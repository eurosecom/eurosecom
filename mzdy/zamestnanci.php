<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$copern = 1*$_REQUEST['copern'];
$urov = 2000;
$zana = 1*$_REQUEST['zana'];
$sys = 'MZD';
if( $zana == 1 ) $sys="ANA";

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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvmzd";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvmzd = include("../mzdy/vtvmzd.php");
endif;
$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;


if( $copern == 9998 )
  {
$_SESSION['newzam']=1;

$vsql = "CREATE TABLE F".$kli_vxcf."_mzdkunnewzam SELECT * FROM F".$kli_vxcf."_mzdkun WHERE oc < 0 ";
$vytvor = mysql_query("$vsql");
$sql = "ALTER TABLE F".$kli_vxcf."_mzdkunnewzam MODIFY oc int(7) PRIMARY KEY auto_increment ";
$vysledek = mysql_query("$sql");

$copern=1;
  }
if( $copern == 9999 )
  {
$_SESSION['newzam']=0;
$copern=1;
  }

$mzdkun="mzdkun";
if( $_SESSION['newzam'] == 1 ) { $mzdkun="mzdkunnewzam"; }

$tlacitkoenter=0;
//if( $_SESSION['nieie'] == 1 AND $_SESSION['chrome'] == 0 AND $_SESSION['safari'] == 0 ) { $tlacitkoenter=1; }

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

//tlacove okno
$tlcuwin="width=850, height=' + vyskawin + ', top=0, left=250, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$sql = "ALTER TABLE F$kli_vxcf"."_$mzdkun MODIFY rdc VARCHAR(6) NOT NULL ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdzalkun MODIFY rdc VARCHAR(6) NOT NULL ";
$vysledek = mysql_query("$sql");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

// cislo operacie
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$h_oc = strip_tags($_REQUEST['h_oc']);
$h_meno = strip_tags($_REQUEST['h_meno']);
$h_prie = strip_tags($_REQUEST['h_prie']);
$h_prbd = StrTr($h_prie, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$h_titl = strip_tags($_REQUEST['h_titl']);
$h_akt = strip_tags($_REQUEST['h_akt']);
$h_rdc = strip_tags($_REQUEST['h_rdc']);
$h_rdk = strip_tags($_REQUEST['h_rdk']);
$h_dar = strip_tags($_REQUEST['h_dar']);
$h_mnr = strip_tags($_REQUEST['h_mnr']);
$h_rodn = strip_tags($_REQUEST['h_rodn']);
$h_zuli = strip_tags($_REQUEST['h_zuli']);
$h_zcdm = strip_tags($_REQUEST['h_zcdm']);
$h_zpsc = strip_tags($_REQUEST['h_zpsc']);
$h_zmes = strip_tags($_REQUEST['h_zmes']);
$h_ztel = strip_tags($_REQUEST['h_ztel']);
$h_zema = strip_tags($_REQUEST['h_zema']);

$h_cop = strip_tags($_REQUEST['h_cop']);
$h_dan = strip_tags($_REQUEST['h_dan']);
$h_pom = strip_tags($_REQUEST['h_pom']);
$h_kat = strip_tags($_REQUEST['h_kat']);
$h_uva = strip_tags($_REQUEST['h_uva']);
$h_uvazn = strip_tags($_REQUEST['h_uvazn']);
$h_wms = strip_tags($_REQUEST['h_wms']);
$h_stz = strip_tags($_REQUEST['h_stz']);
$h_zkz = strip_tags($_REQUEST['h_zkz']);
$h_dav = strip_tags($_REQUEST['h_dav']);
$h_nev = strip_tags($_REQUEST['h_nev']);
$h_nrk = strip_tags($_REQUEST['h_nrk']);
$h_crp = strip_tags($_REQUEST['h_crp']);
$h_znah = strip_tags($_REQUEST['h_znah']);
$h_znem = strip_tags($_REQUEST['h_znem']);
$h_doch = strip_tags($_REQUEST['h_doch']);
$h_docv = strip_tags($_REQUEST['h_docv']);
$h_dad = strip_tags($_REQUEST['h_dad']);
$h_dvy = strip_tags($_REQUEST['h_dvy']);
$h_cdss = strip_tags($_REQUEST['h_cdss']);

$h_roh = strip_tags($_REQUEST['h_roh']);
$h_spno = strip_tags($_REQUEST['h_spno']);
$h_spnie = strip_tags($_REQUEST['h_spnie']);
$h_dsp = strip_tags($_REQUEST['h_dsp']);
$h_dav = strip_tags($_REQUEST['h_dav']);
$h_deti_sp = 1*$_REQUEST['h_deti_sp'];
$h_zrz_dn = strip_tags($_REQUEST['h_zrz_dn']);
$h_ziv_dn = strip_tags($_REQUEST['h_ziv_dn']);
$h_deti_dn = strip_tags($_REQUEST['h_deti_dn']);

$h_zpnie = strip_tags($_REQUEST['h_zpnie']);
$h_zpno = strip_tags($_REQUEST['h_zpno']);
$h_dvp = strip_tags($_REQUEST['h_dvp']);
$h_zdrv = strip_tags($_REQUEST['h_zdrv']);
$h_trd = strip_tags($_REQUEST['h_trd']);
$h_sz0 = strip_tags($_REQUEST['h_sz0']);
$h_sz1 = strip_tags($_REQUEST['h_sz1']);
$h_sz2 = strip_tags($_REQUEST['h_sz2']);
$h_sz3 = strip_tags($_REQUEST['h_sz3']);
$h_sz4 = strip_tags($_REQUEST['h_sz4']);
$h_sz5 = strip_tags($_REQUEST['h_sz5']);

$h_vban = strip_tags($_REQUEST['h_vban']);
$h_uceb = strip_tags($_REQUEST['h_uceb']);
$h_numb = strip_tags($_REQUEST['h_numb']);
$h_vsy = strip_tags($_REQUEST['h_vsy']);
$h_ksy = strip_tags($_REQUEST['h_ksy']);
$h_ssy = strip_tags($_REQUEST['h_ssy']);

//novy zamestnanec
$novy=0;
    if ( $copern == 5 )
    {
$novy=1;
$maxoc=0;
$new_oc=0;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun WHERE oc > 0 ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $new_oc=$riaddok->oc+1;
  }

if( $new_oc == 0 ) $new_oc=1;

$uloztt = "INSERT INTO F$kli_vxcf"."_$mzdkun ( oc ) VALUES ( '$new_oc' ); ";  
//echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

$copern=8;
$cislo_oc=$new_oc;
$h_oc=$new_oc;
    }
//koniec novy zamestnanec


$zmes=0;
if( $copern == 108 ) { $cislo_oc = 1*$_SESSION['vyb_osc']; $h_oc=$cislo_oc; $copern=8; $zmes=1; }

