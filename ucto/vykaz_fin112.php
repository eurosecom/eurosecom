<HTML>
<?php
//tabulku _uctvykaz_fin104 som nechal aj ked vykaz je fin112 ale poodava sa stvrtrocne

do
{
$sys = 'UCT';
$urov = 3000;
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

//ramcek fpdf
$rmc=0;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_oc = 1*$_REQUEST['cislo_oc'];
$stvrtrok = 1*$_REQUEST['cislo_oc'];
$subor = 1*$_REQUEST['subor'];
$strana = 1*$_REQUEST['strana'];
if( $strana == 0 ) $strana=9999;

$fin1a12 = 1*$_REQUEST['fin1a12'];

if( $cislo_oc == 0 ) $cislo_oc=1;
if( $cislo_oc == 1 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if( $cislo_oc == 2 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if( $cislo_oc == 3 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if( $cislo_oc == 4 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }

if( $fin1a12 == 1 )
    {
if( $cislo_oc == 1 ) { $datum="31.01.".$kli_vrok; $mesiac="01"; $kli_vume="1.".$kli_vrok; }
if( $cislo_oc == 2 ) { $datum="28.02.".$kli_vrok; $mesiac="02"; $kli_vume="2.".$kli_vrok; }
if( $cislo_oc == 3 ) { $datum="31.03.".$kli_vrok; $mesiac="03"; $kli_vume="3.".$kli_vrok; }
if( $cislo_oc == 4 ) { $datum="30.04.".$kli_vrok; $mesiac="04"; $kli_vume="4.".$kli_vrok; }
if( $cislo_oc == 5 ) { $datum="31.05.".$kli_vrok; $mesiac="05"; $kli_vume="5.".$kli_vrok; }
if( $cislo_oc == 6 ) { $datum="30.06.".$kli_vrok; $mesiac="06"; $kli_vume="6.".$kli_vrok; }
if( $cislo_oc == 7 ) { $datum="31.07.".$kli_vrok; $mesiac="07"; $kli_vume="7.".$kli_vrok; }
if( $cislo_oc == 8 ) { $datum="31.08.".$kli_vrok; $mesiac="08"; $kli_vume="8.".$kli_vrok; }
if( $cislo_oc == 9 ) { $datum="30.09.".$kli_vrok; $mesiac="09"; $kli_vume="9.".$kli_vrok; }
if( $cislo_oc == 10 ) { $datum="31.10.".$kli_vrok; $mesiac="10"; $kli_vume="10.".$kli_vrok; }
if( $cislo_oc == 11 ) { $datum="30.11.".$kli_vrok; $mesiac="11"; $kli_vume="11.".$kli_vrok; }
if( $cislo_oc == 12 ) { $datum="31.12.".$kli_vrok; $mesiac="12"; $kli_vume="12.".$kli_vrok; }
    }


$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

//zober z min.roka
if( $copern == 1001 )
  {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù rozpoËet z minnulÈho roka ?") )
         { window.close()  }
else
         { location.href='vykaz_fin112.php?copern=1002&strana=1&fin1a12=<?php echo $fin1a12; ?>'  }
</script>
<?php
    }

    if ( $copern == 1002 )
    {


$dsqlt = "DROP TABLE F".$kli_vxcf."_uctvykaz_fin104_nopre2011 ";
$dsql = mysql_query("$dsqlt");
$copern=20;
  }

$urob=0;
$sql = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104_nopre2011 ";
$vysledok = mysql_query("$sql");
if (!$vysledok) { $urob=1; }

$fir_allx11=1*$fir_allx11;
if ( $urob == 1 AND $kli_vrok > 2010 AND $fir_allx11 > 0 )
  {
$kli_vxcf2010=$kli_vxcf-100;
$kli_vxcf2010=$fir_allx11;

$dsqlt = "DROP TABLE F".$kli_vxcf."_uctvykaz_fin104 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F".$kli_vxcf."_uctvykaz_fin104 SELECT * ".
" FROM ".$databaza."F".$kli_vxcf2010."_uctvykaz_fin104 WHERE cpl = 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F".$kli_vxcf."_uctvykaz_fin104 MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F".$kli_vxcf."_uctvykaz_fin104 SELECT ".
" cpl,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal,".
" program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,schvaleny,zmeneny,skutocnost,ico   ".
" FROM ".$databaza."F".$kli_vxcf2010."_uctvykaz_fin104 ".
" WHERE cpl >= 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F".$kli_vxcf."_uctvykaz_fin104 SET skutocnost=0 ";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<trexima
(
   psys             INT,
   ico              DECIMAL(8,0)
);  
trexima;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin104_nopre2011'.$sqlt;
$vytvor = mysql_query("$vsql");

  }
//koniec zober z min.roka



$vsetkyprepocty=0;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

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

if( $fin1a12 == 0 ) {

//tu poznac z akeho bankoveho uctu to bolo zaplatene 
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_uctban ".
" SET uhrad=F$kli_vxcf"."_uctban.ucm ".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.ico = F$kli_vxcf"."_uctban.ico AND ".
"       F$kli_vxcf"."_prcuobratsy$kli_uzid.fak = F$kli_vxcf"."_uctban.fak AND ".
"       F$kli_vxcf"."_prcuobratsy$kli_uzid.ucm = F$kli_vxcf"."_uctban.ucd AND ".
"       LEFT(F$kli_vxcf"."_uctban.ucm,3) = 221 ";
$oznac = mysql_query("$sqtoz");
//echo $sqtoz;
//exit;


$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_uctban ".
" SET uhrad=F$kli_vxcf"."_uctban.ucd ".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.ico = F$kli_vxcf"."_uctban.ico AND ".
"       F$kli_vxcf"."_prcuobratsy$kli_uzid.fak = F$kli_vxcf"."_uctban.fak AND ".
"       F$kli_vxcf"."_prcuobratsy$kli_uzid.ucd = F$kli_vxcf"."_uctban.ucm AND ".
"       LEFT(F$kli_vxcf"."_uctban.ucd,3) = 221 ";
$oznac = mysql_query("$sqtoz");

//exit;


//tu nastav zdroj podla uctu z akeho to bolo hradene 41=zo zisku VUC,46=vlastne zdroje stat.fondu,71=ine zdroje,111=zo st.rozpoctu
$dfzdroj=46;
if( $_SERVER['SERVER_NAME'] == "www.eurodpsgbely.sk" ) { $dfzdroj=41; }

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid  SET zdroj=$dfzdroj ";
$oznac = mysql_query("$sqtoz");

//tu nastav zdroj podla bankoveho uctu ak ucet3 = 221 a zdroj < 1000
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_crf104nuj_nozdr ".
" SET zdroj=F$kli_vxcf"."_crf104nuj_nozdr.crs".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.uhrad = F$kli_vxcf"."_crf104nuj_nozdr.uce AND LEFT(F$kli_vxcf"."_crf104nuj_nozdr.uce,3) = 221 AND crs < 1000 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//tu nastav zdroj podla dokladu v ikonke ZD ak ucet3 nie je 221 a zdroj < 1000
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_crf104nuj_nozdr ".
" SET zdroj=F$kli_vxcf"."_crf104nuj_nozdr.crs".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.dok = F$kli_vxcf"."_crf104nuj_nozdr.uce AND LEFT(F$kli_vxcf"."_crf104nuj_nozdr.uce,3) != 221 AND crs < 1000 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//koniec ak if( $fin1a12 == 0 ) {
                    }

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


if( $fin1a12 == 0 ) {

//tu nastav zdroj podla uctu v ikonke ZD ak zdroj = 1041,1046...
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_crf104nuj_nozdr ".
" SET zdroj=F$kli_vxcf"."_crf104nuj_nozdr.crs ".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.uce = F$kli_vxcf"."_crf104nuj_nozdr.uce AND crs > 1000 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");
//exit;

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zdroj=zdroj-1000 WHERE zdroj > 1000 ";
$oznac = mysql_query("$sqtoz");

//tu nastav zdroj a polozku podla uctu,doklad,hodnota 
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid,F$kli_vxcf"."_crf104nuj_nozdrdok ".
" SET zdroj=F$kli_vxcf"."_crf104nuj_nozdrdok.crs, poloz=F$kli_vxcf"."_crf104nuj_nozdrdok.rpx ".
" WHERE F$kli_vxcf"."_prcuobratsy$kli_uzid.uce = F$kli_vxcf"."_crf104nuj_nozdrdok.uce ".
" AND   F$kli_vxcf"."_prcuobratsy$kli_uzid.dok = F$kli_vxcf"."_crf104nuj_nozdrdok.dox ".
" AND ( F$kli_vxcf"."_prcuobratsy$kli_uzid.hod = F$kli_vxcf"."_crf104nuj_nozdrdok.hox ".
" OR    F$kli_vxcf"."_prcuobratsy$kli_uzid.hod = -F$kli_vxcf"."_crf104nuj_nozdrdok.hox ) ".
" AND   F$kli_vxcf"."_crf104nuj_nozdrdok.uce > 0 AND F$kli_vxcf"."_crf104nuj_nozdrdok.dox > 0 AND F$kli_vxcf"."_crf104nuj_nozdrdok.hox != 0 ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//tu nastav presun podla uctu zo zdroj1 a polozka1 na zdroj2 a polozka2 ak dok, hod == 0 a uce > 0


//tu nastav presun zo zdroj1 a polozka1 na zdroj2 a polozka2 ak uce, dok, hod == 0 



if( $_SERVER['SERVER_NAME'] == "www.eurodpsgbely.sk" ) 
{  

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobratsy$kli_uzid SET zdroj=46 WHERE uce = 66510 ";
$oznac = mysql_query("$sqtoz");
}

//koniec ak if( $fin1a12 == 0 ) {
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

$zdroj3pol=0;
if( $fin1a12 == 1 ) { $zdroj3pol=1; }
if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND ( $kli_vxcf == 409 OR $kli_vxcf == 509 OR $kli_vxcf == 609 OR $kli_vxcf == 709 ) ) { $zdroj3pol=1; }
if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $zdroj3pol=1; }

if( $zdroj3pol == 1 )
{  

$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=substring(poloz,1,3) WHERE poloz > 0 ";
if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND ( $kli_vxcf == 409 OR $kli_vxcf == 509 OR $kli_vxcf == 609 OR $kli_vxcf == 709 ) ) 
{ 
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=41 WHERE poloz > 0 "; 
}

if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) 
{ 
$sqtoz = "UPDATE F$kli_vxcf"."_prcuobrats$kli_uzid SET zdroj=41 WHERE poloz > 0 "; 
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



if( $kli_uzid == 171717171717171 )
  {


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcuobrats$kli_uzid WHERE poloz > 0 ORDER BY uce,str ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

$hods=$hods+$rtov->hod;

echo $rtov->uce.";".$rtov->zdroj.";".$rtov->poloz.";".$rtov->str."<br />";

 }

$i=$i+1;
   }
echo "Spolu".$hods;
exit;
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
"program,$dfzdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = 41 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,41,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = $dfzdroj ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,71,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = $dfzdroj ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,111,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE zdroj = $dfzdroj ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,px12,oc,(druh+2),okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"'','',oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,0,0,0,ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE druh <= 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 SELECT ".
"0,1,oc,druh,okres,obec,daz,kor,prx,uce,ucm,ucd,hod,mdt,dal, ".
"program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,nazov,sum(schvaleny),sum(zmeneny),0,ico ".
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

if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND ( $kli_vxcf == 409 OR $kli_vxcf == 509 OR $kli_vxcf == 609 OR $kli_vxcf == 709 )) 
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



$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobrats'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcuobratsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$copern=20;
    }
