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
if (File_Exists ("../tmp/vykzis.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykzis.$kli_uzid.pdf"); }

$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 0 )
  {
   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
  }

//pre zostavu vytvor pracovny subor prcvykzis$kli_uzid pre import nie
if( $copern == 10 )
{

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykziss'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcvykziss
(
   prx          INT,
   uce          INT,
   ucm          INT,
   ucd          INT,
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
   konx1        INT,
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
   r994         DECIMAL(10,2),
   r995         DECIMAL(10,2),
   rpc01          DECIMAL(10,2),
   rpc02          DECIMAL(10,2),
   rpc03          DECIMAL(10,2),
   rpc04          DECIMAL(10,2),
   rpc05          DECIMAL(10,2),
   rpc06          DECIMAL(10,2),
   rpc07          DECIMAL(10,2),
   rpc08          DECIMAL(10,2),
   rpc09          DECIMAL(10,2),
   rpc10          DECIMAL(10,2),
   rpc11          DECIMAL(10,2),
   rpc12          DECIMAL(10,2),
   rpc13          DECIMAL(10,2),
   rpc14          DECIMAL(10,2),
   rpc15          DECIMAL(10,2),
   rpc16          DECIMAL(10,2),
   rpc17          DECIMAL(10,2),
   rpc18          DECIMAL(10,2),
   rpc19          DECIMAL(10,2),
   rpc20          DECIMAL(10,2),
   rpc21          DECIMAL(10,2),
   rpc22          DECIMAL(10,2),
   rpc23          DECIMAL(10,2),
   rpc24          DECIMAL(10,2),
   rpc25          DECIMAL(10,2),
   rpc26          DECIMAL(10,2),
   rpc27          DECIMAL(10,2),
   rpc28          DECIMAL(10,2),
   rpc29          DECIMAL(10,2),
   rpc30          DECIMAL(10,2),
   rpc31          DECIMAL(10,2),
   rpc32          DECIMAL(10,2),
   rpc33          DECIMAL(10,2),
   rpc34          DECIMAL(10,2),
   rpc35          DECIMAL(10,2),
   rpc36          DECIMAL(10,2),
   rpc37          DECIMAL(10,2),
   rpc38          DECIMAL(10,2),
   rpc39          DECIMAL(10,2),
   rpc40          DECIMAL(10,2),
   rpc41          DECIMAL(10,2),
   rpc42          DECIMAL(10,2),
   rpc43          DECIMAL(10,2),
   rpc44          DECIMAL(10,2),
   rpc45          DECIMAL(10,2),
   rpc46          DECIMAL(10,2),
   rpc47          DECIMAL(10,2),
   rpc48          DECIMAL(10,2),
   rpc49          DECIMAL(10,2),
   rpc50          DECIMAL(10,2),
   rpc51          DECIMAL(10,2),
   rpc52          DECIMAL(10,2),
   rpc53          DECIMAL(10,2),
   rpc54          DECIMAL(10,2),
   rpc55          DECIMAL(10,2),
   rpc56          DECIMAL(10,2),
   rpc57          DECIMAL(10,2),
   konx2          INT,
   rpc58          DECIMAL(10,2),
   rpc59          DECIMAL(10,2),
   rpc60          DECIMAL(10,2),
   rpc61          DECIMAL(10,2),
   rpc62          DECIMAL(10,2),
   rpc63          DECIMAL(10,2),
   rpc64          DECIMAL(10,2),
   rpc65          DECIMAL(10,2),
   rpc66          DECIMAL(10,2),
   rpc67          DECIMAL(10,2),
   rpc68          DECIMAL(10,2),
   rpc69          DECIMAL(10,2),
   rpc70          DECIMAL(10,2),
   rpc71          DECIMAL(10,2),
   rpc72          DECIMAL(10,2),
   rpc73          DECIMAL(10,2),
   rpc74          DECIMAL(10,2),
   rpc75          DECIMAL(10,2),
   rpc76          DECIMAL(10,2),
   rpc77          DECIMAL(10,2),
   rpc78          DECIMAL(10,2),
   rpc994         DECIMAL(10,2),
   rpc995         DECIMAL(10,2),
   rsp01          DECIMAL(10,2),
   rsp02          DECIMAL(10,2),
   rsp03          DECIMAL(10,2),
   rsp04          DECIMAL(10,2),
   rsp05          DECIMAL(10,2),
   rsp06          DECIMAL(10,2),
   rsp07          DECIMAL(10,2),
   rsp08          DECIMAL(10,2),
   rsp09          DECIMAL(10,2),
   rsp10          DECIMAL(10,2),
   rsp11          DECIMAL(10,2),
   rsp12          DECIMAL(10,2),
   rsp13          DECIMAL(10,2),
   rsp14          DECIMAL(10,2),
   rsp15          DECIMAL(10,2),
   rsp16          DECIMAL(10,2),
   rsp17          DECIMAL(10,2),
   rsp18          DECIMAL(10,2),
   rsp19          DECIMAL(10,2),
   rsp20          DECIMAL(10,2),
   rsp21          DECIMAL(10,2),
   rsp22          DECIMAL(10,2),
   rsp23          DECIMAL(10,2),
   rsp24          DECIMAL(10,2),
   rsp25          DECIMAL(10,2),
   rsp26          DECIMAL(10,2),
   rsp27          DECIMAL(10,2),
   rsp28          DECIMAL(10,2),
   rsp29          DECIMAL(10,2),
   rsp30          DECIMAL(10,2),
   rsp31          DECIMAL(10,2),
   rsp32          DECIMAL(10,2),
   rsp33          DECIMAL(10,2),
   rsp34          DECIMAL(10,2),
   rsp35          DECIMAL(10,2),
   rsp36          DECIMAL(10,2),
   rsp37          DECIMAL(10,2),
   rsp38          DECIMAL(10,2),
   rsp39          DECIMAL(10,2),
   rsp40          DECIMAL(10,2),
   rsp41          DECIMAL(10,2),
   rsp42          DECIMAL(10,2),
   rsp43          DECIMAL(10,2),
   rsp44          DECIMAL(10,2),
   rsp45          DECIMAL(10,2),
   rsp46          DECIMAL(10,2),
   rsp47          DECIMAL(10,2),
   rsp48          DECIMAL(10,2),
   rsp49          DECIMAL(10,2),
   rsp50          DECIMAL(10,2),
   rsp51          DECIMAL(10,2),
   rsp52          DECIMAL(10,2),
   rsp53          DECIMAL(10,2),
   rsp54          DECIMAL(10,2),
   rsp55          DECIMAL(10,2),
   rsp56          DECIMAL(10,2),
   rsp57          DECIMAL(10,2),
   konx3          INT,
   rsp58          DECIMAL(10,2),
   rsp59          DECIMAL(10,2),
   rsp60          DECIMAL(10,2),
   rsp61          DECIMAL(10,2),
   rsp62          DECIMAL(10,2),
   rsp63          DECIMAL(10,2),
   rsp64          DECIMAL(10,2),
   rsp65          DECIMAL(10,2),
   rsp66          DECIMAL(10,2),
   rsp67          DECIMAL(10,2),
   rsp68          DECIMAL(10,2),
   rsp69          DECIMAL(10,2),
   rsp70          DECIMAL(10,2),
   rsp71          DECIMAL(10,2),
   rsp72          DECIMAL(10,2),
   rsp73          DECIMAL(10,2),
   rsp74          DECIMAL(10,2),
   rsp75          DECIMAL(10,2),
   rsp76          DECIMAL(10,2),
   rsp77          DECIMAL(10,2),
   rsp78          DECIMAL(10,2),
   rsp994         DECIMAL(10,2),
   rsp995         DECIMAL(10,2),
   ico          INT,
   str          DECIMAL(10,0),
   zak          DECIMAL(10,0)
);
prcvykziss;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcvykziss'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvyk1000ziss'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcvykziss
(
   prx          INT,
   uce          INT,
   ucm          INT,
   ucd          INT,
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
   konx1        INT,
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
   r994         DECIMAL(10,0),
   r995         DECIMAL(10,0),
   rpc01          DECIMAL(10,0),
   rpc02          DECIMAL(10,0),
   rpc03          DECIMAL(10,0),
   rpc04          DECIMAL(10,0),
   rpc05          DECIMAL(10,0),
   rpc06          DECIMAL(10,0),
   rpc07          DECIMAL(10,0),
   rpc08          DECIMAL(10,0),
   rpc09          DECIMAL(10,0),
   rpc10          DECIMAL(10,0),
   rpc11          DECIMAL(10,0),
   rpc12          DECIMAL(10,0),
   rpc13          DECIMAL(10,0),
   rpc14          DECIMAL(10,0),
   rpc15          DECIMAL(10,0),
   rpc16          DECIMAL(10,0),
   rpc17          DECIMAL(10,0),
   rpc18          DECIMAL(10,0),
   rpc19          DECIMAL(10,0),
   rpc20          DECIMAL(10,0),
   rpc21          DECIMAL(10,0),
   rpc22          DECIMAL(10,0),
   rpc23          DECIMAL(10,0),
   rpc24          DECIMAL(10,0),
   rpc25          DECIMAL(10,0),
   rpc26          DECIMAL(10,0),
   rpc27          DECIMAL(10,0),
   rpc28          DECIMAL(10,0),
   rpc29          DECIMAL(10,0),
   rpc30          DECIMAL(10,0),
   rpc31          DECIMAL(10,0),
   rpc32          DECIMAL(10,0),
   rpc33          DECIMAL(10,0),
   rpc34          DECIMAL(10,0),
   rpc35          DECIMAL(10,0),
   rpc36          DECIMAL(10,0),
   rpc37          DECIMAL(10,0),
   rpc38          DECIMAL(10,0),
   rpc39          DECIMAL(10,0),
   rpc40          DECIMAL(10,0),
   rpc41          DECIMAL(10,0),
   rpc42          DECIMAL(10,0),
   rpc43          DECIMAL(10,0),
   rpc44          DECIMAL(10,0),
   rpc45          DECIMAL(10,0),
   rpc46          DECIMAL(10,0),
   rpc47          DECIMAL(10,0),
   rpc48          DECIMAL(10,0),
   rpc49          DECIMAL(10,0),
   rpc50          DECIMAL(10,0),
   rpc51          DECIMAL(10,0),
   rpc52          DECIMAL(10,0),
   rpc53          DECIMAL(10,0),
   rpc54          DECIMAL(10,0),
   rpc55          DECIMAL(10,0),
   rpc56          DECIMAL(10,0),
   rpc57          DECIMAL(10,0),
   konx2          INT,
   rpc58          DECIMAL(10,0),
   rpc59          DECIMAL(10,0),
   rpc60          DECIMAL(10,0),
   rpc61          DECIMAL(10,0),
   rpc62          DECIMAL(10,0),
   rpc63          DECIMAL(10,0),
   rpc64          DECIMAL(10,0),
   rpc65          DECIMAL(10,0),
   rpc66          DECIMAL(10,0),
   rpc67          DECIMAL(10,0),
   rpc68          DECIMAL(10,0),
   rpc69          DECIMAL(10,0),
   rpc70          DECIMAL(10,0),
   rpc71          DECIMAL(10,0),
   rpc72          DECIMAL(10,0),
   rpc73          DECIMAL(10,0),
   rpc74          DECIMAL(10,0),
   rpc75          DECIMAL(10,0),
   rpc76          DECIMAL(10,0),
   rpc77          DECIMAL(10,0),
   rpc78          DECIMAL(10,0),
   rpc994         DECIMAL(10,0),
   rpc995         DECIMAL(10,0),
   rsp01          DECIMAL(10,0),
   rsp02          DECIMAL(10,0),
   rsp03          DECIMAL(10,0),
   rsp04          DECIMAL(10,0),
   rsp05          DECIMAL(10,0),
   rsp06          DECIMAL(10,0),
   rsp07          DECIMAL(10,0),
   rsp08          DECIMAL(10,0),
   rsp09          DECIMAL(10,0),
   rsp10          DECIMAL(10,0),
   rsp11          DECIMAL(10,0),
   rsp12          DECIMAL(10,0),
   rsp13          DECIMAL(10,0),
   rsp14          DECIMAL(10,0),
   rsp15          DECIMAL(10,0),
   rsp16          DECIMAL(10,0),
   rsp17          DECIMAL(10,0),
   rsp18          DECIMAL(10,0),
   rsp19          DECIMAL(10,0),
   rsp20          DECIMAL(10,0),
   rsp21          DECIMAL(10,0),
   rsp22          DECIMAL(10,0),
   rsp23          DECIMAL(10,0),
   rsp24          DECIMAL(10,0),
   rsp25          DECIMAL(10,0),
   rsp26          DECIMAL(10,0),
   rsp27          DECIMAL(10,0),
   rsp28          DECIMAL(10,0),
   rsp29          DECIMAL(10,0),
   rsp30          DECIMAL(10,0),
   rsp31          DECIMAL(10,0),
   rsp32          DECIMAL(10,0),
   rsp33          DECIMAL(10,0),
   rsp34          DECIMAL(10,0),
   rsp35          DECIMAL(10,0),
   rsp36          DECIMAL(10,0),
   rsp37          DECIMAL(10,0),
   rsp38          DECIMAL(10,0),
   rsp39          DECIMAL(10,0),
   rsp40          DECIMAL(10,0),
   rsp41          DECIMAL(10,0),
   rsp42          DECIMAL(10,0),
   rsp43          DECIMAL(10,0),
   rsp44          DECIMAL(10,0),
   rsp45          DECIMAL(10,0),
   rsp46          DECIMAL(10,0),
   rsp47          DECIMAL(10,0),
   rsp48          DECIMAL(10,0),
   rsp49          DECIMAL(10,0),
   rsp50          DECIMAL(10,0),
   rsp51          DECIMAL(10,0),
   rsp52          DECIMAL(10,0),
   rsp53          DECIMAL(10,0),
   rsp54          DECIMAL(10,0),
   rsp55          DECIMAL(10,0),
   rsp56          DECIMAL(10,0),
   rsp57          DECIMAL(10,0),
   konx3          INT,
   rsp58          DECIMAL(10,0),
   rsp59          DECIMAL(10,0),
   rsp60          DECIMAL(10,0),
   rsp61          DECIMAL(10,0),
   rsp62          DECIMAL(10,0),
   rsp63          DECIMAL(10,0),
   rsp64          DECIMAL(10,0),
   rsp65          DECIMAL(10,0),
   rsp66          DECIMAL(10,0),
   rsp67          DECIMAL(10,0),
   rsp68          DECIMAL(10,0),
   rsp69          DECIMAL(10,0),
   rsp70          DECIMAL(10,0),
   rsp71          DECIMAL(10,0),
   rsp72          DECIMAL(10,0),
   rsp73          DECIMAL(10,0),
   rsp74          DECIMAL(10,0),
   rsp75          DECIMAL(10,0),
   rsp76          DECIMAL(10,0),
   rsp77          DECIMAL(10,0),
   rsp78          DECIMAL(10,0),
   rsp994         DECIMAL(10,0),
   rsp995         DECIMAL(10,0),
   ico            INT
);
prcvykziss;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcvyk1000ziss'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid"." SELECT".
" 0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico,0,0".
" FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid"." SELECT".
" 0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico,0,0".
" FROM F$kli_vxcf"."_uctosnova".
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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid"." SELECT".
" 0,ucm,ucm,0,0,0,0,SUM(F$kli_vxcf"."_$uctovanie.hod),0,".
"0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico,F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $kli_vume GROUP BY ucm,F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid"." SELECT".
" 0,ucd,0,ucd,0,0,0,0,SUM(F$kli_vxcf"."_$uctovanie.hod),".
"0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico,F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $kli_vume GROUP BY ucd,F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid"." SELECT".
" 0,ucm,ucm,0,0,0,0,SUM(hod),0,".
"0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico,str,zak".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ucm > 0 AND ume <= $kli_vume GROUP BY ucm,str,zak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid"." SELECT".
" 0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico,str,zak".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ucd > 0 AND ume <= $kli_vume GROUP BY ucd,str,zak";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

}
//koniec vytvorenia pracovneho suboru


