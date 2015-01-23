<!DOCTYPE html   PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>vtvall.php</title>
</head>
<body>
<?php


$sql = "USE $mysqldb";
$vysledek = mysql_query("$sql");


//Tabulka STR
$sql = "SELECT * FROM F$kli_vxcf"."_str";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<STR
(
   str         INT,
   nst         VARCHAR(30),
   dst         INT,
   ust         VARCHAR(10),
   datm        TIMESTAMP(14)
);
STR;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_str'.$sqlt;

$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_str ( str,nst,dst,ust ) VALUES ( '1', 'Stredisko 1', '1', '1' )";
$ttqq = mysql_query("$ttvv");
}
//koniec tabulky STR


//Tabulka STv
$sql = "SELECT * FROM F$kli_vxcf"."_stv";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<stv
(
   stv         INT,
   nsv         VARCHAR(30),
   dsv         INT,
   usv         VARCHAR(10),
   datm        TIMESTAMP(14)
);
stv;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_stv'.$sqlt;

$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_stv ( stv,nsv,dsv,usv ) VALUES ( '1', 'Stavba 1', '1', '1' )";
$ttqq = mysql_query("$ttvv");
}
//koniec tabulky STv


//Tabulka Sku
$sql = "SELECT * FROM F$kli_vxcf"."_sku";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<sku
(
   sku         INT,
   nsu         VARCHAR(30),
   dsu         INT,
   usu         VARCHAR(10),
   datm        TIMESTAMP(14)
);
sku;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_sku'.$sqlt;

$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_sku ( sku,nsu,dsu,usu ) VALUES ( '1', 'Skupina 1', '1', '1' )";
$ttqq = mysql_query("$ttvv");
}
//koniec tabulky sku


//Tabulka ZAK
$sql = "SELECT * FROM F$kli_vxcf"."_zak";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<ZAK
(
   str         INT,
   zak         INT,
   nza         VARCHAR(30),
   sku         INT,
   stv         INT,
   dzk         INT,
   uzk         VARCHAR(10),
   datm        TIMESTAMP(14)
);
ZAK;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_zak'.$sqlt;

$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_zak ( str,zak,nza,sku,stv,dzk,uzk ) VALUES ( '1', '1', 'Zákazka 1', '1', '1', '1', '1' )";
$ttqq = mysql_query("$ttvv");

//primarne kluce
$sql = "ALTER TABLE F$kli_vxcf"."_zak  ADD PRIMARY KEY ( 'str' , 'zak' )";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zak  ADD UNIQUE ( str, zak )";
$vysledek = mysql_query("$sql");
}
//koniec tabulky ZAK


//Tabulka ufir
$sql = "SELECT uctt01 FROM F$kli_vxcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<ufir
(
   udaje        INT,
   fico         INT(10),
   fdic         VARCHAR(15),
   ficd         VARCHAR(15),
   fnaz         VARCHAR(60),
   fuli         VARCHAR(40),
   fmes         VARCHAR(40),
   fpsc         VARCHAR(6),
   ftel         VARCHAR(20),
   ffax         VARCHAR(20),
   fwww         VARCHAR(30),
   fem1         VARCHAR(30),
   fem2         VARCHAR(30),
   fem3         VARCHAR(30),
   fem4         VARCHAR(30),
   fuc1         VARCHAR(30),
   fnm1         VARCHAR(30),
   fnb1         VARCHAR(30),
   fsb1         VARCHAR(30),
   fib1         VARCHAR(30),
   fuc2         VARCHAR(30),
   fnm2         VARCHAR(30),
   fnb2         VARCHAR(30),
   fsb2         VARCHAR(30),
   fib2         VARCHAR(30),
   fuc3         VARCHAR(30),
   fnm3         VARCHAR(30),
   fnb3         VARCHAR(30),
   fsb3         VARCHAR(30),
   fib3         VARCHAR(30),
   fuc4         VARCHAR(30),
   fnm4         VARCHAR(30),
   fnb4         VARCHAR(30),
   fsb4         VARCHAR(30),
   fib4         VARCHAR(30),
   fuc5         VARCHAR(30),
   fnm5         VARCHAR(30),
   fnb5         VARCHAR(30),
   fsb5         VARCHAR(30),
   fib5         VARCHAR(30),
   fuc6         VARCHAR(30),
   fnm6         VARCHAR(30),
   fnb6         VARCHAR(30),
   fsb6         VARCHAR(30),
   fib6         VARCHAR(30),
   dph1         INT(5),
   dph2         INT(5),
   dph3         INT(5),
   dph4         INT(5),
   datm        TIMESTAMP(14)
);
ufir;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_ufir'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "INSERT INTO F".$kli_vxcf."_ufir"." (udaje,fico,fnaz,fuli,fpsc,fmes,fuc1,fnm1,dph1,dph2,dph3,dph4 )".
" VALUES ( 1, '31213121', 'Názov vašej firmy', 'Ulica', '90501', 'Senica', '0', '0', 10, 20, 5, 22  )"; 
$vysledek = mysql_query("$sql");

