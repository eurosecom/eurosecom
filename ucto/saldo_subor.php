<?php
if( $fir_fico == "44537018" AND $kli_vrok < 2010 )
{
$sql = "DROP TABLE F$kli_vxcf"."_uctsaldo_ok$kli_uzid";
$zmaz = mysql_query($sql);
}

$sql = "SELECT * FROM F$kli_vxcf"."_uctsaldo_ok$kli_uzid";
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok) {

//echo "robim nove saldo";
//urob pracovnu prsaldo zjednotenie fakodb,fakdod,pokpri,pokvyd,banvyp

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoico'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prsaldoa'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqltdef = <<<prsaldo
(
   drupoh      INT,
   uce         VARCHAR(10),
   puc         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   ico         INT(10),
   fak         DECIMAL(10,0),
   poz         VARCHAR(80),
   ksy         VARCHAR(10),
   ssy         VARCHAR(10),
   hdp         DECIMAL(10,2),
   hdu         DECIMAL(10,2),
   hod         DECIMAL(10,2),
   uhr         DECIMAL(10,2),
   zos         DECIMAL(10,2),
   dau         DATE
);
prsaldo;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoico'.$kli_uzid.$sqltdef;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofak'.$kli_uzid.$sqltdef;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoicofakp'.$kli_uzid.$sqltdef;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldo'.$kli_uzid.$sqltdef;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prsaldoa'.$kli_uzid.$sqltdef;
$vytvor = mysql_query("$vsql");

$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 )";
$aj37=0;
if( $agrostav == 1 OR $autovalas == 1 OR $delisasro == 1 OR $metalco == 1 OR $polno == 1 OR $lsucto == 1 OR $sekov == 1 OR $alchem == 1 )
{
//echo "idem";
$podmucm="( LEFT(ucm,2) = 31 OR LEFT(ucm,2) = 32 OR LEFT(ucm,2) = 37 OR LEFT(ucm,3) = 335 OR LEFT(ucm,2) = 47 OR LEFT(ucm,3) = 391 )";
$podmucd="( LEFT(ucd,2) = 31 OR LEFT(ucd,2) = 32 OR LEFT(ucd,2) = 37 OR LEFT(ucd,3) = 335 OR LEFT(ucd,2) = 47 OR LEFT(ucd,3) = 391 )";
$aj37=1;
}

