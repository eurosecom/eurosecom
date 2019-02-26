<?php
///////////////////FIN112 citaj mzdy
$sys = 'UCT';
$urov = 1000;

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$copern = 1*$_REQUEST['copern'];
$cislo_oc = 1*$_REQUEST['cislo_oc'];
if ( $copern == 10 )
        {
?>
<script type="text/javascript">
if( confirm ("Chcete naËÌtaù ˙hrady miezd  ?") )
         { window.open('vykaz_fin112_citajmzd.php?cislo_oc=<?php echo $cislo_oc;?>&copern=20&drupoh=1&page=1&subor=0&strana=2&xx=1', '_self' );  }

else
         { window.close();  }

</script>
<?php
exit;
        }


echo "naËÌtanie Miezd ume ".$kli_vume."<br />";

//zaciatok prac
if( $kli_uzid >= 1 )
{

//$kli_vume=6.2018;

//uctban dok	ddu	poh	cpl	ucm	ucd	rdp	dph	hod	hodm	kurz	mena	
//zmen	ico	fak	pop	str	zak	unk	id	datm

$sqlt = "DROP TABLE F".$kli_vxcf."_prcrzp".$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = "DROP TABLE F".$kli_vxcf."_prcrzps".$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = "DROP TABLE F".$kli_vxcf."_prcrzpsok".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcban
(
   cpl          DECIMAL(10,0) DEFAULT 0,
   psys         DECIMAL(2,0) DEFAULT 0,
   dou          DECIMAL(8,0) DEFAULT 0,
   dok          DECIMAL(8,0) DEFAULT 0,
   uce          VARCHAR(8) NOT NULL,
   rzp          VARCHAR(8) NOT NULL,
   ucm          VARCHAR(8) NOT NULL,
   ucd          VARCHAR(8) NOT NULL,
   ico          DECIMAL(10,0) DEFAULT 0,
   fak          DECIMAL(10,0) DEFAULT 0,
   hor          DECIMAL(10,2) DEFAULT 0,
   hou          DECIMAL(10,2) DEFAULT 0
);
prcban;

$vsql = "CREATE TABLE F".$kli_vxcf."_prcrzp".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_prcrzps".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");
$vsql = "CREATE TABLE F".$kli_vxcf."_prcrzpsok".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$sqlt = "DROP TABLE F".$kli_vxcf."_prcuhr".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcban
(
   cpl          DECIMAL(10,0) DEFAULT 0,
   psys         DECIMAL(2,0) DEFAULT 0,
   dok          DECIMAL(8,0) DEFAULT 0,
   ucm          VARCHAR(8) NOT NULL,
   ucd          VARCHAR(8) NOT NULL,
   ico          DECIMAL(10,0) DEFAULT 0,
   fak          DECIMAL(10,0) DEFAULT 0,
   hom          DECIMAL(10,2) DEFAULT 0,
   hod          DECIMAL(10,2) DEFAULT 0,
   hou          DECIMAL(10,2) DEFAULT 0
);
prcban;

$vsql = "CREATE TABLE F".$kli_vxcf."_prcuhr".$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

