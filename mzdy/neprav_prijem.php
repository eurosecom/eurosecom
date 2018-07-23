<?php

$podm_ocx="ocx > 0";
if( $all_oc == 0 )
{
$podm_ocx="ocx = ".$vyb_osc;
}

$podmspomer=" ( ";
$podmvpomer=" ( ";

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE pm4 = 1 ORDER BY pm ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
           
$i=0;
  while ($i < $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);

if( $i > 0 ) { $podmspomer=$podmspomer." OR "; }
$podmspomer=$podmspomer." spom = ".$riadok->pm;
if( $i > 0 ) { $podmvpomer=$podmvpomer." OR "; }
$podmvpomer=$podmvpomer." vpom = ".$riadok->pm;
}
$i=$i+1;
  }

$podmspomer=$podmspomer." ) ";
$podmvpomer=$podmvpomer." ) ";


$sql = "SELECT zzam12b FROM F$kli_vxcf"."_mzdneprav ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
 {

$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdneprav';
$vytvor = mysql_query("$vsql");

$sqlt = <<<statistika_p1304
(
   cpv          INT NOT NULL auto_increment,
   ocx          decimal(10,0) DEFAULT 0,
   spom         decimal(10,0) DEFAULT 0,
   pocdni       decimal(10,0) DEFAULT 0,
   strajk       decimal(10,0) DEFAULT 0,
   skonci       decimal(10,0) DEFAULT 0,
   neplat       decimal(10,0) DEFAULT 0,
   zzam01m      DECIMAL(10,2) DEFAULT 0,
   zzam02m      DECIMAL(10,2) DEFAULT 0,
   zzam03m      DECIMAL(10,2) DEFAULT 0,
   zzam04m      DECIMAL(10,2) DEFAULT 0,
   zzam05m      DECIMAL(10,2) DEFAULT 0,
   zzam06m      DECIMAL(10,2) DEFAULT 0,
   zzam07m      DECIMAL(10,2) DEFAULT 0,
   zzam08m      DECIMAL(10,2) DEFAULT 0,
   zzam09m      DECIMAL(10,2) DEFAULT 0,
   zzam10m      DECIMAL(10,2) DEFAULT 0,
   zzam11m      DECIMAL(10,2) DEFAULT 0,
   zzam12m      DECIMAL(10,2) DEFAULT 0,

   zzam01b      DECIMAL(10,2) DEFAULT 0,
   zzam02b      DECIMAL(10,2) DEFAULT 0,
   zzam03b      DECIMAL(10,2) DEFAULT 0,
   zzam04b      DECIMAL(10,2) DEFAULT 0,
   zzam05b      DECIMAL(10,2) DEFAULT 0,
   zzam06b      DECIMAL(10,2) DEFAULT 0,
   zzam07b      DECIMAL(10,2) DEFAULT 0,
   zzam08b      DECIMAL(10,2) DEFAULT 0,
   zzam09b      DECIMAL(10,2) DEFAULT 0,
   zzam10b      DECIMAL(10,2) DEFAULT 0,
   zzam11b      DECIMAL(10,2) DEFAULT 0,
   zzam12b      DECIMAL(10,2) DEFAULT 0,

   zzam_np      DECIMAL(10,2) DEFAULT 0,
   zzam_sp      DECIMAL(10,2) DEFAULT 0,
   zzam_ip      DECIMAL(10,2) DEFAULT 0,
   zzam_pn      DECIMAL(10,2) DEFAULT 0,
   zzam_up      DECIMAL(10,2) DEFAULT 0,
   zzam_gf      DECIMAL(10,2) DEFAULT 0,
   zzam_rf      DECIMAL(10,2) DEFAULT 0,
   zfir_np      DECIMAL(10,2) DEFAULT 0,
   zfir_sp      DECIMAL(10,2) DEFAULT 0,
   zfir_ip      DECIMAL(10,2) DEFAULT 0,
   zfir_pn      DECIMAL(10,2) DEFAULT 0,
   zfir_up      DECIMAL(10,2) DEFAULT 0,
   zfir_gf      DECIMAL(10,2) DEFAULT 0,
   zfir_rf      DECIMAL(10,2) DEFAULT 0,
   ozam_np      DECIMAL(10,2) DEFAULT 0,
   ozam_sp      DECIMAL(10,2) DEFAULT 0,
   ozam_ip      DECIMAL(10,2) DEFAULT 0,
   ozam_pn      DECIMAL(10,2) DEFAULT 0,
   ozam_up      DECIMAL(10,2) DEFAULT 0,
   ozam_gf      DECIMAL(10,2) DEFAULT 0,
   ozam_rf      DECIMAL(10,2) DEFAULT 0,
   ofir_np      DECIMAL(10,2) DEFAULT 0,
   ofir_sp      DECIMAL(10,2) DEFAULT 0,
   ofir_ip      DECIMAL(10,2) DEFAULT 0,
   ofir_pn      DECIMAL(10,2) DEFAULT 0,
   ofir_up      DECIMAL(10,2) DEFAULT 0,
   ofir_gf      DECIMAL(10,2) DEFAULT 0,
   ofir_rf      DECIMAL(10,2) DEFAULT 0,
   dp           DATE NOT NULL,
   dk           DATE NOT NULL,
   kc           DECIMAL(10,2) DEFAULT 0,
   pmes         DECIMAL(10,0) DEFAULT 0,
   des1         DECIMAL(10,1) DEFAULT 0,
   des2         DECIMAL(10,2) DEFAULT 0,
   des3         DECIMAL(10,3) DEFAULT 0,
   des6         DECIMAL(10,6) DEFAULT 0,
   umex         decimal(7,4) DEFAULT 0,   
   umeo         decimal(7,4) DEFAULT 0,
   konx         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpv)
);
statistika_p1304;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdneprav'.$sqlt;
$vytvor = mysql_query("$vsql");