//faktury podvojne uctovnictvo
if( $kli_vduj != 9 ) 
   { 
if( $odber == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoa".$kli_uzid.
" SELECT 5,ucm,0,ume,dat,das,daz,F$kli_vxcf"."_uctodb.dok,F$kli_vxcf"."_uctodb.ico,F$kli_vxcf"."_uctodb.fak,".
" txp,ksy,ssy,0,0,F$kli_vxcf"."_uctodb.hod,0,F$kli_vxcf"."_uctodb.hod,'0000-00-00' FROM F$kli_vxcf"."_fakodb,F$kli_vxcf"."_uctodb ".
" WHERE F$kli_vxcf"."_fakodb.dok=F$kli_vxcf"."_uctodb.dok AND $podmucm ".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoa".$kli_uzid.
" SELECT 5,ucd,0,ume,dat,das,daz,F$kli_vxcf"."_uctodb.dok,F$kli_vxcf"."_uctodb.ico,F$kli_vxcf"."_uctodb.fak,".
" txp,ksy,ssy,0,0,0,F$kli_vxcf"."_uctodb.hod,-(F$kli_vxcf"."_uctodb.hod),'0000-00-00' FROM F$kli_vxcf"."_fakodb,F$kli_vxcf"."_uctodb ".
" WHERE F$kli_vxcf"."_fakodb.dok=F$kli_vxcf"."_uctodb.dok AND $podmucd ".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 5,uce,0,ume,dat,das,daz,dok,ico,fak,poz,ksy,ssy,0,0,SUM(hod),SUM(uhr),SUM(zos),'0000-00-00' FROM F$kli_vxcf"."_prsaldoa$kli_uzid WHERE dok != 0".
" GROUP BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoa'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

}

if( $dodav == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoa".$kli_uzid.
" SELECT 6,ucd,0,ume,dat,das,daz,F$kli_vxcf"."_uctdod.dok,F$kli_vxcf"."_uctdod.ico,F$kli_vxcf"."_uctdod.fak,".
" txp,ksy,ssy,0,0,-(F$kli_vxcf"."_uctdod.hod),0,-(F$kli_vxcf"."_uctdod.hod),'0000-00-00' FROM F$kli_vxcf"."_fakdod,F$kli_vxcf"."_uctdod ".
" WHERE F$kli_vxcf"."_fakdod.dok=F$kli_vxcf"."_uctdod.dok AND $podmucd ".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoa".$kli_uzid.
" SELECT 6,ucm,0,ume,dat,das,daz,F$kli_vxcf"."_uctdod.dok,F$kli_vxcf"."_uctdod.ico,F$kli_vxcf"."_uctdod.fak,".
" txp,ksy,ssy,0,0,0,-(F$kli_vxcf"."_uctdod.hod),F$kli_vxcf"."_uctdod.hod,'0000-00-00' FROM F$kli_vxcf"."_fakdod,F$kli_vxcf"."_uctdod ".
" WHERE F$kli_vxcf"."_fakdod.dok=F$kli_vxcf"."_uctdod.dok AND $podmucm ".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 6,uce,0,ume,dat,das,daz,dok,ico,fak,poz,ksy,ssy,0,0,SUM(hod),SUM(uhr),SUM(zos),'0000-00-00' FROM F$kli_vxcf"."_prsaldoa$kli_uzid WHERE dok != 0".
" GROUP BY uce,ico,fak,dok".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_prsaldoa'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
}


if( $odber == 1 AND ( $fir_allx11 == 0 OR $kli_vrok < 2010 ) )
{
//echo "robim";
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 7,uce,0,ume,dat,das,daz,dok,ico,fak,txp,ksy,ssy,0,0,hodu,uhr,(hodu-uhr),'0000-00-00' FROM F$kli_vxcf"."_fakodbpoc WHERE uce > 0 AND ( hodu != 0 OR uhr != 0 )".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $dodav == 1 AND ( $fir_allx11 == 0 OR $kli_vrok < 2010 ) )
{
//echo "robim";
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 8,uce,0,ume,dat,das,daz,dok,ico,fak,txp,ksy,ssy,0,0,-hodu,-uhr,-(hodu-uhr),'0000-00-00' FROM F$kli_vxcf"."_fakdodpoc WHERE uce > 0 AND ( hodu != 0 OR uhr != 0 )".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}


if( $odber == 1 AND $fir_allx11 > 0 AND $kli_vrok >= 2010 )
{
$uzcis="";
if( $fir_big != 1 )
{
//echo " xxx ";
$uzcis=$kli_uzid;
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsaldopoco'.$uzcis.' ';
$vytvor = mysql_query("$vsql");
}

$sql = "SELECT * FROM F$kli_vxcf"."_uctsaldopoco".$uzcis."";
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok) 
//neexistuje subor
     {
//echo "robim";

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctsaldopoco'.$uzcis.' '.$sqltdef;
$vytvor = mysql_query("$vsql");

$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctsaldopoco'.$uzcis.' ';
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctsaldopoco".$uzcis."".
" SELECT 7,ucm,0,ume,dat,dat,dat,dok,ico,fak,".
" '','','',0,0,hod,0,hod,'0000-00-00' FROM F$kli_vxcf"."_fakodbpocuct ".
" WHERE $podmucm ".
" ORDER BY ucm,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctsaldopoco".$uzcis."".
" SELECT 7,ucd,0,ume,dat,dat,dat,dok,ico,fak,".
" '','','',0,0,0,hod,-hod,'0000-00-00' FROM F$kli_vxcf"."_fakodbpocuct ".
" WHERE $podmucd ".
" ORDER BY ucd,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ssy,ksy,das z fakodbpoc
$sqtoz = "UPDATE F$kli_vxcf"."_uctsaldopoco".$uzcis.",F$kli_vxcf"."_fakodbpoc".
" SET F$kli_vxcf"."_uctsaldopoco".$uzcis.".ksy=F$kli_vxcf"."_fakodbpoc.ksy, ".
" F$kli_vxcf"."_uctsaldopoco".$uzcis.".ssy=F$kli_vxcf"."_fakodbpoc.ssy, ".
" F$kli_vxcf"."_uctsaldopoco".$uzcis.".poz=F$kli_vxcf"."_fakodbpoc.txp, ".
" F$kli_vxcf"."_uctsaldopoco".$uzcis.".das=F$kli_vxcf"."_fakodbpoc.das ".
" WHERE F$kli_vxcf"."_uctsaldopoco".$uzcis.".uce=F$kli_vxcf"."_fakodbpoc.uce ".
" AND F$kli_vxcf"."_uctsaldopoco".$uzcis.".ico=F$kli_vxcf"."_fakodbpoc.ico ".
" AND F$kli_vxcf"."_uctsaldopoco".$uzcis.".fak=F$kli_vxcf"."_fakodbpoc.fak".
"";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//koniec neexistuje subor
     }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 7,uce,0,ume,dat,das,daz,dok,ico,fak,poz,ksy,ssy,0,0,SUM(hod),SUM(uhr),SUM(zos),'0000-00-00' FROM F$kli_vxcf"."_uctsaldopoco".$uzcis." WHERE dok != 0".
" GROUP BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $dodav == 1 AND $fir_allx11 > 0 AND $kli_vrok >= 2010 )
{
$uzcis="";
if( $fir_big != 1 )
{
//echo " xxx";
$uzcis=$kli_uzid;
$vsql = 'DROP TABLE F'.$kli_vxcf.'_uctsaldopocd'.$uzcis.' ';
$vytvor = mysql_query("$vsql");
}


$sql = "SELECT * FROM F$kli_vxcf"."_uctsaldopocd".$uzcis." ";
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok) 
//neexistuje subor
     {

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctsaldopocd'.$uzcis.' '.$sqltdef;
$vytvor = mysql_query("$vsql");

$sqlt = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctsaldopocd'.$uzcis.' ';
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctsaldopocd".$uzcis." ".
" SELECT 8,ucm,0,ume,dat,dat,dat,dok,ico,fak,".
" '','','',0,0,0,-hod,hod,'0000-00-00' FROM F$kli_vxcf"."_fakdodpocuct ".
" WHERE $podmucm ".
" ORDER BY ucm,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctsaldopocd".$uzcis." ".
" SELECT 8,ucd,0,ume,dat,dat,dat,dok,ico,fak,".
" '','','',0,0,-hod,0,-hod,'0000-00-00' FROM F$kli_vxcf"."_fakdodpocuct ".
" WHERE $podmucd ".
" ORDER BY ucd,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//dopln ssy,ksy,das z fakdodpoc
$sqtoz = "UPDATE F$kli_vxcf"."_uctsaldopocd".$uzcis.",F$kli_vxcf"."_fakdodpoc".
" SET F$kli_vxcf"."_uctsaldopocd".$uzcis.".ksy=F$kli_vxcf"."_fakdodpoc.ksy, ".
" F$kli_vxcf"."_uctsaldopocd".$uzcis.".ssy=F$kli_vxcf"."_fakdodpoc.ssy, ".
" F$kli_vxcf"."_uctsaldopocd".$uzcis.".poz=F$kli_vxcf"."_fakdodpoc.txp, ".
" F$kli_vxcf"."_uctsaldopocd".$uzcis.".das=F$kli_vxcf"."_fakdodpoc.das ".
" WHERE F$kli_vxcf"."_uctsaldopocd".$uzcis.".uce=F$kli_vxcf"."_fakdodpoc.uce ".
" AND F$kli_vxcf"."_uctsaldopocd".$uzcis.".ico=F$kli_vxcf"."_fakdodpoc.ico ".
" AND F$kli_vxcf"."_uctsaldopocd".$uzcis.".fak=F$kli_vxcf"."_fakdodpoc.fak".
"";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//koniec neexistuje subor
     }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 8,uce,0,ume,dat,das,daz,dok,ico,fak,poz,ksy,ssy,0,0,SUM(hod),SUM(uhr),SUM(zos),'0000-00-00' FROM F$kli_vxcf"."_uctsaldopocd".$uzcis." WHERE dok != 0".
" GROUP BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

   }
//koniec faktury podvojne uctovnictvo

//faktury jednoduche uctovnictvo
if( $kli_vduj == 9 ) 
   { 
$dsqlt = "UPDATE F$kli_vxcf"."_fakodb SET hodu=hod, dn1u=dn1, zk1u=zk1, sp1u=sp1, dn2u=dn2, zk2u=zk2, sp2u=sp2 WHERE hodu = 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_fakdod SET hodu=hod, dn1u=dn1, zk1u=zk1, sp1u=sp1, dn2u=dn2, zk2u=zk2, sp2u=sp2 WHERE hodu = 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_fakodbpoc SET hodu=hod, dn1u=dn1, zk1u=zk1, sp1u=sp1, dn2u=dn2, zk2u=zk2, sp2u=sp2 WHERE hodu = 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_fakdodpoc SET hodu=hod, dn1u=dn1, zk1u=zk1, sp1u=sp1, dn2u=dn2, zk2u=zk2, sp2u=sp2 WHERE hodu = 0 ";
$dsql = mysql_query("$dsqlt");

if( $odber == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 5,uce,0,ume,dat,das,daz,dok,ico,fak,txp,ksy,ssy,(dn1u+dn2u),0,hodu,0,hodu,'0000-00-00' FROM F$kli_vxcf"."_fakodb WHERE uce > 0".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $dodav == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 6,uce,0,ume,dat,das,daz,dok,ico,fak,txp,ksy,ssy,(dn1u+dn2u),0,-hodu,0,-hodu,'0000-00-00' FROM F$kli_vxcf"."_fakdod WHERE uce > 0".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $odber == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 7,uce,0,ume,dat,das,daz,dok,ico,fak,txp,ksy,ssy,(dn1u+dn2u-uhr),0,hodu,uhr,(hodu-uhr),'0000-00-00' FROM F$kli_vxcf"."_fakodbpoc WHERE uce > 0".
" ORDER BY uce,ico,fak".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}

if( $dodav == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo".$kli_uzid.
" SELECT 8,uce,0,ume,dat,das,daz,dok,ico,fak,txp,ksy,ssy,(dn1u+dn2u-uhr),0,-hodu,-uhr,-(hodu-uhr),'0000-00-00' FROM F$kli_vxcf"."_fakdodpoc WHERE uce > 0".
" ORDER BY uce,ico,fak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
$dsqlt = "UPDATE F$kli_vxcf"."_prsaldo".$kli_uzid." SET hdp=0 WHERE hdp < 0 ";
$dsql = mysql_query("$dsqlt");

   }
//koniec faktury jednoduche

$psysx=10;
while ($psysx <= 13 ) 
  {
//zober prijmove pokl
if( $psysx == 11 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psysx == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psysx == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psysx == 10 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }

$psys=$psysx;
if( $psysx == 10 ) $psys=14;

if( $psysx <= 13 )
{

if( $kli_vduj != 9 ) 
   { 
if( $odber == 1 )
{
if( $fir_allx15 == 0 OR $psysx != 13  )  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,ucd,0,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"CONCAT(txp, ' ', F$kli_vxcf"."_$uctovanie.pop),'','',0,0,0,F$kli_vxcf"."_$uctovanie.hod,-(F$kli_vxcf"."_$uctovanie.hod),dat".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND $podmucd ";
$dsql = mysql_query("$dsqlt");
                                         }
if( $fir_allx15 == 1 AND $psysx == 13  ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,ucd,0,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"CONCAT(txp, ' ', F$kli_vxcf"."_$uctovanie.pop),'','',0,0,0,F$kli_vxcf"."_$uctovanie.hod,-(F$kli_vxcf"."_$uctovanie.hod),ddu".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND $podmucd ";
$dsql = mysql_query("$dsqlt");
                                         }
}

if( $dodav == 1 )
{
if( $fir_allx15 == 0 OR $psysx != 13  )  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,ucm,0,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"CONCAT(txp, ' ', F$kli_vxcf"."_$uctovanie.pop),'','',0,0,0,-(F$kli_vxcf"."_$uctovanie.hod),F$kli_vxcf"."_$uctovanie.hod,dat".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND $podmucm ";
$dsql = mysql_query("$dsqlt");
                                         }
if( $fir_allx15 == 1 AND $psysx == 13  ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,ucm,0,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"CONCAT(txp, ' ', F$kli_vxcf"."_$uctovanie.pop),'','',0,0,0,-(F$kli_vxcf"."_$uctovanie.hod),F$kli_vxcf"."_$uctovanie.hod,ddu".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND $podmucm ";
$dsql = mysql_query("$dsqlt");
                                         }
}

   }
//koniec klivduj!=9


if( $kli_vduj == 9 ) 
   { 
if( $odber == 1 )
{
//ak je ucm 211 alebo 221
if( $fir_allx15 == 0 OR $psysx != 13  )  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,31100,ucd,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"txp,'','',0,0,0,F$kli_vxcf"."_$uctovanie.hod,-(F$kli_vxcf"."_$uctovanie.hod),dat".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND fak != 0 AND F$kli_vxcf"."_$uctovanie.ico != 0 ".
" AND ( LEFT(ucm,3) = 211 OR LEFT(ucm,3) = 221 ) ";
$dsql = mysql_query("$dsqlt");
                                         }
if( $fir_allx15 == 1 AND $psysx == 13  ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,31100,ucd,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"txp,'','',0,0,0,F$kli_vxcf"."_$uctovanie.hod,-(F$kli_vxcf"."_$uctovanie.hod),ddu".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND fak != 0 AND F$kli_vxcf"."_$uctovanie.ico != 0 ".
" AND ( LEFT(ucm,3) = 211 OR LEFT(ucm,3) = 221 ) ";
$dsql = mysql_query("$dsqlt");
                                         }
}

if( $dodav == 1 )
{
//ak je ucd 211 alebo 221
if( $fir_allx15 == 0 OR $psysx != 13  )  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,32100,ucm,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"txp,'','',0,0,0,-(F$kli_vxcf"."_$uctovanie.hod),F$kli_vxcf"."_$uctovanie.hod,dat".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND fak != 0 AND F$kli_vxcf"."_$uctovanie.ico != 0 ".
" AND ( LEFT(ucd,3) = 211 OR LEFT(ucd,3) = 221 )";
$dsql = mysql_query("$dsqlt");
                                         }
if( $fir_allx15 == 1 AND $psysx == 13  ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,32100,ucm,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.ico,fak,".
"txp,'','',0,0,0,-(F$kli_vxcf"."_$uctovanie.hod),F$kli_vxcf"."_$uctovanie.hod,ddu".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND fak != 0 AND F$kli_vxcf"."_$uctovanie.ico != 0 ".
" AND ( LEFT(ucd,3) = 211 OR LEFT(ucd,3) = 221 )";
$dsql = mysql_query("$dsqlt");
                                         }
}
   }
//koniec klivduj=9

}
else
{


}
$psysx=$psysx+1;

  }

