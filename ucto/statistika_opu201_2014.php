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

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");

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

//modul 178
if( $modul == 178 )
{

//178.modul  

$r01=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 501 OR LEFT(uce,3) = 502 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r02=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 518 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r03=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 503 OR LEFT(uce,3) = 511 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r03=$r03+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }

$r04=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 549 OR LEFT(uce,3) = 582 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r06=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 527 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r13=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 524 OR LEFT(uce,3) = 526 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r13=$r13+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }



$r16=0; $r17=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 112 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { 
$polozka=mysql_fetch_object($sql); 
$r16=$r16+$polozka->pmd-$polozka->pdl;
$r17=$r17+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$r18=0; $r19=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 123 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { 
$polozka=mysql_fetch_object($sql); 
$r18=$r18+$polozka->pmd-$polozka->pdl;
$r19=$r19+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }


$r20=0; $r21=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 132 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { 
$polozka=mysql_fetch_object($sql); 
$r20=$r20+$polozka->pmd-$polozka->pdl;
$r21=$r21+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m178r01='$r01', m178r02='$r02', m178r03='$r03', m178r04='$r04', m178r06='$r06', m178r13='$r13', m178r16='$r16', m178r17='$r17', m178r18='$r18', m178r19='$r19', ".
" m178r20='$r20', m178r21='$r21' ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m183r201=m178r02+m178r03, m184r201=m178r01  WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 
 

$strana=8;
}
//koniec modul178


//modul 177
if( $citajvsetkymoduly == 1 ) { $modul=177; }
if( $modul == 177 )
{

//177.modul 

$r01=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r01=$r01+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r02=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 604 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r02=$r02+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }


$r04=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 504 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r04=$r04+$polozka->omd-$polozka->odl; }
$i=$i+1;                   }


$r06=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 62 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r06=$r06+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }

$r07=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,2) = 61 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r07=$r07+$polozka->odl-$polozka->omd; }
$i=$i+1;                   }



$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m177r01='$r01', m177r02='$r02', m177r04='$r04', m177r06='$r06', m177r07='$r07' WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 
 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m182r201=m177r01, m185r201=m177r02, m185r301=m177r04, m186r201=m177r03, m186r301=m177r05 WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 


$strana=7;
}
//koniec modul177



//prepnute z uobrat.php modul 513 
if( $citajvsetkymoduly == 1 ) { $modul=513; }
if( $modul == 513 )
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r101='$poccen' , m513r201='$pocops' , m513r301='$prir' , m513r401='$ubyt' , m513r501='$zoscen' , m513r601='$zosops' ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r102='$poccen' , m513r202='$pocops' , m513r302='$prir' , m513r402='$ubyt' , m513r502='$zoscen' , m513r602='$zosops' ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r103='$poccen' , m513r203='$pocops' , m513r303='$prir' , m513r403='$ubyt' , m513r503='$zoscen' , m513r603='$zosops' ".
" WHERE ico >= 0"; 
//echo $uprtxt;
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r104='$poccen' , m513r204='$pocops' , m513r304='$prir' , m513r404='$ubyt' , m513r504='$zoscen' , m513r604='$zosops' ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r106='$poccen' , m513r206='$pocops' , m513r306='$prir' , m513r406='$ubyt' , m513r506='$zoscen' , m513r606='$zosops' ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r109='$poccen' , m513r209='$pocops' , m513r309='$prir' , m513r409='$ubyt' , m513r509='$zoscen' , m513r609='$zosops' ".
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

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m513r110='$poccen' , m513r210='$pocops' , m513r310='$prir' , m513r410='$ubyt' , m513r510='$zoscen' , m513r610='$zosops' ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

$strana=6;
}
//koniec odpocitaj modul 513 


//prepnute z uobrat.php modul 516 
if( $citajvsetkymoduly == 1 ) { $modul=516; }
if( $modul == 516 )
{
$mx516r101; $mx516r103; $mx516r203;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 041 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx516r101=$mx516r101+$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 042 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx516r103=$mx516r103+$polozka->omd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 641 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx516r203=$mx516r203+$polozka->odl; }
$i=$i+1;                   } 

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m516r101='$mx516r101', m516r103='$mx516r103', m516r203='$mx516r203' ".
" WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$strana=5;
}
//koniec odpocitaj modul 516 


//prepnute z uobrat.php modul 405 
if( $citajvsetkymoduly == 1 ) { $modul=405; }
if ( $modul == 405 )
{
$mx405r01=0;$mx405r02=0;$mx405r03=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,1) = 6 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx405r01=$mx405r01+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND LEFT(uce,1) = 5 AND LEFT(uce,2) != 59 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx405r02=$mx405r02+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND LEFT(uce,3) = 551 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx405r03=$mx405r03+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m405r03='$mx405r03', m405r02='$mx405r02', m405r01='$mx405r01' ".
" WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


$strana=3;
}
//koniec uobrat.php modul 405

//prepnute z uobrat.php modul 558 
if( $citajvsetkymoduly == 1 ) { $modul=558; }
if ( $modul == 558 )
{
$mx558r03=0;$mx558r04=0;;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 644 OR LEFT(uce,3) = 645 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx558r03=$mx558r03+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 544 OR LEFT(uce,3) = 545 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx558r04=$mx558r04+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }



$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m558r03='$mx558r03', m558r04='$mx558r04' ".
" WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


$strana=3;
}
//koniec uobrat.php modul 558

//prepnute z uobrat.php modul 586 
if( $citajvsetkymoduly == 1 ) { $modul=586; }
if ( $modul == 586 )
{
$mx586r11=0;$mx586r12=0;$mx586r13=0;$mx586r21=0;$mx586r22=0;$mx586r23=0;

//311, 313, 315, 316, 317, 318, 319, 335, 369, 374, 375, 376, 378,
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 311 OR LEFT(uce,3) = 313 ".
"  OR LEFT(uce,3) = 315 OR LEFT(uce,3) = 316 OR LEFT(uce,3) = 317 OR LEFT(uce,3) = 318 OR LEFT(uce,3) = 319 OR LEFT(uce,3) = 335 ".
"  OR LEFT(uce,3) = 369 OR LEFT(uce,3) = 374 OR LEFT(uce,3) = 375 OR LEFT(uce,3) = 376 OR LEFT(uce,3) = 378 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx586r11=$mx586r11+$polozka->pmd-$polozka->pdl; }
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx586r21=$mx586r21+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }

//321, 324, 325, 326, ��ty 367, 368, ��ty 331, 333, 377, 379,
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 321 OR LEFT(uce,3) = 324 ".
"  OR LEFT(uce,3) = 325 OR LEFT(uce,3) = 326 OR LEFT(uce,3) = 367 OR LEFT(uce,3) = 368 OR LEFT(uce,3) = 331 OR LEFT(uce,3) = 333 ".
"  OR LEFT(uce,3) = 377 OR LEFT(uce,3) = 379 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx586r12=$mx586r12+$polozka->pdl-$polozka->pmd; }
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx586r22=$mx586r22+$polozka->zdl-$polozka->zmd; }
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobratsx$kli_uzid WHERE ur1 = 999 AND ( LEFT(uce,3) = 544 OR LEFT(uce,3) = 545 )";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
//echo $sqltt;
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $mx586r13=$mx586r13+$polozka->zmd-$polozka->zdl; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m586r13='$mx586r13', m586r12='$mx586r12', m586r11='$mx586r11', ".
" m586r23='$mx586r23', m586r22='$mx586r22', m586r21='$mx586r21'  ".
" WHERE ico >= 0"; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


$strana=4;
}
//koniec uobrat.php modul 586

//pracovny subor statistika_opu201
$sql = "SELECT konx FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$vsql = 'DROP TABLE F'.$kli_vxcf.'_statistika_opu201';
$vytvor = mysql_query("$vsql");
$sqlt = <<<statistika_opu201
(
   psys         INT,
   cinnost      VARCHAR(80),
   mod100041ano DECIMAL(2,0) DEFAULT 0,
   mod100041nie DECIMAL(2,0) DEFAULT 0,
   mod100042ano DECIMAL(2,0) DEFAULT 0,
   mod100042nie DECIMAL(2,0) DEFAULT 0,
   mod100043ano DECIMAL(2,0) DEFAULT 0,
   mod100043nie DECIMAL(2,0) DEFAULT 0,
   mod100038    DECIMAL(2,0) DEFAULT 0,
   mod100039    DECIMAL(2,0) DEFAULT 0,
   mod100040    DECIMAL(2,0) DEFAULT 0,
   mod100036kal DECIMAL(2,0) DEFAULT 0,
   mod100036hos DECIMAL(2,0) DEFAULT 0,
   mod100037    DECIMAL(2,0) DEFAULT 0,
   mod100069ano DECIMAL(2,0) DEFAULT 0,
   mod100069nie DECIMAL(2,0) DEFAULT 0,
   mod100086ano DECIMAL(2,0) DEFAULT 0,
   mod100086nie DECIMAL(2,0) DEFAULT 0,
   mod100087ano DECIMAL(2,0) DEFAULT 0,
   mod100087nie DECIMAL(2,0) DEFAULT 0,
   mod100088ano DECIMAL(2,0) DEFAULT 0,
   mod100088nie DECIMAL(2,0) DEFAULT 0,
   mod100089    DECIMAL(10,0) DEFAULT 0,
   mod100090    DECIMAL(10,0) DEFAULT 0,
   mod100091    DECIMAL(10,0) DEFAULT 0,
   mod2r01      DECIMAL(10,0) DEFAULT 0,
   mod2r02      DECIMAL(10,0) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   ico          DECIMAL(8,0)
);
statistika_opu201;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_statistika_opu201'.$sqlt;
$vytvor = mysql_query("$vsql");
$ttvv = "INSERT INTO F$kli_vxcf"."_statistika_opu201 ( ico ) VALUES ( '0' )";
$ttqq = mysql_query("$ttvv");
}

//1.strana, 2.strana je hore vyssie
$sql = "SELECT odoslane FROM F$kli_vxcf"."_statistika_opu201 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD odoslane DATE NOT NULL AFTER cinnost";
$vysledek = mysql_query("$sql");
}

//3.strana
$sql = "SELECT m398r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m398r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m398r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m398r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT m405r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r06 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m405r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m558r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r06 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m558r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//4.strana
$sql = "SELECT m580r299 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m580r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m580r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m580r199 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m580r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m580r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m580r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m100044nie FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r199 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r22 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r24 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m586r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m100062ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m100062nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m100044ano DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m100044nie DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m585r5k FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r3k VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r4k VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m585r5k VARCHAR(20) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
}
//5.strana
$sql = "SELECT m571r98 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r10 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r12 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r20 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r22 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r23 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r25 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r26 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r27 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r28 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r30 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r32 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r33 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r35 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r36 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r37 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r38 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r40 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r42 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r43 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r45 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r46 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r47 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r48 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r50 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r52 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r53 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r55 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r56 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r57 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r58 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r60 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r62 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r63 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r65 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r66 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r67 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r68 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r70 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r72 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r73 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r75 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r76 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r77 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r78 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r80 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r82 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r83 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r85 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r86 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r87 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r88 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r90 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r92 VARCHAR(25) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r93 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r95 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r96 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r97 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m571r98 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m516r299 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r109 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r111 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r112 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r113 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r114 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r199 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m516r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//6.strana
$sql = "SELECT m513r699 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r108 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r109 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r110 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r199 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r308 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r309 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r401 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r402 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r403 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r404 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r405 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r406 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r407 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r408 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r409 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r499 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r501 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r502 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r503 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r504 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r505 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r506 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r507 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r508 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r509 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r599 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r601 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r602 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r603 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r604 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r605 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r606 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r607 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r608 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r609 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r610 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m513r699 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m581r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m581r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m581r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m581r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m588r351 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r201 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r202 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r203 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r204 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r205 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r206 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r207 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r208 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r209 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r210 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r211 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r212 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r213 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r214 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r215 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r216 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r217 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r218 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r219 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r220 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r221 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r222 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r223 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r224 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r225 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r226 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r227 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r228 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r229 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r230 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r231 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r232 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r233 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r234 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r235 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r236 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r237 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r238 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r239 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r240 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r241 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r242 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r243 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r244 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r245 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r246 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r247 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r248 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r249 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r250 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r251 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r301 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r302 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r303 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r304 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r305 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r306 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r307 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r308 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r309 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r310 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r311 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r312 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r313 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r314 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r315 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r316 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r317 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r318 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r319 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r320 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r321 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r322 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r323 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r324 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r325 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r326 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r327 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r328 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r329 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r330 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r331 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r332 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r333 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r334 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r335 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r336 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r337 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r338 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r339 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r340 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r341 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r342 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r343 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r344 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r345 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r346 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r347 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r348 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r349 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r350 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m588r351 DECIMAL(2,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//7.strana
$sql = "SELECT m177r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r06 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r07 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r08 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m177r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//8.strana
$sql = "SELECT m178r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r06 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r07 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r08 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r09 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r10 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r11 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r12 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r13 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r14 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r15 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r16 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r17 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r18 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r19 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r20 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r21 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m178r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m179r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m179r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m179r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m179r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m182r299 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r001 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r002 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r003 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r004 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r005 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r006 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r007 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r099 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r101 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r102 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r103 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r104 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r105 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r106 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r107 VARCHAR(30) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m182r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//9.strana
$sql = "SELECT m183r2299 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r001 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r002 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r003 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r004 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r005 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r006 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r007 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r008 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r009 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r010 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r101 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r102 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r103 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r104 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r105 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r106 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r107 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r108 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r109 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r110 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r001 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r002 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r003 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r004 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r005 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r006 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r007 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r008 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r009 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m183r010 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m183r2299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m184r2399 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r001 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r002 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r003 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r004 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r005 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r006 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r007 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r008 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r009 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r010 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r101 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r102 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r103 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r104 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r105 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r106 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r107 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r108 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r109 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r110 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r001 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r002 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r003 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r004 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r005 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r006 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r007 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r008 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r009 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m184r010 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r308 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r309 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m184r2399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//10.strana
$sql = "SELECT m185r2399 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r001 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r002 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r003 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r004 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r005 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r006 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r007 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r001 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r002 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r003 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r004 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r005 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r006 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m185r007 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r101 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r102 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r103 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r104 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r105 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r106 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r107 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m185r2399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m186r2399 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r001 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r002 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r003 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r004 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r005 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r006 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r007 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r001 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r002 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r003 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r004 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r005 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r006 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m186r007 VARCHAR(30) NOT NULL ";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r101 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r102 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r103 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r104 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r105 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r106 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r107 VARCHAR(10) NOT NULL AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m186r2399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT m304r99 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r01 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r02 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r03 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r04 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r05 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r06 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m304r99 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//11.strana
$sql = "SELECT m527r1004 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r401 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r402 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r403 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r404 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r501 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r502 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r503 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r504 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r601 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r602 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r603 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r604 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r701 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r702 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r703 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r704 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r801 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r802 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r803 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r804 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r901 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r902 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r903 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r904 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r1001 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r1002 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r1003 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m527r1004 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//12.strana
$sql = "SELECT m474r399 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r101 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r102 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r103 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r104 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r105 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r106 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r107 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r199 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m474r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//13.strana
$sql = "SELECT m127r699 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r001 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r002 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r003 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r004 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r005 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r006 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r007 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r008 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r009 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r010 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r011 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r012 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r013 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r014 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r015 VARCHAR(30) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r101 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r102 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r103 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r104 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r105 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r106 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r107 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r108 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r109 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r110 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r111 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r112 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r113 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r114 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r115 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r212 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r213 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r214 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r215 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r308 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r309 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r312 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r313 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r314 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r315 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r401 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r402 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r403 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r404 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r405 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r406 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r407 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r408 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r409 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r411 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r412 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r413 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r414 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r415 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r499 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r501 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r502 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r503 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r504 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r505 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r506 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r507 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r508 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r509 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r511 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r512 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r513 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r514 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r515 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r599 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r601 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r602 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r603 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r604 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r605 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r606 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r607 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r608 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r609 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r610 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r611 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r612 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r613 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r614 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r615 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m127r699 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
//14.strana
$sql = "SELECT m128r599 FROM F$kli_vxcf"."_statistika_opu201 WHERE ico=0";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r101 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r102 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r103 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r104 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r105 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r106 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r107 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r108 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r109 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r110 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r111 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r199 VARCHAR(10) NOT NULL";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r201 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r202 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r203 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r204 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r205 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r206 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r207 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r208 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r209 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r210 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r211 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r299 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r301 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r302 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r303 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r304 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r305 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r306 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r307 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r308 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r309 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r310 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r311 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r399 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r401 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r402 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r403 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r404 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r405 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r406 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r407 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r408 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r409 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r410 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r411 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r499 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r501 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r502 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r503 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r504 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r505 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r506 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r507 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r508 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r509 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r510 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r511 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 ADD m128r599 DECIMAL(10,0) DEFAULT 0 AFTER konx";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r101 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r102 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r103 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r104 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r105 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r106 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r107 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r108 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r109 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r110 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r111 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_statistika_opu201 MODIFY m128r199 DECIMAL(10,0) DEFAULT 0 ";
$vysledek = mysql_query("$sql");
//koniec pracovny subor


//nacitaj mzdy
if( $citajvsetkymoduly == 1 ) { $copern=200; }
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
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
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
$odoslane = strip_tags($_REQUEST['odoslane']);
$odoslane_sql=SqlDatum($odoslane);

$mod100041ano = strip_tags($_REQUEST['mod100041ano']);
$mod100041nie = strip_tags($_REQUEST['mod100041nie']);
$mod100042ano = strip_tags($_REQUEST['mod100042ano']);
$mod100042nie = strip_tags($_REQUEST['mod100042nie']);
$mod100043ano = strip_tags($_REQUEST['mod100043ano']);
$mod100043nie = strip_tags($_REQUEST['mod100043nie']);

//2.strana
$mod100038 = strip_tags($_REQUEST['mod100038']);
$mod100039 = strip_tags($_REQUEST['mod100039']);
$mod100040 = strip_tags($_REQUEST['mod100040']);
$mod100036kal = strip_tags($_REQUEST['mod100036kal']);
$mod100036hos = strip_tags($_REQUEST['mod100036hos']);
$mod100037 = strip_tags($_REQUEST['mod100037']);
$mod100069ano = strip_tags($_REQUEST['mod100069ano']);
$mod100069nie = strip_tags($_REQUEST['mod100069nie']);
$mod100086ano = strip_tags($_REQUEST['mod100086ano']);
$mod100086nie = strip_tags($_REQUEST['mod100086nie']);
$mod100087ano = strip_tags($_REQUEST['mod100087ano']);
$mod100087nie = strip_tags($_REQUEST['mod100087nie']);
$mod100088ano = strip_tags($_REQUEST['mod100088ano']);
$mod100088nie = strip_tags($_REQUEST['mod100088nie']);
$mod100089 = strip_tags($_REQUEST['mod100089']);
$mod100090 = strip_tags($_REQUEST['mod100090']);
$mod100091 = strip_tags($_REQUEST['mod100091']);

//3.strana
$mod2r01 = strip_tags($_REQUEST['mod2r01']);
$mod2r02 = strip_tags($_REQUEST['mod2r02']);

$m398r01 = strip_tags($_REQUEST['m398r01']);
$m398r02 = strip_tags($_REQUEST['m398r02']);
$m398r99 = strip_tags($_REQUEST['m398r99']);

$m405r01 = strip_tags($_REQUEST['m405r01']);
$m405r02 = strip_tags($_REQUEST['m405r02']);
$m405r03 = strip_tags($_REQUEST['m405r03']);
$m405r04 = strip_tags($_REQUEST['m405r04']);
$m405r05 = strip_tags($_REQUEST['m405r05']);
$m405r06 = strip_tags($_REQUEST['m405r06']);
$m405r99 = strip_tags($_REQUEST['m405r99']);

$m558r01 = strip_tags($_REQUEST['m558r01']);
$m558r02 = strip_tags($_REQUEST['m558r02']);
$m558r03 = strip_tags($_REQUEST['m558r03']);
$m558r04 = strip_tags($_REQUEST['m558r04']);
$m558r05 = strip_tags($_REQUEST['m558r05']);
$m558r06 = strip_tags($_REQUEST['m558r06']);
$m558r99 = strip_tags($_REQUEST['m558r99']);

//4.strana
$m580r11 = strip_tags($_REQUEST['m580r11']);
$m580r12 = strip_tags($_REQUEST['m580r12']);
$m580r199 = strip_tags($_REQUEST['m580r199']);
$m580r21 = strip_tags($_REQUEST['m580r21']);
$m580r22 = strip_tags($_REQUEST['m580r22']);
$m580r299 = strip_tags($_REQUEST['m580r299']);

$m586r11 = strip_tags($_REQUEST['m586r11']);
$m586r12 = strip_tags($_REQUEST['m586r12']);
$m586r13 = strip_tags($_REQUEST['m586r13']);
$m586r14 = strip_tags($_REQUEST['m586r14']);
$m586r199 = strip_tags($_REQUEST['m586r199']);
$m586r21 = strip_tags($_REQUEST['m586r21']);
$m586r22 = strip_tags($_REQUEST['m586r22']);
$m586r23 = strip_tags($_REQUEST['m586r23']);
$m586r24 = strip_tags($_REQUEST['m586r24']);
$m586r299 = strip_tags($_REQUEST['m586r299']);
$m100062ano = strip_tags($_REQUEST['m100062ano']);
$m100062nie = strip_tags($_REQUEST['m100062nie']);
$m100044ano = strip_tags($_REQUEST['m100044ano']);
$m100044nie = strip_tags($_REQUEST['m100044nie']);
$m585r01 = strip_tags($_REQUEST['m585r01']);
$m585r02 = strip_tags($_REQUEST['m585r02']);
$m585r03 = strip_tags($_REQUEST['m585r03']);
$m585r04 = strip_tags($_REQUEST['m585r04']);
$m585r05 = strip_tags($_REQUEST['m585r05']);
$m585r3k = strip_tags($_REQUEST['m585r3k']);
$m585r4k = strip_tags($_REQUEST['m585r4k']);
$m585r5k = strip_tags($_REQUEST['m585r5k']);


//5.strana
$m516r101 = strip_tags($_REQUEST['m516r101']);
$m516r102 = strip_tags($_REQUEST['m516r102']);
$m516r103 = strip_tags($_REQUEST['m516r103']);
$m516r104 = strip_tags($_REQUEST['m516r104']);
$m516r105 = strip_tags($_REQUEST['m516r105']);
$m516r106 = strip_tags($_REQUEST['m516r106']);
$m516r107 = strip_tags($_REQUEST['m516r107']);
$m516r108 = strip_tags($_REQUEST['m516r108']);
$m516r109 = strip_tags($_REQUEST['m516r109']);
$m516r110 = strip_tags($_REQUEST['m516r110']);
$m516r111 = strip_tags($_REQUEST['m516r111']);
$m516r112 = strip_tags($_REQUEST['m516r112']);
$m516r113 = strip_tags($_REQUEST['m516r113']);
$m516r114 = strip_tags($_REQUEST['m516r114']);
$m516r199 = strip_tags($_REQUEST['m516r199']);
$m516r201 = strip_tags($_REQUEST['m516r201']);
$m516r202 = strip_tags($_REQUEST['m516r202']);
$m516r203 = strip_tags($_REQUEST['m516r203']);
$m516r204 = strip_tags($_REQUEST['m516r204']);
$m516r205 = strip_tags($_REQUEST['m516r205']);
$m516r206 = strip_tags($_REQUEST['m516r206']);
$m516r207 = strip_tags($_REQUEST['m516r207']);
$m516r208 = strip_tags($_REQUEST['m516r208']);
$m516r209 = strip_tags($_REQUEST['m516r209']);
$m516r210 = strip_tags($_REQUEST['m516r210']);
$m516r211 = strip_tags($_REQUEST['m516r211']);
$m516r212 = strip_tags($_REQUEST['m516r212']);
$m516r213 = strip_tags($_REQUEST['m516r213']);
$m516r214 = strip_tags($_REQUEST['m516r214']);
$m516r299 = strip_tags($_REQUEST['m516r299']);

$m571r10 = strip_tags($_REQUEST['m571r10']);
$m571r12 = strip_tags($_REQUEST['m571r12']);
$m571r13 = strip_tags($_REQUEST['m571r13']);
$m571r14 = strip_tags($_REQUEST['m571r14']);
$m571r15 = strip_tags($_REQUEST['m571r15']);
$m571r16 = strip_tags($_REQUEST['m571r16']);
$m571r17 = strip_tags($_REQUEST['m571r17']);
$m571r18 = strip_tags($_REQUEST['m571r18']);
$m571r20 = strip_tags($_REQUEST['m571r20']);
$m571r22 = strip_tags($_REQUEST['m571r22']);
$m571r23 = strip_tags($_REQUEST['m571r23']);
$m571r24 = strip_tags($_REQUEST['m571r24']);
$m571r25 = strip_tags($_REQUEST['m571r25']);
$m571r26 = strip_tags($_REQUEST['m571r26']);
$m571r27 = strip_tags($_REQUEST['m571r27']);
$m571r28 = strip_tags($_REQUEST['m571r28']);
$m571r30 = strip_tags($_REQUEST['m571r30']);
$m571r32 = strip_tags($_REQUEST['m571r32']);
$m571r33 = strip_tags($_REQUEST['m571r33']);
$m571r34 = strip_tags($_REQUEST['m571r34']);
$m571r35 = strip_tags($_REQUEST['m571r35']);
$m571r36 = strip_tags($_REQUEST['m571r36']);
$m571r37 = strip_tags($_REQUEST['m571r37']);
$m571r38 = strip_tags($_REQUEST['m571r38']);
$m571r40 = strip_tags($_REQUEST['m571r40']);
$m571r42 = strip_tags($_REQUEST['m571r42']);
$m571r43 = strip_tags($_REQUEST['m571r43']);
$m571r44 = strip_tags($_REQUEST['m571r44']);
$m571r45 = strip_tags($_REQUEST['m571r45']);
$m571r46 = strip_tags($_REQUEST['m571r46']);
$m571r47 = strip_tags($_REQUEST['m571r47']);
$m571r48 = strip_tags($_REQUEST['m571r48']);
$m571r50 = strip_tags($_REQUEST['m571r50']);
$m571r52 = strip_tags($_REQUEST['m571r52']);
$m571r53 = strip_tags($_REQUEST['m571r53']);
$m571r54 = strip_tags($_REQUEST['m571r54']);
$m571r55 = strip_tags($_REQUEST['m571r55']);
$m571r56 = strip_tags($_REQUEST['m571r56']);
$m571r57 = strip_tags($_REQUEST['m571r57']);
$m571r58 = strip_tags($_REQUEST['m571r58']);
$m571r60 = strip_tags($_REQUEST['m571r60']);
$m571r62 = strip_tags($_REQUEST['m571r62']);
$m571r63 = strip_tags($_REQUEST['m571r63']);
$m571r64 = strip_tags($_REQUEST['m571r64']);
$m571r65 = strip_tags($_REQUEST['m571r65']);
$m571r66 = strip_tags($_REQUEST['m571r66']);
$m571r67 = strip_tags($_REQUEST['m571r67']);
$m571r68 = strip_tags($_REQUEST['m571r68']);
$m571r70 = strip_tags($_REQUEST['m571r70']);
$m571r72 = strip_tags($_REQUEST['m571r72']);
$m571r73 = strip_tags($_REQUEST['m571r73']);
$m571r74 = strip_tags($_REQUEST['m571r74']);
$m571r75 = strip_tags($_REQUEST['m571r75']);
$m571r76 = strip_tags($_REQUEST['m571r76']);
$m571r77 = strip_tags($_REQUEST['m571r77']);
$m571r78 = strip_tags($_REQUEST['m571r78']);
$m571r80 = strip_tags($_REQUEST['m571r80']);
$m571r82 = strip_tags($_REQUEST['m571r82']);
$m571r83 = strip_tags($_REQUEST['m571r83']);
$m571r84 = strip_tags($_REQUEST['m571r84']);
$m571r85 = strip_tags($_REQUEST['m571r85']);
$m571r86 = strip_tags($_REQUEST['m571r86']);
$m571r87 = strip_tags($_REQUEST['m571r87']);
$m571r88 = strip_tags($_REQUEST['m571r88']);
$m571r90 = strip_tags($_REQUEST['m571r90']);
$m571r92 = strip_tags($_REQUEST['m571r92']);
$m571r93 = strip_tags($_REQUEST['m571r93']);
$m571r94 = strip_tags($_REQUEST['m571r94']);
$m571r95 = strip_tags($_REQUEST['m571r95']);
$m571r96 = strip_tags($_REQUEST['m571r96']);
$m571r97 = strip_tags($_REQUEST['m571r97']);
$m571r98 = strip_tags($_REQUEST['m571r98']);

//6.strana
$m513r101 = strip_tags($_REQUEST['m513r101']);
$m513r102 = strip_tags($_REQUEST['m513r102']);
$m513r103 = strip_tags($_REQUEST['m513r103']);
$m513r104 = strip_tags($_REQUEST['m513r104']);
$m513r105 = strip_tags($_REQUEST['m513r105']);
$m513r106 = strip_tags($_REQUEST['m513r106']);
$m513r107 = strip_tags($_REQUEST['m513r107']);
$m513r108 = strip_tags($_REQUEST['m513r108']);
$m513r109 = strip_tags($_REQUEST['m513r109']);
$m513r110 = strip_tags($_REQUEST['m513r110']);
$m513r199 = strip_tags($_REQUEST['m513r199']);

$m513r201 = strip_tags($_REQUEST['m513r201']);
$m513r202 = strip_tags($_REQUEST['m513r202']);
$m513r203 = strip_tags($_REQUEST['m513r203']);
$m513r204 = strip_tags($_REQUEST['m513r204']);
$m513r205 = strip_tags($_REQUEST['m513r205']);
$m513r206 = strip_tags($_REQUEST['m513r206']);
$m513r207 = strip_tags($_REQUEST['m513r207']);
$m513r208 = strip_tags($_REQUEST['m513r208']);
$m513r209 = strip_tags($_REQUEST['m513r209']);
$m513r210 = strip_tags($_REQUEST['m513r210']);
$m513r299 = strip_tags($_REQUEST['m513r299']);

$m513r301 = strip_tags($_REQUEST['m513r301']);
$m513r302 = strip_tags($_REQUEST['m513r302']);
$m513r303 = strip_tags($_REQUEST['m513r303']);
$m513r304 = strip_tags($_REQUEST['m513r304']);
$m513r305 = strip_tags($_REQUEST['m513r305']);
$m513r306 = strip_tags($_REQUEST['m513r306']);
$m513r307 = strip_tags($_REQUEST['m513r307']);
$m513r308 = strip_tags($_REQUEST['m513r308']);
$m513r309 = strip_tags($_REQUEST['m513r309']);
$m513r310 = strip_tags($_REQUEST['m513r310']);
$m513r399 = strip_tags($_REQUEST['m513r399']);

$m513r401 = strip_tags($_REQUEST['m513r401']);
$m513r402 = strip_tags($_REQUEST['m513r402']);
$m513r403 = strip_tags($_REQUEST['m513r403']);
$m513r404 = strip_tags($_REQUEST['m513r404']);
$m513r405 = strip_tags($_REQUEST['m513r405']);
$m513r406 = strip_tags($_REQUEST['m513r406']);
$m513r407 = strip_tags($_REQUEST['m513r407']);
$m513r408 = strip_tags($_REQUEST['m513r408']);
$m513r409 = strip_tags($_REQUEST['m513r409']);
$m513r410 = strip_tags($_REQUEST['m513r410']);
$m513r499 = strip_tags($_REQUEST['m513r499']);

$m513r501 = strip_tags($_REQUEST['m513r501']);
$m513r502 = strip_tags($_REQUEST['m513r502']);
$m513r503 = strip_tags($_REQUEST['m513r503']);
$m513r504 = strip_tags($_REQUEST['m513r504']);
$m513r505 = strip_tags($_REQUEST['m513r505']);
$m513r506 = strip_tags($_REQUEST['m513r506']);
$m513r507 = strip_tags($_REQUEST['m513r507']);
$m513r508 = strip_tags($_REQUEST['m513r508']);
$m513r509 = strip_tags($_REQUEST['m513r509']);
$m513r510 = strip_tags($_REQUEST['m513r510']);
$m513r599 = strip_tags($_REQUEST['m513r599']);

$m513r601 = strip_tags($_REQUEST['m513r601']);
$m513r602 = strip_tags($_REQUEST['m513r602']);
$m513r603 = strip_tags($_REQUEST['m513r603']);
$m513r604 = strip_tags($_REQUEST['m513r604']);
$m513r605 = strip_tags($_REQUEST['m513r605']);
$m513r606 = strip_tags($_REQUEST['m513r606']);
$m513r607 = strip_tags($_REQUEST['m513r607']);
$m513r608 = strip_tags($_REQUEST['m513r608']);
$m513r609 = strip_tags($_REQUEST['m513r609']);
$m513r610 = strip_tags($_REQUEST['m513r610']);
$m513r699 = strip_tags($_REQUEST['m513r699']);

$m581r01 = strip_tags($_REQUEST['m581r01']);
$m581r02 = strip_tags($_REQUEST['m581r02']);
$m581r99 = strip_tags($_REQUEST['m581r99']);

$m588r301 = strip_tags($_REQUEST['m588r301']);
$m588r302 = strip_tags($_REQUEST['m588r302']);
$m588r303 = strip_tags($_REQUEST['m588r303']);
$m588r304 = strip_tags($_REQUEST['m588r304']);
$m588r305 = strip_tags($_REQUEST['m588r305']);
$m588r306 = strip_tags($_REQUEST['m588r306']);
$m588r307 = strip_tags($_REQUEST['m588r307']);
$m588r308 = strip_tags($_REQUEST['m588r308']);
$m588r309 = strip_tags($_REQUEST['m588r309']);
$m588r310 = strip_tags($_REQUEST['m588r310']);

$m588r311 = strip_tags($_REQUEST['m588r311']);
$m588r312 = strip_tags($_REQUEST['m588r312']);
$m588r313 = strip_tags($_REQUEST['m588r313']);
$m588r314 = strip_tags($_REQUEST['m588r314']);
$m588r315 = strip_tags($_REQUEST['m588r315']);
$m588r316 = strip_tags($_REQUEST['m588r316']);
$m588r317 = strip_tags($_REQUEST['m588r317']);
$m588r318 = strip_tags($_REQUEST['m588r318']);
$m588r319 = strip_tags($_REQUEST['m588r319']);
$m588r320 = strip_tags($_REQUEST['m588r320']);

$m588r321 = strip_tags($_REQUEST['m588r321']);
$m588r322 = strip_tags($_REQUEST['m588r322']);
$m588r323 = strip_tags($_REQUEST['m588r323']);
$m588r324 = strip_tags($_REQUEST['m588r324']);
$m588r325 = strip_tags($_REQUEST['m588r325']);
$m588r326 = strip_tags($_REQUEST['m588r326']);
$m588r327 = strip_tags($_REQUEST['m588r327']);
$m588r328 = strip_tags($_REQUEST['m588r328']);
$m588r329 = strip_tags($_REQUEST['m588r329']);
$m588r330 = strip_tags($_REQUEST['m588r330']);

$m588r331 = strip_tags($_REQUEST['m588r331']);
$m588r332 = strip_tags($_REQUEST['m588r332']);
$m588r333 = strip_tags($_REQUEST['m588r333']);
$m588r334 = strip_tags($_REQUEST['m588r334']);
$m588r335 = strip_tags($_REQUEST['m588r335']);
$m588r336 = strip_tags($_REQUEST['m588r336']);
$m588r337 = strip_tags($_REQUEST['m588r337']);
$m588r338 = strip_tags($_REQUEST['m588r338']);
$m588r339 = strip_tags($_REQUEST['m588r339']);
$m588r340 = strip_tags($_REQUEST['m588r340']);

$m588r341 = strip_tags($_REQUEST['m588r341']);
$m588r342 = strip_tags($_REQUEST['m588r342']);
$m588r343 = strip_tags($_REQUEST['m588r343']);
$m588r344 = strip_tags($_REQUEST['m588r344']);
$m588r345 = strip_tags($_REQUEST['m588r345']);
$m588r346 = strip_tags($_REQUEST['m588r346']);
$m588r347 = strip_tags($_REQUEST['m588r347']);
$m588r348 = strip_tags($_REQUEST['m588r348']);
$m588r349 = strip_tags($_REQUEST['m588r349']);
$m588r350 = strip_tags($_REQUEST['m588r350']);
$m588r351 = strip_tags($_REQUEST['m588r351']);

$m588r201 = strip_tags($_REQUEST['m588r201']);
$m588r202 = strip_tags($_REQUEST['m588r202']);
$m588r203 = strip_tags($_REQUEST['m588r203']);
$m588r204 = strip_tags($_REQUEST['m588r204']);
$m588r205 = strip_tags($_REQUEST['m588r205']);
$m588r206 = strip_tags($_REQUEST['m588r206']);
$m588r207 = strip_tags($_REQUEST['m588r207']);
$m588r208 = strip_tags($_REQUEST['m588r208']);
$m588r209 = strip_tags($_REQUEST['m588r209']);
$m588r210 = strip_tags($_REQUEST['m588r210']);

$m588r211 = strip_tags($_REQUEST['m588r211']);
$m588r212 = strip_tags($_REQUEST['m588r212']);
$m588r213 = strip_tags($_REQUEST['m588r213']);
$m588r214 = strip_tags($_REQUEST['m588r214']);
$m588r215 = strip_tags($_REQUEST['m588r215']);
$m588r216 = strip_tags($_REQUEST['m588r216']);
$m588r217 = strip_tags($_REQUEST['m588r217']);
$m588r218 = strip_tags($_REQUEST['m588r218']);
$m588r219 = strip_tags($_REQUEST['m588r219']);
$m588r220 = strip_tags($_REQUEST['m588r220']);

$m588r221 = strip_tags($_REQUEST['m588r221']);
$m588r222 = strip_tags($_REQUEST['m588r222']);
$m588r223 = strip_tags($_REQUEST['m588r223']);
$m588r224 = strip_tags($_REQUEST['m588r224']);
$m588r225 = strip_tags($_REQUEST['m588r225']);
$m588r226 = strip_tags($_REQUEST['m588r226']);
$m588r227 = strip_tags($_REQUEST['m588r227']);
$m588r228 = strip_tags($_REQUEST['m588r228']);
$m588r229 = strip_tags($_REQUEST['m588r229']);
$m588r230 = strip_tags($_REQUEST['m588r230']);

$m588r231 = strip_tags($_REQUEST['m588r231']);
$m588r232 = strip_tags($_REQUEST['m588r232']);
$m588r233 = strip_tags($_REQUEST['m588r233']);
$m588r234 = strip_tags($_REQUEST['m588r234']);
$m588r235 = strip_tags($_REQUEST['m588r235']);
$m588r236 = strip_tags($_REQUEST['m588r236']);
$m588r237 = strip_tags($_REQUEST['m588r237']);
$m588r238 = strip_tags($_REQUEST['m588r238']);
$m588r239 = strip_tags($_REQUEST['m588r239']);
$m588r240 = strip_tags($_REQUEST['m588r240']);

$m588r241 = strip_tags($_REQUEST['m588r241']);
$m588r242 = strip_tags($_REQUEST['m588r242']);
$m588r243 = strip_tags($_REQUEST['m588r243']);
$m588r244 = strip_tags($_REQUEST['m588r244']);
$m588r245 = strip_tags($_REQUEST['m588r245']);
$m588r246 = strip_tags($_REQUEST['m588r246']);
$m588r247 = strip_tags($_REQUEST['m588r247']);
$m588r248 = strip_tags($_REQUEST['m588r248']);
$m588r249 = strip_tags($_REQUEST['m588r249']);
$m588r250 = strip_tags($_REQUEST['m588r250']);
$m588r251 = strip_tags($_REQUEST['m588r251']);

//7.strana
$m177r01 = strip_tags($_REQUEST['m177r01']);
$m177r02 = strip_tags($_REQUEST['m177r02']);
$m177r03 = strip_tags($_REQUEST['m177r03']);
$m177r04 = strip_tags($_REQUEST['m177r04']);
$m177r05 = strip_tags($_REQUEST['m177r05']);
$m177r06 = strip_tags($_REQUEST['m177r06']);
$m177r07 = strip_tags($_REQUEST['m177r07']);
$m177r08 = strip_tags($_REQUEST['m177r08']);
$m177r99 = strip_tags($_REQUEST['m177r99']);

//8.strana
$m178r01 = strip_tags($_REQUEST['m178r01']);
$m178r02 = strip_tags($_REQUEST['m178r02']);
$m178r03 = strip_tags($_REQUEST['m178r03']);
$m178r04 = strip_tags($_REQUEST['m178r04']);
$m178r05 = strip_tags($_REQUEST['m178r05']);
$m178r06 = strip_tags($_REQUEST['m178r06']);
$m178r07 = strip_tags($_REQUEST['m178r07']);
$m178r08 = strip_tags($_REQUEST['m178r08']);
$m178r09 = strip_tags($_REQUEST['m178r09']);
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
$m178r20 = strip_tags($_REQUEST['m178r20']);
$m178r21 = strip_tags($_REQUEST['m178r21']);
$m178r99 = strip_tags($_REQUEST['m178r99']);

$m179r01 = strip_tags($_REQUEST['m179r01']);
$m179r02 = strip_tags($_REQUEST['m179r02']);
$m179r99 = strip_tags($_REQUEST['m179r99']);

$m182r001 = strip_tags($_REQUEST['m182r001']);
$m182r002 = strip_tags($_REQUEST['m182r002']);
$m182r003 = strip_tags($_REQUEST['m182r003']);
$m182r004 = strip_tags($_REQUEST['m182r004']);
$m182r005 = strip_tags($_REQUEST['m182r005']);
$m182r006 = strip_tags($_REQUEST['m182r006']);
$m182r007 = strip_tags($_REQUEST['m182r007']);
$m182r099 = strip_tags($_REQUEST['m182r099']);

$m182r101 = strip_tags($_REQUEST['m182r101']);
$m182r102 = strip_tags($_REQUEST['m182r102']);
$m182r103 = strip_tags($_REQUEST['m182r103']);
$m182r104 = strip_tags($_REQUEST['m182r104']);
$m182r105 = strip_tags($_REQUEST['m182r105']);
$m182r106 = strip_tags($_REQUEST['m182r106']);
$m182r107 = strip_tags($_REQUEST['m182r107']);
$m182r199 = strip_tags($_REQUEST['m182r199']);

$m182r201 = strip_tags($_REQUEST['m182r201']);
$m182r202 = strip_tags($_REQUEST['m182r202']);
$m182r203 = strip_tags($_REQUEST['m182r203']);
$m182r204 = strip_tags($_REQUEST['m182r204']);
$m182r205 = strip_tags($_REQUEST['m182r205']);
$m182r206 = strip_tags($_REQUEST['m182r206']);
$m182r207 = strip_tags($_REQUEST['m182r207']);
$m182r299 = strip_tags($_REQUEST['m182r299']);

//9.strana
$m183r001 = strip_tags($_REQUEST['m183r001']);
$m183r002 = strip_tags($_REQUEST['m183r002']);
$m183r003 = strip_tags($_REQUEST['m183r003']);
$m183r004 = strip_tags($_REQUEST['m183r004']);
$m183r005 = strip_tags($_REQUEST['m183r005']);
$m183r006 = strip_tags($_REQUEST['m183r006']);
$m183r007 = strip_tags($_REQUEST['m183r007']);
$m183r008 = strip_tags($_REQUEST['m183r008']);
$m183r009 = strip_tags($_REQUEST['m183r009']);
$m183r010 = strip_tags($_REQUEST['m183r010']);
$m183r099 = strip_tags($_REQUEST['m183r099']);

$m183r101 = strip_tags($_REQUEST['m183r101']);
$m183r102 = strip_tags($_REQUEST['m183r102']);
$m183r103 = strip_tags($_REQUEST['m183r103']);
$m183r104 = strip_tags($_REQUEST['m183r104']);
$m183r105 = strip_tags($_REQUEST['m183r105']);
$m183r106 = strip_tags($_REQUEST['m183r106']);
$m183r107 = strip_tags($_REQUEST['m183r107']);
$m183r108 = strip_tags($_REQUEST['m183r108']);
$m183r109 = strip_tags($_REQUEST['m183r109']);
$m183r110 = strip_tags($_REQUEST['m183r110']);
$m183r199 = strip_tags($_REQUEST['m183r199']);

$m183r201 = strip_tags($_REQUEST['m183r201']);
$m183r202 = strip_tags($_REQUEST['m183r202']);
$m183r203 = strip_tags($_REQUEST['m183r203']);
$m183r204 = strip_tags($_REQUEST['m183r204']);
$m183r205 = strip_tags($_REQUEST['m183r205']);
$m183r206 = strip_tags($_REQUEST['m183r206']);
$m183r207 = strip_tags($_REQUEST['m183r207']);
$m183r208 = strip_tags($_REQUEST['m183r208']);
$m183r209 = strip_tags($_REQUEST['m183r209']);
$m183r210 = strip_tags($_REQUEST['m183r210']);
$m183r299 = strip_tags($_REQUEST['m183r299']);

$m184r001 = strip_tags($_REQUEST['m184r001']);
$m184r002 = strip_tags($_REQUEST['m184r002']);
$m184r003 = strip_tags($_REQUEST['m184r003']);
$m184r004 = strip_tags($_REQUEST['m184r004']);
$m184r005 = strip_tags($_REQUEST['m184r005']);
$m184r006 = strip_tags($_REQUEST['m184r006']);
$m184r007 = strip_tags($_REQUEST['m184r007']);
$m184r008 = strip_tags($_REQUEST['m184r008']);
$m184r009 = strip_tags($_REQUEST['m184r009']);
$m184r010 = strip_tags($_REQUEST['m184r010']);
$m184r099 = strip_tags($_REQUEST['m184r099']);

$m184r101 = strip_tags($_REQUEST['m184r101']);
$m184r102 = strip_tags($_REQUEST['m184r102']);
$m184r103 = strip_tags($_REQUEST['m184r103']);
$m184r104 = strip_tags($_REQUEST['m184r104']);
$m184r105 = strip_tags($_REQUEST['m184r105']);
$m184r106 = strip_tags($_REQUEST['m184r106']);
$m184r107 = strip_tags($_REQUEST['m184r107']);
$m184r108 = strip_tags($_REQUEST['m184r108']);
$m184r109 = strip_tags($_REQUEST['m184r109']);
$m184r110 = strip_tags($_REQUEST['m184r110']);
$m184r199 = strip_tags($_REQUEST['m184r199']);

$m184r201 = strip_tags($_REQUEST['m184r201']);
$m184r202 = strip_tags($_REQUEST['m184r202']);
$m184r203 = strip_tags($_REQUEST['m184r203']);
$m184r204 = strip_tags($_REQUEST['m184r204']);
$m184r205 = strip_tags($_REQUEST['m184r205']);
$m184r206 = strip_tags($_REQUEST['m184r206']);
$m184r207 = strip_tags($_REQUEST['m184r207']);
$m184r208 = strip_tags($_REQUEST['m184r208']);
$m184r209 = strip_tags($_REQUEST['m184r209']);
$m184r210 = strip_tags($_REQUEST['m184r210']);
$m184r299 = strip_tags($_REQUEST['m184r299']);

$m184r301 = strip_tags($_REQUEST['m184r301']);
$m184r302 = strip_tags($_REQUEST['m184r302']);
$m184r303 = strip_tags($_REQUEST['m184r303']);
$m184r304 = strip_tags($_REQUEST['m184r304']);
$m184r305 = strip_tags($_REQUEST['m184r305']);
$m184r306 = strip_tags($_REQUEST['m184r306']);
$m184r307 = strip_tags($_REQUEST['m184r307']);
$m184r308 = strip_tags($_REQUEST['m184r308']);
$m184r309 = strip_tags($_REQUEST['m184r309']);
$m184r310 = strip_tags($_REQUEST['m184r310']);
$m184r399 = strip_tags($_REQUEST['m184r399']);

//10.strana
$m185r001 = strip_tags($_REQUEST['m185r001']);
$m185r002 = strip_tags($_REQUEST['m185r002']);
$m185r003 = strip_tags($_REQUEST['m185r003']);
$m185r004 = strip_tags($_REQUEST['m185r004']);
$m185r005 = strip_tags($_REQUEST['m185r005']);
$m185r006 = strip_tags($_REQUEST['m185r006']);
$m185r007 = strip_tags($_REQUEST['m185r007']);
$m185r099 = strip_tags($_REQUEST['m185r099']);

$m185r101 = strip_tags($_REQUEST['m185r101']);
$m185r102 = strip_tags($_REQUEST['m185r102']);
$m185r103 = strip_tags($_REQUEST['m185r103']);
$m185r104 = strip_tags($_REQUEST['m185r104']);
$m185r105 = strip_tags($_REQUEST['m185r105']);
$m185r106 = strip_tags($_REQUEST['m185r106']);
$m185r107 = strip_tags($_REQUEST['m185r107']);
$m185r199 = strip_tags($_REQUEST['m185r199']);

$m185r201 = strip_tags($_REQUEST['m185r201']);
$m185r202 = strip_tags($_REQUEST['m185r202']);
$m185r203 = strip_tags($_REQUEST['m185r203']);
$m185r204 = strip_tags($_REQUEST['m185r204']);
$m185r205 = strip_tags($_REQUEST['m185r205']);
$m185r206 = strip_tags($_REQUEST['m185r206']);
$m185r207 = strip_tags($_REQUEST['m185r207']);
$m185r299 = strip_tags($_REQUEST['m185r299']);

$m185r301 = strip_tags($_REQUEST['m185r301']);
$m185r302 = strip_tags($_REQUEST['m185r302']);
$m185r303 = strip_tags($_REQUEST['m185r303']);
$m185r304 = strip_tags($_REQUEST['m185r304']);
$m185r305 = strip_tags($_REQUEST['m185r305']);
$m185r306 = strip_tags($_REQUEST['m185r306']);
$m185r307 = strip_tags($_REQUEST['m185r307']);
$m185r399 = strip_tags($_REQUEST['m185r399']);

$m186r001 = strip_tags($_REQUEST['m186r001']);
$m186r002 = strip_tags($_REQUEST['m186r002']);
$m186r003 = strip_tags($_REQUEST['m186r003']);
$m186r004 = strip_tags($_REQUEST['m186r004']);
$m186r005 = strip_tags($_REQUEST['m186r005']);
$m186r006 = strip_tags($_REQUEST['m186r006']);
$m186r007 = strip_tags($_REQUEST['m186r007']);
$m186r099 = strip_tags($_REQUEST['m186r099']);

$m186r101 = strip_tags($_REQUEST['m186r101']);
$m186r102 = strip_tags($_REQUEST['m186r102']);
$m186r103 = strip_tags($_REQUEST['m186r103']);
$m186r104 = strip_tags($_REQUEST['m186r104']);
$m186r105 = strip_tags($_REQUEST['m186r105']);
$m186r106 = strip_tags($_REQUEST['m186r106']);
$m186r107 = strip_tags($_REQUEST['m186r107']);
$m186r199 = strip_tags($_REQUEST['m186r199']);

$m186r201 = strip_tags($_REQUEST['m186r201']);
$m186r202 = strip_tags($_REQUEST['m186r202']);
$m186r203 = strip_tags($_REQUEST['m186r203']);
$m186r204 = strip_tags($_REQUEST['m186r204']);
$m186r205 = strip_tags($_REQUEST['m186r205']);
$m186r206 = strip_tags($_REQUEST['m186r206']);
$m186r207 = strip_tags($_REQUEST['m186r207']);
$m186r299 = strip_tags($_REQUEST['m186r299']);

$m186r301 = strip_tags($_REQUEST['m186r301']);
$m186r302 = strip_tags($_REQUEST['m186r302']);
$m186r303 = strip_tags($_REQUEST['m186r303']);
$m186r304 = strip_tags($_REQUEST['m186r304']);
$m186r305 = strip_tags($_REQUEST['m186r305']);
$m186r306 = strip_tags($_REQUEST['m186r306']);
$m186r307 = strip_tags($_REQUEST['m186r307']);
$m186r399 = strip_tags($_REQUEST['m186r399']);

$m304r01 = strip_tags($_REQUEST['m304r01']);
$m304r02 = strip_tags($_REQUEST['m304r02']);
$m304r03 = strip_tags($_REQUEST['m304r03']);
$m304r04 = strip_tags($_REQUEST['m304r04']);
$m304r05 = strip_tags($_REQUEST['m304r05']);
$m304r06 = strip_tags($_REQUEST['m304r06']);
$m304r99 = strip_tags($_REQUEST['m304r99']);

//11.strana
$m527r101 = strip_tags($_REQUEST['m527r101']);
$m527r102 = strip_tags($_REQUEST['m527r102']);
$m527r103 = strip_tags($_REQUEST['m527r103']);
$m527r104 = strip_tags($_REQUEST['m527r104']);

$m527r201 = strip_tags($_REQUEST['m527r201']);
$m527r202 = strip_tags($_REQUEST['m527r202']);
$m527r203 = strip_tags($_REQUEST['m527r203']);
$m527r204 = strip_tags($_REQUEST['m527r204']);

$m527r301 = strip_tags($_REQUEST['m527r301']);
$m527r302 = strip_tags($_REQUEST['m527r302']);
$m527r303 = strip_tags($_REQUEST['m527r303']);
$m527r304 = strip_tags($_REQUEST['m527r304']);

$m527r401 = strip_tags($_REQUEST['m527r401']);
$m527r402 = strip_tags($_REQUEST['m527r402']);
$m527r403 = strip_tags($_REQUEST['m527r403']);
$m527r404 = strip_tags($_REQUEST['m527r404']);

$m527r501 = strip_tags($_REQUEST['m527r501']);
$m527r502 = strip_tags($_REQUEST['m527r502']);
$m527r503 = strip_tags($_REQUEST['m527r503']);
$m527r504 = strip_tags($_REQUEST['m527r504']);

$m527r601 = strip_tags($_REQUEST['m527r601']);
$m527r602 = strip_tags($_REQUEST['m527r602']);
$m527r603 = strip_tags($_REQUEST['m527r603']);
$m527r604 = strip_tags($_REQUEST['m527r604']);

$m527r701 = strip_tags($_REQUEST['m527r701']);
$m527r702 = strip_tags($_REQUEST['m527r702']);
$m527r703 = strip_tags($_REQUEST['m527r703']);
$m527r704 = strip_tags($_REQUEST['m527r704']);

$m527r801 = strip_tags($_REQUEST['m527r801']);
$m527r802 = strip_tags($_REQUEST['m527r802']);
$m527r803 = strip_tags($_REQUEST['m527r803']);
$m527r804 = strip_tags($_REQUEST['m527r804']);

$m527r901 = strip_tags($_REQUEST['m527r901']);
$m527r902 = strip_tags($_REQUEST['m527r902']);
$m527r903 = strip_tags($_REQUEST['m527r903']);
$m527r904 = strip_tags($_REQUEST['m527r904']);

$m527r1001 = strip_tags($_REQUEST['m527r1001']);
$m527r1002 = strip_tags($_REQUEST['m527r1002']);
$m527r1003 = strip_tags($_REQUEST['m527r1003']);
$m527r1004 = strip_tags($_REQUEST['m527r1004']);

//12.strana
$m474r101 = strip_tags($_REQUEST['m474r101']);
$m474r102 = strip_tags($_REQUEST['m474r102']);
$m474r103 = strip_tags($_REQUEST['m474r103']);
$m474r104 = strip_tags($_REQUEST['m474r104']);
$m474r105 = strip_tags($_REQUEST['m474r105']);
$m474r106 = strip_tags($_REQUEST['m474r106']);
$m474r107 = strip_tags($_REQUEST['m474r107']);
$m474r199 = strip_tags($_REQUEST['m474r199']);

$m474r201 = strip_tags($_REQUEST['m474r201']);
$m474r202 = strip_tags($_REQUEST['m474r202']);
$m474r203 = strip_tags($_REQUEST['m474r203']);
$m474r204 = strip_tags($_REQUEST['m474r204']);
$m474r205 = strip_tags($_REQUEST['m474r205']);
$m474r206 = strip_tags($_REQUEST['m474r206']);
$m474r207 = strip_tags($_REQUEST['m474r207']);
$m474r299 = strip_tags($_REQUEST['m474r299']);

$m474r301 = strip_tags($_REQUEST['m474r301']);
$m474r302 = strip_tags($_REQUEST['m474r302']);
$m474r303 = strip_tags($_REQUEST['m474r303']);
$m474r304 = strip_tags($_REQUEST['m474r304']);
$m474r305 = strip_tags($_REQUEST['m474r305']);
$m474r306 = strip_tags($_REQUEST['m474r306']);
$m474r307 = strip_tags($_REQUEST['m474r307']);
$m474r399 = strip_tags($_REQUEST['m474r399']);

//13.strana
$m127r001 = strip_tags($_REQUEST['m127r001']);
$m127r002 = strip_tags($_REQUEST['m127r002']);
$m127r003 = strip_tags($_REQUEST['m127r003']);
$m127r004 = strip_tags($_REQUEST['m127r004']);
$m127r005 = strip_tags($_REQUEST['m127r005']);
$m127r006 = strip_tags($_REQUEST['m127r006']);
$m127r007 = strip_tags($_REQUEST['m127r007']);
$m127r008 = strip_tags($_REQUEST['m127r008']);
$m127r009 = strip_tags($_REQUEST['m127r009']);
$m127r010 = strip_tags($_REQUEST['m127r010']);
$m127r011 = strip_tags($_REQUEST['m127r011']);
$m127r012 = strip_tags($_REQUEST['m127r012']);
$m127r013 = strip_tags($_REQUEST['m127r013']);
$m127r014 = strip_tags($_REQUEST['m127r014']);
$m127r015 = strip_tags($_REQUEST['m127r015']);
$m127r099 = strip_tags($_REQUEST['m127r099']);

$m127r101 = strip_tags($_REQUEST['m127r101']);
$m127r102 = strip_tags($_REQUEST['m127r102']);
$m127r103 = strip_tags($_REQUEST['m127r103']);
$m127r104 = strip_tags($_REQUEST['m127r104']);
$m127r105 = strip_tags($_REQUEST['m127r105']);
$m127r106 = strip_tags($_REQUEST['m127r106']);
$m127r107 = strip_tags($_REQUEST['m127r107']);
$m127r108 = strip_tags($_REQUEST['m127r108']);
$m127r109 = strip_tags($_REQUEST['m127r109']);
$m127r110 = strip_tags($_REQUEST['m127r110']);
$m127r111 = strip_tags($_REQUEST['m127r111']);
$m127r112 = strip_tags($_REQUEST['m127r112']);
$m127r113 = strip_tags($_REQUEST['m127r113']);
$m127r114 = strip_tags($_REQUEST['m127r114']);
$m127r115 = strip_tags($_REQUEST['m127r115']);
$m127r199 = strip_tags($_REQUEST['m127r199']);

$m127r201 = strip_tags($_REQUEST['m127r201']);
$m127r202 = strip_tags($_REQUEST['m127r202']);
$m127r203 = strip_tags($_REQUEST['m127r203']);
$m127r204 = strip_tags($_REQUEST['m127r204']);
$m127r205 = strip_tags($_REQUEST['m127r205']);
$m127r206 = strip_tags($_REQUEST['m127r206']);
$m127r207 = strip_tags($_REQUEST['m127r207']);
$m127r208 = strip_tags($_REQUEST['m127r208']);
$m127r209 = strip_tags($_REQUEST['m127r209']);
$m127r210 = strip_tags($_REQUEST['m127r210']);
$m127r211 = strip_tags($_REQUEST['m127r211']);
$m127r212 = strip_tags($_REQUEST['m127r212']);
$m127r213 = strip_tags($_REQUEST['m127r213']);
$m127r214 = strip_tags($_REQUEST['m127r214']);
$m127r215 = strip_tags($_REQUEST['m127r215']);
$m127r299 = strip_tags($_REQUEST['m127r299']);

$m127r301 = strip_tags($_REQUEST['m127r301']);
$m127r302 = strip_tags($_REQUEST['m127r302']);
$m127r303 = strip_tags($_REQUEST['m127r303']);
$m127r304 = strip_tags($_REQUEST['m127r304']);
$m127r305 = strip_tags($_REQUEST['m127r305']);
$m127r306 = strip_tags($_REQUEST['m127r306']);
$m127r307 = strip_tags($_REQUEST['m127r307']);
$m127r308 = strip_tags($_REQUEST['m127r308']);
$m127r309 = strip_tags($_REQUEST['m127r309']);
$m127r310 = strip_tags($_REQUEST['m127r310']);
$m127r311 = strip_tags($_REQUEST['m127r311']);
$m127r312 = strip_tags($_REQUEST['m127r312']);
$m127r313 = strip_tags($_REQUEST['m127r313']);
$m127r314 = strip_tags($_REQUEST['m127r314']);
$m127r315 = strip_tags($_REQUEST['m127r315']);
$m127r399 = strip_tags($_REQUEST['m127r399']);

$m127r401 = strip_tags($_REQUEST['m127r401']);
$m127r402 = strip_tags($_REQUEST['m127r402']);
$m127r403 = strip_tags($_REQUEST['m127r403']);
$m127r404 = strip_tags($_REQUEST['m127r404']);
$m127r405 = strip_tags($_REQUEST['m127r405']);
$m127r406 = strip_tags($_REQUEST['m127r406']);
$m127r407 = strip_tags($_REQUEST['m127r407']);
$m127r408 = strip_tags($_REQUEST['m127r408']);
$m127r409 = strip_tags($_REQUEST['m127r409']);
$m127r410 = strip_tags($_REQUEST['m127r410']);
$m127r411 = strip_tags($_REQUEST['m127r411']);
$m127r412 = strip_tags($_REQUEST['m127r412']);
$m127r413 = strip_tags($_REQUEST['m127r413']);
$m127r414 = strip_tags($_REQUEST['m127r414']);
$m127r415 = strip_tags($_REQUEST['m127r415']);
$m127r499 = strip_tags($_REQUEST['m127r499']);

$m127r501 = strip_tags($_REQUEST['m127r501']);
$m127r502 = strip_tags($_REQUEST['m127r502']);
$m127r503 = strip_tags($_REQUEST['m127r503']);
$m127r504 = strip_tags($_REQUEST['m127r504']);
$m127r505 = strip_tags($_REQUEST['m127r505']);
$m127r506 = strip_tags($_REQUEST['m127r506']);
$m127r507 = strip_tags($_REQUEST['m127r507']);
$m127r508 = strip_tags($_REQUEST['m127r508']);
$m127r509 = strip_tags($_REQUEST['m127r509']);
$m127r510 = strip_tags($_REQUEST['m127r510']);
$m127r511 = strip_tags($_REQUEST['m127r511']);
$m127r512 = strip_tags($_REQUEST['m127r512']);
$m127r513 = strip_tags($_REQUEST['m127r513']);
$m127r514 = strip_tags($_REQUEST['m127r514']);
$m127r515 = strip_tags($_REQUEST['m127r515']);
$m127r599 = strip_tags($_REQUEST['m127r599']);

$m127r601 = strip_tags($_REQUEST['m127r601']);
$m127r602 = strip_tags($_REQUEST['m127r602']);
$m127r603 = strip_tags($_REQUEST['m127r603']);
$m127r604 = strip_tags($_REQUEST['m127r604']);
$m127r605 = strip_tags($_REQUEST['m127r605']);
$m127r606 = strip_tags($_REQUEST['m127r606']);
$m127r607 = strip_tags($_REQUEST['m127r607']);
$m127r608 = strip_tags($_REQUEST['m127r608']);
$m127r609 = strip_tags($_REQUEST['m127r609']);
$m127r610 = strip_tags($_REQUEST['m127r610']);
$m127r611 = strip_tags($_REQUEST['m127r611']);
$m127r612 = strip_tags($_REQUEST['m127r612']);
$m127r613 = strip_tags($_REQUEST['m127r613']);
$m127r614 = strip_tags($_REQUEST['m127r614']);
$m127r615 = strip_tags($_REQUEST['m127r615']);
$m127r699 = strip_tags($_REQUEST['m127r699']);


//14.strana
$m128r101 = strip_tags($_REQUEST['m128r101']);
$m128r102 = strip_tags($_REQUEST['m128r102']);
$m128r103 = strip_tags($_REQUEST['m128r103']);
$m128r104 = strip_tags($_REQUEST['m128r104']);
$m128r105 = strip_tags($_REQUEST['m128r105']);
$m128r106 = strip_tags($_REQUEST['m128r106']);
$m128r107 = strip_tags($_REQUEST['m128r107']);
$m128r108 = strip_tags($_REQUEST['m128r108']);
$m128r109 = strip_tags($_REQUEST['m128r109']);
$m128r110 = strip_tags($_REQUEST['m128r110']);
$m128r111 = strip_tags($_REQUEST['m128r111']);
$m128r199 = strip_tags($_REQUEST['m128r199']);

$m128r201 = strip_tags($_REQUEST['m128r201']);
$m128r202 = strip_tags($_REQUEST['m128r202']);
$m128r203 = strip_tags($_REQUEST['m128r203']);
$m128r204 = strip_tags($_REQUEST['m128r204']);
$m128r205 = strip_tags($_REQUEST['m128r205']);
$m128r206 = strip_tags($_REQUEST['m128r206']);
$m128r207 = strip_tags($_REQUEST['m128r207']);
$m128r208 = strip_tags($_REQUEST['m128r208']);
$m128r209 = strip_tags($_REQUEST['m128r209']);
$m128r210 = strip_tags($_REQUEST['m128r210']);
$m128r211 = strip_tags($_REQUEST['m128r211']);
$m128r299 = strip_tags($_REQUEST['m128r299']);

$m128r301 = strip_tags($_REQUEST['m128r301']);
$m128r302 = strip_tags($_REQUEST['m128r302']);
$m128r303 = strip_tags($_REQUEST['m128r303']);
$m128r304 = strip_tags($_REQUEST['m128r304']);
$m128r305 = strip_tags($_REQUEST['m128r305']);
$m128r306 = strip_tags($_REQUEST['m128r306']);
$m128r307 = strip_tags($_REQUEST['m128r307']);
$m128r308 = strip_tags($_REQUEST['m128r308']);
$m128r309 = strip_tags($_REQUEST['m128r309']);
$m128r310 = strip_tags($_REQUEST['m128r310']);
$m128r311 = strip_tags($_REQUEST['m128r311']);
$m128r399 = strip_tags($_REQUEST['m128r399']);

$m128r401 = strip_tags($_REQUEST['m128r401']);
$m128r402 = strip_tags($_REQUEST['m128r402']);
$m128r403 = strip_tags($_REQUEST['m128r403']);
$m128r404 = strip_tags($_REQUEST['m128r404']);
$m128r405 = strip_tags($_REQUEST['m128r405']);
$m128r406 = strip_tags($_REQUEST['m128r406']);
$m128r407 = strip_tags($_REQUEST['m128r407']);
$m128r408 = strip_tags($_REQUEST['m128r408']);
$m128r409 = strip_tags($_REQUEST['m128r409']);
$m128r410 = strip_tags($_REQUEST['m128r410']);
$m128r411 = strip_tags($_REQUEST['m128r411']);
$m128r499 = strip_tags($_REQUEST['m128r499']);

$m128r501 = strip_tags($_REQUEST['m128r501']);
$m128r502 = strip_tags($_REQUEST['m128r502']);
$m128r503 = strip_tags($_REQUEST['m128r503']);
$m128r504 = strip_tags($_REQUEST['m128r504']);
$m128r505 = strip_tags($_REQUEST['m128r505']);
$m128r506 = strip_tags($_REQUEST['m128r506']);
$m128r507 = strip_tags($_REQUEST['m128r507']);
$m128r508 = strip_tags($_REQUEST['m128r508']);
$m128r509 = strip_tags($_REQUEST['m128r509']);
$m128r510 = strip_tags($_REQUEST['m128r510']);
$m128r511 = strip_tags($_REQUEST['m128r511']);
$m128r599 = strip_tags($_REQUEST['m128r599']);
$uprav="NO";

if ( $strana == 1 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" odoslane='$odoslane_sql', mod100041ano='$mod100041ano', mod100041nie='$mod100041nie', ".
" mod100042ano='$mod100042ano', mod100042nie='$mod100042nie', ".
" mod100043ano='$mod100043ano', mod100043nie='$mod100043nie'  ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 2 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" mod100038='$mod100038', mod100039='$mod100039', mod100040='$mod100040', mod100089='$mod100089', ".
" mod100090='$mod100090', mod100091='$mod100091', mod100037='$mod100037', ".
" mod100036kal='$mod100036kal', mod100036hos='$mod100036hos', mod100069ano='$mod100069ano', mod100069nie='$mod100069nie', ".
" mod100086ano='$mod100086ano', mod100086nie='$mod100086nie', mod100087ano='$mod100087ano', mod100087nie='$mod100087nie', ".
" mod100088ano='$mod100088ano', mod100088nie='$mod100088nie' ".
" WHERE ico >= 0";
                    }

if ( $strana == 3 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" mod2r01='$mod2r01', mod2r02='$mod2r02', ".
" m398r01='$m398r01', m398r02='$m398r02', m398r99='$m398r99', ".
" m405r01='$m405r01', m405r02='$m405r02', m405r03='$m405r03', m405r04='$m405r04', m405r05='$m405r05', m405r06='$m405r06', m405r99='$m405r99', ". 
" m558r01='$m558r01', m558r02='$m558r02', m558r03='$m558r03', m558r04='$m558r04', m558r05='$m558r05', m558r06='$m558r06', m558r99='$m558r99'  ". 
" WHERE ico >= 0";
                    }

if ( $strana == 4 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m580r11='$m580r11', m580r12='$m580r12', m580r199='$m580r199', ". 
" m580r21='$m580r21', m580r22='$m580r22', m580r299='$m580r299', ".
" m586r11='$m586r11', m586r12='$m586r12', m586r13='$m586r13', m586r14='$m586r14', m586r199='$m586r199', ".
" m586r21='$m586r21', m586r22='$m586r22', m586r23='$m586r23', m586r24='$m586r24', m586r299='$m586r299', ".
" m100062ano='$m100062ano', m100062nie='$m100062nie', ".
" m100044ano='$m100044ano', m100044nie='$m100044nie', ".
" m585r01='$m585r01', m585r02='$m585r02', m585r03='$m585r03', m585r04='$m585r04', m585r05='$m585r05', ".
" m585r3k='$m585r3k', m585r4k='$m585r4k', m585r5k='$m585r5k' ".
" WHERE ico >= 0";
                    }

if ( $strana == 5 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m571r10='$m571r10', m571r12='$m571r12', m571r13='$m571r13', m571r15='$m571r15', ".
" m571r16='$m571r16', m571r17='$m571r17', m571r18='$m571r18', ".
" m571r20='$m571r20', m571r22='$m571r22', m571r23='$m571r23', m571r25='$m571r25', ".
" m571r26='$m571r26', m571r27='$m571r27', m571r28='$m571r28', ".
" m571r30='$m571r30', m571r32='$m571r32', m571r33='$m571r33', m571r35='$m571r35', ".
" m571r36='$m571r36', m571r37='$m571r37', m571r38='$m571r38', ".
" m571r40='$m571r40', m571r42='$m571r42', m571r43='$m571r43', m571r45='$m571r45', ".
" m571r46='$m571r46', m571r47='$m571r47', m571r48='$m571r48', ".
" m571r50='$m571r50', m571r52='$m571r52', m571r53='$m571r53', m571r55='$m571r55', ".
" m571r56='$m571r56', m571r57='$m571r57', m571r58='$m571r58', ".
" m571r60='$m571r60', m571r62='$m571r62', m571r63='$m571r63', m571r65='$m571r65', ".
" m571r66='$m571r66', m571r67='$m571r67', m571r68='$m571r68', ".
" m571r70='$m571r70', m571r72='$m571r72', m571r73='$m571r73', m571r75='$m571r75', ".
" m571r76='$m571r76', m571r77='$m571r77', m571r78='$m571r78', ".
" m571r80='$m571r80', m571r82='$m571r82', m571r83='$m571r83', m571r85='$m571r85', ".
" m571r86='$m571r86', m571r87='$m571r87', m571r88='$m571r88', ".
" m571r90='$m571r90', m571r92='$m571r92', m571r93='$m571r93', m571r95='$m571r95', ".
" m571r96='$m571r96', m571r97='$m571r97', m571r98='$m571r98', ".
" m516r101='$m516r101', m516r102='$m516r102', m516r103='$m516r103', m516r104='$m516r104', m516r105='$m516r105', ".
" m516r106='$m516r106', m516r107='$m516r107', m516r108='$m516r108', m516r109='$m516r109', m516r110='$m516r110', ".
" m516r111='$m516r111', m516r112='$m516r112', m516r113='$m516r113', m516r114='$m516r114', m516r199='$m516r199', ".
" m516r201='$m516r201', m516r202='$m516r202', m516r203='$m516r203', m516r204='$m516r204', m516r205='$m516r205', ".
" m516r206='$m516r206', m516r207='$m516r207', m516r208='$m516r208', m516r209='$m516r209', m516r210='$m516r210', ".
" m516r211='$m516r211', m516r212='$m516r212', m516r213='$m516r213', m516r214='$m516r214', m516r299='$m516r299'  ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 6 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m588r201='$m588r201', m588r202='$m588r202', m588r203='$m588r203', m588r204='$m588r204', m588r205='$m588r205', ".
" m588r206='$m588r206', m588r207='$m588r207', m588r208='$m588r208', m588r209='$m588r209', m588r210='$m588r210', ".
" m588r211='$m588r211', m588r212='$m588r212', m588r213='$m588r213', m588r214='$m588r214', m588r215='$m588r215', ".
" m588r216='$m588r216', m588r217='$m588r217', m588r218='$m588r218', m588r219='$m588r219', m588r220='$m588r220', ".

" m588r301='$m588r301', m588r302='$m588r302', m588r303='$m588r303', m588r304='$m588r304', m588r305='$m588r305', ".
" m588r306='$m588r306', m588r307='$m588r307', m588r308='$m588r308', m588r309='$m588r309', m588r310='$m588r310', ".
" m588r311='$m588r311', m588r312='$m588r312', m588r313='$m588r313', m588r314='$m588r314', m588r315='$m588r315', ".
" m588r316='$m588r316', m588r317='$m588r317', m588r318='$m588r318', m588r319='$m588r319', m588r320='$m588r320', ".
" m581r01='$m581r01', m581r02='$m581r02', m581r99='$m581r99',".
" m513r101='$m513r101', m513r102='$m513r102', m513r103='$m513r103', m513r104='$m513r104', m513r105='$m513r105', ".
" m513r106='$m513r106', m513r107='$m513r107', m513r108='$m513r108', m513r109='$m513r109', m513r110='$m513r110', ".
" m513r199='$m513r199', ".
" m513r201='$m513r201', m513r202='$m513r202', m513r203='$m513r203', m513r204='$m513r204', m513r205='$m513r205', ".
" m513r206='$m513r206', m513r207='$m513r207', m513r208='$m513r208', m513r209='$m513r209', m513r210='$m513r210', ".
" m513r299='$m513r299', ".
" m513r301='$m513r301', m513r302='$m513r302', m513r303='$m513r303', m513r304='$m513r304', m513r305='$m513r305', ".
" m513r306='$m513r306', m513r307='$m513r307', m513r308='$m513r308', m513r309='$m513r309', m513r310='$m513r310', ".
" m513r399='$m513r399', ".
" m513r401='$m513r401', m513r402='$m513r402', m513r403='$m513r403', m513r404='$m513r404', m513r405='$m513r405', ".
" m513r406='$m513r406', m513r407='$m513r407', m513r408='$m513r408', m513r409='$m513r409', m513r410='$m513r410', ".
" m513r499='$m513r499', ".
" m513r501='$m513r501', m513r502='$m513r502', m513r503='$m513r503', m513r504='$m513r504', m513r505='$m513r505', ".
" m513r506='$m513r506', m513r507='$m513r507', m513r508='$m513r508', m513r509='$m513r509', m513r510='$m513r510', ".
" m513r599='$m513r599', ".
" m513r601='$m513r601', m513r602='$m513r602', m513r603='$m513r603', m513r604='$m513r604', m513r605='$m513r605', ".
" m513r606='$m513r606', m513r607='$m513r607', m513r608='$m513r608', m513r609='$m513r609', m513r610='$m513r610', ".
" m513r699='$m513r699' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 7 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m177r01='$m177r01', m177r02='$m177r02', m177r03='$m177r03', m177r04='$m177r04', m177r05='$m177r05', ".
" m177r06='$m177r06', m177r07='$m177r07', m177r08='$m177r08', m177r99='$m177r99',  ".

" m588r221='$m588r221', m588r222='$m588r222', m588r223='$m588r223', m588r224='$m588r224', m588r225='$m588r225', ".
" m588r226='$m588r226', m588r227='$m588r227', m588r228='$m588r228', m588r229='$m588r229', m588r230='$m588r230', ".
" m588r231='$m588r231', m588r232='$m588r232', m588r233='$m588r233', m588r234='$m588r234', m588r235='$m588r235', ".
" m588r236='$m588r236', m588r237='$m588r237', m588r238='$m588r238', m588r239='$m588r239', m588r240='$m588r240', ".
" m588r241='$m588r241', m588r242='$m588r242', m588r243='$m588r243', m588r244='$m588r244', m588r245='$m588r245', ".
" m588r246='$m588r246', m588r247='$m588r247', m588r248='$m588r248', m588r249='$m588r249', m588r250='$m588r250', m588r251='$m588r251', ".

" m588r321='$m588r321', m588r322='$m588r322', m588r323='$m588r323', m588r324='$m588r324', m588r325='$m588r325', ".
" m588r326='$m588r326', m588r327='$m588r327', m588r328='$m588r328', m588r329='$m588r329', m588r330='$m588r330', ".
" m588r331='$m588r331', m588r332='$m588r332', m588r333='$m588r333', m588r334='$m588r334', m588r335='$m588r335', ".
" m588r336='$m588r336', m588r337='$m588r337', m588r338='$m588r338', m588r339='$m588r339', m588r340='$m588r340', ".
" m588r341='$m588r341', m588r342='$m588r342', m588r343='$m588r343', m588r344='$m588r344', m588r345='$m588r345', ".
" m588r346='$m588r346', m588r347='$m588r347', m588r348='$m588r348', m588r349='$m588r349', m588r350='$m588r350', m588r351='$m588r351'  ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 8 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m182r001='$m182r001', m182r002='$m182r002', m182r003='$m182r003', m182r004='$m182r004', m182r005='$m182r005', ".
" m182r006='$m182r006', m182r007='$m182r007', ".
" m182r101='$m182r101', m182r102='$m182r102', m182r103='$m182r103', m182r104='$m182r104', m182r105='$m182r105', ".
" m182r106='$m182r106', m182r107='$m182r107', ".
" m182r201='$m182r201', m182r202='$m182r202', m182r203='$m182r203', m182r204='$m182r204', m182r205='$m182r205', ".
" m182r206='$m182r206', m182r207='$m182r207', m182r299='$m182r299', ".

" m179r01='$m179r01', m179r02='$m179r02',  m179r99='$m179r99', ".

" m178r01='$m178r01', m178r02='$m178r02', m178r03='$m178r03', m178r04='$m178r04', m178r05='$m178r05', ".
" m178r06='$m178r06', m178r07='$m178r07', m178r08='$m178r08', m178r09='$m178r09', m178r10='$m178r10', ".
" m178r11='$m178r11', m178r12='$m178r12', m178r13='$m178r13', m178r14='$m178r14', m178r15='$m178r15', ".
" m178r16='$m178r16', m178r17='$m178r17', m178r18='$m178r18', m178r19='$m178r19', m178r20='$m178r20', m178r21='$m178r21',  m178r99='$m178r99' ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 9 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m183r001='$m183r001', m183r002='$m183r002', m183r003='$m183r003', m183r004='$m183r004', m183r005='$m183r005', ".
" m183r006='$m183r006', m183r007='$m183r007', m183r008='$m183r008', m183r009='$m183r009', m183r010='$m183r010', ".
" m183r101='$m183r101', m183r102='$m183r102', m183r103='$m183r103', m183r104='$m183r104', m183r105='$m183r105', ".
" m183r106='$m183r106', m183r107='$m183r107', m183r108='$m183r108', m183r109='$m183r109', m183r110='$m183r110', ".
" m183r201='$m183r201', m183r202='$m183r202', m183r203='$m183r203', m183r204='$m183r204', m183r205='$m183r205', ".
" m183r206='$m183r206', m183r207='$m183r207', m183r208='$m183r208', m183r209='$m183r209', m183r210='$m183r210', m183r299='$m183r299',  ".

" m184r001='$m184r001', m184r002='$m184r002', m184r003='$m184r003', m184r004='$m184r004', m184r005='$m184r005', ".
" m184r006='$m184r006', m184r007='$m184r007', m184r008='$m184r008', m184r009='$m184r009', m184r010='$m184r010', ".
" m184r101='$m184r101', m184r102='$m184r102', m184r103='$m184r103', m184r104='$m184r104', m184r105='$m184r105', ".
" m184r106='$m184r106', m184r107='$m184r107', m184r108='$m184r108', m184r109='$m184r109', m184r110='$m184r110', ".
" m184r201='$m184r201', m184r202='$m184r202', m184r203='$m184r203', m184r204='$m184r204', m184r205='$m184r205', ".
" m184r206='$m184r206', m184r207='$m184r207', m184r208='$m184r208', m184r209='$m184r209', m184r210='$m184r210', m184r299='$m184r299', ".
" m184r301='$m184r301', m184r302='$m184r302', m184r303='$m184r303', m184r304='$m184r304', m184r305='$m184r305', ".
" m184r306='$m184r306', m184r307='$m184r307', m184r308='$m184r308', m184r309='$m184r309', m184r310='$m184r310', m184r399='$m184r399'  ".
" WHERE ico >= 0 ";
                    }

if ( $strana == 10 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m304r01='$m304r01', m304r02='$m304r02', m304r03='$m304r03', m304r04='$m304r04', m304r05='$m304r05', ".
" m304r06='$m304r06', m304r99='$m304r99', ".

" m185r001='$m185r001', m185r002='$m185r002', m185r003='$m185r003', m185r004='$m185r004', m185r005='$m185r005', ".
" m185r006='$m185r006', m185r007='$m185r007', ".
" m185r101='$m185r101', m185r102='$m185r102', m185r103='$m185r103', m185r104='$m185r104', m185r105='$m185r105', ".
" m185r106='$m185r106', m185r107='$m185r107', ".
" m185r201='$m185r201', m185r202='$m185r202', m185r203='$m185r203', m185r204='$m185r204', m185r205='$m185r205', ".
" m185r206='$m185r206', m185r207='$m185r207', m185r299='$m185r299', ".
" m185r301='$m185r301', m185r302='$m185r302', m185r303='$m185r303', m185r304='$m185r304', m185r305='$m185r305', ".
" m185r306='$m185r306', m185r307='$m185r307', m185r399='$m185r399', ".
" m186r001='$m186r001', m186r002='$m186r002', m186r003='$m186r003', m186r004='$m186r004', m186r005='$m186r005', ".
" m186r006='$m186r006', m186r007='$m186r007', ".
" m186r101='$m186r101', m186r102='$m186r102', m186r103='$m186r103', m186r104='$m186r104', m186r105='$m186r105', ".
" m186r106='$m186r106', m186r107='$m186r107', ".
" m186r201='$m186r201', m186r202='$m186r202', m186r203='$m186r203', m186r204='$m186r204', m186r205='$m186r205', ".
" m186r206='$m186r206', m186r207='$m186r207', m186r299='$m186r299', ".
" m186r301='$m186r301', m186r302='$m186r302', m186r303='$m186r303', m186r304='$m186r304', m186r305='$m186r305', ".
" m186r306='$m186r306', m186r307='$m186r307', m186r399='$m186r399'  ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 11 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m527r101='$m527r101', m527r102='$m527r102', m527r103='$m527r103', m527r104='$m527r104', ".
" m527r201='$m527r201', m527r202='$m527r202', m527r203='$m527r203', m527r204='$m527r204', ".
" m527r301='$m527r301', m527r302='$m527r302', m527r303='$m527r303', m527r304='$m527r304', ".
" m527r401='$m527r401', m527r402='$m527r402', m527r403='$m527r403', m527r404='$m527r404', ".
" m527r501='$m527r501', m527r502='$m527r502', m527r503='$m527r503', m527r504='$m527r504', ".
" m527r601='$m527r601', m527r602='$m527r602', m527r603='$m527r603', m527r604='$m527r604', ".
" m527r701='$m527r701', m527r702='$m527r702', m527r703='$m527r703', m527r704='$m527r704', ".
" m527r801='$m527r801', m527r802='$m527r802', m527r803='$m527r803', m527r804='$m527r804', ".
" m527r901='$m527r901', m527r902='$m527r902', m527r903='$m527r903', m527r904='$m527r904', ".
" m527r1001='$m527r1001', m527r1002='$m527r1002', m527r1003='$m527r1003', m527r1004='$m527r1004' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 12 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m474r101='$m474r101', m474r102='$m474r102', m474r103='$m474r103', m474r104='$m474r104', m474r105='$m474r105', ".
" m474r106='$m474r106', m474r107='$m474r107', m474r199='$m474r199', ".
" m474r201='$m474r201', m474r202='$m474r202', m474r203='$m474r203', m474r204='$m474r204', m474r205='$m474r205', ".
" m474r206='$m474r206', m474r207='$m474r207', m474r299='$m474r299', ".
" m474r301='$m474r301', m474r302='$m474r302', m474r303='$m474r303', m474r304='$m474r304', m474r305='$m474r305', ".
" m474r306='$m474r306', m474r307='$m474r307', m474r399='$m474r399'  ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 13 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m127r001='$m127r001', m127r002='$m127r002', m127r003='$m127r003', m127r004='$m127r004', m127r005='$m127r005', ".
" m127r006='$m127r006', m127r007='$m127r007', m127r008='$m127r008', m127r009='$m127r009', m127r010='$m127r010', ".
" m127r011='$m127r011', m127r012='$m127r012', m127r013='$m127r013', m127r014='$m127r014', m127r015='$m127r015', ".

" m127r101='$m127r101', m127r102='$m127r102', m127r103='$m127r103', m127r104='$m127r104', m127r105='$m127r105', ".
" m127r106='$m127r106', m127r107='$m127r107', m127r108='$m127r108', m127r109='$m127r109', m127r110='$m127r110', ".
" m127r111='$m127r111', m127r112='$m127r112', m127r113='$m127r113', m127r114='$m127r114', m127r115='$m127r115', ".

" m127r201='$m127r201', m127r202='$m127r202', m127r203='$m127r203', m127r204='$m127r204', m127r205='$m127r205', ".
" m127r206='$m127r206', m127r207='$m127r207', m127r208='$m127r208', m127r209='$m127r209', m127r210='$m127r210', ".
" m127r211='$m127r211', m127r212='$m127r212', m127r213='$m127r213', m127r214='$m127r214', m127r215='$m127r215', m127r299='$m127r299', ".

" m127r301='$m127r301', m127r302='$m127r302', m127r303='$m127r303', m127r304='$m127r304', m127r305='$m127r305', ".
" m127r306='$m127r306', m127r307='$m127r307', m127r308='$m127r308', m127r309='$m127r309', m127r310='$m127r310', ".
" m127r311='$m127r311', m127r312='$m127r312', m127r313='$m127r313', m127r314='$m127r314', m127r315='$m127r315', m127r399='$m127r399', ".

" m127r401='$m127r401', m127r402='$m127r402', m127r403='$m127r403', m127r404='$m127r404', m127r405='$m127r405', ".
" m127r406='$m127r406', m127r407='$m127r407', m127r408='$m127r408', m127r409='$m127r409', m127r410='$m127r410', ".
" m127r411='$m127r411', m127r412='$m127r412', m127r413='$m127r413', m127r414='$m127r414', m127r415='$m127r415', m127r499='$m127r499', ".

" m127r501='$m127r501', m127r502='$m127r502', m127r503='$m127r503', m127r504='$m127r504', m127r505='$m127r505', ".
" m127r506='$m127r506', m127r507='$m127r507', m127r508='$m127r508', m127r509='$m127r509', m127r510='$m127r510', ".
" m127r511='$m127r511', m127r512='$m127r512', m127r513='$m127r513', m127r514='$m127r514', m127r515='$m127r515', m127r599='$m127r599', ".

" m127r601='$m127r601', m127r602='$m127r602', m127r603='$m127r603', m127r604='$m127r604', m127r605='$m127r605', ".
" m127r606='$m127r606', m127r607='$m127r607', m127r608='$m127r608', m127r609='$m127r609', m127r610='$m127r610', ".
" m127r611='$m127r611', m127r612='$m127r612', m127r613='$m127r613', m127r614='$m127r614', m127r615='$m127r615', m127r699='$m127r699' ".
" WHERE ico >= 0 ";
                     }

if ( $strana == 14 ) {
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".

" m128r101='$m128r101', m128r102='$m128r102', m128r103='$m128r103', m128r104='$m128r104', m128r105='$m128r105', ".
" m128r106='$m128r106', m128r107='$m128r107', m128r108='$m128r108', m128r109='$m128r109', m128r110='$m128r110', ".
" m128r111='$m128r111', m128r199='$m128r199', ".

" m128r201='$m128r201', m128r202='$m128r202', m128r203='$m128r203', m128r204='$m128r204', m128r205='$m128r205', ".
" m128r206='$m128r206', m128r207='$m128r207', m128r208='$m128r208', m128r209='$m128r209', m128r210='$m128r210', ".
" m128r211='$m128r211', m128r299='$m128r299', ".

" m128r301='$m128r301', m128r302='$m128r302', m128r303='$m128r303', m128r304='$m128r304', m128r305='$m128r305', ".
" m128r306='$m128r306', m128r307='$m128r307', m128r308='$m128r308', m128r309='$m128r309', m128r310='$m128r310', ".
" m128r311='$m128r311', m128r399='$m128r399', ".

" m128r401='$m128r401', m128r402='$m128r402', m128r403='$m128r403', m128r404='$m128r404', m128r405='$m128r405', ".
" m128r406='$m128r406', m128r407='$m128r407', m128r408='$m128r408', m128r409='$m128r409', m128r410='$m128r410', ".
" m128r411='$m128r411', m128r499='$m128r499', ".

" m128r501='$m128r501', m128r502='$m128r502', m128r503='$m128r503', m128r504='$m128r504', m128r505='$m128r505', ".
" m128r506='$m128r506', m128r507='$m128r507', m128r508='$m128r508', m128r509='$m128r509', m128r510='$m128r510', ".
" m128r511='$m128r511', m128r599='$m128r599'  ".
" WHERE ico >= 0 ";
                     }


//echo $uprtxt;
$upravene = mysql_query("$uprtxt");
$copern=102;
if (!$upravene):
?>
<script type="text/javascript"> alert( "�DAJE NEBOLI UPRAVEN�" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
     }
//koniec zapisu upravenych udajov


//vypocty
//3.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m398r99=m398r01+m398r02, ".
" m405r99=m405r01+m405r02+m405r03+m405r04+m405r05+m405r06, ".
" m558r99=m558r01+m558r02+m558r03+m558r04+m558r05+m558r06  ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt"); 

//4.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m580r199=m580r11+m580r12, m580r299=m580r21+m580r22, ".
" m586r199=m586r11+m586r12+m586r13+m586r14, m586r299=m586r21+m586r22+m586r23+m586r24  ".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//5.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m516r199=m516r101+m516r102+m516r103+m516r104+m516r105+m516r106+m516r107+m516r108+m516r109+m516r110+m516r111+m516r112+m516r113+m516r114, ". 
" m516r299=m516r201+m516r202+m516r203+m516r204+m516r205+m516r206+m516r207+m516r208+m516r209+m516r210+m516r211+m516r212+m516r213+m516r214  ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//6.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m581r99=m581r01+m581r02, ".
" m513r199=m513r101+m513r102+m513r103+m513r104+m513r105+m513r106+m513r107+m513r108+m513r109+m513r110, ". 
" m513r299=m513r201+m513r202+m513r203+m513r204+m513r205+m513r206+m513r207+m513r208+m513r209+m513r210, ".
" m513r399=m513r301+m513r302+m513r303+m513r304+m513r305+m513r306+m513r307+m513r308+m513r309+m513r310, ".
" m513r499=m513r401+m513r402+m513r403+m513r404+m513r405+m513r406+m513r407+m513r408+m513r409+m513r410, ".
" m513r599=m513r501+m513r502+m513r503+m513r504+m513r505+m513r506+m513r507+m513r508+m513r509+m513r510, ".
" m513r699=m513r601+m513r602+m513r603+m513r604+m513r605+m513r606+m513r607+m513r608+m513r609+m513r610  ".  
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//7.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m177r99=m177r01+m177r02+m177r03+m177r04+m177r05+m177r06+m177r07+m177r08 ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//8.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m178r99=m178r01+m178r02+m178r03+m178r04+m178r05+m178r06+m178r07+m178r08+m178r09+m178r10  ".
" +m178r11+m178r12+m178r13+m178r14+m178r15+m178r16+m178r17+m178r18+m178r19+m178r20+m178r21, ". 
" m179r99=m179r01+m179r02, ".
" m182r299=m182r201+m182r202+m182r203+m182r204+m182r205+m182r206+m182r207 ".     
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//9.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m183r299=m183r201+m183r202+m183r203+m183r204+m183r205+m183r206+m183r207+m183r208+m183r209+m183r210, ".
" m184r299=m184r201+m184r202+m184r203+m184r204+m184r205+m184r206+m184r207+m184r208+m184r209+m184r210, ".     
" m184r399=m184r301+m184r302+m184r303+m184r304+m184r305+m184r306+m184r307+m184r308+m184r309+m184r310  ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//10.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m304r99=m304r01+m304r02+m304r03+m304r04+m304r05+m304r06,  ".
" m185r299=m185r201+m185r202+m185r203+m185r204+m185r205+m185r206+m185r207, ".     
" m185r399=m185r301+m185r302+m185r303+m185r304+m185r305+m185r306+m185r307, ". 
" m186r299=m186r201+m186r202+m186r203+m186r204+m186r205+m186r206+m186r207, ".     
" m186r399=m186r301+m186r302+m186r303+m186r304+m186r305+m186r306+m186r307  ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//12.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m474r199=m474r101+m474r102+m474r103+m474r104+m474r105+m474r106+m474r107, ".
" m474r299=m474r201+m474r202+m474r203+m474r204+m474r205+m474r206+m474r207, ".
" m474r399=m474r301+m474r302+m474r303+m474r304+m474r305+m474r306+m474r307  ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//13.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m127r299=m127r201+m127r202+m127r203+m127r204+m127r205+m127r206+m127r207+m127r208+m127r209+m127r210+m127r211+m127r212+m127r213+m127r214+m127r215, ". 
" m127r399=m127r301+m127r302+m127r303+m127r304+m127r305+m127r306+m127r307+m127r308+m127r309+m127r310+m127r311+m127r312+m127r313+m127r314+m127r315, ". 
" m127r499=m127r401+m127r402+m127r403+m127r404+m127r405+m127r406+m127r407+m127r408+m127r409+m127r410+m127r411+m127r412+m127r413+m127r414+m127r415, ". 
" m127r599=m127r501+m127r502+m127r503+m127r504+m127r505+m127r506+m127r507+m127r508+m127r509+m127r510+m127r511+m127r512+m127r513+m127r514+m127r515, ". 
" m127r699=m127r601+m127r602+m127r603+m127r604+m127r605+m127r606+m127r607+m127r608+m127r609+m127r610+m127r611+m127r612+m127r613+m127r614+m127r615  ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//14.strana
$uprtxt = "UPDATE F$kli_vxcf"."_statistika_opu201 SET ".
" m128r299=m128r201+m128r202+m128r203+m128r204+m128r205+m128r206+m128r207+m128r208+m128r209+m128r210+m128r211, ". 
" m128r399=m128r301+m128r302+m128r303+m128r304+m128r305+m128r306+m128r307+m128r308+m128r309+m128r310+m128r311, ". 
" m128r499=m128r401+m128r402+m128r403+m128r404+m128r405+m128r406+m128r407+m128r408+m128r409+m128r410+m128r411, ". 
" m128r599=m128r501+m128r502+m128r503+m128r504+m128r505+m128r506+m128r507+m128r508+m128r509+m128r510+m128r511, ". 
" m128r199=m128r101+m128r102+m128r103+m128r104+m128r105+m128r106+m128r107+m128r108+m128r109+m128r110+m128r111  ". 
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");

//" mod545r99=mod545r01+mod545r02+mod545r03+mod545r04+mod545r05+mod545r06+mod545r07+mod545r08+mod545r09+mod545r10+mod545r11 ". 
//koniec vypocty

//toto urobim
//nacitaj udaje
if ( $copern >= 1 )
     {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_statistika_opu201 WHERE ico >= 0";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$odoslane_sk = SkDatum($fir_riadok->odoslane);

$mod100041ano = $fir_riadok->mod100041ano;
$mod100041nie = $fir_riadok->mod100041nie;
$mod100042ano = $fir_riadok->mod100042ano;
$mod100042nie = $fir_riadok->mod100042nie;
$mod100043ano = $fir_riadok->mod100043ano;
$mod100043nie = $fir_riadok->mod100043nie;

//2.strana
$mod100038 = $fir_riadok->mod100038;
$mod100039 = $fir_riadok->mod100039;
$mod100040 = $fir_riadok->mod100040;
$mod100036kal = $fir_riadok->mod100036kal;
$mod100036hos = $fir_riadok->mod100036hos;
$mod100037 = $fir_riadok->mod100037;
$mod100069ano = $fir_riadok->mod100069ano;
$mod100069nie = $fir_riadok->mod100069nie;
$mod100086ano = $fir_riadok->mod100086ano;
$mod100086nie = $fir_riadok->mod100086nie;
$mod100087ano = $fir_riadok->mod100087ano;
$mod100087nie = $fir_riadok->mod100087nie;
$mod100088ano = $fir_riadok->mod100088ano;
$mod100088nie = $fir_riadok->mod100088nie;
$mod100089 = $fir_riadok->mod100089;
$mod100090 = $fir_riadok->mod100090;
$mod100091 = $fir_riadok->mod100091;

//3.strana
$mod2r01 = $fir_riadok->mod2r01;
$mod2r02 = $fir_riadok->mod2r02;

$m398r01 = $fir_riadok->m398r01;
$m398r02 = $fir_riadok->m398r02;
$m398r99 = $fir_riadok->m398r99;

$m405r01 = $fir_riadok->m405r01;
$m405r02 = $fir_riadok->m405r02;
$m405r03 = $fir_riadok->m405r03;
$m405r04 = $fir_riadok->m405r04;
$m405r05 = $fir_riadok->m405r05;
$m405r06 = $fir_riadok->m405r06;
$m405r99 = $fir_riadok->m405r99;

$m558r01 = $fir_riadok->m558r01;
$m558r02 = $fir_riadok->m558r02;
$m558r03 = $fir_riadok->m558r03;
$m558r04 = $fir_riadok->m558r04;
$m558r05 = $fir_riadok->m558r05;
$m558r06 = $fir_riadok->m558r06;
$m558r99 = $fir_riadok->m558r99;

//4.strana
$m580r11 = $fir_riadok->m580r11;
$m580r12 = $fir_riadok->m580r12;
$m580r199 = $fir_riadok->m580r199;
$m580r21 = $fir_riadok->m580r21;
$m580r22 = $fir_riadok->m580r22;
$m580r299 = $fir_riadok->m580r299;
$m586r11 = $fir_riadok->m586r11;
$m586r12 = $fir_riadok->m586r12;
$m586r13 = $fir_riadok->m586r13;
$m586r14 = $fir_riadok->m586r14;
$m586r199 = $fir_riadok->m586r199;
$m586r21 = $fir_riadok->m586r21;
$m586r22 = $fir_riadok->m586r22;
$m586r23 = $fir_riadok->m586r23;
$m586r24 = $fir_riadok->m586r24;
$m586r299 = $fir_riadok->m586r299;
$m100062ano = $fir_riadok->m100062ano;
$m100062nie = $fir_riadok->m100062nie;
$m100044ano = $fir_riadok->m100044ano;
$m100044nie = $fir_riadok->m100044nie;
$m585r01 = $fir_riadok->m585r01;
$m585r02 = $fir_riadok->m585r02;
$m585r03 = $fir_riadok->m585r03;
$m585r04 = $fir_riadok->m585r04;
$m585r05 = $fir_riadok->m585r05;
$m585r3k = $fir_riadok->m585r3k;
$m585r4k = $fir_riadok->m585r4k;
$m585r5k = $fir_riadok->m585r5k;

//5.strana
$m516r101 = $fir_riadok->m516r101;
$m516r102 = $fir_riadok->m516r102;
$m516r103 = $fir_riadok->m516r103;
$m516r104 = $fir_riadok->m516r104;
$m516r105 = $fir_riadok->m516r105;
$m516r106 = $fir_riadok->m516r106;
$m516r107 = $fir_riadok->m516r107;
$m516r108 = $fir_riadok->m516r108;
$m516r109 = $fir_riadok->m516r109;
$m516r110 = $fir_riadok->m516r110;
$m516r111 = $fir_riadok->m516r111;
$m516r112 = $fir_riadok->m516r112;
$m516r113 = $fir_riadok->m516r113;
$m516r114 = $fir_riadok->m516r114;
$m516r199 = $fir_riadok->m516r199;
$m516r201 = $fir_riadok->m516r201;
$m516r202 = $fir_riadok->m516r202;
$m516r203 = $fir_riadok->m516r203;
$m516r204 = $fir_riadok->m516r204;
$m516r205 = $fir_riadok->m516r205;
$m516r206 = $fir_riadok->m516r206;
$m516r207 = $fir_riadok->m516r207;
$m516r208 = $fir_riadok->m516r208;
$m516r209 = $fir_riadok->m516r209;
$m516r210 = $fir_riadok->m516r210;
$m516r211 = $fir_riadok->m516r211;
$m516r212 = $fir_riadok->m516r212;
$m516r213 = $fir_riadok->m516r213;
$m516r214 = $fir_riadok->m516r214;
$m516r299 = $fir_riadok->m516r299;

$m571r10 = $fir_riadok->m571r10;
$m571r12 = $fir_riadok->m571r12;
$m571r13 = $fir_riadok->m571r13;
$m571r14 = $fir_riadok->m571r14;
$m571r15 = $fir_riadok->m571r15;
$m571r16 = $fir_riadok->m571r16;
$m571r17 = $fir_riadok->m571r17;
$m571r18 = $fir_riadok->m571r18;
$m571r20 = $fir_riadok->m571r20;
$m571r22 = $fir_riadok->m571r22;
$m571r23 = $fir_riadok->m571r23;
$m571r24 = $fir_riadok->m571r24;
$m571r25 = $fir_riadok->m571r25;
$m571r26 = $fir_riadok->m571r26;
$m571r27 = $fir_riadok->m571r27;
$m571r28 = $fir_riadok->m571r28;
$m571r30 = $fir_riadok->m571r30;
$m571r32 = $fir_riadok->m571r32;
$m571r33 = $fir_riadok->m571r33;
$m571r34 = $fir_riadok->m571r34;
$m571r35 = $fir_riadok->m571r35;
$m571r36 = $fir_riadok->m571r36;
$m571r37 = $fir_riadok->m571r37;
$m571r38 = $fir_riadok->m571r38;
$m571r40 = $fir_riadok->m571r40;
$m571r42 = $fir_riadok->m571r42;
$m571r43 = $fir_riadok->m571r43;
$m571r44 = $fir_riadok->m571r44;
$m571r45 = $fir_riadok->m571r45;
$m571r46 = $fir_riadok->m571r46;
$m571r47 = $fir_riadok->m571r47;
$m571r48 = $fir_riadok->m571r48;
$m571r50 = $fir_riadok->m571r50;
$m571r52 = $fir_riadok->m571r52;
$m571r53 = $fir_riadok->m571r53;
$m571r54 = $fir_riadok->m571r54;
$m571r55 = $fir_riadok->m571r55;
$m571r56 = $fir_riadok->m571r56;
$m571r57 = $fir_riadok->m571r57;
$m571r58 = $fir_riadok->m571r58;
$m571r60 = $fir_riadok->m571r60;
$m571r62 = $fir_riadok->m571r62;
$m571r63 = $fir_riadok->m571r63;
$m571r64 = $fir_riadok->m571r64;
$m571r65 = $fir_riadok->m571r65;
$m571r66 = $fir_riadok->m571r66;
$m571r67 = $fir_riadok->m571r67;
$m571r68 = $fir_riadok->m571r68;
$m571r70 = $fir_riadok->m571r70;
$m571r72 = $fir_riadok->m571r72;
$m571r73 = $fir_riadok->m571r73;
$m571r74 = $fir_riadok->m571r74;
$m571r75 = $fir_riadok->m571r75;
$m571r76 = $fir_riadok->m571r76;
$m571r77 = $fir_riadok->m571r77;
$m571r78 = $fir_riadok->m571r78;
$m571r80 = $fir_riadok->m571r80;
$m571r82 = $fir_riadok->m571r82;
$m571r83 = $fir_riadok->m571r83;
$m571r84 = $fir_riadok->m571r84;
$m571r85 = $fir_riadok->m571r85;
$m571r86 = $fir_riadok->m571r86;
$m571r87 = $fir_riadok->m571r87;
$m571r88 = $fir_riadok->m571r88;
$m571r90 = $fir_riadok->m571r90;
$m571r92 = $fir_riadok->m571r92;
$m571r93 = $fir_riadok->m571r93;
$m571r94 = $fir_riadok->m571r94;
$m571r95 = $fir_riadok->m571r95;
$m571r96 = $fir_riadok->m571r96;
$m571r97 = $fir_riadok->m571r97;
$m571r98 = $fir_riadok->m571r98;

//6.strana
$m513r101 = $fir_riadok->m513r101;
$m513r102 = $fir_riadok->m513r102;
$m513r103 = $fir_riadok->m513r103;
$m513r104 = $fir_riadok->m513r104;
$m513r105 = $fir_riadok->m513r105;
$m513r106 = $fir_riadok->m513r106;
$m513r107 = $fir_riadok->m513r107;
$m513r108 = $fir_riadok->m513r108;
$m513r109 = $fir_riadok->m513r109;
$m513r110 = $fir_riadok->m513r110;
$m513r199 = $fir_riadok->m513r199;

$m513r201 = $fir_riadok->m513r201;
$m513r202 = $fir_riadok->m513r202;
$m513r203 = $fir_riadok->m513r203;
$m513r204 = $fir_riadok->m513r204;
$m513r205 = $fir_riadok->m513r205;
$m513r206 = $fir_riadok->m513r206;
$m513r207 = $fir_riadok->m513r207;
$m513r208 = $fir_riadok->m513r208;
$m513r209 = $fir_riadok->m513r209;
$m513r210 = $fir_riadok->m513r210;
$m513r299 = $fir_riadok->m513r299;

$m513r301 = $fir_riadok->m513r301;
$m513r302 = $fir_riadok->m513r302;
$m513r303 = $fir_riadok->m513r303;
$m513r304 = $fir_riadok->m513r304;
$m513r305 = $fir_riadok->m513r305;
$m513r306 = $fir_riadok->m513r306;
$m513r307 = $fir_riadok->m513r307;
$m513r308 = $fir_riadok->m513r308;
$m513r309 = $fir_riadok->m513r309;
$m513r310 = $fir_riadok->m513r310;
$m513r399 = $fir_riadok->m513r399;

$m513r401 = $fir_riadok->m513r401;
$m513r402 = $fir_riadok->m513r402;
$m513r403 = $fir_riadok->m513r403;
$m513r404 = $fir_riadok->m513r404;
$m513r405 = $fir_riadok->m513r405;
$m513r406 = $fir_riadok->m513r406;
$m513r407 = $fir_riadok->m513r407;
$m513r408 = $fir_riadok->m513r408;
$m513r409 = $fir_riadok->m513r409;
$m513r410 = $fir_riadok->m513r410;
$m513r499 = $fir_riadok->m513r499;

$m513r501 = $fir_riadok->m513r501;
$m513r502 = $fir_riadok->m513r502;
$m513r503 = $fir_riadok->m513r503;
$m513r504 = $fir_riadok->m513r504;
$m513r505 = $fir_riadok->m513r505;
$m513r506 = $fir_riadok->m513r506;
$m513r507 = $fir_riadok->m513r507;
$m513r508 = $fir_riadok->m513r508;
$m513r509 = $fir_riadok->m513r509;
$m513r510 = $fir_riadok->m513r510;
$m513r599 = $fir_riadok->m513r599;

$m513r601 = $fir_riadok->m513r601;
$m513r602 = $fir_riadok->m513r602;
$m513r603 = $fir_riadok->m513r603;
$m513r604 = $fir_riadok->m513r604;
$m513r605 = $fir_riadok->m513r605;
$m513r606 = $fir_riadok->m513r606;
$m513r607 = $fir_riadok->m513r607;
$m513r608 = $fir_riadok->m513r608;
$m513r609 = $fir_riadok->m513r609;
$m513r610 = $fir_riadok->m513r610;
$m513r699 = $fir_riadok->m513r699;

$m581r01 = $fir_riadok->m581r01;
$m581r02 = $fir_riadok->m581r02;
$m581r99 = $fir_riadok->m581r99;

$m588r301 = $fir_riadok->m588r301;
$m588r302 = $fir_riadok->m588r302;
$m588r303 = $fir_riadok->m588r303;
$m588r304 = $fir_riadok->m588r304;
$m588r305 = $fir_riadok->m588r305;
$m588r306 = $fir_riadok->m588r306;
$m588r307 = $fir_riadok->m588r307;
$m588r308 = $fir_riadok->m588r308;
$m588r309 = $fir_riadok->m588r309;
$m588r310 = $fir_riadok->m588r310;

$m588r311 = $fir_riadok->m588r311;
$m588r312 = $fir_riadok->m588r312;
$m588r313 = $fir_riadok->m588r313;
$m588r314 = $fir_riadok->m588r314;
$m588r315 = $fir_riadok->m588r315;
$m588r316 = $fir_riadok->m588r316;
$m588r317 = $fir_riadok->m588r317;
$m588r318 = $fir_riadok->m588r318;
$m588r319 = $fir_riadok->m588r319;
$m588r320 = $fir_riadok->m588r320;

$m588r321 = $fir_riadok->m588r321;
$m588r322 = $fir_riadok->m588r322;
$m588r323 = $fir_riadok->m588r323;
$m588r324 = $fir_riadok->m588r324;
$m588r325 = $fir_riadok->m588r325;
$m588r326 = $fir_riadok->m588r326;
$m588r327 = $fir_riadok->m588r327;
$m588r328 = $fir_riadok->m588r328;
$m588r329 = $fir_riadok->m588r329;
$m588r330 = $fir_riadok->m588r330;

$m588r331 = $fir_riadok->m588r331;
$m588r332 = $fir_riadok->m588r332;
$m588r333 = $fir_riadok->m588r333;
$m588r334 = $fir_riadok->m588r334;
$m588r335 = $fir_riadok->m588r335;
$m588r336 = $fir_riadok->m588r336;
$m588r337 = $fir_riadok->m588r337;
$m588r338 = $fir_riadok->m588r338;
$m588r339 = $fir_riadok->m588r339;
$m588r340 = $fir_riadok->m588r340;

$m588r341 = $fir_riadok->m588r341;
$m588r342 = $fir_riadok->m588r342;
$m588r343 = $fir_riadok->m588r343;
$m588r344 = $fir_riadok->m588r344;
$m588r345 = $fir_riadok->m588r345;
$m588r346 = $fir_riadok->m588r346;
$m588r347 = $fir_riadok->m588r347;
$m588r348 = $fir_riadok->m588r348;
$m588r349 = $fir_riadok->m588r349;
$m588r350 = $fir_riadok->m588r350;
$m588r351 = $fir_riadok->m588r351;

$m588r201 = $fir_riadok->m588r201;
$m588r202 = $fir_riadok->m588r202;
$m588r203 = $fir_riadok->m588r203;
$m588r204 = $fir_riadok->m588r204;
$m588r205 = $fir_riadok->m588r205;
$m588r206 = $fir_riadok->m588r206;
$m588r207 = $fir_riadok->m588r207;
$m588r208 = $fir_riadok->m588r208;
$m588r209 = $fir_riadok->m588r209;
$m588r210 = $fir_riadok->m588r210;

$m588r211 = $fir_riadok->m588r211;
$m588r212 = $fir_riadok->m588r212;
$m588r213 = $fir_riadok->m588r213;
$m588r214 = $fir_riadok->m588r214;
$m588r215 = $fir_riadok->m588r215;
$m588r216 = $fir_riadok->m588r216;
$m588r217 = $fir_riadok->m588r217;
$m588r218 = $fir_riadok->m588r218;
$m588r219 = $fir_riadok->m588r219;
$m588r220 = $fir_riadok->m588r220;

$m588r221 = $fir_riadok->m588r221;
$m588r222 = $fir_riadok->m588r222;
$m588r223 = $fir_riadok->m588r223;
$m588r224 = $fir_riadok->m588r224;
$m588r225 = $fir_riadok->m588r225;
$m588r226 = $fir_riadok->m588r226;
$m588r227 = $fir_riadok->m588r227;
$m588r228 = $fir_riadok->m588r228;
$m588r229 = $fir_riadok->m588r229;
$m588r230 = $fir_riadok->m588r230;

$m588r231 = $fir_riadok->m588r231;
$m588r232 = $fir_riadok->m588r232;
$m588r233 = $fir_riadok->m588r233;
$m588r234 = $fir_riadok->m588r234;
$m588r235 = $fir_riadok->m588r235;
$m588r236 = $fir_riadok->m588r236;
$m588r237 = $fir_riadok->m588r237;
$m588r238 = $fir_riadok->m588r238;
$m588r239 = $fir_riadok->m588r239;
$m588r240 = $fir_riadok->m588r240;

$m588r241 = $fir_riadok->m588r241;
$m588r242 = $fir_riadok->m588r242;
$m588r243 = $fir_riadok->m588r243;
$m588r244 = $fir_riadok->m588r244;
$m588r245 = $fir_riadok->m588r245;
$m588r246 = $fir_riadok->m588r246;
$m588r247 = $fir_riadok->m588r247;
$m588r248 = $fir_riadok->m588r248;
$m588r249 = $fir_riadok->m588r249;
$m588r250 = $fir_riadok->m588r250;
$m588r251 = $fir_riadok->m588r251;

//7.strana
$m177r01 = $fir_riadok->m177r01;
$m177r02 = $fir_riadok->m177r02;
$m177r03 = $fir_riadok->m177r03;
$m177r04 = $fir_riadok->m177r04;
$m177r05 = $fir_riadok->m177r05;
$m177r06 = $fir_riadok->m177r06;
$m177r07 = $fir_riadok->m177r07;
$m177r08 = $fir_riadok->m177r08;
$m177r99 = $fir_riadok->m177r99;

//8.strana
$m178r01 = $fir_riadok->m178r01;
$m178r02 = $fir_riadok->m178r02;
$m178r03 = $fir_riadok->m178r03;
$m178r04 = $fir_riadok->m178r04;
$m178r05 = $fir_riadok->m178r05;
$m178r06 = $fir_riadok->m178r06;
$m178r07 = $fir_riadok->m178r07;
$m178r08 = $fir_riadok->m178r08;
$m178r09 = $fir_riadok->m178r09;
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
$m178r20 = $fir_riadok->m178r20;
$m178r21 = $fir_riadok->m178r21;
$m178r99 = $fir_riadok->m178r99;

$m179r01 = $fir_riadok->m179r01;
$m179r02 = $fir_riadok->m179r02;
$m179r99 = $fir_riadok->m179r99;

$m182r001 = $fir_riadok->m182r001;
$m182r002 = $fir_riadok->m182r002;
$m182r003 = $fir_riadok->m182r003;
$m182r004 = $fir_riadok->m182r004;
$m182r005 = $fir_riadok->m182r005;
$m182r006 = $fir_riadok->m182r006;
$m182r007 = $fir_riadok->m182r007;
$m182r099 = $fir_riadok->m182r099;

$m182r101 = $fir_riadok->m182r101;
$m182r102 = $fir_riadok->m182r102;
$m182r103 = $fir_riadok->m182r103;
$m182r104 = $fir_riadok->m182r104;
$m182r105 = $fir_riadok->m182r105;
$m182r106 = $fir_riadok->m182r106;
$m182r107 = $fir_riadok->m182r107;
$m182r199 = $fir_riadok->m182r199;

$m182r201 = $fir_riadok->m182r201;
$m182r202 = $fir_riadok->m182r202;
$m182r203 = $fir_riadok->m182r203;
$m182r204 = $fir_riadok->m182r204;
$m182r205 = $fir_riadok->m182r205;
$m182r206 = $fir_riadok->m182r206;
$m182r207 = $fir_riadok->m182r207;
$m182r299 = $fir_riadok->m182r299;

//9.strana
$m183r001 = $fir_riadok->m183r001;
$m183r002 = $fir_riadok->m183r002;
$m183r003 = $fir_riadok->m183r003;
$m183r004 = $fir_riadok->m183r004;
$m183r005 = $fir_riadok->m183r005;
$m183r006 = $fir_riadok->m183r006;
$m183r007 = $fir_riadok->m183r007;
$m183r008 = $fir_riadok->m183r008;
$m183r009 = $fir_riadok->m183r009;
$m183r010 = $fir_riadok->m183r010;
$m183r099 = $fir_riadok->m183r099;

$m183r101 = $fir_riadok->m183r101;
$m183r102 = $fir_riadok->m183r102;
$m183r103 = $fir_riadok->m183r103;
$m183r104 = $fir_riadok->m183r104;
$m183r105 = $fir_riadok->m183r105;
$m183r106 = $fir_riadok->m183r106;
$m183r107 = $fir_riadok->m183r107;
$m183r108 = $fir_riadok->m183r108;
$m183r109 = $fir_riadok->m183r109;
$m183r110 = $fir_riadok->m183r110;
$m183r199 = $fir_riadok->m183r199;

$m183r201 = $fir_riadok->m183r201;
$m183r202 = $fir_riadok->m183r202;
$m183r203 = $fir_riadok->m183r203;
$m183r204 = $fir_riadok->m183r204;
$m183r205 = $fir_riadok->m183r205;
$m183r206 = $fir_riadok->m183r206;
$m183r207 = $fir_riadok->m183r207;
$m183r208 = $fir_riadok->m183r208;
$m183r209 = $fir_riadok->m183r209;
$m183r210 = $fir_riadok->m183r210;
$m183r299 = $fir_riadok->m183r299;

$m184r001 = $fir_riadok->m184r001;
$m184r002 = $fir_riadok->m184r002;
$m184r003 = $fir_riadok->m184r003;
$m184r004 = $fir_riadok->m184r004;
$m184r005 = $fir_riadok->m184r005;
$m184r006 = $fir_riadok->m184r006;
$m184r007 = $fir_riadok->m184r007;
$m184r008 = $fir_riadok->m184r008;
$m184r009 = $fir_riadok->m184r009;
$m184r010 = $fir_riadok->m184r010;
$m184r099 = $fir_riadok->m184r099;

$m184r101 = $fir_riadok->m184r101;
$m184r102 = $fir_riadok->m184r102;
$m184r103 = $fir_riadok->m184r103;
$m184r104 = $fir_riadok->m184r104;
$m184r105 = $fir_riadok->m184r105;
$m184r106 = $fir_riadok->m184r106;
$m184r107 = $fir_riadok->m184r107;
$m184r108 = $fir_riadok->m184r108;
$m184r109 = $fir_riadok->m184r109;
$m184r110 = $fir_riadok->m184r110;
$m184r199 = $fir_riadok->m184r199;

$m184r201 = $fir_riadok->m184r201;
$m184r202 = $fir_riadok->m184r202;
$m184r203 = $fir_riadok->m184r203;
$m184r204 = $fir_riadok->m184r204;
$m184r205 = $fir_riadok->m184r205;
$m184r206 = $fir_riadok->m184r206;
$m184r207 = $fir_riadok->m184r207;
$m184r208 = $fir_riadok->m184r208;
$m184r209 = $fir_riadok->m184r209;
$m184r210 = $fir_riadok->m184r210;
$m184r299 = $fir_riadok->m184r299;

$m184r301 = $fir_riadok->m184r301;
$m184r302 = $fir_riadok->m184r302;
$m184r303 = $fir_riadok->m184r303;
$m184r304 = $fir_riadok->m184r304;
$m184r305 = $fir_riadok->m184r305;
$m184r306 = $fir_riadok->m184r306;
$m184r307 = $fir_riadok->m184r307;
$m184r308 = $fir_riadok->m184r308;
$m184r309 = $fir_riadok->m184r309;
$m184r310 = $fir_riadok->m184r310;
$m184r399 = $fir_riadok->m184r399;

//10.strana
$m185r001 = $fir_riadok->m185r001;
$m185r002 = $fir_riadok->m185r002;
$m185r003 = $fir_riadok->m185r003;
$m185r004 = $fir_riadok->m185r004;
$m185r005 = $fir_riadok->m185r005;
$m185r006 = $fir_riadok->m185r006;
$m185r007 = $fir_riadok->m185r007;
$m185r099 = $fir_riadok->m185r099;

$m185r101 = $fir_riadok->m185r101;
$m185r102 = $fir_riadok->m185r102;
$m185r103 = $fir_riadok->m185r103;
$m185r104 = $fir_riadok->m185r104;
$m185r105 = $fir_riadok->m185r105;
$m185r106 = $fir_riadok->m185r106;
$m185r107 = $fir_riadok->m185r107;
$m185r199 = $fir_riadok->m185r199;

$m185r201 = $fir_riadok->m185r201;
$m185r202 = $fir_riadok->m185r202;
$m185r203 = $fir_riadok->m185r203;
$m185r204 = $fir_riadok->m185r204;
$m185r205 = $fir_riadok->m185r205;
$m185r206 = $fir_riadok->m185r206;
$m185r207 = $fir_riadok->m185r207;
$m185r299 = $fir_riadok->m185r299;

$m185r301 = $fir_riadok->m185r301;
$m185r302 = $fir_riadok->m185r302;
$m185r303 = $fir_riadok->m185r303;
$m185r304 = $fir_riadok->m185r304;
$m185r305 = $fir_riadok->m185r305;
$m185r306 = $fir_riadok->m185r306;
$m185r307 = $fir_riadok->m185r307;
$m185r399 = $fir_riadok->m185r399;

$m186r001 = $fir_riadok->m186r001;
$m186r002 = $fir_riadok->m186r002;
$m186r003 = $fir_riadok->m186r003;
$m186r004 = $fir_riadok->m186r004;
$m186r005 = $fir_riadok->m186r005;
$m186r006 = $fir_riadok->m186r006;
$m186r007 = $fir_riadok->m186r007;
$m186r099 = $fir_riadok->m186r099;

$m186r101 = $fir_riadok->m186r101;
$m186r102 = $fir_riadok->m186r102;
$m186r103 = $fir_riadok->m186r103;
$m186r104 = $fir_riadok->m186r104;
$m186r105 = $fir_riadok->m186r105;
$m186r106 = $fir_riadok->m186r106;
$m186r107 = $fir_riadok->m186r107;
$m186r199 = $fir_riadok->m186r199;

$m186r201 = $fir_riadok->m186r201;
$m186r202 = $fir_riadok->m186r202;
$m186r203 = $fir_riadok->m186r203;
$m186r204 = $fir_riadok->m186r204;
$m186r205 = $fir_riadok->m186r205;
$m186r206 = $fir_riadok->m186r206;
$m186r207 = $fir_riadok->m186r207;
$m186r299 = $fir_riadok->m186r299;

$m186r301 = $fir_riadok->m186r301;
$m186r302 = $fir_riadok->m186r302;
$m186r303 = $fir_riadok->m186r303;
$m186r304 = $fir_riadok->m186r304;
$m186r305 = $fir_riadok->m186r305;
$m186r306 = $fir_riadok->m186r306;
$m186r307 = $fir_riadok->m186r307;
$m186r399 = $fir_riadok->m186r399;

$m304r01 = $fir_riadok->m304r01;
$m304r02 = $fir_riadok->m304r02;
$m304r03 = $fir_riadok->m304r03;
$m304r04 = $fir_riadok->m304r04;
$m304r05 = $fir_riadok->m304r05;
$m304r06 = $fir_riadok->m304r06;
$m304r99 = $fir_riadok->m304r99;

//11.strana
$m527r101 = $fir_riadok->m527r101;
$m527r102 = $fir_riadok->m527r102;
$m527r103 = $fir_riadok->m527r103;
$m527r104 = $fir_riadok->m527r104;

$m527r201 = $fir_riadok->m527r201;
$m527r202 = $fir_riadok->m527r202;
$m527r203 = $fir_riadok->m527r203;
$m527r204 = $fir_riadok->m527r204;

$m527r301 = $fir_riadok->m527r301;
$m527r302 = $fir_riadok->m527r302;
$m527r303 = $fir_riadok->m527r303;
$m527r304 = $fir_riadok->m527r304;

$m527r401 = $fir_riadok->m527r401;
$m527r402 = $fir_riadok->m527r402;
$m527r403 = $fir_riadok->m527r403;
$m527r404 = $fir_riadok->m527r404;

$m527r501 = $fir_riadok->m527r501;
$m527r502 = $fir_riadok->m527r502;
$m527r503 = $fir_riadok->m527r503;
$m527r504 = $fir_riadok->m527r504;

$m527r601 = $fir_riadok->m527r601;
$m527r602 = $fir_riadok->m527r602;
$m527r603 = $fir_riadok->m527r603;
$m527r604 = $fir_riadok->m527r604;

$m527r701 = $fir_riadok->m527r701;
$m527r702 = $fir_riadok->m527r702;
$m527r703 = $fir_riadok->m527r703;
$m527r704 = $fir_riadok->m527r704;

$m527r801 = $fir_riadok->m527r801;
$m527r802 = $fir_riadok->m527r802;
$m527r803 = $fir_riadok->m527r803;
$m527r804 = $fir_riadok->m527r804;

$m527r901 = $fir_riadok->m527r901;
$m527r902 = $fir_riadok->m527r902;
$m527r903 = $fir_riadok->m527r903;
$m527r904 = $fir_riadok->m527r904;

$m527r1001 = $fir_riadok->m527r1001;
$m527r1002 = $fir_riadok->m527r1002;
$m527r1003 = $fir_riadok->m527r1003;
$m527r1004 = $fir_riadok->m527r1004;

//12.strana
$m474r101 = $fir_riadok->m474r101;
$m474r102 = $fir_riadok->m474r102;
$m474r103 = $fir_riadok->m474r103;
$m474r104 = $fir_riadok->m474r104;
$m474r105 = $fir_riadok->m474r105;
$m474r106 = $fir_riadok->m474r106;
$m474r107 = $fir_riadok->m474r107;
$m474r199 = $fir_riadok->m474r199;

$m474r201 = $fir_riadok->m474r201;
$m474r202 = $fir_riadok->m474r202;
$m474r203 = $fir_riadok->m474r203;
$m474r204 = $fir_riadok->m474r204;
$m474r205 = $fir_riadok->m474r205;
$m474r206 = $fir_riadok->m474r206;
$m474r207 = $fir_riadok->m474r207;
$m474r299 = $fir_riadok->m474r299;

$m474r301 = $fir_riadok->m474r301;
$m474r302 = $fir_riadok->m474r302;
$m474r303 = $fir_riadok->m474r303;
$m474r304 = $fir_riadok->m474r304;
$m474r305 = $fir_riadok->m474r305;
$m474r306 = $fir_riadok->m474r306;
$m474r307 = $fir_riadok->m474r307;
$m474r399 = $fir_riadok->m474r399;

//13.strana
$m127r001 = $fir_riadok->m127r001;
$m127r002 = $fir_riadok->m127r002;
$m127r003 = $fir_riadok->m127r003;
$m127r004 = $fir_riadok->m127r004;
$m127r005 = $fir_riadok->m127r005;
$m127r006 = $fir_riadok->m127r006;
$m127r007 = $fir_riadok->m127r007;
$m127r008 = $fir_riadok->m127r008;
$m127r009 = $fir_riadok->m127r009;
$m127r010 = $fir_riadok->m127r010;
$m127r011 = $fir_riadok->m127r011;
$m127r012 = $fir_riadok->m127r012;
$m127r013 = $fir_riadok->m127r013;
$m127r014 = $fir_riadok->m127r014;
$m127r015 = $fir_riadok->m127r015;
$m127r099 = $fir_riadok->m127r099;

$m127r101 = $fir_riadok->m127r101;
$m127r102 = $fir_riadok->m127r102;
$m127r103 = $fir_riadok->m127r103;
$m127r104 = $fir_riadok->m127r104;
$m127r105 = $fir_riadok->m127r105;
$m127r106 = $fir_riadok->m127r106;
$m127r107 = $fir_riadok->m127r107;
$m127r108 = $fir_riadok->m127r108;
$m127r109 = $fir_riadok->m127r109;
$m127r110 = $fir_riadok->m127r110;
$m127r111 = $fir_riadok->m127r111;
$m127r112 = $fir_riadok->m127r112;
$m127r113 = $fir_riadok->m127r113;
$m127r114 = $fir_riadok->m127r114;
$m127r115 = $fir_riadok->m127r115;
$m127r199 = $fir_riadok->m127r199;

$m127r201 = $fir_riadok->m127r201;
$m127r202 = $fir_riadok->m127r202;
$m127r203 = $fir_riadok->m127r203;
$m127r204 = $fir_riadok->m127r204;
$m127r205 = $fir_riadok->m127r205;
$m127r206 = $fir_riadok->m127r206;
$m127r207 = $fir_riadok->m127r207;
$m127r208 = $fir_riadok->m127r208;
$m127r209 = $fir_riadok->m127r209;
$m127r210 = $fir_riadok->m127r210;
$m127r211 = $fir_riadok->m127r211;
$m127r212 = $fir_riadok->m127r212;
$m127r213 = $fir_riadok->m127r213;
$m127r214 = $fir_riadok->m127r214;
$m127r215 = $fir_riadok->m127r215;
$m127r299 = $fir_riadok->m127r299;

$m127r301 = $fir_riadok->m127r301;
$m127r302 = $fir_riadok->m127r302;
$m127r303 = $fir_riadok->m127r303;
$m127r304 = $fir_riadok->m127r304;
$m127r305 = $fir_riadok->m127r305;
$m127r306 = $fir_riadok->m127r306;
$m127r307 = $fir_riadok->m127r307;
$m127r308 = $fir_riadok->m127r308;
$m127r309 = $fir_riadok->m127r309;
$m127r310 = $fir_riadok->m127r310;
$m127r311 = $fir_riadok->m127r311;
$m127r312 = $fir_riadok->m127r312;
$m127r313 = $fir_riadok->m127r313;
$m127r314 = $fir_riadok->m127r314;
$m127r315 = $fir_riadok->m127r315;
$m127r399 = $fir_riadok->m127r399;

$m127r401 = $fir_riadok->m127r401;
$m127r402 = $fir_riadok->m127r402;
$m127r403 = $fir_riadok->m127r403;
$m127r404 = $fir_riadok->m127r404;
$m127r405 = $fir_riadok->m127r405;
$m127r406 = $fir_riadok->m127r406;
$m127r407 = $fir_riadok->m127r407;
$m127r408 = $fir_riadok->m127r408;
$m127r409 = $fir_riadok->m127r409;
$m127r410 = $fir_riadok->m127r410;
$m127r411 = $fir_riadok->m127r411;
$m127r412 = $fir_riadok->m127r412;
$m127r413 = $fir_riadok->m127r413;
$m127r414 = $fir_riadok->m127r414;
$m127r415 = $fir_riadok->m127r415;
$m127r499 = $fir_riadok->m127r499;

$m127r501 = $fir_riadok->m127r501;
$m127r502 = $fir_riadok->m127r502;
$m127r503 = $fir_riadok->m127r503;
$m127r504 = $fir_riadok->m127r504;
$m127r505 = $fir_riadok->m127r505;
$m127r506 = $fir_riadok->m127r506;
$m127r507 = $fir_riadok->m127r507;
$m127r508 = $fir_riadok->m127r508;
$m127r509 = $fir_riadok->m127r509;
$m127r510 = $fir_riadok->m127r510;
$m127r511 = $fir_riadok->m127r511;
$m127r512 = $fir_riadok->m127r512;
$m127r513 = $fir_riadok->m127r513;
$m127r514 = $fir_riadok->m127r514;
$m127r515 = $fir_riadok->m127r515;
$m127r599 = $fir_riadok->m127r599;

$m127r601 = $fir_riadok->m127r601;
$m127r602 = $fir_riadok->m127r602;
$m127r603 = $fir_riadok->m127r603;
$m127r604 = $fir_riadok->m127r604;
$m127r605 = $fir_riadok->m127r605;
$m127r606 = $fir_riadok->m127r606;
$m127r607 = $fir_riadok->m127r607;
$m127r608 = $fir_riadok->m127r608;
$m127r609 = $fir_riadok->m127r609;
$m127r610 = $fir_riadok->m127r610;
$m127r611 = $fir_riadok->m127r611;
$m127r612 = $fir_riadok->m127r612;
$m127r613 = $fir_riadok->m127r613;
$m127r614 = $fir_riadok->m127r614;
$m127r615 = $fir_riadok->m127r615;
$m127r699 = $fir_riadok->m127r699;


//14.strana
$m128r101 = $fir_riadok->m128r101;
$m128r102 = $fir_riadok->m128r102;
$m128r103 = $fir_riadok->m128r103;
$m128r104 = $fir_riadok->m128r104;
$m128r105 = $fir_riadok->m128r105;
$m128r106 = $fir_riadok->m128r106;
$m128r107 = $fir_riadok->m128r107;
$m128r108 = $fir_riadok->m128r108;
$m128r109 = $fir_riadok->m128r109;
$m128r110 = $fir_riadok->m128r110;
$m128r111 = $fir_riadok->m128r111;
$m128r199 = $fir_riadok->m128r199;

$m128r201 = $fir_riadok->m128r201;
$m128r202 = $fir_riadok->m128r202;
$m128r203 = $fir_riadok->m128r203;
$m128r204 = $fir_riadok->m128r204;
$m128r205 = $fir_riadok->m128r205;
$m128r206 = $fir_riadok->m128r206;
$m128r207 = $fir_riadok->m128r207;
$m128r208 = $fir_riadok->m128r208;
$m128r209 = $fir_riadok->m128r209;
$m128r210 = $fir_riadok->m128r210;
$m128r211 = $fir_riadok->m128r211;
$m128r299 = $fir_riadok->m128r299;

$m128r301 = $fir_riadok->m128r301;
$m128r302 = $fir_riadok->m128r302;
$m128r303 = $fir_riadok->m128r303;
$m128r304 = $fir_riadok->m128r304;
$m128r305 = $fir_riadok->m128r305;
$m128r306 = $fir_riadok->m128r306;
$m128r307 = $fir_riadok->m128r307;
$m128r308 = $fir_riadok->m128r308;
$m128r309 = $fir_riadok->m128r309;
$m128r310 = $fir_riadok->m128r310;
$m128r311 = $fir_riadok->m128r311;
$m128r399 = $fir_riadok->m128r399;

$m128r401 = $fir_riadok->m128r401;
$m128r402 = $fir_riadok->m128r402;
$m128r403 = $fir_riadok->m128r403;
$m128r404 = $fir_riadok->m128r404;
$m128r405 = $fir_riadok->m128r405;
$m128r406 = $fir_riadok->m128r406;
$m128r407 = $fir_riadok->m128r407;
$m128r408 = $fir_riadok->m128r408;
$m128r409 = $fir_riadok->m128r409;
$m128r410 = $fir_riadok->m128r410;
$m128r411 = $fir_riadok->m128r411;
$m128r499 = $fir_riadok->m128r499;

$m128r501 = $fir_riadok->m128r501;
$m128r502 = $fir_riadok->m128r502;
$m128r503 = $fir_riadok->m128r503;
$m128r504 = $fir_riadok->m128r504;
$m128r505 = $fir_riadok->m128r505;
$m128r506 = $fir_riadok->m128r506;
$m128r507 = $fir_riadok->m128r507;
$m128r508 = $fir_riadok->m128r508;
$m128r509 = $fir_riadok->m128r509;
$m128r510 = $fir_riadok->m128r510;
$m128r511 = $fir_riadok->m128r511;
$m128r599 = $fir_riadok->m128r599;

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
<title>EuroSecom - v�kaz OPU 2-01</title>
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
//od tadeto dole to uz rob ty
//uprava
  if ( $copern == 102 )
  {
?>
  function ObnovUI()
  {
<?php if ( $strana == 1 ) { ?>
   document.formv1.odoslane.value = '<?php echo "$odoslane_sk";?>';
<?php if ( $mod100041ano == 1 ) { echo "document.formv1.mod100041ano.checked='checked'; "; } ?>
<?php if ( $mod100041nie == 1 ) { echo "document.formv1.mod100041nie.checked='checked'; "; } ?>
<?php if ( $mod100042ano == 1 ) { echo "document.formv1.mod100042ano.checked='checked'; "; } ?>
<?php if ( $mod100042nie == 1 ) { echo "document.formv1.mod100042nie.checked='checked'; "; } ?>
<?php if ( $mod100043ano == 1 ) { echo "document.formv1.mod100043ano.checked='checked'; "; } ?>
<?php if ( $mod100043nie == 1 ) { echo "document.formv1.mod100043nie.checked='checked'; "; } ?>
<?php                     } ?>

<?php if ( $strana == 2 ) { ?>
   document.formv1.mod100038.value = '<?php echo "$mod100038";?>';
   document.formv1.mod100039.value = '<?php echo "$mod100039";?>';
   document.formv1.mod100037.value = '<?php echo "$mod100037";?>';
   document.formv1.mod100040.value = '<?php echo "$mod100040";?>';
   document.formv1.mod100089.value = '<?php echo "$mod100089";?>';
   document.formv1.mod100090.value = '<?php echo "$mod100090";?>';
   document.formv1.mod100091.value = '<?php echo "$mod100091";?>';
<?php if ( $mod100036kal == 1 ) { echo "document.formv1.mod100036kal.checked='checked'; "; } ?>
<?php if ( $mod100036hos == 1 ) { echo "document.formv1.mod100036hos.checked='checked'; "; } ?>
<?php if ( $mod100069ano == 1 ) { echo "document.formv1.mod100069ano.checked='checked'; "; } ?>
<?php if ( $mod100069nie == 1 ) { echo "document.formv1.mod100069nie.checked='checked'; "; } ?>
<?php if ( $mod100086ano == 1 ) { echo "document.formv1.mod100086ano.checked='checked'; "; } ?>
<?php if ( $mod100086nie == 1 ) { echo "document.formv1.mod100086nie.checked='checked'; "; } ?>
<?php if ( $mod100087ano == 1 ) { echo "document.formv1.mod100087ano.checked='checked'; "; } ?>
<?php if ( $mod100087nie == 1 ) { echo "document.formv1.mod100087nie.checked='checked'; "; } ?>
<?php if ( $mod100088ano == 1 ) { echo "document.formv1.mod100088ano.checked='checked'; "; } ?>
<?php if ( $mod100088nie == 1 ) { echo "document.formv1.mod100088nie.checked='checked'; "; } ?>
<?php                     } ?>

<?php if ( $strana == 3 ) { ?>
   document.formv1.mod2r01.value = '<?php echo "$mod2r01";?>';
   document.formv1.mod2r02.value = '<?php echo "$mod2r02";?>';

   document.formv1.m398r01.value = '<?php echo "$m398r01";?>';
   document.formv1.m398r02.value = '<?php echo "$m398r02";?>';

   document.formv1.m405r01.value = '<?php echo "$m405r01";?>';
   document.formv1.m405r02.value = '<?php echo "$m405r02";?>';
   document.formv1.m405r03.value = '<?php echo "$m405r03";?>';
   document.formv1.m405r04.value = '<?php echo "$m405r04";?>';
   document.formv1.m405r05.value = '<?php echo "$m405r05";?>';
   document.formv1.m405r06.value = '<?php echo "$m405r06";?>';

   document.formv1.m558r01.value = '<?php echo "$m558r01";?>';
   document.formv1.m558r02.value = '<?php echo "$m558r02";?>';
   document.formv1.m558r03.value = '<?php echo "$m558r03";?>';
   document.formv1.m558r04.value = '<?php echo "$m558r04";?>';
   document.formv1.m558r05.value = '<?php echo "$m558r05";?>';
   document.formv1.m558r06.value = '<?php echo "$m558r06";?>';
<?php                     } ?>

<?php if ( $strana == 4 ) { ?>
   document.formv1.m580r11.value = '<?php echo "$m580r11";?>';
   document.formv1.m580r12.value = '<?php echo "$m580r12";?>';
   document.formv1.m580r21.value = '<?php echo "$m580r21";?>';
   document.formv1.m580r22.value = '<?php echo "$m580r22";?>';

   document.formv1.m586r11.value = '<?php echo "$m586r11";?>';
   document.formv1.m586r12.value = '<?php echo "$m586r12";?>';
   document.formv1.m586r13.value = '<?php echo "$m586r13";?>';
   document.formv1.m586r14.value = '<?php echo "$m586r14";?>';
   //document.formv1.m586r199.value = '<?php echo "$m586r199";?>';
   document.formv1.m586r21.value = '<?php echo "$m586r21";?>';
   document.formv1.m586r22.value = '<?php echo "$m586r22";?>';
   document.formv1.m586r23.value = '<?php echo "$m586r23";?>';
   document.formv1.m586r24.value = '<?php echo "$m586r24";?>';
   //document.formv1.m586r299.value = '<?php echo "$m586r299";?>';

<?php if ( $m100062ano == 1 ) { echo "document.formv1.m100062ano.checked='checked'; "; } ?>
<?php if ( $m100062nie == 1 ) { echo "document.formv1.m100062nie.checked='checked'; "; } ?>
<?php if ( $m100044ano == 1 ) { echo "document.formv1.m100044ano.checked='checked'; "; } ?>
<?php if ( $m100044nie == 1 ) { echo "document.formv1.m100044nie.checked='checked'; "; } ?>

   document.formv1.m585r01.value = '<?php echo "$m585r01";?>';
   document.formv1.m585r02.value = '<?php echo "$m585r02";?>';
   document.formv1.m585r03.value = '<?php echo "$m585r03";?>';
   document.formv1.m585r04.value = '<?php echo "$m585r04";?>';
   document.formv1.m585r05.value = '<?php echo "$m585r05";?>';
   document.formv1.m585r3k.value = '<?php echo "$m585r3k";?>';
   document.formv1.m585r4k.value = '<?php echo "$m585r4k";?>';
   document.formv1.m585r5k.value = '<?php echo "$m585r5k";?>';
<?php                     } ?>

<?php if ( $strana == 5 ) { ?>
   document.formv1.m516r101.value = '<?php echo "$m516r101";?>';
   document.formv1.m516r102.value = '<?php echo "$m516r102";?>';
   document.formv1.m516r103.value = '<?php echo "$m516r103";?>';
   document.formv1.m516r104.value = '<?php echo "$m516r104";?>';
   document.formv1.m516r105.value = '<?php echo "$m516r105";?>';
   document.formv1.m516r106.value = '<?php echo "$m516r106";?>';
   document.formv1.m516r107.value = '<?php echo "$m516r107";?>';
   document.formv1.m516r108.value = '<?php echo "$m516r108";?>';
   document.formv1.m516r109.value = '<?php echo "$m516r109";?>';
   document.formv1.m516r110.value = '<?php echo "$m516r110";?>';
   document.formv1.m516r111.value = '<?php echo "$m516r111";?>';
   document.formv1.m516r112.value = '<?php echo "$m516r112";?>';
   document.formv1.m516r113.value = '<?php echo "$m516r113";?>';
   document.formv1.m516r114.value = '<?php echo "$m516r114";?>';
   //document.formv1.m516r199.value = '<?php echo "$m516r199";?>';
   document.formv1.m516r201.value = '<?php echo "$m516r201";?>';
   document.formv1.m516r202.value = '<?php echo "$m516r202";?>';
   document.formv1.m516r203.value = '<?php echo "$m516r203";?>';
   document.formv1.m516r204.value = '<?php echo "$m516r204";?>';
   document.formv1.m516r205.value = '<?php echo "$m516r205";?>';
   document.formv1.m516r206.value = '<?php echo "$m516r206";?>';
   document.formv1.m516r207.value = '<?php echo "$m516r207";?>';
   document.formv1.m516r208.value = '<?php echo "$m516r208";?>';
   document.formv1.m516r209.value = '<?php echo "$m516r209";?>';
   document.formv1.m516r210.value = '<?php echo "$m516r210";?>';
   document.formv1.m516r211.value = '<?php echo "$m516r211";?>';
   document.formv1.m516r212.value = '<?php echo "$m516r212";?>';
   document.formv1.m516r213.value = '<?php echo "$m516r213";?>';
   document.formv1.m516r214.value = '<?php echo "$m516r214";?>';
   //document.formv1.m516r299.value = '<?php echo "$m516r299";?>';

   document.formv1.m571r10.value = '<?php echo "$m571r10";?>';
   document.formv1.m571r12.value = '<?php echo "$m571r12";?>';
   document.formv1.m571r13.value = '<?php echo "$m571r13";?>';
   //document.formv1.m571r14.value = '<?php echo "$m571r14";?>';
   document.formv1.m571r15.value = '<?php echo "$m571r15";?>';
   document.formv1.m571r16.value = '<?php echo "$m571r16";?>';
   document.formv1.m571r17.value = '<?php echo "$m571r17";?>';
   document.formv1.m571r18.value = '<?php echo "$m571r18";?>';
   document.formv1.m571r20.value = '<?php echo "$m571r20";?>';
   document.formv1.m571r22.value = '<?php echo "$m571r22";?>';
   document.formv1.m571r23.value = '<?php echo "$m571r23";?>';
   //document.formv1.m571r24.value = '<?php echo "$m571r24";?>';
   document.formv1.m571r25.value = '<?php echo "$m571r25";?>';
   document.formv1.m571r26.value = '<?php echo "$m571r26";?>';
   document.formv1.m571r27.value = '<?php echo "$m571r27";?>';
   document.formv1.m571r28.value = '<?php echo "$m571r28";?>';
   document.formv1.m571r30.value = '<?php echo "$m571r30";?>';
   document.formv1.m571r32.value = '<?php echo "$m571r32";?>';
   document.formv1.m571r33.value = '<?php echo "$m571r33";?>';
   //document.formv1.m571r34.value = '<?php echo "$m571r34";?>';
   document.formv1.m571r35.value = '<?php echo "$m571r35";?>';
   document.formv1.m571r36.value = '<?php echo "$m571r36";?>';
   document.formv1.m571r37.value = '<?php echo "$m571r37";?>';
   document.formv1.m571r38.value = '<?php echo "$m571r38";?>';
   document.formv1.m571r40.value = '<?php echo "$m571r40";?>';
   document.formv1.m571r42.value = '<?php echo "$m571r42";?>';
   document.formv1.m571r43.value = '<?php echo "$m571r43";?>';
   //document.formv1.m571r44.value = '<?php echo "$m571r44";?>';
   document.formv1.m571r45.value = '<?php echo "$m571r45";?>';
   document.formv1.m571r46.value = '<?php echo "$m571r46";?>';
   document.formv1.m571r47.value = '<?php echo "$m571r47";?>';
   document.formv1.m571r48.value = '<?php echo "$m571r48";?>';
   document.formv1.m571r50.value = '<?php echo "$m571r50";?>';
   document.formv1.m571r52.value = '<?php echo "$m571r52";?>';
   document.formv1.m571r53.value = '<?php echo "$m571r53";?>';
   //document.formv1.m571r54.value = '<?php echo "$m571r54";?>';
   document.formv1.m571r55.value = '<?php echo "$m571r55";?>';
   document.formv1.m571r56.value = '<?php echo "$m571r56";?>';
   document.formv1.m571r57.value = '<?php echo "$m571r57";?>';
   document.formv1.m571r58.value = '<?php echo "$m571r58";?>';
   document.formv1.m571r60.value = '<?php echo "$m571r60";?>';
   document.formv1.m571r62.value = '<?php echo "$m571r62";?>';
   document.formv1.m571r63.value = '<?php echo "$m571r63";?>';
   //document.formv1.m571r64.value = '<?php echo "$m571r64";?>';
   document.formv1.m571r65.value = '<?php echo "$m571r65";?>';
   document.formv1.m571r66.value = '<?php echo "$m571r66";?>';
   document.formv1.m571r67.value = '<?php echo "$m571r67";?>';
   document.formv1.m571r68.value = '<?php echo "$m571r68";?>';
   document.formv1.m571r70.value = '<?php echo "$m571r70";?>';
   document.formv1.m571r72.value = '<?php echo "$m571r72";?>';
   document.formv1.m571r73.value = '<?php echo "$m571r73";?>';
   //document.formv1.m571r74.value = '<?php echo "$m571r74";?>';
   document.formv1.m571r75.value = '<?php echo "$m571r75";?>';
   document.formv1.m571r76.value = '<?php echo "$m571r76";?>';
   document.formv1.m571r77.value = '<?php echo "$m571r77";?>';
   document.formv1.m571r78.value = '<?php echo "$m571r78";?>';
   document.formv1.m571r80.value = '<?php echo "$m571r80";?>';
   document.formv1.m571r82.value = '<?php echo "$m571r82";?>';
   document.formv1.m571r83.value = '<?php echo "$m571r83";?>';
   //document.formv1.m571r84.value = '<?php echo "$m571r84";?>';
   document.formv1.m571r85.value = '<?php echo "$m571r85";?>';
   document.formv1.m571r86.value = '<?php echo "$m571r86";?>';
   document.formv1.m571r87.value = '<?php echo "$m571r87";?>';
   document.formv1.m571r88.value = '<?php echo "$m571r88";?>';
   document.formv1.m571r90.value = '<?php echo "$m571r90";?>';
   document.formv1.m571r92.value = '<?php echo "$m571r92";?>';
   document.formv1.m571r93.value = '<?php echo "$m571r93";?>';
   //document.formv1.m571r94.value = '<?php echo "$m571r94";?>';
   document.formv1.m571r95.value = '<?php echo "$m571r95";?>';
   document.formv1.m571r96.value = '<?php echo "$m571r96";?>';
   document.formv1.m571r97.value = '<?php echo "$m571r97";?>';
   document.formv1.m571r98.value = '<?php echo "$m571r98";?>';
<?php                     } ?>

<?php if (  $strana == 6 ) { ?>
   document.formv1.m513r101.value = '<?php echo "$m513r101";?>';
   document.formv1.m513r102.value = '<?php echo "$m513r102";?>';
   document.formv1.m513r103.value = '<?php echo "$m513r103";?>';
   document.formv1.m513r104.value = '<?php echo "$m513r104";?>';
   document.formv1.m513r105.value = '<?php echo "$m513r105";?>';
   document.formv1.m513r106.value = '<?php echo "$m513r106";?>';
   document.formv1.m513r107.value = '<?php echo "$m513r107";?>';
   document.formv1.m513r108.value = '<?php echo "$m513r108";?>';
   document.formv1.m513r109.value = '<?php echo "$m513r109";?>';
   document.formv1.m513r110.value = '<?php echo "$m513r110";?>';
   //document.formv1.m513r199.value = '<?php echo "$m513r199";?>';

   document.formv1.m513r201.value = '<?php echo "$m513r201";?>';
   document.formv1.m513r202.value = '<?php echo "$m513r202";?>';
   document.formv1.m513r203.value = '<?php echo "$m513r203";?>';
   document.formv1.m513r204.value = '<?php echo "$m513r204";?>';
   document.formv1.m513r205.value = '<?php echo "$m513r205";?>';
   document.formv1.m513r206.value = '<?php echo "$m513r206";?>';
   document.formv1.m513r207.value = '<?php echo "$m513r207";?>';
   document.formv1.m513r208.value = '<?php echo "$m513r208";?>';
   document.formv1.m513r209.value = '<?php echo "$m513r209";?>';
   document.formv1.m513r210.value = '<?php echo "$m513r210";?>';
   //document.formv1.m513r299.value = '<?php echo "$m513r299";?>';

   document.formv1.m513r301.value = '<?php echo "$m513r301";?>';
   document.formv1.m513r302.value = '<?php echo "$m513r302";?>';
   document.formv1.m513r303.value = '<?php echo "$m513r303";?>';
   document.formv1.m513r304.value = '<?php echo "$m513r304";?>';
   document.formv1.m513r305.value = '<?php echo "$m513r305";?>';
   document.formv1.m513r306.value = '<?php echo "$m513r306";?>';
   document.formv1.m513r307.value = '<?php echo "$m513r307";?>';
   document.formv1.m513r308.value = '<?php echo "$m513r308";?>';
   document.formv1.m513r309.value = '<?php echo "$m513r309";?>';
   document.formv1.m513r310.value = '<?php echo "$m513r310";?>';
   //document.formv1.m513r399.value = '<?php echo "$m513r399";?>';

   document.formv1.m513r401.value = '<?php echo "$m513r401";?>';
   document.formv1.m513r402.value = '<?php echo "$m513r402";?>';
   document.formv1.m513r403.value = '<?php echo "$m513r403";?>';
   document.formv1.m513r404.value = '<?php echo "$m513r404";?>';
   document.formv1.m513r405.value = '<?php echo "$m513r405";?>';
   document.formv1.m513r406.value = '<?php echo "$m513r406";?>';
   document.formv1.m513r407.value = '<?php echo "$m513r407";?>';
   document.formv1.m513r408.value = '<?php echo "$m513r408";?>';
   document.formv1.m513r409.value = '<?php echo "$m513r409";?>';
   document.formv1.m513r410.value = '<?php echo "$m513r410";?>';
   //document.formv1.m513r499.value = '<?php echo "$m513r499";?>';

   document.formv1.m513r501.value = '<?php echo "$m513r501";?>';
   document.formv1.m513r502.value = '<?php echo "$m513r502";?>';
   document.formv1.m513r503.value = '<?php echo "$m513r503";?>';
   document.formv1.m513r504.value = '<?php echo "$m513r504";?>';
   document.formv1.m513r505.value = '<?php echo "$m513r505";?>';
   document.formv1.m513r506.value = '<?php echo "$m513r506";?>';
   document.formv1.m513r507.value = '<?php echo "$m513r507";?>';
   document.formv1.m513r508.value = '<?php echo "$m513r508";?>';
   document.formv1.m513r509.value = '<?php echo "$m513r509";?>';
   document.formv1.m513r510.value = '<?php echo "$m513r510";?>';
   //document.formv1.m513r599.value = '<?php echo "$m513r599";?>';

   document.formv1.m513r601.value = '<?php echo "$m513r601";?>';
   document.formv1.m513r602.value = '<?php echo "$m513r602";?>';
   document.formv1.m513r603.value = '<?php echo "$m513r603";?>';
   document.formv1.m513r604.value = '<?php echo "$m513r604";?>';
   document.formv1.m513r605.value = '<?php echo "$m513r605";?>';
   document.formv1.m513r606.value = '<?php echo "$m513r606";?>';
   document.formv1.m513r607.value = '<?php echo "$m513r607";?>';
   document.formv1.m513r608.value = '<?php echo "$m513r608";?>';
   document.formv1.m513r609.value = '<?php echo "$m513r609";?>';
   document.formv1.m513r610.value = '<?php echo "$m513r610";?>';
   //document.formv1.m513r699.value = '<?php echo "$m513r699";?>';

   document.formv1.m581r01.value = '<?php echo "$m581r01";?>';
   document.formv1.m581r02.value = '<?php echo "$m581r02";?>';
   //document.formv1.m581r99.value = '<?php echo "$m581r99";?>';

<?php if ( $m588r301 == 1 ) { echo "document.formv1.m588r301.checked='checked'; "; } ?>
<?php if ( $m588r302 == 1 ) { echo "document.formv1.m588r302.checked='checked'; "; } ?>
<?php if ( $m588r303 == 1 ) { echo "document.formv1.m588r303.checked='checked'; "; } ?>
<?php if ( $m588r304 == 1 ) { echo "document.formv1.m588r304.checked='checked'; "; } ?>
<?php if ( $m588r305 == 1 ) { echo "document.formv1.m588r305.checked='checked'; "; } ?>
<?php if ( $m588r306 == 1 ) { echo "document.formv1.m588r306.checked='checked'; "; } ?>
<?php if ( $m588r307 == 1 ) { echo "document.formv1.m588r307.checked='checked'; "; } ?>
<?php if ( $m588r308 == 1 ) { echo "document.formv1.m588r308.checked='checked'; "; } ?>
<?php if ( $m588r309 == 1 ) { echo "document.formv1.m588r309.checked='checked'; "; } ?>
<?php if ( $m588r310 == 1 ) { echo "document.formv1.m588r310.checked='checked'; "; } ?>
<?php if ( $m588r311 == 1 ) { echo "document.formv1.m588r311.checked='checked'; "; } ?>
<?php if ( $m588r312 == 1 ) { echo "document.formv1.m588r312.checked='checked'; "; } ?>
<?php if ( $m588r313 == 1 ) { echo "document.formv1.m588r313.checked='checked'; "; } ?>
<?php if ( $m588r314 == 1 ) { echo "document.formv1.m588r314.checked='checked'; "; } ?>
<?php if ( $m588r315 == 1 ) { echo "document.formv1.m588r315.checked='checked'; "; } ?>
<?php if ( $m588r316 == 1 ) { echo "document.formv1.m588r316.checked='checked'; "; } ?>
<?php if ( $m588r317 == 1 ) { echo "document.formv1.m588r317.checked='checked'; "; } ?>
<?php if ( $m588r318 == 1 ) { echo "document.formv1.m588r318.checked='checked'; "; } ?>
<?php if ( $m588r319 == 1 ) { echo "document.formv1.m588r319.checked='checked'; "; } ?>
<?php if ( $m588r320 == 1 ) { echo "document.formv1.m588r320.checked='checked'; "; } ?>

<?php if ( $m588r201 == 1 ) { echo "document.formv1.m588r201.checked='checked'; "; } ?>
<?php if ( $m588r202 == 1 ) { echo "document.formv1.m588r202.checked='checked'; "; } ?>
<?php if ( $m588r203 == 1 ) { echo "document.formv1.m588r203.checked='checked'; "; } ?>
<?php if ( $m588r204 == 1 ) { echo "document.formv1.m588r204.checked='checked'; "; } ?>
<?php if ( $m588r205 == 1 ) { echo "document.formv1.m588r205.checked='checked'; "; } ?>
<?php if ( $m588r206 == 1 ) { echo "document.formv1.m588r206.checked='checked'; "; } ?>
<?php if ( $m588r207 == 1 ) { echo "document.formv1.m588r207.checked='checked'; "; } ?>
<?php if ( $m588r208 == 1 ) { echo "document.formv1.m588r208.checked='checked'; "; } ?>
<?php if ( $m588r209 == 1 ) { echo "document.formv1.m588r209.checked='checked'; "; } ?>
<?php if ( $m588r210 == 1 ) { echo "document.formv1.m588r210.checked='checked'; "; } ?>
<?php if ( $m588r211 == 1 ) { echo "document.formv1.m588r211.checked='checked'; "; } ?>
<?php if ( $m588r212 == 1 ) { echo "document.formv1.m588r212.checked='checked'; "; } ?>
<?php if ( $m588r213 == 1 ) { echo "document.formv1.m588r213.checked='checked'; "; } ?>
<?php if ( $m588r214 == 1 ) { echo "document.formv1.m588r214.checked='checked'; "; } ?>
<?php if ( $m588r215 == 1 ) { echo "document.formv1.m588r215.checked='checked'; "; } ?>
<?php if ( $m588r216 == 1 ) { echo "document.formv1.m588r216.checked='checked'; "; } ?>
<?php if ( $m588r217 == 1 ) { echo "document.formv1.m588r217.checked='checked'; "; } ?>
<?php if ( $m588r218 == 1 ) { echo "document.formv1.m588r218.checked='checked'; "; } ?>
<?php if ( $m588r219 == 1 ) { echo "document.formv1.m588r219.checked='checked'; "; } ?>
<?php if ( $m588r220 == 1 ) { echo "document.formv1.m588r220.checked='checked'; "; } ?>


<?php                     } ?>

<?php if (  $strana == 7 ) { ?>


<?php if ( $m588r221 == 1 ) { echo "document.formv1.m588r221.checked='checked'; "; } ?>
<?php if ( $m588r222 == 1 ) { echo "document.formv1.m588r222.checked='checked'; "; } ?>
<?php if ( $m588r223 == 1 ) { echo "document.formv1.m588r223.checked='checked'; "; } ?>
<?php if ( $m588r224 == 1 ) { echo "document.formv1.m588r224.checked='checked'; "; } ?>
<?php if ( $m588r225 == 1 ) { echo "document.formv1.m588r225.checked='checked'; "; } ?>
<?php if ( $m588r226 == 1 ) { echo "document.formv1.m588r226.checked='checked'; "; } ?>
<?php if ( $m588r227 == 1 ) { echo "document.formv1.m588r227.checked='checked'; "; } ?>
<?php if ( $m588r228 == 1 ) { echo "document.formv1.m588r228.checked='checked'; "; } ?>
<?php if ( $m588r229 == 1 ) { echo "document.formv1.m588r229.checked='checked'; "; } ?>
<?php if ( $m588r230 == 1 ) { echo "document.formv1.m588r230.checked='checked'; "; } ?>
<?php if ( $m588r231 == 1 ) { echo "document.formv1.m588r231.checked='checked'; "; } ?>
<?php if ( $m588r232 == 1 ) { echo "document.formv1.m588r232.checked='checked'; "; } ?>
<?php if ( $m588r233 == 1 ) { echo "document.formv1.m588r233.checked='checked'; "; } ?>
<?php if ( $m588r234 == 1 ) { echo "document.formv1.m588r234.checked='checked'; "; } ?>
<?php if ( $m588r235 == 1 ) { echo "document.formv1.m588r235.checked='checked'; "; } ?>
<?php if ( $m588r236 == 1 ) { echo "document.formv1.m588r236.checked='checked'; "; } ?>
<?php if ( $m588r237 == 1 ) { echo "document.formv1.m588r237.checked='checked'; "; } ?>
<?php if ( $m588r238 == 1 ) { echo "document.formv1.m588r238.checked='checked'; "; } ?>
<?php if ( $m588r239 == 1 ) { echo "document.formv1.m588r239.checked='checked'; "; } ?>
<?php if ( $m588r240 == 1 ) { echo "document.formv1.m588r240.checked='checked'; "; } ?>
<?php if ( $m588r241 == 1 ) { echo "document.formv1.m588r241.checked='checked'; "; } ?>
<?php if ( $m588r242 == 1 ) { echo "document.formv1.m588r242.checked='checked'; "; } ?>
<?php if ( $m588r243 == 1 ) { echo "document.formv1.m588r243.checked='checked'; "; } ?>
<?php if ( $m588r244 == 1 ) { echo "document.formv1.m588r244.checked='checked'; "; } ?>
<?php if ( $m588r245 == 1 ) { echo "document.formv1.m588r245.checked='checked'; "; } ?>
<?php if ( $m588r246 == 1 ) { echo "document.formv1.m588r246.checked='checked'; "; } ?>
<?php if ( $m588r247 == 1 ) { echo "document.formv1.m588r247.checked='checked'; "; } ?>
<?php if ( $m588r248 == 1 ) { echo "document.formv1.m588r248.checked='checked'; "; } ?>
<?php if ( $m588r249 == 1 ) { echo "document.formv1.m588r249.checked='checked'; "; } ?>
<?php if ( $m588r250 == 1 ) { echo "document.formv1.m588r250.checked='checked'; "; } ?>
<?php if ( $m588r251 == 1 ) { echo "document.formv1.m588r251.checked='checked'; "; } ?>

<?php if ( $m588r321 == 1 ) { echo "document.formv1.m588r321.checked='checked'; "; } ?>
<?php if ( $m588r322 == 1 ) { echo "document.formv1.m588r322.checked='checked'; "; } ?>
<?php if ( $m588r323 == 1 ) { echo "document.formv1.m588r323.checked='checked'; "; } ?>
<?php if ( $m588r324 == 1 ) { echo "document.formv1.m588r324.checked='checked'; "; } ?>
<?php if ( $m588r325 == 1 ) { echo "document.formv1.m588r325.checked='checked'; "; } ?>
<?php if ( $m588r326 == 1 ) { echo "document.formv1.m588r326.checked='checked'; "; } ?>
<?php if ( $m588r327 == 1 ) { echo "document.formv1.m588r327.checked='checked'; "; } ?>
<?php if ( $m588r328 == 1 ) { echo "document.formv1.m588r328.checked='checked'; "; } ?>
<?php if ( $m588r329 == 1 ) { echo "document.formv1.m588r329.checked='checked'; "; } ?>
<?php if ( $m588r330 == 1 ) { echo "document.formv1.m588r330.checked='checked'; "; } ?>
<?php if ( $m588r331 == 1 ) { echo "document.formv1.m588r331.checked='checked'; "; } ?>
<?php if ( $m588r332 == 1 ) { echo "document.formv1.m588r332.checked='checked'; "; } ?>
<?php if ( $m588r333 == 1 ) { echo "document.formv1.m588r333.checked='checked'; "; } ?>
<?php if ( $m588r334 == 1 ) { echo "document.formv1.m588r334.checked='checked'; "; } ?>
<?php if ( $m588r335 == 1 ) { echo "document.formv1.m588r335.checked='checked'; "; } ?>
<?php if ( $m588r336 == 1 ) { echo "document.formv1.m588r336.checked='checked'; "; } ?>
<?php if ( $m588r337 == 1 ) { echo "document.formv1.m588r337.checked='checked'; "; } ?>
<?php if ( $m588r338 == 1 ) { echo "document.formv1.m588r338.checked='checked'; "; } ?>
<?php if ( $m588r339 == 1 ) { echo "document.formv1.m588r339.checked='checked'; "; } ?>
<?php if ( $m588r340 == 1 ) { echo "document.formv1.m588r340.checked='checked'; "; } ?>
<?php if ( $m588r341 == 1 ) { echo "document.formv1.m588r341.checked='checked'; "; } ?>
<?php if ( $m588r342 == 1 ) { echo "document.formv1.m588r342.checked='checked'; "; } ?>
<?php if ( $m588r343 == 1 ) { echo "document.formv1.m588r343.checked='checked'; "; } ?>
<?php if ( $m588r344 == 1 ) { echo "document.formv1.m588r344.checked='checked'; "; } ?>
<?php if ( $m588r345 == 1 ) { echo "document.formv1.m588r345.checked='checked'; "; } ?>
<?php if ( $m588r346 == 1 ) { echo "document.formv1.m588r346.checked='checked'; "; } ?>
<?php if ( $m588r347 == 1 ) { echo "document.formv1.m588r347.checked='checked'; "; } ?>
<?php if ( $m588r348 == 1 ) { echo "document.formv1.m588r348.checked='checked'; "; } ?>
<?php if ( $m588r349 == 1 ) { echo "document.formv1.m588r349.checked='checked'; "; } ?>
<?php if ( $m588r350 == 1 ) { echo "document.formv1.m588r350.checked='checked'; "; } ?>
<?php if ( $m588r351 == 1 ) { echo "document.formv1.m588r351.checked='checked'; "; } ?>

   document.formv1.m177r01.value = '<?php echo "$m177r01";?>';
   document.formv1.m177r02.value = '<?php echo "$m177r02";?>';
   document.formv1.m177r03.value = '<?php echo "$m177r03";?>';
   document.formv1.m177r04.value = '<?php echo "$m177r04";?>';
   document.formv1.m177r05.value = '<?php echo "$m177r05";?>';
   document.formv1.m177r06.value = '<?php echo "$m177r06";?>';
   document.formv1.m177r07.value = '<?php echo "$m177r07";?>';
   document.formv1.m177r08.value = '<?php echo "$m177r08";?>';
   //document.formv1.m177r99.value = '<?php echo "$m177r99";?>';
<?php                     } ?>

<?php if ( $strana == 8 ) { ?>

   document.formv1.m178r01.value = '<?php echo "$m178r01";?>';
   document.formv1.m178r02.value = '<?php echo "$m178r02";?>';
   document.formv1.m178r03.value = '<?php echo "$m178r03";?>';
   document.formv1.m178r04.value = '<?php echo "$m178r04";?>';
   document.formv1.m178r05.value = '<?php echo "$m178r05";?>';
   document.formv1.m178r06.value = '<?php echo "$m178r06";?>';
   document.formv1.m178r07.value = '<?php echo "$m178r07";?>';
   document.formv1.m178r08.value = '<?php echo "$m178r08";?>';
   document.formv1.m178r09.value = '<?php echo "$m178r09";?>';
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
   document.formv1.m178r20.value = '<?php echo "$m178r20";?>';
   document.formv1.m178r21.value = '<?php echo "$m178r21";?>';
   //document.formv1.m178r99.value = '<?php echo "$m178r99";?>';

   document.formv1.m179r01.value = '<?php echo "$m179r01";?>';
   document.formv1.m179r02.value = '<?php echo "$m179r02";?>';

   document.formv1.m182r001.value = '<?php echo "$m182r001";?>';
   document.formv1.m182r002.value = '<?php echo "$m182r002";?>';
   document.formv1.m182r003.value = '<?php echo "$m182r003";?>';
   document.formv1.m182r004.value = '<?php echo "$m182r004";?>';
   document.formv1.m182r005.value = '<?php echo "$m182r005";?>';
   document.formv1.m182r006.value = '<?php echo "$m182r006";?>';
   document.formv1.m182r007.value = '<?php echo "$m182r007";?>';
   //document.formv1.m182r099.value = '<?php echo "$m182r099";?>';

   document.formv1.m182r101.value = '<?php echo "$m182r101";?>';
   document.formv1.m182r102.value = '<?php echo "$m182r102";?>';
   document.formv1.m182r103.value = '<?php echo "$m182r103";?>';
   document.formv1.m182r104.value = '<?php echo "$m182r104";?>';
   document.formv1.m182r105.value = '<?php echo "$m182r105";?>';
   document.formv1.m182r106.value = '<?php echo "$m182r106";?>';
   document.formv1.m182r107.value = '<?php echo "$m182r107";?>';
   //document.formv1.m182r199.value = '<?php echo "$m182r199";?>';

   document.formv1.m182r201.value = '<?php echo "$m182r201";?>';
   document.formv1.m182r202.value = '<?php echo "$m182r202";?>';
   document.formv1.m182r203.value = '<?php echo "$m182r203";?>';
   document.formv1.m182r204.value = '<?php echo "$m182r204";?>';
   document.formv1.m182r205.value = '<?php echo "$m182r205";?>';
   document.formv1.m182r206.value = '<?php echo "$m182r206";?>';
   document.formv1.m182r207.value = '<?php echo "$m182r207";?>';
   //document.formv1.m182r299.value = '<?php echo "$m182r299";?>';

<?php                     } ?>

<?php if ( $strana == 9 ) { ?>

   document.formv1.m183r001.value = '<?php echo "$m183r001";?>';
   document.formv1.m183r002.value = '<?php echo "$m183r002";?>';
   document.formv1.m183r003.value = '<?php echo "$m183r003";?>';
   document.formv1.m183r004.value = '<?php echo "$m183r004";?>';
   document.formv1.m183r005.value = '<?php echo "$m183r005";?>';
   document.formv1.m183r006.value = '<?php echo "$m183r006";?>';
   document.formv1.m183r007.value = '<?php echo "$m183r007";?>';
   document.formv1.m183r008.value = '<?php echo "$m183r008";?>';
   document.formv1.m183r009.value = '<?php echo "$m183r009";?>';
   document.formv1.m183r010.value = '<?php echo "$m183r010";?>';
   //document.formv1.m183r099.value = '<?php echo "$m183r099";?>';

   document.formv1.m183r101.value = '<?php echo "$m183r101";?>';
   document.formv1.m183r102.value = '<?php echo "$m183r102";?>';
   document.formv1.m183r103.value = '<?php echo "$m183r103";?>';
   document.formv1.m183r104.value = '<?php echo "$m183r104";?>';
   document.formv1.m183r105.value = '<?php echo "$m183r105";?>';
   document.formv1.m183r106.value = '<?php echo "$m183r106";?>';
   document.formv1.m183r107.value = '<?php echo "$m183r107";?>';
   document.formv1.m183r108.value = '<?php echo "$m183r108";?>';
   document.formv1.m183r109.value = '<?php echo "$m183r109";?>';
   document.formv1.m183r110.value = '<?php echo "$m183r110";?>';
   //document.formv1.m183r199.value = '<?php echo "$m183r199";?>';

   document.formv1.m183r201.value = '<?php echo "$m183r201";?>';
   document.formv1.m183r202.value = '<?php echo "$m183r202";?>';
   document.formv1.m183r203.value = '<?php echo "$m183r203";?>';
   document.formv1.m183r204.value = '<?php echo "$m183r204";?>';
   document.formv1.m183r205.value = '<?php echo "$m183r205";?>';
   document.formv1.m183r206.value = '<?php echo "$m183r206";?>';
   document.formv1.m183r207.value = '<?php echo "$m183r207";?>';
   document.formv1.m183r208.value = '<?php echo "$m183r208";?>';
   document.formv1.m183r209.value = '<?php echo "$m183r209";?>';
   document.formv1.m183r210.value = '<?php echo "$m183r210";?>';
   //document.formv1.m183r299.value = '<?php echo "$m183r299";?>';

   document.formv1.m184r001.value = '<?php echo "$m184r001";?>';
   document.formv1.m184r002.value = '<?php echo "$m184r002";?>';
   document.formv1.m184r003.value = '<?php echo "$m184r003";?>';
   document.formv1.m184r004.value = '<?php echo "$m184r004";?>';
   document.formv1.m184r005.value = '<?php echo "$m184r005";?>';
   document.formv1.m184r006.value = '<?php echo "$m184r006";?>';
   document.formv1.m184r007.value = '<?php echo "$m184r007";?>';
   document.formv1.m184r008.value = '<?php echo "$m184r008";?>';
   document.formv1.m184r009.value = '<?php echo "$m184r009";?>';
   document.formv1.m184r010.value = '<?php echo "$m184r010";?>';
   //document.formv1.m184r099.value = '<?php echo "$m184r099";?>';

   document.formv1.m184r101.value = '<?php echo "$m184r101";?>';
   document.formv1.m184r102.value = '<?php echo "$m184r102";?>';
   document.formv1.m184r103.value = '<?php echo "$m184r103";?>';
   document.formv1.m184r104.value = '<?php echo "$m184r104";?>';
   document.formv1.m184r105.value = '<?php echo "$m184r105";?>';
   document.formv1.m184r106.value = '<?php echo "$m184r106";?>';
   document.formv1.m184r107.value = '<?php echo "$m184r107";?>';
   document.formv1.m184r108.value = '<?php echo "$m184r108";?>';
   document.formv1.m184r109.value = '<?php echo "$m184r109";?>';
   document.formv1.m184r110.value = '<?php echo "$m184r110";?>';
   //document.formv1.m184r199.value = '<?php echo "$m184r199";?>';

   document.formv1.m184r201.value = '<?php echo "$m184r201";?>';
   document.formv1.m184r202.value = '<?php echo "$m184r202";?>';
   document.formv1.m184r203.value = '<?php echo "$m184r203";?>';
   document.formv1.m184r204.value = '<?php echo "$m184r204";?>';
   document.formv1.m184r205.value = '<?php echo "$m184r205";?>';
   document.formv1.m184r206.value = '<?php echo "$m184r206";?>';
   document.formv1.m184r207.value = '<?php echo "$m184r207";?>';
   document.formv1.m184r208.value = '<?php echo "$m184r208";?>';
   document.formv1.m184r209.value = '<?php echo "$m184r209";?>';
   document.formv1.m184r210.value = '<?php echo "$m184r210";?>';
   //document.formv1.m184r299.value = '<?php echo "$m184r299";?>';

   document.formv1.m184r301.value = '<?php echo "$m184r301";?>';
   document.formv1.m184r302.value = '<?php echo "$m184r302";?>';
   document.formv1.m184r303.value = '<?php echo "$m184r303";?>';
   document.formv1.m184r304.value = '<?php echo "$m184r304";?>';
   document.formv1.m184r305.value = '<?php echo "$m184r305";?>';
   document.formv1.m184r306.value = '<?php echo "$m184r306";?>';
   document.formv1.m184r307.value = '<?php echo "$m184r307";?>';
   document.formv1.m184r308.value = '<?php echo "$m184r308";?>';
   document.formv1.m184r309.value = '<?php echo "$m184r309";?>';
   document.formv1.m184r310.value = '<?php echo "$m184r310";?>';
   //document.formv1.m184r399.value = '<?php echo "$m184r399";?>';


<?php                     } ?>

<?php if ( $strana == 10 ) { ?>

   document.formv1.m185r001.value = '<?php echo "$m185r001";?>';
   document.formv1.m185r002.value = '<?php echo "$m185r002";?>';
   document.formv1.m185r003.value = '<?php echo "$m185r003";?>';
   document.formv1.m185r004.value = '<?php echo "$m185r004";?>';
   document.formv1.m185r005.value = '<?php echo "$m185r005";?>';
   document.formv1.m185r006.value = '<?php echo "$m185r006";?>';
   document.formv1.m185r007.value = '<?php echo "$m185r007";?>';
   //document.formv1.m185r099.value = '<?php echo "$m185r099";?>';

   document.formv1.m185r101.value = '<?php echo "$m185r101";?>';
   document.formv1.m185r102.value = '<?php echo "$m185r102";?>';
   document.formv1.m185r103.value = '<?php echo "$m185r103";?>';
   document.formv1.m185r104.value = '<?php echo "$m185r104";?>';
   document.formv1.m185r105.value = '<?php echo "$m185r105";?>';
   document.formv1.m185r106.value = '<?php echo "$m185r106";?>';
   document.formv1.m185r107.value = '<?php echo "$m185r107";?>';
   //document.formv1.m185r199.value = '<?php echo "$m185r199";?>';

   document.formv1.m185r201.value = '<?php echo "$m185r201";?>';
   document.formv1.m185r202.value = '<?php echo "$m185r202";?>';
   document.formv1.m185r203.value = '<?php echo "$m185r203";?>';
   document.formv1.m185r204.value = '<?php echo "$m185r204";?>';
   document.formv1.m185r205.value = '<?php echo "$m185r205";?>';
   document.formv1.m185r206.value = '<?php echo "$m185r206";?>';
   document.formv1.m185r207.value = '<?php echo "$m185r207";?>';
   //document.formv1.m185r299.value = '<?php echo "$m185r299";?>';

   document.formv1.m185r301.value = '<?php echo "$m185r301";?>';
   document.formv1.m185r302.value = '<?php echo "$m185r302";?>';
   document.formv1.m185r303.value = '<?php echo "$m185r303";?>';
   document.formv1.m185r304.value = '<?php echo "$m185r304";?>';
   document.formv1.m185r305.value = '<?php echo "$m185r305";?>';
   document.formv1.m185r306.value = '<?php echo "$m185r306";?>';
   document.formv1.m185r307.value = '<?php echo "$m185r307";?>';
   //document.formv1.m185r399.value = '<?php echo "$m185r399";?>';

   document.formv1.m186r001.value = '<?php echo "$m186r001";?>';
   document.formv1.m186r002.value = '<?php echo "$m186r002";?>';
   document.formv1.m186r003.value = '<?php echo "$m186r003";?>';
   document.formv1.m186r004.value = '<?php echo "$m186r004";?>';
   document.formv1.m186r005.value = '<?php echo "$m186r005";?>';
   document.formv1.m186r006.value = '<?php echo "$m186r006";?>';
   document.formv1.m186r007.value = '<?php echo "$m186r007";?>';
   //document.formv1.m186r099.value = '<?php echo "$m186r099";?>';

   document.formv1.m186r101.value = '<?php echo "$m186r101";?>';
   document.formv1.m186r102.value = '<?php echo "$m186r102";?>';
   document.formv1.m186r103.value = '<?php echo "$m186r103";?>';
   document.formv1.m186r104.value = '<?php echo "$m186r104";?>';
   document.formv1.m186r105.value = '<?php echo "$m186r105";?>';
   document.formv1.m186r106.value = '<?php echo "$m186r106";?>';
   document.formv1.m186r107.value = '<?php echo "$m186r107";?>';
   //document.formv1.m186r199.value = '<?php echo "$m186r199";?>';

   document.formv1.m186r201.value = '<?php echo "$m186r201";?>';
   document.formv1.m186r202.value = '<?php echo "$m186r202";?>';
   document.formv1.m186r203.value = '<?php echo "$m186r203";?>';
   document.formv1.m186r204.value = '<?php echo "$m186r204";?>';
   document.formv1.m186r205.value = '<?php echo "$m186r205";?>';
   document.formv1.m186r206.value = '<?php echo "$m186r206";?>';
   document.formv1.m186r207.value = '<?php echo "$m186r207";?>';
   //document.formv1.m186r299.value = '<?php echo "$m186r299";?>';

   document.formv1.m186r301.value = '<?php echo "$m186r301";?>';
   document.formv1.m186r302.value = '<?php echo "$m186r302";?>';
   document.formv1.m186r303.value = '<?php echo "$m186r303";?>';
   document.formv1.m186r304.value = '<?php echo "$m186r304";?>';
   document.formv1.m186r305.value = '<?php echo "$m186r305";?>';
   document.formv1.m186r306.value = '<?php echo "$m186r306";?>';
   document.formv1.m186r307.value = '<?php echo "$m186r307";?>';
   //document.formv1.m186r399.value = '<?php echo "$m186r399";?>';

   document.formv1.m304r01.value = '<?php echo "$m304r01";?>';
   document.formv1.m304r02.value = '<?php echo "$m304r02";?>';
   document.formv1.m304r03.value = '<?php echo "$m304r03";?>';
   document.formv1.m304r04.value = '<?php echo "$m304r04";?>';
   document.formv1.m304r05.value = '<?php echo "$m304r05";?>';
   document.formv1.m304r06.value = '<?php echo "$m304r06";?>';
   //document.formv1.m304r99.value = '<?php echo "$m304r99";?>';

<?php                      } ?>

<?php if ( $strana == 11 ) { ?>
   document.formv1.m527r101.value = '<?php echo "$m527r101";?>';
   document.formv1.m527r102.value = '<?php echo "$m527r102";?>';
   document.formv1.m527r103.value = '<?php echo "$m527r103";?>';
   document.formv1.m527r104.value = '<?php echo "$m527r104";?>';

   document.formv1.m527r201.value = '<?php echo "$m527r201";?>';
   document.formv1.m527r202.value = '<?php echo "$m527r202";?>';
   document.formv1.m527r203.value = '<?php echo "$m527r203";?>';
   document.formv1.m527r204.value = '<?php echo "$m527r204";?>';

   document.formv1.m527r301.value = '<?php echo "$m527r301";?>';
   document.formv1.m527r302.value = '<?php echo "$m527r302";?>';
   document.formv1.m527r303.value = '<?php echo "$m527r303";?>';
   document.formv1.m527r304.value = '<?php echo "$m527r304";?>';

   document.formv1.m527r401.value = '<?php echo "$m527r401";?>';
   document.formv1.m527r402.value = '<?php echo "$m527r402";?>';
   document.formv1.m527r403.value = '<?php echo "$m527r403";?>';
   document.formv1.m527r404.value = '<?php echo "$m527r404";?>';

   document.formv1.m527r501.value = '<?php echo "$m527r501";?>';
   document.formv1.m527r502.value = '<?php echo "$m527r502";?>';
   document.formv1.m527r503.value = '<?php echo "$m527r503";?>';
   document.formv1.m527r504.value = '<?php echo "$m527r504";?>';

   document.formv1.m527r601.value = '<?php echo "$m527r601";?>';
   document.formv1.m527r602.value = '<?php echo "$m527r602";?>';
   document.formv1.m527r603.value = '<?php echo "$m527r603";?>';
   document.formv1.m527r604.value = '<?php echo "$m527r604";?>';

   document.formv1.m527r701.value = '<?php echo "$m527r701";?>';
   document.formv1.m527r702.value = '<?php echo "$m527r702";?>';
   document.formv1.m527r703.value = '<?php echo "$m527r703";?>';
   document.formv1.m527r704.value = '<?php echo "$m527r704";?>';

   document.formv1.m527r801.value = '<?php echo "$m527r801";?>';
   document.formv1.m527r802.value = '<?php echo "$m527r802";?>';
   document.formv1.m527r803.value = '<?php echo "$m527r803";?>';
   document.formv1.m527r804.value = '<?php echo "$m527r804";?>';

   document.formv1.m527r901.value = '<?php echo "$m527r901";?>';
   document.formv1.m527r902.value = '<?php echo "$m527r902";?>';
   document.formv1.m527r903.value = '<?php echo "$m527r903";?>';
   document.formv1.m527r904.value = '<?php echo "$m527r904";?>';

   document.formv1.m527r1001.value = '<?php echo "$m527r1001";?>';
   document.formv1.m527r1002.value = '<?php echo "$m527r1002";?>';
   document.formv1.m527r1003.value = '<?php echo "$m527r1003";?>';
   document.formv1.m527r1004.value = '<?php echo "$m527r1004";?>';
<?php                      } ?>

<?php if ( $strana == 12 ) { ?>
   document.formv1.m474r101.value = '<?php echo "$m474r101";?>';
   document.formv1.m474r102.value = '<?php echo "$m474r102";?>';
   document.formv1.m474r103.value = '<?php echo "$m474r103";?>';
   document.formv1.m474r104.value = '<?php echo "$m474r104";?>';
   document.formv1.m474r105.value = '<?php echo "$m474r105";?>';
   document.formv1.m474r106.value = '<?php echo "$m474r106";?>';
   document.formv1.m474r107.value = '<?php echo "$m474r107";?>';
   //document.formv1.m474r199.value = '<?php echo "$m474r199";?>';

   document.formv1.m474r201.value = '<?php echo "$m474r201";?>';
   document.formv1.m474r202.value = '<?php echo "$m474r202";?>';
   document.formv1.m474r203.value = '<?php echo "$m474r203";?>';
   document.formv1.m474r204.value = '<?php echo "$m474r204";?>';
   document.formv1.m474r205.value = '<?php echo "$m474r205";?>';
   document.formv1.m474r206.value = '<?php echo "$m474r206";?>';
   document.formv1.m474r207.value = '<?php echo "$m474r207";?>';
   //document.formv1.m474r299.value = '<?php echo "$m474r299";?>';

   document.formv1.m474r301.value = '<?php echo "$m474r301";?>';
   document.formv1.m474r302.value = '<?php echo "$m474r302";?>';
   document.formv1.m474r303.value = '<?php echo "$m474r303";?>';
   document.formv1.m474r304.value = '<?php echo "$m474r304";?>';
   document.formv1.m474r305.value = '<?php echo "$m474r305";?>';
   document.formv1.m474r306.value = '<?php echo "$m474r306";?>';
   document.formv1.m474r307.value = '<?php echo "$m474r307";?>';
   //document.formv1.m474r399.value = '<?php echo "$m474r399";?>';
<?php                      } ?>

<?php if ( $strana == 13 ) { ?>
   document.formv1.m127r001.value = '<?php echo "$m127r001";?>';
   document.formv1.m127r002.value = '<?php echo "$m127r002";?>';
   document.formv1.m127r003.value = '<?php echo "$m127r003";?>';
   document.formv1.m127r004.value = '<?php echo "$m127r004";?>';
   document.formv1.m127r005.value = '<?php echo "$m127r005";?>';
   document.formv1.m127r006.value = '<?php echo "$m127r006";?>';
   document.formv1.m127r007.value = '<?php echo "$m127r007";?>';
   document.formv1.m127r008.value = '<?php echo "$m127r008";?>';
   document.formv1.m127r009.value = '<?php echo "$m127r009";?>';
   document.formv1.m127r010.value = '<?php echo "$m127r010";?>';
   document.formv1.m127r011.value = '<?php echo "$m127r011";?>';
   document.formv1.m127r012.value = '<?php echo "$m127r012";?>';
   document.formv1.m127r013.value = '<?php echo "$m127r013";?>';
   document.formv1.m127r014.value = '<?php echo "$m127r014";?>';
   document.formv1.m127r015.value = '<?php echo "$m127r015";?>';
   //document.formv1.m127r099.value = '<?php echo "$m127r099";?>';

   document.formv1.m127r101.value = '<?php echo "$m127r101";?>';
   document.formv1.m127r102.value = '<?php echo "$m127r102";?>';
   document.formv1.m127r103.value = '<?php echo "$m127r103";?>';
   document.formv1.m127r104.value = '<?php echo "$m127r104";?>';
   document.formv1.m127r105.value = '<?php echo "$m127r105";?>';
   document.formv1.m127r106.value = '<?php echo "$m127r106";?>';
   document.formv1.m127r107.value = '<?php echo "$m127r107";?>';
   document.formv1.m127r108.value = '<?php echo "$m127r108";?>';
   document.formv1.m127r109.value = '<?php echo "$m127r109";?>';
   document.formv1.m127r110.value = '<?php echo "$m127r110";?>';
   document.formv1.m127r111.value = '<?php echo "$m127r111";?>';
   document.formv1.m127r112.value = '<?php echo "$m127r112";?>';
   document.formv1.m127r113.value = '<?php echo "$m127r113";?>';
   document.formv1.m127r114.value = '<?php echo "$m127r114";?>';
   document.formv1.m127r115.value = '<?php echo "$m127r115";?>';
   //document.formv1.m127r199.value = '<?php echo "$m127r199";?>';

   document.formv1.m127r201.value = '<?php echo "$m127r201";?>';
   document.formv1.m127r202.value = '<?php echo "$m127r202";?>';
   document.formv1.m127r203.value = '<?php echo "$m127r203";?>';
   document.formv1.m127r204.value = '<?php echo "$m127r204";?>';
   document.formv1.m127r205.value = '<?php echo "$m127r205";?>';
   document.formv1.m127r206.value = '<?php echo "$m127r206";?>';
   document.formv1.m127r207.value = '<?php echo "$m127r207";?>';
   document.formv1.m127r208.value = '<?php echo "$m127r208";?>';
   document.formv1.m127r209.value = '<?php echo "$m127r209";?>';
   document.formv1.m127r210.value = '<?php echo "$m127r210";?>';
   document.formv1.m127r211.value = '<?php echo "$m127r211";?>';
   document.formv1.m127r212.value = '<?php echo "$m127r212";?>';
   document.formv1.m127r213.value = '<?php echo "$m127r213";?>';
   document.formv1.m127r214.value = '<?php echo "$m127r214";?>';
   document.formv1.m127r215.value = '<?php echo "$m127r215";?>';
   //document.formv1.m127r299.value = '<?php echo "$m127r299";?>';

   document.formv1.m127r301.value = '<?php echo "$m127r301";?>';
   document.formv1.m127r302.value = '<?php echo "$m127r302";?>';
   document.formv1.m127r303.value = '<?php echo "$m127r303";?>';
   document.formv1.m127r304.value = '<?php echo "$m127r304";?>';
   document.formv1.m127r305.value = '<?php echo "$m127r305";?>';
   document.formv1.m127r306.value = '<?php echo "$m127r306";?>';
   document.formv1.m127r307.value = '<?php echo "$m127r307";?>';
   document.formv1.m127r308.value = '<?php echo "$m127r308";?>';
   document.formv1.m127r309.value = '<?php echo "$m127r309";?>';
   document.formv1.m127r310.value = '<?php echo "$m127r310";?>';
   document.formv1.m127r311.value = '<?php echo "$m127r311";?>';
   document.formv1.m127r312.value = '<?php echo "$m127r312";?>';
   document.formv1.m127r313.value = '<?php echo "$m127r313";?>';
   document.formv1.m127r314.value = '<?php echo "$m127r314";?>';
   document.formv1.m127r315.value = '<?php echo "$m127r315";?>';
   //document.formv1.m127r399.value = '<?php echo "$m127r399";?>';

   document.formv1.m127r401.value = '<?php echo "$m127r401";?>';
   document.formv1.m127r402.value = '<?php echo "$m127r402";?>';
   document.formv1.m127r403.value = '<?php echo "$m127r403";?>';
   document.formv1.m127r404.value = '<?php echo "$m127r404";?>';
   document.formv1.m127r405.value = '<?php echo "$m127r405";?>';
   document.formv1.m127r406.value = '<?php echo "$m127r406";?>';
   document.formv1.m127r407.value = '<?php echo "$m127r407";?>';
   document.formv1.m127r408.value = '<?php echo "$m127r408";?>';
   document.formv1.m127r409.value = '<?php echo "$m127r409";?>';
   document.formv1.m127r410.value = '<?php echo "$m127r410";?>';
   document.formv1.m127r411.value = '<?php echo "$m127r411";?>';
   document.formv1.m127r412.value = '<?php echo "$m127r412";?>';
   document.formv1.m127r413.value = '<?php echo "$m127r413";?>';
   document.formv1.m127r414.value = '<?php echo "$m127r414";?>';
   document.formv1.m127r415.value = '<?php echo "$m127r415";?>';
   //document.formv1.m127r499.value = '<?php echo "$m127r499";?>';

   document.formv1.m127r501.value = '<?php echo "$m127r501";?>';
   document.formv1.m127r502.value = '<?php echo "$m127r502";?>';
   document.formv1.m127r503.value = '<?php echo "$m127r503";?>';
   document.formv1.m127r504.value = '<?php echo "$m127r504";?>';
   document.formv1.m127r505.value = '<?php echo "$m127r505";?>';
   document.formv1.m127r506.value = '<?php echo "$m127r506";?>';
   document.formv1.m127r507.value = '<?php echo "$m127r507";?>';
   document.formv1.m127r508.value = '<?php echo "$m127r508";?>';
   document.formv1.m127r509.value = '<?php echo "$m127r509";?>';
   document.formv1.m127r510.value = '<?php echo "$m127r510";?>';
   document.formv1.m127r511.value = '<?php echo "$m127r511";?>';
   document.formv1.m127r512.value = '<?php echo "$m127r512";?>';
   document.formv1.m127r513.value = '<?php echo "$m127r513";?>';
   document.formv1.m127r514.value = '<?php echo "$m127r514";?>';
   document.formv1.m127r515.value = '<?php echo "$m127r515";?>';
   //document.formv1.m127r599.value = '<?php echo "$m127r599";?>';

   document.formv1.m127r601.value = '<?php echo "$m127r601";?>';
   document.formv1.m127r602.value = '<?php echo "$m127r602";?>';
   document.formv1.m127r603.value = '<?php echo "$m127r603";?>';
   document.formv1.m127r604.value = '<?php echo "$m127r604";?>';
   document.formv1.m127r605.value = '<?php echo "$m127r605";?>';
   document.formv1.m127r606.value = '<?php echo "$m127r606";?>';
   document.formv1.m127r607.value = '<?php echo "$m127r607";?>';
   document.formv1.m127r608.value = '<?php echo "$m127r608";?>';
   document.formv1.m127r609.value = '<?php echo "$m127r609";?>';
   document.formv1.m127r610.value = '<?php echo "$m127r610";?>';
   document.formv1.m127r611.value = '<?php echo "$m127r611";?>';
   document.formv1.m127r612.value = '<?php echo "$m127r612";?>';
   document.formv1.m127r613.value = '<?php echo "$m127r613";?>';
   document.formv1.m127r614.value = '<?php echo "$m127r614";?>';
   document.formv1.m127r615.value = '<?php echo "$m127r615";?>';
   //document.formv1.m127r699.value = '<?php echo "$m127r699";?>';
<?php                      } ?>

<?php if ( $strana == 14 ) { ?>
   document.formv1.m128r101.value = '<?php echo "$m128r101";?>';
   document.formv1.m128r102.value = '<?php echo "$m128r102";?>';
   document.formv1.m128r103.value = '<?php echo "$m128r103";?>';
   document.formv1.m128r104.value = '<?php echo "$m128r104";?>';
   document.formv1.m128r105.value = '<?php echo "$m128r105";?>';
   document.formv1.m128r106.value = '<?php echo "$m128r106";?>';
   document.formv1.m128r107.value = '<?php echo "$m128r107";?>';
   document.formv1.m128r108.value = '<?php echo "$m128r108";?>';
   document.formv1.m128r109.value = '<?php echo "$m128r109";?>';
   document.formv1.m128r110.value = '<?php echo "$m128r110";?>';
   document.formv1.m128r111.value = '<?php echo "$m128r111";?>';
   //document.formv1.m128r199.value = '<?php echo "$m128r199";?>';

   document.formv1.m128r201.value = '<?php echo "$m128r201";?>';
   document.formv1.m128r202.value = '<?php echo "$m128r202";?>';
   document.formv1.m128r203.value = '<?php echo "$m128r203";?>';
   document.formv1.m128r204.value = '<?php echo "$m128r204";?>';
   document.formv1.m128r205.value = '<?php echo "$m128r205";?>';
   document.formv1.m128r206.value = '<?php echo "$m128r206";?>';
   document.formv1.m128r207.value = '<?php echo "$m128r207";?>';
   document.formv1.m128r208.value = '<?php echo "$m128r208";?>';
   document.formv1.m128r209.value = '<?php echo "$m128r209";?>';
   document.formv1.m128r210.value = '<?php echo "$m128r210";?>';
   document.formv1.m128r211.value = '<?php echo "$m128r211";?>';
   //document.formv1.m128r299.value = '<?php echo "$m128r299";?>';

   document.formv1.m128r301.value = '<?php echo "$m128r301";?>';
   document.formv1.m128r302.value = '<?php echo "$m128r302";?>';
   document.formv1.m128r303.value = '<?php echo "$m128r303";?>';
   document.formv1.m128r304.value = '<?php echo "$m128r304";?>';
   document.formv1.m128r305.value = '<?php echo "$m128r305";?>';
   document.formv1.m128r306.value = '<?php echo "$m128r306";?>';
   document.formv1.m128r307.value = '<?php echo "$m128r307";?>';
   document.formv1.m128r308.value = '<?php echo "$m128r308";?>';
   document.formv1.m128r309.value = '<?php echo "$m128r309";?>';
   document.formv1.m128r310.value = '<?php echo "$m128r310";?>';
   document.formv1.m128r311.value = '<?php echo "$m128r311";?>';
   //document.formv1.m128r399.value = '<?php echo "$m128r399";?>';

   document.formv1.m128r401.value = '<?php echo "$m128r401";?>';
   document.formv1.m128r402.value = '<?php echo "$m128r402";?>';
   document.formv1.m128r403.value = '<?php echo "$m128r403";?>';
   document.formv1.m128r404.value = '<?php echo "$m128r404";?>';
   document.formv1.m128r405.value = '<?php echo "$m128r405";?>';
   document.formv1.m128r406.value = '<?php echo "$m128r406";?>';
   document.formv1.m128r407.value = '<?php echo "$m128r407";?>';
   document.formv1.m128r408.value = '<?php echo "$m128r408";?>';
   document.formv1.m128r409.value = '<?php echo "$m128r409";?>';
   document.formv1.m128r410.value = '<?php echo "$m128r410";?>';
   document.formv1.m128r411.value = '<?php echo "$m128r411";?>';
   //document.formv1.m128r499.value = '<?php echo "$m128r499";?>';

   document.formv1.m128r501.value = '<?php echo "$m128r501";?>';
   document.formv1.m128r502.value = '<?php echo "$m128r502";?>';
   document.formv1.m128r503.value = '<?php echo "$m128r503";?>';
   document.formv1.m128r504.value = '<?php echo "$m128r504";?>';
   document.formv1.m128r505.value = '<?php echo "$m128r505";?>';
   document.formv1.m128r506.value = '<?php echo "$m128r506";?>';
   document.formv1.m128r507.value = '<?php echo "$m128r507";?>';
   document.formv1.m128r508.value = '<?php echo "$m128r508";?>';
   document.formv1.m128r509.value = '<?php echo "$m128r509";?>';
   document.formv1.m128r510.value = '<?php echo "$m128r510";?>';
   document.formv1.m128r511.value = '<?php echo "$m128r511";?>';
   //document.formv1.m128r599.value = '<?php echo "$m128r599";?>';
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
   window.open('../dokumenty/statistika2014/cpa_ciselnik_pril2v13.pdf', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function CisCPAp1()
  {
   window.open('../dokumenty/statistika2014/cpa_ciselnik_pril1v13.pdf', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function MetodVypln()
  {
   window.open('../dokumenty/statistika2014/opu201/opu201v14_metod_pokyny.pdf', '_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('../ucto/statistika_opu201_2014.php?copern=11&strana=9999', '_blank');
  }
  function StatUdajeFirma()
  {
   window.open('../mzdy/trexima.php?cislo_oc=1&copern=1&drupoh=1&fmzdy=<?php echo $kli_vxcf; ?>&page=1&subor=0', '_blank', 'width=1080, height=900, top=0, left=30, status=yes, resizable=yes, scrollbars=yes');
  }
  function NacitajMzdy()
  {
   window.open('../ucto/statistika_opu201_2014.php?copern=200&drupoh=1&page=1', '_self');
  }
  function NacitajModuly()
  {
   window.open('../ucto/uobrat.php?modul=9200&copern=200&drupoh=1&page=1&typ=PDF&cstat=10201&vyb_ume=<?php echo "12.".$kli_vrok; ?>', '_self');
  }
  function NacitajZobratovky(modul)
  {
   window.open('../ucto/uobrat.php?modul=' + modul + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=10201&vyb_ume=<?php echo "12.".$kli_vrok; ?>', '_self');
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
  <td class="header">Ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch v obchode, ...</td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/infocloud_blue_icon.png" onclick="CisCPAp2();"
     title="��seln�k CPA - pr�loha �. 2" class="btn-form-tool">
    <img src="../obr/ikony/infocloud_blue_icon.png" onclick="CisCPAp1();"
     title="��seln�k CPA - pr�loha �. 1" class="btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Metodick� vysvetlivky k obsahu v�kazu" class="btn-form-tool">
    <img src="../obr/ikony/download_blue_icon.png" onclick="NacitajModuly();" title="Na��ta� �daje do v�etk�ch modulov" class="btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobrazi� v�etky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<?php
$sirka=950;
$vyska=1300;
if ( $strana == 11 ) { $sirka=1250; $vyska=800; }
?>
<div id="content" style="width:<?php echo $sirka; ?>px; height:<?php echo $vyska; ?>px;">
<FORM name="formv1" method="post" action="statistika_opu201_2014.php?copern=103&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive";
$clas5="noactive"; $clas6="noactive"; $clas7="noactive"; $clas8="noactive";
$clas9="noactive"; $clas10="noactive"; $clas11="noactive"; $clas12="noactive";
$clas13="noactive"; $clas14="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active"; if ( $strana == 6 ) $clas6="active";
if ( $strana == 7 ) $clas7="active"; if ( $strana == 8 ) $clas8="active";
if ( $strana == 9 ) $clas9="active"; if ( $strana == 10 ) $clas10="active";
if ( $strana == 11 ) $clas11="active"; if ( $strana == 12 ) $clas12="active";
if ( $strana == 13 ) $clas13="active"; if ( $strana == 14 ) $clas14="active";
$source="statistika_opu201_2014.php?";
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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=14', '_self');" class="<?php echo $clas14; ?> toleft">14</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=11&strana=14', '_blank');" class="<?php echo $clas14; ?> toright">14</a>
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
 <h6 class="toright">Tla�i�:</h6>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-top-formsave">
</div>
<?php
$kli_vrokx = substr($kli_vrok,2,2);
$mesiacx=$mesiac; if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; }
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }
?>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str1.jpg"
 alt="tla�ivo Ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 1.strana 441kB" class="form-background">
<span class="text-echo" style="top:230px; left:475px; font-size:24px;"><?php echo $kli_vrok; ?></span>
<span class="text-echo" style="top:306px; left:314px; font-size:18px; letter-spacing:23px;"><?php echo $kli_vrokx; ?></span>
<span class="text-echo" style="top:306px; left:378px; font-size:18px; letter-spacing:23px;"><?php echo $mesiacx; ?></span>
<span class="text-echo" style="top:306px; left:445px; font-size:18px; letter-spacing:25px;"><?php echo $fir_ficox; ?></span>
<!-- ORGANIZACIA -->
<span class="text-echo" style="top:693px; left:53px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:714px; left:53px;"><?php echo "$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc"; ?></span>
<span class="text-echo" style="top:693px; left:808px;"><?php echo $okres; ?></span>
 <img src="../obr/ikony/pencil_blue_icon.png" onclick="StatUdajeFirma();" title="Nastavi� k�d okresu"
  class="btn-row-tool" style="top:690px; left:839px;">
<!-- Vyplnil -->
<span class="text-echo" style="top:764px; left:53px;"><?php echo $fir_mzdt05; ?></span>
<span class="text-echo" style="top:780px; left:388px;"><?php echo $fir_mzdt04; ?></span>
<span class="text-echo" style="top:830px; left:53px;"><?php echo $fir_fem1; ?></span>
<input type="text" name="odoslane" id="odoslane" onkeyup="CiarkaNaBodku(this);"
 style="width:90px; top:827px; left:390px;"/>

<!-- modul 100041 -->
<script>
  function klikm100041ano()
  {
   document.formv1.mod100041nie.checked = false;
  }
  function klikm100041nie()
  {
   document.formv1.mod100041ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100041ano" value="1" onchange="klikm100041ano();"
 style="top:958px; left:839px;"/>
<input type="checkbox" name="mod100041nie" value="1" onchange="klikm100041nie();"
 style="top:978px; left:839px;"/>

<!-- modul 100042 -->
<script>
  function klikm100042ano()
  {
   document.formv1.mod100042nie.checked = false;
  }
  function klikm100042nie()
  {
   document.formv1.mod100042ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100042ano" value="1" onchange="klikm100042ano();"
 style="top:1068px; left:839px;"/>
<input type="checkbox" name="mod100042nie" value="1" onchange="klikm100042nie();"
 style="top:1088px; left:839px;"/>

<!-- modul 100043 -->
<script>
  function klikm100043ano()
  {
   document.formv1.mod100043nie.checked = false;
  }
  function klikm100043nie()
  {
   document.formv1.mod100043ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100043ano" value="1" onchange="klikm100043ano();"
 style="top:1178px; left:839px;"/>
<input type="checkbox" name="mod100043nie" value="1" onchange="klikm100043nie();"
 style="top:1198px; left:839px;"/>
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str2.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 2.strana 235kB" class="form-background">

<!-- modul 100038 -->
<input type="text" name="mod100038" id="mod100038"
 style="width:253px; top:130px; left:643px;"/>

<!-- modul 100039 -->
<input type="text" name="mod100039" id="mod100039"
 style="width:253px; top:193px; left:643px;"/>

<!-- modul 100040 -->
<input type="text" name="mod100040" id="mod100040"
 style="width:253px; top:256px; left:643px;"/>

<!-- modul 100036 -->
<script>
  function klikm100036kal()
  {
   document.formv1.mod100036hos.checked = false;
  }
  function klikm100036hos()
  {
   document.formv1.mod100036kal.checked = false;
  }
</script>
<input type="checkbox" name="mod100036kal" value="1" onchange="klikm100036kal();"
 style="top:322px; left:839px;"/>
<input type="checkbox" name="mod100036hos" value="1" onchange="klikm100036hos();"
 style="top:343px; left:839px;"/>

<!-- modul 100037 -->
<input type="text" name="mod100037" id="mod100037"
 style="width:253px; top:421px; left:643px;"/>

<!-- modul 100069 -->
<script>
  function klikm100069ano()
  {
   document.formv1.mod100069nie.checked = false;
  }
  function klikm100069nie()
  {
   document.formv1.mod100069ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100069ano" value="1" onchange="klikm100069ano();"
 style="top:549px; left:839px;"/>
<input type="checkbox" name="mod100069nie" value="1" onchange="klikm100069nie();"
 style="top:569px; left:839px;"/>

<!-- modul 100086 -->
<script>
  function klikm100086ano()
  {
   document.formv1.mod100086nie.checked = false;
  }
  function klikm100086nie()
  {
   document.formv1.mod100086ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100086ano" value="1" onchange="klikm100086ano();"
 style="top:632px; left:839px;"/>
<input type="checkbox" name="mod100086nie" value="1" onchange="klikm100086nie();"
 style="top:652px; left:839px;"/>

<!-- modul 100087 -->
<script>
  function klikm100087ano()
  {
   document.formv1.mod100087nie.checked = false;
  }
  function klikm100087nie()
  {
   document.formv1.mod100087ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100087ano" value="1" onchange="klikm100087ano();"
 style="top:747px; left:839px;"/>
<input type="checkbox" name="mod100087nie" value="1" onchange="klikm100087nie();"
 style="top:767px; left:839px;"/>

<!-- modul 100088 -->
<script>
  function klikm100088ano()
  {
   document.formv1.mod100088nie.checked = false;
  }
  function klikm100088nie()
  {
   document.formv1.mod100088ano.checked = false;
  }
</script>
<input type="checkbox" name="mod100088ano" value="1" onchange="klikm100088ano();"
 style="top:890px; left:839px;"/>
<input type="checkbox" name="mod100088nie" value="1" onchange="klikm100088nie();"
 style="top:911px; left:839px;"/>

<!-- modul 100089 -->
<input type="text" name="mod100089" id="mod100089"
 style="width:253px; top:1018px; left:643px;"/>

<!-- modul 100090 -->
<input type="text" name="mod100090" id="mod100090"
 style="width:253px; top:1113px; left:643px;"/>

<!-- modul 100091 -->
<input type="text" name="mod100091" id="mod100091"
 style="width:253px; top:1205px; left:643px;"/>
<?php                                        } ?>


<?php if ( $strana == 3 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str3.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 3.strana 235kB"
 class="form-background">
<span class="text-echo" style="top:96px; left:435px; font-size:16px; letter-spacing:28px;"><?php echo $fir_ficox; ?></span>

<!-- modul 2 -->
<input type="text" name="mod2r01" id="mod2r01" style="width:100px; top:281px; left:680px;"/>
<input type="text" name="mod2r02" id="mod2r02" style="width:100px; top:307px; left:680px;"/>

<!-- modul 398a -->
<input type="text" name="m398r01" id="m398r01" style="width:100px; top:493px; left:680px;"/>
<input type="text" name="m398r02" id="m398r02" style="width:100px; top:519px; left:680px;"/>
<span class="text-echo" style="top:548px; right:165px;"><?php echo $m398r99; ?></span>

<!-- modul 405a -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(405);" style="top:601px; left:448px;" class="btn-row-tool">
<input type="text" name="m405r01" id="m405r01" style="width:100px; top:698px; left:680px;"/>
<input type="text" name="m405r02" id="m405r02" style="width:100px; top:724px; left:680px;"/>
<input type="text" name="m405r03" id="m405r03" style="width:100px; top:750px; left:680px;"/>
<input type="text" name="m405r04" id="m405r04" style="width:100px; top:776px; left:680px;"/>
<input type="text" name="m405r05" id="m405r05" style="width:100px; top:807px; left:680px;"/>
<input type="text" name="m405r06" id="m405r06" style="width:100px; top:844px; left:680px;"/>
<span class="text-echo" style="top:880px; right:165px;"><?php echo $m405r99; ?></span>

<!-- modul 558c -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(558);" style="top:932px; left:385px;" class="btn-row-tool">
<input type="text" name="m558r01" id="m558r01" style="width:100px; top:1029px; left:680px;"/>
<input type="text" name="m558r02" id="m558r02" style="width:100px; top:1055px; left:680px;"/>
<input type="text" name="m558r03" id="m558r03" style="width:100px; top:1081px; left:680px;"/>
<input type="text" name="m558r04" id="m558r04" style="width:100px; top:1107px; left:680px;"/>
<input type="text" name="m558r05" id="m558r05" style="width:100px; top:1133px; left:680px;"/>
<input type="text" name="m558r06" id="m558r06" style="width:100px; top:1159px; left:680px;"/>
<span class="text-echo" style="top:1188px; right:165px;"><?php echo $m558r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 4 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str4.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 4.strana 279kB" class="form-background">

<!-- modul 580a -->
<input type="text" name="m580r11" id="m580r11" style="width:100px; top:175px; left:590px;"/>
<input type="text" name="m580r12" id="m580r12" style="width:100px; top:201px; left:590px;"/>
<span class="text-echo" style="top:230px; right:253px;"><?php echo $m580r199; ?></span>
<input type="text" name="m580r21" id="m580r21" style="width:100px; top:175px; left:765px;"/>
<input type="text" name="m580r22" id="m580r22" style="width:100px; top:201px; left:765px;"/>
<span class="text-echo" style="top:230px; right:79px;"><?php echo $m580r299; ?></span>

<!-- modul 586b -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(586);" style="top:263px; left:337px;" class="btn-row-tool">
<input type="text" name="m586r11" id="m586r11" style="width:100px; top:359px; left:590px;"/>
<input type="text" name="m586r12" id="m586r12" style="width:100px; top:385px; left:590px;"/>
<input type="text" name="m586r13" id="m586r13" style="width:100px; top:411px; left:590px;"/>
<input type="text" name="m586r14" id="m586r14" style="width:100px; top:437px; left:590px;"/>
<span class="text-echo" style="top:467px; right:253px;"><?php echo $m586r199; ?></span>
<input type="text" name="m586r21" id="m586r21" style="width:100px; top:359px; left:765px;"/>
<input type="text" name="m586r22" id="m586r22" style="width:100px; top:385px; left:765px;"/>
<input type="text" name="m586r23" id="m586r23" style="width:100px; top:411px; left:765px;"/>
<input type="text" name="m586r24" id="m586r24" style="width:100px; top:437px; left:765px;"/>
<span class="text-echo" style="top:467px; right:79px;"><?php echo $m586r299; ?></span>

<!-- modul 100062 -->
<script>
  function klikm100062ano()
  {
   document.formv1.m100062nie.checked = false;
  }
  function klikm100062nie()
  {
   document.formv1.m100062ano.checked = false;
  }
</script>
<input type="checkbox" name="m100062ano" value="1" onchange="klikm100062ano();"
 style="top:528px; left:839px;"/>
<input type="checkbox" name="m100062nie" value="1" onchange="klikm100062nie();"
 style="top:548px; left:839px;"/>

<!-- modul 585 -->
<input type="text" name="m585r01" id="m585r01" style="width:100px; top:874px; left:680px;"/>
<input type="text" name="m585r02" id="m585r02" style="width:100px; top:906px; left:680px;"/>
<input type="text" name="m585r3k" id="m585r3k" style="width:112px; top:937px; left:397px;"/>
<input type="text" name="m585r03" id="m585r03" style="width:100px; top:937px; left:680px;"/>
<input type="text" name="m585r4k" id="m585r4k" style="width:112px; top:962px; left:397px;"/>
<input type="text" name="m585r04" id="m585r04" style="width:100px; top:962px; left:680px;"/>
<input type="text" name="m585r5k" id="m585r5k" style="width:112px; top:988px; left:397px;"/>
<input type="text" name="m585r05" id="m585r05" style="width:100px; top:988px; left:680px;"/>

<!-- modul 100044 -->
<script>
  function klikm100044ano()
  {
   document.formv1.m100044nie.checked = false;
  }
  function klikm100044nie()
  {
   document.formv1.m100044ano.checked = false;
  }
</script>
<input type="checkbox" name="m100044ano" value="1" onchange="klikm100044ano();"
 style="top:1153px; left:839px;"/>
<input type="checkbox" name="m100044nie" value="1" onchange="klikm100044nie();"
 style="top:1173px; left:839px;"/>
<?php                                        } ?>


<?php if ( $strana == 5 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str5.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 5.strana 238kB" class="form-background">
<span class="text-echo" style="top:85px; left:435px; font-size:16px; letter-spacing:28px;"><?php echo $fir_ficox; ?></span>

<!-- modul 571 -->
<input type="text" name="m571r10" id="m571r10" style="width:115px; top:338px; left:50px;"/>
<?php $cslr="1."; if ( $m571r10 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:342px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r12" id="m571r12" style="width:100px; top:338px; left:268px;"/>
<input type="text" name="m571r13" id="m571r13" style="width:58px; top:338px; left:378px;"/>
<input type="text" name="m571r15" id="m571r15" style="width:81px; top:338px; left:514px;"/>
<input type="text" name="m571r16" id="m571r16" style="width:92px; top:338px; left:605px;"/>
<input type="text" name="m571r17" id="m571r17" style="width:102px; top:338px; left:707px;"/>
<input type="text" name="m571r18" id="m571r18" style="width:71px; top:338px; left:820px;"/>
<input type="text" name="m571r20" id="m571r20" style="width:115px; top:364px; left:50px;"/>
<?php $cslr="2."; if ( $m571r20 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:368px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r22" id="m571r22" style="width:100px; top:364px; left:268px;"/>
<input type="text" name="m571r23" id="m571r23" style="width:58px; top:364px; left:378px;"/>
<input type="text" name="m571r25" id="m571r25" style="width:81px; top:364px; left:514px;"/>
<input type="text" name="m571r26" id="m571r26" style="width:92px; top:364px; left:605px;"/>
<input type="text" name="m571r27" id="m571r27" style="width:102px; top:364px; left:707px;"/>
<input type="text" name="m571r28" id="m571r28" style="width:71px; top:364px; left:820px;"/>
<input type="text" name="m571r30" id="m571r30" style="width:115px; top:390px; left:50px;"/>
<?php $cslr="3."; if ( $m571r30 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:395px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r32" id="m571r32" style="width:100px; top:390px; left:268px;"/>
<input type="text" name="m571r33" id="m571r33" style="width:58px; top:390px; left:378px;"/>
<input type="text" name="m571r35" id="m571r35" style="width:81px; top:390px; left:514px;"/>
<input type="text" name="m571r36" id="m571r36" style="width:92px; top:390px; left:605px;"/>
<input type="text" name="m571r37" id="m571r37" style="width:102px; top:390px; left:707px;"/>
<input type="text" name="m571r38" id="m571r38" style="width:71px; top:390px; left:820px;"/>
<input type="text" name="m571r40" id="m571r40" style="width:115px; top:416px; left:50px;"/>
<?php $cslr="4."; if ( $m571r40 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:420px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r42" id="m571r42" style="width:100px; top:416px; left:268px;"/>
<input type="text" name="m571r43" id="m571r43" style="width:58px; top:416px; left:378px;"/>
<input type="text" name="m571r45" id="m571r45" style="width:81px; top:416px; left:514px;"/>
<input type="text" name="m571r46" id="m571r46" style="width:92px; top:416px; left:605px;"/>
<input type="text" name="m571r47" id="m571r47" style="width:102px; top:416px; left:707px;"/>
<input type="text" name="m571r48" id="m571r48" style="width:71px; top:416px; left:820px;"/>
<input type="text" name="m571r50" id="m571r50" style="width:115px; top:442px; left:50px;"/>
<?php $cslr="5."; if ( $m571r50 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:446px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r52" id="m571r52" style="width:100px; top:442px; left:268px;"/>
<input type="text" name="m571r53" id="m571r53" style="width:58px; top:442px; left:378px;"/>
<input type="text" name="m571r55" id="m571r55" style="width:81px; top:442px; left:514px;"/>
<input type="text" name="m571r56" id="m571r56" style="width:92px; top:442px; left:605px;"/>
<input type="text" name="m571r57" id="m571r57" style="width:102px; top:442px; left:707px;"/>
<input type="text" name="m571r58" id="m571r58" style="width:71px; top:442px; left:820px;"/>
<input type="text" name="m571r60" id="m571r60" style="width:115px; top:468px; left:50px;"/>
<?php $cslr="6."; if ( $m571r60 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:472px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r62" id="m571r62" style="width:100px; top:468px; left:268px;"/>
<input type="text" name="m571r63" id="m571r63" style="width:58px; top:468px; left:378px;"/>
<input type="text" name="m571r65" id="m571r65" style="width:81px; top:468px; left:514px;"/>
<input type="text" name="m571r66" id="m571r66" style="width:92px; top:468px; left:605px;"/>
<input type="text" name="m571r67" id="m571r67" style="width:102px; top:468px; left:707px;"/>
<input type="text" name="m571r68" id="m571r68" style="width:71px; top:468px; left:820px;"/>
<input type="text" name="m571r70" id="m571r70" style="width:115px; top:494px; left:50px;"/>
<?php $cslr="7."; if ( $m571r70 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:497px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r72" id="m571r72" style="width:100px; top:494px; left:268px;"/>
<input type="text" name="m571r73" id="m571r73" style="width:58px; top:494px; left:378px;"/>
<input type="text" name="m571r75" id="m571r75" style="width:81px; top:494px; left:514px;"/>
<input type="text" name="m571r76" id="m571r76" style="width:92px; top:494px; left:605px;"/>
<input type="text" name="m571r77" id="m571r77" style="width:102px; top:494px; left:707px;"/>
<input type="text" name="m571r78" id="m571r78" style="width:71px; top:494px; left:820px;"/>
<input type="text" name="m571r80" id="m571r80" style="width:115px; top:519px; left:50px;"/>
<?php $cslr="8."; if ( $m571r80 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:523px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r82" id="m571r82" style="width:100px; top:519px; left:268px;"/>
<input type="text" name="m571r83" id="m571r83" style="width:58px; top:519px; left:378px;"/>
<input type="text" name="m571r85" id="m571r85" style="width:81px; top:519px; left:514px;"/>
<input type="text" name="m571r86" id="m571r86" style="width:92px; top:519px; left:605px;"/>
<input type="text" name="m571r87" id="m571r87" style="width:102px; top:519px; left:707px;"/>
<input type="text" name="m571r88" id="m571r88" style="width:71px; top:519px; left:820px;"/>
<input type="text" name="m571r90" id="m571r90" style="width:115px; top:545px; left:50px;"/>
<?php $cslr="9."; if ( $m571r30 == '' ) { $cslr=""; } ?>
 <span class="text-echo" style="top:549px; left:224px;"><?php echo $cslr; ?></span>
<input type="text" name="m571r92" id="m571r92" style="width:100px; top:545px; left:268px;"/>
<input type="text" name="m571r93" id="m571r93" style="width:58px; top:545px; left:378px;"/>
<input type="text" name="m571r95" id="m571r95" style="width:81px; top:545px; left:514px;"/>
<input type="text" name="m571r96" id="m571r96" style="width:92px; top:545px; left:605px;"/>
<input type="text" name="m571r97" id="m571r97" style="width:102px; top:545px; left:707px;"/>
<input type="text" name="m571r98" id="m571r98" style="width:71px; top:545px; left:820px;"/>

<!-- modul 516b -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(516);" style="top:678px; left:530px;" class="btn-row-tool">
<input type="text" name="m516r101" id="m516r101" style="width:100px; top:780px; left:590px;"/>
<input type="text" name="m516r102" id="m516r102" style="width:100px; top:806px; left:590px;"/>
<input type="text" name="m516r103" id="m516r103" style="width:100px; top:831px; left:590px;"/>
<input type="text" name="m516r104" id="m516r104" style="width:100px; top:857px; left:590px;"/>
<input type="text" name="m516r105" id="m516r105" style="width:100px; top:883px; left:590px;"/>
<input type="text" name="m516r106" id="m516r106" style="width:100px; top:909px; left:590px;"/>
<input type="text" name="m516r107" id="m516r107" style="width:100px; top:935px; left:590px;"/>
<input type="text" name="m516r108" id="m516r108" style="width:100px; top:961px; left:590px;"/>
<input type="text" name="m516r109" id="m516r109" style="width:100px; top:987px; left:590px;"/>
<input type="text" name="m516r110" id="m516r110" style="width:100px; top:1012px; left:590px;"/>
<input type="text" name="m516r111" id="m516r111" style="width:100px; top:1038px; left:590px;"/>
<input type="text" name="m516r112" id="m516r112" style="width:100px; top:1064px; left:590px;"/>
<input type="text" name="m516r113" id="m516r113" style="width:100px; top:1090px; left:590px;"/>
<input type="text" name="m516r114" id="m516r114" style="width:100px; top:1116px; left:590px;"/>
<span class="text-echo" style="top:1146px; right:254px;"><?php echo $m516r199; ?></span>
<input type="text" name="m516r201" id="m516r201" style="width:100px; top:780px; left:765px;"/>
<input type="text" name="m516r202" id="m516r202" style="width:100px; top:806px; left:765px;"/>
<input type="text" name="m516r203" id="m516r203" style="width:100px; top:831px; left:765px;"/>
<input type="text" name="m516r204" id="m516r204" style="width:100px; top:857px; left:765px;"/>
<input type="text" name="m516r205" id="m516r205" style="width:100px; top:883px; left:765px;"/>
<input type="text" name="m516r206" id="m516r206" style="width:100px; top:909px; left:765px;"/>
<input type="text" name="m516r207" id="m516r207" style="width:100px; top:935px; left:765px;"/>
<input type="text" name="m516r208" id="m516r208" style="width:100px; top:961px; left:765px;"/>
<input type="text" name="m516r209" id="m516r209" style="width:100px; top:987px; left:765px;"/>
<input type="text" name="m516r210" id="m516r210" style="width:100px; top:1012px; left:765px;"/>
<input type="text" name="m516r211" id="m516r211" style="width:100px; top:1038px; left:765px;"/>
<input type="text" name="m516r212" id="m516r212" style="width:100px; top:1064px; left:765px;"/>
<input type="text" name="m516r213" id="m516r213" style="width:100px; top:1090px; left:765px;"/>
<input type="text" name="m516r214" id="m516r214" style="width:100px; top:1116px; left:765px;"/>
<span class="text-echo" style="top:1146px; right:79px;"><?php echo $m516r299; ?></span>
<?php                                        } ?>


<?php if ( $strana == 6 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str6.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 6.strana 271kB" class="form-background">

<!-- modul 513b -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(513);" style="top:78px; left:358px;" class="btn-row-tool">
<input type="text" name="m513r101" id="m513r101" style="width:87px; top:203px; left:360px;"/>
<input type="text" name="m513r102" id="m513r102" style="width:87px; top:227px; left:360px;"/>
<input type="text" name="m513r103" id="m513r103" style="width:87px; top:251px; left:360px;"/>
<input type="text" name="m513r104" id="m513r104" style="width:87px; top:275px; left:360px;"/>
<input type="text" name="m513r105" id="m513r105" style="width:87px; top:299px; left:360px;"/>
<input type="text" name="m513r106" id="m513r106" style="width:87px; top:330px; left:360px;"/>
<input type="text" name="m513r107" id="m513r107" style="width:87px; top:366px; left:360px;"/>
<input type="text" name="m513r108" id="m513r108" style="width:87px; top:396px; left:360px;"/>
<input type="text" name="m513r109" id="m513r109" style="width:87px; top:427px; left:360px;"/>
<input type="text" name="m513r110" id="m513r110" style="width:87px; top:457px; left:360px;"/>
<span class="text-echo" style="top:485px; right:500px;"><?php echo $m513r199; ?></span>
<input type="text" name="m513r201" id="m513r201" style="width:72px; top:203px; left:458px;"/>
<input type="text" name="m513r202" id="m513r202" style="width:72px; top:227px; left:458px;"/>
<input type="text" name="m513r203" id="m513r203" style="width:72px; top:251px; left:458px;"/>
<input type="text" name="m513r204" id="m513r204" style="width:72px; top:275px; left:458px;"/>
<input type="text" name="m513r205" id="m513r205" style="width:72px; top:299px; left:458px;"/>
<input type="text" name="m513r206" id="m513r206" style="width:72px; top:330px; left:458px;"/>
<input type="text" name="m513r207" id="m513r207" style="width:72px; top:366px; left:458px;"/>
<input type="text" name="m513r208" id="m513r208" style="width:72px; top:396px; left:458px;"/>
<input type="text" name="m513r209" id="m513r209" style="width:72px; top:427px; left:458px;"/>
<input type="text" name="m513r210" id="m513r210" style="width:72px; top:457px; left:458px;"/>
<span class="text-echo" style="top:485px; right:417px;"><?php echo $m513r299; ?></span>
<input type="text" name="m513r301" id="m513r301" style="width:79px; top:203px; left:541px;"/>
<input type="text" name="m513r302" id="m513r302" style="width:79px; top:227px; left:541px;"/>
<input type="text" name="m513r303" id="m513r303" style="width:79px; top:251px; left:541px;"/>
<input type="text" name="m513r304" id="m513r304" style="width:79px; top:275px; left:541px;"/>
<input type="text" name="m513r305" id="m513r305" style="width:79px; top:299px; left:541px;"/>
<input type="text" name="m513r306" id="m513r306" style="width:79px; top:330px; left:541px;"/>
<input type="text" name="m513r307" id="m513r307" style="width:79px; top:366px; left:541px;"/>
<input type="text" name="m513r308" id="m513r308" style="width:79px; top:396px; left:541px;"/>
<input type="text" name="m513r309" id="m513r309" style="width:79px; top:427px; left:541px;"/>
<input type="text" name="m513r310" id="m513r310" style="width:79px; top:457px; left:541px;"/>
<span class="text-echo" style="top:485px; right:328px;"><?php echo $m513r399; ?></span>
<input type="text" name="m513r401" id="m513r401" style="width:79px; top:203px; left:632px;"/>
<input type="text" name="m513r402" id="m513r402" style="width:79px; top:227px; left:632px;"/>
<input type="text" name="m513r403" id="m513r403" style="width:79px; top:251px; left:632px;"/>
<input type="text" name="m513r404" id="m513r404" style="width:79px; top:275px; left:632px;"/>
<input type="text" name="m513r405" id="m513r405" style="width:79px; top:299px; left:632px;"/>
<input type="text" name="m513r406" id="m513r406" style="width:79px; top:330px; left:632px;"/>
<input type="text" name="m513r407" id="m513r407" style="width:79px; top:366px; left:632px;"/>
<input type="text" name="m513r408" id="m513r408" style="width:79px; top:396px; left:632px;"/>
<input type="text" name="m513r409" id="m513r409" style="width:79px; top:427px; left:632px;"/>
<input type="text" name="m513r410" id="m513r410" style="width:79px; top:457px; left:632px;"/>
<span class="text-echo" style="top:485px; right:237px;"><?php echo $m513r499; ?></span>
<input type="text" name="m513r501" id="m513r501" style="width:87px; top:203px; left:722px;"/>
<input type="text" name="m513r502" id="m513r502" style="width:87px; top:227px; left:722px;"/>
<input type="text" name="m513r503" id="m513r503" style="width:87px; top:251px; left:722px;"/>
<input type="text" name="m513r504" id="m513r504" style="width:87px; top:275px; left:722px;"/>
<input type="text" name="m513r505" id="m513r505" style="width:87px; top:299px; left:722px;"/>
<input type="text" name="m513r506" id="m513r506" style="width:87px; top:330px; left:722px;"/>
<input type="text" name="m513r507" id="m513r507" style="width:87px; top:366px; left:722px;"/>
<input type="text" name="m513r508" id="m513r508" style="width:87px; top:396px; left:722px;"/>
<input type="text" name="m513r509" id="m513r509" style="width:87px; top:427px; left:722px;"/>
<input type="text" name="m513r510" id="m513r510" style="width:87px; top:457px; left:722px;"/>
<span class="text-echo" style="top:485px; right:138px;"><?php echo $m513r599; ?></span>
<input type="text" name="m513r601" id="m513r601" style="width:71px; top:203px; left:820px;"/>
<input type="text" name="m513r602" id="m513r602" style="width:71px; top:227px; left:820px;"/>
<input type="text" name="m513r603" id="m513r603" style="width:71px; top:251px; left:820px;"/>
<input type="text" name="m513r604" id="m513r604" style="width:71px; top:275px; left:820px;"/>
<input type="text" name="m513r605" id="m513r605" style="width:71px; top:299px; left:820px;"/>
<input type="text" name="m513r606" id="m513r606" style="width:71px; top:330px; left:820px;"/>
<input type="text" name="m513r607" id="m513r607" style="width:71px; top:366px; left:820px;"/>
<input type="text" name="m513r608" id="m513r608" style="width:71px; top:396px; left:820px;"/>
<input type="text" name="m513r609" id="m513r609" style="width:71px; top:427px; left:820px;"/>
<input type="text" name="m513r610" id="m513r610" style="width:71px; top:457px; left:820px;"/>
<span class="text-echo" style="top:485px; right:57px;"><?php echo $m513r699; ?></span>

<!-- modul 581a -->
<input type="text" name="m581r01" id="m581r01" style="width:100px; top:602px; left:680px;"/>
<input type="text" name="m581r02" id="m581r02" style="width:100px; top:626px; left:680px;"/>
<span class="text-echo" style="top:654px; right:165px;"><?php echo $m581r99; ?></span>

<!-- modul 588 -->
<input type="checkbox" name="m588r201" value="1" style="top:795px; left:719px;"/>
<input type="checkbox" name="m588r202" value="1" style="top:818px; left:719px;"/>
<input type="checkbox" name="m588r203" value="1" style="top:843px; left:719px;"/>
<input type="checkbox" name="m588r204" value="1" style="top:866px; left:719px;"/>
<input type="checkbox" name="m588r205" value="1" style="top:891px; left:719px;"/>
<input type="checkbox" name="m588r206" value="1" style="top:915px; left:719px;"/>
<input type="checkbox" name="m588r207" value="1" style="top:939px; left:719px;"/>
<input type="checkbox" name="m588r208" value="1" style="top:963px; left:719px;"/>
<input type="checkbox" name="m588r209" value="1" style="top:987px; left:719px;"/>
<input type="checkbox" name="m588r210" value="1" style="top:1011px; left:719px;"/>
<input type="checkbox" name="m588r211" value="1" style="top:1035px; left:719px;"/>
<input type="checkbox" name="m588r212" value="1" style="top:1060px; left:719px;"/>
<input type="checkbox" name="m588r213" value="1" style="top:1083px; left:719px;"/>
<input type="checkbox" name="m588r214" value="1" style="top:1107px; left:719px;"/>
<input type="checkbox" name="m588r215" value="1" style="top:1132px; left:719px;"/>
<input type="checkbox" name="m588r216" value="1" style="top:1155px; left:719px;"/>
<input type="checkbox" name="m588r217" value="1" style="top:1179px; left:719px;"/>
<input type="checkbox" name="m588r218" value="1" style="top:1204px; left:719px;"/>
<input type="checkbox" name="m588r219" value="1" style="top:1228px; left:719px;"/>
<input type="checkbox" name="m588r220" value="1" style="top:1252px; left:719px;"/>

<input type="checkbox" name="m588r301" value="1" style="top:795px; left:833px;"/>
<input type="checkbox" name="m588r302" value="1" style="top:818px; left:833px;"/>
<input type="checkbox" name="m588r303" value="1" style="top:843px; left:833px;"/>
<input type="checkbox" name="m588r304" value="1" style="top:866px; left:833px;"/>
<input type="checkbox" name="m588r305" value="1" style="top:891px; left:833px;"/>
<input type="checkbox" name="m588r306" value="1" style="top:915px; left:833px;"/>
<input type="checkbox" name="m588r307" value="1" style="top:939px; left:833px;"/>
<input type="checkbox" name="m588r308" value="1" style="top:963px; left:833px;"/>
<input type="checkbox" name="m588r309" value="1" style="top:987px; left:833px;"/>
<input type="checkbox" name="m588r310" value="1" style="top:1011px; left:833px;"/>
<input type="checkbox" name="m588r311" value="1" style="top:1035px; left:833px;"/>
<input type="checkbox" name="m588r312" value="1" style="top:1060px; left:833px;"/>
<input type="checkbox" name="m588r313" value="1" style="top:1083px; left:833px;"/>
<input type="checkbox" name="m588r314" value="1" style="top:1107px; left:833px;"/>
<input type="checkbox" name="m588r315" value="1" style="top:1132px; left:833px;"/>
<input type="checkbox" name="m588r316" value="1" style="top:1155px; left:833px;"/>
<input type="checkbox" name="m588r317" value="1" style="top:1179px; left:833px;"/>
<input type="checkbox" name="m588r318" value="1" style="top:1204px; left:833px;"/>
<input type="checkbox" name="m588r319" value="1" style="top:1228px; left:833px;"/>
<input type="checkbox" name="m588r320" value="1" style="top:1252px; left:833px;"/>
<?php                                        } ?>


<?php if ( $strana == 7 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str7.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 7.strana 265kB" class="form-background">
<span class="text-echo" style="top:74px; left:435px; font-size:16px; letter-spacing:28px;"><?php echo $fir_ficox; ?></span>

<!-- modul 588 pokra�. -->
<input type="checkbox" name="m588r221" value="1" style="top:167px; left:719px;"/>
<input type="checkbox" name="m588r222" value="1" style="top:192px; left:719px;"/>
<input type="checkbox" name="m588r223" value="1" style="top:216px; left:719px;"/>
<input type="checkbox" name="m588r224" value="1" style="top:240px; left:719px;"/>
<input type="checkbox" name="m588r225" value="1" style="top:264px; left:719px;"/>
<input type="checkbox" name="m588r226" value="1" style="top:288px; left:719px;"/>
<input type="checkbox" name="m588r227" value="1" style="top:312px; left:719px;"/>
<input type="checkbox" name="m588r228" value="1" style="top:336px; left:719px;"/>
<input type="checkbox" name="m588r229" value="1" style="top:360px; left:719px;"/>
<input type="checkbox" name="m588r230" value="1" style="top:384px; left:719px;"/>
<input type="checkbox" name="m588r231" value="1" style="top:408px; left:719px;"/>
<input type="checkbox" name="m588r232" value="1" style="top:434px; left:719px;"/>
<input type="checkbox" name="m588r233" value="1" style="top:458px; left:719px;"/>
<input type="checkbox" name="m588r234" value="1" style="top:483px; left:719px;"/>
<input type="checkbox" name="m588r235" value="1" style="top:506px; left:719px;"/>
<input type="checkbox" name="m588r236" value="1" style="top:531px; left:719px;"/>
<input type="checkbox" name="m588r237" value="1" style="top:555px; left:719px;"/>
<input type="checkbox" name="m588r238" value="1" style="top:579px; left:719px;"/>
<input type="checkbox" name="m588r239" value="1" style="top:603px; left:719px;"/>
<input type="checkbox" name="m588r240" value="1" style="top:627px; left:719px;"/>
<input type="checkbox" name="m588r241" value="1" style="top:658px; left:719px;"/>
<input type="checkbox" name="m588r242" value="1" style="top:688px; left:719px;"/>
<input type="checkbox" name="m588r243" value="1" style="top:712px; left:719px;"/>
<input type="checkbox" name="m588r244" value="1" style="top:736px; left:719px;"/>
<input type="checkbox" name="m588r245" value="1" style="top:760px; left:719px;"/>
<input type="checkbox" name="m588r246" value="1" style="top:784px; left:719px;"/>
<input type="checkbox" name="m588r247" value="1" style="top:815px; left:719px;"/>
<input type="checkbox" name="m588r248" value="1" style="top:845px; left:719px;"/>
<input type="checkbox" name="m588r249" value="1" style="top:869px; left:719px;"/>
<input type="checkbox" name="m588r250" value="1" style="top:893px; left:719px;"/>
<input type="checkbox" name="m588r251" value="1" style="top:918px; left:719px;"/>

<input type="checkbox" name="m588r321" value="1" style="top:167px; left:833px;"/>
<input type="checkbox" name="m588r322" value="1" style="top:192px; left:833px;"/>
<input type="checkbox" name="m588r323" value="1" style="top:216px; left:833px;"/>
<input type="checkbox" name="m588r324" value="1" style="top:240px; left:833px;"/>
<input type="checkbox" name="m588r325" value="1" style="top:264px; left:833px;"/>
<input type="checkbox" name="m588r326" value="1" style="top:288px; left:833px;"/>
<input type="checkbox" name="m588r327" value="1" style="top:312px; left:833px;"/>
<input type="checkbox" name="m588r328" value="1" style="top:336px; left:833px;"/>
<input type="checkbox" name="m588r329" value="1" style="top:360px; left:833px;"/>
<input type="checkbox" name="m588r330" value="1" style="top:384px; left:833px;"/>
<input type="checkbox" name="m588r331" value="1" style="top:408px; left:833px;"/>
<input type="checkbox" name="m588r332" value="1" style="top:434px; left:833px;"/>
<input type="checkbox" name="m588r333" value="1" style="top:458px; left:833px;"/>
<input type="checkbox" name="m588r334" value="1" style="top:483px; left:833px;"/>
<input type="checkbox" name="m588r335" value="1" style="top:506px; left:833px;"/>
<input type="checkbox" name="m588r336" value="1" style="top:531px; left:833px;"/>
<input type="checkbox" name="m588r337" value="1" style="top:555px; left:833px;"/>
<input type="checkbox" name="m588r338" value="1" style="top:579px; left:833px;"/>
<input type="checkbox" name="m588r339" value="1" style="top:603px; left:833px;"/>
<input type="checkbox" name="m588r340" value="1" style="top:627px; left:833px;"/>
<input type="checkbox" name="m588r341" value="1" style="top:658px; left:833px;"/>
<input type="checkbox" name="m588r342" value="1" style="top:688px; left:833px;"/>
<input type="checkbox" name="m588r343" value="1" style="top:712px; left:833px;"/>
<input type="checkbox" name="m588r344" value="1" style="top:736px; left:833px;"/>
<input type="checkbox" name="m588r345" value="1" style="top:760px; left:833px;"/>
<input type="checkbox" name="m588r346" value="1" style="top:784px; left:833px;"/>
<input type="checkbox" name="m588r347" value="1" style="top:815px; left:833px;"/>
<input type="checkbox" name="m588r348" value="1" style="top:845px; left:833px;"/>
<input type="checkbox" name="m588r349" value="1" style="top:869px; left:833px;"/>
<input type="checkbox" name="m588r350" value="1" style="top:893px; left:833px;"/>
<input type="checkbox" name="m588r351" value="1" style="top:918px; left:833px;"/>

<!-- modul 177a -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(177);" style="top:946px; left:312px;" class="btn-row-tool">
<input type="text" name="m177r01" id="m177r01" style="width:100px; top:1032px; left:680px;"/>
<input type="text" name="m177r02" id="m177r02" style="width:100px; top:1056px; left:680px;"/>
<input type="text" name="m177r03" id="m177r03" style="width:100px; top:1080px; left:680px;"/>
<input type="text" name="m177r04" id="m177r04" style="width:100px; top:1105px; left:680px;"/>
<input type="text" name="m177r05" id="m177r05" style="width:100px; top:1129px; left:680px;"/>
<input type="text" name="m177r06" id="m177r06" style="width:100px; top:1153px; left:680px;"/>
<input type="text" name="m177r07" id="m177r07" style="width:100px; top:1177px; left:680px;"/>
<input type="text" name="m177r08" id="m177r08" style="width:100px; top:1202px; left:680px;"/>
<span class="text-echo" style="top:1230px; right:165px;"><?php echo $m177r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 8 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str8.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 8.strana 245kB" class="form-background">

<!-- modul 178a -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z Obratovky"
 onclick="NacitajZobratovky(178);" style="top:78px; left:528px;" class="btn-row-tool">
<input type="text" name="m178r01" id="m178r01" style="width:100px; top:164px; left:705px;"/>
<input type="text" name="m178r02" id="m178r02" style="width:100px; top:188px; left:705px;"/>
<input type="text" name="m178r03" id="m178r03" style="width:100px; top:212px; left:705px;"/>
<input type="text" name="m178r04" id="m178r04" style="width:100px; top:236px; left:705px;"/>
<input type="text" name="m178r05" id="m178r05" style="width:100px; top:260px; left:705px;"/>
<input type="text" name="m178r06" id="m178r06" style="width:100px; top:284px; left:705px;"/>
<input type="text" name="m178r07" id="m178r07" style="width:100px; top:315px; left:705px;"/>
<input type="text" name="m178r08" id="m178r08" style="width:100px; top:345px; left:705px;"/>
<input type="text" name="m178r09" id="m178r09" style="width:100px; top:369px; left:705px;"/>
<input type="text" name="m178r10" id="m178r10" style="width:100px; top:393px; left:705px;"/>
<input type="text" name="m178r11" id="m178r11" style="width:100px; top:417px; left:705px;"/>
<input type="text" name="m178r12" id="m178r12" style="width:100px; top:441px; left:705px;"/>
<input type="text" name="m178r13" id="m178r13" style="width:100px; top:472px; left:705px;"/>
<input type="text" name="m178r14" id="m178r14" style="width:100px; top:502px; left:705px;"/>
<input type="text" name="m178r15" id="m178r15" style="width:100px; top:526px; left:705px;"/>
<input type="text" name="m178r16" id="m178r16" style="width:100px; top:550px; left:705px;"/>
<input type="text" name="m178r17" id="m178r17" style="width:100px; top:575px; left:705px;"/>
<input type="text" name="m178r18" id="m178r18" style="width:100px; top:599px; left:705px;"/>
<input type="text" name="m178r19" id="m178r19" style="width:100px; top:623px; left:705px;"/>
<input type="text" name="m178r20" id="m178r20" style="width:100px; top:647px; left:705px;"/>
<input type="text" name="m178r21" id="m178r21" style="width:100px; top:671px; left:705px;"/>
<span class="text-echo" style="top:699px; right:139px;"><?php echo $m178r99; ?></span>

<!-- modul 179b -->
<input type="text" name="m179r01" id="m179r01" style="width:100px; top:832px; left:680px;"/>
<input type="text" name="m179r02" id="m179r02" style="width:100px; top:858px; left:680px;"/>
<span class="text-echo" style="top:888px; right:162px;"><?php echo $m179r99; ?></span>

<!-- modul 182a -->
<input type="text" name="m182r001" id="m182r001" style="width:350px; top:1029px; left:50px;"/>
<input type="text" name="m182r002" id="m182r002" style="width:350px; top:1053px; left:50px;"/>
<input type="text" name="m182r003" id="m182r003" style="width:350px; top:1077px; left:50px;"/>
<input type="text" name="m182r004" id="m182r004" style="width:350px; top:1101px; left:50px;"/>
<input type="text" name="m182r005" id="m182r005" style="width:350px; top:1125px; left:50px;"/>
<input type="text" name="m182r006" id="m182r006" style="width:350px; top:1149px; left:50px;"/>
<input type="text" name="m182r007" id="m182r007" style="width:350px; top:1173px; left:50px;"/>
<input type="text" name="m182r101" id="m182r101" style="width:156px; top:1029px; left:450px;"/>
<input type="text" name="m182r102" id="m182r102" style="width:156px; top:1053px; left:450px;"/>
<input type="text" name="m182r103" id="m182r103" style="width:156px; top:1077px; left:450px;"/>
<input type="text" name="m182r104" id="m182r104" style="width:156px; top:1101px; left:450px;"/>
<input type="text" name="m182r105" id="m182r105" style="width:156px; top:1125px; left:450px;"/>
<input type="text" name="m182r106" id="m182r106" style="width:156px; top:1149px; left:450px;"/>
<input type="text" name="m182r107" id="m182r107" style="width:156px; top:1173px; left:450px;"/>
<input type="text" name="m182r201" id="m182r201" style="width:100px; top:1029px; left:705px;"/>
<input type="text" name="m182r202" id="m182r202" style="width:100px; top:1053px; left:705px;"/>
<input type="text" name="m182r203" id="m182r203" style="width:100px; top:1077px; left:705px;"/>
<input type="text" name="m182r204" id="m182r204" style="width:100px; top:1101px; left:705px;"/>
<input type="text" name="m182r205" id="m182r205" style="width:100px; top:1125px; left:705px;"/>
<input type="text" name="m182r206" id="m182r206" style="width:100px; top:1149px; left:705px;"/>
<input type="text" name="m182r207" id="m182r207" style="width:100px; top:1173px; left:705px;"/>
<span class="text-echo" style="top:1200px; right:140px;"><?php echo $m182r299; ?></span>
<?php                                        } ?>


<?php if ( $strana == 9 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str9.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 9.strana 225kB" class="form-background">

<!-- modul 183a -->
<input type="text" name="m183r001" id="m183r001" style="width:350px; top:215px; left:50px;"/>
<input type="text" name="m183r002" id="m183r002" style="width:350px; top:242px; left:50px;"/>
<input type="text" name="m183r003" id="m183r003" style="width:350px; top:268px; left:50px;"/>
<input type="text" name="m183r004" id="m183r004" style="width:350px; top:293px; left:50px;"/>
<input type="text" name="m183r005" id="m183r005" style="width:350px; top:319px; left:50px;"/>
<input type="text" name="m183r006" id="m183r006" style="width:350px; top:345px; left:50px;"/>
<input type="text" name="m183r007" id="m183r007" style="width:350px; top:371px; left:50px;"/>
<input type="text" name="m183r008" id="m183r008" style="width:350px; top:397px; left:50px;"/>
<input type="text" name="m183r009" id="m183r009" style="width:350px; top:423px; left:50px;"/>
<input type="text" name="m183r010" id="m183r010" style="width:350px; top:449px; left:50px;"/>
<input type="text" name="m183r101" id="m183r101" style="width:216px; top:215px; left:450px;"/>
<input type="text" name="m183r102" id="m183r102" style="width:216px; top:242px; left:450px;"/>
<input type="text" name="m183r103" id="m183r103" style="width:216px; top:268px; left:450px;"/>
<input type="text" name="m183r104" id="m183r104" style="width:216px; top:293px; left:450px;"/>
<input type="text" name="m183r105" id="m183r105" style="width:216px; top:319px; left:450px;"/>
<input type="text" name="m183r106" id="m183r106" style="width:216px; top:345px; left:450px;"/>
<input type="text" name="m183r107" id="m183r107" style="width:216px; top:371px; left:450px;"/>
<input type="text" name="m183r108" id="m183r108" style="width:216px; top:397px; left:450px;"/>
<input type="text" name="m183r109" id="m183r109" style="width:216px; top:423px; left:450px;"/>
<input type="text" name="m183r110" id="m183r110" style="width:216px; top:449px; left:450px;"/>
<input type="text" name="m183r201" id="m183r201" style="width:216px; top:215px; left:676px;"/>
<input type="text" name="m183r202" id="m183r202" style="width:216px; top:242px; left:676px;"/>
<input type="text" name="m183r203" id="m183r203" style="width:216px; top:268px; left:676px;"/>
<input type="text" name="m183r204" id="m183r204" style="width:216px; top:293px; left:676px;"/>
<input type="text" name="m183r205" id="m183r205" style="width:216px; top:319px; left:676px;"/>
<input type="text" name="m183r206" id="m183r206" style="width:216px; top:345px; left:676px;"/>
<input type="text" name="m183r207" id="m183r207" style="width:216px; top:371px; left:676px;"/>
<input type="text" name="m183r208" id="m183r208" style="width:216px; top:397px; left:676px;"/>
<input type="text" name="m183r209" id="m183r209" style="width:216px; top:423px; left:676px;"/>
<input type="text" name="m183r210" id="m183r210" style="width:216px; top:449px; left:676px;"/>
<span class="text-echo" style="top:479px; right:60px;"><?php echo $m183r299; ?></span>

<!-- modul 184a -->
<input type="text" name="m184r001" id="m184r001" style="width:259px; top:717px; left:50px;"/>
<input type="text" name="m184r002" id="m184r002" style="width:259px; top:744px; left:50px;"/>
<input type="text" name="m184r003" id="m184r003" style="width:259px; top:770px; left:50px;"/>
<input type="text" name="m184r004" id="m184r004" style="width:259px; top:796px; left:50px;"/>
<input type="text" name="m184r005" id="m184r005" style="width:259px; top:822px; left:50px;"/>
<input type="text" name="m184r006" id="m184r006" style="width:259px; top:849px; left:50px;"/>
<input type="text" name="m184r007" id="m184r007" style="width:259px; top:875px; left:50px;"/>
<input type="text" name="m184r008" id="m184r008" style="width:259px; top:901px; left:50px;"/>
<input type="text" name="m184r009" id="m184r009" style="width:259px; top:927px; left:50px;"/>
<input type="text" name="m184r010" id="m184r010" style="width:259px; top:954px; left:50px;"/>
<input type="text" name="m184r101" id="m184r101" style="width:121px; top:717px; left:360px;"/>
<input type="text" name="m184r102" id="m184r102" style="width:121px; top:744px; left:360px;"/>
<input type="text" name="m184r103" id="m184r103" style="width:121px; top:770px; left:360px;"/>
<input type="text" name="m184r104" id="m184r104" style="width:121px; top:796px; left:360px;"/>
<input type="text" name="m184r105" id="m184r105" style="width:121px; top:822px; left:360px;"/>
<input type="text" name="m184r106" id="m184r106" style="width:121px; top:849px; left:360px;"/>
<input type="text" name="m184r107" id="m184r107" style="width:121px; top:875px; left:360px;"/>
<input type="text" name="m184r108" id="m184r108" style="width:121px; top:901px; left:360px;"/>
<input type="text" name="m184r109" id="m184r109" style="width:121px; top:927px; left:360px;"/>
<input type="text" name="m184r110" id="m184r110" style="width:121px; top:954px; left:360px;"/>
<input type="text" name="m184r201" id="m184r201" style="width:204px; top:717px; left:492px;"/>
<input type="text" name="m184r202" id="m184r202" style="width:204px; top:744px; left:492px;"/>
<input type="text" name="m184r203" id="m184r203" style="width:204px; top:770px; left:492px;"/>
<input type="text" name="m184r204" id="m184r204" style="width:204px; top:796px; left:492px;"/>
<input type="text" name="m184r205" id="m184r205" style="width:204px; top:822px; left:492px;"/>
<input type="text" name="m184r206" id="m184r206" style="width:204px; top:849px; left:492px;"/>
<input type="text" name="m184r207" id="m184r207" style="width:204px; top:875px; left:492px;"/>
<input type="text" name="m184r208" id="m184r208" style="width:204px; top:901px; left:492px;"/>
<input type="text" name="m184r209" id="m184r209" style="width:204px; top:927px; left:492px;"/>
<input type="text" name="m184r210" id="m184r210" style="width:204px; top:954px; left:492px;"/>
<span class="text-echo" style="top:984px; right:258px;"><?php echo $m184r299; ?></span>
<input type="text" name="m184r301" id="m184r301" style="width:183px; top:717px; left:708px;"/>
<input type="text" name="m184r302" id="m184r302" style="width:183px; top:744px; left:708px;"/>
<input type="text" name="m184r303" id="m184r303" style="width:183px; top:770px; left:708px;"/>
<input type="text" name="m184r304" id="m184r304" style="width:183px; top:796px; left:708px;"/>
<input type="text" name="m184r305" id="m184r305" style="width:183px; top:822px; left:708px;"/>
<input type="text" name="m184r306" id="m184r306" style="width:183px; top:849px; left:708px;"/>
<input type="text" name="m184r307" id="m184r307" style="width:183px; top:875px; left:708px;"/>
<input type="text" name="m184r308" id="m184r308" style="width:183px; top:901px; left:708px;"/>
<input type="text" name="m184r309" id="m184r309" style="width:183px; top:927px; left:708px;"/>
<input type="text" name="m184r310" id="m184r310" style="width:183px; top:954px; left:708px;"/>
<span class="text-echo" style="top:984px; right:65px;"><?php echo $m184r399; ?></span>
<?php                                        } ?>


<?php if ( $strana == 10 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str10.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 10.strana 264kB" class="form-background">

<!-- modul 185a -->
<input type="text" name="m185r001" id="m185r001" style="width:259px; top:180px; left:50px;"/>
<input type="text" name="m185r002" id="m185r002" style="width:259px; top:204px; left:50px;"/>
<input type="text" name="m185r003" id="m185r003" style="width:259px; top:228px; left:50px;"/>
<input type="text" name="m185r004" id="m185r004" style="width:259px; top:252px; left:50px;"/>
<input type="text" name="m185r005" id="m185r005" style="width:259px; top:276px; left:50px;"/>
<input type="text" name="m185r006" id="m185r006" style="width:259px; top:300px; left:50px;"/>
<input type="text" name="m185r007" id="m185r007" style="width:259px; top:324px; left:50px;"/>
<input type="text" name="m185r101" id="m185r101" style="width:122px; top:180px; left:360px;"/>
<input type="text" name="m185r102" id="m185r102" style="width:122px; top:204px; left:360px;"/>
<input type="text" name="m185r103" id="m185r103" style="width:122px; top:228px; left:360px;"/>
<input type="text" name="m185r104" id="m185r104" style="width:122px; top:252px; left:360px;"/>
<input type="text" name="m185r105" id="m185r105" style="width:122px; top:276px; left:360px;"/>
<input type="text" name="m185r106" id="m185r106" style="width:122px; top:300px; left:360px;"/>
<input type="text" name="m185r107" id="m185r107" style="width:122px; top:324px; left:360px;"/>
<input type="text" name="m185r201" id="m185r201" style="width:204px; top:180px; left:492px;"/>
<input type="text" name="m185r202" id="m185r202" style="width:204px; top:204px; left:492px;"/>
<input type="text" name="m185r203" id="m185r203" style="width:204px; top:228px; left:492px;"/>
<input type="text" name="m185r204" id="m185r204" style="width:204px; top:252px; left:492px;"/>
<input type="text" name="m185r205" id="m185r205" style="width:204px; top:276px; left:492px;"/>
<input type="text" name="m185r206" id="m185r206" style="width:204px; top:300px; left:492px;"/>
<input type="text" name="m185r207" id="m185r207" style="width:204px; top:324px; left:492px;"/>
<span class="text-echo" style="top:353px; right:260px;"><?php echo $m185r299; ?></span>
<input type="text" name="m185r301" id="m185r301" style="width:185px; top:180px; left:707px;"/>
<input type="text" name="m185r302" id="m185r302" style="width:185px; top:204px; left:707px;"/>
<input type="text" name="m185r303" id="m185r303" style="width:185px; top:228px; left:707px;"/>
<input type="text" name="m185r304" id="m185r304" style="width:185px; top:252px; left:707px;"/>
<input type="text" name="m185r305" id="m185r305" style="width:185px; top:276px; left:707px;"/>
<input type="text" name="m185r306" id="m185r306" style="width:185px; top:300px; left:707px;"/>
<input type="text" name="m185r307" id="m185r307" style="width:185px; top:324px; left:707px;"/>
<span class="text-echo" style="top:353px; right:65px;"><?php echo $m185r399; ?></span>

<!-- modul 186a -->
<input type="text" name="m186r001" id="m186r001" style="width:259px; top:577px; left:50px;"/>
<input type="text" name="m186r002" id="m186r002" style="width:259px; top:602px; left:50px;"/>
<input type="text" name="m186r003" id="m186r003" style="width:259px; top:626px; left:50px;"/>
<input type="text" name="m186r004" id="m186r004" style="width:259px; top:650px; left:50px;"/>
<input type="text" name="m186r005" id="m186r005" style="width:259px; top:674px; left:50px;"/>
<input type="text" name="m186r006" id="m186r006" style="width:259px; top:698px; left:50px;"/>
<input type="text" name="m186r007" id="m186r007" style="width:259px; top:722px; left:50px;"/>
<input type="text" name="m186r101" id="m186r101" style="width:122px; top:577px; left:360px;"/>
<input type="text" name="m186r102" id="m186r102" style="width:122px; top:602px; left:360px;"/>
<input type="text" name="m186r103" id="m186r103" style="width:122px; top:626px; left:360px;"/>
<input type="text" name="m186r104" id="m186r104" style="width:122px; top:650px; left:360px;"/>
<input type="text" name="m186r105" id="m186r105" style="width:122px; top:674px; left:360px;"/>
<input type="text" name="m186r106" id="m186r106" style="width:122px; top:698px; left:360px;"/>
<input type="text" name="m186r107" id="m186r107" style="width:122px; top:722px; left:360px;"/>
<input type="text" name="m186r201" id="m186r201" style="width:204px; top:577px; left:492px;"/>
<input type="text" name="m186r202" id="m186r202" style="width:204px; top:602px; left:492px;"/>
<input type="text" name="m186r203" id="m186r203" style="width:204px; top:626px; left:492px;"/>
<input type="text" name="m186r204" id="m186r204" style="width:204px; top:650px; left:492px;"/>
<input type="text" name="m186r205" id="m186r205" style="width:204px; top:674px; left:492px;"/>
<input type="text" name="m186r206" id="m186r206" style="width:204px; top:698px; left:492px;"/>
<input type="text" name="m186r207" id="m186r207" style="width:204px; top:722px; left:492px;"/>
<span class="text-echo" style="top:750px; right:260px;"><?php echo $m186r299; ?></span>
<input type="text" name="m186r301" id="m186r301" style="width:185px; top:577px; left:707px;"/>
<input type="text" name="m186r302" id="m186r302" style="width:185px; top:602px; left:707px;"/>
<input type="text" name="m186r303" id="m186r303" style="width:185px; top:626px; left:707px;"/>
<input type="text" name="m186r304" id="m186r304" style="width:185px; top:650px; left:707px;"/>
<input type="text" name="m186r305" id="m186r305" style="width:185px; top:674px; left:707px;"/>
<input type="text" name="m186r306" id="m186r306" style="width:185px; top:698px; left:707px;"/>
<input type="text" name="m186r307" id="m186r307" style="width:185px; top:722px; left:707px;"/>
<span class="text-echo" style="top:750px; right:65px;"><?php echo $m186r399; ?></span>

<!-- modul 304a -->
<img src="../obr/ikony/download_blue_icon.png" title="Na��ta� �daje z miezd"
 onclick="NacitajMzdy();" style="top:915px; left:377px;" class="btn-row-tool">
<input type="text" name="m304r01" id="m304r01" style="width:140px; top:1008px; left:690px;"/>
<input type="text" name="m304r02" id="m304r02" style="width:140px; top:1034px; left:690px;"/>
<input type="text" name="m304r03" id="m304r03" style="width:140px; top:1060px; left:690px;"/>
<input type="text" name="m304r04" id="m304r04" style="width:140px; top:1086px; left:690px;"/>
<input type="text" name="m304r05" id="m304r05" style="width:140px; top:1111px; left:690px;"/>
<input type="text" name="m304r06" id="m304r06" style="width:140px; top:1137px; left:690px;"/>
<span class="text-echo" style="top:1167px; right:113px;"><?php echo $m304r99; ?></span>
<?php                                        } ?>


<?php if ( $strana == 11 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str11.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 11.strana 187kB"
 class="form-background" style="width:1250px; height:800px;">

<!-- modul 527a -->
<input type="text" name="m527r101" id="m527r101" style="width:64px; top:276px; left:299px;"/>
<input type="text" name="m527r102" id="m527r102" style="width:64px; top:305px; left:299px;"/>
<input type="text" name="m527r103" id="m527r103" style="width:64px; top:332px; left:299px;"/>
<input type="text" name="m527r104" id="m527r104" style="width:64px; top:359px; left:299px;"/>
<input type="text" name="m527r201" id="m527r201" style="width:114px; top:276px; left:374px;"/>
<input type="text" name="m527r202" id="m527r202" style="width:114px; top:305px; left:374px;"/>
<input type="text" name="m527r203" id="m527r203" style="width:114px; top:332px; left:374px;"/>
<input type="text" name="m527r204" id="m527r204" style="width:114px; top:359px; left:374px;"/>
<input type="text" name="m527r301" id="m527r301" style="width:72px; top:276px; left:500px;"/>
<input type="text" name="m527r302" id="m527r302" style="width:72px; top:305px; left:500px;"/>
<input type="text" name="m527r303" id="m527r303" style="width:72px; top:332px; left:500px;"/>
<input type="text" name="m527r304" id="m527r304" style="width:72px; top:359px; left:500px;"/>
<input type="text" name="m527r401" id="m527r401" style="width:72px; top:276px; left:584px;"/>
<input type="text" name="m527r402" id="m527r402" style="width:72px; top:305px; left:584px;"/>
<input type="text" name="m527r403" id="m527r403" style="width:72px; top:332px; left:584px;"/>
<input type="text" name="m527r404" id="m527r404" style="width:72px; top:359px; left:584px;"/>
<input type="text" name="m527r501" id="m527r501" style="width:93px; top:276px; left:669px;"/>
<input type="text" name="m527r502" id="m527r502" style="width:93px; top:305px; left:669px;"/>
<input type="text" name="m527r503" id="m527r503" style="width:93px; top:332px; left:669px;"/>
<input type="text" name="m527r504" id="m527r504" style="width:93px; top:359px; left:669px;"/>
<input type="text" name="m527r601" id="m527r601" style="width:72px; top:276px; left:774px;"/>
<input type="text" name="m527r602" id="m527r602" style="width:72px; top:305px; left:774px;"/>
<input type="text" name="m527r603" id="m527r603" style="width:72px; top:332px; left:774px;"/>
<input type="text" name="m527r604" id="m527r604" style="width:72px; top:359px; left:774px;"/>
<input type="text" name="m527r701" id="m527r701" style="width:83px; top:276px; left:858px;"/>
<input type="text" name="m527r702" id="m527r702" style="width:83px; top:305px; left:858px;"/>
<input type="text" name="m527r703" id="m527r703" style="width:83px; top:332px; left:858px;"/>
<input type="text" name="m527r704" id="m527r704" style="width:83px; top:359px; left:858px;"/>
<input type="text" name="m527r801" id="m527r801" style="width:72px; top:276px; left:953px;"/>
<input type="text" name="m527r802" id="m527r802" style="width:72px; top:305px; left:953px;"/>
<input type="text" name="m527r803" id="m527r803" style="width:72px; top:332px; left:953px;"/>
<input type="text" name="m527r804" id="m527r804" style="width:72px; top:359px; left:953px;"/>
<input type="text" name="m527r901" id="m527r901" style="width:72px; top:276px; left:1037px;"/>
<input type="text" name="m527r902" id="m527r902" style="width:72px; top:305px; left:1037px;"/>
<input type="text" name="m527r903" id="m527r903" style="width:72px; top:332px; left:1037px;"/>
<input type="text" name="m527r904" id="m527r904" style="width:72px; top:359px; left:1037px;"/>
<input type="text" name="m527r1001" id="m527r1001" style="width:73px; top:276px; left:1121px;"/>
<input type="text" name="m527r1002" id="m527r1002" style="width:73px; top:305px; left:1121px;"/>
<input type="text" name="m527r1003" id="m527r1003" style="width:73px; top:332px; left:1121px;"/>
<input type="text" name="m527r1004" id="m527r1004" style="width:73px; top:359px; left:1121px;"/>
<?php                                        } ?>


<?php if ( $strana == 12 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str12.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 12.strana 164kB" class="form-background">

<!-- modul 474a -->
<input type="text" name="m474r101" id="m474r101" style="width:100px; top:263px; left:516px;"/>
<input type="text" name="m474r102" id="m474r102" style="width:100px; top:289px; left:516px;"/>
<input type="text" name="m474r103" id="m474r103" style="width:100px; top:315px; left:516px;"/>
<input type="text" name="m474r104" id="m474r104" style="width:100px; top:341px; left:516px;"/>
<input type="text" name="m474r105" id="m474r105" style="width:100px; top:367px; left:516px;"/>
<input type="text" name="m474r106" id="m474r106" style="width:100px; top:393px; left:516px;"/>
<input type="text" name="m474r107" id="m474r107" style="width:100px; top:419px; left:516px;"/>
<span class="text-echo" style="top:448px; right:333px;"><?php echo $m474r199; ?></span>
<input type="text" name="m474r201" id="m474r201" style="width:113px; top:263px; left:628px;"/>
<input type="text" name="m474r202" id="m474r202" style="width:113px; top:289px; left:628px;"/>
<input type="text" name="m474r203" id="m474r203" style="width:113px; top:315px; left:628px;"/>
<input type="text" name="m474r204" id="m474r204" style="width:113px; top:341px; left:628px;"/>
<input type="text" name="m474r205" id="m474r205" style="width:113px; top:367px; left:628px;"/>
<input type="text" name="m474r206" id="m474r206" style="width:113px; top:393px; left:628px;"/>
<input type="text" name="m474r207" id="m474r207" style="width:113px; top:419px; left:628px;"/>
<span class="text-echo" style="top:448px; right:207px;"><?php echo $m474r299; ?></span>

<input type="text" name="m474r301" id="m474r301" style="width:138px; top:263px; left:753px;"/>
<input type="text" name="m474r302" id="m474r302" style="width:138px; top:289px; left:753px;"/>
<input type="text" name="m474r303" id="m474r303" style="width:138px; top:315px; left:753px;"/>
<input type="text" name="m474r304" id="m474r304" style="width:138px; top:341px; left:753px;"/>
<input type="text" name="m474r305" id="m474r305" style="width:138px; top:367px; left:753px;"/>
<input type="text" name="m474r306" id="m474r306" style="width:138px; top:393px; left:753px;"/>
<input type="text" name="m474r307" id="m474r307" style="width:138px; top:419px; left:753px;"/>
<span class="text-echo" style="top:448px; right:60px;"><?php echo $m474r399; ?></span>
<?php                                        } ?>


<?php if ( $strana == 13 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str13.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 13.strana 207kB" class="form-background">

<!-- modul 127 -->
<input type="text" name="m127r001" id="m127r001" style="width:250px; top:364px; left:50px;"/>
<input type="text" name="m127r002" id="m127r002" style="width:250px; top:392px; left:50px;"/>
<input type="text" name="m127r003" id="m127r003" style="width:250px; top:421px; left:50px;"/>
<input type="text" name="m127r004" id="m127r004" style="width:250px; top:449px; left:50px;"/>
<input type="text" name="m127r005" id="m127r005" style="width:250px; top:478px; left:50px;"/>
<input type="text" name="m127r006" id="m127r006" style="width:250px; top:506px; left:50px;"/>
<input type="text" name="m127r007" id="m127r007" style="width:250px; top:535px; left:50px;"/>
<input type="text" name="m127r008" id="m127r008" style="width:250px; top:563px; left:50px;"/>
<input type="text" name="m127r009" id="m127r009" style="width:250px; top:592px; left:50px;"/>
<input type="text" name="m127r010" id="m127r010" style="width:250px; top:620px; left:50px;"/>
<input type="text" name="m127r011" id="m127r011" style="width:250px; top:649px; left:50px;"/>
<input type="text" name="m127r012" id="m127r012" style="width:250px; top:677px; left:50px;"/>
<input type="text" name="m127r013" id="m127r013" style="width:250px; top:706px; left:50px;"/>
<input type="text" name="m127r014" id="m127r014" style="width:250px; top:734px; left:50px;"/>
<input type="text" name="m127r015" id="m127r015" style="width:250px; top:763px; left:50px;"/>
<input type="text" name="m127r101" id="m127r101" style="width:95px; top:364px; left:345px;"/>
<input type="text" name="m127r102" id="m127r102" style="width:95px; top:392px; left:345px;"/>
<input type="text" name="m127r103" id="m127r103" style="width:95px; top:421px; left:345px;"/>
<input type="text" name="m127r104" id="m127r104" style="width:95px; top:449px; left:345px;"/>
<input type="text" name="m127r105" id="m127r105" style="width:95px; top:478px; left:345px;"/>
<input type="text" name="m127r106" id="m127r106" style="width:95px; top:506px; left:345px;"/>
<input type="text" name="m127r107" id="m127r107" style="width:95px; top:535px; left:345px;"/>
<input type="text" name="m127r108" id="m127r108" style="width:95px; top:563px; left:345px;"/>
<input type="text" name="m127r109" id="m127r109" style="width:95px; top:592px; left:345px;"/>
<input type="text" name="m127r110" id="m127r110" style="width:95px; top:620px; left:345px;"/>
<input type="text" name="m127r111" id="m127r111" style="width:95px; top:649px; left:345px;"/>
<input type="text" name="m127r112" id="m127r112" style="width:95px; top:677px; left:345px;"/>
<input type="text" name="m127r113" id="m127r113" style="width:95px; top:706px; left:345px;"/>
<input type="text" name="m127r114" id="m127r114" style="width:95px; top:734px; left:345px;"/>
<input type="text" name="m127r115" id="m127r115" style="width:95px; top:763px; left:345px;"/>
<input type="text" name="m127r201" id="m127r201" style="width:65px; top:364px; left:450px;"/>
<input type="text" name="m127r202" id="m127r202" style="width:65px; top:392px; left:450px;"/>
<input type="text" name="m127r203" id="m127r203" style="width:65px; top:421px; left:450px;"/>
<input type="text" name="m127r204" id="m127r204" style="width:65px; top:449px; left:450px;"/>
<input type="text" name="m127r205" id="m127r205" style="width:65px; top:478px; left:450px;"/>
<input type="text" name="m127r206" id="m127r206" style="width:65px; top:506px; left:450px;"/>
<input type="text" name="m127r207" id="m127r207" style="width:65px; top:535px; left:450px;"/>
<input type="text" name="m127r208" id="m127r208" style="width:65px; top:563px; left:450px;"/>
<input type="text" name="m127r209" id="m127r209" style="width:65px; top:592px; left:450px;"/>
<input type="text" name="m127r210" id="m127r210" style="width:65px; top:620px; left:450px;"/>
<input type="text" name="m127r211" id="m127r211" style="width:65px; top:649px; left:450px;"/>
<input type="text" name="m127r212" id="m127r212" style="width:65px; top:677px; left:450px;"/>
<input type="text" name="m127r213" id="m127r213" style="width:65px; top:706px; left:450px;"/>
<input type="text" name="m127r214" id="m127r214" style="width:65px; top:734px; left:450px;"/>
<input type="text" name="m127r215" id="m127r215" style="width:65px; top:763px; left:450px;"/>
<span class="text-echo" style="top:795px; right:430px;"><?php echo $m127r299; ?></span>
<input type="text" name="m127r301" id="m127r301" style="width:79px; top:364px; left:526px;"/>
<input type="text" name="m127r302" id="m127r302" style="width:79px; top:392px; left:526px;"/>
<input type="text" name="m127r303" id="m127r303" style="width:79px; top:421px; left:526px;"/>
<input type="text" name="m127r304" id="m127r304" style="width:79px; top:449px; left:526px;"/>
<input type="text" name="m127r305" id="m127r305" style="width:79px; top:478px; left:526px;"/>
<input type="text" name="m127r306" id="m127r306" style="width:79px; top:506px; left:526px;"/>
<input type="text" name="m127r307" id="m127r307" style="width:79px; top:535px; left:526px;"/>
<input type="text" name="m127r308" id="m127r308" style="width:79px; top:563px; left:526px;"/>
<input type="text" name="m127r309" id="m127r309" style="width:79px; top:592px; left:526px;"/>
<input type="text" name="m127r310" id="m127r310" style="width:79px; top:620px; left:526px;"/>
<input type="text" name="m127r311" id="m127r311" style="width:79px; top:649px; left:526px;"/>
<input type="text" name="m127r312" id="m127r312" style="width:79px; top:677px; left:526px;"/>
<input type="text" name="m127r313" id="m127r313" style="width:79px; top:706px; left:526px;"/>
<input type="text" name="m127r314" id="m127r314" style="width:79px; top:734px; left:526px;"/>
<input type="text" name="m127r315" id="m127r315" style="width:79px; top:763px; left:526px;"/>
<span class="text-echo" style="top:795px; right:340px;"><?php echo $m127r399; ?></span>
<input type="text" name="m127r401" id="m127r401" style="width:79px; top:364px; left:617px;"/>
<input type="text" name="m127r402" id="m127r402" style="width:79px; top:392px; left:617px;"/>
<input type="text" name="m127r403" id="m127r403" style="width:79px; top:421px; left:617px;"/>
<input type="text" name="m127r404" id="m127r404" style="width:79px; top:449px; left:617px;"/>
<input type="text" name="m127r405" id="m127r405" style="width:79px; top:478px; left:617px;"/>
<input type="text" name="m127r406" id="m127r406" style="width:79px; top:506px; left:617px;"/>
<input type="text" name="m127r407" id="m127r407" style="width:79px; top:535px; left:617px;"/>
<input type="text" name="m127r408" id="m127r408" style="width:79px; top:563px; left:617px;"/>
<input type="text" name="m127r409" id="m127r409" style="width:79px; top:592px; left:617px;"/>
<input type="text" name="m127r410" id="m127r410" style="width:79px; top:620px; left:617px;"/>
<input type="text" name="m127r411" id="m127r411" style="width:79px; top:649px; left:617px;"/>
<input type="text" name="m127r412" id="m127r412" style="width:79px; top:677px; left:617px;"/>
<input type="text" name="m127r413" id="m127r413" style="width:79px; top:706px; left:617px;"/>
<input type="text" name="m127r414" id="m127r414" style="width:79px; top:734px; left:617px;"/>
<input type="text" name="m127r415" id="m127r415" style="width:79px; top:763px; left:617px;"/>
<span class="text-echo" style="top:795px; right:250px;"><?php echo $m127r499; ?></span>
<input type="text" name="m127r501" id="m127r501" style="width:100px; top:364px; left:708px;"/>
<input type="text" name="m127r502" id="m127r502" style="width:100px; top:392px; left:708px;"/>
<input type="text" name="m127r503" id="m127r503" style="width:100px; top:421px; left:708px;"/>
<input type="text" name="m127r504" id="m127r504" style="width:100px; top:449px; left:708px;"/>
<input type="text" name="m127r505" id="m127r505" style="width:100px; top:478px; left:708px;"/>
<input type="text" name="m127r506" id="m127r506" style="width:100px; top:506px; left:708px;"/>
<input type="text" name="m127r507" id="m127r507" style="width:100px; top:535px; left:708px;"/>
<input type="text" name="m127r508" id="m127r508" style="width:100px; top:563px; left:708px;"/>
<input type="text" name="m127r509" id="m127r509" style="width:100px; top:592px; left:708px;"/>
<input type="text" name="m127r510" id="m127r510" style="width:100px; top:620px; left:708px;"/>
<input type="text" name="m127r511" id="m127r511" style="width:100px; top:649px; left:708px;"/>
<input type="text" name="m127r512" id="m127r512" style="width:100px; top:677px; left:708px;"/>
<input type="text" name="m127r513" id="m127r513" style="width:100px; top:706px; left:708px;"/>
<input type="text" name="m127r514" id="m127r514" style="width:100px; top:734px; left:708px;"/>
<input type="text" name="m127r515" id="m127r515" style="width:100px; top:763px; left:708px;"/>
<span class="text-echo" style="top:795px; right:140px;"><?php echo $m127r599; ?></span>
<input type="text" name="m127r601" id="m127r601" style="width:70px; top:364px; left:821px;"/>
<input type="text" name="m127r602" id="m127r602" style="width:70px; top:392px; left:821px;"/>
<input type="text" name="m127r603" id="m127r603" style="width:70px; top:421px; left:821px;"/>
<input type="text" name="m127r604" id="m127r604" style="width:70px; top:449px; left:821px;"/>
<input type="text" name="m127r605" id="m127r605" style="width:70px; top:478px; left:821px;"/>
<input type="text" name="m127r606" id="m127r606" style="width:70px; top:506px; left:821px;"/>
<input type="text" name="m127r607" id="m127r607" style="width:70px; top:535px; left:821px;"/>
<input type="text" name="m127r608" id="m127r608" style="width:70px; top:563px; left:821px;"/>
<input type="text" name="m127r609" id="m127r609" style="width:70px; top:592px; left:821px;"/>
<input type="text" name="m127r610" id="m127r610" style="width:70px; top:620px; left:821px;"/>
<input type="text" name="m127r611" id="m127r611" style="width:70px; top:649px; left:821px;"/>
<input type="text" name="m127r612" id="m127r612" style="width:70px; top:677px; left:821px;"/>
<input type="text" name="m127r613" id="m127r613" style="width:70px; top:706px; left:821px;"/>
<input type="text" name="m127r614" id="m127r614" style="width:70px; top:734px; left:821px;"/>
<input type="text" name="m127r615" id="m127r615" style="width:70px; top:763px; left:821px;"/>
<span class="text-echo" style="top:795px; right:57px;"><?php echo $m127r699; ?></span>
<?php                                         } ?>


<?php if ( $strana == 14 OR $strana == 9999 ) { ?>
<img src="../dokumenty/statistika2014/opu201/opu201v14_str14.jpg"
 alt="tla�ivo �tvr�ro�n� v�kaz produk�n�ch odvetv� v mal�ch podnikoch Ro� OPU 2-01 14.strana 203kB" class="form-background">

<!-- modul 128 -->
<input type="text" name="m128r101" id="m128r101" style="width:90px; top:291px; left:425px;"/>
<input type="text" name="m128r102" id="m128r102" style="width:90px; top:319px; left:425px;"/>
<input type="text" name="m128r103" id="m128r103" style="width:90px; top:352px; left:425px;"/>
<input type="text" name="m128r104" id="m128r104" style="width:90px; top:385px; left:425px;"/>
<input type="text" name="m128r105" id="m128r105" style="width:90px; top:418px; left:425px;"/>
<input type="text" name="m128r106" id="m128r106" style="width:90px; top:450px; left:425px;"/>
<input type="text" name="m128r107" id="m128r107" style="width:90px; top:482px; left:425px;"/>
<input type="text" name="m128r108" id="m128r108" style="width:90px; top:515px; left:425px;"/>
<input type="text" name="m128r109" id="m128r109" style="width:90px; top:543px; left:425px;"/>
<input type="text" name="m128r110" id="m128r110" style="width:90px; top:572px; left:425px;"/>
<input type="text" name="m128r111" id="m128r111" style="width:90px; top:600px; left:425px;"/>
<span class="text-echo" style="top:633px; right:430px;"><?php echo $m128r199; ?></span>
<input type="text" name="m128r201" id="m128r201" style="width:80px; top:291px; left:526px;"/>
<input type="text" name="m128r202" id="m128r202" style="width:80px; top:319px; left:526px;"/>
<input type="text" name="m128r203" id="m128r203" style="width:80px; top:352px; left:526px;"/>
<input type="text" name="m128r204" id="m128r204" style="width:80px; top:385px; left:526px;"/>
<input type="text" name="m128r205" id="m128r205" style="width:80px; top:418px; left:526px;"/>
<input type="text" name="m128r206" id="m128r206" style="width:80px; top:450px; left:526px;"/>
<input type="text" name="m128r207" id="m128r207" style="width:80px; top:482px; left:526px;"/>
<input type="text" name="m128r208" id="m128r208" style="width:80px; top:515px; left:526px;"/>
<input type="text" name="m128r209" id="m128r209" style="width:80px; top:543px; left:526px;"/>
<input type="text" name="m128r210" id="m128r210" style="width:80px; top:572px; left:526px;"/>
<input type="text" name="m128r211" id="m128r211" style="width:80px; top:600px; left:526px;"/>
<span class="text-echo" style="top:633px; right:341px;"><?php echo $m128r299; ?></span>
<input type="text" name="m128r301" id="m128r301" style="width:79px; top:291px; left:617px;"/>
<input type="text" name="m128r302" id="m128r302" style="width:79px; top:319px; left:617px;"/>
<input type="text" name="m128r303" id="m128r303" style="width:79px; top:352px; left:617px;"/>
<input type="text" name="m128r304" id="m128r304" style="width:79px; top:385px; left:617px;"/>
<input type="text" name="m128r305" id="m128r305" style="width:79px; top:418px; left:617px;"/>
<input type="text" name="m128r306" id="m128r306" style="width:79px; top:450px; left:617px;"/>
<input type="text" name="m128r307" id="m128r307" style="width:79px; top:482px; left:617px;"/>
<input type="text" name="m128r308" id="m128r308" style="width:79px; top:515px; left:617px;"/>
<input type="text" name="m128r309" id="m128r309" style="width:79px; top:543px; left:617px;"/>
<input type="text" name="m128r310" id="m128r310" style="width:79px; top:572px; left:617px;"/>
<input type="text" name="m128r311" id="m128r311" style="width:79px; top:600px; left:617px;"/>
<span class="text-echo" style="top:633px; right:250px;"><?php echo $m128r399; ?></span>
<input type="text" name="m128r401" id="m128r401" style="width:100px; top:291px; left:708px;"/>
<input type="text" name="m128r402" id="m128r402" style="width:100px; top:319px; left:708px;"/>
<input type="text" name="m128r403" id="m128r403" style="width:100px; top:352px; left:708px;"/>
<input type="text" name="m128r404" id="m128r404" style="width:100px; top:385px; left:708px;"/>
<input type="text" name="m128r405" id="m128r405" style="width:100px; top:418px; left:708px;"/>
<input type="text" name="m128r406" id="m128r406" style="width:100px; top:450px; left:708px;"/>
<input type="text" name="m128r407" id="m128r407" style="width:100px; top:482px; left:708px;"/>
<input type="text" name="m128r408" id="m128r408" style="width:100px; top:515px; left:708px;"/>
<input type="text" name="m128r409" id="m128r409" style="width:100px; top:543px; left:708px;"/>
<input type="text" name="m128r410" id="m128r410" style="width:100px; top:572px; left:708px;"/>
<input type="text" name="m128r411" id="m128r411" style="width:100px; top:600px; left:708px;"/>
<span class="text-echo" style="top:633px; right:138px;"><?php echo $m128r499; ?></span>

<input type="text" name="m128r501" id="m128r501" style="width:71px; top:291px; left:821px;"/>
<input type="text" name="m128r502" id="m128r502" style="width:71px; top:319px; left:821px;"/>
<input type="text" name="m128r503" id="m128r503" style="width:71px; top:352px; left:821px;"/>
<input type="text" name="m128r504" id="m128r504" style="width:71px; top:385px; left:821px;"/>
<input type="text" name="m128r505" id="m128r505" style="width:71px; top:418px; left:821px;"/>
<input type="text" name="m128r506" id="m128r506" style="width:71px; top:450px; left:821px;"/>
<input type="text" name="m128r507" id="m128r507" style="width:71px; top:482px; left:821px;"/>
<input type="text" name="m128r508" id="m128r508" style="width:71px; top:515px; left:821px;"/>
<input type="text" name="m128r509" id="m128r509" style="width:71px; top:543px; left:821px;"/>
<input type="text" name="m128r510" id="m128r510" style="width:71px; top:572px; left:821px;"/>
<input type="text" name="m128r511" id="m128r511" style="width:71px; top:600px; left:821px;"/>
<span class="text-echo" style="top:633px; right:58px;"><?php echo $m128r599; ?></span>
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
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=102&strana=14', '_self');" class="<?php echo $clas14; ?> toleft">14</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Ulo�i� zmeny" class="btn-bottom-formsave">
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
//if ( $strana == 11 OR $strana == 9998 ) { $sirka_vyska="320,220"; }
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_statistika_opu201 WHERE ico >= 0 "."";
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
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str1.jpg',0,0,210,297);
}

//OBDOBIA
$pdf->SetFont('arial','',15);
$pdf->Cell(190,37," ","$rmc1",1,"L");
$pdf->Cell(85,8," ","$rmc1",0,"L");$pdf->Cell(34,6,"$kli_vrok","$rmc",1,"C");
$pdf->SetFont('arial','',11);
$pdf->Cell(190,10," ","$rmc1",1,"L");
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
$pdf->Cell(8,7,"$A","$rmc",0,"C");$pdf->Cell(8,7,"$B","$rmc",0,"C");$pdf->Cell(8,7,"$C","$rmc",0,"C");$pdf->Cell(8,7,"$D","$rmc",0,"C");
$pdf->Cell(8,7,"$E","$rmc",0,"C");$pdf->Cell(8,7,"$F","$rmc",0,"C");$pdf->Cell(8,7,"$G","$rmc",0,"C");$pdf->Cell(7,7,"$H","$rmc",1,"C");

//ORGANIZACIA
$pdf->Cell(190,82," ","$rmc1",1,"L");
$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(153,5,"$fir_fnaz","$rmc",0,"L");$pdf->Cell(1,4," ","$rmc1",0,"L");$pdf->Cell(34,5,"$okres","$rmc",1,"C");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(153,6,"$fir_fuli $fir_fcdm, $fir_fmes, $fir_fpsc","$rmc",1,"L");

//VYPLNIL
$pdf->Cell(195,9," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(60,5,"$fir_mzdt05","$rmc",0,"L");$pdf->Cell(14,5," ","$rmc1",0,"L");$pdf->Cell(43,5,"$fir_mzdt04","$rmc",1,"L");
$pdf->Cell(195,6," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"L");$pdf->Cell(72,7,"$fir_fem1","$rmc",0,"L");$pdf->Cell(2,5," ","$rmc1",0,"L");
//odoslane
$pdf->Cell(43,6,"$odoslane_sk","$rmc",1,"C");

//modul 100041
$mod100041ano=" ";
$mod100041nie=" ";
if ( $hlavicka->mod100041ano == 1 ) { $mod100041ano="x"; }
if ( $hlavicka->mod100041nie == 1 ) { $mod100041nie="x"; }
$pdf->Cell(190,24," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100041ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100041nie","$rmc",1,"C");

//modul 100042
$mod100042ano=" ";
$mod100042nie=" ";
if ( $hlavicka->mod100042ano == 1 ) { $mod100042ano="x"; }
if ( $hlavicka->mod100042nie == 1 ) { $mod100042nie="x"; }
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100042ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100042nie","$rmc",1,"C");

//modul 100043
$mod100043ano=" ";
$mod100043nie=" ";
if ( $hlavicka->mod100043ano == 1 ) { $mod100043ano="x"; }
if ( $hlavicka->mod100043nie == 1 ) { $mod100043nie="x"; }
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100043ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100043nie","$rmc",1,"C");
                                       }

if ( $strana == 2 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str2.jpg',0,0,210,297);
}

//modul 100038
$mod100038=$hlavicka->mod100038;
if ( $hlavicka->mod100038 == 0 ) $mod100038="";
$pdf->Cell(190,15," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,4,"$mod100038","$rmc",1,"C");

//modul 100039
$mod100039=$hlavicka->mod100039;
if ( $hlavicka->mod100039 == 0 ) $mod100039="";
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,5,"$mod100039","$rmc",1,"C");

//modul 100040
$mod100040=$hlavicka->mod100040;
if ( $hlavicka->mod100040 == 0 ) $mod100040="";
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,4,"$mod100040","$rmc",1,"C");

//modul 100036
$mod100036kal=" ";
$mod100036hos=" ";
if ( $hlavicka->mod100036kal == 1 ) { $mod100036kal="x"; }
if ( $hlavicka->mod100036hos == 1 ) { $mod100036hos="x"; }
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100036kal","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100036hos","$rmc",1,"C");

//modul 100037
$mod100037=$hlavicka->mod100037;
if ( $hlavicka->mod100037 == 0 ) $mod100037="";
$pdf->Cell(190,14," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,5,"$mod100037","$rmc",1,"C");

//modul 100069
$mod100069ano=" ";
$mod100069nie=" ";
if ( $hlavicka->mod100069ano == 1 ) { $mod100069ano="x"; }
if ( $hlavicka->mod100069nie == 1 ) { $mod100069nie="x"; }
$pdf->Cell(190,23," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100069ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100069nie","$rmc",1,"C");

//modul 100086
$mod100086ano=" ";
$mod100086nie=" ";
if ( $hlavicka->mod100086ano == 1 ) { $mod100086ano="x"; }
if ( $hlavicka->mod100086nie == 1 ) { $mod100086nie="x"; }
$pdf->Cell(190,10," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100086ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100086nie","$rmc",1,"C");

//modul 100087
$mod100087ano=" ";
$mod100087nie=" ";
if ( $hlavicka->mod100087ano == 1 ) { $mod100087ano="x"; }
if ( $hlavicka->mod100087nie == 1 ) { $mod100087nie="x"; }
$pdf->Cell(190,17," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$mod100087ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100087nie","$rmc",1,"C");

//modul 100088
$mod100088ano=" ";
$mod100088nie=" ";
if ( $hlavicka->mod100088ano == 1 ) { $mod100088ano="x"; }
if ( $hlavicka->mod100088nie == 1 ) { $mod100088nie="x"; }
$pdf->Cell(190,23," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100088ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$mod100088nie","$rmc",1,"C");

//modul 100089
$mod100089=$hlavicka->mod100089;
if ( $hlavicka->mod100089 == 0 ) $mod100089="";
$pdf->Cell(190,20," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,6,"$mod100089","$rmc",1,"C");

//modul 100090
$mod100090=$hlavicka->mod100090;
if ( $hlavicka->mod100090 == 0 ) $mod100090="";
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,5,"$mod100090","$rmc",1,"C");

//modul 100091
$mod100091=$hlavicka->mod100091;
if ( $hlavicka->mod100091 == 0 ) $mod100091="";
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(132,6," ","$rmc1",0,"L");$pdf->Cell(57,5,"$mod100091","$rmc",1,"C");
                                       }

if ( $strana == 3 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str3.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str3.jpg',0,0,210,297);
}

//ico
$pdf->Cell(190,5," ","$rmc1",1,"L");
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

//modul 2
$mod2r01=$hlavicka->mod2r01; if ( $mod2r01 == 0 ) $mod2r01="";
$mod2r02=$hlavicka->mod2r02; if ( $mod2r02 == 0 ) $mod2r02="";
$pdf->Cell(195,38," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r01","$rmc",1,"C");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$mod2r02","$rmc",1,"C");

//modul 398a
$m398r01=$hlavicka->m398r01; if ( $m398r01 == 0 ) $m398r01="";
$m398r02=$hlavicka->m398r02; if ( $m398r02 == 0 ) $m398r02="";
$m398r99=$hlavicka->m398r99;
//if ( $m398r99 == 0 ) $m398r99="";
$pdf->Cell(195,36," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m398r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m398r02","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m398r99","$rmc",1,"R");

//modul 405a
$m405r01=$hlavicka->m405r01; if ( $m405r01 == 0 ) $m405r01="";
$m405r02=$hlavicka->m405r02; if ( $m405r02 == 0 ) $m405r02="";
$m405r03=$hlavicka->m405r03; if ( $m405r03 == 0 ) $m405r03="";
$m405r04=$hlavicka->m405r04; if ( $m405r04 == 0 ) $m405r04="";
$m405r05=$hlavicka->m405r05; if ( $m405r05 == 0 ) $m405r05="";
$m405r06=$hlavicka->m405r06; if ( $m405r06 == 0 ) $m405r06="";
$m405r99=$hlavicka->m405r99;
//if ( $m405r99 == 0 ) $m405r99="";
$pdf->Cell(195,29," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m405r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m405r02","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m405r03","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m405r04","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,8,"$m405r05","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,8,"$m405r06","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,7,"$m405r99","$rmc",1,"R");

//modul 558c
$m558r01=$hlavicka->m558r01;
if ( $m558r01 == 0 ) $m558r01="";
$m558r02=$hlavicka->m558r02;
if ( $m558r02 == 0 ) $m558r02="";
$m558r03=$hlavicka->m558r03;
if ( $m558r03 == 0 ) $m558r03="";
$m558r04=$hlavicka->m558r04;
if ( $m558r04 == 0 ) $m558r04="";
$m558r05=$hlavicka->m558r05;
if ( $m558r05 == 0 ) $m558r05="";
$m558r06=$hlavicka->m558r06;
if ( $m558r06 == 0 ) $m558r06="";
$m558r99=$hlavicka->m558r99;
//if ( $m558r99 == 0 ) $m558r99="";
$pdf->Cell(195,28," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m558r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m558r02","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m558r03","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m558r04","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m558r05","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m558r06","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,7,"$m558r99","$rmc",1,"R");
                                       }

if ( $strana == 4 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str4.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str4.jpg',0,0,210,297);
}

//modul 580a
$pdf->Cell(195,24," ","$rmc1",1,"L");
$m580r11=$hlavicka->m580r11;
if ( $m580r11 == 0 ) $m580r11="";
$m580r12=$hlavicka->m580r12;
if ( $m580r12 == 0 ) $m580r12="";
$m580r199=$hlavicka->m580r199;
//if ( $m580r199 == 0 ) $m580r199="";
$m580r21=$hlavicka->m580r21;
if ( $m580r21 == 0 ) $m580r21="";
$m580r22=$hlavicka->m580r22;
if ( $m580r22 == 0 ) $m580r22="";
$m580r299=$hlavicka->m580r299;
//if ( $m580r299 == 0 ) $m580r299="";
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m580r11","$rmc",0,"R");$pdf->Cell(37,6,"$m580r21","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m580r12","$rmc",0,"R");$pdf->Cell(37,6,"$m580r22","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m580r199","$rmc",0,"R");$pdf->Cell(37,6,"$m580r299","$rmc",1,"R");

//modul 586b
$pdf->Cell(195,24," ","$rmc1",1,"L");
$m586r11=$hlavicka->m586r11; if ( $m586r11 == 0 ) $m586r11="";
$m586r12=$hlavicka->m586r12; if ( $m586r12 == 0 ) $m586r12="";
$m586r13=$hlavicka->m586r13; if ( $m586r13 == 0 ) $m586r13="";
$m586r14=$hlavicka->m586r14; if ( $m586r14 == 0 ) $m586r14="";
$m586r199=$hlavicka->m586r199;
//if ( $m586r199 == 0 ) $m586r199="";
$m586r21=$hlavicka->m586r21; if ( $m586r21 == 0 ) $m586r21="";
$m586r22=$hlavicka->m586r22; if ( $m586r22 == 0 ) $m586r22="";
$m586r23=$hlavicka->m586r23; if ( $m586r23 == 0 ) $m586r23="";
$m586r24=$hlavicka->m586r24; if ( $m586r24 == 0 ) $m586r24="";
$m586r299=$hlavicka->m586r299;
//if ( $m586r299 == 0 ) $m586r299="";
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m586r11","$rmc",0,"R");$pdf->Cell(37,6,"$m586r21","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m586r12","$rmc",0,"R");$pdf->Cell(37,6,"$m586r22","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m586r13","$rmc",0,"R");$pdf->Cell(37,6,"$m586r23","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m586r14","$rmc",0,"R");$pdf->Cell(37,6,"$m586r24","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m586r199","$rmc",0,"R");$pdf->Cell(37,6,"$m586r299","$rmc",1,"R");

//modul 100062
$m100062ano=" ";
$m100062nie=" ";
if ( $hlavicka->m100062ano == 1 ) { $m100062ano="x"; }
if ( $hlavicka->m100062nie == 1 ) { $m100062nie="x"; }
$pdf->Cell(190,9," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m100062ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m100062nie","$rmc",1,"C");

//modul 585
$pdf->Cell(195,70," ","$rmc1",1,"L");
$m585r01=$hlavicka->m585r01; if ( $m585r01 == 0 ) $m585r01="";
$m585r02=$hlavicka->m585r02; if ( $m585r02 == 0 ) $m585r02="";
$m585r03=$hlavicka->m585r03; if ( $m585r03 == 0 ) $m585r03="";
$m585r04=$hlavicka->m585r04; if ( $m585r04 == 0 ) $m585r04="";
$m585r05=$hlavicka->m585r05; if ( $m585r05 == 0 ) $m585r05="";
$m585r3k=$hlavicka->m585r3k;
$m585r4k=$hlavicka->m585r4k;
$m585r5k=$hlavicka->m585r5k;
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m585r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,8,"$m585r02","$rmc",1,"R");
$pdf->Cell(77,6,"","$rmc1",0,"L");$pdf->Cell(28,6,"$m585r3k","$rmc",0,"L");
$pdf->Cell(9,6,"","$rmc1",0,"L");$pdf->Cell(75,6,"$m585r03","$rmc",1,"R");
$pdf->Cell(77,6,"","$rmc1",0,"L");$pdf->Cell(28,6,"$m585r4k","$rmc",0,"L");
$pdf->Cell(9,6,"","$rmc1",0,"L");$pdf->Cell(75,6,"$m585r04","$rmc",1,"R");
$pdf->Cell(77,6,"","$rmc1",0,"L");$pdf->Cell(28,6,"$m585r5k","$rmc",0,"L");
$pdf->Cell(9,6,"","$rmc1",0,"L");$pdf->Cell(75,6,"$m585r05","$rmc",1,"R");

//modul 100062
$m100044ano=" ";
$m100044nie=" ";
if ( $hlavicka->m100044ano == 1 ) { $m100044ano="x"; }
if ( $hlavicka->m100044nie == 1 ) { $m100044nie="x"; }
$pdf->Cell(190,32," ","$rmc1",1,"L");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,4,"$m100044ano","$rmc",1,"C");
$pdf->Cell(173,6," ","$rmc1",0,"L");$pdf->Cell(9,5,"$m100044nie","$rmc",1,"C");
                                       }

if ( $strana == 5 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str5.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str5.jpg',0,0,210,297);
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
$pdf->Cell(83,5," ","$rmc1",0,"L");
$pdf->Cell(8,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(8,6,"$D","$rmc",0,"C");
$pdf->Cell(9,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");$pdf->Cell(8,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",1,"C");

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
$pdf->Cell(195,53," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,5,"$m571r10","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,5,"$cslr1","$rmc",0,"C");$pdf->Cell(24,5,"$m571r12","$rmc",0,"L");
$pdf->Cell(15,5,"$m571r13","$rmc",0,"C");$pdf->Cell(15,5,"","$rmc",0,"L");
$pdf->Cell(20,5,"$m571r15","$rmc",0,"C");$pdf->Cell(23,5,"$m571r16","$rmc",0,"R");
$pdf->Cell(25,5,"$m571r17","$rmc",0,"R");$pdf->Cell(18,5,"$m571r18","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r20","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr2","$rmc",0,"C");$pdf->Cell(24,6,"$m571r22","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r23","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r25","$rmc",0,"C");$pdf->Cell(23,6,"$m571r26","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r27","$rmc",0,"R");$pdf->Cell(18,6,"$m571r28","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r30","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr3","$rmc",0,"C");$pdf->Cell(24,6,"$m571r32","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r33","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r35","$rmc",0,"C");$pdf->Cell(23,6,"$m571r36","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r37","$rmc",0,"R");$pdf->Cell(18,6,"$m571r38","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r40","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr4","$rmc",0,"C");$pdf->Cell(24,6,"$m571r42","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r43","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r45","$rmc",0,"C");$pdf->Cell(23,6,"$m571r46","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r47","$rmc",0,"R");$pdf->Cell(18,6,"$m571r48","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r50","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr5","$rmc",0,"C");$pdf->Cell(24,6,"$m571r52","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r53","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r55","$rmc",0,"C");$pdf->Cell(23,6,"$m571r56","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r57","$rmc",0,"R");$pdf->Cell(18,6,"$m571r58","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r60","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr6","$rmc",0,"C");$pdf->Cell(24,6,"$m571r62","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r63","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r65","$rmc",0,"C");$pdf->Cell(23,6,"$m571r66","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r67","$rmc",0,"R");$pdf->Cell(18,6,"$m571r68","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r70","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr7","$rmc",0,"C");$pdf->Cell(24,6,"$m571r72","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r73","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r75","$rmc",0,"C");$pdf->Cell(23,6,"$m571r76","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r77","$rmc",0,"R");$pdf->Cell(18,6,"$m571r78","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r80","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr8","$rmc",0,"C");$pdf->Cell(24,6,"$m571r82","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r83","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r85","$rmc",0,"C");$pdf->Cell(23,6,"$m571r86","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r87","$rmc",0,"R");$pdf->Cell(18,6,"$m571r88","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");
$pdf->Cell(27,6,"$m571r90","$rmc",0,"L");$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(16,6,"$cslr9","$rmc",0,"C");$pdf->Cell(24,6,"$m571r92","$rmc",0,"L");
$pdf->Cell(15,6,"$m571r93","$rmc",0,"C");$pdf->Cell(15,6,"","$rmc",0,"L");
$pdf->Cell(20,6,"$m571r95","$rmc",0,"C");$pdf->Cell(23,6,"$m571r96","$rmc",0,"R");
$pdf->Cell(25,6,"$m571r97","$rmc",0,"R");$pdf->Cell(18,6,"$m571r98","$rmc",1,"R");

//modul 516b
$m516r101=$hlavicka->m516r101; if ( $m516r101 == 0 ) $m516r101="";
$m516r102=$hlavicka->m516r102; if ( $m516r102 == 0 ) $m516r102="";
$m516r103=$hlavicka->m516r103; if ( $m516r103 == 0 ) $m516r103="";
$m516r104=$hlavicka->m516r104; if ( $m516r104 == 0 ) $m516r104="";
$m516r105=$hlavicka->m516r105; if ( $m516r105 == 0 ) $m516r105="";
$m516r106=$hlavicka->m516r106; if ( $m516r106 == 0 ) $m516r106="";
$m516r107=$hlavicka->m516r107; if ( $m516r107 == 0 ) $m516r107="";
$m516r108=$hlavicka->m516r108; if ( $m516r108 == 0 ) $m516r108="";
$m516r109=$hlavicka->m516r109; if ( $m516r109 == 0 ) $m516r109="";
$m516r110=$hlavicka->m516r110; if ( $m516r110 == 0 ) $m516r110="";
$m516r111=$hlavicka->m516r111; if ( $m516r111 == 0 ) $m516r111="";
$m516r112=$hlavicka->m516r112; if ( $m516r112 == 0 ) $m516r112="";
$m516r113=$hlavicka->m516r113; if ( $m516r113 == 0 ) $m516r113="";
$m516r114=$hlavicka->m516r114; if ( $m516r114 == 0 ) $m516r114="";
$m516r199=$hlavicka->m516r199;
//if ( $m516r199 == 0 ) $m516r199="";
$m516r201=$hlavicka->m516r201; if ( $m516r201 == 0 ) $m516r201="";
$m516r202=$hlavicka->m516r202; if ( $m516r202 == 0 ) $m516r202="";
$m516r203=$hlavicka->m516r203; if ( $m516r203 == 0 ) $m516r203="";
$m516r204=$hlavicka->m516r204; if ( $m516r204 == 0 ) $m516r204="";
$m516r205=$hlavicka->m516r205; if ( $m516r205 == 0 ) $m516r205="";
$m516r206=$hlavicka->m516r206; if ( $m516r206 == 0 ) $m516r206="";
$m516r207=$hlavicka->m516r207; if ( $m516r207 == 0 ) $m516r207="";
$m516r208=$hlavicka->m516r208; if ( $m516r208 == 0 ) $m516r208="";
$m516r209=$hlavicka->m516r209; if ( $m516r209 == 0 ) $m516r209="";
$m516r210=$hlavicka->m516r210; if ( $m516r210 == 0 ) $m516r210="";
$m516r211=$hlavicka->m516r211; if ( $m516r211 == 0 ) $m516r211="";
$m516r212=$hlavicka->m516r212; if ( $m516r212 == 0 ) $m516r212="";
$m516r213=$hlavicka->m516r213; if ( $m516r213 == 0 ) $m516r213="";
$m516r214=$hlavicka->m516r214; if ( $m516r214 == 0 ) $m516r214="";
$m516r299=$hlavicka->m516r299;
//if ( $m516r299 == 0 ) $m516r299="";
$pdf->Cell(195,47," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r101","$rmc",0,"R");$pdf->Cell(37,6,"$m516r201","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r102","$rmc",0,"R");$pdf->Cell(37,6,"$m516r202","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r103","$rmc",0,"R");$pdf->Cell(37,6,"$m516r203","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r104","$rmc",0,"R");$pdf->Cell(37,6,"$m516r204","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r105","$rmc",0,"R");$pdf->Cell(37,6,"$m516r205","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r106","$rmc",0,"R");$pdf->Cell(37,6,"$m516r206","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r107","$rmc",0,"R");$pdf->Cell(37,6,"$m516r207","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r108","$rmc",0,"R");$pdf->Cell(37,6,"$m516r208","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r109","$rmc",0,"R");$pdf->Cell(37,6,"$m516r209","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r110","$rmc",0,"R");$pdf->Cell(37,6,"$m516r210","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r111","$rmc",0,"R");$pdf->Cell(37,6,"$m516r211","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r112","$rmc",0,"R");$pdf->Cell(37,6,"$m516r212","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r113","$rmc",0,"R");$pdf->Cell(37,6,"$m516r213","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r114","$rmc",0,"R");$pdf->Cell(37,6,"$m516r214","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");
$pdf->Cell(37,6,"$m516r199","$rmc",0,"R");$pdf->Cell(37,6,"$m516r299","$rmc",1,"R");
                                       }

if ( $strana == 6 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str6.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str6.jpg',0,0,210,297);
}

//modul 513b
$m513r101=$hlavicka->m513r101; if ( $m513r101 == 0 ) $m513r101="";
$m513r102=$hlavicka->m513r102; if ( $m513r102 == 0 ) $m513r102="";
$m513r103=$hlavicka->m513r103; if ( $m513r103 == 0 ) $m513r103="";
$m513r104=$hlavicka->m513r104; if ( $m513r104 == 0 ) $m513r104="";
$m513r105=$hlavicka->m513r105; if ( $m513r105 == 0 ) $m513r105="";
$m513r106=$hlavicka->m513r106; if ( $m513r106 == 0 ) $m513r106="";
$m513r107=$hlavicka->m513r107; if ( $m513r107 == 0 ) $m513r107="";
$m513r108=$hlavicka->m513r108; if ( $m513r108 == 0 ) $m513r108="";
$m513r109=$hlavicka->m513r109; if ( $m513r109 == 0 ) $m513r109="";
$m513r110=$hlavicka->m513r110; if ( $m513r110 == 0 ) $m513r110="";
$m513r199=$hlavicka->m513r199;
//if ( $m513r199 == 0 ) $m513r199="";
$m513r201=$hlavicka->m513r201; if ( $m513r201 == 0 ) $m513r201="";
$m513r202=$hlavicka->m513r202; if ( $m513r202 == 0 ) $m513r202="";
$m513r203=$hlavicka->m513r203; if ( $m513r203 == 0 ) $m513r203="";
$m513r204=$hlavicka->m513r204; if ( $m513r204 == 0 ) $m513r204="";
$m513r205=$hlavicka->m513r205; if ( $m513r205 == 0 ) $m513r205="";
$m513r206=$hlavicka->m513r206; if ( $m513r206 == 0 ) $m513r206="";
$m513r207=$hlavicka->m513r207; if ( $m513r207 == 0 ) $m513r207="";
$m513r208=$hlavicka->m513r208; if ( $m513r208 == 0 ) $m513r208="";
$m513r209=$hlavicka->m513r209; if ( $m513r209 == 0 ) $m513r209="";
$m513r210=$hlavicka->m513r210; if ( $m513r210 == 0 ) $m513r210="";
$m513r299=$hlavicka->m513r299;
//if ( $m513r299 == 0 ) $m513r299="";
$m513r301=$hlavicka->m513r301; if ( $m513r301 == 0 ) $m513r301="";
$m513r302=$hlavicka->m513r302; if ( $m513r302 == 0 ) $m513r302="";
$m513r303=$hlavicka->m513r303; if ( $m513r303 == 0 ) $m513r303="";
$m513r304=$hlavicka->m513r304; if ( $m513r304 == 0 ) $m513r304="";
$m513r305=$hlavicka->m513r305; if ( $m513r305 == 0 ) $m513r305="";
$m513r306=$hlavicka->m513r306; if ( $m513r306 == 0 ) $m513r306="";
$m513r307=$hlavicka->m513r307; if ( $m513r307 == 0 ) $m513r307="";
$m513r308=$hlavicka->m513r308; if ( $m513r308 == 0 ) $m513r308="";
$m513r309=$hlavicka->m513r309; if ( $m513r309 == 0 ) $m513r309="";
$m513r310=$hlavicka->m513r310; if ( $m513r310 == 0 ) $m513r310="";
$m513r399=$hlavicka->m513r399;
//if ( $m513r399 == 0 ) $m513r399="";
$m513r401=$hlavicka->m513r401; if ( $m513r401 == 0 ) $m513r401="";
$m513r402=$hlavicka->m513r402; if ( $m513r402 == 0 ) $m513r402="";
$m513r403=$hlavicka->m513r403; if ( $m513r403 == 0 ) $m513r403="";
$m513r404=$hlavicka->m513r404; if ( $m513r404 == 0 ) $m513r404="";
$m513r405=$hlavicka->m513r405; if ( $m513r405 == 0 ) $m513r405="";
$m513r406=$hlavicka->m513r406; if ( $m513r406 == 0 ) $m513r406="";
$m513r407=$hlavicka->m513r407; if ( $m513r407 == 0 ) $m513r407="";
$m513r408=$hlavicka->m513r408; if ( $m513r408 == 0 ) $m513r408="";
$m513r409=$hlavicka->m513r409; if ( $m513r409 == 0 ) $m513r409="";
$m513r410=$hlavicka->m513r410; if ( $m513r410 == 0 ) $m513r410="";
$m513r499=$hlavicka->m513r499;
//if ( $m513r499 == 0 ) $m513r499="";
$m513r501=$hlavicka->m513r501; if ( $m513r501 == 0 ) $m513r501="";
$m513r502=$hlavicka->m513r502; if ( $m513r502 == 0 ) $m513r502="";
$m513r503=$hlavicka->m513r503; if ( $m513r503 == 0 ) $m513r503="";
$m513r504=$hlavicka->m513r504; if ( $m513r504 == 0 ) $m513r504="";
$m513r505=$hlavicka->m513r505; if ( $m513r505 == 0 ) $m513r505="";
$m513r506=$hlavicka->m513r506; if ( $m513r506 == 0 ) $m513r506="";
$m513r507=$hlavicka->m513r507; if ( $m513r507 == 0 ) $m513r507="";
$m513r508=$hlavicka->m513r508; if ( $m513r508 == 0 ) $m513r508="";
$m513r509=$hlavicka->m513r509; if ( $m513r509 == 0 ) $m513r509="";
$m513r510=$hlavicka->m513r510; if ( $m513r510 == 0 ) $m513r510="";
$m513r599=$hlavicka->m513r599;
//if ( $m513r599 == 0 ) $m513r599="";
$m513r601=$hlavicka->m513r601; if ( $m513r601 == 0 ) $m513r601="";
$m513r602=$hlavicka->m513r602; if ( $m513r602 == 0 ) $m513r602="";
$m513r603=$hlavicka->m513r603; if ( $m513r603 == 0 ) $m513r603="";
$m513r604=$hlavicka->m513r604; if ( $m513r604 == 0 ) $m513r604="";
$m513r605=$hlavicka->m513r605; if ( $m513r605 == 0 ) $m513r605="";
$m513r606=$hlavicka->m513r606; if ( $m513r606 == 0 ) $m513r606="";
$m513r607=$hlavicka->m513r607; if ( $m513r607 == 0 ) $m513r607="";
$m513r608=$hlavicka->m513r608; if ( $m513r608 == 0 ) $m513r608="";
$m513r609=$hlavicka->m513r609; if ( $m513r609 == 0 ) $m513r609="";
$m513r610=$hlavicka->m513r610; if ( $m513r610 == 0 ) $m513r610="";
$m513r699=$hlavicka->m513r699;
//if ( $m513r699 == 0 ) $m513r699="";
$pdf->Cell(195,31," ","$rmc1",1,"L");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,5,"$m513r101","$rmc",0,"R");$pdf->Cell(19,5,"$m513r201","$rmc",0,"R");
$pdf->Cell(20,5,"$m513r301","$rmc",0,"R");$pdf->Cell(20,5,"$m513r401","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r501","$rmc",0,"R");$pdf->Cell(19,5,"$m513r601","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,6,"$m513r102","$rmc",0,"R");$pdf->Cell(19,6,"$m513r202","$rmc",0,"R");
$pdf->Cell(20,6,"$m513r302","$rmc",0,"R");$pdf->Cell(20,6,"$m513r402","$rmc",0,"R");
$pdf->Cell(21,6,"$m513r502","$rmc",0,"R");$pdf->Cell(19,6,"$m513r602","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,5,"$m513r103","$rmc",0,"R");$pdf->Cell(19,5,"$m513r203","$rmc",0,"R");
$pdf->Cell(20,5,"$m513r303","$rmc",0,"R");$pdf->Cell(20,5,"$m513r403","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r503","$rmc",0,"R");$pdf->Cell(19,5,"$m513r603","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,6,"$m513r104","$rmc",0,"R");$pdf->Cell(19,6,"$m513r204","$rmc",0,"R");
$pdf->Cell(20,6,"$m513r304","$rmc",0,"R");$pdf->Cell(20,6,"$m513r404","$rmc",0,"R");
$pdf->Cell(21,6,"$m513r504","$rmc",0,"R");$pdf->Cell(19,6,"$m513r604","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,5,"$m513r105","$rmc",0,"R");$pdf->Cell(19,5,"$m513r205","$rmc",0,"R");
$pdf->Cell(20,5,"$m513r305","$rmc",0,"R");$pdf->Cell(20,5,"$m513r405","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r505","$rmc",0,"R");$pdf->Cell(19,5,"$m513r605","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,8,"$m513r106","$rmc",0,"R");$pdf->Cell(19,8,"$m513r206","$rmc",0,"R");
$pdf->Cell(20,8,"$m513r306","$rmc",0,"R");$pdf->Cell(20,8,"$m513r406","$rmc",0,"R");
$pdf->Cell(21,8,"$m513r506","$rmc",0,"R");$pdf->Cell(19,8,"$m513r606","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,9,"$m513r107","$rmc",0,"R");$pdf->Cell(19,9,"$m513r207","$rmc",0,"R");
$pdf->Cell(20,9,"$m513r307","$rmc",0,"R");$pdf->Cell(20,9,"$m513r407","$rmc",0,"R");
$pdf->Cell(21,9,"$m513r507","$rmc",0,"R");$pdf->Cell(19,9,"$m513r607","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,5,"$m513r108","$rmc",0,"R");$pdf->Cell(19,5,"$m513r208","$rmc",0,"R");
$pdf->Cell(20,5,"$m513r308","$rmc",0,"R");$pdf->Cell(20,5,"$m513r408","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r508","$rmc",0,"R");$pdf->Cell(19,5,"$m513r608","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,9,"$m513r109","$rmc",0,"R");$pdf->Cell(19,9,"$m513r209","$rmc",0,"R");
$pdf->Cell(20,9,"$m513r309","$rmc",0,"R");$pdf->Cell(20,9,"$m513r409","$rmc",0,"R");
$pdf->Cell(21,9,"$m513r509","$rmc",0,"R");$pdf->Cell(19,9,"$m513r609","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,5,"$m513r110","$rmc",0,"R");$pdf->Cell(19,5,"$m513r210","$rmc",0,"R");
$pdf->Cell(20,5,"$m513r310","$rmc",0,"R");$pdf->Cell(20,5,"$m513r410","$rmc",0,"R");
$pdf->Cell(21,5,"$m513r510","$rmc",0,"R");$pdf->Cell(19,5,"$m513r610","$rmc",1,"R");
$pdf->Cell(69,5," ","$rmc1",0,"C");
$pdf->Cell(21,6,"$m513r199","$rmc",0,"R");$pdf->Cell(19,6,"$m513r299","$rmc",0,"R");
$pdf->Cell(20,6,"$m513r399","$rmc",0,"R");$pdf->Cell(20,6,"$m513r499","$rmc",0,"R");
$pdf->Cell(21,6,"$m513r599","$rmc",0,"R");$pdf->Cell(19,6,"$m513r699","$rmc",1,"R");

//modul 581a
$m581r01=$hlavicka->m581r01; if ( $m581r01 == 0 ) $m581r01="";
$m581r02=$hlavicka->m581r02; if ( $m581r02 == 0 ) $m581r02="";
$m581r99=$hlavicka->m581r99;
//if ( $m581r99 == 0 ) $m581r99="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$m581r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m581r02","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m581r99","$rmc",1,"R");

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
$pdf->Cell(190,27," ","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r201","$rmc",0,"C");$pdf->Cell(25,5,"$m588r301","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r202","$rmc",0,"C");$pdf->Cell(25,5,"$m588r302","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r203","$rmc",0,"C");$pdf->Cell(25,6,"$m588r303","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r204","$rmc",0,"C");$pdf->Cell(25,5,"$m588r304","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r205","$rmc",0,"C");$pdf->Cell(25,6,"$m588r305","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r206","$rmc",0,"C");$pdf->Cell(25,5,"$m588r306","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r207","$rmc",0,"C");$pdf->Cell(25,6,"$m588r307","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r208","$rmc",0,"C");$pdf->Cell(25,5,"$m588r308","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r209","$rmc",0,"C");$pdf->Cell(25,6,"$m588r309","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r210","$rmc",0,"C");$pdf->Cell(25,5,"$m588r310","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r211","$rmc",0,"C");$pdf->Cell(25,6,"$m588r311","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r212","$rmc",0,"C");$pdf->Cell(25,5,"$m588r312","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r213","$rmc",0,"C");$pdf->Cell(25,6,"$m588r313","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r214","$rmc",0,"C");$pdf->Cell(25,5,"$m588r314","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r215","$rmc",0,"C");$pdf->Cell(25,6,"$m588r315","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r216","$rmc",0,"C");$pdf->Cell(25,5,"$m588r316","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r217","$rmc",0,"C");$pdf->Cell(25,6,"$m588r317","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r218","$rmc",0,"C");$pdf->Cell(25,5,"$m588r318","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r219","$rmc",0,"C");$pdf->Cell(25,6,"$m588r319","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r220","$rmc",0,"C");$pdf->Cell(25,5,"$m588r320","$rmc",1,"C");
                                       }

if ( $strana == 7 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str7.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str7.jpg',0,0,210,297);
}

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
$pdf->Cell(83,5," ","$rmc1",0,"L");
$pdf->Cell(8,6,"$A","$rmc",0,"C");$pdf->Cell(8,6,"$B","$rmc",0,"C");$pdf->Cell(8,6,"$C","$rmc",0,"C");$pdf->Cell(8,6,"$D","$rmc",0,"C");
$pdf->Cell(9,6,"$E","$rmc",0,"C");$pdf->Cell(8,6,"$F","$rmc",0,"C");$pdf->Cell(8,6,"$G","$rmc",0,"C");$pdf->Cell(8,6,"$H","$rmc",1,"C");

//modul 588 pokrac.
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
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r221","$rmc",0,"C");$pdf->Cell(25,6,"$m588r321","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r222","$rmc",0,"C");$pdf->Cell(25,5,"$m588r322","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r223","$rmc",0,"C");$pdf->Cell(25,6,"$m588r323","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r224","$rmc",0,"C");$pdf->Cell(25,5,"$m588r324","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r225","$rmc",0,"C");$pdf->Cell(25,6,"$m588r325","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r226","$rmc",0,"C");$pdf->Cell(25,5,"$m588r326","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r227","$rmc",0,"C");$pdf->Cell(25,6,"$m588r327","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r228","$rmc",0,"C");$pdf->Cell(25,5,"$m588r328","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r229","$rmc",0,"C");$pdf->Cell(25,6,"$m588r329","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r230","$rmc",0,"C");$pdf->Cell(25,5,"$m588r330","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r231","$rmc",0,"C");$pdf->Cell(25,6,"$m588r331","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r232","$rmc",0,"C");$pdf->Cell(25,6,"$m588r332","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r233","$rmc",0,"C");$pdf->Cell(25,5,"$m588r333","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r234","$rmc",0,"C");$pdf->Cell(25,5,"$m588r334","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r235","$rmc",0,"C");$pdf->Cell(25,6,"$m588r335","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r236","$rmc",0,"C");$pdf->Cell(25,5,"$m588r336","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r237","$rmc",0,"C");$pdf->Cell(25,6,"$m588r337","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r238","$rmc",0,"C");$pdf->Cell(25,5,"$m588r338","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r239","$rmc",0,"C");$pdf->Cell(25,6,"$m588r339","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r240","$rmc",0,"C");$pdf->Cell(25,6,"$m588r340","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,8,"$m588r241","$rmc",0,"C");$pdf->Cell(25,8,"$m588r341","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r242","$rmc",0,"C");$pdf->Cell(25,5,"$m588r342","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r243","$rmc",0,"C");$pdf->Cell(25,6,"$m588r343","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r244","$rmc",0,"C");$pdf->Cell(25,5,"$m588r344","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r245","$rmc",0,"C");$pdf->Cell(25,6,"$m588r345","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r246","$rmc",0,"C");$pdf->Cell(25,6,"$m588r346","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,8,"$m588r247","$rmc",0,"C");$pdf->Cell(25,8,"$m588r347","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r248","$rmc",0,"C");$pdf->Cell(25,5,"$m588r348","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r249","$rmc",0,"C");$pdf->Cell(25,6,"$m588r349","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,5,"$m588r250","$rmc",0,"C");$pdf->Cell(25,5,"$m588r350","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");
$pdf->Cell(25,6,"$m588r251","$rmc",0,"C");$pdf->Cell(25,6,"$m588r351","$rmc",1,"C");
$pdf->Cell(139,6," ","$rmc1",0,"L");

//modul 177a
$m177r01=$hlavicka->m177r01; if ( $m177r01 == 0 ) $m177r01="";
$m177r02=$hlavicka->m177r02; if ( $m177r02 == 0 ) $m177r02="";
$m177r03=$hlavicka->m177r03; if ( $m177r03 == 0 ) $m177r03="";
$m177r04=$hlavicka->m177r04; if ( $m177r04 == 0 ) $m177r04="";
$m177r05=$hlavicka->m177r05; if ( $m177r05 == 0 ) $m177r05="";
$m177r06=$hlavicka->m177r06; if ( $m177r06 == 0 ) $m177r06="";
$m177r07=$hlavicka->m177r07; if ( $m177r07 == 0 ) $m177r07="";
$m177r08=$hlavicka->m177r08; if ( $m177r08 == 0 ) $m177r08="";
$m177r99=$hlavicka->m177r99;
//if ( $m177r99 == 0 ) $m177r99="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$m177r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$m177r02","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m177r03","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$m177r04","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m177r05","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$m177r06","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m177r07","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,5,"$m177r08","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(75,6,"$m177r99","$rmc",1,"R");
                                       }

if ( $strana == 8 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str8.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str8.jpg',0,0,210,297);
}

//modul 178a
$m178r01=$hlavicka->m178r01; if ( $m178r01 == 0 ) $m178r01="";
$m178r02=$hlavicka->m178r02; if ( $m178r02 == 0 ) $m178r02="";
$m178r03=$hlavicka->m178r03; if ( $m178r03 == 0 ) $m178r03="";
$m178r04=$hlavicka->m178r04; if ( $m178r04 == 0 ) $m178r04="";
$m178r05=$hlavicka->m178r05; if ( $m178r05 == 0 ) $m178r05="";
$m178r06=$hlavicka->m178r06; if ( $m178r06 == 0 ) $m178r06="";
$m178r07=$hlavicka->m178r07; if ( $m178r07 == 0 ) $m178r07="";
$m178r08=$hlavicka->m178r08; if ( $m178r08 == 0 ) $m178r08="";
$m178r09=$hlavicka->m178r09; if ( $m178r09 == 0 ) $m178r09="";
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
$m178r20=$hlavicka->m178r20; if ( $m178r20 == 0 ) $m178r20="";
$m178r21=$hlavicka->m178r21; if ( $m178r21 == 0 ) $m178r21="";
$m178r99=$hlavicka->m178r99;
//if ( $m178r99 == 0 ) $m178r99="";
$pdf->Cell(195,22," ","$rmc1",1,"L");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r01","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r02","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r03","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r04","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r05","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r06","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,8,"$m178r07","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r08","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r09","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r10","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r11","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r12","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,8,"$m178r13","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r14","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r15","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r16","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r17","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r18","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r19","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r20","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,5,"$m178r21","$rmc",1,"R");
$pdf->Cell(126,5," ","$rmc1",0,"C");$pdf->Cell(62,6,"$m178r99","$rmc",1,"R");

//modul 179b
$m179r01=$hlavicka->m179r01; if ( $m179r01 == 0 ) $m179r01="";
$m179r02=$hlavicka->m179r02; if ( $m179r02 == 0 ) $m179r02="";
$m179r99=$hlavicka->m179r99;
//if ( $m179r99 == 0 ) $m179r99="";
$pdf->Cell(195,25," ","$rmc1",1,"L");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(74,6,"$m179r01","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(74,6,"$m179r02","$rmc",1,"R");
$pdf->Cell(114,5," ","$rmc1",0,"C");$pdf->Cell(74,6,"$m179r99","$rmc",1,"R");

//modul 182a
$m182r001=$hlavicka->m182r001;
$m182r002=$hlavicka->m182r002;
$m182r003=$hlavicka->m182r003;
$m182r004=$hlavicka->m182r004;
$m182r005=$hlavicka->m182r005;
$m182r006=$hlavicka->m182r006;
$m182r007=$hlavicka->m182r007;
$m182r101=$hlavicka->m182r101;
$m182r102=$hlavicka->m182r102;
$m182r103=$hlavicka->m182r103;
$m182r104=$hlavicka->m182r104;
$m182r105=$hlavicka->m182r105;
$m182r106=$hlavicka->m182r106;
$m182r107=$hlavicka->m182r107;
$m182r201=$hlavicka->m182r201; if ( $m182r201 == 0 ) $m182r201="";
$m182r202=$hlavicka->m182r202; if ( $m182r202 == 0 ) $m182r202="";
$m182r203=$hlavicka->m182r203; if ( $m182r203 == 0 ) $m182r203="";
$m182r204=$hlavicka->m182r204; if ( $m182r204 == 0 ) $m182r204="";
$m182r205=$hlavicka->m182r205; if ( $m182r205 == 0 ) $m182r205="";
$m182r206=$hlavicka->m182r206; if ( $m182r206 == 0 ) $m182r206="";
$m182r207=$hlavicka->m182r207; if ( $m182r207 == 0 ) $m182r207="";
$m182r299=$hlavicka->m182r299;
//if ( $m182r299 == 0 ) $m182r299="";
$pdf->Cell(195,28," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,5,"$m182r001","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,5,"$m182r101","$rmc",0,"C");
$pdf->Cell(62,5,"$m182r201","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,5,"$m182r002","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,5,"$m182r102","$rmc",0,"C");
$pdf->Cell(62,5,"$m182r202","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m182r003","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,6,"$m182r103","$rmc",0,"C");
$pdf->Cell(62,6,"$m182r203","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,5,"$m182r004","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,5,"$m182r104","$rmc",0,"C");
$pdf->Cell(62,5,"$m182r204","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m182r005","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,6,"$m182r105","$rmc",0,"C");
$pdf->Cell(62,6,"$m182r205","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m182r006","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,6,"$m182r106","$rmc",0,"C");
$pdf->Cell(62,6,"$m182r206","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,5,"$m182r007","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,5,"$m182r107","$rmc",0,"C");
$pdf->Cell(62,5,"$m182r207","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,5,"$m182r099","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(37,5,"$m182r199","$rmc",0,"C");
$pdf->Cell(62,5,"$m182r299","$rmc",1,"R");
                                       }

if ( $strana == 9 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str9.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str9.jpg',0,0,210,297);
}

//modul 183a
$m183r001=$hlavicka->m183r001;
$m183r002=$hlavicka->m183r002;
$m183r003=$hlavicka->m183r003;
$m183r004=$hlavicka->m183r004;
$m183r005=$hlavicka->m183r005;
$m183r006=$hlavicka->m183r006;
$m183r007=$hlavicka->m183r007;
$m183r008=$hlavicka->m183r008;
$m183r009=$hlavicka->m183r009;
$m183r010=$hlavicka->m183r010;
$m183r101=$hlavicka->m183r101; if ( $m183r101 == 0 ) $m183r101="";
$m183r102=$hlavicka->m183r102; if ( $m183r102 == 0 ) $m183r102="";
$m183r103=$hlavicka->m183r103; if ( $m183r103 == 0 ) $m183r103="";
$m183r104=$hlavicka->m183r104; if ( $m183r104 == 0 ) $m183r104="";
$m183r105=$hlavicka->m183r105; if ( $m183r105 == 0 ) $m183r105="";
$m183r106=$hlavicka->m183r106; if ( $m183r106 == 0 ) $m183r106="";
$m183r107=$hlavicka->m183r107; if ( $m183r107 == 0 ) $m183r107="";
$m183r108=$hlavicka->m183r108; if ( $m183r108 == 0 ) $m183r108="";
$m183r109=$hlavicka->m183r109; if ( $m183r109 == 0 ) $m183r109="";
$m183r110=$hlavicka->m183r110; if ( $m183r110 == 0 ) $m183r110="";
$m183r199=$hlavicka->m183r199;
//if ( $m183r199 == 0 ) $m183r199="";
$m183r201=$hlavicka->m183r201; if ( $m183r201 == 0 ) $m183r201="";
$m183r202=$hlavicka->m183r202; if ( $m183r202 == 0 ) $m183r202="";
$m183r203=$hlavicka->m183r203; if ( $m183r203 == 0 ) $m183r203="";
$m183r204=$hlavicka->m183r204; if ( $m183r204 == 0 ) $m183r204="";
$m183r205=$hlavicka->m183r205; if ( $m183r205 == 0 ) $m183r205="";
$m183r206=$hlavicka->m183r206; if ( $m183r206 == 0 ) $m183r206="";
$m183r207=$hlavicka->m183r207; if ( $m183r207 == 0 ) $m183r207="";
$m183r208=$hlavicka->m183r208; if ( $m183r208 == 0 ) $m183r208="";
$m183r209=$hlavicka->m183r209; if ( $m183r209 == 0 ) $m183r209="";
$m183r210=$hlavicka->m183r210; if ( $m183r210 == 0 ) $m183r210="";
$m183r299=$hlavicka->m183r299;
//if ( $m183r299 == 0 ) $m183r299="";
$pdf->Cell(195,33," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r001","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r101","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r201","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r002","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r102","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r202","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r003","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r103","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r203","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r004","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r104","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r204","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r005","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r105","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r205","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r006","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r106","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r206","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r007","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r107","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r207","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r008","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r108","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r208","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r009","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r109","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r209","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,6,"$m183r010","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,6,"$m183r110","$rmc",0,"C");
$pdf->Cell(48,6,"$m183r210","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(79,5,"","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(50,5,"","$rmc",0,"C");
$pdf->Cell(48,5,"$m183r299","$rmc",1,"R");

//modul 184a
$m184r001=$hlavicka->m184r001;
$m184r002=$hlavicka->m184r002;
$m184r003=$hlavicka->m184r003;
$m184r004=$hlavicka->m184r004;
$m184r005=$hlavicka->m184r005;
$m184r006=$hlavicka->m184r006;
$m184r007=$hlavicka->m184r007;
$m184r008=$hlavicka->m184r008;
$m184r009=$hlavicka->m184r009;
$m184r010=$hlavicka->m184r010;
$m184r101=$hlavicka->m184r101;
$m184r102=$hlavicka->m184r102;
$m184r103=$hlavicka->m184r103;
$m184r104=$hlavicka->m184r104;
$m184r105=$hlavicka->m184r105;
$m184r106=$hlavicka->m184r106;
$m184r107=$hlavicka->m184r107;
$m184r108=$hlavicka->m184r108;
$m184r109=$hlavicka->m184r109;
$m184r110=$hlavicka->m184r110;
$m184r199=$hlavicka->m184r199;
//if ( $m184r199 == 0 ) $m184r199="";
$m184r201=$hlavicka->m184r201; if ( $m184r201 == 0 ) $m184r201="";
$m184r202=$hlavicka->m184r202; if ( $m184r202 == 0 ) $m184r202="";
$m184r203=$hlavicka->m184r203; if ( $m184r203 == 0 ) $m184r203="";
$m184r204=$hlavicka->m184r204; if ( $m184r204 == 0 ) $m184r204="";
$m184r205=$hlavicka->m184r205; if ( $m184r205 == 0 ) $m184r205="";
$m184r206=$hlavicka->m184r206; if ( $m184r206 == 0 ) $m184r206="";
$m184r207=$hlavicka->m184r207; if ( $m184r207 == 0 ) $m184r207="";
$m184r208=$hlavicka->m184r208; if ( $m184r208 == 0 ) $m184r208="";
$m184r209=$hlavicka->m184r209; if ( $m184r209 == 0 ) $m184r209="";
$m184r210=$hlavicka->m184r210; if ( $m184r210 == 0 ) $m184r210="";
$m184r299=$hlavicka->m184r299;
//if ( $m184r299 == 0 ) $m184r299="";
$m184r301=$hlavicka->m184r301; if ( $m184r301 == 0 ) $m184r301="";
$m184r302=$hlavicka->m184r302; if ( $m184r302 == 0 ) $m184r302="";
$m184r303=$hlavicka->m184r303; if ( $m184r303 == 0 ) $m184r303="";
$m184r304=$hlavicka->m184r304; if ( $m184r304 == 0 ) $m184r304="";
$m184r305=$hlavicka->m184r305; if ( $m184r305 == 0 ) $m184r305="";
$m184r306=$hlavicka->m184r306; if ( $m184r306 == 0 ) $m184r306="";
$m184r307=$hlavicka->m184r307; if ( $m184r307 == 0 ) $m184r307="";
$m184r308=$hlavicka->m184r308; if ( $m184r308 == 0 ) $m184r308="";
$m184r309=$hlavicka->m184r309; if ( $m184r309 == 0 ) $m184r309="";
$m184r310=$hlavicka->m184r310; if ( $m184r310 == 0 ) $m184r310="";
$m184r399=$hlavicka->m184r399;
//if ( $m184r399 == 0 ) $m184r399="";
$pdf->Cell(195,50," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r001","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r101","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r201","$rmc",0,"R");$pdf->Cell(43,6,"$m184r301","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r002","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r102","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r202","$rmc",0,"R");$pdf->Cell(43,6,"$m184r302","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r003","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r103","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r203","$rmc",0,"R");$pdf->Cell(43,6,"$m184r303","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r004","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r104","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r204","$rmc",0,"R");$pdf->Cell(43,6,"$m184r304","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r005","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r105","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r205","$rmc",0,"R");$pdf->Cell(43,6,"$m184r305","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r006","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r106","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r206","$rmc",0,"R");$pdf->Cell(43,6,"$m184r306","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r007","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r107","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r207","$rmc",0,"R");$pdf->Cell(43,6,"$m184r307","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r008","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r108","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r208","$rmc",0,"R");$pdf->Cell(43,6,"$m184r308","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r009","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r109","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r209","$rmc",0,"R");$pdf->Cell(43,6,"$m184r309","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m184r010","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m184r110","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r210","$rmc",0,"R");$pdf->Cell(43,6,"$m184r310","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"","$rmc",0,"C");
$pdf->Cell(48,6,"$m184r299","$rmc",0,"R");$pdf->Cell(43,6,"$m184r399","$rmc",1,"R");
                                       }

if ( $strana == 10 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str10.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str10.jpg',0,0,210,297);
}

//modul 185a
$m185r001=$hlavicka->m185r001;
$m185r002=$hlavicka->m185r002;
$m185r003=$hlavicka->m185r003;
$m185r004=$hlavicka->m185r004;
$m185r005=$hlavicka->m185r005;
$m185r006=$hlavicka->m185r006;
$m185r007=$hlavicka->m185r007;
$m185r101=$hlavicka->m185r101;
$m185r102=$hlavicka->m185r102;
$m185r103=$hlavicka->m185r103;
$m185r104=$hlavicka->m185r104;
$m185r105=$hlavicka->m185r105;
$m185r106=$hlavicka->m185r106;
$m185r107=$hlavicka->m185r107;
$m185r199=$hlavicka->m185r199;
//if ( $m185r199 == 0 ) $m185r199="";
$m185r201=$hlavicka->m185r201; if ( $m185r201 == 0 ) $m185r201="";
$m185r202=$hlavicka->m185r202; if ( $m185r202 == 0 ) $m185r202="";
$m185r203=$hlavicka->m185r203; if ( $m185r203 == 0 ) $m185r203="";
$m185r204=$hlavicka->m185r204; if ( $m185r204 == 0 ) $m185r204="";
$m185r205=$hlavicka->m185r205; if ( $m185r205 == 0 ) $m185r205="";
$m185r206=$hlavicka->m185r206; if ( $m185r206 == 0 ) $m185r206="";
$m185r207=$hlavicka->m185r207; if ( $m185r207 == 0 ) $m185r207="";
$m185r299=$hlavicka->m185r299;
//if ( $m185r299 == 0 ) $m185r299="";
$m185r301=$hlavicka->m185r301; if ( $m185r301 == 0 ) $m185r301="";
$m185r302=$hlavicka->m185r302; if ( $m185r302 == 0 ) $m185r302="";
$m185r303=$hlavicka->m185r303; if ( $m185r303 == 0 ) $m185r303="";
$m185r304=$hlavicka->m185r304; if ( $m185r304 == 0 ) $m185r304="";
$m185r305=$hlavicka->m185r305; if ( $m185r305 == 0 ) $m185r305="";
$m185r306=$hlavicka->m185r306; if ( $m185r306 == 0 ) $m185r306="";
$m185r307=$hlavicka->m185r307; if ( $m185r307 == 0 ) $m185r307="";
$m185r399=$hlavicka->m185r399;
//if ( $m185r399 == 0 ) $m185r399="";
$pdf->Cell(195,26," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m185r001","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m185r101","$rmc",0,"C");
$pdf->Cell(48,5,"$m185r201","$rmc",0,"R");$pdf->Cell(43,5,"$m185r301","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m185r002","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m185r102","$rmc",0,"C");
$pdf->Cell(48,6,"$m185r202","$rmc",0,"R");$pdf->Cell(43,6,"$m185r302","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m185r003","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m185r103","$rmc",0,"C");
$pdf->Cell(48,5,"$m185r203","$rmc",0,"R");$pdf->Cell(43,5,"$m185r303","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m185r004","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m185r104","$rmc",0,"C");
$pdf->Cell(48,6,"$m185r204","$rmc",0,"R");$pdf->Cell(43,6,"$m185r304","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m185r005","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m185r105","$rmc",0,"C");
$pdf->Cell(48,5,"$m185r205","$rmc",0,"R");$pdf->Cell(43,5,"$m185r305","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m185r006","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m185r106","$rmc",0,"C");
$pdf->Cell(48,5,"$m185r206","$rmc",0,"R");$pdf->Cell(43,5,"$m185r306","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m185r007","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m185r107","$rmc",0,"C");
$pdf->Cell(48,6,"$m185r207","$rmc",0,"R");$pdf->Cell(43,6,"$m185r307","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"","$rmc",0,"C");
$pdf->Cell(48,6,"$m185r299","$rmc",0,"R");$pdf->Cell(43,6,"$m185r399","$rmc",1,"R");

//modul 186a
$m186r001=$hlavicka->m186r001;
$m186r002=$hlavicka->m186r002;
$m186r003=$hlavicka->m186r003;
$m186r004=$hlavicka->m186r004;
$m186r005=$hlavicka->m186r005;
$m186r006=$hlavicka->m186r006;
$m186r007=$hlavicka->m186r007;
$m186r101=$hlavicka->m186r101;
$m186r102=$hlavicka->m186r102;
$m186r103=$hlavicka->m186r103;
$m186r104=$hlavicka->m186r104;
$m186r105=$hlavicka->m186r105;
$m186r106=$hlavicka->m186r106;
$m186r107=$hlavicka->m186r107;
$m186r201=$hlavicka->m186r201; if ( $m186r201 == 0 ) $m186r201="";
$m186r202=$hlavicka->m186r202; if ( $m186r202 == 0 ) $m186r202="";
$m186r203=$hlavicka->m186r203; if ( $m186r203 == 0 ) $m186r203="";
$m186r204=$hlavicka->m186r204; if ( $m186r204 == 0 ) $m186r204="";
$m186r205=$hlavicka->m186r205; if ( $m186r205 == 0 ) $m186r205="";
$m186r206=$hlavicka->m186r206; if ( $m186r206 == 0 ) $m186r206="";
$m186r207=$hlavicka->m186r207; if ( $m186r207 == 0 ) $m186r207="";
$m186r299=$hlavicka->m186r299;
//if ( $m186r299 == 0 ) $m186r299="";
$m186r301=$hlavicka->m186r301; if ( $m186r301 == 0 ) $m186r301="";
$m186r302=$hlavicka->m186r302; if ( $m186r302 == 0 ) $m186r302="";
$m186r303=$hlavicka->m186r303; if ( $m186r303 == 0 ) $m186r303="";
$m186r304=$hlavicka->m186r304; if ( $m186r304 == 0 ) $m186r304="";
$m186r305=$hlavicka->m186r305; if ( $m186r305 == 0 ) $m186r305="";
$m186r306=$hlavicka->m186r306; if ( $m186r306 == 0 ) $m186r306="";
$m186r307=$hlavicka->m186r307; if ( $m186r307 == 0 ) $m186r307="";
$m186r399=$hlavicka->m186r399;
//if ( $m186r399 == 0 ) $m186r399="";
$pdf->Cell(195,47," ","$rmc1",1,"L");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m186r001","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m186r101","$rmc",0,"C");
$pdf->Cell(48,5,"$m186r201","$rmc",0,"R");$pdf->Cell(43,5,"$m186r301","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m186r002","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m186r102","$rmc",0,"C");
$pdf->Cell(48,6,"$m186r202","$rmc",0,"R");$pdf->Cell(43,6,"$m186r302","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m186r003","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m186r103","$rmc",0,"C");
$pdf->Cell(48,5,"$m186r203","$rmc",0,"R");$pdf->Cell(43,5,"$m186r303","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m186r004","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m186r104","$rmc",0,"C");
$pdf->Cell(48,6,"$m186r204","$rmc",0,"R");$pdf->Cell(43,6,"$m186r304","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m186r005","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m186r105","$rmc",0,"C");
$pdf->Cell(48,5,"$m186r205","$rmc",0,"R");$pdf->Cell(43,5,"$m186r305","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,5,"$m186r006","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,5,"$m186r106","$rmc",0,"C");
$pdf->Cell(48,5,"$m186r206","$rmc",0,"R");$pdf->Cell(43,5,"$m186r306","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"$m186r007","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"$m186r107","$rmc",0,"C");
$pdf->Cell(48,6,"$m186r207","$rmc",0,"R");$pdf->Cell(43,6,"$m186r307","$rmc",1,"R");
$pdf->Cell(1,5," ","$rmc1",0,"C");$pdf->Cell(59,6,"","$rmc",0,"L");
$pdf->Cell(9,5," ","$rmc1",0,"C");$pdf->Cell(29,6,"","$rmc",0,"C");
$pdf->Cell(48,6,"$m186r299","$rmc",0,"R");$pdf->Cell(43,6,"$m186r399","$rmc",1,"R");

//modul 304a
$m304r01=$hlavicka->m304r01; if ( $m304r01 == 0 ) $m304r01="";
$m304r02=$hlavicka->m304r02; if ( $m304r02 == 0 ) $m304r02="";
$m304r03=$hlavicka->m304r03; if ( $m304r03 == 0 ) $m304r03="";
$m304r04=$hlavicka->m304r04; if ( $m304r04 == 0 ) $m304r04="";
$m304r05=$hlavicka->m304r05; if ( $m304r05 == 0 ) $m304r05="";
$m304r06=$hlavicka->m304r06; if ( $m304r06 == 0 ) $m304r06="";
$m304r99=$hlavicka->m304r99;
//if ( $m304r99 == 0 ) $m304r99="";
$pdf->Cell(195,54," ","$rmc1",1,"L");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,5,"$m304r01","$rmc",1,"R");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,6,"$m304r02","$rmc",1,"R");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,6,"$m304r03","$rmc",1,"R");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,6,"$m304r04","$rmc",1,"R");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,6,"$m304r05","$rmc",1,"R");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,6,"$m304r06","$rmc",1,"R");
$pdf->Cell(116,5," ","$rmc1",0,"C");$pdf->Cell(72,6,"$m304r99","$rmc",1,"R");
                                        }

if ( $strana == 11 OR $strana == 9999 ) {
$pdf->AddPage(L);
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str11.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str11.jpg',8,8,298,199);
}

//modul 527a
$m527r101=$hlavicka->m527r101; if ( $m527r101 == 0 ) $m527r101="";
$m527r102=$hlavicka->m527r102; if ( $m527r102 == 0 ) $m527r102="";
$m527r103=$hlavicka->m527r103; if ( $m527r103 == 0 ) $m527r103="";
$m527r104=$hlavicka->m527r104; if ( $m527r104 == 0 ) $m527r104="";
$m527r201=$hlavicka->m527r201; if ( $m527r201 == 0 ) $m527r201="";
$m527r202=$hlavicka->m527r202; if ( $m527r202 == 0 ) $m527r202="";
$m527r203=$hlavicka->m527r203; if ( $m527r203 == 0 ) $m527r203="";
$m527r204=$hlavicka->m527r204; if ( $m527r204 == 0 ) $m527r204="";
$m527r301=$hlavicka->m527r301; if ( $m527r301 == 0 ) $m527r301="";
$m527r302=$hlavicka->m527r302; if ( $m527r302 == 0 ) $m527r302="";
$m527r303=$hlavicka->m527r303; if ( $m527r303 == 0 ) $m527r303="";
$m527r304=$hlavicka->m527r304; if ( $m527r304 == 0 ) $m527r304="";
$m527r401=$hlavicka->m527r401; if ( $m527r401 == 0 ) $m527r401="";
$m527r402=$hlavicka->m527r402; if ( $m527r402 == 0 ) $m527r402="";
$m527r403=$hlavicka->m527r403; if ( $m527r403 == 0 ) $m527r403="";
$m527r404=$hlavicka->m527r404; if ( $m527r404 == 0 ) $m527r404="";
$m527r501=$hlavicka->m527r501; if ( $m527r501 == 0 ) $m527r501="";
$m527r502=$hlavicka->m527r502; if ( $m527r502 == 0 ) $m527r502="";
$m527r503=$hlavicka->m527r503; if ( $m527r503 == 0 ) $m527r503="";
$m527r504=$hlavicka->m527r504; if ( $m527r504 == 0 ) $m527r504="";
$m527r601=$hlavicka->m527r601; if ( $m527r601 == 0 ) $m527r601="";
$m527r602=$hlavicka->m527r602; if ( $m527r602 == 0 ) $m527r602="";
$m527r603=$hlavicka->m527r603; if ( $m527r603 == 0 ) $m527r603="";
$m527r604=$hlavicka->m527r604; if ( $m527r604 == 0 ) $m527r604="";
$m527r701=$hlavicka->m527r701; if ( $m527r701 == 0 ) $m527r701="";
$m527r702=$hlavicka->m527r702; if ( $m527r702 == 0 ) $m527r702="";
$m527r703=$hlavicka->m527r703; if ( $m527r703 == 0 ) $m527r703="";
$m527r704=$hlavicka->m527r704; if ( $m527r704 == 0 ) $m527r704="";
$m527r801=$hlavicka->m527r801; if ( $m527r801 == 0 ) $m527r801="";
$m527r802=$hlavicka->m527r802; if ( $m527r802 == 0 ) $m527r802="";
$m527r803=$hlavicka->m527r803; if ( $m527r803 == 0 ) $m527r803="";
$m527r804=$hlavicka->m527r804; if ( $m527r804 == 0 ) $m527r804="";
$m527r901=$hlavicka->m527r901; if ( $m527r901 == 0 ) $m527r901="";
$m527r902=$hlavicka->m527r902; if ( $m527r902 == 0 ) $m527r902="";
$m527r903=$hlavicka->m527r903; if ( $m527r903 == 0 ) $m527r903="";
$m527r904=$hlavicka->m527r904; if ( $m527r904 == 0 ) $m527r904="";
$m527r1001=$hlavicka->m527r1001; if ( $m527r1001 == 0 ) $m527r1001="";
$m527r1002=$hlavicka->m527r1002; if ( $m527r1002 == 0 ) $m527r1002="";
$m527r1003=$hlavicka->m527r1003; if ( $m527r1003 == 0 ) $m527r1003="";
$m527r1004=$hlavicka->m527r1004; if ( $m527r1004 == 0 ) $m527r1004="";
$pdf->Cell(195,59," ","$rmc1",1,"L");
$pdf->Cell(69,8," ","$rmc1",0,"C");$pdf->Cell(17,8,"$m527r101","$rmc",0,"R");
$pdf->Cell(30,8,"$m527r201","$rmc",0,"R");$pdf->Cell(21,8,"$m527r301","$rmc",0,"R");
$pdf->Cell(20,8,"$m527r401","$rmc",0,"R");$pdf->Cell(25,8,"$m527r501","$rmc",0,"R");
$pdf->Cell(20,8,"$m527r601","$rmc",0,"R");$pdf->Cell(22,8,"$m527r701","$rmc",0,"R");
$pdf->Cell(21,8,"$m527r801","$rmc",0,"R");$pdf->Cell(20,8,"$m527r901","$rmc",0,"R");
$pdf->Cell(20,8,"$m527r1001","$rmc",1,"R");
$pdf->Cell(69,7," ","$rmc1",0,"C");$pdf->Cell(17,7,"$m527r102","$rmc",0,"R");
$pdf->Cell(30,7,"$m527r202","$rmc",0,"R");$pdf->Cell(21,7,"$m527r302","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r402","$rmc",0,"R");$pdf->Cell(25,7,"$m527r502","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r602","$rmc",0,"R");$pdf->Cell(22,7,"$m527r702","$rmc",0,"R");
$pdf->Cell(21,7,"$m527r802","$rmc",0,"R");$pdf->Cell(20,7,"$m527r902","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r1002","$rmc",1,"R");
$pdf->Cell(69,7," ","$rmc1",0,"C");$pdf->Cell(17,7,"$m527r103","$rmc",0,"R");
$pdf->Cell(30,7,"$m527r203","$rmc",0,"R");$pdf->Cell(21,7,"$m527r303","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r403","$rmc",0,"R");$pdf->Cell(25,7,"$m527r503","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r603","$rmc",0,"R");$pdf->Cell(22,7,"$m527r703","$rmc",0,"R");
$pdf->Cell(21,7,"$m527r803","$rmc",0,"R");$pdf->Cell(20,7,"$m527r903","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r1003","$rmc",1,"R");
$pdf->Cell(69,7," ","$rmc1",0,"C");$pdf->Cell(17,7,"$m527r104","$rmc",0,"R");
$pdf->Cell(30,7,"$m527r204","$rmc",0,"R");$pdf->Cell(21,7,"$m527r304","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r404","$rmc",0,"R");$pdf->Cell(25,7,"$m527r504","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r604","$rmc",0,"R");$pdf->Cell(22,7,"$m527r704","$rmc",0,"R");
$pdf->Cell(21,7,"$m527r804","$rmc",0,"R");$pdf->Cell(20,7,"$m527r904","$rmc",0,"R");
$pdf->Cell(20,7,"$m527r1004","$rmc",1,"R");
                                        }

if ( $strana == 12 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str12.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str12.jpg',0,0,210,297);
}

//modul 474a
$m474r101=$hlavicka->m474r101; if ( $m474r101 == 0 ) $m474r101="";
$m474r102=$hlavicka->m474r102; if ( $m474r102 == 0 ) $m474r102="";
$m474r103=$hlavicka->m474r103; if ( $m474r103 == 0 ) $m474r103="";
$m474r104=$hlavicka->m474r104; if ( $m474r104 == 0 ) $m474r104="";
$m474r105=$hlavicka->m474r105; if ( $m474r105 == 0 ) $m474r105="";
$m474r106=$hlavicka->m474r106; if ( $m474r106 == 0 ) $m474r106="";
$m474r107=$hlavicka->m474r107; if ( $m474r107 == 0 ) $m474r107="";
$m474r199=$hlavicka->m474r199;
//if ( $m474r199 == 0 ) $m474r199="";
$m474r201=$hlavicka->m474r201; if ( $m474r201 == 0 ) $m474r201="";
$m474r202=$hlavicka->m474r202; if ( $m474r202 == 0 ) $m474r202="";
$m474r203=$hlavicka->m474r203; if ( $m474r203 == 0 ) $m474r203="";
$m474r204=$hlavicka->m474r204; if ( $m474r204 == 0 ) $m474r204="";
$m474r205=$hlavicka->m474r205; if ( $m474r205 == 0 ) $m474r205="";
$m474r206=$hlavicka->m474r206; if ( $m474r206 == 0 ) $m474r206="";
$m474r207=$hlavicka->m474r207; if ( $m474r207 == 0 ) $m474r207="";
$m474r299=$hlavicka->m474r299;
//if ( $m474r299 == 0 ) $m474r299="";
$m474r301=$hlavicka->m474r301; if ( $m474r301 == 0 ) $m474r301="";
$m474r302=$hlavicka->m474r302; if ( $m474r302 == 0 ) $m474r302="";
$m474r303=$hlavicka->m474r303; if ( $m474r303 == 0 ) $m474r303="";
$m474r304=$hlavicka->m474r304; if ( $m474r304 == 0 ) $m474r304="";
$m474r305=$hlavicka->m474r305; if ( $m474r305 == 0 ) $m474r305="";
$m474r306=$hlavicka->m474r306; if ( $m474r306 == 0 ) $m474r306="";
$m474r307=$hlavicka->m474r307; if ( $m474r307 == 0 ) $m474r307="";
$m474r399=$hlavicka->m474r399;
//if ( $m474r399 == 0 ) $m474r399="";
$pdf->Cell(195,45," ","$rmc1",1,"L");
$pdf->Cell(103,5," ","$rmc1",0,"C");$pdf->Cell(25,5,"$m474r101","$rmc",0,"R");
$pdf->Cell(28,5,"$m474r201","$rmc",0,"R");$pdf->Cell(33,5,"$m474r301","$rmc",1,"R");
$pdf->Cell(103,5," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r102","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r202","$rmc",0,"R");$pdf->Cell(33,6,"$m474r302","$rmc",1,"R");
$pdf->Cell(103,5," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r103","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r203","$rmc",0,"R");$pdf->Cell(33,6,"$m474r303","$rmc",1,"R");
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r104","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r204","$rmc",0,"R");$pdf->Cell(33,6,"$m474r304","$rmc",1,"R");
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r105","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r205","$rmc",0,"R");$pdf->Cell(33,6,"$m474r305","$rmc",1,"R");
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r106","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r206","$rmc",0,"R");$pdf->Cell(33,6,"$m474r306","$rmc",1,"R");
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r107","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r207","$rmc",0,"R");$pdf->Cell(33,6,"$m474r307","$rmc",1,"R");
$pdf->Cell(103,6," ","$rmc1",0,"C");$pdf->Cell(25,6,"$m474r199","$rmc",0,"R");
$pdf->Cell(28,6,"$m474r299","$rmc",0,"R");$pdf->Cell(33,6,"$m474r399","$rmc",1,"R");
                                        }

if ( $strana == 13 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str13.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str13.jpg',0,0,210,297);
}

//modul 127
$m127r001=$hlavicka->m127r001;
$m127r002=$hlavicka->m127r002;
$m127r003=$hlavicka->m127r003;
$m127r004=$hlavicka->m127r004;
$m127r005=$hlavicka->m127r005;
$m127r006=$hlavicka->m127r006;
$m127r007=$hlavicka->m127r007;
$m127r008=$hlavicka->m127r008;
$m127r009=$hlavicka->m127r009;
$m127r010=$hlavicka->m127r010;
$m127r011=$hlavicka->m127r011;
$m127r012=$hlavicka->m127r012;
$m127r013=$hlavicka->m127r013;
$m127r014=$hlavicka->m127r014;
$m127r015=$hlavicka->m127r015;
$m127r101=$hlavicka->m127r101;
$m127r102=$hlavicka->m127r102;
$m127r103=$hlavicka->m127r103;
$m127r104=$hlavicka->m127r104;
$m127r105=$hlavicka->m127r105;
$m127r106=$hlavicka->m127r106;
$m127r107=$hlavicka->m127r107;
$m127r108=$hlavicka->m127r108;
$m127r109=$hlavicka->m127r109;
$m127r110=$hlavicka->m127r110;
$m127r111=$hlavicka->m127r111;
$m127r112=$hlavicka->m127r112;
$m127r113=$hlavicka->m127r113;
$m127r114=$hlavicka->m127r114;
$m127r115=$hlavicka->m127r115;
$m127r201=$hlavicka->m127r201; if ( $m127r201 == 0 ) $m127r201="";
$m127r202=$hlavicka->m127r202; if ( $m127r202 == 0 ) $m127r202="";
$m127r203=$hlavicka->m127r203; if ( $m127r203 == 0 ) $m127r203="";
$m127r204=$hlavicka->m127r204; if ( $m127r204 == 0 ) $m127r204="";
$m127r205=$hlavicka->m127r205; if ( $m127r205 == 0 ) $m127r205="";
$m127r206=$hlavicka->m127r206; if ( $m127r206 == 0 ) $m127r206="";
$m127r207=$hlavicka->m127r207; if ( $m127r207 == 0 ) $m127r207="";
$m127r208=$hlavicka->m127r208; if ( $m127r208 == 0 ) $m127r208="";
$m127r209=$hlavicka->m127r209; if ( $m127r209 == 0 ) $m127r209="";
$m127r210=$hlavicka->m127r210; if ( $m127r210 == 0 ) $m127r210="";
$m127r211=$hlavicka->m127r211; if ( $m127r211 == 0 ) $m127r211="";
$m127r212=$hlavicka->m127r212; if ( $m127r212 == 0 ) $m127r212="";
$m127r213=$hlavicka->m127r213; if ( $m127r213 == 0 ) $m127r213="";
$m127r214=$hlavicka->m127r214; if ( $m127r214 == 0 ) $m127r214="";
$m127r215=$hlavicka->m127r215; if ( $m127r215 == 0 ) $m127r215="";
$m127r299=$hlavicka->m127r299;
//if ( $m127r299 == 0 ) $m127r299="";
$m127r301=$hlavicka->m127r301; if ( $m127r301 == 0 ) $m127r301="";
$m127r302=$hlavicka->m127r302; if ( $m127r302 == 0 ) $m127r302="";
$m127r303=$hlavicka->m127r303; if ( $m127r303 == 0 ) $m127r303="";
$m127r304=$hlavicka->m127r304; if ( $m127r304 == 0 ) $m127r304="";
$m127r305=$hlavicka->m127r305; if ( $m127r305 == 0 ) $m127r305="";
$m127r306=$hlavicka->m127r306; if ( $m127r306 == 0 ) $m127r306="";
$m127r307=$hlavicka->m127r307; if ( $m127r307 == 0 ) $m127r307="";
$m127r308=$hlavicka->m127r308; if ( $m127r308 == 0 ) $m127r308="";
$m127r309=$hlavicka->m127r309; if ( $m127r309 == 0 ) $m127r309="";
$m127r310=$hlavicka->m127r310; if ( $m127r310 == 0 ) $m127r310="";
$m127r311=$hlavicka->m127r311; if ( $m127r311 == 0 ) $m127r311="";
$m127r312=$hlavicka->m127r312; if ( $m127r312 == 0 ) $m127r312="";
$m127r313=$hlavicka->m127r313; if ( $m127r313 == 0 ) $m127r313="";
$m127r314=$hlavicka->m127r314; if ( $m127r314 == 0 ) $m127r314="";
$m127r315=$hlavicka->m127r315; if ( $m127r315 == 0 ) $m127r315="";
$m127r399=$hlavicka->m127r399;
//if ( $m127r399 == 0 ) $m127r399="";
$m127r401=$hlavicka->m127r401; if ( $m127r401 == 0 ) $m127r401="";
$m127r402=$hlavicka->m127r402; if ( $m127r402 == 0 ) $m127r402="";
$m127r403=$hlavicka->m127r403; if ( $m127r403 == 0 ) $m127r403="";
$m127r404=$hlavicka->m127r404; if ( $m127r404 == 0 ) $m127r404="";
$m127r405=$hlavicka->m127r405; if ( $m127r405 == 0 ) $m127r405="";
$m127r406=$hlavicka->m127r406; if ( $m127r406 == 0 ) $m127r406="";
$m127r407=$hlavicka->m127r407; if ( $m127r407 == 0 ) $m127r407="";
$m127r408=$hlavicka->m127r408; if ( $m127r408 == 0 ) $m127r408="";
$m127r409=$hlavicka->m127r409; if ( $m127r409 == 0 ) $m127r409="";
$m127r410=$hlavicka->m127r410; if ( $m127r410 == 0 ) $m127r410="";
$m127r411=$hlavicka->m127r411; if ( $m127r411 == 0 ) $m127r411="";
$m127r412=$hlavicka->m127r412; if ( $m127r412 == 0 ) $m127r412="";
$m127r413=$hlavicka->m127r413; if ( $m127r413 == 0 ) $m127r413="";
$m127r414=$hlavicka->m127r414; if ( $m127r414 == 0 ) $m127r414="";
$m127r415=$hlavicka->m127r415; if ( $m127r415 == 0 ) $m127r415="";
$m127r499=$hlavicka->m127r499;
//if ( $m127r499 == 0 ) $m127r499="";
$m127r501=$hlavicka->m127r501; if ( $m127r501 == 0 ) $m127r501="";
$m127r502=$hlavicka->m127r502; if ( $m127r502 == 0 ) $m127r502="";
$m127r503=$hlavicka->m127r503; if ( $m127r503 == 0 ) $m127r503="";
$m127r504=$hlavicka->m127r504; if ( $m127r504 == 0 ) $m127r504="";
$m127r505=$hlavicka->m127r505; if ( $m127r505 == 0 ) $m127r505="";
$m127r506=$hlavicka->m127r506; if ( $m127r506 == 0 ) $m127r506="";
$m127r507=$hlavicka->m127r507; if ( $m127r507 == 0 ) $m127r507="";
$m127r508=$hlavicka->m127r508; if ( $m127r508 == 0 ) $m127r508="";
$m127r509=$hlavicka->m127r509; if ( $m127r509 == 0 ) $m127r509="";
$m127r510=$hlavicka->m127r510; if ( $m127r510 == 0 ) $m127r510="";
$m127r511=$hlavicka->m127r511; if ( $m127r511 == 0 ) $m127r511="";
$m127r512=$hlavicka->m127r512; if ( $m127r512 == 0 ) $m127r512="";
$m127r513=$hlavicka->m127r513; if ( $m127r513 == 0 ) $m127r513="";
$m127r514=$hlavicka->m127r514; if ( $m127r514 == 0 ) $m127r514="";
$m127r515=$hlavicka->m127r515; if ( $m127r515 == 0 ) $m127r515="";
$m127r599=$hlavicka->m127r599;
//if ( $m127r599 == 0 ) $m127r599="";
$m127r601=$hlavicka->m127r601; if ( $m127r601 == 0 ) $m127r601="";
$m127r602=$hlavicka->m127r602; if ( $m127r602 == 0 ) $m127r602="";
$m127r603=$hlavicka->m127r603; if ( $m127r603 == 0 ) $m127r603="";
$m127r604=$hlavicka->m127r604; if ( $m127r604 == 0 ) $m127r604="";
$m127r605=$hlavicka->m127r605; if ( $m127r605 == 0 ) $m127r605="";
$m127r606=$hlavicka->m127r606; if ( $m127r606 == 0 ) $m127r606="";
$m127r607=$hlavicka->m127r607; if ( $m127r607 == 0 ) $m127r607="";
$m127r608=$hlavicka->m127r608; if ( $m127r608 == 0 ) $m127r608="";
$m127r609=$hlavicka->m127r609; if ( $m127r609 == 0 ) $m127r609="";
$m127r610=$hlavicka->m127r610; if ( $m127r610 == 0 ) $m127r610="";
$m127r611=$hlavicka->m127r611; if ( $m127r611 == 0 ) $m127r611="";
$m127r612=$hlavicka->m127r612; if ( $m127r612 == 0 ) $m127r612="";
$m127r613=$hlavicka->m127r613; if ( $m127r613 == 0 ) $m127r613="";
$m127r614=$hlavicka->m127r614; if ( $m127r614 == 0 ) $m127r614="";
$m127r615=$hlavicka->m127r615; if ( $m127r615 == 0 ) $m127r615="";
$m127r699=$hlavicka->m127r699;
//if ( $m127r699 == 0 ) $m127r699="";
$pdf->Cell(195,67," ","$rmc1",1,"L");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r001","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r101","$rmc",0,"C");$pdf->Cell(17,6,"$m127r201","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r301","$rmc",0,"R");$pdf->Cell(20,6,"$m127r401","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r501","$rmc",0,"R");$pdf->Cell(18,6,"$m127r601","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r002","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r102","$rmc",0,"C");$pdf->Cell(17,7,"$m127r202","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r302","$rmc",0,"R");$pdf->Cell(20,7,"$m127r402","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r502","$rmc",0,"R");$pdf->Cell(18,7,"$m127r602","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r003","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r103","$rmc",0,"C");$pdf->Cell(17,6,"$m127r203","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r303","$rmc",0,"R");$pdf->Cell(20,6,"$m127r403","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r503","$rmc",0,"R");$pdf->Cell(18,6,"$m127r603","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r004","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r104","$rmc",0,"C");$pdf->Cell(17,7,"$m127r204","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r304","$rmc",0,"R");$pdf->Cell(20,7,"$m127r404","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r504","$rmc",0,"R");$pdf->Cell(18,7,"$m127r604","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r005","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r105","$rmc",0,"C");$pdf->Cell(17,7,"$m127r205","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r305","$rmc",0,"R");$pdf->Cell(20,7,"$m127r405","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r505","$rmc",0,"R");$pdf->Cell(18,7,"$m127r605","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r006","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r106","$rmc",0,"C");$pdf->Cell(17,7,"$m127r206","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r306","$rmc",0,"R");$pdf->Cell(20,7,"$m127r406","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r506","$rmc",0,"R");$pdf->Cell(18,7,"$m127r606","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r007","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r107","$rmc",0,"C");$pdf->Cell(17,6,"$m127r207","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r307","$rmc",0,"R");$pdf->Cell(20,6,"$m127r407","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r507","$rmc",0,"R");$pdf->Cell(18,6,"$m127r607","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r008","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r108","$rmc",0,"C");$pdf->Cell(17,7,"$m127r208","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r308","$rmc",0,"R");$pdf->Cell(20,7,"$m127r408","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r508","$rmc",0,"R");$pdf->Cell(18,7,"$m127r608","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r009","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r109","$rmc",0,"C");$pdf->Cell(17,6,"$m127r209","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r309","$rmc",0,"R");$pdf->Cell(20,6,"$m127r409","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r509","$rmc",0,"R");$pdf->Cell(18,6,"$m127r609","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r010","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r110","$rmc",0,"C");$pdf->Cell(17,7,"$m127r210","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r310","$rmc",0,"R");$pdf->Cell(20,7,"$m127r410","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r510","$rmc",0,"R");$pdf->Cell(18,7,"$m127r610","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r011","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r111","$rmc",0,"C");$pdf->Cell(17,6,"$m127r211","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r311","$rmc",0,"R");$pdf->Cell(20,6,"$m127r411","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r511","$rmc",0,"R");$pdf->Cell(18,6,"$m127r611","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r012","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r112","$rmc",0,"C");$pdf->Cell(17,6,"$m127r212","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r312","$rmc",0,"R");$pdf->Cell(20,6,"$m127r412","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r512","$rmc",0,"R");$pdf->Cell(18,6,"$m127r612","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r013","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r113","$rmc",0,"C");$pdf->Cell(17,7,"$m127r213","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r313","$rmc",0,"R");$pdf->Cell(20,7,"$m127r413","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r513","$rmc",0,"R");$pdf->Cell(18,7,"$m127r613","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r014","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r114","$rmc",0,"C");$pdf->Cell(17,7,"$m127r214","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r314","$rmc",0,"R");$pdf->Cell(20,7,"$m127r414","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r514","$rmc",0,"R");$pdf->Cell(18,7,"$m127r614","$rmc",1,"R");
$pdf->Cell(1,6," ","$rmc1",0,"C");
$pdf->Cell(57,6,"$m127r015","$rmc",0,"L");$pdf->Cell(8,6," ","$rmc1",0,"C");
$pdf->Cell(23,6,"$m127r115","$rmc",0,"C");$pdf->Cell(17,6,"$m127r215","$rmc",0,"R");
$pdf->Cell(20,6,"$m127r315","$rmc",0,"R");$pdf->Cell(20,6,"$m127r415","$rmc",0,"R");
$pdf->Cell(25,6,"$m127r515","$rmc",0,"R");$pdf->Cell(18,6,"$m127r615","$rmc",1,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");
$pdf->Cell(57,7,"$m127r099","$rmc",0,"L");$pdf->Cell(8,7," ","$rmc1",0,"C");
$pdf->Cell(23,7,"$m127r199","$rmc",0,"C");$pdf->Cell(17,7,"$m127r299","$rmc",0,"R");
$pdf->Cell(20,7,"$m127r399","$rmc",0,"R");$pdf->Cell(20,7,"$m127r499","$rmc",0,"R");
$pdf->Cell(25,7,"$m127r599","$rmc",0,"R");$pdf->Cell(18,7,"$m127r699","$rmc",1,"R");
                                        }

if ( $strana == 14 OR $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/statistika2014/opu201/opu201v14_str14.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/statistika2014/opu201/opu201v14_str14.jpg',0,0,210,297);
}

//modul 128
$m128r101=$hlavicka->m128r101; if ( $m128r101 == 0 ) $m128r101="";
$m128r102=$hlavicka->m128r102; if ( $m128r102 == 0 ) $m128r102="";
$m128r103=$hlavicka->m128r103; if ( $m128r103 == 0 ) $m128r103="";
$m128r104=$hlavicka->m128r104; if ( $m128r104 == 0 ) $m128r104="";
$m128r105=$hlavicka->m128r105; if ( $m128r105 == 0 ) $m128r105="";
$m128r106=$hlavicka->m128r106; if ( $m128r106 == 0 ) $m128r106="";
$m128r107=$hlavicka->m128r107; if ( $m128r107 == 0 ) $m128r107="";
$m128r108=$hlavicka->m128r108; if ( $m128r108 == 0 ) $m128r108="";
$m128r109=$hlavicka->m128r109; if ( $m128r109 == 0 ) $m128r109="";
$m128r110=$hlavicka->m128r110; if ( $m128r110 == 0 ) $m128r110="";
$m128r111=$hlavicka->m128r111; if ( $m128r111 == 0 ) $m128r111="";
$m128r199=$hlavicka->m128r199;
//if ( $m128r199 == 0 ) $m128r199="";
$m128r201=$hlavicka->m128r201; if ( $m128r201 == 0 ) $m128r201="";
$m128r202=$hlavicka->m128r202; if ( $m128r202 == 0 ) $m128r202="";
$m128r203=$hlavicka->m128r203; if ( $m128r203 == 0 ) $m128r203="";
$m128r204=$hlavicka->m128r204; if ( $m128r204 == 0 ) $m128r204="";
$m128r205=$hlavicka->m128r205; if ( $m128r205 == 0 ) $m128r205="";
$m128r206=$hlavicka->m128r206; if ( $m128r206 == 0 ) $m128r206="";
$m128r207=$hlavicka->m128r207; if ( $m128r207 == 0 ) $m128r207="";
$m128r208=$hlavicka->m128r208; if ( $m128r208 == 0 ) $m128r208="";
$m128r209=$hlavicka->m128r209; if ( $m128r209 == 0 ) $m128r209="";
$m128r210=$hlavicka->m128r210; if ( $m128r210 == 0 ) $m128r210="";
$m128r211=$hlavicka->m128r211; if ( $m128r211 == 0 ) $m128r211="";
$m128r299=$hlavicka->m128r299;
//if ( $m128r299 == 0 ) $m128r299="";
$m128r301=$hlavicka->m128r301; if ( $m128r301 == 0 ) $m128r301="";
$m128r302=$hlavicka->m128r302; if ( $m128r302 == 0 ) $m128r302="";
$m128r303=$hlavicka->m128r303; if ( $m128r303 == 0 ) $m128r303="";
$m128r304=$hlavicka->m128r304; if ( $m128r304 == 0 ) $m128r304="";
$m128r305=$hlavicka->m128r305; if ( $m128r305 == 0 ) $m128r305="";
$m128r306=$hlavicka->m128r306; if ( $m128r306 == 0 ) $m128r306="";
$m128r307=$hlavicka->m128r307; if ( $m128r307 == 0 ) $m128r307="";
$m128r308=$hlavicka->m128r308; if ( $m128r308 == 0 ) $m128r308="";
$m128r309=$hlavicka->m128r309; if ( $m128r309 == 0 ) $m128r309="";
$m128r310=$hlavicka->m128r310; if ( $m128r310 == 0 ) $m128r310="";
$m128r311=$hlavicka->m128r311; if ( $m128r311 == 0 ) $m128r311="";
$m128r399=$hlavicka->m128r399;
//if ( $m128r399 == 0 ) $m128r399="";
$m128r401=$hlavicka->m128r401; if ( $m128r401 == 0 ) $m128r401="";
$m128r402=$hlavicka->m128r402; if ( $m128r402 == 0 ) $m128r402="";
$m128r403=$hlavicka->m128r403; if ( $m128r403 == 0 ) $m128r403="";
$m128r404=$hlavicka->m128r404; if ( $m128r404 == 0 ) $m128r404="";
$m128r405=$hlavicka->m128r405; if ( $m128r405 == 0 ) $m128r405="";
$m128r406=$hlavicka->m128r406; if ( $m128r406 == 0 ) $m128r406="";
$m128r407=$hlavicka->m128r407; if ( $m128r407 == 0 ) $m128r407="";
$m128r408=$hlavicka->m128r408; if ( $m128r408 == 0 ) $m128r408="";
$m128r409=$hlavicka->m128r409; if ( $m128r409 == 0 ) $m128r409="";
$m128r410=$hlavicka->m128r410; if ( $m128r410 == 0 ) $m128r410="";
$m128r411=$hlavicka->m128r411; if ( $m128r411 == 0 ) $m128r411="";
$m128r499=$hlavicka->m128r499;
//if ( $m128r499 == 0 ) $m128r499="";
$m128r501=$hlavicka->m128r501; if ( $m128r501 == 0 ) $m128r501="";
$m128r502=$hlavicka->m128r502; if ( $m128r502 == 0 ) $m128r502="";
$m128r503=$hlavicka->m128r503; if ( $m128r503 == 0 ) $m128r503="";
$m128r504=$hlavicka->m128r504; if ( $m128r504 == 0 ) $m128r504="";
$m128r505=$hlavicka->m128r505; if ( $m128r505 == 0 ) $m128r505="";
$m128r506=$hlavicka->m128r506; if ( $m128r506 == 0 ) $m128r506="";
$m128r507=$hlavicka->m128r507; if ( $m128r507 == 0 ) $m128r507="";
$m128r508=$hlavicka->m128r508; if ( $m128r508 == 0 ) $m128r508="";
$m128r509=$hlavicka->m128r509; if ( $m128r509 == 0 ) $m128r509="";
$m128r510=$hlavicka->m128r510; if ( $m128r510 == 0 ) $m128r510="";
$m128r511=$hlavicka->m128r511; if ( $m128r511 == 0 ) $m128r511="";
$m128r599=$hlavicka->m128r599;
//if ( $m128r599 == 0 ) $m128r599="";
$pdf->Cell(195,51," ","$rmc1",1,"L");
$pdf->Cell(84,5," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r101","$rmc",0,"R");$pdf->Cell(20,6,"$m128r201","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r301","$rmc",0,"R");$pdf->Cell(25,6,"$m128r401","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r501","$rmc",1,"R");
$pdf->Cell(84,6," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r102","$rmc",0,"R");$pdf->Cell(20,6,"$m128r202","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r302","$rmc",0,"R");$pdf->Cell(25,6,"$m128r402","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r502","$rmc",1,"R");
$pdf->Cell(84,9," ","$rmc1",0,"C");
$pdf->Cell(22,9,"$m128r103","$rmc",0,"R");$pdf->Cell(20,9,"$m128r203","$rmc",0,"R");
$pdf->Cell(20,9,"$m128r303","$rmc",0,"R");$pdf->Cell(25,9,"$m128r403","$rmc",0,"R");
$pdf->Cell(18,9,"$m128r503","$rmc",1,"R");
$pdf->Cell(84,6," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r104","$rmc",0,"R");$pdf->Cell(20,6,"$m128r204","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r304","$rmc",0,"R");$pdf->Cell(25,6,"$m128r404","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r504","$rmc",1,"R");
$pdf->Cell(84,9," ","$rmc1",0,"C");
$pdf->Cell(22,9,"$m128r105","$rmc",0,"R");$pdf->Cell(20,9,"$m128r205","$rmc",0,"R");
$pdf->Cell(20,9,"$m128r305","$rmc",0,"R");$pdf->Cell(25,9,"$m128r405","$rmc",0,"R");
$pdf->Cell(18,9,"$m128r505","$rmc",1,"R");
$pdf->Cell(84,6," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r106","$rmc",0,"R");$pdf->Cell(20,6,"$m128r206","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r306","$rmc",0,"R");$pdf->Cell(25,6,"$m128r406","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r506","$rmc",1,"R");
$pdf->Cell(84,9," ","$rmc1",0,"C");
$pdf->Cell(22,9,"$m128r107","$rmc",0,"R");$pdf->Cell(20,9,"$m128r207","$rmc",0,"R");
$pdf->Cell(20,9,"$m128r307","$rmc",0,"R");$pdf->Cell(25,9,"$m128r407","$rmc",0,"R");
$pdf->Cell(18,9,"$m128r507","$rmc",1,"R");
$pdf->Cell(84,6," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r108","$rmc",0,"R");$pdf->Cell(20,6,"$m128r208","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r308","$rmc",0,"R");$pdf->Cell(25,6,"$m128r408","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r508","$rmc",1,"R");
$pdf->Cell(84,6," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r109","$rmc",0,"R");$pdf->Cell(20,6,"$m128r209","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r309","$rmc",0,"R");$pdf->Cell(25,6,"$m128r409","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r509","$rmc",1,"R");
$pdf->Cell(84,7," ","$rmc1",0,"C");
$pdf->Cell(22,7,"$m128r110","$rmc",0,"R");$pdf->Cell(20,7,"$m128r210","$rmc",0,"R");
$pdf->Cell(20,7,"$m128r310","$rmc",0,"R");$pdf->Cell(25,7,"$m128r410","$rmc",0,"R");
$pdf->Cell(18,7,"$m128r510","$rmc",1,"R");
$pdf->Cell(84,6," ","$rmc1",0,"C");
$pdf->Cell(22,6,"$m128r111","$rmc",0,"R");$pdf->Cell(20,6,"$m128r211","$rmc",0,"R");
$pdf->Cell(20,6,"$m128r311","$rmc",0,"R");$pdf->Cell(25,6,"$m128r411","$rmc",0,"R");
$pdf->Cell(18,6,"$m128r511","$rmc",1,"R");
$pdf->Cell(84,7," ","$rmc1",0,"C");
$pdf->Cell(22,7,"$m128r199","$rmc",0,"R");$pdf->Cell(20,7,"$m128r299","$rmc",0,"R");
$pdf->Cell(20,7,"$m128r399","$rmc",0,"R");$pdf->Cell(25,7,"$m128r499","$rmc",0,"R");
$pdf->Cell(18,7,"$m128r599","$rmc",1,"R");
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