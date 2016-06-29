<!doctype html>
<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'MZD';
$urov = 3000;
$copern = $_REQUEST['copern'];
$tis = $_REQUEST['tis'];
if (!isset($tis)) $tis = 0;

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

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

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;


$cislo_oc = $_REQUEST['cislo_oc'];
$subor = $_REQUEST['subor'];
$rok = 1*$_REQUEST['rok'];
$fir = 1*$_REQUEST['fir'];

$lenjedenrok=0;

//nacitanie jedneho roka do evidencneho listu
    if ( $copern == 4155 )
    {
$rokm1=$kli_vrok-1;
$rokm2=$kli_vrok-2;
$rokm3=$kli_vrok-3;
$rokm4=$kli_vrok-4;
$rokm5=$kli_vrok-5;
$rokm6=$kli_vrok-6;
$rokm7=$kli_vrok-7;
$xrok=$rokm1;
if( $rok == 2 ) { $xrok=$rokm2; }
if( $rok == 3 ) { $xrok=$rokm3; }
if( $rok == 4 ) { $xrok=$rokm4; }
if( $rok == 5 ) { $xrok=$rokm5; }
if( $rok == 6 ) { $xrok=$rokm6; }
if( $rok == 7 ) { $xrok=$rokm7; }
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù hodnoty roku <?php echo $xrok; ?> do evidenËnÈho listu z firmy <?php echo $fir; ?> ? ") )
         { window.close()  }
else
         { location.href='evidencny_list.php?copern=4156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=<?php echo $rok; ?>&fir=<?php echo $fir; ?>'  }
</script>
<?php
    }

    if ( $copern == 4156 )
    {
$copern=26;
$lenjedenrok=$rok;
    }
//koniec nacitanie jedneho roka do evidencneho listu 

//vymazat evidencny list 
    if ( $copern == 6155 )
    {

?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù hodnoty evidenËnÈho listu ? ") )
         { window.close()  }
else
         { location.href='evidencny_list.php?copern=6156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>'  }
</script>
<?php
    }

    if ( $copern == 6156 )
    {

$sqlttt = "DELETE FROM F$kli_vxcf"."_mzdevidencny WHERE oc = $cislo_oc ";
$sqldok = mysql_query("$sqlttt");


$copern=20;
    }
//koniec vymazat evidencny list


//nacitanie minuleho roka do evidencneho listu 
    if ( $copern == 3155 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù hodnoty celÈho evidenËnÈho listu z firmy minulÈho roka ? ") )
         { window.close()  }
else
         { location.href='evidencny_list.php?copern=3156&page=1&drupoh=1&cislo_oc=<?php echo $cislo_oc; ?>'  }
</script>
<?php
    }

    if ( $copern == 3156 )
    {

$h_ycf=0;
if( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
if ( $kli_vrok > 2010 )
{
if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; }
}
if ( $kli_vrok > 2011 )
{
if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; }
}
if ( $kli_vrok > 2012 )
{
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; }
}
if ( $kli_vrok > 2013 )
{
if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; }
}
if ( $kli_vrok > 2014 )
{
if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; }
}
if ( $kli_vrok > 2015 )
{
if ( File_Exists("../pswd/oddelena2015db2016.php") ) { $databaza=$mysqldb2015."."; }
}

$uprtxt = "DELETE FROM F$kli_vxcf"."_mzdevidencny WHERE oc = $cislo_oc ";
$upravene = mysql_query("$uprtxt");

$uprtxt = "INSERT INTO F$kli_vxcf"."_mzdevidencny SELECT * FROM ".$databaza."F$h_ycf"."_mzdevidencny WHERE oc = $cislo_oc ";
$upravene = mysql_query("$uprtxt"); 

$copern=26;
//koniec nacitania celeho minuleho roka do evid.listu 
    }


// znovu nacitaj
if ( $copern == 26 )
    {
$uzjezaznam=0;
$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdevidencny WHERE oc = ".$cislo_oc;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $vz01=$riaddok->vz01;
  $kr01=$riaddok->kr01;
  $kr02=$riaddok->kr02;
  $kr03=$riaddok->kr03;
  $kr04=$riaddok->kr04;
  $kr05=$riaddok->kr05;
  $kr06=$riaddok->kr06;
  $kr07=$riaddok->kr07;
  $kr08=$riaddok->kr08;
  $kr09=$riaddok->kr09;
  $kr10=$riaddok->kr10;
  $kr11=$riaddok->kr11;
  $kr12=$riaddok->kr12;
  $kr13=$riaddok->kr13;
$uzjezaznam=1;
  }

if( $uzjezaznam == 1 ) {


if( $lenjedenrok > 0 )
{
$rokm1=$kli_vrok-1;
$rokm2=$kli_vrok-2;
$rokm3=$kli_vrok-3;
$rokm4=$kli_vrok-4;
$rokm5=$kli_vrok-5;
$rokm6=$kli_vrok-6;
$rokm7=$kli_vrok-7;
$xrok=$rokm1;
if( $lenjedenrok == 2 ) { $xrok=$rokm2; }
if( $lenjedenrok == 3 ) { $xrok=$rokm3; }
if( $lenjedenrok == 4 ) { $xrok=$rokm4; }
if( $lenjedenrok == 5 ) { $xrok=$rokm5; }
if( $lenjedenrok == 6 ) { $xrok=$rokm6; }
if( $lenjedenrok == 7 ) { $xrok=$rokm7; }
}


$databaza="";
if ( $xrok < 2016 AND $lenjedenrok > 0 )
{
if ( File_Exists("../pswd/oddelena2015db2016.php") ) { $databaza=$mysqldb2015."."; }
}
if ( $xrok < 2015 AND $lenjedenrok > 0 )
{
if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; }
}
if ( $xrok < 2014 AND $lenjedenrok > 0 )
{
if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; }
}
if ( $xrok < 2013 AND $lenjedenrok > 0 )
{
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; }
} 
if ( $xrok < 2012 AND $lenjedenrok > 0 )
{
if (File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; }
} 
if ( $xrok < 2011 AND $lenjedenrok > 0 )
{
if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; }
}                     


$vymzak=0;
$znakpoistenia="A";

$kli_vxcfx=$kli_vxcf;
if ( $lenjedenrok > 0 )
{
$kli_vxcfx=$fir;
}

$sqlttt = "SELECT SUM(zzam_sp) AS zzam_dp FROM ".$databaza."F$kli_vxcfx"."_mzdzalsum WHERE oc = $cislo_oc ";
//echo $sqlttt;
//exit;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $vymzak=$vymzak+$riaddok->zzam_dp;
  }

$sql = "CREATE TABLE F".$kli_vxcf."_mzdkun$kli_uzid ".
"SELECT * FROM ".$databaza."F".$kli_vxcfx."_mzdkun WHERE oc=$cislo_oc ";
$vysledek = mysql_query("$sql");

$dat0101=$kli_vrok."-01-01";
$dat3112=$kli_vrok."-12-31";
if( $lenjedenrok > 0 )
{
$rokm1=$kli_vrok-1;
$rokm2=$kli_vrok-2;
$rokm3=$kli_vrok-3;
$rokm4=$kli_vrok-4;
$rokm5=$kli_vrok-5;
$rokm6=$kli_vrok-6;
$rokm7=$kli_vrok-7;
$xrok=$rokm1;
if( $lenjedenrok == 2 ) { $xrok=$rokm2; }
if( $lenjedenrok == 3 ) { $xrok=$rokm3; }
if( $lenjedenrok == 4 ) { $xrok=$rokm4; }
if( $lenjedenrok == 5 ) { $xrok=$rokm5; }
if( $lenjedenrok == 6 ) { $xrok=$rokm6; }
if( $lenjedenrok == 7 ) { $xrok=$rokm7; }

$dat0101=$xrok."-01-01";
$dat3112=$xrok."-12-31";
}

$uprtxt = "UPDATE F$kli_vxcf"."_mzdkun$kli_uzid SET dan='$dat0101' WHERE dan < '$dat0101' "; 
$upravene = mysql_query("$uprtxt"); 
$uprtxt = "UPDATE F$kli_vxcf"."_mzdkun$kli_uzid SET dav='$dat3112' WHERE dan < '$dat0101' OR dav = '0000-00-00' "; 
$upravene = mysql_query("$uprtxt"); 
$uprtxt = "UPDATE F$kli_vxcf"."_mzdkun$kli_uzid SET pom=0 "; 
$upravene = mysql_query("$uprtxt"); 
$uprtxt = "UPDATE F$kli_vxcf"."_mzdkun$kli_uzid SET pom=1 WHERE dar <= '1984-12-31' "; 
$upravene = mysql_query("$uprtxt"); 

$ano513=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkun$kli_uzid WHERE oc = $cislo_oc ";
//echo $sqlttt;
//exit;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $datpoc=$riaddok->dan;
  $datkon=$riaddok->dav;
  $ano513=$riaddok->pom;
  }

$sql = "DROP TABLE F".$kli_vxcf."_mzdkun$kli_uzid ";
$vysledek = mysql_query("$sql");

$kaldni=0;
$vylkc=0;
$sqlttt = "SELECT SUM(TO_DAYS(dk)-TO_DAYS(dp)+1) AS kaldni FROM ".$databaza."F$kli_vxcfx"."_mzdzalvy WHERE oc = $cislo_oc AND ( dm >= 801 AND dm <= 802 )";
if( $alchem == 1 AND $ano513 == 1 )
{
$sqlttt = "SELECT SUM(TO_DAYS(dk)-TO_DAYS(dp)+1) AS kaldni, SUM(kc) AS vylkc FROM ".$databaza."F$kli_vxcfx"."_mzdzalvy WHERE oc = $cislo_oc AND ( dm = 801 OR dm = 802 OR dm = 513 )";
}
//echo $sqlttt;
//exit;
$sqldok = mysql_query("$sqlttt");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $kaldni=$riaddok->kaldni;
  $vylkc=$riaddok->vylkc;
  }

//echo $kaldni; echo " ".$Vylkc;
//exit;

$kli_vrokx=$kli_vrok;
if( $lenjedenrok > 0 )
{
$rokm1=$kli_vrok-1;
$rokm2=$kli_vrok-2;
$rokm3=$kli_vrok-3;
$rokm4=$kli_vrok-4;
$rokm5=$kli_vrok-5;
$rokm6=$kli_vrok-6;
$rokm7=$kli_vrok-7;
$kli_vrokx=$rokm1;
if( $lenjedenrok == 2 ) { $kli_vrokx=$rokm2; }
if( $lenjedenrok == 3 ) { $kli_vrokx=$rokm3; }
if( $lenjedenrok == 4 ) { $kli_vrokx=$rokm4; }
if( $lenjedenrok == 5 ) { $kli_vrokx=$rokm5; }
if( $lenjedenrok == 6 ) { $kli_vrokx=$rokm6; }
if( $lenjedenrok == 7 ) { $kli_vrokx=$rokm7; }
}