//len pre metalco a alchem uprav splatnost pri faktoringovych polozkach
if( $fir_fico == 44551142 ) { $metalco=1; }
if ( $_SERVER['SERVER_NAME'] == "www.omsucto.sk" ) { $metalco=1; }
if( $metalco == 1 OR $alchem == 1 )
          {
//echo "metalco";
$dsqlt = "UPDATE F$kli_vxcf"."_prsaldo$kli_uzid,F$kli_vxcf"."_uctfktspl ".
" SET das=fspl, hod=-uhr, uhr=0 ".
" WHERE drupoh = 14 AND F$kli_vxcf"."_prsaldo$kli_uzid.dok = F$kli_vxcf"."_uctfktspl.fdok  ".
" AND F$kli_vxcf"."_prsaldo$kli_uzid.ico = F$kli_vxcf"."_uctfktspl.fico  ".
" AND F$kli_vxcf"."_prsaldo$kli_uzid.fak = F$kli_vxcf"."_uctfktspl.ffak  ";
$dsql = mysql_query("$dsqlt");

          }
//koniec len pre metalco uprav splatnost pri faktoringovych polozkach

//vseobecne nepenazne do salda
if( $kli_vduj == 9 ) 
   { 

//ak je ucm 311 alebo 321
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,ucm,ucd,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_uctvsdp.dok,F$kli_vxcf"."_uctvsdp.ico,fak,".
"txp,'','',0,0,0,-(F$kli_vxcf"."_uctvsdp.hod),F$kli_vxcf"."_uctvsdp.hod,dat".
" FROM F$kli_vxcf"."_uctvsdp,F$kli_vxcf"."_uctvsdh".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND fak != 0 AND F$kli_vxcf"."_uctvsdp.ico != 0 ".
" AND ( LEFT(ucm,3) = 311 OR LEFT(ucm,3) = 321 ) ";
$dsql = mysql_query("$dsqlt");

//ak je ucd 311 alebo 321
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT $psys,ucd,ucm,ume,'0000-00-00','0000-00-00','0000-00-00',F$kli_vxcf"."_uctvsdp.dok,F$kli_vxcf"."_uctvsdp.ico,fak,".
"txp,'','',0,0,0,F$kli_vxcf"."_uctvsdp.hod,-(F$kli_vxcf"."_uctvsdp.hod),dat".
" FROM F$kli_vxcf"."_uctvsdp,F$kli_vxcf"."_uctvsdh".
" WHERE F$kli_vxcf"."_uctvsdp.dok=F$kli_vxcf"."_uctvsdh.dok AND fak != 0 AND F$kli_vxcf"."_uctvsdp.ico != 0 ".
" AND ( LEFT(ucd,3) = 311 OR LEFT(ucd,3) = 321 )";
$dsql = mysql_query("$dsqlt");

   }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT 24,ucd,0,ume,'0000-00-00','0000-00-00','0000-00-00',dok,ico,fak,".
