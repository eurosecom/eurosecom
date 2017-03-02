<?php
//default je 2
$dtbcharset=2;

//pre educto.sk eurosecomvirtualnyserver.ano 
$eurosecomvirtualnyserver=0;
if( file_exists("pswd/eurosecomvirtualnyserver.ano")) { $eurosecomvirtualnyserver=1; }
if( file_exists("../pswd/eurosecomvirtualnyserver.ano")) { $eurosecomvirtualnyserver=1; }
if( $eurosecomvirtualnyserver == 1 ) 
{ 
$dtbcharset=0; 
}

//pre ekorobot, edcom eurosecom2015virtualnyserver.ano 
$eurosecom2015virtualnyserver=0;
if( file_exists("pswd/eurosecom2015virtualnyserver.ano")) { $eurosecom2015virtualnyserver=1; }
if( file_exists("../pswd/eurosecom2015virtualnyserver.ano")) { $eurosecom2015virtualnyserver=1; }
if( $eurosecom2015virtualnyserver == 1 ) 
{ 
$dtbcharset=2;
$sqltt="SET NAMES cp1250";
$result = mysqli_query($mysqli, "$sqltt");
}


?>