$uzje=0;
if( ( $kr01 == 0 OR $kr01 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr01='$kli_vrokx', vz01='$vymzak', zp01='$znakpoistenia', dp01='$datpoc', dk01='$datkon', kd01='$kaldni', vv01='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr02 == 0 OR $kr02 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr02='$kli_vrokx', vz02='$vymzak', zp02='$znakpoistenia', dp02='$datpoc', dk02='$datkon', kd02='$kaldni', vv02='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr03 == 0 OR $kr03 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr03='$kli_vrokx', vz03='$vymzak', zp03='$znakpoistenia', dp03='$datpoc', dk03='$datkon', kd03='$kaldni', vv03='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr04 == 0 OR $kr04 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr04='$kli_vrokx', vz04='$vymzak', zp04='$znakpoistenia', dp04='$datpoc', dk04='$datkon', kd04='$kaldni', vv04='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr05 == 0 OR $kr05 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr05='$kli_vrokx', vz05='$vymzak', zp05='$znakpoistenia', dp05='$datpoc', dk05='$datkon', kd05='$kaldni', vv05='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr06 == 0 OR $kr06 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr06='$kli_vrokx', vz06='$vymzak', zp06='$znakpoistenia', dp06='$datpoc', dk06='$datkon', kd06='$kaldni', vv06='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr07 == 0 OR $kr07 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr07='$kli_vrokx', vz07='$vymzak', zp07='$znakpoistenia', dp07='$datpoc', dk07='$datkon', kd07='$kaldni', vv07='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr08 == 0 OR $kr08 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr08='$kli_vrokx', vz08='$vymzak', zp08='$znakpoistenia', dp08='$datpoc', dk08='$datkon', kd08='$kaldni', vv08='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr09 == 0 OR $kr09 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr09='$kli_vrokx', vz09='$vymzak', zp09='$znakpoistenia', dp09='$datpoc', dk09='$datkon', kd09='$kaldni', vv09='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr10 == 0 OR $kr10 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr10='$kli_vrokx', vz10='$vymzak', zp10='$znakpoistenia', dp10='$datpoc', dk10='$datkon', kd10='$kaldni', vv10='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr11 == 0 OR $kr11 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr11='$kli_vrokx', vz11='$vymzak', zp11='$znakpoistenia', dp11='$datpoc', dk11='$datkon', kd11='$kaldni', vv11='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr12 == 0 OR $kr12 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr12='$kli_vrokx', vz12='$vymzak', zp12='$znakpoistenia', dp12='$datpoc', dk12='$datkon', kd12='$kaldni', vv12='$vylkc' WHERE oc = $cislo_oc"; }
if( ( $kr13 == 0 OR $kr13 == $kli_vrokx ) AND  $uzje == 0 ) { $uzje=1; $uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" kr13='$kli_vrokx', vz13='$vymzak', zp13='$znakpoistenia', dp13='$datpoc', dk13='$datkon', kd13='$kaldni', vv13='$vylkc' WHERE oc = $cislo_oc"; }

$upravene = mysql_query("$uprtxt"); 

                        }
$copern=20;
    }
//koniec znovu nacitaj

