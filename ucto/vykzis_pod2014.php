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


$sql = "SELECT * FROM F$kli_vxcf"."_crv_pod2014";
$vysledok = mysql_query("$sql");
if ($vysledok)
          {
$polx = mysql_num_rows($vysledok);
$sql = "DROP TABLE F$kli_vxcf"."_crv_pod2014";
if( $polx < 4 ) { $vysledok = mysql_query("$sql"); }
          }

//zostava mesacna
if( $copern == 10 )
{
//nastav crs podla uce ale nie z uctosnova ako pri podnikatelskych ale z crv_pod2014.csv v adresary /import
$sql = "DROP TABLE F$kli_vxcf"."_crv_pod2014";
//$vysledok = mysql_query("$sql");

//Tabulka crv_pod2014
$sql = "SELECT * FROM F$kli_vxcf"."_crv_pod2014";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {
echo "Vytvorit tabulku F$kli_vxcf"."_crv_pod2014!"."<br />";

$sqlt = <<<crv_pod2014
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
crv_pod2014;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_crv_pod2014'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/crv_pod$kli_vrok.csv", "r");
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
$sqult = "INSERT INTO F$kli_vxcf"."_crv_pod2014 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
          }
//koniec tabulky crv_pod2014

//nacitaj riadky z crv_pod2014
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid,F$kli_vxcf"."_crv_pod2014".
" SET rdk=F$kli_vxcf"."_crv_pod2014.crs".
" WHERE LEFT(F$kli_vxcf"."_prcvykziss$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_crv_pod2014.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid,F$kli_vxcf"."_crv_pod2014".
" SET rdk=F$kli_vxcf"."_crv_pod2014.crs".
" WHERE LEFT(F$kli_vxcf"."_prcvykziss$kli_uzid.uce,5) = LEFT(F$kli_vxcf"."_crv_pod2014.uce,5) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid,F$kli_vxcf"."_crv_pod2014".
" SET rdk=F$kli_vxcf"."_crv_pod2014.crs".
" WHERE LEFT(F$kli_vxcf"."_prcvykziss$kli_uzid.uce,6) = LEFT(F$kli_vxcf"."_crv_pod2014.uce,6) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcvykzisneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcvykzisneg".$kli_uzid." SELECT * FROM F".$kli_vxcf."_prcvykziss".$kli_uzid." WHERE rdk = 0 ";
$oznac = mysql_query("$sqtoz");

//rozdel do riadkov
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r01=dal-mdt WHERE rdk = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r02=dal-mdt WHERE rdk = 2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r03=dal-mdt WHERE rdk = 3 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r04=dal-mdt WHERE rdk = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r05=dal-mdt WHERE rdk = 5 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r06=dal-mdt WHERE rdk = 6 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r07=dal-mdt WHERE rdk = 7 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r08=dal-mdt WHERE rdk = 8 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r09=dal-mdt WHERE rdk = 9 ";
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

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r27=dal-mdt WHERE rdk = 27 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r28=dal-mdt WHERE rdk = 28 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r29=dal-mdt WHERE rdk = 29 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r30=dal-mdt WHERE rdk = 30 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r31=dal-mdt WHERE rdk = 31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r32=dal-mdt WHERE rdk = 32 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r33=dal-mdt WHERE rdk = 33 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r34=dal-mdt WHERE rdk = 34 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r35=dal-mdt WHERE rdk = 35 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r36=dal-mdt WHERE rdk = 36 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r37=dal-mdt WHERE rdk = 37 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r38=dal-mdt WHERE rdk = 38 ";
$oznac = mysql_query("$sqtoz");
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

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r45=mdt-dal WHERE rdk = 45 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r46=mdt-dal WHERE rdk = 46 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r47=mdt-dal WHERE rdk = 47 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r48=mdt-dal WHERE rdk = 48 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r49=mdt-dal WHERE rdk = 49 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r50=mdt-dal WHERE rdk = 50 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r51=mdt-dal WHERE rdk = 51 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r52=mdt-dal WHERE rdk = 52 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r53=mdt-dal WHERE rdk = 53 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r54=mdt-dal WHERE rdk = 54 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r55=dal-mdt WHERE rdk = 55 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r56=dal-mdt WHERE rdk = 56 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r57=mdt-dal WHERE rdk = 57 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r58=mdt-dal WHERE rdk = 58 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r59=mdt-dal WHERE rdk = 59 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r60=mdt-dal WHERE rdk = 60 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykziss$kli_uzid SET r61=dal-mdt WHERE rdk = 61 ";
$oznac = mysql_query("$sqtoz");

$rob=0;
if( $rob == 1 )
  {
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
   }


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
"r57=r58+r59, ".
"r49=r50+r51, ".
"r45=r46+r47+r48+r49+r52+r53+r54, ".
"r39=r40+r51, ".
"r29=r30+r31+r35+r39+r42+r43+r44, ".
"r21=r22+r23, ".
"r15=r16+r17+r18+r19, ".
"r10=r11+r12+r13+r14+r15+r20+r21+r24+r25+r26, ".
"r02=r03+r04+r05+r06+r07+r08+r09 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r27=r02+r10, ".
"r28=r03+r04+r045+r06+r07-r11-r12-r13-r14, ".
"r55=r29-r45 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocitaj spolu
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r56=r27+r55, ".
"r61=r56-r57-r60 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");