//zostava mesacna
if( $copern == 10 )
{
//nastav crv podla uce
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=1 WHERE LEFT(uce,3) = 501 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=2 WHERE LEFT(uce,3) = 502 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=2 WHERE LEFT(uce,3) = 503 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=3 WHERE LEFT(uce,3) = 504 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=4 WHERE LEFT(uce,3) = 511 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=5 WHERE LEFT(uce,3) = 512 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=6 WHERE LEFT(uce,3) = 513 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=7 WHERE LEFT(uce,3) = 518 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=8 WHERE LEFT(uce,3) = 521 OR LEFT(uce,3) = 522 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=9 WHERE LEFT(uce,3) = 524 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=10 WHERE LEFT(uce,3) = 525 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=11 WHERE LEFT(uce,3) = 527 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=12 WHERE LEFT(uce,3) = 528 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=13 WHERE LEFT(uce,3) = 531 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=14 WHERE LEFT(uce,3) = 532 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=15 WHERE LEFT(uce,3) = 538 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=16 WHERE LEFT(uce,3) = 541 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=17 WHERE LEFT(uce,3) = 542 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=18 WHERE LEFT(uce,3) = 543 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=19 WHERE LEFT(uce,3) = 544 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=20 WHERE LEFT(uce,3) = 545 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=21 WHERE LEFT(uce,3) = 546 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=22 WHERE LEFT(uce,3) = 547 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=23 WHERE LEFT(uce,3) = 548 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=24 WHERE LEFT(uce,3) = 549 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=24 WHERE LEFT(uce,3) = 588 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=25 WHERE LEFT(uce,3) = 551 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=26 WHERE LEFT(uce,3) = 552 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=27 WHERE LEFT(uce,3) = 553 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=28 WHERE LEFT(uce,3) = 554 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=29 WHERE LEFT(uce,3) = 555 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=30 WHERE LEFT(uce,3) = 556 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=31 WHERE LEFT(uce,3) = 557 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=32 WHERE LEFT(uce,3) = 558 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=32 WHERE LEFT(uce,3) = 559 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=33 WHERE LEFT(uce,3) = 561 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=34 WHERE LEFT(uce,3) = 562 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=35 WHERE LEFT(uce,3) = 563 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=36 WHERE LEFT(uce,3) = 565 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=37 WHERE LEFT(uce,3) = 567 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=39 WHERE LEFT(uce,3) = 601 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=40 WHERE LEFT(uce,3) = 602 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=41 WHERE LEFT(uce,3) = 604 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=42 WHERE LEFT(uce,3) = 611 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=43 WHERE LEFT(uce,3) = 612 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=44 WHERE LEFT(uce,3) = 613 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=45 WHERE LEFT(uce,3) = 614 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=46 WHERE LEFT(uce,3) = 621 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=47 WHERE LEFT(uce,3) = 622 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=48 WHERE LEFT(uce,3) = 623 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=49 WHERE LEFT(uce,3) = 624 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=50 WHERE LEFT(uce,3) = 641 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=51 WHERE LEFT(uce,3) = 642 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=52 WHERE LEFT(uce,3) = 643 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=53 WHERE LEFT(uce,3) = 644 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=54 WHERE LEFT(uce,3) = 645 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=55 WHERE LEFT(uce,3) = 646 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=56 WHERE LEFT(uce,3) = 647 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=57 WHERE LEFT(uce,3) = 648 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=58 WHERE LEFT(uce,3) = 649 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=59 WHERE LEFT(uce,3) = 651 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=60 WHERE LEFT(uce,3) = 652 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=61 WHERE LEFT(uce,3) = 653 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=62 WHERE LEFT(uce,3) = 654 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=63 WHERE LEFT(uce,3) = 655 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=64 WHERE LEFT(uce,3) = 656 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=65 WHERE LEFT(uce,3) = 657 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=66 WHERE LEFT(uce,3) = 658 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=67 WHERE LEFT(uce,3) = 661 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=68 WHERE LEFT(uce,3) = 662 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=69 WHERE LEFT(uce,3) = 663 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=70 WHERE LEFT(uce,3) = 664 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=71 WHERE LEFT(uce,3) = 665 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=72 WHERE LEFT(uce,3) = 667 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=73 WHERE LEFT(uce,3) = 691 ";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=76 WHERE LEFT(uce,3) = 591 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET rdk=77 WHERE LEFT(uce,3) = 595 ";
$oznac = mysql_query("$sqtoz");




//rozdel do riadkov
//druha strana
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r01=mdt-dal WHERE rdk = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r02=mdt-dal WHERE rdk = 2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r03=mdt-dal WHERE rdk = 3 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r04=mdt-dal WHERE rdk = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r05=mdt-dal WHERE rdk = 5 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r06=mdt-dal WHERE rdk = 6 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r07=mdt-dal WHERE rdk = 7 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r08=mdt-dal WHERE rdk = 8 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r09=mdt-dal WHERE rdk = 9 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r10=mdt-dal WHERE rdk = 10 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r11=mdt-dal WHERE rdk = 11 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r12=mdt-dal WHERE rdk = 12 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r13=mdt-dal WHERE rdk = 13 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r14=mdt-dal WHERE rdk = 14 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r15=mdt-dal WHERE rdk = 15 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r16=mdt-dal WHERE rdk = 16 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r17=mdt-dal WHERE rdk = 17 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r18=mdt-dal WHERE rdk = 18 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r19=mdt-dal WHERE rdk = 19 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r20=mdt-dal WHERE rdk = 20 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r21=mdt-dal WHERE rdk = 21 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r22=mdt-dal WHERE rdk = 22 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r23=mdt-dal WHERE rdk = 23 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r24=mdt-dal WHERE rdk = 24 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r25=mdt-dal WHERE rdk = 25 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r26=mdt-dal WHERE rdk = 26 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r27=mdt-dal WHERE rdk = 27 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r28=mdt-dal WHERE rdk = 28 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r29=mdt-dal WHERE rdk = 29 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r30=mdt-dal WHERE rdk = 30 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r31=mdt-dal WHERE rdk = 31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r32=mdt-dal WHERE rdk = 32 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r33=mdt-dal WHERE rdk = 33 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r34=mdt-dal WHERE rdk = 34 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r35=mdt-dal WHERE rdk = 35 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r36=mdt-dal WHERE rdk = 36 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r37=mdt-dal WHERE rdk = 37 ";
$oznac = mysql_query("$sqtoz");

//tretia strana

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r39=dal-mdt WHERE rdk = 39 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r40=dal-mdt WHERE rdk = 40 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r41=dal-mdt WHERE rdk = 41 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r42=dal-mdt WHERE rdk = 42 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r43=dal-mdt WHERE rdk = 43 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r44=dal-mdt WHERE rdk = 44 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r45=dal-mdt WHERE rdk = 45 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r46=dal-mdt WHERE rdk = 46 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r47=dal-mdt WHERE rdk = 47 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r48=dal-mdt WHERE rdk = 48 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r49=dal-mdt WHERE rdk = 49 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r50=dal-mdt WHERE rdk = 50 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r51=dal-mdt WHERE rdk = 51 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r52=dal-mdt WHERE rdk = 52 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r53=dal-mdt WHERE rdk = 53 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r54=dal-mdt WHERE rdk = 54 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r55=dal-mdt WHERE rdk = 55 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r56=dal-mdt WHERE rdk = 56 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r57=dal-mdt WHERE rdk = 57 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r58=dal-mdt WHERE rdk = 58 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r59=dal-mdt WHERE rdk = 59 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r60=dal-mdt WHERE rdk = 60 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r61=dal-mdt WHERE rdk = 61 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r62=dal-mdt WHERE rdk = 62 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r63=dal-mdt WHERE rdk = 63 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r64=dal-mdt WHERE rdk = 64 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r65=dal-mdt WHERE rdk = 65 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r66=dal-mdt WHERE rdk = 66 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r67=dal-mdt WHERE rdk = 67 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r68=dal-mdt WHERE rdk = 68 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r69=dal-mdt WHERE rdk = 69 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r70=dal-mdt WHERE rdk = 70 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r71=dal-mdt WHERE rdk = 71 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r72=dal-mdt WHERE rdk = 72 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r73=dal-mdt WHERE rdk = 73 ";
$oznac = mysql_query("$sqtoz");


//dane
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r76=mdt-dal WHERE rdk = 76 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r77=mdt-dal WHERE rdk = 77 ";
$oznac = mysql_query("$sqtoz");


//podnikatelska cinnost presun z r01 do rpc01......r77 do rpc77 ak zakazka je oznacena v parametroch NV=2
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET konx1=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid,F$kli_vxcf"."_zak ".
" SET konx1=1 ".
" WHERE F$kli_vxcf"."_prcvykziss$kli_uzid.str=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_prcvykziss$kli_uzid.zak=F$kli_vxcf"."_zak.zak ".
" AND F$kli_vxcf"."_zak.uzk=2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET ".
" rpc01=r01, rpc02=r02, rpc03=r03, rpc04=r04, rpc05=r05, rpc06=r06, rpc07=r07, rpc08=r08, rpc09=r09, rpc10=r10, ".
" rpc11=r11, rpc12=r12, rpc13=r13, rpc14=r14, rpc15=r15, rpc16=r16, rpc17=r17, rpc18=r18, rpc19=r19, rpc20=r20, ".
" rpc21=r21, rpc22=r22, rpc23=r23, rpc24=r24, rpc25=r25, rpc26=r26, rpc27=r27, rpc28=r28, rpc29=r29, rpc30=r30, ".
" rpc31=r31, rpc32=r32, rpc33=r33, rpc34=r34, rpc35=r35, rpc36=r36, rpc37=r37, rpc38=r38, rpc39=r39, rpc40=r40, ".
" rpc41=r41, rpc42=r42, rpc43=r43, rpc44=r44, rpc45=r45, rpc46=r46, rpc47=r47, rpc48=r48, rpc49=r49, rpc50=r50, ".
" rpc51=r51, rpc52=r52, rpc53=r53, rpc54=r54, rpc55=r55, rpc56=r56, rpc57=r57, rpc58=r58, rpc59=r59, rpc60=r60, ".
" rpc61=r61, rpc62=r62, rpc63=r63, rpc64=r64, rpc65=r65, rpc66=r66, rpc67=r67, rpc68=r68, rpc69=r69, rpc70=r70, ".
" rpc71=r71, rpc72=r72, rpc73=r73, rpc74=r74, rpc75=r75, rpc76=r76, rpc77=r77                                   ".
" WHERE konx1 = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET ".
" r01=0, r02=0, r03=0, r04=0, r05=0, r06=0, r07=0, r08=0, r09=0, r10=0, ".
" r11=0, r12=0, r13=0, r14=0, r15=0, r16=0, r17=0, r18=0, r19=0, r20=0, ".
" r21=0, r22=0, r23=0, r24=0, r25=0, r26=0, r27=0, r28=0, r29=0, r30=0, ".
" r31=0, r32=0, r33=0, r34=0, r35=0, r36=0, r37=0, r38=0, r39=0, r40=0, ".
" r41=0, r42=0, r43=0, r44=0, r45=0, r46=0, r47=0, r48=0, r49=0, r50=0, ".
" r51=0, r52=0, r53=0, r54=0, r55=0, r56=0, r57=0, r58=0, r59=0, r60=0, ".
" r61=0, r62=0, r63=0, r64=0, r65=0, r66=0, r67=0, r68=0, r69=0, r70=0, ".
" r71=0, r72=0, r73=0, r74=0, r75=0, r76=0, r77=0                       ".
" WHERE konx1 = 1 ";
$oznac = mysql_query("$sqtoz");

//potom odstran str,zak
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET konx1=0 ";
$oznac = mysql_query("$sqtoz");
$sql = "ALTER TABLE F$kli_vxcf"."_prcvykziss$kli_uzid DROP str";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcvykziss$kli_uzid DROP zak";
$vysledek = mysql_query("$sql");

//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykziss$kli_uzid "." SELECT".
" 1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"SUM(r01),SUM(r02),SUM(r03),SUM(r04),SUM(r05),".
"SUM(r06),SUM(r07),SUM(r08),SUM(r09),SUM(r10),SUM(r11),SUM(r12),SUM(r13),SUM(r14),SUM(r15),".
"SUM(r16),SUM(r17),SUM(r18),SUM(r19),SUM(r20),SUM(r21),SUM(r22),SUM(r23),SUM(r24),SUM(r25),SUM(r26),SUM(r27),SUM(r28),SUM(r29),SUM(r30),".
"SUM(r31),SUM(r32),SUM(r33),SUM(r34),SUM(r35),SUM(r36),SUM(r37),SUM(r38),SUM(r39),SUM(r40),".
"SUM(r41),SUM(r42),SUM(r43),SUM(r44),SUM(r45),SUM(r46),SUM(r47),SUM(r48),SUM(r49),SUM(r50),".
"SUM(r51),SUM(r52),SUM(r53),SUM(r54),SUM(r55),SUM(r56),SUM(r57),0,SUM(r58),SUM(r59),SUM(r60),".
"SUM(r61),SUM(r62),SUM(r63),SUM(r64),SUM(r65),SUM(r66),SUM(r67),SUM(r68),SUM(r69),SUM(r70),".
"SUM(r71),SUM(r72),SUM(r73),SUM(r74),SUM(r75),SUM(r76),SUM(r77),SUM(r78),SUM(r994),SUM(r995),".
"SUM(rpc01),SUM(rpc02),SUM(rpc03),SUM(rpc04),SUM(rpc05),".
"SUM(rpc06),SUM(rpc07),SUM(rpc08),SUM(rpc09),SUM(rpc10),SUM(rpc11),SUM(rpc12),SUM(rpc13),SUM(rpc14),SUM(rpc15),".
"SUM(rpc16),SUM(rpc17),SUM(rpc18),SUM(rpc19),SUM(rpc20),SUM(rpc21),SUM(rpc22),SUM(rpc23),SUM(rpc24),SUM(rpc25),SUM(rpc26),SUM(rpc27),SUM(rpc28),SUM(rpc29),SUM(rpc30),".
"SUM(rpc31),SUM(rpc32),SUM(rpc33),SUM(rpc34),SUM(rpc35),SUM(rpc36),SUM(rpc37),SUM(rpc38),SUM(rpc39),SUM(rpc40),".
"SUM(rpc41),SUM(rpc42),SUM(rpc43),SUM(rpc44),SUM(rpc45),SUM(rpc46),SUM(rpc47),SUM(rpc48),SUM(rpc49),SUM(rpc50),".
"SUM(rpc51),SUM(rpc52),SUM(rpc53),SUM(rpc54),SUM(rpc55),SUM(rpc56),SUM(rpc57),0,SUM(rpc58),SUM(rpc59),SUM(rpc60),".
"SUM(rpc61),SUM(rpc62),SUM(rpc63),SUM(rpc64),SUM(rpc65),SUM(rpc66),SUM(rpc67),SUM(rpc68),SUM(rpc69),SUM(rpc70),".
"SUM(rpc71),SUM(rpc72),SUM(rpc73),SUM(rpc74),SUM(rpc75),SUM(rpc76),SUM(rpc77),SUM(rpc78),SUM(rpc994),SUM(rpc995),".
"SUM(rsp01),SUM(rsp02),SUM(rsp03),SUM(rsp04),SUM(rsp05),".
"SUM(rsp06),SUM(rsp07),SUM(rsp08),SUM(rsp09),SUM(rsp10),SUM(rsp11),SUM(rsp12),SUM(rsp13),SUM(rsp14),SUM(rsp15),".
"SUM(rsp16),SUM(rsp17),SUM(rsp18),SUM(rsp19),SUM(rsp20),SUM(rsp21),SUM(rsp22),SUM(rsp23),SUM(rsp24),SUM(rsp25),SUM(rsp26),SUM(rsp27),SUM(rsp28),SUM(rsp29),SUM(rsp30),".
"SUM(rsp31),SUM(rsp32),SUM(rsp33),SUM(rsp34),SUM(rsp35),SUM(rsp36),SUM(rsp37),SUM(rsp38),SUM(rsp39),SUM(rsp40),".
"SUM(rsp41),SUM(rsp42),SUM(rsp43),SUM(rsp44),SUM(rsp45),SUM(rsp46),SUM(rsp47),SUM(rsp48),SUM(rsp49),SUM(rsp50),".
"SUM(rsp51),SUM(rsp52),SUM(rsp53),SUM(rsp54),SUM(rsp55),SUM(rsp56),SUM(rsp57),0,SUM(rsp58),SUM(rsp59),SUM(rsp60),".
"SUM(rsp61),SUM(rsp62),SUM(rsp63),SUM(rsp64),SUM(rsp65),SUM(rsp66),SUM(rsp67),SUM(rsp68),SUM(rsp69),SUM(rsp70),".
"SUM(rsp71),SUM(rsp72),SUM(rsp73),SUM(rsp74),SUM(rsp75),SUM(rsp76),SUM(rsp77),SUM(rsp78),SUM(rsp994),SUM(rsp995),".
"$fir_fico".
" FROM F$kli_vxcf"."_prcvykziss$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//ak na tisic
if( $tis > 0 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvyk1000ziss$kli_uzid "." SELECT".
" 1,uce,ucm,ucd,rdk,prv,hod,mdt,dal,".
"r01,r02,r03,r04,r05,".
"r06,r07,r08,r09,r10,r11,r12,r13,r14,r15,".
"r16,r17,r18,r19,r20,r21,r22,r23,r24,r25,r26,r27,r28,r29,r30,".
"r31,r32,r33,r34,r35,r36,r37,r38,r39,r40,".
"r41,r42,r43,r44,r45,r46,r47,r48,r49,r50,".
"r51,r52,r53,r54,r55,r56,r57,0,r58,r59,r60,".
"r61,r62,r63,r64,r65,r66,r67,r68,r69,r70,".
"r71,r72,r73,r74,r75,r76,r77,r78,r994,r995,".
"rpc01,rpc02,rpc03,rpc04,rpc05,".
"rpc06,rpc07,rpc08,rpc09,rpc10,rpc11,rpc12,rpc13,rpc14,rpc15,".
"rpc16,rpc17,rpc18,rpc19,rpc20,rpc21,rpc22,rpc23,rpc24,rpc25,rpc26,rpc27,rpc28,rpc29,rpc30,".
"rpc31,rpc32,rpc33,rpc34,rpc35,rpc36,rpc37,rpc38,rpc39,rpc40,".
"rpc41,rpc42,rpc43,rpc44,rpc45,rpc46,rpc47,rpc48,rpc49,rpc50,".
"rpc51,rpc52,rpc53,rpc54,rpc55,rpc56,rpc57,0,rpc58,rpc59,rpc60,".
"rpc61,rpc62,rpc63,rpc64,rpc65,rpc66,rpc67,rpc68,rpc69,rpc70,".
"rpc71,rpc72,rpc73,rpc74,rpc75,rpc76,rpc77,rpc78,rpc994,rpc995,".
"rsp01,rsp02,rsp03,rsp04,rsp05,".
"rsp06,rsp07,rsp08,rsp09,rsp10,rsp11,rsp12,rsp13,rsp14,rsp15,".
"rsp16,rsp17,rsp18,rsp19,rsp20,rsp21,rsp22,rsp23,rsp24,rsp25,rsp26,rsp27,rsp28,rsp29,rsp30,".
"rsp31,rsp32,rsp33,rsp34,rsp35,rsp36,rsp37,rsp38,rsp39,rsp40,".
"rsp41,rsp42,rsp43,rsp44,rsp45,rsp46,rsp47,rsp48,rsp49,rsp50,".
"rsp51,rsp52,rsp53,rsp54,rsp55,rsp56,rsp57,0,rsp58,rsp59,rsp60,".
"rsp61,rsp62,rsp63,rsp64,rsp65,rsp66,rsp67,rsp68,rsp69,rsp70,".
"rsp71,rsp72,rsp73,rsp74,rsp75,rsp76,rsp77,rsp78,rsp994,rsp995,".
"$fir_fico".
" FROM F$kli_vxcf"."_prcvykziss$kli_uzid".
" WHERE prx = 1".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec ak 1000ky

//vypocitaj riadky
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r38=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12+r13+r14+r15+r16+r17+r18+r19+r20+r21+r22+r23+r24+r25+r26+r27+r28+r29, ".
"r38=r38+r30+r31+r32+r33+r34+r35+r36+r37, ".
"r74=r39+r40+r41+r42+r43+r44+r45+r46+r47+r48+r49+r50+r51+r52+r53+r54+r55+r56+r57+r58+r59, ".
"r74=r74+r60+r61+r62+r63+r64+r65+r66+r67+r68+r69+r70+r71+r72+r73, ".
"r75=r74-r38,".
"r78=r75-r76-r77,".
"r995=2*r74+r75+r76+r77+r78,".
"r994=2*r38 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rpc38=rpc01+rpc02+rpc03+rpc04+rpc05+rpc06+rpc07+rpc08+rpc09+rpc10+rpc11+rpc12+rpc13+rpc14+rpc15+rpc16+rpc17+rpc18+rpc19+rpc20+rpc21+rpc22+rpc23+rpc24+rpc25+rpc26+rpc27+rpc28+rpc29, ".
"rpc38=rpc38+rpc30+rpc31+rpc32+rpc33+rpc34+rpc35+rpc36+rpc37, ".
"rpc74=rpc39+rpc40+rpc41+rpc42+rpc43+rpc44+rpc45+rpc46+rpc47+rpc48+rpc49+rpc50+rpc51+rpc52+rpc53+rpc54+rpc55+rpc56+rpc57+rpc58+rpc59, ".
"rpc74=rpc74+rpc60+rpc61+rpc62+rpc63+rpc64+rpc65+rpc66+rpc67+rpc68+rpc69+rpc70+rpc71+rpc72+rpc73, ".
"rpc75=rpc74-rpc38,".
"rpc78=rpc75-rpc76-rpc77,".
"rpc995=2*rpc74+rpc75+rpc76+rpc77+rpc78,".
"rpc994=2*rpc38 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocitaj spolu
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rsp01=r01+rpc01,rsp02=r02+rpc02,rsp03=r03+rpc03,rsp04=r04+rpc04,rsp05=r05+rpc05,".
"rsp06=r06+rpc06,rsp07=r07+rpc07,rsp08=r08+rpc08,rsp09=r09+rpc09,rsp10=r10+rpc10,".
"rsp11=r11+rpc11,rsp12=r12+rpc12,rsp13=r13+rpc13,rsp14=r14+rpc14,rsp15=r15+rpc15,".
"rsp16=r16+rpc16,rsp17=r17+rpc17,rsp18=r18+rpc18,rsp19=r19+rpc19,rsp20=r20+rpc20,".
"rsp21=r21+rpc21,rsp22=r22+rpc22,rsp23=r23+rpc23,rsp24=r24+rpc24,rsp25=r25+rpc25,".
"rsp26=r26+rpc26,rsp27=r27+rpc27,rsp28=r28+rpc28,rsp29=r29+rpc29,rsp30=r30+rpc30,".
"rsp31=r31+rpc31,rsp32=r32+rpc32,rsp33=r33+rpc33,rsp34=r34+rpc34,rsp35=r35+rpc35,".
"rsp36=r36+rpc36,rsp37=r37+rpc37,rsp38=r38+rpc38,rsp39=r39+rpc39,rsp40=r40+rpc40,".
"rsp41=r41+rpc41,rsp42=r42+rpc42,rsp43=r43+rpc43,rsp44=r44+rpc44,rsp45=r45+rpc45,".
"rsp46=r46+rpc46,rsp47=r47+rpc47,rsp48=r48+rpc48,rsp49=r49+rpc49,rsp50=r50+rpc50,".
"rsp51=r51+rpc51,rsp52=r52+rpc52,rsp53=r53+rpc53,rsp54=r54+rpc54,rsp55=r55+rpc55,".
"rsp56=r56+rpc56,rsp57=r57+rpc57,rsp58=r58+rpc58,rsp59=r59+rpc59,rsp60=r60+rpc60,".
"rsp61=r61+rpc61,rsp62=r62+rpc62,rsp63=r63+rpc63,rsp64=r64+rpc64,rsp65=r65+rpc65,".
"rsp66=r66+rpc66,rsp67=r67+rpc67,rsp68=r68+rpc68,rsp69=r69+rpc69,rsp70=r70+rpc70,".
"rsp71=r71+rpc71,rsp72=r72+rpc72,rsp73=r73+rpc73,rsp74=r74+rpc74,rsp75=r75+rpc75,".
"rsp76=r76+rpc76,rsp77=r77+rpc77,rsp78=r78+rpc78,rsp994=r994+rpc994,rsp995=r995+rpc995".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//rozdiel po zaokruhleni
if( $tis > 0 )
{
$zisk_suvaha=0;
$zisk_vzisk=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid."");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zisk_suvaha=$riaddok->r73;
  }
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid."");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $zisk_vzisk=$riaddok->rsp78;
  }
