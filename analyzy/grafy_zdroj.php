<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'ANA';
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

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$katg = 1*$_REQUEST['katg'];
$minule = 1*$_REQUEST['minule'];

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");


$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;
$strana=1;

//echo $copern;
//echo $katg;
//echo $kli_uzid;

//bezny a minuly zdroj 
if( $copern == 1001 OR $copern == 1002 ) 
{
$sqlt = <<<uctcrv
(
   rok           DECIMAL(4,0) DEFAULT 0,
   ume           DECIMAL(7,4) DEFAULT 0,
   dat           DATE NOT NULL,
   uce           VARCHAR(8) NOT NULL,
   ucd           VARCHAR(8) NOT NULL,
   hod           DECIMAL(10,2) DEFAULT 0,
   konx          DECIMAL(1,0) DEFAULT 0,
   cvz           DECIMAL(3,0) DEFAULT 0,
   csv           DECIMAL(3,0) DEFAULT 0
);
uctcrv;

if( $copern == 1001 ) {
$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfy".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
                      }

if( $copern == 1002 ) {
$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfb".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfb'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
                      }

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$h_obdp=1;
$h_obdk=$kli_vmes;

//daj cisla firiem
$firm1=0; $firm2=0; $firm3=0; $firm4=0; $firm5=$kli_vxcf;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm4=$fir_allx11; }

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

if( $firm4 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm4"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm3=$fir_allx11; }
}

if( $kli_vrok == 2012 ) { if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; } }
if( $kli_vrok == 2013 ) { if (File_Exists ("../pswd/oddelena2011db2012.php")) { $databaza=$mysqldb2011."."; } }
if( $kli_vrok == 2014 ) { if (File_Exists ("../pswd/oddelena2013db2014.php")) { $databaza=$mysqldb2013."."; } }

if( $firm3 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm3"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm2=$fir_allx11; }
}

if( $kli_vrok == 2013 ) { if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; } }
if( $kli_vrok == 2014 ) { if (File_Exists ("../pswd/oddelena2013db2014.php")) { $databaza=$mysqldb2013."."; } }

if( $firm2 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm2"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if( $fir_allx11 > 0 ) { $firm1=$fir_allx11; }
}
//koniec daj cisla firiem



$rokm5=$kli_vrok;
$rokm4=$kli_vrok-1;
$rokm3=$kli_vrok-2;
$rokm2=$kli_vrok-3;
$rokm1=$kli_vrok-4;

$kli_vrokset5=$rokm5;
$kli_vrokset4=$rokm4;
$kli_vrokset3=$rokm3;
$kli_vrokset2=$rokm2;
$kli_vrokset1=$rokm1;


$xrok=$rokm5;
$kli_vxcfx=$firm5;

$lenjedenrok=1;
if( $copern == 1001 ) { $kolkorokov=1; $lenjedenrok=1; }
if( $copern == 1002 ) { $kolkorokov=5; $lenjedenrok=2; }

while( $lenjedenrok <= $kolkorokov ) {

if( $lenjedenrok == 2 ) { $xrok=$rokm4; $kli_vxcfx=$firm4; }
if( $lenjedenrok == 3 ) { $xrok=$rokm3; $kli_vxcfx=$firm3; }
if( $lenjedenrok == 4 ) { $xrok=$rokm2; $kli_vxcfx=$firm2; }
if( $lenjedenrok == 5 ) { $xrok=$rokm1; $kli_vxcfx=$firm1; }

$kli_vrok=$xrok;

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$xrok;
$dtb2 = include("../cis/oddel_dtbz1.php");
$kli_vrok=$kli_vrokx; 


$mes_obdp=$h_obdp.".".$kli_vrok;
$mes_obdk=$h_obdk.".".$kli_vrok;


$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfx".$kli_uzid;
$vysledok = mysql_query($sql);


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$umeps="1.".$xrok;
$datps=$xrok."-01-01";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" 0,'$umeps','$datps',uce,0,(pmd-pda),0,0,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_uctosnova ".
" WHERE pmd != 0 OR pda != 0 ";

$dsql = mysql_query("$dsqlt");

if( $copern == 1001 ) {

$datpm=$kli_vrok."-".$kli_vmes."-01";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" 0,'$kli_vume','$datpm',uce,0,0,0,0,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_uctosnova ".
" WHERE LEFT(uce,1) = 5 ";

//echo $dsqlt;
//exit;

$dsql = mysql_query("$dsqlt");
                      }

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
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" 0,ume,dat,ucm,ucd,".$databaza."F$kli_vxcfx"."_$uctovanie.hod,0,0,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_$uctovanie,".$databaza."F$kli_vxcfx"."_$doklad".
" WHERE ".$databaza."F$kli_vxcfx"."_$uctovanie.dok=".$databaza."F$kli_vxcfx"."_$doklad.dok AND ( LEFT(ucm,1) < 9 OR LEFT(ucd,1) < 9 ) ";
//echo $dsqlt."<br />";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" 0,ume,dat,ucm,ucd,hod,0,0,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_$uctovanie".
" WHERE LEFT(ucd,1) < 9 ";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }


//vloz stranu dal
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" rok,ume,dat,ucd,0,-(hod),0,0,0 ".
" FROM F$kli_vxcf"."_prcanagrfx$kli_uzid".
" WHERE konx = 0 ";
" ";
$dsql = mysql_query("$dsqlt");

//exit;

//vypocitaj ume,rok z dat
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfx$kli_uzid SET ume=MONTH(dat)+(YEAR(dat)/10000), rok=YEAR(dat) WHERE konx = 0";
$oznac = mysql_query("$sqtoz");

//vloz zamestnancov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" '$xrok',ume,'0000-00-00',9999001,0,1,0,0,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_mzdzalkun ".
" WHERE pom = 0 OR pom = 1 ";
" ";
$dsql = mysql_query("$dsqlt");

//vloz pocet mesiacov
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfx$kli_uzid"." SELECT".
" '$xrok',ume,'0000-00-00',9999002,0,1,0,0,0 ".
" FROM ".$databaza."F$kli_vxcfx"."_mzdzalkun ".
" WHERE pom = 0 OR pom = 1 GROUP BY ume ";
" ";
$dsql = mysql_query("$dsqlt");

//exit;

if( $h_obdp > 1 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prcanagrfx$kli_uzid  WHERE ume < $mes_obdp ";
$dsql = mysql_query("$dsqlt");
}
if( $h_obdk < 12 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_prcanagrfx$kli_uzid  WHERE ume > $mes_obdk ";
$dsql = mysql_query("$dsqlt");
}


//sumar za ucty
if( $copern == 1001 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfy$kli_uzid"." SELECT".
" rok,ume,dat,uce,0,SUM(hod),0,0,0 ".
" FROM F$kli_vxcf"."_prcanagrfx$kli_uzid".
" WHERE konx = 0 GROUP BY uce,ume ";
$dsql = mysql_query("$dsqlt");

$kkx=1; $prp="y"; $akekkx=1;

                      }

if( $copern == 1002 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrfb$kli_uzid"." SELECT".
" rok,$mes_obdk,dat,uce,0,SUM(hod),0,0,0 ".
" FROM F$kli_vxcf"."_prcanagrfx$kli_uzid".
" WHERE konx = 0 GROUP BY uce ";
$dsql = mysql_query("$dsqlt");

$kkx=2; $prp="b"; $akekkx=2;

                      }

//exit;

$lenjedenrok=$lenjedenrok+1;
//koniec while( $lenjedenrok <= 5 ) 
                                  }

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfx".$kli_uzid;
$vysledok = mysql_query($sql);

//vyrob suvahove riadky

while( $kkx == $akekkx )
         {

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET csv=F$kli_vxcf"."_uctosnova.crs".
" WHERE LEFT(F$kli_vxcf"."_prcanagrf$prp$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_uctosnova.uce,3) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET csv=F$kli_vxcf"."_uctosnova.crs".
" WHERE F$kli_vxcf"."_prcanagrf$prp$kli_uzid.uce = F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");

//aktiva/pasiva zmen podla znamienka zostatku
//andrejko tuto pracuje

$pols=0;
$sqltts = "SELECT * FROM F$kli_vxcf"."_uctsyngensuv WHERE dok > 0 ";
$sqls = mysql_query("$sqltts"); 
if( $sqls ) { $pols = mysql_num_rows($sqls); }
if( $pols > 0 ) {
$is=0; 
while ($is < $pols )  
{
if (@$zaznams=mysql_data_seek($sqls,$is)) 
  { 
$polozkas=mysql_fetch_object($sqls); 


$suma=0;
$sqlddd = "SELECT SUM(hod) AS suma FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid WHERE csv = $polozkas->ucm AND rok = $xrok ";
$sqldok = mysql_query("$sqlddd");
  if (@$zaznam=mysql_data_seek($sqldok,0))
    {
    $riaddok=mysql_fetch_object($sqldok);
    $suma=1*$riaddok->suma;
    }

if( $suma < 0 )
    {
$sqlddd = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid SET csv=$polozkas->ucd WHERE csv = $polozkas->ucm AND rok = $xrok ";
$sqldok = mysql_query("$sqlddd");
//echo $suma." idem<br />"; 
    }

  }
$is=$is+1;                   
}
                }