"pop,'','',0,0,0,hod,-(hod),dat".
" FROM F$kli_vxcf"."_uctsklsaldo".
" WHERE $podmucd ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT 24,ucm,0,ume,'0000-00-00','0000-00-00','0000-00-00',dok,ico,fak,".
"pop,'','',0,0,0,-(hod),hod,dat".
" FROM F$kli_vxcf"."_uctsklsaldo".
" WHERE $podmucm ";
$dsql = mysql_query("$dsqlt");

if( $fir_allx11 > 0 AND $kli_vrok >= 2010 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT 27,ucd,0,ume,'0000-00-00','0000-00-00','0000-00-00',dok,ico,fak,".
"pop,'','',0,0,0,hod,-(hod),dat".
" FROM F$kli_vxcf"."_uctuhradpoc".
" WHERE $podmucd ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT 27,ucm,0,ume,'0000-00-00','0000-00-00','0000-00-00',dok,ico,fak,".
"pop,'','',0,0,0,-(hod),hod,dat".
" FROM F$kli_vxcf"."_uctuhradpoc".
" WHERE $podmucm ";
$dsql = mysql_query("$dsqlt");

}

if( $aj37 == 1 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT 27,ucd,0,ume,'0000-00-00','0000-00-00','0000-00-00',dok,ico,fak,".
"pop,'','',0,0,0,hod,-(hod),dat".
" FROM F$kli_vxcf"."_uctmzd".
" WHERE $podmucd ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldo$kli_uzid".
" SELECT 27,ucm,0,ume,'0000-00-00','0000-00-00','0000-00-00',dok,ico,fak,".
"pop,'','',0,0,0,-(hod),hod,dat".
" FROM F$kli_vxcf"."_uctmzd".
" WHERE $podmucm ";
$dsql = mysql_query("$dsqlt");

}

