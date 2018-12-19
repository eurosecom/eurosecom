<?php

//ak je eszalohy.sk tak citaj len vyssi rok z fir
$citajrok=0;
if( $_SERVER['SERVER_NAME'] == "localhost" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "www.enposro.sk" ) { $citajrok=2016; }
if( $_SERVER['SERVER_NAME'] == "www.eurosecom.sk" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" ) { $citajrok=2015; }
if( $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "www.ekorobot.sk" ) { $citajrok=2013; }

if( $_SERVER['SERVER_NAME'] == "enposro.sk" ) { $citajrok=2016; }
if( $_SERVER['SERVER_NAME'] == "eurosecom.sk" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "europkse.sk" ) { $citajrok=2015; }
if( $_SERVER['SERVER_NAME'] == "educto.sk" ) { $citajrok=2014; }
if( $_SERVER['SERVER_NAME'] == "ekorobot.sk" ) { $citajrok=2013; }
?>