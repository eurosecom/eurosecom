<!DOCTYPE html   PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "DTD/xhtml1-strict.dtd">
<html>
<head>
  <title>vtvmzd.php</title>
</head>
<body>
<?php
$sql = "USE $rtxdt";
$vysledek = mysql_query("$sql");

//Tabulka mzdkun
$sql = "SELECT * FROM F$kli_vxcf"."_mzdkun";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzdkun
(
   oc           INT(7) PRIMARY KEY UNIQUE,
   meno         VARCHAR(35),
   prie         VARCHAR(35),
   titl         VARCHAR(10),
   datm         TIMESTAMP(14)
);
mzdkun;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdkun'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_mzdkun ( oc,meno,prie,titl ) VALUES ( '1', 'Ján', 'Novák', '' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_mzdkun ( oc,meno,prie,titl ) VALUES ( '2', 'Jana', 'Malinova', '' )";
$ttqq = mysql_query("$ttvv");
}
//rozsirit mzdkun
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdkun";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD ssy VARCHAR(10) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD ksy VARCHAR(4) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD vsy INT(10) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD numb VARCHAR(4) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD uceb VARCHAR(30) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD vban INT(1) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD sz5 DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD sz4 DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD sz3 DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD sz2 DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD sz1 DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD sz0 DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD trd VARCHAR(10) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zdrv INT(6) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dvp DATE AFTER titl"; //datum poistenia do ZP ide sem dvp;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zpno INT(2) DEFAULT 0 AFTER titl"; //znizene percenta do ZP ide sem kpl1;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zpnie INT(1) DEFAULT 0 AFTER zpno"; //neprihlaseny do ZP;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD deti_dn INT(2) DEFAULT 0 AFTER titl"; //pocet deti na danovy bonus ide sem  det_dn;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD ziv_dn INT(2) DEFAULT 0 AFTER titl"; //odpocet ziv.minima 9=nie ide sem  kpl3;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zrz_dn INT(2) DEFAULT 0 AFTER titl"; //zrazkova dan 9=nie ide sem  kpl2;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD deti_sp INT(2) DEFAULT 0 AFTER titl"; //pocet deti na znizenie SP ide sem  det_sp;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD spno INT(2) DEFAULT 0 AFTER titl"; //znizene percenta do SP ide sem inv_s2;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD spnie INT(1) DEFAULT 0 AFTER spno"; //neprihlaseny do SP;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dsp DATE AFTER spno"; //datum poistenia do SP;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD roh INT(2) DEFAULT 0 AFTER titl"; //roh ide sem rx;
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD cdss INT(5) DEFAULT 0 AFTER titl"; //cislo dss ide sem kpm4;
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dvy DATE AFTER titl"; //suma dochodku ide sem dvy
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dad DATE AFTER titl"; //datum dochodku ide sem dok
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD doch INT(2) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD znem DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD znah DECIMAL(10,4) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD crp DECIMAL(5,1) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD nrk DECIMAL(5,1) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD nev DECIMAL(5,1) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");


$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dav DATE AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dan DATE AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD uva DECIMAL(10,2) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");

$sql = "UPDATE F$kli_vxcf"."_mzdkun SET uva=8";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zkz INT(11) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD stz INT(11) DEFAULT 0 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD wms INT(3) DEFAULT 1 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD kat INT(3) DEFAULT 1 AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD pom INT(3) DEFAULT 1 AFTER titl";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD ztel VARCHAR(35) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zema VARCHAR(35) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zuli VARCHAR(35) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zcdm VARCHAR(10) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zpsc VARCHAR(10) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD zmes VARCHAR(35) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD cop VARCHAR(4) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD mnr VARCHAR(35) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD dar DATE AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD rdk VARCHAR(4) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD rdc VARCHAR(6) NOT NULL AFTER titl";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD akt INT(2) DEFAULT 1 AFTER titl";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun MODIFY dvy DECIMAL(8,2)";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD prbd VARCHAR(35) AFTER prie";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD docv INT(2) DEFAULT 0 AFTER doch";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun MODIFY vsy DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdkun";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD uvazn INT(1) DEFAULT 0 AFTER uva";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun MODIFY cop VARCHAR(20)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun MODIFY cop VARCHAR(20)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdkun ADD rodn VARCHAR(35) NOT NULL AFTER prie";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun ADD rodn VARCHAR(35) NOT NULL AFTER prie";
$vysledek = mysql_query("$sql");
}
//koniec tabulky mzdkun

