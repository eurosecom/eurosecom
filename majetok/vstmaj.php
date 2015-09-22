<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
// cislo operacie
$copern = strip_tags($_REQUEST['copern']);
$sys = 'HIM';
$urov = 1100;
if( $copern == 10 ) $urov = 1000;

$cslm=500101;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//reinicializuj majetok
if( $copern == 1111 )
{
$upravttt = "DROP TABLE F$kli_vxcf"."_vtvmaj "; 
$upravene = mysql_query("$upravttt");
$upravttt = "DROP TABLE F$kli_vxcf"."_vtvall "; 
$upravene = mysql_query("$upravttt");

$sql = "SELECT * FROM F$kli_vxcf"."_majdrm ";
$vysledok = mysql_query($sql);
$cpol=0;
if( $vysledok ) { $cpol = mysql_num_rows($vysledok); }
if( $cpol == 0 ) 
    {
$dsqlt = "DROP TABLE F$kli_vxcf"."_majdrm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_majdimdrm";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_majdrunak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_majdruvyr";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DROP TABLE F$kli_vxcf"."_majsodp";
$dsql = mysql_query("$dsqlt");
    }


$copern=1;
}
//koniec reinicializuj majetok

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvmaj";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmaj = include("../majetok/vtvmaj.php");
endif;

$citfir = include("../cis/citaj_fir.php");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";


// druh pohybu 
$drupoh = strip_tags($_REQUEST['drupoh']);

if( $drupoh == 1 )
{
$tabl = "majmaj";
$cisdok = "majmaj";
$adrdok = "majetok";
}
if( $drupoh == 2 )
{
$tabl = "majdim";
$cisdok = "majdim";
$adrdok = "dmajetok";
}
if( $drupoh == 11 )
{
$tabl = "majpoh";
$cisdok = "majmaj";
$adrdok = "majetok";
}
if( $drupoh == 12 )
{
$tabl = "majpohdim";
$cisdok = "majdim";
$adrdok = "dmajetok";
}


$uloz="NO";
$zmaz="NO";
$uprav="NO";

//uprav sadzby 2015
$sql = "SELECT prx6 FROM F$kli_vxcf"."_majodpskup2015new ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   prx6        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;


if( $kli_vrok >= 2015 )
  {
echo "MenÌm dobu odpisovania odpisovej skupiny 5 na 40 rokov.";

$sql = "UPDATE F".$kli_vxcf."_majsodp SET rdoba5=40, zkoep5=40, zkoed5=41, zzvys5=40, zkoep5_dan=40, rdoba5_dan=40, zkoed5_dan=41, zzvys5_dan=40 WHERE rdoba5 = 20  ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_majodpskup2015new ".$sqlt;
$vysledek = mysql_query("$sql");
  }
}
//koniec uprav sadzby 2015

//uprav sadzby 2015
$sql = "SELECT prx6 FROM F$kli_vxcf"."_majodpskup2015new1 ";
$vysledok = mysql_query($sql);
if (!$vysledok)
{

$sqlt = <<<banvyp
(
   cpld        int not null auto_increment,
   dok         DECIMAL(10,0) DEFAULT 0,
   prx6        DECIMAL(4,0) DEFAULT 0,
   PRIMARY KEY(cpld)
);
banvyp;

$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD zzvys7_dan DECIMAL(10,2) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD zkoep7_dan DECIMAL(10,2) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD zkoed7_dan DECIMAL(10,2) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F".$kli_vxcf."_majsodp ADD rdoba7_dan DECIMAL(10,0) DEFAULT 0 AFTER zzvys6_dan  ";
$vysledek = mysql_query("$sql");

if( $kli_vrok >= 2015 )
  {
echo "NovÈ odpisovÈ skupiny pre rok 2015.";

$standsku=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_majsodp WHERE rdoba1 = 4 AND rdoba2 = 6 AND rdoba3 = 12 AND rdoba4 = 20 ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $standsku=1;
  }
if( $kli_vrok == 2015 AND $standsku == 1 )
  {
$sql = "UPDATE F".$kli_vxcf."_majmaj SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majpoh SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majpoh SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_1_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_1_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_2_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_2_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_3_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_3_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_4_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_4_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_5_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_5_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_6_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_6_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_7_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_7_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_8_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_8_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_9_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_9_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_10_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_10_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_11_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_11_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_12_".$kli_vrok." SET sku=sku+1 WHERE sku > 2 "; $vysledek = mysql_query("$sql");
$sql = "UPDATE F".$kli_vxcf."_majmaj_12_".$kli_vrok." SET sku_dan=sku_dan+1 WHERE sku_dan > 2 "; $vysledek = mysql_query("$sql");
  }

$sql = "UPDATE F".$kli_vxcf."_majsodp SET ".
" rdoba3=8,  zkoep3=8,  zkoed3=9,  zzvys3=8,  zkoep3_dan=8,  rdoba3_dan=8,  zkoed3_dan=9,  zzvys3_dan=8,  ".
" rdoba4=12, zkoep4=12, zkoed4=13, zzvys4=12, zkoep4_dan=12, rdoba4_dan=12, zkoed4_dan=13, zzvys4_dan=12, ".
" rdoba5=20, zkoep5=20, zkoed5=21, zzvys5=20, zkoep5_dan=20, rdoba5_dan=20, zkoed5_dan=21, zzvys5_dan=20, ".
" rdoba6=40, zkoep6=40, zkoed6=41, zzvys6=40, zkoep6_dan=40, rdoba6_dan=40, zkoed6_dan=41, zzvys6_dan=40, ".
" rdoba7=1,  zkoep7=1,  zkoed7=1,  zzvys7=1,  zkoep7_dan=1,  rdoba7_dan=1,  zkoed7_dan=1,  zzvys7_dan=1   ".
" WHERE rdoba1 = 4 AND rdoba2 = 6 AND rdoba3 = 12 AND rdoba4 = 20 ";
$vysledek = mysql_query("$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_majodpskup2015new1 ".$sqlt;
$vysledek = mysql_query("$sql");
  }
}
//koniec uprav sadzby 2015



//oznacenie polozky
    if ( $copern == 3001 )
    {
$h_inv = 1*$_REQUEST['h_inv'];
$h_hx3 = 1*$_REQUEST['h_hx3'];

$hx3=1;
if( $h_hx3 == 1 ) { $hx3=0; }

$upravttt = "UPDATE F$kli_vxcf"."_$tabl SET hx3=$hx3 WHERE inv='$h_inv' ";

if( $h_inv == 0 ) { $upravttt = "UPDATE F$kli_vxcf"."_$tabl SET hx3=0 WHERE inv >= 0 "; }
$upravene = mysql_query("$upravttt");

$copern=1;
    }
//koniec oznacenie polozky


//vymazanie vsetkych poloziek
    if ( $copern == 167 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r z·znamov dlhodobÈho majetku ?") )
         { window.close()  }
else
         { location.href='vstmaj.php?copern=168&page=1&drupoh=1'  }
</script>
<?php
    }
    if ( $copern == 168 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_majmaj';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_majmaj!"." vynulovan· <br />";
    }
//koniec  vymazania databazy majmaj


//import z ../import/FIR$kli_vxcf/MAJ_UCT.CSV a MAJ_DAN.CSV
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/maj.csv ?") )
         { window.close()  }
else
         { location.href='vstmaj.php?copern=156&page=1&drupoh=1'  }
</script>
<?php
    }
