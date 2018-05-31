<?php
$zandroidu=1*$zandroidu;
if( $zandroidu == 0 )
  {
  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);
  }

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
//echo $mysqldb." ".$sqlfir;
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$fir_fico = $fir_riadok->fico;
$fir_fdic = $fir_riadok->fdic;
$fir_ficd = $fir_riadok->ficd;
$fir_fnaz = $fir_riadok->fnaz;
$fir_fuli = $fir_riadok->fuli;
$fir_fcdm = $fir_riadok->fcdm;
$fir_fmes = $fir_riadok->fmes;
$fir_fpsc = $fir_riadok->fpsc;
$fir_ftel = $fir_riadok->ftel;
$fir_ffax = $fir_riadok->ffax;
$fir_fwww = $fir_riadok->fwww;
$fir_fem1 = $fir_riadok->fem1;
$fir_fem2 = $fir_riadok->fem2;
$fir_fem3 = $fir_riadok->fem3;
$fir_uc1fk = $fir_riadok->uc1fk;
$fir_uc2fk = $fir_riadok->uc2fk;
$fir_uc3fk = $fir_riadok->uc3fk;
$fir_fuc1 = $fir_riadok->fuc1;
$fir_fib1 = $fir_riadok->fib1;
$fir_fnm1 = $fir_riadok->fnm1;
$fir_fnb1 = $fir_riadok->fnb1;
$fir_fsb1 = $fir_riadok->fsb1;
$fir_fuc2 = $fir_riadok->fuc2;
$fir_fib2 = $fir_riadok->fib2;
$fir_fnm2 = $fir_riadok->fnm2;
$fir_fnb2 = $fir_riadok->fnb2;
$fir_fsb2 = $fir_riadok->fsb2;
$fir_fuc3 = $fir_riadok->fuc3;
$fir_fib3 = $fir_riadok->fib3;
$fir_fnm3 = $fir_riadok->fnm3;
$fir_fnb3 = $fir_riadok->fnb3;
$fir_fsb3 = $fir_riadok->fsb3;
$fir_dph1 = $fir_riadok->dph1;
$fir_dph2 = $fir_riadok->dph2;
$fir_dph3 = $fir_riadok->dph3;
$fir_dph4 = $fir_riadok->dph4;
$fir_obreg = $fir_riadok->obreg;
$fir_pokpri = $fir_riadok->pokpri;
$fir_pokvyd = $fir_riadok->pokvyd;
$fir_xfa03 = $fir_riadok->xfa03;

$fir_fsw1 = trim($fir_riadok->fsw1);
$fir_fsw2 = trim($fir_riadok->fsw2);
$fir_fsw3 = trim($fir_riadok->fsw3);

$fir_mena1 = $fir_riadok->mena1;
$fir_mena2 = $fir_riadok->mena2;
$fir_kurz12 = $fir_riadok->kurz12;

$fir_sklcpr = $fir_riadok->sklcpr;
$fir_sklcps = $fir_riadok->sklcps;
$fir_sklcvd = $fir_riadok->sklcvd;
$fir_sklcis = $fir_riadok->sklcis;
$fir_sklstr = $fir_riadok->sklstr;
$fir_sklzak = $fir_riadok->sklzak;

$fir_fakodb = $fir_riadok->fakodb;
$fir_fakdod = $fir_riadok->fakdod;
$fir_fakobj = $fir_riadok->fakobj;
$fir_fakprf = $fir_riadok->fakprf;
$fir_fakdol = $fir_riadok->fakdol;
$fir_fakvnp = $fir_riadok->fakvnp;
$fir_fakstr = $fir_riadok->fakstr;
$fir_fakzak = $fir_riadok->fakzak;
$fir_xfa01 = $fir_riadok->xfa01;
$fir_xfa02 = $fir_riadok->xfa02;
$fir_xfa04 = $fir_riadok->xfa04;
$fir_xfa05 = $fir_riadok->xfa05;
$fir_xfa06 = 1*$fir_riadok->xfa06;