//Tabulka mzdtrn
$sql = "SELECT * FROM F$kli_vxcf"."_mzdtrn";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzdtrn
(
   cpl          int not null auto_increment,
   oc           INT(7),
   dm           INT(4),
   kc           DECIMAL(10,2),
   mn           DECIMAL(10,2),
   trx1         INT(1),
   trx2         INT(1),
   trx3         VARCHAR(10) NOT NULL,
   trx4         VARCHAR(50) NOT NULL,
   datm         TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
mzdtrn;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdtrn'.$sqlt;

$vysledek = mysql_query("$sql");

}
//rozsirit mzdtrn
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdtrn";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn ADD ssy VARCHAR(10) NOT NULL AFTER trx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn ADD ksy VARCHAR(4) NOT NULL AFTER trx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn ADD vsy INT(10) DEFAULT 0 AFTER trx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn ADD numb VARCHAR(4) NOT NULL AFTER trx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn ADD uceb VARCHAR(30) NOT NULL AFTER trx4";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtrn MODIFY vsy DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdtrn";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
//koniec tabulky mzdtrn

//Tabulka mzddeti
$sql = "SELECT * FROM F$kli_vxcf"."_mzddeti";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzddeti
(
   cpl          int not null auto_increment,
   oc           INT(7),
   md           VARCHAR(35) NOT NULL,
   rcd          VARCHAR(15) NOT NULL,
   dr           DATE,
   p1           INT(1) DEFAULT 0,
   p2           INT(1) DEFAULT 0,
   p3           INT(1) DEFAULT 0,
   p4           INT(1) DEFAULT 0,
   datm         TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
mzddeti;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzddeti'.$sqlt;

$vysledek = mysql_query("$sql");


}
//rozsirit mzddeti
$sql = "SELECT omes FROM F$kli_vxcf"."_mzddeti";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
//koniec tabulky mzddeti

//Tabulka mzdddp
$sql = "SELECT * FROM F$kli_vxcf"."_mzdddp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{


$sqlt = <<<mzdddp
(
   cpl          int not null auto_increment,
   oc           INT(7),
   perz_dd      DECIMAL(10,2),
   fixz_dd      DECIMAL(10,2),
   perp_dd      DECIMAL(10,2),
   fixp_dd      DECIMAL(10,2),
   cddp         INT(7),
   czm          VARCHAR(35) NOT NULL,
   dtd          DATE,
   pd1          INT(1) DEFAULT 0,
   pd2          INT(1) DEFAULT 0,
   pd3          INT(1) DEFAULT 0,
   pd4          INT(1) DEFAULT 0,
   datm         TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
mzdddp;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdddp'.$sqlt;

$vysledek = mysql_query("$sql");

}
//rozsirit mzdddp
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdddp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
//koniec tabulky mzdddp


//Tabulka zdravpois
$sql = "SELECT * FROM F$kli_vxcf"."_zdravpois";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<zdravpois
(
   zdrv         INT(6) PRIMARY KEY UNIQUE,
   nzdr         VARCHAR(35),
   uceb         VARCHAR(30),
   numb         VARCHAR(4),
   iban         VARCHAR(30),
   vsy          int(10),
   ksy          varchar(4) NOT NULL,
   ssy          varchar(10) NOT NULL,
   anl          int(10),
   pz1          int(10),
   pz2          int(10),
   pz3          int(10),
   pz4          int(10),
   pz5          int(10),
   pt1          VARCHAR(35),
   pt2          VARCHAR(35),
   pt3          VARCHAR(35),
   datm         TIMESTAMP(14)
);
zdravpois;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_zdravpois'.$sqlt;

$vysledek = mysql_query("$sql");



$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2700', 'UNION ZP' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2400', 'Dôvera ZP' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '2508', 'VŠZP' )";
$ttqq = mysql_query("$ttvv");

$ttvv = "INSERT INTO F$kli_vxcf"."_zdravpois ( zdrv,nzdr ) VALUES ( '0', 'Žiadna ZP' )";
$ttqq = mysql_query("$ttvv");
}
//rozsirit zdravpois
$sql = "SELECT omes FROM F$kli_vxcf"."_zdravpois";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_zdravpois MODIFY vsy DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
}
//koniec zdravpois

