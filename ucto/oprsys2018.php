<HTML>
<?php
//zber dat 2018
$sys = 'UCT';
$urov = 1000;
$cslm=100620;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$uprav = 1*$_REQUEST['uprav'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];

//echo $h_obdp;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

if( $h_obdp == 0 ) $h_obdp=$kli_vmes;
if( $h_obdk == 0 ) $h_obdk=$kli_vmes;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $fir_fico == 36084212 ) { $poliklinikase=1; }

$berext=0;
if( $poliklinikase == 1 AND $fir_fico == 36084212 ) { $berext=1; }
//$berext=1;
//$medo=1;

//zablokuj faktury
$blokacia=0;
if( $copern == 2166 )
{
$h_sys = 1*$_REQUEST['h_sys'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$blokacia=1;

$sqlt = <<<saldo
(
   drx         VARCHAR(10),
   idx         INT(4),
   datm        TIMESTAMP(14)
);
saldo;

$sql = "CREATE TABLE F$kli_vxcf"."_uctblokfak".$h_sys."_".$h_obdp."".$sqlt;
$urob = mysql_query("$sql");

$copern=1;
}

//odblokuj faktury
if( $copern == 2177 )
{
$h_sys = 1*$_REQUEST['h_sys'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$blokacia=1;

$sql = "DROP TABLE F$kli_vxcf"."_uctblokfak".$h_sys."_".$h_obdp."".$sqlt;
$urob = mysql_query("$sql");

$copern=1;
}

//zablokuj pokladnicu
$blokacia=0;
if( $copern == 3166 )
{
$h_sys = 1*$_REQUEST['h_sys'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$blokacia=1;

$sqlt = <<<saldo
(
   drx         VARCHAR(10),
   idx         INT(4),
   datm        TIMESTAMP(14)
);
saldo;

$sql = "CREATE TABLE F$kli_vxcf"."_uctblokpokl_".$h_sys."_".$h_obdp."".$sqlt;
$urob = mysql_query("$sql");
//echo $sql;

$copern=1;
}

//odblokuj pokladnicu
if( $copern == 3177 )
{
$h_sys = 1*$_REQUEST['h_sys'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$blokacia=1;

$sql = "DROP TABLE F$kli_vxcf"."_uctblokpokl_".$h_sys."_".$h_obdp."".$sqlt;
$urob = mysql_query("$sql");
//echo $sql;

$copern=1;
}

if( $copern > 50 AND $drupoh == 1 )
{
$uctsys="uctmzd";
}
if( $copern > 50 AND $drupoh == 2 )
{
$uctsys="uctmaj";
}
if( $copern > 50 AND $drupoh == 3 )
{
$uctsys="uctskl";
}
if( $copern > 50 AND $drupoh == 9 )
{
$uctsys="dopnaklady";
}
if( $copern > 50 AND $drupoh == 8 )
{
$uctsys="uctuhradpoc";
$sql = "CREATE TABLE F".$kli_vxcf."_uctuhradpoc SELECT * FROM F".$kli_vxcf."_uctskl WHERE dok = 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_uctuhradpoc MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
}
if( $copern > 50 AND $drupoh == 7 )
{
$uctsys="fakodbpocuct";
$sql = "CREATE TABLE F".$kli_vxcf."_fakodbpocuct SELECT * FROM F".$kli_vxcf."_uctskl WHERE dok = 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_fakodbpocuct MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
}
if( $copern > 50 AND $drupoh == 6 )
{
$uctsys="fakdodpocuct";
$sql = "CREATE TABLE F".$kli_vxcf."_fakdodpocuct SELECT * FROM F".$kli_vxcf."_uctskl WHERE dok = 0";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F".$kli_vxcf."_fakdodpocuct MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
}
if( $copern > 50 AND $drupoh == 21 )
{
$uctsys="uctpocvziskov";
}
if( $copern > 50 AND $drupoh == 22 )
{
$uctsys="uctpocsuvaha";
}
if( $copern > 50 AND $drupoh == 23 )
{
$uctsys="uctpoccash";
}
if( $copern > 50 AND $drupoh == 24 )
{
$uctsys="uctpoccash2011";
}
if( $copern > 50 AND $drupoh == 28 )
{
$uctsys="uctpohybpenden2013";
}
if( $copern > 50 AND $drupoh == 29 )
{
$uctsys="uctpohybpenden";
}
if( $copern > 50 AND $drupoh == 31 )
{
$uctsys="uctpocvziskovno";
}
if( $copern > 50 AND $drupoh == 32 )
{
$uctsys="uctpocsuvahano";
//$sql = "DROP TABLE F$kli_vxcf"."_crs_no";
//$vysledok = mysql_query("$sql");
}
if( $copern > 50 AND $drupoh == 41 )
{
$uctsys="uctpocprivyd";
}
if( $copern > 50 AND $drupoh == 42 )
{
$uctsys="uctpocmajzav";
}
if( $copern > 50 AND $drupoh == 43 )
{
$uctsys="uctjcdarch";
}
if( $copern > 50 AND $drupoh == 44 )
{
$uctsys="uctsyngensuv";
}
if( $copern > 50 AND $drupoh == 45 )
{
$sql = "DELETE FROM F$kli_vxcf"."_mzdprnahset WHERE cpl = 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprnahset MODIFY cpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$uctsys="mzdprnahset";
}
if( $copern > 50 AND $drupoh == 46 )
{
$sql = "DELETE FROM F$kli_vxcf"."_mzdprnahdelene WHERE cpl = 0 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdprnahdelene MODIFY cpl int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$uctsys="mzdprnahdelene";
}
if( $copern > 50 AND $drupoh == 47 )
{
$uctsys="uctpocmajzavnoju";
}

if( $copern > 50 AND $drupoh == 11 )
{
$uctsys="uctvzordok";

$h_obdp=1;
$h_obdk=12;
}

if( $drupoh > 20 OR $drupoh == 11 )
{

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

$sql = 'CREATE TABLE F'.$kli_vxcf.'_'.$uctsys.$sqlt;
$ulozene = mysql_query("$sql");

}
if( $copern > 50 AND $drupoh == 11 )
{
$sql = "ALTER TABLE F$kli_vxcf"."_uctvzordok MODIFY cpl int PRIMARY KEY not null auto_increment ";
$vysledek = mysql_query("$sql");
}

//nacitanie minuleho roka do vykazu ziskov 
    if ( $copern == 3155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù hodnoty bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia ? ") )
         { window.close()  }
else
         { location.href='oprsys.php?copern=3156&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 3156 )
    {

$dsqlt = "DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

//ume  dat  dok  poh  cpl  ucm  ucd  rdp  dph  hod  ico  fak  pop  str  zak  unk  id  datm  
$h_ycf=0;
if( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

if( $drupoh == 21 ) { $odkial="".$databaza."F$h_ycf"."_prcvyk1000ziss$kli_uzid"; $hodx="r"; }
if( $drupoh == 22 ) { $odkial="".$databaza."F$h_ycf"."_prcsuv1000ahas$kli_uzid"; $hodx="rn"; }
if( $drupoh == 23 ) { $odkial="".$databaza."F$h_ycf"."_prccash1000flow$kli_uzid"; $hodx="r"; }
if( $drupoh == 24 ) { $odkial="".$databaza."F$h_ycf"."_prccash1000ziss$kli_uzid"; $hodx="r"; }
if( $drupoh == 31 ) { $odkial="".$databaza."F$h_ycf"."_prcvyk1000ziss$kli_uzid"; $hodx="rsp"; }
if( $drupoh == 32 ) { $odkial="".$databaza."F$h_ycf"."_prcsuv1000ahas$kli_uzid"; $hodx="rn"; }
if( $drupoh == 31 AND $kli_vrok >= 2013 ) { 
$odkial="".$databaza."F$h_ycf"."_prcvykziss$kli_uzid"; $hodx="rsp"; 

$dsqlt="DELETE FROM $odkial WHERE prx != 1 ";
$dsql = mysql_query("$dsqlt");
}
if( $drupoh == 32 AND $kli_vrok >= 2013 ) 
{ 
$odkial="".$databaza."F$h_ycf"."_prcsuvahas$kli_uzid"; $hodx="rn"; 

$dsqlt="DELETE FROM $odkial WHERE prx != 1 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
}

if( $kli_vrok == 2011 AND $drupoh == 22 )
{
//vymaz prepocitanie min.obdobia suvahy2011 preneseneho z 2010
$sqlt = "DROP TABLE F".$kli_vxcf."_uctpocsuv2011";
$vysledok = mysql_query("$sqlt");
}

if( $drupoh == 42 AND $kli_vrok >= 2015 ) 
{ 
$odkial="".$databaza."F$h_ycf"."_prcvmajzavs$kli_uzid"; $hodx="r"; 

$dsqlt="DELETE FROM $odkial WHERE prx != 1 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
}


$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','01',0,0,0,0,0,0,".$hodx."01,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."01 != 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','02',0,0,0,0,0,0,".$hodx."02,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."02 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','03',0,0,0,0,0,0,".$hodx."03,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."03 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','04',0,0,0,0,0,0,".$hodx."04,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."04 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','05',0,0,0,0,0,0,".$hodx."05,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."05 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','06',0,0,0,0,0,0,".$hodx."06,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."06 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','07',0,0,0,0,0,0,".$hodx."07,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."07 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','08',0,0,0,0,0,0,".$hodx."08,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."08 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','09',0,0,0,0,0,0,".$hodx."09,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."09 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','10',0,0,0,0,0,0,".$hodx."10,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."10 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','11',0,0,0,0,0,0,".$hodx."11,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."11 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','12',0,0,0,0,0,0,".$hodx."12,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."12 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','13',0,0,0,0,0,0,".$hodx."13,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."13 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','14',0,0,0,0,0,0,".$hodx."14,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."14 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','15',0,0,0,0,0,0,".$hodx."15,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."15 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','16',0,0,0,0,0,0,".$hodx."16,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."16 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','17',0,0,0,0,0,0,".$hodx."17,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."17 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','18',0,0,0,0,0,0,".$hodx."18,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."18 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','19',0,0,0,0,0,0,".$hodx."19,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."19 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','20',0,0,0,0,0,0,".$hodx."20,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."20 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','21',0,0,0,0,0,0,".$hodx."21,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."21 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','22',0,0,0,0,0,0,".$hodx."22,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."22 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','23',0,0,0,0,0,0,".$hodx."23,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."23 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','24',0,0,0,0,0,0,".$hodx."24,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."24 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','25',0,0,0,0,0,0,".$hodx."25,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."25 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','26',0,0,0,0,0,0,".$hodx."26,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."26 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','27',0,0,0,0,0,0,".$hodx."27,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."27 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','28',0,0,0,0,0,0,".$hodx."28,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."28 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','29',0,0,0,0,0,0,".$hodx."29,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."29 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','30',0,0,0,0,0,0,".$hodx."30,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."30 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','31',0,0,0,0,0,0,".$hodx."31,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."31 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','32',0,0,0,0,0,0,".$hodx."32,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."32 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','33',0,0,0,0,0,0,".$hodx."33,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."33 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','34',0,0,0,0,0,0,".$hodx."34,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."34 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','35',0,0,0,0,0,0,".$hodx."35,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."35 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','36',0,0,0,0,0,0,".$hodx."36,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."36 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','37',0,0,0,0,0,0,".$hodx."37,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."37 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','38',0,0,0,0,0,0,".$hodx."38,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."38 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','39',0,0,0,0,0,0,".$hodx."39,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."39 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','40',0,0,0,0,0,0,".$hodx."40,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."40 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','41',0,0,0,0,0,0,".$hodx."41,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."41 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','42',0,0,0,0,0,0,".$hodx."42,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."42 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','43',0,0,0,0,0,0,".$hodx."43,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."43 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','44',0,0,0,0,0,0,".$hodx."44,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."44 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','45',0,0,0,0,0,0,".$hodx."45,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."45 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','46',0,0,0,0,0,0,".$hodx."46,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."46 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','47',0,0,0,0,0,0,".$hodx."47,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."47 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','48',0,0,0,0,0,0,".$hodx."48,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."48 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','49',0,0,0,0,0,0,".$hodx."49,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."49 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','50',0,0,0,0,0,0,".$hodx."50,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."50 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','51',0,0,0,0,0,0,".$hodx."51,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."51 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','52',0,0,0,0,0,0,".$hodx."52,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."52 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','53',0,0,0,0,0,0,".$hodx."53,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."53 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','54',0,0,0,0,0,0,".$hodx."54,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."54 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','55',0,0,0,0,0,0,".$hodx."55,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."55 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','56',0,0,0,0,0,0,".$hodx."56,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."56 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','57',0,0,0,0,0,0,".$hodx."57,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."57 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','58',0,0,0,0,0,0,".$hodx."58,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."58 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','59',0,0,0,0,0,0,".$hodx."59,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."59 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','60',0,0,0,0,0,0,".$hodx."60,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."60 != 0 ";
$dsql = mysql_query("$dsqlt");

if( $drupoh == 32 ) { $odkial="".$databaza."F$h_ycf"."_prcsuv1000ahas$kli_uzid"; $hodx="r"; }
if( $drupoh == 32 AND $kli_vrok >= 2013 ) { $odkial="".$databaza."F$h_ycf"."_prcsuvahas$kli_uzid"; $hodx="r"; }

$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','61',0,0,0,0,0,0,".$hodx."61,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."61 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','62',0,0,0,0,0,0,".$hodx."62,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."62 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','63',0,0,0,0,0,0,".$hodx."63,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."63 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','64',0,0,0,0,0,0,".$hodx."64,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."64 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','65',0,0,0,0,0,0,".$hodx."65,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."65 != 0 ";
$dsql = mysql_query("$dsqlt");

if( $drupoh == 22 AND $kli_vrok <= 2011 ) { $odkial="".$databaza."F$h_ycf"."_prcsuv1000ahas$kli_uzid"; $hodx="r"; }
if( $drupoh == 22 AND $kli_vrok > 2011 ) { $odkial="".$databaza."F$h_ycf"."_prcsuv1000ahas$kli_uzid"; $hodx="r"; }

$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','66',0,0,0,0,0,0,".$hodx."66,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."66 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','67',0,0,0,0,0,0,".$hodx."67,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."67 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','68',0,0,0,0,0,0,".$hodx."68,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."68 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','69',0,0,0,0,0,0,".$hodx."69,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."69 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','70',0,0,0,0,0,0,".$hodx."70,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."70 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','71',0,0,0,0,0,0,".$hodx."71,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."71 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','72',0,0,0,0,0,0,".$hodx."72,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."72 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','73',0,0,0,0,0,0,".$hodx."73,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."73 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','74',0,0,0,0,0,0,".$hodx."74,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."74 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','75',0,0,0,0,0,0,".$hodx."75,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."75 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','76',0,0,0,0,0,0,".$hodx."76,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."76 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','77',0,0,0,0,0,0,".$hodx."77,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."77 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','78',0,0,0,0,0,0,".$hodx."78,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."78 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','79',0,0,0,0,0,0,".$hodx."79,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."79 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','80',0,0,0,0,0,0,".$hodx."80,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."80 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','81',0,0,0,0,0,0,".$hodx."81,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."81 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','82',0,0,0,0,0,0,".$hodx."82,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."82 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','83',0,0,0,0,0,0,".$hodx."83,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."83 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','84',0,0,0,0,0,0,".$hodx."84,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."84 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','85',0,0,0,0,0,0,".$hodx."85,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."85 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','86',0,0,0,0,0,0,".$hodx."86,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."86 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','87',0,0,0,0,0,0,".$hodx."87,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."87 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','88',0,0,0,0,0,0,".$hodx."88,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."88 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','89',0,0,0,0,0,0,".$hodx."89,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."89 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','90',0,0,0,0,0,0,".$hodx."90,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."90 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','91',0,0,0,0,0,0,".$hodx."91,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."91 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','92',0,0,0,0,0,0,".$hodx."92,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."92 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','93',0,0,0,0,0,0,".$hodx."93,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."93 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','94',0,0,0,0,0,0,".$hodx."94,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."94 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','95',0,0,0,0,0,0,".$hodx."95,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."95 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','96',0,0,0,0,0,0,".$hodx."96,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."96 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','97',0,0,0,0,0,0,".$hodx."97,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."97 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','98',0,0,0,0,0,0,".$hodx."98,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."98 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','99',0,0,0,0,0,0,".$hodx."99,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."99 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','100',0,0,0,0,0,0,".$hodx."100,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."100 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','101',0,0,0,0,0,0,".$hodx."101,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."101 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','102',0,0,0,0,0,0,".$hodx."102,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."102 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','103',0,0,0,0,0,0,".$hodx."103,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."103 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','104',0,0,0,0,0,0,".$hodx."104,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."104 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','105',0,0,0,0,0,0,".$hodx."105,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."105 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','106',0,0,0,0,0,0,".$hodx."106,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."106 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','107',0,0,0,0,0,0,".$hodx."107,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."107 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','108',0,0,0,0,0,0,".$hodx."108,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."108 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','109',0,0,0,0,0,0,".$hodx."109,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."109 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','110',0,0,0,0,0,0,".$hodx."110,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."110 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','111',0,0,0,0,0,0,".$hodx."111,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."111 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','112',0,0,0,0,0,0,".$hodx."112,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."112 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','113',0,0,0,0,0,0,".$hodx."113,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."113 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','114',0,0,0,0,0,0,".$hodx."114,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."114 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','115',0,0,0,0,0,0,".$hodx."115,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."115 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','116',0,0,0,0,0,0,".$hodx."116,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."116 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','117',0,0,0,0,0,0,".$hodx."117,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."117 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','118',0,0,0,0,0,0,".$hodx."118,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."118 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','119',0,0,0,0,0,0,".$hodx."119,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."119 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','120',0,0,0,0,0,0,".$hodx."120,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."120 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','121',0,0,0,0,0,0,".$hodx."121,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."121 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','122',0,0,0,0,0,0,".$hodx."122,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."122 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','123',0,0,0,0,0,0,".$hodx."123,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."123 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','124',0,0,0,0,0,0,".$hodx."124,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."124 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','125',0,0,0,0,0,0,".$hodx."125,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."125 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','126',0,0,0,0,0,0,".$hodx."126,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."126 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','127',0,0,0,0,0,0,".$hodx."127,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."127 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','128',0,0,0,0,0,0,".$hodx."128,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."128 != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt="INSERT INTO F$kli_vxcf"."_$uctsys SELECT 0,'0000-00-00','129',0,0,0,0,0,0,".$hodx."129,0,0,'',0,0,'',0,'0000-00-00' FROM $odkial WHERE ".$hodx."129 != 0 ";
$dsql = mysql_query("$dsqlt");


if( $drupoh == 42 AND $kli_vrok >= 2015 ) 
{ 

$dsqlt="DELETE FROM F$kli_vxcf"."_$uctsys WHERE dok > 21 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;
}


$copern=308;
//koniec nacitania minuleho roka do vykazu ziskov 
    }



//nacitanie standartnej druhpohybu-stlpec penazneho.dennika 
    if ( $copern == 155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk druh pohybu -> stÂpec peÚaûnÈho dennÌka ?") )
         { window.close()  }
else
         { location.href='oprsys.php?copern=156&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 156 )
    {

$uctpohybpenden="uctpohybpenden";
if( $drupoh == 28 ) { $uctpohybpenden="uctpohybpenden2013"; }


$dsqlt = "DELETE FROM F$kli_vxcf"."_$uctpohybpenden WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_$uctpohybpenden SELECT ".
"0,'0000-00-00',uce,0,0,0,prm1,crv,prm2,0,".
"0,0,'',0,0,'',0,'0000-00-00' ".
" FROM F$kli_vxcf"."_uctosnova WHERE LEFT(uce,3) < 100 AND uce > 1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=16 WHERE ucd = 1 AND dph = 1";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=26 WHERE ucd = 1 AND dph != 1";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=22 WHERE ucd != 1 AND dph = 1";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=31 WHERE ucd != 1 AND dph != 1";
$dsql = mysql_query("$dsqlt");

if( $kli_vrok < 2013 ) {

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=14 WHERE hod = 16 AND rdp = 1";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=15 WHERE hod = 16 AND rdp = 2";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=18 WHERE hod = 22 AND rdp = 5";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=19 WHERE hod = 22 AND rdp = 6";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=20 WHERE hod = 22 AND rdp = 7";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=21 WHERE hod = 22 AND rdp = 8";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=25 WHERE hod = 26 AND dok = 55";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=27 WHERE hod = 26 AND dok = 65";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=28 WHERE hod = 31 AND ( dok = 12 OR dok = 19 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=29 WHERE hod = 31 AND ( dok = 13 OR dok = 27 OR dok = 28 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=30 WHERE hod = 31 AND ( dok = 50 OR dok = 54 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=32 WHERE hod = 31 AND dok = 80";
$dsql = mysql_query("$dsqlt");

                        }

if( $kli_vrok >= 2013 ) {

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=14 WHERE hod = 16 AND rdp = 1";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=15 WHERE hod = 16 AND rdp = 2";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=18 WHERE hod = 22 AND rdp = 5";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=19 WHERE hod = 22 AND rdp = 5 AND ( dok = 3 OR dok = 23 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=22 WHERE hod = 22 AND rdp = 6";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=20 WHERE hod = 22 AND rdp = 7";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=21 WHERE hod = 22 AND rdp = 8";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=25 WHERE hod = 26 AND dok = 55";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=27 WHERE hod = 26 AND dok = 65";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=28 WHERE hod = 31 AND ( dok = 12 OR dok = 19 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=29 WHERE hod = 31 AND ( dok = 13 OR dok = 27 OR dok = 28 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=30 WHERE hod = 31 AND ( dok = 50 OR dok = 54 )";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=32 WHERE hod = 31 AND dok = 80";
$dsql = mysql_query("$dsqlt");

                        }

if( $drupoh == 28 )     {

$dsqlt = "UPDATE F$kli_vxcf"."_$uctpohybpenden SET hod=19 WHERE ( dok = 25 OR dok = 85 )";
$dsql = mysql_query("$dsqlt");

                        }

$copern=308;
//koniec nacitania standartnej druhpohybu-stlpec penazneho.dennika 
    }


if( $copern == 308 AND $drupoh > 20 AND $drupoh != 43 AND $drupoh != 44 AND $drupoh != 45 AND $drupoh != 46 )
{
//nastav prechadzajuce obdobie
$sql = 'DROP TABLE F'.$kli_vxcf.'_'.$uctsys."_stl";
$ulozene = mysql_query("$sql");

$sqlt = <<<prcpred
(
   dok          INT,
   hod          DECIMAL(10,2),
   rm01         DECIMAL(10,2),
   rm02         DECIMAL(10,2),
   rm03         DECIMAL(10,2),
   rm04         DECIMAL(10,2),
   rm05         DECIMAL(10,2),
   rm06         DECIMAL(10,2),
   rm07         DECIMAL(10,2),
   rm08         DECIMAL(10,2),
   rm09         DECIMAL(10,2),
   rm10         DECIMAL(10,2),
   rm11         DECIMAL(10,2),
   rm12         DECIMAL(10,2),
   rm13         DECIMAL(10,2),
   rm14         DECIMAL(10,2),
   rm15         DECIMAL(10,2),
   rm16         DECIMAL(10,2),
   rm17         DECIMAL(10,2),
   rm18         DECIMAL(10,2),
   rm19         DECIMAL(10,2),
   rm20         DECIMAL(10,2),
   rm21         DECIMAL(10,2),
   rm22         DECIMAL(10,2),
   rm23         DECIMAL(10,2),
   rm24         DECIMAL(10,2),
   rm25         DECIMAL(10,2),
   rm26         DECIMAL(10,2),
   rm27         DECIMAL(10,2),
   rm28         DECIMAL(10,2),
   rm29         DECIMAL(10,2),
   rm30         DECIMAL(10,2),
   rm31         DECIMAL(10,2),
   rm32         DECIMAL(10,2),
   rm33         DECIMAL(10,2),
   rm34         DECIMAL(10,2),
   rm35         DECIMAL(10,2),
   rm36         DECIMAL(10,2),
   rm37         DECIMAL(10,2),
   rm38         DECIMAL(10,2),
   rm39         DECIMAL(10,2),
   rm40         DECIMAL(10,2),
   rm41         DECIMAL(10,2),
   rm42         DECIMAL(10,2),
   rm43         DECIMAL(10,2),
   rm44         DECIMAL(10,2),
   rm45         DECIMAL(10,2),
   rm46         DECIMAL(10,2),
   rm47         DECIMAL(10,2),
   rm48         DECIMAL(10,2),
   rm49         DECIMAL(10,2),
   rm50         DECIMAL(10,2),
   rm51         DECIMAL(10,2),
   rm52         DECIMAL(10,2),
   rm53         DECIMAL(10,2),
   rm54         DECIMAL(10,2),
   rm55         DECIMAL(10,2),
   rm56         DECIMAL(10,2),
   rm57         DECIMAL(10,2),
   rm58         DECIMAL(10,2),
   rm59         DECIMAL(10,2),
   rm60         DECIMAL(10,2),
   rm61         DECIMAL(10,2),
   rm62         DECIMAL(10,2),
   rm63         DECIMAL(10,2),
   rm64         DECIMAL(10,2),
   rm65         DECIMAL(10,2),
   rm66         DECIMAL(10,2),
   rm67         DECIMAL(10,2),
   rm68         DECIMAL(10,2),
   rm69         DECIMAL(10,2),
   rm70         DECIMAL(10,2),
   rm71         DECIMAL(10,2),
   rm72         DECIMAL(10,2),
   rm73         DECIMAL(10,2),
   rm74         DECIMAL(10,2),
   rm75         DECIMAL(10,2),
   rm76         DECIMAL(10,2),
   rm77         DECIMAL(10,2),
   rm78         DECIMAL(10,2),
   rm79         DECIMAL(10,2),
   rm80         DECIMAL(10,2),
   rm81         DECIMAL(10,2),
   rm82         DECIMAL(10,2),
   rm83         DECIMAL(10,2),
   rm84         DECIMAL(10,2),
   rm85         DECIMAL(10,2),
   rm86         DECIMAL(10,2),
   rm87         DECIMAL(10,2),
   rm88         DECIMAL(10,2),
   rm89         DECIMAL(10,2),
   rm90         DECIMAL(10,2),
   rm91         DECIMAL(10,2),
   rm92         DECIMAL(10,2),
   rm93         DECIMAL(10,2),
   rm94         DECIMAL(10,2),
   rm95         DECIMAL(10,2),
   rm96         DECIMAL(10,2),
   rm97         DECIMAL(10,2),
   rm98         DECIMAL(10,2),
   rm99         DECIMAL(10,2),
   rm100         DECIMAL(10,2),
   rm101         DECIMAL(10,2),
   rm102         DECIMAL(10,2),
   rm103         DECIMAL(10,2),
   rm104         DECIMAL(10,2),
   rm105         DECIMAL(10,2),
   rm106         DECIMAL(10,2),
   rm107         DECIMAL(10,2),
   rm108         DECIMAL(10,2),
   rm109         DECIMAL(10,2),
   rm110         DECIMAL(10,2),
   rm111         DECIMAL(10,2),
   rm112         DECIMAL(10,2),
   rm113         DECIMAL(10,2),
   rm114         DECIMAL(10,2),
   rm115         DECIMAL(10,2),
   rm116         DECIMAL(10,2),
   rm117         DECIMAL(10,2),
   rm118         DECIMAL(10,2),
   rm119         DECIMAL(10,2),
   rm120         DECIMAL(10,2),
   rm121         DECIMAL(10,2),
   rm122         DECIMAL(10,2),
   rm123         DECIMAL(10,2),
   rm124         DECIMAL(10,2),
   rm125         DECIMAL(10,2),
   fic          INT
);
prcpred;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_'.$uctsys."_stl".$sqlt;
$ulozene = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_".$uctsys."_stl"." SELECT ".
"dok,hod,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0".
" FROM F$kli_vxcf"."_".$uctsys.
" WHERE cpl > 0";
$dsql = mysql_query("$dsqlt");


if( $copern > 50 AND $drupoh == 31 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET dok=104 WHERE dok=994 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET dok=105 WHERE dok=995 "; $dsql = mysql_query("$dsqlt");
}

if( $copern > 50 AND $drupoh == 32 )
{
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET dok=111 WHERE dok=991 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET dok=112 WHERE dok=992 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET dok=113 WHERE dok=993 "; $dsql = mysql_query("$dsqlt");
}


$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm00=hod WHERE dok=00 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm01=hod WHERE dok=01 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm02=hod WHERE dok=02 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm03=hod WHERE dok=03 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm04=hod WHERE dok=04 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm05=hod WHERE dok=05 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm06=hod WHERE dok=06 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm07=hod WHERE dok=07 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm08=hod WHERE dok=08 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm09=hod WHERE dok=09 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm10=hod WHERE dok=10 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm11=hod WHERE dok=11 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm12=hod WHERE dok=12 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm13=hod WHERE dok=13 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm14=hod WHERE dok=14 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm15=hod WHERE dok=15 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm16=hod WHERE dok=16 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm17=hod WHERE dok=17 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm18=hod WHERE dok=18 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm19=hod WHERE dok=19 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm20=hod WHERE dok=20 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm21=hod WHERE dok=21 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm22=hod WHERE dok=22 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm23=hod WHERE dok=23 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm24=hod WHERE dok=24 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm25=hod WHERE dok=25 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm26=hod WHERE dok=26 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm27=hod WHERE dok=27 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm28=hod WHERE dok=28 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm29=hod WHERE dok=29 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm30=hod WHERE dok=30 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm31=hod WHERE dok=31 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm32=hod WHERE dok=32 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm33=hod WHERE dok=33 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm34=hod WHERE dok=34 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm35=hod WHERE dok=35 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm36=hod WHERE dok=36 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm37=hod WHERE dok=37 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm38=hod WHERE dok=38 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm39=hod WHERE dok=39 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm40=hod WHERE dok=40 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm41=hod WHERE dok=41 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm42=hod WHERE dok=42 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm43=hod WHERE dok=43 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm44=hod WHERE dok=44 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm45=hod WHERE dok=45 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm46=hod WHERE dok=46 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm47=hod WHERE dok=47 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm48=hod WHERE dok=48 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm49=hod WHERE dok=49 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm50=hod WHERE dok=50 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm51=hod WHERE dok=51 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm52=hod WHERE dok=52 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm53=hod WHERE dok=53 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm54=hod WHERE dok=54 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm55=hod WHERE dok=55 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm56=hod WHERE dok=56 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm57=hod WHERE dok=57 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm58=hod WHERE dok=58 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm59=hod WHERE dok=59 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm60=hod WHERE dok=60 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm61=hod WHERE dok=61 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm62=hod WHERE dok=62 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm63=hod WHERE dok=63 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm64=hod WHERE dok=64 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm65=hod WHERE dok=65 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm66=hod WHERE dok=66 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm67=hod WHERE dok=67 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm68=hod WHERE dok=68 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm69=hod WHERE dok=69 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm70=hod WHERE dok=70 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm71=hod WHERE dok=71 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm72=hod WHERE dok=72 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm73=hod WHERE dok=73 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm74=hod WHERE dok=74 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm75=hod WHERE dok=75 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm76=hod WHERE dok=76 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm77=hod WHERE dok=77 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm78=hod WHERE dok=78 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm79=hod WHERE dok=79 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm80=hod WHERE dok=80 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm81=hod WHERE dok=81 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm82=hod WHERE dok=82 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm83=hod WHERE dok=83 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm84=hod WHERE dok=84 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm85=hod WHERE dok=85 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm86=hod WHERE dok=86 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm87=hod WHERE dok=87 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm88=hod WHERE dok=88 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm89=hod WHERE dok=89 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm90=hod WHERE dok=90 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm91=hod WHERE dok=91 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm92=hod WHERE dok=92 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm93=hod WHERE dok=93 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm94=hod WHERE dok=94 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm95=hod WHERE dok=95 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm96=hod WHERE dok=96 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm97=hod WHERE dok=97 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm98=hod WHERE dok=98 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm99=hod WHERE dok=99 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm100=hod WHERE dok=100 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm101=hod WHERE dok=101 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm102=hod WHERE dok=102 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm103=hod WHERE dok=103 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm104=hod WHERE dok=104 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm105=hod WHERE dok=105 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm106=hod WHERE dok=106 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm107=hod WHERE dok=107 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm108=hod WHERE dok=108 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm109=hod WHERE dok=109 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm110=hod WHERE dok=110 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm111=hod WHERE dok=111 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm112=hod WHERE dok=112 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm113=hod WHERE dok=113 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm114=hod WHERE dok=114 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm115=hod WHERE dok=115 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm116=hod WHERE dok=116 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm117=hod WHERE dok=117 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm118=hod WHERE dok=118 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm119=hod WHERE dok=119 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm120=hod WHERE dok=120 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm121=hod WHERE dok=121 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm122=hod WHERE dok=122 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm123=hod WHERE dok=123 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm124=hod WHERE dok=124 "; $dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_".$uctsys."_stl"." SET rm125=hod WHERE dok=125 "; $dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_".$uctsys."_stl"." SELECT ".
"0,0,".
"SUM(rm01),SUM(rm02),SUM(rm03),SUM(rm04),SUM(rm05),SUM(rm06),SUM(rm07),SUM(rm08),SUM(rm09),SUM(rm10),".
"SUM(rm11),SUM(rm12),SUM(rm13),SUM(rm14),SUM(rm15),SUM(rm16),SUM(rm17),SUM(rm18),SUM(rm19),SUM(rm20),".
"SUM(rm21),SUM(rm22),SUM(rm23),SUM(rm24),SUM(rm25),SUM(rm26),SUM(rm27),SUM(rm28),SUM(rm29),SUM(rm30),".
"SUM(rm31),SUM(rm32),SUM(rm33),SUM(rm34),SUM(rm35),SUM(rm36),SUM(rm37),SUM(rm38),SUM(rm39),SUM(rm40),".
"SUM(rm41),SUM(rm42),SUM(rm43),SUM(rm44),SUM(rm45),SUM(rm46),SUM(rm47),SUM(rm48),SUM(rm49),SUM(rm50),".
"SUM(rm51),SUM(rm52),SUM(rm53),SUM(rm54),SUM(rm55),SUM(rm56),SUM(rm57),SUM(rm58),SUM(rm59),SUM(rm60),".
"SUM(rm61),SUM(rm62),SUM(rm63),SUM(rm64),SUM(rm65),SUM(rm66),SUM(rm67),SUM(rm68),SUM(rm69),SUM(rm70),".
"SUM(rm71),SUM(rm72),SUM(rm73),SUM(rm74),SUM(rm75),SUM(rm76),SUM(rm77),SUM(rm78),SUM(rm79),SUM(rm80),".
"SUM(rm81),SUM(rm82),SUM(rm83),SUM(rm84),SUM(rm85),SUM(rm86),SUM(rm87),SUM(rm88),SUM(rm89),SUM(rm90),".
"SUM(rm91),SUM(rm92),SUM(rm93),SUM(rm94),SUM(rm95),SUM(rm96),SUM(rm97),SUM(rm98),SUM(rm99),SUM(rm100),".
"SUM(rm101),SUM(rm102),SUM(rm103),SUM(rm104),SUM(rm105),SUM(rm106),SUM(rm107),SUM(rm108),SUM(rm109),SUM(rm110),".
"SUM(rm111),SUM(rm112),SUM(rm113),SUM(rm114),SUM(rm115),SUM(rm116),SUM(rm117),SUM(rm118),SUM(rm119),SUM(rm120),SUM(rm121),SUM(rm122),SUM(rm123),SUM(rm124),SUM(rm125),".
"1".
" FROM F$kli_vxcf"."_".$uctsys."_stl".
" WHERE fic = 0".
" GROUP BY fic".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_".$uctsys."_stl"." WHERE fic=0 "; $dsql = mysql_query("$dsqlt");

}
//koniec nastavenia poc.stavov


//import z ../import/FIR$kli_vxcf/UCT_POH.CSV
    if ( $copern == 55 )
    {
$UCT_POH="UCT_POH";
if( $drupoh == 1 )
{
$UCT_POH="UCT_MZD";
}
if( $drupoh == 2 )
{
$UCT_POH="UCT_MAJ";
}
if( $drupoh == 3 )
{
$UCT_POH="UCT_SKL";
}
if( $drupoh == 8 )
{
$UCT_POH="UHR_POC";
}

$odkial="../import/FIR".$kli_vxcf."/";

if( $drupoh == 11 )
{
$UCT_POH="uctvzordok".$kli_vrok;
$odkial="../import/";
}
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru <?php echo $odkial; ?><?php echo $UCT_POH; ?>.csv ?") )
         { window.close()  }
else
         { location.href='oprsys.php?copern=56&page=1&drupoh=<?php echo $drupoh;?>'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$UCT_POH="UCT_POH";
if( $drupoh == 1 )
{
$UCT_POH="UCT_MZD";
}
if( $drupoh == 2 )
{
$UCT_POH="UCT_MAJ";
}
if( $drupoh == 3 )
{
$UCT_POH="UCT_SKL";
}
if( $drupoh == 8 )
{
$UCT_POH="UHR_POC";
}

$odkial="../import/FIR".$kli_vxcf."/";

if( $drupoh == 11 )
{
$UCT_POH="uctvzordok".$kli_vrok;
$odkial="../import/";
}


$suborxx=$odkial.$UCT_POH.".csv";
if( file_exists("$suborxx")) echo "S˙bor ".$suborxx." existuje<br />";

$subor = fopen("$suborxx", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_ume = $pole[0];
  $x_dat= $pole[1];
  $x_dok = $pole[2];
  $x_ucm = $pole[3];
  $x_ucd = $pole[4];
  $x_rdp = $pole[5];
  $x_ico = $pole[6];
  $x_fak = $pole[7];
  $x_str = $pole[8];
  $x_zak = $pole[9];
  $x_hod = $pole[10];
  $x_pop = $pole[11];
  $x_kon = $pole[12];
 
$c_str=1*$x_str;
$c_hod=1*$x_hod;
$sql_dat=SqlDatum($x_dat);

if( $x_dok != 0 AND $drupoh == 11 )
{
$sqult = "INSERT INTO F$kli_vxcf"."_$uctsys ( ume,dat,dok,ucm,ucd,rdp,ico,fak,str,zak,hod,pop,id )".
" VALUES ( '$x_ume', '$sql_dat', '$x_dok', '$x_ucm', '$x_ucd', '$x_rdp', '$x_ico', '$x_fak', '$x_str', '$x_zak', '$x_hod', '$x_pop', $kli_uzid ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_$uctsys!"." naimportovan· <br />";

fclose ($subor);
$copern=308;
    }
//koniec nacitania pohybov



//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r ˙Ëtovn˝ch pohybov ?") )
         { window.close()  }
else
         { location.href='oprsys.php?copern=167&page=1&drupoh=<?php echo $drupoh;?>'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=308;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_'.$uctsys;
$vysledok = mysql_query("$sqlt");
echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_$uctsys!"." vynulovan· <br />";
    }



//vymazanie nosneho
if ( $copern == 316 )
    {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 

$copern=308;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania nosneho

//ulozenie noveho nosneho
if ( $copern == 315 AND $uprav != 1  )
    {
$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_dok = strip_tags($_REQUEST['h_dok']);
$h_rdp = strip_tags($_REQUEST['h_rdp']);
$h_fak = strip_tags($_REQUEST['h_fak']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_hod = strip_tags($_REQUEST['h_hod']);
$h_pop = strip_tags($_REQUEST['h_pop']);
$h_poh = strip_tags($_REQUEST['h_poh']);

$umes=$h_obdp.".".$kli_vrok;
$dats=$kli_vrok."-".$h_obdp."-01";
if( $drupoh == 43 OR $drupoh == 45 OR $drupoh == 46 ) { $umes = strip_tags($_REQUEST['h_ume']); $dats="0000-00-00"; }

if( $drupoh <= 11 )
{
$umes = strip_tags($_REQUEST['h_ume']);
$dats = strip_tags($_REQUEST['h_dat']);
$dats=SqlDatum($dats);
}

$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok,ume,dat,ucm,ucd,rdp,ico,fak,str,zak,hod,pop,poh ) ".
" VALUES ( '$h_dok', '$umes' , '$dats', '$h_ucm' , '$h_ucd' , '$h_rdp' , '$h_ico' , '$h_fak' , '$h_str' , '$h_zak' , '$h_hod' , '$h_pop' , '$h_poh'  ); "; 

//echo $ulozttt;

$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;

if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia nosneho

//uprava polozky
if ( $copern == 315 AND $uprav == 1 )
    {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$uprav_cpl = 1*strip_tags($_REQUEST['uprav_cpl']);

$h_ucm = strip_tags($_REQUEST['h_ucm']);
$h_ucd = strip_tags($_REQUEST['h_ucd']);
$h_dok = strip_tags($_REQUEST['h_dok']);
$h_rdp = strip_tags($_REQUEST['h_rdp']);
$h_fak = strip_tags($_REQUEST['h_fak']);
$h_ico = strip_tags($_REQUEST['h_ico']);
$h_str = strip_tags($_REQUEST['h_str']);
$h_zak = strip_tags($_REQUEST['h_zak']);
$h_hod = strip_tags($_REQUEST['h_hod']);
$h_pop = strip_tags($_REQUEST['h_pop']);
$h_poh = strip_tags($_REQUEST['h_poh']);

$umes=$h_obdp.".".$kli_vrok;
$dats=$kli_vrok."-".$h_obdp."-01";
if( $drupoh == 43 ) { $umes = strip_tags($_REQUEST['h_ume']); $dats="0000-00-00"; }

if( $drupoh <= 11 )
{
$umes = strip_tags($_REQUEST['h_ume']);
$dats = strip_tags($_REQUEST['h_dat']);
$dats=SqlDatum($dats);
}

$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( dok,ume,dat,ucm,ucd,rdp,ico,fak,str,zak,hod,pop,poh ) ".
" VALUES ( '$h_dok', '$umes', '$dats', '$h_ucm' , '$h_ucd' , '$h_rdp' , '$h_ico' , '$h_fak' , '$h_str' , '$h_zak' , '$h_hod' , '$h_pop' , '$h_poh'  ); ";
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava nosneho

//308=uprava ak uz existuje
if ( $copern == 308 AND $uprav == 1 )
      {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_ume = $riadok->ume;
$h_ucm = $riadok->ucm;
$h_ucd = $riadok->ucd;
$h_dok = $riadok->dok;
$h_rdp = $riadok->rdp;
$h_fak = $riadok->fak;
$h_ico = $riadok->ico;
$h_str = $riadok->str;
$h_zak = $riadok->zak;
$h_hod = $riadok->hod;
$h_pop = $riadok->pop;
$h_poh = $riadok->poh;

if( $drupoh <= 11 )
{
$h_datsk = $riadok->dat;
$h_datsk=SkDatum($h_datsk);
}

  }

$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 

       }

//koniec uprava nacitanie

?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>⁄prava d·t z podsystÈmov</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }


<?php
//ciselnik druhov vyrobkov,nosny,rozperny,oko,lem
  if ( $copern > 200 AND $copern < 699 )
  {
?>

    function VyberVstup()
    {
    <?php if ( $copern > 300 AND $copern < 399 AND $drupoh <= 20 ) { echo "document.formv1.h_ume.focus();"; } ?>
    <?php if ( $copern > 300 AND $copern < 399 AND $drupoh > 20 AND $drupoh < 40 ) { echo "document.formv1.h_dok.focus();"; } ?>
    document.formv1.uloz.disabled = true;
    <?php if ( $drupoh < 20 ) { echo "document.forms.formhk1.h_obdp.value='$h_obdp';"; } ?>
    <?php if ( $drupoh < 20 ) { echo "document.forms.formhk1.h_obdk.value='$h_obdk';"; } ?>
    }

    function ObnovUI()
    {

    <?php if( $copern == 308 AND $uprav == 1 ) { ?>
    document.formv1.h_dok.value = '<?php echo "$h_dok";?>';
    document.formv1.h_ucm.value = '<?php echo "$h_ucm";?>';
    document.formv1.h_ucd.value = '<?php echo "$h_ucd";?>';
    document.formv1.h_rdp.value = '<?php echo "$h_rdp";?>';
    document.formv1.h_fak.value = '<?php echo "$h_fak";?>';
    document.formv1.h_ico.value = '<?php echo "$h_ico";?>';
    document.formv1.h_str.value = '<?php echo "$h_str";?>';
    document.formv1.h_zak.value = '<?php echo "$h_zak";?>';
    document.formv1.h_hod.value = '<?php echo "$h_hod";?>';
    document.formv1.h_pop.value = '<?php echo "$h_pop";?>';
    document.formv1.h_poh.value = '<?php echo "$h_poh";?>';
    <?php                    } ?>
    <?php if( $copern == 308 AND $uprav == 1 AND $drupoh == 43) { ?>
    document.formv1.h_ume.value = '<?php echo "$h_ume";?>';
    <?php                    } ?>
    <?php if( $copern == 308 AND $uprav == 1 AND $drupoh <= 11 ) { ?>
    document.formv1.h_dat.value = '<?php echo "$h_datsk";?>';
    document.formv1.h_ume.value = '<?php echo "$h_ume";?>';
    <?php                    } ?>
    }

    function Povol_uloz()
    {
    var okvstup=1;

<?php if ( $copern > 300 AND $copern < 399 AND $drupoh != 43 AND $drupoh != 44 AND $drupoh != 45 AND $drupoh != 46 ) { ?>
    if ( document.formv1.h_hod.value == '' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 300 AND $copern < 399 AND $drupoh == 43 ) { ?>
    if ( document.formv1.h_dok.value == '' ) okvstup=0;
    if ( document.formv1.h_dok.value == '0' ) okvstup=0;
    if ( document.formv1.h_poh.value == '' ) okvstup=0;
    if ( document.formv1.h_poh.value == '0' ) okvstup=0;
    if ( document.formv1.h_ume.value == '' ) okvstup=0;
    if ( document.formv1.h_ume.value == '0' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 300 AND $copern < 399 AND $drupoh == 44 ) { ?>
    if ( document.formv1.h_dok.value == '' ) okvstup=0;
    if ( document.formv1.h_dok.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '0' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 300 AND $copern < 399 AND $drupoh == 45 ) { ?>
    if ( document.formv1.h_ume.value == '' ) okvstup=0;
    if ( document.formv1.h_ume.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '0' ) okvstup=0;
<?php                                        } ?>

<?php if ( $copern > 300 AND $copern < 399 AND $drupoh == 46 ) { ?>
    if ( document.formv1.h_ume.value == '' ) okvstup=0;
    if ( document.formv1.h_ume.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '0' ) okvstup=0;
    if ( document.formv1.h_dok.value == '' ) okvstup=0;
    if ( document.formv1.h_dok.value == '0' ) okvstup=0;
    if ( document.formv1.h_hod.value == '' ) okvstup=0;
    if ( document.formv1.h_hod.value == '0' ) okvstup=0;
<?php                                        } ?>

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false); }

    }

<?php
/////////////////////////////////////////////////////////////uprava dat z podsystemov
        if( $drupoh < 20  )           { ?>

function UmeEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_dat.focus();
        document.formv1.h_dat.select();
              }
                }
function DatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_dok.focus();
        document.formv1.h_dok.select();
              }
                }


function DokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_ucm.focus();
        document.formv1.h_ucm.select();
              }
                }


function UcmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_ucd.focus();
        document.formv1.h_ucd.select();
              }
                }

function UcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_rdp.focus();
        document.formv1.h_rdp.select();
              }
                }


function RdpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_fak.focus();
        document.formv1.h_fak.select();
              }
                }

function FakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_ico.focus();
        document.formv1.h_ico.select();
              }
                }


function IcoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_str.focus();
        document.formv1.h_str.select();
              }
                }

function StrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_zak.focus();
        document.formv1.h_zak.select();
              }
                }

function ZakEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_pop.focus();
        document.formv1.h_pop.select();
              }
                }

function PopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_hod.focus();
        document.formv1.h_hod.select();
              }
                }

function HodEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

    if ( document.formv1.h_hod.value == '' ) okvstup=0;
    if ( document.formv1.h_hod.value == '0' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
    if ( okvstup == 0 && document.formv1.h_hod.value == '' ) { document.formv1.h_hod.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_hod.value == '0' ) { document.formv1.h_hod.focus(); return (false); }
              }
                }

<?php
/////////////////////////////////////////////////////////////koniec uprava dat z podsystemov
                                     } ?>

<?php
/////////////////////////////////////////////////////////////uprava pociatocnych stavov
        if( $drupoh > 20 AND $drupoh != 43 AND $drupoh != 44 AND $drupoh != 45 AND $drupoh != 46 )           { ?>

function DokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_hod.focus();
        document.formv1.h_hod.select();
              }
                }


function HodEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

    if ( document.formv1.h_hod.value == '' ) okvstup=0;
    if ( document.formv1.h_hod.value == '0' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
    if ( okvstup == 0 && document.formv1.h_hod.value == '' ) { document.formv1.h_hod.focus(); return (false); }
    if ( okvstup == 0 && document.formv1.h_hod.value == '0' ) { document.formv1.h_hod.focus(); return (false); }
              }
                }

<?php
/////////////////////////////////////////////////////////////koniec uprava poc.stavov
                                     } ?>

