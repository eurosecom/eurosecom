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
if( $kli_vrok == 2020 ) { $databaza=$mysqldb2020."."; }
if( $kli_vrok == 2021 ) { $databaza=$mysqldb2021."."; }
if( $kli_vrok == 2022 ) { $databaza=$mysqldb2022."."; }
if( $kli_vrok == 2023 ) { $databaza=$mysqldb2023."."; }
if( $kli_vrok == 2024 ) { $databaza=$mysqldb2024."."; }

if( $kli_vrok == $dbmain ) { $databaza=""; }

//echo " dat2 ".$databaza;

          }
else
          {
 
if( $kli_vrok == 2010 )
 {
if (File_Exists ("../pswd/oddelena2010db2011.php")) { $databaza=$mysqldb2010."."; }
 }
if( $kli_vrok == 2011 )
 {
if (File_Exists ("../pswd/oddelena2011db2012.php")) { $databaza=$mysqldb2011."."; }
 }
if( $kli_vrok == 2012 )
 {
if (File_Exists ("../pswd/oddelena2012db2013.php")) { $databaza=$mysqldb2012."."; }
 }
if( $kli_vrok == 2013 )
 {
if (File_Exists ("../pswd/oddelena2013db2014.php")) { $databaza=$mysqldb2013."."; }
 }
if( $kli_vrok == 2014 )
{
if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; }
}
if( $kli_vrok == 2015 )
{
if ( File_Exists("../pswd/oddelena2015db2016.php") ) { $databaza=$mysqldb2015."."; }
}
if( $kli_vrok == 2016 )
{
$databaza="";
}

          }
?>