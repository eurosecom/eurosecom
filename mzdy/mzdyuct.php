<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 2000;
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


$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmzd = include("../mzdy/vtvmzd.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;

$copern = $_REQUEST['copern'];


$cit_nas = include("../cis/citaj_nas.php");
$cit_nas = include("../cis/citaj_fir.php");

//oprava pomer konatel nie u pm 12,17 2013
if ( $kli_vrok == 2013 )
    {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdpomer SET pm_maj=0 WHERE pm = 12 OR pm = 17 ";
$dsql = mysql_query("$dsqlt");
    }
//koniec oprava pomer konatel nie u pm 12,17 2013

if ( $copern == 10 OR $copern == 20 )
    {
if ( $copern == 10 ) $podm_poc = "ume < ".$vyb_ume;
if ( $copern == 10 ) $podm_obd = "ume = ".$vyb_ume;
if ( $copern == 20 ) $podm_poc = "ume < 1.".$vyb_rok;
if ( $copern == 20 ) $podm_obd = "ume >= 1.".$vyb_rok." AND ume <= 12.".$vyb_rok;

//echo 'pociatok'.$podm_poc;
//echo 'obdobie'.$podm_obd;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$mzdmes="mzdzalmesx".$kli_uzid;
$mzdtrn="mzdzaltrnx".$kli_uzid;
$mzdddp="mzdzalddpx".$kli_uzid;
$mzdkun="mzdzalkunx".$kli_uzid;
$mzdprm="mzdzalprmx".$kli_uzid;

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmesx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalmes WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrnx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzaltrn WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddpx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalddp WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkunx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalkun WHERE ume = $kli_vume";
$vysledek = mysql_query("$sql");
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprmx$kli_uzid ".
"SELECT * FROM F".$kli_vxcf."_mzdzalprm WHERE ume = $kli_vume";
//$vysledek = mysql_query("$sql");


//urob pracovnu mzdprc zjednotenie pri,vyd,pre,poc

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   dru         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   dmn         INT,
   br          INT,
   pom         INT,
   kon         INT,
   oc          INT,
   ico         INT,
   fak         INT,
   pds         INT,
   pms         INT,
   str         INT,
   zak         INT,
   stj         INT,
   hod         DECIMAL(10,2),
   hdd         DECIMAL(10,2),
   ucm         INT(10),
   ucd         INT(10)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc2'.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc3'.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$dat_odp=$kli_vrok."-".$kli_vmes."-1";
$kli_obd=$kli_vmes;
if( $kli_vmes < 10 ) $kli_obd="0".$kli_vmes;
$dok_odp=$kli_vrok."020".$kli_obd;

//zisti ci neieje problem s mzducty
$problem=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzducty";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucf_zp=1*$riaddok->ucf_zp;
  $ucf_np=1*$riaddok->ucf_np;
  $ucf_sp=1*$riaddok->ucf_sp;
  }
if( $ucf_zp == 0 AND $ucf_np == 0 AND $ucf_sp == 0 AND $fir_allx11 > 0 ) { $problem=1; } 
    if ( $problem == 1 )
    {
//echo "riesim problem";

$databaza="";
if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; }


$dsqlt = "DROP TABLE F$kli_vxcf"."_mzducty ";
$dsql = mysql_query("$dsqlt");

$sql = "CREATE TABLE F".$kli_vxcf."_mzducty SELECT * FROM ".$databaza."F".$fir_allx11."_mzducty ";
$vysledek = mysql_query("$sql");

$dsqlt = "UPDATE F$kli_vxcf"."_mzducty SET cfuct=0 ";
$dsql = mysql_query("$dsqlt");



$sql = "SELECT ucm_dovo FROM F$kli_vxcf"."_mzducty";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_ddpf VARCHAR(10) DEFAULT '52490' AFTER puc_kon";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucd_ddpf VARCHAR(10) DEFAULT '33690' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_dovm VARCHAR(10) DEFAULT '0' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_dovo VARCHAR(10) DEFAULT '0' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
}

//koniec zisti ci neieje problem s mzducty
    }


//oductovanie dovolenky z minuleho roka z 323
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzducty";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucm_dovo=1*$riaddok->ucm_dovo;
  $ucm_dovm=1*$riaddok->ucm_dovm;
  }
if( $ucm_dovm > 0 )
{

$dovin = include("dovolenky_minsubor.php");

}
//koniec oductovanie dovolenky z minuleho roka z 323