//Tabulka mzddss
$sql = "SELECT * FROM F$kli_vxcf"."_mzddss";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzddss
(
   cdss         INT(6) PRIMARY KEY UNIQUE,
   ndss         VARCHAR(35),
   uceb         VARCHAR(30),
   numb         VARCHAR(4),
   iban         VARCHAR(30),
   vsy          int(10),
   ksy          varchar(4) NOT NULL,
   ssy          varchar(10) NOT NULL,
   anl          int(10),
   pz1          int(10),
   pz2          int(10),
   pz3          int(10),
   pz4          int(10),
   pz5          int(10),
   pt1          VARCHAR(35),
   pt2          VARCHAR(35),
   pt3          VARCHAR(35),
   datm         TIMESTAMP(14)
);
mzddss;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzddss'.$sqlt;

$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_mzddss ( cdss,ndss ) VALUES ( '1', 'DSS 1' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_mzddss ( cdss,ndss ) VALUES ( '2', 'DSS 2' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_mzddss ( cdss,ndss ) VALUES ( '3', 'DSS 3' )";
$ttqq = mysql_query("$ttvv");
}
//rozsirit mzddss
$sql = "SELECT omes FROM F$kli_vxcf"."_mzddss";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzddss MODIFY vsy DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
}
//koniec mzddss

//Tabulka mzdcisddp
$sql = "SELECT * FROM F$kli_vxcf"."_mzdcisddp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{


$sqlt = <<<mzdcisddp
(
   cddp         INT(6) PRIMARY KEY UNIQUE,
   nddp         VARCHAR(35),
   uceb         VARCHAR(30),
   numb         VARCHAR(4),
   iban         VARCHAR(30),
   vsy          int(10),
   ksy          varchar(4) NOT NULL,
   ssy          varchar(10) NOT NULL,
   anl          int(10),
   pz1          int(10),
   pz2          int(10),
   pz3          int(10),
   pz4          int(10),
   pz5          int(10),
   pt1          VARCHAR(35),
   pt2          VARCHAR(35),
   pt3          VARCHAR(35),
   datm         TIMESTAMP(14)
);
mzdcisddp;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdcisddp'.$sqlt;


$vysledek = mysql_query("$sql");


$ttvv = "INSERT INTO F$kli_vxcf"."_mzdcisddp ( cddp,nddp ) VALUES ( '1', 'DDP 1' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_mzdcisddp ( cddp,nddp ) VALUES ( '2', 'DDP 2' )";
$ttqq = mysql_query("$ttvv");
$ttvv = "INSERT INTO F$kli_vxcf"."_mzdcisddp ( cddp,nddp ) VALUES ( '3', 'DDP 3' )";
$ttqq = mysql_query("$ttvv");
}
//rozsirit mzdcisddp
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdcisddp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdcisddp MODIFY vsy DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
}
//koniec mzdcisddp

//Tabulka mzdpomer
$sql = "SELECT * FROM F$kli_vxcf"."_mzdpomer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzdpomer
(
   pm           INT(7),
   nzpm         VARCHAR(60) NOT NULL,
   prpm         VARCHAR(60) NOT NULL,
   zam_zp       INT(1) DEFAULT 1,
   zam_np       INT(1) DEFAULT 1,
   zam_sp       INT(1) DEFAULT 1,
   zam_ip       INT(1) DEFAULT 1,
   zam_pn       INT(1) DEFAULT 1,
   zam_up       INT(1) DEFAULT 0,
   zam_gf       INT(1) DEFAULT 0,
   zam_rf       INT(1) DEFAULT 0,
   fir_zp       INT(1) DEFAULT 1,
   fir_np       INT(1) DEFAULT 1,
   fir_sp       INT(1) DEFAULT 1,
   fir_ip       INT(1) DEFAULT 1,
   fir_pn       INT(1) DEFAULT 1,
   fir_up       INT(1) DEFAULT 1,
   fir_gf       INT(1) DEFAULT 1,
   fir_rf       INT(1) DEFAULT 1,
   zam_zm       INT(1) DEFAULT 1,
   pm_doh       INT(1) DEFAULT 0,
   pm_maj       INT(1) DEFAULT 0,
   np_soc       INT(1) DEFAULT 0,
   pm1          INT(1) DEFAULT 0,
   pm2          INT(1) DEFAULT 0,
   pm3          INT(1) DEFAULT 0,
   pm4          INT(1) DEFAULT 0,
   datm         TIMESTAMP(14)
);
mzdpomer;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdpomer'.$sqlt;

$vysledek = mysql_query("$sql");

}
//rozsirit mzdpomer
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdpomer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
//koniec tabulky mzdpomer