//////////////////////////AK MLYN ZAHORIE ZRUS ANALYTIKU A DAJ 31100
if(!isset($rusan)) $rusan = 0;
if( $fir_fico == "44537018" AND $rusan == 1 AND $kli_vrok < 2010 )
{
//echo "opravim";
$sqtoz = "UPDATE F$kli_vxcf"."_prsaldo$kli_uzid SET uce=LEFT(uce,3)*100 WHERE uce > 0 ";
$oznac = mysql_query("$sqtoz");
}
//////////////////////////KONIEC UPRAVY MLYN ZAHORIE

//alchem nechce 326ku
if( $alchem == 1 )
  {
$sqtoz = "DELETE FROM F$kli_vxcf"."_prsaldo$kli_uzid WHERE LEFT(uce,3) = 326 ";
$oznac = mysql_query("$sqtoz");

  }


//pri dodavatelskych zmen znamienka hod,uhr,zos 

$sqtoz = "UPDATE F$kli_vxcf"."_prsaldo$kli_uzid,F$kli_vxcf"."_ddod".
" SET hod=-hod, uhr=-uhr, zos=-zos ".
" WHERE F$kli_vxcf"."_prsaldo$kli_uzid.uce=F$kli_vxcf"."_ddod.ddod ";

$oznac = mysql_query("$sqtoz");


