<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

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

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$lenvzs = 1*$_REQUEST['lenvzs'];
$lensuv = 1*$_REQUEST['lensuv'];

$cislo_oc = 1*$_REQUEST['cislo_oc'];
if( $cislo_oc == 0 ) $cislo_oc=1;
if( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; $kli_pume="1.".$kli_vrok; }
if( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; $kli_pume="4.".$kli_vrok; }
if( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; $kli_pume="7.".$kli_vrok; }
if( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; $kli_pume="10.".$kli_vrok; }


$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if ( File_Exists("../tmp/vykfin.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/vykfin.$kli_uzid.pdf"); }

$kompletka = 1*$_REQUEST['kompletka'];
if ( $kompletka == 0 )
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
if ( $copern == 10 )
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykfins6a04'.$kli_uzid;
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

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcvykfins6a04'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");



//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid"." SELECT".
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

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid"." SELECT".
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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid"." SELECT".
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

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid"." SELECT".
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

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid"." SELECT".
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

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid"." SELECT".
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


$sql = "SELECT * FROM F$kli_vxcf"."_crv_fin6a04";
$vysledok = mysql_query("$sql");
if ($vysledok)
          {
$polx = mysql_num_rows($vysledok);
$sql = "DROP TABLE F$kli_vxcf"."_crv_fin6a04";
if( $polx < 4 ) { $vysledok = mysql_query("$sql"); }
          }

//zostava mesacna
if( $copern == 10 )
{
$sql = "DROP TABLE F$kli_vxcf"."_crv_fin6a04";
//$vysledok = mysql_query("$sql");

$sql = "SELECT * FROM F$kli_vxcf"."_crv_fin6a04";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {
echo "Vytvorit tabulku F$kli_vxcf"."_crv_fin6a04!"."<br />";

$sqlt = <<<crv_fin2014
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         DECIMAL(10,0),
   PRIMARY KEY(cpl)
);
crv_fin2014;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_crv_fin6a04'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/crv_fin6a04_$kli_vrok.csv", "r");
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
$sqult = "INSERT INTO F$kli_vxcf"."_crv_fin6a04 ( uce,crs )".
" VALUES ( '$x_uce', '$x_crs' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
          }
//koniec tabulky 

//nacitaj riadky 
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid,F$kli_vxcf"."_crv_fin6a04".
" SET rdk=F$kli_vxcf"."_crv_fin6a04.crs".
" WHERE LEFT(F$kli_vxcf"."_prcvykfins6a04$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_crv_fin6a04.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid,F$kli_vxcf"."_crv_fin6a04".
" SET rdk=F$kli_vxcf"."_crv_fin6a04.crs".
" WHERE LEFT(F$kli_vxcf"."_prcvykfins6a04$kli_uzid.uce,5) = LEFT(F$kli_vxcf"."_crv_fin6a04.uce,5) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid,F$kli_vxcf"."_crv_fin6a04".
" SET rdk=F$kli_vxcf"."_crv_fin6a04.crs".
" WHERE LEFT(F$kli_vxcf"."_prcvykfins6a04$kli_uzid.uce,6) = LEFT(F$kli_vxcf"."_crv_fin6a04.uce,6) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcvykfinneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "CREATE TABLE F$kli_vxcf"."_prcvykfinneg".$kli_uzid." SELECT * FROM F".$kli_vxcf."_prcvykfins6a04".$kli_uzid." WHERE rdk >= 0 ";
$oznac = mysql_query("$sqtoz");


