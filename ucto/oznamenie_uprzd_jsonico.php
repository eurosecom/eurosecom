<?php
$sys = 'UCT';
$urov = 1;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

header('Content-Type: text/json; Accept-Charset: utf-8; ');

require_once("../pswd/password.php");
//include_once ("config.php");
$mysqli = new mysqli($mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb);
if ($mysqli->connect_errno) {
    echo "Spojenie so serverom nedostupne.";
    exit();
}


require_once("../cis/dtb_charset.php");
//Ȍ���蝞���


$prm1 = $_GET['prm1'];
$prm2 = $_GET['prm2'];


$cprm1 = 1*$prm1;

if( $prm1 == "" )
{ 
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ico > 0 ORDER BY nai";
}

if( $prm1 != "" ) 
{ 
$sqltt = "SELECT * FROM F$kli_vxcf"."_ico WHERE ( dic LIKE '%$prm1%' OR nai LIKE '%$prm1%' ) ORDER BY nai";
}

$result = mysqli_query($mysqli, "$sqltt");

$response["firmy"] = array();

while ($row = $result->fetch_array()) {
    // temp user array
    $firma = array();
    $firma["ico"] = $row["ico"];
    $firma["dic"] = $row["dic"];

    $naix = $row["nai"];
    $ulix = $row["uli"];
    $mesx = $row["mes"];


if( $dtbcharset == 1 ) {
    $naix = iconv("UTF-8", "CP1250", $naix);
    $ulix = iconv("UTF-8", "CP1250", $ulix);
    $mesx = iconv("UTF-8", "CP1250", $mesx);
                 }
if( $dtbcharset == 2 ) {
    $naix = iconv("CP1250", "UTF-8", $naix);
    $ulix = iconv("CP1250", "UTF-8", $ulix);
    $mesx = iconv("CP1250", "UTF-8", $mesx);
                 }


    $firma["nai"] = $naix;
    $firma["uli"] = $ulix;
    $firma["mes"] = $mesx;
    $firma["psc"] = $row["psc"];

    // push single product into final response array
    array_push($response["firmy"], $firma);
}

$result->close();
$mysqli->close();
// echoing JSON response
echo json_encode($response);



?>
