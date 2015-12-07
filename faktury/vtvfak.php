<!DOCTYPE html   PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>vtvfak.php</title>
</head>
<body>
<?php
//echo "Nastavit databazu $mysqldb!"."<br />";
$sql = "USE $rtxdt";
$vysledek = mysql_query("$sql");
if ($vysledek)
     //echo "Databaza $mysqldb nastavena."."<br />";


//Tabulka fakodb
$sql = "SELECT * FROM F$kli_vxcf"."_fakodb";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakodb!"."<br />";

$sqlt = <<<fakodb
(
   uce     VARCHAR(10),
   ume     FLOAT(8,4),
   dat     DATE,
   dav     DATE,
   das     DATE,
   daz     DATE,
   dok     INT(8),
   doq     INT(8),
   skl     int(11) DEFAULT 0,
   poh     int(2) DEFAULT 0,
   ico     int(10),
   fak     int(10),
   dol     int(10),
   prf     int(10),
   obj     varchar(15) NOT NULL,
   unk     varchar(15) NOT NULL,
   dpr     varchar(20) NOT NULL,
   ksy     varchar(4) NOT NULL,
   ssy     varchar(10) NOT NULL,
   poz     varchar(80) NOT NULL,
   str     int(11),
   zak     int(11),
   txz     text NOT NULL,
   txp     text NOT NULL,
   zk0     decimal(10,2) DEFAULT 0,
   zk1     decimal(10,2) DEFAULT 0,
   zk2     decimal(10,2) DEFAULT 0,
   zk3     decimal(10,2) DEFAULT 0,
   zk4     decimal(10,2) DEFAULT 0,
   dn1     decimal(10,2) DEFAULT 0,
   dn2     decimal(10,2) DEFAULT 0,
   dn3     decimal(10,2) DEFAULT 0,
   dn4     decimal(10,2) DEFAULT 0,
   sp1     decimal(10,2) DEFAULT 0,
   sp2     decimal(10,2) DEFAULT 0,
   sz1     int(2) DEFAULT 0,
   sz2     int(2) DEFAULT 0,
   sz3     int(2) DEFAULT 0,
   sz4     int(2) DEFAULT 0,
   zk0u    decimal(10,2) DEFAULT 0,
   zk1u    decimal(10,2) DEFAULT 0,
   zk2u    decimal(10,2) DEFAULT 0,
   dn1u    decimal(10,2) DEFAULT 0,
   dn2u    decimal(10,2) DEFAULT 0,
   sp0u    decimal(10,2) DEFAULT 0,
   sp1u    decimal(10,2) DEFAULT 0,
   sp2u    decimal(10,2) DEFAULT 0,
   hodu    decimal(10,2) DEFAULT 0,
   hod     decimal(10,2) DEFAULT 0,
   hodm    decimal(10,2) DEFAULT 0,
   kurz    decimal(10,4) DEFAULT 0,
   mena    varchar(5) NOT NULL,     
   zmen    int(1) DEFAULT 0,
   odbm    int(10) DEFAULT 0,
   zal     decimal(10,2) DEFAULT 0,
   zao     decimal(10,2) DEFAULT 0,
   ruc     decimal(10,2) DEFAULT 0,
   uhr     decimal(10,2) DEFAULT 0,
   id      int(11) DEFAULT 0,
   datm    timestamp(14)
);
fakodb;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakodb'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakodb'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakodb ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_fakodb MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky fakodb

//Tabulka fakodbpoc
$sql = "SELECT * FROM F$kli_vxcf"."_fakodbpoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakodbpoc!"."<br />";