//rozdel do riadkov
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r01=dal-mdt WHERE rdk = 1 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r02=dal-mdt WHERE rdk = 2 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r03=mdt-dal WHERE rdk = 3 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r04=dal-mdt WHERE rdk = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r05=dal-mdt WHERE rdk = 5 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r06=mdt-dal WHERE rdk = 6 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r07=mdt-dal WHERE rdk = 7 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r08=mdt-dal WHERE rdk = 8 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r09=mdt-dal WHERE rdk = 9 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r10=mdt-dal WHERE rdk = 10 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r11=mdt-dal WHERE rdk = 11 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r12=mdt-dal WHERE rdk = 12 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r13=mdt-dal WHERE rdk = 13 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r14=mdt-dal WHERE rdk = 14 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r15=mdt-dal WHERE rdk = 15 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r16=mdt-dal WHERE rdk = 16 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r17=mdt-dal WHERE rdk = 17 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r18=mdt-dal WHERE rdk = 18 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r19=mdt-dal WHERE rdk = 19 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r20=dal-mdt WHERE rdk = 20 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r21=mdt-dal WHERE rdk = 21 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r22=mdt-dal WHERE rdk = 22 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r23=dal-mdt WHERE rdk = 23 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r24=dal-mdt WHERE rdk = 24 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r25=dal-mdt WHERE rdk = 25 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r26=dal-mdt WHERE rdk = 26 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r27=mdt-dal WHERE rdk = 27 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r28=dal-mdt WHERE rdk = 28 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r29=dal-mdt WHERE rdk = 29 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r30=mdt-dal WHERE rdk = 30 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r31=dal-mdt WHERE rdk = 31 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r32=mdt-dal WHERE rdk = 32 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r33=dal-mdt WHERE rdk = 33 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r34=mdt-dal WHERE rdk = 34 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r35=dal-mdt WHERE rdk = 35 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r36=mdt-dal WHERE rdk = 36 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET r37=mdt-dal WHERE rdk = 37 ";
$oznac = mysql_query("$sqtoz");


//potom odstran str,zak
$sqtoz = "UPDATE F$kli_vxcf"."_prcvykfins6a04$kli_uzid SET konx1=0 ";
$oznac = mysql_query("$sqtoz");
$sql = "ALTER TABLE F$kli_vxcf"."_prcvykfins6a04$kli_uzid DROP str";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_prcvykfins6a04$kli_uzid DROP zak";
$vysledek = mysql_query("$sql");


//sumar za riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcvykfins6a04$kli_uzid "." SELECT".
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
" FROM F$kli_vxcf"."_prcvykfins6a04$kli_uzid".
" WHERE rdk > 0".
" GROUP BY prx".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//vypocitaj riadky
$vsldat="prcvykziss";
if( $tis > 0 ) { $vsldat="prcvyk1000ziss"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r11=r12+r13, ".
"r17=r18+r19  ".
" WHERE prx = 1 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"rpc11=rpc12+rpc13, ".
"rpc17=rpc18+rpc19 ".
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



//vypis negenerovane pohyby este neviem ci budu generovane vsetky
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcvykfinneg$kli_uzid WHERE LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 AND LEFT(uce,1) != 8 AND LEFT(uce,1) != 9 ";
$oznac = mysql_query("$sqtoz");


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykfinneg$kli_uzid  WHERE ( rdk = 0 OR rdk = 11 OR rdk = 17 ) ".
" GROUP BY uce ";
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

$sqtoz = "DROP TABLE F$kli_vxcf"."_prcvykfinneg$kli_uzid ";
$oznac = mysql_query("$sqtoz");
exit;
          }
//koniec vypis negenerovane pohyby

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcvykfins6a04$kli_uzid WHERE prx != 1 ";
$oznac = mysql_query("$sqtoz");

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcvykfins6a04".$kli_uzid." WHERE prx = 1 ";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

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

$rm01=""; $rm02=""; $rm03=""; $rm04=""; $rm05=""; $rm06=""; $rm07=""; $rm08=""; $rm09=""; $rm10=""; 
$rm11=""; $rm12=""; $rm13=""; $rm14=""; $rm15=""; $rm16=""; $rm17=""; $rm18=""; $rm19=""; $rm20="";
$rm21=""; $rm22=""; $rm23=""; $rm24=""; $rm25=""; $rm26=""; $rm27=""; $rm28=""; $rm29=""; $rm30="";
$rm31=""; $rm32=""; $rm33=""; $rm34=""; $rm35=""; $rm36=""; $rm37=""; $rm38="";