$ramex=0;

    if ( $copern == 156 AND $ramex == 1 ) include("import_ramex.php");

    if ( $copern == 156 AND $ramex == 0 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/MAJ_UCT.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MAJ_UCT.CSV existuje<br />";

//POZOR NESMIE BYT V NAZVE ;


//cdp b 0;xz ; b;str b 0;xz ; b;inv b 10;xz ; b;tri b 0;xz ; b;obo b 0;xz ; b;dob b 0;xz ; b;drm b 0;xz ; b;
//sku b 0;xz ; b;spo b 0;xz ; b;vyc b 0;xz ; b;pop b 0;xz ; b;naz b 0;xz ; b;zak b 0;xz ; b;rzv b 0;xz ; b;
//zar b 0;xz ; b;cen b 0;xz ; b;ops b 0;xz ; b;mes b 0;xz ; b;ros b 0;xz ; b;zos b 0;xz ; b;zss b 0;xz ; b;
//rop b 0;xz ; b;dvy b 0;xz ; b;svy b 0;xz ; b;rok b 0;xz ; b;dat b 0;xz ; b;jkp b 0;xz ; b;ckp b 0;xz ; b;
//oc b 0;xz ; b;kanc b 0;xz ; b;pxz b 0;xz ; b;rvr b 0;xz ; b;xt koniec@r$

$subor = fopen("../import/FIR$kli_vxcf/MAJ_UCT.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_cdp = $pole[0];
  $x_str = $pole[1];
  $x_inv = $pole[2];
  $x_tri = $pole[3];
  $x_obo = $pole[4];
  $x_dob = $pole[5];
  $x_drm = $pole[6];
  $x_sku = $pole[7];
  $x_spo = $pole[8];
  $x_vyc = $pole[9];
  $x_pop = $pole[10];
  $x_naz = AddSlashes($pole[11]);
  $x_zak = $pole[12];
  $x_rzv = $pole[13];
  $x_zar = $pole[14];
  $x_cen = $pole[15];
  $x_ops = $pole[16];
  $x_mes = $pole[17];
  $x_ros = $pole[18];
  $x_zos = $pole[19];
  $x_zss = $pole[20];
  $x_rop = $pole[21];
  $x_dvy = $pole[22];
  $x_svy = $pole[23];
  $x_rok = $pole[24];
  $x_dat = $pole[25];
  $x_jkp = $pole[26];
  $x_ckp = $pole[27];
  $x_oc = $pole[28];
  $x_kanc = $pole[29];
  $x_pxz = $pole[30];
  $x_rvr = $pole[31];
  $x_perc = $pole[32];
  $x_cnm = $pole[33];
  $x_msm = $pole[34];
  $x_rom = $pole[35];
  $x_rpm = $pole[36];


  $dob_sql = SqlDatum($x_dob);
  $zar_sql = SqlDatum($x_zar);

$c_inv=1*$x_inv;

 
$sqult = "INSERT INTO F$kli_vxcf"."_majmaj ( ume,druh,str,inv,tri,obo,dob,drm,sku,spo,vyc,pop,naz,zak,rzv,zar,cen,ops,mes,ros,zos,zss,rop,".
"jkp,ckp,oc,kanc,poz,rvr,perc,id,mno,drh1,drh2,dox,meso,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,".
"spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5)".
" VALUES ( '12.2009', 1, '$x_str', '$x_inv', '$x_tri', '$x_obo', '$dob_sql', '$x_drm', '$x_sku', '$x_spo', '$x_vyc', '$x_pop', '$x_naz',".
" '$x_zak', '$x_rzv', '$zar_sql', '$x_cen', '$x_ops', '$x_mes', '$x_ros', '$x_zos', '$x_zss', '$x_rop', '$x_jkp', '$x_ckp', '$x_oc', '$x_kanc',". 
" '$x_poz', '$x_rvr', '$x_perc',".
"'$kli_uzid', 1, 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,'1.12.2009','','',0,0,0,'$x_cnm',0,0,0,'$x_msm','$x_rom','$x_rpm' );";

if( $c_inv > 0 ) $ulozene = mysql_query("$sqult"); 
}
echo "Tabulka F$kli_vxcf"."_majmaj!"." naimportovan· <br />";
fclose ($subor);
//naimportovane uctovne

//import kancelarii

if( file_exists("../import/FIR$kli_vxcf/MAJ_KANC.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MAJ_KANC.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MAJ_KANC.CSV", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_kanc = $pole[0];
  $x_popk = $pole[1];
  $x_kon = $pole[2];

 
$c_kanc=1*$x_kanc;
if( $x_popk == '' ) $x_popk="Kancelaria ".$x_kanc;

if( $c_kanc > 0 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_kancelarie ( kanc,nkan,ukan,pkan )".
" VALUES ( '$x_kanc', '$x_popk', 1, 1 ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_kancelarie!"." naimportovan· <br />";

fclose ($subor);

//naimportovane kancelarie


//import danovych do majpohdim
if( file_exists("../import/FIR$kli_vxcf/MAJ_DAN.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MAJ_DAN.CSV existuje<br />";

$sqult = "TRUNCATE F$kli_vxcf"."_majpohdim"; 
$ulozene = mysql_query("$sqult"); 

//POZOR NESMIE BYT V NAZVE ;

$subor = fopen("../import/FIR$kli_vxcf/MAJ_DAN.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_cdp = $pole[0];
  $x_str = $pole[1];
  $x_inv = $pole[2];
  $x_tri = $pole[3];
  $x_obo = $pole[4];
  $x_dob = $pole[5];
  $x_drm = $pole[6];
  $x_sku = $pole[7];
  $x_spo = $pole[8];
  $x_vyc = $pole[9];
  $x_pop = $pole[10];
  $x_naz = AddSlashes($pole[11]);
  $x_zak = $pole[12];
  $x_rzv = $pole[13];
  $x_zar = $pole[14];
  $x_cen = $pole[15];
  $x_ops = $pole[16];
  $x_mes = $pole[17];
  $x_ros = $pole[18];
  $x_zos = $pole[19];
  $x_zss = $pole[20];
  $x_rop = $pole[21];
  $x_dvy = $pole[22];
  $x_svy = $pole[23];
  $x_rok = $pole[24];
  $x_dat = $pole[25];
  $x_jkp = $pole[26];
  $x_ckp = $pole[27];
  $x_oc = $pole[28];
  $x_kanc = $pole[29];
  $x_pxz = $pole[30];
  $x_rvr = $pole[31];
  $x_perc = $pole[32];
  $x_cnm = $pole[33];
  $x_msm = $pole[34];
  $x_rom = $pole[35];
  $x_rpm = $pole[36];


  $dob_sql = SqlDatum($x_dob);
  $zar_sql = SqlDatum($x_zar);
 
$sqult = "INSERT INTO F$kli_vxcf"."_majpohdim ( ume,druh,str,inv,tri,obo,dob,drm,sku,spo,vyc,pop,naz,zak,rzv,zar,cen,ops,mes,ros,zos,zss,rop,".
"jkp,ckp,oc,kanc,poz,rvr,perc,id,mno,drh1,drh2,dox,meso,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,".
"spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5)".
" VALUES ( '12.2009', 1, '$x_str', '$x_inv', '$x_tri', '$x_obo', '$dob_sql', '$x_drm', '$x_sku', '$x_spo', '$x_vyc', '$x_pop', '$x_naz',".
" '$x_zak', '$x_rzv', '$zar_sql', '$x_cen', '$x_ops', '$x_mes', '$x_ros', '$x_zos', '$x_zss', '$x_rop', '$x_jkp', '$x_ckp', '$x_oc', '$x_kanc',". 
" '$x_poz', '$x_rvr', '$x_perc',".
"'$kli_uzid', 1, 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,'1.12.2009','','',0,0,0,'$x_cnm',0,0,0,'$x_msm','$x_rom','$x_rpm' );";

$ulozene = mysql_query("$sqult"); 
}
echo "Tabulka F$kli_vxcf"."_majdan!"." naimportovan· <br />";
fclose ($subor);

//naimportovane danove v majpohdim
//nastav do majmaj cen,ops,zos,zss,mes,ros,spo,sku,perc do cen_dan...

$sqtoz = "UPDATE F$kli_vxcf"."_majmaj,F$kli_vxcf"."_majpohdim".
" SET F$kli_vxcf"."_majmaj.sku_dan=F$kli_vxcf"."_majpohdim.sku,F$kli_vxcf"."_majmaj.spo_dan=F$kli_vxcf"."_majpohdim.spo,".
" F$kli_vxcf"."_majmaj.perc_dan=F$kli_vxcf"."_majpohdim.perc,F$kli_vxcf"."_majmaj.cen_dan=F$kli_vxcf"."_majpohdim.cen,".
" F$kli_vxcf"."_majmaj.ops_dan=F$kli_vxcf"."_majpohdim.ops,F$kli_vxcf"."_majmaj.zos_dan=F$kli_vxcf"."_majpohdim.zos,".
" F$kli_vxcf"."_majmaj.zss_dan=F$kli_vxcf"."_majpohdim.zos".
" WHERE F$kli_vxcf"."_majmaj.inv = F$kli_vxcf"."_majpohdim.inv ";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqult = "TRUNCATE F$kli_vxcf"."_majpohdim"; 
$ulozene = mysql_query("$sqult"); 


//ak je percento > 100 potom su to Sk
$sqtoz = "UPDATE F$kli_vxcf"."_majmaj".
" SET meso=perc, perc=0".
" WHERE ( inv > 0 AND perc > 100 )";
$oznac = mysql_query("$sqtoz");
$sqtoz = "UPDATE F$kli_vxcf"."_majmaj".
" SET roco_dan=12*perc_dan, perc_dan=0".
" WHERE ( inv > 0 AND perc_dan > 100 )";
$oznac = mysql_query("$sqtoz");

    }
////////koniec naimportovania copern=156


//vymazanie vsetkych poloziek
    if ( $copern == 267 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r z·znamov drobnÈho majetku ?") )
         { window.close()  }
else
         { location.href='vstmaj.php?copern=268&page=1&drupoh=2'  }
</script>
<?php
    }
    if ( $copern == 268 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_majdim';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_majdim!"." vynulovan· <br />";
    }
//koniec nahratia a vymazania databazy majmaj


//import z ../import/FIR$kli_vxcf/DIM_UCT.CSV
    if ( $copern == 255 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/dim.csv ?") )
         { window.close()  }
else
         { location.href='vstmaj.php?copern=256&page=1&drupoh=2'  }
</script>
<?php
    }
    if ( $copern == 256 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/DIM_UCT.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/DIM_UCT.CSV existuje<br />";


//cdp b 0;xz ; b;str b 0;xz ; b;inv b 10;xz ; b;tri b 0;xz ; b;obo b 0;xz ; b;dob b 0;xz ; b;drm b 0;xz ; b;
//sku b 0;xz ; b;spo b 0;xz ; b;vyc b 0;xz ; b;pop b 0;xz ; b;naz b 0;xz ; b;zak b 0;xz ; b;rzv b 0;xz ; b;
//zar b 0;xz ; b;cen b 0;xz ; b;ops b 0;xz ; b;mes b 0;xz ; b;ros b 0;xz ; b;zos b 0;xz ; b;zss b 0;xz ; b;
//rop b 0;xz ; b;dvy b 0;xz ; b;svy b 0;xz ; b;rok b 0;xz ; b;dat b 0;xz ; b;jkp b 0;xz ; b;ckp b 0;xz ; b;
//oc b 0;xz ; b;kanc b 0;xz ; b;pxz b 0;xz ; b;rvr b 0;xz ; b;xt koniec@r$

$cvety = 1;
$subor = fopen("../import/FIR$kli_vxcf/DIM_UCT.CSV", "r");
while (! feof($subor) )
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_cdp = $pole[0];
  $x_str = $pole[1];
  $x_inv = $pole[2];
  $x_tri = $pole[3];
  $x_obo = $pole[4];
  $x_dob = $pole[5];
  $x_drm = $pole[6];
  $x_sku = $pole[7];
  $x_spo = $pole[8];
  $x_vyc = $pole[9];
  $x_pop = $pole[10];
  $x_naz = AddSlashes($pole[11]);
  $x_zak = $pole[12];
  $x_rzv = $pole[13];
  $x_zar = $pole[14];
  $x_cen = $pole[15];
  $x_ops = $pole[16];
  $x_mes = $pole[17];
  $x_ros = $pole[18];
  $x_zos = $pole[19];
  $x_zss = $pole[20];
  $x_rop = $pole[21];
  $x_dvy = $pole[22];
  $x_svy = $pole[23];
  $x_rok = $pole[24];
  $x_dat = $pole[25];
  $x_jkp = $pole[26];
  $x_ckp = $pole[27];
  $x_oc = $pole[28];
  $x_kanc = $pole[29];
  $x_pxz = $pole[30];
  $x_rvr = $pole[31];
  $x_perc = $pole[32];

  $dob_sql = SqlDatum($x_dob);
  $zar_sql = SqlDatum($x_zar);

$x_umex="12.2008";
$x_datx="2008-31-12";
if( $x_obo == 7 ) { $x_umex="12.2007"; $x_datx="2007-31-12"; }
if( $x_obo == 6 ) { $x_umex="12.2006"; $x_datx="2006-31-12"; }

$c_inv=1*$x_inv;

if( $cvety > 0 AND $cvety < 5000 )
{ 
$sqult = "INSERT INTO F$kli_vxcf"."_majdim ( ume,druh,str,inv,tri,obo,dob,drm,sku,spo,vyc,pop,naz,zak,rzv,zar,cen,ops,mes,ros,zos,zss,rop,".
"jkp,ckp,oc,kanc,poz,rvr,perc,id,mno,drh1,drh2,dox,meso,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,".
"spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5)".
" VALUES ( '$x_umex', 2, '$x_str', '$x_inv', '$x_tri', '$x_obo', '$dob_sql', '$x_drm', '$x_sku', '$x_spo', '$x_vyc', '$x_pop', '$x_naz',".
" '$x_zak', '$x_rzv', '$dob_sql', '$x_cen', '0', '$x_mes', '$x_ros', '$x_zos', '$x_zss', '$x_rop', '$x_jkp', '$x_ckp', '$x_oc', '$x_kanc',". 
" '$x_poz', '$x_rvr', '$x_perc',".
"'$kli_uzid', '$x_ops', 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,'$x_datx','','',0,0,0,0,0,0,0,0,0,0 );";

if( $c_inv > 0 ) $ulozene = mysql_query("$sqult"); 
}

$cvety = $cvety+1;

}
echo "Tabulka F$kli_vxcf"."_majdim!"." naimportovan· <br />";
fclose ($subor);


    }
//koniec naimportovania


//vymazanie vsetkych poloziek
    if ( $copern == 367 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r z·znamov pohybov dlhodobÈho majetku ?") )
         { window.close()  }
else
         { location.href='vstmaj.php?copern=368&page=1&drupoh=11'  }
</script>
<?php
    }
    if ( $copern == 368 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_majpoh';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_majpoh!"." vynulovan· <br />";
    }
//koniec nahratia a vymazania databazy majpoh


//import z ../import/FIR$kli_vxcf/DIM_UCT.CSV
    if ( $copern == 355 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/maj_poh.csv ?") )
         { window.close()  }
else
         { location.href='vstmaj.php?copern=356&page=1&drupoh=11'  }
</script>
<?php
    }
    if ( $copern == 356 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/MAJ_POH.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MAJ_POH.CSV existuje<br />";


//cdp b 0;xz ; b;str b 0;xz ; b;inv b 10;xz ; b;tri b 0;xz ; b;obo b 0;xz ; b;dob b 0;xz ; b;drm b 0;xz ; b;
//sku b 0;xz ; b;spo b 0;xz ; b;vyc b 0;xz ; b;pop b 0;xz ; b;naz b 0;xz ; b;zak b 0;xz ; b;rzv b 0;xz ; b;
//zar b 0;xz ; b;cen b 0;xz ; b;ops b 0;xz ; b;mes b 0;xz ; b;ros b 0;xz ; b;zos b 0;xz ; b;zss b 0;xz ; b;
//rop b 0;xz ; b;dvy b 0;xz ; b;svy b 0;xz ; b;rok b 0;xz ; b;dat b 0;xz ; b;jkp b 0;xz ; b;ckp b 0;xz ; b;
//oc b 0;xz ; b;kanc b 0;xz ; b;pxz b 0;xz ; b;rvr b 0;xz ; b;xt koniec@r$

$cvety = 1;
$subor = fopen("../import/FIR$kli_vxcf/MAJ_POH.CSV", "r");
while (! feof($subor) )
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_cdp = $pole[0];
  $x_str = $pole[1];
  $x_inv = $pole[2];
  $x_tri = $pole[3];
  $x_obo = $pole[4];
  $x_dob = $pole[5];
  $x_drm = $pole[6];
  $x_sku = $pole[7];
  $x_spo = $pole[8];
  $x_vyc = $pole[9];
  $x_pop = $pole[10];
  $x_naz = AddSlashes($pole[11]);
  $x_zak = $pole[12];
  $x_rzv = $pole[13];
  $x_zar = $pole[14];
  $x_cen = $pole[15];
  $x_ops = $pole[16];
  $x_mes = $pole[17];
  $x_ros = $pole[18];
  $x_zos = $pole[19];
  $x_zss = $pole[20];
  $x_rop = $pole[21];
  $x_dvy = $pole[22];
  $x_svy = $pole[23];
  $x_rok = $pole[24];
  $x_dat = $pole[25];
  $x_jkp = $pole[26];
  $x_ckp = $pole[27];
  $x_oc = $pole[28];
  $x_kanc = $pole[29];
  $x_pxz = $pole[30];
  $x_rvr = $pole[31];
  $x_perc = $pole[32];

  $dob_sql = SqlDatum($x_dob);
  $zar_sql = SqlDatum($x_zar);
  $dvy_sql = SqlDatum($x_dvy);
  $dat_sql = SqlDatum($x_dat);

$pole = explode(".", $x_dat);
$kli_dden=$pole[0];
$kli_dmes=$pole[1];
$kli_drok=$pole[2];
$x_ume=$kli_dmes.".".$kli_drok;

if( $cvety > 0 AND $cvety < 1000 )
{ 
$sqult = "INSERT INTO F$kli_vxcf"."_majpoh ( ume,druh,str,inv,tri,obo,dob,drm,sku,spo,vyc,pop,naz,zak,rzv,zar,cen,ops,mes,ros,zos,zss,rop,".
"jkp,ckp,oc,kanc,poz,rvr,perc,id,mno,drh1,drh2,dox,meso,xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,".
"spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,poh,dph,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5)".
" VALUES ( '$x_ume', 1, '$x_str', '$x_inv', '$x_tri', '$x_obo', '$dob_sql', '$x_drm', '$x_sku', '$x_spo', '$x_vyc', '$x_pop', '$x_naz',".
" '$x_zak', '$x_rzv', '$dob_sql', '$x_cen', '0', '$x_mes', '$x_ros', '$x_zos', '$x_zss', '$x_rop', '$x_jkp', '$x_ckp', '$x_oc', '$x_kanc',". 
" '$x_poz', '$x_rvr', '$x_perc',".
"'$kli_uzid', '$x_ops', 0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'$x_cdp','$x_svy','$dvy_sql','$dvy_sql','$dat_sql',0,0,0,0,0,0,0,0,0,0 );";

$ulozene = mysql_query("$sqult"); 
}

$cvety = $cvety+1;

}
echo "Tabulka F$kli_vxcf"."_majpoh!"." naimportovan· <br />";
fclose ($subor);


    }
//koniec naimportovania


// 16=vymazanie polozky a pohybu potvrdene v vstm_u.php
if ( $copern == 16 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_inv = strip_tags($_REQUEST['cislo_inv']);
$cislo_poh = strip_tags($_REQUEST['cislo_poh']);
$cislo_inr = strip_tags($_REQUEST['cislo_inr']);

//echo "drp".$drupoh;

if( $drupoh == 1 )
    {
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majmaj WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
    }

if( $drupoh == 11 )
    {
//zmazat zaradenie
if( $cislo_poh == 2 )
{
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majmaj WHERE inv='$cislo_inv' ");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majpoh WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
}
//zmazat vyradenie
if( $cislo_poh == 3 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_majmaj".
" SELECT 0,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,1,1,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majpoh".
" WHERE cpl='$cislo_cpl' AND inv='$cislo_inv' AND poh = 3".
"";
$dsql = mysql_query("$dsqlt");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majpoh WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
}
//zmazat zvysenie
if( $cislo_poh == 4 )
{
$uprtt = "UPDATE F$kli_vxcf"."_majmaj SET cen=cen-hd1, zss=zss-hd1, zos=cen-ops, rzv=hx1,".
" cen_dan=cen_dan-hd1, zss_dan=zss_dan-hd1, zos_dan=cen_dan-ops_dan, hd1=0, hx1=0, hx2=0 WHERE inv='$cislo_inv' ";
$upravene = mysql_query("$uprtt"); 

$dsql = mysql_query("$dsqlt");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majpoh WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
}
//zmazat rozdelenie
if( $cislo_poh == 5 )
{
$uprtt = "UPDATE F$kli_vxcf"."_majmaj SET cen=cen+hd1, ops=ops+hd2, zos=cen-ops, zss=zos+ros,".
" cen_dan=cen_dan+hd1, ops_dan=ops_dan+hd2, zos_dan=cen_dan-ops_dan, zss_dan=zos_dan+ros_dan,".
" hd1=0, hd2=0, datm=now() WHERE inv='$cislo_inv' ";
$upravene = mysql_query("$uprtt"); 

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majmaj WHERE inv='$cislo_inr' ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majpoh WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
}
    }

if( $drupoh == 2 )
    {
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majdim WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
    }

if( $drupoh == 12 )
    {
//zmazat zaradenie
if( $cislo_poh == 2 )
{
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majdim WHERE inv='$cislo_inv' ");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majpohdim WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
}
//zmazat vyradenie
if( $cislo_poh == 3 )
{
$h_mnvx = strip_tags($_REQUEST['h_mnvx']);
$upravene = mysql_query("UPDATE F$kli_vxcf"."_majdim SET mno=mno+'$h_mnvx' WHERE inv='$cislo_inv' ");

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdim".
" SELECT 0,ume,druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,1,1,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majpohdim".
" WHERE cpl='$cislo_cpl' AND inv='$cislo_inv' AND poh = 3".
"";
$dsql = mysql_query("$dsqlt");
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majpohdim WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");
}
    }


$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;

     }
//koniec vymazania polozky


// 116=vyradenie polozky potvrdene v vstm_u.php
if ( $copern == 116 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_inv = strip_tags($_REQUEST['cislo_inv']);
$h_phv = strip_tags($_REQUEST['h_phv']);
$h_dtv = strip_tags($_REQUEST['h_dtv']);
$h_dvv = strip_tags($_REQUEST['h_dvv']);
$h_mnv = strip_tags($_REQUEST['h_mnv']);
$h_dtv = SqlDatum($h_dtv);
$pole = explode("-", $h_dtv);
$h_umv = $pole[1].".".$pole[0];

//echo "drp".$drupoh;

if( $drupoh == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_majpoh".
" SELECT 0,'$h_umv',druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,'3','$h_phv','$h_dtv','$h_dvv',dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majmaj".
" WHERE cpl = $cislo_cpl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majmaj WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");

}


if( $drupoh == 2 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_majpohdim".
" SELECT 0,'$h_umv',druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,'$h_mnv',dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,'3','$h_phv','$h_dtv','$h_dvv',dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majdim".
" WHERE cpl = $cislo_cpl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$upravene = mysql_query("UPDATE F$kli_vxcf"."_majdim SET mno=mno-'$h_mnv' WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ");

$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_majdim WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' AND mno <= 0 ) ");
}


$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYRADEN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;

     }
//koniec vyradenia


// 14=zvysenie hodnoty potvrdene v vstm_u.php hx2=1 v majpoh znamena ze uz bol uplatneny pohyb
if ( $copern == 14 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_inv = strip_tags($_REQUEST['cislo_inv']);
$h_phz = strip_tags($_REQUEST['h_phz']);
$h_dtz = strip_tags($_REQUEST['h_dtz']);
$h_dvz = strip_tags($_REQUEST['h_dvz']);
$h_dtz = SqlDatum($h_dtz);
$pole = explode("-", $h_dtz);
$h_umz = $pole[1].".".$pole[0];
$h_rkz = $pole[0];

//echo "drp".$drupoh;

if( $drupoh == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_majpoh".
" SELECT 0,'$h_umz',druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,'$h_rkz',str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,'4','4','$h_dtz','$h_dvz',dvt,'$h_phz',hd2,hd3,hd4,hd5,hx1,1,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majmaj".
" WHERE cpl = $cislo_cpl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$uprtt = "UPDATE F$kli_vxcf"."_majmaj SET cen=cen+('$h_phz'), zss=zss+('$h_phz'), zos=cen-ops, dap='$h_dtz', hx1=rzv, rzv='$h_rkz',".
" cen_dan=cen_dan+('$h_phz'), zss_dan=zss_dan+('$h_phz'), zos_dan=cen_dan-ops_dan, hd1='$h_phz', datm=now() WHERE ( cpl='$cislo_cpl' AND inv='$cislo_inv' ) ";
$upravene = mysql_query("$uprtt"); 

}


$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( " HODNOTA NEBOLA ZV›äEN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;

     }
//koniec zvysenia

// 15=rozdelenie hodnoty potvrdene v vstm_u.php hx2=1 v majpoh znamena ze uz bol uplatneny pohyb
if ( $copern == 15 )
     {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$cislo_inv = strip_tags($_REQUEST['cislo_inv']);
$h_cer = strip_tags($_REQUEST['h_cer']);
$h_opr = strip_tags($_REQUEST['h_opr']);
$h_inr = strip_tags($_REQUEST['h_inr']);
$h_dvr = strip_tags($_REQUEST['h_dvr']);
$h_dtr = strip_tags($_REQUEST['h_dtr']);
$h_dtr = SqlDatum($h_dtr);
$pole = explode("-", $h_dtr);
$h_umr = $pole[1].".".$pole[0];
$h_rkr = $pole[0];
$h_zsr = $h_cer - $h_opr;


//echo "drp".$drupoh;

if( $drupoh == 1 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_majpoh".
" SELECT 0,'$h_umr',druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,'$h_rkz',str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,'5','5','$h_dtr','$h_dvr',dvt,'$h_cer','$h_opr',hd3,hd4,hd5,'$h_inr',1,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majmaj".
" WHERE cpl = $cislo_cpl".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//urob dve polozky
$uprtt = "UPDATE F$kli_vxcf"."_majmaj SET cen=cen-('$h_cer'), ops=ops-('$h_opr'), zos=cen-ops, zss=zos+ros,".
" cen_dan=cen_dan-('$h_cer'), ops_dan=ops_dan-('$h_opr'), zos_dan=cen_dan-ops_dan, zss_dan=zos_dan+ros_dan,".
" dap='$h_dtr', hd1='$h_cer', hd2='$h_opr', datm=now() WHERE inv='$cislo_inv' ";
$upravene = mysql_query("$uprtt"); 

$dsqlt = "INSERT INTO F$kli_vxcf"."_majmaj".
" SELECT 0,'$h_umr',druh,drm,'$h_inr',naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,'$h_cer','$h_opr','$h_zsr','$h_zsr',0,0,0,spo_dan,sku_dan,perc_dan,roco_dan,'$h_cer','$h_opr','$h_zsr','$h_zsr',0,0,0,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,1,1,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majpoh".
" WHERE inv='$cislo_inv' AND poh = 5".
"";
$ulozene = mysql_query("$dsqlt");
}


if( $drupoh == 2 )
{

$dsqlt = "INSERT INTO F$kli_vxcf"."_majpohdim".
" SELECT 0,'$h_umr',druh,drm,inv,naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,mno,dob,dox,zar,'$h_rkz',str,zak,oc,kanc,".
"spo,sku,perc,meso,cen,ops,zos,zss,mes,ros,rop,spo_dan,sku_dan,perc_dan,roco_dan,cen_dan,ops_dan,zos_dan,zss_dan,mes_dan,ros_dan,rop_dan,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,'5','5','$h_dtr','$h_dvr',dvt,'$h_cer','$h_opr',hd3,hd4,hd5,'$h_inr',1,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majdim".
" WHERE cpl = $cislo_cpl".
"";
//echo $dsqlt;
//$dsql = mysql_query("$dsqlt");

//urob dve polozky
$uprtt = "UPDATE F$kli_vxcf"."_majdim SET cen=cen, ops=ops, zos=cen-ops, zss=zos+ros,".
" cen_dan=cen_dan, ops_dan=ops_dan, zos_dan=cen_dan-ops_dan, zss_dan=zos_dan+ros_dan,".
" dap='$h_dtr', hd1='$h_cer', hd2='$h_opr', datm=now(), mno=mno-1 WHERE inv='$cislo_inv' ";
//echo $uprtt;
$upravene = mysql_query("$uprtt"); 

$dsqlt = "INSERT INTO F$kli_vxcf"."_majdim".
" SELECT 0,'$h_umr',druh,drm,'$h_inr',naz,pop,poz,vyc,rvr,tri,obo,jkp,ckp,drh1,drh2,1,dob,dox,zar,rzv,str,zak,oc,kanc,".
"spo,sku,perc,meso,'$h_cer','$h_opr','$h_zsr','$h_zsr',0,0,0,spo_dan,sku_dan,perc_dan,roco_dan,'$h_cer','$h_opr','$h_zsr','$h_zsr',0,0,0,".
"xmax,cen_max,ops_max,zos_max,zss_max,mes_max,ros_max,rop_max,5,5,dap,dvp,dvt,hd1,hd2,hd3,hd4,hd5,hx1,hx2,hx3,hx4,hx5,id,now()".
" FROM F$kli_vxcf"."_majdim".
" WHERE inv='$cislo_inv' ".
"";
$ulozene = mysql_query("$dsqlt");
}

$copern=1;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " HODNOTA NEBOLA ROZDELEN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;

     }
//koniec rozdelenia


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<?php
if ( $drupoh == 1 )
  {
?>
<title>Zoznam dlhodobÈho majetku</title>
<?php
}
?>
<?php
if ( $drupoh == 2 )
  {
?>
<title>Zoznam drobnÈho majetku</title>
<?php
}
?>
<?php
if ( $drupoh == 11 )
  {
?>
<title>Pohyby dlhodobÈho majetku</title>
<?php
}
?>
<?php
if ( $drupoh == 12 )
  {
?>
<title>Pohyby drobnÈho majetku</title>
<?php
}
?>

  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

//funkcia na zobrazenie popisu 
    function UkazSkryj (text)
    {
        Okno.innerHTML = text ;
        Okno.style.display="block";
        Okno.style.top=event.clientY;
        Okno.style.left=event.clientX;

    }

// Kontrola cisla celeho v rozsahu x az y  
      function intg(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (Math.floor(b)==b && b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

// Kontrola des.cisla v rozsahu x az y  
      function cele(x1,x,y,Oznam) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       Oznam.style.display="none";
         if (b == "") return true;
         else{
         if (b>=x && b<=y) return true; 
         else {
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         return false;
              } 
             }
      }

<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_inv.focus();
<?php if ( $copern == 10000 ) echo "document.formp2.pokl.disabled = true;"; ?>
    }

<?php
  }
//koniec hladania
?>
<?php
//hladanie
  if ( $copern == 9 )
  {
?>
    function VyberVstup()
    {

    }

    function ObnovUI()
    {
<?php if ( $copern == 10000 ) echo "document.formp2.pokl.disabled = true;"; ?>
    }

<?php
  }
//koniec hladania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 OR $copern == 10 )
  {
?>
//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.forma3.sstrana.disabled = true; }
     else { Oznam.style.display="none"; document.forma3.sstrana.disabled = false; }
    }

    function VyberVstup()
    {
    document.forma3.page.focus();
    document.forma3.page.select();
    }

    function ObnovUI()
    {
<?php if ( $copern == 10000 ) echo "document.formp2.pokl.disabled = true;"; ?>
    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>

    function Vyber( invx, pagex, hx3x )
    {

var h_inv = invx;
var h_page = pagex;
var h_hx3 = hx3x;

window.open('../majetok/vstmaj.php?h_inv=' + h_inv + '&copern=3001&drupoh=<?php echo $drupoh;?>&page=1&h_hx3=' + h_hx3 + '&xxx=1', '_self' );


    }

    function NovaPol( invx )
    {

var h_inv = invx;

window.open('../majetok/vstm_u.php?h_inv=' + h_inv + '&copern=3001&drupoh=<?php echo $drupoh;?>&page=1&xxx=1', '_self' );


    }


    function textHim( invx )
    {

var h_inv = invx;

window.open('../majetok/maj_text.php?h_inv=' + h_inv + '&copern=1&drupoh=<?php echo $drupoh;?>&page=1', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }


    function mespoh()
    {

var akep=document.formhl1.akep.value;

window.open('../majetok/mespoh.php?akep=' + akep + '&copern=10&drupoh=<?php echo $drupoh; ?>&page=1', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

    }

    function rocpoh()
    {

var akep=document.formhl1.akep.value;

window.open('../majetok/mespoh.php?akep=' + akep + '&copern=10&drupoh=21&page=1', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }



  </script>
</HEAD>
<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php 


// aktualna strana
$page = strip_tags($_REQUEST['page']);
// nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
if( $copern == 9 ) $pols = 900;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);

?>

<table class="h2" width="100%" >
<tr>
<?php if( $drupoh == 1 ) echo "<td>EuroSecom  -  Dlhodob˝ majetok"; ?>
<?php if( $drupoh == 2 ) echo "<td>EuroSecom  -  Drobn˝ majetok"; ?>
<?php if( $drupoh == 11 ) echo "<td>EuroSecom  -  Pohyby dlhodob˝ majetok"; ?>
<?php if( $drupoh == 12 ) echo "<td>EuroSecom  -  Pohyby drobn˝ majetok"; ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />
<div id="Okno"></div>

<?php
// toto je cast na zobrazenie tabulky a prechody medzi stranami
// 1=volanie z menu.php
// 2=dalsia strana
// 3=predosla strana
// 4=prejst na stranu
// 5=nova polozka
// 6=mazanie
// 7=hladanie
// 8=uprava
// 9=hladanie
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 7 && $copern != 9 AND $copern != 10 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 7 || $copern == 9 OR $copern == 10 )
  {
//[[[[[

$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_$tabl".
" WHERE inv > 0 ". 
" ORDER BY datm DESC,inv DESC".
"";

//echo $sqltt;

$sql = mysql_query("$sqltt");

  }
// zobraz hladanie vo vsetkych
if ( $copern == 9 )
  {

$hladaj_inv = strip_tags($_REQUEST['hladaj_inv']);
$hladaj_naz = strip_tags($_REQUEST['hladaj_naz']);
$hladaj_str = strip_tags($_REQUEST['hladaj_str']);
$hladaj_oc = strip_tags($_REQUEST['hladaj_oc']);

if ( $hladaj_inv != "" ) {


$sqltx = "SELECT *".
" FROM F$kli_vxcf"."_$tabl".
" WHERE F$kli_vxcf"."_$tabl.inv = '$hladaj_inv'".
" ORDER BY datm DESC,inv DESC".
"";

$sql = mysql_query("$sqltx");

                        }

if ( $hladaj_oc != "" ) { 

$sqltx = "SELECT *".
" FROM F$kli_vxcf"."_$tabl".
" WHERE F$kli_vxcf"."_$tabl.oc = '$hladaj_oc' OR F$kli_vxcf"."_$tabl.kanc = $hladaj_oc".
" ORDER BY datm DESC,inv DESC".
"";

$sql = mysql_query("$sqltx");

}

if ( $hladaj_str != "" ) {


$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_$tabl".
" WHERE F$kli_vxcf"."_$tabl.str = $hladaj_str OR F$kli_vxcf"."_$tabl.zak = $hladaj_str ".
" ORDER BY datm DESC,inv DESC".
"";

$sql = mysql_query("$sqltt");
}

if ( $hladaj_naz != "" ) {

$sqltt = "SELECT * ".
" FROM F$kli_vxcf"."_$tabl".
" WHERE naz LIKE '%$hladaj_naz%' ".
" ORDER BY datm DESC,inv DESC".
"";

$sql = mysql_query("$sqltt");
}

  }

// celkom poloziek
$cpol = mysql_num_rows($sql);
$npol = $cpol + 1;
// pocet stran
$xstr =1*(ceil($cpol / $pols));
if ( $xstr == 0 ) $xstr=1;
?>

<table class="fmenu" width="100%" >

<?php
//nezobraz hladanie pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<FORM name="formhl1" class="hmenu" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=15 height=10 border=0 title="Vyhæad·vanie" >
<?php
  if ( $drupoh == 1 )
  {
?>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" >
<?php
       if ( $drupoh == 1 )
       {
?>

<img src='../obr/tlac.png' onClick="window.open('kartamajetku.php?copern=21&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=È&cislo_inv=È', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"
 width=20 height=15 border=0 title="TlaË vöetk˝ch kariet majetku" >
<?php
       }
?>
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<?php
if ( $kli_uzall > 10000 )
{
?>
<td class="hmenu" ><a href='vstmaj.php?copern=167&page=1&drupoh=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<td class="hmenu" ><a href='vstmaj.php?copern=155&page=1&drupoh=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
}
?>
<?php
  }
?>
<?php
  if ( $drupoh == 2 )
  {
?>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<?php
if ( $kli_uzall > 10000 )
{
?>
<td class="hmenu" ><a href='vstmaj.php?copern=267&page=1&drupoh=2'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<td class="hmenu" ><a href='vstmaj.php?copern=255&page=1&drupoh=2'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
}
?>
<?php
if ( $kli_uzall > 99000 )
{
?>
<td class="hmenu" ><a href='vstmaj.php?copern=1111&page=1&drupoh=2'>
<img src='../obr/white.jpg' width=20 height=15 border=0 title="Reinicializ·cia Majetku - nevymaûe stav majetku"></a>
<?php
}
?>
<?php
  }
?>
<?php
  if ( $drupoh == 11 OR $drupoh == 12 )
  {
?>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>

<td class="hmenu" >
<?php
if ( $kli_uzall > 10000 AND $drupoh == 11 )
{
?>
<a href='vstmaj.php?copern=367&page=1&drupoh=11'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<a href='vstmaj.php?copern=355&page=1&drupoh=11'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
<?php
}
?>
</td>
<td class="hmenu" >
<a href="#" onClick="mespoh();">
<img src='../obr/tlac.png' width=15 height=15 border=0 title='VytlaËiù mesaËnÈ pohyby, vöetky/zaradenia/vyradenia podæa selektora vpravo' ></a>

<?php
       if ( $drupoh == 11 )
       {
?>
<a href="#" onClick="rocpoh();">
<img src='../obr/tlac.png' width=20 height=20 border=0 title='VytlaËiù roËnÈ pohyby, vöetky/zaradenia/vyradenia podæa selektora vpravo' ></a>

<?php
       }
?>

<?php
       if ( $drupoh == 12 )
       {
?>
<a href="#" onClick="window.open('mespoh.php?copern=10&drupoh=22&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=20 border=0 title='VytlaËiù roËnÈ pohyby' ></a>

<td class="hmenu" >
ume<a href="#" onClick="window.open('mespoh.php?copern=10&drupoh=32&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=20 border=0 title='VytlaËiù roËnÈ pohyby, podæa mesiacov' ></a>
<?php
       }
?>
</td>

<td class="hmenu" >
<select class="hvstup" size="1" name="akep" id="akep" >
<option value="0" >ALL</option>
<option value="1" >ZAR</option>
<option value="2" >VYR</option>
</select>
<?php
  }
?>


</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_inv" id="hladaj_inv" size="15" value="<?php echo $hladaj_inv;?>" />
<td class="hmenu"><input type="text" name="hladaj_naz" id="hladaj_naz" size="30" value="<?php echo $hladaj_naz;?>" />
<td class="hmenu"><input type="text" name="hladaj_str" id="hladaj_str" size="15" value="<?php echo $hladaj_str;?>" />
<td class="hmenu"><input type="text" name="hladaj_oc" id="hladaj_oc" size="15" value="<?php echo $hladaj_oc;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" ></td>
</FORM>
<FORM name="formhl2" class="hmenu" method="post" action="vstmaj.php?drupoh=<?php echo $drupoh;?>&page=1&copern=1" >
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" ></td>
</tr>
</FORM>
<?php
     }
?>
<FORM name="formp2" class="obyc" method="post" action="../ucto/vspk_u.php?drupoh=<?php echo $drupoh;?>&page=1&copern=55" >
<tr>
<?php
  if ( $drupoh == 1 )
  {
?>
<td class="hmenu" width="10%" >Ume - Inv.ËÌslo
<td class="hmenu" width="26%" >

 <img src='../obr/zmazuplne.png'  width=12 height=12 border=0 title='Zruöiù oznaËenie vöetk˝ch poloûiek' onclick='Vyber(0, 1, 0);' >


N·zov
<td class="hmenu" width="10%" >STR - Z¡K
<td class="hmenu" width="10%" >Os.ËÌslo/Kancel·ria
<td class="hmenu" width="10%" align="right">Obst.cena
<td class="hmenu" width="10%" align="right">Zost.cena
<td class="hmenu" width="4%" >TlaË
<td class="hmenu" width="4%" >UPR
<td class="hmenu" width="4%" >VYR
<th class="hmenu" width="4%" >ZVä
<td class="hmenu" width="4%" >RZD
<th class="hmenu" width="4%" >Zmaû
<?php
  }
?>
<?php
  if ( $drupoh == 2 )
  {
?>
<td class="hmenu" width="10%" >Ume - Inv.ËÌslo
<td class="hmenu" width="26%" >

 <img src='../obr/zmazuplne.png'  width=12 height=12 border=0 title='Zruöiù oznaËenie vöetk˝ch poloûiek' onclick='Vyber(0, 1, 0);' >

N·zov
<td class="hmenu" width="10%" >STR - Z¡K
<td class="hmenu" width="10%" >Os.ËÌslo/Kancel·ria
<td class="hmenu" width="10%" align="right">Obst.cena
<td class="hmenu" width="10%" align="right">Mnoûstvo 
<td class="hmenu" width="4%" >TlaË
<td class="hmenu" width="4%" >UPR
<td class="hmenu" width="4%" >VYR
<th class="hmenu" width="4%" > 
<td class="hmenu" width="4%" >RZD 
<th class="hmenu" width="4%" >Zmaû
<?php
  }
?>
<?php
  if ( $drupoh == 11 )
  {
?>
<td class="hmenu" width="10%" >Ume - Inv.ËÌslo
<td class="hmenu" width="26%" >N·zov
<td class="hmenu" width="10%" >Pohyb/Druh
<td class="hmenu" width="10%" >Os.ËÌslo/Kancel·ria
<td class="hmenu" width="10%" align="right">Obst.cena
<td class="hmenu" width="10%" align="right">Zost.cena
<td class="hmenu" width="4%" >TlaË
<td class="hmenu" width="4%" >UPR
<td class="hmenu" width="4%" >
<th class="hmenu" width="4%" >
<td class="hmenu" width="4%" >
<th class="hmenu" width="4%" >Zmaû
<?php
  }
?>
<?php
  if ( $drupoh == 12 )
  {
?>
<td class="hmenu" width="10%" >Ume - Inv.ËÌslo
<td class="hmenu" width="26%" >N·zov
<td class="hmenu" width="10%" >Pohyb/Druh
<td class="hmenu" width="10%" >Os.ËÌslo/Kancel·ria
<td class="hmenu" width="10%" align="right">Obst.cena
<td class="hmenu" width="10%" align="right">Mnoûstvo 
<td class="hmenu" width="4%" >TlaË
<td class="hmenu" width="4%" >UPR
<td class="hmenu" width="4%" >
<th class="hmenu" width="4%" > 
<td class="hmenu" width="4%" > 
<th class="hmenu" width="4%" >Zmaû
<?php
  }
?>

</tr>

<?php
   while ($i <= $konc )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>
<?php
  if ( $drupoh == 1 )
  {
?>
<td class="fmenu" ><?php echo $riadok->ume;?> - <?php echo $riadok->inv;?></td>
<td class="fmenu" >
 <input type="checkbox" name="vyber<?php echo $riadok->inv;?>" value="1" onclick="Vyber(<?php echo $riadok->inv;?>, <?php echo $page;?>, <?php echo $riadok->hx3;?>);"/>
<?php
if ( $riadok->hx3 == 1 )
   {
?>
<script type="text/javascript">
document.formp2.vyber<?php echo $riadok->inv;?>.checked = "checked";
</script>
<?php
   }
?>
<?php echo $riadok->naz;?></td>
<td class="fmenu" >
<img src='../obr/vlozit.png' width=10 height=10 border=1 onclick="NovaPol(<?php echo $riadok->inv;?>)" title="Zaradiù nov˙ poloûku s rovnak˝mi ˙dajmi" >

<?php echo $riadok->str;?> - <?php echo $riadok->zak;?></td>
<td class="fmenu" >
<?php
if ( $drupoh == 1 OR $drupoh == 222 )
   {
?>
<img src='../obr/orig.png' width=10 height=10 border=1 onclick="textHim(<?php echo $riadok->inv;?>)" title="DoplÚuj˙ce ˙daje o majetku" >

<?php
   }
?>

<?php
  if ( $riadok->oc != 0 )
  {
?>
osË <?php echo $riadok->oc;?> <?php echo $riadok->prie;?>  <?php echo $riadok->meno;?>
<?php
  }
?>
<?php
  if ( $riadok->kanc != 0 )
  {
?>
kanc <?php echo $riadok->kanc;?> <?php echo $riadok->nkan;?>
<?php
  }
?>
</td>
<td class="fmenu" align="right" ><?php echo $riadok->cen;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->zos;?></td>
<td class="fmenu" >

<img src='../obr/tlac.png' onClick="window.open('kartamajetku.php?copern=21&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_inv=<?php echo $riadok->inv;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"
 width=15 height=10 border=0 title="TlaË karty majetku" >

<img src='../obr/zoznam.png' onClick="window.open('umiestnenie.php?copern=21&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_inv=<?php echo $riadok->inv;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"
 width=15 height=10 border=0 title="TlaË umiestnenia majetku" >
</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 1 )
  {
?>
<a href='vstm_u.php?copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù poloûku majetku" ></a>
<?php
  }
?>
</td>
<td class="fmenu" >
<a href='vstm_u.php?copern=106&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Vyradiù poloûku majetku" ></a>
</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 1 )
  {
?>
<a href='vstm_u.php?copern=4&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Zv˝öiù hodnotu poloûky majetku" ></a>
<?php
  }
?>
</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 1 )
  {
?>
<a href='vstm_u.php?copern=5&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Rozdeliù hodnotu poloûky majetku" ></a>
<?php
  }
?>
</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 1 )
  {
?>
<a href='vstm_u.php?copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Zmazaù poloûku majetku" ></a>
<?php
  }
