<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 900;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];
$cislo_dok = 1*$_REQUEST['cislo_dok'];
$hladaj_uce = 1*$_REQUEST['hladaj_uce'];
$h_sys = 1*$_REQUEST['h_sys'];
$h_obdp = 1*$_REQUEST['h_obdp'];

$citfir = include("../cis/citaj_fir.php");
$citfir = include("../cis/citaj_nas.php");

if( $fir_fico == 44551142 AND $kli_vrok != 2016 ) { echo $kli_vrok." ??"; exit; }
if( $fir_fico == 44551142 AND $kli_vrok == 2016 ) 
{
?>
<script type="text/javascript">
if( !confirm ("Chcete za˙Ëtovaù fakt˙ry z podsystÈmu <?php echo $h_sys; ?> Odbyt, fakt˙ry za obdobie <?php echo $h_obdp; ?>.<?php echo $kli_vrok; ?> ?") )
         { window.close();  }
else
  var okno = window.open("../faktury/int_fakt44551142.php?copern=56&page=1&h_sys=<?php echo $h_sys; ?>&h_obdp=<?php echo $h_obdp; ?>&drupoh=1&uprav=1","_self");
</script>
<?php
exit;
}

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcvwin="width=1020, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

if( $copern == 55 )
{
?>
<script type="text/javascript">
if( !confirm ("Chcete za˙Ëtovaù fakt˙ry z podsystÈmu <?php echo $h_sys; ?> Odbyt, fakt˙ry za obdobie <?php echo $h_obdp; ?>.<?php echo $kli_vrok; ?> ?") )
         { window.close();  }
else
  var okno = window.open("../faktury/int_fakt.php?copern=56&page=1&h_sys=<?php echo $h_sys; ?>&h_obdp=<?php echo $h_obdp; ?>&drupoh=1&uprav=1","_self");
</script>

<?php
exit;
}


if( $copern == 56 AND $medo == 41 )
{
echo "Prebieha nastavovanie ˙Ëtovania fakt˙r z podsystÈmov, pre viac inform·ciÌ volajte spr·vcu aplik·cie.";

exit;
}

///////zauctuj sluzbove faktury z tejistej FIR ako UCTO
if( $copern == 56 AND $medo == 0 )
{

//echo "uctujem";

$uzk2="60200";

$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; }

$sqldok = mysql_query("SELECT * FROM $ductpoh"."uctpohyby WHERE ucto = 0 AND dzk2 = 55 AND LEFT(uzk2,3) = 602 ORDER BY cpoh LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uzk2=$riaddok->uzk2;
  $dzk2=$riaddok->dzk2;
  $udn2=$riaddok->udn2;
  $uzk1=$riaddok->uzk1;
  $dzk1=$riaddok->dzk1;
  $udn1=$riaddok->udn1;
  $uzk0=$riaddok->uzk0;
  $dzk0=$riaddok->dzk0;
  }
//echo " uzk2 ".$uzk2;

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctodb'.$kli_uzid.' ';
$vsql = mysql_query("$sql");

