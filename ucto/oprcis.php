<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$uprav = 1*$_REQUEST['uprav'];
$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];

//echo $h_obdp;

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

if( $h_obdp == 0 ) $h_obdp=$kli_vmes;
if( $h_obdk == 0 ) $h_obdk=$kli_vmes;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

if( $copern > 50 AND $drupoh == 81 )
{
$uctsys="crf204_no";
}
if( $copern > 50 AND $drupoh == 82 )
{
$uctsys="crf704_no";
}
if( $copern > 50 AND $drupoh == 83 )
{
$uctsys="crf204nuj_no";
}
if( $copern > 50 AND $drupoh == 84 )
{
$uctsys="crf104nuj_no";
}
if( $copern > 50 AND $drupoh == 85 )
{
$uctsys="crf104nuj_nozdr";
}
if( $copern > 50 AND $drupoh == 86 )
{
$uctsys="crf104nuj_nozdrdok";
}
if( $copern > 50 AND $drupoh == 87 )
{
$uctsys="crf204pod_no";
}
if( $copern > 50 AND $drupoh == 94 )
{
$uctsys="crcash_flow";
}
if( $copern > 50 AND $drupoh == 95 )
{
$uctsys="crcash_flow2011";
}
if( $copern > 50 AND $drupoh == 96 )
{
$uctsys="crs_no";
}
if( $copern > 50 AND $drupoh == 97 )
{
$uctsys="uctgenprivydnoju";
}
if( $copern > 50 AND $drupoh == 98 )
{
$uctsys="uctgenmajzavnoju";
}

if( $drupoh == 86 )
{

$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   dox         VARCHAR(10),
   hox         DECIMAL(10,2),
   crs         INT,
   PRIMARY KEY(cpl)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_'.$uctsys.$sqlt;
$ulozene = mysql_query("$sql");

$sql = "ALTER TABLE F$kli_vxcf"."_".$uctsys." ADD rpx VARCHAR(50) NOT NULL AFTER hox";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_".$uctsys." ADD crz INT AFTER hox";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_".$uctsys." ADD rpz VARCHAR(50) NOT NULL AFTER hox";
$vysledek = mysql_query("$sql");

}

if( $drupoh == 81 OR $drupoh == 82 OR $drupoh == 83 OR $drupoh == 84 OR $drupoh == 85 OR $drupoh == 94 OR $drupoh == 95 OR $drupoh == 96 OR $drupoh == 97 OR $drupoh == 98 OR $drupoh == 87 )
{

$sqlt = <<<uctmzd
(
   cpl         int not null auto_increment,
   uce         VARCHAR(10),
   crs         INT,
   PRIMARY KEY(cpl)
);
uctmzd;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_'.$uctsys.$sqlt;
$ulozene = mysql_query("$sql");

}

if( $drupoh == 96 OR $drupoh == 97 OR $drupoh == 98 )
{
$sql = "ALTER TABLE F$kli_vxcf"."_".$uctsys." ADD cpl int PRIMARY KEY not null auto_increment FIRST";
$vysledek = mysql_query("$sql");

}

if( $drupoh == 83 )
{
$sql = "ALTER TABLE F$kli_vxcf"."_crf204nuj_no ADD cpl01 int DEFAULT 0 AFTER crs";
$vysledek = mysql_query("$sql");

}
if( $drupoh == 87 )
{
$sql = "ALTER TABLE F$kli_vxcf"."_crf204pod_no ADD cpl01 int DEFAULT 0 AFTER crs";
$vysledek = mysql_query("$sql");

}