//Tabulka mzddmn
$sql = "SELECT * FROM F$kli_vxcf"."_mzddmn";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzddmn
(
   dm           INT(7),
   nzdm         VARCHAR(15) NOT NULL,
   dndm         VARCHAR(60) NOT NULL,
   td           INT(1) DEFAULT 0,
   nap_zp       INT(1) DEFAULT 1,
   nap_np       INT(1) DEFAULT 1,
   nap_sp       INT(1) DEFAULT 1,
   nap_ip       INT(1) DEFAULT 1,
   nap_pn       INT(1) DEFAULT 1,
   nap_up       INT(1) DEFAULT 1,
   nap_gf       INT(1) DEFAULT 1,
   nap_rf       INT(1) DEFAULT 1,
   br           INT(1) DEFAULT 0,
   rh           INT(1) DEFAULT 0,
   do           INT(1) DEFAULT 0,
   ne           INT(1) DEFAULT 0,
   ho           INT(1) DEFAULT 0,
   np           INT(1) DEFAULT 0,
   prn          INT(1) DEFAULT 0,
   prm          INT(1) DEFAULT 0,
   prv          INT(1) DEFAULT 0,
   prs          INT(1) DEFAULT 0,
   sa           DECIMAL(10,4),
   ko           DECIMAL(10,4),
   sax          DECIMAL(10,4),
   su           INT(6) DEFAULT 0,
   au           INT(6) DEFAULT 0,
   suc          INT(6) DEFAULT 0,
   auc          INT(6) DEFAULT 0,
   dm1          INT(1) DEFAULT 0,
   dm2          INT(1) DEFAULT 0,
   dm3          INT(1) DEFAULT 0,
   dm4          INT(1) DEFAULT 0,
   datm         TIMESTAMP(14)
);
mzddmn;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzddmn'.$sqlt;

$vysledek = mysql_query("$sql");

}
//rozsirit mzddmn
$sql = "SELECT omes FROM F$kli_vxcf"."_mzddmn";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY sa INT(3)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY sax INT(3)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY ko INT(3)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY sa DECIMAL(10,4)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY su VARCHAR(6)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY au VARCHAR(6)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY suc VARCHAR(6)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzddmn MODIFY auc VARCHAR(6)";
$vysledek = mysql_query("$sql");


}
//koniec tabulky mzddmn

//Tabulka mzdprm
$sql = "SELECT * FROM F$kli_vxcf"."_mzdprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzdprm
(
   datum           DATE,
   max_zp          DECIMAL(10,2),
   max_np          DECIMAL(10,2),
   max_sp          DECIMAL(10,2),
   max_ip          DECIMAL(10,2),
   max_pn          DECIMAL(10,2),
   max_up          DECIMAL(10,2),
   max_gf          DECIMAL(10,2),
   max_rf          DECIMAL(10,2),
   min_zp          DECIMAL(10,2),
   min_np          DECIMAL(10,2),
   min_sp          DECIMAL(10,2),
   min_ip          DECIMAL(10,2),
   min_pn          DECIMAL(10,2),
   min_up          DECIMAL(10,2),
   min_gf          DECIMAL(10,2),
   min_rf          DECIMAL(10,2),
   zam_zp          DECIMAL(10,2),
   zam_zpn         DECIMAL(10,2),
   zam_np          DECIMAL(10,2),
   zam_sp          DECIMAL(10,2),
   zam_ip          DECIMAL(10,2),
   zam_pn          DECIMAL(10,2),
   zam_up          DECIMAL(10,2),
   zam_gf          DECIMAL(10,2),
   zam_rf          DECIMAL(10,2),
   fir_zp          DECIMAL(10,2),
   fir_zpn         DECIMAL(10,2),
   fir_np          DECIMAL(10,2),
   fir_sp          DECIMAL(10,2),
   fir_ip          DECIMAL(10,2),
   fir_pn          DECIMAL(10,2),
   fir_up          DECIMAL(10,2),
   fir_gf          DECIMAL(10,2),
   fir_rf          DECIMAL(10,2),
   dan_bonus       DECIMAL(10,2),
   dan_danov       DECIMAL(10,2),
   soc_perc        DECIMAL(10,2),
   uva_hod         DECIMAL(10,2),
   min_mzda        DECIMAL(10,2),
   dan_perc        DECIMAL(10,2)
);
mzdprm;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprm'.$sqlt;

$vysledek = mysql_query("$sql");

}
//nastavit parametre miezd
$sql = "SELECT datum FROM F$kli_vxcf"."_mzdprm WHERE datum = '2009-01-01'";
$vysledok = mysql_query("$sql");
$cpol = mysql_num_rows($vysledok);