if( $kli_vrok == 2013 )
     {
//minule zaklady uloz
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav SELECT ".
" 0,oc,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" zfir_up,0,0,0,0,0,0,0,0,0,0,0, ".
" SUM(zzam_np),SUM(zzam_sp),SUM(zzam_ip),SUM(zzam_pn),SUM(zzam_up),SUM(zzam_gf),SUM(zzam_rf),".
" SUM(zfir_np),SUM(zfir_sp),SUM(zfir_ip),SUM(zfir_pn),SUM(zfir_up),SUM(zfir_gf),SUM(zfir_rf),".
" SUM(ozam_np),SUM(ozam_sp),SUM(ozam_ip),SUM(ozam_pn),SUM(ozam_up),SUM(ozam_gf),SUM(ozam_rf),".
" SUM(ofir_np),SUM(ofir_sp),SUM(ofir_ip),SUM(ofir_pn),SUM(ofir_up),SUM(ofir_gf),SUM(ofir_rf),".
" '','',0,0, ".
" 0,0,0,0,ume,ume,0 ".
" FROM F$kli_vxcf"."_mzdzalsum ".
" WHERE $podmspomer AND ume = 01.2013 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

     }

 }
//koniec vytvorenie


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdneprav'.$kli_uzid.' ';
$vytvor = mysql_query("$vsql");

//dalej len ak su pohyby nepravidelne v vy
$umesp=0;
$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdprcvy$kli_uzid WHERE dm >= 100 AND dm <= 199 AND $podm_oc AND $podmvpomer ";

$posl = mysql_query("$poslhh"); 
if( $posl ) { $umesp = mysql_num_rows($posl); }