///////////////////////////////////////////////////////////////mzdove polozky z zalvy
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,ume,'$dat_odp','$dok_odp',dm,0,0,0,oc,0,0,0,0,str,zak,stj,kc,(F$kli_vxcf"."_mzdzalvy.hod),0,0 FROM F$kli_vxcf"."_mzdzalvy WHERE dm != 904 AND dm < 991 AND kc != 0 AND $podm_obd ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");

//oductovanie dovolenky z minuleho roka  - dovolenka minusom na dm506
if( $ucm_dovm > 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,$kli_vume,'$dat_odp','$dok_odp',506,0,0,0,oc,0,0,0,0,stx,zkx,0,-ecerpane,0,0,0 FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid." WHERE konx = 0 AND ecerpane != 0 ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");

}
//koniec oductovanie dovolenky z minuleho roka 

//dopln pom z mzdkun
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_$mzdkun".
" SET F$kli_vxcf"."_mzdprc.pom = F$kli_vxcf"."_$mzdkun.pom ".
" WHERE F$kli_vxcf"."_mzdprc.oc = F$kli_vxcf"."_$mzdkun.oc".
"";
$dsql = mysql_query("$dsqlt");

//dopln str,zak z mzdkun ak str=0 alebo zak=0
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_$mzdkun".
" SET str=stz, zak=zkz ".
" WHERE F$kli_vxcf"."_mzdprc.oc = F$kli_vxcf"."_$mzdkun.oc AND ( str = 0 OR zak = 0 )".
"";
$dsql = mysql_query("$dsqlt");

//dopln kon = konatel  z mzdpomer
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzdpomer".
" SET kon=pm_maj, pms=np_soc ".
" WHERE F$kli_vxcf"."_mzdprc.pom = F$kli_vxcf"."_mzdpomer.pm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln br,prs pre dm z ciselnika dmn
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzddmn".
" SET F$kli_vxcf"."_mzdprc.br = F$kli_vxcf"."_mzddmn.br, pds = prs ".
" WHERE F$kli_vxcf"."_mzdprc.dmn = F$kli_vxcf"."_mzddmn.dm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//////////////////////////////nacitaj ucty miezd
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzducty WHERE ucty = 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucf_zp=$riaddok->ucf_zp;
  $ucf_np=$riaddok->ucf_np;
  $ucf_sp=$riaddok->ucf_sp;
  $ucf_ip=$riaddok->ucf_ip;
  $ucf_pn=$riaddok->ucf_pn;
  $ucf_up=$riaddok->ucf_up;
  $ucf_gf=$riaddok->ucf_gf;
  $ucf_rf=$riaddok->ucf_rf;
  $ucp_zp=$riaddok->ucp_zp;
  $ucp_np=$riaddok->ucp_np;
  $ucp_sp=$riaddok->ucp_sp;
  $ucp_ip=$riaddok->ucp_ip;
  $ucp_pn=$riaddok->ucp_pn;
  $ucp_up=$riaddok->ucp_up;
  $ucp_gf=$riaddok->ucp_gf;
  $ucp_rf=$riaddok->ucp_rf;
  $ucz_zp=$riaddok->ucz_zp;
  $ucz_np=$riaddok->ucz_np;
  $ucz_sp=$riaddok->ucz_sp;
  $ucz_ip=$riaddok->ucz_ip;
  $ucz_pn=$riaddok->ucz_pn;
  $ucz_up=$riaddok->ucz_up;
  $ucz_gf=$riaddok->ucz_gf;
  $ucz_rf=$riaddok->ucz_rf;
  $aupc=100;
  if( $riaddok->ucf_zp > 66666 ) { $aupc=1000; }
  $puczam=1*$riaddok->puc_zam;
  $puckon=1*$riaddok->puc_kon;
  $ucmsoc=1*$riaddok->ucm_soc;
  $ucdsoc=1*$riaddok->ucd_soc;
  $ucmddpf=1*$riaddok->ucm_ddpf;
  $ucdddpf=1*$riaddok->ucd_ddpf;
  $cfuct=1*$riaddok->cfuct;
  if( $cfuct == 0 ) $cfuct=$kli_vxcf;
  }

//dopln ucm a ucd pre dmn z ciselnika dmn zamestnanci
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzddmn".
" SET ucm=(su*$aupc)+au, ucd=$puczam ".
" WHERE ( F$kli_vxcf"."_mzdprc.br = 1 OR F$kli_vxcf"."_mzdprc.br = 2 OR F$kli_vxcf"."_mzdprc.br > 3 ) AND kon = 0 AND F$kli_vxcf"."_mzdprc.dmn = F$kli_vxcf"."_mzddmn.dm".
"";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzddmn".
" SET ucd=(su*$aupc)+au, ucm=$puczam ".
" WHERE F$kli_vxcf"."_mzdprc.br = 3 AND kon = 0 AND F$kli_vxcf"."_mzdprc.dmn = F$kli_vxcf"."_mzddmn.dm".
"";
$dsql = mysql_query("$dsqlt");

