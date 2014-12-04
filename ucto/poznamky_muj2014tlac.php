<HTML>
<?php
//celkovy zaciatok dokumentu
do
{
$sys = 'UCT';
$urov = 2000;
$uziv = include("../uziv.php");
if ( !$uziv ) exit;
if (!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

//ramcek fpdf 1=zap,0=vyp
$rmc=0;
$rmc1=0;

//$zablokovane=1;
if ( $_SERVER['SERVER_NAME'] == "localhost" ) { $zablokovane=0; }
if ( $zablokovane == 1 )
     {
?>
<script type="text/javascript">
alert ("Pozn·mky bud˙ pripravenÈ v priebehu janu·ra 2015. Aktu·lne info n·jdete na vstupnej str·nke v bode Novinky, tipy, triky.");
window.close();
</script>
<?php
exit;
     }

//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawic + ', height=' + vyskawic + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

$citfir = include("../cis/citaj_fir.php");
$citnas = include("../cis/citaj_nas.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$strana = 1*$_REQUEST['strana'];
if ( $strana == 0 ) $strana=1;
$urobxml = 1*$_REQUEST['urobxml'];

//$strana=25;

$dopoz = 1*$_REQUEST['dopoz'];
if ( $copern == 1 ) $dopoz=1;

$no="";

$h_drp = $_REQUEST['h_drp'];
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Pozn·mky PO 2013</title>

<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;
</script>
<script type='text/javascript'>
                    
                    
  function ukazrobot()
  {                 
  <?php echo "robotokno.style.display=''; robotmenu.style.display='none';";  ?>
  myRobot = document.getElementById("robotokno");
  myRobotmenu = document.getElementById("robotmenu");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  myRobotmenu.style.top = toprobotmenu;
  myRobotmenu.style.left = leftrobotmenu;
  }                 
                    
  function zhasnirobot()
  {                 
  robotokno.style.display='none';
  robotmenu.style.display='none';
  }                 
                    
  function zobraz_robotmenu()
  {                 
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
<?php if( $dopoz == 1 ) { ?>
  document.emzdy.dopoz.checked = "checked";
<?php                   } ?>
  }                 
                    
  function zhasni_menurobot()
  {                 
   robotmenu.style.display='none';
  }                 
                    
function NacitajMzdy()
                {
var h_mfir = document.forms.emzdy.h_mfir.value;
var dopoz = 0;
if( document.emzdy.dopoz.checked ) dopoz=1;

window.open('../ucto/poznamky_muj2014nacitaj.php?h_mfir=' + h_mfir + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=10101&vyb_ume=<?php echo $vyb_umk; ?>&dopoz=' + dopoz + '&xxc=1', '_self' );
                }


function NacitajPol( premx )
                {
var ucm1 = document.forms.enast.h_ucm1.value;
var ucm2 = document.forms.enast.h_ucm2.value;
var ucm3 = document.forms.enast.h_ucm3.value;
var ucm4 = document.forms.enast.h_ucm4.value;
var ucm5 = document.forms.enast.h_ucm5.value;
var ico1 = document.forms.enast.h_ico1.value;
var ico2 = document.forms.enast.h_ico2.value;
var ico3 = document.forms.enast.h_ico3.value;
var ico4 = document.forms.enast.h_ico4.value;
var ico5 = document.forms.enast.h_ico5.value;
var premenna = premx;
var zmd = 0;
if( document.enast.zmd.checked ) zmd=1;
var zdl = 0;
if( document.enast.zdl.checked ) zdl=1;
var omd = 0;
if( document.enast.omd.checked ) omd=1;
var odl = 0;
if( document.enast.odl.checked ) odl=1;
var pmd = 0;
if( document.enast.pmd.checked ) pmd=1;
var pdl = 0;
if( document.enast.pdl.checked ) pdl=1;
var mnl = 0;
if( document.enast.mnl.checked ) mnl=1;

window.open('../ucto/poznamky_muj2014nacitaj.php?h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&mnl=' + mnl + '&premenna=' + premenna + '&copern=900&drupoh=1&page=1&strana=<?php echo $strana; ?>', '_self' );
                }

function UrobSubor()
                {
window.open('../ucto/poznamky_muj2014nacitaj.php?&copern=901&drupoh=1&page=1&strana=<?php echo $strana; ?>&dopoz=1', '_self' );
                }




//robotmenu

    var toprobot = 200;
    var leftrobot = 40;
    var toprobotmenu = 160;
    var leftrobotmenu = 100;
    var widthrobotmenu = 600;
                    
    var htmlmenu = "<FORM name='emzdy' method='post' action='#' ><table  class='ponuka' width='100%'><tr><td width='80%'>Menu EkoRobot</td>" +
    "<td width='20%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  
                     

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 402 );\">" +
"Chcete naËÌtaù ˙daje o z·v‰zkoch zo saldokonta ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 999 );\">" +
"Chcete naËÌtaù ˙daje o bezprostredne predch·dzaj˙com obdobÌ z Pozn·mok PO 2013 z firmy minulÈho roka ?</a>";
    htmlmenu += "</td></tr>";
                    
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>";
htmlmenu += "<a href=\"#\" onClick=\"NacitajMzdy();\">" +
"Chcete naËÌtaù ˙daje o poËte zamestnancov z miezd firma ËÌslo</a> ";
    htmlmenu += "<input type='text' name='h_mfir' id='h_mfir' size='2' maxlenght='4' value='<?php echo $kli_vxcf; ?>' >"; 
    htmlmenu += " ?</td></tr>";

    htmlmenu += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenu += " <img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='UrobSubor();' alt='Vytvorenie s˙boru, z ktorÈho naËÌtate hodnoty (staËÌ jeden kr·t klikn˙ù)' > S˙bor"; 
    htmlmenu += "<td class='ponuka' colspan='1'>Po naËÌtanÌ nasp‰ù <input type='checkbox' name='dopoz' value='1' >"; 
    htmlmenu += " </td></tr>";

    htmlmenu += "</table></FORM>"; 

  function NacitajHodnotu( riadok )
  {
   var dopoz = 0;
   if ( document.emzdy.dopoz.checked ) dopoz=1;
   window.open('../ucto/poznamky_muj2014nacitaj.php?copern=' + riadok + '&drupoh=1&page=1&dopoz=' + dopoz + '&xxc=1', '_self');
  }
</script>
<script type="text/javascript" src="poznamky_po2011js.js"></script>
</HEAD>
<BODY class="white" onload="<?php if( $copern == 1 ) { echo 'ukazrobot();'; } ?>
<?php if( $copern == 1 AND $dopoz == 1 ) { echo ' zobraz_robotmenu();'; } ?>"  >
<table class="h2" width="100%" >
<tr>
  <td>EuroSecom  -  Pozn·mky MUJ v.2014 </td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 160; left: 90; width:200; height:100;">
zobrazene menu
</div>

<?php
//nacitaj
if ( $copern == 1  )
        {
?>  
<table class="thead" width="100%">
<FORM name="formv1" method="post" action="#" >
<tr>
  <td class="bmenu"  align="right"></td>
  <td class="bmenu" ><input type="hidden" name="m405r41" id="m405r41" size="55"  /></td>
</tr>
</FORM>
<?php
//koniec nacitaj
        }
?> 

    
<table class="thead" width="100%">
<FORM name="formv1" class="obyc" method="post" action="statistika_r101.php?copern=3&strana=<?php echo "$strana";?>" >

<?php
//zostava PDF
if ( $copern == 10 )
     {
if ( File_Exists("../tmp/poznamky.$kli_uzid.pdf") ) { $soubor = unlink("../tmp/poznamky.$kli_uzid.pdf"); }
     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac


$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014$no WHERE psys >= 0 ".""; 
//echo $sqltt;
//exit;

$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; 

//zaciatok strany ak by som chcel strankovat
  while ($i <= $pol )
  {
  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);


if ( $strana == 1 OR $strana == 9999 ) {

//strana 1
$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/muj2014/uzmuj_v14-1.jpg',0,0,210,297);
}

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

$pole = explode(".", $kli_vume);
$kli_mdph=$pole[0];
$kli_rdph=$pole[1];
if ( $kli_mdph < 10 ) $kli_mdph="0".$kli_mdph;

$pole = explode(".", $kli_vume);
$mesp_dph=$pole[0];
$mesk_dph=$pole[0];
$rokp_dph=$pole[1];

$datp_dph=$rokp_dph.'-'.$mesp_dph.'-01';
$datk_dph=$rokp_dph.'-'.$mesk_dph.'-01';

$ttvv = "INSERT INTO prcdatum".$kli_uzid." ( datp,datk,fic ) VALUES ( '$datp_dph', '$datp_dph', 0 )";
$ttqq = mysql_query("$ttvv");


$dsqlt = "UPDATE prcdatum".$kli_uzid.
" SET datp='$datp_dph',  datk=LAST_DAY('$datk_dph')".
" WHERE fic >= 0 ".
"";
$dsql = mysql_query("$dsqlt");

$sql = mysql_query("SELECT * FROM prcdatum$kli_uzid");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datp_dph=$riadok->datp;
  $datk_dph=$riadok->datk;
  }
$sqlt = 'DROP TABLE prcdatum'.$kli_uzid;
$vysledok = mysql_query("$sqlt");

$datp_sk=SkDatum($datp_dph);
$datk_sk=SkDatum($datk_dph);

//nacitaj uzavierka k datumu z ufirdalsie
$datksk="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datksk=SkDatum($riadok->datk);
  }
if ( $datksk != '' AND $datksk != '00.00.0000' ) { $datk_sk=$datksk; }

//zostavena k
$pdf->Cell(190,15," ","$rmc1",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(84,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,28," ","$rmc1",1,"L");
$textxx="1234567890";
$text=$fir_fdic;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",1,"C");

//ico
$pdf->Cell(190,7," ","$rmc1",1,"L");
$textxx="12345678";
$text=$fir_fico;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//sknace
$pdf->Cell(190,7," ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
//$sn2c=substr($sknacec,1,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
$pdf->SetFont('arial','',10);
$riadna=""; $mimor=""; $priebez="";
if ( $h_drp == 1 ) { $riadna="x"; }
if ( $h_drp == 2 ) { $mimor="x"; }
if ( $h_drp == 3 ) { $priebez="x"; }
if ( $h_zos != '' )
{
$krizzos="x";
if ( trim($h_sch) != '' ) { $krizzos=" "; }
}
if ( $h_sch != '' )
{
$krizsch="x";
}
$pdf->SetY(62);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$riadna","$rmc",0,"C");
$pdf->SetY(71);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$mimor","$rmc",0,"C");
$pdf->SetY(80);
$pdf->Cell(82,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$priebez","$rmc",0,"C");
$pdf->SetFont('arial','',12);

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.".$kli_vmesx.".".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);

if ( $riadok->datbod != '0000-00-00' )
     {
  $datbodsk=SkDatum($riadok->datbod);
  $datbdosk=SkDatum($riadok->datbdo);
  $datmodsk=SkDatum($riadok->datmod);
  $datmdosk=SkDatum($riadok->datmdo);
     }
  }

$poleb = explode(".", $datbodsk);
$obdd1=$poleb[0];
$obdm1=$poleb[1];
$obdr1=$poleb[2];
$poleb = explode(".", $datbdosk);
$obdd2=$poleb[0];
$obdm2=$poleb[1];
$obdr2=$poleb[2];
$poleb = explode(".", $datmodsk);
$obmd1=$poleb[0];
$obmm1=$poleb[1];
$obmr1=$poleb[2];
$poleb = explode(".", $datmdosk);
$obmd2=$poleb[0];
$obmm2=$poleb[1];
$obmr2=$poleb[2];

$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;

//za obdobie
$me1="0"; $me2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$me1=substr($obdm1,0,1);
$me2=substr($obdm1,1,1);
}
$C=substr($kli_rdph,2,1);
$D=substr($kli_rdph,3,1);
$pdf->SetY(58);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$me1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$Am=substr($kli_mdph,0,1);
$Bm=substr($kli_mdph,1,1);
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$Am=substr($obdm2,0,1);
$Bm=substr($obdm2,1,1);
}
$pdf->SetY(67);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$Am","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$Bm","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//predchadzajuce obdobie
$mep1="0"; $mep2="1";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mep1=substr($obmm1,0,1);
$mep2=substr($obmm1,1,1);
}
$kli_prdph=$kli_rdph-1;
$C=substr($kli_prdph,2,1);
$D=substr($kli_prdph,3,1);
$pdf->SetY(76);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$mep1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$mep2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");

$mepm1="1"; $mepm2="2";
if ( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 )
{
$mepm1=substr($obmm2,0,1);
$mepm2=substr($obmm2,1,1);
}
$pdf->SetY(85);
$pdf->Cell(156,5," ","$rmc1",0,"R");$pdf->Cell(5,6,"$mepm1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(3,6,"$mepm2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",1,"C");


//nazov
$pdf->Cell(190,22," ","$rmc1",1,"L");
$A=substr($fir_fnaz,0,1);
$B=substr($fir_fnaz,1,1);
$C=substr($fir_fnaz,2,1);
$D=substr($fir_fnaz,3,1);
$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);
$G=substr($fir_fnaz,6,1);
$H=substr($fir_fnaz,7,1);
$I=substr($fir_fnaz,8,1);
$J=substr($fir_fnaz,9,1);
$K=substr($fir_fnaz,10,1);
$L=substr($fir_fnaz,11,1);
$M=substr($fir_fnaz,12,1);
$N=substr($fir_fnaz,13,1);
$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);
$R=substr($fir_fnaz,16,1);
$S=substr($fir_fnaz,17,1);
$T=substr($fir_fnaz,18,1);
$U=substr($fir_fnaz,19,1);
$V=substr($fir_fnaz,20,1);
$W=substr($fir_fnaz,21,1);
$X=substr($fir_fnaz,22,1);
$Y=substr($fir_fnaz,23,1);
$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);
$B1=substr($fir_fnaz,26,1);
$C1=substr($fir_fnaz,27,1);
$D1=substr($fir_fnaz,28,1);
$E1=substr($fir_fnaz,29,1);
$F1=substr($fir_fnaz,30,1);
$G1=substr($fir_fnaz,31,1);
$H1=substr($fir_fnaz,32,1);
$I1=substr($fir_fnaz,33,1);
$J1=substr($fir_fnaz,34,1);
$K1=substr($fir_fnaz,35,1);
$L1=substr($fir_fnaz,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//nazov r2
$fir_fnazr2="";
$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_fnazr2=substr($fir_fnaz,37,36);
$A=substr($fir_fnazr2,0,1);
$B=substr($fir_fnazr2,1,1);
$C=substr($fir_fnazr2,2,1);
$D=substr($fir_fnazr2,3,1);
$E=substr($fir_fnazr2,4,1);
$F=substr($fir_fnazr2,5,1);
$G=substr($fir_fnazr2,6,1);
$H=substr($fir_fnazr2,7,1);
$I=substr($fir_fnazr2,8,1);
$J=substr($fir_fnazr2,9,1);
$K=substr($fir_fnazr2,10,1);
$L=substr($fir_fnazr2,11,1);
$M=substr($fir_fnazr2,12,1);
$N=substr($fir_fnazr2,13,1);
$O=substr($fir_fnazr2,14,1);
$P=substr($fir_fnazr2,15,1);
$R=substr($fir_fnazr2,16,1);
$S=substr($fir_fnazr2,17,1);
$T=substr($fir_fnazr2,18,1);
$U=substr($fir_fnazr2,19,1);
$V=substr($fir_fnazr2,20,1);
$W=substr($fir_fnazr2,21,1);
$X=substr($fir_fnazr2,22,1);
$Y=substr($fir_fnazr2,23,1);
$Z=substr($fir_fnazr2,24,1);
$A1=substr($fir_fnazr2,25,1);
$B1=substr($fir_fnazr2,26,1);
$C1=substr($fir_fnazr2,27,1);
$D1=substr($fir_fnazr2,28,1);
$E1=substr($fir_fnazr2,29,1);
$F1=substr($fir_fnazr2,30,1);
$G1=substr($fir_fnazr2,31,1);
$H1=substr($fir_fnazr2,32,1);
$I1=substr($fir_fnazr2,33,1);
$J1=substr($fir_fnazr2,34,1);
$K1=substr($fir_fnazr2,35,1);
$L1=substr($fir_fnazr2,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//Sidlo uctovej jednotky
//ulica
$pdf->Cell(190,13," ","$rmc1",1,"L");
$textxx="ABCDEFGHIJKLMNOPRSTUVXYZ1234";
$text=$fir_fuli;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t28","$rmc",0,"C");

//cislo
$textxx="111122";
$text=$fir_fcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,7," ","$rmc1",1,"L");
$text=$fir_fpsc;
$textxx="12345";
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text=$fir_fmes;
$textxx="ABCDEFGHIJKLMNOPRSTU";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$t09=substr($text,8,1);
$t10=substr($text,9,1);
$t11=substr($text,10,1);
$t12=substr($text,11,1);
$t13=substr($text,12,1);
$t14=substr($text,13,1);
$t15=substr($text,14,1);
$t16=substr($text,15,1);
$t17=substr($text,16,1);
$t18=substr($text,17,1);
$t19=substr($text,18,1);
$t20=substr($text,19,1);
$t21=substr($text,20,1);
$t22=substr($text,21,1);
$t23=substr($text,22,1);
$t24=substr($text,23,1);
$t25=substr($text,24,1);
$t26=substr($text,25,1);
$t27=substr($text,26,1);
$t28=substr($text,27,1);
$t29=substr($text,28,1);
$t30=substr($text,29,1);
$t31=substr($text,30,1);
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t31","$rmc",1,"C");

//obchodny register
$pdf->Cell(190,7," ","$rmc1",1,"L");
$A=substr($fir_obreg,0,1);
$B=substr($fir_obreg,1,1);
$C=substr($fir_obreg,2,1);
$D=substr($fir_obreg,3,1);
$E=substr($fir_obreg,4,1);
$F=substr($fir_obreg,5,1);
$G=substr($fir_obreg,6,1);
$H=substr($fir_obreg,7,1);
$I=substr($fir_obreg,8,1);
$J=substr($fir_obreg,9,1);
$K=substr($fir_obreg,10,1);
$L=substr($fir_obreg,11,1);
$M=substr($fir_obreg,12,1);
$N=substr($fir_obreg,13,1);
$O=substr($fir_obreg,14,1);
$P=substr($fir_obreg,15,1);
$R=substr($fir_obreg,16,1);
$S=substr($fir_obreg,17,1);
$T=substr($fir_obreg,18,1);
$U=substr($fir_obreg,19,1);
$V=substr($fir_obreg,20,1);
$W=substr($fir_obreg,21,1);
$X=substr($fir_obreg,22,1);
$Y=substr($fir_obreg,23,1);
$Z=substr($fir_obreg,24,1);
$A1=substr($fir_obreg,25,1);
$B1=substr($fir_obreg,26,1);
$C1=substr($fir_obreg,27,1);
$D1=substr($fir_obreg,28,1);
$E1=substr($fir_obreg,29,1);
$F1=substr($fir_obreg,30,1);
$G1=substr($fir_obreg,31,1);
$H1=substr($fir_obreg,32,1);
$I1=substr($fir_obreg,33,1);
$J1=substr($fir_obreg,34,1);
$K1=substr($fir_obreg,35,1);
$L1=substr($fir_obreg,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//
$pdf->Cell(190,3," ","$rmc1",1,"L");
$fir_obregr2="";
$A=substr($fir_obregr2,0,1);
$B=substr($fir_obregr2,1,1);
$C=substr($fir_obregr2,2,1);
$D=substr($fir_obregr2,3,1);
$E=substr($fir_obregr2,4,1);
$F=substr($fir_obregr2,5,1);
$G=substr($fir_obregr2,6,1);
$H=substr($fir_obregr2,7,1);
$I=substr($fir_obregr2,8,1);
$J=substr($fir_obregr2,9,1);
$K=substr($fir_obregr2,10,1);
$L=substr($fir_obregr2,11,1);
$M=substr($fir_obregr2,12,1);
$N=substr($fir_obregr2,13,1);
$O=substr($fir_obregr2,14,1);
$P=substr($fir_obregr2,15,1);
$R=substr($fir_obregr2,16,1);
$S=substr($fir_obregr2,17,1);
$T=substr($fir_obregr2,18,1);
$U=substr($fir_obregr2,19,1);
$V=substr($fir_obregr2,20,1);
$W=substr($fir_obregr2,21,1);
$X=substr($fir_obregr2,22,1);
$Y=substr($fir_obregr2,23,1);
$Z=substr($fir_obregr2,24,1);
$A1=substr($fir_obregr2,25,1);
$B1=substr($fir_obregr2,26,1);
$C1=substr($fir_obregr2,27,1);
$D1=substr($fir_obregr2,28,1);
$E1=substr($fir_obregr2,29,1);
$F1=substr($fir_obregr2,30,1);
$G1=substr($fir_obregr2,31,1);
$H1=substr($fir_obregr2,32,1);
$I1=substr($fir_obregr2,33,1);
$J1=substr($fir_obregr2,34,1);
$K1=substr($fir_obregr2,35,1);
$L1=substr($fir_obregr2,36,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//cislo telefonu
$pdf->Cell(190,6," ","$rmc1",1,"L");
$t01=substr($fir_ftel,0,1);
$t02=substr($fir_ftel,1,1);
$t03=substr($fir_ftel,2,1);
$t04=substr($fir_ftel,3,1);
$t05=substr($fir_ftel,4,1);
$t06=substr($fir_ftel,5,1);
$t07=substr($fir_ftel,6,1);
$t08=substr($fir_ftel,7,1);
$t09=substr($fir_ftel,8,1);
$t10=substr($fir_ftel,9,1);
$t11=substr($fir_ftel,10,1);
$t12=substr($fir_ftel,11,1);
$t13=substr($fir_ftel,12,1);
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",0,"C");

//cislo faxu
$t01=substr($fir_ffax,0,1);
$t02=substr($fir_ffax,1,1);
$t03=substr($fir_ffax,2,1);
$t04=substr($fir_ffax,3,1);
$t05=substr($fir_ffax,4,1);
$t06=substr($fir_ffax,5,1);
$t07=substr($fir_ffax,6,1);
$t08=substr($fir_ffax,7,1);
$t09=substr($fir_ffax,8,1);
$t10=substr($fir_ffax,9,1);
$t11=substr($fir_ffax,10,1);
$t12=substr($fir_ffax,11,1);
$t13=substr($fir_ffax,12,1);
$pdf->Cell(7,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t10","$rmc",0,"L");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"L");$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(5,7,"$t12","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t13","$rmc",1,"C");

//email
$pdf->Cell(190,6," ","$rmc1",1,"L");
$fir_fulicis=$fir_fem1;
$A=substr($fir_fulicis,0,1);
$B=substr($fir_fulicis,1,1);
$C=substr($fir_fulicis,2,1);
$D=substr($fir_fulicis,3,1);
$E=substr($fir_fulicis,4,1);
$F=substr($fir_fulicis,5,1);
$G=substr($fir_fulicis,6,1);
$H=substr($fir_fulicis,7,1);
$I=substr($fir_fulicis,8,1);
$J=substr($fir_fulicis,9,1);
$K=substr($fir_fulicis,10,1);
$L=substr($fir_fulicis,11,1);
$M=substr($fir_fulicis,12,1);
$N=substr($fir_fulicis,13,1);
$O=substr($fir_fulicis,14,1);
$P=substr($fir_fulicis,15,1);
$R=substr($fir_fulicis,16,1);
$S=substr($fir_fulicis,17,1);
$T=substr($fir_fulicis,18,1);
$U=substr($fir_fulicis,19,1);
$V=substr($fir_fulicis,20,1);
$W=substr($fir_fulicis,21,1);
$X=substr($fir_fulicis,22,1);
$Y=substr($fir_fulicis,23,1);
$Z=substr($fir_fulicis,24,1);
$A1=substr($fir_fulicis,25,1);
$B1=substr($fir_fulicis,26,1);
$C1=substr($fir_fulicis,27,1);
$D1=substr($fir_fulicis,28,1);
$E1=substr($fir_fulicis,29,1);
$pdf->Cell(1,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$L1","$rmc",1,"C");

//datum zostavenia
$pdf->Cell(190,9," ","$rcm1",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(1,6," ","$rcm1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(3,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(14,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");

//datum schvalenia
$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(5,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rcm1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t06","$rmc",1,"C");

//odkaz na datum uzavierky k
//podla mna zbytocne
$pdf->SetY(25);
$pdf->SetX(60);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(60);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);

//odkaz na uctovne obdobia
$pdf->SetY(55);

$odkaz="../cis/ufirdalsie.php?copern=202";
if( $_SESSION['chrome'] == 1 ) {
$odkaz=$_SERVER['SERVER_NAME']."/cis/ufirdalsie.php?copern=202";
                               }

$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
$pdf->SetX(130);$pdf->Cell(85,5,"                                                                                               ","0",1,"L",0,$odkaz);
//koniec prva strana

                                       } //koniec strana 1

//ico
$text=$fir_fico;
$ico01=substr($text,0,1);
$ico02=substr($text,1,1);
$ico03=substr($text,2,1);
$ico04=substr($text,3,1);
$ico05=substr($text,4,1);
$ico06=substr($text,5,1);
$ico07=substr($text,6,1);
$ico08=substr($text,7,1);

//dic
$text=$fir_fdic;
$dic01=substr($text,0,1);
$dic02=substr($text,1,1);
$dic03=substr($text,2,1);
$dic04=substr($text,3,1);
$dic05=substr($text,4,1);
$dic06=substr($text,5,1);
$dic07=substr($text,6,1);
$dic08=substr($text,7,1);
$dic09=substr($text,8,1);
$dic10=substr($text,9,1);

    function vytlactextx($ktorytext, $mysqlhostx, $mysqluserx, $mysqlpasswdx, $mysqldbx, $kli_vxcf)
    {
  @$spojeni = mysql_connect($mysqlhostx, $mysqluserx, $mysqlpasswdx);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldbx);

$ozntext=$ktorytext;
$textvypis="";
$sqlttt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014texty WHERE ozntxt = '$ozntext' ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $textvypis=$riaddok->hdntxt;
 }

    return $textvypis;
    }

$nopg2=0;$nopg3=0;$nopg4=0;$nopg5=0;$nopg6=0; 

//strana 2
$stranax=1;

if ( $nopg2 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2014/poznamkymuj2014tabtext/poznamkymuj_tab101.jpg') AND $hlavicka->tlt101 == 1 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2014/poznamkymuj2014tabtext/poznamkymuj_tab101.jpg',0,200,210,40);
}

$stranax=$stranax+1;
//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(38,7,"Pozn·mky ⁄Ë M⁄J 3 - 04","1",0,"L");
$pdf->Cell(10,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(10,7," ","$rmc1",0,"L");

$pdf->Cell(8,7,"I»O","$rmc1",0,"L");
$pdf->Cell(4,7,"$ico01","1",0,"L");
$pdf->Cell(4,7,"$ico02","1",0,"L");
$pdf->Cell(4,7,"$ico03","1",0,"L");
$pdf->Cell(4,7,"$ico04","1",0,"L");
$pdf->Cell(4,7,"$ico05","1",0,"L");
$pdf->Cell(4,7,"$ico06","1",0,"L");
$pdf->Cell(4,7,"$ico07","1",0,"L");
$pdf->Cell(4,7,"$ico08","1",0,"L");

$pdf->Cell(8,7,"DI»","$rmc1",0,"L");
$pdf->Cell(4,7,"$dic01","1",0,"L");
$pdf->Cell(4,7,"$dic02","1",0,"L");
$pdf->Cell(4,7,"$dic03","1",0,"L");
$pdf->Cell(4,7,"$dic04","1",0,"L");
$pdf->Cell(4,7,"$dic05","1",0,"L");
$pdf->Cell(4,7,"$dic06","1",0,"L");
$pdf->Cell(4,7,"$dic07","1",0,"L");
$pdf->Cell(4,7,"$dic08","1",0,"L");
$pdf->Cell(4,7,"$dic09","1",0,"L");
$pdf->Cell(4,7,"$dic10","1",1,"L");
$pdf->Cell(190,8,"                          ","$rmc1",1,"L");
$pdf->SetFont('arial','',10);
$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"»l.1 VöeobecnÈ ˙daje","$rmc",1,"L");


$pdf->Cell(90,10,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.1.1 N·zov pr·vnickej osoby a jej sÌdlo alebo meno a priezvisko fyzickej osoby.","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$nazovsidlo=$fir_fnaz.", ".$fir_fuli." ".$fir_fcdm.", ".$fir_fmes.", ".$fir_fpsc;
if ( $fir_uctt03 == 999 ) {
$sqlfir = "SELECT * FROM F$kli_vxcf"."_ufirdalsie ";
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }
$nazovsidlo=$fir_riadok->dmeno." ".$fir_riadok->dprie;                         }

$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"$nazovsidlo","$rmc",1,"L");

$pdf->Cell(90,10,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.1.2 ⁄daje o konsolidovanom celku.","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

//pocet zamestnancov
if ( $hlavicka->ac11 == 0 ) $hlavicka->ac11="";
if ( $hlavicka->ac12 == 0 ) $hlavicka->ac12="";
if ( $hlavicka->ac21 == 0 ) $hlavicka->ac21="";
if ( $hlavicka->ac22 == 0 ) $hlavicka->ac22="";
if ( $hlavicka->ac31 == 0 ) $hlavicka->ac31="";
if ( $hlavicka->ac32 == 0 ) $hlavicka->ac32="";
$hlavicka->ac11nyg46nyg46nyg46="1234.56";
$hlavicka->ac12nyg46nyg46nyg46="1234.56";
$hlavicka->ac21nyg46nyg46nyg46="1234.56";
$hlavicka->ac22nyg46nyg46nyg46="1234.56";
$hlavicka->ac31nyg46nyg46nyg46="1234.56";
$hlavicka->ac32nyg46nyg46nyg46="1234.56";

$pdf->Cell(90,120,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(10,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"»l.1.3 Priemern˝ prepoËÌtan˝ poËet zamestnancov.","$rmc",1,"L");
$pdf->Cell(90,12,"     ","$rmc1",1,"L");

$yA_text2=206;
if ( $hlavicka->tlt101 == 1 )
{
$pdf->SetFont('arial','',9);
$pdf->Cell(82,6,"     ","$rmc1",0,"L");$pdf->Cell(47,6,"$hlavicka->ac11","$rmc",0,"R");$pdf->Cell(48,6,"$hlavicka->ac12","$rmc",1,"R");
$pdf->Cell(82,5,"     ","$rmc1",0,"L");$pdf->Cell(47,10,"$hlavicka->ac21","$rmc",0,"R");$pdf->Cell(48,10,"$hlavicka->ac22","$rmc",1,"R");
$pdf->Cell(82,5,"     ","$rmc1",0,"L");$pdf->Cell(47,7,"$hlavicka->ac31","$rmc",0,"R");$pdf->Cell(48,7,"$hlavicka->ac32","$rmc",1,"R");

$yA_text2=240;
}

$pdf->SetFont('arial','',8);
$ozntext="A_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(70);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(10,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="A_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY($yA_text2);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(10,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 2






}
$i = $i + 1;

  }

$pdf->Output("../tmp/poznamky.$kli_uzid.pdf");


if( $urobxml == 0 ) {
?> 
<script type="text/javascript">
  var okno = window.open("../tmp/poznamky.<?php echo $kli_uzid; ?>.pdf","_self");
</script>
<?php
                    }
     }
//koniec zostava PDF copern=11

?>




<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>