?>
</td>
<?php
}
?>
<?php
  if ( $drupoh == 2 )
  {
?>
<td class="fmenu" ><?php echo $riadok->ume;?> - <?php echo $riadok->inv;?></td>
<td class="fmenu" >

 <input type="checkbox" name="vyber<?php echo $riadok->inv;?>" value="1" onclick="Vyber(<?php echo $riadok->inv;?>, <?php echo $page;?>, <?php echo $riadok->hx3;?>);"/>
<?php
if ( $riadok->hx3 == 1 )
   {
?>
<script type="text/javascript">
document.formp2.vyber<?php echo $riadok->inv;?>.checked = "checked";
</script>
<?php
   }
?>

<?php echo $riadok->naz;?></td>
<td class="fmenu" >
<img src='../obr/vlozit.png' width=10 height=10 border=1 onclick="NovaPol(<?php echo $riadok->inv;?>)" title="Zaradiù nov˙ poloûku s rovnak˝mi ˙dajmi" >


<?php echo $riadok->str;?> - <?php echo $riadok->zak;?></td>
<td class="fmenu" >
<?php
if ( $drupoh == 1 OR $drupoh == 222 )
   {
?>
<img src='../obr/orig.png' width=10 height=10 border=1 onclick="textHim(<?php echo $riadok->inv;?>)" title="DoplÚuj˙ce ˙daje o majetku" >

<?php
   }
?>

<?php
  if ( $riadok->oc != 0 )
  {
?>
osË <?php echo $riadok->oc;?> <?php echo $riadok->prie;?>  <?php echo $riadok->meno;?>
<?php
  }
?>
<?php
  if ( $riadok->kanc != 0 )
  {
?>
kanc <?php echo $riadok->kanc;?> <?php echo $riadok->nkan;?>
<?php
  }
?>
</td>
<td class="fmenu" align="right" ><?php echo $riadok->cen;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->mno;?></td>
<td class="fmenu" >
<img src='../obr/tlac.png' onClick="window.open('vstm_t.php?copern=31&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_inv=<?php echo $riadok->inv;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"
 width=15 height=10 border=0 title="TlaË karty majetku" >

<img src='../obr/zoznam.png' onClick="window.open('umiestnenie.php?copern=31&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_inv=<?php echo $riadok->inv;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes')"
 width=15 height=10 border=0 title="TlaË umiestnenia majetku" >

</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 1 )
  {
?>
<a href='vstm_u.php?copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù poloûku majetku" ></a>
<?php
  }
