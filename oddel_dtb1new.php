<?php
//podvojneu.php, mzdy.php... v roote
//Nastavenie $mysqldbfir pre fir a nas tabulku to je vzdy main databaza
//Nastavenie $mysqldbdata pre ostatne datove tabulky podla roka 
//echo $dbmain; 

$mysqldbfir=$mysqldb2016; 
$mysqldbdata=$mysqldb2016;
if(  $dbmain == 2017 ) { $mysqldbfir=$mysqldb2017; }
if(  $dbmain == 2018 ) { $mysqldbfir=$mysqldb2018; }
if(  $dbmain == 2019 ) { $mysqldbfir=$mysqldb2019; }

//echo " fir ".$mysqldbfir;
//echo " dat ".$mysqldbdata."<br />";
?>