$sqlt = <<<uctodb
(
   prx          INT,
   slu          DECIMAL(15,0),
   strx         INT,
   zakx         INT,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         DECIMAL(10,0),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
uctodb;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctodb'.$kli_uzid.$sqlt;
$vsql = mysql_query("$sql");

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$datp_ume=$kli_vrok.'-'.$h_obdp.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datp_ume', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',0),  datk=LAST_DAY('$datp_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$podmdat=" dat >= '".$datp_ume."' AND dat <= '".$datk_ume."' ";


//fakslu
//dok  fak  dol  prf  cpl  slu  nsl  pop  pon  dph  cen  cep  ced  mno  mer  pfak  cfak  dfak  id  datm  

$pohcis=1000*$h_obdp+$h_sys;

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctodb".$kli_uzid." ".
" SELECT 0,slu,F$kli_vxcf"."_fakodb.str,F$kli_vxcf"."_fakodb.zak,F$kli_vxcf"."_fakslu.dok,$pohcis,0,F$kli_vxcf"."_fakodb.uce,'',0,dph,(cep*mno),".
" F$kli_vxcf"."_fakodb.ico,F$kli_vxcf"."_fakodb.fak,'',0,0,'',$kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_fakslu,F$kli_vxcf"."_fakodb ".
" WHERE F$kli_vxcf"."_fakslu.dok >= 0 AND F$kli_vxcf"."_fakslu.dok=F$kli_vxcf"."_fakodb.dok ".
" AND $podmdat ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctodb".$kli_uzid." ".
" SELECT 0,0,F$kli_vxcf"."_fakodb.str,F$kli_vxcf"."_fakodb.zak,F$kli_vxcf"."_fakodb.dok,$pohcis,0,F$kli_vxcf"."_fakodb.uce,'',0,$fir_dph2,(zao),".
" F$kli_vxcf"."_fakodb.ico,F$kli_vxcf"."_fakodb.fak,'',0,0,'',$kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_fakodb ".
" WHERE  $podmdat ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_uctodb".$kli_uzid." SET ucd=$uzk2, rdp=$dzk2 WHERE dph=$fir_dph2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctodb".$kli_uzid." SET ucd=$uzk1, rdp=$dzk1 WHERE dph=$fir_dph1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctodb".$kli_uzid." SET ucd=$uzk0, rdp=$dzk0 WHERE dph=0 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_uctodb".$kli_uzid.",F$kli_vxcf"."_sklsluudaje SET ".
" ucd=xuce1, str=xuce2, zak=xuce3 WHERE F$kli_vxcf"."_uctodb".$kli_uzid.".slu=F$kli_vxcf"."_sklsluudaje.xcis ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_uctodb".$kli_uzid." SET str=strx WHERE str = 0 AND strx != 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctodb".$kli_uzid." SET zak=zakx WHERE zak = 0 AND zakx != 0 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctodb".$kli_uzid." ".
" SELECT 1,slu,strx,zakx,dok,poh,0,ucm,ucd,rdp,dph,sum(hod),ico,fak,pop,str,zak,unk,".
" $kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_uctodb".$kli_uzid." ".
" WHERE hod != 0 GROUP BY dok,ucm,ucd,str,zak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctodb".$kli_uzid."  WHERE prx=0 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctodb".$kli_uzid." ".
" SELECT 1,slu,strx,zakx,dok,poh,0,ucm,$udn2,rdp,dph,dn2,ico,fak,pop,0,0,unk,".
" $kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_uctodb".$kli_uzid." ".
" WHERE dn2 != 0 GROUP BY dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctodb".$kli_uzid." ".
" SELECT 1,slu,strx,zakx,dok,poh,0,ucm,$udn1,rdp,dph,dn1,ico,fak,pop,0,0,unk,".
" $kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_uctodb".$kli_uzid." ".
" WHERE dn1 != 0 GROUP BY dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


//daj to do rozuctovania

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctodb WHERE poh=$pohcis ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctodb ".
" SELECT dok,poh,0,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,".
" $kli_uzid,now() ".
" FROM F$kli_vxcf"."_uctodb".$kli_uzid." ".
" WHERE hod != 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_fakodb,F$kli_vxcf"."_uctodb".$kli_uzid." SET ".
" hodu=F$kli_vxcf"."_fakodb.hod, zk2u=F$kli_vxcf"."_fakodb.zk2+F$kli_vxcf"."_fakodb.zao, zk1u=F$kli_vxcf"."_fakodb.zk1, ".
" zk0u=F$kli_vxcf"."_fakodb.zk0, dn2u=F$kli_vxcf"."_fakodb.dn2, dn1u=F$kli_vxcf"."_fakodb.dn1 ".
" WHERE F$kli_vxcf"."_fakodb.dok=F$kli_vxcf"."_uctodb".$kli_uzid.".dok ";
$dsql = mysql_query("$dsqlt");

?>



<?php
}
///////koniec zauctuj sluzbove faktury z tejistej FIR ako UCTO

$ajdodavfak=0;
if( $fir_fico == '45505373' ) { $ajdodavfak=1; }

