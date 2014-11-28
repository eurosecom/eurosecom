<?php
if (File_Exists ("../pswd/oddelena2013db2014.php")) { $oddel2013=1; }
if( $oddel2013 == 1 ) 
{ 
$mysqldbdata=$mysqldb;
if( $vyb_rok > 0 AND $vyb_rok < 2014 ) { $mysqldbdata=$mysqldb2013; }
}

if (File_Exists ("../pswd/oddelena2012db2013.php")) { $oddel2012=1; }
if( $oddel2012 == 1 ) 
{ 
if( $vyb_rok > 0 AND $vyb_rok < 2013 ) { $mysqldbdata=$mysqldb2012; }
}

if (File_Exists ("../pswd/oddelena2011db2012.php")) { $oddel2011=1; }
if( $oddel2011 == 1 ) 
{ 
if( $vyb_rok > 0 AND $vyb_rok < 2012 ) { $mysqldbdata=$mysqldb2011; }
}

if (File_Exists ("../pswd/oddelena2010db2011.php")) { $oddel2010=1; }
if( $oddel2010 == 1 ) 
{ 
if( $vyb_rok > 0 AND $vyb_rok < 2011 ) { $mysqldbdata=$mysqldb2010; }
}
?>