<?php

if( $copernx == 'alibaba40' ) { 

if (File_Exists ("tmp/00001111testujcas.txt")) { $soubor = unlink("tmp/00001111testujcas.txt"); }
$soubor = fopen("tmp/00001111testujcas.txt", "a+");

fclose($soubor);


$adresar = opendir("tmp");
chdir("tmp");

$filename = "00001111testujcas.txt";
$datumzmeny=date ("Y-m-d h:s", filemtime($filename));
$pole = explode("-", $datumzmeny);
$rok=$pole[0];
$mesiac=$pole[1];
$den=$pole[2];

$cascislo=$rok*365+$mesiac*30+$den;

$casnula=$cascislo; 
//echo $cascislo;


while ($soubor = readdir($adresar))
{

if(is_file($soubor))
    {

$filename = "$soubor";
if (file_exists($filename)) {

$zmaz=1;
if( $filename == "menu2.on" ) { $zmaz=0; }
if( $filename == "menu3.on" ) { $zmaz=0; }
if( $filename == "index.php" ) { $zmaz=0; }
if( $filename == "uctosnova.csv" ) { $zmaz=0; }

$datumzmeny=date ("Y-m-d h:s", filemtime($filename));
$pole = explode("-", $datumzmeny);
$rok=$pole[0];
$mesiac=$pole[1];
$den=$pole[2];

$cascislo=$rok*365+$mesiac*30+$den;

$casrozdiel=$casnula-$cascislo;
if( $casrozdiel < 1 ) { $zmaz=0; } 

   //echo "$filename bol naposledy upravený: " .$datumzmeny." cascislo ".$cascislo." zmaz ".$zmaz." ".$casrozdiel."<br />";
   if ( $zmaz == 1 ) { $souborzmaz = unlink("$filename"); }
                            }


    }


}

$sqlt = <<<mzdprc
(
   dat          DATE,
   konx1        DECIMAL(10,0) DEFAULT 0
);
mzdprc;

$vsql = 'CREATE TABLE cleaningtmp '.$sqlt;
$vytvor = mysql_query("$vsql");

$ttvv = "INSERT INTO cleaningtmp ( dat,konx1  ) VALUES ( '$datdnessql', '1' )";
$ttqq = mysql_query("$ttvv");

                              }
//len ak alibaba40

?>