$zisk_rozd=$zisk_vzisk-$zisk_suvaha;

$cislo_rdk=1*$fir_uctx06;
if( $cislo_rdk < 10 ) $cislo_rdk="0".$cislo_rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_prcvyk1000ziss$kli_uzid SET ".
"r".$cislo_rdk."=r".$cislo_rdk."+".$zisk_rozd."  ".
" WHERE prx = 1 ";
//echo $sqtoz;
if( $fir_uctx06 > 0 ) { $oznac = mysql_query("$sqtoz"); }

//vypocitaj znovu riadky
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r38=r01+r02+r03+r04+r05+r06+r07+r08+r09+r10+r11+r12+r13+r14+r15+r16+r17+r18+r19+r20+r21+r22+r23+r24+r25+r26+r27+r28+r29, ".
"r38=r38+r30+r31+r32+r33+r34+r35+r36+r37, ".
"r74=r39+r40+r41+r42+r43+r44+r45+r46+r47+r48+r49+r50+r51+r52+r53+r54+r55+r56+r57+r58+r59, ".
"r74=r74+r60+r61+r62+r63+r64+r65+r66+r67+r68+r69+r70+r71+r72+r73, ".
"r75=r74-r38,".
"r78=r75-r76-r77,".
"r995=2*r74+r75+r76+r77+r78,".
"r994=2*r38 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//vypocitaj znovu spolu
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rsp01=r01+rpc01,rsp02=r02+rpc02,rsp03=r03+rpc03,rsp04=r04+rpc04,rsp05=r05+rpc05,".
"rsp06=r06+rpc06,rsp07=r07+rpc07,rsp08=r08+rpc08,rsp09=r09+rpc09,rsp10=r10+rpc10,".
"rsp11=r11+rpc11,rsp12=r12+rpc12,rsp13=r13+rpc13,rsp14=r14+rpc14,rsp15=r15+rpc15,".
"rsp16=r16+rpc16,rsp17=r17+rpc17,rsp18=r18+rpc18,rsp19=r19+rpc19,rsp20=r20+rpc20,".
"rsp21=r21+rpc21,rsp22=r22+rpc22,rsp23=r23+rpc23,rsp24=r24+rpc24,rsp25=r25+rpc25,".
"rsp26=r26+rpc26,rsp27=r27+rpc27,rsp28=r28+rpc28,rsp29=r29+rpc29,rsp30=r30+rpc30,".
"rsp31=r31+rpc31,rsp32=r32+rpc32,rsp33=r33+rpc33,rsp34=r34+rpc34,rsp35=r35+rpc35,".
"rsp36=r36+rpc36,rsp37=r37+rpc37,rsp38=r38+rpc38,rsp39=r39+rpc39,rsp40=r40+rpc40,".
"rsp41=r41+rpc41,rsp42=r42+rpc42,rsp43=r43+rpc43,rsp44=r44+rpc44,rsp45=r45+rpc45,".
"rsp46=r46+rpc46,rsp47=r47+rpc47,rsp48=r48+rpc48,rsp49=r49+rpc49,rsp50=r50+rpc50,".
"rsp51=r51+rpc51,rsp52=r52+rpc52,rsp53=r53+rpc53,rsp54=r54+rpc54,rsp55=r55+rpc55,".
"rsp56=r56+rpc56,rsp57=r57+rpc57,rsp58=r58+rpc58,rsp59=r59+rpc59,rsp60=r60+rpc60,".
"rsp61=r61+rpc61,rsp62=r62+rpc62,rsp63=r63+rpc63,rsp64=r64+rpc64,rsp65=r65+rpc65,".
"rsp66=r66+rpc66,rsp67=r67+rpc67,rsp68=r68+rpc68,rsp69=r69+rpc69,rsp70=r70+rpc70,".
"rsp71=r71+rpc71,rsp72=r72+rpc72,rsp73=r73+rpc73,rsp74=r74+rpc74,rsp75=r75+rpc75,".
"rsp76=r76+rpc76,rsp77=r77+rpc77,rsp78=r78+rpc78,rsp994=r994+rpc994,rsp995=r995+rpc995".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//echo " ".$fir_uctx06;
//echo " ".$zisk_suvaha;
//echo " ".$zisk_vzisk;
//echo " ".$zisk_rozd;
}
//koniec rozdiel po zaokruhleni