<?php
/////////////////////////////////////////////////////////////uprava jcd
        if( $drupoh == 43  )           { ?>

function DokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_poh.focus();
        document.formv1.h_poh.select();
              }
                }

function PohEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_ume.focus();
        document.formv1.h_ume.select();
              }
                }

function UmeEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

    if ( document.formv1.h_dok.value == '' ) okvstup=0;
    if ( document.formv1.h_dok.value == '0' ) okvstup=0;
    if ( document.formv1.h_poh.value == '' ) okvstup=0;
    if ( document.formv1.h_poh.value == '0' ) okvstup=0;
    if ( document.formv1.h_ume.value == '' ) okvstup=0;
    if ( document.formv1.h_ume.value == '0' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
    if ( okvstup == 0 ) { document.formv1.h_dok.focus(); return (false); }
              }
                }

<?php
/////////////////////////////////////////////////////////////koniec uprava jcd
                                     } ?>

<?php
/////////////////////////////////////////////////////////////uprava syngensuv
        if( $drupoh == 43  )           { ?>

function DokEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_ucm.focus();
        document.formv1.h_ucm.select();
              }
                }

function UcmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){
        document.formv1.h_ucd.focus();
        document.formv1.h_ucd.select();
              }
                }

function UcdEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy

  if(k == 13 ){

    var okvstup=1;

    if ( document.formv1.h_dok.value == '' ) okvstup=0;
    if ( document.formv1.h_dok.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '' ) okvstup=0;
    if ( document.formv1.h_ucm.value == '0' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '' ) okvstup=0;
    if ( document.formv1.h_ucd.value == '0' ) okvstup=0;

    if ( okvstup == 1 ) { document.forms.formv1.submit(); return (true); }
    if ( okvstup == 0 ) { document.formv1.h_dok.focus(); return (false); }
              }
                }