///////zauctuj dodavatelske faktury z tejistej FIR ako UCTO
if( $copern == 56 AND $medo == 0 AND $ajdodavfak == 1 )
{

//echo "uctujem";

$uzk2="50100";

$ductpoh="";
if( $fir_uctx03 == 1 ) { $ductpoh="F".$kli_vxcf."_"; }

$sqldok = mysql_query("SELECT * FROM $ductpoh"."uctpohyby WHERE ucto = 0 AND dzk2 = 25 AND LEFT(uzk2,3) = 501 ORDER BY cpoh LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uzk2=$riaddok->uzk2;
  $dzk2=$riaddok->dzk2;
  $udn2=$riaddok->udn2;
  $uzk1=$riaddok->uzk1;
  $dzk1=$riaddok->dzk1;
  $udn1=$riaddok->udn1;
  $uzk0=$riaddok->uzk0;
  $dzk0=$riaddok->dzk0;
  }
//echo " uzk2 ".$uzk2;

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctdod'.$kli_uzid.' ';
$vsql = mysql_query("$sql");

$sqlt = <<<uctdod
(
   prx          INT,
   slu          DECIMAL(15,0),
   strx         INT,
   zakx         INT,
   dok         INT(8),
   poh         INT,
   cpl         int not null auto_increment,
   ucm         VARCHAR(10),
   ucd         VARCHAR(10),
   rdp         INT(2),
   dph         INT(2),
   hod         DECIMAL(10,2),
   ico         INT(10),
   fak         DECIMAL(10,0),
   pop         VARCHAR(80),
   str         INT,
   zak         INT,
   unk         VARCHAR(15),
   id          INT,
   datm        TIMESTAMP(14),
   zk0         DECIMAL(10,2),
   zk1         DECIMAL(10,2),
   zk2         DECIMAL(10,2),
   dn1         DECIMAL(10,2),
   dn2         DECIMAL(10,2),
   PRIMARY KEY(cpl)
);
uctdod;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctdod'.$kli_uzid.$sqlt;
$vsql = mysql_query("$sql");

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcdatum
(
   datp          DATE,
   datk          DATE,
   fic          INT
);
prcdatum;

$vsql = 'CREATE TABLE prcdatum'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$datp_ume=$kli_vrok.'-'.$h_obdp.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_ume', '$datp_ume', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp=SUBDATE('$datp_ume',0),  datk=LAST_DAY('$datp_ume')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_ume=$riadok->datp;
  $datk_ume=$riadok->datk;
  }

$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$podmdat=" dat >= '".$datp_ume."' AND dat <= '".$datk_ume."' ";

 

$pohcis=1000*$h_obdp+$h_sys;

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdod".$kli_uzid." ".
" SELECT 0,0,F$kli_vxcf"."_fakdod.str,F$kli_vxcf"."_fakdod.zak,F$kli_vxcf"."_fakdod.dok,$pohcis,0,'',F$kli_vxcf"."_fakdod.uce,0,$fir_dph2,(zk0+zk1+zk2+zao),".
" F$kli_vxcf"."_fakdod.ico,F$kli_vxcf"."_fakdod.fak,'',0,0,'',$kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_fakdod ".
" WHERE  $podmdat ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_uctdod".$kli_uzid." SET ucm=$uzk2, rdp=$dzk2 WHERE dph=$fir_dph2 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctdod".$kli_uzid." SET ucm=$uzk1, rdp=$dzk1 WHERE dph=$fir_dph1 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_uctdod".$kli_uzid." SET ucm=$uzk0, rdp=$dzk0 WHERE dph=0 ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdod".$kli_uzid." ".
" SELECT 1,slu,strx,zakx,dok,poh,0,ucm,ucd,rdp,dph,sum(hod),ico,fak,pop,str,zak,unk,".
" $kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_uctdod".$kli_uzid." ".
" WHERE hod != 0 GROUP BY dok,ucm,ucd,str,zak";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdod".$kli_uzid."  WHERE prx=0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdod".$kli_uzid." ".
" SELECT 1,slu,strx,zakx,dok,poh,0,$udn2,ucd,rdp,dph,dn2,ico,fak,pop,0,0,unk,".
" $kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_uctdod".$kli_uzid." ".
" WHERE dn2 != 0 GROUP BY dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdod".$kli_uzid." ".
" SELECT 1,slu,strx,zakx,dok,poh,0,$udn1,ucd,rdp,dph,dn1,ico,fak,pop,0,0,unk,".
" $kli_uzid,now(),zk0,zk1,zk2,dn1,dn2 ".
" FROM F$kli_vxcf"."_uctdod".$kli_uzid." ".
" WHERE dn1 != 0 GROUP BY dok ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");