// zapis upravene udaje
if ( $copern == 23 )
    {
$dp01 = strip_tags($_REQUEST['dp01']);
$dp02 = strip_tags($_REQUEST['dp02']);
$dp03 = strip_tags($_REQUEST['dp03']);
$dp04 = strip_tags($_REQUEST['dp04']);
$dp05 = strip_tags($_REQUEST['dp05']);
$dp06 = strip_tags($_REQUEST['dp06']);
$dp07 = strip_tags($_REQUEST['dp07']);
$dp08 = strip_tags($_REQUEST['dp08']);
$dp09 = strip_tags($_REQUEST['dp09']);
$dp10 = strip_tags($_REQUEST['dp10']);
$dp11 = strip_tags($_REQUEST['dp11']);
$dp12 = strip_tags($_REQUEST['dp12']);
$dp13 = strip_tags($_REQUEST['dp13']);

$dk01 = strip_tags($_REQUEST['dk01']);
$dk02 = strip_tags($_REQUEST['dk02']);
$dk03 = strip_tags($_REQUEST['dk03']);
$dk04 = strip_tags($_REQUEST['dk04']);
$dk05 = strip_tags($_REQUEST['dk05']);
$dk06 = strip_tags($_REQUEST['dk06']);
$dk07 = strip_tags($_REQUEST['dk07']);
$dk08 = strip_tags($_REQUEST['dk08']);
$dk09 = strip_tags($_REQUEST['dk09']);
$dk10 = strip_tags($_REQUEST['dk10']);
$dk11 = strip_tags($_REQUEST['dk11']);
$dk12 = strip_tags($_REQUEST['dk12']);
$dk13 = strip_tags($_REQUEST['dk13']);

$kd01 = strip_tags($_REQUEST['kd01']);
$kd02 = strip_tags($_REQUEST['kd02']);
$kd03 = strip_tags($_REQUEST['kd03']);
$kd04 = strip_tags($_REQUEST['kd04']);
$kd05 = strip_tags($_REQUEST['kd05']);
$kd06 = strip_tags($_REQUEST['kd06']);
$kd07 = strip_tags($_REQUEST['kd07']);
$kd08 = strip_tags($_REQUEST['kd08']);
$kd09 = strip_tags($_REQUEST['kd09']);
$kd10 = strip_tags($_REQUEST['kd10']);
$kd11 = strip_tags($_REQUEST['kd11']);
$kd12 = strip_tags($_REQUEST['kd12']);
$kd13 = strip_tags($_REQUEST['kd13']);

$kr01 = strip_tags($_REQUEST['kr01']);
$kr02 = strip_tags($_REQUEST['kr02']);
$kr03 = strip_tags($_REQUEST['kr03']);
$kr04 = strip_tags($_REQUEST['kr04']);
$kr05 = strip_tags($_REQUEST['kr05']);
$kr06 = strip_tags($_REQUEST['kr06']);
$kr07 = strip_tags($_REQUEST['kr07']);
$kr08 = strip_tags($_REQUEST['kr08']);
$kr09 = strip_tags($_REQUEST['kr09']);
$kr10 = strip_tags($_REQUEST['kr10']);
$kr11 = strip_tags($_REQUEST['kr11']);
$kr12 = strip_tags($_REQUEST['kr12']);
$kr13 = strip_tags($_REQUEST['kr13']);

$zp01 = strip_tags($_REQUEST['zp01']);
$zp02 = strip_tags($_REQUEST['zp02']);
$zp03 = strip_tags($_REQUEST['zp03']);
$zp04 = strip_tags($_REQUEST['zp04']);
$zp05 = strip_tags($_REQUEST['zp05']);
$zp06 = strip_tags($_REQUEST['zp06']);
$zp07 = strip_tags($_REQUEST['zp07']);
$zp08 = strip_tags($_REQUEST['zp08']);
$zp09 = strip_tags($_REQUEST['zp09']);
$zp10 = strip_tags($_REQUEST['zp10']);
$zp11 = strip_tags($_REQUEST['zp11']);
$zp12 = strip_tags($_REQUEST['zp12']);
$zp13 = strip_tags($_REQUEST['zp13']);

$vz01 = strip_tags($_REQUEST['vz01']);
$vz02 = strip_tags($_REQUEST['vz02']);
$vz03 = strip_tags($_REQUEST['vz03']);
$vz04 = strip_tags($_REQUEST['vz04']);
$vz05 = strip_tags($_REQUEST['vz05']);
$vz06 = strip_tags($_REQUEST['vz06']);
$vz07 = strip_tags($_REQUEST['vz07']);
$vz08 = strip_tags($_REQUEST['vz08']);
$vz09 = strip_tags($_REQUEST['vz09']);
$vz10 = strip_tags($_REQUEST['vz10']);
$vz11 = strip_tags($_REQUEST['vz11']);
$vz12 = strip_tags($_REQUEST['vz12']);
$vz13 = strip_tags($_REQUEST['vz13']);

$vv01 = strip_tags($_REQUEST['vv01']);
$vv02 = strip_tags($_REQUEST['vv02']);
$vv03 = strip_tags($_REQUEST['vv03']);
$vv04 = strip_tags($_REQUEST['vv04']);
$vv05 = strip_tags($_REQUEST['vv05']);
$vv06 = strip_tags($_REQUEST['vv06']);
$vv07 = strip_tags($_REQUEST['vv07']);
$vv08 = strip_tags($_REQUEST['vv08']);
$vv09 = strip_tags($_REQUEST['vv09']);
$vv10 = strip_tags($_REQUEST['vv10']);
$vv11 = strip_tags($_REQUEST['vv11']);
$vv12 = strip_tags($_REQUEST['vv12']);
$vv13 = strip_tags($_REQUEST['vv13']);

$pozn = strip_tags($_REQUEST['pozn']);
$str2 = strip_tags($_REQUEST['str2']);
$oprav = strip_tags($_REQUEST['oprav']);
$predo = strip_tags($_REQUEST['predo']);

$uprav="NO";

$dk01_sql=SqlDatum($dk01);
$dk02_sql=SqlDatum($dk02);
$dk03_sql=SqlDatum($dk03);
$dk04_sql=SqlDatum($dk04);
$dk05_sql=SqlDatum($dk05);
$dk06_sql=SqlDatum($dk06);
$dk07_sql=SqlDatum($dk07);
$dk08_sql=SqlDatum($dk08);
$dk09_sql=SqlDatum($dk09);
$dk10_sql=SqlDatum($dk10);
$dk11_sql=SqlDatum($dk11);
$dk12_sql=SqlDatum($dk12);
$dk13_sql=SqlDatum($dk13);

$dp01_sql=SqlDatum($dp01);
$dp02_sql=SqlDatum($dp02);
$dp03_sql=SqlDatum($dp03);
$dp04_sql=SqlDatum($dp04);
$dp05_sql=SqlDatum($dp05);
$dp06_sql=SqlDatum($dp06);
$dp07_sql=SqlDatum($dp07);
$dp08_sql=SqlDatum($dp08);
$dp09_sql=SqlDatum($dp09);
$dp10_sql=SqlDatum($dp10);
$dp11_sql=SqlDatum($dp11);
$dp12_sql=SqlDatum($dp12);
$dp13_sql=SqlDatum($dp13);

$datum = strip_tags($_REQUEST['datum']);
$datum_sql=SqlDatum($datum);


$uprtxt = "UPDATE F$kli_vxcf"."_mzdevidencny SET ".
" dp01='$dp01_sql', dk01='$dk01_sql', dp02='$dp02_sql', dk02='$dk02_sql', dp03='$dp03_sql', dk03='$dk03_sql', dp04='$dp04_sql', dk04='$dk04_sql', ".
" dp05='$dp05_sql', dk05='$dk05_sql', dp06='$dp06_sql', dk06='$dk06_sql', dp07='$dp07_sql', dk07='$dk07_sql', dp08='$dp08_sql', dk08='$dk08_sql', ".
" dp09='$dp09_sql', dk09='$dk09_sql', dp10='$dp10_sql', dk10='$dk10_sql', dp11='$dp11_sql', dk11='$dk11_sql', dp12='$dp12_sql', dk12='$dk12_sql', ".
" dp13='$dp13_sql', dk13='$dk13_sql', ".
" kr01='$kr01', kr02='$kr02', kr03='$kr03', kr04='$kr04', kr05='$kr05', kr06='$kr06', ".
" kr07='$kr07', kr08='$kr08', kr09='$kr09', kr10='$kr10', kr11='$kr11', kr12='$kr12', kr13='$kr13', ".
" zp01='$zp01', zp02='$zp02', zp03='$zp03', zp04='$zp04', zp05='$zp05', zp06='$zp06', ".
" zp07='$zp07', zp08='$zp08', zp09='$zp09', zp10='$zp10', zp11='$zp11', zp12='$zp12', zp13='$zp13', ".
" kd01='$kd01', kd02='$kd02', kd03='$kd03', kd04='$kd04', kd05='$kd05', kd06='$kd06', ".
" kd07='$kd07', kd08='$kd08', kd09='$kd09', kd10='$kd10', kd11='$kd11', kd12='$kd12', kd13='$kd13', ".
" vv01='$vv01', vv02='$vv02', vv03='$vv03', vv04='$vv04', vv05='$vv05', vv06='$vv06', ".
" vv07='$vv07', vv08='$vv08', vv09='$vv09', vv10='$vv10', vv11='$vv11', vv12='$vv12', vv13='$vv13', ".
" vz01='$vz01', vz02='$vz02', vz03='$vz03', vz04='$vz04', vz05='$vz05', vz06='$vz06', ".
" vz07='$vz07', vz08='$vz08', vz09='$vz09', vz10='$vz10', vz11='$vz11', vz12='$vz12', vz13='$vz13', ".
" pozn='$pozn', oprav='$oprav', predo='$predo', datum='$datum_sql', str2='$str2'  ".
" WHERE oc = $cislo_oc"; 
//echo $uprtxt;
//exit;
$upravene = mysql_query("$uprtxt");  
$copern=20;
if (!$upravene):
?>
<script type="text/javascript"> alert( "⁄DAJE NEBOLI UPRAVEN…" ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych udajov


//prac.subor a subor vytvorenych potvrdeni
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<mzdprc
(
   oc           INT(7) DEFAULT 0,
   kr01         DECIMAL(10,0) DEFAULT 0,
   kr02         DECIMAL(10,0) DEFAULT 0,
   kr03         DECIMAL(10,0) DEFAULT 0,
   kr04         DECIMAL(10,0) DEFAULT 0,
   kr05         DECIMAL(10,0) DEFAULT 0,
   kr06         DECIMAL(10,0) DEFAULT 0,
   kr07         DECIMAL(10,0) DEFAULT 0,
   kr08         DECIMAL(10,0) DEFAULT 0,
   kr09         DECIMAL(10,0) DEFAULT 0,
   kr10         DECIMAL(10,0) DEFAULT 0,
   kr11         DECIMAL(10,0) DEFAULT 0,
   kr12         DECIMAL(10,0) DEFAULT 0,
   kr13         DECIMAL(10,0) DEFAULT 0,
   zp01         VARCHAR(5) NOT NULL,
   zp02         VARCHAR(5) NOT NULL,
   zp03         VARCHAR(5) NOT NULL,
   zp04         VARCHAR(5) NOT NULL,
   zp05         VARCHAR(5) NOT NULL,
   zp06         VARCHAR(5) NOT NULL,
   zp07         VARCHAR(5) NOT NULL,
   zp08         VARCHAR(5) NOT NULL,
   zp09         VARCHAR(5) NOT NULL,
   zp10         VARCHAR(5) NOT NULL,
   zp11         VARCHAR(5) NOT NULL,
   zp12         VARCHAR(5) NOT NULL,
   zp13         VARCHAR(5) NOT NULL,
   dp01         DATE,
   dp02         DATE,
   dp03         DATE,
   dp04         DATE,
   dp05         DATE,
   dp06         DATE,
   dp07         DATE,
   dp08         DATE,
   dp09         DATE,
   dp10         DATE,
   dp11         DATE,
   dp12         DATE,
   dp13         DATE,
   dk01         DATE,
   dk02         DATE,
   dk03         DATE,
   dk04         DATE,
   dk05         DATE,
   dk06         DATE,
   dk07         DATE,
   dk08         DATE,
   dk09         DATE,
   dk10         DATE,
   dk11         DATE,
   dk12         DATE,
   dk13         DATE,
   vz01         DECIMAL(10,2) DEFAULT 0,
   vz02         DECIMAL(10,2) DEFAULT 0,
   vz03         DECIMAL(10,2) DEFAULT 0,
   vz04         DECIMAL(10,2) DEFAULT 0,
   vz05         DECIMAL(10,2) DEFAULT 0,
   vz06         DECIMAL(10,2) DEFAULT 0,
   vz07         DECIMAL(10,2) DEFAULT 0,
   vz08         DECIMAL(10,2) DEFAULT 0,
   vz09         DECIMAL(10,2) DEFAULT 0,
   vz10         DECIMAL(10,2) DEFAULT 0,
   vz11         DECIMAL(10,2) DEFAULT 0,
   vz12         DECIMAL(10,2) DEFAULT 0,
   vz13         DECIMAL(10,2) DEFAULT 0,
   vv01         DECIMAL(10,2) DEFAULT 0,
   vv02         DECIMAL(10,2) DEFAULT 0,
   vv03         DECIMAL(10,2) DEFAULT 0,
   vv04         DECIMAL(10,2) DEFAULT 0,
   vv05         DECIMAL(10,2) DEFAULT 0,
   vv06         DECIMAL(10,2) DEFAULT 0,
   vv07         DECIMAL(10,2) DEFAULT 0,
   vv08         DECIMAL(10,2) DEFAULT 0,
   vv09         DECIMAL(10,2) DEFAULT 0,
   vv10         DECIMAL(10,2) DEFAULT 0,
   vv11         DECIMAL(10,2) DEFAULT 0,
   vv12         DECIMAL(10,2) DEFAULT 0,
   vv13         DECIMAL(10,2) DEFAULT 0,
   kd01         DECIMAL(10,0) DEFAULT 0,
   kd02         DECIMAL(10,0) DEFAULT 0,
   kd03         DECIMAL(10,0) DEFAULT 0,
   kd04         DECIMAL(10,0) DEFAULT 0,
   kd05         DECIMAL(10,0) DEFAULT 0,
   kd06         DECIMAL(10,0) DEFAULT 0,
   kd07         DECIMAL(10,0) DEFAULT 0,
   kd08         DECIMAL(10,0) DEFAULT 0,
   kd09         DECIMAL(10,0) DEFAULT 0,
   kd10         DECIMAL(10,0) DEFAULT 0,
   kd11         DECIMAL(10,0) DEFAULT 0,
   kd12         DECIMAL(10,0) DEFAULT 0,
   kd13         DECIMAL(10,0) DEFAULT 0,
   konx         DECIMAL(1,0) DEFAULT 0,
   pozn         VARCHAR(80),
   str2         TEXT,
   datum        DATE
);
mzdprc;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = 'CREATE TABLE F'.$kli_vxcf.'_mzdevidencny'.$sqlt;
$vytvor = mysql_query("$vsql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdevidencny ADD pozn VARCHAR(80) AFTER konx";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdevidencny ADD predo VARCHAR(50) NOT NULL AFTER datum";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_mzdevidencny ADD oprav DECIMAL(2,0) DEFAULT 0 AFTER datum";
$vysledek = mysql_query("$sql");

$jepotvrd=0;
$sql = "SELECT * FROM F$kli_vxcf"."_mzdevidencny WHERE oc = $cislo_oc";
$sqldok = mysql_query("$sql");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $jepotvrd=1;
  }
if( $jepotvrd == 0 ) $subor=1;

//pre potvrdenie vytvor pracovny subor
if( $subor == 1 )
{

//zober data z kun
$dsqlt = "INSERT INTO F$kli_vxcf"."_mzdevidencny".
" SELECT oc,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"'','','','','','','','','','','','','',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"'0000-00-00','0000-00-00','0000-00-00','0000-00-00','0000-00-00',".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"0,0,0,0,0,0,0,0,0,0,0,0,0,".
"1,'','','0000-00-00',0,'' ".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE F$kli_vxcf"."_mzdkun.oc = $cislo_oc".
"";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


}
//koniec pracovneho suboru pre potvrdenie 

/////////////NACITANIE UDAJOV Z PARAMETROV
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdprm");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $cicz=$riaddok->cicz;
  }

/////////////////////////////////////////////////VYTLAC POTVRDENIE
if( $copern == 10 )
{

//urob sucet
$sqtoz = "UPDATE F$kli_vxcf"."_mzdevidencny".
" SET vzspolu=vz01+vz02+vz03+vz04+vz05+vz06+vz07+vz08+vz09+vz10+vz11+vz12 WHERE oc >= 0";
//echo $sqtoz;
$oznac = mysql_query("$sqtoz");



if ( File_Exists("../tmp/evidlist.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/evidlist.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqltt = "SELECT * FROM F$kli_vxcf"."_mzdevidencny".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdevidencny.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdevidencny.oc = $cislo_oc AND konx = 1 ORDER BY konx,prie,meno";

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
//echo $sqltt;
//exit;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

  $ozam_np = $hlavicka->ozam_np;
  $pole = explode(".", $ozam_np);
  $Cozam_np = $pole[0];
  $Dozam_np = substr($pole[1],0,1);

$pdf->AddPage();
$pdf->SetFont('arial','',10);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/mzdy_potvrdenia/evidencny_list/evidencny_list.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/mzdy_potvrdenia/evidencny_list/evidencny_list.jpg',0,0,210,297);
}
$pdf->SetY(10);

//vyplnene strojom
$pdf->Cell(190,23," ","$rmc1",1,"L");
$str2=1*$hlavicka->str2;
if ( $_SERVER['SERVER_NAME'] == "www.zerotax.sk" ) { $strojom="X"; }
if ( $str2 == 1 ) { $strojom="X"; }
if ( $str2 != 1 ) { $strojom=" "; }
$pdf->Cell(48,3," ","$rmc1",0,"L");$pdf->Cell(3,4,"$strojom","$rmc",0,"C");

//opravny
$opravx="";
if ( $hlavicka->oprav == 1 ) { $opravx="X"; }
$pdf->Cell(14,3," ","$rmc1",0,"L");$pdf->Cell(4,4,"$opravx","$rmc",1,"C");

//I.POISTENEC
//priezvisko, meno, titul
$pdf->Cell(190,8," ","$rmc1",1,"L");
$pdf->Cell(92,6,"$hlavicka->prie","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(63,6,"$hlavicka->meno","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(31,6,"$hlavicka->titl","$rmc",1,"L");
//rod.,predo priezviska
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(92,5,"$hlavicka->rodn","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(94,5,"$hlavicka->predo","$rmc",1,"L");
//narodenia
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(126,6,"$hlavicka->mnr","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$dar=SkDatum($hlavicka->dar);
$pole = explode(".", $dar);
$dar1=$pole[0];
$dar2=$pole[1];
$dar3=$pole[2];
$pdf->Cell(28,6,"$dar1$dar2$dar3","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(32,6,"$hlavicka->rdc$hlavicka->rdk","$rmc",1,"L");
//ulica a cislo
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pdf->Cell(89,6,"$hlavicka->zuli","$rmc",0,"L");$pdf->Cell(40,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$hlavicka->zcdm","$rmc",0,"L");$pdf->Cell(30,6," ","$rmc1",1,"L");
//obec a psc
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(126,6,"$hlavicka->zmes","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$hlavicka->zpsc","$rmc",1,"L");
//nastup a vystup
$pdf->Cell(190,3," ","$rmc1",1,"L");
$dan=SkDatum($hlavicka->dan);
$pole = explode(".", $dan);
$dan1=$pole[0];
$dan2=$pole[1];
$dan3=$pole[2];
$pdf->Cell(98,6," ","$rmc1",0,"L");$pdf->Cell(28,6,"$dan1$dan2$dan3","$rmc",0,"C");
//
$dav=SkDatum($hlavicka->dav);
$pole = explode(".", $dav);
$dav1=$pole[0];
$dav2=$pole[1];
$dav3=$pole[2];
$davx=$dav1.$dav2.$dav3;
if ( $davx == 00000000 ) $davx="";
$pdf->Cell(3,6," ","$rmc1",0,"L");$pdf->Cell(28,6,"$davx","$rmc",1,"C");

//II.OBDOBIA
if ( $hlavicka->kr01 > 0 )
{
$vz01=$hlavicka->vz01;
//if( $hlavicka->vz01 == 0 ) $vz01="";
$vv01=$hlavicka->vv01;
if ( $hlavicka->vv01 == 0 ) $vv01="";
$kd01=$hlavicka->kd01;
if ( $hlavicka->kd01 == 0 ) $kd01="";
$dp01=SkDatum($hlavicka->dp01);
if ( $dp01 == "00.00.0000" ) $dp01="";
$dk01=SkDatum($hlavicka->dk01);
if ( $dk01 == "00.00.0000" ) $dk01="";
$pole = explode(".", $vz01);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr01 < 2009 ) $vz01=$cel;
$pole = explode(".", $vv01);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr01 < 2009 ) $vv01=$cel;
if ( $hlavicka->kr01 >= 2009 ) { $vz01=str_replace(".",",",$vz01); $vv01=str_replace(".",",",$vv01); }
$pole = explode(".", $dp01);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk01);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(113);
$pdf->Cell(13,6,"$hlavicka->kr01","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp01","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz01","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv01","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd01","$rmc",1,"R");
}

if ( $hlavicka->kr02 > 0 )
{
$vz02=$hlavicka->vz02;
//if( $hlavicka->vz02 == 0 ) $vz02="";
$vv02=$hlavicka->vv02;
if ( $hlavicka->vv02 == 0 ) $vv02="";
$kd02=$hlavicka->kd02;
if ( $hlavicka->kd02 == 0 ) $kd02="";
$dp02=SkDatum($hlavicka->dp02);
if ( $dp02 == "00.00.0000" ) $dp02="";
$dk02=SkDatum($hlavicka->dk02);
if ( $dk02 == "00.00.0000" ) $dk02="";
$pole = explode(".", $vz02);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr02 < 2009 ) $vz02=$cel;
$pole = explode(".", $vv02);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr02 < 2009 ) $vv02=$cel;
if ( $hlavicka->kr02 >= 2009 ) { $vz02=str_replace(".",",",$vz02); $vv02=str_replace(".",",",$vv02); }
$pole = explode(".", $dp02);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk02);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(121);
$pdf->Cell(13,6,"$hlavicka->kr02","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp02","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz02","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv02","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd02","$rmc",1,"R");
}

if ( $hlavicka->kr03 > 0 )
{
$vz03=$hlavicka->vz03;
//if( $hlavicka->vz03 == 0 ) $vz03="";
$vv03=$hlavicka->vv03;
if ( $hlavicka->vv03 == 0 ) $vv03="";
$kd03=$hlavicka->kd03;
if ( $hlavicka->kd03 == 0 ) $kd03="";
$dp03=SkDatum($hlavicka->dp03);
if ( $dp03 == "00.00.0000" ) $dp03="";
$dk03=SkDatum($hlavicka->dk03);
if ( $dk03 == "00.00.0000" ) $dk03="";
$pole = explode(".", $vz03);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr03 < 2009 ) $vz03=$cel;
$pole = explode(".", $vv03);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr03 < 2009 ) $vv03=$cel;
if ( $hlavicka->kr03 >= 2009 ) { $vz03=str_replace(".",",",$vz03); $vv03=str_replace(".",",",$vv03); }
$pole = explode(".", $dp03);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk03);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(130);
$pdf->Cell(13,6,"$hlavicka->kr03","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp03","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz03","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv03","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd03","$rmc",1,"R");
}

