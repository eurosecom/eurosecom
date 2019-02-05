<!doctype html>
<HTML>
<?php
do
{
$sys = 'MZD';
$urov = 2000;
$copern = $_REQUEST['copern'];
$typ = $_REQUEST['typ'];
$cislo_uce = $_REQUEST['cislo_uce'];
$drupoh = 1*$_REQUEST['drupoh'];

$cislo_oc = 1*$_REQUEST['cislo_oc'];

$uziv = include("../uziv.php");
if ( !$uziv ) exit;

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$rokrocnezuc=$kli_vrok;
if ( $rokrocnezuc < 2011 ) { $rokrocnezuc=""; }
if ( $rokrocnezuc == 2011 ) { $rokrocnezuc="2011"; }
if ( $rokrocnezuc == 2012 ) { $rokrocnezuc="2012"; }
if ( $rokrocnezuc == 2013 ) { $rokrocnezuc="2013"; }
if ( $rokrocnezuc == 2014 ) { $rokrocnezuc="2014"; }
if ( $rokrocnezuc == 2015 ) { $rokrocnezuc="2015"; }
if ( $rokrocnezuc == 2016 ) { $rokrocnezuc="2016"; }
if ( $rokrocnezuc == 2017 ) { $rokrocnezuc="2017"; }
if ( $rokrocnezuc >= 2018 ) { $rokrocnezuc="2018"; }

$rokrocnezucz=$kli_vrok;
if ( $rokrocnezucz < 2011 ) { $rokrocnezucz=""; }
if ( $rokrocnezucz == 2011 ) { $rokrocnezucz="2011"; }
if ( $rokrocnezucz == 2012 ) { $rokrocnezucz="2012"; }
if ( $rokrocnezucz == 2013 ) { $rokrocnezucz="2013"; }
if ( $rokrocnezucz == 2014 ) { $rokrocnezucz="2013"; }
if ( $rokrocnezucz == 2015 ) { $rokrocnezucz="2013"; }
if ( $rokrocnezucz == 2016 ) { $rokrocnezucz="2013"; }
if ( $rokrocnezucz >= 2017 ) { $rokrocnezucz="2013"; }

//toto neviem preco tam bolo ???!!???
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdrocnedane WHERE r00 > 999998 ";
//$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdrocnedane WHERE r04a1 > 4025.70 ";
//$dsql = mysql_query("$dsqlt");
$dsqlt = "DELETE FROM F$kli_vxcf"."_mzdrocnedane WHERE r08 > 12 ";
//$dsql = mysql_query("$dsqlt");
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
 <link rel="stylesheet" href="../css/reset.css">
 <link rel="stylesheet" href="../css/tlaciva.css">
<title>EuroSecom - Zoznam RZ dane z príjmu</title>
<style type="text/css">
.list-nav > h5 {
  padding: 6px 16px 5px 16px;
  font-size: 13px;
  color: #000;
  text-align: center;
  background-color: #fff;
  letter-spacing: .02em;
}
.list-nav > h4 {
  padding: 7px 16px 6px 16px;
  font-size: 11px;
  font-weight: bold;
  color: #000;
  text-align: center;
  background-color: #fff;
  letter-spacing: .02em;
}
.puntik {
  display: inline-block;
  width: 8px;
  height: 8px;
  background-color: #93ccde;
  border-radius: 50%;
  vertical-align: middle;
  margin-right: 8px;
}
.wrap-list {
  position: absolute;
  top: 72px;
  left: 50%;
  width: 1024px;
  margin-left: -512px;
  padding-bottom: 20px;
  height: calc(100% - 100px);
}
/* list layout */
.list th:nth-child(1), .list td:nth-child(1) {
  width: 48px;
  text-align: center;
}
.list th:nth-child(2), .list td:nth-child(2) {
  width: 240px;
  text-align: left;
}
.list th:nth-child(3), .list td:nth-child(3) {
  width: 70px;
  text-align: right;
}
.list th:nth-child(4), .list td:nth-child(4) {
  width: 80px;
  text-align: right;
}
.list th:nth-child(5), .list td:nth-child(5) {
  width: 70px;
  text-align: right;
}
.list th:nth-child(6), .list td:nth-child(6) {
  width: 70px;
  text-align: right;
}
.list th:nth-child(7), .list td:nth-child(7) {
  width: 70px;
  text-align: right;
}
.list th:nth-child(8), .list td:nth-child(8) {
  width: 80px;
  text-align: right;
}
.list th:nth-child(9), .list td:nth-child(9) {
  width: 70px;
  text-align: right;
}
.list th:nth-child(10), .list td:nth-child(10) {
  width: 80px;
  text-align: right;
}
.list th:nth-child(11), .list td:nth-child(11) {
  width: 80px;
  text-align: right;
}
.list th:nth-child(12), .list td:nth-child(12) {
  width: 48px;
  text-align: center;
}
.list {
  font-size: 12px;
  height: 100%;
  display: block;
}
.list tbody, .list thead {
  display: block;
  background-color: white;
}
.list tbody {
  overflow-y: auto;
  max-height: calc(100% - 60px);
}
.list tbody tr:not(:first-of-type) {
  border-top: 1px solid #e0e0e0;
  border-bottom: 1px solid #e0e0e0;
}

.list thead th {
  height: 16px;
  line-height: 16px;
  font-size: 11px;
  color: #999;
  padding: 8px 0 4px 0;
}
.list tbody tr:not(.last-row):hover {
  background-color: rgba(0,0,0,.10);
}
.list tbody td {
  height: 30px;
  line-height: 30px;
}

.list tbody td.rzclassano {
  background-color: #93ccde;
  font-weight: bold;
}
.list tbody img {
  position: relative;
  top: 4px;
  width: 16px;
  height: 16px;
  cursor: pointer;
}
.list tbody a { color: #000; }
.list tbody a:hover { color: #39f; }
.list .last-row td {
  height: 30px;
  line-height: 30px;
  padding-bottom: 0px;
  font-size: 11px;
  font-weight: bold;
  color: #999;
}
</style>
<script type="text/javascript">
//parameter okna
var param = 'scrollbars=yes,resizable=yes,top=0,left=0,width=1080,height=900';

//Rocne zuctovanie
  function TlacRZ( h_oc )
  {
   window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=10&drupoh=1&page=1&subor=0', '_blank', param);
  }
  function UpravRZ( h_oc )
  {
   window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=20&drupoh=1&page=1&subor=0', '_self');
  }
  function ZnovuRZ( h_oc )
  {
   window.open('../mzdy/rocne_dane<?php echo $rokrocnezuc; ?>.php?cislo_oc=' + h_oc + '&copern=26&drupoh=1&page=1&subor=0', '_self', param);
  }
  function TlacZoznamRZ()
  {
   window.open('../mzdy/rocne_danezoznam<?php echo $rokrocnezucz; ?>.php?copern=11&drupoh=1&page=1&subor=0', '_blank', param);
  }

  function ObnovUI()
  {
<?php if ( $cislo_oc > 0) { ?>
    document.getElementById('<?php echo $cislo_oc; ?>').scrollIntoView();
<?php } ?>
  }
</script>
</HEAD>
<BODY onload="ObnovUI();">
<div id="wrap-heading">
 <table id="heading">
 <tr>
  <td class="ilogin">EuroSecom</td>
  <td class="ilogin" align="right"><?php echo "<strong>UME</strong> $kli_vume&nbsp;&nbsp;<strong>FIR</strong> $kli_vxcf:$kli_nxcf&nbsp;&nbsp;<strong>login</strong> $kli_uzmeno $kli_uzprie / $kli_uzid";?></td>
 </tr>
 <tr>
  <td class="header">Roèné zúètovanie dane z príjmov - <span class="subheader">Zamestnanci</span></td>
  <td>
   <div class="bar-btn-form-tool">
    <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacZoznamRZ();" title="Zobrazi zoznam v PDF" class="btn-form-tool">
   </div>
  </td>
 </tr>
 </table>
</div>

<div class="wrap-list">
  <div class="list-nav" style="overflow: auto;">
    <h5 class="toleft">Zamestnanci</h5>
    <h4 class="toright"><span class="puntik"></span>Vykonané RZ</h4>
  </div>
<?php
//zoznam zamestnancov
if ( $copern != 11 )
     {
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   psys         INT(10),
   oc           INT(10),
   pomx         DECIMAL(10,0),
   vykx         DECIMAL(10,0),
   r00x         DECIMAL(10,2),
   r03x         DECIMAL(10,2),
   r04ax        DECIMAL(10,2),
   r06x         DECIMAL(10,2),
   r09x         DECIMAL(10,2),
   r11x         DECIMAL(10,2),
   r14x         DECIMAL(10,2),
   r15x         DECIMAL(10,2),
   r18x         DECIMAL(10,2),
   pop          VARCHAR(80)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,0,0,0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid,F$kli_vxcf"."_mzdrocnedane ".
" SET vykx=vyk, r00x=r00, r03x=r03, r04ax=r04a, r06x=r06, r09x=r09, r11x=r12-r13, r14x=r14, r15x=r15-r16, r18x=r18n-r18p  ".
" WHERE F$kli_vxcf"."_rzdanezoz$kli_uzid.oc=F$kli_vxcf"."_mzdrocnedane.oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid,F$kli_vxcf"."_mzdrocnedane ".
" SET r18x=0, r09x=0, r06x=0, r14x=0, r15x=0  ".
" WHERE vykx = 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 9,oc,0,SUM(vykx),SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r15x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY psys ";
$dsql = mysql_query("$dsqlt");
//exit;

$sqltt = "SELECT * FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc >= 0 "."ORDER BY psys,F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc ";
//echo $sqltt;
$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$strana=1;
$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
if ( $j == 0 ) { ?>
  <table class="list">
  <thead>
  <tr style="border-bottom: 1px solid lightblue;">
    <th>&nbsp;</th>
    <th>
      <span>Zamestnanec</span><br>
      <span style="position: relative; top: 4px;">Os.è.<span style="font-weight:normal;">&nbsp;Priezvisko Meno / pomer</span></span>
    </th>
    <th>Úhrn<br>príjmov<br>
<?php
if ( $kli_vrok >= 2017 ) { echo "R01"; }
if ( $kli_vrok < 2017 ) { echo "R00"; }
?>
    </th>
    <th>Základ<br>dane<br>R03</th>
    <th>Odpoè.<br>daòov.<br>R04a</th>
    <th>Daò<br>R06</th>
    <th>Zam.<br>prémia<br>R09</th>
    <th>Daò. bonus<br>Vypl / -Vybr<br>R12 / -R13</th>
    <th>Predd.<br>R14</th>
    <th>Daò.<br>Nedo/ -Prepl<br>R15 / -R16</th>
    <th>Nedo.<br>/ -Prepl.<br>R18n / -R18p</th>
    <th>&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php          }
//koniec j=0

//html nestrankuj
if ( $typ == 'HTML' ) $j=1;

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

//zvyrazni ano rz
$rzclass="rzclass";
if ( $polozka->vykx == 1 ) { $rzclass="rzclassano"; }
?>
<?php if ( $polozka->psys == 0 ) { ?>
  <tr id="<?php echo $polozka->oc; ?>">
    <td class="<?php echo $rzclass; ?>">
      <img src="../obr/ikony/printer_blue_icon.png" onclick="TlacRZ(<?php echo $polozka->oc;?>);" title="Zobrazi RZ v PDF">
    </td>
    <td class="<?php echo $rzclass; ?>">
      <a href="#" onclick="UpravRZ(<?php echo $polozka->oc; ?>);" title="Upravi RZ"><strong><?php echo $polozka->oc;?></strong>
      <?php echo "$polozka->prie $polozka->meno / $polozka->pom"; ?>&nbsp;&nbsp;<img src="../obr/ikony/pencil_blue_icon.png"></a>
    </td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r00x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r03x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r04ax; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r06x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r09x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r11x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r14x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r15x; ?></td>
    <td class="<?php echo $rzclass; ?>"><?php echo $polozka->r18x; ?></td>
    <td class="<?php echo $rzclass; ?>">
      <img src="../obr/ikony/download_blue_icon.png" onclick="ZnovuRZ(<?php echo $polozka->oc;?>);" title="Naèíta hodnoty z miezd">
    </td>
  </tr>

<?php                            }

if ( $polozka->psys == 9 ) {
$r00x=$polozka->r00x;
$r03x=$polozka->r03x;
$r04ax=$polozka->r04ax;
$r06x=$polozka->r06x;
$r09x=$polozka->r09x;
$r11x=$polozka->r11x;
$r14x=$polozka->r14x;
$r15x=$polozka->r15x;
$r18x=$polozka->r18x;
                           }
}
$i = $i + 1;
$j = $j + 1;
  }
     }
//koniec zoznamu
?>
  <tr class="last-row">
    <td>&nbsp;</td>
    <td>SPOLU</td>
    <td><?php echo $r00x; ?></td>
    <td><?php echo $r03x; ?></td>
    <td><?php echo $r04ax; ?></td>
    <td><?php echo $r06x; ?></td>
    <td><?php echo $r09x; ?></td>
    <td><?php echo $r11x; ?></td>
    <td><?php echo $r14x; ?></td>
    <td><?php echo $r15x; ?></td>
    <td><?php echo $r18x; ?></td>
    <td>&nbsp;</td>
  </tr>
  </tbody>
  </table>
</div><!-- .wrap-list -->
<?php
//tlac zoznamu pdf
if ( $copern == 11 )
{

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/zoznamrz_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/zoznamrz_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$pdf=new FPDF("L","mm","A4");
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$sqlt = <<<prcpendens
(
   psys         INT(10),
   oc           INT(10),
   pomx         DECIMAL(10,0),
   vykx         DECIMAL(10,0),
   r00x         DECIMAL(10,2),
   r03x         DECIMAL(10,2),
   r04ax        DECIMAL(10,2),
   r06x         DECIMAL(10,2),
   r09x         DECIMAL(10,2),
   r11x         DECIMAL(10,2),
   r14x         DECIMAL(10,2),
   r15x         DECIMAL(10,2),
   r18x         DECIMAL(10,2),
   pop          VARCHAR(80)
);
prcpendens;

$vsql = 'CREATE TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid.$sqlt;
$vytvor = mysql_query("$vsql");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 0,oc,0,0,0,0,0,0,0,0,0,0,0,'' ".
" FROM F$kli_vxcf"."_mzdkun".
" WHERE oc >= 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid,F$kli_vxcf"."_mzdrocnedane ".
" SET vykx=vyk, r00x=r00, r03x=r03, r04ax=r04a, r06x=r06, r09x=r09, r11x=r12-r13, r14x=r14, r15x=r15-r16, r18x=r18n-r18p  ".
" WHERE F$kli_vxcf"."_rzdanezoz$kli_uzid.oc=F$kli_vxcf"."_mzdrocnedane.oc";
$dsql = mysql_query("$dsqlt");

$dsqlt = "UPDATE F$kli_vxcf"."_rzdanezoz$kli_uzid,F$kli_vxcf"."_mzdrocnedane ".
" SET r18x=0, r09x=0, r06x=0, r14x=0, r15x=0  ".
" WHERE vykx = 0";
$dsql = mysql_query("$dsqlt");

$dsqlt = "INSERT INTO F$kli_vxcf"."_rzdanezoz$kli_uzid"." SELECT".
" 9,oc,0,SUM(vykx),SUM(r00x),SUM(r03x),SUM(r04ax),SUM(r06x),SUM(r09x),SUM(r11x),SUM(r14x),SUM(r15x),SUM(r18x),'' ".
" FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" WHERE oc >= 0 GROUP BY psys ";
$dsql = mysql_query("$dsqlt");

$sqltt = "SELECT * FROM F$kli_vxcf"."_rzdanezoz$kli_uzid".
" LEFT JOIN F$kli_vxcf"."_mzdkun".
" ON F$kli_vxcf"."_rzdanezoz$kli_uzid".".oc=F$kli_vxcf"."_mzdkun.oc".
" WHERE F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc >= 0 "."ORDER BY psys,F$kli_vxcf"."_rzdanezoz".$kli_uzid.".oc";
//echo $sqltt;

$tov = mysql_query("$sqltt");
$tvpol = mysql_num_rows($tov);
//exit;

$zostatokeur=0;
$zostatok=0;
$new=0;
$strana=0;
$j=0;
$i=0;
  while ($i <= $tvpol )
  {
  if (@$zaznam=mysql_data_seek($tov,$i))
{
$riadok=mysql_fetch_object($tov);
$dax_sk=SkDatum($riadok->dax);

//hlavicka strany
if ( $j == 0 )
     {
$pdf->AddPage();
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
$strana=$strana+1;
$pdf->SetFont('arial','',10);

if ( $copern == 11 ) { $pdf->Cell(90,6,"Zoznam RZ $kli_vrok ","LTB",0,"L"); }
$pdf->Cell(0,6,"$kli_nxcf strana $strana","RTB",1,"R");
$pdf->SetFont('arial','',7);

if ( $copern == 11 ) {
$pdf->Cell(10,3.5," ","TLR",0,"C");$pdf->Cell(62,3.5,"Zamestnanec","TR",0,"C");$pdf->Cell(25,3.5,"Úhrn príjmov","TR",0,"C");$pdf->Cell(25,3.5,"Základ dane","TR",0,"C");
$pdf->Cell(20,3.5,"NÈZD","TR",0,"C");$pdf->Cell(20,3.5,"Daò","TR",0,"C");$pdf->Cell(20,3.5,"Zam. prémia","TR",0,"C");$pdf->Cell(20,3.5,"Bonus","TR",0,"C");
$pdf->Cell(25,3.5,"Preddavky","TR",0,"C");$pdf->Cell(25,3.5,"Daò. Nedo/ -Preplatok","TR",0,"C");$pdf->Cell(0,3.5,"Nedo/ -Preplatok","TR",1,"R");
$pdf->Cell(10,3.5,"RZ","LBR",0,"C");$pdf->Cell(62,3.5,"Os.è. Priezvisko Meno","LBR",0,"C");$pdf->Cell(25,3.5,"R00","BR",0,"C");$pdf->Cell(25,3.5,"R03","BR",0,"C");
$pdf->Cell(20,3.5,"R04a","BR",0,"C");$pdf->Cell(20,3.5,"R06","BR",0,"C");$pdf->Cell(20,3.5,"R09","BR",0,"C");$pdf->Cell(20,3.5,"R12/ -R13","BR",0,"C");
$pdf->Cell(25,3.5,"R14","BR",0,"C");$pdf->Cell(25,3.5,"R15/ -R16","BR",0,"C");$pdf->Cell(0,3.5,"R18n/ -R18p","BR",1,"C");
                     }
     }
//koniec hlavicky j=0

if ( $riadok->psys == 0 AND $drupoh == 1 )
{
$pdf->SetFont('arial','',9);
$vykrz="N";

if ( $riadok->vykx == 1 ) { $vykrz="A"; }
$pdf->Cell(10,5,"$vykrz","0",0,"C");$pdf->Cell(62,5,"$riadok->oc $riadok->prie $riadok->meno","0",0,"L");$pdf->Cell(25,5,"$riadok->r00x","0",0,"R");
$pdf->Cell(25,5,"$riadok->r03x","0",0,"R");$pdf->Cell(20,5,"$riadok->r04ax","0",0,"R");$pdf->Cell(20,5,"$riadok->r06x","0",0,"R");
$pdf->Cell(20,5,"$riadok->r09x","0",0,"R");$pdf->Cell(20,5,"$riadok->r11x","0",0,"R");$pdf->Cell(25,5,"$riadok->r14x","0",0,"R");
$pdf->Cell(25,5,"$riadok->r15x","0",0,"R");$pdf->Cell(0,5,"$riadok->r18x","0",1,"R");
}

if ( $riadok->psys == 9 AND $drupoh == 1 )
{
$pdf->SetFont('arial','',8);
$pdf->Cell(72,5,"CELKOM","T",0,"L");$pdf->Cell(25,5,"$riadok->r00x","T",0,"R");$pdf->Cell(25,5,"$riadok->r03x","T",0,"R");
$pdf->Cell(20,5,"$riadok->r04ax","T",0,"R");$pdf->Cell(20,5,"$riadok->r06x","T",0,"R");$pdf->Cell(20,5,"$riadok->r09x","T",0,"R");
$pdf->Cell(20,5,"$riadok->r11x","T",0,"R");$pdf->Cell(25,5,"$riadok->r14x","T",0,"R");$pdf->Cell(25,5,"$riadok->r15x","T",0,"R");
$pdf->Cell(0,5,"$riadok->r18x","T",1,"R");
}

}
$i = $i + 1;
$j = $j + 1;
if ( $j > 38 ) $j=0;
  }

$pdf->Output("$outfilex");

$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcx'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_mzdprcu'.$kli_uzid;
$vysledok = mysql_query("$sqlt");
?>

<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>

<?php
}
//koniec tlac zoznamu
?>

<?php
$sqlt = 'DROP TABLE F'.$kli_vxcf.'_rzdanezoz'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>