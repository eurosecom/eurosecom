<?php
//ckli.php, ckli_u.php, cfir.php a cfir_u.php... v roote
//Nastavenie $mysqldb pre editovanie tabulky fir a klienti


$mysqldb=$mysqldb2016; 
if(  $dbmain == 2017 ) { $mysqldb=$mysqldb2017; }
if(  $dbmain == 2018 ) { $mysqldb=$mysqldb2018; }
if(  $dbmain == 2019 ) { $mysqldb=$mysqldb2019; }

//echo " db ".$mysqldb;


?>