//ma dat

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctban.cpl, 0, F$kli_vxcf"."_uctban.dok, ucm, ucd, F$kli_vxcf"."_uctban.ico, F$kli_vxcf"."_uctban.fak, F$kli_vxcf"."_uctban.hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctban, F$kli_vxcf"."_banvyp ".
" WHERE LEFT(ucm,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctban.dok = F$kli_vxcf"."_banvyp.dok ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctpokuct.cpl, 0, F$kli_vxcf"."_uctpokuct.dok, ucm, ucd, F$kli_vxcf"."_uctpokuct.ico, F$kli_vxcf"."_uctpokuct.fak, F$kli_vxcf"."_uctpokuct.hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokpri ".
" WHERE LEFT(ucm,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctpokuct.dok = F$kli_vxcf"."_pokpri.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctpokuct.cpl, 0, F$kli_vxcf"."_uctpokuct.dok, ucm, ucd, F$kli_vxcf"."_uctpokuct.ico, F$kli_vxcf"."_uctpokuct.fak, F$kli_vxcf"."_uctpokuct.hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokvyd ".
" WHERE LEFT(ucm,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctpokuct.dok = F$kli_vxcf"."_pokvyd.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctvsdp.cpl, 0, F$kli_vxcf"."_uctvsdp.dok, ucm, ucd, F$kli_vxcf"."_uctvsdp.ico, F$kli_vxcf"."_uctvsdp.fak, F$kli_vxcf"."_uctvsdp.hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctvsdp, F$kli_vxcf"."_uctvsdh ".
" WHERE LEFT(ucm,1) = 5 AND ume < $kli_vume AND F$kli_vxcf"."_uctvsdp.dok = F$kli_vxcf"."_uctvsdh.dok";
$dsql = mysql_query("$dsqlt");

if( $kli_vume == 1.2019 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT cpl, 0, dok, ucm, ucd, ico, fak, hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctvsdp ".
" WHERE dok = 6005 ";
$dsql = mysql_query("$dsqlt");
  }

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctdod.cpl, 0, F$kli_vxcf"."_uctdod.dok, ucm, ucd, F$kli_vxcf"."_uctdod.ico, F$kli_vxcf"."_uctdod.fak, F$kli_vxcf"."_uctdod.hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctdod, F$kli_vxcf"."_fakdod ".
" WHERE LEFT(ucm,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctdod.dok = F$kli_vxcf"."_fakdod.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctodb.cpl, 0, F$kli_vxcf"."_uctodb.dok, ucm, ucd, F$kli_vxcf"."_uctodb.ico, F$kli_vxcf"."_uctodb.fak, F$kli_vxcf"."_uctodb.hod, 0, 0 ".
" FROM F$kli_vxcf"."_uctodb, F$kli_vxcf"."_fakodb ".
" WHERE LEFT(ucm,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctodb.dok = F$kli_vxcf"."_fakodb.dok";
//$dsql = mysql_query("$dsqlt");



