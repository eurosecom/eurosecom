<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 1000;
$analyzy = 1*$_REQUEST['analyzy']; 
if( $analyzy == 1 ) { $sys='ANA'; $urov=1000; }
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;

$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];
$xml = 1*$_REQUEST['xml'];

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

$vyb_ume = 1*$_REQUEST['vyb_ume'];


if( $kli_vrok < 2011 )
{
?>
<script type="text/javascript">
  var okno = window.open("../ucto/suvaha2010.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&analyzy=<?php echo $analyzy; ?>
&tis=<?php echo $tis; ?>&fort=<?php echo $fort; ?>&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>
&xml=<?php echo $xml; ?>&vyb_ume=<?php echo $vyb_ume; ?>&cstat=<?php echo $cstat; ?>","_self");
</script>
<?php
exit;
}


$suborxml = 1*$_REQUEST['suborxml'];
if( $xml == 1 AND $suborxml == 1 ) { ?>
<script type="text/javascript">
window.open('../ucto/suvaha_xml.php?copern=110&page=1&sysx=UCT&drupoh=1&uprav=1&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>', '_self' );
</script>
<?php 
exit;
                                         } 


//ramcek fpdf 1=zap,0=vyp
$rmc=0;

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
if (File_Exists ("../tmp/suvaha.$kli_uzid.pdf")) { $soubor = unlink("../tmp/suvaha.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

//350=sirka obdlznika 0 znamena do konca , 15=vyska obdlznika , $riadok-text , "1"=border ano 0 nie
//parameter druhy zlava 1=kurzor prejde na zaciatok riadku,0 kurzor pokracuje na riadku,2 kurzor ide nad riadok
//L=zarovnanie left alebo C=center R=right
//$pdf->Cell(350,15,"$riadok","$rmc",1,"L");
//$rest = substr("abcdef", 0, 4); // vrátí "abcd"

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//pre zostavu vytvor pracovny subor prcsuvaha$kli_uzid aj pre import
if( $copern == 10 OR $copern == 11 )
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
   r119         DECIMAL(10,2),
   r120         DECIMAL(10,2),
   r121         DECIMAL(10,2),
   r122         DECIMAL(10,2),
   r123         DECIMAL(10,2),
   r124         DECIMAL(10,2),
   r125         DECIMAL(10,2),
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
   rk65          DECIMAL(10,2),
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
   rn65          DECIMAL(10,2),
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
   r119         DECIMAL(10,0),
   r120         DECIMAL(10,0),
   r121         DECIMAL(10,0),
   r122         DECIMAL(10,0),
   r123         DECIMAL(10,0),
   r124         DECIMAL(10,0),
   r125         DECIMAL(10,0),
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
   rk65          DECIMAL(10,0),
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
   rn65          DECIMAL(10,0),
   ico          INT
);
prcsuvahas;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
}
//koniec prac subor


//pre zostavu vytvor pracovny subor prcsuvaha$kli_uzid pre import nie
if( $copern == 10 )
{

//zober pociatocny stav uctov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,uce,uce,0,0,0,0,pmd,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"$fir_fico FROM F$kli_vxcf"."_uctosnova".
" WHERE F$kli_vxcf"."_uctosnova.pmd != 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,uce,uce,0,0,0,0,0,pda,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
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
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucm > 0 AND ume <= $vyb_ume GROUP BY ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(F$kli_vxcf"."_$uctovanie.hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ucd > 0 AND ume <= $vyb_ume GROUP BY ucd";
$dsql = mysql_query("$dsqlt");

}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucm,ucm,0,0,0,0,SUM(hod),0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ucm > 0 AND ume <= $vyb_ume GROUP BY ucm";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,ucd,0,ucd,0,0,0,0,SUM(hod),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_$uctovanie".
" WHERE ucd > 0 AND ume <= $vyb_ume GROUP BY ucd";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }

//suma za ucet
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,9,uce,0,0,0,0,0,SUM(mdt),SUM(dal),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico FROM F$kli_vxcf"."_prcsuvahas$kli_uzid".
" WHERE prx = 0 GROUP BY uce";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcsuvahas$kli_uzid WHERE prx != 9 OR LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET prx=0";
$oznac = mysql_query("$sqtoz");


//uprava generovania suvahy2011 v uctosnova a minuleho obdobia preneseneho z 2010
$sql = "SELECT * FROM F$kli_vxcf"."_uctpocsuv2011 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
  {
//echo "idem";

if( $kli_vrok == 2011 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=dok WHERE dok >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=fak-1 WHERE dok >= 4 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=fak-1 WHERE dok >= 35 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=fak+1 WHERE dok > 41 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=fak+1 WHERE dok > 48 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=fak+1 WHERE dok > 95 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET fak=fak+1 WHERE dok > 106 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctpocsuvaha SET dok=fak WHERE dok >= 0 "; $oznac = mysql_query("$sqtoz");
  }

$sqlt = <<<uctcrv
(
   uce          VARCHAR(11),
   c01          INT
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocsuv2011'.$sqlt;
$vytvor = mysql_query("$vsql");

  }

$sql = "SELECT * FROM F$kli_vxcf"."_uctgensuv2011 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
  {
//echo "idem";

$poslhh = "SELECT * FROM F$kli_vxcf"."_uctosnova ".
" WHERE ( uce = 21100 OR uce = 22100 OR uce = 31100 OR uce = 32100 OR uce = 50100 OR uce = 50400 OR uce = 60100 OR uce = 60400 ) AND crv = 1 AND crs = 1 ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 AND $kli_vrok >= 2010 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=56  WHERE uce = 21100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=57  WHERE uce = 22100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=48  WHERE uce = 31100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0,  crs=106 WHERE uce = 32100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=9,  crs=0   WHERE uce = 50100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=2,  crs=0   WHERE uce = 50400 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=5,  crs=0   WHERE uce = 60100 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=1,  crs=0   WHERE uce = 60400 AND crv = 1 AND crs = 1 "; $oznac = mysql_query("$sqtoz");
}

if( $kli_vrok == 2011 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=crs, prm3=crs WHERE crs >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=prm4-1 WHERE crs >= 4 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=prm4-1 WHERE crs >= 35 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=prm4+1 WHERE crs > 41 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=prm4+1 WHERE crs > 48 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=prm4+1 WHERE crs > 95 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET prm4=prm4+1 WHERE crs > 106 "; $oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crs=prm4 WHERE crs >= 0 "; $oznac = mysql_query("$sqtoz");
  }

$sqlt = <<<uctcrv
(
   uce          VARCHAR(11),
   c01          INT
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctgensuv2011'.$sqlt;
$vytvor = mysql_query("$vsql");

  }


$sql = "SELECT * FROM F$kli_vxcf"."_uctgensuvaxp2011 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
  {
//echo "idem";

if( $kli_vrok == 2011 )
  {
//synteticke generovanie suvahy aktiva/pasiva
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=ucm  WHERE ucm >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak-1 WHERE ucm >= 4 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak-1 WHERE ucm >= 35 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucm > 41 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucm > 48 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucm > 95 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucm > 106 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET ucm=fak WHERE ucm >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=ucd  WHERE ucd >= 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak-1 WHERE ucd >= 4 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak-1 WHERE ucd >= 35 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucd > 41 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucd > 48 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucd > 95 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET fak=fak+1 WHERE ucd > 106 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctsyngensuv SET ucd=fak WHERE ucd >= 0 "; $oznac = mysql_query("$sqtoz");
  }

$sqlt = <<<uctcrv
(
   uce          VARCHAR(11),
   c01          INT
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctgensuvaxp2011'.$sqlt;
$vytvor = mysql_query("$vsql");

  }


//koniec uprava generovania suvahy2011 v uctosnova a minuleho obdobia preneseneho z 2010

//GERNEROVANIE nastav crs podla uce
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crs=0 WHERE ( LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 ) AND crs != 0 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_uctosnova SET crv=0 WHERE LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 AND crv != 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET rdk=F$kli_vxcf"."_uctosnova.crs".
" WHERE F$kli_vxcf"."_prcsuvahas$kli_uzid.uce = F$kli_vxcf"."_uctosnova.uce ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//pozri co mame synteticky(zmen cislo riadku) a podla zostatku ( zmen cislo riadku )
$sqltt = "SELECT * FROM F".$kli_vxcf."_uctsyngensuv WHERE dok != '' ";
$jesynt=0;
$pol=0;
$sql = mysql_query("$sqltt");
if( $sql ) { $pol = mysql_num_rows($sql); }
if( $pol > 0 ) {
//echo "mame synteticke";
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_uctsyngensuv".
" SET rdk=F$kli_vxcf"."_uctsyngensuv.ucm, uce=F$kli_vxcf"."_uctsyngensuv.dok ".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = F$kli_vxcf"."_uctsyngensuv.dok ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//ak aktiva je minus 

//suma za ucet znovu po upravach syntetiky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,9,uce,0,0,rdk,0,0,SUM(mdt),SUM(dal),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
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

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_uctsyngensuv".
" SET rdk=F$kli_vxcf"."_uctsyngensuv.ucd, F$kli_vxcf"."_prcsuvahas$kli_uzid.hod=-1*F$kli_vxcf"."_prcsuvahas$kli_uzid.hod  ".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = F$kli_vxcf"."_uctsyngensuv.dok ".
" AND F$kli_vxcf"."_prcsuvahas$kli_uzid.hod < 0  AND F$kli_vxcf"."_uctsyngensuv.ucd > 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;
               }
//koniec uprav pre synteticke generovanie

}
//koniec vytvorenia pracovneho suboru pre copern=10

//import z txt
if( $copern == 11 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcsuvahas$kli_uzid"." SELECT".
" 0,0,uct,0,uct,0,0,0,0,-(zmd),".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,".
"0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
" $fir_fico".
" FROM F$kli_vxcf"."_prcvykimport$kli_uzid".
" WHERE zmd != 0";
$dsql = mysql_query("$dsqlt");

//nastav crs podla uce analyticky
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET rdk=F$kli_vxcf"."_uctosnova.crs".
" WHERE LEFT(F$kli_vxcf"."_prcsuvahas$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_uctosnova.uce,3) ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$copern=10;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcvykimport'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
}
//koniec import

//kontrola na generovanie
$stojkaj=0;
if( ( $copern == 10 OR $copern == 11 ) AND $kli_vrok < 2099 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas$kli_uzid WHERE rdk = 0 AND LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 AND LEFT(uce,1) != 8 AND LEFT(uce,1) != 9 AND LEFT(uce,1) != 7  ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if( $pol > 0 ) {
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); echo "Nastavte èíslo riadka pre úèet ".$polozka->uce."<br />"; }
$i=$i+1;                   }
$stojkaj=1;
               }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas$kli_uzid WHERE ".
" ( rdk = 1 OR rdk = 2 OR rdk = 3 OR rdk = 11 OR rdk = 21 OR rdk = 30 OR rdk = 31 OR rdk = 38 OR rdk = 46 OR rdk = 55 OR rdk = 61 ".
" OR rdk = 66 OR rdk = 67 OR rdk = 68 OR rdk = 73 OR rdk = 80 OR rdk = 84 OR rdk = 87 OR rdk = 88 OR rdk = 89 OR rdk = 94 OR rdk = 106 OR rdk = 118 OR rdk = 121 ) ". 
" AND LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 AND LEFT(uce,1) != 8 AND LEFT(uce,1) != 9 AND LEFT(uce,1) != 7  ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if( $pol > 0 ) {
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); echo "Nemôžete nastavi sumárne èíslo riadka pre úèet ".$polozka->uce." napr. pre nehmotný majetok nie 3=sumárny riadok,súètový ale 4 až 10<br />"; }
$i=$i+1;                   }
$stojkaj=1;
               }


if( $stojkaj == 1 ) { exit; }
}
//exit;
//koniec kontrola na generovanie

//zostava mesacna
if( $copern == 10 )
{

//korekcia
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid".
" SET kor=1".
" WHERE LEFT(uce,3) = 071 OR LEFT(uce,3) = 072 OR LEFT(uce,3) = 073 OR LEFT(uce,3) = 074 OR LEFT(uce,3) = 075 OR LEFT(uce,3) = 076 OR LEFT(uce,3) = 079 ".
" OR LEFT(uce,3) = 078  ".
" OR LEFT(uce,3) = 081 OR LEFT(uce,3) = 082 OR LEFT(uce,3) = 083 OR LEFT(uce,3) = 084 OR LEFT(uce,3) = 085 OR LEFT(uce,3) = 086 ".
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
while ($rdk <= 125 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET r$crdk=mdt-dal WHERE rdk = $rdk AND kor = 0 ";
if( $rdk > 65 ) { $sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET r$crdk=dal-mdt WHERE rdk = $rdk "; }
$oznac = mysql_query("$sqtoz");

if( $rdk < 66 ) { 
$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET rk$crdk=dal-mdt WHERE rdk = $rdk AND kor = 1 ";
$oznac = mysql_query("$sqtoz");

//$sqtoz = "UPDATE F$kli_vxcf"."_prcsuvahas$kli_uzid SET rn$crdk=r$crdk-rk$crdk WHERE rdk > 0 ";
//$oznac = mysql_query("$sqtoz");

                }
$rdk=$rdk+1;
  }

//exit;

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
"SUM(r119),SUM(r120),SUM(r121),SUM(r122),SUM(r123),SUM(r124),SUM(r125),".
"SUM(rk01),SUM(rk02),SUM(rk03),SUM(rk04),SUM(rk05),SUM(rk06),SUM(rk07),SUM(rk08),SUM(rk09),SUM(rk10),".
"SUM(rk11),SUM(rk12),SUM(rk13),SUM(rk14),SUM(rk15),SUM(rk16),SUM(rk17),SUM(rk18),SUM(rk19),SUM(rk20),".
"SUM(rk21),SUM(rk22),SUM(rk23),SUM(rk24),SUM(rk25),SUM(rk26),SUM(rk27),SUM(rk28),SUM(rk29),SUM(rk30),".
"SUM(rk31),SUM(rk32),SUM(rk33),SUM(rk34),SUM(rk35),SUM(rk36),SUM(rk37),SUM(rk38),SUM(rk39),SUM(rk40),".
"SUM(rk41),SUM(rk42),SUM(rk43),SUM(rk44),SUM(rk45),SUM(rk46),SUM(rk47),SUM(rk48),SUM(rk49),SUM(rk50),".
"SUM(rk51),SUM(rk52),SUM(rk53),SUM(rk54),SUM(rk55),SUM(rk56),SUM(rk57),SUM(rk58),SUM(rk59),SUM(rk60),".
"SUM(rk61),SUM(rk62),SUM(rk63),SUM(rk64),SUM(rk65),".
"SUM(rn01),SUM(rn02),SUM(rn03),SUM(rn04),SUM(rn05),SUM(rn06),SUM(rn07),SUM(rn08),SUM(rn09),SUM(rn10),".
"SUM(rn11),SUM(rn12),SUM(rn13),SUM(rn14),SUM(rn15),SUM(rn16),SUM(rn17),SUM(rn18),SUM(rn19),SUM(rn20),".
"SUM(rn21),SUM(rn22),SUM(rn23),SUM(rn24),SUM(rn25),SUM(rn26),SUM(rn27),SUM(rn28),SUM(rn29),SUM(rn30),".
"SUM(rn31),SUM(rn32),SUM(rn33),SUM(rn34),SUM(rn35),SUM(rn36),SUM(rn37),SUM(rn38),SUM(rn39),SUM(rn40),".
"SUM(rn41),SUM(rn42),SUM(rn43),SUM(rn44),SUM(rn45),SUM(rn46),SUM(rn47),SUM(rn48),SUM(rn49),SUM(rn50),".
"SUM(rn51),SUM(rn52),SUM(rn53),SUM(rn54),SUM(rn55),SUM(rn56),SUM(rn57),SUM(rn58),SUM(rn59),SUM(rn60),".
"SUM(rn61),SUM(rn62),SUM(rn63),SUM(rn64),SUM(rn65),".
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
"rn61=r61-rk61, rn62=r62-rk62, rn63=r63-rk63, rn64=r64-rk64, rn65=r65-rk65 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

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
"r116=r116/1, r117=r117/1, r118=r118/1, r119=r119/1, r120=r120/1, r121=r121/1, r122=r122/1, r123=r123/1, r124=r124/1, r125=r125/1,".
"rk01=rk01/1, rk02=rk02/1, rk03=rk03/1, rk04=rk04/1, rk05=rk05/1, rk06=rk06/1, rk07=rk07/1, rk08=rk08/1, rk09=rk09/1, rk10=rk10/1,".
"rk11=rk11/1, rk12=rk12/1, rk13=rk13/1, rk14=rk14/1, rk15=rk15/1, rk16=rk16/1, rk17=rk17/1, rk18=rk18/1, rk19=rk19/1, rk20=rk20/1,".
"rk21=rk21/1, rk22=rk22/1, rk23=rk23/1, rk24=rk24/1, rk25=rk25/1, rk26=rk26/1, rk27=rk27/1, rk28=rk28/1, rk29=rk29/1, rk30=rk30/1,".
"rk31=rk31/1, rk32=rk32/1, rk33=rk33/1, rk34=rk34/1, rk35=rk35/1, rk36=rk36/1, rk37=rk37/1, rk38=rk38/1, rk39=rk39/1, rk40=rk40/1,".
"rk41=rk41/1, rk42=rk42/1, rk43=rk43/1, rk44=rk44/1, rk45=rk45/1, rk46=rk46/1, rk47=rk47/1, rk48=rk48/1, rk49=rk49/1,".
"rk50=rk50/1, rk51=rk51/1, rk52=rk52/1, rk53=rk53/1, rk54=rk54/1, rk55=rk55/1, rk56=rk56/1, rk57=rk57/1, rk58=rk58/1 , rk59=rk59/1,".
"rk60=rk60/1, rk61=rk61/1, rk62=rk62/1, rk63=rk63/1, rk64=rk64/1, rk65=rk65/1 ".
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
"r110,r111,r112,r113,r114,r115,r116,r117,r118,r119,r120,r121,r122,r123,r124,r125,".
"rk01,rk02,rk03,rk04,rk05,".
"rk06,rk07,rk08,rk09,rk10,rk11,rk12,rk13,rk14,rk15,".
"rk16,rk17,rk18,rk19,rk20,rk21,rk22,rk23,rk24,rk25,rk26,rk27,rk28,rk29,rk30,".
"rk31,rk32,rk33,rk34,rk35,rk36,rk37,rk38,rk39,rk40,".
"rk41,rk42,rk43,rk44,rk45,rk46,rk47,rk48,rk49,".
"rk50,rk51,rk52,rk53,rk54,rk55,rk56,rk57,rk58,rk59,".
"rk60,rk61,rk62,rk63,rk64,rk65,".
"rn01,rn02,rn03,rn04,rn05,".
"rn06,rn07,rn08,rn09,rn10,rn11,rn12,rn13,rn14,rn15,".
"rn16,rn17,rn18,rn19,rn20,rn21,rn22,rn23,rn24,rn25,rn26,rn27,rn28,rn29,rn30,".
"rn31,rn32,rn33,rn34,rn35,rn36,rn37,rn38,rn39,rn40,".
"rn41,rn42,rn43,rn44,rn45,rn46,rn47,rn48,rn49,".
"rn50,rn51,rn52,rn53,rn54,rn55,rn56,rn57,rn58,rn59,".
"rn60,rn61,rn62,rn63,rn64,rn65,".
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
"rn61=r61-rk61, rn62=r62-rk62, rn63=r63-rk63, rn64=r64-rk64, rn65=r65-rk65 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

}
//koniec ak 1000ky

//vypocitaj riadky strana 8
$vsldat="prcsuvahas";
if( $tis > 0 ) { $vsldat="prcsuv1000ahas"; }
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r121=r122+r123+r124+r125, ".
"r118=r119+r120, ".
"r106=r107+r108+r109+r110+r111+r112+r113+r114+r115+r116 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj riadky strana 7a6pasiva
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r94=r95+r96+r97+r98+r99+r100+r101+r102+r103+r104+r105, ".
"r89=r90+r91+r92+r93, ".
"r88=r89+r94+r106+r117+r118, ".
"r84=r85+r86, ".
"r80=r81+r82+r83, ".
"r73=r74+r75+r76+r77+r78+r79, ".
"r68=r69+r70+r71+r72 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj strana 2 az 6aktiva
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r61=r62+r63+r64+r65, rk61=rk62+rk63+rk64+rk65, rn61=rn62+rn63+rn64+rn65,".
"r55=r56+r57+r58+r59+r60, rk55=rk56+rk57+rk58+rk59+rk60, rn55=rn56+rn57+rn58+rn59+rn60, ".
"r46=r47+r48+r49+r50+r51+r52+r53+r54, rk46=rk47+rk48+rk49+rk50+rk51+rk52+rk53+rk54, rn46=rn47+rn48+rn49+rn50+rn51+rn52+rn53+rn54, ".
"r38=r39+r40+r41+r42+r43+r44+r45, rk38=rk39+rk40+rk41+rk42+rk43+rk44+rk45, rn38=rn39+rn40+rn41+rn42+rn43+rn44+rn45, ".
"r31=r32+r33+r34+r35+r36+r37, rk31=rk32+rk33+rk34+rk35+rk36+rk37, rn31=rn32+rn33+rn34+rn35+rn36+rn37, ".
"r30=r31+r38+r46+r55, rk30=rk31+rk38+rk46+rk55, rn30=rn31+rn38+rn46+rn55, ".
"r21=r22+r23+r24+r25+r26+r27+r28+r29, rk21=rk22+rk23+rk24+rk25+rk26+rk27+rk28+rk29, rn21=rn22+rn23+rn24+rn25+rn26+rn27+rn28+rn29, ".
"r11=r12+r13+r14+r15+r16+r17+r18+r19+r20, rk11=rk12+rk13+rk14+rk15+rk16+rk17+rk18+rk19+rk20, rn11=rn12+rn13+rn14+rn15+rn16+rn17+rn18+rn19+rn20,".
"r03=r04+r05+r06+r07+r08+r09+r10, rk03=rk04+rk05+rk06+rk07+rk08+rk09+rk10, rn03=rn04+rn05+rn06+rn07+rn08+rn09+rn10, ".
"r02=r03+r11+r21, rk02=rk03+rk11+rk21, rn02=rn03+rn11+rn21, ". 
"r01=r02+r30+r61, rk01=rk02+rk30+rk61, rn01=rn02+rn30+rn61 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//vypocitaj vysledok naposledy
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r87=rn01-(r68+r73+r80+r84+r88+r121), ".
"r67=r68+r73+r80+r84+r87, ".
"r66=r67+r88+r121 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

//ulozenie pre zaokruhlenie

$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsuvzaok';
if( $tis == 0 ) { $vytvor = mysql_query("$vsql"); }

$sqlt = <<<uctcrv
(
   datprvy      TIMESTAMP(14),
   hospcent     DECIMAL(10,2) DEFAULT 0,
   datcent      TIMESTAMP(14),
   cislcent     DECIMAL(10,0) DEFAULT 0,
   umecent      DECIMAL(10,4) DEFAULT 0,
   hospzaok     DECIMAL(10,2) DEFAULT 0,
   datzaok      TIMESTAMP(14),
   cislzaok     DECIMAL(10,0) DEFAULT 0,
   umezaok      DECIMAL(10,4) DEFAULT 0,
   hospeura     DECIMAL(10,0) DEFAULT 0,
   hosprozd     DECIMAL(10,2) DEFAULT 0,
   cislrozd     DECIMAL(10,0) DEFAULT 0,
   umerozd      DECIMAL(10,4) DEFAULT 0,
   cxx          INT DEFAULT 0
);
uctcrv;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctsuvzaok'.$sqlt;
$vytvor = mysql_query("$vsql");

if( $tis == 0 ) { 

$hospodarsky=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid." WHERE prx = 1 "; 
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hospodarsky=$riaddok->r87;
  } 

$ttvv = "INSERT INTO F$kli_vxcf"."_uctsuvzaok ( hospcent, datcent, umecent ) VALUES ( '$hospodarsky', now(), '$kli_vume' )";
$ttqq = mysql_query("$ttvv");
$sqltt = "UPDATE F$kli_vxcf"."_uctsuvzaok SET cislcent=UNIX_TIMESTAMP(datcent) ";
$sql = mysql_query("$sqltt");
                }

if( $tis > 0 )  { 

$hospodarskyz=0;
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid." WHERE prx = 1 "; 
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hospodarskyz=$riaddok->r87;
  }

$sqltt = "UPDATE F$kli_vxcf"."_uctsuvzaok SET hospzaok='$hospodarskyz', datzaok=now(), umezaok='$kli_vume' ";
$sql = mysql_query("$sqltt");
$sqltt = "UPDATE F$kli_vxcf"."_uctsuvzaok SET cislzaok=UNIX_TIMESTAMP(datzaok), hospeura=hospcent ";
$sql = mysql_query("$sqltt");

$sqltt = "UPDATE F$kli_vxcf"."_uctsuvzaok SET hosprozd=hospzaok-hospeura, cislrozd=cislzaok-cislcent, umerozd=umezaok-umecent, cxx=cxx+1 ";
$sql = mysql_query("$sqltt");
                }

//koniec ulozenie pre zaokruhlenie


//tuto blok na zaokruhlenie zaokruhlenej suvahy na suvahu v centoch
if( $tis > 0 AND $fir_uctx15 > 0 )
     {
$sqtoz = "SELECT * FROM F$kli_vxcf"."_uctsuvzaok "; $exis = mysql_query("$sqtoz");
if( $exis )
{
$hosprozd=0;
$umerozd=1;
$cislrozd=1000;
$sqltt = "SELECT * FROM F$kli_vxcf"."_uctsuvzaok "; 
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $hosprozd=1*$riaddok->hosprozd;
  $umerozd=1*$riaddok->umerozd;
  $cislrozd=1*$riaddok->cislrozd;
  $cxx=1*$riaddok->cxx;
  } 
if( $hosprozd != 0 AND $umerozd == 0 AND $cislrozd < 240 AND $cxx == 1 )
  {
//echo "zaokruhlujem";
//exit;

$cislo_rdk=1*$fir_uctx15;
if( $cislo_rdk < 10 ) $cislo_rdk="0".$cislo_rdk;
$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r".$cislo_rdk."=r".$cislo_rdk."-".$hosprozd.", ".
"rn".$cislo_rdk."=rn".$cislo_rdk."-".$hosprozd." ".
" WHERE prx = 1 ";
//echo $sqtoz;
if( $fir_uctx15 > 0 ) { $oznac = mysql_query("$sqtoz"); }

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r61=r62+r63+r64+r65, rk61=rk62+rk63+rk64+rk65, rn61=rn62+rn63+rn64+rn65,".
"r55=r56+r57+r58+r59+r60, rk55=rk56+rk57+rk58+rk59+rk60, rn55=rn56+rn57+rn58+rn59+rn60, ".
"r46=r47+r48+r49+r50+r51+r52+r53+r54, rk46=rk47+rk48+rk49+rk50+rk51+rk52+rk53+rk54, rn46=rn47+rn48+rn49+rn50+rn51+rn52+rn53+rn54, ".
"r38=r39+r40+r41+r42+r43+r44+r45, rk38=rk39+rk40+rk41+rk42+rk43+rk44+rk45, rn38=rn39+rn40+rn41+rn42+rn43+rn44+rn45, ".
"r31=r32+r33+r34+r35+r36+r37, rk31=rk32+rk33+rk34+rk35+rk36+rk37, rn31=rn32+rn33+rn34+rn35+rn36+rn37, ".
"r30=r31+r38+r46+r55, rk30=rk31+rk38+rk46+rk55, rn30=rn31+rn38+rn46+rn55, ".
"r21=r22+r23+r24+r25+r26+r27+r28+r29, rk21=rk22+rk23+rk24+rk25+rk26+rk27+rk28+rk29, rn21=rn22+rn23+rn24+rn25+rn26+rn27+rn28+rn29, ".
"r11=r12+r13+r14+r15+r16+r17+r18+r19+r20, rk11=rk12+rk13+rk14+rk15+rk16+rk17+rk18+rk19+rk20, rn11=rn12+rn13+rn14+rn15+rn16+rn17+rn18+rn19+rn20,".
"r03=r04+r05+r06+r07+r08+r09+r10, rk03=rk04+rk05+rk06+rk07+rk08+rk09+rk10, rn03=rn04+rn05+rn06+rn07+rn08+rn09+rn10, ".
"r02=r03+r11+r21, rk02=rk03+rk11+rk21, rn02=rn03+rn11+rn21, ". 
"r01=r02+r30+r61, rk01=rk02+rk30+rk61, rn01=rn02+rn30+rn61 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_".$vsldat.$kli_uzid." SET ".
"r87=rn01-(r68+r73+r80+r84+r88+r121), ".
"r67=r68+r73+r80+r84+r87, ".
"r66=r67+r88+r121 ".
" WHERE prx = 1 ";
$oznac = mysql_query("$sqtoz");

  }
}
     }
//koniec blok na zaokruhlenie zaokruhlenej suvahy na suvahu v centoch


//zapis do statistickej TABLE a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 1304 )
{
$r11=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas$kli_uzid WHERE prx = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r11=$r11+$polozka->rn01; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p1304 SET ".
" mod545r11a2='$r11', ".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");  
?>
<script type="text/javascript">

window.open('../ucto/statistika_p1304.php?copern=101&drupoh=1&page=1&modul=1545', '_self' )

</script>
<?php
}

//zapis do statistickej TABLE a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 304 )
{
$r12=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas$kli_uzid WHERE prx = 1";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); $r12=$r12+$polozka->rn01; }
$i=$i+1;                   }


$uprtxt = "UPDATE F$kli_vxcf"."_statistika_p304 SET ".
" mod545r12a2='$r12', ".
" mod545r99a2=mod545r01a2+mod545r02a2+mod545r03a2+mod545r04a2+mod545r05a2+mod545r06a2+mod545r07a2+mod545r08a2+mod545r09a2+mod545r10a2+mod545r11a2+mod545r12a2".
" WHERE ico >= 0"; 
$upravene = mysql_query("$uprtxt");


$rok304="";
if( $kli_vrok < 2016 ) $rok304="_2015";
if( $kli_vrok < 2014 ) $rok304="_2013";
if( $kli_vrok < 2013 ) $rok304="_2012";
  
?>
<script type="text/javascript">

window.open('../ucto/statistika_p304<?php echo $rok304; ?>.php?copern=101&drupoh=1&page=1&modul=1545', '_self' )

</script>
<?php
}


//poc.stav
$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,2),
   rm01         DECIMAL(10,2),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocsuvaha_stl'.$sqlt;
$ulozene = mysql_query("$sql");

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpocsuvaha_stl1000';
$ulozene = mysql_query("$sql");
$sql = 'DROP TABLE F'.$kli_vxcf.'_uctpocsuvaha_stt';
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
   rm114         DECIMAL(10,0),
   rm115         DECIMAL(10,0),
   rm116         DECIMAL(10,0),
   rm117         DECIMAL(10,0),
   rm118         DECIMAL(10,0),
   rm119         DECIMAL(10,0),
   rm120         DECIMAL(10,0),
   rm121         DECIMAL(10,0),
   rm122         DECIMAL(10,0),
   rm123         DECIMAL(10,0),
   rm124         DECIMAL(10,0),
   rm125         DECIMAL(10,0),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpocsuvaha_stt'.$sqlt;
$ulozene = mysql_query("$sql");

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuvahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvaha_stl".
" ON F$kli_vxcf"."_prcsuvahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvaha_stl.fic".
" WHERE prx = 1 ".""; 

//exit;

if( $tis > 0 ) { 

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctpocsuvaha_stt SELECT ".
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
"rm101,rm102,rm103,rm104,rm105,rm106,rm107,rm108,rm109,rm110,".
"rm111,rm112,rm113,rm114,rm115,rm116,rm117,rm118,rm119,rm120,rm121,rm122,rm123,rm124,rm125,".
"fic".
" FROM F$kli_vxcf"."_uctpocsuvaha_stl".
"";

$dsql = mysql_query("$dsqlt");


//zapis do statistickej zostavy rocny r101
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../ucto/statistika_r101nacitaj.php?copern=1&drupoh=1&page=1&zsuva=1', '_self' )

</script>
<?php
exit;
}
//koniec zapis do statistickej zostavy rocny r101

//zapis do statistickej TABLE vts101 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 20201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_vts101.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky vts101

//zapis do statistickej TABLE zav101 a prepni do stat zostavy
$cstat = 1*$_REQUEST['cstat'];
if( $cstat == 30201 )
{
$modul = 1*$_REQUEST['modul'];
?>
<script type="text/javascript">

window.open('../ucto/statistika_zav101.php?copern=1&drupoh=1&page=1&modul=<?php echo $modul; ?>', '_self' )

</script>
<?php
exit;
}
//koniec statistiky zav101

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvaha_stt".
" ON F$kli_vxcf"."_prcsuv1000ahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvaha_stt.fic".
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


//toto rob len pri zmene suvahy
$zmena=0;
if( $zmena == 1 )
          {
if (File_Exists ("../tmp/vloz$kli_uzid.php")) { $soubor = unlink("../tmp/vloz$kli_uzid.php"); }
$soubor = fopen("../tmp/vloz$kli_uzid.php", "a+");

  $text = "<?php"."\r\n";
  fwrite($soubor, $text);

$rdk=1;
while ($rdk <= 123 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;

$text="\$r".$crdk."=\$hlavicka->r".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->r".$crdk." == 0 ) \$r".$crdk."='';"."\r\n";

$text=$text."\$rk".$crdk."=\$hlavicka->rk".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->rk".$crdk." == 0 ) \$rk".$crdk."='';"."\r\n";

$text=$text."\$rn".$crdk."=\$hlavicka->rn".$crdk.";"."\r\n";
$text=$text."if( \$hlavicka->rn".$crdk." == 0 ) \$rn".$crdk."='';"."\r\n";

fwrite($soubor, $text);

$rdk=$rdk+1;
  }

  $text = "?>"."\r\n";
  fwrite($soubor, $text);

  fclose($soubor);

include("../tmp/vloz$kli_uzid.php");
          }
//toto rob len pri zmene suvahy