//poc.stav subory
$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,2),
   rm01         DECIMAL(10,2),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocvziskovno_stl'.$sqlt;
$ulozene = mysql_query("$sql");

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpocvziskovno_stl1000';
$ulozene = mysql_query("$sql");
$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpocvziskovno_stt';
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
   rm104         DECIMAL(10,0),
   rm105         DECIMAL(10,0),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocvziskovno_stt'.$sqlt;
$ulozene = mysql_query("$sql");

//koniec poc.stav

$skusobna=0;
if( $skusobna == 1 )
  {
  $text = "UPDATE F".$kli_vxcf."_prcvykziss".$kli_uzid." SET ";

  $i=0;
  while ( $i < 79 )
   {
   $ix=$i;
   if( $i < 10 ) { $ix="0".$i; }
   if( $i == 0 ) {  $text = $text."  "; }
   if( $i == 1 ) {  $text = $text."  r".$ix."=".$i." "; }
   if( $i > 1 )  {  $text = $text." ,r".$ix."=".$i." "; }
   $hodpc=1000+$i;
   if( $i > 0 )  {  $text = $text." ,rpc".$ix."=".$hodpc." "; }
   $hodsp=2000+$i;
   if( $i > 0 )  {  $text = $text." ,rsp".$ix."=".$hodsp." "; }

  $i=$i+1;
   }
  $text = $text." WHERE prx = 1 ";
//echo $text;
//exit;
$ulozene = mysql_query("$text");

  $text = "UPDATE F".$kli_vxcf."_uctpocvziskovno_stl SET ";

  $i=0;
  while ( $i < 79 )
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

window.open('../ucto/uzavierka_nuj2013.php?copern=10&drupoh=1&tis=0&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=1', '_self' )


</script>
<?php
exit;
  }


//vytlac
//$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid." WHERE prx = 1 ".""; 
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocvziskovno_stl".
" ON F$kli_vxcf"."_prcvykziss$kli_uzid.prx=F$kli_vxcf"."_uctpocvziskovno_stl.fic".
" WHERE prx = 1 "."";



if( $tis > 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctpocvziskovno_stt SELECT ".
"dok,hod,".
"rm01,rm02,rm03,rm04,rm05,rm06,rm07,rm08,rm09,rm10,".
"rm11,rm12,rm13,rm14,rm15,rm16,rm17,rm18,rm19,rm20,".
"rm21,rm22,rm23,rm24,rm25,rm26,rm27,rm28,rm29,rm30,".
"rm31,rm32,rm33,rm34,rm35,rm36,rm37,rm38,rm39,rm40,".
"rm41,rm42,rm43,rm44,rm45,rm46,rm47,rm48,rm49,rm50,".
"rm51,rm52,rm53,rm54,rm55,rm56,rm57,rm58,rm59,rm60,".
"rm61,rm62,rm63,rm64,rm65,rm66,rm67,rm68,rm69,rm70,".
"rm71,rm72,rm73,rm74,rm75,rm76,rm77,rm78,rm104,rm105,".
"fic".
" FROM F$kli_vxcf"."_uctpocvziskovno_stl".
"";

$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocvziskovno_stt".
" ON F$kli_vxcf"."_prcvyk1000ziss$kli_uzid.prx=F$kli_vxcf"."_uctpocvziskovno_stt.fic".
" WHERE prx = 1 ".""; 

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

//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/vysledovka_str1.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/vysledovka_str1.jpg',12,26,191,262); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);
$pdf->Cell(190,30,"     ","0",1,"L");


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
$pdf->Cell(190,12,"     ","0",1,"L");
$pdf->Cell(70,6," ","0",0,"R");$pdf->Cell(35,6,"$datk_sk","0",1,"C");


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

$pdf->Cell(190,16,"     ","0",1,"L");
$pdf->Cell(59,5," ","0",0,"R");$pdf->Cell(6,6,"$me1","0",0,"C");$pdf->Cell(7,6,"$me2","0",0,"C");

$A=substr($kli_rdph,0,1);
$B=substr($kli_rdph,1,1);
$C=substr($kli_rdph,2,1);
$D=substr($kli_rdph,3,1);

$pdf->Cell(5,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1); 
}

$pdf->Cell(18,5," ","0",0,"R");$pdf->Cell(6,6,"$Am","0",0,"C");$pdf->Cell(5,6,"$Bm","0",0,"C");

$pdf->Cell(7,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");

$pdf->Cell(7,5," ","0",1,"C");

//predchadzajuce obdobie
$mep1="0"; $mep2="1";
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$mep1=substr($obmm1,0,1);
$mep2=substr($obmm1,1,1); 
}

$pdf->Cell(190,12,"     ","0",1,"L");
$pdf->Cell(59,5," ","0",0,"R");$pdf->Cell(6,6,"$mep1","0",0,"C");$pdf->Cell(7,6,"$mep2","0",0,"C");

$kli_prdph=$kli_rdph-1;

$A=substr($kli_prdph,0,1);
$B=substr($kli_prdph,1,1);
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);

$pdf->Cell(5,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(6,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");

$mepm1="1"; $mepm2="2";
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) 
{ 
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1); 
}

$pdf->Cell(18,5," ","0",0,"R");$pdf->Cell(6,6,"$mepm1","0",0,"C");$pdf->Cell(5,6,"$mepm2","0",0,"C");

$pdf->Cell(7,5," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");

$pdf->Cell(7,5," ","0",1,"C");

//riadna uzavierka
$pdf->Cell(190,18,"     ","0",1,"L");
$pdf->Cell(97,5," ","0",0,"R");$pdf->Cell(7,6,"x","0",0,"C");$pdf->Cell(7,6," ","0",1,"C");

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

$pdf->Cell(190,-7,"     ","0",1,"L");
$pdf->Cell(3,6," ","0",0,"R");$pdf->Cell(6,6,"$A","0",0,"C");
$pdf->Cell(4,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(6,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(5,6,"$G","0",0,"C");
$pdf->Cell(5,6,"$H","0",0,"C");$pdf->Cell(5,6,"$I","0",0,"C");
$pdf->Cell(7,6,"$J","0",0,"C");

$pdf->Cell(7,5," ","0",1,"C");

//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(190,8,"     ","0",1,"L");
$pdf->Cell(3,6," ","0",0,"R");$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");

$pdf->Cell(7,5," ","0",1,"C");

//nazov r1
$pdf->Cell(190,26,"     ","0",1,"L");

$A=substr($fir_fnaz,0,1);$B=substr($fir_fnaz,1,1);$C=substr($fir_fnaz,2,1);$D=substr($fir_fnaz,3,1);$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);$G=substr($fir_fnaz,6,1);$H=substr($fir_fnaz,7,1);$I=substr($fir_fnaz,8,1);$J=substr($fir_fnaz,9,1);

$K=substr($fir_fnaz,10,1);$L=substr($fir_fnaz,11,1);$M=substr($fir_fnaz,12,1);$N=substr($fir_fnaz,13,1);$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);$R=substr($fir_fnaz,16,1);$S=substr($fir_fnaz,17,1);$T=substr($fir_fnaz,18,1);$U=substr($fir_fnaz,19,1);

$V=substr($fir_fnaz,20,1);$W=substr($fir_fnaz,21,1);$X=substr($fir_fnaz,22,1);$Y=substr($fir_fnaz,23,1);$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);$B1=substr($fir_fnaz,26,1);$C1=substr($fir_fnaz,27,1);$D1=substr($fir_fnaz,28,1);$E1=substr($fir_fnaz,29,1);

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

$pdf->Cell(6,6,"$V","0",0,"C");
$pdf->Cell(6,6,"$W","0",0,"C");$pdf->Cell(5,6,"$X","0",0,"C");
$pdf->Cell(6,6,"$Y","0",0,"C");$pdf->Cell(6,6,"$Z","0",0,"C");
$pdf->Cell(6,6,"$A1","0",0,"C");
$pdf->Cell(6,6,"$B1","0",0,"C");$pdf->Cell(6,6,"$C1","0",0,"C");
$pdf->Cell(6,6,"$D1","0",0,"C");$pdf->Cell(6,6,"$E1","0",0,"C");