if ( $hlavicka->kr04 > 0 )
{
$vz04=$hlavicka->vz04;
//if( $hlavicka->vz04 == 0 ) $vz04="";
$vv04=$hlavicka->vv04;
if ( $hlavicka->vv04 == 0 ) $vv04="";
$kd04=$hlavicka->kd04;
if ( $hlavicka->kd04 == 0 ) $kd04="";
$dp04=SkDatum($hlavicka->dp04);
if ( $dp04 == "00.00.0000" ) $dp04="";
$dk04=SkDatum($hlavicka->dk04);
if ( $dk04 == "00.00.0000" ) $dk04="";
$pole = explode(".", $vz04);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr04 < 2009 ) $vz04=$cel;
$pole = explode(".", $vv04);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr04 < 2009 ) $vv04=$cel;
if ( $hlavicka->kr04 >= 2009 ) { $vz04=str_replace(".",",",$vz04); $vv04=str_replace(".",",",$vv04); }
$pole = explode(".", $dp04);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk04);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(138);
$pdf->Cell(13,6,"$hlavicka->kr04","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp04","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz04","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv04","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd04","$rmc",1,"R");
}

if ( $hlavicka->kr05 > 0 )
{
$vz05=$hlavicka->vz05;
//if( $hlavicka->vz05 == 0 ) $vz05="";
$vv05=$hlavicka->vv05;
if ( $hlavicka->vv05 == 0 ) $vv05="";
$kd05=$hlavicka->kd05;
if ( $hlavicka->kd05 == 0 ) $kd05="";
$dp05=SkDatum($hlavicka->dp05);
if ( $dp05 == "00.00.0000" ) $dp05="";
$dk05=SkDatum($hlavicka->dk05);
if ( $dk05 == "00.00.0000" ) $dk05="";
$pole = explode(".", $vz05);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr05 < 2009 ) $vz05=$cel;
$pole = explode(".", $vv05);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr05 < 2009 ) $vv05=$cel;
if ( $hlavicka->kr05 >= 2009 ) { $vz05=str_replace(".",",",$vz05); $vv05=str_replace(".",",",$vv05); }
$pole = explode(".", $dp05);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk05);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(147);
$pdf->Cell(13,6,"$hlavicka->kr05","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp05","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz05","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv05","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd05","$rmc",1,"R");
}

if ( $hlavicka->kr06 > 0 )
{
$vz06=$hlavicka->vz06;
//if( $hlavicka->vz06 == 0 ) $vz06="";
$vv06=$hlavicka->vv06;
if ( $hlavicka->vv06 == 0 ) $vv06="";
$kd06=$hlavicka->kd06;
if ( $hlavicka->kd06 == 0 ) $kd06="";
$dp06=SkDatum($hlavicka->dp06);
if ( $dp06 == "00.00.0000" ) $dp06="";
$dk06=SkDatum($hlavicka->dk06);
if ( $dk06 == "00.00.0000" ) $dk06="";
$pole = explode(".", $vz06);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr06 < 2009 ) $vz06=$cel;
$pole = explode(".", $vv06);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr06 < 2009 ) $vv06=$cel;
if ( $hlavicka->kr06 >= 2009 ) { $vz06=str_replace(".",",",$vz06); $vv06=str_replace(".",",",$vv06); }
$pole = explode(".", $dp06);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk06);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(155);
$pdf->Cell(13,6,"$hlavicka->kr06","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp06","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz06","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv06","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd06","$rmc",1,"R");
}

if ( $hlavicka->kr07 > 0 )
{
$vz07=$hlavicka->vz07;
//if( $hlavicka->vz07 == 0 ) $vz07="";
$vv07=$hlavicka->vv07;
if ( $hlavicka->vv07 == 0 ) $vv07="";
$kd07=$hlavicka->kd07;
if ( $hlavicka->kd07 == 0 ) $kd07="";
$dp07=SkDatum($hlavicka->dp07);
if ( $dp07 == "00.00.0000" ) $dp07="";
$dk07=SkDatum($hlavicka->dk07);
if ( $dk07 == "00.00.0000" ) $dk07="";
$pole = explode(".", $vz07);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr07 < 2009 ) $vz07=$cel;
$pole = explode(".", $vv07);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr07 < 2009 ) $vv07=$cel;
if ( $hlavicka->kr07 >= 2009 ) { $vz07=str_replace(".",",",$vz07); $vv07=str_replace(".",",",$vv07); }
$pole = explode(".", $dp07);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk07);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(164);
$pdf->Cell(13,6,"$hlavicka->kr07","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp07","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz07","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv07","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd07","$rmc",1,"R");
}

if ( $hlavicka->kr08 > 0 )
{
$vz08=$hlavicka->vz08;
//if( $hlavicka->vz08 == 0 ) $vz08="";
$vv08=$hlavicka->vv08;
if ( $hlavicka->vv08 == 0 ) $vv08="";
$kd08=$hlavicka->kd08;
if ( $hlavicka->kd08 == 0 ) $kd08="";
$dp08=SkDatum($hlavicka->dp08);
if ( $dp08 == "00.00.0000" ) $dp08="";
$dk08=SkDatum($hlavicka->dk08);
if ( $dk08 == "00.00.0000" ) $dk08="";
$pole = explode(".", $vz08);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr08 < 2009 ) $vz08=$cel;
$pole = explode(".", $vv08);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr08 < 2009 ) $vv08=$cel;
if ( $hlavicka->kr08 >= 2009 ) { $vz08=str_replace(".",",",$vz08); $vv08=str_replace(".",",",$vv08); }
$pole = explode(".", $dp08);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk08);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(172);
$pdf->Cell(13,6,"$hlavicka->kr08","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp08","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz08","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv08","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd08","$rmc",1,"R");
}

if ( $hlavicka->kr09 > 0 )
{
$vz09=$hlavicka->vz09;
//if( $hlavicka->vz09 == 0 ) $vz09="";
$vv09=$hlavicka->vv09;
if ( $hlavicka->vv09 == 0 ) $vv09="";
$kd09=$hlavicka->kd09;
if ( $hlavicka->kd09 == 0 ) $kd09="";
$dp09=SkDatum($hlavicka->dp09);
if ( $dp09 == "00.00.0000" ) $dp09="";
$dk09=SkDatum($hlavicka->dk09);
if ( $dk09 == "00.00.0000" ) $dk09="";
$pole = explode(".", $vz09);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr09 < 2009 ) $vz09=$cel;
$pole = explode(".", $vv09);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr09 < 2009 ) $vv09=$cel;
if ( $hlavicka->kr09 >= 2009 ) { $vz09=str_replace(".",",",$vz09); $vv09=str_replace(".",",",$vv09); }
$pole = explode(".", $dp09);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk09);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(180);
$pdf->Cell(13,6,"$hlavicka->kr09","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp09","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz09","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv09","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd09","$rmc",1,"R");
}

if ( $hlavicka->kr10 > 0 )
{
$vz10=$hlavicka->vz10;
//if( $hlavicka->vz10 == 0 ) $vz10="";
$vv10=$hlavicka->vv10;
if ( $hlavicka->vv10 == 0 ) $vv10="";
$kd10=$hlavicka->kd10;
if ( $hlavicka->kd10 == 0 ) $kd10="";
$dp10=SkDatum($hlavicka->dp10);
if ( $dp10 == "00.00.0000" ) $dp10="";
$dk10=SkDatum($hlavicka->dk10);
if ( $dk10 == "00.00.0000" ) $dk10="";
$pole = explode(".", $vz10);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr10 < 2009 ) $vz10=$cel;
$pole = explode(".", $vv10);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr10 < 2009 ) $vv10=$cel;
if ( $hlavicka->kr10 >= 2009 ) { $vz10=str_replace(".",",",$vz10); $vv10=str_replace(".",",",$vv10); }
$pole = explode(".", $dp10);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk10);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(189);
$pdf->Cell(13,6,"$hlavicka->kr10","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp10","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz10","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv10","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd10","$rmc",1,"R");
}

if ( $hlavicka->kr11 > 0 )
{
$vz11=$hlavicka->vz11;
//if( $hlavicka->vz11 == 0 ) $vz11="";
$vv11=$hlavicka->vv11;
if ( $hlavicka->vv11 == 0 ) $vv11="";
$kd11=$hlavicka->kd11;
if ( $hlavicka->kd11 == 0 ) $kd11="";
$dp11=SkDatum($hlavicka->dp11);
if ( $dp11 == "00.00.0000" ) $dp11="";
$dk11=SkDatum($hlavicka->dk11);
if ( $dk11 == "00.00.0000" ) $dk11="";
$pole = explode(".", $vz11);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr11 < 2009 ) $vz11=$cel;
$pole = explode(".", $vv11);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr11 < 2009 ) $vv11=$cel;
if ( $hlavicka->kr11 >= 2009 ) { $vz11=str_replace(".",",",$vz11); $vv11=str_replace(".",",",$vv11); }
$pole = explode(".", $dp11);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk11);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(197);
$pdf->Cell(13,6,"$hlavicka->kr11","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp11","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz11","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv11","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd11","$rmc",1,"R");
}