//exit;

//koniec aktiva/pasiva zmen podla znamienka zostatku

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid SET hod=-1*hod WHERE csv >= 66 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid"." SELECT".
" rok,ume,dat,uce,0,SUM(hod),1,0,csv ".
" FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 0 AND csv != 0 GROUP BY rok,csv ";
$dsql = mysql_query("$dsqlt");

//vypocitaj riadky strana 8
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,121 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 122 AND csv <= 125 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,118 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 119 AND csv <= 120 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,106 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 107 AND csv <= 116 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");


//vypocitaj riadky strana 7a6pasiva
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,94 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 95 AND csv <= 105 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,89 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 90 AND csv <= 93 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,88 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND ( csv = 89 OR csv = 94 OR csv = 106 OR csv = 116 OR csv = 118 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,84 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 85 AND csv <= 86 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,80 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 81 AND csv <= 83 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,73 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 74 AND csv <= 79 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,68 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 69 AND csv <= 72 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,67 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND ( csv = 68 OR csv = 73 OR csv = 80 OR csv = 84 OR csv = 87 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

//vypocitaj strana 2 az 6aktiva
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,61 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 62 AND csv <= 65 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,55 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 56 AND csv <= 60 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,46 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 47 AND csv <= 54 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,38 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 39 AND csv <= 45 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,31 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 32 AND csv <= 37 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,30 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND ( csv = 31 OR csv = 38 OR csv = 46 OR csv = 55 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,21 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 22 AND csv <= 29 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,11 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 12 AND csv <= 20 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,03 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND csv >= 04 AND csv <= 10 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,02 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND ( csv = 3 OR csv = 11 OR csv = 21 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),1,0,01 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 1 AND ( csv = 2 OR csv = 30 OR csv = 61 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

//exit;


//vyrob vykziskove riadky
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET cvz=F$kli_vxcf"."_uctosnova.crv".
" WHERE LEFT(F$kli_vxcf"."_prcanagrf$prp$kli_uzid.uce,3) = LEFT(F$kli_vxcf"."_uctosnova.uce,3) ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid,F$kli_vxcf"."_uctosnova".
" SET cvz=F$kli_vxcf"."_uctosnova.crv".
" WHERE F$kli_vxcf"."_prcanagrf$prp$kli_uzid.uce = F$kli_vxcf"."_uctosnova.uce ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrf$prp$kli_uzid SET hod=-1*hod WHERE LEFT(uce,1) = 6 ";
$oznac = mysql_query("$sqtoz");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid"." SELECT".
" rok,ume,dat,uce,0,SUM(hod),2,cvz,0 ".
" FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 0 AND cvz != 0 GROUP BY rok,cvz ";
$dsql = mysql_query("$dsqlt");

//vypocitaj riadky
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,03,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 01 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,03,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 02 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,04,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 05 AND cvz <= 07 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,08,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 09 AND cvz <= 10 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,11,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 03 AND cvz <= 04 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,11,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 08 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,12,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 13 AND cvz <= 16 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,26,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 11 OR cvz = 19 OR cvz = 22 OR cvz = 24 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,26,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 12 OR cvz = 17 OR cvz = 18 OR cvz = 20 OR cvz = 21 OR cvz = 23 OR cvz = 25 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,29,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 30 AND cvz <= 32 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,46,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 27 OR cvz = 29 OR cvz = 33 OR cvz = 35 OR cvz = 38 OR cvz = 40 OR cvz = 42 OR cvz = 44 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,46,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 28 OR cvz = 34 OR cvz = 36 OR cvz = 37 OR cvz = 39 OR cvz = 41 OR cvz = 43 OR cvz = 45 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,47,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 26 OR cvz = 46 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,48,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 49 AND cvz <= 50 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,51,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 47 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,51,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 48 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,54,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 52 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,54,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 53 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,55,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz >= 56 AND cvz <= 57 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,58,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 54 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,58,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 55 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,59,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 47 OR cvz = 54 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,SUM(hod),2,61,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND ( cvz = 51 OR cvz = 58 ) GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcanagrf$prp$kli_uzid SELECT rok,ume,dat,0,0,-SUM(hod),2,61,0 FROM F$kli_vxcf"."_prcanagrf$prp$kli_uzid".
" WHERE konx = 2 AND cvz = 60 GROUP BY rok,konx ";
$dsql = mysql_query("$dsqlt");

$kkx=$kkx+1;
         }

$katg=1;
}
//koniec bezny a minuly zdroj 

//pomerove ukazovatele katg = 1 
if( $katg == 1 )
{
//exit;

$sqlt = <<<uctcrv
(
   katg          DECIMAL(4,0) DEFAULT 0,
   cellikv       DECIMAL(10,2) DEFAULT 0,
   bezlikv       DECIMAL(10,2) DEFAULT 0,
   pohlikv       DECIMAL(10,2) DEFAULT 0,
   plnesch       DECIMAL(10,2) DEFAULT 0,
   inkpohl       DECIMAL(10,0) DEFAULT 0,
   splazav       DECIMAL(10,0) DEFAULT 0,
   dobrzas       DECIMAL(10,0) DEFAULT 0,
   obrtzas       DECIMAL(10,2) DEFAULT 0,
   renakt        DECIMAL(10,2) DEFAULT 0,
   rentrz        DECIMAL(10,2) DEFAULT 0,
   rennak        DECIMAL(10,2) DEFAULT 0,
   urokry        DECIMAL(10,2) DEFAULT 0,
   urozat        DECIMAL(10,2) DEFAULT 0,
   momarze5      DECIMAL(10,2) DEFAULT 0,
   momarze4      DECIMAL(10,2) DEFAULT 0,
   momarze3      DECIMAL(10,2) DEFAULT 0,
   momarze2      DECIMAL(10,2) DEFAULT 0,
   momarze1      DECIMAL(10,2) DEFAULT 0,
   celzadl5      DECIMAL(10,2) DEFAULT 0,
   celzadl4      DECIMAL(10,2) DEFAULT 0,
   celzadl3      DECIMAL(10,2) DEFAULT 0,
   celzadl2      DECIMAL(10,2) DEFAULT 0,
   celzadl1      DECIMAL(10,2) DEFAULT 0,
   uvezadl5      DECIMAL(10,2) DEFAULT 0,
   uvezadl4      DECIMAL(10,2) DEFAULT 0,
   uvezadl3      DECIMAL(10,2) DEFAULT 0,
   uvezadl2      DECIMAL(10,2) DEFAULT 0,
   uvezadl1      DECIMAL(10,2) DEFAULT 0,
   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfv".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.' ( katg ) VALUES ( 1 ) ';
$vytvor = mysql_query("$vsql");

//celkov· likvidita: Beûn· aktÌva/Kr·tkodobÈ z·v‰zky = S030/(S093+S106+S120+S117+S121)
$hore=0; $dole=0; $cellikv=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 30 OR csv = 93 OR csv = 106 OR csv = 120 OR csv = 117 OR csv = 121 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 30 ) { $hore=$hore+$polozka->hod; }
if( $polozka->csv != 30 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET cellikv=$hore/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//beûn· likvidita: (FinaËnÈ ˙Ëty+Kr·tkodobÈ pohæad·vky)/Kr·tkodobÈ z·v‰zky = ((S055-S058)+S046)/(S093+S106+S120+S117+S121)
$hore=0; $dole=0; $bezlikv=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 55 OR csv = 58 OR csv = 46 OR csv = 106 OR csv = 120 OR csv = 117 OR csv = 121 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv < 90 ) { $hore=$hore+$polozka->hod; }
if( $polozka->csv > 90 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET bezlikv=$hore/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//pohotov· likvidita: FinanËnÈ ˙Ëty/Kr·tkodobÈ z·v‰zky = (S055-S058)/(S093+S106+S120+S117+S121)
$hore=0; $dole=0; $pohlikv=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 55 OR csv = 58 OR csv = 93 OR csv = 106 OR csv = 120 OR csv = 117 OR csv = 121 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv < 90 ) { $hore=$hore+$polozka->hod; }
if( $polozka->csv > 90 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET pohlikv=$hore/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//platobn· neshopnosù: Kr·tkodobÈ z·v‰zky/Pohæad·vky = (S093+S106+S120+S117+S121)/(S046+S038)
$hore=0; $dole=0; $plnesch=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 93 OR csv = 106 OR csv = 120 OR csv = 117 OR csv = 121 OR csv = 46 OR csv = 38 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv > 90 ) { $hore=$hore+$polozka->hod; }
if( $polozka->csv < 90 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET plnesch=$hore/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//Doba inkasa pohæad·vok: (Pohæad·vky/Trûby)xPoËet dnÌ = ((S046+S038)x365)/skupina60
$hore=0; $dole=0; $inkpohl=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 46 OR csv = 38 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv < 90 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,2) = 60 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET inkpohl=($hore*365)/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//Doba spl·cania z·v‰zkov: (Z·v‰zky/N·klady)xPoËet dnÌ = ((S094+S106)x365/trieda5)
$hore=0; $dole=0; $splazav=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 94 OR csv = 106 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv < 110 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 5 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET splazav=($hore*365)/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//Doba obratu z·sob: Z·soby/(Trûby/PoËet dnÌ) = S031x365/(skupina60)
$hore=0; $dole=0; $dobrzas=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 031 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv < 110 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 6 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET dobrzas=($hore*365)/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//Obrat z·sob: Trûby/Z·soby = skupina60/S031
$hore=0; $dole=0; $obrtzas=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,2) = 60 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 031 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv < 110 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }


if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET obrtzas=$hore/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//rentabilita aktÌv: (EAT/AktÌva)x100 = (V051/S001)
$hore=0; $dole=0; $renakt=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 2 AND ( cvz = 51 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 1 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql);  
if( $polozka->csv >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET renakt=100*($hore/$dole) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//rentabilita trûieb: (EAT/Trûby)x100 = (V051/skupina60)x100
$hore=0; $dole=0; $rentrz=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 2 AND ( cvz = 51 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 6 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET rentrz=100*($hore/$dole) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//rentabilita n·kladov: (EAT/N·klady)x100 = (V051/trieda5)x100
$hore=0; $dole=0; $rennak=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 2 AND ( cvz = 51 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 5 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET rennak=100*($hore/$dole) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//˙rokovÈ krytie: EBIT/N·kladovÈ ˙roky = (V47+562)/562
$hore=0; $dole=0; $urokry=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 2 AND ( cvz = 47 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,3) = 562 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET urokry=($hore+$dole)/$dole WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//˙rokovÈ zaùaûenie: (N·kladovÈ ˙roky/EBIT)x100 = (562/V47+562)x100
$hore=0; $dole=0; $urozat=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,3) = 562 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $hore=$hore+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 2 AND ( cvz = 47 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $dole=$dole+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET urozat=100*($hore/($hore+$dole)) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }


//miera obchodnej marûe: (Obchodn· marûa/Trûby z predaja tovaru)x100 = (V03/604)x100
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 2 AND ( cvz = 3 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $hore5=$hore5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,3) = 604 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $dole5=$dole5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 2 AND ( cvz = 3 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $hore1=$hore1+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 0 AND LEFT(uce,3) = 604 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $dole1=$dole1+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole5 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET momarze5=100*($hore5/$dole5) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole4 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET momarze4=100*($hore4/$dole4) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole3 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET momarze3=100*($hore3/$dole3) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole2 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET momarze2=100*($hore2/$dole2) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole1 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET momarze1=100*($hore1/$dole1) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//celkov· zadlûenosù: (CudzÌ kapit·l/AktÌva)x100 = ((S088+S121)/S001)x100
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1  AND ( csv = 88 OR csv = 121 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore5=$hore5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND csv = 1 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $dole5=$dole5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND ( csv = 88 OR csv = 121 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $hore1=$hore1+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND csv = 1 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $dole1=$dole1+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole5 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET celzadl5=100*($hore5/$dole5) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole4 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET celzadl4=100*($hore4/$dole4) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole3 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET celzadl3=100*($hore3/$dole3) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole2 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET celzadl2=100*($hore2/$dole2) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole1 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET celzadl1=100*($hore1/$dole1) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

//˙verov· zadlûenosù: (BankovÈ pÙûiËky a v˝pomoci/AktÌva)x100 = ((S117+S118)/S001)
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1  AND ( csv = 117 OR csv = 118 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore5=$hore5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND csv = 1 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->cvz >= 0 ) { $dole5=$dole5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND ( csv = 117 OR csv = 118 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $hore1=$hore1+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND csv = 1 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $dole1=$dole1+$polozka->hod; }
}
$i=$i+1;                   }

if( $dole5 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET uvezadl5=100*($hore5/$dole5) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole4 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET uvezadl4=100*($hore4/$dole4) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole3 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET uvezadl3=100*($hore3/$dole3) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole2 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET uvezadl2=100*($hore2/$dole2) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }
if( $dole1 != 0 )
     {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET uvezadl1=100*($hore1/$dole1) WHERE katg = 1 ";
$oznac = mysql_query("$sqtoz");
     }

}
//koniec pomerove ukazovatele katg = 1


//grafy aktiva katg = 2 
if( $katg == 2 )
{
$sqlt = <<<uctcrv
(
   katg          DECIMAL(4,0) DEFAULT 0,
   staktdl       DECIMAL(10,2) DEFAULT 0,
   staktob       DECIMAL(10,2) DEFAULT 0,
   staktcs       DECIMAL(10,2) DEFAULT 0,
   stobmzs       DECIMAL(10,2) DEFAULT 0,
   stobmdp       DECIMAL(10,2) DEFAULT 0,
   stobmkp       DECIMAL(10,2) DEFAULT 0,
   stobmfu       DECIMAL(10,2) DEFAULT 0,
   vjobpoh5      DECIMAL(10,2) DEFAULT 0,
   vjobpoh4      DECIMAL(10,2) DEFAULT 0,
   vjobpoh3      DECIMAL(10,2) DEFAULT 0,
   vjobpoh2      DECIMAL(10,2) DEFAULT 0,
   vjobpoh1      DECIMAL(10,2) DEFAULT 0,
   stfupen       DECIMAL(10,2) DEFAULT 0,
   stfuban       DECIMAL(10,2) DEFAULT 0,
   stfudlb       DECIMAL(10,2) DEFAULT 0,
   stfukfm       DECIMAL(10,2) DEFAULT 0,
   stfuofm       DECIMAL(10,2) DEFAULT 0,
   penze01       DECIMAL(10,2) DEFAULT 0,
   penze02       DECIMAL(10,2) DEFAULT 0,
   penze03       DECIMAL(10,2) DEFAULT 0,
   penze04       DECIMAL(10,2) DEFAULT 0,
   penze05       DECIMAL(10,2) DEFAULT 0,
   penze06       DECIMAL(10,2) DEFAULT 0,
   penze07       DECIMAL(10,2) DEFAULT 0,
   penze08       DECIMAL(10,2) DEFAULT 0,
   penze09       DECIMAL(10,2) DEFAULT 0,
   penze10       DECIMAL(10,2) DEFAULT 0,
   penze11       DECIMAL(10,2) DEFAULT 0,
   penze12       DECIMAL(10,2) DEFAULT 0,
   banka01       DECIMAL(10,2) DEFAULT 0,
   banka02       DECIMAL(10,2) DEFAULT 0,
   banka03       DECIMAL(10,2) DEFAULT 0,
   banka04       DECIMAL(10,2) DEFAULT 0,
   banka05       DECIMAL(10,2) DEFAULT 0,
   banka06       DECIMAL(10,2) DEFAULT 0,
   banka07       DECIMAL(10,2) DEFAULT 0,
   banka08       DECIMAL(10,2) DEFAULT 0,
   banka09       DECIMAL(10,2) DEFAULT 0,
   banka10       DECIMAL(10,2) DEFAULT 0,
   banka11       DECIMAL(10,2) DEFAULT 0,
   banka12       DECIMAL(10,2) DEFAULT 0,
   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfv".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.' ( katg ) VALUES ( 2 ) ';
$vytvor = mysql_query("$vsql");

//ötrukt˙ra aktÌv: Dlhodob˝ majetok, Obeûn˝ majetok a »asovÈ rozlÌöenie = hodnoty riadkov S002,S030 a S061
$staktdl=0; $staktob=0; $staktcs=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 2 OR csv = 30 OR csv = 61 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 2  ) { $staktdl=$staktdl+$polozka->hod; }
if( $polozka->csv == 30 ) { $staktob=$staktob+$polozka->hod; }
if( $polozka->csv == 61 ) { $staktcs=$staktcs+$polozka->hod; }
}
$i=$i+1;                   }

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET staktdl=$staktdl, staktob=$staktob, staktcs=$staktcs  WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");


// ötrukt˙ra obeûnÈho majetku: Z·soby, DlhodobÈ pohæad·vky, Kr·tkodobÈ pohæad·vky a FinanËnÈ ˙Ëty = hodnoty riadkov S031,S038,S046 a S055
$stobmzs=0; $stobmdp=0; $stobmkp=0; $stobmfu=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 31 OR csv = 38 OR csv = 46 OR csv = 55 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 31 ) { $stobmzs=$stobmzs+$polozka->hod; }
if( $polozka->csv == 38 ) { $stobmdp=$stobmdp+$polozka->hod; }
if( $polozka->csv == 46 ) { $stobmkp=$stobmkp+$polozka->hod; }
if( $polozka->csv == 55 ) { $stobmfu=$stobmfu+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stobmzs=$stobmzs, stobmdp=$stobmdp, stobmkp=$stobmkp, stobmfu=$stobmfu  WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");


//medziroËn˝ v˝voj ˙Ëtu "Pohæad·vky z obchodnÈho styku": Kr·tkodobÈ i DlhodobÈ Pohæad·vky z obchodnÈho styku = roËnÈ s˙Ëty hodnÙt riadkov S039+S047
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1  AND ( csv = 39 OR csv = 47 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore5=$hore5+$polozka->hod; }
}
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND ( csv = 39 OR csv = 47 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $hore1=$hore1+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjobpoh5=$hore5 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjobpoh4=$hore4 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjobpoh3=$hore3 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjobpoh2=$hore2 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjobpoh1=$hore1 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");


//ötrukt˙ra finanËn˝ch ˙Ëtov: Peniaze, ⁄Ëty v bank·ch, ⁄Ëty v bank·ch viac ako 1 rok, Kr·tkodob˝ FM a Obstar·van˝ FM = hodnoty riadkov S056,S057,S058,S059 a S060
$stfupen=0; $stfuban=0; $stfudlb=0; $stfukfm=0; $stfuofm=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 56 OR csv = 57 OR csv = 58 OR csv = 59 OR csv = 60 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 56 ) { $stfupen=$stfupen+$polozka->hod; }
if( $polozka->csv == 57 ) { $stfuban=$stfuban+$polozka->hod; }
if( $polozka->csv == 58 ) { $stfudlb=$stfudlb+$polozka->hod; }
if( $polozka->csv == 59 ) { $stfukfm=$stfukfm+$polozka->hod; }
if( $polozka->csv == 60 ) { $stfuofm=$stfuofm+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stfupen=$stfupen, stfuban=$stfuban, stfudlb=$stfudlb, stfukfm=$stfukfm, stfuofm=$stfuofm WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");


//mesacny v˝voj ˙Ëtov "Peniaze" a "⁄Ëty v bank·ch": Peniaze, ⁄Ëty v bank·ch a ⁄Ëty v bank·ch viac ako 1 rok = mesaËnÈ hodnoty riadkov S056 a (S057+S058)
$mes01="1.".$kli_vrok; $mes02="2.".$kli_vrok; $mes03="3.".$kli_vrok; $mes04="4.".$kli_vrok; $mes05="5.".$kli_vrok; $mes06="6.".$kli_vrok; 
$mes07="7.".$kli_vrok; $mes08="8.".$kli_vrok; $mes09="9.".$kli_vrok; $mes10="10.".$kli_vrok; $mes11="11.".$kli_vrok; $mes12="12.".$kli_vrok;

$penze01=0; $penze02=0; $penze03=0; $penze04=0; $penze05=0; $penze06=0; $penze07=0; $penze08=0; $penze09=0; $penze10=0; $penze11=0; $penze12=0;
$banka01=0; $banka02=0; $banka03=0; $banka04=0; $banka05=0; $banka06=0; $banka07=0; $banka08=0; $banka09=0; $banka10=0; $banka11=0; $banka12=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,2) = 21 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 AND $polozka->ume <= $mes01 AND $kli_vume >= $mes01 ) { $penze01=$penze01+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes02 AND $kli_vume >= $mes02 ) { $penze02=$penze02+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes03 AND $kli_vume >= $mes03 ) { $penze03=$penze03+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes04 AND $kli_vume >= $mes04 ) { $penze04=$penze04+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes05 AND $kli_vume >= $mes05 ) { $penze05=$penze05+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes06 AND $kli_vume >= $mes06 ) { $penze06=$penze06+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes07 AND $kli_vume >= $mes07 ) { $penze07=$penze07+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes08 AND $kli_vume >= $mes08 ) { $penze08=$penze08+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes09 AND $kli_vume >= $mes09 ) { $penze09=$penze09+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes10 AND $kli_vume >= $mes10 ) { $penze10=$penze10+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes11 AND $kli_vume >= $mes11 ) { $penze11=$penze11+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes12 AND $kli_vume >= $mes12 ) { $penze12=$penze12+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0  AND LEFT(uce,2) = 22 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 AND $polozka->ume <= $mes01 AND $kli_vume >= $mes01 ) { $banka01=$banka01+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes02 AND $kli_vume >= $mes02 ) { $banka02=$banka02+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes03 AND $kli_vume >= $mes03 ) { $banka03=$banka03+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes04 AND $kli_vume >= $mes04 ) { $banka04=$banka04+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes05 AND $kli_vume >= $mes05 ) { $banka05=$banka05+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes06 AND $kli_vume >= $mes06 ) { $banka06=$banka06+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes07 AND $kli_vume >= $mes07 ) { $banka07=$banka07+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes08 AND $kli_vume >= $mes08 ) { $banka08=$banka08+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes09 AND $kli_vume >= $mes09 ) { $banka09=$banka09+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes10 AND $kli_vume >= $mes10 ) { $banka10=$banka10+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes11 AND $kli_vume >= $mes11 ) { $banka11=$banka11+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume <= $mes12 AND $kli_vume >= $mes12 ) { $banka12=$banka12+$polozka->hod; }
}
$i=$i+1;                   }

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET penze01=$penze01, penze02=$penze02, penze03=$penze03, penze04=$penze04 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET penze05=$penze05, penze06=$penze06, penze07=$penze07, penze08=$penze08 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET penze09=$penze09, penze10=$penze10, penze11=$penze11, penze12=$penze12 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET banka01=$banka01, banka02=$banka02, banka03=$banka03, banka04=$banka04 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET banka05=$banka05, banka06=$banka06, banka07=$banka07, banka08=$banka08 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET banka09=$banka09, banka10=$banka10, banka11=$banka11, banka12=$banka12 WHERE katg = 2 ";
$oznac = mysql_query("$sqtoz");

}
//koniec grafy aktiva katg = 2 