//dal

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctban.cpl, 0, F$kli_vxcf"."_uctban.dok, ucm, ucd, F$kli_vxcf"."_uctban.ico, F$kli_vxcf"."_uctban.fak, 0, F$kli_vxcf"."_uctban.hod, 0 ".
" FROM F$kli_vxcf"."_uctban, F$kli_vxcf"."_banvyp ".
" WHERE LEFT(ucd,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctban.dok = F$kli_vxcf"."_banvyp.dok ";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctpokuct.cpl, 0, F$kli_vxcf"."_uctpokuct.dok, ucm, ucd, F$kli_vxcf"."_uctpokuct.ico, F$kli_vxcf"."_uctpokuct.fak, 0, F$kli_vxcf"."_uctpokuct.hod, 0 ".
" FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokpri ".
" WHERE LEFT(ucd,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctpokuct.dok = F$kli_vxcf"."_pokpri.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctpokuct.cpl, 0, F$kli_vxcf"."_uctpokuct.dok, ucm, ucd, F$kli_vxcf"."_uctpokuct.ico, F$kli_vxcf"."_uctpokuct.fak, 0, F$kli_vxcf"."_uctpokuct.hod, 0 ".
" FROM F$kli_vxcf"."_uctpokuct,F$kli_vxcf"."_pokvyd ".
" WHERE LEFT(ucd,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctpokuct.dok = F$kli_vxcf"."_pokvyd.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctvsdp.cpl, 0, F$kli_vxcf"."_uctvsdp.dok, ucm, ucd, F$kli_vxcf"."_uctvsdp.ico, F$kli_vxcf"."_uctvsdp.fak, 0, F$kli_vxcf"."_uctvsdp.hod, 0 ".
" FROM F$kli_vxcf"."_uctvsdp, F$kli_vxcf"."_uctvsdh ".
" WHERE LEFT(ucd,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctvsdp.dok = F$kli_vxcf"."_uctvsdh.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctdod.cpl, 0, F$kli_vxcf"."_uctdod.dok, ucm, ucd, F$kli_vxcf"."_uctdod.ico, F$kli_vxcf"."_uctdod.fak, 0, F$kli_vxcf"."_uctdod.hod, 0 ".
" FROM F$kli_vxcf"."_uctdod, F$kli_vxcf"."_fakdod ".
" WHERE LEFT(ucd,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctdod.dok = F$kli_vxcf"."_fakdod.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcuhr$kli_uzid ".
" SELECT F$kli_vxcf"."_uctodb.cpl, 0, F$kli_vxcf"."_uctodb.dok, ucm, ucd, F$kli_vxcf"."_uctodb.ico, F$kli_vxcf"."_uctodb.fak, 0, F$kli_vxcf"."_uctodb.hod, 0 ".
" FROM F$kli_vxcf"."_uctodb, F$kli_vxcf"."_fakodb ".
" WHERE LEFT(ucd,1) = 2 ANd ume <= $kli_vume AND F$kli_vxcf"."_uctodb.dok = F$kli_vxcf"."_fakodb.dok";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_prcuhr$kli_uzid SET hod=hom WHERE dok >= 0 ";
$dsql = mysql_query("$dsqlt");
$dsqlt = "UPDATE F$kli_vxcf"."_prcuhr$kli_uzid SET hom=0 WHERE dok >= 0 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcuhr$kli_uzid WHERE LEFT(ucm,1) = 2 AND LEFT(ucd,1) = 2 ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_prcuhr$kli_uzid WHERE LEFT(ucm,3) != 521 AND LEFT(ucm,3) != 524 ";
$dsql = mysql_query("$dsqlt");

//exit;

$sqltt = "SELECT * FROM F".$kli_vxcf."_prcuhr$kli_uzid WHERE dok >= 0 GROUP BY dok ";

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);


$hodmd=$hodmd+$rtov->hom;
$hoddl=$hoddl+$rtov->hod;
$hou=$hou+$rtov->hou;

//echo $rtov->cpl.";".$rtov->dok.";".$rtov->ucm.";".$rtov->ucd.";".$rtov->ico.";".$rtov->fak.";".$rtov->hom.";".$rtov->hod.";___________________"."<br />";

$jeuctdod=0;
//uctodb
$sqlt2 = "SELECT * FROM F".$kli_vxcf."_uctvsdp WHERE dok = $rtov->dok AND ( LEFT(ucm,3) = 521 OR LEFT(ucm,3) = 524 ) ORDER BY dok, cpl ";

$to2 = mysql_query("$sqlt2");
$tvpo2 = mysql_num_rows($to2);
//echo $sqlt2.$tvpo2."<br />";
$i2=0;
  while ($i2 <= $tvpo2 )
  {

  if (@$zaznam=mysql_data_seek($to2,$i2))
 {
$rto2=mysql_fetch_object($to2);


$jeuctdod=1;
//echo $rto2->dok.";".$rto2->ucm.";".$rto2->ucd.";".$rto2->hod.";_____2"."<br />";


$dsqlt = "INSERT INTO F$kli_vxcf"."_prcrzp$kli_uzid ".
" ( cpl, psys, dou, dok, uce, rzp, ucm, ucd, ico, fak, hor, hou ) VALUES ".
" ( $rtov->cpl, 1, '$rtov->dok', '$rto2->dok', '$rto2->ucm', '', '$rto2->ucm', '$rto2->ucd', '$rtov->ico', '$rtov->fak', '$rto2->hod', '$rtov->hod' ) ";
$dsql = mysql_query("$dsqlt");


 }

$i2=$i2+1;
   }

//end uctodb