//koniec nacitaj data

// vymaz polozku
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


if ( $strana == 1 OR $strana == 3 )    {

$okres = strip_tags($_REQUEST['okres']);
$obec = strip_tags($_REQUEST['obec']);
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);
$zdroj = strip_tags($_REQUEST['zdroj']);
$polozka = strip_tags($_REQUEST['polozka']);
$schvaleny = 1*$_REQUEST['schvaleny'];
$zmeneny = 1*$_REQUEST['zmeneny'];
$skutocnost = 1*$_REQUEST['skutocnost'];


$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 (oc,druh,zdroj,polozka,schvaleny,zmeneny,skutocnost) VALUES ".
" (  '$stvrtrok', '$strana', '$zdroj', '$polozka', '$schvaleny', '$zmeneny', '$skutocnost' ) ";

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET ".
" okres='$okres', obec='$obec', daz='$daz_sql', xpolozka=SUBSTRING(polozka,1,3), podpolozka=SUBSTRING(polozka,4,3), ".
" xoddiel=SUBSTRING(oddiel,1,2), skupina=SUBSTRING(oddiel,4,1), trieda=SUBSTRING(oddiel,6,1), podtrieda=SUBSTRING(oddiel,8,1) ".
" WHERE oc >= 0 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");



                       }