<?php
/////////////////////////////////////////////////////////////koniec syngensuv
                                     } ?>

<?php
  }
//koniec oprava podsystemu
?>

<?php
//ciselnik druhov vyrobkov,nosny,rozperny,oko,lem
  if ( $copern < 300 )
  {
?>

    function VyberVstup()
    {

    }

    function ObnovUI()
    {


    }


<?php
  }
//koniec oprava podsystemu
?>


function HladajUme()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/oprsys.php?copern=308&page=1&sysx=UCT&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + '&drupoh=<?php echo $drupoh; ?>',
 '_self' );
                }

function ZmazPolozku(cpl)
                {
var cislo_cpl = cpl;
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/oprsys.php?copern=316&page=1&sysx=UCT&cislo_cpl=' + cislo_cpl + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + '&drupoh=<?php echo $drupoh; ?>&uprav=0',
 '_self' );
                }

function UpravPolozku(cpl)
                {
var cislo_cpl = cpl;
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/oprsys.php?copern=308&page=1&sysx=UCT&uprav_cpl=' + cislo_cpl + '&cislo_cpl=' + cislo_cpl + '&h_obdk=' + h_obdk + '&h_obdp=' + h_obdp + '&drupoh=<?php echo $drupoh; ?>&uprav=1',
 '_self' );
                }

