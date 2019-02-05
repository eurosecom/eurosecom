<?php

//echo "idem";
$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

if( $vyb_roks == 2019 )
     {

$sql = "CREATE TABLE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdprm2018 SELECT * FROM ".$mysqldbdatas.".F$vyb_xcfs"."_mzdprm";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdpomer SET fir_up=1 WHERE pm = 3 ";
$vysledek = mysql_query("$sql");

$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdprm SET ".
" zam_zp=4,    fir_zp=10,   max_zp=9999999, min_zp=0, zam_zpn=2, fir_zpn=5, ".
" zam_np=1.4,  fir_np=1.4,  max_np=6678.00, min_np=0, ".
" zam_sp=4,    fir_sp=14,   max_sp=6678.00, min_sp=0, ".
" zam_ip=3,    fir_ip=3,    max_ip=6678.00, min_ip=0, ".
" zam_pn=1,    fir_pn=1,    max_pn=6678.00, min_pn=0, ".
" zam_gf=0,    fir_gf=0.25, max_gf=6678.00, min_gf=0, ".
" zam_up=0,    fir_up=0.8,  max_up=9999999, min_up=0, ".
" zam_rf=0,    fir_rf=4.75, max_rf=6678.00, min_rf=0, ".
" min_mzda=520.00, dan_bonus=22.17, dan_danov=328.11  ";
$vysledek = mysql_query("$sql");
//echo $sql;

//echo $kli_nezis;
if( $kli_nezi == 0 AND $_SERVER['SERVER_NAME'] != "www.euroalchem.sk" )
          {
$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzddmn SET sa=0.7473 WHERE dm = 202 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzddmn SET sa=1.4945 WHERE dm = 203 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzddmn SET sa=0.8967 WHERE dm = 223 ";
$vysledek = mysql_query("$sql");
          }

if( $kli_nezi == 0 AND $_SERVER['SERVER_NAME'] == "www.euroalchem.sk" )
          {
$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzddmn SET sa=0.7473 WHERE dm = 205 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzddmn SET sa=1.4945 WHERE dm = 206 ";
$vysledek = mysql_query("$sql");
$sql = "UPDATE ".$mysqldbdatas.".F$vyb_xcfs"."_mzddmn SET sa=0.8967 WHERE dm = 223 ";
$vysledek = mysql_query("$sql");
          }

     }

$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018a";
$vysledek = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_mzdprm_new012018b";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE ".$mysqldbdatas.".F$vyb_xcfs"."_mzdprm_new012019c".$sqlt;
$vysledek = mysql_query("$sql");

?>