<HTML>
<?php

do
{
$sys = 'MZD';
$urov = 2000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];

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

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Kontrola nahrávania</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
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

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Kontrola nahratých miezd
</td>
<td align="right">
<span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kontrolasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kontrolasb'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   psys         INT(10),
   oc           INT(10),
   sum_dni      DECIMAL(10,2),
   sum_hod      DECIMAL(10,2),
   sum_hox      DECIMAL(10,2),
   dm518        DECIMAL(10,2),
   dm519        DECIMAL(10,2),
   uvaz         DECIMAL(10,2),
   zlydat       DECIMAL(10,0) DEFAULT 0,
   dm506        DECIMAL(10,2),
   pop          VARCHAR(80)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kontrolasy'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_kontrolasb'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,0,0,0,(nev+nrk),'' ".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,sum_dni,sum_hod,(sum_hot+sum_ban),0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_mzdprcsum$kli_uzid".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");


//max 7dni 518
if( $agrostav >= 0 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,hod,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc >= 0 AND dm = 518";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,hod,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_mzdmes".
" WHERE oc >= 0 AND dm = 518";
$dsql = mysql_query("$dsqlt");
}


//ak dovolenka narok-cerpane < 0
$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,0,0,0,-dni,'' ".
" FROM F$kli_vxcf"."_mzdzalvy".
" WHERE oc >= 0 AND dm >= 506 AND dm <= 508";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,0,0,0,-dni,'' ".
" FROM F$kli_vxcf"."_mzdmes".
" WHERE oc >= 0 AND dm >= 506 AND dm <= 508";
$dsql = mysql_query("$dsqlt");


//datum mimo rozsah
$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$pociatok=$kli_vrok."-".$kli_vmes."-01";
$koniec=$kli_vrok."-".$kli_vmes."-31";

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,hod,0,0,1,0,'' ".
" FROM F$kli_vxcf"."_mzdmes".
" WHERE oc >= 0 AND dp != '0000-00-00' AND ( dp < '$pociatok' OR dp > '$koniec' )";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,hod,0,0,1,0,'' ".
" FROM F$kli_vxcf"."_mzdmes".
" WHERE oc >= 0 AND dk != '0000-00-00' AND ( dk < '$pociatok' OR dk > '$koniec' )";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,hod,0,0,1,0,'' ".
" FROM F$kli_vxcf"."_mzdmes".
" WHERE dat < '$pociatok' OR dat > '$koniec' ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");
//exit;


//kontrola je prijem a ziadne odvody sum_hru, ozam_zp, ozam_np, ozam_sp, ozam_ip, ozam_pn
$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,0,0,200,0,'' ".
" FROM F$kli_vxcf"."_mzdprcsum$kli_uzid".
" WHERE oc >= 0 AND sum_hru != 0 AND ozam_zp = 0 AND ozam_np = 0 AND ozam_sp = 0 AND ozam_ip = 0 AND ozam_pn = 0 ";
$dsql = mysql_query("$dsqlt");
//exit;

//kontrola minimalnej mzdy NUJ
if( $fir_fico == '37986708' )
  {
$minhodmzd=2.759;


$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasb$kli_uzid"." SELECT".
" 0,oc,0,hod,0,0,0,0,1,0,'' ".
" FROM F$kli_vxcf"."_mzdprcvy$kli_uzid".
" WHERE oc >= 0 AND dm = 101 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasb$kli_uzid"." SELECT".
" 0,oc,0,0,kc,0,0,0,1,0,'' ".
" FROM F$kli_vxcf"."_mzdprcvy$kli_uzid".
" WHERE oc >= 0 AND dm >= 100 AND dm <= 499 AND dm != 204 AND dm != 211 AND dm != 223 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasb$kli_uzid"." SELECT".
" 9,oc,SUM(sum_dni),SUM(sum_hod),SUM(sum_hox),0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_kontrolasb$kli_uzid".
" WHERE oc >= 0 GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kontrolasb$kli_uzid WHERE psys = 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kontrolasb$kli_uzid SET dm518=sum_hox/sum_hod WHERE sum_hod > 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kontrolasb$kli_uzid SET dm519=(sum_hod*$minhodmzd)-sum_hox WHERE sum_hod > 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,dm519,0,9000,0,'' ".
" FROM F$kli_vxcf"."_kontrolasb$kli_uzid".
" WHERE oc >= 0 AND dm518 < $minhodmzd AND dm518 > 0 ";
$dsql = mysql_query("$dsqlt");

  }
