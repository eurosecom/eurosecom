<HTML>
<?php

do
{
$sys = 'UCT';
$urov = 2000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$tis = $_REQUEST['tis'];
if(!isset($tis)) $tis = 0;
$fort = $_REQUEST['fort'];
if(!isset($fort)) $fort = 1;


$cslm=100440;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$cislo_ume = $_REQUEST['cislo_ume'];
$cislo_druh = $_REQUEST['cislo_druh'];
$cislo_stvrt = 1*$_REQUEST['cislo_stvrt'];
$cislo_cpid = 1*$_REQUEST['cislo_cpid'];

$subor = $_REQUEST['subor'];
$prepoc = 1*$_REQUEST['prepoc'];
$odpoc = 1*$_REQUEST['odpoc'];

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//ak existuje ../import/zozicdph01x1.csv  a  ../import/zozicdph01x2.csv nacitaj na 2x
$oddelcsv=0;
if( file_exists("../import/zozicdph01x1.csv")) { $oddelcsv=1; }


//nacitaj zozicdph.csv
$sql = "SELECT * FROM zozicdph01";
$vysledok = mysql_query("$sql");
$cpol=0;
if( $vysledok ) { $cpol = mysql_num_rows($vysledok); }
if( $cpol < 204000 AND $oddelcsv == 0 ) 
{
$sql = "DROP TABLE zozicdph01";
$vysledek = mysql_query("$sql");
echo $cpol." ".$sql."<br />";
}
$cpolicdph=$cpol;

if( $oddelcsv == 0 ) {
$sql = "SELECT * FROM zozicdph01";
$vysledok = mysql_query("$sql"); 
if (!$vysledok)
          {

if( file_exists("../import/zozicdph01.csv")) 
        {

echo "Vytvaram tabulku zozicdph01!"."<br />";

$sqlt = <<<crs_no
(
   xicd         VARCHAR(15) not null,
   xnaz         VARCHAR(40) not null,
   xmes         VARCHAR(40) not null,
   xuli         VARCHAR(40) not null
);
crs_no;

$sql = 'CREATE TABLE zozicdph01'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/zozicdph01.csv", "r");
while (! feof($subor))
     {
//zoznamplatitelovdph;05.02.2014
//1020000003; ;SlavomÌr Duda;TovarnÈ;14
//1020000025; ;Bartolomej Janok;SaËurov;Davidovsk· 315

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_icd =  $pole[0];
  $x_naz =  $pole[2];
  $x_mes =  $pole[3];
  $x_uli =  $pole[4];
 

$c_icd=1*$x_icd;

if( $c_icd > 0 )
{
$sqult = "INSERT INTO zozicdph01 ( xicd, xnaz, xmes, xuli )".
" VALUES ( '$x_icd', '$x_naz', '$x_mes', '$x_uli' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
//koniec while

        }
//koniec existuje csv
          }
//koniec neexistuje tabulka zozicdph01
//ak oddelcsv=0
                     }

$akecsv = 1*$_REQUEST['akecsv'];
if( $oddelcsv == 1 AND $akecsv == 1 ) {

if( file_exists("../import/zozicdph01x1.csv")) 
        {

$sql = "DELETE FROM zozicdph01 ";
$vysledek = mysql_query("$sql");

$subor = fopen("../import/zozicdph01x1.csv", "r");
while (! feof($subor))
     {

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_icd =  $pole[0];
  $x_naz =  $pole[2];
  $x_mes =  $pole[3];
  $x_uli =  $pole[4];
 

$c_icd=1*$x_icd;

if( $c_icd > 0 )
{
$sqult = "INSERT INTO zozicdph01 ( xicd, xnaz, xmes, xuli )".
" VALUES ( '$x_icd', '$x_naz', '$x_mes', '$x_uli' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
//koniec while

fclose ($subor);
        }
//koniec existuje csv

//ak oddelcsv=1 akecsv=1
                     }

if( $oddelcsv == 1 AND $akecsv == 2 ) {
if( file_exists("../import/zozicdph01x2.csv")) 
        {

$subor = fopen("../import/zozicdph01x2.csv", "r");
while (! feof($subor))
     {

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_icd =  $pole[0];
  $x_naz =  $pole[2];
  $x_mes =  $pole[3];
  $x_uli =  $pole[4];
 

$c_icd=1*$x_icd;

if( $c_icd > 0 )
{
$sqult = "INSERT INTO zozicdph01 ( xicd, xnaz, xmes, xuli )".
" VALUES ( '$x_icd', '$x_naz', '$x_mes', '$x_uli' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
//koniec while

fclose ($subor);
        }

//koniec neexistuje tabulka zozicdph01
//ak oddelcsv=1 akecsv=2
                     }


//dopln zozicdph k 20032014
$sql = "SELECT * FROM zozicdph01new20032014 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

//echo "idem";

if( file_exists("../import/zozicdph_plus140320.csv")) 
        {
$subor = fopen("../import/zozicdph_plus140320.csv", "r");
while (! feof($subor))
     {
//1011111111; ;SlavomÌr Duda;TovarnÈ;14
//1022222222; ;Bartolomej Janok;SaËurov;Davidovsk· 315
//1099999999; ;Mari·n Bratko;Matiaöka;13

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_icd =  $pole[0];
  $x_naz =  $pole[2];
  $x_mes =  $pole[3];
  $x_uli =  $pole[4];

$jeicd=0;
if( $jeicd == 1111 )
  {
$sqlttt = "SELECT * FROM zozicdph01 WHERE xicd = '$x_icd' ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jeicd=1;
  }
if( $jeicd == 1 )
    {
echo $x_icd.";;".$x_naz.";".$x_mes.";".$x_uli."<br />";

    }
  } 

$c_icd=1*$x_icd;

if( $c_icd > 0 )
{
$sqult = "INSERT INTO zozicdph01 ( xicd, xnaz, xmes, xuli )".
" VALUES ( '$x_icd', '$x_naz', '$x_mes', '$x_uli' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
//koniec while


        }
//koniec ak existuje csv

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE zozicdph01new20032014 ".$sqlt;
$vysledek = mysql_query("$sql");

}
//koniec dopln zozicdph k 20032014


//dopln zozicdph k 30052014
$sql = "SELECT * FROM zozicdph01new30052014 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

echo "dopÂÚam iËdph.";

if( file_exists("../import/zozicdph_plus140530.csv")) 
        {
$subor = fopen("../import/zozicdph_plus140530.csv", "r");
while (! feof($subor))
     {
//1011111111; ;SlavomÌr Duda;TovarnÈ;14
//1022222222; ;Bartolomej Janok;SaËurov;Davidovsk· 315
//1099999999; ;Mari·n Bratko;Matiaöka;13

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_icd =  $pole[0];
  $x_naz =  $pole[2];
  $x_mes =  $pole[3];
  $x_uli =  $pole[4];


$c_icd=1*$x_icd;

if( $c_icd > 0 )
{
$sqult = "INSERT INTO zozicdph01 ( xicd, xnaz, xmes, xuli )".
" VALUES ( '$x_icd', '$x_naz', '$x_mes', '$x_uli' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
//koniec while


        }
//koniec ak existuje csv

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE zozicdph01new30052014 ".$sqlt;
$vysledek = mysql_query("$sql");

}
//koniec dopln zozicdph k 30052014


//dopln zozicdph k 150220
$sql = "SELECT * FROM zozicdph01new150220 ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

echo "dopÂÚam iËdph.";

if( file_exists("../import/zozicdph_plus150220.csv")) 
        {
$subor = fopen("../import/zozicdph_plus150220.csv", "r");
while (! feof($subor))
     {
//1011111111;SlavomÌr Duda;TovarnÈ;
//1022222222;Bartolomej Janok;SaËurov;


  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_icd =  $pole[0];
  $x_naz =  $pole[1];
  $x_mes =  $pole[2];
  $x_uli =  $pole[3];


$c_icd=1*$x_icd;

if( $c_icd > 0 )
{
$sqult = "INSERT INTO zozicdph01 ( xicd, xnaz, xmes, xuli )".
" VALUES ( '$x_icd', '$x_naz', '$x_mes', '$x_uli' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }
//koniec while

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE zozicdph01new150220 ".$sqlt;
$vysledek = mysql_query("$sql");

        }
//koniec ak existuje csv

}
//koniec dopln zozicdph k 150220


//kontrola DU
if( $kli_vrok == 2012  )
 {
$sql = "SELECT * FROM F$kli_vxcf"."_uctnewdupobocka";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{

$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_ufir ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $danovy=$riaddok->uctt01;
  $danovyx=$riaddok->uctt01;
  }

//ak existuje ../import/obce_du.csv naimportuj obec_du
//Tabulka obec_du
$sql = "SELECT * FROM obec_du";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {

if( file_exists("../import/obce_du.csv")) 
        {

echo "Vytvaram tabulku obec_du!"."<br />";

$sqlt = <<<crs_no
(
   obec         VARCHAR(40) not null,
   obecbd       VARCHAR(40) not null,
   okres        VARCHAR(40) not null,
   pscs         VARCHAR(10) not null,
   pscsb        VARCHAR(10) not null,
   kodok        VARCHAR(10) not null,
   vuc          VARCHAR(10) not null,
   ndu          VARCHAR(30) not null
);
crs_no;

$sql = 'CREATE TABLE obec_du'.$sqlt;
$vysledek = mysql_query("$sql");

$subor = fopen("../import/obce_du.csv", "r");
while (! feof($subor))
     {
//DOBEC;OBEC;OKRES;PSC;DPOSTA;POSTA;KOD_OKR;KRAJ

  $riadok = fgets($subor, 500);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_obec =  $pole[0];
  $x_okres = $pole[2];
  $x_psc =   $pole[3];
  $x_kok =   $pole[6];
  $x_vuc =   $pole[7];
 
$x_pscb=str_replace(" ","",$x_psc);
$x_obecbd = StrTr($x_obec, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$x_obecbdlw=strtolower($x_obecbd);;

$c_kok=1*$x_kok;

if( $c_kok > 0 )
{
$sqult = "INSERT INTO obec_du ( obec,obecbd,okres,pscs,pscsb,kodok,vuc )".
" VALUES ( '$x_obec', '$x_obecbdlw', '$x_okres', '$x_psc', '$x_pscb', '$x_kok', '$x_vuc' ); "; 

$ulozene = mysql_query("$sqult"); 
}
     }

//koniec existuje csv
        }

$sqult = "UPDATE obec_du SET ndu='TREN»ÕN' WHERE LEFT(vuc,2) = 'TC' "; $ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE obec_du SET ndu='TRNAVA' WHERE LEFT(vuc,2) = 'TA' "; $ulozene = mysql_query("$sqult");
$sqult = "UPDATE obec_du SET ndu='KOäICE' WHERE LEFT(vuc,2) = 'KI' "; $ulozene = mysql_query("$sqult");
$sqult = "UPDATE obec_du SET ndu='PREäOV' WHERE LEFT(vuc,2) = 'PV' "; $ulozene = mysql_query("$sqult");
$sqult = "UPDATE obec_du SET ndu='NITRA' WHERE LEFT(vuc,2) = 'NI' "; $ulozene = mysql_query("$sqult");
$sqult = "UPDATE obec_du SET ndu='BRATISLAVA' WHERE LEFT(vuc,2) = 'BL' "; $ulozene = mysql_query("$sqult");
$sqult = "UPDATE obec_du SET ndu='éILINA' WHERE LEFT(vuc,2) = 'ZI' "; $ulozene = mysql_query("$sqult");
$sqult = "UPDATE obec_du SET ndu='BANSK¡ BYSTRICA' WHERE LEFT(vuc,2) = 'BC' "; $ulozene = mysql_query("$sqult");

          }
//koniec  nie je obec_du tabulka

//koniec ak existuje ../import/obce_du.csv naimportuj obec_du

//ak je obec_du tak prepis DU
$sql = "SELECT * FROM obec_du";
$vysledok = mysql_query("$sql");
if ($vysledok)
          {


//upravim danovy na same male a bez diakritiky
$danovybd = StrTr($danovy, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$danovy=strtolower($danovybd);

$sqldok = mysql_query("SELECT * FROM obec_du WHERE obecbd = '$danovy' ");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $danovynew=$riaddok->ndu;
  }

$sqldok = mysql_query("UPDATE F$kli_vxcf"."_ufir SET uctt01 = '$danovynew' ");

echo "Opravil som DUold ".$danovyx." na DUnew ".$danovynew.".";
//exit;

          }
//koniec ak je obec_du tak prepis DU

$sqlt = <<<vtvmzd
(
   xcf         INT,
   id          INT,
   datm        TIMESTAMP(14)
);
vtvmzd;

$sql = "CREATE TABLE F$kli_vxcf"."_uctnewdupobocka".$sqlt;
$vysledek = mysql_query("$sql");
}

 }
//koniec kontrola DU

if( $kli_vrok < 2012 )
{
$koefmin = 1*$_REQUEST['koefmin'];
$druhykoef = strip_tags($_REQUEST['druhykoef']);
?>

<script type="text/javascript">
  var okno = window.open("../ucto/archivdph.php?copern=<?php echo $copern; ?>&drupoh=<?php echo $drupoh; ?>&tis=<?php echo $tis; ?>
&fort=<?php echo $fort; ?>&subor=<?php echo $subor; ?>&prepoc=<?php echo $prepoc; ?>
&cislo_ume=<?php echo $cislo_ume; ?>&cislo_stvrt=<?php echo $cislo_stvrt; ?>&koefmin=<?php echo $koefmin; ?>&druhykoef=<?php echo $druhykoef; ?>
&cislo_druh=<?php echo $cislo_druh; ?>&cislo_dap=<?php echo $cislo_dap; ?>","_self");
</script>
<?php
exit;
}

if ( $copern == 80 )
    {

$sql = "SELECT cpop FROM F$kli_vxcf"."_archivdph ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
          {
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD koefmin DECIMAL(10,4) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD koefnew DECIMAL(10,4) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD odpocall DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD odpocupr DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD odpocroz DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD rodpocall DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD rodpocupr DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD rodpocroz DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD druhykoef TEXT AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r19orig DECIMAL(10,2) DEFAULT 0 AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r18orig DECIMAL(10,2) DEFAULT 0 AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r37 DECIMAL(10,2) AFTER r36";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD r38 DECIMAL(10,2) AFTER r37";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD dad DATE NOT NULL AFTER fic";
$vysledek = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD cpid INT AFTER druh";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD daid timestamp AFTER cpid";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph MODIFY cpid int PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph MODIFY daid timestamp ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_archivdph ADD cpop INT DEFAULT 0 AFTER daid";
$vysledek = mysql_query("$sql");
          }

     }



//odpocet riadne od dodatocneho presunute do prizdph2014_uprava.php
if ( $copern == 230 )
    {
$sqlt = "DROP TABLE F$kli_vxcf"."_archivdph".$kli_uzid;
$vysledok = mysql_query("$sqlt");


$vsql = "CREATE TABLE F$kli_vxcf"."_archivdph".$kli_uzid." SELECT * FROM F$kli_vxcf"."_archivdph ".
" WHERE ume = $cislo_ume AND druh = 1 AND stvrtrok = $cislo_stvrt ";
$vytvor = mysql_query("$vsql");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph,F$kli_vxcf"."_archivdph".$kli_uzid." ".
" SET F$kli_vxcf"."_archivdph.r36=F$kli_vxcf"."_archivdph.r28-F$kli_vxcf"."_archivdph".$kli_uzid.".r28-".
"F$kli_vxcf"."_archivdph.r30+F$kli_vxcf"."_archivdph.r30, ".
" F$kli_vxcf"."_archivdph.r37=F$kli_vxcf"."_archivdph.r28-F$kli_vxcf"."_archivdph".$kli_uzid.".r28-".
"F$kli_vxcf"."_archivdph.r30+F$kli_vxcf"."_archivdph.r30 ".
" WHERE F$kli_vxcf"."_archivdph.ume = $cislo_ume AND F$kli_vxcf"."_archivdph.druh = 3 AND F$kli_vxcf"."_archivdph.stvrtrok = $cislo_stvrt ".
" AND F$kli_vxcf"."_archivdph.ume=F$kli_vxcf"."_archivdph".$kli_uzid.".ume ".
" AND F$kli_vxcf"."_archivdph.stvrtrok=F$kli_vxcf"."_archivdph".$kli_uzid.".stvrtrok ".
" AND F$kli_vxcf"."_archivdph".$kli_uzid.".druh = 1 AND F$kli_vxcf"."_archivdph.cpid = $cislo_cpid ".
"";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

$sqlt = "DROP TABLE F$kli_vxcf"."_archivdph".$kli_uzid;
$vysledok = mysql_query("$sqlt");
//exit;


$copern=20;
$odpoc=1;
    }
//koniec odpocet riadne od dodatocneho


//prepocet pomernej DPH presunute do prizdph2014_uprava.php
if ( $copern == 220 )
    {
$koefmin = 1*$_REQUEST['koefmin'];
$druhykoef = strip_tags($_REQUEST['druhykoef']);

$uprtxt = "UPDATE F$kli_vxcf"."_archivdphkoef SET koefmin='$koefmin', druhykoef='$druhykoef' WHERE fic >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET koefmin='$koefmin', druhykoef='$druhykoef' WHERE ume >= 0"; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET r19orig=r21 WHERE r19orig = 0 AND cpid = $cislo_cpid "; 
$upravene = mysql_query("$uprtxt");

$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET r18orig=r20 WHERE r18orig = 0 AND cpid = $cislo_cpid "; 
$upravene = mysql_query("$uprtxt");

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$pole = explode(".", $cislo_ume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

if( $cislo_stvrt > 0 ) {
$kli_mdph="";
if( $cislo_stvrt == 1 ) { $mesp_dph=1; $mesk_dph=3; $obddph="1"; }
if( $cislo_stvrt == 2 ) { $mesp_dph=4; $mesk_dph=6; $obddph="2"; }
if( $cislo_stvrt == 3 ) { $mesp_dph=7; $mesk_dph=9; $obddph="3"; }
if( $cislo_stvrt == 4 ) { $mesp_dph=10; $mesk_dph=12; $obddph="4"; }
if( $cislo_stvrt == 5 ) { $mesp_dph=1; $mesk_dph=12; $obddph="5"; }
                       }

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");

$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//echo $datp_dph."  ".$datk_dph;


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   dok          INT,
   hod          DECIMAL(10,2),
   prx          INT
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$podmrdp="AND ( LEFT(ucm,3) = 343 ";

$pole = explode(",", $druhykoef);

$cislo=1*$pole[0];
if( $cislo > 0 ) $podmrdp=$podmrdp." ) AND ( rdp = $pole[0] ";
$cislo=1*$pole[1];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[1] ";
$cislo=1*$pole[2];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[2] ";
$cislo=1*$pole[3];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[3] ";
$cislo=1*$pole[4];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[4] ";
$cislo=1*$pole[5];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[5] ";
$cislo=1*$pole[6];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[6] ";
$cislo=1*$pole[7];
if( $cislo > 0 ) $podmrdp=$podmrdp." OR rdp = $pole[7] ";

$podmrdp=$podmrdp." ) ";


//echo $podmrdp;

//exit;


$psys=12;
while ($psys <= 16 ) 
  {
//zober vydavkove pokl
if( $psys == 12 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 13 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 14 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober dodavatelske
if( $psys == 16 ) { $uctovanie="uctdod"; $doklad="fakdod"; }

if( $psys <= 16 )
{
if( $psys < 15 )
   {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,0 ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".$podmrdp." ".
" AND ( F$kli_vxcf"."_$doklad.dat >= '$datp_dph' AND F$kli_vxcf"."_$doklad.dat <= '$datk_dph' ) ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
   }
if( $psys > 15 )
   {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" F$kli_vxcf"."_$uctovanie.dok,F$kli_vxcf"."_$uctovanie.hod,0 ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".$podmrdp." ".
" AND F$kli_vxcf"."_$doklad.daz >= '$datp_dph' AND F$kli_vxcf"."_$doklad.daz <= '$datk_dph' ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
   }



}
else
{
//tu budu podsystemy

}
$psys=$psys+1;
  }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,SUM(hod),1 FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE prx = 0 GROUP BY prx ";
$dsql = mysql_query("$dsqlt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE prx = 0 "; 
$zmazane = mysql_query("$zmazttt"); 

$sqlmax = mysql_query("SELECT * FROM F$kli_vxcf"."_prcprizdphs$kli_uzid ORDER by dok DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $odpocall=$riadmax->hod;
  }

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET odpocall=$odpocall, odpocupr=koefmin*odpocall, odpocroz=odpocall-odpocupr, r21=r19orig-odpocroz ".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";

//echo $sqtoz;
$oznac = mysql_query("$sqtoz");

//vynuluj pred tym vypocitane
$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r31=0, r32=0, r33=0, r34=0  ".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

//prepocty
$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r19=r02+r04+r06+r08+r10+r12+r14+r18, r31=r19-r21-r20-r29-r30+r27+r28-r29-r30 ".
" WHERE ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r34=r31-r32-r33 ".
" WHERE r31 >= 0 AND  ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r32=-r31, r33=0, r34=0 ".
" WHERE r31 < 0 AND  ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r31=0 ".
" WHERE r31 < 0 AND  ume = $cislo_ume AND druh = $cislo_druh AND stvrtrok = $cislo_stvrt AND cpid = $cislo_cpid ";
$oznac = mysql_query("$sqtoz");


$copern=20;
$prepoc=1;
    }
//koniec prepocet

//vymazanie polozky
if ( $copern == 60 )
    {
$zmazttt = "DELETE FROM F$kli_vxcf"."_archivdphzoznam WHERE er4 = $cislo_cpid  "; 
$zmazane = mysql_query("$zmazttt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_archivdphkvdph WHERE cpid = $cislo_cpid  "; 
$zmazane = mysql_query("$zmazttt");

$zmazttt = "DELETE FROM F$kli_vxcf"."_archivdph WHERE cpid = $cislo_cpid  "; 
$zmazane = mysql_query("$zmazttt"); 
$copern=80;
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

// zapis upravene udaje presunute do prizdph2014_uprava.php
if ( $copern == 23 )
    {

$par79ods2 = $_REQUEST['par79ods2'];
//echo $par79ods2;
$r01 = strip_tags($_REQUEST['r01']);
$r02 = strip_tags($_REQUEST['r02']);
$r03 = strip_tags($_REQUEST['r03']);
$r04 = strip_tags($_REQUEST['r04']);
$r05 = strip_tags($_REQUEST['r05']);
$r06 = strip_tags($_REQUEST['r06']);
$r07 = strip_tags($_REQUEST['r07']);
$r08 = strip_tags($_REQUEST['r08']);
$r09 = strip_tags($_REQUEST['r09']);
$r10 = strip_tags($_REQUEST['r10']);
$r11 = strip_tags($_REQUEST['r11']);
$r12 = strip_tags($_REQUEST['r12']);
$r13 = strip_tags($_REQUEST['r13']);
$r14 = strip_tags($_REQUEST['r14']);
$r15 = strip_tags($_REQUEST['r15']);
$r16 = strip_tags($_REQUEST['r16']);
$r17 = strip_tags($_REQUEST['r17']);
$r18 = strip_tags($_REQUEST['r18']);
$r19 = strip_tags($_REQUEST['r19']);
$r20 = strip_tags($_REQUEST['r20']);
$r21 = strip_tags($_REQUEST['r21']);
$r22 = strip_tags($_REQUEST['r22']);
$r23 = strip_tags($_REQUEST['r23']);
$r24 = strip_tags($_REQUEST['r24']);
$r25 = strip_tags($_REQUEST['r25']);
$r26 = strip_tags($_REQUEST['r26']);
$r27 = strip_tags($_REQUEST['r27']);
$r28 = strip_tags($_REQUEST['r28']);
$r29 = strip_tags($_REQUEST['r29']);
$r30 = strip_tags($_REQUEST['r30']);
$r31 = strip_tags($_REQUEST['r31']);
$r32 = strip_tags($_REQUEST['r32']);
$r33 = strip_tags($_REQUEST['r33']);
$r34 = strip_tags($_REQUEST['r34']);
$r35 = strip_tags($_REQUEST['r35']);
$r36 = strip_tags($_REQUEST['r36']);
$r37 = strip_tags($_REQUEST['r37']);
$r38 = strip_tags($_REQUEST['r38']);
$dad = $_REQUEST['dad'];
$dad_sql=Sqldatum($dad);
$cpop = 1*$_REQUEST['cpop'];

$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_archivdph SET cpop='$cpop',".
" r01='$r01', r02='$r02', r03='$r03', r04='$r04', r05='$r05', r06='$r06', r07='$r07', r08='$r08', r09='$r09',".
" r10='$r10', r11='$r11', r12='$r12', r13='$r13', r14='$r14', r15='$r15', r16='$r16', r17='$r17', r18='$r18', r19='$r19',".
" r20='$r20', r21='$r21', r22='$r22', r23='$r23', r24='$r24', r25='$r25', r26='$r26', r27='$r27', r28='$r28', r29='$r29',".
" r30='$r30', r31='$r31', r32='$r32', r33='$r33', r34='$r34', r35='$r35', r36='$r36', r37='$r37', r38='$r38', dad='$dad_sql', ".
" par79ods2='$par79ods2' ".
" WHERE cpid = $cislo_cpid  "; 
//echo $uprtxt;
$upravene = mysql_query("$uprtxt");  

//prepocty

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r19=r02+r04+r06+r08+r10+r12+r14+r18, r31=r19-r21-r20-r29-r30+r27+r28-r29-r30 ".
" WHERE cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r34=r31-r32-r33 ".
" WHERE r31 >= 0 AND cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r32=-r31, r33=0, r34=0 ".
" WHERE r31 < 0 AND cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_archivdph".
" SET r31=0 ".
" WHERE r31 < 0 AND cpid = $cislo_cpid  ";
$oznac = mysql_query("$sqtoz");

$copern=80;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN… " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov



//nacitaj udaje pre upravu presunute do prizdph2014_uprava.php
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_archivdph".
" WHERE cpid = $cislo_cpid ORDER BY ume,druh";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$par79ods2 = $fir_riadok->par79ods2;
$r01 = $fir_riadok->r01;
$r02 = $fir_riadok->r02;
$r03 = $fir_riadok->r03;
$r04 = $fir_riadok->r04;
$r05 = $fir_riadok->r05;
$r06 = $fir_riadok->r06;
$r07 = $fir_riadok->r07;
$r08 = $fir_riadok->r08;
$r09 = $fir_riadok->r09;
$r10 = $fir_riadok->r10;
$r11 = $fir_riadok->r11;
$r12 = $fir_riadok->r12;
$r13 = $fir_riadok->r13;
$r14 = $fir_riadok->r14;
$r15 = $fir_riadok->r15;
$r16 = $fir_riadok->r16;
$r17 = $fir_riadok->r17;
$r18 = $fir_riadok->r18;
$r19 = $fir_riadok->r19;
$r20 = $fir_riadok->r20;
$r21 = $fir_riadok->r21;
$r22 = $fir_riadok->r22;
$r23 = $fir_riadok->r23;
$r24 = $fir_riadok->r24;
$r25 = $fir_riadok->r25;
$r26 = $fir_riadok->r26;
$r27 = $fir_riadok->r27;
$r28 = $fir_riadok->r28;
$r29 = $fir_riadok->r29;
$r30 = $fir_riadok->r30;
$r31 = $fir_riadok->r31;
$r32 = $fir_riadok->r32;
$r33 = $fir_riadok->r33;
$r34 = $fir_riadok->r34;
$r35 = $fir_riadok->r35;
$r36 = $fir_riadok->r36;
$r37 = $fir_riadok->r37;
$r38 = $fir_riadok->r38;
$stvrtrok = $fir_riadok->stvrtrok;
$ume = $fir_riadok->ume;

$dad = $fir_riadok->dad;
$dad_sk=SkDatum($dad);
$cpop = 1*$fir_riadok->cpop;

$odpocall=1*$fir_riadok->odpocall;
$odpocupr=1*$fir_riadok->odpocupr;

mysql_free_result($fir_vysledok);

$sqlfirk = "SELECT * FROM F$kli_vxcf"."_archivdphkoef WHERE fic >= 0";

$fir_vysledokk = mysql_query($sqlfirk);
$fir_riadokk=mysql_fetch_object($fir_vysledokk);

$koefmin=1*$fir_riadokk->koefmin;
$druhykoef=$fir_riadokk->druhykoef;

mysql_free_result($fir_vysledokk);

    }
//koniec nacitania

//ulozenie parametrov koef a nastav
$sql = "SELECT fic FROM F$kli_vxcf"."_archivdphkoef ";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
$sql = "CREATE TABLE F".$kli_vxcf."_archivdphkoef SELECT * FROM F".$kli_vxcf."_archivdph WHERE fic >= 0";
$vysledek = mysql_query("$sql");

$sql = "DELETE FROM F".$kli_vxcf."_archivdphkoef WHERE fic >= 0";
$vysledek = mysql_query("$sql");

$ttvv = "INSERT INTO F$kli_vxcf"."_archivdphkoef ( fic ) VALUES ( '$fir_fico' )";
$ttqq = mysql_query("$ttvv");
}


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Prehæad dane - ötvrùroËn˝</title>
  <style type="text/css">

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

<?php
//uprava sadzby strana 1
  if ( $copern == 20 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.r01.value = '<?php echo "$r01";?>';
    document.formv1.r02.value = '<?php echo "$r02";?>';
    document.formv1.r03.value = '<?php echo "$r03";?>';
    document.formv1.r04.value = '<?php echo "$r04";?>';
    document.formv1.r05.value = '<?php echo "$r05";?>';
    document.formv1.r06.value = '<?php echo "$r06";?>';
    document.formv1.r07.value = '<?php echo "$r07";?>';
    document.formv1.r08.value = '<?php echo "$r08";?>';
    document.formv1.r09.value = '<?php echo "$r09";?>';
    document.formv1.r10.value = '<?php echo "$r10";?>';
    document.formv1.r11.value = '<?php echo "$r11";?>';
    document.formv1.r12.value = '<?php echo "$r12";?>';
    document.formv1.r13.value = '<?php echo "$r13";?>';
    document.formv1.r14.value = '<?php echo "$r14";?>';
    document.formv1.r15.value = '<?php echo "$r15";?>';
    document.formv1.r16.value = '<?php echo "$r16";?>';
    document.formv1.r17.value = '<?php echo "$r17";?>';
    document.formv1.r18.value = '<?php echo "$r18";?>';
    document.formv1.r19.value = '<?php echo "$r19";?>';
    document.formv1.r20.value = '<?php echo "$r20";?>';
    document.formv1.r21.value = '<?php echo "$r21";?>';
    document.formv1.r22.value = '<?php echo "$r22";?>';
    document.formv1.r23.value = '<?php echo "$r23";?>';
    document.formv1.r24.value = '<?php echo "$r24";?>';
    document.formv1.r25.value = '<?php echo "$r25";?>';
    document.formv1.r26.value = '<?php echo "$r26";?>';
    document.formv1.r27.value = '<?php echo "$r27";?>';
    document.formv1.r28.value = '<?php echo "$r28";?>';
    document.formv1.r29.value = '<?php echo "$r29";?>';
    document.formv1.r30.value = '<?php echo "$r30";?>';
    document.formv1.r31.value = '<?php echo "$r31";?>';
    document.formv1.r32.value = '<?php echo "$r32";?>';
    document.formv1.r33.value = '<?php echo "$r33";?>';
    document.formv1.r34.value = '<?php echo "$r34";?>';
    document.formv1.r35.value = '<?php echo "$r35";?>';
    document.formv1.r36.value = '<?php echo "$r36";?>';
    document.formv1.r37.value = '<?php echo "$r37";?>';
    document.formv1.r38.value = '<?php echo "$r38";?>';
    document.formv1.dad.value = '<?php echo "$dad_sk";?>';
    document.formv1.cpop.value = '<?php echo "$cpop";?>';
    }
<?php
//koniec uprava
  }
?>

<?php
  if ( $copern != 20 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
  }
?>


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


// Kontrola des.cisla celeho v rozsahu x az y  
      function cele(x1,x,y,Oznam,des) 
      { 
       var b;
       b=x1.value;
       var anyString=b;
       var err=0;
       var c;
       var d;
       var cele;
       var pocdes;
       cele=0;
       pocdes=0;
       c=b.toString();
       d=c.split('.');
       if ( isNaN(d[1]) ) { cele=1; }
       if ( cele == 0 ) { pocdes=d[1].length; }

         if (b == "") { err=0 }
         if (b>=x && b<=y) { err=0 }
         if ( x1.value.search(/[^0-9.-]/g) != -1) { err=1 }
         if (b<x && b != "") { err=1 }
         if (b>y && b != "") { err=1 }
         if (cele == 0 && pocdes > des ) { err=1 }

	 if (err == 0)
	 {         
         Oznam.style.display="none";
         return true;
         }

	 if (err == 1)
	 { 
         Oznam.style.display="";
         document.formv1.uloz.disabled = true;
         x1.focus();
         x1.value = b + "??";
         return false;
         }

      }


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


function ZmazPolozku(cpid)
                {
var cislo_cpid = cpid;

window.open('../ucto/archivdph2014.php?copern=60&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&drupoh=1&uprav=1',
 '_self' );
                }

function UpravPolozku(cpid,ume,druh,stvrtrok,dap)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var cislo_dap = dap;
var stvrtrok = stvrtrok;

window.open('../ucto/prizdph2014_uprav.php?copern=20&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&drupoh=1&uprav=1',
 '_self' );
                }

function TlacPolozku(cpid,ume,druh,stvrtrok,dap)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var cislo_dap = dap;
var stvrtrok = stvrtrok;

window.open('../ucto/prizdph2014.php?copern=110&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&cislo_dap=' + cislo_dap + '&drupoh=1&uprav=1&fir_uctx01=<?php echo $fir_uctx01; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function ExportPolozku(cpid,ume,druh,stvrtrok,dap)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var cislo_dap = dap;
var stvrtrok = stvrtrok;

window.open('../ucto/prizdph2014_xml.php?copern=110&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&cislo_dap=' + cislo_dap + '&drupoh=1&uprav=1&fir_uctx01=<?php echo $fir_uctx01; ?>',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


  function ukazrobot()
  { 
  <?php echo "robotokno.style.display=''; robotmenu.style.display='none';";  ?>
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  robotmenu.style.display='none';
  }

  function zobraz_robotmenu()
  { 

  robotmenu.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  }



  function NerobNic()
  { 

  }

  function Prepoc(cpid,ume,druh,stvrtrok)
  { 
var cislo_cpid = cpid;
var h_koefmin = document.forms.fkoef.h_koefmin.value;
var h_druhykoef = document.forms.fkoef.h_druhykoef.value;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;

window.open('../ucto/archivdph2014.php?copern=220&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok +
 '&koefmin=' + h_koefmin + '&druhykoef=' + h_druhykoef + '&drupoh=1&uprav=1&prepoc=1', '_self' );


  }

  function ArchivJCD()
  { 

window.open('../ucto/oprsys.php?copern=308&drupoh=43&page=1&sysx=UCT', '_blank','<?php echo $tlcuwin; ?>' );

  }

function TlacPotvrdDPH(obdx)
                {
  var obdobiex = obdx;
  window.open('../tmp/potvrddph' + obdobiex + '.<?php echo $kli_uzid; ?>.pdf', '_blank', '<?php echo $tlcuwin; ?>' );
                }


  function Odpoc(cpid,ume,druh,stvrtrok)
  { 
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;

window.open('../ucto/archivdph2014.php?copern=230&page=1&sysx=UCT&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok +
 '&drupoh=1&uprav=1&odpoc=1', '_self' );


  }


function TlacZoznam(cpid,ume,druh,stvrtrok)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;

window.open('../ucto/prizdph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacZoznamRP(cpid,ume,druh,stvrtrok)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;

window.open('../ucto/prizdph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacZoznamRM(cpid,ume,druh,stvrtrok)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;

window.open('../ucto/prizdph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=2',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KvPdf(cpid,ume,druh,stvrtrok,dap,cpop)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;
var cislo_cpop = cpop;

window.open('../ucto/kontrolnydph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&cislo_cpop=' + cislo_cpop + '&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KvXml(cpid,ume,druh,stvrtrok,dap,cpop)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;
var cislo_cpop = cpop;

window.open('../ucto/kontrolnydph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&xmlko=1&cislo_cpop=' + cislo_cpop + '&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function KvControl(cpid,ume,druh,stvrtrok,dap,cpop)
                {
var cislo_cpid = cpid;
var cislo_ume = ume;
var cislo_druh = druh;
var stvrtrok = stvrtrok;
var cislo_cpop = cpop;

window.open('../ucto/kontrolnydph2014.php?copern=7020&drupoh=1&page=1&typ=PDF&xmlko=0&control=1&cislo_cpop=' + cislo_cpop + '&cislo_cpid=' + cislo_cpid + '&cislo_ume=' + cislo_ume + '&cislo_druh=' + cislo_druh + '&cislo_stvrt=' + stvrtrok + '&rozdiel=0',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function manualDodKvdph(cpid, ume, stvrt)
                {

window.open('../ucto/kontrolnydph2014_manual.php?copern=1&drupoh=1&page=1&typ=PDF&xmlko=0&control=1&rozdiel=0&xume=' + ume + '&xstv=' + stvrt + '&xdod=' + cpid + '&xx=1',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI(); <?php if( $copern == 20 ) { echo 'ukazrobot();'; } ?> <?php if( $prepoc == 1 ) { echo 'zobraz_robotmenu();'; } ?>" >

<table class="h2" width="100%" >
<tr>

<td>EuroSecom  -  ArchÌv daÚov˝ch priznanÌ DPH <?php echo $kli_vrok; ?>

<?php if( $oddelcsv == 1 ) { ?>
<a href="#" title="icDPH CSV1" onClick="window.open('../ucto/archivdph2014.php?copern=80&drupoh=1&page=1&akecsv=1', '_self')">CSV1</a>

&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" title="icDPH CSV2" onClick="window.open('../ucto/archivdph2014.php?copern=80&drupoh=1&page=1&akecsv=2', '_self')">CSV2</a>
<?php                      } ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>


<?php
//upravy  udaje strana 1
if ( $copern == 20 )
    {
?>
<tr>
<span id="Cele" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Datum" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 D·tum musÌ byù v tvare DD.MM.RRRR,DD.MM alebo DD naprÌklad 21.10.2008 , 21 program doplni na 21.<?php echo $kli_vume; ?>;</span>
<span id="Desc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 2 desatinnÈ miesta;</span>
<span id="Desc4" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 4 desatinnÈ miesta;</span>
<span id="Desc1" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Hodnota mus byù desatinnÈ ËÌslo, maxim·lne 1 desatinnÈ miesto;</span>
<span id="Oc" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 OS» musÌ byù celÈ kladnÈ ËÌslo v rozsahu 1 aû 9999</span>
<span id="Fx" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 MusÌte vyplniù vöetky poloûky vstupu</span>
<span id="Ul" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $h_oc;?> spr·vne uloûen·</span>
</tr>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="archivdph2014.php?copern=23
&cislo_cpid=<?php echo $cislo_cpid;?>" >
<tr>
<td class="bmenu" width="10%">
<?php
if( $cislo_stvrt == 0 ) { $podmzarchu=" er1 = 0 AND ume = $cislo_ume "; } 
if( $cislo_stvrt > 0 ) { $podmzarchu=" er1 = $cislo_stvrt "; } 
$jearchzoznam=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_archivdphzoznam WHERE $podmzarchu ";
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $jearchzoznam=1;
  }
if( $jearchzoznam == 1 )
     { ?>
<a href="#" onClick="TlacZoznam(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $cislo_stvrt;?>);">
zoznam <img src='../obr/tlac.png' width=15 height=15 border=0 title='TlaË zoznamu dokladov k priznaniu DPH podæa riadkov' ></a>
<?php } ?>
</td>
<td class="bmenu" width="10%">
<?php
if( $jearchzoznam == 1 )
     { ?>
<a href="#" onClick="TlacZoznamRP(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $cislo_stvrt;?>);">
+ <img src='../obr/export.png' width=15 height=15 border=0 title='TlaË rozdielov˝ch dokladov, ktorÈ s˙ navyöe v zozname archivovanom oproti aktu·lnemu' ></a>

<a href="#" onClick="TlacZoznamRM(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $cislo_stvrt;?>);">
- <img src='../obr/import.png' width=15 height=15 border=0 title='TlaË rozdielov˝ch dokladov, ktorÈ ch˝baj˙ v zozname archivovanom oproti aktu·lnemu' ></a>
<?php } ?>
</td><td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="5%"></td><td class="bmenu" width="5%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
<td class="bmenu" width="10%"></td><td class="bmenu" width="10%"></td>
</td><td class="bmenu" width="10%"></td>
</tr>

<tr>

<?php if ( $stvrtrok == 0 ) { ?>
<td class="bmenu" colspan="8">DaÚovÈ priznanie za mesiac <?php echo $cislo_ume;?> 
<?php                               } ?>

<?php if ( $stvrtrok != 0 ) { ?>
<td class="bmenu" colspan="8">DaÚovÈ priznanie za ötvrùrok <?php echo $stvrtrok;?> 
<?php                               } ?>

<?php if ( $cislo_druh == 1 ) { echo " Riadne"; } ?>
<?php if ( $cislo_druh == 2 ) { echo " OpravnÈ"; } ?>
<?php if ( $cislo_druh == 3 ) { echo " DodatoËnÈ"; } ?>

/id<?php echo $cislo_cpid;?>
</td>

<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù ˙pravy"></td>
</tr>

<tr><td class="bmenu" colspan="8">D·tum zistenia skutoËnosti na podanie dodatoËnÈho DP 
<input type="text" name="dad" id="dad" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="8">»Ìslo ID kontrolnÈho v˝kazu DPH, ktor˝ opravujem ( len u dodatoËn˝ch priznanÌ )
<input type="text" name="cpop" id="cpop" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Dodanie tovaru a sluûby podæa ß8 a 9 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" >zn.sadzba</td>
<td class="pvstuz" colspan="2">01 <input type="text" name="r01" id="r01" size="10" /></td>
<td class="pvstuz" colspan="2">02 <input type="text" name="r02" id="r02" size="10" /></td>
</tr>
<tr><td class="pvstuz" colspan="4"> </td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" >zkl.sadzba</td>
<td class="pvstuz" colspan="2">03 <input type="text" name="r03" id="r03" size="10" /></td>
<td class="pvstuz" colspan="2">04 <input type="text" name="r04" id="r04" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Nadobudnutie tovaru v tuzemsku podæa ß11 a 11a z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" >zn.sadzba</td>
<td class="pvstuz" colspan="2">05 <input type="text" name="r05" id="r05" size="10" /></td>
<td class="pvstuz" colspan="2">06 <input type="text" name="r06" id="r06" size="10" /></td>
</tr>
<tr><td class="pvstuz" colspan="4"> </td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" >zkl.sadzba</td>
<td class="pvstuz" colspan="2">07 <input type="text" name="r07" id="r07" size="10" /></td>
<td class="pvstuz" colspan="2">08 <input type="text" name="r08" id="r08" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Tovary a sluûby, pri ktor˝ch prÌjemca platÌ daÚ podæa ß69 ods.2 a 9 aû 12 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">09 <input type="text" name="r09" id="r09" size="10" /></td>
<td class="pvstuz" colspan="2">10 <input type="text" name="r10" id="r10" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Sluûby, pri ktor˝ch prÌjemca platÌ daÚ podæa ß69 ods.3 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">11 <input type="text" name="r11" id="r11" size="10" /></td>
<td class="pvstuz" colspan="2">12 <input type="text" name="r12" id="r12" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Tovary, pri ktor˝ch druh˝ odberateæ platÌ daÚ podæa ß69 ods.7 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">13 <input type="text" name="r13" id="r13" size="10" /></td>
<td class="pvstuz" colspan="2">14 <input type="text" name="r14" id="r14" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Dodanie tovarov a sluûieb s oslobodenÌm od dane</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">15 <input type="text" name="r15" id="r15" size="10" /></td>
<td class="pvstuz" colspan="2"> </td>
</tr>
<tr><td class="pvstuz" colspan="4">z toho: podæa ß43 ods.1 a 4 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">16 <input type="text" name="r16" id="r16" size="10" /></td>
<td class="pvstuz" colspan="2"> </td>
</tr>
<tr><td class="pvstuz" colspan="4">z toho: podæa ß46,47 a ß48 ods.8 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">17 <input type="text" name="r17" id="r17" size="10" /></td>
<td class="pvstuz" colspan="2"> </td>
</tr>

<tr><td class="pvstuz" colspan="4">DaÚov· povinnosù pri zruöenÌ registr·cie podæa ß81 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" ></td>
<td class="pvstuz" colspan="2"> </td>
<td class="pvstuz" colspan="2">18 <input type="text" name="r18" id="r18" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">D A “  C E L K O M</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" ></td>
<td class="pvstuz" colspan="2"> </td>
<td class="pvstuz" colspan="2">19 <input type="text" name="r19" id="r19" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">OdpoËÌtanie dane celkom podæa ß49 aû 54a z·kona</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"></td>
<td class="bmenu" colspan="2" align="right" >zn.sadzba</td>
<td class="bmenu" colspan="2">20 <input type="text" name="r20" id="r20" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"></td>
<td class="bmenu" colspan="2" align="right" >zkl.sadzba</td>
<td class="bmenu" colspan="2">21 <input type="text" name="r21" id="r21" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">z toho: podæa ß51 ods.1 pÌsm. a) z·kona</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"></td>
<td class="bmenu" colspan="2" align="right" >zn.sadzba</td>
<td class="bmenu" colspan="2">22 <input type="text" name="r22" id="r22" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"></td>
<td class="bmenu" colspan="2" align="right" >zkl.sadzba</td>
<td class="bmenu" colspan="2">23 <input type="text" name="r23" id="r23" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">z toho: podæa ß51 ods.1 pÌsm. d) z·kona</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"></td>
<td class="bmenu" colspan="2" align="right" >zn.sadzba</td>
<td class="bmenu" colspan="2">24 <input type="text" name="r24" id="r24" size="10" /></td>
</tr>
<tr><td class="bmenu" colspan="4"> </td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1"></td>
<td class="bmenu" colspan="2" align="right" >zkl.sadzba</td>
<td class="bmenu" colspan="2">25 <input type="text" name="r25" id="r25" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Rozdiel v z·kl.dane a v dani po oprave podæa ß25 ods.1 aû 3 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2">26 <input type="text" name="r26" id="r26" size="10" /></td>
<td class="pvstuz" colspan="2">27 <input type="text" name="r27" id="r27" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Oprava odpoËÌtanej dane podæa ß53 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" > </td>
<td class="pvstuz" colspan="2"> </td>
<td class="pvstuz" colspan="2">28 <input type="text" name="r28" id="r28" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">OdpoËÌtanie dane pri registr·cii platiteæa dane podæa ß55 z·kona</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right" > </td>
<td class="bmenu" colspan="2"> </td>
<td class="bmenu" colspan="2">29 <input type="text" name="r29" id="r29" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">Vr·tenie dane cestuj˙cim  pri v˝voze tovaru podæa ß60 z·kona</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right" > </td>
<td class="bmenu" colspan="2"> </td>
<td class="bmenu" colspan="2">30 <input type="text" name="r30" id="r30" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Vlastn· daÚov· povinnosù </td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" ></td>
<td class="pvstuz" colspan="2"> </td>
<td class="pvstuz" colspan="2">31 <input type="text" name="r31" id="r31" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">Nadmern˝ odpoËet</td>
<td class="bmenu" colspan="4">Splnenie podmienok podæa ß79 ods.2 z·kona
 <input type="checkbox" name="par79ods2" value="1"  />
<?php
if ( $par79ods2 == 1 )
   {
?>
<script type="text/javascript">
document.formv1.par79ods2.checked = "checked";
</script>
<?php
   }
?>
</td>
<td class="bmenu" colspan="2">32 <input type="text" name="r32" id="r32" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Nadmern˝ odpoËet odpoËÌtan˝ od vlastnej daÚovej povinnosti podæa ß79 z·kona</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" ></td>
<td class="pvstuz" colspan="2"> </td>
<td class="pvstuz" colspan="2">33 <input type="text" name="r33" id="r33" size="10" /></td>
</tr>

<tr><td class="pvstuz" colspan="4">Vlastn· daÚov· povinnosù na ˙hradu</td>
<td class="pvstuz" colspan="1"> </td>
<td class="pvstuz" colspan="1" align="right" ></td>
<td class="pvstuz" colspan="2"> </td>
<td class="pvstuz" colspan="2">34 <input type="text" name="r34" id="r34" size="10" /></td>
</tr>


<tr><td class="bmenu" colspan="4">Trojstrann˝ obchod podæa ß45 z·kona</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right" > </td>
<td class="bmenu" colspan="2">35 <input type="text" name="r35" id="r35" size="10" /></td>
<td class="bmenu" colspan="2">36 <input type="text" name="r36" id="r36" size="10" /></td>
</tr>

<tr><td class="bmenu" colspan="4">⁄DAJE DODATO»N…HO DA“OV…HO PRIZNANIA</td>
<td class="bmenu" colspan="1"> </td>
<td class="bmenu" colspan="1" align="right" > </td>
<td class="bmenu" colspan="2">37 <input type="text" name="r37" id="r37" size="10" /></td>
<td class="bmenu" colspan="2">38 <input type="text" name="r38" id="r38" size="10" /></td>
</tr>

</FORM>

</table>

<div id="myBANKADelement"></div>
<div id="jeBANKADelement"></div>


<script type="text/javascript">

</script>

<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  udaje strana 1
?>

<?php
//zoznam priznani
if ( $copern == 80 )
     {
$sqltt = "SELECT * FROM F$kli_vxcf"."_archivdph WHERE druh > 0 ORDER BY ume DESC,stvrtrok DESC,druh";
//echo $sqltt;
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;
?>

<table class="fmenu" width="100%" >


<tr>
<td class="hmenu" colspan="5" >
<?php
if( $fir_uctx07 == 1 )
     {
?>
<a href="#" onClick="ArchivJCD();">
JCD <img src='../obr/zoznam.png' width=15 height=15 border=0 title='ArchÌv JCD uplatnen˝ch v DPH' ></a></td>
<?php
     }
?>
<td class="hmenu" colspan="5" align="right" ></td>
</tr>


<tr>
<td class="hmenu" width="10%" >mesiac
<td class="hmenu" width="10%" >ötvrùrok
<td class="hmenu" width="15%" >druh
<td class="hmenu" width="15%" align="right" >r31 vlastn· daÚ.povinnosù
<td class="hmenu" width="15%" align="right" >r32 nadmer˝ odpoËet
<td class="hmenu" width="5%" >TlaË
<td class="hmenu" width="5%" >Uprav
<td class="hmenu" width="5%" >Export
<td class="hmenu" width="15%" >Kontroln˝ v˝kaz
<td class="hmenu" width="5%" >Zmaû
</tr>

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
<td class="fmenu" ><?php if ( $riadok->stvrtrok == 0 ) { echo $riadok->ume; }?></td>
<td class="fmenu" >
<?php if ( $riadok->stvrtrok != 0 AND $riadok->stvrtrok != 5 ) { echo $riadok->stvrtrok; } ?>
<?php if ( $riadok->stvrtrok == 5 ) { echo "rok ".$kli_vrok; } ?>
</td>
<td class="fmenu" >

<?php if ( $riadok->druh == 1 ) { echo "Riadne"; } ?>
<?php if ( $riadok->druh == 2 ) { echo "OpravnÈ"; } ?>
<?php if ( $riadok->druh == 3 ) { echo "DodatoËnÈ"; } ?>
 z <?php echo $riadok->dap;?> /id<?php echo $riadok->cpid;?> <?php echo $riadok->daid;?>
</td>

<td class="fmenu" align="right" ><?php echo $riadok->r31;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->r32;?></td>

<td class="fmenu" width="5%" >
<a href="#" onClick="TlacPolozku(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->druh;?>,<?php echo $riadok->stvrtrok;?>,'<?php echo $riadok->dap;?>');">
<img src='../obr/tlac.png' width=15 height=10 border=0 title='TlaËiù priznanie DPH' ></a>

<?php
$obdx=$riadok->ume;
if( $riadok->stvrtrok == 1 ) { $obdx="1.".$kli_vrok; }
if( $riadok->stvrtrok == 2 ) { $obdx="4.".$kli_vrok; }
if( $riadok->stvrtrok == 3 ) { $obdx="7.".$kli_vrok; }
if( $riadok->stvrtrok == 4 ) { $obdx="10.".$kli_vrok; }
?>

<a href="#" onClick="TlacPotvrdDPH('<?php echo $obdx;?>');">
<img src='../obr/tlac.png' width=10 height=10 border=0 title="VytlaËiù potvrdenie o podanÌ daÚovÈho priznania DPH vo form·te PDF" ></a>

<td class="fmenu" width="5%" >
<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->druh;?>,<?php echo $riadok->stvrtrok;?>,'<?php echo $riadok->dap;?>');">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<td class="fmenu" width="5%" >
<a href="#" onClick="ExportPolozku(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->druh;?>,<?php echo $riadok->stvrtrok;?>,'<?php echo $riadok->dap;?>');">
<img src='../obr/export.png' width=15 height=10 border=0 title='Export do XML' ></a>

<?php $cislo_cpop=1*$riadok->cpop; ?>

<td class="fmenu" width="15%" >
<a href="#" onClick="KvPdf(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->druh;?>,<?php echo $riadok->stvrtrok;?>,'<?php echo $riadok->dap;?>',<?php echo $cislo_cpop;?>);">
<img src='../obr/tlac.png' width=15 height=10 border=0 title='TlaËiù kontroln˝ v˝kaz DPH PDF' ></a>
&nbsp;&nbsp;&nbsp;
<a href="#" onClick="KvXml(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->druh;?>,<?php echo $riadok->stvrtrok;?>,'<?php echo $riadok->dap;?>',<?php echo $cislo_cpop;?>);">
<img src='../obr/export.png' width=15 height=10 border=0 title='Export kontrolnÈho v˝kazu DPH do XML' ></a>
&nbsp;&nbsp;&nbsp;
<a href="#" onClick="KvControl(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->druh;?>,<?php echo $riadok->stvrtrok;?>,'<?php echo $riadok->dap;?>',<?php echo $cislo_cpop;?>);">
<img src='../obr/pozor.png' width=15 height=10 border=0 title='Kontrolovaù kontroln˝ v˝kaz DPH iËdph(<?php echo $cpolicdph; ?>)' ></a>

<?php if ( $riadok->druh == 3 ) { ?>
&nbsp;&nbsp;&nbsp;
<a href="#" onClick="manualDodKvdph(<?php echo $riadok->cpid;?>,'<?php echo $riadok->ume;?>',<?php echo $riadok->stvrtrok;?>);">
<img src='../obr/vlozit.png' width=15 height=10 border=0 title='Manu·lny vstup kontroln˝ v˝kaz DPH ' ></a>


<?php                           } ?>

<td class="fmenu" width="5%" >
<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpid;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

</table>

<?php
     }
//koniec zoznam
?>


<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 490; left: 400; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 title='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 title='Zhasni EkoRobota' >
</div>

<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 450; left: 460; width:380; height:100;">

<table  class='ponuka' width='100%'>
<tr>
<td width='80%'>Menu EkoRobot - Koeficient pomernÈho odpoËÌtania DPH</td>
<td width='20%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' title='Zhasni menu' ></td>
</tr> 


<?php if( $cislo_druh == 3 ) { ?>
<tr>
<td width='100%' class='ponuka' colspan='2'>
<a href="#" onClick="Odpoc(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $stvrtrok;?>);">
Chcete odpoËÌtaù riadne priznanie DPH od dodatoËnÈho ?</a>
</td>
</tr>
<?php                        } ?>


<?php 
if( $koefmin == 0 OR $koefmin > 1 ) $koefmin=" 1.00";
?>

<tr><FORM name='fkoef' method='post' action='#' ><td width='100%' class='ponuka' colspan='2'>
Druhy dokladov s pomern˝m uplatnenÌm napr: 34,46,48 
<input type='text' name='h_druhykoef' id='h_druhykoef' size='30' maxlenght='30' value='<?php echo $druhykoef; ?>' > 
</td></tr>

<tr><td width='80%' class='ponuka' colspan='1'>
Koeficient z predch·dzaj˙ceho kalend·rneho roka </td><td width='20%' class='ponuka' colspan='1'>
<input type='text' name='h_koefmin' id='h_koefmin' size='4' maxlenght='4' value='<?php echo $koefmin; ?>' > 
</td></tr>

<tr><td width='100%' class='ponuka' colspan='2'> 
<a href="#" onClick="Prepoc(<?php echo $cislo_cpid;?>,'<?php echo $cislo_ume;?>',<?php echo $cislo_druh;?>,<?php echo $stvrtrok;?>);">
Chcete prepoËÌtaù pomern˝ odpoËet DPH ?</a>
</td></tr>

<?php if( $prepoc == 1 ) { ?>

<tr><td width='80%' class='ponuka' colspan='1'>
Suma 20% DPH za pomernÈ druhy celkom </td><td width='20%' class='ponuka' colspan='1'>
<input type='text' name='h_odpocall' id='h_odpocall' size='10' maxlenght='10' value='<?php echo $odpocall; ?>' > 
</td></tr>

<tr><td width='80%' class='ponuka' colspan='1'>
Suma 20% DPH za pomernÈ druhy upraven· </td><td width='20%' class='ponuka' colspan='1'>
<input type='text' name='h_odpocupr' id='h_odpocupr' size='10' maxlenght='10' value='<?php echo $odpocupr; ?>' > 
</td></tr>

<?php                    } ?>

<tr><td></td></FORM></tr></table> 
</div>

<?php
$robot=1;
$cislista = include("uct_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