if( $umesp > 0 ) {


$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdneprav'.$kli_uzid.' SELECT * FROM F'.$kli_vxcf.'_mzdneprav WHERE ocx = 0 ';
$vytvor = mysql_query("$vsql");

//minule zaklady ber z mzdneprav
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav$kli_uzid SELECT ".
" 0,ocx,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,zfir_up,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" '','',0,0, ".
" 0,0,0,0,umex,umeo,10 ".
" FROM F$kli_vxcf"."_mzdneprav ".
" WHERE $podm_ocx AND umex < $kli_vume ";
$dsql = mysql_query("$dsqlt");


if( $kli_vmes > 1 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam01m=zfir_up WHERE umeo = 01.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 2 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam02m=zfir_up WHERE umeo = 02.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 3 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam03m=zfir_up WHERE umeo = 03.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 4 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam04m=zfir_up WHERE umeo = 04.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 5 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam05m=zfir_up WHERE umeo = 05.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 6 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam06m=zfir_up WHERE umeo = 06.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 7 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam07m=zfir_up WHERE umeo = 07.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 8 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam08m=zfir_up WHERE umeo = 08.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 9 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam09m=zfir_up WHERE umeo = 09.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 10 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam10m=zfir_up WHERE umeo = 10.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}
if( $kli_vmes > 11 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam11m=zfir_up WHERE umeo = 11.$kli_vrok AND konx = 10 ";
$dsql = mysql_query("$dsqlt");
}


$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_up=0 ";
$dsql = mysql_query("$dsqlt");
//exit;

//bezny mesiac zaklady
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav$kli_uzid SELECT ".
" 0,oc,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" dp,dk,kc,0, ".
" 0,0,0,0,ume,0,1 ".
" FROM F$kli_vxcf"."_mzdprcvy$kli_uzid ".
" WHERE dm >= 100 AND dm <= 199 AND $podm_oc AND $podmvpomer ";
$dsql = mysql_query("$dsqlt");

//pociatok a koniec ochrana datumov
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vmes.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $datk=$riaddok->dat;
  }

$datp01=$kli_vrok."-01-01";
$datp=$kli_vrok."-".$kli_vmes."-01";
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET dp='$datp' WHERE dp = '0000-00-00' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET dp='$datk' WHERE dk = '0000-00-00' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET dk='$datk' WHERE dk > '$datk' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET dp='$datp01' WHERE dk < '$datp01' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET dk='$datp01' WHERE dk < '$datp01' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET dp=dk WHERE dk < dp AND konx = 1 ";
$dsql = mysql_query("$dsqlt");



$kli_vmesx=$kli_vmes;
if( $kli_vmes < 10 ) { $kli_vmesx="0".$kli_vmes; }
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET pmes=MONTH(dk)-MONTH(dp)+1 WHERE konx = 1 ";
$dsql = mysql_query("$dsqlt");

if( $kli_vmes > 1 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 01.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat01p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 01.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat01k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam01b=kc/pmes WHERE dp <= '$dat01k' AND dk >= '$dat01p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt"); 
                    }

if( $kli_vmes > 2 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 02.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat02p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 02.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat02k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam02b=kc/pmes WHERE dp <= '$dat02k' AND dk >= '$dat02p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 3 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 03.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat03p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 03.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat03k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam03b=kc/pmes WHERE dp <= '$dat03k' AND dk >= '$dat03p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 4 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 04.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat04p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 04.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat04k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam04b=kc/pmes WHERE dp <= '$dat04k' AND dk >= '$dat04p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 5 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 05.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat05p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 05.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat05k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam05b=kc/pmes WHERE dp <= '$dat05k' AND dk >= '$dat05p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 6 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 06.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat06p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 06.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat06k=$riaddok->dat;
  }


$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam06b=kc/pmes WHERE dp <= '$dat06k' AND dk >= '$dat06p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 7 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 07.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat07p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 07.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat07k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam07b=kc/pmes WHERE dp <= '$dat07k' AND dk >= '$dat07p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 8 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 08.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat08p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 08.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat08k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam08b=kc/pmes WHERE dp <= '$dat08k' AND dk >= '$dat08p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 9 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 09.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat09p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 09.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat09k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam09b=kc/pmes WHERE dp <= '$dat09k' AND dk >= '$dat09p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 10 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 10.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat10p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 10.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat10k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam10b=kc/pmes WHERE dp <= '$dat10k' AND dk >= '$dat10p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }

if( $kli_vmes > 11 ) { 

$sqltt = "SELECT * FROM kalendar WHERE ume = 11.$kli_vrok ORDER BY dat LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat11p=$riaddok->dat;
  }

$sqltt = "SELECT * FROM kalendar WHERE ume = 11.$kli_vrok ORDER BY dat DESC LIMIT 1 ";
$sqldok = mysql_query("$sqltt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $dat11k=$riaddok->dat;
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam11b=kc/pmes WHERE dp <= '$dat11k' AND dk >= '$dat11p' AND konx = 1 ";
$dsql = mysql_query("$dsqlt");
                    }


$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ".
" zzam".$kli_vmesx."b=zzam".$kli_vmesx."b+(kc-zzam01b-zzam02b-zzam03b-zzam04b-zzam05b-zzam06b-zzam07b-zzam08b-zzam09b-zzam10b-zzam11b-zzam12b) WHERE  konx = 1 ";
$dsql = mysql_query("$dsqlt");

//suma za zamestnanca
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav$kli_uzid SELECT ".
" 0,ocx,0,0,0,0,0, ".
" SUM(zzam01m),SUM(zzam02m),SUM(zzam03m),SUM(zzam04m),SUM(zzam05m),SUM(zzam06m),SUM(zzam07m),SUM(zzam08m),SUM(zzam09m),SUM(zzam10m),SUM(zzam11m),SUM(zzam12m), ".
" SUM(zzam01b),SUM(zzam02b),SUM(zzam03b),SUM(zzam04b),SUM(zzam05b),SUM(zzam06b),SUM(zzam07b),SUM(zzam08b),SUM(zzam09b),SUM(zzam10b),SUM(zzam11b),SUM(zzam12b), ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0,0,0, ".
" '','',0,0, ".
" 0,0,0,0,umex,0,2 ".
" FROM F$kli_vxcf"."_mzdneprav$kli_uzid ".
" WHERE ocx > 0 GROUP BY ocx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdneprav$kli_uzid WHERE konx != 2 ";
$dsql = mysql_query("$dsqlt");


$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid,F$kli_vxcf"."_$mzdkun ".
" SET spom=pom  WHERE F$kli_vxcf"."_mzdneprav$kli_uzid.ocx = F$kli_vxcf"."_$mzdkun.oc ";
$oznac = mysql_query("$sqtoz");

if( $kli_uzid == 1717 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdneprav$kli_uzid ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

echo $rtov->ocx." ".$rtov->dp." ".$rtov->dk." ".$rtov->zzam01b." ".$rtov->zzam02b." ".$rtov->zzam03b." ".$rtov->spom."<br />";

 }

$i=$i+1;
   }

exit;
}
//koniec kliuzid=17


