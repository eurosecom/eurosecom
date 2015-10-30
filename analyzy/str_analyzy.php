<HTML>
<?php

do
{
$sys = 'ANA';
$urov = 5000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];
$druhana = 1*$_REQUEST['druhana'];

$uziv = include("../uziv.php");
if( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$h_obdp = 1*$_REQUEST['h_obdp'];
$h_obdk = 1*$_REQUEST['h_obdk'];
if( $h_obdp == 0 ) { $h_obdp=1; }
if( $h_obdk == 0 ) { $h_obdk=$kli_vmes; }
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Analyzy</title>
  <style type="text/css">
td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }
td.hvstup_tzlte { background-color:#ecaa12; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_zlte  { background-color:#ffff90; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.hvstup_bsede { background-color:#eaeaea; color:black; font-weight:normal;
                  height:12px; font-size:12px; }
td.hvstup_bred { background-color:#ff6c6c; color:black; font-weight:normal;
                  height:12px; font-size:12px; }

td.hvstup_biele { background-color:white; color:black; font-weight:bold;
                  height:12px; font-size:12px; }

td.zvyrazni { background-color:blue; color:#ffff90; font-weight:bold;
                  height:16px; font-size:14px; }

  </style>
<script type="text/javascript">

//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;



function MzdList( h_oc )
                {

window.open('../mzdy/mzdevid.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function VyslZak( h_oc )
                {

window.open('../analyzy/str_zisk.php?csv=0&cislo_zak=' + h_oc + '&copern=10&drupoh=1&page=1&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&typ=PDF&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function VyslZakCsv( h_oc )
                {

window.open('../analyzy/str_zisk.php?csv=1&cislo_zak=' + h_oc + '&copern=10&drupoh=1&page=1&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&typ=PDF&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function VyslZakAll( h_oc )
                {

window.open('../analyzy/str_zisk.php?cislo_zak=' + h_oc + '&copern=10&drupoh=1&page=1&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&typ=PDF&zana=1&druhana=<?php echo $druhana; ?>&vsetkystr=1',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function VyslZakVsetky()
                {

window.open('../analyzy/str_zisk.php?vsetkystr=1&csv=0&cislo_zak=0&copern=10&drupoh=1&page=1&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&typ=PDF&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function VyslZakVsetkyCsv()
                {

window.open('../analyzy/str_zisk.php?vsetkystr=1&csv=1&cislo_zak=0&copern=10&drupoh=1&page=1&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&typ=PDF&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function Mat( h_oc )
                {

window.open('../analyzy/str_mat.php?cislo_zak=' + h_oc + '&copern=10&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&drupoh=1&page=1&subor=0&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }

function Mzdy( h_oc )
                {
window.open('../analyzy/str_mzdy.php?cislo_zak=' + h_oc + '&copern=10&h_min=<?php echo $h_min; ?>&h_obdp=<?php echo $h_obdp; ?>&h_obdk=<?php echo $h_obdk; ?>&drupoh=1&page=1&subor=0&zana=1&druhana=<?php echo $druhana; ?>',
 '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );
                }

function Zvyrazni_tdbiele(Obj, zak)
                {
  var dajid1 = "zak" + zak + "s1"; 
  myTD1 = document.getElementById( dajid1 );
  var dajid2 = "zak" + zak + "s2"; 
  myTD2 = document.getElementById( dajid2 );
  var dajid3 = "zak" + zak + "s3"; 
  myTD3 = document.getElementById( dajid3 );
  var dajid4 = "zak" + zak + "s4"; 
  myTD4 = document.getElementById( dajid4 );
  var dajid5 = "zak" + zak + "s5"; 
  myTD5 = document.getElementById( dajid5 );
  var dajid6 = "zak" + zak + "s6"; 
  myTD6 = document.getElementById( dajid6 );
  var dajid7 = "zak" + zak + "s7"; 
  myTD7 = document.getElementById( dajid7 );
  var dajid8 = "zak" + zak + "s8"; 
  myTD8 = document.getElementById( dajid8 );

if( Obj.className == "hvstup_biele" || Obj.className == "hvstup_zlte" ) 
{
Obj.className = "zvyrazni";
myTD1.className = "zvyrazni";
myTD2.className = "zvyrazni";
myTD3.className = "zvyrazni";
myTD4.className = "zvyrazni";
myTD5.className = "zvyrazni";
myTD6.className = "zvyrazni";
myTD7.className = "zvyrazni";
myTD8.className = "zvyrazni";
}
else 
{
Obj.className = "hvstup_biele";
myTD1.className = "hvstup_biele";
myTD2.className = "hvstup_biele";
myTD3.className = "hvstup_biele";
myTD4.className = "hvstup_zlte";
myTD5.className = "hvstup_biele";
myTD6.className = "hvstup_zlte";
myTD7.className = "hvstup_biele";
myTD8.className = "hvstup_zlte";
}
                }

function VyberVstup()
                {
<?php if( $kli_vduj != 9 ) { echo "document.forms.formx1.h_obdp.value=$h_obdp; "; } ?>
<?php if( $kli_vduj != 9 ) { echo "document.forms.formx1.h_obdk.value=$h_obdk; "; } ?>

                }

function setdatum()
                {

  var h_obdp = document.forms.formx1.h_obdp.value;
  var h_obdk = document.forms.formx1.h_obdk.value;

window.open('../analyzy/str_analyzy.php?copern=10&h_obdp=' + h_obdp + '&h_obdk=' + h_obdk + '&druhana=<?php echo $druhana; ?>&drupoh=1&page=1',
 '_self', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' );

                }
   
</script>
</HEAD>
<BODY class="white" onload="VyberVstup();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php if( $druhana == 0 ) { echo "Analýzy stredísk"; } ?>
<?php if( $druhana == 1 ) { echo "Analýzy skupín"; } ?>
<?php if( $druhana == 2 ) { echo "Analýzy stavieb"; } ?>

<a href="#" onClick="window.open('../analyzy/str_analyzy.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&zana=1', '_self'  )">
STR<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Analýzy STREDÍSK' ></a>

<a href="#" onClick="window.open('../analyzy/str_analyzy.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&zana=1&druhana=1', '_self'  )">
SKU<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Analýzy SKUPÍN' ></a>

<a href="#" onClick="window.open('../analyzy/str_analyzy.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&zana=1&druhana=2', '_self'  )">
STA<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Analýzy STAVIEB' ></a>

</td>
<td align="right">
<span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   psys         INT(10),
   oc           INT(10),
   pomx         VARCHAR(10),
   vykx         DECIMAL(10,0),
   zakx         DECIMAL(10,0),
   r00x         DECIMAL(10,2),
   r03x         DECIMAL(10,2),
   r04ax        DECIMAL(10,2),
   r06x         DECIMAL(10,2),
   r09x         DECIMAL(10,2),
   r11x         DECIMAL(10,2),
   r14x         DECIMAL(10,2),
   r18x         DECIMAL(10,2),
   pop          VARCHAR(80)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");


$ume_poc=$h_obdp.".".$kli_vrok;
$ume_kon=$h_obdk.".".$kli_vrok;

$psys=1;
 while ($psys <= 9 ) 
 {
//zober prijmove pokl
if( $psys == 1 ) { $uctovanie="uctpokuct"; $doklad="pokpri"; }
//zober vydavkove pokl
if( $psys == 2 ) { $uctovanie="uctpokuct"; $doklad="pokvyd"; }
//zober bankove
if( $psys == 3 ) { $uctovanie="uctban"; $doklad="banvyp"; }
//zober vseobecne
if( $psys == 4 ) { $uctovanie="uctvsdp"; $doklad="uctvsdh"; }
//zober odberatelske
if( $psys == 5 ) { $uctovanie="uctodb"; $doklad="fakodb"; }
//zober dodavatelske
if( $psys == 6 ) { $uctovanie="uctdod"; $doklad="fakdod"; }
//zober majetok
if( $psys == 7 ) { $uctovanie="uctmaj"; }
//zober majetok
if( $psys == 8 ) { $uctovanie="uctskl"; }
//zober mzdy
if( $psys == 9 ) { $uctovanie="uctmzd"; }

if( $psys <= 6 )
{
$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 1,F$kli_vxcf"."_$uctovanie.str,ucm,ucd,F$kli_vxcf"."_$uctovanie.zak,-F$kli_vxcf"."_$uctovanie.hod,F$kli_vxcf"."_$uctovanie.hod,0,0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".
" AND ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 8 OR LEFT(ucm,1) = 6 OR LEFT(ucm,1) = 9  ) AND ume >= $ume_poc AND ume <= $ume_kon ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 1,F$kli_vxcf"."_$uctovanie.str,ucm,ucd,F$kli_vxcf"."_$uctovanie.zak,F$kli_vxcf"."_$uctovanie.hod,0,F$kli_vxcf"."_$uctovanie.hod,0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_$uctovanie,F$kli_vxcf"."_$doklad".
" WHERE F$kli_vxcf"."_$uctovanie.dok=F$kli_vxcf"."_$doklad.dok ".
" AND ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 8 OR LEFT(ucd,1) = 6 OR LEFT(ucd,1) = 9 ) AND ume >= $ume_poc AND ume <= $ume_kon ";
$dsql = mysql_query("$dsqlt");
}
else
{
//tu budu podsystemy

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 1,str,ucm,ucd,zak,-hod,hod,0,0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( LEFT(ucm,1) = 5 OR LEFT(ucm,1) = 8 OR LEFT(ucm,1) = 6 OR LEFT(ucm,1) = 9  ) AND ume >= $ume_poc AND ume <= $ume_kon ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 1,str,ucm,ucd,zak,hod,0,hod,0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_$uctovanie".
" WHERE ( LEFT(ucd,1) = 5 OR LEFT(ucd,1) = 8 OR LEFT(ucd,1) = 6 OR LEFT(ucd,1) = 9  ) AND ume >= $ume_poc AND ume <= $ume_kon ";
$dsql = mysql_query("$dsqlt");

}
$psys=$psys+1;
  }



//material
$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid  ".
" SET r09x=r03x  ".
" WHERE LEFT(pomx,3) = 501";
$dsql = mysql_query("$dsqlt");

//mzdy
$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid  ".
" SET r06x=r03x  ".
" WHERE LEFT(pomx,3) = 521 OR LEFT(pomx,3) = 522 OR LEFT(pomx,3) = 524";
$dsql = mysql_query("$dsqlt");

//suma za oc
if( $druhana == 0 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,zakx,SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz$kli_uzid WHERE psys = 1";
$dsql = mysql_query("$dsqlt");
  }


if( $druhana == 1 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,zakx,SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY oc,zakx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz$kli_uzid WHERE psys = 1";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid,F$kli_vxcf"."_zak  ".
" SET vykx=sku  ".
" WHERE F$kli_vxcf"."_rzdanezoz$kli_uzid.oc=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_rzdanezoz$kli_uzid.zakx=F$kli_vxcf"."_zak.zak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid SET oc=vykx, psys=1  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,zakx,SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz$kli_uzid WHERE psys = 1";
$dsql = mysql_query("$dsqlt");
  }

if( $druhana == 2 )
  {
$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,zakx,SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY oc,zakx ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz$kli_uzid WHERE psys = 1";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid,F$kli_vxcf"."_zak  ".
" SET vykx=stv  ".
" WHERE F$kli_vxcf"."_rzdanezoz$kli_uzid.oc=F$kli_vxcf"."_zak.str AND F$kli_vxcf"."_rzdanezoz$kli_uzid.zakx=F$kli_vxcf"."_zak.zak";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid SET oc=vykx, psys=1  ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,zakx,SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY oc ";
$dsql = mysql_query("$dsqlt");

$dsqlt = "DELETE FROM F$kli_vxcf"."_rzdanezoz$kli_uzid WHERE psys = 1";
$dsql = mysql_query("$dsqlt");
  }

//suma celkom
$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 9,oc,0,SUM(vykx),0,SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY psys ";
$dsql = mysql_query("$dsqlt");
//exit;

//priemer
$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid  ".
" SET r04ax=r00x/r03x  ".
" WHERE r03x != 0";
//$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid ".
" SET r09x=r00x+r06x  ".
" WHERE oc >= 0";
//$dsql = mysql_query("$dsqlt");

$xtriedenie = 1*$_REQUEST['xtriedenie'];
if( $druhana == 0 )
  {
$toc="bmenu"; $tprie="hvstup_bred"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,nst";
  }
if( $druhana == 1 )
  {
$toc="bmenu"; $tprie="hvstup_bred"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,nsu";
  }
if( $druhana == 2 )
  {
$toc="bmenu"; $tprie="hvstup_bred"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,nsv";
  }
if( $xtriedenie == 1 )
{
$toc="hvstup_bred"; $tprie="bmenu"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; 
$triedenie="psys,F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc";
}
if( $xtriedenie == 2 AND $druhana == 0 )
  {
$toc="bmenu"; $tprie="hvstup_bred"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,nst";
  }
if( $xtriedenie == 2 AND $druhana == 1 )
  {
$toc="bmenu"; $tprie="hvstup_bred"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,nsu";
  }
if( $xtriedenie == 2 AND $druhana == 2 )
  {
$toc="bmenu"; $tprie="hvstup_bred"; $tr00="bmenu"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,nsv";
  }
if( $xtriedenie == 3 )
{
$toc="bmenu"; $tprie="bmenu"; $tr00="hvstup_bred"; $tr03="bmenu"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,r00x DESC";
}
if( $xtriedenie == 4 )
{
$toc="bmenu"; $tprie="bmenu"; $tr00="bmenu"; $tr03="hvstup_bred"; $tr04="bmenu"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,r03x DESC";
}
if( $xtriedenie == 5 )
{
$toc="bmenu"; $tprie="bmenu"; $tr00="bmenu"; $tr03="bmenu"; $tr04="hvstup_bred"; $tr06="bmenu"; $tr09="bmenu"; $triedenie="psys,r04ax DESC";
}

if( $druhana == 0 ) { 
$sqltt = "SELECT * FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_str".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_str.str".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc >= 0 "."ORDER BY $triedenie";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
                    }

if( $druhana == 1 ) { 
$sqltt = "SELECT * FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_sku".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_sku.sku".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc >= 0 "."ORDER BY $triedenie";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
                    }

if( $druhana == 2 ) { 
$sqltt = "SELECT * FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_stv".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_stv.stv".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc >= 0 "."ORDER BY $triedenie";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);
                    }

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {

if ( $j == 0 )
      {
?>

<table class="vstup" width="100%" >
<FORM name="formx1" class="obyc" method="post" action="#" >

<tr>
<td class="bmenu" colspan="5" align="lext" >Analýzy za obdobie od <?php echo $h_obdp;?>.<?php echo $kli_vrok;?> do <?php echo $h_obdk;?>.<?php echo $kli_vrok;?>
<td class="bmenu" colspan="5" align="right" >
Obdobie <select size="1" name="h_obdp" id="h_obdp" >
<option value="1" >od 01.<?php echo $kli_vrok;?></option>
<option value="2" >od 02.<?php echo $kli_vrok;?></option>
<option value="3" >od 03.<?php echo $kli_vrok;?></option>
<option value="4" >od 04.<?php echo $kli_vrok;?></option>
<option value="5" >od 05.<?php echo $kli_vrok;?></option>
<option value="6" >od 06.<?php echo $kli_vrok;?></option>
<option value="7" >od 07.<?php echo $kli_vrok;?></option>
<option value="8" >od 08.<?php echo $kli_vrok;?></option>
<option value="9" >od 09.<?php echo $kli_vrok;?></option>
<option value="10" >od 10.<?php echo $kli_vrok;?></option>
<option value="11" >od 11.<?php echo $kli_vrok;?></option>
<option value="12" >od 12.<?php echo $kli_vrok;?></option>
</select>
 - <select size="1" name="h_obdk" id="h_obdk" >
<option value="1" >do 01.<?php echo $kli_vrok;?></option>
<option value="2" >do 02.<?php echo $kli_vrok;?></option>
<option value="3" >do 03.<?php echo $kli_vrok;?></option>
<option value="4" >do 04.<?php echo $kli_vrok;?></option>
<option value="5" >do 05.<?php echo $kli_vrok;?></option>
<option value="6" >do 06.<?php echo $kli_vrok;?></option>
<option value="7" >do 07.<?php echo $kli_vrok;?></option>
<option value="8" >do 08.<?php echo $kli_vrok;?></option>
<option value="9" >do 09.<?php echo $kli_vrok;?></option>
<option value="10" >do 10.<?php echo $kli_vrok;?></option>
<option value="11" >do 11.<?php echo $kli_vrok;?></option>
<option value="12" >do 12.<?php echo $kli_vrok;?></option>
</select>

 <a href="#" onClick="setdatum()">
<img src='../obr/ok.png' width=20 height=20 border=0 title='Nastavi vybrané obdobie' ></a>

<tr>

<tr>

<?php if( $druhana == 0 ) { ?>

<td class="<?php echo $toc; ?>" width="5%" align="center">
<a href='str_analyzy.php?copern=1&xtriedenie=1&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">STR</a></td>


<td class="<?php echo $tr06; ?>" width="9%" >
<a href="#" onClick="VyslZakVsetky();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Výsledok za všetky Strediská Vytlaèi vo formáte PDF' ></a>

<img src='../obr/export.png' width=20 height=15 border=0 title='Výsledovka za všetky Strediská - EXPORT do CSV' 
onClick="VyslZakVsetkyCsv();" >

<?php                     } ?>

<?php if( $druhana == 1 ) { ?>

<td class="<?php echo $toc; ?>" width="5%" align="center">
<a href='str_analyzy.php?copern=1&xtriedenie=1&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">SKU</a></td>


<td class="<?php echo $tr06; ?>" width="9%" >
<a href="#" onClick="window.open('../analyzy/str_zisk.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&zana=1&druhana=1&vsetkystr=1', '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Výsledok za všetky Skupiny Vytlaèi vo formáte PDF' ></a>

<?php                     } ?>

<?php if( $druhana == 2 ) { ?>

<td class="<?php echo $toc; ?>" width="5%" align="center">
<a href='str_analyzy.php?copern=1&xtriedenie=1&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">STA</a></td>


<td class="<?php echo $tr06; ?>" width="9%" >
<a href="#" onClick="window.open('../analyzy/str_zisk.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&zana=1&druhana=2&vsetkystr=1', '_blank', 'width=950, height=900, top=0, left=200, status=yes, resizable=yes, scrollbars=yes' )">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='Výsledok za všetky Stavby Vytlaèi vo formáte PDF' ></a>

<?php                     } ?>

<td class="<?php echo $tprie; ?>" width="41%" >
<a href='str_analyzy.php?copern=1&xtriedenie=2&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">názov</a></td>

<td class="bmenu" width="5%" align="right"> </td>

<td class="<?php echo $tr00; ?>" width="8%" align="center">
<a href='str_analyzy.php?copern=1&xtriedenie=3&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">Zisk</a></td>

<td class="<?php echo $tr03; ?>" width="8%" align="center">
<a href='str_analyzy.php?copern=1&xtriedenie=4&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">Náklady</a></td>

<td class="<?php echo $tr04; ?>" width="8%" align="center">
<a href='str_analyzy.php?copern=1&xtriedenie=5&page=1&cislo_z=<?php echo $cislo_x;?>&druhana=<?php echo $druhana; ?>' target="_self">Výnosy</a></td>

<td class="<?php echo $tr06; ?>" width="8%" align="center">Mzdy,Odvody</td>
<td class="<?php echo $tr09; ?>" width="8%" align="center">Materiál</td>


</tr>

<?php
      }
//koniec j=0

//html nestrankuj
if( $typ == 'HTML' ) $j=1;

  if (@$zaznam=mysql_data_seek($sql,$i))
{
$polozka=mysql_fetch_object($sql);

$h_hotp=0;
$h_hotv=0;
$h_hotp=$polozka->hotp;
$h_hotv=$polozka->hotv;

//urob slovensky datum na 8miest
  list ($rok, $mes, $den) = split ('[-]', $polozka->dat, 3);
  $rok=$rok-2000;
  $datsk = sprintf("%02d.%02d.%02d", $den, $mes, $rok);

//sumare napocet
$hotp = $hotp + $h_hotp;
$Cislo=$hotp+"";

$hvstup="hvstup_biele";
$hvstupz="hvstup_zlte";

$vykrz="NIE";

if( $polozka->vykx == 1 ) { $hvstup="hvstup_bred"; $vykrz="ÁNO"; }

if( $polozka->pom == 9 ) { $hvstup="hvstup_bsede"; $hvstupz="hvstup_bsede"; }

$funkciatd="Zvyrazni_tdbiele";

?>

<?php if( $polozka->psys == 0 ) { ?>

<tr>
<td class="<?php echo $hvstup; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s1" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )">
<?php echo $polozka->oc; ?> </td>

<td class="<?php echo $hvstupz; ?>" > 

<img src='../obr/tlac.png' width=20 height=15 border=0 title='Výsledovka za stredisko' onClick="VyslZak(<?php echo $polozka->oc;?>);">

<img src='../obr/export.png' width=20 height=15 border=0 title='Výsledovka za stredisko - EXPORT do CSV' onClick="VyslZakCsv(<?php echo $polozka->oc;?>);">

</td>

<td class="<?php echo $hvstup; ?>" id="zak<?php echo $polozka->oc; ?>s2" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )">
<?php if( $druhana == 0 ) { echo $polozka->nst; } ?>
<?php if( $druhana == 1 ) { echo $polozka->nsu; } ?>
<?php if( $druhana == 2 ) { echo $polozka->nsv; } ?>
</td>

<td class="<?php echo $hvstup; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s3" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )">
 </td>

<td class="<?php echo $hvstupz; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s4" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )"><?php echo $polozka->r00x;?></td>
<td class="<?php echo $hvstup; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s5" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )"><?php echo $polozka->r03x;?></td>
<td class="<?php echo $hvstupz; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s6" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )"><?php echo $polozka->r04ax;?></td>
<td class="<?php echo $hvstup; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s7" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )"><?php echo $polozka->r06x;?></td>
<td class="<?php echo $hvstupz; ?>" align="right" id="zak<?php echo $polozka->oc; ?>s8" onClick="<?php echo $funkciatd; ?>( this, <?php echo $polozka->oc; ?> )"><?php echo $polozka->r09x ;?></td>

</tr>

<?php                           } ?>


<?php if( $polozka->psys == 9 ) { ?>

<tr>
<td class="bmenu" align="right"></td>
<td class="bmenu" align="right"> </td>
<td class="bmenu">SPOLU</td>
<td class="bmenu" align="right"></td>

<td class="bmenu" align="right"><?php echo $polozka->r00x;?></td>
<td class="bmenu" align="right"><?php echo $polozka->r03x;?></td>
<td class="bmenu" align="right"><?php echo $polozka->r04ax;?></td>
<td class="bmenu" align="right"><?php echo $polozka->r06x;?></td>
<td class="bmenu" align="right"><?php echo $polozka->r09x;?></td>

</tr>

<?php                           } ?>



<?php
}



$i = $i + 1;
$j = $j + 1;
  }

//koniec poloziek

?>
</table>
<?php

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");


// celkovy koniec dokumentu
$zmenume=1; $odkaz="../analyzy/str_analyzy.php?copern=1&newmenu=$newmenu&druhana=$druhana";
$cislista = include("ana_lista.php"); 
       } while (false);
?>
</BODY>
</HTML>
