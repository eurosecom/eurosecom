<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$copern = $_REQUEST['copern'];
$drupoh = $_REQUEST['drupoh'];
$h_drp = $_REQUEST['h_drp'];
$h_dap = $_REQUEST['h_dap'];

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

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$datum = $_REQUEST['datum'];
//echo $datum;

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcprizdphs
(
   er1          INT,
   psys         INT,
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT,
   skl          DECIMAL(10,0),
   poh          DECIMAL(10,0),
   ico          INT,
   fic          INT,
   dam          DATE
);
prcprizdphs;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


//pociatok a koniec mesiaca

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

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=1;
$mesk_dph=12;
$rokp_dph=$pole[1];


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

//koniec pociatok a koniec mesiaca


if( $copern == 40 )
{
//kontrola datum mimo rozsah alebo nulove ume

$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$pole = explode(".", $kli_vume);
$kli_ames=$pole[0];
$kli_arok=$pole[1];
$pocdat=$kli_arok."-01-01";
$kondat=$kli_arok."-12-31";

$psys=11;
while ($psys <= 17 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $doklad="sklpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $doklad="sklvyd"; }
//zober presun
if( $psys == 13 ) { $doklad="sklpre"; }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 2,$psys,ume,F$kli_vxcf"."_$doklad.dat,F$kli_vxcf"."_$doklad.dok,skl,poh,ico,0,datm ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE cis = 0 AND ( F$kli_vxcf"."_$doklad.dat < '$pocdat' OR F$kli_vxcf"."_$doklad.dat > '$kondat' OR ume = 0 )";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$psys=$psys+1;
  }

//exit;


$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=4 WHERE er1 > 1 AND ume != 0 ";
$oznac = mysql_query("$sqtoz"); 
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=5 WHERE er1 > 1 AND ume = 0 ";
$oznac = mysql_query("$sqtoz");


//presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys > 0 AND er1 > 1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//koniec kontrola datum

}
//koniec copern=40


if( $copern == 50 )
{
//kontrola doklady nahrate po $h_datp


$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

$datum = $_REQUEST['datum'];

$pole = explode(" ", $datum);
$datumx=$pole[0];
$casx=$pole[1];

$casx1 = explode(".", $casx);
$casa=$casx1[0];
$casb=$casx1[1];

$datumxsql=SqlDatum($datumx)." ".$casa.":".$casb;

$psys=11;
while ($psys <= 17 ) 
  {
//zober prijmove pokl
if( $psys == 11 ) { $doklad="sklpri"; }
//zober vydavkove pokl
if( $psys == 12 ) { $doklad="sklvyd"; }
//zober presun
if( $psys == 13 ) { $doklad="sklpre"; }


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 2,$psys,ume,F$kli_vxcf"."_$doklad.dat,F$kli_vxcf"."_$doklad.dok,skl,poh,ico,0,datm ".
" FROM F$kli_vxcf"."_$doklad".
" WHERE datm > '$datumxsql' AND ume <= $kli_vume ";

//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$psys=$psys+1;
  }

//exit;


$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=6 WHERE dok > 0 ";
$oznac = mysql_query("$sqtoz"); 

//presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * ".
" FROM F$kli_vxcf"."_prcprizdphs$kli_uzid".
" WHERE psys > 0 AND er1 > 1".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

}
//koniec copern=50

//tlac vsetky chyby

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE er1 > 0 ORDER BY er1,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);


?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Skladové kontroly</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
    
</script>
</HEAD>
<BODY class="white" >

<?php