$fir_dopfak = $fir_riadok->dopfak;
$fir_dopobj = $fir_riadok->dopobj;
$fir_dopdol = $fir_riadok->dopdol;
$fir_dopvnp = $fir_riadok->dopvnp;
$fir_dopreg = $fir_riadok->dopreg;
$fir_dopstz = $fir_riadok->dopstz;
$fir_dopstr = $fir_riadok->dopstr;
$fir_dopzak = $fir_riadok->dopzak;
$fir_xdp01 = $fir_riadok->xdp01;
$fir_xdp02 = $fir_riadok->xdp02;
$fir_xdp03 = $fir_riadok->xdp03;
$fir_xdp04 = $fir_riadok->xdp04;
$fir_xdp05 = $fir_riadok->xdp05;
$fir_xdp06 = $fir_riadok->xdp06;

$fir_majx01 = 1*$fir_riadok->majx01;
$fir_majx02 = $fir_riadok->majx02;
$fir_majx03 = $fir_riadok->majx03;
$fir_majx04 = $fir_riadok->majx04;
$fir_majx05 = $fir_riadok->majx05;

$fir_uctx01 = $fir_riadok->uctx01;
$fir_uctx02 = $fir_riadok->uctx02;
$fir_uctx03 = $fir_riadok->uctx03;
$fir_uctx04 = $fir_riadok->uctx04;
$fir_uctx05 = $fir_riadok->uctx05;
$fir_uctx06 = $fir_riadok->uctx06;
$fir_uctx07 = $fir_riadok->uctx07;
$fir_uctx08 = $fir_riadok->uctx08;
$fir_uctx09h = 1*$fir_riadok->uctx09;
$fir_uctx09 = 1*$fir_riadok->uctx09;
$fir_uctx10 = 1*$fir_riadok->uctx10;
$fir_uctx11 = 1*$fir_riadok->uctx11;
$fir_uctx12 = 1*$fir_riadok->uctx12;
$fir_uctx13 = 1*$fir_riadok->uctx13;
$fir_uctx14 = 1*$fir_riadok->uctx14;
$fir_uctx15 = 1*$fir_riadok->uctx15;
$fir_allx15 = 1*$fir_riadok->allx15;
$fir_allx14 = 1*$fir_riadok->allx14;
$fir_allx13 = 1*$fir_riadok->allx13;

$fir_uctt01 = $fir_riadok->uctt01;
$fir_uctt02 = $fir_riadok->uctt02;
$fir_uctt03 = $fir_riadok->uctt03;
$fir_uctt04 = $fir_riadok->uctt04;
$fir_uctt05 = $fir_riadok->uctt05;

$fir_mzdx01 = $fir_riadok->mzdx01;
$fir_mzdx02 = $fir_riadok->mzdx02;
$fir_mzdx03 = $fir_riadok->mzdx03;
$fir_mzdx04 = $fir_riadok->mzdx04;
$fir_mzdx05 = $fir_riadok->mzdx05;
$fir_mzdx06 = $fir_riadok->mzdx06;
$fir_mzdx07 = 1*$fir_riadok->mzdx07;
$fir_mzdx08 = 1*$fir_riadok->mzdx08;

$fir_mzdt04 = $fir_riadok->mzdt04;
$fir_mzdt05 = $fir_riadok->mzdt05;
$fir_sknace = $fir_riadok->mzdt03;

$fir_xsk03 = 1*$fir_riadok->xsk03;
$fir_xsk04 = 1*$fir_riadok->xsk04;
$fir_xsk02 = 1*$fir_riadok->xsk02;
$fir_xsk05 = 1*$fir_riadok->xsk05;

$fir_xvr01 = 1*$fir_riadok->xvr01;
$fir_xvr05 = 1*$fir_riadok->xvr05;

$fir_allx11 = 1*$fir_riadok->allx11;
$fir_allx12 = 1*$fir_riadok->allx12;

mysql_free_result($fir_vysledok);


$cisdokodd = 0;
$pvpokljed = 0;
$pvpokljedmes = 0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/cislovanie_dokladov_oddelene.ano")) { $cisdokodd = 1; }
if ( $fir_uctx09 == 1 ) { $cisdokodd = 1; }
if ( $fir_uctx09 == 2 ) { $fir_uctx09 = 1; $cisdokodd = 1; $pvpokljed = 1; $pvpokljedmes = 1; }

