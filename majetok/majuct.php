<HTML>
<?php

do
{
$sys = 'HIM';
$urov = 2000;
$cslm=500503;
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


$cit_nas = include("../cis/citaj_nas.php");
$cit_fir = include("../cis/citaj_fir.php");

//$poliklinikase=1;

if ( $copern == 10 OR $copern == 20 )
    {
if ( $copern == 10 ) $podm_poc = "ume < ".$vyb_ume;
if ( $copern == 10 ) $podm_obd = "ume = ".$vyb_ume;
if ( $copern == 20 ) $podm_poc = "ume < 1.".$vyb_rok;
if ( $copern == 20 ) $podm_obd = "ume >= 1.".$vyb_rok." AND ume <= 12.".$vyb_rok;

//echo 'pociatok'.$podm_poc;
//echo 'obdobie'.$podm_obd;

//urob pracovnu majprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majprc2';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majprc3';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<majprc
(
   dru         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   inv         INT,
   drm         INT,
   poh         INT,
   dph         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   hod         DECIMAL(10,2),
   ucm         VARCHAR(10),
   ucd         VARCHAR(10)
);
majprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_majprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_majprc2'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_majprc3'.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$dat_odp=$kli_vrok."-".$kli_vmes."-1";
$kli_obd=$kli_vmes;
if( $kli_vmes < 10 ) $kli_obd="0".$kli_vmes;
$dok_odp=$kli_vrok."010".$kli_obd;

//odpis mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 1,ume,'$dat_odp','$dok_odp',inv,drm,poh,dph,0,0,str,zak,mes,0,0 FROM F$kli_vxcf"."_majodpisy WHERE mes != 0 AND $podm_obd ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//zaradenie mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 2,ume,dob,'$dok_odp',inv,drm,poh,dph,0,0,str,zak,cen,0,0 FROM F$kli_vxcf"."_majpoh WHERE poh = 2 AND $podm_obd ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//vyradenie mesiaca obstaravacia cena
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 3,ume,'$dat_odp','$dok_odp',inv,drm,poh,dph,0,0,str,zak,cen,0,0 FROM F$kli_vxcf"."_majpoh WHERE poh = 3 AND $podm_obd ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//vyradenie mesiaca oductuj rocny odpis
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 13,ume,'$dat_odp','$dok_odp',inv,drm,poh,dph,0,0,str,zak,-(ros),0,0 FROM F$kli_vxcf"."_majpoh WHERE ros > 0 AND poh = 3 AND $podm_obd ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//vyradenie mesiaca zostatok k 1.1. 
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 23,ume,'$dat_odp','$dok_odp',inv,drm,poh,dph,0,0,str,zak,zss,0,0 FROM F$kli_vxcf"."_majpoh WHERE zss > 0 AND poh = 3 AND drm != 031 AND $podm_obd ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//zvysenie mesiaca
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 4,ume,'$dat_odp','$dok_odp',inv,drm,poh,dph,0,0,str,zak,hd1,0,0 FROM F$kli_vxcf"."_majpoh WHERE poh = 4 AND $podm_obd ".
" ORDER BY inv".
"";
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre odpis z majdrm podla drm
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrm".
" SET F$kli_vxcf"."_majprc.ucm = F$kli_vxcf"."_majdrm.ucmodpis, F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrm.ucdodpis ".
" WHERE dru = 1 AND F$kli_vxcf"."_majprc.drm = F$kli_vxcf"."_majdrm.cdrm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre zaradenie z majdrm podla drm a potom ucd zmen podla majdobst
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrm".
" SET F$kli_vxcf"."_majprc.ucm = F$kli_vxcf"."_majdrm.ucmzar, F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrm.ucdzar ".
" WHERE dru = 2 AND F$kli_vxcf"."_majprc.drm = F$kli_vxcf"."_majdrm.cdrm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrunak".
" SET F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrunak.udrn  ".
" WHERE dru = 2 AND F$kli_vxcf"."_majprc.dph = F$kli_vxcf"."_majdrunak.cdrn".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre zvysenie z majdrm podla drm 
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrm".
" SET F$kli_vxcf"."_majprc.ucm = F$kli_vxcf"."_majdrm.ucmzar, F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrm.ucdzar ".
" WHERE dru = 4 AND F$kli_vxcf"."_majprc.drm = F$kli_vxcf"."_majdrm.cdrm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre vyradenie obstaravacia cena z majdrm podla drm 
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrm".
" SET F$kli_vxcf"."_majprc.ucm = F$kli_vxcf"."_majdrm.ucmvyr, F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrm.ucdvyr ".
" WHERE dru = 3 AND F$kli_vxcf"."_majprc.drm = F$kli_vxcf"."_majdrm.cdrm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre vyradenie rocny odpis z majdrm podla drm 
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrm".
" SET F$kli_vxcf"."_majprc.ucm = F$kli_vxcf"."_majdrm.ucmvyo, F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrm.ucdvyo ".
" WHERE dru = 13 AND F$kli_vxcf"."_majprc.drm = F$kli_vxcf"."_majdrm.cdrm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre zostatok k 1.1. z majdrm podla drm a uprav podla druhu vyradenia
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdrm".
" SET F$kli_vxcf"."_majprc.ucm = '54100', F$kli_vxcf"."_majprc.ucd = F$kli_vxcf"."_majdrm.ucmvyr ".
" WHERE dru = 23 AND F$kli_vxcf"."_majprc.drm = F$kli_vxcf"."_majdrm.cdrm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majdruvyr".
" SET F$kli_vxcf"."_majprc.ucm = F$kli_vxcf"."_majdruvyr.udrv  ".
" WHERE dru = 23 AND F$kli_vxcf"."_majprc.dph = F$kli_vxcf"."_majdruvyr.cdrv".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$anatri=1;
if( $_SERVER['SERVER_NAME'] == "www.lipovecsro.sk" ) { $anatri=0; }
if( $_SERVER['SERVER_NAME'] == "www.kamenecsro.sk" ) { $anatri=0; }
if( ( $slovakiaplay == 1 OR $polno == 1 ) AND $anatri == 1 )
{
if( $anatri == 1 )
     {
//dopln tri a urob analytiku podla triedy ucm=ucm+(tri*10)
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majmaj".
" SET F$kli_vxcf"."_majprc.ucm = ucm+(tri*10) ".
" WHERE F$kli_vxcf"."_majprc.inv = F$kli_vxcf"."_majmaj.inv AND LEFT(ucm,3) != 551 AND F$kli_vxcf"."_majprc.poh != 3".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majmaj".
" SET F$kli_vxcf"."_majprc.ucd = ucd+(tri*10) ".
" WHERE F$kli_vxcf"."_majprc.inv = F$kli_vxcf"."_majmaj.inv AND LEFT(ucd,3) != 551 AND F$kli_vxcf"."_majprc.poh != 3".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln tri z pohybov pri vyradeni a urob analytiku podla triedy ucm=ucm+(tri*10)
$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majpoh".
" SET F$kli_vxcf"."_majprc.ucm = ucm+(tri*10) ".
" WHERE F$kli_vxcf"."_majprc.inv = F$kli_vxcf"."_majpoh.inv AND LEFT(ucm,3) != 551 AND F$kli_vxcf"."_majprc.poh = 3 AND F$kli_vxcf"."_majpoh.poh = 3".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majpoh".
" SET F$kli_vxcf"."_majprc.ucd = ucd+(tri*10) ".
" WHERE F$kli_vxcf"."_majprc.inv = F$kli_vxcf"."_majpoh.inv AND LEFT(ucd,3) != 551 AND F$kli_vxcf"."_majprc.poh = 3 AND F$kli_vxcf"."_majpoh.poh = 3".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
     }
    
if( $polno != 1 )
     {
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ucm=CONCAT( '0', ucm ) WHERE ucm < 9999 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ucd=CONCAT( '0', ucd ) WHERE ucd < 9999 ";
$dsql = mysql_query("$dsqlt");
     }
if( $polno == 1 )
     {
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ucm=CONCAT( '0', ucm ) WHERE LEFT(ucm,1) = 8 OR LEFT(ucm,1) = 7 OR LEFT(ucm,1) = 2 OR LEFT(ucm,1) = 1 OR LEFT(ucm,2) = 31 OR LEFT(ucm,1) = 4 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ucd=CONCAT( '0', ucd ) WHERE LEFT(ucd,1) = 8 OR LEFT(ucd,1) = 7 OR LEFT(ucd,1) = 2 OR LEFT(ucd,1) = 1 OR LEFT(ucd,2) = 31 OR LEFT(ucd,1) = 4 ";
$dsql = mysql_query("$dsqlt");
     }
}


if( $polno == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc".
" SELECT 2,ume,dat,dok,inv,drm,poh,dph,0,0,str,zak,hod,'614100','624100' FROM F$kli_vxcf"."_majprc WHERE poh = 2 AND dph = 8 AND LEFT(ucm,3) = 026 ".
"";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

//echo "polik".$poliklinikase;

//exit;

//ak je zdroj > 0 a percento eu,bezp > 0 aspon u jednej polozky nastav poliklinikase=1 aby ponukal uctovanie pri zdrojoch financovania eu...
$sql = "SELECT * FROM F$kli_vxcf"."_majtextmaj WHERE zdro > 0 AND cene > 0 ";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $poliklinikase=1;
  }


//uctovanie EUodpisov poliklinikase
if( $poliklinikase == 1 )
     {
//echo "idem";
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ico=0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majtextmaj ".
" SET ico=2 ".
" WHERE F$kli_vxcf"."_majprc.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc2".
" SELECT dru,ume,dat,dok,inv,drm,poh,dph,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc ".
" WHERE ico = 2 AND dru = 1 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET hod=hod*pere/100 ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 11,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,-hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET str=stre, zak=zake, ucm=odme, ucd=odpe ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 )  ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 11,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET ucm=suv1, ucd=suv2 ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 )  ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 11,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");
//exit;
     }
//koniec uctovanie EUodpisov poliklinikase

//exit;

//uctovanie SRodpisov poliklinikase
if( $poliklinikase == 1 )
     {
//echo "idem";
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ico=0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majtextmaj ".
" SET ico=2 ".
" WHERE F$kli_vxcf"."_majprc.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc2".
" SELECT dru,ume,dat,dok,inv,drm,poh,dph,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc ".
" WHERE ico = 2 AND dru = 1 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET hod=hod*peru/100 ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 12,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,-hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET str=stru, zak=zaku, ucm=odmu, ucd=odpu ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 12,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET ucm=suv1, ucd=suv2 ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 12,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");
//exit;
     }
