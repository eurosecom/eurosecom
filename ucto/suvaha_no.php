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

//konecne odstranili tie kontrolne cisla

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if (File_Exists ("../tmp/suvaha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/suvaha.$kli_uzid.pdf"); }

$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 0 )
  {
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

//350=sirka obdlznika 0 znamena do konca , 15=vyska obdlznika , $riadok-text , "1"=border ano 0 nie
//parameter druhy zlava 1=kurzor prejde na zaciatok riadku,0 kurzor pokracuje na riadku,2 kurzor ide nad riadok
//L=zarovnanie left alebo C=center R=right
//$pdf->Cell(350,15,"$riadok","0",1,"L");
//$rest = substr("abcdef", 0, 4); // vrátí "abcd"

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
  }

//pre zostavu vytvor pracovny subor prcsuvaha$kli_uzid pre import nie
if( $copern == 10 )
{

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvahas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcsuvahas
(
   kor          INT,
   prx          INT,
   uce          VARCHAR(11),
   ucm          VARCHAR(11),
   ucd          VARCHAR(11),
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,2),
   mdt          DECIMAL(10,2),
   dal          DECIMAL(10,2),
   r01          DECIMAL(10,2),
   r02          DECIMAL(10,2),
   r03          DECIMAL(10,2),
   r04          DECIMAL(10,2),
   r05          DECIMAL(10,2),
   r06          DECIMAL(10,2),
   r07          DECIMAL(10,2),
   r08          DECIMAL(10,2),
   r09          DECIMAL(10,2),
   r10          DECIMAL(10,2),
   r11          DECIMAL(10,2),
   r12          DECIMAL(10,2),
   r13          DECIMAL(10,2),
   r14          DECIMAL(10,2),
   r15          DECIMAL(10,2),
   r16          DECIMAL(10,2),
   r17          DECIMAL(10,2),
   r18          DECIMAL(10,2),
   r19          DECIMAL(10,2),
   r20          DECIMAL(10,2),
   r21          DECIMAL(10,2),
   r22          DECIMAL(10,2),
   r23          DECIMAL(10,2),
   r24          DECIMAL(10,2),
   r25          DECIMAL(10,2),
   r26          DECIMAL(10,2),
   r27          DECIMAL(10,2),
   r28          DECIMAL(10,2),
   r29          DECIMAL(10,2),
   r30          DECIMAL(10,2),
   r31          DECIMAL(10,2),
   r32          DECIMAL(10,2),
   r33          DECIMAL(10,2),
   r34          DECIMAL(10,2),
   r35          DECIMAL(10,2),
   r36          DECIMAL(10,2),
   r37          DECIMAL(10,2),
   r38          DECIMAL(10,2),
   r39          DECIMAL(10,2),
   r40          DECIMAL(10,2),
   r41          DECIMAL(10,2),
   r42          DECIMAL(10,2),
   r43          DECIMAL(10,2),
   r44          DECIMAL(10,2),
   r45          DECIMAL(10,2),
   r46          DECIMAL(10,2),
   r47          DECIMAL(10,2),
   r48          DECIMAL(10,2),
   r49          DECIMAL(10,2),
   r50          DECIMAL(10,2),
   r51          DECIMAL(10,2),
   r52          DECIMAL(10,2),
   r53          DECIMAL(10,2),
   r54          DECIMAL(10,2),
   r55          DECIMAL(10,2),
   r56          DECIMAL(10,2),
   r57          DECIMAL(10,2),
   r58          DECIMAL(10,2),
   r59          DECIMAL(10,2),
   r60          DECIMAL(10,2),
   r61          DECIMAL(10,2),
   r62          DECIMAL(10,2),
   r63          DECIMAL(10,2),
   r64          DECIMAL(10,2),
   r65          DECIMAL(10,2),
   r66          DECIMAL(10,2),
   r67          DECIMAL(10,2),
   r68          DECIMAL(10,2),
   r69          DECIMAL(10,2),
   r70          DECIMAL(10,2),
   r71          DECIMAL(10,2),
   r72          DECIMAL(10,2),
   r73          DECIMAL(10,2),
   r74          DECIMAL(10,2),
   r75          DECIMAL(10,2),
   r76          DECIMAL(10,2),
   r77          DECIMAL(10,2),
   r78          DECIMAL(10,2),
   r79          DECIMAL(10,2),
   r80          DECIMAL(10,2),
   r81          DECIMAL(10,2),
   r82          DECIMAL(10,2),
   r83          DECIMAL(10,2),
   r84          DECIMAL(10,2),
   r85          DECIMAL(10,2),
   r86          DECIMAL(10,2),
   r87          DECIMAL(10,2),
   r88          DECIMAL(10,2),
   r89          DECIMAL(10,2),
   r90          DECIMAL(10,2),
   r91          DECIMAL(10,2),
   r92          DECIMAL(10,2),
   r93          DECIMAL(10,2),
   r94          DECIMAL(10,2),
   r95          DECIMAL(10,2),
   r96          DECIMAL(10,2),
   r97          DECIMAL(10,2),
   r98          DECIMAL(10,2),
   r99          DECIMAL(10,2),
   r100         DECIMAL(10,2),
   r101         DECIMAL(10,2),
   r102         DECIMAL(10,2),
   r103         DECIMAL(10,2),
   r104         DECIMAL(10,2),
   r105         DECIMAL(10,2),
   r106         DECIMAL(10,2),
   r107         DECIMAL(10,2),
   r108         DECIMAL(10,2),
   r109         DECIMAL(10,2),
   r110         DECIMAL(10,2),
   r111         DECIMAL(10,2),
   r112         DECIMAL(10,2),
   r113         DECIMAL(10,2),
   r114         DECIMAL(10,2),
   r115         DECIMAL(10,2),
   r116         DECIMAL(10,2),
   r117         DECIMAL(10,2),
   r118         DECIMAL(10,2),
   rk01          DECIMAL(10,2),
   rk02          DECIMAL(10,2),
   rk03          DECIMAL(10,2),
   rk04          DECIMAL(10,2),
   rk05          DECIMAL(10,2),
   rk06          DECIMAL(10,2),
   rk07          DECIMAL(10,2),
   rk08          DECIMAL(10,2),
   rk09          DECIMAL(10,2),
   rk10          DECIMAL(10,2),
   rk11          DECIMAL(10,2),
   rk12          DECIMAL(10,2),
   rk13          DECIMAL(10,2),
   rk14          DECIMAL(10,2),
   rk15          DECIMAL(10,2),
   rk16          DECIMAL(10,2),
   rk17          DECIMAL(10,2),
   rk18          DECIMAL(10,2),
   rk19          DECIMAL(10,2),
   rk20          DECIMAL(10,2),
   rk21          DECIMAL(10,2),
   rk22          DECIMAL(10,2),
   rk23          DECIMAL(10,2),
   rk24          DECIMAL(10,2),
   rk25          DECIMAL(10,2),
   rk26          DECIMAL(10,2),
   rk27          DECIMAL(10,2),
   rk28          DECIMAL(10,2),
   rk29          DECIMAL(10,2),
   rk30          DECIMAL(10,2),
   rk31          DECIMAL(10,2),
   rk32          DECIMAL(10,2),
   rk33          DECIMAL(10,2),
   rk34          DECIMAL(10,2),
   rk35          DECIMAL(10,2),
   rk36          DECIMAL(10,2),
   rk37          DECIMAL(10,2),
   rk38          DECIMAL(10,2),
   rk39          DECIMAL(10,2),
   rk40          DECIMAL(10,2),
   rk41          DECIMAL(10,2),
   rk42          DECIMAL(10,2),
   rk43          DECIMAL(10,2),
   rk44          DECIMAL(10,2),
   rk45          DECIMAL(10,2),
   rk46          DECIMAL(10,2),
   rk47          DECIMAL(10,2),
   rk48          DECIMAL(10,2),
   rk49          DECIMAL(10,2),
   rk50          DECIMAL(10,2),
   rk51          DECIMAL(10,2),
   rk52          DECIMAL(10,2),
   rk53          DECIMAL(10,2),
   rk54          DECIMAL(10,2),
   rk55          DECIMAL(10,2),
   rk56          DECIMAL(10,2),
   rk57          DECIMAL(10,2),
   rk58          DECIMAL(10,2),
   rk59          DECIMAL(10,2),
   rk60          DECIMAL(10,2),
   rk61          DECIMAL(10,2),
   rk62          DECIMAL(10,2),
   rk63          DECIMAL(10,2),
   rk64          DECIMAL(10,2),
   rn01          DECIMAL(10,2),
   rn02          DECIMAL(10,2),
   rn03          DECIMAL(10,2),
   rn04          DECIMAL(10,2),
   rn05          DECIMAL(10,2),
   rn06          DECIMAL(10,2),
   rn07          DECIMAL(10,2),
   rn08          DECIMAL(10,2),
   rn09          DECIMAL(10,2),
   rn10          DECIMAL(10,2),
   rn11          DECIMAL(10,2),
   rn12          DECIMAL(10,2),
   rn13          DECIMAL(10,2),
   rn14          DECIMAL(10,2),
   rn15          DECIMAL(10,2),
   rn16          DECIMAL(10,2),
   rn17          DECIMAL(10,2),
   rn18          DECIMAL(10,2),
   rn19          DECIMAL(10,2),
   rn20          DECIMAL(10,2),
   rn21          DECIMAL(10,2),
   rn22          DECIMAL(10,2),
   rn23          DECIMAL(10,2),
   rn24          DECIMAL(10,2),
   rn25          DECIMAL(10,2),
   rn26          DECIMAL(10,2),
   rn27          DECIMAL(10,2),
   rn28          DECIMAL(10,2),
   rn29          DECIMAL(10,2),
   rn30          DECIMAL(10,2),
   rn31          DECIMAL(10,2),
   rn32          DECIMAL(10,2),
   rn33          DECIMAL(10,2),
   rn34          DECIMAL(10,2),
   rn35          DECIMAL(10,2),
   rn36          DECIMAL(10,2),
   rn37          DECIMAL(10,2),
   rn38          DECIMAL(10,2),
   rn39          DECIMAL(10,2),
   rn40          DECIMAL(10,2),
   rn41          DECIMAL(10,2),
   rn42          DECIMAL(10,2),
   rn43          DECIMAL(10,2),
   rn44          DECIMAL(10,2),
   rn45          DECIMAL(10,2),
   rn46          DECIMAL(10,2),
   rn47          DECIMAL(10,2),
   rn48          DECIMAL(10,2),
   rn49          DECIMAL(10,2),
   rn50          DECIMAL(10,2),
   rn51          DECIMAL(10,2),
   rn52          DECIMAL(10,2),
   rn53          DECIMAL(10,2),
   rn54          DECIMAL(10,2),
   rn55          DECIMAL(10,2),
   rn56          DECIMAL(10,2),
   rn57          DECIMAL(10,2),
   rn58          DECIMAL(10,2),
   rn59          DECIMAL(10,2),
   rn60          DECIMAL(10,2),
   rn61          DECIMAL(10,2),
   rn62          DECIMAL(10,2),
   rn63          DECIMAL(10,2),
   rn64          DECIMAL(10,2),
   ico          INT
);
prcsuvahas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcsuvahas'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcsuvahas
(
   kor          INT,
   prx          INT,
   uce          VARCHAR(11),
   ucm          VARCHAR(11),
   ucd          VARCHAR(11),
   rdk          INT,
   prv          INT,
   hod          DECIMAL(10,0),
   mdt          DECIMAL(10,0),
   dal          DECIMAL(10,0),
   r01          DECIMAL(10,0),
   r02          DECIMAL(10,0),
   r03          DECIMAL(10,0),
   r04          DECIMAL(10,0),
   r05          DECIMAL(10,0),
   r06          DECIMAL(10,0),
   r07          DECIMAL(10,0),
   r08          DECIMAL(10,0),
   r09          DECIMAL(10,0),
   r10          DECIMAL(10,0),
   r11          DECIMAL(10,0),
   r12          DECIMAL(10,0),
   r13          DECIMAL(10,0),
   r14          DECIMAL(10,0),
   r15          DECIMAL(10,0),
   r16          DECIMAL(10,0),
   r17          DECIMAL(10,0),
   r18          DECIMAL(10,0),
   r19          DECIMAL(10,0),
   r20          DECIMAL(10,0),
   r21          DECIMAL(10,0),
   r22          DECIMAL(10,0),
   r23          DECIMAL(10,0),
   r24          DECIMAL(10,0),
   r25          DECIMAL(10,0),
   r26          DECIMAL(10,0),
   r27          DECIMAL(10,0),
   r28          DECIMAL(10,0),
   r29          DECIMAL(10,0),
   r30          DECIMAL(10,0),
   r31          DECIMAL(10,0),
   r32          DECIMAL(10,0),
   r33          DECIMAL(10,0),
   r34          DECIMAL(10,0),
   r35          DECIMAL(10,0),
   r36          DECIMAL(10,0),
   r37          DECIMAL(10,0),
   r38          DECIMAL(10,0),
   r39          DECIMAL(10,0),
   r40          DECIMAL(10,0),
   r41          DECIMAL(10,0),
   r42          DECIMAL(10,0),
   r43          DECIMAL(10,0),
   r44          DECIMAL(10,0),
   r45          DECIMAL(10,0),
   r46          DECIMAL(10,0),
   r47          DECIMAL(10,0),
   r48          DECIMAL(10,0),
   r49          DECIMAL(10,0),
   r50          DECIMAL(10,0),
   r51          DECIMAL(10,0),
   r52          DECIMAL(10,0),
   r53          DECIMAL(10,0),
   r54          DECIMAL(10,0),
   r55          DECIMAL(10,0),
   r56          DECIMAL(10,0),
   r57          DECIMAL(10,0),
   r58          DECIMAL(10,0),
   r59          DECIMAL(10,0),
   r60          DECIMAL(10,0),
   r61          DECIMAL(10,0),
   r62          DECIMAL(10,0),
   r63          DECIMAL(10,0),
   r64          DECIMAL(10,0),
   r65          DECIMAL(10,0),
   r66          DECIMAL(10,0),
   r67          DECIMAL(10,0),
   r68          DECIMAL(10,0),
   r69          DECIMAL(10,0),
   r70          DECIMAL(10,0),
   r71          DECIMAL(10,0),
   r72          DECIMAL(10,0),
   r73          DECIMAL(10,0),
   r74          DECIMAL(10,0),
   r75          DECIMAL(10,0),
   r76          DECIMAL(10,0),
   r77          DECIMAL(10,0),
   r78          DECIMAL(10,0),
   r79          DECIMAL(10,0),
   r80          DECIMAL(10,0),
   r81          DECIMAL(10,0),
   r82          DECIMAL(10,0),
   r83          DECIMAL(10,0),
   r84          DECIMAL(10,0),
   r85          DECIMAL(10,0),
   r86          DECIMAL(10,0),
   r87          DECIMAL(10,0),
   r88          DECIMAL(10,0),
   r89          DECIMAL(10,0),
   r90          DECIMAL(10,0),
   r91          DECIMAL(10,0),
   r92          DECIMAL(10,0),
   r93          DECIMAL(10,0),
   r94          DECIMAL(10,0),
   r95          DECIMAL(10,0),
   r96          DECIMAL(10,0),
   r97          DECIMAL(10,0),
   r98          DECIMAL(10,0),
   r99          DECIMAL(10,0),
   r100         DECIMAL(10,0),
   r101         DECIMAL(10,0),
   r102         DECIMAL(10,0),
   r103         DECIMAL(10,0),
   r104         DECIMAL(10,0),
   r105         DECIMAL(10,0),
   r106         DECIMAL(10,0),
   r107         DECIMAL(10,0),
   r108         DECIMAL(10,0),
   r109         DECIMAL(10,0),
   r110         DECIMAL(10,0),
   r111         DECIMAL(10,0),
   r112         DECIMAL(10,0),
   r113         DECIMAL(10,0),
   r114         DECIMAL(10,0),
   r115         DECIMAL(10,0),
   r116         DECIMAL(10,0),
   r117         DECIMAL(10,0),
   r118         DECIMAL(10,0),
   rk01          DECIMAL(10,0),
   rk02          DECIMAL(10,0),
   rk03          DECIMAL(10,0),
   rk04          DECIMAL(10,0),
   rk05          DECIMAL(10,0),
   rk06          DECIMAL(10,0),
   rk07          DECIMAL(10,0),
   rk08          DECIMAL(10,0),
   rk09          DECIMAL(10,0),
   rk10          DECIMAL(10,0),
   rk11          DECIMAL(10,0),
   rk12          DECIMAL(10,0),
   rk13          DECIMAL(10,0),
   rk14          DECIMAL(10,0),
   rk15          DECIMAL(10,0),
   rk16          DECIMAL(10,0),
   rk17          DECIMAL(10,0),
   rk18          DECIMAL(10,0),
   rk19          DECIMAL(10,0),
   rk20          DECIMAL(10,0),
   rk21          DECIMAL(10,0),
   rk22          DECIMAL(10,0),
   rk23          DECIMAL(10,0),
   rk24          DECIMAL(10,0),
   rk25          DECIMAL(10,0),
   rk26          DECIMAL(10,0),
   rk27          DECIMAL(10,0),
   rk28          DECIMAL(10,0),
   rk29          DECIMAL(10,0),
   rk30          DECIMAL(10,0),
   rk31          DECIMAL(10,0),
   rk32          DECIMAL(10,0),
   rk33          DECIMAL(10,0),
   rk34          DECIMAL(10,0),
   rk35          DECIMAL(10,0),
   rk36          DECIMAL(10,0),
   rk37          DECIMAL(10,0),
   rk38          DECIMAL(10,0),
   rk39          DECIMAL(10,0),
   rk40          DECIMAL(10,0),
   rk41          DECIMAL(10,0),
   rk42          DECIMAL(10,0),
   rk43          DECIMAL(10,0),
   rk44          DECIMAL(10,0),
   rk45          DECIMAL(10,0),
   rk46          DECIMAL(10,0),
   rk47          DECIMAL(10,0),
   rk48          DECIMAL(10,0),
   rk49          DECIMAL(10,0),
   rk50          DECIMAL(10,0),
   rk51          DECIMAL(10,0),
   rk52          DECIMAL(10,0),
   rk53          DECIMAL(10,0),
   rk54          DECIMAL(10,0),
   rk55          DECIMAL(10,0),
   rk56          DECIMAL(10,0),
   rk57          DECIMAL(10,0),
   rk58          DECIMAL(10,0),
   rk59          DECIMAL(10,0),
   rk60          DECIMAL(10,0),
   rk61          DECIMAL(10,0),
   rk62          DECIMAL(10,0),
   rk63          DECIMAL(10,0),
   rk64          DECIMAL(10,0),
   rn01          DECIMAL(10,0),
   rn02          DECIMAL(10,0),
   rn03          DECIMAL(10,0),
   rn04          DECIMAL(10,0),
   rn05          DECIMAL(10,0),
   rn06          DECIMAL(10,0),
   rn07          DECIMAL(10,0),
   rn08          DECIMAL(10,0),
   rn09          DECIMAL(10,0),
   rn10          DECIMAL(10,0),
   rn11          DECIMAL(10,0),
   rn12          DECIMAL(10,0),
   rn13          DECIMAL(10,0),
   rn14          DECIMAL(10,0),
   rn15          DECIMAL(10,0),
   rn16          DECIMAL(10,0),
   rn17          DECIMAL(10,0),
   rn18          DECIMAL(10,0),
   rn19          DECIMAL(10,0),
   rn20          DECIMAL(10,0),
   rn21          DECIMAL(10,0),
   rn22          DECIMAL(10,0),
   rn23          DECIMAL(10,0),
   rn24          DECIMAL(10,0),
   rn25          DECIMAL(10,0),
   rn26          DECIMAL(10,0),
   rn27          DECIMAL(10,0),
   rn28          DECIMAL(10,0),
   rn29          DECIMAL(10,0),
   rn30          DECIMAL(10,0),
   rn31          DECIMAL(10,0),
   rn32          DECIMAL(10,0),
   rn33          DECIMAL(10,0),
   rn34          DECIMAL(10,0),
   rn35          DECIMAL(10,0),
   rn36          DECIMAL(10,0),
   rn37          DECIMAL(10,0),
   rn38          DECIMAL(10,0),
   rn39          DECIMAL(10,0),
   rn40          DECIMAL(10,0),
   rn41          DECIMAL(10,0),
   rn42          DECIMAL(10,0),
   rn43          DECIMAL(10,0),
   rn44          DECIMAL(10,0),
   rn45          DECIMAL(10,0),
   rn46          DECIMAL(10,0),
   rn47          DECIMAL(10,0),
   rn48          DECIMAL(10,0),
   rn49          DECIMAL(10,0),
   rn50          DECIMAL(10,0),
   rn51          DECIMAL(10,0),
   rn52          DECIMAL(10,0),
   rn53          DECIMAL(10,0),
   rn54          DECIMAL(10,0),
   rn55          DECIMAL(10,0),
   rn56          DECIMAL(10,0),
   rn57          DECIMAL(10,0),
   rn58          DECIMAL(10,0),
   rn59          DECIMAL(10,0),
   rn60          DECIMAL(10,0),
   rn61          DECIMAL(10,0),
   rn62          DECIMAL(10,0),
   rn63          DECIMAL(10,0),
   rn64          DECIMAL(10,0),
   ico          INT
);
prcsuvahas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pda != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$psys=1;
while ($psys <= 9 ) 
  {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucm,ucm,0,0,0,0,SUM(F$kli_vxcf"."_$uctovanie.hod),0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume GROUP BY ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(F$kli_vxcf"."_$uctovanie.hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume GROUP BY ucd";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucm,ucm,0,0,0,0,SUM(hod),0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucm > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( ucd > 0 AND ume <= $kli_vume ) GROUP BY F$kli_vxcf"."_$uctovanie.ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

}
//koniec vytvorenia pracovneho suboru



$sql = "SELECT * FROM F$kli_vxcf"."_crs_no";
$vysledok = mysql_query("$sql");
if ($vysledok)
          {
$polx = mysql_num_rows($vysledok);
$sql = "DROP TABLE F$kli_vxcf"."_crs_no";
if( $polx < 4 ) { $vysledok = mysql_query("$sql"); }
          }

//zostava mesacna
if( $copern == 10 )
{
//nastav crs podla uce ale nie z uctosnova ako pri podnikatelskych ale z crs_no.csv v adresary /import/ucto

//Tabulka crs_no
$sql = "SELECT * FROM F$kli_vxcf"."_crs_no";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {
echo "Vytvorit tabulku F$kli_vxcf"."_crs_no!"."<br />";

$sqlt = <<<crs_no
(
   uce         VARCHAR(10),
   crs         INT
);
crs_no;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_crs_no'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/crs_no$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_uce = $pole[0];
  $x_crs = $pole[1];
  $x_kon = $pole[2];
 
$c_uce=1*$x_uce;

if( $c_uce > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_crs_no ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
          }
//koniec tabulky crs_no

//uprava pkse


if(  $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND $kli_vrok < 2012 )
{
//echo "robim";
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=50 WHERE LEFT(uce,3) = 335 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=50 WHERE LEFT(uce,3) = 378 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=44 WHERE LEFT(uce,3) = 391 ";
$oznac = mysql_query("$sqtoz");
}

if(  $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND $kli_vxcf == 209 AND $kli_vrok < 2012 )
{
//echo "robim";
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=46 WHERE LEFT(uce,3) = 341 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=91 WHERE LEFT(uce,3) = 342 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=91 WHERE LEFT(uce,3) = 343 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_crs_no SET crs=91 WHERE LEFT(uce,3) = 345 ";
$oznac = mysql_query("$sqtoz");
}

if( $_SERVER['SERVER_NAME'] == "www.eurofp.sk" AND $kli_vrok < 2012 )
{
$sqtoz = "DELETE FROM F$kli_vxcf"."_crs_no WHERE LEFT(uce,3) = 479 ";
$oznac = mysql_query("$sqtoz");

$sqult = "INSERT INTO F$kli_vxcf"."_crs_no ( uce,crs ) VALUES ( '47900', '86' ); "; 
$ulozene = mysql_query("$sqult"); 

}


$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_no".
" SET rdk=F$kli_vxcf"."_crs_no.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_crs_no.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_no".
" SET rdk=F$kli_vxcf"."_crs_no.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,5) = LEFT(F$kli_vxcf"."_crs_no.uce,5) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_no".
" SET rdk=F$kli_vxcf"."_crs_no.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,6) = LEFT(F$kli_vxcf"."_crs_no.uce,6) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


if(  $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND $kli_vxcf == 309 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_no".
" SET rdk=F$kli_vxcf"."_crs_no.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,6) = LEFT(F$kli_vxcf"."_crs_no.uce,6) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
}




//korekcia
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid".
" SET kor=1".
" WHERE LEFT(uce,3) = 071 OR LEFT(uce,3) = 072 OR LEFT(uce,3) = 073 OR LEFT(uce,3) = 074 OR LEFT(uce,3) = 075 OR LEFT(uce,3) = 076 OR LEFT(uce,3) = 079 ".
"  OR LEFT(uce,3) = 078 OR LEFT(uce,3) = 081 OR LEFT(uce,3) = 082 OR LEFT(uce,3) = 083 OR LEFT(uce,3) = 084 OR LEFT(uce,3) = 085 OR LEFT(uce,3) = 086 ".
" OR LEFT(uce,3) = 088 OR LEFT(uce,3) = 089 ".
" OR LEFT(uce,3) = 091 OR LEFT(uce,3) = 092 OR LEFT(uce,3) = 093 OR LEFT(uce,3) = 094 OR LEFT(uce,3) = 095 OR LEFT(uce,3) = 096 OR LEFT(uce,3) = 098 ".
" OR LEFT(uce,3) = 191 OR LEFT(uce,3) = 192 OR LEFT(uce,3) = 193 OR LEFT(uce,3) = 194 OR LEFT(uce,3) = 195 OR LEFT(uce,3) = 196 ".
" OR LEFT(uce,3) = 197 OR LEFT(uce,3) = 198 OR LEFT(uce,3) = 199 ".
" OR LEFT(uce,3) = 291 OR LEFT(uce,3) = 391 ".
"";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;

//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 118 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk AND kor = 0 ";
if( $rdk > 60 ) { $sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

if( $rdk < 61 ) { 
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET rk$crdk=dal-mdt WHERE rdk = $rdk AND kor = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET rn$crdk=r$crdk-rk$crdk WHERE rdk > 0 ";
$oznac = mysql_query("$sqtoz");

                }
$rdk=$rdk+1;
  }

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcsuvahasneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcsuvahasneg".$kli_uzid." SELECT * FROM F".$kli_vxcf."_prcsuvahas".$kli_uzid." WHERE rdk = 0 ";
$oznac = mysql_query("$sqtoz");

//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid "." SELECT".
" 0,1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),".
"SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),".
"SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(r39),SUM(r40),".
"SUM(r41),SUM(r42),SUM(r43),SUM(r44),SUM(r45),SUM(r46),SUM(r47),SUM(r48),SUM(r49),SUM(r50),".
"SUM(r51),SUM(r52),SUM(r53),SUM(r54),SUM(r55),SUM(r56),SUM(r57),SUM(r58),SUM(r59),SUM(r60),".
"SUM(r61),SUM(r62),SUM(r63),SUM(r64),SUM(r65),SUM(r66),SUM(r67),SUM(r68),SUM(r69),SUM(r70),".
"SUM(r71),SUM(r72),SUM(r73),SUM(r74),SUM(r75),SUM(r76),SUM(r77),SUM(r78),SUM(r79),SUM(r80),".
"SUM(r81),SUM(r82),SUM(r83),SUM(r84),SUM(r85),SUM(r86),SUM(r87),SUM(r88),SUM(r89),SUM(r90),".
"SUM(r91),SUM(r92),SUM(r93),SUM(r94),SUM(r95),SUM(r96),SUM(r97),SUM(r98),SUM(r99),SUM(r100),".
"SUM(r101),SUM(r102),SUM(r103),SUM(r104),SUM(r105),SUM(r106),SUM(r107),SUM(r108),SUM(r109),SUM(r110),".
"SUM(r111),SUM(r112),SUM(r113),SUM(r114),SUM(r115),SUM(r116),SUM(r117),SUM(r118),".
"SUM(rk01),SUM(rk02),SUM(rk03),SUM(rk04),SUM(rk05),SUM(rk06),SUM(rk07),SUM(rk08),SUM(rk09),SUM(rk10),".
"SUM(rk11),SUM(rk12),SUM(rk13),SUM(rk14),SUM(rk15),SUM(rk16),SUM(rk17),SUM(rk18),SUM(rk19),SUM(rk20),".
"SUM(rk21),SUM(rk22),SUM(rk23),SUM(rk24),SUM(rk25),SUM(rk26),SUM(rk27),SUM(rk28),SUM(rk29),SUM(rk30),".
"SUM(rk31),SUM(rk32),SUM(rk33),SUM(rk34),SUM(rk35),SUM(rk36),SUM(rk37),SUM(rk38),SUM(rk39),SUM(rk40),".
"SUM(rk41),SUM(rk42),SUM(rk43),SUM(rk44),SUM(rk45),SUM(rk46),SUM(rk47),SUM(rk48),SUM(rk49),SUM(rk50),".
"SUM(rk51),SUM(rk52),SUM(rk53),SUM(rk54),SUM(rk55),SUM(rk56),SUM(rk57),SUM(rk58),SUM(rk59),SUM(rk60),".
"SUM(rk61),SUM(rk62),SUM(rk63),SUM(rk64),".
"SUM(rn01),SUM(rn02),SUM(rn03),SUM(rn04),SUM(rn05),SUM(rn06),SUM(rn07),SUM(rn08),SUM(rn09),SUM(rn10),".
"SUM(rn11),SUM(rn12),SUM(rn13),SUM(rn14),SUM(rn15),SUM(rn16),SUM(rn17),SUM(rn18),SUM(rn19),SUM(rn20),".
"SUM(rn21),SUM(rn22),SUM(rn23),SUM(rn24),SUM(rn25),SUM(rn26),SUM(rn27),SUM(rn28),SUM(rn29),SUM(rn30),".
"SUM(rn31),SUM(rn32),SUM(rn33),SUM(rn34),SUM(rn35),SUM(rn36),SUM(rn37),SUM(rn38),SUM(rn39),SUM(rn40),".
"SUM(rn41),SUM(rn42),SUM(rn43),SUM(rn44),SUM(rn45),SUM(rn46),SUM(rn47),SUM(rn48),SUM(rn49),SUM(rn50),".
"SUM(rn51),SUM(rn52),SUM(rn53),SUM(rn54),SUM(rn55),SUM(rn56),SUM(rn57),SUM(rn58),SUM(rn59),SUM(rn60),".
"SUM(rn61),SUM(rn62),SUM(rn63),SUM(rn64),".
"$fir_fico".
" FROM F$kli_vxcf"."_prcsuvahas$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

//ak na tisic
if( $tis > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET ".
"r01=r01/1, r02=r02/1, r03=r03/1, r04=r04/1, r05=r05/1, r06=r06/1, r07=r07/1, r08=r08/1, r09=r09/1, r10=r10/1,".
"r11=r11/1, r12=r12/1, r13=r13/1, r14=r14/1, r15=r15/1, r16=r16/1, r17=r17/1, r18=r18/1, r19=r19/1, r20=r20/1,".
"r21=r21/1, r22=r22/1, r23=r23/1, r24=r24/1, r25=r25/1, r26=r26/1, r27=r27/1, r28=r28/1, r29=r29/1, r30=r30/1,".
"r31=r31/1, r32=r32/1, r33=r33/1, r34=r34/1, r35=r35/1, r36=r36/1, r37=r37/1, r38=r38/1, r39=r39/1, r40=r40/1,".
"r41=r41/1, r42=r42/1, r43=r43/1, r44=r44/1, r45=r45/1, r46=r46/1, r47=r47/1, r48=r48/1, r49=r49/1,".
"r50=r50/1, r51=r51/1, r52=r52/1, r53=r53/1, r54=r54/1, r55=r55/1, r56=r56/1, r57=r57/1, r58=r58/1 , r59=r59/1,".
"r60=r60/1, r61=r61/1, r62=r62/1, r63=r63/1, r64=r64/1, r65=r65/1, r66=r66/1, r67=r67/1, r68=r68/1 , r69=r69/1,".
"r70=r70/1, r71=r71/1, r72=r72/1, r73=r73/1, r74=r74/1, r75=r75/1, r76=r76/1, r77=r77/1, r78=r78/1 , r79=r79/1,".
"r80=r80/1, r81=r81/1, r82=r82/1, r83=r83/1, r84=r84/1, r85=r85/1, r86=r86/1, r87=r87/1, r88=r88/1 , r89=r89/1,".
"r90=r90/1, r91=r91/1, r92=r92/1, r93=r93/1, r94=r94/1, r95=r95/1, r96=r96/1, r97=r97/1, r98=r98/1 , r99=r99/1,".
"r100=r100/1, r101=r101/1, r102=r102/1, r103=r103/1, r104=r104/1, r105=r105/1,".
"r106=r106/1, r107=r107/1, r108=r108/1 , r109=r109/1,".
"r110=r110/1, r111=r111/1, r112=r112/1, r113=r113/1, r114=r114/1, r115=r115/1,".
"r116=r116/1, r117=r117/1, r118=r118/1, ".
"rk01=rk01/1, rk02=rk02/1, rk03=rk03/1, rk04=rk04/1, rk05=rk05/1, rk06=rk06/1, rk07=rk07/1, rk08=rk08/1, rk09=rk09/1, rk10=rk10/1,".
"rk11=rk11/1, rk12=rk12/1, rk13=rk13/1, rk14=rk14/1, rk15=rk15/1, rk16=rk16/1, rk17=rk17/1, rk18=rk18/1, rk19=rk19/1, rk20=rk20/1,".
"rk21=rk21/1, rk22=rk22/1, rk23=rk23/1, rk24=rk24/1, rk25=rk25/1, rk26=rk26/1, rk27=rk27/1, rk28=rk28/1, rk29=rk29/1, rk30=rk30/1,".
"rk31=rk31/1, rk32=rk32/1, rk33=rk33/1, rk34=rk34/1, rk35=rk35/1, rk36=rk36/1, rk37=rk37/1, rk38=rk38/1, rk39=rk39/1, rk40=rk40/1,".
"rk41=rk41/1, rk42=rk42/1, rk43=rk43/1, rk44=rk44/1, rk45=rk45/1, rk46=rk46/1, rk47=rk47/1, rk48=rk48/1, rk49=rk49/1,".
"rk50=rk50/1, rk51=rk51/1, rk52=rk52/1, rk53=rk53/1, rk54=rk54/1, rk55=rk55/1, rk56=rk56/1, rk57=rk57/1, rk58=rk58/1 , rk59=rk59/1,".
"rk60=rk60/1, rk61=rk61/1, rk62=rk62/1, rk63=rk63/1, rk64=rk64/1, ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuv1000ahas$kli_uzid "." SELECT".
" 0,1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,r01,r02,r03,r04,r05,".
"r06,r07,r08,r09,r10,r11,r12,r13,r14,r15,".
"r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,".
"r31,r32,r33,r34,r35,r36,r37,r38,r39,r40,".
"r41,r42,r43,r44,r45,r46,r47,r48,r49,".
"r50,r51,r52,r53,r54,r55,r56,r57,r58,r59,".
"r60,r61,r62,r63,r64,r65,r66,r67,r68,r69,".
"r70,r71,r72,r73,r74,r75,r76,r77,r78,r79,".
"r80,r81,r82,r83,r84,r85,r86,r87,r88,r89,".
"r90,r91,r92,r93,r94,r95,r96,r97,r98,r99,".
"r100,r101,r102,r103,r104,r105,r106,r107,r108,r109,".
"r110,r111,r112,r113,r114,r115,r116,r117,r118,".
"rk01,rk02,rk03,rk04,rk05,".
"rk06,rk07,rk08,rk09,rk10,rk11,rk12,rk13,rk14,rk15,".
"rk16,rk17,rk18,rk19,rk20,rk21,rk22,rk23,rk24,rk25,rk26,rk27,rk28,rk29,rk30,".
"rk31,rk32,rk33,rk34,rk35,rk36,rk37,rk38,rk39,rk40,".
"rk41,rk42,rk43,rk44,rk45,rk46,rk47,rk48,rk49,".
"rk50,rk51,rk52,rk53,rk54,rk55,rk56,rk57,rk58,rk59,".
"rk60,rk61,rk62,rk63,rk64,".
"rn01,rn02,rn03,rn04,rn05,".
"rn06,rn07,rn08,rn09,rn10,rn11,rn12,rn13,rn14,rn15,".
"rn16,rn17,rn18,rn19,rn20,rn21,rn22,rn23,rn24,rn25,rn26,rn27,rn28,rn29,rn30,".
"rn31,rn32,rn33,rn34,rn35,rn36,rn37,rn38,rn39,rn40,".
"rn41,rn42,rn43,rn44,rn45,rn46,rn47,rn48,rn49,".
"rn50,rn51,rn52,rn53,rn54,rn55,rn56,rn57,rn58,rn59,".
"rn60,rn61,rn62,rn63,rn64,".
"$fir_fico".
" FROM F$kli_vxcf"."_prcsuvahas$kli_uzid".
" WHERE prx = 1".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$sqtoz = "UPDATE F$kli_vxcf"."_prcsuv1000ahas$kli_uzid SET ".
"rn01=r01-rk01, rn02=r02-rk02, rn03=r03-rk03, rn04=r04-rk04, rn05=r05-rk05, rn06=r06-rk06, rn07=r07-rk07, rn08=r08-rk08, rn09=r09-rk09, rn10=r10-rk10,".
"rn11=r11-rk11, rn12=r12-rk12, rn13=r13-rk13, rn14=r14-rk14, rn15=r15-rk15, rn16=r16-rk16, rn17=r17-rk17, rn18=r18-rk18, rn19=r19-rk19, rn20=r20-rk20,".
"rn21=r21-rk21, rn22=r22-rk22, rn23=r23-rk23, rn24=r24-rk24, rn25=r25-rk25, rn26=r26-rk26, rn27=r27-rk27, rn28=r28-rk28, rn29=r29-rk29, rn30=r30-rk30,".
"rn31=r31-rk31, rn32=r32-rk32, rn33=r33-rk33, rn34=r34-rk34, rn35=r35-rk35, rn36=r36-rk36, rn37=r37-rk37, rn38=r38-rk38, rn39=r39-rk39, rn40=r40-rk40,".
"rn41=r41-rk41, rn42=r42-rk42, rn43=r43-rk43, rn44=r44-rk44, rn45=r45-rk45, rn46=r46-rk46, rn47=r47-rk47, rn48=r48-rk48, rn49=r49-rk49, rn50=r50-rk50,".
"rn51=r51-rk51, rn52=r52-rk52, rn53=r53-rk53, rn54=r54-rk54, rn55=r55-rk55, rn56=r56-rk56, rn57=r57-rk57, rn58=r58-rk58, rn59=r59-rk59, rn60=r60-rk60,".
"rn61=r61-rk61, rn62=r62-rk62, rn63=r63-rk63, rn64=r64-rk64 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

}
//koniec ak 1000ky

//exit;

//vypocitaj riadky strana 4
$vsldat="prcsuvahas";
if( $tis > 0 ) { $vsldat="prcsuv1000ahas"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r101=r102+r103, ".
"r97=r98+r99+r100, ".
"r87=r88+r89+r90+r91+r92+r93+r94+r95+r96, ".
"r79=r80+r81+r82+r83+r84+r85+r86, ".
"r75=r76+r77+r78, ".
"r68=r69+r70+r71, ".
"r62=r63+r64+r65+r66+r67, ".
"r74=r75+r79+r87+r97 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj strana 3
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r57=r58+r59, ".
"r51=r52+r53+r54+r55+r56, ".
"r42=r43+r44+r45+r46+r47+r48+r49+r50, ".
"r37=r38+r39+r40+r41, ".
"r30=r31+r32+r33+r34+r35+r36, ".
"r29=r30+r37+r42+r51 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rn57=rn58+rn59, ".
"rn51=rn52+rn53+rn54+rn55+rn56, ".
"rn42=rn43+rn44+rn45+rn46+rn47+rn48+rn49+rn50, ".
"rn37=rn38+rn39+rn40+rn41, ".
"rn30=rn31+rn32+rn33+rn34+rn35+rn36, ".
"rn29=rn30+rn37+rn42+rn51 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rk57=rk58+rk59, ".
"rk51=rk52+rk53+rk54+rk55+rk56, ".
"rk42=rk43+rk44+rk45+rk46+rk47+rk48+rk49+rk50, ".
"rk37=rk38+rk39+rk40+rk41, ".
"rk30=rk31+rk32+rk33+rk34+rk35+rk36, ".
"rk29=rk30+rk37+rk42+rk51 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj strana 2
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r21=r22+r23+r24+r25+r26+r27+r28, ".
"r09=r10+r11+r12+r13+r14+r15+r16+r17+r18+r19+r20, ".
"r02=r03+r04+r05+r06+r07+r08, ".
"r01=r02+r09+r21 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rn21=rn22+rn23+rn24+rn25+rn26+rn27+rn28, ".
"rn09=rn10+rn11+rn12+rn13+rn14+rn15+rn16+rn17+rn18+rn19+rn20, ".
"rn02=rn03+rn04+rn05+rn06+rn07+rn08, ".
"rn01=rn02+rn09+rn21 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rk21=rk22+rk23+rk24+rk25+rk26+rk27+rk28, ".
"rk09=rk10+rk11+rk12+rk13+rk14+rk15+rk16+rk17+rk18+rk19+rk20, ".
"rk02=rk03+rk04+rk05+rk06+rk07+rk08, ".
"rk01=rk02+rk09+rk21 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj vysledok naposledy riadok 111,114,115=991, 112,116,117=992 113=993
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r60=r01+r29+r57, ".
"rn60=rn01+rn29+rn57, ".
"rk60=rk01+rk29+rk57  ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r111=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12+r13+r14+r15+r16+r17+r18+r19+r20+r21+r22+r23+r24+r25+r26+r27+r28, ".
"r112=r29+r30+r31+r32+r33+r34+r35+r36+r37+r38+r39+r40+r41+r42+r43+r44+r45+r46+r47+r48+r49+r50+r51+r52+r53+r54+r55+r56+r57+r58+r59+r60, ".
"r114=rn01+rn02+rn03+rn04+rn05+rn06+rn07+rn08+rn09+rn10+rn11+rn12+rn13+rn14+rn15+rn16+rn17+rn18+rn19+rn20+rn21+rn22+rn23+rn24+rn25+rn26+rn27+rn28, ".
"r116=rn29+rn30+rn31+rn32+rn33+rn34+rn35+rn36+rn37+rn38+rn39+rn40+rn41+rn42+rn43+rn44+rn45+rn46+rn47+rn48+rn49+rn50+rn51+rn52+rn53+rn54+rn55+rn56+rn57+rn58+rn59+rn60, ".
"r115=rk01+rk02+rk03+rk04+rk05+rk06+rk07+rk08+rk09+rk10+rk11+rk12+rk13+rk14+rk15+rk16+rk17+rk18+rk19+rk20+rk21+rk22+rk23+rk24+rk25+rk26+rk27+rk28, ".
"r117=rk29+rk30+rk31+rk32+rk33+rk34+rk35+rk36+rk37+rk38+rk39+rk40+rk41+rk42+rk43+rk44+rk45+rk46+rk47+rk48+rk49+rk50+rk51+rk52+rk53+rk54+rk55+rk56+rk57+rk58+rk59+rk60, ".
"r73=rn60-(r62+r68+r72+r74+r101), ".
"r61=r62+r68+r72+r73, ".
"r104=r61+r74+r101, ".
"r113=r61+r62+r63+r64+r65+r66+r67+r68+r69+r70+r71+r72+r73+r74+r75+r76+r77+r78+r79+r80, ".
"r113=r113+r81+r82+r83+r84+r85+r86+r87+r88+r89+r90+r91+r92+r93+r94+r95+r96+r97+r98+r99+r100+r101+r102+r103+r104 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");
 
//poc.stav subory
$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,2),
   rm01         DECIMAL(10,2),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocsuvahano_stl'.$sqlt;
$ulozene = mysql_query("$sql");

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpocsuvahano_stl1000';
$ulozene = mysql_query("$sql");
$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpocsuvahano_stt';
$ulozene = mysql_query("$sql");

$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,0),
   rm01         DECIMAL(10,0),
   rm02         DECIMAL(10,0),
   rm03         DECIMAL(10,0),
   rm04         DECIMAL(10,0),
   rm05         DECIMAL(10,0),
   rm06         DECIMAL(10,0),
   rm07         DECIMAL(10,0),
   rm08         DECIMAL(10,0),
   rm09         DECIMAL(10,0),
   rm10         DECIMAL(10,0),
   rm11         DECIMAL(10,0),
   rm12         DECIMAL(10,0),
   rm13         DECIMAL(10,0),
   rm14         DECIMAL(10,0),
   rm15         DECIMAL(10,0),
   rm16         DECIMAL(10,0),
   rm17         DECIMAL(10,0),
   rm18         DECIMAL(10,0),
   rm19         DECIMAL(10,0),
   rm20         DECIMAL(10,0),
   rm21         DECIMAL(10,0),
   rm22         DECIMAL(10,0),
   rm23         DECIMAL(10,0),
   rm24         DECIMAL(10,0),
   rm25         DECIMAL(10,0),
   rm26         DECIMAL(10,0),
   rm27         DECIMAL(10,0),
   rm28         DECIMAL(10,0),
   rm29         DECIMAL(10,0),
   rm30         DECIMAL(10,0),
   rm31         DECIMAL(10,0),
   rm32         DECIMAL(10,0),
   rm33         DECIMAL(10,0),
   rm34         DECIMAL(10,0),
   rm35         DECIMAL(10,0),
   rm36         DECIMAL(10,0),
   rm37         DECIMAL(10,0),
   rm38         DECIMAL(10,0),
   rm39         DECIMAL(10,0),
   rm40         DECIMAL(10,0),
   rm41         DECIMAL(10,0),
   rm42         DECIMAL(10,0),
   rm43         DECIMAL(10,0),
   rm44         DECIMAL(10,0),
   rm45         DECIMAL(10,0),
   rm46         DECIMAL(10,0),
   rm47         DECIMAL(10,0),
   rm48         DECIMAL(10,0),
   rm49         DECIMAL(10,0),
   rm50         DECIMAL(10,0),
   rm51         DECIMAL(10,0),
   rm52         DECIMAL(10,0),
   rm53         DECIMAL(10,0),
   rm54         DECIMAL(10,0),
   rm55         DECIMAL(10,0),
   rm56         DECIMAL(10,0),
   rm57         DECIMAL(10,0),
   rm58         DECIMAL(10,0),
   rm59         DECIMAL(10,0),
   rm60         DECIMAL(10,0),
   rm61         DECIMAL(10,0),
   rm62         DECIMAL(10,0),
   rm63         DECIMAL(10,0),
   rm64         DECIMAL(10,0),
   rm65         DECIMAL(10,0),
   rm66         DECIMAL(10,0),
   rm67         DECIMAL(10,0),
   rm68         DECIMAL(10,0),
   rm69         DECIMAL(10,0),
   rm70         DECIMAL(10,0),
   rm71         DECIMAL(10,0),
   rm72         DECIMAL(10,0),
   rm73         DECIMAL(10,0),
   rm74         DECIMAL(10,0),
   rm75         DECIMAL(10,0),
   rm76         DECIMAL(10,0),
   rm77         DECIMAL(10,0),
   rm78         DECIMAL(10,0),
   rm79         DECIMAL(10,0),
   rm80         DECIMAL(10,0),
   rm81         DECIMAL(10,0),
   rm82         DECIMAL(10,0),
   rm83         DECIMAL(10,0),
   rm84         DECIMAL(10,0),
   rm85         DECIMAL(10,0),
   rm86         DECIMAL(10,0),
   rm87         DECIMAL(10,0),
   rm88         DECIMAL(10,0),
   rm89         DECIMAL(10,0),
   rm90         DECIMAL(10,0),
   rm91         DECIMAL(10,0),
   rm92         DECIMAL(10,0),
   rm93         DECIMAL(10,0),
   rm94         DECIMAL(10,0),
   rm95         DECIMAL(10,0),
   rm96         DECIMAL(10,0),
   rm97         DECIMAL(10,0),
   rm98         DECIMAL(10,0),
   rm99         DECIMAL(10,0),
   rm100         DECIMAL(10,0),
   rm101         DECIMAL(10,0),
   rm102         DECIMAL(10,0),
   rm103         DECIMAL(10,0),
   rm104         DECIMAL(10,0),
   rm105         DECIMAL(10,0),
   rm106         DECIMAL(10,0),
   rm107         DECIMAL(10,0),
   rm108         DECIMAL(10,0),
   rm109         DECIMAL(10,0),
   rm110         DECIMAL(10,0),
   rm111         DECIMAL(10,0),
   rm112         DECIMAL(10,0),
   rm113         DECIMAL(10,0),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocsuvahano_stt'.$sqlt;
$ulozene = mysql_query("$sql");

//koniec poc.stav


$skusobna=0;
if( $skusobna == 1 )
  {
  $text = "UPDATE F".$kli_vxcf."_prcsuvahas".$kli_uzid." SET ";

  $i=0;
  while ( $i < 105 )
   {
   $ix=$i;
   if( $i < 10 ) { $ix="0".$i; }
   if( $i == 0 ) {  $text = $text."  "; }
   if( $i == 1 ) {  $text = $text."  r".$ix."=".$i." "; }
   if( $i > 1 )  {  $text = $text." ,r".$ix."=".$i." "; }
   $hodpc=1000+$i;
   if( $i > 0 AND $i < 61 )  {  $text = $text." ,rk".$ix."=".$hodpc." "; }
   $hodsp=2000+$i;
   if( $i > 0 AND $i < 61 )  {  $text = $text." ,rn".$ix."=".$hodsp." "; }

  $i=$i+1;
   }
  $text = $text." WHERE prx = 1 ";
//echo $text;
//exit;
$ulozene = mysql_query("$text");

  $text = "UPDATE F".$kli_vxcf."_uctpocsuvahano_stl SET ";

  $i=0;
  while ( $i < 105 )
   {
   $ix=$i;
   if( $i < 10 ) { $ix="0".$i; }
   if( $i == 0 ) {  $text = $text."  "; }
   if( $i == 1 ) {  $text = $text."  rm".$ix."=".$i." "; }
   $hodrm=3000+$i;
   if( $i > 1 )  {  $text = $text." ,rm".$ix."=".$hodrm." "; }

  $i=$i+1;
   }
  $text = $text."  ";
//echo $text;
//exit;
$ulozene = mysql_query("$text");
  }
//koniec skusobna


//uzavierka NUJ 2013
$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 1 )
  {
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
?>
<script type="text/javascript">

window.open('../ucto/vykzis_no.php?copern=10&drupoh=1&tis=0&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=1', '_self' )


</script>
<?php
exit;
  }