//grafy pasiva katg = 3 
if( $katg == 3 )
{

$sqlt = <<<uctcrv
(
   katg          DECIMAL(4,0) DEFAULT 0,
   stpasvi       DECIMAL(10,2) DEFAULT 0,
   stpaszv       DECIMAL(10,2) DEFAULT 0,
   stpascs       DECIMAL(10,2) DEFAULT 0,
   vjkruv5       DECIMAL(10,2) DEFAULT 0,
   vjkruv4       DECIMAL(10,2) DEFAULT 0,
   vjkruv3       DECIMAL(10,2) DEFAULT 0,
   vjkruv2       DECIMAL(10,2) DEFAULT 0,
   vjkruv1       DECIMAL(10,2) DEFAULT 0,
   vjdluv5       DECIMAL(10,2) DEFAULT 0,
   vjdluv4       DECIMAL(10,2) DEFAULT 0,
   vjdluv3       DECIMAL(10,2) DEFAULT 0,
   vjdluv2       DECIMAL(10,2) DEFAULT 0,
   vjdluv1       DECIMAL(10,2) DEFAULT 0,
   vjkrzv5       DECIMAL(10,2) DEFAULT 0,
   vjkrzv4       DECIMAL(10,2) DEFAULT 0,
   vjkrzv3       DECIMAL(10,2) DEFAULT 0,
   vjkrzv2       DECIMAL(10,2) DEFAULT 0,
   vjkrzv1       DECIMAL(10,2) DEFAULT 0,
   vjdlzv5       DECIMAL(10,2) DEFAULT 0,
   vjdlzv4       DECIMAL(10,2) DEFAULT 0,
   vjdlzv3       DECIMAL(10,2) DEFAULT 0,
   vjdlzv2       DECIMAL(10,2) DEFAULT 0,
   vjdlzv1       DECIMAL(10,2) DEFAULT 0,
   stzavrz       DECIMAL(10,2) DEFAULT 0,
   stzavdz       DECIMAL(10,2) DEFAULT 0,
   stzavkz       DECIMAL(10,2) DEFAULT 0,
   stzavfv       DECIMAL(10,2) DEFAULT 0,
   stzavbu       DECIMAL(10,2) DEFAULT 0,
   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfv".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.' ( katg ) VALUES ( 3 ) ';
$vytvor = mysql_query("$vsql");


//ötrukt˙ra pasÌv: VlastnÈ imanie, Z·v‰zky a »asovÈ rozlÌöenie = hodnoty riadkov S067,S088 a S121
$stpasvi=0; $stpaszv=0; $stpascs=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 67 OR csv = 88 OR csv = 121 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 67  ) { $stpasvi=$stpasvi+$polozka->hod; }
if( $polozka->csv == 88  ) { $stpaszv=$stpaszv+$polozka->hod; }
if( $polozka->csv == 121 ) { $stpascs=$stpascs+$polozka->hod; }
}
$i=$i+1;                   }

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stpasvi=$stpasvi, stpaszv=$stpaszv, stpascs=$stpascs  WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

