<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu VTS 101 rok 2015
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
$rmc=1;
$rmc1=0;

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

//.jpg podklad
$jpg_cesta="../dokumenty/statistika2015/roc_vts101/roc_vts101_v15";
$jpg_popis="tlaèivo Roèný výkaz produkèných odvetví vo vybraných trhových službách Roè VTS 1-01 ".$kli_vrok;

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
if ( $modul == 9200 )
{
$citajvsetkymoduly=1;
$modul=405;
}

//modul 573
//dopyt, zruseny v2015
if ( $modul == 573 )
{
$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 411 OR LEFT(uce,3) = 412 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pdl; $prir=$prir+$polozka->odl; $ubyt=$ubyt+$polozka->omd; $zoscen=$zoscen+$polozka->zdl;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m573r11='$poccen', m573r21='$poccen', m573r151='$zoscen', m573r161='$zoscen', m573r111='$prir', m573r121='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 322 OR LEFT(uce,3) = 473 OR LEFT(uce,3) = 478 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pdl; $prir=$prir+$polozka->odl; $ubyt=$ubyt+$polozka->omd; $zoscen=$zoscen+$polozka->zdl;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m573r13='$poccen', m573r23='$poccen', m573r153='$zoscen', m573r163='$zoscen', m573r113='$prir', m573r123='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 241 OR LEFT(uce,3) = 249 OR LEFT(uce,3) = 273 OR LEFT(uce,3) = 255 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pdl; $prir=$prir+$polozka->odl; $ubyt=$ubyt+$polozka->omd; $zoscen=$zoscen+$polozka->zdl;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m573r15='$poccen', m573r25='$poccen', m573r155='$zoscen', m573r165='$zoscen', m573r115='$prir', m573r125='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 321 OR LEFT(uce,3) = 324 OR LEFT(uce,3) = 325 OR LEFT(uce,3) = 326 ".
" OR LEFT(uce,3) = 361 OR LEFT(uce,3) = 368 OR LEFT(uce,3) = 331 OR LEFT(uce,3) = 333 OR LEFT(uce,3) = 379 OR LEFT(uce,3) = 342 OR LEFT(uce,3) = 343 ".
"  OR LEFT(uce,3) = 366 OR LEFT(uce,3) = 371 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pdl; $prir=$prir+$polozka->odl; $ubyt=$ubyt+$polozka->omd; $zoscen=$zoscen+$polozka->zdl;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m573r17='$poccen', m573r27='$poccen', m573r157='$zoscen', m573r167='$zoscen', m573r117='$prir', m573r127='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 321 OR LEFT(uce,3) = 324 OR LEFT(uce,3) = 379 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pdl; $prir=$prir+$polozka->odl; $ubyt=$ubyt+$polozka->omd; $zoscen=$zoscen+$polozka->zdl;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m573r18='$poccen', m573r28='$poccen', m573r158='$zoscen', m573r168='$zoscen', m573r118='$prir', m573r128='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$strana=10;
}
//koniec modul 573

//modul 572
//dopyt, zruseny v2015
if ( $modul == 572 )
{
$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 061 OR LEFT(uce,3) = 062 OR LEFT(uce,3) = 063 OR LEFT(uce,3) = 069 ".
" OR LEFT(uce,3) = 251 OR LEFT(uce,3) = 096 OR LEFT(uce,3) = 291 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m572r11='$poccen', m572r15='$poccen', m572r21='$poccen', m572r25='$poccen', m572r151='$zoscen', m572r155='$zoscen', m572r161='$zoscen', m572r165='$zoscen',  ".
" m572r111='$prir', m572r115='$prir', m572r121='$ubyt', m572r125='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 065 OR LEFT(uce,3) = 256 OR LEFT(uce,3) = 257 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m572r16='$poccen', m572r26='$poccen', m572r156='$zoscen', m572r166='$zoscen', m572r116='$prir', m572r126='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 066 OR LEFT(uce,3) = 067 OR LEFT(uce,3) = 351 OR LEFT(uce,3) = 355 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m572r18='$poccen', m572r28='$poccen', m572r158='$zoscen', m572r168='$zoscen', m572r118='$prir', m572r128='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 313 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 316 ".
" OR LEFT(uce,3) = 317  OR LEFT(uce,3) = 318  OR LEFT(uce,3) = 319  OR LEFT(uce,3) = 335  OR LEFT(uce,3) = 369 ".
" OR LEFT(uce,3) = 374  OR LEFT(uce,3) = 375  OR LEFT(uce,3) = 376  OR LEFT(uce,3) = 378  OR LEFT(uce,3) = 369 OR LEFT(uce,3) = 314 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m572r110='$poccen', m572r210='$poccen', m572r1510='$zoscen', m572r1610='$zoscen', m572r1110='$prir', m572r1210='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 314 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd;
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m572r0111='$poccen', m572r0211='$poccen', m572r1511='$zoscen', m572r1611='$zoscen', m572r1111='$prir', m572r1211='$ubyt'  ".
" WHERE ico >= 0 ";
$upravene = mysql_query("$uprtxt");


$strana=9;
}
//koniec modul 572

//modul 514
if ( $modul == 514 )
{
$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR  LEFT(uce,3) = 604 OR LEFT(uce,3) = 606  )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce2=substr($polozka->uce,0,2);
if( $uce2 == '60' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m514r1='$ubyt'-'$prir'  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=15; //dopyt, teraz je na 13.strane
}
//koniec modul 514

//modul 516
if ( $modul == 516 )
{
$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 041 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '041' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m516r11='$prir', m516r12='$prir', m516r61='$prir', m516r62='$prir' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 042 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '042' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m516r71='$prir', m516r72='$prir', m516r101='$prir', m516r102='$prir', m516r111='$prir', m516r112='$prir' ".
" WHERE ico >= 0";
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m516r77='$ubyt', m516r107='$ubyt', m516r117='$ubyt'  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$strana=8;
}
//koniec modul 516


//modul 513
if ( $modul == 513 )
{
$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 01 OR LEFT(uce,2) = 07 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce2=substr($polozka->uce,0,2);
if( $uce2 == '01' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce2 == '07' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r11='$poccen' , m513r12='$pocops' , m513r13='$prir' , m513r14='$ubyt' , m513r17='$zoscen' , m513r18='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 012 OR LEFT(uce,3) = 072 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '012' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '072' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r21='$poccen' , m513r22='$pocops' , m513r23='$prir' , m513r24='$ubyt' , m513r27='$zoscen' , m513r28='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 013 OR LEFT(uce,3) = 073 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '013' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '073' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r31='$poccen' , m513r32='$pocops' , m513r33='$prir' , m513r34='$ubyt' , m513r37='$zoscen' , m513r38='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 014 OR LEFT(uce,3) = 074 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '014' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '074' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r41='$poccen' , m513r42='$pocops' , m513r43='$prir' , m513r44='$ubyt' , m513r47='$zoscen' , m513r48='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 015 OR LEFT(uce,3) = 075 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '015' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '075' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r51='$poccen' , m513r52='$pocops' , m513r53='$prir' , m513r54='$ubyt' , m513r57='$zoscen' , m513r58='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 019 OR LEFT(uce,3) = 079 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '019' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '079' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r61='$poccen' , m513r62='$pocops' , m513r63='$prir' , m513r64='$ubyt' , m513r67='$zoscen' , m513r68='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 02 OR LEFT(uce,2) = 08 OR LEFT(uce,2) = 03 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce2=substr($polozka->uce,0,2);
if( $uce2 == '02' OR $uce2 == '03' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce2 == '08' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r71='$poccen' , m513r72='$pocops' , m513r73='$prir' , m513r74='$ubyt' , m513r77='$zoscen' , m513r78='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 021 OR LEFT(uce,3) = 081 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '021' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '081' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r81='$poccen' , m513r82='$pocops' , m513r83='$prir' , m513r84='$ubyt' , m513r87='$zoscen' , m513r88='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 022 OR LEFT(uce,3) = 082 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '022' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '082' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r101='$poccen' , m513r102='$pocops' , m513r103='$prir' , m513r104='$ubyt' , m513r107='$zoscen' , m513r108='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r111='$poccen' , m513r112='$pocops' , m513r113='$prir' , m513r114='$ubyt' , m513r117='$zoscen' , m513r118='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 025 OR LEFT(uce,3) = 085 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '025' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '085' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r151='$poccen' , m513r152='$pocops' , m513r153='$prir' , m513r154='$ubyt' , m513r157='$zoscen' , m513r158='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 026 OR LEFT(uce,3) = 086 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '026' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '086' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r161='$poccen' , m513r162='$pocops' , m513r163='$prir' , m513r164='$ubyt' , m513r167='$zoscen' , m513r168='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 031 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '031' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r171='$poccen' , m513r173='$prir' , m513r174='$ubyt' , m513r177='$zoscen' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 032 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '032' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r201='$poccen' , m513r203='$prir' , m513r204='$ubyt' , m513r207='$zoscen' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 029 OR LEFT(uce,3) = 089 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '029' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
if( $uce3 == '089' ) { $pocops=$pocops+$polozka->pdl; $zosops=$zosops+$polozka->zdl; }
					}
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r221='$poccen' , m513r222='$pocops' , m513r223='$prir' , m513r224='$ubyt' , m513r227='$zoscen' , m513r228='$zosops' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$poccen=0; $pocops=0; $prir=0; $ubyt=0; $zoscen=0; $zosops=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 551 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) 	{
$polozka=mysql_fetch_object($sql);
$uce3=substr($polozka->uce,0,3);
if( $uce3 == '551' ) { $poccen=$poccen+$polozka->pmd; $prir=$prir+$polozka->omd; $ubyt=$ubyt+$polozka->odl; $zoscen=$zoscen+$polozka->zmd; }
					}
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r79='$prir' , m513r109='$prir' , m513r119='$prir' ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=7;
}
//koniec modul 513

//modul 586
if ( $modul == 586 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas$kli_uzid WHERE prx = 1 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i))
            { $polozka=mysql_fetch_object($sql);
$rn12=$rn12+$polozka->rn01;
$rn22=$rn22+$polozka->r31;
$rn132=$rn132+$polozka->r67;
$rn142=$rn142+$polozka->r68;
$rn192=$rn192+$polozka->r118;
            }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctpocsuvaha_stt WHERE dok >= 0 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i))
            { $polozka=mysql_fetch_object($sql);
$rm11=$rm11+$polozka->rm01;
$rm21=$rm21+$polozka->rm31;
$rm131=$rm131+$polozka->rm67;
$rm141=$rm141+$polozka->rm68;
$rm191=$rm191+$polozka->r118;
            }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m586r12='$rn12', m586r11='$rm11', ".
" m586r22='$rn22', m586r21='$rm21', ".
" m586r132='$rn132', m586r131='$rm131', ".
" m586r142='$rn142', m586r141='$rm141', ".
" m586r152='$rn152', m586r151='$rm151', ".
" m586r192='$rn192', m586r191='$rm191'  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$strana=5;
}
//koniec modul 586

//modul 558
if ( $modul == 558 )
{
$r01=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 59 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r03=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 662 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }


$r05=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 552 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r05=$r05+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r07=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 644 OR LEFT(uce,3) = 645 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r08=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 544 OR LEFT(uce,3) = 545 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r08=$r08+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r15=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 543 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r15=$r15+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m558r1='$r01', m558r3='$r03', m558r5='$r05', m558r7='$r07', m558r8='$r08', m558r15='$r15', ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


$strana=4;
}
//koniec modul 558

//modul 405
if ( $modul == 405 )
{
$r01=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,1) = 6 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r02=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( ( LEFT(uce,3) = 601 ) OR ( LEFT(uce,3) = 602 ) OR ( LEFT(uce,3) = 604 ) OR ( LEFT(uce,3) = 606 ) OR ( LEFT(uce,3) = 607 ) OR ".
" ( LEFT(uce,3) = 504 ) OR ( LEFT(uce,3) = 507 ) OR ".
" ( LEFT(uce,2) = 61 ) OR ( LEFT(uce,2) = 62 ) )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }


$r03=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,1) = 5 AND LEFT(uce,2) != 59 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r07=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ".
" ( ( LEFT(uce,3) = 601 ) OR ( LEFT(uce,3) = 602 ) OR ( LEFT(uce,3) = 604 ) OR ( LEFT(uce,3) = 606 ) OR ( LEFT(uce,3) = 607 ) OR ".
" ( LEFT(uce,3) = 501 ) OR ( LEFT(uce,3) = 502 ) OR ( LEFT(uce,3) = 503 ) OR ( LEFT(uce,3) = 504 ) OR ( LEFT(uce,3) = 507 ) OR ".
" ( LEFT(uce,2) = 51 ) OR ( LEFT(uce,2) = 61 ) OR ( LEFT(uce,2) = 62 ) )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m405r11='$r01', m405r21='$r02', m405r31='$r03', m405r71='$r07', ".
" psys=0 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

$strana=4;
}
//koniec modul 405


//vytvor tabulku v databaze
$sql = "SELECT r101x FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_vts101';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(100) not null,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx8        DECIMAL(10,0) DEFAULT 0,
   r101x        DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_vts101'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_vts101 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");
}

//1.strana
$sql = "SELECT mod100043nie FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def1<br />"; 
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD odoslane DATE NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100041ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100041nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100042ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100042nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100043ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100043nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//2.strana
$sql = "SELECT m1101r4b FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def2<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1100r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100036kal DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100036hos DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100037 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m100214r01 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m100214r02 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100069ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod100069nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r2 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r3 DECIMAL(10,1) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r4a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r4b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//3.strana
$sql = "SELECT m1005r1b FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def3<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r5a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r5b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r6a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r6b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r7a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r7b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r8a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1101r8b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod2r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD mod2r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m398r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1005r1a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m1005r1b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//4.strana
$sql = "SELECT m558r99 FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def4<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m405r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m406r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m558r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//5.strana
$sql = "SELECT m100044nie FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def5<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m586r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m100062ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m100062nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r3k VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r4k VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m585r5k VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m100044ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m100044nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//6.strana
$sql = "SELECT m581r99 FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def6<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r10 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r12 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r20 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r22 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r30 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r32 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r40 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r42 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r50 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r52 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r60 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r62 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r70 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r72 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r80 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r82 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r90 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r92 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m571r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r4 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r5 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r8 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r9 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m581r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//7.strana
$sql = "SELECT m513r999 FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def7<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r19 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r29 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r39 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r49 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r59 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r69 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r79 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r89 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r109 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r118 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r119 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r128 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r129 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r138 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r139 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r148 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r149 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r158 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r159 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r168 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r169 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r228 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r229 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r998 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m513r999 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//8.strana
$sql = "SELECT m516r997 FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def8<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m516r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//9.strana
$sql = "SELECT m572r0211 FROM F$kli_vxcf"."_statistika_vts101 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def9<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r19 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r29 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r39 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r49 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r411 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r59 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r511 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r69 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r610 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r611 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r79 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r710 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r711 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r89 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r810 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r811 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r910 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r911 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r109 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1010 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1011 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r118 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r119 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r128 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r129 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r138 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r139 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r148 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r149 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1411 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r158 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r159 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1511 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r168 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r169 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1610 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1611 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r178 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r179 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1710 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1711 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r188 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r189 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1810 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1811 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r198 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r199 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1910 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r1911 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2010 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2011 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r218 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r219 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r228 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r229 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r238 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r239 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r248 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r249 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r2411 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r998 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r999 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r9910 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r9911 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r0111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101 ADD m572r0211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//10.strana
$sql = "SELECT r101x FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_vts101s2';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   psys         INT DEFAULT 0,
   cinnost      VARCHAR(100) not null,
   konx         DECIMAL(10,0) DEFAULT 0,
   konx8        DECIMAL(10,0) DEFAULT 0,
   r101x        DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0) DEFAULT 0
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_vts101s2'.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_vts101s2 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");
}

$sql = "SELECT m573r998 FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def10<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r118 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r128 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r138 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r148 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r158 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r168 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r178 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r188 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r198 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r218 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r228 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r237 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r238 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r247 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r248 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m573r998 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}

//11.strana
$sql = "SELECT m588r338 FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def11<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r201 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r202 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r203 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r204 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r205 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r206 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r207 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r208 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r209 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r210 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r211 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r212 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r213 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r214 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r215 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r216 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r217 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r218 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r219 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r220 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r221 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r222 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r223 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r224 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r225 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r226 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r227 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r228 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r229 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r230 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r231 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r232 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r233 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r234 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r235 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r236 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r237 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r238 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r239 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r240 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r241 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r242 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r243 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r244 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r245 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r246 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r247 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r248 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r249 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r250 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r251 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r301 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r302 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r303 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r304 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r305 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r306 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r307 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r308 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r309 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r310 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r311 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r312 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r313 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r314 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r315 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r316 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r317 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r318 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r319 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r320 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r321 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r322 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r323 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r324 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r325 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r326 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r327 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r328 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r329 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r330 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r331 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r332 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r333 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r334 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r335 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r336 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r337 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r338 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//12.strana
$sql = "SELECT m1527r1b FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def12<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r339 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r340 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r341 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r342 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r343 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r344 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r345 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r346 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r347 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r348 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r349 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r350 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m588r351 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r1 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r2 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r3 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r4 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r5 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r6 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r7 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r8 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r9 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r10 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r11 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r12 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m19r99 DECIMAL(10,2) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m1527r1a DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m1527r1b DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//13.strana
$sql = "SELECT m527r1710 FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def13<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r19 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r29 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r34 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r39 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r44 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r49 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r54 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r59 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r64 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r69 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r610 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r71 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r74 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r79 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r710 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r81 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r82 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r84 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r89 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r810 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r91 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r92 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r94 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r910 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r109 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1010 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r115 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r116 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r117 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r118 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r119 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r121 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r122 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r123 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r124 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r125 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r126 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r127 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r128 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r129 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r131 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r132 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r133 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r134 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r135 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r136 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r137 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r138 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r139 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r141 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r142 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r143 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r144 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r145 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r146 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r147 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r148 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r149 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r151 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r152 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r153 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r154 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r155 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r156 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r157 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r158 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r159 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r161 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r162 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r163 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r164 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r165 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r166 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r167 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r168 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r169 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1610 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r171 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r172 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r173 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r174 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r175 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r176 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r177 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r178 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r179 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1710 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//14.strana
$sql = "SELECT m527r9910 FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def14<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r181 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r182 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r183 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r184 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r185 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r186 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r187 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r188 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1810 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r191 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r192 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r193 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r194 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r195 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r196 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r197 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r198 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r1910 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r2010 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r216 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r217 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r218 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r2110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r221 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r222 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r223 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r224 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r225 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r226 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r227 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r228 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r2210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r231 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r232 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r233 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r234 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r235 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r236 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r237 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r238 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r2310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r241 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r242 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r243 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r244 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r245 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r246 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r247 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r248 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r2410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r994 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r995 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r996 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r997 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r998 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r999 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m527r9910 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//15.strana
$sql = "SELECT m514r99 FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "def15<br />";
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r31 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r32 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r41 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r42 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r51 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r52 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r61 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r62 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r72 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r991 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r992 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m474r993 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m514r1 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m514r2 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m514r3 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_vts101s2 ADD m514r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//koniec vytvorenia definicie


//nacitaj mzdy
if ( $citajvsetkymoduly == 1 ) { $copern=200; }
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
   ico          DECIMAL(8,0)
);
statprac;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statprac'.$sqlt;
$vytvor = mysql_query("$vsql");

//pocet zamestnancov
$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,rdc,0,pom,0,1, ".
"0,0,0,0,$fir_fico".
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

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 999,oc,ume,rodc,zena,pom,dhpom,SUM(pocet), ".
"dm,dni,hod,kc,$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 0".
" GROUP BY ume,dhpom";
$dsql = mysql_query("$dsqlt");


$r01=0; $r01m01=0; $r01m02=0; $r01m03=0; $r01m04=0; $r01m05=0; $r01m06=0; $r01m07=0; $r01m08=0; $r01m09=0; $r01m10=0; $r01m11=0; $r01m12=0; $r03=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 1.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m01=$r01m01+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 1.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m01=$r01m01+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 2.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m02=$r01m03+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 3.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m03=$r01m03+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 4.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m04=$r01m04+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 5.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m05=$r01m05+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 6.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m06=$r01m06+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 7.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m07=$r01m07+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 8.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m08=$r01m08+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 9.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m09=$r01m09+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 10.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m10=$r01m10+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 11.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m11=$r01m11+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 999 AND ume = 12.".$kli_vrok." AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01m12=$r01m12+$polozka->pocet; $r02=$r02+$polozka->pocet; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 0 AND ume = $vyb_umk AND zena > 12 AND dhpom = 0";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+1; }
$i=$i+1;                   }

$r01=($r01m01+$r01m02+$r01m03+$r01m04+$r01m05+$r01m06+$r01m07+$r01m08+$r01m09+$r01m10+$r01m11+$r01m12)/12;


//odpracovane hodiny a eur 
$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,vpom,0,1, ".
"dm,dni,hod,kc,$fir_fico".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 0,oc,ume,'',0,spom,0,1, ".
"9999,0,0,(ofir_zp+ofir_np+ofir_sp+ofir_ip+ofir_pn+ofir_up+ofir_gf+ofir_rf),$fir_fico".
" FROM F$kli_vxcf"."_mzdzalsum".
" WHERE ume >= $vyb_ump AND ume <= $vyb_umk".
"";
$dsql = mysql_query("$dsqlt");

$uprtxt = "UPDATE F$kli_vxcf"."_statprac,F$kli_vxcf"."_mzdpomer SET ".
" dhpom=pm_doh ".
" WHERE F$kli_vxcf"."_statprac.pom = F$kli_vxcf"."_mzdpomer.pm"; 
$upravene = mysql_query("$uprtxt");  

$dsqlt = "INSERT INTO F$kli_vxcf"."_statprac "." SELECT".
" 555,oc,ume,rodc,zena,pom,dhpom,pocet, ".
"dm,SUM(dni),SUM(hod),SUM(kc),$fir_fico".
" FROM F$kli_vxcf"."_statprac".
" WHERE dhpom = 0".
" GROUP BY ume,dhpom,dm";
$dsql = mysql_query("$dsqlt");

$r04=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( ( dm > 100 AND dm < 111 ) OR dm = 132 OR dm = 209 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+$polozka->hod; }
$i=$i+1;                   }

$r06=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_statprac WHERE drh = 555 AND dhpom = 0 AND ( dm > 100 AND dm < 600 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->kc; }
$i=$i+1;                   }


//zapis do statistiky
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m304r01='$r01', m304r02='$r02', m304r03='$r03', m304r04='$r04', m304r06='$r06' ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
//echo $uprtxt;
//exit; 

$copern=102;
$strana=10;
if( $citajvsetkymoduly == 1 ) { $strana=3; }
}
//koniec copern=200 nacitaj statistiku z miezd

//zapis upravene udaje
if ( $copern == 103 )
     {
//1.strana
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);
$cinnost = strip_tags($_REQUEST['cinnost']);
//2.strana
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);
$mod100041ano = strip_tags($_REQUEST['mod100041ano']);
$mod100041nie = strip_tags($_REQUEST['mod100041nie']);
$mod100042ano = strip_tags($_REQUEST['mod100042ano']);
$mod100042nie = strip_tags($_REQUEST['mod100042nie']);
$mod100043ano = strip_tags($_REQUEST['mod100043ano']);
$mod100043nie = strip_tags($_REQUEST['mod100043nie']);
$m1100r4 = strip_tags($_REQUEST['m1100r4']);
$m1100r5 = strip_tags($_REQUEST['m1100r5']);
$m1100r6 = strip_tags($_REQUEST['m1100r6']);
$m1100r7 = strip_tags($_REQUEST['m1100r7']);
$m1100r8 = strip_tags($_REQUEST['m1100r8']);
$m1100r9 = strip_tags($_REQUEST['m1100r9']);
$m1100r10 = strip_tags($_REQUEST['m1100r10']);
$m1100r11 = strip_tags($_REQUEST['m1100r11']);
$m1100r12 = strip_tags($_REQUEST['m1100r12']);
$m1100r13 = strip_tags($_REQUEST['m1100r13']);
$mod100036kal = strip_tags($_REQUEST['mod100036kal']);
$mod100036hos = strip_tags($_REQUEST['mod100036hos']);
//3.strana
$mod100037 = strip_tags($_REQUEST['mod100037']);
$m100214r01 = strip_tags($_REQUEST['m100214r01']);
$m100214r02 = strip_tags($_REQUEST['m100214r02']);
$mod100069ano = strip_tags($_REQUEST['mod100069ano']);
$mod100069nie = strip_tags($_REQUEST['mod100069nie']);
$m1101r2 = strip_tags($_REQUEST['m1101r2']);
$m1101r3 = strip_tags($_REQUEST['m1101r3']);
$m1101r4a = strip_tags($_REQUEST['m1101r4a']);
$m1101r4b = strip_tags($_REQUEST['m1101r4b']);
$m1101r5a = strip_tags($_REQUEST['m1101r5a']);
$m1101r5b = strip_tags($_REQUEST['m1101r5b']);
$m1101r6a = strip_tags($_REQUEST['m1101r6a']);
$m1101r6b = strip_tags($_REQUEST['m1101r6b']);
$m1101r7a = strip_tags($_REQUEST['m1101r7a']);
$m1101r7b = strip_tags($_REQUEST['m1101r7b']);
//$m1101r8a = strip_tags($_REQUEST['m1101r8a']);
//$m1101r8b = strip_tags($_REQUEST['m1101r8b']);

//4.strana
$m398r11 = strip_tags($_REQUEST['m398r11']);
$m398r12 = strip_tags($_REQUEST['m398r12']);
$m398r13 = strip_tags($_REQUEST['m398r13']);
$m398r14 = strip_tags($_REQUEST['m398r14']);
$m398r21 = strip_tags($_REQUEST['m398r21']);
$m398r22 = strip_tags($_REQUEST['m398r22']);
$m398r23 = strip_tags($_REQUEST['m398r23']);
$m398r24 = strip_tags($_REQUEST['m398r24']);
$m398r991 = strip_tags($_REQUEST['m398r991']);
$m398r992 = strip_tags($_REQUEST['m398r992']);
$m398r993 = strip_tags($_REQUEST['m398r993']);
$m398r994 = strip_tags($_REQUEST['m398r994']);
$m1005r1a = strip_tags($_REQUEST['m1005r1a']);
$m1005r1b = strip_tags($_REQUEST['m1005r1b']);
$m405r11 = strip_tags($_REQUEST['m405r11']);
$m405r12 = strip_tags($_REQUEST['m405r12']);
$m405r21 = strip_tags($_REQUEST['m405r21']);
$m405r31 = strip_tags($_REQUEST['m405r31']);
$m405r32 = strip_tags($_REQUEST['m405r32']);
$m405r41 = strip_tags($_REQUEST['m405r41']);
$m405r51 = strip_tags($_REQUEST['m405r51']);
$m405r61 = strip_tags($_REQUEST['m405r61']);
$m405r71 = strip_tags($_REQUEST['m405r71']);
$m405r81 = strip_tags($_REQUEST['m405r81']);
$m405r82 = strip_tags($_REQUEST['m405r82']);
$m405r991 = strip_tags($_REQUEST['m405r991']);
$m405r992 = strip_tags($_REQUEST['m405r992']);
$m406r1 = strip_tags($_REQUEST['m406r1']);
$m406r2 = strip_tags($_REQUEST['m406r2']);
$m406r3 = strip_tags($_REQUEST['m406r3']);
$m406r4 = strip_tags($_REQUEST['m406r4']);
$m406r5 = strip_tags($_REQUEST['m406r5']);
$m406r6 = strip_tags($_REQUEST['m406r6']);
$m406r7 = strip_tags($_REQUEST['m406r7']);
$m406r99 = strip_tags($_REQUEST['m406r99']);
//5.strana
$m558r1 = strip_tags($_REQUEST['m558r1']);
$m558r2 = strip_tags($_REQUEST['m558r2']);
$m558r3 = strip_tags($_REQUEST['m558r3']);
$m558r4 = strip_tags($_REQUEST['m558r4']);
$m558r5 = strip_tags($_REQUEST['m558r5']);
$m558r6 = strip_tags($_REQUEST['m558r6']);
$m558r7 = strip_tags($_REQUEST['m558r7']);
$m558r8 = strip_tags($_REQUEST['m558r8']);
$m558r9 = strip_tags($_REQUEST['m558r9']);
$m558r10 = strip_tags($_REQUEST['m558r10']);
$m558r11 = strip_tags($_REQUEST['m558r11']);
$m558r12 = strip_tags($_REQUEST['m558r12']);
$m558r13 = strip_tags($_REQUEST['m558r13']);
$m558r14 = strip_tags($_REQUEST['m558r14']);
$m558r15 = strip_tags($_REQUEST['m558r15']);
$m558r16 = strip_tags($_REQUEST['m558r16']);
$m558r17 = strip_tags($_REQUEST['m558r17']);
$m558r18 = strip_tags($_REQUEST['m558r18']);
$m558r99 = strip_tags($_REQUEST['m558r99']);
$m585r01 = strip_tags($_REQUEST['m585r01']);
$m585r02 = strip_tags($_REQUEST['m585r02']);
$m585r03 = strip_tags($_REQUEST['m585r03']);
$m585r04 = strip_tags($_REQUEST['m585r04']);
$m585r05 = strip_tags($_REQUEST['m585r05']);
$m585r3k = strip_tags($_REQUEST['m585r3k']);
$m585r4k = strip_tags($_REQUEST['m585r4k']);
$m585r5k = strip_tags($_REQUEST['m585r5k']);
$m100044ano = strip_tags($_REQUEST['m100044ano']);
$m100044nie = strip_tags($_REQUEST['m100044nie']);
//6.strana
$m571r10 = strip_tags($_REQUEST['m571r10']);
$m571r12 = strip_tags($_REQUEST['m571r12']);
$m571r13 = strip_tags($_REQUEST['m571r13']);
$m571r15 = strip_tags($_REQUEST['m571r15']);
$m571r16 = strip_tags($_REQUEST['m571r16']);
$m571r17 = strip_tags($_REQUEST['m571r17']);
$m571r18 = strip_tags($_REQUEST['m571r18']);
$m571r20 = strip_tags($_REQUEST['m571r20']);
$m571r22 = strip_tags($_REQUEST['m571r22']);
$m571r23 = strip_tags($_REQUEST['m571r23']);
$m571r25 = strip_tags($_REQUEST['m571r25']);
$m571r26 = strip_tags($_REQUEST['m571r26']);
$m571r27 = strip_tags($_REQUEST['m571r27']);
$m571r28 = strip_tags($_REQUEST['m571r28']);
$m571r30 = strip_tags($_REQUEST['m571r30']);
$m571r32 = strip_tags($_REQUEST['m571r32']);
$m571r33 = strip_tags($_REQUEST['m571r33']);
$m571r35 = strip_tags($_REQUEST['m571r35']);
$m571r36 = strip_tags($_REQUEST['m571r36']);
$m571r37 = strip_tags($_REQUEST['m571r37']);
$m571r38 = strip_tags($_REQUEST['m571r38']);
$m571r40 = strip_tags($_REQUEST['m571r40']);
$m571r42 = strip_tags($_REQUEST['m571r42']);
$m571r43 = strip_tags($_REQUEST['m571r43']);
$m571r45 = strip_tags($_REQUEST['m571r45']);
$m571r46 = strip_tags($_REQUEST['m571r46']);
$m571r47 = strip_tags($_REQUEST['m571r47']);
$m571r48 = strip_tags($_REQUEST['m571r48']);
$m571r50 = strip_tags($_REQUEST['m571r50']);
$m571r52 = strip_tags($_REQUEST['m571r52']);
$m571r53 = strip_tags($_REQUEST['m571r53']);
$m571r55 = strip_tags($_REQUEST['m571r55']);
$m571r56 = strip_tags($_REQUEST['m571r56']);
$m571r57 = strip_tags($_REQUEST['m571r57']);
$m571r58 = strip_tags($_REQUEST['m571r58']);
$m571r60 = strip_tags($_REQUEST['m571r60']);
$m571r62 = strip_tags($_REQUEST['m571r62']);
$m571r63 = strip_tags($_REQUEST['m571r63']);
$m571r65 = strip_tags($_REQUEST['m571r65']);
$m571r66 = strip_tags($_REQUEST['m571r66']);
$m571r67 = strip_tags($_REQUEST['m571r67']);
$m571r68 = strip_tags($_REQUEST['m571r68']);
$m571r70 = strip_tags($_REQUEST['m571r70']);
$m571r72 = strip_tags($_REQUEST['m571r72']);
$m571r73 = strip_tags($_REQUEST['m571r73']);
$m571r75 = strip_tags($_REQUEST['m571r75']);
$m571r76 = strip_tags($_REQUEST['m571r76']);
$m571r77 = strip_tags($_REQUEST['m571r77']);
$m571r78 = strip_tags($_REQUEST['m571r78']);
$m571r80 = strip_tags($_REQUEST['m571r80']);
$m571r82 = strip_tags($_REQUEST['m571r82']);
$m571r83 = strip_tags($_REQUEST['m571r83']);
$m571r85 = strip_tags($_REQUEST['m571r85']);
$m571r86 = strip_tags($_REQUEST['m571r86']);
$m571r87 = strip_tags($_REQUEST['m571r87']);
$m571r88 = strip_tags($_REQUEST['m571r88']);
$m571r90 = strip_tags($_REQUEST['m571r90']);
$m571r92 = strip_tags($_REQUEST['m571r92']);
$m571r93 = strip_tags($_REQUEST['m571r93']);
$m571r95 = strip_tags($_REQUEST['m571r95']);
$m571r96 = strip_tags($_REQUEST['m571r96']);
$m571r97 = strip_tags($_REQUEST['m571r97']);
$m571r98 = strip_tags($_REQUEST['m571r98']);
//$m100062ano = strip_tags($_REQUEST['m100062ano']);
//$m100062nie = strip_tags($_REQUEST['m100062nie']);
$m581r1 = strip_tags($_REQUEST['m581r1']);
$m581r2 = strip_tags($_REQUEST['m581r2']);
$m581r3 = strip_tags($_REQUEST['m581r3']);
$m581r4 = strip_tags($_REQUEST['m581r4']);
$m581r5 = strip_tags($_REQUEST['m581r5']);
$m581r6 = strip_tags($_REQUEST['m581r6']);
$m581r7 = strip_tags($_REQUEST['m581r7']);
$m581r8 = strip_tags($_REQUEST['m581r8']);
//$m581r9 = strip_tags($_REQUEST['m581r9']);
//$m581r10 = strip_tags($_REQUEST['m581r10']);
//$m581r11 = strip_tags($_REQUEST['m581r11']);
$m581r12 = strip_tags($_REQUEST['m581r12']);
$m581r99 = strip_tags($_REQUEST['m581r99']);
//7.strana
$m513r11 = strip_tags($_REQUEST['m513r11']);
$m513r12 = strip_tags($_REQUEST['m513r12']);
$m513r13 = strip_tags($_REQUEST['m513r13']);
$m513r14 = strip_tags($_REQUEST['m513r14']);
$m513r15 = strip_tags($_REQUEST['m513r15']);
$m513r16 = strip_tags($_REQUEST['m513r16']);
$m513r17 = strip_tags($_REQUEST['m513r17']);
$m513r18 = strip_tags($_REQUEST['m513r18']);
$m513r19 = strip_tags($_REQUEST['m513r19']);
$m513r21 = strip_tags($_REQUEST['m513r21']);
$m513r22 = strip_tags($_REQUEST['m513r22']);
$m513r23 = strip_tags($_REQUEST['m513r23']);
$m513r24 = strip_tags($_REQUEST['m513r24']);
$m513r25 = strip_tags($_REQUEST['m513r25']);
$m513r26 = strip_tags($_REQUEST['m513r26']);
$m513r27 = strip_tags($_REQUEST['m513r27']);
$m513r28 = strip_tags($_REQUEST['m513r28']);
$m513r29 = strip_tags($_REQUEST['m513r29']);
$m513r31 = strip_tags($_REQUEST['m513r31']);
$m513r32 = strip_tags($_REQUEST['m513r32']);
$m513r33 = strip_tags($_REQUEST['m513r33']);
$m513r34 = strip_tags($_REQUEST['m513r34']);
$m513r35 = strip_tags($_REQUEST['m513r35']);
$m513r36 = strip_tags($_REQUEST['m513r36']);
$m513r37 = strip_tags($_REQUEST['m513r37']);
$m513r38 = strip_tags($_REQUEST['m513r38']);
$m513r39 = strip_tags($_REQUEST['m513r39']);
$m513r41 = strip_tags($_REQUEST['m513r41']);
$m513r42 = strip_tags($_REQUEST['m513r42']);
$m513r43 = strip_tags($_REQUEST['m513r43']);
$m513r44 = strip_tags($_REQUEST['m513r44']);
$m513r45 = strip_tags($_REQUEST['m513r45']);
$m513r46 = strip_tags($_REQUEST['m513r46']);
$m513r47 = strip_tags($_REQUEST['m513r47']);
$m513r48 = strip_tags($_REQUEST['m513r48']);
$m513r49 = strip_tags($_REQUEST['m513r49']);
$m513r51 = strip_tags($_REQUEST['m513r51']);
$m513r52 = strip_tags($_REQUEST['m513r52']);
$m513r53 = strip_tags($_REQUEST['m513r53']);
$m513r54 = strip_tags($_REQUEST['m513r54']);
$m513r55 = strip_tags($_REQUEST['m513r55']);
$m513r56 = strip_tags($_REQUEST['m513r56']);
$m513r57 = strip_tags($_REQUEST['m513r57']);
$m513r58 = strip_tags($_REQUEST['m513r58']);
$m513r59 = strip_tags($_REQUEST['m513r59']);
$m513r61 = strip_tags($_REQUEST['m513r61']);
$m513r62 = strip_tags($_REQUEST['m513r62']);
$m513r63 = strip_tags($_REQUEST['m513r63']);
$m513r64 = strip_tags($_REQUEST['m513r64']);
$m513r65 = strip_tags($_REQUEST['m513r65']);
$m513r66 = strip_tags($_REQUEST['m513r66']);
$m513r67 = strip_tags($_REQUEST['m513r67']);
$m513r68 = strip_tags($_REQUEST['m513r68']);
$m513r69 = strip_tags($_REQUEST['m513r69']);
$m513r71 = strip_tags($_REQUEST['m513r71']);
$m513r72 = strip_tags($_REQUEST['m513r72']);
$m513r73 = strip_tags($_REQUEST['m513r73']);
$m513r74 = strip_tags($_REQUEST['m513r74']);
$m513r75 = strip_tags($_REQUEST['m513r75']);
$m513r76 = strip_tags($_REQUEST['m513r76']);
$m513r77 = strip_tags($_REQUEST['m513r77']);
$m513r78 = strip_tags($_REQUEST['m513r78']);
$m513r79 = strip_tags($_REQUEST['m513r79']);
$m513r81 = strip_tags($_REQUEST['m513r81']);
$m513r82 = strip_tags($_REQUEST['m513r82']);
$m513r83 = strip_tags($_REQUEST['m513r83']);
$m513r84 = strip_tags($_REQUEST['m513r84']);
$m513r85 = strip_tags($_REQUEST['m513r85']);
$m513r86 = strip_tags($_REQUEST['m513r86']);
$m513r87 = strip_tags($_REQUEST['m513r87']);
$m513r88 = strip_tags($_REQUEST['m513r88']);
$m513r89 = strip_tags($_REQUEST['m513r89']);
$m513r91 = strip_tags($_REQUEST['m513r91']);
$m513r92 = strip_tags($_REQUEST['m513r92']);
$m513r93 = strip_tags($_REQUEST['m513r93']);
$m513r94 = strip_tags($_REQUEST['m513r94']);
$m513r95 = strip_tags($_REQUEST['m513r95']);
$m513r96 = strip_tags($_REQUEST['m513r96']);
$m513r97 = strip_tags($_REQUEST['m513r97']);
$m513r98 = strip_tags($_REQUEST['m513r98']);
$m513r99 = strip_tags($_REQUEST['m513r99']);
$m513r101 = strip_tags($_REQUEST['m513r101']);
$m513r102 = strip_tags($_REQUEST['m513r102']);
$m513r103 = strip_tags($_REQUEST['m513r103']);
$m513r104 = strip_tags($_REQUEST['m513r104']);
$m513r105 = strip_tags($_REQUEST['m513r105']);
$m513r106 = strip_tags($_REQUEST['m513r106']);
$m513r107 = strip_tags($_REQUEST['m513r107']);
$m513r108 = strip_tags($_REQUEST['m513r108']);
$m513r109 = strip_tags($_REQUEST['m513r109']);
$m513r111 = strip_tags($_REQUEST['m513r111']);
$m513r112 = strip_tags($_REQUEST['m513r112']);
$m513r113 = strip_tags($_REQUEST['m513r113']);
$m513r114 = strip_tags($_REQUEST['m513r114']);
$m513r115 = strip_tags($_REQUEST['m513r115']);
$m513r116 = strip_tags($_REQUEST['m513r116']);
$m513r117 = strip_tags($_REQUEST['m513r117']);
$m513r118 = strip_tags($_REQUEST['m513r118']);
$m513r119 = strip_tags($_REQUEST['m513r119']);
$m513r121 = strip_tags($_REQUEST['m513r121']);
$m513r122 = strip_tags($_REQUEST['m513r122']);
$m513r123 = strip_tags($_REQUEST['m513r123']);
$m513r124 = strip_tags($_REQUEST['m513r124']);
$m513r125 = strip_tags($_REQUEST['m513r125']);
$m513r126 = strip_tags($_REQUEST['m513r126']);
$m513r127 = strip_tags($_REQUEST['m513r127']);
$m513r128 = strip_tags($_REQUEST['m513r128']);
$m513r129 = strip_tags($_REQUEST['m513r129']);
$m513r131 = strip_tags($_REQUEST['m513r131']);
$m513r132 = strip_tags($_REQUEST['m513r132']);
$m513r133 = strip_tags($_REQUEST['m513r133']);
$m513r134 = strip_tags($_REQUEST['m513r134']);
$m513r135 = strip_tags($_REQUEST['m513r135']);
$m513r136 = strip_tags($_REQUEST['m513r136']);
$m513r137 = strip_tags($_REQUEST['m513r137']);
$m513r138 = strip_tags($_REQUEST['m513r138']);
$m513r139 = strip_tags($_REQUEST['m513r139']);
$m513r141 = strip_tags($_REQUEST['m513r141']);
$m513r142 = strip_tags($_REQUEST['m513r142']);
$m513r143 = strip_tags($_REQUEST['m513r143']);
$m513r144 = strip_tags($_REQUEST['m513r144']);
$m513r145 = strip_tags($_REQUEST['m513r145']);
$m513r146 = strip_tags($_REQUEST['m513r146']);
$m513r147 = strip_tags($_REQUEST['m513r147']);
$m513r148 = strip_tags($_REQUEST['m513r148']);
$m513r149 = strip_tags($_REQUEST['m513r149']);
$m513r151 = strip_tags($_REQUEST['m513r151']);
$m513r152 = strip_tags($_REQUEST['m513r152']);
$m513r153 = strip_tags($_REQUEST['m513r153']);
$m513r154 = strip_tags($_REQUEST['m513r154']);
$m513r155 = strip_tags($_REQUEST['m513r155']);
$m513r156 = strip_tags($_REQUEST['m513r156']);
$m513r157 = strip_tags($_REQUEST['m513r157']);
$m513r158 = strip_tags($_REQUEST['m513r158']);
$m513r159 = strip_tags($_REQUEST['m513r159']);
$m513r161 = strip_tags($_REQUEST['m513r161']);
$m513r162 = strip_tags($_REQUEST['m513r162']);
$m513r163 = strip_tags($_REQUEST['m513r163']);
$m513r164 = strip_tags($_REQUEST['m513r164']);
$m513r165 = strip_tags($_REQUEST['m513r165']);
$m513r166 = strip_tags($_REQUEST['m513r166']);
$m513r167 = strip_tags($_REQUEST['m513r167']);
$m513r168 = strip_tags($_REQUEST['m513r168']);
$m513r169 = strip_tags($_REQUEST['m513r169']);
$m513r171 = strip_tags($_REQUEST['m513r171']);
$m513r173 = strip_tags($_REQUEST['m513r173']);
$m513r174 = strip_tags($_REQUEST['m513r174']);
$m513r175 = strip_tags($_REQUEST['m513r175']);
$m513r176 = strip_tags($_REQUEST['m513r176']);
$m513r177 = strip_tags($_REQUEST['m513r177']);
$m513r181 = strip_tags($_REQUEST['m513r181']);
$m513r183 = strip_tags($_REQUEST['m513r183']);
$m513r184 = strip_tags($_REQUEST['m513r184']);
$m513r185 = strip_tags($_REQUEST['m513r185']);
$m513r186 = strip_tags($_REQUEST['m513r186']);
$m513r187 = strip_tags($_REQUEST['m513r187']);
$m513r191 = strip_tags($_REQUEST['m513r191']);
$m513r193 = strip_tags($_REQUEST['m513r193']);
$m513r194 = strip_tags($_REQUEST['m513r194']);
$m513r195 = strip_tags($_REQUEST['m513r195']);
$m513r196 = strip_tags($_REQUEST['m513r196']);
$m513r197 = strip_tags($_REQUEST['m513r197']);
$m513r201 = strip_tags($_REQUEST['m513r201']);
$m513r203 = strip_tags($_REQUEST['m513r203']);
$m513r204 = strip_tags($_REQUEST['m513r204']);
$m513r205 = strip_tags($_REQUEST['m513r205']);
$m513r206 = strip_tags($_REQUEST['m513r206']);
$m513r207 = strip_tags($_REQUEST['m513r207']);
$m513r211 = strip_tags($_REQUEST['m513r211']);
$m513r213 = strip_tags($_REQUEST['m513r213']);
$m513r214 = strip_tags($_REQUEST['m513r214']);
$m513r215 = strip_tags($_REQUEST['m513r215']);
$m513r216 = strip_tags($_REQUEST['m513r216']);
$m513r217 = strip_tags($_REQUEST['m513r217']);
$m513r221 = strip_tags($_REQUEST['m513r221']);
$m513r222 = strip_tags($_REQUEST['m513r222']);
$m513r223 = strip_tags($_REQUEST['m513r223']);
$m513r224 = strip_tags($_REQUEST['m513r224']);
$m513r225 = strip_tags($_REQUEST['m513r225']);
$m513r226 = strip_tags($_REQUEST['m513r226']);
$m513r227 = strip_tags($_REQUEST['m513r227']);
$m513r228 = strip_tags($_REQUEST['m513r228']);
$m513r229 = strip_tags($_REQUEST['m513r229']);
$m513r991 = strip_tags($_REQUEST['m513r991']);
$m513r992 = strip_tags($_REQUEST['m513r992']);
$m513r993 = strip_tags($_REQUEST['m513r993']);
$m513r994 = strip_tags($_REQUEST['m513r994']);
$m513r995 = strip_tags($_REQUEST['m513r995']);
$m513r996 = strip_tags($_REQUEST['m513r996']);
$m513r997 = strip_tags($_REQUEST['m513r997']);
$m513r998 = strip_tags($_REQUEST['m513r998']);
$m513r999 = strip_tags($_REQUEST['m513r999']);
//8.strana
$m516r11 = strip_tags($_REQUEST['m516r11']);
$m516r12 = strip_tags($_REQUEST['m516r12']);
$m516r13 = strip_tags($_REQUEST['m516r13']);
$m516r14 = strip_tags($_REQUEST['m516r14']);
$m516r15 = strip_tags($_REQUEST['m516r15']);
$m516r16 = strip_tags($_REQUEST['m516r16']);
$m516r17 = strip_tags($_REQUEST['m516r17']);
$m516r21 = strip_tags($_REQUEST['m516r21']);
$m516r22 = strip_tags($_REQUEST['m516r22']);
$m516r23 = strip_tags($_REQUEST['m516r23']);
$m516r24 = strip_tags($_REQUEST['m516r24']);
$m516r25 = strip_tags($_REQUEST['m516r25']);
$m516r26 = strip_tags($_REQUEST['m516r26']);
$m516r27 = strip_tags($_REQUEST['m516r27']);
$m516r31 = strip_tags($_REQUEST['m516r31']);
$m516r32 = strip_tags($_REQUEST['m516r32']);
$m516r33 = strip_tags($_REQUEST['m516r33']);
$m516r34 = strip_tags($_REQUEST['m516r34']);
$m516r35 = strip_tags($_REQUEST['m516r35']);
$m516r36 = strip_tags($_REQUEST['m516r36']);
$m516r37 = strip_tags($_REQUEST['m516r37']);
$m516r41 = strip_tags($_REQUEST['m516r41']);
$m516r42 = strip_tags($_REQUEST['m516r42']);
$m516r43 = strip_tags($_REQUEST['m516r43']);
$m516r44 = strip_tags($_REQUEST['m516r44']);
$m516r45 = strip_tags($_REQUEST['m516r45']);
$m516r46 = strip_tags($_REQUEST['m516r46']);
$m516r47 = strip_tags($_REQUEST['m516r47']);
$m516r51 = strip_tags($_REQUEST['m516r51']);
$m516r53 = strip_tags($_REQUEST['m516r53']);
$m516r54 = strip_tags($_REQUEST['m516r54']);
$m516r55 = strip_tags($_REQUEST['m516r55']);
$m516r57 = strip_tags($_REQUEST['m516r57']);
$m516r61 = strip_tags($_REQUEST['m516r61']);
$m516r62 = strip_tags($_REQUEST['m516r62']);
$m516r63 = strip_tags($_REQUEST['m516r63']);
$m516r64 = strip_tags($_REQUEST['m516r64']);
$m516r65 = strip_tags($_REQUEST['m516r65']);
$m516r66 = strip_tags($_REQUEST['m516r66']);
$m516r67 = strip_tags($_REQUEST['m516r67']);
$m516r71 = strip_tags($_REQUEST['m516r71']);
$m516r72 = strip_tags($_REQUEST['m516r72']);
$m516r73 = strip_tags($_REQUEST['m516r73']);
$m516r74 = strip_tags($_REQUEST['m516r74']);
$m516r75 = strip_tags($_REQUEST['m516r75']);
$m516r76 = strip_tags($_REQUEST['m516r76']);
$m516r77 = strip_tags($_REQUEST['m516r77']);
$m516r81 = strip_tags($_REQUEST['m516r81']);
$m516r82 = strip_tags($_REQUEST['m516r82']);
$m516r83 = strip_tags($_REQUEST['m516r83']);
$m516r84 = strip_tags($_REQUEST['m516r84']);
$m516r85 = strip_tags($_REQUEST['m516r85']);
$m516r86 = strip_tags($_REQUEST['m516r86']);
$m516r87 = strip_tags($_REQUEST['m516r87']);
$m516r91 = strip_tags($_REQUEST['m516r91']);
$m516r92 = strip_tags($_REQUEST['m516r92']);
$m516r93 = strip_tags($_REQUEST['m516r93']);
$m516r94 = strip_tags($_REQUEST['m516r94']);
$m516r95 = strip_tags($_REQUEST['m516r95']);
$m516r96 = strip_tags($_REQUEST['m516r96']);
$m516r97 = strip_tags($_REQUEST['m516r97']);
$m516r101 = strip_tags($_REQUEST['m516r101']);
$m516r102 = strip_tags($_REQUEST['m516r102']);
$m516r103 = strip_tags($_REQUEST['m516r103']);
$m516r104 = strip_tags($_REQUEST['m516r104']);
$m516r105 = strip_tags($_REQUEST['m516r105']);
$m516r106 = strip_tags($_REQUEST['m516r106']);
$m516r107 = strip_tags($_REQUEST['m516r107']);
$m516r111 = strip_tags($_REQUEST['m516r111']);
$m516r112 = strip_tags($_REQUEST['m516r112']);
$m516r113 = strip_tags($_REQUEST['m516r113']);
$m516r114 = strip_tags($_REQUEST['m516r114']);
$m516r115 = strip_tags($_REQUEST['m516r115']);
$m516r116 = strip_tags($_REQUEST['m516r116']);
$m516r117 = strip_tags($_REQUEST['m516r117']);
$m516r121 = strip_tags($_REQUEST['m516r121']);
$m516r122 = strip_tags($_REQUEST['m516r122']);
$m516r123 = strip_tags($_REQUEST['m516r123']);
$m516r124 = strip_tags($_REQUEST['m516r124']);
$m516r125 = strip_tags($_REQUEST['m516r125']);
$m516r126 = strip_tags($_REQUEST['m516r126']);
$m516r127 = strip_tags($_REQUEST['m516r127']);
$m516r131 = strip_tags($_REQUEST['m516r131']);
$m516r132 = strip_tags($_REQUEST['m516r132']);
$m516r133 = strip_tags($_REQUEST['m516r133']);
$m516r134 = strip_tags($_REQUEST['m516r134']);
$m516r135 = strip_tags($_REQUEST['m516r135']);
$m516r136 = strip_tags($_REQUEST['m516r136']);
$m516r137 = strip_tags($_REQUEST['m516r137']);
$m516r141 = strip_tags($_REQUEST['m516r141']);
$m516r142 = strip_tags($_REQUEST['m516r142']);
$m516r143 = strip_tags($_REQUEST['m516r143']);
$m516r144 = strip_tags($_REQUEST['m516r144']);
$m516r145 = strip_tags($_REQUEST['m516r145']);
$m516r146 = strip_tags($_REQUEST['m516r146']);
$m516r147 = strip_tags($_REQUEST['m516r147']);
$m516r151 = strip_tags($_REQUEST['m516r151']);
$m516r152 = strip_tags($_REQUEST['m516r152']);
$m516r153 = strip_tags($_REQUEST['m516r153']);
$m516r154 = strip_tags($_REQUEST['m516r154']);
$m516r155 = strip_tags($_REQUEST['m516r155']);
$m516r156 = strip_tags($_REQUEST['m516r156']);
$m516r157 = strip_tags($_REQUEST['m516r157']);
$m516r161 = strip_tags($_REQUEST['m516r161']);
$m516r162 = strip_tags($_REQUEST['m516r162']);
$m516r163 = strip_tags($_REQUEST['m516r163']);
$m516r164 = strip_tags($_REQUEST['m516r164']);
$m516r165 = strip_tags($_REQUEST['m516r165']);
$m516r166 = strip_tags($_REQUEST['m516r166']);
$m516r167 = strip_tags($_REQUEST['m516r167']);
$m516r171 = strip_tags($_REQUEST['m516r171']);
$m516r172 = strip_tags($_REQUEST['m516r172']);
$m516r174 = strip_tags($_REQUEST['m516r174']);
$m516r175 = strip_tags($_REQUEST['m516r175']);
$m516r177 = strip_tags($_REQUEST['m516r177']);
$m516r181 = strip_tags($_REQUEST['m516r181']);
$m516r182 = strip_tags($_REQUEST['m516r182']);
$m516r184 = strip_tags($_REQUEST['m516r184']);
$m516r185 = strip_tags($_REQUEST['m516r185']);
$m516r187 = strip_tags($_REQUEST['m516r187']);
$m516r191 = strip_tags($_REQUEST['m516r191']);
$m516r192 = strip_tags($_REQUEST['m516r192']);
$m516r194 = strip_tags($_REQUEST['m516r194']);
$m516r195 = strip_tags($_REQUEST['m516r195']);
$m516r197 = strip_tags($_REQUEST['m516r197']);
$m516r201 = strip_tags($_REQUEST['m516r201']);
$m516r202 = strip_tags($_REQUEST['m516r202']);
$m516r204 = strip_tags($_REQUEST['m516r204']);
$m516r205 = strip_tags($_REQUEST['m516r205']);
$m516r206 = strip_tags($_REQUEST['m516r206']);
$m516r207 = strip_tags($_REQUEST['m516r207']);
$m516r211 = strip_tags($_REQUEST['m516r211']);
$m516r212 = strip_tags($_REQUEST['m516r212']);
$m516r214 = strip_tags($_REQUEST['m516r214']);
$m516r215 = strip_tags($_REQUEST['m516r215']);
$m516r216 = strip_tags($_REQUEST['m516r216']);
$m516r217 = strip_tags($_REQUEST['m516r217']);
$m516r221 = strip_tags($_REQUEST['m516r221']);
$m516r222 = strip_tags($_REQUEST['m516r222']);
$m516r223 = strip_tags($_REQUEST['m516r223']);
$m516r224 = strip_tags($_REQUEST['m516r224']);
$m516r225 = strip_tags($_REQUEST['m516r225']);
$m516r226 = strip_tags($_REQUEST['m516r226']);
$m516r227 = strip_tags($_REQUEST['m516r227']);
$m516r991 = strip_tags($_REQUEST['m516r991']);
$m516r992 = strip_tags($_REQUEST['m516r992']);
$m516r993 = strip_tags($_REQUEST['m516r993']);
$m516r994 = strip_tags($_REQUEST['m516r994']);
$m516r995 = strip_tags($_REQUEST['m516r995']);
$m516r996 = strip_tags($_REQUEST['m516r996']);
$m516r997 = strip_tags($_REQUEST['m516r997']);
//9.strana
$m586r11 = strip_tags($_REQUEST['m586r11']);
$m586r12 = strip_tags($_REQUEST['m586r12']);
$m586r21 = strip_tags($_REQUEST['m586r21']);
$m586r22 = strip_tags($_REQUEST['m586r22']);
$m586r131 = strip_tags($_REQUEST['m586r131']);
$m586r132 = strip_tags($_REQUEST['m586r132']);
$m586r141 = strip_tags($_REQUEST['m586r141']);
$m586r142 = strip_tags($_REQUEST['m586r142']);
$m586r151 = strip_tags($_REQUEST['m586r151']);
$m586r152 = strip_tags($_REQUEST['m586r152']);
$m586r191 = strip_tags($_REQUEST['m586r191']);
$m586r192 = strip_tags($_REQUEST['m586r192']);
$m586r201 = strip_tags($_REQUEST['m586r201']);
$m586r202 = strip_tags($_REQUEST['m586r202']);
$m586r991 = strip_tags($_REQUEST['m586r991']);
$m586r992 = strip_tags($_REQUEST['m586r992']);
//10.strana
$m19r1 = strip_tags($_REQUEST['m19r1']);
$m19r2 = strip_tags($_REQUEST['m19r2']);
$m19r3 = strip_tags($_REQUEST['m19r3']);
$m19r4 = strip_tags($_REQUEST['m19r4']);
$m19r5 = strip_tags($_REQUEST['m19r5']);
$m19r6 = strip_tags($_REQUEST['m19r6']);
$m19r7 = strip_tags($_REQUEST['m19r7']);
$m19r8 = strip_tags($_REQUEST['m19r8']);
$m19r9 = strip_tags($_REQUEST['m19r9']);
$m19r10 = strip_tags($_REQUEST['m19r10']);
$m19r11 = strip_tags($_REQUEST['m19r11']);
$m19r12 = strip_tags($_REQUEST['m19r12']);
$m19r99 = strip_tags($_REQUEST['m19r99']);
$m1527r1a = strip_tags($_REQUEST['m1527r1a']);
$m1527r1b = strip_tags($_REQUEST['m1527r1b']);
//11.strana
$m527r11 = strip_tags($_REQUEST['m527r11']);
$m527r12 = strip_tags($_REQUEST['m527r12']);
$m527r13 = strip_tags($_REQUEST['m527r13']);
$m527r14 = strip_tags($_REQUEST['m527r14']);
$m527r15 = strip_tags($_REQUEST['m527r15']);
$m527r16 = strip_tags($_REQUEST['m527r16']);
$m527r17 = strip_tags($_REQUEST['m527r17']);
$m527r18 = strip_tags($_REQUEST['m527r18']);
$m527r19 = strip_tags($_REQUEST['m527r19']);
$m527r110 = strip_tags($_REQUEST['m527r110']);
$m527r21 = strip_tags($_REQUEST['m527r21']);
$m527r22 = strip_tags($_REQUEST['m527r22']);
$m527r23 = strip_tags($_REQUEST['m527r23']);
$m527r24 = strip_tags($_REQUEST['m527r24']);
$m527r25 = strip_tags($_REQUEST['m527r25']);
$m527r26 = strip_tags($_REQUEST['m527r26']);
$m527r27 = strip_tags($_REQUEST['m527r27']);
$m527r28 = strip_tags($_REQUEST['m527r28']);
$m527r29 = strip_tags($_REQUEST['m527r29']);
$m527r210 = strip_tags($_REQUEST['m527r210']);
$m527r31 = strip_tags($_REQUEST['m527r31']);
$m527r32 = strip_tags($_REQUEST['m527r32']);
$m527r33 = strip_tags($_REQUEST['m527r33']);
$m527r34 = strip_tags($_REQUEST['m527r34']);
$m527r35 = strip_tags($_REQUEST['m527r35']);
$m527r36 = strip_tags($_REQUEST['m527r36']);
$m527r37 = strip_tags($_REQUEST['m527r37']);
$m527r38 = strip_tags($_REQUEST['m527r38']);
$m527r39 = strip_tags($_REQUEST['m527r39']);
$m527r310 = strip_tags($_REQUEST['m527r310']);
$m527r41 = strip_tags($_REQUEST['m527r41']);
$m527r42 = strip_tags($_REQUEST['m527r42']);
$m527r43 = strip_tags($_REQUEST['m527r43']);
$m527r44 = strip_tags($_REQUEST['m527r44']);
$m527r45 = strip_tags($_REQUEST['m527r45']);
$m527r46 = strip_tags($_REQUEST['m527r46']);
$m527r47 = strip_tags($_REQUEST['m527r47']);
$m527r48 = strip_tags($_REQUEST['m527r48']);
$m527r49 = strip_tags($_REQUEST['m527r49']);
$m527r410 = strip_tags($_REQUEST['m527r410']);
$m527r51 = strip_tags($_REQUEST['m527r51']);
$m527r52 = strip_tags($_REQUEST['m527r52']);
$m527r53 = strip_tags($_REQUEST['m527r53']);
$m527r54 = strip_tags($_REQUEST['m527r54']);
$m527r55 = strip_tags($_REQUEST['m527r55']);
$m527r56 = strip_tags($_REQUEST['m527r56']);
$m527r57 = strip_tags($_REQUEST['m527r57']);
$m527r58 = strip_tags($_REQUEST['m527r58']);
$m527r59 = strip_tags($_REQUEST['m527r59']);
$m527r510 = strip_tags($_REQUEST['m527r510']);
$m527r61 = strip_tags($_REQUEST['m527r61']);
$m527r62 = strip_tags($_REQUEST['m527r62']);
$m527r63 = strip_tags($_REQUEST['m527r63']);
$m527r64 = strip_tags($_REQUEST['m527r64']);
$m527r65 = strip_tags($_REQUEST['m527r65']);
$m527r66 = strip_tags($_REQUEST['m527r66']);
$m527r67 = strip_tags($_REQUEST['m527r67']);
$m527r68 = strip_tags($_REQUEST['m527r68']);
$m527r69 = strip_tags($_REQUEST['m527r69']);
$m527r610 = strip_tags($_REQUEST['m527r610']);
$m527r71 = strip_tags($_REQUEST['m527r71']);
$m527r72 = strip_tags($_REQUEST['m527r72']);
$m527r73 = strip_tags($_REQUEST['m527r73']);
$m527r74 = strip_tags($_REQUEST['m527r74']);
$m527r75 = strip_tags($_REQUEST['m527r75']);
$m527r76 = strip_tags($_REQUEST['m527r76']);
$m527r77 = strip_tags($_REQUEST['m527r77']);
$m527r78 = strip_tags($_REQUEST['m527r78']);
$m527r79 = strip_tags($_REQUEST['m527r79']);
$m527r710 = strip_tags($_REQUEST['m527r710']);
$m527r81 = strip_tags($_REQUEST['m527r81']);
$m527r82 = strip_tags($_REQUEST['m527r82']);
$m527r83 = strip_tags($_REQUEST['m527r83']);
$m527r84 = strip_tags($_REQUEST['m527r84']);
$m527r85 = strip_tags($_REQUEST['m527r85']);
$m527r86 = strip_tags($_REQUEST['m527r86']);
$m527r87 = strip_tags($_REQUEST['m527r87']);
$m527r88 = strip_tags($_REQUEST['m527r88']);
$m527r89 = strip_tags($_REQUEST['m527r89']);
$m527r810 = strip_tags($_REQUEST['m527r810']);
$m527r91 = strip_tags($_REQUEST['m527r91']);
$m527r92 = strip_tags($_REQUEST['m527r92']);
$m527r93 = strip_tags($_REQUEST['m527r93']);
$m527r94 = strip_tags($_REQUEST['m527r94']);
$m527r95 = strip_tags($_REQUEST['m527r95']);
$m527r96 = strip_tags($_REQUEST['m527r96']);
$m527r97 = strip_tags($_REQUEST['m527r97']);
$m527r98 = strip_tags($_REQUEST['m527r98']);
$m527r99 = strip_tags($_REQUEST['m527r99']);
$m527r910 = strip_tags($_REQUEST['m527r910']);
$m527r101 = strip_tags($_REQUEST['m527r101']);
$m527r102 = strip_tags($_REQUEST['m527r102']);
$m527r103 = strip_tags($_REQUEST['m527r103']);
$m527r104 = strip_tags($_REQUEST['m527r104']);
$m527r105 = strip_tags($_REQUEST['m527r105']);
$m527r106 = strip_tags($_REQUEST['m527r106']);
$m527r107 = strip_tags($_REQUEST['m527r107']);
$m527r108 = strip_tags($_REQUEST['m527r108']);
$m527r109 = strip_tags($_REQUEST['m527r109']);
$m527r1010 = strip_tags($_REQUEST['m527r1010']);
$m527r111 = strip_tags($_REQUEST['m527r111']);
$m527r112 = strip_tags($_REQUEST['m527r112']);
$m527r113 = strip_tags($_REQUEST['m527r113']);
$m527r114 = strip_tags($_REQUEST['m527r114']);
$m527r115 = strip_tags($_REQUEST['m527r115']);
$m527r116 = strip_tags($_REQUEST['m527r116']);
$m527r117 = strip_tags($_REQUEST['m527r117']);
$m527r118 = strip_tags($_REQUEST['m527r118']);
$m527r119 = strip_tags($_REQUEST['m527r119']);
$m527r1110 = strip_tags($_REQUEST['m527r1110']);
$m527r121 = strip_tags($_REQUEST['m527r121']);
$m527r122 = strip_tags($_REQUEST['m527r122']);
$m527r123 = strip_tags($_REQUEST['m527r123']);
$m527r124 = strip_tags($_REQUEST['m527r124']);
$m527r125 = strip_tags($_REQUEST['m527r125']);
$m527r126 = strip_tags($_REQUEST['m527r126']);
$m527r127 = strip_tags($_REQUEST['m527r127']);
$m527r128 = strip_tags($_REQUEST['m527r128']);
$m527r129 = strip_tags($_REQUEST['m527r129']);
$m527r1210 = strip_tags($_REQUEST['m527r1210']);
$m527r131 = strip_tags($_REQUEST['m527r131']);
$m527r132 = strip_tags($_REQUEST['m527r132']);
$m527r133 = strip_tags($_REQUEST['m527r133']);
$m527r134 = strip_tags($_REQUEST['m527r134']);
$m527r135 = strip_tags($_REQUEST['m527r135']);
$m527r136 = strip_tags($_REQUEST['m527r136']);
$m527r137 = strip_tags($_REQUEST['m527r137']);
$m527r138 = strip_tags($_REQUEST['m527r138']);
$m527r139 = strip_tags($_REQUEST['m527r139']);
$m527r1310 = strip_tags($_REQUEST['m527r1310']);
$m527r141 = strip_tags($_REQUEST['m527r141']);
$m527r142 = strip_tags($_REQUEST['m527r142']);
$m527r143 = strip_tags($_REQUEST['m527r143']);
$m527r144 = strip_tags($_REQUEST['m527r144']);
$m527r145 = strip_tags($_REQUEST['m527r145']);
$m527r146 = strip_tags($_REQUEST['m527r146']);
$m527r147 = strip_tags($_REQUEST['m527r147']);
$m527r148 = strip_tags($_REQUEST['m527r148']);
$m527r149 = strip_tags($_REQUEST['m527r149']);
$m527r1410 = strip_tags($_REQUEST['m527r1410']);
$m527r151 = strip_tags($_REQUEST['m527r151']);
$m527r152 = strip_tags($_REQUEST['m527r152']);
$m527r153 = strip_tags($_REQUEST['m527r153']);
$m527r154 = strip_tags($_REQUEST['m527r154']);
$m527r155 = strip_tags($_REQUEST['m527r155']);
$m527r156 = strip_tags($_REQUEST['m527r156']);
$m527r157 = strip_tags($_REQUEST['m527r157']);
$m527r158 = strip_tags($_REQUEST['m527r158']);
$m527r159 = strip_tags($_REQUEST['m527r159']);
$m527r1510 = strip_tags($_REQUEST['m527r1510']);
$m527r161 = strip_tags($_REQUEST['m527r161']);
$m527r162 = strip_tags($_REQUEST['m527r162']);
$m527r163 = strip_tags($_REQUEST['m527r163']);
$m527r164 = strip_tags($_REQUEST['m527r164']);
$m527r165 = strip_tags($_REQUEST['m527r165']);
$m527r166 = strip_tags($_REQUEST['m527r166']);
$m527r167 = strip_tags($_REQUEST['m527r167']);
$m527r168 = strip_tags($_REQUEST['m527r168']);
$m527r169 = strip_tags($_REQUEST['m527r169']);
$m527r1610 = strip_tags($_REQUEST['m527r1610']);
$m527r171 = strip_tags($_REQUEST['m527r171']);
$m527r172 = strip_tags($_REQUEST['m527r172']);
$m527r173 = strip_tags($_REQUEST['m527r173']);
$m527r174 = strip_tags($_REQUEST['m527r174']);
$m527r175 = strip_tags($_REQUEST['m527r175']);
$m527r176 = strip_tags($_REQUEST['m527r176']);
$m527r177 = strip_tags($_REQUEST['m527r177']);
$m527r178 = strip_tags($_REQUEST['m527r178']);
$m527r179 = strip_tags($_REQUEST['m527r179']);
$m527r1710 = strip_tags($_REQUEST['m527r1710']);
//12.strana
$m527r181 = strip_tags($_REQUEST['m527r181']);
$m527r182 = strip_tags($_REQUEST['m527r182']);
$m527r183 = strip_tags($_REQUEST['m527r183']);
$m527r184 = strip_tags($_REQUEST['m527r184']);
$m527r185 = strip_tags($_REQUEST['m527r185']);
$m527r186 = strip_tags($_REQUEST['m527r186']);
$m527r187 = strip_tags($_REQUEST['m527r187']);
$m527r188 = strip_tags($_REQUEST['m527r188']);
$m527r1810 = strip_tags($_REQUEST['m527r1810']);
$m527r191 = strip_tags($_REQUEST['m527r191']);
$m527r192 = strip_tags($_REQUEST['m527r192']);
$m527r193 = strip_tags($_REQUEST['m527r193']);
$m527r194 = strip_tags($_REQUEST['m527r194']);
$m527r195 = strip_tags($_REQUEST['m527r195']);
$m527r196 = strip_tags($_REQUEST['m527r196']);
$m527r197 = strip_tags($_REQUEST['m527r197']);
$m527r198 = strip_tags($_REQUEST['m527r198']);
$m527r1910 = strip_tags($_REQUEST['m527r1910']);
$m527r201 = strip_tags($_REQUEST['m527r201']);
$m527r202 = strip_tags($_REQUEST['m527r202']);
$m527r203 = strip_tags($_REQUEST['m527r203']);
$m527r204 = strip_tags($_REQUEST['m527r204']);
$m527r205 = strip_tags($_REQUEST['m527r205']);
$m527r206 = strip_tags($_REQUEST['m527r206']);
$m527r207 = strip_tags($_REQUEST['m527r207']);
$m527r208 = strip_tags($_REQUEST['m527r208']);
$m527r2010 = strip_tags($_REQUEST['m527r2010']);
$m527r211 = strip_tags($_REQUEST['m527r211']);
$m527r212 = strip_tags($_REQUEST['m527r212']);
$m527r213 = strip_tags($_REQUEST['m527r213']);
$m527r214 = strip_tags($_REQUEST['m527r214']);
$m527r215 = strip_tags($_REQUEST['m527r215']);
$m527r216 = strip_tags($_REQUEST['m527r216']);
$m527r217 = strip_tags($_REQUEST['m527r217']);
$m527r218 = strip_tags($_REQUEST['m527r218']);
$m527r2110 = strip_tags($_REQUEST['m527r2110']);
$m527r221 = strip_tags($_REQUEST['m527r221']);
$m527r222 = strip_tags($_REQUEST['m527r222']);
$m527r223 = strip_tags($_REQUEST['m527r223']);
$m527r224 = strip_tags($_REQUEST['m527r224']);
$m527r225 = strip_tags($_REQUEST['m527r225']);
$m527r226 = strip_tags($_REQUEST['m527r226']);
$m527r227 = strip_tags($_REQUEST['m527r227']);
$m527r228 = strip_tags($_REQUEST['m527r228']);
$m527r2210 = strip_tags($_REQUEST['m527r2210']);
$m527r231 = strip_tags($_REQUEST['m527r231']);
$m527r232 = strip_tags($_REQUEST['m527r232']);
$m527r233 = strip_tags($_REQUEST['m527r233']);
$m527r234 = strip_tags($_REQUEST['m527r234']);
$m527r235 = strip_tags($_REQUEST['m527r235']);
$m527r236 = strip_tags($_REQUEST['m527r236']);
$m527r237 = strip_tags($_REQUEST['m527r237']);
$m527r238 = strip_tags($_REQUEST['m527r238']);
$m527r2310 = strip_tags($_REQUEST['m527r2310']);
$m527r241 = strip_tags($_REQUEST['m527r241']);
$m527r242 = strip_tags($_REQUEST['m527r242']);
$m527r243 = strip_tags($_REQUEST['m527r243']);
$m527r244 = strip_tags($_REQUEST['m527r244']);
$m527r245 = strip_tags($_REQUEST['m527r245']);
$m527r246 = strip_tags($_REQUEST['m527r246']);
$m527r247 = strip_tags($_REQUEST['m527r247']);
$m527r248 = strip_tags($_REQUEST['m527r248']);
$m527r2410 = strip_tags($_REQUEST['m527r2410']);
$m527r991 = strip_tags($_REQUEST['m527r991']);
$m527r992 = strip_tags($_REQUEST['m527r992']);
$m527r993 = strip_tags($_REQUEST['m527r993']);
$m527r994 = strip_tags($_REQUEST['m527r994']);
$m527r995 = strip_tags($_REQUEST['m527r995']);
$m527r996 = strip_tags($_REQUEST['m527r996']);
$m527r997 = strip_tags($_REQUEST['m527r997']);
$m527r998 = strip_tags($_REQUEST['m527r998']);
$m527r999 = strip_tags($_REQUEST['m527r999']);
$m527r9910 = strip_tags($_REQUEST['m527r9910']);
//13.strana
$m474r11 = strip_tags($_REQUEST['m474r11']);
$m474r12 = strip_tags($_REQUEST['m474r12']);
$m474r13 = strip_tags($_REQUEST['m474r13']);
$m474r21 = strip_tags($_REQUEST['m474r21']);
$m474r22 = strip_tags($_REQUEST['m474r22']);
$m474r23 = strip_tags($_REQUEST['m474r23']);
$m474r31 = strip_tags($_REQUEST['m474r31']);
$m474r32 = strip_tags($_REQUEST['m474r32']);
$m474r33 = strip_tags($_REQUEST['m474r33']);
$m474r41 = strip_tags($_REQUEST['m474r41']);
$m474r42 = strip_tags($_REQUEST['m474r42']);
$m474r43 = strip_tags($_REQUEST['m474r43']);
$m474r51 = strip_tags($_REQUEST['m474r51']);
$m474r52 = strip_tags($_REQUEST['m474r52']);
$m474r53 = strip_tags($_REQUEST['m474r53']);
$m474r61 = strip_tags($_REQUEST['m474r61']);
$m474r62 = strip_tags($_REQUEST['m474r62']);
$m474r63 = strip_tags($_REQUEST['m474r63']);
$m474r72 = strip_tags($_REQUEST['m474r72']);
$m474r73 = strip_tags($_REQUEST['m474r73']);
$m474r991 = strip_tags($_REQUEST['m474r991']);
$m474r992 = strip_tags($_REQUEST['m474r992']);
$m474r993 = strip_tags($_REQUEST['m474r993']);
$m514r1 = strip_tags($_REQUEST['m514r1']);
$m514r2 = strip_tags($_REQUEST['m514r2']);
$m514r3 = strip_tags($_REQUEST['m514r3']);
$m514r99 = strip_tags($_REQUEST['m514r99']);
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" odoslane='$odoslane_sql', cinnost='$cinnost' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" mod2r01='$mod2r01', mod2r02='$mod2r02',
  mod100041ano='$mod100041ano', mod100041nie='$mod100041nie',
  mod100042ano='$mod100042ano', mod100042nie='$mod100042nie',
  mod100043ano='$mod100043ano', mod100043nie='$mod100043nie',
  m1100r4='$m1100r4', m1100r5='$m1100r5', m1100r6='$m1100r6', m1100r7='$m1100r7',
  m1100r8='$m1100r8', m1100r9='$m1100r9', m1100r10='$m1100r10', m1100r11='$m1100r11',
  m1100r12='$m1100r12', m1100r13='$m1100r13',
  mod100036kal='$mod100036kal', mod100036hos='$mod100036hos' ".
" WHERE ico >= 0";
                    }

if ( $strana == 3 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" mod100037='$mod100037', m100214r01='$m100214r01', m100214r02='$m100214r02',
  mod100069ano='$mod100069ano', mod100069nie='$mod100069nie',
  m1101r2='$m1101r2', m1101r3='$m1101r3', m1101r4a='$m1101r4a', m1101r4b='$m1101r4b',
  m1101r5a='$m1101r5a', m1101r5b='$m1101r5b', m1101r6a='$m1101r6a', m1101r6b='$m1101r6b',
  m1101r7a='$m1101r7a', m1101r7b='$m1101r7b' ".
" WHERE ico >= 0";
                    }

if ( $strana == 4 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m398r11='$m398r11', m398r12='$m398r12', m398r13='$m398r13', m398r14='$m398r14',
  m398r21='$m398r21', m398r22='$m398r22', m398r23='$m398r23', m398r24='$m398r24',
  m398r991='$m398r991', m398r992='$m398r992', m398r993='$m398r993', m398r994='$m398r994',
  m1005r1a='$m1005r1a', m1005r1b='$m1005r1b',
  m405r11='$m405r11', m405r12='$m405r12', m405r21='$m405r21',
  m405r31='$m405r31', m405r32='$m405r32', m405r41='$m405r41',
  m405r51='$m405r51', m405r61='$m405r61', m405r71='$m405r71',
  m405r81='$m405r81', m405r82='$m405r82', m405r991='$m405r991', m405r992='$m405r992',
  m406r1='$m406r1', m406r2='$m406r2', m406r3='$m406r3', m406r4='$m406r4', m406r5='$m406r5',
  m406r6='$m406r6', m406r7='$m406r7', m406r99='$m406r99' ".
" WHERE ico >= 0";
                    }

if ( $strana == 5 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m558r1='$m558r1', m558r2='$m558r2', m558r3='$m558r3', m558r4='$m558r4',
  m558r5='$m558r5', m558r6='$m558r6', m558r7='$m558r7', m558r8='$m558r8',
  m558r9='$m558r9', m558r10='$m558r10', m558r11='$m558r11', m558r12='$m558r12',
  m558r13='$m558r13', m558r14='$m558r14', m558r15='$m558r15', m558r16='$m558r16',
  m558r17='$m558r17', m558r18='$m558r18', m558r99='$m558r99',
  m585r01='$m585r01', m585r02='$m585r02', m585r03='$m585r03', m585r04='$m585r04',
  m585r05='$m585r05', m585r3k='$m585r3k', m585r4k='$m585r4k', m585r5k='$m585r5k',
  m100044ano='$m100044ano', m100044nie='$m100044nie' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 6 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m571r10='$m571r10', m571r12='$m571r12', m571r13='$m571r13', m571r15='$m571r15',
  m571r16='$m571r16', m571r17='$m571r17', m571r18='$m571r18',
  m571r20='$m571r20', m571r22='$m571r22', m571r23='$m571r23', m571r25='$m571r25',
  m571r26='$m571r26', m571r27='$m571r27', m571r28='$m571r28',
  m571r30='$m571r30', m571r32='$m571r32', m571r33='$m571r33', m571r35='$m571r35',
  m571r36='$m571r36', m571r37='$m571r37', m571r38='$m571r38',
  m571r40='$m571r40', m571r42='$m571r42', m571r43='$m571r43', m571r45='$m571r45',
  m571r46='$m571r46', m571r47='$m571r47', m571r48='$m571r48',
  m571r50='$m571r50', m571r52='$m571r52', m571r53='$m571r53', m571r55='$m571r55',
  m571r56='$m571r56', m571r57='$m571r57', m571r58='$m571r58',
  m571r60='$m571r60', m571r62='$m571r62', m571r63='$m571r63', m571r65='$m571r65',
  m571r66='$m571r66', m571r67='$m571r67', m571r68='$m571r68',
  m571r70='$m571r70', m571r72='$m571r72', m571r73='$m571r73', m571r75='$m571r75',
  m571r76='$m571r76', m571r77='$m571r77', m571r78='$m571r78',
  m571r80='$m571r80', m571r82='$m571r82', m571r83='$m571r83', m571r85='$m571r85',
  m571r86='$m571r86', m571r87='$m571r87', m571r88='$m571r88',
  m571r90='$m571r90', m571r92='$m571r92', m571r93='$m571r93', m571r95='$m571r95',
  m571r96='$m571r96', m571r97='$m571r97', m571r98='$m571r98',
  m581r1='$m581r1', m581r2='$m581r2', m581r3='$m581r3', m581r3='$m581r3',
  m581r4='$m581r4', m581r5='$m581r5', m581r6='$m581r6', m581r7='$m581r7',
  m581r8='$m581r8', m581r12='$m581r12', m581r99='$m581r99' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 7 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r11='$m513r11', m513r12='$m513r12', m513r13='$m513r13', m513r14='$m513r14',
  m513r15='$m513r15', m513r16='$m513r16', m513r17='$m513r17', m513r18='$m513r18',
  m513r19='$m513r19', m513r21='$m513r21', m513r22='$m513r22', m513r23='$m513r23',
  m513r24='$m513r24', m513r25='$m513r25', m513r26='$m513r26', m513r27='$m513r27',
  m513r28='$m513r28', m513r29='$m513r29', m513r31='$m513r31', m513r32='$m513r32',
  m513r33='$m513r33', m513r34='$m513r34', m513r35='$m513r35', m513r36='$m513r36',
  m513r37='$m513r37', m513r38='$m513r38', m513r39='$m513r39', m513r41='$m513r41',
  m513r42='$m513r42', m513r43='$m513r43', m513r44='$m513r44', m513r45='$m513r45',
  m513r46='$m513r46', m513r47='$m513r47', m513r48='$m513r48', m513r49='$m513r49',
  m513r51='$m513r51', m513r52='$m513r52', m513r53='$m513r53', m513r54='$m513r54',
  m513r55='$m513r55', m513r56='$m513r56', m513r57='$m513r57', m513r58='$m513r58',
  m513r59='$m513r59', m513r61='$m513r61', m513r62='$m513r62', m513r63='$m513r63',
  m513r64='$m513r64', m513r65='$m513r65', m513r66='$m513r66', m513r67='$m513r67',
  m513r68='$m513r68', m513r69='$m513r69', m513r71='$m513r71', m513r72='$m513r72',
  m513r73='$m513r73', m513r74='$m513r74', m513r75='$m513r75', m513r76='$m513r76',
  m513r77='$m513r77', m513r78='$m513r78', m513r79='$m513r79', m513r81='$m513r81',
  m513r82='$m513r82', m513r83='$m513r83', m513r84='$m513r84', m513r85='$m513r85',
  m513r86='$m513r86', m513r87='$m513r87', m513r88='$m513r88', m513r89='$m513r89',
  m513r91='$m513r91', m513r92='$m513r92', m513r93='$m513r93', m513r94='$m513r94',
  m513r95='$m513r95', m513r96='$m513r96', m513r97='$m513r97', m513r98='$m513r98',
  m513r99='$m513r99', m513r101='$m513r101', m513r102='$m513r102', m513r103='$m513r103',
  m513r104='$m513r104', m513r105='$m513r105', m513r106='$m513r106', m513r107='$m513r107',
  m513r108='$m513r108', m513r109='$m513r109', m513r111='$m513r111', m513r112='$m513r112',
  m513r113='$m513r113', m513r114='$m513r114', m513r115='$m513r115', m513r116='$m513r116',
  m513r117='$m513r117', m513r118='$m513r118', m513r119='$m513r119', m513r121='$m513r121',
  m513r122='$m513r122', m513r123='$m513r123', m513r124='$m513r124', m513r125='$m513r125',
  m513r126='$m513r126', m513r127='$m513r127', m513r128='$m513r128', m513r129='$m513r129',
  m513r131='$m513r131', m513r132='$m513r132', m513r133='$m513r133', m513r134='$m513r134',
  m513r135='$m513r135', m513r136='$m513r136', m513r137='$m513r137', m513r138='$m513r138',
  m513r139='$m513r139', m513r141='$m513r141', m513r142='$m513r142', m513r143='$m513r143',
  m513r144='$m513r144', m513r145='$m513r145', m513r146='$m513r146', m513r147='$m513r147',
  m513r148='$m513r148', m513r149='$m513r149', m513r151='$m513r151', m513r152='$m513r152',
  m513r153='$m513r153', m513r154='$m513r154', m513r155='$m513r155', m513r156='$m513r156',
  m513r157='$m513r157', m513r158='$m513r158', m513r159='$m513r159', m513r161='$m513r161',
  m513r162='$m513r162', m513r163='$m513r163', m513r164='$m513r164', m513r165='$m513r165',
  m513r166='$m513r166', m513r167='$m513r167', m513r168='$m513r168', m513r169='$m513r169',
  m513r171='$m513r171', m513r173='$m513r173', m513r174='$m513r174', m513r175='$m513r175',
  m513r176='$m513r176', m513r177='$m513r177', m513r181='$m513r181', m513r183='$m513r183',
  m513r184='$m513r184', m513r185='$m513r185', m513r186='$m513r186', m513r187='$m513r187',
  m513r191='$m513r191', m513r193='$m513r193', m513r194='$m513r194', m513r195='$m513r195',
  m513r196='$m513r196', m513r197='$m513r197', m513r201='$m513r201', m513r203='$m513r203',
  m513r204='$m513r204', m513r205='$m513r205', m513r206='$m513r206', m513r207='$m513r207',
  m513r211='$m513r211', m513r213='$m513r213', m513r214='$m513r214', m513r215='$m513r215',
  m513r216='$m513r216', m513r217='$m513r217', m513r221='$m513r221', m513r222='$m513r222',
  m513r223='$m513r223', m513r224='$m513r224', m513r225='$m513r225', m513r226='$m513r226',
  m513r227='$m513r227', m513r228='$m513r228', m513r229='$m513r229', m513r991='$m513r991',
  m513r992='$m513r992', m513r993='$m513r993', m513r994='$m513r994', m513r995='$m513r995',
  m513r996='$m513r996', m513r997='$m513r997', m513r998='$m513r998', m513r999='$m513r999' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 8 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m516r11='$m516r11', m516r12='$m516r12', m516r13='$m516r13', m516r14='$m516r14',
  m516r15='$m516r15', m516r16='$m516r16', m516r17='$m516r17', m516r21='$m516r21',
  m516r22='$m516r22', m516r23='$m516r23', m516r24='$m516r24', m516r25='$m516r25',
  m516r26='$m516r26', m516r27='$m516r27', m516r31='$m516r31', m516r32='$m516r32',
  m516r33='$m516r33', m516r34='$m516r34', m516r35='$m516r35', m516r36='$m516r36',
  m516r37='$m516r37', m516r41='$m516r41', m516r42='$m516r42', m516r43='$m516r43',
  m516r44='$m516r44', m516r45='$m516r45', m516r46='$m516r46', m516r47='$m516r47',
  m516r51='$m516r51', m516r53='$m516r53', m516r54='$m516r54', m516r55='$m516r55',
  m516r57='$m516r57', m516r61='$m516r61', m516r62='$m516r62', m516r63='$m516r63',
  m516r64='$m516r64', m516r65='$m516r65', m516r66='$m516r66', m516r67='$m516r67',
  m516r71='$m516r71', m516r72='$m516r72', m516r73='$m516r73', m516r74='$m516r74',
  m516r75='$m516r75', m516r76='$m516r76', m516r77='$m516r77', m516r81='$m516r81',
  m516r82='$m516r82', m516r83='$m516r83', m516r84='$m516r84', m516r85='$m516r85',
  m516r86='$m516r86', m516r87='$m516r87', m516r91='$m516r91', m516r92='$m516r92',
  m516r93='$m516r93', m516r94='$m516r94', m516r95='$m516r95', m516r96='$m516r96',
  m516r97='$m516r97', m516r101='$m516r101', m516r102='$m516r102', m516r103='$m516r103',
  m516r104='$m516r104', m516r105='$m516r105', m516r106='$m516r106', m516r107='$m516r107',
  m516r111='$m516r111', m516r112='$m516r112', m516r113='$m516r113', m516r114='$m516r114',
  m516r115='$m516r115', m516r116='$m516r116', m516r117='$m516r117', m516r121='$m516r121',
  m516r122='$m516r122', m516r123='$m516r123', m516r124='$m516r124', m516r125='$m516r125',
  m516r126='$m516r126', m516r127='$m516r127', m516r131='$m516r131', m516r132='$m516r132',
  m516r133='$m516r133', m516r134='$m516r134', m516r135='$m516r135', m516r136='$m516r136',
  m516r137='$m516r137', m516r141='$m516r141', m516r142='$m516r142', m516r143='$m516r143',
  m516r144='$m516r144', m516r145='$m516r145', m516r146='$m516r146', m516r147='$m516r147',
  m516r151='$m516r151', m516r152='$m516r152', m516r153='$m516r153', m516r154='$m516r154',
  m516r155='$m516r155', m516r156='$m516r156', m516r157='$m516r157', m516r161='$m516r161',
  m516r162='$m516r162', m516r163='$m516r163', m516r164='$m516r164', m516r165='$m516r165',
  m516r166='$m516r166', m516r167='$m516r167', m516r171='$m516r171', m516r172='$m516r172',
  m516r174='$m516r174', m516r175='$m516r175', m516r177='$m516r177', m516r181='$m516r181',
  m516r182='$m516r182', m516r184='$m516r184', m516r185='$m516r185', m516r187='$m516r187',
  m516r191='$m516r191', m516r192='$m516r192', m516r194='$m516r194', m516r195='$m516r195',
  m516r197='$m516r197', m516r201='$m516r201', m516r202='$m516r202', m516r204='$m516r204',
  m516r205='$m516r205', m516r206='$m516r206', m516r207='$m516r207', m516r211='$m516r211',
  m516r212='$m516r212', m516r214='$m516r214', m516r215='$m516r215', m516r216='$m516r216',
  m516r217='$m516r217', m516r221='$m516r221', m516r222='$m516r222', m516r223='$m516r223',
  m516r224='$m516r224', m516r225='$m516r225', m516r226='$m516r226', m516r227='$m516r227',
  m516r991='$m516r991', m516r992='$m516r992', m516r993='$m516r993', m516r994='$m516r994',
  m516r995='$m516r995', m516r996='$m516r996', m516r997='$m516r997' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 9 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m586r11='$m586r11', m586r12='$m586r12', m586r21='$m586r21', m586r22='$m586r22',
  m586r131='$m586r131', m586r132='$m586r132', m586r141='$m586r141', m586r142='$m586r142',
  m586r151='$m586r151', m586r152='$m586r152',m586r191='$m586r191', m586r192='$m586r192',
  m586r201='$m586r201', m586r202='$m586r202', m586r991='$m586r991', m586r992='$m586r992' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 10 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m19r1='$m19r1', m19r2='$m19r2', m19r3='$m19r3', m19r4='$m19r4', m19r5='$m19r5',
  m19r6='$m19r6', m19r7='$m19r7', m19r8='$m19r8', m19r9='$m19r9', m19r10='$m19r10',
  m19r11='$m19r11', m19r12='$m19r12', m19r99='$m19r99',
  m1527r1a='$m1527r1a', m1527r1b='$m1527r1b' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 11 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m527r11='$m527r11', m527r12='$m527r12', m527r13='$m527r13', m527r14='$m527r14',
  m527r15='$m527r15', m527r16='$m527r16', m527r17='$m527r17', m527r18='$m527r18',
  m527r19='$m527r19', m527r110='$m527r110',
  m527r21='$m527r21', m527r22='$m527r22', m527r23='$m527r23', m527r24='$m527r24',
  m527r25='$m527r25', m527r26='$m527r26', m527r27='$m527r27', m527r28='$m527r28',
  m527r29='$m527r29', m527r210='$m527r210',
  m527r31='$m527r31', m527r32='$m527r32', m527r33='$m527r33', m527r34='$m527r34',
  m527r35='$m527r35', m527r36='$m527r36', m527r37='$m527r37', m527r38='$m527r38',
  m527r39='$m527r39', m527r310='$m527r310',
  m527r41='$m527r41', m527r42='$m527r42', m527r43='$m527r43', m527r44='$m527r44',
  m527r45='$m527r45', m527r46='$m527r46', m527r47='$m527r47', m527r48='$m527r48',
  m527r49='$m527r49', m527r410='$m527r410',
  m527r51='$m527r51', m527r52='$m527r52', m527r53='$m527r53', m527r54='$m527r54',
  m527r55='$m527r55', m527r56='$m527r56', m527r57='$m527r57', m527r58='$m527r58',
  m527r59='$m527r59', m527r510='$m527r510',
  m527r61='$m527r61', m527r62='$m527r62', m527r63='$m527r63', m527r64='$m527r64',
  m527r65='$m527r65', m527r66='$m527r66', m527r67='$m527r67', m527r68='$m527r68',
  m527r69='$m527r69', m527r610='$m527r610',
  m527r71='$m527r71', m527r72='$m527r72', m527r73='$m527r73', m527r74='$m527r74',
  m527r75='$m527r75', m527r76='$m527r76', m527r77='$m527r77', m527r78='$m527r78',
  m527r79='$m527r79', m527r710='$m527r710',
  m527r81='$m527r81', m527r82='$m527r82', m527r83='$m527r83', m527r84='$m527r84',
  m527r85='$m527r85', m527r86='$m527r86', m527r87='$m527r87', m527r88='$m527r88',
  m527r89='$m527r89', m527r810='$m527r810',
  m527r91='$m527r91', m527r92='$m527r92', m527r93='$m527r93', m527r94='$m527r94',
  m527r95='$m527r95', m527r96='$m527r96', m527r97='$m527r97', m527r98='$m527r98',
  m527r99='$m527r99', m527r910='$m527r910',
  m527r101='$m527r101', m527r102='$m527r102', m527r103='$m527r103', m527r104='$m527r104',
  m527r105='$m527r105', m527r106='$m527r106', m527r107='$m527r107', m527r108='$m527r108',
  m527r109='$m527r109', m527r1010='$m527r1010',
  m527r111='$m527r111', m527r112='$m527r112', m527r113='$m527r113', m527r114='$m527r114',
  m527r115='$m527r115', m527r116='$m527r116', m527r117='$m527r117', m527r118='$m527r118',
  m527r119='$m527r119', m527r1110='$m527r1110',
  m527r121='$m527r121', m527r122='$m527r122', m527r123='$m527r123', m527r124='$m527r124',
  m527r125='$m527r125', m527r126='$m527r126', m527r127='$m527r127', m527r128='$m527r128',
  m527r129='$m527r129', m527r1210='$m527r1210',
  m527r131='$m527r131', m527r132='$m527r132', m527r133='$m527r133', m527r134='$m527r134',
  m527r135='$m527r135', m527r136='$m527r136', m527r137='$m527r137', m527r138='$m527r138',
  m527r139='$m527r139', m527r1310='$m527r1310',
  m527r141='$m527r141', m527r142='$m527r142', m527r143='$m527r143', m527r144='$m527r144',
  m527r145='$m527r145', m527r146='$m527r146', m527r147='$m527r147', m527r148='$m527r148',
  m527r149='$m527r149', m527r1410='$m527r1410',
  m527r151='$m527r151', m527r152='$m527r152', m527r153='$m527r153', m527r154='$m527r154',
  m527r155='$m527r155', m527r156='$m527r156', m527r157='$m527r157', m527r158='$m527r158',
  m527r159='$m527r159', m527r1510='$m527r1510',
  m527r161='$m527r161', m527r162='$m527r162', m527r163='$m527r163', m527r164='$m527r164',
  m527r165='$m527r165', m527r166='$m527r166', m527r167='$m527r167', m527r168='$m527r168',
  m527r169='$m527r169', m527r1610='$m527r1610',
  m527r171='$m527r171', m527r172='$m527r172', m527r173='$m527r173', m527r174='$m527r174',
  m527r175='$m527r175', m527r176='$m527r176', m527r177='$m527r177', m527r178='$m527r178',
  m527r179='$m527r179', m527r1710='$m527r1710' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 12 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m527r181='$m527r181', m527r182='$m527r182', m527r183='$m527r183', m527r184='$m527r184',
  m527r185='$m527r185', m527r186='$m527r186', m527r187='$m527r187', m527r188='$m527r188',
  m527r1810='$m527r1810',
  m527r191='$m527r191', m527r192='$m527r192', m527r193='$m527r193', m527r194='$m527r194',
  m527r195='$m527r195', m527r196='$m527r196', m527r197='$m527r197', m527r198='$m527r198',
  m527r1910='$m527r1910',
  m527r201='$m527r201', m527r202='$m527r202', m527r203='$m527r203', m527r204='$m527r204',
  m527r205='$m527r205', m527r206='$m527r206', m527r207='$m527r207', m527r208='$m527r208',
  m527r2010='$m527r2010',
  m527r211='$m527r211', m527r212='$m527r212', m527r213='$m527r213', m527r214='$m527r214',
  m527r215='$m527r215', m527r216='$m527r216', m527r217='$m527r217', m527r218='$m527r218',
  m527r2110='$m527r2110',
  m527r221='$m527r221', m527r222='$m527r222', m527r223='$m527r223', m527r224='$m527r224',
  m527r225='$m527r225', m527r226='$m527r226', m527r227='$m527r227', m527r228='$m527r228',
  m527r2210='$m527r2210',
  m527r231='$m527r231', m527r232='$m527r232', m527r233='$m527r233', m527r234='$m527r234',
  m527r235='$m527r235', m527r236='$m527r236', m527r237='$m527r237', m527r238='$m527r238',
  m527r2310='$m527r2310',
  m527r241='$m527r241', m527r242='$m527r242', m527r243='$m527r243', m527r244='$m527r244',
  m527r245='$m527r245', m527r246='$m527r246', m527r247='$m527r247', m527r248='$m527r248',
  m527r2410='$m527r2410',
  m527r991='$m527r991', m527r992='$m527r992', m527r993='$m527r993', m527r994='$m527r994',
  m527r995='$m527r995', m527r996='$m527r996', m527r997='$m527r997', m527r998='$m527r998',
  m527r999='$m527r999', m527r9910='$m527r9910' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 13 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m474r11='$m474r11', m474r12='$m474r12', m474r13='$m474r13',
  m474r21='$m474r21', m474r22='$m474r22', m474r23='$m474r23',
  m474r31='$m474r31', m474r32='$m474r32', m474r33='$m474r33',
  m474r41='$m474r41', m474r42='$m474r42', m474r43='$m474r43',
  m474r51='$m474r51', m474r52='$m474r52', m474r53='$m474r53',
  m474r61='$m474r61', m474r62='$m474r62', m474r63='$m474r63',
  m474r72='$m474r72', m474r73='$m474r73',
  m474r991='$m474r991', m474r992='$m474r992', m474r993='$m474r993',
  m514r1='$m514r1', m514r2='$m514r2', m514r3='$m514r3', m514r99='$m514r99' ".
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
//4.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m398r991=m398r11+m398r21, m398r992=m398r12+m398r22, m398r993=m398r13+m398r23, m398r994=m398r14+m398r24  ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 

//4.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m406r99=m406r1+m406r2+m406r3+m406r4+m406r5+m406r6+m406r7, ".
" m405r81=m405r11-m405r31, m405r82=m405r12-m405r32, ".
" m405r991=m405r11+m405r21+m405r31+m405r41+m405r51+m405r61+m405r71+m405r81, ".
" m405r992=m405r12+m405r32+m405r82  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");
//5.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m558r99=m558r1+m558r2+m558r3+m558r4+m558r5+m558r6+m558r7+m558r8+m558r9+m558r10+".
" m558r11+m558r12+m558r13+m558r14+m558r15+m558r16+m558r17+m558r18 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//9.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m586r991=m586r11+m586r21+m586r131+m586r141+m586r151+m586r191+m586r201, ".
" m586r992=m586r12+m586r22+m586r132+m586r142+m586r152+m586r192+m586r202  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//6.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m581r99=m581r1+m581r2+m581r3+m581r4+m581r5+m581r6+m581r7+m581r8+m581r9+m581r10+m581r11+m581r12 ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//7.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m513r999=m513r19+m513r29+m513r39+m513r49+m513r59+m513r69+m513r79+m513r89+m513r99+m513r109+m513r119+m513r129+m513r139+m513r149+m513r159+m513r169+m513r229, ".
" m513r998=m513r18+m513r28+m513r38+m513r48+m513r58+m513r68+m513r78+m513r88+m513r98+m513r108+m513r118+m513r128+m513r138+m513r148+m513r158+m513r168+m513r228, ".
" m513r997=m513r17+m513r27+m513r37+m513r47+m513r57+m513r67+m513r77+m513r87+m513r97+m513r107+m513r117+m513r127+m513r137+m513r147+m513r157+m513r167+m513r177+m513r187+m513r197+m513r207+m513r217+m513r227, ".
" m513r996=m513r16+m513r26+m513r36+m513r46+m513r56+m513r66+m513r76+m513r86+m513r96+m513r106+m513r116+m513r126+m513r136+m513r146+m513r156+m513r166+m513r176+m513r186+m513r196+m513r206+m513r216+m513r226, ".
" m513r995=m513r15+m513r25+m513r35+m513r45+m513r55+m513r65+m513r75+m513r85+m513r95+m513r105+m513r115+m513r125+m513r135+m513r145+m513r155+m513r165+m513r175+m513r185+m513r195+m513r205+m513r215+m513r225, ".
" m513r994=m513r14+m513r24+m513r34+m513r44+m513r54+m513r64+m513r74+m513r84+m513r94+m513r104+m513r114+m513r124+m513r134+m513r144+m513r154+m513r164+m513r174+m513r184+m513r194+m513r204+m513r214+m513r224, ".
" m513r993=m513r13+m513r23+m513r33+m513r43+m513r53+m513r63+m513r73+m513r83+m513r93+m513r103+m513r113+m513r123+m513r133+m513r143+m513r153+m513r163+m513r173+m513r183+m513r193+m513r203+m513r213+m513r223, ".
" m513r992=m513r12+m513r22+m513r32+m513r42+m513r52+m513r62+m513r72+m513r82+m513r92+m513r102+m513r112+m513r122+m513r132+m513r142+m513r152+m513r162+m513r222, ".
" m513r991=m513r11+m513r21+m513r31+m513r41+m513r51+m513r61+m513r71+m513r81+m513r91+m513r101+m513r111+m513r121+m513r131+m513r141+m513r151+m513r161+m513r171+m513r181+m513r191+m513r201+m513r211+m513r221 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//8.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".
" m516r997=m516r17+m516r27+m516r37+m516r47+m516r57+m516r67+m516r77+m516r87+m516r97+m516r107+m516r117+m516r127+m516r137+m516r147+m516r157+m516r167+m516r177+m516r187+m516r197+m516r207+m516r217+m516r227, ".
" m516r996=m516r16+m516r26+m516r36+m516r46+m516r66+m516r76+m516r86+m516r96+m516r106+m516r116+m516r126+m516r136+m516r146+m516r156+m516r166+m516r206+m516r216+m516r226, ".
" m516r995=m516r15+m516r25+m516r35+m516r45+m516r55+m516r65+m516r75+m516r85+m516r95+m516r105+m516r115+m516r125+m516r135+m516r145+m516r155+m516r165+m516r175+m516r185+m516r195+m516r205+m516r215+m516r225, ".
" m516r994=m516r14+m516r24+m516r34+m516r44+m516r54+m516r64+m516r74+m516r84+m516r94+m516r104+m516r114+m516r124+m516r134+m516r144+m516r154+m516r164+m516r174+m516r184+m516r194+m516r204+m516r214+m516r224, ".
" m516r993=m516r13+m516r23+m516r33+m516r43+m516r53+m516r63+m516r73+m516r83+m516r93+m516r103+m516r113+m516r123+m516r133+m516r143+m516r153+m516r163+m516r223, ".
" m516r992=m516r12+m516r22+m516r32+m516r42+m516r62+m516r72+m516r82+m516r92+m516r102+m516r112+m516r122+m516r132+m516r142+m516r152+m516r162+m516r172+m516r182+m516r192+m516r202+m516r212+m516r222, ".
" m516r991=m516r11+m516r21+m516r31+m516r41+m516r51+m516r61+m516r71+m516r81+m516r91+m516r101+m516r111+m516r121+m516r131+m516r141+m516r151+m516r161+m516r171+m516r181+m516r191+m516r201+m516r211+m516r221 ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");

//9.strana
//dopyt, zrusene v2015
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101 SET ".

" m572r991=m572r11+m572r21+m572r111+m572r121+m572r131+m572r141+m572r151+m572r161+m572r181+m572r211, ".
" m572r992=m572r12+m572r22+m572r112+m572r122+m572r132+m572r142+m572r152+m572r162+m572r182+m572r212, ".
" m572r993=m572r13+m572r23+m572r113+m572r123+m572r133+m572r143+m572r153+m572r163+m572r183+m572r213, ".

" m572r994=m572r14+m572r114+m572r124+m572r134+m572r144+m572r154, ".
" m572r995=m572r15+m572r25+m572r115+m572r125+m572r135+m572r145+m572r155+m572r165, ".
" m572r996=m572r16+m572r26+m572r116+m572r126+m572r136+m572r146+m572r156+m572r166, ".
" m572r997=m572r17+m572r27+m572r117+m572r127+m572r137+m572r147+m572r157+m572r167, ".

" m572r998=m572r18+m572r28+m572r38+m572r48+m572r58+m572r68+m572r78+m572r88+m572r98+m572r108 ".
" +m572r118+m572r128+m572r138+m572r148+m572r158+m572r168+m572r178+m572r188+m572r198+m572r208+m572r218+m572r228+m572r238+m572r248, ".
" m572r999=m572r19+m572r29+m572r39+m572r49+m572r59+m572r69+m572r79+m572r89+m572r99+m572r109 ".
" +m572r119+m572r129+m572r139+m572r149+m572r159+m572r169+m572r179+m572r189+m572r199+m572r209+m572r219+m572r229+m572r239+m572r249, ".

" m572r9910=m572r110+m572r210+m572r310+m572r410+m572r510+m572r610+m572r710+m572r810+m572r910+m572r1010 ".
" +m572r1110+m572r1210+m572r1310+m572r1410+m572r1510+m572r1610+m572r1710+m572r1810+m572r1910+m572r2010+m572r2110+m572r2210+m572r2310+m572r2410, ".
" m572r9911=m572r0111+m572r0211+m572r311+m572r411+m572r511+m572r611+m572r711+m572r811+m572r911+m572r1011 ".
" +m572r1111+m572r1211+m572r1311+m572r1411+m572r1511+m572r1611+m572r1711+m572r1811+m572r1911+m572r2011+m572r2111+m572r2211+m572r2311+m572r2411  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//10.strana
//dopyt, zrusene v2015
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".

" m573r991=m573r11+m573r21+m573r81+m573r91+m573r111+m573r121+m573r131+m573r141+m573r151+m573r161+m573r221+m573r231, ".
" m573r992=m573r12+m573r22+m573r82+m573r92+m573r112+m573r122+m573r132+m573r142+m573r152+m573r162+m573r222+m573r232, ".
" m573r993=m573r13+m573r23+m573r83+m573r93+m573r113+m573r123+m573r133+m573r143+m573r153+m573r163+m573r223+m573r233, ".
" m573r994=m573r14+m573r24+m573r84+m573r94+m573r114+m573r124+m573r134+m573r144+m573r154+m573r164+m573r224+m573r234, ".

" m573r995=m573r15+m573r25+m573r35+m573r45+m573r55+m573r65+m573r75+m573r85+m573r95+m573r105 ".
" +m573r115+m573r125+m573r135+m573r145+m573r155+m573r165+m573r175+m573r185+m573r195+m573r205+m573r215+m573r225+m573r235+m573r245, ".
" m573r996=m573r16+m573r26+m573r36+m573r46+m573r56+m573r66+m573r76+m573r86+m573r96+m573r106 ".
" +m573r116+m573r126+m573r136+m573r146+m573r156+m573r166+m573r176+m573r186+m573r196+m573r206+m573r216+m573r226+m573r236+m573r246, ".
" m573r997=m573r17+m573r27+m573r37+m573r47+m573r57+m573r67+m573r77+m573r87+m573r97+m573r107 ".
" +m573r117+m573r127+m573r137+m573r147+m573r157+m573r167+m573r177+m573r187+m573r197+m573r207+m573r217+m573r227+m573r237+m573r247, ".

" m573r998=m573r18+m573r28+m573r38+m573r48+m573r58+m573r68+m573r78+m573r88+m573r98+m573r108 ".
" +m573r118+m573r128+m573r138+m573r148+m573r158+m573r168+m573r178+m573r188+m573r198+m573r208+m573r218+m573r228+m573r238+m573r248  ".
" WHERE ico >= 0";
$upravene = mysql_query("$uprtxt");


//10.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m19r99=m19r1+m19r2+m19r3+m19r4+m19r5+m19r6+m19r7+m19r8+m19r9+m19r10+m19r11+m19r12 ";
$upravene = mysql_query("$uprtxt");

//11. a 12.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m527r9910=m527r110+m527r210+m527r310+m527r410+m527r510+m527r610+m527r710+m527r810+m527r910+m527r1010+m527r1110+m527r1210+m527r1310+m527r1410+m527r1510+m527r1610+m527r1710+m527r1810+m527r1910+m527r2010+m527r2110+m527r2210+m527r2310+m527r2410, ".
" m527r999=m527r19+m527r29+m527r39+m527r49+m527r59+m527r69+m527r79+m527r89+m527r99+m527r109+m527r119+m527r129+m527r139+m527r149+m527r159+m527r169+m527r179, ".
" m527r998=m527r18+m527r28+m527r38+m527r48+m527r58+m527r68+m527r78+m527r88+m527r98+m527r108+m527r118+m527r128+m527r138+m527r148+m527r158+m527r168+m527r178+m527r188+m527r198+m527r208+m527r218+m527r228+m527r238+m527r248, ".
" m527r997=m527r17+m527r27+m527r37+m527r47+m527r57+m527r67+m527r77+m527r87+m527r97+m527r107+m527r117+m527r127+m527r137+m527r147+m527r157+m527r167+m527r177+m527r187+m527r197+m527r207+m527r217+m527r227+m527r237+m527r247, ".
" m527r996=m527r16+m527r26+m527r36+m527r46+m527r56+m527r66+m527r76+m527r86+m527r96+m527r106+m527r116+m527r126+m527r136+m527r146+m527r156+m527r166+m527r176+m527r186+m527r196+m527r206+m527r216+m527r226+m527r236+m527r246, ".
" m527r995=m527r15+m527r25+m527r35+m527r45+m527r55+m527r65+m527r75+m527r85+m527r95+m527r105+m527r115+m527r125+m527r135+m527r145+m527r155+m527r165+m527r175+m527r185+m527r195+m527r205+m527r215+m527r225+m527r235+m527r245, ".
" m527r994=m527r14+m527r24+m527r34+m527r44+m527r54+m527r64+m527r74+m527r84+m527r94+m527r104+m527r114+m527r124+m527r134+m527r144+m527r154+m527r164+m527r174+m527r184+m527r194+m527r204+m527r214+m527r224+m527r234+m527r244, ".
" m527r993=m527r13+m527r23+m527r33+m527r43+m527r53+m527r63+m527r73+m527r83+m527r93+m527r103+m527r113+m527r123+m527r133+m527r143+m527r153+m527r163+m527r173+m527r183+m527r193+m527r203+m527r213+m527r223+m527r233+m527r243, ".
" m527r992=m527r12+m527r22+m527r32+m527r42+m527r52+m527r62+m527r72+m527r82+m527r92+m527r102+m527r112+m527r122+m527r132+m527r142+m527r152+m527r162+m527r172+m527r182+m527r192+m527r202+m527r212+m527r222+m527r232+m527r242, ".
" m527r991=m527r11+m527r21+m527r31+m527r41+m527r51+m527r61+m527r71+m527r81+m527r91+m527r101+m527r111+m527r121+m527r131+m527r141+m527r151+m527r161+m527r171+m527r181+m527r191+m527r201+m527r211+m527r221+m527r231+m527r241  ";
$upravene = mysql_query("$uprtxt");


//13.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_vts101s2 SET ".
" m514r99=m514r1+m514r2+m514r3, ".

" m474r993=m474r13+m474r23+m474r33+m474r43+m474r53+m474r63+m474r73, ".
" m474r992=m474r12+m474r22+m474r32+m474r42+m474r52+m474r62+m474r72, ".
" m474r991=m474r11+m474r21+m474r31+m474r41+m474r51+m474r61 ";
$upravene = mysql_query("$uprtxt");



//Pripadne dalsie vypocty:
//modul 513: riadky 1 a 7
//modul 516: riadok 1 a stlpec 1
//modul 572: riadok 1 a 15
//modul 573: riadok 1 a 15
//modul 527: riadok 1,12,18 a stlpec 1

//koniec vypocty

//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_vts101 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
//1.strana
$odoslane_sk = SkDatum($fir_riadok->odoslane);
$cinnost = $fir_riadok->cinnost;
//2.strana
$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;
$mod100041ano = $fir_riadok->mod100041ano;
$mod100041nie = $fir_riadok->mod100041nie;
$mod100042ano = $fir_riadok->mod100042ano;
$mod100042nie = $fir_riadok->mod100042nie;
$mod100043ano = $fir_riadok->mod100043ano;
$mod100043nie = $fir_riadok->mod100043nie;
$m1100r4 = $fir_riadok->m1100r4;
$m1100r5 = $fir_riadok->m1100r5;
$m1100r6 = $fir_riadok->m1100r6;
$m1100r7 = $fir_riadok->m1100r7;
$m1100r8 = $fir_riadok->m1100r8;
$m1100r9 = $fir_riadok->m1100r9;
$m1100r10 = $fir_riadok->m1100r10;
$m1100r11 = $fir_riadok->m1100r11;
$m1100r12 = $fir_riadok->m1100r12;
$m1100r13 = $fir_riadok->m1100r13;
$mod100036kal = $fir_riadok->mod100036kal;
$mod100036hos = $fir_riadok->mod100036hos;
//3.strana
$mod100037 = $fir_riadok->mod100037;
$m100214r01 = $fir_riadok->m100214r01;
$m100214r02 = $fir_riadok->m100214r02;
$mod100069ano = $fir_riadok->mod100069ano;
$mod100069nie = $fir_riadok->mod100069nie;
$m1101r2 = $fir_riadok->m1101r2;
$m1101r3 = $fir_riadok->m1101r3;
$m1101r4a = $fir_riadok->m1101r4a;
$m1101r4b = $fir_riadok->m1101r4b;
$m1101r5a = $fir_riadok->m1101r5a;
$m1101r5b = $fir_riadok->m1101r5b;
$m1101r6a = $fir_riadok->m1101r6a;
$m1101r6b = $fir_riadok->m1101r6b;
$m1101r7a = $fir_riadok->m1101r7a;
$m1101r7b = $fir_riadok->m1101r7b;
//4.strana
$m398r11 = $fir_riadok->m398r11;
$m398r12 = $fir_riadok->m398r12;
$m398r13 = $fir_riadok->m398r13;
$m398r14 = $fir_riadok->m398r14;
$m398r21 = $fir_riadok->m398r21;
$m398r22 = $fir_riadok->m398r22;
$m398r23 = $fir_riadok->m398r23;
$m398r24 = $fir_riadok->m398r24;
$m398r991 = $fir_riadok->m398r991;
$m398r992 = $fir_riadok->m398r992;
$m398r993 = $fir_riadok->m398r993;
$m398r994 = $fir_riadok->m398r994;
$m1005r1a = $fir_riadok->m1005r1a;
$m1005r1b = $fir_riadok->m1005r1b;
$m405r11 = $fir_riadok->m405r11;
$m405r12 = $fir_riadok->m405r12;
$m405r21 = $fir_riadok->m405r21;
$m405r31 = $fir_riadok->m405r31;
$m405r32 = $fir_riadok->m405r32;
$m405r41 = $fir_riadok->m405r41;
$m405r51 = $fir_riadok->m405r51;
$m405r61 = $fir_riadok->m405r61;
$m405r71 = $fir_riadok->m405r71;
$m405r81 = $fir_riadok->m405r81;
$m405r82 = $fir_riadok->m405r82;
$m405r991 = $fir_riadok->m405r991;
$m405r992 = $fir_riadok->m405r992;
$m406r1 = $fir_riadok->m406r1;
$m406r2 = $fir_riadok->m406r2;
$m406r3 = $fir_riadok->m406r3;
$m406r4 = $fir_riadok->m406r4;
$m406r5 = $fir_riadok->m406r5;
$m406r6 = $fir_riadok->m406r6;
$m406r7 = $fir_riadok->m406r7;
$m406r99 = $fir_riadok->m406r99;
//5.strana
$m558r1 = $fir_riadok->m558r1;
$m558r2 = $fir_riadok->m558r2;
$m558r3 = $fir_riadok->m558r3;
$m558r4 = $fir_riadok->m558r4;
$m558r5 = $fir_riadok->m558r5;
$m558r6 = $fir_riadok->m558r6;
$m558r7 = $fir_riadok->m558r7;
$m558r8 = $fir_riadok->m558r8;
$m558r9 = $fir_riadok->m558r9;
$m558r10 = $fir_riadok->m558r10;
$m558r11 = $fir_riadok->m558r11;
$m558r12 = $fir_riadok->m558r12;
$m558r13 = $fir_riadok->m558r13;
$m558r14 = $fir_riadok->m558r14;
$m558r15 = $fir_riadok->m558r15;
$m558r16 = $fir_riadok->m558r16;
$m558r17 = $fir_riadok->m558r17;
$m558r18 = $fir_riadok->m558r18;
$m558r99 = $fir_riadok->m558r99;
$m585r01 = $fir_riadok->m585r01;
$m585r02 = $fir_riadok->m585r02;
$m585r03 = $fir_riadok->m585r03;
$m585r04 = $fir_riadok->m585r04;
$m585r05 = $fir_riadok->m585r05;
$m585r3k = $fir_riadok->m585r3k;
$m585r4k = $fir_riadok->m585r4k;
$m585r5k = $fir_riadok->m585r5k;
$m100044ano = $fir_riadok->m100044ano;
$m100044nie = $fir_riadok->m100044nie;
//6.strana
$m571r10 = $fir_riadok->m571r10;
$m571r12 = $fir_riadok->m571r12;
$m571r13 = $fir_riadok->m571r13;
$m571r15 = $fir_riadok->m571r15;
$m571r16 = $fir_riadok->m571r16;
$m571r17 = $fir_riadok->m571r17;
$m571r18 = $fir_riadok->m571r18;
$m571r20 = $fir_riadok->m571r20;
$m571r22 = $fir_riadok->m571r22;
$m571r23 = $fir_riadok->m571r23;
$m571r25 = $fir_riadok->m571r25;
$m571r26 = $fir_riadok->m571r26;
$m571r27 = $fir_riadok->m571r27;
$m571r28 = $fir_riadok->m571r28;
$m571r30 = $fir_riadok->m571r30;
$m571r32 = $fir_riadok->m571r32;
$m571r33 = $fir_riadok->m571r33;
$m571r35 = $fir_riadok->m571r35;
$m571r36 = $fir_riadok->m571r36;
$m571r37 = $fir_riadok->m571r37;
$m571r38 = $fir_riadok->m571r38;
$m571r40 = $fir_riadok->m571r40;
$m571r42 = $fir_riadok->m571r42;
$m571r43 = $fir_riadok->m571r43;
$m571r45 = $fir_riadok->m571r45;
$m571r46 = $fir_riadok->m571r46;
$m571r47 = $fir_riadok->m571r47;
$m571r48 = $fir_riadok->m571r48;
$m571r50 = $fir_riadok->m571r50;
$m571r52 = $fir_riadok->m571r52;
$m571r53 = $fir_riadok->m571r53;
$m571r55 = $fir_riadok->m571r55;
$m571r56 = $fir_riadok->m571r56;
$m571r57 = $fir_riadok->m571r57;
$m571r58 = $fir_riadok->m571r58;
$m571r60 = $fir_riadok->m571r60;
$m571r62 = $fir_riadok->m571r62;
$m571r63 = $fir_riadok->m571r63;
$m571r65 = $fir_riadok->m571r65;
$m571r66 = $fir_riadok->m571r66;
$m571r67 = $fir_riadok->m571r67;
$m571r68 = $fir_riadok->m571r68;
$m571r70 = $fir_riadok->m571r70;
$m571r72 = $fir_riadok->m571r72;
$m571r73 = $fir_riadok->m571r73;
$m571r75 = $fir_riadok->m571r75;
$m571r76 = $fir_riadok->m571r76;
$m571r77 = $fir_riadok->m571r77;
$m571r78 = $fir_riadok->m571r78;
$m571r80 = $fir_riadok->m571r80;
$m571r82 = $fir_riadok->m571r82;
$m571r83 = $fir_riadok->m571r83;
$m571r85 = $fir_riadok->m571r85;
$m571r86 = $fir_riadok->m571r86;
$m571r87 = $fir_riadok->m571r87;
$m571r88 = $fir_riadok->m571r88;
$m571r90 = $fir_riadok->m571r90;
$m571r92 = $fir_riadok->m571r92;
$m571r93 = $fir_riadok->m571r93;
$m571r95 = $fir_riadok->m571r95;
$m571r96 = $fir_riadok->m571r96;
$m571r97 = $fir_riadok->m571r97;
$m571r98 = $fir_riadok->m571r98;
$m581r1 = $fir_riadok->m581r1;
$m581r2 = $fir_riadok->m581r2;
$m581r3 = $fir_riadok->m581r3;
$m581r4 = $fir_riadok->m581r4;
$m581r5 = $fir_riadok->m581r5;
$m581r6 = $fir_riadok->m581r6;
$m581r7 = $fir_riadok->m581r7;
$m581r8 = $fir_riadok->m581r8;
$m581r12 = $fir_riadok->m581r12;
$m581r99 = $fir_riadok->m581r99;
//7.strana
$m513r11 = $fir_riadok->m513r11;
$m513r12 = $fir_riadok->m513r12;
$m513r13 = $fir_riadok->m513r13;
$m513r14 = $fir_riadok->m513r14;
$m513r15 = $fir_riadok->m513r15;
$m513r16 = $fir_riadok->m513r16;
$m513r17 = $fir_riadok->m513r17;
$m513r18 = $fir_riadok->m513r18;
$m513r19 = $fir_riadok->m513r19;
$m513r21 = $fir_riadok->m513r21;
$m513r22 = $fir_riadok->m513r22;
$m513r23 = $fir_riadok->m513r23;
$m513r24 = $fir_riadok->m513r24;
$m513r25 = $fir_riadok->m513r25;
$m513r26 = $fir_riadok->m513r26;
$m513r27 = $fir_riadok->m513r27;
$m513r28 = $fir_riadok->m513r28;
$m513r29 = $fir_riadok->m513r29;
$m513r31 = $fir_riadok->m513r31;
$m513r32 = $fir_riadok->m513r32;
$m513r33 = $fir_riadok->m513r33;
$m513r34 = $fir_riadok->m513r34;
$m513r35 = $fir_riadok->m513r35;
$m513r36 = $fir_riadok->m513r36;
$m513r37 = $fir_riadok->m513r37;
$m513r38 = $fir_riadok->m513r38;
$m513r39 = $fir_riadok->m513r39;
$m513r41 = $fir_riadok->m513r41;
$m513r42 = $fir_riadok->m513r42;
$m513r43 = $fir_riadok->m513r43;
$m513r44 = $fir_riadok->m513r44;
$m513r45 = $fir_riadok->m513r45;
$m513r46 = $fir_riadok->m513r46;
$m513r47 = $fir_riadok->m513r47;
$m513r48 = $fir_riadok->m513r48;
$m513r49 = $fir_riadok->m513r49;
$m513r51 = $fir_riadok->m513r51;
$m513r52 = $fir_riadok->m513r52;
$m513r53 = $fir_riadok->m513r53;
$m513r54 = $fir_riadok->m513r54;
$m513r55 = $fir_riadok->m513r55;
$m513r56 = $fir_riadok->m513r56;
$m513r57 = $fir_riadok->m513r57;
$m513r58 = $fir_riadok->m513r58;
$m513r59 = $fir_riadok->m513r59;
$m513r61 = $fir_riadok->m513r61;
$m513r62 = $fir_riadok->m513r62;
$m513r63 = $fir_riadok->m513r63;
$m513r64 = $fir_riadok->m513r64;
$m513r65 = $fir_riadok->m513r65;
$m513r66 = $fir_riadok->m513r66;
$m513r67 = $fir_riadok->m513r67;
$m513r68 = $fir_riadok->m513r68;
$m513r69 = $fir_riadok->m513r69;
$m513r71 = $fir_riadok->m513r71;
$m513r72 = $fir_riadok->m513r72;
$m513r73 = $fir_riadok->m513r73;
$m513r74 = $fir_riadok->m513r74;
$m513r75 = $fir_riadok->m513r75;
$m513r76 = $fir_riadok->m513r76;
$m513r77 = $fir_riadok->m513r77;
$m513r78 = $fir_riadok->m513r78;
$m513r79 = $fir_riadok->m513r79;
$m513r81 = $fir_riadok->m513r81;
$m513r82 = $fir_riadok->m513r82;
$m513r83 = $fir_riadok->m513r83;
$m513r84 = $fir_riadok->m513r84;
$m513r85 = $fir_riadok->m513r85;
$m513r86 = $fir_riadok->m513r86;
$m513r87 = $fir_riadok->m513r87;
$m513r88 = $fir_riadok->m513r88;
$m513r89 = $fir_riadok->m513r89;
$m513r91 = $fir_riadok->m513r91;
$m513r92 = $fir_riadok->m513r92;
$m513r93 = $fir_riadok->m513r93;
$m513r94 = $fir_riadok->m513r94;
$m513r95 = $fir_riadok->m513r95;
$m513r96 = $fir_riadok->m513r96;
$m513r97 = $fir_riadok->m513r97;
$m513r98 = $fir_riadok->m513r98;
$m513r99 = $fir_riadok->m513r99;
$m513r101 = $fir_riadok->m513r101;
$m513r102 = $fir_riadok->m513r102;
$m513r103 = $fir_riadok->m513r103;
$m513r104 = $fir_riadok->m513r104;
$m513r105 = $fir_riadok->m513r105;
$m513r106 = $fir_riadok->m513r106;
$m513r107 = $fir_riadok->m513r107;
$m513r108 = $fir_riadok->m513r108;
$m513r109 = $fir_riadok->m513r109;
$m513r111 = $fir_riadok->m513r111;
$m513r112 = $fir_riadok->m513r112;
$m513r113 = $fir_riadok->m513r113;
$m513r114 = $fir_riadok->m513r114;
$m513r115 = $fir_riadok->m513r115;
$m513r116 = $fir_riadok->m513r116;
$m513r117 = $fir_riadok->m513r117;
$m513r118 = $fir_riadok->m513r118;
$m513r119 = $fir_riadok->m513r119;
$m513r121 = $fir_riadok->m513r121;
$m513r122 = $fir_riadok->m513r122;
$m513r123 = $fir_riadok->m513r123;
$m513r124 = $fir_riadok->m513r124;
$m513r125 = $fir_riadok->m513r125;
$m513r126 = $fir_riadok->m513r126;
$m513r127 = $fir_riadok->m513r127;
$m513r128 = $fir_riadok->m513r128;
$m513r129 = $fir_riadok->m513r129;
$m513r131 = $fir_riadok->m513r131;
$m513r132 = $fir_riadok->m513r132;
$m513r133 = $fir_riadok->m513r133;
$m513r134 = $fir_riadok->m513r134;
$m513r135 = $fir_riadok->m513r135;
$m513r136 = $fir_riadok->m513r136;
$m513r137 = $fir_riadok->m513r137;
$m513r138 = $fir_riadok->m513r138;
$m513r139 = $fir_riadok->m513r139;
$m513r141 = $fir_riadok->m513r141;
$m513r142 = $fir_riadok->m513r142;
$m513r143 = $fir_riadok->m513r143;
$m513r144 = $fir_riadok->m513r144;
$m513r145 = $fir_riadok->m513r145;
$m513r146 = $fir_riadok->m513r146;
$m513r147 = $fir_riadok->m513r147;
$m513r148 = $fir_riadok->m513r148;
$m513r149 = $fir_riadok->m513r149;
$m513r151 = $fir_riadok->m513r151;
$m513r152 = $fir_riadok->m513r152;
$m513r153 = $fir_riadok->m513r153;
$m513r154 = $fir_riadok->m513r154;
$m513r155 = $fir_riadok->m513r155;
$m513r156 = $fir_riadok->m513r156;
$m513r157 = $fir_riadok->m513r157;
$m513r158 = $fir_riadok->m513r158;
$m513r159 = $fir_riadok->m513r159;
$m513r161 = $fir_riadok->m513r161;
$m513r162 = $fir_riadok->m513r162;
$m513r163 = $fir_riadok->m513r163;
$m513r164 = $fir_riadok->m513r164;
$m513r165 = $fir_riadok->m513r165;
$m513r166 = $fir_riadok->m513r166;
$m513r167 = $fir_riadok->m513r167;
$m513r168 = $fir_riadok->m513r168;
$m513r169 = $fir_riadok->m513r169;
$m513r171 = $fir_riadok->m513r171;
$m513r173 = $fir_riadok->m513r173;
$m513r174 = $fir_riadok->m513r174;
$m513r175 = $fir_riadok->m513r175;
$m513r176 = $fir_riadok->m513r176;
$m513r177 = $fir_riadok->m513r177;
$m513r181 = $fir_riadok->m513r181;
$m513r183 = $fir_riadok->m513r183;
$m513r184 = $fir_riadok->m513r184;
$m513r185 = $fir_riadok->m513r185;
$m513r186 = $fir_riadok->m513r186;
$m513r187 = $fir_riadok->m513r187;
$m513r191 = $fir_riadok->m513r191;
$m513r193 = $fir_riadok->m513r193;
$m513r194 = $fir_riadok->m513r194;
$m513r195 = $fir_riadok->m513r195;
$m513r196 = $fir_riadok->m513r196;
$m513r197 = $fir_riadok->m513r197;
$m513r201 = $fir_riadok->m513r201;
$m513r203 = $fir_riadok->m513r203;
$m513r204 = $fir_riadok->m513r204;
$m513r205 = $fir_riadok->m513r205;
$m513r206 = $fir_riadok->m513r206;
$m513r207 = $fir_riadok->m513r207;
$m513r211 = $fir_riadok->m513r211;
$m513r213 = $fir_riadok->m513r213;
$m513r214 = $fir_riadok->m513r214;
$m513r215 = $fir_riadok->m513r215;
$m513r216 = $fir_riadok->m513r216;
$m513r217 = $fir_riadok->m513r217;
$m513r221 = $fir_riadok->m513r221;
$m513r222 = $fir_riadok->m513r222;
$m513r223 = $fir_riadok->m513r223;
$m513r224 = $fir_riadok->m513r224;
$m513r225 = $fir_riadok->m513r225;
$m513r226 = $fir_riadok->m513r226;
$m513r227 = $fir_riadok->m513r227;
$m513r228 = $fir_riadok->m513r228;
$m513r229 = $fir_riadok->m513r229;
$m513r991 = $fir_riadok->m513r991;
$m513r992 = $fir_riadok->m513r992;
$m513r993 = $fir_riadok->m513r993;
$m513r994 = $fir_riadok->m513r994;
$m513r995 = $fir_riadok->m513r995;
$m513r996 = $fir_riadok->m513r996;
$m513r997 = $fir_riadok->m513r997;
$m513r998 = $fir_riadok->m513r998;
$m513r999 = $fir_riadok->m513r999;
//8.strana
$m516r11 = $fir_riadok->m516r11;
$m516r12 = $fir_riadok->m516r12;
$m516r13 = $fir_riadok->m516r13;
$m516r14 = $fir_riadok->m516r14;
$m516r15 = $fir_riadok->m516r15;
$m516r16 = $fir_riadok->m516r16;
$m516r17 = $fir_riadok->m516r17;
$m516r21 = $fir_riadok->m516r21;
$m516r22 = $fir_riadok->m516r22;
$m516r23 = $fir_riadok->m516r23;
$m516r24 = $fir_riadok->m516r24;
$m516r25 = $fir_riadok->m516r25;
$m516r26 = $fir_riadok->m516r26;
$m516r27 = $fir_riadok->m516r27;
$m516r31 = $fir_riadok->m516r31;
$m516r32 = $fir_riadok->m516r32;
$m516r33 = $fir_riadok->m516r33;
$m516r34 = $fir_riadok->m516r34;
$m516r35 = $fir_riadok->m516r35;
$m516r36 = $fir_riadok->m516r36;
$m516r37 = $fir_riadok->m516r37;
$m516r41 = $fir_riadok->m516r41;
$m516r42 = $fir_riadok->m516r42;
$m516r43 = $fir_riadok->m516r43;
$m516r44 = $fir_riadok->m516r44;
$m516r45 = $fir_riadok->m516r45;
$m516r46 = $fir_riadok->m516r46;
$m516r47 = $fir_riadok->m516r47;
$m516r51 = $fir_riadok->m516r51;
$m516r53 = $fir_riadok->m516r53;
$m516r54 = $fir_riadok->m516r54;
$m516r55 = $fir_riadok->m516r55;
$m516r57 = $fir_riadok->m516r57;
$m516r61 = $fir_riadok->m516r61;
$m516r62 = $fir_riadok->m516r62;
$m516r63 = $fir_riadok->m516r63;
$m516r64 = $fir_riadok->m516r64;
$m516r65 = $fir_riadok->m516r65;
$m516r66 = $fir_riadok->m516r66;
$m516r67 = $fir_riadok->m516r67;
$m516r71 = $fir_riadok->m516r71;
$m516r72 = $fir_riadok->m516r72;
$m516r73 = $fir_riadok->m516r73;
$m516r74 = $fir_riadok->m516r74;
$m516r75 = $fir_riadok->m516r75;
$m516r76 = $fir_riadok->m516r76;
$m516r77 = $fir_riadok->m516r77;
$m516r81 = $fir_riadok->m516r81;
$m516r82 = $fir_riadok->m516r82;
$m516r83 = $fir_riadok->m516r83;
$m516r84 = $fir_riadok->m516r84;
$m516r85 = $fir_riadok->m516r85;
$m516r86 = $fir_riadok->m516r86;
$m516r87 = $fir_riadok->m516r87;
$m516r91 = $fir_riadok->m516r91;
$m516r92 = $fir_riadok->m516r92;
$m516r93 = $fir_riadok->m516r93;
$m516r94 = $fir_riadok->m516r94;
$m516r95 = $fir_riadok->m516r95;
$m516r96 = $fir_riadok->m516r96;
$m516r97 = $fir_riadok->m516r97;
$m516r101 = $fir_riadok->m516r101;
$m516r102 = $fir_riadok->m516r102;
$m516r103 = $fir_riadok->m516r103;
$m516r104 = $fir_riadok->m516r104;
$m516r105 = $fir_riadok->m516r105;
$m516r106 = $fir_riadok->m516r106;
$m516r107 = $fir_riadok->m516r107;
$m516r111 = $fir_riadok->m516r111;
$m516r112 = $fir_riadok->m516r112;
$m516r113 = $fir_riadok->m516r113;
$m516r114 = $fir_riadok->m516r114;
$m516r115 = $fir_riadok->m516r115;
$m516r116 = $fir_riadok->m516r116;
$m516r117 = $fir_riadok->m516r117;
$m516r121 = $fir_riadok->m516r121;
$m516r122 = $fir_riadok->m516r122;
$m516r123 = $fir_riadok->m516r123;
$m516r124 = $fir_riadok->m516r124;
$m516r125 = $fir_riadok->m516r125;
$m516r126 = $fir_riadok->m516r126;
$m516r127 = $fir_riadok->m516r127;
$m516r131 = $fir_riadok->m516r131;
$m516r132 = $fir_riadok->m516r132;
$m516r133 = $fir_riadok->m516r133;
$m516r134 = $fir_riadok->m516r134;
$m516r135 = $fir_riadok->m516r135;
$m516r136 = $fir_riadok->m516r136;
$m516r137 = $fir_riadok->m516r137;
$m516r141 = $fir_riadok->m516r141;
$m516r142 = $fir_riadok->m516r142;
$m516r143 = $fir_riadok->m516r143;
$m516r144 = $fir_riadok->m516r144;
$m516r145 = $fir_riadok->m516r145;
$m516r146 = $fir_riadok->m516r146;
$m516r147 = $fir_riadok->m516r147;
$m516r151 = $fir_riadok->m516r151;
$m516r152 = $fir_riadok->m516r152;
$m516r153 = $fir_riadok->m516r153;
$m516r154 = $fir_riadok->m516r154;
$m516r155 = $fir_riadok->m516r155;
$m516r156 = $fir_riadok->m516r156;
$m516r157 = $fir_riadok->m516r157;
$m516r161 = $fir_riadok->m516r161;
$m516r162 = $fir_riadok->m516r162;
$m516r163 = $fir_riadok->m516r163;
$m516r164 = $fir_riadok->m516r164;
$m516r165 = $fir_riadok->m516r165;
$m516r166 = $fir_riadok->m516r166;
$m516r167 = $fir_riadok->m516r167;
$m516r171 = $fir_riadok->m516r171;
$m516r172 = $fir_riadok->m516r172;
$m516r174 = $fir_riadok->m516r174;
$m516r175 = $fir_riadok->m516r175;
$m516r177 = $fir_riadok->m516r177;
$m516r181 = $fir_riadok->m516r181;
$m516r182 = $fir_riadok->m516r182;
$m516r184 = $fir_riadok->m516r184;
$m516r185 = $fir_riadok->m516r185;
$m516r187 = $fir_riadok->m516r187;
$m516r191 = $fir_riadok->m516r191;
$m516r192 = $fir_riadok->m516r192;
$m516r194 = $fir_riadok->m516r194;
$m516r195 = $fir_riadok->m516r195;
$m516r197 = $fir_riadok->m516r197;
$m516r201 = $fir_riadok->m516r201;
$m516r202 = $fir_riadok->m516r202;
$m516r204 = $fir_riadok->m516r204;
$m516r205 = $fir_riadok->m516r205;
$m516r206 = $fir_riadok->m516r206;
$m516r207 = $fir_riadok->m516r207;
$m516r211 = $fir_riadok->m516r211;
$m516r212 = $fir_riadok->m516r212;
$m516r214 = $fir_riadok->m516r214;
$m516r215 = $fir_riadok->m516r215;
$m516r216 = $fir_riadok->m516r216;
$m516r217 = $fir_riadok->m516r217;
$m516r221 = $fir_riadok->m516r221;
$m516r222 = $fir_riadok->m516r222;
$m516r223 = $fir_riadok->m516r223;
$m516r224 = $fir_riadok->m516r224;
$m516r225 = $fir_riadok->m516r225;
$m516r226 = $fir_riadok->m516r226;
$m516r227 = $fir_riadok->m516r227;
$m516r991 = $fir_riadok->m516r991;
$m516r992 = $fir_riadok->m516r992;
$m516r993 = $fir_riadok->m516r993;
$m516r994 = $fir_riadok->m516r994;
$m516r995 = $fir_riadok->m516r995;
$m516r996 = $fir_riadok->m516r996;
$m516r997 = $fir_riadok->m516r997;
//9.strana
$m586r11 = $fir_riadok->m586r11;
$m586r12 = $fir_riadok->m586r12;
$m586r21 = $fir_riadok->m586r21;
$m586r22 = $fir_riadok->m586r22;
$m586r131 = $fir_riadok->m586r131;
$m586r132 = $fir_riadok->m586r132;
$m586r141 = $fir_riadok->m586r141;
$m586r142 = $fir_riadok->m586r142;
$m586r151 = $fir_riadok->m586r151;
$m586r152 = $fir_riadok->m586r152;
$m586r191 = $fir_riadok->m586r191;
$m586r192 = $fir_riadok->m586r192;
$m586r201 = $fir_riadok->m586r201;
$m586r202 = $fir_riadok->m586r202;
$m586r991 = $fir_riadok->m586r991;
$m586r992 = $fir_riadok->m586r992;
//10.strana
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);
$m19r1 = $fir_riadok->m19r1;
$m19r2 = $fir_riadok->m19r2;
$m19r3 = $fir_riadok->m19r3;
$m19r4 = $fir_riadok->m19r4;
$m19r5 = $fir_riadok->m19r5;
$m19r6 = $fir_riadok->m19r6;
$m19r7 = $fir_riadok->m19r7;
$m19r8 = $fir_riadok->m19r8;
$m19r9 = $fir_riadok->m19r9;
$m19r10 = $fir_riadok->m19r10;
$m19r11 = $fir_riadok->m19r11;
$m19r12 = $fir_riadok->m19r12;
$m19r99 = $fir_riadok->m19r99;
$m1527r1a = $fir_riadok->m1527r1a;
$m1527r1b = $fir_riadok->m1527r1b;
//11.strana
$m527r11 = $fir_riadok->m527r11;
$m527r12 = $fir_riadok->m527r12;
$m527r13 = $fir_riadok->m527r13;
$m527r14 = $fir_riadok->m527r14;
$m527r15 = $fir_riadok->m527r15;
$m527r16 = $fir_riadok->m527r16;
$m527r17 = $fir_riadok->m527r17;
$m527r18 = $fir_riadok->m527r18;
$m527r19 = $fir_riadok->m527r19;
$m527r110 = $fir_riadok->m527r110;
$m527r21 = $fir_riadok->m527r21;
$m527r22 = $fir_riadok->m527r22;
$m527r23 = $fir_riadok->m527r23;
$m527r24 = $fir_riadok->m527r24;
$m527r25 = $fir_riadok->m527r25;
$m527r26 = $fir_riadok->m527r26;
$m527r27 = $fir_riadok->m527r27;
$m527r28 = $fir_riadok->m527r28;
$m527r29 = $fir_riadok->m527r29;
$m527r210 = $fir_riadok->m527r210;
$m527r31 = $fir_riadok->m527r31;
$m527r32 = $fir_riadok->m527r32;
$m527r33 = $fir_riadok->m527r33;
$m527r34 = $fir_riadok->m527r34;
$m527r35 = $fir_riadok->m527r35;
$m527r36 = $fir_riadok->m527r36;
$m527r37 = $fir_riadok->m527r37;
$m527r38 = $fir_riadok->m527r38;
$m527r39 = $fir_riadok->m527r39;
$m527r310 = $fir_riadok->m527r310;
$m527r41 = $fir_riadok->m527r41;
$m527r42 = $fir_riadok->m527r42;
$m527r43 = $fir_riadok->m527r43;
$m527r44 = $fir_riadok->m527r44;
$m527r45 = $fir_riadok->m527r45;
$m527r46 = $fir_riadok->m527r46;
$m527r47 = $fir_riadok->m527r47;
$m527r48 = $fir_riadok->m527r48;
$m527r49 = $fir_riadok->m527r49;
$m527r410 = $fir_riadok->m527r410;
$m527r51 = $fir_riadok->m527r51;
$m527r52 = $fir_riadok->m527r52;
$m527r53 = $fir_riadok->m527r53;
$m527r54 = $fir_riadok->m527r54;
$m527r55 = $fir_riadok->m527r55;
$m527r56 = $fir_riadok->m527r56;
$m527r57 = $fir_riadok->m527r57;
$m527r58 = $fir_riadok->m527r58;
$m527r59 = $fir_riadok->m527r59;
$m527r510 = $fir_riadok->m527r510;
$m527r61 = $fir_riadok->m527r61;
$m527r62 = $fir_riadok->m527r62;
$m527r63 = $fir_riadok->m527r63;
$m527r64 = $fir_riadok->m527r64;
$m527r65 = $fir_riadok->m527r65;
$m527r66 = $fir_riadok->m527r66;
$m527r67 = $fir_riadok->m527r67;
$m527r68 = $fir_riadok->m527r68;
$m527r69 = $fir_riadok->m527r69;
$m527r610 = $fir_riadok->m527r610;
$m527r71 = $fir_riadok->m527r71;
$m527r72 = $fir_riadok->m527r72;
$m527r73 = $fir_riadok->m527r73;
$m527r74 = $fir_riadok->m527r74;
$m527r75 = $fir_riadok->m527r75;
$m527r76 = $fir_riadok->m527r76;
$m527r77 = $fir_riadok->m527r77;
$m527r78 = $fir_riadok->m527r78;
$m527r79 = $fir_riadok->m527r79;
$m527r710 = $fir_riadok->m527r710;
$m527r81 = $fir_riadok->m527r81;
$m527r82 = $fir_riadok->m527r82;
$m527r83 = $fir_riadok->m527r83;
$m527r84 = $fir_riadok->m527r84;
$m527r85 = $fir_riadok->m527r85;
$m527r86 = $fir_riadok->m527r86;
$m527r87 = $fir_riadok->m527r87;
$m527r88 = $fir_riadok->m527r88;
$m527r89 = $fir_riadok->m527r89;
$m527r810 = $fir_riadok->m527r810;
$m527r91 = $fir_riadok->m527r91;
$m527r92 = $fir_riadok->m527r92;
$m527r93 = $fir_riadok->m527r93;
$m527r94 = $fir_riadok->m527r94;
$m527r95 = $fir_riadok->m527r95;
$m527r96 = $fir_riadok->m527r96;
$m527r97 = $fir_riadok->m527r97;
$m527r98 = $fir_riadok->m527r98;
$m527r99 = $fir_riadok->m527r99;
$m527r910 = $fir_riadok->m527r910;
$m527r101 = $fir_riadok->m527r101;
$m527r102 = $fir_riadok->m527r102;
$m527r103 = $fir_riadok->m527r103;
$m527r104 = $fir_riadok->m527r104;
$m527r105 = $fir_riadok->m527r105;
$m527r106 = $fir_riadok->m527r106;
$m527r107 = $fir_riadok->m527r107;
$m527r108 = $fir_riadok->m527r108;
$m527r109 = $fir_riadok->m527r109;
$m527r1010 = $fir_riadok->m527r1010;
$m527r111 = $fir_riadok->m527r111;
$m527r112 = $fir_riadok->m527r112;
$m527r113 = $fir_riadok->m527r113;
$m527r114 = $fir_riadok->m527r114;
$m527r115 = $fir_riadok->m527r115;
$m527r116 = $fir_riadok->m527r116;
$m527r117 = $fir_riadok->m527r117;
$m527r118 = $fir_riadok->m527r118;
$m527r119 = $fir_riadok->m527r119;
$m527r1110 = $fir_riadok->m527r1110;
$m527r121 = $fir_riadok->m527r121;
$m527r122 = $fir_riadok->m527r122;
$m527r123 = $fir_riadok->m527r123;
$m527r124 = $fir_riadok->m527r124;
$m527r125 = $fir_riadok->m527r125;
$m527r126 = $fir_riadok->m527r126;
$m527r127 = $fir_riadok->m527r127;
$m527r128 = $fir_riadok->m527r128;
$m527r129 = $fir_riadok->m527r129;
$m527r1210 = $fir_riadok->m527r1210;
$m527r131 = $fir_riadok->m527r131;
$m527r132 = $fir_riadok->m527r132;
$m527r133 = $fir_riadok->m527r133;
$m527r134 = $fir_riadok->m527r134;
$m527r135 = $fir_riadok->m527r135;
$m527r136 = $fir_riadok->m527r136;
$m527r137 = $fir_riadok->m527r137;
$m527r138 = $fir_riadok->m527r138;
$m527r139 = $fir_riadok->m527r139;
$m527r1310 = $fir_riadok->m527r1310;
$m527r141 = $fir_riadok->m527r141;
$m527r142 = $fir_riadok->m527r142;
$m527r143 = $fir_riadok->m527r143;
$m527r144 = $fir_riadok->m527r144;
$m527r145 = $fir_riadok->m527r145;
$m527r146 = $fir_riadok->m527r146;
$m527r147 = $fir_riadok->m527r147;
$m527r148 = $fir_riadok->m527r148;
$m527r149 = $fir_riadok->m527r149;
$m527r1410 = $fir_riadok->m527r1410;
$m527r151 = $fir_riadok->m527r151;
$m527r152 = $fir_riadok->m527r152;
$m527r153 = $fir_riadok->m527r153;
$m527r154 = $fir_riadok->m527r154;
$m527r155 = $fir_riadok->m527r155;
$m527r156 = $fir_riadok->m527r156;
$m527r157 = $fir_riadok->m527r157;
$m527r158 = $fir_riadok->m527r158;
$m527r159 = $fir_riadok->m527r159;
$m527r1510 = $fir_riadok->m527r1510;
$m527r161 = $fir_riadok->m527r161;
$m527r162 = $fir_riadok->m527r162;
$m527r163 = $fir_riadok->m527r163;
$m527r164 = $fir_riadok->m527r164;
$m527r165 = $fir_riadok->m527r165;
$m527r166 = $fir_riadok->m527r166;
$m527r167 = $fir_riadok->m527r167;
$m527r168 = $fir_riadok->m527r168;
$m527r169 = $fir_riadok->m527r169;
$m527r1610 = $fir_riadok->m527r1610;
$m527r171 = $fir_riadok->m527r171;
$m527r172 = $fir_riadok->m527r172;
$m527r173 = $fir_riadok->m527r173;
$m527r174 = $fir_riadok->m527r174;
$m527r175 = $fir_riadok->m527r175;
$m527r176 = $fir_riadok->m527r176;
$m527r177 = $fir_riadok->m527r177;
$m527r178 = $fir_riadok->m527r178;
$m527r179 = $fir_riadok->m527r179;
$m527r1710 = $fir_riadok->m527r1710;
//12.strana
$m527r181 = $fir_riadok->m527r181;
$m527r182 = $fir_riadok->m527r182;
$m527r183 = $fir_riadok->m527r183;
$m527r184 = $fir_riadok->m527r184;
$m527r185 = $fir_riadok->m527r185;
$m527r186 = $fir_riadok->m527r186;
$m527r187 = $fir_riadok->m527r187;
$m527r188 = $fir_riadok->m527r188;
$m527r1810 = $fir_riadok->m527r1810;
$m527r191 = $fir_riadok->m527r191;
$m527r192 = $fir_riadok->m527r192;
$m527r193 = $fir_riadok->m527r193;
$m527r194 = $fir_riadok->m527r194;
$m527r195 = $fir_riadok->m527r195;
$m527r196 = $fir_riadok->m527r196;
$m527r197 = $fir_riadok->m527r197;
$m527r198 = $fir_riadok->m527r198;
$m527r1910 = $fir_riadok->m527r1910;
$m527r201 = $fir_riadok->m527r201;
$m527r202 = $fir_riadok->m527r202;
$m527r203 = $fir_riadok->m527r203;
$m527r204 = $fir_riadok->m527r204;
$m527r205 = $fir_riadok->m527r205;
$m527r206 = $fir_riadok->m527r206;
$m527r207 = $fir_riadok->m527r207;
$m527r208 = $fir_riadok->m527r208;
$m527r2010 = $fir_riadok->m527r2010;
$m527r211 = $fir_riadok->m527r211;
$m527r212 = $fir_riadok->m527r212;
$m527r213 = $fir_riadok->m527r213;
$m527r214 = $fir_riadok->m527r214;
$m527r215 = $fir_riadok->m527r215;
$m527r216 = $fir_riadok->m527r216;
$m527r217 = $fir_riadok->m527r217;
$m527r218 = $fir_riadok->m527r218;
$m527r2110 = $fir_riadok->m527r2110;
$m527r221 = $fir_riadok->m527r221;
$m527r222 = $fir_riadok->m527r222;
$m527r223 = $fir_riadok->m527r223;
$m527r224 = $fir_riadok->m527r224;
$m527r225 = $fir_riadok->m527r225;
$m527r226 = $fir_riadok->m527r226;
$m527r227 = $fir_riadok->m527r227;
$m527r228 = $fir_riadok->m527r228;
$m527r2210 = $fir_riadok->m527r2210;
$m527r231 = $fir_riadok->m527r231;
$m527r232 = $fir_riadok->m527r232;
$m527r233 = $fir_riadok->m527r233;
$m527r234 = $fir_riadok->m527r234;
$m527r235 = $fir_riadok->m527r235;
$m527r236 = $fir_riadok->m527r236;
$m527r237 = $fir_riadok->m527r237;
$m527r238 = $fir_riadok->m527r238;
$m527r2310 = $fir_riadok->m527r2310;
$m527r241 = $fir_riadok->m527r241;
$m527r242 = $fir_riadok->m527r242;
$m527r243 = $fir_riadok->m527r243;
$m527r244 = $fir_riadok->m527r244;
$m527r245 = $fir_riadok->m527r245;
$m527r246 = $fir_riadok->m527r246;
$m527r247 = $fir_riadok->m527r247;
$m527r248 = $fir_riadok->m527r248;
$m527r2410 = $fir_riadok->m527r2410;
$m527r991 = $fir_riadok->m527r991;
$m527r992 = $fir_riadok->m527r992;
$m527r993 = $fir_riadok->m527r993;
$m527r994 = $fir_riadok->m527r994;
$m527r995 = $fir_riadok->m527r995;
$m527r996 = $fir_riadok->m527r996;
$m527r997 = $fir_riadok->m527r997;
$m527r998 = $fir_riadok->m527r998;
$m527r999 = $fir_riadok->m527r999;
$m527r9910 = $fir_riadok->m527r9910;
//13.strana
$m474r11 = $fir_riadok->m474r11;
$m474r12 = $fir_riadok->m474r12;
$m474r13 = $fir_riadok->m474r13;
$m474r21 = $fir_riadok->m474r21;
$m474r22 = $fir_riadok->m474r22;
$m474r23 = $fir_riadok->m474r23;
$m474r31 = $fir_riadok->m474r31;
$m474r32 = $fir_riadok->m474r32;
$m474r33 = $fir_riadok->m474r33;
$m474r41 = $fir_riadok->m474r41;
$m474r42 = $fir_riadok->m474r42;
$m474r43 = $fir_riadok->m474r43;
$m474r51 = $fir_riadok->m474r51;
$m474r52 = $fir_riadok->m474r52;
$m474r53 = $fir_riadok->m474r53;
$m474r61 = $fir_riadok->m474r61;
$m474r62 = $fir_riadok->m474r62;
$m474r63 = $fir_riadok->m474r63;
$m474r72 = $fir_riadok->m474r72;
$m474r73 = $fir_riadok->m474r73;
$m474r991 = $fir_riadok->m474r991;
$m474r992 = $fir_riadok->m474r992;
$m474r993 = $fir_riadok->m474r993;
$m514r1 = $fir_riadok->m514r1;
$m514r2 = $fir_riadok->m514r2;
$m514r3 = $fir_riadok->m514r3;
$m514r99 = $fir_riadok->m514r99;

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

//sknace bez bodiek
$sknace=str_replace(".", "", $fir_sknace);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - výkaz Roè VTS 1-01</title>
<style type="text/css">
div.navbar > a {
  padding: 6px 10px 6px 10px;
  font-size: 12px;
}
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
   document.formv1.cinnost.value = '<?php echo "$cinnost";?>';
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
   document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';
<?php if ( $mod100041ano == 1 ) { echo "document.formv1.mod100041ano.checked='checked';"; } ?>
<?php if ( $mod100041nie == 1 ) { echo "document.formv1.mod100041nie.checked='checked';"; } ?>
<?php if ( $mod100042ano == 1 ) { echo "document.formv1.mod100042ano.checked='checked';"; } ?>
<?php if ( $mod100042nie == 1 ) { echo "document.formv1.mod100042nie.checked='checked';"; } ?>
<?php if ( $mod100043ano == 1 ) { echo "document.formv1.mod100043ano.checked='checked';"; } ?>
<?php if ( $mod100043nie == 1 ) { echo "document.formv1.mod100043nie.checked='checked';"; } ?>
   document.formv1.m1100r4.value = '<?php echo "$m1100r4";?>';
   document.formv1.m1100r5.value = '<?php echo "$m1100r5";?>';
   document.formv1.m1100r6.value = '<?php echo "$m1100r6";?>';
   document.formv1.m1100r7.value = '<?php echo "$m1100r7";?>';
   document.formv1.m1100r8.value = '<?php echo "$m1100r8";?>';
   document.formv1.m1100r9.value = '<?php echo "$m1100r9";?>';
   document.formv1.m1100r10.value = '<?php echo "$m1100r10";?>';
   document.formv1.m1100r11.value = '<?php echo "$m1100r11";?>';
   document.formv1.m1100r12.value = '<?php echo "$m1100r12";?>';
   document.formv1.m1100r13.value = '<?php echo "$m1100r13";?>';


<?php if ( $mod100036kal == 1 ) { echo "document.formv1.mod100036kal.checked='checked';"; } ?>
<?php if ( $mod100036hos == 1 ) { echo "document.formv1.mod100036hos.checked='checked';"; } ?>


<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.mod100037.value = '<?php echo "$mod100037";?>';
   document.formv1.m100214r01.value = '<?php echo "$m100214r01";?>';
   document.formv1.m100214r02.value = '<?php echo "$m100214r02";?>';
<?php if ( $mod100069ano == 1 ) { echo "document.formv1.mod100069ano.checked='checked';"; } ?>
<?php if ( $mod100069nie == 1 ) { echo "document.formv1.mod100069nie.checked='checked';"; } ?>
   document.formv1.m1101r2.value = '<?php echo "$m1101r2";?>';
   document.formv1.m1101r3.value = '<?php echo "$m1101r3";?>';
<?php if ( $m1101r4a == 1 ) { echo "document.formv1.m1101r4a.checked='checked';"; } ?>
<?php if ( $m1101r4b == 1 ) { echo "document.formv1.m1101r4b.checked='checked';"; } ?>
<?php if ( $m1101r5a == 1 ) { echo "document.formv1.m1101r5a.checked='checked';"; } ?>
<?php if ( $m1101r5b == 1 ) { echo "document.formv1.m1101r5b.checked='checked';"; } ?>
<?php if ( $m1101r6a == 1 ) { echo "document.formv1.m1101r6a.checked='checked';"; } ?>
<?php if ( $m1101r6b == 1 ) { echo "document.formv1.m1101r6b.checked='checked';"; } ?>
<?php if ( $m1101r7a == 1 ) { echo "document.formv1.m1101r7a.checked='checked';"; } ?>
<?php if ( $m1101r7b == 1 ) { echo "document.formv1.m1101r7b.checked='checked';"; } ?>
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   document.formv1.m398r11.value = '<?php echo "$m398r11";?>';
   document.formv1.m398r12.value = '<?php echo "$m398r12";?>';
   document.formv1.m398r13.value = '<?php echo "$m398r13";?>';
   document.formv1.m398r14.value = '<?php echo "$m398r14";?>';
   document.formv1.m398r21.value = '<?php echo "$m398r21";?>';
   document.formv1.m398r22.value = '<?php echo "$m398r22";?>';
   document.formv1.m398r23.value = '<?php echo "$m398r23";?>';
   document.formv1.m398r24.value = '<?php echo "$m398r24";?>';
 //document.formv1.m398r991.value = '<?php echo "$m398r991";?>';
 //document.formv1.m398r992.value = '<?php echo "$m398r992";?>';
 //document.formv1.m398r993.value = '<?php echo "$m398r993";?>';
 //document.formv1.m398r994.value = '<?php echo "$m398r994";?>';
<?php if ( $m1005r1a == 1 ) { echo "document.formv1.m1005r1a.checked='checked';"; } ?>
<?php if ( $m1005r1b == 1 ) { echo "document.formv1.m1005r1b.checked='checked';"; } ?>
   document.formv1.m405r11.value = '<?php echo "$m405r11";?>';
   document.formv1.m405r12.value = '<?php echo "$m405r12";?>';
   document.formv1.m405r21.value = '<?php echo "$m405r21";?>';
   document.formv1.m405r31.value = '<?php echo "$m405r31";?>';
   document.formv1.m405r32.value = '<?php echo "$m405r32";?>';
   document.formv1.m405r41.value = '<?php echo "$m405r41";?>';
   document.formv1.m405r51.value = '<?php echo "$m405r51";?>';
   document.formv1.m405r61.value = '<?php echo "$m405r61";?>';
   document.formv1.m405r71.value = '<?php echo "$m405r71";?>';
   document.formv1.m405r81.value = '<?php echo "$m405r81";?>';
   document.formv1.m405r82.value = '<?php echo "$m405r82";?>';
 //document.formv1.m405r991.value = '<?php echo "$m405r991";?>';
 //document.formv1.m405r992.value = '<?php echo "$m405r992";?>';
   document.formv1.m406r1.value = '<?php echo "$m406r1";?>';
   document.formv1.m406r2.value = '<?php echo "$m406r2";?>';
   document.formv1.m406r3.value = '<?php echo "$m406r3";?>';
   document.formv1.m406r4.value = '<?php echo "$m406r4";?>';
   document.formv1.m406r5.value = '<?php echo "$m406r5";?>';
   document.formv1.m406r6.value = '<?php echo "$m406r6";?>';
   document.formv1.m406r7.value = '<?php echo "$m406r7";?>';
 //document.formv1.m406r99.value = '<?php echo "$m406r99";?>';
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   document.formv1.m558r1.value = '<?php echo "$m558r1";?>';
   document.formv1.m558r2.value = '<?php echo "$m558r2";?>';
   document.formv1.m558r3.value = '<?php echo "$m558r3";?>';
   document.formv1.m558r4.value = '<?php echo "$m558r4";?>';
   document.formv1.m558r5.value = '<?php echo "$m558r5";?>';
   document.formv1.m558r6.value = '<?php echo "$m558r6";?>';
   document.formv1.m558r7.value = '<?php echo "$m558r7";?>';
   document.formv1.m558r8.value = '<?php echo "$m558r8";?>';
   document.formv1.m558r9.value = '<?php echo "$m558r9";?>';
   document.formv1.m558r10.value = '<?php echo "$m558r10";?>';
   document.formv1.m558r11.value = '<?php echo "$m558r11";?>';
   document.formv1.m558r12.value = '<?php echo "$m558r12";?>';
   document.formv1.m558r13.value = '<?php echo "$m558r13";?>';
   document.formv1.m558r14.value = '<?php echo "$m558r14";?>';
   document.formv1.m558r15.value = '<?php echo "$m558r15";?>';
   document.formv1.m558r16.value = '<?php echo "$m558r16";?>';
   document.formv1.m558r17.value = '<?php echo "$m558r17";?>';
   document.formv1.m558r18.value = '<?php echo "$m558r18";?>';
 //document.formv1.m558r99.value = '<?php echo "$m558r99";?>';
   document.formv1.m585r01.value = '<?php echo "$m585r01";?>';
   document.formv1.m585r02.value = '<?php echo "$m585r02";?>';
   document.formv1.m585r03.value = '<?php echo "$m585r03";?>';
   document.formv1.m585r04.value = '<?php echo "$m585r04";?>';
   document.formv1.m585r05.value = '<?php echo "$m585r05";?>';
   document.formv1.m585r3k.value = '<?php echo "$m585r3k";?>';
   document.formv1.m585r4k.value = '<?php echo "$m585r4k";?>';
   document.formv1.m585r5k.value = '<?php echo "$m585r5k";?>';
<?php if ( $m100044ano == 1 ) { echo "document.formv1.m100044ano.checked='checked';"; } ?>
<?php if ( $m100044nie == 1 ) { echo "document.formv1.m100044nie.checked='checked';"; } ?>
<?php                     } ?>

<?php if ( $strana == 6 ) { ?>
   document.formv1.m571r10.value = '<?php echo "$m571r10";?>';
   document.formv1.m571r12.value = '<?php echo "$m571r12";?>';
   document.formv1.m571r13.value = '<?php echo "$m571r13";?>';
   document.formv1.m571r15.value = '<?php echo "$m571r15";?>';
   document.formv1.m571r16.value = '<?php echo "$m571r16";?>';
   document.formv1.m571r17.value = '<?php echo "$m571r17";?>';
   document.formv1.m571r18.value = '<?php echo "$m571r18";?>';
   document.formv1.m571r20.value = '<?php echo "$m571r20";?>';
   document.formv1.m571r22.value = '<?php echo "$m571r22";?>';
   document.formv1.m571r23.value = '<?php echo "$m571r23";?>';
   document.formv1.m571r25.value = '<?php echo "$m571r25";?>';
   document.formv1.m571r26.value = '<?php echo "$m571r26";?>';
   document.formv1.m571r27.value = '<?php echo "$m571r27";?>';
   document.formv1.m571r28.value = '<?php echo "$m571r28";?>';
   document.formv1.m571r30.value = '<?php echo "$m571r30";?>';
   document.formv1.m571r32.value = '<?php echo "$m571r32";?>';
   document.formv1.m571r33.value = '<?php echo "$m571r33";?>';
   document.formv1.m571r35.value = '<?php echo "$m571r35";?>';
   document.formv1.m571r36.value = '<?php echo "$m571r36";?>';
   document.formv1.m571r37.value = '<?php echo "$m571r37";?>';
   document.formv1.m571r38.value = '<?php echo "$m571r38";?>';
   document.formv1.m571r40.value = '<?php echo "$m571r40";?>';
   document.formv1.m571r42.value = '<?php echo "$m571r42";?>';
   document.formv1.m571r43.value = '<?php echo "$m571r43";?>';
   document.formv1.m571r45.value = '<?php echo "$m571r45";?>';
   document.formv1.m571r46.value = '<?php echo "$m571r46";?>';
   document.formv1.m571r47.value = '<?php echo "$m571r47";?>';
   document.formv1.m571r48.value = '<?php echo "$m571r48";?>';
   document.formv1.m571r50.value = '<?php echo "$m571r50";?>';
   document.formv1.m571r52.value = '<?php echo "$m571r52";?>';
   document.formv1.m571r53.value = '<?php echo "$m571r53";?>';
   document.formv1.m571r55.value = '<?php echo "$m571r55";?>';
   document.formv1.m571r56.value = '<?php echo "$m571r56";?>';
   document.formv1.m571r57.value = '<?php echo "$m571r57";?>';
   document.formv1.m571r58.value = '<?php echo "$m571r58";?>';
   document.formv1.m571r60.value = '<?php echo "$m571r60";?>';
   document.formv1.m571r62.value = '<?php echo "$m571r62";?>';
   document.formv1.m571r63.value = '<?php echo "$m571r63";?>';
   document.formv1.m571r65.value = '<?php echo "$m571r65";?>';
   document.formv1.m571r66.value = '<?php echo "$m571r66";?>';
   document.formv1.m571r67.value = '<?php echo "$m571r67";?>';
   document.formv1.m571r68.value = '<?php echo "$m571r68";?>';
   document.formv1.m571r70.value = '<?php echo "$m571r70";?>';
   document.formv1.m571r72.value = '<?php echo "$m571r72";?>';
   document.formv1.m571r73.value = '<?php echo "$m571r73";?>';
   document.formv1.m571r75.value = '<?php echo "$m571r75";?>';
   document.formv1.m571r76.value = '<?php echo "$m571r76";?>';
   document.formv1.m571r77.value = '<?php echo "$m571r77";?>';
   document.formv1.m571r78.value = '<?php echo "$m571r78";?>';
   document.formv1.m571r80.value = '<?php echo "$m571r80";?>';
   document.formv1.m571r82.value = '<?php echo "$m571r82";?>';
   document.formv1.m571r83.value = '<?php echo "$m571r83";?>';
   document.formv1.m571r85.value = '<?php echo "$m571r85";?>';
   document.formv1.m571r86.value = '<?php echo "$m571r86";?>';
   document.formv1.m571r87.value = '<?php echo "$m571r87";?>';
   document.formv1.m571r88.value = '<?php echo "$m571r88";?>';
   document.formv1.m571r90.value = '<?php echo "$m571r90";?>';
   document.formv1.m571r92.value = '<?php echo "$m571r92";?>';
   document.formv1.m571r93.value = '<?php echo "$m571r93";?>';
   document.formv1.m571r95.value = '<?php echo "$m571r95";?>';
   document.formv1.m571r96.value = '<?php echo "$m571r96";?>';
   document.formv1.m571r97.value = '<?php echo "$m571r97";?>';
   document.formv1.m571r98.value = '<?php echo "$m571r98";?>';
   document.formv1.m581r1.value = '<?php echo "$m581r1";?>';
   document.formv1.m581r2.value = '<?php echo "$m581r2";?>';
   document.formv1.m581r3.value = '<?php echo "$m581r3";?>';
   document.formv1.m581r4.value = '<?php echo "$m581r4";?>';
   document.formv1.m581r5.value = '<?php echo "$m581r5";?>';
   document.formv1.m581r6.value = '<?php echo "$m581r6";?>';
   document.formv1.m581r7.value = '<?php echo "$m581r7";?>';
   document.formv1.m581r8.value = '<?php echo "$m581r8";?>';
   document.formv1.m581r12.value = '<?php echo "$m581r12";?>';
 //document.formv1.m581r99.value = '<?php echo "$m581r99";?>';
<?php                     } ?>

<?php if (  $strana == 7 ) { ?>
   document.formv1.m513r11.value = '<?php echo "$m513r11";?>';
   document.formv1.m513r12.value = '<?php echo "$m513r12";?>';
   document.formv1.m513r13.value = '<?php echo "$m513r13";?>';
   document.formv1.m513r14.value = '<?php echo "$m513r14";?>';
   document.formv1.m513r15.value = '<?php echo "$m513r15";?>';
   document.formv1.m513r16.value = '<?php echo "$m513r16";?>';
   document.formv1.m513r17.value = '<?php echo "$m513r17";?>';
   document.formv1.m513r18.value = '<?php echo "$m513r18";?>';
   document.formv1.m513r19.value = '<?php echo "$m513r19";?>';
   document.formv1.m513r21.value = '<?php echo "$m513r21";?>';
   document.formv1.m513r22.value = '<?php echo "$m513r22";?>';
   document.formv1.m513r23.value = '<?php echo "$m513r23";?>';
   document.formv1.m513r24.value = '<?php echo "$m513r24";?>';
   document.formv1.m513r25.value = '<?php echo "$m513r25";?>';
   document.formv1.m513r26.value = '<?php echo "$m513r26";?>';
   document.formv1.m513r27.value = '<?php echo "$m513r27";?>';
   document.formv1.m513r28.value = '<?php echo "$m513r28";?>';
   document.formv1.m513r29.value = '<?php echo "$m513r29";?>';
   document.formv1.m513r31.value = '<?php echo "$m513r31";?>';
   document.formv1.m513r32.value = '<?php echo "$m513r32";?>';
   document.formv1.m513r33.value = '<?php echo "$m513r33";?>';
   document.formv1.m513r34.value = '<?php echo "$m513r34";?>';
   document.formv1.m513r35.value = '<?php echo "$m513r35";?>';
   document.formv1.m513r36.value = '<?php echo "$m513r36";?>';
   document.formv1.m513r37.value = '<?php echo "$m513r37";?>';
   document.formv1.m513r38.value = '<?php echo "$m513r38";?>';
   document.formv1.m513r39.value = '<?php echo "$m513r39";?>';
   document.formv1.m513r41.value = '<?php echo "$m513r41";?>';
   document.formv1.m513r42.value = '<?php echo "$m513r42";?>';
   document.formv1.m513r43.value = '<?php echo "$m513r43";?>';
   document.formv1.m513r44.value = '<?php echo "$m513r44";?>';
   document.formv1.m513r45.value = '<?php echo "$m513r45";?>';
   document.formv1.m513r46.value = '<?php echo "$m513r46";?>';
   document.formv1.m513r47.value = '<?php echo "$m513r47";?>';
   document.formv1.m513r48.value = '<?php echo "$m513r48";?>';
   document.formv1.m513r49.value = '<?php echo "$m513r49";?>';
   document.formv1.m513r51.value = '<?php echo "$m513r51";?>';
   document.formv1.m513r52.value = '<?php echo "$m513r52";?>';
   document.formv1.m513r53.value = '<?php echo "$m513r53";?>';
   document.formv1.m513r54.value = '<?php echo "$m513r54";?>';
   document.formv1.m513r55.value = '<?php echo "$m513r55";?>';
   document.formv1.m513r56.value = '<?php echo "$m513r56";?>';
   document.formv1.m513r57.value = '<?php echo "$m513r57";?>';
   document.formv1.m513r58.value = '<?php echo "$m513r58";?>';
   document.formv1.m513r59.value = '<?php echo "$m513r59";?>';
   document.formv1.m513r61.value = '<?php echo "$m513r61";?>';
   document.formv1.m513r62.value = '<?php echo "$m513r62";?>';
   document.formv1.m513r63.value = '<?php echo "$m513r63";?>';
   document.formv1.m513r64.value = '<?php echo "$m513r64";?>';
   document.formv1.m513r65.value = '<?php echo "$m513r65";?>';
   document.formv1.m513r66.value = '<?php echo "$m513r66";?>';
   document.formv1.m513r67.value = '<?php echo "$m513r67";?>';
   document.formv1.m513r68.value = '<?php echo "$m513r68";?>';
   document.formv1.m513r69.value = '<?php echo "$m513r69";?>';
   document.formv1.m513r71.value = '<?php echo "$m513r71";?>';
   document.formv1.m513r72.value = '<?php echo "$m513r72";?>';
   document.formv1.m513r73.value = '<?php echo "$m513r73";?>';
   document.formv1.m513r74.value = '<?php echo "$m513r74";?>';
   document.formv1.m513r75.value = '<?php echo "$m513r75";?>';
   document.formv1.m513r76.value = '<?php echo "$m513r76";?>';
   document.formv1.m513r77.value = '<?php echo "$m513r77";?>';
   document.formv1.m513r78.value = '<?php echo "$m513r78";?>';
   document.formv1.m513r79.value = '<?php echo "$m513r79";?>';
   document.formv1.m513r81.value = '<?php echo "$m513r81";?>';
   document.formv1.m513r82.value = '<?php echo "$m513r82";?>';
   document.formv1.m513r83.value = '<?php echo "$m513r83";?>';
   document.formv1.m513r84.value = '<?php echo "$m513r84";?>';
   document.formv1.m513r85.value = '<?php echo "$m513r85";?>';
   document.formv1.m513r86.value = '<?php echo "$m513r86";?>';
   document.formv1.m513r87.value = '<?php echo "$m513r87";?>';
   document.formv1.m513r88.value = '<?php echo "$m513r88";?>';
   document.formv1.m513r89.value = '<?php echo "$m513r89";?>';
   document.formv1.m513r91.value = '<?php echo "$m513r91";?>';
   document.formv1.m513r92.value = '<?php echo "$m513r92";?>';
   document.formv1.m513r93.value = '<?php echo "$m513r93";?>';
   document.formv1.m513r94.value = '<?php echo "$m513r94";?>';
   document.formv1.m513r95.value = '<?php echo "$m513r95";?>';
   document.formv1.m513r96.value = '<?php echo "$m513r96";?>';
   document.formv1.m513r97.value = '<?php echo "$m513r97";?>';
   document.formv1.m513r98.value = '<?php echo "$m513r98";?>';
   document.formv1.m513r99.value = '<?php echo "$m513r99";?>';
   document.formv1.m513r101.value = '<?php echo "$m513r101";?>';
   document.formv1.m513r102.value = '<?php echo "$m513r102";?>';
   document.formv1.m513r103.value = '<?php echo "$m513r103";?>';
   document.formv1.m513r104.value = '<?php echo "$m513r104";?>';
   document.formv1.m513r105.value = '<?php echo "$m513r105";?>';
   document.formv1.m513r106.value = '<?php echo "$m513r106";?>';
   document.formv1.m513r107.value = '<?php echo "$m513r107";?>';
   document.formv1.m513r108.value = '<?php echo "$m513r108";?>';
   document.formv1.m513r109.value = '<?php echo "$m513r109";?>';
   document.formv1.m513r111.value = '<?php echo "$m513r111";?>';
   document.formv1.m513r112.value = '<?php echo "$m513r112";?>';
   document.formv1.m513r113.value = '<?php echo "$m513r113";?>';
   document.formv1.m513r114.value = '<?php echo "$m513r114";?>';
   document.formv1.m513r115.value = '<?php echo "$m513r115";?>';
   document.formv1.m513r116.value = '<?php echo "$m513r116";?>';
   document.formv1.m513r117.value = '<?php echo "$m513r117";?>';
   document.formv1.m513r118.value = '<?php echo "$m513r118";?>';
   document.formv1.m513r119.value = '<?php echo "$m513r119";?>';
   document.formv1.m513r121.value = '<?php echo "$m513r121";?>';
   document.formv1.m513r122.value = '<?php echo "$m513r122";?>';
   document.formv1.m513r123.value = '<?php echo "$m513r123";?>';
   document.formv1.m513r124.value = '<?php echo "$m513r124";?>';
   document.formv1.m513r125.value = '<?php echo "$m513r125";?>';
   document.formv1.m513r126.value = '<?php echo "$m513r126";?>';
   document.formv1.m513r127.value = '<?php echo "$m513r127";?>';
   document.formv1.m513r128.value = '<?php echo "$m513r128";?>';
   document.formv1.m513r129.value = '<?php echo "$m513r129";?>';
   document.formv1.m513r131.value = '<?php echo "$m513r131";?>';
   document.formv1.m513r132.value = '<?php echo "$m513r132";?>';
   document.formv1.m513r133.value = '<?php echo "$m513r133";?>';
   document.formv1.m513r134.value = '<?php echo "$m513r134";?>';
   document.formv1.m513r135.value = '<?php echo "$m513r135";?>';
   document.formv1.m513r136.value = '<?php echo "$m513r136";?>';
   document.formv1.m513r137.value = '<?php echo "$m513r137";?>';
   document.formv1.m513r138.value = '<?php echo "$m513r138";?>';
   document.formv1.m513r139.value = '<?php echo "$m513r139";?>';
   document.formv1.m513r141.value = '<?php echo "$m513r141";?>';
   document.formv1.m513r142.value = '<?php echo "$m513r142";?>';
   document.formv1.m513r143.value = '<?php echo "$m513r143";?>';
   document.formv1.m513r144.value = '<?php echo "$m513r144";?>';
   document.formv1.m513r145.value = '<?php echo "$m513r145";?>';
   document.formv1.m513r146.value = '<?php echo "$m513r146";?>';
   document.formv1.m513r147.value = '<?php echo "$m513r147";?>';
   document.formv1.m513r148.value = '<?php echo "$m513r148";?>';
   document.formv1.m513r149.value = '<?php echo "$m513r149";?>';
   document.formv1.m513r151.value = '<?php echo "$m513r151";?>';
   document.formv1.m513r152.value = '<?php echo "$m513r152";?>';
   document.formv1.m513r153.value = '<?php echo "$m513r153";?>';
   document.formv1.m513r154.value = '<?php echo "$m513r154";?>';
   document.formv1.m513r155.value = '<?php echo "$m513r155";?>';
   document.formv1.m513r156.value = '<?php echo "$m513r156";?>';
   document.formv1.m513r157.value = '<?php echo "$m513r157";?>';
   document.formv1.m513r158.value = '<?php echo "$m513r158";?>';
   document.formv1.m513r159.value = '<?php echo "$m513r159";?>';
   document.formv1.m513r161.value = '<?php echo "$m513r161";?>';
   document.formv1.m513r162.value = '<?php echo "$m513r162";?>';
   document.formv1.m513r163.value = '<?php echo "$m513r163";?>';
   document.formv1.m513r164.value = '<?php echo "$m513r164";?>';
   document.formv1.m513r165.value = '<?php echo "$m513r165";?>';
   document.formv1.m513r166.value = '<?php echo "$m513r166";?>';
   document.formv1.m513r167.value = '<?php echo "$m513r167";?>';
   document.formv1.m513r168.value = '<?php echo "$m513r168";?>';
   document.formv1.m513r169.value = '<?php echo "$m513r169";?>';
   document.formv1.m513r171.value = '<?php echo "$m513r171";?>';
   document.formv1.m513r173.value = '<?php echo "$m513r173";?>';
   document.formv1.m513r174.value = '<?php echo "$m513r174";?>';
   document.formv1.m513r175.value = '<?php echo "$m513r175";?>';
   document.formv1.m513r176.value = '<?php echo "$m513r176";?>';
   document.formv1.m513r177.value = '<?php echo "$m513r177";?>';
   document.formv1.m513r181.value = '<?php echo "$m513r181";?>';
   document.formv1.m513r183.value = '<?php echo "$m513r183";?>';
   document.formv1.m513r184.value = '<?php echo "$m513r184";?>';
   document.formv1.m513r185.value = '<?php echo "$m513r185";?>';
   document.formv1.m513r186.value = '<?php echo "$m513r186";?>';
   document.formv1.m513r187.value = '<?php echo "$m513r187";?>';
   document.formv1.m513r191.value = '<?php echo "$m513r191";?>';
   document.formv1.m513r193.value = '<?php echo "$m513r193";?>';
   document.formv1.m513r194.value = '<?php echo "$m513r194";?>';
   document.formv1.m513r195.value = '<?php echo "$m513r195";?>';
   document.formv1.m513r196.value = '<?php echo "$m513r196";?>';
   document.formv1.m513r197.value = '<?php echo "$m513r197";?>';
   document.formv1.m513r201.value = '<?php echo "$m513r201";?>';
   document.formv1.m513r203.value = '<?php echo "$m513r203";?>';
   document.formv1.m513r204.value = '<?php echo "$m513r204";?>';
   document.formv1.m513r205.value = '<?php echo "$m513r205";?>';
   document.formv1.m513r206.value = '<?php echo "$m513r206";?>';
   document.formv1.m513r207.value = '<?php echo "$m513r207";?>';
   document.formv1.m513r211.value = '<?php echo "$m513r211";?>';
   document.formv1.m513r213.value = '<?php echo "$m513r213";?>';
   document.formv1.m513r214.value = '<?php echo "$m513r214";?>';
   document.formv1.m513r215.value = '<?php echo "$m513r215";?>';
   document.formv1.m513r216.value = '<?php echo "$m513r216";?>';
   document.formv1.m513r217.value = '<?php echo "$m513r217";?>';
   document.formv1.m513r221.value = '<?php echo "$m513r221";?>';
   document.formv1.m513r222.value = '<?php echo "$m513r222";?>';
   document.formv1.m513r223.value = '<?php echo "$m513r223";?>';
   document.formv1.m513r224.value = '<?php echo "$m513r224";?>';
   document.formv1.m513r225.value = '<?php echo "$m513r225";?>';
   document.formv1.m513r226.value = '<?php echo "$m513r226";?>';
   document.formv1.m513r227.value = '<?php echo "$m513r227";?>';
   document.formv1.m513r228.value = '<?php echo "$m513r228";?>';
   document.formv1.m513r229.value = '<?php echo "$m513r229";?>';
 //document.formv1.m513r991.value = '<?php echo "$m513r991";?>';
 //document.formv1.m513r992.value = '<?php echo "$m513r992";?>';
 //document.formv1.m513r993.value = '<?php echo "$m513r993";?>';
 //document.formv1.m513r994.value = '<?php echo "$m513r994";?>';
 //document.formv1.m513r995.value = '<?php echo "$m513r995";?>';
 //document.formv1.m513r996.value = '<?php echo "$m513r996";?>';
 //document.formv1.m513r997.value = '<?php echo "$m513r997";?>';
 //document.formv1.m513r998.value = '<?php echo "$m513r998";?>';
 //document.formv1.m513r999.value = '<?php echo "$m513r999";?>';
<?php                     } ?>

<?php if ( $strana == 8 ) { ?>
   document.formv1.m516r11.value = '<?php echo "$m516r11";?>';
   document.formv1.m516r12.value = '<?php echo "$m516r12";?>';
   document.formv1.m516r13.value = '<?php echo "$m516r13";?>';
   document.formv1.m516r14.value = '<?php echo "$m516r14";?>';
   document.formv1.m516r15.value = '<?php echo "$m516r15";?>';
   document.formv1.m516r16.value = '<?php echo "$m516r16";?>';
   document.formv1.m516r17.value = '<?php echo "$m516r17";?>';
   document.formv1.m516r21.value = '<?php echo "$m516r21";?>';
   document.formv1.m516r22.value = '<?php echo "$m516r22";?>';
   document.formv1.m516r23.value = '<?php echo "$m516r23";?>';
   document.formv1.m516r24.value = '<?php echo "$m516r24";?>';
   document.formv1.m516r25.value = '<?php echo "$m516r25";?>';
   document.formv1.m516r26.value = '<?php echo "$m516r26";?>';
   document.formv1.m516r27.value = '<?php echo "$m516r27";?>';
   document.formv1.m516r31.value = '<?php echo "$m516r31";?>';
   document.formv1.m516r32.value = '<?php echo "$m516r32";?>';
   document.formv1.m516r33.value = '<?php echo "$m516r33";?>';
   document.formv1.m516r34.value = '<?php echo "$m516r34";?>';
   document.formv1.m516r35.value = '<?php echo "$m516r35";?>';
   document.formv1.m516r36.value = '<?php echo "$m516r36";?>';
   document.formv1.m516r37.value = '<?php echo "$m516r37";?>';
   document.formv1.m516r41.value = '<?php echo "$m516r41";?>';
   document.formv1.m516r42.value = '<?php echo "$m516r42";?>';
   document.formv1.m516r43.value = '<?php echo "$m516r43";?>';
   document.formv1.m516r44.value = '<?php echo "$m516r44";?>';
   document.formv1.m516r45.value = '<?php echo "$m516r45";?>';
   document.formv1.m516r46.value = '<?php echo "$m516r46";?>';
   document.formv1.m516r47.value = '<?php echo "$m516r47";?>';
   document.formv1.m516r51.value = '<?php echo "$m516r51";?>';
   document.formv1.m516r53.value = '<?php echo "$m516r53";?>';
   document.formv1.m516r54.value = '<?php echo "$m516r54";?>';
   document.formv1.m516r55.value = '<?php echo "$m516r55";?>';
   document.formv1.m516r57.value = '<?php echo "$m516r57";?>';
   document.formv1.m516r61.value = '<?php echo "$m516r61";?>';
   document.formv1.m516r62.value = '<?php echo "$m516r62";?>';
   document.formv1.m516r63.value = '<?php echo "$m516r63";?>';
   document.formv1.m516r64.value = '<?php echo "$m516r64";?>';
   document.formv1.m516r65.value = '<?php echo "$m516r65";?>';
   document.formv1.m516r66.value = '<?php echo "$m516r66";?>';
   document.formv1.m516r67.value = '<?php echo "$m516r67";?>';
   document.formv1.m516r71.value = '<?php echo "$m516r71";?>';
   document.formv1.m516r72.value = '<?php echo "$m516r72";?>';
   document.formv1.m516r73.value = '<?php echo "$m516r73";?>';
   document.formv1.m516r74.value = '<?php echo "$m516r74";?>';
   document.formv1.m516r75.value = '<?php echo "$m516r75";?>';
   document.formv1.m516r76.value = '<?php echo "$m516r76";?>';
   document.formv1.m516r77.value = '<?php echo "$m516r77";?>';
   document.formv1.m516r81.value = '<?php echo "$m516r81";?>';
   document.formv1.m516r82.value = '<?php echo "$m516r82";?>';
   document.formv1.m516r83.value = '<?php echo "$m516r83";?>';
   document.formv1.m516r84.value = '<?php echo "$m516r84";?>';
   document.formv1.m516r85.value = '<?php echo "$m516r85";?>';
   document.formv1.m516r86.value = '<?php echo "$m516r86";?>';
   document.formv1.m516r87.value = '<?php echo "$m516r87";?>';
   document.formv1.m516r91.value = '<?php echo "$m516r91";?>';
   document.formv1.m516r92.value = '<?php echo "$m516r92";?>';
   document.formv1.m516r93.value = '<?php echo "$m516r93";?>';
   document.formv1.m516r94.value = '<?php echo "$m516r94";?>';
   document.formv1.m516r95.value = '<?php echo "$m516r95";?>';
   document.formv1.m516r96.value = '<?php echo "$m516r96";?>';
   document.formv1.m516r97.value = '<?php echo "$m516r97";?>';
   document.formv1.m516r101.value = '<?php echo "$m516r101";?>';
   document.formv1.m516r102.value = '<?php echo "$m516r102";?>';
   document.formv1.m516r103.value = '<?php echo "$m516r103";?>';
   document.formv1.m516r104.value = '<?php echo "$m516r104";?>';
   document.formv1.m516r105.value = '<?php echo "$m516r105";?>';
   document.formv1.m516r106.value = '<?php echo "$m516r106";?>';
   document.formv1.m516r107.value = '<?php echo "$m516r107";?>';
   document.formv1.m516r111.value = '<?php echo "$m516r111";?>';
   document.formv1.m516r112.value = '<?php echo "$m516r112";?>';
   document.formv1.m516r113.value = '<?php echo "$m516r113";?>';
   document.formv1.m516r114.value = '<?php echo "$m516r114";?>';
   document.formv1.m516r115.value = '<?php echo "$m516r115";?>';
   document.formv1.m516r116.value = '<?php echo "$m516r116";?>';
   document.formv1.m516r117.value = '<?php echo "$m516r117";?>';
   document.formv1.m516r121.value = '<?php echo "$m516r121";?>';
   document.formv1.m516r122.value = '<?php echo "$m516r122";?>';
   document.formv1.m516r123.value = '<?php echo "$m516r123";?>';
   document.formv1.m516r124.value = '<?php echo "$m516r124";?>';
   document.formv1.m516r125.value = '<?php echo "$m516r125";?>';
   document.formv1.m516r126.value = '<?php echo "$m516r126";?>';
   document.formv1.m516r127.value = '<?php echo "$m516r127";?>';
   document.formv1.m516r131.value = '<?php echo "$m516r131";?>';
   document.formv1.m516r132.value = '<?php echo "$m516r132";?>';
   document.formv1.m516r133.value = '<?php echo "$m516r133";?>';
   document.formv1.m516r134.value = '<?php echo "$m516r134";?>';
   document.formv1.m516r135.value = '<?php echo "$m516r135";?>';
   document.formv1.m516r136.value = '<?php echo "$m516r136";?>';
   document.formv1.m516r137.value = '<?php echo "$m516r137";?>';
   document.formv1.m516r141.value = '<?php echo "$m516r141";?>';
   document.formv1.m516r142.value = '<?php echo "$m516r142";?>';
   document.formv1.m516r143.value = '<?php echo "$m516r143";?>';
   document.formv1.m516r144.value = '<?php echo "$m516r144";?>';
   document.formv1.m516r145.value = '<?php echo "$m516r145";?>';
   document.formv1.m516r146.value = '<?php echo "$m516r146";?>';
   document.formv1.m516r147.value = '<?php echo "$m516r147";?>';
   document.formv1.m516r151.value = '<?php echo "$m516r151";?>';
   document.formv1.m516r152.value = '<?php echo "$m516r152";?>';
   document.formv1.m516r153.value = '<?php echo "$m516r153";?>';
   document.formv1.m516r154.value = '<?php echo "$m516r154";?>';
   document.formv1.m516r155.value = '<?php echo "$m516r155";?>';
   document.formv1.m516r156.value = '<?php echo "$m516r156";?>';
   document.formv1.m516r157.value = '<?php echo "$m516r157";?>';
   document.formv1.m516r161.value = '<?php echo "$m516r161";?>';
   document.formv1.m516r162.value = '<?php echo "$m516r162";?>';
   document.formv1.m516r163.value = '<?php echo "$m516r163";?>';
   document.formv1.m516r164.value = '<?php echo "$m516r164";?>';
   document.formv1.m516r165.value = '<?php echo "$m516r165";?>';
   document.formv1.m516r166.value = '<?php echo "$m516r166";?>';
   document.formv1.m516r167.value = '<?php echo "$m516r167";?>';
   document.formv1.m516r171.value = '<?php echo "$m516r171";?>';
   document.formv1.m516r172.value = '<?php echo "$m516r172";?>';
   document.formv1.m516r174.value = '<?php echo "$m516r174";?>';
   document.formv1.m516r175.value = '<?php echo "$m516r175";?>';
   document.formv1.m516r177.value = '<?php echo "$m516r177";?>';
   document.formv1.m516r181.value = '<?php echo "$m516r181";?>';
   document.formv1.m516r182.value = '<?php echo "$m516r182";?>';
   document.formv1.m516r184.value = '<?php echo "$m516r184";?>';
   document.formv1.m516r185.value = '<?php echo "$m516r185";?>';
   document.formv1.m516r187.value = '<?php echo "$m516r187";?>';
   document.formv1.m516r191.value = '<?php echo "$m516r191";?>';
   document.formv1.m516r192.value = '<?php echo "$m516r192";?>';
   document.formv1.m516r194.value = '<?php echo "$m516r194";?>';
   document.formv1.m516r195.value = '<?php echo "$m516r195";?>';
   document.formv1.m516r197.value = '<?php echo "$m516r197";?>';
   document.formv1.m516r201.value = '<?php echo "$m516r201";?>';
   document.formv1.m516r202.value = '<?php echo "$m516r202";?>';
   document.formv1.m516r204.value = '<?php echo "$m516r204";?>';
   document.formv1.m516r205.value = '<?php echo "$m516r205";?>';
   document.formv1.m516r206.value = '<?php echo "$m516r206";?>';
   document.formv1.m516r207.value = '<?php echo "$m516r207";?>';
   document.formv1.m516r211.value = '<?php echo "$m516r211";?>';
   document.formv1.m516r212.value = '<?php echo "$m516r212";?>';
   document.formv1.m516r214.value = '<?php echo "$m516r214";?>';
   document.formv1.m516r215.value = '<?php echo "$m516r215";?>';
   document.formv1.m516r216.value = '<?php echo "$m516r216";?>';
   document.formv1.m516r217.value = '<?php echo "$m516r217";?>';
   document.formv1.m516r221.value = '<?php echo "$m516r221";?>';
   document.formv1.m516r222.value = '<?php echo "$m516r222";?>';
   document.formv1.m516r223.value = '<?php echo "$m516r223";?>';
   document.formv1.m516r224.value = '<?php echo "$m516r224";?>';
   document.formv1.m516r225.value = '<?php echo "$m516r225";?>';
   document.formv1.m516r226.value = '<?php echo "$m516r226";?>';
   document.formv1.m516r227.value = '<?php echo "$m516r227";?>';
 //document.formv1.m516r991.value = '<?php echo "$m516r991";?>';
 //document.formv1.m516r992.value = '<?php echo "$m516r992";?>';
 //document.formv1.m516r993.value = '<?php echo "$m516r993";?>';
 //document.formv1.m516r994.value = '<?php echo "$m516r994";?>';
 //document.formv1.m516r995.value = '<?php echo "$m516r995";?>';
 //document.formv1.m516r996.value = '<?php echo "$m516r996";?>';
 //document.formv1.m516r997.value = '<?php echo "$m516r997";?>';
<?php                     } ?>

<?php if ( $strana == 9 ) { ?>
   document.formv1.m586r11.value = '<?php echo "$m586r11";?>';
   document.formv1.m586r12.value = '<?php echo "$m586r12";?>';
   document.formv1.m586r21.value = '<?php echo "$m586r21";?>';
   document.formv1.m586r22.value = '<?php echo "$m586r22";?>';
   document.formv1.m586r131.value = '<?php echo "$m586r131";?>';
   document.formv1.m586r132.value = '<?php echo "$m586r132";?>';
   document.formv1.m586r141.value = '<?php echo "$m586r141";?>';
   document.formv1.m586r142.value = '<?php echo "$m586r142";?>';
   document.formv1.m586r151.value = '<?php echo "$m586r151";?>';
   document.formv1.m586r152.value = '<?php echo "$m586r152";?>';
   document.formv1.m586r191.value = '<?php echo "$m586r191";?>';
   document.formv1.m586r192.value = '<?php echo "$m586r192";?>';
   document.formv1.m586r201.value = '<?php echo "$m586r201";?>';
   document.formv1.m586r202.value = '<?php echo "$m586r202";?>';
 //document.formv1.m586r991.value = '<?php echo "$m586r991";?>';
 //document.formv1.m586r992.value = '<?php echo "$m586r992";?>';




<?php                     } ?>

<?php if ( $strana == 10 ) { ?>
   document.formv1.m19r1.value = '<?php echo "$m19r1";?>';
   document.formv1.m19r2.value = '<?php echo "$m19r2";?>';
   document.formv1.m19r3.value = '<?php echo "$m19r3";?>';
   document.formv1.m19r4.value = '<?php echo "$m19r4";?>';
   document.formv1.m19r5.value = '<?php echo "$m19r5";?>';
   document.formv1.m19r6.value = '<?php echo "$m19r6";?>';
   document.formv1.m19r7.value = '<?php echo "$m19r7";?>';
   document.formv1.m19r8.value = '<?php echo "$m19r8";?>';
   document.formv1.m19r9.value = '<?php echo "$m19r9";?>';
   document.formv1.m19r10.value = '<?php echo "$m19r10";?>';
   document.formv1.m19r11.value = '<?php echo "$m19r11";?>';
   document.formv1.m19r12.value = '<?php echo "$m19r12";?>';
 //document.formv1.m19r99.value = '<?php echo "$m19r99";?>';
<?php if ( $m1527r1a == 1 ) { echo "document.formv1.m1527r1a.checked='checked';"; } ?>
<?php if ( $m1527r1b == 1 ) { echo "document.formv1.m1527r1b.checked='checked';"; } ?>
<?php                      } ?>

<?php if ( $strana == 11 ) { ?>
   document.formv1.m527r11.value = '<?php echo "$m527r11";?>';
   document.formv1.m527r12.value = '<?php echo "$m527r12";?>';
   document.formv1.m527r13.value = '<?php echo "$m527r13";?>';
   document.formv1.m527r14.value = '<?php echo "$m527r14";?>';
   document.formv1.m527r15.value = '<?php echo "$m527r15";?>';
   document.formv1.m527r16.value = '<?php echo "$m527r16";?>';
   document.formv1.m527r17.value = '<?php echo "$m527r17";?>';
   document.formv1.m527r18.value = '<?php echo "$m527r18";?>';
   document.formv1.m527r19.value = '<?php echo "$m527r19";?>';
   document.formv1.m527r110.value = '<?php echo "$m527r110";?>';
   document.formv1.m527r21.value = '<?php echo "$m527r21";?>';
   document.formv1.m527r22.value = '<?php echo "$m527r22";?>';
   document.formv1.m527r23.value = '<?php echo "$m527r23";?>';
   document.formv1.m527r24.value = '<?php echo "$m527r24";?>';
   document.formv1.m527r25.value = '<?php echo "$m527r25";?>';
   document.formv1.m527r26.value = '<?php echo "$m527r26";?>';
   document.formv1.m527r27.value = '<?php echo "$m527r27";?>';
   document.formv1.m527r28.value = '<?php echo "$m527r28";?>';
   document.formv1.m527r29.value = '<?php echo "$m527r29";?>';
   document.formv1.m527r210.value = '<?php echo "$m527r210";?>';
   document.formv1.m527r31.value = '<?php echo "$m527r31";?>';
   document.formv1.m527r32.value = '<?php echo "$m527r32";?>';
   document.formv1.m527r33.value = '<?php echo "$m527r33";?>';
   document.formv1.m527r34.value = '<?php echo "$m527r34";?>';
   document.formv1.m527r35.value = '<?php echo "$m527r35";?>';
   document.formv1.m527r36.value = '<?php echo "$m527r36";?>';
   document.formv1.m527r37.value = '<?php echo "$m527r37";?>';
   document.formv1.m527r38.value = '<?php echo "$m527r38";?>';
   document.formv1.m527r39.value = '<?php echo "$m527r39";?>';
   document.formv1.m527r310.value = '<?php echo "$m527r310";?>';
   document.formv1.m527r41.value = '<?php echo "$m527r41";?>';
   document.formv1.m527r42.value = '<?php echo "$m527r42";?>';
   document.formv1.m527r43.value = '<?php echo "$m527r43";?>';
   document.formv1.m527r44.value = '<?php echo "$m527r44";?>';
   document.formv1.m527r45.value = '<?php echo "$m527r45";?>';
   document.formv1.m527r46.value = '<?php echo "$m527r46";?>';
   document.formv1.m527r47.value = '<?php echo "$m527r47";?>';
   document.formv1.m527r48.value = '<?php echo "$m527r48";?>';
   document.formv1.m527r49.value = '<?php echo "$m527r49";?>';
   document.formv1.m527r410.value = '<?php echo "$m527r410";?>';
   document.formv1.m527r51.value = '<?php echo "$m527r51";?>';
   document.formv1.m527r52.value = '<?php echo "$m527r52";?>';
   document.formv1.m527r53.value = '<?php echo "$m527r53";?>';
   document.formv1.m527r54.value = '<?php echo "$m527r54";?>';
   document.formv1.m527r55.value = '<?php echo "$m527r55";?>';
   document.formv1.m527r56.value = '<?php echo "$m527r56";?>';
   document.formv1.m527r57.value = '<?php echo "$m527r57";?>';
   document.formv1.m527r58.value = '<?php echo "$m527r58";?>';
   document.formv1.m527r59.value = '<?php echo "$m527r59";?>';
   document.formv1.m527r510.value = '<?php echo "$m527r510";?>';
   document.formv1.m527r61.value = '<?php echo "$m527r61";?>';
   document.formv1.m527r62.value = '<?php echo "$m527r62";?>';
   document.formv1.m527r63.value = '<?php echo "$m527r63";?>';
   document.formv1.m527r64.value = '<?php echo "$m527r64";?>';
   document.formv1.m527r65.value = '<?php echo "$m527r65";?>';
   document.formv1.m527r66.value = '<?php echo "$m527r66";?>';
   document.formv1.m527r67.value = '<?php echo "$m527r67";?>';
   document.formv1.m527r68.value = '<?php echo "$m527r68";?>';
   document.formv1.m527r69.value = '<?php echo "$m527r69";?>';
   document.formv1.m527r610.value = '<?php echo "$m527r610";?>';
   document.formv1.m527r71.value = '<?php echo "$m527r71";?>';
   document.formv1.m527r72.value = '<?php echo "$m527r72";?>';
   document.formv1.m527r73.value = '<?php echo "$m527r73";?>';
   document.formv1.m527r74.value = '<?php echo "$m527r74";?>';
   document.formv1.m527r75.value = '<?php echo "$m527r75";?>';
   document.formv1.m527r76.value = '<?php echo "$m527r76";?>';
   document.formv1.m527r77.value = '<?php echo "$m527r77";?>';
   document.formv1.m527r78.value = '<?php echo "$m527r78";?>';
   document.formv1.m527r79.value = '<?php echo "$m527r79";?>';
   document.formv1.m527r710.value = '<?php echo "$m527r710";?>';
   document.formv1.m527r81.value = '<?php echo "$m527r81";?>';
   document.formv1.m527r82.value = '<?php echo "$m527r82";?>';
   document.formv1.m527r83.value = '<?php echo "$m527r83";?>';
   document.formv1.m527r84.value = '<?php echo "$m527r84";?>';
   document.formv1.m527r85.value = '<?php echo "$m527r85";?>';
   document.formv1.m527r86.value = '<?php echo "$m527r86";?>';
   document.formv1.m527r87.value = '<?php echo "$m527r87";?>';
   document.formv1.m527r88.value = '<?php echo "$m527r88";?>';
   document.formv1.m527r89.value = '<?php echo "$m527r89";?>';
   document.formv1.m527r810.value = '<?php echo "$m527r810";?>';
   document.formv1.m527r91.value = '<?php echo "$m527r91";?>';
   document.formv1.m527r92.value = '<?php echo "$m527r92";?>';
   document.formv1.m527r93.value = '<?php echo "$m527r93";?>';
   document.formv1.m527r94.value = '<?php echo "$m527r94";?>';
   document.formv1.m527r95.value = '<?php echo "$m527r95";?>';
   document.formv1.m527r96.value = '<?php echo "$m527r96";?>';
   document.formv1.m527r97.value = '<?php echo "$m527r97";?>';
   document.formv1.m527r98.value = '<?php echo "$m527r98";?>';
   document.formv1.m527r99.value = '<?php echo "$m527r99";?>';
   document.formv1.m527r910.value = '<?php echo "$m527r910";?>';
   document.formv1.m527r101.value = '<?php echo "$m527r101";?>';
   document.formv1.m527r102.value = '<?php echo "$m527r102";?>';
   document.formv1.m527r103.value = '<?php echo "$m527r103";?>';
   document.formv1.m527r104.value = '<?php echo "$m527r104";?>';
   document.formv1.m527r105.value = '<?php echo "$m527r105";?>';
   document.formv1.m527r106.value = '<?php echo "$m527r106";?>';
   document.formv1.m527r107.value = '<?php echo "$m527r107";?>';
   document.formv1.m527r108.value = '<?php echo "$m527r108";?>';
   document.formv1.m527r109.value = '<?php echo "$m527r109";?>';
   document.formv1.m527r1010.value = '<?php echo "$m527r1010";?>';
   document.formv1.m527r111.value = '<?php echo "$m527r111";?>';
   document.formv1.m527r112.value = '<?php echo "$m527r112";?>';
   document.formv1.m527r113.value = '<?php echo "$m527r113";?>';
   document.formv1.m527r114.value = '<?php echo "$m527r114";?>';
   document.formv1.m527r115.value = '<?php echo "$m527r115";?>';
   document.formv1.m527r116.value = '<?php echo "$m527r116";?>';
   document.formv1.m527r117.value = '<?php echo "$m527r117";?>';
   document.formv1.m527r118.value = '<?php echo "$m527r118";?>';
   document.formv1.m527r119.value = '<?php echo "$m527r119";?>';
   document.formv1.m527r1110.value = '<?php echo "$m527r1110";?>';
   document.formv1.m527r121.value = '<?php echo "$m527r121";?>';
   document.formv1.m527r122.value = '<?php echo "$m527r122";?>';
   document.formv1.m527r123.value = '<?php echo "$m527r123";?>';
   document.formv1.m527r124.value = '<?php echo "$m527r124";?>';
   document.formv1.m527r125.value = '<?php echo "$m527r125";?>';
   document.formv1.m527r126.value = '<?php echo "$m527r126";?>';
   document.formv1.m527r127.value = '<?php echo "$m527r127";?>';
   document.formv1.m527r128.value = '<?php echo "$m527r128";?>';
   document.formv1.m527r129.value = '<?php echo "$m527r129";?>';
   document.formv1.m527r1210.value = '<?php echo "$m527r1210";?>';
   document.formv1.m527r131.value = '<?php echo "$m527r131";?>';
   document.formv1.m527r132.value = '<?php echo "$m527r132";?>';
   document.formv1.m527r133.value = '<?php echo "$m527r133";?>';
   document.formv1.m527r134.value = '<?php echo "$m527r134";?>';
   document.formv1.m527r135.value = '<?php echo "$m527r135";?>';
   document.formv1.m527r136.value = '<?php echo "$m527r136";?>';
   document.formv1.m527r137.value = '<?php echo "$m527r137";?>';
   document.formv1.m527r138.value = '<?php echo "$m527r138";?>';
   document.formv1.m527r139.value = '<?php echo "$m527r139";?>';
   document.formv1.m527r1310.value = '<?php echo "$m527r1310";?>';
   document.formv1.m527r141.value = '<?php echo "$m527r141";?>';
   document.formv1.m527r142.value = '<?php echo "$m527r142";?>';
   document.formv1.m527r143.value = '<?php echo "$m527r143";?>';
   document.formv1.m527r144.value = '<?php echo "$m527r144";?>';
   document.formv1.m527r145.value = '<?php echo "$m527r145";?>';
   document.formv1.m527r146.value = '<?php echo "$m527r146";?>';
   document.formv1.m527r147.value = '<?php echo "$m527r147";?>';
   document.formv1.m527r148.value = '<?php echo "$m527r148";?>';
   document.formv1.m527r149.value = '<?php echo "$m527r149";?>';
   document.formv1.m527r1410.value = '<?php echo "$m527r1410";?>';
   document.formv1.m527r151.value = '<?php echo "$m527r151";?>';
   document.formv1.m527r152.value = '<?php echo "$m527r152";?>';
   document.formv1.m527r153.value = '<?php echo "$m527r153";?>';
   document.formv1.m527r154.value = '<?php echo "$m527r154";?>';
   document.formv1.m527r155.value = '<?php echo "$m527r155";?>';
   document.formv1.m527r156.value = '<?php echo "$m527r156";?>';
   document.formv1.m527r157.value = '<?php echo "$m527r157";?>';
   document.formv1.m527r158.value = '<?php echo "$m527r158";?>';
   document.formv1.m527r159.value = '<?php echo "$m527r159";?>';
   document.formv1.m527r1510.value = '<?php echo "$m527r1510";?>';
   document.formv1.m527r161.value = '<?php echo "$m527r161";?>';
   document.formv1.m527r162.value = '<?php echo "$m527r162";?>';
   document.formv1.m527r163.value = '<?php echo "$m527r163";?>';
   document.formv1.m527r164.value = '<?php echo "$m527r164";?>';
   document.formv1.m527r165.value = '<?php echo "$m527r165";?>';
   document.formv1.m527r166.value = '<?php echo "$m527r166";?>';
   document.formv1.m527r167.value = '<?php echo "$m527r167";?>';
   document.formv1.m527r168.value = '<?php echo "$m527r168";?>';
   document.formv1.m527r169.value = '<?php echo "$m527r169";?>';
   document.formv1.m527r1610.value = '<?php echo "$m527r1610";?>';
   document.formv1.m527r171.value = '<?php echo "$m527r171";?>';
   document.formv1.m527r172.value = '<?php echo "$m527r172";?>';
   document.formv1.m527r173.value = '<?php echo "$m527r173";?>';
   document.formv1.m527r174.value = '<?php echo "$m527r174";?>';
   document.formv1.m527r175.value = '<?php echo "$m527r175";?>';
   document.formv1.m527r176.value = '<?php echo "$m527r176";?>';
   document.formv1.m527r177.value = '<?php echo "$m527r177";?>';
   document.formv1.m527r178.value = '<?php echo "$m527r178";?>';
   document.formv1.m527r179.value = '<?php echo "$m527r179";?>';
   document.formv1.m527r1710.value = '<?php echo "$m527r1710";?>';
<?php                      } ?>

<?php if ( $strana == 12 ) { ?>
   document.formv1.m527r181.value = '<?php echo "$m527r181";?>';
   document.formv1.m527r182.value = '<?php echo "$m527r182";?>';
   document.formv1.m527r183.value = '<?php echo "$m527r183";?>';
   document.formv1.m527r184.value = '<?php echo "$m527r184";?>';
   document.formv1.m527r185.value = '<?php echo "$m527r185";?>';
   document.formv1.m527r186.value = '<?php echo "$m527r186";?>';
   document.formv1.m527r187.value = '<?php echo "$m527r187";?>';
   document.formv1.m527r188.value = '<?php echo "$m527r188";?>';
   document.formv1.m527r1810.value = '<?php echo "$m527r1810";?>';
   document.formv1.m527r191.value = '<?php echo "$m527r191";?>';
   document.formv1.m527r192.value = '<?php echo "$m527r192";?>';
   document.formv1.m527r193.value = '<?php echo "$m527r193";?>';
   document.formv1.m527r194.value = '<?php echo "$m527r194";?>';
   document.formv1.m527r195.value = '<?php echo "$m527r195";?>';
   document.formv1.m527r196.value = '<?php echo "$m527r196";?>';
   document.formv1.m527r197.value = '<?php echo "$m527r197";?>';
   document.formv1.m527r198.value = '<?php echo "$m527r198";?>';
   document.formv1.m527r1910.value = '<?php echo "$m527r1910";?>';
   document.formv1.m527r201.value = '<?php echo "$m527r201";?>';
   document.formv1.m527r202.value = '<?php echo "$m527r202";?>';
   document.formv1.m527r203.value = '<?php echo "$m527r203";?>';
   document.formv1.m527r204.value = '<?php echo "$m527r204";?>';
   document.formv1.m527r205.value = '<?php echo "$m527r205";?>';
   document.formv1.m527r206.value = '<?php echo "$m527r206";?>';
   document.formv1.m527r207.value = '<?php echo "$m527r207";?>';
   document.formv1.m527r208.value = '<?php echo "$m527r208";?>';
   document.formv1.m527r2010.value = '<?php echo "$m527r2010";?>';
   document.formv1.m527r211.value = '<?php echo "$m527r211";?>';
   document.formv1.m527r212.value = '<?php echo "$m527r212";?>';
   document.formv1.m527r213.value = '<?php echo "$m527r213";?>';
   document.formv1.m527r214.value = '<?php echo "$m527r214";?>';
   document.formv1.m527r215.value = '<?php echo "$m527r215";?>';
   document.formv1.m527r216.value = '<?php echo "$m527r216";?>';
   document.formv1.m527r217.value = '<?php echo "$m527r217";?>';
   document.formv1.m527r218.value = '<?php echo "$m527r218";?>';
   document.formv1.m527r2110.value = '<?php echo "$m527r2110";?>';
   document.formv1.m527r221.value = '<?php echo "$m527r221";?>';
   document.formv1.m527r222.value = '<?php echo "$m527r222";?>';
   document.formv1.m527r223.value = '<?php echo "$m527r223";?>';
   document.formv1.m527r224.value = '<?php echo "$m527r224";?>';
   document.formv1.m527r225.value = '<?php echo "$m527r225";?>';
   document.formv1.m527r226.value = '<?php echo "$m527r226";?>';
   document.formv1.m527r227.value = '<?php echo "$m527r227";?>';
   document.formv1.m527r228.value = '<?php echo "$m527r228";?>';
   document.formv1.m527r2210.value = '<?php echo "$m527r2210";?>';
   document.formv1.m527r231.value = '<?php echo "$m527r231";?>';
   document.formv1.m527r232.value = '<?php echo "$m527r232";?>';
   document.formv1.m527r233.value = '<?php echo "$m527r233";?>';
   document.formv1.m527r234.value = '<?php echo "$m527r234";?>';
   document.formv1.m527r235.value = '<?php echo "$m527r235";?>';
   document.formv1.m527r236.value = '<?php echo "$m527r236";?>';
   document.formv1.m527r237.value = '<?php echo "$m527r237";?>';
   document.formv1.m527r238.value = '<?php echo "$m527r238";?>';
   document.formv1.m527r2310.value = '<?php echo "$m527r2310";?>';
   document.formv1.m527r241.value = '<?php echo "$m527r241";?>';
   document.formv1.m527r242.value = '<?php echo "$m527r242";?>';
   document.formv1.m527r243.value = '<?php echo "$m527r243";?>';
   document.formv1.m527r244.value = '<?php echo "$m527r244";?>';
   document.formv1.m527r245.value = '<?php echo "$m527r245";?>';
   document.formv1.m527r246.value = '<?php echo "$m527r246";?>';
   document.formv1.m527r247.value = '<?php echo "$m527r247";?>';
   document.formv1.m527r248.value = '<?php echo "$m527r248";?>';
   document.formv1.m527r2410.value = '<?php echo "$m527r2410";?>';
 //document.formv1.m527r991.value = '<?php echo "$m527r991";?>';
 //document.formv1.m527r992.value = '<?php echo "$m527r992";?>';
 //document.formv1.m527r993.value = '<?php echo "$m527r993";?>';
 //document.formv1.m527r994.value = '<?php echo "$m527r994";?>';
 //document.formv1.m527r995.value = '<?php echo "$m527r995";?>';
 //document.formv1.m527r996.value = '<?php echo "$m527r996";?>';
 //document.formv1.m527r997.value = '<?php echo "$m527r997";?>';
 //document.formv1.m527r998.value = '<?php echo "$m527r998";?>';
 //document.formv1.m527r999.value = '<?php echo "$m527r999";?>';
 //document.formv1.m527r9910.value = '<?php echo "$m527r9910";?>';
<?php                      } ?>

<?php if ( $strana == 13 ) { ?>
   document.formv1.m474r11.value = '<?php echo "$m474r11";?>';
   document.formv1.m474r12.value = '<?php echo "$m474r12";?>';
   document.formv1.m474r13.value = '<?php echo "$m474r13";?>';
   document.formv1.m474r21.value = '<?php echo "$m474r21";?>';
   document.formv1.m474r22.value = '<?php echo "$m474r22";?>';
   document.formv1.m474r23.value = '<?php echo "$m474r23";?>';
   document.formv1.m474r31.value = '<?php echo "$m474r31";?>';
   document.formv1.m474r32.value = '<?php echo "$m474r32";?>';
   document.formv1.m474r33.value = '<?php echo "$m474r33";?>';
   document.formv1.m474r41.value = '<?php echo "$m474r41";?>';
   document.formv1.m474r42.value = '<?php echo "$m474r42";?>';
   document.formv1.m474r43.value = '<?php echo "$m474r43";?>';
   document.formv1.m474r51.value = '<?php echo "$m474r51";?>';
   document.formv1.m474r52.value = '<?php echo "$m474r52";?>';
   document.formv1.m474r53.value = '<?php echo "$m474r53";?>';
   document.formv1.m474r61.value = '<?php echo "$m474r61";?>';
   document.formv1.m474r62.value = '<?php echo "$m474r62";?>';
   document.formv1.m474r63.value = '<?php echo "$m474r63";?>';
   document.formv1.m474r72.value = '<?php echo "$m474r72";?>';
   document.formv1.m474r73.value = '<?php echo "$m474r73";?>';
 //document.formv1.m474r991.value = '<?php echo "$m474r991";?>';
 //document.formv1.m474r992.value = '<?php echo "$m474r992";?>';
 //document.formv1.m474r993.value = '<?php echo "$m474r993";?>';
   document.formv1.m514r1.value = '<?php echo "$m514r1";?>';
   document.formv1.m514r2.value = '<?php echo "$m514r2";?>';
   document.formv1.m514r3.value = '<?php echo "$m514r3";?>';
 //document.formv1.m514r99.value = '<?php echo "$m514r99";?>';
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

  function CisCPAp1()
  {
   window.open('../dokumenty/statistika2014/cpa_ciselnik_pril1v13.pdf', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_metodika.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../ucto/statistika_vts101.php?copern=11&strana=9999', '_blank');
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../ucto/statistika_vts101.php?copern=200&drupoh=1&page=1', '_self');
  }
  function NacitajZobratovky(modul)
  {
   window.open('../ucto/uobrat.php?modul=' + modul + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=20201&vyb_ume=<?php echo "12.".$kli_vrok; ?>', '_self');
  }
  function NacitajZosuvahy(modul)
  {
   window.open('../ucto/suvaha__x.php?modul=' + modul + '&copern=10&drupoh=1&page=1&tis=1&typ=PDF&cstat=20201&vyb_ume=<?php echo "12.".$kli_vrok; ?>', '_self');
  }

//bud alebo checkbox v module 100041
  function klikm100041ano()
  {
   document.formv1.mod100041nie.checked = false;
  }
  function klikm100041nie()
  {
   document.formv1.mod100041ano.checked = false;
  }
//bud alebo checkbox v module 100042
  function klikm100042ano()
  {
   document.formv1.mod100042nie.checked = false;
  }
  function klikm100042nie()
  {
   document.formv1.mod100042ano.checked = false;
  }
//bud alebo checkbox v module 100043
  function klikm100043ano()
  {
   document.formv1.mod100043nie.checked = false;
  }
  function klikm100043nie()
  {
   document.formv1.mod100043ano.checked = false;
  }
//bud alebo checkbox v module 100036
  function klikm100036kal()
  {
   document.formv1.mod100036hos.checked = false;
  }
  function klikm100036hos()
  {
   document.formv1.mod100036kal.checked = false;
  }
//bud alebo checkbox v module 100069
  function klikm100069ano()
  {
   document.formv1.mod100069nie.checked = false;
  }
  function klikm100069nie()
  {
   document.formv1.mod100069ano.checked = false;
  }
//bud alebo checkbox v module 100071
  function klikm1101r4ano()
  {
   document.formv1.m1101r4b.checked = false;
  }
  function klikm1101r4nie()
  {
   document.formv1.m1101r4a.checked = false;
  }
//bud alebo checkbox v module 100075
  function klikm1101r5ano()
  {
   document.formv1.m1101r5b.checked = false;
  }
  function klikm1101r5nie()
  {
   document.formv1.m1101r5a.checked = false;
  }
//bud alebo checkbox v module 100079
  function klikm1101r6ano()
  {
   document.formv1.m1101r6b.checked = false;
  }
  function klikm1101r6nie()
  {
   document.formv1.m1101r6a.checked = false;
  }
//bud alebo checkbox v module 100082
  function klikm1101r7ano()
  {
   document.formv1.m1101r7b.checked = false;
  }
  function klikm1101r7nie()
  {
   document.formv1.m1101r7a.checked = false;
  }
//bud alebo checkbox v module 100131
  function klikm1005r1ano()
  {
   document.formv1.m1005r1b.checked = false;
  }
  function klikm1005r1nie()
  {
   document.formv1.m1005r1a.checked = false;
  }
//bud alebo checkbox v module 100044
  function klikm100044ano()
  {
   document.formv1.m100044nie.checked = false;
  }
  function klikm100044nie()
  {
   document.formv1.m100044ano.checked = false;
  }
//bud alebo checkbox v module 100103
  function klikm1527r1ano()
  {
   document.formv1.m1527r1b.checked = false;
  }
  function klikm1527r1nie()
  {
   document.formv1.m1527r1a.checked = false;
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
  <td class="header">Roèný výkaz produkèných odvetví vo vybraných trhových službách VTS 1-01</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/infocloud_blue_icon.png" onclick="CisCPAp1();"
     title="Èíselník CPA - príloha è.1" class="btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();"
     title="Metodické vysvetlivky k obsahu výkazu" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();"
     title="Zobrazi všetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<?php
$sirka=950;
$vyska=1300;
if ( $strana == 7 OR $strana == 8 OR $strana == 11 OR $strana == 12 )
{
$sirka=1250; $vyska=920;
}
?>
<div id="content" style="width:<?php echo $sirka; ?>px; height:<?php echo $vyska; ?>px;">
<FORM name="formv1" method="post" action="statistika_vts101.php?copern=103&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive";
$clas5="noactive"; $clas6="noactive"; $clas7="noactive"; $clas8="noactive";
$clas9="noactive"; $clas10="noactive"; $clas11="noactive"; $clas12="noactive";
$clas13="noactive"; $clas14="noactive"; $clas15="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";
if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active";
if ( $strana == 9 ) $clas9="active"; if ( $strana == 10 ) $clas10="active";
if ( $strana == 11 ) $clas11="active"; if ( $strana == 12 ) $clas12="active";
if ( $strana == 13 ) $clas13="active"; if ( $strana == 14 ) $clas14="active";
if ( $strana == 15 ) $clas15="active";
$source="statistika_vts101.php?";
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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=13', '_self');" class="<?php echo $clas13; ?> toleft">13</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=13', '_blank');" class="<?php echo $clas13; ?> toright">13</a>
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
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 265kB">

<span class="text-echo" style="top:278px; left:445px; font-size:18px; letter-spacing:27px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:805px; left:53px;"><?php echo "$fir_fnaz $fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<!-- sknace -->
<input type="text" name="cinnost" id="cinnost" style="width:487px; top:857px; left:53px;"/> <!-- dopyt, nový input -->
<span class="text-echo" style="top:863px; left:573px; font-size:16px; letter-spacing:25px;"><?php echo $sknace; ?></span>

<span class="text-echo" style="top:810px; left:808px;"><?php echo $okres; ?></span>
<img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastavi kód okresu"
     class="btn-row-tool" style="top:809px; left:839px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:935px; left:53px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:945px; left:388px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:992px; left:53px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);"
       style="width:90px; top:989px; left:390px;"/>

<!-- modul 100307 -->
<span class="text-echo center" style="width:499px; top:1156px; left:400px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo center" style="width:499px; top:1182px; left:400px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo center" style="width:499px; top:1208px; left:400px;"><?php echo $fir_fem1; ?></span>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str2.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 2.strana 256kB">

<!-- modul 100315 -->
<!-- <input type="text" name="cinnost" id="cinnost" style="width:487px; top:180px; left:405px;"/> -->
<span class="text-echo center" style="top:184px; left:410px;"><?php echo $cinnost; ?></span> <!-- dopyt, na 1.strane to isté spravi výpis -->
<span class="text-echo center" style="top:210px; left:630px;"><?php echo $sknace; ?></span>

<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:373px; left:750px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:411px; left:750px;"/>

<!-- modul 100041 -->
<input type="checkbox" name="mod100041ano" value="1" onchange="klikm100041ano();"
       style="top:539px; left:839px;"/>
<input type="checkbox" name="mod100041nie" value="1" onchange="klikm100041nie();"
       style="top:560px; left:839px;"/>

<!-- modul 100042 -->
<input type="checkbox" name="mod100042ano" value="1" onchange="klikm100042ano();"
       style="top:653px; left:839px;"/>
<input type="checkbox" name="mod100042nie" value="1" onchange="klikm100042nie();"
       style="top:673px; left:839px;"/>

<!-- modul 100043 -->
<input type="checkbox" name="mod100043ano" value="1" onchange="klikm100043ano();"
       style="top:766px; left:839px;"/>
<input type="checkbox" name="mod100043nie" value="1" onchange="klikm100043nie();"
       style="top:787px; left:839px;"/>

<!-- modul 100008 -->
<input type="text" name="m1100r4" id="m1100r4" maxlength="8" style="width:100px; top:894px; left:640px;"/>
<input type="text" name="m1100r5" id="m1100r5" maxlength="8" style="width:100px; top:921px; left:640px;"/>
<input type="text" name="m1100r6" id="m1100r6" maxlength="8" style="width:100px; top:950px; left:640px;"/>
<input type="text" name="m1100r7" id="m1100r7" maxlength="8" style="width:100px; top:979px; left:640px;"/>
<input type="text" name="m1100r8" id="m1100r8" maxlength="8" style="width:100px; top:1007px; left:640px;"/>
<input type="text" name="m1100r9" id="m1100r9" maxlength="8" style="width:100px; top:1035px; left:640px;"/>
<input type="text" name="m1100r10" id="m1100r10" maxlength="8" style="width:100px; top:1064px; left:640px;"/>
<input type="text" name="m1100r11" id="m1100r11" maxlength="8" style="width:100px; top:1093px; left:640px;"/>
<input type="text" name="m1100r12" id="m1100r12" maxlength="8" style="width:100px; top:1121px; left:640px;"/>
<input type="text" name="m1100r13" id="m1100r13" maxlength="8" style="width:100px; top:1150px; left:640px;"/>

<!-- modul 100036 -->
<input type="checkbox" name="mod100036kal" value="1" onchange="klikm100036kal();"
       style="top:1223px; left:839px;"/>
<input type="checkbox" name="mod100036hos" value="1" onchange="klikm100036hos();"
       style="top:1243px; left:839px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str3.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 3.strana 244kB">
<span class="text-echo" style="top:85px; left:479px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 100037 -->
<input type="text" name="mod100037" id="mod100037" style="width:253px; top:160px; left:643px;"/>

<!-- modul 100214 -->
<input type="text" name="m100214r01" id="m100214r01" style="width:100px; top:277px; left:670px;"/>
<input type="text" name="m100214r02" id="m100214r02" style="width:100px; top:303px; left:670px;"/>

<!-- modul 100069 -->
<input type="checkbox" name="mod100069ano" value="1" onchange="klikm100069ano();"
       style="top:443px; left:839px;"/>
<input type="checkbox" name="mod100069nie" value="1" onchange="klikm100069nie();"
       style="top:463px; left:839px;"/>

<!-- modul 100073 -->
<input type="text" name="m1101r2" id="m1101r2" onkeyup="CiarkaNaBodku(this);"
       style="width:253px; top:536px; left:643px;"/>

<!-- modul 100074 -->
<input type="text" name="m1101r3" id="m1101r3" style="width:253px; top:722px; left:643px;"/>

<!-- modul 100071 -->
<input type="checkbox" name="m1101r4a" value="1" onclick="klikm1101r4ano();"
       style="top:782px; left:839px;"/>
<input type="checkbox" name="m1101r4b" value="1" onclick="klikm1101r4nie();"
       style="top:803px; left:839px;"/>

<!-- modul 100075 -->
<input type="checkbox" name="m1101r5a" value="1" onclick="klikm1101r5ano();"
       style="top:903px; left:839px;"/>
<input type="checkbox" name="m1101r5b" value="1" onclick="klikm1101r5nie();"
       style="top:924px; left:839px;"/>

<!-- modul 100079 -->
<input type="checkbox" name="m1101r6a" value="1" onclick="klikm1101r6ano();"
       style="top:1027px; left:839px;"/>
<input type="checkbox" name="m1101r6b" value="1" onclick="klikm1101r6nie();"
       style="top:1048px; left:839px;"/>

<!-- modul 100082 -->
<input type="checkbox" name="m1101r7a" value="1" onclick="klikm1101r7ano();"
       style="top:1183px; left:839px;"/>
<input type="checkbox" name="m1101r7b" value="1" onclick="klikm1101r7nie();"
       style="top:1204px; left:839px;"/>
<?php                                        } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str4.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 4.strana 232kB">

<!-- modul 398 -->
<input type="text" name="m398r11" id="m398r11" style="width:100px; top:268px; left:437px;"/>
<input type="text" name="m398r12" id="m398r12" style="width:90px; top:268px; left:549px;"/>
<input type="text" name="m398r13" id="m398r13" style="width:112px; top:268px; left:651px;"/>
<input type="text" name="m398r14" id="m398r14" style="width:115px; top:268px; left:776px;"/>
<input type="text" name="m398r21" id="m398r21" style="width:100px; top:296px; left:437px;"/>
<input type="text" name="m398r22" id="m398r22" style="width:90px; top:296px; left:549px;"/>
<input type="text" name="m398r23" id="m398r23" style="width:112px; top:296px; left:651px;"/>
<input type="text" name="m398r24" id="m398r24" style="width:115px; top:296px; left:776px;"/>
<span class="text-echo" style="top:329px; right:410px;"><?php echo $m398r991; ?></span>
<span class="text-echo" style="top:329px; right:308px;"><?php echo $m398r992; ?></span>
<span class="text-echo" style="top:329px; right:184px;"><?php echo $m398r993; ?></span>
<span class="text-echo" style="top:329px; right:56px;"><?php echo $m398r994; ?></span>

<!-- modul 100131 -->
<input type="checkbox" name="m1005r1a" value="1" onclick="klikm1005r1ano();"
       style="top:434px; left:839px;"/>
<input type="checkbox" name="m1005r1b" value="1" onclick="klikm1005r1nie();"
       style="top:455px; left:839px;"/>


<!-- modul 405 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky"
     onclick="NacitajZobratovky(405);" style="top:505px; left:450px;" class="btn-row-tool">
<input type="text" name="m405r11" id="m405r11" style="width:100px; top:624px; left:590px;"/>
<input type="text" name="m405r12" id="m405r12" style="width:100px; top:624px; left:760px;"/>
<input type="text" name="m405r21" id="m405r21" style="width:100px; top:652px; left:590px;"/>
<input type="text" name="m405r31" id="m405r31" style="width:100px; top:681px; left:590px;"/>
<input type="text" name="m405r32" id="m405r32" style="width:100px; top:681px; left:760px;"/>
<input type="text" name="m405r41" id="m405r41" style="width:100px; top:709px; left:590px;"/>
<input type="text" name="m405r51" id="m405r51" style="width:100px; top:738px; left:590px;"/>
<input type="text" name="m405r61" id="m405r61" style="width:100px; top:770px; left:590px;"/>
<input type="text" name="m405r71" id="m405r71" style="width:100px; top:803px; left:590px;"/>
<input type="text" name="m405r81" id="m405r81" style="width:100px; top:831px; left:590px;"/>
<input type="text" name="m405r82" id="m405r82" style="width:100px; top:831px; left:760px;"/>
<span class="text-echo" style="top:864px; right:255px;"><?php echo $m405r991; ?></span>
<span class="text-echo" style="top:864px; right:84px;"><?php echo $m405r992; ?></span>

<!-- modul 406 -->
<input type="text" name="m406r1" id="m406r1" style="width:100px; top:1001px; left:630px;"/>
<input type="text" name="m406r2" id="m406r2" style="width:100px; top:1029px; left:630px;"/>
<input type="text" name="m406r3" id="m406r3" style="width:100px; top:1057px; left:630px;"/>
<input type="text" name="m406r4" id="m406r4" style="width:100px; top:1086px; left:630px;"/>
<input type="text" name="m406r5" id="m406r5" style="width:100px; top:1114px; left:630px;"/>
<input type="text" name="m406r6" id="m406r6" style="width:100px; top:1143px; left:630px;"/>
<input type="text" name="m406r7" id="m406r7" style="width:100px; top:1171px; left:630px;"/>
<span class="text-echo" style="top:1204px; right:215px;"><?php echo $m406r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str5.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 5.strana 268kB">
<span class="text-echo" style="top:76px; left:480px; font-size:16px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>

<!-- modul 558 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky"
     onclick="NacitajZobratovky(558);" style="top:108px; left:387px;" class="btn-row-tool">
<input type="text" name="m558r1" id="m558r1" style="width:100px; top:195px; left:680px;"/>
<input type="text" name="m558r2" id="m558r2" style="width:100px; top:219px; left:680px;"/>
<input type="text" name="m558r3" id="m558r3" style="width:100px; top:243px; left:680px;"/>
<input type="text" name="m558r4" id="m558r4" style="width:100px; top:267px; left:680px;"/>
<input type="text" name="m558r5" id="m558r5" style="width:100px; top:291px; left:680px;"/>
<input type="text" name="m558r6" id="m558r6" style="width:100px; top:315px; left:680px;"/>
<input type="text" name="m558r7" id="m558r7" style="width:100px; top:339px; left:680px;"/>
<input type="text" name="m558r8" id="m558r8" style="width:100px; top:363px; left:680px;"/>
<input type="text" name="m558r9" id="m558r9" style="width:100px; top:387px; left:680px;"/>
<input type="text" name="m558r10" id="m558r10" style="width:100px; top:411px; left:680px;"/>
<input type="text" name="m558r11" id="m558r11" style="width:100px; top:435px; left:680px;"/>
<input type="text" name="m558r12" id="m558r12" style="width:100px; top:460px; left:680px;"/>
<input type="text" name="m558r13" id="m558r13" style="width:100px; top:484px; left:680px;"/>
<input type="text" name="m558r14" id="m558r14" style="width:100px; top:508px; left:680px;"/>
<input type="text" name="m558r15" id="m558r15" style="width:100px; top:532px; left:680px;"/>
<input type="text" name="m558r16" id="m558r16" style="width:100px; top:556px; left:680px;"/>
<input type="text" name="m558r17" id="m558r17" style="width:100px; top:580px; left:680px;"/>
<input type="text" name="m558r18" id="m558r18" style="width:100px; top:604px; left:680px;"/>
<span class="text-echo" style="top:633px; right:170px;"><?php echo $m558r99; ?></span>

<!-- modul 585 -->
<input type="text" name="m585r01" id="m585r01" style="width:100px; top:981px; left:680px;"/>
<input type="text" name="m585r02" id="m585r02" style="width:100px; top:1012px; left:680px;"/>
<input type="text" name="m585r3k" id="m585r3k" style="width:112px; top:1045px; left:397px;"/>
<input type="text" name="m585r03" id="m585r03" style="width:100px; top:1045px; left:680px;"/>
<input type="text" name="m585r4k" id="m585r4k" style="width:112px; top:1075px; left:397px;"/>
<input type="text" name="m585r04" id="m585r04" style="width:100px; top:1075px; left:680px;"/>
<input type="text" name="m585r5k" id="m585r5k" style="width:112px; top:1106px; left:397px;"/>
<input type="text" name="m585r05" id="m585r05" style="width:100px; top:1106px; left:680px;"/>

<!-- modul 100044 -->
<input type="checkbox" name="m100044ano" value="1" onchange="klikm100044ano();"
       style="top:1238px; left:839px;"/>
<input type="checkbox" name="m100044nie" value="1" onchange="klikm100044nie();"
       style="top:1259px; left:839px;"/>
<?php                                        } ?>


<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str6.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 6.strana 228kB">

<!-- modul 571 -->
<input type="text" name="m571r10" id="m571r10" style="width:115px; top:261px; left:50px;"/>
<?php $cslr="1."; if ( $m571r10 == '' ) { $cslr=""; } ?>
<span class="text-echo" style="top:266px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r12" id="m571r12" style="width:133px; top:262px; left:269px;"/>
<input type="text" name="m571r13" id="m571r13" style="width:58px; top:262px; left:412px;"/>
<input type="text" name="m571r15" id="m571r15" style="width:58px; top:262px; left:548px;"/>
<input type="text" name="m571r16" id="m571r16" style="width:80px; top:262px; left:616px;"/>
<input type="text" name="m571r17" id="m571r17" style="width:103px; top:262px; left:707px;"/>
<input type="text" name="m571r18" id="m571r18" style="width:71px; top:262px; left:820px;"/>
<input type="text" name="m571r20" id="m571r20" style="width:115px; top:288px; left:50px;"/>
<?php $cslr="2."; if ( $m571r20 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:292px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r22" id="m571r22" style="width:133px; top:288px; left:269px;"/>
<input type="text" name="m571r23" id="m571r23" style="width:58px; top:288px; left:412px;"/>
<input type="text" name="m571r25" id="m571r25" style="width:58px; top:288px; left:548px;"/>
<input type="text" name="m571r26" id="m571r26" style="width:80px; top:288px; left:616px;"/>
<input type="text" name="m571r27" id="m571r27" style="width:103px; top:288px; left:707px;"/>
<input type="text" name="m571r28" id="m571r28" style="width:71px; top:288px; left:820px;"/>
<input type="text" name="m571r30" id="m571r30" style="width:115px; top:314px; left:50px;"/>
<?php $cslr="3."; if ( $m571r30 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:318px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r32" id="m571r32" style="width:133px; top:314px; left:269px;"/>
<input type="text" name="m571r33" id="m571r33" style="width:58px; top:314px; left:412px;"/>
<input type="text" name="m571r35" id="m571r35" style="width:58px; top:314px; left:548px;"/>
<input type="text" name="m571r36" id="m571r36" style="width:80px; top:314px; left:616px;"/>
<input type="text" name="m571r37" id="m571r37" style="width:103px; top:314px; left:707px;"/>
<input type="text" name="m571r38" id="m571r38" style="width:71px; top:314px; left:820px;"/>
<input type="text" name="m571r40" id="m571r40" style="width:115px; top:339px; left:50px;"/>
<?php $cslr="4."; if ( $m571r40 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:343px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r42" id="m571r42" style="width:133px; top:340px; left:269px;"/>
<input type="text" name="m571r43" id="m571r43" style="width:58px; top:340px; left:412px;"/>
<input type="text" name="m571r45" id="m571r45" style="width:58px; top:340px; left:548px;"/>
<input type="text" name="m571r46" id="m571r46" style="width:80px; top:340px; left:616px;"/>
<input type="text" name="m571r47" id="m571r47" style="width:103px; top:340px; left:707px;"/>
<input type="text" name="m571r48" id="m571r48" style="width:71px; top:340px; left:820px;"/>
<input type="text" name="m571r50" id="m571r50" style="width:115px; top:366px; left:50px;"/>
<?php $cslr="5."; if ( $m571r50 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:370px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r52" id="m571r52" style="width:133px; top:365px; left:269px;"/>
<input type="text" name="m571r53" id="m571r53" style="width:58px; top:365px; left:412px;"/>
<input type="text" name="m571r55" id="m571r55" style="width:58px; top:365px; left:548px;"/>
<input type="text" name="m571r56" id="m571r56" style="width:80px; top:365px; left:616px;"/>
<input type="text" name="m571r57" id="m571r57" style="width:103px; top:365px; left:707px;"/>
<input type="text" name="m571r58" id="m571r58" style="width:71px; top:365px; left:820px;"/>
<input type="text" name="m571r60" id="m571r60" style="width:115px; top:391px; left:50px;"/>
<?php $cslr="6."; if ( $m571r60 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:395px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r62" id="m571r62" style="width:133px; top:391px; left:269px;"/>
<input type="text" name="m571r63" id="m571r63" style="width:58px; top:391px; left:412px;"/>
<input type="text" name="m571r65" id="m571r65" style="width:58px; top:391px; left:548px;"/>
<input type="text" name="m571r66" id="m571r66" style="width:80px; top:391px; left:616px;"/>
<input type="text" name="m571r67" id="m571r67" style="width:103px; top:391px; left:707px;"/>
<input type="text" name="m571r68" id="m571r68" style="width:71px; top:391px; left:820px;"/>
<input type="text" name="m571r70" id="m571r70" style="width:115px; top:417px; left:50px;"/>
<?php $cslr="7."; if ( $m571r70 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:421px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r72" id="m571r72" style="width:133px; top:417px; left:269px;"/>
<input type="text" name="m571r73" id="m571r73" style="width:58px; top:417px; left:412px;"/>
<input type="text" name="m571r75" id="m571r75" style="width:58px; top:417px; left:548px;"/>
<input type="text" name="m571r76" id="m571r76" style="width:80px; top:417px; left:616px;"/>
<input type="text" name="m571r77" id="m571r77" style="width:103px; top:417px; left:707px;"/>
<input type="text" name="m571r78" id="m571r78" style="width:71px; top:417px; left:820px;"/>
<input type="text" name="m571r80" id="m571r80" style="width:115px; top:443px; left:50px;"/>
<?php $cslr="8."; if ( $m571r80 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:447px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r82" id="m571r82" style="width:133px; top:443px; left:269px;"/>
<input type="text" name="m571r83" id="m571r83" style="width:58px; top:443px; left:412px;"/>
<input type="text" name="m571r85" id="m571r85" style="width:58px; top:443px; left:548px;"/>
<input type="text" name="m571r86" id="m571r86" style="width:80px; top:443px; left:616px;"/>
<input type="text" name="m571r87" id="m571r87" style="width:103px; top:443px; left:707px;"/>
<input type="text" name="m571r88" id="m571r88" style="width:71px; top:443px; left:820px;"/>
<input type="text" name="m571r90" id="m571r90" style="width:115px; top:469px; left:50px;"/>
<?php $cslr="9."; if ( $m571r90 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:473px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r92" id="m571r92" style="width:133px; top:469px; left:269px;"/>
<input type="text" name="m571r93" id="m571r93" style="width:58px; top:469px; left:412px;"/>
<input type="text" name="m571r95" id="m571r95" style="width:58px; top:469px; left:548px;"/>
<input type="text" name="m571r96" id="m571r96" style="width:80px; top:469px; left:616px;"/>
<input type="text" name="m571r97" id="m571r97" style="width:103px; top:469px; left:707px;"/>
<input type="text" name="m571r98" id="m571r98" style="width:71px; top:469px; left:820px;"/>

<!-- modul 581 -->
<!-- dopyt, upravi súètový vzorec -->
<input type="text" name="m581r1" id="m581r1" style="width:100px; top:692px; left:680px;"/>
<input type="text" name="m581r2" id="m581r2" style="width:100px; top:718px; left:680px;"/>
<input type="text" name="m581r3" id="m581r3" style="width:100px; top:743px; left:680px;"/>
<input type="text" name="m581r4" id="m581r4" style="width:100px; top:770px; left:680px;"/>
<input type="text" name="m581r5" id="m581r5" style="width:100px; top:795px; left:680px;"/>
<input type="text" name="m581r6" id="m581r6" style="width:100px; top:821px; left:680px;"/>
<input type="text" name="m581r7" id="m581r7" style="width:100px; top:847px; left:680px;"/>
<input type="text" name="m581r8" id="m581r8" style="width:100px; top:873px; left:680px;"/>
<input type="text" name="m581r12" id="m581r12" style="width:100px; top:899px; left:680px;"/>
<span class="text-echo" style="top:929px; right:165px;"><?php echo $m581r99; ?></span>

<!-- modul 100301, 100302, 100303, 100304 dorobi, sú nové -->

<?php                                        } ?>


<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str7.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 7.strana 259kB" style="width:1250px; height:1000px;">
<span class="text-echo" style="top:84px; left:937px; font-size:16px; letter-spacing:14px;"><?php echo $fir_ficox; ?></span>

<!-- modul 513 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky"
     onclick="NacitajZobratovky(513);" class="btn-row-tool" style="top:114px; left:237px;">
<input type="text" name="m513r11" id="m513r11" style="width:89px; top:258px; left:375px;"/>
<input type="text" name="m513r12" id="m513r12" style="width:75px; top:258px; left:471px;"/>
<input type="text" name="m513r13" id="m513r13" style="width:67px; top:258px; left:553px;"/>
<input type="text" name="m513r14" id="m513r14" style="width:105px; top:258px; left:627px;"/>
<input type="text" name="m513r15" id="m513r15" style="width:82px; top:258px; left:739px;"/>
<input type="text" name="m513r16" id="m513r16" style="width:105px; top:258px; left:828px;"/>
<input type="text" name="m513r17" id="m513r17" style="width:82px; top:258px; left:940px;"/>
<input type="text" name="m513r18" id="m513r18" style="width:74px; top:258px; left:1029px;"/>
<input type="text" name="m513r19" id="m513r19" style="width:100px; top:258px; left:1111px;"/>
<input type="text" name="m513r21" id="m513r21" style="width:89px; top:281px; left:375px;"/>
<input type="text" name="m513r22" id="m513r22" style="width:75px; top:281px; left:471px;"/>
<input type="text" name="m513r23" id="m513r23" style="width:67px; top:281px; left:553px;"/>
<input type="text" name="m513r24" id="m513r24" style="width:105px; top:281px; left:627px;"/>
<input type="text" name="m513r25" id="m513r25" style="width:82px; top:281px; left:739px;"/>
<input type="text" name="m513r26" id="m513r26" style="width:105px; top:281px; left:828px;"/>
<input type="text" name="m513r27" id="m513r27" style="width:82px; top:281px; left:940px;"/>
<input type="text" name="m513r28" id="m513r28" style="width:74px; top:281px; left:1029px;"/>
<input type="text" name="m513r29" id="m513r29" style="width:100px; top:281px; left:1111px;"/>
<input type="text" name="m513r31" id="m513r31" style="width:89px; top:305px; left:375px;"/>
<input type="text" name="m513r32" id="m513r32" style="width:75px; top:305px; left:471px;"/>
<input type="text" name="m513r33" id="m513r33" style="width:67px; top:305px; left:553px;"/>
<input type="text" name="m513r34" id="m513r34" style="width:105px; top:305px; left:627px;"/>
<input type="text" name="m513r35" id="m513r35" style="width:82px; top:305px; left:739px;"/>
<input type="text" name="m513r36" id="m513r36" style="width:105px; top:305px; left:828px;"/>
<input type="text" name="m513r37" id="m513r37" style="width:82px; top:305px; left:940px;"/>
<input type="text" name="m513r38" id="m513r38" style="width:74px; top:305px; left:1029px;"/>
<input type="text" name="m513r39" id="m513r39" style="width:100px; top:305px; left:1111px;"/>
<input type="text" name="m513r41" id="m513r41" style="width:89px; top:328px; left:375px;"/>
<input type="text" name="m513r42" id="m513r42" style="width:75px; top:328px; left:471px;"/>
<input type="text" name="m513r43" id="m513r43" style="width:67px; top:328px; left:553px;"/>
<input type="text" name="m513r44" id="m513r44" style="width:105px; top:328px; left:627px;"/>
<input type="text" name="m513r45" id="m513r45" style="width:82px; top:328px; left:739px;"/>
<input type="text" name="m513r46" id="m513r46" style="width:105px; top:328px; left:828px;"/>
<input type="text" name="m513r47" id="m513r47" style="width:82px; top:328px; left:940px;"/>
<input type="text" name="m513r48" id="m513r48" style="width:74px; top:328px; left:1029px;"/>
<input type="text" name="m513r49" id="m513r49" style="width:100px; top:328px; left:1111px;"/>
<input type="text" name="m513r51" id="m513r51" style="width:89px; top:351px; left:375px;"/>
<input type="text" name="m513r52" id="m513r52" style="width:75px; top:351px; left:471px;"/>
<input type="text" name="m513r53" id="m513r53" style="width:67px; top:351px; left:553px;"/>
<input type="text" name="m513r54" id="m513r54" style="width:105px; top:351px; left:627px;"/>
<input type="text" name="m513r55" id="m513r55" style="width:82px; top:351px; left:739px;"/>
<input type="text" name="m513r56" id="m513r56" style="width:105px; top:351px; left:828px;"/>
<input type="text" name="m513r57" id="m513r57" style="width:82px; top:351px; left:940px;"/>
<input type="text" name="m513r58" id="m513r58" style="width:74px; top:351px; left:1029px;"/>
<input type="text" name="m513r59" id="m513r59" style="width:100px; top:351px; left:1111px;"/>
<input type="text" name="m513r61" id="m513r61" style="width:89px; top:375px; left:375px;"/>
<input type="text" name="m513r62" id="m513r62" style="width:75px; top:375px; left:471px;"/>
<input type="text" name="m513r63" id="m513r63" style="width:67px; top:375px; left:553px;"/>
<input type="text" name="m513r64" id="m513r64" style="width:105px; top:375px; left:627px;"/>
<input type="text" name="m513r65" id="m513r65" style="width:82px; top:375px; left:739px;"/>
<input type="text" name="m513r66" id="m513r66" style="width:105px; top:375px; left:828px;"/>
<input type="text" name="m513r67" id="m513r67" style="width:82px; top:375px; left:940px;"/>
<input type="text" name="m513r68" id="m513r68" style="width:74px; top:375px; left:1029px;"/>
<input type="text" name="m513r69" id="m513r69" style="width:100px; top:375px; left:1111px;"/>
<input type="text" name="m513r71" id="m513r71" style="width:89px; top:399px; left:375px;"/>
<input type="text" name="m513r72" id="m513r72" style="width:75px; top:399px; left:471px;"/>
<input type="text" name="m513r73" id="m513r73" style="width:67px; top:399px; left:553px;"/>
<input type="text" name="m513r74" id="m513r74" style="width:105px; top:399px; left:627px;"/>
<input type="text" name="m513r75" id="m513r75" style="width:82px; top:399px; left:739px;"/>
<input type="text" name="m513r76" id="m513r76" style="width:105px; top:399px; left:828px;"/>
<input type="text" name="m513r77" id="m513r77" style="width:82px; top:399px; left:940px;"/>
<input type="text" name="m513r78" id="m513r78" style="width:74px; top:399px; left:1029px;"/>
<input type="text" name="m513r79" id="m513r79" style="width:100px; top:399px; left:1111px;"/>
<input type="text" name="m513r81" id="m513r81" style="width:89px; top:423px; left:375px;"/>
<input type="text" name="m513r82" id="m513r82" style="width:75px; top:423px; left:471px;"/>
<input type="text" name="m513r83" id="m513r83" style="width:67px; top:423px; left:553px;"/>
<input type="text" name="m513r84" id="m513r84" style="width:105px; top:423px; left:627px;"/>
<input type="text" name="m513r85" id="m513r85" style="width:82px; top:423px; left:739px;"/>
<input type="text" name="m513r86" id="m513r86" style="width:105px; top:423px; left:828px;"/>
<input type="text" name="m513r87" id="m513r87" style="width:82px; top:423px; left:940px;"/>
<input type="text" name="m513r88" id="m513r88" style="width:74px; top:423px; left:1029px;"/>
<input type="text" name="m513r89" id="m513r89" style="width:100px; top:423px; left:1111px;"/>
<input type="text" name="m513r91" id="m513r91" style="width:89px; top:446px; left:375px;"/>
<input type="text" name="m513r92" id="m513r92" style="width:75px; top:446px; left:471px;"/>
<input type="text" name="m513r93" id="m513r93" style="width:67px; top:446px; left:553px;"/>
<input type="text" name="m513r94" id="m513r94" style="width:105px; top:446px; left:627px;"/>
<input type="text" name="m513r95" id="m513r95" style="width:82px; top:446px; left:739px;"/>
<input type="text" name="m513r96" id="m513r96" style="width:105px; top:446px; left:828px;"/>
<input type="text" name="m513r97" id="m513r97" style="width:82px; top:446px; left:940px;"/>
<input type="text" name="m513r98" id="m513r98" style="width:74px; top:446px; left:1029px;"/>
<input type="text" name="m513r99" id="m513r99" style="width:100px; top:446px; left:1111px;"/>
<input type="text" name="m513r101" id="m513r101" style="width:89px; top:470px; left:375px;"/>
<input type="text" name="m513r102" id="m513r102" style="width:75px; top:470px; left:471px;"/>
<input type="text" name="m513r103" id="m513r103" style="width:67px; top:470px; left:553px;"/>
<input type="text" name="m513r104" id="m513r104" style="width:105px; top:470px; left:627px;"/>
<input type="text" name="m513r105" id="m513r105" style="width:82px; top:470px; left:739px;"/>
<input type="text" name="m513r106" id="m513r106" style="width:105px; top:470px; left:828px;"/>
<input type="text" name="m513r107" id="m513r107" style="width:82px; top:470px; left:940px;"/>
<input type="text" name="m513r108" id="m513r108" style="width:74px; top:470px; left:1029px;"/>
<input type="text" name="m513r109" id="m513r109" style="width:100px; top:470px; left:1111px;"/>
<input type="text" name="m513r111" id="m513r111" style="width:89px; top:493px; left:375px;"/>
<input type="text" name="m513r112" id="m513r112" style="width:75px; top:493px; left:471px;"/>
<input type="text" name="m513r113" id="m513r113" style="width:67px; top:493px; left:553px;"/>
<input type="text" name="m513r114" id="m513r114" style="width:105px; top:493px; left:627px;"/>
<input type="text" name="m513r115" id="m513r115" style="width:82px; top:493px; left:739px;"/>
<input type="text" name="m513r116" id="m513r116" style="width:105px; top:493px; left:828px;"/>
<input type="text" name="m513r117" id="m513r117" style="width:82px; top:493px; left:940px;"/>
<input type="text" name="m513r118" id="m513r118" style="width:74px; top:493px; left:1029px;"/>
<input type="text" name="m513r119" id="m513r119" style="width:100px; top:493px; left:1111px;"/>
<input type="text" name="m513r121" id="m513r121" style="width:89px; top:516px; left:375px;"/>
<input type="text" name="m513r122" id="m513r122" style="width:75px; top:516px; left:471px;"/>
<input type="text" name="m513r123" id="m513r123" style="width:67px; top:516px; left:553px;"/>
<input type="text" name="m513r124" id="m513r124" style="width:105px; top:516px; left:627px;"/>
<input type="text" name="m513r125" id="m513r125" style="width:82px; top:516px; left:739px;"/>
<input type="text" name="m513r126" id="m513r126" style="width:105px; top:516px; left:828px;"/>
<input type="text" name="m513r127" id="m513r127" style="width:82px; top:516px; left:940px;"/>
<input type="text" name="m513r128" id="m513r128" style="width:74px; top:516px; left:1029px;"/>
<input type="text" name="m513r129" id="m513r129" style="width:100px; top:516px; left:1111px;"/>
<input type="text" name="m513r131" id="m513r131" style="width:89px; top:548px; left:375px;"/>
<input type="text" name="m513r132" id="m513r132" style="width:75px; top:548px; left:471px;"/>
<input type="text" name="m513r133" id="m513r133" style="width:67px; top:548px; left:553px;"/>
<input type="text" name="m513r134" id="m513r134" style="width:105px; top:548px; left:627px;"/>
<input type="text" name="m513r135" id="m513r135" style="width:82px; top:548px; left:739px;"/>
<input type="text" name="m513r136" id="m513r136" style="width:105px; top:548px; left:828px;"/>
<input type="text" name="m513r137" id="m513r137" style="width:82px; top:548px; left:940px;"/>
<input type="text" name="m513r138" id="m513r138" style="width:74px; top:548px; left:1029px;"/>
<input type="text" name="m513r139" id="m513r139" style="width:100px; top:548px; left:1111px;"/>
<input type="text" name="m513r141" id="m513r141" style="width:89px; top:579px; left:375px;"/>
<input type="text" name="m513r142" id="m513r142" style="width:75px; top:579px; left:471px;"/>
<input type="text" name="m513r143" id="m513r143" style="width:67px; top:579px; left:553px;"/>
<input type="text" name="m513r144" id="m513r144" style="width:105px; top:579px; left:627px;"/>
<input type="text" name="m513r145" id="m513r145" style="width:82px; top:579px; left:739px;"/>
<input type="text" name="m513r146" id="m513r146" style="width:105px; top:579px; left:828px;"/>
<input type="text" name="m513r147" id="m513r147" style="width:82px; top:579px; left:940px;"/>
<input type="text" name="m513r148" id="m513r148" style="width:74px; top:579px; left:1029px;"/>
<input type="text" name="m513r149" id="m513r149" style="width:100px; top:579px; left:1111px;"/>
<input type="text" name="m513r151" id="m513r151" style="width:89px; top:603px; left:375px;"/>
<input type="text" name="m513r152" id="m513r152" style="width:75px; top:603px; left:471px;"/>
<input type="text" name="m513r153" id="m513r153" style="width:67px; top:603px; left:553px;"/>
<input type="text" name="m513r154" id="m513r154" style="width:105px; top:603px; left:627px;"/>
<input type="text" name="m513r155" id="m513r155" style="width:82px; top:603px; left:739px;"/>
<input type="text" name="m513r156" id="m513r156" style="width:105px; top:603px; left:828px;"/>
<input type="text" name="m513r157" id="m513r157" style="width:82px; top:603px; left:940px;"/>
<input type="text" name="m513r158" id="m513r158" style="width:74px; top:603px; left:1029px;"/>
<input type="text" name="m513r159" id="m513r159" style="width:100px; top:603px; left:1111px;"/>
<input type="text" name="m513r161" id="m513r161" style="width:89px; top:626px; left:375px;"/>
<input type="text" name="m513r162" id="m513r162" style="width:75px; top:626px; left:471px;"/>
<input type="text" name="m513r163" id="m513r163" style="width:67px; top:626px; left:553px;"/>
<input type="text" name="m513r164" id="m513r164" style="width:105px; top:626px; left:627px;"/>
<input type="text" name="m513r165" id="m513r165" style="width:82px; top:626px; left:739px;"/>
<input type="text" name="m513r166" id="m513r166" style="width:105px; top:626px; left:828px;"/>
<input type="text" name="m513r167" id="m513r167" style="width:82px; top:626px; left:940px;"/>
<input type="text" name="m513r168" id="m513r168" style="width:74px; top:626px; left:1029px;"/>
<input type="text" name="m513r169" id="m513r169" style="width:100px; top:626px; left:1111px;"/>
<input type="text" name="m513r171" id="m513r171" style="width:89px; top:650px; left:375px;"/>
<input type="text" name="m513r173" id="m513r173" style="width:67px; top:650px; left:553px;"/>
<input type="text" name="m513r174" id="m513r174" style="width:105px; top:650px; left:627px;"/>
<input type="text" name="m513r175" id="m513r175" style="width:82px; top:650px; left:739px;"/>
<input type="text" name="m513r176" id="m513r176" style="width:105px; top:650px; left:828px;"/>
<input type="text" name="m513r177" id="m513r177" style="width:82px; top:650px; left:940px;"/>
<input type="text" name="m513r181" id="m513r181" style="width:89px; top:673px; left:375px;"/>
<input type="text" name="m513r183" id="m513r183" style="width:67px; top:673px; left:553px;"/>
<input type="text" name="m513r184" id="m513r184" style="width:105px; top:673px; left:627px;"/>
<input type="text" name="m513r185" id="m513r185" style="width:82px; top:673px; left:739px;"/>
<input type="text" name="m513r186" id="m513r186" style="width:105px; top:673px; left:828px;"/>
<input type="text" name="m513r187" id="m513r187" style="width:82px; top:673px; left:940px;"/>
<input type="text" name="m513r191" id="m513r191" style="width:89px; top:697px; left:375px;"/>
<input type="text" name="m513r193" id="m513r193" style="width:67px; top:697px; left:553px;"/>
<input type="text" name="m513r194" id="m513r194" style="width:105px; top:697px; left:627px;"/>
<input type="text" name="m513r195" id="m513r195" style="width:82px; top:697px; left:739px;"/>
<input type="text" name="m513r196" id="m513r196" style="width:105px; top:697px; left:828px;"/>
<input type="text" name="m513r197" id="m513r197" style="width:82px; top:697px; left:940px;"/>
<input type="text" name="m513r201" id="m513r201" style="width:89px; top:721px; left:375px;"/>
<input type="text" name="m513r203" id="m513r203" style="width:67px; top:721px; left:553px;"/>
<input type="text" name="m513r204" id="m513r204" style="width:105px; top:721px; left:627px;"/>
<input type="text" name="m513r205" id="m513r205" style="width:82px; top:721px; left:739px;"/>
<input type="text" name="m513r206" id="m513r206" style="width:105px; top:721px; left:828px;"/>
<input type="text" name="m513r207" id="m513r207" style="width:82px; top:721px; left:940px;"/>
<input type="text" name="m513r211" id="m513r211" style="width:89px; top:744px; left:375px;"/>
<input type="text" name="m513r213" id="m513r213" style="width:67px; top:744px; left:553px;"/>
<input type="text" name="m513r214" id="m513r214" style="width:105px; top:744px; left:627px;"/>
<input type="text" name="m513r215" id="m513r215" style="width:82px; top:744px; left:739px;"/>
<input type="text" name="m513r216" id="m513r216" style="width:105px; top:744px; left:828px;"/>
<input type="text" name="m513r217" id="m513r217" style="width:82px; top:744px; left:940px;"/>
<input type="text" name="m513r221" id="m513r221" style="width:89px; top:768px; left:375px;"/>
<input type="text" name="m513r222" id="m513r222" style="width:75px; top:768px; left:471px;"/>
<input type="text" name="m513r223" id="m513r223" style="width:67px; top:768px; left:553px;"/>
<input type="text" name="m513r224" id="m513r224" style="width:105px; top:768px; left:627px;"/>
<input type="text" name="m513r225" id="m513r225" style="width:82px; top:768px; left:739px;"/>
<input type="text" name="m513r226" id="m513r226" style="width:105px; top:768px; left:828px;"/>
<input type="text" name="m513r227" id="m513r227" style="width:82px; top:768px; left:940px;"/>
<input type="text" name="m513r228" id="m513r228" style="width:74px; top:768px; left:1029px;"/>
<input type="text" name="m513r229" id="m513r229" style="width:100px; top:768px; left:1111px;"/>
<span class="text-echo" style="top:795px; right:785px;"><?php echo $m513r991; ?></span>
<span class="text-echo" style="top:795px; right:703px;"><?php echo $m513r992; ?></span>
<span class="text-echo" style="top:795px; right:628px;"><?php echo $m513r993; ?></span>
<span class="text-echo" style="top:795px; right:518px;"><?php echo $m513r994; ?></span>
<span class="text-echo" style="top:795px; right:428px;"><?php echo $m513r995; ?></span>
<span class="text-echo" style="top:795px; right:316px;"><?php echo $m513r996; ?></span>
<span class="text-echo" style="top:795px; right:227px;"><?php echo $m513r997; ?></span>
<span class="text-echo" style="top:795px; right:145px;"><?php echo $m513r998; ?></span>
<span class="text-echo" style="top:795px; right:38px;"><?php echo $m513r999; ?></span>
<?php                                        } ?>


<?php if ( $strana == 8 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str8.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 8.strana 245kB" style="width:1250px; height:1000px;">

<!-- modul 516 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky"
     onclick="NacitajZobratovky(516);" class="btn-row-tool" style="top:75px; left:352px;">
<input type="text" name="m516r11" id="m516r11" style="width:109px; top:219px; left:386px;"/>
<input type="text" name="m516r12" id="m516r12" style="width:109px; top:219px; left:505px;"/>
<input type="text" name="m516r13" id="m516r13" style="width:109px; top:219px; left:624px;"/>
<input type="text" name="m516r14" id="m516r14" style="width:109px; top:219px; left:743px;"/>
<input type="text" name="m516r15" id="m516r15" style="width:109px; top:219px; left:862px;"/>
<input type="text" name="m516r16" id="m516r16" style="width:109px; top:219px; left:981px;"/>
<input type="text" name="m516r17" id="m516r17" style="width:109px; top:219px; left:1100px;"/>
<input type="text" name="m516r21" id="m516r21" style="width:109px; top:243px; left:386px;"/>
<input type="text" name="m516r22" id="m516r22" style="width:109px; top:243px; left:505px;"/>
<input type="text" name="m516r23" id="m516r23" style="width:109px; top:243px; left:624px;"/>
<input type="text" name="m516r24" id="m516r24" style="width:109px; top:243px; left:743px;"/>
<input type="text" name="m516r25" id="m516r25" style="width:109px; top:243px; left:862px;"/>
<input type="text" name="m516r26" id="m516r26" style="width:109px; top:243px; left:981px;"/>
<input type="text" name="m516r27" id="m516r27" style="width:109px; top:243px; left:1100px;"/>
<input type="text" name="m516r31" id="m516r31" style="width:109px; top:266px; left:386px;"/>
<input type="text" name="m516r32" id="m516r32" style="width:109px; top:266px; left:505px;"/>
<input type="text" name="m516r33" id="m516r33" style="width:109px; top:266px; left:624px;"/>
<input type="text" name="m516r34" id="m516r34" style="width:109px; top:266px; left:743px;"/>
<input type="text" name="m516r35" id="m516r35" style="width:109px; top:266px; left:862px;"/>
<input type="text" name="m516r36" id="m516r36" style="width:109px; top:266px; left:981px;"/>
<input type="text" name="m516r37" id="m516r37" style="width:109px; top:266px; left:1100px;"/>
<input type="text" name="m516r41" id="m516r41" style="width:109px; top:290px; left:386px;"/>
<input type="text" name="m516r42" id="m516r42" style="width:109px; top:290px; left:505px;"/>
<input type="text" name="m516r43" id="m516r43" style="width:109px; top:290px; left:624px;"/>
<input type="text" name="m516r44" id="m516r44" style="width:109px; top:290px; left:743px;"/>
<input type="text" name="m516r45" id="m516r45" style="width:109px; top:290px; left:862px;"/>
<input type="text" name="m516r46" id="m516r46" style="width:109px; top:290px; left:981px;"/>
<input type="text" name="m516r47" id="m516r47" style="width:109px; top:290px; left:1100px;"/>
<input type="text" name="m516r51" id="m516r51" style="width:109px; top:313px; left:386px;"/>
<input type="text" name="m516r53" id="m516r53" style="width:109px; top:313px; left:624px;"/>
<input type="text" name="m516r54" id="m516r54" style="width:109px; top:313px; left:743px;"/>
<input type="text" name="m516r55" id="m516r55" style="width:109px; top:313px; left:862px;"/>
<input type="text" name="m516r57" id="m516r57" style="width:109px; top:313px; left:1100px;"/>
<input type="text" name="m516r61" id="m516r61" style="width:109px; top:337px; left:386px;"/>
<input type="text" name="m516r62" id="m516r62" style="width:109px; top:337px; left:505px;"/>
<input type="text" name="m516r63" id="m516r63" style="width:109px; top:337px; left:624px;"/>
<input type="text" name="m516r64" id="m516r64" style="width:109px; top:337px; left:743px;"/>
<input type="text" name="m516r65" id="m516r65" style="width:109px; top:337px; left:862px;"/>
<input type="text" name="m516r66" id="m516r66" style="width:109px; top:337px; left:981px;"/>
<input type="text" name="m516r67" id="m516r67" style="width:109px; top:337px; left:1100px;"/>
<input type="text" name="m516r71" id="m516r71" style="width:109px; top:360px; left:386px;"/>
<input type="text" name="m516r72" id="m516r72" style="width:109px; top:360px; left:505px;"/>
<input type="text" name="m516r73" id="m516r73" style="width:109px; top:360px; left:624px;"/>
<input type="text" name="m516r74" id="m516r74" style="width:109px; top:360px; left:743px;"/>
<input type="text" name="m516r75" id="m516r75" style="width:109px; top:360px; left:862px;"/>
<input type="text" name="m516r76" id="m516r76" style="width:109px; top:360px; left:981px;"/>
<input type="text" name="m516r77" id="m516r77" style="width:109px; top:360px; left:1100px;"/>
<input type="text" name="m516r81" id="m516r81" style="width:109px; top:384px; left:386px;"/>
<input type="text" name="m516r82" id="m516r82" style="width:109px; top:384px; left:505px;"/>
<input type="text" name="m516r83" id="m516r83" style="width:109px; top:384px; left:624px;"/>
<input type="text" name="m516r84" id="m516r84" style="width:109px; top:384px; left:743px;"/>
<input type="text" name="m516r85" id="m516r85" style="width:109px; top:384px; left:862px;"/>
<input type="text" name="m516r86" id="m516r86" style="width:109px; top:384px; left:981px;"/>
<input type="text" name="m516r87" id="m516r87" style="width:109px; top:384px; left:1100px;"/>
<input type="text" name="m516r91" id="m516r91" style="width:109px; top:408px; left:386px;"/>
<input type="text" name="m516r92" id="m516r92" style="width:109px; top:408px; left:505px;"/>
<input type="text" name="m516r93" id="m516r93" style="width:109px; top:408px; left:624px;"/>
<input type="text" name="m516r94" id="m516r94" style="width:109px; top:408px; left:743px;"/>
<input type="text" name="m516r95" id="m516r95" style="width:109px; top:408px; left:862px;"/>
<input type="text" name="m516r96" id="m516r96" style="width:109px; top:408px; left:981px;"/>
<input type="text" name="m516r97" id="m516r97" style="width:109px; top:408px; left:1100px;"/>
<input type="text" name="m516r101" id="m516r101" style="width:109px; top:431px; left:386px;"/>
<input type="text" name="m516r102" id="m516r102" style="width:109px; top:431px; left:505px;"/>
<input type="text" name="m516r103" id="m516r103" style="width:109px; top:431px; left:624px;"/>
<input type="text" name="m516r104" id="m516r104" style="width:109px; top:431px; left:743px;"/>
<input type="text" name="m516r105" id="m516r105" style="width:109px; top:431px; left:862px;"/>
<input type="text" name="m516r106" id="m516r106" style="width:109px; top:431px; left:981px;"/>
<input type="text" name="m516r107" id="m516r107" style="width:109px; top:431px; left:1100px;"/>
<input type="text" name="m516r111" id="m516r111" style="width:109px; top:455px; left:386px;"/>
<input type="text" name="m516r112" id="m516r112" style="width:109px; top:455px; left:505px;"/>
<input type="text" name="m516r113" id="m516r113" style="width:109px; top:455px; left:624px;"/>
<input type="text" name="m516r114" id="m516r114" style="width:109px; top:455px; left:743px;"/>
<input type="text" name="m516r115" id="m516r115" style="width:109px; top:455px; left:862px;"/>
<input type="text" name="m516r116" id="m516r116" style="width:109px; top:455px; left:981px;"/>
<input type="text" name="m516r117" id="m516r117" style="width:109px; top:455px; left:1100px;"/>
<input type="text" name="m516r121" id="m516r121" style="width:109px; top:478px; left:386px;"/>
<input type="text" name="m516r122" id="m516r122" style="width:109px; top:478px; left:505px;"/>
<input type="text" name="m516r123" id="m516r123" style="width:109px; top:478px; left:624px;"/>
<input type="text" name="m516r124" id="m516r124" style="width:109px; top:478px; left:743px;"/>
<input type="text" name="m516r125" id="m516r125" style="width:109px; top:478px; left:862px;"/>
<input type="text" name="m516r126" id="m516r126" style="width:109px; top:478px; left:981px;"/>
<input type="text" name="m516r127" id="m516r127" style="width:109px; top:478px; left:1100px;"/>
<input type="text" name="m516r131" id="m516r131" style="width:109px; top:509px; left:386px;"/>
<input type="text" name="m516r132" id="m516r132" style="width:109px; top:509px; left:505px;"/>
<input type="text" name="m516r133" id="m516r133" style="width:109px; top:509px; left:624px;"/>
<input type="text" name="m516r134" id="m516r134" style="width:109px; top:509px; left:743px;"/>
<input type="text" name="m516r135" id="m516r135" style="width:109px; top:509px; left:862px;"/>
<input type="text" name="m516r136" id="m516r136" style="width:109px; top:509px; left:981px;"/>
<input type="text" name="m516r137" id="m516r137" style="width:109px; top:509px; left:1100px;"/>
<input type="text" name="m516r141" id="m516r141" style="width:109px; top:539px; left:386px;"/>
<input type="text" name="m516r142" id="m516r142" style="width:109px; top:539px; left:505px;"/>
<input type="text" name="m516r143" id="m516r143" style="width:109px; top:539px; left:624px;"/>
<input type="text" name="m516r144" id="m516r144" style="width:109px; top:539px; left:743px;"/>
<input type="text" name="m516r145" id="m516r145" style="width:109px; top:539px; left:862px;"/>
<input type="text" name="m516r146" id="m516r146" style="width:109px; top:539px; left:981px;"/>
<input type="text" name="m516r147" id="m516r147" style="width:109px; top:539px; left:1100px;"/>
<input type="text" name="m516r151" id="m516r151" style="width:109px; top:562px; left:386px;"/>
<input type="text" name="m516r152" id="m516r152" style="width:109px; top:562px; left:505px;"/>
<input type="text" name="m516r153" id="m516r153" style="width:109px; top:562px; left:624px;"/>
<input type="text" name="m516r154" id="m516r154" style="width:109px; top:562px; left:743px;"/>
<input type="text" name="m516r155" id="m516r155" style="width:109px; top:562px; left:862px;"/>
<input type="text" name="m516r156" id="m516r156" style="width:109px; top:562px; left:981px;"/>
<input type="text" name="m516r157" id="m516r157" style="width:109px; top:562px; left:1100px;"/>
<input type="text" name="m516r161" id="m516r161" style="width:109px; top:586px; left:386px;"/>
<input type="text" name="m516r162" id="m516r162" style="width:109px; top:586px; left:505px;"/>
<input type="text" name="m516r163" id="m516r163" style="width:109px; top:586px; left:624px;"/>
<input type="text" name="m516r164" id="m516r164" style="width:109px; top:586px; left:743px;"/>
<input type="text" name="m516r165" id="m516r165" style="width:109px; top:586px; left:862px;"/>
<input type="text" name="m516r166" id="m516r166" style="width:109px; top:586px; left:981px;"/>
<input type="text" name="m516r167" id="m516r167" style="width:109px; top:586px; left:1100px;"/>
<input type="text" name="m516r171" id="m516r171" style="width:109px; top:609px; left:386px;"/>
<input type="text" name="m516r172" id="m516r172" style="width:109px; top:609px; left:505px;"/>
<input type="text" name="m516r174" id="m516r174" style="width:109px; top:609px; left:743px;"/>
<input type="text" name="m516r175" id="m516r175" style="width:109px; top:609px; left:862px;"/>
<input type="text" name="m516r177" id="m516r177" style="width:109px; top:609px; left:1100px;"/>
<input type="text" name="m516r181" id="m516r181" style="width:109px; top:633px; left:386px;"/>
<input type="text" name="m516r182" id="m516r182" style="width:109px; top:633px; left:505px;"/>
<input type="text" name="m516r184" id="m516r184" style="width:109px; top:633px; left:743px;"/>
<input type="text" name="m516r185" id="m516r185" style="width:109px; top:633px; left:862px;"/>
<input type="text" name="m516r187" id="m516r187" style="width:109px; top:633px; left:1100px;"/>
<input type="text" name="m516r191" id="m516r191" style="width:109px; top:656px; left:386px;"/>
<input type="text" name="m516r192" id="m516r192" style="width:109px; top:656px; left:505px;"/>
<input type="text" name="m516r194" id="m516r194" style="width:109px; top:656px; left:743px;"/>
<input type="text" name="m516r195" id="m516r195" style="width:109px; top:656px; left:862px;"/>
<input type="text" name="m516r197" id="m516r197" style="width:109px; top:656px; left:1100px;"/>
<input type="text" name="m516r201" id="m516r201" style="width:109px; top:680px; left:386px;"/>
<input type="text" name="m516r202" id="m516r202" style="width:109px; top:680px; left:505px;"/>
<input type="text" name="m516r204" id="m516r204" style="width:109px; top:680px; left:743px;"/>
<input type="text" name="m516r205" id="m516r205" style="width:109px; top:680px; left:862px;"/>
<input type="text" name="m516r206" id="m516r206" style="width:109px; top:680px; left:981px;"/>
<input type="text" name="m516r207" id="m516r207" style="width:109px; top:680px; left:1100px;"/>
<input type="text" name="m516r211" id="m516r211" style="width:109px; top:703px; left:386px;"/>
<input type="text" name="m516r212" id="m516r212" style="width:109px; top:703px; left:505px;"/>
<input type="text" name="m516r214" id="m516r214" style="width:109px; top:703px; left:743px;"/>
<input type="text" name="m516r215" id="m516r215" style="width:109px; top:703px; left:862px;"/>
<input type="text" name="m516r216" id="m516r216" style="width:109px; top:703px; left:981px;"/>
<input type="text" name="m516r217" id="m516r217" style="width:109px; top:703px; left:1100px;"/>
<input type="text" name="m516r221" id="m516r221" style="width:109px; top:727px; left:386px;"/>
<input type="text" name="m516r222" id="m516r222" style="width:109px; top:727px; left:505px;"/>
<input type="text" name="m516r223" id="m516r223" style="width:109px; top:727px; left:624px;"/>
<input type="text" name="m516r224" id="m516r224" style="width:109px; top:727px; left:743px;"/>
<input type="text" name="m516r225" id="m516r225" style="width:109px; top:727px; left:862px;"/>
<input type="text" name="m516r226" id="m516r226" style="width:109px; top:727px; left:981px;"/>
<input type="text" name="m516r227" id="m516r227" style="width:109px; top:727px; left:1100px;"/>
<span class="text-echo" style="top:754px; right:753px;"><?php echo $m516r991; ?></span>
<span class="text-echo" style="top:754px; right:634px;"><?php echo $m516r992; ?></span>
<span class="text-echo" style="top:754px; right:514px;"><?php echo $m516r993; ?></span>
<span class="text-echo" style="top:754px; right:395px;"><?php echo $m516r994; ?></span>
<span class="text-echo" style="top:754px; right:276px;"><?php echo $m516r995; ?></span>
<span class="text-echo" style="top:754px; right:157px;"><?php echo $m516r996; ?></span>
<span class="text-echo" style="top:754px; right:39px;"><?php echo $m516r997; ?></span>
<?php                                        } ?>


<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str9.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 9.strana 237kB">

<!-- modul 100305 -->
<!-- dopyt, novinka -->

<!-- modul 586 -->
<!-- dopyt, iné výpoèty -->
<!-- dopyt, predtým str.5 -->
<!-- dopyt, pridané inputy -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje zo Súvahy"
     onclick="NacitajZosuvahy(586);" style="top:285px; left:338px;" class="btn-row-tool">
<input type="text" name="m586r11" id="m586r11" style="width:100px; top:391px; left:596px;"/>
<input type="text" name="m586r12" id="m586r12" style="width:100px; top:391px; left:760px;"/>
<input type="text" name="m586r21" id="m586r21" style="width:100px; top:419px; left:596px;"/>
<input type="text" name="m586r22" id="m586r22" style="width:100px; top:419px; left:760px;"/>
<input type="text" name="m586r131" id="m586r131" style="width:100px; top:732px; left:596px;"/>
<input type="text" name="m586r132" id="m586r132" style="width:100px; top:732px; left:760px;"/>
<input type="text" name="m586r141" id="m586r141" style="width:100px; top:761px; left:596px;"/>
<input type="text" name="m586r142" id="m586r142" style="width:100px; top:761px; left:760px;"/>
<input type="text" name="m586r151" id="m586r151" style="width:100px; top:789px; left:596px;"/>
<input type="text" name="m586r152" id="m586r152" style="width:100px; top:789px; left:760px;"/>
<input type="text" name="m586r191" id="m586r191" style="width:100px; top:903px; left:596px;"/>
<input type="text" name="m586r192" id="m586r192" style="width:100px; top:903px; left:760px;"/>
<input type="text" name="m586r201" id="m586r201" style="width:100px; top:932px; left:596px;"/>
<input type="text" name="m586r202" id="m586r202" style="width:100px; top:932px; left:760px;"/>
<span class="text-echo" style="top:1078px; right:250px;"><?php echo $m586r991; ?></span>
<span class="text-echo" style="top:1078px; right:80px;"><?php echo $m586r992; ?></span>


<?php                                        } ?>


<?php if ( $strana == 10 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str10.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 10.strana 237kB">

<!-- modul 19 -->
<input type="text" name="m19r1" id="m19r1" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:236px; left:720px;"/>
<input type="text" name="m19r2" id="m19r2" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:264px; left:720px;"/>
<input type="text" name="m19r3" id="m19r3" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:292px; left:720px;"/>
<input type="text" name="m19r4" id="m19r4" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:321px; left:720px;"/>
<input type="text" name="m19r5" id="m19r5" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:349px; left:720px;"/>
<input type="text" name="m19r6" id="m19r6" style="width:100px; top:378px; left:720px;"/>
<input type="text" name="m19r7" id="m19r7" style="width:100px; top:406px; left:720px;"/>
<input type="text" name="m19r8" id="m19r8" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:435px; left:720px;"/>
<input type="text" name="m19r9" id="m19r9" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:470px; left:720px;"/>
<input type="text" name="m19r10" id="m19r10" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:505px; left:720px;"/>
<input type="text" name="m19r11" id="m19r11" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:534px; left:720px;"/>
<input type="text" name="m19r12" id="m19r12" onkeyup="CiarkaNaBodku(this);"
       style="width:100px; top:572px; left:720px;"/>
<span class="text-echo" style="top:614px; right:130px;"><?php echo $m19r99; ?></span>

<!-- modul 100103 -->
<input type="checkbox" name="m1527r1a" value="1" onclick="klikm1527r1ano();"
       style="top:785px; left:839px;"/>
<input type="checkbox" name="m1527r1b" value="1" onclick="klikm1527r1nie();"
       style="top:805px; left:839px;"/>

<?php                                         } ?>


<?php if ( $strana == 11 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str11.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 11.strana 246kB" style="width:1250px; height:1000px;">

<!-- modul 527 -->
<input type="text" name="m527r11" id="m527r11" style="width:74px; top:272px; left:331px;"/>
<input type="text" name="m527r12" id="m527r12" style="width:95px; top:272px; left:415px;"/>
<input type="text" name="m527r13" id="m527r13" style="width:64px; top:272px; left:520px;"/>
<input type="text" name="m527r14" id="m527r14" style="width:64px; top:272px; left:594px;"/>
<input type="text" name="m527r15" id="m527r15" style="width:96px; top:272px; left:667px;"/>
<input type="text" name="m527r16" id="m527r16" style="width:84px; top:272px; left:773px;"/>
<input type="text" name="m527r17" id="m527r17" style="width:73px; top:272px; left:868px;"/>
<input type="text" name="m527r18" id="m527r18" style="width:74px; top:272px; left:952px;"/>
<input type="text" name="m527r19" id="m527r19" style="width:74px; top:272px; left:1036px;"/>
<input type="text" name="m527r110" id="m527r110" style="width:75px; top:272px; left:1120px;"/>
<input type="text" name="m527r21" id="m527r21" style="width:74px; top:307px; left:331px;"/>
<input type="text" name="m527r22" id="m527r22" style="width:95px; top:307px; left:415px;"/>
<input type="text" name="m527r23" id="m527r23" style="width:64px; top:307px; left:520px;"/>
<input type="text" name="m527r24" id="m527r24" style="width:64px; top:307px; left:594px;"/>
<input type="text" name="m527r25" id="m527r25" style="width:96px; top:307px; left:667px;"/>
<input type="text" name="m527r26" id="m527r26" style="width:84px; top:307px; left:773px;"/>
<input type="text" name="m527r27" id="m527r27" style="width:73px; top:307px; left:868px;"/>
<input type="text" name="m527r28" id="m527r28" style="width:74px; top:307px; left:952px;"/>
<input type="text" name="m527r29" id="m527r29" style="width:74px; top:307px; left:1036px;"/>
<input type="text" name="m527r210" id="m527r210" style="width:75px; top:307px; left:1120px;"/>
<input type="text" name="m527r31" id="m527r31" style="width:74px; top:338px; left:331px;"/>
<input type="text" name="m527r32" id="m527r32" style="width:95px; top:338px; left:415px;"/>
<input type="text" name="m527r33" id="m527r33" style="width:64px; top:338px; left:520px;"/>
<input type="text" name="m527r34" id="m527r34" style="width:64px; top:338px; left:594px;"/>
<input type="text" name="m527r35" id="m527r35" style="width:96px; top:338px; left:667px;"/>
<input type="text" name="m527r36" id="m527r36" style="width:84px; top:338px; left:773px;"/>
<input type="text" name="m527r37" id="m527r37" style="width:73px; top:338px; left:868px;"/>
<input type="text" name="m527r38" id="m527r38" style="width:74px; top:338px; left:952px;"/>
<input type="text" name="m527r39" id="m527r39" style="width:74px; top:338px; left:1036px;"/>
<input type="text" name="m527r310" id="m527r310" style="width:75px; top:338px; left:1120px;"/>
<input type="text" name="m527r41" id="m527r41" style="width:74px; top:374px; left:331px;"/>
<input type="text" name="m527r42" id="m527r42" style="width:95px; top:374px; left:415px;"/>
<input type="text" name="m527r43" id="m527r43" style="width:64px; top:374px; left:520px;"/>
<input type="text" name="m527r44" id="m527r44" style="width:64px; top:374px; left:594px;"/>
<input type="text" name="m527r45" id="m527r45" style="width:96px; top:374px; left:667px;"/>
<input type="text" name="m527r46" id="m527r46" style="width:84px; top:374px; left:773px;"/>
<input type="text" name="m527r47" id="m527r47" style="width:73px; top:374px; left:868px;"/>
<input type="text" name="m527r48" id="m527r48" style="width:74px; top:374px; left:952px;"/>
<input type="text" name="m527r49" id="m527r49" style="width:74px; top:374px; left:1036px;"/>
<input type="text" name="m527r410" id="m527r410" style="width:75px; top:374px; left:1120px;"/>
<input type="text" name="m527r51" id="m527r51" style="width:74px; top:414px; left:331px;"/>
<input type="text" name="m527r52" id="m527r52" style="width:95px; top:414px; left:415px;"/>
<input type="text" name="m527r53" id="m527r53" style="width:64px; top:414px; left:520px;"/>
<input type="text" name="m527r54" id="m527r54" style="width:64px; top:414px; left:594px;"/>
<input type="text" name="m527r55" id="m527r55" style="width:96px; top:414px; left:667px;"/>
<input type="text" name="m527r56" id="m527r56" style="width:84px; top:414px; left:773px;"/>
<input type="text" name="m527r57" id="m527r57" style="width:73px; top:414px; left:868px;"/>
<input type="text" name="m527r58" id="m527r58" style="width:74px; top:414px; left:952px;"/>
<input type="text" name="m527r59" id="m527r59" style="width:74px; top:414px; left:1036px;"/>
<input type="text" name="m527r510" id="m527r510" style="width:75px; top:414px; left:1120px;"/>
<input type="text" name="m527r61" id="m527r61" style="width:74px; top:449px; left:331px;"/>
<input type="text" name="m527r62" id="m527r62" style="width:95px; top:449px; left:415px;"/>
<input type="text" name="m527r63" id="m527r63" style="width:64px; top:449px; left:520px;"/>
<input type="text" name="m527r64" id="m527r64" style="width:64px; top:449px; left:594px;"/>
<input type="text" name="m527r65" id="m527r65" style="width:96px; top:449px; left:667px;"/>
<input type="text" name="m527r66" id="m527r66" style="width:84px; top:449px; left:773px;"/>
<input type="text" name="m527r67" id="m527r67" style="width:73px; top:449px; left:868px;"/>
<input type="text" name="m527r68" id="m527r68" style="width:74px; top:449px; left:952px;"/>
<input type="text" name="m527r69" id="m527r69" style="width:74px; top:449px; left:1036px;"/>
<input type="text" name="m527r610" id="m527r610" style="width:75px; top:449px; left:1120px;"/>
<input type="text" name="m527r71" id="m527r71" style="width:74px; top:495px; left:331px;"/>
<input type="text" name="m527r72" id="m527r72" style="width:95px; top:495px; left:415px;"/>
<input type="text" name="m527r73" id="m527r73" style="width:64px; top:495px; left:520px;"/>
<input type="text" name="m527r74" id="m527r74" style="width:64px; top:495px; left:594px;"/>
<input type="text" name="m527r75" id="m527r75" style="width:96px; top:495px; left:667px;"/>
<input type="text" name="m527r76" id="m527r76" style="width:84px; top:495px; left:773px;"/>
<input type="text" name="m527r77" id="m527r77" style="width:73px; top:495px; left:868px;"/>
<input type="text" name="m527r78" id="m527r78" style="width:74px; top:495px; left:952px;"/>
<input type="text" name="m527r79" id="m527r79" style="width:74px; top:495px; left:1036px;"/>
<input type="text" name="m527r710" id="m527r710" style="width:75px; top:495px; left:1120px;"/>
<input type="text" name="m527r81" id="m527r81" style="width:74px; top:544px; left:331px;"/>
<input type="text" name="m527r82" id="m527r82" style="width:95px; top:544px; left:415px;"/>
<input type="text" name="m527r83" id="m527r83" style="width:64px; top:544px; left:520px;"/>
<input type="text" name="m527r84" id="m527r84" style="width:64px; top:544px; left:594px;"/>
<input type="text" name="m527r85" id="m527r85" style="width:96px; top:544px; left:667px;"/>
<input type="text" name="m527r86" id="m527r86" style="width:84px; top:544px; left:773px;"/>
<input type="text" name="m527r87" id="m527r87" style="width:73px; top:544px; left:868px;"/>
<input type="text" name="m527r88" id="m527r88" style="width:74px; top:544px; left:952px;"/>
<input type="text" name="m527r89" id="m527r89" style="width:74px; top:544px; left:1036px;"/>
<input type="text" name="m527r810" id="m527r810" style="width:75px; top:544px; left:1120px;"/>
<input type="text" name="m527r91" id="m527r91" style="width:74px; top:587px; left:331px;"/>
<input type="text" name="m527r92" id="m527r92" style="width:95px; top:587px; left:415px;"/>
<input type="text" name="m527r93" id="m527r93" style="width:64px; top:587px; left:520px;"/>
<input type="text" name="m527r94" id="m527r94" style="width:64px; top:587px; left:594px;"/>
<input type="text" name="m527r95" id="m527r95" style="width:96px; top:587px; left:667px;"/>
<input type="text" name="m527r96" id="m527r96" style="width:84px; top:587px; left:773px;"/>
<input type="text" name="m527r97" id="m527r97" style="width:73px; top:587px; left:868px;"/>
<input type="text" name="m527r98" id="m527r98" style="width:74px; top:587px; left:952px;"/>
<input type="text" name="m527r99" id="m527r99" style="width:74px; top:587px; left:1036px;"/>
<input type="text" name="m527r910" id="m527r910" style="width:75px; top:587px; left:1120px;"/>
<input type="text" name="m527r101" id="m527r101" style="width:74px; top:638px; left:331px;"/>
<input type="text" name="m527r102" id="m527r102" style="width:95px; top:638px; left:415px;"/>
<input type="text" name="m527r103" id="m527r103" style="width:64px; top:638px; left:520px;"/>
<input type="text" name="m527r104" id="m527r104" style="width:64px; top:638px; left:594px;"/>
<input type="text" name="m527r105" id="m527r105" style="width:96px; top:638px; left:667px;"/>
<input type="text" name="m527r106" id="m527r106" style="width:84px; top:638px; left:773px;"/>
<input type="text" name="m527r107" id="m527r107" style="width:73px; top:638px; left:868px;"/>
<input type="text" name="m527r108" id="m527r108" style="width:74px; top:638px; left:952px;"/>
<input type="text" name="m527r109" id="m527r109" style="width:74px; top:638px; left:1036px;"/>
<input type="text" name="m527r1010" id="m527r1010" style="width:75px; top:638px; left:1120px;"/>
<input type="text" name="m527r111" id="m527r111" style="width:74px; top:678px; left:331px;"/>
<input type="text" name="m527r112" id="m527r112" style="width:95px; top:678px; left:415px;"/>
<input type="text" name="m527r113" id="m527r113" style="width:64px; top:678px; left:520px;"/>
<input type="text" name="m527r114" id="m527r114" style="width:64px; top:678px; left:594px;"/>
<input type="text" name="m527r115" id="m527r115" style="width:96px; top:678px; left:667px;"/>
<input type="text" name="m527r116" id="m527r116" style="width:84px; top:678px; left:773px;"/>
<input type="text" name="m527r117" id="m527r117" style="width:73px; top:678px; left:868px;"/>
<input type="text" name="m527r118" id="m527r118" style="width:74px; top:678px; left:952px;"/>
<input type="text" name="m527r119" id="m527r119" style="width:74px; top:678px; left:1036px;"/>
<input type="text" name="m527r1110" id="m527r1110" style="width:75px; top:678px; left:1120px;"/>
<input type="text" name="m527r121" id="m527r121" style="width:74px; top:710px; left:331px;"/>
<input type="text" name="m527r122" id="m527r122" style="width:95px; top:710px; left:415px;"/>
<input type="text" name="m527r123" id="m527r123" style="width:64px; top:710px; left:520px;"/>
<input type="text" name="m527r124" id="m527r124" style="width:64px; top:710px; left:594px;"/>
<input type="text" name="m527r125" id="m527r125" style="width:96px; top:710px; left:667px;"/>
<input type="text" name="m527r126" id="m527r126" style="width:84px; top:710px; left:773px;"/>
<input type="text" name="m527r127" id="m527r127" style="width:73px; top:710px; left:868px;"/>
<input type="text" name="m527r128" id="m527r128" style="width:74px; top:710px; left:952px;"/>
<input type="text" name="m527r129" id="m527r129" style="width:74px; top:710px; left:1036px;"/>
<input type="text" name="m527r1210" id="m527r1210" style="width:75px; top:710px; left:1120px;"/>
<input type="text" name="m527r131" id="m527r131" style="width:74px; top:741px; left:331px;"/>
<input type="text" name="m527r132" id="m527r132" style="width:95px; top:741px; left:415px;"/>
<input type="text" name="m527r133" id="m527r133" style="width:64px; top:741px; left:520px;"/>
<input type="text" name="m527r134" id="m527r134" style="width:64px; top:741px; left:594px;"/>
<input type="text" name="m527r135" id="m527r135" style="width:96px; top:741px; left:667px;"/>
<input type="text" name="m527r136" id="m527r136" style="width:84px; top:741px; left:773px;"/>
<input type="text" name="m527r137" id="m527r137" style="width:73px; top:741px; left:868px;"/>
<input type="text" name="m527r138" id="m527r138" style="width:74px; top:741px; left:952px;"/>
<input type="text" name="m527r139" id="m527r139" style="width:74px; top:741px; left:1036px;"/>
<input type="text" name="m527r1310" id="m527r1310" style="width:75px; top:741px; left:1120px;"/>
<input type="text" name="m527r141" id="m527r141" style="width:74px; top:772px; left:331px;"/>
<input type="text" name="m527r142" id="m527r142" style="width:95px; top:772px; left:415px;"/>
<input type="text" name="m527r143" id="m527r143" style="width:64px; top:772px; left:520px;"/>
<input type="text" name="m527r144" id="m527r144" style="width:64px; top:772px; left:594px;"/>
<input type="text" name="m527r145" id="m527r145" style="width:96px; top:772px; left:667px;"/>
<input type="text" name="m527r146" id="m527r146" style="width:84px; top:772px; left:773px;"/>
<input type="text" name="m527r147" id="m527r147" style="width:73px; top:772px; left:868px;"/>
<input type="text" name="m527r148" id="m527r148" style="width:74px; top:772px; left:952px;"/>
<input type="text" name="m527r149" id="m527r149" style="width:74px; top:772px; left:1036px;"/>
<input type="text" name="m527r1410" id="m527r1410" style="width:75px; top:772px; left:1120px;"/>
<input type="text" name="m527r151" id="m527r151" style="width:74px; top:815px; left:331px;"/>
<input type="text" name="m527r152" id="m527r152" style="width:95px; top:815px; left:415px;"/>
<input type="text" name="m527r153" id="m527r153" style="width:64px; top:815px; left:520px;"/>
<input type="text" name="m527r154" id="m527r154" style="width:64px; top:815px; left:594px;"/>
<input type="text" name="m527r155" id="m527r155" style="width:96px; top:815px; left:667px;"/>
<input type="text" name="m527r156" id="m527r156" style="width:84px; top:815px; left:773px;"/>
<input type="text" name="m527r157" id="m527r157" style="width:73px; top:815px; left:868px;"/>
<input type="text" name="m527r158" id="m527r158" style="width:74px; top:815px; left:952px;"/>
<input type="text" name="m527r159" id="m527r159" style="width:74px; top:815px; left:1036px;"/>
<input type="text" name="m527r1510" id="m527r1510" style="width:75px; top:815px; left:1120px;"/>
<input type="text" name="m527r161" id="m527r161" style="width:74px; top:873px; left:331px;"/>
<input type="text" name="m527r162" id="m527r162" style="width:95px; top:873px; left:415px;"/>
<input type="text" name="m527r163" id="m527r163" style="width:64px; top:873px; left:520px;"/>
<input type="text" name="m527r164" id="m527r164" style="width:64px; top:873px; left:594px;"/>
<input type="text" name="m527r165" id="m527r165" style="width:96px; top:873px; left:667px;"/>
<input type="text" name="m527r166" id="m527r166" style="width:84px; top:873px; left:773px;"/>
<input type="text" name="m527r167" id="m527r167" style="width:73px; top:873px; left:868px;"/>
<input type="text" name="m527r168" id="m527r168" style="width:74px; top:873px; left:952px;"/>
<input type="text" name="m527r169" id="m527r169" style="width:74px; top:873px; left:1036px;"/>
<input type="text" name="m527r1610" id="m527r1610" style="width:75px; top:873px; left:1120px;"/>
<input type="text" name="m527r171" id="m527r171" style="width:74px; top:927px; left:331px;"/>
<input type="text" name="m527r172" id="m527r172" style="width:95px; top:927px; left:415px;"/>
<input type="text" name="m527r173" id="m527r173" style="width:64px; top:927px; left:520px;"/>
<input type="text" name="m527r174" id="m527r174" style="width:64px; top:927px; left:594px;"/>
<input type="text" name="m527r175" id="m527r175" style="width:96px; top:927px; left:667px;"/>
<input type="text" name="m527r176" id="m527r176" style="width:84px; top:927px; left:773px;"/>
<input type="text" name="m527r177" id="m527r177" style="width:73px; top:927px; left:868px;"/>
<input type="text" name="m527r178" id="m527r178" style="width:74px; top:927px; left:952px;"/>
<input type="text" name="m527r179" id="m527r179" style="width:74px; top:927px; left:1036px;"/>
<input type="text" name="m527r1710" id="m527r1710" style="width:75px; top:927px; left:1120px;"/>
<?php                                        } ?>


<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str12.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 12.strana 256kB" style="width:1250px; height:1000px;">

<!-- modul 527 pokrac. -->
<input type="text" name="m527r181" id="m527r181" style="width:74px; top:252px; left:331px;"/>
<input type="text" name="m527r182" id="m527r182" style="width:95px; top:252px; left:415px;"/>
<input type="text" name="m527r183" id="m527r183" style="width:64px; top:252px; left:520px;"/>
<input type="text" name="m527r184" id="m527r184" style="width:64px; top:252px; left:594px;"/>
<input type="text" name="m527r185" id="m527r185" style="width:96px; top:252px; left:667px;"/>
<input type="text" name="m527r186" id="m527r186" style="width:84px; top:252px; left:773px;"/>
<input type="text" name="m527r187" id="m527r187" style="width:73px; top:252px; left:868px;"/>
<input type="text" name="m527r188" id="m527r188" style="width:74px; top:252px; left:952px;"/>
<input type="text" name="m527r1810" id="m527r1810" style="width:75px; top:252px; left:1120px;"/>
<input type="text" name="m527r191" id="m527r191" style="width:74px; top:306px; left:331px;"/>
<input type="text" name="m527r192" id="m527r192" style="width:95px; top:306px; left:415px;"/>
<input type="text" name="m527r193" id="m527r193" style="width:64px; top:306px; left:520px;"/>
<input type="text" name="m527r194" id="m527r194" style="width:64px; top:306px; left:594px;"/>
<input type="text" name="m527r195" id="m527r195" style="width:96px; top:306px; left:667px;"/>
<input type="text" name="m527r196" id="m527r196" style="width:84px; top:306px; left:773px;"/>
<input type="text" name="m527r197" id="m527r197" style="width:73px; top:306px; left:868px;"/>
<input type="text" name="m527r198" id="m527r198" style="width:74px; top:306px; left:952px;"/>
<input type="text" name="m527r1910" id="m527r1910" style="width:75px; top:306px; left:1120px;"/>
<input type="text" name="m527r201" id="m527r201" style="width:74px; top:393px; left:331px;"/>
<input type="text" name="m527r202" id="m527r202" style="width:95px; top:393px; left:415px;"/>
<input type="text" name="m527r203" id="m527r203" style="width:64px; top:393px; left:520px;"/>
<input type="text" name="m527r204" id="m527r204" style="width:64px; top:393px; left:594px;"/>
<input type="text" name="m527r205" id="m527r205" style="width:96px; top:393px; left:667px;"/>
<input type="text" name="m527r206" id="m527r206" style="width:84px; top:393px; left:773px;"/>
<input type="text" name="m527r207" id="m527r207" style="width:73px; top:393px; left:868px;"/>
<input type="text" name="m527r208" id="m527r208" style="width:74px; top:393px; left:952px;"/>
<input type="text" name="m527r2010" id="m527r2010" style="width:75px; top:393px; left:1120px;"/>
<input type="text" name="m527r211" id="m527r211" style="width:74px; top:486px; left:331px;"/>
<input type="text" name="m527r212" id="m527r212" style="width:95px; top:486px; left:415px;"/>
<input type="text" name="m527r213" id="m527r213" style="width:64px; top:486px; left:520px;"/>
<input type="text" name="m527r214" id="m527r214" style="width:64px; top:486px; left:594px;"/>
<input type="text" name="m527r215" id="m527r215" style="width:96px; top:486px; left:667px;"/>
<input type="text" name="m527r216" id="m527r216" style="width:84px; top:486px; left:773px;"/>
<input type="text" name="m527r217" id="m527r217" style="width:73px; top:486px; left:868px;"/>
<input type="text" name="m527r218" id="m527r218" style="width:74px; top:486px; left:952px;"/>
<input type="text" name="m527r2110" id="m527r2110" style="width:75px; top:486px; left:1120px;"/>
<input type="text" name="m527r221" id="m527r221" style="width:74px; top:568px; left:331px;"/>
<input type="text" name="m527r222" id="m527r222" style="width:95px; top:568px; left:415px;"/>
<input type="text" name="m527r223" id="m527r223" style="width:64px; top:568px; left:520px;"/>
<input type="text" name="m527r224" id="m527r224" style="width:64px; top:568px; left:594px;"/>
<input type="text" name="m527r225" id="m527r225" style="width:96px; top:568px; left:667px;"/>
<input type="text" name="m527r226" id="m527r226" style="width:84px; top:568px; left:773px;"/>
<input type="text" name="m527r227" id="m527r227" style="width:73px; top:568px; left:868px;"/>
<input type="text" name="m527r228" id="m527r228" style="width:74px; top:568px; left:952px;"/>
<input type="text" name="m527r2210" id="m527r2210" style="width:75px; top:568px; left:1120px;"/>
<input type="text" name="m527r231" id="m527r231" style="width:74px; top:640px; left:331px;"/>
<input type="text" name="m527r232" id="m527r232" style="width:95px; top:640px; left:415px;"/>
<input type="text" name="m527r233" id="m527r233" style="width:64px; top:640px; left:520px;"/>
<input type="text" name="m527r234" id="m527r234" style="width:64px; top:640px; left:594px;"/>
<input type="text" name="m527r235" id="m527r235" style="width:96px; top:640px; left:667px;"/>
<input type="text" name="m527r236" id="m527r236" style="width:84px; top:640px; left:773px;"/>
<input type="text" name="m527r237" id="m527r237" style="width:73px; top:640px; left:868px;"/>
<input type="text" name="m527r238" id="m527r238" style="width:74px; top:640px; left:952px;"/>
<input type="text" name="m527r2310" id="m527r2310" style="width:75px; top:640px; left:1120px;"/>
<input type="text" name="m527r241" id="m527r241" style="width:74px; top:702px; left:331px;"/>
<input type="text" name="m527r242" id="m527r242" style="width:95px; top:702px; left:415px;"/>
<input type="text" name="m527r243" id="m527r243" style="width:64px; top:702px; left:520px;"/>
<input type="text" name="m527r244" id="m527r244" style="width:64px; top:702px; left:594px;"/>
<input type="text" name="m527r245" id="m527r245" style="width:96px; top:702px; left:667px;"/>
<input type="text" name="m527r246" id="m527r246" style="width:84px; top:702px; left:773px;"/>
<input type="text" name="m527r247" id="m527r247" style="width:73px; top:702px; left:868px;"/>
<input type="text" name="m527r248" id="m527r248" style="width:74px; top:702px; left:952px;"/>
<input type="text" name="m527r2410" id="m527r2410" style="width:75px; top:702px; left:1120px;"/>
<span class="text-echo" style="top:747px; right:841px;"><?php echo $m527r991; ?></span>
<span class="text-echo" style="top:747px; right:736px;"><?php echo $m527r992; ?></span>
<span class="text-echo" style="top:747px; right:663px;"><?php echo $m527r993; ?></span>
<span class="text-echo" style="top:747px; right:589px;"><?php echo $m527r994; ?></span>
<span class="text-echo" style="top:747px; right:484px;"><?php echo $m527r995; ?></span>
<span class="text-echo" style="top:747px; right:389px;"><?php echo $m527r996; ?></span>
<span class="text-echo" style="top:747px; right:305px;"><?php echo $m527r997; ?></span>
<span class="text-echo" style="top:747px; right:221px;"><?php echo $m527r998; ?></span>
<span class="text-echo" style="top:747px; right:138px;"><?php echo $m527r999; ?></span>
<span class="text-echo" style="top:747px; right:52px;"><?php echo $m527r9910; ?></span>
<?php                                         } ?>


<?php if ( $strana == 13 OR $strana == 9999 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str13.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 13.strana 237kB">

<!-- modul 474 -->
<input type="text" name="m474r11" id="m474r11" style="width:101px; top:262px; left:559px;"/>
<input type="text" name="m474r12" id="m474r12" style="width:101px; top:262px; left:673px;"/>
<input type="text" name="m474r13" id="m474r13" style="width:101px; top:262px; left:787px;"/>
<input type="text" name="m474r21" id="m474r21" style="width:101px; top:292px; left:559px;"/>
<input type="text" name="m474r22" id="m474r22" style="width:101px; top:292px; left:673px;"/>
<input type="text" name="m474r23" id="m474r23" style="width:101px; top:292px; left:787px;"/>
<input type="text" name="m474r31" id="m474r31" style="width:101px; top:323px; left:559px;"/>
<input type="text" name="m474r32" id="m474r32" style="width:101px; top:323px; left:673px;"/>
<input type="text" name="m474r33" id="m474r33" style="width:101px; top:323px; left:787px;"/>
<input type="text" name="m474r41" id="m474r41" style="width:101px; top:353px; left:559px;"/>
<input type="text" name="m474r42" id="m474r42" style="width:101px; top:353px; left:673px;"/>
<input type="text" name="m474r43" id="m474r43" style="width:101px; top:353px; left:787px;"/>
<input type="text" name="m474r51" id="m474r51" style="width:101px; top:384px; left:559px;"/>
<input type="text" name="m474r52" id="m474r52" style="width:101px; top:384px; left:673px;"/>
<input type="text" name="m474r53" id="m474r53" style="width:101px; top:384px; left:787px;"/>
<input type="text" name="m474r61" id="m474r61" style="width:101px; top:415px; left:559px;"/>
<input type="text" name="m474r62" id="m474r62" style="width:101px; top:415px; left:673px;"/>
<input type="text" name="m474r63" id="m474r63" style="width:101px; top:415px; left:787px;"/>
<input type="text" name="m474r72" id="m474r72" style="width:101px; top:445px; left:673px;"/>
<input type="text" name="m474r73" id="m474r73" style="width:101px; top:445px; left:787px;"/>
<span class="text-echo" style="top:480px; right:287px;"><?php echo $m474r991; ?></span>
<span class="text-echo" style="top:480px; right:172px;"><?php echo $m474r992; ?></span>
<span class="text-echo" style="top:480px; right:59px;"><?php echo $m474r993; ?></span>

<!-- modul 514 -->
<img src="../obr/ikony/download_blue_icon.png" title="Naèíta údaje z Obratovky"
     onclick="NacitajZobratovky(514);" style="top:563px; left:514px;" class="btn-row-tool">
<input type="text" name="m514r1" id="m514r1" style="width:100px; top:660px; left:720px;"/>
<input type="text" name="m514r2" id="m514r2" style="width:100px; top:690px; left:720px;"/>
<input type="text" name="m514r3" id="m514r3" style="width:100px; top:721px; left:720px;"/>
<span class="text-echo" style="top:756px; right:130px;"><?php echo $m514r99; ?></span>
<?php                                         } ?>

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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=13', '_self');" class="<?php echo $clas13; ?> toleft">13</a>
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

//vytlac strana 1 az 9
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_vts101 WHERE ico >= 0 "."";
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
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str1.jpg',0,0,210,297);
}

//OBDOBIA
$pdf->SetFont('arial','',15);
$pdf->Cell(190,31," ","$rmc1",1,"L");
$pdf->Cell(85,8," ","$rmc1",0,"L");$pdf->Cell(34,6,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',11);
$pdf->Cell(190,12," ","$rmc1",1,"L");
$R1=substr($kli_vrok,2,1);
$R2=substr($kli_vrok,3,1);
$mesiacx=$mesiac;
if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$A=substr($mesiacx,0,1);
$B=substr($mesiacx,1,1);
$pdf->Cell(57,5," ","$rmc1",0,"L");
$pdf->Cell(7,7,"$R1","$rmc",0,"C");$pdf->Cell(7,7,"$R2","$rmc",0,"C");$pdf->Cell(7,7,"$A","$rmc",0,"C");$pdf->Cell(7,7,"$B","$rmc",0,"C");
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
$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(9,7,"$B","$rmc",0,"C");$pdf->Cell(8,7,"$C","$rmc",0,"C");$pdf->Cell(8,7,"$D","$rmc",0,"C");
$pdf->Cell(8,7,"$E","$rmc",0,"C");$pdf->Cell(8,7,"$F","$rmc",0,"C");$pdf->Cell(8,7,"$G","$rmc",0,"C");$pdf->Cell(9,7,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,86," ","$rmc1",1,"L");
$pdf->Cell(50,4," ","$rmc1",0,"L");$pdf->Cell(104,6,"$fir_fnaz","$rmc",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",0,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,5,"$okres","$rmc",1,"C");

//VYPLNIL
$pdf->Cell(195,9," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$fir_mzdt05","$rmc",0,"L");
$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(43,10,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,1," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,7,"$fir_fem1","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
//odoslane
$pdf->Cell(43,6,"$odoslane_sk","$rmc",1,"C");

//modul 100041
$mod100041ano=" ";
$mod100041nie=" ";
if ( $hlavicka->mod100041ano == 1 ) { $mod100041ano="x"; }
if ( $hlavicka->mod100041nie == 1 ) { $mod100041nie="x"; }
$pdf->Cell(190,22," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100041ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100041nie","$rmc",1,"C");

//modul 100042
$mod100042ano=" ";
$mod100042nie=" ";
if ( $hlavicka->mod100042ano == 1 ) { $mod100042ano="x"; }
if ( $hlavicka->mod100042nie == 1 ) { $mod100042nie="x"; }
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100042ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100042nie","$rmc",1,"C");

//modul 100043
$mod100043ano=" ";
$mod100043nie=" ";
if ( $hlavicka->mod100043ano == 1 ) { $mod100043ano="x"; }
if ( $hlavicka->mod100043nie == 1 ) { $mod100043nie="x"; }
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100043ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100043nie","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str2.jpg',0,0,210,297);
}

//modul 100008
$m1100r4=$hlavicka->m1100r4; if ( $m1100r4 == 0 ) $m1100r4="";
$m1100r5=$hlavicka->m1100r5; if ( $m1100r5 == 0 ) $m1100r5="";
$m1100r6=$hlavicka->m1100r6; if ( $m1100r6 == 0 ) $m1100r6="";
$m1100r7=$hlavicka->m1100r7; if ( $m1100r7 == 0 ) $m1100r7="";
$m1100r8=$hlavicka->m1100r8; if ( $m1100r8 == 0 ) $m1100r8="";
$m1100r9=$hlavicka->m1100r9; if ( $m1100r9 == 0 ) $m1100r9="";
$m1100r10=$hlavicka->m1100r10; if ( $m1100r10 == 0 ) $m1100r10="";
$m1100r11=$hlavicka->m1100r11; if ( $m1100r11 == 0 ) $m1100r11="";
$m1100r12=$hlavicka->m1100r12; if ( $m1100r12 == 0 ) $m1100r12="";
$m1100r13=$hlavicka->m1100r13; if ( $m1100r13 == 0 ) $m1100r13="";
$pdf->Cell(195,17," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r4","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r5","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r6","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r7","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r8","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r9","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r10","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r11","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r12","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m1100r13","$rmc",1,"C");

//modul 100036
$mod100036kal=" ";
$mod100036hos=" ";
if ( $hlavicka->mod100036kal == 1 ) { $mod100036kal="x"; }
if ( $hlavicka->mod100036hos == 1 ) { $mod100036hos="x"; }
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100036kal","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100036hos","$rmc",1,"C");

//modul 100037
$mod100037=$hlavicka->mod100037;
if ( $hlavicka->mod100037 == 0 ) $mod100037="";
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,6,"$mod100037","$rmc",1,"C");

//modul 100214
$m100214r01=$hlavicka->m100214r01; if ( $m100214r01 == 0 ) $m100214r01="";
$m100214r02=$hlavicka->m100214r02; if ( $m100214r02 == 0 ) $m100214r02="";
$pdf->Cell(190,21," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m100214r01","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m100214r02","$rmc",1,"C");

//modul 100069
$mod100069ano=" ";
$mod100069nie=" ";
if ( $hlavicka->mod100069ano == 1 ) { $mod100069ano="x"; }
if ( $hlavicka->mod100069nie == 1 ) { $mod100069nie="x"; }
$pdf->Cell(190,23," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100069ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100069nie","$rmc",1,"C");

//modul 100073
$m1101r2=$hlavicka->m1101r2;
if ( $hlavicka->m1101r2 == 0 ) $m1101r2="";
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,5,"$m1101r2","$rmc",1,"C");

//modul 100074
$m1101r3=$hlavicka->m1101r3;
if ( $hlavicka->m1101r3 == 0 ) $m1101r3="";
$pdf->Cell(190,38," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,6,"$m1101r3","$rmc",1,"C");

//modul 100071
$m1101r4a=" ";
$m1101r4b=" ";
if ( $hlavicka->m1101r4a == 1 ) { $m1101r4a="x"; }
if ( $hlavicka->m1101r4b == 1 ) { $m1101r4b="x"; }
$pdf->Cell(190,9," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m1101r4a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1101r4b","$rmc",1,"C");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str3.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str3.jpg',0,0,210,297);
}

//ico
$pdf->Cell(190,3," ","$rmc1",1,"L");
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
$pdf->Cell(83,3," ","$rmc1",0,"L");
$pdf->Cell(8,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(8,6,"$D","$rmc",0,"C");
$pdf->Cell(9,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");$pdf->Cell(8,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",1,"C");

//modul 100075
$m1101r5a=" ";
$m1101r5b=" ";
if ( $hlavicka->m1101r5a == 1 ) { $m1101r5a="x"; }
if ( $hlavicka->m1101r5b == 1 ) { $m1101r5b="x"; }
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m1101r5a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1101r5b","$rmc",1,"C");

//modul 100079
$m1101r6a=" ";
$m1101r6b=" ";
if ( $hlavicka->m1101r6a == 1 ) { $m1101r6a="x"; }
if ( $hlavicka->m1101r6b == 1 ) { $m1101r6b="x"; }
$pdf->Cell(190,21," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1101r6a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1101r6b","$rmc",1,"C");

//modul 100082
$m1101r7a=" ";
$m1101r7b=" ";
if ( $hlavicka->m1101r7a == 1 ) { $m1101r7a="x"; }
if ( $hlavicka->m1101r7b == 1 ) { $m1101r7b="x"; }
$pdf->Cell(190,28," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1101r7a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m1101r7b","$rmc",1,"C");

//modul 2
$mod2r01=$hlavicka->mod2r01; if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02; if ( $mod2r02 == 0 ) $mod2r02="";
$pdf->Cell(195,38," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r01","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r02","$rmc",1,"C");

//modul 398
$m398r11=$hlavicka->m398r11; if ( $m398r11 == 0 ) $m398r11="";
$m398r12=$hlavicka->m398r12; if ( $m398r12 == 0 ) $m398r12="";
$m398r13=$hlavicka->m398r13; if ( $m398r13 == 0 ) $m398r13="";
$m398r14=$hlavicka->m398r14; if ( $m398r14 == 0 ) $m398r14="";
$m398r21=$hlavicka->m398r21; if ( $m398r21 == 0 ) $m398r21="";
$m398r22=$hlavicka->m398r22; if ( $m398r22 == 0 ) $m398r22="";
$m398r23=$hlavicka->m398r23; if ( $m398r23 == 0 ) $m398r23="";
$m398r24=$hlavicka->m398r24; if ( $m398r24 == 0 ) $m398r24="";
$m398r991=$hlavicka->m398r991;
//if ( $m398r991 == 0 ) $m398r991="";
$m398r992=$hlavicka->m398r992;
//if ( $m398r992 == 0 ) $m398r992="";
$m398r993=$hlavicka->m398r993;
//if ( $m398r993 == 0 ) $m398r993="";
$m398r994=$hlavicka->m398r994;
//if ( $m398r994 == 0 ) $m398r994="";
$pdf->Cell(195,47," ","$rmc1",1,"L");
$pdf->Cell(89,5," ","$rmc1",0,"C");
$pdf->Cell(25,6,"$m398r11","$rmc",0,"R");$pdf->Cell(25,6,"$m398r12","$rmc",0,"R");
$pdf->Cell(25,6,"$m398r13","$rmc",0,"R");$pdf->Cell(25,6,"$m398r14","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"C");
$pdf->Cell(25,6,"$m398r21","$rmc",0,"R");$pdf->Cell(25,6,"$m398r22","$rmc",0,"R");
$pdf->Cell(25,6,"$m398r23","$rmc",0,"R");$pdf->Cell(25,6,"$m398r24","$rmc",1,"R");
$pdf->Cell(89,5," ","$rmc1",0,"C");
$pdf->Cell(25,6,"$m398r991","$rmc",0,"R");$pdf->Cell(25,6,"$m398r992","$rmc",0,"R");
$pdf->Cell(25,6,"$m398r993","$rmc",0,"R");$pdf->Cell(25,6,"$m398r994","$rmc",1,"R");

//modul 100131
$m1005r1a=" ";
$m1005r1b=" ";
if ( $hlavicka->m1005r1a == 1 ) { $m1005r1a="x"; }
if ( $hlavicka->m1005r1b == 1 ) { $m1005r1b="x"; }
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1005r1a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m1005r1b","$rmc",1,"C");
                                       }

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str4.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str4.jpg',0,0,210,297);
}

//modul 405
$m405r11=$hlavicka->m405r11; if ( $m405r11 == 0 ) $m405r11="";
$m405r12=$hlavicka->m405r12; if ( $m405r12 == 0 ) $m405r12="";
$m405r21=$hlavicka->m405r21; if ( $m405r21 == 0 ) $m405r21="";
$m405r31=$hlavicka->m405r31; if ( $m405r31 == 0 ) $m405r31="";
$m405r32=$hlavicka->m405r32; if ( $m405r32 == 0 ) $m405r32="";
$m405r41=$hlavicka->m405r41; if ( $m405r41 == 0 ) $m405r41="";
$m405r51=$hlavicka->m405r51; if ( $m405r51 == 0 ) $m405r51="";
$m405r61=$hlavicka->m405r61; if ( $m405r61 == 0 ) $m405r61="";
$m405r71=$hlavicka->m405r71; if ( $m405r71 == 0 ) $m405r71="";
$m405r81=$hlavicka->m405r81; if ( $m405r81 == 0 ) $m405r81="";
$m405r82=$hlavicka->m405r82; if ( $m405r82 == 0 ) $m405r82="";
$m405r991=$hlavicka->m405r991;
//if ( $m405r991 == 0 ) $m405r991="";
$m405r992=$hlavicka->m405r992;
//if ( $m405r992 == 0 ) $m405r992="";
$pdf->Cell(195,27," ","$rmc1",1,"L");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m405r11","$rmc",0,"R");$pdf->Cell(38,6,"$m405r12","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m405r21","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,5,"$m405r31","$rmc",0,"R");$pdf->Cell(38,5,"$m405r32","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,5,"$m405r41","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m405r51","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,8,"$m405r61","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m405r71","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m405r81","$rmc",0,"R");$pdf->Cell(38,6,"$m405r82","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m405r991","$rmc",0,"R");$pdf->Cell(38,6,"$m405r992","$rmc",1,"R");

//modul 406
$m406r1=$hlavicka->m406r1; if ( $m406r1 == 0 ) $m406r1="";
$m406r2=$hlavicka->m406r2; if ( $m406r2 == 0 ) $m406r2="";
$m406r3=$hlavicka->m406r3; if ( $m406r3 == 0 ) $m406r3="";
$m406r4=$hlavicka->m406r4; if ( $m406r4 == 0 ) $m406r4="";
$m406r5=$hlavicka->m406r5; if ( $m406r5 == 0 ) $m406r5="";
$m406r6=$hlavicka->m406r6; if ( $m406r6 == 0 ) $m406r6="";
$m406r7=$hlavicka->m406r7; if ( $m406r7 == 0 ) $m406r7="";
$m406r99=$hlavicka->m406r99;
//if ( $m406r99 == 0 ) $m406r99="";
$pdf->Cell(195,21," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m406r1","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m406r2","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m406r3","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m406r4","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m406r5","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m406r6","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m406r7","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m406r99","$rmc",1,"R");

//modul 558
$m558r1=$hlavicka->m558r1; if ( $m558r1 == 0 ) $m558r1="";
$m558r2=$hlavicka->m558r2; if ( $m558r2 == 0 ) $m558r2="";
$m558r3=$hlavicka->m558r3; if ( $m558r3 == 0 ) $m558r3="";
$m558r4=$hlavicka->m558r4; if ( $m558r4 == 0 ) $m558r4="";
$m558r5=$hlavicka->m558r5; if ( $m558r5 == 0 ) $m558r5="";
$m558r6=$hlavicka->m558r6; if ( $m558r6 == 0 ) $m558r6="";
$m558r7=$hlavicka->m558r7; if ( $m558r7 == 0 ) $m558r7="";
$m558r8=$hlavicka->m558r8; if ( $m558r8 == 0 ) $m558r8="";
$m558r9=$hlavicka->m558r9; if ( $m558r9 == 0 ) $m558r9="";
$m558r10=$hlavicka->m558r10; if ( $m558r10 == 0 ) $m558r10="";
$m558r11=$hlavicka->m558r11; if ( $m558r11 == 0 ) $m558r11="";
$m558r12=$hlavicka->m558r12; if ( $m558r12 == 0 ) $m558r12="";
$m558r13=$hlavicka->m558r13; if ( $m558r13 == 0 ) $m558r13="";
$m558r14=$hlavicka->m558r14; if ( $m558r14 == 0 ) $m558r14="";
$m558r15=$hlavicka->m558r15; if ( $m558r15 == 0 ) $m558r15="";
$m558r16=$hlavicka->m558r16; if ( $m558r16 == 0 ) $m558r16="";
$m558r17=$hlavicka->m558r17; if ( $m558r17 == 0 ) $m558r17="";
$m558r18=$hlavicka->m558r18; if ( $m558r18 == 0 ) $m558r18="";
$m558r99=$hlavicka->m558r99;
//if ( $m558r99 == 0 ) $m558r99="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r1","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r2","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r3","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r4","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r5","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r6","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r7","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r8","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r9","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r10","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r11","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r12","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r13","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r14","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r15","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r16","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r17","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m558r18","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m558r99","$rmc",1,"R");
                                       }

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str5.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str5.jpg',0,0,210,297);
}

//ico
$pdf->Cell(190,8," ","$rmc1",1,"L");
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
$pdf->Cell(83,5," ","$rmc1",0,"L");
$pdf->Cell(8,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(8,6,"$D","$rmc",0,"C");
$pdf->Cell(9,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");$pdf->Cell(8,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",1,"C");

//modul 586
$m586r11=$hlavicka->m586r11; if ( $m586r11 == 0 ) $m586r11="";
$m586r12=$hlavicka->m586r12; if ( $m586r12 == 0 ) $m586r12="";
$m586r21=$hlavicka->m586r21; if ( $m586r21 == 0 ) $m586r21="";
$m586r22=$hlavicka->m586r22; if ( $m586r22 == 0 ) $m586r22="";
$m586r131=$hlavicka->m586r131; if ( $m586r131 == 0 ) $m586r131="";
$m586r132=$hlavicka->m586r132; if ( $m586r132 == 0 ) $m586r132="";
$m586r141=$hlavicka->m586r141; if ( $m586r141 == 0 ) $m586r141="";
$m586r142=$hlavicka->m586r142; if ( $m586r142 == 0 ) $m586r142="";
$m586r151=$hlavicka->m586r151; if ( $m586r151 == 0 ) $m586r151="";
$m586r152=$hlavicka->m586r152; if ( $m586r152 == 0 ) $m586r152="";
$m586r191=$hlavicka->m586r191; if ( $m586r191 == 0 ) $m586r191="";
$m586r192=$hlavicka->m586r192; if ( $m586r192 == 0 ) $m586r192="";
$m586r201=$hlavicka->m586r201; if ( $m586r201 == 0 ) $m586r201="";
$m586r202=$hlavicka->m586r202; if ( $m586r202 == 0 ) $m586r202="";
$m586r991=$hlavicka->m586r991;
//if ( $m586r991 == 0 ) $m586r991="";
$m586r992=$hlavicka->m586r992;
//if ( $m586r992 == 0 ) $m586r992="";
$pdf->Cell(195,28," ","$rmc1",1,"L");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r11","$rmc",0,"R");$pdf->Cell(38,6,"$m586r12","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r21","$rmc",0,"R");$pdf->Cell(38,6,"$m586r22","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r131","$rmc",0,"R");$pdf->Cell(38,6,"$m586r132","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r141","$rmc",0,"R");$pdf->Cell(38,6,"$m586r142","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r151","$rmc",0,"R");$pdf->Cell(38,6,"$m586r152","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r191","$rmc",0,"R");$pdf->Cell(38,6,"$m586r192","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r201","$rmc",0,"R");$pdf->Cell(38,6,"$m586r202","$rmc",1,"R");
$pdf->Cell(113,5," ","$rmc1",0,"C");
$pdf->Cell(38,6,"$m586r991","$rmc",0,"R");$pdf->Cell(38,6,"$m586r992","$rmc",1,"R");

//modul 100062
$m100062ano=" ";
$m100062nie=" ";
if ( $hlavicka->m100062ano == 1 ) { $m100062ano="x"; }
if ( $hlavicka->m100062nie == 1 ) { $m100062nie="x"; }
$pdf->Cell(190,13," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m100062ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m100062nie","$rmc",1,"C");

//modul 585
$m585r01=$hlavicka->m585r01; if ( $m585r01 == 0 ) $m585r01="";
$m585r02=$hlavicka->m585r02; if ( $m585r02 == 0 ) $m585r02="";
$m585r03=$hlavicka->m585r03; if ( $m585r03 == 0 ) $m585r03="";
$m585r04=$hlavicka->m585r04; if ( $m585r04 == 0 ) $m585r04="";
$m585r05=$hlavicka->m585r05; if ( $m585r05 == 0 ) $m585r05="";
$m585r3k=$hlavicka->m585r3k;
$m585r4k=$hlavicka->m585r4k;
$m585r5k=$hlavicka->m585r5k;
$pdf->Cell(195,75," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m585r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,8,"$m585r02","$rmc",1,"R");
$pdf->Cell(77,6,"","$rmc1",0,"L");$pdf->Cell(28,6,"$m585r3k","$rmc",0,"L");
$pdf->Cell(9,6,"","$rmc1",0,"L");$pdf->Cell(75,6,"$m585r03","$rmc",1,"R");
$pdf->Cell(77,6,"","$rmc1",0,"L");$pdf->Cell(28,6,"$m585r4k","$rmc",0,"L");
$pdf->Cell(9,6,"","$rmc1",0,"L");$pdf->Cell(75,6,"$m585r04","$rmc",1,"R");
$pdf->Cell(77,6,"","$rmc1",0,"L");$pdf->Cell(28,6,"$m585r5k","$rmc",0,"L");
$pdf->Cell(9,6,"","$rmc1",0,"L");$pdf->Cell(75,6,"$m585r05","$rmc",1,"R");

//modul 100044
$m100044ano=" ";
$m100044nie=" ";
if ( $hlavicka->m100044ano == 1 ) { $m100044ano="x"; }
if ( $hlavicka->m100044nie == 1 ) { $m100044nie="x"; }
$pdf->Cell(190,37," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m100044ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m100044nie","$rmc",1,"C");
                                       }

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str6.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str6.jpg',0,0,210,297);
}

//modul 571
$m571r10=$hlavicka->m571r10;
$m571r20=$hlavicka->m571r20;
$m571r30=$hlavicka->m571r30;
$m571r40=$hlavicka->m571r40;
$m571r50=$hlavicka->m571r50;
$m571r60=$hlavicka->m571r60;
$m571r70=$hlavicka->m571r70;
$m571r80=$hlavicka->m571r80;
$m571r90=$hlavicka->m571r90;
$cslr1="1."; if ( $m571r10 == '' ) { $cslr1=""; }
$cslr2="2."; if ( $m571r20 == '' ) { $cslr2=""; }
$cslr3="3."; if ( $m571r30 == '' ) { $cslr3=""; }
$cslr4="4."; if ( $m571r40 == '' ) { $cslr4=""; }
$cslr5="5."; if ( $m571r50 == '' ) { $cslr5=""; }
$cslr6="6."; if ( $m571r60 == '' ) { $cslr6=""; }
$cslr7="7."; if ( $m571r70 == '' ) { $cslr7=""; }
$cslr8="8."; if ( $m571r80 == '' ) { $cslr8=""; }
$cslr9="9."; if ( $m571r90 == '' ) { $cslr9=""; }
$m571r12=$hlavicka->m571r12;
$m571r22=$hlavicka->m571r22;
$m571r32=$hlavicka->m571r32;
$m571r42=$hlavicka->m571r42;
$m571r52=$hlavicka->m571r52;
$m571r62=$hlavicka->m571r62;
$m571r72=$hlavicka->m571r72;
$m571r82=$hlavicka->m571r82;
$m571r92=$hlavicka->m571r92;
$m571r13=$hlavicka->m571r13; if ( $m571r13 == 0 ) $m585r13="";
$m571r23=$hlavicka->m571r23; if ( $m571r23 == 0 ) $m585r23="";
$m571r33=$hlavicka->m571r33; if ( $m571r33 == 0 ) $m585r33="";
$m571r43=$hlavicka->m571r43; if ( $m571r43 == 0 ) $m585r43="";
$m571r53=$hlavicka->m571r53; if ( $m571r53 == 0 ) $m585r53="";
$m571r63=$hlavicka->m571r63; if ( $m571r63 == 0 ) $m585r63="";
$m571r73=$hlavicka->m571r73; if ( $m571r73 == 0 ) $m585r73="";
$m571r83=$hlavicka->m571r83; if ( $m571r83 == 0 ) $m585r83="";
$m571r93=$hlavicka->m571r93; if ( $m571r93 == 0 ) $m585r93="";
$m571r15=$hlavicka->m571r15; if ( $m571r15 == 0 ) $m585r15="";
$m571r25=$hlavicka->m571r25; if ( $m571r25 == 0 ) $m585r25="";
$m571r35=$hlavicka->m571r35; if ( $m571r35 == 0 ) $m585r35="";
$m571r45=$hlavicka->m571r45; if ( $m571r45 == 0 ) $m585r45="";
$m571r55=$hlavicka->m571r55; if ( $m571r55 == 0 ) $m585r55="";
$m571r65=$hlavicka->m571r65; if ( $m571r65 == 0 ) $m585r65="";
$m571r75=$hlavicka->m571r75; if ( $m571r75 == 0 ) $m585r75="";
$m571r85=$hlavicka->m571r85; if ( $m571r85 == 0 ) $m585r85="";
$m571r95=$hlavicka->m571r95; if ( $m571r95 == 0 ) $m585r95="";
$m571r16=$hlavicka->m571r16; if ( $m571r16 == 0 ) $m585r16="";
$m571r26=$hlavicka->m571r26; if ( $m571r26 == 0 ) $m585r26="";
$m571r36=$hlavicka->m571r36; if ( $m571r36 == 0 ) $m585r36="";
$m571r46=$hlavicka->m571r46; if ( $m571r46 == 0 ) $m585r46="";
$m571r56=$hlavicka->m571r56; if ( $m571r56 == 0 ) $m585r56="";
$m571r66=$hlavicka->m571r66; if ( $m571r66 == 0 ) $m585r66="";
$m571r76=$hlavicka->m571r76; if ( $m571r76 == 0 ) $m585r76="";
$m571r86=$hlavicka->m571r86; if ( $m571r86 == 0 ) $m585r86="";
$m571r96=$hlavicka->m571r96; if ( $m571r96 == 0 ) $m585r96="";
$m571r17=$hlavicka->m571r17; if ( $m571r17 == 0 ) $m585r17="";
$m571r27=$hlavicka->m571r27; if ( $m571r27 == 0 ) $m585r27="";
$m571r37=$hlavicka->m571r37; if ( $m571r37 == 0 ) $m585r37="";
$m571r47=$hlavicka->m571r47; if ( $m571r47 == 0 ) $m585r47="";
$m571r57=$hlavicka->m571r57; if ( $m571r57 == 0 ) $m585r57="";
$m571r67=$hlavicka->m571r67; if ( $m571r67 == 0 ) $m585r67="";
$m571r77=$hlavicka->m571r77; if ( $m571r77 == 0 ) $m585r77="";
$m571r87=$hlavicka->m571r87; if ( $m571r87 == 0 ) $m585r87="";
$m571r97=$hlavicka->m571r97; if ( $m571r97 == 0 ) $m585r97="";
$m571r18=$hlavicka->m571r18; if ( $m571r18 == 0 ) $m585r18="";
$m571r28=$hlavicka->m571r28; if ( $m571r28 == 0 ) $m585r28="";
$m571r38=$hlavicka->m571r38; if ( $m571r38 == 0 ) $m585r38="";
$m571r48=$hlavicka->m571r48; if ( $m571r48 == 0 ) $m585r48="";
$m571r58=$hlavicka->m571r58; if ( $m571r58 == 0 ) $m585r58="";
$m571r68=$hlavicka->m571r68; if ( $m571r68 == 0 ) $m585r68="";
$m571r78=$hlavicka->m571r78; if ( $m571r78 == 0 ) $m585r78="";
$m571r88=$hlavicka->m571r88; if ( $m571r88 == 0 ) $m585r88="";
$m571r98=$hlavicka->m571r98; if ( $m571r98 == 0 ) $m585r98="";
$pdf->Cell(195,56," ","$rmc1",1,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r10","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr1","$rmc",0,"C");$pdf->Cell(35,6,"$m571r12","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r13","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r15","$rmc",0,"C");$pdf->Cell(20,6,"$m571r16","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r17","$rmc",0,"R");$pdf->Cell(18,6,"$m571r18","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r20","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr2","$rmc",0,"C");$pdf->Cell(35,6,"$m571r22","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r23","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r25","$rmc",0,"C");$pdf->Cell(20,6,"$m571r26","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r27","$rmc",0,"R");$pdf->Cell(18,6,"$m571r28","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r30","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr3","$rmc",0,"C");$pdf->Cell(35,6,"$m571r32","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r33","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r35","$rmc",0,"C");$pdf->Cell(20,6,"$m571r36","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r37","$rmc",0,"R");$pdf->Cell(18,6,"$m571r38","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r40","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr4","$rmc",0,"C");$pdf->Cell(35,6,"$m571r42","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r43","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r45","$rmc",0,"C");$pdf->Cell(20,6,"$m571r46","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r47","$rmc",0,"R");$pdf->Cell(18,6,"$m571r48","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r50","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr5","$rmc",0,"C");$pdf->Cell(35,6,"$m571r52","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r53","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r55","$rmc",0,"C");$pdf->Cell(20,6,"$m571r56","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r57","$rmc",0,"R");$pdf->Cell(18,6,"$m571r58","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r60","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr6","$rmc",0,"C");$pdf->Cell(35,6,"$m571r62","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r63","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r65","$rmc",0,"C");$pdf->Cell(20,6,"$m571r66","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r67","$rmc",0,"R");$pdf->Cell(18,6,"$m571r68","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r70","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr7","$rmc",0,"C");$pdf->Cell(35,6,"$m571r72","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r73","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r75","$rmc",0,"C");$pdf->Cell(20,6,"$m571r76","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r77","$rmc",0,"R");$pdf->Cell(18,6,"$m571r78","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r80","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr8","$rmc",0,"C");$pdf->Cell(35,6,"$m571r82","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r83","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r85","$rmc",0,"C");$pdf->Cell(20,6,"$m571r86","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r87","$rmc",0,"R");$pdf->Cell(18,6,"$m571r88","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r90","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc1",0,"C");
$pdf->Cell(15,6,"$cslr9","$rmc",0,"C");$pdf->Cell(35,6,"$m571r92","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r93","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc1",0,"L");
$pdf->Cell(15,6,"$m571r95","$rmc",0,"C");$pdf->Cell(20,6,"$m571r96","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r97","$rmc",0,"R");$pdf->Cell(18,6,"$m571r98","$rmc",1,"R");

//modul 581
$m581r1=$hlavicka->m581r1; if ( $m581r1 == 0 ) $m581r1="";
$m581r2=$hlavicka->m581r2; if ( $m581r2 == 0 ) $m581r2="";
$m581r3=$hlavicka->m581r3; if ( $m581r3 == 0 ) $m581r3="";
$m581r4=$hlavicka->m581r4; if ( $m581r4 == 0 ) $m581r4="";
$m581r5=$hlavicka->m581r5; if ( $m581r5 == 0 ) $m581r5="";
$m581r6=$hlavicka->m581r6; if ( $m581r6 == 0 ) $m581r6="";
$m581r7=$hlavicka->m581r7; if ( $m581r7 == 0 ) $m581r7="";
$m581r8=$hlavicka->m581r8; if ( $m581r8 == 0 ) $m581r8="";
$m581r9=$hlavicka->m581r9; if ( $m581r9 == 0 ) $m581r9="";
$m581r10=$hlavicka->m581r10; if ( $m581r10 == 0 ) $m581r10="";
$m581r11=$hlavicka->m581r11; if ( $m581r11 == 0 ) $m581r11="";
$m581r12=$hlavicka->m581r12; if ( $m581r12 == 0 ) $m581r12="";
$m581r99=$hlavicka->m581r99;
//if ( $m581r99 == 0 ) $m581r99="";
$pdf->Cell(195,45," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,5,"$m581r1","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r2","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r3","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r4","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r5","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r6","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r7","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r8","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r9","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r10","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r11","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r12","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m581r99","$rmc",1,"R");
                                       }

if ( $strana == 7 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str7.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str7.jpg',5,0,305,210);
}

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(215,4," ","$rmc1",0,"L");
$pdf->Cell(6,5,"$A","$rmc",0,"C");$pdf->Cell(6,5,"$B","$rmc",0,"C");$pdf->Cell(6,5,"$C","$rmc",0,"C");$pdf->Cell(6,5,"$D","$rmc",0,"C");
$pdf->Cell(6,5,"$E","$rmc",0,"C");$pdf->Cell(6,5,"$F","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(6,5,"$H","$rmc",1,"C");

//modul 513
$m513r11=$hlavicka->m513r11; if ( $m513r11 == 0 ) $m513r11="";
$m513r12=$hlavicka->m513r12; if ( $m513r12 == 0 ) $m513r12="";
$m513r13=$hlavicka->m513r13; if ( $m513r13 == 0 ) $m513r13="";
$m513r14=$hlavicka->m513r14; if ( $m513r14 == 0 ) $m513r14="";
$m513r15=$hlavicka->m513r15; if ( $m513r15 == 0 ) $m513r15="";
$m513r16=$hlavicka->m513r16; if ( $m513r16 == 0 ) $m513r16="";
$m513r17=$hlavicka->m513r17; if ( $m513r17 == 0 ) $m513r17="";
$m513r18=$hlavicka->m513r18; if ( $m513r18 == 0 ) $m513r18="";
$m513r19=$hlavicka->m513r19; if ( $m513r19 == 0 ) $m513r19="";
$m513r21=$hlavicka->m513r21; if ( $m513r21 == 0 ) $m513r21="";
$m513r22=$hlavicka->m513r22; if ( $m513r22 == 0 ) $m513r22="";
$m513r23=$hlavicka->m513r23; if ( $m513r23 == 0 ) $m513r23="";
$m513r24=$hlavicka->m513r24; if ( $m513r24 == 0 ) $m513r24="";
$m513r25=$hlavicka->m513r25; if ( $m513r25 == 0 ) $m513r25="";
$m513r26=$hlavicka->m513r26; if ( $m513r26 == 0 ) $m513r26="";
$m513r27=$hlavicka->m513r27; if ( $m513r27 == 0 ) $m513r27="";
$m513r28=$hlavicka->m513r28; if ( $m513r28 == 0 ) $m513r28="";
$m513r29=$hlavicka->m513r29; if ( $m513r29 == 0 ) $m513r29="";
$m513r31=$hlavicka->m513r31; if ( $m513r31 == 0 ) $m513r31="";
$m513r32=$hlavicka->m513r32; if ( $m513r32 == 0 ) $m513r32="";
$m513r33=$hlavicka->m513r33; if ( $m513r33 == 0 ) $m513r33="";
$m513r34=$hlavicka->m513r34; if ( $m513r34 == 0 ) $m513r34="";
$m513r35=$hlavicka->m513r35; if ( $m513r35 == 0 ) $m513r35="";
$m513r36=$hlavicka->m513r36; if ( $m513r36 == 0 ) $m513r36="";
$m513r37=$hlavicka->m513r37; if ( $m513r37 == 0 ) $m513r37="";
$m513r38=$hlavicka->m513r38; if ( $m513r38 == 0 ) $m513r38="";
$m513r39=$hlavicka->m513r39; if ( $m513r39 == 0 ) $m513r39="";
$m513r41=$hlavicka->m513r41; if ( $m513r41 == 0 ) $m513r41="";
$m513r42=$hlavicka->m513r42; if ( $m513r42 == 0 ) $m513r42="";
$m513r43=$hlavicka->m513r43; if ( $m513r43 == 0 ) $m513r43="";
$m513r44=$hlavicka->m513r44; if ( $m513r44 == 0 ) $m513r44="";
$m513r45=$hlavicka->m513r45; if ( $m513r45 == 0 ) $m513r45="";
$m513r46=$hlavicka->m513r46; if ( $m513r46 == 0 ) $m513r46="";
$m513r47=$hlavicka->m513r47; if ( $m513r47 == 0 ) $m513r47="";
$m513r48=$hlavicka->m513r48; if ( $m513r48 == 0 ) $m513r48="";
$m513r49=$hlavicka->m513r49; if ( $m513r49 == 0 ) $m513r49="";
$m513r51=$hlavicka->m513r51; if ( $m513r51 == 0 ) $m513r51="";
$m513r52=$hlavicka->m513r52; if ( $m513r52 == 0 ) $m513r52="";
$m513r53=$hlavicka->m513r53; if ( $m513r53 == 0 ) $m513r53="";
$m513r54=$hlavicka->m513r54; if ( $m513r54 == 0 ) $m513r54="";
$m513r55=$hlavicka->m513r55; if ( $m513r55 == 0 ) $m513r55="";
$m513r56=$hlavicka->m513r56; if ( $m513r56 == 0 ) $m513r56="";
$m513r57=$hlavicka->m513r57; if ( $m513r57 == 0 ) $m513r57="";
$m513r58=$hlavicka->m513r58; if ( $m513r58 == 0 ) $m513r58="";
$m513r59=$hlavicka->m513r59; if ( $m513r59 == 0 ) $m513r59="";
$m513r61=$hlavicka->m513r61; if ( $m513r61 == 0 ) $m513r61="";
$m513r62=$hlavicka->m513r62; if ( $m513r62 == 0 ) $m513r62="";
$m513r63=$hlavicka->m513r63; if ( $m513r63 == 0 ) $m513r63="";
$m513r64=$hlavicka->m513r64; if ( $m513r64 == 0 ) $m513r64="";
$m513r65=$hlavicka->m513r65; if ( $m513r65 == 0 ) $m513r65="";
$m513r66=$hlavicka->m513r66; if ( $m513r66 == 0 ) $m513r66="";
$m513r67=$hlavicka->m513r67; if ( $m513r67 == 0 ) $m513r67="";
$m513r68=$hlavicka->m513r68; if ( $m513r68 == 0 ) $m513r68="";
$m513r69=$hlavicka->m513r69; if ( $m513r69 == 0 ) $m513r69="";
$m513r71=$hlavicka->m513r71; if ( $m513r71 == 0 ) $m513r71="";
$m513r72=$hlavicka->m513r72; if ( $m513r72 == 0 ) $m513r72="";
$m513r73=$hlavicka->m513r73; if ( $m513r73 == 0 ) $m513r73="";
$m513r74=$hlavicka->m513r74; if ( $m513r74 == 0 ) $m513r74="";
$m513r75=$hlavicka->m513r75; if ( $m513r75 == 0 ) $m513r75="";
$m513r76=$hlavicka->m513r76; if ( $m513r76 == 0 ) $m513r76="";
$m513r77=$hlavicka->m513r77; if ( $m513r77 == 0 ) $m513r77="";
$m513r78=$hlavicka->m513r78; if ( $m513r78 == 0 ) $m513r78="";
$m513r79=$hlavicka->m513r79; if ( $m513r79 == 0 ) $m513r79="";
$m513r81=$hlavicka->m513r81; if ( $m513r81 == 0 ) $m513r81="";
$m513r82=$hlavicka->m513r82; if ( $m513r82 == 0 ) $m513r82="";
$m513r83=$hlavicka->m513r83; if ( $m513r83 == 0 ) $m513r83="";
$m513r84=$hlavicka->m513r84; if ( $m513r84 == 0 ) $m513r84="";
$m513r85=$hlavicka->m513r85; if ( $m513r85 == 0 ) $m513r85="";
$m513r86=$hlavicka->m513r86; if ( $m513r86 == 0 ) $m513r86="";
$m513r87=$hlavicka->m513r87; if ( $m513r87 == 0 ) $m513r87="";
$m513r88=$hlavicka->m513r88; if ( $m513r88 == 0 ) $m513r88="";
$m513r89=$hlavicka->m513r89; if ( $m513r89 == 0 ) $m513r89="";
$m513r91=$hlavicka->m513r91; if ( $m513r91 == 0 ) $m513r91="";
$m513r92=$hlavicka->m513r92; if ( $m513r92 == 0 ) $m513r92="";
$m513r93=$hlavicka->m513r93; if ( $m513r93 == 0 ) $m513r93="";
$m513r94=$hlavicka->m513r94; if ( $m513r94 == 0 ) $m513r94="";
$m513r95=$hlavicka->m513r95; if ( $m513r95 == 0 ) $m513r95="";
$m513r96=$hlavicka->m513r96; if ( $m513r96 == 0 ) $m513r96="";
$m513r97=$hlavicka->m513r97; if ( $m513r97 == 0 ) $m513r97="";
$m513r98=$hlavicka->m513r98; if ( $m513r98 == 0 ) $m513r98="";
$m513r99=$hlavicka->m513r99; if ( $m513r99 == 0 ) $m513r99="";
$m513r101=$hlavicka->m513r101; if ( $m513r101 == 0 ) $m513r101="";
$m513r102=$hlavicka->m513r102; if ( $m513r102 == 0 ) $m513r102="";
$m513r103=$hlavicka->m513r103; if ( $m513r103 == 0 ) $m513r103="";
$m513r104=$hlavicka->m513r104; if ( $m513r104 == 0 ) $m513r104="";
$m513r105=$hlavicka->m513r105; if ( $m513r105 == 0 ) $m513r105="";
$m513r106=$hlavicka->m513r106; if ( $m513r106 == 0 ) $m513r106="";
$m513r107=$hlavicka->m513r107; if ( $m513r107 == 0 ) $m513r107="";
$m513r108=$hlavicka->m513r108; if ( $m513r108 == 0 ) $m513r108="";
$m513r109=$hlavicka->m513r109; if ( $m513r109 == 0 ) $m513r109="";
$m513r111=$hlavicka->m513r111; if ( $m513r111 == 0 ) $m513r111="";
$m513r112=$hlavicka->m513r112; if ( $m513r112 == 0 ) $m513r112="";
$m513r113=$hlavicka->m513r113; if ( $m513r113 == 0 ) $m513r113="";
$m513r114=$hlavicka->m513r114; if ( $m513r114 == 0 ) $m513r114="";
$m513r115=$hlavicka->m513r115; if ( $m513r115 == 0 ) $m513r115="";
$m513r116=$hlavicka->m513r116; if ( $m513r116 == 0 ) $m513r116="";
$m513r117=$hlavicka->m513r117; if ( $m513r117 == 0 ) $m513r117="";
$m513r118=$hlavicka->m513r118; if ( $m513r118 == 0 ) $m513r118="";
$m513r119=$hlavicka->m513r119; if ( $m513r119 == 0 ) $m513r119="";
$m513r121=$hlavicka->m513r121; if ( $m513r121 == 0 ) $m513r121="";
$m513r122=$hlavicka->m513r122; if ( $m513r122 == 0 ) $m513r122="";
$m513r123=$hlavicka->m513r123; if ( $m513r123 == 0 ) $m513r123="";
$m513r124=$hlavicka->m513r124; if ( $m513r124 == 0 ) $m513r124="";
$m513r125=$hlavicka->m513r125; if ( $m513r125 == 0 ) $m513r125="";
$m513r126=$hlavicka->m513r126; if ( $m513r126 == 0 ) $m513r126="";
$m513r127=$hlavicka->m513r127; if ( $m513r127 == 0 ) $m513r127="";
$m513r128=$hlavicka->m513r128; if ( $m513r128 == 0 ) $m513r128="";
$m513r129=$hlavicka->m513r129; if ( $m513r129 == 0 ) $m513r129="";
$m513r131=$hlavicka->m513r131; if ( $m513r131 == 0 ) $m513r131="";
$m513r132=$hlavicka->m513r132; if ( $m513r132 == 0 ) $m513r132="";
$m513r133=$hlavicka->m513r133; if ( $m513r133 == 0 ) $m513r133="";
$m513r134=$hlavicka->m513r134; if ( $m513r134 == 0 ) $m513r134="";
$m513r135=$hlavicka->m513r135; if ( $m513r135 == 0 ) $m513r135="";
$m513r136=$hlavicka->m513r136; if ( $m513r136 == 0 ) $m513r136="";
$m513r137=$hlavicka->m513r137; if ( $m513r137 == 0 ) $m513r137="";
$m513r138=$hlavicka->m513r138; if ( $m513r138 == 0 ) $m513r138="";
$m513r139=$hlavicka->m513r139; if ( $m513r139 == 0 ) $m513r139="";
$m513r141=$hlavicka->m513r141; if ( $m513r141 == 0 ) $m513r141="";
$m513r142=$hlavicka->m513r142; if ( $m513r142 == 0 ) $m513r142="";
$m513r143=$hlavicka->m513r143; if ( $m513r143 == 0 ) $m513r143="";
$m513r144=$hlavicka->m513r144; if ( $m513r144 == 0 ) $m513r144="";
$m513r145=$hlavicka->m513r145; if ( $m513r145 == 0 ) $m513r145="";
$m513r146=$hlavicka->m513r146; if ( $m513r146 == 0 ) $m513r146="";
$m513r147=$hlavicka->m513r147; if ( $m513r147 == 0 ) $m513r147="";
$m513r148=$hlavicka->m513r148; if ( $m513r148 == 0 ) $m513r148="";
$m513r149=$hlavicka->m513r149; if ( $m513r149 == 0 ) $m513r149="";
$m513r151=$hlavicka->m513r151; if ( $m513r151 == 0 ) $m513r151="";
$m513r152=$hlavicka->m513r152; if ( $m513r152 == 0 ) $m513r152="";
$m513r153=$hlavicka->m513r153; if ( $m513r153 == 0 ) $m513r153="";
$m513r154=$hlavicka->m513r154; if ( $m513r154 == 0 ) $m513r154="";
$m513r155=$hlavicka->m513r155; if ( $m513r155 == 0 ) $m513r155="";
$m513r156=$hlavicka->m513r156; if ( $m513r156 == 0 ) $m513r156="";
$m513r157=$hlavicka->m513r157; if ( $m513r157 == 0 ) $m513r157="";
$m513r158=$hlavicka->m513r158; if ( $m513r158 == 0 ) $m513r158="";
$m513r159=$hlavicka->m513r159; if ( $m513r159 == 0 ) $m513r159="";
$m513r161=$hlavicka->m513r161; if ( $m513r161 == 0 ) $m513r161="";
$m513r162=$hlavicka->m513r162; if ( $m513r162 == 0 ) $m513r162="";
$m513r163=$hlavicka->m513r163; if ( $m513r163 == 0 ) $m513r163="";
$m513r164=$hlavicka->m513r164; if ( $m513r164 == 0 ) $m513r164="";
$m513r165=$hlavicka->m513r165; if ( $m513r165 == 0 ) $m513r165="";
$m513r166=$hlavicka->m513r166; if ( $m513r166 == 0 ) $m513r166="";
$m513r167=$hlavicka->m513r167; if ( $m513r167 == 0 ) $m513r167="";
$m513r168=$hlavicka->m513r168; if ( $m513r168 == 0 ) $m513r168="";
$m513r169=$hlavicka->m513r169; if ( $m513r169 == 0 ) $m513r169="";
$m513r171=$hlavicka->m513r171; if ( $m513r171 == 0 ) $m513r171="";
$m513r173=$hlavicka->m513r173; if ( $m513r173 == 0 ) $m513r173="";
$m513r174=$hlavicka->m513r174; if ( $m513r174 == 0 ) $m513r174="";
$m513r175=$hlavicka->m513r175; if ( $m513r175 == 0 ) $m513r175="";
$m513r176=$hlavicka->m513r176; if ( $m513r176 == 0 ) $m513r176="";
$m513r177=$hlavicka->m513r177; if ( $m513r177 == 0 ) $m513r177="";
$m513r181=$hlavicka->m513r181; if ( $m513r181 == 0 ) $m513r181="";
$m513r183=$hlavicka->m513r183; if ( $m513r183 == 0 ) $m513r183="";
$m513r184=$hlavicka->m513r184; if ( $m513r184 == 0 ) $m513r184="";
$m513r185=$hlavicka->m513r185; if ( $m513r185 == 0 ) $m513r185="";
$m513r186=$hlavicka->m513r186; if ( $m513r186 == 0 ) $m513r186="";
$m513r187=$hlavicka->m513r187; if ( $m513r187 == 0 ) $m513r187="";
$m513r191=$hlavicka->m513r191; if ( $m513r191 == 0 ) $m513r191="";
$m513r193=$hlavicka->m513r193; if ( $m513r193 == 0 ) $m513r193="";
$m513r194=$hlavicka->m513r194; if ( $m513r194 == 0 ) $m513r194="";
$m513r195=$hlavicka->m513r195; if ( $m513r195 == 0 ) $m513r195="";
$m513r196=$hlavicka->m513r196; if ( $m513r196 == 0 ) $m513r196="";
$m513r197=$hlavicka->m513r197; if ( $m513r197 == 0 ) $m513r197="";
$m513r201=$hlavicka->m513r201; if ( $m513r201 == 0 ) $m513r201="";
$m513r203=$hlavicka->m513r203; if ( $m513r203 == 0 ) $m513r203="";
$m513r204=$hlavicka->m513r204; if ( $m513r204 == 0 ) $m513r204="";
$m513r205=$hlavicka->m513r205; if ( $m513r205 == 0 ) $m513r205="";
$m513r206=$hlavicka->m513r206; if ( $m513r206 == 0 ) $m513r206="";
$m513r207=$hlavicka->m513r207; if ( $m513r207 == 0 ) $m513r207="";
$m513r211=$hlavicka->m513r211; if ( $m513r211 == 0 ) $m513r211="";
$m513r213=$hlavicka->m513r213; if ( $m513r213 == 0 ) $m513r213="";
$m513r214=$hlavicka->m513r214; if ( $m513r214 == 0 ) $m513r214="";
$m513r215=$hlavicka->m513r215; if ( $m513r215 == 0 ) $m513r215="";
$m513r216=$hlavicka->m513r216; if ( $m513r216 == 0 ) $m513r216="";
$m513r217=$hlavicka->m513r217; if ( $m513r217 == 0 ) $m513r217="";
$m513r221=$hlavicka->m513r221; if ( $m513r221 == 0 ) $m513r221="";
$m513r222=$hlavicka->m513r222; if ( $m513r222 == 0 ) $m513r222="";
$m513r223=$hlavicka->m513r223; if ( $m513r223 == 0 ) $m513r223="";
$m513r224=$hlavicka->m513r224; if ( $m513r224 == 0 ) $m513r224="";
$m513r225=$hlavicka->m513r225; if ( $m513r225 == 0 ) $m513r225="";
$m513r226=$hlavicka->m513r226; if ( $m513r226 == 0 ) $m513r226="";
$m513r227=$hlavicka->m513r227; if ( $m513r227 == 0 ) $m513r227="";
$m513r228=$hlavicka->m513r228; if ( $m513r228 == 0 ) $m513r228="";
$m513r229=$hlavicka->m513r229; if ( $m513r229 == 0 ) $m513r229="";
$m513r991=$hlavicka->m513r991;
//if ( $m513r991 == 0 ) $m513r991="";
$m513r992=$hlavicka->m513r992;
//if ( $m513r992 == 0 ) $m513r992="";
$m513r993=$hlavicka->m513r993;
//if ( $m513r993 == 0 ) $m513r993="";
$m513r994=$hlavicka->m513r994;
//if ( $m513r994 == 0 ) $m513r994="";
$m513r995=$hlavicka->m513r995;
//if ( $m513r995 == 0 ) $m513r995="";
$m513r996=$hlavicka->m513r996;
//if ( $m513r996 == 0 ) $m513r996="";
$m513r997=$hlavicka->m513r997;
//if ( $m513r997 == 0 ) $m513r997="";
$m513r998=$hlavicka->m513r998;
//if ( $m513r998 == 0 ) $m513r998="";
$m513r999=$hlavicka->m513r999;
//if ( $m513r999 == 0 ) $m513r999="";
$pdf->Cell(195,42," ","$rmc1",1,"L");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"$m513r11","$rmc",0,"R");$pdf->Cell(22,5,"$m513r12","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r13","$rmc",0,"R");$pdf->Cell(23,5,"$m513r14","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r15","$rmc",0,"R");$pdf->Cell(31,5,"$m513r16","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r17","$rmc",0,"R");$pdf->Cell(22,5,"$m513r18","$rmc",0,"R");
$pdf->Cell(28,5,"$m513r19","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r21","$rmc",0,"R");$pdf->Cell(22,4,"$m513r22","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r23","$rmc",0,"R");$pdf->Cell(23,4,"$m513r24","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r25","$rmc",0,"R");$pdf->Cell(31,4,"$m513r26","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r27","$rmc",0,"R");$pdf->Cell(22,4,"$m513r28","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r29","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r31","$rmc",0,"R");$pdf->Cell(22,4,"$m513r32","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r33","$rmc",0,"R");$pdf->Cell(23,4,"$m513r34","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r35","$rmc",0,"R");$pdf->Cell(31,4,"$m513r36","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r37","$rmc",0,"R");$pdf->Cell(22,4,"$m513r38","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r39","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r41","$rmc",0,"R");$pdf->Cell(22,4,"$m513r42","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r43","$rmc",0,"R");$pdf->Cell(23,4,"$m513r44","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r45","$rmc",0,"R");$pdf->Cell(31,4,"$m513r46","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r47","$rmc",0,"R");$pdf->Cell(22,4,"$m513r48","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r49","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r51","$rmc",0,"R");$pdf->Cell(22,4,"$m513r52","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r53","$rmc",0,"R");$pdf->Cell(23,4,"$m513r54","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r55","$rmc",0,"R");$pdf->Cell(31,4,"$m513r56","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r57","$rmc",0,"R");$pdf->Cell(22,4,"$m513r58","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r59","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r61","$rmc",0,"R");$pdf->Cell(22,4,"$m513r62","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r63","$rmc",0,"R");$pdf->Cell(23,4,"$m513r64","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r65","$rmc",0,"R");$pdf->Cell(31,4,"$m513r66","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r67","$rmc",0,"R");$pdf->Cell(22,4,"$m513r68","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r69","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"$m513r71","$rmc",0,"R");$pdf->Cell(22,5,"$m513r72","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r73","$rmc",0,"R");$pdf->Cell(23,5,"$m513r74","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r75","$rmc",0,"R");$pdf->Cell(31,5,"$m513r76","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r77","$rmc",0,"R");$pdf->Cell(22,5,"$m513r78","$rmc",0,"R");
$pdf->Cell(28,5,"$m513r79","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r81","$rmc",0,"R");$pdf->Cell(22,4,"$m513r82","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r83","$rmc",0,"R");$pdf->Cell(23,4,"$m513r84","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r85","$rmc",0,"R");$pdf->Cell(31,4,"$m513r86","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r87","$rmc",0,"R");$pdf->Cell(22,4,"$m513r88","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r89","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r91","$rmc",0,"R");$pdf->Cell(22,4,"$m513r92","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r93","$rmc",0,"R");$pdf->Cell(23,4,"$m513r94","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r95","$rmc",0,"R");$pdf->Cell(31,4,"$m513r96","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r97","$rmc",0,"R");$pdf->Cell(22,4,"$m513r98","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r99","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r101","$rmc",0,"R");$pdf->Cell(22,4,"$m513r102","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r103","$rmc",0,"R");$pdf->Cell(23,4,"$m513r104","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r105","$rmc",0,"R");$pdf->Cell(31,4,"$m513r106","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r107","$rmc",0,"R");$pdf->Cell(22,4,"$m513r108","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r109","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r111","$rmc",0,"R");$pdf->Cell(22,4,"$m513r112","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r113","$rmc",0,"R");$pdf->Cell(23,4,"$m513r114","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r115","$rmc",0,"R");$pdf->Cell(31,4,"$m513r116","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r117","$rmc",0,"R");$pdf->Cell(22,4,"$m513r118","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r119","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"$m513r121","$rmc",0,"R");$pdf->Cell(22,5,"$m513r122","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r123","$rmc",0,"R");$pdf->Cell(23,5,"$m513r124","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r125","$rmc",0,"R");$pdf->Cell(31,5,"$m513r126","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r127","$rmc",0,"R");$pdf->Cell(22,5,"$m513r128","$rmc",0,"R");
$pdf->Cell(28,5,"$m513r129","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$m513r131","$rmc",0,"R");$pdf->Cell(22,6,"$m513r132","$rmc",0,"R");
$pdf->Cell(24,6,"$m513r133","$rmc",0,"R");$pdf->Cell(23,6,"$m513r134","$rmc",0,"R");
$pdf->Cell(24,6,"$m513r135","$rmc",0,"R");$pdf->Cell(31,6,"$m513r136","$rmc",0,"R");
$pdf->Cell(21,6,"$m513r137","$rmc",0,"R");$pdf->Cell(22,6,"$m513r138","$rmc",0,"R");
$pdf->Cell(28,6,"$m513r139","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r141","$rmc",0,"R");$pdf->Cell(22,4,"$m513r142","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r143","$rmc",0,"R");$pdf->Cell(23,4,"$m513r144","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r145","$rmc",0,"R");$pdf->Cell(31,4,"$m513r146","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r147","$rmc",0,"R");$pdf->Cell(22,4,"$m513r148","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r149","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r151","$rmc",0,"R");$pdf->Cell(22,4,"$m513r152","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r153","$rmc",0,"R");$pdf->Cell(23,4,"$m513r154","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r155","$rmc",0,"R");$pdf->Cell(31,4,"$m513r156","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r157","$rmc",0,"R");$pdf->Cell(22,4,"$m513r158","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r159","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r161","$rmc",0,"R");$pdf->Cell(22,4,"$m513r162","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r163","$rmc",0,"R");$pdf->Cell(23,4,"$m513r164","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r165","$rmc",0,"R");$pdf->Cell(31,4,"$m513r166","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r167","$rmc",0,"R");$pdf->Cell(22,4,"$m513r168","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r169","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r171","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r173","$rmc",0,"R");$pdf->Cell(23,4,"$m513r174","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r175","$rmc",0,"R");$pdf->Cell(31,4,"$m513r176","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r177","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(28,4,"","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r181","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r183","$rmc",0,"R");$pdf->Cell(23,4,"$m513r184","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r185","$rmc",0,"R");$pdf->Cell(31,4,"$m513r186","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r187","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(28,4,"","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"$m513r191","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r193","$rmc",0,"R");$pdf->Cell(23,5,"$m513r194","$rmc",0,"R");
$pdf->Cell(24,5,"$m513r195","$rmc",0,"R");$pdf->Cell(31,5,"$m513r196","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r197","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(28,5,"","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r201","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r203","$rmc",0,"R");$pdf->Cell(23,4,"$m513r204","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r205","$rmc",0,"R");$pdf->Cell(31,4,"$m513r206","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r207","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(28,4,"","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r211","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r213","$rmc",0,"R");$pdf->Cell(23,4,"$m513r214","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r215","$rmc",0,"R");$pdf->Cell(31,4,"$m513r216","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r217","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(28,4,"","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r221","$rmc",0,"R");$pdf->Cell(22,4,"$m513r222","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r223","$rmc",0,"R");$pdf->Cell(23,4,"$m513r224","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r225","$rmc",0,"R");$pdf->Cell(31,4,"$m513r226","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r227","$rmc",0,"R");$pdf->Cell(22,4,"$m513r228","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r229","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m513r991","$rmc",0,"R");$pdf->Cell(22,4,"$m513r992","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r993","$rmc",0,"R");$pdf->Cell(23,4,"$m513r994","$rmc",0,"R");
$pdf->Cell(24,4,"$m513r995","$rmc",0,"R");$pdf->Cell(31,4,"$m513r996","$rmc",0,"R");
$pdf->Cell(21,4,"$m513r997","$rmc",0,"R");$pdf->Cell(22,4,"$m513r998","$rmc",0,"R");
$pdf->Cell(28,4,"$m513r999","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
                                       }

if ( $strana == 8 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str8.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str8.jpg',5,0,305,210);
}

//modul 516
$m516r11=$hlavicka->m516r11; if ( $m516r11 == 0 ) $m516r11="";
$m516r12=$hlavicka->m516r12; if ( $m516r12 == 0 ) $m516r12="";
$m516r13=$hlavicka->m516r13; if ( $m516r13 == 0 ) $m516r13="";
$m516r14=$hlavicka->m516r14; if ( $m516r14 == 0 ) $m516r14="";
$m516r15=$hlavicka->m516r15; if ( $m516r15 == 0 ) $m516r15="";
$m516r16=$hlavicka->m516r16; if ( $m516r16 == 0 ) $m516r16="";
$m516r17=$hlavicka->m516r17; if ( $m516r17 == 0 ) $m516r17="";
$m516r21=$hlavicka->m516r21; if ( $m516r21 == 0 ) $m516r21="";
$m516r22=$hlavicka->m516r22; if ( $m516r22 == 0 ) $m516r22="";
$m516r23=$hlavicka->m516r23; if ( $m516r23 == 0 ) $m516r23="";
$m516r24=$hlavicka->m516r24; if ( $m516r24 == 0 ) $m516r24="";
$m516r25=$hlavicka->m516r25; if ( $m516r25 == 0 ) $m516r25="";
$m516r26=$hlavicka->m516r26; if ( $m516r26 == 0 ) $m516r26="";
$m516r27=$hlavicka->m516r27; if ( $m516r27 == 0 ) $m516r27="";
$m516r31=$hlavicka->m516r31; if ( $m516r31 == 0 ) $m516r31="";
$m516r32=$hlavicka->m516r32; if ( $m516r32 == 0 ) $m516r32="";
$m516r33=$hlavicka->m516r33; if ( $m516r33 == 0 ) $m516r33="";
$m516r34=$hlavicka->m516r34; if ( $m516r34 == 0 ) $m516r34="";
$m516r35=$hlavicka->m516r35; if ( $m516r35 == 0 ) $m516r35="";
$m516r36=$hlavicka->m516r36; if ( $m516r36 == 0 ) $m516r36="";
$m516r37=$hlavicka->m516r37; if ( $m516r37 == 0 ) $m516r37="";
$m516r41=$hlavicka->m516r41; if ( $m516r41 == 0 ) $m516r41="";
$m516r42=$hlavicka->m516r42; if ( $m516r42 == 0 ) $m516r42="";
$m516r43=$hlavicka->m516r43; if ( $m516r43 == 0 ) $m516r43="";
$m516r44=$hlavicka->m516r44; if ( $m516r44 == 0 ) $m516r44="";
$m516r45=$hlavicka->m516r45; if ( $m516r45 == 0 ) $m516r45="";
$m516r46=$hlavicka->m516r46; if ( $m516r46 == 0 ) $m516r46="";
$m516r47=$hlavicka->m516r47; if ( $m516r47 == 0 ) $m516r47="";
$m516r51=$hlavicka->m516r51; if ( $m516r51 == 0 ) $m516r51="";
$m516r53=$hlavicka->m516r53; if ( $m516r53 == 0 ) $m516r53="";
$m516r54=$hlavicka->m516r54; if ( $m516r54 == 0 ) $m516r54="";
$m516r55=$hlavicka->m516r55; if ( $m516r55 == 0 ) $m516r55="";
$m516r57=$hlavicka->m516r57; if ( $m516r57 == 0 ) $m516r57="";
$m516r61=$hlavicka->m516r61; if ( $m516r61 == 0 ) $m516r61="";
$m516r62=$hlavicka->m516r62; if ( $m516r62 == 0 ) $m516r62="";
$m516r63=$hlavicka->m516r63; if ( $m516r63 == 0 ) $m516r63="";
$m516r64=$hlavicka->m516r64; if ( $m516r64 == 0 ) $m516r64="";
$m516r65=$hlavicka->m516r65; if ( $m516r65 == 0 ) $m516r65="";
$m516r66=$hlavicka->m516r66; if ( $m516r66 == 0 ) $m516r66="";
$m516r67=$hlavicka->m516r67; if ( $m516r67 == 0 ) $m516r67="";
$m516r71=$hlavicka->m516r71; if ( $m516r71 == 0 ) $m516r71="";
$m516r72=$hlavicka->m516r72; if ( $m516r72 == 0 ) $m516r72="";
$m516r73=$hlavicka->m516r73; if ( $m516r73 == 0 ) $m516r73="";
$m516r74=$hlavicka->m516r74; if ( $m516r74 == 0 ) $m516r74="";
$m516r75=$hlavicka->m516r75; if ( $m516r75 == 0 ) $m516r75="";
$m516r76=$hlavicka->m516r76; if ( $m516r76 == 0 ) $m516r76="";
$m516r77=$hlavicka->m516r77; if ( $m516r77 == 0 ) $m516r77="";
$m516r81=$hlavicka->m516r81; if ( $m516r81 == 0 ) $m516r81="";
$m516r82=$hlavicka->m516r82; if ( $m516r82 == 0 ) $m516r82="";
$m516r83=$hlavicka->m516r83; if ( $m516r83 == 0 ) $m516r83="";
$m516r84=$hlavicka->m516r84; if ( $m516r84 == 0 ) $m516r84="";
$m516r85=$hlavicka->m516r85; if ( $m516r85 == 0 ) $m516r85="";
$m516r86=$hlavicka->m516r86; if ( $m516r86 == 0 ) $m516r86="";
$m516r87=$hlavicka->m516r87; if ( $m516r87 == 0 ) $m516r87="";
$m516r91=$hlavicka->m516r91; if ( $m516r91 == 0 ) $m516r91="";
$m516r92=$hlavicka->m516r92; if ( $m516r92 == 0 ) $m516r92="";
$m516r93=$hlavicka->m516r93; if ( $m516r93 == 0 ) $m516r93="";
$m516r94=$hlavicka->m516r94; if ( $m516r94 == 0 ) $m516r94="";
$m516r95=$hlavicka->m516r95; if ( $m516r95 == 0 ) $m516r95="";
$m516r96=$hlavicka->m516r96; if ( $m516r96 == 0 ) $m516r96="";
$m516r97=$hlavicka->m516r97; if ( $m516r97 == 0 ) $m516r97="";
$m516r101=$hlavicka->m516r101; if ( $m516r101 == 0 ) $m516r101="";
$m516r102=$hlavicka->m516r102; if ( $m516r102 == 0 ) $m516r102="";
$m516r103=$hlavicka->m516r103; if ( $m516r103 == 0 ) $m516r103="";
$m516r104=$hlavicka->m516r104; if ( $m516r104 == 0 ) $m516r104="";
$m516r105=$hlavicka->m516r105; if ( $m516r105 == 0 ) $m516r105="";
$m516r106=$hlavicka->m516r106; if ( $m516r106 == 0 ) $m516r106="";
$m516r107=$hlavicka->m516r107; if ( $m516r107 == 0 ) $m516r107="";
$m516r111=$hlavicka->m516r111; if ( $m516r111 == 0 ) $m516r111="";
$m516r112=$hlavicka->m516r112; if ( $m516r112 == 0 ) $m516r112="";
$m516r113=$hlavicka->m516r113; if ( $m516r113 == 0 ) $m516r113="";
$m516r114=$hlavicka->m516r114; if ( $m516r114 == 0 ) $m516r114="";
$m516r115=$hlavicka->m516r115; if ( $m516r115 == 0 ) $m516r115="";
$m516r116=$hlavicka->m516r116; if ( $m516r116 == 0 ) $m516r116="";
$m516r117=$hlavicka->m516r117; if ( $m516r117 == 0 ) $m516r117="";
$m516r121=$hlavicka->m516r121; if ( $m516r121 == 0 ) $m516r121="";
$m516r122=$hlavicka->m516r122; if ( $m516r122 == 0 ) $m516r122="";
$m516r123=$hlavicka->m516r123; if ( $m516r123 == 0 ) $m516r123="";
$m516r124=$hlavicka->m516r124; if ( $m516r124 == 0 ) $m516r124="";
$m516r125=$hlavicka->m516r125; if ( $m516r125 == 0 ) $m516r125="";
$m516r126=$hlavicka->m516r126; if ( $m516r126 == 0 ) $m516r126="";
$m516r127=$hlavicka->m516r127; if ( $m516r127 == 0 ) $m516r127="";
$m516r131=$hlavicka->m516r131; if ( $m516r131 == 0 ) $m516r131="";
$m516r132=$hlavicka->m516r132; if ( $m516r132 == 0 ) $m516r132="";
$m516r133=$hlavicka->m516r133; if ( $m516r133 == 0 ) $m516r133="";
$m516r134=$hlavicka->m516r134; if ( $m516r134 == 0 ) $m516r134="";
$m516r135=$hlavicka->m516r135; if ( $m516r135 == 0 ) $m516r135="";
$m516r136=$hlavicka->m516r136; if ( $m516r136 == 0 ) $m516r136="";
$m516r137=$hlavicka->m516r137; if ( $m516r137 == 0 ) $m516r137="";
$m516r141=$hlavicka->m516r141; if ( $m516r141 == 0 ) $m516r141="";
$m516r142=$hlavicka->m516r142; if ( $m516r142 == 0 ) $m516r142="";
$m516r143=$hlavicka->m516r143; if ( $m516r143 == 0 ) $m516r143="";
$m516r144=$hlavicka->m516r144; if ( $m516r144 == 0 ) $m516r144="";
$m516r145=$hlavicka->m516r145; if ( $m516r145 == 0 ) $m516r145="";
$m516r146=$hlavicka->m516r146; if ( $m516r146 == 0 ) $m516r146="";
$m516r147=$hlavicka->m516r147; if ( $m516r147 == 0 ) $m516r147="";
$m516r151=$hlavicka->m516r151; if ( $m516r151 == 0 ) $m516r151="";
$m516r152=$hlavicka->m516r152; if ( $m516r152 == 0 ) $m516r152="";
$m516r153=$hlavicka->m516r153; if ( $m516r153 == 0 ) $m516r153="";
$m516r154=$hlavicka->m516r154; if ( $m516r154 == 0 ) $m516r154="";
$m516r155=$hlavicka->m516r155; if ( $m516r155 == 0 ) $m516r155="";
$m516r156=$hlavicka->m516r156; if ( $m516r156 == 0 ) $m516r156="";
$m516r157=$hlavicka->m516r157; if ( $m516r157 == 0 ) $m516r157="";
$m516r161=$hlavicka->m516r161; if ( $m516r161 == 0 ) $m516r161="";
$m516r162=$hlavicka->m516r162; if ( $m516r162 == 0 ) $m516r162="";
$m516r163=$hlavicka->m516r163; if ( $m516r163 == 0 ) $m516r163="";
$m516r164=$hlavicka->m516r164; if ( $m516r164 == 0 ) $m516r164="";
$m516r165=$hlavicka->m516r165; if ( $m516r165 == 0 ) $m516r165="";
$m516r166=$hlavicka->m516r166; if ( $m516r166 == 0 ) $m516r166="";
$m516r167=$hlavicka->m516r167; if ( $m516r167 == 0 ) $m516r167="";
$m516r171=$hlavicka->m516r171; if ( $m516r171 == 0 ) $m516r171="";
$m516r172=$hlavicka->m516r172; if ( $m516r172 == 0 ) $m516r172="";
$m516r174=$hlavicka->m516r174; if ( $m516r174 == 0 ) $m516r174="";
$m516r175=$hlavicka->m516r175; if ( $m516r175 == 0 ) $m516r175="";
$m516r177=$hlavicka->m516r177; if ( $m516r177 == 0 ) $m516r177="";
$m516r181=$hlavicka->m516r181; if ( $m516r181 == 0 ) $m516r181="";
$m516r182=$hlavicka->m516r182; if ( $m516r182 == 0 ) $m516r182="";
$m516r184=$hlavicka->m516r184; if ( $m516r184 == 0 ) $m516r184="";
$m516r185=$hlavicka->m516r185; if ( $m516r185 == 0 ) $m516r185="";
$m516r187=$hlavicka->m516r187; if ( $m516r187 == 0 ) $m516r187="";
$m516r191=$hlavicka->m516r191; if ( $m516r191 == 0 ) $m516r191="";
$m516r192=$hlavicka->m516r192; if ( $m516r192 == 0 ) $m516r192="";
$m516r194=$hlavicka->m516r194; if ( $m516r194 == 0 ) $m516r194="";
$m516r195=$hlavicka->m516r195; if ( $m516r195 == 0 ) $m516r195="";
$m516r197=$hlavicka->m516r197; if ( $m516r197 == 0 ) $m516r197="";
$m516r201=$hlavicka->m516r201; if ( $m516r201 == 0 ) $m516r201="";
$m516r202=$hlavicka->m516r202; if ( $m516r202 == 0 ) $m516r202="";
$m516r204=$hlavicka->m516r204; if ( $m516r204 == 0 ) $m516r204="";
$m516r205=$hlavicka->m516r205; if ( $m516r205 == 0 ) $m516r205="";
$m516r206=$hlavicka->m516r206; if ( $m516r206 == 0 ) $m516r206="";
$m516r207=$hlavicka->m516r207; if ( $m516r207 == 0 ) $m516r207="";
$m516r211=$hlavicka->m516r211; if ( $m516r211 == 0 ) $m516r211="";
$m516r212=$hlavicka->m516r212; if ( $m516r212 == 0 ) $m516r212="";
$m516r214=$hlavicka->m516r214; if ( $m516r214 == 0 ) $m516r214="";
$m516r215=$hlavicka->m516r215; if ( $m516r215 == 0 ) $m516r215="";
$m516r216=$hlavicka->m516r216; if ( $m516r216 == 0 ) $m516r216="";
$m516r217=$hlavicka->m516r217; if ( $m516r217 == 0 ) $m516r217="";
$m516r221=$hlavicka->m516r221; if ( $m516r221 == 0 ) $m516r221="";
$m516r222=$hlavicka->m516r222; if ( $m516r222 == 0 ) $m516r222="";
$m516r223=$hlavicka->m516r223; if ( $m516r223 == 0 ) $m516r223="";
$m516r224=$hlavicka->m516r224; if ( $m516r224 == 0 ) $m516r224="";
$m516r225=$hlavicka->m516r225; if ( $m516r225 == 0 ) $m516r225="";
$m516r226=$hlavicka->m516r226; if ( $m516r226 == 0 ) $m516r226="";
$m516r227=$hlavicka->m516r227; if ( $m516r227 == 0 ) $m516r227="";
$m516r228=$hlavicka->m516r228; if ( $m516r228 == 0 ) $m516r228="";
$m516r229=$hlavicka->m516r229; if ( $m516r229 == 0 ) $m516r229="";
$m516r991=$hlavicka->m516r991;
//if ( $m516r991 == 0 ) $m516r991="";
$m516r992=$hlavicka->m516r992;
//if ( $m516r992 == 0 ) $m516r992="";
$m516r993=$hlavicka->m516r993;
//if ( $m516r993 == 0 ) $m516r993="";
$m516r994=$hlavicka->m516r994;
//if ( $m516r994 == 0 ) $m516r994="";
$m516r995=$hlavicka->m516r995;
//if ( $m516r995 == 0 ) $m516r995="";
$m516r996=$hlavicka->m516r996;
//if ( $m516r996 == 0 ) $m516r996="";
$m516r997=$hlavicka->m516r997;
//if ( $m516r997 == 0 ) $m516r997="";
$pdf->Cell(195,36," ","$rmc1",1,"L");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r11","$rmc",0,"R");$pdf->Cell(29,5,"$m516r12","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r13","$rmc",0,"R");$pdf->Cell(29,5,"$m516r14","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r15","$rmc",0,"R");$pdf->Cell(29,5,"$m516r16","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r17","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r21","$rmc",0,"R");$pdf->Cell(29,4,"$m516r22","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r23","$rmc",0,"R");$pdf->Cell(29,4,"$m516r24","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r25","$rmc",0,"R");$pdf->Cell(29,4,"$m516r26","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r27","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r31","$rmc",0,"R");$pdf->Cell(29,4,"$m516r32","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r33","$rmc",0,"R");$pdf->Cell(29,4,"$m516r34","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r35","$rmc",0,"R");$pdf->Cell(29,4,"$m516r36","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r37","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r41","$rmc",0,"R");$pdf->Cell(29,4,"$m516r42","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r43","$rmc",0,"R");$pdf->Cell(29,4,"$m516r44","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r45","$rmc",0,"R");$pdf->Cell(29,4,"$m516r46","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r47","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r51","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r53","$rmc",0,"R");$pdf->Cell(29,4,"$m516r54","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r55","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r57","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r61","$rmc",0,"R");$pdf->Cell(29,5,"$m516r62","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r63","$rmc",0,"R");$pdf->Cell(29,5,"$m516r64","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r65","$rmc",0,"R");$pdf->Cell(29,5,"$m516r66","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r67","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r71","$rmc",0,"R");$pdf->Cell(29,4,"$m516r72","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r73","$rmc",0,"R");$pdf->Cell(29,4,"$m516r74","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r75","$rmc",0,"R");$pdf->Cell(29,4,"$m516r76","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r77","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r81","$rmc",0,"R");$pdf->Cell(29,4,"$m516r82","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r83","$rmc",0,"R");$pdf->Cell(29,4,"$m516r84","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r85","$rmc",0,"R");$pdf->Cell(29,4,"$m516r86","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r87","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r91","$rmc",0,"R");$pdf->Cell(29,4,"$m516r92","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r93","$rmc",0,"R");$pdf->Cell(29,4,"$m516r94","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r95","$rmc",0,"R");$pdf->Cell(29,4,"$m516r96","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r97","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r101","$rmc",0,"R");$pdf->Cell(29,4,"$m516r102","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r103","$rmc",0,"R");$pdf->Cell(29,4,"$m516r104","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r105","$rmc",0,"R");$pdf->Cell(29,4,"$m516r106","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r107","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r111","$rmc",0,"R");$pdf->Cell(29,5,"$m516r112","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r113","$rmc",0,"R");$pdf->Cell(29,5,"$m516r114","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r115","$rmc",0,"R");$pdf->Cell(29,5,"$m516r116","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r117","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r121","$rmc",0,"R");$pdf->Cell(29,4,"$m516r122","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r123","$rmc",0,"R");$pdf->Cell(29,4,"$m516r124","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r125","$rmc",0,"R");$pdf->Cell(29,4,"$m516r126","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r127","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r131","$rmc",0,"R");$pdf->Cell(29,5,"$m516r132","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r133","$rmc",0,"R");$pdf->Cell(29,5,"$m516r134","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r135","$rmc",0,"R");$pdf->Cell(29,5,"$m516r136","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r137","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r141","$rmc",0,"R");$pdf->Cell(29,5,"$m516r142","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r143","$rmc",0,"R");$pdf->Cell(29,5,"$m516r144","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r145","$rmc",0,"R");$pdf->Cell(29,5,"$m516r146","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r147","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r151","$rmc",0,"R");$pdf->Cell(29,4,"$m516r152","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r153","$rmc",0,"R");$pdf->Cell(29,4,"$m516r154","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r155","$rmc",0,"R");$pdf->Cell(29,4,"$m516r156","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r157","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r161","$rmc",0,"R");$pdf->Cell(29,4,"$m516r162","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r163","$rmc",0,"R");$pdf->Cell(29,4,"$m516r164","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r165","$rmc",0,"R");$pdf->Cell(29,4,"$m516r166","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r167","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r171","$rmc",0,"R");$pdf->Cell(29,4,"$m516r172","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"$m516r174","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r175","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r177","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r181","$rmc",0,"R");$pdf->Cell(29,5,"$m516r182","$rmc",0,"R");
$pdf->Cell(29,5,"","$rmc",0,"R");$pdf->Cell(29,5,"$m516r184","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r185","$rmc",0,"R");$pdf->Cell(29,5,"","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r187","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r191","$rmc",0,"R");$pdf->Cell(29,4,"$m516r192","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"$m516r194","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r195","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r197","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r201","$rmc",0,"R");$pdf->Cell(29,4,"$m516r202","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"$m516r204","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r205","$rmc",0,"R");$pdf->Cell(29,4,"$m516r206","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r207","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r211","$rmc",0,"R");$pdf->Cell(29,4,"$m516r212","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"$m516r214","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r215","$rmc",0,"R");$pdf->Cell(29,4,"$m516r216","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r217","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m516r221","$rmc",0,"R");$pdf->Cell(29,4,"$m516r222","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r223","$rmc",0,"R");$pdf->Cell(29,4,"$m516r224","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r225","$rmc",0,"R");$pdf->Cell(29,4,"$m516r226","$rmc",0,"R");
$pdf->Cell(29,4,"$m516r227","$rmc",1,"R");
$pdf->Cell(89,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m516r991","$rmc",0,"R");$pdf->Cell(29,5,"$m516r992","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r993","$rmc",0,"R");$pdf->Cell(29,5,"$m516r994","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r995","$rmc",0,"R");$pdf->Cell(29,5,"$m516r996","$rmc",0,"R");
$pdf->Cell(29,5,"$m516r997","$rmc",1,"R");
                                       }

if ( $strana == 9 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str9.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str9.jpg',5,0,305,210);
}

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
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
$pdf->Cell(217,4," ","$rmc1",0,"L");
$pdf->Cell(6,5,"$A","$rmc",0,"C");$pdf->Cell(6,5,"$B","$rmc",0,"C");$pdf->Cell(6,5,"$C","$rmc",0,"C");$pdf->Cell(6,5,"$D","$rmc",0,"C");
$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(6,5,"$F","$rmc",0,"C");$pdf->Cell(6,5,"$G","$rmc",0,"C");$pdf->Cell(6,5,"$H","$rmc",1,"C");

//modul 572
$m572r11=$hlavicka->m572r11; if ( $m572r11 == 0 ) $m572r11="";
$m572r12=$hlavicka->m572r12; if ( $m572r12 == 0 ) $m572r12="";
$m572r13=$hlavicka->m572r13; if ( $m572r13 == 0 ) $m572r13="";
$m572r14=$hlavicka->m572r14; if ( $m572r14 == 0 ) $m572r14="";
$m572r15=$hlavicka->m572r15; if ( $m572r15 == 0 ) $m572r15="";
$m572r16=$hlavicka->m572r16; if ( $m572r16 == 0 ) $m572r16="";
$m572r17=$hlavicka->m572r17; if ( $m572r17 == 0 ) $m572r17="";
$m572r18=$hlavicka->m572r18; if ( $m572r18 == 0 ) $m572r18="";
$m572r19=$hlavicka->m572r19; if ( $m572r19 == 0 ) $m572r19="";
$m572r110=$hlavicka->m572r110; if ( $m572r110 == 0 ) $m572r110="";
$m572r0111=$hlavicka->m572r0111; if ( $m572r0111 == 0 ) $m572r0111="";
$m572r21=$hlavicka->m572r21; if ( $m572r21 == 0 ) $m572r21="";
$m572r22=$hlavicka->m572r22; if ( $m572r22 == 0 ) $m572r22="";
$m572r23=$hlavicka->m572r23; if ( $m572r23 == 0 ) $m572r23="";
$m572r25=$hlavicka->m572r25; if ( $m572r25 == 0 ) $m572r25="";
$m572r26=$hlavicka->m572r26; if ( $m572r26 == 0 ) $m572r26="";
$m572r27=$hlavicka->m572r27; if ( $m572r27 == 0 ) $m572r27="";
$m572r28=$hlavicka->m572r28; if ( $m572r28 == 0 ) $m572r28="";
$m572r29=$hlavicka->m572r29; if ( $m572r29 == 0 ) $m572r29="";
$m572r210=$hlavicka->m572r210; if ( $m572r210 == 0 ) $m572r210="";
$m572r0211=$hlavicka->m572r0211; if ( $m572r0211 == 0 ) $m572r0211="";
$m572r38=$hlavicka->m572r38; if ( $m572r38 == 0 ) $m572r38="";
$m572r39=$hlavicka->m572r39; if ( $m572r39 == 0 ) $m572r39="";
$m572r310=$hlavicka->m572r310; if ( $m572r310 == 0 ) $m572r310="";
$m572r311=$hlavicka->m572r311; if ( $m572r311 == 0 ) $m572r311="";
$m572r48=$hlavicka->m572r48; if ( $m572r48 == 0 ) $m572r48="";
$m572r49=$hlavicka->m572r49; if ( $m572r49 == 0 ) $m572r49="";
$m572r410=$hlavicka->m572r410; if ( $m572r410 == 0 ) $m572r410="";
$m572r411=$hlavicka->m572r411; if ( $m572r411 == 0 ) $m572r411="";
$m572r58=$hlavicka->m572r58; if ( $m572r58 == 0 ) $m572r58="";
$m572r59=$hlavicka->m572r59; if ( $m572r59 == 0 ) $m572r59="";
$m572r510=$hlavicka->m572r510; if ( $m572r510 == 0 ) $m572r510="";
$m572r511=$hlavicka->m572r511; if ( $m572r511 == 0 ) $m572r511="";
$m572r68=$hlavicka->m572r68; if ( $m572r68 == 0 ) $m572r68="";
$m572r69=$hlavicka->m572r69; if ( $m572r69 == 0 ) $m572r69="";
$m572r610=$hlavicka->m572r610; if ( $m572r610 == 0 ) $m572r610="";
$m572r611=$hlavicka->m572r611; if ( $m572r611 == 0 ) $m572r611="";
$m572r78=$hlavicka->m572r78; if ( $m572r78 == 0 ) $m572r78="";
$m572r79=$hlavicka->m572r79; if ( $m572r79 == 0 ) $m572r79="";
$m572r710=$hlavicka->m572r710; if ( $m572r710 == 0 ) $m572r710="";
$m572r711=$hlavicka->m572r711; if ( $m572r711 == 0 ) $m572r711="";
$m572r88=$hlavicka->m572r88; if ( $m572r88 == 0 ) $m572r88="";
$m572r89=$hlavicka->m572r89; if ( $m572r89 == 0 ) $m572r89="";
$m572r810=$hlavicka->m572r810; if ( $m572r810 == 0 ) $m572r810="";
$m572r811=$hlavicka->m572r811; if ( $m572r811 == 0 ) $m572r811="";
$m572r98=$hlavicka->m572r98; if ( $m572r98 == 0 ) $m572r98="";
$m572r99=$hlavicka->m572r99; if ( $m572r99 == 0 ) $m572r99="";
$m572r910=$hlavicka->m572r910; if ( $m572r910 == 0 ) $m572r910="";
$m572r911=$hlavicka->m572r911; if ( $m572r911 == 0 ) $m572r911="";
$m572r108=$hlavicka->m572r108; if ( $m572r108 == 0 ) $m572r108="";
$m572r109=$hlavicka->m572r109; if ( $m572r109 == 0 ) $m572r109="";
$m572r1010=$hlavicka->m572r1010; if ( $m572r1010 == 0 ) $m572r1010="";
$m572r1011=$hlavicka->m572r1011; if ( $m572r1011 == 0 ) $m572r1011="";
$m572r111=$hlavicka->m572r111; if ( $m572r111 == 0 ) $m572r111="";
$m572r112=$hlavicka->m572r112; if ( $m572r112 == 0 ) $m572r112="";
$m572r113=$hlavicka->m572r113; if ( $m572r113 == 0 ) $m572r113="";
$m572r114=$hlavicka->m572r114; if ( $m572r114 == 0 ) $m572r114="";
$m572r115=$hlavicka->m572r115; if ( $m572r115 == 0 ) $m572r115="";
$m572r116=$hlavicka->m572r116; if ( $m572r116 == 0 ) $m572r116="";
$m572r117=$hlavicka->m572r117; if ( $m572r117 == 0 ) $m572r117="";
$m572r118=$hlavicka->m572r118; if ( $m572r118 == 0 ) $m572r118="";
$m572r119=$hlavicka->m572r119; if ( $m572r119 == 0 ) $m572r119="";
$m572r1110=$hlavicka->m572r1110; if ( $m572r1110 == 0 ) $m572r1110="";
$m572r1111=$hlavicka->m572r1111; if ( $m572r1111 == 0 ) $m572r1111="";
$m572r121=$hlavicka->m572r121; if ( $m572r121 == 0 ) $m572r121="";
$m572r122=$hlavicka->m572r122; if ( $m572r122 == 0 ) $m572r122="";
$m572r123=$hlavicka->m572r123; if ( $m572r123 == 0 ) $m572r123="";
$m572r124=$hlavicka->m572r124; if ( $m572r124 == 0 ) $m572r124="";
$m572r125=$hlavicka->m572r125; if ( $m572r125 == 0 ) $m572r125="";
$m572r126=$hlavicka->m572r126; if ( $m572r126 == 0 ) $m572r126="";
$m572r127=$hlavicka->m572r127; if ( $m572r127 == 0 ) $m572r127="";
$m572r128=$hlavicka->m572r128; if ( $m572r128 == 0 ) $m572r128="";
$m572r129=$hlavicka->m572r129; if ( $m572r129 == 0 ) $m572r129="";
$m572r1210=$hlavicka->m572r1210; if ( $m572r1210 == 0 ) $m572r1210="";
$m572r1211=$hlavicka->m572r1211; if ( $m572r1211 == 0 ) $m572r1211="";
$m572r131=$hlavicka->m572r131; if ( $m572r131 == 0 ) $m572r131="";
$m572r132=$hlavicka->m572r132; if ( $m572r132 == 0 ) $m572r132="";
$m572r133=$hlavicka->m572r133; if ( $m572r133 == 0 ) $m572r133="";
$m572r134=$hlavicka->m572r134; if ( $m572r134 == 0 ) $m572r134="";
$m572r135=$hlavicka->m572r135; if ( $m572r135 == 0 ) $m572r135="";
$m572r136=$hlavicka->m572r136; if ( $m572r136 == 0 ) $m572r136="";
$m572r137=$hlavicka->m572r137; if ( $m572r137 == 0 ) $m572r137="";
$m572r138=$hlavicka->m572r138; if ( $m572r138 == 0 ) $m572r138="";
$m572r139=$hlavicka->m572r139; if ( $m572r139 == 0 ) $m572r139="";
$m572r1310=$hlavicka->m572r1310; if ( $m572r1310 == 0 ) $m572r1310="";
$m572r1311=$hlavicka->m572r1311; if ( $m572r1311 == 0 ) $m572r1311="";
$m572r141=$hlavicka->m572r141; if ( $m572r141 == 0 ) $m572r141="";
$m572r142=$hlavicka->m572r142; if ( $m572r142 == 0 ) $m572r142="";
$m572r143=$hlavicka->m572r143; if ( $m572r143 == 0 ) $m572r143="";
$m572r144=$hlavicka->m572r144; if ( $m572r144 == 0 ) $m572r144="";
$m572r145=$hlavicka->m572r145; if ( $m572r145 == 0 ) $m572r145="";
$m572r146=$hlavicka->m572r146; if ( $m572r146 == 0 ) $m572r146="";
$m572r147=$hlavicka->m572r147; if ( $m572r147 == 0 ) $m572r147="";
$m572r148=$hlavicka->m572r148; if ( $m572r148 == 0 ) $m572r148="";
$m572r149=$hlavicka->m572r149; if ( $m572r149 == 0 ) $m572r149="";
$m572r1410=$hlavicka->m572r1410; if ( $m572r1410 == 0 ) $m572r1410="";
$m572r1411=$hlavicka->m572r1411; if ( $m572r1411 == 0 ) $m572r1411="";
$m572r151=$hlavicka->m572r151; if ( $m572r151 == 0 ) $m572r151="";
$m572r152=$hlavicka->m572r152; if ( $m572r152 == 0 ) $m572r152="";
$m572r153=$hlavicka->m572r153; if ( $m572r153 == 0 ) $m572r153="";
$m572r154=$hlavicka->m572r154; if ( $m572r154 == 0 ) $m572r154="";
$m572r155=$hlavicka->m572r155; if ( $m572r155 == 0 ) $m572r155="";
$m572r156=$hlavicka->m572r156; if ( $m572r156 == 0 ) $m572r156="";
$m572r157=$hlavicka->m572r157; if ( $m572r157 == 0 ) $m572r157="";
$m572r158=$hlavicka->m572r158; if ( $m572r158 == 0 ) $m572r158="";
$m572r159=$hlavicka->m572r159; if ( $m572r159 == 0 ) $m572r159="";
$m572r1510=$hlavicka->m572r1510; if ( $m572r1510 == 0 ) $m572r1510="";
$m572r1511=$hlavicka->m572r1511; if ( $m572r1511 == 0 ) $m572r1511="";
$m572r161=$hlavicka->m572r161; if ( $m572r161 == 0 ) $m572r161="";
$m572r162=$hlavicka->m572r162; if ( $m572r162 == 0 ) $m572r162="";
$m572r163=$hlavicka->m572r163; if ( $m572r163 == 0 ) $m572r163="";
$m572r165=$hlavicka->m572r165; if ( $m572r165 == 0 ) $m572r165="";
$m572r166=$hlavicka->m572r166; if ( $m572r166 == 0 ) $m572r166="";
$m572r167=$hlavicka->m572r167; if ( $m572r167 == 0 ) $m572r167="";
$m572r168=$hlavicka->m572r168; if ( $m572r168 == 0 ) $m572r168="";
$m572r169=$hlavicka->m572r169; if ( $m572r169 == 0 ) $m572r169="";
$m572r1610=$hlavicka->m572r1610; if ( $m572r1610 == 0 ) $m572r1610="";
$m572r1611=$hlavicka->m572r1611; if ( $m572r1611 == 0 ) $m572r1611="";
$m572r178=$hlavicka->m572r178; if ( $m572r178 == 0 ) $m572r178="";
$m572r179=$hlavicka->m572r179; if ( $m572r179 == 0 ) $m572r179="";
$m572r1710=$hlavicka->m572r1710; if ( $m572r1710 == 0 ) $m572r1710="";
$m572r1711=$hlavicka->m572r1711; if ( $m572r1711 == 0 ) $m572r1711="";
$m572r181=$hlavicka->m572r181; if ( $m572r181 == 0 ) $m572r181="";
$m572r182=$hlavicka->m572r182; if ( $m572r182 == 0 ) $m572r182="";
$m572r183=$hlavicka->m572r183; if ( $m572r183 == 0 ) $m572r183="";
$m572r188=$hlavicka->m572r188; if ( $m572r188 == 0 ) $m572r188="";
$m572r189=$hlavicka->m572r189; if ( $m572r189 == 0 ) $m572r189="";
$m572r1810=$hlavicka->m572r1810; if ( $m572r1810 == 0 ) $m572r1810="";
$m572r1811=$hlavicka->m572r1811; if ( $m572r1811 == 0 ) $m572r1811="";
$m572r198=$hlavicka->m572r198; if ( $m572r198 == 0 ) $m572r198="";
$m572r199=$hlavicka->m572r199; if ( $m572r199 == 0 ) $m572r199="";
$m572r1910=$hlavicka->m572r1910; if ( $m572r1910 == 0 ) $m572r1910="";
$m572r1911=$hlavicka->m572r1911; if ( $m572r1911 == 0 ) $m572r1911="";
$m572r208=$hlavicka->m572r208; if ( $m572r208 == 0 ) $m572r208="";
$m572r209=$hlavicka->m572r209; if ( $m572r209 == 0 ) $m572r209="";
$m572r2010=$hlavicka->m572r2010; if ( $m572r2010 == 0 ) $m572r2010="";
$m572r2011=$hlavicka->m572r2011; if ( $m572r2011 == 0 ) $m572r2011="";
$m572r211=$hlavicka->m572r211; if ( $m572r211 == 0 ) $m572r211="";
$m572r212=$hlavicka->m572r212; if ( $m572r212 == 0 ) $m572r212="";
$m572r213=$hlavicka->m572r213; if ( $m572r213 == 0 ) $m572r213="";
$m572r218=$hlavicka->m572r218; if ( $m572r218 == 0 ) $m572r218="";
$m572r219=$hlavicka->m572r219; if ( $m572r219 == 0 ) $m572r219="";
$m572r2110=$hlavicka->m572r2110; if ( $m572r2110 == 0 ) $m572r2110="";
$m572r2111=$hlavicka->m572r2111; if ( $m572r2111 == 0 ) $m572r2111="";
$m572r228=$hlavicka->m572r228; if ( $m572r228 == 0 ) $m572r228="";
$m572r229=$hlavicka->m572r229; if ( $m572r229 == 0 ) $m572r229="";
$m572r2210=$hlavicka->m572r2210; if ( $m572r2210 == 0 ) $m572r2210="";
$m572r2211=$hlavicka->m572r2211; if ( $m572r2211 == 0 ) $m572r2211="";
$m572r238=$hlavicka->m572r238; if ( $m572r238 == 0 ) $m572r238="";
$m572r239=$hlavicka->m572r239; if ( $m572r239 == 0 ) $m572r239="";
$m572r2310=$hlavicka->m572r2310; if ( $m572r2310 == 0 ) $m572r2310="";
$m572r2311=$hlavicka->m572r2311; if ( $m572r2311 == 0 ) $m572r2311="";
$m572r248=$hlavicka->m572r248; if ( $m572r248 == 0 ) $m572r248="";
$m572r249=$hlavicka->m572r249; if ( $m572r249 == 0 ) $m572r249="";
$m572r2410=$hlavicka->m572r2410; if ( $m572r2410 == 0 ) $m572r2410="";
$m572r2411=$hlavicka->m572r2411; if ( $m572r2411 == 0 ) $m572r2411="";
$m572r991=$hlavicka->m572r991;
//if ( $m572r991 == 0 ) $m572r991="";
$m572r992=$hlavicka->m572r992;
//if ( $m572r992 == 0 ) $m572r992="";
$m572r993=$hlavicka->m572r993;
//if ( $m572r993 == 0 ) $m572r993="";
$m572r994=$hlavicka->m572r994;
//if ( $m572r994 == 0 ) $m572r994="";
$m572r995=$hlavicka->m572r995;
//if ( $m572r995 == 0 ) $m572r995="";
$m572r996=$hlavicka->m572r996;
//if ( $m572r996 == 0 ) $m572r996="";
$m572r997=$hlavicka->m572r997;
//if ( $m572r997 == 0 ) $m572r997="";
$m572r998=$hlavicka->m572r998;
//if ( $m572r998 == 0 ) $m572r998="";
$m572r999=$hlavicka->m572r999;
//if ( $m572r999 == 0 ) $m572r999="";
$m572r9910=$hlavicka->m572r9910;
//if ( $m572r9910 == 0 ) $m572r9910="";
$m572r9911=$hlavicka->m572r9911;
//if ( $m572r9911 == 0 ) $m572r9911="";
$pdf->Cell(195,37," ","$rmc1",1,"L");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r11","$rmc",0,"R");$pdf->Cell(22,4,"$m572r12","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r13","$rmc",0,"R");$pdf->Cell(22,4,"$m572r14","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r15","$rmc",0,"R");$pdf->Cell(22,4,"$m572r16","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r17","$rmc",0,"R");$pdf->Cell(22,4,"$m572r18","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r19","$rmc",0,"R");$pdf->Cell(22,4,"$m572r110","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r0111","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r21","$rmc",0,"R");$pdf->Cell(22,4,"$m572r22","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r23","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r25","$rmc",0,"R");$pdf->Cell(22,4,"$m572r26","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r27","$rmc",0,"R");$pdf->Cell(22,4,"$m572r28","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r29","$rmc",0,"R");$pdf->Cell(22,4,"$m572r210","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r0211","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"$m572r38","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r39","$rmc",0,"R");$pdf->Cell(22,4,"$m572r310","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r311","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(21,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"$m572r48","$rmc",0,"R");
$pdf->Cell(21,5,"$m572r49","$rmc",0,"R");$pdf->Cell(22,5,"$m572r410","$rmc",0,"R");
$pdf->Cell(22,5,"$m572r411","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r58","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r59","$rmc",0,"R");$pdf->Cell(22,6,"$m572r510","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r511","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r68","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r69","$rmc",0,"R");$pdf->Cell(22,6,"$m572r610","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r611","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(21,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"$m572r78","$rmc",0,"R");
$pdf->Cell(21,5,"$m572r79","$rmc",0,"R");$pdf->Cell(22,5,"$m572r710","$rmc",0,"R");
$pdf->Cell(22,5,"$m572r711","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"$m572r88","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r89","$rmc",0,"R");$pdf->Cell(22,4,"$m572r810","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r811","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r98","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r99","$rmc",0,"R");$pdf->Cell(22,6,"$m572r910","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r911","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(21,5,"","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(22,5,"","$rmc",0,"R");$pdf->Cell(22,5,"$m572r108","$rmc",0,"R");
$pdf->Cell(21,5,"$m572r109","$rmc",0,"R");$pdf->Cell(22,5,"$m572r1010","$rmc",0,"R");
$pdf->Cell(22,5,"$m572r1011","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r111","$rmc",0,"R");$pdf->Cell(22,4,"$m572r112","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r113","$rmc",0,"R");$pdf->Cell(22,4,"$m572r114","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r115","$rmc",0,"R");$pdf->Cell(22,4,"$m572r116","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r117","$rmc",0,"R");$pdf->Cell(22,4,"$m572r118","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r119","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1110","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1111","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r121","$rmc",0,"R");$pdf->Cell(22,4,"$m572r122","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r123","$rmc",0,"R");$pdf->Cell(22,4,"$m572r124","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r125","$rmc",0,"R");$pdf->Cell(22,4,"$m572r126","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r127","$rmc",0,"R");$pdf->Cell(22,4,"$m572r128","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r129","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1210","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1211","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r131","$rmc",0,"R");$pdf->Cell(22,4,"$m572r132","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r133","$rmc",0,"R");$pdf->Cell(22,4,"$m572r134","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r135","$rmc",0,"R");$pdf->Cell(22,4,"$m572r136","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r137","$rmc",0,"R");$pdf->Cell(22,4,"$m572r138","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r139","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1310","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1311","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r141","$rmc",0,"R");$pdf->Cell(22,4,"$m572r142","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r143","$rmc",0,"R");$pdf->Cell(22,4,"$m572r144","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r145","$rmc",0,"R");$pdf->Cell(22,4,"$m572r146","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r147","$rmc",0,"R");$pdf->Cell(22,4,"$m572r148","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r149","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1410","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1411","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r151","$rmc",0,"R");$pdf->Cell(22,4,"$m572r152","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r153","$rmc",0,"R");$pdf->Cell(22,4,"$m572r154","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r155","$rmc",0,"R");$pdf->Cell(22,4,"$m572r156","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r157","$rmc",0,"R");$pdf->Cell(22,4,"$m572r158","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r159","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1510","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1511","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,5,"$m572r161","$rmc",0,"R");$pdf->Cell(22,5,"$m572r162","$rmc",0,"R");
$pdf->Cell(22,5,"$m572r163","$rmc",0,"R");$pdf->Cell(22,5,"","$rmc",0,"R");
$pdf->Cell(21,5,"$m572r165","$rmc",0,"R");$pdf->Cell(22,5,"$m572r166","$rmc",0,"R");
$pdf->Cell(22,5,"$m572r167","$rmc",0,"R");$pdf->Cell(22,5,"$m572r168","$rmc",0,"R");
$pdf->Cell(21,5,"$m572r169","$rmc",0,"R");$pdf->Cell(22,5,"$m572r1610","$rmc",0,"R");
$pdf->Cell(22,5,"$m572r1611","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"$m572r178","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r179","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1710","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1711","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r181","$rmc",0,"R");$pdf->Cell(22,4,"$m572r182","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r183","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"$m572r188","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r189","$rmc",0,"R");$pdf->Cell(22,4,"$m572r1810","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r1811","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r198","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r199","$rmc",0,"R");$pdf->Cell(22,6,"$m572r1910","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r1911","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r208","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r209","$rmc",0,"R");$pdf->Cell(22,6,"$m572r2010","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r2011","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$m572r211","$rmc",0,"R");$pdf->Cell(22,6,"$m572r212","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r213","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r218","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r219","$rmc",0,"R");$pdf->Cell(22,6,"$m572r2110","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r2111","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"$m572r228","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r229","$rmc",0,"R");$pdf->Cell(22,4,"$m572r2210","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r2211","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(22,6,"","$rmc",0,"R");
$pdf->Cell(22,6,"","$rmc",0,"R");$pdf->Cell(22,6,"$m572r238","$rmc",0,"R");
$pdf->Cell(21,6,"$m572r239","$rmc",0,"R");$pdf->Cell(22,6,"$m572r2310","$rmc",0,"R");
$pdf->Cell(22,6,"$m572r2311","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(21,4,"","$rmc",0,"R");$pdf->Cell(22,4,"","$rmc",0,"R");
$pdf->Cell(22,4,"","$rmc",0,"R");$pdf->Cell(22,4,"$m572r248","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r249","$rmc",0,"R");$pdf->Cell(22,4,"$m572r2410","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r2411","$rmc",1,"R");
$pdf->Cell(52,4," ","$rmc1",0,"L");
$pdf->Cell(22,4,"$m572r991","$rmc",0,"R");$pdf->Cell(22,4,"$m572r992","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r993","$rmc",0,"R");$pdf->Cell(22,4,"$m572r994","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r995","$rmc",0,"R");$pdf->Cell(22,4,"$m572r996","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r997","$rmc",0,"R");$pdf->Cell(22,4,"$m572r998","$rmc",0,"R");
$pdf->Cell(21,4,"$m572r999","$rmc",0,"R");$pdf->Cell(22,4,"$m572r9910","$rmc",0,"R");
$pdf->Cell(22,4,"$m572r9911","$rmc",1,"R");
                                       }
}
$i = $i + 1;
  }
//koniec tlac strana 1 az 9

//vytlac strana 10 az 15
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_vts101s2 WHERE ico >= 0 "."";
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

if ( $strana == 10 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',8);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str10.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str10.jpg',5,0,305,210);
}

//modul 573
$m573r11=$hlavicka->m573r11; if ( $m573r11 == 0 ) $m573r11="";
$m573r12=$hlavicka->m573r12; if ( $m573r12 == 0 ) $m573r12="";
$m573r13=$hlavicka->m573r13; if ( $m573r13 == 0 ) $m573r13="";
$m573r14=$hlavicka->m573r14; if ( $m573r14 == 0 ) $m573r14="";
$m573r15=$hlavicka->m573r15; if ( $m573r15 == 0 ) $m573r15="";
$m573r16=$hlavicka->m573r16; if ( $m573r16 == 0 ) $m573r16="";
$m573r17=$hlavicka->m573r17; if ( $m573r17 == 0 ) $m573r17="";
$m573r18=$hlavicka->m573r18; if ( $m573r18 == 0 ) $m573r18="";
$m573r21=$hlavicka->m573r21; if ( $m573r21 == 0 ) $m573r21="";
$m573r22=$hlavicka->m573r22; if ( $m573r22 == 0 ) $m573r22="";
$m573r23=$hlavicka->m573r23; if ( $m573r23 == 0 ) $m573r23="";
$m573r24=$hlavicka->m573r24; if ( $m573r24 == 0 ) $m573r24="";
$m573r25=$hlavicka->m573r25; if ( $m573r25 == 0 ) $m573r25="";
$m573r26=$hlavicka->m573r26; if ( $m573r26 == 0 ) $m573r26="";
$m573r27=$hlavicka->m573r27; if ( $m573r27 == 0 ) $m573r27="";
$m573r28=$hlavicka->m573r28; if ( $m573r28 == 0 ) $m573r28="";
$m573r35=$hlavicka->m573r35; if ( $m573r35 == 0 ) $m573r35="";
$m573r36=$hlavicka->m573r36; if ( $m573r36 == 0 ) $m573r36="";
$m573r37=$hlavicka->m573r37; if ( $m573r37 == 0 ) $m573r37="";
$m573r38=$hlavicka->m573r38; if ( $m573r38 == 0 ) $m573r38="";
$m573r45=$hlavicka->m573r45; if ( $m573r45 == 0 ) $m573r45="";
$m573r46=$hlavicka->m573r46; if ( $m573r46 == 0 ) $m573r46="";
$m573r47=$hlavicka->m573r47; if ( $m573r47 == 0 ) $m573r47="";
$m573r48=$hlavicka->m573r48; if ( $m573r48 == 0 ) $m573r48="";
$m573r55=$hlavicka->m573r55; if ( $m573r55 == 0 ) $m573r55="";
$m573r56=$hlavicka->m573r56; if ( $m573r56 == 0 ) $m573r56="";
$m573r57=$hlavicka->m573r57; if ( $m573r57 == 0 ) $m573r57="";
$m573r58=$hlavicka->m573r58; if ( $m573r58 == 0 ) $m573r58="";
$m573r65=$hlavicka->m573r65; if ( $m573r65 == 0 ) $m573r65="";
$m573r66=$hlavicka->m573r66; if ( $m573r66 == 0 ) $m573r66="";
$m573r67=$hlavicka->m573r67; if ( $m573r67 == 0 ) $m573r67="";
$m573r68=$hlavicka->m573r68; if ( $m573r68 == 0 ) $m573r68="";
$m573r75=$hlavicka->m573r75; if ( $m573r75 == 0 ) $m573r75="";
$m573r76=$hlavicka->m573r76; if ( $m573r76 == 0 ) $m573r76="";
$m573r77=$hlavicka->m573r77; if ( $m573r77 == 0 ) $m573r77="";
$m573r78=$hlavicka->m573r78; if ( $m573r78 == 0 ) $m573r78="";
$m573r81=$hlavicka->m573r81; if ( $m573r81 == 0 ) $m573r81="";
$m573r82=$hlavicka->m573r82; if ( $m573r82 == 0 ) $m573r82="";
$m573r83=$hlavicka->m573r83; if ( $m573r83 == 0 ) $m573r83="";
$m573r84=$hlavicka->m573r84; if ( $m573r84 == 0 ) $m573r84="";
$m573r85=$hlavicka->m573r85; if ( $m573r85 == 0 ) $m573r85="";
$m573r86=$hlavicka->m573r86; if ( $m573r86 == 0 ) $m573r86="";
$m573r87=$hlavicka->m573r87; if ( $m573r87 == 0 ) $m573r87="";
$m573r88=$hlavicka->m573r88; if ( $m573r88 == 0 ) $m573r88="";
$m573r91=$hlavicka->m573r91; if ( $m573r91 == 0 ) $m573r91="";
$m573r92=$hlavicka->m573r92; if ( $m573r92 == 0 ) $m573r92="";
$m573r93=$hlavicka->m573r93; if ( $m573r93 == 0 ) $m573r93="";
$m573r94=$hlavicka->m573r94; if ( $m573r94 == 0 ) $m573r94="";
$m573r95=$hlavicka->m573r95; if ( $m573r95 == 0 ) $m573r95="";
$m573r96=$hlavicka->m573r96; if ( $m573r96 == 0 ) $m573r96="";
$m573r97=$hlavicka->m573r97; if ( $m573r97 == 0 ) $m573r97="";
$m573r98=$hlavicka->m573r98; if ( $m573r98 == 0 ) $m573r98="";
$m573r105=$hlavicka->m573r105; if ( $m573r105 == 0 ) $m573r105="";
$m573r106=$hlavicka->m573r106; if ( $m573r106 == 0 ) $m573r106="";
$m573r107=$hlavicka->m573r107; if ( $m573r107 == 0 ) $m573r107="";
$m573r108=$hlavicka->m573r108; if ( $m573r108 == 0 ) $m573r108="";
$m573r111=$hlavicka->m573r111; if ( $m573r111 == 0 ) $m573r111="";
$m573r112=$hlavicka->m573r112; if ( $m573r112 == 0 ) $m573r112="";
$m573r113=$hlavicka->m573r113; if ( $m573r113 == 0 ) $m573r113="";
$m573r114=$hlavicka->m573r114; if ( $m573r114 == 0 ) $m573r114="";
$m573r115=$hlavicka->m573r115; if ( $m573r115 == 0 ) $m573r115="";
$m573r116=$hlavicka->m573r116; if ( $m573r116 == 0 ) $m573r116="";
$m573r117=$hlavicka->m573r117; if ( $m573r117 == 0 ) $m573r117="";
$m573r118=$hlavicka->m573r118; if ( $m573r118 == 0 ) $m573r118="";
$m573r121=$hlavicka->m573r121; if ( $m573r121 == 0 ) $m573r121="";
$m573r122=$hlavicka->m573r122; if ( $m573r122 == 0 ) $m573r122="";
$m573r123=$hlavicka->m573r123; if ( $m573r123 == 0 ) $m573r123="";
$m573r124=$hlavicka->m573r124; if ( $m573r124 == 0 ) $m573r124="";
$m573r125=$hlavicka->m573r125; if ( $m573r125 == 0 ) $m573r125="";
$m573r126=$hlavicka->m573r126; if ( $m573r126 == 0 ) $m573r126="";
$m573r127=$hlavicka->m573r127; if ( $m573r127 == 0 ) $m573r127="";
$m573r128=$hlavicka->m573r128; if ( $m573r128 == 0 ) $m573r128="";
$m573r131=$hlavicka->m573r131; if ( $m573r131 == 0 ) $m573r131="";
$m573r132=$hlavicka->m573r132; if ( $m573r132 == 0 ) $m573r132="";
$m573r133=$hlavicka->m573r133; if ( $m573r133 == 0 ) $m573r133="";
$m573r134=$hlavicka->m573r134; if ( $m573r134 == 0 ) $m573r134="";
$m573r135=$hlavicka->m573r135; if ( $m573r135 == 0 ) $m573r135="";
$m573r136=$hlavicka->m573r136; if ( $m573r136 == 0 ) $m573r136="";
$m573r137=$hlavicka->m573r137; if ( $m573r137 == 0 ) $m573r137="";
$m573r138=$hlavicka->m573r138; if ( $m573r138 == 0 ) $m573r138="";
$m573r141=$hlavicka->m573r141; if ( $m573r141 == 0 ) $m573r141="";
$m573r142=$hlavicka->m573r142; if ( $m573r142 == 0 ) $m573r142="";
$m573r143=$hlavicka->m573r143; if ( $m573r143 == 0 ) $m573r143="";
$m573r144=$hlavicka->m573r144; if ( $m573r144 == 0 ) $m573r144="";
$m573r145=$hlavicka->m573r145; if ( $m573r145 == 0 ) $m573r145="";
$m573r146=$hlavicka->m573r146; if ( $m573r146 == 0 ) $m573r146="";
$m573r147=$hlavicka->m573r147; if ( $m573r147 == 0 ) $m573r147="";
$m573r148=$hlavicka->m573r148; if ( $m573r148 == 0 ) $m573r148="";
$m573r151=$hlavicka->m573r151; if ( $m573r151 == 0 ) $m573r151="";
$m573r152=$hlavicka->m573r152; if ( $m573r152 == 0 ) $m573r152="";
$m573r153=$hlavicka->m573r153; if ( $m573r153 == 0 ) $m573r153="";
$m573r154=$hlavicka->m573r154; if ( $m573r154 == 0 ) $m573r154="";
$m573r155=$hlavicka->m573r155; if ( $m573r155 == 0 ) $m573r155="";
$m573r156=$hlavicka->m573r156; if ( $m573r156 == 0 ) $m573r156="";
$m573r157=$hlavicka->m573r157; if ( $m573r157 == 0 ) $m573r157="";
$m573r158=$hlavicka->m573r158; if ( $m573r158 == 0 ) $m573r158="";
$m573r161=$hlavicka->m573r161; if ( $m573r161 == 0 ) $m573r161="";
$m573r162=$hlavicka->m573r162; if ( $m573r162 == 0 ) $m573r162="";
$m573r163=$hlavicka->m573r163; if ( $m573r163 == 0 ) $m573r163="";
$m573r164=$hlavicka->m573r164; if ( $m573r164 == 0 ) $m573r164="";
$m573r165=$hlavicka->m573r165; if ( $m573r165 == 0 ) $m573r165="";
$m573r166=$hlavicka->m573r166; if ( $m573r166 == 0 ) $m573r166="";
$m573r167=$hlavicka->m573r167; if ( $m573r167 == 0 ) $m573r167="";
$m573r168=$hlavicka->m573r168; if ( $m573r168 == 0 ) $m573r168="";
$m573r175=$hlavicka->m573r175; if ( $m573r175 == 0 ) $m573r175="";
$m573r176=$hlavicka->m573r176; if ( $m573r176 == 0 ) $m573r176="";
$m573r177=$hlavicka->m573r177; if ( $m573r177 == 0 ) $m573r177="";
$m573r178=$hlavicka->m573r178; if ( $m573r178 == 0 ) $m573r178="";
$m573r185=$hlavicka->m573r185; if ( $m573r185 == 0 ) $m573r185="";
$m573r186=$hlavicka->m573r186; if ( $m573r186 == 0 ) $m573r186="";
$m573r187=$hlavicka->m573r187; if ( $m573r187 == 0 ) $m573r187="";
$m573r188=$hlavicka->m573r188; if ( $m573r188 == 0 ) $m573r188="";
$m573r195=$hlavicka->m573r195; if ( $m573r195 == 0 ) $m573r195="";
$m573r196=$hlavicka->m573r196; if ( $m573r196 == 0 ) $m573r196="";
$m573r197=$hlavicka->m573r197; if ( $m573r197 == 0 ) $m573r197="";
$m573r198=$hlavicka->m573r198; if ( $m573r198 == 0 ) $m573r198="";
$m573r205=$hlavicka->m573r205; if ( $m573r205 == 0 ) $m573r205="";
$m573r206=$hlavicka->m573r206; if ( $m573r206 == 0 ) $m573r206="";
$m573r207=$hlavicka->m573r207; if ( $m573r207 == 0 ) $m573r207="";
$m573r208=$hlavicka->m573r208; if ( $m573r208 == 0 ) $m573r208="";
$m573r215=$hlavicka->m573r215; if ( $m573r215 == 0 ) $m573r215="";
$m573r216=$hlavicka->m573r216; if ( $m573r216 == 0 ) $m573r216="";
$m573r217=$hlavicka->m573r217; if ( $m573r217 == 0 ) $m573r217="";
$m573r218=$hlavicka->m573r218; if ( $m573r218 == 0 ) $m573r218="";
$m573r221=$hlavicka->m573r221; if ( $m573r221 == 0 ) $m573r221="";
$m573r222=$hlavicka->m573r222; if ( $m573r222 == 0 ) $m573r222="";
$m573r223=$hlavicka->m573r223; if ( $m573r223 == 0 ) $m573r223="";
$m573r224=$hlavicka->m573r224; if ( $m573r224 == 0 ) $m573r224="";
$m573r225=$hlavicka->m573r225; if ( $m573r225 == 0 ) $m573r225="";
$m573r226=$hlavicka->m573r226; if ( $m573r226 == 0 ) $m573r226="";
$m573r227=$hlavicka->m573r227; if ( $m573r227 == 0 ) $m573r227="";
$m573r228=$hlavicka->m573r228; if ( $m573r228 == 0 ) $m573r228="";
$m573r231=$hlavicka->m573r231; if ( $m573r231 == 0 ) $m573r231="";
$m573r232=$hlavicka->m573r232; if ( $m573r232 == 0 ) $m573r232="";
$m573r233=$hlavicka->m573r233; if ( $m573r233 == 0 ) $m573r233="";
$m573r234=$hlavicka->m573r234; if ( $m573r234 == 0 ) $m573r234="";
$m573r235=$hlavicka->m573r235; if ( $m573r235 == 0 ) $m573r235="";
$m573r236=$hlavicka->m573r236; if ( $m573r236 == 0 ) $m573r236="";
$m573r237=$hlavicka->m573r237; if ( $m573r237 == 0 ) $m573r237="";
$m573r238=$hlavicka->m573r238; if ( $m573r238 == 0 ) $m573r238="";
$m573r245=$hlavicka->m573r245; if ( $m573r245 == 0 ) $m573r245="";
$m573r246=$hlavicka->m573r246; if ( $m573r246 == 0 ) $m573r246="";
$m573r247=$hlavicka->m573r247; if ( $m573r247 == 0 ) $m573r247="";
$m573r248=$hlavicka->m573r248; if ( $m573r248 == 0 ) $m573r248="";
$m573r991=$hlavicka->m573r991;
//if ( $m573r991 == 0 ) $m573r991="";
$m573r992=$hlavicka->m573r992;
//if ( $m573r992 == 0 ) $m573r992="";
$m573r993=$hlavicka->m573r993;
//if ( $m573r993 == 0 ) $m573r993="";
$m573r994=$hlavicka->m573r994;
//if ( $m573r994 == 0 ) $m573r994="";
$m573r995=$hlavicka->m573r995;
//if ( $m573r995 == 0 ) $m573r995="";
$m573r996=$hlavicka->m573r996;
//if ( $m573r996 == 0 ) $m573r996="";
$m573r997=$hlavicka->m573r997;
//if ( $m573r997 == 0 ) $m573r997="";
$m573r998=$hlavicka->m573r998;
//if ( $m573r998 == 0 ) $m573r998="";
$pdf->Cell(195,32," ","$rmc1",1,"L");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r11","$rmc",0,"R");$pdf->Cell(29,4,"$m573r12","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r13","$rmc",0,"R");$pdf->Cell(29,4,"$m573r14","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r15","$rmc",0,"R");$pdf->Cell(29,4,"$m573r16","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r17","$rmc",0,"R");$pdf->Cell(29,4,"$m573r18","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r21","$rmc",0,"R");$pdf->Cell(29,4,"$m573r22","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r23","$rmc",0,"R");$pdf->Cell(29,4,"$m573r24","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r25","$rmc",0,"R");$pdf->Cell(29,4,"$m573r26","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r27","$rmc",0,"R");$pdf->Cell(29,4,"$m573r28","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r35","$rmc",0,"R");$pdf->Cell(29,4,"$m573r36","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r37","$rmc",0,"R");$pdf->Cell(29,4,"$m573r38","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"","$rmc",0,"R");$pdf->Cell(29,5,"","$rmc",0,"R");
$pdf->Cell(29,5,"","$rmc",0,"R");$pdf->Cell(29,5,"","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r45","$rmc",0,"R");$pdf->Cell(29,5,"$m573r46","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r47","$rmc",0,"R");$pdf->Cell(29,5,"$m573r48","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r55","$rmc",0,"R");$pdf->Cell(29,4,"$m573r56","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r57","$rmc",0,"R");$pdf->Cell(29,4,"$m573r58","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r65","$rmc",0,"R");$pdf->Cell(29,4,"$m573r66","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r67","$rmc",0,"R");$pdf->Cell(29,4,"$m573r68","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,6,"","$rmc",0,"R");$pdf->Cell(29,6,"","$rmc",0,"R");
$pdf->Cell(29,6,"","$rmc",0,"R");$pdf->Cell(29,6,"","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r75","$rmc",0,"R");$pdf->Cell(29,6,"$m573r76","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r77","$rmc",0,"R");$pdf->Cell(29,6,"$m573r78","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r81","$rmc",0,"R");$pdf->Cell(29,4,"$m573r82","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r83","$rmc",0,"R");$pdf->Cell(29,4,"$m573r84","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r85","$rmc",0,"R");$pdf->Cell(29,4,"$m573r86","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r87","$rmc",0,"R");$pdf->Cell(29,4,"$m573r88","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,6,"$m573r91","$rmc",0,"R");$pdf->Cell(29,6,"$m573r92","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r93","$rmc",0,"R");$pdf->Cell(29,6,"$m573r94","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r95","$rmc",0,"R");$pdf->Cell(29,6,"$m573r96","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r97","$rmc",0,"R");$pdf->Cell(29,6,"$m573r98","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r105","$rmc",0,"R");$pdf->Cell(29,4,"$m573r106","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r107","$rmc",0,"R");$pdf->Cell(29,4,"$m573r108","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r111","$rmc",0,"R");$pdf->Cell(29,4,"$m573r112","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r113","$rmc",0,"R");$pdf->Cell(29,4,"$m573r114","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r115","$rmc",0,"R");$pdf->Cell(29,4,"$m573r116","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r117","$rmc",0,"R");$pdf->Cell(29,4,"$m573r118","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r121","$rmc",0,"R");$pdf->Cell(29,4,"$m573r122","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r123","$rmc",0,"R");$pdf->Cell(29,4,"$m573r124","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r125","$rmc",0,"R");$pdf->Cell(29,4,"$m573r126","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r127","$rmc",0,"R");$pdf->Cell(29,4,"$m573r128","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"$m573r131","$rmc",0,"R");$pdf->Cell(29,5,"$m573r132","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r133","$rmc",0,"R");$pdf->Cell(29,5,"$m573r134","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r135","$rmc",0,"R");$pdf->Cell(29,5,"$m573r136","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r137","$rmc",0,"R");$pdf->Cell(29,5,"$m573r138","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r141","$rmc",0,"R");$pdf->Cell(29,4,"$m573r142","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r143","$rmc",0,"R");$pdf->Cell(29,4,"$m573r144","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r145","$rmc",0,"R");$pdf->Cell(29,4,"$m573r146","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r147","$rmc",0,"R");$pdf->Cell(29,4,"$m573r148","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r151","$rmc",0,"R");$pdf->Cell(29,4,"$m573r152","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r153","$rmc",0,"R");$pdf->Cell(29,4,"$m573r154","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r155","$rmc",0,"R");$pdf->Cell(29,4,"$m573r156","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r157","$rmc",0,"R");$pdf->Cell(29,4,"$m573r158","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r161","$rmc",0,"R");$pdf->Cell(29,4,"$m573r162","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r163","$rmc",0,"R");$pdf->Cell(29,4,"$m573r164","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r165","$rmc",0,"R");$pdf->Cell(29,4,"$m573r166","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r167","$rmc",0,"R");$pdf->Cell(29,4,"$m573r168","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r175","$rmc",0,"R");$pdf->Cell(29,4,"$m573r176","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r177","$rmc",0,"R");$pdf->Cell(29,4,"$m573r178","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,5,"","$rmc",0,"R");$pdf->Cell(29,5,"","$rmc",0,"R");
$pdf->Cell(29,5,"","$rmc",0,"R");$pdf->Cell(29,5,"","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r185","$rmc",0,"R");$pdf->Cell(29,5,"$m573r186","$rmc",0,"R");
$pdf->Cell(29,5,"$m573r187","$rmc",0,"R");$pdf->Cell(29,5,"$m573r188","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r195","$rmc",0,"R");$pdf->Cell(29,4,"$m573r196","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r197","$rmc",0,"R");$pdf->Cell(29,4,"$m573r198","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r205","$rmc",0,"R");$pdf->Cell(29,4,"$m573r206","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r207","$rmc",0,"R");$pdf->Cell(29,4,"$m573r208","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,6,"","$rmc",0,"R");$pdf->Cell(29,6,"","$rmc",0,"R");
$pdf->Cell(29,6,"","$rmc",0,"R");$pdf->Cell(29,6,"","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r215","$rmc",0,"R");$pdf->Cell(29,6,"$m573r216","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r217","$rmc",0,"R");$pdf->Cell(29,6,"$m573r218","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r221","$rmc",0,"R");$pdf->Cell(29,4,"$m573r222","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r223","$rmc",0,"R");$pdf->Cell(29,4,"$m573r224","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r225","$rmc",0,"R");$pdf->Cell(29,4,"$m573r226","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r227","$rmc",0,"R");$pdf->Cell(29,4,"$m573r228","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,6,"$m573r231","$rmc",0,"R");$pdf->Cell(29,6,"$m573r232","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r233","$rmc",0,"R");$pdf->Cell(29,6,"$m573r234","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r235","$rmc",0,"R");$pdf->Cell(29,6,"$m573r236","$rmc",0,"R");
$pdf->Cell(29,6,"$m573r237","$rmc",0,"R");$pdf->Cell(29,6,"$m573r238","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"","$rmc",0,"R");$pdf->Cell(29,4,"","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r245","$rmc",0,"R");$pdf->Cell(29,4,"$m573r246","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r247","$rmc",0,"R");$pdf->Cell(29,4,"$m573r248","$rmc",1,"R");
$pdf->Cell(60,4," ","$rmc1",0,"L");
$pdf->Cell(29,4,"$m573r991","$rmc",0,"R");$pdf->Cell(29,4,"$m573r992","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r993","$rmc",0,"R");$pdf->Cell(29,4,"$m573r994","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r995","$rmc",0,"R");$pdf->Cell(29,4,"$m573r996","$rmc",0,"R");
$pdf->Cell(29,4,"$m573r997","$rmc",0,"R");$pdf->Cell(29,4,"$m573r998","$rmc",1,"R");
                                        }

if ( $strana == 11 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str11.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str11.jpg',0,0,210,297);
}

//modul 588
$m588r201=""; if ( $hlavicka->m588r201 == 1 ) { $m588r201="x"; }
$m588r202=""; if ( $hlavicka->m588r202 == 1 ) { $m588r202="x"; }
$m588r203=""; if ( $hlavicka->m588r203 == 1 ) { $m588r203="x"; }
$m588r204=""; if ( $hlavicka->m588r204 == 1 ) { $m588r204="x"; }
$m588r205=""; if ( $hlavicka->m588r205 == 1 ) { $m588r205="x"; }
$m588r206=""; if ( $hlavicka->m588r206 == 1 ) { $m588r206="x"; }
$m588r207=""; if ( $hlavicka->m588r207 == 1 ) { $m588r207="x"; }
$m588r208=""; if ( $hlavicka->m588r208 == 1 ) { $m588r208="x"; }
$m588r209=""; if ( $hlavicka->m588r209 == 1 ) { $m588r209="x"; }
$m588r210=""; if ( $hlavicka->m588r210 == 1 ) { $m588r210="x"; }
$m588r211=""; if ( $hlavicka->m588r211 == 1 ) { $m588r211="x"; }
$m588r212=""; if ( $hlavicka->m588r212 == 1 ) { $m588r212="x"; }
$m588r213=""; if ( $hlavicka->m588r213 == 1 ) { $m588r213="x"; }
$m588r214=""; if ( $hlavicka->m588r214 == 1 ) { $m588r214="x"; }
$m588r215=""; if ( $hlavicka->m588r215 == 1 ) { $m588r215="x"; }
$m588r216=""; if ( $hlavicka->m588r216 == 1 ) { $m588r216="x"; }
$m588r217=""; if ( $hlavicka->m588r217 == 1 ) { $m588r217="x"; }
$m588r218=""; if ( $hlavicka->m588r218 == 1 ) { $m588r218="x"; }
$m588r219=""; if ( $hlavicka->m588r219 == 1 ) { $m588r219="x"; }
$m588r220=""; if ( $hlavicka->m588r220 == 1 ) { $m588r220="x"; }
$m588r221=""; if ( $hlavicka->m588r221 == 1 ) { $m588r221="x"; }
$m588r222=""; if ( $hlavicka->m588r222 == 1 ) { $m588r222="x"; }
$m588r223=""; if ( $hlavicka->m588r223 == 1 ) { $m588r223="x"; }
$m588r224=""; if ( $hlavicka->m588r224 == 1 ) { $m588r224="x"; }
$m588r225=""; if ( $hlavicka->m588r225 == 1 ) { $m588r225="x"; }
$m588r226=""; if ( $hlavicka->m588r226 == 1 ) { $m588r226="x"; }
$m588r227=""; if ( $hlavicka->m588r227 == 1 ) { $m588r227="x"; }
$m588r228=""; if ( $hlavicka->m588r228 == 1 ) { $m588r228="x"; }
$m588r229=""; if ( $hlavicka->m588r229 == 1 ) { $m588r229="x"; }
$m588r230=""; if ( $hlavicka->m588r230 == 1 ) { $m588r230="x"; }
$m588r231=""; if ( $hlavicka->m588r231 == 1 ) { $m588r231="x"; }
$m588r232=""; if ( $hlavicka->m588r232 == 1 ) { $m588r232="x"; }
$m588r233=""; if ( $hlavicka->m588r233 == 1 ) { $m588r233="x"; }
$m588r234=""; if ( $hlavicka->m588r234 == 1 ) { $m588r234="x"; }
$m588r235=""; if ( $hlavicka->m588r235 == 1 ) { $m588r235="x"; }
$m588r236=""; if ( $hlavicka->m588r236 == 1 ) { $m588r236="x"; }
$m588r237=""; if ( $hlavicka->m588r237 == 1 ) { $m588r237="x"; }
$m588r238=""; if ( $hlavicka->m588r238 == 1 ) { $m588r238="x"; }
$m588r239=""; if ( $hlavicka->m588r239 == 1 ) { $m588r239="x"; }
$m588r301=""; if ( $hlavicka->m588r301 == 1 ) { $m588r301="x"; }
$m588r302=""; if ( $hlavicka->m588r302 == 1 ) { $m588r302="x"; }
$m588r303=""; if ( $hlavicka->m588r303 == 1 ) { $m588r303="x"; }
$m588r304=""; if ( $hlavicka->m588r304 == 1 ) { $m588r304="x"; }
$m588r305=""; if ( $hlavicka->m588r305 == 1 ) { $m588r305="x"; }
$m588r306=""; if ( $hlavicka->m588r306 == 1 ) { $m588r306="x"; }
$m588r307=""; if ( $hlavicka->m588r307 == 1 ) { $m588r307="x"; }
$m588r308=""; if ( $hlavicka->m588r308 == 1 ) { $m588r308="x"; }
$m588r309=""; if ( $hlavicka->m588r309 == 1 ) { $m588r309="x"; }
$m588r310=""; if ( $hlavicka->m588r310 == 1 ) { $m588r310="x"; }
$m588r311=""; if ( $hlavicka->m588r311 == 1 ) { $m588r311="x"; }
$m588r312=""; if ( $hlavicka->m588r312 == 1 ) { $m588r312="x"; }
$m588r313=""; if ( $hlavicka->m588r313 == 1 ) { $m588r313="x"; }
$m588r314=""; if ( $hlavicka->m588r314 == 1 ) { $m588r314="x"; }
$m588r315=""; if ( $hlavicka->m588r315 == 1 ) { $m588r315="x"; }
$m588r316=""; if ( $hlavicka->m588r316 == 1 ) { $m588r316="x"; }
$m588r317=""; if ( $hlavicka->m588r317 == 1 ) { $m588r317="x"; }
$m588r318=""; if ( $hlavicka->m588r318 == 1 ) { $m588r318="x"; }
$m588r319=""; if ( $hlavicka->m588r319 == 1 ) { $m588r319="x"; }
$m588r320=""; if ( $hlavicka->m588r320 == 1 ) { $m588r320="x"; }
$m588r321=""; if ( $hlavicka->m588r321 == 1 ) { $m588r321="x"; }
$m588r322=""; if ( $hlavicka->m588r322 == 1 ) { $m588r322="x"; }
$m588r323=""; if ( $hlavicka->m588r323 == 1 ) { $m588r323="x"; }
$m588r324=""; if ( $hlavicka->m588r324 == 1 ) { $m588r324="x"; }
$m588r325=""; if ( $hlavicka->m588r325 == 1 ) { $m588r325="x"; }
$m588r326=""; if ( $hlavicka->m588r326 == 1 ) { $m588r326="x"; }
$m588r327=""; if ( $hlavicka->m588r327 == 1 ) { $m588r327="x"; }
$m588r328=""; if ( $hlavicka->m588r328 == 1 ) { $m588r328="x"; }
$m588r329=""; if ( $hlavicka->m588r329 == 1 ) { $m588r329="x"; }
$m588r330=""; if ( $hlavicka->m588r330 == 1 ) { $m588r330="x"; }
$m588r331=""; if ( $hlavicka->m588r331 == 1 ) { $m588r331="x"; }
$m588r332=""; if ( $hlavicka->m588r332 == 1 ) { $m588r332="x"; }
$m588r333=""; if ( $hlavicka->m588r333 == 1 ) { $m588r333="x"; }
$m588r334=""; if ( $hlavicka->m588r334 == 1 ) { $m588r334="x"; }
$m588r335=""; if ( $hlavicka->m588r335 == 1 ) { $m588r335="x"; }
$m588r336=""; if ( $hlavicka->m588r336 == 1 ) { $m588r336="x"; }
$m588r337=""; if ( $hlavicka->m588r337 == 1 ) { $m588r337="x"; }
$m588r338=""; if ( $hlavicka->m588r338 == 1 ) { $m588r338="x"; }
$m588r339=""; if ( $hlavicka->m588r339 == 1 ) { $m588r339="x"; }
$pdf->Cell(190,33," ","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r201","$rmc",0,"C");$pdf->Cell(25,6,"$m588r301","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r202","$rmc",0,"C");$pdf->Cell(25,6,"$m588r302","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r203","$rmc",0,"C");$pdf->Cell(25,6,"$m588r303","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r204","$rmc",0,"C");$pdf->Cell(25,6,"$m588r304","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r205","$rmc",0,"C");$pdf->Cell(25,6,"$m588r305","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r206","$rmc",0,"C");$pdf->Cell(25,6,"$m588r306","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r207","$rmc",0,"C");$pdf->Cell(25,6,"$m588r307","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r208","$rmc",0,"C");$pdf->Cell(25,6,"$m588r308","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r209","$rmc",0,"C");$pdf->Cell(25,6,"$m588r309","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r210","$rmc",0,"C");$pdf->Cell(25,6,"$m588r310","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r211","$rmc",0,"C");$pdf->Cell(25,6,"$m588r311","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r212","$rmc",0,"C");$pdf->Cell(25,5,"$m588r312","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r213","$rmc",0,"C");$pdf->Cell(25,6,"$m588r313","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r214","$rmc",0,"C");$pdf->Cell(25,6,"$m588r314","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r215","$rmc",0,"C");$pdf->Cell(25,6,"$m588r315","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r216","$rmc",0,"C");$pdf->Cell(25,6,"$m588r316","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r217","$rmc",0,"C");$pdf->Cell(25,6,"$m588r317","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r218","$rmc",0,"C");$pdf->Cell(25,6,"$m588r318","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r219","$rmc",0,"C");$pdf->Cell(25,6,"$m588r319","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r220","$rmc",0,"C");$pdf->Cell(25,6,"$m588r320","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r221","$rmc",0,"C");$pdf->Cell(25,6,"$m588r321","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r222","$rmc",0,"C");$pdf->Cell(25,6,"$m588r322","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r223","$rmc",0,"C");$pdf->Cell(25,5,"$m588r323","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r224","$rmc",0,"C");$pdf->Cell(25,6,"$m588r324","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r225","$rmc",0,"C");$pdf->Cell(25,6,"$m588r325","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r226","$rmc",0,"C");$pdf->Cell(25,6,"$m588r326","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r227","$rmc",0,"C");$pdf->Cell(25,6,"$m588r327","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r228","$rmc",0,"C");$pdf->Cell(25,6,"$m588r328","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r229","$rmc",0,"C");$pdf->Cell(25,6,"$m588r329","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r230","$rmc",0,"C");$pdf->Cell(25,6,"$m588r330","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r231","$rmc",0,"C");$pdf->Cell(25,6,"$m588r331","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r232","$rmc",0,"C");$pdf->Cell(25,6,"$m588r332","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r233","$rmc",0,"C");$pdf->Cell(25,5,"$m588r333","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r234","$rmc",0,"C");$pdf->Cell(25,6,"$m588r334","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r235","$rmc",0,"C");$pdf->Cell(25,6,"$m588r335","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r236","$rmc",0,"C");$pdf->Cell(25,6,"$m588r336","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r237","$rmc",0,"C");$pdf->Cell(25,6,"$m588r337","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r238","$rmc",0,"C");$pdf->Cell(25,6,"$m588r338","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r239","$rmc",0,"C");$pdf->Cell(25,6,"$m588r339","$rmc",1,"C");
                                        }

if ( $strana == 12 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str12.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str12.jpg',0,0,210,297);
}

//modul 588 pokrac.
$m588r240=""; if ( $hlavicka->m588r240 == 1 ) { $m588r240="x"; }
$m588r241=""; if ( $hlavicka->m588r241 == 1 ) { $m588r241="x"; }
$m588r242=""; if ( $hlavicka->m588r242 == 1 ) { $m588r242="x"; }
$m588r243=""; if ( $hlavicka->m588r243 == 1 ) { $m588r243="x"; }
$m588r244=""; if ( $hlavicka->m588r244 == 1 ) { $m588r244="x"; }
$m588r245=""; if ( $hlavicka->m588r245 == 1 ) { $m588r245="x"; }
$m588r246=""; if ( $hlavicka->m588r246 == 1 ) { $m588r246="x"; }
$m588r247=""; if ( $hlavicka->m588r247 == 1 ) { $m588r247="x"; }
$m588r248=""; if ( $hlavicka->m588r248 == 1 ) { $m588r248="x"; }
$m588r249=""; if ( $hlavicka->m588r249 == 1 ) { $m588r249="x"; }
$m588r250=""; if ( $hlavicka->m588r250 == 1 ) { $m588r250="x"; }
$m588r251=""; if ( $hlavicka->m588r251 == 1 ) { $m588r251="x"; }
$m588r340=""; if ( $hlavicka->m588r340 == 1 ) { $m588r340="x"; }
$m588r341=""; if ( $hlavicka->m588r341 == 1 ) { $m588r341="x"; }
$m588r342=""; if ( $hlavicka->m588r342 == 1 ) { $m588r342="x"; }
$m588r343=""; if ( $hlavicka->m588r343 == 1 ) { $m588r343="x"; }
$m588r344=""; if ( $hlavicka->m588r344 == 1 ) { $m588r344="x"; }
$m588r345=""; if ( $hlavicka->m588r345 == 1 ) { $m588r345="x"; }
$m588r346=""; if ( $hlavicka->m588r346 == 1 ) { $m588r346="x"; }
$m588r347=""; if ( $hlavicka->m588r347 == 1 ) { $m588r347="x"; }
$m588r348=""; if ( $hlavicka->m588r348 == 1 ) { $m588r348="x"; }
$m588r349=""; if ( $hlavicka->m588r349 == 1 ) { $m588r349="x"; }
$m588r350=""; if ( $hlavicka->m588r350 == 1 ) { $m588r350="x"; }
$m588r351=""; if ( $hlavicka->m588r351 == 1 ) { $m588r351="x"; }
$pdf->Cell(190,17," ","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r240","$rmc",0,"C");$pdf->Cell(25,6,"$m588r340","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,8,"$m588r241","$rmc",0,"C");$pdf->Cell(25,8,"$m588r341","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r242","$rmc",0,"C");$pdf->Cell(25,6,"$m588r342","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r243","$rmc",0,"C");$pdf->Cell(25,6,"$m588r343","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r244","$rmc",0,"C");$pdf->Cell(25,6,"$m588r344","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r245","$rmc",0,"C");$pdf->Cell(25,6,"$m588r345","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r246","$rmc",0,"C");$pdf->Cell(25,6,"$m588r346","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,8,"$m588r247","$rmc",0,"C");$pdf->Cell(25,8,"$m588r347","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r248","$rmc",0,"C");$pdf->Cell(25,6,"$m588r348","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r249","$rmc",0,"C");$pdf->Cell(25,6,"$m588r349","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r250","$rmc",0,"C");$pdf->Cell(25,6,"$m588r350","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r251","$rmc",0,"C");$pdf->Cell(25,6,"$m588r351","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");

//modul 19
$m19r1=$hlavicka->m19r1; if ( $m19r1 == 0 ) $m19r1="";
$m19r2=$hlavicka->m19r2; if ( $m19r2 == 0 ) $m19r2="";
$m19r3=$hlavicka->m19r3; if ( $m19r3 == 0 ) $m19r3="";
$m19r4=$hlavicka->m19r4; if ( $m19r4 == 0 ) $m19r4="";
$m19r5=$hlavicka->m19r5; if ( $m19r5 == 0 ) $m19r5="";
$m19r6=$hlavicka->m19r6; if ( $m19r6 == 0 ) $m19r6="";
$m19r7=$hlavicka->m19r7; if ( $m19r7 == 0 ) $m19r7="";
$m19r8=$hlavicka->m19r8; if ( $m19r8 == 0 ) $m19r8="";
$m19r9=$hlavicka->m19r9; if ( $m19r9 == 0 ) $m19r9="";
$m19r10=$hlavicka->m19r10; if ( $m19r10 == 0 ) $m19r10="";
$m19r11=$hlavicka->m19r11; if ( $m19r11 == 0 ) $m19r11="";
$m19r12=$hlavicka->m19r12; if ( $m19r12 == 0 ) $m19r12="";
$m19r99=$hlavicka->m19r99;
//if ( $m19r99 == 0 ) $m19r99="";
$pdf->Cell(195,39," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,9,"$m19r1","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,8,"$m19r2","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r3","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r4","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r5","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r6","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r7","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r8","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,8,"$m19r9","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r10","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r11","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,8,"$m19r12","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m19r99","$rmc",1,"R");

//modul 100103
$m1527r1a=" ";
$m1527r1b=" ";
if ( $hlavicka->m1527r1a == 1 ) { $m1527r1a="x"; }
if ( $hlavicka->m1527r1b == 1 ) { $m1527r1b="x"; }
$pdf->Cell(190,26," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m1527r1a","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m1527r1b","$rmc",1,"C");
                                        }

if ( $strana == 13 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str13.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str13.jpg',5,0,305,210);
}

//modul 527
$m527r11=$hlavicka->m527r11; if ( $m527r11 == 0 ) $m527r11="";
$m527r12=$hlavicka->m527r12; if ( $m527r12 == 0 ) $m527r12="";
$m527r13=$hlavicka->m527r13; if ( $m527r13 == 0 ) $m527r13="";
$m527r14=$hlavicka->m527r14; if ( $m527r14 == 0 ) $m527r14="";
$m527r15=$hlavicka->m527r15; if ( $m527r15 == 0 ) $m527r15="";
$m527r16=$hlavicka->m527r16; if ( $m527r16 == 0 ) $m527r16="";
$m527r17=$hlavicka->m527r17; if ( $m527r17 == 0 ) $m527r17="";
$m527r18=$hlavicka->m527r18; if ( $m527r18 == 0 ) $m527r18="";
$m527r19=$hlavicka->m527r19; if ( $m527r19 == 0 ) $m527r19="";
$m527r110=$hlavicka->m527r110; if ( $m527r110 == 0 ) $m527r110="";
$m527r21=$hlavicka->m527r21; if ( $m527r21 == 0 ) $m527r21="";
$m527r22=$hlavicka->m527r22; if ( $m527r22 == 0 ) $m527r22="";
$m527r23=$hlavicka->m527r23; if ( $m527r23 == 0 ) $m527r23="";
$m527r24=$hlavicka->m527r24; if ( $m527r24 == 0 ) $m527r24="";
$m527r25=$hlavicka->m527r25; if ( $m527r25 == 0 ) $m527r25="";
$m527r26=$hlavicka->m527r26; if ( $m527r26 == 0 ) $m527r26="";
$m527r27=$hlavicka->m527r27; if ( $m527r27 == 0 ) $m527r27="";
$m527r28=$hlavicka->m527r28; if ( $m527r28 == 0 ) $m527r28="";
$m527r29=$hlavicka->m527r29; if ( $m527r29 == 0 ) $m527r29="";
$m527r210=$hlavicka->m527r210; if ( $m527r210 == 0 ) $m527r210="";
$m527r31=$hlavicka->m527r31; if ( $m527r31 == 0 ) $m527r31="";
$m527r32=$hlavicka->m527r32; if ( $m527r32 == 0 ) $m527r32="";
$m527r33=$hlavicka->m527r33; if ( $m527r33 == 0 ) $m527r33="";
$m527r34=$hlavicka->m527r34; if ( $m527r34 == 0 ) $m527r34="";
$m527r35=$hlavicka->m527r35; if ( $m527r35 == 0 ) $m527r35="";
$m527r36=$hlavicka->m527r36; if ( $m527r36 == 0 ) $m527r36="";
$m527r37=$hlavicka->m527r37; if ( $m527r37 == 0 ) $m527r37="";
$m527r38=$hlavicka->m527r38; if ( $m527r38 == 0 ) $m527r38="";
$m527r39=$hlavicka->m527r39; if ( $m527r39 == 0 ) $m527r39="";
$m527r310=$hlavicka->m527r310; if ( $m527r310 == 0 ) $m527r310="";
$m527r41=$hlavicka->m527r41; if ( $m527r41 == 0 ) $m527r41="";
$m527r42=$hlavicka->m527r42; if ( $m527r42 == 0 ) $m527r42="";
$m527r43=$hlavicka->m527r43; if ( $m527r43 == 0 ) $m527r43="";
$m527r44=$hlavicka->m527r44; if ( $m527r44 == 0 ) $m527r44="";
$m527r45=$hlavicka->m527r45; if ( $m527r45 == 0 ) $m527r45="";
$m527r46=$hlavicka->m527r46; if ( $m527r46 == 0 ) $m527r46="";
$m527r47=$hlavicka->m527r47; if ( $m527r47 == 0 ) $m527r47="";
$m527r48=$hlavicka->m527r48; if ( $m527r48 == 0 ) $m527r48="";
$m527r49=$hlavicka->m527r49; if ( $m527r49 == 0 ) $m527r49="";
$m527r410=$hlavicka->m527r410; if ( $m527r410 == 0 ) $m527r410="";
$m527r51=$hlavicka->m527r51; if ( $m527r51 == 0 ) $m527r51="";
$m527r52=$hlavicka->m527r52; if ( $m527r52 == 0 ) $m527r52="";
$m527r53=$hlavicka->m527r53; if ( $m527r53 == 0 ) $m527r53="";
$m527r54=$hlavicka->m527r54; if ( $m527r54 == 0 ) $m527r54="";
$m527r55=$hlavicka->m527r55; if ( $m527r55 == 0 ) $m527r55="";
$m527r56=$hlavicka->m527r56; if ( $m527r56 == 0 ) $m527r56="";
$m527r57=$hlavicka->m527r57; if ( $m527r57 == 0 ) $m527r57="";
$m527r58=$hlavicka->m527r58; if ( $m527r58 == 0 ) $m527r58="";
$m527r59=$hlavicka->m527r59; if ( $m527r59 == 0 ) $m527r59="";
$m527r510=$hlavicka->m527r510; if ( $m527r510 == 0 ) $m527r510="";
$m527r61=$hlavicka->m527r61; if ( $m527r61 == 0 ) $m527r61="";
$m527r62=$hlavicka->m527r62; if ( $m527r62 == 0 ) $m527r62="";
$m527r63=$hlavicka->m527r63; if ( $m527r63 == 0 ) $m527r63="";
$m527r64=$hlavicka->m527r64; if ( $m527r64 == 0 ) $m527r64="";
$m527r65=$hlavicka->m527r65; if ( $m527r65 == 0 ) $m527r65="";
$m527r66=$hlavicka->m527r66; if ( $m527r66 == 0 ) $m527r66="";
$m527r67=$hlavicka->m527r67; if ( $m527r67 == 0 ) $m527r67="";
$m527r68=$hlavicka->m527r68; if ( $m527r68 == 0 ) $m527r68="";
$m527r69=$hlavicka->m527r69; if ( $m527r69 == 0 ) $m527r69="";
$m527r610=$hlavicka->m527r610; if ( $m527r610 == 0 ) $m527r610="";
$m527r71=$hlavicka->m527r71; if ( $m527r71 == 0 ) $m527r71="";
$m527r72=$hlavicka->m527r72; if ( $m527r72 == 0 ) $m527r72="";
$m527r73=$hlavicka->m527r73; if ( $m527r73 == 0 ) $m527r73="";
$m527r74=$hlavicka->m527r74; if ( $m527r74 == 0 ) $m527r74="";
$m527r75=$hlavicka->m527r75; if ( $m527r75 == 0 ) $m527r75="";
$m527r76=$hlavicka->m527r76; if ( $m527r76 == 0 ) $m527r76="";
$m527r77=$hlavicka->m527r77; if ( $m527r77 == 0 ) $m527r77="";
$m527r78=$hlavicka->m527r78; if ( $m527r78 == 0 ) $m527r78="";
$m527r79=$hlavicka->m527r79; if ( $m527r79 == 0 ) $m527r79="";
$m527r710=$hlavicka->m527r710; if ( $m527r710 == 0 ) $m527r710="";
$m527r81=$hlavicka->m527r81; if ( $m527r81 == 0 ) $m527r81="";
$m527r82=$hlavicka->m527r82; if ( $m527r82 == 0 ) $m527r82="";
$m527r83=$hlavicka->m527r83; if ( $m527r83 == 0 ) $m527r83="";
$m527r84=$hlavicka->m527r84; if ( $m527r84 == 0 ) $m527r84="";
$m527r85=$hlavicka->m527r85; if ( $m527r85 == 0 ) $m527r85="";
$m527r86=$hlavicka->m527r86; if ( $m527r86 == 0 ) $m527r86="";
$m527r87=$hlavicka->m527r87; if ( $m527r87 == 0 ) $m527r87="";
$m527r88=$hlavicka->m527r88; if ( $m527r88 == 0 ) $m527r88="";
$m527r89=$hlavicka->m527r89; if ( $m527r89 == 0 ) $m527r89="";
$m527r810=$hlavicka->m527r810; if ( $m527r810 == 0 ) $m527r810="";
$m527r91=$hlavicka->m527r91; if ( $m527r91 == 0 ) $m527r91="";
$m527r92=$hlavicka->m527r92; if ( $m527r92 == 0 ) $m527r92="";
$m527r93=$hlavicka->m527r93; if ( $m527r93 == 0 ) $m527r93="";
$m527r94=$hlavicka->m527r94; if ( $m527r94 == 0 ) $m527r94="";
$m527r95=$hlavicka->m527r95; if ( $m527r95 == 0 ) $m527r95="";
$m527r96=$hlavicka->m527r96; if ( $m527r96 == 0 ) $m527r96="";
$m527r97=$hlavicka->m527r97; if ( $m527r97 == 0 ) $m527r97="";
$m527r98=$hlavicka->m527r98; if ( $m527r98 == 0 ) $m527r98="";
$m527r99=$hlavicka->m527r99; if ( $m527r99 == 0 ) $m527r99="";
$m527r910=$hlavicka->m527r910; if ( $m527r910 == 0 ) $m527r910="";
$m527r101=$hlavicka->m527r101; if ( $m527r101 == 0 ) $m527r101="";
$m527r102=$hlavicka->m527r102; if ( $m527r102 == 0 ) $m527r102="";
$m527r103=$hlavicka->m527r103; if ( $m527r103 == 0 ) $m527r103="";
$m527r104=$hlavicka->m527r104; if ( $m527r104 == 0 ) $m527r104="";
$m527r105=$hlavicka->m527r105; if ( $m527r105 == 0 ) $m527r105="";
$m527r106=$hlavicka->m527r106; if ( $m527r106 == 0 ) $m527r106="";
$m527r107=$hlavicka->m527r107; if ( $m527r107 == 0 ) $m527r107="";
$m527r108=$hlavicka->m527r108; if ( $m527r108 == 0 ) $m527r108="";
$m527r109=$hlavicka->m527r109; if ( $m527r109 == 0 ) $m527r109="";
$m527r1010=$hlavicka->m527r1010; if ( $m527r1010 == 0 ) $m527r1010="";
$m527r111=$hlavicka->m527r111; if ( $m527r111 == 0 ) $m527r111="";
$m527r112=$hlavicka->m527r112; if ( $m527r112 == 0 ) $m527r112="";
$m527r113=$hlavicka->m527r113; if ( $m527r113 == 0 ) $m527r113="";
$m527r114=$hlavicka->m527r114; if ( $m527r114 == 0 ) $m527r114="";
$m527r115=$hlavicka->m527r115; if ( $m527r115 == 0 ) $m527r115="";
$m527r116=$hlavicka->m527r116; if ( $m527r116 == 0 ) $m527r116="";
$m527r117=$hlavicka->m527r117; if ( $m527r117 == 0 ) $m527r117="";
$m527r118=$hlavicka->m527r118; if ( $m527r118 == 0 ) $m527r118="";
$m527r119=$hlavicka->m527r119; if ( $m527r119 == 0 ) $m527r119="";
$m527r1110=$hlavicka->m527r1110; if ( $m527r1110 == 0 ) $m527r1110="";
$m527r121=$hlavicka->m527r121; if ( $m527r121 == 0 ) $m527r121="";
$m527r122=$hlavicka->m527r122; if ( $m527r122 == 0 ) $m527r122="";
$m527r123=$hlavicka->m527r123; if ( $m527r123 == 0 ) $m527r123="";
$m527r124=$hlavicka->m527r124; if ( $m527r124 == 0 ) $m527r124="";
$m527r125=$hlavicka->m527r125; if ( $m527r125 == 0 ) $m527r125="";
$m527r126=$hlavicka->m527r126; if ( $m527r126 == 0 ) $m527r126="";
$m527r127=$hlavicka->m527r127; if ( $m527r127 == 0 ) $m527r127="";
$m527r128=$hlavicka->m527r128; if ( $m527r128 == 0 ) $m527r128="";
$m527r129=$hlavicka->m527r129; if ( $m527r129 == 0 ) $m527r129="";
$m527r1210=$hlavicka->m527r1210; if ( $m527r1210 == 0 ) $m527r1210="";
$m527r131=$hlavicka->m527r131; if ( $m527r131 == 0 ) $m527r131="";
$m527r132=$hlavicka->m527r132; if ( $m527r132 == 0 ) $m527r132="";
$m527r133=$hlavicka->m527r133; if ( $m527r133 == 0 ) $m527r133="";
$m527r134=$hlavicka->m527r134; if ( $m527r134 == 0 ) $m527r134="";
$m527r135=$hlavicka->m527r135; if ( $m527r135 == 0 ) $m527r135="";
$m527r136=$hlavicka->m527r136; if ( $m527r136 == 0 ) $m527r136="";
$m527r137=$hlavicka->m527r137; if ( $m527r137 == 0 ) $m527r137="";
$m527r138=$hlavicka->m527r138; if ( $m527r138 == 0 ) $m527r138="";
$m527r139=$hlavicka->m527r139; if ( $m527r139 == 0 ) $m527r139="";
$m527r1310=$hlavicka->m527r1310; if ( $m527r1310 == 0 ) $m527r1310="";
$m527r141=$hlavicka->m527r141; if ( $m527r141 == 0 ) $m527r141="";
$m527r142=$hlavicka->m527r142; if ( $m527r142 == 0 ) $m527r142="";
$m527r143=$hlavicka->m527r143; if ( $m527r143 == 0 ) $m527r143="";
$m527r144=$hlavicka->m527r144; if ( $m527r144 == 0 ) $m527r144="";
$m527r145=$hlavicka->m527r145; if ( $m527r145 == 0 ) $m527r145="";
$m527r146=$hlavicka->m527r146; if ( $m527r146 == 0 ) $m527r146="";
$m527r147=$hlavicka->m527r147; if ( $m527r147 == 0 ) $m527r147="";
$m527r148=$hlavicka->m527r148; if ( $m527r148 == 0 ) $m527r148="";
$m527r149=$hlavicka->m527r149; if ( $m527r149 == 0 ) $m527r149="";
$m527r1410=$hlavicka->m527r1410; if ( $m527r1410 == 0 ) $m527r1410="";
$m527r151=$hlavicka->m527r151; if ( $m527r151 == 0 ) $m527r151="";
$m527r152=$hlavicka->m527r152; if ( $m527r152 == 0 ) $m527r152="";
$m527r153=$hlavicka->m527r153; if ( $m527r153 == 0 ) $m527r153="";
$m527r154=$hlavicka->m527r154; if ( $m527r154 == 0 ) $m527r154="";
$m527r155=$hlavicka->m527r155; if ( $m527r155 == 0 ) $m527r155="";
$m527r156=$hlavicka->m527r156; if ( $m527r156 == 0 ) $m527r156="";
$m527r157=$hlavicka->m527r157; if ( $m527r157 == 0 ) $m527r157="";
$m527r158=$hlavicka->m527r158; if ( $m527r158 == 0 ) $m527r158="";
$m527r159=$hlavicka->m527r159; if ( $m527r159 == 0 ) $m527r159="";
$m527r1510=$hlavicka->m527r1510; if ( $m527r1510 == 0 ) $m527r1510="";
$m527r161=$hlavicka->m527r161; if ( $m527r161 == 0 ) $m527r161="";
$m527r162=$hlavicka->m527r162; if ( $m527r162 == 0 ) $m527r162="";
$m527r163=$hlavicka->m527r163; if ( $m527r163 == 0 ) $m527r163="";
$m527r164=$hlavicka->m527r164; if ( $m527r164 == 0 ) $m527r164="";
$m527r165=$hlavicka->m527r165; if ( $m527r165 == 0 ) $m527r165="";
$m527r166=$hlavicka->m527r166; if ( $m527r166 == 0 ) $m527r166="";
$m527r167=$hlavicka->m527r167; if ( $m527r167 == 0 ) $m527r167="";
$m527r168=$hlavicka->m527r168; if ( $m527r168 == 0 ) $m527r168="";
$m527r169=$hlavicka->m527r169; if ( $m527r169 == 0 ) $m527r169="";
$m527r1610=$hlavicka->m527r1610; if ( $m527r1610 == 0 ) $m527r1610="";
$m527r171=$hlavicka->m527r171; if ( $m527r171 == 0 ) $m527r171="";
$m527r172=$hlavicka->m527r172; if ( $m527r172 == 0 ) $m527r172="";
$m527r173=$hlavicka->m527r173; if ( $m527r173 == 0 ) $m527r173="";
$m527r174=$hlavicka->m527r174; if ( $m527r174 == 0 ) $m527r174="";
$m527r175=$hlavicka->m527r175; if ( $m527r175 == 0 ) $m527r175="";
$m527r176=$hlavicka->m527r176; if ( $m527r176 == 0 ) $m527r176="";
$m527r177=$hlavicka->m527r177; if ( $m527r177 == 0 ) $m527r177="";
$m527r178=$hlavicka->m527r178; if ( $m527r178 == 0 ) $m527r178="";
$m527r179=$hlavicka->m527r179; if ( $m527r179 == 0 ) $m527r179="";
$m527r1710=$hlavicka->m527r1710; if ( $m527r1710 == 0 ) $m527r1710="";
$pdf->Cell(195,45," ","$rmc1",1,"L");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,8,"$m527r11","$rmc",0,"R");$pdf->Cell(25,8,"$m527r12","$rmc",0,"R");
$pdf->Cell(18,8,"$m527r13","$rmc",0,"R");$pdf->Cell(21,8,"$m527r14","$rmc",0,"R");
$pdf->Cell(26,8,"$m527r15","$rmc",0,"R");$pdf->Cell(20,8,"$m527r16","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r17","$rmc",0,"R");$pdf->Cell(20,8,"$m527r18","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r19","$rmc",0,"R");$pdf->Cell(21,8,"$m527r110","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r21","$rmc",0,"R");$pdf->Cell(25,6,"$m527r22","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r23","$rmc",0,"R");$pdf->Cell(21,6,"$m527r24","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r25","$rmc",0,"R");$pdf->Cell(20,6,"$m527r26","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r27","$rmc",0,"R");$pdf->Cell(20,6,"$m527r28","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r29","$rmc",0,"R");$pdf->Cell(21,6,"$m527r210","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r31","$rmc",0,"R");$pdf->Cell(25,6,"$m527r32","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r33","$rmc",0,"R");$pdf->Cell(21,6,"$m527r34","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r35","$rmc",0,"R");$pdf->Cell(20,6,"$m527r36","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r37","$rmc",0,"R");$pdf->Cell(20,6,"$m527r38","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r39","$rmc",0,"R");$pdf->Cell(21,6,"$m527r310","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,9,"$m527r41","$rmc",0,"R");$pdf->Cell(25,9,"$m527r42","$rmc",0,"R");
$pdf->Cell(18,9,"$m527r43","$rmc",0,"R");$pdf->Cell(21,9,"$m527r44","$rmc",0,"R");
$pdf->Cell(26,9,"$m527r45","$rmc",0,"R");$pdf->Cell(20,9,"$m527r46","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r47","$rmc",0,"R");$pdf->Cell(20,9,"$m527r48","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r49","$rmc",0,"R");$pdf->Cell(21,9,"$m527r410","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,8,"$m527r51","$rmc",0,"R");$pdf->Cell(25,8,"$m527r52","$rmc",0,"R");
$pdf->Cell(18,8,"$m527r53","$rmc",0,"R");$pdf->Cell(21,8,"$m527r54","$rmc",0,"R");
$pdf->Cell(26,8,"$m527r55","$rmc",0,"R");$pdf->Cell(20,8,"$m527r56","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r57","$rmc",0,"R");$pdf->Cell(20,8,"$m527r58","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r59","$rmc",0,"R");$pdf->Cell(21,8,"$m527r510","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r61","$rmc",0,"R");$pdf->Cell(25,6,"$m527r62","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r63","$rmc",0,"R");$pdf->Cell(21,6,"$m527r64","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r65","$rmc",0,"R");$pdf->Cell(20,6,"$m527r66","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r67","$rmc",0,"R");$pdf->Cell(20,6,"$m527r68","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r69","$rmc",0,"R");$pdf->Cell(21,6,"$m527r610","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,12,"$m527r71","$rmc",0,"R");$pdf->Cell(25,12,"$m527r72","$rmc",0,"R");
$pdf->Cell(18,12,"$m527r73","$rmc",0,"R");$pdf->Cell(21,12,"$m527r74","$rmc",0,"R");
$pdf->Cell(26,12,"$m527r75","$rmc",0,"R");$pdf->Cell(20,12,"$m527r76","$rmc",0,"R");
$pdf->Cell(21,12,"$m527r77","$rmc",0,"R");$pdf->Cell(20,12,"$m527r78","$rmc",0,"R");
$pdf->Cell(21,12,"$m527r79","$rmc",0,"R");$pdf->Cell(21,12,"$m527r710","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,9,"$m527r81","$rmc",0,"R");$pdf->Cell(25,9,"$m527r82","$rmc",0,"R");
$pdf->Cell(18,9,"$m527r83","$rmc",0,"R");$pdf->Cell(21,9,"$m527r84","$rmc",0,"R");
$pdf->Cell(26,9,"$m527r85","$rmc",0,"R");$pdf->Cell(20,9,"$m527r86","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r87","$rmc",0,"R");$pdf->Cell(20,9,"$m527r88","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r89","$rmc",0,"R");$pdf->Cell(21,9,"$m527r810","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,8,"$m527r91","$rmc",0,"R");$pdf->Cell(25,8,"$m527r92","$rmc",0,"R");
$pdf->Cell(18,8,"$m527r93","$rmc",0,"R");$pdf->Cell(21,8,"$m527r94","$rmc",0,"R");
$pdf->Cell(26,8,"$m527r95","$rmc",0,"R");$pdf->Cell(20,8,"$m527r96","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r97","$rmc",0,"R");$pdf->Cell(20,8,"$m527r98","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r99","$rmc",0,"R");$pdf->Cell(21,8,"$m527r910","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,9,"$m527r101","$rmc",0,"R");$pdf->Cell(25,9,"$m527r102","$rmc",0,"R");
$pdf->Cell(18,9,"$m527r103","$rmc",0,"R");$pdf->Cell(21,9,"$m527r104","$rmc",0,"R");
$pdf->Cell(26,9,"$m527r105","$rmc",0,"R");$pdf->Cell(20,9,"$m527r106","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r107","$rmc",0,"R");$pdf->Cell(20,9,"$m527r108","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r109","$rmc",0,"R");$pdf->Cell(21,9,"$m527r1010","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,5,"$m527r111","$rmc",0,"R");$pdf->Cell(25,5,"$m527r112","$rmc",0,"R");
$pdf->Cell(18,5,"$m527r113","$rmc",0,"R");$pdf->Cell(21,5,"$m527r114","$rmc",0,"R");
$pdf->Cell(26,5,"$m527r115","$rmc",0,"R");$pdf->Cell(20,5,"$m527r116","$rmc",0,"R");
$pdf->Cell(21,5,"$m527r117","$rmc",0,"R");$pdf->Cell(20,5,"$m527r118","$rmc",0,"R");
$pdf->Cell(21,5,"$m527r119","$rmc",0,"R");$pdf->Cell(21,5,"$m527r1110","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r121","$rmc",0,"R");$pdf->Cell(25,6,"$m527r122","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r123","$rmc",0,"R");$pdf->Cell(21,6,"$m527r124","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r125","$rmc",0,"R");$pdf->Cell(20,6,"$m527r126","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r127","$rmc",0,"R");$pdf->Cell(20,6,"$m527r128","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r129","$rmc",0,"R");$pdf->Cell(21,6,"$m527r1210","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r131","$rmc",0,"R");$pdf->Cell(25,6,"$m527r132","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r133","$rmc",0,"R");$pdf->Cell(21,6,"$m527r134","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r135","$rmc",0,"R");$pdf->Cell(20,6,"$m527r136","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r137","$rmc",0,"R");$pdf->Cell(20,6,"$m527r138","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r139","$rmc",0,"R");$pdf->Cell(21,6,"$m527r1310","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r141","$rmc",0,"R");$pdf->Cell(25,6,"$m527r142","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r143","$rmc",0,"R");$pdf->Cell(21,6,"$m527r144","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r145","$rmc",0,"R");$pdf->Cell(20,6,"$m527r146","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r147","$rmc",0,"R");$pdf->Cell(20,6,"$m527r148","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r149","$rmc",0,"R");$pdf->Cell(21,6,"$m527r1410","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,8,"$m527r151","$rmc",0,"R");$pdf->Cell(25,8,"$m527r152","$rmc",0,"R");
$pdf->Cell(18,8,"$m527r153","$rmc",0,"R");$pdf->Cell(21,8,"$m527r154","$rmc",0,"R");
$pdf->Cell(26,8,"$m527r155","$rmc",0,"R");$pdf->Cell(20,8,"$m527r156","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r157","$rmc",0,"R");$pdf->Cell(20,8,"$m527r158","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r159","$rmc",0,"R");$pdf->Cell(21,8,"$m527r1510","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,9,"$m527r161","$rmc",0,"R");$pdf->Cell(25,9,"$m527r162","$rmc",0,"R");
$pdf->Cell(18,9,"$m527r163","$rmc",0,"R");$pdf->Cell(21,9,"$m527r164","$rmc",0,"R");
$pdf->Cell(26,9,"$m527r165","$rmc",0,"R");$pdf->Cell(20,9,"$m527r166","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r167","$rmc",0,"R");$pdf->Cell(20,9,"$m527r168","$rmc",0,"R");
$pdf->Cell(21,9,"$m527r169","$rmc",0,"R");$pdf->Cell(21,9,"$m527r1610","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,8,"$m527r171","$rmc",0,"R");$pdf->Cell(25,8,"$m527r172","$rmc",0,"R");
$pdf->Cell(18,8,"$m527r173","$rmc",0,"R");$pdf->Cell(21,8,"$m527r174","$rmc",0,"R");
$pdf->Cell(26,8,"$m527r175","$rmc",0,"R");$pdf->Cell(20,8,"$m527r176","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r177","$rmc",0,"R");$pdf->Cell(20,8,"$m527r178","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r179","$rmc",0,"R");$pdf->Cell(21,8,"$m527r1710","$rmc",1,"R");
                                        }

if ( $strana == 14 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str14.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str14.jpg',5,0,305,210);
}

//modul 527 pokrac.
$m527r181=$hlavicka->m527r181; if ( $m527r181 == 0 ) $m527r181="";
$m527r182=$hlavicka->m527r182; if ( $m527r182 == 0 ) $m527r182="";
$m527r183=$hlavicka->m527r183; if ( $m527r183 == 0 ) $m527r183="";
$m527r184=$hlavicka->m527r184; if ( $m527r184 == 0 ) $m527r184="";
$m527r185=$hlavicka->m527r185; if ( $m527r185 == 0 ) $m527r185="";
$m527r186=$hlavicka->m527r186; if ( $m527r186 == 0 ) $m527r186="";
$m527r187=$hlavicka->m527r187; if ( $m527r187 == 0 ) $m527r187="";
$m527r188=$hlavicka->m527r188; if ( $m527r188 == 0 ) $m527r188="";
$m527r1810=$hlavicka->m527r1810; if ( $m527r1810 == 0 ) $m527r1810="";
$m527r191=$hlavicka->m527r191; if ( $m527r191 == 0 ) $m527r191="";
$m527r192=$hlavicka->m527r192; if ( $m527r192 == 0 ) $m527r192="";
$m527r193=$hlavicka->m527r193; if ( $m527r193 == 0 ) $m527r193="";
$m527r194=$hlavicka->m527r194; if ( $m527r194 == 0 ) $m527r194="";
$m527r195=$hlavicka->m527r195; if ( $m527r195 == 0 ) $m527r195="";
$m527r196=$hlavicka->m527r196; if ( $m527r196 == 0 ) $m527r196="";
$m527r197=$hlavicka->m527r197; if ( $m527r197 == 0 ) $m527r197="";
$m527r198=$hlavicka->m527r198; if ( $m527r198 == 0 ) $m527r198="";
$m527r1910=$hlavicka->m527r1910; if ( $m527r1910 == 0 ) $m527r1910="";
$m527r201=$hlavicka->m527r201; if ( $m527r201 == 0 ) $m527r201="";
$m527r202=$hlavicka->m527r202; if ( $m527r202 == 0 ) $m527r202="";
$m527r203=$hlavicka->m527r203; if ( $m527r203 == 0 ) $m527r203="";
$m527r204=$hlavicka->m527r204; if ( $m527r204 == 0 ) $m527r204="";
$m527r205=$hlavicka->m527r205; if ( $m527r205 == 0 ) $m527r205="";
$m527r206=$hlavicka->m527r206; if ( $m527r206 == 0 ) $m527r206="";
$m527r207=$hlavicka->m527r207; if ( $m527r207 == 0 ) $m527r207="";
$m527r208=$hlavicka->m527r208; if ( $m527r208 == 0 ) $m527r208="";
$m527r2010=$hlavicka->m527r2010; if ( $m527r2010 == 0 ) $m527r2010="";
$m527r211=$hlavicka->m527r211; if ( $m527r211 == 0 ) $m527r211="";
$m527r212=$hlavicka->m527r212; if ( $m527r212 == 0 ) $m527r212="";
$m527r213=$hlavicka->m527r213; if ( $m527r213 == 0 ) $m527r213="";
$m527r214=$hlavicka->m527r214; if ( $m527r214 == 0 ) $m527r214="";
$m527r215=$hlavicka->m527r215; if ( $m527r215 == 0 ) $m527r215="";
$m527r216=$hlavicka->m527r216; if ( $m527r216 == 0 ) $m527r216="";
$m527r217=$hlavicka->m527r217; if ( $m527r217 == 0 ) $m527r217="";
$m527r218=$hlavicka->m527r218; if ( $m527r218 == 0 ) $m527r218="";
$m527r2110=$hlavicka->m527r2110; if ( $m527r2110 == 0 ) $m527r2110="";
$m527r221=$hlavicka->m527r221; if ( $m527r221 == 0 ) $m527r221="";
$m527r222=$hlavicka->m527r222; if ( $m527r222 == 0 ) $m527r222="";
$m527r223=$hlavicka->m527r223; if ( $m527r223 == 0 ) $m527r223="";
$m527r224=$hlavicka->m527r224; if ( $m527r224 == 0 ) $m527r224="";
$m527r225=$hlavicka->m527r225; if ( $m527r225 == 0 ) $m527r225="";
$m527r226=$hlavicka->m527r226; if ( $m527r226 == 0 ) $m527r226="";
$m527r227=$hlavicka->m527r227; if ( $m527r227 == 0 ) $m527r227="";
$m527r228=$hlavicka->m527r228; if ( $m527r228 == 0 ) $m527r228="";
$m527r2210=$hlavicka->m527r2210; if ( $m527r2210 == 0 ) $m527r2210="";
$m527r231=$hlavicka->m527r231; if ( $m527r231 == 0 ) $m527r231="";
$m527r232=$hlavicka->m527r232; if ( $m527r232 == 0 ) $m527r232="";
$m527r233=$hlavicka->m527r233; if ( $m527r233 == 0 ) $m527r233="";
$m527r234=$hlavicka->m527r234; if ( $m527r234 == 0 ) $m527r234="";
$m527r235=$hlavicka->m527r235; if ( $m527r235 == 0 ) $m527r235="";
$m527r236=$hlavicka->m527r236; if ( $m527r236 == 0 ) $m527r236="";
$m527r237=$hlavicka->m527r237; if ( $m527r237 == 0 ) $m527r237="";
$m527r238=$hlavicka->m527r238; if ( $m527r238 == 0 ) $m527r238="";
$m527r2310=$hlavicka->m527r2310; if ( $m527r2310 == 0 ) $m527r2310="";
$m527r241=$hlavicka->m527r241; if ( $m527r241 == 0 ) $m527r241="";
$m527r242=$hlavicka->m527r242; if ( $m527r242 == 0 ) $m527r242="";
$m527r243=$hlavicka->m527r243; if ( $m527r243 == 0 ) $m527r243="";
$m527r244=$hlavicka->m527r244; if ( $m527r244 == 0 ) $m527r244="";
$m527r245=$hlavicka->m527r245; if ( $m527r245 == 0 ) $m527r245="";
$m527r246=$hlavicka->m527r246; if ( $m527r246 == 0 ) $m527r246="";
$m527r247=$hlavicka->m527r247; if ( $m527r247 == 0 ) $m527r247="";
$m527r248=$hlavicka->m527r248; if ( $m527r248 == 0 ) $m527r248="";
$m527r2410=$hlavicka->m527r2410; if ( $m527r2410 == 0 ) $m527r2410="";
$m527r991=$hlavicka->m527r991;
//if ( $m527r991 == 0 ) $m527r991="";
$m527r992=$hlavicka->m527r992;
//if ( $m527r992 == 0 ) $m527r992="";
$m527r993=$hlavicka->m527r993;
//if ( $m527r993 == 0 ) $m527r993="";
$m527r994=$hlavicka->m527r994;
//if ( $m527r994 == 0 ) $m527r994="";
$m527r995=$hlavicka->m527r995;
//if ( $m527r995 == 0 ) $m527r995="";
$m527r996=$hlavicka->m527r996;
//if ( $m527r996 == 0 ) $m527r996="";
$m527r997=$hlavicka->m527r997;
//if ( $m527r997 == 0 ) $m527r997="";
$m527r998=$hlavicka->m527r998;
//if ( $m527r998 == 0 ) $m527r998="";
$m527r999=$hlavicka->m527r999;
//if ( $m527r999 == 0 ) $m527r999="";
$m527r9910=$hlavicka->m527r9910;
//if ( $m527r9910 == 0 ) $m527r9910="";
$pdf->Cell(195,29," ","$rmc1",1,"L");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,6,"$m527r181","$rmc",0,"R");$pdf->Cell(25,6,"$m527r182","$rmc",0,"R");
$pdf->Cell(18,6,"$m527r183","$rmc",0,"R");$pdf->Cell(21,6,"$m527r184","$rmc",0,"R");
$pdf->Cell(26,6,"$m527r185","$rmc",0,"R");$pdf->Cell(20,6,"$m527r186","$rmc",0,"R");
$pdf->Cell(21,6,"$m527r187","$rmc",0,"R");$pdf->Cell(20,6,"$m527r188","$rmc",0,"R");
$pdf->Cell(21,6,"","$rmc",0,"R");$pdf->Cell(21,6,"$m527r1810","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,12,"$m527r191","$rmc",0,"R");$pdf->Cell(25,12,"$m527r192","$rmc",0,"R");
$pdf->Cell(18,12,"$m527r193","$rmc",0,"R");$pdf->Cell(21,12,"$m527r194","$rmc",0,"R");
$pdf->Cell(26,12,"$m527r195","$rmc",0,"R");$pdf->Cell(20,12,"$m527r196","$rmc",0,"R");
$pdf->Cell(21,12,"$m527r197","$rmc",0,"R");$pdf->Cell(20,12,"$m527r198","$rmc",0,"R");
$pdf->Cell(21,12,"","$rmc",0,"R");$pdf->Cell(21,12,"$m527r1910","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,16,"$m527r201","$rmc",0,"R");$pdf->Cell(25,16,"$m527r202","$rmc",0,"R");
$pdf->Cell(18,16,"$m527r203","$rmc",0,"R");$pdf->Cell(21,16,"$m527r204","$rmc",0,"R");
$pdf->Cell(26,16,"$m527r205","$rmc",0,"R");$pdf->Cell(20,16,"$m527r206","$rmc",0,"R");
$pdf->Cell(21,16,"$m527r207","$rmc",0,"R");$pdf->Cell(20,16,"$m527r208","$rmc",0,"R");
$pdf->Cell(21,16,"","$rmc",0,"R");$pdf->Cell(21,16,"$m527r2010","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,17,"$m527r211","$rmc",0,"R");$pdf->Cell(25,17,"$m527r212","$rmc",0,"R");
$pdf->Cell(18,17,"$m527r213","$rmc",0,"R");$pdf->Cell(21,17,"$m527r214","$rmc",0,"R");
$pdf->Cell(26,17,"$m527r215","$rmc",0,"R");$pdf->Cell(20,17,"$m527r216","$rmc",0,"R");
$pdf->Cell(21,17,"$m527r217","$rmc",0,"R");$pdf->Cell(20,17,"$m527r218","$rmc",0,"R");
$pdf->Cell(21,17,"","$rmc",0,"R");$pdf->Cell(21,17,"$m527r2110","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,12,"$m527r221","$rmc",0,"R");$pdf->Cell(25,12,"$m527r222","$rmc",0,"R");
$pdf->Cell(18,12,"$m527r223","$rmc",0,"R");$pdf->Cell(21,12,"$m527r224","$rmc",0,"R");
$pdf->Cell(26,12,"$m527r225","$rmc",0,"R");$pdf->Cell(20,12,"$m527r226","$rmc",0,"R");
$pdf->Cell(21,12,"$m527r227","$rmc",0,"R");$pdf->Cell(20,12,"$m527r228","$rmc",0,"R");
$pdf->Cell(21,12,"","$rmc",0,"R");$pdf->Cell(21,12,"$m527r2210","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,13,"$m527r231","$rmc",0,"R");$pdf->Cell(25,13,"$m527r232","$rmc",0,"R");
$pdf->Cell(18,13,"$m527r233","$rmc",0,"R");$pdf->Cell(21,13,"$m527r234","$rmc",0,"R");
$pdf->Cell(26,13,"$m527r235","$rmc",0,"R");$pdf->Cell(20,13,"$m527r236","$rmc",0,"R");
$pdf->Cell(21,13,"$m527r237","$rmc",0,"R");$pdf->Cell(20,13,"$m527r238","$rmc",0,"R");
$pdf->Cell(21,13,"","$rmc",0,"R");$pdf->Cell(21,13,"$m527r2310","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,8,"$m527r241","$rmc",0,"R");$pdf->Cell(25,8,"$m527r242","$rmc",0,"R");
$pdf->Cell(18,8,"$m527r243","$rmc",0,"R");$pdf->Cell(21,8,"$m527r244","$rmc",0,"R");
$pdf->Cell(26,8,"$m527r245","$rmc",0,"R");$pdf->Cell(20,8,"$m527r246","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r247","$rmc",0,"R");$pdf->Cell(20,8,"$m527r248","$rmc",0,"R");
$pdf->Cell(21,8,"","$rmc",0,"R");$pdf->Cell(21,8,"$m527r2410","$rmc",1,"R");
$pdf->Cell(75,4," ","$rmc1",0,"L");
$pdf->Cell(21,7,"$m527r991","$rmc",0,"R");$pdf->Cell(25,7,"$m527r992","$rmc",0,"R");
$pdf->Cell(18,7,"$m527r993","$rmc",0,"R");$pdf->Cell(21,7,"$m527r994","$rmc",0,"R");
$pdf->Cell(26,7,"$m527r995","$rmc",0,"R");$pdf->Cell(20,7,"$m527r996","$rmc",0,"R");
$pdf->Cell(21,7,"$m527r997","$rmc",0,"R");$pdf->Cell(20,7,"$m527r998","$rmc",0,"R");
$pdf->Cell(21,7,"$m527r999","$rmc",0,"R");$pdf->Cell(21,7,"$m527r9910","$rmc",1,"R");
                                        }


if ( $strana == 15 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/vts101/vts101v14_str15.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/vts101/vts101v14_str15.jpg',0,0,210,297);
}

//modul 474
$m474r11=$hlavicka->m474r11; if ( $m474r11 == 0 ) $m474r11="";
$m474r12=$hlavicka->m474r12; if ( $m474r12 == 0 ) $m474r12="";
$m474r13=$hlavicka->m474r13; if ( $m474r13 == 0 ) $m474r13="";
$m474r21=$hlavicka->m474r21; if ( $m474r21 == 0 ) $m474r21="";
$m474r22=$hlavicka->m474r22; if ( $m474r22 == 0 ) $m474r22="";
$m474r23=$hlavicka->m474r23; if ( $m474r23 == 0 ) $m474r23="";
$m474r31=$hlavicka->m474r31; if ( $m474r31 == 0 ) $m474r31="";
$m474r32=$hlavicka->m474r32; if ( $m474r32 == 0 ) $m474r32="";
$m474r33=$hlavicka->m474r33; if ( $m474r33 == 0 ) $m474r33="";
$m474r41=$hlavicka->m474r41; if ( $m474r41 == 0 ) $m474r41="";
$m474r42=$hlavicka->m474r42; if ( $m474r42 == 0 ) $m474r42="";
$m474r43=$hlavicka->m474r43; if ( $m474r43 == 0 ) $m474r43="";
$m474r51=$hlavicka->m474r51; if ( $m474r51 == 0 ) $m474r51="";
$m474r52=$hlavicka->m474r52; if ( $m474r52 == 0 ) $m474r52="";
$m474r53=$hlavicka->m474r53; if ( $m474r53 == 0 ) $m474r53="";
$m474r61=$hlavicka->m474r61; if ( $m474r61 == 0 ) $m474r61="";
$m474r62=$hlavicka->m474r62; if ( $m474r62 == 0 ) $m474r62="";
$m474r63=$hlavicka->m474r63; if ( $m474r63 == 0 ) $m474r63="";
$m474r72=$hlavicka->m474r72; if ( $m474r72 == 0 ) $m474r72="";
$m474r73=$hlavicka->m474r73; if ( $m474r73 == 0 ) $m474r73="";
$m474r991=$hlavicka->m474r991;
//if ( $m474r991 == 0 ) $m474r991="";
$m474r992=$hlavicka->m474r992;
//if ( $m474r992 == 0 ) $m474r992="";
$m474r993=$hlavicka->m474r993;
//if ( $m474r993 == 0 ) $m474r993="";
$pdf->Cell(195,49," ","$rmc1",1,"L");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r11","$rmc",0,"R");$pdf->Cell(25,6,"$m474r12","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r13","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r21","$rmc",0,"R");$pdf->Cell(25,6,"$m474r22","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r23","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r31","$rmc",0,"R");$pdf->Cell(25,6,"$m474r32","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r33","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r41","$rmc",0,"R");$pdf->Cell(25,6,"$m474r42","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r43","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r51","$rmc",0,"R");$pdf->Cell(25,6,"$m474r52","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r53","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r61","$rmc",0,"R");$pdf->Cell(25,6,"$m474r62","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r63","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,5,"","$rmc",0,"R");$pdf->Cell(25,5,"$m474r72","$rmc",0,"R");
$pdf->Cell(25,5,"$m474r73","$rmc",1,"R");
$pdf->Cell(114,4," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m474r991","$rmc",0,"R");$pdf->Cell(25,6,"$m474r992","$rmc",0,"R");
$pdf->Cell(25,6,"$m474r993","$rmc",1,"R");

//modul 514
$m514r1=$hlavicka->m514r1; if ( $m514r1 == 0 ) $m514r1="";
$m514r2=$hlavicka->m514r2; if ( $m514r2 == 0 ) $m514r2="";
$m514r3=$hlavicka->m514r3; if ( $m514r3 == 0 ) $m514r3="";
$m514r99=$hlavicka->m514r99;
//if ( $m514r99 == 0 ) $m514r99="";
$pdf->Cell(195,40," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m514r1","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,11,"$m514r2","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,10,"$m514r3","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"R");$pdf->Cell(70,6,"$m514r99","$rmc",1,"R");
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