<!doctype html>
<HTML>
<?php
do
{
$sys = 'UCT';
$urov = 2000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

$cslm=100440;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_ume = $_REQUEST['cislo_ume'];
$cislo_druh = $_REQUEST['cislo_druh'];
$cislo_stvrt = 1*$_REQUEST['cislo_stvrt'];
$cislo_cpid = 1*$_REQUEST['cislo_cpid'];

$subor = $_REQUEST['subor'];
$prepoc = 1*$_REQUEST['prepoc'];
$odpoc = 1*$_REQUEST['odpoc'];

$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) { $strana=2; }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";



//odpocet riadne od dodatocneho
if ( $copern == 230 )
    {
$sqlt = "DROP TABLE F$kli_vxcf"."_archivdph".$kli_uzid;
$vysledok = mysql_query("$sqlt");


$vsql = "CREATE TABLE F$kli_vxcf"."_archivdph".$kli_uzid." SELECT * FROM F$kli_vxcf"."_archivdph ".
" WHERE ume = $cislo_ume AND druh = 1 AND stvrtrok = $cislo_stvrt ";
$vytvor = mysql_query("$vsql");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph,F$kli_vxcf"."_archivdph".$kli_uzid." ".
" SET F$kli_vxcf"."_archivdph.r37=F$kli_vxcf"."_archivdph.r31-F$kli_vxcf"."_archivdph".$kli_uzid.".r31-".
"F$kli_vxcf"."_archivdph.r32+F$kli_vxcf"."_archivdph.r32, ".
" F$kli_vxcf"."_archivdph.r38=F$kli_vxcf"."_archivdph.r34-F$kli_vxcf"."_archivdph".$kli_uzid.".r34 ".
" WHERE F$kli_vxcf"."_archivdph.ume = $cislo_ume AND F$kli_vxcf"."_archivdph.druh = 3 AND F$kli_vxcf"."_archivdph.stvrtrok = $cislo_stvrt ".
" AND F$kli_vxcf"."_archivdph.ume=F$kli_vxcf"."_archivdph".$kli_uzid.".ume ".
" AND F$kli_vxcf"."_archivdph.stvrtrok=F$kli_vxcf"."_archivdph".$kli_uzid.".stvrtrok ".
" AND F$kli_vxcf"."_archivdph".$kli_uzid.".druh = 1 AND F$kli_vxcf"."_archivdph.cpid = $cislo_cpid ".
"";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqlt = "DROP TABLE F$kli_vxcf"."_archivdph".$kli_uzid;
$vysledok = mysql_query("$sqlt");
//exit;


$copern=20;
$odpoc=1;
    }
//koniec odpocet riadne od dodatocneho


//prepocet pomernej DPH
if ( $copern == 220 )
    {
$koefmin = 1*$_REQUEST['koefmin'];
$druhykoef = strip_tags($_REQUEST['druhykoef']);

$uprtxt = "UPDATE F$kli_vxcf"."_archivdphkoef SET koefmin='$koefmin', druhykoef='$druhykoef' WHERE fic >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET koefmin='$koefmin', druhykoef='$druhykoef' WHERE ume >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET r19orig=r21 WHERE r19orig = 0 AND cpid = $cislo_cpid "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET r18orig=r20 WHERE r18orig = 0 AND cpid = $cislo_cpid "; 
$upravene = mysql_query("$uprtxt");

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

$pole = explode(".", $cislo_ume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

if( $cislo_stvrt > 0 ) {
$kli_mdph="";
if( $cislo_stvrt == 1 ) { $mesp_dph=1; $mesk_dph=3; $obddph="1"; }
if( $cislo_stvrt == 2 ) { $mesp_dph=4; $mesk_dph=6; $obddph="2"; }
if( $cislo_stvrt == 3 ) { $mesp_dph=7; $mesk_dph=9; $obddph="3"; }
if( $cislo_stvrt == 4 ) { $mesp_dph=10; $mesk_dph=12; $obddph="4"; }
if( $cislo_stvrt == 5 ) { $mesp_dph=1; $mesk_dph=12; $obddph="5"; }
                       }

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

//echo $datp_dph."  ".$datk_dph;


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   dok          INT,
   hod          DECIMAL(10,2),
   prx          INT
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podmrdp="AND ( LEFT(ucm,3) = 343 ";

$pole = explode(",", $druhykoef);

$cislo=1*$pole[0];
if( $cislo > 0 ) $podmrdp=$podmrdp." ) AND ( rdp = $pole[0] ";
$cislo=1*$pole[1];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[1] ";
$cislo=1*$pole[2];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[2] ";
$cislo=1*$pole[3];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[3] ";
$cislo=1*$pole[4];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[4] ";
$cislo=1*$pole[5];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[5] ";
$cislo=1*$pole[6];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[6] ";
$cislo=1*$pole[7];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[7] ";

$podmrdp=$podmrdp." ) ";


//echo $podmrdp;

//exit;


$psys=12;
while ($psys <= 16 ) 
  {
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }

if( $psys <= 16 )
{
if( $psys < 15 )
   {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,0 ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".$podmrdp." ".
" AND ( F$kli_vxcf"."_$doklad.dat >= '$datp_dph' AND F$kli_vxcf"."_$doklad.dat <= '$datk_dph' ) ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
   }
if( $psys > 15 )
   {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,0 ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".$podmrdp." ".
" AND F$kli_vxcf"."_$doklad.daz >= '$datp_dph' AND F$kli_vxcf"."_$doklad.daz <= '$datk_dph' ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
   }



}
else
{
//tu budu podsystemy

}
$psys=$psys+1;
  }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,SUM(hod),1 FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE prx = 0 GROUP BY prx ";
$dsql = mysql_query("$dsqlt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE prx = 0 "; 
$zmazane = mysql_query("$zmazttt"); 

$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ORDER by dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $odpocall=$riadmax->hod;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET odpocall=$odpocall, odpocupr=koefmin*odpocall, odpocroz=odpocall-odpocupr, r21=r19orig-odpocroz ".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vynuluj pred tym vypocitane
$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r31=0, r32=0, r33=0, r34=0  ".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

//prepocty
$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r19=r02+r04+r06+r08+r10+r12+r14+r18, r31=r19-r21-r20-r29-r30+r27+r28-r29-r30 ".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r34=r31-r32-r33 ".
" WHERE r31 >= 0 AND  ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r32=-r31, r33=0, r34=0 ".
" WHERE r31 < 0 AND  ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r31=0 ".
" WHERE r31 < 0 AND  ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");


$copern=20;
$prepoc=1;
    }
