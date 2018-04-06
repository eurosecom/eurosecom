<!doctype html>
<HTML>
<?php
//celkovy zaciatok FIN 112 rovnakÈ aj pre rok 2018
do
{
$sys = 'UCT';
$urov = 3000;
$copern = $_REQUEST['copern'];

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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//.jpg podklad
if ( $kli_vrok < 2018 ) {
$jpg_cesta="../dokumenty/statistika2016/fin112/fin1-12_v16";
                        }
if ( $kli_vrok >= 2018 ) {
$jpg_cesta="../dokumenty/tlacivo2018/fin1-12/fin1-12_v18";
                        }
$jpg_popis="FinanËn˝ v˝kaz o prÌjmoch, v˝davkoch a finanËn˝ch oper·ci·ch FIN 1-12 za rok ".$kli_vrok;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=9999;

if ( $cislo_oc == 0 ) $cislo_oc=1;
if ( $cislo_oc == 1 ) { $datum="31.01.".$kli_vrok; $mesiac="01"; $kli_vume="1.".$kli_vrok; }
if ( $cislo_oc == 2 ) { $datum="28.02.".$kli_vrok; $mesiac="02"; $kli_vume="2.".$kli_vrok; }
if ( $cislo_oc == 3 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if ( $cislo_oc == 4 ) { $datum="30.04.".$kli_vrok; $mesiac="04"; $kli_vume="4.".$kli_vrok; }
if ( $cislo_oc == 5 ) { $datum="31.05.".$kli_vrok; $mesiac="05"; $kli_vume="5.".$kli_vrok; }
if ( $cislo_oc == 6 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if ( $cislo_oc == 7 ) { $datum="31.07.".$kli_vrok; $mesiac="07"; $kli_vume="7.".$kli_vrok; }
if ( $cislo_oc == 8 ) { $datum="31.08.".$kli_vrok; $mesiac="08"; $kli_vume="8.".$kli_vrok; }
if ( $cislo_oc == 9 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if ( $cislo_oc == 10 ) { $datum="31.10.".$kli_vrok; $mesiac="10"; $kli_vume="10.".$kli_vrok; }
if ( $cislo_oc == 11 ) { $datum="30.11.".$kli_vrok; $mesiac="11"; $kli_vume="11.".$kli_vrok; }
if ( $cislo_oc == 12 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }



//nacitanie minuleho roka do DMV
    if ( $copern == 3155 ) { ?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù rozpoËet z firmy minulÈho roka ? ") )
         { window.close() }
else
         { location.href='vykaz_fin112_2016.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>' }
</script>
<?php                      }

    if ( $copern == 3156 )
    {
$h_ycf=0;
if ( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");


$uprtxt = "DROP TABLE F$kli_vxcf"."_uctvykaz_fin104x".$kli_uzid." ";
$upravene = mysql_query("$uprtxt");
$uprtxt = "CREATE TABLE F$kli_vxcf"."_uctvykaz_fin104x".$kli_uzid." SELECT * FROM ".$databaza."F$h_ycf"."_uctvykaz_fin104 WHERE druh < 3 ";
$upravene = mysql_query("$uprtxt");


$uprtxt = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin104 ";
$upravene = mysql_query("$uprtxt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104x".$kli_uzid." WHERE druh < 3 ORDER BY druh,cpl ";
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
//echo $uprtxt."<br />";

$i=0;
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 ( oc, druh, zdroj, oddiel, polozka, schvaleny, zmeneny, skutocnost ) VALUES ".
" ( '$hlavicka->oc', '$hlavicka->druh', '$hlavicka->zdroj', '$hlavicka->oddiel', '$hlavicka->polozka', '$hlavicka->schvaleny', ".
" '$hlavicka->zmeneny', '$hlavicka->skutocnost' ) ";
$upravene = mysql_query("$uprtxt");

//echo $uprtxt."<br />";

}
$i=$i+1;
  }

if( $kli_vrok == 2016 )
  {

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET oc = 1 ";
//$upravene = mysql_query("$uprtxt");


  }

$uprtxt = "DROP TABLE F$kli_vxcf"."_uctvykaz_fin104x".$kli_uzid." ";
$upravene = mysql_query("$uprtxt");

$copern=20;
$strana=2;
//exit;
//koniec nacitania rozpoctu minuleho roka
    }


$vsetkyprepocty=0;
//nacitaj data
if ( $copern == 26 )
    {

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcuobrats
(
   psys         INT,
   uro          INT(8),
   cpl          int not null auto_increment,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT(8),
   uce          VARCHAR(10),
   ur1          INT(10),
   puc          VARCHAR(10),
   ucm          VARCHAR(10),
   ucd          VARCHAR(10),
   rdp          INT(2),
   ico          INT(10),
   fak          INT(10),
   str          INT,
   zak          INT,
   hod          DECIMAL(10,2),
   mdt          DECIMAL(10,2),
   dal          DECIMAL(10,2),
   zos          DECIMAL(10,2),
   pop          VARCHAR(80),
   pox          INT(10),
   pmd          DECIMAL(10,2),
   pdl          DECIMAL(10,2),
   bmd          DECIMAL(10,2),
   bdl          DECIMAL(10,2),
   omd          DECIMAL(10,2),
   odl          DECIMAL(10,2),
   zmd          DECIMAL(10,2),
   zdl          DECIMAL(10,2),
   podnk        DECIMAL(10,0) DEFAULT 0,
   uhrad        VARCHAR(10),
   zdroj        VARCHAR(10),
   poloz        DECIMAL(10,0) DEFAULT 0,
   rpje         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
prcuobrats;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$umex=$kli_vume;

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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,F$kli_vxcf"."_$uctovanie.dok,ucm,1,ucd,ucm,ucd,rdp,F$kli_vxcf"."_$uctovanie.ico,F$kli_vxcf"."_$uctovanie.fak,".
"F$kli_vxcf"."_$uctovanie.str,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,".
"0,0,F$kli_vxcf"."_$doklad.txp,1,0,0,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok AND ( ucm > 0 OR ucd > 0 ) AND ume <= $umex ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid"." SELECT".
" $psys,1,0,ume,dat,dok,ucm,1,ucd,ucm,ucd,rdp,ico,fak,".
"str,zak,hod,hod,".
"0,0,pop,1,0,0,0,0,0,0,0,0,0,0,0,0,0".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ume <= $umex ";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }



//tu daj prec madat 3kovych uctov ale nie 346 zuctovanie dotacii proti 691
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcuobratsy$kli_uzid WHERE LEFT(ucm,1) = 3 AND LEFT(ucd,1) != 5 AND LEFT(ucd,1) != 6 ";
$oznac = mysql_query("$sqtoz");


//vloz stranu dal
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobratsy$kli_uzid"." SELECT".
" psys,1,0,ume,dat,dok,ucd,1,ucm,ucm,ucd,rdp,ico,fak,str,zak,-(hod),0,hod,0,pop,pox,0,0,0,0,0,0,0,0,podnk,uhrad,zdroj,poloz,rpje".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE ume <= $umex AND psys > 0 ";
" ";
$dsql = mysql_query("$dsqlt");


if( $_SERVER['SERVER_NAME'] == "www.eurodpsgbely.sk" )
{
$dfzdroj=41;
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcuobratsy$kli_uzid WHERE LEFT(ucm,5) = 37810 ";
$oznac = mysql_query("$sqtoz");
}



if( $_SERVER['SERVER_NAME'] == "www.eurodpsgbely.sk" )
{

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zdroj=46 WHERE uce = 66510 ";
$oznac = mysql_query("$sqtoz");
}


$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET rpje=1 WHERE poloz > 0 ";
$oznac = mysql_query("$sqtoz");

//oznac podnikatelsku cinnost podla zak
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET pdnk=0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_zak ".
" SET podnk=F$kli_vxcf"."_zak.uzk ".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.str = F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_prcuobratsy$kli_uzid.zak = F$kli_vxcf"."_zak.zak";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET podnk=2 WHERE LEFT(uce,3) = 551 ";
$oznac = mysql_query("$sqtoz");
}

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET podnk=0 WHERE podnk != 2 ";
$oznac = mysql_query("$sqtoz");


//sumar za podnk,ucty,dok,zdroj,polozku
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" psys,1,0,ume,dat,0,uce,999,puc,ucm,ucd,rdp,1,fak,str,zak,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl),podnk,uhrad,zdroj,poloz,rpje".
" FROM F$kli_vxcf"."_prcuobratsy$kli_uzid".
" WHERE cpl >= 0 AND ".
" ( LEFT(uce,1) = 3 OR LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 OR LEFT(uce,1) = 8 OR LEFT(uce,1) = 9 ) ".
" GROUP BY podnk,uce,dok,zdroj,poloz ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//nastav crv podla uce,3
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid,F$kli_vxcf"."_crf104nuj_no".
" SET poloz=F$kli_vxcf"."_crf104nuj_no.crs".
" WHERE LEFT(F$kli_vxcf"."_prcuobrats$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_crf104nuj_no.uce,3) AND F$kli_vxcf"."_crf104nuj_no.uce < 999 AND rpje = 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//nastav crv podla uce
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid,F$kli_vxcf"."_crf104nuj_no".
" SET poloz=F$kli_vxcf"."_crf104nuj_no.crs".
" WHERE F$kli_vxcf"."_prcuobrats$kli_uzid.uce = F$kli_vxcf"."_crf104nuj_no.uce AND rpje = 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vymaz 3kove ucty ak nemaju polozku
$sqtoz = "DELETE FROM F$kli_vxcf"."_prcuobrats$kli_uzid WHERE LEFT(uce,1) = 3 AND poloz = 0 ";
$oznac = mysql_query("$sqtoz");

//exit;

//psys  uro  cpl  ume  dat  dok  uce  ur1  puc  ucm  ucd  rdp  ico  fak  str  zak  hod  mdt  dal  zos  pop  pox
//pmd  pdl  bmd  bdl  omd  odl  zmd  zdl  uhrad  zdroj  poloz  rpje
//tu nastav presun zo zdroj1 a polozka1 na zdroj2 a polozka2 ak uce, dok, hod == 0

//sem este presun z zdroja,polozky na novy zdroj,polozku opravene vyssie
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" 9,1,0,'$kli_vume','0000-00-00',1,'0',1,'0','0','0',0,0,0,0,0,".
"-(hox),0,0,0,'',1,".
"0,0,0,0,0,0,0,0,podnk,'',crz,rpz,0".
" FROM F$kli_vxcf"."_crf104nuj_nozdrdok ".
" WHERE crz > 0 AND rpz > 0 AND crs > 0 AND rpx > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" 9,1,0,'$kli_vume','0000-00-00',1,'0',1,'0','0','0',0,0,0,0,0,".
"hox,0,0,0,'',1,".
"0,0,0,0,0,0,0,0,podnk,'',crs,rpx,0".
" FROM F$kli_vxcf"."_crf104nuj_nozdrdok ".
" WHERE crz > 0 AND rpz > 0 AND crs > 0 AND rpx > 0 ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;

$zdroj3pol=1;
if( $zdroj3pol == 1 )
    {

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=41 WHERE poloz > 0 ";

if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND $fir_fico == 37990845 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=46 WHERE poloz > 0 ";
}

if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND ( $kli_vxcf == 909 OR $kli_vxcf == 509 OR $kli_vxcf == 609 OR $kli_vxcf == 709 OR $kli_vxcf == 809 ) )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=46 WHERE poloz > 0 ";
}

if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=41 WHERE poloz > 0 ";
}

if( $_SERVER['SERVER_NAME'] == "www.mpsbm.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=71 WHERE poloz > 0 ";
}

$oznac = mysql_query("$sqtoz");


if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=111 WHERE poloz = 610 AND str = 24 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=111 WHERE poloz = 620 AND str = 24 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=111 WHERE poloz = 641  ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=111 WHERE poloz = 310  ";
$oznac = mysql_query("$sqtoz");

}

    }