//vytlac
//$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid." WHERE prx = 1 "."";
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvahano_stl".
" ON F$kli_vxcf"."_prcsuvahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvahano_stl.fic".
" WHERE prx = 1 "."";


if( $tis > 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctpocsuvahano_stt SELECT ".
"dok,hod,".
"rm01,rm02,rm03,rm04,rm05,rm06,rm07,rm08,rm09,rm10,".
"rm11,rm12,rm13,rm14,rm15,rm16,rm17,rm18,rm19,rm20,".
"rm21,rm22,rm23,rm24,rm25,rm26,rm27,rm28,rm29,rm30,".
"rm31,rm32,rm33,rm34,rm35,rm36,rm37,rm38,rm39,rm40,".
"rm41,rm42,rm43,rm44,rm45,rm46,rm47,rm48,rm49,rm50,".
"rm51,rm52,rm53,rm54,rm55,rm56,rm57,rm58,rm59,rm60,".
"rm61,rm62,rm63,rm64,rm65,rm66,rm67,rm68,rm69,rm70,".
"rm71,rm72,rm73,rm74,rm75,rm76,rm77,rm78,rm79,rm80,".
"rm81,rm82,rm83,rm84,rm85,rm86,rm87,rm88,rm89,rm90,".
"rm91,rm92,rm93,rm94,rm95,rm96,rm97,rm98,rm99,rm100,".
"rm101,rm102,rm103,rm104,rm105,rm106,rm107,rm108,rm109,rm110,rm111,rm112,rm113,".
"fic".
" FROM F$kli_vxcf"."_uctpocsuvahano_stl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//if( $tis > 0 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." WHERE prx = 1 ".""; }
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvahano_stt".
" ON F$kli_vxcf"."_prcsuv1000ahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvahano_stt.fic".
" WHERE prx = 1 ".""; 

//exit;
}