if ( $cpol == 0 )
{
$ttvv = "INSERT INTO F$kli_vxcf"."_mzdprm ( datum,max_zp,max_np,max_sp,max_ip,max_pn,max_up,max_gf,max_rf,".
"min_zp,min_np,min_sp,min_ip,min_pn,min_up,min_gf,min_rf,".
"zam_zp,zam_np,zam_sp,zam_ip,zam_pn,zam_up,zam_gf,zam_rf,".
"fir_zp,fir_np,fir_sp,fir_ip,fir_pn,fir_up,fir_gf,fir_rf,zam_zpn,fir_zpn,".
"dan_bonus,dan_danov,soc_perc,uva_hod,min_mzda,dan_perc )".
" VALUES ( '2009-01-01', 2006.17, 1003.09, 2674.90, 2674.90, 2674.90, 9999999, 1003.09, 2674.90,".
" 295.50, 295.50, 295.50, 295.50, 295.50, 295.50, 295.50, 295.50, ".
" 4, 1.4, 4, 3, 1, 0, 0, 0, ".
" 10, 1.4, 14, 3, 1, 0.8, 0.25, 4.75, 2, 5, ".
" 19.32, 335.47, 0.8, 8, 295.50, 19 ".
" )";

$ttqq = mysql_query("$ttvv");
}
//rozsirit mzdprm
$sql = "SELECT cicz FROM F$kli_vxcf"."_mzdprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD zucz INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD zucs INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ssys VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ksys VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD vsys INT(10) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD nums VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD uces VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD zucd INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ssyd VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ksyd VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD vsyd INT(10) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD numd VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD uced VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD cicz VARCHAR(20) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
}

$sql = "SELECT ucedz FROM F$kli_vxcf"."_mzdprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm MODIFY vsys DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm MODIFY vsyd DECIMAL(10,0)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD zucdz INT(2) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ssydz VARCHAR(10) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ksydz VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD vsydz DECIMAL(10,0) DEFAULT 0 AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD numdz VARCHAR(4) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprm ADD ucedz VARCHAR(30) NOT NULL AFTER dan_perc";
$vysledek = mysql_query("$sql");
$sql = "UPDATE F$kli_vxcf"."_mzdprm SET max_gf=1003.09";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
//koniec tabulky mzdprm


//Tabulka mzdmes
$sql = "SELECT * FROM F$kli_vxcf"."_mzdmes";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzdmes
(
   cpl          int not null auto_increment,
   dok          INT(8) DEFAULT 0,
   dat          DATE not null,
   ume          DECIMAL(7,4),
   oc           INT(7) DEFAULT 0,
   dm           INT(4) DEFAULT 0,
   dp           DATE not null,
   dk           DATE not null,
   dni          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   mnz          DECIMAL(10,4) DEFAULT 0,
   saz          DECIMAL(10,4) DEFAULT 0,
   kc           DECIMAL(10,2) DEFAULT 0,
   str          INT(7) DEFAULT 0,
   zak          INT(7) DEFAULT 0,
   stj          INT(7) DEFAULT 0,
   msx1         INT(1) DEFAULT 0,
   msx2         INT(1) DEFAULT 0,
   msx3         INT(1) DEFAULT 0,
   msx4         INT(1) DEFAULT 0,
   id           INT,
   datm         TIMESTAMP(14),
   PRIMARY KEY(cpl)
);
mzdmes;


$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzdmes'.$sqlt;

$vysledek = mysql_query("$sql");

}
//rozsirit mzdmes
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdmes";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdmes ADD pop VARCHAR(50) NOT NULL AFTER msx4";
$vysledek = mysql_query("$sql");


}
//koniec tabulky mzdmes

//vytvorenie tabuliek adresara ZAL
$sql = "SELECT ume FROM F$kli_vxcf"."_mzdzalkun ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalkun ".
"SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc=0";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzaltrn ".
"SELECT * FROM F".$kli_vxcf."_mzdtrn WHERE oc=0";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalddp ".
"SELECT * FROM F".$kli_vxcf."_mzdddp WHERE oc=0";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalprm ".
"SELECT * FROM F".$kli_vxcf."_mzdprm WHERE fir_np=1000";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdzalmes ".
"SELECT * FROM F".$kli_vxcf."_mzdmes WHERE oc=0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun ADD ume DECIMAL(7,4) FIRST";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzaltrn ADD ume DECIMAL(7,4) FIRST";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalddp ADD ume DECIMAL(7,4) FIRST";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalprm ADD ume DECIMAL(7,4) FIRST";
$vysledek = mysql_query("$sql");
}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdzalprm";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdzaltrn";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdzalddp";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

}
$sql = "SELECT omes FROM F$kli_vxcf"."_mzdzalkun";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun ADD uvazn INT(1) DEFAULT 0 AFTER uva";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun MODIFY cop VARCHAR(20)";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun ADD rodn VARCHAR(35) NOT NULL AFTER prie";
$vysledek = mysql_query("$sql");
}
//koniec vytvorenia tabuliek adresara ZAL