if ( $strana == 2 OR $strana == 4 )    {

$okres = strip_tags($_REQUEST['okres']);
$obec = strip_tags($_REQUEST['obec']);
$daz = $_REQUEST['daz'];
$daz_sql = SqlDatum($daz);

$zdroj = strip_tags($_REQUEST['zdroj']);
$oddiel = strip_tags($_REQUEST['oddiel']);
$polozka = strip_tags($_REQUEST['polozka']);
$schvaleny = 1*$_REQUEST['schvaleny'];
$zmeneny = 1*$_REQUEST['zmeneny'];
$skutocnost = 1*$_REQUEST['skutocnost'];


$uprtxt = "INSERT INTO F$kli_vxcf"."_uctvykaz_fin104 (oc,druh,zdroj,oddiel,polozka,schvaleny,zmeneny,skutocnost) VALUES ".
" (  '$stvrtrok', '$strana', '$zdroj', '$oddiel', '$polozka', '$schvaleny', '$zmeneny', '$skutocnost' ) ";

//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET ".
" okres='$okres', obec='$obec', daz='$daz_sql', xpolozka=SUBSTRING(polozka,1,3), podpolozka=SUBSTRING(polozka,4,3), ".
" xoddiel=SUBSTRING(oddiel,1,2), skupina=SUBSTRING(oddiel,4,1), trieda=SUBSTRING(oddiel,6,1), podtrieda=SUBSTRING(oddiel,8,1) ".
" WHERE oc >= 0 "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");

                       }


$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
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

$sql = "SELECT px12 FROM F".$kli_vxcf."_uctvykaz_fin104na2des";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DELETE FROM F'.$kli_vxcf.'_uctvykaz_fin104d2 ';
$vysledok = mysql_query("$sqlt");

$sqlt = 'INSERT INTO F'.$kli_vxcf.'_uctvykaz_fin104d2 SELECT * FROM F'.$kli_vxcf.'_uctvykaz_fin104 ';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin104';
$vysledok = mysql_query("$sqlt");
}


$sql = "SELECT px12 FROM F".$kli_vxcf."_uctvykaz_fin104";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin104';
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctvykaz_fin104d2';
//$vysledok = mysql_query("$sqlt");

$desat=0;
  while ($desat <= 1 )
  {
$pocdes="10,2";
if( $desat == 1 ) $pocdes="10,2";

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
if( $desat == 1 ) $vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin104d2'.$sqlt;
$vytvor = mysql_query("$vsql");

$desat=$desat+1;
  }
//koniec while


}
//koniec vytvorenie 

$sql = "SELECT xpolozka FROM F".$kli_vxcf."_uctvykaz_fin104";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104 ADD xpolozka VARCHAR(11) NOT NULL AFTER polozka";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104 ADD xoddiel VARCHAR(11) NOT NULL AFTER oddiel";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104d2 ADD xpolozka VARCHAR(11) NOT NULL AFTER polozka";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvykaz_fin104d2 ADD xoddiel VARCHAR(11) NOT NULL AFTER oddiel";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT px12 FROM F".$kli_vxcf."_uctvykaz_fin104na2des";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$sqlt = 'INSERT INTO F'.$kli_vxcf.'_uctvykaz_fin104 SELECT * FROM F'.$kli_vxcf.'_uctvykaz_fin104d2 ';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   px12          INT,
   ico           INT
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctvykaz_fin104na2des'.$sqlt;
$vytvor = mysql_query("$vsql");

}

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104d2";
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104";
$vytvor = mysql_query("$vsql");

$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");
$vsql = 'TRUNCATE TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid." ";
$vytvor = mysql_query("$vsql");


//vypocty
if( $copern >= 0 )
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


/////////////////////////////////////////////////VYTLAC ROCNE
if( $copern == 10 )
{

if (File_Exists ("../tmp/vykazfin.$kli_uzid.pdf")) { $soubor = unlink("../tmp/vykazfin.$kli_uzid.pdf"); }

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
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
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
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 OR druh = 3 ".
" GROUP BY druh,zdroj,xpolozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,200,uce,ucm,ucd,0,0,0,".
" program,zdroj,'99999','99999',skupina,trieda,podtrieda,999999,999,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 1 ".
" GROUP BY druh,zdroj".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,500,uce,ucm,ucd,0,0,0,".
" program,'99999','99999','99999',skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
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
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 OR druh = 4 ".
" GROUP BY druh,zdroj,polozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,10,uce,ucm,ucd,0,0,0,".
" program,zdroj,oddiel,xoddiel,skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 OR druh = 4 ".
" GROUP BY druh,zdroj,xpolozka".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,200,uce,ucm,ucd,0,0,0,".
" program,zdroj,'99999','99999',skupina,trieda,podtrieda,999999,999,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 ".
" GROUP BY druh,zdroj".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctprcvykazx".$kli_uzid." "." SELECT".
" 0,1,oc,druh,okres,obec,daz,kor,500,uce,ucm,ucd,0,0,0,".
" program,'99999','99999','99999',skupina,trieda,podtrieda,polozka,xpolozka,podpolozka,'',".
"SUM(schvaleny),SUM(zmeneny),SUM(skutocnost),ico ".
" FROM F$kli_vxcf"."_uctvykaz_fin104".
" WHERE druh = 2 OR druh = 4  ".
" GROUP BY druh".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $fin1a12=0; }


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
if ( $j == 0 )    {

if( $i == 0 AND $fin1a12 == 0 )
    {

$pdf->AddPage();
$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);


if (File_Exists ('../dokumenty/vykazy_nujfin2013/fin112/fin112_str1.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2013/fin112/fin112_str1.jpg',0,0,210,296); 
}


$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//obdobie k
$pdf->Cell(195,54,"                          ","$rmc",1,"L");
$text=$datum;
$textx="14.01.2010";

$pdf->Cell(78,6," ","$rmc",0,"R");$pdf->Cell(41,6,"$text","$rmc",1,"C");


//iËo
$pdf->Cell(195,30,"                          ","$rmc",1,"L");

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

$pdf->Cell(1,5," ","$rmc",0,"R");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");


//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5," ","$rmc",0,"C");


//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");


//kÛd okresu
$text=$hlavicka->okres;
$textx="123";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(24,5," ","$rmc",0,"C");


//kÛd obce
$text=$hlavicka->obec;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",1,"C");


//n·zov subj. VS
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
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

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//n·zov subj. VS 2
$pdf->Cell(195,2,"                          ","$rmc",1,"L");
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

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//pr·vna forma subj. VS
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
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

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//ulica a ËÌslo
$pdf->Cell(195,20,"                          ","$rmc",1,"L");
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

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//psË
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5," ","$rmc",0,"C");


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

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",1,"C");