$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


$urob=0;

if( $urob == 1 )
{
if (File_Exists ("../tmp/vloz$kli_uzid.php")) { $soubor = unlink("../tmp/vloz$kli_uzid.php"); }
$soubor = fopen("../tmp/vloz$kli_uzid.php", "a+");

  $text = "<?php"."\r\n";
  fwrite($soubor, $text);

$rdk=1;
while ($rdk <= 117 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$text="\$r".$crdk."=\$hlavicka->r".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->r".$crdk." == 0 ) \$r".$crdk."='';"."\r\n";

$text=$text."\$rk".$crdk."=\$hlavicka->rk".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->rk".$crdk." == 0 ) \$rk".$crdk."='';"."\r\n";

$text=$text."\$rn".$crdk."=\$hlavicka->rn".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->rn".$crdk." == 0 ) \$rn".$crdk."='';"."\r\n";

$text=$text."\$rm".$crdk."=\$hlavicka->rm".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->rm".$crdk." == 0 ) \$rm".$crdk."='';"."\r\n";

fwrite($soubor, $text);

$rdk=$rdk+1;
  }

  $text = "?>"."\r\n";
  fwrite($soubor, $text);

  fclose($soubor);

include("../tmp/vloz$kli_uzid.php");

}



$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01='';
$rk01=$hlavicka->rk01;
if( $hlavicka->rk01 == 0 ) $rk01='';
$rn01=$hlavicka->rn01;
if( $hlavicka->rn01 == 0 ) $rn01='';
$rm01=$hlavicka->rm01;
if( $hlavicka->rm01 == 0 ) $rm01='';
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02='';
$rk02=$hlavicka->rk02;
if( $hlavicka->rk02 == 0 ) $rk02='';
$rn02=$hlavicka->rn02;
if( $hlavicka->rn02 == 0 ) $rn02='';
$rm02=$hlavicka->rm02;
if( $hlavicka->rm02 == 0 ) $rm02='';
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03='';
$rk03=$hlavicka->rk03;
if( $hlavicka->rk03 == 0 ) $rk03='';
$rn03=$hlavicka->rn03;
if( $hlavicka->rn03 == 0 ) $rn03='';
$rm03=$hlavicka->rm03;
if( $hlavicka->rm03 == 0 ) $rm03='';
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04='';
$rk04=$hlavicka->rk04;
if( $hlavicka->rk04 == 0 ) $rk04='';
$rn04=$hlavicka->rn04;
if( $hlavicka->rn04 == 0 ) $rn04='';
$rm04=$hlavicka->rm04;
if( $hlavicka->rm04 == 0 ) $rm04='';
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05='';
$rk05=$hlavicka->rk05;
if( $hlavicka->rk05 == 0 ) $rk05='';
$rn05=$hlavicka->rn05;
if( $hlavicka->rn05 == 0 ) $rn05='';
$rm05=$hlavicka->rm05;
if( $hlavicka->rm05 == 0 ) $rm05='';
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06='';
$rk06=$hlavicka->rk06;
if( $hlavicka->rk06 == 0 ) $rk06='';
$rn06=$hlavicka->rn06;
if( $hlavicka->rn06 == 0 ) $rn06='';
$rm06=$hlavicka->rm06;
if( $hlavicka->rm06 == 0 ) $rm06='';
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07='';
$rk07=$hlavicka->rk07;
if( $hlavicka->rk07 == 0 ) $rk07='';
$rn07=$hlavicka->rn07;
if( $hlavicka->rn07 == 0 ) $rn07='';
$rm07=$hlavicka->rm07;
if( $hlavicka->rm07 == 0 ) $rm07='';
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08='';
$rk08=$hlavicka->rk08;
if( $hlavicka->rk08 == 0 ) $rk08='';
$rn08=$hlavicka->rn08;
if( $hlavicka->rn08 == 0 ) $rn08='';
$rm08=$hlavicka->rm08;
if( $hlavicka->rm08 == 0 ) $rm08='';
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09='';
$rk09=$hlavicka->rk09;
if( $hlavicka->rk09 == 0 ) $rk09='';
$rn09=$hlavicka->rn09;
if( $hlavicka->rn09 == 0 ) $rn09='';
$rm09=$hlavicka->rm09;
if( $hlavicka->rm09 == 0 ) $rm09='';
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10='';
$rk10=$hlavicka->rk10;
if( $hlavicka->rk10 == 0 ) $rk10='';
$rn10=$hlavicka->rn10;
if( $hlavicka->rn10 == 0 ) $rn10='';
$rm10=$hlavicka->rm10;
if( $hlavicka->rm10 == 0 ) $rm10='';
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11='';
$rk11=$hlavicka->rk11;
if( $hlavicka->rk11 == 0 ) $rk11='';
$rn11=$hlavicka->rn11;
if( $hlavicka->rn11 == 0 ) $rn11='';
$rm11=$hlavicka->rm11;
if( $hlavicka->rm11 == 0 ) $rm11='';
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12='';
$rk12=$hlavicka->rk12;
if( $hlavicka->rk12 == 0 ) $rk12='';
$rn12=$hlavicka->rn12;
if( $hlavicka->rn12 == 0 ) $rn12='';
$rm12=$hlavicka->rm12;
if( $hlavicka->rm12 == 0 ) $rm12='';
$r13=$hlavicka->r13;
if( $hlavicka->r13 == 0 ) $r13='';
$rk13=$hlavicka->rk13;
if( $hlavicka->rk13 == 0 ) $rk13='';
$rn13=$hlavicka->rn13;
if( $hlavicka->rn13 == 0 ) $rn13='';
$rm13=$hlavicka->rm13;
if( $hlavicka->rm13 == 0 ) $rm13='';
$r14=$hlavicka->r14;
if( $hlavicka->r14 == 0 ) $r14='';
$rk14=$hlavicka->rk14;
if( $hlavicka->rk14 == 0 ) $rk14='';
$rn14=$hlavicka->rn14;
if( $hlavicka->rn14 == 0 ) $rn14='';
$rm14=$hlavicka->rm14;
if( $hlavicka->rm14 == 0 ) $rm14='';
$r15=$hlavicka->r15;
if( $hlavicka->r15 == 0 ) $r15='';
$rk15=$hlavicka->rk15;
if( $hlavicka->rk15 == 0 ) $rk15='';
$rn15=$hlavicka->rn15;
if( $hlavicka->rn15 == 0 ) $rn15='';
$rm15=$hlavicka->rm15;
if( $hlavicka->rm15 == 0 ) $rm15='';
$r16=$hlavicka->r16;
if( $hlavicka->r16 == 0 ) $r16='';
$rk16=$hlavicka->rk16;
if( $hlavicka->rk16 == 0 ) $rk16='';
$rn16=$hlavicka->rn16;
if( $hlavicka->rn16 == 0 ) $rn16='';
$rm16=$hlavicka->rm16;
if( $hlavicka->rm16 == 0 ) $rm16='';
$r17=$hlavicka->r17;
if( $hlavicka->r17 == 0 ) $r17='';
$rk17=$hlavicka->rk17;
if( $hlavicka->rk17 == 0 ) $rk17='';
$rn17=$hlavicka->rn17;
if( $hlavicka->rn17 == 0 ) $rn17='';
$rm17=$hlavicka->rm17;
if( $hlavicka->rm17 == 0 ) $rm17='';
$r18=$hlavicka->r18;
if( $hlavicka->r18 == 0 ) $r18='';
$rk18=$hlavicka->rk18;
if( $hlavicka->rk18 == 0 ) $rk18='';
$rn18=$hlavicka->rn18;
if( $hlavicka->rn18 == 0 ) $rn18='';
$rm18=$hlavicka->rm18;
if( $hlavicka->rm18 == 0 ) $rm18='';
$r19=$hlavicka->r19;
if( $hlavicka->r19 == 0 ) $r19='';
$rk19=$hlavicka->rk19;
if( $hlavicka->rk19 == 0 ) $rk19='';
$rn19=$hlavicka->rn19;
if( $hlavicka->rn19 == 0 ) $rn19='';
$rm19=$hlavicka->rm19;
if( $hlavicka->rm19 == 0 ) $rm19='';
$r20=$hlavicka->r20;
if( $hlavicka->r20 == 0 ) $r20='';
$rk20=$hlavicka->rk20;
if( $hlavicka->rk20 == 0 ) $rk20='';
$rn20=$hlavicka->rn20;
if( $hlavicka->rn20 == 0 ) $rn20='';
$rm20=$hlavicka->rm20;
if( $hlavicka->rm20 == 0 ) $rm20='';
$r21=$hlavicka->r21;
if( $hlavicka->r21 == 0 ) $r21='';
$rk21=$hlavicka->rk21;
if( $hlavicka->rk21 == 0 ) $rk21='';
$rn21=$hlavicka->rn21;
if( $hlavicka->rn21 == 0 ) $rn21='';
$rm21=$hlavicka->rm21;
if( $hlavicka->rm21 == 0 ) $rm21='';
$r22=$hlavicka->r22;
if( $hlavicka->r22 == 0 ) $r22='';
$rk22=$hlavicka->rk22;
if( $hlavicka->rk22 == 0 ) $rk22='';
$rn22=$hlavicka->rn22;
if( $hlavicka->rn22 == 0 ) $rn22='';
$rm22=$hlavicka->rm22;
if( $hlavicka->rm22 == 0 ) $rm22='';
$r23=$hlavicka->r23;
if( $hlavicka->r23 == 0 ) $r23='';
$rk23=$hlavicka->rk23;
if( $hlavicka->rk23 == 0 ) $rk23='';
$rn23=$hlavicka->rn23;
if( $hlavicka->rn23 == 0 ) $rn23='';
$rm23=$hlavicka->rm23;
if( $hlavicka->rm23 == 0 ) $rm23='';
$r24=$hlavicka->r24;
if( $hlavicka->r24 == 0 ) $r24='';
$rk24=$hlavicka->rk24;
if( $hlavicka->rk24 == 0 ) $rk24='';
$rn24=$hlavicka->rn24;
if( $hlavicka->rn24 == 0 ) $rn24='';
$rm24=$hlavicka->rm24;
if( $hlavicka->rm24 == 0 ) $rm24='';
$r25=$hlavicka->r25;
if( $hlavicka->r25 == 0 ) $r25='';
$rk25=$hlavicka->rk25;
if( $hlavicka->rk25 == 0 ) $rk25='';
$rn25=$hlavicka->rn25;
if( $hlavicka->rn25 == 0 ) $rn25='';
$rm25=$hlavicka->rm25;
if( $hlavicka->rm25 == 0 ) $rm25='';
$r26=$hlavicka->r26;
if( $hlavicka->r26 == 0 ) $r26='';
$rk26=$hlavicka->rk26;
if( $hlavicka->rk26 == 0 ) $rk26='';
$rn26=$hlavicka->rn26;
if( $hlavicka->rn26 == 0 ) $rn26='';
$rm26=$hlavicka->rm26;
if( $hlavicka->rm26 == 0 ) $rm26='';
$r27=$hlavicka->r27;
if( $hlavicka->r27 == 0 ) $r27='';
$rk27=$hlavicka->rk27;
if( $hlavicka->rk27 == 0 ) $rk27='';
$rn27=$hlavicka->rn27;
if( $hlavicka->rn27 == 0 ) $rn27='';
$rm27=$hlavicka->rm27;
if( $hlavicka->rm27 == 0 ) $rm27='';
$r28=$hlavicka->r28;
if( $hlavicka->r28 == 0 ) $r28='';
$rk28=$hlavicka->rk28;
if( $hlavicka->rk28 == 0 ) $rk28='';
$rn28=$hlavicka->rn28;
if( $hlavicka->rn28 == 0 ) $rn28='';
$rm28=$hlavicka->rm28;
if( $hlavicka->rm28 == 0 ) $rm28='';
$r29=$hlavicka->r29;
if( $hlavicka->r29 == 0 ) $r29='';
$rk29=$hlavicka->rk29;
if( $hlavicka->rk29 == 0 ) $rk29='';
$rn29=$hlavicka->rn29;
if( $hlavicka->rn29 == 0 ) $rn29='';
$rm29=$hlavicka->rm29;
if( $hlavicka->rm29 == 0 ) $rm29='';
$r30=$hlavicka->r30;
if( $hlavicka->r30 == 0 ) $r30='';
$rk30=$hlavicka->rk30;
if( $hlavicka->rk30 == 0 ) $rk30='';
$rn30=$hlavicka->rn30;
if( $hlavicka->rn30 == 0 ) $rn30='';
$rm30=$hlavicka->rm30;
if( $hlavicka->rm30 == 0 ) $rm30='';
$r31=$hlavicka->r31;
if( $hlavicka->r31 == 0 ) $r31='';
$rk31=$hlavicka->rk31;
if( $hlavicka->rk31 == 0 ) $rk31='';
$rn31=$hlavicka->rn31;
if( $hlavicka->rn31 == 0 ) $rn31='';
$rm31=$hlavicka->rm31;
if( $hlavicka->rm31 == 0 ) $rm31='';
$r32=$hlavicka->r32;
if( $hlavicka->r32 == 0 ) $r32='';
$rk32=$hlavicka->rk32;
if( $hlavicka->rk32 == 0 ) $rk32='';
$rn32=$hlavicka->rn32;
if( $hlavicka->rn32 == 0 ) $rn32='';
$rm32=$hlavicka->rm32;
if( $hlavicka->rm32 == 0 ) $rm32='';
$r33=$hlavicka->r33;
if( $hlavicka->r33 == 0 ) $r33='';
$rk33=$hlavicka->rk33;
if( $hlavicka->rk33 == 0 ) $rk33='';
$rn33=$hlavicka->rn33;
if( $hlavicka->rn33 == 0 ) $rn33='';
$rm33=$hlavicka->rm33;
if( $hlavicka->rm33 == 0 ) $rm33='';
$r34=$hlavicka->r34;
if( $hlavicka->r34 == 0 ) $r34='';
$rk34=$hlavicka->rk34;
if( $hlavicka->rk34 == 0 ) $rk34='';
$rn34=$hlavicka->rn34;
if( $hlavicka->rn34 == 0 ) $rn34='';
$rm34=$hlavicka->rm34;
if( $hlavicka->rm34 == 0 ) $rm34='';
$r35=$hlavicka->r35;
if( $hlavicka->r35 == 0 ) $r35='';
$rk35=$hlavicka->rk35;
if( $hlavicka->rk35 == 0 ) $rk35='';
$rn35=$hlavicka->rn35;
if( $hlavicka->rn35 == 0 ) $rn35='';
$rm35=$hlavicka->rm35;
if( $hlavicka->rm35 == 0 ) $rm35='';
$r36=$hlavicka->r36;
if( $hlavicka->r36 == 0 ) $r36='';
$rk36=$hlavicka->rk36;
if( $hlavicka->rk36 == 0 ) $rk36='';
$rn36=$hlavicka->rn36;
if( $hlavicka->rn36 == 0 ) $rn36='';
$rm36=$hlavicka->rm36;
if( $hlavicka->rm36 == 0 ) $rm36='';
$r37=$hlavicka->r37;
if( $hlavicka->r37 == 0 ) $r37='';
$rk37=$hlavicka->rk37;
if( $hlavicka->rk37 == 0 ) $rk37='';
$rn37=$hlavicka->rn37;
if( $hlavicka->rn37 == 0 ) $rn37='';
$rm37=$hlavicka->rm37;
if( $hlavicka->rm37 == 0 ) $rm37='';
$r38=$hlavicka->r38;
if( $hlavicka->r38 == 0 ) $r38='';
$rk38=$hlavicka->rk38;
if( $hlavicka->rk38 == 0 ) $rk38='';
$rn38=$hlavicka->rn38;
if( $hlavicka->rn38 == 0 ) $rn38='';
$rm38=$hlavicka->rm38;
if( $hlavicka->rm38 == 0 ) $rm38='';
$r39=$hlavicka->r39;
if( $hlavicka->r39 == 0 ) $r39='';
$rk39=$hlavicka->rk39;
if( $hlavicka->rk39 == 0 ) $rk39='';
$rn39=$hlavicka->rn39;
if( $hlavicka->rn39 == 0 ) $rn39='';
$rm39=$hlavicka->rm39;
if( $hlavicka->rm39 == 0 ) $rm39='';
$r40=$hlavicka->r40;
if( $hlavicka->r40 == 0 ) $r40='';
$rk40=$hlavicka->rk40;
if( $hlavicka->rk40 == 0 ) $rk40='';
$rn40=$hlavicka->rn40;
if( $hlavicka->rn40 == 0 ) $rn40='';
$rm40=$hlavicka->rm40;
if( $hlavicka->rm40 == 0 ) $rm40='';
$r41=$hlavicka->r41;
if( $hlavicka->r41 == 0 ) $r41='';
$rk41=$hlavicka->rk41;
if( $hlavicka->rk41 == 0 ) $rk41='';
$rn41=$hlavicka->rn41;
if( $hlavicka->rn41 == 0 ) $rn41='';
$rm41=$hlavicka->rm41;
if( $hlavicka->rm41 == 0 ) $rm41='';
$r42=$hlavicka->r42;
if( $hlavicka->r42 == 0 ) $r42='';
$rk42=$hlavicka->rk42;
if( $hlavicka->rk42 == 0 ) $rk42='';
$rn42=$hlavicka->rn42;
if( $hlavicka->rn42 == 0 ) $rn42='';
$rm42=$hlavicka->rm42;
if( $hlavicka->rm42 == 0 ) $rm42='';
$r43=$hlavicka->r43;
if( $hlavicka->r43 == 0 ) $r43='';
$rk43=$hlavicka->rk43;
if( $hlavicka->rk43 == 0 ) $rk43='';
$rn43=$hlavicka->rn43;
if( $hlavicka->rn43 == 0 ) $rn43='';
$rm43=$hlavicka->rm43;
if( $hlavicka->rm43 == 0 ) $rm43='';
$r44=$hlavicka->r44;
if( $hlavicka->r44 == 0 ) $r44='';
$rk44=$hlavicka->rk44;
if( $hlavicka->rk44 == 0 ) $rk44='';
$rn44=$hlavicka->rn44;
if( $hlavicka->rn44 == 0 ) $rn44='';
$rm44=$hlavicka->rm44;
if( $hlavicka->rm44 == 0 ) $rm44='';
$r45=$hlavicka->r45;
if( $hlavicka->r45 == 0 ) $r45='';
$rk45=$hlavicka->rk45;
if( $hlavicka->rk45 == 0 ) $rk45='';
$rn45=$hlavicka->rn45;
if( $hlavicka->rn45 == 0 ) $rn45='';
$rm45=$hlavicka->rm45;
if( $hlavicka->rm45 == 0 ) $rm45='';
$r46=$hlavicka->r46;
if( $hlavicka->r46 == 0 ) $r46='';
$rk46=$hlavicka->rk46;
if( $hlavicka->rk46 == 0 ) $rk46='';
$rn46=$hlavicka->rn46;
if( $hlavicka->rn46 == 0 ) $rn46='';
$rm46=$hlavicka->rm46;
if( $hlavicka->rm46 == 0 ) $rm46='';
$r47=$hlavicka->r47;
if( $hlavicka->r47 == 0 ) $r47='';
$rk47=$hlavicka->rk47;
if( $hlavicka->rk47 == 0 ) $rk47='';
$rn47=$hlavicka->rn47;
if( $hlavicka->rn47 == 0 ) $rn47='';
$rm47=$hlavicka->rm47;
if( $hlavicka->rm47 == 0 ) $rm47='';
$r48=$hlavicka->r48;
if( $hlavicka->r48 == 0 ) $r48='';
$rk48=$hlavicka->rk48;
if( $hlavicka->rk48 == 0 ) $rk48='';
$rn48=$hlavicka->rn48;
if( $hlavicka->rn48 == 0 ) $rn48='';
$rm48=$hlavicka->rm48;
if( $hlavicka->rm48 == 0 ) $rm48='';
$r49=$hlavicka->r49;
if( $hlavicka->r49 == 0 ) $r49='';
$rk49=$hlavicka->rk49;
if( $hlavicka->rk49 == 0 ) $rk49='';
$rn49=$hlavicka->rn49;
if( $hlavicka->rn49 == 0 ) $rn49='';
$rm49=$hlavicka->rm49;
if( $hlavicka->rm49 == 0 ) $rm49='';
$r50=$hlavicka->r50;
if( $hlavicka->r50 == 0 ) $r50='';
$rk50=$hlavicka->rk50;
if( $hlavicka->rk50 == 0 ) $rk50='';
$rn50=$hlavicka->rn50;
if( $hlavicka->rn50 == 0 ) $rn50='';
$rm50=$hlavicka->rm50;
if( $hlavicka->rm50 == 0 ) $rm50='';
$r51=$hlavicka->r51;
if( $hlavicka->r51 == 0 ) $r51='';
$rk51=$hlavicka->rk51;
if( $hlavicka->rk51 == 0 ) $rk51='';
$rn51=$hlavicka->rn51;
if( $hlavicka->rn51 == 0 ) $rn51='';
$rm51=$hlavicka->rm51;
if( $hlavicka->rm51 == 0 ) $rm51='';
$r52=$hlavicka->r52;
if( $hlavicka->r52 == 0 ) $r52='';
$rk52=$hlavicka->rk52;
if( $hlavicka->rk52 == 0 ) $rk52='';
$rn52=$hlavicka->rn52;
if( $hlavicka->rn52 == 0 ) $rn52='';
$rm52=$hlavicka->rm52;
if( $hlavicka->rm52 == 0 ) $rm52='';
$r53=$hlavicka->r53;
if( $hlavicka->r53 == 0 ) $r53='';
$rk53=$hlavicka->rk53;
if( $hlavicka->rk53 == 0 ) $rk53='';
$rn53=$hlavicka->rn53;
if( $hlavicka->rn53 == 0 ) $rn53='';
$rm53=$hlavicka->rm53;
if( $hlavicka->rm53 == 0 ) $rm53='';
$r54=$hlavicka->r54;
if( $hlavicka->r54 == 0 ) $r54='';
$rk54=$hlavicka->rk54;
if( $hlavicka->rk54 == 0 ) $rk54='';
$rn54=$hlavicka->rn54;
if( $hlavicka->rn54 == 0 ) $rn54='';
$rm54=$hlavicka->rm54;
if( $hlavicka->rm54 == 0 ) $rm54='';
$r55=$hlavicka->r55;
if( $hlavicka->r55 == 0 ) $r55='';
$rk55=$hlavicka->rk55;
if( $hlavicka->rk55 == 0 ) $rk55='';
$rn55=$hlavicka->rn55;
if( $hlavicka->rn55 == 0 ) $rn55='';
$rm55=$hlavicka->rm55;
if( $hlavicka->rm55 == 0 ) $rm55='';
$r56=$hlavicka->r56;
if( $hlavicka->r56 == 0 ) $r56='';
$rk56=$hlavicka->rk56;
if( $hlavicka->rk56 == 0 ) $rk56='';
$rn56=$hlavicka->rn56;
if( $hlavicka->rn56 == 0 ) $rn56='';
$rm56=$hlavicka->rm56;
if( $hlavicka->rm56 == 0 ) $rm56='';
$r57=$hlavicka->r57;
if( $hlavicka->r57 == 0 ) $r57='';
$rk57=$hlavicka->rk57;
if( $hlavicka->rk57 == 0 ) $rk57='';
$rn57=$hlavicka->rn57;
if( $hlavicka->rn57 == 0 ) $rn57='';
$rm57=$hlavicka->rm57;
if( $hlavicka->rm57 == 0 ) $rm57='';
$r58=$hlavicka->r58;
if( $hlavicka->r58 == 0 ) $r58='';
$rk58=$hlavicka->rk58;
if( $hlavicka->rk58 == 0 ) $rk58='';
$rn58=$hlavicka->rn58;
if( $hlavicka->rn58 == 0 ) $rn58='';
$rm58=$hlavicka->rm58;
if( $hlavicka->rm58 == 0 ) $rm58='';
$r59=$hlavicka->r59;
if( $hlavicka->r59 == 0 ) $r59='';
$rk59=$hlavicka->rk59;
if( $hlavicka->rk59 == 0 ) $rk59='';
$rn59=$hlavicka->rn59;
if( $hlavicka->rn59 == 0 ) $rn59='';
$rm59=$hlavicka->rm59;
if( $hlavicka->rm59 == 0 ) $rm59='';
$r60=$hlavicka->r60;
if( $hlavicka->r60 == 0 ) $r60='';
$rk60=$hlavicka->rk60;
if( $hlavicka->rk60 == 0 ) $rk60='';
$rn60=$hlavicka->rn60;
if( $hlavicka->rn60 == 0 ) $rn60='';
$rm60=$hlavicka->rm60;
if( $hlavicka->rm60 == 0 ) $rm60='';
$r61=$hlavicka->r61;
if( $hlavicka->r61 == 0 ) $r61='';
$rk61=$hlavicka->rk61;
if( $hlavicka->rk61 == 0 ) $rk61='';
$rn61=$hlavicka->rn61;
if( $hlavicka->rn61 == 0 ) $rn61='';
$rm61=$hlavicka->rm61;
if( $hlavicka->rm61 == 0 ) $rm61='';
$r62=$hlavicka->r62;
if( $hlavicka->r62 == 0 ) $r62='';
$rk62=$hlavicka->rk62;
if( $hlavicka->rk62 == 0 ) $rk62='';
$rn62=$hlavicka->rn62;
if( $hlavicka->rn62 == 0 ) $rn62='';
$rm62=$hlavicka->rm62;
if( $hlavicka->rm62 == 0 ) $rm62='';
$r63=$hlavicka->r63;
if( $hlavicka->r63 == 0 ) $r63='';
$rk63=$hlavicka->rk63;
if( $hlavicka->rk63 == 0 ) $rk63='';
$rn63=$hlavicka->rn63;
if( $hlavicka->rn63 == 0 ) $rn63='';
$rm63=$hlavicka->rm63;
if( $hlavicka->rm63 == 0 ) $rm63='';
$r64=$hlavicka->r64;
if( $hlavicka->r64 == 0 ) $r64='';
$rk64=$hlavicka->rk64;
if( $hlavicka->rk64 == 0 ) $rk64='';
$rn64=$hlavicka->rn64;
if( $hlavicka->rn64 == 0 ) $rn64='';
$rm64=$hlavicka->rm64;
if( $hlavicka->rm64 == 0 ) $rm64='';
$r65=$hlavicka->r65;
if( $hlavicka->r65 == 0 ) $r65='';
$rk65=$hlavicka->rk65;
if( $hlavicka->rk65 == 0 ) $rk65='';
$rn65=$hlavicka->rn65;
if( $hlavicka->rn65 == 0 ) $rn65='';
$rm65=$hlavicka->rm65;
if( $hlavicka->rm65 == 0 ) $rm65='';
$r66=$hlavicka->r66;
if( $hlavicka->r66 == 0 ) $r66='';
$rk66=$hlavicka->rk66;
if( $hlavicka->rk66 == 0 ) $rk66='';
$rn66=$hlavicka->rn66;
if( $hlavicka->rn66 == 0 ) $rn66='';
$rm66=$hlavicka->rm66;
if( $hlavicka->rm66 == 0 ) $rm66='';
$r67=$hlavicka->r67;
if( $hlavicka->r67 == 0 ) $r67='';
$rk67=$hlavicka->rk67;
if( $hlavicka->rk67 == 0 ) $rk67='';
$rn67=$hlavicka->rn67;
if( $hlavicka->rn67 == 0 ) $rn67='';
$rm67=$hlavicka->rm67;
if( $hlavicka->rm67 == 0 ) $rm67='';
$r68=$hlavicka->r68;
if( $hlavicka->r68 == 0 ) $r68='';
$rk68=$hlavicka->rk68;
if( $hlavicka->rk68 == 0 ) $rk68='';
$rn68=$hlavicka->rn68;
if( $hlavicka->rn68 == 0 ) $rn68='';
$rm68=$hlavicka->rm68;
if( $hlavicka->rm68 == 0 ) $rm68='';
$r69=$hlavicka->r69;
if( $hlavicka->r69 == 0 ) $r69='';
$rk69=$hlavicka->rk69;
if( $hlavicka->rk69 == 0 ) $rk69='';
$rn69=$hlavicka->rn69;
if( $hlavicka->rn69 == 0 ) $rn69='';
$rm69=$hlavicka->rm69;
if( $hlavicka->rm69 == 0 ) $rm69='';
$r70=$hlavicka->r70;
if( $hlavicka->r70 == 0 ) $r70='';
$rk70=$hlavicka->rk70;
if( $hlavicka->rk70 == 0 ) $rk70='';
$rn70=$hlavicka->rn70;
if( $hlavicka->rn70 == 0 ) $rn70='';
$rm70=$hlavicka->rm70;
if( $hlavicka->rm70 == 0 ) $rm70='';
$r71=$hlavicka->r71;
if( $hlavicka->r71 == 0 ) $r71='';
$rk71=$hlavicka->rk71;
if( $hlavicka->rk71 == 0 ) $rk71='';
$rn71=$hlavicka->rn71;
if( $hlavicka->rn71 == 0 ) $rn71='';
$rm71=$hlavicka->rm71;
if( $hlavicka->rm71 == 0 ) $rm71='';
$r72=$hlavicka->r72;
if( $hlavicka->r72 == 0 ) $r72='';
$rk72=$hlavicka->rk72;
if( $hlavicka->rk72 == 0 ) $rk72='';
$rn72=$hlavicka->rn72;
if( $hlavicka->rn72 == 0 ) $rn72='';
$rm72=$hlavicka->rm72;
if( $hlavicka->rm72 == 0 ) $rm72='';
$r73=$hlavicka->r73;
if( $hlavicka->r73 == 0 ) $r73='';
$rk73=$hlavicka->rk73;
if( $hlavicka->rk73 == 0 ) $rk73='';
$rn73=$hlavicka->rn73;
if( $hlavicka->rn73 == 0 ) $rn73='';
$rm73=$hlavicka->rm73;
if( $hlavicka->rm73 == 0 ) $rm73='';
$r74=$hlavicka->r74;
if( $hlavicka->r74 == 0 ) $r74='';
$rk74=$hlavicka->rk74;
if( $hlavicka->rk74 == 0 ) $rk74='';
$rn74=$hlavicka->rn74;
if( $hlavicka->rn74 == 0 ) $rn74='';
$rm74=$hlavicka->rm74;
if( $hlavicka->rm74 == 0 ) $rm74='';
$r75=$hlavicka->r75;
if( $hlavicka->r75 == 0 ) $r75='';
$rk75=$hlavicka->rk75;
if( $hlavicka->rk75 == 0 ) $rk75='';
$rn75=$hlavicka->rn75;
if( $hlavicka->rn75 == 0 ) $rn75='';
$rm75=$hlavicka->rm75;
if( $hlavicka->rm75 == 0 ) $rm75='';
$r76=$hlavicka->r76;
if( $hlavicka->r76 == 0 ) $r76='';
$rk76=$hlavicka->rk76;
if( $hlavicka->rk76 == 0 ) $rk76='';
$rn76=$hlavicka->rn76;
if( $hlavicka->rn76 == 0 ) $rn76='';
$rm76=$hlavicka->rm76;
if( $hlavicka->rm76 == 0 ) $rm76='';
$r77=$hlavicka->r77;
if( $hlavicka->r77 == 0 ) $r77='';
$rk77=$hlavicka->rk77;
if( $hlavicka->rk77 == 0 ) $rk77='';
$rn77=$hlavicka->rn77;
if( $hlavicka->rn77 == 0 ) $rn77='';
$rm77=$hlavicka->rm77;
if( $hlavicka->rm77 == 0 ) $rm77='';
$r78=$hlavicka->r78;
if( $hlavicka->r78 == 0 ) $r78='';
$rk78=$hlavicka->rk78;
if( $hlavicka->rk78 == 0 ) $rk78='';
$rn78=$hlavicka->rn78;
if( $hlavicka->rn78 == 0 ) $rn78='';
$rm78=$hlavicka->rm78;
if( $hlavicka->rm78 == 0 ) $rm78='';
$r79=$hlavicka->r79;
if( $hlavicka->r79 == 0 ) $r79='';
$rk79=$hlavicka->rk79;
if( $hlavicka->rk79 == 0 ) $rk79='';
$rn79=$hlavicka->rn79;
if( $hlavicka->rn79 == 0 ) $rn79='';
$rm79=$hlavicka->rm79;
if( $hlavicka->rm79 == 0 ) $rm79='';
$r80=$hlavicka->r80;
if( $hlavicka->r80 == 0 ) $r80='';
$rk80=$hlavicka->rk80;
if( $hlavicka->rk80 == 0 ) $rk80='';
$rn80=$hlavicka->rn80;
if( $hlavicka->rn80 == 0 ) $rn80='';
$rm80=$hlavicka->rm80;
if( $hlavicka->rm80 == 0 ) $rm80='';
$r81=$hlavicka->r81;
if( $hlavicka->r81 == 0 ) $r81='';
$rk81=$hlavicka->rk81;
if( $hlavicka->rk81 == 0 ) $rk81='';
$rn81=$hlavicka->rn81;
if( $hlavicka->rn81 == 0 ) $rn81='';
$rm81=$hlavicka->rm81;
if( $hlavicka->rm81 == 0 ) $rm81='';
$r82=$hlavicka->r82;
if( $hlavicka->r82 == 0 ) $r82='';
$rk82=$hlavicka->rk82;
if( $hlavicka->rk82 == 0 ) $rk82='';
$rn82=$hlavicka->rn82;
if( $hlavicka->rn82 == 0 ) $rn82='';
$rm82=$hlavicka->rm82;
if( $hlavicka->rm82 == 0 ) $rm82='';
$r83=$hlavicka->r83;
if( $hlavicka->r83 == 0 ) $r83='';
$rk83=$hlavicka->rk83;
if( $hlavicka->rk83 == 0 ) $rk83='';
$rn83=$hlavicka->rn83;
if( $hlavicka->rn83 == 0 ) $rn83='';
$rm83=$hlavicka->rm83;
if( $hlavicka->rm83 == 0 ) $rm83='';
$r84=$hlavicka->r84;
if( $hlavicka->r84 == 0 ) $r84='';
$rk84=$hlavicka->rk84;
if( $hlavicka->rk84 == 0 ) $rk84='';
$rn84=$hlavicka->rn84;
if( $hlavicka->rn84 == 0 ) $rn84='';
$rm84=$hlavicka->rm84;
if( $hlavicka->rm84 == 0 ) $rm84='';
$r85=$hlavicka->r85;
if( $hlavicka->r85 == 0 ) $r85='';
$rk85=$hlavicka->rk85;
if( $hlavicka->rk85 == 0 ) $rk85='';
$rn85=$hlavicka->rn85;
if( $hlavicka->rn85 == 0 ) $rn85='';
$rm85=$hlavicka->rm85;
if( $hlavicka->rm85 == 0 ) $rm85='';
$r86=$hlavicka->r86;
if( $hlavicka->r86 == 0 ) $r86='';
$rk86=$hlavicka->rk86;
if( $hlavicka->rk86 == 0 ) $rk86='';
$rn86=$hlavicka->rn86;
if( $hlavicka->rn86 == 0 ) $rn86='';
$rm86=$hlavicka->rm86;
if( $hlavicka->rm86 == 0 ) $rm86='';
$r87=$hlavicka->r87;
if( $hlavicka->r87 == 0 ) $r87='';
$rk87=$hlavicka->rk87;
if( $hlavicka->rk87 == 0 ) $rk87='';
$rn87=$hlavicka->rn87;
if( $hlavicka->rn87 == 0 ) $rn87='';
$rm87=$hlavicka->rm87;
if( $hlavicka->rm87 == 0 ) $rm87='';
$r88=$hlavicka->r88;
if( $hlavicka->r88 == 0 ) $r88='';
$rk88=$hlavicka->rk88;
if( $hlavicka->rk88 == 0 ) $rk88='';
$rn88=$hlavicka->rn88;
if( $hlavicka->rn88 == 0 ) $rn88='';
$rm88=$hlavicka->rm88;
if( $hlavicka->rm88 == 0 ) $rm88='';
$r89=$hlavicka->r89;
if( $hlavicka->r89 == 0 ) $r89='';
$rk89=$hlavicka->rk89;
if( $hlavicka->rk89 == 0 ) $rk89='';
$rn89=$hlavicka->rn89;
if( $hlavicka->rn89 == 0 ) $rn89='';
$rm89=$hlavicka->rm89;
if( $hlavicka->rm89 == 0 ) $rm89='';
$r90=$hlavicka->r90;
if( $hlavicka->r90 == 0 ) $r90='';
$rk90=$hlavicka->rk90;
if( $hlavicka->rk90 == 0 ) $rk90='';
$rn90=$hlavicka->rn90;
if( $hlavicka->rn90 == 0 ) $rn90='';
$rm90=$hlavicka->rm90;
if( $hlavicka->rm90 == 0 ) $rm90='';
$r91=$hlavicka->r91;
if( $hlavicka->r91 == 0 ) $r91='';
$rk91=$hlavicka->rk91;
if( $hlavicka->rk91 == 0 ) $rk91='';
$rn91=$hlavicka->rn91;
if( $hlavicka->rn91 == 0 ) $rn91='';
$rm91=$hlavicka->rm91;
if( $hlavicka->rm91 == 0 ) $rm91='';
$r92=$hlavicka->r92;
if( $hlavicka->r92 == 0 ) $r92='';
$rk92=$hlavicka->rk92;
if( $hlavicka->rk92 == 0 ) $rk92='';
$rn92=$hlavicka->rn92;
if( $hlavicka->rn92 == 0 ) $rn92='';
$rm92=$hlavicka->rm92;
if( $hlavicka->rm92 == 0 ) $rm92='';
$r93=$hlavicka->r93;
if( $hlavicka->r93 == 0 ) $r93='';
$rk93=$hlavicka->rk93;
if( $hlavicka->rk93 == 0 ) $rk93='';
$rn93=$hlavicka->rn93;
if( $hlavicka->rn93 == 0 ) $rn93='';
$rm93=$hlavicka->rm93;
if( $hlavicka->rm93 == 0 ) $rm93='';
$r94=$hlavicka->r94;
if( $hlavicka->r94 == 0 ) $r94='';
$rk94=$hlavicka->rk94;
if( $hlavicka->rk94 == 0 ) $rk94='';
$rn94=$hlavicka->rn94;
if( $hlavicka->rn94 == 0 ) $rn94='';
$rm94=$hlavicka->rm94;
if( $hlavicka->rm94 == 0 ) $rm94='';
$r95=$hlavicka->r95;
if( $hlavicka->r95 == 0 ) $r95='';
$rk95=$hlavicka->rk95;
if( $hlavicka->rk95 == 0 ) $rk95='';
$rn95=$hlavicka->rn95;
if( $hlavicka->rn95 == 0 ) $rn95='';
$rm95=$hlavicka->rm95;
if( $hlavicka->rm95 == 0 ) $rm95='';
$r96=$hlavicka->r96;
if( $hlavicka->r96 == 0 ) $r96='';
$rk96=$hlavicka->rk96;
if( $hlavicka->rk96 == 0 ) $rk96='';
$rn96=$hlavicka->rn96;
if( $hlavicka->rn96 == 0 ) $rn96='';
$rm96=$hlavicka->rm96;
if( $hlavicka->rm96 == 0 ) $rm96='';
$r97=$hlavicka->r97;
if( $hlavicka->r97 == 0 ) $r97='';
$rk97=$hlavicka->rk97;
if( $hlavicka->rk97 == 0 ) $rk97='';
$rn97=$hlavicka->rn97;
if( $hlavicka->rn97 == 0 ) $rn97='';
$rm97=$hlavicka->rm97;
if( $hlavicka->rm97 == 0 ) $rm97='';
$r98=$hlavicka->r98;
if( $hlavicka->r98 == 0 ) $r98='';
$rk98=$hlavicka->rk98;
if( $hlavicka->rk98 == 0 ) $rk98='';
$rn98=$hlavicka->rn98;
if( $hlavicka->rn98 == 0 ) $rn98='';
$rm98=$hlavicka->rm98;
if( $hlavicka->rm98 == 0 ) $rm98='';
$r99=$hlavicka->r99;
if( $hlavicka->r99 == 0 ) $r99='';
$rk99=$hlavicka->rk99;
if( $hlavicka->rk99 == 0 ) $rk99='';
$rn99=$hlavicka->rn99;
if( $hlavicka->rn99 == 0 ) $rn99='';
$rm99=$hlavicka->rm99;
if( $hlavicka->rm99 == 0 ) $rm99='';
$r100=$hlavicka->r100;
if( $hlavicka->r100 == 0 ) $r100='';
$rk100=$hlavicka->rk100;
if( $hlavicka->rk100 == 0 ) $rk100='';
$rn100=$hlavicka->rn100;
if( $hlavicka->rn100 == 0 ) $rn100='';
$rm100=$hlavicka->rm100;
if( $hlavicka->rm100 == 0 ) $rm100='';
$r101=$hlavicka->r101;
if( $hlavicka->r101 == 0 ) $r101='';
$rk101=$hlavicka->rk101;
if( $hlavicka->rk101 == 0 ) $rk101='';
$rn101=$hlavicka->rn101;
if( $hlavicka->rn101 == 0 ) $rn101='';
$rm101=$hlavicka->rm101;
if( $hlavicka->rm101 == 0 ) $rm101='';
$r102=$hlavicka->r102;
if( $hlavicka->r102 == 0 ) $r102='';
$rk102=$hlavicka->rk102;
if( $hlavicka->rk102 == 0 ) $rk102='';
$rn102=$hlavicka->rn102;
if( $hlavicka->rn102 == 0 ) $rn102='';
$rm102=$hlavicka->rm102;
if( $hlavicka->rm102 == 0 ) $rm102='';
$r103=$hlavicka->r103;
if( $hlavicka->r103 == 0 ) $r103='';
$rk103=$hlavicka->rk103;
if( $hlavicka->rk103 == 0 ) $rk103='';
$rn103=$hlavicka->rn103;
if( $hlavicka->rn103 == 0 ) $rn103='';
$rm103=$hlavicka->rm103;
if( $hlavicka->rm103 == 0 ) $rm103='';
$r104=$hlavicka->r104;
if( $hlavicka->r104 == 0 ) $r104='';
$rk104=$hlavicka->rk104;
if( $hlavicka->rk104 == 0 ) $rk104='';
$rn104=$hlavicka->rn104;
if( $hlavicka->rn104 == 0 ) $rn104='';
$rm104=$hlavicka->rm104;
if( $hlavicka->rm104 == 0 ) $rm104='';
$r105=$hlavicka->r105;
if( $hlavicka->r105 == 0 ) $r105='';
$rk105=$hlavicka->rk105;
if( $hlavicka->rk105 == 0 ) $rk105='';
$rn105=$hlavicka->rn105;
if( $hlavicka->rn105 == 0 ) $rn105='';
$rm105=$hlavicka->rm105;
if( $hlavicka->rm105 == 0 ) $rm105='';
$r106=$hlavicka->r106;
if( $hlavicka->r106 == 0 ) $r106='';
$rk106=$hlavicka->rk106;
if( $hlavicka->rk106 == 0 ) $rk106='';
$rn106=$hlavicka->rn106;
if( $hlavicka->rn106 == 0 ) $rn106='';
$rm106=$hlavicka->rm106;
if( $hlavicka->rm106 == 0 ) $rm106='';
$r107=$hlavicka->r107;
if( $hlavicka->r107 == 0 ) $r107='';
$rk107=$hlavicka->rk107;
if( $hlavicka->rk107 == 0 ) $rk107='';
$rn107=$hlavicka->rn107;
if( $hlavicka->rn107 == 0 ) $rn107='';
$rm107=$hlavicka->rm107;
if( $hlavicka->rm107 == 0 ) $rm107='';
$r108=$hlavicka->r108;
if( $hlavicka->r108 == 0 ) $r108='';
$rk108=$hlavicka->rk108;
if( $hlavicka->rk108 == 0 ) $rk108='';
$rn108=$hlavicka->rn108;
if( $hlavicka->rn108 == 0 ) $rn108='';
$rm108=$hlavicka->rm108;
if( $hlavicka->rm108 == 0 ) $rm108='';
$r109=$hlavicka->r109;
if( $hlavicka->r109 == 0 ) $r109='';
$rk109=$hlavicka->rk109;
if( $hlavicka->rk109 == 0 ) $rk109='';
$rn109=$hlavicka->rn109;
if( $hlavicka->rn109 == 0 ) $rn109='';
$rm109=$hlavicka->rm109;
if( $hlavicka->rm109 == 0 ) $rm109='';
$r110=$hlavicka->r110;
if( $hlavicka->r110 == 0 ) $r110='';
$rk110=$hlavicka->rk110;
if( $hlavicka->rk110 == 0 ) $rk110='';
$rn110=$hlavicka->rn110;
if( $hlavicka->rn110 == 0 ) $rn110='';
$rm110=$hlavicka->rm110;
if( $hlavicka->rm110 == 0 ) $rm110='';
$r111=$hlavicka->r111;
if( $hlavicka->r111 == 0 ) $r111='';
$rk111=$hlavicka->rk111;
if( $hlavicka->rk111 == 0 ) $rk111='';
$rn111=$hlavicka->rn111;
if( $hlavicka->rn111 == 0 ) $rn111='';
$rm111=$hlavicka->rm111;
if( $hlavicka->rm111 == 0 ) $rm111='';
$r112=$hlavicka->r112;
if( $hlavicka->r112 == 0 ) $r112='';
$rk112=$hlavicka->rk112;
if( $hlavicka->rk112 == 0 ) $rk112='';
$rn112=$hlavicka->rn112;
if( $hlavicka->rn112 == 0 ) $rn112='';
$rm112=$hlavicka->rm112;
if( $hlavicka->rm112 == 0 ) $rm112='';
$r113=$hlavicka->r113;
if( $hlavicka->r113 == 0 ) $r113='';
$rk113=$hlavicka->rk113;
if( $hlavicka->rk113 == 0 ) $rk113='';
$rn113=$hlavicka->rn113;
if( $hlavicka->rn113 == 0 ) $rn113='';
$rm113=$hlavicka->rm113;
if( $hlavicka->rm113 == 0 ) $rm113='';
$r114=$hlavicka->r114;
if( $hlavicka->r114 == 0 ) $r114='';
$rk114=$hlavicka->rk114;
if( $hlavicka->rk114 == 0 ) $rk114='';
$rn114=$hlavicka->rn114;
if( $hlavicka->rn114 == 0 ) $rn114='';
$rm114=$hlavicka->rm114;
if( $hlavicka->rm114 == 0 ) $rm114='';
$r115=$hlavicka->r115;
if( $hlavicka->r115 == 0 ) $r115='';
$rk115=$hlavicka->rk115;
if( $hlavicka->rk115 == 0 ) $rk115='';
$rn115=$hlavicka->rn115;
if( $hlavicka->rn115 == 0 ) $rn115='';
$rm115=$hlavicka->rm115;
if( $hlavicka->rm115 == 0 ) $rm115='';
$r116=$hlavicka->r116;
if( $hlavicka->r116 == 0 ) $r116='';
$rk116=$hlavicka->rk116;
if( $hlavicka->rk116 == 0 ) $rk116='';
$rn116=$hlavicka->rn116;
if( $hlavicka->rn116 == 0 ) $rn116='';
$rm116=$hlavicka->rm116;
if( $hlavicka->rm116 == 0 ) $rm116='';
$r117=$hlavicka->r117;
if( $hlavicka->r117 == 0 ) $r117='';
$rk117=$hlavicka->rk117;
if( $hlavicka->rk117 == 0 ) $rk117='';
$rn117=$hlavicka->rn117;
if( $hlavicka->rn117 == 0 ) $rn117='';
$rm117=$hlavicka->rm117;
if( $hlavicka->rm117 == 0 ) $rm117='';