//medziroËn˝ v˝voj dlhodob˝ch/beûn˝ch Bankov˝ch ˙verov: BankovÈ ˙very dlhodobÈ a BeûnÈ bankovÈ ˙very = roËnÈ hodnoty na riadkoch S119 a S120
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1  AND ( csv = 119 OR csv = 120 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 120 ) { $hore5=$hore5+$polozka->hod; }
if( $polozka->csv == 119 ) { $dole5=$dole5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND ( csv = 119 OR csv = 120 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 AND  $polozka->csv == 120 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 AND  $polozka->csv == 120 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 AND  $polozka->csv == 120 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 AND  $polozka->csv == 120 ) { $hore1=$hore1+$polozka->hod; }
if( $polozka->rok == $rok4 AND  $polozka->csv == 119 ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 AND  $polozka->csv == 119 ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 AND  $polozka->csv == 119 ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 AND  $polozka->csv == 119 ) { $dole1=$dole1+$polozka->hod; }
}
$i=$i+1;                   }

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkruv5=$hore5 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkruv4=$hore4 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkruv3=$hore3 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkruv2=$hore2 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkruv1=$hore1 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdluv5=$dole5 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdluv4=$dole4 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdluv3=$dole3 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdluv2=$dole2 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdluv1=$dole1 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");


