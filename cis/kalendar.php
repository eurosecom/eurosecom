<!DOCTYPE html   PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>kalendar.php</title>
</head>
<body>
<?php

echo "Nastavit databazu $mysqldb!"."<br />";
$sql = "USE $mysqldb";
$vysledek = mysql_query("$sql");
if ($vysledek)
     echo "Databaza $mysqldb nastavena."."<br />";

$sqlt = "DROP TABLE kalendar1";
$vysledok = mysql_query("$sqlt");

//OD TADETO LEN JEDEN RAZ
$sql = "SELECT m122011 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "zakladam kalendar 2008-2011 ";

//Tabulka kalendar
$sql = "SELECT * FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "Vytvorit tabulku kalendar!"."<br />";

$sqlt = <<<kalendar
(
   dat         DATE,
   ume         FLOAT(6,4),
   akyden      INT,
   svt         INT
);
kalendar;

$sql = 'CREATE TABLE kalendar'.$sqlt;
//echo 'CREATE TABLE kalendar'.$sqlt;

$vysledek = mysql_query("$sql");
if ($vysledek)
      echo "Tabulka kalendar!"."vytvorená <br />";



$den=1;
$i=0;
  while ($i <= 730 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2008)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");
//sviatky 2008
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2008-01-01' OR dat = '2008-01-06' OR dat = '2008-03-21' OR dat = '2008-03-24' OR dat = '2008-05-01'".
" OR dat = '2008-05-08' OR dat = '2008-07-05' OR dat = '2008-08-29' OR dat = '2008-09-01' OR dat = '2008-09-15'".
" OR dat = '2008-11-01' OR dat = '2008-11-17' OR dat = '2008-12-24' OR dat = '2008-12-25' OR dat = '2008-12-26'".
" OR dat = '2009-01-01' OR dat = '2009-01-06'";

$upravene = mysql_query("$uprt");

}
//koniec vytvorenia tabulky kalendar

//sviatky 2009
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2009-01-01' OR dat = '2009-01-06' OR dat = '2009-04-10' OR dat = '2009-04-13' ".
" OR dat = '2009-05-01' OR dat = '2009-05-08' OR dat = '2009-07-05' ".
" OR dat = '2009-08-29' OR dat = '2009-09-01' OR dat = '2009-09-15' ".
" OR dat = '2009-11-01' OR dat = '2009-11-17' ".
" OR dat = '2009-12-24' OR dat = '2009-12-25' OR dat = '2009-12-26' ";
$upravene = mysql_query("$uprt");

//rozsirit kalendar
$sql = "ALTER TABLE kalendar ADD sood INT(2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE kalendar ADD sodo INT(2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE kalendar ADD neod INT(2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE kalendar ADD nedo INT(2) DEFAULT 0 AFTER svt";
$vysledek = mysql_query("$sql");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 ";
$upravene = mysql_query("$uprt");
//januar
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2009-01-01' AND dat <= '2009-01-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2009-01-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2009-01-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2009-01-05' AND dat <= '2009-01-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2009-01-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2009-01-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2009-01-12' AND dat <= '2009-01-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2009-01-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2009-01-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2009-01-19' AND dat <= '2009-01-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2009-01-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2009-01-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2009-01-26' AND dat <= '2009-01-30'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2009-01-31'";
$upravene = mysql_query("$uprt");
//februar
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2009-02-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2009-02-02' AND dat <= '2009-02-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2009-02-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2009-02-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2009-02-09' AND dat <= '2009-02-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2009-02-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2009-02-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2009-02-16' AND dat <= '2009-02-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2009-02-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2009-02-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2009-02-23' AND dat <= '2009-02-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2009-02-28'";
$upravene = mysql_query("$uprt");
//marec
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2009-03-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-03-02' AND dat <= '2009-03-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-03-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-03-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-03-09' AND dat <= '2009-03-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-03-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-03-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-03-16' AND dat <= '2009-03-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-03-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-03-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-03-23' AND dat <= '2009-03-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-03-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-03-29'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-03-30' AND dat <= '2009-03-31'";
$upravene = mysql_query("$uprt");
$sql = "ALTER TABLE kalendar ADD prcx1 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");
//april
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-04-01' AND dat <= '2009-04-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-04-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-04-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-04-06' AND dat <= '2009-04-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-04-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-04-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-04-13' AND dat <= '2009-04-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-04-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-04-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-04-20' AND dat <= '2009-04-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-04-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-04-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-04-27' AND dat <= '2009-04-30'";
$upravene = mysql_query("$uprt");
$sql = "ALTER TABLE kalendar ADD prcx2 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");
//maj sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=5, neod=5 WHERE dat >= '2009-05-01' AND dat <= '2009-05-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-05-04' AND dat <= '2009-05-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-05-11' AND dat <= '2009-05-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-05-18' AND dat <= '2009-05-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-05-25' AND dat <= '2009-05-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2009-05-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2009-05-03'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-05-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-05-10'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-05-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-05-17'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-05-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-05-24'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-05-30'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-05-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx05 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");