$sqlt = <<<fakodbpoc
(
   uce     VARCHAR(10),
   ume     FLOAT(8,4),
   dat     DATE,
   dav     DATE,
   das     DATE,
   daz     DATE,
   dok     INT(8),
   doq     INT(8),
   skl     int(11) DEFAULT 0,
   poh     int(2) DEFAULT 0,
   ico     int(10),
   fak     int(10),
   dol     int(10),
   prf     int(10),
   obj     varchar(15) NOT NULL,
   unk     varchar(15) NOT NULL,
   dpr     varchar(20) NOT NULL,
   ksy     varchar(4) NOT NULL,
   ssy     varchar(10) NOT NULL,
   poz     varchar(80) NOT NULL,
   str     int(11),
   zak     int(11),
   txz     text NOT NULL,
   txp     text NOT NULL,
   zk0     decimal(10,2) DEFAULT 0,
   zk1     decimal(10,2) DEFAULT 0,
   zk2     decimal(10,2) DEFAULT 0,
   zk3     decimal(10,2) DEFAULT 0,
   zk4     decimal(10,2) DEFAULT 0,
   dn1     decimal(10,2) DEFAULT 0,
   dn2     decimal(10,2) DEFAULT 0,
   dn3     decimal(10,2) DEFAULT 0,
   dn4     decimal(10,2) DEFAULT 0,
   sp1     decimal(10,2) DEFAULT 0,
   sp2     decimal(10,2) DEFAULT 0,
   sz1     int(2) DEFAULT 0,
   sz2     int(2) DEFAULT 0,
   sz3     int(2) DEFAULT 0,
   sz4     int(2) DEFAULT 0,
   zk0u    decimal(10,2) DEFAULT 0,
   zk1u    decimal(10,2) DEFAULT 0,
   zk2u    decimal(10,2) DEFAULT 0,
   dn1u    decimal(10,2) DEFAULT 0,
   dn2u    decimal(10,2) DEFAULT 0,
   sp0u    decimal(10,2) DEFAULT 0,
   sp1u    decimal(10,2) DEFAULT 0,
   sp2u    decimal(10,2) DEFAULT 0,
   hodu    decimal(10,2) DEFAULT 0,
   hod     decimal(10,2) DEFAULT 0,
   hodm    decimal(10,2) DEFAULT 0,
   kurz    decimal(10,4) DEFAULT 0,
   mena    varchar(5) NOT NULL,     
   zmen    int(1) DEFAULT 0,
   odbm    int(10) DEFAULT 0,
   zal     decimal(10,2) DEFAULT 0,
   zao     decimal(10,2) DEFAULT 0,
   ruc     decimal(10,2) DEFAULT 0,
   uhr     decimal(10,2) DEFAULT 0,
   id      int(11) DEFAULT 0,
   datm    timestamp(14)
);
fakodbpoc;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakodbpoc'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakodbpoc'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakodbpoc ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_fakodbpoc MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky fakodbpoc

//Tabulka fakdod
$sql = "SELECT * FROM F$kli_vxcf"."_fakdod";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakdod!"."<br />";

$sqlt = <<<fakdod
(
   uce     VARCHAR(10),
   ume     FLOAT(8,4),
   dat     DATE,
   dav     DATE,
   das     DATE,
   daz     DATE,
   dok     INT(8),
   doq     INT(8),
   skl     int(11) DEFAULT 0,
   poh     int(2) DEFAULT 0,
   ico     int(10),
   fak     int(10),
   dol     int(10),
   prf     int(10),
   obj     varchar(15) NOT NULL,
   unk     varchar(15) NOT NULL,
   dpr     varchar(20) NOT NULL,
   ksy     varchar(4) NOT NULL,
   ssy     varchar(10) NOT NULL,
   poz     varchar(80) NOT NULL,
   str     int(11),
   zak     int(11),
   txz     text NOT NULL,
   txp     text NOT NULL,
   zk0     decimal(10,2) DEFAULT 0,
   zk1     decimal(10,2) DEFAULT 0,
   zk2     decimal(10,2) DEFAULT 0,
   zk3     decimal(10,2) DEFAULT 0,
   zk4     decimal(10,2) DEFAULT 0,
   dn1     decimal(10,2) DEFAULT 0,
   dn2     decimal(10,2) DEFAULT 0,
   dn3     decimal(10,2) DEFAULT 0,
   dn4     decimal(10,2) DEFAULT 0,
   sp1     decimal(10,2) DEFAULT 0,
   sp2     decimal(10,2) DEFAULT 0,
   sz1     int(2) DEFAULT 0,
   sz2     int(2) DEFAULT 0,
   sz3     int(2) DEFAULT 0,
   sz4     int(2) DEFAULT 0,
   zk0u    decimal(10,2) DEFAULT 0,
   zk1u    decimal(10,2) DEFAULT 0,
   zk2u    decimal(10,2) DEFAULT 0,
   dn1u    decimal(10,2) DEFAULT 0,
   dn2u    decimal(10,2) DEFAULT 0,
   sp0u    decimal(10,2) DEFAULT 0,
   sp1u    decimal(10,2) DEFAULT 0,
   sp2u    decimal(10,2) DEFAULT 0,
   hodu    decimal(10,2) DEFAULT 0,
   hod     decimal(10,2) DEFAULT 0,
   hodm    decimal(10,2) DEFAULT 0,
   kurz    decimal(10,4) DEFAULT 0,
   mena    varchar(5) NOT NULL,     
   zmen    int(1) DEFAULT 0,
   odbm    int(10) DEFAULT 0,
   zal     decimal(10,2) DEFAULT 0,
   zao     decimal(10,2) DEFAULT 0,
   ruc     decimal(10,2) DEFAULT 0,
   uhr     decimal(10,2) DEFAULT 0,
   id      int(11) DEFAULT 0,
   datm    timestamp(14)
);
fakdod;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakdod'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakdod'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_fakdod MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky fakdod

