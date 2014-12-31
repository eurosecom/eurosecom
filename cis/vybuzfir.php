<?php

  $sqlfiruzttx = "SELECT * FROM $mysqldbfir.firuz ";
  $sqlfiruzx = mysql_query("$sqlfiruzttx");
  if($sqlfiruzx)
      {

  $sqlfiruzttt = "SELECT * FROM $mysqldbfir.firuz WHERE uzid = $kli_uzid ORDER BY fiod, fido";
  $sqlfiruz = mysql_query("$sqlfiruzttt");
  while ($riadok = mysql_fetch_object($sqlfiruz))
  {

  $akefirmy = $akefirmy." OR ( xcf >= $riadok->fiod AND xcf <= $riadok->fido )";

  }

      }


//echo "<br />"."<br />"."<br />"."<br />"."<br />"."<br />"."<br />".$akefirmy."<br />";
//exit;

?>