//uctodb 2018
$jeuctdod2=0;
if( $jeuctdod2 == 0 )
          {

echo "idem 2018";
$databaza18=$mysqldb2018.".";
$kli_vxcfmin=909;

$sqlt3 = "SELECT * FROM ".$databaza18."F".$kli_vxcfmin."_uctvsdp WHERE ( dok = 6231 OR dok = 6499 ) AND ( LEFT(ucm,3) = 521 OR LEFT(ucm,3) = 524 ) ORDER BY dok, cpl ";

$to3 = mysql_query("$sqlt3");
$tvpo3 = mysql_num_rows($to3);
echo $sqlt3.$tvpo3."<br />";
$i3=0;
  while ($i3 <= $tvpo3 )
  {

  if (@$zaznam=mysql_data_seek($to3,$i3))
 {
$rto3=mysql_fetch_object($to3);

$jeuctdod=1;
echo $rto3->dok.";".$rto3->ucm.";".$rto3->ucd.";".$rto3->hod.";_____3"."<br />";

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcrzp$kli_uzid ".
" ( cpl, psys, dou, dok, uce, rzp, ucm, ucd, ico, fak, hor, hou ) VALUES ".
" ( $rtov->cpl, 1, '$rtov->dok', '$rto3->dok', '$rto3->ucm', '', '$rto3->ucm', '$rto3->ucd', '$rtov->ico', '$rtov->fak', '$rto3->hod', '$rtov->hod' ) ";
$dsql = mysql_query("$dsqlt");

 }

$i3=$i3+1;
   }

          }
//end uctodb 2018

if( $jeuctdod == 0 ) { echo $rtov->dok.";".$rtov->ico.";".$rtov->fak.";".$rtov->hod.";".";_____NENASIEL"."<br />"; }

 }

$i=$i+1;
   }


echo "hodmd ".$hodmd.";sum"."<br />";
echo "hoddl ".$hoddl.";sum"."<br />";
echo "hou ".$hou.";sum"."<br />";
//exit;


$dsqlt = "DELETE FROM F$kli_vxcf"."_prcrzp$kli_uzid WHERE LEFT(ucm,3) = 395 AND LEFT(ucd,3) = 395 ";
$dsql = mysql_query("$dsqlt");


}
//koniec prac

//exit;

//zaciatok rzp
if( $kli_uzid >= 1 )
{

$sqlt = "DELETE FROM F".$kli_vxcf."_prcrzps".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqltt = "ALTER TABLE F$kli_vxcf"."_prcrzps$kli_uzid ADD hox DECIMAL(10,2) DEFAULT 0 AFTER hou";
$tov = mysql_query("$sqltt");
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcrzp$kli_uzid ADD hox DECIMAL(10,2) DEFAULT 0 AFTER hou";
$tov = mysql_query("$sqltt");


$dsqlt = "UPDATE F$kli_vxcf"."_prcrzp$kli_uzid, F$kli_vxcf"."_crf104nuj_no ".
" SET rzp=crs ".
" WHERE LEFT(F$kli_vxcf"."_prcrzp$kli_uzid.uce,3)=LEFT(F$kli_vxcf"."_crf104nuj_no.uce,3) ";
$dsql = mysql_query("$dsqlt");


$dsqlt = "UPDATE F$kli_vxcf"."_prcrzp$kli_uzid, F$kli_vxcf"."_crf104nuj_no ".
" SET rzp=crs ".
" WHERE F$kli_vxcf"."_prcrzp$kli_uzid.uce=F$kli_vxcf"."_crf104nuj_no.uce ";
$dsql = mysql_query("$dsqlt");


$sqlt = "DELETE FROM F".$kli_vxcf."_prcrzps".$kli_uzid;
$vysledok = mysql_query("$sqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcrzps$kli_uzid ".
" SELECT cpl, 0, dou, dok, uce, rzp, ucm, ucd, ico, fak, SUM(hor), hou, SUM(hox) ".
" FROM F$kli_vxcf"."_prcrzp$kli_uzid ".
" WHERE dok >= 0 GROUP BY rzp,uce ";
$dsql = mysql_query("$dsqlt");



$sqltt = "SELECT * FROM F".$kli_vxcf."_prcrzps$kli_uzid WHERE dok >= 0 ORDER BY rzp";


$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);


$hou=$hou+$rtov->hou;
$hor=$hor+$rtov->hor;

$hod=$hod+$rtov->hod;
$hom=$hom+$rtov->hom;
$hox=$hox+$rtov->hox;

echo $rtov->cpl.";".$rtov->dou.";".$rtov->dok.";".$rtov->uce.";".$rtov->rzp.";".$rtov->hor.";".$rtov->hou.";".$rtov->hox.";___________________"."<br />";



 }

