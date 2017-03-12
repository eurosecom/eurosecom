<?php
/**
 * Created by PhpStorm.
 * User: eurosecom
 * Date: 11. 3. 2017
 * Time: 12:17
 *
 * Call www.eszalohy.sk parametre cislo_oc je číslo zamestnanca, firx je číslo firmy, rokx je účtovný rok, zaloha je názov domény, z ktorej voláme zálohu (eurosecom, enposro...)
 * JSON Response hodnota základu
 */

$fir2014 = 1*$_REQUEST['f2014'];
$zaloha = $_REQUEST['zaloha'];
$alchem = 1*$_REQUEST['alchem'];

$firx = 1*$_REQUEST['firx'];
$rokx = 1*$_REQUEST['rokx'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];

$_SESSION['eszalohy']=$zaloha;
$_SESSION['kli_vhsxy']=13287465;

require_once("../pswd/password.php");
$mysqli = new mysqli($mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb);
if ($mysqli->connect_errno) {
    echo "Spojenie so serverom nedostupne.";
    exit();
}


require_once("../cis/dtb_charset.php");
//ČŚĽľščťžýáí

//$mysqldb2014 az $mysqldb2010
//rok, znak, datpoc, datkon, vzak, vzvyl, dnvyl

if( $rokx == 2014 ) { $databaza=$mysqldb2014."."; }
if( $rokx == 2013 ) { $databaza=$mysqldb2013."."; }
if( $rokx == 2012 ) { $databaza=$mysqldb2012."."; }
if( $rokx == 2011 ) { $databaza=$mysqldb2011."."; }
if( $rokx == 2010 ) { $databaza=$mysqldb2010."."; }
if( $rokx == 2009 ) { $databaza=$mysqldb2010."."; }

$kli_uzid=0;
$kli_vxcf=$firx;

$vzak=0; 
$sqlttt = "SELECT SUM(zzam_sp) AS zzam_dp FROM ".$databaza."F$kli_vxcf"."_mzdzalsum WHERE oc = $cislo_oc ";
//echo $sqlttt." klivrok ".$kli_vrok."<br />";
//exit;
$sqldok = mysqli_query($mysqli, "$sqlttt");
  if (@$zaznam=mysqli_data_seek($sqldok,0))
  {
  $riaddok=mysqli_fetch_object($sqldok);
  $vzak=$vzak+$riaddok->zzam_dp;
  }


$sql = "DROP TABLE F".$kli_vxcf."_mzdkunxx".$kli_uzid." ";
$vysledek = mysqli_query($mysqli, "$sql");

$sql = "CREATE TABLE F".$kli_vxcf."_mzdkunxx".$kli_uzid." SELECT * FROM ".$databaza."F".$kli_vxcf."_mzdkun WHERE oc=$cislo_oc ";
$vysledek = mysqli_query($mysqli, "$sql");

$dat0101=$rokx."-01-01";
$dat3112=$rokx."-12-31";

$uprtxt = "UPDATE F$kli_vxcf"."_mzdkunxx$kli_uzid SET dan='$dat0101' WHERE dan < '$dat0101' ";
$vysledek = mysqli_query($mysqli, "$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_mzdkunxx$kli_uzid SET dav='$dat3112' WHERE dan < '$dat0101' OR dav = '0000-00-00' ";
$vysledek = mysqli_query($mysqli, "$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_mzdkunxx$kli_uzid SET pom=0 ";
$vysledek = mysqli_query($mysqli, "$uprtxt");
$uprtxt = "UPDATE F$kli_vxcf"."_mzdkunxx$kli_uzid SET pom=1 WHERE dar <= '1984-12-31' ";
$vysledek = mysqli_query($mysqli, "$uprtxt");

$ano513=0;

$sqlttt = "SELECT * FROM F$kli_vxcf"."_mzdkunxx$kli_uzid WHERE oc = $cislo_oc ";
$sqldok = mysqli_query($mysqli, "$sqlttt");
  if (@$zaznam=mysqli_data_seek($sqldok,0))
  {
  $riaddok=mysqli_fetch_object($sqldok);
  $datpoc=$riaddok->dan;
  $datkon=$riaddok->dav;
  $ano513=$riaddok->pom;
  }

$sql = "DROP TABLE F".$kli_vxcf."_mzdkunxx".$kli_uzid." ";
$vysledek = mysqli_query($mysqli, "$sql");


$kaldni=0;
$vylkc=0;
$sqlttt = "SELECT SUM(TO_DAYS(dk)-TO_DAYS(dp)+1) AS kaldni FROM ".$databaza."F$kli_vxcf"."_mzdzalvy WHERE oc = $cislo_oc AND ( dm >= 801 AND dm <= 802 )";
if( $alchem == 1 AND $ano513 == 1 )
{
$sqlttt = "SELECT SUM(TO_DAYS(dk)-TO_DAYS(dp)+1) AS kaldni, SUM(kc) AS vylkc FROM ".$databaza."F$kli_vxcf"."_mzdzalvy WHERE oc = $cislo_oc AND ( dm = 801 OR dm = 802 OR dm = 513 )";
}
//echo $sqlttt;
//exit;
$sqldok = mysqli_query($mysqli, "$sqlttt");
  if (@$zaznam=mysqli_data_seek($sqldok,0))
  {
  $riaddok=mysqli_fetch_object($sqldok);
  $kaldni=$riaddok->kaldni;
  $vylkc=$riaddok->vylkc;
  }


header('Content-Type: text/json; Accept-Charset: utf-8; ');

// array for JSON response
$response = array();


    $response["firmy"] = array();

        $firma = array();
        $firma["rok"] = $rokx;
        $firma["znak"] = "A";
        $firma["datpoc"] = $datpoc;
        $firma["datkon"] = $datkon;
        $firma["vzak"] = $vzak;
        $firma["vzvyl"] = $vylkc;
        $firma["dnvyl"] = $kaldni;
        array_push($response["firmy"], $firma);

    $mysqli->close();
    // echoing JSON response
    echo "jsonCallback(".json_encode($response).");";


exit;

?>