//dopln ucm a ucd pre dmn z ciselnika dmn konatelia
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzddmn".
" SET ucm=(suc*$aupc)+auc, ucd=$puckon ".
" WHERE ( F$kli_vxcf"."_mzdprc.br = 1 OR F$kli_vxcf"."_mzdprc.br = 2 OR F$kli_vxcf"."_mzdprc.br > 3 ) AND kon = 1 AND F$kli_vxcf"."_mzdprc.dmn = F$kli_vxcf"."_mzddmn.dm".
"";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_mzddmn".
" SET ucd=(suc*$aupc)+auc, ucm=$puckon ".
" WHERE F$kli_vxcf"."_mzdprc.br = 3 AND kon = 1 AND F$kli_vxcf"."_mzdprc.dmn = F$kli_vxcf"."_mzddmn.dm".
"";
$dsql = mysql_query("$dsqlt");

if( $_SERVER['SERVER_NAME'] == "www.kamenecsro.sk" ) { $polno=0; }
//vnutopodnikove preuctovanie dm104,107 stj != 0 
if( $polno == 1 )
{
//castkov ma gh1 aj gh2 len nulove takze maju ocenenu hodinu prace stroja a mzdy traktoristu preuctovavaju zo stroja na plodinu

//gh2=0 kc=hodiny * sadzba
//gh2!=0 kc=mnozstvo * sadzba
//preuctuj cez 599xxx/699xxx na str,zak zo stj,zak

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,ume,dat,dok,94,0,0,0,0,0,0,0,0,str,zak,stj,0,SUM(hdd),'599000','395000' FROM F$kli_vxcf"."_mzdprc WHERE stj != 0 AND ( dmn = 104 OR dmn = 107 )".
" GROUP BY str,zak,stj".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,ume,dat,dok,95,0,0,0,0,0,0,0,0,0,0,stj,0,SUM(hdd),'395000','699000' FROM F$kli_vxcf"."_mzdprc WHERE stj != 0 AND ( dmn = 104 OR dmn = 107 )".
" GROUP BY stj".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_vyroperacie".
" SET str=strv, zak=zakv, ucd=ucd+oper, hod=hdd*cen1 ".
" WHERE F$kli_vxcf"."_mzdprc.dmn = 95 AND F$kli_vxcf"."_mzdprc.stj = F$kli_vxcf"."_vyroperacie.stroj".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_vyroperacie".
" SET ucm=ucm+oper, hod=hdd*cen1 ".
" WHERE F$kli_vxcf"."_mzdprc.dmn = 94 AND F$kli_vxcf"."_mzdprc.stj = F$kli_vxcf"."_vyroperacie.stroj".
"";
$dsql = mysql_query("$dsqlt");

//exit;

//ak gh1=0  potom str,zak prepis na stj,zaj nechaj hodnotu kc na 521 a preuctuj na str,zak kc cez 599000/699000

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,ume,dat,dok,91,0,0,0,0,0,0,0,0,str,zak,0,SUM(hod),0,'599000','395000' FROM F$kli_vxcf"."_mzdprc WHERE stj != 0 AND ( dmn = 104 OR dmn = 107 )".
" GROUP BY str,zak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,ume,dat,dok,92,0,0,0,0,0,0,0,0,0,0,stj,SUM(hod),0,'395000','699000' FROM F$kli_vxcf"."_mzdprc WHERE stj != 0 AND ( dmn = 104 OR dmn = 107 )".
" GROUP BY stj".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_vyroperacie".
" SET str=strv, zak=zakv ".
" WHERE F$kli_vxcf"."_mzdprc.dmn = 92 AND F$kli_vxcf"."_mzdprc.stj = F$kli_vxcf"."_vyroperacie.stroj".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc,F$kli_vxcf"."_vyroperacie".
" SET str=strv, zak=zakv ".
" WHERE ( F$kli_vxcf"."_mzdprc.dmn = 104 OR F$kli_vxcf"."_mzdprc.dmn = 107 ) AND F$kli_vxcf"."_mzdprc.stj != 0 ".
" AND F$kli_vxcf"."_mzdprc.stj = F$kli_vxcf"."_vyroperacie.stroj".
"";
$dsql = mysql_query("$dsqlt");

//exit;

}
//koniec vnutopodnikove preuctovanie dm104,107 stj != 0
//exit;

