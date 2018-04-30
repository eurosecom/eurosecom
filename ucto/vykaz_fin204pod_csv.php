<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

//od 1.1.2018 nová štruktúra CSV FIN 204

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];


$fir_ficox=$fir_fico;
if( $fir_fico < 100000 ) $fir_ficox="00".$fir_fico;
$mesiac="03";
$typorg="31";
$cislo_oc=1;

$cislo_oc = 1*$_REQUEST['cislo_oc'];
if( $cislo_oc == 1 ) { $mesiac="01"; }
if( $cislo_oc == 2 ) { $mesiac="02"; }
if( $cislo_oc == 3 ) { $mesiac="03"; }
if( $cislo_oc == 4 ) { $mesiac="04"; }
if( $cislo_oc == 5 ) { $mesiac="05"; }
if( $cislo_oc == 6 ) { $mesiac="06"; }
if( $cislo_oc == 7 ) { $mesiac="07"; }
if( $cislo_oc == 8 ) { $mesiac="08"; }
if( $cislo_oc == 9 ) { $mesiac="09"; }
if( $cislo_oc == 10 ) { $mesiac="10"; }
if( $cislo_oc == 11 ) { $mesiac="11"; }
if( $cislo_oc == 12 ) { $mesiac="12"; }

if( $fir_fico == 44551142 )
{
$fir_ficox="00310000";
$typorg="22";
}

$dat_bez = Date ("Ymdhi", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$fico8=$fir_fico;
if( $fico8 < 999999 ) { $fico8="00".$fico8; }
$rokmes=$kli_vmes.$kli_vrok;

//nazov
$nazsub="FIN2_".$dat_bez.".csv";

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }


//////////////////////////////////////////////////////////// FIN 204



//urob csv
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$kli_vxr=substr($kli_vrok,2,2);;
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

