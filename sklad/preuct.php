<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 2000;
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $urov=5000; }
$cslm=402200;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);


$copern = $_REQUEST['copern'];
$kontrol = 1*$_REQUEST['kontrol'];

$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;

if ( $copern == 10 OR $copern == 20 )
    {
if ( $copern == 10 ) $podm_poc = "ume < ".$vyb_ume;
if ( $copern == 10 ) $podm_obd = "ume = ".$vyb_ume;
if ( $copern == 20 ) $podm_poc = "ume < 1.".$vyb_rok;
if ( $copern == 20 ) $podm_obd = "ume >= 1.".$vyb_rok." AND ume <= 12.".$vyb_rok;

//echo 'pociatok'.$podm_poc;
//echo 'obdobie'.$podm_obd;

//urob pracovnu sklprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc3';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<sklprc
(
   ume         FLOAT(8,4),
   dat         DATE,
   skl         INT,
   dok         INT,
   poh         INT,
   ico         INT,
   fak         DECIMAL(10,0),
   str         INT,
   zak         INT,
   cis         VARCHAR(15),
   mno         DECIMAL(10,3),
   cen         DECIMAL(10,4),
   hod         DECIMAL(10,2),
   dru         INT,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10)
);
sklprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc2'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_sklprc3'.$sqlt;
$vytvor = mysql_query("$vsql");

//prijem mesiaca
if( $agrostav != 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),1,0,0 FROM F$kli_vxcf"."_sklpri WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,dok".
"";
$dsql = mysql_query("$dsqlt");
}
if( $agrostav == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),1,0,0 FROM F$kli_vxcf"."_sklpri WHERE ( poh = 4 AND $podm_obd )".
" ORDER BY skl,poh,dok".
"";
$dsql = mysql_query("$dsqlt");
}

//vyhod prijemky,ktore nechces uctovat
$sqltt = "SELECT * FROM F$kli_vxcf"."_sklcph WHERE ucd = 0 AND drp <= 4 ORDER BY poh ";
//echo $sqltt;
//exit;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc WHERE poh = $riadok->poh ";
$dsql = mysql_query("$dsqlt");

}
$i = $i + 1;

  }
//koniec vyhod prijemky,ktore nechces uctovat

//vydaj mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),2,0,0 FROM F$kli_vxcf"."_sklvyd WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,dok".
"";
$dsql = mysql_query("$dsqlt");

//faktury mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),2,0,0 FROM F$kli_vxcf"."_sklfak WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,dok".
"";
$dsql = mysql_query("$dsqlt");

//presun mesiaca vydaj
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),3,0,0 FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,dok".
"";
$dsql = mysql_query("$dsqlt");

//presun mesiaca prijem
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc".
" SELECT ume,dat,sk2,dok,poh,ico,fak,str,zak,cis,mno,cen,(mno*cen),4,0,0 FROM F$kli_vxcf"."_sklpre WHERE ( cis > 0 AND $podm_obd )".
" ORDER BY skl,poh,dok".
"";
$dsql = mysql_query("$dsqlt");


//group za skl,poh,dok,cis
$dsqlt = "INSERT INTO F$kli_vxcf"."_sklprc2".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,cis,mno,cen,SUM(hod),dru,ucm,ucd FROM F$kli_vxcf"."_sklprc ".
" GROUP BY skl,poh,dok,cis,str,zak".
"";
$dsql = mysql_query("$dsqlt");