//Tabulka fakdodpoc
$sql = "SELECT * FROM F$kli_vxcf"."_fakdodpoc";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakdodpoc!"."<br />";

$sqlt = <<<fakdodpoc
(
   uce     VARCHAR(10),
   ume     FLOAT(8,4),
   dat     DATE,
   dav     DATE,
   das     DATE,
   daz     DATE,
   dok     INT(8),
   doq     INT(8),
   skl     int(11) DEFAULT 0,
   poh     int(2) DEFAULT 0,
   ico     int(10),
   fak     int(10),
   dol     int(10),
   prf     int(10),
   obj     varchar(15) NOT NULL,
   unk     varchar(15) NOT NULL,
   dpr     varchar(20) NOT NULL,
   ksy     varchar(4) NOT NULL,
   ssy     varchar(10) NOT NULL,
   poz     varchar(80) NOT NULL,
   str     int(11),
   zak     int(11),
   txz     text NOT NULL,
   txp     text NOT NULL,
   zk0     decimal(10,2) DEFAULT 0,
   zk1     decimal(10,2) DEFAULT 0,
   zk2     decimal(10,2) DEFAULT 0,
   zk3     decimal(10,2) DEFAULT 0,
   zk4     decimal(10,2) DEFAULT 0,
   dn1     decimal(10,2) DEFAULT 0,
   dn2     decimal(10,2) DEFAULT 0,
   dn3     decimal(10,2) DEFAULT 0,
   dn4     decimal(10,2) DEFAULT 0,
   sp1     decimal(10,2) DEFAULT 0,
   sp2     decimal(10,2) DEFAULT 0,
   sz1     int(2) DEFAULT 0,
   sz2     int(2) DEFAULT 0,
   sz3     int(2) DEFAULT 0,
   sz4     int(2) DEFAULT 0,
   zk0u    decimal(10,2) DEFAULT 0,
   zk1u    decimal(10,2) DEFAULT 0,
   zk2u    decimal(10,2) DEFAULT 0,
   dn1u    decimal(10,2) DEFAULT 0,
   dn2u    decimal(10,2) DEFAULT 0,
   sp0u    decimal(10,2) DEFAULT 0,
   sp1u    decimal(10,2) DEFAULT 0,
   sp2u    decimal(10,2) DEFAULT 0,
   hodu    decimal(10,2) DEFAULT 0,
   hod     decimal(10,2) DEFAULT 0,
   hodm    decimal(10,2) DEFAULT 0,
   kurz    decimal(10,4) DEFAULT 0,
   mena    varchar(5) NOT NULL,     
   zmen    int(1) DEFAULT 0,
   odbm    int(10) DEFAULT 0,
   zal     decimal(10,2) DEFAULT 0,
   zao     decimal(10,2) DEFAULT 0,
   ruc     decimal(10,2) DEFAULT 0,
   uhr     decimal(10,2) DEFAULT 0,
   id      int(11) DEFAULT 0,
   datm    timestamp(14)
);
fakdodpoc;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakdodpoc'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakdodpoc'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_fakdodpoc MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky fakdodpoc

//Tabulka fakvnp
$sql = "SELECT * FROM F$kli_vxcf"."_fakvnp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakvnp!"."<br />";