$sqlttpv = "SELECT * FROM F$kli_vxcf"."_pov_fin6a04 WHERE dok > 0 ORDER BY dok "; 
$sqlpv = mysql_query("$sqlttpv");
if($sqlpv) { $polpv = mysql_num_rows($sqlpv); }

$ipv=0;
  while ($ipv <= $polpv )
  {
  if (@$zaznam=mysql_data_seek($sqlpv,$ipv))
{
$hlavickpv=mysql_fetch_object($sqlpv);

$riadok=1*$hlavickpv->dok;

if ( $riadok ==  1 ) { $rm01=1*$hlavickpv->hod; }
if ( $riadok ==  2 ) { $rm02=1*$hlavickpv->hod; }
if ( $riadok ==  3 ) { $rm03=1*$hlavickpv->hod; }
if ( $riadok ==  4 ) { $rm04=1*$hlavickpv->hod; }
if ( $riadok ==  5 ) { $rm05=1*$hlavickpv->hod; }
if ( $riadok ==  6 ) { $rm06=1*$hlavickpv->hod; }
if ( $riadok ==  7 ) { $rm07=1*$hlavickpv->hod; }
if ( $riadok ==  8 ) { $rm08=1*$hlavickpv->hod; }
if ( $riadok ==  9 ) { $rm09=1*$hlavickpv->hod; }
if ( $riadok == 10 ) { $rm10=1*$hlavickpv->hod; }
if ( $riadok == 11 ) { $rm11=1*$hlavickpv->hod; }
if ( $riadok == 12 ) { $rm12=1*$hlavickpv->hod; }
if ( $riadok == 13 ) { $rm13=1*$hlavickpv->hod; }
if ( $riadok == 14 ) { $rm14=1*$hlavickpv->hod; }
if ( $riadok == 15 ) { $rm15=1*$hlavickpv->hod; }
if ( $riadok == 16 ) { $rm16=1*$hlavickpv->hod; }
if ( $riadok == 17 ) { $rm17=1*$hlavickpv->hod; }
if ( $riadok == 18 ) { $rm18=1*$hlavickpv->hod; }
if ( $riadok == 19 ) { $rm19=1*$hlavickpv->hod; }
if ( $riadok == 20 ) { $rm20=1*$hlavickpv->hod; }
if ( $riadok == 21 ) { $rm21=1*$hlavickpv->hod; }
if ( $riadok == 22 ) { $rm22=1*$hlavickpv->hod; }
if ( $riadok == 23 ) { $rm23=1*$hlavickpv->hod; }
if ( $riadok == 24 ) { $rm24=1*$hlavickpv->hod; }
if ( $riadok == 25 ) { $rm25=1*$hlavickpv->hod; }
if ( $riadok == 26 ) { $rm26=1*$hlavickpv->hod; }
if ( $riadok == 27 ) { $rm27=1*$hlavickpv->hod; }
if ( $riadok == 28 ) { $rm28=1*$hlavickpv->hod; }
if ( $riadok == 29 ) { $rm29=1*$hlavickpv->hod; }
if ( $riadok == 30 ) { $rm30=1*$hlavickpv->hod; }
if ( $riadok == 31 ) { $rm31=1*$hlavickpv->hod; }
if ( $riadok == 32 ) { $rm32=1*$hlavickpv->hod; }
if ( $riadok == 33 ) { $rm33=1*$hlavickpv->hod; }
if ( $riadok == 34 ) { $rm34=1*$hlavickpv->hod; }
if ( $riadok == 35 ) { $rm35=1*$hlavickpv->hod; }
if ( $riadok == 36 ) { $rm36=1*$hlavickpv->hod; }
if ( $riadok == 37 ) { $rm37=1*$hlavickpv->hod; }
if ( $riadok == 38 ) { $rm38=1*$hlavickpv->hod; }
}
$ipv = $ipv + 1;
  }

