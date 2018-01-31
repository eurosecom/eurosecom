<?php
//vypocitaj hodinovu sadzbu do sz4 v mzdkun

if( $kli_vume == 1.2009 ) { $pracsviat=22; }
if( $kli_vume == 2.2009 ) { $pracsviat=20; }
if( $kli_vume == 3.2009 ) { $pracsviat=22; }
if( $kli_vume == 4.2009 ) { $pracsviat=22; }
if( $kli_vume == 5.2009 ) { $pracsviat=21; }
if( $kli_vume == 6.2009 ) { $pracsviat=22; }
if( $kli_vume == 7.2009 ) { $pracsviat=23; }
if( $kli_vume == 8.2009 ) { $pracsviat=21; }
if( $kli_vume == 9.2009 ) { $pracsviat=22; }
if( $kli_vume == 10.2009 ) { $pracsviat=22; }
if( $kli_vume == 11.2009 ) { $pracsviat=21; }
if( $kli_vume == 12.2009 ) { $pracsviat=23; }

if( $kli_vume == 1.2010 ) { $pracsviat=21; }
if( $kli_vume == 2.2010 ) { $pracsviat=20; }
if( $kli_vume == 3.2010 ) { $pracsviat=23; }
if( $kli_vume == 4.2010 ) { $pracsviat=22; }
if( $kli_vume == 5.2010 ) { $pracsviat=21; }
if( $kli_vume == 6.2010 ) { $pracsviat=22; }
if( $kli_vume == 7.2010 ) { $pracsviat=22; }
if( $kli_vume == 8.2010 ) { $pracsviat=22; }
if( $kli_vume == 9.2010 ) { $pracsviat=22; }
if( $kli_vume == 10.2010 ) { $pracsviat=21; }
if( $kli_vume == 11.2010 ) { $pracsviat=22; }
if( $kli_vume == 12.2010 ) { $pracsviat=23; }

if( $kli_vume == 1.2011 ) { $pracsviat=21; }
if( $kli_vume == 2.2011 ) { $pracsviat=20; }
if( $kli_vume == 3.2011 ) { $pracsviat=23; }
if( $kli_vume == 4.2011 ) { $pracsviat=21; }
if( $kli_vume == 5.2011 ) { $pracsviat=22; }
if( $kli_vume == 6.2011 ) { $pracsviat=22; }
if( $kli_vume == 7.2011 ) { $pracsviat=21; }
if( $kli_vume == 8.2011 ) { $pracsviat=23; }
if( $kli_vume == 9.2011 ) { $pracsviat=22; }
if( $kli_vume == 10.2011 ) { $pracsviat=21; }
if( $kli_vume == 11.2011 ) { $pracsviat=22; }
if( $kli_vume == 12.2011 ) { $pracsviat=22; }

if( $kli_vume == 1.2012 ) { $pracsviat=22; }
if( $kli_vume == 2.2012 ) { $pracsviat=21; }
if( $kli_vume == 3.2012 ) { $pracsviat=22; }
if( $kli_vume == 4.2012 ) { $pracsviat=21; }
if( $kli_vume == 5.2012 ) { $pracsviat=23; }
if( $kli_vume == 6.2012 ) { $pracsviat=21; }
if( $kli_vume == 7.2012 ) { $pracsviat=22; }
if( $kli_vume == 8.2012 ) { $pracsviat=23; }
if( $kli_vume == 9.2012 ) { $pracsviat=20; }
if( $kli_vume == 10.2012 ) { $pracsviat=23; }
if( $kli_vume == 11.2012 ) { $pracsviat=22; }
if( $kli_vume == 12.2012 ) { $pracsviat=21; }


if( $kli_vrok > 2012 ) {

$umesiac=$kli_vume;

$pracsviat=22;
$sqltt = "SELECT * FROM kalendar WHERE ume = $umesiac AND akyden < 6 ";
$sql = mysql_query("$sqltt");
if( $sql ) { $pracsviat = 1*mysql_num_rows($sql); }

                        }