//import z ../import/mzdkun.CSV
    if ( $copern == 55 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/MZDKUN.CSV , MZDTRN.CSV , MZDDETI.CSV a MZDDDP.CSV ?") )
         { window.close()  }
else
         { location.href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=56&page=1'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/MZDKUN.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MZDKUN.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MZDKUN.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_oc = $pole[0];
  $x_meno = $pole[1];
  $x_prie = $pole[2];
  $x_titl = $pole[3];
  $x_rdc = $pole[4];
  $x_rdk = $pole[5];

  $x_mnr = $pole[6];
  $x_zmes = $pole[7];
  $x_zuli = $pole[8];
  $x_zpsc = $pole[9];
  $x_pom = $pole[10];
  $x_kat = $pole[11];
  $x_wms = $pole[12];
  $x_stz = $pole[13];
  $x_zkz = $pole[14];
  $x_uva = $pole[15];
  $x_dan = $pole[16];
  $x_daz = $pole[17];
  $x_nev = $pole[18];
  $x_nrk = $pole[19];
  $x_crp = $pole[20];
  $x_znah = $pole[21];
  $x_znem = $pole[22];
  $x_doch = $pole[23];
  $x_dad = $pole[24];
  $x_dvy = $pole[25];

  $x_cdss = $pole[26];
  $x_roh = $pole[27];
  $x_spno = $pole[28];
  $x_deti_sp = $pole[29];
  $x_zrzdn = $pole[30];
  $x_zivdn = $pole[31];
  $x_detidn = $pole[32];
  $x_zpno = $pole[33];
  $x_dvp = $pole[34];
  $x_zdrv = $pole[35];

  $x_trd = $pole[36];
  $x_sz0 = $pole[37];
  $x_sz1 = $pole[38];
  $x_sz2 = $pole[39];
  $x_sz3 = $pole[40];
  $x_sz4 = $pole[41];

  $x_vban = $pole[42];
  $x_uceb = $pole[43];
  $x_numb = $pole[44];
  $x_vsy = $pole[45];
  $x_ksy = $pole[46];
  $x_ssy = $pole[47];

  $x_kon = $pole[48];

  $dan_sql = SqlDatum($x_dan);
  $daz_sql = SqlDatum($x_daz);
  $dad_sql = SqlDatum($x_dad);
  $dvp_sql = SqlDatum($x_dvp);
  $rdc1=substr($x_rdc,0,2);
  $rdc2=substr($x_rdc,2,2);
  $rdc3=substr($x_rdc,4,2);
  if( $rdc2 > 50 ) $rdc2=$rdc2-50; 
  $dar_sql="19".$rdc1."-".$rdc2."-".$rdc3;

$x_prbd = StrTr($x_prie, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
 
$sqult = "INSERT INTO F$kli_vxcf"."_$mzdkun ( oc,meno,prie,prbd,titl,rdc,rdk,dar,".
" mnr,zmes,zuli,zpsc,pom,kat,wms,stz,zkz,uva,dan,dav,".
" nev,nrk,crp,znah,znem,doch,dad,dvy,".
" cdss,roh,spno,deti_sp,zrz_dn,ziv_dn,deti_dn,zpno,dvp,dsp,zdrv,".
" trd,sz0,sz1,sz2,sz3,sz4,vban,uceb,numb,vsy,ksy,ssy )".
" VALUES ( '$x_oc', '$x_meno', '$x_prie', '$x_prbd', '$x_titl', '$x_rdc', '$x_rdk', '$dar_sql',".
" '$x_mnr', '$x_zmes', '$x_zuli', '$x_zpsc', '$x_pom', '$x_kat', '$x_wms', '$x_stz', '$x_zkz', '$x_uva', '$dan_sql', '$daz_sql',".
" '$x_nev', '$x_nrk', '$x_crp', '$x_znah', '$x_znem', '$x_doch', '$dad_sql', '$x_dvy',".
" '$x_cdss', '$x_roh', '$x_spno', '$x_deti_sp', '$x_zrzdn', '$x_zivdn', '$x_detidn', '$x_zpno', '$dvp_sql', '$dvp_sql', '$x_zdrv',".
" '$x_trd', '$x_sz0', '$x_sz1', '$x_sz2', '$x_sz3', '$x_sz4',".
" '$x_vban', '$x_uceb', '$x_numb', '$x_vsy', '$x_ksy', '$x_ssy' ); "; 

//echo $sqult;

$c_oc=1*$x_oc;
if( $c_oc > 0 ) { $ulozene = mysql_query("$sqult"); }


}

echo "Tabulka F$kli_vxcf"."_$mzdkun!"." naimportovan· <br />";

fclose ($subor);

if( file_exists("../import/FIR$kli_vxcf/MZDTRN.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MZDTRN.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MZDTRN.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_oc = $pole[0];
  $x_dm = $pole[1];
  $x_kc = $pole[2];
  $x_mn = $pole[3];
  $x_trx1 = $pole[4];
  $x_trx2 = $pole[5];


  $x_uceb = $pole[6];
  $x_numb = $pole[7];
  $x_vsy = $pole[8];
  $x_ksy = $pole[9];
  $x_ssy = $pole[10];

  $x_kon = $pole[11];

$sqult = "INSERT INTO F$kli_vxcf"."_mzdtrn ( oc,dm,kc,mn,trx1,trx2,uceb,numb,vsy,ksy,ssy )".
" VALUES ( '$x_oc', '$x_dm', '$x_kc', '$x_mn', '$x_trx1', '$x_trx2', '$x_uceb', '$x_numb', '$x_vsy', '$x_ksy', '$x_ssy' ); "; 

//echo $sqult;

$c_oc=1*$x_oc;
if( $c_oc > 0 ) { $ulozene = mysql_query("$sqult"); }


}

echo "Tabulka F$kli_vxcf"."_mzdtrn!"." naimportovan· <br />";

fclose ($subor);

if( file_exists("../import/FIR$kli_vxcf/MZDDETI.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MZDDETI.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MZDDETI.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_oc = $pole[0];
  $x_md = $pole[1];
  $x_rcd = $pole[2];
  $x_dr = $pole[3];
  $x_p1 = $pole[4];
  $x_p2 = $pole[5];
  $x_p3 = $pole[6];
  $x_p4 = $pole[7];

  $x_kon = $pole[8];


  $dr_sql = SqlDatum($x_dr);

$sqult = "INSERT INTO F$kli_vxcf"."_mzddeti ( oc,md,rcd,dr,p1,p2,p3,p4 )".
" VALUES ( '$x_oc', '$x_md', '$x_rcd', '$dr_sql', '$x_p1', '$x_p2', '$x_p3', '$x_p4' ); "; 

//echo $sqult;

$c_oc=1*$x_oc;
if( $c_oc > 0 ) { $ulozene = mysql_query("$sqult"); }


}

echo "Tabulka F$kli_vxcf"."_mzddeti!"." naimportovan· <br />";

fclose ($subor);

if( file_exists("../import/FIR$kli_vxcf/MZDDDP.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/MZDDDP.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/MZDDDP.CSV", "r");
while (! feof($subor))
{
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);
  $x_oc = $pole[0];
  $x_perzdd = $pole[1];
  $x_fixzdd = $pole[2];
  $x_perpdd = $pole[3];
  $x_fixpdd = $pole[4];
  $x_cddp = $pole[5];
  $x_czm = $pole[6];
  $x_dtd = $pole[7];

  $x_kon = $pole[8];

  $dtd_sql = SqlDatum($x_dtd);

$sqult = "INSERT INTO F$kli_vxcf"."_mzdddp ( oc,perz_dd,fixz_dd,perp_dd,fixp_dd,cddp,czm,dtd )".
" VALUES ( '$x_oc', '$x_perzdd', '$x_fixzdd', '$x_perpdd', '$x_fixpdd', '$x_cddp', '$x_czm', '$dtd_sql' ); "; 

//echo $sqult;

$c_oc=1*$x_oc;
if( $c_oc > 0 ) { $ulozene = mysql_query("$sqult"); }


}

echo "Tabulka F$kli_vxcf"."_mzdddp!"." naimportovan· <br />";

fclose ($subor);

    }

//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r zoznamu zamestnancov , trval˝ch poloûiek , ˙dajov o deùoch a DDP ?") )
         { window.close()  }
else
         { location.href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=167&page=1'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_$mzdkun';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_$mzdkun!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdtrn';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdtrn!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzddeti';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzddeti!"." vynulovan· <br />";

$sqlt = 'TRUNCATE F'.$kli_vxcf.'_mzdddp';
$vysledok = mysql_query("$sqlt");
//echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_mzdddp!"." vynulovan· <br />";

    }

// 5=ulozenie polozky do databazy nahratej v zamestnanci.php
// 6=vymazanie polozky potvrdene v zamestnanci.php
$uloz="NO";
$zmaz="NO";
$uprav="NO";
if ( $copern == 15 || $copern == 16 )
     {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
//ulozenie novej
if ( $copern == 15 )
    {
  $dar_sql = SqlDatum($h_dar);
  $dan_sql = SqlDatum($h_dan);
  $daz_sql = SqlDatum($h_daz);
  $dad_sql = SqlDatum($h_dad);
  $dvp_sql = SqlDatum($h_dvp);
  $dsp_sql = SqlDatum($h_dsp);

$uloztt = "INSERT INTO F$kli_vxcf"."_$mzdkun ( oc,meno,prie,rodn,prbd,titl,rdc,rdk,dar,".
" mnr,cop,zmes,zuli,zpsc,pom,kat,wms,stz,zkz,uva,uvazn,dan,dav,".
" nev,nrk,crp,znah,znem,doch,dad,dvy,".
" cdss,roh,spno,deti_sp,zrz_dn,ziv_dn,deti_dn,zpno,zpnie,dvp,zdrv,".
" spnie,dsp,trd,sz0,sz1,sz2,sz3,sz4,sz5,zema,ztel,zcdm ".
"  )".
" VALUES ( '$h_oc', '$h_meno', '$h_prie', '$h_rodn', '$h_prbd', '$h_titl', '$h_rdc', '$h_rdk', '$dar_sql',".
" '$h_mnr', '$h_cop', '$h_zmes', '$h_zuli', '$h_zpsc', '$h_pom', '$h_kat', '$h_wms', '$h_stz', '$h_zkz', '$h_uva', '$h_uvazn', '$dan_sql', '$daz_sql',".
" '$h_nev', '$h_nrk', '$h_crp', '$h_znah', '$h_znem', '$h_doch', '$dad_sql', '$h_dvy',".
" '$h_cdss', '$h_roh', '$h_spno', '$h_deti_sp', '$h_zrzdn', '$h_zivdn', '$h_detidn', '$h_zpno', '$h_zpnie', '$dvp_sql', '$h_zdrv',".
" '$h_spnie', '$dsp_sql', '$h_trd', '$h_sz0', '$h_sz1', '$h_sz2', '$h_sz3', '$h_sz4', '$h_sz5', '$h_zema', '$h_ztel', '$h_zcdm' ); ";  

echo $uloztt;
$ulozene = mysql_query("$uloztt"); 

$copern=1;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
//echo "POLOéKA oc:$h_oc SPR¡VNE ULOéEN¡ ";
endif;
    }
//koniec ulozenia
//vymazanie
if ( $copern == 16 )
    {

$zmazttt = "UPDATE F$kli_vxcf"."_$mzdkun SET akt=9 WHERE oc='$cislo_oc'";
//echo $upravttt;

$zmazane = mysql_query("$zmazttt");  
$copern=1;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="NO";
//echo "POLOéKA oc:$cislo_oc BOLA VYMAZAN¡ ";
endif;
    }
     }
//koniec vymazania a ulozenia

//uprava 18
if ( $copern == 18 )
  {

$cislo_oc = strip_tags($_REQUEST['cislo_oc']);

  $dar_sql = SqlDatum($h_dar);
  $dan_sql = SqlDatum($h_dan);
  $dav_sql = SqlDatum($h_dav);
  $daz_sql = SqlDatum($h_daz);
  $dad_sql = SqlDatum($h_dad);
  $dvp_sql = SqlDatum($h_dvp);
  $dsp_sql = SqlDatum($h_dsp);

$upravttt = "UPDATE F$kli_vxcf"."_$mzdkun SET  meno='$h_meno', titl='$h_titl',".
" prie='$h_prie', rodn='$h_rodn', prbd='$h_prbd', zuli='$h_zuli', zpsc='$h_zpsc', zmes='$h_zmes', ztel='$h_ztel',".
" zema='$h_zema', rdc='$h_rdc', rdk='$h_rdk', zcdm='$h_zcdm', dar='$dar_sql',".
" mnr='$h_mnr', cop='$h_cop', dan='$dan_sql', dav='$dav_sql', pom='$h_pom',".
" uva='$h_uva', uvazn='$h_uvazn', kat='$h_kat', stz='$h_stz', zkz='$h_zkz', pom='$h_pom',".
" zdrv='$h_zdrv', dvp='$dvp_sql', zpno='$h_zpno', zpnie='$h_zpnie',".
" znah='$h_znah', nrk='$h_nrk', nev='$h_nev', crp='$h_crp', znem='$h_znem',".
" cdss='$h_cdss', dsp='$dsp_sql', spno='$h_spno', spnie='$h_spnie', deti_sp='$h_deti_sp',".
" doch='$h_doch', docv='$h_docv', dad='$dad_sql', dvy='$h_dvy',".
" deti_dn='$h_deti_dn', ziv_dn='$h_ziv_dn', zrz_dn='$h_zrz_dn',".
" sz0='$h_sz0', sz1='$h_sz1', sz2='$h_sz2', sz3='$h_sz3', sz4='$h_sz4',".
" wms='$h_wms', vban='$h_vban', roh='$h_roh'  WHERE oc='$cislo_oc'";
//echo $upravttt;

$upravene = mysql_query("$upravttt"); 
$copern=8;
$cislo_oc = $h_oc;
if (!$upravene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA UPRAVEN¡ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
//echo "POLOéKA oc:$cislo_oc UPRAVEN¡ ";
endif;
  }


//uprava faktury hlavicka
if ( $copern == 8 )
    {
$sqltt = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc = $cislo_oc ".
"";
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_oc = $riadok->oc;
$h_meno = $riadok->meno;
$h_prie = $riadok->prie;
$h_prbd = StrTr($h_prie, "·‰ËÔÈÏÎÌæÚÙÛˆ‡¯öù˙˘¸˝û¡ƒ»œ…ÃÀÕº“”÷‘ÿ¿äç⁄Ÿ‹›é",
"aacdeeeilnooorrstuuuyzAACDEEELINOOORRSTUUUYZ");
$h_titl = $riadok->titl;
$h_akt = $riadok->akt;
$h_rdc = $riadok->rdc;
$h_rdk = $riadok->rdk;
$h_dar = $riadok->dar;
$h_mnr = $riadok->mnr;
$h_rodn = $riadok->rodn;
$h_zuli = $riadok->zuli;
$h_zcdm = $riadok->zcdm;
$h_zpsc = $riadok->zpsc;
$h_zmes = $riadok->zmes;
$h_ztel = $riadok->ztel;
$h_zema = $riadok->zema;

$h_cop = $riadok->cop;
$h_dan = $riadok->dan;
$h_pom = $riadok->pom;
$h_kat = $riadok->kat;
$h_uva = $riadok->uva;
$h_uvazn = $riadok->uvazn;
$h_wms = $riadok->wms;
$h_stz = $riadok->stz;
$h_zkz = $riadok->zkz;
$h_dav = $riadok->dav;
$h_nev = $riadok->nev;
$h_nrk = $riadok->nrk;
$h_crp = $riadok->crp;
$h_znah = $riadok->znah;
$h_znem = $riadok->znem;
$h_doch = $riadok->doch;
$h_docv = $riadok->docv;
$h_dad = $riadok->dad;
$h_dvy = $riadok->dvy;
$h_cdss = $riadok->cdss;

$h_roh = $riadok->roh;
$h_spno = $riadok->spno;
$h_spnie = $riadok->spnie;
$h_dsp = $riadok->dsp;
$h_dav = $riadok->dav;
$h_deti_sp = $riadok->deti_sp;
$h_zrz_dn = $riadok->zrz_dn;
$h_ziv_dn = $riadok->ziv_dn;
$h_deti_dn = $riadok->deti_dn;

$h_zpno = $riadok->zpno;
$h_zpnie = $riadok->zpnie;
$h_dvp = $riadok->dvp;
$h_zdrv = $riadok->zdrv;
$h_trd = $riadok->trd;
$h_sz0 = $riadok->sz0;
$h_sz1 = $riadok->sz1;
$h_sz2 = $riadok->sz2;
$h_sz3 = $riadok->sz3;
$h_sz4 = $riadok->sz4;
$h_sz5 = $riadok->sz5;

$h_vban = $riadok->vban;
$h_uceb = $riadok->uceb;
$h_numb = $riadok->numb;
$h_vsy = $riadok->vsy;
$h_ksy = $riadok->ksy;
$h_ssy = $riadok->ssy;

  $dar_sk = SkDatum($h_dar);
  $dan_sk = SkDatum($h_dan);
  $dav_sk = SkDatum($h_dav);
  $daz_sk = SkDatum($h_daz);
  $dad_sk = SkDatum($h_dad);
  $dvp_sk = SkDatum($h_dvp);
  $dsp_sk = SkDatum($h_dsp);

  }

$ibanb=""; $swft="";
$sqlttr = "SELECT * FROM F$kli_vxcf"."_mzdtextmzd WHERE invt = $cislo_oc ";
$sqlr = mysql_query("$sqlttr"); 
  if (@$zaznamr=mysql_data_seek($sqlr,0))
  {
  $riadokr=mysql_fetch_object($sqlr);

$ibanb = $riadokr->ziban;
$swft = $riadokr->zswft;
  }

//echo "ibanb".$ibanb;
    }
//koniec copern=8 nacitanie



//8=uprava
if ( $copern == 8 )
  {
if( $novy == 0 AND $zmes == 0 ) $cislo_oc = strip_tags($_REQUEST['h_oc']);
  }


//6=vymazanie zamestnanca neaktivneho dav < 1.1.2012
if ( $copern == 6 )
  {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$page = strip_tags($_REQUEST['page']);
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù zamestnanca os.ËÌslo <?php echo $cislo_oc; ?> ?") )
         { window.close();  }
else
  var okno = window.open("zamestnanci.php?sys=MZD&copern=6666&page=<?php echo $page;?>&cislo_oc=<?php echo $cislo_oc;?>","_self");
</script>

<?php
exit;
  }

if ( $copern == 6666 )
  {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$nezmaz=1;

$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalsum WHERE oc = $cislo_oc ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("Zamestnanec os.ËÌslo <?php echo $cislo_oc; ?> m· mzdovÈ pohyby v roku <?php echo $kli_vrok; ?>.  \r NemÙûete ho vymazaù !");
window.close();
</script>
<?php
exit;
}
if( $umesp == 0 ) { $nezmaz=0; }

$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalmes WHERE oc = $cislo_oc ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("Zamestnanec os.ËÌslo <?php echo $cislo_oc; ?> m· mzdovÈ pohyby v roku <?php echo $kli_vrok; ?>.  \r NemÙûete ho vymazaù !");
window.close();
</script>
<?php
exit;
}
if( $umesp == 0 ) { $nezmaz=0; }

$poslhh = "SELECT * FROM F$kli_vxcf"."_mzdzalvy WHERE oc = $cislo_oc ";
$posl = mysql_query("$poslhh"); 
$umesp = mysql_num_rows($posl);

if( $umesp > 0 )
{
?>
<script type="text/javascript">
alert ("Zamestnanec os.ËÌslo <?php echo $cislo_oc; ?> m· mzdovÈ pohyby v roku <?php echo $kli_vrok; ?>.  \r NemÙûete ho vymazaù !");
window.close();
</script>
<?php
exit;
}
if( $umesp == 0 ) { $nezmaz=0; }

if( $nezmaz == 0 )
  {
echo "Maûem zamestnanca os.ËÌslo ".$cislo_oc;

$kli_vromaz=$kli_vrok-1;
$datmaz=$kli_vromaz."-01-01";

$dsqlt = "UPDATE F$kli_vxcf"."_mzdtrn,F$kli_vxcf"."_$mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdtrn.oc=F$kli_vxcf"."_$mzdkun.oc ".
" AND F$kli_vxcf"."_$mzdkun.pom = 9 AND F$kli_vxcf"."_$mzdkun.dav < '$datmaz' AND F$kli_vxcf"."_$mzdkun.dav != '0000-00-00' AND F$kli_vxcf"."_mzdtrn.oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzddeti,F$kli_vxcf"."_$mzdkun ".
" SET p4=9 ".
" WHERE F$kli_vxcf"."_mzddeti.oc=F$kli_vxcf"."_$mzdkun.oc ".
" AND F$kli_vxcf"."_$mzdkun.pom = 9 AND F$kli_vxcf"."_$mzdkun.dav < '$datmaz' AND F$kli_vxcf"."_$mzdkun.dav != '0000-00-00' AND F$kli_vxcf"."_mzddeti.oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdddp,F$kli_vxcf"."_$mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdddp.oc=F$kli_vxcf"."_$mzdkun.oc ".
" AND F$kli_vxcf"."_$mzdkun.pom = 9 AND F$kli_vxcf"."_$mzdkun.dav < '$datmaz' AND F$kli_vxcf"."_$mzdkun.dav != '0000-00-00' AND F$kli_vxcf"."_mzdddp.oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdzaltrn,F$kli_vxcf"."_$mzdkun ".
" SET mn=9999 ".
" WHERE F$kli_vxcf"."_mzdzaltrn.oc=F$kli_vxcf"."_$mzdkun.oc ".
" AND F$kli_vxcf"."_$mzdkun.pom = 9 AND F$kli_vxcf"."_$mzdkun.dav < '$datmaz' AND F$kli_vxcf"."_$mzdkun.dav != '0000-00-00' AND F$kli_vxcf"."_mzdzaltrn.oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_mzdzalddp,F$kli_vxcf"."_$mzdkun ".
" SET pd4=9 ".
" WHERE F$kli_vxcf"."_mzdzalddp.oc=F$kli_vxcf"."_$mzdkun.oc ".
" AND F$kli_vxcf"."_$mzdkun.pom = 9 AND F$kli_vxcf"."_$mzdkun.dav < '$datmaz' AND F$kli_vxcf"."_$mzdkun.dav != '0000-00-00' AND F$kli_vxcf"."_mzdzalddp.oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdtrn WHERE mn = 9999 AND oc = $cislo_oc "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzddeti WHERE p4 = 9 AND oc = $cislo_oc "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdddp WHERE pd4 = 9 AND oc = $cislo_oc "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdzaltrn WHERE mn = 9999 AND oc = $cislo_oc "; $dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdzalddp WHERE pd4 = 9 AND oc = $cislo_oc "; $dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_$mzdkun WHERE pom = 9 AND dav < '$datmaz' AND dav != '0000-00-00' AND oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdzalkun WHERE oc = $cislo_oc ";
$dsql = mysql_query("$dsqlt");
  }


$copern=1;
$drupoh=1;
$page=1;
$cislo_oc=0;
$sys="MZD";

  }

if( $_SESSION['ie10'] == 1 ) { header('X-UA-Compatible: IE=8'); }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Zoznam zamestnancov</title>
  <style type="text/css">

  </style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

function UrobOnClick(e)
                {
      Fx.style.display='none';
      Cele.style.display='none';
      Datum.style.display='none';
      Desc.style.display='none';
      Desc4.style.display='none';
      Desc1.style.display='none';
      Oc.style.display='none';
                }
                

function OcEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_meno.focus();
        document.forms.formv1.h_meno.select();
              }
                }

function MenoEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_prie.focus();
        document.forms.formv1.h_prie.select();
              }
                }

function PrieEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_titl.focus();
        document.forms.formv1.h_titl.select();
              }
                }

function TitlEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_rodn.focus();
        document.forms.formv1.h_rodn.select();
              }
                }

function RodnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zuli.focus();
        document.forms.formv1.h_zuli.select();
              }
                }

function ZuliEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zcdm.focus();
        document.forms.formv1.h_zcdm.select();
              }
                }

function ZcdmEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zpsc.focus();
        document.forms.formv1.h_zpsc.select();
              }
                }

function ZpscEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zmes.focus();
        document.forms.formv1.h_zmes.select();
              }
                }

function ZmesEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_ztel.focus();
        document.forms.formv1.h_ztel.select();
              }
                }

function ZtelEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zema.focus();
        document.forms.formv1.h_zema.select();
              }
                }

function ZemaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_rdc.focus();
        document.forms.formv1.h_rdc.select();
              }
                }

function RdcEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_rdk.focus();
        document.forms.formv1.h_rdk.select();
              }
                }

function RdkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dar.focus();
        document.forms.formv1.h_dar.select();
              }
                }

function DarEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_mnr.focus();
        document.forms.formv1.h_mnr.select();
              }
                }

function MnrEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_cop.focus();
        document.forms.formv1.h_cop.select();
              }
                }

function CopEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dan.focus();
        document.forms.formv1.h_dan.select();
              }
                }

function DanEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_pom.focus();
              }
                }

function PomEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_uva.focus();
        document.forms.formv1.h_uva.select();
              }
                }

function UvaEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_kat.focus();
        document.forms.formv1.h_kat.select();
              }
                }

function KatEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_wms.focus();
        document.forms.formv1.h_wms.select();
              }
                }

function WmsEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_stz.focus();
              }
                }

function StzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zkz.focus();
              }
                }

function ZkzEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dav.focus();
        document.forms.formv1.h_dav.select();
              }
                }

function DavEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_zdrv.focus();
              }
                }

function ZdrvEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dvp.focus();
        document.forms.formv1.h_dvp.select();
              }
                }

function DvpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_znah.focus();
        document.forms.formv1.h_znah.select();
              }
                }

function ZnahEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_nrk.focus();
        document.forms.formv1.h_nrk.select();
              }
                }

function NrkEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_nev.focus();
        document.forms.formv1.h_nev.select();
              }
                }

function NevEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_crp.focus();
        document.forms.formv1.h_crp.select();
              }
                }

function CrpEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_znem.focus();
        document.forms.formv1.h_znem.select();
              }
                }

function ZnemEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_cdss.focus();
              }
                }

function CdssEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dsp.focus();
        document.forms.formv1.h_dsp.select();
              }
                }

function DspEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dad.focus();
        document.forms.formv1.h_dad.select();
              }
                }

function DadEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_dvy.focus();
        document.forms.formv1.h_dvy.select();
              }
                }

function DvyEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_deti_dn.focus();
        document.forms.formv1.h_deti_dn.select();
              }
                }

function Deti_dnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz0.focus();
        document.forms.formv1.h_sz0.select();
              }
                }

function Ziv_dnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz0.focus();
        document.forms.formv1.h_sz0.select();
              }
                }

function Zrz_dnEnter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz0.focus();
        document.forms.formv1.h_sz0.select();
              }
                }

function Sz0Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz1.focus();
        document.forms.formv1.h_sz1.select();
              }
                }

function Sz1Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz2.focus();
        document.forms.formv1.h_sz2.select();
              }
                }

function Sz2Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz3.focus();
        document.forms.formv1.h_sz3.select();
              }
                }

function Sz3Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz4.focus();
        document.forms.formv1.h_sz4.select();
              }
                }

function Sz4Enter(e)
                {
  var k = (navigator.appName=="Netscape") ? e : event.keyCode; // kÛd stlaËenej kl·vesy
  if(k == 13 ){
        document.forms.formv1.h_sz4.focus();
        document.forms.formv1.h_sz4.select();
              }
                }

//Kontrola datumu Sk
function kontrola_datum(vstup, Oznam, x1, errflag)
		{
		var text
		var index
		var tecka
		var den
		var mesic
		var rok
		var ch
                var err

		text=""
                err=0 
		
		den=""
		mesic=""
		rok=""
		tecka=0
		
		for (index = 0; index < vstup.value.length; index++) 
			{
      ch = vstup.value.charAt(index);
			if (ch != "0" && ch != "1" && ch != "2" && ch != "3" && ch != "4" && ch != "5" && ch != "6" && ch != "7" && ch != "8" && ch != "9" && ch != ".") 
				{text="Pole Datum zadavajte vo formate DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok).\r"; err=3 }
			if ((ch == "0" || ch == "1" || ch == "2" || ch == "3" || ch == "4" || ch == "5" || ch == "6" || ch == "7" || ch == "8" || ch == "9") && (text ==""))
				{
				if (tecka == 0)
					{den=den + ch}
				if (tecka == 1)
					{mesic=mesic + ch}
				if (tecka == 2)
					{rok=rok + ch}
				}
			if (ch == "." && text == "")
				{
				if (tecka == 1)
					{tecka=2}
				if (tecka == 0)
					{tecka=1}
				
				}	
			}
			
		if (tecka == 2 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>}
		if (tecka == 1 && rok == "" )
			{rok=<?php echo $kli_vrok; ?>; err= 0}
		if (tecka == 1 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; err= 0}
		if (tecka == 0 && mesic == "" )
			{mesic=<?php echo $kli_vmes; ?>; rok=<?php echo $kli_vrok; ?>; err= 0}
		if ((den<1 || den >31) && (text == ""))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 31.\r"; err=1 }
		if ((mesic<1 || mesic>12) && (text == ""))
			{text=text + "Pocet mesiacov nemoze byt mensi ako 1 a vacsi ako 12.\r"; err=2 }
		if (rok<1930 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt mensi ako 1930.\r"; err=3 }
		if (rok>2029 && tecka == 2 && text == "" && rok != "" )
			{text=text + "Rok nemoze byt v‰ËöÌ ako 2029.\r"; err=3 }
		if (tecka > 2)
			{text=text+ "Datum zadavajte vo formatu DD.MM alebo DD.MM.RRRR (DD=den, MM=mesiac, RRRR=rok)\r"; err=3 }

		if (mesic == 2)
			{
			if (rok != "")
				{
				if (rok % 4 == 0)
					{
					if (den>29)
						{text=text + "Vo februari roku " + rok + " je maximalne 29 dni.\r"; err=1 }
					}
				else
					{
					if (den>28)
						{text=text + "Vo februari roku " + rok + " je maximalne 28 dni.\r"; err=1 }
					}
				}
			else
				{
				if (den>29)
					{text=text + "Vo februari roku je maximalne 29 dni.\r"}
				}
			}

		if ((mesic == 4 || mesic == 6 || mesic == 9 || mesic == 11) && (den>30))
			{text=text + "Pocet dni v uvedenom mesiaci nemoze byt mensi ako 1 a vacsi ako 30.\r"}
		



		if (text!="" && err == 1 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "??"  + "." + mesic+ "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 2 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic + "??" + "." + rok;
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (text!="" && err == 3 && vstup.value.length > 0 )
			{
                        Oznam.style.display="";
                        x1.value = den + "." + mesic +  "." + rok + "??";
                        errflag.value = "1";
                        x1.focus();
			return false;
                        }
		if (err == 0)
			{
                        Oznam.style.display="none";
                        x1.value = den + "." + mesic +  "." + rok ;
                        errflag.value = "0";
			return true;
			}

		}
//koniec kontrola datumu

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



<?php
//hladanie
  if ( $copern == 7 )
  {
?>
    function VyberVstup()
    {
    document.formhl1.hladaj_prie.focus();
    }

<?php
  }
//koniec hladania
?>
<?php
//vymazanie
  if ( $copern == 6 OR $copern == 9 OR $copern == 16 )
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
//koniec vymazania
?>

<?php
//zobrazenie
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 OR $copern == 4 )
  {
?>

    function VyberVstup()
    {
    document.formhl1.hladaj_oc.focus();
    document.formhl1.hladaj_oc.select();
    }

    function ObnovUI()
    {

    var ii=1*<?php echo strip_tags($_REQUEST['page']);?>;
    if ( ii == 1 ) document.forma2.pstrana.disabled = true;
    <?php if( $zmaz == 'OK' ) echo "Zm.style.display='';";?>
    <?php if( $uprav == 'OK' ) echo "Up.style.display='';";?>
    }

<?php
  }
?>
<?php
//uprava
  if ( $copern == 8 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.h_oc.value = '<?php echo "$h_oc";?>';
    document.formv1.h_meno.value = '<?php echo "$h_meno";?>';
    document.formv1.h_prie.value = '<?php echo "$h_prie";?>';
    document.formv1.h_rodn.value = '<?php echo "$h_rodn";?>';
    document.formv1.h_titl.value = '<?php echo "$h_titl";?>';
    document.formv1.h_zuli.value = '<?php echo "$h_zuli";?>';
    document.formv1.h_zcdm.value = '<?php echo "$h_zcdm";?>';
    document.formv1.h_zpsc.value = '<?php echo "$h_zpsc";?>';
    document.formv1.h_zmes.value = '<?php echo "$h_zmes";?>';
    document.formv1.h_ztel.value = '<?php echo "$h_ztel";?>';
    document.formv1.h_zema.value = '<?php echo "$h_zema";?>';
    document.formv1.h_rdc.value = '<?php echo "$h_rdc";?>';
    document.formv1.h_rdk.value = '<?php echo "$h_rdk";?>';
    document.formv1.h_dar.value = '<?php echo "$dar_sk";?>';
    document.formv1.h_mnr.value = '<?php echo "$h_mnr";?>';
    document.formv1.h_dan.value = '<?php echo "$dan_sk";?>';
    document.formv1.h_dav.value = '<?php echo "$dav_sk";?>';
    document.formv1.h_pom.value = '<?php echo "$h_pom";?>';
    document.formv1.h_kat.value = '<?php echo "$h_kat";?>';
    document.formv1.h_uva.value = '<?php echo "$h_uva";?>';
    document.formv1.h_cop.value = '<?php echo "$h_cop";?>';
    document.formv1.h_wms.value = '<?php echo "$h_wms";?>';
    document.formv1.h_stz.value = '<?php echo "$h_stz";?>';
    document.formv1.h_zkz.value = '<?php echo "$h_zkz";?>';
    document.formv1.h_zdrv.value = '<?php echo "$h_zdrv";?>';
    document.formv1.h_dvp.value = '<?php echo "$dvp_sk";?>';

    document.formv1.h_znah.value = '<?php echo "$h_znah";?>';
    document.formv1.h_nrk.value = '<?php echo "$h_nrk";?>';
    document.formv1.h_nev.value = '<?php echo "$h_nev";?>';
    document.formv1.h_crp.value = '<?php echo "$h_crp";?>';
    document.formv1.h_znem.value = '<?php echo "$h_znem";?>';

    document.formv1.h_cdss.value = '<?php echo "$h_cdss";?>';
    document.formv1.h_dsp.value = '<?php echo "$dsp_sk";?>';

    document.formv1.h_dvy.value = '<?php echo "$h_dvy";?>';
    document.formv1.h_dad.value = '<?php echo "$dad_sk";?>';

    document.formv1.h_deti_dn.value = '<?php echo "$h_deti_dn";?>';

    document.formv1.h_sz0.value = '<?php echo "$h_sz0";?>';
    document.formv1.h_sz1.value = '<?php echo "$h_sz1";?>';
    document.formv1.h_sz2.value = '<?php echo "$h_sz2";?>';
    document.formv1.h_sz3.value = '<?php echo "$h_sz3";?>';
    document.formv1.h_sz4.value = '<?php echo "$h_sz4";?>';

    }

<?php
//koniec uprava
  }
//uprava,nova
  if ( $copern == 5 OR $copern == 8 OR $copern == 15 OR $copern == 8 )
  {
?>

    function Zapis_COOK()
    {

    return (true);
    }

    function Obnov_vstup()
    {

    return (true);
    }

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; document.formv1.uloz.disabled = true; }
     else { Oznam.style.display="none"; }
    }

    function VyberVstup()
    {
    <?php if( $copern == 5 ) echo "document.formv1.h_oc.focus();"; ?>
    <?php if( $copern == 5 ) echo "document.formv1.h_oc.select();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_meno.focus();"; ?>
    <?php if( $copern == 8 ) echo "document.formv1.h_meno.select();"; ?>
    <?php if( $zana == 0 ) echo "document.formv1.uloz.disabled = true;"; ?>
    
    }


    function Povol_uloz()
    {
    var okvstup=1;
    if ( document.formv1.h_oc.value == '' ) okvstup=0;
    if ( document.formv1.h_meno.value == '' ) okvstup=0;
    if ( document.formv1.h_prie.value == '' ) okvstup=0;

    if ( okvstup == 1 ) { document.formv1.uloz.disabled = false; Fx.style.display="none"; return (true); }
       else { document.formv1.uloz.disabled = true; Fx.style.display=""; return (false) ; }

    }

<?php
//koniec nova,uprava
  }
?>

<?php
//nova
  if ( $copern == 5 )
  { 
?>
    function ObnovUI()
    {
<?php if( $uloz == 'OK' ) echo "Ul.style.display='';";?>
    }

<?php
//koniec nova
  }
?>

  </script>


<?php if( $copern == 8 ) { echo "<script type='text/javascript' src='uloz_bankuzam.js'></script>"; } ?>

<script type='text/javascript'>

