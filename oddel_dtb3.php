<?php

$oddel2010=0;
if (File_Exists ("pswd/oddelena2010db2011.php")) { $oddel2010=1; }
if( $oddel2010 == 1 ) { $mysqldb=$mysqldb2011; }
$oddel2011=0;
if (File_Exists ("pswd/oddelena2011db2012.php")) { $oddel2011=1; }
if( $oddel2011 == 1 ) { $mysqldb=$mysqldb2012; }
$oddel2012=0;
if (File_Exists ("pswd/oddelena2012db2013.php")) { $oddel2012=1; }
if( $oddel2012 == 1 ) { $mysqldb=$mysqldb2013; }
$oddel2013=0;
if (File_Exists ("pswd/oddelena2013db2014.php")) { $oddel2013=1; }
if( $oddel2013 == 1 ) { $mysqldb=$mysqldb2014; }

?>