//dopln ucm pre vydaj
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_sklcph".
" SET F$kli_vxcf"."_sklprc2.ucm = F$kli_vxcf"."_sklcph.ucm ".
" WHERE dru = 2 AND F$kli_vxcf"."_sklprc2.poh = F$kli_vxcf"."_sklcph.poh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucd pre prijem
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_sklcph".
" SET F$kli_vxcf"."_sklprc2.ucd = F$kli_vxcf"."_sklcph.ucd ".
" WHERE dru = 1 AND F$kli_vxcf"."_sklprc2.poh = F$kli_vxcf"."_sklcph.poh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln uce skladu pre prijem
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_skl".
" SET F$kli_vxcf"."_sklprc2.ucm = F$kli_vxcf"."_skl.ucs ".
" WHERE dru = 1 AND F$kli_vxcf"."_sklprc2.skl = F$kli_vxcf"."_skl.skl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln uce skladu pre presun prijem
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_skl".
" SET F$kli_vxcf"."_sklprc2.ucm = F$kli_vxcf"."_skl.ucs ".
" WHERE dru = 4 AND F$kli_vxcf"."_sklprc2.skl = F$kli_vxcf"."_skl.skl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln uce skladu pre vydaj
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_skl".
" SET F$kli_vxcf"."_sklprc2.ucd = F$kli_vxcf"."_skl.ucs ".
" WHERE dru = 2 AND F$kli_vxcf"."_sklprc2.skl = F$kli_vxcf"."_skl.skl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln uce skladu pre presun vydaj
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_skl".
" SET F$kli_vxcf"."_sklprc2.ucd = F$kli_vxcf"."_skl.ucs ".
" WHERE dru = 3 AND F$kli_vxcf"."_sklprc2.skl = F$kli_vxcf"."_skl.skl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucm pre presun vydaj
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_sklcph".
" SET F$kli_vxcf"."_sklprc2.ucm = F$kli_vxcf"."_sklcph.ucm ".
" WHERE dru = 3 AND F$kli_vxcf"."_sklprc2.poh = F$kli_vxcf"."_sklcph.poh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucd pre presun prijem
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2,F$kli_vxcf"."_sklcph".
" SET F$kli_vxcf"."_sklprc2.ucd = F$kli_vxcf"."_sklcph.ucd ".
" WHERE dru = 4 AND F$kli_vxcf"."_sklprc2.poh = F$kli_vxcf"."_sklcph.poh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc';
$vysledok = mysql_query("$sqlt");

    }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè-V</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--

     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na vysku okraje vl=15 vp=15 hr=15 dl=15 poloziek 43    