$sqlt = <<<fakvnp
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dav         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   doq         INT(8),
   skl         INT,
   poh         INT(2),
   ico         INT(10),
   fak         INT(10),
   dol         INT(10),
   prf         INT(10),
   ksy         VARCHAR(4),
   ssy         VARCHAR(10),
   poz         VARCHAR(80),
   str         INT,
   zak         INT,
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   zk3         DECIMAL(10,2),
   zk4         DECIMAL(10,2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   dn3         DECIMAL(10,2),
   dn4         DECIMAL(10,2),
   id          INT,
   datm        TIMESTAMP(14)
);
fakvnp;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakvnp'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakvnp'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD hod DECIMAL(10,2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD txp TEXT AFTER zak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD txz TEXT AFTER zak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD obj VARCHAR(15) AFTER prf";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD unk VARCHAR(15) AFTER obj";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD dpr VARCHAR(20) AFTER unk";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD sz4 INT(2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD sz3 INT(2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD sz2 INT(2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD sz1 INT(2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD sp2 DECIMAL(10,2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD sp1 DECIMAL(10,2) AFTER dn4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD uhr DECIMAL(10,2) AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD ruc DECIMAL(10,2) AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD zal DECIMAL(10,2) AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakvnp ADD zao DECIMAL(10,2) AFTER zal";
$vysledek = mysql_query("$sql");

}
//koniec tabulky fakvnp


//Tabulka fakdol
$sql = "SELECT * FROM F$kli_vxcf"."_fakdol";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakdol!"."<br />";

$sqlt = <<<fakdol
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dav         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   doq         INT(8),
   skl         INT,
   poh         INT(2),
   ico         INT(10),
   fak         INT(10),
   dol         INT(10),
   prf         INT(10),
obj         varchar(15) NOT NULL,
unk         varchar(15) NOT NULL,
dpr         varchar(20) NOT NULL,
ksy         varchar(4) NOT NULL,
ssy         varchar(10) NOT NULL,
poz         varchar(80) NOT NULL,
str         int(11) DEFAULT 0,
zak         int(11) DEFAULT 0,
txz         text NOT NULL,
txp         text NOT NULL,
zk0         decimal(10,2) DEFAULT 0,
zk1         decimal(10,2) DEFAULT 0,
zk2         decimal(10,2) DEFAULT 0,
zk3         decimal(10,2) DEFAULT 0,
zk4         decimal(10,2) DEFAULT 0,
dn1         decimal(10,2) DEFAULT 0,
dn2         decimal(10,2) DEFAULT 0,
dn3         decimal(10,2) DEFAULT 0,
dn4         decimal(10,2) DEFAULT 0,
sp1         decimal(10,2) DEFAULT 0,
sp2         decimal(10,2) DEFAULT 0,
sz1         int(2) DEFAULT 0,
sz2         int(2) DEFAULT 0,
sz3         int(2) DEFAULT 0,
sz4         int(2) DEFAULT 0,
hod         decimal(10,2) DEFAULT 0,
hodm        decimal(10,2) DEFAULT 0,
kurz        decimal(10,4) DEFAULT 0,
mena        varchar(5) NOT NULL,
zmen        int(1) DEFAULT 0,
odbm        int(10) DEFAULT 0,
zal        decimal(10,2) DEFAULT 0,
zao        decimal(10,2) DEFAULT 0,
ruc        decimal(10,2) DEFAULT 0,
uhr        decimal(10,2) DEFAULT 0,
id        int(11) DEFAULT 0,
   datm        TIMESTAMP(14)
);
fakdol;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakdol'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakdol'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakdol ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky fakdol

//Tabulka fakprf
$sql = "SELECT * FROM F$kli_vxcf"."_fakprf";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakprf!"."<br />";

$sqlt = <<<fakprf
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dav         DATE,
   das         DATE,
   daz         DATE,
   dok         INT(8),
   doq         INT(8),
   skl         INT,
   poh         INT(2),
   ico         INT(10),
   fak         INT(10),
   dol         INT(10),
   prf         INT(10),