//Tabulka mzducty
$sql = "SELECT * FROM F$kli_vxcf"."_mzducty";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<mzducty
(
   ucty            INT(2),
   ucf_zp          VARCHAR(10),
   ucf_np          VARCHAR(10),
   ucf_sp          VARCHAR(10),
   ucf_ip          VARCHAR(10),
   ucf_pn          VARCHAR(10),
   ucf_up          VARCHAR(10),
   ucf_gf          VARCHAR(10),
   ucf_rf          VARCHAR(10),
   ucp_zp          VARCHAR(10),
   ucp_np          VARCHAR(10),
   ucp_sp          VARCHAR(10),
   ucp_ip          VARCHAR(10),
   ucp_pn          VARCHAR(10),
   ucp_up          VARCHAR(10),
   ucp_gf          VARCHAR(10),
   ucp_rf          VARCHAR(10),
   ucz_zp          VARCHAR(10),
   ucz_np          VARCHAR(10),
   ucz_sp          VARCHAR(10),
   ucz_ip          VARCHAR(10),
   ucz_pn          VARCHAR(10),
   ucz_up          VARCHAR(10),
   ucz_gf          VARCHAR(10),
   ucz_rf          VARCHAR(10),
   ucm_soc         VARCHAR(10),
   ucd_soc         VARCHAR(10),
   puc_zam         VARCHAR(10),
   puc_kon         VARCHAR(10),
   konxuc          INT(2)
);
mzducty;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_mzducty'.$sqlt;

$vysledek = mysql_query("$sql");

}
//nastavit parametre uctovania miezd
$sql = "SELECT * FROM F$kli_vxcf"."_mzducty WHERE ucty = 1";
$vysledok = mysql_query("$sql");
$cpol = mysql_num_rows($vysledok);



if ( $cpol == 0 )
{
$ttvv = "INSERT INTO F$kli_vxcf"."_mzducty ( ucty,ucf_zp,ucf_np,ucf_sp,ucf_ip,ucf_pn,ucf_up,ucf_gf,ucf_rf,".
"ucp_zp,ucp_np,ucp_sp,ucp_ip,ucp_pn,ucp_up,ucp_gf,ucp_rf,".
"ucz_zp,ucz_np,ucz_sp,ucz_ip,ucz_pn,ucz_up,ucz_gf,ucz_rf,".
"ucm_soc,ucd_soc,puc_zam,puc_kon,konxuc )".
" VALUES ( 1, '52400', '52400', '52400', '52400', '52400', '52400', '52400', '52400', ".
" '33610', '33620', '33620', '33620', '33620', '33620', '33620', '33620', ".
" '33610', '33620', '33620', '33620', '33620', '33620', '33620', '33620', ".
" '52700', '47230', '33100', '36600', '1' ".
" )";

$ttqq = mysql_query("$ttvv");
}
//rozsirit mzducty

$sql = "SELECT omes FROM F$kli_vxcf"."_mzducty";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD cfuct INT(2) DEFAULT 0 AFTER puc_kon";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucm_ddpf VARCHAR(10) DEFAULT '52490' AFTER puc_kon";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzducty ADD ucd_ddpf VARCHAR(10) DEFAULT '33690' AFTER ucm_ddpf";
$vysledek = mysql_query("$sql");
}
//koniec tabulky mzducty

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

//vymaz upravove subory pre parametre
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new032009".$sqlt;
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new072009".$sqlt;
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012010".$sqlt;
$vysledek = mysql_query("$sql");

//Tabulka vtvmzd
$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_vtvmzd'.$sqlt;

$vysledek = mysql_query("$sql");
echo "Podsystém Mzdy a personalistika inicializovaný.<br />";
}
//koniec tabulky vtvmzd

$vtvmzd = 1;
return $vtvmzd;

?>
</BODY>
</HTML>