$ixx=1;
while( $ixx <= $kli_vmes )
   {

$ixxx=$ixx;
if( $ixx < 10 ) { $ixxx="0".$ixx; }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_np=0, zzam_sp=0 WHERE konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_sp=zzam".$ixxx."b+zzam".$ixxx."m, zzam_np=zzam".$ixxx."b WHERE konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_up=0, zfir_up=zzam_np WHERE konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_np=zzam".$ixxx."b-((zzam".$ixxx."b+zzam".$ixxx."m)-$max_sp) WHERE zzam_sp > $max_sp AND konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_np=0 WHERE zzam_np < 0 AND konx = 2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_np=zzam_np WHERE  konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET umeo=".$ixxx.".".$kli_vrok." WHERE konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";


$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_sp=zzam_np, zzam_ip=zzam_np, zzam_pn=zzam_np, zzam_gf=zzam_np, zzam_rf=zzam_np WHERE konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_sp=zfir_np, zfir_ip=zfir_np, zfir_pn=zfir_np, zfir_gf=zfir_np, zfir_rf=zfir_np WHERE konx = 2 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt."<br />";


//uprava zakladov podla pomeru 
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid,F$kli_vxcf"."_mzdpomer".
" SET ".
" zzam_np=zam_np*zzam_np, zfir_np=fir_np*zfir_np, ".
" zzam_sp=zam_sp*zzam_sp, zfir_sp=fir_sp*zfir_sp, ".
" zzam_ip=zam_ip*zzam_ip, zfir_ip=fir_ip*zfir_ip, ".
" zzam_pn=zam_pn*zzam_pn, zfir_pn=fir_pn*zfir_pn, ".
" zzam_up=zam_up*zzam_up, zfir_up=fir_up*zfir_up, ".
" zzam_gf=zam_gf*zzam_gf, zfir_gf=fir_gf*zfir_gf, ".
" zzam_rf=zam_rf*zzam_rf, zfir_rf=fir_rf*zfir_rf  ".
" WHERE F$kli_vxcf"."_mzdneprav$kli_uzid.spom = F$kli_vxcf"."_mzdpomer.pm";
$oznac = mysql_query("$sqtoz");

//tu vlozim prepocet alikvotnej casti
//if( $ixx == $kli_vmes AND ( $kli_vume >= 12.2014 OR $kli_vrok > 2014 ) AND $_SERVER['SERVER_NAME'] == "www.eurofp.sk" )
if( $ixx == $kli_vmes AND ( $kli_vume >= 12.2014 OR $kli_vrok > 2014 ) )
     {
$pocdnimax=30;
$sqlttr = "SELECT * FROM kalendar WHERE ume = ".$kli_vmes.".".$kli_vrok." ";
$sqlrr = mysql_query("$sqlttr");
$pocdnimax = mysql_num_rows($sqlrr);
$denpr=$kli_vrok."-".$kli_vmes."-01";
$denpo=$kli_vrok."-".$kli_vmes."-".$pocdnimax;

$sqlttd = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE ".
" dan >= '".$denpr."' AND dan <= '".$denpo."' AND dav >= '".$denpr."' AND dav <= '".$denpo."' AND dan != '0000.00.00' AND dav != '0000.00.00' ";
$tovd = mysql_query("$sqlttd");
$tvpold = mysql_num_rows($tovd);
$id=0;
  while ($id <= $tvpold )
  {

  if (@$zaznam=mysql_data_seek($tovd,$id))
 {
$rtovd=mysql_fetch_object($tovd);

$pocetdni=1;
$sqlttr2 = "SELECT * FROM kalendar WHERE dat >= '".$rtovd->dan."' AND dat <= '".$rtovd->dav."' ";
$sqlrr2 = mysql_query("$sqlttr2");
$pocetdni = mysql_num_rows($sqlrr2);
//echo $sqlttr2;

if( $pocetdni < $pocdnimax ) {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_np=$pocetdni*$denVzNp WHERE konx = 2 AND zzam_np > 0 AND ocx = $rtovd->oc AND zzam_np > ($pocetdni*$denVzNp) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_sp=$pocetdni*$denVzSp WHERE konx = 2 AND zzam_sp > 0 AND ocx = $rtovd->oc AND zzam_sp > ($pocetdni*$denVzSp) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_ip=$pocetdni*$denVzIp WHERE konx = 2 AND zzam_ip > 0 AND ocx = $rtovd->oc AND zzam_ip > ($pocetdni*$denVzIp) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam_pn=$pocetdni*$denVzPn WHERE konx = 2 AND zzam_pn > 0 AND ocx = $rtovd->oc AND zzam_pn > ($pocetdni*$denVzPn) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_rf=$pocetdni*$denVzRf WHERE konx = 2 AND zfir_rf > 0 AND ocx = $rtovd->oc AND zfir_rf > ($pocetdni*$denVzRf) ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_gf=$pocetdni*$denVzGf WHERE konx = 2 AND zfir_gf > 0 AND ocx = $rtovd->oc AND zfir_gf > ($pocetdni*$denVzGf) ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_np=zzam_np, zfir_sp=zzam_sp, zfir_ip=zzam_ip, ".
" zfir_pn=zzam_pn WHERE konx = 2 AND ocx = $rtovd->oc ";
$dsql = mysql_query("$dsqlt");

                              }


 }

$id=$id+1;
   }


     }
//koniec tu vlozim prepocet alikvotnej casti

//odvodova ulava dochodca-dohodar od 1.7.2018
if( $ixx >= 7 OR $kli_vrok > 2018 )
  {
//andrejko

$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE zrz_dn = 1 ";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

//echo $rtov->oc." ".$tvpol."<br />";


if( $kli_vrok == 2018 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid ".
" SET zzam_sp=0, zzam_ip=0 WHERE ocx = $rtov->oc AND zzam_sp <= 200 AND ocx = $rtov->oc AND umeo >= 7.2018 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid ".
" SET zzam_sp=zzam_sp-200, zzam_ip=zzam_ip-200 WHERE ocx = $rtov->oc AND zzam_sp > 200 AND ocx = $rtov->oc AND umeo >= 7.2018 ";
$oznac = mysql_query("$sqtoz");
  }
if( $kli_vrok > 2018 )
  {
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid ".
" SET zzam_sp=0, zzam_ip=0 WHERE ocx = $rtov->oc AND zzam_sp <= 200 AND ocx = $rtov->oc ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid ".
" SET zzam_sp=zzam_sp-200, zzam_ip=zzam_ip-200 WHERE ocx = $rtov->oc AND zzam_sp > 200 AND ocx = $rtov->oc ";
$oznac = mysql_query("$sqtoz");
  }

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zfir_sp=zzam_sp, zfir_ip=zzam_ip WHERE ocx = $rtov->oc ";
$dsql = mysql_query("$dsqlt");

 }

$i=$i+1;
   }