//medziroËn˝ v˝voj dlhodob˝ch/kr·tkodob˝ch Z·v‰zkov z obchodnÈho styku = roËnÈ hodnoty na riadkoch S107 a S095
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1  AND ( csv = 107 OR csv = 95 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 107 ) { $hore5=$hore5+$polozka->hod; }
if( $polozka->csv == 95  ) { $dole5=$dole5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 1 AND ( csv = 107 OR csv = 95 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 AND  $polozka->csv == 107 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 AND  $polozka->csv == 107 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 AND  $polozka->csv == 107 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 AND  $polozka->csv == 107 ) { $hore1=$hore1+$polozka->hod; }
if( $polozka->rok == $rok4 AND  $polozka->csv == 95  ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 AND  $polozka->csv == 95  ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 AND  $polozka->csv == 95  ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 AND  $polozka->csv == 95  ) { $dole1=$dole1+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkrzv5=$hore5 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkrzv4=$hore4 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkrzv3=$hore3 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkrzv2=$hore2 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjkrzv1=$hore1 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdlzv5=$dole5 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdlzv4=$dole4 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdlzv3=$dole3 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdlzv2=$dole2 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjdlzv1=$dole1 WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");


//ötrukt˙ra z·v‰zkov: Rezervy, DlhodobÈ z·v‰zky, Kr·tkodobÈ z·v‰zky, Kr·tk.finan.v˝pomoci a Ban.˙very = hodnoty riadkov S089,S094,S106,S117 a S118
$stzavrz=0; $stzavdz=0; $stzavkz=0; $stzavfv=0; $stzavbu=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 1 AND ( csv = 89 OR csv = 94 OR csv = 106 OR csv = 117 OR csv = 118 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv == 89  ) { $stzavrz=$stzavrz+$polozka->hod; }
if( $polozka->csv == 94  ) { $stzavdz=$stzavdz+$polozka->hod; }
if( $polozka->csv == 106 ) { $stzavkz=$stzavkz+$polozka->hod; }
if( $polozka->csv == 117 ) { $stzavfv=$stzavfv+$polozka->hod; }
if( $polozka->csv == 118 ) { $stzavbu=$stzavbu+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stzavrz=$stzavrz, stzavdz=$stzavdz, stzavkz=$stzavkz, stzavfv=$stzavfv, stzavbu=$stzavbu WHERE katg = 3 ";
$oznac = mysql_query("$sqtoz");

}
//koniec grafy pasiva katg = 3 


//grafy hospodarenie katg = 4 
if( $katg == 4 )
{
$sqlt = <<<uctcrv
(
   katg          DECIMAL(4,0) DEFAULT 0,
   vjnakl5       DECIMAL(10,2) DEFAULT 0,
   vjnakl4       DECIMAL(10,2) DEFAULT 0,
   vjnakl3       DECIMAL(10,2) DEFAULT 0,
   vjnakl2       DECIMAL(10,2) DEFAULT 0,
   vjnakl1       DECIMAL(10,2) DEFAULT 0,
   vjvyno5       DECIMAL(10,2) DEFAULT 0,
   vjvyno4       DECIMAL(10,2) DEFAULT 0,
   vjvyno3       DECIMAL(10,2) DEFAULT 0,
   vjvyno2       DECIMAL(10,2) DEFAULT 0,
   vjvyno1       DECIMAL(10,2) DEFAULT 0,
   vjzisk5       DECIMAL(10,2) DEFAULT 0,
   vjzisk4       DECIMAL(10,2) DEFAULT 0,
   vjzisk3       DECIMAL(10,2) DEFAULT 0,
   vjzisk2       DECIMAL(10,2) DEFAULT 0,
   vjzisk1       DECIMAL(10,2) DEFAULT 0,

   msnakl01      DECIMAL(10,2) DEFAULT 0,
   msnakl02      DECIMAL(10,2) DEFAULT 0,
   msnakl03      DECIMAL(10,2) DEFAULT 0,
   msnakl04      DECIMAL(10,2) DEFAULT 0,
   msnakl05      DECIMAL(10,2) DEFAULT 0,
   msnakl06      DECIMAL(10,2) DEFAULT 0,
   msnakl07      DECIMAL(10,2) DEFAULT 0,
   msnakl08      DECIMAL(10,2) DEFAULT 0,
   msnakl09      DECIMAL(10,2) DEFAULT 0,
   msnakl10      DECIMAL(10,2) DEFAULT 0,
   msnakl11      DECIMAL(10,2) DEFAULT 0,
   msnakl12      DECIMAL(10,2) DEFAULT 0,

   msvyno01      DECIMAL(10,2) DEFAULT 0,
   msvyno02      DECIMAL(10,2) DEFAULT 0,
   msvyno03      DECIMAL(10,2) DEFAULT 0,
   msvyno04      DECIMAL(10,2) DEFAULT 0,
   msvyno05      DECIMAL(10,2) DEFAULT 0,
   msvyno06      DECIMAL(10,2) DEFAULT 0,
   msvyno07      DECIMAL(10,2) DEFAULT 0,
   msvyno08      DECIMAL(10,2) DEFAULT 0,
   msvyno09      DECIMAL(10,2) DEFAULT 0,
   msvyno10      DECIMAL(10,2) DEFAULT 0,
   msvyno11      DECIMAL(10,2) DEFAULT 0,
   msvyno12      DECIMAL(10,2) DEFAULT 0,

   mszisk01      DECIMAL(10,2) DEFAULT 0,
   mszisk02      DECIMAL(10,2) DEFAULT 0,
   mszisk03      DECIMAL(10,2) DEFAULT 0,
   mszisk04      DECIMAL(10,2) DEFAULT 0,
   mszisk05      DECIMAL(10,2) DEFAULT 0,
   mszisk06      DECIMAL(10,2) DEFAULT 0,
   mszisk07      DECIMAL(10,2) DEFAULT 0,
   mszisk08      DECIMAL(10,2) DEFAULT 0,
   mszisk09      DECIMAL(10,2) DEFAULT 0,
   mszisk10      DECIMAL(10,2) DEFAULT 0,
   mszisk11      DECIMAL(10,2) DEFAULT 0,
   mszisk12      DECIMAL(10,2) DEFAULT 0,

   stnakl1       DECIMAL(10,2) DEFAULT 0,
   stnakl2       DECIMAL(10,2) DEFAULT 0,
   stnakl3       DECIMAL(10,2) DEFAULT 0,
   stnakl4       DECIMAL(10,2) DEFAULT 0,
   stnakl5       DECIMAL(10,2) DEFAULT 0,
   stnakl6       DECIMAL(10,2) DEFAULT 0,
   stnakl7       DECIMAL(10,2) DEFAULT 0,
   stnakl8       DECIMAL(10,2) DEFAULT 0,
   stnakl9       DECIMAL(10,2) DEFAULT 0,
   stnakl10      DECIMAL(10,2) DEFAULT 0,

   stvyno1       DECIMAL(10,2) DEFAULT 0,
   stvyno2       DECIMAL(10,2) DEFAULT 0,
   stvyno3       DECIMAL(10,2) DEFAULT 0,
   stvyno4       DECIMAL(10,2) DEFAULT 0,
   stvyno5       DECIMAL(10,2) DEFAULT 0,
   stvyno6       DECIMAL(10,2) DEFAULT 0,
   stvyno7       DECIMAL(10,2) DEFAULT 0,
   stvyno8       DECIMAL(10,2) DEFAULT 0,
   stvyno9       DECIMAL(10,2) DEFAULT 0,
   stvyno10      DECIMAL(10,2) DEFAULT 0,

   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfv".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.' ( katg ) VALUES ( 4 ) ';
$vytvor = mysql_query("$vsql");




//medziroËn˝ v˝voj nakladov, vynosov, trzieb
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND ( LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$uce1=substr($polozka->uce,0,1);
if( $uce1 == 5 ) { $hore5=$hore5+$polozka->hod; }
if( $uce1 == 6 ) { $dole5=$dole5+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 0 AND ( LEFT(uce,1) = 5 OR LEFT(uce,1) = 6 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$uce1=substr($polozka->uce,0,1);
if( $polozka->rok == $rok4 AND  $uce1 == 5 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 AND  $uce1 == 5 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 AND  $uce1 == 5 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 AND  $uce1 == 5 ) { $hore1=$hore1+$polozka->hod; }
if( $polozka->rok == $rok4 AND  $uce1 == 6 ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 AND  $uce1 == 6 ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 AND  $uce1 == 6 ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 AND  $uce1 == 6 ) { $dole1=$dole1+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjnakl5=$hore5 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjnakl4=$hore4 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjnakl3=$hore3 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjnakl2=$hore2 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjnakl1=$hore1 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjvyno5=$dole5 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjvyno4=$dole4 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjvyno3=$dole3 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjvyno2=$dole2 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjvyno1=$dole1 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzisk1=vjvyno1-vjnakl1 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzisk2=vjvyno2-vjnakl2 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzisk3=vjvyno3-vjnakl3 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzisk4=vjvyno4-vjnakl4 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzisk5=vjvyno5-vjnakl5 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

//mesacny v˝voj naklady, vynosy, zisk
$mes01="1.".$kli_vrok; $mes02="2.".$kli_vrok; $mes03="3.".$kli_vrok; $mes04="4.".$kli_vrok; $mes05="5.".$kli_vrok; $mes06="6.".$kli_vrok; 
$mes07="7.".$kli_vrok; $mes08="8.".$kli_vrok; $mes09="9.".$kli_vrok; $mes10="10.".$kli_vrok; $mes11="11.".$kli_vrok; $mes12="12.".$kli_vrok;

$msnakl01=0; $msnakl02=0; $msnakl03=0; $msnakl04=0; $msnakl05=0; $msnakl06=0; $msnakl07=0; $msnakl08=0; $msnakl09=0; $msnakl10=0; $msnakl11=0; $msnakl12=0;
$msvyno01=0; $msvyno02=0; $msvyno03=0; $msvyno04=0; $msvyno05=0; $msvyno06=0; $msvyno07=0; $msvyno08=0; $msvyno09=0; $msvyno10=0; $msvyno11=0; $msvyno12=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 5 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 AND $polozka->ume == $mes01  ) { $msnakl01=$msnakl01+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes02  ) { $msnakl02=$msnakl02+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes03  ) { $msnakl03=$msnakl03+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes04  ) { $msnakl04=$msnakl04+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes05  ) { $msnakl05=$msnakl05+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes06  ) { $msnakl06=$msnakl06+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes07  ) { $msnakl07=$msnakl07+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes08  ) { $msnakl08=$msnakl08+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes09  ) { $msnakl09=$msnakl09+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes10  ) { $msnakl10=$msnakl10+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes11  ) { $msnakl11=$msnakl11+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes12  ) { $msnakl12=$msnakl12+$polozka->hod; }
}
$i=$i+1;                   }

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 6 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 AND $polozka->ume == $mes01  ) { $msvyno01=$msvyno01+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes02  ) { $msvyno02=$msvyno02+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes03  ) { $msvyno03=$msvyno03+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes04  ) { $msvyno04=$msvyno04+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes05  ) { $msvyno05=$msvyno05+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes06  ) { $msvyno06=$msvyno06+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes07  ) { $msvyno07=$msvyno07+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes08  ) { $msvyno08=$msvyno08+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes09  ) { $msvyno09=$msvyno09+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes10  ) { $msvyno10=$msvyno10+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes11  ) { $msvyno11=$msvyno11+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes12  ) { $msvyno12=$msvyno12+$polozka->hod; }
}
$i=$i+1;                   }

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET msnakl01=$msnakl01, msnakl02=$msnakl02, msnakl03=$msnakl03, msnakl04=$msnakl04 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET msnakl05=$msnakl05, msnakl06=$msnakl06, msnakl07=$msnakl07, msnakl08=$msnakl08 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET msnakl09=$msnakl09, msnakl10=$msnakl10, msnakl11=$msnakl11, msnakl12=$msnakl12 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET msvyno01=$msvyno01, msvyno02=$msvyno02, msvyno03=$msvyno03, msvyno04=$msvyno04 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET msvyno05=$msvyno05, msvyno06=$msvyno06, msvyno07=$msvyno07, msvyno08=$msvyno08 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET msvyno09=$msvyno09, msvyno10=$msvyno10, msvyno11=$msvyno11, msvyno12=$msvyno12 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mszisk01=msvyno01-msnakl01, mszisk02=msvyno02-msnakl02, mszisk03=msvyno03-msnakl03 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mszisk04=msvyno04-msnakl04, mszisk05=msvyno05-msnakl05, mszisk06=msvyno06-msnakl06 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mszisk07=msvyno07-msnakl07, mszisk08=msvyno08-msnakl08, mszisk09=msvyno09-msnakl09 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mszisk10=msvyno10-msnakl10, mszisk11=msvyno11-msnakl11, mszisk12=msvyno12-msnakl12 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

//ötrukt˙ra n·kladov(podæa skupÌn ˙o): 50 SpotrebovanÈ n·kupy, 51 Sluûby, 52 OsobnÈ n·klady, 53 Dane a poplatky, 54 InÈ prev·dzkovÈ n·klady,
// 55 Odpisy, rezervy a OP prev·dzkov˝ch n·kladov, 56 FinanËnÈ n·klady, 57 Rezervy a OP finanËn˝ch n·kladov,
// 58 Mimoriadne n·klady, 59 Dane z prÌjmov a prevodovÈ ˙Ëty = s˙Ëty hodnÙt syntetick˝ch ˙Ëtov

$stnakl1=0; $stnakl2=0; $stnakl3=0; $stnakl4=0; $stnakl5=0; $stnakl6=0; $stnakl7=0; $stnakl8=0; $stnakl9=0; $stnakl10=0; $stnakl11=0; $stnakl12=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 5 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$uce2=substr($polozka->uce,0,2);
if( $uce2 == 50 ) { $stnakl1=$stnakl1+$polozka->hod; }
if( $uce2 == 51 ) { $stnakl2=$stnakl2+$polozka->hod; }
if( $uce2 == 52 ) { $stnakl3=$stnakl3+$polozka->hod; }
if( $uce2 == 53 ) { $stnakl4=$stnakl4+$polozka->hod; }
if( $uce2 == 54 ) { $stnakl5=$stnakl5+$polozka->hod; }
if( $uce2 == 55 ) { $stnakl6=$stnakl6+$polozka->hod; }
if( $uce2 == 56 ) { $stnakl7=$stnakl7+$polozka->hod; }
if( $uce2 == 57 ) { $stnakl8=$stnakl8+$polozka->hod; }
if( $uce2 == 58 ) { $stnakl9=$stnakl9+$polozka->hod; }
if( $uce2 == 59 ) { $stnakl10=$stnakl10+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stnakl1=$stnakl1, stnakl2=$stnakl2, stnakl3=$stnakl3, stnakl4=$stnakl4 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stnakl5=$stnakl5, stnakl6=$stnakl6, stnakl7=$stnakl7, stnakl8=$stnakl8 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stnakl9=$stnakl9, stnakl10=$stnakl10 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

//ötrukt˙ra v˝nosov(podæa skupÌn ˙o): 60 Trûby za vlastnÈ v˝kony a tovar, 61 Zmeny stavu vn˙troorganizaËn˝ch z·sob, 62 Aktiv·cia,
// 64 InÈ v˝nosy z hospod·rskej Ëinnosti, 65 Z˙Ëtovanie rezerv a OP v˝nosov z hospod·rskej Ëinnosti,
// 66 FinanËnÈ v˝nosy, 67 Z˙Ëtovanie rezerv a OP finanËn˝ch v˝nosov, 68 Mimoriadne v˝nosy, 69 PrevodovÈ ˙Ëty

$stvyno1=0; $stvyno2=0; $stvyno3=0; $stvyno4=0; $stvyno5=0; $stvyno6=0; $stvyno7=0; $stvyno8=0; $stvyno9=0; $stvyno10=0; $stvyno11=0; $stvyno12=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,1) = 6 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$uce2=substr($polozka->uce,0,2);
if( $uce2 == 60 ) { $stvyno1=$stvyno1+$polozka->hod; }
if( $uce2 == 61 ) { $stvyno2=$stvyno2+$polozka->hod; }
if( $uce2 == 62 ) { $stvyno3=$stvyno3+$polozka->hod; }
if( $uce2 == 64 ) { $stvyno4=$stvyno4+$polozka->hod; }
if( $uce2 == 65 ) { $stvyno5=$stvyno5+$polozka->hod; }
if( $uce2 == 66 ) { $stvyno6=$stvyno6+$polozka->hod; }
if( $uce2 == 67 ) { $stvyno7=$stvyno7+$polozka->hod; }
if( $uce2 == 68 ) { $stvyno8=$stvyno8+$polozka->hod; }
if( $uce2 == 69 ) { $stvyno9=$stvyno9+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stvyno1=$stvyno1, stvyno2=$stvyno2, stvyno3=$stvyno3, stvyno4=$stvyno4 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stvyno5=$stvyno5, stvyno6=$stvyno6, stvyno7=$stvyno7, stvyno8=$stvyno8 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stvyno9=$stvyno9 WHERE katg = 4 ";
$oznac = mysql_query("$sqtoz");


}
//koniec grafy hospodarenie katg = 4 

//grafy trzby katg = 5 
if( $katg == 5 )
{
$sqlt = <<<uctcrv
(
   katg          DECIMAL(4,0) DEFAULT 0,

   sttrz1       DECIMAL(10,2) DEFAULT 0,
   sttrz2       DECIMAL(10,2) DEFAULT 0,
   sttrz3       DECIMAL(10,2) DEFAULT 0,

   mstrz01      DECIMAL(10,2) DEFAULT 0,
   mstrz02      DECIMAL(10,2) DEFAULT 0,
   mstrz03      DECIMAL(10,2) DEFAULT 0,
   mstrz04      DECIMAL(10,2) DEFAULT 0,
   mstrz05      DECIMAL(10,2) DEFAULT 0,
   mstrz06      DECIMAL(10,2) DEFAULT 0,
   mstrz07      DECIMAL(10,2) DEFAULT 0,
   mstrz08      DECIMAL(10,2) DEFAULT 0,
   mstrz09      DECIMAL(10,2) DEFAULT 0,
   mstrz10      DECIMAL(10,2) DEFAULT 0,
   mstrz11      DECIMAL(10,2) DEFAULT 0,
   mstrz12      DECIMAL(10,2) DEFAULT 0,

   vjtrz5       DECIMAL(10,2) DEFAULT 0,
   vjtrz4       DECIMAL(10,2) DEFAULT 0,
   vjtrz3       DECIMAL(10,2) DEFAULT 0,
   vjtrz2       DECIMAL(10,2) DEFAULT 0,
   vjtrz1       DECIMAL(10,2) DEFAULT 0,

   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfv".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.' ( katg ) VALUES ( 5 ) ';
$vytvor = mysql_query("$vsql");

//ötrukt˙ra trûieb: Trûby za vlastnÈ v˝robky, Trûby z predaja sluûieb a Trûby za tovar = hodnoty na ˙Ëtoch 601,602 a 604

$sttrz1=0; $sttrz2=0; $sttrz3=0; $sttrz4=0; $sttrz5=0; $sttrz6=0; $sttrz7=0; $sttrz8=0; $sttrz9=0; $sttrz10=0; $sttrz11=0; $sttrz12=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,2) = 60 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$uce3=substr($polozka->uce,0,3);
if( $uce3 == 601 ) { $sttrz1=$sttrz1+$polozka->hod; }
if( $uce3 == 602 ) { $sttrz2=$sttrz2+$polozka->hod; }
if( $uce3 == 604 ) { $sttrz3=$sttrz3+$polozka->hod; }

}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET sttrz1=$sttrz1, sttrz2=$sttrz2, sttrz3=$sttrz3 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

//mesacny v˝voj trzieb
$mes01="1.".$kli_vrok; $mes02="2.".$kli_vrok; $mes03="3.".$kli_vrok; $mes04="4.".$kli_vrok; $mes05="5.".$kli_vrok; $mes06="6.".$kli_vrok; 
$mes07="7.".$kli_vrok; $mes08="8.".$kli_vrok; $mes09="9.".$kli_vrok; $mes10="10.".$kli_vrok; $mes11="11.".$kli_vrok; $mes12="12.".$kli_vrok;

$mstrz01=0; $mstrz02=0; $mstrz03=0; $mstrz04=0; $mstrz05=0; $mstrz06=0; $mstrz07=0; $mstrz08=0; $mstrz09=0; $mstrz10=0; $mstrz11=0; $mstrz12=0;


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 AND $polozka->ume == $mes01  ) { $mstrz01=$mstrz01+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes02  ) { $mstrz02=$mstrz02+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes03  ) { $mstrz03=$mstrz03+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes04  ) { $mstrz04=$mstrz04+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes05  ) { $mstrz05=$mstrz05+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes06  ) { $mstrz06=$mstrz06+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes07  ) { $mstrz07=$mstrz07+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes08  ) { $mstrz08=$mstrz08+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes09  ) { $mstrz09=$mstrz09+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes10  ) { $mstrz10=$mstrz10+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes11  ) { $mstrz11=$mstrz11+$polozka->hod; }
if( $polozka->csv >= 0 AND $polozka->ume == $mes12  ) { $mstrz12=$mstrz12+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mstrz01=$mstrz01, mstrz02=$mstrz02, mstrz03=$mstrz03, mstrz04=$mstrz04 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mstrz05=$mstrz05, mstrz06=$mstrz06, mstrz07=$mstrz07, mstrz08=$mstrz08 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET mstrz09=$mstrz09, mstrz10=$mstrz10, mstrz11=$mstrz11, mstrz12=$mstrz12 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

//medziroËn˝ v˝voj trzieb
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore5=$hore5+$polozka->hod; }
}
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 0 AND ( LEFT(uce,3) = 601 OR LEFT(uce,3) = 602 OR LEFT(uce,3) = 604 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $hore1=$hore1+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjtrz5=$hore5 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjtrz4=$hore4 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjtrz3=$hore3 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjtrz2=$hore2 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjtrz1=$hore1 WHERE katg = 5 ";
$oznac = mysql_query("$sqtoz");

}
//koniec grafy trzby katg = 5 