//jun sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-06-01' AND dat <= '2009-06-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-06-08' AND dat <= '2009-06-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-06-15' AND dat <= '2009-06-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-06-22' AND dat <= '2009-06-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-06-29' AND dat <= '2009-06-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-06-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-06-07'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-06-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-06-14'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-06-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-06-21'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-06-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-06-28'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx06 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//jul sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-07-01' AND dat <= '2009-07-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-07-06' AND dat <= '2009-07-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-07-13' AND dat <= '2009-07-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-07-20' AND dat <= '2009-07-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-07-27' AND dat <= '2009-07-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-07-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-07-05'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-07-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-07-12'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-07-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-07-19'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-07-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-07-26'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx07 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//august sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-08-03' AND dat <= '2009-08-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-08-10' AND dat <= '2009-08-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-08-17' AND dat <= '2009-08-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-08-24' AND dat <= '2009-08-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-08-31' AND dat <= '2009-08-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2009-08-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2009-08-02'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-08-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-08-09'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-08-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-08-16'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-08-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-08-23'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-08-29'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-08-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx08 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");


//september sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-09-01' AND dat <= '2009-09-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-09-07' AND dat <= '2009-09-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-09-14' AND dat <= '2009-09-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-09-21' AND dat <= '2009-09-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-09-28' AND dat <= '2009-09-30'";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-09-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-09-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-09-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-09-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-09-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-09-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-09-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-09-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx09 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//oktober sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2009-10-01' AND dat <= '2009-10-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2009-10-05' AND dat <= '2009-10-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2009-10-12' AND dat <= '2009-10-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2009-10-19' AND dat <= '2009-10-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2009-10-26' AND dat <= '2009-10-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2009-10-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2009-10-04'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2009-10-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2009-10-11'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2009-10-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2009-10-18'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2009-10-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2009-10-25'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2009-10-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx10 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//november sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-11-02' AND dat <= '2009-11-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-11-09' AND dat <= '2009-11-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-11-16' AND dat <= '2009-11-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-11-23' AND dat <= '2009-11-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-11-30' AND dat <= '2009-11-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2009-11-01'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-11-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-11-08'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-11-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-11-15'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-11-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-11-22'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-11-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-11-29'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx11 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//december sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2009-12-01' AND dat <= '2009-12-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2009-12-07' AND dat <= '2009-12-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2009-12-14' AND dat <= '2009-12-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2009-12-21' AND dat <= '2009-12-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2009-12-28' AND dat <= '2009-12-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2009-12-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2009-12-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2009-12-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2009-12-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2009-12-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2009-12-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2009-12-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2009-12-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD prcx12 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//koniec tabulky kalendar 2009


//pridat rok 2010 do tabulky kalendar
$sql = "SELECT rok2010 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "Kalendar 2010"."<br />";

$den=1;
$i=0;
  while ($i <= 364 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2010)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2010
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2010-01-01' OR dat = '2010-01-06' OR dat = '2010-04-02' OR dat = '2010-04-05' ".
" OR dat = '2010-05-01' OR dat = '2010-05-08' OR dat = '2010-07-05' ".
" OR dat = '2010-08-29' OR dat = '2010-09-01' OR dat = '2010-09-15' ".
" OR dat = '2010-11-01' OR dat = '2010-11-17' ".
" OR dat = '2010-12-24' OR dat = '2010-12-25' OR dat = '2010-12-26' ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2010 DECIMAL(4,0) DEFAULT 2010 AFTER svt";
$vysledek = mysql_query("$sql");
}
//koniec pridat 2010 do kalendara


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