//koniec prepocet



//zapis upravene udaje
if ( $copern == 23 )
    {

$par79ods2 = $_REQUEST['par79ods2'];
//echo $par79ods2;
$r01 = strip_tags($_REQUEST['r01']);
$r02 = strip_tags($_REQUEST['r02']);
$r03 = strip_tags($_REQUEST['r03']);
$r04 = strip_tags($_REQUEST['r04']);
$r05 = strip_tags($_REQUEST['r05']);
$r06 = strip_tags($_REQUEST['r06']);
$r07 = strip_tags($_REQUEST['r07']);
$r08 = strip_tags($_REQUEST['r08']);
$r09 = strip_tags($_REQUEST['r09']);
$r10 = strip_tags($_REQUEST['r10']);
$r11 = strip_tags($_REQUEST['r11']);
$r12 = strip_tags($_REQUEST['r12']);
$r13 = strip_tags($_REQUEST['r13']);
$r14 = strip_tags($_REQUEST['r14']);
$r15 = strip_tags($_REQUEST['r15']);
$r16 = strip_tags($_REQUEST['r16']);
$r17 = strip_tags($_REQUEST['r17']);
$r18 = strip_tags($_REQUEST['r18']);
$r19 = strip_tags($_REQUEST['r19']);
$r20 = strip_tags($_REQUEST['r20']);
$r21 = strip_tags($_REQUEST['r21']);
$r22 = strip_tags($_REQUEST['r22']);
$r23 = strip_tags($_REQUEST['r23']);
$r24 = strip_tags($_REQUEST['r24']);
$r25 = strip_tags($_REQUEST['r25']);
$r26 = strip_tags($_REQUEST['r26']);
$r27 = strip_tags($_REQUEST['r27']);
$r28 = strip_tags($_REQUEST['r28']);
$r29 = strip_tags($_REQUEST['r29']);
$r30 = strip_tags($_REQUEST['r30']);
$r31 = strip_tags($_REQUEST['r31']);
$r32 = strip_tags($_REQUEST['r32']);
$r33 = strip_tags($_REQUEST['r33']);
$r34 = strip_tags($_REQUEST['r34']);
$r35 = strip_tags($_REQUEST['r35']);
$r36 = strip_tags($_REQUEST['r36']);
$r37 = strip_tags($_REQUEST['r37']);
$r38 = strip_tags($_REQUEST['r38']);
$dad = $_REQUEST['dad'];
$dad_sql=Sqldatum($dad);
$cpop = 1*$_REQUEST['cpop'];

$uprav="NO";

if( $strana == 2 ) {

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET cpop='$cpop',".
" r01='$r01', r02='$r02', r03='$r03', r04='$r04', r05='$r05', r06='$r06', r07='$r07', r08='$r08', r09='$r09',".
" r10='$r10', r11='$r11', r12='$r12', r13='$r13', r14='$r14', r15='$r15', r16='$r16', r17='$r17', r18='$r18', r18='$r18',".
" r20='$r20', r21='$r21', r22='$r22', r23='$r23', r24='$r24', r25='$r25', r26='$r26', r27='$r27', r28='$r28', r29='$r29',".
" r30='$r30', r32='$r32', r31='$r31', r33='$r33', r34='$r34', r35='$r35', r36='$r36', r37='$r37', r38='$r38', ".
" par79ods2='$par79ods2' ".
" WHERE cpid = $cislo_cpid  "; 

                   }
if( $strana == 1 ) {

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET ".
" dad='$dad_sql' ".
" WHERE cpid = $cislo_cpid  "; 

                   }

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

//prepocty

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r19=r02+r04+r06+r08+r10+r12+r14+r18, r31=r19-r21-r20-r29-r30+r27+r28-r29-r30 ".
" WHERE cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r34=r31-r32-r33 ".
" WHERE r31 >= 0 AND cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r32=-r31, r33=0, r34=0 ".
" WHERE r31 < 0 AND cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r31=0 ".
" WHERE r31 < 0 AND cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

//exit;
?>
<script type="text/javascript">
 window.open('../ucto/archivdph2014.php?copern=80&drupoh=1&page=1', '_self' );
</script>
<?php
$copern=20;
exit;
    }