//grafy zamestnanci katg = 6 
if( $katg == 6 )
{
$sqlt = <<<uctcrv
(
   katg          DECIMAL(4,0) DEFAULT 0,

   stosnak1       DECIMAL(10,2) DEFAULT 0,
   stosnak2       DECIMAL(10,2) DEFAULT 0,
   stosnak3       DECIMAL(10,2) DEFAULT 0,
   stosnak4       DECIMAL(10,2) DEFAULT 0,
   stosnak5       DECIMAL(10,2) DEFAULT 0,
   stosnak6       DECIMAL(10,2) DEFAULT 0,
   stosnak7       DECIMAL(10,2) DEFAULT 0,
   stosnak8       DECIMAL(10,2) DEFAULT 0,

   vjmzdy5       DECIMAL(10,2) DEFAULT 0,
   vjmzdy4       DECIMAL(10,2) DEFAULT 0,
   vjmzdy3       DECIMAL(10,2) DEFAULT 0,
   vjmzdy2       DECIMAL(10,2) DEFAULT 0,
   vjmzdy1       DECIMAL(10,2) DEFAULT 0,

   vjprod5       DECIMAL(10,2) DEFAULT 0,
   vjprod4       DECIMAL(10,2) DEFAULT 0,
   vjprod3       DECIMAL(10,2) DEFAULT 0,
   vjprod2       DECIMAL(10,2) DEFAULT 0,
   vjprod1       DECIMAL(10,2) DEFAULT 0,

   vjzam5       DECIMAL(10,2) DEFAULT 0,
   vjzam4       DECIMAL(10,2) DEFAULT 0,
   vjzam3       DECIMAL(10,2) DEFAULT 0,
   vjzam2       DECIMAL(10,2) DEFAULT 0,
   vjzam1       DECIMAL(10,2) DEFAULT 0,

   konx          DECIMAL(1,0) DEFAULT 0
);
uctcrv;

$sql = "DROP TABLE F".$kli_vxcf."_prcanagrfv".$kli_uzid;
$vysledok = mysql_query($sql);
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'INSERT INTO F'.$kli_vxcf.'_prcanagrfv'.$kli_uzid.' ( katg ) VALUES ( 6 ) ';
$vytvor = mysql_query("$vsql");

//exit;

//ötrukt˙ra osobn˝ch n·kladov(˙s 52): MzdovÈ n·klady, PrÌjmy spoloËnÌkov a Ëlenov zo z·vislej Ëinnosti, Odmeny Ëlenom org·nov spoloËnosti a druûstva,
//Z·konnÈ soci·lne zabezpeËenie, OstatnÈ soci·lne zabezpeËenie, Soci·lne n·klady FO - podnikateæa,
//OstatnÈ soci·lne n·klady = hodnoty na ˙Ëtoch 521,522,523,524,525,526,527 a 528

$stosnak1=0; $stosnak2=0; $stosnak3=0; $stosnak4=0; $stosnak5=0; $stosnak6=0; $stosnak7=0; $stosnak8=0; $stosnak9=0; $stosnak10=0; $stosnak11=0; $stosnak12=0;

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND LEFT(uce,2) = 52 "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
$uce3=substr($polozka->uce,0,3);
if( $uce3 == 521 ) { $stosnak1=$stosnak1+$polozka->hod; }
if( $uce3 == 522 ) { $stosnak2=$stosnak2+$polozka->hod; }
if( $uce3 == 523 ) { $stosnak3=$stosnak3+$polozka->hod; }
if( $uce3 == 524 ) { $stosnak4=$stosnak4+$polozka->hod; }
if( $uce3 == 525 ) { $stosnak5=$stosnak5+$polozka->hod; }
if( $uce3 == 526 ) { $stosnak6=$stosnak6+$polozka->hod; }
if( $uce3 == 527 ) { $stosnak7=$stosnak7+$polozka->hod; }
if( $uce3 == 528 ) { $stosnak8=$stosnak8+$polozka->hod; }
}
$i=$i+1;                   }

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stosnak1=$stosnak1, stosnak2=$stosnak2, stosnak3=$stosnak3, stosnak4=$stosnak4 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET stosnak5=$stosnak5, stosnak6=$stosnak6, stosnak7=$stosnak7, stosnak8=$stosnak8  WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");