//01.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=5, neod=5 WHERE dat >= '2010-01-01' AND dat <= '2010-01-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-01-04' AND dat <= '2010-01-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-01-11' AND dat <= '2010-01-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-01-18' AND dat <= '2010-01-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-01-25' AND dat <= '2010-01-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2010-01-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2010-01-03'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-01-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-01-10'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-01-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-01-17'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-01-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-01-24'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-01-30'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-01-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m012010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//02.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-02-01' AND dat <= '2010-02-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-02-08' AND dat <= '2010-02-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-02-15' AND dat <= '2010-02-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-02-22' AND dat <= '2010-02-26'";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-02-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-02-07'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-02-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-02-14'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-02-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-02-21'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-02-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-02-28'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m022010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//03.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-03-01' AND dat <= '2010-03-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-03-08' AND dat <= '2010-03-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-03-15' AND dat <= '2010-03-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-03-22' AND dat <= '2010-03-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-03-29' AND dat <= '2010-03-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-03-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-03-07'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-03-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-03-14'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-03-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-03-21'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-03-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-03-28'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m032010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//04.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-04-01' AND dat <= '2010-04-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-04-05' AND dat <= '2010-04-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-04-12' AND dat <= '2010-04-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-04-19' AND dat <= '2010-04-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-04-26' AND dat <= '2010-04-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-04-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-04-04'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-04-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-04-11'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-04-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-04-18'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-04-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-04-25'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m042010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//05.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-05-03' AND dat <= '2010-05-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-05-10' AND dat <= '2010-05-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-05-17' AND dat <= '2010-05-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-05-24' AND dat <= '2010-05-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-05-31' AND dat <= '2010-05-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2010-05-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2010-05-02'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-05-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-05-09'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-05-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-05-16'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-05-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-05-23'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-05-29'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-05-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m052010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//06.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-06-01' AND dat <= '2010-06-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-06-07' AND dat <= '2010-06-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-06-14' AND dat <= '2010-06-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-06-21' AND dat <= '2010-06-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-06-28' AND dat <= '2010-06-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-06-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-06-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-06-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-06-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-06-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-06-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-06-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-06-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m062010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//07.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2010-07-01' AND dat <= '2010-07-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2010-07-05' AND dat <= '2010-07-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2010-07-12' AND dat <= '2010-07-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2010-07-19' AND dat <= '2010-07-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2010-07-26' AND dat <= '2010-07-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2010-07-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2010-07-04'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2010-07-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2010-07-11'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2010-07-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2010-07-18'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2010-07-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2010-07-25'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2010-07-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m072010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//08.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-08-02' AND dat <= '2010-08-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-08-09' AND dat <= '2010-08-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-08-16' AND dat <= '2010-08-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-08-23' AND dat <= '2010-08-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-08-30' AND dat <= '2010-08-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2010-08-01'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-08-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-08-08'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-08-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-08-15'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-08-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-08-22'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-08-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-08-29'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m082010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//09.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-09-01' AND dat <= '2010-09-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-09-06' AND dat <= '2010-09-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-09-13' AND dat <= '2010-09-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-09-20' AND dat <= '2010-09-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-09-27' AND dat <= '2010-09-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-09-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-09-05'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-09-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-09-12'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-09-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-09-19'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-09-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-09-26'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m092010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//10.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=5, neod=5 WHERE dat >= '2010-10-01' AND dat <= '2010-10-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-10-04' AND dat <= '2010-10-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-10-11' AND dat <= '2010-10-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-10-18' AND dat <= '2010-10-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-10-25' AND dat <= '2010-10-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2010-10-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2010-10-03'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-10-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-10-10'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-10-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-10-17'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-10-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-10-24'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-10-30'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-10-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m102010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//11.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-11-01' AND dat <= '2010-11-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-11-08' AND dat <= '2010-11-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-11-15' AND dat <= '2010-11-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-11-22' AND dat <= '2010-11-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-11-29' AND dat <= '2010-11-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-11-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-11-07'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-11-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-11-14'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-11-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-11-21'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-11-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-11-28'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m112010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//12.2010 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2010-12-01' AND dat <= '2010-12-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2010-12-06' AND dat <= '2010-12-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2010-12-13' AND dat <= '2010-12-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2010-12-20' AND dat <= '2010-12-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2010-12-27' AND dat <= '2010-12-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2010-12-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2010-12-05'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2010-12-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2010-12-12'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2010-12-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2010-12-19'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2010-12-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2010-12-26'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m122010 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");



//pridat rok 2011 do tabulky kalendar
$sql = "SELECT rok2011 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "Kalendar 2011"."<br />";

$den=1;
$i=0;
  while ($i <= 364 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2011)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2011
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2011-01-01' OR dat = '2011-01-06' OR dat = '2011-04-22' OR dat = '2011-04-25' ".
" OR dat = '2011-05-01' OR dat = '2011-05-08' OR dat = '2011-07-05' ".
" OR dat = '2011-08-29' OR dat = '2011-09-01' OR dat = '2011-09-15' ".
" OR dat = '2011-11-01' OR dat = '2011-11-17' ".
" OR dat = '2011-12-24' OR dat = '2011-12-25' OR dat = '2011-12-26' ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2011 DECIMAL(4,0) DEFAULT 2011 AFTER svt";
$vysledek = mysql_query("$sql");
}
//koniec pridat 2011 do kalendara


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

//01.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-01-03' AND dat <= '2011-01-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-01-10' AND dat <= '2011-01-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-01-17' AND dat <= '2011-01-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-01-24' AND dat <= '2011-01-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-01-31' AND dat <= '2011-01-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2011-01-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2011-01-02'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-01-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-01-09'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-01-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-01-16'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-01-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-01-23'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-01-29'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-01-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m012011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");