//koniec zapisu upravenych udajov



//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_archivdph".
" WHERE cpid = $cislo_cpid ORDER BY ume,druh";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$par79ods2 = $fir_riadok->par79ods2;
$r01 = $fir_riadok->r01;
$r02 = $fir_riadok->r02;
$r03 = $fir_riadok->r03;
$r04 = $fir_riadok->r04;
$r05 = $fir_riadok->r05;
$r06 = $fir_riadok->r06;
$r07 = $fir_riadok->r07;
$r08 = $fir_riadok->r08;
$r09 = $fir_riadok->r09;
$r10 = $fir_riadok->r10;
$r11 = $fir_riadok->r11;
$r12 = $fir_riadok->r12;
$r13 = $fir_riadok->r13;
$r14 = $fir_riadok->r14;
$r15 = $fir_riadok->r15;
$r16 = $fir_riadok->r16;
$r17 = $fir_riadok->r17;
$r18 = $fir_riadok->r18;
$r19 = $fir_riadok->r19;
$r20 = $fir_riadok->r20;
$r21 = $fir_riadok->r21;
$r22 = $fir_riadok->r22;
$r23 = $fir_riadok->r23;
$r24 = $fir_riadok->r24;
$r25 = $fir_riadok->r25;
$r26 = $fir_riadok->r26;
$r27 = $fir_riadok->r27;
$r28 = $fir_riadok->r28;
$r29 = $fir_riadok->r29;
$r30 = $fir_riadok->r30;
$r31 = $fir_riadok->r31;
$r32 = $fir_riadok->r32;
$r33 = $fir_riadok->r33;
$r34 = $fir_riadok->r34;
$r35 = $fir_riadok->r35;
$r36 = $fir_riadok->r36;
$r37 = $fir_riadok->r37;
$r38 = $fir_riadok->r38;
$stvrtrok = $fir_riadok->stvrtrok;
$ume = $fir_riadok->ume;

$dad = $fir_riadok->dad;
$dad_sk=SkDatum($dad);
$cpop = 1*$fir_riadok->cpop;

$dap = $fir_riadok->dap;

$odpocall=1*$fir_riadok->odpocall;
$odpocupr=1*$fir_riadok->odpocupr;

mysql_free_result($fir_vysledok);

$sqlfirk = "SELECT * FROM F$kli_vxcf"."_archivdphkoef WHERE fic >= 0";

$fir_vysledokk = mysql_query($sqlfirk);
$fir_riadokk=mysql_fetch_object($fir_vysledokk);

$koefmin=1*$fir_riadokk->koefmin;
$druhykoef=$fir_riadokk->druhykoef;

mysql_free_result($fir_vysledokk);
    }
//koniec nacitania