//nacitanie generovania SUVNO z minuleho roka 
    if ( $copern == 5055 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù generovanie z minulÈho roka ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=5056&page=1&drupoh=96'  }
</script>
<?php
    }

    if ( $copern == 5056 )
    {

$h_ycf=0;
if( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$dsqlt = "TRUNCATE F$kli_vxcf"."_crs_no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crs_no SELECT * FROM ".$databaza."F$h_ycf"."_crs_no ";
$dsql = mysql_query("$dsqlt");


$copern=308;
//koniec nacitanie generovania SUVNO z minuleho roka
    }

//nacitanie generovania CASHFLOW2011 z minuleho roka 
    if ( $copern == 6095 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù generovanie CASH FLOW z minulÈho roka ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=6195&page=1&drupoh=95'  }
</script>
<?php
    }

    if ( $copern == 6195 )
    {

$h_ycf=0;
if( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

$dsqlt = "TRUNCATE F$kli_vxcf"."_crcash_flow2011 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crcash_flow2011 SELECT * FROM ".$databaza."F$h_ycf"."_crcash_flow2011 ";
$dsql = mysql_query("$dsqlt");


$copern=308;
//koniec nacitanie generovania CASHFLOW2011  z minuleho roka
    }


//nacitanie generovania 104 z minuleho roka 
    if ( $copern == 4055 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù generovanie z minulÈho roka ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=4056&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 4056 )
    {

$h_ycf=0;
if( $fir_allx11 > 0 ) $h_ycf=1*$fir_allx11;

$databaza="";
$dtb2 = include("../cis/oddel_dtbz1.php");

if( $drupoh == 82 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf704_no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf704_no SELECT * FROM ".$databaza."F$h_ycf"."_crf704_no ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 83 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf204nuj_no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf204nuj_no SELECT * FROM ".$databaza."F$h_ycf"."_crf204nuj_no ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 87 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf204pod_no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf204pod_no SELECT * FROM ".$databaza."F$h_ycf"."_crf204pod_no ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 84 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf104nuj_no ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf104nuj_no SELECT * FROM ".$databaza."F$h_ycf"."_crf104nuj_no ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 85 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf104nuj_nozdr ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf104nuj_nozdr SELECT * FROM ".$databaza."F$h_ycf"."_crf104nuj_nozdr ";
$dsql = mysql_query("$dsqlt");
  }

if( $drupoh == 86 )
  {
$dsqlt = "TRUNCATE F$kli_vxcf"."_crf104nuj_nozdrdok ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_crf104nuj_nozdrdok SELECT * FROM ".$databaza."F$h_ycf"."_crf104nuj_nozdrdok ";
$dsql = mysql_query("$dsqlt");
  }



$copern=308;
//koniec nacitanie generovania 104 z minuleho roka
    }



//nacitanie standartnej generovania FIN 2 - 04 NUJ
    if ( $copern == 155 AND $drupoh == 83 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk generovania FIN 2 - 04 NUJ ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=83'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 83 )
    {

$sql = "DROP TABLE F$kli_vxcf"."_crf204nuj_no";
$vysledok = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_crf204nuj_nopre2011";
$vysledok = mysql_query("$sql");

echo "Zatvorte okno generovania a skliknite na naËÌtanie hodnÙt do v˝kazu FIN 2 - 04 NUJ - Program naËÌta ötandartn˝ ËÌselnÌk generovania FIN 2 - 04 NUJ";
exit;


$copern=308;
//koniec nacitania standartnej generovania FIN 2 - 04 NUJ
    }

//nacitanie standartnej generovania FIN 2 - 04 POD
    if ( $copern == 155 AND $drupoh == 87 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk generovania FIN 2 - 04 POD ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=87'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 87 )
    {

$sql = "DROP TABLE F$kli_vxcf"."_crf204pod_no";
$vysledok = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_crf204pod_nopre2011";
$vysledok = mysql_query("$sql");

echo "Zatvorte okno generovania a skliknite na naËÌtanie hodnÙt do v˝kazu FIN 2 - 04 POD - Program naËÌta ötandartn˝ ËÌselnÌk generovania FIN 2 - 04 POD";
exit;


$copern=308;
//koniec nacitania standartnej generovania FIN 2 - 04 POD
    }

//nacitanie standartnej generovania FIN 7 - 04
    if ( $copern == 155 AND $drupoh == 82 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk generovania FIN 7 - 04 ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=82'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 82 )
    {

$sql = "DROP TABLE F$kli_vxcf"."_crf704_no";
$vysledok = mysql_query("$sql");
$sql = "DROP TABLE F$kli_vxcf"."_crf704_nopre2011";
$vysledok = mysql_query("$sql");

echo "Zatvorte okno generovania a skliknite na naËÌtanie hodnÙt do v˝kazu FIN 7 - 04 - Program naËÌta ötandartn˝ ËÌselnÌk generovania FIN 7 - 04";
exit;


$copern=308;
//koniec nacitania standartnej generovania FIN 7 - 04
    }

//nacitanie standartnej druhpohybu-riadok vPVnoJU
    if ( $copern == 155 AND $drupoh == 97 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk druh pohybu -> riadok V˝kazu o prÌjmoch a v˝davkoch NO JU ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=97'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 97 )
    {

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctgenprivydnoju WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_uctgenprivydnoju ADD cru DECIMAL(5,0) DEFAULT 0 AFTER crs";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenprivydnoju ADD prm1 DECIMAL(2,0) DEFAULT 0 AFTER cru";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenprivydnoju ADD hod DECIMAL(2,0) DEFAULT 0 AFTER prm1";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctgenprivydnoju SELECT ".
"0,uce,0,crv,prm1,0 ".
" FROM F$kli_vxcf"."_uctosnova WHERE LEFT(uce,3) < 100 AND uce > 1 AND prm2 = 1 ORDER BY ucc ";
$dsql = mysql_query("$dsqlt");


if( $kli_vrok >= 2012 ) {

$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=15 WHERE prm1 != 1";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=24 WHERE prm1 = 1 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=13 WHERE cru = 1 OR cru = 2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=17 WHERE cru = 5 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=18 WHERE cru = 6 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=19 WHERE cru = 7 OR cru = 8 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=21 WHERE cru = 10 AND uce = 8 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenprivydnoju SET crs=23 WHERE cru = 9 AND uce = 26 ";
$dsql = mysql_query("$dsqlt");
                        }

$sql = "ALTER TABLE F$kli_vxcf"."_uctgenprivydnoju DROP prm1 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenprivydnoju DROP hod ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenprivydnoju DROP cru ";
$vysledek = mysql_query("$sql");

$copern=308;
//koniec nacitania standartnej druhpohybu-riadok vPVnoJU
    }

//nacitanie standartnej druhpohybu-riadok vMZnoJU
    if ( $copern == 155 AND $drupoh == 98 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk druh pohybu -> riadok V˝kazu o majetku a z·v‰zkoch NO JU  ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=98'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 98 )
    {

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctgenmajzavnoju WHERE cpl >= 0";
$dsql = mysql_query("$dsqlt");

$sql = "ALTER TABLE F$kli_vxcf"."_uctgenmajzavnoju ADD cru DECIMAL(5,0) DEFAULT 0 AFTER crs";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenmajzavnoju ADD prm1 DECIMAL(2,0) DEFAULT 0 AFTER cru";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenmajzavnoju ADD hod DECIMAL(2,0) DEFAULT 0 AFTER prm1";
$vysledek = mysql_query("$sql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctgenmajzavnoju SELECT ".
"0,uce,0,crs,prm1,0 ".
" FROM F$kli_vxcf"."_uctosnova WHERE uce > 0 AND crs > 0 ORDER BY ucc ";
$dsql = mysql_query("$dsqlt");


if( $kli_vrok >= 2012 ) {

$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=4 WHERE cru = 4 OR cru = 5 OR cru = 6 OR cru = 7 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=5 WHERE cru = 8 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=6 WHERE cru = 10 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=8 WHERE cru = 13 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=9 WHERE cru = 11 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=10 WHERE cru = 12 OR cru = 14 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=12 WHERE cru = 17 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctgenmajzavnoju SET crs=15 WHERE cru = 18 ";
$dsql = mysql_query("$dsqlt");

                        }

$sql = "ALTER TABLE F$kli_vxcf"."_uctgenmajzavnoju DROP prm1 ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenmajzavnoju DROP hod ";
$vysledek = mysql_query("$sql");
$sql = "ALTER TABLE F$kli_vxcf"."_uctgenmajzavnoju DROP cru ";
$vysledek = mysql_query("$sql");


$copern=308;
//koniec nacitania standartnej druhpohybu-riadok vMZnoJU
    }

//nacitanie standartnej cash
    if ( $copern == 155 AND $drupoh == 94 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk generovania cash flow ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 94 )
    {

$dsqlt = "TRUNCATE F$kli_vxcf"."_crcash_flow ";
$dsql = mysql_query("$dsqlt");


$copern=308;
//koniec nacitania standartnej druhpohybu-stlpec penazneho.dennika 
    }

//nacitanie standartnej cash2011
    if ( $copern == 155 AND $drupoh == 95 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù ötandartn˝ ËÌselnÌk generovania cash flow ?") )
         { window.close()  }
else
         { location.href='oprcis.php?copern=156&page=1&drupoh=<?php echo $drupoh; ?>'  }
</script>
<?php
    }

    if ( $copern == 156 AND $drupoh == 95 )
    {

$dsqlt = "TRUNCATE F$kli_vxcf"."_crcash_flow2011 ";
$dsql = mysql_query("$dsqlt");


$copern=308;
//koniec nacitania standartnej druhpohybu-stlpec penazneho.dennika 
    }


//vymazanie 
if ( $copern == 316 )
    {
$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 

$copern=308;
if (!$zmazane):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA VYMAZAN¡ " ) </script>
<?php
endif;
if ($zmazane):
$zmaz="OK";
endif;
     }
//koniec vymazania 

//ulozenie noveho 
if ( $copern == 315 AND $uprav != 1 AND $drupoh >= 81  )
    {
$h_uce = strip_tags($_REQUEST['h_uce']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_dox = 1*$_REQUEST['h_dox'];
$h_hox = 1*$_REQUEST['h_hox'];
$h_rpx = 1*$_REQUEST['h_rpx'];
$h_rpz = 1*$_REQUEST['h_rpz'];
$h_crz = 1*$_REQUEST['h_crz'];

if( $drupoh != 86 )
{
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) ".
" VALUES ( '$h_uce', '$h_crs'  ); "; 
}
if( $drupoh == 86 )
{
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, dox, hox, rpx, crs, rpz, crz ) ".
" VALUES ( '$h_uce', '$h_dox', '$h_hox', '$h_rpx', '$h_crs', '$h_rpz', '$h_crz'  ); "; 
}

//echo $ulozttt;

$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;

if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec ulozenia 

//uprava polozky
if ( $copern == 315 AND $uprav == 1 AND $drupoh >= 81  )
    {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$uprav_cpl = 1*strip_tags($_REQUEST['uprav_cpl']);

$h_uce = strip_tags($_REQUEST['h_uce']);
$h_crs = strip_tags($_REQUEST['h_crs']);
$h_dox = 1*$_REQUEST['h_dox'];
$h_hox = 1*$_REQUEST['h_hox'];
$h_rpx = 1*$_REQUEST['h_rpx'];
$h_rpz = 1*$_REQUEST['h_rpz'];
$h_crz = 1*$_REQUEST['h_crz'];

if( $drupoh != 86 )
{
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, crs ) ".
" VALUES ( '$h_uce', '$h_crs'  ); "; 
}
if( $drupoh == 86 )
{
$ulozttt = "INSERT INTO F$kli_vxcf"."_$uctsys ( uce, dox, hox, rpx, crs, rpz, crz ) ".
" VALUES ( '$h_uce', '$h_dox', '$h_hox', '$h_rpx', '$h_crs', '$h_rpz', '$h_crz'  ); ";  
}

//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 
$copern=308;
$uprav=0;
if (!$ulozene):
?>
<script type="text/javascript"> alert( " POLOéKA NEBOLA SPR¡VNE ULOéEN¡ " ) </script>
<?php
endif;
if ($ulozene):
$uloz="OK";
endif;
    }
//koniec uprava 

//308=uprava ak uz existuje
if ( $copern == 308 AND $uprav == 1 AND $drupoh >= 81  )
      {
$cislo_cpl = 1*strip_tags($_REQUEST['cislo_cpl']);
$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl = $cislo_cpl  ".
"";
//echo $sqltt;
$sql = mysql_query("$sqltt"); 
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

$h_uce = $riadok->uce;
$h_crs = $riadok->crs;
$h_dox = 1*$riadok->dox;
$h_hox = 1*$riadok->hox;
$h_rpx = 1*$riadok->rpx;
$h_rpz = 1*$riadok->rpz;
$h_crz = 1*$riadok->crz;

  }

$cislo_cpl = strip_tags($_REQUEST['cislo_cpl']);
$zmazane = mysql_query("DELETE FROM F$kli_vxcf"."_$uctsys WHERE cpl='$cislo_cpl' "); 

       }

//koniec uprava nacitanie

?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>⁄prava ËÌselnÌkov</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;

//  Kontrola cisla
    function KontrolaCisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola cisla desatinneho
    function KontrolaDcisla(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.-]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }

//  Kontrola datumu
    function KontrolaDatum(Vstup, Oznam)
    {
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Vstup.value=Vstup.value.replace(",","."); }
     if ( Vstup.value.search(/[^0-9.]/g) != -1) { Oznam.style.display=""; }
     else { Oznam.style.display="none"; }
    }




    function VyberVstup()
    {

    }

    function ObnovUI()
    {

    <?php if( $copern == 308 AND $uprav >= 0 AND $drupoh >= 81  ) { ?>
    document.formv1.h_uce.value = '<?php echo "$h_uce";?>';
    document.formv1.h_crs.value = '<?php echo "$h_crs";?>';

    <?php                                                         } ?>
    <?php if( $copern == 308 AND $uprav >= 0 AND $drupoh == 86  ) { ?>
    document.formv1.h_dox.value = '<?php echo "$h_dox";?>';
    document.formv1.h_hox.value = '<?php echo "$h_hox";?>';
    document.formv1.h_rpx.value = '<?php echo "$h_rpx";?>';
    document.formv1.h_rpz.value = '<?php echo "$h_rpz";?>';
    document.formv1.h_crz.value = '<?php echo "$h_crz";?>';
    <?php                                                         } ?>
    }

    function Povol_uloz()
    {

    }

function ZmazPolozku(cpl)
                {
var cislo_cpl = cpl;

window.open('../ucto/oprcis.php?copern=316&page=1&sysx=UCT&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=0',
 '_self' );
                }

function UpravPolozku(cpl)
                {
var cislo_cpl = cpl;

window.open('../ucto/oprcis.php?copern=308&page=1&sysx=UCT&uprav_cpl=' + cislo_cpl + '&cislo_cpl=' + cislo_cpl + '&drupoh=<?php echo $drupoh; ?>&uprav=1',
 '_self' );
                }
  
</script>
</HEAD>
<BODY class="white" id="white" onload="ObnovUI(); VyberVstup();" >



<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  

<?php if( $drupoh == 81 ) { echo " Generovanie v˝kazu FIN 2-04"; } ?>
<?php if( $drupoh == 82 ) { echo " Generovanie v˝kazu FIN 7-04"; } ?>
<?php if( $drupoh == 83 ) { echo " Generovanie v˝kazu FIN 2-04 NUJ"; } ?>
<?php if( $drupoh == 87 ) { echo " Generovanie v˝kazu FIN 2-04 POD"; } ?>
<?php if( $drupoh == 84 AND $kli_vrok <  2013 ) { echo " Generovanie v˝kazu FIN 1-04"; } ?>
<?php if( $drupoh == 85 AND $kli_vrok <  2013 ) { echo " Generovanie v˝kazu FIN 1-04 - priradenie bank.˙Ëet,doklad,˙Ëet / zdroj financovania"; } ?>
<?php if( $drupoh == 86 AND $kli_vrok <  2013 ) { echo " Generovanie v˝kazu FIN 1-04 - priradenie ˙Ëet,doklad,hodnota / zdroj financovania,RP"; } ?>
<?php if( $drupoh == 84 AND $kli_vrok >= 2013 ) { echo " Generovanie v˝kazu FIN 1-12"; } ?>
<?php if( $drupoh == 85 AND $kli_vrok >= 2013 ) { echo " Generovanie v˝kazu FIN 1-12 - priradenie bank.˙Ëet,doklad,˙Ëet / zdroj financovania"; } ?>
<?php if( $drupoh == 86 AND $kli_vrok >= 2013 ) { echo " Generovanie v˝kazu FIN 1-12 - priradenie ˙Ëet,doklad,hodnota / zdroj financovania,RP"; } ?>
<?php if( $drupoh == 94 ) { echo " Generovanie CASH FLOW"; } ?>
<?php if( $drupoh == 95 ) { echo " Generovanie CASH FLOW v.2011"; } ?>
<?php if( $drupoh == 96 ) { echo " Generovanie S˙vaha NO"; } ?>
<?php if( $drupoh == 97 ) { echo " Generovanie V˝kazu o prÌjmoch a v˝davkoch NO JU "; } ?>
<?php if( $drupoh == 98 ) { echo " Generovanie V˝kazu o majetku a z·v‰zkoch NO JU "; } ?>
</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />




<?php
////////////////////////////////////////////////////////////////uprava vykaz204
if( $drupoh == 81 OR $drupoh == 82 OR $drupoh == 83 OR $drupoh == 84 OR $drupoh == 85 OR $drupoh == 86 OR $drupoh == 94 OR $drupoh == 95 OR $drupoh == 96 OR $drupoh == 97 OR $drupoh == 98 OR $drupoh == 87 )           
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY cpl";
if( $drupoh == 96 ) { $sqltt = "SELECT * FROM F$kli_vxcf"."_$uctsys WHERE cpl > 0 ORDER BY uce"; }
$sql = mysql_query("$sqltt");

// celkom poloziek
$cpol = mysql_num_rows($sql);
$i = 0;

?>
<table class="vstup" width="100%" >
<?php if( $drupoh == 81 OR $drupoh == 82 OR $drupoh == 83 OR $drupoh == 84 OR $drupoh == 94 OR $drupoh == 95 OR $drupoh == 96 OR $drupoh == 97 OR $drupoh == 98 OR $drupoh == 87 ) { ?>
<tr>
<td class="hmenu" width="10%" >Uce
<?php if( $drupoh == 82 OR $drupoh == 84 ) { ?>
<a href='oprcis.php?drupoh=<?php echo $drupoh; ?>&copern=4055&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie z minulÈho roka"></a>
<?php                     } ?>
<?php if( $drupoh == 83 ) { ?>
<a href='#'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie z minulÈho roka nie je moûnÈ lebo sa zmenil v˝kaz oproti roku 2012"></a>
<?php                     } ?>
<?php if( $drupoh == 87 ) { ?>
<a href='#'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie z minulÈho roka nie je moûnÈ lebo nov˝ v˝kaz pre rok 2015"></a>
<?php                     } ?>
<?php if( $drupoh == 95 ) { ?>
<a href='oprcis.php?drupoh=<?php echo $drupoh; ?>&copern=6095&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie CASH FLOW 2011 z minulÈho roka"></a>
<?php                     } ?>
<?php if( $drupoh == 96 ) { ?>
<a href='oprcis.php?drupoh=<?php echo $drupoh; ?>&copern=5055&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie z minulÈho roka"></a>
<?php                     } ?>
<td class="hmenu" width="10%" align="right" >Ë.r.
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="75%" align="right" > 
<?php
if ( $drupoh != 95 AND $drupoh != 84 AND $drupoh != 83 AND $drupoh != 87 )
  {
?>
<a href='oprcis.php?drupoh=<?php echo $drupoh; ?>&copern=155&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Nastav ötandartn˝ ËÌselnÌk"></a>
<?php
  }
?>
<?php
if (  $drupoh == 83 )
  {
?>
<a href='vykaz_fin204nuj.php?drupoh=1&copern=1001&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Nastav ötandartn˝ ËÌselnÌk"></a>
<?php
  }
?>
<?php
if (  $drupoh == 87 )
  {
?>
<a href='vykaz_fin204pod.php?drupoh=1&copern=1001&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Nastav ötandartn˝ ËÌselnÌk"></a>
<?php
  }
?>
<?php
if ( $kli_uzall > 25000 AND $drupoh == 95 )
  {
?>
<img src='../obr/export.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=14&page=1', '_self');" 
width=20 height=15 border=0 title="Exportovaù ËÌselnÌk generovania do s˙boru CSV" >
 - 
<?php
  }
?>
<?php
if ( $drupoh == 95 )
  {
?>
<img src='../obr/orig.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1514&page=1', '_self');" 
width=20 height=15 border=0 title="NaËÌtaù ötandartn˝ ËÌselnÌk generovania z ../import/cashgen<?php echo $kli_vrok; ?>.csv" >
 - 
<img src='../obr/kos.png' onclick="window.open('../mzdy/drmiezd_export.php?sys=<?php echo $sys; ?>&copern=1814&page=1', '_self');" 
width=20 height=15 border=0 title="Vymazaù ËÌselnÌk generovania" >
<?php
  }
?>


</tr>
<?php                                                                                         } ?>
<?php if( $drupoh == 85 ) { ?>
<tr>
<td class="hmenu" width="10%" >BU,DK,UC

<a href='oprcis.php?drupoh=85&copern=4055&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie z minulÈho roka"></a>

<td class="hmenu" width="10%" align="right" >Zdroj
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="75%" align="right" > 
</tr>
<?php                     } ?>
<?php if( $drupoh == 86 ) { ?>
<tr>
<td class="hmenu" width="10%" >Uce

<a href='oprcis.php?drupoh=86&copern=4055&page=1'>
<img src='../obr/import.png' width=20 height=15 border=0 title="NaËÌtaj generovanie z minulÈho roka"></a>

<td class="hmenu" width="10%" >Dok
<td class="hmenu" width="10%" >Hod
<td class="hmenu" width="10%" align="right" >zRP
<td class="hmenu" width="10%" align="right" >zoZdroja
<td class="hmenu" width="10%" align="right" >RP
<td class="hmenu" width="10%" align="right" >Zdroj
<th class="hmenu" width="5%" >Edi/Del
<td class="hmenu" width="25%" align="right" > 
</tr>
<?php                     } ?>
<?php
   while ($i <= $cpol )
   {
?>
<?php
  if (@$zaznam=mysql_data_seek($sql,$i))
  {
$riadok=mysql_fetch_object($sql);
?>
<tr>

<td class="fmenu" ><?php echo $riadok->uce;?></td>
<?php if( $drupoh == 86 ) { ?>
<td class="fmenu" align="right" ><?php echo $riadok->dox;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->hox;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->rpz;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->crz;?></td>
<td class="fmenu" align="right" ><?php echo $riadok->rpx;?></td>
<?php                     } ?>
<td class="fmenu" align="right" ><?php echo $riadok->crs;?></td>

<td class="fmenu" width="5%" >

<a href="#" onClick="UpravPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/uprav.png' width=15 height=10 border=0 title='Upraviù riadok' ></a>

<a href="#" onClick="ZmazPolozku(<?php echo $riadok->cpl;?>);">
<img src='../obr/zmaz.png' width=15 height=10 border=0 title='Vymazaù riadok' ></a>

</td>
</tr>
<?php
  }
$i = $i + 1;
   }
?>

<FORM name="formv1" class="obyc" method="post" action="oprcis.php?copern=315&uprav=<?php echo $uprav;?>&drupoh=<?php echo $drupoh;?>" >
<tr>

<td class="hmenu"><input type="text" name="h_uce" id="h_uce" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" " />

<?php if( $drupoh == 86 ) { ?>
<td class="hmenu"><input type="text" name="h_dox" id="h_dox" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" " />
<td class="hmenu"><input type="text" name="h_hox" id="h_hox" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" " />
<td class="hmenu"><input type="text" name="h_rpz" id="h_rpz" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" " />
<td class="hmenu"><input type="text" name="h_crz" id="h_crz" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" " />
<td class="hmenu"><input type="text" name="h_rpx" id="h_rpx" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" " />
<?php                     } ?>

<td class="hmenu"><input type="text" name="h_crs" id="h_crs" size="7" onclick=" "
 onKeyDown=" "  onkeyup=" "/>

</tr>

<tr>
<td class="obyc" colspan="2"><INPUT type="submit" id="uloz" name="uloz" value="Uloûiù" ></td>
</tr>
</table>

<?php
}
////////////////////////////////////////////////////////////////koniec uprava vykaz104
?>

<?php
// celkovy koniec dokumentu

       } while (false);
?>
</BODY>
</HTML>
