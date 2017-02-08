<?php
//databaza podla roka

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
if( $kli_vrok <= 2010 ) { $databaza=$mysqldb2010."."; }
if( $kli_vrok == 2011 ) { $databaza=$mysqldb2011."."; }
if( $kli_vrok == 2012 ) { $databaza=$mysqldb2012."."; }
if( $kli_vrok == 2013 ) { $databaza=$mysqldb2013."."; }
if( $kli_vrok == 2014 ) { $databaza=$mysqldb2014."."; }
if( $kli_vrok == 2015 ) { $databaza=$mysqldb2015."."; }
if( $kli_vrok == 2016 ) { $databaza=$mysqldb2016."."; }
if( $kli_vrok == 2017 ) { $databaza=$mysqldb2017."."; }
if( $kli_vrok == 2018 ) { $databaza=$mysqldb2018."."; }
if( $kli_vrok == 2019 ) { $databaza=$mysqldb2019."."; }

          }

?>