$pdf->Cell(1,6," ","0",1,"C");


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

$pdf->Cell(190,9,"     ","0",1,"L");
$A=substr($tel_pred,0,1);$B=substr($tel_pred,1,1);$C=substr($tel_pred,2,1);$D=substr($tel_pred,3,1);$E=substr($tel_pred,4,1);$F=substr($tel_pred,5,1);

$pdf->Cell(7,6," ","$rmc",0,"C");;$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(6,6,"$B","$rmc",0,"C");
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

$pdf->SetY(140);$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$sn1c","$rmc",0,"C");$pdf->Cell(4,6,"$sn2c","$rmc",0,"C");

//datum zostavenia
$h_zos = $_REQUEST['h_zos'];
$pdf->SetY(250);
$pdf->SetX(30);

$pdf->Cell(20,6,"$h_zos","0",1,"L");

//strana2

$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01="";
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02="";
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03="";
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04="";
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05="";
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06="";
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07="";
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08="";
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09="";
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10="";
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11="";
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12="";
$r13=$hlavicka->r13;
if( $hlavicka->r13 == 0 ) $r13="";
$r14=$hlavicka->r14;
if( $hlavicka->r14 == 0 ) $r14="";
$r15=$hlavicka->r15;
if( $hlavicka->r15 == 0 ) $r15="";
$r16=$hlavicka->r16;
if( $hlavicka->r16 == 0 ) $r16="";
$r17=$hlavicka->r17;
if( $hlavicka->r17 == 0 ) $r17="";
$r18=$hlavicka->r18;
if( $hlavicka->r18 == 0 ) $r18="";
$r19=$hlavicka->r19;
if( $hlavicka->r19 == 0 ) $r19="";
$r20=$hlavicka->r20;
if( $hlavicka->r20 == 0 ) $r20="";
$r21=$hlavicka->r21;
if( $hlavicka->r21 == 0 ) $r21="";
$r22=$hlavicka->r22;
if( $hlavicka->r22 == 0 ) $r22="";
$r23=$hlavicka->r23;
if( $hlavicka->r23 == 0 ) $r23="";
$r24=$hlavicka->r24;
if( $hlavicka->r24 == 0 ) $r24="";
$r25=$hlavicka->r25;
if( $hlavicka->r25 == 0 ) $r25="";
$r26=$hlavicka->r26;
if( $hlavicka->r26 == 0 ) $r26="";
$r27=$hlavicka->r27;
if( $hlavicka->r27 == 0 ) $r27="";
$r28=$hlavicka->r28;
if( $hlavicka->r28 == 0 ) $r28="";
$r29=$hlavicka->r29;
if( $hlavicka->r29 == 0 ) $r29="";
$r30=$hlavicka->r30;
if( $hlavicka->r30 == 0 ) $r30="";
$r31=$hlavicka->r31;
if( $hlavicka->r31 == 0 ) $r31="";
$r32=$hlavicka->r32;
if( $hlavicka->r32 == 0 ) $r32="";
$r33=$hlavicka->r33;
if( $hlavicka->r33 == 0 ) $r33="";
$r34=$hlavicka->r34;
if( $hlavicka->r34 == 0 ) $r34="";
$r35=$hlavicka->r35;
if( $hlavicka->r35 == 0 ) $r35="";
$r36=$hlavicka->r36;
if( $hlavicka->r36 == 0 ) $r36="";
$r37=$hlavicka->r37;
if( $hlavicka->r37 == 0 ) $r37="";
$r38=$hlavicka->r38;
if( $hlavicka->r38 == 0 ) $r38="";
$r39=$hlavicka->r39;
if( $hlavicka->r39 == 0 ) $r39="";
$r40=$hlavicka->r40;
if( $hlavicka->r40 == 0 ) $r40="";
$r41=$hlavicka->r41;
if( $hlavicka->r41 == 0 ) $r41="";
$r42=$hlavicka->r42;
if( $hlavicka->r42 == 0 ) $r42="";
$r43=$hlavicka->r43;
if( $hlavicka->r43 == 0 ) $r43="";
$r44=$hlavicka->r44;
if( $hlavicka->r44 == 0 ) $r44="";
$r45=$hlavicka->r45;
if( $hlavicka->r45 == 0 ) $r45="";
$r46=$hlavicka->r46;
if( $hlavicka->r46 == 0 ) $r46="";
$r47=$hlavicka->r47;
if( $hlavicka->r47 == 0 ) $r47="";
$r48=$hlavicka->r48;
if( $hlavicka->r48 == 0 ) $r48="";
$r49=$hlavicka->r49;
if( $hlavicka->r49 == 0 ) $r49="";
$r50=$hlavicka->r50;
if( $hlavicka->r50 == 0 ) $r50="";
$r51=$hlavicka->r51;
if( $hlavicka->r51 == 0 ) $r51="";
$r52=$hlavicka->r52;
if( $hlavicka->r52 == 0 ) $r52="";
$r53=$hlavicka->r53;
if( $hlavicka->r53 == 0 ) $r53="";
$r54=$hlavicka->r54;
if( $hlavicka->r54 == 0 ) $r54="";
$r55=$hlavicka->r55;
if( $hlavicka->r55 == 0 ) $r55="";
$r56=$hlavicka->r56;
if( $hlavicka->r56 == 0 ) $r56="";
$r57=$hlavicka->r57;
if( $hlavicka->r57 == 0 ) $r57="";
$r58=$hlavicka->r58;
if( $hlavicka->r58 == 0 ) $r58="";
$r59=$hlavicka->r59;
if( $hlavicka->r59 == 0 ) $r59="";
$r60=$hlavicka->r60;
if( $hlavicka->r60 == 0 ) $r60="";
$r61=$hlavicka->r61;
if( $hlavicka->r61 == 0 ) $r61="";
$r62=$hlavicka->r62;
if( $hlavicka->r62 == 0 ) $r62="";
$r63=$hlavicka->r63;
if( $hlavicka->r63 == 0 ) $r63="";
$r64=$hlavicka->r64;
if( $hlavicka->r64 == 0 ) $r64="";
$r65=$hlavicka->r65;
if( $hlavicka->r65 == 0 ) $r65="";
$r66=$hlavicka->r66;
if( $hlavicka->r66 == 0 ) $r66="";
$r67=$hlavicka->r67;
if( $hlavicka->r67 == 0 ) $r67="";
$r68=$hlavicka->r68;
if( $hlavicka->r68 == 0 ) $r68="";
$r69=$hlavicka->r69;
if( $hlavicka->r69 == 0 ) $r69="";
$r70=$hlavicka->r70;
if( $hlavicka->r70 == 0 ) $r70="";
$r71=$hlavicka->r71;
if( $hlavicka->r71 == 0 ) $r71="";
$r72=$hlavicka->r72;
if( $hlavicka->r72 == 0 ) $r72="";
$r73=$hlavicka->r73;
if( $hlavicka->r73 == 0 ) $r73="";
$r74=$hlavicka->r74;
if( $hlavicka->r74 == 0 ) $r74="";
$r75=$hlavicka->r75;
if( $hlavicka->r75 == 0 ) $r75="";
$r76=$hlavicka->r76;
if( $hlavicka->r76 == 0 ) $r76="";
$r77=$hlavicka->r77;
if( $hlavicka->r77 == 0 ) $r77="";
$r78=$hlavicka->r78;
if( $hlavicka->r78 == 0 ) $r78="";
$r994=$hlavicka->r994;
if( $hlavicka->r994 == 0 ) $r994="";
$r995=$hlavicka->r995;
if( $hlavicka->r995 == 0 ) $r995="";

$rpc01=$hlavicka->rpc01;
if( $hlavicka->rpc01 == 0 ) $rpc01="";
$rpc02=$hlavicka->rpc02;
if( $hlavicka->rpc02 == 0 ) $rpc02="";
$rpc03=$hlavicka->rpc03;
if( $hlavicka->rpc03 == 0 ) $rpc03="";
$rpc04=$hlavicka->rpc04;
if( $hlavicka->rpc04 == 0 ) $rpc04="";
$rpc05=$hlavicka->rpc05;
if( $hlavicka->rpc05 == 0 ) $rpc05="";
$rpc06=$hlavicka->rpc06;
if( $hlavicka->rpc06 == 0 ) $rpc06="";
$rpc07=$hlavicka->rpc07;
if( $hlavicka->rpc07 == 0 ) $rpc07="";
$rpc08=$hlavicka->rpc08;
if( $hlavicka->rpc08 == 0 ) $rpc08="";
$rpc09=$hlavicka->rpc09;
if( $hlavicka->rpc09 == 0 ) $rpc09="";
$rpc10=$hlavicka->rpc10;
if( $hlavicka->rpc10 == 0 ) $rpc10="";
$rpc11=$hlavicka->rpc11;
if( $hlavicka->rpc11 == 0 ) $rpc11="";
$rpc12=$hlavicka->rpc12;
if( $hlavicka->rpc12 == 0 ) $rpc12="";
$rpc13=$hlavicka->rpc13;
if( $hlavicka->rpc13 == 0 ) $rpc13="";
$rpc14=$hlavicka->rpc14;
if( $hlavicka->rpc14 == 0 ) $rpc14="";
$rpc15=$hlavicka->rpc15;
if( $hlavicka->rpc15 == 0 ) $rpc15="";
$rpc16=$hlavicka->rpc16;
if( $hlavicka->rpc16 == 0 ) $rpc16="";
$rpc17=$hlavicka->rpc17;
if( $hlavicka->rpc17 == 0 ) $rpc17="";
$rpc18=$hlavicka->rpc18;
if( $hlavicka->rpc18 == 0 ) $rpc18="";
$rpc19=$hlavicka->rpc19;
if( $hlavicka->rpc19 == 0 ) $rpc19="";
$rpc20=$hlavicka->rpc20;
if( $hlavicka->rpc20 == 0 ) $rpc20="";
$rpc21=$hlavicka->rpc21;
if( $hlavicka->rpc21 == 0 ) $rpc21="";
$rpc22=$hlavicka->rpc22;
if( $hlavicka->rpc22 == 0 ) $rpc22="";
$rpc23=$hlavicka->rpc23;
if( $hlavicka->rpc23 == 0 ) $rpc23="";
$rpc24=$hlavicka->rpc24;
if( $hlavicka->rpc24 == 0 ) $rpc24="";
$rpc25=$hlavicka->rpc25;
if( $hlavicka->rpc25 == 0 ) $rpc25="";
$rpc26=$hlavicka->rpc26;
if( $hlavicka->rpc26 == 0 ) $rpc26="";
$rpc27=$hlavicka->rpc27;
if( $hlavicka->rpc27 == 0 ) $rpc27="";
$rpc28=$hlavicka->rpc28;
if( $hlavicka->rpc28 == 0 ) $rpc28="";
$rpc29=$hlavicka->rpc29;
if( $hlavicka->rpc29 == 0 ) $rpc29="";
$rpc30=$hlavicka->rpc30;
if( $hlavicka->rpc30 == 0 ) $rpc30="";
$rpc31=$hlavicka->rpc31;
if( $hlavicka->rpc31 == 0 ) $rpc31="";
$rpc32=$hlavicka->rpc32;
if( $hlavicka->rpc32 == 0 ) $rpc32="";
$rpc33=$hlavicka->rpc33;
if( $hlavicka->rpc33 == 0 ) $rpc33="";
$rpc34=$hlavicka->rpc34;
if( $hlavicka->rpc34 == 0 ) $rpc34="";
$rpc35=$hlavicka->rpc35;
if( $hlavicka->rpc35 == 0 ) $rpc35="";
$rpc36=$hlavicka->rpc36;
if( $hlavicka->rpc36 == 0 ) $rpc36="";
$rpc37=$hlavicka->rpc37;
if( $hlavicka->rpc37 == 0 ) $rpc37="";
$rpc38=$hlavicka->rpc38;
if( $hlavicka->rpc38 == 0 ) $rpc38="";
$rpc39=$hlavicka->rpc39;
if( $hlavicka->rpc39 == 0 ) $rpc39="";
$rpc40=$hlavicka->rpc40;
if( $hlavicka->rpc40 == 0 ) $rpc40="";
$rpc41=$hlavicka->rpc41;
if( $hlavicka->rpc41 == 0 ) $rpc41="";
$rpc42=$hlavicka->rpc42;
if( $hlavicka->rpc42 == 0 ) $rpc42="";
$rpc43=$hlavicka->rpc43;
if( $hlavicka->rpc43 == 0 ) $rpc43="";
$rpc44=$hlavicka->rpc44;
if( $hlavicka->rpc44 == 0 ) $rpc44="";
$rpc45=$hlavicka->rpc45;
if( $hlavicka->rpc45 == 0 ) $rpc45="";
$rpc46=$hlavicka->rpc46;
if( $hlavicka->rpc46 == 0 ) $rpc46="";
$rpc47=$hlavicka->rpc47;
if( $hlavicka->rpc47 == 0 ) $rpc47="";
$rpc48=$hlavicka->rpc48;
if( $hlavicka->rpc48 == 0 ) $rpc48="";
$rpc49=$hlavicka->rpc49;
if( $hlavicka->rpc49 == 0 ) $rpc49="";
$rpc50=$hlavicka->rpc50;
if( $hlavicka->rpc50 == 0 ) $rpc50="";
$rpc51=$hlavicka->rpc51;
if( $hlavicka->rpc51 == 0 ) $rpc51="";
$rpc52=$hlavicka->rpc52;
if( $hlavicka->rpc52 == 0 ) $rpc52="";
$rpc53=$hlavicka->rpc53;
if( $hlavicka->rpc53 == 0 ) $rpc53="";
$rpc54=$hlavicka->rpc54;
if( $hlavicka->rpc54 == 0 ) $rpc54="";
$rpc55=$hlavicka->rpc55;
if( $hlavicka->rpc55 == 0 ) $rpc55="";
$rpc56=$hlavicka->rpc56;
if( $hlavicka->rpc56 == 0 ) $rpc56="";
$rpc57=$hlavicka->rpc57;
if( $hlavicka->rpc57 == 0 ) $rpc57="";
$rpc58=$hlavicka->rpc58;
if( $hlavicka->rpc58 == 0 ) $rpc58="";
$rpc59=$hlavicka->rpc59;
if( $hlavicka->rpc59 == 0 ) $rpc59="";
$rpc60=$hlavicka->rpc60;
if( $hlavicka->rpc60 == 0 ) $rpc60="";
$rpc61=$hlavicka->rpc61;
if( $hlavicka->rpc61 == 0 ) $rpc61="";
$rpc62=$hlavicka->rpc62;
if( $hlavicka->rpc62 == 0 ) $rpc62="";
$rpc63=$hlavicka->rpc63;
if( $hlavicka->rpc63 == 0 ) $rpc63="";
$rpc64=$hlavicka->rpc64;
if( $hlavicka->rpc64 == 0 ) $rpc64="";
$rpc65=$hlavicka->rpc65;
if( $hlavicka->rpc65 == 0 ) $rpc65="";
$rpc66=$hlavicka->rpc66;
if( $hlavicka->rpc66 == 0 ) $rpc66="";
$rpc67=$hlavicka->rpc67;
if( $hlavicka->rpc67 == 0 ) $rpc67="";
$rpc68=$hlavicka->rpc68;
if( $hlavicka->rpc68 == 0 ) $rpc68="";
$rpc69=$hlavicka->rpc69;
if( $hlavicka->rpc69 == 0 ) $rpc69="";
$rpc70=$hlavicka->rpc70;
if( $hlavicka->rpc70 == 0 ) $rpc70="";
$rpc71=$hlavicka->rpc71;
if( $hlavicka->rpc71 == 0 ) $rpc71="";
$rpc72=$hlavicka->rpc72;
if( $hlavicka->rpc72 == 0 ) $rpc72="";
$rpc73=$hlavicka->rpc73;
if( $hlavicka->rpc73 == 0 ) $rpc73="";
$rpc74=$hlavicka->rpc74;
if( $hlavicka->rpc74 == 0 ) $rpc74="";
$rpc75=$hlavicka->rpc75;
if( $hlavicka->rpc75 == 0 ) $rpc75="";
$rpc76=$hlavicka->rpc76;
if( $hlavicka->rpc76 == 0 ) $rpc76="";
$rpc77=$hlavicka->rpc77;
if( $hlavicka->rpc77 == 0 ) $rpc77="";
$rpc78=$hlavicka->rpc78;
if( $hlavicka->rpc78 == 0 ) $rpc78="";
$rpc994=$hlavicka->rpc994;
if( $hlavicka->rpc994 == 0 ) $rpc994="";
$rpc995=$hlavicka->rpc995;
if( $hlavicka->rpc995 == 0 ) $rpc995="";


