<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//ramcek fpdf 1=zap,0=vyp
$rmc=0;

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if (File_Exists ("../tmp/uzavierka.$kli_uzid.pdf")) { $soubor = unlink("../tmp/uzavierka.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvahano_stl".
" ON F$kli_vxcf"."_prcsuvahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvahano_stl.fic".
" WHERE prx = 1 ".""; 


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//V MUJ 2014 POUZIVAME LEN STLPCE rn01 az rn45 a rm01 az rm45


$r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01='';
$rk01=$hlavicka->rk01; if ( $hlavicka->rk01 == 0 ) $rk01='';
$rn01=$hlavicka->rn01; if ( $hlavicka->rn01 == 0 ) $rn01='';
$rm01=$hlavicka->rm01; if ( $hlavicka->rm01 == 0 ) $rm01='';
$r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02='';
$rk02=$hlavicka->rk02; if ( $hlavicka->rk02 == 0 ) $rk02='';
$rn02=$hlavicka->rn02; if ( $hlavicka->rn02 == 0 ) $rn02='';
$rm02=$hlavicka->rm02; if ( $hlavicka->rm02 == 0 ) $rm02='';
$r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03='';
$rk03=$hlavicka->rk03; if ( $hlavicka->rk03 == 0 ) $rk03='';
$rn03=$hlavicka->rn03; if ( $hlavicka->rn03 == 0 ) $rn03='';
$rm03=$hlavicka->rm03; if ( $hlavicka->rm03 == 0 ) $rm03='';
$r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $r04='';
$rk04=$hlavicka->rk04; if ( $hlavicka->rk04 == 0 ) $rk04='';
$rn04=$hlavicka->rn04; if ( $hlavicka->rn04 == 0 ) $rn04='';
$rm04=$hlavicka->rm04; if ( $hlavicka->rm04 == 0 ) $rm04='';
$r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05='';
$rk05=$hlavicka->rk05; if ( $hlavicka->rk05 == 0 ) $rk05='';
$rn05=$hlavicka->rn05; if ( $hlavicka->rn05 == 0 ) $rn05='';
$rm05=$hlavicka->rm05; if ( $hlavicka->rm05 == 0 ) $rm05='';
$r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06='';
$rk06=$hlavicka->rk06; if ( $hlavicka->rk06 == 0 ) $rk06='';
$rn06=$hlavicka->rn06; if ( $hlavicka->rn06 == 0 ) $rn06='';
$rm06=$hlavicka->rm06; if ( $hlavicka->rm06 == 0 ) $rm06='';
$r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07='';
$rk07=$hlavicka->rk07; if ( $hlavicka->rk07 == 0 ) $rk07='';
$rn07=$hlavicka->rn07; if ( $hlavicka->rn07 == 0 ) $rn07='';
$rm07=$hlavicka->rm07; if ( $hlavicka->rm07 == 0 ) $rm07='';
$r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08='';
$rk08=$hlavicka->rk08; if ( $hlavicka->rk08 == 0 ) $rk08='';
$rn08=$hlavicka->rn08; if ( $hlavicka->rn08 == 0 ) $rn08='';
$rm08=$hlavicka->rm08; if ( $hlavicka->rm08 == 0 ) $rm08='';
$r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09='';
$rk09=$hlavicka->rk09; if ( $hlavicka->rk09 == 0 ) $rk09='';
$rn09=$hlavicka->rn09; if ( $hlavicka->rn09 == 0 ) $rn09='';
$rm09=$hlavicka->rm09; if ( $hlavicka->rm09 == 0 ) $rm09='';
$r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10='';
$rk10=$hlavicka->rk10; if ( $hlavicka->rk10 == 0 ) $rk10='';
$rn10=$hlavicka->rn10; if ( $hlavicka->rn10 == 0 ) $rn10='';
$rm10=$hlavicka->rm10; if ( $hlavicka->rm10 == 0 ) $rm10='';
$r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11='';
$rk11=$hlavicka->rk11; if ( $hlavicka->rk11 == 0 ) $rk11='';
$rn11=$hlavicka->rn11; if ( $hlavicka->rn11 == 0 ) $rn11='';
$rm11=$hlavicka->rm11; if ( $hlavicka->rm11 == 0 ) $rm11='';
$r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12='';
$rk12=$hlavicka->rk12; if ( $hlavicka->rk12 == 0 ) $rk12='';
$rn12=$hlavicka->rn12; if ( $hlavicka->rn12 == 0 ) $rn12='';
$rm12=$hlavicka->rm12; if ( $hlavicka->rm12 == 0 ) $rm12='';
$r13=$hlavicka->r13; if ( $hlavicka->r13 == 0 ) $r13='';
$rk13=$hlavicka->rk13; if ( $hlavicka->rk13 == 0 ) $rk13='';
$rn13=$hlavicka->rn13; if ( $hlavicka->rn13 == 0 ) $rn13='';
$rm13=$hlavicka->rm13; if ( $hlavicka->rm13 == 0 ) $rm13='';
$r14=$hlavicka->r14; if ( $hlavicka->r14 == 0 ) $r14='';
$rk14=$hlavicka->rk14; if ( $hlavicka->rk14 == 0 ) $rk14='';
$rn14=$hlavicka->rn14; if ( $hlavicka->rn14 == 0 ) $rn14='';
$rm14=$hlavicka->rm14; if ( $hlavicka->rm14 == 0 ) $rm14='';
$r15=$hlavicka->r15; if ( $hlavicka->r15 == 0 ) $r15='';
$rk15=$hlavicka->rk15; if ( $hlavicka->rk15 == 0 ) $rk15='';
$rn15=$hlavicka->rn15; if ( $hlavicka->rn15 == 0 ) $rn15='';
$rm15=$hlavicka->rm15; if ( $hlavicka->rm15 == 0 ) $rm15='';
$r16=$hlavicka->r16; if ( $hlavicka->r16 == 0 ) $r16='';
$rk16=$hlavicka->rk16; if ( $hlavicka->rk16 == 0 ) $rk16='';
$rn16=$hlavicka->rn16; if ( $hlavicka->rn16 == 0 ) $rn16='';
$rm16=$hlavicka->rm16; if ( $hlavicka->rm16 == 0 ) $rm16='';
$r17=$hlavicka->r17; if ( $hlavicka->r17 == 0 ) $r17='';
$rk17=$hlavicka->rk17; if ( $hlavicka->rk17 == 0 ) $rk17='';
$rn17=$hlavicka->rn17; if ( $hlavicka->rn17 == 0 ) $rn17='';
$rm17=$hlavicka->rm17; if ( $hlavicka->rm17 == 0 ) $rm17='';
$r18=$hlavicka->r18; if ( $hlavicka->r18 == 0 ) $r18='';
$rk18=$hlavicka->rk18; if ( $hlavicka->rk18 == 0 ) $rk18='';
$rn18=$hlavicka->rn18; if ( $hlavicka->rn18 == 0 ) $rn18='';
$rm18=$hlavicka->rm18; if ( $hlavicka->rm18 == 0 ) $rm18='';
$r19=$hlavicka->r19; if ( $hlavicka->r19 == 0 ) $r19='';
$rk19=$hlavicka->rk19; if ( $hlavicka->rk19 == 0 ) $rk19='';
$rn19=$hlavicka->rn19; if ( $hlavicka->rn19 == 0 ) $rn19='';
$rm19=$hlavicka->rm19; if ( $hlavicka->rm19 == 0 ) $rm19='';
$r20=$hlavicka->r20; if ( $hlavicka->r20 == 0 ) $r20='';
$rk20=$hlavicka->rk20; if ( $hlavicka->rk20 == 0 ) $rk20='';
$rn20=$hlavicka->rn20; if ( $hlavicka->rn20 == 0 ) $rn20='';
$rm20=$hlavicka->rm20; if ( $hlavicka->rm20 == 0 ) $rm20='';
$r21=$hlavicka->r21; if ( $hlavicka->r21 == 0 ) $r21='';
$rk21=$hlavicka->rk21; if ( $hlavicka->rk21 == 0 ) $rk21='';
$rn21=$hlavicka->rn21; if ( $hlavicka->rn21 == 0 ) $rn21='';
$rm21=$hlavicka->rm21; if ( $hlavicka->rm21 == 0 ) $rm21='';
$r22=$hlavicka->r22; if ( $hlavicka->r22 == 0 ) $r22='';
$rk22=$hlavicka->rk22; if ( $hlavicka->rk22 == 0 ) $rk22='';
$rn22=$hlavicka->rn22; if ( $hlavicka->rn22 == 0 ) $rn22='';
$rm22=$hlavicka->rm22; if ( $hlavicka->rm22 == 0 ) $rm22='';
$r23=$hlavicka->r23; if ( $hlavicka->r23 == 0 ) $r23='';
$rk23=$hlavicka->rk23; if ( $hlavicka->rk23 == 0 ) $rk23='';
$rn23=$hlavicka->rn23; if ( $hlavicka->rn23 == 0 ) $rn23='';
$rm23=$hlavicka->rm23; if ( $hlavicka->rm23 == 0 ) $rm23='';
$r24=$hlavicka->r24; if ( $hlavicka->r24 == 0 ) $r24='';
$rk24=$hlavicka->rk24; if ( $hlavicka->rk24 == 0 ) $rk24='';
$rn24=$hlavicka->rn24; if ( $hlavicka->rn24 == 0 ) $rn24='';
$rm24=$hlavicka->rm24; if ( $hlavicka->rm24 == 0 ) $rm24='';
$r25=$hlavicka->r25; if ( $hlavicka->r25 == 0 ) $r25='';
$rk25=$hlavicka->rk25; if ( $hlavicka->rk25 == 0 ) $rk25='';
$rn25=$hlavicka->rn25; if ( $hlavicka->rn25 == 0 ) $rn25='';
$rm25=$hlavicka->rm25; if ( $hlavicka->rm25 == 0 ) $rm25='';
$r26=$hlavicka->r26; if ( $hlavicka->r26 == 0 ) $r26='';
$rk26=$hlavicka->rk26; if ( $hlavicka->rk26 == 0 ) $rk26='';
$rn26=$hlavicka->rn26; if ( $hlavicka->rn26 == 0 ) $rn26='';
$rm26=$hlavicka->rm26; if ( $hlavicka->rm26 == 0 ) $rm26='';
$r27=$hlavicka->r27; if ( $hlavicka->r27 == 0 ) $r27='';
$rk27=$hlavicka->rk27; if ( $hlavicka->rk27 == 0 ) $rk27='';
$rn27=$hlavicka->rn27; if ( $hlavicka->rn27 == 0 ) $rn27='';
$rm27=$hlavicka->rm27; if ( $hlavicka->rm27 == 0 ) $rm27='';
$r28=$hlavicka->r28; if ( $hlavicka->r28 == 0 ) $r28='';
$rk28=$hlavicka->rk28; if ( $hlavicka->rk28 == 0 ) $rk28='';
$rn28=$hlavicka->rn28; if ( $hlavicka->rn28 == 0 ) $rn28='';
$rm28=$hlavicka->rm28; if ( $hlavicka->rm28 == 0 ) $rm28='';
$r29=$hlavicka->r29; if ( $hlavicka->r29 == 0 ) $r29='';
$rk29=$hlavicka->rk29; if ( $hlavicka->rk29 == 0 ) $rk29='';
$rn29=$hlavicka->rn29; if ( $hlavicka->rn29 == 0 ) $rn29='';
$rm29=$hlavicka->rm29; if ( $hlavicka->rm29 == 0 ) $rm29='';
$r30=$hlavicka->r30; if ( $hlavicka->r30 == 0 ) $r30='';
$rk30=$hlavicka->rk30; if ( $hlavicka->rk30 == 0 ) $rk30='';
$rn30=$hlavicka->rn30; if ( $hlavicka->rn30 == 0 ) $rn30='';
$rm30=$hlavicka->rm30; if ( $hlavicka->rm30 == 0 ) $rm30='';
$r31=$hlavicka->r31; if ( $hlavicka->r31 == 0 ) $r31='';
$rk31=$hlavicka->rk31; if ( $hlavicka->rk31 == 0 ) $rk31='';
$rn31=$hlavicka->rn31; if ( $hlavicka->rn31 == 0 ) $rn31='';
$rm31=$hlavicka->rm31; if ( $hlavicka->rm31 == 0 ) $rm31='';
$r32=$hlavicka->r32; if ( $hlavicka->r32 == 0 ) $r32='';
$rk32=$hlavicka->rk32; if ( $hlavicka->rk32 == 0 ) $rk32='';
$rn32=$hlavicka->rn32; if ( $hlavicka->rn32 == 0 ) $rn32='';
$rm32=$hlavicka->rm32; if ( $hlavicka->rm32 == 0 ) $rm32='';
$r33=$hlavicka->r33; if ( $hlavicka->r33 == 0 ) $r33='';
$rk33=$hlavicka->rk33; if ( $hlavicka->rk33 == 0 ) $rk33='';
$rn33=$hlavicka->rn33; if ( $hlavicka->rn33 == 0 ) $rn33='';
$rm33=$hlavicka->rm33; if ( $hlavicka->rm33 == 0 ) $rm33='';
$r34=$hlavicka->r34; if ( $hlavicka->r34 == 0 ) $r34='';
$rk34=$hlavicka->rk34; if ( $hlavicka->rk34 == 0 ) $rk34='';
$rn34=$hlavicka->rn34; if ( $hlavicka->rn34 == 0 ) $rn34='';
$rm34=$hlavicka->rm34; if ( $hlavicka->rm34 == 0 ) $rm34='';
$r35=$hlavicka->r35; if ( $hlavicka->r35 == 0 ) $r35='';
$rk35=$hlavicka->rk35; if ( $hlavicka->rk35 == 0 ) $rk35='';
$rn35=$hlavicka->rn35; if ( $hlavicka->rn35 == 0 ) $rn35='';
$rm35=$hlavicka->rm35; if ( $hlavicka->rm35 == 0 ) $rm35='';
$r36=$hlavicka->r36; if ( $hlavicka->r36 == 0 ) $r36='';
$rk36=$hlavicka->rk36; if ( $hlavicka->rk36 == 0 ) $rk36='';
$rn36=$hlavicka->rn36; if ( $hlavicka->rn36 == 0 ) $rn36='';
$rm36=$hlavicka->rm36; if ( $hlavicka->rm36 == 0 ) $rm36='';
$r37=$hlavicka->r37; if ( $hlavicka->r37 == 0 ) $r37='';
$rk37=$hlavicka->rk37; if ( $hlavicka->rk37 == 0 ) $rk37='';
$rn37=$hlavicka->rn37; if ( $hlavicka->rn37 == 0 ) $rn37='';
$rm37=$hlavicka->rm37; if ( $hlavicka->rm37 == 0 ) $rm37='';
$r38=$hlavicka->r38; if ( $hlavicka->r38 == 0 ) $r38='';
$rk38=$hlavicka->rk38; if ( $hlavicka->rk38 == 0 ) $rk38='';
$rn38=$hlavicka->rn38; if ( $hlavicka->rn38 == 0 ) $rn38='';
$rm38=$hlavicka->rm38; if ( $hlavicka->rm38 == 0 ) $rm38='';
$r39=$hlavicka->r39; if ( $hlavicka->r39 == 0 ) $r39='';
$rk39=$hlavicka->rk39; if ( $hlavicka->rk39 == 0 ) $rk39='';
$rn39=$hlavicka->rn39; if ( $hlavicka->rn39 == 0 ) $rn39='';
$rm39=$hlavicka->rm39; if ( $hlavicka->rm39 == 0 ) $rm39='';
$r40=$hlavicka->r40; if ( $hlavicka->r40 == 0 ) $r40='';
$rk40=$hlavicka->rk40; if ( $hlavicka->rk40 == 0 ) $rk40='';
$rn40=$hlavicka->rn40; if ( $hlavicka->rn40 == 0 ) $rn40='';
$rm40=$hlavicka->rm40; if ( $hlavicka->rm40 == 0 ) $rm40='';
$r41=$hlavicka->r41; if ( $hlavicka->r41 == 0 ) $r41='';
$rk41=$hlavicka->rk41; if ( $hlavicka->rk41 == 0 ) $rk41='';
$rn41=$hlavicka->rn41; if ( $hlavicka->rn41 == 0 ) $rn41='';
$rm41=$hlavicka->rm41; if ( $hlavicka->rm41 == 0 ) $rm41='';
$r42=$hlavicka->r42; if ( $hlavicka->r42 == 0 ) $r42='';
$rk42=$hlavicka->rk42; if ( $hlavicka->rk42 == 0 ) $rk42='';
$rn42=$hlavicka->rn42; if ( $hlavicka->rn42 == 0 ) $rn42='';
$rm42=$hlavicka->rm42; if ( $hlavicka->rm42 == 0 ) $rm42='';
$r43=$hlavicka->r43; if ( $hlavicka->r43 == 0 ) $r43='';
$rk43=$hlavicka->rk43; if ( $hlavicka->rk43 == 0 ) $rk43='';
$rn43=$hlavicka->rn43; if ( $hlavicka->rn43 == 0 ) $rn43='';
$rm43=$hlavicka->rm43; if ( $hlavicka->rm43 == 0 ) $rm43='';
$r44=$hlavicka->r44; if ( $hlavicka->r44 == 0 ) $r44='';
$rk44=$hlavicka->rk44; if ( $hlavicka->rk44 == 0 ) $rk44='';
$rn44=$hlavicka->rn44; if ( $hlavicka->rn44 == 0 ) $rn44='';
$rm44=$hlavicka->rm44; if ( $hlavicka->rm44 == 0 ) $rm44='';
$r45=$hlavicka->r45; if ( $hlavicka->r45 == 0 ) $r45='';
$rk45=$hlavicka->rk45; if ( $hlavicka->rk45 == 0 ) $rk45='';
$rn45=$hlavicka->rn45; if ( $hlavicka->rn45 == 0 ) $rn45='';
$rm45=$hlavicka->rm45; if ( $hlavicka->rm45 == 0 ) $rm45='';
$r46=$hlavicka->r46; if ( $hlavicka->r46 == 0 ) $r46='';
$rk46=$hlavicka->rk46; if ( $hlavicka->rk46 == 0 ) $rk46='';
$rn46=$hlavicka->rn46; if ( $hlavicka->rn46 == 0 ) $rn46='';
$rm46=$hlavicka->rm46; if ( $hlavicka->rm46 == 0 ) $rm46='';
$r47=$hlavicka->r47; if ( $hlavicka->r47 == 0 ) $r47='';
$rk47=$hlavicka->rk47; if ( $hlavicka->rk47 == 0 ) $rk47='';
$rn47=$hlavicka->rn47; if ( $hlavicka->rn47 == 0 ) $rn47='';
$rm47=$hlavicka->rm47; if ( $hlavicka->rm47 == 0 ) $rm47='';
$r48=$hlavicka->r48; if ( $hlavicka->r48 == 0 ) $r48='';
$rk48=$hlavicka->rk48; if ( $hlavicka->rk48 == 0 ) $rk48='';
$rn48=$hlavicka->rn48; if ( $hlavicka->rn48 == 0 ) $rn48='';
$rm48=$hlavicka->rm48; if ( $hlavicka->rm48 == 0 ) $rm48='';
$r49=$hlavicka->r49; if ( $hlavicka->r49 == 0 ) $r49='';
$rk49=$hlavicka->rk49; if ( $hlavicka->rk49 == 0 ) $rk49='';
$rn49=$hlavicka->rn49; if ( $hlavicka->rn49 == 0 ) $rn49='';
$rm49=$hlavicka->rm49; if ( $hlavicka->rm49 == 0 ) $rm49='';
$r50=$hlavicka->r50; if ( $hlavicka->r50 == 0 ) $r50='';
$rk50=$hlavicka->rk50; if ( $hlavicka->rk50 == 0 ) $rk50='';
$rn50=$hlavicka->rn50; if ( $hlavicka->rn50 == 0 ) $rn50='';
$rm50=$hlavicka->rm50; if ( $hlavicka->rm50 == 0 ) $rm50='';
$r51=$hlavicka->r51; if ( $hlavicka->r51 == 0 ) $r51='';
$rk51=$hlavicka->rk51; if ( $hlavicka->rk51 == 0 ) $rk51='';
$rn51=$hlavicka->rn51; if ( $hlavicka->rn51 == 0 ) $rn51='';
$rm51=$hlavicka->rm51; if ( $hlavicka->rm51 == 0 ) $rm51='';
$r52=$hlavicka->r52; if ( $hlavicka->r52 == 0 ) $r52='';
$rk52=$hlavicka->rk52; if ( $hlavicka->rk52 == 0 ) $rk52='';
$rn52=$hlavicka->rn52; if ( $hlavicka->rn52 == 0 ) $rn52='';
$rm52=$hlavicka->rm52; if ( $hlavicka->rm52 == 0 ) $rm52='';
$r53=$hlavicka->r53; if ( $hlavicka->r53 == 0 ) $r53='';
$rk53=$hlavicka->rk53; if ( $hlavicka->rk53 == 0 ) $rk53='';
$rn53=$hlavicka->rn53; if ( $hlavicka->rn53 == 0 ) $rn53='';
$rm53=$hlavicka->rm53; if ( $hlavicka->rm53 == 0 ) $rm53='';
$r54=$hlavicka->r54; if ( $hlavicka->r54 == 0 ) $r54='';
$rk54=$hlavicka->rk54; if ( $hlavicka->rk54 == 0 ) $rk54='';
$rn54=$hlavicka->rn54; if ( $hlavicka->rn54 == 0 ) $rn54='';
$rm54=$hlavicka->rm54; if ( $hlavicka->rm54 == 0 ) $rm54='';
$r55=$hlavicka->r55; if ( $hlavicka->r55 == 0 ) $r55='';
$rk55=$hlavicka->rk55; if ( $hlavicka->rk55 == 0 ) $rk55='';
$rn55=$hlavicka->rn55; if ( $hlavicka->rn55 == 0 ) $rn55='';
$rm55=$hlavicka->rm55; if ( $hlavicka->rm55 == 0 ) $rm55='';
$r56=$hlavicka->r56; if ( $hlavicka->r56 == 0 ) $r56='';
$rk56=$hlavicka->rk56; if ( $hlavicka->rk56 == 0 ) $rk56='';
$rn56=$hlavicka->rn56; if ( $hlavicka->rn56 == 0 ) $rn56='';
$rm56=$hlavicka->rm56; if ( $hlavicka->rm56 == 0 ) $rm56='';
$r57=$hlavicka->r57; if ( $hlavicka->r57 == 0 ) $r57='';
$rk57=$hlavicka->rk57; if ( $hlavicka->rk57 == 0 ) $rk57='';
$rn57=$hlavicka->rn57; if ( $hlavicka->rn57 == 0 ) $rn57='';
$rm57=$hlavicka->rm57; if ( $hlavicka->rm57 == 0 ) $rm57='';
$r58=$hlavicka->r58; if ( $hlavicka->r58 == 0 ) $r58='';
$rk58=$hlavicka->rk58; if ( $hlavicka->rk58 == 0 ) $rk58='';
$rn58=$hlavicka->rn58; if ( $hlavicka->rn58 == 0 ) $rn58='';
$rm58=$hlavicka->rm58; if ( $hlavicka->rm58 == 0 ) $rm58='';
$r59=$hlavicka->r59; if ( $hlavicka->r59 == 0 ) $r59='';
$rk59=$hlavicka->rk59; if ( $hlavicka->rk59 == 0 ) $rk59='';
$rn59=$hlavicka->rn59; if ( $hlavicka->rn59 == 0 ) $rn59='';
$rm59=$hlavicka->rm59; if ( $hlavicka->rm59 == 0 ) $rm59='';
$r60=$hlavicka->r60; if ( $hlavicka->r60 == 0 ) $r60='';
$rk60=$hlavicka->rk60; if ( $hlavicka->rk60 == 0 ) $rk60='';
$rn60=$hlavicka->rn60; if ( $hlavicka->rn60 == 0 ) $rn60='';
$rm60=$hlavicka->rm60; if ( $hlavicka->rm60 == 0 ) $rm60='';
$r61=$hlavicka->r61; if ( $hlavicka->r61 == 0 ) $r61='';
$rk61=$hlavicka->rk61; if ( $hlavicka->rk61 == 0 ) $rk61='';
$rn61=$hlavicka->rn61; if ( $hlavicka->rn61 == 0 ) $rn61='';
$rm61=$hlavicka->rm61; if ( $hlavicka->rm61 == 0 ) $rm61='';
$r62=$hlavicka->r62; if ( $hlavicka->r62 == 0 ) $r62='';
$rk62=$hlavicka->rk62; if ( $hlavicka->rk62 == 0 ) $rk62='';
$rn62=$hlavicka->rn62; if ( $hlavicka->rn62 == 0 ) $rn62='';
$rm62=$hlavicka->rm62; if ( $hlavicka->rm62 == 0 ) $rm62='';
$r63=$hlavicka->r63; if ( $hlavicka->r63 == 0 ) $r63='';
$rk63=$hlavicka->rk63; if ( $hlavicka->rk63 == 0  ) $rk63='';
$rn63=$hlavicka->rn63; if ( $hlavicka->rn63 == 0 ) $rn63='';
$rm63=$hlavicka->rm63; if ( $hlavicka->rm63 == 0 ) $rm63='';
$r64=$hlavicka->r64; if ( $hlavicka->r64 == 0 ) $r64='';
$rk64=$hlavicka->rk64; if ( $hlavicka->rk64 == 0 ) $rk64='';
$rn64=$hlavicka->rn64; if ( $hlavicka->rn64 == 0 ) $rn64='';
$rm64=$hlavicka->rm64; if ( $hlavicka->rm64 == 0 ) $rm64='';
$r65=$hlavicka->r65; if ( $hlavicka->r65 == 0 ) $r65='';
$rk65=$hlavicka->rk65; if ( $hlavicka->rk65 == 0 ) $rk65='';
$rn65=$hlavicka->rn65; if ( $hlavicka->rn65 == 0 ) $rn65='';
$rm65=$hlavicka->rm65; if ( $hlavicka->rm65 == 0 ) $rm65='';
$r66=$hlavicka->r66; if ( $hlavicka->r66 == 0 ) $r66='';
$rk66=$hlavicka->rk66; if ( $hlavicka->rk66 == 0 ) $rk66='';
$rn66=$hlavicka->rn66; if ( $hlavicka->rn66 == 0 ) $rn66='';
$rm66=$hlavicka->rm66; if ( $hlavicka->rm66 == 0 ) $rm66='';
$r67=$hlavicka->r67; if ( $hlavicka->r67 == 0 ) $r67='';
$rk67=$hlavicka->rk67; if ( $hlavicka->rk67 == 0 ) $rk67='';
$rn67=$hlavicka->rn67; if ( $hlavicka->rn67 == 0 ) $rn67='';
$rm67=$hlavicka->rm67; if ( $hlavicka->rm67 == 0 ) $rm67='';
$r68=$hlavicka->r68; if ( $hlavicka->r68 == 0 ) $r68='';
$rk68=$hlavicka->rk68; if ( $hlavicka->rk68 == 0 ) $rk68='';
$rn68=$hlavicka->rn68; if ( $hlavicka->rn68 == 0 ) $rn68='';
$rm68=$hlavicka->rm68; if ( $hlavicka->rm68 == 0 ) $rm68='';
$r69=$hlavicka->r69; if ( $hlavicka->r69 == 0 ) $r69='';
$rk69=$hlavicka->rk69; if ( $hlavicka->rk69 == 0 ) $rk69='';
$rn69=$hlavicka->rn69; if ( $hlavicka->rn69 == 0 ) $rn69='';
$rm69=$hlavicka->rm69; if ( $hlavicka->rm69 == 0 ) $rm69='';
$r70=$hlavicka->r70; if ( $hlavicka->r70 == 0 ) $r70='';
$rk70=$hlavicka->rk70; if ( $hlavicka->rk70 == 0 ) $rk70='';
$rn70=$hlavicka->rn70; if ( $hlavicka->rn70 == 0 ) $rn70='';
$rm70=$hlavicka->rm70; if ( $hlavicka->rm70 == 0 ) $rm70='';
$r71=$hlavicka->r71; if ( $hlavicka->r71 == 0 ) $r71='';
$rk71=$hlavicka->rk71; if ( $hlavicka->rk71 == 0 ) $rk71='';
$rn71=$hlavicka->rn71; if ( $hlavicka->rn71 == 0 ) $rn71='';
$rm71=$hlavicka->rm71; if ( $hlavicka->rm71 == 0 ) $rm71='';
$r72=$hlavicka->r72; if ( $hlavicka->r72 == 0 ) $r72='';
$rk72=$hlavicka->rk72; if ( $hlavicka->rk72 == 0 ) $rk72='';
$rn72=$hlavicka->rn72; if ( $hlavicka->rn72 == 0 ) $rn72='';
$rm72=$hlavicka->rm72; if ( $hlavicka->rm72 == 0 ) $rm72='';
$r73=$hlavicka->r73; if ( $hlavicka->r73 == 0 ) $r73='';
$rk73=$hlavicka->rk73; if ( $hlavicka->rk73 == 0 ) $rk73='';
$rn73=$hlavicka->rn73; if ( $hlavicka->rn73 == 0 ) $rn73='';
$rm73=$hlavicka->rm73; if ( $hlavicka->rm73 == 0 ) $rm73='';
$r74=$hlavicka->r74; if ( $hlavicka->r74 == 0 ) $r74='';
$rk74=$hlavicka->rk74; if ( $hlavicka->rk74 == 0 ) $rk74='';
$rn74=$hlavicka->rn74; if ( $hlavicka->rn74 == 0 ) $rn74='';
$rm74=$hlavicka->rm74; if ( $hlavicka->rm74 == 0 ) $rm74='';
$r75=$hlavicka->r75; if ( $hlavicka->r75 == 0 ) $r75='';
$rk75=$hlavicka->rk75; if ( $hlavicka->rk75 == 0 ) $rk75='';
$rn75=$hlavicka->rn75; if ( $hlavicka->rn75 == 0 ) $rn75='';
$rm75=$hlavicka->rm75; if ( $hlavicka->rm75 == 0 ) $rm75='';
$r76=$hlavicka->r76; if ( $hlavicka->r76 == 0 ) $r76='';
$rk76=$hlavicka->rk76; if ( $hlavicka->rk76 == 0 ) $rk76='';
$rn76=$hlavicka->rn76; if ( $hlavicka->rn76 == 0 ) $rn76='';
$rm76=$hlavicka->rm76; if ( $hlavicka->rm76 == 0 ) $rm76='';
$r77=$hlavicka->r77; if ( $hlavicka->r77 == 0 ) $r77='';
$rk77=$hlavicka->rk77; if ( $hlavicka->rk77 == 0 ) $rk77='';
$rn77=$hlavicka->rn77; if ( $hlavicka->rn77 == 0 ) $rn77='';
$rm77=$hlavicka->rm77; if ( $hlavicka->rm77 == 0 ) $rm77='';
$r78=$hlavicka->r78; if ( $hlavicka->r78 == 0 ) $r78='';
$rk78=$hlavicka->rk78; if ( $hlavicka->rk78 == 0 ) $rk78='';
$rn78=$hlavicka->rn78; if ( $hlavicka->rn78 == 0 ) $rn78='';
$rm78=$hlavicka->rm78; if ( $hlavicka->rm78 == 0 ) $rm78='';
$r79=$hlavicka->r79; if ( $hlavicka->r79 == 0 ) $r79='';
$rk79=$hlavicka->rk79; if ( $hlavicka->rk79 == 0 ) $rk79='';
$rn79=$hlavicka->rn79; if ( $hlavicka->rn79 == 0 ) $rn79='';
$rm79=$hlavicka->rm79; if ( $hlavicka->rm79 == 0 ) $rm79='';
$r80=$hlavicka->r80; if ( $hlavicka->r80 == 0 ) $r80='';
$rk80=$hlavicka->rk80; if ( $hlavicka->rk80 == 0 ) $rk80='';
$rn80=$hlavicka->rn80; if ( $hlavicka->rn80 == 0 ) $rn80='';
$rm80=$hlavicka->rm80; if ( $hlavicka->rm80 == 0 ) $rm80='';
$r81=$hlavicka->r81; if ( $hlavicka->r81 == 0 ) $r81='';
$rk81=$hlavicka->rk81; if ( $hlavicka->rk81 == 0 ) $rk81='';
$rn81=$hlavicka->rn81; if ( $hlavicka->rn81 == 0 ) $rn81='';
$rm81=$hlavicka->rm81; if ( $hlavicka->rm81 == 0 ) $rm81='';
$r82=$hlavicka->r82; if ( $hlavicka->r82 == 0 ) $r82='';
$rk82=$hlavicka->rk82; if ( $hlavicka->rk82 == 0 ) $rk82='';
$rn82=$hlavicka->rn82; if ( $hlavicka->rn82 == 0 ) $rn82='';
$rm82=$hlavicka->rm82; if ( $hlavicka->rm82 == 0 ) $rm82='';
$r83=$hlavicka->r83; if ( $hlavicka->r83 == 0 ) $r83='';
$rk83=$hlavicka->rk83; if ( $hlavicka->rk83 == 0 ) $rk83='';
$rn83=$hlavicka->rn83; if ( $hlavicka->rn83 == 0 ) $rn83='';
$rm83=$hlavicka->rm83; if ( $hlavicka->rm83 == 0 ) $rm83='';
$r84=$hlavicka->r84; if ( $hlavicka->r84 == 0 ) $r84='';
$rk84=$hlavicka->rk84; if ( $hlavicka->rk84 == 0 ) $rk84='';
$rn84=$hlavicka->rn84; if ( $hlavicka->rn84 == 0 ) $rn84='';
$rm84=$hlavicka->rm84; if ( $hlavicka->rm84 == 0 ) $rm84='';
$r85=$hlavicka->r85; if ( $hlavicka->r85 == 0 ) $r85='';
$rk85=$hlavicka->rk85; if ( $hlavicka->rk85 == 0 ) $rk85='';
$rn85=$hlavicka->rn85; if ( $hlavicka->rn85 == 0 ) $rn85='';
$rm85=$hlavicka->rm85; if ( $hlavicka->rm85 == 0 ) $rm85='';
$r86=$hlavicka->r86; if ( $hlavicka->r86 == 0 ) $r86='';
$rk86=$hlavicka->rk86; if ( $hlavicka->rk86 == 0 ) $rk86='';
$rn86=$hlavicka->rn86; if ( $hlavicka->rn86 == 0 ) $rn86='';
$rm86=$hlavicka->rm86; if ( $hlavicka->rm86 == 0 ) $rm86='';
$r87=$hlavicka->r87; if ( $hlavicka->r87 == 0 ) $r87='';
$rk87=$hlavicka->rk87; if ( $hlavicka->rk87 == 0 ) $rk87='';
$rn87=$hlavicka->rn87; if ( $hlavicka->rn87 == 0 ) $rn87='';
$rm87=$hlavicka->rm87; if ( $hlavicka->rm87 == 0 ) $rm87='';
$r88=$hlavicka->r88; if ( $hlavicka->r88 == 0 ) $r88='';
$rk88=$hlavicka->rk88; if ( $hlavicka->rk88 == 0 ) $rk88='';
$rn88=$hlavicka->rn88; if ( $hlavicka->rn88 == 0 ) $rn88='';
$rm88=$hlavicka->rm88; if ( $hlavicka->rm88 == 0 ) $rm88='';
$r89=$hlavicka->r89; if ( $hlavicka->r89 == 0 ) $r89='';
$rk89=$hlavicka->rk89; if ( $hlavicka->rk89 == 0 ) $rk89='';
$rn89=$hlavicka->rn89; if ( $hlavicka->rn89 == 0 ) $rn89='';
$rm89=$hlavicka->rm89; if ( $hlavicka->rm89 == 0 ) $rm89='';
$r90=$hlavicka->r90; if ( $hlavicka->r90 == 0 ) $r90='';
$rk90=$hlavicka->rk90; if ( $hlavicka->rk90 == 0 ) $rk90='';
$rn90=$hlavicka->rn90; if ( $hlavicka->rn90 == 0 ) $rn90='';
$rm90=$hlavicka->rm90; if ( $hlavicka->rm90 == 0 ) $rm90='';
$r91=$hlavicka->r91; if ( $hlavicka->r91 == 0 ) $r91='';
$rk91=$hlavicka->rk91; if ( $hlavicka->rk91 == 0 ) $rk91='';
$rn91=$hlavicka->rn91; if ( $hlavicka->rn91 == 0 ) $rn91='';
$rm91=$hlavicka->rm91; if ( $hlavicka->rm91 == 0 ) $rm91='';
$r92=$hlavicka->r92; if ( $hlavicka->r92 == 0 ) $r92='';
$rk92=$hlavicka->rk92; if ( $hlavicka->rk92 == 0 ) $rk92='';
$rn92=$hlavicka->rn92; if ( $hlavicka->rn92 == 0 ) $rn92='';
$rm92=$hlavicka->rm92; if ( $hlavicka->rm92 == 0 ) $rm92='';
$r93=$hlavicka->r93; if ( $hlavicka->r93 == 0 ) $r93='';
$rk93=$hlavicka->rk93; if ( $hlavicka->rk93 == 0 ) $rk93='';
$rn93=$hlavicka->rn93; if ( $hlavicka->rn93 == 0 ) $rn93='';
$rm93=$hlavicka->rm93; if ( $hlavicka->rm93 == 0 ) $rm93='';
$r94=$hlavicka->r94; if ( $hlavicka->r94 == 0 ) $r94='';
$rk94=$hlavicka->rk94; if ( $hlavicka->rk94 == 0 ) $rk94='';
$rn94=$hlavicka->rn94; if ( $hlavicka->rn94 == 0 ) $rn94='';
$rm94=$hlavicka->rm94; if ( $hlavicka->rm94 == 0 ) $rm94='';
$r95=$hlavicka->r95; if ( $hlavicka->r95 == 0 ) $r95='';
$rk95=$hlavicka->rk95; if ( $hlavicka->rk95 == 0 ) $rk95='';
$rn95=$hlavicka->rn95; if ( $hlavicka->rn95 == 0 ) $rn95='';
$rm95=$hlavicka->rm95; if ( $hlavicka->rm95 == 0 ) $rm95='';
$r96=$hlavicka->r96; if ( $hlavicka->r96 == 0 ) $r96='';
$rk96=$hlavicka->rk96; if ( $hlavicka->rk96 == 0 ) $rk96='';
$rn96=$hlavicka->rn96; if ( $hlavicka->rn96 == 0 ) $rn96='';
$rm96=$hlavicka->rm96; if ( $hlavicka->rm96 == 0 ) $rm96='';
$r97=$hlavicka->r97; if ( $hlavicka->r97 == 0 ) $r97='';
$rk97=$hlavicka->rk97; if ( $hlavicka->rk97 == 0 ) $rk97='';
$rn97=$hlavicka->rn97; if ( $hlavicka->rn97 == 0 ) $rn97='';
$rm97=$hlavicka->rm97; if ( $hlavicka->rm97 == 0 ) $rm97='';
$r98=$hlavicka->r98; if ( $hlavicka->r98 == 0 ) $r98='';
$rk98=$hlavicka->rk98; if ( $hlavicka->rk98 == 0 ) $rk98='';
$rn98=$hlavicka->rn98; if ( $hlavicka->rn98 == 0 ) $rn98='';
$rm98=$hlavicka->rm98; if ( $hlavicka->rm98 == 0 ) $rm98='';
$r99=$hlavicka->r99; if ( $hlavicka->r99 == 0 ) $r99='';
$rk99=$hlavicka->rk99; if ( $hlavicka->rk99 == 0 ) $rk99='';
$rn99=$hlavicka->rn99; if ( $hlavicka->rn99 == 0 ) $rn99='';
$rm99=$hlavicka->rm99; if ( $hlavicka->rm99 == 0 ) $rm99='';
$r100=$hlavicka->r100; if ( $hlavicka->r100 == 0 ) $r100='';
$rk100=$hlavicka->rk100; if ( $hlavicka->rk100 == 0 ) $rk100='';
$rn100=$hlavicka->rn100; if ( $hlavicka->rn100 == 0 ) $rn100='';
$rm100=$hlavicka->rm100; if ( $hlavicka->rm100 == 0 ) $rm100='';
$r101=$hlavicka->r101; if ( $hlavicka->r101 == 0 ) $r101='';
$rk101=$hlavicka->rk101; if ( $hlavicka->rk101 == 0 ) $rk101='';
$rn101=$hlavicka->rn101; if ( $hlavicka->rn101 == 0 ) $rn101='';
$rm101=$hlavicka->rm101; if ( $hlavicka->rm101 == 0 ) $rm101='';
$r102=$hlavicka->r102; if ( $hlavicka->r102 == 0 ) $r102='';
$rk102=$hlavicka->rk102; if ( $hlavicka->rk102 == 0 ) $rk102='';
$rn102=$hlavicka->rn102; if ( $hlavicka->rn102 == 0 ) $rn102='';
$rm102=$hlavicka->rm102; if ( $hlavicka->rm102 == 0 ) $rm102='';
$r103=$hlavicka->r103; if ( $hlavicka->r103 == 0 ) $r103='';
$rk103=$hlavicka->rk103; if ( $hlavicka->rk103 == 0 ) $rk103='';
$rn103=$hlavicka->rn103; if ( $hlavicka->rn103 == 0 ) $rn103='';
$rm103=$hlavicka->rm103; if ( $hlavicka->rm103 == 0 ) $rm103='';
$r104=$hlavicka->r104; if ( $hlavicka->r104 == 0 ) $r104='';
$rk104=$hlavicka->rk104; if ( $hlavicka->rk104 == 0 ) $rk104='';
$rn104=$hlavicka->rn104; if ( $hlavicka->rn104 == 0 ) $rn104='';
$rm104=$hlavicka->rm104; if ( $hlavicka->rm104 == 0 ) $rm104='';
$r105=$hlavicka->r105; if ( $hlavicka->r105 == 0 ) $r105='';
$rk105=$hlavicka->rk105; if ( $hlavicka->rk105 == 0 ) $rk105='';
$rn105=$hlavicka->rn105; if ( $hlavicka->rn105 == 0 ) $rn105='';
$rm105=$hlavicka->rm105; if ( $hlavicka->rm105 == 0 ) $rm105='';
$r106=$hlavicka->r106; if ( $hlavicka->r106 == 0 ) $r106='';
$rk106=$hlavicka->rk106; if ( $hlavicka->rk106 == 0 ) $rk106='';
$rn106=$hlavicka->rn106; if ( $hlavicka->rn106 == 0 ) $rn106='';
$rm106=$hlavicka->rm106; if ( $hlavicka->rm106 == 0 ) $rm106='';
$r107=$hlavicka->r107; if ( $hlavicka->r107 == 0 ) $r107='';
$rk107=$hlavicka->rk107; if ( $hlavicka->rk107 == 0 ) $rk107='';
$rn107=$hlavicka->rn107; if ( $hlavicka->rn107 == 0 ) $rn107='';
$rm107=$hlavicka->rm107; if ( $hlavicka->rm107 == 0 ) $rm107='';
$r108=$hlavicka->r108; if ( $hlavicka->r108 == 0 ) $r108='';
$rk108=$hlavicka->rk108; if ( $hlavicka->rk108 == 0 ) $rk108='';
$rn108=$hlavicka->rn108; if ( $hlavicka->rn108 == 0 ) $rn108='';
$rm108=$hlavicka->rm108; if ( $hlavicka->rm108 == 0 ) $rm108='';
$r109=$hlavicka->r109; if ( $hlavicka->r109 == 0 ) $r109='';
$rk109=$hlavicka->rk109; if ( $hlavicka->rk109 == 0 ) $rk109='';
$rn109=$hlavicka->rn109; if ( $hlavicka->rn109 == 0 ) $rn109='';
$rm109=$hlavicka->rm109; if ( $hlavicka->rm109 == 0 ) $rm109='';
$r110=$hlavicka->r110; if ( $hlavicka->r110 == 0 ) $r110='';
$rk110=$hlavicka->rk110; if ( $hlavicka->rk110 == 0 ) $rk110='';
$rn110=$hlavicka->rn110; if ( $hlavicka->rn110 == 0 ) $rn110='';
$rm110=$hlavicka->rm110; if ( $hlavicka->rm110 == 0 ) $rm110='';
$r111=$hlavicka->r111; if ( $hlavicka->r111 == 0 ) $r111='';
$rk111=$hlavicka->rk111; if ( $hlavicka->rk111 == 0 ) $rk111='';
$rn111=$hlavicka->rn111; if ( $hlavicka->rn111 == 0 ) $rn111='';
$rm111=$hlavicka->rm111; if ( $hlavicka->rm111 == 0 ) $rm111='';
$r112=$hlavicka->r112; if ( $hlavicka->r112 == 0 ) $r112='';
$rk112=$hlavicka->rk112; if ( $hlavicka->rk112 == 0 ) $rk112='';
$rn112=$hlavicka->rn112; if ( $hlavicka->rn112 == 0 ) $rn112='';
$rm112=$hlavicka->rm112; if ( $hlavicka->rm112 == 0 ) $rm112='';
$r113=$hlavicka->r113; if ( $hlavicka->r113 == 0 ) $r113='';
$rk113=$hlavicka->rk113; if ( $hlavicka->rk113 == 0 ) $rk113='';
$rn113=$hlavicka->rn113; if ( $hlavicka->rn113 == 0 ) $rn113='';
$rm113=$hlavicka->rm113; if ( $hlavicka->rm113 == 0 ) $rm113='';
$r114=$hlavicka->r114; if ( $hlavicka->r114 == 0 ) $r114='';
$rk114=$hlavicka->rk114; if ( $hlavicka->rk114 == 0 ) $rk114='';
$rn114=$hlavicka->rn114; if ( $hlavicka->rn114 == 0 ) $rn114='';
$rm114=$hlavicka->rm114; if ( $hlavicka->rm114 == 0 ) $rm114='';
$r115=$hlavicka->r115; if ( $hlavicka->r115 == 0 ) $r115='';
$rk115=$hlavicka->rk115; if ( $hlavicka->rk115 == 0 ) $rk115='';
$rn115=$hlavicka->rn115; if ( $hlavicka->rn115 == 0 ) $rn115='';
$rm115=$hlavicka->rm115; if ( $hlavicka->rm115 == 0 ) $rm115='';
$r116=$hlavicka->r116; if ( $hlavicka->r116 == 0 ) $r116='';
$rk116=$hlavicka->rk116; if ( $hlavicka->rk116 == 0 ) $rk116='';
$rn116=$hlavicka->rn116; if ( $hlavicka->rn116 == 0 ) $rn116='';
$rm116=$hlavicka->rm116; if ( $hlavicka->rm116 == 0 ) $rm116='';
$r117=$hlavicka->r117; if ( $hlavicka->r117 == 0 ) $r117='';
$rk117=$hlavicka->rk117; if ( $hlavicka->rk117 == 0 ) $rk117='';
$rn117=$hlavicka->rn117; if ( $hlavicka->rn117 == 0 ) $rn117='';
$rm117=$hlavicka->rm117; if ( $hlavicka->rm117 == 0 ) $rm117='';

//ak je ps 0.00 zadany daj 0.00
$sqlttm = "SELECT * FROM F$kli_vxcf"."_uctpocsuvahano WHERE dok > 0 AND hod = 0 ORDER BY dok";
$sqlm = mysql_query("$sqlttm");
if($sqlm){ $polm = mysql_num_rows($sqlm); }
$im=0;
  while ($im <= $polm )
  {
  if (@$zaznam=mysql_data_seek($sqlm,$im))
{
$hlavickam=mysql_fetch_object($sqlm);

if( $hlavickam->dok ==  1 ) { $rm01="0.00"; }
if( $hlavickam->dok ==  2 ) { $rm02="0.00"; }
if( $hlavickam->dok ==  3 ) { $rm03="0.00"; }
if( $hlavickam->dok ==  4 ) { $rm04="0.00"; }
if( $hlavickam->dok ==  5 ) { $rm05="0.00"; }
if( $hlavickam->dok ==  6 ) { $rm06="0.00"; }
if( $hlavickam->dok ==  7 ) { $rm07="0.00"; }
if( $hlavickam->dok ==  8 ) { $rm08="0.00"; }
if( $hlavickam->dok ==  9 ) { $rm09="0.00"; }
if( $hlavickam->dok == 10 ) { $rm10="0.00"; }
if( $hlavickam->dok == 11 ) { $rm11="0.00"; }
if( $hlavickam->dok == 12 ) { $rm12="0.00"; }
if( $hlavickam->dok == 13 ) { $rm13="0.00"; }
if( $hlavickam->dok == 14 ) { $rm14="0.00"; }
if( $hlavickam->dok == 15 ) { $rm15="0.00"; }
if( $hlavickam->dok == 16 ) { $rm16="0.00"; }
if( $hlavickam->dok == 17 ) { $rm17="0.00"; }
if( $hlavickam->dok == 18 ) { $rm18="0.00"; }
if( $hlavickam->dok == 19 ) { $rm19="0.00"; }
if( $hlavickam->dok == 20 ) { $rm20="0.00"; }
if( $hlavickam->dok == 21 ) { $rm21="0.00"; }
if( $hlavickam->dok == 22 ) { $rm22="0.00"; }
if( $hlavickam->dok == 23 ) { $rm23="0.00"; }
if( $hlavickam->dok == 24 ) { $rm24="0.00"; }
if( $hlavickam->dok == 25 ) { $rm25="0.00"; }
if( $hlavickam->dok == 26 ) { $rm26="0.00"; }
if( $hlavickam->dok == 27 ) { $rm27="0.00"; }
if( $hlavickam->dok == 28 ) { $rm28="0.00"; }
if( $hlavickam->dok == 29 ) { $rm29="0.00"; }
if( $hlavickam->dok == 30 ) { $rm30="0.00"; }
if( $hlavickam->dok == 31 ) { $rm31="0.00"; }
if( $hlavickam->dok == 32 ) { $rm32="0.00"; }
if( $hlavickam->dok == 33 ) { $rm33="0.00"; }
if( $hlavickam->dok == 34 ) { $rm34="0.00"; }
if( $hlavickam->dok == 35 ) { $rm35="0.00"; }
if( $hlavickam->dok == 36 ) { $rm36="0.00"; }
if( $hlavickam->dok == 37 ) { $rm37="0.00"; }
if( $hlavickam->dok == 38 ) { $rm38="0.00"; }
if( $hlavickam->dok == 39 ) { $rm39="0.00"; }
if( $hlavickam->dok == 40 ) { $rm40="0.00"; }
if( $hlavickam->dok == 41 ) { $rm41="0.00"; }
if( $hlavickam->dok == 42 ) { $rm42="0.00"; }
if( $hlavickam->dok == 43 ) { $rm43="0.00"; }
if( $hlavickam->dok == 44 ) { $rm44="0.00"; }
if( $hlavickam->dok == 45 ) { $rm45="0.00"; }
if( $hlavickam->dok == 46 ) { $rm46="0.00"; }
if( $hlavickam->dok == 47 ) { $rm47="0.00"; }
if( $hlavickam->dok == 48 ) { $rm48="0.00"; }
if( $hlavickam->dok == 49 ) { $rm49="0.00"; }
if( $hlavickam->dok == 50 ) { $rm50="0.00"; }
if( $hlavickam->dok == 51 ) { $rm51="0.00"; }
if( $hlavickam->dok == 52 ) { $rm52="0.00"; }
if( $hlavickam->dok == 53 ) { $rm53="0.00"; }
if( $hlavickam->dok == 54 ) { $rm54="0.00"; }
if( $hlavickam->dok == 55 ) { $rm55="0.00"; }
if( $hlavickam->dok == 56 ) { $rm56="0.00"; }
if( $hlavickam->dok == 57 ) { $rm57="0.00"; }
if( $hlavickam->dok == 58 ) { $rm58="0.00"; }
if( $hlavickam->dok == 59 ) { $rm59="0.00"; }
if( $hlavickam->dok == 60 ) { $rm60="0.00"; }
if( $hlavickam->dok == 61 ) { $rm61="0.00"; }
if( $hlavickam->dok == 62 ) { $rm62="0.00"; }
if( $hlavickam->dok == 63 ) { $rm63="0.00"; }
if( $hlavickam->dok == 64 ) { $rm64="0.00"; }
if( $hlavickam->dok == 65 ) { $rm65="0.00"; }
if( $hlavickam->dok == 66 ) { $rm66="0.00"; }
if( $hlavickam->dok == 67 ) { $rm67="0.00"; }
if( $hlavickam->dok == 68 ) { $rm68="0.00"; }
if( $hlavickam->dok == 69 ) { $rm69="0.00"; }
if( $hlavickam->dok == 70 ) { $rm70="0.00"; }
if( $hlavickam->dok == 71 ) { $rm71="0.00"; }
if( $hlavickam->dok == 72 ) { $rm72="0.00"; }
if( $hlavickam->dok == 73 ) { $rm73="0.00"; }
if( $hlavickam->dok == 74 ) { $rm74="0.00"; }
if( $hlavickam->dok == 75 ) { $rm75="0.00"; }
if( $hlavickam->dok == 76 ) { $rm76="0.00"; }
if( $hlavickam->dok == 77 ) { $rm77="0.00"; }
if( $hlavickam->dok == 78 ) { $rm78="0.00"; }
if( $hlavickam->dok == 79 ) { $rm79="0.00"; }
if( $hlavickam->dok == 80 ) { $rm80="0.00"; }
if( $hlavickam->dok == 81 ) { $rm81="0.00"; }
if( $hlavickam->dok == 82 ) { $rm82="0.00"; }
if( $hlavickam->dok == 83 ) { $rm83="0.00"; }
if( $hlavickam->dok == 84 ) { $rm84="0.00"; }
if( $hlavickam->dok == 85 ) { $rm85="0.00"; }
if( $hlavickam->dok == 86 ) { $rm86="0.00"; }
if( $hlavickam->dok == 87 ) { $rm87="0.00"; }
if( $hlavickam->dok == 88 ) { $rm88="0.00"; }
if( $hlavickam->dok == 89 ) { $rm89="0.00"; }
if( $hlavickam->dok == 90 ) { $rm90="0.00"; }
if( $hlavickam->dok == 91 ) { $rm91="0.00"; }
if( $hlavickam->dok == 92 ) { $rm92="0.00"; }
if( $hlavickam->dok == 93 ) { $rm93="0.00"; }
if( $hlavickam->dok == 94 ) { $rm94="0.00"; }
if( $hlavickam->dok == 95 ) { $rm95="0.00"; }
if( $hlavickam->dok == 96 ) { $rm96="0.00"; }
if( $hlavickam->dok == 97 ) { $rm97="0.00"; }
if( $hlavickam->dok == 98 ) { $rm98="0.00"; }
if( $hlavickam->dok == 99 ) { $rm99="0.00"; }
if( $hlavickam->dok == 100 ) { $rm100="0.00"; }
if( $hlavickam->dok == 101 ) { $rm101="0.00"; }
if( $hlavickam->dok == 102 ) { $rm102="0.00"; }
if( $hlavickam->dok == 103 ) { $rm103="0.00"; }
if( $hlavickam->dok == 104 ) { $rm104="0.00"; }
if( $hlavickam->dok == 105 ) { $rm105="0.00"; }
if( $hlavickam->dok == 106 ) { $rm106="0.00"; }
if( $hlavickam->dok == 107 ) { $rm107="0.00"; }
if( $hlavickam->dok == 108 ) { $rm108="0.00"; }
if( $hlavickam->dok == 109 ) { $rm109="0.00"; }
if( $hlavickam->dok == 110 ) { $rm110="0.00"; }
}
$im = $im + 1;
  }


//vypocitaj rm991,992,993 ako sucet to uz od 2012 zbytocne lebo kontrolne cisla zrusili
$nnne=1;
if ( $nnne == 0 )
    {
$rm991=0;
$sqldok = mysql_query("SELECT SUM(hod) as r991 FROM F$kli_vxcf"."_uctpocsuvahano WHERE dok >= 1 AND dok <= 28 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rm991=1*$riaddok->r991;
  }
$rm992=0;
$sqldok = mysql_query("SELECT SUM(hod) as r992 FROM F$kli_vxcf"."_uctpocsuvahano WHERE dok >= 29 AND dok <= 60 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rm992=1*$riaddok->r992;
  }
$rm993=0;
$sqldok = mysql_query("SELECT SUM(hod) as r993 FROM F$kli_vxcf"."_uctpocsuvahano WHERE dok >= 61 AND dok <= 104 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rm993=1*$riaddok->r993;
  }
     }
//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-1.jpg') AND $i == 0 )
{
if ( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-1.jpg',4,0,201,291); }
}

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

//nacitaj uzavierka k datumu z ufirdalsie
$datksk="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datksk=SkDatum($riadok->datk);
  }

if( $datksk != '' AND $datksk != '00.00.0000' ) { $datk_sk=$datksk; } 

//zostavena k
$pdf->Cell(190,18,"     ","0",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(84,6," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","0",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","0",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,28,"     ","0",1,"L");
$textxx="1234567890";
$text=$fir_fdic;
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
$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7,"     ","0",1,"L");
$textxx="12345678";
$text=$fir_fico;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//sknace
$pdf->Cell(190,7,"     ","0",1,"L");
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
$pdf->Cell(27,6," ","0",0,"C");$pdf->Cell(4,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","0",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","0",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
$pdf->SetFont('arial','',8);
$riadna=""; if ( $h_drp == 1 ) $riadna="x";
$mimor=""; if ( $h_drp == 2 ) $mimor="x";
if ( $h_zos != '' )
{
$krizzos="x";
if ( trim($h_sch) != '' ) { $krizzos=" "; }
}
if ( $h_sch != '' )
{
$krizsch="x";
}
$pdf->SetY(66);
$pdf->Cell(64,3," ","0",0,"C");$pdf->Cell(3,3,"$riadna","$rmc",0,"C");$pdf->Cell(26,3," ","0",0,"C");$pdf->Cell(3,3,"$krizzos","$rmc",1,"C");
$pdf->SetY(75);
$pdf->Cell(64,3," ","0",0,"C");$pdf->Cell(3,3,"$mimor","$rmc",0,"C");$pdf->Cell(26,3," ","0",0,"C");$pdf->Cell(3,3,"$krizsch","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.12.".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);
     }
  }

$poleb = explode(".", $datbodsk);
$obdd1=$poleb[0];
$obdm1=$poleb[1];
$obdr1=$poleb[2];
$poleb = explode(".", $datbdosk);
$obdd2=$poleb[0];
$obdm2=$poleb[1];
$obdr2=$poleb[2];
$poleb = explode(".", $datmodsk);
$obmd1=$poleb[0];
$obmm1=$poleb[1];
$obmr1=$poleb[2];
$poleb = explode(".", $datmdosk);
$obmd2=$poleb[0];
$obmm2=$poleb[1];
$obmr2=$poleb[2];


$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;

//za obdobie
$me1="0"; $me2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$me1=substr($obdm1,0,1);
$me2=substr($obdm1,1,1);
}
$C=substr($kli_rdph,2,1);
$D=substr($kli_rdph,3,1);
$pdf->SetY(62);
$pdf->Cell(156,5," ","0",0,"R");$pdf->Cell(4,6,"$me1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1);
}
$pdf->SetY(71);
$pdf->Cell(156,5," ","0",0,"R");$pdf->Cell(4,6,"$Am","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bm","$rmc",0,"C");
$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//predchadzajuce obdobie
$mep1="0"; $mep2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mep1=substr($obmm1,0,1);
$mep2=substr($obmm1,1,1);
}
$kli_prdph=$kli_rdph-1;
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);
$pdf->SetY(80);
$pdf->Cell(156,5," ","0",0,"R");$pdf->Cell(4,6,"$mep1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$mep2","$rmc",0,"C");
$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$mepm1="1"; $mepm2="2";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1);
}
$pdf->SetY(89);
$pdf->Cell(156,5," ","0",0,"R");$pdf->Cell(4,6,"$mepm1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$mepm2","$rmc",0,"C");
$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$pdf->SetFont('arial','',8);
//prilozene sucasti
$pdf->Cell(190,8,"     ","0",1,"L");
$pdf->Cell(16,5," ","0",0,"C");$pdf->Cell(4,4,"x","$rmc",0,"C");$pdf->Cell(67,5," ","0",0,"C");$pdf->Cell(5,4,"x","$rmc",1,"C");
$pdf->Cell(190,3,"     ","0",1,"L");
$pdf->Cell(16,5," ","0",0,"C");$pdf->Cell(4,5,"x","$rmc",1,"C");
$pdf->SetFont('arial','',12);