//medziroËn˝ v˝voj mzdovych nakladov 521,522
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND ( LEFT(uce,3) = 521 OR LEFT(uce,3) = 522 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->csv >= 0 ) { $hore5=$hore5+$polozka->hod; }
}
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 0 AND ( LEFT(uce,3) = 521 OR LEFT(uce,3) = 522 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 ) { $hore1=$hore1+$polozka->hod; }
}
$i=$i+1;                   }


$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjmzdy5=$hore5 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjmzdy4=$hore4 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjmzdy3=$hore3 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjmzdy2=$hore2 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjmzdy1=$hore1 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");


//medziroËn˝ v˝voj produktivita pr·ce z v˝nosov: V˝nosy/PoËet zamestnancov = s˙Ëet ˙Ëtovej triedy 6/PoËet zamestnancov
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; $pocm5=0; $pocm4=0; $pocm3=0; $pocm2=0; $pocm1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND ( LEFT(uce,1) = 6 OR uce = 9999001 OR uce = 9999002 ) "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->uce <= 9999001 ) { $hore5=$hore5+$polozka->hod; }
if( $polozka->uce == 9999001 ) { $dole5=$dole5+$polozka->hod; }
if( $polozka->uce == 9999002 ) { $pocm5=$pocm5+$polozka->hod; }
}
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 0 AND ( LEFT(uce,1) = 6 OR uce = 9999001 OR uce = 9999002 )  "; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 AND $polozka->uce <= 9999001 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 AND $polozka->uce <= 9999001 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 AND $polozka->uce <= 9999001 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 AND $polozka->uce <= 9999001 ) { $hore1=$hore1+$polozka->hod; }
if( $polozka->rok == $rok4 AND $polozka->uce == 9999001 ) { $dole4=$dole4+$polozka->hod; }
if( $polozka->rok == $rok3 AND $polozka->uce == 9999001 ) { $dole3=$dole3+$polozka->hod; }
if( $polozka->rok == $rok2 AND $polozka->uce == 9999001 ) { $dole2=$dole2+$polozka->hod; }
if( $polozka->rok == $rok1 AND $polozka->uce == 9999001 ) { $dole1=$dole1+$polozka->hod; }
if( $polozka->rok == $rok4 AND $polozka->uce == 9999002 ) { $pocm4=$pocm4+$polozka->hod; }
if( $polozka->rok == $rok3 AND $polozka->uce == 9999002 ) { $pocm3=$pocm3+$polozka->hod; }
if( $polozka->rok == $rok2 AND $polozka->uce == 9999002 ) { $pocm2=$pocm2+$polozka->hod; }
if( $polozka->rok == $rok1 AND $polozka->uce == 9999002 ) { $pocm1=$pocm1+$polozka->hod; }
}
$i=$i+1;                   }