//exit;
   

  }
//if( $ixx == 7 ) { exit; }
//koniec odvodova ulava dochodca-dohodar od 1.7.2018

//vypocet odvody
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid".
" SET ".
" des6=($zam_np*zzam_np)/100, des6=des6-0.005, des2=des6, ozam_np=des2, ".
" des6=($fir_np*zfir_np)/100, des6=des6-0.005, des2=des6, ofir_np=des2, ".
" des6=($zam_sp*zzam_sp)/100, des6=des6-0.005, des2=des6, ozam_sp=des2, ".
" des6=($fir_sp*zfir_sp)/100, des6=des6-0.005, des2=des6, ofir_sp=des2, ".
" des6=($zam_ip*zzam_ip)/100, des6=des6-0.005, des2=des6, ozam_ip=des2, ".
" des6=($fir_ip*zfir_ip)/100, des6=des6-0.005, des2=des6, ofir_ip=des2, ".
" des6=($zam_pn*zzam_pn)/100, des6=des6-0.005, des2=des6, ozam_pn=des2, ".
" des6=($fir_pn*zfir_pn)/100, des6=des6-0.005, des2=des6, ofir_pn=des2, ".
" des6=($zam_up*zzam_up)/100, des6=des6-0.005, des2=des6, ozam_up=des2, ".
" des6=($fir_up*zfir_up)/100, des6=des6-0.005, des2=des6, ofir_up=des2, ".
" des6=($zam_gf*zzam_gf)/100, des6=des6-0.005, des2=des6, ozam_gf=des2, ".
" des6=($fir_gf*zfir_gf)/100, des6=des6-0.005, des2=des6, ofir_gf=des2, ".
" des6=($zam_rf*zzam_rf)/100, des6=des6-0.005, des2=des6, ozam_rf=des2, ".
" des6=($fir_rf*zfir_rf)/100, des6=des6-0.005, des2=des6, ofir_rf=des2, ".
" zzam_up=0, zzam_gf=0, zzam_rf=0, des1=0, des2=0, des3=0, des6=0 ".
" WHERE ocx > 0 ";
$oznac = mysql_query("$sqtoz");