//nazov
$pdf->Cell(190,11,"     ","0",1,"L");
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
$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//nazov r2
$fir_fnazr2="";
$pdf->Cell(190,3,"     ","0",1,"L");
$fir_fnazr2=substr($fir_fnaz,37,36);
$A=substr($fir_fnazr2,0,1);
$B=substr($fir_fnazr2,1,1);
$C=substr($fir_fnazr2,2,1);
$D=substr($fir_fnazr2,3,1);
$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);
$G=substr($fir_fnazr2,6,1);
$H=substr($fir_fnazr2,7,1);
$I=substr($fir_fnazr2,8,1);
$J=substr($fir_fnazr2,9,1);
$K=substr($fir_fnazr2,10,1);
$L=substr($fir_fnazr2,11,1);
$M=substr($fir_fnazr2,12,1);
$N=substr($fir_fnazr2,13,1);
$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);
$R=substr($fir_fnazr2,16,1);
$S=substr($fir_fnazr2,17,1);
$T=substr($fir_fnazr2,18,1);
$U=substr($fir_fnazr2,19,1);
$V=substr($fir_fnazr2,20,1);
$W=substr($fir_fnazr2,21,1);
$X=substr($fir_fnazr2,22,1);
$Y=substr($fir_fnazr2,23,1);
$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);
$B1=substr($fir_fnazr2,26,1);
$C1=substr($fir_fnazr2,27,1);
$D1=substr($fir_fnazr2,28,1);
$E1=substr($fir_fnazr2,29,1);
$F1=substr($fir_fnazr2,30,1);
$G1=substr($fir_fnazr2,31,1);
$H1=substr($fir_fnazr2,32,1);
$I1=substr($fir_fnazr2,33,1);
$J1=substr($fir_fnazr2,34,1);
$K1=substr($fir_fnazr2,35,1);
$L1=substr($fir_fnazr2,36,1);
$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//Sidlo uctovej jednotky
//ulica
$pdf->Cell(190,13,"     ","0",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$fir_fuli;
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
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");

//cislo
$textxx="111122";
$text=$fir_fcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(7,7," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,6,"                          ","0",1,"L");
$text=$fir_fpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text=$fir_fmes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
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
$pdf->Cell(7,6," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,6,"                          ","0",1,"L");
$text=$fir_ftel;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(6,7," ","0",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t03","$rmc",0,"C");$pdf->Cell(5,7," ","0",0,"C");$pdf->Cell(5,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//cislo faxu
$text=$fir_ffax;
$textxx="0905/665881";
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(11,7," ","0",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(6,7," ","0",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t11","$rmc",1,"L");

//email
$pdf->Cell(190,7,"     ","0",1,"L");
$fir_fulicis=$fir_fem1;
$A=substr($fir_fulicis,0,1);
$B=substr($fir_fulicis,1,1);
$C=substr($fir_fulicis,2,1);
$D=substr($fir_fulicis,3,1);
$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);
$G=substr($fir_fulicis,6,1);
$H=substr($fir_fulicis,7,1);
$I=substr($fir_fulicis,8,1);
$J=substr($fir_fulicis,9,1);
$K=substr($fir_fulicis,10,1);
$L=substr($fir_fulicis,11,1);
$M=substr($fir_fulicis,12,1);
$N=substr($fir_fulicis,13,1);
$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);
$R=substr($fir_fulicis,16,1);
$S=substr($fir_fulicis,17,1);
$T=substr($fir_fulicis,18,1);
$U=substr($fir_fulicis,19,1);
$V=substr($fir_fulicis,20,1);
$W=substr($fir_fulicis,21,1);
$X=substr($fir_fulicis,22,1);
$Y=substr($fir_fulicis,23,1);
$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);
$B1=substr($fir_fulicis,26,1);
$C1=substr($fir_fulicis,27,1);
$D1=substr($fir_fulicis,28,1);
$E1=substr($fir_fulicis,29,1);
$pdf->Cell(1,6," ","0",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//datum zostavenia
$pdf->Cell(190,10,"     ","0",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","0",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","0",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//datum schvalenia
$pdf->Cell(190,12,"     ","0",1,"L");
$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","0",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","0",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","0",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");


//odkaz na datum uzavierky k
$pdf->SetY(25);
$pdf->SetX(60);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(60);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);

//odkaz na uctovne obdobia
$pdf->SetY(55);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);

//strana 2
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-2.jpg') )
{
if ( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-2.jpg',3,1,204,286); }
}
$pdf->SetY(10);

//ico
$pdf->Cell(190,1,"     ","0",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(120,6," ","0",0,"R");
$pdf->Cell(5,7,"$A","$rmc",0,"C");$pdf->Cell(5,7,"$B","$rmc",0,"C");$pdf->Cell(6,7,"$C","$rmc",0,"C");$pdf->Cell(5,7,"$D","$rmc",0,"C");
$pdf->Cell(5,7,"$E","$rmc",0,"C");$pdf->Cell(6,7,"$F","$rmc",0,"C");$pdf->Cell(5,7,"$G","$rmc",0,"C");$pdf->Cell(5,7,"$H","$rmc",0,"C");
$pdf->SetFont('arial','',8);

//Neobezny majetok
$pdf->Cell(190,39,"     ","0",1,"L");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r01","$rmc",0,"R");$pdf->Cell(19,7,"$rk01","$rmc",0,"R");$pdf->Cell(20,7,"$rn01","$rmc",0,"R");
$pdf->Cell(29,7,"$rm01","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r02","$rmc",0,"R");$pdf->Cell(19,8,"$rk02","$rmc",0,"R");$pdf->Cell(20,8,"$rn02","$rmc",0,"R");
$pdf->Cell(29,8,"$rm02","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r03","$rmc",0,"R");$pdf->Cell(19,8,"$rk03","$rmc",0,"R");$pdf->Cell(20,8,"$rn03","$rmc",0,"R");
$pdf->Cell(29,8,"$rm03","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r04","$rmc",0,"R");$pdf->Cell(19,7,"$rk04","$rmc",0,"R");$pdf->Cell(20,7,"$rn04","$rmc",0,"R");
$pdf->Cell(29,7,"$rm04","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r05","$rmc",0,"R");$pdf->Cell(19,7,"$rk05","$rmc",0,"R");$pdf->Cell(20,7,"$rn05","$rmc",0,"R");
$pdf->Cell(29,7,"$rm05","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r06","$rmc",0,"R");$pdf->Cell(19,8,"$rk06","$rmc",0,"R");$pdf->Cell(20,8,"$rn06","$rmc",0,"R");
$pdf->Cell(29,8,"$rm06","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,7,"$r07","$rmc",0,"R");$pdf->Cell(19,7,"$rk07","$rmc",0,"R");$pdf->Cell(20,7,"$rn07","$rmc",0,"R");
$pdf->Cell(29,7,"$rm07","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r08","$rmc",0,"R");$pdf->Cell(19,8,"$rk08","$rmc",0,"R");$pdf->Cell(20,8,"$rn08","$rmc",0,"R");
$pdf->Cell(29,8,"$rm08","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r09","$rmc",0,"R");$pdf->Cell(19,7,"$rk09","$rmc",0,"R");$pdf->Cell(20,7,"$rn09","$rmc",0,"R");
$pdf->Cell(29,7,"$rm09","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r10","$rmc",0,"R");$pdf->Cell(19,7,"$rk10","$rmc",0,"R");$pdf->Cell(20,7,"$rn10","$rmc",0,"R");
$pdf->Cell(29,7,"$rm10","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r11","$rmc",0,"R");$pdf->Cell(19,7,"$rk11","$rmc",0,"R");$pdf->Cell(20,7,"$rn11","$rmc",0,"R");
$pdf->Cell(29,7,"$rm11","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,7,"$r12","$rmc",0,"R");$pdf->Cell(19,7,"$rk12","$rmc",0,"R");$pdf->Cell(20,7,"$rn12","$rmc",0,"R");
$pdf->Cell(29,7,"$rm12","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,8,"$r13","$rmc",0,"R");$pdf->Cell(19,8,"$rk13","$rmc",0,"R");$pdf->Cell(20,8,"$rn13","$rmc",0,"R");
$pdf->Cell(29,8,"$rm13","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r14","$rmc",0,"R");$pdf->Cell(19,7,"$rk14","$rmc",0,"R");$pdf->Cell(20,7,"$rn14","$rmc",0,"R");
$pdf->Cell(29,7,"$rm14","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,7,"$r15","$rmc",0,"R");$pdf->Cell(19,7,"$rk15","$rmc",0,"R");$pdf->Cell(20,7,"$rn15","$rmc",0,"R");
$pdf->Cell(29,7,"$rm15","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r16","$rmc",0,"R");$pdf->Cell(19,7,"$rk16","$rmc",0,"R");$pdf->Cell(20,7,"$rn16","$rmc",0,"R");
$pdf->Cell(29,7,"$rm16","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r17","$rmc",0,"R");$pdf->Cell(19,7,"$rk17","$rmc",0,"R");$pdf->Cell(20,7,"$rn17","$rmc",0,"R");
$pdf->Cell(29,7,"$rm17","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r18","$rmc",0,"R");$pdf->Cell(19,7,"$rk18","$rmc",0,"R");$pdf->Cell(20,7,"$rn18","$rmc",0,"R");
$pdf->Cell(29,7,"$rm18","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r19","$rmc",0,"R");$pdf->Cell(19,7,"$rk19","$rmc",0,"R");$pdf->Cell(20,7,"$rn19","$rmc",0,"R");
$pdf->Cell(29,7,"$rm19","$rmc",1,"R");
$pdf->Cell(101,9," ","0",0,"R");$pdf->Cell(24,8,"$r20","$rmc",0,"R");$pdf->Cell(19,8,"$rk20","$rmc",0,"R");$pdf->Cell(20,8,"$rn20","$rmc",0,"R");
$pdf->Cell(29,8,"$rm20","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r21","$rmc",0,"R");$pdf->Cell(19,7,"$rk21","$rmc",0,"R");$pdf->Cell(20,7,"$rn21","$rmc",0,"R");
$pdf->Cell(29,7,"$rm21","$rmc",1,"R");
$pdf->Cell(101,9," ","0",0,"R");$pdf->Cell(24,9,"$r22","$rmc",0,"R");$pdf->Cell(19,9,"$rk22","$rmc",0,"R");$pdf->Cell(20,9,"$rn22","$rmc",0,"R");
$pdf->Cell(29,9,"$rm22","$rmc",1,"R");
$pdf->Cell(101,11," ","0",0,"R");$pdf->Cell(24,11,"$r23","$rmc",0,"R");$pdf->Cell(19,11,"$rk23","$rmc",0,"R");$pdf->Cell(20,11,"$rn23","$rmc",0,"R");
$pdf->Cell(29,11,"$rm23","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r24","$rmc",0,"R");$pdf->Cell(19,8,"$rk24","$rmc",0,"R");$pdf->Cell(20,8,"$rn24","$rmc",0,"R");
$pdf->Cell(29,8,"$rm24","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r25","$rmc",0,"R");$pdf->Cell(19,8,"$rk25","$rmc",0,"R");$pdf->Cell(20,8,"$rn25","$rmc",0,"R");
$pdf->Cell(29,8,"$rm25","$rmc",1,"R");
$pdf->Cell(101,9," ","0",0,"R");$pdf->Cell(24,8,"$r26","$rmc",0,"R");$pdf->Cell(19,8,"$rk26","$rmc",0,"R");$pdf->Cell(20,8,"$rn26","$rmc",0,"R");
$pdf->Cell(29,8,"$rm26","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r27","$rmc",0,"R");$pdf->Cell(19,8,"$rk27","$rmc",0,"R");$pdf->Cell(20,8,"$rn27","$rmc",0,"R");
$pdf->Cell(29,8,"$rm27","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,9,"$r28","$rmc",0,"R");$pdf->Cell(19,9,"$rk28","$rmc",0,"R");$pdf->Cell(20,9,"$rn28","$rmc",0,"R");
$pdf->Cell(29,9,"$rm28","$rmc",1,"R");


//strana 3
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-3.jpg') )
{
if ( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-3.jpg',3,0,204,287); }
}
$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//ico
$pdf->Cell(190,3,"     ","0",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(119,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->SetFont('arial','',8);

//Neobezny majetok
$pdf->Cell(190,37,"     ","0",1,"L");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,7,"$r29","$rmc",0,"R");$pdf->Cell(19,7,"$rk29","$rmc",0,"R");$pdf->Cell(20,7,"$rn29","$rmc",0,"R");
$pdf->Cell(29,7,"$rm29","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r30","$rmc",0,"R");$pdf->Cell(19,8,"$rk30","$rmc",0,"R");$pdf->Cell(20,8,"$rn30","$rmc",0,"R");
$pdf->Cell(29,8,"$rm30","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r31","$rmc",0,"R");$pdf->Cell(19,6,"$rk31","$rmc",0,"R");$pdf->Cell(20,6,"$rn31","$rmc",0,"R");
$pdf->Cell(29,6,"$rm31","$rmc",1,"R");
$pdf->Cell(101,9," ","0",0,"R");$pdf->Cell(24,9,"$r32","$rmc",0,"R");$pdf->Cell(19,9,"$rk32","$rmc",0,"R");$pdf->Cell(20,9,"$rn32","$rmc",0,"R");
$pdf->Cell(29,9,"$rm32","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,6,"$r33","$rmc",0,"R");$pdf->Cell(19,6,"$rk33","$rmc",0,"R");$pdf->Cell(20,6,"$rn33","$rmc",0,"R");
$pdf->Cell(29,6,"$rm33","$rmc",1,"R");
$pdf->Cell(101,5," ","0",0,"R");$pdf->Cell(24,6,"$r34","$rmc",0,"R");$pdf->Cell(19,6,"$rk34","$rmc",0,"R");$pdf->Cell(20,6,"$rn34","$rmc",0,"R");
$pdf->Cell(29,6,"$rm34","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r35","$rmc",0,"R");$pdf->Cell(19,6,"$rk35","$rmc",0,"R");$pdf->Cell(20,6,"$rn35","$rmc",0,"R");
$pdf->Cell(29,6,"$rm35","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,7,"$r36","$rmc",0,"R");$pdf->Cell(19,7,"$rk36","$rmc",0,"R");$pdf->Cell(20,7,"$rn36","$rmc",0,"R");
$pdf->Cell(29,7,"$rm36","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r37","$rmc",0,"R");$pdf->Cell(19,6,"$rk37","$rmc",0,"R");$pdf->Cell(20,6,"$rn37","$rmc",0,"R");
$pdf->Cell(29,6,"$rm37","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r38","$rmc",0,"R");$pdf->Cell(19,8,"$rk38","$rmc",0,"R");$pdf->Cell(20,8,"$rn38","$rmc",0,"R");
$pdf->Cell(29,8,"$rm38","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r39","$rmc",0,"R");$pdf->Cell(19,6,"$rk39","$rmc",0,"R");$pdf->Cell(20,6,"$rn39","$rmc",0,"R");
$pdf->Cell(29,6,"$rm39","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r40","$rmc",0,"R");$pdf->Cell(19,7,"$rk40","$rmc",0,"R");$pdf->Cell(20,7,"$rn40","$rmc",0,"R");
$pdf->Cell(29,7,"$rm40","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r41","$rmc",0,"R");$pdf->Cell(19,8,"$rk41","$rmc",0,"R");$pdf->Cell(20,8,"$rn41","$rmc",0,"R");
$pdf->Cell(29,8,"$rm41","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r42","$rmc",0,"R");$pdf->Cell(19,6,"$rk42","$rmc",0,"R");$pdf->Cell(20,6,"$rn42","$rmc",0,"R");
$pdf->Cell(29,6,"$rm42","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r43","$rmc",0,"R");$pdf->Cell(19,8,"$rk43","$rmc",0,"R");$pdf->Cell(20,8,"$rn43","$rmc",0,"R");
$pdf->Cell(29,8,"$rm43","$rmc",1,"R");
$pdf->Cell(101,5," ","0",0,"R");$pdf->Cell(24,5,"$r44","$rmc",0,"R");$pdf->Cell(19,5,"$rk44","$rmc",0,"R");$pdf->Cell(20,5,"$rn44","$rmc",0,"R");
$pdf->Cell(29,5,"$rm44","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,9,"$r45","$rmc",0,"R");$pdf->Cell(19,9,"$rk45","$rmc",0,"R");$pdf->Cell(20,9,"$rn45","$rmc",0,"R");
$pdf->Cell(29,9,"$rm45","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r46","$rmc",0,"R");$pdf->Cell(19,8,"$rk46","$rmc",0,"R");$pdf->Cell(20,8,"$rn46","$rmc",0,"R");
$pdf->Cell(29,8,"$rm46","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r47","$rmc",0,"R");$pdf->Cell(19,8,"$rk47","$rmc",0,"R");$pdf->Cell(20,8,"$rn47","$rmc",0,"R");
$pdf->Cell(29,8,"$rm47","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,7,"$r48","$rmc",0,"R");$pdf->Cell(19,7,"$rk48","$rmc",0,"R");$pdf->Cell(20,7,"$rn48","$rmc",0,"R");
$pdf->Cell(29,7,"$rm48","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r49","$rmc",0,"R");$pdf->Cell(19,6,"$rk49","$rmc",0,"R");$pdf->Cell(20,6,"$rn49","$rmc",0,"R");
$pdf->Cell(29,6,"$rm49","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,8,"$r50","$rmc",0,"R");$pdf->Cell(19,8,"$rk50","$rmc",0,"R");$pdf->Cell(20,8,"$rn50","$rmc",0,"R");
$pdf->Cell(29,8,"$rm50","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r51","$rmc",0,"R");$pdf->Cell(19,6,"$rk51","$rmc",0,"R");$pdf->Cell(20,6,"$rn51","$rmc",0,"R");
$pdf->Cell(29,6,"$rm51","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r52","$rmc",0,"R");$pdf->Cell(19,7,"$rk52","$rmc",0,"R");$pdf->Cell(20,7,"$rn52","$rmc",0,"R");
$pdf->Cell(29,7,"$rm52","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,6,"$r53","$rmc",0,"R");$pdf->Cell(19,6,"$rk53","$rmc",0,"R");$pdf->Cell(20,6,"$rn53","$rmc",0,"R");
$pdf->Cell(29,6,"$rm53","$rmc",1,"R");
$pdf->Cell(101,8," ","0",0,"R");$pdf->Cell(24,8,"$r54","$rmc",0,"R");$pdf->Cell(19,8,"$rk54","$rmc",0,"R");$pdf->Cell(20,8,"$rn54","$rmc",0,"R");
$pdf->Cell(29,8,"$rm54","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r55","$rmc",0,"R");$pdf->Cell(19,7,"$rk55","$rmc",0,"R");$pdf->Cell(20,7,"$rn55","$rmc",0,"R");
$pdf->Cell(29,7,"$rm55","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r56","$rmc",0,"R");$pdf->Cell(19,7,"$rk56","$rmc",0,"R");$pdf->Cell(20,7,"$rn56","$rmc",0,"R");
$pdf->Cell(29,7,"$rm56","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r57","$rmc",0,"R");$pdf->Cell(19,6,"$rk57","$rmc",0,"R");$pdf->Cell(20,6,"$rn57","$rmc",0,"R");
$pdf->Cell(29,6,"$rm57","$rmc",1,"R");
$pdf->Cell(101,4," ","0",0,"R");$pdf->Cell(24,5,"$r58","$rmc",0,"R");$pdf->Cell(19,5,"$rk58","$rmc",0,"R");$pdf->Cell(20,5,"$rn58","$rmc",0,"R");
$pdf->Cell(29,5,"$rm58","$rmc",1,"R");
$pdf->Cell(101,6," ","0",0,"R");$pdf->Cell(24,6,"$r59","$rmc",0,"R");$pdf->Cell(19,6,"$rk59","$rmc",0,"R");$pdf->Cell(20,6,"$rn59","$rmc",0,"R");
$pdf->Cell(29,6,"$rm59","$rmc",1,"R");
$pdf->Cell(101,7," ","0",0,"R");$pdf->Cell(24,7,"$r60","$rmc",0,"R");$pdf->Cell(19,7,"$rk60","$rmc",0,"R");$pdf->Cell(20,7,"$rn60","$rmc",0,"R");
$pdf->Cell(29,7,"$rm60","$rmc",1,"R");




}
$i = $i + 1;
  }
//koniec while suvaha

//vytlac
//$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid." WHERE prx = 1 ".""; 
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocvziskovno_stl".
" ON F$kli_vxcf"."_prcvykziss$kli_uzid.prx=F$kli_vxcf"."_uctpocvziskovno_stl.fic".
" WHERE prx = 1 "."";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

//V MUJ 2014 POUZIVAME LEN STLPCE r01 az r38 a rm01 az rm38

$r01=$hlavicka->r01; if ( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02; if ( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03; if ( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04; if ( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05; if ( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06; if ( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07; if ( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08; if ( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09; if ( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10; if ( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11; if ( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12; if ( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13; if ( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14; if ( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15; if ( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16; if ( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17; if ( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18; if ( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19; if ( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20; if ( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21; if ( $hlavicka->r21 == 0 ) $r21="";
$r22=$hlavicka->r22; if ( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23; if ( $hlavicka->r23 == 0 ) $r23="";
$r24=$hlavicka->r24; if ( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25; if ( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26; if ( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27; if ( $hlavicka->r27 == 0 ) $r27="";
$r28=$hlavicka->r28; if ( $hlavicka->r28 == 0 ) $r28="";
$r29=$hlavicka->r29; if ( $hlavicka->r29 == 0 ) $r29="";
$r30=$hlavicka->r30; if ( $hlavicka->r30 == 0 ) $r30="";
$r31=$hlavicka->r31; if ( $hlavicka->r31 == 0 ) $r31="";
$r32=$hlavicka->r32; if ( $hlavicka->r32 == 0 ) $r32="";
$r33=$hlavicka->r33; if ( $hlavicka->r33 == 0 ) $r33="";
$r34=$hlavicka->r34; if ( $hlavicka->r34 == 0 ) $r34="";
$r35=$hlavicka->r35; if ( $hlavicka->r35 == 0 ) $r35="";
$r36=$hlavicka->r36; if ( $hlavicka->r36 == 0 ) $r36="";
$r37=$hlavicka->r37; if ( $hlavicka->r37 == 0 ) $r37="";
$r38=$hlavicka->r38; if ( $hlavicka->r38 == 0 ) $r38="";
$r39=$hlavicka->r39; if ( $hlavicka->r39 == 0 ) $r39="";
$r40=$hlavicka->r40; if ( $hlavicka->r40 == 0 ) $r40="";
$r41=$hlavicka->r41; if ( $hlavicka->r41 == 0 ) $r41="";
$r42=$hlavicka->r42; if ( $hlavicka->r42 == 0 ) $r42="";
$r43=$hlavicka->r43; if ( $hlavicka->r43 == 0 ) $r43="";
$r44=$hlavicka->r44; if ( $hlavicka->r44 == 0 ) $r44="";
$r45=$hlavicka->r45; if ( $hlavicka->r45 == 0 ) $r45="";
$r46=$hlavicka->r46; if ( $hlavicka->r46 == 0 ) $r46="";
$r47=$hlavicka->r47; if ( $hlavicka->r47 == 0 ) $r47="";
$r48=$hlavicka->r48; if ( $hlavicka->r48 == 0 ) $r48="";
$r49=$hlavicka->r49; if ( $hlavicka->r49 == 0 ) $r49="";
$r50=$hlavicka->r50; if ( $hlavicka->r50 == 0 ) $r50="";
$r51=$hlavicka->r51; if ( $hlavicka->r51 == 0 ) $r51="";
$r52=$hlavicka->r52; if ( $hlavicka->r52 == 0 ) $r52="";
$r53=$hlavicka->r53; if ( $hlavicka->r53 == 0 ) $r53="";
$r54=$hlavicka->r54; if ( $hlavicka->r54 == 0 ) $r54="";
$r55=$hlavicka->r55; if ( $hlavicka->r55 == 0 ) $r55="";
$r56=$hlavicka->r56; if ( $hlavicka->r56 == 0 ) $r56="";
$r57=$hlavicka->r57; if ( $hlavicka->r57 == 0 ) $r57="";
$r58=$hlavicka->r58; if ( $hlavicka->r58 == 0 ) $r58="";
$r59=$hlavicka->r59; if ( $hlavicka->r59 == 0 ) $r59="";
$r60=$hlavicka->r60; if ( $hlavicka->r60 == 0 ) $r60="";
$r61=$hlavicka->r61; if ( $hlavicka->r61 == 0 ) $r61="";
$r62=$hlavicka->r62; if ( $hlavicka->r62 == 0 ) $r62="";
$r63=$hlavicka->r63; if ( $hlavicka->r63 == 0 ) $r63="";
$r64=$hlavicka->r64; if ( $hlavicka->r64 == 0 ) $r64="";
$r65=$hlavicka->r65; if ( $hlavicka->r65 == 0 ) $r65="";
$r66=$hlavicka->r66; if ( $hlavicka->r66 == 0 ) $r66="";
$r67=$hlavicka->r67; if ( $hlavicka->r67 == 0 ) $r67="";
$r68=$hlavicka->r68; if ( $hlavicka->r68 == 0 ) $r68="";
$r69=$hlavicka->r69; if ( $hlavicka->r69 == 0 ) $r69="";
$r70=$hlavicka->r70; if ( $hlavicka->r70 == 0 ) $r70="";
$r71=$hlavicka->r71; if ( $hlavicka->r71 == 0 ) $r71="";
$r72=$hlavicka->r72; if ( $hlavicka->r72 == 0 ) $r72="";
$r73=$hlavicka->r73; if ( $hlavicka->r73 == 0 ) $r73="";
$r74=$hlavicka->r74; if ( $hlavicka->r74 == 0 ) $r74="";
$r75=$hlavicka->r75; if ( $hlavicka->r75 == 0 ) $r75="";
$r76=$hlavicka->r76; if ( $hlavicka->r76 == 0 ) $r76="";
$r77=$hlavicka->r77; if ( $hlavicka->r77 == 0 ) $r77="";
$r78=$hlavicka->r78; if ( $hlavicka->r78 == 0 ) $r78="";
$r994=$hlavicka->r994; if ( $hlavicka->r994 == 0 ) $r994="";
$r995=$hlavicka->r995; if ( $hlavicka->r995 == 0 ) $r995="";

$rpc01=$hlavicka->rpc01; if ( $hlavicka->rpc01 == 0 ) $rpc01="";
$rpc02=$hlavicka->rpc02; if ( $hlavicka->rpc02 == 0 ) $rpc02="";
$rpc03=$hlavicka->rpc03; if ( $hlavicka->rpc03 == 0 ) $rpc03="";
$rpc04=$hlavicka->rpc04; if ( $hlavicka->rpc04 == 0 ) $rpc04="";
$rpc05=$hlavicka->rpc05; if ( $hlavicka->rpc05 == 0 ) $rpc05="";
$rpc06=$hlavicka->rpc06; if ( $hlavicka->rpc06 == 0 ) $rpc06="";
$rpc07=$hlavicka->rpc07; if ( $hlavicka->rpc07 == 0 ) $rpc07="";
$rpc08=$hlavicka->rpc08; if ( $hlavicka->rpc08 == 0 ) $rpc08="";
$rpc09=$hlavicka->rpc09; if ( $hlavicka->rpc09 == 0 ) $rpc09="";
$rpc10=$hlavicka->rpc10; if ( $hlavicka->rpc10 == 0 ) $rpc10="";
$rpc11=$hlavicka->rpc11; if ( $hlavicka->rpc11 == 0 ) $rpc11="";
$rpc12=$hlavicka->rpc12; if ( $hlavicka->rpc12 == 0 ) $rpc12="";
$rpc13=$hlavicka->rpc13; if ( $hlavicka->rpc13 == 0 ) $rpc13="";
$rpc14=$hlavicka->rpc14; if ( $hlavicka->rpc14 == 0 ) $rpc14="";
$rpc15=$hlavicka->rpc15; if ( $hlavicka->rpc15 == 0 ) $rpc15="";
$rpc16=$hlavicka->rpc16; if ( $hlavicka->rpc16 == 0 ) $rpc16="";
$rpc17=$hlavicka->rpc17; if ( $hlavicka->rpc17 == 0 ) $rpc17="";
$rpc18=$hlavicka->rpc18; if ( $hlavicka->rpc18 == 0 ) $rpc18="";
$rpc19=$hlavicka->rpc19; if ( $hlavicka->rpc19 == 0 ) $rpc19="";
$rpc20=$hlavicka->rpc20; if ( $hlavicka->rpc20 == 0 ) $rpc20="";
$rpc21=$hlavicka->rpc21; if ( $hlavicka->rpc21 == 0 ) $rpc21="";
$rpc22=$hlavicka->rpc22; if ( $hlavicka->rpc22 == 0 ) $rpc22="";
$rpc23=$hlavicka->rpc23; if ( $hlavicka->rpc23 == 0 ) $rpc23="";
$rpc24=$hlavicka->rpc24; if ( $hlavicka->rpc24 == 0 ) $rpc24="";
$rpc25=$hlavicka->rpc25; if ( $hlavicka->rpc25 == 0 ) $rpc25="";
$rpc26=$hlavicka->rpc26; if ( $hlavicka->rpc26 == 0 ) $rpc26="";
$rpc27=$hlavicka->rpc27; if ( $hlavicka->rpc27 == 0 ) $rpc27="";
$rpc28=$hlavicka->rpc28; if ( $hlavicka->rpc28 == 0 ) $rpc28="";
$rpc29=$hlavicka->rpc29; if ( $hlavicka->rpc29 == 0 ) $rpc29="";
$rpc30=$hlavicka->rpc30; if ( $hlavicka->rpc30 == 0 ) $rpc30="";
$rpc31=$hlavicka->rpc31; if ( $hlavicka->rpc31 == 0 ) $rpc31="";
$rpc32=$hlavicka->rpc32; if ( $hlavicka->rpc32 == 0 ) $rpc32="";
$rpc33=$hlavicka->rpc33; if ( $hlavicka->rpc33 == 0 ) $rpc33="";
$rpc34=$hlavicka->rpc34; if ( $hlavicka->rpc34 == 0 ) $rpc34="";
$rpc35=$hlavicka->rpc35; if ( $hlavicka->rpc35 == 0 ) $rpc35="";
$rpc36=$hlavicka->rpc36; if ( $hlavicka->rpc36 == 0 ) $rpc36="";
$rpc37=$hlavicka->rpc37; if ( $hlavicka->rpc37 == 0 ) $rpc37="";
$rpc38=$hlavicka->rpc38; if ( $hlavicka->rpc38 == 0 ) $rpc38="";
$rpc39=$hlavicka->rpc39; if ( $hlavicka->rpc39 == 0 ) $rpc39="";
$rpc40=$hlavicka->rpc40; if ( $hlavicka->rpc40 == 0 ) $rpc40="";
$rpc41=$hlavicka->rpc41; if ( $hlavicka->rpc41 == 0 ) $rpc41="";
$rpc42=$hlavicka->rpc42; if ( $hlavicka->rpc42 == 0 ) $rpc42="";
$rpc43=$hlavicka->rpc43; if ( $hlavicka->rpc43 == 0 ) $rpc43="";
$rpc44=$hlavicka->rpc44; if ( $hlavicka->rpc44 == 0 ) $rpc44="";
$rpc45=$hlavicka->rpc45; if ( $hlavicka->rpc45 == 0 ) $rpc45="";
$rpc46=$hlavicka->rpc46; if ( $hlavicka->rpc46 == 0 ) $rpc46="";
$rpc47=$hlavicka->rpc47; if ( $hlavicka->rpc47 == 0 ) $rpc47="";
$rpc48=$hlavicka->rpc48; if ( $hlavicka->rpc48 == 0 ) $rpc48="";
$rpc49=$hlavicka->rpc49; if ( $hlavicka->rpc49 == 0 ) $rpc49="";
$rpc50=$hlavicka->rpc50; if ( $hlavicka->rpc50 == 0 ) $rpc50="";
$rpc51=$hlavicka->rpc51; if ( $hlavicka->rpc51 == 0 ) $rpc51="";
$rpc52=$hlavicka->rpc52; if ( $hlavicka->rpc52 == 0 ) $rpc52="";
$rpc53=$hlavicka->rpc53; if ( $hlavicka->rpc53 == 0 ) $rpc53="";
$rpc54=$hlavicka->rpc54; if ( $hlavicka->rpc54 == 0 ) $rpc54="";
$rpc55=$hlavicka->rpc55; if ( $hlavicka->rpc55 == 0 ) $rpc55="";
$rpc56=$hlavicka->rpc56; if ( $hlavicka->rpc56 == 0 ) $rpc56="";
$rpc57=$hlavicka->rpc57; if ( $hlavicka->rpc57 == 0 ) $rpc57="";
$rpc58=$hlavicka->rpc58; if ( $hlavicka->rpc58 == 0 ) $rpc58="";
$rpc59=$hlavicka->rpc59; if ( $hlavicka->rpc59 == 0 ) $rpc59="";
$rpc60=$hlavicka->rpc60; if ( $hlavicka->rpc60 == 0 ) $rpc60="";
$rpc61=$hlavicka->rpc61; if ( $hlavicka->rpc61 == 0 ) $rpc61="";
$rpc62=$hlavicka->rpc62; if ( $hlavicka->rpc62 == 0 ) $rpc62="";
$rpc63=$hlavicka->rpc63; if ( $hlavicka->rpc63 == 0 ) $rpc63="";
$rpc64=$hlavicka->rpc64; if ( $hlavicka->rpc64 == 0 ) $rpc64="";
$rpc65=$hlavicka->rpc65; if ( $hlavicka->rpc65 == 0 ) $rpc65="";
$rpc66=$hlavicka->rpc66; if ( $hlavicka->rpc66 == 0 ) $rpc66="";
$rpc67=$hlavicka->rpc67; if ( $hlavicka->rpc67 == 0 ) $rpc67="";
$rpc68=$hlavicka->rpc68; if ( $hlavicka->rpc68 == 0 ) $rpc68="";
$rpc69=$hlavicka->rpc69; if ( $hlavicka->rpc69 == 0 ) $rpc69="";
$rpc70=$hlavicka->rpc70; if ( $hlavicka->rpc70 == 0 ) $rpc70="";
$rpc71=$hlavicka->rpc71; if ( $hlavicka->rpc71 == 0 ) $rpc71="";
$rpc72=$hlavicka->rpc72; if ( $hlavicka->rpc72 == 0 ) $rpc72="";
$rpc73=$hlavicka->rpc73; if ( $hlavicka->rpc73 == 0 ) $rpc73="";
$rpc74=$hlavicka->rpc74; if ( $hlavicka->rpc74 == 0 ) $rpc74="";
$rpc75=$hlavicka->rpc75; if ( $hlavicka->rpc75 == 0 ) $rpc75="";
$rpc76=$hlavicka->rpc76; if ( $hlavicka->rpc76 == 0 ) $rpc76="";
$rpc77=$hlavicka->rpc77; if ( $hlavicka->rpc77 == 0 ) $rpc77="";
$rpc78=$hlavicka->rpc78; if ( $hlavicka->rpc78 == 0 ) $rpc78="";
$rpc994=$hlavicka->rpc994; if ( $hlavicka->rpc994 == 0 ) $rpc994="";
$rpc995=$hlavicka->rpc995; if ( $hlavicka->rpc995 == 0 ) $rpc995="";

$rsp01=$hlavicka->rsp01; if ( $hlavicka->rsp01 == 0 ) $rsp01="";
$rsp02=$hlavicka->rsp02; if ( $hlavicka->rsp02 == 0 ) $rsp02="";
$rsp03=$hlavicka->rsp03; if ( $hlavicka->rsp03 == 0 ) $rsp03="";
$rsp04=$hlavicka->rsp04; if ( $hlavicka->rsp04 == 0 ) $rsp04="";
$rsp05=$hlavicka->rsp05; if ( $hlavicka->rsp05 == 0 ) $rsp05="";
$rsp06=$hlavicka->rsp06; if ( $hlavicka->rsp06 == 0 ) $rsp06="";
$rsp07=$hlavicka->rsp07; if ( $hlavicka->rsp07 == 0 ) $rsp07="";
$rsp08=$hlavicka->rsp08; if ( $hlavicka->rsp08 == 0 ) $rsp08="";
$rsp09=$hlavicka->rsp09; if ( $hlavicka->rsp09 == 0 ) $rsp09="";
$rsp10=$hlavicka->rsp10; if ( $hlavicka->rsp10 == 0 ) $rsp10="";
$rsp11=$hlavicka->rsp11; if ( $hlavicka->rsp11 == 0 ) $rsp11="";
$rsp12=$hlavicka->rsp12; if ( $hlavicka->rsp12 == 0 ) $rsp12="";
$rsp13=$hlavicka->rsp13; if ( $hlavicka->rsp13 == 0 ) $rsp13="";
$rsp14=$hlavicka->rsp14; if ( $hlavicka->rsp14 == 0 ) $rsp14="";
$rsp15=$hlavicka->rsp15; if ( $hlavicka->rsp15 == 0 ) $rsp15="";
$rsp16=$hlavicka->rsp16; if ( $hlavicka->rsp16 == 0 ) $rsp16="";
$rsp17=$hlavicka->rsp17; if ( $hlavicka->rsp17 == 0 ) $rsp17="";
$rsp18=$hlavicka->rsp18; if ( $hlavicka->rsp18 == 0 ) $rsp18="";
$rsp19=$hlavicka->rsp19; if ( $hlavicka->rsp19 == 0 ) $rsp19="";
$rsp20=$hlavicka->rsp20; if ( $hlavicka->rsp20 == 0 ) $rsp20="";
$rsp21=$hlavicka->rsp21; if ( $hlavicka->rsp21 == 0 ) $rsp21="";
$rsp22=$hlavicka->rsp22; if ( $hlavicka->rsp22 == 0 ) $rsp22="";
$rsp23=$hlavicka->rsp23; if ( $hlavicka->rsp23 == 0 ) $rsp23="";
$rsp24=$hlavicka->rsp24; if ( $hlavicka->rsp24 == 0 ) $rsp24="";
$rsp25=$hlavicka->rsp25; if ( $hlavicka->rsp25 == 0 ) $rsp25="";
$rsp26=$hlavicka->rsp26; if ( $hlavicka->rsp26 == 0 ) $rsp26="";
$rsp27=$hlavicka->rsp27; if ( $hlavicka->rsp27 == 0 ) $rsp27="";
$rsp28=$hlavicka->rsp28; if ( $hlavicka->rsp28 == 0 ) $rsp28="";
$rsp29=$hlavicka->rsp29; if ( $hlavicka->rsp29 == 0 ) $rsp29="";
$rsp30=$hlavicka->rsp30; if ( $hlavicka->rsp30 == 0 ) $rsp30="";
$rsp31=$hlavicka->rsp31; if ( $hlavicka->rsp31 == 0 ) $rsp31="";
$rsp32=$hlavicka->rsp32; if ( $hlavicka->rsp32 == 0 ) $rsp32="";
$rsp33=$hlavicka->rsp33; if ( $hlavicka->rsp33 == 0 ) $rsp33="";
$rsp34=$hlavicka->rsp34; if ( $hlavicka->rsp34 == 0 ) $rsp34="";
$rsp35=$hlavicka->rsp35; if ( $hlavicka->rsp35 == 0 ) $rsp35="";
$rsp36=$hlavicka->rsp36; if ( $hlavicka->rsp36 == 0 ) $rsp36="";
$rsp37=$hlavicka->rsp37; if ( $hlavicka->rsp37 == 0 ) $rsp37="";
$rsp38=$hlavicka->rsp38; if ( $hlavicka->rsp38 == 0 ) $rsp38="";
$rsp39=$hlavicka->rsp39; if ( $hlavicka->rsp39 == 0 ) $rsp39="";
$rsp40=$hlavicka->rsp40; if ( $hlavicka->rsp40 == 0 ) $rsp40="";
$rsp41=$hlavicka->rsp41; if ( $hlavicka->rsp41 == 0 ) $rsp41="";
$rsp42=$hlavicka->rsp42; if ( $hlavicka->rsp42 == 0 ) $rsp42="";
$rsp43=$hlavicka->rsp43; if ( $hlavicka->rsp43 == 0 ) $rsp43="";
$rsp44=$hlavicka->rsp44; if ( $hlavicka->rsp44 == 0 ) $rsp44="";
$rsp45=$hlavicka->rsp45; if ( $hlavicka->rsp45 == 0 ) $rsp45="";
$rsp46=$hlavicka->rsp46; if ( $hlavicka->rsp46 == 0 ) $rsp46="";
$rsp47=$hlavicka->rsp47; if ( $hlavicka->rsp47 == 0 ) $rsp47="";
$rsp48=$hlavicka->rsp48; if ( $hlavicka->rsp48 == 0 ) $rsp48="";
$rsp49=$hlavicka->rsp49; if ( $hlavicka->rsp49 == 0 ) $rsp49="";
$rsp50=$hlavicka->rsp50; if ( $hlavicka->rsp50 == 0 ) $rsp50="";
$rsp51=$hlavicka->rsp51; if ( $hlavicka->rsp51 == 0 ) $rsp51="";
$rsp52=$hlavicka->rsp52; if ( $hlavicka->rsp52 == 0 ) $rsp52="";
$rsp53=$hlavicka->rsp53; if ( $hlavicka->rsp53 == 0 ) $rsp53="";
$rsp54=$hlavicka->rsp54; if ( $hlavicka->rsp54 == 0 ) $rsp54="";
$rsp55=$hlavicka->rsp55; if ( $hlavicka->rsp55 == 0 ) $rsp55="";
$rsp56=$hlavicka->rsp56; if ( $hlavicka->rsp56 == 0 ) $rsp56="";
$rsp57=$hlavicka->rsp57; if ( $hlavicka->rsp57 == 0 ) $rsp57="";
$rsp58=$hlavicka->rsp58; if ( $hlavicka->rsp58 == 0 ) $rsp58="";
$rsp59=$hlavicka->rsp59; if ( $hlavicka->rsp59 == 0 ) $rsp59="";
$rsp60=$hlavicka->rsp60; if ( $hlavicka->rsp60 == 0 ) $rsp60="";
$rsp61=$hlavicka->rsp61; if ( $hlavicka->rsp61 == 0 ) $rsp61="";
$rsp62=$hlavicka->rsp62; if ( $hlavicka->rsp62 == 0 ) $rsp62="";
$rsp63=$hlavicka->rsp63; if ( $hlavicka->rsp63 == 0 ) $rsp63="";
$rsp64=$hlavicka->rsp64; if ( $hlavicka->rsp64 == 0 ) $rsp64="";
$rsp65=$hlavicka->rsp65; if ( $hlavicka->rsp65 == 0 ) $rsp65="";
$rsp66=$hlavicka->rsp66; if ( $hlavicka->rsp66 == 0 ) $rsp66="";
$rsp67=$hlavicka->rsp67; if ( $hlavicka->rsp67 == 0 ) $rsp67="";
$rsp68=$hlavicka->rsp68; if ( $hlavicka->rsp68 == 0 ) $rsp68="";
$rsp69=$hlavicka->rsp69; if ( $hlavicka->rsp69 == 0 ) $rsp69="";
$rsp70=$hlavicka->rsp70; if ( $hlavicka->rsp70 == 0 ) $rsp70="";
$rsp71=$hlavicka->rsp71; if ( $hlavicka->rsp71 == 0 ) $rsp71="";
$rsp72=$hlavicka->rsp72; if ( $hlavicka->rsp72 == 0 ) $rsp72="";
$rsp73=$hlavicka->rsp73; if ( $hlavicka->rsp73 == 0 ) $rsp73="";
$rsp74=$hlavicka->rsp74; if ( $hlavicka->rsp74 == 0 ) $rsp74="";
$rsp75=$hlavicka->rsp75; if ( $hlavicka->rsp75 == 0 ) $rsp75="";
$rsp76=$hlavicka->rsp76; if ( $hlavicka->rsp76 == 0 ) $rsp76="";
$rsp77=$hlavicka->rsp77; if ( $hlavicka->rsp77 == 0 ) $rsp77="";
$rsp78=$hlavicka->rsp78; if ( $hlavicka->rsp78 == 0 ) $rsp78="";
$rsp994=$hlavicka->rsp994; if ( $hlavicka->rsp994 == 0 ) $rsp994="";
$rsp995=$hlavicka->rsp995; if ( $hlavicka->rsp995 == 0 ) $rsp995="";

$rm01=$hlavicka->rm01; if ( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02; if ( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03; if ( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04; if ( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05; if ( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06; if ( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07; if ( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08; if ( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09; if ( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10; if ( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11; if ( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12; if ( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13; if ( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14; if ( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15; if ( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16; if ( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17; if ( $hlavicka->rm17 == 0 ) $rm17="";
$rm18=$hlavicka->rm18; if ( $hlavicka->rm18 == 0 ) $rm18="";
$rm19=$hlavicka->rm19; if ( $hlavicka->rm19 == 0 ) $rm19="";
$rm20=$hlavicka->rm20; if ( $hlavicka->rm20 == 0 ) $rm20="";
$rm21=$hlavicka->rm21; if ( $hlavicka->rm21 == 0 ) $rm21="";
$rm22=$hlavicka->rm22; if ( $hlavicka->rm22 == 0 ) $rm22="";
$rm23=$hlavicka->rm23; if ( $hlavicka->rm23 == 0 ) $rm23="";
$rm24=$hlavicka->rm24; if ( $hlavicka->rm24 == 0 ) $rm24="";
$rm25=$hlavicka->rm25; if ( $hlavicka->rm25 == 0 ) $rm25="";
$rm26=$hlavicka->rm26; if ( $hlavicka->rm26 == 0 ) $rm26="";
$rm27=$hlavicka->rm27; if ( $hlavicka->rm27 == 0 ) $rm27="";
$rm28=$hlavicka->rm28; if ( $hlavicka->rm28 == 0 ) $rm28="";
$rm29=$hlavicka->rm29; if ( $hlavicka->rm29 == 0 ) $rm29="";
$rm30=$hlavicka->rm30; if ( $hlavicka->rm30 == 0 ) $rm30="";
$rm31=$hlavicka->rm31; if ( $hlavicka->rm31 == 0 ) $rm31="";
$rm32=$hlavicka->rm32; if ( $hlavicka->rm32 == 0 ) $rm32="";
$rm33=$hlavicka->rm33; if ( $hlavicka->rm33 == 0 ) $rm33="";
$rm34=$hlavicka->rm34; if ( $hlavicka->rm34 == 0 ) $rm34="";
$rm35=$hlavicka->rm35; if ( $hlavicka->rm35 == 0 ) $rm35="";
$rm36=$hlavicka->rm36; if ( $hlavicka->rm36 == 0 ) $rm36="";
$rm37=$hlavicka->rm37; if ( $hlavicka->rm37 == 0 ) $rm37="";
$rm38=$hlavicka->rm38; if ( $hlavicka->rm38 == 0 ) $rm38="";
$rm39=$hlavicka->rm39; if ( $hlavicka->rm39 == 0 ) $rm39="";
$rm40=$hlavicka->rm40; if ( $hlavicka->rm40 == 0 ) $rm40="";
$rm41=$hlavicka->rm41; if ( $hlavicka->rm41 == 0 ) $rm41="";
$rm42=$hlavicka->rm42; if ( $hlavicka->rm42 == 0 ) $rm42="";
$rm43=$hlavicka->rm43; if ( $hlavicka->rm43 == 0 ) $rm43="";
$rm44=$hlavicka->rm44; if ( $hlavicka->rm44 == 0 ) $rm44="";
$rm45=$hlavicka->rm45; if ( $hlavicka->rm45 == 0 ) $rm45="";
$rm46=$hlavicka->rm46; if ( $hlavicka->rm46 == 0 ) $rm46="";
$rm47=$hlavicka->rm47; if ( $hlavicka->rm47 == 0 ) $rm47="";
$rm48=$hlavicka->rm48; if ( $hlavicka->rm48 == 0 ) $rm48="";
$rm49=$hlavicka->rm49; if ( $hlavicka->rm49 == 0 ) $rm49="";
$rm50=$hlavicka->rm50; if ( $hlavicka->rm50 == 0 ) $rm50="";
$rm51=$hlavicka->rm51; if ( $hlavicka->rm51 == 0 ) $rm51="";
$rm52=$hlavicka->rm52; if ( $hlavicka->rm52 == 0 ) $rm52="";
$rm53=$hlavicka->rm53; if ( $hlavicka->rm53 == 0 ) $rm53="";
$rm54=$hlavicka->rm54; if ( $hlavicka->rm54 == 0 ) $rm54="";
$rm55=$hlavicka->rm55; if ( $hlavicka->rm55 == 0 ) $rm55="";
$rm56=$hlavicka->rm56; if ( $hlavicka->rm56 == 0 ) $rm56="";
$rm57=$hlavicka->rm57; if ( $hlavicka->rm57 == 0 ) $rm57="";
$rm58=$hlavicka->rm58; if ( $hlavicka->rm58 == 0 ) $rm58="";
$rm59=$hlavicka->rm59; if ( $hlavicka->rm59 == 0 ) $rm59="";
$rm60=$hlavicka->rm60; if ( $hlavicka->rm60 == 0 ) $rm60="";
$rm61=$hlavicka->rm61; if ( $hlavicka->rm61 == 0 ) $rm61="";
$rm62=$hlavicka->rm62; if ( $hlavicka->rm62 == 0 ) $rm62="";
$rm63=$hlavicka->rm63; if ( $hlavicka->rm63 == 0 ) $rm63="";
$rm64=$hlavicka->rm64; if ( $hlavicka->rm64 == 0 ) $rm64="";
$rm65=$hlavicka->rm65; if ( $hlavicka->rm65 == 0 ) $rm65="";
$rm66=$hlavicka->rm66; if ( $hlavicka->rm66 == 0 ) $rm66="";
$rm67=$hlavicka->rm67; if ( $hlavicka->rm67 == 0 ) $rm67="";
$rm68=$hlavicka->rm68; if ( $hlavicka->rm68 == 0 ) $rm68="";
$rm69=$hlavicka->rm69; if ( $hlavicka->rm69 == 0 ) $rm69="";
$rm70=$hlavicka->rm70; if ( $hlavicka->rm70 == 0 ) $rm70="";
$rm71=$hlavicka->rm71; if ( $hlavicka->rm71 == 0 ) $rm71="";
$rm72=$hlavicka->rm72; if ( $hlavicka->rm72 == 0 ) $rm72="";
$rm73=$hlavicka->rm73; if ( $hlavicka->rm73 == 0 ) $rm73="";
$rm74=$hlavicka->rm74; if ( $hlavicka->rm74 == 0 ) $rm74="";
$rm75=$hlavicka->rm75; if ( $hlavicka->rm75 == 0 ) $rm75="";
$rm76=$hlavicka->rm76; if ( $hlavicka->rm76 == 0 ) $rm76="";
$rm77=$hlavicka->rm77; if ( $hlavicka->rm77 == 0 ) $rm77="";
$rm78=$hlavicka->rm78; if ( $hlavicka->rm78 == 0 ) $rm78="";
$rm994=$hlavicka->rm104; if ( $hlavicka->rm104 == 0 ) $rm994="";
$rm995=$hlavicka->rm105; if ( $hlavicka->rm105 == 0 ) $rm995="";

//ak je ps 0.00 zadany daj 0.00
$sqlttm = "SELECT * FROM F$kli_vxcf"."_uctpocvziskovno WHERE dok > 0 AND hod = 0 ORDER BY dok";
$sqlm = mysql_query("$sqlttm");
if($sqlm){ $polm = mysql_num_rows($sqlm); }
$im=0;
  while ($im <= $polm )
  {
  if (@$zaznam=mysql_data_seek($sqlm,$im))
{
$hlavickam=mysql_fetch_object($sqlm);

if( $hlavickam->dok ==  1 ) { $rm01="0.00"; }
if( $hlavickam->dok ==  2 ) { $rm02="0.00"; }
if( $hlavickam->dok ==  3 ) { $rm03="0.00"; }
if( $hlavickam->dok ==  4 ) { $rm04="0.00"; }
if( $hlavickam->dok ==  5 ) { $rm05="0.00"; }
if( $hlavickam->dok ==  6 ) { $rm06="0.00"; }
if( $hlavickam->dok ==  7 ) { $rm07="0.00"; }
if( $hlavickam->dok ==  8 ) { $rm08="0.00"; }
if( $hlavickam->dok ==  9 ) { $rm09="0.00"; }
if( $hlavickam->dok == 10 ) { $rm10="0.00"; }
if( $hlavickam->dok == 11 ) { $rm11="0.00"; }
if( $hlavickam->dok == 12 ) { $rm12="0.00"; }
if( $hlavickam->dok == 13 ) { $rm13="0.00"; }
if( $hlavickam->dok == 14 ) { $rm14="0.00"; }
if( $hlavickam->dok == 15 ) { $rm15="0.00"; }
if( $hlavickam->dok == 16 ) { $rm16="0.00"; }
if( $hlavickam->dok == 17 ) { $rm17="0.00"; }
if( $hlavickam->dok == 18 ) { $rm18="0.00"; }
if( $hlavickam->dok == 19 ) { $rm19="0.00"; }
if( $hlavickam->dok == 20 ) { $rm20="0.00"; }
if( $hlavickam->dok == 21 ) { $rm21="0.00"; }
if( $hlavickam->dok == 22 ) { $rm22="0.00"; }
if( $hlavickam->dok == 23 ) { $rm23="0.00"; }
if( $hlavickam->dok == 24 ) { $rm24="0.00"; }
if( $hlavickam->dok == 25 ) { $rm25="0.00"; }
if( $hlavickam->dok == 26 ) { $rm26="0.00"; }
if( $hlavickam->dok == 27 ) { $rm27="0.00"; }
if( $hlavickam->dok == 28 ) { $rm28="0.00"; }
if( $hlavickam->dok == 29 ) { $rm29="0.00"; }
if( $hlavickam->dok == 30 ) { $rm30="0.00"; }
if( $hlavickam->dok == 31 ) { $rm31="0.00"; }
if( $hlavickam->dok == 32 ) { $rm32="0.00"; }
if( $hlavickam->dok == 33 ) { $rm33="0.00"; }
if( $hlavickam->dok == 34 ) { $rm34="0.00"; }
if( $hlavickam->dok == 35 ) { $rm35="0.00"; }
if( $hlavickam->dok == 36 ) { $rm36="0.00"; }
if( $hlavickam->dok == 37 ) { $rm37="0.00"; }
if( $hlavickam->dok == 38 ) { $rm38="0.00"; }
if( $hlavickam->dok == 39 ) { $rm39="0.00"; }
if( $hlavickam->dok == 40 ) { $rm40="0.00"; }
if( $hlavickam->dok == 41 ) { $rm41="0.00"; }
if( $hlavickam->dok == 42 ) { $rm42="0.00"; }
if( $hlavickam->dok == 43 ) { $rm43="0.00"; }
if( $hlavickam->dok == 44 ) { $rm44="0.00"; }
if( $hlavickam->dok == 45 ) { $rm45="0.00"; }
if( $hlavickam->dok == 46 ) { $rm46="0.00"; }
if( $hlavickam->dok == 47 ) { $rm47="0.00"; }
if( $hlavickam->dok == 48 ) { $rm48="0.00"; }
if( $hlavickam->dok == 49 ) { $rm49="0.00"; }
if( $hlavickam->dok == 50 ) { $rm50="0.00"; }
if( $hlavickam->dok == 51 ) { $rm51="0.00"; }
if( $hlavickam->dok == 52 ) { $rm52="0.00"; }
if( $hlavickam->dok == 53 ) { $rm53="0.00"; }
if( $hlavickam->dok == 54 ) { $rm54="0.00"; }
if( $hlavickam->dok == 55 ) { $rm55="0.00"; }
if( $hlavickam->dok == 56 ) { $rm56="0.00"; }
if( $hlavickam->dok == 57 ) { $rm57="0.00"; }
if( $hlavickam->dok == 58 ) { $rm58="0.00"; }
if( $hlavickam->dok == 59 ) { $rm59="0.00"; }
if( $hlavickam->dok == 60 ) { $rm60="0.00"; }
if( $hlavickam->dok == 61 ) { $rm61="0.00"; }
if( $hlavickam->dok == 62 ) { $rm62="0.00"; }
if( $hlavickam->dok == 63 ) { $rm63="0.00"; }
if( $hlavickam->dok == 64 ) { $rm64="0.00"; }
if( $hlavickam->dok == 65 ) { $rm65="0.00"; }
if( $hlavickam->dok == 66 ) { $rm66="0.00"; }
if( $hlavickam->dok == 67 ) { $rm67="0.00"; }
if( $hlavickam->dok == 68 ) { $rm68="0.00"; }
if( $hlavickam->dok == 69 ) { $rm69="0.00"; }
if( $hlavickam->dok == 70 ) { $rm70="0.00"; }
if( $hlavickam->dok == 71 ) { $rm71="0.00"; }
if( $hlavickam->dok == 72 ) { $rm72="0.00"; }
if( $hlavickam->dok == 73 ) { $rm73="0.00"; }
if( $hlavickam->dok == 74 ) { $rm74="0.00"; }
if( $hlavickam->dok == 75 ) { $rm75="0.00"; }
if( $hlavickam->dok == 76 ) { $rm76="0.00"; }
if( $hlavickam->dok == 77 ) { $rm77="0.00"; }
if( $hlavickam->dok == 78 ) { $rm78="0.00"; }
if( $hlavickam->dok == 79 ) { $rm79="0.00"; }
if( $hlavickam->dok == 80 ) { $rm80="0.00"; }
if( $hlavickam->dok == 81 ) { $rm81="0.00"; }
if( $hlavickam->dok == 82 ) { $rm82="0.00"; }
if( $hlavickam->dok == 83 ) { $rm83="0.00"; }
if( $hlavickam->dok == 84 ) { $rm84="0.00"; }
if( $hlavickam->dok == 85 ) { $rm85="0.00"; }
if( $hlavickam->dok == 86 ) { $rm86="0.00"; }
if( $hlavickam->dok == 87 ) { $rm87="0.00"; }
if( $hlavickam->dok == 88 ) { $rm88="0.00"; }
if( $hlavickam->dok == 89 ) { $rm89="0.00"; }
if( $hlavickam->dok == 90 ) { $rm90="0.00"; }
if( $hlavickam->dok == 91 ) { $rm91="0.00"; }
if( $hlavickam->dok == 92 ) { $rm92="0.00"; }
if( $hlavickam->dok == 93 ) { $rm93="0.00"; }
if( $hlavickam->dok == 94 ) { $rm94="0.00"; }
if( $hlavickam->dok == 95 ) { $rm95="0.00"; }
if( $hlavickam->dok == 96 ) { $rm96="0.00"; }
if( $hlavickam->dok == 97 ) { $rm97="0.00"; }
if( $hlavickam->dok == 98 ) { $rm98="0.00"; }
if( $hlavickam->dok == 99 ) { $rm99="0.00"; }
if( $hlavickam->dok == 100 ) { $rm100="0.00"; }
if( $hlavickam->dok == 101 ) { $rm101="0.00"; }
if( $hlavickam->dok == 102 ) { $rm102="0.00"; }
if( $hlavickam->dok == 103 ) { $rm103="0.00"; }
if( $hlavickam->dok == 104 ) { $rm104="0.00"; }
if( $hlavickam->dok == 105 ) { $rm105="0.00"; }
if( $hlavickam->dok == 106 ) { $rm106="0.00"; }
if( $hlavickam->dok == 107 ) { $rm107="0.00"; }
if( $hlavickam->dok == 108 ) { $rm108="0.00"; }
if( $hlavickam->dok == 109 ) { $rm109="0.00"; }
if( $hlavickam->dok == 110 ) { $rm110="0.00"; }
}
$im = $im + 1;
  }

//vypocitaj rm994,995 ako sucet
$nnne=1;
if ( $nnne == 0 )
    {
$rm994=0;
$sqldok = mysql_query("SELECT SUM(hod) as r994 FROM F$kli_vxcf"."_uctpocvziskovno WHERE dok >= 1 AND dok <= 38 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rm994=1*$riaddok->r994;
  }
$rm995=0;
$sqldok = mysql_query("SELECT SUM(hod) as r995 FROM F$kli_vxcf"."_uctpocvziskovno WHERE dok >= 39 AND dok <= 78 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rm995=1*$riaddok->r995;
  }
    }

//strana 4
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-4.jpg') AND $i == 0 )
{
if ( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-4.jpg',4,0,200,287); }
}
$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//ico
$pdf->Cell(190,0,"     ","0",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(113,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(6,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->SetFont('arial','',8);

//Naklady
$pdf->Cell(190,30,"     ","0",1,"L");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r01","$rmc",0,"R");$pdf->Cell(27,5,"$rpc01","$rmc",0,"R");$pdf->Cell(26,5,"$rsp01","$rmc",0,"R");
$pdf->Cell(27,5,"$rm01","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r02","$rmc",0,"R");$pdf->Cell(27,6,"$rpc02","$rmc",0,"R");$pdf->Cell(26,6,"$rsp02","$rmc",0,"R");
$pdf->Cell(27,6,"$rm02","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,5,"$r03","$rmc",0,"R");$pdf->Cell(27,5,"$rpc03","$rmc",0,"R");$pdf->Cell(26,5,"$rsp03","$rmc",0,"R");
$pdf->Cell(27,5,"$rm03","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r04","$rmc",0,"R");$pdf->Cell(27,5,"$rpc04","$rmc",0,"R");$pdf->Cell(26,5,"$rsp04","$rmc",0,"R");
$pdf->Cell(27,5,"$rm04","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r05","$rmc",0,"R");$pdf->Cell(27,5,"$rpc05","$rmc",0,"R");$pdf->Cell(26,5,"$rsp05","$rmc",0,"R");
$pdf->Cell(27,5,"$rm05","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r06","$rmc",0,"R");$pdf->Cell(27,6,"$rpc06","$rmc",0,"R");$pdf->Cell(26,6,"$rsp06","$rmc",0,"R");
$pdf->Cell(27,6,"$rm06","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,6,"$r07","$rmc",0,"R");$pdf->Cell(27,6,"$rpc07","$rmc",0,"R");$pdf->Cell(26,6,"$rsp07","$rmc",0,"R");
$pdf->Cell(27,6,"$rm07","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r08","$rmc",0,"R");$pdf->Cell(27,6,"$rpc08","$rmc",0,"R");$pdf->Cell(26,6,"$rsp08","$rmc",0,"R");
$pdf->Cell(27,6,"$rm08","$rmc",1,"R");
$pdf->Cell(85,8," ","0",0,"R");$pdf->Cell(24,8,"$r09","$rmc",0,"R");$pdf->Cell(27,8,"$rpc09","$rmc",0,"R");$pdf->Cell(26,8,"$rsp09","$rmc",0,"R");
$pdf->Cell(27,8,"$rm09","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r10","$rmc",0,"R");$pdf->Cell(27,6,"$rpc10","$rmc",0,"R");$pdf->Cell(26,6,"$rsp10","$rmc",0,"R");
$pdf->Cell(27,6,"$rm10","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,5,"$r11","$rmc",0,"R");$pdf->Cell(27,5,"$rpc11","$rmc",0,"R");$pdf->Cell(26,5,"$rsp11","$rmc",0,"R");
$pdf->Cell(27,5,"$rm11","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r12","$rmc",0,"R");$pdf->Cell(27,5,"$rpc12","$rmc",0,"R");$pdf->Cell(26,5,"$rsp12","$rmc",0,"R");
$pdf->Cell(27,5,"$rm12","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r13","$rmc",0,"R");$pdf->Cell(27,6,"$rpc13","$rmc",0,"R");$pdf->Cell(26,6,"$rsp13","$rmc",0,"R");
$pdf->Cell(27,6,"$rm13","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r14","$rmc",0,"R");$pdf->Cell(27,5,"$rpc14","$rmc",0,"R");$pdf->Cell(26,5,"$rsp14","$rmc",0,"R");
$pdf->Cell(27,5,"$rm14","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r15","$rmc",0,"R");$pdf->Cell(27,6,"$rpc15","$rmc",0,"R");$pdf->Cell(26,6,"$rsp15","$rmc",0,"R");
$pdf->Cell(27,6,"$rm15","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r16","$rmc",0,"R");$pdf->Cell(27,5,"$rpc16","$rmc",0,"R");$pdf->Cell(26,5,"$rsp16","$rmc",0,"R");
$pdf->Cell(27,5,"$rm16","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r17","$rmc",0,"R");$pdf->Cell(27,6,"$rpc17","$rmc",0,"R");$pdf->Cell(26,6,"$rsp17","$rmc",0,"R");
$pdf->Cell(27,6,"$rm17","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r18","$rmc",0,"R");$pdf->Cell(27,6,"$rpc18","$rmc",0,"R");$pdf->Cell(26,6,"$rsp18","$rmc",0,"R");
$pdf->Cell(27,6,"$rm18","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r19","$rmc",0,"R");$pdf->Cell(27,5,"$rpc19","$rmc",0,"R");$pdf->Cell(26,5,"$rsp19","$rmc",0,"R");
$pdf->Cell(27,5,"$rm19","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r20","$rmc",0,"R");$pdf->Cell(27,5,"$rpc20","$rmc",0,"R");$pdf->Cell(26,5,"$rsp20","$rmc",0,"R");
$pdf->Cell(27,5,"$rm20","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r21","$rmc",0,"R");$pdf->Cell(27,6,"$rpc21","$rmc",0,"R");$pdf->Cell(26,6,"$rsp21","$rmc",0,"R");
$pdf->Cell(27,6,"$rm21","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r22","$rmc",0,"R");$pdf->Cell(27,6,"$rpc22","$rmc",0,"R");$pdf->Cell(26,6,"$rsp22","$rmc",0,"R");
$pdf->Cell(27,6,"$rm22","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r23","$rmc",0,"R");$pdf->Cell(27,5,"$rpc23","$rmc",0,"R");$pdf->Cell(26,5,"$rsp23","$rmc",0,"R");
$pdf->Cell(27,5,"$rm23","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r24","$rmc",0,"R");$pdf->Cell(27,6,"$rpc24","$rmc",0,"R");$pdf->Cell(26,6,"$rsp24","$rmc",0,"R");
$pdf->Cell(27,6,"$rm24","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,9,"$r25","$rmc",0,"R");$pdf->Cell(27,9,"$rpc25","$rmc",0,"R");$pdf->Cell(26,9,"$rsp25","$rmc",0,"R");
$pdf->Cell(27,9,"$rm25","$rmc",1,"R");
$pdf->Cell(85,12," ","0",0,"R");$pdf->Cell(24,12,"$r26","$rmc",0,"R");$pdf->Cell(27,12,"$rpc26","$rmc",0,"R");$pdf->Cell(26,12,"$rsp26","$rmc",0,"R");
$pdf->Cell(27,12,"$rm26","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r27","$rmc",0,"R");$pdf->Cell(27,5,"$rpc27","$rmc",0,"R");$pdf->Cell(26,5,"$rsp27","$rmc",0,"R");
$pdf->Cell(27,5,"$rm27","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r28","$rmc",0,"R");$pdf->Cell(27,6,"$rpc28","$rmc",0,"R");$pdf->Cell(26,6,"$rsp28","$rmc",0,"R");
$pdf->Cell(27,6,"$rm28","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r29","$rmc",0,"R");$pdf->Cell(27,6,"$rpc29","$rmc",0,"R");$pdf->Cell(26,6,"$rsp29","$rmc",0,"R");
$pdf->Cell(27,6,"$rm29","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r30","$rmc",0,"R");$pdf->Cell(27,5,"$rpc30","$rmc",0,"R");$pdf->Cell(26,5,"$rsp30","$rmc",0,"R");
$pdf->Cell(27,5,"$rm30","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,9,"$r31","$rmc",0,"R");$pdf->Cell(27,9,"$rpc31","$rmc",0,"R");$pdf->Cell(26,9,"$rsp31","$rmc",0,"R");
$pdf->Cell(27,9,"$rm31","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r32","$rmc",0,"R");$pdf->Cell(27,5,"$rpc32","$rmc",0,"R");$pdf->Cell(26,5,"$rsp32","$rmc",0,"R");
$pdf->Cell(27,5,"$rm32","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,9,"$r33","$rmc",0,"R");$pdf->Cell(27,9,"$rpc33","$rmc",0,"R");$pdf->Cell(26,9,"$rsp33","$rmc",0,"R");
$pdf->Cell(27,9,"$rm33","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r34","$rmc",0,"R");$pdf->Cell(27,6,"$rpc34","$rmc",0,"R");$pdf->Cell(26,6,"$rsp34","$rmc",0,"R");
$pdf->Cell(27,6,"$rm34","$rmc",1,"R");
$pdf->Cell(85,8," ","0",0,"R");$pdf->Cell(24,8,"$r35","$rmc",0,"R");$pdf->Cell(27,8,"$rpc35","$rmc",0,"R");$pdf->Cell(26,8,"$rsp35","$rmc",0,"R");
$pdf->Cell(27,8,"$rm35","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,7,"$r36","$rmc",0,"R");$pdf->Cell(27,7,"$rpc36","$rmc",0,"R");$pdf->Cell(26,7,"$rsp36","$rmc",0,"R");
$pdf->Cell(27,7,"$rm36","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r37","$rmc",0,"R");$pdf->Cell(27,6,"$rpc37","$rmc",0,"R");$pdf->Cell(26,6,"$rsp37","$rmc",0,"R");
$pdf->Cell(27,6,"$rm37","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r38","$rmc",0,"R");$pdf->Cell(27,6,"$rpc38","$rmc",0,"R");$pdf->Cell(26,6,"$rsp38","$rmc",0,"R");
$pdf->Cell(27,6,"$rm38","$rmc",1,"R");


//strana 6
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists ('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-5.jpg') AND $i == 0 )
{
if ( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-5.jpg',5,0,200,287); }
}
$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//ico
$pdf->Cell(190,1,"     ","0",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(115,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(5,6,"$D","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(5,6,"$H","$rmc",0,"C");
$pdf->SetFont('arial','',8);

//Vynosy
$pdf->Cell(190,30,"     ","0",1,"L");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r39","$rmc",0,"R");$pdf->Cell(27,5,"$rpc39","$rmc",0,"R");$pdf->Cell(26,5,"$rsp39","$rmc",0,"R");
$pdf->Cell(27,5,"$rm39","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r40","$rmc",0,"R");$pdf->Cell(27,5,"$rpc40","$rmc",0,"R");$pdf->Cell(26,5,"$rsp40","$rmc",0,"R");
$pdf->Cell(27,5,"$rm40","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r41","$rmc",0,"R");$pdf->Cell(27,5,"$rpc41","$rmc",0,"R");$pdf->Cell(26,5,"$rsp41","$rmc",0,"R");
$pdf->Cell(27,5,"$rm41","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r42","$rmc",0,"R");$pdf->Cell(27,5,"$rpc42","$rmc",0,"R");$pdf->Cell(26,5,"$rsp42","$rmc",0,"R");
$pdf->Cell(27,5,"$rm42","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r43","$rmc",0,"R");$pdf->Cell(27,6,"$rpc43","$rmc",0,"R");$pdf->Cell(26,6,"$rsp43","$rmc",0,"R");
$pdf->Cell(27,6,"$rm43","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r44","$rmc",0,"R");$pdf->Cell(27,5,"$rpc44","$rmc",0,"R");$pdf->Cell(26,5,"$rsp44","$rmc",0,"R");
$pdf->Cell(27,5,"$rm44","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r45","$rmc",0,"R");$pdf->Cell(27,6,"$rpc45","$rmc",0,"R");$pdf->Cell(26,6,"$rsp45","$rmc",0,"R");
$pdf->Cell(27,6,"$rm45","$rmc",1,"R");
$pdf->Cell(85,4," ","0",0,"R");$pdf->Cell(24,4,"$r46","$rmc",0,"R");$pdf->Cell(27,4,"$rpc46","$rmc",0,"R");$pdf->Cell(26,4,"$rsp46","$rmc",0,"R");
$pdf->Cell(27,4,"$rm46","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r47","$rmc",0,"R");$pdf->Cell(27,5,"$rpc47","$rmc",0,"R");$pdf->Cell(26,5,"$rsp47","$rmc",0,"R");
$pdf->Cell(27,5,"$rm47","$rmc",1,"R");
$pdf->Cell(85,7," ","0",0,"R");$pdf->Cell(24,8,"$r48","$rmc",0,"R");$pdf->Cell(27,8,"$rpc48","$rmc",0,"R");$pdf->Cell(26,8,"$rsp48","$rmc",0,"R");
$pdf->Cell(27,8,"$rm48","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,9,"$r49","$rmc",0,"R");$pdf->Cell(27,9,"$rpc49","$rmc",0,"R");$pdf->Cell(26,9,"$rsp49","$rmc",0,"R");
$pdf->Cell(27,9,"$rm49","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,5,"$r50","$rmc",0,"R");$pdf->Cell(27,5,"$rpc50","$rmc",0,"R");$pdf->Cell(26,5,"$rsp50","$rmc",0,"R");
$pdf->Cell(27,5,"$rm50","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r51","$rmc",0,"R");$pdf->Cell(27,5,"$rpc51","$rmc",0,"R");$pdf->Cell(26,5,"$rsp51","$rmc",0,"R");
$pdf->Cell(27,5,"$rm51","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,5,"$r52","$rmc",0,"R");$pdf->Cell(27,5,"$rpc52","$rmc",0,"R");$pdf->Cell(26,5,"$rsp52","$rmc",0,"R");
$pdf->Cell(27,5,"$rm52","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r53","$rmc",0,"R");$pdf->Cell(27,5,"$rpc53","$rmc",0,"R");$pdf->Cell(26,5,"$rsp53","$rmc",0,"R");
$pdf->Cell(27,5,"$rm53","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r54","$rmc",0,"R");$pdf->Cell(27,6,"$rpc54","$rmc",0,"R");$pdf->Cell(26,6,"$rsp54","$rmc",0,"R");
$pdf->Cell(27,6,"$rm54","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r55","$rmc",0,"R");$pdf->Cell(27,5,"$rpc55","$rmc",0,"R");$pdf->Cell(26,5,"$rsp55","$rmc",0,"R");
$pdf->Cell(27,5,"$rm55","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r56","$rmc",0,"R");$pdf->Cell(27,5,"$rpc56","$rmc",0,"R");$pdf->Cell(26,5,"$rsp56","$rmc",0,"R");
$pdf->Cell(27,5,"$rm56","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r57","$rmc",0,"R");$pdf->Cell(27,5,"$rpc57","$rmc",0,"R");$pdf->Cell(26,5,"$rsp57","$rmc",0,"R");
$pdf->Cell(27,5,"$rm57","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r58","$rmc",0,"R");$pdf->Cell(27,5,"$rpc58","$rmc",0,"R");$pdf->Cell(26,5,"$rsp58","$rmc",0,"R");
$pdf->Cell(27,5,"$rm58","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,8,"$r59","$rmc",0,"R");$pdf->Cell(27,8,"$rpc59","$rmc",0,"R");$pdf->Cell(26,8,"$rsp59","$rmc",0,"R");
$pdf->Cell(27,8,"$rm59","$rmc",1,"R");
$pdf->Cell(85,7," ","0",0,"R");$pdf->Cell(24,8,"$r60","$rmc",0,"R");$pdf->Cell(27,8,"$rpc60","$rmc",0,"R");$pdf->Cell(26,8,"$rsp60","$rmc",0,"R");
$pdf->Cell(27,8,"$rm60","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,9,"$r61","$rmc",0,"R");$pdf->Cell(27,9,"$rpc61","$rmc",0,"R");$pdf->Cell(26,9,"$rsp61","$rmc",0,"R");
$pdf->Cell(27,9,"$rm61","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r62","$rmc",0,"R");$pdf->Cell(27,6,"$rpc62","$rmc",0,"R");$pdf->Cell(26,6,"$rsp62","$rmc",0,"R");
$pdf->Cell(27,6,"$rm62","$rmc",1,"R");
$pdf->Cell(85,8," ","0",0,"R");$pdf->Cell(24,8,"$r63","$rmc",0,"R");$pdf->Cell(27,8,"$rpc63","$rmc",0,"R");$pdf->Cell(26,8,"$rsp63","$rmc",0,"R");
$pdf->Cell(27,8,"$rm63","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r64","$rmc",0,"R");$pdf->Cell(27,5,"$rpc64","$rmc",0,"R");$pdf->Cell(26,5,"$rsp64","$rmc",0,"R");
$pdf->Cell(27,5,"$rm64","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r65","$rmc",0,"R");$pdf->Cell(27,5,"$rpc65","$rmc",0,"R");$pdf->Cell(26,5,"$rsp65","$rmc",0,"R");
$pdf->Cell(27,5,"$rm65","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r66","$rmc",0,"R");$pdf->Cell(27,5,"$rpc66","$rmc",0,"R");$pdf->Cell(26,5,"$rsp66","$rmc",0,"R");
$pdf->Cell(27,5,"$rm66","$rmc",1,"R");
$pdf->Cell(85,7," ","0",0,"R");$pdf->Cell(24,7,"$r67","$rmc",0,"R");$pdf->Cell(27,7,"$rpc67","$rmc",0,"R");$pdf->Cell(26,7,"$rsp67","$rmc",0,"R");
$pdf->Cell(27,7,"$rm67","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r68","$rmc",0,"R");$pdf->Cell(27,6,"$rpc68","$rmc",0,"R");$pdf->Cell(26,6,"$rsp68","$rmc",0,"R");
$pdf->Cell(27,6,"$rm68","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r69","$rmc",0,"R");$pdf->Cell(27,5,"$rpc69","$rmc",0,"R");$pdf->Cell(26,5,"$rsp69","$rmc",0,"R");
$pdf->Cell(27,5,"$rm69","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r70","$rmc",0,"R");$pdf->Cell(27,5,"$rpc70","$rmc",0,"R");$pdf->Cell(26,5,"$rsp70","$rmc",0,"R");
$pdf->Cell(27,5,"$rm70","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r71","$rmc",0,"R");$pdf->Cell(27,5,"$rpc71","$rmc",0,"R");$pdf->Cell(26,5,"$rsp71","$rmc",0,"R");
$pdf->Cell(27,5,"$rm71","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r72","$rmc",0,"R");$pdf->Cell(27,5,"$rpc72","$rmc",0,"R");$pdf->Cell(26,5,"$rsp72","$rmc",0,"R");
$pdf->Cell(27,5,"$rm72","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r73","$rmc",0,"R");$pdf->Cell(27,5,"$rpc73","$rmc",0,"R");$pdf->Cell(26,5,"$rsp73","$rmc",0,"R");
$pdf->Cell(27,5,"$rm73","$rmc",1,"R");
$pdf->Cell(85,6," ","0",0,"R");$pdf->Cell(24,6,"$r74","$rmc",0,"R");$pdf->Cell(27,6,"$rpc74","$rmc",0,"R");$pdf->Cell(26,6,"$rsp74","$rmc",0,"R");
$pdf->Cell(27,6,"$rm74","$rmc",1,"R");
$pdf->Cell(85,8," ","0",0,"R");$pdf->Cell(24,8,"$r75","$rmc",0,"R");$pdf->Cell(27,8,"$rpc75","$rmc",0,"R");$pdf->Cell(26,8,"$rsp75","$rmc",0,"R");
$pdf->Cell(27,8,"$rm75","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r76","$rmc",0,"R");$pdf->Cell(27,5,"$rpc76","$rmc",0,"R");$pdf->Cell(26,5,"$rsp76","$rmc",0,"R");
$pdf->Cell(27,5,"$rm76","$rmc",1,"R");
$pdf->Cell(85,5," ","0",0,"R");$pdf->Cell(24,5,"$r77","$rmc",0,"R");$pdf->Cell(27,5,"$rpc77","$rmc",0,"R");$pdf->Cell(26,5,"$rsp77","$rmc",0,"R");
$pdf->Cell(27,5,"$rm77","$rmc",1,"R");
$pdf->Cell(85,9," ","0",0,"R");$pdf->Cell(24,9,"$r78","$rmc",0,"R");$pdf->Cell(27,9,"$rpc78","$rmc",0,"R");$pdf->Cell(26,9,"$rsp78","$rmc",0,"R");
$pdf->Cell(27,9,"$rm78","$rmc",1,"R");

}
$i = $i + 1;
  }
//koniec while vykazziskov


$pdf->Output("../tmp/uzavierka.$kli_uzid.pdf");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvahas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvaha'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykziss'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykzis'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvyk1000ziss'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/uzavierka.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Uzavierka MUJ PDF</title>
</HEAD>
<BODY class="white" >

<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
