<!DOCTYPE html   PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>vtvuct.php</title>
</head>
<body>
<?php
//echo "Nastavit databazu $mysqldb!"."<br />";
$sql = "USE $rtxdt";
$vysledek = mysql_query("$sql");
if ($vysledek)
     //echo "Databaza $mysqldb nastavena."."<br />";

//Tabulka banvyp
$sql = "SELECT * FROM F$kli_vxcf"."_banvyp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_banvyp!"."<br />";

$sqlt = <<<banvyp
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   doq         INT(8),
   txp         TEXT,
   txz         TEXT,
   ico         INT(10),
   kto         VARCHAR(80),
   unk         VARCHAR(15),
   poz         VARCHAR(80),
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   zk3         DECIMAL(10,2),
   zk4         DECIMAL(10,2),
   sz1         INT(2),
   sz2         INT(2),
   sz3         INT(2),
   sz4         INT(2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   dn3         DECIMAL(10,2),
   dn4         DECIMAL(10,2),
   sp1         DECIMAL(10,2),
   sp2         DECIMAL(10,2),
   sp3         DECIMAL(10,2),
   sp4         DECIMAL(10,2),
   id          INT,
   datm        TIMESTAMP(14)
);
banvyp;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_banvyp'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_banvyp'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD hod DECIMAL(10,2) AFTER sp4";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD hodu DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD sp2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD sp1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD sp0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD dn2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD dn1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD zk2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD zk1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD zk0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_banvyp MODIFY kurz DECIMAL(14,9) DEFAULT 0";
$vysledek = mysql_query("$sql");
//koniec tabulky banvyp

//Tabulka uctvsdh
$sql = "SELECT * FROM F$kli_vxcf"."_uctvsdh";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctvsdh!"."<br />";

$sqlt = <<<uctvsdh
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   doq         INT(8),
   txp         TEXT,
   txz         TEXT,
   ico         INT(10),
   kto         VARCHAR(80),
   unk         VARCHAR(15),
   poz         VARCHAR(80),
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   zk3         DECIMAL(10,2),
   zk4         DECIMAL(10,2),
   sz1         INT(2),
   sz2         INT(2),
   sz3         INT(2),
   sz4         INT(2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   dn3         DECIMAL(10,2),
   dn4         DECIMAL(10,2),
   sp1         DECIMAL(10,2),
   sp2         DECIMAL(10,2),
   sp3         DECIMAL(10,2),
   sp4         DECIMAL(10,2),
   id          INT,
   datm        TIMESTAMP(14)
);
uctvsdh;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctvsdh'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctvsdh'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD hod DECIMAL(10,2) AFTER sp4";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD hodu DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD sp2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD sp1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD sp0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD dn2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD dn1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD zk2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD zk1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD zk0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD kurz DECIMAL(14,9) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdh ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
//koniec tabulky uctvsdh

//Tabulka pokpri
$sql = "SELECT * FROM F$kli_vxcf"."_pokpri";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_pokpri!"."<br />";

$sqlt = <<<pokpri
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   doq         INT(8),
   txp         TEXT,
   txz         TEXT,
   ico         INT(10),
   kto         VARCHAR(80),
   unk         VARCHAR(15),
   poz         VARCHAR(80),
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   zk3         DECIMAL(10,2),
   zk4         DECIMAL(10,2),
   sz1         INT(2),
   sz2         INT(2),
   sz3         INT(2),
   sz4         INT(2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   dn3         DECIMAL(10,2),
   dn4         DECIMAL(10,2),
   sp1         DECIMAL(10,2),
   sp2         DECIMAL(10,2),
   sp3         DECIMAL(10,2),
   sp4         DECIMAL(10,2),
   id          INT,
   datm        TIMESTAMP(14)
);
pokpri;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_pokpri'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_pokpri'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD hod DECIMAL(10,2) AFTER sp4";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD hodu DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD sp2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD sp1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD sp0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD dn2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD dn1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD zk2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD zk1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD zk0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokpri ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
//koniec tabulky pokpri


//Tabulka pokvyd
$sql = "SELECT * FROM F$kli_vxcf"."_pokvyd";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_pokvyd!"."<br />";