//02.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-02-01' AND dat <= '2011-02-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-02-07' AND dat <= '2011-02-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-02-14' AND dat <= '2011-02-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-02-21' AND dat <= '2011-02-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-02-28' AND dat <= '2011-02-28'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-02-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-02-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-02-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-02-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-02-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-02-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-02-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-02-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m022011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//03.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-03-01' AND dat <= '2011-03-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-03-07' AND dat <= '2011-03-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-03-14' AND dat <= '2011-03-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-03-21' AND dat <= '2011-03-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-03-28' AND dat <= '2011-03-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-03-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-03-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-03-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-03-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-03-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-03-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-03-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-03-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m032011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//04.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2011-04-01' AND dat <= '2011-04-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2011-04-04' AND dat <= '2011-04-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2011-04-11' AND dat <= '2011-04-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2011-04-18' AND dat <= '2011-04-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2011-04-25' AND dat <= '2011-04-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2011-04-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2011-04-03'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2011-04-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2011-04-10'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2011-04-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2011-04-17'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2011-04-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2011-04-24'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2011-04-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m042011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//05.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-05-02' AND dat <= '2011-05-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-05-09' AND dat <= '2011-05-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-05-16' AND dat <= '2011-05-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-05-23' AND dat <= '2011-05-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-05-30' AND dat <= '2011-05-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2011-05-01'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-05-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-05-08'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-05-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-05-15'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-05-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-05-22'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-05-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-05-29'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m052011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//06.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-06-01' AND dat <= '2011-06-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-06-06' AND dat <= '2011-06-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-06-13' AND dat <= '2011-06-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-06-20' AND dat <= '2011-06-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-06-27' AND dat <= '2011-06-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-06-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-06-05'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-06-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-06-12'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-06-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-06-19'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-06-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-06-26'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m062011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//07.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=5, neod=5 WHERE dat >= '2011-07-01' AND dat <= '2011-07-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-07-04' AND dat <= '2011-07-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-07-11' AND dat <= '2011-07-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-07-18' AND dat <= '2011-07-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-07-25' AND dat <= '2011-07-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2011-07-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2011-07-03'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-07-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-07-10'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-07-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-07-17'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-07-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-07-24'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-07-30'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-07-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m072011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//08.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-08-01' AND dat <= '2011-08-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-08-08' AND dat <= '2011-08-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-08-15' AND dat <= '2011-08-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-08-22' AND dat <= '2011-08-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-08-29' AND dat <= '2011-08-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-08-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-08-07'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-08-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-08-14'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-08-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-08-21'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-08-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-08-28'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m082011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//09.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-09-01' AND dat <= '2011-09-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-09-05' AND dat <= '2011-09-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-09-12' AND dat <= '2011-09-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-09-19' AND dat <= '2011-09-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-09-26' AND dat <= '2011-09-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-09-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-09-04'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-09-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-09-11'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-09-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-09-18'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-09-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-09-25'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m092011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//10.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-10-03' AND dat <= '2011-10-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-10-10' AND dat <= '2011-10-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-10-17' AND dat <= '2011-10-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-10-24' AND dat <= '2011-10-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-10-31' AND dat <= '2011-10-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2011-10-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2011-10-02'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-10-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-10-09'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-10-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-10-16'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-10-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-10-23'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-10-29'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-10-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m102011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//11.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2011-11-01' AND dat <= '2011-11-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2011-11-07' AND dat <= '2011-11-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2011-11-14' AND dat <= '2011-11-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2011-11-21' AND dat <= '2011-11-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2011-11-28' AND dat <= '2011-11-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2011-11-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2011-11-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2011-11-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2011-11-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2011-11-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2011-11-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2011-11-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2011-11-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m112011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//12.2011 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2011-12-01' AND dat <= '2011-12-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2011-12-05' AND dat <= '2011-12-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2011-12-12' AND dat <= '2011-12-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2011-12-19' AND dat <= '2011-12-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2011-12-26' AND dat <= '2011-12-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2011-12-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2011-12-04'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2011-12-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2011-12-11'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2011-12-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2011-12-18'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2011-12-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2011-12-25'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2011-12-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m122011 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//KONIEC OD TADETO LEN JEDEN RAZ
echo "vytvoreny kalendar 2008-2011 ";
     }


//OD TADETO LEN JEDEN RAZ rok 2012
$sql = "SELECT rok2012 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {

echo "Vytvaram Kalendar 2012"."<br />";