//vypocitaj rm991,992,993 ako sucet to uz od 2012 zbytocne lebo kontrolne cisla zrusili
$nnne=1;
if( $nnne == 0 ) 
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
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/suvaha_str1.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/suvaha_str1.jpg',10,26,193,260); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',10);
$pdf->Cell(190,35,"     ","0",1,"L");


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
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

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

$pdf->SetFont('arial','',12);
$pdf->Cell(190,6,"     ","0",1,"L");
$pdf->Cell(68,6," ","0",0,"R");$pdf->Cell(34,6,"$datk_sk","0",1,"C");

//nacitaj obdobie z priznanie_po
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_po");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $obdd1=$riadok->obdd1;
  $obdm1=$riadok->obdm1;
  $obdr1=$riadok->obdr1;
  $obdd2=$riadok->obdd2;
  $obdm2=$riadok->obdm2;
  $obdr2=$riadok->obdr2;
  $obmd1=$riadok->obmd1;
  $obmm1=$riadok->obmm1;
  $obmr1=$riadok->obmr1;
  $obmd2=$riadok->obmd2;
  $obmm2=$riadok->obmm2;
  $obmr2=$riadok->obmr2;
  }

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;


//obdobie
$me1="0"; $me2="1";
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$me1=substr($obdm1,0,1);
$me2=substr($obdm1,1,1); 
}

