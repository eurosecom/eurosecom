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

$lenvzs = 1*$_REQUEST['lenvzs'];
$lensuv = 1*$_REQUEST['lensuv'];

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



$sql = "SELECT * FROM F$kli_vxcf"."_crs_muj2014";
$vysledok = mysql_query("$sql");
if ($vysledok)
          {
$polx = mysql_num_rows($vysledok);
$sql = "DROP TABLE F$kli_vxcf"."_crs_muj2014";
if( $polx < 4 ) { $vysledok = mysql_query("$sql"); }
          }

//zostava mesacna
if( $copern == 10 )
{
//nastav crs podla uce ale nie z uctosnova ako pri podnikatelskych ale z crs_muj2014.csv v adresary /import
$sql = "DROP TABLE F$kli_vxcf"."_crs_muj2014";
//$vysledok = mysql_query("$sql");

//Tabulka crs_muj2014
$sql = "SELECT * FROM F$kli_vxcf"."_crs_muj2014";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {
echo "Vytvorit tabulku F$kli_vxcf"."_crs_muj2014!"."<br />";

$sqlt = <<<crs_muj2014
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
crs_muj2014;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_crs_muj2014'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/crs_muj$kli_vrok.csv", "r");
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
$sqult = "INSERT INTO F$kli_vxcf"."_crs_muj2014 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
          }
//koniec tabulky crs_muj2014


$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_muj2014".
" SET rdk=F$kli_vxcf"."_crs_muj2014.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_crs_muj2014.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_muj2014".
" SET rdk=F$kli_vxcf"."_crs_muj2014.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,5) = LEFT(F$kli_vxcf"."_crs_muj2014.uce,5) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_crs_muj2014".
" SET rdk=F$kli_vxcf"."_crs_muj2014.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,6) = LEFT(F$kli_vxcf"."_crs_muj2014.uce,6) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//Tabulka uctsyngensuv_muj2014
$sql = "SELECT * FROM F$kli_vxcf"."_uctsyngensuv_muj2014";
$vysledok = mysql_query("$sql");
if ($vysledok)
          {
$polx = mysql_num_rows($vysledok);
$sql = "DROP TABLE F$kli_vxcf"."_uctsyngensuv_muj2014";
if( $polx < 1 ) { $vysledok = mysql_query("$sql"); }
          }

$sql = "DROP TABLE F$kli_vxcf"."_uctsyngensuv_muj2014";
//$vysledok = mysql_query("$sql");

$sql = "SELECT * FROM F$kli_vxcf"."_uctsyngensuv_muj2014";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {
echo "Vytvorit tabulku F$kli_vxcf"."_uctsyngensuv_muj2014!"."<br />";

$sqlt = <<<uctsyngensuv_muj2014
(
   cpl         int not null auto_increment,
   dok         VARCHAR(10),
   ucm         DECIMAL(10,0),
   ucd         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
uctsyngensuv_muj2014;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctsyngensuv_muj2014'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/uctsyngensuv_muj$kli_vrok.csv", "r");
while (! feof($subor))
     {
  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_dok = $pole[0];
  $x_ucm = $pole[1];
  $x_ucd = $pole[2];
  $x_kon = $pole[3];
 
$c_dok=1*$x_dok;

if( $c_dok > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_uctsyngensuv_muj2014 ( dok,ucm,ucd )".
" VALUES ( '$x_dok', '$x_ucm', '$x_ucd' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
          }
//koniec tabulky uctsyngensuv_muj2014


//pozri co mame synteticky(zmen cislo riadku) a podla zostatku ( zmen cislo riadku )
$sqltt = "SELECT * FROM F".$kli_vxcf."_uctsyngensuv_muj2014 WHERE dok != '' ";
$jesynt=0;
$pol=0;
$sql = mysql_query("$sqltt");
if( $sql ) { $pol = mysql_num_rows($sql); }
if( $pol > 0 ) {
//echo "mame synteticke";
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_uctsyngensuv_muj2014".
" SET rdk=F$kli_vxcf"."_uctsyngensuv_muj2014.ucm, uce=F$kli_vxcf"."_uctsyngensuv_muj2014.dok ".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = F$kli_vxcf"."_uctsyngensuv_muj2014.dok ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ak aktiva je minus 

//suma za ucet znovu po upravach syntetiky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,9,uce,0,0,rdk,0,0,SUM(mdt),SUM(dal),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_prcsuvahas$kli_uzid".
" WHERE prx = 0 GROUP BY uce";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcsuvahas$kli_uzid WHERE prx != 9 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET prx=0, hod=mdt-dal";
$oznac = mysql_query("$sqtoz"); 

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_uctsyngensuv_muj2014".
" SET rdk=F$kli_vxcf"."_uctsyngensuv_muj2014.ucd, F$kli_vxcf"."_prcsuvahas$kli_uzid.hod=-1*F$kli_vxcf"."_prcsuvahas$kli_uzid.hod  ".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = F$kli_vxcf"."_uctsyngensuv_muj2014.dok ".
" AND F$kli_vxcf"."_prcsuvahas$kli_uzid.hod < 0  AND F$kli_vxcf"."_uctsyngensuv_muj2014.ucd > 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;
               }
//koniec uprav pre synteticke generovanie


//korekcia
$ajkorekcia=0;
if( $ajkorekcia == 1 ) 
  {
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
  }

//rozdel do riadkov , vypocitaj netto

$rdk=1;
while ($rdk <= 45 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk AND kor = 0 ";
if( $rdk >= 24 ) { $sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

if( $rdk < 24 ) { 
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

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET ".
"rn01=r01-rk01, rn02=r02-rk02, rn03=r03-rk03, rn04=r04-rk04, rn05=r05-rk05, rn06=r06-rk06, rn07=r07-rk07, rn08=r08-rk08, rn09=r09-rk09, rn10=r10-rk10,".
"rn11=r11-rk11, rn12=r12-rk12, rn13=r13-rk13, rn14=r14-rk14, rn15=r15-rk15, rn16=r16-rk16, rn17=r17-rk17, rn18=r18-rk18, rn19=r19-rk19, rn20=r20-rk20,".
"rn21=r21-rk21, rn22=r22-rk22, rn23=r23-rk23, rn24=r24-rk24, rn25=r25-rk25, rn26=r26-rk26, rn27=r27-rk27, rn28=r28-rk28, rn29=r29-rk29, rn30=r30-rk30,".
"rn31=r31-rk31, rn32=r32-rk32, rn33=r33-rk33, rn34=r34-rk34, rn35=r35-rk35, rn36=r36-rk36, rn37=r37-rk37, rn38=r38-rk38, rn39=r39-rk39, rn40=r40-rk40,".
"rn41=r41-rk41, rn42=r42-rk42, rn43=r43-rk43, rn44=r44-rk44, rn45=r45-rk45, rn46=r46-rk46, rn47=r47-rk47, rn48=r48-rk48, rn49=r49-rk49, rn50=r50-rk50,".
"rn51=r51-rk51, rn52=r52-rk52, rn53=r53-rk53, rn54=r54-rk54, rn55=r55-rk55, rn56=r56-rk56, rn57=r57-rk57, rn58=r58-rk58, rn59=r59-rk59, rn60=r60-rk60,".
"rn61=r61-rk61, rn62=r62-rk62, rn63=r63-rk63, rn64=r64-rk64 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//ak na tisic
if( $tis > 0 )
{

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

//vypocitaj riadky strana 2
$vsldat="prcsuvahas";
if( $tis > 0 ) { $vsldat="prcsuv1000ahas"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rn21=rn22+rn23, ".
"rn17=rn18+rn19+rn20, ".
"rn14=rn15+rn16+rn17+rn21, ".
"rn09=rn10+rn11+rn12+rn13, ".
"rn04=rn05+rn06+rn07+rn08, ".
"rn02=rn03+rn04+rn09, ".
"rn01=rn02+rn14 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj strana 3
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rn38=rn39+rn40+rn41+rn42, ".
"rn26=rn27+rn28, ".
"rn34=rn35+rn36+rn37+rn38+rn43+rn44+rn45 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");


//vypocitaj vysledok  
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rn33=rn01-rn26-rn29-rn30-rn31-rn32-rn34 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//posledne sucty  
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rn25=rn26+rn29+rn30+rn31+rn32+rn33, ".
"rn24=rn25+rn34  ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");
 

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

echo "Negenerovaný úèet ".$hlavicka->uce." / èíslo riadku ".$hlavicka->rdk."<br />";

}
$i = $i + 1;

  }

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcsuvahasneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");
exit;
          }
//koniec vypis negenerovane pohyby



//uzavierka kompletna MUJ 2014
$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 1 )
  {
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
?>
<script type="text/javascript">

window.open('../ucto/vykzis_muj2014.php?copern=10&drupoh=1&tis=<?php echo $tis; ?>&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=1&lenvzs=<?php echo $lenvzs; ?>&lensuv=<?php echo $lensuv; ?>', '_self' )


</script>
<?php
exit;
  }

//uzavierka MUJ 2014
$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 0 )
  {
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
?>
<script type="text/javascript">

window.open('../ucto/vykzis_muj2014.php?copern=10&drupoh=1&tis=<?php echo $tis; ?>&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=0&lenvzs=<?php echo $lenvzs; ?>&lensuv=<?php echo $lensuv; ?>', '_self' )


</script>
<?php
  }
exit;

//koniec zostava mesacna
}


?> 
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Suvaha PDF</title>
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