$den=1;
$i=0;
  while ($i <= 365 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2012)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2012
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2012-01-01' OR dat = '2012-01-06' OR dat = '2012-04-06' OR dat = '2012-04-09' ".
" OR dat = '2012-05-01' OR dat = '2012-05-08' OR dat = '2012-07-05' ".
" OR dat = '2012-08-29' OR dat = '2012-09-01' OR dat = '2012-09-15' ".
" OR dat = '2012-11-01' OR dat = '2012-11-17' ".
" OR dat = '2012-12-24' OR dat = '2012-12-25' OR dat = '2012-12-26' ";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2012 DECIMAL(4,0) DEFAULT 2012 AFTER svt";
$vysledek = mysql_query("$sql");

     }
//OD TADETO LEN JEDEN RAZ rok 2012

//echo "Kalendar 2012 "."<br />";

//OD TADETO LEN JEDEN RAZ
$sql = "SELECT m092012 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
//01.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-01-02' AND dat <= '2012-01-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-01-09' AND dat <= '2012-01-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-01-16' AND dat <= '2012-01-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-01-23' AND dat <= '2012-01-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2012-01-30' AND dat <= '2012-01-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2012-01-01'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-01-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-01-08'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-01-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-01-15'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-01-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-01-22'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-01-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-01-29'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m012012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//02.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-02-01' AND dat <= '2012-02-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-02-06' AND dat <= '2012-02-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-02-13' AND dat <= '2012-02-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-02-20' AND dat <= '2012-02-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2012-02-27' AND dat <= '2012-02-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-02-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-02-05'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-02-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-02-12'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-02-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-02-19'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-02-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-02-26'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m022012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//03.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2012-03-01' AND dat <= '2012-03-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2012-03-05' AND dat <= '2012-03-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2012-03-12' AND dat <= '2012-03-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2012-03-19' AND dat <= '2012-03-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2012-03-26' AND dat <= '2012-03-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2012-03-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2012-03-04'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2012-03-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2012-03-11'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2012-03-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2012-03-18'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2012-03-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2012-03-25'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2012-03-31'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m032012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//04.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-04-02' AND dat <= '2012-04-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-04-09' AND dat <= '2012-04-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-04-16' AND dat <= '2012-04-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-04-23' AND dat <= '2012-04-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2012-04-30' AND dat <= '2012-04-30'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2012-04-01'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-04-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-04-08'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-04-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-04-15'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-04-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-04-22'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-04-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-04-29'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m042012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//05.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-05-01' AND dat <= '2012-05-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-05-07' AND dat <= '2012-05-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-05-14' AND dat <= '2012-05-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-05-21' AND dat <= '2012-05-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2012-05-28' AND dat <= '2012-05-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-05-05'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-05-06'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-05-12'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-05-13'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-05-19'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-05-20'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-05-26'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-05-27'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m052012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//06.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=5, neod=4 WHERE dat >= '2012-06-01' AND dat <= '2012-06-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=4, neod=3 WHERE dat >= '2012-06-04' AND dat <= '2012-06-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=3, neod=2 WHERE dat >= '2012-06-11' AND dat <= '2012-06-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=2, neod=1 WHERE dat >= '2012-06-18' AND dat <= '2012-06-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=1, neod=0 WHERE dat >= '2012-06-25' AND dat <= '2012-06-29'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=4, sood=4, neod=4 WHERE dat = '2012-06-02'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=3 WHERE dat = '2012-06-03'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=3, sood=3, neod=3 WHERE dat = '2012-06-09'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=2 WHERE dat = '2012-06-10'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=2, sood=2, neod=2 WHERE dat = '2012-06-16'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=1 WHERE dat = '2012-06-17'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=1, sood=1, neod=1 WHERE dat = '2012-06-23'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=0 WHERE dat = '2012-06-24'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=0, sood=0, neod=0 WHERE dat = '2012-06-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m062012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//07.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-07-02' AND dat <= '2012-07-06'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-07-09' AND dat <= '2012-07-13'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-07-16' AND dat <= '2012-07-20'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-07-23' AND dat <= '2012-07-27'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2012-07-30' AND dat <= '2012-07-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2012-07-01'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-07-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-07-08'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-07-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-07-15'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-07-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-07-22'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-07-28'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-07-29'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m072012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//08.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-08-01' AND dat <= '2012-08-03'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-08-06' AND dat <= '2012-08-10'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-08-13' AND dat <= '2012-08-17'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-08-20' AND dat <= '2012-08-24'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=0, sood=0, neod=0 WHERE dat >= '2012-08-27' AND dat <= '2012-08-31'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-08-04'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-08-05'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-08-11'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-08-12'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-08-18'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-08-19'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-08-25'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-08-26'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m082012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//09.2012 sodo=soboty od tohoto datumu dokonca mesiaca vratane tohoto datumu, sood=soboty od tohoto datumu do konca mesiaca bez tohoto datumu
$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=4, neod=4 WHERE dat >= '2012-09-03' AND dat <= '2012-09-07'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=3, neod=3 WHERE dat >= '2012-09-10' AND dat <= '2012-09-14'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=2, neod=2 WHERE dat >= '2012-09-17' AND dat <= '2012-09-21'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=1, neod=1 WHERE dat >= '2012-09-24' AND dat <= '2012-09-28'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=5, nedo=5, sood=4, neod=5 WHERE dat = '2012-09-01'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=4, nedo=5, sood=4, neod=4 WHERE dat = '2012-09-02'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=4, nedo=4, sood=3, neod=4 WHERE dat = '2012-09-08'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=3, nedo=4, sood=3, neod=3 WHERE dat = '2012-09-09'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=3, nedo=3, sood=2, neod=3 WHERE dat = '2012-09-15'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=2, nedo=3, sood=2, neod=2 WHERE dat = '2012-09-16'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=2, nedo=2, sood=1, neod=2 WHERE dat = '2012-09-22'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=1, nedo=2, sood=1, neod=1 WHERE dat = '2012-09-23'";
$upravene = mysql_query("$uprt");