//ulozenie parametrov koef a nastav
$sql = "SELECT fic FROM F$kli_vxcf"."_archivdphkoef ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_archivdphkoef SELECT * FROM F".$kli_vxcf."_archivdph WHERE fic >= 0";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_archivdphkoef WHERE fic >= 0";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_archivdphkoef ( fic ) VALUES ( '$fir_fico' )";
$ttqq = mysql_query("$ttvv");
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Priznanie DPH</title>
<style type="text/css">
div.bar-btn-form-tool {
  top: 28px;
}
div.bar-btn-form-tool > a {
  display: block;
  float: right;
  line-height: 16px;
  font-size: 14px;
  color: #39f;
  margin-left: 10px;
}
div.bar-btn-form-tool > a:hover {
  text-decoration: underline;
}
div.navbar {
  overflow: auto;
  width: 100%;
  background-color: #add8e6;
}
div.wrap-form-background {
  overflow: hidden;
  width: 950px;
  height: 1300px;
  background-color: #fff;
}
img.form-background {
  display: block;
  width: 900px;
  height: 1250px;
  margin: 30px 0 0 25px;
}
span.text-echo {
  font-size: 19px;
  letter-spacing: 12px;
}
span.text-echo-field {
  position: absolute;
  height: 28px;
  line-height: 28px;
  text-indent: 5px;
  background-color: #fff;
  letter-spacing: 1px;
  font-weight: bold;
  font-size: 18px;
  color: #000;
}
img.ekorobot {
  position: absolute;
  top: 570px;
  left: 440px;
  width: 90px;
  height: 130px;
  cursor: pointer;
}
div.wrap-ekorobot-menu {
  position: absolute;
  top: 395px;
  left: 460px;
  width: 390px;
  background-color: #ffff90;
  border: 2px outset #ececec;
}
table.ekorobot-menu {
  width: 100%;
}
table.ekorobot-menu th {
  text-align: left;
  height: 30px;
  line-height: 30px;
  font-size: 13px;
  text-indent: 5px;
}
table.ekorobot-menu td {
  height: 34px;
  text-indent: 5px;
  font-size: 13px;
  background-color: #fff;
  border-bottom: 2px solid #ffff90;
}
table.ekorobot-menu a {
  font-size: 12px;
  font-weight: bold;
  color: #2f93bb;
  cursor: pointer;
}
table.ekorobot-menu a:hover {
  text-decoration: underline;
}
table.ekorobot-menu p {
  line-height: 28px;
}
table.ekorobot-menu input[type=text] {
  display: block;
  height: 14px;
  margin-left: 10px;
  padding: 5px 0;
  text-indent: 4px;
  font-size:14px;
}
img.menu-close-btn {
  display: block;
  width: 15px;
  height: 15px;
  position: absolute;
  top: 6px;
  right: 8px;
  cursor: pointer;
}
div.kvdph-menu {
  position: absolute;
  top: 0px;
  right: 0;
  width: 490px;
  height: 24px;
  line-height: 24px;
  padding-left: 7px;
  font-size: 13px;
}
div.kvdph-menu > div {
  float: left;
  height: 20px;
}
span.alert-success {
  color: #046D4B;
  font-weight: normal;
}
</style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
<?php if ( $strana == 2 ) { ?>
   document.formv1.r01.value = '<?php echo "$r01";?>';
   document.formv1.r02.value = '<?php echo "$r02";?>';
   document.formv1.r03.value = '<?php echo "$r03";?>';
   document.formv1.r04.value = '<?php echo "$r04";?>';
   document.formv1.r05.value = '<?php echo "$r05";?>';
   document.formv1.r06.value = '<?php echo "$r06";?>';
   document.formv1.r07.value = '<?php echo "$r07";?>';
   document.formv1.r08.value = '<?php echo "$r08";?>';
   document.formv1.r09.value = '<?php echo "$r09";?>';
   document.formv1.r10.value = '<?php echo "$r10";?>';
   document.formv1.r11.value = '<?php echo "$r11";?>';
   document.formv1.r12.value = '<?php echo "$r12";?>';
   document.formv1.r13.value = '<?php echo "$r13";?>';
   document.formv1.r14.value = '<?php echo "$r14";?>';
   document.formv1.r15.value = '<?php echo "$r15";?>';
   document.formv1.r16.value = '<?php echo "$r16";?>';
   document.formv1.r17.value = '<?php echo "$r17";?>';
   document.formv1.r18.value = '<?php echo "$r18";?>';
//   document.formv1.r19.value = '<?php echo "$r19";?>';
   document.formv1.r20.value = '<?php echo "$r20";?>';
   document.formv1.r21.value = '<?php echo "$r21";?>';
   document.formv1.r22.value = '<?php echo "$r22";?>';
   document.formv1.r23.value = '<?php echo "$r23";?>';
   document.formv1.r24.value = '<?php echo "$r24";?>';
   document.formv1.r25.value = '<?php echo "$r25";?>';
   document.formv1.r26.value = '<?php echo "$r26";?>';
   document.formv1.r27.value = '<?php echo "$r27";?>';
   document.formv1.r28.value = '<?php echo "$r28";?>';
   document.formv1.r29.value = '<?php echo "$r29";?>';
   document.formv1.r30.value = '<?php echo "$r30";?>';
//   document.formv1.r31.value = '<?php echo "$r31";?>';
   document.formv1.r32.value = '<?php echo "$r32";?>';
   document.formv1.r33.value = '<?php echo "$r33";?>';
//   document.formv1.r34.value = '<?php echo "$r34";?>';
   document.formv1.r35.value = '<?php echo "$r35";?>';
   document.formv1.r36.value = '<?php echo "$r36";?>';
   document.formv1.r37.value = '<?php echo "$r37";?>';
   document.formv1.r38.value = '<?php echo "$r38";?>';
   document.formv1.cpop.value = '<?php echo "$cpop";?>';
<?php if ( $par79ods2 == 1 ) { ?> document.formv1.par79ods2.checked = "checked"; <?php } ?>

<?php                     } ?>
<?php if ( $strana == 1 ) { ?>
   document.formv1.dad.value = '<?php echo "$dad_sk";?>';
<?php                     } ?>
  }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern != 20 )
  {
?>
  function ObnovUI()
  {
  }
<?php
  }
?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1 ) { Vstup.value=Vstup.value.replace(",","."); }
  }