//smerovÈ ËÌslo telefÛnu
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
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

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");


//ËÌslo telefÛnu
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

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");
$pdf->Cell(6,5," ","$rmc",0,"C");


//ËÌslo faxu
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

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",1,"C");


//email
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
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

$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(6,5,"$t05","$rmc",0,"C");$pdf->Cell(6,5,"$t06","$rmc",0,"C");$pdf->Cell(6,5,"$t07","$rmc",0,"C");$pdf->Cell(6,5,"$t08","$rmc",0,"C");
$pdf->Cell(6,5,"$t09","$rmc",0,"C");$pdf->Cell(6,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(6,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(6,5,"$t19","$rmc",0,"C");$pdf->Cell(6,5,"$t20","$rmc",0,"C");
$pdf->Cell(6,5,"$t21","$rmc",0,"C");$pdf->Cell(6,5,"$t22","$rmc",0,"C");$pdf->Cell(6,5,"$t23","$rmc",0,"C");$pdf->Cell(6,5,"$t24","$rmc",0,"C");
$pdf->Cell(6,5,"$t25","$rmc",0,"C");$pdf->Cell(6,5,"$t26","$rmc",0,"C");$pdf->Cell(6,5,"$t27","$rmc",0,"C");$pdf->Cell(6,5,"$t28","$rmc",0,"C");
$pdf->Cell(6,5,"$t29","$rmc",0,"C");$pdf->Cell(6,5,"$t30","$rmc",0,"C");$pdf->Cell(6,5,"$t31","$rmc",1,"C");


//datum zostavenia
$pdf->Cell(195,22,"                          ","$rmc",1,"L");
$daz= SkDatum($hlavicka->daz);
if( $daz == '00.00.0000' ) $daz="";

$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(48,6,"$daz","$rmc",1,"C");

    }
//koniec ak i=0 a fin1a12=0

if( $i == 0 AND $fin1a12 == 1 )
    {

$pdf->AddPage();
$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);


if (File_Exists ('../dokumenty/vykazy_nujfin2014/fin1a12/fin1a12_str1.jpg') )
{
$pdf->Image('../dokumenty/vykazy_nujfin2014/fin1a12/fin1a12_str1.jpg',0,0,210,299); 
}


$pdf->SetY(10);
$pdf->SetFont('arial','',10);

//obdobie k
$pdf->Cell(195,72,"                          ","$rmc",1,"L");
$text=$datum;
$textx="14.01.2010";

$pdf->Cell(78,6," ","$rmc",0,"R");$pdf->Cell(41,6,"$text","$rmc",1,"C");


//iËo
$pdf->Cell(195,19,"                          ","$rmc",1,"L");

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

$pdf->Cell(22,5," ","$rmc",0,"R");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc",0,"C");


//mesiac
$text=$mesiac;
$textx="12345678";
$t01=substr($text,0,1);
$t02=substr($text,1,1);

$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(7,5," ","$rmc",0,"C");


//rok
$text=$kli_vrok;
$textx="1234";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(6,5,"$t03","$rmc",0,"C");$pdf->Cell(6,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc",0,"C");


//kÛd okresu
$text=$hlavicka->okres;
$textx="123";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);

$pdf->Cell(6,5,"$t01","$rmc",0,"C");$pdf->Cell(6,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(19,5," ","$rmc",0,"C");


//kÛd obce
$text=$hlavicka->obec;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);

$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",1,"C");


//n·zov subj. VS
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
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

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");


//n·zov subj. VS 2
$pdf->Cell(195,2,"                          ","$rmc",1,"L");
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

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(6,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(6,5,"$t13","$rmc",0,"C");$pdf->Cell(6,5,"$t14","$rmc",0,"C");$pdf->Cell(6,5,"$t15","$rmc",0,"C");$pdf->Cell(6,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(6,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");

//pr·vna forma subj. VS
$pdf->Cell(195,6,"                          ","$rmc",1,"L");
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

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(6,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(7,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");


//ulica a ËÌslo
$pdf->Cell(195,14,"                          ","$rmc",1,"L");
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

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(5,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(7,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");


//psË
$pdf->Cell(195,9,"                          ","$rmc",1,"L");
$fir_fpsc=str_replace(" ","",$fir_fpsc);
$text=$fir_fpsc;
$textx="123456";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5," ","$rmc",0,"C");


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

$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(7,5,"$t07","$rmc",0,"C");$pdf->Cell(7,5,"$t08","$rmc",0,"C");
$pdf->Cell(7,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(7,5,"$t12","$rmc",0,"C");
$pdf->Cell(5,5,"$t13","$rmc",0,"C");$pdf->Cell(5,5,"$t14","$rmc",0,"C");$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(5,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",1,"C");


//smerovÈ ËÌslo telefÛnu
$pdf->Cell(195,9,"                          ","$rmc",1,"L");
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

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc",0,"C");


//ËÌslo telefÛnu
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

$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc",0,"C");

//smerove cislo faxu
$pole = explode("/", $fir_ffax);
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

$pdf->Cell(12,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5," ","$rmc",0,"C");

//ËÌslo faxu
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

$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",1,"C");


//email
$pdf->Cell(195,9,"                          ","$rmc",1,"L");
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

$pdf->Cell(22,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$t01","$rmc",0,"C");$pdf->Cell(5,5,"$t02","$rmc",0,"C");$pdf->Cell(5,5,"$t03","$rmc",0,"C");$pdf->Cell(5,5,"$t04","$rmc",0,"C");
$pdf->Cell(5,5,"$t05","$rmc",0,"C");$pdf->Cell(5,5,"$t06","$rmc",0,"C");$pdf->Cell(5,5,"$t07","$rmc",0,"C");$pdf->Cell(5,5,"$t08","$rmc",0,"C");
$pdf->Cell(5,5,"$t09","$rmc",0,"C");$pdf->Cell(5,5,"$t10","$rmc",0,"C");$pdf->Cell(5,5,"$t11","$rmc",0,"C");$pdf->Cell(7,5,"$t12","$rmc",0,"C");
$pdf->Cell(7,5,"$t13","$rmc",0,"C");$pdf->Cell(7,5,"$t14","$rmc",0,"C");$pdf->Cell(5,5,"$t15","$rmc",0,"C");$pdf->Cell(5,5,"$t16","$rmc",0,"C");
$pdf->Cell(5,5,"$t17","$rmc",0,"C");$pdf->Cell(7,5,"$t18","$rmc",0,"C");$pdf->Cell(5,5,"$t19","$rmc",0,"C");$pdf->Cell(5,5,"$t20","$rmc",0,"C");
$pdf->Cell(5,5,"$t21","$rmc",0,"C");$pdf->Cell(5,5,"$t22","$rmc",0,"C");$pdf->Cell(5,5,"$t23","$rmc",0,"C");$pdf->Cell(5,5,"$t24","$rmc",0,"C");
$pdf->Cell(5,5,"$t25","$rmc",0,"C");$pdf->Cell(5,5,"$t26","$rmc",0,"C");$pdf->Cell(5,5,"$t27","$rmc",0,"C");$pdf->Cell(5,5,"$t28","$rmc",0,"C");
$pdf->Cell(5,5,"$t29","$rmc",0,"C");$pdf->Cell(5,5,"$t30","$rmc",0,"C");$pdf->Cell(5,5,"$t31","$rmc",1,"C");


//datum zostavenia
$pdf->Cell(195,22,"                          ","$rmc",1,"L");
$daz= SkDatum($hlavicka->daz);
if( $daz == '00.00.0000' ) $daz="";

$pdf->Cell(15,6," ","$rmc",0,"C");$pdf->Cell(48,6,"$daz","$rmc",1,"C");

    }
//koniec ak i=0 a fin1a12=1


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

$pdf->Output("../tmp/vykazfin.$kli_uzid.pdf");




?>

<script type="text/javascript">
  var okno = window.open("../tmp/vykazfin.<?php echo $kli_uzid; ?>.pdf","_self");
</script>


<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA 

if( $strana == 9999 ) $strana=1;

//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE oc >= 0 ";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

if( $strana == 1 OR $strana == 3 OR $strana == 9999 )
{

$okres = 1*$fir_riadok->okres;
$obec = 1*$fir_riadok->obec;
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);

}

if( $strana == 2 OR $strana == 4 )
{

$okres = 1*$fir_riadok->okres;
$obec = 1*$fir_riadok->obec;
$daz = $fir_riadok->daz;
$daz_sk=SkDatum($daz);

}

$sqlfirx = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE oddiel != '' ";

$fir_vysledokx = mysql_query($sqlfirx);
$fir_riadokx=mysql_fetch_object($fir_vysledokx);


$ostp = $fir_riadokx->oddiel;


mysql_free_result($fir_vysledok);



    }
//koniec nacitania

$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}
$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin204nuj WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}
$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin504 WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}
$pol=0;
if( $okres == 0 OR $obec == 0 )
{
$sqlokr = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin604 WHERE okres > 0 AND obec > 0 ";
$okr_vysledok = mysql_query($sqlokr);
if( $okr_vysledok ) { $pol = 1*mysql_num_rows($okr_vysledok); }
if( $pol > 0) { $okr_riadok=mysql_fetch_object($okr_vysledok); $okres=1*$okr_riadok->okres; $obec=1*$okr_riadok->obec; }
}



$dness = Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
if( $daz_sk == '00.00.0000' ) { $daz_sk=$dness; }

$popvyk="FIN 1-12";
if( $fin1a12 == 1 ) { $popvyk="FIN 1a-12"; }
if( $_SERVER['SERVER_NAME'] == "www.smmgbely.sk" ) { $popvyk="FIN 1-12"; }

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>V˝kaz <?php echo $popvyk; ?></title>
  <style type="text/css">

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


function ProgramEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.zdroj.focus();
        document.forms.formv1.zdroj.select();
              }
                }

function ZdrojEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        <?php if ( $strana == 1 ) { ?>
        document.forms.formv1.polozka.focus();
        document.forms.formv1.polozka.select();
        <?php                     } ?>
        <?php if ( $strana == 2 ) { ?>
        document.forms.formv1.oddiel.focus();
        document.forms.formv1.oddiel.select();
        <?php                     } ?>
              }
                }

function OddielEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.polozka.focus();
        document.forms.formv1.polozka.select();
              }
                }

function PolozkaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        <?php if ( $strana <= 2 ) { ?>
        document.forms.formv1.schvaleny.focus();
        document.forms.formv1.schvaleny.select();
        <?php                     } ?>
        <?php if ( $strana >  2 ) { ?>
        document.forms.formv1.skutocnost.focus();
        document.forms.formv1.skutocnost.select();
        <?php                     } ?>

              }
                }

function SchvalenyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.zmeneny.value=document.formv1.schvaleny.value; 
        document.forms.formv1.zmeneny.focus();
        document.forms.formv1.zmeneny.select();
              }
                }

function ZmenenyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.forms.formv1.skutocnost.focus();
        document.forms.formv1.skutocnost.select();
              }
                }

function SkutocnostEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

    if ( document.formv1.zdroj.value == '' ) okvstup=0;
    if ( document.formv1.zdroj.value == 0 ) okvstup=0;
    if ( document.formv1.polozka.value == '' ) okvstup=0;
    if ( document.formv1.polozka.value == 0 ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true);  document.forms.formv1.submit(); return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

              }
                }


    function ObnovUI()
    {

<?php if ( $strana == 1 OR $strana == 3 )                           { ?>

document.formv1.okres.value = '<?php echo $okres;?>';
document.formv1.obec.value = '<?php echo $obec;?>';
document.formv1.daz.value = '<?php echo $daz_sk;?>';
document.formv1.ostp.value = '<?php echo $ostp;?>';

document.formv1.zdroj.value = '<?php echo $zdroj;?>';
document.formv1.polozka.value = '<?php echo $polozka;?>';
document.formv1.schvaleny.value = '<?php echo $schvaleny;?>';
document.formv1.zmeneny.value = '<?php echo $zmeneny;?>';
document.formv1.skutocnost.value = '<?php echo $skutocnost;?>';

 document.formv1.uloz.disabled = true;
 if( document.forms.formv1.zdroj.value == '' ) { document.forms.formv1.zdroj.value="41"; }
        <?php if ( $strana == 1 ) { ?>
        document.forms.formv1.zdroj.focus();
        document.forms.formv1.zdroj.select();
        <?php                     } ?>
        <?php if ( $strana == 3 ) { ?>
        document.forms.formv1.polozka.focus();
        document.forms.formv1.polozka.select();
        <?php                     } ?>

<?php                                                  } ?>

<?php if ( $strana == 2 OR $strana == 4 )                           { ?>


document.formv1.okres.value = '<?php echo $okres;?>';
document.formv1.obec.value = '<?php echo $obec;?>';
document.formv1.daz.value = '<?php echo $daz_sk;?>';
document.formv1.ostp.value = '<?php echo $ostp;?>';

document.formv1.zdroj.value = '<?php echo $zdroj;?>';
document.formv1.oddiel.value = '<?php echo $oddiel;?>';
document.formv1.polozka.value = '<?php echo $polozka;?>';
document.formv1.schvaleny.value = '<?php echo $schvaleny;?>';
document.formv1.zmeneny.value = '<?php echo $zmeneny;?>';
document.formv1.skutocnost.value = '<?php echo $skutocnost;?>';

 document.formv1.uloz.disabled = true;
 if( document.forms.formv1.zdroj.value == '' ) { document.forms.formv1.zdroj.value="41"; }
 if( document.forms.formv1.oddiel.value == '' ) { document.forms.formv1.oddiel.value="10.1.2.2"; }
        <?php if ( $strana == 2 ) { ?>
        document.forms.formv1.zdroj.focus();
        document.forms.formv1.zdroj.select();
        <?php                     } ?>
        <?php if ( $strana == 4 ) { ?>
        document.forms.formv1.oddiel.focus();
        document.forms.formv1.oddiel.select();
        <?php                     } ?>
<?php                                                                   } ?>



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

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


function ZnovuPotvrdenie()
                {
window.open('vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&drupoh=1&page=1&subor=1&fin1a12=<?php echo $fin1a12; ?>',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


  function Generuj()
  { 

window.open('../ucto/oprcis.php?copern=308&drupoh=84&page=1&sysx=UCT', '_blank','<?php echo $tlcuwin; ?>' );

  }

  function AkyZdroj()
  { 

window.open('../ucto/oprcis.php?copern=308&drupoh=85&page=1&sysx=UCT', '_blank','<?php echo $tlcuwin; ?>' );

  }

  function AkyZdroj2()
  { 

window.open('../ucto/oprcis.php?copern=308&drupoh=86&page=1&sysx=UCT', '_blank','<?php echo $tlcuwin; ?>' );

  }


function ZnovuNacitaj()
                {
var nostp = document.formv1.ostp.value;

window.open('vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=26&nostp=' + nostp + '&drupoh=1&page=1&subor=1&fin1a12=<?php echo $fin1a12; ?>', '_self' );
                }

   
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI();" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  V˝kaz <?php echo $popvyk; ?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>


<?php if( $copern == 20 ) { ?>

<table class="h2" width="100%" >
<tr>
<td align="left">

<?php
if( $strana < 1 OR $strana > 4 ) $strana=1;
?>

<?php if( $fin1a12 == 0 ) { 
echo "Obdobie: ".$cislo_oc.".ötvrùrok ".$kli_vrok."  ";
                          }
?>
<?php if( $fin1a12 == 1 ) { 
echo "Obdobie: ".$cislo_oc.".mesiac ".$kli_vrok."  ";
                          }
?>
<a href="#" onClick="ZnovuNacitaj();">
<img src='../obr/orig.png' width=20 height=15 border=0 title='Znovu naËÌtaù hodnoty ' ></a>

<a href="#" onClick="window.open('vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=10&drupoh=1&page=1&subor=0&strana=9999&fin1a12=<?php echo $fin1a12; ?>',
 '_blank', 'width=1050, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='TlaË do PDF' ></a>
</td>

<td colspan="2">
<a href="#" onClick="Generuj();" title='Generovanie naËÌtania=priradenie ˙Ëtu k rozpoËtovej poloûke'>
UCRP<img src='../obr/zoznam.png' width=15 height=15 border=0  ></a>
 - 
<a href="#" onClick="AkyZdroj();" title='Priradenie zdroja financovania k bankovÈmu ˙Ëtu,dokladu,˙Ëtu'>
ZD<img src='../obr/zoznam.png' width=15 height=15 border=0  ></a>
 - 
<a href="#" onClick="AkyZdroj2();" title='Priradenie zdroja,rozp.poloûky ku kombin·cii ˙Ëet,doklad,hodnota'>
ZDRP<img src='../obr/zoznam.png' width=15 height=15 border=0  ></a>
</tr>
</table>


<?php                     } ?>


<?php
//upravy  udaje strana
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="../ucto/vykaz_fin112.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>&fin1a12=<?php echo $fin1a12; ?>" >
<tr>
<td class="bmenu" width="10%"> Strana <?php echo $strana;?>
<?php
$prev_str=$strana-1;
$next_str=$strana+1;
if( $prev_str == 0 ) $prev_str=4;
if( $next_str == 5 ) $next_str=1;
?>
<td class="bmenu" width="10%">
<a href="#" onClick="window.open('vykaz_fin112.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $prev_str;?>&fin1a12=<?php echo $fin1a12; ?>', '_self' )">
<img src='../obr/prev.png' width=12 height=12 border=0 title='Strana <?php echo $prev_str;?> obdobie <?php echo $cislo_oc; ?>' ></a>
<a href="#" onClick="window.open('vykaz_fin112.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $next_str;?>&fin1a12=<?php echo $fin1a12; ?>', '_self' )">
<img src='../obr/next.png' width=12 height=12 border=0 title='Strana <?php echo $next_str;?> obdobie <?php echo $cislo_oc; ?>' ></a>
</td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</tr>

<tr>

<td class="bmenu" colspan="3">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title="Uprav vybran˙ stranu Ë." ></a>

<a href="#" onClick="window.open('../ucto/vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=1&subor=0&strana=1&fin1a12=<?php echo $fin1a12; ?>', '_self' );">1</a> 

<a href="#" onClick="window.open('../ucto/vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=1&subor=0&strana=2&fin1a12=<?php echo $fin1a12; ?>', '_self' );">2</a>

<a href="#" onClick="window.open('../ucto/vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=1&subor=0&strana=3&fin1a12=<?php echo $fin1a12; ?>', '_self' );">3</a> 

<a href="#" onClick="window.open('../ucto/vykaz_fin112.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=1&subor=0&strana=4&fin1a12=<?php echo $fin1a12; ?>', '_self' );">4</a>

</td>

<td class="bmenu" colspan="3"></td>

<td class="obyc" colspan="4"></td>
</tr>

<tr><td class="pvstuz" colspan="10">⁄daje o firme </td></tr>
<tr>
<td class="bmenu" colspan="9">KÛd okresu:
<input type="text" name="okres" id="okres" size="10" />
 KÛd obce:
<input type="text" name="obec" id="obec" size="10" />
 V˝kaz zostaven˝ dÚa:
<input type="text" name="daz" id="daz" size="10" />

 Oddiel.Skupina.Trieda.Podtrieda:
<input type="text" name="ostp" id="ostp" size="10" />
</td>
<td class="bmenu" colspan="1">
<a href='vykaz_fin112.php?copern=1001&strana=1&fin1a12=<?php echo $fin1a12; ?>'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaù rozpoËet z minulÈho roka"></a>
</td>
</tr>

<?php if ( $strana == 1   )                           { ?>

<?php

$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE oc >= 0 AND druh = 1 ORDER BY druh,kor,xpolozka,polozka";


//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i) OR $j == 0 )
{
$rsluz=mysql_fetch_object($sluz);

if( $j == 0 )
     {
$fmenu="fmenu";
$pvstup="pvstup";

?>

<tr><td class="pvstuz" colspan="10">»asù I.PrÌjmy a v˝davky rozpoËtu subjektu verejnej spr·vy </td></tr>
<tr><td class="pvstuz" colspan="10">1.1. PrÌjmy </td></tr>
<tr>
<td class="bmenu" colspan="1">Zdroj</td>
<td class="bmenu" colspan="2">Poloûka + Podpoloûka</td>
<td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1" align="right">Schv·len˝ rozpoËet</td>
<td class="bmenu" colspan="1" align="right">RozpoËet po zmen·ch</td>
<td class="bmenu" colspan="1" align="right">SkutoËnosù</td>
</tr>

<?php
     }
//koniec j=0



?>

<tr>
<td class="hvstup" colspan="1"><?php echo $rsluz->zdroj;?></td>
<td class="hvstup" colspan="2"><?php echo $rsluz->polozka;?></td>
<td class="hvstup" colspan="4"><?php echo $rsluz->nazov;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->schvaleny;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->zmeneny;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->skutocnost;?>

<a href='vykaz_fin112.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>&fin1a12=<?php echo $fin1a12; ?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>

</td>
</tr>

<?php
}

$i = $i + 1;
$j = $j + 1;
  }
              
?>

<tr>
<td class="bmenu" colspan="1"><input type="text" name="zdroj" id="zdroj" size="10" onKeyDown="return ZdrojEnter(event.which)"/></td>
<td class="bmenu" colspan="2"><input type="text" name="polozka" id="polozka" size="10" onKeyDown="return PolozkaEnter(event.which)"/></td>

<td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="schvaleny" id="schvaleny" size="10" onKeyDown="return SchvalenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="zmeneny" id="zmeneny" size="10" onKeyDown="return ZmenenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="skutocnost" id="skutocnost" size="10" onKeyDown="return SkutocnostEnter(event.which)"/></td>
</tr>




<?php                                                                  } //koniec 1.strana ?>




<?php if ( $strana == 2  )                           { ?>


<?php

$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104  ".
" WHERE oc >= 0 AND druh = 2 ORDER BY druh,kor,xpolozka,polozka";


//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i) OR $j == 0 )
{
$rsluz=mysql_fetch_object($sluz);

if( $j == 0 )
     {
$fmenu="fmenu";
$pvstup="pvstup";

?>


<tr><td class="pvstuz" colspan="10">»asù I.PrÌjmy a v˝davky rozpoËtu subjektu verejnej spr·vy </td></tr>
<tr><td class="pvstuz" colspan="10">1.2. V˝davky </td></tr>
<tr>
<td class="bmenu" colspan="1">Program</td>
<td class="bmenu" colspan="1">Zdroj</td>
<td class="bmenu" colspan="2">Oddiel + Skupina + Trieda + Podtrieda</td>
<td class="bmenu" colspan="2">Poloûka + Podpoloûka</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right">Schv·len˝ rozpoËet</td>
<td class="bmenu" colspan="1" align="right">RozpoËet po zmen·ch</td>
<td class="bmenu" colspan="1" align="right">SkutoËnosù</td>
</tr>

<?php
     }
//koniec j=0



?>

<tr>
<td class="hvstup" colspan="1"><?php echo $rsluz->program;?></td>
<td class="hvstup" colspan="1"><?php echo $rsluz->zdroj;?></td>
<td class="hvstup" colspan="2"><?php echo $rsluz->oddiel;?></td>
<td class="hvstup" colspan="2"><?php echo $rsluz->polozka;?></td>

<td class="hvstup" colspan="1"><?php echo $rsluz->nazov;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->schvaleny;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->zmeneny;?></td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->skutocnost;?>

<a href='vykaz_fin112.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>&fin1a12=<?php echo $fin1a12; ?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>

</td>
</tr>

<?php
}

$i = $i + 1;
$j = $j + 1;
  }
              
?>


<tr>
<td class="bmenu" colspan="1"><input type="text" name="program" id="program" size="10" onKeyDown="return ProgramEnter(event.which)"/></td>
<td class="bmenu" colspan="1"><input type="text" name="zdroj" id="zdroj" size="10" onKeyDown="return ZdrojEnter(event.which)"/></td>
<td class="bmenu" colspan="2"><input type="text" name="oddiel" id="oddiel" size="10" onKeyDown="return OddielEnter(event.which)"/></td>

<td class="bmenu" colspan="2"><input type="text" name="polozka" id="polozka" size="10" onKeyDown="return PolozkaEnter(event.which)"/></td>

<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="schvaleny" id="schvaleny" size="10" onKeyDown="return SchvalenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="zmeneny" id="zmeneny" size="10" onKeyDown="return ZmenenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="skutocnost" id="skutocnost" size="10" onKeyDown="return SkutocnostEnter(event.which)"/></td>
</tr>



<?php                                                                  } //koniec 2.strana ?>

<?php if ( $strana == 3   )                           { ?>

<?php

$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104 ".
" WHERE oc >= 0 AND druh = 3 ORDER BY druh,kor,xpolozka,polozka";


//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i) OR $j == 0 )
{
$rsluz=mysql_fetch_object($sluz);

if( $j == 0 )
     {
$fmenu="fmenu";
$pvstup="pvstup";

?>

<tr><td class="pvstuz" colspan="10">»asù III.Podnikateæsk· Ëinnosù subjektu verejnej spr·vy </td></tr>
<tr><td class="pvstuz" colspan="10">3.1. PrÌjmy </td></tr>
<tr>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="2">Poloûka + Podpoloûka</td>
<td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1" align="right"> </td>
<td class="bmenu" colspan="1" align="right"> </td>
<td class="bmenu" colspan="1" align="right">SkutoËnosù</td>
</tr>

<?php
     }
//koniec j=0



?>

<tr>
<td class="hvstup" colspan="1"> </td>
<td class="hvstup" colspan="2"><?php echo $rsluz->polozka;?></td>
<td class="hvstup" colspan="4"><?php echo $rsluz->nazov;?></td>
<td class="hvstup" colspan="1" align="right"> </td>
<td class="hvstup" colspan="1" align="right"> </td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->skutocnost;?>

<a href='vykaz_fin112.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>&fin1a12=<?php echo $fin1a12; ?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>

</td>
</tr>

<?php
}

$i = $i + 1;
$j = $j + 1;
  }
              
?>

<tr>
<td class="bmenu" colspan="1"><input type="hidden" name="zdroj" id="zdroj" size="10" onKeyDown="return ZdrojEnter(event.which)"/></td>
<td class="bmenu" colspan="2"><input type="text" name="polozka" id="polozka" size="10" onKeyDown="return PolozkaEnter(event.which)"/></td>

<td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1" align="right"><input type="hidden" name="schvaleny" id="schvaleny" size="10" onKeyDown="return SchvalenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="hidden" name="zmeneny" id="zmeneny" size="10" onKeyDown="return ZmenenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="skutocnost" id="skutocnost" size="10" onKeyDown="return SkutocnostEnter(event.which)"/></td>
</tr>




<?php                                                                  } //koniec 3.strana ?>