$uprt = "UPDATE kalendar SET sodo=1, nedo=1, sood=0, neod=1 WHERE dat = '2012-09-29'";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET sodo=0, nedo=1, sood=0, neod=0 WHERE dat = '2012-09-30'";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD m092012 INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

//KONIEC OD TADETO LEN JEDEN RAZ
//$sql = "SELECT m092012 FROM kalendar";
//echo "toto uz nie";
     }
//echo "toto ano";


$sql = "SELECT m122012 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="10.2012"; }
if( $i == 2 ) { $kli_vumeabc="11.2012"; }
if( $i == 3 ) { $kli_vumeabc="12.2012"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");


$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//koniec $sql = "SELECT m122012 FROM kalendar";
     }

//OD TADETO LEN JEDEN RAZ rok 2013
$sql = "SELECT rok2013 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {

echo "Vytvaram Kalendar 2013"."<br />";

$den=1;
$i=0;
  while ($i <= 364 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2013)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2013
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2013-01-01' OR dat = '2013-01-06' OR dat = '2013-03-29' OR dat = '2013-04-01' ".
" OR dat = '2013-05-01' OR dat = '2013-05-08' OR dat = '2013-07-05' ".
" OR dat = '2013-08-29' OR dat = '2013-09-01' OR dat = '2013-09-15' ".
" OR dat = '2013-11-01' OR dat = '2013-11-17' ".
" OR dat = '2013-12-24' OR dat = '2013-12-25' OR dat = '2013-12-26' ";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2013 DECIMAL(4,0) DEFAULT 2013 AFTER svt";
$vysledek = mysql_query("$sql");

     }
//koniec OD TADETO LEN JEDEN RAZ rok 2013

//echo "Kalendar 2013 "."<br />";

$sql = "SELECT m032013 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 01-03.2013"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="01.2013"; }
if( $i == 2 ) { $kli_vumeabc="02.2013"; }
if( $i == 3 ) { $kli_vumeabc="03.2013"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");


$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

// koniec $sql = "SELECT m032013 FROM kalendar";
     }

$sql = "SELECT m062013 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 04-06.2013"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="04.2013"; }
if( $i == 2 ) { $kli_vumeabc="05.2013"; }
if( $i == 3 ) { $kli_vumeabc="06.2013"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");


$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

// koniec $sql = "SELECT m062013 FROM kalendar";
     }

$sql = "SELECT m092013 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 07-09.2013"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="07.2013"; }
if( $i == 2 ) { $kli_vumeabc="08.2013"; }
if( $i == 3 ) { $kli_vumeabc="09.2013"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 09.2013 AND dat < '2013-09-27' ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=1, sodo=1 WHERE dat = '2013-09-27' ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=0, sodo=1 WHERE dat = '2013-09-28' ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=0, sodo=0 WHERE dat = '2013-09-29' ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=0, sodo=0 WHERE dat = '2013-09-30' ";
$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m092013 FROM kalendar";
     }

$sql = "SELECT m122013 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 10-12.2013"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="10.2013"; }
if( $i == 2 ) { $kli_vumeabc="11.2013"; }
if( $i == 3 ) { $kli_vumeabc="12.2013"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 12.2013 AND dat <= '2013-12-31' ";
$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m122013 FROM kalendar";
     }

//OD TADETO LEN JEDEN RAZ rok 2014
$sql = "SELECT rok2014 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {

echo "Vytvaram Kalendar 2014"."<br />";