$pdf->Cell(190,17,"     ","0",1,"L");
$pdf->Cell(60,5," ","0",0,"R");$pdf->Cell(4,5,"$me1","0",0,"C");$pdf->Cell(7,5,"$me2","0",0,"C");

$A=substr($kli_rdph,0,1);
$B=substr($kli_rdph,1,1);
$C=substr($kli_rdph,2,1);
$D=substr($kli_rdph,3,1);

$pdf->Cell(6,5," ","0",0,"R");$pdf->Cell(6,5,"$A","0",0,"C");
$pdf->Cell(6,5,"$B","0",0,"C");$pdf->Cell(6,5,"$C","0",0,"C");
$pdf->Cell(6,5,"$D","0",0,"C");


$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1); 
}

$pdf->Cell(19,5," ","0",0,"R");$pdf->Cell(6,5,"$Am","0",0,"C");$pdf->Cell(4,5,"$Bm","0",0,"C");

$pdf->Cell(7,5," ","0",0,"R");$pdf->Cell(6,5,"$A","0",0,"C");
$pdf->Cell(6,5,"$B","0",0,"C");$pdf->Cell(6,5,"$C","0",0,"C");
$pdf->Cell(6,5,"$D","0",0,"C");

$pdf->Cell(7,5," ","0",1,"C");