//oductovanie dovolenky z minuleho roka  - dovolenka plusom na ucet 323 z uctovania miezd
if( $ucm_dovm > 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,$kli_vume,'$dat_odp','$dok_odp',1323,0,0,0,oc,0,0,0,0,stx,zkx,0,ecerpane,0,$ucm_dovm,$puczam ".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid." WHERE konx = 0 AND ecerpane != 0 AND p522 = 0 ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,$kli_vume,'$dat_odp','$dok_odp',1323,0,0,0,oc,0,0,0,0,stx,zkx,0,ecerpane,0,$ucm_dovm,$puckon ".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid." WHERE konx = 0 AND ecerpane != 0 AND p522 != 0 ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");
}
//koniec oductovanie dovolenky z minuleho roka 

//oductovanie dovolenky z minuleho roka  - odvody -524 a +323
if( $ucm_dovo > 0 )
{
//echo "idem";
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,$kli_vume,'$dat_odp','$dok_odp',1524,0,0,0,oc,0,0,0,0,stx,zkx,0,-ocerpane,0,$ucf_np,$ucp_np ".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid." WHERE konx = 110 AND ocerpane != 0 ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".
" SELECT 1,$kli_vume,'$dat_odp','$dok_odp',1524,0,0,0,oc,0,0,0,0,stx,zkx,0,ocerpane,0,$ucm_dovo,$ucp_np ".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid." WHERE konx = 110 AND ocerpane != 0 ".
" ORDER BY oc".
"";
$dsql = mysql_query("$dsqlt");
}
//koniec oductovanie dovolenky z minuleho roka 

//group za ucm,ucd,str,zak
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 1,ume,LAST_DAY(dat),dok,0,0,0,0,0,0,0,0,0,str,zak,0,SUM(hod),0,ucm,ucd FROM F$kli_vxcf"."_mzdprc ".
" GROUP BY ucm,ucd,str,zak".
"";
$dsql = mysql_query("$dsqlt");


////////////////////////////////////////////////////////////////////////////////////socialny fond
//vymaz pripadne preuctovanie vnutropodnikove aby neslo dvakrat do mzdprc2
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprc WHERE dmn = 91 OR dmn = 92 OR dmn = 93 OR dmn = 94 OR dmn = 95 ";
$dsql = mysql_query("$dsqlt");


$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $soc_perc=$riaddok->soc_perc;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc".
" SET hod=$soc_perc*hod*pds*pms/100, ucm=$ucmsoc, ucd=$ucdsoc ".
" WHERE oc > 0".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 1,ume,LAST_DAY(dat),dok,0,0,0,0,0,0,0,0,0,str,zak,0,SUM(hod),0,ucm,ucd FROM F$kli_vxcf"."_mzdprc ".
" GROUP BY ucm,ucd,str,zak".
"";
$dsql = mysql_query("$dsqlt");


///////////////////////////////////////////////////////////////odvody zamestnanec , zamestnavatel
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 11,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ozam_zp,0,$puczam,$ucz_zp FROM F$kli_vxcf"."_mzdzalsum WHERE ozam_zp > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 12,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ozam_np,0,$puczam,$ucz_np FROM F$kli_vxcf"."_mzdzalsum WHERE ozam_np > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 13,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ozam_sp,0,$puczam,$ucz_sp FROM F$kli_vxcf"."_mzdzalsum WHERE ozam_sp > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 14,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ozam_ip,0,$puczam,$ucz_ip FROM F$kli_vxcf"."_mzdzalsum WHERE ozam_ip > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 15,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ozam_pn,0,$puczam,$ucz_pn FROM F$kli_vxcf"."_mzdzalsum WHERE ozam_pn > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");

//ak rozuctovanie 524 na ZAK(len ak 524 pre vsetky odvody je jedna a nie analytika podla ZP) tak zmen ucf_... na 39530, polno na 395030
$roz524zak=0;
if( $_SERVER['SERVER_NAME'] == "www.montosucto.sk" ) { $roz524zak=1; }
if( $_SERVER['SERVER_NAME'] == "www.esoplastsro.sk" ) { $roz524zak=1; }
if( $polno == 1 ) { $roz524zak=1; }
if( $ucf_np != $ucf_zp ) $roz524zak=0;
if( $ucf_sp != $ucf_zp ) $roz524zak=0;
if( $ucf_ip != $ucf_zp ) $roz524zak=0;
if( $ucf_pn != $ucf_zp ) $roz524zak=0;
if( $ucf_up != $ucf_zp ) $roz524zak=0;
if( $ucf_gf != $ucf_zp ) $roz524zak=0;
if( $ucf_rf != $ucf_zp ) $roz524zak=0;
$ucet524=$ucf_zp;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_zdravpois WHERE pz1 > 0 OR pz2 > 0 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  //echo "idem";
  $riaddok=mysql_fetch_object($sqldok);
  $pz1=1*$riaddok->pz1;
  $pz2=1*$riaddok->pz2;
  if( $pz1 > 0 OR $pz2 > 0 ) $roz524zak=0;
  }