//daj to do rozuctovania

$dsqlt = "DELETE FROM F$kli_vxcf"."_uctdod WHERE poh=$pohcis ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_uctdod ".
" SELECT dok,poh,0,ucm,ucd,rdp,dph,hod,ico,fak,pop,str,zak,unk,".
" $kli_uzid,now() ".
" FROM F$kli_vxcf"."_uctdod".$kli_uzid." ".
" WHERE hod != 0 ";
//echo $dsqlt;
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_fakdod,F$kli_vxcf"."_uctdod".$kli_uzid." SET ".
" hodu=F$kli_vxcf"."_fakdod.hod, zk2u=F$kli_vxcf"."_fakdod.zk2+F$kli_vxcf"."_fakdod.zao, zk1u=F$kli_vxcf"."_fakdod.zk1, ".
" zk0u=F$kli_vxcf"."_fakdod.zk0, dn2u=F$kli_vxcf"."_fakdod.dn2, dn1u=F$kli_vxcf"."_fakdod.dn1 ".
" WHERE F$kli_vxcf"."_fakdod.dok=F$kli_vxcf"."_uctdod".$kli_uzid.".dok ";
$dsql = mysql_query("$dsqlt");

?>



<?php
}
///////koniec zauctuj dodavatelske faktury z tejistej FIR ako UCTO


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Za˙Ëtovanie intern˝ch fakt˙r</title>
  <style type="text/css">
    #Okno{ display: none; cursor: hand; width: 150px;
             position: absolute; top: 0; left: 0;
             border: "1 solid";
             background-color: "#f0f8ff";
             border-top-color: "blue";
             border-left-color: "blue";
             border-right-color: "blue";
             border-bottom-color: "blue";
             font-size: 8pt; font-family: Arial;
           }
  </style>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

function TlacDok( dok )
                {

window.open('db_dokladov.php?vloz_dok=' + dok + '&cislo_dok=<?php echo $cislo_dok;?>&hladaj_uce=<?php echo $hladaj_uce;?>&copern=50&drupoh=1&page=1&subor=0',
 '_blank', 'width=1050, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }
    

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Za˙Ëtovanie intern˝ch fakt˙r

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
if( $copern == 56 AND $medo == 0 )
{
$uceodb="31110";
$sqldok = mysql_query("SELECT * F$kli_vxcf"."_uctodb".$kli_uzid." WHERE poh = $pohcis ORDER BY cpl LIMIT 1");
  if (@$zaznam=mysql_data_seek($sqldok,0))
  {
  $riaddok=mysql_fetch_object($sqldok);
  $uceodb=$riaddok->ucm;
  }

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctodb'.$kli_uzid.' ';
$vsql = mysql_query("$sql");

?>
OK
<script type="text/javascript">
    window.open('../ucto/zozdok.php?copern=101&drupoh=1&page=1&cislo_uce=<?php echo $uceodb;?>&page=1&tlacitR=1', '_self' );
</script>
<?php
}
?>

<?php
if( $copern == 56 AND $medo == 1 )
{
$uceodb="31147";
if( $h_sys == 612 ) $uceodb="31149";
if( $h_sys == 611 ) $uceodb="31142";
if( $h_sys == 601 ) $uceodb="31144";

$sql = 'DROP TABLE F'.$kli_vxcf.'_uctodbx'.$kli_uzid.' ';
$vsql = mysql_query("$sql");

//window.open('../ucto/rozdok.php?copern=101&drupoh=1&page=1&cislo_uce=' + ucet + '&hladaj_dok=' + hladaj_dok + '&page=1&tlacitR=1', '_blank', '' )

?>
OK
<script type="text/javascript">
    window.open('../ucto/rozdok.php?copern=101&drupoh=1&page=1&cislo_uce=<?php echo $uceodb;?>&page=1&tlacitR=1', '_self' );
</script>
<?php
}
?>


<?php


// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