obj         varchar(15) NOT NULL,
unk         varchar(15) NOT NULL,
dpr         varchar(20) NOT NULL,
ksy         varchar(4) NOT NULL,
ssy         varchar(10) NOT NULL,
poz         varchar(80) NOT NULL,
str         int(11) DEFAULT 0,
zak         int(11) DEFAULT 0,
txz         text NOT NULL,
txp         text NOT NULL,
zk0         decimal(10,2) DEFAULT 0,
zk1         decimal(10,2) DEFAULT 0,
zk2         decimal(10,2) DEFAULT 0,
zk3         decimal(10,2) DEFAULT 0,
zk4         decimal(10,2) DEFAULT 0,
dn1         decimal(10,2) DEFAULT 0,
dn2         decimal(10,2) DEFAULT 0,
dn3         decimal(10,2) DEFAULT 0,
dn4         decimal(10,2) DEFAULT 0,
sp1         decimal(10,2) DEFAULT 0,
sp2         decimal(10,2) DEFAULT 0,
sz1         int(2) DEFAULT 0,
sz2         int(2) DEFAULT 0,
sz3         int(2) DEFAULT 0,
sz4         int(2) DEFAULT 0,
hod         decimal(10,2) DEFAULT 0,
hodm        decimal(10,2) DEFAULT 0,
kurz        decimal(10,4) DEFAULT 0,
mena        varchar(5) NOT NULL,
zmen        int(1) DEFAULT 0,
odbm        int(10) DEFAULT 0,
zal        decimal(10,2) DEFAULT 0,
zao        decimal(10,2) DEFAULT 0,
ruc        decimal(10,2) DEFAULT 0,
uhr        decimal(10,2) DEFAULT 0,
id        int(11) DEFAULT 0,
   datm        TIMESTAMP(14)
);
fakprf;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakprf'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakprf'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_fakprf ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky fakprf

//Tabulka dodb
$sql = "SELECT cx01 FROM F$kli_vxcf"."_dodb";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_dodb!"."<br />";

$sqlt = <<<dodb
(
   dodb         VARCHAR(10),
   nodb         VARCHAR(30),
   drod         INT,
   ucod         VARCHAR(10),
   datm         TIMESTAMP(14)
);
dodb;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dodb'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_dodb'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '31100', 'Odberate¾ská faktúra', '1', '31100' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '31160', 'Odber.faktúra Doprava', '11', '31160' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '88801', 'Dodací list', '2', '88801' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '88802', 'Vnútropodniková faktúra', '3', '88802' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '99901', 'Dodací list Doprava', '12', '99901' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '99902', 'Vnútropod.faktúra Doprava', '13', '99902' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dodb ( dodb,nodb,drod,ucod ) VALUES ( '99903', 'Predfaktúra Doprava', '14', '99903' )";
$ttqq = mysql_query("$ttvv");

//pridat stlpce
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD zakv INT AFTER ucod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD strv INT AFTER ucod";
$vysledek = mysql_query("$sql");

//pridat stlpce
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD cfak INT(10) DEFAULT 1 AFTER zakv";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD tx02 VARCHAR(30) AFTER cfak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD tx01 VARCHAR(30) AFTER cfak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD cx02 INT AFTER cfak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dodb ADD cx01 INT AFTER cfak";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_dodb SET cfak=760001 WHERE dodb = '31100' ";
$vysledek = mysql_query("$sql");
}
//koniec tabulky dodb


//Tabulka ddod
$sql = "SELECT cfak FROM F$kli_vxcf"."_ddod";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_ddod!"."<br />";

$sqlt = <<<ddod
(
   ddod         VARCHAR(10),
   ndod         VARCHAR(30),
   drdo         INT,
   ucdo         VARCHAR(10),
   datm         TIMESTAMP(14)
);
ddod;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_ddod'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_ddod'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_ddod ( ddod,ndod,drdo,ucdo ) VALUES ( '32100', 'Dodávate¾ská faktúra', '1', '32100' )";
$ttqq = mysql_query("$ttvv");

$sql = "ALTER TABLE F$kli_vxcf"."_ddod ADD cfak INT(10) DEFAULT 1 AFTER ucdo";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_ddod SET cfak=860001 WHERE ddod = '32100' ";
$vysledek = mysql_query("$sql");
}
//koniec tabulky ddod

//Tabulka sluzby
$sql = "SELECT * FROM F$kli_vxcf"."_sluzby";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_sluzby!"."<br />";