<?php if ( $strana == 4  )                           { ?>


<?php

$sluztt = "UPDATE F$kli_vxcf"."_uctvykaz_fin104 SET kor=1*zdroj ";
$sluz = mysql_query("$sluztt");

$sluztt = "SELECT * FROM F$kli_vxcf"."_uctvykaz_fin104  ".
" WHERE oc >= 0 AND druh = 4 ORDER BY druh,kor,xpolozka,polozka";


//echo $sluztt;
$sluz = mysql_query("$sluztt");
$slpol = mysql_num_rows($sluz);

//zaciatok vypisu
$i=0;
$j=0;
  while ($i <= $slpol )
  {

  if (@$zaznam=mysql_data_seek($sluz,$i) OR $j == 0 )
{
$rsluz=mysql_fetch_object($sluz);

if( $j == 0 )
     {
$fmenu="fmenu";
$pvstup="pvstup";

?>


<tr><td class="pvstuz" colspan="10">»asù III.Podnikateæsk· Ëinnosù subjektu verejnej spr·vy </td></tr>
<tr><td class="pvstuz" colspan="10">3.2. V˝davky </td></tr>
<tr>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="2">Oddiel + Skupina + Trieda + Podtrieda</td>
<td class="bmenu" colspan="2">Poloûka + Podpoloûka</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right"> </td>
<td class="bmenu" colspan="1" align="right"> </td>
<td class="bmenu" colspan="1" align="right">SkutoËnosù</td>
</tr>

<?php
     }
//koniec j=0



?>

<tr>
<td class="hvstup" colspan="1"> </td>
<td class="hvstup" colspan="1"> </td>
<td class="hvstup" colspan="2"><?php echo $rsluz->oddiel;?></td>
<td class="hvstup" colspan="2"><?php echo $rsluz->polozka;?></td>

<td class="hvstup" colspan="1"><?php echo $rsluz->nazov;?></td>
<td class="hvstup" colspan="1" align="right"> </td>
<td class="hvstup" colspan="1" align="right"> </td>
<td class="hvstup" colspan="1" align="right"><?php echo $rsluz->skutocnost;?>

<a href='vykaz_fin112.php?copern=316&cislo_cpl=<?php echo $rsluz->cpl;?>&cislo_oc=<?php echo $cislo_oc;?>&strana=<?php echo $strana;?>&fin1a12=<?php echo $fin1a12; ?>'>
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Vymazaù riadok" ></a>

</td>
</tr>

<?php
}

$i = $i + 1;
$j = $j + 1;
  }
              
?>


<tr>
<td class="bmenu" colspan="1"><input type="hidden" name="program" id="program" size="10" onKeyDown="return ProgramEnter(event.which)"/></td>
<td class="bmenu" colspan="1"><input type="hidden" name="zdroj" id="zdroj" size="10" onKeyDown="return ZdrojEnter(event.which)"/></td>
<td class="bmenu" colspan="2"><input type="text" name="oddiel" id="oddiel" size="10" onKeyDown="return OddielEnter(event.which)"/></td>

<td class="bmenu" colspan="2"><input type="text" name="polozka" id="polozka" size="10" onKeyDown="return PolozkaEnter(event.which)"/></td>

<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right"><input type="hidden" name="schvaleny" id="schvaleny" size="10" onKeyDown="return SchvalenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="hidden" name="zmeneny" id="zmeneny" size="10" onKeyDown="return ZmenenyEnter(event.which)"/></td>
<td class="bmenu" colspan="1" align="right"><input type="text" name="skutocnost" id="skutocnost" size="10" onKeyDown="return SkutocnostEnter(event.which)"/></td>
</tr>



<?php                                                                  } //koniec 4.strana ?>


<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù"></td>
</tr>



</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje 
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykaz'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazx'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_uctprcvykazz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
$cislista = include("uct_lista.php");
       } while (false);
?>
</BODY>
</HTML>