$den=1;
$i=0;
  while ($i <= 364 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2014)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2014
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2014-01-01' OR dat = '2014-01-06' OR dat = '2014-04-18' OR dat = '2014-04-21' ".
" OR dat = '2014-05-01' OR dat = '2014-05-08' OR dat = '2014-07-05' ".
" OR dat = '2014-08-29' OR dat = '2014-09-01' OR dat = '2014-09-15' ".
" OR dat = '2014-11-01' OR dat = '2014-11-17' ".
" OR dat = '2014-12-24' OR dat = '2014-12-25' OR dat = '2014-12-26' ";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2014 DECIMAL(4,0) DEFAULT 2014 AFTER svt";
$vysledek = mysql_query("$sql");

     }
//koniec OD TADETO LEN JEDEN RAZ rok 2014


$sql = "SELECT m032014 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 01-03.2014"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="01.2014"; }
if( $i == 2 ) { $kli_vumeabc="02.2014"; }
if( $i == 3 ) { $kli_vumeabc="03.2014"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 12.2013 AND dat <= '2013-12-31' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m032014 FROM kalendar";
     }

$sql = "SELECT m062014 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 04-06.2014"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="04.2014"; }
if( $i == 2 ) { $kli_vumeabc="05.2014"; }
if( $i == 3 ) { $kli_vumeabc="06.2014"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 6.2014 AND dat <= '2014-06-30' ";
$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m062014 FROM kalendar";
     }


$sql = "SELECT m092014 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 07-09.2014"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="07.2014"; }
if( $i == 2 ) { $kli_vumeabc="08.2014"; }
if( $i == 3 ) { $kli_vumeabc="09.2014"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 6.2014 AND dat <= '2014-06-30' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m092014 FROM kalendar";
     }

$sql = "SELECT m122014 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 10-12.2014"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="10.2014"; }
if( $i == 2 ) { $kli_vumeabc="11.2014"; }
if( $i == 3 ) { $kli_vumeabc="12.2014"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 6.2014 AND dat <= '2014-06-30' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m122014 FROM kalendar";
     }

//echo "Kalendar 2015 "."<br />";

//OD TADETO LEN JEDEN RAZ rok 2015
$sql = "SELECT rok2015 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {

echo "Vytvaram Kalendar 2015"."<br />";

$den=1;
$i=0;
  while ($i <= 364 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2015)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2015
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2015-01-01' OR dat = '2015-01-06' OR dat = '2015-04-03' OR dat = '2015-04-06' ".
" OR dat = '2015-05-01' OR dat = '2015-05-08' OR dat = '2015-07-05' ".
" OR dat = '2015-08-29' OR dat = '2015-09-01' OR dat = '2015-09-15' ".
" OR dat = '2015-11-01' OR dat = '2015-11-17' ".
" OR dat = '2015-12-24' OR dat = '2015-12-25' OR dat = '2015-12-26' ";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2015 DECIMAL(4,0) DEFAULT 2015 AFTER svt";
$vysledek = mysql_query("$sql");

     }
//koniec OD TADETO LEN JEDEN RAZ rok 2015

$sql = "SELECT m032015 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 01-03.2015"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="01.2015"; }
if( $i == 2 ) { $kli_vumeabc="02.2015"; }
if( $i == 3 ) { $kli_vumeabc="03.2015"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 2.2015 AND dat <= '2015-02-28' ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 3.2015 AND dat <= '2015-03-31' ";
$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m032015 FROM kalendar";
     }

$sql = "SELECT m062015 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 04-06.2015"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="04.2015"; }
if( $i == 2 ) { $kli_vumeabc="05.2015"; }
if( $i == 3 ) { $kli_vumeabc="06.2015"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 2.2015 AND dat <= '2015-02-28' ";
//$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 3.2015 AND dat <= '2015-03-31' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m062015 FROM kalendar";
     }

$sql = "SELECT m092015 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 07-09.2015"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="07.2015"; }
if( $i == 2 ) { $kli_vumeabc="08.2015"; }
if( $i == 3 ) { $kli_vumeabc="09.2015"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak prva nedela zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 2.2015 AND dat <= '2015-02-28' ";
//$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 3.2015 AND dat <= '2015-03-31' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m092015 FROM kalendar";
     }


$sql = "SELECT m122015 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 10-12.2015"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="10.2015"; }
if( $i == 2 ) { $kli_vumeabc="11.2015"; }
if( $i == 3 ) { $kli_vumeabc="12.2015"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak je prva nedela v mesiaci zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 11.2015 AND dat <= '2015-11-30' ";
$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m122015 FROM kalendar";
     }

echo "Kalendar 2016 "."<br />";

//OD TADETO LEN JEDEN RAZ rok 2016
$sql = "SELECT rok2016 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {

echo "Vytvaram Kalendar 2016"."<br />";