$sqlt = <<<sluzby
(
   slu         INT(15) PRIMARY KEY UNIQUE,
   nsl         VARCHAR(40),
   mer         VARCHAR(3),
   dph         INT(2),
   cep         DECIMAL(10,2),
   ced         DECIMAL(10,2),
   tl1         BOOL NOT NULL,
   tl2         BOOL NOT NULL,
   tl3         BOOL NOT NULL,
   datm        TIMESTAMP(14)
);
sluzby;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_sluzby'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_sluzby'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_sluzby ( slu,nsl,mer,dph,cep,ced ) VALUES ( '2001', 'služba è. 2001', 'h', '20', 5, 6 )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_sluzby ( slu,nsl,mer,dph,cep,ced ) VALUES ( '2002', 'služba è. 2002', 'h', '20', 10, 12 )";
$ttqq = mysql_query("$ttvv");

//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD webtx2 TEXT AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD webtx1 TEXT AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD kat04h VARCHAR(20) AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD kat03h VARCHAR(20) AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD kat02h VARCHAR(20) AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD kat01h VARCHAR(20) AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD labh2 VARCHAR(20) AFTER tl3";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD labh1 VARCHAR(20) AFTER tl3";
$vysledek = mysql_query("$sql");

}
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD nslz VARCHAR(80) NOT NULL AFTER nsl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_sluzby ADD nslp VARCHAR(80) NOT NULL AFTER nsl";
$vysledek = mysql_query("$sql");
//koniec tabulky sluzby


//Tabulka sluzbyzas
$sql = "SELECT * FROM F$kli_vxcf"."_sluzbyzas";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_sluzbyzas!"."<br />";

$sqlt = <<<sluzbyzas
(
   skl         INT,
   slu         INT(15),
   cen         DECIMAL(10,2),
   zas         DECIMAL(10,3),
   datm        TIMESTAMP(14),
   PRIMARY KEY ( skl, slu, cen ),
   UNIQUE ( skl, slu, cen )
);
sluzbyzas;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_sluzbyzas'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_sluzbyzas'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_sluzbyzas ENGINE InnoDB";
$vysledek = mysql_query("$sql");


}
//koniec tabulky sluzbyzas

//Tabulka fakslu
$sql = "SELECT * FROM F$kli_vxcf"."_fakslu";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_fakslu!"."<br />";

$sqlt = <<<fakslu
(
   dok         INT(8),
   cpl         int not null auto_increment,
   slu         INT(15),
   nsl         VARCHAR(40),
   dph         INT(2),
   cen         DECIMAL(10,2),
   cep         DECIMAL(10,2),
   ced         DECIMAL(10,2),
   mno         DECIMAL(10,3),
   mer         VARCHAR(3),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
fakslu;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_fakslu'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_fakslu'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD pop TEXT AFTER nsl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD prf INT(10) AFTER dok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD dol INT(10) AFTER dok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD fak INT(10) AFTER dok";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD dfak INT AFTER mer";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD cfak INT AFTER mer";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD pfak INT AFTER mer";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu ADD pon TEXT AFTER pop";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu MODIFY cep DECIMAL(12,4)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_fakslu MODIFY ced DECIMAL(12,4)";
$vysledek = mysql_query("$sql");
//koniec tabulky fakslu

//Tabulka faktext
$sql = "SELECT * FROM F$kli_vxcf"."_faktext";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_faktext!"."<br />";

$sqlt = <<<faktext
(
   cpt     int not null auto_increment,
   txx     text NOT NULL,
   drh     INT(8) DEFAULT 1,
   prm     INT(8) DEFAULT 0,
   PRIMARY KEY(cpt)
);
faktext;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_faktext'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_faktext'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_faktext ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky faktext

//Tabulka vtvfak
$sql = "SELECT * FROM F$kli_vxcf"."_vtvfak";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_vtvfak!"."<br />";

$sqlt = <<<vtvfak
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvfak;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_vtvfak'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_vtvfak'.$sqlt;

$vysledek = mysql_query("$sql");
echo "Podsystém Faktúry, odbyt inicializovaný.<br />";
}
//koniec tabulky vtvfak

$vtvfak = 1;
return $vtvfak;

?>
</BODY>
</HTML>