//hodnota uhradena pre jednoduche
if( $kli_vduj == 9 ) 
   { 
$sqtoz = "UPDATE F$kli_vxcf"."_prsaldo$kli_uzid".
" SET hdu=uhr ".
" WHERE fak != 0 AND drupoh > 10 AND LEFT(puc,3) = 343";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
   }

//daj prec ucet 563,663 ico=0 a fak=0
$sqtoz = "DELETE FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE fak = 0 AND ico = 0 AND drupoh = 14";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//echo "robim";
//exit;

//vsetko aktualny stav prsaldoico,prsaldoicofak

$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoico$kli_uzid".
" SELECT drupoh,uce,puc,ume,dat,dat,dat,dok,ico,fak,".
"poz,'','',SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),dau".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce > 0 ".
" GROUP BY uce,ico";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_prsaldoicofak$kli_uzid".
" SELECT drupoh,uce,puc,ume,MAX(dat),MAX(das),MAX(daz),dok,ico,fak,".
"poz,MAX(ksy),MAX(ssy),SUM(hdp),SUM(hdu),SUM(hod),SUM(uhr),SUM(zos),MAX(dau)".
" FROM F$kli_vxcf"."_prsaldo$kli_uzid".
" WHERE uce > 0 ".
" GROUP BY uce,ico,fak";
$dsql = mysql_query("$dsqlt");

//exit;

$sqlt = <<<saldo
(
   drx         VARCHAR(10),
   idx         INT(4),
   datm        TIMESTAMP(14)
);
saldo;

$sql = "CREATE TABLE F$kli_vxcf"."_uctsaldo_ok$kli_uzid".$sqlt;
$urob = mysql_query("$sql");

$sql = "CREATE TABLE F$kli_vxcf"."_uctsaldo_uhr$kli_uzid".$sqlt;
$urob = mysql_query("$sql");

//exit;
                }
?>