//kontrola na generovanie

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobrats$kli_uzid WHERE poloz = 0 GROUP BY uce";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if( $pol > 0 ) {
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); echo "Nastavte rozpoËtov˙ poloûku pre ˙Ëet ".$polozka->uce."<br />"; }
$i=$i+1;                   }
exit;
               }

//exit;
//koniec kontrola na generovanie

//sumar za rozp.polozky a zdroj
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuobrats$kli_uzid "." SELECT".
" 999,1,0,ume,dat,dok,uce,999,puc,ucm,ucd,rdp,1,fak,str,0,SUM(hod),SUM(mdt),SUM(dal),SUM(mdt-dal),pop,1,".
"SUM(pmd),SUM(pdl),SUM(bmd),SUM(bdl),SUM(omd),SUM(odl),SUM(zmd),SUM(zdl),podnk,uhrad,zdroj,poloz,rpje".
" FROM F$kli_vxcf"."_prcuobrats$kli_uzid".
" WHERE cpl >= 0 AND poloz > 0 ".
" GROUP BY podnk,poloz,zdroj ".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcuobrats$kli_uzid "." WHERE psys != 999 ";
$dsql = mysql_query("$dsqlt");

//exit;

//prenes do rozpoctu ale opacne nacitaj schvaleny a po zmenach do tohoto a zober skutocne z tohoto
//cpl  px12  oc  druh  okres  obec  daz  kor  prx  uce  ucm  ucd  hod  mdt  dal
//program  zdroj  oddiel  xoddiel  skupina  trieda  podtrieda  polozka  xpolozka  podpolozka  nazov  schvaleny  zmeneny  skutocnost  ico

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,$dfzdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = 41 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,41,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = $dfzdroj ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,71,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = $dfzdroj ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,111,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = $dfzdroj ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,(druh+2),okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"'','',oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE druh <= 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,1,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,sum(schvaleny),sum(zmeneny),sum(predpoklad),0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" GROUP BY druh,zdroj,polozka ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE px12 = 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;

$nostp = $_REQUEST['nostp'];
$nostp=trim($nostp);

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET px12=0, oddiel='10.7.0.2' ";
$oznac = mysql_query("$sqtoz");

if( $nostp != "" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET px12=0, oddiel='$nostp' ";
$oznac = mysql_query("$sqtoz");
}

if( $_SERVER['SERVER_NAME'] == "www.mpsbm.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET px12=0, oddiel='04.1.1' ";
$oznac = mysql_query("$sqtoz");
}

if( $_SERVER['SERVER_NAME'] == "www.eurodpsgbely.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET px12=0, oddiel='10.1.2.2' ";
$oznac = mysql_query("$sqtoz");
}

if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" )
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET px12=0, program='9.2', oddiel='0.8.2.0' ";
$oznac = mysql_query("$sqtoz");
}

if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND ( $kli_vxcf == 909 OR $kli_vxcf == 509 OR $kli_vxcf == 609 OR $kli_vxcf == 709 OR $kli_vxcf == 809 ))
{
$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET px12=0, program='', oddiel='0.7.2.2' ";
$oznac = mysql_query("$sqtoz");
}

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104,F$kli_vxcf"."_prcuobrats$kli_uzid".
" SET F$kli_vxcf"."_uctvykaz_fin104.skutocnost=F$kli_vxcf"."_prcuobrats$kli_uzid.hod, zak=7777 ".
" WHERE F$kli_vxcf"."_uctvykaz_fin104.polozka = F$kli_vxcf"."_prcuobrats$kli_uzid".".poloz ".
" AND F$kli_vxcf"."_uctvykaz_fin104.zdroj = F$kli_vxcf"."_prcuobrats$kli_uzid".".zdroj ".
" AND F$kli_vxcf"."_uctvykaz_fin104.druh <= 2 AND F$kli_vxcf"."_prcuobrats$kli_uzid".".podnk = 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104,F$kli_vxcf"."_prcuobrats$kli_uzid".
" SET F$kli_vxcf"."_uctvykaz_fin104.skutocnost=F$kli_vxcf"."_prcuobrats$kli_uzid.hod, zak=7777 ".
" WHERE F$kli_vxcf"."_uctvykaz_fin104.polozka = F$kli_vxcf"."_prcuobrats$kli_uzid".".poloz ".
" AND F$kli_vxcf"."_uctvykaz_fin104.druh > 2 AND F$kli_vxcf"."_prcuobrats$kli_uzid".".podnk = 2 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET skutocnost=-skutocnost WHERE druh = 1 OR druh = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE schvaleny = 0 AND zmeneny = 0 AND skutocnost = 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//kontrola na pritomnost polozky v rozpocte

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobrats$kli_uzid WHERE zak != 7777 AND hod != 0 ";
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
if( $pol > 0 ) {
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i))
{ $polozka=mysql_fetch_object($sql); echo "RozpoËtov· poloûka zdroj=".$polozka->zdroj." poloûka=".$polozka->poloz." nie je v rozpoËte ! <br />"; }
$i=$i+1;                   }
exit;
               }

//exit;
//koniec kontrola na pritomnost polozky v rozpocte

$sqtoz = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET oc = $cislo_oc ";
$oznac = mysql_query("$sqtoz");


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$copern=20;
$strana=2;
    }
//koniec nacitaj data

//vymaz polozku
if ( $copern == 316 )
    {
$cislo_cpl = 1*$_REQUEST['cislo_cpl'];

$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE cpl = $cislo_cpl";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $meno=$riaddok->meno;

$zdroj = $riaddok->zdroj;
$oddiel = $riaddok->oddiel;
$polozka = $riaddok->polozka;
$schvaleny = 1*$riaddok->schvaleny;
$zmeneny = 1*$riaddok->zmeneny;
$predpoklad = 1*$riaddok->predpoklad;
$skutocnost = 1*$riaddok->skutocnost;
  }


