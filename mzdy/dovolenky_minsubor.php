<?php

//prac.subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovol'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovolx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcdovolz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   pox          INT(7) DEFAULT 0,
   pomer        INT(7) DEFAULT 0,
   uvazok       DECIMAL(10,2) DEFAULT 0,
   p522         INT(7) DEFAULT 0,
   stx          DECIMAL(10,0) DEFAULT 0,
   zkx          DECIMAL(10,0) DEFAULT 0,
   minul        DECIMAL(10,2) DEFAULT 0,
   ccerpane     DECIMAL(10,2) DEFAULT 0,
   cerpane      DECIMAL(10,2) DEFAULT 0,
   mcerpane     DECIMAL(10,2) DEFAULT 0,
   ecerpane     DECIMAL(10,2) DEFAULT 0,
   mpriem       DECIMAL(10,4) DEFAULT 0,
   meur         DECIMAL(10,2) DEFAULT 0,
   priemer      DECIMAL(10,4) DEFAULT 0,
   minzos       DECIMAL(10,2) DEFAULT 0,
   zoseur       DECIMAL(10,2) DEFAULT 0,
   modv         DECIMAL(10,2) DEFAULT 0,
   ocerpane     DECIMAL(10,2) DEFAULT 0,
   zosodv       DECIMAL(10,2) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcdovol'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcdovolx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcdovolz'.$kli_uzid.$sqlt;
//$vytvor = mysql_query("$vsql");

//zober data z kun 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" SELECT oc,0,0,0,0,0,0,".
"nev,0,0,0,0,0,0,0,0,0,".
"0,0,0,0".
" FROM F$kli_vxcf"."_mzdzalkun".
" WHERE ume = $kli_vume ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z vy 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" SELECT oc,0,0,0,0,0,0,".
"0,dni,0,0,0,0,0,0,0,0,".
"0,0,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume <= $kli_vume AND ( dm = 506 OR dm = 507 OR dm = 508 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//zober data z vy 
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" SELECT oc,0,0,0,0,0,0,".
"0,0,dni,0,0,0,0,0,0,0,".
"0,0,0,0".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE ume = $kli_vume AND ( dm = 506 OR dm = 507 OR dm = 508 )".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//sumar za oc
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,1,0,0,0,0,0,".
"SUM(minul),SUM(ccerpane),SUM(cerpane),0,0,0,0,0,0,0,".
"0,0,0,0".
" FROM F$kli_vxcf"."_mzdprcdovol".$kli_uzid.
" WHERE pox = 0".
" GROUP BY oc";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

//dopln udaje z kun
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid,F$kli_vxcf"."_mzdzalkun".
" SET pomer=pom, priemer=znah, uvazok=uva, stx=stz, zkx=zkz ".
" WHERE F$kli_vxcf"."_mzdprcdovolx$kli_uzid.oc = F$kli_vxcf"."_mzdzalkun.oc AND ume = $kli_vume";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//dopln kon = konatel  z mzdpomer
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid,F$kli_vxcf"."_mzdpomer".
" SET p522=pm_maj ".
" WHERE F$kli_vxcf"."_mzdprcdovolx$kli_uzid.pomer = F$kli_vxcf"."_mzdpomer.pm".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln udaje z kun priemer na pociatku roku
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid,F$kli_vxcf"."_mzdzalkun".
" SET mpriem=znah ".
" WHERE F$kli_vxcf"."_mzdprcdovolx$kli_uzid.oc = F$kli_vxcf"."_mzdzalkun.oc AND ume = 1.$kli_vrok";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_mzdprcdovolx$kli_uzid WHERE pox = 0 ";
//echo $sqtoz;
//$oznac = mysql_query("$sqtoz");


//vypocitaj sucty
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET ccerpane=minul WHERE oc > 0 AND ccerpane > minul";
//$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET cerpane=minul WHERE oc > 0 AND cerpane > minul";
//$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET mcerpane=cerpane  WHERE oc > 0 AND minul >= ccerpane AND cerpane != 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET mcerpane=cerpane-(ccerpane-minul) WHERE oc > 0 AND minul < ccerpane AND cerpane != 0";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET mcerpane=0 WHERE oc > 0 AND mcerpane < 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET ccerpane=minul WHERE oc > 0 AND ccerpane > minul";
$oznac = mysql_query("$sqtoz");


$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET minzos=minul-ccerpane WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET meur=mpriem*minul*uvazok, zoseur=mpriem*minzos*uvazok, ecerpane=mpriem*mcerpane*uvazok  WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

//sumar za vsetko
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,1,0,uvazok,0,0,0,".
"SUM(minul),SUM(ccerpane),SUM(cerpane),SUM(mcerpane),SUM(ecerpane),0,SUM(meur),0,SUM(minzos),SUM(zoseur),".
"0,0,0,9".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" WHERE pox = 1".
" GROUP BY pox";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzducty";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $ucm_dovo=1*$riaddok->ucm_dovo;
  }

if( $ucm_dovo > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcdovolx$kli_uzid".
" SET modv=0.352*meur, zosodv=0.352*zoseur, ocerpane=0.352*ecerpane  WHERE oc > 0 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,0,0,uvazok,0,stx,zkx,".
"0,0,0,0,SUM(ecerpane),0,SUM(meur),0,0,SUM(zoseur),".
"SUM(modv),SUM(ocerpane),SUM(zosodv),10".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" WHERE konx = 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,0,0,uvazok,0,0,0,".
"0,0,0,0,SUM(ecerpane),0,SUM(meur),0,0,SUM(zoseur),".
"SUM(modv+meur),SUM(ocerpane+ecerpane),SUM(zosodv+zoseur),11".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" WHERE konx = 0".
" GROUP BY konx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" SELECT oc,0,0,uvazok,0,stx,zkx,".
"0,0,0,0,SUM(ecerpane),0,SUM(meur),0,0,SUM(zoseur),".
"SUM(modv),SUM(ocerpane),SUM(zosodv),110".
" FROM F$kli_vxcf"."_mzdprcdovolx".$kli_uzid.
" WHERE konx = 0".
" GROUP BY stx,zkx";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

?>