$alchem=0;
$agrostav=0;
$autovalas=0;
$merkfood=0;
$fir_big=0;
$ekorobot=0;
$metalco=0;
$poliklinikase=0;
$ramex=0;
$esoplast=0;
$delisasro=0;
$slovakiaplay=0;
$emotrans=0;
$polno=0;
$medo=0;
$lsucto=0;
$sekov=0;
$pdkuty=0;
$stavoimpex=0;
$kontrolstrzak=0;
$ajprepocetnask=1;
$ajregistracka=0;
if (File_Exists ("../dokumenty/FIR$kli_vxcf/ajregistracka.ano")) { $ajregistracka=1; }
$wedgb = 0;
if ( $fir_fico == 31423116 ) { $wedgb = 1; }
if ( $fir_fico == 36084212 ) { $poliklinikase = 1; $fir_big=1; }
if ( $fir_fico == 31424317 ) { $alchem = 1; $fir_big=1; }
if ( $fir_fico == 36671291 ) { $alchem = 1; }
if ( $fir_fico == 31431194 ) { $alchem = 1; }
if ( $fir_fico == 36684295 ) { $alchem = 1; }
if ( $fir_fico == 36238732 ) { $metalco = 1; }
if ( $fir_fico == 31419623 ) { $agrostav = 1; }
if ( $fir_fico == 31681743 ) { $autovalas = 1; $fir_big=1; $kontrolstrzak=1; }
if ( $fir_fico == 31424318 ) { $polno=1; }
if ( $fir_fico == 31104452 ) { $polno=1; }
if ( $fir_fico == 36239062 ) { $polno=1; }
if ( $fir_fico == 45232903 ) { $fir_big=1; } //eurodiskont
if( $_SERVER['SERVER_NAME'] == "www.stavoimpexsro.sk" ) { $stavoimpex=1; }
if( $_SERVER['SERVER_NAME'] == "www.lsucto.sk" ) { $lsucto=1; }
if( $_SERVER['SERVER_NAME'] == "www.merkfood.sk" ) { $merkfood=1; }
if( $_SERVER['SERVER_NAME'] == "www.ekorobot.sk" ) { $ekorobot=1; }
if( $_SERVER['SERVER_NAME'] == "www.euroramex.sk" ) { $ramex=1; }
if( $_SERVER['SERVER_NAME'] == "www.esoplastsro.sk" ) { $esoplast=1; }
if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" ) { $poliklinikase=1; }
if( $_SERVER['SERVER_NAME'] == "www.delisasro.sk" ) { $delisasro=1; }
if( $_SERVER['SERVER_NAME'] == "www.skplaysro.sk" ) { $slovakiaplay=1; }
if( $_SERVER['SERVER_NAME'] == "skplaysro" ) { $slovakiaplay=1; }
if( $_SERVER['SERVER_NAME'] == "www.emotranssro.sk" ) { $emotrans=1; }
if( $_SERVER['SERVER_NAME'] == "www.medosro.sk" ) { $medo=1; }
if( $_SERVER['SERVER_NAME'] == "www.eurosekov.sk" ) { $sekov=1; $kontrolstrzak=1; }
if( $_SERVER['SERVER_NAME'] == "www.pdkuty.sk" ) { $polno=1; $pdkuty=1; }
if( $_SERVER['SERVER_NAME'] == "www.kamenecsro.sk" ) { $polno=1; }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/ajprepocetnask.nie")) { $ajprepocetnask=0; }
if( $_SERVER['SERVER_NAME'] == "www.eurosecom.sk" ) { $fir_uctx03=1; }
if( $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $fir_uctx03=1; }

if( $_SERVER['SERVER_NAME'] != "localhost" AND $_SERVER['SERVER_NAME'] != "www.educto.sk" ) { $fir_xfa06=0; }
if( $_SERVER['SERVER_NAME'] == "www.educto.sk" ) 
{ 
if( $kli_vxcf != 2681 AND $kli_vxcf != 2682 ) { $fir_xfa06=0; } 
}
$longslu=0;
if ( $fir_fico == 46529233 ) { $longslu=1; }
$hosprok=0;
if ( $fir_fico == 50608738 OR $fir_fico == 50610040 ) { $hosprok=1; }



return $citfir;
?>