if( $roz524zak == 1 ) { $ucf_zp=39530; $ucf_np=39530; $ucf_sp=39530; $ucf_ip=39530; $ucf_pn=39530; $ucf_up=39530; $ucf_rf=39530; $ucf_gf=39530; }
if( $roz524zak == 1 AND $polno == 1 ) 
{ $ucf_zp=395030; $ucf_np=395030; $ucf_sp=395030; $ucf_ip=395030; $ucf_pn=395030; $ucf_up=395030; $ucf_rf=395030; $ucf_gf=395030; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 21,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_zp,0,$ucf_zp,$ucp_zp FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_zp > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 22,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_np,0,$ucf_np,$ucp_np FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_np > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 23,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_sp,0,$ucf_sp,$ucp_sp FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_sp > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 24,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_ip,0,$ucf_ip,$ucp_ip FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_ip > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 25,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_pn,0,$ucf_pn,$ucp_pn FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_pn > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 24,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_up,0,$ucf_up,$ucp_up FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_up > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 24,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_gf,0,$ucf_gf,$ucp_gf FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_gf > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 24,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ofir_rf,0,$ucf_rf,$ucp_rf FROM F$kli_vxcf"."_mzdzalsum WHERE ofir_rf > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");

//rozuctovanie 524
if( $roz524zak == 1 ) 
{
//echo "rozuctujem 524";

$celkom524=0;
$sqlttt = "SELECT SUM(hod) as sum FROM F$kli_vxcf"."_mzdprc3 WHERE dru >= 21 AND dru <= 25 GROUP BY dmn ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $celkom524=1*$riaddok->sum;
  //echo "celkom524 ".$celkom524;
  }

$celkom52x=0;
$sqlttt = "SELECT SUM(hod) as sum FROM F$kli_vxcf"."_mzdprc2 WHERE LEFT(ucm,3) = 521 OR LEFT(ucm,3) = 522 GROUP BY dmn ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $celkom52x=1*$riaddok->sum;
  //echo "celkom52x ".$celkom52x;
  }

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 29,ume,'$dat_odp','$dok_odp',11,0,0,0,0,0,0,0,0,str,zak,0,SUM(hod),0,$ucet524,$ucf_zp FROM F$kli_vxcf"."_mzdprc2 ".
" WHERE LEFT(F$kli_vxcf"."_mzdprc2.ucm,3) = 521 OR LEFT(F$kli_vxcf"."_mzdprc2.ucm,3) = 522 GROUP BY str,zak".
"";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3".
" SET hod=hod*$celkom524/$celkom52x ".
" WHERE dru = 29".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$celkom524r=0;
$sqlttt = "SELECT SUM(hod) as sum,str,zak FROM F$kli_vxcf"."_mzdprc3 WHERE dru = 29 GROUP BY dru ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $celkom524r=1*$riaddok->sum;
  $strr=1*$riaddok->str;
  $zakr=1*$riaddok->zak;
  //echo "celkom524r ".$celkom524r." str ".$strr." zak ".$zakr;
  }


$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3".
" SET hod=hod-$celkom524r+$celkom524 ".
" WHERE dru = 29 AND str = $strr AND zak = $zakr ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec rozuctovanie 524

//dopln zdrv z kun a pripocitaj analytiku za ZP
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3,F$kli_vxcf"."_mzdzalkun".
" SET F$kli_vxcf"."_mzdprc3.fak = F$kli_vxcf"."_mzdzalkun.zdrv ".
" WHERE F$kli_vxcf"."_mzdprc3.oc = F$kli_vxcf"."_mzdzalkun.oc AND F$kli_vxcf"."_mzdzalkun.ume = $kli_vume AND ( dru = 11 OR dru = 21 ) ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3,F$kli_vxcf"."_zdravpois".
" SET ucd=ucd+pz2 ".
" WHERE F$kli_vxcf"."_mzdprc3.fak = F$kli_vxcf"."_zdravpois.zdrv AND dru = 11".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3,F$kli_vxcf"."_zdravpois".
" SET ucm=ucm+pz1, ucd=ucd+pz2 ".
" WHERE F$kli_vxcf"."_mzdprc3.fak = F$kli_vxcf"."_zdravpois.zdrv AND dru = 21".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3,F$kli_vxcf"."_zdravpois".
" SET fak=0 ".
" dru = 21 OR dru = 11 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//odvody DDp firma
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 31,ume,'$dat_odp','$dok_odp',11,0,0,0,oc,0,0,0,0,0,0,0,ddp_fir,0,$ucmddpf,$ucdddpf FROM F$kli_vxcf"."_mzdzalsum WHERE ddp_fir > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");