//poistka ak odvod < 0 potom odvod=0
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_np=0 WHERE ozam_np < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_np=0 WHERE ofir_np < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_sp=0 WHERE ozam_sp < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_sp=0 WHERE ofir_sp < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_ip=0 WHERE ozam_ip < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_ip=0 WHERE ofir_ip < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_pn=0 WHERE ozam_pn < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_pn=0 WHERE ofir_pn < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_up=0 WHERE ozam_up < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_up=0 WHERE ofir_up < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_gf=0 WHERE ozam_gf < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_gf=0 WHERE ofir_gf < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ozam_rf=0 WHERE ozam_rf < 0 "; $oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET ofir_rf=0 WHERE ofir_rf < 0 "; $oznac = mysql_query("$sqtoz");

$kli_umeo=$ixxx.".".$kli_vrok;

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav$kli_uzid SELECT ".
" 0,ocx,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" zzam_np,zzam_sp,zzam_ip,zzam_pn,zzam_up,zzam_gf,zzam_rf,zfir_np,zfir_sp,zfir_ip,zfir_pn,zfir_up,zfir_gf,zfir_rf, ".
" ozam_np,ozam_sp,ozam_ip,ozam_pn,ozam_up,ozam_gf,ozam_rf,ofir_np,ofir_sp,ofir_ip,ofir_pn,ofir_up,ofir_gf,ofir_rf, ".
" '','',0,0, ".
" 0,0,0,0,'$kli_vume','$kli_umeo',20 ".
" FROM F$kli_vxcf"."_mzdneprav$kli_uzid ".
" WHERE ocx > 0 AND konx = 2  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdneprav$kli_uzid SET zzam".$ixxx."b=zfir_up WHERE konx = 20 AND umeo = ".$ixxx.".".$kli_vrok." AND umex = $kli_vume ";
$dsql = mysql_query("$dsqlt");

$ixx=$ixx+1;
    }

if( $kli_uzid == 383838383 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdneprav$kli_uzid ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);

echo $rtov->ocx." sp ".$rtov->zzam_sp." ip ".$rtov->zzam_ip." osp ".$rtov->ozam_sp." oip ".$rtov->ozam_ip." ".$rtov->umeo." ".$rtov->konx." ".$denVzSp."<br />";

 }

$i=$i+1;
   }

exit;
}
//koniec kliuzid=38


//exit;

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdneprav$kli_uzid WHERE ".
" zfir_np = 0 AND zfir_sp = 0 AND  zfir_ip = 0 AND  zfir_pn = 0 AND  zfir_up = 0 AND  zfir_gf = 0 AND  zfir_rf = 0 "; 
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdneprav$kli_uzid WHERE konx != 20 ";
$dsql = mysql_query("$dsqlt");

//exit;

//suma za zamestnanca
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav$kli_uzid SELECT ".
" 0,ocx,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" SUM(zzam_np),SUM(zzam_sp),SUM(zzam_ip),SUM(zzam_pn),SUM(zzam_up),SUM(zzam_gf),SUM(zzam_rf),".
" SUM(zfir_np),SUM(zfir_sp),SUM(zfir_ip),SUM(zfir_pn),SUM(zfir_up),SUM(zfir_gf),SUM(zfir_rf),".
" SUM(ozam_np),SUM(ozam_sp),SUM(ozam_ip),SUM(ozam_pn),SUM(ozam_up),SUM(ozam_gf),SUM(ozam_rf),".
" SUM(ofir_np),SUM(ofir_sp),SUM(ofir_ip),SUM(ofir_pn),SUM(ofir_up),SUM(ofir_gf),SUM(ofir_rf),".
" '','',0,0, ".
" 0,0,0,0,$kli_vume,$kli_umeo,30 ".
" FROM F$kli_vxcf"."_mzdneprav$kli_uzid ".
" WHERE ocx > 0 GROUP BY ocx ";
$dsql = mysql_query("$dsqlt");