$i=$i+1;
   }

//echo "hou ".$hou.";sum"."<br />";
//echo "hor ".$hor.";sum"."<br />";

//echo "hod ".$hod.";sum"."<br />";
//echo "hom ".$hom.";sum"."<br />";

echo "hox ".$hox.";sum"."<br />";

}
//koniec rzp


//hotovo za rzp
$sqltt = "ALTER TABLE F$kli_vxcf"."_prcrzpsok$kli_uzid ADD hox DECIMAL(10,2) DEFAULT 0 AFTER hou";
$tov = mysql_query("$sqltt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_prcrzpsok$kli_uzid ".
" SELECT cpl, 1, dou, dok, uce, rzp, ucm, ucd, ico, fak, SUM(hor), hou, SUM(hor) ".
" FROM F$kli_vxcf"."_prcrzps$kli_uzid ".
" WHERE dok >= 0 GROUP BY rzp ";
$dsql = mysql_query("$dsqlt");

//exit;

//napocitaj do _uctvykaz_fin104

$hox=0;
$sqltt = "SELECT * FROM F".$kli_vxcf."_prcrzpsok$kli_uzid WHERE dok >= 0 ORDER BY rzp";
$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//echo $sqltt.$tvpol."<br />";
$i=0;
  while ($i <= $tvpol )
  {

  if (@$zaznam=mysql_data_seek($tov,$i))
 {
$rtov=mysql_fetch_object($tov);


$hou=$hou+$rtov->hou;
$hor=$hor+$rtov->hor;

$hod=$hod+$rtov->hod;
$hom=$hom+$rtov->hom;
$hox=$hox+$rtov->hox;

echo $rtov->cpl.";".$rtov->dou.";".$rtov->dok.";".$rtov->uce.";".$rtov->rzp.";".$rtov->hor.";".$rtov->hou.";".$rtov->hox.";___________________"."<br />";

$sqltt3 = "UPDATE F".$kli_vxcf."_uctvykaz_fin104 SET skutocnost=skutocnost+($rtov->hox) WHERE polozka = $rtov->rzp  ";
$sqldo3 = mysql_query("$sqltt3");


$sqltt3 = "SELECT * FROM F".$kli_vxcf."_uctvykaz_fin104 WHERE polozka = $rtov->rzp  ";
$sqldo3 = mysql_query("$sqltt3");
$tvpol3 = 1*mysql_num_rows($sqldo3);
if( $tvpol3 == 0 ) { echo $rtov->rzp." NIE JE RZP v rozpocte "."<br />"; }

 }

$i=$i+1;
   }

//echo "hou ".$hou.";sum"."<br />";
//echo "hor ".$hor.";sum"."<br />";

//echo "hod ".$hod.";sum"."<br />";
//echo "hom ".$hom.";sum"."<br />";

echo "hox ".$hox.";sum"."<br />";

echo "naËÌtanie Miezd ume ".$kli_vume."<br />";
exit;

?>
<script type="text/javascript">

window.open('../ucto/vykaz_fin112_2016.php?cislo_oc=<?php echo $cislo_oc; ?>&copern=20&drupoh=1&fmzdy=&page=1&subor=0&fin1a12=1&strana=2', '_self' )

</script>
<?php


?>