//exit;
//koniec kontrola minimalnej mzdy NUJ

$dsqlt = "INSERT INTO F$kli_vxcf"."_kontrolasy$kli_uzid"." SELECT".
" 9,oc,SUM(sum_dni),SUM(sum_hod),SUM(sum_hox),SUM(dm518),SUM(dm519),0,SUM(zlydat),SUM(dm506),'' ".
" FROM F$kli_vxcf"."_kontrolasy$kli_uzid".
" WHERE oc >= 0 GROUP BY oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_kontrolasy$kli_uzid WHERE psys = 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_kontrolasy$kli_uzid,F$kli_vxcf"."_mzdkun SET uvaz=uva*7 WHERE F$kli_vxcf"."_kontrolasy$kli_uzid.oc=F$kli_vxcf"."_mzdkun.oc";
$dsql = mysql_query("$dsqlt");

//exit;

$sqltt = "SELECT * FROM F$kli_vxcf"."_kontrolasy$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_kontrolasy$kli_uzid".".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_kontrolasy".$kli_uzid.".oc >= 0 "."ORDER BY prie";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);



$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

if ( $j == 0 )
      {
?>

<table class="vstup" width="100%" >

<tr>
<td class="bmenu" width="5%">os.è.</td>
<td class="bmenu" width="20%">meno,priezvisko</td>
<td class="bmenu" width="5%" align="right">Pomer</td>
<td class="hvstup_zlte" width="10%" align="right">Dni</td>
<td class="hvstup_zlte" width="10%" align="right">Hodiny</td>
<td class="hvstup_zlte" width="10%" align="right">€</td>
<td class="bmenu" width="25%" > </td>
<td class="hvstup_zlte" width="4%" align="right">dni506</td>
<td class="hvstup_zlte" width="7%" align="right">hod.518/519</td>
<td class="hvstup_zlte" width="4%" align="right">Datum</td>
</tr>

<?php
      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

$h_hotp=0;
$h_hotv=0;
$h_hotp=$polozka->hotp;
$h_hotv=$polozka->hotv;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotp = $hotp + $h_hotp;
$Cislo=$hotp+"";

$hvstup="hvstup";
$hvstupz="hvstup_zlte";
$pozortext="";
if( $polozka->sum_dni == 0 AND $polozka->sum_hod == 0 AND $polozka->sum_hot <= 0 AND ( $polozka->pom != 9 AND $polozka->pom != 2 AND $polozka->pom != 7 AND $polozka->pom != 8 ) ) 
{ $hvstup="hvstup_bred"; $pozortext="Nulové hodiny alebo dni !?!?"; }
if( $polozka->dm518 > $polozka->uvaz AND $agrostav == 0 ) { $hvstup="hvstup_bred"; $pozortext="Preèerpaná DM 518, max. 7 dní v roku !?!?"; }
if( $polozka->dm519 > $polozka->uvaz AND $agrostav == 0 ) { $hvstup="hvstup_bred"; $pozortext="Preèerpaná DM 518, max. 7 dní v roku  !?!?"; }
if( $polozka->dm506 < 0 ) { $hvstup="hvstup_bred"; $pozortext="Preèerpaná dovolenka !?!?"; }
if( $polozka->zlydat > 0 AND $polozka->zlydat < 100 ) { $hvstup="hvstup_bred"; $pozortext="Dátum mimo úètovného mesica nahratý v mesaènej dávke !?!?"; }
if( $polozka->zlydat >= 200 AND $polozka->zlydat < 300 ) { $hvstup="hvstup_bred"; $pozortext="Je príjem a nie sú odvody !?!?"; }
if( $polozka->zlydat >= 9000 ) { $hvstup="hvstup_bred"; $pozortext="Minimálna hodinová mzda !?!? Rozdiel celkom hrubá mzda $polozka->dm519 Eur"; }

if( $polozka->pom == 9 AND $polozka->zlydat == 0 ) { $hvstup="hvstup_bsede"; $hvstupz="hvstup_bsede"; }
?>

<tr>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $polozka->oc; ?> <a href="#" onClick="window.open('../mzdy/mes_mzdy.php?copern=101&drupoh=1&page=1&zkun=1&vyb_osc=<?php echo $polozka->oc;?>','_self')">
<img src='../obr/orig.png' width=15 height=15 border=0 title='Úprava mesaèných položiek zamestnanca' ></a>

</td>
<td class="<?php echo $hvstup; ?>">
<?php if( $pozortext != '' ) { ?>
<img src='../obr/info.png' width=15 height=15 border=0 title='<?php echo $pozortext;?>' >
<?php                        } ?>
<?php echo $polozka->prie; ?> <?php echo $polozka->meno; ?></td>
<td class="<?php echo $hvstup; ?>" align="right"><?php echo $polozka->pom;?></td>
<td class="<?php echo $hvstupz; ?>" align="right"><?php echo $polozka->sum_dni;?></td>
<td class="<?php echo $hvstupz; ?>" align="right"><?php echo $polozka->sum_hod;?></td>
<td class="<?php echo $hvstupz; ?>" align="right"><?php echo $polozka->sum_hox;?></td>
<td class="<?php echo $hvstup; ?>" >
<a href="#" onClick="window.open('vyplat_paska.php?&copern=501&page=1&ostre=0&vyb_osc=<?php echo $polozka->oc;?>','_blank','<?php echo $tlcswin; ?>')">
<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 title='Výplatná páska zamestnanca' ></a>


<a href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_oc=<?php echo $polozka->oc;?>&h_oc=<?php echo $polozka->oc;?>'>
<img src='../obr/uprav.png' width=15 height=15 border=0 title="Úprava údajov o zamestnancovi"></a>
<a href="#" onClick="window.open('../mzdy/trvale.php?copern=1&drupoh=1&page=1&zkun=1&cislo_oc=<?php echo $polozka->oc;?>','_blank','<?php echo $tlcuwin; ?>')">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='Úprava trvalých položiek zamestnanca' ></a>
<a href="#" onClick="window.open('../mzdy/mes_mzdy.php?copern=101&drupoh=1&page=1&zkun=1&vyb_osc=<?php echo $polozka->oc;?>','_self')">
<img src='../obr/orig.png' width=15 height=15 border=0 title='Úprava mesaèných položiek zamestnanca' ></a>
<a href="#" onClick="window.open('../mzdy/deti.php?copern=1&drupoh=1&page=1&zkun=1&cislo_oc=<?php echo $polozka->oc;?>','_blank','<?php echo $tlcuwin; ?>')">
<img src='../obr/klienti.png' width=15 height=15 border=0 title='Deti zamestnanca' ></a>

<img src='../obr/import.png' width=15 height=15 border=0 title='Mzdový list zamestnanca' onClick="window.open('../mzdy/mzdevid.php?copern=10&drupoh=1&page=1&cislo_oc=<?php echo $polozka->oc;?>','_blank','<?php echo $tlcuwin; ?>')" >

</td>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $polozka->dm506; ?></td>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $polozka->dm518; ?> / <?php echo $polozka->dm519; ?></td>
<td class="<?php echo $hvstup; ?>" align="right">
<?php echo $polozka->zlydat; ?></td>
</tr>
<?php
}



$i = $i + 1;
$j = $j + 1;
  }

//koniec poloziek

?>

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_kontrolasy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvy'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcsum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneod'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneodx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcneody'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdcerp'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalmesx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzaltrnx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalddpx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalkunx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdzalprmx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