?>
</td>
<td class="fmenu" >
<a href='vstm_u.php?copern=106&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Vyradiù poloûku majetku" ></a>
</td>
<td class="fmenu" >
 
</td>
<td class="fmenu" >

<a href='vstm_u.php?copern=5&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Rozdeliù hodnotu poloûky majetku" ></a>

</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 1 OR $riadok->poh == 5 )
  {
?>
<a href='vstm_u.php?copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Zmazaù poloûku majetku" ></a>
<?php
  }
?>
</td>
<?php
}
?>
<?php
  if ( $drupoh == 11 )
  {
?>
<td class="fmenu" ><?php echo $riadok->ume;?> - <?php echo $riadok->inv;?></td>
<td class="fmenu" ><?php echo $riadok->naz;?></td>
<td class="fmenu" ><?php echo $riadok->poh;?>/<?php echo $riadok->dph; ?>
<?php
  if ( $riadok->poh == 2 )
  {
?>
 zaradenie
<?php
  }
?>
<?php
  if ( $riadok->poh == 3 )
  {
?>
 vyradenie
<?php
  }
?>
<?php
  if ( $riadok->poh == 4 )
  {
?>
 zv˝öenie o <?php echo $riadok->hd1;?>
<?php
  }
?>
<?php
  if ( $riadok->poh == 5 )
  {
?>
 rozdelenie
<?php
  }
?>
</td>
<td class="fmenu" >
<?php
if ( $drupoh == 11 )
   {
?>
<img src='../obr/orig.png' width=10 height=10 border=1 onclick="textHim(<?php echo $riadok->inv;?>)" title="DoplÚuj˙ce ˙daje o majetku" >

<?php
   }
?>
<?php
  if ( $riadok->oc != 0 )
  {
?>
osË <?php echo $riadok->oc;?> <?php echo $riadok->prie;?>  <?php echo $riadok->meno;?>
<?php
  }
?>
<?php
  if ( $riadok->kanc != 0 )
  {
?>
kanc <?php echo $riadok->kanc;?> <?php echo $riadok->nkan;?>
<?php
  }
?>
</td>
<td class="fmenu" align="right" ><?php echo $riadok->cen;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->zos;?></td>
<td class="fmenu" >
<a href="#" onClick="window.open('vstm_t.php?copern=<?php echo $riadok->poh+20; ?>&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_inv=<?php echo $riadok->inv;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË protokolu o pohybe" ></a>
</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 2 )
  {
?>
<a href='vstm_u.php?copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&poh=<?php echo $riadok->poh;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù pohyb" ></a>
<?php
  }