//koniec uctovanie SRodpisov poliklinikase



//uctovanie EUzaradeni a zvyseni poliklinikase
if( $poliklinikase == 1 )
     {
//echo "idem";
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ico=0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majtextmaj ".
" SET ico=2 ".
" WHERE F$kli_vxcf"."_majprc.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) AND ( dru = 2 OR dru = 4 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc2".
" SELECT dru,ume,dat,dok,inv,drm,poh,dph,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET hod=cene ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 21,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,-hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET str=stre, zak=zake, ucm=zrme, ucd=zrpe ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 21,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET ucm=suv3, ucd=suv4 ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 21,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ico=0 ";
$dsql = mysql_query("$dsqlt");

//exit;
     }
//koniec uctovanie EUzaradeni a zvyseni poliklinikase


//uctovanie SRzaradeni a zvyseni poliklinikase
if( $poliklinikase == 1 )
     {
//echo "idem";
$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ico=0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc,F$kli_vxcf"."_majtextmaj ".
" SET ico=2 ".
" WHERE F$kli_vxcf"."_majprc.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) AND ( dru = 2 OR dru = 4 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc2".
" SELECT dru,ume,dat,dok,inv,drm,poh,dph,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET hod=cens ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 22,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,-hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET str=stru, zak=zaku, ucm=zrmu, ucd=zrpu ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 ) ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 22,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc2,F$kli_vxcf"."_majtextmaj ".
" SET ucm=suv3, ucd=suv4 ".
" WHERE F$kli_vxcf"."_majprc2.inv=F$kli_vxcf"."_majtextmaj.invt AND ( F$kli_vxcf"."_majtextmaj.zdro=2 OR F$kli_vxcf"."_majtextmaj.zdro=3 )  ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc ".
" SELECT 22,ume,dat,dok,inv,drm,poh,dph,0,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_majprc2 ".
" WHERE ico = 2 ".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "TRUNCATE TABLE F$kli_vxcf"."_majprc2"; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_majprc SET ico=0 ";
$dsql = mysql_query("$dsqlt");

//exit;
     }