//uprava poliklinika senica
if( $fir_fico == "36084212" )
          {

$zmaztt = "DELETE FROM F$kli_vxcf"."_sklprc2 WHERE LEFT(ucm,1) != 5 "; 
$zmazane = mysql_query("$zmaztt");

//pohyb10

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501520, ucd=112520 WHERE LEFT(cis,4) = 1520 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501530, ucd=112530 WHERE LEFT(cis,4) = 1533 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501550, ucd=112550 WHERE LEFT(cis,4) = 1550 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501560, ucd=112560 WHERE LEFT(cis,4) = 1580 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501570, ucd=112570 WHERE LEFT(cis,4) = 1590 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501711, ucd=112711 WHERE LEFT(cis,4) = 7110 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501720, ucd=112720 WHERE LEFT(cis,4) = 7120 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501713, ucd=112713 WHERE LEFT(cis,4) = 7130 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501715, ucd=112715 WHERE LEFT(cis,4) = 7150 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501730, ucd=112716 WHERE LEFT(cis,4) = 1716 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501713, ucd=112717 WHERE LEFT(cis,4) = 7170 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501721, ucd=112721 WHERE LEFT(cis,4) = 7210 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501920, ucd=112722 WHERE LEFT(cis,4) = 1722 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501920, ucd=112722 WHERE LEFT(cis,4) = 7220 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501930, ucd=112723 WHERE LEFT(cis,4) = 7230 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501930, ucd=112724 WHERE LEFT(cis,4) = 7240 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501911, ucd=112725 WHERE LEFT(cis,4) = 7250 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501912, ucd=112726 WHERE LEFT(cis,4) = 7260 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501930, ucd=112728 WHERE LEFT(cis,4) = 7280 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501820, ucd=112810 WHERE LEFT(cis,4) = 1810 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501820, ucd=112820 WHERE LEFT(cis,4) = 1820 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501820, ucd=112840 WHERE LEFT(cis,4) = 1840 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501820, ucd=112850 WHERE LEFT(cis,4) = 1850 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501810, ucd=112880 WHERE LEFT(cis,4) = 1880 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501920, ucd=112722 WHERE LEFT(cis,4) = 7221 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=501713, ucd=112717 WHERE LEFT(cis,4) = 7173 AND  LEFT(ucm,3) = 501"; $dsql = mysql_query("$dsqlt");


//pohyb13

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112520 WHERE LEFT(cis,4) = 1520 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112530 WHERE LEFT(cis,4) = 1533 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112550 WHERE LEFT(cis,4) = 1550 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112560 WHERE LEFT(cis,4) = 1580 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112570 WHERE LEFT(cis,4) = 1590 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112711 WHERE LEFT(cis,4) = 7110 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112720 WHERE LEFT(cis,4) = 7120 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112713 WHERE LEFT(cis,4) = 7130 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112715 WHERE LEFT(cis,4) = 7150 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112716 WHERE LEFT(cis,4) = 1716 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112717 WHERE LEFT(cis,4) = 7170 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112721 WHERE LEFT(cis,4) = 7210 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112722 WHERE LEFT(cis,4) = 1722 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112722 WHERE LEFT(cis,4) = 7220 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112723 WHERE LEFT(cis,4) = 7230 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112724 WHERE LEFT(cis,4) = 7240 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112725 WHERE LEFT(cis,4) = 7250 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112726 WHERE LEFT(cis,4) = 7260 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112728 WHERE LEFT(cis,4) = 7280 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112810 WHERE LEFT(cis,4) = 1810 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112820 WHERE LEFT(cis,4) = 1820 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112840 WHERE LEFT(cis,4) = 1840 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112850 WHERE LEFT(cis,4) = 1850 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112880 WHERE LEFT(cis,4) = 1880 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112722 WHERE LEFT(cis,4) = 7221 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 ".
" SET ucm=554100, ucd=112717 WHERE LEFT(cis,4) = 7173 AND  LEFT(ucm,3) = 554"; $dsql = mysql_query("$dsqlt");


$sqlt = <<<sklprc
(


cist 1880 ucm:0:3 501 ;
ucm=501810
ucd=112880
cist 7221 ucm:0:3 501 ;
ucm=501920
ucd=112722

);
sklprc;

          }
//koniec uprava poliklinika senica

//uprava zs senica
if( $fir_fico == "37990845" )
          {

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET ucm=501998 WHERE skl = 1 AND  LEFT(ucm,3) = 501 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET ucm=501999 WHERE skl = 2 AND  LEFT(ucm,3) = 501 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_sklprc2 WHERE LEFT(ucd,3) = 111 "; $dsql = mysql_query("$dsqlt");

          }
//koniec uprava zs senica

//uprava polnohospodarska cinnost
if( $polno == 1 )  {
//rd castkov
if( $fir_fico == "31104452" )  { $uprav = include("uctovanie_rdcastkov.php");    }
//koniec rd castkov
                   }
//koniec uprava polnohospodarska cinnost

//uprava medosro od 2016
if( $medo == 1 AND $kli_vrok >= 2016 )  {
echo "Medo úprava";
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET ucd=13129 WHERE LEFT(ucm,5) = 13229 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET ucd=13139 WHERE LEFT(ucm,5) = 13239 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET ucm=50429, ucd=13229 WHERE LEFT(ucm,3) = 501 AND LEFT(ucd,5) = 13229 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_sklprc2 SET ucm=50439, ucd=13239 WHERE LEFT(ucm,3) = 501 AND LEFT(ucd,5) = 13239 "; $dsql = mysql_query("$dsqlt");
                                     }
//koniec uprava medosro od 2016

//exit;