//echo "ostre".$ostre." "."data_zal".$data_zal." ";
if( $ostre == 1 )
{
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdneprav WHERE umex = $kli_vume  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdneprav SELECT ".
" 0,ocx,0,0,0,0,0, ".
" 0,0,0,0,0,0,0,0,0,0,0,0, ".
" SUM(zzam01b),SUM(zzam02b),SUM(zzam03b),SUM(zzam04b),SUM(zzam05b),SUM(zzam06b),SUM(zzam07b),SUM(zzam08b),SUM(zzam09b),SUM(zzam10b),SUM(zzam11b),SUM(zzam12b), ".
" SUM(zzam_np),SUM(zzam_sp),SUM(zzam_ip),SUM(zzam_pn),SUM(zzam_up),SUM(zzam_gf),SUM(zzam_rf),".
" SUM(zfir_np),SUM(zfir_sp),SUM(zfir_ip),SUM(zfir_pn),SUM(zfir_up),SUM(zfir_gf),SUM(zfir_rf),".
" SUM(ozam_np),SUM(ozam_sp),SUM(ozam_ip),SUM(ozam_pn),SUM(ozam_up),SUM(ozam_gf),SUM(ozam_rf),".
" SUM(ofir_np),SUM(ofir_sp),SUM(ofir_ip),SUM(ofir_pn),SUM(ofir_up),SUM(ofir_gf),SUM(ofir_rf),".
" '','',0,0, ".
" 0,0,0,0,umex,umeo,0 ".
" FROM F$kli_vxcf"."_mzdneprav$kli_uzid ".
" WHERE konx = 20 GROUP BY ocx,umeo ";
$dsql = mysql_query("$dsqlt");

}

$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdneprav$kli_uzid WHERE konx != 30 ";
$dsql = mysql_query("$dsqlt");

$sqtoz = "UPDATE F$kli_vxcf"."_mzdprcsum$kli_uzid,F$kli_vxcf"."_mzdneprav$kli_uzid ".
" SET ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_rf=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_rf, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_gf=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_gf, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_up=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_up, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_pn=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_pn, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_ip=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_ip, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_sp=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_sp, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ofir_np=F$kli_vxcf"."_mzdneprav$kli_uzid.ofir_np, ".

" F$kli_vxcf"."_mzdprcsum$kli_uzid.ozam_pn=F$kli_vxcf"."_mzdneprav$kli_uzid.ozam_pn, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ozam_ip=F$kli_vxcf"."_mzdneprav$kli_uzid.ozam_ip, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ozam_sp=F$kli_vxcf"."_mzdneprav$kli_uzid.ozam_sp, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.ozam_np=F$kli_vxcf"."_mzdneprav$kli_uzid.ozam_np, ".

" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_rf=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_rf, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_gf=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_gf, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_up=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_up, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_pn=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_pn, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_ip=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_ip, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_sp=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_sp, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zfir_np=F$kli_vxcf"."_mzdneprav$kli_uzid.zfir_np, ".

" F$kli_vxcf"."_mzdprcsum$kli_uzid.zzam_pn=F$kli_vxcf"."_mzdneprav$kli_uzid.zzam_pn, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zzam_ip=F$kli_vxcf"."_mzdneprav$kli_uzid.zzam_ip, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zzam_sp=F$kli_vxcf"."_mzdneprav$kli_uzid.zzam_sp, ".
" F$kli_vxcf"."_mzdprcsum$kli_uzid.zzam_np=F$kli_vxcf"."_mzdneprav$kli_uzid.zzam_np ".
" WHERE F$kli_vxcf"."_mzdprcsum$kli_uzid.oc=F$kli_vxcf"."_mzdneprav$kli_uzid.ocx ";
$oznac = mysql_query("$sqtoz");


$vsql = 'DROP TABLE F'.$kli_vxcf.'_mzdneprav'.$kli_uzid.' ';
$vytvor = mysql_query("$vsql");

//echo $dsqlt;
//exit;


//koniec dalej len ak su pohyby nepravidelne v vy
                 }

?>