if( $pocm5 > 0 ) { $dole5=$dole5/$pocm5; }
if( $pocm4 > 0 ) { $dole4=$dole4/$pocm4; }
if( $pocm3 > 0 ) { $dole3=$dole3/$pocm3; }
if( $pocm2 > 0 ) { $dole2=$dole2/$pocm2; }
if( $pocm1 > 0 ) { $dole1=$dole1/$pocm1; }

if( $dole5 != 0 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjprod5=$hore5/$dole5 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");
 }
if( $dole4 != 0 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjprod4=$hore4/$dole4 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");
 }
if( $dole3 != 0 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjprod3=$hore3/$dole3 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");
 }
if( $dole2 != 0 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjprod2=$hore2/$dole2 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");
 }
if( $dole1 != 0 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjprod1=$hore1/$dole1 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz");
 }

//medziroËn˝ v˝voj zamestnancov
$rok5=$kli_vrok; $rok4=$kli_vrok-1; $rok3=$kli_vrok-2; $rok2=$kli_vrok-3; $rok1=$kli_vrok-4; 
$hore5=0; $dole5=0; $hore4=0; $dole4=0; $hore3=0; $dole3=0; $hore2=0; $dole2=0; $hore1=0; $dole1=0; $pocm5=0; $pocm4=0; $pocm3=0; $pocm2=0; $pocm1=0; 

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfy$kli_uzid WHERE konx = 0 AND ( uce = 9999001 OR uce = 9999002 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->uce == 9999001 ) { $hore5=$hore5+$polozka->hod; }
if( $polozka->uce == 9999002 ) { $pocm5=$pocm5+$polozka->hod; }
}
$i=$i+1;                   }


$sqltt = "SELECT * FROM F$kli_vxcf"."_prcanagrfb$kli_uzid WHERE konx = 0 AND ( uce = 9999001 OR uce = 9999002 )"; 
$sql = mysql_query("$sqltt"); $pol = mysql_num_rows($sql);
$i=0; while ($i <= $pol )  {
if (@$zaznam=mysql_data_seek($sql,$i)) { $polozka=mysql_fetch_object($sql); 
if( $polozka->rok == $rok4 AND $polozka->uce == 9999001 ) { $hore4=$hore4+$polozka->hod; }
if( $polozka->rok == $rok3 AND $polozka->uce == 9999001 ) { $hore3=$hore3+$polozka->hod; }
if( $polozka->rok == $rok2 AND $polozka->uce == 9999001 ) { $hore2=$hore2+$polozka->hod; }
if( $polozka->rok == $rok1 AND $polozka->uce == 9999001 ) { $hore1=$hore1+$polozka->hod; }
if( $polozka->rok == $rok4 AND $polozka->uce == 9999002 ) { $pocm4=$pocm4+$polozka->hod; }
if( $polozka->rok == $rok3 AND $polozka->uce == 9999002 ) { $pocm3=$pocm3+$polozka->hod; }
if( $polozka->rok == $rok2 AND $polozka->uce == 9999002 ) { $pocm2=$pocm2+$polozka->hod; }
if( $polozka->rok == $rok1 AND $polozka->uce == 9999002 ) { $pocm1=$pocm1+$polozka->hod; }
}
$i=$i+1;                   }

if( $pocm5 > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzam5=$hore5/$pocm5 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz"); //echo $sqtoz;
}
if( $pocm4 > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzam4=$hore4/$pocm4 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz"); //echo $sqtoz;
}
if( $pocm3 > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzam3=$hore3/$pocm3 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz"); //echo $sqtoz;
}
if( $pocm2 > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzam2=$hore2/$pocm2 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz"); //echo $sqtoz;
}
if( $pocm1 > 0 )
{
$sqtoz = "UPDATE F$kli_vxcf"."_prcanagrfv$kli_uzid SET vjzam1=$hore1/$pocm1 WHERE katg = 6 ";
$oznac = mysql_query("$sqtoz"); //echo $sqtoz;
}

//exit;

}
//koniec grafy zamestnanci katg = 6 

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Grafy zdroj</title>
  <style type="text/css">

  </style>

<script type="text/javascript">

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />





<?php

//prepni do grafov
$cstat=10101;
if( $copern == 1001 ) { $nacit=1; }
if( $copern == 1002 ) { $nacit=2; }
if( $copern == 1 AND $minule == 1 ) { $nacit=2; }

if( $cstat == 10101 )
{
?>
<script type="text/javascript">

window.open('../analyzy/grafy.php?copern=1&drupoh=1&page=1&analyzy=1&katg=<?php echo $katg; ?>&nacit=<?php echo $nacit; ?>&minule=<?php echo $minule; ?>', '_self' )

</script>
<?php
exit;
}

//koniec prepni spat

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