$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprc$kli_uzid ";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<uctmzd
(
   prx         INT,
   oc          INT,
   kc          DECIMAL(10,2),
   sz4x        DECIMAL(10,4)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc'.$kli_uzid.$sqlt;
$ulozene = mysql_query("$sql");

$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprb$kli_uzid ";
$dsql = mysql_query("$dsqlt");

$sqlt = <<<uctmzd
(
   prx         INT,
   oc          INT,
   kc          DECIMAL(10,2),
   hh          DECIMAL(10,2),
   sz4x        DECIMAL(10,4)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprb'.$kli_uzid.$sqlt;
$ulozene = mysql_query("$sql");

//dps gbely 36084514
//dssbrodske 37986830

$fir_ficoorig=$fir_fico;
if( $fir_fico == 45741093 ) { $fir_fico=37986830; }

$zdravprac=0;
if( $fir_fico == 36084514 OR $fir_fico == 37986708 OR $fir_fico == 37986830 OR $kli_nezis == 1 )
{
$zdravprac=1;
}

if( $zdravprac == 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".$kli_uzid." SELECT 0,oc,kc,0 FROM F$kli_vxcf"."_mzdtrn WHERE trx1 = 1 AND ( dm = 101 OR dm = 107 ) ";
$dsql = mysql_query("$dsqlt");
}

if( $zdravprac == 1 )
{
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".$kli_uzid." SELECT 0,oc,kc,0 FROM F$kli_vxcf"."_mzdtrn WHERE ( dm = 101 OR dm = 118 OR dm = 217 OR dm = 218 ) ";
$dsql = mysql_query("$dsqlt");

if( $kli_vrokx > 2009 )
     {

$kli_vxcfxy=$kli_vxcf;
if( $fir_allx11 > 0 ) $kli_vxcfxy=$fir_allx11;
$kli_mrok=$kli_vrok-1;
$mes1="10.".$kli_mrok; $mes2="11.".$kli_mrok; $mes3="12.".$kli_mrok;
if( $kli_vmesx > 3 ) { $mes1="1.".$kli_vrok; $mes2="2.".$kli_vrok; $mes3="3.".$kli_vrok; $kli_vxcfxy=$kli_vxcf; }
if( $kli_vmesx > 6 ) { $mes1="4.".$kli_vrok; $mes2="5.".$kli_vrok; $mes3="6.".$kli_vrok; $kli_vxcfxy=$kli_vxcf; }
if( $kli_vmesx > 9 ) { $mes1="7.".$kli_vrok; $mes2="8.".$kli_vrok; $mes3="9.".$kli_vrok; $kli_vxcfxy=$kli_vxcf; }

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprb".$kli_uzid." SELECT 0,oc,kc,0,0 FROM F$kli_vxcfxy"."_mzdzalvy WHERE dm = 308 AND ume >= $mes1 AND ume <= $mes3 ";
$dsql = mysql_query("$dsqlt");
if( $fir_fico != 37986830 )
       {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprb".$kli_uzid." SELECT 0,oc,0,hod,0 FROM F$kli_vxcfxy"."_mzdzalvy WHERE dm >= 101 AND dm <= 104 AND ume >= $mes1 AND ume <= $mes3 ";
$dsql = mysql_query("$dsqlt");
       }

//uprava dssbrodske
if( $fir_fico == 37986830 )
       {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprb".$kli_uzid." SELECT 0,oc,0,1,0 FROM F$kli_vxcfxy"."_mzdzalkun WHERE ume >= $mes1 AND ume <= $mes3 AND pom != 9 ";
$dsql = mysql_query("$dsqlt");


       }
//koniec uprava dssbrodske

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprb".$kli_uzid." SELECT 1,oc,SUM(kc),SUM(hh),0 FROM F$kli_vxcf"."_mzdprb".$kli_uzid." WHERE prx = 0 GROUP BY oc";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprb".$kli_uzid." WHERE prx = 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprb".$kli_uzid." SET sz4x=kc/hh WHERE oc > 0 AND hh > 0";
$dsql = mysql_query("$dsqlt");
     }

}


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc".$kli_uzid." SELECT 1,oc,SUM(kc),0 FROM F$kli_vxcf"."_mzdprc".$kli_uzid." WHERE kc > 0 GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdprc".$kli_uzid." WHERE prx = 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc".$kli_uzid." SET sz4x=kc/$pracsviat WHERE oc > 0";
$dsql = mysql_query("$dsqlt");

//uprava markovic
if( $fir_fico == 11952644 )
     {
$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc".$kli_uzid." SET sz4x=kc/21.74 WHERE oc > 0";
$dsql = mysql_query("$dsqlt");
     }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun,F$kli_vxcf"."_mzdprc".$kli_uzid." SET sz4=sz4x/uva WHERE F$kli_vxcf"."_mzdkun.oc = F$kli_vxcf"."_mzdprc".$kli_uzid.".oc AND uva > 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun,F$kli_vxcf"."_mzdprb".$kli_uzid." SET sz4=sz4+sz4x WHERE F$kli_vxcf"."_mzdkun.oc = F$kli_vxcf"."_mzdprb".$kli_uzid.".oc ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//uprava dssbrodske
if( $fir_fico == 37986830 )
     {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc".$kli_uzid." SET sz4x=kc WHERE oc > 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun,F$kli_vxcf"."_mzdprc".$kli_uzid." SET sz3=sz4x WHERE F$kli_vxcf"."_mzdkun.oc = F$kli_vxcf"."_mzdprc".$kli_uzid.".oc AND uva > 0";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun,F$kli_vxcf"."_mzdprb".$kli_uzid." SET sz3=sz3+kc/hh WHERE F$kli_vxcf"."_mzdkun.oc = F$kli_vxcf"."_mzdprb".$kli_uzid.".oc AND hh > 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz4=sz3 WHERE oc > 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz3=sz3/174 WHERE oc > 0 AND uva = 8.0  "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz3=sz3/168 WHERE oc > 0 AND uva = 7.75 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz3=sz3/163 WHERE oc > 0 AND uva = 7.5  "; $dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz3=sz3/119.53 WHERE oc > 0 AND uva = 5.5 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz3=sz3/119.53 WHERE oc > 0 AND uva < 5.5 "; $dsql = mysql_query("$dsqlt");

//toto chcem pre dsszavod
if( $fir_ficoorig == 45741093 ) 
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz4=sz4/($pracsviat*uva) WHERE oc > 0 AND uva > 0 ";
$dsql = mysql_query("$dsqlt");
}
//toto chcem pre dssbrodske
if( $fir_ficoorig == 37986830 ) 
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdkun SET sz4=sz3, sz3=0 WHERE oc > 0 AND uva > 0 ";
$dsql = mysql_query("$dsqlt");
}

     }