//vyplata v hotovosti a na ucet 
if( $alchem == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 16,ume,'$dat_odp','$dok_odp',16,0,0,0,oc,0,0,0,0,0,0,0,sum_hot,0,$puczam,37950 FROM F$kli_vxcf"."_mzdzalsum WHERE sum_hot > 0 AND $podm_obd ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 17,ume,'$dat_odp','$dok_odp',17,0,0,0,oc,0,0,0,0,0,0,0,sum_ban,0,$puczam,37950 FROM F$kli_vxcf"."_mzdzalsum WHERE sum_ban > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
}

//vyplata na ucet 
if( $autovalas == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 17,ume,'$dat_odp','$dok_odp',17,0,0,0,oc,0,0,0,0,0,0,0,sum_ban,0,$puczam,325300 FROM F$kli_vxcf"."_mzdzalsum WHERE sum_ban > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
}

//vyplata na ucet 
if( $emotrans == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 17,ume,'$dat_odp','$dok_odp',17,0,0,0,oc,0,0,0,0,0,0,0,sum_ban,0,$puczam,333000 FROM F$kli_vxcf"."_mzdzalsum WHERE sum_ban > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
}

//vyplata na ucet 
if( $polno == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 17,ume,'$dat_odp','$dok_odp',17,0,0,0,oc,0,0,0,0,0,0,0,sum_ban,0,$puczam,379050 FROM F$kli_vxcf"."_mzdzalsum WHERE sum_ban > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
}

//vyplata na ucet 
if( $medo == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 17,ume,'$dat_odp','$dok_odp',17,0,0,0,oc,0,0,0,0,0,0,0,sum_ban,0,$puczam,37900 FROM F$kli_vxcf"."_mzdzalsum WHERE sum_ban > 0 AND $podm_obd ";
$dsql = mysql_query("$dsqlt");
}

//dopln pom,str,zak z mzdkun
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3,F$kli_vxcf"."_$mzdkun".
" SET F$kli_vxcf"."_mzdprc3.pom = F$kli_vxcf"."_$mzdkun.pom, str=stz, zak=zkz ".
" WHERE F$kli_vxcf"."_mzdprc3.oc = F$kli_vxcf"."_$mzdkun.oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln kon = konatel  z mzdpomer
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3,F$kli_vxcf"."_mzdpomer".
" SET kon=pm_maj".
" WHERE F$kli_vxcf"."_mzdprc3.pom = F$kli_vxcf"."_mzdpomer.pm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//prepis puczam na puckon 
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3".
" SET ucm=$puckon".
" WHERE dru >= 11 AND dru <= 17 AND kon = 1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 1,ume,LAST_DAY(dat),dok,0,0,0,0,0,0,0,0,0,str,zak,0,SUM(hod),0,ucm,ucd FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY ucm,ucd,str,zak".
"";
$dsql = mysql_query("$dsqlt");

//ico,fak pre 37
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc2 SET ico=$fir_fico, fak=10000*ume WHERE LEFT(ucm,2)=37 OR LEFT(ucd,2)=37 ";
$dsql = mysql_query("$dsqlt");

//zaverecne upravy DPS Gbely
if( $fir_fico == 36084514 AND $kli_vrok >= 2016 )
  {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc2 SET ucm=ucm+1, ucd=ucd+1 WHERE str = 100 ";
$dsql = mysql_query("$dsqlt");

  }



//zmaz pracovnu mzdprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc';
$vysledok = mysql_query("$sqlt");
//zmaz pracovnu mzdprc3
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
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