//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mena1 VARCHAR(5) AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mena2 VARCHAR(5) AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD kurz12 VARCHAR(8) AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD obreg VARCHAR(40) AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD sklstr INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD sklzak INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD sklcpr INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD sklcps INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD sklcvd INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD sklcis INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakdod INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakodb INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakobj INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakdol INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakprf INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakstr INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakzak INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk04 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk03 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk02 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xsk01 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa04 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa03 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa02 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa01 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD pokpri INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD pokvyd INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fakvnp INT AFTER fakprf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xdp06 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xdp05 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xdp04 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xdp03 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xdp02 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xdp01 INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopfak INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopdol INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopvnp INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopstz INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopreg INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopobj INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopstr INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD dopzak INT AFTER dph4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD fcdm VARCHAR(15) AFTER fuli";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa05 INT AFTER xfa04";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa06 INT AFTER xfa05";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa07 INT AFTER xfa06";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa08 INT AFTER xfa07";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_ufir"." SET fcdm='1020/50', mena1='Eur', mena2='Sk', kurz12='30.1260',".
" sklcpr='410001', sklcvd='510001', sklcps='610001', sklcis='1', sklstr='1', sklzak='1',".
" fakodb='710001', fakdod='810001', fakobj='990001', fakprf='980001', fakdol='970001', fakvnp='660001', ".
" fakstr='1', fakzak='1', xfa01='1', xfa02='2', xfa03='21100', xfa04='1', xfa05='1', ".
" pokpri='10001', pokvyd='20001',".
" dopfak='580001', dopdol='590001', dopvnp='570001', dopstz='560001', dopreg='110001', dopobj='550001', ".
" dopstr='1', dopzak='1', xdp01='1', xdp02='2', xdp03='21100', xdp04='0', xdp05='80001', xdp06='90001'  ".
" WHERE udaje = 1";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa05 INT AFTER xfa04";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa06 INT AFTER xfa05";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD xfa07 INT AFTER xfa06";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD majx05 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD majx04 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD majx03 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD majx02 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD majx01 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx14 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx13 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx12 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx11 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx10 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx09 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx08 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx07 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx06 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx05 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx04 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx03 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx02 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctx01 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctt05 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctt04 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctt03 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctt02 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uctt01 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F".$kli_vxcf."_ufir SET".
" fakodb='750001', fakdod='850001', pokpri='10001', pokvyd='20001', uctx04='30001', uctx05='40001', uctx13='50001', ".
" uctx01='1', uctx02='1', uctx03='1', uctx09='0', uctx12='0', uctx14='0'  ".
" WHERE udaje = 1";
$vysledek = mysql_query("$sql");
}
//rozsir o parametre mzdy
$sql = "SELECT mzdx01 FROM F$kli_vxcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx09 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx08 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx07 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx06 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx05 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx04 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx03 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx02 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdx01 INT AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdt05 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdt04 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdt03 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdt02 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD mzdt01 VARCHAR(30) AFTER mena1";
$vysledek = mysql_query("$sql");
}
//rozsir viac parametrov k fak
$sql = "SELECT uc1fk FROM F$kli_vxcf"."_ufir";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uc3fk INT DEFAULT 1 AFTER mzdx09";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uc2fk INT DEFAULT 1 AFTER mzdx09";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufir ADD uc1fk INT DEFAULT 1 AFTER mzdx09";
$vysledek = mysql_query("$sql");
}
//koniec tabulky ufir

//Tabulka ICO
$sql = "SELECT * FROM F$kli_vxcf"."_ico";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<ico
(
   ico         INT(10) PRIMARY KEY,
   dic         VARCHAR(30) not null,
   icd         VARCHAR(30) not null,
   nai         VARCHAR(35) not null,
   na2         VARCHAR(50) not null,
   uli         VARCHAR(50) not null,
   psc         VARCHAR(7) not null,
   mes         VARCHAR(35) not null,
   tel         VARCHAR(50) not null,
   fax         VARCHAR(50) not null,
   em1         VARCHAR(50) not null,
   em2         VARCHAR(50) not null,
   em3         VARCHAR(50) not null,
   www         VARCHAR(50) not null,
   uc1         VARCHAR(25) not null,
   nm1         VARCHAR(4) not null,
   uc2         VARCHAR(25) not null,
   nm2         VARCHAR(4) not null,
   uc3         VARCHAR(25) not null,
   nm3         VARCHAR(4) not null,
   dns         INT(3) DEFAULT 0,
   datm        TIMESTAMP(14)
);
ico;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_ico'.$sqlt;