$den=1;
$i=0;
  while ($i <= 365 )
  {

$datum = Date ("Y-m-d", MkTime (0,0,0,1,$den+$i,2016)); 
//echo $datum;
$pole = explode("-", $datum);
$h_ume = $pole[1].".".$pole[0];

$ttvv = "INSERT INTO kalendar ( dat,ume,akyden,svt ) VALUES ( '$datum', '$h_ume', '0', '0' )";
$ttqq = mysql_query("$ttvv");

$i = $i + 1;
  }

//sviatky 2016
$uprt = "UPDATE kalendar SET svt=1".
" WHERE dat = '2016-01-01' OR dat = '2016-01-06' OR dat = '2016-05-25' OR dat = '2016-03-28' ".
" OR dat = '2016-05-01' OR dat = '2016-05-08' OR dat = '2016-07-05' ".
" OR dat = '2016-08-29' OR dat = '2016-09-01' OR dat = '2016-09-15' ".
" OR dat = '2016-11-01' OR dat = '2016-11-17' ".
" OR dat = '2016-12-24' OR dat = '2016-12-25' OR dat = '2016-12-26' ";
$upravene = mysql_query("$uprt");


$uprt = "UPDATE kalendar SET akyden=DAYOFWEEK(dat)".
" WHERE ume > 0 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=8".
" WHERE akyden = 1 ";
$upravene = mysql_query("$uprt");
$uprt = "UPDATE kalendar SET akyden=akyden-1".
" WHERE akyden > 0 ";
$upravene = mysql_query("$uprt");

$sql = "ALTER TABLE kalendar ADD rok2016 DECIMAL(4,0) DEFAULT 2016 AFTER svt";
$vysledek = mysql_query("$sql");

     }
//koniec OD TADETO LEN JEDEN RAZ rok 2016

$sql = "SELECT m032016 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 01-03.2016"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="01.2016"; }
if( $i == 2 ) { $kli_vumeabc="02.2016"; }
if( $i == 3 ) { $kli_vumeabc="03.2016"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak je prva nedela v mesiaci zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 11.2015 AND dat <= '2015-11-30' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m032016 FROM kalendar";
     }


$sql = "SELECT m062016 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 04-06.2016"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="04.2016"; }
if( $i == 2 ) { $kli_vumeabc="05.2016"; }
if( $i == 3 ) { $kli_vumeabc="06.2016"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak je prva nedela v mesiaci zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 5.2016 AND dat <= '2016-05-31' ";
$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m062016 FROM kalendar";
     }

$sql = "SELECT m092016 FROM kalendar";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
echo "So a Ne 07-09.2016"."<br />";

$i=1;
while ($i <= 3 )
 {

if( $i == 1 ) { $kli_vumeabc="07.2016"; }
if( $i == 2 ) { $kli_vumeabc="08.2016"; }
if( $i == 3 ) { $kli_vumeabc="09.2016"; }

$sqlttt = "UPDATE kalendar SET m092012=WEEK(dat) WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET m092012=m092012-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc ORDER BY dat";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $akyden=1*$riaddok->akyden;
  $tyzden=1*$riaddok->m092012;
  }

$sqlttt = "UPDATE kalendar SET m082012=m092012-$tyzden WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt"); $pocetsobot = 1*mysql_num_rows($sqldok);

$sqlttt = "SELECT * FROM kalendar WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt"); $pocetnedel = 1*mysql_num_rows($sqldok);

$sqlttt = "UPDATE kalendar SET sodo=$pocetsobot-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET nedo=$pocetnedel-m082012 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sodo=sodo-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET neod=nedo, sood=sodo WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET sood=sood-1 WHERE ume = $kli_vumeabc AND akyden = 6 ";
$sqldok = mysql_query("$sqlttt");
$sqlttt = "UPDATE kalendar SET neod=neod-1 WHERE ume = $kli_vumeabc AND akyden = 7 ";
$sqldok = mysql_query("$sqlttt");

$sqlttt = "UPDATE kalendar SET m082012=0, m092012=0 WHERE ume = $kli_vumeabc ";
$sqldok = mysql_query("$sqlttt");

$pole = explode(".", $kli_vumeabc);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pridaj="m".$kli_vmes.$kli_vrok;

$sql = "ALTER TABLE kalendar ADD $pridaj INT(2) DEFAULT 0 AFTER sood";
$vysledek = mysql_query("$sql");

$i=$i+1;
 }

//pozor ak je prva nedela v mesiaci zmen datum na posledny den mesiaca 30, 31
$sqlttt = "UPDATE kalendar SET sood=sood+1, sodo=sodo+1 WHERE ume = 5.2016 AND dat <= '2016-05-31' ";
//$sqldok = mysql_query("$sqlttt");

// koniec $sql = "SELECT m092016 FROM kalendar";
     }

$vtvkal = 1;
return $vtvkal;
?>
</BODY>
</HTML>