//presun do uctmzd
if ( $copern == 10  )
  {
$zmaztt = "DELETE FROM F$cfuct"."_uctmzd WHERE ume=$kli_vume"; 
$zmazane = mysql_query("$zmaztt");

$h_pop="podsystem Mzdy ".$kli_vume;
$sqlp = "INSERT INTO F$cfuct"."_uctmzd".
" SELECT ume,dat,dok,0,0,ucm,ucd,1,0,hod,ico,fak,'$h_pop',str,zak,'','$kli_uzid',now() FROM F$kli_vxcf"."_mzdprc2 WHERE hod != 0".
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
" FROM F$kli_vxcf"."_mzdprc2 WHERE hod != 0".
" ORDER by ucm,ucd,str,zak".
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
<td class="tlacs" align="left" colspan="5">Prevod do úètovníctva - Mzdy</td>
<td class="tlacs" align="right" colspan="5"> <?php echo $vyb_ume; ?> <?php echo $vyb_naz; ?></td>
<?php
  }
?>
<?php
if ( $copern == 20 )
  {
?>
<td class="tlacs" align="left" colspan="5">Prevod do úètovníctva - Mzdy - okamžitý stav</td>
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
<td class="tlacs" colspan="10">Celkom DOK:&nbsp;<?php echo $scelag1;?> Sk </td>
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
<td class="tlacs">Celkom DOK:&nbsp;<?php echo $scelag1;?> Sk </td>
</tr>
<tr bgcolor="lightblue">
<td class="tlacs">Celkom všetky DOK:&nbsp;<?php echo $sCelkom;?> Sk </td>
</tr>
</table>
<br clear=left>

<?php


$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
if( $kli_vmes < 10 ) $kli_vmes = ""."0".$kli_vmes;


$nazsub=$cfuct."mzd".$kli_vmes;


if (File_Exists ("../tmp/$nazsub.txt")) { $soubor = unlink("../tmp/$nazsub.txt"); }

$soubor = fopen("../tmp/$nazsub.txt", "a+");


  $vysledok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprc2");
  while ($riadok = mysql_fetch_object($vysledok))
  {
  $text = $riadok->ume.";".$riadok->dat.";".$riadok->dok.";".$riadok->ucm.";".$riadok->ucd.";";
  $text = $text.$riadok->ico.";".$riadok->fak.";".$riadok->str.";".$riadok->zak.";".$riadok->hod."\r\n";
  fwrite($soubor, $text);
  }
  mysql_free_result($vysledok);


fclose($soubor);
////////////////////////////////////koniec subor txt

///////////////////////////////////zostava zauctovania pdf1

if (File_Exists ("../tmp/$nazsub.pdf")) { $soubor = unlink("../tmp/$nazsub.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprc2 ORDER BY ucm,ucd";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$pdf->SetFont('arial','',10);

$pdf->Cell(140,5,"Prevod do úètovníctva - Mzdy","0",0,"L");$pdf->Cell(100,5,"$vyb_ume $vyb_naz","0",1,"R");
$pdf->Cell(20,5,"Úè.mes.","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");$pdf->Cell(25,5,"Doklad","1",0,"R");
$pdf->Cell(25,5,"Máda","1",0,"R");$pdf->Cell(25,5,"Dal","1",0,"R");
$pdf->Cell(25,5,"IÈO","1",0,"R");$pdf->Cell(25,5,"faktúra","1",0,"R");$pdf->Cell(25,5,"STR","1",0,"R");$pdf->Cell(25,5,"ZÁK","1",0,"R");
$pdf->Cell(30,5,"Hodnota","1",1,"R");

$pdf->SetFont('arial','',8);

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$pdf->Cell(20,5,"$rtov->ume","1",0,"R");$pdf->Cell(20,5,"$rtov->dat","1",0,"R");$pdf->Cell(25,5,"$rtov->dok","1",0,"R");

$ucm=$rtov->ucm;
$ucd=$rtov->ucd;
$ucmx=$rtov->ucm;
$ucdx=$rtov->ucd;

//rozpoctova.klasifikacia
if( $fir_allx14 == 1 )
   {
$rozpkls=0;
$sqlddt = "SELECT uce, crs FROM F$kli_vxcf"."_crf104nuj_no WHERE uce = $ucm ";
$sqldok = mysql_query("$sqlddt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rozpkls=1*$riaddok->crs;
  }
if( $rozpkls > 0 ) { $pdf->SetFont('arial','',7); $ucmx=$ucmx." rpk ".$rozpkls;  }
   }
$pdf->Cell(25,5,"$ucmx","1",0,"R");
$pdf->SetFont('arial','',8);

//rozpoctova.klasifikacia
if( $fir_allx14 == 1 )
   {
$rozpkls=0;
$sqlddt = "SELECT uce, crs FROM F$kli_vxcf"."_crf104nuj_no WHERE uce = $ucd ";
$sqldok = mysql_query("$sqlddt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rozpkls=1*$riaddok->crs;
  }
if( $rozpkls > 0 ) { $pdf->SetFont('arial','',7); $ucdx=$ucdx." rpk ".$rozpkls;   }
   }
$pdf->Cell(25,5,"$ucdx","1",0,"R");
$pdf->SetFont('arial','',8);

$pdf->Cell(25,5,"$rtov->ico","1",0,"R");$pdf->Cell(25,5,"$rtov->fak","1",0,"R");$pdf->Cell(25,5,"$rtov->str","1",0,"R");$pdf->Cell(25,5,"$rtov->zak","1",0,"R");
$pdf->Cell(30,5,"$rtov->hod","1",1,"R");


}
$i = $i + 1;
$j = $j + 1;

  }

$pdf->SetFont('arial','',10);
$pdf->Cell(140,5,"Celkom za doklad","LTB",0,"L");$pdf->Cell(105,5,"$sCelkom","RTB",1,"R");

$pdf->Output("../tmp/$nazsub.pdf");

///////////////////////////////////koniec zostava zauctovania pdf1

///////////////////////////////////zostava zauctovania pdf2
$nazsub2=$cfuct."mzds".$kli_vmes;

if (File_Exists ("../tmp/$nazsub2.pdf")) { $soubor = unlink("../tmp/$nazsub2.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("P","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcuct';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   pox         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   mdat        DECIMAL(10,2),
   dal         DECIMAL(10,2),
   uce         VARCHAR(10)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcuct'.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuct".
" SELECT 0,ume,dat,dok,ico,fak,str,zak,hod,0,ucm FROM F$kli_vxcf"."_mzdprc2 WHERE dru >= 0 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuct".
" SELECT 0,ume,dat,dok,ico,fak,str,zak,0,hod,ucd FROM F$kli_vxcf"."_mzdprc2 WHERE dru >= 0 ";
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcuct".
" SELECT 1,ume,dat,dok,0,0,0,0,SUM(mdat),SUM(dal),uce FROM F$kli_vxcf"."_mzdprcuct WHERE pox = 0 GROUP BY uce ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprcuct WHERE pox != 1 ";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprcuct ORDER BY uce ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$pdf->SetFont('arial','',10);

$pdf->Cell(140,5,"Prevod do úètovníctva - Mzdy","0",0,"L");$pdf->Cell(0,5,"$vyb_ume $vyb_naz","0",1,"R");
$pdf->Cell(20,5,"Úè.mes.","1",0,"R");$pdf->Cell(20,5,"Dátum","1",0,"R");$pdf->Cell(35,5,"Doklad","1",0,"R");
$pdf->Cell(35,5,"Úèet","1",0,"R");$pdf->Cell(35,5,"Máda","1",0,"R");$pdf->Cell(0,5,"Dal","1",1,"R");


$pdf->SetFont('arial','',8);

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

$pdf->Cell(20,5,"$rtov->ume","1",0,"R");$pdf->Cell(20,5,"$rtov->dat","1",0,"R");$pdf->Cell(35,5,"$rtov->dok","1",0,"R");

$uce=$rtov->uce;
$ucex=$rtov->uce;

//rozpoctova.klasifikacia
if( $fir_allx14 == 1 )
   {
$rozpkls=0;
$sqlddt = "SELECT uce, crs FROM F$kli_vxcf"."_crf104nuj_no WHERE uce = $uce ";
$sqldok = mysql_query("$sqlddt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $rozpkls=1*$riaddok->crs;
  }
if( $rozpkls > 0 ) { $pdf->SetFont('arial','',7); $ucex=$ucex." rpk ".$rozpkls;  }
   }
$pdf->Cell(35,5,"$ucex","1",0,"R");
$pdf->SetFont('arial','',8);



$pdf->Cell(35,5,"$rtov->mdat","1",0,"R");$pdf->Cell(0,5,"$rtov->dal","1",1,"R");


}
$i = $i + 1;
$j = $j + 1;

  }

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcuct';
$vysledok = mysql_query("$sqlt");

$pdf->Output("../tmp/$nazsub2.pdf");

///////////////////////////////////koniec zostava zauctovania pdf2

?>
<a href="../tmp/<?php echo $nazsub; ?>.pdf">Zostava zaúètovania PDF v.1</a><br />
<br />
<br />
<a href="../tmp/<?php echo $nazsub2; ?>.pdf">Zostava zaúètovania PDF v.2</a><br />
<br />
<br />
<a href="../tmp/<?php echo $nazsub; ?>.txt">../tmp/<?php echo $nazsub; ?>.txt</a>


<?php


//zmaz pracovnu mzdprc
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

mysql_free_result($sql);
} while (false);
?>
</BODY>
</HTML>