//predchadzajuce obdobie
$mep1="0"; $mep2="1";
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$mep1=substr($obmm1,0,1);
$mep2=substr($obmm1,1,1); 
}

$pdf->Cell(190,12,"     ","0",1,"L");
$pdf->Cell(60,5," ","0",0,"R");$pdf->Cell(4,5,"$mep1","0",0,"C");$pdf->Cell(7,5,"$mep2","0",0,"C");

$kli_prdph=$kli_rdph-1;

$A=substr($kli_prdph,0,1);
$B=substr($kli_prdph,1,1);
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);

$pdf->Cell(6,5," ","0",0,"R");$pdf->Cell(6,5,"$A","0",0,"C");
$pdf->Cell(6,5,"$B","0",0,"C");$pdf->Cell(6,5,"$C","0",0,"C");
$pdf->Cell(6,5,"$D","0",0,"C");

$mepm1="1"; $mepm2="2";
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1); 
}

$pdf->Cell(19,5," ","0",0,"R");$pdf->Cell(6,5,"$mepm1","0",0,"C");$pdf->Cell(4,5,"$mepm2","0",0,"C");


$pdf->Cell(7,5," ","0",0,"R");$pdf->Cell(6,5,"$A","0",0,"C");
$pdf->Cell(6,5,"$B","0",0,"C");$pdf->Cell(6,5,"$C","0",0,"C");
$pdf->Cell(6,5,"$D","0",0,"C");

$pdf->Cell(7,11," ","0",1,"C");


//dic
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

$pdf->Cell(190,10,"     ","0",1,"L");

$pdf->Cell(4,6," ","0",0,"R");$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(6,6,"$F","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(5,6,"$H","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");
$pdf->Cell(6,6,"$J","0",0,"C");

//riadna uzavierka
$pdf->Cell(41,10," ","0",0,"C");$pdf->Cell(7,10,"x","0",0,"C");$pdf->Cell(7,10," ","0",1,"C");

//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(190,3,"     ","0",1,"L");
$pdf->Cell(3,6," ","0",0,"R");$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(6,6,"$F","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(5,6,"$H","0",0,"C");

$pdf->Cell(7,5," ","0",1,"C");

//nazov r1
$pdf->SetFont('arial','',9);
$pdf->Cell(190,27,"     ","0",1,"L");

$A=substr($fir_fnaz,0,1);$B=substr($fir_fnaz,1,1);$C=substr($fir_fnaz,2,1);$D=substr($fir_fnaz,3,1);$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);$G=substr($fir_fnaz,6,1);$H=substr($fir_fnaz,7,1);$I=substr($fir_fnaz,8,1);$J=substr($fir_fnaz,9,1);

$K=substr($fir_fnaz,10,1);$L=substr($fir_fnaz,11,1);$M=substr($fir_fnaz,12,1);$N=substr($fir_fnaz,13,1);$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);$R=substr($fir_fnaz,16,1);$S=substr($fir_fnaz,17,1);$T=substr($fir_fnaz,18,1);$U=substr($fir_fnaz,19,1);

