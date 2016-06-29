<?php
//podvojneu.php, mzdy.php... v roote
//Nastavenie $mysqldbdata pre ostatne datove tabulky podla roka
 
if( $vyb_rok > 0 AND $vyb_rok < 2020 ) { $mysqldbdata=$mysqldb2019; }
if( $vyb_rok > 0 AND $vyb_rok < 2019 ) { $mysqldbdata=$mysqldb2018; }
if( $vyb_rok > 0 AND $vyb_rok < 2018 ) { $mysqldbdata=$mysqldb2017; }
if( $vyb_rok > 0 AND $vyb_rok < 2017 ) { $mysqldbdata=$mysqldb2016; }
if( $vyb_rok > 0 AND $vyb_rok < 2016 ) { $mysqldbdata=$mysqldb2015; }
if( $vyb_rok > 0 AND $vyb_rok < 2015 ) { $mysqldbdata=$mysqldb2014; }
if( $vyb_rok > 0 AND $vyb_rok < 2014 ) { $mysqldbdata=$mysqldb2013; } 
if( $vyb_rok > 0 AND $vyb_rok < 2013 ) { $mysqldbdata=$mysqldb2012; }
if( $vyb_rok > 0 AND $vyb_rok < 2012 ) { $mysqldbdata=$mysqldb2011; }
if( $vyb_rok > 0 AND $vyb_rok < 2011 ) { $mysqldbdata=$mysqldb2010; }

//echo " fir ".$mysqldbfir;
//echo " dat ".$mysqldbdata;
?>