?>
</td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<td class="fmenu" >
<a href='vstm_u.php?copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_poh=<?php echo $riadok->poh;?>' target="_self">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Zmazaù pohyb" ></a>
</td>
<?php
}
?>
<?php
  if ( $drupoh == 12 )
  {
?>
<td class="fmenu" ><?php echo $riadok->ume;?> - <?php echo $riadok->inv;?></td>
<td class="fmenu" ><?php echo $riadok->naz;?></td>
<td class="fmenu" ><?php echo $riadok->poh;?>/<?php echo $riadok->dph; ?>
<?php
  if ( $riadok->poh == 2 )
  {
?>
 zaradenie
<?php
  }
?>
<?php
  if ( $riadok->poh == 3 )
  {
?>
 vyradenie
<?php
  }
?>
<?php
  if ( $riadok->poh == 4 )
  {
?>
 zv˝öenie
<?php
  }
?>
<?php
  if ( $riadok->poh == 5 )
  {
?>
 rozdelenie
<?php
  }
?>
</td>
<td class="fmenu" >
<?php
  if ( $riadok->oc != 0 )
  {
?>
osË <?php echo $riadok->oc;?> <?php echo $riadok->prie;?>  <?php echo $riadok->meno;?>
<?php
  }
?>
<?php
  if ( $riadok->kanc != 0 )
  {
?>
kanc <?php echo $riadok->kanc;?> <?php echo $riadok->nkan;?>
<?php
  }
?>
</td>
<td class="fmenu" align="right" ><?php echo $riadok->cen;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->mno;?></td>
<td class="fmenu" >
<a href="#" onClick="window.open('vstm_t.php?copern=<?php echo $riadok->poh+30; ?>&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_inv=<?php echo $riadok->inv;?>', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=15 height=10 border=0 title="TlaË protokolu o pohybe" ></a>
</td>
<td class="fmenu" >
<?php
  if ( $riadok->poh == 2 )
  {
?>
<a href='vstm_u.php?copern=8&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>&poh=<?php echo $riadok->poh;?>
&cislo_cpl=<?php echo $riadok->cpl;?>' target="_self">
<img src='../obr/uprav.png' width=15 height=10 border=0 title="Upraviù pohyb" ></a>
<?php
  }
?>
</td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<td class="fmenu" ></td>
<td class="fmenu" >
<a href='vstm_u.php?copern=6&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>
&cislo_cpl=<?php echo $riadok->cpl;?>&cislo_poh=<?php echo $riadok->poh;?>' target="_self">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title="Zmazaù pohyb" ></a>
</td>
<?php
}
?>