//strana 1
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',10);
if ( File_Exists('../dokumenty/vykazy_nujfin2014/fin6a04/fin6a04_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_nujfin2014/fin6a04/fin6a04_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//obdobie k
//dopyt, rozbeha
$pdf->Cell(195,67," ","$rmc1",1,"L");
$text=$datum;
//$textx="14.01.2010";
$t01=substr($text,0,1);
$pdf->Cell(83,6," ","$rmc1",0,"R");$pdf->Cell(34,6,"$text","$rmc",1,"C");

//ico
$pdf->Cell(195,19," ","$rmc1",1,"L");
$text=$fir_fico;
$textx="12345678";
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(20,5," ","$rmc1",0,"R");
$pdf->Cell(5,4,"$t01","$rmc",0,"C");$pdf->Cell(5,4,"$t02","$rmc",0,"C");$pdf->Cell(5,4,"$t03","$rmc",0,"C");
$pdf->Cell(5,4,"$t04","$rmc",0,"C");$pdf->Cell(5,4,"$t05","$rmc",0,"C");$pdf->Cell(5,4,"$t06","$rmc",0,"C");
$pdf->Cell(5,4,"$t07","$rmc",0,"C");$pdf->Cell(5,4,"$t08","$rmc",0,"C");

//mesiac
//dopyt, rozbeha
$text=$mesiac;
//$text="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,4,"$t01","$rmc",0,"C");$pdf->Cell(5,4,"$t02","$rmc",0,"C");

//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(6,5," ","$rmc1",0,"C");
$pdf->Cell(7,4,"$t01","$rmc",0,"C");$pdf->Cell(7,4,"$t02","$rmc",0,"C");$pdf->Cell(6,4,"$t03","$rmc",0,"C");$pdf->Cell(5,4,"$t04","$rmc",0,"C");


$nasielvyplnene=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204nuj WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $nasielvyplnene=1;

  $riaddok=mysql_fetch_object($sqldok);
  $xokres=1*$riaddok->okres;
  $xobec=1*$riaddok->obec;
  }

//kód okresu
//dopyt, rozbeha
$text=$xokres;
$textx="123";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,4,"$t01","$rmc",0,"C");$pdf->Cell(4,4,"$t02","$rmc",0,"C");$pdf->Cell(6,4,"$t03","$rmc",0,"C");

//kód obce
//dopyt, rozbeha
$text=$xobec;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$pdf->Cell(19,5," ","$rmc1",0,"C");
$pdf->Cell(5,4,"$t01","$rmc",0,"C");$pdf->Cell(5,4,"$t02","$rmc",0,"C");$pdf->Cell(5,4,"$t03","$rmc",0,"C");
$pdf->Cell(5,4,"$t04","$rmc",0,"C");$pdf->Cell(5,4,"$t05","$rmc",0,"C");$pdf->Cell(5,4,"$t06","$rmc",1,"C");

