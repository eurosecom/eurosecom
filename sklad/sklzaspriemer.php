<?php
//echo "idem";

$kli_vxcfsklx=1*$kli_vxcfskl;
if( $kli_vxcfsklx == 0 ) { $kli_vxcfskl=$kli_vxcf; }

$sql = "SELECT * FROM F$kli_vxcfskl"."_sklzaspriemer";
$vysledok = mysql_query("$sql");
if (!$vysledok)
     {
//echo "robim sklzaspriemer";

$sqlt = <<<sklzas
(
   prx         INT,
   skl         INT,
   cis         DECIMAL(15,0),
   cen         DECIMAL(10,4),
   zas         DECIMAL(10,3),
   hop         DECIMAL(10,2)
);
sklzas;

$sql = 'CREATE TABLE F'.$kli_vxcfskl.'_sklzaspriemer'.$sqlt;
$vysledek = mysql_query("$sql");

$dsqlt = "DELETE FROM F$kli_vxcfskl"."_sklzaspriemer ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcfskl"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,mno,(cen*mno) ".
" FROM F$kli_vxcfskl"."_sklpoc ".
" WHERE cis > 0 ORDER BY skl,cis,cen DESC";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcfskl"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,mno,(cen*mno) ".
" FROM F$kli_vxcfskl"."_sklpri ".
" WHERE cis > 0 ORDER BY skl,cis,cen DESC";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcfskl"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,-mno,-(cen*mno) ".
" FROM F$kli_vxcfskl"."_sklvyd ".
" WHERE cis > 0 AND cen != 0 ORDER BY skl,cis,cen DESC";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcfskl"."_sklzaspriemer ".
" SELECT 0,skl,cis,cen,-mno,-(cen*mno) ".
" FROM F$kli_vxcfskl"."_sklfak ".
" WHERE cis > 0 AND cen != 0 ORDER BY skl,cis,cen DESC";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcfskl"."_sklzaspriemer ".
" SELECT 1,skl,cis,MAX(cen),SUM(zas),SUM(hop) ".
" FROM F$kli_vxcfskl"."_sklzaspriemer ".
" WHERE cis >= 0 GROUP by skl,cis";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcfskl"."_sklzaspriemer WHERE prx = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcfskl"."_sklzaspriemer SET cen=hop/zas WHERE zas > 0 AND hop > 0";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcfskl"."_sklzaspriemer SET cen=hop/zas WHERE zas < 0 AND hop < 0";
$dsql = mysql_query("$dsqlt");

$sqlttxc = "SELECT * FROM F$kli_vxcfskl"."_sklfak WHERE cen = 0  ";
$tovxc = mysql_query("$sqlttxc");
$tvpolxc = mysql_num_rows($tovxc);
if( $tvpolxc > 0 )
  {

$dsqlt = "DROP TABLE F$kli_vxcfskl"."_sklfakx".$kli_uzid." ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "CREATE TABLE F$kli_vxcfskl"."_sklfakx".$kli_uzid." SELECT * FROM F$kli_vxcfskl"."_sklfak WHERE cen = 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcfskl"."_sklzaspriemer,F$kli_vxcfskl"."_sklfakx$kli_uzid ".
" SET zas=zas-mno WHERE F$kli_vxcfskl"."_sklzaspriemer.skl=F$kli_vxcfskl"."_sklfakx$kli_uzid.skl AND ".
" F$kli_vxcfskl"."_sklzaspriemer.cis=F$kli_vxcfskl"."_sklfakx$kli_uzid.cis ";
$dsql = mysql_query("$dsqlt");

//echo $dsqlt."<br />";

  }

     }
?>
