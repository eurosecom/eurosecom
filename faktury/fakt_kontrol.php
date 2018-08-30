<HTML>
<?php

do
{
$sys = 'UCT';
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
   uce          DECIMAL(10,0),
   ume          FLOAT(8,4),
   dat          DATE,
   dok          INT,
   dal          DATE,
   dol          INT,
   hod          DECIMAL(10,2),
   fak          DECIMAL(10,0),
   ico          DECIMAL(10,0),
   dni          DECIMAL(10,0),
   fic          INT
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


if( $copern == 1 )
{



/////////////////////////////////////////////////////////kontrola faktura aj dodak za ico

$sqtoz = "TRUNCATE TABLE F$kli_vxcf"."_prcprizdphs$kli_uzid ";
$oznac = mysql_query("$sqtoz");

//er1	psys	ume	dat	dok	hod	fak ico	fic

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,1,uce,ume,dat,dok,'',0,0,0,ico,0,0 FROM F$kli_vxcf"."_fakodb WHERE dok >= 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,11,0,ume,'',0,dat,dok,0,0,ico,0,0 FROM F$kli_vxcf"."_fakdol WHERE dok >= 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphs$kli_uzid"." SELECT".
" 0,1,MAX(uce),MAX(ume),MAX(dat),MAX(dok),MAX(dal),MAX(dol),hod,MAX(fak),ico,0,99 FROM F$kli_vxcf"."_prcprizdphs$kli_uzid"." WHERE dok >= 0 GROUP BY ico";
$dsql = mysql_query("$dsqlt");

//exit;

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE fic != 99";
$oznac = mysql_query("$sqtoz");

$sqtoz = "DELETE FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE dok = 0 OR dol = 0 ";
$oznac = mysql_query("$sqtoz");

$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET dni=datediff(dat, dal) WHERE dok != 0 AND dol != 0 ";
$oznac = mysql_query("$sqtoz"); 

//nastav eror ak je fak aj dod za ico a datumy su < 60
$sqtoz = "UPDATE F$kli_vxcf"."_prcprizdphs$kli_uzid SET er1=1 WHERE fic = 99 AND dok != 0 AND dol != 0 ";
$oznac = mysql_query("$sqtoz"); 

//exit;

/////////////////////////////////////////////////////////koniec kontrola faktura aj dodak za ico


///////////////////////////////////////////////////////////////////////////////////presun ak er1 > 1 do chyb
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcprizdphsy$kli_uzid "." SELECT * FROM F$kli_vxcf"."_prcprizdphs$kli_uzid WHERE er1 > 0 ";
$dsql = mysql_query("$dsqlt");



////////////////////////////////////////////////////////////////////tlac vsetky chyby

$sqltt = "SELECT * FROM F$kli_vxcf"."_prcprizdphsy".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_ico".
" ON F$kli_vxcf"."_prcprizdphsy$kli_uzid".".ico=F$kli_vxcf"."_ico.ico".
" WHERE er1 > 0 ORDER BY er1,ume,dok";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
}

?>

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Odbyt kontroly</title>
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

//<a href='vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=31100&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT
//&cislo_dok=780007&h_fak=780007&h_dol=0&h_prf=0'>

function upravFakt( uce, dok )
                {              

window.open('vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=1&page=1&hladaj_uce=' + uce + '&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&cislo_dok=' + dok + '&h_dol=0&h_prf=0'
, '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }

function upravDod( dok )
                {              

window.open('vstf_u.php?regpok=0&vyroba=0&copern=8&drupoh=11&page=1&hladaj_uce=88801&h_tlsl=1&h_tltv=0&rozb1=NOT&rozb2=NOT&cislo_dok=' + dok + '&h_dol=0&h_prf=0'
, '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );

                }
    
</script>
</HEAD>
<BODY class="white" >

<?php

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
$par=0;
$strana=1;
  while ($i <= $pol )
  {

//hlavicka
if ( $j == 0 )
{



if( $copern == 1 AND $drupoh == 1) //html;
   {
?>
<table class="vstup" width="100%" >
<tr>
<td class="bmenu" colspan="3"><?php echo "Odbyt kontroly - Chybové hlásenia "; ?>
<a href="#" onClick="window.open('fakt_kontrol.php?copern=1&drupoh=1&page=1', '_self');">
<img src='../obr/ok.png' width=20 height=15 border=0 title="Chybové hlásenia prepoèet po úpravách dokladov" ></a>
</td>
<td class="bmenu" colspan="2" align="right">
<?php echo "FIR$kli_vxcf $kli_nxcf"; ?>
</td>
</tr>

<tr>
<td class="bmenu" width="10%">Úè.mes.</td>
<td class="bmenu" width="10%">Dátum</td>
<td class="bmenu" width="10%" align="right">Faktúra</td>
<td class="bmenu" width="10%">Dátum</td>
<td class="bmenu" width="10%" align="right">Dodací list</td>
<td class="bmenu" width="5%">Dni</td>
<td class="bmenu" width="45%">IÈO</td>

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
  list ($rok, $mes, $den) = split ('[-]', $hlavicka->dal, 3);
  $rok=$rok-2000;
  $dalsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);


if( $copern == 1 AND $drupoh == 1 )
   {
$hvstup="hvstup";
if( $par == 1 ) { $hvstup="hvstup_bsede"; }
if( $hlavicka->er1 > 0 ) { $hvstup="hvstup_bred"; }
?>

<?php if( $hlavicka->er1 == 1 ) { ?>
<tr><td class="hvstup" colspan="4" >Faktúra aj dodací list za IÈO</td></tr>
<?php                           } ?>

<?php if( $hlavicka->er1 == 2 ) { ?>
<tr><td class="hvstup" colspan="4" >Kontrola 2</td></tr>
<?php                           } ?>



<tr>

<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ume; ?></td>
<td class="<?php echo $hvstup; ?>" ><?php echo $datsk; ?></td>
<td class="<?php echo $hvstup; ?>" align="right" >

<?php echo $hlavicka->dok; ?>
<img src='../obr/uprav.png' width=15 height=15 onClick="upravFakt(<?php echo $hlavicka->uce; ?>, <?php echo $hlavicka->dok; ?>);" border=1 title="Úprava faktúry" >

</td>
<td class="<?php echo $hvstup; ?>" ><?php echo $dalsk; ?></td>
<td class="<?php echo $hvstup; ?>" align="right" >

<?php echo $hlavicka->dol; ?>
<img src='../obr/orig.png' width=15 height=15 onClick="upravDod(<?php echo $hlavicka->fak; ?>);" border=1 title="Úprava dodacieho listu" >

<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->dni; ?></td>

</td>
<td class="<?php echo $hvstup; ?>" ><?php echo $hlavicka->ico; ?> <?php echo $hlavicka->nai; ?> <?php echo $hlavicka->mes; ?></td>


</tr>
<?php
   }
//koniec copern=1 html


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
//$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_prcprizdphsy'.$kli_uzid;
//$vysledok = mysql_query("$sqlt");

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