$sqtoz = "DELETE FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE cpl = $cislo_cpl";
$oznac = mysql_query("$sqtoz");
$copern=20;

    }
//koniec vymaz polozku


// zapis polozku
if ( $copern == 23 )
    {
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);
$zdroj = strip_tags($_REQUEST['zdroj']);
$oddiel = strip_tags($_REQUEST['oddiel']);


if( $strana == 1 )                     {
$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET daz='$daz_sql' ";
$upravene = mysql_query("$uprtxt");
                                       }

if ( $strana == 2 OR $strana == 4 )    {


$polozka = strip_tags($_REQUEST['polozka']);
$schvaleny = 1*$_REQUEST['schvaleny'];
$zmeneny = 1*$_REQUEST['zmeneny'];
$predpoklad = 1*$_REQUEST['predpoklad'];
$skutocnost = 1*$_REQUEST['skutocnost'];
$druh=$strana-1;

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104set SET zdroj='$zdroj' ";
if( $zdroj > 0 ) { $upravene = mysql_query("$uprtxt"); }


$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 (oc,druh,zdroj,polozka,schvaleny,zmeneny,predpoklad,skutocnost) VALUES ".
" (  '$cislo_oc', '$druh', '$zdroj', '$polozka', '$schvaleny', '$zmeneny', '$predpoklad', '$skutocnost' ) ";

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


                       }



if ( $strana == 3 OR $strana == 5 )    {

$polozka = strip_tags($_REQUEST['polozka']);
$schvaleny = 1*$_REQUEST['schvaleny'];
$zmeneny = 1*$_REQUEST['zmeneny'];
$predpoklad = 1*$_REQUEST['predpoklad'];
$skutocnost = 1*$_REQUEST['skutocnost'];

$druh=$strana-1;

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104set SET zdroj='$zdroj'  ";
if( $zdroj > 0 ) { $upravene = mysql_query("$uprtxt"); }

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104set SET oddiel='$oddiel' ";
if( $oddiel > 0 ) { $upravene = mysql_query("$uprtxt"); }

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 (oc,druh,zdroj,oddiel,polozka,schvaleny,zmeneny,predpoklad,skutocnost) VALUES ".
" (  '$cislo_oc', '$druh', '$zdroj', '$oddiel', '$polozka', '$schvaleny', '$zmeneny', '$predpoklad', '$skutocnost' ) ";

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");


                       }


$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu polozky


//prac.subor a subor
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sql = "SELECT px12 FROM F".$kli_vxcf."_uctvykaz_fin104";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin104';
$vysledok = mysql_query("$sqlt");


$pocdes="10,2";
$sqlt = <<<mzdprc
(
   cpl         int not null auto_increment,
   px12         DECIMAL($pocdes) DEFAULT 0,
   oc           INT(7) DEFAULT 0,
   druh         DECIMAL(10,0) DEFAULT 0,
   okres        VARCHAR(11) NOT NULL,
   obec         VARCHAR(11) NOT NULL,
   daz          DATE NOT NULL,
   kor          INT DEFAULT 0,
   prx          INT DEFAULT 0,
   uce          VARCHAR(11) NOT NULL,
   ucm          VARCHAR(11) NOT NULL,
   ucd          VARCHAR(11) NOT NULL,
   hod          DECIMAL($pocdes) DEFAULT 0,
   mdt          DECIMAL($pocdes) DEFAULT 0,
   dal          DECIMAL($pocdes) DEFAULT 0,
   program      VARCHAR(11) NOT NULL,
   zdroj        VARCHAR(11) NOT NULL,
   oddiel       VARCHAR(11) NOT NULL,
   skupina      VARCHAR(11) NOT NULL,
   trieda       VARCHAR(11) NOT NULL,
   podtrieda    VARCHAR(11) NOT NULL,
   polozka      VARCHAR(11) NOT NULL,
   podpolozka   VARCHAR(11) NOT NULL,
   nazov        VARCHAR(80) NOT NULL,
   schvaleny    DECIMAL($pocdes) DEFAULT 0,
   zmeneny      DECIMAL($pocdes) DEFAULT 0,
   skutocnost   DECIMAL($pocdes) DEFAULT 0,
   ico          INT DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin104'.$sqlt;
$vytvor = mysql_query("$vsql");

}
//koniec create
$sql = "SELECT xpolozka FROM F".$kli_vxcf."_uctvykaz_fin104";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104 ADD xpolozka VARCHAR(11) NOT NULL AFTER polozka";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104 ADD xoddiel VARCHAR(11) NOT NULL AFTER oddiel";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT predpoklad FROM F".$kli_vxcf."_uctvykaz_fin104";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104 ADD predpoklad DECIMAL(10,2) DEFAULT 0 AFTER zmeneny";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT px12 FROM F".$kli_vxcf."_uctvykaz_fin104set";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin104set';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   cpl         int not null auto_increment,
   px12         DECIMAL(10,0) DEFAULT 0,
   program      VARCHAR(11) NOT NULL,
   zdroj        VARCHAR(11) NOT NULL,
   oddiel       VARCHAR(11) NOT NULL,
   skupina      VARCHAR(11) NOT NULL,
   trieda       VARCHAR(11) NOT NULL,
   ico          INT DEFAULT 0,
   PRIMARY KEY(cpl)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin104set '.$sqlt;
$vytvor = mysql_query("$vsql");

$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104set ( zdroj, oddiel ) VALUES (  '46', '0.7.2.2' ) ";
$upravene = mysql_query("$uprtxt");

}

//koniec vytvorenie


//vypocty
if ( $copern == 10 OR $copern == 20 )
{

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET program='', zdroj='' WHERE druh = 3 OR druh = 4 ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET ".
" xpolozka=SUBSTRING(polozka,1,3), podpolozka=SUBSTRING(polozka,4,3), ".
" xoddiel=SUBSTRING(oddiel,1,2), skupina=SUBSTRING(oddiel,4,1), trieda=SUBSTRING(oddiel,6,1), podtrieda=SUBSTRING(oddiel,8,1) ".
" WHERE oc >= 0 ";
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

}
//koniec vypocty


if( $strana == 9999 ) $strana=1;

//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104  ";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$daz_sk = SkDatum($fir_riadok->daz);

mysql_free_result($fir_vysledok);


$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104set  ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);


$zdrojx = $fir_riadok->zdroj;
$oddielx = $fir_riadok->oddiel;


mysql_free_result($fir_vysledok);


if( $schvaleny == '' ) { $schvaleny="0.00"; }
if( $zmeneny == '' ) { $zmeneny="0.00"; }
if( $predpoklad == '' ) { $predpoklad="0.00"; }
if( $skutocnost == '' ) { $skutocnost="0.00"; }

    }
//koniec nacitania

//6-miestne ico
$fir_ficox=$fir_fico; if ( $fir_ficox < 999999 ) { $fir_ficox="00".$fir_ficox; }

