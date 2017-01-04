<?php

$mysqldbfir=$mysqldb;
$mysqldbdatax=$mysqldbdata;

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb1new.php");
          }

$mysqldbdata=$mysqldbdatax;

  $dbvttt = "SELECT $mysqldbfir.nas_id.ume,$mysqldbfir.nas_id.xcf,$mysqldbfir.fir.naz,$mysqldbfir.fir.rok,$mysqldbfir.fir.duj,robot ".
  " FROM $mysqldbfir.nas_id,$mysqldbfir.fir WHERE $mysqldbfir.nas_id.id=$kli_uzid AND $mysqldbfir.nas_id.xcf=$mysqldbfir.fir.xcf";
  $dbv = mysql_query("$dbvttt");
//if( $kli_uzid == 17 ) { echo $dbvttt; }


  $riadok = mysql_fetch_object($dbv);
  $vyb_xcf = $riadok->xcf;
  $vyb_naz = $riadok->naz;
  $vyb_duj = $riadok->duj;
  $vyb_rok = $riadok->rok;
  $vyb_ume = $riadok->ume+"";
  $vyb_ume=sprintf("%2.4f", $vyb_ume);
  $vyb_robot = $riadok->robot;
  mysql_free_result($dbv);
?>