//Nazov
$pdf->Cell(195,14," ","$rmc1",1,"L");
$text=$fir_fnaz;
$textx="0123456789abcdefghijklmnoprstuv";
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
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(4,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$pdf->Cell(195,0," ","$rmc1",1,"L");
$text=substr($fir_fnaz,31,30);;
$textx="0123456789abcdefghijklmnoprstuv";
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
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(4,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//pravna forma
$pdf->Cell(195,8," ","$rmc1",1,"L");
$text=$fir_uctt02;
$textx="0123456789abcdefghijklmnoprstuv";
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
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6,"$t05","$rmc",0,"C");$pdf->Cell(5,6,"$t06","$rmc",0,"C");$pdf->Cell(5,6,"$t07","$rmc",0,"C");$pdf->Cell(5,6,"$t08","$rmc",0,"C");
$pdf->Cell(5,6,"$t09","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");$pdf->Cell(5,6,"$t11","$rmc",0,"C");$pdf->Cell(6,6,"$t12","$rmc",0,"C");
$pdf->Cell(7,6,"$t13","$rmc",0,"C");$pdf->Cell(7,6,"$t14","$rmc",0,"C");$pdf->Cell(6,6,"$t15","$rmc",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(5,6,"$t17","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");$pdf->Cell(5,6,"$t19","$rmc",0,"C");$pdf->Cell(5,6,"$t20","$rmc",0,"C");
$pdf->Cell(5,6,"$t21","$rmc",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");$pdf->Cell(5,6,"$t23","$rmc",0,"C");$pdf->Cell(5,6,"$t24","$rmc",0,"C");
$pdf->Cell(5,6,"$t25","$rmc",0,"C");$pdf->Cell(5,6,"$t26","$rmc",0,"C");$pdf->Cell(5,6,"$t27","$rmc",0,"C");$pdf->Cell(5,6,"$t28","$rmc",0,"C");
$pdf->Cell(5,6,"$t29","$rmc",0,"C");$pdf->Cell(5,6,"$t30","$rmc",0,"C");$pdf->Cell(5,6,"$t31","$rmc",1,"C");

//ulica a cislo
$pdf->Cell(195,13," ","$rmc1",1,"L");
$text=$fir_fuli." ".$fir_fcdm;
$textx="0123456789abcdefghijklmnoprstuv";
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
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(4,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//psc
$pdf->Cell(195,8," ","$rmc1",1,"L");
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");
$pdf->Cell(5,6,"$t04","$rmc",0,"C");$pdf->Cell(5,6,"$t05","$rmc",0,"C");

//obec
$text=$fir_fmes;
$textx="123456789abcdefghijklmnov";
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
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");$pdf->Cell(5,6,"$t03","$rmc",0,"C");$pdf->Cell(5,6,"$t04","$rmc",0,"C");
$pdf->Cell(5,6,"$t05","$rmc",0,"C");$pdf->Cell(6,6,"$t06","$rmc",0,"C");$pdf->Cell(7,6,"$t07","$rmc",0,"C");$pdf->Cell(7,6,"$t08","$rmc",0,"C");
$pdf->Cell(6,6,"$t09","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(6,6,"$t12","$rmc",0,"C");
$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(6,6,"$t14","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(5,6,"$t17","$rmc",0,"C");$pdf->Cell(5,6,"$t18","$rmc",0,"C");$pdf->Cell(5,6,"$t19","$rmc",0,"C");$pdf->Cell(5,6,"$t20","$rmc",0,"C");
$pdf->Cell(5,6,"$t21","$rmc",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");$pdf->Cell(5,6,"$t23","$rmc",0,"C");$pdf->Cell(5,6,"$t24","$rmc",0,"C");
$pdf->Cell(5,6,"$t25","$rmc",1,"C");

//telefon smerove
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pole = explode("/", $fir_ftel);
$tel_pred=$pole[0];
$tel_za=$pole[1];
$text=$tel_pred;
$textx="01234567";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");

//telefon cislo
$text=$tel_za;
$textx="0123456789";
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
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(7,5,"$t04","$rmc",0,"C");
$pdf->Cell(7,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(4,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(4,5,"$t10","$rmc",0,"C");

//fax
$pole = explode("/", $fir_ffax);
$tel_pred=$pole[0];
$tel_za=$pole[1];
$text=$tel_za;
$textx="01234567";
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
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",1,"C");

//email
$pdf->Cell(195,9," ","$rmc1",1,"L");
$text=$fir_fem1;
$textx="0123456789abcdefghijklmnoprstuv";
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
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(4,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//koniec strana1

//strana 2
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$pdf->SetFont('arial','',10);
if ( File_Exists('../dokumenty/vykazy_nujfin2014/fin6a04/fin6a04_str2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_nujfin2014/fin6a04/fin6a04_str2.jpg',0,0,210,297);
}
$pdf->SetY(10);

$pdf->Cell(190,24," ","$rmc1",1,"L");
//skutocnost k
//dopyt, rozbeha
$pdf->SetFont('arial','',8);
$text=$datum;
$pdf->Cell(117,6," ","$rmc1",0,"R");$pdf->Cell(31,4,"$text","$rmc",1,"C");
$pdf->SetFont('arial','',10);

//riadky
$pdf->Cell(190,16," ","$rmc1",1,"L");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r01","$rmc",0,"R");$pdf->Cell(35,4,"$rm01","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r02","$rmc",0,"R");$pdf->Cell(35,5,"$rm02","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r03","$rmc",0,"R");$pdf->Cell(35,5,"$rm03","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r04","$rmc",0,"R");$pdf->Cell(35,4,"$rm04","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r05","$rmc",0,"R");$pdf->Cell(35,5,"$rm05","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r06","$rmc",0,"R");$pdf->Cell(35,5,"$rm06","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r07","$rmc",0,"R");$pdf->Cell(35,4,"$rm07","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r08","$rmc",0,"R");$pdf->Cell(35,5,"$rm08","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r09","$rmc",0,"R");$pdf->Cell(35,5,"$rm09","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r10","$rmc",0,"R");$pdf->Cell(35,5,"$rm10","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r11","$rmc",0,"R");$pdf->Cell(35,4,"$rm11","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r12","$rmc",0,"R");$pdf->Cell(35,5,"$rm12","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r13","$rmc",0,"R");$pdf->Cell(35,5,"$rm13","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r14","$rmc",0,"R");$pdf->Cell(35,4,"$rm14","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r15","$rmc",0,"R");$pdf->Cell(35,5,"$rm15","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r16","$rmc",0,"R");$pdf->Cell(35,5,"$rm16","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r17","$rmc",0,"R");$pdf->Cell(35,4,"$rm17","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r18","$rmc",0,"R");$pdf->Cell(35,5,"$rm18","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r19","$rmc",0,"R");$pdf->Cell(35,5,"$rm19","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,8,"$r20","$rmc",0,"R");$pdf->Cell(35,8,"$rm20","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,8,"$r21","$rmc",0,"R");$pdf->Cell(35,8,"$rm21","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,8,"$r22","$rmc",0,"R");$pdf->Cell(35,8,"$rm22","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r23","$rmc",0,"R");$pdf->Cell(35,5,"$rm23","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r24","$rmc",0,"R");$pdf->Cell(35,5,"$rm24","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r25","$rmc",0,"R");$pdf->Cell(35,5,"$rm25","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r26","$rmc",0,"R");$pdf->Cell(35,4,"$rm26","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r27","$rmc",0,"R");$pdf->Cell(35,5,"$rm27","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r28","$rmc",0,"R");$pdf->Cell(35,5,"$rm28","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r29","$rmc",0,"R");$pdf->Cell(35,4,"$rm29","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r30","$rmc",0,"R");$pdf->Cell(35,5,"$rm30","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r31","$rmc",0,"R");$pdf->Cell(35,4,"$rm31","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r32","$rmc",0,"R");$pdf->Cell(35,5,"$rm32","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r33","$rmc",0,"R");$pdf->Cell(35,5,"$rm33","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r34","$rmc",0,"R");$pdf->Cell(35,4,"$rm34","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r35","$rmc",0,"R");$pdf->Cell(35,5,"$rm35","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,5,"$r36","$rmc",0,"R");$pdf->Cell(35,5,"$rm36","$rmc",1,"R");
$pdf->Cell(115,6," ","$rmc1",0,"R");$pdf->Cell(35,4,"$r37","$rmc",0,"R");$pdf->Cell(35,4,"$rm37","$rmc",1,"R");

}
$i = $i + 1;
  }
//koniec tlac


$pdf->Output("../tmp/vykfin.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykfins6a04'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");



?> 

<script type="text/javascript">
  var okno = window.open("../tmp/vykfin.<?php echo $kli_uzid; ?>.pdf","_self");
</script>

<?php

//koniec if( $copern == 10 )
}



?> 
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>VykazFIN 6a04 PDF</title>
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