//skrateny datum k
$skutku=substr($datum,0,6);
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>V˝kaz FIN 1-12</title>
<style type="text/css">
form input[type=text] {
  height: 20px;
  line-height: 20px;
  padding-left: 4px;
  border: 1px solid #39f;
  font-size: 14px;
}
div.input-echo {
  position: absolute;
  font-size: 16px;
  background-color: #fff;
  font-weight: bold;
}
div.form-background-wide {
  width: 1250px;
  background-color: #fff;
  clear: left;
}
div.form-content-wide {
  width: 1150px;
  margin: 0 auto;
  padding: 20px 0 30px 0;
}
h2.form-header {
  height: 23px;
  font-size: 15px;
  background-color: ;
}
.fixne-menu {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 1;
  padding: 6px 0;
  background-color: #ddd;
}
table.table-heading {
  width: 1150px;
  background-color: #ddd;
  height: 24px;
  line-height: 24px;
  text-align: center;
  font-size: 11px;
  margin: 0 auto;
}
table.zoznam tbody tr:hover {
  background-color: #eee;
}
table.zoznam tbody td {
  font-size: 12px;
  line-height: 20px;
}
table.zoznam tfoot th {
  height: 24px;
  line-height: 24px;
  font-size: 11px;
  background-color: #ddd;
}
table.zoznam tfoot td {
  height: 24px;
  padding-top: 6px;
}
table.zoznam tfoot td input[type=text] {
  position: static;
}
input.btn-rowsave {
  height: 24px;
  cursor: pointer;
  position: relative;
  top: -1px;
}
tr.zero-line > td { /* urcenie sirky stlpcov */
  height: 0;
}
img.btn-cancel {
  width: 14px;
  height: 14px;
  position: relative;
  top: 3px;
  cursor: pointer;
  opacity: 0.7;
}
img.btn-cancel:hover {
  opacity: 1;
}
span:after, a:before, a:after {
  display: inline-block;
  content: '';
  background-repeat: no-repeat;
}
a.btn-down-x26 { /* tlacidlo nacitaj min.rok */
  display: block;
  line-height: 26px;
  padding: 0 9px 0 7px;
  font-size: 11px;
  font-weight: bold;
  color: #fff;
  background-color: #39f;
  -moz-border-radius: 2px;
  -webkit-border-radius: 2px;
  border-radius: 2px;
  position: relative;
  top: -7px;
  -moz-opacity: 0.7;
  -khtml-opacity: 0.7;
  opacity: 0.7;
}
a.btn-down-x26:before {
  background-image: url(../obr/ikony/download6_white_x16.png);
  width: 16px;
  height: 16px;
  vertical-align: -4px;
  margin-right: 3px;
}
a.btn-down-x26:hover {
  -moz-opacity: 1;
  -khtml-opacity: 1;
  opacity: 1;
}
img.btn-form-tool {
  margin: 0 8px;
}
.btn-text {
  border: 0;
  box-sizing: border-box;
  color: #39f;
  cursor: pointer;
  display: inline-block;
  font-size: 14px;
  font-weight: 500;
  height: 28px;
  line-height: 28px;
  padding: 0 6px;
  text-align: center;
  text-transform: uppercase;
  /*vertical-align: middle;*/
  background-color: transparent;
  border-radius: 2px;
}
.btn-text:hover {
  background-color: rgba(158,158,158,.2);
}
</style>
<script type="text/javascript">
<?php
//uprava
  if ( $copern == 20 )
  {
?>


function ProgramEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.zdroj.focus();
        document.forms.formv1.zdroj.select();
              }
                }

  function ZdrojEnter(e)
  {
   var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy
   if ( k == 13 ) {
<?php if ( $strana == 2 ) { ?>
        document.forms.formv1.polozka.focus();
        document.forms.formv1.polozka.select();
<?php                     } ?>
<?php if ( $strana == 3 ) { ?>
        document.forms.formv1.oddiel.focus();
        document.forms.formv1.oddiel.select();
<?php                     } ?>
                  }
  }

function OddielEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.polozka.focus();
        document.forms.formv1.polozka.select();
              }
                }

function PolozkaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        <?php if ( $strana == 2 ) { ?>
        document.forms.formv1.schvaleny.focus();
        document.forms.formv1.schvaleny.select();
        <?php                     } ?>
        <?php if ( $strana == 3 ) { ?>
        document.forms.formv1.schvaleny.focus();
        document.forms.formv1.schvaleny.select();
        <?php                     } ?>
        <?php if ( $strana == 4 ) { ?>
        document.forms.formv1.skutocnost.focus();
        document.forms.formv1.skutocnost.select();
        <?php                     } ?>
        <?php if ( $strana == 5 ) { ?>
        document.forms.formv1.skutocnost.focus();
        document.forms.formv1.skutocnost.select();
        <?php                     } ?>

              }
                }

function SchvalenyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.zmeneny.value=document.formv1.schvaleny.value;
        document.forms.formv1.zmeneny.focus();
        document.forms.formv1.zmeneny.select();
              }
                }

function ZmenenyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.predpoklad.focus();
        document.forms.formv1.predpoklad.select();
              }
                }

function PredpokladEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.skutocnost.focus();
        document.forms.formv1.skutocnost.select();
              }
                }

function SkutocnostEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; //kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