if ( $hlavicka->kr12 > 0 )
{
$vz12=$hlavicka->vz12;
//if( $hlavicka->vz12 == 0 ) $vz12="";
$vv12=$hlavicka->vv12;
if ( $hlavicka->vv12 == 0 ) $vv12="";
$kd12=$hlavicka->kd12;
if ( $hlavicka->kd12 == 0 ) $kd12="";
$dp12=SkDatum($hlavicka->dp12);
if ( $dp12 == "00.00.0000" ) $dp12="";
$dk12=SkDatum($hlavicka->dk12);
if ( $dk12 == "00.00.0000" ) $dk12="";
$pole = explode(".", $dp12);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk12);
$dnik=$pole[0];
$mesk=$pole[1];
$pole = explode(".", $vz12);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr12 < 2009 ) $vz12=$cel;
$pole = explode(".", $vv12);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr12 < 2009 ) $vv12=$cel;
if ( $hlavicka->kr12 >= 2009 ) { $vz12=str_replace(".",",",$vz12); $vv12=str_replace(".",",",$vv12); }
$pdf->SetY(206);
$pdf->Cell(13,6,"$hlavicka->kr12","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp12","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz12","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv12","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd12","$rmc",1,"R");
}

if ( $hlavicka->kr13 > 0 )
{
$vz13=$hlavicka->vz13;
if ( $hlavicka->vz13 == 0 ) $vz13="";
$vv13=$hlavicka->vv13;
if ( $hlavicka->vv13 == 0 ) $vv13="";
$kd13=$hlavicka->kd13;
if ( $hlavicka->kd13 == 0 ) $kd13="";
$dp13=SkDatum($hlavicka->dp13);
if ( $dp13 == "00.00.0000" ) $dp13="";
$dk13=SkDatum($hlavicka->dk13);
if ( $dk13 == "00.00.0000" ) $dk13="";
$pole = explode(".", $vz13);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr13 < 2009 ) $vz13=$cel;
$pole = explode(".", $vv13);
$cel=$pole[0];
$des=$pole[1];
if ( $hlavicka->kr13 < 2009 ) $vv13=$cel;
if ( $hlavicka->kr13 >= 2009 ) { $vz13=str_replace(".",",",$vz13); $vv13=str_replace(".",",",$vv13); }
$pole = explode(".", $dp13);
$dnip=$pole[0];
$mesp=$pole[1];
$pole = explode(".", $dk13);
$dnik=$pole[0];
$mesk=$pole[1];
$pdf->SetY(214);
$pdf->Cell(13,6,"$hlavicka->kr13","$rmc",0,"C");$pdf->Cell(7,6," ","$rmc1",0,"L");
$pdf->Cell(16,6,"$hlavicka->zp13","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnip","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$mesp","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(10,6,"$dnik","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(11,6,"$mesk","$rmc",0,"C");$pdf->Cell(4,6," ","$rmc1",0,"L");
$pdf->Cell(23,6,"$vz13","$rmc",0,"R");$pdf->Cell(2,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$vv13","$rmc",0,"R");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(17,6,"$kd13","$rmc",1,"R");
}

//III.ZAMESTNAVATEL
//nazov
$pdf->SetY(231);
$pdf->Cell(192,6,"$fir_fnaz","$rmc",1,"L");
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(126,6," ","$rmc",0,"L");$pdf->Cell(10,6," ","$rmc1",0,"L");
//kriziky ico/dic
$pdf->Cell(4,6,"X","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc1",0,"L");
$pdf->Cell(4,6," ","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc1",0,"L");
//cislo organizacia
$pdf->Cell(37,6," $fir_fico","$rmc",1,"L");
//ulica a cislo
$pdf->Cell(190,2," ","$rmc1",1,"L");
$pdf->Cell(89,6,"$fir_fuli","$rmc",0,"L");$pdf->Cell(40,7," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$fir_fcdm","$rmc",0,"L");$pdf->Cell(30,6," ","$rmc1",1,"L");
//obec a psc
$pdf->Cell(190,3," ","$rmc1",1,"L");
$pdf->Cell(126,6,"$fir_fmes","$rmc",0,"L");$pdf->Cell(3,6," ","$rmc1",0,"L");
$pdf->Cell(22,6,"$fir_fpsc","$rmc",1,"L");

//datum odoslania
$pdf->Cell(190,6," ","$rmc1",1,"L");
$datum=SkDatum($hlavicka->datum);
if ( $datum == '00.00.0000' ) { $datum=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); }
$pole = explode(".", $datum);
$datum1=$pole[0];
$datum2=$pole[1];
$datum3=$pole[2];
$pdf->Cell(23,6,"$datum1$datum2$datum3","$rmc",0,"C");

}
$i = $i + 1;
  }
$pdf->Output("../tmp/evidlist.$kli_uzid.pdf");
?>

<script type="text/javascript">
  var okno = window.open("../tmp/evidlist.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
}
/////////////////////////////////////////KONIEC VYTLACENIA POTVRDENIA FO

