<?php
//echo "sepa 2017";
$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;


//zmenit mzdtrn a mzdzaltrn trx4 na varchar(50)
$sql = "ALTER TABLE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdtrn MODIFY trx4 VARCHAR(50) NOT NULL";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdzaltrn MODIFY trx4 VARCHAR(50) NOT NULL";
$vysledek = mysql_query("$sql");

//rozsirit ufirdalsie o ibany a sp, odbory 
//iban dane sp a odbory
$sql = "SELECT ibod FROM F".$kli_vxcf."_ufirdalsie";
$vysledok = mysql_query($sql);
if (!$vysledok)
{
$kli_vxcf=$vyb_xcfs;
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpfo1 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpfo2 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdppo1 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdppo2 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdph VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpzc VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpzr VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpdmv VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibdpfo1 VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ucsp VARCHAR(25) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD nmsp VARCHAR(6) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD kssp VARCHAR(4) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD sssp VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD vssp VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibsp VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ucod VARCHAR(25) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD nmod VARCHAR(6) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ksod VARCHAR(4) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ssod VARCHAR(10) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD vsod VARCHAR(20) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_ufirdalsie ADD ibod VARCHAR(50) NOT NULL AFTER kkx";
$vysledek = mysql_query("$sql");
}

//rozsirit mzdtextmzd o iban zamestnanca
$sql = "SELECT ziban FROM F".$kli_vxcf."_mzdtextmzd ";
$vysledok = mysql_query($sql);
if (!$vysledok){
$kli_vxcf=$vyb_xcfs;
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtextmzd ADD zswft VARCHAR(15) not null AFTER zdro";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdtextmzd ADD ziban VARCHAR(50) not null AFTER zdro";
$vysledek = mysql_query("$sql");
               }

$kli_vxcf=$vyb_xcfs;
$sql = "ALTER TABLE F$kli_vxcf"."_mzdcisddp MODIFY iban VARCHAR(50) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdcisddp MODIFY pt3 VARCHAR(35) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zdravpois MODIFY iban VARCHAR(50) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_zdravpois MODIFY pt3 VARCHAR(35) NOT NULL ";
$vysledek = mysql_query("$sql");


$sql = "CREATE TABLE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdprm_sepa012016a".$sqlt;
$vysledek = mysql_query("$sql");
?>