$dat_bez = Date ("Ymdhi", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$fico8=$fir_fico;
if( $fico8 < 999999 ) { $fico8="00".$fico8; }
$rokmes=$kli_vmes.$kli_vrok;

$soubor = fopen("../tmp/$nazsub", "a+");

$dotaz = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204pod WHERE F$kli_vxcf"."_uctvykaz_fin204pod.oc = $cislo_oc  ORDER BY oc";

$sql = mysql_query("$dotaz");
$pol = mysql_num_rows($sql);
//exit;


$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


//hlavicka aktiva

  $text = "\r\n";
  fwrite($soubor, $text);

  $text = "\"hlavicka,1\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"ico\","."\"rok\","."\"mesiac\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"".$fico8."\","."\"".$kli_vrok."\","."\"".$kli_vmes."\""."\r\n";
  fwrite($soubor, $text);

  $text = "\r\n";
  fwrite($soubor, $text);

  $text = "\"aktiva,68\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"R\","."\"S1\","."\"S2\","."\"S3\","."\"S4\""."\r\n";
  fwrite($soubor, $text);


//polozky aktiva


  $text = "\"R1\",\"".$hlavicka->r01."\",\"".$hlavicka->rk01."\",\"".$hlavicka->rn01."\",\"".$hlavicka->rm01."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R2\",\"".$hlavicka->r02."\",\"".$hlavicka->rk02."\",\"".$hlavicka->rn02."\",\"".$hlavicka->rm02."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R3\",\"".$hlavicka->r03."\",\"".$hlavicka->rk03."\",\"".$hlavicka->rn03."\",\"".$hlavicka->rm03."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R4\",\"".$hlavicka->r04."\",\"".$hlavicka->rk04."\",\"".$hlavicka->rn04."\",\"".$hlavicka->rm04."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R5\",\"".$hlavicka->r05."\",\"".$hlavicka->rk05."\",\"".$hlavicka->rn05."\",\"".$hlavicka->rm05."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R6\",\"".$hlavicka->r06."\",\"".$hlavicka->rk06."\",\"".$hlavicka->rn06."\",\"".$hlavicka->rm06."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R7\",\"".$hlavicka->r07."\",\"".$hlavicka->rk07."\",\"".$hlavicka->rn07."\",\"".$hlavicka->rm07."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R8\",\"".$hlavicka->r08."\",\"".$hlavicka->rk08."\",\"".$hlavicka->rn08."\",\"".$hlavicka->rm08."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R9\",\"".$hlavicka->r09."\",\"".$hlavicka->rk09."\",\"".$hlavicka->rn09."\",\"".$hlavicka->rm09."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R10\",\"".$hlavicka->r10."\",\"".$hlavicka->rk10."\",\"".$hlavicka->rn10."\",\"".$hlavicka->rm10."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R11\",\"".$hlavicka->r11."\",\"".$hlavicka->rk11."\",\"".$hlavicka->rn11."\",\"".$hlavicka->rm11."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R12\",\"".$hlavicka->r12."\",\"".$hlavicka->rk12."\",\"".$hlavicka->rn12."\",\"".$hlavicka->rm12."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R13\",\"".$hlavicka->r13."\",\"".$hlavicka->rk13."\",\"".$hlavicka->rn13."\",\"".$hlavicka->rm13."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R14\",\"".$hlavicka->r14."\",\"".$hlavicka->rk14."\",\"".$hlavicka->rn14."\",\"".$hlavicka->rm14."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R15\",\"".$hlavicka->r15."\",\"".$hlavicka->rk15."\",\"".$hlavicka->rn15."\",\"".$hlavicka->rm15."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R16\",\"".$hlavicka->r16."\",\"".$hlavicka->rk16."\",\"".$hlavicka->rn16."\",\"".$hlavicka->rm16."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R17\",\"".$hlavicka->r17."\",\"".$hlavicka->rk17."\",\"".$hlavicka->rn17."\",\"".$hlavicka->rm17."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R18\",\"".$hlavicka->r18."\",\"".$hlavicka->rk18."\",\"".$hlavicka->rn18."\",\"".$hlavicka->rm18."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R19\",\"".$hlavicka->r19."\",\"".$hlavicka->rk19."\",\"".$hlavicka->rn19."\",\"".$hlavicka->rm19."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R20\",\"".$hlavicka->r20."\",\"".$hlavicka->rk20."\",\"".$hlavicka->rn20."\",\"".$hlavicka->rm20."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R21\",\"".$hlavicka->r21."\",\"".$hlavicka->rk21."\",\"".$hlavicka->rn21."\",\"".$hlavicka->rm21."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R22\",\"".$hlavicka->r22."\",\"".$hlavicka->rk22."\",\"".$hlavicka->rn22."\",\"".$hlavicka->rm22."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R23\",\"".$hlavicka->r23."\",\"".$hlavicka->rk23."\",\"".$hlavicka->rn23."\",\"".$hlavicka->rm23."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R24\",\"".$hlavicka->r24."\",\"".$hlavicka->rk24."\",\"".$hlavicka->rn24."\",\"".$hlavicka->rm24."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R25\",\"".$hlavicka->r25."\",\"".$hlavicka->rk25."\",\"".$hlavicka->rn25."\",\"".$hlavicka->rm25."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R26\",\"".$hlavicka->r26."\",\"".$hlavicka->rk26."\",\"".$hlavicka->rn26."\",\"".$hlavicka->rm26."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R27\",\"".$hlavicka->r27."\",\"".$hlavicka->rk27."\",\"".$hlavicka->rn27."\",\"".$hlavicka->rm27."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R28\",\"".$hlavicka->r28."\",\"".$hlavicka->rk28."\",\"".$hlavicka->rn28."\",\"".$hlavicka->rm28."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R29\",\"".$hlavicka->r29."\",\"".$hlavicka->rk29."\",\"".$hlavicka->rn29."\",\"".$hlavicka->rm29."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R30\",\"".$hlavicka->r30."\",\"".$hlavicka->rk30."\",\"".$hlavicka->rn30."\",\"".$hlavicka->rm30."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R31\",\"".$hlavicka->r31."\",\"".$hlavicka->rk31."\",\"".$hlavicka->rn31."\",\"".$hlavicka->rm31."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R32\",\"".$hlavicka->r32."\",\"".$hlavicka->rk32."\",\"".$hlavicka->rn32."\",\"".$hlavicka->rm32."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R33\",\"".$hlavicka->r33."\",\"".$hlavicka->rk33."\",\"".$hlavicka->rn33."\",\"".$hlavicka->rm33."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R34\",\"".$hlavicka->r34."\",\"".$hlavicka->rk34."\",\"".$hlavicka->rn34."\",\"".$hlavicka->rm34."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R35\",\"".$hlavicka->r35."\",\"".$hlavicka->rk35."\",\"".$hlavicka->rn35."\",\"".$hlavicka->rm35."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R36\",\"".$hlavicka->r36."\",\"".$hlavicka->rk36."\",\"".$hlavicka->rn36."\",\"".$hlavicka->rm36."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R37\",\"".$hlavicka->r37."\",\"".$hlavicka->rk37."\",\"".$hlavicka->rn37."\",\"".$hlavicka->rm37."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R38\",\"".$hlavicka->r38."\",\"".$hlavicka->rk38."\",\"".$hlavicka->rn38."\",\"".$hlavicka->rm38."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R39\",\"".$hlavicka->r39."\",\"".$hlavicka->rk39."\",\"".$hlavicka->rn39."\",\"".$hlavicka->rm39."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R40\",\"".$hlavicka->r40."\",\"".$hlavicka->rk40."\",\"".$hlavicka->rn40."\",\"".$hlavicka->rm40."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R41\",\"".$hlavicka->r41."\",\"".$hlavicka->rk41."\",\"".$hlavicka->rn41."\",\"".$hlavicka->rm41."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R42\",\"".$hlavicka->r42."\",\"".$hlavicka->rk42."\",\"".$hlavicka->rn42."\",\"".$hlavicka->rm42."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R43\",\"".$hlavicka->r43."\",\"".$hlavicka->rk43."\",\"".$hlavicka->rn43."\",\"".$hlavicka->rm43."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R44\",\"".$hlavicka->r44."\",\"".$hlavicka->rk44."\",\"".$hlavicka->rn44."\",\"".$hlavicka->rm44."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R45\",\"".$hlavicka->r45."\",\"".$hlavicka->rk45."\",\"".$hlavicka->rn45."\",\"".$hlavicka->rm45."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R46\",\"".$hlavicka->r46."\",\"".$hlavicka->rk46."\",\"".$hlavicka->rn46."\",\"".$hlavicka->rm46."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R47\",\"".$hlavicka->r47."\",\"".$hlavicka->rk47."\",\"".$hlavicka->rn47."\",\"".$hlavicka->rm47."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R48\",\"".$hlavicka->r48."\",\"".$hlavicka->rk48."\",\"".$hlavicka->rn48."\",\"".$hlavicka->rm48."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R49\",\"".$hlavicka->r49."\",\"".$hlavicka->rk49."\",\"".$hlavicka->rn49."\",\"".$hlavicka->rm49."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R50\",\"".$hlavicka->r50."\",\"".$hlavicka->rk50."\",\"".$hlavicka->rn50."\",\"".$hlavicka->rm50."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R51\",\"".$hlavicka->r51."\",\"".$hlavicka->rk51."\",\"".$hlavicka->rn51."\",\"".$hlavicka->rm51."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R52\",\"".$hlavicka->r52."\",\"".$hlavicka->rk52."\",\"".$hlavicka->rn52."\",\"".$hlavicka->rm52."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R53\",\"".$hlavicka->r53."\",\"".$hlavicka->rk53."\",\"".$hlavicka->rn53."\",\"".$hlavicka->rm53."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R54\",\"".$hlavicka->r54."\",\"".$hlavicka->rk54."\",\"".$hlavicka->rn54."\",\"".$hlavicka->rm54."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R55\",\"".$hlavicka->r55."\",\"".$hlavicka->rk55."\",\"".$hlavicka->rn55."\",\"".$hlavicka->rm55."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R56\",\"".$hlavicka->r56."\",\"".$hlavicka->rk56."\",\"".$hlavicka->rn56."\",\"".$hlavicka->rm56."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R57\",\"".$hlavicka->r57."\",\"".$hlavicka->rk57."\",\"".$hlavicka->rn57."\",\"".$hlavicka->rm57."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R58\",\"".$hlavicka->r58."\",\"".$hlavicka->rk58."\",\"".$hlavicka->rn58."\",\"".$hlavicka->rm58."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R59\",\"".$hlavicka->r59."\",\"".$hlavicka->rk59."\",\"".$hlavicka->rn59."\",\"".$hlavicka->rm59."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R60\",\"".$hlavicka->r60."\",\"".$hlavicka->rk60."\",\"".$hlavicka->rn60."\",\"".$hlavicka->rm60."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R61\",\"".$hlavicka->r61."\",\"".$hlavicka->rk61."\",\"".$hlavicka->rn61."\",\"".$hlavicka->rm61."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R62\",\"".$hlavicka->r62."\",\"".$hlavicka->rk62."\",\"".$hlavicka->rn62."\",\"".$hlavicka->rm62."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R63\",\"".$hlavicka->r63."\",\"".$hlavicka->rk63."\",\"".$hlavicka->rn63."\",\"".$hlavicka->rm63."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R64\",\"".$hlavicka->r64."\",\"".$hlavicka->rk64."\",\"".$hlavicka->rn64."\",\"".$hlavicka->rm64."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R65\",\"".$hlavicka->r65."\",\"".$hlavicka->rk65."\",\"".$hlavicka->rn65."\",\"".$hlavicka->rm65."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R66\",\"".$hlavicka->r66."\",\"".$hlavicka->rk66."\",\"".$hlavicka->rn66."\",\"".$hlavicka->rm66."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R67\",\"".$hlavicka->r67."\",\"".$hlavicka->rk67."\",\"".$hlavicka->rn67."\",\"".$hlavicka->rm67."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R68\",\"".$hlavicka->r68."\",\"".$hlavicka->rk68."\",\"".$hlavicka->rn68."\",\"".$hlavicka->rm68."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);



//hlavicka pasiva



  $text = "\r\n";
  fwrite($soubor, $text);

  $text = "\"pasiva,63\""."\r\n";
  fwrite($soubor, $text);

  $text = "\"R\","."\"S5\","."\"S6\""."\r\n";
  fwrite($soubor, $text);


//polozky pasiva


  $text = "\"R69\",\"".$hlavicka->r69."\",\"".$hlavicka->rm69."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R70\",\"".$hlavicka->r70."\",\"".$hlavicka->rm70."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R71\",\"".$hlavicka->r71."\",\"".$hlavicka->rm71."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R72\",\"".$hlavicka->r72."\",\"".$hlavicka->rm72."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R73\",\"".$hlavicka->r73."\",\"".$hlavicka->rm73."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R74\",\"".$hlavicka->r74."\",\"".$hlavicka->rm74."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R75\",\"".$hlavicka->r75."\",\"".$hlavicka->rm75."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R76\",\"".$hlavicka->r76."\",\"".$hlavicka->rm76."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R77\",\"".$hlavicka->r77."\",\"".$hlavicka->rm77."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R78\",\"".$hlavicka->r78."\",\"".$hlavicka->rm78."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R79\",\"".$hlavicka->r79."\",\"".$hlavicka->rm79."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R80\",\"".$hlavicka->r80."\",\"".$hlavicka->rm80."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R81\",\"".$hlavicka->r81."\",\"".$hlavicka->rm81."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R82\",\"".$hlavicka->r82."\",\"".$hlavicka->rm82."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R83\",\"".$hlavicka->r83."\",\"".$hlavicka->rm83."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R84\",\"".$hlavicka->r84."\",\"".$hlavicka->rm84."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R85\",\"".$hlavicka->r85."\",\"".$hlavicka->rm85."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R86\",\"".$hlavicka->r86."\",\"".$hlavicka->rm86."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R87\",\"".$hlavicka->r87."\",\"".$hlavicka->rm87."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R88\",\"".$hlavicka->r88."\",\"".$hlavicka->rm88."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R89\",\"".$hlavicka->r89."\",\"".$hlavicka->rm89."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R90\",\"".$hlavicka->r90."\",\"".$hlavicka->rm90."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R91\",\"".$hlavicka->r91."\",\"".$hlavicka->rm91."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R92\",\"".$hlavicka->r92."\",\"".$hlavicka->rm92."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R93\",\"".$hlavicka->r93."\",\"".$hlavicka->rm93."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R94\",\"".$hlavicka->r94."\",\"".$hlavicka->rm94."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R95\",\"".$hlavicka->r95."\",\"".$hlavicka->rm95."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R96\",\"".$hlavicka->r96."\",\"".$hlavicka->rm96."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R97\",\"".$hlavicka->r97."\",\"".$hlavicka->rm97."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R98\",\"".$hlavicka->r98."\",\"".$hlavicka->rm98."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R99\",\"".$hlavicka->r99."\",\"".$hlavicka->rm99."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R100\",\"".$hlavicka->r100."\",\"".$hlavicka->rm100."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R101\",\"".$hlavicka->r101."\",\"".$hlavicka->rm101."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R102\",\"".$hlavicka->r102."\",\"".$hlavicka->rm102."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R103\",\"".$hlavicka->r103."\",\"".$hlavicka->rm103."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R104\",\"".$hlavicka->r104."\",\"".$hlavicka->rm104."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R105\",\"".$hlavicka->r105."\",\"".$hlavicka->rm105."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R106\",\"".$hlavicka->r106."\",\"".$hlavicka->rm106."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R107\",\"".$hlavicka->r107."\",\"".$hlavicka->rm107."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R108\",\"".$hlavicka->r108."\",\"".$hlavicka->rm108."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R109\",\"".$hlavicka->r109."\",\"".$hlavicka->rm109."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R110\",\"".$hlavicka->r110."\",\"".$hlavicka->rm110."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R111\",\"".$hlavicka->r111."\",\"".$hlavicka->rm111."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R112\",\"".$hlavicka->r112."\",\"".$hlavicka->rm112."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R113\",\"".$hlavicka->r113."\",\"".$hlavicka->rm113."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R114\",\"".$hlavicka->r114."\",\"".$hlavicka->rm114."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R115\",\"".$hlavicka->r115."\",\"".$hlavicka->rm115."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R116\",\"".$hlavicka->r116."\",\"".$hlavicka->rm116."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R117\",\"".$hlavicka->r117."\",\"".$hlavicka->rm117."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R118\",\"".$hlavicka->r118."\",\"".$hlavicka->rm118."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R119\",\"".$hlavicka->r119."\",\"".$hlavicka->rm119."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);

  $text = "\"R120\",\"".$hlavicka->r120."\",\"".$hlavicka->rm120."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R121\",\"".$hlavicka->r121."\",\"".$hlavicka->rm121."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R122\",\"".$hlavicka->r122."\",\"".$hlavicka->rm122."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R123\",\"".$hlavicka->r123."\",\"".$hlavicka->rm123."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R124\",\"".$hlavicka->r124."\",\"".$hlavicka->rm124."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R125\",\"".$hlavicka->r125."\",\"".$hlavicka->rm125."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R126\",\"".$hlavicka->r126."\",\"".$hlavicka->rm126."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R127\",\"".$hlavicka->r127."\",\"".$hlavicka->rm127."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R128\",\"".$hlavicka->r128."\",\"".$hlavicka->rm128."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R129\",\"".$hlavicka->r129."\",\"".$hlavicka->rm129."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R130\",\"".$hlavicka->r130."\",\"".$hlavicka->rm130."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);
  $text = "\"R131\",\"".$hlavicka->r131."\",\"".$hlavicka->rm131."\"";
  $text = $text."\r\n";
  fwrite($soubor, $text);




}
$i = $i + 1;
  }





fclose($soubor);
////////////////////////////////////////////////////////////KONIEC FIN 204pod


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>CSV</title>
  <style type="text/css">
  </style>
<script type="text/javascript">   
</script>
</HEAD>
<BODY class="white">


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FIN 2-04 CSV súbor FIN2.csv</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if( $copern == 1 )
{
?>
<br />
<br />
Stiahnite si nižšie uvedený súbor na Váš lokálny disk a uložte ho s názvom FIN2.csv :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>"><?php echo $nazsub; ?></a>
<br />
<br />
<?php
}
?>




<br /><br />
<?php
// celkovy koniec dokumentu



       } while (false);
?>
</BODY>
</HTML>