//koniec uctovanie SRzaradeni a zvyseni poliklinikase

//len jedno inv pozri
$dsqlt = "DELETE FROM F$kli_vxcf"."_majprc WHERE inv != 184 ";
//$dsql = mysql_query("$dsqlt");

//group za ucm,ucd,str,zak
$dsqlt = "INSERT INTO F$kli_vxcf"."_majprc2".
" SELECT 1,ume,LAST_DAY(dat),dok,0,0,0,0,0,0,str,zak,SUM(hod),ucm,ucd FROM F$kli_vxcf"."_majprc ".
" GROUP BY ucm,ucd,str,zak".
"";
$dsql = mysql_query("$dsqlt");

//zmaz pracovnu majprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majprc';
$vysledok = mysql_query("$sqlt");
//zmaz pracovnu majprc3
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majprc3';
$vysledok = mysql_query("$sqlt");
    }

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$h_obdp=$kli_vmes;
$h_obdk=$kli_vmes;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Tlaè-V</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">

function ZostavaDok()
                {
 
window.open('majuct_pdf.php?copern=361&page=1&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&drupoh=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</SCRIPT>

</HEAD>
<BODY class="white" >
<?php
// nastavenie vzhladu stranky v IE zahlavie= &d &t &b Strana è. &p z &P pata=prazdna
// na vysku okraje vl=15 vp=15 hr=15 dl=15 poloziek 43    

//presun do uctmaj
if ( $copern == 10  )
  {
$kli_vxcfuct=1*$fir_majx02;
if( $kli_vxcfuct == 0 ) $kli_vxcfuct=1*$kli_vxcf;

$zmaztt = "DELETE FROM F$kli_vxcf"."_majprc2 WHERE hod = 0 "; 
$zmazane = mysql_query("$zmaztt");

$zmaztt = "DELETE FROM F$kli_vxcf"."_majprc2 WHERE ucm = 0 AND ucd = 0 "; 
$zmazane = mysql_query("$zmaztt");

$zmaztt = "DELETE FROM F$kli_vxcfuct"."_uctmaj WHERE ume=$kli_vume"; 
$zmazane = mysql_query("$zmaztt");

$h_pop="podsystem Majetok ".$kli_vume;
$sqlp = "INSERT INTO F$kli_vxcfuct"."_uctmaj".
" SELECT ume,dat,dok,0,0,ucm,ucd,1,0,hod,ico,fak,'$h_pop',str,zak,'','$kli_uzid',now() FROM F$kli_vxcf"."_majprc2 WHERE hod != 0".
" ORDER BY dok,str,zak".
"";

//echo $sqlt;

$sql = mysql_query("$sqlp");
  }

//tlacit zostavu
if ( $copern == 10 OR $copern == 20 )
  {
$sqlt = "SELECT ume,DATE_FORMAt(dat, '%d.%m.%Y' ) AS dat,dok,ico,fak,".
" str,zak,hod,ucm,ucd ".
" FROM F$kli_vxcf"."_majprc2".
" ORDER by dok,ucm,ucd,str,zak".
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
<td class="tlacs" align="left" colspan="5">Prevod do úètovníctva - Dlhodobý majetok

&nbsp;&nbsp;&nbsp;<img src='../obr/tlac.png' onclick='ZostavaDok();' width=15 height=15 border=0 title='Vytlaèi vo formáte PDF' >

</td>
<td class="tlacs" align="right" colspan="5"> <?php echo $vyb_ume; ?> <?php echo $vyb_naz; ?></td>
<?php
  }
?>
<?php
if ( $copern == 20 )
  {
?>
<td class="tlacs" align="left" colspan="5">Prevod do úètovníctva - Dlhodobý majetok - okamžitý stav</td>
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
<td class="tlacs" colspan="10">Celkom DOK:&nbsp;<?php echo $scelag1;?> Eur </td>
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
<td class="tlacs">Celkom DOK:&nbsp;<?php echo $scelag1;?> Eur </td>
</tr>
<tr bgcolor="lightblue">
<td class="tlacs">Celkom všetky DOK:&nbsp;<?php echo $sCelkom;?> Eur </td>
</tr>
</table>
<br clear=left>

<?php

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;

if (File_Exists ("../tmp/maj$kli_vmes.txt")) { $soubor = unlink("../tmp/maj$kli_vmes.txt"); }

$soubor = fopen("../tmp/maj$kli_vmes.txt", "a+");


  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_majprc2");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = $riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->ucm.";".$riadok->ucd.";";
  $text = $text.$riadok->ico.";".$riadok->fak.";".$riadok->str.";".$riadok->zak.";".$riadok->hod."\r\n";
  fwrite($soubor, $text);
  }
  mysql_free_result($vysledok);


fclose($soubor);
?>

<br />

<img src='../obr/tlac.png' onclick='ZostavaDok();' width=15 height=15 border=0 title='Vytlaèi vo formáte PDF' >

&nbsp;&nbsp;&nbsp;

<a href="../tmp/maj<?php echo $kli_vmes; ?>.txt">../tmp/maj<?php echo $kli_vmes; ?>.txt</a>


<?php


//zmaz pracovnu majprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_majprc2';
$vysledok = mysql_query("$sqlt");

mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>