$rsp01=$hlavicka->rsp01;
if( $hlavicka->rsp01 == 0 ) $rsp01="";
$rsp02=$hlavicka->rsp02;
if( $hlavicka->rsp02 == 0 ) $rsp02="";
$rsp03=$hlavicka->rsp03;
if( $hlavicka->rsp03 == 0 ) $rsp03="";
$rsp04=$hlavicka->rsp04;
if( $hlavicka->rsp04 == 0 ) $rsp04="";
$rsp05=$hlavicka->rsp05;
if( $hlavicka->rsp05 == 0 ) $rsp05="";
$rsp06=$hlavicka->rsp06;
if( $hlavicka->rsp06 == 0 ) $rsp06="";
$rsp07=$hlavicka->rsp07;
if( $hlavicka->rsp07 == 0 ) $rsp07="";
$rsp08=$hlavicka->rsp08;
if( $hlavicka->rsp08 == 0 ) $rsp08="";
$rsp09=$hlavicka->rsp09;
if( $hlavicka->rsp09 == 0 ) $rsp09="";
$rsp10=$hlavicka->rsp10;
if( $hlavicka->rsp10 == 0 ) $rsp10="";
$rsp11=$hlavicka->rsp11;
if( $hlavicka->rsp11 == 0 ) $rsp11="";
$rsp12=$hlavicka->rsp12;
if( $hlavicka->rsp12 == 0 ) $rsp12="";
$rsp13=$hlavicka->rsp13;
if( $hlavicka->rsp13 == 0 ) $rsp13="";
$rsp14=$hlavicka->rsp14;
if( $hlavicka->rsp14 == 0 ) $rsp14="";
$rsp15=$hlavicka->rsp15;
if( $hlavicka->rsp15 == 0 ) $rsp15="";
$rsp16=$hlavicka->rsp16;
if( $hlavicka->rsp16 == 0 ) $rsp16="";
$rsp17=$hlavicka->rsp17;
if( $hlavicka->rsp17 == 0 ) $rsp17="";
$rsp18=$hlavicka->rsp18;
if( $hlavicka->rsp18 == 0 ) $rsp18="";
$rsp19=$hlavicka->rsp19;
if( $hlavicka->rsp19 == 0 ) $rsp19="";
$rsp20=$hlavicka->rsp20;
if( $hlavicka->rsp20 == 0 ) $rsp20="";
$rsp21=$hlavicka->rsp21;
if( $hlavicka->rsp21 == 0 ) $rsp21="";
$rsp22=$hlavicka->rsp22;
if( $hlavicka->rsp22 == 0 ) $rsp22="";
$rsp23=$hlavicka->rsp23;
if( $hlavicka->rsp23 == 0 ) $rsp23="";
$rsp24=$hlavicka->rsp24;
if( $hlavicka->rsp24 == 0 ) $rsp24="";
$rsp25=$hlavicka->rsp25;
if( $hlavicka->rsp25 == 0 ) $rsp25="";
$rsp26=$hlavicka->rsp26;
if( $hlavicka->rsp26 == 0 ) $rsp26="";
$rsp27=$hlavicka->rsp27;
if( $hlavicka->rsp27 == 0 ) $rsp27="";
$rsp28=$hlavicka->rsp28;
if( $hlavicka->rsp28 == 0 ) $rsp28="";
$rsp29=$hlavicka->rsp29;
if( $hlavicka->rsp29 == 0 ) $rsp29="";
$rsp30=$hlavicka->rsp30;
if( $hlavicka->rsp30 == 0 ) $rsp30="";
$rsp31=$hlavicka->rsp31;
if( $hlavicka->rsp31 == 0 ) $rsp31="";
$rsp32=$hlavicka->rsp32;
if( $hlavicka->rsp32 == 0 ) $rsp32="";
$rsp33=$hlavicka->rsp33;
if( $hlavicka->rsp33 == 0 ) $rsp33="";
$rsp34=$hlavicka->rsp34;
if( $hlavicka->rsp34 == 0 ) $rsp34="";
$rsp35=$hlavicka->rsp35;
if( $hlavicka->rsp35 == 0 ) $rsp35="";
$rsp36=$hlavicka->rsp36;
if( $hlavicka->rsp36 == 0 ) $rsp36="";
$rsp37=$hlavicka->rsp37;
if( $hlavicka->rsp37 == 0 ) $rsp37="";
$rsp38=$hlavicka->rsp38;
if( $hlavicka->rsp38 == 0 ) $rsp38="";
$rsp39=$hlavicka->rsp39;
if( $hlavicka->rsp39 == 0 ) $rsp39="";
$rsp40=$hlavicka->rsp40;
if( $hlavicka->rsp40 == 0 ) $rsp40="";
$rsp41=$hlavicka->rsp41;
if( $hlavicka->rsp41 == 0 ) $rsp41="";
$rsp42=$hlavicka->rsp42;
if( $hlavicka->rsp42 == 0 ) $rsp42="";
$rsp43=$hlavicka->rsp43;
if( $hlavicka->rsp43 == 0 ) $rsp43="";
$rsp44=$hlavicka->rsp44;
if( $hlavicka->rsp44 == 0 ) $rsp44="";
$rsp45=$hlavicka->rsp45;
if( $hlavicka->rsp45 == 0 ) $rsp45="";
$rsp46=$hlavicka->rsp46;
if( $hlavicka->rsp46 == 0 ) $rsp46="";
$rsp47=$hlavicka->rsp47;
if( $hlavicka->rsp47 == 0 ) $rsp47="";
$rsp48=$hlavicka->rsp48;
if( $hlavicka->rsp48 == 0 ) $rsp48="";
$rsp49=$hlavicka->rsp49;
if( $hlavicka->rsp49 == 0 ) $rsp49="";
$rsp50=$hlavicka->rsp50;
if( $hlavicka->rsp50 == 0 ) $rsp50="";
$rsp51=$hlavicka->rsp51;
if( $hlavicka->rsp51 == 0 ) $rsp51="";
$rsp52=$hlavicka->rsp52;
if( $hlavicka->rsp52 == 0 ) $rsp52="";
$rsp53=$hlavicka->rsp53;
if( $hlavicka->rsp53 == 0 ) $rsp53="";
$rsp54=$hlavicka->rsp54;
if( $hlavicka->rsp54 == 0 ) $rsp54="";
$rsp55=$hlavicka->rsp55;
if( $hlavicka->rsp55 == 0 ) $rsp55="";
$rsp56=$hlavicka->rsp56;
if( $hlavicka->rsp56 == 0 ) $rsp56="";
$rsp57=$hlavicka->rsp57;
if( $hlavicka->rsp57 == 0 ) $rsp57="";
$rsp58=$hlavicka->rsp58;
if( $hlavicka->rsp58 == 0 ) $rsp58="";
$rsp59=$hlavicka->rsp59;
if( $hlavicka->rsp59 == 0 ) $rsp59="";
$rsp60=$hlavicka->rsp60;
if( $hlavicka->rsp60 == 0 ) $rsp60="";
$rsp61=$hlavicka->rsp61;
if( $hlavicka->rsp61 == 0 ) $rsp61="";
$rsp62=$hlavicka->rsp62;
if( $hlavicka->rsp62 == 0 ) $rsp62="";
$rsp63=$hlavicka->rsp63;
if( $hlavicka->rsp63 == 0 ) $rsp63="";
$rsp64=$hlavicka->rsp64;
if( $hlavicka->rsp64 == 0 ) $rsp64="";
$rsp65=$hlavicka->rsp65;
if( $hlavicka->rsp65 == 0 ) $rsp65="";
$rsp66=$hlavicka->rsp66;
if( $hlavicka->rsp66 == 0 ) $rsp66="";
$rsp67=$hlavicka->rsp67;
if( $hlavicka->rsp67 == 0 ) $rsp67="";
$rsp68=$hlavicka->rsp68;
if( $hlavicka->rsp68 == 0 ) $rsp68="";
$rsp69=$hlavicka->rsp69;
if( $hlavicka->rsp69 == 0 ) $rsp69="";
$rsp70=$hlavicka->rsp70;
if( $hlavicka->rsp70 == 0 ) $rsp70="";
$rsp71=$hlavicka->rsp71;
if( $hlavicka->rsp71 == 0 ) $rsp71="";
$rsp72=$hlavicka->rsp72;
if( $hlavicka->rsp72 == 0 ) $rsp72="";
$rsp73=$hlavicka->rsp73;
if( $hlavicka->rsp73 == 0 ) $rsp73="";
$rsp74=$hlavicka->rsp74;
if( $hlavicka->rsp74 == 0 ) $rsp74="";
$rsp75=$hlavicka->rsp75;
if( $hlavicka->rsp75 == 0 ) $rsp75="";
$rsp76=$hlavicka->rsp76;
if( $hlavicka->rsp76 == 0 ) $rsp76="";
$rsp77=$hlavicka->rsp77;
if( $hlavicka->rsp77 == 0 ) $rsp77="";
$rsp78=$hlavicka->rsp78;
if( $hlavicka->rsp78 == 0 ) $rsp78="";
$rsp994=$hlavicka->rsp994;
if( $hlavicka->rsp994 == 0 ) $rsp994="";
$rsp995=$hlavicka->rsp995;
if( $hlavicka->rsp995 == 0 ) $rsp995="";