if (File_Exists ("../tmp/prizdph$kli_vume.$kli_uzid.pdf")) { $soubor = unlink("../tmp/prizdph$kli_vume.$kli_uzid.pdf"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');


if( $copern >= 40 OR $copern == 50 )
{
$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');
}

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {

//hlavicka
if ( $j == 0 )
{



if( $copern >= 40 AND $drupoh == 1) //html;
   {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="5"><?php echo "Skladové kontroly - Chybové hlásenia "; ?>

<a href="#" onClick="window.open('sklad_kontrol.php?copern=<?php echo $copern;?>&drupoh=<?php echo $drupoh;?>&page=1', '_self',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=15 border=0 alt="Prepoèet kontrol po úpravách dokladov" ></a>

</td>
<td class="bmenu" colspan="5" align="right">
<?php echo "FIR$kli_vxcf $kli_nxcf strana $strana"; ?>
</td>
</tr>

<tr>
<td class="bmenu" width="10%">Úè.mes.</td>
<td class="bmenu" width="15%">Dátum</td>
<td class="bmenu" width="15%">Doklad</td>
<td class="bmenu" width="10%" align="right">Sklad</td>
<td class="bmenu" width="10%" align="right">Pohyb</td>
<td class="bmenu" width="40%">IÈO</td>
</tr>
<?php
   }



}
//koniec hlavicka j=0

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$faknul=$hlavicka->fak;
if( $hlavicka->fak == 0 ) $faknul="";

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->daz, 3);
  $rok=$rok-2000;
  $dazsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);


if( $copern >= 40 AND $drupoh == 1 )
   {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
if( $hlavicka->er1 > 0 ) { $hvstup="hvstup_bred"; }
?>

<?php if( $hlavicka->er1 == 1 ) { ?>
<tr><td class="hvstup" colspan="4" >V zaúètovaní dokladu je nulový úèet/pohyb</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 2 ) { ?>
<tr><td class="hvstup" colspan="4" >Viacnásobný výskyt kombinácie IÈO,Faktúra</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 3 ) { ?>
<tr><td class="hvstup" colspan="4" >Viacnásobný výskyt èísla dokladu</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 4 ) { ?>
<tr><td class="hvstup" colspan="4" >Dátum mimo rozsah úètovného roka</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 5 ) { ?>
<tr><td class="hvstup" colspan="4" >Úètovné obdobie 00.0000 ???</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 6 ) { ?>
<tr><td class="hvstup" colspan="4" >Doklad z ume <= <?php echo $kli_vume; ?> nahratý po <?php echo $datum; ?> dòa <?php echo $hlavicka->dam; ?> ???</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 99 ) { ?>
<tr><td class="hvstup" colspan="4" >Rozdiel hodnota fakúry - zaúètovanie dokladu</td></tr>
<?php                           } ?>

<tr>
<?php
if(  $hlavicka->psys != 0 )
{
?>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ume; ?> <?php echo $hlavicka->rdk; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $datsk; ?></td>
<td class="<?php echo $hvstup; ?>" >
<?php if( $hlavicka->psys == 11 )
  { ?>
<a href="#" onClick="window.open('vstp_u.php?copern=8&drupoh=1&page=1&cislo_skl=<?php echo $hlavicka->skl;?>&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="Úprava vybranej príjemky" ></a>

<?php 
  } ?>
<?php if( $hlavicka->psys == 12 )
  { ?>
<a href="#" onClick="window.open('vstp_u.php?copern=8&drupoh=2&page=1&cislo_skl=<?php echo $hlavicka->skl;?>&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="Úprava vybranej výdajky" ></a>

<?php 
  } ?>
<?php if( $hlavicka->psys == 13 )
  { ?>
<a href="#" onClick="window.open('vstp_u.php?copern=8&drupoh=3&page=1&cislo_skl=<?php echo $hlavicka->skl;?>&cislo_dok=<?php echo $hlavicka->dok;?>', '_blank',
 'width=940, height=' + vyskawin + ', top=0, left=40, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes' )">
<img src='../obr/zoznam.png' width=15 height=10 border=0 alt="Úprava vybranej presunky " ></a>

<?php 
  } ?>

<?php echo $hlavicka->dok; ?></td>

<td class="hvstup_zlte" width="10%" align="right"><?php echo $hlavicka->skl; ?></td>

<td class="<?php echo $hvstup; ?>" align="right"><?php echo $hlavicka->poh; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ico; ?> <?php echo $hlavicka->nai; ?></td>
<?php
}
?>

</tr>
<?php
   }
//koniec copern>=40 html


}
$i = $i + 1;
$j = $j + 1;

if( $par == 0 )
{
$par=1;
}
else
{
$par=0;
}

//nebudem strankovat if( $j == 27 ) $j=0;

  }
//koniec hlavicky


$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphs'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