$r01=$hlavicka->r01;
if( $hlavicka->r01 == 0 ) $r01='';
$rk01=$hlavicka->rk01;
if( $hlavicka->rk01 == 0 ) $rk01='';
$rn01=$hlavicka->rn01;
if( $hlavicka->rn01 == 0 ) $rn01='';
$r02=$hlavicka->r02;
if( $hlavicka->r02 == 0 ) $r02='';
$rk02=$hlavicka->rk02;
if( $hlavicka->rk02 == 0 ) $rk02='';
$rn02=$hlavicka->rn02;
if( $hlavicka->rn02 == 0 ) $rn02='';
$r03=$hlavicka->r03;
if( $hlavicka->r03 == 0 ) $r03='';
$rk03=$hlavicka->rk03;
if( $hlavicka->rk03 == 0 ) $rk03='';
$rn03=$hlavicka->rn03;
if( $hlavicka->rn03 == 0 ) $rn03='';
$r04=$hlavicka->r04;
if( $hlavicka->r04 == 0 ) $r04='';
$rk04=$hlavicka->rk04;
if( $hlavicka->rk04 == 0 ) $rk04='';
$rn04=$hlavicka->rn04;
if( $hlavicka->rn04 == 0 ) $rn04='';
$r05=$hlavicka->r05;
if( $hlavicka->r05 == 0 ) $r05='';
$rk05=$hlavicka->rk05;
if( $hlavicka->rk05 == 0 ) $rk05='';
$rn05=$hlavicka->rn05;
if( $hlavicka->rn05 == 0 ) $rn05='';
$r06=$hlavicka->r06;
if( $hlavicka->r06 == 0 ) $r06='';
$rk06=$hlavicka->rk06;
if( $hlavicka->rk06 == 0 ) $rk06='';
$rn06=$hlavicka->rn06;
if( $hlavicka->rn06 == 0 ) $rn06='';
$r07=$hlavicka->r07;
if( $hlavicka->r07 == 0 ) $r07='';
$rk07=$hlavicka->rk07;
if( $hlavicka->rk07 == 0 ) $rk07='';
$rn07=$hlavicka->rn07;
if( $hlavicka->rn07 == 0 ) $rn07='';
$r08=$hlavicka->r08;
if( $hlavicka->r08 == 0 ) $r08='';
$rk08=$hlavicka->rk08;
if( $hlavicka->rk08 == 0 ) $rk08='';
$rn08=$hlavicka->rn08;
if( $hlavicka->rn08 == 0 ) $rn08='';
$r09=$hlavicka->r09;
if( $hlavicka->r09 == 0 ) $r09='';
$rk09=$hlavicka->rk09;
if( $hlavicka->rk09 == 0 ) $rk09='';
$rn09=$hlavicka->rn09;
if( $hlavicka->rn09 == 0 ) $rn09='';
$r10=$hlavicka->r10;
if( $hlavicka->r10 == 0 ) $r10='';
$rk10=$hlavicka->rk10;
if( $hlavicka->rk10 == 0 ) $rk10='';
$rn10=$hlavicka->rn10;
if( $hlavicka->rn10 == 0 ) $rn10='';
$r11=$hlavicka->r11;
if( $hlavicka->r11 == 0 ) $r11='';
$rk11=$hlavicka->rk11;
if( $hlavicka->rk11 == 0 ) $rk11='';
$rn11=$hlavicka->rn11;
if( $hlavicka->rn11 == 0 ) $rn11='';
$r12=$hlavicka->r12;
if( $hlavicka->r12 == 0 ) $r12='';
$rk12=$hlavicka->rk12;
if( $hlavicka->rk12 == 0 ) $rk12='';
$rn12=$hlavicka->rn12;
if( $hlavicka->rn12 == 0 ) $rn12='';
$r13=$hlavicka->r13;
if( $hlavicka->r13 == 0 ) $r13='';
$rk13=$hlavicka->rk13;
if( $hlavicka->rk13 == 0 ) $rk13='';
$rn13=$hlavicka->rn13;
if( $hlavicka->rn13 == 0 ) $rn13='';
$r14=$hlavicka->r14;
if( $hlavicka->r14 == 0 ) $r14='';
$rk14=$hlavicka->rk14;
if( $hlavicka->rk14 == 0 ) $rk14='';
$rn14=$hlavicka->rn14;
if( $hlavicka->rn14 == 0 ) $rn14='';
$r15=$hlavicka->r15;
if( $hlavicka->r15 == 0 ) $r15='';
$rk15=$hlavicka->rk15;
if( $hlavicka->rk15 == 0 ) $rk15='';
$rn15=$hlavicka->rn15;
if( $hlavicka->rn15 == 0 ) $rn15='';
$r16=$hlavicka->r16;
if( $hlavicka->r16 == 0 ) $r16='';
$rk16=$hlavicka->rk16;
if( $hlavicka->rk16 == 0 ) $rk16='';
$rn16=$hlavicka->rn16;
if( $hlavicka->rn16 == 0 ) $rn16='';
$r17=$hlavicka->r17;
if( $hlavicka->r17 == 0 ) $r17='';
$rk17=$hlavicka->rk17;
if( $hlavicka->rk17 == 0 ) $rk17='';
$rn17=$hlavicka->rn17;
if( $hlavicka->rn17 == 0 ) $rn17='';
$r18=$hlavicka->r18;
if( $hlavicka->r18 == 0 ) $r18='';
$rk18=$hlavicka->rk18;
if( $hlavicka->rk18 == 0 ) $rk18='';
$rn18=$hlavicka->rn18;
if( $hlavicka->rn18 == 0 ) $rn18='';
$r19=$hlavicka->r19;
if( $hlavicka->r19 == 0 ) $r19='';
$rk19=$hlavicka->rk19;
if( $hlavicka->rk19 == 0 ) $rk19='';
$rn19=$hlavicka->rn19;
if( $hlavicka->rn19 == 0 ) $rn19='';
$r20=$hlavicka->r20;
if( $hlavicka->r20 == 0 ) $r20='';
$rk20=$hlavicka->rk20;
if( $hlavicka->rk20 == 0 ) $rk20='';
$rn20=$hlavicka->rn20;
if( $hlavicka->rn20 == 0 ) $rn20='';
$r21=$hlavicka->r21;
if( $hlavicka->r21 == 0 ) $r21='';
$rk21=$hlavicka->rk21;
if( $hlavicka->rk21 == 0 ) $rk21='';
$rn21=$hlavicka->rn21;
if( $hlavicka->rn21 == 0 ) $rn21='';
$r22=$hlavicka->r22;
if( $hlavicka->r22 == 0 ) $r22='';
$rk22=$hlavicka->rk22;
if( $hlavicka->rk22 == 0 ) $rk22='';
$rn22=$hlavicka->rn22;
if( $hlavicka->rn22 == 0 ) $rn22='';
$r23=$hlavicka->r23;
if( $hlavicka->r23 == 0 ) $r23='';
$rk23=$hlavicka->rk23;
if( $hlavicka->rk23 == 0 ) $rk23='';
$rn23=$hlavicka->rn23;
if( $hlavicka->rn23 == 0 ) $rn23='';
$r24=$hlavicka->r24;
if( $hlavicka->r24 == 0 ) $r24='';
$rk24=$hlavicka->rk24;
if( $hlavicka->rk24 == 0 ) $rk24='';
$rn24=$hlavicka->rn24;
if( $hlavicka->rn24 == 0 ) $rn24='';
$r25=$hlavicka->r25;
if( $hlavicka->r25 == 0 ) $r25='';
$rk25=$hlavicka->rk25;
if( $hlavicka->rk25 == 0 ) $rk25='';
$rn25=$hlavicka->rn25;
if( $hlavicka->rn25 == 0 ) $rn25='';
$r26=$hlavicka->r26;
if( $hlavicka->r26 == 0 ) $r26='';
$rk26=$hlavicka->rk26;
if( $hlavicka->rk26 == 0 ) $rk26='';
$rn26=$hlavicka->rn26;
if( $hlavicka->rn26 == 0 ) $rn26='';
$r27=$hlavicka->r27;
if( $hlavicka->r27 == 0 ) $r27='';
$rk27=$hlavicka->rk27;
if( $hlavicka->rk27 == 0 ) $rk27='';
$rn27=$hlavicka->rn27;
if( $hlavicka->rn27 == 0 ) $rn27='';
$r28=$hlavicka->r28;
if( $hlavicka->r28 == 0 ) $r28='';
$rk28=$hlavicka->rk28;
if( $hlavicka->rk28 == 0 ) $rk28='';
$rn28=$hlavicka->rn28;
if( $hlavicka->rn28 == 0 ) $rn28='';
$r29=$hlavicka->r29;
if( $hlavicka->r29 == 0 ) $r29='';
$rk29=$hlavicka->rk29;
if( $hlavicka->rk29 == 0 ) $rk29='';
$rn29=$hlavicka->rn29;
if( $hlavicka->rn29 == 0 ) $rn29='';
$r30=$hlavicka->r30;
if( $hlavicka->r30 == 0 ) $r30='';
$rk30=$hlavicka->rk30;
if( $hlavicka->rk30 == 0 ) $rk30='';
$rn30=$hlavicka->rn30;
if( $hlavicka->rn30 == 0 ) $rn30='';
$r31=$hlavicka->r31;
if( $hlavicka->r31 == 0 ) $r31='';
$rk31=$hlavicka->rk31;
if( $hlavicka->rk31 == 0 ) $rk31='';
$rn31=$hlavicka->rn31;
if( $hlavicka->rn31 == 0 ) $rn31='';
$r32=$hlavicka->r32;
if( $hlavicka->r32 == 0 ) $r32='';
$rk32=$hlavicka->rk32;
if( $hlavicka->rk32 == 0 ) $rk32='';
$rn32=$hlavicka->rn32;
if( $hlavicka->rn32 == 0 ) $rn32='';
$r33=$hlavicka->r33;
if( $hlavicka->r33 == 0 ) $r33='';
$rk33=$hlavicka->rk33;
if( $hlavicka->rk33 == 0 ) $rk33='';
$rn33=$hlavicka->rn33;
if( $hlavicka->rn33 == 0 ) $rn33='';
$r34=$hlavicka->r34;
if( $hlavicka->r34 == 0 ) $r34='';
$rk34=$hlavicka->rk34;
if( $hlavicka->rk34 == 0 ) $rk34='';
$rn34=$hlavicka->rn34;
if( $hlavicka->rn34 == 0 ) $rn34='';
$r35=$hlavicka->r35;
if( $hlavicka->r35 == 0 ) $r35='';
$rk35=$hlavicka->rk35;
if( $hlavicka->rk35 == 0 ) $rk35='';
$rn35=$hlavicka->rn35;
if( $hlavicka->rn35 == 0 ) $rn35='';
$r36=$hlavicka->r36;
if( $hlavicka->r36 == 0 ) $r36='';
$rk36=$hlavicka->rk36;
if( $hlavicka->rk36 == 0 ) $rk36='';
$rn36=$hlavicka->rn36;
if( $hlavicka->rn36 == 0 ) $rn36='';
$r37=$hlavicka->r37;
if( $hlavicka->r37 == 0 ) $r37='';
$rk37=$hlavicka->rk37;
if( $hlavicka->rk37 == 0 ) $rk37='';
$rn37=$hlavicka->rn37;
if( $hlavicka->rn37 == 0 ) $rn37='';
$r38=$hlavicka->r38;
if( $hlavicka->r38 == 0 ) $r38='';
$rk38=$hlavicka->rk38;
if( $hlavicka->rk38 == 0 ) $rk38='';
$rn38=$hlavicka->rn38;
if( $hlavicka->rn38 == 0 ) $rn38='';
$r39=$hlavicka->r39;
if( $hlavicka->r39 == 0 ) $r39='';
$rk39=$hlavicka->rk39;
if( $hlavicka->rk39 == 0 ) $rk39='';
$rn39=$hlavicka->rn39;
if( $hlavicka->rn39 == 0 ) $rn39='';
$r40=$hlavicka->r40;
if( $hlavicka->r40 == 0 ) $r40='';
$rk40=$hlavicka->rk40;
if( $hlavicka->rk40 == 0 ) $rk40='';
$rn40=$hlavicka->rn40;
if( $hlavicka->rn40 == 0 ) $rn40='';
$r41=$hlavicka->r41;
if( $hlavicka->r41 == 0 ) $r41='';
$rk41=$hlavicka->rk41;
if( $hlavicka->rk41 == 0 ) $rk41='';
$rn41=$hlavicka->rn41;
if( $hlavicka->rn41 == 0 ) $rn41='';
$r42=$hlavicka->r42;
if( $hlavicka->r42 == 0 ) $r42='';
$rk42=$hlavicka->rk42;
if( $hlavicka->rk42 == 0 ) $rk42='';
$rn42=$hlavicka->rn42;
if( $hlavicka->rn42 == 0 ) $rn42='';
$r43=$hlavicka->r43;
if( $hlavicka->r43 == 0 ) $r43='';
$rk43=$hlavicka->rk43;
if( $hlavicka->rk43 == 0 ) $rk43='';
$rn43=$hlavicka->rn43;
if( $hlavicka->rn43 == 0 ) $rn43='';
$r44=$hlavicka->r44;
if( $hlavicka->r44 == 0 ) $r44='';
$rk44=$hlavicka->rk44;
if( $hlavicka->rk44 == 0 ) $rk44='';
$rn44=$hlavicka->rn44;
if( $hlavicka->rn44 == 0 ) $rn44='';
$r45=$hlavicka->r45;
if( $hlavicka->r45 == 0 ) $r45='';
$rk45=$hlavicka->rk45;
if( $hlavicka->rk45 == 0 ) $rk45='';
$rn45=$hlavicka->rn45;
if( $hlavicka->rn45 == 0 ) $rn45='';
$r46=$hlavicka->r46;
if( $hlavicka->r46 == 0 ) $r46='';
$rk46=$hlavicka->rk46;
if( $hlavicka->rk46 == 0 ) $rk46='';
$rn46=$hlavicka->rn46;
if( $hlavicka->rn46 == 0 ) $rn46='';
$r47=$hlavicka->r47;
if( $hlavicka->r47 == 0 ) $r47='';
$rk47=$hlavicka->rk47;
if( $hlavicka->rk47 == 0 ) $rk47='';
$rn47=$hlavicka->rn47;
if( $hlavicka->rn47 == 0 ) $rn47='';
$r48=$hlavicka->r48;
if( $hlavicka->r48 == 0 ) $r48='';
$rk48=$hlavicka->rk48;
if( $hlavicka->rk48 == 0 ) $rk48='';
$rn48=$hlavicka->rn48;
if( $hlavicka->rn48 == 0 ) $rn48='';
$r49=$hlavicka->r49;
if( $hlavicka->r49 == 0 ) $r49='';
$rk49=$hlavicka->rk49;
if( $hlavicka->rk49 == 0 ) $rk49='';
$rn49=$hlavicka->rn49;
if( $hlavicka->rn49 == 0 ) $rn49='';
$r50=$hlavicka->r50;
if( $hlavicka->r50 == 0 ) $r50='';
$rk50=$hlavicka->rk50;
if( $hlavicka->rk50 == 0 ) $rk50='';
$rn50=$hlavicka->rn50;
if( $hlavicka->rn50 == 0 ) $rn50='';
$r51=$hlavicka->r51;
if( $hlavicka->r51 == 0 ) $r51='';
$rk51=$hlavicka->rk51;
if( $hlavicka->rk51 == 0 ) $rk51='';
$rn51=$hlavicka->rn51;
if( $hlavicka->rn51 == 0 ) $rn51='';
$r52=$hlavicka->r52;
if( $hlavicka->r52 == 0 ) $r52='';
$rk52=$hlavicka->rk52;
if( $hlavicka->rk52 == 0 ) $rk52='';
$rn52=$hlavicka->rn52;
if( $hlavicka->rn52 == 0 ) $rn52='';
$r53=$hlavicka->r53;
if( $hlavicka->r53 == 0 ) $r53='';
$rk53=$hlavicka->rk53;
if( $hlavicka->rk53 == 0 ) $rk53='';
$rn53=$hlavicka->rn53;
if( $hlavicka->rn53 == 0 ) $rn53='';
$r54=$hlavicka->r54;
if( $hlavicka->r54 == 0 ) $r54='';
$rk54=$hlavicka->rk54;
if( $hlavicka->rk54 == 0 ) $rk54='';
$rn54=$hlavicka->rn54;
if( $hlavicka->rn54 == 0 ) $rn54='';
$r55=$hlavicka->r55;
if( $hlavicka->r55 == 0 ) $r55='';
$rk55=$hlavicka->rk55;
if( $hlavicka->rk55 == 0 ) $rk55='';
$rn55=$hlavicka->rn55;
if( $hlavicka->rn55 == 0 ) $rn55='';
$r56=$hlavicka->r56;
if( $hlavicka->r56 == 0 ) $r56='';
$rk56=$hlavicka->rk56;
if( $hlavicka->rk56 == 0 ) $rk56='';
$rn56=$hlavicka->rn56;
if( $hlavicka->rn56 == 0 ) $rn56='';
$r57=$hlavicka->r57;
if( $hlavicka->r57 == 0 ) $r57='';
$rk57=$hlavicka->rk57;
if( $hlavicka->rk57 == 0 ) $rk57='';
$rn57=$hlavicka->rn57;
if( $hlavicka->rn57 == 0 ) $rn57='';
$r58=$hlavicka->r58;
if( $hlavicka->r58 == 0 ) $r58='';
$rk58=$hlavicka->rk58;
if( $hlavicka->rk58 == 0 ) $rk58='';
$rn58=$hlavicka->rn58;
if( $hlavicka->rn58 == 0 ) $rn58='';
$r59=$hlavicka->r59;
if( $hlavicka->r59 == 0 ) $r59='';
$rk59=$hlavicka->rk59;
if( $hlavicka->rk59 == 0 ) $rk59='';
$rn59=$hlavicka->rn59;
if( $hlavicka->rn59 == 0 ) $rn59='';
$r60=$hlavicka->r60;
if( $hlavicka->r60 == 0 ) $r60='';
$rk60=$hlavicka->rk60;
if( $hlavicka->rk60 == 0 ) $rk60='';
$rn60=$hlavicka->rn60;
if( $hlavicka->rn60 == 0 ) $rn60='';
$r61=$hlavicka->r61;
if( $hlavicka->r61 == 0 ) $r61='';
$rk61=$hlavicka->rk61;
if( $hlavicka->rk61 == 0 ) $rk61='';
$rn61=$hlavicka->rn61;
if( $hlavicka->rn61 == 0 ) $rn61='';
$r62=$hlavicka->r62;
if( $hlavicka->r62 == 0 ) $r62='';
$rk62=$hlavicka->rk62;
if( $hlavicka->rk62 == 0 ) $rk62='';
$rn62=$hlavicka->rn62;
if( $hlavicka->rn62 == 0 ) $rn62='';
$r63=$hlavicka->r63;
if( $hlavicka->r63 == 0 ) $r63='';
$rk63=$hlavicka->rk63;
if( $hlavicka->rk63 == 0 ) $rk63='';
$rn63=$hlavicka->rn63;
if( $hlavicka->rn63 == 0 ) $rn63='';
$r64=$hlavicka->r64;
if( $hlavicka->r64 == 0 ) $r64='';
$rk64=$hlavicka->rk64;
if( $hlavicka->rk64 == 0 ) $rk64='';
$rn64=$hlavicka->rn64;
if( $hlavicka->rn64 == 0 ) $rn64='';
$r65=$hlavicka->r65;
if( $hlavicka->r65 == 0 ) $r65='';
$rk65=$hlavicka->rk65;
if( $hlavicka->rk65 == 0 ) $rk65='';
$rn65=$hlavicka->rn65;
if( $hlavicka->rn65 == 0 ) $rn65='';
$r66=$hlavicka->r66;
if( $hlavicka->r66 == 0 ) $r66='';
$rk66=$hlavicka->rk66;
if( $hlavicka->rk66 == 0 ) $rk66='';
$rn66=$hlavicka->rn66;
if( $hlavicka->rn66 == 0 ) $rn66='';
$r67=$hlavicka->r67;
if( $hlavicka->r67 == 0 ) $r67='';
$rk67=$hlavicka->rk67;
if( $hlavicka->rk67 == 0 ) $rk67='';
$rn67=$hlavicka->rn67;
if( $hlavicka->rn67 == 0 ) $rn67='';
$r68=$hlavicka->r68;
if( $hlavicka->r68 == 0 ) $r68='';
$rk68=$hlavicka->rk68;
if( $hlavicka->rk68 == 0 ) $rk68='';
$rn68=$hlavicka->rn68;
if( $hlavicka->rn68 == 0 ) $rn68='';
$r69=$hlavicka->r69;
if( $hlavicka->r69 == 0 ) $r69='';
$rk69=$hlavicka->rk69;
if( $hlavicka->rk69 == 0 ) $rk69='';
$rn69=$hlavicka->rn69;
if( $hlavicka->rn69 == 0 ) $rn69='';
$r70=$hlavicka->r70;
if( $hlavicka->r70 == 0 ) $r70='';
$rk70=$hlavicka->rk70;
if( $hlavicka->rk70 == 0 ) $rk70='';
$rn70=$hlavicka->rn70;
if( $hlavicka->rn70 == 0 ) $rn70='';
$r71=$hlavicka->r71;
if( $hlavicka->r71 == 0 ) $r71='';
$rk71=$hlavicka->rk71;
if( $hlavicka->rk71 == 0 ) $rk71='';
$rn71=$hlavicka->rn71;
if( $hlavicka->rn71 == 0 ) $rn71='';
$r72=$hlavicka->r72;
if( $hlavicka->r72 == 0 ) $r72='';
$rk72=$hlavicka->rk72;
if( $hlavicka->rk72 == 0 ) $rk72='';
$rn72=$hlavicka->rn72;
if( $hlavicka->rn72 == 0 ) $rn72='';
$r73=$hlavicka->r73;
if( $hlavicka->r73 == 0 ) $r73='';
$rk73=$hlavicka->rk73;
if( $hlavicka->rk73 == 0 ) $rk73='';
$rn73=$hlavicka->rn73;
if( $hlavicka->rn73 == 0 ) $rn73='';
$r74=$hlavicka->r74;
if( $hlavicka->r74 == 0 ) $r74='';
$rk74=$hlavicka->rk74;
if( $hlavicka->rk74 == 0 ) $rk74='';
$rn74=$hlavicka->rn74;
if( $hlavicka->rn74 == 0 ) $rn74='';
$r75=$hlavicka->r75;
if( $hlavicka->r75 == 0 ) $r75='';
$rk75=$hlavicka->rk75;
if( $hlavicka->rk75 == 0 ) $rk75='';
$rn75=$hlavicka->rn75;
if( $hlavicka->rn75 == 0 ) $rn75='';
$r76=$hlavicka->r76;
if( $hlavicka->r76 == 0 ) $r76='';
$rk76=$hlavicka->rk76;
if( $hlavicka->rk76 == 0 ) $rk76='';
$rn76=$hlavicka->rn76;
if( $hlavicka->rn76 == 0 ) $rn76='';
$r77=$hlavicka->r77;
if( $hlavicka->r77 == 0 ) $r77='';
$rk77=$hlavicka->rk77;
if( $hlavicka->rk77 == 0 ) $rk77='';
$rn77=$hlavicka->rn77;
if( $hlavicka->rn77 == 0 ) $rn77='';
$r78=$hlavicka->r78;
if( $hlavicka->r78 == 0 ) $r78='';
$rk78=$hlavicka->rk78;
if( $hlavicka->rk78 == 0 ) $rk78='';
$rn78=$hlavicka->rn78;
if( $hlavicka->rn78 == 0 ) $rn78='';
$r79=$hlavicka->r79;
if( $hlavicka->r79 == 0 ) $r79='';
$rk79=$hlavicka->rk79;
if( $hlavicka->rk79 == 0 ) $rk79='';
$rn79=$hlavicka->rn79;
if( $hlavicka->rn79 == 0 ) $rn79='';
$r80=$hlavicka->r80;
if( $hlavicka->r80 == 0 ) $r80='';
$rk80=$hlavicka->rk80;
if( $hlavicka->rk80 == 0 ) $rk80='';
$rn80=$hlavicka->rn80;
if( $hlavicka->rn80 == 0 ) $rn80='';
$r81=$hlavicka->r81;
if( $hlavicka->r81 == 0 ) $r81='';
$rk81=$hlavicka->rk81;
if( $hlavicka->rk81 == 0 ) $rk81='';
$rn81=$hlavicka->rn81;
if( $hlavicka->rn81 == 0 ) $rn81='';
$r82=$hlavicka->r82;
if( $hlavicka->r82 == 0 ) $r82='';
$rk82=$hlavicka->rk82;
if( $hlavicka->rk82 == 0 ) $rk82='';
$rn82=$hlavicka->rn82;
if( $hlavicka->rn82 == 0 ) $rn82='';
$r83=$hlavicka->r83;
if( $hlavicka->r83 == 0 ) $r83='';
$rk83=$hlavicka->rk83;
if( $hlavicka->rk83 == 0 ) $rk83='';
$rn83=$hlavicka->rn83;
if( $hlavicka->rn83 == 0 ) $rn83='';
$r84=$hlavicka->r84;
if( $hlavicka->r84 == 0 ) $r84='';
$rk84=$hlavicka->rk84;
if( $hlavicka->rk84 == 0 ) $rk84='';
$rn84=$hlavicka->rn84;
if( $hlavicka->rn84 == 0 ) $rn84='';
$r85=$hlavicka->r85;
if( $hlavicka->r85 == 0 ) $r85='';
$rk85=$hlavicka->rk85;
if( $hlavicka->rk85 == 0 ) $rk85='';
$rn85=$hlavicka->rn85;
if( $hlavicka->rn85 == 0 ) $rn85='';
$r86=$hlavicka->r86;
if( $hlavicka->r86 == 0 ) $r86='';
$rk86=$hlavicka->rk86;
if( $hlavicka->rk86 == 0 ) $rk86='';
$rn86=$hlavicka->rn86;
if( $hlavicka->rn86 == 0 ) $rn86='';
$r87=$hlavicka->r87;
if( $hlavicka->r87 == 0 ) $r87='';
$rk87=$hlavicka->rk87;
if( $hlavicka->rk87 == 0 ) $rk87='';
$rn87=$hlavicka->rn87;
if( $hlavicka->rn87 == 0 ) $rn87='';
$r88=$hlavicka->r88;
if( $hlavicka->r88 == 0 ) $r88='';
$rk88=$hlavicka->rk88;
if( $hlavicka->rk88 == 0 ) $rk88='';
$rn88=$hlavicka->rn88;
if( $hlavicka->rn88 == 0 ) $rn88='';
$r89=$hlavicka->r89;
if( $hlavicka->r89 == 0 ) $r89='';
$rk89=$hlavicka->rk89;
if( $hlavicka->rk89 == 0 ) $rk89='';
$rn89=$hlavicka->rn89;
if( $hlavicka->rn89 == 0 ) $rn89='';
$r90=$hlavicka->r90;
if( $hlavicka->r90 == 0 ) $r90='';
$rk90=$hlavicka->rk90;
if( $hlavicka->rk90 == 0 ) $rk90='';
$rn90=$hlavicka->rn90;
if( $hlavicka->rn90 == 0 ) $rn90='';
$r91=$hlavicka->r91;
if( $hlavicka->r91 == 0 ) $r91='';
$rk91=$hlavicka->rk91;
if( $hlavicka->rk91 == 0 ) $rk91='';
$rn91=$hlavicka->rn91;
if( $hlavicka->rn91 == 0 ) $rn91='';
$r92=$hlavicka->r92;
if( $hlavicka->r92 == 0 ) $r92='';
$rk92=$hlavicka->rk92;
if( $hlavicka->rk92 == 0 ) $rk92='';
$rn92=$hlavicka->rn92;
if( $hlavicka->rn92 == 0 ) $rn92='';
$r93=$hlavicka->r93;
if( $hlavicka->r93 == 0 ) $r93='';
$rk93=$hlavicka->rk93;
if( $hlavicka->rk93 == 0 ) $rk93='';
$rn93=$hlavicka->rn93;
if( $hlavicka->rn93 == 0 ) $rn93='';
$r94=$hlavicka->r94;
if( $hlavicka->r94 == 0 ) $r94='';
$rk94=$hlavicka->rk94;
if( $hlavicka->rk94 == 0 ) $rk94='';
$rn94=$hlavicka->rn94;
if( $hlavicka->rn94 == 0 ) $rn94='';
$r95=$hlavicka->r95;
if( $hlavicka->r95 == 0 ) $r95='';
$rk95=$hlavicka->rk95;
if( $hlavicka->rk95 == 0 ) $rk95='';
$rn95=$hlavicka->rn95;
if( $hlavicka->rn95 == 0 ) $rn95='';
$r96=$hlavicka->r96;
if( $hlavicka->r96 == 0 ) $r96='';
$rk96=$hlavicka->rk96;
if( $hlavicka->rk96 == 0 ) $rk96='';
$rn96=$hlavicka->rn96;
if( $hlavicka->rn96 == 0 ) $rn96='';
$r97=$hlavicka->r97;
if( $hlavicka->r97 == 0 ) $r97='';
$rk97=$hlavicka->rk97;
if( $hlavicka->rk97 == 0 ) $rk97='';
$rn97=$hlavicka->rn97;
if( $hlavicka->rn97 == 0 ) $rn97='';
$r98=$hlavicka->r98;
if( $hlavicka->r98 == 0 ) $r98='';
$rk98=$hlavicka->rk98;
if( $hlavicka->rk98 == 0 ) $rk98='';
$rn98=$hlavicka->rn98;
if( $hlavicka->rn98 == 0 ) $rn98='';
$r99=$hlavicka->r99;
if( $hlavicka->r99 == 0 ) $r99='';
$rk99=$hlavicka->rk99;
if( $hlavicka->rk99 == 0 ) $rk99='';
$rn99=$hlavicka->rn99;
if( $hlavicka->rn99 == 0 ) $rn99='';
$r100=$hlavicka->r100;
if( $hlavicka->r100 == 0 ) $r100='';
$rk100=$hlavicka->rk100;
if( $hlavicka->rk100 == 0 ) $rk100='';
$rn100=$hlavicka->rn100;
if( $hlavicka->rn100 == 0 ) $rn100='';
$r101=$hlavicka->r101;
if( $hlavicka->r101 == 0 ) $r101='';
$rk101=$hlavicka->rk101;
if( $hlavicka->rk101 == 0 ) $rk101='';
$rn101=$hlavicka->rn101;
if( $hlavicka->rn101 == 0 ) $rn101='';
$r102=$hlavicka->r102;
if( $hlavicka->r102 == 0 ) $r102='';
$rk102=$hlavicka->rk102;
if( $hlavicka->rk102 == 0 ) $rk102='';
$rn102=$hlavicka->rn102;
if( $hlavicka->rn102 == 0 ) $rn102='';
$r103=$hlavicka->r103;
if( $hlavicka->r103 == 0 ) $r103='';
$rk103=$hlavicka->rk103;
if( $hlavicka->rk103 == 0 ) $rk103='';
$rn103=$hlavicka->rn103;
if( $hlavicka->rn103 == 0 ) $rn103='';
$r104=$hlavicka->r104;
if( $hlavicka->r104 == 0 ) $r104='';
$rk104=$hlavicka->rk104;
if( $hlavicka->rk104 == 0 ) $rk104='';
$rn104=$hlavicka->rn104;
if( $hlavicka->rn104 == 0 ) $rn104='';
$r105=$hlavicka->r105;
if( $hlavicka->r105 == 0 ) $r105='';
$rk105=$hlavicka->rk105;
if( $hlavicka->rk105 == 0 ) $rk105='';
$rn105=$hlavicka->rn105;
if( $hlavicka->rn105 == 0 ) $rn105='';
$r106=$hlavicka->r106;
if( $hlavicka->r106 == 0 ) $r106='';
$rk106=$hlavicka->rk106;
if( $hlavicka->rk106 == 0 ) $rk106='';
$rn106=$hlavicka->rn106;
if( $hlavicka->rn106 == 0 ) $rn106='';
$r107=$hlavicka->r107;
if( $hlavicka->r107 == 0 ) $r107='';
$rk107=$hlavicka->rk107;
if( $hlavicka->rk107 == 0 ) $rk107='';
$rn107=$hlavicka->rn107;
if( $hlavicka->rn107 == 0 ) $rn107='';
$r108=$hlavicka->r108;
if( $hlavicka->r108 == 0 ) $r108='';
$rk108=$hlavicka->rk108;
if( $hlavicka->rk108 == 0 ) $rk108='';
$rn108=$hlavicka->rn108;
if( $hlavicka->rn108 == 0 ) $rn108='';
$r109=$hlavicka->r109;
if( $hlavicka->r109 == 0 ) $r109='';
$rk109=$hlavicka->rk109;
if( $hlavicka->rk109 == 0 ) $rk109='';
$rn109=$hlavicka->rn109;
if( $hlavicka->rn109 == 0 ) $rn109='';
$r110=$hlavicka->r110;
if( $hlavicka->r110 == 0 ) $r110='';
$rk110=$hlavicka->rk110;
if( $hlavicka->rk110 == 0 ) $rk110='';
$rn110=$hlavicka->rn110;
if( $hlavicka->rn110 == 0 ) $rn110='';
$r111=$hlavicka->r111;
if( $hlavicka->r111 == 0 ) $r111='';
$rk111=$hlavicka->rk111;
if( $hlavicka->rk111 == 0 ) $rk111='';
$rn111=$hlavicka->rn111;
if( $hlavicka->rn111 == 0 ) $rn111='';
$r112=$hlavicka->r112;
if( $hlavicka->r112 == 0 ) $r112='';
$rk112=$hlavicka->rk112;
if( $hlavicka->rk112 == 0 ) $rk112='';
$rn112=$hlavicka->rn112;
if( $hlavicka->rn112 == 0 ) $rn112='';
$r113=$hlavicka->r113;
if( $hlavicka->r113 == 0 ) $r113='';
$rk113=$hlavicka->rk113;
if( $hlavicka->rk113 == 0 ) $rk113='';
$rn113=$hlavicka->rn113;
if( $hlavicka->rn113 == 0 ) $rn113='';
$r114=$hlavicka->r114;
if( $hlavicka->r114 == 0 ) $r114='';
$rk114=$hlavicka->rk114;
if( $hlavicka->rk114 == 0 ) $rk114='';
$rn114=$hlavicka->rn114;
if( $hlavicka->rn114 == 0 ) $rn114='';
$r115=$hlavicka->r115;
if( $hlavicka->r115 == 0 ) $r115='';
$rk115=$hlavicka->rk115;
if( $hlavicka->rk115 == 0 ) $rk115='';
$rn115=$hlavicka->rn115;
if( $hlavicka->rn115 == 0 ) $rn115='';
$r116=$hlavicka->r116;
if( $hlavicka->r116 == 0 ) $r116='';
$rk116=$hlavicka->rk116;
if( $hlavicka->rk116 == 0 ) $rk116='';
$rn116=$hlavicka->rn116;
if( $hlavicka->rn116 == 0 ) $rn116='';
$r117=$hlavicka->r117;
if( $hlavicka->r117 == 0 ) $r117='';
$rk117=$hlavicka->rk117;
if( $hlavicka->rk117 == 0 ) $rk117='';
$rn117=$hlavicka->rn117;
if( $hlavicka->rn117 == 0 ) $rn117='';
$r118=$hlavicka->r118;
if( $hlavicka->r118 == 0 ) $r118='';
$rk118=$hlavicka->rk118;
if( $hlavicka->rk118 == 0 ) $rk118='';
$rn118=$hlavicka->rn118;
if( $hlavicka->rn118 == 0 ) $rn118='';
$r119=$hlavicka->r119;
if( $hlavicka->r119 == 0 ) $r119='';
$rk119=$hlavicka->rk119;
if( $hlavicka->rk119 == 0 ) $rk119='';
$rn119=$hlavicka->rn119;
if( $hlavicka->rn119 == 0 ) $rn119='';
$r120=$hlavicka->r120;
if( $hlavicka->r120 == 0 ) $r120='';
$rk120=$hlavicka->rk120;
if( $hlavicka->rk120 == 0 ) $rk120='';
$rn120=$hlavicka->rn120;
if( $hlavicka->rn120 == 0 ) $rn120='';
$r121=$hlavicka->r121;
if( $hlavicka->r121 == 0 ) $r121='';
$rk121=$hlavicka->rk121;
if( $hlavicka->rk121 == 0 ) $rk121='';
$rn121=$hlavicka->rn121;
if( $hlavicka->rn121 == 0 ) $rn121='';
$r122=$hlavicka->r122;
if( $hlavicka->r122 == 0 ) $r122='';
$rk122=$hlavicka->rk122;
if( $hlavicka->rk122 == 0 ) $rk122='';
$rn122=$hlavicka->rn122;
if( $hlavicka->rn122 == 0 ) $rn122='';
$r123=$hlavicka->r123;
if( $hlavicka->r123 == 0 ) $r123='';
$rk123=$hlavicka->rk123;
if( $hlavicka->rk123 == 0 ) $rk123='';
$rn123=$hlavicka->rn123;
if( $hlavicka->rn123 == 0 ) $rn123='';

$r124=$hlavicka->r124;
if( $hlavicka->r124 == 0 ) $r124='';
$rk124=$hlavicka->rk124;
if( $hlavicka->rk124 == 0 ) $rk124='';
$rn124=$hlavicka->rn124;
if( $hlavicka->rn124 == 0 ) $rn124='';
$r125=$hlavicka->r125;
if( $hlavicka->r125 == 0 ) $r125='';
$rk125=$hlavicka->rk125;
if( $hlavicka->rk125 == 0 ) $rk125='';
$rn125=$hlavicka->rn125;
if( $hlavicka->rn125 == 0 ) $rn125='';

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
$rm79=$hlavicka->rm79;
if( $hlavicka->rm79 == 0 ) $rm79="";
$rm80=$hlavicka->rm80;
if( $hlavicka->rm80 == 0 ) $rm80="";
$rm81=$hlavicka->rm81;
if( $hlavicka->rm81 == 0 ) $rm81="";
$rm82=$hlavicka->rm82;
if( $hlavicka->rm82 == 0 ) $rm82="";
$rm83=$hlavicka->rm83;
if( $hlavicka->rm83 == 0 ) $rm83="";
$rm84=$hlavicka->rm84;
if( $hlavicka->rm84 == 0 ) $rm84="";
$rm85=$hlavicka->rm85;
if( $hlavicka->rm85 == 0 ) $rm85="";
$rm86=$hlavicka->rm86;
if( $hlavicka->rm86 == 0 ) $rm86="";
$rm87=$hlavicka->rm87;
if( $hlavicka->rm87 == 0 ) $rm87="";
$rm88=$hlavicka->rm88;
if( $hlavicka->rm88 == 0 ) $rm88="";
$rm89=$hlavicka->rm89;
if( $hlavicka->rm89 == 0 ) $rm89="";
$rm90=$hlavicka->rm90;
if( $hlavicka->rm90 == 0 ) $rm90="";
$rm91=$hlavicka->rm91;
if( $hlavicka->rm91 == 0 ) $rm91="";
$rm92=$hlavicka->rm92;
if( $hlavicka->rm92 == 0 ) $rm92="";
$rm93=$hlavicka->rm93;
if( $hlavicka->rm93 == 0 ) $rm93="";
$rm94=$hlavicka->rm94;
if( $hlavicka->rm94 == 0 ) $rm94="";
$rm95=$hlavicka->rm95;
if( $hlavicka->rm95 == 0 ) $rm95="";
$rm96=$hlavicka->rm96;
if( $hlavicka->rm96 == 0 ) $rm96="";
$rm97=$hlavicka->rm97;
if( $hlavicka->rm97 == 0 ) $rm97="";
$rm98=$hlavicka->rm98;
if( $hlavicka->rm98 == 0 ) $rm98="";
$rm99=$hlavicka->rm99;
if( $hlavicka->rm99 == 0 ) $rm99="";
$rm100=$hlavicka->rm100;
if( $hlavicka->rm100 == 0 ) $rm100="";
$rm101=$hlavicka->rm101;
if( $hlavicka->rm101 == 0 ) $rm101="";
$rm102=$hlavicka->rm102;
if( $hlavicka->rm102 == 0 ) $rm102="";
$rm103=$hlavicka->rm103;
if( $hlavicka->rm103 == 0 ) $rm103="";
$rm104=$hlavicka->rm104;
if( $hlavicka->rm104 == 0 ) $rm104="";
$rm105=$hlavicka->rm105;
if( $hlavicka->rm105 == 0 ) $rm105="";
$rm106=$hlavicka->rm106;
if( $hlavicka->rm106 == 0 ) $rm106="";
$rm107=$hlavicka->rm107;
if( $hlavicka->rm107 == 0 ) $rm107="";
$rm108=$hlavicka->rm108;
if( $hlavicka->rm108 == 0 ) $rm108="";
$rm109=$hlavicka->rm109;
if( $hlavicka->rm109 == 0 ) $rm109="";
$rm110=$hlavicka->rm110;
if( $hlavicka->rm110 == 0 ) $rm110="";
$rm111=$hlavicka->rm111;
if( $hlavicka->rm111 == 0 ) $rm111="";
$rm112=$hlavicka->rm112;
if( $hlavicka->rm112 == 0 ) $rm112="";
$rm113=$hlavicka->rm113;
if( $hlavicka->rm113 == 0 ) $rm113="";
$rm114=$hlavicka->rm114;
if( $hlavicka->rm114 == 0 ) $rm114="";
$rm115=$hlavicka->rm115;
if( $hlavicka->rm115 == 0 ) $rm115="";
$rm116=$hlavicka->rm116;
if( $hlavicka->rm116 == 0 ) $rm116="";
$rm117=$hlavicka->rm117;
if( $hlavicka->rm117 == 0 ) $rm117="";
$rm118=$hlavicka->rm118;
if( $hlavicka->rm118 == 0 ) $rm118="";
$rm119=$hlavicka->rm119;
if( $hlavicka->rm119 == 0 ) $rm119="";
$rm120=$hlavicka->rm120;
if( $hlavicka->rm120 == 0 ) $rm120="";
$rm121=$hlavicka->rm121;
if( $hlavicka->rm121 == 0 ) $rm121="";
$rm122=$hlavicka->rm122;
if( $hlavicka->rm122 == 0 ) $rm122="";
$rm123=$hlavicka->rm123;
if( $hlavicka->rm123 == 0 ) $rm123="";
$rm124=$hlavicka->rm124;
if( $hlavicka->rm124 == 0 ) $rm124="";
$rm125=$hlavicka->rm125;
if( $hlavicka->rm125 == 0 ) $rm125="";