//nacitaj udaje pre upravu
if ( $copern == 20 )
    {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_mzdevidencny".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_mzdevidencny.oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_mzdevidencny.oc = $cislo_oc AND konx = 1 ORDER BY konx,prie,meno";

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$oc = $fir_riadok->oc;
$meno = $fir_riadok->meno;
$prie = $fir_riadok->prie;
$titl = $fir_riadok->titl;
$rodprie = $fir_riadok->rodn;
$mnr = $fir_riadok->mnr;
$dar = $fir_riadok->dar;
$dar_sk=SkDatum($dar);
$rodne = $fir_riadok->rdc."/".$fir_riadok->rdk;
$ulica = $fir_riadok->zuli;
$dom = $fir_riadok->zcdm;
$obec = $fir_riadok->zmes;
$psc = $fir_riadok->zpsc;
$dan = $fir_riadok->dan;
$dan_sk=SkDatum($dan);
$dav = $fir_riadok->dav;
$dav_sk=SkDatum($dav);

$dp01 = SkDatum($fir_riadok->dp01);
$dk01 = SkDatum($fir_riadok->dk01);
$dp02 = SkDatum($fir_riadok->dp02);
$dk02 = SkDatum($fir_riadok->dk02);
$dp03 = SkDatum($fir_riadok->dp03);
$dk03 = SkDatum($fir_riadok->dk03);
$dp04 = SkDatum($fir_riadok->dp04);
$dk04 = SkDatum($fir_riadok->dk04);
$dp05 = SkDatum($fir_riadok->dp05);
$dk05 = SkDatum($fir_riadok->dk05);
$dp06 = SkDatum($fir_riadok->dp06);
$dk06 = SkDatum($fir_riadok->dk06);
$dp07 = SkDatum($fir_riadok->dp07);
$dk07 = SkDatum($fir_riadok->dk07);
$dp08 = SkDatum($fir_riadok->dp08);
$dk08 = SkDatum($fir_riadok->dk08);
$dp09 = SkDatum($fir_riadok->dp09);
$dk09 = SkDatum($fir_riadok->dk09);
$dp10 = SkDatum($fir_riadok->dp10);
$dk10 = SkDatum($fir_riadok->dk10);
$dp11 = SkDatum($fir_riadok->dp11);
$dk11 = SkDatum($fir_riadok->dk11);
$dp12 = SkDatum($fir_riadok->dp12);
$dk12 = SkDatum($fir_riadok->dk12);
$dp13 = SkDatum($fir_riadok->dp13);
$dk13 = SkDatum($fir_riadok->dk13);

$kr01 = $fir_riadok->kr01;
$kr02 = $fir_riadok->kr02;
$kr03 = $fir_riadok->kr03;
$kr04 = $fir_riadok->kr04;
$kr05 = $fir_riadok->kr05;
$kr06 = $fir_riadok->kr06;
$kr07 = $fir_riadok->kr07;
$kr08 = $fir_riadok->kr08;
$kr09 = $fir_riadok->kr09;
$kr10 = $fir_riadok->kr10;
$kr11 = $fir_riadok->kr11;
$kr12 = $fir_riadok->kr12;
$kr13 = $fir_riadok->kr13;

$zp01 = $fir_riadok->zp01;
$zp02 = $fir_riadok->zp02;
$zp03 = $fir_riadok->zp03;
$zp04 = $fir_riadok->zp04;
$zp05 = $fir_riadok->zp05;
$zp06 = $fir_riadok->zp06;
$zp07 = $fir_riadok->zp07;
$zp08 = $fir_riadok->zp08;
$zp09 = $fir_riadok->zp09;
$zp10 = $fir_riadok->zp10;
$zp11 = $fir_riadok->zp11;
$zp12 = $fir_riadok->zp12;
$zp13 = $fir_riadok->zp13;

$vz01 = $fir_riadok->vz01;
$vz02 = $fir_riadok->vz02;
$vz03 = $fir_riadok->vz03;
$vz04 = $fir_riadok->vz04;
$vz05 = $fir_riadok->vz05;
$vz06 = $fir_riadok->vz06;
$vz07 = $fir_riadok->vz07;
$vz08 = $fir_riadok->vz08;
$vz09 = $fir_riadok->vz09;
$vz10 = $fir_riadok->vz10;
$vz11 = $fir_riadok->vz11;
$vz12 = $fir_riadok->vz12;
$vz13 = $fir_riadok->vz13;

$vv01 = $fir_riadok->vv01;
$vv02 = $fir_riadok->vv02;
$vv03 = $fir_riadok->vv03;
$vv04 = $fir_riadok->vv04;
$vv05 = $fir_riadok->vv05;
$vv06 = $fir_riadok->vv06;
$vv07 = $fir_riadok->vv07;
$vv08 = $fir_riadok->vv08;
$vv09 = $fir_riadok->vv09;
$vv10 = $fir_riadok->vv10;
$vv11 = $fir_riadok->vv11;
$vv12 = $fir_riadok->vv12;
$vv13 = $fir_riadok->vv13;

$kd01 = $fir_riadok->kd01;
$kd02 = $fir_riadok->kd02;
$kd03 = $fir_riadok->kd03;
$kd04 = $fir_riadok->kd04;
$kd05 = $fir_riadok->kd05;
$kd06 = $fir_riadok->kd06;
$kd07 = $fir_riadok->kd07;
$kd08 = $fir_riadok->kd08;
$kd09 = $fir_riadok->kd09;
$kd10 = $fir_riadok->kd10;
$kd11 = $fir_riadok->kd11;
$kd12 = $fir_riadok->kd12;
$kd13 = $fir_riadok->kd13;

$pozn = $fir_riadok->pozn;
$oprav = $fir_riadok->oprav;
$predo = $fir_riadok->predo;
$str2 = 1*$fir_riadok->str2;
$datum = SkDatum($fir_riadok->datum);
if ( $datum == '00.00.0000' ) 
{ 
$datum=Date ("d.m.Y", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"))); 
$datumsql=SqlDatum($datum);
$sqlx = "UPDATE F$kli_vxcf"."_mzdevidencny SET datum='$datumsql' ";
$vysledekx = mysql_query("$sqlx");
}

mysql_free_result($fir_vysledok);
    }
//koniec nacitania
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - EvidenËn˝ list dÙchodkovÈho poistenia</title>
<style type="text/css">
form input[type=text] {
  height: 20px;
  line-height: 20px;
  font-size: 14px;
}
form select {
  height: 24px;
}
img.btn-row-tool {
  width: 20px;
  height: 20px;
  cursor: default;
}
p.nacitaj-bar {
  height: 20px;
  line-height: 20px;
  margin-left: 10px;
  border-left: 2px solid lightblue;
  border-right: 2px solid lightblue;
  padding-right: 5px;
  padding-left: 7px;
}
p.nacitaj-bar > span {
  font-size: 12px;
  padding-right: 2px;
}
p.nacitaj-bar > a {
  font-size: 13px;
  color: #39f;
  font-weight: bold;
  margin: 0 1px;
}
p.nacitaj-bar > a:hover {
  border-bottom: 1px solid #39f;
}
</style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height-20;
var sirkawic = screen.width-10;

  function Dp01Onfocus(e)
  {
   var krx = document.formv1.kr01.value;
   if ( document.formv1.dp01.value == '00.00.0000' ) document.formv1.dp01.value = '01.01.' + krx;
   if ( document.formv1.dk01.value == '00.00.0000' ) document.formv1.dk01.value = '31.12.' + krx;
  }
  function Dp02Onfocus(e)
  {
   var krx = document.formv1.kr02.value;
   if ( document.formv1.dp02.value == '00.00.0000' ) document.formv1.dp02.value = '01.01.' + krx;
   if ( document.formv1.dk02.value == '00.00.0000' ) document.formv1.dk02.value = '31.12.' + krx;
  }
  function Dp03Onfocus(e)
  {
   var krx = document.formv1.kr03.value;
   if ( document.formv1.dp03.value == '00.00.0000' ) document.formv1.dp03.value = '01.01.' + krx;
   if ( document.formv1.dk03.value == '00.00.0000' ) document.formv1.dk03.value = '31.12.' + krx;
  }
  function Dp04Onfocus(e)
  {
   var krx = document.formv1.kr04.value;
   if ( document.formv1.dp04.value == '00.00.0000' ) document.formv1.dp04.value = '01.01.' + krx;
   if ( document.formv1.dk04.value == '00.00.0000' ) document.formv1.dk04.value = '31.12.' + krx;
  }
  function Dp05Onfocus(e)
  {
   var krx = document.formv1.kr05.value;
   if ( document.formv1.dp05.value == '00.00.0000' ) document.formv1.dp05.value = '01.01.' + krx;
   if ( document.formv1.dk05.value == '00.00.0000' ) document.formv1.dk05.value = '31.12.' + krx;
  }
  function Dp06Onfocus(e)
  {
   var krx = document.formv1.kr06.value;
   if ( document.formv1.dp06.value == '00.00.0000' ) document.formv1.dp06.value = '01.01.' + krx;
   if ( document.formv1.dk06.value == '00.00.0000' ) document.formv1.dk06.value = '31.12.' + krx;
  }
  function Dp07Onfocus(e)
  {
   var krx = document.formv1.kr07.value;
   if ( document.formv1.dp07.value == '00.00.0000' ) document.formv1.dp07.value = '01.01.' + krx;
   if ( document.formv1.dk07.value == '00.00.0000' ) document.formv1.dk07.value = '31.12.' + krx;
  }
  function Dp08Onfocus(e)
  {
   var krx = document.formv1.kr08.value;
   if ( document.formv1.dp08.value == '00.00.0000' ) document.formv1.dp08.value = '01.01.' + krx;
   if ( document.formv1.dk08.value == '00.00.0000' ) document.formv1.dk08.value = '31.12.' + krx;
  }

<?php
//uprava
  if ( $copern == 20 )
  { 
?>
  function ObnovUI()
  {
   document.formv1.datum.value = '<?php echo "$datum";?>';

   document.formv1.kr01.value = '<?php echo "$kr01";?>';
   document.formv1.kr02.value = '<?php echo "$kr02";?>';
   document.formv1.kr03.value = '<?php echo "$kr03";?>';
   document.formv1.kr04.value = '<?php echo "$kr04";?>';
   document.formv1.kr05.value = '<?php echo "$kr05";?>';
   document.formv1.kr06.value = '<?php echo "$kr06";?>';
   document.formv1.kr07.value = '<?php echo "$kr07";?>';
   document.formv1.kr08.value = '<?php echo "$kr08";?>';
   document.formv1.kr09.value = '<?php echo "$kr09";?>';
   document.formv1.kr10.value = '<?php echo "$kr10";?>';
   document.formv1.kr11.value = '<?php echo "$kr11";?>';
   document.formv1.kr12.value = '<?php echo "$kr12";?>';
   document.formv1.kr13.value = '<?php echo "$kr13";?>';

   document.formv1.zp01.value = '<?php echo "$zp01";?>';
   document.formv1.zp02.value = '<?php echo "$zp02";?>';
   document.formv1.zp03.value = '<?php echo "$zp03";?>';
   document.formv1.zp04.value = '<?php echo "$zp04";?>';
   document.formv1.zp05.value = '<?php echo "$zp05";?>';
   document.formv1.zp06.value = '<?php echo "$zp06";?>';
   document.formv1.zp07.value = '<?php echo "$zp07";?>';
   document.formv1.zp08.value = '<?php echo "$zp08";?>';
   document.formv1.zp09.value = '<?php echo "$zp09";?>';
   document.formv1.zp10.value = '<?php echo "$zp10";?>';
   document.formv1.zp11.value = '<?php echo "$zp11";?>';
   document.formv1.zp12.value = '<?php echo "$zp12";?>';
   document.formv1.zp13.value = '<?php echo "$zp13";?>';

   document.formv1.dp01.value = '<?php echo "$dp01";?>';
   document.formv1.dp02.value = '<?php echo "$dp02";?>';
   document.formv1.dp03.value = '<?php echo "$dp03";?>';
   document.formv1.dp04.value = '<?php echo "$dp04";?>';
   document.formv1.dp05.value = '<?php echo "$dp05";?>';
   document.formv1.dp06.value = '<?php echo "$dp06";?>';
   document.formv1.dp07.value = '<?php echo "$dp07";?>';
   document.formv1.dp08.value = '<?php echo "$dp08";?>';
   document.formv1.dp09.value = '<?php echo "$dp09";?>';
   document.formv1.dp10.value = '<?php echo "$dp10";?>';
   document.formv1.dp11.value = '<?php echo "$dp11";?>';
   document.formv1.dp12.value = '<?php echo "$dp12";?>';
   document.formv1.dp13.value = '<?php echo "$dp13";?>';

   document.formv1.dk01.value = '<?php echo "$dk01";?>';
   document.formv1.dk02.value = '<?php echo "$dk02";?>';
   document.formv1.dk03.value = '<?php echo "$dk03";?>';
   document.formv1.dk04.value = '<?php echo "$dk04";?>';
   document.formv1.dk05.value = '<?php echo "$dk05";?>';
   document.formv1.dk06.value = '<?php echo "$dk06";?>';
   document.formv1.dk07.value = '<?php echo "$dk07";?>';
   document.formv1.dk08.value = '<?php echo "$dk08";?>';
   document.formv1.dk09.value = '<?php echo "$dk09";?>';
   document.formv1.dk10.value = '<?php echo "$dk10";?>';
   document.formv1.dk11.value = '<?php echo "$dk11";?>';
   document.formv1.dk12.value = '<?php echo "$dk12";?>';
   document.formv1.dk13.value = '<?php echo "$dk13";?>';

   document.formv1.vz01.value = '<?php echo "$vz01";?>';
   document.formv1.vz02.value = '<?php echo "$vz02";?>';
   document.formv1.vz03.value = '<?php echo "$vz03";?>';
   document.formv1.vz04.value = '<?php echo "$vz04";?>';
   document.formv1.vz05.value = '<?php echo "$vz05";?>';
   document.formv1.vz06.value = '<?php echo "$vz06";?>';
   document.formv1.vz07.value = '<?php echo "$vz07";?>';
   document.formv1.vz08.value = '<?php echo "$vz08";?>';
   document.formv1.vz09.value = '<?php echo "$vz09";?>';
   document.formv1.vz10.value = '<?php echo "$vz10";?>';
   document.formv1.vz11.value = '<?php echo "$vz11";?>';
   document.formv1.vz12.value = '<?php echo "$vz12";?>';
   document.formv1.vz13.value = '<?php echo "$vz13";?>';

   document.formv1.vv01.value = '<?php echo "$vv01";?>';
   document.formv1.vv02.value = '<?php echo "$vv02";?>';
   document.formv1.vv03.value = '<?php echo "$vv03";?>';
   document.formv1.vv04.value = '<?php echo "$vv04";?>';
   document.formv1.vv05.value = '<?php echo "$vv05";?>';
   document.formv1.vv06.value = '<?php echo "$vv06";?>';
   document.formv1.vv07.value = '<?php echo "$vv07";?>';
   document.formv1.vv08.value = '<?php echo "$vv08";?>';
   document.formv1.vv09.value = '<?php echo "$vv09";?>';
   document.formv1.vv10.value = '<?php echo "$vv10";?>';
   document.formv1.vv11.value = '<?php echo "$vv11";?>';
   document.formv1.vv12.value = '<?php echo "$vv12";?>';
   document.formv1.vv13.value = '<?php echo "$vv13";?>';

   document.formv1.kd01.value = '<?php echo "$kd01";?>';
   document.formv1.kd02.value = '<?php echo "$kd02";?>';
   document.formv1.kd03.value = '<?php echo "$kd03";?>';
   document.formv1.kd04.value = '<?php echo "$kd04";?>';
   document.formv1.kd05.value = '<?php echo "$kd05";?>';
   document.formv1.kd06.value = '<?php echo "$kd06";?>';
   document.formv1.kd07.value = '<?php echo "$kd07";?>';
   document.formv1.kd08.value = '<?php echo "$kd08";?>';
   document.formv1.kd09.value = '<?php echo "$kd09";?>';
   document.formv1.kd10.value = '<?php echo "$kd10";?>';
   document.formv1.kd11.value = '<?php echo "$kd11";?>';
   document.formv1.kd12.value = '<?php echo "$kd12";?>';
   document.formv1.kd13.value = '<?php echo "$kd13";?>';

<?php if ( $oprav == 1 ) { ?> document.formv1.oprav.checked = "checked"; <?php } ?>
<?php if ( $str2 == 1 ) { ?> document.formv1.str2.checked = "checked"; <?php } ?>
   document.formv1.predo.value = '<?php echo "$predo";?>';
   document.formv1.pozn.value = '<?php echo "$pozn";?>';

   document.forms.formv1.kr01.focus();
   document.forms.formv1.kr01.select();
  }
<?php
//koniec uprava
  }
?>

<?php if ( $copern != 20 ) { ?>
  function ObnovUI()
  {
  }
<?php                      } ?>

//Z ciarky na bodku
  function CiarkaNaBodku(Vstup)
  {
   if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
  }

  function prevOC(prevoc)
  {
   window.open('evidencny_list.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=' + prevoc + '', '_self');
  }
  function nextOC(nextoc)
  {
   window.open('evidencny_list.php?copern=20&drupoh=1&page=1&subor=0&cislo_oc=' + nextoc + '', '_self');
  }

  function ZnovuPotvrdenie()
  {
   window.open('../mzdy/evidencny_list.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=26&drupoh=1&page=1&subor=0&fmzdy=<?php echo $kli_vxcf; ?>',
 '_self', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }
  function NavodVyplnenie()
  {
   window.open('../dokumenty/mzdy_potvrdenia/evidencny_list/evidencny_list_navod.pdf',
 '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function tlacpdf(oc)
  {
   window.open('evidencny_list.php?copern=10&drupoh=1&page=1&subor=0&cislo_oc=' + oc + '&xx=1',
 '_blank', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes');
  }
  function XMLEvidencny()
  {
   window.open('../mzdy/evidencny_listxml.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=10&drupoh=1&page=1&subor=0&fmzdy=83',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
                }
</script>
<?php
$rokm1=$kli_vrok-1;
$rokm2=$kli_vrok-2;
$rokm3=$kli_vrok-3;
$rokm4=$kli_vrok-4;
$rokm5=$kli_vrok-5;
$rokm6=$kli_vrok-6;
$rokm7=$kli_vrok-7;

$firm1=0; $firm2=0; $firm3=0; $firm4=0; $firm5=0; $firm6=0; $firm7=0;

$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm1=$fir_allx11; }

$databaza="";
if ( $kli_vrok == 2011 ) { if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; } }
if ( $kli_vrok == 2012 ) { if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; } }
if ( $kli_vrok == 2013 ) { if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; } }
if ( $kli_vrok == 2014 ) { if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; } }
if ( $kli_vrok == 2015 ) { if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; } }
if ( $kli_vrok == 2016 ) { if ( File_Exists("../pswd/oddelena2015db2016.php") ) { $databaza=$mysqldb2015."."; } }