$V=substr($fir_fnaz,20,1);$W=substr($fir_fnaz,21,1);$X=substr($fir_fnaz,22,1);$Y=substr($fir_fnaz,23,1);$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);$B1=substr($fir_fnaz,26,1);$C1=substr($fir_fnaz,27,1);$D1=substr($fir_fnaz,28,1);$E1=substr($fir_fnaz,29,1);

$pdf->Cell(3,5," ","0",0,"R");$pdf->Cell(6,5,"$A","0",0,"C");
$pdf->Cell(5,5,"$B","0",0,"C");$pdf->Cell(6,5,"$C","0",0,"C");
$pdf->Cell(6,5,"$D","0",0,"C");$pdf->Cell(6,5,"$E","0",0,"C");
$pdf->Cell(5,5,"$F","0",0,"C");$pdf->Cell(6,5,"$G","0",0,"C");
$pdf->Cell(6,5,"$H","0",0,"C");$pdf->Cell(6,5,"$I","0",0,"C");
$pdf->Cell(6,5,"$J","0",0,"C");

$pdf->Cell(6,5,"$K","0",0,"C");
$pdf->Cell(6,5,"$L","0",0,"C");$pdf->Cell(6,5,"$M","0",0,"C");
$pdf->Cell(6,5,"$N","0",0,"C");$pdf->Cell(6,5,"$O","0",0,"C");
$pdf->Cell(5,5,"$P","0",0,"C");$pdf->Cell(6,5,"$R","0",0,"C");
$pdf->Cell(6,5,"$S","0",0,"C");$pdf->Cell(6,5,"$T","0",0,"C");
$pdf->Cell(6,5,"$U","0",0,"C");

$pdf->Cell(6,5,"$V","0",0,"C");
$pdf->Cell(6,5,"$W","0",0,"C");$pdf->Cell(5,5,"$X","0",0,"C");
$pdf->Cell(6,5,"$Y","0",0,"C");$pdf->Cell(6,5,"$Z","0",0,"C");
$pdf->Cell(6,5,"$A1","0",0,"C");
$pdf->Cell(6,5,"$B1","0",0,"C");$pdf->Cell(6,5,"$C1","0",0,"C");
$pdf->Cell(6,5,"$D1","0",0,"C");$pdf->Cell(6,5,"$E1","0",0,"C");

$pdf->Cell(1,5," ","0",1,"C");

//nazov r2
$pdf->Cell(190,1,"     ","0",1,"L");
$fir_fnazr2=substr($fir_fnaz,30,30);

$A=substr($fir_fnazr2,0,1);$B=substr($fir_fnazr2,1,1);$C=substr($fir_fnazr2,2,1);$D=substr($fir_fnazr2,3,1);$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);$G=substr($fir_fnazr2,6,1);$H=substr($fir_fnazr2,7,1);$I=substr($fir_fnazr2,8,1);$J=substr($fir_fnazr2,9,1);

$K=substr($fir_fnazr2,10,1);$L=substr($fir_fnazr2,11,1);$M=substr($fir_fnazr2,12,1);$N=substr($fir_fnazr2,13,1);$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);$R=substr($fir_fnazr2,16,1);$S=substr($fir_fnazr2,17,1);$T=substr($fir_fnazr2,18,1);$U=substr($fir_fnazr2,19,1);

$V=substr($fir_fnazr2,20,1);$W=substr($fir_fnazr2,21,1);$X=substr($fir_fnazr2,22,1);$Y=substr($fir_fnazr2,23,1);$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);$B1=substr($fir_fnazr2,26,1);$C1=substr($fir_fnazr2,27,1);$D1=substr($fir_fnazr2,28,1);$E1=substr($fir_fnazr2,29,1);

$pdf->Cell(3,6," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(5,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");
$pdf->Cell(6,6,"$J","0",0,"C");

$pdf->Cell(6,6,"$K","0",0,"C");
$pdf->Cell(6,6,"$L","0",0,"C");$pdf->Cell(6,6,"$M","0",0,"C");
$pdf->Cell(6,6,"$N","0",0,"C");$pdf->Cell(6,6,"$O","0",0,"C");
$pdf->Cell(5,6,"$P","0",0,"C");$pdf->Cell(6,6,"$R","0",0,"C");
$pdf->Cell(6,6,"$S","0",0,"C");$pdf->Cell(6,6,"$T","0",0,"C");
$pdf->Cell(6,6,"$U","0",0,"C");

$pdf->Cell(5,6,"$V","0",0,"C");
$pdf->Cell(6,6,"$W","0",0,"C");$pdf->Cell(6,6,"$X","0",0,"C");
$pdf->Cell(6,6,"$Y","0",0,"C");$pdf->Cell(6,6,"$Z","0",0,"C");
$pdf->Cell(5,6,"$A1","0",0,"C");
$pdf->Cell(6,6,"$B1","0",0,"C");$pdf->Cell(6,6,"$C1","0",0,"C");
$pdf->Cell(6,6,"$D1","0",0,"C");$pdf->Cell(6,6,"$E1","0",0,"C");

$pdf->Cell(1,6," ","0",1,"C");

//ulica a cislo
$pdf->Cell(190,12,"     ","0",1,"L");

$fir_fulicis=$fir_fuli." ".$fir_fcdm;

$A=substr($fir_fulicis,0,1);$B=substr($fir_fulicis,1,1);$C=substr($fir_fulicis,2,1);$D=substr($fir_fulicis,3,1);$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);$G=substr($fir_fulicis,6,1);$H=substr($fir_fulicis,7,1);$I=substr($fir_fulicis,8,1);$J=substr($fir_fulicis,9,1);

$K=substr($fir_fulicis,10,1);$L=substr($fir_fulicis,11,1);$M=substr($fir_fulicis,12,1);$N=substr($fir_fulicis,13,1);$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);$R=substr($fir_fulicis,16,1);$S=substr($fir_fulicis,17,1);$T=substr($fir_fulicis,18,1);$U=substr($fir_fulicis,19,1);

$V=substr($fir_fulicis,20,1);$W=substr($fir_fulicis,21,1);$X=substr($fir_fulicis,22,1);$Y=substr($fir_fulicis,23,1);$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);$B1=substr($fir_fulicis,26,1);$C1=substr($fir_fulicis,27,1);$D1=substr($fir_fulicis,28,1);$E1=substr($fir_fulicis,29,1);

$pdf->Cell(2,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");$pdf->Cell(7,6,"$J","0",0,"C");

$pdf->Cell(4,6,"$K","0",0,"C");$pdf->Cell(6,6,"$L","0",0,"C");$pdf->Cell(6,6,"$M","0",0,"C");$pdf->Cell(6,6,"$N","0",0,"C");$pdf->Cell(6,6,"$O","0",0,"C");
$pdf->Cell(6,6,"$P","0",0,"C");$pdf->Cell(6,6,"$R","0",0,"C");$pdf->Cell(6,6,"$S","0",0,"C");$pdf->Cell(6,6,"$T","0",0,"C");$pdf->Cell(6,6,"$U","0",0,"C");

$pdf->Cell(6,6,"$V","0",0,"C");$pdf->Cell(6,6,"$W","0",0,"C");$pdf->Cell(6,6,"$X","0",0,"C");$pdf->Cell(5,6,"$Y","0",0,"C");$pdf->Cell(6,6,"$Z","0",0,"C");
$pdf->Cell(6,6,"$A1","0",0,"C");$pdf->Cell(6,6,"$B1","0",0,"C");$pdf->Cell(6,6,"$C1","0",0,"C");$pdf->Cell(6,6,"$D1","0",0,"C");$pdf->Cell(6,6,"$E1","0",0,"C");

$pdf->Cell(1,5," ","0",1,"C");

//psc mesto
$pdf->Cell(190,17,"     ","0",1,"L");

$fir_fpsc=str_replace(" ","",$fir_fpsc);
$fir_fulicis=$fir_fpsc."  ".$fir_fmes;

$A=substr($fir_fulicis,0,1);$B=substr($fir_fulicis,1,1);$C=substr($fir_fulicis,2,1);$D=substr($fir_fulicis,3,1);$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);$G=substr($fir_fulicis,6,1);$H=substr($fir_fulicis,7,1);$I=substr($fir_fulicis,8,1);$J=substr($fir_fulicis,9,1);

$K=substr($fir_fulicis,10,1);$L=substr($fir_fulicis,11,1);$M=substr($fir_fulicis,12,1);$N=substr($fir_fulicis,13,1);$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);$R=substr($fir_fulicis,16,1);$S=substr($fir_fulicis,17,1);$T=substr($fir_fulicis,18,1);$U=substr($fir_fulicis,19,1);

$V=substr($fir_fulicis,20,1);$W=substr($fir_fulicis,21,1);$X=substr($fir_fulicis,22,1);$Y=substr($fir_fulicis,23,1);$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);$B1=substr($fir_fulicis,26,1);$C1=substr($fir_fulicis,27,1);$D1=substr($fir_fulicis,28,1);$E1=substr($fir_fulicis,29,1);

$pdf->Cell(2,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");$pdf->Cell(6,6,"$D","0",0,"C");
$pdf->Cell(6,6,"$E","0",0,"C");$pdf->Cell(1,6,"$F","0",0,"C");$pdf->Cell(4,6,"$G","0",0,"C");$pdf->Cell(6,6,"$H","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");
$pdf->Cell(6,6,"$J","0",0,"C");

$pdf->Cell(6,6,"$K","0",0,"C");$pdf->Cell(6,6,"$L","0",0,"C");$pdf->Cell(6,6,"$M","0",0,"C");$pdf->Cell(6,6,"$N","0",0,"C");$pdf->Cell(6,6,"$O","0",0,"C");
$pdf->Cell(6,6,"$P","0",0,"C");$pdf->Cell(5,6,"$R","0",0,"C");$pdf->Cell(6,6,"$S","0",0,"C");$pdf->Cell(6,6,"$T","0",0,"C");$pdf->Cell(6,6,"$U","0",0,"C");

$pdf->Cell(6,6,"$V","0",0,"C");$pdf->Cell(6,6,"$W","0",0,"C");$pdf->Cell(6,6,"$X","0",0,"C");$pdf->Cell(5,6,"$Y","0",0,"C");$pdf->Cell(6,6,"$Z","0",0,"C");
$pdf->Cell(6,6,"$A1","0",0,"C");$pdf->Cell(6,6,"$B1","0",0,"C");$pdf->Cell(6,6,"$C1","0",0,"C");$pdf->Cell(6,6,"$D1","0",0,"C");$pdf->Cell(6,6,"$E1","0",0,"C");

$pdf->Cell(1,5," ","0",1,"C");

//telefon a fax
$pdf->SetFont('arial','',10);
$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
if( $tel_pred == 0 ) { $tel_pred=""; }
$tel_za=$pole[1];

$pdf->Cell(190,8,"     ","0",1,"L");
$A=substr($tel_pred,0,1);$B=substr($tel_pred,1,1);$C=substr($tel_pred,2,1);$D=substr($tel_pred,3,1);$E=substr($tel_pred,4,1);$F=substr($tel_pred,5,1);

$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");
$pdf->Cell(6,6,"$C","$rmc",0,"C");$pdf->Cell(1,6,"$D","$rmc",0,"C");$pdf->Cell(2,6,"$E","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");

$A=substr($tel_za,0,1);$B=substr($tel_za,1,1);$C=substr($tel_za,2,1);$D=substr($tel_za,3,1);$E=substr($tel_za,4,1);$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);$H=substr($tel_za,7,1);

$pdf->Cell(7,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(6,6,"$C","$rmc",0,"C");
$pdf->Cell(6,6,"$D","$rmc",0,"C");$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(6,6,"$G","$rmc",0,"C");
$pdf->Cell(6,6,"$H","$rmc",0,"C");


$pdf->SetFont('arial','',10);
$pole = explode("/", $fir_ffax);
$fax_pred=$pole[0];
$fax_za=$pole[1];

$A=substr($fax_pred,0,1);$B=substr($fax_pred,1,1);$C=substr($fax_pred,2,1);$D=substr($fax_pred,3,1);

$F=substr($fax_za,0,1);$G=substr($fax_za,1,1);$H=substr($fax_za,2,1);$I=substr($fax_za,3,1);$J=substr($fax_za,4,1);$K=substr($fax_za,5,1);$L=substr($fax_za,6,1);


$pdf->Cell(34,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(6,6,"$D","$rmc",0,"C");$pdf->Cell(6,6,"$F","$rmc",0,"C");
$pdf->Cell(6,6,"$G","$rmc",0,"C");$pdf->Cell(6,6,"$H","$rmc",0,"C");$pdf->Cell(6,6,"$I","$rmc",0,"C");
$pdf->Cell(6,6,"$J","$rmc",0,"C");$pdf->Cell(6,6,"$K","$rmc",0,"C");$pdf->Cell(6,6,"$L","$rmc",0,"C");

//email
$pdf->SetFont('arial','',9);
$pdf->Cell(190,14,"     ","0",1,"L");

$fir_fulicis=$fir_fem1;

$A=substr($fir_fulicis,0,1);$B=substr($fir_fulicis,1,1);$C=substr($fir_fulicis,2,1);$D=substr($fir_fulicis,3,1);$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);$G=substr($fir_fulicis,6,1);$H=substr($fir_fulicis,7,1);$I=substr($fir_fulicis,8,1);$J=substr($fir_fulicis,9,1);

$K=substr($fir_fulicis,10,1);$L=substr($fir_fulicis,11,1);$M=substr($fir_fulicis,12,1);$N=substr($fir_fulicis,13,1);$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);$R=substr($fir_fulicis,16,1);$S=substr($fir_fulicis,17,1);$T=substr($fir_fulicis,18,1);$U=substr($fir_fulicis,19,1);

$V=substr($fir_fulicis,20,1);$W=substr($fir_fulicis,21,1);$X=substr($fir_fulicis,22,1);$Y=substr($fir_fulicis,23,1);$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);$B1=substr($fir_fulicis,26,1);$C1=substr($fir_fulicis,27,1);$D1=substr($fir_fulicis,28,1);$E1=substr($fir_fulicis,29,1);

$pdf->Cell(1,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");$pdf->Cell(6,6,"$E","0",0,"C");
$pdf->Cell(6,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");$pdf->Cell(6,6,"$I","0",0,"C");
$pdf->Cell(6,6,"$J","0",0,"C");

$pdf->Cell(6,6,"$K","0",0,"C");
$pdf->Cell(6,6,"$L","0",0,"C");$pdf->Cell(4,6,"$M","0",0,"C");
$pdf->Cell(6,6,"$N","0",0,"C");$pdf->Cell(6,6,"$O","0",0,"C");
$pdf->Cell(6,6,"$P","0",0,"C");$pdf->Cell(6,6,"$R","0",0,"C");
$pdf->Cell(6,6,"$S","0",0,"C");$pdf->Cell(6,6,"$T","0",0,"C");
$pdf->Cell(6,6,"$U","0",0,"C");

$pdf->Cell(6,6,"$V","0",0,"C");
$pdf->Cell(6,6,"$W","0",0,"C");$pdf->Cell(6,6,"$X","0",0,"C");
$pdf->Cell(6,6,"$Y","0",0,"C");$pdf->Cell(6,6,"$Z","0",0,"C");
$pdf->Cell(5,6,"$A1","0",0,"C");
$pdf->Cell(6,6,"$B1","0",0,"C");$pdf->Cell(6,6,"$C1","0",0,"C");
$pdf->Cell(6,6,"$D1","0",0,"C");$pdf->Cell(6,6,"$E1","0",0,"C");

$pdf->Cell(1,5," ","0",1,"C");

//sknace
$pdf->SetFont('arial','',11);
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);

$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
$sn2c=substr($sknacec,1,1);

$pdf->SetY(139);$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$sn1c","$rmc",0,"C");$pdf->Cell(4,6,"$sn2c","$rmc",0,"C");

//datum zostavenia
$h_zos = $_REQUEST['h_zos'];
$pdf->SetY(248);
$pdf->SetX(30);

$pdf->Cell(20,6,"$h_zos","0",1,"L");

//strana2
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/suvaha_str2.jpg') )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/suvaha_str2.jpg',5,8,200,278); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(190,39,"     ","0",1,"L");