//ekorobot menu
  function zobraz_robotmenu()
  { 
   robotmenu.style.display='';
  }
  function zhasni_menurobot()
  { 
   robotmenu.style.display='none';
  }

  function Prepoc(cpid,ume,druh,stvrtrok)
  { 
   var cislo_cpid = cpid;
   var h_koefmin = document.forms.fkoef.h_koefmin.value;
   var h_druhykoef = document.forms.fkoef.h_druhykoef.value;
   var cislo_ume = ume;
   var cislo_druh = druh;
   var stvrtrok = stvrtrok;
window.open('../ucto/prizdph2014_uprav.php?copern=220&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&koefmin=' + h_koefmin + '&druhykoef=' + h_druhykoef + '&drupoh=1&uprav=1&prepoc=1', '_self' );
  }

  function Odpoc(cpid,ume,druh,stvrtrok)
  { 
   var cislo_cpid = cpid;
   var cislo_ume = ume;
   var cislo_druh = druh;
   var stvrtrok = stvrtrok;
window.open('../ucto/prizdph2014_uprav.php?copern=230&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&drupoh=1&uprav=1&odpoc=1', '_self');
  }

  function TlacZoznam(cpid,ume,druh,stvrtrok)
  {
   var cislo_cpid = cpid;
   var cislo_ume = ume;
   var cislo_druh = druh;
   var stvrtrok = stvrtrok;
window.open('../ucto/prizdph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function TlacZoznamRP(cpid,ume,druh,stvrtrok)
  {
   var cislo_cpid = cpid;
   var cislo_ume = ume;
   var cislo_druh = druh;
   var stvrtrok = stvrtrok;
window.open('../ucto/prizdph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }

  function TlacZoznamRM(cpid,ume,druh,stvrtrok)
  {
   var cislo_cpid = cpid;
   var cislo_ume = ume;
   var cislo_druh = druh;
   var stvrtrok = stvrtrok;
window.open('../ucto/prizdph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
  }
</script>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
     {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
  </tr>
  <tr>
<?php
if ( $cislo_druh == 1 ) { $druh_priz="Riadne"; }
if ( $cislo_druh == 2 ) { $druh_priz="OpravnÈ"; }
if ( $cislo_druh == 3 ) { $druh_priz="DodatoËnÈ"; }
?>
   <td class="header">
    <span class="subheader"><?php echo $druh_priz; ?></span> priznanie DPH
    <span class="subheader">id <?php echo $cislo_cpid; ?></span> - ˙prava
   </td>
   <td>
    <div class="bar-btn-form-tool">
     <a href="#" title="Sp‰ù do archÌvu" onclick="window.open('../ucto/archivdph2014.php?copern=80&drupoh=1&page=1', '_self' )">Sp‰ù</a>
     <a style="height:16px; border-right:2px solid #39f;">&nbsp;</a>
<?php
if ( $cislo_stvrt == 0 ) { $podmzarchu=" er1 = 0 AND ume = $cislo_ume "; }
if ( $cislo_stvrt > 0 ) { $podmzarchu=" er1 = $cislo_stvrt "; }
$jearchzoznam=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_archivdphzoznam WHERE $podmzarchu ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jearchzoznam=1;
  }
if ( $jearchzoznam == 1 ) { ?>
     <a href="#" onclick="TlacZoznam(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $cislo_stvrt;?>);"
      title="Zobraziù zoznam dokladov k priznaniu DPH podæa riadkov">Doklady DPH</a>
<?php                     } ?>

<?php if ( $jearchzoznam == 1 ) { ?>
     <a href="#" onclick="TlacZoznamRP(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $cislo_stvrt;?>);"
      title='Zobraziù rozdielovÈ doklady, ktorÈ s˙ navyöe oproti archÌvu'>PridanÈ doklady</a>
     <a href="#" onclick="TlacZoznamRM(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $cislo_stvrt;?>);"
      title='Zobraziù rozdielovÈ doklady, ktorÈ ch˝baj˙ oproti archÌvu'>Ch˝baj˙ce doklady</a>
<?php                           } ?>
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="prizdph2014_uprav.php?copern=23&cislo_cpid=<?php echo $cislo_cpid; ?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
$source="prizdph2014_uprav.php?cislo_cpid=$cislo_cpid&cislo_ume=$cislo_ume&cislo_druh=$cislo_druh&cislo_stvrt=$cislo_stvrt&drupoh=1&uprav=1";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>&copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy" class="btn-top-formsave">
</div>

<?php if ( $strana == 1 OR $strana == 9999 ) { ?>
<div class="wrap-form-background">
<img src="../dokumenty/dph2012/dphstr1.jpg" alt="tlaËivo Priznanie DPH 1.strana 309kB"
 class="form-background">

<!-- danove udaje -->
<?php $fir_ficdx=substr($fir_ficd,2,10); ?>
<span class="text-echo-field" style="top:233px; left:99px; width:233px;"><?php echo $fir_ficdx; ?></span>
<span class="text-echo-field" style="top:289px; left:39px; width:234px;"><?php echo $fir_fdicx; ?></span>
<span class="text-echo-field" style="top:344px; left:39px; width:294px;"><?php echo $fir_uctt01; ?></span>

<!-- Druh priznania -->
<?php
$riadne="x";
$opravne="x";
$dodatocne="x";
if ( $cislo_druh == 1 ) { $opravne=""; $dodatocne=""; $dat_dodatocne=""; }
if ( $cislo_druh == 2 ) { $riadne=""; $dodatocne=""; $dat_dodatocne=""; }
if ( $cislo_druh == 3 ) { $riadne=""; $opravne=""; $dat_dodatocne=$h_dap; }
?>
<span class="text-echo" style="top:235px; left:358px;"><?php echo $riadne; ?></span>
<span class="text-echo" style="top:262px; left:358px;"><?php echo $opravne; ?></span>
<span class="text-echo" style="top:289px; left:358px;"><?php echo $dodatocne; ?></span>
<input type="text" name="dad" id="dad" onkeyup="CiarkaNaBodku(this);"
 style="width:201px; top:283px; left:470px;"/>

<!-- Zdanovacie obdobie -->
<?php
//if ( $stvrtrok == 0 ) { $mesiacx=$cislo_ume; if ( $mesiacx < 10 ) { $mesiacx="0".$mesiacx; } }
//if ( $stvrtrok != 0 ) { echo $stvrtrok; }
$mesiac=1*$cislo_ume;
if ( $mesiac < 10 ) { $mesiac="0".$mesiac; }
if ( $mesiac == 0 ) { $mesiac=""; }
$mesiacx=substr($mesiac,0,2);
$mesiacxn=1*$mesiacx;
if ( $stvrtrok == 0 ) { $stvrtrok=""; }
if ( $mesiacxn == 0 ) { $mesiacx=""; }
$stvrtrokx=$stvrtrok;
?>

<span class="text-echo" style="top:264px; left:698px;"><?php echo $mesiacx; ?></span>
<span class="text-echo" style="top:264px; left:774px;"><?php echo $stvrtrokx; ?></span>
<span class="text-echo" style="top:264px; left:829px;"><?php echo $kli_vrok; ?></span>

<!-- typ platitela = natvrdo 1.moznost -->
<span class="text-echo" style="top:323px; left:358px;">x</span>

<!-- FO / PO -->
<span class="text-echo-field" style="top:474px; left:39px; width:876px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo-field" style="top:625px; left:39px; width:661px;"><?php echo $fir_fuli; ?></span>
<span class="text-echo-field" style="top:625px; left:727px; width:187px;"><?php echo $fir_fcdm; ?></span>
<span class="text-echo-field" style="top:681px; left:39px; width:115px;"><?php echo $fir_fpsc; ?></span>
<span class="text-echo-field" style="top:681px; left:182px; width:732px;"><?php echo $fir_fmes; ?></span>
<?php
$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
?>
<span class="text-echo-field" style="top:738px; left:63px; width:67px;"><?php echo $tel_pred; ?></span>
<span class="text-echo-field" style="top:738px; left:158px; width:186px;"><?php echo $tel_za; ?></span>
<?php
$pole = explode("/", $fir_ffax);
$fax_pred=1*$pole[0];
$fax_za=$pole[1];
?>
<span class="text-echo-field" style="top:738px; left:383px; width:67px;"><?php echo $fax_pred; ?></span>
<span class="text-echo-field" style="top:738px; left:478px; width:186px;"><?php echo $fax_za; ?></span>

<!-- Opravnena osoba -->
<span class="text-echo-field" style="top:798px; left:39px; width:876px;"><?php echo $fir_uctt05; ?></span>
<?php
$pole = explode("/", $fir_uctt04);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
?>
<span class="text-echo-field" style="top:853px; left:63px; width:69px;"><?php echo $tel_pred; ?></span>
<span class="text-echo-field" style="top:853px; left:159px; width:186px;"><?php echo $tel_za; ?></span>

<!-- Vyhlasujem dna -->
<span class="text-echo-field" style="top:990px; left:42px; width:210px;"><?php echo $dap; ?></span>

</div> <!-- koniec .wrap-form-background -->
<?php                                        } ?>


<?php if ( $strana == 2 OR $strana == 9999 ) { ?>
<div class="wrap-form-background">
<img src="../dokumenty/dph2012/dphstr2.jpg" alt="tlaËivo Priznanie DPH 2.strana 309kB"
 class="form-background">

<!-- zahlavie strany -->
<?php $fir_ficdx=substr($fir_ficd,2,10); ?>
<span class="text-echo-field" style="top:82px; left:200px; width:233px;"><?php echo $fir_ficdx; ?></span>
<span class="text-echo-field" style="top:82px; left:457px; width:233px;"><?php echo $fir_fdicx; ?></span>

<!-- riadky 01-04 -->
<input type="text" name="r01" id="r01" onkeyup="CiarkaNaBodku(this);"
 style="top:141px; left:319px; width:287px;"/>
<input type="text" name="r02" id="r02" onkeyup="CiarkaNaBodku(this);"
 style="top:141px; left:646px; width:263px;"/>
<input type="text" name="r03" id="r03" onkeyup="CiarkaNaBodku(this);"
 style="top:180px; left:319px; width:287px;"/>
<input type="text" name="r04" id="r04" onkeyup="CiarkaNaBodku(this);"
 style="top:180px; left:646px; width:263px;"/>
<!-- riadky 05-08 -->
<input type="text" name="r05" id="r05" onkeyup="CiarkaNaBodku(this);"
 style="top:218px; left:319px; width:287px;"/>
<input type="text" name="r06" id="r06" onkeyup="CiarkaNaBodku(this);"
 style="top:218px; left:646px; width:263px;"/>
<input type="text" name="r07" id="r07" onkeyup="CiarkaNaBodku(this);"
 style="top:255px; left:319px; width:287px;"/>
<input type="text" name="r08" id="r08" onkeyup="CiarkaNaBodku(this);"
 style="top:255px; left:646px; width:263px;"/>
<!-- riadky 09-10 -->
<input type="text" name="r09" id="r09" onkeyup="CiarkaNaBodku(this);"
 style="top:294px; left:319px; width:287px;"/>
<input type="text" name="r10" id="r10" onkeyup="CiarkaNaBodku(this);"
 style="top:294px; left:646px; width:263px;"/>
<!-- riadky 11-12 -->
<input type="text" name="r11" id="r11" onkeyup="CiarkaNaBodku(this);"
 style="top:331px; left:319px; width:287px;"/>
<input type="text" name="r12" id="r12" onkeyup="CiarkaNaBodku(this);"
 style="top:331px; left:646px; width:263px;"/>
<!-- riadky 13-14 -->
<input type="text" name="r13" id="r13" onkeyup="CiarkaNaBodku(this);"
 style="top:370px; left:319px; width:287px;"/>
<input type="text" name="r14" id="r14" onkeyup="CiarkaNaBodku(this);"
 style="top:370px; left:646px; width:263px;"/>
<!-- riadky 15-17 -->
<input type="text" name="r15" id="r15" onkeyup="CiarkaNaBodku(this);"
 style="top:408px; left:319px; width:287px;"/>
<input type="text" name="r16" id="r16" onkeyup="CiarkaNaBodku(this);"
 style="top:446px; left:319px; width:287px;"/>
<input type="text" name="r17" id="r17" onkeyup="CiarkaNaBodku(this);"
 style="top:484px; left:319px; width:287px;"/>
<!-- riadky 18-25 -->
<input type="text" name="r18" id="r18" onkeyup="CiarkaNaBodku(this);"
 style="top:521px; left:646px; width:263px;"/>
<span class="text-echo-field" style="top:560px; left:646px; width:269px;"><?php echo $r19; ?></span>
<input type="text" name="r20" id="r20" onkeyup="CiarkaNaBodku(this);"
 style="top:599px; left:646px; width:263px;"/>
<input type="text" name="r21" id="r21" onkeyup="CiarkaNaBodku(this);"
 style="top:636px; left:646px; width:263px;"/>
<input type="text" name="r22" id="r22" onkeyup="CiarkaNaBodku(this);"
 style="top:675px; left:646px; width:263px;"/>
<input type="text" name="r23" id="r23" onkeyup="CiarkaNaBodku(this);"
 style="top:712px; left:646px; width:263px;"/>
<input type="text" name="r24" id="r24" onkeyup="CiarkaNaBodku(this);"
 style="top:750px; left:646px; width:263px;"/>
<input type="text" name="r25" id="r25" onkeyup="CiarkaNaBodku(this);"
 style="top:790px; left:646px; width:263px;"/>
<!-- riadky 26-27 -->
<input type="text" name="r26" id="r26" onkeyup="CiarkaNaBodku(this);"
 style="top:831px; left:319px; width:287px;"/>
<input type="text" name="r27" id="r27" onkeyup="CiarkaNaBodku(this);"
 style="top:830px; left:646px; width:263px;"/>
<!-- riadky 28-31 -->
<input type="text" name="r28" id="r28" onkeyup="CiarkaNaBodku(this);"
 style="top:873px; left:646px; width:263px;"/>
<input type="text" name="r29" id="r29" onkeyup="CiarkaNaBodku(this);"
 style="top:912px; left:646px; width:263px;"/>
<input type="text" name="r30" id="r30" onkeyup="CiarkaNaBodku(this);"
 style="top:950px; left:646px; width:263px;"/>
<span class="text-echo-field" style="top:989px; left:646px; width:269px;"><?php echo $r31; ?></span>

<!-- riadok 32 -->
 <input type="checkbox" name="par79ods2" value="1" style="top:1029px; left:252px;"/>

<input type="text" name="r32" id="r32" onkeyup="CiarkaNaBodku(this);"
 style="top:1027px; left:646px; width:263px;"/>
<!-- riadky 33-34 -->
<input type="text" name="r33" id="r33" onkeyup="CiarkaNaBodku(this);"
 style="top:1064px; left:646px; width:263px;"/>
<span class="text-echo-field" style="top:1103px; left:646px; width:269px;"><?php echo $r34; ?></span>

<!-- riadky 35-36 -->
<input type="text" name="r35" id="r35" onkeyup="CiarkaNaBodku(this);"
 style="top:1161px; left:344px; width:261px;"/>
<input type="text" name="r36" id="r36" onkeyup="CiarkaNaBodku(this);"
 style="top:1161px; left:646px; width:263px;"/>
<!-- riadky 37-38 -->
<input type="text" name="r37" id="r37" onkeyup="CiarkaNaBodku(this);"
 style="top:1228px; left:320px; width:263px;"/>
<input type="text" name="r38" id="r38" onkeyup="CiarkaNaBodku(this);"
 style="top:1228px; left:646px; width:263px;"/>
</div> <!-- koniec wrap-form-background -->

<!-- ekorobot -->
 <img src='../obr/robot/robot3.jpg' onclick="zobraz_robotmenu();" class="ekorobot" style="float:left;"
  title='Dobr˝ deÚ, som V·ö EkoRobot, ak m·te ot·zku Ëi ûelanie, kliknite na mÚa'>

<?php if ( $cislo_druh == 3 ) { ?>
<!-- id kvdph = manualna uprava dodatocneho kvdph -->
<div class="kvdph-menu">
 <div style="width:250px;"><strong>ID</strong> priznania DPH a KVDPH, ktorÈ opravujem</div>
 <div style="width:52px;">
  <input type="text" name="cpop" id="cpop"
   style="width:40px; font-size:14px; height:18px; line-height:18px;"/>
 </div>
 <div>(len u <strong>dodatoËn˝ch</strong> priznanÌ !)</div>
</div>

<?php                         } ?>
<?php if ( $cislo_druh != 3 ) { ?>
<div class="kvdph-menu">
 <div style="width:52px;">
  <input type="hidden" name="cpop" id="cpop" />
 </div>

</div>

<?php                         } ?>
<?php                                        } ?>

<div class="navbar">
<!--
   <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2', '_self');" class="<?php echo $clas2; ?> toleft">2</a>
-->
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny"
  class="btn-bottom-formsave" style="top:0;">
</div>
</FORM>


<?php
//mysql_free_result($vysledok);
     }
//koniec uprav
?>

<!-- ekorobot menu -->
<div id="robotmenu" class="wrap-ekorobot-menu" style="display:none;">
 <table class="ekorobot-menu">
 <tr>
  <th style="width:100%;">Koeficient pomernÈho odpoËÌtania DPH
    <img src='../obr/zmazuplne.png' onclick='zhasni_menurobot();' title='Zavrieù menu'
     class="menu-close-btn">
  </th>
 </tr>
<?php if ( $cislo_druh == 3 ) { ?>
 <tr>
  <td style="line-height:30px; height:30px; text-align:center;">
   <a href="#" onclick="Odpoc(<?php echo $cislo_cpid; ?>,'<?php echo $cislo_ume; ?>',<?php echo $cislo_druh; ?>,<?php echo $stvrtrok; ?>);">
    OdpoËÌtaù riadne priznanie DPH od dodatoËnÈho !</a>
  </td>
 </tr>
<?php                         } ?>
<?php if ( $koefmin == 0 OR $koefmin > 1 ) $koefmin="1.00"; ?>
<FORM name='fkoef' method='post' action='#'>
 <tr>
  <td style="height:60px;">
   <p><strong>Druhy</strong> dokladov s pomern˝m uplatnenÌm <span style="font-size:13px;">(napr: 34, 46, 48)</span></p>
   <input type='text' name='h_druhykoef' id='h_druhykoef' maxlenght='30'
    value='<?php echo $druhykoef; ?>' style="width:300px;">
  </td>
 </tr>
 <tr>
  <td>
   <p style="float:left; line-height:34px;"><strong>Koeficient z predch·dz.</strong> kalend·rneho roka</p>
   <input type='text' name='h_koefmin' id='h_koefmin' maxlenght='4' onkeyup="CiarkaNaBodku(this);"
    value='<?php echo $koefmin; ?>' style="width:48px; float:right; position:relative; top:4px; right:30px;">
  </td>
 </tr>
<?php if ( $prepoc == 0 ) { ?>
 <tr>
  <td style="line-height:30px; height:30px; text-align:center;">
   <a href="#" onclick="Prepoc(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $stvrtrok;?>);">
   PrepoËÌtaù pomern˝ odpoËet DPH !</a>
  </td>
 </tr>
<?php                     } ?>
<?php if ( $prepoc == 1 ) { ?>
 <tr>
  <td style="height:60px;">
   <p>Suma 20% DPH za pomernÈ druhy <strong>celkom</strong></p>
   <input type='text' name='h_odpocall' id='h_odpocall' maxlenght='10'
    value='<?php echo $odpocall; ?>' style="width:100px;">
  </td>
 </tr>
 <tr>
  <td style="height:60px;">
   <p>Suma 20% DPH za pomernÈ druhy <strong>upraven·</strong></p>
   <input type='text' name='h_odpocupr' id='h_odpocupr' maxlenght='10'
    value='<?php echo $odpocupr; ?>' style="width:100px;">
  </td>
 </tr>
 <tr>
 	<th style="text-align:center;">
   <span class="alert-success">-- Pomern˝ odpoËet DPH prepoËÌtan˝. --</span>
  </th>
 </tr>
<?php                     } ?>
</FORM>
 </table>
</div> <!-- koniec ekorobot-menu -->
</div> <!-- koniec #content -->

<?php
if ( $prepoc == 1 ) {
?>
<script type="text/javascript">
zobraz_robotmenu();
</script>
<?php
                    }
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>