if ( $firm1 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm1"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm2=$fir_allx11; }
}


if ( $kli_vrok == 2012 ) { if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; } }
if ( $kli_vrok == 2013 ) { if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; } }
if ( $kli_vrok == 2014 ) { if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; } }
if ( $kli_vrok == 2015 ) { if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; } }
if ( $kli_vrok == 2016 ) { if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; } }

if ( $firm2 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm2"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm3=$fir_allx11; }
}

if ( $kli_vrok == 2013 ) { if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; } }
if ( $kli_vrok == 2014 ) { if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; } }
if ( $kli_vrok == 2015 ) { if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; } }
if ( $kli_vrok == 2016 ) { if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; } }

if ( $firm3 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm3"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm4=$fir_allx11; }
}


if ( $kli_vrok == 2014 ) { if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; } }
if ( $kli_vrok == 2015 ) { if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; } }
if ( $kli_vrok == 2016 ) { if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; } }

if ( $firm4 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm4"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm5=$fir_allx11; }
}

if ( $kli_vrok == 2015 ) { if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; } }
if ( $kli_vrok == 2016 ) { if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; } }

if ( $firm5 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm5"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm6=$fir_allx11; }
}

if ( $kli_vrok == 2016 ) { if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; } }

if ( $firm6 > 0 )
{
$sqlfir = "SELECT * FROM ".$databaza."F$firm6"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $firm7=$fir_allx11; }
}

//osobne cislo prepinanie
$novy=0;
if ( $novy == 0 )
{
$prev_oc=$cislo_oc-1;
$next_oc=$cislo_oc+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
$nasieloc=0;
$i=0;
while ( $i <= 9999 AND $nasieloc == 0 )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$prev_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $prev_oc=$prev_oc-1;
if ( $prev_oc <= 1 ) $nasieloc=1;
}
$i=$i+1;

$maxoc=9999;
$sqldok = mysql_query("SELECT * FROM F$kli_vxcf"."_mzdkun ORDER BY oc DESC LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $maxoc=1*$riaddok->oc;
  }
if ( $next_oc > $maxoc ) $next_oc=$maxoc;