//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-1.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-1.jpg',12,14,186,274); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);

$pdf->Cell(190,20,"     ","$rmc",1,"L");

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

if( $alchem == 1 AND $kli_vxcf == 526 AND $kli_vume == 9.2010 ) { $datk_sk="10.09.2010"; }



//uzavierka k z ufirdalsie
if( $kli_vrok >= 2013 )
          {

$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  if( $riadok->datk != '0000-00-00' )
    {
  $datk_sk=SkDatum($riadok->datk);
    }
  }
          }

$pole = explode(".", $datk_sk);
$denk_sk=$pole[0];
$mesk_sk=$pole[1];
$rokk_sk=$pole[2]-2000;
if( $rokk_sk < 10 ) $rokk_sk="0".$rokk_sk;

//uzavierka k datumu
$Adenk=substr($denk_sk,0,1);
$Bdenk=substr($denk_sk,1,1);
$Amesk=substr($mesk_sk,0,1);
$Bmesk=substr($mesk_sk,1,1);
$Arokk=substr($rokk_sk,0,1);
$Brokk=substr($rokk_sk,1,1);

$pdf->Cell(64,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$Adenk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bdenk","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Amesk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesk","$rmc",0,"C");

$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Arokk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokk","$rmc",1,"C");

//dic
$pdf->Cell(0,26," ","$rmc",1,"C");

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

$pdf->Cell(4,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",0,"C");

$pdf->Cell(0,5," ","$rmc",1,"C");


$pdf->Cell(63,3," ","$rmc",0,"C");$pdf->Cell(3,3," ","$rmc",1,"C");

//ico
$pdf->Cell(0,5," ","$rmc",1,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);


$pdf->Cell(4,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");

$pdf->Cell(0,5," ","$rmc",1,"C");

//sknace
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

$pdf->Cell(0,7," ","$rmc",1,"L");
$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(4,5,"$sn1a","$rmc",0,"L");$pdf->Cell(4,5,"$sn2a","$rmc",0,"L");
$pdf->Cell(3,5," ","$rmc",0,"L");$pdf->Cell(5,5,"$sn1b","$rmc",0,"L");$pdf->Cell(5,5,"$sn2b","$rmc",0,"L");
$pdf->Cell(3,5," ","$rmc",0,"L");$pdf->Cell(5,5,"$sn1c","$rmc",0,"L");$pdf->Cell(5,5,"$sn2c","$rmc",0,"L");

$pdf->Cell(10,5," ","$rmc",1,"L");

//uctovne a predchadzajuce obdobie mesk_sk,rokk_sk,mesp_sk,rokp_sk
$rokp_sk=$rokk_sk;
$mesp_sk="01";
$rokp08_sk=$rokk_sk-1;
if( $rokp08_sk < 10 ) $rokp08_sk="0".$rokp08_sk;
$mesp08_sk="01";
$rokk08_sk=$rokk_sk-1;
if( $rokk08_sk < 10 ) $rokk08_sk="0".$rokk08_sk;
$mesk08_sk="12";

//nacitaj obdobie z priznanie_po stare rok 2013
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

if( $kli_vrok >= 2013 )
{

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="20.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
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

$obdr1=substr($obdr1,2,2);
$obdr2=substr($obdr2,2,2);
$obmr1=substr($obmr1,2,2);
$obmr2=substr($obmr2,2,2);
}
//koniec rok 2013

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) { 
$mesp_sk=$obdm1; $rokp_sk=$obdr1; $mesk_sk=$obdm2; $rokk_sk=$obdr2; $mesp08_sk=$obmm1; $rokp08_sk=$obmr1; $mesk08_sk=$obmm2; $rokk08_sk=$obmr2; }

$Amesp=substr($mesp_sk,0,1);
$Bmesp=substr($mesp_sk,1,1);
$Arokp=substr($rokp_sk,0,1);
$Brokp=substr($rokp_sk,1,1);
$Amesk08=substr($mesk08_sk,0,1);
$Bmesk08=substr($mesk08_sk,1,1);
$Arokk08=substr($rokk08_sk,0,1);
$Brokk08=substr($rokk08_sk,1,1);
$Amesp08=substr($mesp08_sk,0,1);
$Bmesp08=substr($mesp08_sk,1,1);
$Arokp08=substr($rokp08_sk,0,1);
$Brokp08=substr($rokp08_sk,1,1);

$Amesk=substr($mesk_sk,0,1);
$Bmesk=substr($mesk_sk,1,1);
$Arokk=substr($rokk_sk,0,1);
$Brokk=substr($rokk_sk,1,1);

$pdf->SetY(62);
$pdf->SetX(164);
$pdf->Cell(4,6,"$Amesp","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesp","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Arokp","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokp","$rmc",1,"C");
$pdf->SetY(70);
$pdf->SetX(164);
$pdf->Cell(4,6,"$Amesk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesk","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Arokk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokk","$rmc",1,"C");
$pdf->SetY(79);
$pdf->SetX(164);
$pdf->Cell(4,6,"$Amesp08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesp08","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Arokp08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokp08","$rmc",1,"C");
$pdf->SetY(87);
$pdf->SetX(164);
$pdf->Cell(4,6,"$Amesk08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Bmesk08","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Arokk08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Brokk08","$rmc",1,"C");

//nazov1
if( $fir_fico == 31431194 ) { $fir_fnaz="HOSPODÁRSKE SLUŽBY s.r.o."; $fir_fnaz2="\"v likvidácii\""; }
$pdf->Cell(0,8," ","$rmc",1,"C");

$A=substr($fir_fnaz,0,1);$B=substr($fir_fnaz,1,1);$C=substr($fir_fnaz,2,1);$D=substr($fir_fnaz,3,1);$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);$G=substr($fir_fnaz,6,1);$H=substr($fir_fnaz,7,1);$I=substr($fir_fnaz,8,1);$J=substr($fir_fnaz,9,1);

$K=substr($fir_fnaz,10,1);$L=substr($fir_fnaz,11,1);$M=substr($fir_fnaz,12,1);$N=substr($fir_fnaz,13,1);$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);$R=substr($fir_fnaz,16,1);$S=substr($fir_fnaz,17,1);$T=substr($fir_fnaz,18,1);$U=substr($fir_fnaz,19,1);

$V=substr($fir_fnaz,20,1);$W=substr($fir_fnaz,21,1);$X=substr($fir_fnaz,22,1);$Y=substr($fir_fnaz,23,1);$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);$B1=substr($fir_fnaz,26,1);$C1=substr($fir_fnaz,27,1);$D1=substr($fir_fnaz,28,1);$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);$G1=substr($fir_fnaz,31,1);$H1=substr($fir_fnaz,32,1);$I1=substr($fir_fnaz,33,1);$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);$L1=substr($fir_fnaz,36,1);

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$H","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pdf->Cell(1,6," ","$rmc",1,"C");

//nazov2
$pdf->Cell(0,3," ","$rmc",1,"C");
$fir_fnaz2=substr($fir_fnaz,37,36);

$A=substr($fir_fnaz2,0,1);$B=substr($fir_fnaz2,1,1);$C=substr($fir_fnaz2,2,1);$D=substr($fir_fnaz2,3,1);$E=substr($fir_fnaz2,4,1);
$F=substr($fir_fnaz2,5,1);$G=substr($fir_fnaz2,6,1);$H=substr($fir_fnaz2,7,1);$I=substr($fir_fnaz2,8,1);$J=substr($fir_fnaz2,9,1);

$K=substr($fir_fnaz2,10,1);$L=substr($fir_fnaz2,11,1);$M=substr($fir_fnaz2,12,1);$N=substr($fir_fnaz2,13,1);$O=substr($fir_fnaz2,14,1);
$P=substr($fir_fnaz2,15,1);$R=substr($fir_fnaz2,16,1);$S=substr($fir_fnaz2,17,1);$T=substr($fir_fnaz2,18,1);$U=substr($fir_fnaz2,19,1);

$V=substr($fir_fnaz2,20,1);$W=substr($fir_fnaz2,21,1);$X=substr($fir_fnaz2,22,1);$Y=substr($fir_fnaz2,23,1);$Z=substr($fir_fnaz2,24,1);
$A1=substr($fir_fnaz2,25,1);$B1=substr($fir_fnaz2,26,1);$C1=substr($fir_fnaz2,27,1);$D1=substr($fir_fnaz2,28,1);$E1=substr($fir_fnaz2,29,1);
$F1=substr($fir_fnaz2,30,1);$G1=substr($fir_fnaz2,31,1);$H1=substr($fir_fnaz2,32,1);$I1=substr($fir_fnaz2,33,1);$J1=substr($fir_fnaz2,34,1);
$K1=substr($fir_fnaz2,35,1);$L1=substr($fir_fnaz2,36,1);

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(1,6," ","$rmc",1,"C");

//ulica cislo
$pdf->Cell(190,13,"     ","$rmc",1,"L");

$A=substr($fir_fuli,0,1);$B=substr($fir_fuli,1,1);$C=substr($fir_fuli,2,1);$D=substr($fir_fuli,3,1);$E=substr($fir_fuli,4,1);
$F=substr($fir_fuli,5,1);$G=substr($fir_fuli,6,1);$H=substr($fir_fuli,7,1);$I=substr($fir_fuli,8,1);$J=substr($fir_fuli,9,1);

$K=substr($fir_fuli,10,1);$L=substr($fir_fuli,11,1);$M=substr($fir_fuli,12,1);$N=substr($fir_fuli,13,1);$O=substr($fir_fuli,14,1);
$P=substr($fir_fuli,15,1);$R=substr($fir_fuli,16,1);$S=substr($fir_fuli,17,1);$T=substr($fir_fuli,18,1);$U=substr($fir_fuli,19,1);

$V=substr($fir_fuli,20,1);$W=substr($fir_fuli,21,1);$X=substr($fir_fuli,22,1);$Y=substr($fir_fuli,23,1);$Z=substr($fir_fuli,24,1);
$A1=substr($fir_fuli,25,1);$B1=substr($fir_fuli,26,1);$C1=substr($fir_fuli,27,1);