$rm01=$hlavicka->rm01;
if( $hlavicka->rm01 == 0 ) $rm01="";
$rm02=$hlavicka->rm02;
if( $hlavicka->rm02 == 0 ) $rm02="";
$rm03=$hlavicka->rm03;
if( $hlavicka->rm03 == 0 ) $rm03="";
$rm04=$hlavicka->rm04;
if( $hlavicka->rm04 == 0 ) $rm04="";
$rm05=$hlavicka->rm05;
if( $hlavicka->rm05 == 0 ) $rm05="";
$rm06=$hlavicka->rm06;
if( $hlavicka->rm06 == 0 ) $rm06="";
$rm07=$hlavicka->rm07;
if( $hlavicka->rm07 == 0 ) $rm07="";
$rm08=$hlavicka->rm08;
if( $hlavicka->rm08 == 0 ) $rm08="";
$rm09=$hlavicka->rm09;
if( $hlavicka->rm09 == 0 ) $rm09="";
$rm10=$hlavicka->rm10;
if( $hlavicka->rm10 == 0 ) $rm10="";
$rm11=$hlavicka->rm11;
if( $hlavicka->rm11 == 0 ) $rm11="";
$rm12=$hlavicka->rm12;
if( $hlavicka->rm12 == 0 ) $rm12="";
$rm13=$hlavicka->rm13;
if( $hlavicka->rm13 == 0 ) $rm13="";
$rm14=$hlavicka->rm14;
if( $hlavicka->rm14 == 0 ) $rm14="";
$rm15=$hlavicka->rm15;
if( $hlavicka->rm15 == 0 ) $rm15="";
$rm16=$hlavicka->rm16;
if( $hlavicka->rm16 == 0 ) $rm16="";
$rm17=$hlavicka->rm17;
if( $hlavicka->rm17 == 0 ) $rm17="";
$rm18=$hlavicka->rm18;
if( $hlavicka->rm18 == 0 ) $rm18="";
$rm19=$hlavicka->rm19;
if( $hlavicka->rm19 == 0 ) $rm19="";
$rm20=$hlavicka->rm20;
if( $hlavicka->rm20 == 0 ) $rm20="";
$rm21=$hlavicka->rm21;
if( $hlavicka->rm21 == 0 ) $rm21="";
$rm22=$hlavicka->rm22;
if( $hlavicka->rm22 == 0 ) $rm22="";
$rm23=$hlavicka->rm23;
if( $hlavicka->rm23 == 0 ) $rm23="";
$rm24=$hlavicka->rm24;
if( $hlavicka->rm24 == 0 ) $rm24="";
$rm25=$hlavicka->rm25;
if( $hlavicka->rm25 == 0 ) $rm25="";
$rm26=$hlavicka->rm26;
if( $hlavicka->rm26 == 0 ) $rm26="";
$rm27=$hlavicka->rm27;
if( $hlavicka->rm27 == 0 ) $rm27="";
$rm28=$hlavicka->rm28;
if( $hlavicka->rm28 == 0 ) $rm28="";
$rm29=$hlavicka->rm29;
if( $hlavicka->rm29 == 0 ) $rm29="";
$rm30=$hlavicka->rm30;
if( $hlavicka->rm30 == 0 ) $rm30="";
$rm31=$hlavicka->rm31;
if( $hlavicka->rm31 == 0 ) $rm31="";
$rm32=$hlavicka->rm32;
if( $hlavicka->rm32 == 0 ) $rm32="";
$rm33=$hlavicka->rm33;
if( $hlavicka->rm33 == 0 ) $rm33="";
$rm34=$hlavicka->rm34;
if( $hlavicka->rm34 == 0 ) $rm34="";
$rm35=$hlavicka->rm35;
if( $hlavicka->rm35 == 0 ) $rm35="";
$rm36=$hlavicka->rm36;
if( $hlavicka->rm36 == 0 ) $rm36="";
$rm37=$hlavicka->rm37;
if( $hlavicka->rm37 == 0 ) $rm37="";
$rm38=$hlavicka->rm38;
if( $hlavicka->rm38 == 0 ) $rm38="";
$rm39=$hlavicka->rm39;
if( $hlavicka->rm39 == 0 ) $rm39="";
$rm40=$hlavicka->rm40;
if( $hlavicka->rm40 == 0 ) $rm40="";
$rm41=$hlavicka->rm41;
if( $hlavicka->rm41 == 0 ) $rm41="";
$rm42=$hlavicka->rm42;
if( $hlavicka->rm42 == 0 ) $rm42="";
$rm43=$hlavicka->rm43;
if( $hlavicka->rm43 == 0 ) $rm43="";
$rm44=$hlavicka->rm44;
if( $hlavicka->rm44 == 0 ) $rm44="";
$rm45=$hlavicka->rm45;
if( $hlavicka->rm45 == 0 ) $rm45="";
$rm46=$hlavicka->rm46;
if( $hlavicka->rm46 == 0 ) $rm46="";
$rm47=$hlavicka->rm47;
if( $hlavicka->rm47 == 0 ) $rm47="";
$rm48=$hlavicka->rm48;
if( $hlavicka->rm48 == 0 ) $rm48="";
$rm49=$hlavicka->rm49;
if( $hlavicka->rm49 == 0 ) $rm49="";
$rm50=$hlavicka->rm50;
if( $hlavicka->rm50 == 0 ) $rm50="";
$rm51=$hlavicka->rm51;
if( $hlavicka->rm51 == 0 ) $rm51="";
$rm52=$hlavicka->rm52;
if( $hlavicka->rm52 == 0 ) $rm52="";
$rm53=$hlavicka->rm53;
if( $hlavicka->rm53 == 0 ) $rm53="";
$rm54=$hlavicka->rm54;
if( $hlavicka->rm54 == 0 ) $rm54="";
$rm55=$hlavicka->rm55;
if( $hlavicka->rm55 == 0 ) $rm55="";
$rm56=$hlavicka->rm56;
if( $hlavicka->rm56 == 0 ) $rm56="";
$rm57=$hlavicka->rm57;
if( $hlavicka->rm57 == 0 ) $rm57="";
$rm58=$hlavicka->rm58;
if( $hlavicka->rm58 == 0 ) $rm58="";
$rm59=$hlavicka->rm59;
if( $hlavicka->rm59 == 0 ) $rm59="";
$rm60=$hlavicka->rm60;
if( $hlavicka->rm60 == 0 ) $rm60="";
$rm61=$hlavicka->rm61;
if( $hlavicka->rm61 == 0 ) $rm61="";
$rm62=$hlavicka->rm62;
if( $hlavicka->rm62 == 0 ) $rm62="";
$rm63=$hlavicka->rm63;
if( $hlavicka->rm63 == 0 ) $rm63="";
$rm64=$hlavicka->rm64;
if( $hlavicka->rm64 == 0 ) $rm64="";
$rm65=$hlavicka->rm65;
if( $hlavicka->rm65 == 0 ) $rm65="";
$rm66=$hlavicka->rm66;
if( $hlavicka->rm66 == 0 ) $rm66="";
$rm67=$hlavicka->rm67;
if( $hlavicka->rm67 == 0 ) $rm67="";
$rm68=$hlavicka->rm68;
if( $hlavicka->rm68 == 0 ) $rm68="";
$rm69=$hlavicka->rm69;
if( $hlavicka->rm69 == 0 ) $rm69="";
$rm70=$hlavicka->rm70;
if( $hlavicka->rm70 == 0 ) $rm70="";
$rm71=$hlavicka->rm71;
if( $hlavicka->rm71 == 0 ) $rm71="";
$rm72=$hlavicka->rm72;
if( $hlavicka->rm72 == 0 ) $rm72="";
$rm73=$hlavicka->rm73;
if( $hlavicka->rm73 == 0 ) $rm73="";
$rm74=$hlavicka->rm74;
if( $hlavicka->rm74 == 0 ) $rm74="";
$rm75=$hlavicka->rm75;
if( $hlavicka->rm75 == 0 ) $rm75="";
$rm76=$hlavicka->rm76;
if( $hlavicka->rm76 == 0 ) $rm76="";
$rm77=$hlavicka->rm77;
if( $hlavicka->rm77 == 0 ) $rm77="";
$rm78=$hlavicka->rm78;
if( $hlavicka->rm78 == 0 ) $rm78="";
$rm994=$hlavicka->rm104;
if( $hlavicka->rm104 == 0 ) $rm994="";
$rm995=$hlavicka->rm105;
if( $hlavicka->rm105 == 0 ) $rm995="";

//vypocitaj rm994,995 ako sucet
$nnne=1;
if( $nnne == 0 )
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

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/vysledovka_str2.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/vysledovka_str2.jpg',8,9,191,278); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);

$pdf->Cell(190,30,"     ","0",1,"L");


$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r01","0",0,"R");$pdf->Cell(27,5,"$rpc01","0",0,"R");$pdf->Cell(26,5,"$rsp01","0",0,"R");
$pdf->Cell(26,5,"$rm01","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r02","0",0,"R");$pdf->Cell(27,6,"$rpc02","0",0,"R");$pdf->Cell(26,6,"$rsp02","0",0,"R");
$pdf->Cell(26,6,"$rm02","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r03","0",0,"R");$pdf->Cell(27,6,"$rpc03","0",0,"R");$pdf->Cell(26,6,"$rsp03","0",0,"R");
$pdf->Cell(26,6,"$rm03","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r04","0",0,"R");$pdf->Cell(27,5,"$rpc04","0",0,"R");$pdf->Cell(26,5,"$rsp04","0",0,"R");
$pdf->Cell(26,5,"$rm04","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r05","0",0,"R");$pdf->Cell(27,5,"$rpc05","0",0,"R");$pdf->Cell(26,5,"$rsp05","0",0,"R");
$pdf->Cell(26,5,"$rm05","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r06","0",0,"R");$pdf->Cell(27,6,"$rpc06","0",0,"R");$pdf->Cell(26,6,"$rsp06","0",0,"R");
$pdf->Cell(26,6,"$rm06","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r07","0",0,"R");$pdf->Cell(27,5,"$rpc07","0",0,"R");$pdf->Cell(26,5,"$rsp07","0",0,"R");
$pdf->Cell(26,5,"$rm07","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r08","0",0,"R");$pdf->Cell(27,6,"$rpc08","0",0,"R");$pdf->Cell(26,6,"$rsp08","0",0,"R");
$pdf->Cell(26,6,"$rm08","0",1,"R");
$pdf->Cell(83,8," ","0",0,"R");$pdf->Cell(25,8,"$r09","0",0,"R");$pdf->Cell(27,8,"$rpc09","0",0,"R");$pdf->Cell(26,8,"$rsp09","0",0,"R");
$pdf->Cell(26,8,"$rm09","0",1,"R");

$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r10","0",0,"R");$pdf->Cell(27,6,"$rpc10","0",0,"R");$pdf->Cell(26,6,"$rsp10","0",0,"R");
$pdf->Cell(26,6,"$rm10","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r11","0",0,"R");$pdf->Cell(27,6,"$rpc11","0",0,"R");$pdf->Cell(26,6,"$rsp11","0",0,"R");
$pdf->Cell(26,6,"$rm11","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r12","0",0,"R");$pdf->Cell(27,5,"$rpc12","0",0,"R");$pdf->Cell(26,5,"$rsp12","0",0,"R");
$pdf->Cell(26,5,"$rm12","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r13","0",0,"R");$pdf->Cell(27,6,"$rpc13","0",0,"R");$pdf->Cell(26,6,"$rsp13","0",0,"R");
$pdf->Cell(26,6,"$rm13","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r14","0",0,"R");$pdf->Cell(27,5,"$rpc14","0",0,"R");$pdf->Cell(26,5,"$rsp14","0",0,"R");
$pdf->Cell(26,5,"$rm14","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r15","0",0,"R");$pdf->Cell(27,6,"$rpc15","0",0,"R");$pdf->Cell(26,6,"$rsp15","0",0,"R");
$pdf->Cell(26,6,"$rm15","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r16","0",0,"R");$pdf->Cell(27,5,"$rpc16","0",0,"R");$pdf->Cell(26,5,"$rsp16","0",0,"R");
$pdf->Cell(26,5,"$rm16","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r17","0",0,"R");$pdf->Cell(27,6,"$rpc17","0",0,"R");$pdf->Cell(26,6,"$rsp17","0",0,"R");
$pdf->Cell(26,6,"$rm17","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r18","0",0,"R");$pdf->Cell(27,6,"$rpc18","0",0,"R");$pdf->Cell(26,6,"$rsp18","0",0,"R");
$pdf->Cell(26,6,"$rm18","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r19","0",0,"R");$pdf->Cell(27,5,"$rpc19","0",0,"R");$pdf->Cell(26,5,"$rsp19","0",0,"R");
$pdf->Cell(26,5,"$rm19","0",1,"R");

$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r20","0",0,"R");$pdf->Cell(27,5,"$rpc20","0",0,"R");$pdf->Cell(26,5,"$rsp20","0",0,"R");
$pdf->Cell(26,5,"$rm20","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r21","0",0,"R");$pdf->Cell(27,6,"$rpc21","0",0,"R");$pdf->Cell(26,6,"$rsp21","0",0,"R");
$pdf->Cell(26,6,"$rm21","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r22","0",0,"R");$pdf->Cell(27,6,"$rpc22","0",0,"R");$pdf->Cell(26,6,"$rsp22","0",0,"R");
$pdf->Cell(26,6,"$rm22","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r23","0",0,"R");$pdf->Cell(27,5,"$rpc23","0",0,"R");$pdf->Cell(26,5,"$rsp23","0",0,"R");
$pdf->Cell(26,5,"$rm23","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r24","0",0,"R");$pdf->Cell(27,6,"$rpc24","0",0,"R");$pdf->Cell(26,6,"$rsp24","0",0,"R");
$pdf->Cell(26,6,"$rm24","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r25","0",0,"R");$pdf->Cell(27,9,"$rpc25","0",0,"R");$pdf->Cell(26,9,"$rsp25","0",0,"R");
$pdf->Cell(26,9,"$rm25","0",1,"R");
$pdf->Cell(83,12," ","0",0,"R");$pdf->Cell(25,12,"$r26","0",0,"R");$pdf->Cell(27,12,"$rpc26","0",0,"R");$pdf->Cell(26,12,"$rsp26","0",0,"R");
$pdf->Cell(26,12,"$rm26","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r27","0",0,"R");$pdf->Cell(27,5,"$rpc27","0",0,"R");$pdf->Cell(26,5,"$rsp27","0",0,"R");
$pdf->Cell(26,5,"$rm27","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r28","0",0,"R");$pdf->Cell(27,6,"$rpc28","0",0,"R");$pdf->Cell(26,6,"$rsp28","0",0,"R");
$pdf->Cell(26,6,"$rm28","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r29","0",0,"R");$pdf->Cell(27,6,"$rpc29","0",0,"R");$pdf->Cell(26,6,"$rsp29","0",0,"R");
$pdf->Cell(26,6,"$rm29","0",1,"R");