$nasieloc=0;
$i=0;
while ($i <= 9999 AND $nasieloc == 0 AND $next_oc <= $maxoc )
{
$sqlico = mysql_query("SELECT oc FROM F$kli_vxcf"."_mzdkun WHERE oc=$next_oc ");
  if (@$zaznam=mysql_data_seek($sqlico,$i))
  {
  $riadico=mysql_fetch_object($sqlico);
  $nasieloc=1;
  }
if ( $nasieloc == 0 ) $next_oc=$next_oc+1;
if ( $next_oc >= 9999 ) $nasieloc=1;
}
$i=$i+1;
if ( $prev_oc == 0 ) $prev_oc=1;
if ( $next_oc > 9999 ) $next_oc=9999;
}
?>
</HEAD>
<BODY id="white" onload="ObnovUI();">
<?php
//uprav udaje
if ( $copern == 20 )
    {
?>
<div id="wrap-heading">
 <table id="heading">
  <tr>
   <td class="ilogin">EuroSecom</td>
   <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
  </tr>
  <tr>
   <td class="header">EvidenËn˝ list dÙchodkov. poist. - <span class="subheader"><?php echo "$oc $meno $prie";?></span>
<?php if ( $novy == 0 ) { ?>
    <img src='../obr/prev.png' onclick="prevOC(<?php echo $prev_oc; ?>);" title="Os.Ë. <?php echo $prev_oc; ?>" class="navoc-icon">
    <img src='../obr/next.png' onclick="nextOC(<?php echo $next_oc; ?>);" title="Os.Ë. <?php echo $next_oc; ?>" class="navoc-icon">
<?php                   } ?>
   </td>
   <td>
    <div class="bar-btn-form-tool">
<img src="../obr/ikony/xmark_lred_icon.png" title="Vymazaù hodnoty evidenËnÈho listu"
 onclick="window.open('evidencny_list.php?copern=6155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>', '_self')"
 class="btn-form-tool">

<p class="toright nacitaj-bar">
 <span>NaËÌtaù</span>
 <a href="#" onclick="ZnovuPotvrdenie();" title="NaËÌtaù hodnoty roku <?php echo $kli_vrok; ?>"><?php echo $kli_vrok; ?></a>


<?php if ( $firm1 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=1&fir=<?php echo $firm1; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm1; ?> a firmy Ë. <?php echo $firm1; ?> - len rok <?php echo $rokm1; ?>'>
  <?php echo "$rokm1,$firm1"; ?>
 </a>
<?php                   } ?>

<?php if ( $copern == 20 )
{
//toto musime doriesit
?>
<?php if ( $firm2 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=2&fir=<?php echo $firm2; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm2; ?> a firmy Ë. <?php echo $firm2; ?> - len rok <?php echo $rokm2; ?>'>
  <?php echo "$rokm2,$firm2"; ?>
 </a>
<?php                   } ?>
<?php if ( $firm3 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=3&fir=<?php echo $firm3; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm3; ?> a firmy Ë. <?php echo $firm3; ?> - len rok <?php echo $rokm3; ?>'>
  <?php echo "$rokm3,$firm3"; ?>
 </a>
<?php                   } ?>
<?php if ( $firm4 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=4&fir=<?php echo $firm4; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm4; ?> a firmy Ë. <?php echo $firm4; ?> - len rok <?php echo $rokm4; ?>'>
  <?php echo "$rokm4,$firm4"; ?>
 </a>
<?php                   } ?>
<?php if ( $firm5 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=5&fir=<?php echo $firm5; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm5; ?> a firmy Ë. <?php echo $firm5; ?> - len rok <?php echo $rokm5; ?>'>
  <?php echo "$rokm5,$firm5"; ?>
 </a>
<?php                   } ?>
<?php if ( $firm6 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=6&fir=<?php echo $firm6; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm6; ?> a firmy Ë. <?php echo $firm6; ?> - len rok <?php echo $rokm6; ?>'>
  <?php echo "$rokm6,$firm6"; ?>
 </a>
<?php                   } ?>

<?php if ( $firm7 > 0 ) { ?>
 <a href="#" onclick="window.open('evidencny_list.php?copern=4155&drupoh=1&page=1&cislo_oc=<?php echo $cislo_oc; ?>&rok=7&fir=<?php echo $firm7; ?>', '_self')"
  title='NaËÌtaù hodnoty evidenËnÈho listu z <?php echo $rokm7; ?> a firmy Ë. <?php echo $firm7; ?> - len rok <?php echo $rokm7; ?>'>
  <?php echo "$rokm7,$firm7"; ?>
 </a>
<?php                   } ?>

<?php
}
?>
</p>
     <img src="../obr/ikony/info_blue_icon.png" onclick="NavodVyplnenie();"
          title="PouËenie na vyplnenie" class="btn-form-tool">
     <img src="../obr/ikony/upbox_blue_icon.png" onclick="XMLEvidencny();"
          title="Export do XML" class="btn-form-tool">
     <img src="../obr/ikony/printer_blue_icon.png" onclick="tlacpdf(<?php echo $cislo_oc; ?>);"
          title="Zobraziù v PDF" class="btn-form-tool">
    </div>
   </td>
  </tr>
 </table>
</div>

<div id="content">
<FORM name="formv1" method="post" action="evidencny_list.php?copern=23&cislo_oc=<?php echo $cislo_oc;?>">
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-top-formsave" style="top:4px;">
<img src="../dokumenty/mzdy_potvrdenia/evidencny_list/evidencny_list.jpg"
     alt="tlaËivo EvidenËn˝ list dÙchodkovÈho poistenia 231kB" class="form-background">

<!-- vyplneny -->
<input type="checkbox" name="str2" value="1" style="top:143px; left:260px;"/>
<input type="checkbox" name="oprav" value="1" style="top:143px; left:339px;"/>

<!-- I. POISTENEC -->
<span class="text-echo" style="top:203px; left:40px;"><?php echo $prie; ?></span>
<span class="text-echo" style="top:203px; left:478px;"><?php echo $meno; ?></span>
<span class="text-echo" style="top:203px; left:778px;"><?php echo $titl; ?></span>
<span class="text-echo" style="top:241px; left:40px;"><?php echo $rodprie; ?></span>
<input type="text" name="predo" id="predo" style="top:235px; left:473px; width:420px;"/>
<span class="text-echo" style="top:277px; left:40px;"><?php echo $mnr; ?></span>
<span class="text-echo" style="top:277px; left:634px;"><?php echo $dar_sk; ?></span>
<span class="text-echo" style="top:277px; left:775px;"><?php echo $rodne; ?></span>
<span class="text-echo" style="top:333px; left:40px;"><?php echo $ulica; ?></span>
<span class="text-echo" style="top:333px; left:634px;"><?php echo $dom; ?></span>
<span class="text-echo" style="top:370px; left:40px;"><?php echo $obec; ?></span>
<span class="text-echo" style="top:370px; left:634px;"><?php echo $psc; ?></span>
<span class="text-echo" style="top:407px; left:513px;"><?php echo $dan_sk; ?></span>
<span class="text-echo" style="top:407px; left:652px;"><?php echo $dav_sk; ?></span>

<!-- II. Obdobia poistenia ... -->
<img src="../obr/ikony/info_blue_icon.png" class="btn-row-tool" style="top:465px; left:127px;"
     title="A = zamestnanec, MD = matersk· dovolenka, RD = rodiËovsk· dovolenka, VS = vojensk· sluûba, CS = civiln· sluûba">
<!-- 1.riadok -->
<input type="text" name="kr01" id="kr01" style="top:494px; left:35px; width:70px;"/>
<select size="1" name="zp01" id="zp01" style="top:494px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp01" id="dp01" onfocus="return Dp01Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:494px; left:218px; width:93px;"/>
<input type="text" name="dk01" id="dk01" onkeyup="CiarkaNaBodku(this);"
       style="top:494px; left:328px; width:93px;"/>
<input type="text" name="vz01" id="vz01" onkeyup="CiarkaNaBodku(this);"
       style="top:494px; left:450px; width:93px;"/>
<input type="text" name="vv01" id="vv01" onkeyup="CiarkaNaBodku(this);"
       style="top:494px; left:562px; width:93px;"/>
<input type="text" name="kd01" id="kd01" style="top:494px; left:675px; width:72px;"/>
<!-- 2.riadok -->
<input type="text" name="kr02" id="kr02" style="top:531px; left:35px; width:70px;"/>
<select size="1" name="zp02" id="zp02" style="top:531px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp02" id="dp02" onfocus="return Dp02Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:531px; left:218px; width:93px;"/>
<input type="text" name="dk02" id="dk02" onkeyup="CiarkaNaBodku(this);"
       style="top:531px; left:328px; width:93px;"/>
<input type="text" name="vz02" id="vz02" onkeyup="CiarkaNaBodku(this);"
       style="top:531px; left:450px; width:93px;"/>
<input type="text" name="vv02" id="vv02" onkeyup="CiarkaNaBodku(this);"
       style="top:531px; left:562px; width:93px;"/>
<input type="text" name="kd02" id="kd02" style="top:531px; left:675px; width:72px;"/>
<!-- 3.riadok -->
<input type="text" name="kr03" id="kr03" style="top:568px; left:35px; width:70px;"/>
<select size="1" name="zp03" id="zp03" style="top:568px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp03" id="dp03" onfocus="return Dp03Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:568px; left:218px; width:93px;"/>
<input type="text" name="dk03" id="dk03" onkeyup="CiarkaNaBodku(this);"
       style="top:568px; left:328px; width:93px;"/>
<input type="text" name="vz03" id="vz03" onkeyup="CiarkaNaBodku(this);"
       style="top:568px; left:450px; width:93px;"/>
<input type="text" name="vv03" id="vv03" onkeyup="CiarkaNaBodku(this);"
       style="top:568px; left:562px; width:93px;"/>
<input type="text" name="kd03" id="kd03" style="top:568px; left:675px; width:72px;"/>
<!-- 4.riadok -->
<input type="text" name="kr04" id="kr04" style="top:605px; left:35px; width:70px;"/>
<select size="1" name="zp04" id="zp04" style="top:605px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp04" id="dp04" onfocus="return Dp04Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:605px; left:218px; width:93px;"/>
<input type="text" name="dk04" id="dk04" onkeyup="CiarkaNaBodku(this);"
       style="top:605px; left:328px; width:93px;"/>
<input type="text" name="vz04" id="vz04" onkeyup="CiarkaNaBodku(this);"
       style="top:605px; left:450px; width:93px;"/>
<input type="text" name="vv04" id="vv04" onkeyup="CiarkaNaBodku(this);"
       style="top:605px; left:562px; width:93px;"/>
<input type="text" name="kd04" id="kd04" style="top:605px; left:675px; width:72px;"/>
<!-- 5.riadok -->
<input type="text" name="kr05" id="kr05" style="top:642px; left:35px; width:70px;"/>
<select size="1" name="zp05" id="zp05" style="top:642px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp05" id="dp05" onfocus="return Dp05Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:642px; left:218px; width:93px;"/>
<input type="text" name="dk05" id="dk05" onkeyup="CiarkaNaBodku(this);"
       style="top:642px; left:328px; width:93px;"/>
<input type="text" name="vz05" id="vz05" onkeyup="CiarkaNaBodku(this);"
       style="top:642px; left:450px; width:93px;"/>
<input type="text" name="vv05" id="vv05" onkeyup="CiarkaNaBodku(this);"
       style="top:642px; left:562px; width:93px;"/>
<input type="text" name="kd05" id="kd05" style="top:642px; left:675px; width:72px;"/>
<!-- 6.riadok -->
<input type="text" name="kr06" id="kr06" style="top:680px; left:35px; width:70px;"/>
<select size="1" name="zp06" id="zp06" style="top:680px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp06" id="dp06" onfocus="return Dp06Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:680px; left:218px; width:93px;"/>
<input type="text" name="dk06" id="dk06" onkeyup="CiarkaNaBodku(this);"
       style="top:680px; left:328px; width:93px;"/>
<input type="text" name="vz06" id="vz06" onkeyup="CiarkaNaBodku(this);"
       style="top:680px; left:450px; width:93px;"/>
<input type="text" name="vv06" id="vv06" onkeyup="CiarkaNaBodku(this);"
       style="top:680px; left:562px; width:93px;"/>
<input type="text" name="kd06" id="kd06" style="top:680px; left:675px; width:72px;"/>
<!-- 7.riadok -->
<input type="text" name="kr07" id="kr07" style="top:717px; left:35px; width:70px;"/>
<select size="1" name="zp07" id="zp07" style="top:717px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp07" id="dp07" onfocus="return Dp07Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:717px; left:218px; width:93px;"/>
<input type="text" name="dk07" id="dk07" onkeyup="CiarkaNaBodku(this);"
       style="top:717px; left:328px; width:93px;"/>
<input type="text" name="vz07" id="vz07" onkeyup="CiarkaNaBodku(this);"
       style="top:717px; left:450px; width:93px;"/>
<input type="text" name="vv07" id="vv07" onkeyup="CiarkaNaBodku(this);"
       style="top:717px; left:562px; width:93px;"/>
<input type="text" name="kd07" id="kd07" style="top:717px; left:675px; width:72px;"/>
<!-- 8.riadok -->
<input type="text" name="kr08" id="kr08" style="top:753px; left:35px; width:70px;"/>
<select size="1" name="zp08" id="zp08" style="top:753px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp08" id="dp08" onfocus="return Dp08Onfocus(event.which)"
       onkeyup="CiarkaNaBodku(this);" style="top:753px; left:218px; width:93px;"/>
<input type="text" name="dk08" id="dk08" onkeyup="CiarkaNaBodku(this);"
       style="top:753px; left:328px; width:93px;"/>
<input type="text" name="vz08" id="vz08" onkeyup="CiarkaNaBodku(this);"
       style="top:753px; left:450px; width:93px;"/>
<input type="text" name="vv08" id="vv08" onkeyup="CiarkaNaBodku(this);"
       style="top:753px; left:562px; width:93px;"/>
<input type="text" name="kd08" id="kd08" style="top:753px; left:675px; width:72px;"/>
<!-- 9.riadok -->
<input type="text" name="kr09" id="kr09" style="top:790px; left:35px; width:70px;"/>
<select size="1" name="zp09" id="zp09" style="top:790px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp09" id="dp09" onkeyup="CiarkaNaBodku(this);"
       style="top:790px; left:218px; width:93px;"/>
<input type="text" name="dk09" id="dk09" onkeyup="CiarkaNaBodku(this);"
       style="top:790px; left:328px; width:93px;"/>
<input type="text" name="vz09" id="vz09" onkeyup="CiarkaNaBodku(this);"
       style="top:790px; left:450px; width:93px;"/>
<input type="text" name="vv09" id="vv09" onkeyup="CiarkaNaBodku(this);"
       style="top:790px; left:562px; width:93px;"/>
<input type="text" name="kd09" id="kd09" style="top:790px; left:675px; width:72px;"/>
<!-- 10.riadok -->
<input type="text" name="kr10" id="kr10" style="top:827px; left:35px; width:70px;"/>
<select size="1" name="zp10" id="zp10" style="top:827px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp10" id="dp10" onkeyup="CiarkaNaBodku(this);"
       style="top:827px; left:218px; width:93px;"/>
<input type="text" name="dk10" id="dk10" onkeyup="CiarkaNaBodku(this);"
       style="top:827px; left:328px; width:93px;"/>
<input type="text" name="vz10" id="vz10" onkeyup="CiarkaNaBodku(this);"
       style="top:827px; left:450px; width:93px;"/>
<input type="text" name="vv10" id="vv10" onkeyup="CiarkaNaBodku(this);"
       style="top:827px; left:562px; width:93px;"/>
<input type="text" name="kd10" id="kd10" style="top:827px; left:675px; width:72px;"/>
<!-- 11.riadok -->
<input type="text" name="kr11" id="kr11" style="top:865px; left:35px; width:70px;"/>
<select size="1" name="zp11" id="zp11" style="top:865px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp11" id="dp11" onkeyup="CiarkaNaBodku(this);"
       style="top:865px; left:218px; width:93px;"/>
<input type="text" name="dk11" id="dk11" onkeyup="CiarkaNaBodku(this);"
       style="top:865px; left:328px; width:93px;"/>
<input type="text" name="vz11" id="vz11" onkeyup="CiarkaNaBodku(this);"
       style="top:865px; left:450px; width:93px;"/>
<input type="text" name="vv11" id="vv11" onkeyup="CiarkaNaBodku(this);"
       style="top:865px; left:562px; width:93px;"/>
<input type="text" name="kd11" id="kd11" style="top:865px; left:675px; width:72px;"/>
<!-- 12.riadok -->
<input type="text" name="kr12" id="kr12" style="top:902px; left:35px; width:70px;"/>
<select size="1" name="zp12" id="zp12" style="top:902px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp12" id="dp12" onkeyup="CiarkaNaBodku(this);"
       style="top:902px; left:218px; width:93px;"/>
<input type="text" name="dk12" id="dk12" onkeyup="CiarkaNaBodku(this);"
       style="top:902px; left:328px; width:93px;"/>
<input type="text" name="vz12" id="vz12" onkeyup="CiarkaNaBodku(this);"
       style="top:902px; left:450px; width:93px;"/>
<input type="text" name="vv12" id="vv12" onkeyup="CiarkaNaBodku(this);"
       style="top:902px; left:562px; width:93px;"/>
<input type="text" name="kd12" id="kd12" style="top:902px; left:675px; width:72px;"/>
<!-- 13.riadok -->
<input type="text" name="kr13" id="kr13" style="top:939px; left:35px; width:70px;"/>
<select size="1" name="zp13" id="zp13" style="top:939px; left:136px; width:70px;">
 <option value="A">A = zamestnanec</option>
 <option value="MD">MD = matersk· dovolenka</option>
 <option value="RD">RD = rodiËovsk· dovolenka</option>
 <option value="VS">VS = vojensk· sluûba</option>
 <option value="CS">CS = civiln· sluûba</option>
 <option value=" "></option>
</select>
<input type="text" name="dp13" id="dp13" onkeyup="CiarkaNaBodku(this);"
       style="top:939px; left:218px; width:93px;"/>
<input type="text" name="dk13" id="dk13" onkeyup="CiarkaNaBodku(this);"
       style="top:939px; left:328px; width:93px;"/>
<input type="text" name="vz13" id="vz13" onkeyup="CiarkaNaBodku(this);"
       style="top:939px; left:450px; width:93px;"/>
<input type="text" name="vv13" id="vv13" onkeyup="CiarkaNaBodku(this);"
       style="top:939px; left:562px; width:93px;"/>
<input type="text" name="kd13" id="kd13" style="top:939px; left:675px; width:72px;"/>

<!-- III. ZAMESTNAVATEL -->
<span class="text-echo" style="top:1018px; left:40px;"><?php echo $fir_fnaz; ?></span>
<span class="text-echo" style="top:1053px; left:666px;">x</span>
<span class="text-echo" style="top:1055px; left:756px;"><?php echo $fir_fico; ?></span>
<span class="text-echo" style="top:1092px; left:40px;"><?php echo $fir_fuli; ?></span>
<span class="text-echo" style="top:1092px; left:635px;"><?php echo $fir_fcdm; ?></span>
<span class="text-echo" style="top:1129px; left:40px;"><?php echo $fir_fmes; ?></span>
<span class="text-echo" style="top:1129px; left:635px;"><?php echo $fir_fpsc; ?></span>

<!-- IV. POTVRDENIE SPRAVNOSTI -->
<input type="text" name="datum" id="datum" onkeyup="CiarkaNaBodku(this);"
       style="top:1179px; left:35px; width:122px;"/>

<!-- poznamka -->
<label for="pozn" style="position:absolute; top:1280px; left:165px; font-size:12px; font-weight:bold;">Pozn·mka</label>
<input type="text" name="pozn" id="pozn" style="top:1274px; right:12px; width:700px;"/>
 <INPUT type="submit" id="uloz" name="uloz" value="Uloûiù zmeny" class="btn-bottom-formsave">
</FORM>
</div> <!-- koniec #content -->
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav
?>


<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvypl'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcvyplz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
$cislista = include("mzd_lista_norm.php");
} while (false);
?>
</BODY>
</HTML>