$pdf->Cell(4,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$C1","$rmc",0,"C");

$A=substr($fir_fcdm,0,1);$B=substr($fir_fcdm,1,1);$C=substr($fir_fcdm,2,1);$D=substr($fir_fcdm,3,1);$E=substr($fir_fcdm,4,1);
$F=substr($fir_fcdm,5,1);$G=substr($fir_fcdm,6,1);$H=substr($fir_fcdm,7,1);

$pdf->Cell(7,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",1,"C");


//psc,obec
$pdf->Cell(190,6,"     ","$rmc",1,"L");

$fir_fpsc=str_replace(" ","",$fir_fpsc);
$A=substr($fir_fpsc,0,1);$B=substr($fir_fpsc,1,1);$C=substr($fir_fpsc,2,1);$D=substr($fir_fpsc,3,1);$E=substr($fir_fpsc,4,1);

$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");


$A=substr($fir_fmes,0,1);$B=substr($fir_fmes,1,1);$C=substr($fir_fmes,2,1);$D=substr($fir_fmes,3,1);$E=substr($fir_fmes,4,1);
$F=substr($fir_fmes,5,1);$G=substr($fir_fmes,6,1);$H=substr($fir_fmes,7,1);$I=substr($fir_fmes,8,1);$J=substr($fir_fmes,9,1);

$K=substr($fir_fmes,10,1);$L=substr($fir_fmes,11,1);$M=substr($fir_fmes,12,1);$N=substr($fir_fmes,13,1);$O=substr($fir_fmes,14,1);
$P=substr($fir_fmes,15,1);$R=substr($fir_fmes,16,1);$S=substr($fir_fmes,17,1);$T=substr($fir_fmes,18,1);$U=substr($fir_fmes,19,1);

$V=substr($fir_fmes,20,1);$W=substr($fir_fmes,21,1);$X=substr($fir_fmes,22,1);$Y=substr($fir_fmes,23,1);$Z=substr($fir_fmes,24,1);
$A1=substr($fir_fmes,25,1);$B1=substr($fir_fmes,26,1);$C1=substr($fir_fmes,27,1);$D1=substr($fir_fmes,28,1);$E1=substr($fir_fmes,29,1);

$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",1,"C");

//telefon fax
$pdf->Cell(190,6,"     ","$rmc",1,"L");

$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if( $tel_pred == 0 ) { $tel_pred=""; }
if( $tel_za == 0 ) { $tel_za=""; }

$A=substr($tel_pred,0,1);$B=substr($tel_pred,1,1);$C=substr($tel_pred,2,1);

$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($tel_za,0,1);$B=substr($tel_za,1,1);$C=substr($tel_za,2,1);
$D=substr($tel_za,3,1);$E=substr($tel_za,4,1);$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);$H=substr($tel_za,7,1);


$pdf->Cell(5,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pole = explode("/", $fir_ffax);
$fax_pred=1*$pole[0];
$fax_za=$pole[1];
if( $fax_pred == 0 ) { $fax_pred=""; }
if( $fax_za == 0 ) { $fax_za=""; }

$A=substr($fax_pred,0,1);$B=substr($fax_pred,1,1);$C=substr($fax_pred,2,1);

$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($fax_za,0,1);$B=substr($fax_za,1,1);$C=substr($fax_za,2,1);
$D=substr($fax_za,3,1);$E=substr($fax_za,4,1);$F=substr($fax_za,5,1);
$G=substr($fax_za,6,1);$H=substr($fax_za,7,1);


$pdf->Cell(5,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pdf->Cell(1,6," ","$rmc",1,"C");

//email
$pdf->Cell(190,6,"     ","$rmc",1,"L");
$A=substr($fir_fem1,0,1);$B=substr($fir_fem1,1,1);$C=substr($fir_fem1,2,1);$D=substr($fir_fem1,3,1);$E=substr($fir_fem1,4,1);
$F=substr($fir_fem1,5,1);$G=substr($fir_fem1,6,1);$H=substr($fir_fem1,7,1);$I=substr($fir_fem1,8,1);$J=substr($fir_fem1,9,1);

$K=substr($fir_fem1,10,1);$L=substr($fir_fem1,11,1);$M=substr($fir_fem1,12,1);$N=substr($fir_fem1,13,1);$O=substr($fir_fem1,14,1);
$P=substr($fir_fem1,15,1);$R=substr($fir_fem1,16,1);$S=substr($fir_fem1,17,1);$T=substr($fir_fem1,18,1);$U=substr($fir_fem1,19,1);

$V=substr($fir_fem1,20,1);$W=substr($fir_fem1,21,1);$X=substr($fir_fem1,22,1);$Y=substr($fir_fem1,23,1);$Z=substr($fir_fem1,24,1);
$A1=substr($fir_fem1,25,1);$B1=substr($fir_fem1,26,1);$C1=substr($fir_fem1,27,1);$D1=substr($fir_fem1,28,1);$E1=substr($fir_fem1,29,1);

$pdf->Cell(5,6," ","$rmc",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(3,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$A1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$C1","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",1,"C");

//zostavena, schvalena
$pdf->SetY(181);
$pdf->SetX(13);

$da1=substr($h_zos,0,1);
$da2=substr($h_zos,1,1);
$da3=substr($h_zos,3,1);
$da4=substr($h_zos,4,1);
$da5=substr($h_zos,6,1);
$da6=substr($h_zos,7,1);
$da7=substr($h_zos,8,1);
$da8=substr($h_zos,9,1);

$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da2","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da4","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da8","$rmc",1,"C");

$pdf->SetY(199);
$pdf->SetX(11);

$da1=substr($h_sch,0,1);
$da2=substr($h_sch,1,1);
$da3=substr($h_sch,3,1);
$da4=substr($h_sch,4,1);
$da5=substr($h_sch,6,1);
$da6=substr($h_sch,7,1);
$da7=substr($h_sch,8,1);
$da8=substr($h_sch,9,1);

$pdf->Cell(4,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da2","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$da3","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da4","$rmc",0,"C");$pdf->Cell(3,6," ","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$da7","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$da8","$rmc",1,"C");

//krizik zostavena,schvalena
if( $h_zos != '' )
{
$krizzos="X";
if( trim($h_sch) != '' ) { $krizzos=" "; }
$pdf->SetY(67);
$pdf->Cell(92,3," ","$rmc",0,"C");$pdf->Cell(3,3,"$krizzos","$rmc",1,"C");
}
if( $h_sch != '' )
{
$krizsch="X";
$pdf->SetY(74);
$pdf->Cell(92,3," ","$rmc",0,"C");$pdf->Cell(3,3,"$krizsch","$rmc",1,"C");
}

//odkaz na datumy
$pdf->SetY(25);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(65);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(65);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(65);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);

$pdf->SetY(55);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);
$pdf->SetX(125);$pdf->Cell(90,5,"                                                            ","0",1,"L",0,$odkaz);

//riadna mimoriadna krizik
$druz=0;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $druz=1*$riadok->druz;
  }

$riadna="X";
$mimoriadna=" ";
if( $druz == 1 ) { $riadna=" "; $mimoriadna="X"; } 
$pdf->SetY(67);
$pdf->Cell(62,3," ","$rmc",0,"C");$pdf->Cell(4,3,"$riadna","$rmc",1,"C");

$pdf->SetY(74);
$pdf->Cell(62,3," ","$rmc",0,"C");$pdf->Cell(4,3,"$mimoriadna","$rmc",1,"C");


//koniec strana 1


$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-2.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-2.jpg',12,11,186,274); }
}

$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,5,"     ","$rmc",1,"L");

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

$pdf->Cell(72,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,16,"     ","$rmc",1,"L");


$pdf->Cell(48,6," ","$rmc",0,"R");
$r01=sprintf('% 11s',$r01);
$A=substr($r01,0,1);
$B=substr($r01,1,1);
$C=substr($r01,2,1);
$D=substr($r01,3,1);
$E=substr($r01,4,1);
$F=substr($r01,5,1);
$G=substr($r01,6,1);
$H=substr($r01,7,1);
$I=substr($r01,8,1);
$J=substr($r01,9,1);
$K=substr($r01,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn01=sprintf('% 11s',$rn01);
$A=substr($rn01,0,1);
$B=substr($rn01,1,1);
$C=substr($rn01,2,1);
$D=substr($rn01,3,1);
$E=substr($rn01,4,1);
$F=substr($rn01,5,1);
$G=substr($rn01,6,1);
$H=substr($rn01,7,1);
$I=substr($rn01,8,1);
$J=substr($rn01,9,1);
$K=substr($rn01,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk01=sprintf('% 11s',$rk01);
$A=substr($rk01,0,1);
$B=substr($rk01,1,1);
$C=substr($rk01,2,1);
$D=substr($rk01,3,1);
$E=substr($rk01,4,1);
$F=substr($rk01,5,1);
$G=substr($rk01,6,1);
$H=substr($rk01,7,1);
$I=substr($rk01,8,1);
$J=substr($rk01,9,1);
$K=substr($rk01,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm01=sprintf('% 11s',$rm01);
$A=substr($rm01,0,1);
$B=substr($rm01,1,1);
$C=substr($rm01,2,1);
$D=substr($rm01,3,1);
$E=substr($rm01,4,1);
$F=substr($rm01,5,1);
$G=substr($rm01,6,1);
$H=substr($rm01,7,1);
$I=substr($rm01,8,1);
$J=substr($rm01,9,1);
$K=substr($rm01,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r02=sprintf('% 11s',$r02);
$A=substr($r02,0,1);
$B=substr($r02,1,1);
$C=substr($r02,2,1);
$D=substr($r02,3,1);
$E=substr($r02,4,1);
$F=substr($r02,5,1);
$G=substr($r02,6,1);
$H=substr($r02,7,1);
$I=substr($r02,8,1);
$J=substr($r02,9,1);
$K=substr($r02,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn02=sprintf('% 11s',$rn02);
$A=substr($rn02,0,1);
$B=substr($rn02,1,1);
$C=substr($rn02,2,1);
$D=substr($rn02,3,1);
$E=substr($rn02,4,1);
$F=substr($rn02,5,1);
$G=substr($rn02,6,1);
$H=substr($rn02,7,1);
$I=substr($rn02,8,1);
$J=substr($rn02,9,1);
$K=substr($rn02,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk02=sprintf('% 11s',$rk02);
$A=substr($rk02,0,1);
$B=substr($rk02,1,1);
$C=substr($rk02,2,1);
$D=substr($rk02,3,1);
$E=substr($rk02,4,1);
$F=substr($rk02,5,1);
$G=substr($rk02,6,1);
$H=substr($rk02,7,1);
$I=substr($rk02,8,1);
$J=substr($rk02,9,1);
$K=substr($rk02,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm02=sprintf('% 11s',$rm02);
$A=substr($rm02,0,1);
$B=substr($rm02,1,1);
$C=substr($rm02,2,1);
$D=substr($rm02,3,1);
$E=substr($rm02,4,1);
$F=substr($rm02,5,1);
$G=substr($rm02,6,1);
$H=substr($rm02,7,1);
$I=substr($rm02,8,1);
$J=substr($rm02,9,1);
$K=substr($rm02,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r03=sprintf('% 11s',$r03);
$A=substr($r03,0,1);
$B=substr($r03,1,1);
$C=substr($r03,2,1);
$D=substr($r03,3,1);
$E=substr($r03,4,1);
$F=substr($r03,5,1);
$G=substr($r03,6,1);
$H=substr($r03,7,1);
$I=substr($r03,8,1);
$J=substr($r03,9,1);
$K=substr($r03,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn03=sprintf('% 11s',$rn03);
$A=substr($rn03,0,1);
$B=substr($rn03,1,1);
$C=substr($rn03,2,1);
$D=substr($rn03,3,1);
$E=substr($rn03,4,1);
$F=substr($rn03,5,1);
$G=substr($rn03,6,1);
$H=substr($rn03,7,1);
$I=substr($rn03,8,1);
$J=substr($rn03,9,1);
$K=substr($rn03,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk03=sprintf('% 11s',$rk03);
$A=substr($rk03,0,1);
$B=substr($rk03,1,1);
$C=substr($rk03,2,1);
$D=substr($rk03,3,1);
$E=substr($rk03,4,1);
$F=substr($rk03,5,1);
$G=substr($rk03,6,1);
$H=substr($rk03,7,1);
$I=substr($rk03,8,1);
$J=substr($rk03,9,1);
$K=substr($rk03,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm03=sprintf('% 11s',$rm03);
$A=substr($rm03,0,1);
$B=substr($rm03,1,1);
$C=substr($rm03,2,1);
$D=substr($rm03,3,1);
$E=substr($rm03,4,1);
$F=substr($rm03,5,1);
$G=substr($rm03,6,1);
$H=substr($rm03,7,1);
$I=substr($rm03,8,1);
$J=substr($rm03,9,1);
$K=substr($rm03,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r04=sprintf('% 11s',$r04);
$A=substr($r04,0,1);
$B=substr($r04,1,1);
$C=substr($r04,2,1);
$D=substr($r04,3,1);
$E=substr($r04,4,1);
$F=substr($r04,5,1);
$G=substr($r04,6,1);
$H=substr($r04,7,1);
$I=substr($r04,8,1);
$J=substr($r04,9,1);
$K=substr($r04,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn04=sprintf('% 11s',$rn04);
$A=substr($rn04,0,1);
$B=substr($rn04,1,1);
$C=substr($rn04,2,1);
$D=substr($rn04,3,1);
$E=substr($rn04,4,1);
$F=substr($rn04,5,1);
$G=substr($rn04,6,1);
$H=substr($rn04,7,1);
$I=substr($rn04,8,1);
$J=substr($rn04,9,1);
$K=substr($rn04,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk04=sprintf('% 11s',$rk04);
$A=substr($rk04,0,1);
$B=substr($rk04,1,1);
$C=substr($rk04,2,1);
$D=substr($rk04,3,1);
$E=substr($rk04,4,1);
$F=substr($rk04,5,1);
$G=substr($rk04,6,1);
$H=substr($rk04,7,1);
$I=substr($rk04,8,1);
$J=substr($rk04,9,1);
$K=substr($rk04,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm04=sprintf('% 11s',$rm04);
$A=substr($rm04,0,1);
$B=substr($rm04,1,1);
$C=substr($rm04,2,1);
$D=substr($rm04,3,1);
$E=substr($rm04,4,1);
$F=substr($rm04,5,1);
$G=substr($rm04,6,1);
$H=substr($rm04,7,1);
$I=substr($rm04,8,1);
$J=substr($rm04,9,1);
$K=substr($rm04,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r05=sprintf('% 11s',$r05);
$A=substr($r05,0,1);
$B=substr($r05,1,1);
$C=substr($r05,2,1);
$D=substr($r05,3,1);
$E=substr($r05,4,1);
$F=substr($r05,5,1);
$G=substr($r05,6,1);
$H=substr($r05,7,1);
$I=substr($r05,8,1);
$J=substr($r05,9,1);
$K=substr($r05,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn05=sprintf('% 11s',$rn05);
$A=substr($rn05,0,1);
$B=substr($rn05,1,1);
$C=substr($rn05,2,1);
$D=substr($rn05,3,1);
$E=substr($rn05,4,1);
$F=substr($rn05,5,1);
$G=substr($rn05,6,1);
$H=substr($rn05,7,1);
$I=substr($rn05,8,1);
$J=substr($rn05,9,1);
$K=substr($rn05,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk05=sprintf('% 11s',$rk05);
$A=substr($rk05,0,1);
$B=substr($rk05,1,1);
$C=substr($rk05,2,1);
$D=substr($rk05,3,1);
$E=substr($rk05,4,1);
$F=substr($rk05,5,1);
$G=substr($rk05,6,1);
$H=substr($rk05,7,1);
$I=substr($rk05,8,1);
$J=substr($rk05,9,1);
$K=substr($rk05,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm05=sprintf('% 11s',$rm05);
$A=substr($rm05,0,1);
$B=substr($rm05,1,1);
$C=substr($rm05,2,1);
$D=substr($rm05,3,1);
$E=substr($rm05,4,1);
$F=substr($rm05,5,1);
$G=substr($rm05,6,1);
$H=substr($rm05,7,1);
$I=substr($rm05,8,1);
$J=substr($rm05,9,1);
$K=substr($rm05,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r06=sprintf('% 11s',$r06);
$A=substr($r06,0,1);
$B=substr($r06,1,1);
$C=substr($r06,2,1);
$D=substr($r06,3,1);
$E=substr($r06,4,1);
$F=substr($r06,5,1);
$G=substr($r06,6,1);
$H=substr($r06,7,1);
$I=substr($r06,8,1);
$J=substr($r06,9,1);
$K=substr($r06,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn06=sprintf('% 11s',$rn06);
$A=substr($rn06,0,1);
$B=substr($rn06,1,1);
$C=substr($rn06,2,1);
$D=substr($rn06,3,1);
$E=substr($rn06,4,1);
$F=substr($rn06,5,1);
$G=substr($rn06,6,1);
$H=substr($rn06,7,1);
$I=substr($rn06,8,1);
$J=substr($rn06,9,1);
$K=substr($rn06,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk06=sprintf('% 11s',$rk06);
$A=substr($rk06,0,1);
$B=substr($rk06,1,1);
$C=substr($rk06,2,1);
$D=substr($rk06,3,1);
$E=substr($rk06,4,1);
$F=substr($rk06,5,1);
$G=substr($rk06,6,1);
$H=substr($rk06,7,1);
$I=substr($rk06,8,1);
$J=substr($rk06,9,1);
$K=substr($rk06,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm06=sprintf('% 11s',$rm06);
$A=substr($rm06,0,1);
$B=substr($rm06,1,1);
$C=substr($rm06,2,1);
$D=substr($rm06,3,1);
$E=substr($rm06,4,1);
$F=substr($rm06,5,1);
$G=substr($rm06,6,1);
$H=substr($rm06,7,1);
$I=substr($rm06,8,1);
$J=substr($rm06,9,1);
$K=substr($rm06,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r07=sprintf('% 11s',$r07);
$A=substr($r07,0,1);
$B=substr($r07,1,1);
$C=substr($r07,2,1);
$D=substr($r07,3,1);
$E=substr($r07,4,1);
$F=substr($r07,5,1);
$G=substr($r07,6,1);
$H=substr($r07,7,1);
$I=substr($r07,8,1);
$J=substr($r07,9,1);
$K=substr($r07,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn07=sprintf('% 11s',$rn07);
$A=substr($rn07,0,1);
$B=substr($rn07,1,1);
$C=substr($rn07,2,1);
$D=substr($rn07,3,1);
$E=substr($rn07,4,1);
$F=substr($rn07,5,1);
$G=substr($rn07,6,1);
$H=substr($rn07,7,1);
$I=substr($rn07,8,1);
$J=substr($rn07,9,1);
$K=substr($rn07,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk07=sprintf('% 11s',$rk07);
$A=substr($rk07,0,1);
$B=substr($rk07,1,1);
$C=substr($rk07,2,1);
$D=substr($rk07,3,1);
$E=substr($rk07,4,1);
$F=substr($rk07,5,1);
$G=substr($rk07,6,1);
$H=substr($rk07,7,1);
$I=substr($rk07,8,1);
$J=substr($rk07,9,1);
$K=substr($rk07,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm07=sprintf('% 11s',$rm07);
$A=substr($rm07,0,1);
$B=substr($rm07,1,1);
$C=substr($rm07,2,1);
$D=substr($rm07,3,1);
$E=substr($rm07,4,1);
$F=substr($rm07,5,1);
$G=substr($rm07,6,1);
$H=substr($rm07,7,1);
$I=substr($rm07,8,1);
$J=substr($rm07,9,1);
$K=substr($rm07,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r08=sprintf('% 11s',$r08);
$A=substr($r08,0,1);
$B=substr($r08,1,1);
$C=substr($r08,2,1);
$D=substr($r08,3,1);
$E=substr($r08,4,1);
$F=substr($r08,5,1);
$G=substr($r08,6,1);
$H=substr($r08,7,1);
$I=substr($r08,8,1);
$J=substr($r08,9,1);
$K=substr($r08,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn08=sprintf('% 11s',$rn08);
$A=substr($rn08,0,1);
$B=substr($rn08,1,1);
$C=substr($rn08,2,1);
$D=substr($rn08,3,1);
$E=substr($rn08,4,1);
$F=substr($rn08,5,1);
$G=substr($rn08,6,1);
$H=substr($rn08,7,1);
$I=substr($rn08,8,1);
$J=substr($rn08,9,1);
$K=substr($rn08,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk08=sprintf('% 11s',$rk08);
$A=substr($rk08,0,1);
$B=substr($rk08,1,1);
$C=substr($rk08,2,1);
$D=substr($rk08,3,1);
$E=substr($rk08,4,1);
$F=substr($rk08,5,1);
$G=substr($rk08,6,1);
$H=substr($rk08,7,1);
$I=substr($rk08,8,1);
$J=substr($rk08,9,1);
$K=substr($rk08,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm08=sprintf('% 11s',$rm08);
$A=substr($rm08,0,1);
$B=substr($rm08,1,1);
$C=substr($rm08,2,1);
$D=substr($rm08,3,1);
$E=substr($rm08,4,1);
$F=substr($rm08,5,1);
$G=substr($rm08,6,1);
$H=substr($rm08,7,1);
$I=substr($rm08,8,1);
$J=substr($rm08,9,1);
$K=substr($rm08,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r09=sprintf('% 11s',$r09);
$A=substr($r09,0,1);
$B=substr($r09,1,1);
$C=substr($r09,2,1);
$D=substr($r09,3,1);
$E=substr($r09,4,1);
$F=substr($r09,5,1);
$G=substr($r09,6,1);
$H=substr($r09,7,1);
$I=substr($r09,8,1);
$J=substr($r09,9,1);
$K=substr($r09,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn09=sprintf('% 11s',$rn09);
$A=substr($rn09,0,1);
$B=substr($rn09,1,1);
$C=substr($rn09,2,1);
$D=substr($rn09,3,1);
$E=substr($rn09,4,1);
$F=substr($rn09,5,1);
$G=substr($rn09,6,1);
$H=substr($rn09,7,1);
$I=substr($rn09,8,1);
$J=substr($rn09,9,1);
$K=substr($rn09,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk09=sprintf('% 11s',$rk09);
$A=substr($rk09,0,1);
$B=substr($rk09,1,1);
$C=substr($rk09,2,1);
$D=substr($rk09,3,1);
$E=substr($rk09,4,1);
$F=substr($rk09,5,1);
$G=substr($rk09,6,1);
$H=substr($rk09,7,1);
$I=substr($rk09,8,1);
$J=substr($rk09,9,1);
$K=substr($rk09,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm09=sprintf('% 11s',$rm09);
$A=substr($rm09,0,1);
$B=substr($rm09,1,1);
$C=substr($rm09,2,1);
$D=substr($rm09,3,1);
$E=substr($rm09,4,1);
$F=substr($rm09,5,1);
$G=substr($rm09,6,1);
$H=substr($rm09,7,1);
$I=substr($rm09,8,1);
$J=substr($rm09,9,1);
$K=substr($rm09,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r10=sprintf('% 11s',$r10);
$A=substr($r10,0,1);
$B=substr($r10,1,1);
$C=substr($r10,2,1);
$D=substr($r10,3,1);
$E=substr($r10,4,1);
$F=substr($r10,5,1);
$G=substr($r10,6,1);
$H=substr($r10,7,1);
$I=substr($r10,8,1);
$J=substr($r10,9,1);
$K=substr($r10,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn10=sprintf('% 11s',$rn10);
$A=substr($rn10,0,1);
$B=substr($rn10,1,1);
$C=substr($rn10,2,1);
$D=substr($rn10,3,1);
$E=substr($rn10,4,1);
$F=substr($rn10,5,1);
$G=substr($rn10,6,1);
$H=substr($rn10,7,1);
$I=substr($rn10,8,1);
$J=substr($rn10,9,1);
$K=substr($rn10,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk10=sprintf('% 11s',$rk10);
$A=substr($rk10,0,1);
$B=substr($rk10,1,1);
$C=substr($rk10,2,1);
$D=substr($rk10,3,1);
$E=substr($rk10,4,1);
$F=substr($rk10,5,1);
$G=substr($rk10,6,1);
$H=substr($rk10,7,1);
$I=substr($rk10,8,1);
$J=substr($rk10,9,1);
$K=substr($rk10,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm10=sprintf('% 11s',$rm10);
$A=substr($rm10,0,1);
$B=substr($rm10,1,1);
$C=substr($rm10,2,1);
$D=substr($rm10,3,1);
$E=substr($rm10,4,1);
$F=substr($rm10,5,1);
$G=substr($rm10,6,1);
$H=substr($rm10,7,1);
$I=substr($rm10,8,1);
$J=substr($rm10,9,1);
$K=substr($rm10,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r11=sprintf('% 11s',$r11);
$A=substr($r11,0,1);
$B=substr($r11,1,1);
$C=substr($r11,2,1);
$D=substr($r11,3,1);
$E=substr($r11,4,1);
$F=substr($r11,5,1);
$G=substr($r11,6,1);
$H=substr($r11,7,1);
$I=substr($r11,8,1);
$J=substr($r11,9,1);
$K=substr($r11,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn11=sprintf('% 11s',$rn11);
$A=substr($rn11,0,1);
$B=substr($rn11,1,1);
$C=substr($rn11,2,1);
$D=substr($rn11,3,1);
$E=substr($rn11,4,1);
$F=substr($rn11,5,1);
$G=substr($rn11,6,1);
$H=substr($rn11,7,1);
$I=substr($rn11,8,1);
$J=substr($rn11,9,1);
$K=substr($rn11,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk11=sprintf('% 11s',$rk11);
$A=substr($rk11,0,1);
$B=substr($rk11,1,1);
$C=substr($rk11,2,1);
$D=substr($rk11,3,1);
$E=substr($rk11,4,1);
$F=substr($rk11,5,1);
$G=substr($rk11,6,1);
$H=substr($rk11,7,1);
$I=substr($rk11,8,1);
$J=substr($rk11,9,1);
$K=substr($rk11,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm11=sprintf('% 11s',$rm11);
$A=substr($rm11,0,1);
$B=substr($rm11,1,1);
$C=substr($rm11,2,1);
$D=substr($rm11,3,1);
$E=substr($rm11,4,1);
$F=substr($rm11,5,1);
$G=substr($rm11,6,1);
$H=substr($rm11,7,1);
$I=substr($rm11,8,1);
$J=substr($rm11,9,1);
$K=substr($rm11,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r12=sprintf('% 11s',$r12);
$A=substr($r12,0,1);
$B=substr($r12,1,1);
$C=substr($r12,2,1);
$D=substr($r12,3,1);
$E=substr($r12,4,1);
$F=substr($r12,5,1);
$G=substr($r12,6,1);
$H=substr($r12,7,1);
$I=substr($r12,8,1);
$J=substr($r12,9,1);
$K=substr($r12,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn12=sprintf('% 11s',$rn12);
$A=substr($rn12,0,1);
$B=substr($rn12,1,1);
$C=substr($rn12,2,1);
$D=substr($rn12,3,1);
$E=substr($rn12,4,1);
$F=substr($rn12,5,1);
$G=substr($rn12,6,1);
$H=substr($rn12,7,1);
$I=substr($rn12,8,1);
$J=substr($rn12,9,1);
$K=substr($rn12,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk12=sprintf('% 11s',$rk12);
$A=substr($rk12,0,1);
$B=substr($rk12,1,1);
$C=substr($rk12,2,1);
$D=substr($rk12,3,1);
$E=substr($rk12,4,1);
$F=substr($rk12,5,1);
$G=substr($rk12,6,1);
$H=substr($rk12,7,1);
$I=substr($rk12,8,1);
$J=substr($rk12,9,1);
$K=substr($rk12,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm12=sprintf('% 11s',$rm12);
$A=substr($rm12,0,1);
$B=substr($rm12,1,1);
$C=substr($rm12,2,1);
$D=substr($rm12,3,1);
$E=substr($rm12,4,1);
$F=substr($rm12,5,1);
$G=substr($rm12,6,1);
$H=substr($rm12,7,1);
$I=substr($rm12,8,1);
$J=substr($rm12,9,1);
$K=substr($rm12,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r13=sprintf('% 11s',$r13);
$A=substr($r13,0,1);
$B=substr($r13,1,1);
$C=substr($r13,2,1);
$D=substr($r13,3,1);
$E=substr($r13,4,1);
$F=substr($r13,5,1);
$G=substr($r13,6,1);
$H=substr($r13,7,1);
$I=substr($r13,8,1);
$J=substr($r13,9,1);
$K=substr($r13,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn13=sprintf('% 11s',$rn13);
$A=substr($rn13,0,1);
$B=substr($rn13,1,1);
$C=substr($rn13,2,1);
$D=substr($rn13,3,1);
$E=substr($rn13,4,1);
$F=substr($rn13,5,1);
$G=substr($rn13,6,1);
$H=substr($rn13,7,1);
$I=substr($rn13,8,1);
$J=substr($rn13,9,1);
$K=substr($rn13,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk13=sprintf('% 11s',$rk13);
$A=substr($rk13,0,1);
$B=substr($rk13,1,1);
$C=substr($rk13,2,1);
$D=substr($rk13,3,1);
$E=substr($rk13,4,1);
$F=substr($rk13,5,1);
$G=substr($rk13,6,1);
$H=substr($rk13,7,1);
$I=substr($rk13,8,1);
$J=substr($rk13,9,1);
$K=substr($rk13,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm13=sprintf('% 11s',$rm13);
$A=substr($rm13,0,1);
$B=substr($rm13,1,1);
$C=substr($rm13,2,1);
$D=substr($rm13,3,1);
$E=substr($rm13,4,1);
$F=substr($rm13,5,1);
$G=substr($rm13,6,1);
$H=substr($rm13,7,1);
$I=substr($rm13,8,1);
$J=substr($rm13,9,1);
$K=substr($rm13,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r14=sprintf('% 11s',$r14);
$A=substr($r14,0,1);
$B=substr($r14,1,1);
$C=substr($r14,2,1);
$D=substr($r14,3,1);
$E=substr($r14,4,1);
$F=substr($r14,5,1);
$G=substr($r14,6,1);
$H=substr($r14,7,1);
$I=substr($r14,8,1);
$J=substr($r14,9,1);
$K=substr($r14,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn14=sprintf('% 11s',$rn14);
$A=substr($rn14,0,1);
$B=substr($rn14,1,1);
$C=substr($rn14,2,1);
$D=substr($rn14,3,1);
$E=substr($rn14,4,1);
$F=substr($rn14,5,1);
$G=substr($rn14,6,1);
$H=substr($rn14,7,1);
$I=substr($rn14,8,1);
$J=substr($rn14,9,1);
$K=substr($rn14,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk14=sprintf('% 11s',$rk14);
$A=substr($rk14,0,1);
$B=substr($rk14,1,1);
$C=substr($rk14,2,1);
$D=substr($rk14,3,1);
$E=substr($rk14,4,1);
$F=substr($rk14,5,1);
$G=substr($rk14,6,1);
$H=substr($rk14,7,1);
$I=substr($rk14,8,1);
$J=substr($rk14,9,1);
$K=substr($rk14,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm14=sprintf('% 11s',$rm14);
$A=substr($rm14,0,1);
$B=substr($rm14,1,1);
$C=substr($rm14,2,1);
$D=substr($rm14,3,1);
$E=substr($rm14,4,1);
$F=substr($rm14,5,1);
$G=substr($rm14,6,1);
$H=substr($rm14,7,1);
$I=substr($rm14,8,1);
$J=substr($rm14,9,1);
$K=substr($rm14,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");


//koniec strana 2

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-3.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-3.jpg',13,12,186,274); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,5,"     ","$rmc",1,"L");

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

$pdf->Cell(73,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(3,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,17,"     ","$rmc",1,"L");

$pdf->Cell(49,6," ","$rmc",0,"R");
$r15=sprintf('% 11s',$r15);
$A=substr($r15,0,1);
$B=substr($r15,1,1);
$C=substr($r15,2,1);
$D=substr($r15,3,1);
$E=substr($r15,4,1);
$F=substr($r15,5,1);
$G=substr($r15,6,1);
$H=substr($r15,7,1);
$I=substr($r15,8,1);
$J=substr($r15,9,1);
$K=substr($r15,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn15=sprintf('% 11s',$rn15);
$A=substr($rn15,0,1);
$B=substr($rn15,1,1);
$C=substr($rn15,2,1);
$D=substr($rn15,3,1);
$E=substr($rn15,4,1);
$F=substr($rn15,5,1);
$G=substr($rn15,6,1);
$H=substr($rn15,7,1);
$I=substr($rn15,8,1);
$J=substr($rn15,9,1);
$K=substr($rn15,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk15=sprintf('% 11s',$rk15);
$A=substr($rk15,0,1);
$B=substr($rk15,1,1);
$C=substr($rk15,2,1);
$D=substr($rk15,3,1);
$E=substr($rk15,4,1);
$F=substr($rk15,5,1);
$G=substr($rk15,6,1);
$H=substr($rk15,7,1);
$I=substr($rk15,8,1);
$J=substr($rk15,9,1);
$K=substr($rk15,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm15=sprintf('% 11s',$rm15);
$A=substr($rm15,0,1);
$B=substr($rm15,1,1);
$C=substr($rm15,2,1);
$D=substr($rm15,3,1);
$E=substr($rm15,4,1);
$F=substr($rm15,5,1);
$G=substr($rm15,6,1);
$H=substr($rm15,7,1);
$I=substr($rm15,8,1);
$J=substr($rm15,9,1);
$K=substr($rm15,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r16=sprintf('% 11s',$r16);
$A=substr($r16,0,1);
$B=substr($r16,1,1);
$C=substr($r16,2,1);
$D=substr($r16,3,1);
$E=substr($r16,4,1);
$F=substr($r16,5,1);
$G=substr($r16,6,1);
$H=substr($r16,7,1);
$I=substr($r16,8,1);
$J=substr($r16,9,1);
$K=substr($r16,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn16=sprintf('% 11s',$rn16);
$A=substr($rn16,0,1);
$B=substr($rn16,1,1);
$C=substr($rn16,2,1);
$D=substr($rn16,3,1);
$E=substr($rn16,4,1);
$F=substr($rn16,5,1);
$G=substr($rn16,6,1);
$H=substr($rn16,7,1);
$I=substr($rn16,8,1);
$J=substr($rn16,9,1);
$K=substr($rn16,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk16=sprintf('% 11s',$rk16);
$A=substr($rk16,0,1);
$B=substr($rk16,1,1);
$C=substr($rk16,2,1);
$D=substr($rk16,3,1);
$E=substr($rk16,4,1);
$F=substr($rk16,5,1);
$G=substr($rk16,6,1);
$H=substr($rk16,7,1);
$I=substr($rk16,8,1);
$J=substr($rk16,9,1);
$K=substr($rk16,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm16=sprintf('% 11s',$rm16);
$A=substr($rm16,0,1);
$B=substr($rm16,1,1);
$C=substr($rm16,2,1);
$D=substr($rm16,3,1);
$E=substr($rm16,4,1);
$F=substr($rm16,5,1);
$G=substr($rm16,6,1);
$H=substr($rm16,7,1);
$I=substr($rm16,8,1);
$J=substr($rm16,9,1);
$K=substr($rm16,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r17=sprintf('% 11s',$r17);
$A=substr($r17,0,1);
$B=substr($r17,1,1);
$C=substr($r17,2,1);
$D=substr($r17,3,1);
$E=substr($r17,4,1);
$F=substr($r17,5,1);
$G=substr($r17,6,1);
$H=substr($r17,7,1);
$I=substr($r17,8,1);
$J=substr($r17,9,1);
$K=substr($r17,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn17=sprintf('% 11s',$rn17);
$A=substr($rn17,0,1);
$B=substr($rn17,1,1);
$C=substr($rn17,2,1);
$D=substr($rn17,3,1);
$E=substr($rn17,4,1);
$F=substr($rn17,5,1);
$G=substr($rn17,6,1);
$H=substr($rn17,7,1);
$I=substr($rn17,8,1);
$J=substr($rn17,9,1);
$K=substr($rn17,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk17=sprintf('% 11s',$rk17);
$A=substr($rk17,0,1);
$B=substr($rk17,1,1);
$C=substr($rk17,2,1);
$D=substr($rk17,3,1);
$E=substr($rk17,4,1);
$F=substr($rk17,5,1);
$G=substr($rk17,6,1);
$H=substr($rk17,7,1);
$I=substr($rk17,8,1);
$J=substr($rk17,9,1);
$K=substr($rk17,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm17=sprintf('% 11s',$rm17);
$A=substr($rm17,0,1);
$B=substr($rm17,1,1);
$C=substr($rm17,2,1);
$D=substr($rm17,3,1);
$E=substr($rm17,4,1);
$F=substr($rm17,5,1);
$G=substr($rm17,6,1);
$H=substr($rm17,7,1);
$I=substr($rm17,8,1);
$J=substr($rm17,9,1);
$K=substr($rm17,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r18=sprintf('% 11s',$r18);
$A=substr($r18,0,1);
$B=substr($r18,1,1);
$C=substr($r18,2,1);
$D=substr($r18,3,1);
$E=substr($r18,4,1);
$F=substr($r18,5,1);
$G=substr($r18,6,1);
$H=substr($r18,7,1);
$I=substr($r18,8,1);
$J=substr($r18,9,1);
$K=substr($r18,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn18=sprintf('% 11s',$rn18);
$A=substr($rn18,0,1);
$B=substr($rn18,1,1);
$C=substr($rn18,2,1);
$D=substr($rn18,3,1);
$E=substr($rn18,4,1);
$F=substr($rn18,5,1);
$G=substr($rn18,6,1);
$H=substr($rn18,7,1);
$I=substr($rn18,8,1);
$J=substr($rn18,9,1);
$K=substr($rn18,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk18=sprintf('% 11s',$rk18);
$A=substr($rk18,0,1);
$B=substr($rk18,1,1);
$C=substr($rk18,2,1);
$D=substr($rk18,3,1);
$E=substr($rk18,4,1);
$F=substr($rk18,5,1);
$G=substr($rk18,6,1);
$H=substr($rk18,7,1);
$I=substr($rk18,8,1);
$J=substr($rk18,9,1);
$K=substr($rk18,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm18=sprintf('% 11s',$rm18);
$A=substr($rm18,0,1);
$B=substr($rm18,1,1);
$C=substr($rm18,2,1);
$D=substr($rm18,3,1);
$E=substr($rm18,4,1);
$F=substr($rm18,5,1);
$G=substr($rm18,6,1);
$H=substr($rm18,7,1);
$I=substr($rm18,8,1);
$J=substr($rm18,9,1);
$K=substr($rm18,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r19=sprintf('% 11s',$r19);
$A=substr($r19,0,1);
$B=substr($r19,1,1);
$C=substr($r19,2,1);
$D=substr($r19,3,1);
$E=substr($r19,4,1);
$F=substr($r19,5,1);
$G=substr($r19,6,1);
$H=substr($r19,7,1);
$I=substr($r19,8,1);
$J=substr($r19,9,1);
$K=substr($r19,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn19=sprintf('% 11s',$rn19);
$A=substr($rn19,0,1);
$B=substr($rn19,1,1);
$C=substr($rn19,2,1);
$D=substr($rn19,3,1);
$E=substr($rn19,4,1);
$F=substr($rn19,5,1);
$G=substr($rn19,6,1);
$H=substr($rn19,7,1);
$I=substr($rn19,8,1);
$J=substr($rn19,9,1);
$K=substr($rn19,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk19=sprintf('% 11s',$rk19);
$A=substr($rk19,0,1);
$B=substr($rk19,1,1);
$C=substr($rk19,2,1);
$D=substr($rk19,3,1);
$E=substr($rk19,4,1);
$F=substr($rk19,5,1);
$G=substr($rk19,6,1);
$H=substr($rk19,7,1);
$I=substr($rk19,8,1);
$J=substr($rk19,9,1);
$K=substr($rk19,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm19=sprintf('% 11s',$rm19);
$A=substr($rm19,0,1);
$B=substr($rm19,1,1);
$C=substr($rm19,2,1);
$D=substr($rm19,3,1);
$E=substr($rm19,4,1);
$F=substr($rm19,5,1);
$G=substr($rm19,6,1);
$H=substr($rm19,7,1);
$I=substr($rm19,8,1);
$J=substr($rm19,9,1);
$K=substr($rm19,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r20=sprintf('% 11s',$r20);
$A=substr($r20,0,1);
$B=substr($r20,1,1);
$C=substr($r20,2,1);
$D=substr($r20,3,1);
$E=substr($r20,4,1);
$F=substr($r20,5,1);
$G=substr($r20,6,1);
$H=substr($r20,7,1);
$I=substr($r20,8,1);
$J=substr($r20,9,1);
$K=substr($r20,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn20=sprintf('% 11s',$rn20);
$A=substr($rn20,0,1);
$B=substr($rn20,1,1);
$C=substr($rn20,2,1);
$D=substr($rn20,3,1);
$E=substr($rn20,4,1);
$F=substr($rn20,5,1);
$G=substr($rn20,6,1);
$H=substr($rn20,7,1);
$I=substr($rn20,8,1);
$J=substr($rn20,9,1);
$K=substr($rn20,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk20=sprintf('% 11s',$rk20);
$A=substr($rk20,0,1);
$B=substr($rk20,1,1);
$C=substr($rk20,2,1);
$D=substr($rk20,3,1);
$E=substr($rk20,4,1);
$F=substr($rk20,5,1);
$G=substr($rk20,6,1);
$H=substr($rk20,7,1);
$I=substr($rk20,8,1);
$J=substr($rk20,9,1);
$K=substr($rk20,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm20=sprintf('% 11s',$rm20);
$A=substr($rm20,0,1);
$B=substr($rm20,1,1);
$C=substr($rm20,2,1);
$D=substr($rm20,3,1);
$E=substr($rm20,4,1);
$F=substr($rm20,5,1);
$G=substr($rm20,6,1);
$H=substr($rm20,7,1);
$I=substr($rm20,8,1);
$J=substr($rm20,9,1);
$K=substr($rm20,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r21=sprintf('% 11s',$r21);
$A=substr($r21,0,1);
$B=substr($r21,1,1);
$C=substr($r21,2,1);
$D=substr($r21,3,1);
$E=substr($r21,4,1);
$F=substr($r21,5,1);
$G=substr($r21,6,1);
$H=substr($r21,7,1);
$I=substr($r21,8,1);
$J=substr($r21,9,1);
$K=substr($r21,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn21=sprintf('% 11s',$rn21);
$A=substr($rn21,0,1);
$B=substr($rn21,1,1);
$C=substr($rn21,2,1);
$D=substr($rn21,3,1);
$E=substr($rn21,4,1);
$F=substr($rn21,5,1);
$G=substr($rn21,6,1);
$H=substr($rn21,7,1);
$I=substr($rn21,8,1);
$J=substr($rn21,9,1);
$K=substr($rn21,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk21=sprintf('% 11s',$rk21);
$A=substr($rk21,0,1);
$B=substr($rk21,1,1);
$C=substr($rk21,2,1);
$D=substr($rk21,3,1);
$E=substr($rk21,4,1);
$F=substr($rk21,5,1);
$G=substr($rk21,6,1);
$H=substr($rk21,7,1);
$I=substr($rk21,8,1);
$J=substr($rk21,9,1);
$K=substr($rk21,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm21=sprintf('% 11s',$rm21);
$A=substr($rm21,0,1);
$B=substr($rm21,1,1);
$C=substr($rm21,2,1);
$D=substr($rm21,3,1);
$E=substr($rm21,4,1);
$F=substr($rm21,5,1);
$G=substr($rm21,6,1);
$H=substr($rm21,7,1);
$I=substr($rm21,8,1);
$J=substr($rm21,9,1);
$K=substr($rm21,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r22=sprintf('% 11s',$r22);
$A=substr($r22,0,1);
$B=substr($r22,1,1);
$C=substr($r22,2,1);
$D=substr($r22,3,1);
$E=substr($r22,4,1);
$F=substr($r22,5,1);
$G=substr($r22,6,1);
$H=substr($r22,7,1);
$I=substr($r22,8,1);
$J=substr($r22,9,1);
$K=substr($r22,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn22=sprintf('% 11s',$rn22);
$A=substr($rn22,0,1);
$B=substr($rn22,1,1);
$C=substr($rn22,2,1);
$D=substr($rn22,3,1);
$E=substr($rn22,4,1);
$F=substr($rn22,5,1);
$G=substr($rn22,6,1);
$H=substr($rn22,7,1);
$I=substr($rn22,8,1);
$J=substr($rn22,9,1);
$K=substr($rn22,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk22=sprintf('% 11s',$rk22);
$A=substr($rk22,0,1);
$B=substr($rk22,1,1);
$C=substr($rk22,2,1);
$D=substr($rk22,3,1);
$E=substr($rk22,4,1);
$F=substr($rk22,5,1);
$G=substr($rk22,6,1);
$H=substr($rk22,7,1);
$I=substr($rk22,8,1);
$J=substr($rk22,9,1);
$K=substr($rk22,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm22=sprintf('% 11s',$rm22);
$A=substr($rm22,0,1);
$B=substr($rm22,1,1);
$C=substr($rm22,2,1);
$D=substr($rm22,3,1);
$E=substr($rm22,4,1);
$F=substr($rm22,5,1);
$G=substr($rm22,6,1);
$H=substr($rm22,7,1);
$I=substr($rm22,8,1);
$J=substr($rm22,9,1);
$K=substr($rm22,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r23=sprintf('% 11s',$r23);
$A=substr($r23,0,1);
$B=substr($r23,1,1);
$C=substr($r23,2,1);
$D=substr($r23,3,1);
$E=substr($r23,4,1);
$F=substr($r23,5,1);
$G=substr($r23,6,1);
$H=substr($r23,7,1);
$I=substr($r23,8,1);
$J=substr($r23,9,1);
$K=substr($r23,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn23=sprintf('% 11s',$rn23);
$A=substr($rn23,0,1);
$B=substr($rn23,1,1);
$C=substr($rn23,2,1);
$D=substr($rn23,3,1);
$E=substr($rn23,4,1);
$F=substr($rn23,5,1);
$G=substr($rn23,6,1);
$H=substr($rn23,7,1);
$I=substr($rn23,8,1);
$J=substr($rn23,9,1);
$K=substr($rn23,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk23=sprintf('% 11s',$rk23);
$A=substr($rk23,0,1);
$B=substr($rk23,1,1);
$C=substr($rk23,2,1);
$D=substr($rk23,3,1);
$E=substr($rk23,4,1);
$F=substr($rk23,5,1);
$G=substr($rk23,6,1);
$H=substr($rk23,7,1);
$I=substr($rk23,8,1);
$J=substr($rk23,9,1);
$K=substr($rk23,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm23=sprintf('% 11s',$rm23);
$A=substr($rm23,0,1);
$B=substr($rm23,1,1);
$C=substr($rm23,2,1);
$D=substr($rm23,3,1);
$E=substr($rm23,4,1);
$F=substr($rm23,5,1);
$G=substr($rm23,6,1);
$H=substr($rm23,7,1);
$I=substr($rm23,8,1);
$J=substr($rm23,9,1);
$K=substr($rm23,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r24=sprintf('% 11s',$r24);
$A=substr($r24,0,1);
$B=substr($r24,1,1);
$C=substr($r24,2,1);
$D=substr($r24,3,1);
$E=substr($r24,4,1);
$F=substr($r24,5,1);
$G=substr($r24,6,1);
$H=substr($r24,7,1);
$I=substr($r24,8,1);
$J=substr($r24,9,1);
$K=substr($r24,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn24=sprintf('% 11s',$rn24);
$A=substr($rn24,0,1);
$B=substr($rn24,1,1);
$C=substr($rn24,2,1);
$D=substr($rn24,3,1);
$E=substr($rn24,4,1);
$F=substr($rn24,5,1);
$G=substr($rn24,6,1);
$H=substr($rn24,7,1);
$I=substr($rn24,8,1);
$J=substr($rn24,9,1);
$K=substr($rn24,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk24=sprintf('% 11s',$rk24);
$A=substr($rk24,0,1);
$B=substr($rk24,1,1);
$C=substr($rk24,2,1);
$D=substr($rk24,3,1);
$E=substr($rk24,4,1);
$F=substr($rk24,5,1);
$G=substr($rk24,6,1);
$H=substr($rk24,7,1);
$I=substr($rk24,8,1);
$J=substr($rk24,9,1);
$K=substr($rk24,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm24=sprintf('% 11s',$rm24);
$A=substr($rm24,0,1);
$B=substr($rm24,1,1);
$C=substr($rm24,2,1);
$D=substr($rm24,3,1);
$E=substr($rm24,4,1);
$F=substr($rm24,5,1);
$G=substr($rm24,6,1);
$H=substr($rm24,7,1);
$I=substr($rm24,8,1);
$J=substr($rm24,9,1);
$K=substr($rm24,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r25=sprintf('% 11s',$r25);
$A=substr($r25,0,1);
$B=substr($r25,1,1);
$C=substr($r25,2,1);
$D=substr($r25,3,1);
$E=substr($r25,4,1);
$F=substr($r25,5,1);
$G=substr($r25,6,1);
$H=substr($r25,7,1);
$I=substr($r25,8,1);
$J=substr($r25,9,1);
$K=substr($r25,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn25=sprintf('% 11s',$rn25);
$A=substr($rn25,0,1);
$B=substr($rn25,1,1);
$C=substr($rn25,2,1);
$D=substr($rn25,3,1);
$E=substr($rn25,4,1);
$F=substr($rn25,5,1);
$G=substr($rn25,6,1);
$H=substr($rn25,7,1);
$I=substr($rn25,8,1);
$J=substr($rn25,9,1);
$K=substr($rn25,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk25=sprintf('% 11s',$rk25);
$A=substr($rk25,0,1);
$B=substr($rk25,1,1);
$C=substr($rk25,2,1);
$D=substr($rk25,3,1);
$E=substr($rk25,4,1);
$F=substr($rk25,5,1);
$G=substr($rk25,6,1);
$H=substr($rk25,7,1);
$I=substr($rk25,8,1);
$J=substr($rk25,9,1);
$K=substr($rk25,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm25=sprintf('% 11s',$rm25);
$A=substr($rm25,0,1);
$B=substr($rm25,1,1);
$C=substr($rm25,2,1);
$D=substr($rm25,3,1);
$E=substr($rm25,4,1);
$F=substr($rm25,5,1);
$G=substr($rm25,6,1);
$H=substr($rm25,7,1);
$I=substr($rm25,8,1);
$J=substr($rm25,9,1);
$K=substr($rm25,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r26=sprintf('% 11s',$r26);
$A=substr($r26,0,1);
$B=substr($r26,1,1);
$C=substr($r26,2,1);
$D=substr($r26,3,1);
$E=substr($r26,4,1);
$F=substr($r26,5,1);
$G=substr($r26,6,1);
$H=substr($r26,7,1);
$I=substr($r26,8,1);
$J=substr($r26,9,1);
$K=substr($r26,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn26=sprintf('% 11s',$rn26);
$A=substr($rn26,0,1);
$B=substr($rn26,1,1);
$C=substr($rn26,2,1);
$D=substr($rn26,3,1);
$E=substr($rn26,4,1);
$F=substr($rn26,5,1);
$G=substr($rn26,6,1);
$H=substr($rn26,7,1);
$I=substr($rn26,8,1);
$J=substr($rn26,9,1);
$K=substr($rn26,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk26=sprintf('% 11s',$rk26);
$A=substr($rk26,0,1);
$B=substr($rk26,1,1);
$C=substr($rk26,2,1);
$D=substr($rk26,3,1);
$E=substr($rk26,4,1);
$F=substr($rk26,5,1);
$G=substr($rk26,6,1);
$H=substr($rk26,7,1);
$I=substr($rk26,8,1);
$J=substr($rk26,9,1);
$K=substr($rk26,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm26=sprintf('% 11s',$rm26);
$A=substr($rm26,0,1);
$B=substr($rm26,1,1);
$C=substr($rm26,2,1);
$D=substr($rm26,3,1);
$E=substr($rm26,4,1);
$F=substr($rm26,5,1);
$G=substr($rm26,6,1);
$H=substr($rm26,7,1);
$I=substr($rm26,8,1);
$J=substr($rm26,9,1);
$K=substr($rm26,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r27=sprintf('% 11s',$r27);
$A=substr($r27,0,1);
$B=substr($r27,1,1);
$C=substr($r27,2,1);
$D=substr($r27,3,1);
$E=substr($r27,4,1);
$F=substr($r27,5,1);
$G=substr($r27,6,1);
$H=substr($r27,7,1);
$I=substr($r27,8,1);
$J=substr($r27,9,1);
$K=substr($r27,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn27=sprintf('% 11s',$rn27);
$A=substr($rn27,0,1);
$B=substr($rn27,1,1);
$C=substr($rn27,2,1);
$D=substr($rn27,3,1);
$E=substr($rn27,4,1);
$F=substr($rn27,5,1);
$G=substr($rn27,6,1);
$H=substr($rn27,7,1);
$I=substr($rn27,8,1);
$J=substr($rn27,9,1);
$K=substr($rn27,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk27=sprintf('% 11s',$rk27);
$A=substr($rk27,0,1);
$B=substr($rk27,1,1);
$C=substr($rk27,2,1);
$D=substr($rk27,3,1);
$E=substr($rk27,4,1);
$F=substr($rk27,5,1);
$G=substr($rk27,6,1);
$H=substr($rk27,7,1);
$I=substr($rk27,8,1);
$J=substr($rk27,9,1);
$K=substr($rk27,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm27=sprintf('% 11s',$rm27);
$A=substr($rm27,0,1);
$B=substr($rm27,1,1);
$C=substr($rm27,2,1);
$D=substr($rm27,3,1);
$E=substr($rm27,4,1);
$F=substr($rm27,5,1);
$G=substr($rm27,6,1);
$H=substr($rm27,7,1);
$I=substr($rm27,8,1);
$J=substr($rm27,9,1);
$K=substr($rm27,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r28=sprintf('% 11s',$r28);
$A=substr($r28,0,1);
$B=substr($r28,1,1);
$C=substr($r28,2,1);
$D=substr($r28,3,1);
$E=substr($r28,4,1);
$F=substr($r28,5,1);
$G=substr($r28,6,1);
$H=substr($r28,7,1);
$I=substr($r28,8,1);
$J=substr($r28,9,1);
$K=substr($r28,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn28=sprintf('% 11s',$rn28);
$A=substr($rn28,0,1);
$B=substr($rn28,1,1);
$C=substr($rn28,2,1);
$D=substr($rn28,3,1);
$E=substr($rn28,4,1);
$F=substr($rn28,5,1);
$G=substr($rn28,6,1);
$H=substr($rn28,7,1);
$I=substr($rn28,8,1);
$J=substr($rn28,9,1);
$K=substr($rn28,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk28=sprintf('% 11s',$rk28);
$A=substr($rk28,0,1);
$B=substr($rk28,1,1);
$C=substr($rk28,2,1);
$D=substr($rk28,3,1);
$E=substr($rk28,4,1);
$F=substr($rk28,5,1);
$G=substr($rk28,6,1);
$H=substr($rk28,7,1);
$I=substr($rk28,8,1);
$J=substr($rk28,9,1);
$K=substr($rk28,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm28=sprintf('% 11s',$rm28);
$A=substr($rm28,0,1);
$B=substr($rm28,1,1);
$C=substr($rm28,2,1);
$D=substr($rm28,3,1);
$E=substr($rm28,4,1);
$F=substr($rm28,5,1);
$G=substr($rm28,6,1);
$H=substr($rm28,7,1);
$I=substr($rm28,8,1);
$J=substr($rm28,9,1);
$K=substr($rm28,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");


//koniec strana 3

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-4.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-4.jpg',12,12,186,274); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,6,"     ","$rmc",1,"L");

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

$pdf->Cell(72,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(3,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,16,"     ","$rmc",1,"L");


$pdf->Cell(48,6," ","$rmc",0,"R");
$r29=sprintf('% 11s',$r29);
$A=substr($r29,0,1);
$B=substr($r29,1,1);
$C=substr($r29,2,1);
$D=substr($r29,3,1);
$E=substr($r29,4,1);
$F=substr($r29,5,1);
$G=substr($r29,6,1);
$H=substr($r29,7,1);
$I=substr($r29,8,1);
$J=substr($r29,9,1);
$K=substr($r29,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn29=sprintf('% 11s',$rn29);
$A=substr($rn29,0,1);
$B=substr($rn29,1,1);
$C=substr($rn29,2,1);
$D=substr($rn29,3,1);
$E=substr($rn29,4,1);
$F=substr($rn29,5,1);
$G=substr($rn29,6,1);
$H=substr($rn29,7,1);
$I=substr($rn29,8,1);
$J=substr($rn29,9,1);
$K=substr($rn29,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk29=sprintf('% 11s',$rk29);
$A=substr($rk29,0,1);
$B=substr($rk29,1,1);
$C=substr($rk29,2,1);
$D=substr($rk29,3,1);
$E=substr($rk29,4,1);
$F=substr($rk29,5,1);
$G=substr($rk29,6,1);
$H=substr($rk29,7,1);
$I=substr($rk29,8,1);
$J=substr($rk29,9,1);
$K=substr($rk29,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm29=sprintf('% 11s',$rm29);
$A=substr($rm29,0,1);
$B=substr($rm29,1,1);
$C=substr($rm29,2,1);
$D=substr($rm29,3,1);
$E=substr($rm29,4,1);
$F=substr($rm29,5,1);
$G=substr($rm29,6,1);
$H=substr($rm29,7,1);
$I=substr($rm29,8,1);
$J=substr($rm29,9,1);
$K=substr($rm29,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r30=sprintf('% 11s',$r30);
$A=substr($r30,0,1);
$B=substr($r30,1,1);
$C=substr($r30,2,1);
$D=substr($r30,3,1);
$E=substr($r30,4,1);
$F=substr($r30,5,1);
$G=substr($r30,6,1);
$H=substr($r30,7,1);
$I=substr($r30,8,1);
$J=substr($r30,9,1);
$K=substr($r30,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn30=sprintf('% 11s',$rn30);
$A=substr($rn30,0,1);
$B=substr($rn30,1,1);
$C=substr($rn30,2,1);
$D=substr($rn30,3,1);
$E=substr($rn30,4,1);
$F=substr($rn30,5,1);
$G=substr($rn30,6,1);
$H=substr($rn30,7,1);
$I=substr($rn30,8,1);
$J=substr($rn30,9,1);
$K=substr($rn30,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk30=sprintf('% 11s',$rk30);
$A=substr($rk30,0,1);
$B=substr($rk30,1,1);
$C=substr($rk30,2,1);
$D=substr($rk30,3,1);
$E=substr($rk30,4,1);
$F=substr($rk30,5,1);
$G=substr($rk30,6,1);
$H=substr($rk30,7,1);
$I=substr($rk30,8,1);
$J=substr($rk30,9,1);
$K=substr($rk30,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm30=sprintf('% 11s',$rm30);
$A=substr($rm30,0,1);
$B=substr($rm30,1,1);
$C=substr($rm30,2,1);
$D=substr($rm30,3,1);
$E=substr($rm30,4,1);
$F=substr($rm30,5,1);
$G=substr($rm30,6,1);
$H=substr($rm30,7,1);
$I=substr($rm30,8,1);
$J=substr($rm30,9,1);
$K=substr($rm30,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r31=sprintf('% 11s',$r31);
$A=substr($r31,0,1);
$B=substr($r31,1,1);
$C=substr($r31,2,1);
$D=substr($r31,3,1);
$E=substr($r31,4,1);
$F=substr($r31,5,1);
$G=substr($r31,6,1);
$H=substr($r31,7,1);
$I=substr($r31,8,1);
$J=substr($r31,9,1);
$K=substr($r31,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn31=sprintf('% 11s',$rn31);
$A=substr($rn31,0,1);
$B=substr($rn31,1,1);
$C=substr($rn31,2,1);
$D=substr($rn31,3,1);
$E=substr($rn31,4,1);
$F=substr($rn31,5,1);
$G=substr($rn31,6,1);
$H=substr($rn31,7,1);
$I=substr($rn31,8,1);
$J=substr($rn31,9,1);
$K=substr($rn31,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk31=sprintf('% 11s',$rk31);
$A=substr($rk31,0,1);
$B=substr($rk31,1,1);
$C=substr($rk31,2,1);
$D=substr($rk31,3,1);
$E=substr($rk31,4,1);
$F=substr($rk31,5,1);
$G=substr($rk31,6,1);
$H=substr($rk31,7,1);
$I=substr($rk31,8,1);
$J=substr($rk31,9,1);
$K=substr($rk31,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm31=sprintf('% 11s',$rm31);
$A=substr($rm31,0,1);
$B=substr($rm31,1,1);
$C=substr($rm31,2,1);
$D=substr($rm31,3,1);
$E=substr($rm31,4,1);
$F=substr($rm31,5,1);
$G=substr($rm31,6,1);
$H=substr($rm31,7,1);
$I=substr($rm31,8,1);
$J=substr($rm31,9,1);
$K=substr($rm31,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r32=sprintf('% 11s',$r32);
$A=substr($r32,0,1);
$B=substr($r32,1,1);
$C=substr($r32,2,1);
$D=substr($r32,3,1);
$E=substr($r32,4,1);
$F=substr($r32,5,1);
$G=substr($r32,6,1);
$H=substr($r32,7,1);
$I=substr($r32,8,1);
$J=substr($r32,9,1);
$K=substr($r32,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn32=sprintf('% 11s',$rn32);
$A=substr($rn32,0,1);
$B=substr($rn32,1,1);
$C=substr($rn32,2,1);
$D=substr($rn32,3,1);
$E=substr($rn32,4,1);
$F=substr($rn32,5,1);
$G=substr($rn32,6,1);
$H=substr($rn32,7,1);
$I=substr($rn32,8,1);
$J=substr($rn32,9,1);
$K=substr($rn32,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk32=sprintf('% 11s',$rk32);
$A=substr($rk32,0,1);
$B=substr($rk32,1,1);
$C=substr($rk32,2,1);
$D=substr($rk32,3,1);
$E=substr($rk32,4,1);
$F=substr($rk32,5,1);
$G=substr($rk32,6,1);
$H=substr($rk32,7,1);
$I=substr($rk32,8,1);
$J=substr($rk32,9,1);
$K=substr($rk32,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm32=sprintf('% 11s',$rm32);
$A=substr($rm32,0,1);
$B=substr($rm32,1,1);
$C=substr($rm32,2,1);
$D=substr($rm32,3,1);
$E=substr($rm32,4,1);
$F=substr($rm32,5,1);
$G=substr($rm32,6,1);
$H=substr($rm32,7,1);
$I=substr($rm32,8,1);
$J=substr($rm32,9,1);
$K=substr($rm32,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r33=sprintf('% 11s',$r33);
$A=substr($r33,0,1);
$B=substr($r33,1,1);
$C=substr($r33,2,1);
$D=substr($r33,3,1);
$E=substr($r33,4,1);
$F=substr($r33,5,1);
$G=substr($r33,6,1);
$H=substr($r33,7,1);
$I=substr($r33,8,1);
$J=substr($r33,9,1);
$K=substr($r33,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn33=sprintf('% 11s',$rn33);
$A=substr($rn33,0,1);
$B=substr($rn33,1,1);
$C=substr($rn33,2,1);
$D=substr($rn33,3,1);
$E=substr($rn33,4,1);
$F=substr($rn33,5,1);
$G=substr($rn33,6,1);
$H=substr($rn33,7,1);
$I=substr($rn33,8,1);
$J=substr($rn33,9,1);
$K=substr($rn33,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk33=sprintf('% 11s',$rk33);
$A=substr($rk33,0,1);
$B=substr($rk33,1,1);
$C=substr($rk33,2,1);
$D=substr($rk33,3,1);
$E=substr($rk33,4,1);
$F=substr($rk33,5,1);
$G=substr($rk33,6,1);
$H=substr($rk33,7,1);
$I=substr($rk33,8,1);
$J=substr($rk33,9,1);
$K=substr($rk33,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm33=sprintf('% 11s',$rm33);
$A=substr($rm33,0,1);
$B=substr($rm33,1,1);
$C=substr($rm33,2,1);
$D=substr($rm33,3,1);
$E=substr($rm33,4,1);
$F=substr($rm33,5,1);
$G=substr($rm33,6,1);
$H=substr($rm33,7,1);
$I=substr($rm33,8,1);
$J=substr($rm33,9,1);
$K=substr($rm33,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r34=sprintf('% 11s',$r34);
$A=substr($r34,0,1);
$B=substr($r34,1,1);
$C=substr($r34,2,1);
$D=substr($r34,3,1);
$E=substr($r34,4,1);
$F=substr($r34,5,1);
$G=substr($r34,6,1);
$H=substr($r34,7,1);
$I=substr($r34,8,1);
$J=substr($r34,9,1);
$K=substr($r34,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn34=sprintf('% 11s',$rn34);
$A=substr($rn34,0,1);
$B=substr($rn34,1,1);
$C=substr($rn34,2,1);
$D=substr($rn34,3,1);
$E=substr($rn34,4,1);
$F=substr($rn34,5,1);
$G=substr($rn34,6,1);
$H=substr($rn34,7,1);
$I=substr($rn34,8,1);
$J=substr($rn34,9,1);
$K=substr($rn34,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk34=sprintf('% 11s',$rk34);
$A=substr($rk34,0,1);
$B=substr($rk34,1,1);
$C=substr($rk34,2,1);
$D=substr($rk34,3,1);
$E=substr($rk34,4,1);
$F=substr($rk34,5,1);
$G=substr($rk34,6,1);
$H=substr($rk34,7,1);
$I=substr($rk34,8,1);
$J=substr($rk34,9,1);
$K=substr($rk34,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm34=sprintf('% 11s',$rm34);
$A=substr($rm34,0,1);
$B=substr($rm34,1,1);
$C=substr($rm34,2,1);
$D=substr($rm34,3,1);
$E=substr($rm34,4,1);
$F=substr($rm34,5,1);
$G=substr($rm34,6,1);
$H=substr($rm34,7,1);
$I=substr($rm34,8,1);
$J=substr($rm34,9,1);
$K=substr($rm34,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r35=sprintf('% 11s',$r35);
$A=substr($r35,0,1);
$B=substr($r35,1,1);
$C=substr($r35,2,1);
$D=substr($r35,3,1);
$E=substr($r35,4,1);
$F=substr($r35,5,1);
$G=substr($r35,6,1);
$H=substr($r35,7,1);
$I=substr($r35,8,1);
$J=substr($r35,9,1);
$K=substr($r35,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn35=sprintf('% 11s',$rn35);
$A=substr($rn35,0,1);
$B=substr($rn35,1,1);
$C=substr($rn35,2,1);
$D=substr($rn35,3,1);
$E=substr($rn35,4,1);
$F=substr($rn35,5,1);
$G=substr($rn35,6,1);
$H=substr($rn35,7,1);
$I=substr($rn35,8,1);
$J=substr($rn35,9,1);
$K=substr($rn35,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk35=sprintf('% 11s',$rk35);
$A=substr($rk35,0,1);
$B=substr($rk35,1,1);
$C=substr($rk35,2,1);
$D=substr($rk35,3,1);
$E=substr($rk35,4,1);
$F=substr($rk35,5,1);
$G=substr($rk35,6,1);
$H=substr($rk35,7,1);
$I=substr($rk35,8,1);
$J=substr($rk35,9,1);
$K=substr($rk35,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm35=sprintf('% 11s',$rm35);
$A=substr($rm35,0,1);
$B=substr($rm35,1,1);
$C=substr($rm35,2,1);
$D=substr($rm35,3,1);
$E=substr($rm35,4,1);
$F=substr($rm35,5,1);
$G=substr($rm35,6,1);
$H=substr($rm35,7,1);
$I=substr($rm35,8,1);
$J=substr($rm35,9,1);
$K=substr($rm35,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r36=sprintf('% 11s',$r36);
$A=substr($r36,0,1);
$B=substr($r36,1,1);
$C=substr($r36,2,1);
$D=substr($r36,3,1);
$E=substr($r36,4,1);
$F=substr($r36,5,1);
$G=substr($r36,6,1);
$H=substr($r36,7,1);
$I=substr($r36,8,1);
$J=substr($r36,9,1);
$K=substr($r36,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn36=sprintf('% 11s',$rn36);
$A=substr($rn36,0,1);
$B=substr($rn36,1,1);
$C=substr($rn36,2,1);
$D=substr($rn36,3,1);
$E=substr($rn36,4,1);
$F=substr($rn36,5,1);
$G=substr($rn36,6,1);
$H=substr($rn36,7,1);
$I=substr($rn36,8,1);
$J=substr($rn36,9,1);
$K=substr($rn36,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk36=sprintf('% 11s',$rk36);
$A=substr($rk36,0,1);
$B=substr($rk36,1,1);
$C=substr($rk36,2,1);
$D=substr($rk36,3,1);
$E=substr($rk36,4,1);
$F=substr($rk36,5,1);
$G=substr($rk36,6,1);
$H=substr($rk36,7,1);
$I=substr($rk36,8,1);
$J=substr($rk36,9,1);
$K=substr($rk36,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm36=sprintf('% 11s',$rm36);
$A=substr($rm36,0,1);
$B=substr($rm36,1,1);
$C=substr($rm36,2,1);
$D=substr($rm36,3,1);
$E=substr($rm36,4,1);
$F=substr($rm36,5,1);
$G=substr($rm36,6,1);
$H=substr($rm36,7,1);
$I=substr($rm36,8,1);
$J=substr($rm36,9,1);
$K=substr($rm36,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r37=sprintf('% 11s',$r37);
$A=substr($r37,0,1);
$B=substr($r37,1,1);
$C=substr($r37,2,1);
$D=substr($r37,3,1);
$E=substr($r37,4,1);
$F=substr($r37,5,1);
$G=substr($r37,6,1);
$H=substr($r37,7,1);
$I=substr($r37,8,1);
$J=substr($r37,9,1);
$K=substr($r37,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn37=sprintf('% 11s',$rn37);
$A=substr($rn37,0,1);
$B=substr($rn37,1,1);
$C=substr($rn37,2,1);
$D=substr($rn37,3,1);
$E=substr($rn37,4,1);
$F=substr($rn37,5,1);
$G=substr($rn37,6,1);
$H=substr($rn37,7,1);
$I=substr($rn37,8,1);
$J=substr($rn37,9,1);
$K=substr($rn37,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk37=sprintf('% 11s',$rk37);
$A=substr($rk37,0,1);
$B=substr($rk37,1,1);
$C=substr($rk37,2,1);
$D=substr($rk37,3,1);
$E=substr($rk37,4,1);
$F=substr($rk37,5,1);
$G=substr($rk37,6,1);
$H=substr($rk37,7,1);
$I=substr($rk37,8,1);
$J=substr($rk37,9,1);
$K=substr($rk37,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm37=sprintf('% 11s',$rm37);
$A=substr($rm37,0,1);
$B=substr($rm37,1,1);
$C=substr($rm37,2,1);
$D=substr($rm37,3,1);
$E=substr($rm37,4,1);
$F=substr($rm37,5,1);
$G=substr($rm37,6,1);
$H=substr($rm37,7,1);
$I=substr($rm37,8,1);
$J=substr($rm37,9,1);
$K=substr($rm37,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r38=sprintf('% 11s',$r38);
$A=substr($r38,0,1);
$B=substr($r38,1,1);
$C=substr($r38,2,1);
$D=substr($r38,3,1);
$E=substr($r38,4,1);
$F=substr($r38,5,1);
$G=substr($r38,6,1);
$H=substr($r38,7,1);
$I=substr($r38,8,1);
$J=substr($r38,9,1);
$K=substr($r38,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn38=sprintf('% 11s',$rn38);
$A=substr($rn38,0,1);
$B=substr($rn38,1,1);
$C=substr($rn38,2,1);
$D=substr($rn38,3,1);
$E=substr($rn38,4,1);
$F=substr($rn38,5,1);
$G=substr($rn38,6,1);
$H=substr($rn38,7,1);
$I=substr($rn38,8,1);
$J=substr($rn38,9,1);
$K=substr($rn38,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk38=sprintf('% 11s',$rk38);
$A=substr($rk38,0,1);
$B=substr($rk38,1,1);
$C=substr($rk38,2,1);
$D=substr($rk38,3,1);
$E=substr($rk38,4,1);
$F=substr($rk38,5,1);
$G=substr($rk38,6,1);
$H=substr($rk38,7,1);
$I=substr($rk38,8,1);
$J=substr($rk38,9,1);
$K=substr($rk38,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm38=sprintf('% 11s',$rm38);
$A=substr($rm38,0,1);
$B=substr($rm38,1,1);
$C=substr($rm38,2,1);
$D=substr($rm38,3,1);
$E=substr($rm38,4,1);
$F=substr($rm38,5,1);
$G=substr($rm38,6,1);
$H=substr($rm38,7,1);
$I=substr($rm38,8,1);
$J=substr($rm38,9,1);
$K=substr($rm38,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r39=sprintf('% 11s',$r39);
$A=substr($r39,0,1);
$B=substr($r39,1,1);
$C=substr($r39,2,1);
$D=substr($r39,3,1);
$E=substr($r39,4,1);
$F=substr($r39,5,1);
$G=substr($r39,6,1);
$H=substr($r39,7,1);
$I=substr($r39,8,1);
$J=substr($r39,9,1);
$K=substr($r39,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn39=sprintf('% 11s',$rn39);
$A=substr($rn39,0,1);
$B=substr($rn39,1,1);
$C=substr($rn39,2,1);
$D=substr($rn39,3,1);
$E=substr($rn39,4,1);
$F=substr($rn39,5,1);
$G=substr($rn39,6,1);
$H=substr($rn39,7,1);
$I=substr($rn39,8,1);
$J=substr($rn39,9,1);
$K=substr($rn39,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk39=sprintf('% 11s',$rk39);
$A=substr($rk39,0,1);
$B=substr($rk39,1,1);
$C=substr($rk39,2,1);
$D=substr($rk39,3,1);
$E=substr($rk39,4,1);
$F=substr($rk39,5,1);
$G=substr($rk39,6,1);
$H=substr($rk39,7,1);
$I=substr($rk39,8,1);
$J=substr($rk39,9,1);
$K=substr($rk39,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm39=sprintf('% 11s',$rm39);
$A=substr($rm39,0,1);
$B=substr($rm39,1,1);
$C=substr($rm39,2,1);
$D=substr($rm39,3,1);
$E=substr($rm39,4,1);
$F=substr($rm39,5,1);
$G=substr($rm39,6,1);
$H=substr($rm39,7,1);
$I=substr($rm39,8,1);
$J=substr($rm39,9,1);
$K=substr($rm39,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r40=sprintf('% 11s',$r40);
$A=substr($r40,0,1);
$B=substr($r40,1,1);
$C=substr($r40,2,1);
$D=substr($r40,3,1);
$E=substr($r40,4,1);
$F=substr($r40,5,1);
$G=substr($r40,6,1);
$H=substr($r40,7,1);
$I=substr($r40,8,1);
$J=substr($r40,9,1);
$K=substr($r40,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn40=sprintf('% 11s',$rn40);
$A=substr($rn40,0,1);
$B=substr($rn40,1,1);
$C=substr($rn40,2,1);
$D=substr($rn40,3,1);
$E=substr($rn40,4,1);
$F=substr($rn40,5,1);
$G=substr($rn40,6,1);
$H=substr($rn40,7,1);
$I=substr($rn40,8,1);
$J=substr($rn40,9,1);
$K=substr($rn40,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk40=sprintf('% 11s',$rk40);
$A=substr($rk40,0,1);
$B=substr($rk40,1,1);
$C=substr($rk40,2,1);
$D=substr($rk40,3,1);
$E=substr($rk40,4,1);
$F=substr($rk40,5,1);
$G=substr($rk40,6,1);
$H=substr($rk40,7,1);
$I=substr($rk40,8,1);
$J=substr($rk40,9,1);
$K=substr($rk40,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm40=sprintf('% 11s',$rm40);
$A=substr($rm40,0,1);
$B=substr($rm40,1,1);
$C=substr($rm40,2,1);
$D=substr($rm40,3,1);
$E=substr($rm40,4,1);
$F=substr($rm40,5,1);
$G=substr($rm40,6,1);
$H=substr($rm40,7,1);
$I=substr($rm40,8,1);
$J=substr($rm40,9,1);
$K=substr($rm40,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r41=sprintf('% 11s',$r41);
$A=substr($r41,0,1);
$B=substr($r41,1,1);
$C=substr($r41,2,1);
$D=substr($r41,3,1);
$E=substr($r41,4,1);
$F=substr($r41,5,1);
$G=substr($r41,6,1);
$H=substr($r41,7,1);
$I=substr($r41,8,1);
$J=substr($r41,9,1);
$K=substr($r41,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn41=sprintf('% 11s',$rn41);
$A=substr($rn41,0,1);
$B=substr($rn41,1,1);
$C=substr($rn41,2,1);
$D=substr($rn41,3,1);
$E=substr($rn41,4,1);
$F=substr($rn41,5,1);
$G=substr($rn41,6,1);
$H=substr($rn41,7,1);
$I=substr($rn41,8,1);
$J=substr($rn41,9,1);
$K=substr($rn41,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk41=sprintf('% 11s',$rk41);
$A=substr($rk41,0,1);
$B=substr($rk41,1,1);
$C=substr($rk41,2,1);
$D=substr($rk41,3,1);
$E=substr($rk41,4,1);
$F=substr($rk41,5,1);
$G=substr($rk41,6,1);
$H=substr($rk41,7,1);
$I=substr($rk41,8,1);
$J=substr($rk41,9,1);
$K=substr($rk41,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm41=sprintf('% 11s',$rm41);
$A=substr($rm41,0,1);
$B=substr($rm41,1,1);
$C=substr($rm41,2,1);
$D=substr($rm41,3,1);
$E=substr($rm41,4,1);
$F=substr($rm41,5,1);
$G=substr($rm41,6,1);
$H=substr($rm41,7,1);
$I=substr($rm41,8,1);
$J=substr($rm41,9,1);
$K=substr($rm41,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$r42=sprintf('% 11s',$r42);
$A=substr($r42,0,1);
$B=substr($r42,1,1);
$C=substr($r42,2,1);
$D=substr($r42,3,1);
$E=substr($r42,4,1);
$F=substr($r42,5,1);
$G=substr($r42,6,1);
$H=substr($r42,7,1);
$I=substr($r42,8,1);
$J=substr($r42,9,1);
$K=substr($r42,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn42=sprintf('% 11s',$rn42);
$A=substr($rn42,0,1);
$B=substr($rn42,1,1);
$C=substr($rn42,2,1);
$D=substr($rn42,3,1);
$E=substr($rn42,4,1);
$F=substr($rn42,5,1);
$G=substr($rn42,6,1);
$H=substr($rn42,7,1);
$I=substr($rn42,8,1);
$J=substr($rn42,9,1);
$K=substr($rn42,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(48,6," ","$rmc",0,"R");
$rk42=sprintf('% 11s',$rk42);
$A=substr($rk42,0,1);
$B=substr($rk42,1,1);
$C=substr($rk42,2,1);
$D=substr($rk42,3,1);
$E=substr($rk42,4,1);
$F=substr($rk42,5,1);
$G=substr($rk42,6,1);
$H=substr($rk42,7,1);
$I=substr($rk42,8,1);
$J=substr($rk42,9,1);
$K=substr($rk42,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm42=sprintf('% 11s',$rm42);
$A=substr($rm42,0,1);
$B=substr($rm42,1,1);
$C=substr($rm42,2,1);
$D=substr($rm42,3,1);
$E=substr($rm42,4,1);
$F=substr($rm42,5,1);
$G=substr($rm42,6,1);
$H=substr($rm42,7,1);
$I=substr($rm42,8,1);
$J=substr($rm42,9,1);
$K=substr($rm42,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");



//koniec strana 4

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-5.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-5.jpg',13,12,187,274); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,6,"     ","$rmc",1,"L");

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

$pdf->Cell(73,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,16,"     ","$rmc",1,"L");

$pdf->Cell(50,6," ","$rmc",0,"R");
$r43=sprintf('% 11s',$r43);
$A=substr($r43,0,1);
$B=substr($r43,1,1);
$C=substr($r43,2,1);
$D=substr($r43,3,1);
$E=substr($r43,4,1);
$F=substr($r43,5,1);
$G=substr($r43,6,1);
$H=substr($r43,7,1);
$I=substr($r43,8,1);
$J=substr($r43,9,1);
$K=substr($r43,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn43=sprintf('% 11s',$rn43);
$A=substr($rn43,0,1);
$B=substr($rn43,1,1);
$C=substr($rn43,2,1);
$D=substr($rn43,3,1);
$E=substr($rn43,4,1);
$F=substr($rn43,5,1);
$G=substr($rn43,6,1);
$H=substr($rn43,7,1);
$I=substr($rn43,8,1);
$J=substr($rn43,9,1);
$K=substr($rn43,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk43=sprintf('% 11s',$rk43);
$A=substr($rk43,0,1);
$B=substr($rk43,1,1);
$C=substr($rk43,2,1);
$D=substr($rk43,3,1);
$E=substr($rk43,4,1);
$F=substr($rk43,5,1);
$G=substr($rk43,6,1);
$H=substr($rk43,7,1);
$I=substr($rk43,8,1);
$J=substr($rk43,9,1);
$K=substr($rk43,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm43=sprintf('% 11s',$rm43);
$A=substr($rm43,0,1);
$B=substr($rm43,1,1);
$C=substr($rm43,2,1);
$D=substr($rm43,3,1);
$E=substr($rm43,4,1);
$F=substr($rm43,5,1);
$G=substr($rm43,6,1);
$H=substr($rm43,7,1);
$I=substr($rm43,8,1);
$J=substr($rm43,9,1);
$K=substr($rm43,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r44=sprintf('% 11s',$r44);
$A=substr($r44,0,1);
$B=substr($r44,1,1);
$C=substr($r44,2,1);
$D=substr($r44,3,1);
$E=substr($r44,4,1);
$F=substr($r44,5,1);
$G=substr($r44,6,1);
$H=substr($r44,7,1);
$I=substr($r44,8,1);
$J=substr($r44,9,1);
$K=substr($r44,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn44=sprintf('% 11s',$rn44);
$A=substr($rn44,0,1);
$B=substr($rn44,1,1);
$C=substr($rn44,2,1);
$D=substr($rn44,3,1);
$E=substr($rn44,4,1);
$F=substr($rn44,5,1);
$G=substr($rn44,6,1);
$H=substr($rn44,7,1);
$I=substr($rn44,8,1);
$J=substr($rn44,9,1);
$K=substr($rn44,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk44=sprintf('% 11s',$rk44);
$A=substr($rk44,0,1);
$B=substr($rk44,1,1);
$C=substr($rk44,2,1);
$D=substr($rk44,3,1);
$E=substr($rk44,4,1);
$F=substr($rk44,5,1);
$G=substr($rk44,6,1);
$H=substr($rk44,7,1);
$I=substr($rk44,8,1);
$J=substr($rk44,9,1);
$K=substr($rk44,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm44=sprintf('% 11s',$rm44);
$A=substr($rm44,0,1);
$B=substr($rm44,1,1);
$C=substr($rm44,2,1);
$D=substr($rm44,3,1);
$E=substr($rm44,4,1);
$F=substr($rm44,5,1);
$G=substr($rm44,6,1);
$H=substr($rm44,7,1);
$I=substr($rm44,8,1);
$J=substr($rm44,9,1);
$K=substr($rm44,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r45=sprintf('% 11s',$r45);
$A=substr($r45,0,1);
$B=substr($r45,1,1);
$C=substr($r45,2,1);
$D=substr($r45,3,1);
$E=substr($r45,4,1);
$F=substr($r45,5,1);
$G=substr($r45,6,1);
$H=substr($r45,7,1);
$I=substr($r45,8,1);
$J=substr($r45,9,1);
$K=substr($r45,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn45=sprintf('% 11s',$rn45);
$A=substr($rn45,0,1);
$B=substr($rn45,1,1);
$C=substr($rn45,2,1);
$D=substr($rn45,3,1);
$E=substr($rn45,4,1);
$F=substr($rn45,5,1);
$G=substr($rn45,6,1);
$H=substr($rn45,7,1);
$I=substr($rn45,8,1);
$J=substr($rn45,9,1);
$K=substr($rn45,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk45=sprintf('% 11s',$rk45);
$A=substr($rk45,0,1);
$B=substr($rk45,1,1);
$C=substr($rk45,2,1);
$D=substr($rk45,3,1);
$E=substr($rk45,4,1);
$F=substr($rk45,5,1);
$G=substr($rk45,6,1);
$H=substr($rk45,7,1);
$I=substr($rk45,8,1);
$J=substr($rk45,9,1);
$K=substr($rk45,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm45=sprintf('% 11s',$rm45);
$A=substr($rm45,0,1);
$B=substr($rm45,1,1);
$C=substr($rm45,2,1);
$D=substr($rm45,3,1);
$E=substr($rm45,4,1);
$F=substr($rm45,5,1);
$G=substr($rm45,6,1);
$H=substr($rm45,7,1);
$I=substr($rm45,8,1);
$J=substr($rm45,9,1);
$K=substr($rm45,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r46=sprintf('% 11s',$r46);
$A=substr($r46,0,1);
$B=substr($r46,1,1);
$C=substr($r46,2,1);
$D=substr($r46,3,1);
$E=substr($r46,4,1);
$F=substr($r46,5,1);
$G=substr($r46,6,1);
$H=substr($r46,7,1);
$I=substr($r46,8,1);
$J=substr($r46,9,1);
$K=substr($r46,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn46=sprintf('% 11s',$rn46);
$A=substr($rn46,0,1);
$B=substr($rn46,1,1);
$C=substr($rn46,2,1);
$D=substr($rn46,3,1);
$E=substr($rn46,4,1);
$F=substr($rn46,5,1);
$G=substr($rn46,6,1);
$H=substr($rn46,7,1);
$I=substr($rn46,8,1);
$J=substr($rn46,9,1);
$K=substr($rn46,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk46=sprintf('% 11s',$rk46);
$A=substr($rk46,0,1);
$B=substr($rk46,1,1);
$C=substr($rk46,2,1);
$D=substr($rk46,3,1);
$E=substr($rk46,4,1);
$F=substr($rk46,5,1);
$G=substr($rk46,6,1);
$H=substr($rk46,7,1);
$I=substr($rk46,8,1);
$J=substr($rk46,9,1);
$K=substr($rk46,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm46=sprintf('% 11s',$rm46);
$A=substr($rm46,0,1);
$B=substr($rm46,1,1);
$C=substr($rm46,2,1);
$D=substr($rm46,3,1);
$E=substr($rm46,4,1);
$F=substr($rm46,5,1);
$G=substr($rm46,6,1);
$H=substr($rm46,7,1);
$I=substr($rm46,8,1);
$J=substr($rm46,9,1);
$K=substr($rm46,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r47=sprintf('% 11s',$r47);
$A=substr($r47,0,1);
$B=substr($r47,1,1);
$C=substr($r47,2,1);
$D=substr($r47,3,1);
$E=substr($r47,4,1);
$F=substr($r47,5,1);
$G=substr($r47,6,1);
$H=substr($r47,7,1);
$I=substr($r47,8,1);
$J=substr($r47,9,1);
$K=substr($r47,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn47=sprintf('% 11s',$rn47);
$A=substr($rn47,0,1);
$B=substr($rn47,1,1);
$C=substr($rn47,2,1);
$D=substr($rn47,3,1);
$E=substr($rn47,4,1);
$F=substr($rn47,5,1);
$G=substr($rn47,6,1);
$H=substr($rn47,7,1);
$I=substr($rn47,8,1);
$J=substr($rn47,9,1);
$K=substr($rn47,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk47=sprintf('% 11s',$rk47);
$A=substr($rk47,0,1);
$B=substr($rk47,1,1);
$C=substr($rk47,2,1);
$D=substr($rk47,3,1);
$E=substr($rk47,4,1);
$F=substr($rk47,5,1);
$G=substr($rk47,6,1);
$H=substr($rk47,7,1);
$I=substr($rk47,8,1);
$J=substr($rk47,9,1);
$K=substr($rk47,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm47=sprintf('% 11s',$rm47);
$A=substr($rm47,0,1);
$B=substr($rm47,1,1);
$C=substr($rm47,2,1);
$D=substr($rm47,3,1);
$E=substr($rm47,4,1);
$F=substr($rm47,5,1);
$G=substr($rm47,6,1);
$H=substr($rm47,7,1);
$I=substr($rm47,8,1);
$J=substr($rm47,9,1);
$K=substr($rm47,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r48=sprintf('% 11s',$r48);
$A=substr($r48,0,1);
$B=substr($r48,1,1);
$C=substr($r48,2,1);
$D=substr($r48,3,1);
$E=substr($r48,4,1);
$F=substr($r48,5,1);
$G=substr($r48,6,1);
$H=substr($r48,7,1);
$I=substr($r48,8,1);
$J=substr($r48,9,1);
$K=substr($r48,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn48=sprintf('% 11s',$rn48);
$A=substr($rn48,0,1);
$B=substr($rn48,1,1);
$C=substr($rn48,2,1);
$D=substr($rn48,3,1);
$E=substr($rn48,4,1);
$F=substr($rn48,5,1);
$G=substr($rn48,6,1);
$H=substr($rn48,7,1);
$I=substr($rn48,8,1);
$J=substr($rn48,9,1);
$K=substr($rn48,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk48=sprintf('% 11s',$rk48);
$A=substr($rk48,0,1);
$B=substr($rk48,1,1);
$C=substr($rk48,2,1);
$D=substr($rk48,3,1);
$E=substr($rk48,4,1);
$F=substr($rk48,5,1);
$G=substr($rk48,6,1);
$H=substr($rk48,7,1);
$I=substr($rk48,8,1);
$J=substr($rk48,9,1);
$K=substr($rk48,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm48=sprintf('% 11s',$rm48);
$A=substr($rm48,0,1);
$B=substr($rm48,1,1);
$C=substr($rm48,2,1);
$D=substr($rm48,3,1);
$E=substr($rm48,4,1);
$F=substr($rm48,5,1);
$G=substr($rm48,6,1);
$H=substr($rm48,7,1);
$I=substr($rm48,8,1);
$J=substr($rm48,9,1);
$K=substr($rm48,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r49=sprintf('% 11s',$r49);
$A=substr($r49,0,1);
$B=substr($r49,1,1);
$C=substr($r49,2,1);
$D=substr($r49,3,1);
$E=substr($r49,4,1);
$F=substr($r49,5,1);
$G=substr($r49,6,1);
$H=substr($r49,7,1);
$I=substr($r49,8,1);
$J=substr($r49,9,1);
$K=substr($r49,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn49=sprintf('% 11s',$rn49);
$A=substr($rn49,0,1);
$B=substr($rn49,1,1);
$C=substr($rn49,2,1);
$D=substr($rn49,3,1);
$E=substr($rn49,4,1);
$F=substr($rn49,5,1);
$G=substr($rn49,6,1);
$H=substr($rn49,7,1);
$I=substr($rn49,8,1);
$J=substr($rn49,9,1);
$K=substr($rn49,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk49=sprintf('% 11s',$rk49);
$A=substr($rk49,0,1);
$B=substr($rk49,1,1);
$C=substr($rk49,2,1);
$D=substr($rk49,3,1);
$E=substr($rk49,4,1);
$F=substr($rk49,5,1);
$G=substr($rk49,6,1);
$H=substr($rk49,7,1);
$I=substr($rk49,8,1);
$J=substr($rk49,9,1);
$K=substr($rk49,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm49=sprintf('% 11s',$rm49);
$A=substr($rm49,0,1);
$B=substr($rm49,1,1);
$C=substr($rm49,2,1);
$D=substr($rm49,3,1);
$E=substr($rm49,4,1);
$F=substr($rm49,5,1);
$G=substr($rm49,6,1);
$H=substr($rm49,7,1);
$I=substr($rm49,8,1);
$J=substr($rm49,9,1);
$K=substr($rm49,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r50=sprintf('% 11s',$r50);
$A=substr($r50,0,1);
$B=substr($r50,1,1);
$C=substr($r50,2,1);
$D=substr($r50,3,1);
$E=substr($r50,4,1);
$F=substr($r50,5,1);
$G=substr($r50,6,1);
$H=substr($r50,7,1);
$I=substr($r50,8,1);
$J=substr($r50,9,1);
$K=substr($r50,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn50=sprintf('% 11s',$rn50);
$A=substr($rn50,0,1);
$B=substr($rn50,1,1);
$C=substr($rn50,2,1);
$D=substr($rn50,3,1);
$E=substr($rn50,4,1);
$F=substr($rn50,5,1);
$G=substr($rn50,6,1);
$H=substr($rn50,7,1);
$I=substr($rn50,8,1);
$J=substr($rn50,9,1);
$K=substr($rn50,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk50=sprintf('% 11s',$rk50);
$A=substr($rk50,0,1);
$B=substr($rk50,1,1);
$C=substr($rk50,2,1);
$D=substr($rk50,3,1);
$E=substr($rk50,4,1);
$F=substr($rk50,5,1);
$G=substr($rk50,6,1);
$H=substr($rk50,7,1);
$I=substr($rk50,8,1);
$J=substr($rk50,9,1);
$K=substr($rk50,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm50=sprintf('% 11s',$rm50);
$A=substr($rm50,0,1);
$B=substr($rm50,1,1);
$C=substr($rm50,2,1);
$D=substr($rm50,3,1);
$E=substr($rm50,4,1);
$F=substr($rm50,5,1);
$G=substr($rm50,6,1);
$H=substr($rm50,7,1);
$I=substr($rm50,8,1);
$J=substr($rm50,9,1);
$K=substr($rm50,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r51=sprintf('% 11s',$r51);
$A=substr($r51,0,1);
$B=substr($r51,1,1);
$C=substr($r51,2,1);
$D=substr($r51,3,1);
$E=substr($r51,4,1);
$F=substr($r51,5,1);
$G=substr($r51,6,1);
$H=substr($r51,7,1);
$I=substr($r51,8,1);
$J=substr($r51,9,1);
$K=substr($r51,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn51=sprintf('% 11s',$rn51);
$A=substr($rn51,0,1);
$B=substr($rn51,1,1);
$C=substr($rn51,2,1);
$D=substr($rn51,3,1);
$E=substr($rn51,4,1);
$F=substr($rn51,5,1);
$G=substr($rn51,6,1);
$H=substr($rn51,7,1);
$I=substr($rn51,8,1);
$J=substr($rn51,9,1);
$K=substr($rn51,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk51=sprintf('% 11s',$rk51);
$A=substr($rk51,0,1);
$B=substr($rk51,1,1);
$C=substr($rk51,2,1);
$D=substr($rk51,3,1);
$E=substr($rk51,4,1);
$F=substr($rk51,5,1);
$G=substr($rk51,6,1);
$H=substr($rk51,7,1);
$I=substr($rk51,8,1);
$J=substr($rk51,9,1);
$K=substr($rk51,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm51=sprintf('% 11s',$rm51);
$A=substr($rm51,0,1);
$B=substr($rm51,1,1);
$C=substr($rm51,2,1);
$D=substr($rm51,3,1);
$E=substr($rm51,4,1);
$F=substr($rm51,5,1);
$G=substr($rm51,6,1);
$H=substr($rm51,7,1);
$I=substr($rm51,8,1);
$J=substr($rm51,9,1);
$K=substr($rm51,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r52=sprintf('% 11s',$r52);
$A=substr($r52,0,1);
$B=substr($r52,1,1);
$C=substr($r52,2,1);
$D=substr($r52,3,1);
$E=substr($r52,4,1);
$F=substr($r52,5,1);
$G=substr($r52,6,1);
$H=substr($r52,7,1);
$I=substr($r52,8,1);
$J=substr($r52,9,1);
$K=substr($r52,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn52=sprintf('% 11s',$rn52);
$A=substr($rn52,0,1);
$B=substr($rn52,1,1);
$C=substr($rn52,2,1);
$D=substr($rn52,3,1);
$E=substr($rn52,4,1);
$F=substr($rn52,5,1);
$G=substr($rn52,6,1);
$H=substr($rn52,7,1);
$I=substr($rn52,8,1);
$J=substr($rn52,9,1);
$K=substr($rn52,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk52=sprintf('% 11s',$rk52);
$A=substr($rk52,0,1);
$B=substr($rk52,1,1);
$C=substr($rk52,2,1);
$D=substr($rk52,3,1);
$E=substr($rk52,4,1);
$F=substr($rk52,5,1);
$G=substr($rk52,6,1);
$H=substr($rk52,7,1);
$I=substr($rk52,8,1);
$J=substr($rk52,9,1);
$K=substr($rk52,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm52=sprintf('% 11s',$rm52);
$A=substr($rm52,0,1);
$B=substr($rm52,1,1);
$C=substr($rm52,2,1);
$D=substr($rm52,3,1);
$E=substr($rm52,4,1);
$F=substr($rm52,5,1);
$G=substr($rm52,6,1);
$H=substr($rm52,7,1);
$I=substr($rm52,8,1);
$J=substr($rm52,9,1);
$K=substr($rm52,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r53=sprintf('% 11s',$r53);
$A=substr($r53,0,1);
$B=substr($r53,1,1);
$C=substr($r53,2,1);
$D=substr($r53,3,1);
$E=substr($r53,4,1);
$F=substr($r53,5,1);
$G=substr($r53,6,1);
$H=substr($r53,7,1);
$I=substr($r53,8,1);
$J=substr($r53,9,1);
$K=substr($r53,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn53=sprintf('% 11s',$rn53);
$A=substr($rn53,0,1);
$B=substr($rn53,1,1);
$C=substr($rn53,2,1);
$D=substr($rn53,3,1);
$E=substr($rn53,4,1);
$F=substr($rn53,5,1);
$G=substr($rn53,6,1);
$H=substr($rn53,7,1);
$I=substr($rn53,8,1);
$J=substr($rn53,9,1);
$K=substr($rn53,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk53=sprintf('% 11s',$rk53);
$A=substr($rk53,0,1);
$B=substr($rk53,1,1);
$C=substr($rk53,2,1);
$D=substr($rk53,3,1);
$E=substr($rk53,4,1);
$F=substr($rk53,5,1);
$G=substr($rk53,6,1);
$H=substr($rk53,7,1);
$I=substr($rk53,8,1);
$J=substr($rk53,9,1);
$K=substr($rk53,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm53=sprintf('% 11s',$rm53);
$A=substr($rm53,0,1);
$B=substr($rm53,1,1);
$C=substr($rm53,2,1);
$D=substr($rm53,3,1);
$E=substr($rm53,4,1);
$F=substr($rm53,5,1);
$G=substr($rm53,6,1);
$H=substr($rm53,7,1);
$I=substr($rm53,8,1);
$J=substr($rm53,9,1);
$K=substr($rm53,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r54=sprintf('% 11s',$r54);
$A=substr($r54,0,1);
$B=substr($r54,1,1);
$C=substr($r54,2,1);
$D=substr($r54,3,1);
$E=substr($r54,4,1);
$F=substr($r54,5,1);
$G=substr($r54,6,1);
$H=substr($r54,7,1);
$I=substr($r54,8,1);
$J=substr($r54,9,1);
$K=substr($r54,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn54=sprintf('% 11s',$rn54);
$A=substr($rn54,0,1);
$B=substr($rn54,1,1);
$C=substr($rn54,2,1);
$D=substr($rn54,3,1);
$E=substr($rn54,4,1);
$F=substr($rn54,5,1);
$G=substr($rn54,6,1);
$H=substr($rn54,7,1);
$I=substr($rn54,8,1);
$J=substr($rn54,9,1);
$K=substr($rn54,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk54=sprintf('% 11s',$rk54);
$A=substr($rk54,0,1);
$B=substr($rk54,1,1);
$C=substr($rk54,2,1);
$D=substr($rk54,3,1);
$E=substr($rk54,4,1);
$F=substr($rk54,5,1);
$G=substr($rk54,6,1);
$H=substr($rk54,7,1);
$I=substr($rk54,8,1);
$J=substr($rk54,9,1);
$K=substr($rk54,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm54=sprintf('% 11s',$rm54);
$A=substr($rm54,0,1);
$B=substr($rm54,1,1);
$C=substr($rm54,2,1);
$D=substr($rm54,3,1);
$E=substr($rm54,4,1);
$F=substr($rm54,5,1);
$G=substr($rm54,6,1);
$H=substr($rm54,7,1);
$I=substr($rm54,8,1);
$J=substr($rm54,9,1);
$K=substr($rm54,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r55=sprintf('% 11s',$r55);
$A=substr($r55,0,1);
$B=substr($r55,1,1);
$C=substr($r55,2,1);
$D=substr($r55,3,1);
$E=substr($r55,4,1);
$F=substr($r55,5,1);
$G=substr($r55,6,1);
$H=substr($r55,7,1);
$I=substr($r55,8,1);
$J=substr($r55,9,1);
$K=substr($r55,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn55=sprintf('% 11s',$rn55);
$A=substr($rn55,0,1);
$B=substr($rn55,1,1);
$C=substr($rn55,2,1);
$D=substr($rn55,3,1);
$E=substr($rn55,4,1);
$F=substr($rn55,5,1);
$G=substr($rn55,6,1);
$H=substr($rn55,7,1);
$I=substr($rn55,8,1);
$J=substr($rn55,9,1);
$K=substr($rn55,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk55=sprintf('% 11s',$rk55);
$A=substr($rk55,0,1);
$B=substr($rk55,1,1);
$C=substr($rk55,2,1);
$D=substr($rk55,3,1);
$E=substr($rk55,4,1);
$F=substr($rk55,5,1);
$G=substr($rk55,6,1);
$H=substr($rk55,7,1);
$I=substr($rk55,8,1);
$J=substr($rk55,9,1);
$K=substr($rk55,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm55=sprintf('% 11s',$rm55);
$A=substr($rm55,0,1);
$B=substr($rm55,1,1);
$C=substr($rm55,2,1);
$D=substr($rm55,3,1);
$E=substr($rm55,4,1);
$F=substr($rm55,5,1);
$G=substr($rm55,6,1);
$H=substr($rm55,7,1);
$I=substr($rm55,8,1);
$J=substr($rm55,9,1);
$K=substr($rm55,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$r56=sprintf('% 11s',$r56);
$A=substr($r56,0,1);
$B=substr($r56,1,1);
$C=substr($r56,2,1);
$D=substr($r56,3,1);
$E=substr($r56,4,1);
$F=substr($r56,5,1);
$G=substr($r56,6,1);
$H=substr($r56,7,1);
$I=substr($r56,8,1);
$J=substr($r56,9,1);
$K=substr($r56,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn56=sprintf('% 11s',$rn56);
$A=substr($rn56,0,1);
$B=substr($rn56,1,1);
$C=substr($rn56,2,1);
$D=substr($rn56,3,1);
$E=substr($rn56,4,1);
$F=substr($rn56,5,1);
$G=substr($rn56,6,1);
$H=substr($rn56,7,1);
$I=substr($rn56,8,1);
$J=substr($rn56,9,1);
$K=substr($rn56,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(50,6," ","$rmc",0,"R");
$rk56=sprintf('% 11s',$rk56);
$A=substr($rk56,0,1);
$B=substr($rk56,1,1);
$C=substr($rk56,2,1);
$D=substr($rk56,3,1);
$E=substr($rk56,4,1);
$F=substr($rk56,5,1);
$G=substr($rk56,6,1);
$H=substr($rk56,7,1);
$I=substr($rk56,8,1);
$J=substr($rk56,9,1);
$K=substr($rk56,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm56=sprintf('% 11s',$rm56);
$A=substr($rm56,0,1);
$B=substr($rm56,1,1);
$C=substr($rm56,2,1);
$D=substr($rm56,3,1);
$E=substr($rm56,4,1);
$F=substr($rm56,5,1);
$G=substr($rm56,6,1);
$H=substr($rm56,7,1);
$I=substr($rm56,8,1);
$J=substr($rm56,9,1);
$K=substr($rm56,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");



//koniec strana 5

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-6.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-6.jpg',13,11,186,275); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,5,"     ","$rmc",1,"L");

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

$pdf->Cell(73,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(3,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,16,"     ","$rmc",1,"L");

$pdf->Cell(49,6," ","$rmc",0,"R");
$r57=sprintf('% 11s',$r57);
$A=substr($r57,0,1);
$B=substr($r57,1,1);
$C=substr($r57,2,1);
$D=substr($r57,3,1);
$E=substr($r57,4,1);
$F=substr($r57,5,1);
$G=substr($r57,6,1);
$H=substr($r57,7,1);
$I=substr($r57,8,1);
$J=substr($r57,9,1);
$K=substr($r57,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn57=sprintf('% 11s',$rn57);
$A=substr($rn57,0,1);
$B=substr($rn57,1,1);
$C=substr($rn57,2,1);
$D=substr($rn57,3,1);
$E=substr($rn57,4,1);
$F=substr($rn57,5,1);
$G=substr($rn57,6,1);
$H=substr($rn57,7,1);
$I=substr($rn57,8,1);
$J=substr($rn57,9,1);
$K=substr($rn57,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk57=sprintf('% 11s',$rk57);
$A=substr($rk57,0,1);
$B=substr($rk57,1,1);
$C=substr($rk57,2,1);
$D=substr($rk57,3,1);
$E=substr($rk57,4,1);
$F=substr($rk57,5,1);
$G=substr($rk57,6,1);
$H=substr($rk57,7,1);
$I=substr($rk57,8,1);
$J=substr($rk57,9,1);
$K=substr($rk57,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm57=sprintf('% 11s',$rm57);
$A=substr($rm57,0,1);
$B=substr($rm57,1,1);
$C=substr($rm57,2,1);
$D=substr($rm57,3,1);
$E=substr($rm57,4,1);
$F=substr($rm57,5,1);
$G=substr($rm57,6,1);
$H=substr($rm57,7,1);
$I=substr($rm57,8,1);
$J=substr($rm57,9,1);
$K=substr($rm57,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r58=sprintf('% 11s',$r58);
$A=substr($r58,0,1);
$B=substr($r58,1,1);
$C=substr($r58,2,1);
$D=substr($r58,3,1);
$E=substr($r58,4,1);
$F=substr($r58,5,1);
$G=substr($r58,6,1);
$H=substr($r58,7,1);
$I=substr($r58,8,1);
$J=substr($r58,9,1);
$K=substr($r58,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn58=sprintf('% 11s',$rn58);
$A=substr($rn58,0,1);
$B=substr($rn58,1,1);
$C=substr($rn58,2,1);
$D=substr($rn58,3,1);
$E=substr($rn58,4,1);
$F=substr($rn58,5,1);
$G=substr($rn58,6,1);
$H=substr($rn58,7,1);
$I=substr($rn58,8,1);
$J=substr($rn58,9,1);
$K=substr($rn58,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk58=sprintf('% 11s',$rk58);
$A=substr($rk58,0,1);
$B=substr($rk58,1,1);
$C=substr($rk58,2,1);
$D=substr($rk58,3,1);
$E=substr($rk58,4,1);
$F=substr($rk58,5,1);
$G=substr($rk58,6,1);
$H=substr($rk58,7,1);
$I=substr($rk58,8,1);
$J=substr($rk58,9,1);
$K=substr($rk58,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm58=sprintf('% 11s',$rm58);
$A=substr($rm58,0,1);
$B=substr($rm58,1,1);
$C=substr($rm58,2,1);
$D=substr($rm58,3,1);
$E=substr($rm58,4,1);
$F=substr($rm58,5,1);
$G=substr($rm58,6,1);
$H=substr($rm58,7,1);
$I=substr($rm58,8,1);
$J=substr($rm58,9,1);
$K=substr($rm58,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r59=sprintf('% 11s',$r59);
$A=substr($r59,0,1);
$B=substr($r59,1,1);
$C=substr($r59,2,1);
$D=substr($r59,3,1);
$E=substr($r59,4,1);
$F=substr($r59,5,1);
$G=substr($r59,6,1);
$H=substr($r59,7,1);
$I=substr($r59,8,1);
$J=substr($r59,9,1);
$K=substr($r59,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn59=sprintf('% 11s',$rn59);
$A=substr($rn59,0,1);
$B=substr($rn59,1,1);
$C=substr($rn59,2,1);
$D=substr($rn59,3,1);
$E=substr($rn59,4,1);
$F=substr($rn59,5,1);
$G=substr($rn59,6,1);
$H=substr($rn59,7,1);
$I=substr($rn59,8,1);
$J=substr($rn59,9,1);
$K=substr($rn59,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk59=sprintf('% 11s',$rk59);
$A=substr($rk59,0,1);
$B=substr($rk59,1,1);
$C=substr($rk59,2,1);
$D=substr($rk59,3,1);
$E=substr($rk59,4,1);
$F=substr($rk59,5,1);
$G=substr($rk59,6,1);
$H=substr($rk59,7,1);
$I=substr($rk59,8,1);
$J=substr($rk59,9,1);
$K=substr($rk59,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm59=sprintf('% 11s',$rm59);
$A=substr($rm59,0,1);
$B=substr($rm59,1,1);
$C=substr($rm59,2,1);
$D=substr($rm59,3,1);
$E=substr($rm59,4,1);
$F=substr($rm59,5,1);
$G=substr($rm59,6,1);
$H=substr($rm59,7,1);
$I=substr($rm59,8,1);
$J=substr($rm59,9,1);
$K=substr($rm59,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r60=sprintf('% 11s',$r60);
$A=substr($r60,0,1);
$B=substr($r60,1,1);
$C=substr($r60,2,1);
$D=substr($r60,3,1);
$E=substr($r60,4,1);
$F=substr($r60,5,1);
$G=substr($r60,6,1);
$H=substr($r60,7,1);
$I=substr($r60,8,1);
$J=substr($r60,9,1);
$K=substr($r60,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn60=sprintf('% 11s',$rn60);
$A=substr($rn60,0,1);
$B=substr($rn60,1,1);
$C=substr($rn60,2,1);
$D=substr($rn60,3,1);
$E=substr($rn60,4,1);
$F=substr($rn60,5,1);
$G=substr($rn60,6,1);
$H=substr($rn60,7,1);
$I=substr($rn60,8,1);
$J=substr($rn60,9,1);
$K=substr($rn60,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk60=sprintf('% 11s',$rk60);
$A=substr($rk60,0,1);
$B=substr($rk60,1,1);
$C=substr($rk60,2,1);
$D=substr($rk60,3,1);
$E=substr($rk60,4,1);
$F=substr($rk60,5,1);
$G=substr($rk60,6,1);
$H=substr($rk60,7,1);
$I=substr($rk60,8,1);
$J=substr($rk60,9,1);
$K=substr($rk60,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm60=sprintf('% 11s',$rm60);
$A=substr($rm60,0,1);
$B=substr($rm60,1,1);
$C=substr($rm60,2,1);
$D=substr($rm60,3,1);
$E=substr($rm60,4,1);
$F=substr($rm60,5,1);
$G=substr($rm60,6,1);
$H=substr($rm60,7,1);
$I=substr($rm60,8,1);
$J=substr($rm60,9,1);
$K=substr($rm60,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r61=sprintf('% 11s',$r61);
$A=substr($r61,0,1);
$B=substr($r61,1,1);
$C=substr($r61,2,1);
$D=substr($r61,3,1);
$E=substr($r61,4,1);
$F=substr($r61,5,1);
$G=substr($r61,6,1);
$H=substr($r61,7,1);
$I=substr($r61,8,1);
$J=substr($r61,9,1);
$K=substr($r61,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn61=sprintf('% 11s',$rn61);
$A=substr($rn61,0,1);
$B=substr($rn61,1,1);
$C=substr($rn61,2,1);
$D=substr($rn61,3,1);
$E=substr($rn61,4,1);
$F=substr($rn61,5,1);
$G=substr($rn61,6,1);
$H=substr($rn61,7,1);
$I=substr($rn61,8,1);
$J=substr($rn61,9,1);
$K=substr($rn61,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk61=sprintf('% 11s',$rk61);
$A=substr($rk61,0,1);
$B=substr($rk61,1,1);
$C=substr($rk61,2,1);
$D=substr($rk61,3,1);
$E=substr($rk61,4,1);
$F=substr($rk61,5,1);
$G=substr($rk61,6,1);
$H=substr($rk61,7,1);
$I=substr($rk61,8,1);
$J=substr($rk61,9,1);
$K=substr($rk61,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm61=sprintf('% 11s',$rm61);
$A=substr($rm61,0,1);
$B=substr($rm61,1,1);
$C=substr($rm61,2,1);
$D=substr($rm61,3,1);
$E=substr($rm61,4,1);
$F=substr($rm61,5,1);
$G=substr($rm61,6,1);
$H=substr($rm61,7,1);
$I=substr($rm61,8,1);
$J=substr($rm61,9,1);
$K=substr($rm61,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r62=sprintf('% 11s',$r62);
$A=substr($r62,0,1);
$B=substr($r62,1,1);
$C=substr($r62,2,1);
$D=substr($r62,3,1);
$E=substr($r62,4,1);
$F=substr($r62,5,1);
$G=substr($r62,6,1);
$H=substr($r62,7,1);
$I=substr($r62,8,1);
$J=substr($r62,9,1);
$K=substr($r62,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn62=sprintf('% 11s',$rn62);
$A=substr($rn62,0,1);
$B=substr($rn62,1,1);
$C=substr($rn62,2,1);
$D=substr($rn62,3,1);
$E=substr($rn62,4,1);
$F=substr($rn62,5,1);
$G=substr($rn62,6,1);
$H=substr($rn62,7,1);
$I=substr($rn62,8,1);
$J=substr($rn62,9,1);
$K=substr($rn62,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk62=sprintf('% 11s',$rk62);
$A=substr($rk62,0,1);
$B=substr($rk62,1,1);
$C=substr($rk62,2,1);
$D=substr($rk62,3,1);
$E=substr($rk62,4,1);
$F=substr($rk62,5,1);
$G=substr($rk62,6,1);
$H=substr($rk62,7,1);
$I=substr($rk62,8,1);
$J=substr($rk62,9,1);
$K=substr($rk62,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm62=sprintf('% 11s',$rm62);
$A=substr($rm62,0,1);
$B=substr($rm62,1,1);
$C=substr($rm62,2,1);
$D=substr($rm62,3,1);
$E=substr($rm62,4,1);
$F=substr($rm62,5,1);
$G=substr($rm62,6,1);
$H=substr($rm62,7,1);
$I=substr($rm62,8,1);
$J=substr($rm62,9,1);
$K=substr($rm62,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r63=sprintf('% 11s',$r63);
$A=substr($r63,0,1);
$B=substr($r63,1,1);
$C=substr($r63,2,1);
$D=substr($r63,3,1);
$E=substr($r63,4,1);
$F=substr($r63,5,1);
$G=substr($r63,6,1);
$H=substr($r63,7,1);
$I=substr($r63,8,1);
$J=substr($r63,9,1);
$K=substr($r63,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn63=sprintf('% 11s',$rn63);
$A=substr($rn63,0,1);
$B=substr($rn63,1,1);
$C=substr($rn63,2,1);
$D=substr($rn63,3,1);
$E=substr($rn63,4,1);
$F=substr($rn63,5,1);
$G=substr($rn63,6,1);
$H=substr($rn63,7,1);
$I=substr($rn63,8,1);
$J=substr($rn63,9,1);
$K=substr($rn63,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk63=sprintf('% 11s',$rk63);
$A=substr($rk63,0,1);
$B=substr($rk63,1,1);
$C=substr($rk63,2,1);
$D=substr($rk63,3,1);
$E=substr($rk63,4,1);
$F=substr($rk63,5,1);
$G=substr($rk63,6,1);
$H=substr($rk63,7,1);
$I=substr($rk63,8,1);
$J=substr($rk63,9,1);
$K=substr($rk63,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm63=sprintf('% 11s',$rm63);
$A=substr($rm63,0,1);
$B=substr($rm63,1,1);
$C=substr($rm63,2,1);
$D=substr($rm63,3,1);
$E=substr($rm63,4,1);
$F=substr($rm63,5,1);
$G=substr($rm63,6,1);
$H=substr($rm63,7,1);
$I=substr($rm63,8,1);
$J=substr($rm63,9,1);
$K=substr($rm63,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r64=sprintf('% 11s',$r64);
$A=substr($r64,0,1);
$B=substr($r64,1,1);
$C=substr($r64,2,1);
$D=substr($r64,3,1);
$E=substr($r64,4,1);
$F=substr($r64,5,1);
$G=substr($r64,6,1);
$H=substr($r64,7,1);
$I=substr($r64,8,1);
$J=substr($r64,9,1);
$K=substr($r64,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn64=sprintf('% 11s',$rn64);
$A=substr($rn64,0,1);
$B=substr($rn64,1,1);
$C=substr($rn64,2,1);
$D=substr($rn64,3,1);
$E=substr($rn64,4,1);
$F=substr($rn64,5,1);
$G=substr($rn64,6,1);
$H=substr($rn64,7,1);
$I=substr($rn64,8,1);
$J=substr($rn64,9,1);
$K=substr($rn64,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk64=sprintf('% 11s',$rk64);
$A=substr($rk64,0,1);
$B=substr($rk64,1,1);
$C=substr($rk64,2,1);
$D=substr($rk64,3,1);
$E=substr($rk64,4,1);
$F=substr($rk64,5,1);
$G=substr($rk64,6,1);
$H=substr($rk64,7,1);
$I=substr($rk64,8,1);
$J=substr($rk64,9,1);
$K=substr($rk64,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm64=sprintf('% 11s',$rm64);
$A=substr($rm64,0,1);
$B=substr($rm64,1,1);
$C=substr($rm64,2,1);
$D=substr($rm64,3,1);
$E=substr($rm64,4,1);
$F=substr($rm64,5,1);
$G=substr($rm64,6,1);
$H=substr($rm64,7,1);
$I=substr($rm64,8,1);
$J=substr($rm64,9,1);
$K=substr($rm64,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$r65=sprintf('% 11s',$r65);
$A=substr($r65,0,1);
$B=substr($r65,1,1);
$C=substr($r65,2,1);
$D=substr($r65,3,1);
$E=substr($r65,4,1);
$F=substr($r65,5,1);
$G=substr($r65,6,1);
$H=substr($r65,7,1);
$I=substr($r65,8,1);
$J=substr($r65,9,1);
$K=substr($r65,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rn65=sprintf('% 11s',$rn65);
$A=substr($rn65,0,1);
$B=substr($rn65,1,1);
$C=substr($rn65,2,1);
$D=substr($rn65,3,1);
$E=substr($rn65,4,1);
$F=substr($rn65,5,1);
$G=substr($rn65,6,1);
$H=substr($rn65,7,1);
$I=substr($rn65,8,1);
$J=substr($rn65,9,1);
$K=substr($rn65,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(49,6," ","$rmc",0,"R");
$rk65=sprintf('% 11s',$rk65);
$A=substr($rk65,0,1);
$B=substr($rk65,1,1);
$C=substr($rk65,2,1);
$D=substr($rk65,3,1);
$E=substr($rk65,4,1);
$F=substr($rk65,5,1);
$G=substr($rk65,6,1);
$H=substr($rk65,7,1);
$I=substr($rk65,8,1);
$J=substr($rk65,9,1);
$K=substr($rk65,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm65=sprintf('% 11s',$rm65);
$A=substr($rm65,0,1);
$B=substr($rm65,1,1);
$C=substr($rm65,2,1);
$D=substr($rm65,3,1);
$E=substr($rm65,4,1);
$F=substr($rm65,5,1);
$G=substr($rm65,6,1);
$H=substr($rm65,7,1);
$I=substr($rm65,8,1);
$J=substr($rm65,9,1);
$K=substr($rm65,10,1);
$pdf->Cell(30,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");



//generovanie strany
$generuj=0;
if( $generuj == 1 )
          {
if (File_Exists ("../tmp/vlozvkzs$kli_uzid.php")) { $soubor = unlink("../tmp/vlozvkzs$kli_uzid.php"); }
$soubor = fopen("../tmp/vlozvkzs$kli_uzid.php", "a+");

  $text = "<?php"."\r\n";
  fwrite($soubor, $text);

$rdk=57;
while ($rdk <= 65 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;


$text="\$pdf->Cell(49,6,\" \",\"1\",0,\"R\");"."\r\n";
fwrite($soubor, $text);

$text="\$r".$crdk."=sprintf('% 11s',\$r".$crdk.");"."\r\n";
fwrite($soubor, $text);

$text="\$A=substr(\$r".$crdk.",0,1);"."\r\n";
fwrite($soubor, $text);
$text="\$B=substr(\$r".$crdk.",1,1);"."\r\n";
fwrite($soubor, $text);
$text="\$C=substr(\$r".$crdk.",2,1);"."\r\n";
fwrite($soubor, $text);
$text="\$D=substr(\$r".$crdk.",3,1);"."\r\n";
fwrite($soubor, $text);
$text="\$E=substr(\$r".$crdk.",4,1);"."\r\n";
fwrite($soubor, $text);
$text="\$F=substr(\$r".$crdk.",5,1);"."\r\n";
fwrite($soubor, $text);
$text="\$G=substr(\$r".$crdk.",6,1);"."\r\n";
fwrite($soubor, $text);
$text="\$H=substr(\$r".$crdk.",7,1);"."\r\n";
fwrite($soubor, $text);
$text="\$I=substr(\$r".$crdk.",8,1);"."\r\n";
fwrite($soubor, $text);
$text="\$J=substr(\$r".$crdk.",9,1);"."\r\n";
fwrite($soubor, $text);
$text="\$K=substr(\$r".$crdk.",10,1);"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\"\$A\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$B\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$C\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$D\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$E\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(5,6,\"\$F\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$G\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$H\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$I\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$J\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$K\",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);


$text="\$rn".$crdk."=sprintf('% 11s',\$rn".$crdk.");"."\r\n";
fwrite($soubor, $text);

$text="\$A=substr(\$rn".$crdk.",0,1);"."\r\n";
fwrite($soubor, $text);
$text="\$B=substr(\$rn".$crdk.",1,1);"."\r\n";
fwrite($soubor, $text);
$text="\$C=substr(\$rn".$crdk.",2,1);"."\r\n";
fwrite($soubor, $text);
$text="\$D=substr(\$rn".$crdk.",3,1);"."\r\n";
fwrite($soubor, $text);
$text="\$E=substr(\$rn".$crdk.",4,1);"."\r\n";
fwrite($soubor, $text);
$text="\$F=substr(\$rn".$crdk.",5,1);"."\r\n";
fwrite($soubor, $text);
$text="\$G=substr(\$rn".$crdk.",6,1);"."\r\n";
fwrite($soubor, $text);
$text="\$H=substr(\$rn".$crdk.",7,1);"."\r\n";
fwrite($soubor, $text);
$text="\$I=substr(\$rn".$crdk.",8,1);"."\r\n";
fwrite($soubor, $text);
$text="\$J=substr(\$rn".$crdk.",9,1);"."\r\n";
fwrite($soubor, $text);
$text="\$K=substr(\$rn".$crdk.",10,1);"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\" \",\"1\",0,\"R\");"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\"\$A\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$B\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$C\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(5,6,\"\$D\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$E\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$F\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$G\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$H\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$I\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$J\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(5,6,\"\$K\",\"1\",1,\"C\");"."\r\n";
fwrite($soubor, $text);


$text="\$pdf->Cell(150,3,\" \",\"1\",1,\"R\");"."\r\n";
fwrite($soubor, $text);


$text="\$pdf->Cell(49,6,\" \",\"1\",0,\"R\");"."\r\n";
fwrite($soubor, $text);

$text="\$r".$crdk."=sprintf('% 11s',\$r".$crdk.");"."\r\n";
fwrite($soubor, $text);

$text="\$A=substr(\$rk".$crdk.",0,1);"."\r\n";
fwrite($soubor, $text);
$text="\$B=substr(\$rk".$crdk.",1,1);"."\r\n";
fwrite($soubor, $text);
$text="\$C=substr(\$rk".$crdk.",2,1);"."\r\n";
fwrite($soubor, $text);
$text="\$D=substr(\$rk".$crdk.",3,1);"."\r\n";
fwrite($soubor, $text);
$text="\$E=substr(\$rk".$crdk.",4,1);"."\r\n";
fwrite($soubor, $text);
$text="\$F=substr(\$rk".$crdk.",5,1);"."\r\n";
fwrite($soubor, $text);
$text="\$G=substr(\$rk".$crdk.",6,1);"."\r\n";
fwrite($soubor, $text);
$text="\$H=substr(\$rk".$crdk.",7,1);"."\r\n";
fwrite($soubor, $text);
$text="\$I=substr(\$rk".$crdk.",8,1);"."\r\n";
fwrite($soubor, $text);
$text="\$J=substr(\$rk".$crdk.",9,1);"."\r\n";
fwrite($soubor, $text);
$text="\$K=substr(\$rk".$crdk.",10,1);"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\"\$A\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$B\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$C\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$D\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$E\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(5,6,\"\$F\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$G\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$H\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$I\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$J\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$K\",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);


$text="\$rm".$crdk."=sprintf('% 11s',\$rm".$crdk.");"."\r\n";
fwrite($soubor, $text);

$text="\$A=substr(\$rm".$crdk.",0,1);"."\r\n";
fwrite($soubor, $text);
$text="\$B=substr(\$rm".$crdk.",1,1);"."\r\n";
fwrite($soubor, $text);
$text="\$C=substr(\$rm".$crdk.",2,1);"."\r\n";
fwrite($soubor, $text);
$text="\$D=substr(\$rm".$crdk.",3,1);"."\r\n";
fwrite($soubor, $text);
$text="\$E=substr(\$rm".$crdk.",4,1);"."\r\n";
fwrite($soubor, $text);
$text="\$F=substr(\$rm".$crdk.",5,1);"."\r\n";
fwrite($soubor, $text);
$text="\$G=substr(\$rm".$crdk.",6,1);"."\r\n";
fwrite($soubor, $text);
$text="\$H=substr(\$rm".$crdk.",7,1);"."\r\n";
fwrite($soubor, $text);
$text="\$I=substr(\$rm".$crdk.",8,1);"."\r\n";
fwrite($soubor, $text);
$text="\$J=substr(\$rm".$crdk.",9,1);"."\r\n";
fwrite($soubor, $text);
$text="\$K=substr(\$rm".$crdk.",10,1);"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(33,6,\" \",\"1\",0,\"R\");"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\"\$A\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$B\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$C\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$D\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$E\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$F\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(5,6,\"\$G\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$H\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$I\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$J\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$K\",\"1\",1,\"C\");"."\r\n";
fwrite($soubor, $text);


$text="\$pdf->Cell(150,2,\" \",\"1\",1,\"R\");"."\r\n";
fwrite($soubor, $text);


if( $rdk == 58 OR $rdk == 60 OR $rdk == 62 OR $rdk == 64 OR $rdk == 66 OR $rdk == 68 )
{
$text="\$pdf->Cell(150,1,\" \",\"1\",1,\"R\");"."\r\n";
fwrite($soubor, $text);
} 

$rdk=$rdk+1;
  }

  $text = "?>"."\r\n";
  fwrite($soubor, $text);

  fclose($soubor);

include("../tmp/vlozvkzs$kli_uzid.php");
          }
//koniec generovania


$pdf->Cell(190,50,"     ","$rmc",1,"L");


$pdf->Cell(76,6," ","$rmc",0,"R");
$r66=sprintf('% 11s',$r66);
$A=substr($r66,0,1);
$B=substr($r66,1,1);
$C=substr($r66,2,1);
$D=substr($r66,3,1);
$E=substr($r66,4,1);
$F=substr($r66,5,1);
$G=substr($r66,6,1);
$H=substr($r66,7,1);
$I=substr($r66,8,1);
$J=substr($r66,9,1);
$K=substr($r66,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm66=sprintf('% 11s',$rm66);
$A=substr($rm66,0,1);
$B=substr($rm66,1,1);
$C=substr($rm66,2,1);
$D=substr($rm66,3,1);
$E=substr($rm66,4,1);
$F=substr($rm66,5,1);
$G=substr($rm66,6,1);
$H=substr($rm66,7,1);
$I=substr($rm66,8,1);
$J=substr($rm66,9,1);
$K=substr($rm66,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r67=sprintf('% 11s',$r67);
$A=substr($r67,0,1);
$B=substr($r67,1,1);
$C=substr($r67,2,1);
$D=substr($r67,3,1);
$E=substr($r67,4,1);
$F=substr($r67,5,1);
$G=substr($r67,6,1);
$H=substr($r67,7,1);
$I=substr($r67,8,1);
$J=substr($r67,9,1);
$K=substr($r67,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm67=sprintf('% 11s',$rm67);
$A=substr($rm67,0,1);
$B=substr($rm67,1,1);
$C=substr($rm67,2,1);
$D=substr($rm67,3,1);
$E=substr($rm67,4,1);
$F=substr($rm67,5,1);
$G=substr($rm67,6,1);
$H=substr($rm67,7,1);
$I=substr($rm67,8,1);
$J=substr($rm67,9,1);
$K=substr($rm67,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r68=sprintf('% 11s',$r68);
$A=substr($r68,0,1);
$B=substr($r68,1,1);
$C=substr($r68,2,1);
$D=substr($r68,3,1);
$E=substr($r68,4,1);
$F=substr($r68,5,1);
$G=substr($r68,6,1);
$H=substr($r68,7,1);
$I=substr($r68,8,1);
$J=substr($r68,9,1);
$K=substr($r68,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm68=sprintf('% 11s',$rm68);
$A=substr($rm68,0,1);
$B=substr($rm68,1,1);
$C=substr($rm68,2,1);
$D=substr($rm68,3,1);
$E=substr($rm68,4,1);
$F=substr($rm68,5,1);
$G=substr($rm68,6,1);
$H=substr($rm68,7,1);
$I=substr($rm68,8,1);
$J=substr($rm68,9,1);
$K=substr($rm68,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r69=sprintf('% 11s',$r69);
$A=substr($r69,0,1);
$B=substr($r69,1,1);
$C=substr($r69,2,1);
$D=substr($r69,3,1);
$E=substr($r69,4,1);
$F=substr($r69,5,1);
$G=substr($r69,6,1);
$H=substr($r69,7,1);
$I=substr($r69,8,1);
$J=substr($r69,9,1);
$K=substr($r69,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm69=sprintf('% 11s',$rm69);
$A=substr($rm69,0,1);
$B=substr($rm69,1,1);
$C=substr($rm69,2,1);
$D=substr($rm69,3,1);
$E=substr($rm69,4,1);
$F=substr($rm69,5,1);
$G=substr($rm69,6,1);
$H=substr($rm69,7,1);
$I=substr($rm69,8,1);
$J=substr($rm69,9,1);
$K=substr($rm69,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");


//koniec strana 6

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-7.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-7.jpg',13,11,186,274); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,4,"     ","$rmc",1,"L");

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

$pdf->Cell(73,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,14,"     ","$rmc",1,"L");

$pdf->Cell(76,6," ","$rmc",0,"R");
$r70=sprintf('% 11s',$r70);
$A=substr($r70,0,1);
$B=substr($r70,1,1);
$C=substr($r70,2,1);
$D=substr($r70,3,1);
$E=substr($r70,4,1);
$F=substr($r70,5,1);
$G=substr($r70,6,1);
$H=substr($r70,7,1);
$I=substr($r70,8,1);
$J=substr($r70,9,1);
$K=substr($r70,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm70=sprintf('% 11s',$rm70);
$A=substr($rm70,0,1);
$B=substr($rm70,1,1);
$C=substr($rm70,2,1);
$D=substr($rm70,3,1);
$E=substr($rm70,4,1);
$F=substr($rm70,5,1);
$G=substr($rm70,6,1);
$H=substr($rm70,7,1);
$I=substr($rm70,8,1);
$J=substr($rm70,9,1);
$K=substr($rm70,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r71=sprintf('% 11s',$r71);
$A=substr($r71,0,1);
$B=substr($r71,1,1);
$C=substr($r71,2,1);
$D=substr($r71,3,1);
$E=substr($r71,4,1);
$F=substr($r71,5,1);
$G=substr($r71,6,1);
$H=substr($r71,7,1);
$I=substr($r71,8,1);
$J=substr($r71,9,1);
$K=substr($r71,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm71=sprintf('% 11s',$rm71);
$A=substr($rm71,0,1);
$B=substr($rm71,1,1);
$C=substr($rm71,2,1);
$D=substr($rm71,3,1);
$E=substr($rm71,4,1);
$F=substr($rm71,5,1);
$G=substr($rm71,6,1);
$H=substr($rm71,7,1);
$I=substr($rm71,8,1);
$J=substr($rm71,9,1);
$K=substr($rm71,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r72=sprintf('% 11s',$r72);
$A=substr($r72,0,1);
$B=substr($r72,1,1);
$C=substr($r72,2,1);
$D=substr($r72,3,1);
$E=substr($r72,4,1);
$F=substr($r72,5,1);
$G=substr($r72,6,1);
$H=substr($r72,7,1);
$I=substr($r72,8,1);
$J=substr($r72,9,1);
$K=substr($r72,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm72=sprintf('% 11s',$rm72);
$A=substr($rm72,0,1);
$B=substr($rm72,1,1);
$C=substr($rm72,2,1);
$D=substr($rm72,3,1);
$E=substr($rm72,4,1);
$F=substr($rm72,5,1);
$G=substr($rm72,6,1);
$H=substr($rm72,7,1);
$I=substr($rm72,8,1);
$J=substr($rm72,9,1);
$K=substr($rm72,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");


$pdf->Cell(76,6," ","$rmc",0,"R");
$r73=sprintf('% 11s',$r73);
$A=substr($r73,0,1);
$B=substr($r73,1,1);
$C=substr($r73,2,1);
$D=substr($r73,3,1);
$E=substr($r73,4,1);
$F=substr($r73,5,1);
$G=substr($r73,6,1);
$H=substr($r73,7,1);
$I=substr($r73,8,1);
$J=substr($r73,9,1);
$K=substr($r73,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm73=sprintf('% 11s',$rm73);
$A=substr($rm73,0,1);
$B=substr($rm73,1,1);
$C=substr($rm73,2,1);
$D=substr($rm73,3,1);
$E=substr($rm73,4,1);
$F=substr($rm73,5,1);
$G=substr($rm73,6,1);
$H=substr($rm73,7,1);
$I=substr($rm73,8,1);
$J=substr($rm73,9,1);
$K=substr($rm73,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r74=sprintf('% 11s',$r74);
$A=substr($r74,0,1);
$B=substr($r74,1,1);
$C=substr($r74,2,1);
$D=substr($r74,3,1);
$E=substr($r74,4,1);
$F=substr($r74,5,1);
$G=substr($r74,6,1);
$H=substr($r74,7,1);
$I=substr($r74,8,1);
$J=substr($r74,9,1);
$K=substr($r74,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm74=sprintf('% 11s',$rm74);
$A=substr($rm74,0,1);
$B=substr($rm74,1,1);
$C=substr($rm74,2,1);
$D=substr($rm74,3,1);
$E=substr($rm74,4,1);
$F=substr($rm74,5,1);
$G=substr($rm74,6,1);
$H=substr($rm74,7,1);
$I=substr($rm74,8,1);
$J=substr($rm74,9,1);
$K=substr($rm74,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r75=sprintf('% 11s',$r75);
$A=substr($r75,0,1);
$B=substr($r75,1,1);
$C=substr($r75,2,1);
$D=substr($r75,3,1);
$E=substr($r75,4,1);
$F=substr($r75,5,1);
$G=substr($r75,6,1);
$H=substr($r75,7,1);
$I=substr($r75,8,1);
$J=substr($r75,9,1);
$K=substr($r75,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm75=sprintf('% 11s',$rm75);
$A=substr($rm75,0,1);
$B=substr($rm75,1,1);
$C=substr($rm75,2,1);
$D=substr($rm75,3,1);
$E=substr($rm75,4,1);
$F=substr($rm75,5,1);
$G=substr($rm75,6,1);
$H=substr($rm75,7,1);
$I=substr($rm75,8,1);
$J=substr($rm75,9,1);
$K=substr($rm75,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r76=sprintf('% 11s',$r76);
$A=substr($r76,0,1);
$B=substr($r76,1,1);
$C=substr($r76,2,1);
$D=substr($r76,3,1);
$E=substr($r76,4,1);
$F=substr($r76,5,1);
$G=substr($r76,6,1);
$H=substr($r76,7,1);
$I=substr($r76,8,1);
$J=substr($r76,9,1);
$K=substr($r76,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm76=sprintf('% 11s',$rm76);
$A=substr($rm76,0,1);
$B=substr($rm76,1,1);
$C=substr($rm76,2,1);
$D=substr($rm76,3,1);
$E=substr($rm76,4,1);
$F=substr($rm76,5,1);
$G=substr($rm76,6,1);
$H=substr($rm76,7,1);
$I=substr($rm76,8,1);
$J=substr($rm76,9,1);
$K=substr($rm76,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r77=sprintf('% 11s',$r77);
$A=substr($r77,0,1);
$B=substr($r77,1,1);
$C=substr($r77,2,1);
$D=substr($r77,3,1);
$E=substr($r77,4,1);
$F=substr($r77,5,1);
$G=substr($r77,6,1);
$H=substr($r77,7,1);
$I=substr($r77,8,1);
$J=substr($r77,9,1);
$K=substr($r77,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm77=sprintf('% 11s',$rm77);
$A=substr($rm77,0,1);
$B=substr($rm77,1,1);
$C=substr($rm77,2,1);
$D=substr($rm77,3,1);
$E=substr($rm77,4,1);
$F=substr($rm77,5,1);
$G=substr($rm77,6,1);
$H=substr($rm77,7,1);
$I=substr($rm77,8,1);
$J=substr($rm77,9,1);
$K=substr($rm77,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r78=sprintf('% 11s',$r78);
$A=substr($r78,0,1);
$B=substr($r78,1,1);
$C=substr($r78,2,1);
$D=substr($r78,3,1);
$E=substr($r78,4,1);
$F=substr($r78,5,1);
$G=substr($r78,6,1);
$H=substr($r78,7,1);
$I=substr($r78,8,1);
$J=substr($r78,9,1);
$K=substr($r78,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm78=sprintf('% 11s',$rm78);
$A=substr($rm78,0,1);
$B=substr($rm78,1,1);
$C=substr($rm78,2,1);
$D=substr($rm78,3,1);
$E=substr($rm78,4,1);
$F=substr($rm78,5,1);
$G=substr($rm78,6,1);
$H=substr($rm78,7,1);
$I=substr($rm78,8,1);
$J=substr($rm78,9,1);
$K=substr($rm78,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r79=sprintf('% 11s',$r79);
$A=substr($r79,0,1);
$B=substr($r79,1,1);
$C=substr($r79,2,1);
$D=substr($r79,3,1);
$E=substr($r79,4,1);
$F=substr($r79,5,1);
$G=substr($r79,6,1);
$H=substr($r79,7,1);
$I=substr($r79,8,1);
$J=substr($r79,9,1);
$K=substr($r79,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm79=sprintf('% 11s',$rm79);
$A=substr($rm79,0,1);
$B=substr($rm79,1,1);
$C=substr($rm79,2,1);
$D=substr($rm79,3,1);
$E=substr($rm79,4,1);
$F=substr($rm79,5,1);
$G=substr($rm79,6,1);
$H=substr($rm79,7,1);
$I=substr($rm79,8,1);
$J=substr($rm79,9,1);
$K=substr($rm79,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r80=sprintf('% 11s',$r80);
$A=substr($r80,0,1);
$B=substr($r80,1,1);
$C=substr($r80,2,1);
$D=substr($r80,3,1);
$E=substr($r80,4,1);
$F=substr($r80,5,1);
$G=substr($r80,6,1);
$H=substr($r80,7,1);
$I=substr($r80,8,1);
$J=substr($r80,9,1);
$K=substr($r80,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm80=sprintf('% 11s',$rm80);
$A=substr($rm80,0,1);
$B=substr($rm80,1,1);
$C=substr($rm80,2,1);
$D=substr($rm80,3,1);
$E=substr($rm80,4,1);
$F=substr($rm80,5,1);
$G=substr($rm80,6,1);
$H=substr($rm80,7,1);
$I=substr($rm80,8,1);
$J=substr($rm80,9,1);
$K=substr($rm80,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r81=sprintf('% 11s',$r81);
$A=substr($r81,0,1);
$B=substr($r81,1,1);
$C=substr($r81,2,1);
$D=substr($r81,3,1);
$E=substr($r81,4,1);
$F=substr($r81,5,1);
$G=substr($r81,6,1);
$H=substr($r81,7,1);
$I=substr($r81,8,1);
$J=substr($r81,9,1);
$K=substr($r81,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm81=sprintf('% 11s',$rm81);
$A=substr($rm81,0,1);
$B=substr($rm81,1,1);
$C=substr($rm81,2,1);
$D=substr($rm81,3,1);
$E=substr($rm81,4,1);
$F=substr($rm81,5,1);
$G=substr($rm81,6,1);
$H=substr($rm81,7,1);
$I=substr($rm81,8,1);
$J=substr($rm81,9,1);
$K=substr($rm81,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r82=sprintf('% 11s',$r82);
$A=substr($r82,0,1);
$B=substr($r82,1,1);
$C=substr($r82,2,1);
$D=substr($r82,3,1);
$E=substr($r82,4,1);
$F=substr($r82,5,1);
$G=substr($r82,6,1);
$H=substr($r82,7,1);
$I=substr($r82,8,1);
$J=substr($r82,9,1);
$K=substr($r82,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm82=sprintf('% 11s',$rm82);
$A=substr($rm82,0,1);
$B=substr($rm82,1,1);
$C=substr($rm82,2,1);
$D=substr($rm82,3,1);
$E=substr($rm82,4,1);
$F=substr($rm82,5,1);
$G=substr($rm82,6,1);
$H=substr($rm82,7,1);
$I=substr($rm82,8,1);
$J=substr($rm82,9,1);
$K=substr($rm82,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r83=sprintf('% 11s',$r83);
$A=substr($r83,0,1);
$B=substr($r83,1,1);
$C=substr($r83,2,1);
$D=substr($r83,3,1);
$E=substr($r83,4,1);
$F=substr($r83,5,1);
$G=substr($r83,6,1);
$H=substr($r83,7,1);
$I=substr($r83,8,1);
$J=substr($r83,9,1);
$K=substr($r83,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm83=sprintf('% 11s',$rm83);
$A=substr($rm83,0,1);
$B=substr($rm83,1,1);
$C=substr($rm83,2,1);
$D=substr($rm83,3,1);
$E=substr($rm83,4,1);
$F=substr($rm83,5,1);
$G=substr($rm83,6,1);
$H=substr($rm83,7,1);
$I=substr($rm83,8,1);
$J=substr($rm83,9,1);
$K=substr($rm83,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r84=sprintf('% 11s',$r84);
$A=substr($r84,0,1);
$B=substr($r84,1,1);
$C=substr($r84,2,1);
$D=substr($r84,3,1);
$E=substr($r84,4,1);
$F=substr($r84,5,1);
$G=substr($r84,6,1);
$H=substr($r84,7,1);
$I=substr($r84,8,1);
$J=substr($r84,9,1);
$K=substr($r84,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm84=sprintf('% 11s',$rm84);
$A=substr($rm84,0,1);
$B=substr($rm84,1,1);
$C=substr($rm84,2,1);
$D=substr($rm84,3,1);
$E=substr($rm84,4,1);
$F=substr($rm84,5,1);
$G=substr($rm84,6,1);
$H=substr($rm84,7,1);
$I=substr($rm84,8,1);
$J=substr($rm84,9,1);
$K=substr($rm84,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r85=sprintf('% 11s',$r85);
$A=substr($r85,0,1);
$B=substr($r85,1,1);
$C=substr($r85,2,1);
$D=substr($r85,3,1);
$E=substr($r85,4,1);
$F=substr($r85,5,1);
$G=substr($r85,6,1);
$H=substr($r85,7,1);
$I=substr($r85,8,1);
$J=substr($r85,9,1);
$K=substr($r85,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm85=sprintf('% 11s',$rm85);
$A=substr($rm85,0,1);
$B=substr($rm85,1,1);
$C=substr($rm85,2,1);
$D=substr($rm85,3,1);
$E=substr($rm85,4,1);
$F=substr($rm85,5,1);
$G=substr($rm85,6,1);
$H=substr($rm85,7,1);
$I=substr($rm85,8,1);
$J=substr($rm85,9,1);
$K=substr($rm85,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r86=sprintf('% 11s',$r86);
$A=substr($r86,0,1);
$B=substr($r86,1,1);
$C=substr($r86,2,1);
$D=substr($r86,3,1);
$E=substr($r86,4,1);
$F=substr($r86,5,1);
$G=substr($r86,6,1);
$H=substr($r86,7,1);
$I=substr($r86,8,1);
$J=substr($r86,9,1);
$K=substr($r86,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm86=sprintf('% 11s',$rm86);
$A=substr($rm86,0,1);
$B=substr($rm86,1,1);
$C=substr($rm86,2,1);
$D=substr($rm86,3,1);
$E=substr($rm86,4,1);
$F=substr($rm86,5,1);
$G=substr($rm86,6,1);
$H=substr($rm86,7,1);
$I=substr($rm86,8,1);
$J=substr($rm86,9,1);
$K=substr($rm86,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r87=sprintf('% 11s',$r87);
$A=substr($r87,0,1);
$B=substr($r87,1,1);
$C=substr($r87,2,1);
$D=substr($r87,3,1);
$E=substr($r87,4,1);
$F=substr($r87,5,1);
$G=substr($r87,6,1);
$H=substr($r87,7,1);
$I=substr($r87,8,1);
$J=substr($r87,9,1);
$K=substr($r87,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm87=sprintf('% 11s',$rm87);
$A=substr($rm87,0,1);
$B=substr($rm87,1,1);
$C=substr($rm87,2,1);
$D=substr($rm87,3,1);
$E=substr($rm87,4,1);
$F=substr($rm87,5,1);
$G=substr($rm87,6,1);
$H=substr($rm87,7,1);
$I=substr($rm87,8,1);
$J=substr($rm87,9,1);
$K=substr($rm87,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r88=sprintf('% 11s',$r88);
$A=substr($r88,0,1);
$B=substr($r88,1,1);
$C=substr($r88,2,1);
$D=substr($r88,3,1);
$E=substr($r88,4,1);
$F=substr($r88,5,1);
$G=substr($r88,6,1);
$H=substr($r88,7,1);
$I=substr($r88,8,1);
$J=substr($r88,9,1);
$K=substr($r88,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm88=sprintf('% 11s',$rm88);
$A=substr($rm88,0,1);
$B=substr($rm88,1,1);
$C=substr($rm88,2,1);
$D=substr($rm88,3,1);
$E=substr($rm88,4,1);
$F=substr($rm88,5,1);
$G=substr($rm88,6,1);
$H=substr($rm88,7,1);
$I=substr($rm88,8,1);
$J=substr($rm88,9,1);
$K=substr($rm88,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r89=sprintf('% 11s',$r89);
$A=substr($r89,0,1);
$B=substr($r89,1,1);
$C=substr($r89,2,1);
$D=substr($r89,3,1);
$E=substr($r89,4,1);
$F=substr($r89,5,1);
$G=substr($r89,6,1);
$H=substr($r89,7,1);
$I=substr($r89,8,1);
$J=substr($r89,9,1);
$K=substr($r89,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm89=sprintf('% 11s',$rm89);
$A=substr($rm89,0,1);
$B=substr($rm89,1,1);
$C=substr($rm89,2,1);
$D=substr($rm89,3,1);
$E=substr($rm89,4,1);
$F=substr($rm89,5,1);
$G=substr($rm89,6,1);
$H=substr($rm89,7,1);
$I=substr($rm89,8,1);
$J=substr($rm89,9,1);
$K=substr($rm89,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r90=sprintf('% 11s',$r90);
$A=substr($r90,0,1);
$B=substr($r90,1,1);
$C=substr($r90,2,1);
$D=substr($r90,3,1);
$E=substr($r90,4,1);
$F=substr($r90,5,1);
$G=substr($r90,6,1);
$H=substr($r90,7,1);
$I=substr($r90,8,1);
$J=substr($r90,9,1);
$K=substr($r90,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm90=sprintf('% 11s',$rm90);
$A=substr($rm90,0,1);
$B=substr($rm90,1,1);
$C=substr($rm90,2,1);
$D=substr($rm90,3,1);
$E=substr($rm90,4,1);
$F=substr($rm90,5,1);
$G=substr($rm90,6,1);
$H=substr($rm90,7,1);
$I=substr($rm90,8,1);
$J=substr($rm90,9,1);
$K=substr($rm90,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r91=sprintf('% 11s',$r91);
$A=substr($r91,0,1);
$B=substr($r91,1,1);
$C=substr($r91,2,1);
$D=substr($r91,3,1);
$E=substr($r91,4,1);
$F=substr($r91,5,1);
$G=substr($r91,6,1);
$H=substr($r91,7,1);
$I=substr($r91,8,1);
$J=substr($r91,9,1);
$K=substr($r91,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm91=sprintf('% 11s',$rm91);
$A=substr($rm91,0,1);
$B=substr($rm91,1,1);
$C=substr($rm91,2,1);
$D=substr($rm91,3,1);
$E=substr($rm91,4,1);
$F=substr($rm91,5,1);
$G=substr($rm91,6,1);
$H=substr($rm91,7,1);
$I=substr($rm91,8,1);
$J=substr($rm91,9,1);
$K=substr($rm91,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r92=sprintf('% 11s',$r92);
$A=substr($r92,0,1);
$B=substr($r92,1,1);
$C=substr($r92,2,1);
$D=substr($r92,3,1);
$E=substr($r92,4,1);
$F=substr($r92,5,1);
$G=substr($r92,6,1);
$H=substr($r92,7,1);
$I=substr($r92,8,1);
$J=substr($r92,9,1);
$K=substr($r92,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm92=sprintf('% 11s',$rm92);
$A=substr($rm92,0,1);
$B=substr($rm92,1,1);
$C=substr($rm92,2,1);
$D=substr($rm92,3,1);
$E=substr($rm92,4,1);
$F=substr($rm92,5,1);
$G=substr($rm92,6,1);
$H=substr($rm92,7,1);
$I=substr($rm92,8,1);
$J=substr($rm92,9,1);
$K=substr($rm92,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,3," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r93=sprintf('% 11s',$r93);
$A=substr($r93,0,1);
$B=substr($r93,1,1);
$C=substr($r93,2,1);
$D=substr($r93,3,1);
$E=substr($r93,4,1);
$F=substr($r93,5,1);
$G=substr($r93,6,1);
$H=substr($r93,7,1);
$I=substr($r93,8,1);
$J=substr($r93,9,1);
$K=substr($r93,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm93=sprintf('% 11s',$rm93);
$A=substr($rm93,0,1);
$B=substr($rm93,1,1);
$C=substr($rm93,2,1);
$D=substr($rm93,3,1);
$E=substr($rm93,4,1);
$F=substr($rm93,5,1);
$G=substr($rm93,6,1);
$H=substr($rm93,7,1);
$I=substr($rm93,8,1);
$J=substr($rm93,9,1);
$K=substr($rm93,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r94=sprintf('% 11s',$r94);
$A=substr($r94,0,1);
$B=substr($r94,1,1);
$C=substr($r94,2,1);
$D=substr($r94,3,1);
$E=substr($r94,4,1);
$F=substr($r94,5,1);
$G=substr($r94,6,1);
$H=substr($r94,7,1);
$I=substr($r94,8,1);
$J=substr($r94,9,1);
$K=substr($r94,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm94=sprintf('% 11s',$rm94);
$A=substr($rm94,0,1);
$B=substr($rm94,1,1);
$C=substr($rm94,2,1);
$D=substr($rm94,3,1);
$E=substr($rm94,4,1);
$F=substr($rm94,5,1);
$G=substr($rm94,6,1);
$H=substr($rm94,7,1);
$I=substr($rm94,8,1);
$J=substr($rm94,9,1);
$K=substr($rm94,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r95=sprintf('% 11s',$r95);
$A=substr($r95,0,1);
$B=substr($r95,1,1);
$C=substr($r95,2,1);
$D=substr($r95,3,1);
$E=substr($r95,4,1);
$F=substr($r95,5,1);
$G=substr($r95,6,1);
$H=substr($r95,7,1);
$I=substr($r95,8,1);
$J=substr($r95,9,1);
$K=substr($r95,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm95=sprintf('% 11s',$rm95);
$A=substr($rm95,0,1);
$B=substr($rm95,1,1);
$C=substr($rm95,2,1);
$D=substr($rm95,3,1);
$E=substr($rm95,4,1);
$F=substr($rm95,5,1);
$G=substr($rm95,6,1);
$H=substr($rm95,7,1);
$I=substr($rm95,8,1);
$J=substr($rm95,9,1);
$K=substr($rm95,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r96=sprintf('% 11s',$r96);
$A=substr($r96,0,1);
$B=substr($r96,1,1);
$C=substr($r96,2,1);
$D=substr($r96,3,1);
$E=substr($r96,4,1);
$F=substr($r96,5,1);
$G=substr($r96,6,1);
$H=substr($r96,7,1);
$I=substr($r96,8,1);
$J=substr($r96,9,1);
$K=substr($r96,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm96=sprintf('% 11s',$rm96);
$A=substr($rm96,0,1);
$B=substr($rm96,1,1);
$C=substr($rm96,2,1);
$D=substr($rm96,3,1);
$E=substr($rm96,4,1);
$F=substr($rm96,5,1);
$G=substr($rm96,6,1);
$H=substr($rm96,7,1);
$I=substr($rm96,8,1);
$J=substr($rm96,9,1);
$K=substr($rm96,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r97=sprintf('% 11s',$r97);
$A=substr($r97,0,1);
$B=substr($r97,1,1);
$C=substr($r97,2,1);
$D=substr($r97,3,1);
$E=substr($r97,4,1);
$F=substr($r97,5,1);
$G=substr($r97,6,1);
$H=substr($r97,7,1);
$I=substr($r97,8,1);
$J=substr($r97,9,1);
$K=substr($r97,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm97=sprintf('% 11s',$rm97);
$A=substr($rm97,0,1);
$B=substr($rm97,1,1);
$C=substr($rm97,2,1);
$D=substr($rm97,3,1);
$E=substr($rm97,4,1);
$F=substr($rm97,5,1);
$G=substr($rm97,6,1);
$H=substr($rm97,7,1);
$I=substr($rm97,8,1);
$J=substr($rm97,9,1);
$K=substr($rm97,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");


//koniec strana 7

$pdf->AddPage();
$pdf->SetFont('arial','',10);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/suvaha2011/11suvaha-8.jpg') AND $i == 0 )
{
if( $fort == 1 ) { $pdf->Image('../dokumenty/suvaha2011/11suvaha-8.jpg',12,11,186,275); }
}


$pdf->SetY(10);
$pdf->SetFont('arial','',12);

//dic
$pdf->Cell(190,5,"     ","$rmc",1,"L");

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

$pdf->Cell(72,5," ","$rmc",0,"R");$pdf->Cell(4,5,"$A","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(4,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(4,5,"$J","$rmc",1,"C");

$pdf->Cell(190,14,"     ","$rmc",1,"L");


$pdf->Cell(76,6," ","$rmc",0,"R");
$r98=sprintf('% 11s',$r98);
$A=substr($r98,0,1);
$B=substr($r98,1,1);
$C=substr($r98,2,1);
$D=substr($r98,3,1);
$E=substr($r98,4,1);
$F=substr($r98,5,1);
$G=substr($r98,6,1);
$H=substr($r98,7,1);
$I=substr($r98,8,1);
$J=substr($r98,9,1);
$K=substr($r98,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm98=sprintf('% 11s',$rm98);
$A=substr($rm98,0,1);
$B=substr($rm98,1,1);
$C=substr($rm98,2,1);
$D=substr($rm98,3,1);
$E=substr($rm98,4,1);
$F=substr($rm98,5,1);
$G=substr($rm98,6,1);
$H=substr($rm98,7,1);
$I=substr($rm98,8,1);
$J=substr($rm98,9,1);
$K=substr($rm98,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r99=sprintf('% 11s',$r99);
$A=substr($r99,0,1);
$B=substr($r99,1,1);
$C=substr($r99,2,1);
$D=substr($r99,3,1);
$E=substr($r99,4,1);
$F=substr($r99,5,1);
$G=substr($r99,6,1);
$H=substr($r99,7,1);
$I=substr($r99,8,1);
$J=substr($r99,9,1);
$K=substr($r99,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm99=sprintf('% 11s',$rm99);
$A=substr($rm99,0,1);
$B=substr($rm99,1,1);
$C=substr($rm99,2,1);
$D=substr($rm99,3,1);
$E=substr($rm99,4,1);
$F=substr($rm99,5,1);
$G=substr($rm99,6,1);
$H=substr($rm99,7,1);
$I=substr($rm99,8,1);
$J=substr($rm99,9,1);
$K=substr($rm99,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r100=sprintf('% 11s',$r100);
$A=substr($r100,0,1);
$B=substr($r100,1,1);
$C=substr($r100,2,1);
$D=substr($r100,3,1);
$E=substr($r100,4,1);
$F=substr($r100,5,1);
$G=substr($r100,6,1);
$H=substr($r100,7,1);
$I=substr($r100,8,1);
$J=substr($r100,9,1);
$K=substr($r100,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm100=sprintf('% 11s',$rm100);
$A=substr($rm100,0,1);
$B=substr($rm100,1,1);
$C=substr($rm100,2,1);
$D=substr($rm100,3,1);
$E=substr($rm100,4,1);
$F=substr($rm100,5,1);
$G=substr($rm100,6,1);
$H=substr($rm100,7,1);
$I=substr($rm100,8,1);
$J=substr($rm100,9,1);
$K=substr($rm100,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");


$pdf->Cell(76,6," ","$rmc",0,"R");
$r101=sprintf('% 11s',$r101);
$A=substr($r101,0,1);
$B=substr($r101,1,1);
$C=substr($r101,2,1);
$D=substr($r101,3,1);
$E=substr($r101,4,1);
$F=substr($r101,5,1);
$G=substr($r101,6,1);
$H=substr($r101,7,1);
$I=substr($r101,8,1);
$J=substr($r101,9,1);
$K=substr($r101,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm101=sprintf('% 11s',$rm101);
$A=substr($rm101,0,1);
$B=substr($rm101,1,1);
$C=substr($rm101,2,1);
$D=substr($rm101,3,1);
$E=substr($rm101,4,1);
$F=substr($rm101,5,1);
$G=substr($rm101,6,1);
$H=substr($rm101,7,1);
$I=substr($rm101,8,1);
$J=substr($rm101,9,1);
$K=substr($rm101,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r102=sprintf('% 11s',$r102);
$A=substr($r102,0,1);
$B=substr($r102,1,1);
$C=substr($r102,2,1);
$D=substr($r102,3,1);
$E=substr($r102,4,1);
$F=substr($r102,5,1);
$G=substr($r102,6,1);
$H=substr($r102,7,1);
$I=substr($r102,8,1);
$J=substr($r102,9,1);
$K=substr($r102,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm102=sprintf('% 11s',$rm102);
$A=substr($rm102,0,1);
$B=substr($rm102,1,1);
$C=substr($rm102,2,1);
$D=substr($rm102,3,1);
$E=substr($rm102,4,1);
$F=substr($rm102,5,1);
$G=substr($rm102,6,1);
$H=substr($rm102,7,1);
$I=substr($rm102,8,1);
$J=substr($rm102,9,1);
$K=substr($rm102,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r103=sprintf('% 11s',$r103);
$A=substr($r103,0,1);
$B=substr($r103,1,1);
$C=substr($r103,2,1);
$D=substr($r103,3,1);
$E=substr($r103,4,1);
$F=substr($r103,5,1);
$G=substr($r103,6,1);
$H=substr($r103,7,1);
$I=substr($r103,8,1);
$J=substr($r103,9,1);
$K=substr($r103,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm103=sprintf('% 11s',$rm103);
$A=substr($rm103,0,1);
$B=substr($rm103,1,1);
$C=substr($rm103,2,1);
$D=substr($rm103,3,1);
$E=substr($rm103,4,1);
$F=substr($rm103,5,1);
$G=substr($rm103,6,1);
$H=substr($rm103,7,1);
$I=substr($rm103,8,1);
$J=substr($rm103,9,1);
$K=substr($rm103,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r104=sprintf('% 11s',$r104);
$A=substr($r104,0,1);
$B=substr($r104,1,1);
$C=substr($r104,2,1);
$D=substr($r104,3,1);
$E=substr($r104,4,1);
$F=substr($r104,5,1);
$G=substr($r104,6,1);
$H=substr($r104,7,1);
$I=substr($r104,8,1);
$J=substr($r104,9,1);
$K=substr($r104,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm104=sprintf('% 11s',$rm104);
$A=substr($rm104,0,1);
$B=substr($rm104,1,1);
$C=substr($rm104,2,1);
$D=substr($rm104,3,1);
$E=substr($rm104,4,1);
$F=substr($rm104,5,1);
$G=substr($rm104,6,1);
$H=substr($rm104,7,1);
$I=substr($rm104,8,1);
$J=substr($rm104,9,1);
$K=substr($rm104,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r105=sprintf('% 11s',$r105);
$A=substr($r105,0,1);
$B=substr($r105,1,1);
$C=substr($r105,2,1);
$D=substr($r105,3,1);
$E=substr($r105,4,1);
$F=substr($r105,5,1);
$G=substr($r105,6,1);
$H=substr($r105,7,1);
$I=substr($r105,8,1);
$J=substr($r105,9,1);
$K=substr($r105,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm105=sprintf('% 11s',$rm105);
$A=substr($rm105,0,1);
$B=substr($rm105,1,1);
$C=substr($rm105,2,1);
$D=substr($rm105,3,1);
$E=substr($rm105,4,1);
$F=substr($rm105,5,1);
$G=substr($rm105,6,1);
$H=substr($rm105,7,1);
$I=substr($rm105,8,1);
$J=substr($rm105,9,1);
$K=substr($rm105,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r106=sprintf('% 11s',$r106);
$A=substr($r106,0,1);
$B=substr($r106,1,1);
$C=substr($r106,2,1);
$D=substr($r106,3,1);
$E=substr($r106,4,1);
$F=substr($r106,5,1);
$G=substr($r106,6,1);
$H=substr($r106,7,1);
$I=substr($r106,8,1);
$J=substr($r106,9,1);
$K=substr($r106,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm106=sprintf('% 11s',$rm106);
$A=substr($rm106,0,1);
$B=substr($rm106,1,1);
$C=substr($rm106,2,1);
$D=substr($rm106,3,1);
$E=substr($rm106,4,1);
$F=substr($rm106,5,1);
$G=substr($rm106,6,1);
$H=substr($rm106,7,1);
$I=substr($rm106,8,1);
$J=substr($rm106,9,1);
$K=substr($rm106,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r107=sprintf('% 11s',$r107);
$A=substr($r107,0,1);
$B=substr($r107,1,1);
$C=substr($r107,2,1);
$D=substr($r107,3,1);
$E=substr($r107,4,1);
$F=substr($r107,5,1);
$G=substr($r107,6,1);
$H=substr($r107,7,1);
$I=substr($r107,8,1);
$J=substr($r107,9,1);
$K=substr($r107,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm107=sprintf('% 11s',$rm107);
$A=substr($rm107,0,1);
$B=substr($rm107,1,1);
$C=substr($rm107,2,1);
$D=substr($rm107,3,1);
$E=substr($rm107,4,1);
$F=substr($rm107,5,1);
$G=substr($rm107,6,1);
$H=substr($rm107,7,1);
$I=substr($rm107,8,1);
$J=substr($rm107,9,1);
$K=substr($rm107,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r108=sprintf('% 11s',$r108);
$A=substr($r108,0,1);
$B=substr($r108,1,1);
$C=substr($r108,2,1);
$D=substr($r108,3,1);
$E=substr($r108,4,1);
$F=substr($r108,5,1);
$G=substr($r108,6,1);
$H=substr($r108,7,1);
$I=substr($r108,8,1);
$J=substr($r108,9,1);
$K=substr($r108,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm108=sprintf('% 11s',$rm108);
$A=substr($rm108,0,1);
$B=substr($rm108,1,1);
$C=substr($rm108,2,1);
$D=substr($rm108,3,1);
$E=substr($rm108,4,1);
$F=substr($rm108,5,1);
$G=substr($rm108,6,1);
$H=substr($rm108,7,1);
$I=substr($rm108,8,1);
$J=substr($rm108,9,1);
$K=substr($rm108,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r109=sprintf('% 11s',$r109);
$A=substr($r109,0,1);
$B=substr($r109,1,1);
$C=substr($r109,2,1);
$D=substr($r109,3,1);
$E=substr($r109,4,1);
$F=substr($r109,5,1);
$G=substr($r109,6,1);
$H=substr($r109,7,1);
$I=substr($r109,8,1);
$J=substr($r109,9,1);
$K=substr($r109,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm109=sprintf('% 11s',$rm109);
$A=substr($rm109,0,1);
$B=substr($rm109,1,1);
$C=substr($rm109,2,1);
$D=substr($rm109,3,1);
$E=substr($rm109,4,1);
$F=substr($rm109,5,1);
$G=substr($rm109,6,1);
$H=substr($rm109,7,1);
$I=substr($rm109,8,1);
$J=substr($rm109,9,1);
$K=substr($rm109,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r110=sprintf('% 11s',$r110);
$A=substr($r110,0,1);
$B=substr($r110,1,1);
$C=substr($r110,2,1);
$D=substr($r110,3,1);
$E=substr($r110,4,1);
$F=substr($r110,5,1);
$G=substr($r110,6,1);
$H=substr($r110,7,1);
$I=substr($r110,8,1);
$J=substr($r110,9,1);
$K=substr($r110,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm110=sprintf('% 11s',$rm110);
$A=substr($rm110,0,1);
$B=substr($rm110,1,1);
$C=substr($rm110,2,1);
$D=substr($rm110,3,1);
$E=substr($rm110,4,1);
$F=substr($rm110,5,1);
$G=substr($rm110,6,1);
$H=substr($rm110,7,1);
$I=substr($rm110,8,1);
$J=substr($rm110,9,1);
$K=substr($rm110,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r111=sprintf('% 11s',$r111);
$A=substr($r111,0,1);
$B=substr($r111,1,1);
$C=substr($r111,2,1);
$D=substr($r111,3,1);
$E=substr($r111,4,1);
$F=substr($r111,5,1);
$G=substr($r111,6,1);
$H=substr($r111,7,1);
$I=substr($r111,8,1);
$J=substr($r111,9,1);
$K=substr($r111,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm111=sprintf('% 11s',$rm111);
$A=substr($rm111,0,1);
$B=substr($rm111,1,1);
$C=substr($rm111,2,1);
$D=substr($rm111,3,1);
$E=substr($rm111,4,1);
$F=substr($rm111,5,1);
$G=substr($rm111,6,1);
$H=substr($rm111,7,1);
$I=substr($rm111,8,1);
$J=substr($rm111,9,1);
$K=substr($rm111,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r112=sprintf('% 11s',$r112);
$A=substr($r112,0,1);
$B=substr($r112,1,1);
$C=substr($r112,2,1);
$D=substr($r112,3,1);
$E=substr($r112,4,1);
$F=substr($r112,5,1);
$G=substr($r112,6,1);
$H=substr($r112,7,1);
$I=substr($r112,8,1);
$J=substr($r112,9,1);
$K=substr($r112,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm112=sprintf('% 11s',$rm112);
$A=substr($rm112,0,1);
$B=substr($rm112,1,1);
$C=substr($rm112,2,1);
$D=substr($rm112,3,1);
$E=substr($rm112,4,1);
$F=substr($rm112,5,1);
$G=substr($rm112,6,1);
$H=substr($rm112,7,1);
$I=substr($rm112,8,1);
$J=substr($rm112,9,1);
$K=substr($rm112,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r113=sprintf('% 11s',$r113);
$A=substr($r113,0,1);
$B=substr($r113,1,1);
$C=substr($r113,2,1);
$D=substr($r113,3,1);
$E=substr($r113,4,1);
$F=substr($r113,5,1);
$G=substr($r113,6,1);
$H=substr($r113,7,1);
$I=substr($r113,8,1);
$J=substr($r113,9,1);
$K=substr($r113,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm113=sprintf('% 11s',$rm113);
$A=substr($rm113,0,1);
$B=substr($rm113,1,1);
$C=substr($rm113,2,1);
$D=substr($rm113,3,1);
$E=substr($rm113,4,1);
$F=substr($rm113,5,1);
$G=substr($rm113,6,1);
$H=substr($rm113,7,1);
$I=substr($rm113,8,1);
$J=substr($rm113,9,1);
$K=substr($rm113,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r114=sprintf('% 11s',$r114);
$A=substr($r114,0,1);
$B=substr($r114,1,1);
$C=substr($r114,2,1);
$D=substr($r114,3,1);
$E=substr($r114,4,1);
$F=substr($r114,5,1);
$G=substr($r114,6,1);
$H=substr($r114,7,1);
$I=substr($r114,8,1);
$J=substr($r114,9,1);
$K=substr($r114,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm114=sprintf('% 11s',$rm114);
$A=substr($rm114,0,1);
$B=substr($rm114,1,1);
$C=substr($rm114,2,1);
$D=substr($rm114,3,1);
$E=substr($rm114,4,1);
$F=substr($rm114,5,1);
$G=substr($rm114,6,1);
$H=substr($rm114,7,1);
$I=substr($rm114,8,1);
$J=substr($rm114,9,1);
$K=substr($rm114,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r115=sprintf('% 11s',$r115);
$A=substr($r115,0,1);
$B=substr($r115,1,1);
$C=substr($r115,2,1);
$D=substr($r115,3,1);
$E=substr($r115,4,1);
$F=substr($r115,5,1);
$G=substr($r115,6,1);
$H=substr($r115,7,1);
$I=substr($r115,8,1);
$J=substr($r115,9,1);
$K=substr($r115,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm115=sprintf('% 11s',$rm115);
$A=substr($rm115,0,1);
$B=substr($rm115,1,1);
$C=substr($rm115,2,1);
$D=substr($rm115,3,1);
$E=substr($rm115,4,1);
$F=substr($rm115,5,1);
$G=substr($rm115,6,1);
$H=substr($rm115,7,1);
$I=substr($rm115,8,1);
$J=substr($rm115,9,1);
$K=substr($rm115,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r116=sprintf('% 11s',$r116);
$A=substr($r116,0,1);
$B=substr($r116,1,1);
$C=substr($r116,2,1);
$D=substr($r116,3,1);
$E=substr($r116,4,1);
$F=substr($r116,5,1);
$G=substr($r116,6,1);
$H=substr($r116,7,1);
$I=substr($r116,8,1);
$J=substr($r116,9,1);
$K=substr($r116,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm116=sprintf('% 11s',$rm116);
$A=substr($rm116,0,1);
$B=substr($rm116,1,1);
$C=substr($rm116,2,1);
$D=substr($rm116,3,1);
$E=substr($rm116,4,1);
$F=substr($rm116,5,1);
$G=substr($rm116,6,1);
$H=substr($rm116,7,1);
$I=substr($rm116,8,1);
$J=substr($rm116,9,1);
$K=substr($rm116,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r117=sprintf('% 11s',$r117);
$A=substr($r117,0,1);
$B=substr($r117,1,1);
$C=substr($r117,2,1);
$D=substr($r117,3,1);
$E=substr($r117,4,1);
$F=substr($r117,5,1);
$G=substr($r117,6,1);
$H=substr($r117,7,1);
$I=substr($r117,8,1);
$J=substr($r117,9,1);
$K=substr($r117,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm117=sprintf('% 11s',$rm117);
$A=substr($rm117,0,1);
$B=substr($rm117,1,1);
$C=substr($rm117,2,1);
$D=substr($rm117,3,1);
$E=substr($rm117,4,1);
$F=substr($rm117,5,1);
$G=substr($rm117,6,1);
$H=substr($rm117,7,1);
$I=substr($rm117,8,1);
$J=substr($rm117,9,1);
$K=substr($rm117,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r118=sprintf('% 11s',$r118);
$A=substr($r118,0,1);
$B=substr($r118,1,1);
$C=substr($r118,2,1);
$D=substr($r118,3,1);
$E=substr($r118,4,1);
$F=substr($r118,5,1);
$G=substr($r118,6,1);
$H=substr($r118,7,1);
$I=substr($r118,8,1);
$J=substr($r118,9,1);
$K=substr($r118,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm118=sprintf('% 11s',$rm118);
$A=substr($rm118,0,1);
$B=substr($rm118,1,1);
$C=substr($rm118,2,1);
$D=substr($rm118,3,1);
$E=substr($rm118,4,1);
$F=substr($rm118,5,1);
$G=substr($rm118,6,1);
$H=substr($rm118,7,1);
$I=substr($rm118,8,1);
$J=substr($rm118,9,1);
$K=substr($rm118,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r119=sprintf('% 11s',$r119);
$A=substr($r119,0,1);
$B=substr($r119,1,1);
$C=substr($r119,2,1);
$D=substr($r119,3,1);
$E=substr($r119,4,1);
$F=substr($r119,5,1);
$G=substr($r119,6,1);
$H=substr($r119,7,1);
$I=substr($r119,8,1);
$J=substr($r119,9,1);
$K=substr($r119,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm119=sprintf('% 11s',$rm119);
$A=substr($rm119,0,1);
$B=substr($rm119,1,1);
$C=substr($rm119,2,1);
$D=substr($rm119,3,1);
$E=substr($rm119,4,1);
$F=substr($rm119,5,1);
$G=substr($rm119,6,1);
$H=substr($rm119,7,1);
$I=substr($rm119,8,1);
$J=substr($rm119,9,1);
$K=substr($rm119,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r120=sprintf('% 11s',$r120);
$A=substr($r120,0,1);
$B=substr($r120,1,1);
$C=substr($r120,2,1);
$D=substr($r120,3,1);
$E=substr($r120,4,1);
$F=substr($r120,5,1);
$G=substr($r120,6,1);
$H=substr($r120,7,1);
$I=substr($r120,8,1);
$J=substr($r120,9,1);
$K=substr($r120,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm120=sprintf('% 11s',$rm120);
$A=substr($rm120,0,1);
$B=substr($rm120,1,1);
$C=substr($rm120,2,1);
$D=substr($rm120,3,1);
$E=substr($rm120,4,1);
$F=substr($rm120,5,1);
$G=substr($rm120,6,1);
$H=substr($rm120,7,1);
$I=substr($rm120,8,1);
$J=substr($rm120,9,1);
$K=substr($rm120,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r121=sprintf('% 11s',$r121);
$A=substr($r121,0,1);
$B=substr($r121,1,1);
$C=substr($r121,2,1);
$D=substr($r121,3,1);
$E=substr($r121,4,1);
$F=substr($r121,5,1);
$G=substr($r121,6,1);
$H=substr($r121,7,1);
$I=substr($r121,8,1);
$J=substr($r121,9,1);
$K=substr($r121,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm121=sprintf('% 11s',$rm121);
$A=substr($rm121,0,1);
$B=substr($rm121,1,1);
$C=substr($rm121,2,1);
$D=substr($rm121,3,1);
$E=substr($rm121,4,1);
$F=substr($rm121,5,1);
$G=substr($rm121,6,1);
$H=substr($rm121,7,1);
$I=substr($rm121,8,1);
$J=substr($rm121,9,1);
$K=substr($rm121,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r122=sprintf('% 11s',$r122);
$A=substr($r122,0,1);
$B=substr($r122,1,1);
$C=substr($r122,2,1);
$D=substr($r122,3,1);
$E=substr($r122,4,1);
$F=substr($r122,5,1);
$G=substr($r122,6,1);
$H=substr($r122,7,1);
$I=substr($r122,8,1);
$J=substr($r122,9,1);
$K=substr($r122,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm122=sprintf('% 11s',$rm122);
$A=substr($rm122,0,1);
$B=substr($rm122,1,1);
$C=substr($rm122,2,1);
$D=substr($rm122,3,1);
$E=substr($rm122,4,1);
$F=substr($rm122,5,1);
$G=substr($rm122,6,1);
$H=substr($rm122,7,1);
$I=substr($rm122,8,1);
$J=substr($rm122,9,1);
$K=substr($rm122,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r123=sprintf('% 11s',$r123);
$A=substr($r123,0,1);
$B=substr($r123,1,1);
$C=substr($r123,2,1);
$D=substr($r123,3,1);
$E=substr($r123,4,1);
$F=substr($r123,5,1);
$G=substr($r123,6,1);
$H=substr($r123,7,1);
$I=substr($r123,8,1);
$J=substr($r123,9,1);
$K=substr($r123,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm123=sprintf('% 11s',$rm123);
$A=substr($rm123,0,1);
$B=substr($rm123,1,1);
$C=substr($rm123,2,1);
$D=substr($rm123,3,1);
$E=substr($rm123,4,1);
$F=substr($rm123,5,1);
$G=substr($rm123,6,1);
$H=substr($rm123,7,1);
$I=substr($rm123,8,1);
$J=substr($rm123,9,1);
$K=substr($rm123,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");

$pdf->Cell(76,6," ","$rmc",0,"R");
$r124=sprintf('% 11s',$r124);
$A=substr($r124,0,1);
$B=substr($r124,1,1);
$C=substr($r124,2,1);
$D=substr($r124,3,1);
$E=substr($r124,4,1);
$F=substr($r124,5,1);
$G=substr($r124,6,1);
$H=substr($r124,7,1);
$I=substr($r124,8,1);
$J=substr($r124,9,1);
$K=substr($r124,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm124=sprintf('% 11s',$rm124);
$A=substr($rm124,0,1);
$B=substr($rm124,1,1);
$C=substr($rm124,2,1);
$D=substr($rm124,3,1);
$E=substr($rm124,4,1);
$F=substr($rm124,5,1);
$G=substr($rm124,6,1);
$H=substr($rm124,7,1);
$I=substr($rm124,8,1);
$J=substr($rm124,9,1);
$K=substr($rm124,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");
$pdf->Cell(76,6," ","$rmc",0,"R");
$r125=sprintf('% 11s',$r125);
$A=substr($r125,0,1);
$B=substr($r125,1,1);
$C=substr($r125,2,1);
$D=substr($r125,3,1);
$E=substr($r125,4,1);
$F=substr($r125,5,1);
$G=substr($r125,6,1);
$H=substr($r125,7,1);
$I=substr($r125,8,1);
$J=substr($r125,9,1);
$K=substr($r125,10,1);
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(3,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");
$rm125=sprintf('% 11s',$rm125);
$A=substr($rm125,0,1);
$B=substr($rm125,1,1);
$C=substr($rm125,2,1);
$D=substr($rm125,3,1);
$E=substr($rm125,4,1);
$F=substr($rm125,5,1);
$G=substr($rm125,6,1);
$H=substr($rm125,7,1);
$I=substr($rm125,8,1);
$J=substr($rm125,9,1);
$K=substr($rm125,10,1);
$pdf->Cell(3,6," ","$rmc",0,"R");
$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(4,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",1,"C");
$pdf->Cell(150,2," ","$rmc",1,"R");
$pdf->Cell(150,1," ","$rmc",1,"R");

//generovanie strany
$generuj=0;
if( $generuj == 1 )
          {
if (File_Exists ("../tmp/vlozvkzs$kli_uzid.php")) { $soubor = unlink("../tmp/vlozvkzs$kli_uzid.php"); }
$soubor = fopen("../tmp/vlozvkzs$kli_uzid.php", "a+");

  $text = "<?php"."\r\n";
  fwrite($soubor, $text);

$rdk=101;
while ($rdk <= 123 ) 
  {
$crdk=$rdk;
if( $rdk < 10 ) $crdk="0".$rdk;


$text="\$pdf->Cell(77,6,\" \",\"1\",0,\"R\");"."\r\n";
fwrite($soubor, $text);

$text="\$r".$crdk."=sprintf('% 11s',\$r".$crdk.");"."\r\n";
fwrite($soubor, $text);

$text="\$A=substr(\$r".$crdk.",0,1);"."\r\n";
fwrite($soubor, $text);
$text="\$B=substr(\$r".$crdk.",1,1);"."\r\n";
fwrite($soubor, $text);
$text="\$C=substr(\$r".$crdk.",2,1);"."\r\n";
fwrite($soubor, $text);
$text="\$D=substr(\$r".$crdk.",3,1);"."\r\n";
fwrite($soubor, $text);
$text="\$E=substr(\$r".$crdk.",4,1);"."\r\n";
fwrite($soubor, $text);
$text="\$F=substr(\$r".$crdk.",5,1);"."\r\n";
fwrite($soubor, $text);
$text="\$G=substr(\$r".$crdk.",6,1);"."\r\n";
fwrite($soubor, $text);
$text="\$H=substr(\$r".$crdk.",7,1);"."\r\n";
fwrite($soubor, $text);
$text="\$I=substr(\$r".$crdk.",8,1);"."\r\n";
fwrite($soubor, $text);
$text="\$J=substr(\$r".$crdk.",9,1);"."\r\n";
fwrite($soubor, $text);
$text="\$K=substr(\$r".$crdk.",10,1);"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\"\$A\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$B\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$C\",\"1\",0,\"C\");\$pdf->Cell(2,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$D\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$E\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$F\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$G\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(5,6,\"\$H\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$I\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$J\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$K\",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);


$text="\$rm".$crdk."=sprintf('% 11s',\$rm".$crdk.");"."\r\n";
fwrite($soubor, $text);

$text="\$A=substr(\$rm".$crdk.",0,1);"."\r\n";
fwrite($soubor, $text);
$text="\$B=substr(\$rm".$crdk.",1,1);"."\r\n";
fwrite($soubor, $text);
$text="\$C=substr(\$rm".$crdk.",2,1);"."\r\n";
fwrite($soubor, $text);
$text="\$D=substr(\$rm".$crdk.",3,1);"."\r\n";
fwrite($soubor, $text);
$text="\$E=substr(\$rm".$crdk.",4,1);"."\r\n";
fwrite($soubor, $text);
$text="\$F=substr(\$rm".$crdk.",5,1);"."\r\n";
fwrite($soubor, $text);
$text="\$G=substr(\$rm".$crdk.",6,1);"."\r\n";
fwrite($soubor, $text);
$text="\$H=substr(\$rm".$crdk.",7,1);"."\r\n";
fwrite($soubor, $text);
$text="\$I=substr(\$rm".$crdk.",8,1);"."\r\n";
fwrite($soubor, $text);
$text="\$J=substr(\$rm".$crdk.",9,1);"."\r\n";
fwrite($soubor, $text);
$text="\$K=substr(\$rm".$crdk.",10,1);"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\" \",\"1\",0,\"R\");"."\r\n";
fwrite($soubor, $text);

$text="\$pdf->Cell(4,6,\"\$A\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$B\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$C\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$D\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$E\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$F\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$G\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(5,6,\"\$H\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$I\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");"."\r\n";
fwrite($soubor, $text);
$text="\$pdf->Cell(4,6,\"\$J\",\"1\",0,\"C\");\$pdf->Cell(1,6,\" \",\"1\",0,\"C\");\$pdf->Cell(4,6,\"\$K\",\"1\",1,\"C\");"."\r\n";
fwrite($soubor, $text);


$text="\$pdf->Cell(150,2,\" \",\"1\",1,\"R\");"."\r\n";
fwrite($soubor, $text);


if( $rdk != 103 AND $rdk != 107 AND $rdk != 111 AND $rdk != 116 AND $rdk != 121 )
{
$text="\$pdf->Cell(150,1,\" \",\"1\",1,\"R\");"."\r\n";
fwrite($soubor, $text);
} 

$rdk=$rdk+1;
  }

  $text = "?>"."\r\n";
  fwrite($soubor, $text);

  fclose($soubor);

include("../tmp/vlozvkzs$kli_uzid.php");
          }
//koniec generovania



//koniec strana 8

}
$i = $i + 1;

  }

//koniec zostava mesacna
}




$pdf->Output("../tmp/suvaha.$kli_uzid.pdf");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvahas'.$kli_uzid;
if( $analyzy == 0 ) $vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuvaha'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];

if( $tis == 0 AND $kli_vmesx < 12 ) { 
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcsuv1000ahas'.$kli_uzid;
if( $xml == 0 )$vysledok = mysql_query("$sqlt");
                }
?> 
<?php if( $xml == 0 ) { ?>

<script type="text/javascript">
  var okno = window.open("../tmp/suvaha.<?php echo $kli_uzid; ?>.pdf","_self");

<?php                 } ?>
</script>
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


<?php if( $xml == 1 ) { ?>

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  Súvaha - súbor FDF

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<?php
function prevodkodov( $zdroj )
         {
$vysledok = StrTr($zdroj, "á","\341");
$vysledok = StrTr($vysledok, "è","\226");
$vysledok = StrTr($vysledok, "ä","\344");
$vysledok = StrTr($vysledok, "(","\(");
$vysledok = StrTr($vysledok, ")","\)");
//$vysledok = StrTr($vysledok, "\","\\");
$vysledok = StrTr($vysledok, "<","\210");
$vysledok = StrTr($vysledok, ">","\211");
$vysledok = StrTr($vysledok, "‰","\213");
$vysledok = StrTr($vysledok, "€","\240");
$vysledok = StrTr($vysledok, "Á","\304");
$vysledok = StrTr($vysledok, "á","\341");
$vysledok = StrTr($vysledok, "Ä","\304");
$vysledok = StrTr($vysledok, "È","\225");
$vysledok = StrTr($vysledok, "Ï","\230");
$vysledok = StrTr($vysledok, "ï","\232");
$vysledok = StrTr($vysledok, "É","\311");
$vysledok = StrTr($vysledok, "é","\351");
$vysledok = StrTr($vysledok, "Ì","\233");
$vysledok = StrTr($vysledok, "ì","\234");
$vysledok = StrTr($vysledok, "Ë","\313");
$vysledok = StrTr($vysledok, "ë","\353");
$vysledok = StrTr($vysledok, "Í","\315");
$vysledok = StrTr($vysledok, "í","\355");
$vysledok = StrTr($vysledok, "Å","\241");
$vysledok = StrTr($vysledok, "å","\242");
$vysledok = StrTr($vysledok, "¼","\245");
$vysledok = StrTr($vysledok, "¾","\251");
$vysledok = StrTr($vysledok, "Ò","\252");
$vysledok = StrTr($vysledok, "ò","\254");
$vysledok = StrTr($vysledok, "Ó","\323");
$vysledok = StrTr($vysledok, "ó","\363");
$vysledok = StrTr($vysledok, "Ô","\324");
$vysledok = StrTr($vysledok, "ô","\364");
$vysledok = StrTr($vysledok, "À","\203");
$vysledok = StrTr($vysledok, "à","\261");
$vysledok = StrTr($vysledok, "Ø","\277");
$vysledok = StrTr($vysledok, "ø","\272");
//$vysledok = StrTr($vysledok, "Š","\227");
//$vysledok = StrTr($vysledok, "š","\235");
$vysledok = StrTr($vysledok, "Š","S");
$vysledok = StrTr($vysledok, "š","s");
$vysledok = StrTr($vysledok, "","\222");
$vysledok = StrTr($vysledok, "","\243");
$vysledok = StrTr($vysledok, "Ú","\332");
$vysledok = StrTr($vysledok, "ú","\372");
$vysledok = StrTr($vysledok, "Ù","\262");
$vysledok = StrTr($vysledok, "ù","\263");
$vysledok = StrTr($vysledok, "Ý","\335");
$vysledok = StrTr($vysledok, "ý","\375");
$vysledok = StrTr($vysledok, "Ž","\231");
$vysledok = StrTr($vysledok, "ž","\236");
$vysledok = StrTr($vysledok, "§","\247");
$vysledok = StrTr($vysledok, "µ","\265");
$vysledok = StrTr($vysledok, "x","\327");
$vysledok = StrTr($vysledok, "-","\205");
$vysledok = StrTr($vysledok, "—","\204");
$vysledok = StrTr($vysledok, "‘","\217");
$vysledok = StrTr($vysledok, "’","\220");
$vysledok = StrTr($vysledok, ",","\221");
$vysledok = StrTr($vysledok, "“","\215");
$vysledok = StrTr($vysledok, "”","\216");
$vysledok = StrTr($vysledok, "„","\214");
$vysledok = StrTr($vysledok, "'","\264");
$vysledok = StrTr($vysledok, "°","\260");


return $vysledok;
         }

//prva strana

$nazsub="SUVAHA_".$kli_vrok."_F".$kli_vxcf."_".$kli_uzid.".fdf";

if (File_Exists ("../tmp/$nazsub")) { $soubor = unlink("../tmp/$nazsub"); }

$soubor = fopen("../tmp/$nazsub", "a+");

//NACITANIE CISLA PLATITELA,NAZVU Z CISELNIKA ZP
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE zdrv=$cislo_zdrv ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $platitel=$riaddok->vsy;
  $nazzdrv=$riaddok->nzdr;
  }

$sqlt = <<<prcvykziss
(
%FDF-1.2
%âãÏÓ
1 0 obj
<< /FDF
  << /Fields [
	<< /V ()/T (den)>>
	<< /V ()/T (mesiac)>>
	<< /V ()/T (rok)>>

	<< /V ()/T (dic)>>
	<< /V ()/T (ico)>> 

	<< /V ()/T (sknace1)>>
	<< /V ()/T (sknace2)>>
	<< /V ()/T (sknace3)>>
	
	<< /V ()/T (uzr)>>
	<< /V ()/T (uzm)>> 
	<< /V ()/T (uzz)>> 
	<< /V ()/T (uzs)>>
	
	<< /V ()/T (od_mes)>>
	<< /V ()/T (od_rok)>>
	<< /V ()/T (do_mes)>> 
	<< /V ()/T (do_rok)>>
	
	<< /V ()/T (bpo_od_mes)>>
	<< /V ()/T (bpo_od_rok)>> 
	<< /V ()/T (bpo_do_mes)>> 
	<< /V ()/T (bpo_do_rok)>>

	<< /V ()/T (ucto1)>> 
	<< /V ()/T (ucto2)>>

	<< /V ()/T (s_ulica)>>
	<< /V ()/T (s_cislo)>>
	<< /V ()/T (s_psc)>> 
	<< /V ()/T (s_obec)>>
	<< /V ()/T (s_tel_pre)>> 
	<< /V ()/T (s_tel)>>
	<< /V ()/T (s_fax_pre)>>
	<< /V ()/T (s_fax)>>
	<< /V ()/T (email)>> 

	<< /V ()/T (z_den)>>
	<< /V ()/T (z_mesiac)>>
	<< /V ()/T (z_rok)>> 
	<< /V ()/T (s_den)>> 
	<< /V ()/T (s_mesiac)>> 
	<< /V ()/T (s_rok)>>

	<< /V ()/T (001_1_1)>>
	<< /V ()/T (001_1_2)>>
	<< /V ()/T (001_2)>> 
	<< /V ()/T (001_3)>>
...
	<< /V ()/T (065_1_1)>>
	<< /V ()/T (065_1_2)>>
	<< /V ()/T (065_2)>>
	<< /V ()/T (065_3)>>

	<< /V ()/T (066_4)>>
	<< /V ()/T (066_5)>> 

...

	<< /V ()/T (101_4)>> 
	<< /V ()/T (101_5)>>
...
	<< /V ()/T (123_4)>>
	<< /V ()/T (123_5)>>

	<< /V (Tla\226ivo vytla\226en\351 z internetu)/T (print)>>

    ] 
     /F (UVPOD1-09-print.pdf)
     /ID [ <44b17025f3b6a2e62cc72e523924e65d><6b0740370c3e7fa74a0941f180bc468b>]
  >> 
>> 
endobj
trailer
<< /Root 1 0 R >>
%%EOF

);
prcvykziss;


//hlavicka
$sqltt = "SELECT * FROM F$kli_vxcf"."_prcsuv1000ahas".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpocsuvaha_stt".
" ON F$kli_vxcf"."_prcsuv1000ahas$kli_uzid.prx=F$kli_vxcf"."_uctpocsuvaha_stt.fic".
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

$obdobie=$kli_vmes;

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 

if( $i == 0 )
     {
  $text = "%FDF-1.2"."\r\n";
  fwrite($soubor, $text);
  $text = "%âãÏÓ"."\r\n";
  fwrite($soubor, $text);
  $text = "1 0 obj"."\r\n";
  fwrite($soubor, $text);


  $text = "<< /FDF"."\r\n";
  fwrite($soubor, $text);
  $text = "  << /Fields"."\r\n";
  fwrite($soubor, $text);
  $text = "    ["."\r\n";
  fwrite($soubor, $text);

//udaje

//echo $denk_sk;
$pole = explode(".", $datk_sk);
$den=$pole[0];
$mesiac=$pole[1];
$rok=1*$pole[2]-2000;
if( $rok < 10 ) $rok="09";

  $text = "	<< /V (".$den.")/T (den)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$mesiac.")/T (mesiac)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rok.")/T (rok)>>"."\r\n";
  fwrite($soubor, $text);


  $text = "	<< /V (".$fir_fdic.")/T (dic)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$fir_fico.")/T (ico)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$sknacea.")/T (sknace1)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$sknaceb.")/T (sknace2)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$sknacec.")/T (sknace3)>>"."\r\n";
  fwrite($soubor, $text);


$h_drp=1;
$riadne="";
if( $h_drp == 1 ) $riadne="x";
  $text = "	<< /V (".$riadne.")/T (uzr)>>"."\r\n";
  fwrite($soubor, $text);
$mimor="";
if( $h_drp == 2 ) $oprav="x";
  $text = "	<< /V (".$mimor.")/T (uzm)>>"."\r\n";
  fwrite($soubor, $text);

$h_zosta=1;
$zosta="";
if( $h_zosta == 1 ) $zosta="x";
  $text = "	<< /V (".$zosta.")/T (uzz)>>"."\r\n";
  fwrite($soubor, $text);

$h_schva=0;
$schva="";
if( $h_schva == 1 ) $schva="x";
  $text = "	<< /V (".$schva.")/T (uzs)>>"."\r\n";
  fwrite($soubor, $text);

//nacitaj obdobie z priznanie_po
$sqlrr = mysql_query("SELECT * FROM F$kli_vxcf"."_uctpriznanie_po");
  if (@$zaznam=mysql_data_seek($sqlrr,0))
  {
  $riadok=mysql_fetch_object($sqlrr);
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
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) { 
$mesp_sk=$obdm1; $rokp_sk=$obdr1; $mesk_sk=$obdm2; $rokk_sk=$obdr2; 
$mesp08_sk=$obmm1; $rokp08_sk=$obmr1; $mesk08_sk=$obmm2; $rokk08_sk=$obmr2; 
                                                  }

  $text = "	<< /V (".$mesp_sk.")/T (od_mes)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rokp_sk.")/T (od_rok)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$mesk_sk.")/T (do_mes)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rokk_sk.")/T (do_rok)>>"."\r\n";
  fwrite($soubor, $text);


  $text = "	<< /V (".$mesp08_sk.")/T (bpo_od_mes)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rokp08_sk.")/T (bpo_od_rok)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$mesk08_sk.")/T (bpo_do_mes)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rokk08_sk.")/T (bpo_do_rok)>>"."\r\n";
  fwrite($soubor, $text);

$obch_meno=prevodkodov( $fir_fnaz );

  $text = "	<< /V (".$obch_meno.")/T (ucto1)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V ()/T (ucto2)>>"."\r\n";
  fwrite($soubor, $text);


$ulica=prevodkodov( $fir_fuli );

  $text = "	<< /V (".$ulica.")/T (s_ulica)>>"."\r\n";
  fwrite($soubor, $text);

$cislo=prevodkodov( $fir_fcdm );

  $text = "	<< /V (".$cislo.")/T (s_cislo)>>"."\r\n";
  fwrite($soubor, $text);

$psc=str_replace(" ","",$fir_fpsc);

  $text = "	<< /V (".$psc.")/T (s_psc)>>"."\r\n";
  fwrite($soubor, $text);

$obec=prevodkodov( $fir_fmes );

  $text = "	<< /V (".$obec.")/T (s_obec)>>"."\r\n";
  fwrite($soubor, $text);

$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
$tel_za=1*$pole[1];

  $text = "	<< /V (".$tel_pred.")/T (s_tel_pre)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$tel_za.")/T (s_tel)>>"."\r\n";
  fwrite($soubor, $text);

$pole = explode("/", $fir_ffax);
$fax_pred=1*$pole[0];
$fax_za=1*$pole[1];

  $text = "	<< /V (".$fax_pred.")/T (s_fax_pre)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$fax_za.")/T (s_fax)>>"."\r\n";
  fwrite($soubor, $text);

$email=prevodkodov( $fir_fem1 );

  $text = "	<< /V (".$email.")/T (email)>>"."\r\n";
  fwrite($soubor, $text);


$pole = explode(".", $h_zos);
$den=$pole[0];
$mesiac=$pole[1];
$rok=10;

  $text = "	<< /V (".$den.")/T (z_den)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$mesiac.")/T (z_mesiac)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rok.")/T (z_rok)>>"."\r\n";
  fwrite($soubor, $text);

$pole = explode(".", $h_sch);
$den=$pole[0];
$mesiac=$pole[1];
$rok=10;

  $text = "	<< /V (".$den.")/T (s_den)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$mesiac.")/T (s_mesiac)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$rok.")/T (s_rok)>>"."\r\n";
  fwrite($soubor, $text);

//sumy v riadkoch
$riadok=1;
  while ($riadok <= 123 )
  {

$oznriad=$riadok;
if( $riadok < 10 ) $oznriad="00".$riadok;
if( $riadok >= 10 AND $riadok < 100 ) $oznriad="0".$riadok;


if( $riadok == 1 ) { $hodnota1=$r01; $hodnota2=$rk01; $hodnota3=$rn01; $hodnota4=$rm01; }
if( $riadok == 2 ) { $hodnota1=$r02; $hodnota2=$rk02; $hodnota3=$rn02; $hodnota4=$rm02; }
if( $riadok == 3 ) { $hodnota1=$r03; $hodnota2=$rk03; $hodnota3=$rn03; $hodnota4=$rm03; }
if( $riadok == 4 ) { $hodnota1=$r04; $hodnota2=$rk04; $hodnota3=$rn04; $hodnota4=$rm04; }
if( $riadok == 5 ) { $hodnota1=$r05; $hodnota2=$rk05; $hodnota3=$rn05; $hodnota4=$rm05; }
if( $riadok == 6 ) { $hodnota1=$r06; $hodnota2=$rk06; $hodnota3=$rn06; $hodnota4=$rm06; }
if( $riadok == 7 ) { $hodnota1=$r07; $hodnota2=$rk07; $hodnota3=$rn07; $hodnota4=$rm07; }
if( $riadok == 8 ) { $hodnota1=$r08; $hodnota2=$rk08; $hodnota3=$rn08; $hodnota4=$rm08; }
if( $riadok == 9 ) { $hodnota1=$r09; $hodnota2=$rk09; $hodnota3=$rn09; $hodnota4=$rm09; }
if( $riadok == 10 ) { $hodnota1=$r10; $hodnota2=$rk10; $hodnota3=$rn10; $hodnota4=$rm10; }
if( $riadok == 11 ) { $hodnota1=$r11; $hodnota2=$rk11; $hodnota3=$rn11; $hodnota4=$rm11; }
if( $riadok == 12 ) { $hodnota1=$r12; $hodnota2=$rk12; $hodnota3=$rn12; $hodnota4=$rm12; }
if( $riadok == 13 ) { $hodnota1=$r13; $hodnota2=$rk13; $hodnota3=$rn13; $hodnota4=$rm13; }
if( $riadok == 14 ) { $hodnota1=$r14; $hodnota2=$rk14; $hodnota3=$rn14; $hodnota4=$rm14; }
if( $riadok == 15 ) { $hodnota1=$r15; $hodnota2=$rk15; $hodnota3=$rn15; $hodnota4=$rm15; }
if( $riadok == 16 ) { $hodnota1=$r16; $hodnota2=$rk16; $hodnota3=$rn16; $hodnota4=$rm16; }
if( $riadok == 17 ) { $hodnota1=$r17; $hodnota2=$rk17; $hodnota3=$rn17; $hodnota4=$rm17; }
if( $riadok == 18 ) { $hodnota1=$r18; $hodnota2=$rk18; $hodnota3=$rn18; $hodnota4=$rm18; }
if( $riadok == 19 ) { $hodnota1=$r19; $hodnota2=$rk19; $hodnota3=$rn19; $hodnota4=$rm19; }
if( $riadok == 20 ) { $hodnota1=$r20; $hodnota2=$rk20; $hodnota3=$rn20; $hodnota4=$rm20; }
if( $riadok == 21 ) { $hodnota1=$r21; $hodnota2=$rk21; $hodnota3=$rn21; $hodnota4=$rm21; }
if( $riadok == 22 ) { $hodnota1=$r22; $hodnota2=$rk22; $hodnota3=$rn22; $hodnota4=$rm22; }
if( $riadok == 23 ) { $hodnota1=$r23; $hodnota2=$rk23; $hodnota3=$rn23; $hodnota4=$rm23; }
if( $riadok == 24 ) { $hodnota1=$r24; $hodnota2=$rk24; $hodnota3=$rn24; $hodnota4=$rm24; }
if( $riadok == 25 ) { $hodnota1=$r25; $hodnota2=$rk25; $hodnota3=$rn25; $hodnota4=$rm25; }
if( $riadok == 26 ) { $hodnota1=$r26; $hodnota2=$rk26; $hodnota3=$rn26; $hodnota4=$rm26; }
if( $riadok == 27 ) { $hodnota1=$r27; $hodnota2=$rk27; $hodnota3=$rn27; $hodnota4=$rm27; }
if( $riadok == 28 ) { $hodnota1=$r28; $hodnota2=$rk28; $hodnota3=$rn28; $hodnota4=$rm28; }
if( $riadok == 29 ) { $hodnota1=$r29; $hodnota2=$rk29; $hodnota3=$rn29; $hodnota4=$rm29; }
if( $riadok == 30 ) { $hodnota1=$r30; $hodnota2=$rk30; $hodnota3=$rn30; $hodnota4=$rm30; }
if( $riadok == 31 ) { $hodnota1=$r31; $hodnota2=$rk31; $hodnota3=$rn31; $hodnota4=$rm31; }
if( $riadok == 32 ) { $hodnota1=$r32; $hodnota2=$rk32; $hodnota3=$rn32; $hodnota4=$rm32; }
if( $riadok == 33 ) { $hodnota1=$r33; $hodnota2=$rk33; $hodnota3=$rn33; $hodnota4=$rm33; }
if( $riadok == 34 ) { $hodnota1=$r34; $hodnota2=$rk34; $hodnota3=$rn34; $hodnota4=$rm34; }
if( $riadok == 35 ) { $hodnota1=$r35; $hodnota2=$rk35; $hodnota3=$rn35; $hodnota4=$rm35; }
if( $riadok == 36 ) { $hodnota1=$r36; $hodnota2=$rk36; $hodnota3=$rn36; $hodnota4=$rm36; }
if( $riadok == 37 ) { $hodnota1=$r37; $hodnota2=$rk37; $hodnota3=$rn37; $hodnota4=$rm37; }
if( $riadok == 38 ) { $hodnota1=$r38; $hodnota2=$rk38; $hodnota3=$rn38; $hodnota4=$rm38; }
if( $riadok == 39 ) { $hodnota1=$r39; $hodnota2=$rk39; $hodnota3=$rn39; $hodnota4=$rm39; }
if( $riadok == 40 ) { $hodnota1=$r40; $hodnota2=$rk40; $hodnota3=$rn40; $hodnota4=$rm40; }
if( $riadok == 41 ) { $hodnota1=$r41; $hodnota2=$rk41; $hodnota3=$rn41; $hodnota4=$rm41; }
if( $riadok == 42 ) { $hodnota1=$r42; $hodnota2=$rk42; $hodnota3=$rn42; $hodnota4=$rm42; }
if( $riadok == 43 ) { $hodnota1=$r43; $hodnota2=$rk43; $hodnota3=$rn43; $hodnota4=$rm43; }
if( $riadok == 44 ) { $hodnota1=$r44; $hodnota2=$rk44; $hodnota3=$rn44; $hodnota4=$rm44; }
if( $riadok == 45 ) { $hodnota1=$r45; $hodnota2=$rk45; $hodnota3=$rn45; $hodnota4=$rm45; }
if( $riadok == 46 ) { $hodnota1=$r46; $hodnota2=$rk46; $hodnota3=$rn46; $hodnota4=$rm46; }
if( $riadok == 47 ) { $hodnota1=$r47; $hodnota2=$rk47; $hodnota3=$rn47; $hodnota4=$rm47; }
if( $riadok == 48 ) { $hodnota1=$r48; $hodnota2=$rk48; $hodnota3=$rn48; $hodnota4=$rm48; }
if( $riadok == 49 ) { $hodnota1=$r49; $hodnota2=$rk49; $hodnota3=$rn49; $hodnota4=$rm49; }
if( $riadok == 50 ) { $hodnota1=$r50; $hodnota2=$rk50; $hodnota3=$rn50; $hodnota4=$rm50; }
if( $riadok == 51 ) { $hodnota1=$r51; $hodnota2=$rk51; $hodnota3=$rn51; $hodnota4=$rm51; }
if( $riadok == 52 ) { $hodnota1=$r52; $hodnota2=$rk52; $hodnota3=$rn52; $hodnota4=$rm52; }
if( $riadok == 53 ) { $hodnota1=$r53; $hodnota2=$rk53; $hodnota3=$rn53; $hodnota4=$rm53; }
if( $riadok == 54 ) { $hodnota1=$r54; $hodnota2=$rk54; $hodnota3=$rn54; $hodnota4=$rm54; }
if( $riadok == 55 ) { $hodnota1=$r55; $hodnota2=$rk55; $hodnota3=$rn55; $hodnota4=$rm55; }
if( $riadok == 56 ) { $hodnota1=$r56; $hodnota2=$rk56; $hodnota3=$rn56; $hodnota4=$rm56; }
if( $riadok == 57 ) { $hodnota1=$r57; $hodnota2=$rk57; $hodnota3=$rn57; $hodnota4=$rm57; }
if( $riadok == 58 ) { $hodnota1=$r58; $hodnota2=$rk58; $hodnota3=$rn58; $hodnota4=$rm58; }
if( $riadok == 59 ) { $hodnota1=$r59; $hodnota2=$rk59; $hodnota3=$rn59; $hodnota4=$rm59; }
if( $riadok == 60 ) { $hodnota1=$r60; $hodnota2=$rk60; $hodnota3=$rn60; $hodnota4=$rm60; }
if( $riadok == 61 ) { $hodnota1=$r61; $hodnota2=$rk61; $hodnota3=$rn61; $hodnota4=$rm61; }
if( $riadok == 62 ) { $hodnota1=$r62; $hodnota2=$rk62; $hodnota3=$rn62; $hodnota4=$rm62; }
if( $riadok == 63 ) { $hodnota1=$r63; $hodnota2=$rk63; $hodnota3=$rn63; $hodnota4=$rm63; }
if( $riadok == 64 ) { $hodnota1=$r64; $hodnota2=$rk64; $hodnota3=$rn64; $hodnota4=$rm64; }
if( $riadok == 65 ) { $hodnota1=$r65; $hodnota2=$rk65; $hodnota3=$rn65; $hodnota4=$rm65; }


if( $riadok < 66 ) {

  $text = "	<< /V (".$hodnota1.")/T (".$oznriad."_1_1)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$hodnota2.")/T (".$oznriad."_1_2)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$hodnota3.")/T (".$oznriad."_2)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$hodnota4.")/T (".$oznriad."_3)>>"."\r\n";
  fwrite($soubor, $text);

                   }

if( $riadok == 66 ) { $hodnota1=$r66; $hodnota4=$rm66; }
if( $riadok == 67 ) { $hodnota1=$r67; $hodnota4=$rm67; }
if( $riadok == 68 ) { $hodnota1=$r68; $hodnota4=$rm68; }
if( $riadok == 69 ) { $hodnota1=$r69; $hodnota4=$rm69; }
if( $riadok == 70 ) { $hodnota1=$r70; $hodnota4=$rm70; }
if( $riadok == 71 ) { $hodnota1=$r71; $hodnota4=$rm71; }
if( $riadok == 72 ) { $hodnota1=$r72; $hodnota4=$rm72; }
if( $riadok == 73 ) { $hodnota1=$r73; $hodnota4=$rm73; }
if( $riadok == 74 ) { $hodnota1=$r74; $hodnota4=$rm74; }
if( $riadok == 75 ) { $hodnota1=$r75; $hodnota4=$rm75; }
if( $riadok == 76 ) { $hodnota1=$r76; $hodnota4=$rm76; }
if( $riadok == 77 ) { $hodnota1=$r77; $hodnota4=$rm77; }
if( $riadok == 78 ) { $hodnota1=$r78; $hodnota4=$rm78; }
if( $riadok == 79 ) { $hodnota1=$r79; $hodnota4=$rm79; }
if( $riadok == 80 ) { $hodnota1=$r80; $hodnota4=$rm80; }
if( $riadok == 81 ) { $hodnota1=$r81; $hodnota4=$rm81; }
if( $riadok == 82 ) { $hodnota1=$r82; $hodnota4=$rm82; }
if( $riadok == 83 ) { $hodnota1=$r83; $hodnota4=$rm83; }
if( $riadok == 84 ) { $hodnota1=$r84; $hodnota4=$rm84; }
if( $riadok == 85 ) { $hodnota1=$r85; $hodnota4=$rm85; }
if( $riadok == 86 ) { $hodnota1=$r86; $hodnota4=$rm86; }
if( $riadok == 87 ) { $hodnota1=$r87; $hodnota4=$rm87; }
if( $riadok == 88 ) { $hodnota1=$r88; $hodnota4=$rm88; }
if( $riadok == 89 ) { $hodnota1=$r89; $hodnota4=$rm89; }
if( $riadok == 90 ) { $hodnota1=$r90; $hodnota4=$rm90; }
if( $riadok == 91 ) { $hodnota1=$r91; $hodnota4=$rm91; }
if( $riadok == 92 ) { $hodnota1=$r92; $hodnota4=$rm92; }
if( $riadok == 93 ) { $hodnota1=$r93; $hodnota4=$rm93; }
if( $riadok == 94 ) { $hodnota1=$r94; $hodnota4=$rm94; }
if( $riadok == 95 ) { $hodnota1=$r95; $hodnota4=$rm95; }
if( $riadok == 96 ) { $hodnota1=$r96; $hodnota4=$rm96; }
if( $riadok == 97 ) { $hodnota1=$r97; $hodnota4=$rm97; }
if( $riadok == 98 ) { $hodnota1=$r98; $hodnota4=$rm98; }
if( $riadok == 99 ) { $hodnota1=$r99; $hodnota4=$rm99; }
if( $riadok == 100 ) { $hodnota1=$r100; $hodnota4=$rm100; }
if( $riadok == 101 ) { $hodnota1=$r101; $hodnota4=$rm101; }
if( $riadok == 102 ) { $hodnota1=$r102; $hodnota4=$rm102; }
if( $riadok == 103 ) { $hodnota1=$r103; $hodnota4=$rm103; }
if( $riadok == 104 ) { $hodnota1=$r104; $hodnota4=$rm104; }
if( $riadok == 105 ) { $hodnota1=$r105; $hodnota4=$rm105; }
if( $riadok == 106 ) { $hodnota1=$r106; $hodnota4=$rm106; }
if( $riadok == 107 ) { $hodnota1=$r107; $hodnota4=$rm107; }
if( $riadok == 108 ) { $hodnota1=$r108; $hodnota4=$rm108; }
if( $riadok == 109 ) { $hodnota1=$r109; $hodnota4=$rm109; }
if( $riadok == 110 ) { $hodnota1=$r110; $hodnota4=$rm110; }
if( $riadok == 111 ) { $hodnota1=$r111; $hodnota4=$rm111; }
if( $riadok == 112 ) { $hodnota1=$r112; $hodnota4=$rm112; }
if( $riadok == 113 ) { $hodnota1=$r113; $hodnota4=$rm113; }
if( $riadok == 114 ) { $hodnota1=$r114; $hodnota4=$rm114; }
if( $riadok == 115 ) { $hodnota1=$r115; $hodnota4=$rm115; }
if( $riadok == 116 ) { $hodnota1=$r116; $hodnota4=$rm116; }
if( $riadok == 117 ) { $hodnota1=$r117; $hodnota4=$rm117; }
if( $riadok == 118 ) { $hodnota1=$r118; $hodnota4=$rm118; }
if( $riadok == 119 ) { $hodnota1=$r119; $hodnota4=$rm119; }
if( $riadok == 120 ) { $hodnota1=$r120; $hodnota4=$rm120; }
if( $riadok == 121 ) { $hodnota1=$r121; $hodnota4=$rm121; }
if( $riadok == 122 ) { $hodnota1=$r122; $hodnota4=$rm122; }
if( $riadok == 123 ) { $hodnota1=$r123; $hodnota4=$rm123; }



if( $riadok >= 66 ) {


  $text = "	<< /V (".$hodnota1.")/T (".$oznriad."_4)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (".$hodnota4.")/T (".$oznriad."_5)>>"."\r\n";
  fwrite($soubor, $text);

                   }

$riadok=$riadok+1;
  }
//koniec sumy v riadkoch

//koniec udaje
  $text = " "."\r\n";
  fwrite($soubor, $text);
  $text = "	<< /V (Tla\226ivo vytla\226en\351 z internetu)/T (print)>>"."\r\n";
  fwrite($soubor, $text);
  $text = "     ] "."\r\n";
  fwrite($soubor, $text);
  $text = "    /F (UVPOD1-09-print.pdf)"."\r\n";
  fwrite($soubor, $text);
  $text = "    /ID [ <44b17025f3b6a2e62cc72e523924e65d><6b0740370c3e7fa74a0941f180bc468b>]"."\r\n";
  fwrite($soubor, $text);
  $text = "  >>"."\r\n";
  fwrite($soubor, $text);
  $text = ">> "."\r\n";
  fwrite($soubor, $text);
  $text = "endobj"."\r\n";
  fwrite($soubor, $text);
  $text = "trailer"."\r\n";
  fwrite($soubor, $text);
  $text = "<</Root 1 0 R >>"."\r\n";
  fwrite($soubor, $text);
  $text = "%%EOF"."\r\n";
  fwrite($soubor, $text);


    }
}
$i = $i + 1;
$j = $j + 1;
  }

fclose($soubor);
//koniec prva strana



?>

<?php
if( $xml == 1 )
{
?>
<br />
<br />
Stiahnite si nižšie uvedené súbory na Váš lokálny disk a vytlaète FDF výkaz :
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>">../tmp/<?php echo $nazsub; ?></a>
<br />
<br />
<a href="../dokumenty/dan_z_prijmov/priznaniepo/UVPOD1-09-print.pdf">../dokumenty/dan_z_prijmov/priznaniepo/UVPOD1-09-print.pdf</a>

<br />
<br />
<?php
}
?>

<?php                 } ?>
<?php
//koniec el.komunikacie

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