//rozdiel po zaokruhleni
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctparzaok_pod2014 ");
  if (!$sqldok)
  {

$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
uctmzd;

$sql = "CREATE TABLE F".$kli_vxcf."_uctparzaok_pod2014 ".$sqlt;
$ulozene = mysql_query("$sql");

$sql = "INSERT INTO F".$kli_vxcf."_uctparzaok_pod2014 (uce, crs) VALUE ('35', '26') ";
$ulozene = mysql_query("$sql");
  }


if( $tis > 0 )
{
$zisk_suvaha=0;
$zisk_vzisk=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid."");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  //echo "idem";
  $riaddok=mysql_fetch_object($sqldok);
  $zisk_suvaha=$riaddok->rn100;
  }
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_prcvyk1000ziss".$kli_uzid."");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  //echo "idem";
  $riaddok=mysql_fetch_object($sqldok);
  $zisk_vzisk=$riaddok->rsp61;
  }
$zisk_rozd=$zisk_vzisk-$zisk_suvaha;
//echo $zisk_rozd."=".$zisk_vzisk."-".$zisk_suvaha;

$cislo_rdk=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_uctparzaok_pod2014 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cislo_rdk=1*$riaddok->crs;
  }
if( $cislo_rdk < 10 ) $cislo_rdk="0".$cislo_rdk;
//echo $cislo_rdk;
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_prcvyk1000ziss$kli_uzid SET ".
"r".$cislo_rdk."=r".$cislo_rdk."+".$zisk_rozd."  ".
" WHERE prx = 1 ";
//echo $sqtoz;
if( $cislo_rdk > 0 ) { $oznac = mysql_query("$sqtoz"); }
//exit;

//vypocitaj znovu riadky
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r57=r58+r59, ".
"r49=r50+r51, ".
"r45=r46+r47+r48+r49+r52+r53+r54, ".
"r39=r40+r51, ".
"r29=r30+r31+r35+r39+r42+r43+r44, ".
"r21=r22+r23, ".
"r15=r16+r17+r18+r19, ".
"r10=r11+r12+r13+r14+r15+r20+r21+r24+r25+r26, ".
"r02=r03+r04+r05+r06+r07+r08+r09 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r27=r02+r10, ".
"r28=r03+r04+r045+r06+r07-r11-r12-r13-r14, ".
"r55=r29-r45 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vypocitaj spolu
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r56=r27+r55, ".
"r61=r56-r57-r60 ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//echo " ".$fir_uctx06;
//echo " ".$zisk_suvaha;
//echo " ".$zisk_vzisk;
//echo " ".$zisk_rozd;
}
//koniec rozdiel po zaokruhleni



//vypis negenerovane pohyby
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcvykzisneg$kli_uzid WHERE LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 AND LEFT(uce,1) != 8 AND LEFT(uce,1) != 9 ";
$oznac = mysql_query("$sqtoz");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykzisneg$kli_uzid WHERE rdk = 0 GROUP BY uce ";

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

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcvykzisneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");
exit;
          }
//koniec vypis negenerovane pohyby


//uzavierka pod 2014
$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 1 )
  {
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
?>
<script type="text/javascript">

window.open('../ucto/uzavierka_pod2014.php?copern=10&drupoh=1&tis=<?php echo $tis; ?>&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=1&lenvzs=<?php echo $lenvzs; ?>&lensuv=<?php echo $lensuv; ?>', '_self' )


</script>
<?php
exit;
  }


//uzavierka pod 2014
$kompletka = 1*$_REQUEST['kompletka'];
if( $kompletka == 0 )
  {
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$h_drp = $_REQUEST['h_drp'];
?>
<script type="text/javascript">

window.open('../ucto/uzavierka_pod2014.php?copern=10&drupoh=1&tis=<?php echo $tis; ?>&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&h_drp=<?php echo $h_drp; ?>&page=1&kompletka=0&lenvzs=<?php echo $lenvzs; ?>&lensuv=<?php echo $lensuv; ?>', '_self' )


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