function ZostavaDok()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/oprsys.php?copern=361&page=1&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=<?php echo $drupoh; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZostavaUce()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/oprsys.php?copern=362&page=1&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=<?php echo $drupoh; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZostavaUceNak()
                {
var h_obdp = document.forms.formhk1.h_obdp.value;
var h_obdk = document.forms.formhk1.h_obdk.value;

window.open('../ucto/oprsys.php?copern=362&page=1&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&drupoh=<?php echo $drupoh; ?>&ucenak=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function NacitajFaktury()
                {

var h_obdp = document.forms.formct1.h_obdp.value;
var h_sys = document.forms.formct1.h_sys.value;

window.open('../ucto/ext_fakt.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ZoberFaktury()
                {
<?php if( $medo == 0 AND $berext == 0 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>
<?php if( $medo == 1 AND $kli_vrok == 2012 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2012medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $medo == 1 AND $kli_vrok == 2013 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2013medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $medo == 1 AND $kli_vrok == 2014 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2014medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $medo == 1 AND $kli_vrok == 2015 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2015medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $medo == 1 AND $kli_vrok == 2016 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2016medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $medo == 1 AND $kli_vrok == 2017 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2017medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $medo == 1 AND $kli_vrok == 2018 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2018medo.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $berext == 1 AND $kli_vrok == 2013 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2013pkse.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                       } ?>

<?php if( $berext == 1 AND $kli_vrok == 2014 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2014pkse.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                          } ?>

<?php if( $berext == 1 AND $kli_vrok == 2015 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2015pkse.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                          } ?>

<?php if( $berext == 1 AND $kli_vrok == 2016 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2016pkse.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                          } ?>

<?php if( $berext == 1 AND $kli_vrok == 2017 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2017pkse.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                          } ?>


<?php if( $berext == 1 AND $kli_vrok == 2018 ) { ?>
var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../faktury/int_fakt2018pkse.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
<?php                                          } ?>


                }

function ZablokujFaktury()
                {

var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../ucto/oprsys.php?copern=2166&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OdblokujFaktury()
                {

var h_obdp = document.forms.formct2.h_obdp.value;
var h_sys = document.forms.formct2.h_sys.value;

window.open('../ucto/oprsys.php?copern=2177&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  function PocUhrad()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=308&drupoh=8&page=1","_self" );
  }

  function PocOdber()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=308&drupoh=7&page=1","_self" );
  }

  function PocDodav()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=308&drupoh=6&page=1","_self" );
  }
  
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI(); VyberVstup();" >



<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php if( $drupoh == 1 AND $copern == 1 ) { echo " PodsystÈmy"; } ?>
<?php if( $drupoh == 1 AND $copern != 1 ) { echo " PodsystÈm MZDY"; } ?>
<?php if( $drupoh == 2 ) { echo " PodsystÈm DLHODOB› MAJETOK"; } ?>
<?php if( $drupoh == 3 ) { echo " PodsystÈm SKLAD,Z¡SOBY"; } ?>
<?php if( $drupoh == 9 ) { echo " N·klady a v˝nosy na vozidl·"; } ?>
<?php if( $drupoh == 8 ) { echo " ⁄hrady poËiatoËn˝ stav"; } ?>
<?php if( $drupoh == 7 ) { echo " OdberateæskÈ fakt˙ry poËiatoËn˝ stav"; } ?>
<?php if( $drupoh == 6 ) { echo " Dod·vateæskÈ fakt˙ry poËiatoËn˝ stav"; } ?>
<?php if( $drupoh == 21 ) { echo " V˝kaz ziskov - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 22 ) { echo " S˙vaha - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 23 ) { echo " CASH FLOW - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 24 ) { echo " CASH FLOW v.2011 - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 28 ) { echo " Nastavenie Druh pohybu -> StÂpec peÚaûnÈho dennÌka verzia 2013"; } ?>
<?php if( $drupoh == 29 ) { echo " Nastavenie Druh pohybu -> StÂpec peÚaûnÈho dennÌka verzia 2012"; } ?>
<?php if( $drupoh == 31 ) { echo " V˝kaz ziskov NO - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 32 ) { echo " S˙vaha NO - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 41 ) { echo " V˝kaz o prÌjmoch a v˝davkoch - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 42 ) { echo " V˝kaz o majetku a z·v‰zkoch - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 43 ) { echo " ArchÌv dokladov JCD"; } ?>
<?php if( $drupoh == 44 ) { echo " SyntetickÈ generovanie s˙vahy"; } ?>
<?php if( $drupoh == 45 ) { echo " Nastavenie delen˝ch ËastÌ priemerov na n·hrady"; } ?>
<?php if( $drupoh == 46 ) { echo " Zoznam delen˝ch ËastÌ priemerov na n·hrady"; } ?>
<?php if( $drupoh == 47 ) { echo " V˝kaz o majetku a z·v‰zkoch NO JU - ⁄daje bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia"; } ?>
<?php if( $drupoh == 11 ) { echo " VzorovÈ doklady ˙Ëtovania"; } ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php
if( $copern == 1 )
           {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=3&page=1', '_blank','<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄prava ˙Ëtovania podsystÈmu SKLAD,Z¡SOBY' ></a>
</td>
<td class="bmenu" width="90%">Sklad, z·soby</td>
</tr>
</table>
<table class="vstup" width="100%" >
<FORM name="formct1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="NacitajFaktury();">
<img src='../obr/vlozit.png' width=19 height=14 border=1 title='NaËÌtaù externÈ fakt˙ry' ></a>
</td>
<td class="bmenu" width="90%">Extern˝ Odbyt,fakt˙ry

<select size="1" name="h_obdp" id="h_obdp" >
<option value="<?php echo $kli_vmes;?>" >obdobie <?php echo $kli_vume;?></option>
</select>

<select size="1" name="h_sys" id="h_sys" >
<option value="55" >SYS 55</option>
<option value="56" >SYS 56</option>
<option value="57" >SYS 57</option>
<option value="58" >SYS 58</option>
<option value="59" >SYS 59</option>
</select>
</td>

</tr>
</FORM>
</table>

<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=2&page=1', '_blank','<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄prava ˙Ëtovania podsystÈmu MAJETOK' ></a>
</td>
<td class="bmenu" width="90%">Dlhodob˝ majetok</td>
</tr>
</table>
<table class="vstup" width="100%" >
<tr><td class="bmenu" width="90%">DopravnÈ sluûby</td>
</tr>
</table>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=308&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='⁄prava ˙Ëtovania podsystÈmu MZDY' ></a>
</td>
<td class="bmenu" width="90%">Mzdy a personalistika</td>
</tr>
</table>

<?php
$jeuctovaniesluzieb=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklsluudaje WHERE xuce1 > 60000 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  if( $riaddok->xuce1 > 60000 ) { $jeuctovaniesluzieb=1; }
  }

if( $jeuctovaniesluzieb == 1 ) { 
?>

<table class="vstup" width="100%" >
<FORM name="formct2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZoberFaktury();">
<img src='../obr/vlozit.png' width=19 height=14 border=1 title='Za˙Ëtovaù fakt˙ry z podsystÈmu odbyt, fakt˙ry' ></a>
</td>
<td class="bmenu" width="90%">Odbyt,fakt˙ry

<select size="1" name="h_obdp" id="h_obdp" >
<option value="<?php echo $kli_vmes;?>" >obdobie <?php echo $kli_vume;?></option>
</select>

<select size="1" name="h_sys" id="h_sys" >
<?php if( $medo == 0 AND $berext == 0 ) { ?>
<option value="85" >SYS 85</option>
<?php                  } ?>
<?php if( $medo == 1 AND $kli_vrok == 2011 ) { ?>
<?php
$blok601="";
$blok611="";
$blok612="";
$blok613="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak601_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok601=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak611_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok611=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak612_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok612=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak613_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok613=" - BLOKOVAN…"; }

?>

<option value="601" >SYS 601 Ubytovanie <?php echo $blok601;?></option>
<option value="611" >SYS 611 ZK RohoûnÌk <?php echo $blok611;?></option>
<option value="612" >SYS 612 FastFood NM <?php echo $blok612;?></option>
<option value="613" >SYS 613 ZK VrbovÈ <?php echo $blok613;?></option>
<?php                                         } ?>

<?php if( $medo == 1 AND $kli_vrok == 2012 ) { ?>
<?php
$blok602="";
$blok621="";
$blok652="";
$blok683="";
$blok694="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak602_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok602=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak621_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok621=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak652_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok652=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak683_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok683=" - BLOKOVAN…"; }
$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak694_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok694=" - BLOKOVAN…"; }
?>

<option value="602" >SYS 602 Ubytovanie <?php echo $blok602;?></option>
<option value="621" >SYS 621 ZK RohoûnÌk <?php echo $blok621;?></option>
<option value="652" >SYS 652 FastFood NM <?php echo $blok652;?></option>
<option value="683" >SYS 683 ZK VrbovÈ <?php echo $blok683;?></option>
<option value="694" >SYS 694 FastFood SE <?php echo $blok694;?></option>
<?php                                         } ?>

<?php if( $medo == 1 AND $kli_vrok == 2013 ) { ?>
<?php
$blok603="";
$blok653="";
$blok684="";
$blok673="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak603_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok603=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak653_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok653=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak684_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok684=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak673_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok673=" - BLOKOVAN…"; }
?>

<option value="603" >SYS 603 Ubytovanie <?php echo $blok603;?></option>
<option value="653" >SYS 653 FastFood NM <?php echo $blok653;?></option>
<option value="684" >SYS 684 ZK VrbovÈ <?php echo $blok684;?></option>
<option value="673" >SYS 673 GastroBENE <?php echo $blok673;?></option>
<?php                                         } ?>
<?php if( $medo == 1 AND $kli_vrok == 2014 ) { ?>
<?php
$blok604="";
$blok654="";
$blok685="";
$blok674="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak604_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok604=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak654_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok654=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak685_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok685=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak674_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok674=" - BLOKOVAN…"; }
?>

<option value="604" >SYS 604 Ubytovanie <?php echo $blok604;?></option>
<option value="654" >SYS 654 FastFood NM <?php echo $blok654;?></option>
<option value="685" >SYS 685 ZK VrbovÈ <?php echo $blok685;?></option>
<option value="674" >SYS 674 GastroBENE <?php echo $blok674;?></option>
<?php                                         } ?>
<?php if( $medo == 1 AND $kli_vrok == 2015 ) { ?>
<?php
$blok605="";
$blok655="";
$blok686="";
$blok675="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak605_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok605=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak655_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok655=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak686_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok686=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak675_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok675=" - BLOKOVAN…"; }
?>

<option value="605" >SYS 605 Ubytovanie <?php echo $blok605;?></option>
<option value="655" >SYS 655 FastFood NM <?php echo $blok655;?></option>
<option value="686" >SYS 686 ZK VrbovÈ <?php echo $blok686;?></option>
<option value="675" >SYS 675 GastroBENE <?php echo $blok675;?></option>
<?php                                         } ?>

<?php if( $medo == 1 AND $kli_vrok == 2016 ) { ?>
<?php
$blok606="";
$blok646="";
$blok656="";
$blok687="";
$blok676="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak606_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok606=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak646_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok646=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak656_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok656=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak687_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok687=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak676_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok676=" - BLOKOVAN…"; }
?>

<option value="606" >SYS 606 Ubytovanie <?php echo $blok606;?></option>
<option value="646" >SYS 646 FastFood NM GastroBENE <?php echo $blok646;?></option>
<option value="656" >SYS 656 FastFood NM <?php echo $blok656;?></option>
<option value="687" >SYS 687 ZK VrbovÈ <?php echo $blok687;?></option>
<option value="676" >SYS 676 GastroBENE <?php echo $blok676;?></option>
<?php                                         } ?>

<?php if( $medo == 1 AND $kli_vrok == 2017 ) { ?>
<?php
$blok607="";
$blok647="";
$blok657="";
$blok677="";
$blok688="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak607_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok607=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak647_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok647=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak657_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok657=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak677_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok677=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak688_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok688=" - BLOKOVAN…"; }
?>

<option value="607" >SYS 607 Ubytovanie <?php echo $blok607;?></option>
<option value="647" >SYS 647 FastFood NM GastroBENE <?php echo $blok647;?></option>
<option value="657" >SYS 657 FastFood NM <?php echo $blok657;?></option>
<option value="677" >SYS 677 GastroBENE <?php echo $blok677;?></option>
<option value="688" >SYS 688 ZK VrbovÈ <?php echo $blok688;?></option>
<?php                                         } ?>

<?php if( $medo == 1 AND $kli_vrok == 2018 ) { ?>
<?php
$blok608="";
$blok648="";
$blok678="";
$blok689="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak608_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok608=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak648_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok648=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak678_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok678=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak689_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok689=" - BLOKOVAN…"; }
?>

<option value="608" >SYS 608 Ubytovanie <?php echo $blok608;?></option>
<option value="648" >SYS 648 FastFood NM GastroBENE <?php echo $blok648;?></option>
<option value="678" >SYS 678 GastroBENE VrbovÈ <?php echo $blok678;?></option>
<option value="689" >SYS 689 ZK VrbovÈ <?php echo $blok689;?></option>
<?php                                         } ?>

<?php if( $berext == 1 AND $kli_vrok == 2013 ) { ?>
<?php
$blok411="";
$blok412="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak411_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok411=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak412_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok412=" - BLOKOVAN…"; }

?>

<option value="411" >SYS 411 Zdrav.starostlivosù <?php echo $blok411;?></option>
<option value="412" >SYS 412 OstatnÈ <?php echo $blok412;?></option>
<?php                                         } ?>

<?php if( $berext == 1 AND $kli_vrok == 2014 ) { ?>
<?php
$blok511="";
$blok512="";
$blok514="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak511_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok511=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak512_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok512=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak514_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok514=" - BLOKOVAN…"; }

?>

<option value="511" >SYS 511 Zdrav.starostlivosù <?php echo $blok511;?></option>
<option value="512" >SYS 512 OstatnÈ <?php echo $blok512;?></option>
<option value="514" >SYS 514 N·jomnÈ <?php echo $blok514;?></option>
<?php                                         } ?>

<?php if( $berext == 1 AND $kli_vrok == 2015 ) { ?>
<?php
$blok611="";
$blok612="";
$blok614="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak611_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok611=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak612_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok612=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak614_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok614=" - BLOKOVAN…"; }

?>

<option value="611" >SYS 611 Zdrav.starostlivosù <?php echo $blok611;?></option>
<option value="612" >SYS 612 OstatnÈ <?php echo $blok612;?></option>
<option value="614" >SYS 614 N·jomnÈ <?php echo $blok614;?></option>
<?php                                         } ?>

<?php if( $berext == 1 AND $kli_vrok == 2016 ) { ?>
<?php
$blok611="";
$blok612="";
$blok614="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak711_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok711=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak712_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok712=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak714_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok714=" - BLOKOVAN…"; }

?>

<option value="711" >SYS 711 Zdrav.starostlivosù <?php echo $blok711;?></option>
<option value="712" >SYS 712 OstatnÈ <?php echo $blok712;?></option>
<option value="714" >SYS 714 N·jomnÈ <?php echo $blok714;?></option>
<?php                                         } ?>

<?php if( $berext == 1 AND $kli_vrok == 2017 ) { ?>
<?php
$blok811="";
$blok812="";
$blok814="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak811_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok811=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak812_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok812=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak814_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok814=" - BLOKOVAN…"; }

?>

<option value="811" >SYS 811 Zdrav.starostlivosù <?php echo $blok811;?></option>
<option value="812" >SYS 812 OstatnÈ <?php echo $blok812;?></option>
<option value="814" >SYS 814 N·jomnÈ <?php echo $blok814;?></option>
<?php                                         } ?>

<?php if( $berext == 1 AND $kli_vrok == 2018 ) { ?>
<?php
$blok911="";
$blok912="";
$blok914="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak911_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok911=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak912_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok912=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokfak914_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blok914=" - BLOKOVAN…"; }

?>

<option value="911" >SYS 911 Zdrav.starostlivosù <?php echo $blok911;?></option>
<option value="912" >SYS 912 OstatnÈ <?php echo $blok912;?></option>
<option value="914" >SYS 914 N·jomnÈ <?php echo $blok914;?></option>
<?php                                         } ?>

</select>
</td>

<?php if( $medo == 1 OR $berext > 0 ) { ?>

<td class="bmenu" width="4%">
<a href="#" onClick="ZablokujFaktury();">
<img src='../obr/zmaz.png' width=19 height=14 border=1 title='Zablokovaù za˙Ëtovanie fakt˙r pre nastavenÈ UME a SYS' ></a>
</td>

<td class="bmenu" width="4%">
<a href="#" onClick="OdblokujFaktury();">
<img src='../obr/ok.png' width=19 height=14 border=1 title='Odblokovaù za˙Ëtovanie fakt˙r pre nastavenÈ UME a SYS' ></a>
</td>

<?php                  } ?>

</tr>
</FORM>
</table>

<?php                           } ?>





<?php

//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx prenos pokladnice

$jeuctovaniesluziebpok=0; $pokl1=0; $pokl2=0; $pokl3=0; $pokl4=0; $cfir1=0; $cfir2=0; $cfir3=0; $cfir4=0; 
$sqlttt = "SELECT * FROM F$kli_vxcf"."_sklsluudaje WHERE ( xuce1 >= 21100 AND xuce1 <= 21199 ) OR ( xuce1 >= 211000 AND xuce1 <= 211999 ) ORDER BY xuce1 ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jeuctovaniesluziebpok=1;
  if( $i == 0 ) { $pokl1=1*$riaddok->xuce1; $cfir1=1*$riaddok->xuce2; } 
  if( $i == 1 ) { $pokl2=1*$riaddok->xuce1; $cfir2=1*$riaddok->xuce2; } 
  if( $i == 2 ) { $pokl3=1*$riaddok->xuce1; $cfir3=1*$riaddok->xuce2; } 
  if( $i == 3 ) { $pokl4=1*$riaddok->xuce1; $cfir4=1*$riaddok->xuce2; } 
  }

if( $jeuctovaniesluziebpok == 1 ) { 
?>

<table class="vstup" width="100%" >
<FORM name="formct3" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="ZoberPokladnicu();">
<img src='../obr/vlozit.png' width=19 height=14 border=1 title='Preniesù extern˙ pokladnicu' ></a>
</td>
<td class="bmenu" width="90%">Extern· pokladnica

<select size="1" name="h_obdp" id="h_obdp" >
<option value="<?php echo $kli_vmes;?>" >obdobie <?php echo $kli_vume;?></option>
</select>

<select size="1" name="h_sys" id="h_sys" >

<?php
$blokp1="";
$blokp2="";
$blokp3="";
$blokp4="";

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokpokl_".$pokl1."_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blokp1=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokpokl_".$pokl2."_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blokp2=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokpokl_".$pokl3."_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blokp3=" - BLOKOVAN…"; }

$sql = "SELECT * FROM F$kli_vxcf"."_uctblokpokl_".$pokl4."_".$h_obdp." ";
$urob = mysql_query("$sql");
if($urob) { $blokp4=" - BLOKOVAN…"; }

?>

<?php if( $pokl1 > 0 ) { ?><option value="<?php echo $pokl1;?>" ><?php echo $pokl1;?> <?php echo $blokp1;?></option><?php } ?>
<?php if( $pokl2 > 0 ) { ?><option value="<?php echo $pokl2;?>" ><?php echo $pokl2;?> <?php echo $blokp2;?></option><?php } ?>
<?php if( $pokl3 > 0 ) { ?><option value="<?php echo $pokl3;?>" ><?php echo $pokl3;?> <?php echo $blokp3;?></option><?php } ?>
<?php if( $pokl4 > 0 ) { ?><option value="<?php echo $pokl4;?>" ><?php echo $pokl4;?> <?php echo $blokp4;?></option><?php } ?>

</select>
</td>

<td class="bmenu" width="4%">
<a href="#" onClick="ZablokujPrenos();">
<img src='../obr/zmaz.png' width=19 height=14 border=1 title='Zablokovaù prenos pre nastavenÈ UME a Pokladnicu' ></a>
</td>

<td class="bmenu" width="4%">
<a href="#" onClick="OdblokujPrenos();">
<img src='../obr/ok.png' width=19 height=14 border=1 title='Odblokovaù prenos pre nastavenÈ UME a Pokladnicu' ></a>
</td>


</tr>
</FORM>
</table>
<script type="text/javascript">

function ZoberPokladnicu()
                {

var h_obdp = document.forms.formct3.h_obdp.value;
var h_sys = document.forms.formct3.h_sys.value;

window.open('../ucto/ext_pokl.php?copern=55&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function ZablokujPrenos()
                {

var h_obdp = document.forms.formct3.h_obdp.value;
var h_sys = document.forms.formct3.h_sys.value;

window.open('../ucto/oprsys.php?copern=3166&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function OdblokujPrenos()
                {

var h_obdp = document.forms.formct3.h_obdp.value;
var h_sys = document.forms.formct3.h_sys.value;

window.open('../ucto/oprsys.php?copern=3177&page=1&h_sys=' + h_sys + '&h_obdp=' + h_obdp + '&drupoh=1&uprav=1',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

  
</script>
<?php
                                } 
//xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx koniec prenos pokladnice
?>



<?php
//koniec copern=1
           }
?>

<?php
//oprava podsystemov
if ( $copern == 308 )
     {
?>

<table class="fmenu" width="100%" >

<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ ËÌslo</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù desatinnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum ???</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
</tr>

<?php
/////////////////////////////////////////////////////////////uprava dat z podsystemov
if( $drupoh < 20  )           
{

$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 AND ( ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok." ) ORDER BY cpl";
  if( $h_obdp == 100 )
  {
  $sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 AND ( ume <= $h_obdk.".$kli_vrok." ) ORDER BY cpl";
  }
  if( $h_obdk == 100 )
  {
  $sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 AND ( ume >= $h_obdp.".$kli_vrok." ) ORDER BY cpl";
  }
if( $drupoh == 11 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok,cpl";
  if( $h_obdp == 100 )
  {
  $sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok,cpl";
  }
  if( $h_obdk == 100 )
  {
  $sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok,cpl";
  }
}
if( $drupoh == 8 OR $drupoh == 7 OR $drupoh == 6 )
{
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl >= 0 ORDER BY dok,cpl";
}
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
//echo "cpol".$cpol;
$i = 0;

?>

<FORM name="formhk1" class="obyc" method="post" action="#" >

<tr>
<td class="bmenu" colspan="1">
<a href="#" onClick="ZostavaDok();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF zostava sum·r za doklad' ></a>
</td>
<td class="bmenu" colspan="1">
<a href="#" onClick="ZostavaUce();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF zostava sum·r za ˙Ëet,STR,ZAK' ></a>
</td>
<td class="bmenu" colspan="1">
<a href="#" onClick="ZostavaUceNak();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF zostava sum·r za ˙Ëet,˙Ëty 5,6 STR,ZAK' ></a>
</td>
<td class="bmenu" colspan="3"></td>
<td class="bmenu" colspan="4">
<select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
<option value="100" >od 00.0000</option>
</select>

<select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
<option value="100" >vöetko</option>
</select>
<a href="#" onClick="HladajUme();">
<img src='../obr/hladaj.png' width=20 height=15 border=0 title='Vyber za˙Ëtovanie pre vybranÈ obdobie' ></a>
</td>
</tr>
</FORM>


<?php
if ( $kli_uzall > 3000 )
  {
?>
<tr>
<td class="hmenu" colspan="10">
<td class="hmenu" ><a href='oprsys.php?copern=67&page=1&drupoh=<?php echo $drupoh;?>'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<td class="hmenu" ><a href='oprsys.php?copern=55&page=1&drupoh=<?php echo $drupoh;?>'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT"></a>
</tr>
<?php
  }
?>

<tr>
<td class="hmenu" colspan="2" >
<?php
  if ( $drupoh == 8 OR $drupoh == 7 OR $drupoh == 6 )
  {
?>
<a href="#" onClick="window.open('oprsys.php?copern=308&page=1&drupoh=8','_self' )">
UHR<img src='../obr/zoznam.png' width=15 height=15 border=0 title='⁄prava poËiatoËnÈho stavu ˙hrad' ></a>

-

<a href="#" onClick="window.open('oprsys.php?copern=308&page=1&drupoh=7','_self' )">
ODB<img src='../obr/zoznam.png' width=15 height=15 border=0 title='⁄prava poËiatoËnÈho stavu Odberateæsk˝ch fakt˙r' ></a>

-

<a href="#" onClick="window.open('oprsys.php?copern=308&page=1&drupoh=6','_self' )">
DOD<img src='../obr/zoznam.png' width=15 height=15 border=0 title='⁄prava poËiatoËnÈho stavu Dod·vateæsk˝ch fakt˙r' ></a>
<?php
  }
?>

<?php
  if ( $drupoh == 9 )
  {
?>
<a href="#" onClick="window.open('../doprava/vynnak.php?&copern=10&page=1','_blank','<?php echo $tlcswin; ?>')">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='Sum·r v˝nosov a n·kladov za mesiac <?php echo $kli_vume; ?>' ></a>
<?php
  }
?>
</td>
<td class="hmenu" colspan="2" >
<?php
  if ( $drupoh == 9 )
  {
?>
<a href="#" onClick="window.open('../doprava/vynnak.php?&copern=20&page=1','_blank','<?php echo $tlcswin; ?>')">
<img src='../obr/orig.png' width=15 height=15 border=0 title='Sum·r v˝nosov a n·kladov za 1.<?php echo $kli_vrok; ?> aû <?php echo $kli_vume; ?>' ></a>
<?php
  }
?>
</td>
</tr>

<tr><td class="hmenu" colspan="12" ></tr>
<tr>
<td class="hmenu" width="16%" >ume d·tum
<td class="hmenu" width="7%" >doklad
<td class="hmenu" width="8%" >ucm
<td class="hmenu" width="8%" >ucd
<td class="hmenu" width="4%" >drd
<td class="hmenu" width="6%" align="right" >fak
<td class="hmenu" width="6%" align="right" >ico
<td class="hmenu" width="8%" align="right" >str
<td class="hmenu" width="8%" align="right" >zak
<td class="hmenu" width="16%" >popis
<td class="hmenu" width="8%" align="right" >hodnota
<th class="hmenu" width="5%" >Edi/Del
</tr>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);

$datsk=SkDatum($riadok->dat);
?>
<tr>
<td class="fmenu" ><?php echo $riadok->ume;?> <?php echo $datsk;?></td>
<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->ucm;?></td>
<td class="fmenu" ><?php echo $riadok->ucd;?></td>
<td class="fmenu" ><?php echo $riadok->rdp;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->fak;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->ico;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->str;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->zak;?></td>
<td class="fmenu" ><?php echo $riadok->pop;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->hod;?></td>

<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="oprsys.php?copern=315&uprav=<?php echo $uprav;?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<td class="hmenu">
<input type="text" name="h_ume" id="h_ume" size="4" onclick="Fx.style.display='none';"
 onKeyDown="return UmeEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)" />
<input type="text" name="h_dat" id="h_dat" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return DatEnter(event.which)"  onkeyup="KontrolaDatum(this, Datum)" />

<td class="hmenu"><input type="text" name="h_dok" id="h_dok" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return DokEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele)" />

<td class="hmenu"><input type="text" name="h_ucm" id="h_ucm" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return UcmEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele)" />

<td class="hmenu"><input type="text" name="h_ucd" id="h_ucd" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return UcdEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele)"/>

<td class="hmenu"><input type="text" name="h_rdp" id="h_rdp" size="3" 
 onKeyDown="return RdpEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele)"/>

<td class="hmenu" align="right" ><input type="text" name="h_fak" id="h_fak" size="7" 
 onKeyDown="return FakEnter(event.which)"  onkeyup="KontrolaCisla(this, Desc)"/>

<td class="hmenu" align="right" ><input type="text" name="h_ico" id="h_ico" size="7" 
 onKeyDown="return IcoEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele)"/>

<td class="hmenu" align="right" ><input type="text" name="h_str" id="h_str" size="5" 
 onKeyDown="return StrEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele"/>

<td class="hmenu" align="right" ><input type="text" name="h_zak" id="h_zak" size="5" 
 onKeyDown="return ZakEnter(event.which)"  onkeyup="KontrolaCisla(this, Cele)"/>

<td class="hmenu"><input type="text" name="h_pop" id="h_pop" size="20" 
 onKeyDown="return PopEnter(event.which)" />

<td class="hmenu" align="right" ><input type="text" name="h_hod" id="h_hod" size="8" onclick="Fx.style.display='none';"
 onKeyDown="return HodEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)"/>

<td class="hmenu"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

<input type="hidden" name="h_poh" id="h_poh" />

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

<?php                    
////////////////////////////////////////////////////////////////koniec uprava dat z podsystemov
                            } ?>

<?php
////////////////////////////////////////////////////////////////uprava pociatocnych stavov
if( $drupoh > 20 AND $drupoh != 43 AND $drupoh != 44 AND $drupoh != 45 AND $drupoh != 46 )           
{

$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>

<?php
if( $drupoh != 28 AND $drupoh != 29 )           
  {
?>
<tr>
<td class="hmenu" width="10%" >riadok

<?php if( $drupoh == 21 OR $drupoh == 22 OR $drupoh == 23 OR $drupoh == 24 OR $drupoh == 31 OR $drupoh == 32 OR $drupoh == 42 ) { ?>
<a href="#" onClick="window.open('../ucto/oprsys.php?copern=3155&drupoh=<?php echo $drupoh; ?>&page=1', '_self'  )">
<img src='../obr/ziarovka.png' width=20 height=15 border=0 title='NaËÌtaù hodnoty bezprostredne predch·dzaj˙ceho ˙ËtovnÈho obdobia z minulÈho roku' ></a>
<?php                      } ?>

<td class="hmenu" width="10%" align="right" >hodnota
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="75%" > 
</tr>
<?php
  }
if( $drupoh == 29 OR $drupoh == 28 )           
  {
?>
<tr>
<td class="hmenu" width="10%" >Pohyb
<td class="hmenu" width="10%" align="right" >StÂpec
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="75%" align="right" > 
<a href='oprsys.php?drupoh=<?php echo $drupoh; ?>&copern=155&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Nastav ötandartn˝ ËÌselnÌk"></a>

</tr>
<?php
  }
?>
<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>

<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->hod;?></td>

<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formhk1" class="obyc" method="post" action="#" >
<input type="hidden" name="h_obdp" id="h_obdp" />
<input type="hidden" name="h_obdk" id="h_obdk" />
</FORM>

<FORM name="formv1" class="obyc" method="post" action="oprsys.php?copern=315&uprav=<?php echo $uprav;?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<input type="hidden" name="h_cpl" id="h_cpl" />

<td class="hmenu"><input type="text" name="h_dok" id="h_dok" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return DokEnter(event.which)"  onkeyup="KontrolaCisla(this, Desc)" />

<input type="hidden" name="h_ucm" id="h_ucm" />
<input type="hidden" name="h_ucd" id="h_ucd" />
<input type="hidden" name="h_rdp" id="h_rdp" />
<input type="hidden" name="h_fak" id="h_fak" />
<input type="hidden" name="h_ico" id="h_ico" />
<input type="hidden" name="h_str" id="h_str" />
<input type="hidden" name="h_zak" id="h_zak" />
<input type="hidden" name="h_pop" id="h_pop" />
<input type="hidden" name="h_poh" id="h_poh" />

<td class="hmenu" align="right" ><input type="text" name="h_hod" id="h_hod" size="8" onclick="Fx.style.display='none';"
 onKeyDown="return HodEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)"/>

<td class="hmenu" colspan="2"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

<?php                    
////////////////////////////////////////////////////////////////koniec uprava pociatocnych stavov
                            } ?>

<?php
////////////////////////////////////////////////////////////////uprava archiv jcd
if( $drupoh > 20 AND $drupoh == 43 )           
{

$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>

<?php
if( $drupoh == 43  )           
  {
?>
<tr>

<td class="hmenu" width="17%" >Doklad JCD
<td class="hmenu" width="17%" >Doklad ˙hrady
<td class="hmenu" width="17%" >UME uplatnenia
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="44%" > 
</tr>
<?php
  }
?>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>

<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->poh;?></td>
<td class="fmenu" ><?php echo $riadok->ume;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formhk1" class="obyc" method="post" action="#" >
<input type="hidden" name="h_obdp" id="h_obdp" />
<input type="hidden" name="h_obdk" id="h_obdk" />
</FORM>

<FORM name="formv1" class="obyc" method="post" action="oprsys.php?copern=315&uprav=<?php echo $uprav;?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_dok" id="h_dok" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return DokEnter(event.which)"  onkeyup="KontrolaCisla(this, Desc)" />

<td class="hmenu" ><input type="text" name="h_poh" id="h_poh" size="8" onclick="Fx.style.display='none';"
 onKeyDown="return PohEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)"/>

<td class="hmenu"><input type="text" name="h_ume" id="h_ume" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return UmeEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)" />

<input type="hidden" name="h_ucm" id="h_ucm" />
<input type="hidden" name="h_ucd" id="h_ucd" />
<input type="hidden" name="h_rdp" id="h_rdp" />
<input type="hidden" name="h_fak" id="h_fak" />
<input type="hidden" name="h_ico" id="h_ico" />
<input type="hidden" name="h_str" id="h_str" />
<input type="hidden" name="h_zak" id="h_zak" />
<input type="hidden" name="h_pop" id="h_pop" />
<input type="hidden" name="h_hod" id="h_hod" />

<td class="hmenu" colspan="2"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

<?php                    
////////////////////////////////////////////////////////////////koniec uprava archiv jcd
                            } ?>

<?php
////////////////////////////////////////////////////////////////uprava syngensuv
if( $drupoh > 20 AND $drupoh == 44 )           
{

$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>

<?php
if( $drupoh == 44 )           
  {
?>
<tr>

<td class="hmenu" width="17%" >Syntet.˙Ëet
<td class="hmenu" width="17%" >Ë.r.aktÌva
<td class="hmenu" width="17%" >Ë.r.pasÌva
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="44%" > 
</tr>
<?php
  }
?>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>

<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->ucm;?></td>
<td class="fmenu" ><?php echo $riadok->ucd;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formhk1" class="obyc" method="post" action="#" >
<input type="hidden" name="h_obdp" id="h_obdp" />
<input type="hidden" name="h_obdk" id="h_obdk" />
</FORM>

<FORM name="formv1" class="obyc" method="post" action="oprsys.php?copern=315&uprav=<?php echo $uprav;?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_dok" id="h_dok" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return DokEnter(event.which)"  onkeyup="KontrolaCisla(this, Desc)" />

<td class="hmenu" ><input type="text" name="h_ucm" id="h_ucm" size="8" onclick="Fx.style.display='none';"
 onKeyDown="return PohEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)"/>

<td class="hmenu"><input type="text" name="h_ucd" id="h_ucd" size="7" onclick="Fx.style.display='none';"
 onKeyDown="return UmeEnter(event.which)"  onkeyup="KontrolaDcisla(this, Desc)" />

<input type="hidden" name="h_poh" id="h_poh" />
<input type="hidden" name="h_ume" id="h_ume" />
<input type="hidden" name="h_rdp" id="h_rdp" />
<input type="hidden" name="h_fak" id="h_fak" />
<input type="hidden" name="h_ico" id="h_ico" />
<input type="hidden" name="h_str" id="h_str" />
<input type="hidden" name="h_zak" id="h_zak" />
<input type="hidden" name="h_pop" id="h_pop" />
<input type="hidden" name="h_hod" id="h_hod" />

<td class="hmenu" colspan="2"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

<?php                    
////////////////////////////////////////////////////////////////koniec uprava syngensuv
                            } ?>

<?php
////////////////////////////////////////////////////////////////uprava nastavenie prnah
if( $drupoh > 20 AND $drupoh == 45 )           
{

$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY ume,ucm";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>

<?php
if( $drupoh == 45 )           
  {
?>
<tr>

<td class="hmenu" width="17%" >⁄Ë.mesiac
<td class="hmenu" width="17%" >Druh mzdy
<td class="hmenu" width="17%" >Deliù na koæko ËastÌ
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="44%" > 
</tr>
<?php
  }
?>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>

<td class="fmenu" ><?php echo $riadok->ume;?></td>
<td class="fmenu" ><?php echo $riadok->ucm;?></td>
<td class="fmenu" ><?php echo $riadok->ucd;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formhk1" class="obyc" method="post" action="#" >
<input type="hidden" name="h_obdp" id="h_obdp" />
<input type="hidden" name="h_obdk" id="h_obdk" />
</FORM>

<FORM name="formv1" class="obyc" method="post" action="oprsys.php?copern=315&uprav=<?php echo $uprav;?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_ume" id="h_ume" size="7" onclick="Fx.style.display='none';" />

<td class="hmenu" ><input type="text" name="h_ucm" id="h_ucm" size="8" onclick="Fx.style.display='none';" />

<td class="hmenu"><input type="text" name="h_ucd" id="h_ucd" size="7" onclick="Fx.style.display='none';" />

<input type="hidden" name="h_poh" id="h_poh" />
<input type="hidden" name="h_dok" id="h_dok" />
<input type="hidden" name="h_rdp" id="h_rdp" />
<input type="hidden" name="h_fak" id="h_fak" />
<input type="hidden" name="h_ico" id="h_ico" />
<input type="hidden" name="h_str" id="h_str" />
<input type="hidden" name="h_zak" id="h_zak" />
<input type="hidden" name="h_pop" id="h_pop" />
<input type="hidden" name="h_hod" id="h_hod" />

<td class="hmenu" colspan="2"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

<?php                    
////////////////////////////////////////////////////////////////koniec uprava nastav delene prnah
                            } ?>

<?php
////////////////////////////////////////////////////////////////uprava napocet prnah
if( $drupoh > 20 AND $drupoh == 46 )           
{

$podmx="nosn > 0 ";
if ( $uprav == 1 ) $podmx="nosn != ".$cislo_nosn;

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY dok,ume,ucm";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>

<?php
if( $drupoh == 46 )           
  {
?>
<tr>

<td class="hmenu" width="17%" >⁄Ë.mesiac
<td class="hmenu" width="17%" >Druh mzdy
<td class="hmenu" width="17%" >Deliù na koæko ËastÌ
<td class="hmenu" width="17%" >OsË
<td class="hmenu" width="17%" >Hodnota
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="10%" > 
</tr>
<?php
  }
?>

<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>

<td class="fmenu" ><?php echo $riadok->ume;?></td>
<td class="fmenu" ><?php echo $riadok->ucm;?></td>
<td class="fmenu" ><?php echo $riadok->ucd;?></td>
<td class="fmenu" ><?php echo $riadok->dok;?></td>
<td class="fmenu" ><?php echo $riadok->hod;?></td>
<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formhk1" class="obyc" method="post" action="#" >
<input type="hidden" name="h_obdp" id="h_obdp" />
<input type="hidden" name="h_obdk" id="h_obdk" />
</FORM>

<FORM name="formv1" class="obyc" method="post" action="oprsys.php?copern=315&uprav=<?php echo $uprav;?>&h_obdk=<?php echo $h_obdk;?>
&h_obdp=<?php echo $h_obdp;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_ume" id="h_ume" size="7" onclick="Fx.style.display='none';" />

<td class="hmenu" ><input type="text" name="h_ucm" id="h_ucm" size="8" onclick="Fx.style.display='none';" />

<td class="hmenu"><input type="text" name="h_ucd" id="h_ucd" size="7" onclick="Fx.style.display='none';" />


<td class="hmenu" ><input type="text" name="h_dok" id="h_dok" size="8" onclick="Fx.style.display='none';" />

<td class="hmenu"><input type="text" name="h_hod" id="h_hod" size="7" onclick="Fx.style.display='none';" />

<input type="hidden" name="h_poh" id="h_poh" />
<input type="hidden" name="h_rdp" id="h_rdp" />
<input type="hidden" name="h_fak" id="h_fak" />
<input type="hidden" name="h_ico" id="h_ico" />
<input type="hidden" name="h_str" id="h_str" />
<input type="hidden" name="h_zak" id="h_zak" />
<input type="hidden" name="h_pop" id="h_pop" />


<td class="hmenu" colspan="2"><input type="text" name="h_ne1" id="h_ne1" size="3"  /> 

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" onclick="Fx.style.display='none';"
 id="uloz" name="uloz" value="Uloûiù" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
</tr>

<?php                    
////////////////////////////////////////////////////////////////koniec uprava napocet delene prnah
                            } ?>

</FORM>

</table>

<div id="myKompelement"></div>

<span id="New" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:lime; color:black;">
 Nepozn·m poloûku CIS v ûiadnom sklade v celom ËÌselnÌku materi·lu , hæadajte podæa n·zvu</span>


<?php
     }
//koniec uprava
?>

<?php
//zostava zauctovania za doklad
  if ( $copern == 361 )
          {
$nazsub="zauctovanie";


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   dru         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   hod         DECIMAL(10,2),
   ucm         INT(10),
   ucd         INT(10)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc2'.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc3'.$sqlt;
$vytvor = mysql_query("$vsql");

  if ( $drupoh == 1 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_uctmzd ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
                      }

  if ( $drupoh == 2 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_uctmaj ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
                      }

  if ( $drupoh == 3 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,ucm,ucd FROM F$kli_vxcf"."_uctskl ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
                      }

$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,SUM(hod),ucm,ucd FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY dok,ucm,ucd,str,zak".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 2,ume,dat,dok,ico,fak,str,zak,SUM(hod),ucm,ucd FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY dru".
"";
$dsql = mysql_query("$dsqlt");

if (File_Exists ("../tmp/$nazsub.pdf")) { $soubor = unlink("../tmp/$nazsub.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprc2 ORDER BY dru,dok,ucm,ucd,str,zak";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$pdf->SetFont('arial','',10);

$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

  if ( $j == 0 )
  {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprc2 ORDER BY dru,dok,ucm,ucd,str,zak";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);

$pdf->SetFont('arial','',10);

  if ( $drupoh == 1 ) { $pdf->Cell(140,5,"Za˙Ëtovanie podsystÈmu Mzdy","0",0,"L"); }
  if ( $drupoh == 2 ) { $pdf->Cell(140,5,"Za˙Ëtovanie podsystÈmu Dlhodob˝ majetok","0",0,"L"); }
  if ( $drupoh == 3 ) { $pdf->Cell(140,5,"Za˙Ëtovanie podsystÈmu Sklad, z·soby","0",0,"L"); }

$pdf->Cell(100,5,"ume $h_obdp.$kli_vrok / $h_obdk.$kli_vrok $kli_nxcf strana.$strana ","0",1,"R");
$pdf->Cell(20,5,"⁄Ë.mes.","1",0,"R");$pdf->Cell(20,5,"D·tum","1",0,"R");$pdf->Cell(25,5,"Doklad","1",0,"R");
$pdf->Cell(25,5,"⁄Ëet M·daù","1",0,"R");$pdf->Cell(25,5,"⁄Ëet Dal","1",0,"R");
$pdf->Cell(25,5,"I»O","1",0,"R");$pdf->Cell(25,5,"fakt˙ra","1",0,"R");$pdf->Cell(25,5,"STR","1",0,"R");$pdf->Cell(25,5,"Z¡K","1",0,"R");
$pdf->Cell(30,5,"Hodnota","1",1,"R");

$strana=$strana+1;
$pdf->SetFont('arial','',8);

  }
//koniec j=0

  if ( $rtov->dru == 1 )
  {
$pdf->Cell(20,5,"$rtov->ume","0",0,"R");$pdf->Cell(20,5,"$rtov->dat","0",0,"R");$pdf->Cell(25,5,"$rtov->dok","0",0,"R");
$pdf->Cell(25,5,"$rtov->ucm","0",0,"R");$pdf->Cell(25,5,"$rtov->ucd","0",0,"R");
$pdf->Cell(25,5,"$rtov->ico","0",0,"R");$pdf->Cell(25,5,"$rtov->fak","0",0,"R");$pdf->Cell(25,5,"$rtov->str","0",0,"R");$pdf->Cell(25,5,"$rtov->zak","0",0,"R");
$pdf->Cell(30,5,"$rtov->hod","0",1,"R");
  }

  if ( $rtov->dru == 2 )
  {
$pdf->Cell(215,5,"CELKOM vöetky doklady","1",0,"R");
$pdf->Cell(30,5,"$rtov->hod","1",1,"R");
  }

}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 ) $j=0;

  }

$pdf->Output("../tmp/$nazsub.pdf");

//koniec zauctovanie za doklad
          }


//zostava zauctovania za doklad
  if ( $copern == 362 )
          {
$nazsub="zauctovanie";


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   dru         INT,
   ume         FLOAT(8,4),
   dat         DATE,
   dok         INT,
   ico         INT,
   fak         INT,
   str         INT,
   zak         INT,
   mdt         DECIMAL(10,2),
   dal         DECIMAL(10,2),
   roz         DECIMAL(10,2),
   uce         VARCHAR(10)
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc2'.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprc3'.$sqlt;
$vytvor = mysql_query("$vsql");

  if ( $drupoh == 1 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,0,0,ucm FROM F$kli_vxcf"."_uctmzd ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,0,hod,0,ucd FROM F$kli_vxcf"."_uctmzd ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
$dsql = mysql_query("$dsqlt");
                      }

  if ( $drupoh == 2 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,0,0,ucm FROM F$kli_vxcf"."_uctmaj ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,0,hod,0,ucd FROM F$kli_vxcf"."_uctmaj ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
$dsql = mysql_query("$dsqlt");
                      }


  if ( $drupoh == 3 ) {
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,hod,0,0,ucm FROM F$kli_vxcf"."_uctskl ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc3".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,0,hod,0,ucd FROM F$kli_vxcf"."_uctskl ".
" WHERE ume >= $h_obdp.".$kli_vrok." AND ume <= $h_obdk.".$kli_vrok.
"";
$dsql = mysql_query("$dsqlt");
                      }


$ucenak = 1*$_REQUEST['ucenak'];

  if ( $ucenak == 1 ) {

$dsqlt = "UPDATE F$kli_vxcf"."_mzdprc3".
" SET str=0, zak=0 ".
" WHERE LEFT(uce,1) != 5 AND LEFT(uce,1) != 6 ".
"";
$dsql = mysql_query("$dsqlt");
                      }


$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 1,ume,dat,dok,ico,fak,str,zak,SUM(mdt),SUM(dal),0,uce FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY uce,dok,str,zak".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 2,ume,dat,dok,ico,fak,str,zak,SUM(mdt),SUM(dal),SUM(mdt-dal),uce FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY uce".
"";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdprc2".
" SELECT 2,ume,dat,dok,ico,fak,str,zak,SUM(mdt),SUM(dal),SUM(mdt-dal),99999999 FROM F$kli_vxcf"."_mzdprc3 ".
" GROUP BY dru".
"";
$dsql = mysql_query("$dsqlt");

if (File_Exists ("../tmp/$nazsub.pdf")) { $soubor = unlink("../tmp/$nazsub.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');


$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdprc2 ORDER BY uce,dru,dok,str,zak";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);


$strana=1;
$j=0;           
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
{
$rtov=mysql_fetch_object($tov);

  if ( $j == 0 )
  {

$pdf->AddPage();

$pdf->SetLeftMargin(15); 
$pdf->SetTopMargin(15); 

$pdf->SetFont('arial','',10);


  if ( $drupoh == 1 ) { $pdf->Cell(140,5,"Za˙Ëtovanie podsystÈmu Mzdy","0",0,"L"); }
  if ( $drupoh == 2 ) { $pdf->Cell(140,5,"Za˙Ëtovanie podsystÈmu Dlhodob˝ majetok","0",0,"L"); }
  if ( $drupoh == 3 ) { $pdf->Cell(140,5,"Za˙Ëtovanie podsystÈmu Sklad, z·soby","0",0,"L"); }

$pdf->Cell(125,5,"ume $h_obdp.$kli_vrok / $h_obdk.$kli_vrok $kli_nxcf strana.$strana ","0",1,"R");
$pdf->Cell(20,5,"⁄Ë.mes.","1",0,"R");$pdf->Cell(20,5,"D·tum","1",0,"R");$pdf->Cell(25,5,"Doklad","1",0,"R");
$pdf->Cell(25,5,"⁄Ëet","1",0,"R");$pdf->Cell(25,5,"M·Daù","1",0,"R");$pdf->Cell(25,5,"Dal","1",0,"R");$pdf->Cell(25,5,"M·Daù-Dal","1",0,"R");
$pdf->Cell(25,5,"I»O","1",0,"R");$pdf->Cell(25,5,"fakt˙ra","1",0,"R");$pdf->Cell(25,5,"STR","1",0,"R");$pdf->Cell(25,5,"Z¡K","1",1,"R");

$pdf->SetFont('arial','',8);

$strana=$strana+1;
$pdf->SetFont('arial','',8);

  }
//koniec j=0


  if ( $rtov->dru == 1 )
  {
$pdf->Cell(20,5,"$rtov->ume","0",0,"R");$pdf->Cell(20,5,"$rtov->dat","0",0,"R");$pdf->Cell(25,5,"$rtov->dok","0",0,"R");
$pdf->Cell(25,5,"$rtov->uce","0",0,"R");$pdf->Cell(25,5,"$rtov->mdt","0",0,"R");$pdf->Cell(25,5,"$rtov->dal","0",0,"R");$pdf->Cell(25,5,"","0",0,"R");
$pdf->Cell(25,5,"$rtov->ico","0",0,"R");$pdf->Cell(25,5,"$rtov->fak","0",0,"R");$pdf->Cell(25,5,"$rtov->str","0",0,"R");
$pdf->Cell(25,5,"$rtov->zak","0",1,"R");

  }

  if ( $rtov->dru == 2 AND $rtov->uce != 99999999 )
  {
$pdf->Cell(90,5,"CELKOM ˙Ëet $rtov->uce","1",0,"R");
$pdf->Cell(25,5,"$rtov->mdt","1",0,"R");$pdf->Cell(25,5,"$rtov->dal","1",0,"R");$pdf->Cell(25,5,"$rtov->roz","1",1,"R");
  }

  if ( $rtov->dru == 2 AND $rtov->uce == 99999999 )
  {
$pdf->Cell(90,5,"CELKOM vöetky ˙Ëty","1",0,"R");
$pdf->Cell(25,5,"$rtov->mdt","1",0,"R");$pdf->Cell(25,5,"$rtov->dal","1",0,"R");$pdf->Cell(25,5,"$rtov->roz","1",1,"R");
  }

}
$i = $i + 1;
$j = $j + 1;
if( $j > 30 ) $j=0;
  }

$pdf->Output("../tmp/$nazsub.pdf");

//koniec zauctovanie za ucet
          }


  if ( $copern == 361 OR $copern == 362 )
          {
?>

<script type="text/javascript">
  var okno = window.open("../tmp/<?php echo $nazsub; ?>.pdf","_self");
</script>

<?php
          }
//koniec rozuctovania 


// celkovy koniec dokumentu
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc2';
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprc3';
$vysledok = mysql_query("$sqlt");

if ( $drupoh < 20 )  { 
$zmenume=1; $odkaz="../ucto/oprsys.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("uct_lista.php"); }

       } while (false);
?>
</BODY>
</HTML>
