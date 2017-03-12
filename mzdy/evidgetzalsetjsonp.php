<?php
/**
 * Created by PhpStorm.
 * User: eurosecom
 * Date: 23. 2. 2017
 * Time: 11:21
 *
 * Call www.eszalohy.sk parametre fir2014 to je číslo firmy pre rok 2014, zaloha je názov domény, z ktorej voláme zálohu (eurosecom, enposro...)
 * JSON Response čísla firiem pre roky 2014 až 2009 fir2014 až fir 2009
 */


$fir2014 = 1*$_REQUEST['f2014'];
$zaloha = $_REQUEST['zaloha'];

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
//3240 HOLOŠKA 2014, 3239 HOLOŠKA 2013, 239 HOLOŠKA 2012, 139 HOLOŠKA 2011, 39 HOLOŠKA 2010, 701 HOLOŠKA 2009 osc 12 Jana Holoskova je vo vsetkych firmach


$fir2013=0; $fir2012=0; $fir2011=0; $fir2010=0; $fir2009=0; 

$databaza=$mysqldb2014.".";
$kli_vxcf=$fir2014;

$sqlfir = "SELECT * FROM ".$databaza."F".$kli_vxcf."_ufir WHERE udaje = 1";
//echo $sqlfir."<br />";
$fir_vysledok = mysqli_query($mysqli, $sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysqli_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $fir2013=$fir_allx11; }


$databaza=$mysqldb2013.".";
$kli_vxcf=$fir2013;

if ( $fir2013 > 0 )
{
$fir_riadok->allx11=0;

$sqlfir = "SELECT * FROM ".$databaza."F$kli_vxcf"."_ufir WHERE udaje = 1";
//echo $sqlfir."<br />";
$fir_vysledok = mysqli_query($mysqli, $sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysqli_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $fir2012=$fir_allx11; }
}


$databaza=$mysqldb2012.".";
$kli_vxcf=$fir2012;


if ( $fir2012 > 0 )
{
$fir_riadok->allx11=0;

$sqlfir = "SELECT * FROM ".$databaza."F$kli_vxcf"."_ufir WHERE udaje = 1";
//echo $sqlfir."<br />";
$fir_vysledok = mysqli_query($mysqli, $sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysqli_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $fir2011=$fir_allx11; }
}

$databaza=$mysqldb2011.".";
$kli_vxcf=$fir2011;


if ( $fir2011 > 0 )
{
$fir_riadok->allx11=0;

$sqlfir = "SELECT * FROM ".$databaza."F$kli_vxcf"."_ufir WHERE udaje = 1";
//echo $sqlfir."<br />";
$fir_vysledok = mysqli_query($mysqli, $sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysqli_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $fir2010=$fir_allx11; }
}

$databaza=$mysqldb2010.".";
$kli_vxcf=$fir2010;


if ( $fir2010 > 0 )
{
$fir_riadok->allx11=0;

$sqlfir = "SELECT * FROM ".$databaza."F$kli_vxcf"."_ufir WHERE udaje = 1";
//echo $sqlfir."<br />";
$fir_vysledok = mysqli_query($mysqli, $sqlfir);
if ( $fir_vysledok ) { $fir_riadok=mysqli_fetch_object($fir_vysledok); }

$fir_allx11 = 1*$fir_riadok->allx11;
if ( $fir_allx11 > 0 ) { $fir2009=$fir_allx11; }
}


header('Content-Type: text/json; Accept-Charset: utf-8; ');

// array for JSON response
$response = array();


    $response["firmy"] = array();

        $firma = array();
        $firma["fir2014"] = $fir2014;
        $firma["fir2013"] = $fir2013;
        $firma["fir2012"] = $fir2012;
        $firma["fir2011"] = $fir2011;
        $firma["fir2010"] = $fir2010;
        $firma["fir2009"] = $fir2009;
        array_push($response["firmy"], $firma);

    $mysqli->close();
    // echoing JSON response
    echo "jsonCallback(".json_encode($response).");";


exit;

?>