//presun do uctskl
if ( $copern == 10 )
  {
//na tlac
$sqlp = "INSERT INTO F$kli_vxcf"."_sklprc3".
" SELECT ume,dat,skl,dok,poh,ico,fak,str,zak,0,0,0,SUM(hod),0,ucm,ucd ".
" FROM F$kli_vxcf"."_sklprc2 WHERE hod != 0 GROUP BY ucm,ucd,dok,str,zak,ico,fak".
"";
$sql = mysql_query("$sqlp");

  }

if ( $copern == 10 AND $kontrol == 1 )
  {
?>
<script type="text/javascript">

window.open('../sklad/kontuctskl.php?copern=10&drupoh=1&page=1', '_self' );

</script>
<?php
exit;
  }

if ( $copern == 10 AND $kontrol == 0 )
  {
$kli_vxcfuct=1*$fir_xsk03;
$rovnakesu=0;
if( $kli_vxcfuct == 0 ) { $kli_vxcfuct=1*$kli_vxcf; $rovnakesu=1; }

if( $kli_vrok < 2011 OR $rovnakesu == 1 )
{
$zmaztt = "DELETE FROM F$kli_vxcfuct"."_uctskl WHERE ume=$kli_vume"; 
$zmazane = mysql_query("$zmaztt");
}

$h_pop="podsystem Sklad ".$kli_vume;
if( $kli_vrok >= 2011 AND $rovnakesu == 0 )
{
$zmaztt = "DELETE FROM F$kli_vxcfuct"."_uctskl WHERE ume=$kli_vume AND poh = $kli_vxcf "; 
$zmazane = mysql_query("$zmaztt");
$h_pop="podsystem Sklad ".$kli_vume." F".$kli_vxcf;
}


$sqlp = "INSERT INTO F$kli_vxcfuct"."_uctskl".
" SELECT ume,dat,dok,$kli_vxcf,0,ucm,ucd,1,0,SUM(hod),ico,fak,'$h_pop',str,zak,'','$kli_uzid',now() ".
" FROM F$kli_vxcf"."_sklprc3 WHERE hod != 0 GROUP BY ucm,ucd,dok,str,zak,ico,fak".
"";

//echo $sqlp;

$sql = mysql_query("$sqlp");
  }

//tlacit zostavu
if ( $copern == 10 OR $copern == 20 )
  {

$sqlt = "SELECT ume,DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat,skl,poh,dok,ico,fak,".
" str,zak,hod,ucm,ucd ".
" FROM F$kli_vxcf"."_sklprc3".
" ORDER by dok".
"";

//echo $sqlt;

$sql = mysql_query("$sqlt");
  }
  

// celkom poloziek
$cpol = mysql_num_rows($sql);
// pocet poloziek na strane
$pols = 1*43;
// pocet stran
$xstr =ceil($cpol / $pols);

?>