$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_ico ( ico,dic,icd,nai,uli,psc,mes,uc1,nm1,em1,tel ) VALUES ( '44551142', '2022753887', 'SK2022753887', 'EDcom s.r.o.', 'Sotinská 1474/11', '90501', 'Senica', '2625811363', '1100', 'edcom@edcom.sk', '0905/804265' )";
$ttqq = mysql_query("$ttvv");

$sql = "ALTER TABLE F$kli_vxcf"."_ico ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico ADD ib1 varchar(40) not null AFTER nm1";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico ADD ib2 varchar(40) not null AFTER nm2";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico ADD ib3 varchar(40) not null AFTER nm3";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_ico MODIFY ib1 varchar(40) not null ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico MODIFY ib2 varchar(40) not null ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ico MODIFY ib3 varchar(40) not null ";
$vysledek = mysql_query("$sql");
//koniec tabulky ICO

//Tabulka icoodbm
$sql = "SELECT * FROM F$kli_vxcf"."_icoodbm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<icoodbm
(
   ico          INT(10),
   odbm         INT(10) DEFAULT 0,
   onai         VARCHAR(35) NOT NULL,
   ona2         VARCHAR(50) NOT NULL,
   ouli         VARCHAR(50) NOT NULL,
   opsc         VARCHAR(7) NOT NULL,
   omes         VARCHAR(35) NOT NULL,
   poz1         VARCHAR(35) NOT NULL,
   poz2         VARCHAR(35) NOT NULL
);
icoodbm;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_icoodbm'.$sqlt;

$vysledek = mysql_query("$sql");

}
//koniec tabulky icoodbm

//rozsirenie klienti
$sql = "ALTER TABLE klienti ADD fak_prav varchar(10) AFTER skl_prav";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE klienti ADD vyr_prav varchar(10) AFTER ana_prav";
$vysledek = mysql_query("$sql");
//koniec rozsirenia klienti

//Tabulka krtgrd
$sql = "SELECT * FROM krtgrd";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<krtgrd
(
   id          INT UNIQUE,
   a1          INT(10) DEFAULT 1234,
   a2          INT(10) DEFAULT 1234,
   a3          INT(10) DEFAULT 1234,
   a4          INT(10) DEFAULT 1234,
   a5          INT(10) DEFAULT 1234,
   a6          INT(10) DEFAULT 1234,
   b1          INT(10) DEFAULT 1234,
   b2          INT(10) DEFAULT 1234,
   b3          INT(10) DEFAULT 1234,
   b4          INT(10) DEFAULT 1234,
   b5          INT(10) DEFAULT 1234,
   b6          INT(10) DEFAULT 1234,
   c1          INT(10) DEFAULT 1234,
   c2          INT(10) DEFAULT 1234,
   c3          INT(10) DEFAULT 1234,
   c4          INT(10) DEFAULT 1234,
   c5          INT(10) DEFAULT 1234,
   c6          INT(10) DEFAULT 1234,
   d1          INT(10) DEFAULT 1234,
   d2          INT(10) DEFAULT 1234,
   d3          INT(10) DEFAULT 1234,
   d4          INT(10) DEFAULT 1234,
   d5          INT(10) DEFAULT 1234,
   d6          INT(10) DEFAULT 1234,
   e1          INT(10) DEFAULT 1234,
   e2          INT(10) DEFAULT 1234,
   e3          INT(10) DEFAULT 1234,
   e4          INT(10) DEFAULT 1234,
   e5          INT(10) DEFAULT 1234,
   e6          INT(10) DEFAULT 1234,
   f1          INT(10) DEFAULT 1234,
   f2          INT(10) DEFAULT 1234,
   f3          INT(10) DEFAULT 1234,
   f4          INT(10) DEFAULT 1234,
   f5          INT(10) DEFAULT 1234,
   f6          INT(10) DEFAULT 1234,
   nepl        INT(10) DEFAULT 0,
   aktiv       INT(10) DEFAULT 1
);
krtgrd;

$sql = 'CREATE TABLE krtgrd'.$sqlt;

$vysledek = mysql_query("$sql");
}
//koniec tabulky krtgrd

//tabulka dealeri
$sql = "SELECT * FROM F$kli_vxcf"."_dealeri";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<dealeri
(
   deal        DECIMAL(13,0),
   ndea        VARCHAR(30),
   ddea        DECIMAL(13,0),
   udea        DECIMAL(13,0),
   dec1        DECIMAL(13,0),
   dec2        DECIMAL(13,0),
   dec3        DECIMAL(13,0),
   dec4        DECIMAL(13,2),
   dec5        DECIMAL(13,2),
   dec6        DECIMAL(13,2),
   det1        TEXT,
   det2        TEXT,
   det3        TEXT
);
dealeri;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dealeri'.$sqlt;
$vysledok = mysql_query("$sql");
}

//Tabulka vtvall
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvall
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvall;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_vtvall'.$sqlt;

$vysledek = mysql_query("$sql");

}
//koniec tabulky vtvall


$vtvall = 1;
return $vtvall;
?>
</BODY>
</HTML>