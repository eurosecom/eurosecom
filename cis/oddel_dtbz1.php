<?php
if ( $kli_vrok > 2010 )
{
if ( File_Exists("../pswd/oddelena2010db2011.php") ) { $databaza=$mysqldb2010."."; }
}
if ( $kli_vrok > 2011 )
{
if ( File_Exists("../pswd/oddelena2011db2012.php") ) { $databaza=$mysqldb2011."."; }
}
if ( $kli_vrok > 2012 )
{
if ( File_Exists("../pswd/oddelena2012db2013.php") ) { $databaza=$mysqldb2012."."; }
}
if ( $kli_vrok > 2013 )
{
if ( File_Exists("../pswd/oddelena2013db2014.php") ) { $databaza=$mysqldb2013."."; }
}
if ( $kli_vrok > 2014 )
{
if ( File_Exists("../pswd/oddelena2014db2015.php") ) { $databaza=$mysqldb2014."."; }
}
?>