$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r30","0",0,"R");$pdf->Cell(27,5,"$rpc30","0",0,"R");$pdf->Cell(26,5,"$rsp30","0",0,"R");
$pdf->Cell(26,5,"$rm30","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r31","0",0,"R");$pdf->Cell(27,9,"$rpc31","0",0,"R");$pdf->Cell(26,9,"$rsp31","0",0,"R");
$pdf->Cell(26,9,"$rm31","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r32","0",0,"R");$pdf->Cell(27,5,"$rpc32","0",0,"R");$pdf->Cell(26,5,"$rsp32","0",0,"R");
$pdf->Cell(26,5,"$rm32","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r33","0",0,"R");$pdf->Cell(27,9,"$rpc33","0",0,"R");$pdf->Cell(26,9,"$rsp33","0",0,"R");
$pdf->Cell(26,9,"$rm33","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r34","0",0,"R");$pdf->Cell(27,6,"$rpc34","0",0,"R");$pdf->Cell(26,6,"$rsp34","0",0,"R");
$pdf->Cell(26,6,"$rm34","0",1,"R");
$pdf->Cell(83,8," ","0",0,"R");$pdf->Cell(25,8,"$r35","0",0,"R");$pdf->Cell(27,8,"$rpc35","0",0,"R");$pdf->Cell(26,8,"$rsp35","0",0,"R");
$pdf->Cell(26,8,"$rm35","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r36","0",0,"R");$pdf->Cell(27,6,"$rpc36","0",0,"R");$pdf->Cell(26,6,"$rsp36","0",0,"R");
$pdf->Cell(26,6,"$rm36","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r37","0",0,"R");$pdf->Cell(27,6,"$rpc37","0",0,"R");$pdf->Cell(26,6,"$rsp37","0",0,"R");
$pdf->Cell(26,6,"$rm37","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r38","0",0,"R");$pdf->Cell(27,6,"$rpc38","0",0,"R");$pdf->Cell(26,6,"$rsp38","0",0,"R");
$pdf->Cell(26,6,"$rm38","0",1,"R");


//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Sety(11);$pdf->Cell(113,6," ","0",0,"R");
$pdf->Cell(5,6,"$A","0",0,"C");
$pdf->Cell(6,6,"$B","0",0,"C");$pdf->Cell(5,6,"$C","0",0,"C");
$pdf->Cell(5,6,"$D","0",0,"C");$pdf->Cell(5,6,"$E","0",0,"C");
$pdf->Cell(5,6,"$F","0",0,"C");$pdf->Cell(6,6,"$G","0",0,"C");
$pdf->Cell(6,6,"$H","0",0,"C");


//strana 3

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/vykazy_no2012/vysledovka_str3.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/vykazy_no2012/vysledovka_str3.jpg',8,10,191,277); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',10);




$pdf->Cell(190,31,"     ","0",1,"L");

$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r39","0",0,"R");$pdf->Cell(27,5,"$rpc39","0",0,"R");$pdf->Cell(26,5,"$rsp39","0",0,"R");
$pdf->Cell(26,5,"$rm39","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r40","0",0,"R");$pdf->Cell(27,5,"$rpc40","0",0,"R");$pdf->Cell(26,5,"$rsp40","0",0,"R");
$pdf->Cell(26,5,"$rm40","0",1,"R");
                  
                  
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r41","0",0,"R");$pdf->Cell(27,5,"$rpc41","0",0,"R");$pdf->Cell(26,5,"$rsp41","0",0,"R");
$pdf->Cell(26,5,"$rm41","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r42","0",0,"R");$pdf->Cell(27,5,"$rpc42","0",0,"R");$pdf->Cell(26,5,"$rsp42","0",0,"R");
$pdf->Cell(26,5,"$rm42","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r43","0",0,"R");$pdf->Cell(27,6,"$rpc43","0",0,"R");$pdf->Cell(26,6,"$rsp43","0",0,"R");
$pdf->Cell(26,6,"$rm43","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r44","0",0,"R");$pdf->Cell(27,5,"$rpc44","0",0,"R");$pdf->Cell(26,5,"$rsp44","0",0,"R");
$pdf->Cell(26,5,"$rm44","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r45","0",0,"R");$pdf->Cell(27,6,"$rpc45","0",0,"R");$pdf->Cell(26,6,"$rsp45","0",0,"R");
$pdf->Cell(26,6,"$rm45","0",1,"R");
$pdf->Cell(83,4," ","0",0,"R");$pdf->Cell(25,4,"$r46","0",0,"R");$pdf->Cell(27,4,"$rpc46","0",0,"R");$pdf->Cell(26,4,"$rsp46","0",0,"R");
$pdf->Cell(26,4,"$rm46","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r47","0",0,"R");$pdf->Cell(27,5,"$rpc47","0",0,"R");$pdf->Cell(26,5,"$rsp47","0",0,"R");
$pdf->Cell(26,5,"$rm47","0",1,"R");
$pdf->Cell(83,7," ","0",0,"R");$pdf->Cell(25,7,"$r48","0",0,"R");$pdf->Cell(27,7,"$rpc48","0",0,"R");$pdf->Cell(26,7,"$rsp48","0",0,"R");
$pdf->Cell(26,7,"$rm48","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r49","0",0,"R");$pdf->Cell(27,9,"$rpc49","0",0,"R");$pdf->Cell(26,9,"$rsp49","0",0,"R");
$pdf->Cell(26,9,"$rm49","0",1,"R");

$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r50","0",0,"R");$pdf->Cell(27,6,"$rpc50","0",0,"R");$pdf->Cell(26,6,"$rsp50","0",0,"R");
$pdf->Cell(26,6,"$rm50","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r51","0",0,"R");$pdf->Cell(27,5,"$rpc51","0",0,"R");$pdf->Cell(26,5,"$rsp51","0",0,"R");
$pdf->Cell(26,5,"$rm51","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,5,"$r52","0",0,"R");$pdf->Cell(27,5,"$rpc52","0",0,"R");$pdf->Cell(26,5,"$rsp52","0",0,"R");
$pdf->Cell(26,5,"$rm52","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r53","0",0,"R");$pdf->Cell(27,5,"$rpc53","0",0,"R");$pdf->Cell(26,5,"$rsp53","0",0,"R");
$pdf->Cell(26,5,"$rm53","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r54","0",0,"R");$pdf->Cell(27,6,"$rpc54","0",0,"R");$pdf->Cell(26,6,"$rsp54","0",0,"R");
$pdf->Cell(26,6,"$rm54","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r55","0",0,"R");$pdf->Cell(27,5,"$rpc55","0",0,"R");$pdf->Cell(26,5,"$rsp55","0",0,"R");
$pdf->Cell(26,5,"$rm55","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r56","0",0,"R");$pdf->Cell(27,5,"$rpc56","0",0,"R");$pdf->Cell(26,5,"$rsp56","0",0,"R");
$pdf->Cell(26,5,"$rm56","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r57","0",0,"R");$pdf->Cell(27,5,"$rpc57","0",0,"R");$pdf->Cell(26,5,"$rsp57","0",0,"R");
$pdf->Cell(26,5,"$rm57","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r58","0",0,"R");$pdf->Cell(27,5,"$rpc58","0",0,"R");$pdf->Cell(26,5,"$rsp58","0",0,"R");
$pdf->Cell(26,5,"$rm58","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r59","0",0,"R");$pdf->Cell(27,9,"$rpc59","0",0,"R");$pdf->Cell(26,9,"$rsp59","0",0,"R");
$pdf->Cell(26,9,"$rm59","0",1,"R");

$pdf->Cell(83,7," ","0",0,"R");$pdf->Cell(25,7,"$r60","0",0,"R");$pdf->Cell(27,7,"$rpc60","0",0,"R");$pdf->Cell(26,7,"$rsp60","0",0,"R");
$pdf->Cell(26,7,"$rm60","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r61","0",0,"R");$pdf->Cell(27,9,"$rpc61","0",0,"R");$pdf->Cell(26,9,"$rsp61","0",0,"R");
$pdf->Cell(26,9,"$rm61","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r62","0",0,"R");$pdf->Cell(27,6,"$rpc62","0",0,"R");$pdf->Cell(26,6,"$rsp62","0",0,"R");
$pdf->Cell(26,6,"$rm62","0",1,"R");
$pdf->Cell(83,8," ","0",0,"R");$pdf->Cell(25,8,"$r63","0",0,"R");$pdf->Cell(27,8,"$rpc63","0",0,"R");$pdf->Cell(26,8,"$rsp63","0",0,"R");
$pdf->Cell(26,8,"$rm63","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r64","0",0,"R");$pdf->Cell(27,5,"$rpc64","0",0,"R");$pdf->Cell(26,5,"$rsp64","0",0,"R");
$pdf->Cell(26,5,"$rm64","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r65","0",0,"R");$pdf->Cell(27,5,"$rpc65","0",0,"R");$pdf->Cell(26,5,"$rsp65","0",0,"R");
$pdf->Cell(26,5,"$rm65","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r66","0",0,"R");$pdf->Cell(27,5,"$rpc66","0",0,"R");$pdf->Cell(26,5,"$rsp66","0",0,"R");
$pdf->Cell(26,5,"$rm66","0",1,"R");
$pdf->Cell(83,7," ","0",0,"R");$pdf->Cell(25,7,"$r67","0",0,"R");$pdf->Cell(27,7,"$rpc67","0",0,"R");$pdf->Cell(26,7,"$rsp67","0",0,"R");
$pdf->Cell(26,7,"$rm67","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r68","0",0,"R");$pdf->Cell(27,6,"$rpc68","0",0,"R");$pdf->Cell(26,6,"$rsp68","0",0,"R");
$pdf->Cell(26,6,"$rm68","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r69","0",0,"R");$pdf->Cell(27,5,"$rpc69","0",0,"R");$pdf->Cell(26,5,"$rsp69","0",0,"R");
$pdf->Cell(26,5,"$rm69","0",1,"R");


$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r70","0",0,"R");$pdf->Cell(27,5,"$rpc70","0",0,"R");$pdf->Cell(26,5,"$rsp70","0",0,"R");
$pdf->Cell(26,5,"$rm70","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r71","0",0,"R");$pdf->Cell(27,5,"$rpc71","0",0,"R");$pdf->Cell(26,5,"$rsp71","0",0,"R");
$pdf->Cell(26,5,"$rm71","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r72","0",0,"R");$pdf->Cell(27,5,"$rpc72","0",0,"R");$pdf->Cell(26,5,"$rsp72","0",0,"R");
$pdf->Cell(26,5,"$rm72","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r73","0",0,"R");$pdf->Cell(27,5,"$rpc73","0",0,"R");$pdf->Cell(26,5,"$rsp73","0",0,"R");
$pdf->Cell(26,5,"$rm73","0",1,"R");
$pdf->Cell(83,6," ","0",0,"R");$pdf->Cell(25,6,"$r74","0",0,"R");$pdf->Cell(27,6,"$rpc74","0",0,"R");$pdf->Cell(26,6,"$rsp74","0",0,"R");
$pdf->Cell(26,6,"$rm74","0",1,"R");
$pdf->Cell(83,8," ","0",0,"R");$pdf->Cell(25,8,"$r75","0",0,"R");$pdf->Cell(27,8,"$rpc75","0",0,"R");$pdf->Cell(26,8,"$rsp75","0",0,"R");
$pdf->Cell(26,8,"$rm75","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r76","0",0,"R");$pdf->Cell(27,5,"$rpc76","0",0,"R");$pdf->Cell(26,5,"$rsp76","0",0,"R");
$pdf->Cell(26,5,"$rm76","0",1,"R");
$pdf->Cell(83,5," ","0",0,"R");$pdf->Cell(25,5,"$r77","0",0,"R");$pdf->Cell(27,5,"$rpc77","0",0,"R");$pdf->Cell(26,5,"$rsp77","0",0,"R");
$pdf->Cell(26,5,"$rm77","0",1,"R");
$pdf->Cell(83,9," ","0",0,"R");$pdf->Cell(25,9,"$r78","0",0,"R");$pdf->Cell(27,9,"$rpc78","0",0,"R");$pdf->Cell(26,9,"$rsp78","0",0,"R");
$pdf->Cell(26,9,"$rm78","0",1,"R");


//ico
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Sety(11);$pdf->Cell(114,6," ","0",0,"R");
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




$pdf->Output("../tmp/vykzis.$kli_uzid.pdf");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykziss'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykzis'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvyk1000ziss'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

?> 

<script type="text/javascript">
  var okno = window.open("../tmp/vykzis.<?php echo $kli_uzid; ?>.pdf","_self");
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
