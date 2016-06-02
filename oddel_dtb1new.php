<?php
$oddel2010=0;
if (File_Exists ("pswd/oddelena2010db2011.php")) { $oddel2010=1; }
if( $oddel2010 == 1 ) 
{ 
$mysqldbfir=$mysqldb2011; 
$mysqldbdata=$mysqldb;
}
$oddel2011=0;
if (File_Exists ("pswd/oddelena2011db2012.php")) { $oddel2011=1; }
if( $oddel2011 == 1 ) 
{ 
$mysqldbfir=$mysqldb2012; 
$mysqldbdata=$mysqldb;
}
$oddel2012=0;
if (File_Exists ("pswd/oddelena2012db2013.php")) { $oddel2012=1; }
if( $oddel2012 == 1 ) 
{ 
$mysqldbfir=$mysqldb2013; 
$mysqldbdata=$mysqldb;
}
$oddel2013=0;
if (File_Exists ("pswd/oddelena2013db2014.php")) { $oddel2013=1; }
if( $oddel2013 == 1 ) 
{ 
$mysqldbfir=$mysqldb2014; 
$mysqldbdata=$mysqldb;
}
$oddel2014=0;
if (File_Exists ("pswd/oddelena2014db2015.php")) { $oddel2014=1; }
if( $oddel2014 == 1 ) 
{ 
$mysqldbfir=$mysqldb2015; 
$mysqldbdata=$mysqldb;
}
$oddel2015=0;
if (File_Exists ("pswd/oddelena2015db2016.php")) { $oddel2015=1; }
if( $oddel2015 == 1 ) 
{ 
$mysqldbfir=$mysqldb2016; 
$mysqldbdata=$mysqldb;
}
?>