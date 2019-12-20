<?php
//../kuch/kuch.php, ../rest.rest.php, ../ubyt/ubyt.php 
//Nastavenie $mysqldbfir pre uzfir, menp a nas tabulku to je vzdy main databaza
//Nastavenie $mysqldbdata pre ostatne datove tabulky podla roka 
//echo $dbmain; 

$mysqldbfir=$mysqldb2016; 
$mysqldbdata=$mysqldb2016;
if(  $dbmain == 2017 ) { $mysqldbfir=$mysqldb2017; }
if(  $dbmain == 2018 ) { $mysqldbfir=$mysqldb2018; }
if(  $dbmain == 2019 ) { $mysqldbfir=$mysqldb2019; }
if(  $dbmain == 2020 ) { $mysqldbfir=$mysqldb2020; }
if(  $dbmain == 2021 ) { $mysqldbfir=$mysqldb2021; }
if(  $dbmain == 2022 ) { $mysqldbfir=$mysqldb2022; }
if(  $dbmain == 2023 ) { $mysqldbfir=$mysqldb2023; }
if(  $dbmain == 2024 ) { $mysqldbfir=$mysqldb2024; }

//echo " fir ".$mysqldbfir;
//echo " dat ".$mysqldbdata."<br />";
?>