$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r01","0",0,"R");$pdf->Cell(20,7,"$rk01","0",0,"R");$pdf->Cell(20,7,"$rn01","0",0,"R");
$pdf->Cell(29,7,"$rm01","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r02","0",0,"R");$pdf->Cell(20,8,"$rk02","0",0,"R");$pdf->Cell(20,8,"$rn02","0",0,"R");
$pdf->Cell(29,8,"$rm02","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r03","0",0,"R");$pdf->Cell(20,8,"$rk03","0",0,"R");$pdf->Cell(20,8,"$rn03","0",0,"R");
$pdf->Cell(29,8,"$rm03","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r04","0",0,"R");$pdf->Cell(20,7,"$rk04","0",0,"R");$pdf->Cell(20,7,"$rn04","0",0,"R");
$pdf->Cell(29,7,"$rm04","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r05","0",0,"R");$pdf->Cell(20,7,"$rk05","0",0,"R");$pdf->Cell(20,7,"$rn05","0",0,"R");
$pdf->Cell(29,7,"$rm05","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r06","0",0,"R");$pdf->Cell(20,8,"$rk06","0",0,"R");$pdf->Cell(20,8,"$rn06","0",0,"R");
$pdf->Cell(29,8,"$rm06","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r07","0",0,"R");$pdf->Cell(20,8,"$rk07","0",0,"R");$pdf->Cell(20,8,"$rn07","0",0,"R");
$pdf->Cell(29,8,"$rm07","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r08","0",0,"R");$pdf->Cell(20,8,"$rk08","0",0,"R");$pdf->Cell(20,8,"$rn08","0",0,"R");
$pdf->Cell(29,8,"$rm08","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r09","0",0,"R");$pdf->Cell(20,7,"$rk09","0",0,"R");$pdf->Cell(20,7,"$rn09","0",0,"R");
$pdf->Cell(29,7,"$rm09","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r10","0",0,"R");$pdf->Cell(20,7,"$rk10","0",0,"R");$pdf->Cell(20,7,"$rn10","0",0,"R");
$pdf->Cell(29,7,"$rm10","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r11","0",0,"R");$pdf->Cell(20,7,"$rk11","0",0,"R");$pdf->Cell(20,7,"$rn11","0",0,"R");
$pdf->Cell(29,7,"$rm11","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r12","0",0,"R");$pdf->Cell(20,6,"$rk12","0",0,"R");$pdf->Cell(20,6,"$rn12","0",0,"R");
$pdf->Cell(29,6,"$rm12","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r13","0",0,"R");$pdf->Cell(20,7,"$rk13","0",0,"R");$pdf->Cell(20,7,"$rn13","0",0,"R");
$pdf->Cell(29,7,"$rm13","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r14","0",0,"R");$pdf->Cell(20,7,"$rk14","0",0,"R");$pdf->Cell(20,7,"$rn14","0",0,"R");
$pdf->Cell(29,7,"$rm14","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r15","0",0,"R");$pdf->Cell(20,8,"$rk15","0",0,"R");$pdf->Cell(20,8,"$rn15","0",0,"R");
$pdf->Cell(29,8,"$rm15","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r16","0",0,"R");$pdf->Cell(20,7,"$rk16","0",0,"R");$pdf->Cell(20,7,"$rn16","0",0,"R");
$pdf->Cell(29,7,"$rm16","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r17","0",0,"R");$pdf->Cell(20,7,"$rk17","0",0,"R");$pdf->Cell(20,7,"$rn17","0",0,"R");
$pdf->Cell(29,7,"$rm17","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r18","0",0,"R");$pdf->Cell(20,7,"$rk18","0",0,"R");$pdf->Cell(20,7,"$rn18","0",0,"R");
$pdf->Cell(29,7,"$rm18","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,9,"$r19","0",0,"R");$pdf->Cell(20,9,"$rk19","0",0,"R");$pdf->Cell(20,9,"$rn19","0",0,"R");
$pdf->Cell(29,7,"$rm19","0",1,"R");
$pdf->Cell(102,9," ","0",0,"R");$pdf->Cell(22,9,"$r20","0",0,"R");$pdf->Cell(20,9,"$rk20","0",0,"R");$pdf->Cell(20,9,"$rn20","0",0,"R");
$pdf->Cell(29,9,"$rm20","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r21","0",0,"R");$pdf->Cell(20,7,"$rk21","0",0,"R");$pdf->Cell(20,7,"$rn21","0",0,"R");
$pdf->Cell(29,7,"$rm21","0",1,"R");
$pdf->Cell(102,9," ","0",0,"R");$pdf->Cell(22,9,"$r22","0",0,"R");$pdf->Cell(20,9,"$rk22","0",0,"R");$pdf->Cell(20,9,"$rn22","0",0,"R");
$pdf->Cell(29,9,"$rm22","0",1,"R");
$pdf->Cell(102,11," ","0",0,"R");$pdf->Cell(22,11,"$r23","0",0,"R");$pdf->Cell(20,11,"$rk23","0",0,"R");$pdf->Cell(20,11,"$rn23","0",0,"R");
$pdf->Cell(29,11,"$rm23","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r24","0",0,"R");$pdf->Cell(20,8,"$rk24","0",0,"R");$pdf->Cell(20,8,"$rn24","0",0,"R");
$pdf->Cell(29,8,"$rm24","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r25","0",0,"R");$pdf->Cell(20,8,"$rk25","0",0,"R");$pdf->Cell(20,8,"$rn25","0",0,"R");
$pdf->Cell(29,8,"$rm25","0",1,"R");
$pdf->Cell(102,9," ","0",0,"R");$pdf->Cell(22,9,"$r26","0",0,"R");$pdf->Cell(20,9,"$rk26","0",0,"R");$pdf->Cell(20,9,"$rn26","0",0,"R");
$pdf->Cell(29,9,"$rm26","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r27","0",0,"R");$pdf->Cell(20,8,"$rk27","0",0,"R");$pdf->Cell(20,8,"$rn27","0",0,"R");
$pdf->Cell(29,8,"$rm27","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r28","0",0,"R");$pdf->Cell(20,8,"$rk28","0",0,"R");$pdf->Cell(20,8,"$rn28","0",0,"R");
$pdf->Cell(29,8,"$rm28","0",1,"R");

//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Sety(10);$pdf->Cell(121,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");

//strana3
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/suvaha_str3.jpg') )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/suvaha_str3.jpg',5,9,200,277); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(190,38,"     ","0",1,"L");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r29","0",0,"R");$pdf->Cell(20,8,"$rk29","0",0,"R");$pdf->Cell(20,8,"$rn29","0",0,"R");
$pdf->Cell(29,8,"$rm29","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r30","0",0,"R");$pdf->Cell(20,8,"$rk30","0",0,"R");$pdf->Cell(20,8,"$rn30","0",0,"R");
$pdf->Cell(29,8,"$rm30","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r31","0",0,"R");$pdf->Cell(20,6,"$rk31","0",0,"R");$pdf->Cell(20,6,"$rn31","0",0,"R");
$pdf->Cell(29,6,"$rm31","0",1,"R");
$pdf->Cell(102,9," ","0",0,"R");$pdf->Cell(22,9,"$r32","0",0,"R");$pdf->Cell(20,9,"$rk32","0",0,"R");$pdf->Cell(20,9,"$rn32","0",0,"R");
$pdf->Cell(29,9,"$rm32","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r33","0",0,"R");$pdf->Cell(20,7,"$rk33","0",0,"R");$pdf->Cell(20,7,"$rn33","0",0,"R");
$pdf->Cell(29,7,"$rm33","0",1,"R");
$pdf->Cell(102,5," ","0",0,"R");$pdf->Cell(22,5,"$r34","0",0,"R");$pdf->Cell(20,5,"$rk34","0",0,"R");$pdf->Cell(20,5,"$rn34","0",0,"R");
$pdf->Cell(29,5,"$rm34","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r35","0",0,"R");$pdf->Cell(20,6,"$rk35","0",0,"R");$pdf->Cell(20,6,"$rn35","0",0,"R");
$pdf->Cell(29,6,"$rm35","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r36","0",0,"R");$pdf->Cell(20,6,"$rk36","0",0,"R");$pdf->Cell(20,6,"$rn36","0",0,"R");
$pdf->Cell(29,8,"$rm36","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r37","0",0,"R");$pdf->Cell(20,6,"$rk37","0",0,"R");$pdf->Cell(20,6,"$rn37","0",0,"R");
$pdf->Cell(29,6,"$rm37","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r38","0",0,"R");$pdf->Cell(20,8,"$rk38","0",0,"R");$pdf->Cell(20,8,"$rn38","0",0,"R");
$pdf->Cell(29,8,"$rm38","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r39","0",0,"R");$pdf->Cell(20,6,"$rk39","0",0,"R");$pdf->Cell(20,6,"$rn39","0",0,"R");
$pdf->Cell(29,6,"$rm39","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r40","0",0,"R");$pdf->Cell(20,7,"$rk40","0",0,"R");$pdf->Cell(20,7,"$rn40","0",0,"R");
$pdf->Cell(29,7,"$rm40","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r41","0",0,"R");$pdf->Cell(20,8,"$rk41","0",0,"R");$pdf->Cell(20,8,"$rn41","0",0,"R");
$pdf->Cell(29,8,"$rm41","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r42","0",0,"R");$pdf->Cell(20,6,"$rk42","0",0,"R");$pdf->Cell(20,6,"$rn42","0",0,"R");
$pdf->Cell(29,6,"$rm42","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r43","0",0,"R");$pdf->Cell(20,8,"$rk43","0",0,"R");$pdf->Cell(20,8,"$rn43","0",0,"R");
$pdf->Cell(29,8,"$rm43","0",1,"R");
$pdf->Cell(102,5," ","0",0,"R");$pdf->Cell(22,5,"$r44","0",0,"R");$pdf->Cell(20,5,"$rk44","0",0,"R");$pdf->Cell(20,5,"$rn44","0",0,"R");
$pdf->Cell(29,5,"$rm44","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r45","0",0,"R");$pdf->Cell(20,8,"$rk45","0",0,"R");$pdf->Cell(20,8,"$rn45","0",0,"R");
$pdf->Cell(29,8,"$rm45","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r46","0",0,"R");$pdf->Cell(20,8,"$rk46","0",0,"R");$pdf->Cell(20,8,"$rn46","0",0,"R");
$pdf->Cell(29,8,"$rm46","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r47","0",0,"R");$pdf->Cell(20,8,"$rk47","0",0,"R");$pdf->Cell(20,8,"$rn47","0",0,"R");
$pdf->Cell(29,8,"$rm47","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r48","0",0,"R");$pdf->Cell(20,8,"$rk48","0",0,"R");$pdf->Cell(20,8,"$rn48","0",0,"R");
$pdf->Cell(29,8,"$rm48","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r49","0",0,"R");$pdf->Cell(20,6,"$rk49","0",0,"R");$pdf->Cell(20,6,"$rn49","0",0,"R");
$pdf->Cell(29,6,"$rm49","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r50","0",0,"R");$pdf->Cell(20,7,"$rk50","0",0,"R");$pdf->Cell(20,7,"$rn50","0",0,"R");
$pdf->Cell(29,7,"$rm50","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r51","0",0,"R");$pdf->Cell(20,6,"$rk51","0",0,"R");$pdf->Cell(20,6,"$rn51","0",0,"R");
$pdf->Cell(29,6,"$rm51","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r52","0",0,"R");$pdf->Cell(20,7,"$rk52","0",0,"R");$pdf->Cell(20,7,"$rn52","0",0,"R");
$pdf->Cell(29,7,"$rm52","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r53","0",0,"R");$pdf->Cell(20,7,"$rk53","0",0,"R");$pdf->Cell(20,7,"$rn53","0",0,"R");
$pdf->Cell(29,7,"$rm53","0",1,"R");
$pdf->Cell(102,8," ","0",0,"R");$pdf->Cell(22,8,"$r54","0",0,"R");$pdf->Cell(20,8,"$rk54","0",0,"R");$pdf->Cell(20,8,"$rn54","0",0,"R");
$pdf->Cell(29,8,"$rm54","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r55","0",0,"R");$pdf->Cell(20,7,"$rk55","0",0,"R");$pdf->Cell(20,7,"$rn55","0",0,"R");
$pdf->Cell(29,7,"$rm55","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r56","0",0,"R");$pdf->Cell(20,7,"$rk56","0",0,"R");$pdf->Cell(20,7,"$rn56","0",0,"R");
$pdf->Cell(29,7,"$rm56","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r57","0",0,"R");$pdf->Cell(20,6,"$rk57","0",0,"R");$pdf->Cell(20,6,"$rn57","0",0,"R");
$pdf->Cell(29,6,"$rm57","0",1,"R");
$pdf->Cell(102,4," ","0",0,"R");$pdf->Cell(22,4,"$r58","0",0,"R");$pdf->Cell(20,4,"$rk58","0",0,"R");$pdf->Cell(20,4,"$rn58","0",0,"R");
$pdf->Cell(29,4,"$rm58","0",1,"R");
$pdf->Cell(102,6," ","0",0,"R");$pdf->Cell(22,6,"$r59","0",0,"R");$pdf->Cell(20,6,"$rk59","0",0,"R");$pdf->Cell(20,6,"$rn59","0",0,"R");
$pdf->Cell(29,6,"$rm59","0",1,"R");
$pdf->Cell(102,7," ","0",0,"R");$pdf->Cell(22,7,"$r60","0",0,"R");$pdf->Cell(20,7,"$rk60","0",0,"R");$pdf->Cell(20,7,"$rn60","0",0,"R");
$pdf->Cell(29,7,"$rm60","0",1,"R");

//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Sety(11);$pdf->Cell(120,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");

//strana4
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/suvaha_str4.jpg') )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/suvaha_str4.jpg',12,10,193,276); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(190,27,"     ","0",1,"L");

$pdf->Cell(118,8," ","0",0,"R");$pdf->Cell(30,8,"$r61","0",0,"R");$pdf->Cell(40,8,"$rm61","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r62","0",0,"R");$pdf->Cell(40,5,"$rm62","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r63","0",0,"R");$pdf->Cell(40,4,"$rm63","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r64","0",0,"R");$pdf->Cell(40,5,"$rm64","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r65","0",0,"R");$pdf->Cell(40,4,"$rm65","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r66","0",0,"R");$pdf->Cell(40,5,"$rm66","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r67","0",0,"R");$pdf->Cell(40,5,"$rm67","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r68","0",0,"R");$pdf->Cell(40,4,"$rm68","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r69","0",0,"R");$pdf->Cell(40,5,"$rm69","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r70","0",0,"R");$pdf->Cell(40,4,"$rm70","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r71","0",0,"R");$pdf->Cell(40,5,"$rm71","0",1,"R");
$pdf->Cell(118,8," ","0",0,"R");$pdf->Cell(30,8,"$r72","0",0,"R");$pdf->Cell(40,8,"$rm72","0",1,"R");
$pdf->Cell(118,9," ","0",0,"R");$pdf->Cell(30,9,"$r73","0",0,"R");$pdf->Cell(40,9,"$rm73","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r74","0",0,"R");$pdf->Cell(40,4,"$rm74","0",1,"R");
$pdf->Cell(118,6," ","0",0,"R");$pdf->Cell(30,6,"$r75","0",0,"R");$pdf->Cell(40,6,"$rm75","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r76","0",0,"R");$pdf->Cell(40,5,"$rm76","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r77","0",0,"R");$pdf->Cell(40,5,"$rm77","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r78","0",0,"R");$pdf->Cell(40,5,"$rm78","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r79","0",0,"R");$pdf->Cell(40,4,"$rm79","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r80","0",0,"R");$pdf->Cell(40,5,"$rm80","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r81","0",0,"R");$pdf->Cell(40,5,"$rm81","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r82","0",0,"R");$pdf->Cell(40,5,"$rm82","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r83","0",0,"R");$pdf->Cell(40,5,"$rm83","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r84","0",0,"R");$pdf->Cell(40,5,"$rm84","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r85","0",0,"R");$pdf->Cell(40,5,"$rm85","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r86","0",0,"R");$pdf->Cell(40,4,"$rm86","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r87","0",0,"R");$pdf->Cell(40,5,"$rm87","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r88","0",0,"R");$pdf->Cell(40,5,"$rm88","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r89","0",0,"R");$pdf->Cell(40,5,"$rm89","0",1,"R");
$pdf->Cell(118,8," ","0",0,"R");$pdf->Cell(30,8,"$r90","0",0,"R");$pdf->Cell(40,8,"$rm90","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r91","0",0,"R");$pdf->Cell(40,5,"$rm91","0",1,"R");
$pdf->Cell(118,8," ","0",0,"R");$pdf->Cell(30,8,"$r92","0",0,"R");$pdf->Cell(40,8,"$rm92","0",1,"R");
$pdf->Cell(118,8," ","0",0,"R");$pdf->Cell(30,8,"$r93","0",0,"R");$pdf->Cell(40,8,"$rm93","0",1,"R");
$pdf->Cell(118,6," ","0",0,"R");$pdf->Cell(30,6,"$r94","0",0,"R");$pdf->Cell(40,6,"$rm94","0",1,"R");
$pdf->Cell(118,4," ","0",0,"R");$pdf->Cell(30,4,"$r95","0",0,"R");$pdf->Cell(40,4,"$rm95","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r96","0",0,"R");$pdf->Cell(40,5,"$rm96","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r97","0",0,"R");$pdf->Cell(40,5,"$rm97","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r98","0",0,"R");$pdf->Cell(40,5,"$rm98","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r99","0",0,"R");$pdf->Cell(40,5,"$rm99","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r100","0",0,"R");$pdf->Cell(40,5,"$rm100","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r101","0",0,"R");$pdf->Cell(40,5,"$rm101","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r102","0",0,"R");$pdf->Cell(40,5,"$rm102","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r103","0",0,"R");$pdf->Cell(40,5,"$rm103","0",1,"R");
$pdf->Cell(118,5," ","0",0,"R");$pdf->Cell(30,5,"$r104","0",0,"R");$pdf->Cell(40,5,"$rm104","0",1,"R");

//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Sety(12);$pdf->Cell(119,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");

}
$i = $i + 1;

  }

//koniec zostava mesacna
}

//vypis negenerovane pohyby
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcsuvahasneg$kli_uzid WHERE LEFT(uce,1) = 5 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcsuvahasneg$kli_uzid WHERE LEFT(uce,1) = 6 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcsuvahasneg$kli_uzid WHERE LEFT(uce,1) = 7 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcsuvahasneg$kli_uzid WHERE LEFT(uce,1) = 8 ";
$oznac = mysql_query("$sqtoz");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahasneg$kli_uzid WHERE rdk = 0 GROUP BY uce ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

if( $pol > 0 )
          {

$i=0;
  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

if( $i == 0 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);
              }
$pdf->Cell(60,6,"Negenerované ","$rmc",0,"L");$pdf->Cell(25,6,"$hlavicka->uce / rdk$hlavicka->rdk","$rmc",0,"L");$pdf->Cell(25,6," ","$rmc",1,"L");

}
$i = $i + 1;

  }
          }
//koniec if( $pol > 0 )


$sqtoz = "DROP TABLE F$kli_vxcf"."_prcsuvahasneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$pdf->Output("../tmp/suvaha.$kli_uzid.pdf");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvahas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvaha'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
if( $tis == 0 ) { 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
                }
?> 

<script type="text/javascript">
  var okno = window.open("../tmp/suvaha.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Vykaz Ziskov PDF</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
    
</script>
</HEAD>
<BODY class="white" >




<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