<?php
$strana = 1;
$celkom = 0.00;
$hodnota = 0.00;
$ag1_min = 999999999999999; //pociatocna hodnota agregacie1 aby bola vzdy vacsia
$pocet_ag1 = 0; //pocet agregacii cislo 1

   while ($strana <= $xstr )
     {
$riad_dokon =  $pols+1;
// pocet stran
$xstr =ceil(($cpol+$pocet_ag1) / $pols);
?>

<table width="660px" align="left" border="1" cellpadding="3" cellspacing="0" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<?php
if ( $copern == 10 )
  {
?>
<td class="tlacs" align="left" colspan="5">Prevod do úètovníctva - Sklady</td>
<td class="tlacs" align="right" colspan="5"> <?php echo $vyb_ume; ?> <?php echo $vyb_naz; ?></td>
<?php
  }
?>
<?php
if ( $copern == 20 )
  {
?>
<td class="tlacs" align="left" colspan="5">Prevod do úètovníctva - Sklady - okamžitý stav</td>
<td class="tlacs" align="right" colspan="5"> <?php echo $vyb_naz; ?></td>
<?php
  }
?>
</tr>
<tr bgcolor="lightblue">
<th class="tlac">UME<th class="tlac">DAT<th class="tlac">Doklad
<th class="tlac">UCM<th class="tlac">UCD<th class="tlac">ICO<th class="tlac">FAK
<th class="tlac">STR<th class="tlac">ZAK<th class="tlac">Hodnota
<br />
</tr>

<?php
$i=($strana*$pols)-$pols-$pocet_ag1;
//koniec vsetkych stran okrem poslednej
$konc=($strana*$pols)-1-$pocet_ag1;
//koniec poslednej strany
if( $strana == $xstr ) $konc=($strana*$pols)-1;
$riad_dokon = $riad_dokon-1;

   while ($i <= $konc )
   {

  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
$riad_dokon = $riad_dokon-1;
$ag1_rozdiel = $ag1_min - $riadok->dok;
$ag1_rozdiel = 0;
?>
<?php
if( $ag1_rozdiel < 0 )
{
?>
<tr bgcolor="lightblue">
<td class="tlacs" colspan="10">Celkom DOK:&nbsp;<?php echo $scelag1;?> <?php echo $mena1;?> </td>
</tr>
<?php
$riad_dokon = $riad_dokon-1;
$pocet_ag1=$pocet_ag1+1;
if( $strana != $xstr ) $konc=$konc-1;
$celag1 = 0;
}
?>

<?php
if( $riad_dokon >= 0 )
                {
?>
<tr>
<td class="tlac" width="10%" >&nbsp;<?php echo $riadok->ume;?></td>
<td class="tlac" width="10%" >&nbsp;<?php echo $riadok->dat;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->dok;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->ucm;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->ucd;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->ico;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->fak;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->str;?></td>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $riadok->zak;?></td>
<?php 
$hodnota = $riadok->hod;
$celkom = $celkom + $hodnota;
$celag1 = $celag1 + $hodnota;
$Cislo=$hodnota+"";
$sText=sprintf("%0.2f", $Cislo);
$Cislo=$celkom+"";
$sCelkom=sprintf("%0.2f", $Cislo);
$Cislo=$celag1+"";
$scelag1=sprintf("%0.2f", $Cislo);
?>
<td class="tlac" align="right" width="10%" >&nbsp;<?php echo $sText;?></td>
</tr>
<?php
                }
?>

<?php
  }
$i = $i + 1;
$ag1_min = $riadok->dok;

   }
?>
</table>
<br clear=left>

<?php
$strana = $strana + 1;
     }
?>

<table width="660px" align="left" border="1" cellpadding="3" cellspacing="0" bordercolor="lightblue" >
<tr bgcolor="lightblue">
<td class="tlacs">Celkom DOK:&nbsp;<?php echo $scelag1;?> <?php echo $mena1;?> </td>
</tr>
<tr bgcolor="lightblue">
<td class="tlacs">Celkom všetky DOK:&nbsp;<?php echo $sCelkom;?> <?php echo $mena1;?> </td>
</tr>
</table>
<br clear=left>

<?php

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

if (File_Exists ("../tmp/mtz$kli_vmes.txt")) { $soubor = unlink("../tmp/mtz$kli_vmes.txt"); }

$soubor = fopen("../tmp/mtz$kli_vmes.txt", "a+");


  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_sklprc3");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = $riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->ucm.";".$riadok->ucd.";";
  $text = $text.$riadok->ico.";".$riadok->fak.";".$riadok->str.";".$riadok->zak.";".$riadok->hod."\r\n";
  fwrite($soubor, $text);
  }
  mysql_free_result($vysledok);


fclose($soubor);
?>

<a href="../tmp/mtz<?php echo $kli_vmes; ?>.txt">../tmp/mtz<?php echo $kli_vmes; ?>.txt</a>


<?php


//zmaz pracovnu sklprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc2';
$vysledok = mysql_query("$sqlt");
//zmaz pracovnu sklprc3
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_sklprc3';
$vysledok = mysql_query("$sqlt");

mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>