$sqlt = <<<pokvyd
(
   uce         VARCHAR(10),
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   doq         INT(8),
   txp         TEXT,
   txz         TEXT,
   ico         INT(10),
   kto         VARCHAR(80),
   unk         VARCHAR(15),
   poz         VARCHAR(80),
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   zk3         DECIMAL(10,2),
   zk4         DECIMAL(10,2),
   sz1         INT(2),
   sz2         INT(2),
   sz3         INT(2),
   sz4         INT(2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   dn3         DECIMAL(10,2),
   dn4         DECIMAL(10,2),
   sp1         DECIMAL(10,2),
   sp2         DECIMAL(10,2),
   sp3         DECIMAL(10,2),
   sp4         DECIMAL(10,2),
   id          INT,
   datm        TIMESTAMP(14)
);
pokvyd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_pokvyd'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_pokvyd'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ENGINE InnoDB";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD hod DECIMAL(10,2) AFTER sp4";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD hodu DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD sp2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD sp1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD sp0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD dn2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD dn1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD zk2u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD zk1u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD zk0u DECIMAL(10,2) DEFAULT 0 AFTER sp4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_pokvyd ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
//koniec tabulky pokvyd


//Tabulka dpok
$sql = "SELECT cvyd FROM F$kli_vxcf"."_dpok";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_dpok!"."<br />";

$sqlt = <<<dpok
(
   dpok         VARCHAR(10),
   npok         VARCHAR(30),
   drpk         INT,
   ucpk         VARCHAR(10),
   datm         TIMESTAMP(14)
);
dpok;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dpok'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_dpok'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_dpok (dpok,npok,drpk,ucpk  ) VALUES ( '21100', 'Pokladnica 21100', '1', '1' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dpok (dpok,npok,drpk,ucpk  ) VALUES ( '21120', 'Pokladnica 21120 Doprava', '2', '1' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dpok (dpok,npok,drpk,ucpk  ) VALUES ( '21160', 'ERP Doprava', '9', '1' )";
//$ttqq = mysql_query("$ttvv");

$sql = "ALTER TABLE F$kli_vxcf"."_dpok ADD cpri INT(10) DEFAULT 1 AFTER ucpk";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_dpok ADD cvyd INT(10) DEFAULT 1 AFTER ucpk";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_dpok SET cpri=10001, cvyd=20001 WHERE dpok = '21100' ";
$vysledek = mysql_query("$sql");
}
//koniec tabulky dpok


//Tabulka dban
$sql = "SELECT cban FROM F$kli_vxcf"."_dban";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_dban!"."<br />";

$sqlt = <<<dban
(
   dban         INT(10),
   nban         VARCHAR(30),
   uceb         VARCHAR(30),
   numb         VARCHAR(4),
   iban         VARCHAR(30),
   twib         VARCHAR(30),
   parb         INT(10),
   datm         TIMESTAMP(14)
);
dban;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_dban'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_dban'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_dban (dban,nban,uceb,numb,iban,twib,parb  ) VALUES ( '22100', 'TATRABANKA', '262458987', '1100', 'SK2411000000000262459786', '', '1' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_dban (dban,nban,uceb,numb,iban,twib,parb  ) VALUES ( '22110', 'VUB', '704040182', '0200', 'SK4602000000000704040182', '', '1' )";
//$ttqq = mysql_query("$ttvv");

$sql = "ALTER TABLE F$kli_vxcf"."_dban ADD cban INT(10) DEFAULT 1 AFTER parb";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_dban SET cban=30001 WHERE dban = '22100' ";
$vysledek = mysql_query("$sql");
}

//koniec tabulky dban


//Tabulka uctpok
$sql = "SELECT * FROM F$kli_vxcf"."_uctpok";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctpok!"."<br />";

$sqlt = <<<uctpok
(
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctpok;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpok'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctpok'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctpok ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctpok ADD unk VARCHAR(15) AFTER zak";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpok MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpok ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpok ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpok ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpok ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
//koniec tabulky uctpok

//Tabulka uctpokuct
$sql = "SELECT * FROM F$kli_vxcf"."_uctpokuct";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctpokuct!"."<br />";

$sqlt = <<<uctpokuct
(
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctpokuct;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpokuct'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctpokuct'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctpokuct MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky uctpokuct

//Tabulka uctban
$sql = "SELECT * FROM F$kli_vxcf"."_uctban";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctban!"."<br />";

$sqlt = <<<uctban
(
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctban;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctban'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctban'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctban ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctban MODIFY kurz DECIMAL(10,5) DEFAULT 0";
$vysledek = mysql_query("$sql");
//koniec tabulky uctban

//Tabulka uctvsdp
$sql = "SELECT * FROM F$kli_vxcf"."_uctvsdp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctvsdp!"."<br />";

$sqlt = <<<uctvsdp
(
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctvsdp;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctvsdp'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctvsdp'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT zmen FROM F$kli_vxcf"."_uctvsdp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
  {
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp ADD zmen INT(1) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp ADD mena VARCHAR(5) NOT NULL AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp ADD kurz DECIMAL(10,4) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp ADD hodm DECIMAL(10,2) DEFAULT 0 AFTER hod";
$vysledek = mysql_query("$sql");
  }
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctvsdp MODIFY kurz DECIMAL(10,5) DEFAULT 0";
$vysledek = mysql_query("$sql");
//koniec tabulky uctvsdp

//Tabulka uctskl
$sql = "SELECT * FROM F$kli_vxcf"."_uctskl";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctskl!"."<br />";

$sqlt = <<<uctskl
(
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctskl;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctskl'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctskl'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctskl ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctskl MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky uctskl

//Tabulka uctodb
$sql = "SELECT * FROM F$kli_vxcf"."_uctodb";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctodb!"."<br />";

$sqlt = <<<uctodb
(
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctodb;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctodb'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctodb'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctodb ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctodb MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky uctodb

//Tabulka uctdod
$sql = "SELECT * FROM F$kli_vxcf"."_uctdod";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctdod!"."<br />";

$sqlt = <<<uctdod
(
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctdod;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctdod'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctdod'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctdod ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctdod MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky uctdod

//Tabulka uctdop
$sql = "SELECT * FROM F$kli_vxcf"."_uctdop";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctdop!"."<br />";

$sqlt = <<<uctdop
(
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctdop;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctdop'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctdop'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctdop ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky uctdop

//Tabulka uctmaj
$sql = "SELECT * FROM F$kli_vxcf"."_uctmaj";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctmaj!"."<br />";

$sqlt = <<<uctmaj
(
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctmaj;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctmaj'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctmaj'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctmaj ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctmaj MODIFY fak DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky uctmaj

//Tabulka uctmzd
$sql = "SELECT * FROM F$kli_vxcf"."_uctmzd";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctmzd!"."<br />";

$sqlt = <<<uctmzd
(
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         INT(10),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctmzd'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctmzd'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctmzd ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky uctmzd

//Tabulka uctosnova
$sql = "SELECT * FROM F$kli_vxcf"."_uctosnova";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctosnova!"."<br />";

$sqlt = <<<uctosnova
(
   uce         VARCHAR(10) UNIQUE,
   nuc         VARCHAR(90),
   crv         INT(3),
   crs         INT(3),
   pmd         DECIMAL(10,2),
   pda         DECIMAL(10,2),
   prm1        INT(3),
   prm2        INT(3),
   prm3        INT(3),
   prm4        INT(3),
   ucc         INT,
   PRIMARY KEY(uce)
);
uctosnova;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctosnova'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctosnova'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctosnova ENGINE InnoDB";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '21100', 'Pokladnica', '1', '1', '0', '0', '1', '21100' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '22100', 'Bankový úèet', '1', '1', '0', '0', '1', '22100' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '31100', 'Odberatelia', '1', '1', '0', '0', '1', '31100' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '32100', 'Dodávatelia', '1', '1', '0', '0', '1', '32100' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '50100', 'Spotreba materialu', '1', '1', '0', '0', '1', '50100' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '50400', 'Predany tovar', '1', '1', '0', '0', '1', '50400' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '60100', 'Trzby za sluzby', '1', '1', '0', '0', '1', '60100' )";
//$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctosnova (uce,nuc,crv,crs,pmd,pda,prm1,ucc) VALUES ( '60400', 'Trzby za tovar', '1', '1', '0', '0', '1', '60400' )";
//$ttqq = mysql_query("$ttvv");
$sql = "DROP TABLE F$kli_vxcf"."_uctosnovanew_b";
$vysledek = mysql_query("$sql");
}
//koniec tabulky uctosnova

//Tabulka uctdrdp
$sql = "SELECT * FROM F$kli_vxcf"."_uctdrdp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctdrdp!"."<br />";

$sqlt = <<<uctdrdp
(
   rdp         INT UNIQUE,
   nrd         VARCHAR(50),
   szd         INT(3),
   crz         INT(3),
   crd         INT(3),
   crz1        INT(3),
   crd1        INT(3),
   crz2        INT(3),
   crd2        INT(3),
   crz3        INT(3),
   crd3        INT(3),
   PRIMARY KEY(rdp)
);
uctdrdp;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctdrdp'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctdrdp'.$sqlt;

$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp ENGINE InnoDB";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY crd3 VARCHAR(10) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctdrdp MODIFY nrd VARCHAR(70) NOT NULL ";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '01', 'Doklad nie je daòový pre DPH', '0', '0', '0', '0', '0' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctdrdp (rdp,nrd,szd,crz,crd,crz1,crd1) VALUES ( '10', 'Odvod-Vrátenie DPH', '0', '0', '0', '0', '0' )";
$ttqq = mysql_query("$ttvv");
}

$sql = "DROP TABLE F$kli_vxcf"."_uctdphnew";
$vysledek = mysql_query("$sql");
//koniec tabulky uctdrdp

//Tabulka uctmeny
$sql = "SELECT * FROM F$kli_vxcf"."_uctmeny";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctmeny!"."<br />";

$sqlt = <<<uctmeny
(
   mena         VARCHAR(5),
   nmen         VARCHAR(40),
   dmen         INT,
   umen         INT,
   datm         TIMESTAMP(14)
);
uctmeny;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctmeny'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctmeny'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_uctmeny (mena,nmen,dmen,umen  ) VALUES ( 'USD', 'US Dolar', '1', '1' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_uctmeny (mena,nmen,dmen,umen  ) VALUES ( 'CZK', 'CZ Koruna', '1', '1' )";
$ttqq = mysql_query("$ttvv");
}
//koniec tabulky uctmeny

//Tabulka uctcudz
$sql = "SELECT * FROM F$kli_vxcf"."_uctcudz";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctcudz!"."<br />";

$sqlt = <<<uctcudz
(
   cuce         VARCHAR(11),
   cume         VARCHAR(40),
   pscu         DECIMAL(10,2),
   pssk         DECIMAL(10,2),
   prc1         INT,
   prc2         INT,
   datm         TIMESTAMP(14)
);
uctcudz;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctcudz'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctcudz'.$sqlt;

$vysledek = mysql_query("$sql");

}
$sql = "ALTER TABLE F$kli_vxcf"."_uctcudz ADD mena VARCHAR(5) NOT NULL AFTER cume";
$vysledek = mysql_query("$sql");
//koniec tabulky uctcudz

//Tabulka uctkurzy
$sql = "SELECT * FROM F$kli_vxcf"."_uctkurzy";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctkurzy!"."<br />";

$sqlt = <<<uctkurzy
(
   mena         VARCHAR(5),
   datk         DATE,
   pomr         INT,
   kurz         DECIMAL(10,4),
   prk1         INT,
   prk2         INT,
   datm         TIMESTAMP(14)
);
uctkurzy;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctkurzy'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctkurzy'.$sqlt;

$vysledek = mysql_query("$sql");

}
//koniec tabulky uctkurzy

//Tabulka uctpriku
$sql = "SELECT * FROM F$kli_vxcf"."_uctpriku";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctpriku!"."<br />";

$sqlt = <<<uctpriku
(
   dok         int PRIMARY KEY not null auto_increment,
   uce         VARCHAR(11),
   dat         DATE,
   hodp        DECIMAL(10,2) DEFAULT 0,
   hodm        decimal(10,2) DEFAULT 0,
   kurz        decimal(10,4) DEFAULT 0,
   mena        varchar(5) NOT NULL,     
   zmen        int(1) DEFAULT 0,
   txp         TEXT,
   txz         TEXT,
   ico         INT(10),
   kto         VARCHAR(80),
   unk         VARCHAR(15),
   poz         VARCHAR(80),
   id          INT,
   datm        TIMESTAMP(14)
);
uctpriku;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctpriku'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctpriku'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_uctpriku ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky uctpriku

//Tabulka uctprikp
$sql = "SELECT * FROM F$kli_vxcf"."_uctprikp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_uctprikp!"."<br />";

$sqlt = <<<uctprikp
(
   dok         int,
   cpl         int PRIMARY KEY not null auto_increment,
   uceb        VARCHAR(30),
   numb        VARCHAR(4),
   iban        VARCHAR(30),
   pbic        VARCHAR(10),
   twib        VARCHAR(30),
   vsy         int(10),
   ksy         varchar(4) NOT NULL,
   ssy         varchar(10) NOT NULL,
   hodp        DECIMAL(10,2) DEFAULT 0,
   hodm        decimal(10,2) DEFAULT 0,
   uce         int,
   ico         INT(10),
   id          INT,
   datm        TIMESTAMP(14)
);
uctprikp;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctprikp'.$sqlt;
////echo 'CREATE TABLE F'.$kli_vxcf.'_uctprikp'.$sqlt;

$vysledek = mysql_query("$sql");


//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
$sql = "ALTER TABLE F$kli_vxcf"."_uctprikp MODIFY vsy DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
//koniec tabulky uctprikp

//Tabulka uctpohyby
$sql = "SELECT * FROM uctpohyby";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku uctpohyby!"."<br />";

$sqlt = <<<uctpohyby
(
   cpoh        int PRIMARY KEY not null UNIQUE,
   pohp        VARCHAR(50) NOT NULL,
   ucto        INT DEFAULT 0,
   druh        INT DEFAULT 1,
   uzk0        VARCHAR(11) NOT NULL,
   dzk0        INT DEFAULT 0,
   uzk1        VARCHAR(11) NOT NULL,
   dzk1        INT DEFAULT 0,
   uzk2        VARCHAR(11) NOT NULL,
   dzk2        INT DEFAULT 0,
   udn1        VARCHAR(11) NOT NULL,
   ddn1        INT DEFAULT 0,
   udn2        VARCHAR(11) NOT NULL,
   ddn2        INT DEFAULT 0,
   hfak        INT DEFAULT 0,
   hico        INT DEFAULT 0,
   hstr        INT DEFAULT 0,
   hzak        INT DEFAULT 0,
   id          INT,
   datm        TIMESTAMP(14)
);
uctpohyby;
$sql = 'CREATE TABLE uctpohyby'.$sqlt;
$vysledek = mysql_query("$sql");

//pridaj stlpec
$sql = "ALTER TABLE uctpohyby ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT * FROM F$kli_vxcf"."_uctpohyby";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku uctpohyby!"."<br />";

$sqlt = <<<uctpohyby
(
   cpoh        int PRIMARY KEY not null UNIQUE,
   pohp        VARCHAR(50) NOT NULL,
   ucto        INT DEFAULT 0,
   druh        INT DEFAULT 1,
   uzk0        VARCHAR(11) NOT NULL,
   dzk0        INT DEFAULT 0,
   uzk1        VARCHAR(11) NOT NULL,
   dzk1        INT DEFAULT 0,
   uzk2        VARCHAR(11) NOT NULL,
   dzk2        INT DEFAULT 0,
   udn1        VARCHAR(11) NOT NULL,
   ddn1        INT DEFAULT 0,
   udn2        VARCHAR(11) NOT NULL,
   ddn2        INT DEFAULT 0,
   hfak        INT DEFAULT 0,
   hico        INT DEFAULT 0,
   hstr        INT DEFAULT 0,
   hzak        INT DEFAULT 0,
   id          INT,
   datm        TIMESTAMP(14)
);
uctpohyby;
$sql = "CREATE TABLE F$kli_vxcf"."_uctpohyby".$sqlt;
$vysledek = mysql_query("$sql");

//pridaj stlpec
$sql = "ALTER TABLE F$kli_vxcf"."_uctpohyby ENGINE InnoDB";
$vysledek = mysql_query("$sql");
}
//koniec tabulky uctpohyby

//Tabulka vtvuct
$sql = "SELECT * FROM F$kli_vxcf"."_vtvuct";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
//echo "Vytvorit tabulku F$kli_vxcf"."_vtvuct!"."<br />";

$sqlt = <<<vtvuct
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvuct;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_vtvuct'.$sqlt;

$vysledek = mysql_query("$sql");
echo "Podsystém Úètovníctvo inicializovaný.<br />";
}
//koniec tabulky vtvuct

$vtvuct = 1;
return $vtvuct;

?>
</BODY>
</HTML>