<?php if ( $strana == 2 OR $strana == 3 )           { ?>
    if ( document.formv1.zdroj.value == '' ) okvstup=0;
    if ( document.formv1.zdroj.value == 0 ) okvstup=0;
<?php                                               } ?>
    if ( document.formv1.polozka.value == '' ) okvstup=0;
    if ( document.formv1.polozka.value == 0 ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true);  document.forms.formv1.submit(); return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

              }
                }


    function ObnovUI()
    {

<?php if ( $strana == 1 )                           { ?>

<?php if( $zdroj == '' ) { $zdroj=$zdrojx; } ?>

document.formv1.daz.value = '<?php echo $daz_sk;?>';



<?php                                               } ?>

<?php if ( $strana == 2 )                           { ?>

<?php if( $zdroj == '' ) { $zdroj=$zdrojx; } ?>

document.formv1.zdroj.value = '<?php echo $zdroj;?>';
document.formv1.polozka.value = '<?php echo $polozka;?>';
document.formv1.schvaleny.value = '<?php echo $schvaleny;?>';
document.formv1.zmeneny.value = '<?php echo $zmeneny;?>';
document.formv1.predpoklad.value = '<?php echo $predpoklad;?>';
document.formv1.skutocnost.value = '<?php echo $skutocnost;?>';

        document.formv1.uloz.disabled = true;
        document.forms.formv1.zdroj.focus();
        document.forms.formv1.zdroj.select();


<?php                                               } ?>



<?php if ( $strana == 3 )                           { ?>

<?php if( $zdroj == '' ) { $zdroj=$zdrojx; } ?>
<?php if( $oddiel == '' ) { $oddiel=$oddielx; } ?>

document.formv1.zdroj.value = '<?php echo $zdroj;?>';
document.formv1.oddiel.value = '<?php echo $oddiel;?>';
document.formv1.polozka.value = '<?php echo $polozka;?>';
document.formv1.schvaleny.value = '<?php echo $schvaleny;?>';
document.formv1.zmeneny.value = '<?php echo $zmeneny;?>';
document.formv1.predpoklad.value = '<?php echo $predpoklad;?>';
document.formv1.skutocnost.value = '<?php echo $skutocnost;?>';

        document.formv1.uloz.disabled = true;
        document.forms.formv1.zdroj.focus();
        document.forms.formv1.zdroj.select();

<?php                                               } ?>

<?php if ( $strana == 4 )                           { ?>



document.formv1.polozka.value = '<?php echo $polozka;?>';
document.formv1.schvaleny.value = '<?php echo $schvaleny;?>';
document.formv1.zmeneny.value = '<?php echo $zmeneny;?>';
document.formv1.predpoklad.value = '<?php echo $predpoklad;?>';
document.formv1.skutocnost.value = '<?php echo $skutocnost;?>';

        document.formv1.uloz.disabled = true;
        document.forms.formv1.polozka.focus();
        document.forms.formv1.polozka.select();


<?php                                               } ?>

<?php if ( $strana == 5 )                           { ?>

<?php if( $oddiel == '' ) { $oddiel=$oddielx; } ?>

document.formv1.oddiel.value = '<?php echo $oddiel;?>';
document.formv1.polozka.value = '<?php echo $polozka;?>';
document.formv1.schvaleny.value = '<?php echo $schvaleny;?>';
document.formv1.zmeneny.value = '<?php echo $zmeneny;?>';
document.formv1.predpoklad.value = '<?php echo $predpoklad;?>';
document.formv1.skutocnost.value = '<?php echo $skutocnost;?>';

        document.formv1.uloz.disabled = true;
        document.forms.formv1.oddiel.focus();
        document.forms.formv1.oddiel.select();
<?php                                                } ?>

    }

    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.polozka.value == "" ) { okvstup=0; }
    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; return (true); }
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
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function MetodVypln()
  {
   window.open('<?php echo $jpg_cesta; ?>_vysvetlivky.pdf',
'_blank', 'width=980, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes');
  }
  function TlacVykaz()
  {
   window.open('vykaz_fin112_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999',
'_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

function DbfFin112nujpod()
                {

window.open('fin112nujpoddbf.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function CsvFin1a12()
                {

window.open('vykaz_fin112_csv.php?cislo_oc=<?php echo $cislo_oc;?>&copern=1&drupoh=1&page=1&subor=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  function Vymaz(cpl)
  {
   window.open('vykaz_fin112_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=316&drupoh=1&page=1&subor=0&strana=<?php echo $strana; ?>&cislo_cpl=' + cpl + '&xx=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }

  function CitajMinuly()
  {
   window.open('vykaz_fin112_2016.php?cislo_oc=<?php echo $cislo_oc;?>&copern=3155&drupoh=1&page=1&subor=0&strana=2&xx=1',
'_self', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
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
  <td class="header">FIN 1-12 PrÌjmy, v˝davky a finanËnÈ oper·cie za
   <span style="color:#39f;"><?php echo "$cislo_oc. mesiac";?></span>
   <img src='../obr/info.png' style="width:12px; height:12px;"
        title="EnterNext = na Ôalöiu poloûku mÙûete prejsù kl·vesou Enter">
  </td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/info_blue_icon.png" onclick="MetodVypln();" title="Vysvetlivky na vyplnenie v˝kazu" class="btn-form-tool">
<?php if ( $kli_vrok < 2018 ) { ?>
    <button type="button" onclick="DbfFin112nujpod();" title="Export do DBF" class="btn-text toright" style="position: relative; top: -4px;">DBF</button>
<?php } ?>
<?php if ( $kli_vrok >= 2017 ) { ?>
    <button type="button" onclick="CsvFin1a12();" title="Export do CSV" class="btn-text toright" style="position: relative; top: -4px;">CSV</button>
<?php } ?>
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacVykaz();" title="Zobraziù vöetky strany v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<?php
$sirka=950;
if ( $strana == 2 OR $strana == 3 OR $strana == 4 OR $strana == 5 )
{
$sirka=1250;
}
?>
<div id="content" style="width:<?php echo $sirka; ?>px; overflow:auto; padding-bottom:5px;">
<FORM name="formv1" method="post" action="../ucto/vykaz_fin112_2016.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana; ?>">
<?php
$clas1="noactive"; $clas2="noactive"; $clas3="noactive"; $clas4="noactive"; $clas5="noactive";
if ( $strana == 1 ) $clas1="active"; if ( $strana == 2 ) $clas2="active";
if ( $strana == 3 ) $clas3="active"; if ( $strana == 4 ) $clas4="active";
if ( $strana == 5 ) $clas5="active";
$source="vykaz_fin112_2016.php";
?>
<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">PrÌjmy</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas3; ?> toleft">V˝davky</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=4&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas4; ?> toleft">PrÌjmovÈ oper·cie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=5&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas5; ?> toleft">V˝davkovÈ oper·cie</a>
<?php if ( $strana == 1 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave">
<?php                     } ?>
</div>

<?php if ( $strana == 1 ) { ?>
<img src="<?php echo $jpg_cesta; ?>_str1.jpg" class="form-background"
     alt="<?php echo $jpg_popis; ?> 1.strana 265kB">

<span class="text-echo" style="top:153px; left:403px;"><?php echo $datum; ?></span>
<span class="text-echo" style="top:241px; left:141px;">x</span>
<span class="text-echo" style="top:516px; left:141px; letter-spacing:13.5px;"><?php echo $fir_ficox; ?></span>
<span class="text-echo" style="top:516px; left:342px; letter-spacing:14px;"><?php echo $mesiac; ?></span>
<span class="text-echo" style="top:516px; left:409px; letter-spacing:13.5px;"><?php echo $kli_vrok; ?></span>
<div class="input-echo" style="width:687px; top:574px; left:135px; height:40px; line-height:40px;"><?php echo $fir_fnaz; ?></div>
<div class="input-echo" style="width:687px; top:655px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_uctt02; ?></div>
<div class="input-echo" style="width:687px; top:735.5px; left:135px; height:39.5px; line-height:39.5px;"><?php echo $fir_fuli; ?></div>
<div class="input-echo" style="width:105px; top:816.5px; left:135px; height:19px; line-height:19px;"><?php echo $fir_fpsc; ?></div>
<div class="input-echo" style="width:553px; top:816.5px; left:269px; height:39.5px; line-height:39.5px;"><?php echo $fir_fmes; ?></div>
<div class="input-echo" style="width:687px; top:898px; left:135px; height:19px; line-height:19px; font-size:15px;"><?php echo $fir_fem1; ?></div>
<input type="text" name="daz" id="daz" onkeyup="CiarkaNaBodku(this);"
       style="width:80px; top:966px; left:236px; height:22px; line-height:22px; font-size:14px; padding-left:4px;"/>
<?php                     } ?>


<?php if ( $strana == 2 ) { ?>
<div class="form-background-wide">
<div class="form-content-wide">
 <h2 class="form-header toleft">»asù I. - <strong>PrÌjmy</strong></h2>
 <a href="#" onclick="CitajMinuly();" title="NaËÌtaù rozpoËet z minulÈho roka" class="toright btn-down-x26">RozpoËet minul˝ rok</a>
<div id="FixneMenu">
<table class="table-heading">
<tr>
 <th style="width:15%;">Zdroj</th>
 <th style="width:15%;">Poloûka.Podpoloûka</th>
 <th style="width:15%;">Schv·len˝ rozpoËet</th>
 <th style="width:15%;">RozpoËet po zmen·ch</th>
 <th style="width:15%;">OËak·van· skutoËnosù</th>
 <th style="width:15%;">SkutoËnosù k <?php echo $skutku; ?></th>
 <th style="width:10%;"></th>
</tr>
</table>
</div>

<table class="zoznam" style="width:100%;">
<thead>
<tr class="zero-line">
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:10%;"></td>
</tr>
</thead>
<?php
$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE oc >= 0 AND druh = 1 ORDER BY cpl ";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);
?>
<tbody>
<tr>
 <td class="center"><?php echo $rsluz->zdroj; ?></td>
 <td class="center"><?php echo $rsluz->polozka; ?></td>
 <td class="right"><?php echo $rsluz->schvaleny; ?></td>
 <td class="right"><?php echo $rsluz->zmeneny; ?></td>
 <td class="right"><?php echo $rsluz->predpoklad; ?></td>
 <td class="right"><?php echo $rsluz->skutocnost; ?></td>
 <td class="center">
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="Vymaz(<?php echo $rsluz->cpl;?>);"
       title="Vymazaù riadok" class="btn-cancel">
 </td>
</tr>
</tbody>
<?php
}
$i = $i + 1;
$j = $j + 1;
  }
?>
<?php
$sqlxx = "SELECT SUM(schvaleny) AS uhrn1, SUM(zmeneny) AS uhrn2, SUM(predpoklad) AS uhrn3, SUM(skutocnost) AS uhrn4 FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE druh = 1 ";
$vysledokxx = mysql_query($sqlxx);
if ( $vysledokxx ) {
$riadokxx=mysql_fetch_object($vysledokxx);
$uhrn1 = $riadokxx->uhrn1;
$uhrn2 = $riadokxx->uhrn2;
$uhrn3 = $riadokxx->uhrn3;
$uhrn4 = $riadokxx->uhrn4;
                   }
if ( $uhrn1 == '' ) { $uhrn1=0; }
if ( $uhrn2 == '' ) { $uhrn2=0; }
if ( $uhrn3 == '' ) { $uhrn3=0; }
if ( $uhrn4 == '' ) { $uhrn4=0; }
?>
<tfoot>
<tr>
 <th colspan="2" class="center">Spolu</th>
 <th class="right"><?php echo $uhrn1; ?></th>
 <th class="right"><?php echo $uhrn2; ?></th>
 <th class="right"><?php echo $uhrn3; ?></th>
 <th class="right"><?php echo $uhrn4; ?></th>
 <th>&nbsp;</th>
</tr>
<tr>
 <td class="center">
  <input type="text" name="zdroj" id="zdroj" onkeydown="ZdrojEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="center">
  <input type="text" name="polozka" id="polozka" onkeydown="PolozkaEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="right">
  <input type="text" name="schvaleny" id="schvaleny" onkeydown="SchvalenyEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="zmeneny" id="zmeneny"  onkeydown="ZmenenyEnter(event.which)"  onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="predpoklad" id="predpoklad"  onkeydown="PredpokladEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="skutocnost" id="skutocnost"  onkeydown="SkutocnostEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="center" onmouseover="return Povol_uloz();">
  <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" class="btn-rowsave" >
 </td>
</tr>
</tfoot>
</table>

</div>
</div> <!-- .form-background-wide -->
<?php                     } ?>


<?php if ( $strana == 3 ) { ?>
<div class="form-background-wide">
<div class="form-content-wide">
 <h2 class="toleft form-header">»asù I. - <strong>V˝davky</strong></h2>
 <a href="" title="NaËÌtaù rozpoËet z minulÈho roka" class="toright btn-down-x26">RozpoËet minul˝ rok</a>
<div id="FixneMenu">
<table class="table-heading">
<tr>
 <th style="width:14%;">Zdroj</th>
 <th style="width:14%;">Oddiel</th>
 <th style="width:14%;">Poloûka.Podpoloûka</th>
 <th style="width:12%;">Schv·len˝ rozpoËet</th>
 <th style="width:12%;">RozpoËet po zmen·ch</th>
 <th style="width:12%;">OËak·van· skutoËnosù</th>
 <th style="width:12%;">SkutoËnosù k <?php echo $skutku; ?></th>
 <th style="width:8%;"></th>
</tr>
</table>
</div>

<table class="zoznam" style="width:100%;">
<thead>
<tr class="zero-line">
 <td style="width:14%;"></td>
 <td style="width:14%;"></td>
 <td style="width:14%;"></td>
 <td style="width:12%;"></td>
 <td style="width:12%;"></td>
 <td style="width:12%;"></td>
 <td style="width:12%;"></td>
 <td style="width:8%;"></td>
</tr>
</thead>
<?php
$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE oc >= 0 AND druh = 2 ORDER BY cpl ";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);
?>
<tbody>
<tr>
 <td class="center"><?php echo $rsluz->zdroj; ?></td>
 <td class="center"><?php echo $rsluz->oddiel; ?></td>
 <td class="center"><?php echo $rsluz->polozka; ?></td>
 <td class="right"><?php echo $rsluz->schvaleny; ?></td>
 <td class="right"><?php echo $rsluz->zmeneny; ?></td>
 <td class="right"><?php echo $rsluz->predpoklad; ?></td>
 <td class="right"><?php echo $rsluz->skutocnost; ?></td>
 <td class="center">
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="Vymaz(<?php echo $rsluz->cpl;?>);"
       title="Vymazaù riadok" class="btn-cancel">
 </td>
</tr>
</tbody>
<?php
}
$i = $i + 1;
$j = $j + 1;
  }
?>
<?php
$sqlxx = "SELECT SUM(schvaleny) AS uhrn1, SUM(zmeneny) AS uhrn2, SUM(predpoklad) AS uhrn3, SUM(skutocnost) AS uhrn4 FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE druh = 2 ";
$vysledokxx = mysql_query($sqlxx);
if ( $vysledokxx ) {
$riadokxx=mysql_fetch_object($vysledokxx);
$uhrn1 = $riadokxx->uhrn1;
$uhrn2 = $riadokxx->uhrn2;
$uhrn3 = $riadokxx->uhrn3;
$uhrn4 = $riadokxx->uhrn4;
}
if ( $uhrn1 == '' ) { $uhrn1=0; }
if ( $uhrn2 == '' ) { $uhrn2=0; }
if ( $uhrn3 == '' ) { $uhrn3=0; }
if ( $uhrn4 == '' ) { $uhrn4=0; }
?>
<tfoot>
<tr>
 <th colspan="3" class="center">Spolu</th>
 <th class="right"><?php echo $uhrn1; ?></th>
 <th class="right"><?php echo $uhrn2; ?></th>
 <th class="right"><?php echo $uhrn3; ?></th>
 <th class="right"><?php echo $uhrn4; ?></th>
 <th>&nbsp;</th>
</tr>
<tr>
 <td class="center">
  <input type="text" name="zdroj" id="zdroj" onkeydown="ZdrojEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="center">
  <input type="text" name="oddiel" id="oddiel" onkeydown="OddielEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="center">
  <input type="text" name="polozka" id="polozka" onkeydown="PolozkaEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="right">
  <input type="text" name="schvaleny" id="schvaleny" onkeydown="SchvalenyEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="zmeneny" id="zmeneny"  onkeydown="ZmenenyEnter(event.which)"  onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="predpoklad" id="predpoklad"  onkeydown="PredpokladEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="skutocnost" id="skutocnost"  onkeydown="SkutocnostEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="center" onmouseover="return Povol_uloz();">
  <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" class="btn-rowsave">
 </td>
</tr>
</tfoot>
</table>

</div>
</div> <!-- .form-background-wide -->
<?php                     } ?>


<?php if ( $strana == 4 ) { ?>
<div class="form-background-wide">
<div class="form-content-wide">
 <h2 class="form-header">»asù II. - <strong>PrÌjmovÈ oper·cie</strong></h2>

<div id="FixneMenu">
<table class="table-heading">
<tr>
 <th style="width:30%;">Poloûka.Podpoloûka</th>
 <th style="width:15%;">Schv·len˝ rozpoËet</th>
 <th style="width:15%;">RozpoËet po zmen·ch</th>
 <th style="width:15%;">OËak·van· skutoËnosù</th>
 <th style="width:15%;">SkutoËnosù k <?php echo $skutku; ?></th>
 <th style="width:10%;"></th>
</tr>
</table>
</div>

<table class="zoznam" style="width:100%;">
<thead>
<tr class="zero-line">
 <td style="width:30%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:15%;"></td>
 <td style="width:10%;"></td>
</tr>
</thead>
<?php
$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE oc >= 0 AND druh = 3 ORDER BY cpl ";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);
?>
<tbody>
<tr>
 <td class="center"><?php echo $rsluz->polozka; ?></td>
 <td class="right"><?php echo $rsluz->schvaleny; ?></td>
 <td class="right"><?php echo $rsluz->zmeneny; ?></td>
 <td class="right"><?php echo $rsluz->predpoklad; ?></td>
 <td class="right"><?php echo $rsluz->skutocnost; ?></td>
 <td class="center">
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="Vymaz(<?php echo $rsluz->cpl;?>);"
       title="Vymazaù riadok" class="btn-cancel">
 </td>
</tr>
</tbody>
<?php
}
$i = $i + 1;
$j = $j + 1;
  }
?>
<?php
$sqlxx = "SELECT SUM(schvaleny) AS uhrn1, SUM(zmeneny) AS uhrn2, SUM(predpoklad) AS uhrn3, SUM(skutocnost) AS uhrn4 FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE druh = 3 ";
$vysledokxx = mysql_query($sqlxx);
if ( $vysledokxx ) {
$riadokxx=mysql_fetch_object($vysledokxx);
$uhrn1 = $riadokxx->uhrn1;
$uhrn2 = $riadokxx->uhrn2;
$uhrn3 = $riadokxx->uhrn3;
$uhrn4 = $riadokxx->uhrn4;
}
if ( $uhrn1 == '' ) { $uhrn1=0; }
if ( $uhrn2 == '' ) { $uhrn2=0; }
if ( $uhrn3 == '' ) { $uhrn3=0; }
if ( $uhrn4 == '' ) { $uhrn4=0; }
?>
<tfoot>
<tr>
 <th class="center">Spolu</th>
 <th class="right"><?php echo $uhrn1; ?></th>
 <th class="right"><?php echo $uhrn2; ?></th>
 <th class="right"><?php echo $uhrn3; ?></th>
 <th class="right"><?php echo $uhrn4; ?></th>
 <th>&nbsp;</th>
</tr>
<tr>
 <td class="center">
  <input type="text" name="polozka" id="polozka" onkeydown="PolozkaEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="right">
  <input type="text" name="schvaleny" id="schvaleny" disabled="disabled" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="zmeneny" id="zmeneny" disabled="disabled" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="predpoklad" id="predpoklad" disabled="disabled" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="skutocnost" id="skutocnost" onkeydown="SkutocnostEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="center" onmouseover="return Povol_uloz();">
  <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" class="btn-rowsave">
 </td>
</tr>
</tfoot>
</table>

</div>
</div> <!-- .form-background-wide -->
<?php                     } ?>


<?php if ( $strana == 5 ) { ?>
<div class="form-background-wide">
<div class="form-content-wide">
 <h2 class="form-header">»asù II. - <strong>V˝davkovÈ oper·cie</strong></h2>

<div id="FixneMenu">
<table class="table-heading">
<tr>
 <th style="width:20%;">Oddiel</th>
 <th style="width:20%;">Poloûka.Podpoloûka</th>
 <th style="width:13%;">Schv·len˝ rozpoËet</th>
 <th style="width:13%;">RozpoËet po zmen·ch</th>
 <th style="width:13%;">OËak·van· skutoËnosù</th>
 <th style="width:13%;">SkutoËnosù k <?php echo $skutku; ?></th>
 <th style="width:8%;"></th>
</tr>
</table>
</div>

<table class="zoznam" style="width:100%;">
<thead>
<tr class="zero-line">
 <td style="width:20%;"></td>
 <td style="width:20%;"></td>
 <td style="width:13%;"></td>
 <td style="width:13%;"></td>
 <td style="width:13%;"></td>
 <td style="width:13%;"></td>
 <td style="width:8%;"></td>
</tr>
</thead>
<?php
$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");
$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE oc >= 0 AND druh = 4 ORDER BY cpl ";
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ( $i <= $slpol )
  {
  if (@$zaznam=mysql_data_seek($sluz,$i))
{
$rsluz=mysql_fetch_object($sluz);
?>
<tbody>
<tr>
 <td class="center"><?php echo $rsluz->oddiel; ?></td>
 <td class="center"><?php echo $rsluz->polozka; ?></td>
 <td class="right"><?php echo $rsluz->schvaleny; ?></td>
 <td class="right"><?php echo $rsluz->zmeneny; ?></td>
 <td class="right"><?php echo $rsluz->predpoklad; ?></td>
 <td class="right"><?php echo $rsluz->skutocnost; ?></td>
 <td class="center">
  <img src="../obr/ikony/xmark_lred_icon.png" onclick="Vymaz(<?php echo $rsluz->cpl;?>);"
       title="Vymazaù riadok" class="btn-cancel">
 </td>
</tr>
</tbody>
<?php
}
$i = $i + 1;
$j = $j + 1;
  }
?>
<?php
$sqlxx = "SELECT SUM(schvaleny) AS uhrn1, SUM(zmeneny) AS uhrn2, SUM(predpoklad) AS uhrn3, SUM(skutocnost) AS uhrn4 FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE druh = 4 ";
$vysledokxx = mysql_query($sqlxx);
if ( $vysledokxx ) {
$riadokxx=mysql_fetch_object($vysledokxx);
$uhrn1 = $riadokxx->uhrn1;
$uhrn2 = $riadokxx->uhrn2;
$uhrn3 = $riadokxx->uhrn3;
$uhrn4 = $riadokxx->uhrn4;
}
if ( $uhrn1 == '' ) { $uhrn1=0; }
if ( $uhrn2 == '' ) { $uhrn2=0; }
if ( $uhrn3 == '' ) { $uhrn3=0; }
if ( $uhrn4 == '' ) { $uhrn4=0; }
?>
<tfoot>
<tr>
 <th colspan="2" class="center">Spolu</th>
 <th class="right"><?php echo $uhrn1; ?></th>
 <th class="right"><?php echo $uhrn2; ?></th>
 <th class="right"><?php echo $uhrn3; ?></th>
 <th class="right"><?php echo $uhrn4; ?></th>
 <th class="center">&nbsp;</th>
</tr>
<tr>
 <td class="center">
  <input type="text" name="oddiel" id="oddiel" onkeydown="OddielEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="center">
  <input type="text" name="polozka" id="polozka" onkeydown="PolozkaEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:100px;"/>
 </td>
 <td class="right">
  <input type="text" name="schvaleny" id="schvaleny" disabled="disabled" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="zmeneny" id="zmeneny" disabled="disabled" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="predpoklad" id="predpoklad" disabled="disabled" style="width:80px;"/>
 </td>
 <td class="right">
  <input type="text" name="skutocnost" id="skutocnost" onkeydown="SkutocnostEnter(event.which)" onkeyup="CiarkaNaBodku(this);" style="width:80px;"/>
 </td>
 <td class="center" onmouseover="return Povol_uloz();">
  <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" class="btn-rowsave">
 </td>
</tr>
</tfoot>
</table>

</div>
</div> <!-- .form-background-wide -->
<?php                     } ?>

<?php if ( $strana != 1 ) { ?>
<script type="text/javascript">
    var menu = document.getElementById('FixneMenu');
    window.onscroll = function () {
      menu.className = (
        document.documentElement.scrollTop + document.body.scrollTop > menu.parentNode.offsetTop + 70
        && document.documentElement.clientHeight > menu.offsetHeight
      ) ? "fixne-menu" : "";
    }
</script>
<?php                     } ?>

<div class="navbar">
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas1; ?> toleft">1</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=2&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas2; ?> toleft">PrÌjmy</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=3&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas3; ?> toleft">V˝davky</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=4&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas4; ?> toleft">PrÌjmovÈ oper·cie</a>
 <a href="#" onclick="window.open('<?php echo $source; ?>?copern=20&strana=5&cislo_oc=<?php echo $cislo_oc; ?>', '_self');" class="<?php echo $clas5; ?> toleft">V˝davkovÈ oper·cie</a>
<?php if ( $strana == 1 ) { ?>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
<?php                     } ?>
</div>

</FORM>
</div> <!-- #content -->
<?php
     }
//koniec uprav
?>

<?php
/////////////////////////////////////////////////VYTLAC
if ( $copern == 10 )
{
$hhmmss = Date ("is", MkTime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")) );

 $outfilexdel="../tmp/vykfin_".$kli_uzid."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

$outfilex="../tmp/vykfin_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);

$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


//vytlac

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE druh = 5 ";
$vytvor = mysql_query("$vsql");

// cpl  px12  oc  druh  okres  obec  daz  kor  prx  uce  ucm  ucd  hod  mdt  dal
// program  zdroj  oddiel  xoddiel  skupina  trieda  podtrieda  polozka  xpolozka  podpolozka  nazov  schvaleny  zmeneny  skutocnost  ico

//prijmy
//sumare
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,0,uce,ucm,ucd,0,0,0,".
" program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 OR druh = 3 ".
" GROUP BY druh,zdroj,polozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,10,uce,ucm,ucd,0,0,0,".
" program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 OR druh = 3 ".
" GROUP BY druh,zdroj,xpolozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,200,uce,ucm,ucd,0,0,0,".
" program,zdroj,'99999','99999',skupina,trieda,podtrieda,999999,999,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 ".
" GROUP BY druh,zdroj".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,500,uce,ucm,ucd,0,0,0,".
" program,'99999','99999','99999',skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 OR druh = 3 ".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

//vydavky
//sumare
$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,0,uce,ucm,ucd,0,0,0,".
" program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 OR druh = 4 ".
" GROUP BY druh,zdroj,polozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,10,uce,ucm,ucd,0,0,0,".
" program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 OR druh = 4 ".
" GROUP BY druh,zdroj,xpolozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,200,uce,ucm,ucd,0,0,0,".
" program,zdroj,'99999','99999',skupina,trieda,podtrieda,999999,999,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 ".
" GROUP BY druh,zdroj".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,500,uce,ucm,ucd,0,0,0,".
" program,'99999','99999','99999',skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(predpoklad),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 OR druh = 4  ".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


if ( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $fin1a12=0; }

$sqltt = "SELECT * FROM F$kli_vxcf"."_uctprcvykazx".$kli_uzid." ".
" WHERE F$kli_vxcf"."_uctprcvykazx$kli_uzid.oc >= 0  ORDER BY druh,zdroj,xpolozka,prx,polozka";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
$i=0;
$j=0;

  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$dat_dat = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$dat_dat = SkDatum($hlavicka->da21 );
if( $dat_dat == '0000-00-00' ) $dat_dat="";

//prva strana j=0
if ( $j == 0 ) {

if ( $i == 0 )
     {
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists($jpg_cesta.'_str1.jpg') )
{
$pdf->Image($jpg_cesta.'_str1.jpg',0,0,210,297);
}
$pdf->SetY(10);

//obdobie k
$pdf->SetFont('arial','',10);
$text=$datum;
$pdf->Cell(195,19," ","$rmc1",1,"L");
$pdf->Cell(78,6," ","$rmc1",0,"R");$pdf->Cell(22,4,"$text","$rmc",1,"C");

//druh vykazu krizik
$text="x";
$pdf->Cell(195,17," ","$rmc1",1,"L");
$pdf->Cell(20,4," ","$rmc1",0,"R");$pdf->Cell(4,3,"$text","$rmc",1,"C");

//ico
$text=$fir_fico;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(195,59," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"R");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(4,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$pdf->Cell(5,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",1,"C");

//nazov subjektu
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
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=substr($fir_fnaz,31,30);;
$textx="»˝0123456789abcdefghijklmnoprstuv";
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
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//pravna forma
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
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//ulica a cislo
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
$pdf->Cell(195,13.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");
//
$text=" ";
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
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//psc
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");
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
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");
//
$text=" ";
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
$pdf->Cell(49,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(4,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");

//email
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
$pdf->Cell(195,8.5," ","$rmc1",1,"L");
$pdf->Cell(20,5," ","$rmc1",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");
$pdf->Cell(4,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");
$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");
$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");
$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(4,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");
$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");
$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");
$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//datum zostavenia
$daz= SkDatum($hlavicka->daz);
if ( $daz == '00.00.0000' ) $daz="";
$pdf->Cell(195,12," ","$rmc1",1,"L");
$pdf->Cell(40,5," ","$rmc1",0,"C");$pdf->Cell(22,4,"$daz","$rmc",1,"C");

     }
//koniec ak i=0





//nova dalsia strana
$pdf->AddPage();
$pdf->SetFont('arial','',9);


if( $hlavicka->druh == 1 AND $hlavicka->prx == 0 )
{
$pdf->Cell(155,4,"»asù I. PrÌjmy a v˝davky rozpoËtu subjektu verejnej spr·vy","0",0,"L");$pdf->Cell(30,4,"Strana: 2","0",1,"R");
$pdf->Cell(155,4,"1.1. PrÌjmy","0",1,"L");

$pdf->Cell(20,4," ","T",0,"L");$pdf->Cell(20,4,"Zdroj","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4,"Poloûka+","T",0,"L");

$pdf->Cell(25,4,"Schv·len˝","T",0,"R");
$pdf->Cell(25,4,"RozpoËet","T",0,"R");$pdf->Cell(25,4,"SkutoËnosù","T",1,"R");


$pdf->Cell(20,4," ","B",0,"L");$pdf->Cell(20,4," ","B",0,"L");
$pdf->Cell(35,4," ","B",0,"L");$pdf->Cell(35,4,"podpoloûka","B",0,"L");

$pdf->Cell(25,4,"rozpoËet","B",0,"R");
$pdf->Cell(25,4,"po zmen·ch","B",0,"R");$pdf->Cell(25,4," ","B",1,"R");
}


if( $hlavicka->druh == 2 AND $hlavicka->prx == 0 )
{

$pdf->Cell(155,4,"»asù I. PrÌjmy a v˝davky rozpoËtu subjektu verejnej spr·vy","0",0,"L");$pdf->Cell(30,4,"Strana: 3","0",1,"R");
$pdf->Cell(155,4,"1.2. V˝davky","0",1,"L");


$pdf->Cell(20,4,"Program","T",0,"L");$pdf->Cell(20,4,"Zdroj","T",0,"L");
$pdf->Cell(35,4,"Odd.skup.","T",0,"L");$pdf->Cell(35,4,"Poloûka+","T",0,"L");

$pdf->Cell(25,4,"Schv·len˝","T",0,"R");
$pdf->Cell(25,4,"RozpoËet","T",0,"R");$pdf->Cell(25,4,"SkutoËnosù","T",1,"R");


$pdf->Cell(20,4," ","B",0,"L");$pdf->Cell(20,4," ","B",0,"L");
$pdf->Cell(35,4,"tr.podtr.","B",0,"L");$pdf->Cell(35,4,"podpoloûka","B",0,"L");

$pdf->Cell(25,4,"rozpoËet","B",0,"R");
$pdf->Cell(25,4,"po zmen·ch","B",0,"R");$pdf->Cell(25,4," ","B",1,"R");
}



if( $hlavicka->druh == 3 AND $hlavicka->prx == 0 )
{
$pdf->Cell(155,4,"»asù III. Podnikateæsk· Ëinnosù subjektu verejnej spr·vy","0",0,"L");$pdf->Cell(30,4,"Strana: 4","0",1,"R");
$pdf->Cell(155,4,"3.1. PrÌjmy","0",1,"L");

$pdf->Cell(20,4," ","T",0,"L");$pdf->Cell(20,4," ","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4,"Poloûka+","T",0,"L");

$pdf->Cell(25,4," ","T",0,"R");
$pdf->Cell(25,4," ","T",0,"R");$pdf->Cell(25,4,"SkutoËnosù","T",1,"R");


$pdf->Cell(20,4," ","B",0,"L");$pdf->Cell(20,4," ","B",0,"L");
$pdf->Cell(35,4," ","B",0,"L");$pdf->Cell(35,4,"podpoloûka","B",0,"L");

$pdf->Cell(25,4," ","B",0,"R");
$pdf->Cell(25,4," ","B",0,"R");$pdf->Cell(25,4," ","B",1,"R");

}

if( $hlavicka->druh == 4 AND $hlavicka->prx == 0 )
{

$pdf->Cell(155,4,"»asù III. Podnikateæsk· Ëinnosù subjektu verejnej spr·vy","0",0,"L");$pdf->Cell(30,4,"Strana: 5","0",1,"R");
$pdf->Cell(155,4,"3.2. V˝davky","0",1,"L");


$pdf->Cell(20,4," ","T",0,"L");$pdf->Cell(20,4," ","T",0,"L");
$pdf->Cell(35,4,"Odd.skup.","T",0,"L");$pdf->Cell(35,4,"Poloûka+","T",0,"L");

$pdf->Cell(25,4," ","T",0,"R");
$pdf->Cell(25,4," ","T",0,"R");$pdf->Cell(25,4,"SkutoËnosù","T",1,"R");


$pdf->Cell(20,4," ","B",0,"L");$pdf->Cell(20,4," ","B",0,"L");
$pdf->Cell(35,4,"tr.podtr.","B",0,"L");$pdf->Cell(35,4,"podpoloûka","B",0,"L");

$pdf->Cell(25,4," ","B",0,"R");
$pdf->Cell(25,4," ","B",0,"R");$pdf->Cell(25,4," ","B",1,"R");

}



               }
//koniec j=0



$schvaleny=$hlavicka->schvaleny;
if( $hlavicka->schvaleny == 0 ) $schvaleny="";
$zmeneny=$hlavicka->zmeneny;
if( $hlavicka->zmeneny == 0 ) $zmeneny="";
$predpoklad=$hlavicka->predpoklad;
if( $hlavicka->predpoklad == 0 ) $predpoklad="";
$skutocnost=$hlavicka->skutocnost;
if( $hlavicka->skutocnost == 0 ) $skutocnost="";

//prijem

if( ( $hlavicka->druh == 1 OR $hlavicka->druh == 3 ) AND $hlavicka->prx == 0 )
{
$pdf->Cell(20,4," ","0",0,"L");$pdf->Cell(20,4,"$hlavicka->zdroj","0",0,"L");
$pdf->Cell(35,4," ","0",0,"L");$pdf->Cell(35,4,"$hlavicka->polozka","0",0,"L");

$pdf->Cell(25,4,"$schvaleny","0",0,"R");
$pdf->Cell(25,4,"$zmeneny","0",0,"R");$pdf->Cell(25,4,"$skutocnost","0",1,"R");
}

if( ( $hlavicka->druh == 1 OR $hlavicka->druh == 3 ) AND $hlavicka->prx == 10 )
{
$pdf->Cell(20,4,"$hlavicka->program","T",0,"L");$pdf->Cell(20,4,"$hlavicka->zdroj","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4,"$hlavicka->xpolozka","T",0,"L");

$pdf->Cell(25,4,"$schvaleny","0",0,"R");
$pdf->Cell(25,4,"$zmeneny","0",0,"R");$pdf->Cell(25,4,"$skutocnost","0",1,"R");
}

if( ( $hlavicka->druh == 1 OR $hlavicka->druh == 3 ) AND $hlavicka->prx == 200 )
{
$pdf->Cell(20,4,"$hlavicka->program","T",0,"L");$pdf->Cell(20,4,"$hlavicka->zdroj zdroj celkom","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4," ","T",0,"L");

$pdf->Cell(25,4,"$schvaleny","0",0,"R");
$pdf->Cell(25,4,"$zmeneny","0",0,"R");$pdf->Cell(25,4,"$skutocnost","0",1,"R");
}

if( ( $hlavicka->druh == 1 OR $hlavicka->druh == 3 ) AND $hlavicka->prx == 500 )
{
$pdf->Cell(20,4,"⁄HRN","T",0,"L");$pdf->Cell(20,4," ","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4," ","T",0,"L");

$pdf->Cell(25,4,"$schvaleny","T",0,"R");
$pdf->Cell(25,4,"$zmeneny","T",0,"R");$pdf->Cell(25,4,"$skutocnost","T",1,"R");
$j=-1;
}

//vydaj

if( ( $hlavicka->druh == 2 OR $hlavicka->druh == 4 ) AND $hlavicka->prx == 0 )
{
$pdf->Cell(20,4," ","0",0,"L");$pdf->Cell(20,4,"$hlavicka->zdroj","0",0,"L");
$pdf->Cell(35,4," ","0",0,"L");$pdf->Cell(35,4,"$hlavicka->polozka","0",0,"L");

$pdf->Cell(25,4,"$schvaleny","0",0,"R");
$pdf->Cell(25,4,"$zmeneny","0",0,"R");$pdf->Cell(25,4,"$skutocnost","0",1,"R");
}

if( ( $hlavicka->druh == 2 OR $hlavicka->druh == 4 ) AND $hlavicka->prx == 10 )
{
$pdf->Cell(20,4," ","T",0,"L");$pdf->Cell(20,4,"$hlavicka->zdroj","T",0,"L");
$pdf->Cell(35,4,"$hlavicka->oddiel","T",0,"L");$pdf->Cell(35,4,"$hlavicka->xpolozka","T",0,"L");

$pdf->Cell(25,4,"$schvaleny","0",0,"R");
$pdf->Cell(25,4,"$zmeneny","0",0,"R");$pdf->Cell(25,4,"$skutocnost","0",1,"R");
}

if( ( $hlavicka->druh == 2 OR $hlavicka->druh == 4 ) AND $hlavicka->prx == 200 )
{
$pdf->Cell(20,4," ","T",0,"L");$pdf->Cell(20,4,"$hlavicka->zdroj zdroj celkom","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4," ","T",0,"L");

$pdf->Cell(25,4,"$schvaleny","T",0,"R");
$pdf->Cell(25,4,"$zmeneny","T",0,"R");$pdf->Cell(25,4,"$skutocnost","T",1,"R");
}

if( ( $hlavicka->druh == 2 OR $hlavicka->druh == 4 ) AND $hlavicka->prx == 500 )
{
$pdf->Cell(20,4,"⁄HRN","T",0,"L");$pdf->Cell(20,4," ","T",0,"L");
$pdf->Cell(35,4," ","T",0,"L");$pdf->Cell(35,4," ","T",0,"L");

$pdf->Cell(25,4,"$schvaleny","T",0,"R");
$pdf->Cell(25,4,"$zmeneny","T",0,"R");$pdf->Cell(25,4,"$skutocnost","T",1,"R");
$j=-1;
}


//koniec polozky


}
$i = $i + 1;
$j = $j + 1;
  }
$pdf->Output("$outfilex");
?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>", "_self");
</script>

<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA
?>



<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec
//$cislista = include("uct_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>