//koniec dssbrodske

//vypocet priemeru na nemocenske tento rok _mzdnemzakb
//len 1.krat po ostrom spracovani
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdnemzakb ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { 
$fir_riadok=mysql_fetch_object($fir_vysledok); 
$kli_vumexx = $fir_riadok->umex;
$kli_vume1="1.".$kli_vrok;
if( $kli_vumexx != $kli_vume )
  {
$sqlt = "DROP TABLE F".$kli_vxcf."_mzdnemzakb ";
$vysledok = mysql_query("$sqlt");
  }
}

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdnemzakb ";
$sql = mysql_query("$sqltt");
if(!$sql) 
{ 
//echo "idem ".$kli_vume." ".$kli_vumexx." ".$kli_vume1;

$sqltx = <<<uctmzd
(
   prx         INT DEFAULT 0,
   oc          INT DEFAULT 0,
   kc          DECIMAL(10,2) DEFAULT 0,
   dna         DECIMAL(10,2) DEFAULT 0,
   dnn         DECIMAL(10,2) DEFAULT 0,
   dnc         DECIMAL(10,2) DEFAULT 0,
   sz4x        DECIMAL(10,4) DEFAULT 0,
   umex        DECIMAL(7,4) DEFAULT 0,
   znem        DECIMAL(10,4) DEFAULT 0,
   dan         DATE NOT NULL,
   dav         DATE NOT NULL
);
uctmzd;

$dsqlt = "CREATE TABLE F$kli_vxcf"."_mzdnemzakb ".$sqltx;
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 0, oc, 0, 0, 0, 0, 0, 0, znem, dan, dav FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ";
$dsql = mysql_query("$dsqlt");

$kli_vrom=$kli_vrok-1;
$datum0101=$kli_vrom."-01-01";
$datumazdo=$kli_vrok."-".$kli_vmes."-01";

$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET dna=TO_DAYS('$datumazdo')-TO_DAYS('$datum0101') WHERE oc > 0 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET dna=TO_DAYS(dav)-TO_DAYS('$datum0101')+1 WHERE oc > 0 AND dav >= '$datum0101' AND dav < '$datumazdo' ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET dna=TO_DAYS('$datumazdo')-TO_DAYS(dan) WHERE oc > 0 AND dan >= '$datum0101' AND dan < '$datumazdo' ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET dna=TO_DAYS(dav)-TO_DAYS(dan)+1 WHERE oc > 0 AND dav >= '$datum0101' AND dav < '$datumazdo' AND dan >= '$datum0101' AND dan < '$datumazdo' ";
$vysledek = mysql_query("$sql");

//echo $sql;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 1, oc, zzam_np, 0, 0, 0, 0, 0, 0, '', '' FROM F$kli_vxcf"."_mzdzalsum WHERE ume < $kli_vume ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 2, oc, 0, 0, dni, 0, 0, 0, 0, '', '' FROM F$kli_vxcf"."_mzdzalvy WHERE ume < $kli_vume AND dm >= 801 AND dm <= 804 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 2, oc, 0, 0, dni, 0, 0, 0, 0, '', '' FROM F$kli_vxcf"."_mzdzalvy WHERE ume < $kli_vume AND ( dm = 502 OR dm = 503 ) ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$kli_vmcf=$fir_allx11;
$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 3, oc, zzam_np, 0, 0, 0, 0, 0, 0, '', '' FROM ".$databaza."F$kli_vmcf"."_mzdzalsum WHERE oc > 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 4, oc, 0, 0, dni, 0, 0, 0, 0, '', '' FROM ".$databaza."F$kli_vmcf"."_mzdzalvy WHERE dm >= 801 AND dm <= 804 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 4, oc, 0, 0, dni, 0, 0, 0, 0, '', '' FROM ".$databaza."F$kli_vmcf"."_mzdzalvy WHERE dm = 502 OR dm = 503 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//exit;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdnemzakb SELECT 9, oc, SUM(kc), sum(dna), sum(dnn), 0, 0, 0, sum(znem), MAX(dan), MAX(dav) FROM F$kli_vxcf"."_mzdnemzakb GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

$sql = "DELETE FROM F$kli_vxcf"."_mzdnemzakb WHERE prx != 9 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET dnc=dna-dnn WHERE oc > 0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET sz4x=kc/dnc WHERE oc > 0 AND dnc > 0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET sz4x=znem WHERE oc > 0 AND sz4x = 0 ";
$vysledek = mysql_query("$sql");

if( $kli_vrok == 2015 )
  {
$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET sz4x=40.6356 WHERE oc > 0 AND sz4x > 40.6356 ";
$vysledek = mysql_query("$sql");
  }
if( $kli_vrok == 2016 )
  {
$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET sz4x=42.3124 WHERE oc > 0 AND sz4x > 42.3124 ";
$vysledek = mysql_query("$sql");
  }

$sql = "UPDATE F$kli_vxcf"."_mzdnemzakb SET umex='$kli_vume' WHERE oc > 0 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_mzdkun,F$kli_vxcf"."_mzdnemzakb SET F$kli_vxcf"."_mzdkun.znem=F$kli_vxcf"."_mzdnemzakb.sz4x ".
" WHERE F$kli_vxcf"."_mzdkun.oc=F$kli_vxcf"."_mzdnemzakb.oc AND F$kli_vxcf"."_mzdkun.dan > '$datum0101'";
$vysledek = mysql_query("$sql");
//echo $sql;

}


//max.vyplata nemocenske
if( $kli_vrok == 2016 )
  {
$sql = "UPDATE F$kli_vxcf"."_mzdkun SET znem=42.3124 WHERE znem > 42.3124 ";
$vysledek = mysql_query("$sql");
  }
if( $kli_vrok == 2017 )
  {
$sql = "UPDATE F$kli_vxcf"."_mzdkun SET znem=58.0603 WHERE znem > 58.0603 ";
$vysledek = mysql_query("$sql");
  }
if( $kli_vrok == 2018 )
  {
$sql = "UPDATE F$kli_vxcf"."_mzdkun SET znem=59.9672 WHERE znem > 59.9672 ";
$vysledek = mysql_query("$sql");
  }

//koniec vypocet priemeru na nemocenske tento rok

$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprc$kli_uzid ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DROP TABLE F$kli_vxcf"."_mzdprb$kli_uzid ";
$dsql = mysql_query("$dsqlt");

//koniec vypoctu sz4
?>