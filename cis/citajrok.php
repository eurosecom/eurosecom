<?php

//ak je eszalohy.sk tak citaj len vyssi rok z fir
$citajrok=0;
if( $_SERVER['SERVER_NAME'] == "localhost" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "www.eurosecom.sk" ) { $citajrok=2014; }

?>