//banka

    var uceb = "<?php echo $h_uceb;?>";
    var numb = "<?php echo $h_numb;?>";
    var ibanb = "<?php echo $ibanb;?>";
    var swft = "<?php echo $swft;?>";
    var vsy = "<?php echo $h_vsy;?>";
    var ksy = "<?php echo $h_ksy;?>";
    var ssy = "<?php echo $h_ssy;?>";

    function jeBANKA()
    { 
    jeBANKA = document.getElementById("jeBANKAelement");

    var htmlbanka = "<table  class='ponuka' width='100%'><tr>";

    htmlbanka += "<td width='50%'>Bankov˝ ˙Ëet: ";
    htmlbanka += "" + ibanb + " - ";
    htmlbanka += "" + swft + " / ";
    htmlbanka += "" + uceb + " / ";
    htmlbanka += "" + numb + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='10%'>VSY:";
    htmlbanka += "" + vsy + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='10%'>KSY:";
    htmlbanka += "" + ksy + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='10%'>SSY:";
    htmlbanka += "" + ssy + "";
    htmlbanka += "</td>";

    htmlbanka += "<td width='5%'>";
    htmlbanka += "</td>";


    htmlbanka += "<td width='15%' align='right'></td></tr>"; 
    htmlbanka += "</table>";
    jeBANKA.innerHTML = htmlbanka;
    jeBANKAelement.style.display='';
    }

    function ulozitBANKU()
    { 

    ibanb = document.fbanka1.h_ibanb.value;
    uceb = document.fbanka1.h_uceb.value;
    numb = document.fbanka1.h_numb.value;
    vsy = document.fbanka1.h_vsy.value;
    ksy = document.fbanka1.h_ksy.value;
    ssy = document.fbanka1.h_ssy.value;

    <?php $h_oc=1*$h_oc; ?>

    ulozBANKU(1,<?php echo $h_oc;?>);
    }

    function zhasniBANKU()
    { 
    myBANKAelement.style.display='none';
    jeBANKAelement.style.display='';
    }

    function textOsc( oscx )
    {

var h_osc = oscx;

window.open('../mzdy/mzd_text.php?h_cvz=' + h_osc + '&copern=1&drupoh=<?php echo $drupoh;?>&page=1', '_blank',  'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );


    }


function vlozDovOC()
                    {
window.open('vloz_dmn.php?copern=21&cislo_oc=<?php echo $cislo_oc; ?>', '_self' )
                    }

function vlozDov()
                    {
window.open('vloz_dmn.php?copern=20&cislo_oc=<?php echo $cislo_oc; ?>', '_self' )
                    }

function zamsodpoc()
                    {
window.open('ktomaodpocetzp.php?copern=1&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )
                    }

function dajIBAN(cislo)
                {
var cislox = cislo;

window.open('../cis/dajiban.php?cislo_oc=<?php echo $cislo_oc; ?>&cislox=' + cislox + '&copern=2', '_self' );
                }


</script>

</HEAD>

<BODY class="white" onload="ObnovUI(); VyberVstup();" >

<?php
//uprav bankovy ucet
//echo $copern;
if ( $copern == 8 )
     {
?>
<div id="nastavbankx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 512px; left: 10px; width:1180px; height:120px;">
<table  class='ponuka' width='100%'><tr><FORM name='fbanka1' class='obyc' method='post' action='#' >

<td width='66%'>˙Ëet 
<input type='text' name='h_uceb' id='h_uceb' size='18' value="<?php echo $h_uceb;?>"  
 onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 
 num<input type='text' name='h_numb' id='h_numb' size='6' value="<?php echo $h_numb;?>" 
onchange='return intg(this,0,9999,Cele)' onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 

<img src='../obr/vlozit.png' onclick="dajIBAN(11);" width=15 height=15 border=0 title="VypoËÌtaù SK IBAN z bankovÈho ˙Ëtu zamestnanca" >

 iban<input type='text' name='h_ibanb' id='h_ibanb' size='38' value="<?php echo $ibanb;?>" />
 bic<input type='text' name='h_swft' id='h_swft' size='12' value="<?php echo $swft;?>" />
</td>

<td width='3%'>
<img border=0 src='../obr/ok.png' style='width:15; height:10;' onclick="ulozitBANKUnew();" title='Uloûiù' >
</td>

<td width='10%'>VSY:
<input type='text' name='h_vsy' id='h_vsy' size='8' value="<?php echo $h_vsy;?>"  
onchange='return intg(this,0,9999999999,Cele)' onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 
</td>

<td width='8%'>KSY:
<input type='text' name='h_ksy' id='h_ksy' size='4' value="<?php echo $h_ksy;?>"  
onchange='return intg(this,0,9999,Cele)' onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 
</td>

<td width='10%'>SSY:
<input type='text' name='h_ssy' id='h_ssy' size='8' value="<?php echo $h_ssy;?>"  
onchange='return intg(this,1,9999999999,Cele)' onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Cele)" /> 
</td>


<td width='3%' align='left'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;'
onClick="nastavbankx.style.display='none'; jeBANKAelement.style.display='';" title='Zhasni nastavenie ˙Ëtu' ></td></FORM></tr>

 
</table>
</div>
<script type="text/javascript">

function nacitajBanku()
                {
    nastavbankx.style.display='';
    jeBANKAelement.style.display='none';

                }

    function ulozitBANKUnew()
    { 

    ibanb = document.fbanka1.h_ibanb.value;
    uceb = document.fbanka1.h_uceb.value;
    numb = document.fbanka1.h_numb.value;
    vsy = document.fbanka1.h_vsy.value;
    ksy = document.fbanka1.h_ksy.value;
    ssy = document.fbanka1.h_ssy.value;

    <?php $h_oc=1*$h_oc; ?>

    ulozBANKU(1,<?php echo $h_oc;?>);
    nastavbankx.style.display='none';
    }



</script>
<?php
     }
?>

<?php 
// aktualna strana
$page = strip_tags($_REQUEST['page']);
//nasledujuca strana
$npage =  $page + 1;
// predchadzajuca strana
$ppage =  $page - 1;
// pocet poloziek na stranu
$pols = 15;
// zaciatok cyklu
$i = ( $page - 1 ) * $pols;
// koniec cyklu
$konc =($pols*($page-1))+($pols-1);
?>


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Zoznam zamestnancov
<?php if( $_SESSION['newzam'] == 1 ) { ?>
 - novÌ neaktÌvni zamestnanci
<?php                                } ?>
<?php
  if ( $copern == 5 ) echo "- nov· poloûka";
  if ( $copern == 8 ) echo "- ˙prava poloûky";
  if ( $copern == 6 ) echo "- vymazanie poloûky";
?>
 <img src='../obr/info.png' width=12 height=12 border=0 title="EnterNext = v tomto formul·ry po zadanÌ hodnoty poloûky a stlaËenÌ Enter program prejde na vstup Ôalöej poloûky">
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />



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
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5|| $copern == 6 || $copern == 7 || $copern == 8 || $copern == 9 )
     {

if ( $copern != 1 && $copern != 2 && $copern != 3 && $copern != 4 && $copern != 5 && $copern != 6 && $copern != 7 && $copern != 8 && $copern != 9 ) break;

    do
    {
// zobraz vsetko co je v tabulke
if ( $copern == 1 || $copern == 2 || $copern == 3 || $copern == 4 || $copern == 5 || $copern == 6 || $copern == 7 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun ORDER BY oc");
  }

// zobraz len upravovaneho
if ( $copern == 8 )
  {
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc = '$cislo_oc' ORDER BY oc");
  }

// zobraz hladanie
if ( $copern == 9 )
  {

$hladaj_prie = strip_tags($_REQUEST['hladaj_prie']);
$hladaj_zmes = strip_tags($_REQUEST['hladaj_zmes']);
$hladaj_ztel = strip_tags($_REQUEST['hladaj_ztel']);
$hladaj_oc = strip_tags($_REQUEST['hladaj_oc']);

if ( $hladaj_ztel != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE ( ztel LIKE '%$hladaj_ztel%' ) ORDER BY oc");
if ( $hladaj_zmes != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE ( zmes LIKE '%$hladaj_zmes%' ) ORDER BY oc");
if ( $hladaj_prie != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE ( prie LIKE '%$hladaj_prie%' OR meno LIKE '%$hladaj_prie%' ) ORDER BY oc");
if ( $hladaj_oc != "" ) $sql = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE ( oc = '$hladaj_oc' ) ORDER BY oc");
  }
// zobraz uprava a zmazanie
if ( $copern == 6 )
  {
$sql = mysql_query("SELECT* FROM F$kli_vxcf"."_$mzdkun WHERE oc > 0 ORDER BY oc");

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
<FORM name="formhl1" class="hmenu" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&page=1&copern=9" >
<td class="hmenu" ><img src='../obr/hladaj.png' width=20 height=12 border=0>
<td class="hmenu" align="left">
<a href="#" onclick="zamsodpoc();">
odpoËet ZP <img src='../obr/tlac.png' width=20 height=15 border=0 title="Zamestnanci s nastaven˝m odpoËtom ZP"></a>
</td>
<td class="hmenu" ></td>
<td class="hmenu" ></td>

<td class="hmenu" >
<?php
if ( $kli_uzall > 3500 )
  {
?>
<a href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=67&page=1'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek"></a>
<?php
  }
?>
</td>
<td class="hmenu" ><a href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=55&page=1'>
<?php
if ( $kli_uzall > 3500 )
  {
?>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov"></a>
<?php
  }
?>
</td>
</tr>
<tr>
<td class="hmenu"><input type="text" name="hladaj_oc" id="hladaj_oc" size="11" value="<?php echo $hladaj_oc;?>" />
<td class="hmenu"><input type="text" name="hladaj_prie" id="hladaj_prie" size="30" value="<?php echo $hladaj_prie;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_zmes" id="hladaj_zmes" size="30" value="<?php echo $hladaj_zmes;?>" /> 
<td class="hmenu"><input type="text" name="hladaj_ztel" id="hladaj_ztel" size="30" value="<?php echo $hladaj_ztel;?>" /> 
<td class="obyc" align="left"><INPUT type="submit" id="hlad1" name="hlad1" value="Hæadaù" >
</td>
</FORM>
</tr>
<tr>
<FORM name="formhl2" class="hmenu" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&page=1&copern=1" >
<td class="hmenu" colspan="4"></td>
<td class="obyc" align="left"><INPUT type="submit" id="hlad2" name="hlad2" value="Vöetko" >
</td>
</FORM>
</tr>

<?php
     }
?>

<?php
  if ( $copern != 8 AND $copern != 5 )
  {
?>
<tr>
<th class="hmenu">Os.ËÌslo<th class="hmenu">Meno, Priezvisko<th class="hmenu">Bydlisko<th class="hmenu">TelefÛn, e-mail
<th class="hmenu">Uprav<th class="hmenu">Zmaû
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
<td class="fmenu" width="10%" ><?php echo $riadok->oc;?></td>
<td class="fmenu" width="30%" >
<a href="#" onClick="window.open('zpdavka601.php?sys=<?php echo $sys; ?>&copern=1&cislo_oc=<?php echo $riadok->oc;?>','_blank','<?php echo $tlcuwin; ?>')">
<img src='../obr/export.png' width=15 height=15 border=0 title='Zmeny ZP, SP elektronicky' ></a>
<?php echo $riadok->meno;?> <?php echo $riadok->prie;?></td>
<td class="fmenu" width="25%" ><?php echo $riadok->zuli;?> <?php echo $riadok->zcdm;?>, <?php echo $riadok->zmes;?></td>
<td class="fmenu" width="20%" ><?php echo $riadok->ztel;?> <?php echo $riadok->zema;?></td>
<td class="fmenu" width="10%" >
<a href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_oc=<?php echo $riadok->oc;?>&h_oc=<?php echo $riadok->oc;?>'>
<img src='../obr/uprav.png' width=15 height=15 border=0 title="⁄prava ˙dajov o zamestnancovi"></a>
<?php if( $_SESSION['newzam'] == 0 ) { ?>
<a href="#" onClick="window.open('../mzdy/trvale.php?copern=1&drupoh=1&page=1&zkun=1&cislo_oc=<?php echo $riadok->oc;?>','_blank','<?php echo $tlcuwin; ?>')">
<img src='../obr/zoznam.png' width=15 height=15 border=0 title='⁄prava trval˝ch poloûiek zamestnanca' ></a>
<?php                                } ?>
<?php if( $_SESSION['newzam'] == 0 ) { ?>
<a href="#" onClick="window.open('../mzdy/mes_mzdy.php?copern=101&drupoh=1&page=1&zkun=1&vyb_osc=<?php echo $riadok->oc;?>','_self')">
<img src='../obr/orig.png' width=15 height=15 border=0 title='⁄prava mesaËn˝ch poloûiek zamestnanca' ></a>
<?php                                } ?>
<?php if( $_SESSION['newzam'] == 0 ) { ?>
<a href="#" onClick="window.open('../mzdy/deti.php?copern=1&drupoh=1&page=1&zkun=1&cislo_oc=<?php echo $riadok->oc;?>','_blank','<?php echo $tlcuwin; ?>')">
<img src='../obr/klienti.png' width=15 height=15 border=0 title='Deti zamestnanca' ></a>
<?php                                } ?>
</td>
<td class="fmenu" width="5%" ><a href='zamestnanci.php?sys=<?php echo $sys; ?>&copern=6&page=<?php echo $page;?>&cislo_oc=<?php echo $riadok->oc;?>'>Zmaû</a></td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

</table>
<table class="fmenu" width="100%" >
<tr><td  width="80%" ><?php echo "Strana:$page  Celkom poloûiek/str·n v celej tabulke:$cpol/$xstr ";?></td>
<td width="20%" align="right">
<?php if( $_SESSION['newzam'] == 1 ) { ?>
 <img src='../obr/vlozit.png' onClick="window.open('zamestnanci.php?copern=9999&drupoh=1&page=1','_self')" width=12 height=12 border=0 title="Sp‰ù na AktÌvnych zamestnancov">
<?php                                } ?>
<?php if( $_SESSION['newzam'] == 0 ) { ?>
 <img src='../obr/vlozit.png' onClick="window.open('zamestnanci.php?copern=9998&drupoh=1&page=1','_self')" width=12 height=12 border=0 title="NovÌ zamestnanci, eöte neaktÌvni len prihl·senÌ do SP">
<?php                                } ?>
</td>
</tr>
</table>

<?php
//koniec zobraz ak nie copern=8,5
  }
?>

<?php
//mysql_close();
mysql_free_result($sql);
    } while (false);
//koniec 1,2,3,4,5,6,7,8,9
?>

<?php
// 6=vymazanie polozky
if ( $copern == 6 )
  {
$cislo_oc = strip_tags($_REQUEST['cislo_oc']);
$page = strip_tags($_REQUEST['page']);

$sqlp = "SELECT * FROM F$kli_vxcf"."_$mzdkun WHERE oc='$cislo_oc'";
$sql = mysql_query("$sqlp");
?>
<table class="fmenu" width="100%" >
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr></tr>
<tr>
<?php while($zaznam=mysql_fetch_array($sql)):?>
<td class="fmenu" width="10%" ><?php echo $zaznam["oc"];?></td>
<td class="fmenu" width="30%" ><?php echo $zaznam["meno"];?> <?php echo $zaznam["prie"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["zuli"];?> <?php echo $zaznam["zcdm"];?>, <?php echo $zaznam["zmes"];?></td>
<td class="fmenu" width="25%" ><?php echo $zaznam["ztel"];?> <?php echo $zaznam["zema"];?></td>
<td class="fmenu" width="5%" ></td>
<td class="fmenu" width="5%" ></td>
<?php endwhile;?>
<FORM name="formv2" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=16>&cislo_oc=<?php echo $cislo_oc;?>&cislo_cis=<?php echo $cislo_cis;?>&cislo_cen=<?php echo $cislo_cen;?>" >
<tr>
<td class="obyc"><INPUT type="submit" id="zmaz" name="zmaz" value="&nbsp;Vymazaù poloûku&nbsp;" ></td>
</tr>
</FORM>
<FORM name="formv3" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc"><INPUT type="submit" id="stornom" name="stornom" value="Storno nevymazaù" ></td>
</tr>
</FORM>
</table>

<?php
//mysql_close();
mysql_free_result($sql);
  }
//koniec pre vymazanie
?>

<?php
//zobraz pre novu polozku
if ( $copern == 5 OR $copern == 8 )
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
<tr>
</table>

<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&
<?php if ( $copern == 5 ) {echo "copern=15&"; } ?>
<?php if ( $copern == 8 ) {echo "copern=18&"; } ?>
<?php if ( $copern == 8 ) {echo "cislo_oc=$cislo_oc"; } ?>
" >

<tr></tr><tr></tr><tr></tr>
<tr>
<td class="fmenu" width="10%">OsobnÈ ËÌslo:</td>
<td class="fmenu" width="15%">

<?php
if( $novy == 0 AND $zana == 0 )
{
$prev_oc=$cislo_oc-1; 
$next_oc=$cislo_oc+1;

if( $prev_oc == 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_$mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_$mzdkun ORDER BY oc DESC LIMIT 1"); 
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }

if( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_$mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if( $nasieloc == 0 ) $next_oc=$next_oc+1;
if( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;

if( $prev_oc == 0 ) $prev_oc=1;
if( $next_oc > 9999 ) $next_oc=9999;
?>
<a href="#" onClick="window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_oc=<?php echo $prev_oc;?>&h_oc=<?php echo $prev_oc;?>', '_self' )">
<img src='../obr/prev.png' width=12 height=12 border=0 title='Zamestnanec osË <?php echo $prev_oc; ?>' ></a>
<a href="#" onClick="window.open('zamestnanci.php?sys=<?php echo $sys; ?>&copern=8&page=<?php echo $page;?>&cislo_oc=<?php echo $next_oc;?>&h_oc=<?php echo $next_oc;?>', '_self' )">
<img src='../obr/next.png' width=12 height=12 border=0 title='Zamestnanec osË <?php echo $next_oc; ?>' ></a>
<?php
}
//koniec novy=0
?>

<?php
if ( $copern == 5 )
     {
?>
<input type="text" name="h_oc" id="h_oc" size="8"
onchange="return intg(this,1,9999,Oc)" onclick="Fx.style.display='none';" onkeyup="KontrolaCisla(this, Oc)" 
onKeyDown="return OcEnter(event.which)" />*</td>
<?php
     }
?>
<?php
if ( $copern == 8 )
     {
echo "   ".$h_oc;
?>
<input type="hidden" name="h_oc" id="h_oc" /></td>
<?php
     }
?>
<td class="fmenu" width="10%">Meno:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_meno" id="h_meno" onclick="Fx.style.display='none';" onKeyDown="return MenoEnter(event.which)" />*</td>
<td class="fmenu" width="10%">Priezvisko:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_prie" id="h_prie" onclick="Fx.style.display='none';" onKeyDown="return PrieEnter(event.which)" />*</td>
<td class="fmenu" width="10%">Titul:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_titl" id="h_titl" onclick="Fx.style.display='none';" onKeyDown="return TitlEnter(event.which)" /></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu" width="10%">RodnÈ priezvisko:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_rodn" id="h_rodn" onKeyDown="return RodnEnter(event.which)" /></td>

<td class="fmenu" width="10%">Trv.bydlisko - ulica:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_zuli" id="h_zuli" onKeyDown="return ZuliEnter(event.which)" /></td>
<td class="fmenu" colspan="2">»Ìslo:
 <input type="text" name="h_zcdm" id="h_zcdm" onKeyDown="return ZcdmEnter(event.which)" size="8"/>
 PS»:
<input type="text" name="h_zpsc" id="h_zpsc" onKeyDown="return ZpscEnter(event.which)" size="6"/></td>
<td class="fmenu" width="10%">Mesto:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_zmes" id="h_zmes" onKeyDown="return ZmesEnter(event.which)"/></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu" width="10%">TelefÛn:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_ztel" id="h_ztel" onKeyDown="return ZtelEnter(event.which)" /></td>
<td class="fmenu" width="10%">E-mail:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_zema" id="h_zema" onKeyDown="return ZemaEnter(event.which)"/></td>
<td class="fmenu" rowspan="5">
<a href='vsmz_s.php?copern=20&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_oc;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie fotografie do datab·zy" ></a>
Foto:
<?php
$jesub=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/zamestnanci/oc$h_oc.jpg") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/oc<?php echo $h_oc;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/oc<?php echo $h_oc;?>.jpg' width=70 height=80 border=0 title="Fotografia" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/zamestnanci/oc$h_oc.gif") AND $jesub == 0 )  
{
$jesub=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/oc<?php echo $h_oc;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/oc<?php echo $h_oc;?>.gif' width=70 height=80 border=0 title="Fotografia" ></a>
<?php
} 
?>
</td>
<td class="fmenu" rowspan="5">
<a href='vsmz_s.php?copern=21&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_oc;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie obËianskeho preukazu do datab·zy" ></a>
OP:
<?php
$jecop=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/zamestnanci/op$h_oc.jpg") AND $jecop == 0 )  
{
$jecop=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/op<?php echo $h_oc;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/op<?php echo $h_oc;?>.jpg' width=70 height=80 border=0 title="ObËiansky preukaz" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/zamestnanci/op$h_oc.gif") AND $jecop == 0 )  
{
$jecop=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/op<?php echo $h_oc;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/op<?php echo $h_oc;?>.gif' width=70 height=80 border=0 title="ObËiansky preukaz" ></a>
<?php
} 
?>
</td>
<td class="fmenu" rowspan="5">
<a href='vsmz_s.php?copern=22&drupoh=<?php echo $drupoh;?>&page=1&cislo_xy=<?php echo $h_oc;?>' target="_blank">
<img src='../obr/ziarovka.png' width=15 height=10 border=0 title="Uloûenie kartiËky ZP do datab·zy" ></a>
ZP:
<?php
$jecvd=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/zamestnanci/zp$h_oc.jpg") AND $jecvd == 0 )  
{
$jecvd=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/zp<?php echo $h_oc;?>.jpg' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/zp<?php echo $h_oc;?>.jpg' width=70 height=80 border=0 title="KartiËka ZP" ></a>
<?php
} 
?>
<?php
if (File_Exists ("../dokumenty/FIR$kli_vxcf/zamestnanci/zp$h_oc.gif") AND $jecvd == 0 )  
{
$jecvd=1;
?>
<a href='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/zp<?php echo $h_oc;?>.gif' target="_blank">
<img src='../dokumenty/FIR<?php echo $kli_vxcf;?>/zamestnanci/zp<?php echo $h_oc;?>.gif' width=70 height=80 border=0 title="KartiËka ZP" ></a>
<?php
} 
?>
</td>
<td class="bmenu" rowspan="5">

<img src='../obr/orig.png' width=20 height=15 border=1 onclick="textOsc('<?php echo $cislo_oc;?>')" title="DoplÚuj˙ce ˙daje o zamestnancovi" >Dop

</tr>
<tr></tr>
<tr>
<td class="fmenu" width="10%">RodnÈ ËÌslo:</td>
<td class="fmenu" width="15%">
<input class="fmenu" type="text" name="h_rdc" id="h_rdc" size="6" maxlength="6" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,999999,Cele,document.formv1.err_rdc)" onkeyup="KontrolaCisla(this, Cele)" 
 onKeyDown="return RdcEnter(event.which)" />
/
<input class="fmenu" type="text" name="h_rdk" id="h_rdk" size="4" maxlength="4" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,999999,Cele,document.formv1.err_rdk)" onkeyup="KontrolaCisla(this, Cele)" 
 onKeyDown="return RdkEnter(event.which)" />
</td>
<td class="fmenu" colspan="2">D·tum narodenia:
<input class="fmenu" type="text" name="h_dar" id="h_dar" size="10" maxlength="10" 
 onclick="UrobOnClick()" onkeyup="KontrolaDatum(this, Datum)"
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dar)" onKeyDown="return DarEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dar" value="0">
</td>
</tr>
<tr></tr>
<tr>
<td class="fmenu" width="10%">Miesto narodenia:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_mnr" id="h_mnr" onKeyDown="return MnrEnter(event.which)"/></td>
<td class="fmenu" width="10%">»Ìslo OP:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_cop" id="h_cop" onKeyDown="return CopEnter(event.which)"/></td>
</tr>
<tr></tr>
<tr>
<td class="fmenu" colspan="2">D·tum n·stupu:
<input class="fmenu" type="text" name="h_dan" id="h_dan" size="10" maxlength="10" 
 onclick="UrobOnClick()" onkeyup="KontrolaDatum(this, Datum)"
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dan)" onKeyDown="return DanEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dan" value="0">
</td>

<td class="fmenu" colspan="2">Prac.pomer:
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdpomer WHERE ( pm >= 0 ) ORDER BY pm");
?>
<select class="hvstup" size="1" name="h_pom" id="h_pom" onmouseover="UrobOnClick();" 
 onKeyDown="return PomEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["pm"];?>" >
<?php 
$polmen = $zaznam["nzpm"];
$poltxt = SubStr($polmen,0,50);
?>
<?php echo $zaznam["pm"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu" colspan="2" >⁄v‰zok:
<input type="text" name="h_uva" id="h_uva" size="8" 
 onclick="UrobOnClick()"
 onKeyDown="return UvaEnter(event.which)"
 onchange="return cele(this,0.01,99,Desc,2,document.formv1.err_uva)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_uva" value="0" >
 Skr·ten˝:
 <input type="checkbox" name="h_uvazn" value="1" />
<?php
if ( $h_uvazn == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_uvazn.checked = "checked";
</script>
<?php
   }
?>

</td>
<td class="fmenu" width="10%">KategÛria:</td>
<td class="fmenu" width="15%">
<input class="fmenu" type="text" name="h_kat" id="h_kat" size="4" maxlength="4" 
 onclick="UrobOnClick()"
 onchange="return intg(this,1,999999,Cele,document.formv1.err_kat)" onkeyup="KontrolaCisla(this, Cele)" 
 onKeyDown="return KatEnter(event.which)" />
</td>
</tr>
<tr></tr>

<tr>
<td class="fmenu" width="10%">V˝platnÈ miesto:</td>
<td class="fmenu" width="15%">
<input class="fmenu" type="text" name="h_wms" id="h_wms" size="4" maxlength="4" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,9999,Cele,document.formv1.err_wms)" onkeyup="KontrolaCisla(this, Cele)" 
 onKeyDown="return WmsEnter(event.which)" />
</td>

<td class="fmenu" colspan="2">Stredisko:
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_str WHERE ( str >= 0 ) ORDER BY str");
?>
<select class="hvstup" size="1" name="h_stz" id="h_stz" onmouseover="UrobOnClick();" 
 onKeyDown="return StzEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["str"];?>" >
<?php 
$polmen = $zaznam["nst"];
$poltxt = SubStr($polmen,0,30);
?>
<?php echo $zaznam["str"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu" colspan="2">Z·kazka:
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_zak WHERE ( zak >= 0 ) ORDER BY zak");
?>
<select class="hvstup" size="1" name="h_zkz" id="h_zkz" onmouseover="UrobOnClick();" 
 onKeyDown="return ZkzEnter(event.which)" >
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["zak"];?>" >
<?php 
$polmen = $zaznam["nza"];
$poltxt = SubStr($polmen,0,30);
?>
<?php echo $zaznam["zak"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu" colspan="2">D·tum ukonËenia pr.pomeru:
<input class="fmenu" type="text" name="h_dav" id="h_dav" size="10" maxlength="10" 
 onclick="UrobOnClick()" onkeyup="KontrolaDatum(this, Datum)"
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dav)" onKeyDown="return DavEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dav" value="0">
</td>
</tr>
<tr></tr>

<tr>
<td class="fmenu" colspan="2">ZP:
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_zdravpois WHERE ( zdrv >= 0 ) ORDER BY zdrv");
?>
<select class="hvstup" size="1" name="h_zdrv" id="h_zdrv" onmouseover="UrobOnClick();" 
 onKeyDown="return ZdrvEnter(event.which)" >
<option value="0" >0 - ûiadna ZP</option>
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["zdrv"];?>" >
<?php 
$polmen = $zaznam["nzdr"];
$poltxt = SubStr($polmen,0,30);
?>
<?php echo $zaznam["zdrv"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu" width="10%" colspan="2">D·tum poistenia v ZP:
<input class="fmenu" type="text" name="h_dvp" id="h_dvp" size="10" maxlength="10" 
 onclick="UrobOnClick()" onkeyup="KontrolaDatum(this, Datum)"
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dvp)" onKeyDown="return DvpEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dvp" value="0">

<a href="#" onClick="window.open('zpdavka601.php?sys=MZD&copern=1&cislo_oc=<?php echo $cislo_oc;?>','_self')">
<img src='../obr/export.png' width=15 height=15 border=0 title='Zmeny ZP elektronicky' ></a>

</td>

<td class="fmenu" colspan="2">ZnÌûenÈ % odvodov do ZP:
 <input type="checkbox" name="h_zpno" value="1"  />
<?php
if ( $h_zpno == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_zpno.checked = "checked";
</script>
<?php
   }
?>
</td>

<td class="fmenu" colspan="1">Neprihl·sen˝ do ZP:
 <input type="checkbox" name="h_zpnie" value="1"  />
<?php
if ( $h_zpnie == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_zpnie.checked = "checked";
</script>
<?php
   }
?>
<td class="fmenu" colspan="1">Odvodov· ˙æava ZP:
 <input type="checkbox" name="h_deti_sp" value="1"  />
<?php
if ( $h_deti_sp == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_deti_sp.checked = "checked";
</script>
<?php
   }
?>
</td>

</tr>
<tr></tr>

<tr>
<td class="fmenu" width="10%">Pr.n·hrady <?php echo $mena1; ?>/hod:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_znah" id="h_znah" size="8" 
 onclick="UrobOnClick()"
 onKeyDown="return ZnahEnter(event.which)"
 onchange="return cele(this,0,9999,Desc4,4,document.formv1.err_znah)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
<INPUT type="hidden" name="err_znah" value="0">
</td>

<td class="fmenu" colspan="4">Dovolenka dni - N·rok:
<input type="text" name="h_nrk" id="h_nrk" size="6" 
 onclick="UrobOnClick()"
 onKeyDown="return NrkEnter(event.which)"
 onchange="return cele(this,0,999,Desc1,1,document.formv1.err_nrk)" 
 onkeyup="KontrolaDcisla(this, Desc1)"  />
<INPUT type="hidden" name="err_nrk" value="0">
Min.rok:
<input type="text" name="h_nev" id="h_nev" size="6" 
 onclick="UrobOnClick()"
 onKeyDown="return NevEnter(event.which)"
 onchange="return cele(this,-99,999,Desc1,1,document.formv1.err_nev)" 
 onkeyup="KontrolaDcisla(this, Desc1)"  />
<INPUT type="hidden" name="err_nev" value="0">
»erpanÈ:
<input type="text" name="h_crp" id="h_crp" size="6" 
 onclick="UrobOnClick()"
 onKeyDown="return CrpEnter(event.which)"
 onchange="return cele(this,0,999,Desc1,1,document.formv1.err_crp)" 
 onkeyup="KontrolaDcisla(this, Desc1)"  />
<INPUT type="hidden" name="err_crp" value="0">

OC <img border=1 src='../obr/vlozit.png' onclick='vlozDovOC();' style='width:12; height:12;' title='Nastaviù z·konn˝ n·rok na poËet dnÌ dovolenky pre vybranÈho zamestnanca' >

-

ALL <img border=1 src='../obr/vlozit.png' onclick='vlozDov();' style='width:15; height:15;' title='Nastaviù z·konn˝ n·rok na poËet dnÌ dovolenky pre vöetk˝ch zamestnancov' >


</td>

<td class="fmenu" width="10%">Pr.nemoc <?php echo $mena1; ?>/deÚ:</td>
<td class="fmenu" width="15%">
<input type="text" name="h_znem" id="h_znem" size="8" 
 onclick="UrobOnClick()"
 onKeyDown="return ZnemEnter(event.which)"
 onchange="return cele(this,0,99999,Desc4,4,document.formv1.err_znem)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
<INPUT type="hidden" name="err_znem" value="0">
</td>

</tr>
<tr></tr>

<tr>
<td class="fmenu" colspan="2">DSS:
<?php
$sqls = mysql_query("SELECT * FROM F$kli_vxcf"."_mzddss WHERE ( cdss >= 0 ) ORDER BY cdss");
?>
<select class="hvstup" size="1" name="h_cdss" id="h_cdss" onmouseover="UrobOnClick();" 
 onKeyDown="return CdssEnter(event.which)" >
<option value="0" >0 - ûiadna DSS</option>
<?php while($zaznam=mysql_fetch_array($sqls)):?>
<option value="<?php echo $zaznam["cdss"];?>" >
<?php 
$polmen = $zaznam["ndss"];
$poltxt = SubStr($polmen,0,30);
?>
<?php echo $zaznam["cdss"];?> - <?php echo $poltxt;?></option>
<?php endwhile;?>
</select>
</td>

<td class="fmenu" width="10%" colspan="2">D·tum poistenia v SP:
<input class="fmenu" type="text" name="h_dsp" id="h_dsp" size="10" maxlength="10" 
 onclick="UrobOnClick()" onkeyup="KontrolaDatum(this, Datum)"
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dsp)" onKeyDown="return DspEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dsp" value="0">

<a href="#" onClick="window.open('sp_rlfo.php?sys=MZD&copern=1&cislo_oc=<?php echo $cislo_oc;?>','_self')">
<img src='../obr/export.png' width=15 height=15 border=0 title='Zmeny SP elektronicky' ></a>

</td>

<td class="fmenu" colspan="2">ZnÌûenÈ min.z·klady do SP:
 75% <input type="checkbox" name="h_spno" value="1"  />
<?php
if ( $h_spno == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_spno.checked = "checked";
</script>
<?php
   }
?>
</td>

<td class="fmenu" colspan="2">Neprihl·sen˝ do SP:
 <input type="checkbox" name="h_spnie" value="1"  />
<?php
if ( $h_spnie == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_spnie.checked = "checked";
</script>
<?php
   }
?>
</td>

</tr>
<tr></tr>

<tr>
<td class="fmenu" colspan="2">Star.dÙchodok:
 <input type="checkbox" name="h_doch" value="1"  />
<?php
if ( $h_doch == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_doch.checked = "checked";
</script>
<?php
   }
?>

V˝sl.dÙchodok:
 <input type="checkbox" name="h_docv" value="1"  />
<?php
if ( $h_docv == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_docv.checked = "checked";
</script>
<?php
   }
?>
</td>

<td class="fmenu" width="10%" colspan="2">DÙchodok od:
<input class="fmenu" type="text" name="h_dad" id="h_dad" size="10" maxlength="10" 
 onclick="UrobOnClick()" onkeyup="KontrolaDatum(this, Datum)"
 onChange="return kontrola_datum(this, Datum, this, document.formv1.err_dad)" onKeyDown="return DadEnter(event.which)" />
<input class="hvstup" type="hidden" name="err_dad" value="0">
</td>

<td class="fmenu" width="10%">DÙchodok <?php echo $mena1; ?> :</td>
<td class="fmenu" width="15%">
<input type="text" name="h_dvy" id="h_dvy" size="8" 
 onclick="UrobOnClick()"
 onKeyDown="return DvyEnter(event.which)"
 onchange="return cele(this,0,999999,Desc,2,document.formv1.err_dvy)" 
 onkeyup="KontrolaDcisla(this, Desc)"  />
<INPUT type="hidden" name="err_dvy" value="0">
</td>

<td class="fmenu" colspan="2">Odbory:
 <input type="checkbox" name="h_roh" value="1"  />
<?php
if ( $h_roh == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_roh.checked = "checked";
</script>
<?php
   }
?>
</td>

</tr>
<tr></tr>

<tr>
<td class="fmenu" width="10%">PoËet detÌ daÚ.bonus:</td>
<td class="fmenu" width="15%">
<input class="fmenu" type="text" name="h_deti_dn" id="h_deti_dn" size="2" maxlength="2" 
 onclick="UrobOnClick()"
 onchange="return intg(this,0,9999,Cele,document.formv1.err_detidn)" onkeyup="KontrolaCisla(this, Cele)" 
 onKeyDown="return Deti_dnEnter(event.which)" />
<INPUT type="hidden" name="err_detidn" value="0">
</td>

<td class="fmenu" colspan="4">NIE odpoËet na daÚovnÌka:
 <input type="checkbox" name="h_ziv_dn" value="1"  />
<?php
if ( $h_ziv_dn == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_ziv_dn.checked = "checked";
</script>
<?php
   }
?>

NIE zr·ûkov· daÚ:
 <input type="checkbox" name="h_zrz_dn" value="1"  />
<?php
if ( $h_zrz_dn == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_zrz_dn.checked = "checked";
</script>
<?php
   }
?>
</td>

<td class="fmenu" >
<?php if( $zana == 0 )    { ?>
<a href="#" onClick="nacitajBanku();">
<img src='../obr/banky/euro.jpg' width=20 height=20 border=0 title='Nastaviù bankov˝ ˙Ëet pre mzdu zamestnanca' >Bankov˝ ˙Ëet</a>
<?php                     } ?>
 <input type="checkbox" name="h_vban" value="1"  />
<?php
if ( $h_vban == 1 )
   {
?>
<script type="text/javascript">
document.formv1.h_vban.checked = "checked";
</script>
<?php
   }
?>
</td>

</tr>
<tr></tr>

<tr>
<td class="fmenu" colspan="7">
 Sadzba Ë.0 :
 <input type="text" name="h_sz0" id="h_sz0" size="10" 
 onclick="UrobOnClick()"
 onKeyDown="return Sz0Enter(event.which)"
 onchange="return cele(this,0,99999,Desc4,4,document.formv1.err_sz0)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
 <INPUT type="hidden" name="err_sz0" value="0">

 Sadzba Ë.1 :
 <input type="text" name="h_sz1" id="h_sz1" size="10" 
 onclick="UrobOnClick()"
 onKeyDown="return Sz1Enter(event.which)"
 onchange="return cele(this,0,99999,Desc4,4,document.formv1.err_sz1)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
 <INPUT type="hidden" name="err_sz1" value="0">

 Sadzba Ë.2 :
 <input type="text" name="h_sz2" id="h_sz2" size="10" 
 onclick="UrobOnClick()"
 onKeyDown="return Sz2Enter(event.which)"
 onchange="return cele(this,0,99999,Desc4,4,document.formv1.err_sz2)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
 <INPUT type="hidden" name="err_sz2" value="0">

 Sadzba Ë.3 :
 <input type="text" name="h_sz3" id="h_sz3" size="10" 
 onclick="UrobOnClick()"
 onKeyDown="return Sz3Enter(event.which)"
 onchange="return cele(this,0,99999,Desc4,4,document.formv1.err_sz3)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
 <INPUT type="hidden" name="err_sz3" value="0">

 Sadzba Ë.4 :
 <input type="text" name="h_sz4" id="h_sz4" size="10" 
 onclick="UrobOnClick()"
 onKeyDown="return Sz4Enter(event.which)"
 onchange="return cele(this,0,99999,Desc4,4,document.formv1.err_sz4)" 
 onkeyup="KontrolaDcisla(this, Desc4)"  />
 <INPUT type="hidden" name="err_sz4" value="0"> <?php echo $mena1; ?>/hod
</td>



</tr>
<tr></tr>

<tr>
<td class="obyc">
<?php if( $zana == 0 )    { ?>
<INPUT type="submit" id="uloz" name="uloz" value="Uloûiù poloûku" onclick="Zapis_COOK();" ><SPAN id="uvolni" onmouseover="return Povol_uloz();">&nbsp;</SPAN></td>
<?php                     } ?>
<td class="obyc" align="right">
<?php if( $tlacitkoenter == 1 AND $zana == 0 ) {  ?>
<img border=0 src='../obr/ok.png' style='width:15; height:15;' onClick="return Povol_uloz();"
 title='Uvolniù tlaËÌtko Uloûiù poloûku' >
<?php                                          }  ?>
</td>

<td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td><td class="obyc"></td>
<td class="obyc" align="right"></td>
</tr>
</FORM>
<FORM name="formv4" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&page=<?php echo $page;?>&copern=1" >
<tr>
<td class="obyc">
<?php if( $zana == 0 )    { ?>
<INPUT type="submit" id="stornou" name="stornou" value="Sp‰ù - Zoznam" >
<?php                     } ?>
</td>
</tr>
</FORM>
</table>
<tr>
<div id="myBANKAelement"></div>
</tr>


<?php
if( $h_vban == 9 )
    {
//banka
?>
<table  class='ponuka' width='100%'>
<tr>
<td width="30%" >Bankov˝ ˙Ëet: <?php echo $ibanb; ?> / <?php echo $riadok->uceb; ?> / <?php echo $riadok->numb; ?></td>
<td width="15%" >VSY: <?php echo $riadok->vsy; ?></td>
<td width="10%" >KSY: <?php echo $riadok->ksy; ?></td>
<td width="15%" >SSY: <?php echo $riadok->ssy; ?></td>
<td width="30%" > </td>
</tr>
</table>
<?php
    }
?>
<div id="jeBANKAelement"></div>
<?php
if( $h_vban == 1 )
    {
//banka
?>
<script type="text/javascript">
jeBANKA();
</script>
<?php
    }
?>


<?php
     }
//koniec zobrazenia pre novu polozku
//nezobraz pre novu,upravu a mazanie
if ( $copern != 5 AND $copern != 6 AND $copern != 8 )
     {
?>
<tr>
<span id="Ax" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:red; color:black;">
 Zadajte ËÌslo strany - ˙daj musÌ byù celÈ kladnÈ ËÌslo</span>
<span id="Zm" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_oc;?> zmazan·</span>
<span id="Up" style="display:none; width:100%; align:center; font-family:bold; font-weight:bold; background-color:yellow; color:black;">
 Poloûka OS»=<?php echo $cislo_oc;?> upraven·</span>
</tr>

<table>
<tr>
<td>
<FORM name="forma2" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=3";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_oc=$hladaj_oc&hladaj_prie=$hladaj_prie&hladaj_zmes=$hladaj_zmes&hladaj_ztel=$hladaj_ztel";
}
?>
&page=<?php echo $ppage;?>" >
<INPUT type="submit" id="pstrana" name="pstrana" value="Predoöl· strana" >
</FORM>
</td>
<td>
<FORM name="forma1" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&
<?php
if ( $copern != 9 )
{
echo "copern=2";
}
if ( $copern == 9 )
{
echo "copern=9&hladaj_oc=$hladaj_oc&hladaj_prie=$hladaj_prie&hladaj_zmes=$hladaj_zmes&hladaj_ztel=$hladaj_ztel";
}
?>
&page=<?php echo $npage;?>" >
<INPUT type="submit" id="dstrana" value="œalöia strana" >
</FORM>
</td>
<td>
<FORM name="forma3" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&copern=4" >
<INPUT type="submit" id="sstrana" value="Prejsù na stranu:" >
<input type="text" name="page" id="page" value="<?php echo $xstr;?>" size="4" onkeyup="KontrolaCisla(this, Ax)"/>
</FORM>
</td>
<td>
<FORM name="forma4" class="obyc" method="post" action="zamestnanci.php?sys=<?php echo $sys; ?>&copern=5&page=<?php echo $xstr;?>&npol=<?php echo $npol;?>" >
<INPUT type="submit" id="npol" value="Nov˝ zamestnanec" >
</FORM>
</td>
<td>

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

// celkovy koniec dokumentu


$cislista = include("../mzdy/mzd_lista.php");

       } while (false);
?>
</BODY>
</HTML>