</tr>
<?php
  }
$i = $i + 1;
   }
if ( $copern != 5 AND $copern != 8 AND $copern != 6 ) echo "</table>";
?>
<table class="fmenu" width="100%" >
<tr>
<td class="bmenu" width="80%" >
<?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?>
</td>
<td class="bmenu" width="20%" align="center">
<?php
if ( $copern == 10000 )
{
?>
<input type="checkbox" name="uhradp" value="1"  onmouseover="UkazSkryj('Vyfakt˙rovaù<br />vybranÈ doklady<br />zaökrtnite a OK');"
 onmouseout="Okno.style.display='none';" >
<INPUT type="submit" id="pokl" name="pokl" value="OK" />
<?php
}
?>
</td>
</FORM>
</td>
</tr>
</table>
<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,7,9

//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka INV=<?php echo $cislo_inv;?> vymazan·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="vstmaj.php?
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_str=$hladaj_str&hladaj_naz=$hladaj_naz&hladaj_oc=$hladaj_oc&hladaj_inv=$hladaj_inv";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="vstmaj.php?
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_str=$hladaj_str&hladaj_naz=$hladaj_naz&hladaj_oc=$hladaj_oc&hladaj_inv=$hladaj_inv";
}
?>
&drupoh=<?php echo $drupoh;?>&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="vstmaj.php?copern=4&drupoh=<?php echo $drupoh;?>&page=<?php echo $xstr;?>" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<?php
if ( $drupoh == 1 OR $drupoh == 2 )
{
?>
<FORM name="forma4" class="obyc" method="post" action="vstm_u.php?copern=1&drupoh=<?php echo $drupoh;?>&page=<?php echo $page;?>" >
<INPUT type="submit" name="npol" id="npol" value="Zaradenie" >
</FORM>
<?php
}
?>
</td>
</tr>
</table>

<?php
     }
//koniec nezobraz pre novu,upravu a mazanie
?>


<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

$cislista = include("maj_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
