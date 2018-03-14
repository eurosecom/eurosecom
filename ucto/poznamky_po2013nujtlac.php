<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'UCT';
$urov = 2000;
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
if( $strana == 0 ) $strana=1;

//$strana=25;

$dopoz = 1*$_REQUEST['dopoz'];
if( $copern == 1 ) $dopoz=1;

$no="";


?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Pozn·mky PO 2013 NUJ</title>
  <style type="text/css">

  </style>

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

window.open('../ucto/poznamky_po2013nujnacitaj.php?h_mfir=' + h_mfir + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=10101&vyb_ume=<?php echo $vyb_umk; ?>&dopoz=' + dopoz + '&xxc=1', '_self' );
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

window.open('../ucto/poznamky_po2013nujnacitaj.php?h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&mnl=' + mnl + '&premenna=' + premenna + '&copern=900&drupoh=1&page=1&strana=<?php echo $strana; ?>', '_self' );
                }

function UrobSubor()
                {
window.open('../ucto/poznamky_po2013nujnacitaj.php?&copern=901&drupoh=1&page=1&strana=<?php echo $strana; ?>&dopoz=1', '_self' );
                }

function vytlacGener( premx )
                {
var premenna = premx;

window.open('../ucto/poznamky_po2013nujnacitajtlac.php?copern=1&premenna=' + premenna + '&txx=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function Nacitaj( premenna )
                {


    var htmlmenunac = "<table  class='ponuka' width='100%'><tr><td width='50%'>";

    htmlmenunac += "<img border=0 src='../obr/tlac.png' style='width:15; height:15;' onClick=\"vytlacGener( '" + premenna + "' );\" title='TlaËiù nastavenÈ poloûky' > ";
    htmlmenunac += "NaËÌtanie poloûky " + premenna + "</td>";

    htmlmenunac += "<td width='50%' align='right'>";
    htmlmenunac += "<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='zhasni_menurobot();' title='Zhasni menu' ></td></tr>";

                    
    htmlmenunac += "<tr><FORM name='enast' method='post' action='#' ><td class='ponuka' colspan='2'>";
    htmlmenunac += "<a href=\"#\" onClick=\"NacitajPol( '" + premenna + "' );\"> Chcete naËÌtaù hodnotu poloûky podæa nastavenia ?</a></td></tr> ";

    htmlmenunac += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenunac += "˙Ëet <input type='text' name='h_ucm1' id='h_ucm1' size='6' maxlenght='6' value='' >"; 

    htmlmenunac += "<td class='ponuka' colspan='1'>"; 
    htmlmenunac += "iËo <input type='text' name='h_ico1' id='h_ico1' size='8' maxlenght='8' value='' ></td></tr>";

    htmlmenunac += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenunac += "˙Ëet <input type='text' name='h_ucm2' id='h_ucm2' size='6' maxlenght='6' value='' >"; 

    htmlmenunac += "<td class='ponuka' colspan='1'>"; 
    htmlmenunac += "iËo <input type='text' name='h_ico2' id='h_ico2' size='8' maxlenght='8' value='' ></td></tr>";

    htmlmenunac += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenunac += "˙Ëet <input type='text' name='h_ucm3' id='h_ucm3' size='6' maxlenght='6' value='' >"; 

    htmlmenunac += "<td class='ponuka' colspan='1'>"; 
    htmlmenunac += "iËo <input type='text' name='h_ico3' id='h_ico3' size='8' maxlenght='8' value='' ></td></tr>";

    htmlmenunac += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenunac += "˙Ëet <input type='text' name='h_ucm4' id='h_ucm4' size='6' maxlenght='6' value='' >"; 

    htmlmenunac += "<td class='ponuka' colspan='1'>"; 
    htmlmenunac += "iËo <input type='text' name='h_ico4' id='h_ico4' size='8' maxlenght='8' value='' ></td></tr>";

    htmlmenunac += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenunac += "˙Ëet <input type='text' name='h_ucm5' id='h_ucm5' size='6' maxlenght='6' value='' >"; 

    htmlmenunac += "<td class='ponuka' colspan='1'>"; 
    htmlmenunac += "iËo <input type='text' name='h_ico5' id='h_ico5' size='8' maxlenght='8' value='' ></td></tr>"; 

    htmlmenunac += "<tr><td class='ponuka' colspan='2'>"; 
    htmlmenunac += "zmd<input type='checkbox' name='zmd' value='1' > | zdl<input type='checkbox' name='zdl' value='1' >";
    htmlmenunac += " | omd<input type='checkbox' name='omd' value='1' > | odl<input type='checkbox' name='odl' value='1' >";
    htmlmenunac += " | pmd<input type='checkbox' name='pmd' value='1' > | pdl<input type='checkbox' name='pdl' value='1' >"; 
    htmlmenunac += " | mnl<input type='checkbox' name='mnl' value='1' > "; 

    htmlmenunac += " <img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='UrobSubor();' alt='Vytvorenie s˙boru, z ktorÈho naËÌtate hodnoty (staËÌ jeden kr·t klikn˙ù)' > S˙bor"; 

    htmlmenunac += "</td></tr>"; 

    htmlmenunac += "</FORM></table>";

  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenunac;
  robotmenu.style.display='';

volajNastavenie( premenna );

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
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 301 );\">" +
"Chcete naËÌtaù ˙daje o Dlhodobom Nehmotnom majetku (»l. III. ods. 1) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 300 );\">" +
"Chcete naËÌtaù ˙daje o Dlhodobom Hmotnom majetku (»l. III. ods. 1) z obratovky ?</a>";
    htmlmenu += "</td></tr>";                    

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 302 );\">" +
"Chcete naËÌtaù ˙daje o dlhodobom FinanËnom majetku (»l. III. ods. 4) z obratovky ?</a>";
    htmlmenu += "</td></tr>";                      

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 401 );\">" +
"Chcete naËÌtaù ˙daje o vekovej ötrukt˙re pohæad·vok (»l. III. ods. 10) z obratovky a zo saldokonta ?</a>";
    htmlmenu += "</td></tr>";  

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 501 );\">" +
"Chcete naËÌtaù ˙daje o kr·tkodobom FinanËnom majetku (»l. III. ods. 6) z obratovky ?</a>";
    htmlmenu += "</td></tr>";   

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 502 );\">" +
"Chcete naËÌtaù ˙daje o »asovom rozlÌöenÌ na strane aktÌv (»l. III. ods. 11) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 503 );\">" +
"Chcete naËÌtaù ˙daje o RozdelenÌ ˙ËtovnÈho zisku, straty (»l. III. ods. 13) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 504 );\">" +
"Chcete naËÌtaù ˙daje o Rezerv·ch (»l. III. ods. 14) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 402 );\">" +
"Chcete naËÌtaù ˙daje o z·v‰zkoch (»l. III. ods. 14 pÌsm.c,d) zo saldokonta ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 505 );\">" +
"Chcete naËÌtaù ˙daje o Soci·lnom fonde (»l. III. ods. 14 pÌsm.e) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 507 );\">" +
"Chcete naËÌtaù ˙daje o Trûb·ch, v˝nosoch a obrate (»l. IV. ods. 1,2,4) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 508 );\">" +
"Chcete naËÌtaù ˙daje o N·kladoch (»l. IV. ods. 5,7) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 510 );\">" +
"Chcete naËÌtaù ˙daje o Zmen·ch vlastn˝ch zdrojov krytia majetku (»l. III. ods. 12) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 999 );\">" +
"Chcete naËÌtaù ˙daje o bezprostredne predch·dzaj˙com obdobÌ z pozn·mok z firmy minulÈho roka ?</a>";
    htmlmenu += "</td></tr>";
                    
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>";
htmlmenu += "<a href=\"#\" onClick=\"NacitajMzdy();\">" +
"Chcete naËÌtaù ˙daje z miezd (»l. I. ods. 4) firma ËÌslo</a> ";
    htmlmenu += "<input type='text' name='h_mfir' id='h_mfir' size='2' maxlenght='4' value='<?php echo $kli_vxcf; ?>' >"; 
    htmlmenu += " ?</td></tr>";

    htmlmenu += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenu += " <img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='UrobSubor();' alt='Vytvorenie s˙boru, z ktorÈho naËÌtate hodnoty (staËÌ jeden kr·t klikn˙ù)' > S˙bor"; 
    htmlmenu += "<td class='ponuka' colspan='1'>Po naËÌtanÌ nasp‰ù <input type='checkbox' name='dopoz' value='1' >"; 
    htmlmenu += " </td></tr>";

    htmlmenu += "</table></FORM>"; 

function Zistipolozku()
                {

var prvepismeno
var polozka="m405r41";
var objekt=event.srcElement;
var polozka=objekt.id;
//document.forms.formv1.m405r41.value=polozka;

prvepismeno = polozka.charAt(0);
if ( prvepismeno == "m" )
  {
//Nacitaj( polozka );
  }
                }


function NacitajHodnotu( riadok )
                {
var dopoz = 0;
if( document.emzdy.dopoz.checked ) dopoz=1;

window.open('../ucto/poznamky_po2013nujnacitaj.php?copern=' + riadok + '&drupoh=1&page=1&dopoz=' + dopoz + '&xxc=1', '_self' ); 
                }
   
</script>

</HEAD>
<BODY class="white" onload="<?php if( $copern == 1 ) { echo 'ukazrobot();'; } ?>
<?php if( $copern == 1 AND $dopoz == 1 ) { echo ' zobraz_robotmenu();'; } ?>" ondblclick="Zistipolozku();" >
<table class="h2" width="100%" >
<tr>
  <td>EuroSecom  -  Pozn·mky PO v.2013 NUJ</td>
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


<?php
//zostava PDF
if( $copern == 10 )
          {
$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/pozn_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/pozn_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

   define('FPDF_FONTPATH','../fpdf/font/');
   require('../fpdf/fpdf.php');

$sirka_vyska="210,320";



$velkost_strany = explode(",", $sirka_vyska);
 
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac


$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_no2011 WHERE psys >= 0 ".""; 
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

$rmc=0;
$rmc1=0;

//tlac strana 1
if ( $strana == 1 OR $strana == 9999 )
    {

$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_vrchnastrana.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_vrchnastrana.jpg',0,0,210,296);
}


$pdf->SetY(20);
$pdf->SetFont('arial','',9);
$pdf->Cell(120,6," ","$rmc",0,"L");$pdf->Cell(0,6,"PrÌloha k opatreniu MF/17616/2013-74","$rmc",1,"L");

$pdf->SetY(40);
$pdf->SetFont('arial','',9);
$pdf->Cell(133,6," ","$rmc",0,"L");$pdf->Cell(0,6,"Pozn·mky ⁄Ë NUJ 3 - 01","$rmc",1,"L");


$pdf->SetY(17);

//za obdobie
$pocetdni=31;
$sqltt = "SELECT * FROM kalendar WHERE ume = $kli_vume ";
$sql = mysql_query("$sqltt");
$pocetdni = mysql_num_rows($sql);

$datumod="01.01.".$kli_vrok;
$datumdo=$pocetdni.".".$kli_vume;

//nacitaj obdobia z ufirdalsie
$pole = explode(".", $kli_vume);
$kli_vmesx=$pole[0];
$kli_vrokx=$pole[1];
if ( $kli_vmesx < 10 ) { $kli_vmesx="0".$kli_vmesx; }
$kli_mrokx=$kli_vrokx-1;

$datbodsk="01.01.".$kli_vrokx; $datbdosk="31.12.".$kli_vrokx; $datmodsk="01.01.".$kli_mrokx; $datmdosk="31.12.".$kli_mrokx;
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


$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) { 
$datumod=$obdd1.".".$obdm1.".20".$obdr1; $datumdo=$obdd2.".".$obdm2.".20".$obdr2; }

$pdf->SetFont('arial','',9);

$pdf->Cell(190,42,"  ","$rmc1",1,"L");
$pdf->Cell(97,6,"     ","$rmc1",0,"L");
$krok=substr($obdr1,2,2);
$pdf->Cell(15,6,"$obdd2.$obdm2.","$rmc",0,"L");$pdf->Cell(5,6," ","$rmc",0,"L");$pdf->Cell(15,6,"$krok","$rmc",1,"L");

//v eurocentoch krizik
$keurocenty="x"; $kcenty=" "; 
$pdf->Cell(90,7,"  ","$rmc1",1,"L");
$pdf->Cell(83,3,"     ","$rmc1",0,"L");$pdf->Cell(4,3,"$keurocenty","$rmc",0,"L");
$pdf->Cell(57,3,"     ","$rmc1",0,"L");$pdf->Cell(4,3,"$kcenty","$rmc",1,"L");

//za obdobie a bezprostredne predch.
$cobdd1=1*$obdd1;
$cobdm1=1*$obdm1;
$cobdr1=1*$obdr1;
if( $cobdd1 > 0 AND $cobdm1 > 0 AND $cobdr1 > 0 ) { 
$mesp_sk=$obdm1; $rokp_sk=$obdr1; $mesk_sk=$obdm2; $rokk_sk=$obdr2; $mesp08_sk=$obmm1; $rokp08_sk=$obmr1; $mesk08_sk=$obmm2; $rokk08_sk=$obmr2; }

$Amesp=substr($mesp_sk,0,1);
$Bmesp=substr($mesp_sk,1,1);
$Arokp=substr($rokp_sk,2,1);
$Brokp=substr($rokp_sk,3,1);

$Amesk=substr($mesk_sk,0,1);
$Bmesk=substr($mesk_sk,1,1);
$Arokk=substr($rokk_sk,2,1);
$Brokk=substr($rokk_sk,3,1);

$Amesk08=substr($mesk08_sk,0,1);
$Bmesk08=substr($mesk08_sk,1,1);
$Arokk08=substr($rokk08_sk,2,1);
$Brokk08=substr($rokk08_sk,3,1);
$Amesp08=substr($mesp08_sk,0,1);
$Bmesp08=substr($mesp08_sk,1,1);
$Arokp08=substr($rokp08_sk,2,1);
$Brokp08=substr($rokp08_sk,3,1);

$pdf->Cell(90,13,"  ","$rmc1",1,"L");
$pdf->Cell(82,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Amesp","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Bmesp","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"0","$rmc",0,"C");
$pdf->Cell(6,6,"$Arokp","$rmc",0,"C");$pdf->Cell(6,6,"$Brokp","$rmc",0,"C");

$pdf->Cell(18,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$Amesk","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$Bmesk","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"0","$rmc",0,"C");
$pdf->Cell(6,6,"$Arokk","$rmc",0,"C");$pdf->Cell(6,6,"$Brokk","$rmc",1,"C");

$pdf->Cell(90,10,"  ","$rmc1",1,"L");
$pdf->Cell(82,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Amesp08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Bmesp08","$rmc",0,"C");
$pdf->Cell(7,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"0","$rmc",0,"C");
$pdf->Cell(6,6,"$Arokp08","$rmc",0,"C");$pdf->Cell(6,6,"$Brokp08","$rmc",0,"C");

$pdf->Cell(18,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$Amesk08","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$Bmesk08","$rmc",0,"C");
$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"2","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"0","$rmc",0,"C");
$pdf->Cell(6,6,"$Arokk08","$rmc",0,"C");$pdf->Cell(6,6,"$Brokk08","$rmc",1,"C");


//ico
$pdf->Cell(80,38," ","$rmc",1,"C");

$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);

$pdf->Cell(1,5," ","$rmc",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(2,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(2,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");

//dic
$pdf->Cell(6,5," ","$rmc",0,"C");

$A=substr($fir_fdic,0,1);
$B=substr($fir_fdic,1,1);
$C=substr($fir_fdic,2,1);
$D=substr($fir_fdic,3,1);
$E=substr($fir_fdic,4,1);
$F=substr($fir_fdic,5,1);
$G=substr($fir_fdic,6,1);
$H=substr($fir_fdic,7,1);
$I=substr($fir_fdic,8,1);
$J=substr($fir_fdic,9,1);

$pdf->Cell(6,5," ","$rmc",0,"R");$pdf->Cell(5,5,"$A","$rmc",0,"C");$pdf->Cell(2,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$B","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$C","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$D","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$E","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$F","$rmc",0,"C");$pdf->Cell(2,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$G","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(5,5,"$H","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");$pdf->Cell(5,5,"$I","$rmc",0,"C");$pdf->Cell(1,5," ","$rmc",0,"C");
$pdf->Cell(6,5,"$J","$rmc",0,"C");



//sknace
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);

$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
$sn2c=substr($sknacec,1,1);

$pdf->Cell(2,5," ","$rmc",0,"L");
$pdf->Cell(5,5," ","$rmc",0,"L");$pdf->Cell(6,5,"$sn1a","$rmc",0,"L");$pdf->Cell(6,5,"$sn2a","$rmc",0,"L");
$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(6,5,"$sn1b","$rmc",0,"L");$pdf->Cell(6,5,"$sn2b","$rmc",0,"L");
$pdf->Cell(6,5," ","$rmc",0,"L");$pdf->Cell(6,5,"$sn1c","$rmc",0,"L");$pdf->Cell(6,5,"$sn2c","$rmc",0,"L");

$pdf->Cell(10,5," ","$rmc",1,"L");

//nazov1
$pdf->Cell(0,10," ","$rmc",1,"C");

$A=substr($fir_fnaz,0,1);$B=substr($fir_fnaz,1,1);$C=substr($fir_fnaz,2,1);$D=substr($fir_fnaz,3,1);$E=substr($fir_fnaz,4,1);
$F=substr($fir_fnaz,5,1);$G=substr($fir_fnaz,6,1);$H=substr($fir_fnaz,7,1);$I=substr($fir_fnaz,8,1);$J=substr($fir_fnaz,9,1);

$K=substr($fir_fnaz,10,1);$L=substr($fir_fnaz,11,1);$M=substr($fir_fnaz,12,1);$N=substr($fir_fnaz,13,1);$O=substr($fir_fnaz,14,1);
$P=substr($fir_fnaz,15,1);$R=substr($fir_fnaz,16,1);$S=substr($fir_fnaz,17,1);$T=substr($fir_fnaz,18,1);$U=substr($fir_fnaz,19,1);

$V=substr($fir_fnaz,20,1);$W=substr($fir_fnaz,21,1);$X=substr($fir_fnaz,22,1);$Y=substr($fir_fnaz,23,1);$Z=substr($fir_fnaz,24,1);
$A1=substr($fir_fnaz,25,1);$B1=substr($fir_fnaz,26,1);$C1=substr($fir_fnaz,27,1);$D1=substr($fir_fnaz,28,1);$E1=substr($fir_fnaz,29,1);$F1=substr($fir_fnaz,30,1);

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$P","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A1","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$F1","$rmc",0,"C");

$pdf->Cell(1,6," ","$rmc",1,"C");

//nazov2
$pdf->Cell(0,0," ","$rmc",1,"C");
$fir_fnaz2=substr($fir_fnaz,31,30);

$A=substr($fir_fnaz2,0,1);$B=substr($fir_fnaz2,1,1);$C=substr($fir_fnaz2,2,1);$D=substr($fir_fnaz2,3,1);$E=substr($fir_fnaz2,4,1);
$F=substr($fir_fnaz2,5,1);$G=substr($fir_fnaz2,6,1);$H=substr($fir_fnaz2,7,1);$I=substr($fir_fnaz2,8,1);$J=substr($fir_fnaz2,9,1);

$K=substr($fir_fnaz2,10,1);$L=substr($fir_fnaz2,11,1);$M=substr($fir_fnaz2,12,1);$N=substr($fir_fnaz2,13,1);$O=substr($fir_fnaz2,14,1);
$P=substr($fir_fnaz2,15,1);$R=substr($fir_fnaz2,16,1);$S=substr($fir_fnaz2,17,1);$T=substr($fir_fnaz2,18,1);$U=substr($fir_fnaz2,19,1);

$V=substr($fir_fnaz2,20,1);$W=substr($fir_fnaz2,21,1);$X=substr($fir_fnaz2,22,1);$Y=substr($fir_fnaz2,23,1);$Z=substr($fir_fnaz2,24,1);
$A1=substr($fir_fnaz2,25,1);$B1=substr($fir_fnaz2,26,1);$C1=substr($fir_fnaz2,27,1);$D1=substr($fir_fnaz2,28,1);$E1=substr($fir_fnaz2,29,1);


$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$P","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A1","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(1,6," ","$rmc",1,"C");

//ulica cislo
$pdf->Cell(190,14,"     ","$rmc",1,"L");

$A=substr($fir_fuli,0,1);$B=substr($fir_fuli,1,1);$C=substr($fir_fuli,2,1);$D=substr($fir_fuli,3,1);$E=substr($fir_fuli,4,1);
$F=substr($fir_fuli,5,1);$G=substr($fir_fuli,6,1);$H=substr($fir_fuli,7,1);$I=substr($fir_fuli,8,1);$J=substr($fir_fuli,9,1);

$K=substr($fir_fuli,10,1);$L=substr($fir_fuli,11,1);$M=substr($fir_fuli,12,1);$N=substr($fir_fuli,13,1);$O=substr($fir_fuli,14,1);
$P=substr($fir_fuli,15,1);$R=substr($fir_fuli,16,1);$S=substr($fir_fuli,17,1);$T=substr($fir_fuli,18,1);$U=substr($fir_fuli,19,1);

$V=substr($fir_fuli,20,1);$W=substr($fir_fuli,21,1);$X=substr($fir_fuli,22,1);$Y=substr($fir_fuli,23,1);$Z=substr($fir_fuli,24,1);
$A1=substr($fir_fuli,25,1);$B1=substr($fir_fuli,26,1);$C1=substr($fir_fuli,27,1);

$pdf->Cell(2,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$P","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$X","$rmc",0,"C");


$A=substr($fir_fcdm,0,1);$B=substr($fir_fcdm,1,1);$C=substr($fir_fcdm,2,1);$D=substr($fir_fcdm,3,1);$E=substr($fir_fcdm,4,1);
$F=substr($fir_fcdm,5,1);$G=substr($fir_fcdm,6,1);$H=substr($fir_fcdm,7,1);



$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$H","$rmc",1,"C");



//psc,obec
$pdf->Cell(190,9,"     ","$rmc",1,"L");

$fir_fpsc=str_replace(" ","",$fir_fpsc);
$A=substr($fir_fpsc,0,1);$B=substr($fir_fpsc,1,1);$C=substr($fir_fpsc,2,1);$D=substr($fir_fpsc,3,1);$E=substr($fir_fpsc,4,1);

$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(6,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(6,6,"$E","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");


$A=substr($fir_fmes,0,1);$B=substr($fir_fmes,1,1);$C=substr($fir_fmes,2,1);$D=substr($fir_fmes,3,1);$E=substr($fir_fmes,4,1);
$F=substr($fir_fmes,5,1);$G=substr($fir_fmes,6,1);$H=substr($fir_fmes,7,1);$I=substr($fir_fmes,8,1);$J=substr($fir_fmes,9,1);

$K=substr($fir_fmes,10,1);$L=substr($fir_fmes,11,1);$M=substr($fir_fmes,12,1);$N=substr($fir_fmes,13,1);$O=substr($fir_fmes,14,1);
$P=substr($fir_fmes,15,1);$R=substr($fir_fmes,16,1);$S=substr($fir_fmes,17,1);$T=substr($fir_fmes,18,1);$U=substr($fir_fmes,19,1);

$V=substr($fir_fmes,20,1);$W=substr($fir_fmes,21,1);$X=substr($fir_fmes,22,1);$Y=substr($fir_fmes,23,1);$Z=substr($fir_fmes,24,1);
$A1=substr($fir_fmes,25,1);$B1=substr($fir_fmes,26,1);$C1=substr($fir_fmes,27,1);$D1=substr($fir_fmes,28,1);$E1=substr($fir_fmes,29,1);

$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$J","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$P","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$U","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Y","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Z","$rmc",1,"C");


//telefon fax
$pdf->Cell(190,9,"     ","$rmc",1,"L");

$pole = explode("/", $fir_ftel);
$tel_pred=1*$pole[0];
$tel_za=1*$pole[1];

$A=substr($tel_pred,0,1);$B=substr($tel_pred,1,1);$C=substr($tel_pred,2,1);

$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6," ","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($tel_za,0,1);$B=substr($tel_za,1,1);$C=substr($tel_za,2,1);
$D=substr($tel_za,3,1);$E=substr($tel_za,4,1);$F=substr($tel_za,5,1);
$G=substr($tel_za,6,1);$H=substr($tel_za,7,1);


$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pole = explode("/", $fir_ffax);
$fax_pred=1*$pole[0];
$fax_za=1*$pole[1];

$A=substr($fax_pred,0,1);$B=substr($fax_pred,1,1);$C=substr($fax_pred,2,1);

$pdf->Cell(12,6," ","$rmc",0,"C");$pdf->Cell(6,6," ","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");

$A=substr($fax_za,0,1);$B=substr($fax_za,1,1);$C=substr($fax_za,2,1);
$D=substr($fax_za,3,1);$E=substr($fax_za,4,1);$F=substr($fax_za,5,1);
$G=substr($fax_za,6,1);$H=substr($fax_za,7,1);


$pdf->Cell(6,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");


$pdf->Cell(1,6," ","$rmc",1,"C");

//email
$pdf->Cell(190,8,"     ","$rmc",1,"L");
$A=substr($fir_fem1,0,1);$B=substr($fir_fem1,1,1);$C=substr($fir_fem1,2,1);$D=substr($fir_fem1,3,1);$E=substr($fir_fem1,4,1);
$F=substr($fir_fem1,5,1);$G=substr($fir_fem1,6,1);$H=substr($fir_fem1,7,1);$I=substr($fir_fem1,8,1);$J=substr($fir_fem1,9,1);

$K=substr($fir_fem1,10,1);$L=substr($fir_fem1,11,1);$M=substr($fir_fem1,12,1);$N=substr($fir_fem1,13,1);$O=substr($fir_fem1,14,1);
$P=substr($fir_fem1,15,1);$R=substr($fir_fem1,16,1);$S=substr($fir_fem1,17,1);$T=substr($fir_fem1,18,1);$U=substr($fir_fem1,19,1);

$V=substr($fir_fem1,20,1);$W=substr($fir_fem1,21,1);$X=substr($fir_fem1,22,1);$Y=substr($fir_fem1,23,1);$Z=substr($fir_fem1,24,1);
$A1=substr($fir_fem1,25,1);$B1=substr($fir_fem1,26,1);$C1=substr($fir_fem1,27,1);$D1=substr($fir_fem1,28,1);$E1=substr($fir_fem1,29,1);

$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$B","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$D","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$F","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$H","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$J","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$K","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$L","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$N","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$P","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$S","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$U","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");

$pdf->Cell(5,6,"$V","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$W","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$Y","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$A1","$rmc",0,"C");$pdf->Cell(2,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$C1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");
$pdf->Cell(5,6,"$E1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",1,"C");


//zostavena, schvalena
$h_zos = $_REQUEST['h_zos'];
$h_sch = $_REQUEST['h_sch'];

//ZostavenÈ dÚa
$pdf->Cell(0,10," ","$rmc",1,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(25,7,"$h_zos","$rmc",1,"C");

//Schv·lenÈ dÚa
$pdf->Cell(0,14," ","$rmc",1,"C");
$pdf->Cell(1,6," ","$rmc",0,"R");$pdf->Cell(25,6,"$h_sch","$rmc",1,"C");

//datum vzniku UJ
$aa2sk = SkDatum($hlavicka->aa2); 
if( $aa2sk == '00.00.0000' ) $aa2sk="";
$A=substr($aa2sk,0,1);
$B=substr($aa2sk,1,1);
$C=substr($aa2sk,3,1);
$D=substr($aa2sk,4,1);
$E=substr($aa2sk,6,1);
$F=substr($aa2sk,7,1);
$G=substr($aa2sk,8,1);
$H=substr($aa2sk,9,1);

$pdf->SetY(123);
$pdf->Cell(1,3," ","$rmc",0,"C");$pdf->Cell(6,5,"$A","$rmc",0,"C");$pdf->Cell(6,5,"$B","$rmc",0,"C");$pdf->Cell(7,5," ","$rmc",0,"C");$pdf->Cell(6,5,"$C","$rmc",0,"C");
$pdf->Cell(6,5,"$D","$rmc",0,"C");$pdf->Cell(6,5," ","$rmc",0,"C");$pdf->Cell(6,5,"$E","$rmc",0,"C");$pdf->Cell(6,5,"$F","$rmc",0,"C");$pdf->Cell(7,5,"$G","$rmc",0,"C");
$pdf->Cell(6,5,"$H","$rmc",0,"C");

//krizik riadna
$pdf->SetY(124);
$pdf->Cell(96,3," ","$rmc",0,"C");$pdf->Cell(3,3,"X","$rmc",1,"C");

//krizik zostavena
$krizik1="X";
$krizik2="X";

$text=1*$hlavicka->a2e;
if( $text == 0 ) $krizik2="";
$text=1*$hlavicka->a1e;
if( $text == 0 ) $krizik1="";

$pdf->SetY(123);
$pdf->Cell(137,3," ","$rmc",0,"C");$pdf->Cell(6,6,"$krizik1","$rmc",1,"C");
$pdf->Cell(137,4," ","$rmc",0,"C");$pdf->Cell(6,6,"$krizik2","$rmc",1,"C");


//koniec tlac strana 1
    }


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
$sqlttt = "SELECT * FROM F$kli_vxcf"."_poznamky_no2011texty WHERE ozntxt = '$ozntext' ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $textvypis=$riaddok->hdntxt;
 }

    return $textvypis;
    }



$sqlfir = "SELECT * FROM F$kli_vxcf"."_poznamky_nujnopage ";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); }

   $nopg2 = 1*$fir_riadok->nopg2;
   $nopg3 = 1*$fir_riadok->nopg3;
   $nopg4 = 1*$fir_riadok->nopg4;
   $nopg5 = 1*$fir_riadok->nopg5;
   $nopg6 = 1*$fir_riadok->nopg6;
   $nopg7 = 1*$fir_riadok->nopg7;
   $nopg8 = 1*$fir_riadok->nopg8;
   $nopg9 = 1*$fir_riadok->nopg9;
   $nopg10 = 1*$fir_riadok->nopg10;
   $nopg11 = 1*$fir_riadok->nopg11;
   $nopg12 = 1*$fir_riadok->nopg12;
   $nopg13 = 1*$fir_riadok->nopg13;
   $nopg14 = 1*$fir_riadok->nopg14;
   $nopg15 = 1*$fir_riadok->nopg15;
   $nopg16 = 1*$fir_riadok->nopg16;
   $nopg17 = 1*$fir_riadok->nopg17;
   $nopg18 = 1*$fir_riadok->nopg18;
   $nopg19 = 1*$fir_riadok->nopg19;
   $nopg20 = 1*$fir_riadok->nopg20;
   $nopg21 = 1*$fir_riadok->nopg21;
   $nopg22 = 1*$fir_riadok->nopg22;
   $nopg23 = 1*$fir_riadok->nopg23;
   $nopg24 = 1*$fir_riadok->nopg24;
   $nopg25 = 1*$fir_riadok->nopg25;


$stranax=1;
//tlac strana 2
if ( $nopg2 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab1.jpg',0,164,210,40);
}



$pdf->SetFont('arial','',10);

$pdf->Cell(0,15," ","$rmc",1,"L");
$pdf->Cell(7,6," ","$rmc",0,"L");$pdf->Cell(0,6,"I. VäEOBECN… ⁄DAJE","$rmc",1,"L");
$pdf->SetFont('arial','',9);

//info k casti A pism. c
if( $hlavicka->ac11 == 0 ) $hlavicka->ac11="";
if( $hlavicka->ac12 == 0 ) $hlavicka->ac12="";
if( $hlavicka->ac21 == 0 ) $hlavicka->ac21="";
if( $hlavicka->ac22 == 0 ) $hlavicka->ac22="";
if( $hlavicka->ac31 == 0 ) $hlavicka->ac31="";
if( $hlavicka->ac32 == 0 ) $hlavicka->ac32="";
if( $hlavicka->ac41 == 0 ) $hlavicka->ac41="";
if( $hlavicka->ac42 == 0 ) $hlavicka->ac42="";
$hlavicka->ac11nyg46nyg46nyg46="1234.56";
$hlavicka->ac12nyg46nyg46nyg46="1234.56";
$hlavicka->ac21nyg46nyg46nyg46="1234.56";
$hlavicka->ac22nyg46nyg46nyg46="1234.56";
$hlavicka->ac31nyg46nyg46nyg46="1234.56";
$hlavicka->ac32nyg46nyg46nyg46="1234.56";

$pdf->Cell(90,130,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,4,"I. ods.4) PoËet zamestnancov a dobrovoænÌkov","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',9);
$pdf->Cell(89,6,"     ","$rmc",0,"L");$pdf->Cell(47,6,"$hlavicka->ac11","$rmc",0,"R");$pdf->Cell(45,6,"$hlavicka->ac12","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(89,5,"     ","$rmc",0,"L");$pdf->Cell(47,5,"$hlavicka->ac31","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->ac32","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(89,5,"     ","$rmc",0,"L");$pdf->Cell(47,5,"$hlavicka->ac41","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->ac42","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(89,5,"     ","$rmc",0,"L");$pdf->Cell(47,5,"$hlavicka->ac51","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->ac52","$rmc",1,"R");

$pdf->SetFont('arial','',8);

$ozntext="A_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(30);
$pdf->Cell(7,6," ","$rmc",0,"L");$pdf->Cell(0,6,"I. ods.1 Meno a priezvisko FO alebo n·zov PO, ktor· je zakladateæom alebo zriaÔovateæom ","$rmc",1,"L");
$pdf->Cell(7,6," ","$rmc",0,"L");$pdf->Cell(0,6,"⁄J, jej trval˝ pobyt alebo sÌdlo, d·tum zaloûenia alebo zriadenia ˙Ëtovnej jednotky. ","$rmc",1,"L");
$pdf->Cell(0,3," ","$rmc",1,"L");

if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="A_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(205);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 2
    }


//tlac strana 3
if ( $nopg3 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

$ozntext="B_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(30);
$pdf->SetFont('arial','',8);
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"I. ods.2) Inform·cie o Ëlenoch ötatut·rnych, dozorn˝ch a in˝ch org·nov ⁄J","$rmc",1,"L");
$pdf->Cell(90,3,"     ","$rmc1",1,"L");
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="B_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(130);
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"I. ods.3) Opis Ëinnosti, na ˙Ëel ktorej bola ˙Ëtovn· jednotka zriaden· a opis ","$rmc",1,"L");
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"druhu pdnikateæskej Ëinnosti, ktor˙ ⁄J vykon·va","$rmc",1,"L");
$pdf->Cell(90,3,"     ","$rmc1",1,"L");
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="B_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(210);
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"I. ods.5) Inform·cia o organiz·ci·ch v zriaÔovateæskej pÙsobnosti ˙Ëtovnej jednotky","$rmc",1,"L");

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 3
    }


//tlac strana 4
if ( $nopg4 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


$pdf->SetFont('arial','',10);

$pdf->Cell(0,10," ","$rmc",1,"L");
$pdf->Cell(7,6," ","$rmc",0,"L");$pdf->Cell(0,6,"II. INFORM¡CIE O ⁄»TOVN›CH Z¡SAD¡CH A ⁄»TOVN›CH MET”DACH","$rmc",1,"L");
$pdf->SetFont('arial','',9);


$ozntext="E_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(40);
$pdf->SetFont('arial','',8);
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"II. ods.1 Inform·cia,Ëi je ⁄Z zostaven· za splnenia predpokladu, ⁄J bude nepretrûite pokraËovaù v Ëinnosti ","$rmc",1,"L");
$pdf->Cell(90,3,"     ","$rmc1",1,"L");

if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="E_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(80);
$pdf->SetFont('arial','',8);
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"II. ods.2 Zmeny ˙Ëtovn˝ch z·sad a ˙Ëtovn˝ch metÛd a spÙsob oceÚovania majetku ","$rmc",1,"L");
$pdf->Cell(90,3,"     ","$rmc1",1,"L");
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 4
    }


//tlac strana 5
if ( $nopg5 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


$ozntext="E_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
$pdf->SetFont('arial','',8);
$pdf->Cell(7,4," ","$rmc",0,"L");$pdf->Cell(0,4,"II. ods.2 SpÙsob zostavovania odpisovÈho pl·nu dlhodobÈho majetku ","$rmc",1,"L");
$pdf->Cell(90,3,"     ","$rmc1",1,"L");
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(7,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 5
    }


//tlac strana 6
if ( $nopg6 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab3_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab3_1.jpg',10,60,190,160);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab4.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab4.jpg',1,240,210,30);
}

$pdf->SetFont('arial','',10);

$pdf->Cell(0,10," ","$rmc",1,"L");
$pdf->Cell(2,6," ","$rmc",0,"L");$pdf->Cell(0,6,"III. INFORM¡CIE, KTOR… DOP≈“AJ⁄ A VYSVETºUJ⁄ ⁄DAJE V S⁄VAHE","$rmc",1,"L");
$pdf->SetFont('arial','',9);

$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(2,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 1 Inform·cie o dlhodobom nehmotnom majetku a dlhodobom hmotnom majetku","$rmc",1,"L");
$pdf->Cell(90,2,"     ","$rmc1",1,"L");



$pdf->Cell(90,23,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(2,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 1 o stave a pohybe dlhodobÈho nehmotnÈho majetku","$rmc",1,"L");
$pdf->Cell(90,23,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',7);

//3.info k casti F pism. a tabulka 1.
//prvotne ocenenie
if( $hlavicka->f1a11b == 0 ) $hlavicka->f1a11b="";
if( $hlavicka->f1a11c == 0 ) $hlavicka->f1a11c="";
if( $hlavicka->f1a11d == 0 ) $hlavicka->f1a11d="";
if( $hlavicka->f1a11f == 0 ) $hlavicka->f1a11f="";
if( $hlavicka->f1a11g == 0 ) $hlavicka->f1a11g="";
if( $hlavicka->f1a11h == 0 ) $hlavicka->f1a11h="";
if( $hlavicka->f1a11i == 0 ) $hlavicka->f1a11i="";

$hlavicka->f1a11bnyg46nyg46="1234.56";
$hlavicka->f1a11cnyg46nyg46="1234.56";
$hlavicka->f1a11dnyg46nyg46="1234.56";
$hlavicka->f1a11enyg46nyg46="1234.56";
$hlavicka->f1a11fnyg46nyg46="1234.56";
$hlavicka->f1a11gnyg46nyg46="1234.56";
$hlavicka->f1a11hnyg46nyg46="1234.56";
$hlavicka->f1a11inyg46nyg46="1234.56";


$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a11b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a11c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a11d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a11f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a11g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a11h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a11i","$rmc",1,"R");


if( $hlavicka->f1a12b == 0 ) $hlavicka->f1a12b="";
if( $hlavicka->f1a12c == 0 ) $hlavicka->f1a12c="";
if( $hlavicka->f1a12d == 0 ) $hlavicka->f1a12d="";
if( $hlavicka->f1a12f == 0 ) $hlavicka->f1a12f="";
if( $hlavicka->f1a12g == 0 ) $hlavicka->f1a12g="";
if( $hlavicka->f1a12h == 0 ) $hlavicka->f1a12h="";
if( $hlavicka->f1a12i == 0 ) $hlavicka->f1a12i="";

$hlavicka->f1a12bnyg46nyg46="1234.56";
$hlavicka->f1a12cnyg46nyg46="1234.56";
$hlavicka->f1a12dnyg46nyg46="1234.56";
$hlavicka->f1a12enyg46nyg46="1234.56";
$hlavicka->f1a12fnyg46nyg46="1234.56";
$hlavicka->f1a12gnyg46nyg46="1234.56";
$hlavicka->f1a12hnyg46nyg46="1234.56";
$hlavicka->f1a12inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a12b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a12c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a12d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a12f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a12g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a12h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a12i","$rmc",1,"R");


if( $hlavicka->f1a13b == 0 ) $hlavicka->f1a13b="";
if( $hlavicka->f1a13c == 0 ) $hlavicka->f1a13c="";
if( $hlavicka->f1a13d == 0 ) $hlavicka->f1a13d="";
if( $hlavicka->f1a13f == 0 ) $hlavicka->f1a13f="";
if( $hlavicka->f1a13g == 0 ) $hlavicka->f1a13g="";
if( $hlavicka->f1a13h == 0 ) $hlavicka->f1a13h="";
if( $hlavicka->f1a13i == 0 ) $hlavicka->f1a13i="";

$hlavicka->f1a13bnyg46nyg46="1234.56";
$hlavicka->f1a13cnyg46nyg46="1234.56";
$hlavicka->f1a13dnyg46nyg46="1234.56";
$hlavicka->f1a13enyg46nyg46="1234.56";
$hlavicka->f1a13fnyg46nyg46="1234.56";
$hlavicka->f1a13gnyg46nyg46="1234.56";
$hlavicka->f1a13hnyg46nyg46="1234.56";
$hlavicka->f1a13inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a13b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a13c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a13d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a13f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a13g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a13h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a13i","$rmc",1,"R");

if( $hlavicka->f1a14b == 0 ) $hlavicka->f1a14b="";
if( $hlavicka->f1a14c == 0 ) $hlavicka->f1a14c="";
if( $hlavicka->f1a14d == 0 ) $hlavicka->f1a14d="";
if( $hlavicka->f1a14f == 0 ) $hlavicka->f1a14f="";
if( $hlavicka->f1a14g == 0 ) $hlavicka->f1a14g="";
if( $hlavicka->f1a14h == 0 ) $hlavicka->f1a14h="";
if( $hlavicka->f1a14i == 0 ) $hlavicka->f1a14i="";

$hlavicka->f1a14bnyg46nyg46="1234.56";
$hlavicka->f1a14cnyg46nyg46="1234.56";
$hlavicka->f1a14dnyg46nyg46="1234.56";
$hlavicka->f1a14enyg46nyg46="1234.56";
$hlavicka->f1a14fnyg46nyg46="1234.56";
$hlavicka->f1a14gnyg46nyg46="1234.56";
$hlavicka->f1a14hnyg46nyg46="1234.56";
$hlavicka->f1a14inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a14b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->f1a14c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a14d","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a14f","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->f1a14g","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a14h","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->f1a14i","$rmc",1,"R");

if( $hlavicka->f1a15b == 0 ) $hlavicka->f1a15b="";
if( $hlavicka->f1a15c == 0 ) $hlavicka->f1a15c="";
if( $hlavicka->f1a15d == 0 ) $hlavicka->f1a15d="";
if( $hlavicka->f1a15f == 0 ) $hlavicka->f1a15f="";
if( $hlavicka->f1a15g == 0 ) $hlavicka->f1a15g="";
if( $hlavicka->f1a15h == 0 ) $hlavicka->f1a15h="";
if( $hlavicka->f1a15i == 0 ) $hlavicka->f1a15i="";

$hlavicka->f1a15bnyg46nyg46="1234.56";
$hlavicka->f1a15cnyg46nyg46="1234.56";
$hlavicka->f1a15dnyg46nyg46="1234.56";
$hlavicka->f1a15enyg46nyg46="1234.56";
$hlavicka->f1a15fnyg46nyg46="1234.56";
$hlavicka->f1a15gnyg46nyg46="1234.56";
$hlavicka->f1a15hnyg46nyg46="1234.56";
$hlavicka->f1a15inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a15b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a15c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a15d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a15f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a15g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a15h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a15i","$rmc",1,"R");

//opravky
if( $hlavicka->f1a16b == 0 ) $hlavicka->f1a16b="";
if( $hlavicka->f1a16c == 0 ) $hlavicka->f1a16c="";
if( $hlavicka->f1a16d == 0 ) $hlavicka->f1a16d="";
if( $hlavicka->f1a16f == 0 ) $hlavicka->f1a16f="";
if( $hlavicka->f1a16g == 0 ) $hlavicka->f1a16g="";
if( $hlavicka->f1a16h == 0 ) $hlavicka->f1a16h="";
if( $hlavicka->f1a16i == 0 ) $hlavicka->f1a16i="";

$hlavicka->f1a16bnyg46nyg46="1234.56";
$hlavicka->f1a16cnyg46nyg46="1234.56";
$hlavicka->f1a16dnyg46nyg46="1234.56";
$hlavicka->f1a16enyg46nyg46="1234.56";
$hlavicka->f1a16fnyg46nyg46="1234.56";
$hlavicka->f1a16gnyg46nyg46="1234.56";
$hlavicka->f1a16hnyg46nyg46="1234.56";
$hlavicka->f1a16inyg46nyg46="1234.56";


$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a16b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a16c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a16d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a16f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a16g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a16h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a16i","$rmc",1,"R");

if( $hlavicka->f1a17b == 0 ) $hlavicka->f1a17b="";
if( $hlavicka->f1a17c == 0 ) $hlavicka->f1a17c="";
if( $hlavicka->f1a17d == 0 ) $hlavicka->f1a17d="";
if( $hlavicka->f1a17f == 0 ) $hlavicka->f1a17f="";
if( $hlavicka->f1a17g == 0 ) $hlavicka->f1a17g="";
if( $hlavicka->f1a17h == 0 ) $hlavicka->f1a17h="";
if( $hlavicka->f1a17i == 0 ) $hlavicka->f1a17i="";

$hlavicka->f1a17bnyg46nyg46="1234.56";
$hlavicka->f1a17cnyg46nyg46="1234.56";
$hlavicka->f1a17dnyg46nyg46="1234.56";
$hlavicka->f1a17enyg46nyg46="1234.56";
$hlavicka->f1a17fnyg46nyg46="1234.56";
$hlavicka->f1a17gnyg46nyg46="1234.56";
$hlavicka->f1a17hnyg46nyg46="1234.56";
$hlavicka->f1a17inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a17b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a17c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a17d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a17f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a17g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a17h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a17i","$rmc",1,"R");

if( $hlavicka->f1a18b == 0 ) $hlavicka->f1a18b="";
if( $hlavicka->f1a18c == 0 ) $hlavicka->f1a18c="";
if( $hlavicka->f1a18d == 0 ) $hlavicka->f1a18d="";
if( $hlavicka->f1a18f == 0 ) $hlavicka->f1a18f="";
if( $hlavicka->f1a18g == 0 ) $hlavicka->f1a18g="";
if( $hlavicka->f1a18h == 0 ) $hlavicka->f1a18h="";
if( $hlavicka->f1a18i == 0 ) $hlavicka->f1a18i="";

$hlavicka->f1a18bnyg46nyg46="1234.56";
$hlavicka->f1a18cnyg46nyg46="1234.56";
$hlavicka->f1a18dnyg46nyg46="1234.56";
$hlavicka->f1a18enyg46nyg46="1234.56";
$hlavicka->f1a18fnyg46nyg46="1234.56";
$hlavicka->f1a18gnyg46nyg46="1234.56";
$hlavicka->f1a18hnyg46nyg46="1234.56";
$hlavicka->f1a18inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a18b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a18c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a18d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a18f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a18g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a18h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a18i","$rmc",1,"R");

if( $hlavicka->f1a19b == 0 ) $hlavicka->f1a19b="";
if( $hlavicka->f1a19c == 0 ) $hlavicka->f1a19c="";
if( $hlavicka->f1a19d == 0 ) $hlavicka->f1a19d="";
if( $hlavicka->f1a19f == 0 ) $hlavicka->f1a19f="";
if( $hlavicka->f1a19g == 0 ) $hlavicka->f1a19g="";
if( $hlavicka->f1a19h == 0 ) $hlavicka->f1a19h="";
if( $hlavicka->f1a19i == 0 ) $hlavicka->f1a19i="";

$hlavicka->f1a19bnyg46nyg46="1234.56";
$hlavicka->f1a19cnyg46nyg46="1234.56";
$hlavicka->f1a19dnyg46nyg46="1234.56";
$hlavicka->f1a19enyg46nyg46="1234.56";
$hlavicka->f1a19fnyg46nyg46="1234.56";
$hlavicka->f1a19gnyg46nyg46="1234.56";
$hlavicka->f1a19hnyg46nyg46="1234.56";
$hlavicka->f1a19inyg46nyg46="1234.56";


$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a19b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a19c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a19d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a19f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a19g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a19h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a19i","$rmc",1,"R");

//opravne polozky
if( $hlavicka->f1a110b == 0 ) $hlavicka->f1a110b="";
if( $hlavicka->f1a110c == 0 ) $hlavicka->f1a110c="";
if( $hlavicka->f1a110d == 0 ) $hlavicka->f1a110d="";
if( $hlavicka->f1a110f == 0 ) $hlavicka->f1a110f="";
if( $hlavicka->f1a110g == 0 ) $hlavicka->f1a110g="";
if( $hlavicka->f1a110h == 0 ) $hlavicka->f1a110h="";
if( $hlavicka->f1a110i == 0 ) $hlavicka->f1a110i="";

$hlavicka->f1a110bnyg46nyg46="1234.56";
$hlavicka->f1a110cnyg46nyg46="1234.56";
$hlavicka->f1a110dnyg46nyg46="1234.56";
$hlavicka->f1a110enyg46nyg46="1234.56";
$hlavicka->f1a110fnyg46nyg46="1234.56";
$hlavicka->f1a110gnyg46nyg46="1234.56";
$hlavicka->f1a110hnyg46nyg46="1234.56";
$hlavicka->f1a110inyg46nyg46="1234.56";


$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a110b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a110c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a110d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a110f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a110g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a110h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a110i","$rmc",1,"R");

if( $hlavicka->f1a111b == 0 ) $hlavicka->f1a111b="";
if( $hlavicka->f1a111c == 0 ) $hlavicka->f1a111c="";
if( $hlavicka->f1a111d == 0 ) $hlavicka->f1a111d="";
if( $hlavicka->f1a111f == 0 ) $hlavicka->f1a111f="";
if( $hlavicka->f1a111g == 0 ) $hlavicka->f1a111g="";
if( $hlavicka->f1a111h == 0 ) $hlavicka->f1a111h="";
if( $hlavicka->f1a111i == 0 ) $hlavicka->f1a111i="";

$hlavicka->f1a111bnyg46nyg46="1234.56";
$hlavicka->f1a111cnyg46nyg46="1234.56";
$hlavicka->f1a111dnyg46nyg46="1234.56";
$hlavicka->f1a111enyg46nyg46="1234.56";
$hlavicka->f1a111fnyg46nyg46="1234.56";
$hlavicka->f1a111gnyg46nyg46="1234.56";
$hlavicka->f1a111hnyg46nyg46="1234.56";
$hlavicka->f1a111inyg46nyg46="1234.56";


$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a111b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a111c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a111d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a111f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a111g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a111h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a111i","$rmc",1,"R");

if( $hlavicka->f1a112b == 0 ) $hlavicka->f1a112b="";
if( $hlavicka->f1a112c == 0 ) $hlavicka->f1a112c="";
if( $hlavicka->f1a112d == 0 ) $hlavicka->f1a112d="";
if( $hlavicka->f1a112f == 0 ) $hlavicka->f1a112f="";
if( $hlavicka->f1a112g == 0 ) $hlavicka->f1a112g="";
if( $hlavicka->f1a112h == 0 ) $hlavicka->f1a112h="";
if( $hlavicka->f1a112i == 0 ) $hlavicka->f1a112i="";

$hlavicka->f1a112bnyg46nyg46="1234.56";
$hlavicka->f1a112cnyg46nyg46="1234.56";
$hlavicka->f1a112dnyg46nyg46="1234.56";
$hlavicka->f1a112enyg46nyg46="1234.56";
$hlavicka->f1a112fnyg46nyg46="1234.56";
$hlavicka->f1a112gnyg46nyg46="1234.56";
$hlavicka->f1a112hnyg46nyg46="1234.56";
$hlavicka->f1a112inyg46nyg46="1234.56";


$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a112b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a112c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a112d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a112f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a112g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a112h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a112i","$rmc",1,"R");

if( $hlavicka->f1a113b == 0 ) $hlavicka->f1a113b="";
if( $hlavicka->f1a113c == 0 ) $hlavicka->f1a113c="";
if( $hlavicka->f1a113d == 0 ) $hlavicka->f1a113d="";
if( $hlavicka->f1a113f == 0 ) $hlavicka->f1a113f="";
if( $hlavicka->f1a113g == 0 ) $hlavicka->f1a113g="";
if( $hlavicka->f1a113h == 0 ) $hlavicka->f1a113h="";
if( $hlavicka->f1a113i == 0 ) $hlavicka->f1a113i="";

$hlavicka->f1a113bnyg46nyg46="1234.56";
$hlavicka->f1a113cnyg46nyg46="1234.56";
$hlavicka->f1a113dnyg46nyg46="1234.56";
$hlavicka->f1a113enyg46nyg46="1234.56";
$hlavicka->f1a113fnyg46nyg46="1234.56";
$hlavicka->f1a113gnyg46nyg46="1234.56";
$hlavicka->f1a113hnyg46nyg46="1234.56";
$hlavicka->f1a113inyg46nyg46="1234.56";


$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a113b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a113c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a113d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a113f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a113g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a113h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a113i","$rmc",1,"R");

//zostatkova
if( $hlavicka->f1a114b == 0 ) $hlavicka->f1a114b="";
if( $hlavicka->f1a114c == 0 ) $hlavicka->f1a114c="";
if( $hlavicka->f1a114d == 0 ) $hlavicka->f1a114d="";
if( $hlavicka->f1a114f == 0 ) $hlavicka->f1a114f="";
if( $hlavicka->f1a114g == 0 ) $hlavicka->f1a114g="";
if( $hlavicka->f1a114h == 0 ) $hlavicka->f1a114h="";
if( $hlavicka->f1a114i == 0 ) $hlavicka->f1a114i="";

$hlavicka->f1a114bnyg46nyg46="1234.56";
$hlavicka->f1a114cnyg46nyg46="1234.56";
$hlavicka->f1a114dnyg46nyg46="1234.56";
$hlavicka->f1a114enyg46nyg46="1234.56";
$hlavicka->f1a114fnyg46nyg46="1234.56";
$hlavicka->f1a114gnyg46nyg46="1234.56";
$hlavicka->f1a114hnyg46nyg46="1234.56";
$hlavicka->f1a114inyg46nyg46="1234.56";


$pdf->Cell(90,8,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a114b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a114c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a114d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a114f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a114g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a114h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a114i","$rmc",1,"R");


if( $hlavicka->f1a115b == 0 ) $hlavicka->f1a115b="";
if( $hlavicka->f1a115c == 0 ) $hlavicka->f1a115c="";
if( $hlavicka->f1a115d == 0 ) $hlavicka->f1a115d="";
if( $hlavicka->f1a115f == 0 ) $hlavicka->f1a115f="";
if( $hlavicka->f1a115g == 0 ) $hlavicka->f1a115g="";
if( $hlavicka->f1a115h == 0 ) $hlavicka->f1a115h="";
if( $hlavicka->f1a115i == 0 ) $hlavicka->f1a115i="";

$hlavicka->f1a115bnyg46nyg46="1234.56";
$hlavicka->f1a115cnyg46nyg46="1234.56";
$hlavicka->f1a115dnyg46nyg46="1234.56";
$hlavicka->f1a115enyg46nyg46="1234.56";
$hlavicka->f1a115fnyg46nyg46="1234.56";
$hlavicka->f1a115gnyg46nyg46="1234.56";
$hlavicka->f1a115hnyg46nyg46="1234.56";
$hlavicka->f1a115inyg46nyg46="1234.56";


$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(36,5,"     ","$rmc",0,"L");
$pdf->Cell(16,5,"$hlavicka->f1a115b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a115c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->f1a115d","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a115f","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a115g","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->f1a115h","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f1a115i","$rmc",1,"R");


//4. info k casti F pism. c
$pdf->SetFont('arial','',8);


$pdf->Cell(90,22,"     ","$rmc1",1,"L");
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods.1 Dlhodob˝ nehmotn˝ majetok a z·loûnÈ pr·vo ","$rmc",1,"L");
$pdf->Cell(90,9,"     ","$rmc1",1,"L");

if( $hlavicka->f1c1 == 0 ) $hlavicka->f1c1="";
if( $hlavicka->f1c2 == 0 ) $hlavicka->f1c2="";

$hlavicka->f1c1nyg46nyg46="1234.56";
$hlavicka->f1c2nyg46nyg46="1234.56";

$pdf->Cell(127,15,"     ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->f1c1","$rmc",1,"R");
$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(127,5,"     ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->f1c2","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(29);

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(2,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(220);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(2,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(268);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(2,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 6
    }



//tlac strana 7
if ( $nopg7 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab5_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab5_1.jpg',10,25,190,160);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab6.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab6.jpg',0,240,210,30);
}



$pdf->Cell(90,12,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(4,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 1 o stave a pohybe dlhodobÈho hmotnÈho majetku","$rmc",1,"L");
$pdf->Cell(90,25,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',7);

//5.info k casti F pism. o dlhodobom hmotnom majetku a tabulka 1.
//prvotne ocenenie
if( $hlavicka->f2a11b == 0 ) $hlavicka->f2a11b="";
if( $hlavicka->f2a11c == 0 ) $hlavicka->f2a11c="";
if( $hlavicka->f2a11d == 0 ) $hlavicka->f2a11d="";
if( $hlavicka->f2a11e == 0 ) $hlavicka->f2a11e="";
if( $hlavicka->f2a11f == 0 ) $hlavicka->f2a11f="";
if( $hlavicka->f2a11g == 0 ) $hlavicka->f2a11g="";
if( $hlavicka->f2a11h == 0 ) $hlavicka->f2a11h="";
if( $hlavicka->f2a11i == 0 ) $hlavicka->f2a11i="";
if( $hlavicka->f2a11j == 0 ) $hlavicka->f2a11j="";
if( $hlavicka->f2a11bx == 0 ) $hlavicka->f2a11bx="";
if( $hlavicka->f2a11dx == 0 ) $hlavicka->f2a11dx="";

$hlavicka->f2a11bnyg46nyg46="1234.56";
$hlavicka->f2a11cnyg46nyg46="1234.56";
$hlavicka->f2a11dnyg46nyg46="1234.56";
$hlavicka->f2a11enyg46nyg46="1234.56";
$hlavicka->f2a11fnyg46nyg46="1234.56";
$hlavicka->f2a11gnyg46nyg46="1234.56";
$hlavicka->f2a11hnyg46nyg46="1234.56";
$hlavicka->f2a11inyg46nyg46="1234.56";
$hlavicka->f2a11jnyg46nyg46="1234.56";

$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a11b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a11bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a11c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a11d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a11dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a11e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a11f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a11g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a11h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a11i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a11j","$rmc",1,"R");


if( $hlavicka->f2a12b == 0 ) $hlavicka->f2a12b="";
if( $hlavicka->f2a12c == 0 ) $hlavicka->f2a12c="";
if( $hlavicka->f2a12d == 0 ) $hlavicka->f2a12d="";
if( $hlavicka->f2a12e == 0 ) $hlavicka->f2a12e="";
if( $hlavicka->f2a12f == 0 ) $hlavicka->f2a12f="";
if( $hlavicka->f2a12g == 0 ) $hlavicka->f2a12g="";
if( $hlavicka->f2a12h == 0 ) $hlavicka->f2a12h="";
if( $hlavicka->f2a12i == 0 ) $hlavicka->f2a12i="";
if( $hlavicka->f2a12j == 0 ) $hlavicka->f2a12j="";
if( $hlavicka->f2a12bx == 0 ) $hlavicka->f2a12bx="";
if( $hlavicka->f2a12dx == 0 ) $hlavicka->f2a12dx="";

$hlavicka->f2a12bnyg46nyg46="1234.56";
$hlavicka->f2a12cnyg46nyg46="1234.56";
$hlavicka->f2a12dnyg46nyg46="1234.56";
$hlavicka->f2a12enyg46nyg46="1234.56";
$hlavicka->f2a12fnyg46nyg46="1234.56";
$hlavicka->f2a12gnyg46nyg46="1234.56";
$hlavicka->f2a12hnyg46nyg46="1234.56";
$hlavicka->f2a12inyg46nyg46="1234.56";
$hlavicka->f2a12jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a12b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a12bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a12c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a12d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a12dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a12e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a12f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a12g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a12h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a12i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a12j","$rmc",1,"R");

if( $hlavicka->f2a13b == 0 ) $hlavicka->f2a13b="";
if( $hlavicka->f2a13c == 0 ) $hlavicka->f2a13c="";
if( $hlavicka->f2a13d == 0 ) $hlavicka->f2a13d="";
if( $hlavicka->f2a13e == 0 ) $hlavicka->f2a13e="";
if( $hlavicka->f2a13f == 0 ) $hlavicka->f2a13f="";
if( $hlavicka->f2a13g == 0 ) $hlavicka->f2a13g="";
if( $hlavicka->f2a13h == 0 ) $hlavicka->f2a13h="";
if( $hlavicka->f2a13i == 0 ) $hlavicka->f2a13i="";
if( $hlavicka->f2a13j == 0 ) $hlavicka->f2a13j="";
if( $hlavicka->f2a13bx == 0 ) $hlavicka->f2a13bx="";
if( $hlavicka->f2a13dx == 0 ) $hlavicka->f2a13dx="";

$hlavicka->f2a13bnyg46nyg46="1234.56";
$hlavicka->f2a13cnyg46nyg46="1234.56";
$hlavicka->f2a13dnyg46nyg46="1234.56";
$hlavicka->f2a13enyg46nyg46="1234.56";
$hlavicka->f2a13fnyg46nyg46="1234.56";
$hlavicka->f2a13gnyg46nyg46="1234.56";
$hlavicka->f2a13hnyg46nyg46="1234.56";
$hlavicka->f2a13inyg46nyg46="1234.56";
$hlavicka->f2a13jnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a13b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a13bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a13c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a13d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a13dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a13e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a13f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a13g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a13h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a13i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a13j","$rmc",1,"R");

if( $hlavicka->f2a14b == 0 ) $hlavicka->f2a14b="";
if( $hlavicka->f2a14c == 0 ) $hlavicka->f2a14c="";
if( $hlavicka->f2a14d == 0 ) $hlavicka->f2a14d="";
if( $hlavicka->f2a14e == 0 ) $hlavicka->f2a14e="";
if( $hlavicka->f2a14f == 0 ) $hlavicka->f2a14f="";
if( $hlavicka->f2a14g == 0 ) $hlavicka->f2a14g="";
if( $hlavicka->f2a14h == 0 ) $hlavicka->f2a14h="";
if( $hlavicka->f2a14i == 0 ) $hlavicka->f2a14i="";
if( $hlavicka->f2a14j == 0 ) $hlavicka->f2a14j="";
if( $hlavicka->f2a14bx == 0 ) $hlavicka->f2a14bx="";
if( $hlavicka->f2a14dx == 0 ) $hlavicka->f2a14dx="";

$hlavicka->f2a14bnyg46nyg46="1234.56";
$hlavicka->f2a14cnyg46nyg46="1234.56";
$hlavicka->f2a14dnyg46nyg46="1234.56";
$hlavicka->f2a14enyg46nyg46="1234.56";
$hlavicka->f2a14fnyg46nyg46="1234.56";
$hlavicka->f2a14gnyg46nyg46="1234.56";
$hlavicka->f2a14hnyg46nyg46="1234.56";
$hlavicka->f2a14inyg46nyg46="1234.56";
$hlavicka->f2a14jnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a14b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a14bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a14c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a14d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a14dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a14e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a14f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a14g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a14h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a14i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a14j","$rmc",1,"R");

if( $hlavicka->f2a15b == 0 ) $hlavicka->f2a15b="";
if( $hlavicka->f2a15c == 0 ) $hlavicka->f2a15c="";
if( $hlavicka->f2a15d == 0 ) $hlavicka->f2a15d="";
if( $hlavicka->f2a15e == 0 ) $hlavicka->f2a15e="";
if( $hlavicka->f2a15f == 0 ) $hlavicka->f2a15f="";
if( $hlavicka->f2a15g == 0 ) $hlavicka->f2a15g="";
if( $hlavicka->f2a15h == 0 ) $hlavicka->f2a15h="";
if( $hlavicka->f2a15i == 0 ) $hlavicka->f2a15i="";
if( $hlavicka->f2a15j == 0 ) $hlavicka->f2a15j="";
if( $hlavicka->f2a15bx == 0 ) $hlavicka->f2a15bx="";
if( $hlavicka->f2a15dx == 0 ) $hlavicka->f2a15dx="";

$hlavicka->f2a15bnyg46nyg46="1234.56";
$hlavicka->f2a15cnyg46nyg46="1234.56";
$hlavicka->f2a15dnyg46nyg46="1234.56";
$hlavicka->f2a15enyg46nyg46="1234.56";
$hlavicka->f2a15fnyg46nyg46="1234.56";
$hlavicka->f2a15gnyg46nyg46="1234.56";
$hlavicka->f2a15hnyg46nyg46="1234.56";
$hlavicka->f2a15inyg46nyg46="1234.56";
$hlavicka->f2a15jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a15b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a15bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a15c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a15d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a15dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a15e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a15f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a15g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a15h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a15i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a15j","$rmc",1,"R");

//opravky
if( $hlavicka->f2a16b == 0 ) $hlavicka->f2a16b="";
if( $hlavicka->f2a16c == 0 ) $hlavicka->f2a16c="";
if( $hlavicka->f2a16d == 0 ) $hlavicka->f2a16d="";
if( $hlavicka->f2a16e == 0 ) $hlavicka->f2a16e="";
if( $hlavicka->f2a16f == 0 ) $hlavicka->f2a16f="";
if( $hlavicka->f2a16g == 0 ) $hlavicka->f2a16g="";
if( $hlavicka->f2a16h == 0 ) $hlavicka->f2a16h="";
if( $hlavicka->f2a16i == 0 ) $hlavicka->f2a16i="";
if( $hlavicka->f2a16j == 0 ) $hlavicka->f2a16j="";
if( $hlavicka->f2a16bx == 0 ) $hlavicka->f2a16bx="";
if( $hlavicka->f2a16dx == 0 ) $hlavicka->f2a16dx="";

$hlavicka->f2a16bnyg46nyg46="1234.56";
$hlavicka->f2a16cnyg46nyg46="1234.56";
$hlavicka->f2a16dnyg46nyg46="1234.56";
$hlavicka->f2a16enyg46nyg46="1234.56";
$hlavicka->f2a16fnyg46nyg46="1234.56";
$hlavicka->f2a16gnyg46nyg46="1234.56";
$hlavicka->f2a16hnyg46nyg46="1234.56";
$hlavicka->f2a16inyg46nyg46="1234.56";
$hlavicka->f2a16jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a16b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a16bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a16c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a16d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a16dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a16e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a16f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a16g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a16h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a16i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a16j","$rmc",1,"R");

if( $hlavicka->f2a17b == 0 ) $hlavicka->f2a17b="";
if( $hlavicka->f2a17c == 0 ) $hlavicka->f2a17c="";
if( $hlavicka->f2a17d == 0 ) $hlavicka->f2a17d="";
if( $hlavicka->f2a17e == 0 ) $hlavicka->f2a17e="";
if( $hlavicka->f2a17f == 0 ) $hlavicka->f2a17f="";
if( $hlavicka->f2a17g == 0 ) $hlavicka->f2a17g="";
if( $hlavicka->f2a17h == 0 ) $hlavicka->f2a17h="";
if( $hlavicka->f2a17i == 0 ) $hlavicka->f2a17i="";
if( $hlavicka->f2a17j == 0 ) $hlavicka->f2a17j="";
if( $hlavicka->f2a17bx == 0 ) $hlavicka->f2a17bx="";
if( $hlavicka->f2a17dx == 0 ) $hlavicka->f2a17dx="";

$hlavicka->f2a17bnyg46nyg46="1234.56";
$hlavicka->f2a17cnyg46nyg46="1234.56";
$hlavicka->f2a17dnyg46nyg46="1234.56";
$hlavicka->f2a17enyg46nyg46="1234.56";
$hlavicka->f2a17fnyg46nyg46="1234.56";
$hlavicka->f2a17gnyg46nyg46="1234.56";
$hlavicka->f2a17hnyg46nyg46="1234.56";
$hlavicka->f2a17inyg46nyg46="1234.56";
$hlavicka->f2a17jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a17b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a17bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a17c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a17d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a17dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a17e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a17f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a17g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a17h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a17i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a17j","$rmc",1,"R");


if( $hlavicka->f2a18b == 0 ) $hlavicka->f2a18b="";
if( $hlavicka->f2a18c == 0 ) $hlavicka->f2a18c="";
if( $hlavicka->f2a18d == 0 ) $hlavicka->f2a18d="";
if( $hlavicka->f2a18e == 0 ) $hlavicka->f2a18e="";
if( $hlavicka->f2a18f == 0 ) $hlavicka->f2a18f="";
if( $hlavicka->f2a18g == 0 ) $hlavicka->f2a18g="";
if( $hlavicka->f2a18h == 0 ) $hlavicka->f2a18h="";
if( $hlavicka->f2a18i == 0 ) $hlavicka->f2a18i="";
if( $hlavicka->f2a18j == 0 ) $hlavicka->f2a18j="";
if( $hlavicka->f2a18bx == 0 ) $hlavicka->f2a18bx="";
if( $hlavicka->f2a18dx == 0 ) $hlavicka->f2a18dx="";

$hlavicka->f2a18bnyg46nyg46="1234.56";
$hlavicka->f2a18cnyg46nyg46="1234.56";
$hlavicka->f2a18dnyg46nyg46="1234.56";
$hlavicka->f2a18enyg46nyg46="1234.56";
$hlavicka->f2a18fnyg46nyg46="1234.56";
$hlavicka->f2a18gnyg46nyg46="1234.56";
$hlavicka->f2a18hnyg46nyg46="1234.56";
$hlavicka->f2a18inyg46nyg46="1234.56";
$hlavicka->f2a18jnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a18b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a18bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a18c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a18d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a18dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a18e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a18f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a18g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a18h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a18i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a18j","$rmc",1,"R");

if( $hlavicka->f2a19b == 0 ) $hlavicka->f2a19b="";
if( $hlavicka->f2a19c == 0 ) $hlavicka->f2a19c="";
if( $hlavicka->f2a19d == 0 ) $hlavicka->f2a19d="";
if( $hlavicka->f2a19e == 0 ) $hlavicka->f2a19e="";
if( $hlavicka->f2a19f == 0 ) $hlavicka->f2a19f="";
if( $hlavicka->f2a19g == 0 ) $hlavicka->f2a19g="";
if( $hlavicka->f2a19h == 0 ) $hlavicka->f2a19h="";
if( $hlavicka->f2a19i == 0 ) $hlavicka->f2a19i="";
if( $hlavicka->f2a19j == 0 ) $hlavicka->f2a19j="";
if( $hlavicka->f2a19bx == 0 ) $hlavicka->f2a19bx="";
if( $hlavicka->f2a19dx == 0 ) $hlavicka->f2a19dx="";

$hlavicka->f2a19bnyg46nyg46="1234.56";
$hlavicka->f2a19cnyg46nyg46="1234.56";
$hlavicka->f2a19dnyg46nyg46="1234.56";
$hlavicka->f2a19enyg46nyg46="1234.56";
$hlavicka->f2a19fnyg46nyg46="1234.56";
$hlavicka->f2a19gnyg46nyg46="1234.56";
$hlavicka->f2a19hnyg46nyg46="1234.56";
$hlavicka->f2a19inyg46nyg46="1234.56";
$hlavicka->f2a19jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a19b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a19bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a19c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a19d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a19dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a19e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a19f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a19g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a19h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a19i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a19j","$rmc",1,"R");

//opravne polozky
if( $hlavicka->f2a110b == 0 ) $hlavicka->f2a110b="";
if( $hlavicka->f2a110c == 0 ) $hlavicka->f2a110c="";
if( $hlavicka->f2a110d == 0 ) $hlavicka->f2a110d="";
if( $hlavicka->f2a110e == 0 ) $hlavicka->f2a110e="";
if( $hlavicka->f2a110f == 0 ) $hlavicka->f2a110f="";
if( $hlavicka->f2a110g == 0 ) $hlavicka->f2a110g="";
if( $hlavicka->f2a110h == 0 ) $hlavicka->f2a110h="";
if( $hlavicka->f2a110i == 0 ) $hlavicka->f2a110i="";
if( $hlavicka->f2a110j == 0 ) $hlavicka->f2a110j="";
if( $hlavicka->f2a110bx == 0 ) $hlavicka->f2a110bx="";
if( $hlavicka->f2a110dx == 0 ) $hlavicka->f2a110dx="";

$hlavicka->f2a110bnyg46nyg46="1234.56";
$hlavicka->f2a110cnyg46nyg46="1234.56";
$hlavicka->f2a110dnyg46nyg46="1234.56";
$hlavicka->f2a110enyg46nyg46="1234.56";
$hlavicka->f2a110fnyg46nyg46="1234.56";
$hlavicka->f2a110gnyg46nyg46="1234.56";
$hlavicka->f2a110hnyg46nyg46="1234.56";
$hlavicka->f2a110inyg46nyg46="1234.56";
$hlavicka->f2a110jnyg46nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a110b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a110bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a110c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a110d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a110dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a110e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a110f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a110g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a110h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a110i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a110j","$rmc",1,"R");

if( $hlavicka->f2a111b == 0 ) $hlavicka->f2a111b="";
if( $hlavicka->f2a111c == 0 ) $hlavicka->f2a111c="";
if( $hlavicka->f2a111d == 0 ) $hlavicka->f2a111d="";
if( $hlavicka->f2a111e == 0 ) $hlavicka->f2a111e="";
if( $hlavicka->f2a111f == 0 ) $hlavicka->f2a111f="";
if( $hlavicka->f2a111g == 0 ) $hlavicka->f2a111g="";
if( $hlavicka->f2a111h == 0 ) $hlavicka->f2a111h="";
if( $hlavicka->f2a111i == 0 ) $hlavicka->f2a111i="";
if( $hlavicka->f2a111j == 0 ) $hlavicka->f2a111j="";
if( $hlavicka->f2a111bx == 0 ) $hlavicka->f2a111bx="";
if( $hlavicka->f2a111dx == 0 ) $hlavicka->f2a111dx="";

$hlavicka->f2a111bnyg46nyg46="1234.56";
$hlavicka->f2a111cnyg46nyg46="1234.56";
$hlavicka->f2a111dnyg46nyg46="1234.56";
$hlavicka->f2a111enyg46nyg46="1234.56";
$hlavicka->f2a111fnyg46nyg46="1234.56";
$hlavicka->f2a111gnyg46nyg46="1234.56";
$hlavicka->f2a111hnyg46nyg46="1234.56";
$hlavicka->f2a111inyg46nyg46="1234.56";
$hlavicka->f2a111jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a111b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a111bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a111c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a111d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a111dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a111e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a111f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a111g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a111h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a111i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a111j","$rmc",1,"R");


if( $hlavicka->f2a112b == 0 ) $hlavicka->f2a112b="";
if( $hlavicka->f2a112c == 0 ) $hlavicka->f2a112c="";
if( $hlavicka->f2a112d == 0 ) $hlavicka->f2a112d="";
if( $hlavicka->f2a112e == 0 ) $hlavicka->f2a112e="";
if( $hlavicka->f2a112f == 0 ) $hlavicka->f2a112f="";
if( $hlavicka->f2a112g == 0 ) $hlavicka->f2a112g="";
if( $hlavicka->f2a112h == 0 ) $hlavicka->f2a112h="";
if( $hlavicka->f2a112i == 0 ) $hlavicka->f2a112i="";
if( $hlavicka->f2a112j == 0 ) $hlavicka->f2a112j="";
if( $hlavicka->f2a112bx == 0 ) $hlavicka->f2a112bx="";
if( $hlavicka->f2a112dx == 0 ) $hlavicka->f2a112dx="";

$hlavicka->f2a112bnyg46nyg46="1234.56";
$hlavicka->f2a112cnyg46nyg46="1234.56";
$hlavicka->f2a112dnyg46nyg46="1234.56";
$hlavicka->f2a112enyg46nyg46="1234.56";
$hlavicka->f2a112fnyg46nyg46="1234.56";
$hlavicka->f2a112gnyg46nyg46="1234.56";
$hlavicka->f2a112hnyg46nyg46="1234.56";
$hlavicka->f2a112inyg46nyg46="1234.56";
$hlavicka->f2a112jnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a112b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a112bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a112c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a112d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a112dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a112e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a112f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a112g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a112h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a112i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a112j","$rmc",1,"R");

if( $hlavicka->f2a113b == 0 ) $hlavicka->f2a113b="";
if( $hlavicka->f2a113c == 0 ) $hlavicka->f2a113c="";
if( $hlavicka->f2a113d == 0 ) $hlavicka->f2a113d="";
if( $hlavicka->f2a113e == 0 ) $hlavicka->f2a113e="";
if( $hlavicka->f2a113f == 0 ) $hlavicka->f2a113f="";
if( $hlavicka->f2a113g == 0 ) $hlavicka->f2a113g="";
if( $hlavicka->f2a113h == 0 ) $hlavicka->f2a113h="";
if( $hlavicka->f2a113i == 0 ) $hlavicka->f2a113i="";
if( $hlavicka->f2a113j == 0 ) $hlavicka->f2a113j="";
if( $hlavicka->f2a113bx == 0 ) $hlavicka->f2a113bx="";
if( $hlavicka->f2a113dx == 0 ) $hlavicka->f2a113dx="";

$hlavicka->f2a113bnyg46nyg46="1234.56";
$hlavicka->f2a113cnyg46nyg46="1234.56";
$hlavicka->f2a113dnyg46nyg46="1234.56";
$hlavicka->f2a113enyg46nyg46="1234.56";
$hlavicka->f2a113fnyg46nyg46="1234.56";
$hlavicka->f2a113gnyg46nyg46="1234.56";
$hlavicka->f2a113hnyg46nyg46="1234.56";
$hlavicka->f2a113inyg46nyg46="1234.56";
$hlavicka->f2a113jnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a113b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a113bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a113c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a113d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a113dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a113e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a113f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a113g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a113h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a113i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a113j","$rmc",1,"R");

//zostatok
if( $hlavicka->f2a114b == 0 ) $hlavicka->f2a114b="";
if( $hlavicka->f2a114c == 0 ) $hlavicka->f2a114c="";
if( $hlavicka->f2a114d == 0 ) $hlavicka->f2a114d="";
if( $hlavicka->f2a114e == 0 ) $hlavicka->f2a114e="";
if( $hlavicka->f2a114f == 0 ) $hlavicka->f2a114f="";
if( $hlavicka->f2a114g == 0 ) $hlavicka->f2a114g="";
if( $hlavicka->f2a114h == 0 ) $hlavicka->f2a114h="";
if( $hlavicka->f2a114i == 0 ) $hlavicka->f2a114i="";
if( $hlavicka->f2a114j == 0 ) $hlavicka->f2a114j="";
if( $hlavicka->f2a114bx == 0 ) $hlavicka->f2a114bx="";
if( $hlavicka->f2a114dx == 0 ) $hlavicka->f2a114dx="";

$hlavicka->f2a114bnyg46nyg46="1234.56";
$hlavicka->f2a114cnyg46nyg46="1234.56";
$hlavicka->f2a114dnyg46nyg46="1234.56";
$hlavicka->f2a114enyg46nyg46="1234.56";
$hlavicka->f2a114fnyg46nyg46="1234.56";
$hlavicka->f2a114gnyg46nyg46="1234.56";
$hlavicka->f2a114hnyg46nyg46="1234.56";
$hlavicka->f2a114inyg46nyg46="1234.56";
$hlavicka->f2a114jnyg46nyg46="1234.56";

$pdf->Cell(90,11,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a114b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a114bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a114c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a114d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a114dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a114e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a114f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a114g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a114h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a114i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a114j","$rmc",1,"R");

if( $hlavicka->f2a115b == 0 ) $hlavicka->f2a115b="";
if( $hlavicka->f2a115c == 0 ) $hlavicka->f2a115c="";
if( $hlavicka->f2a115d == 0 ) $hlavicka->f2a115d="";
if( $hlavicka->f2a115e == 0 ) $hlavicka->f2a115e="";
if( $hlavicka->f2a115f == 0 ) $hlavicka->f2a115f="";
if( $hlavicka->f2a115g == 0 ) $hlavicka->f2a115g="";
if( $hlavicka->f2a115h == 0 ) $hlavicka->f2a115h="";
if( $hlavicka->f2a115i == 0 ) $hlavicka->f2a115i="";
if( $hlavicka->f2a115j == 0 ) $hlavicka->f2a115j="";
if( $hlavicka->f2a115bx == 0 ) $hlavicka->f2a115bx="";
if( $hlavicka->f2a115dx == 0 ) $hlavicka->f2a115dx="";

$hlavicka->f2a115bnyg46nyg46="1234.56";
$hlavicka->f2a115cnyg46nyg46="1234.56";
$hlavicka->f2a115dnyg46nyg46="1234.56";
$hlavicka->f2a115enyg46nyg46="1234.56";
$hlavicka->f2a115fnyg46nyg46="1234.56";
$hlavicka->f2a115gnyg46nyg46="1234.56";
$hlavicka->f2a115hnyg46nyg46="1234.56";
$hlavicka->f2a115inyg46nyg46="1234.56";
$hlavicka->f2a115jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(23,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f2a115b","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a115bx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a115c","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a115d","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a115dx","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a115e","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a115f","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a115g","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a115h","$rmc",0,"R");$pdf->Cell(15,5,"$hlavicka->f2a115i","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->f2a115j","$rmc",1,"R");



$pdf->Cell(90,55,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 1 Dlhodob˝ hmotn˝ majetok a z·loûnÈ pr·vo","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',9);
//6. info k casti F pism. c o dlhodobom HM
$pdf->SetFont('arial','',9);

if( $hlavicka->f2c1 == 0 ) $hlavicka->f2c1="";
if( $hlavicka->f2c2 == 0 ) $hlavicka->f2c2="";

$hlavicka->f2c1nyg46nyg46="1234.56";
$hlavicka->f2c2nyg46nyg46="1234.56";

$pdf->Cell(125,5,"     ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->f2c1","$rmc",1,"R");
$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(125,5,"     ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->f2c2","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text5"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(185);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(4,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text7"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(267);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(4,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 7
    }


}
$i = $i + 1;

  }


$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_no2011s2 WHERE psys >= 0 ".""; 

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



//tlac strana 8
if ( $nopg8 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab7_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab7_1.jpg',10,20,190,150);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab8.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab8.jpg',1,240,210,30);
}

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(2,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 4 o zmen·ch jednotliv˝ch poloûiek DlhodobÈho finanËnÈho majetku","$rmc",1,"L");
$pdf->Cell(90,41,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',7);

//7.info k casti F pism. o dlhodobom financnom majetku a tabulka 1. bezny rok
//prvotne ocenenie f1j1b
if( $hlavicka->f1j1b == 0 ) $hlavicka->f1j1b="";
if( $hlavicka->f1j1c == 0 ) $hlavicka->f1j1c="";
if( $hlavicka->f1j1d == 0 ) $hlavicka->f1j1d="";
if( $hlavicka->f1j1e == 0 ) $hlavicka->f1j1e="";
if( $hlavicka->f1j1f == 0 ) $hlavicka->f1j1f="";
if( $hlavicka->f1j1g == 0 ) $hlavicka->f1j1g="";
if( $hlavicka->f1j1h == 0 ) $hlavicka->f1j1h="";
if( $hlavicka->f1j1i == 0 ) $hlavicka->f1j1i="";
if( $hlavicka->f1j1j == 0 ) $hlavicka->f1j1j="";

$hlavicka->f1j1bnyg46nyg46="1234.56";
$hlavicka->f1j1cnyg46nyg46="1234.56";
$hlavicka->f1j1dnyg46nyg46="1234.56";
$hlavicka->f1j1enyg46nyg46="1234.56";
$hlavicka->f1j1fnyg46nyg46="1234.56";
$hlavicka->f1j1gnyg46nyg46="1234.56";
$hlavicka->f1j1hnyg46nyg46="1234.56";
$hlavicka->f1j1inyg46nyg46="1234.56";
$hlavicka->f1j1jnyg46nyg46="1234.56";

$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j1c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j1d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j1e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j1f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j1h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j1i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j1j","$rmc",1,"R");


if( $hlavicka->f1j2b == 0 ) $hlavicka->f1j2b="";
if( $hlavicka->f1j2c == 0 ) $hlavicka->f1j2c="";
if( $hlavicka->f1j2d == 0 ) $hlavicka->f1j2d="";
if( $hlavicka->f1j2e == 0 ) $hlavicka->f1j2e="";
if( $hlavicka->f1j2f == 0 ) $hlavicka->f1j2f="";
if( $hlavicka->f1j2g == 0 ) $hlavicka->f1j2g="";
if( $hlavicka->f1j2h == 0 ) $hlavicka->f1j2h="";
if( $hlavicka->f1j2i == 0 ) $hlavicka->f1j2i="";
if( $hlavicka->f1j2j == 0 ) $hlavicka->f1j2j="";

$hlavicka->f1j2bnyg46nyg46="1234.56";
$hlavicka->f1j2cnyg46nyg46="1234.56";
$hlavicka->f1j2dnyg46nyg46="1234.56";
$hlavicka->f1j2enyg46nyg46="1234.56";
$hlavicka->f1j2fnyg46nyg46="1234.56";
$hlavicka->f1j2gnyg46nyg46="1234.56";
$hlavicka->f1j2hnyg46nyg46="1234.56";
$hlavicka->f1j2inyg46nyg46="1234.56";
$hlavicka->f1j2jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j2c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j2d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j2e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j2f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j2h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j2i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j2j","$rmc",1,"R");

if( $hlavicka->f1j3b == 0 ) $hlavicka->f1j3b="";
if( $hlavicka->f1j3c == 0 ) $hlavicka->f1j3c="";
if( $hlavicka->f1j3d == 0 ) $hlavicka->f1j3d="";
if( $hlavicka->f1j3e == 0 ) $hlavicka->f1j3e="";
if( $hlavicka->f1j3f == 0 ) $hlavicka->f1j3f="";
if( $hlavicka->f1j3g == 0 ) $hlavicka->f1j3g="";
if( $hlavicka->f1j3h == 0 ) $hlavicka->f1j3h="";
if( $hlavicka->f1j3i == 0 ) $hlavicka->f1j3i="";
if( $hlavicka->f1j3j == 0 ) $hlavicka->f1j3j="";

$hlavicka->f1j3bnyg46nyg46="1234.56";
$hlavicka->f1j3cnyg46nyg46="1234.56";
$hlavicka->f1j3dnyg46nyg46="1234.56";
$hlavicka->f1j3enyg46nyg46="1234.56";
$hlavicka->f1j3fnyg46nyg46="1234.56";
$hlavicka->f1j3gnyg46nyg46="1234.56";
$hlavicka->f1j3hnyg46nyg46="1234.56";
$hlavicka->f1j3inyg46nyg46="1234.56";
$hlavicka->f1j3jnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j3b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j3c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j3d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j3e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j3f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j3h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j3i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j3j","$rmc",1,"R");

if( $hlavicka->f1j4b == 0 ) $hlavicka->f1j4b="";
if( $hlavicka->f1j4c == 0 ) $hlavicka->f1j4c="";
if( $hlavicka->f1j4d == 0 ) $hlavicka->f1j4d="";
if( $hlavicka->f1j4e == 0 ) $hlavicka->f1j4e="";
if( $hlavicka->f1j4f == 0 ) $hlavicka->f1j4f="";
if( $hlavicka->f1j4g == 0 ) $hlavicka->f1j4g="";
if( $hlavicka->f1j4h == 0 ) $hlavicka->f1j4h="";
if( $hlavicka->f1j4i == 0 ) $hlavicka->f1j4i="";
if( $hlavicka->f1j4j == 0 ) $hlavicka->f1j4j="";

$hlavicka->f1j4bnyg46nyg46="1234.56";
$hlavicka->f1j4cnyg46nyg46="1234.56";
$hlavicka->f1j4dnyg46nyg46="1234.56";
$hlavicka->f1j4enyg46nyg46="1234.56";
$hlavicka->f1j4fnyg46nyg46="1234.56";
$hlavicka->f1j4gnyg46nyg46="1234.56";
$hlavicka->f1j4hnyg46nyg46="1234.56";
$hlavicka->f1j4inyg46nyg46="1234.56";
$hlavicka->f1j4jnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j4b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j4c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j4d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j4e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j4f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j4h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j4i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j4j","$rmc",1,"R");

if( $hlavicka->f1j5b == 0 ) $hlavicka->f1j5b="";
if( $hlavicka->f1j5c == 0 ) $hlavicka->f1j5c="";
if( $hlavicka->f1j5d == 0 ) $hlavicka->f1j5d="";
if( $hlavicka->f1j5e == 0 ) $hlavicka->f1j5e="";
if( $hlavicka->f1j5f == 0 ) $hlavicka->f1j5f="";
if( $hlavicka->f1j5g == 0 ) $hlavicka->f1j5g="";
if( $hlavicka->f1j5h == 0 ) $hlavicka->f1j5h="";
if( $hlavicka->f1j5i == 0 ) $hlavicka->f1j5i="";
if( $hlavicka->f1j5j == 0 ) $hlavicka->f1j5j="";

$hlavicka->f1j5bnyg46nyg46="1234.56";
$hlavicka->f1j5cnyg46nyg46="1234.56";
$hlavicka->f1j5dnyg46nyg46="1234.56";
$hlavicka->f1j5enyg46nyg46="1234.56";
$hlavicka->f1j5fnyg46nyg46="1234.56";
$hlavicka->f1j5gnyg46nyg46="1234.56";
$hlavicka->f1j5hnyg46nyg46="1234.56";
$hlavicka->f1j5inyg46nyg46="1234.56";
$hlavicka->f1j5jnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j5b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j5c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j5d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j5e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j5f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j5h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j5i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j5j","$rmc",1,"R");

//opravne polozky
if( $hlavicka->f1j6b == 0 ) $hlavicka->f1j6b="";
if( $hlavicka->f1j6c == 0 ) $hlavicka->f1j6c="";
if( $hlavicka->f1j6d == 0 ) $hlavicka->f1j6d="";
if( $hlavicka->f1j6e == 0 ) $hlavicka->f1j6e="";
if( $hlavicka->f1j6f == 0 ) $hlavicka->f1j6f="";
if( $hlavicka->f1j6g == 0 ) $hlavicka->f1j6g="";
if( $hlavicka->f1j6h == 0 ) $hlavicka->f1j6h="";
if( $hlavicka->f1j6i == 0 ) $hlavicka->f1j6i="";
if( $hlavicka->f1j6j == 0 ) $hlavicka->f1j6j="";

$hlavicka->f1j6bnyg46nyg46="1234.56";
$hlavicka->f1j6cnyg46nyg46="1234.56";
$hlavicka->f1j6dnyg46nyg46="1234.56";
$hlavicka->f1j6enyg46nyg46="1234.56";
$hlavicka->f1j6fnyg46nyg46="1234.56";
$hlavicka->f1j6gnyg46nyg46="1234.56";
$hlavicka->f1j6hnyg46nyg46="1234.56";
$hlavicka->f1j6inyg46nyg46="1234.56";
$hlavicka->f1j6jnyg46nyg46="1234.56";

$pdf->Cell(90,12,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j6b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j6c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j6d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j6e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j6f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j6h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j6i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j6j","$rmc",1,"R");

if( $hlavicka->f1j7b == 0 ) $hlavicka->f1j7b="";
if( $hlavicka->f1j7c == 0 ) $hlavicka->f1j7c="";
if( $hlavicka->f1j7d == 0 ) $hlavicka->f1j7d="";
if( $hlavicka->f1j7e == 0 ) $hlavicka->f1j7e="";
if( $hlavicka->f1j7f == 0 ) $hlavicka->f1j7f="";
if( $hlavicka->f1j7g == 0 ) $hlavicka->f1j7g="";
if( $hlavicka->f1j7h == 0 ) $hlavicka->f1j7h="";
if( $hlavicka->f1j7i == 0 ) $hlavicka->f1j7i="";
if( $hlavicka->f1j7j == 0 ) $hlavicka->f1j7j="";

$hlavicka->f1j7bnyg46nyg46="1234.56";
$hlavicka->f1j7cnyg46nyg46="1234.56";
$hlavicka->f1j7dnyg46nyg46="1234.56";
$hlavicka->f1j7enyg46nyg46="1234.56";
$hlavicka->f1j7fnyg46nyg46="1234.56";
$hlavicka->f1j7gnyg46nyg46="1234.56";
$hlavicka->f1j7hnyg46nyg46="1234.56";
$hlavicka->f1j7inyg46nyg46="1234.56";
$hlavicka->f1j7jnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j7b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j7c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j7d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j7e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j7f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j7h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j7i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j7j","$rmc",1,"R");


if( $hlavicka->f1j8b == 0 ) $hlavicka->f1j8b="";
if( $hlavicka->f1j8c == 0 ) $hlavicka->f1j8c="";
if( $hlavicka->f1j8d == 0 ) $hlavicka->f1j8d="";
if( $hlavicka->f1j8e == 0 ) $hlavicka->f1j8e="";
if( $hlavicka->f1j8f == 0 ) $hlavicka->f1j8f="";
if( $hlavicka->f1j8g == 0 ) $hlavicka->f1j8g="";
if( $hlavicka->f1j8h == 0 ) $hlavicka->f1j8h="";
if( $hlavicka->f1j8i == 0 ) $hlavicka->f1j8i="";
if( $hlavicka->f1j8j == 0 ) $hlavicka->f1j8j="";

$hlavicka->f1j8bnyg46nyg46="1234.56";
$hlavicka->f1j8cnyg46nyg46="1234.56";
$hlavicka->f1j8dnyg46nyg46="1234.56";
$hlavicka->f1j8enyg46nyg46="1234.56";
$hlavicka->f1j8fnyg46nyg46="1234.56";
$hlavicka->f1j8gnyg46nyg46="1234.56";
$hlavicka->f1j8hnyg46nyg46="1234.56";
$hlavicka->f1j8inyg46nyg46="1234.56";
$hlavicka->f1j8jnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j8b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j8c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j8d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j8e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j8f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j8h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j8i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j8j","$rmc",1,"R");

if( $hlavicka->f1j9b == 0 ) $hlavicka->f1j9b="";
if( $hlavicka->f1j9c == 0 ) $hlavicka->f1j9c="";
if( $hlavicka->f1j9d == 0 ) $hlavicka->f1j9d="";
if( $hlavicka->f1j9e == 0 ) $hlavicka->f1j9e="";
if( $hlavicka->f1j9f == 0 ) $hlavicka->f1j9f="";
if( $hlavicka->f1j9g == 0 ) $hlavicka->f1j9g="";
if( $hlavicka->f1j9h == 0 ) $hlavicka->f1j9h="";
if( $hlavicka->f1j9i == 0 ) $hlavicka->f1j9i="";
if( $hlavicka->f1j9j == 0 ) $hlavicka->f1j9j="";

$hlavicka->f1j9bnyg46nyg46="1234.56";
$hlavicka->f1j9cnyg46nyg46="1234.56";
$hlavicka->f1j9dnyg46nyg46="1234.56";
$hlavicka->f1j9enyg46nyg46="1234.56";
$hlavicka->f1j9fnyg46nyg46="1234.56";
$hlavicka->f1j9gnyg46nyg46="1234.56";
$hlavicka->f1j9hnyg46nyg46="1234.56";
$hlavicka->f1j9inyg46nyg46="1234.56";
$hlavicka->f1j9jnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j9b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j9c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j9d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j9e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j9f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j9h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j9i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j9j","$rmc",1,"R");

//uctovna hodnota
if( $hlavicka->f1j10b == 0 ) $hlavicka->f1j10b="";
if( $hlavicka->f1j10c == 0 ) $hlavicka->f1j10c="";
if( $hlavicka->f1j10d == 0 ) $hlavicka->f1j10d="";
if( $hlavicka->f1j10e == 0 ) $hlavicka->f1j10e="";
if( $hlavicka->f1j10f == 0 ) $hlavicka->f1j10f="";
if( $hlavicka->f1j10g == 0 ) $hlavicka->f1j10g="";
if( $hlavicka->f1j10h == 0 ) $hlavicka->f1j10h="";
if( $hlavicka->f1j10i == 0 ) $hlavicka->f1j10i="";
if( $hlavicka->f1j10j == 0 ) $hlavicka->f1j10j="";

$hlavicka->f1j10bnyg46nyg46="1234.56";
$hlavicka->f1j10cnyg46nyg46="1234.56";
$hlavicka->f1j10dnyg46nyg46="1234.56";
$hlavicka->f1j10enyg46nyg46="1234.56";
$hlavicka->f1j10fnyg46nyg46="1234.56";
$hlavicka->f1j10gnyg46nyg46="1234.56";
$hlavicka->f1j10hnyg46nyg46="1234.56";
$hlavicka->f1j10inyg46nyg46="1234.56";
$hlavicka->f1j10jnyg46nyg46="1234.56";

$pdf->Cell(90,13,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j10b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j10c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j10d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j10e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j10f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j10h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j10i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j10j","$rmc",1,"R");

if( $hlavicka->f1j11b == 0 ) $hlavicka->f1j11b="";
if( $hlavicka->f1j11c == 0 ) $hlavicka->f1j11c="";
if( $hlavicka->f1j11d == 0 ) $hlavicka->f1j11d="";
if( $hlavicka->f1j11e == 0 ) $hlavicka->f1j11e="";
if( $hlavicka->f1j11f == 0 ) $hlavicka->f1j11f="";
if( $hlavicka->f1j11g == 0 ) $hlavicka->f1j11g="";
if( $hlavicka->f1j11h == 0 ) $hlavicka->f1j11h="";
if( $hlavicka->f1j11i == 0 ) $hlavicka->f1j11i="";
if( $hlavicka->f1j11j == 0 ) $hlavicka->f1j11j="";

$hlavicka->f1j11bnyg46nyg46="1234.56";
$hlavicka->f1j11cnyg46nyg46="1234.56";
$hlavicka->f1j11dnyg46nyg46="1234.56";
$hlavicka->f1j11enyg46nyg46="1234.56";
$hlavicka->f1j11fnyg46nyg46="1234.56";
$hlavicka->f1j11gnyg46nyg46="1234.56";
$hlavicka->f1j11hnyg46nyg46="1234.56";
$hlavicka->f1j11inyg46nyg46="1234.56";
$hlavicka->f1j11jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(47,5,"     ","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->f1j11b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1j11c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1j11d","$rmc",0,"R");$pdf->Cell(19,5,"$hlavicka->f1j11e","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f1j11f","$rmc",0,"R");
$pdf->Cell(17,5,"$hlavicka->f1j11h","$rmc",0,"R");$pdf->Cell(16,5,"$hlavicka->f1j11i","$rmc",0,"R");
$pdf->Cell(13,5,"$hlavicka->f1j11j","$rmc",1,"R");


//8. info k casti F pism. c o dlhodobom fin.majetku
$pdf->Cell(90,73,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 4 Dlhodob˝ finanËn˝ majetok a z·loûnÈ pr·vo","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);

if( $hlavicka->fm1 == 0 ) $hlavicka->fm1="";
if( $hlavicka->fm2 == 0 ) $hlavicka->fm2="";


$hlavicka->fm1nyg46nyg46="1234.56";
$hlavicka->fm2nyg46nyg46="1234.56";

$pdf->SetFont('arial','',9);
$pdf->Cell(127,5,"     ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->fm1","$rmc",1,"R");
$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(127,5,"     ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->fm2","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text8"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(170);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(2,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text10"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(270);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(6,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 8
    }




//tlac strana 9
if ( $nopg9 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab9.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab9.jpg',10,22,190,50);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab18_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab18_1.jpg',20,118,170,50);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab18_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab18_2.jpg',20,196,170,60);
}

$pdf->Cell(90,8,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(2,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods.4 Inform·cie o ötrukt˙re dlhodobÈho finanËnÈho majetku","$rmc",1,"L");
$pdf->Cell(90,32,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',7);
//9.info k casti F pism. i o strukture dlhodobeho financ.majetku 
if( $hlavicka->f1i1b == 0 ) $hlavicka->f1i1b="";
if( $hlavicka->f1i1c == 0 ) $hlavicka->f1i1c="";
if( $hlavicka->f1i1d == 0 ) $hlavicka->f1i1d="";
if( $hlavicka->f1i1e == 0 ) $hlavicka->f1i1e="";
if( $hlavicka->f1i1f == 0 ) $hlavicka->f1i1f="";
if( $hlavicka->f1i1fx == 0 ) $hlavicka->f1i1fx="";

$hlavicka->f1i1anyg46nyg46="1234.56";
$hlavicka->f1i1bnyg46nyg46="1234.56";
$hlavicka->f1i1cnyg46nyg46="1234.56";
$hlavicka->f1i1dnyg46nyg46="1234.56";
$hlavicka->f1i1enyg46nyg46="1234.56";
$hlavicka->f1i1fnyg46nyg46="1234.56";

$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(42,5,"$hlavicka->f1i1a","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->f1i1b","$rmc",0,"R");$pdf->Cell(31,5,"$hlavicka->f1i1c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1i1d","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->f1i1e","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f1i1f","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->f1i1fx","$rmc",1,"R");

if( $hlavicka->f1i2b == 0 ) $hlavicka->f1i2b="";
if( $hlavicka->f1i2c == 0 ) $hlavicka->f1i2c="";
if( $hlavicka->f1i2d == 0 ) $hlavicka->f1i2d="";
if( $hlavicka->f1i2e == 0 ) $hlavicka->f1i2e="";
if( $hlavicka->f1i2f == 0 ) $hlavicka->f1i2f="";
if( $hlavicka->f1i2fx == 0 ) $hlavicka->f1i2fx="";

$hlavicka->f1i2anyg46nyg46="1234.56";
$hlavicka->f1i2bnyg46nyg46="1234.56";
$hlavicka->f1i2cnyg46nyg46="1234.56";
$hlavicka->f1i2dnyg46nyg46="1234.56";
$hlavicka->f1i2enyg46nyg46="1234.56";
$hlavicka->f1i2fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(42,5,"$hlavicka->f1i2a","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->f1i2b","$rmc",0,"R");$pdf->Cell(31,5,"$hlavicka->f1i2c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1i2d","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->f1i2e","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f1i2f","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->f1i2fx","$rmc",1,"R");

if( $hlavicka->f1i3b == 0 ) $hlavicka->f1i3b="";
if( $hlavicka->f1i3c == 0 ) $hlavicka->f1i3c="";
if( $hlavicka->f1i3d == 0 ) $hlavicka->f1i3d="";
if( $hlavicka->f1i3e == 0 ) $hlavicka->f1i3e="";
if( $hlavicka->f1i3f == 0 ) $hlavicka->f1i3f="";
if( $hlavicka->f1i3fx == 0 ) $hlavicka->f1i3fx="";

$hlavicka->f1i3anyg46nyg46="1234.56";
$hlavicka->f1i3bnyg46nyg46="1234.56";
$hlavicka->f1i3cnyg46nyg46="1234.56";
$hlavicka->f1i3dnyg46nyg46="1234.56";
$hlavicka->f1i3enyg46nyg46="1234.56";
$hlavicka->f1i3fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(42,5,"$hlavicka->f1i3a","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->f1i3b","$rmc",0,"R");$pdf->Cell(31,5,"$hlavicka->f1i3c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1i3d","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->f1i3e","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f1i3f","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->f1i3fx","$rmc",1,"R");


$pdf->Cell(90,40,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(10,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 6 Kr·tkodob˝ finanËn˝ majetok ","$rmc",1,"L");
$pdf->Cell(10,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabuæka 1","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//18.info k casti F pism. w o krat.FM
if( $hlavicka->f1w11 == 0 ) $hlavicka->f1w11="";
if( $hlavicka->f1w12 == 0 ) $hlavicka->f1w12="";

$hlavicka->f1w11nyg46nyg46="1234.56";
$hlavicka->f1w12nyg46nyg46="1234.56";

$pdf->Cell(70,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w11","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->f1w12","$rmc",1,"R");

if( $hlavicka->f1w11x == 0 ) $hlavicka->f1w11x="";
if( $hlavicka->f1w12x == 0 ) $hlavicka->f1w12x="";

$hlavicka->f1w11xnyg46nyg46="1234.56";
$hlavicka->f1w12xnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(70,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w11x","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->f1w12x","$rmc",1,"R");


if( $hlavicka->f1w21 == 0 ) $hlavicka->f1w21="";
if( $hlavicka->f1w22 == 0 ) $hlavicka->f1w22="";

$hlavicka->f1w21nyg46nyg46="1234.56";
$hlavicka->f1w22nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(70,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w21","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->f1w22","$rmc",1,"R");

if( $hlavicka->f1w31 == 0 ) $hlavicka->f1w31="";
if( $hlavicka->f1w32 == 0 ) $hlavicka->f1w32="";

$hlavicka->f1w31nyg46nyg46="1234.56";
$hlavicka->f1w32nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(70,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w31","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->f1w32","$rmc",1,"R");

if( $hlavicka->f1w41 == 0 ) $hlavicka->f1w41="";
if( $hlavicka->f1w42 == 0 ) $hlavicka->f1w42="";

$hlavicka->f1w41nyg46nyg46="1234.56";
$hlavicka->f1w42nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(70,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w41","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->f1w42","$rmc",1,"R");

if( $hlavicka->f1w991 == 0 ) $hlavicka->f1w991="";
if( $hlavicka->f1w992 == 0 ) $hlavicka->f1w992="";

$hlavicka->f1w991nyg46nyg46="1234.56";
$hlavicka->f1w992nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(70,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w991","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->f1w992","$rmc",1,"R");


$pdf->Cell(90,21,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(10,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 6 Kr·tkodob˝ finanËn˝ majetok ","$rmc",1,"L");
$pdf->Cell(10,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabuæka 2","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//18.info k casti F pism. w o krat.FM tabulka 2
if( $hlavicka->f2w1b == 0 ) $hlavicka->f2w1b="";
if( $hlavicka->f2w1c == 0 ) $hlavicka->f2w1c="";
if( $hlavicka->f2w1d == 0 ) $hlavicka->f2w1d="";
if( $hlavicka->f2w1e == 0 ) $hlavicka->f2w1e="";

$hlavicka->f2w1bnyg46nyg46="1234.56";
$hlavicka->f2w1cnyg46nyg46="1234.56";
$hlavicka->f2w1dnyg46nyg46="1234.56";
$hlavicka->f2w1enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(27,5,"$hlavicka->f2w1b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f2w1c","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->f2w1d","$rmc",0,"R");$pdf->Cell(42,5,"$hlavicka->f2w1e","$rmc",1,"R");

if( $hlavicka->f2w2b == 0 ) $hlavicka->f2w2b="";
if( $hlavicka->f2w2c == 0 ) $hlavicka->f2w2c="";
if( $hlavicka->f2w2d == 0 ) $hlavicka->f2w2d="";
if( $hlavicka->f2w2e == 0 ) $hlavicka->f2w2e="";

$hlavicka->f2w2bnyg46nyg46="1234.56";
$hlavicka->f2w2cnyg46nyg46="1234.56";
$hlavicka->f2w2dnyg46nyg46="1234.56";
$hlavicka->f2w2enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(27,5,"$hlavicka->f2w2b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f2w2c","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->f2w2d","$rmc",0,"R");$pdf->Cell(42,5,"$hlavicka->f2w2e","$rmc",1,"R");

if( $hlavicka->f2w4b == 0 ) $hlavicka->f2w4b="";
if( $hlavicka->f2w4c == 0 ) $hlavicka->f2w4c="";
if( $hlavicka->f2w4d == 0 ) $hlavicka->f2w4d="";
if( $hlavicka->f2w4e == 0 ) $hlavicka->f2w4e="";

$hlavicka->f2w4bnyg46nyg46="1234.56";
$hlavicka->f2w4cnyg46nyg46="1234.56";
$hlavicka->f2w4dnyg46nyg46="1234.56";
$hlavicka->f2w4enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(27,5,"$hlavicka->f2w4b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f2w4c","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->f2w4d","$rmc",0,"R");$pdf->Cell(42,5,"$hlavicka->f2w4e","$rmc",1,"R");

if( $hlavicka->f2w5b == 0 ) $hlavicka->f2w5b="";
if( $hlavicka->f2w5c == 0 ) $hlavicka->f2w5c="";
if( $hlavicka->f2w5d == 0 ) $hlavicka->f2w5d="";
if( $hlavicka->f2w5e == 0 ) $hlavicka->f2w5e="";

$hlavicka->f2w5bnyg46nyg46="1234.56";
$hlavicka->f2w5cnyg46nyg46="1234.56";
$hlavicka->f2w5dnyg46nyg46="1234.56";
$hlavicka->f2w5enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(27,5,"$hlavicka->f2w5b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f2w5c","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->f2w5d","$rmc",0,"R");$pdf->Cell(42,5,"$hlavicka->f2w5e","$rmc",1,"R");

if( $hlavicka->f2w6b == 0 ) $hlavicka->f2w6b="";
if( $hlavicka->f2w6c == 0 ) $hlavicka->f2w6c="";
if( $hlavicka->f2w6d == 0 ) $hlavicka->f2w6d="";
if( $hlavicka->f2w6e == 0 ) $hlavicka->f2w6e="";

$hlavicka->f2w6bnyg46nyg46="1234.56";
$hlavicka->f2w6cnyg46nyg46="1234.56";
$hlavicka->f2w6dnyg46nyg46="1234.56";
$hlavicka->f2w6enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(27,5,"$hlavicka->f2w6b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f2w6c","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->f2w6d","$rmc",0,"R");$pdf->Cell(42,5,"$hlavicka->f2w6e","$rmc",1,"R");

if( $hlavicka->f2w99b == 0 ) $hlavicka->f2w99b="";
if( $hlavicka->f2w99c == 0 ) $hlavicka->f2w99c="";
if( $hlavicka->f2w99d == 0 ) $hlavicka->f2w99d="";
if( $hlavicka->f2w99e == 0 ) $hlavicka->f2w99e="";

$hlavicka->f2w99bnyg46nyg46="1234.56";
$hlavicka->f2w99cnyg46nyg46="1234.56";
$hlavicka->f2w99dnyg46nyg46="1234.56";
$hlavicka->f2w99enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(27,5,"$hlavicka->f2w99b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->f2w99c","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->f2w99d","$rmc",0,"R");$pdf->Cell(42,5,"$hlavicka->f2w99e","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text11"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(73);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text25"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(167);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(10,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text26"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(255);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(10,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 9
    }



//tlac strana 10
if ( $nopg10 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab21.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab21.jpg',14,23,196,45);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab12_1rok2013.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab12_1rok2013.jpg',14,100,196,58);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab12_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab12_2.jpg',0,180,210,30);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab13.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab13.jpg',0,240,210,30);
}

$pdf->Cell(90,10,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 6 Ocenenie KFM, ku dÚu zostavenia ⁄Z re·lnou hodnotou","$rmc",1,"L");
$pdf->Cell(90,15,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//21.info k casti F pism. za o oceneni krat.FM tabulka 2
if( $hlavicka->fza1b == 0 ) $hlavicka->fza1b="";
if( $hlavicka->fza1c == 0 ) $hlavicka->fza1c="";
if( $hlavicka->fza1d == 0 ) $hlavicka->fza1d="";

$hlavicka->fza1bnyg46nyg46="1234.56";
$hlavicka->fza1cnyg46nyg46="1234.56";
$hlavicka->fza1dnyg46nyg46="1234.56";

$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza1b","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->fza1c","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->fza1d","$rmc",1,"R");

if( $hlavicka->fza2b == 0 ) $hlavicka->fza2b="";
if( $hlavicka->fza2c == 0 ) $hlavicka->fza2c="";
if( $hlavicka->fza2d == 0 ) $hlavicka->fza2d="";

$hlavicka->fza2bnyg46nyg46="1234.56";
$hlavicka->fza2cnyg46nyg46="1234.56";
$hlavicka->fza2dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza2b","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->fza2c","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->fza2d","$rmc",1,"R");

if( $hlavicka->fza4b == 0 ) $hlavicka->fza4b="";
if( $hlavicka->fza4c == 0 ) $hlavicka->fza4c="";
if( $hlavicka->fza4d == 0 ) $hlavicka->fza4d="";

$hlavicka->fza4bnyg46nyg46="1234.56";
$hlavicka->fza4cnyg46nyg46="1234.56";
$hlavicka->fza4dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza4b","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->fza4c","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->fza4d","$rmc",1,"R");

if( $hlavicka->fza99b == 0 ) $hlavicka->fza99b="";
if( $hlavicka->fza99c == 0 ) $hlavicka->fza99c="";
if( $hlavicka->fza99d == 0 ) $hlavicka->fza99d="";

$hlavicka->fza99bnyg46nyg46="1234.56";
$hlavicka->fza99cnyg46nyg46="1234.56";
$hlavicka->fza99dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza99b","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->fza99c","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->fza99d","$rmc",1,"R");




$pdf->Cell(90,28,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 7 OpravnÈ poloûky k z·sob·m ","$rmc",1,"L");
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabuæka 1","$rmc",1,"L");
$pdf->Cell(90,6,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);

//12.info k casti F pism. o o opravnych polozkach tab1
if( $hlavicka->f1o1b == 0 ) $hlavicka->f1o1b="";
if( $hlavicka->f1o1c == 0 ) $hlavicka->f1o1c="";
if( $hlavicka->f1o1d == 0 ) $hlavicka->f1o1d="";
if( $hlavicka->f1o1e == 0 ) $hlavicka->f1o1e="";
if( $hlavicka->f1o1f == 0 ) $hlavicka->f1o1f="";

$hlavicka->f1o2bnyg46nyg46="1234.56";
$hlavicka->f1o2cnyg46nyg46="1234.56";
$hlavicka->f1o2dnyg46nyg46="1234.56";
$hlavicka->f1o2enyg46nyg46="1234.56";
$hlavicka->f1o2fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o1b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o1d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o1e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o1f","$rmc",1,"R");


if( $hlavicka->f1o2b == 0 ) $hlavicka->f1o2b="";
if( $hlavicka->f1o2c == 0 ) $hlavicka->f1o2c="";
if( $hlavicka->f1o2d == 0 ) $hlavicka->f1o2d="";
if( $hlavicka->f1o2e == 0 ) $hlavicka->f1o2e="";
if( $hlavicka->f1o2f == 0 ) $hlavicka->f1o2f="";

$hlavicka->f1o2bnyg46nyg46="1234.56";
$hlavicka->f1o2cnyg46nyg46="1234.56";
$hlavicka->f1o2dnyg46nyg46="1234.56";
$hlavicka->f1o2enyg46nyg46="1234.56";
$hlavicka->f1o2fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o2b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o2d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o2e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o2f","$rmc",1,"R");

if( $hlavicka->f1o3b == 0 ) $hlavicka->f1o3b="";
if( $hlavicka->f1o3c == 0 ) $hlavicka->f1o3c="";
if( $hlavicka->f1o3d == 0 ) $hlavicka->f1o3d="";
if( $hlavicka->f1o3e == 0 ) $hlavicka->f1o3e="";
if( $hlavicka->f1o3f == 0 ) $hlavicka->f1o3f="";

$hlavicka->f1o3bnyg46nyg46="1234.56";
$hlavicka->f1o3cnyg46nyg46="1234.56";
$hlavicka->f1o3dnyg46nyg46="1234.56";
$hlavicka->f1o3enyg46nyg46="1234.56";
$hlavicka->f1o3fnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o3b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o3d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o3e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o3f","$rmc",1,"R");

if( $hlavicka->f1o4b == 0 ) $hlavicka->f1o4b="";
if( $hlavicka->f1o4c == 0 ) $hlavicka->f1o4c="";
if( $hlavicka->f1o4d == 0 ) $hlavicka->f1o4d="";
if( $hlavicka->f1o4e == 0 ) $hlavicka->f1o4e="";
if( $hlavicka->f1o4f == 0 ) $hlavicka->f1o4f="";

$hlavicka->f1o4bnyg46nyg46="1234.56";
$hlavicka->f1o4cnyg46nyg46="1234.56";
$hlavicka->f1o4dnyg46nyg46="1234.56";
$hlavicka->f1o4enyg46nyg46="1234.56";
$hlavicka->f1o4fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o4b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o4c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o4d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o4e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o4f","$rmc",1,"R");

if( $hlavicka->f1o5b == 0 ) $hlavicka->f1o5b="";
if( $hlavicka->f1o5c == 0 ) $hlavicka->f1o5c="";
if( $hlavicka->f1o5d == 0 ) $hlavicka->f1o5d="";
if( $hlavicka->f1o5e == 0 ) $hlavicka->f1o5e="";
if( $hlavicka->f1o5f == 0 ) $hlavicka->f1o5f="";

$hlavicka->f1o5bnyg46nyg46="1234.56";
$hlavicka->f1o5cnyg46nyg46="1234.56";
$hlavicka->f1o5dnyg46nyg46="1234.56";
$hlavicka->f1o5enyg46nyg46="1234.56";
$hlavicka->f1o5fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o5b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o5c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o5d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o5e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o5f","$rmc",1,"R");

if( $hlavicka->f1o7b == 0 ) $hlavicka->f1o7b="";
if( $hlavicka->f1o7c == 0 ) $hlavicka->f1o7c="";
if( $hlavicka->f1o7d == 0 ) $hlavicka->f1o7d="";
if( $hlavicka->f1o7e == 0 ) $hlavicka->f1o7e="";
if( $hlavicka->f1o7f == 0 ) $hlavicka->f1o7f="";

$hlavicka->f1o7bnyg46nyg46="1234.56";
$hlavicka->f1o7cnyg46nyg46="1234.56";
$hlavicka->f1o7dnyg46nyg46="1234.56";
$hlavicka->f1o7enyg46nyg46="1234.56";
$hlavicka->f1o7fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o7b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o7c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o7d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o7e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o7f","$rmc",1,"R");

if( $hlavicka->f1o99b == 0 ) $hlavicka->f1o99b="";
if( $hlavicka->f1o99c == 0 ) $hlavicka->f1o99c="";
if( $hlavicka->f1o99d == 0 ) $hlavicka->f1o99d="";
if( $hlavicka->f1o99e == 0 ) $hlavicka->f1o99e="";
if( $hlavicka->f1o99f == 0 ) $hlavicka->f1o99f="";

$hlavicka->f1o99bnyg46nyg46="1234.56";
$hlavicka->f1o99cnyg46nyg46="1234.56";
$hlavicka->f1o99dnyg46nyg46="1234.56";
$hlavicka->f1o99enyg46nyg46="1234.56";
$hlavicka->f1o99fnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->f1o99b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->f1o99c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o99d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->f1o99e","$rmc",0,"R");
$pdf->Cell(31,5,"$hlavicka->f1o99f","$rmc",1,"R");


$pdf->Cell(90,17,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 7 OpravnÈ poloûky k z·sob·m ","$rmc",1,"L");
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabuæka 2","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);

//12.info k casti F pism. o o opravnych polozkach tab2
if( $hlavicka->f2o1 == 0 ) $hlavicka->f2o1="";
if( $hlavicka->f2o2 == 0 ) $hlavicka->f2o2="";

$hlavicka->f2o1nyg46nyg46="1234.56";
$hlavicka->f2o2nyg46nyg46="1234.56";

$pdf->Cell(145,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->f2o1","$rmc",1,"R");
$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(145,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->f2o2","$rmc",1,"R");


$pdf->Cell(90,31,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 7 Z·soby a z·loûnÈ pr·vo","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//13.info k casti F pism. p o zasobach...
if( $hlavicka->fp1 == 0 ) $hlavicka->fp1="";
if( $hlavicka->fp2 == 0 ) $hlavicka->fp2="";

$hlavicka->fp1nyg46nyg46="1234.56";
$hlavicka->fp2nyg46nyg46="1234.56";

$pdf->Cell(145,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->fp1","$rmc",1,"R");
$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(145,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->fp2","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text29"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(66);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text14"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(157);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text15"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(209);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text16"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(269);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 10
    }


//tlac strana 11
if ( $nopg11 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);



if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab15.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab15.jpg',22,30,167,50);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab16_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab16_2.jpg',22,140,167,40);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab17.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab17.jpg',0,210,210,40);
}

$pdf->Cell(90,16,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 9 o v˝voji opravnej poloûky k pohæad·vkam","$rmc",1,"L");
$pdf->Cell(90,8,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//15.info k casti F pism. r o opravnych polozkach k pohladavkam
$pdf->SetFont('arial','',7);
if( $hlavicka->fr1b == 0 ) $hlavicka->fr1b="";
if( $hlavicka->fr1c == 0 ) $hlavicka->fr1c="";
if( $hlavicka->fr1d == 0 ) $hlavicka->fr1d="";
if( $hlavicka->fr1e == 0 ) $hlavicka->fr1e="";
if( $hlavicka->fr1f == 0 ) $hlavicka->fr1f="";

$hlavicka->fr1bnyg46nyg46="1234.56";
$hlavicka->fr1cnyg46nyg46="1234.56";
$hlavicka->fr1dnyg46nyg46="1234.56";
$hlavicka->fr1enyg46nyg46="1234.56";
$hlavicka->fr1fnyg46nyg46="1234.56";

$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(7,5,"$hlavicka->fr1b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->fr1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->fr1d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->fr1e","$rmc",0,"R");
$pdf->Cell(32,5,"$hlavicka->fr1f","$rmc",1,"R");

if( $hlavicka->fr3b == 0 ) $hlavicka->fr3b="";
if( $hlavicka->fr3c == 0 ) $hlavicka->fr3c="";
if( $hlavicka->fr3d == 0 ) $hlavicka->fr3d="";
if( $hlavicka->fr3e == 0 ) $hlavicka->fr3e="";
if( $hlavicka->fr3f == 0 ) $hlavicka->fr3f="";

$hlavicka->fr3bnyg46nyg46="1234.56";
$hlavicka->fr3cnyg46nyg46="1234.56";
$hlavicka->fr3dnyg46nyg46="1234.56";
$hlavicka->fr3enyg46nyg46="1234.56";
$hlavicka->fr3fnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(7,5,"$hlavicka->fr3b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->fr3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->fr3d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->fr3e","$rmc",0,"R");
$pdf->Cell(32,5,"$hlavicka->fr3f","$rmc",1,"R");

if( $hlavicka->fr4b == 0 ) $hlavicka->fr4b="";
if( $hlavicka->fr4c == 0 ) $hlavicka->fr4c="";
if( $hlavicka->fr4d == 0 ) $hlavicka->fr4d="";
if( $hlavicka->fr4e == 0 ) $hlavicka->fr4e="";
if( $hlavicka->fr4f == 0 ) $hlavicka->fr4f="";

$hlavicka->fr4bnyg46nyg46="1234.56";
$hlavicka->fr4cnyg46nyg46="1234.56";
$hlavicka->fr4dnyg46nyg46="1234.56";
$hlavicka->fr4enyg46nyg46="1234.56";
$hlavicka->fr4fnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(7,5,"$hlavicka->fr4b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->fr4c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->fr4d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->fr4e","$rmc",0,"R");
$pdf->Cell(32,5,"$hlavicka->fr4f","$rmc",1,"R");

if( $hlavicka->fr5b == 0 ) $hlavicka->fr5b="";
if( $hlavicka->fr5c == 0 ) $hlavicka->fr5c="";
if( $hlavicka->fr5d == 0 ) $hlavicka->fr5d="";
if( $hlavicka->fr5e == 0 ) $hlavicka->fr5e="";
if( $hlavicka->fr5f == 0 ) $hlavicka->fr5f="";

$hlavicka->fr5bnyg46nyg46="1234.56";
$hlavicka->fr5cnyg46nyg46="1234.56";
$hlavicka->fr5dnyg46nyg46="1234.56";
$hlavicka->fr5enyg46nyg46="1234.56";
$hlavicka->fr5fnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(7,5,"$hlavicka->fr5b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->fr5c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->fr5d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->fr5e","$rmc",0,"R");
$pdf->Cell(32,5,"$hlavicka->fr5f","$rmc",1,"R");


if( $hlavicka->fr99b == 0 ) $hlavicka->fr99b="";
if( $hlavicka->fr99c == 0 ) $hlavicka->fr99c="";
if( $hlavicka->fr99d == 0 ) $hlavicka->fr99d="";
if( $hlavicka->fr99e == 0 ) $hlavicka->fr99e="";
if( $hlavicka->fr99f == 0 ) $hlavicka->fr99f="";

$hlavicka->fr99bnyg46nyg46="1234.56";
$hlavicka->fr99cnyg46nyg46="1234.56";
$hlavicka->fr99dnyg46nyg46="1234.56";
$hlavicka->fr99enyg46nyg46="1234.56";
$hlavicka->fr99fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(7,5,"$hlavicka->fr99b","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->fr99c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->fr99d","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->fr99e","$rmc",0,"R");
$pdf->Cell(32,5,"$hlavicka->fr99f","$rmc",1,"R");

//druha tabulka
$pdf->Cell(90,59,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 10 o pohæad·vkach do lehoty splatnosti a po lehote splatnosti ","$rmc",1,"L");
$pdf->Cell(90,19,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//16.info k casti F pism. s o vekovej... tabulka 2
if( $hlavicka->f2s1b == 0 ) $hlavicka->f2s1b="";
if( $hlavicka->f2s1c == 0 ) $hlavicka->f2s1c="";

$hlavicka->f2s1bnyg46nyg46="1234.56";
$hlavicka->f2s1cnyg46nyg46="1234.56";

$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(58,5,"$hlavicka->f2s1b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f2s1c","$rmc",1,"R");

if( $hlavicka->f2s2b == 0 ) $hlavicka->f2s2b="";
if( $hlavicka->f2s2c == 0 ) $hlavicka->f2s2c="";

$hlavicka->f2s2bnyg46nyg46="1234.56";
$hlavicka->f2s2cnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(58,5,"$hlavicka->f2s2b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f2s2c","$rmc",1,"R");

if( $hlavicka->f2s3b == 0 ) $hlavicka->f2s3b="";
if( $hlavicka->f2s3c == 0 ) $hlavicka->f2s3c="";

$hlavicka->f2s3bnyg46nyg46="1234.56";
$hlavicka->f2s3cnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(58,5,"$hlavicka->f2s3b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f2s3c","$rmc",1,"R");

if( $hlavicka->f2s4b == 0 ) $hlavicka->f2s4b="";
if( $hlavicka->f2s4c == 0 ) $hlavicka->f2s4c="";

$hlavicka->f2s4bnyg46nyg46="1234.56";
$hlavicka->f2s4cnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(58,5,"$hlavicka->f2s4b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f2s4c","$rmc",1,"R");

if( $hlavicka->f2s5b == 0 ) $hlavicka->f2s5b="";
if( $hlavicka->f2s5c == 0 ) $hlavicka->f2s5c="";

$hlavicka->f2s5bnyg46nyg46="1234.56";
$hlavicka->f2s5cnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(58,5,"$hlavicka->f2s5b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f2s5c","$rmc",1,"R");

if( $hlavicka->f2s6b == 0 ) $hlavicka->f2s6b="";
if( $hlavicka->f2s6c == 0 ) $hlavicka->f2s6c="";

$hlavicka->f2s6bnyg46nyg46="1234.56";
$hlavicka->f2s6cnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(58,5,"$hlavicka->f2s6b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f2s6c","$rmc",1,"R");

//tretia tabulka
$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");
$pdf->Cell(0,4,"III. ods. 9 Pohæad·vky zabezpeËenÈ z·loûn˝m pr·vom alebo inou formou zabezpeËenia","$rmc",1,"L");
$pdf->Cell(90,14,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//17.info k casti F pism. t,u o pohl.zabezp.
if( $hlavicka->ftu11 == 0 ) $hlavicka->ftu11="";
if( $hlavicka->ftu12 == 0 ) $hlavicka->ftu12="";

$hlavicka->ftu11nyg46nyg46="1234.56";
$hlavicka->ftu12nyg46nyg46="1234.56";

$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->ftu11","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->ftu12","$rmc",1,"R");

if( $hlavicka->ftu21 == 0 ) $hlavicka->ftu21="";
if( $hlavicka->ftu22 == 0 ) $hlavicka->ftu22="";

$hlavicka->ftu21nyg46nyg46="1234.56";
$hlavicka->ftu22nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5," ","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->ftu22","$rmc",1,"R");


if( $hlavicka->ftu31 == 0 ) $hlavicka->ftu31="";
if( $hlavicka->ftu32 == 0 ) $hlavicka->ftu32="";

$hlavicka->ftu31nyg46nyg46="1234.56";
$hlavicka->ftu32nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5," ","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->ftu32","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text21"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(79);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text23"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(180);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text24"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(248);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 11
    }




//tlac strana 12
if ( $nopg12 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab22.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab22.jpg',0,20,210,90);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab47_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab47_1.jpg',22,160,167,100);
}

//prva tabulka

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 11 V˝znamnÈ poloûky ËasovÈho rozlÌöenia AktÌv","$rmc",1,"L");
$pdf->Cell(90,11,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//22.info k casti F pism. z,b o vyznamnych polozkach.

if( $hlavicka->f1zb12 == 0 ) $hlavicka->f1zb12="";
if( $hlavicka->f1zb13 == 0 ) $hlavicka->f1zb13="";

$hlavicka->f1zb12nyg46nyg46="1234.56";
$hlavicka->f1zb13nyg46nyg46="1234.56";

$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(60,5,"$hlavicka->f1zb12","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->f1zb13","$rmc",1,"R");

if( $hlavicka->f1zb22 == 0 ) $hlavicka->f1zb22="";
if( $hlavicka->f1zb23 == 0 ) $hlavicka->f1zb23="";

$hlavicka->f1zb21nyg46nyg46="1234.56";
$hlavicka->f1zb22nyg46nyg46="1234.56";
$hlavicka->f1zb23nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f1zb21","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f1zb22","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f1zb23","$rmc",1,"R");

if( $hlavicka->f1zb32 == 0 ) $hlavicka->f1zb32="";
if( $hlavicka->f1zb33 == 0 ) $hlavicka->f1zb33="";

$hlavicka->f1zb31nyg46nyg46="1234.56";
$hlavicka->f1zb32nyg46nyg46="1234.56";
$hlavicka->f1zb33nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f1zb31","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f1zb32","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f1zb33","$rmc",1,"R");

if( $hlavicka->f2zb12 == 0 ) $hlavicka->f2zb12="";
if( $hlavicka->f2zb13 == 0 ) $hlavicka->f2zb13="";

$hlavicka->f2zb12nyg46nyg46="1234.56";
$hlavicka->f2zb13nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(60,5,"$hlavicka->f2zb12","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->f2zb13","$rmc",1,"R");

if( $hlavicka->f2zb22 == 0 ) $hlavicka->f2zb22="";
if( $hlavicka->f2zb23 == 0 ) $hlavicka->f2zb23="";

$hlavicka->f2zb21nyg46nyg46="1234.56";
$hlavicka->f2zb22nyg46nyg46="1234.56";
$hlavicka->f2zb23nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f2zb21","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f2zb22","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f2zb23","$rmc",1,"R");

if( $hlavicka->f2zb32 == 0 ) $hlavicka->f2zb32="";
if( $hlavicka->f2zb33 == 0 ) $hlavicka->f2zb33="";

$hlavicka->f2zb31nyg46nyg46="1234.56";
$hlavicka->f2zb32nyg46nyg46="1234.56";
$hlavicka->f2zb33nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f2zb31","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f2zb32","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f2zb33","$rmc",1,"R");

if( $hlavicka->f3zb12 == 0 ) $hlavicka->f3zb12="";
if( $hlavicka->f3zb13 == 0 ) $hlavicka->f3zb13="";

$hlavicka->f3zb12nyg46nyg46="1234.56";
$hlavicka->f3zb13nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(60,5,"$hlavicka->f3zb12","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->f3zb13","$rmc",1,"R");

if( $hlavicka->f3zb22 == 0 ) $hlavicka->f3zb22="";
if( $hlavicka->f3zb23 == 0 ) $hlavicka->f3zb23="";

$hlavicka->f3zb21nyg46nyg46="1234.56";
$hlavicka->f3zb22nyg46nyg46="1234.56";
$hlavicka->f3zb23nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f3zb21","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f3zb22","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f3zb23","$rmc",1,"R");

if( $hlavicka->f3zb32 == 0 ) $hlavicka->f3zb32="";
if( $hlavicka->f3zb33 == 0 ) $hlavicka->f3zb33="";

$hlavicka->f3zb31nyg46nyg46="1234.56";
$hlavicka->f3zb32nyg46nyg46="1234.56";
$hlavicka->f3zb33nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f3zb31","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f3zb32","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f3zb33","$rmc",1,"R");

if( $hlavicka->f4zb12 == 0 ) $hlavicka->f4zb12="";
if( $hlavicka->f4zb13 == 0 ) $hlavicka->f4zb13="";

$hlavicka->f4zb12nyg46nyg46="1234.56";
$hlavicka->f4zb13nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(60,5,"$hlavicka->f4zb12","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->f4zb13","$rmc",1,"R");

if( $hlavicka->f4zb22 == 0 ) $hlavicka->f4zb22="";
if( $hlavicka->f4zb23 == 0 ) $hlavicka->f4zb23="";

$hlavicka->f4zb21nyg46nyg46="1234.56";
$hlavicka->f4zb22nyg46nyg46="1234.56";
$hlavicka->f4zb23nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f4zb21","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f4zb22","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f4zb23","$rmc",1,"R");

if( $hlavicka->f4zb32 == 0 ) $hlavicka->f4zb32="";
if( $hlavicka->f4zb33 == 0 ) $hlavicka->f4zb33="";

$hlavicka->f4zb31nyg46nyg46="1234.56";
$hlavicka->f4zb32nyg46nyg46="1234.56";
$hlavicka->f4zb33nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f4zb31","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f4zb32","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f4zb33","$rmc",1,"R");


//druha tabulka
$sqlttxx = "SELECT * FROM F$kli_vxcf"."_poznamky_no2011s3 WHERE psys >= 0 ".""; 

$sqlxx = mysql_query("$sqlttxx");
  if (@$zaznam=mysql_data_seek($sqlxx,0))
{
$hlavickaxx=mysql_fetch_object($sqlxx);


$pdf->Cell(90,48,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 12 Zmeny vlastn˝ch zdrojov krytia neobeûnÈho majetku a obeûnÈho majetku","$rmc",1,"L");
$pdf->Cell(90,13,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);

//tab47.1 P zmeny vlastneho imania tab1

if( $hlavickaxx->p1b1 == 0 ) $hlavickaxx->p1b1 ="";
if( $hlavickaxx->p1c1 == 0 ) $hlavickaxx->p1c1 ="";
if( $hlavickaxx->p1d1 == 0 ) $hlavickaxx->p1d1 ="";
if( $hlavickaxx->p1e1 == 0 ) $hlavickaxx->p1e1 ="";
if( $hlavickaxx->p1f1 == 0 ) $hlavickaxx->p1f1 ="";

$hlavickaxx->p1b1nyg46="1234.56";
$hlavickaxx->p1c1nyg46="1234.56";
$hlavickaxx->p1d1nyg46="1234.56";
$hlavickaxx->p1e1nyg46="1234.56";
$hlavickaxx->p1f1nyg46="1234.56";

$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b1","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c1","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d1","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e1","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f1","$rmc",1,"R");

if( $hlavickaxx->p1b2 == 0 ) $hlavickaxx->p1b2 ="";
if( $hlavickaxx->p1c2 == 0 ) $hlavickaxx->p1c2 ="";
if( $hlavickaxx->p1d2 == 0 ) $hlavickaxx->p1d2 ="";
if( $hlavickaxx->p1e2 == 0 ) $hlavickaxx->p1e2 ="";
if( $hlavickaxx->p1f2 == 0 ) $hlavickaxx->p1f2 ="";

$hlavickaxx->p1b2nyg46="1234.56";
$hlavickaxx->p1c2nyg46="1234.56";
$hlavickaxx->p1d2nyg46="1234.56";
$hlavickaxx->p1e2nyg46="1234.56";
$hlavickaxx->p1f2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b2","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c2","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d2","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e2","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f2","$rmc",1,"R");

if( $hlavickaxx->p1b3 == 0 ) $hlavickaxx->p1b3 ="";
if( $hlavickaxx->p1c3 == 0 ) $hlavickaxx->p1c3 ="";
if( $hlavickaxx->p1d3 == 0 ) $hlavickaxx->p1d3 ="";
if( $hlavickaxx->p1e3 == 0 ) $hlavickaxx->p1e3 ="";
if( $hlavickaxx->p1f3 == 0 ) $hlavickaxx->p1f3 ="";

$hlavickaxx->p1b3nyg46="1234.56";
$hlavickaxx->p1c3nyg46="1234.56";
$hlavickaxx->p1d3nyg46="1234.56";
$hlavickaxx->p1e3nyg46="1234.56";
$hlavickaxx->p1f3nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b3","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c3","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d3","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e3","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f3","$rmc",1,"R");

if( $hlavickaxx->p1b4 == 0 ) $hlavickaxx->p1b4 ="";
if( $hlavickaxx->p1c4 == 0 ) $hlavickaxx->p1c4 ="";
if( $hlavickaxx->p1d4 == 0 ) $hlavickaxx->p1d4 ="";
if( $hlavickaxx->p1e4 == 0 ) $hlavickaxx->p1e4 ="";
if( $hlavickaxx->p1f4 == 0 ) $hlavickaxx->p1f4 ="";

$hlavickaxx->p1b4nyg46="1234.56";
$hlavickaxx->p1c4nyg46="1234.56";
$hlavickaxx->p1d4nyg46="1234.56";
$hlavickaxx->p1e4nyg46="1234.56";
$hlavickaxx->p1f4nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b4","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c4","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d4","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e4","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f4","$rmc",1,"R");

if( $hlavickaxx->p1b5 == 0 ) $hlavickaxx->p1b5 ="";
if( $hlavickaxx->p1c5 == 0 ) $hlavickaxx->p1c5 ="";
if( $hlavickaxx->p1d5 == 0 ) $hlavickaxx->p1d5 ="";
if( $hlavickaxx->p1e5 == 0 ) $hlavickaxx->p1e5 ="";
if( $hlavickaxx->p1f5 == 0 ) $hlavickaxx->p1f5 ="";

$hlavickaxx->p1b5nyg46="1234.56";
$hlavickaxx->p1c5nyg46="1234.56";
$hlavickaxx->p1d5nyg46="1234.56";
$hlavickaxx->p1e5nyg46="1234.56";
$hlavickaxx->p1f5nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b5","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c5","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d5","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e5","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f5","$rmc",1,"R");

if( $hlavickaxx->p1b6 == 0 ) $hlavickaxx->p1b6 ="";
if( $hlavickaxx->p1c6 == 0 ) $hlavickaxx->p1c6 ="";
if( $hlavickaxx->p1d6 == 0 ) $hlavickaxx->p1d6 ="";
if( $hlavickaxx->p1e6 == 0 ) $hlavickaxx->p1e6 ="";
if( $hlavickaxx->p1f6 == 0 ) $hlavickaxx->p1f6 ="";

$hlavickaxx->p1b6nyg46="1234.56";
$hlavickaxx->p1c6nyg46="1234.56";
$hlavickaxx->p1d6nyg46="1234.56";
$hlavickaxx->p1e6nyg46="1234.56";
$hlavickaxx->p1f6nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b6","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c6","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d6","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e6","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f6","$rmc",1,"R");

if( $hlavickaxx->p1b8 == 0 ) $hlavickaxx->p1b8 ="";
if( $hlavickaxx->p1c8 == 0 ) $hlavickaxx->p1c8 ="";
if( $hlavickaxx->p1d8 == 0 ) $hlavickaxx->p1d8 ="";
if( $hlavickaxx->p1e8 == 0 ) $hlavickaxx->p1e8="";
if( $hlavickaxx->p1f8 == 0 ) $hlavickaxx->p1f8 ="";

$hlavickaxx->p1b8nyg46="1234.56";
$hlavickaxx->p1c8nyg46="1234.56";
$hlavickaxx->p1d8nyg46="1234.56";
$hlavickaxx->p1e8nyg46="1234.56";
$hlavickaxx->p1f8nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b8","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c8","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d8","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e8","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f8","$rmc",1,"R");

if( $hlavickaxx->p1b11 == 0 ) $hlavickaxx->p1b11 ="";
if( $hlavickaxx->p1c11 == 0 ) $hlavickaxx->p1c11 ="";
if( $hlavickaxx->p1d11 == 0 ) $hlavickaxx->p1d11 ="";
if( $hlavickaxx->p1e11 == 0 ) $hlavickaxx->p1e11="";
if( $hlavickaxx->p1f11 == 0 ) $hlavickaxx->p1f11 ="";

$hlavickaxx->p1b11nyg46="1234.56";
$hlavickaxx->p1c11nyg46="1234.56";
$hlavickaxx->p1d11nyg46="1234.56";
$hlavickaxx->p1e11nyg46="1234.56";
$hlavickaxx->p1f11nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b11","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c11","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d11","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e11","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f11","$rmc",1,"R");

if( $hlavickaxx->p1b12 == 0 ) $hlavickaxx->p1b12 ="";
if( $hlavickaxx->p1c12 == 0 ) $hlavickaxx->p1c12 ="";
if( $hlavickaxx->p1d12 == 0 ) $hlavickaxx->p1d12 ="";
if( $hlavickaxx->p1e12 == 0 ) $hlavickaxx->p1e12="";
if( $hlavickaxx->p1f12 == 0 ) $hlavickaxx->p1f12 ="";

$hlavickaxx->p1b12nyg46="1234.56";
$hlavickaxx->p1c12nyg46="1234.56";
$hlavickaxx->p1d12nyg46="1234.56";
$hlavickaxx->p1e12nyg46="1234.56";
$hlavickaxx->p1f12nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b12","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c12","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d12","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e12","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f12","$rmc",1,"R");

if( $hlavickaxx->p1b13 == 0 ) $hlavickaxx->p1b13 ="";
if( $hlavickaxx->p1c13 == 0 ) $hlavickaxx->p1c13 ="";
if( $hlavickaxx->p1d13 == 0 ) $hlavickaxx->p1d13 ="";
if( $hlavickaxx->p1e13 == 0 ) $hlavickaxx->p1e13="";
if( $hlavickaxx->p1f13 == 0 ) $hlavickaxx->p1f13 ="";

$hlavickaxx->p1b13nyg46="1234.56";
$hlavickaxx->p1c13nyg46="1234.56";
$hlavickaxx->p1d13nyg46="1234.56";
$hlavickaxx->p1e13nyg46="1234.56";
$hlavickaxx->p1f13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b13","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c13","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d13","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e13","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f13","$rmc",1,"R");

if( $hlavickaxx->p1b14 == 0 ) $hlavickaxx->p1b14 ="";
if( $hlavickaxx->p1c14 == 0 ) $hlavickaxx->p1c14 ="";
if( $hlavickaxx->p1d14 == 0 ) $hlavickaxx->p1d14 ="";
if( $hlavickaxx->p1e14 == 0 ) $hlavickaxx->p1e14="";
if( $hlavickaxx->p1f14 == 0 ) $hlavickaxx->p1f14 ="";

$hlavickaxx->p1b14nyg46="1234.56";
$hlavickaxx->p1c14nyg46="1234.56";
$hlavickaxx->p1d14nyg46="1234.56";
$hlavickaxx->p1e14nyg46="1234.56";
$hlavickaxx->p1f14nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b14","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c14","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d14","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e14","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f14","$rmc",1,"R");


if( $hlavickaxx->p1b16 == 0 ) $hlavickaxx->p1b16 ="";
if( $hlavickaxx->p1c16 == 0 ) $hlavickaxx->p1c16 ="";
if( $hlavickaxx->p1d16 == 0 ) $hlavickaxx->p1d16 ="";
if( $hlavickaxx->p1e16 == 0 ) $hlavickaxx->p1e16="";
if( $hlavickaxx->p1f16 == 0 ) $hlavickaxx->p1f16 ="";

$hlavickaxx->p1b16nyg46="1234.56";
$hlavickaxx->p1c16nyg46="1234.56";
$hlavickaxx->p1d16nyg46="1234.56";
$hlavickaxx->p1e16nyg46="1234.56";
$hlavickaxx->p1f16nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$hlavickaxx->p1b16","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1c16","$rmc",0,"R");$pdf->Cell(21,5,"$hlavickaxx->p1d16","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavickaxx->p1e16","$rmc",0,"R");$pdf->Cell(33,5,"$hlavickaxx->p1f16","$rmc",1,"R");

$sumb=$hlavickaxx->p1b16+$hlavickaxx->p1b14+$hlavickaxx->p1b13+$hlavickaxx->p1b12+$hlavickaxx->p1b11+$hlavickaxx->p1b1;
$sumc=$hlavickaxx->p1c16+$hlavickaxx->p1c14+$hlavickaxx->p1c13+$hlavickaxx->p1c12+$hlavickaxx->p1c11+$hlavickaxx->p1c1;
$sumd=$hlavickaxx->p1d16+$hlavickaxx->p1d14+$hlavickaxx->p1d13+$hlavickaxx->p1d12+$hlavickaxx->p1d11+$hlavickaxx->p1d1;
$sume=$hlavickaxx->p1e16+$hlavickaxx->p1e14+$hlavickaxx->p1e13+$hlavickaxx->p1e12+$hlavickaxx->p1e11+$hlavickaxx->p1e1;
$sumf=$hlavickaxx->p1f16+$hlavickaxx->p1f14+$hlavickaxx->p1f13+$hlavickaxx->p1f12+$hlavickaxx->p1f11+$hlavickaxx->p1f1;


if( $sumb == 0 ) $sumb ="";
if( $sumc == 0 ) $sumc ="";
if( $sumd == 0 ) $sumd ="";
if( $sume == 0 ) $sume ="";
if( $sumf == 0 ) $sumf ="";

//if( $_SERVER['SERVER_NAME'] == "www.ekorobot.sk" AND $kli_vxcf == 475 ) { $sumb ="38074"; $sumf ="24811"; }


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");$pdf->Cell(10,5,"$sumb","$rmc",0,"R");
$pdf->Cell(23,5,"$sumc","$rmc",0,"R");$pdf->Cell(21,5,"$sumd","$rmc",0,"R");
$pdf->Cell(23,5,"$sume","$rmc",0,"R");$pdf->Cell(33,5,"$sumf","$rmc",1,"R");


}

//textove

$pdf->SetFont('arial','',9);

$ozntext="F_text30"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(110);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="P_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(260);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 12
    }

//tlac strana 13
if ( $nopg13 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab24_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab24_1.jpg',22,20,167,200);
}

//prva tabulka

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 13 o rozdelenÌ ˙ËtovnÈho zisku alebo vysporiadanÌ ˙Ëtovnej straty ","$rmc",1,"L");
$pdf->Cell(90,21,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);

//24.info k casti G pism. a,k 3 bodu prilohy 3
$pdf->SetFont('arial','',9);
if( $hlavicka->g3a11 == 0 ) $hlavicka->g3a11="";
if( $hlavicka->g3a12 == 0 ) $hlavicka->g3a12="";
if( $hlavicka->g3a13 == 0 ) $hlavicka->g3a13="";
if( $hlavicka->g3a13x == 0 ) $hlavicka->g3a13x="";
if( $hlavicka->g3a14 == 0 ) $hlavicka->g3a14="";
if( $hlavicka->g3a14x == 0 ) $hlavicka->g3a14x="";
if( $hlavicka->g3a15 == 0 ) $hlavicka->g3a15="";
if( $hlavicka->g3a16 == 0 ) $hlavicka->g3a16="";
if( $hlavicka->g3a17 == 0 ) $hlavicka->g3a17="";
if( $hlavicka->g3a18 == 0 ) $hlavicka->g3a18="";
if( $hlavicka->g3a19 == 0 ) $hlavicka->g3a19="";


$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a11","$rmc",1,"R");
$pdf->Cell(90,11,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a12","$rmc",1,"R");
$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a13","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a13x","$rmc",1,"R");
$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a14","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a14x","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a15","$rmc",1,"R");
$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a16","$rmc",1,"R");
$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a17","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a18","$rmc",1,"R");
$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a19","$rmc",1,"R");


if( $hlavicka->g3a21 == 0 ) $hlavicka->g3a21="";
if( $hlavicka->g3a22 == 0 ) $hlavicka->g3a22="";
if( $hlavicka->g3a23 == 0 ) $hlavicka->g3a23="";
if( $hlavicka->g3a23x == 0 ) $hlavicka->g3a23x="";
if( $hlavicka->g3a24 == 0 ) $hlavicka->g3a24="";
if( $hlavicka->g3a25 == 0 ) $hlavicka->g3a25="";
if( $hlavicka->g3a26 == 0 ) $hlavicka->g3a26="";
if( $hlavicka->g3a27 == 0 ) $hlavicka->g3a27="";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a21","$rmc",1,"R");
$pdf->Cell(90,12,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a22","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a23","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a23x","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a24","$rmc",1,"R");
$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a25","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a26","$rmc",1,"R");
$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a27","$rmc",1,"R");





//textove

$pdf->SetFont('arial','',9);

$ozntext="G_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(218);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 13
    }

//tlac strana 14
if ( $nopg14 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab25_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab25_1.jpg',0,25,210,120);
}

//prva tabulka

$pdf->Cell(90,12,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 14 o tvorbe a pouûitÌ rezerv","$rmc",1,"L");
$pdf->Cell(90,29,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//25.info k casti G pism. b prilohy c 3

if( $hlavicka->g1b1b1 == 0 ) $hlavicka->g1b1b1="";
if( $hlavicka->g1b1c1 == 0 ) $hlavicka->g1b1c1="";
if( $hlavicka->g1b1d1 == 0 ) $hlavicka->g1b1d1="";
if( $hlavicka->g1b1e1 == 0 ) $hlavicka->g1b1e1="";
if( $hlavicka->g1b1f1 == 0 ) $hlavicka->g1b1f1="";

$hlavicka->g1b1b1nyg46nyg46="1234.56";
$hlavicka->g1b1c1nyg46nyg46="1234.56";
$hlavicka->g1b1d1nyg46nyg46="1234.56";
$hlavicka->g1b1e1nyg46nyg46="1234.56";
$hlavicka->g1b1f1nyg46nyg46="1234.56";

$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b1b1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b1c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b1d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b1e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b1f1","$rmc",1,"R");

if( $hlavicka->g1b2b1 == 0 ) $hlavicka->g1b2b1="";
if( $hlavicka->g1b2c1 == 0 ) $hlavicka->g1b2c1="";
if( $hlavicka->g1b2d1 == 0 ) $hlavicka->g1b2d1="";
if( $hlavicka->g1b2e1 == 0 ) $hlavicka->g1b2e1="";
if( $hlavicka->g1b2f1 == 0 ) $hlavicka->g1b2f1="";

$hlavicka->g1b2a1nyg46nyg46="1234.56";
$hlavicka->g1b2b1nyg46nyg46="1234.56";
$hlavicka->g1b2c1nyg46nyg46="1234.56";
$hlavicka->g1b2d1nyg46nyg46="1234.56";
$hlavicka->g1b2e1nyg46nyg46="1234.56";
$hlavicka->g1b2f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b2a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b2b1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b2c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b2d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b2e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b2f1","$rmc",1,"R");

if( $hlavicka->g1b3b1 == 0 ) $hlavicka->g1b3b1="";
if( $hlavicka->g1b3c1 == 0 ) $hlavicka->g1b3c1="";
if( $hlavicka->g1b3d1 == 0 ) $hlavicka->g1b3d1="";
if( $hlavicka->g1b3e1 == 0 ) $hlavicka->g1b3e1="";
if( $hlavicka->g1b3f1 == 0 ) $hlavicka->g1b3f1="";

$hlavicka->g1b3a1nyg46nyg46="1234.56";
$hlavicka->g1b3b1nyg46nyg46="1234.56";
$hlavicka->g1b3c1nyg46nyg46="1234.56";
$hlavicka->g1b3d1nyg46nyg46="1234.56";
$hlavicka->g1b3e1nyg46nyg46="1234.56";
$hlavicka->g1b3f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b3a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b3b1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b3c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b3d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b3e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b3f1","$rmc",1,"R");

if( $hlavicka->g1b4b1 == 0 ) $hlavicka->g1b4b1="";
if( $hlavicka->g1b4c1 == 0 ) $hlavicka->g1b4c1="";
if( $hlavicka->g1b4d1 == 0 ) $hlavicka->g1b4d1="";
if( $hlavicka->g1b4e1 == 0 ) $hlavicka->g1b4e1="";
if( $hlavicka->g1b4f1 == 0 ) $hlavicka->g1b4f1="";

$hlavicka->g1b4a1nyg46nyg46="1234.56";
$hlavicka->g1b4b1nyg46nyg46="1234.56";
$hlavicka->g1b4c1nyg46nyg46="1234.56";
$hlavicka->g1b4d1nyg46nyg46="1234.56";
$hlavicka->g1b4e1nyg46nyg46="1234.56";
$hlavicka->g1b4f1nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b4a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b4b1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b4c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b4d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b4e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b4f1","$rmc",1,"R");

if( $hlavicka->g1b5b1 == 0 ) $hlavicka->g1b5b1="";
if( $hlavicka->g1b5c1 == 0 ) $hlavicka->g1b5c1="";
if( $hlavicka->g1b5d1 == 0 ) $hlavicka->g1b5d1="";
if( $hlavicka->g1b5e1 == 0 ) $hlavicka->g1b5e1="";
if( $hlavicka->g1b5f1 == 0 ) $hlavicka->g1b5f1="";

$hlavicka->g1b5a1nyg46nyg46="1234.56";
$hlavicka->g1b5b1nyg46nyg46="1234.56";
$hlavicka->g1b5c1nyg46nyg46="1234.56";
$hlavicka->g1b5d1nyg46nyg46="1234.56";
$hlavicka->g1b5e1nyg46nyg46="1234.56";
$hlavicka->g1b5f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b5a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b5b1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b5c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b5d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b5e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b5f1","$rmc",1,"R");

if( $hlavicka->g1b6b1 == 0 ) $hlavicka->g1b6b1="";
if( $hlavicka->g1b6c1 == 0 ) $hlavicka->g1b6c1="";
if( $hlavicka->g1b6d1 == 0 ) $hlavicka->g1b6d1="";
if( $hlavicka->g1b6e1 == 0 ) $hlavicka->g1b6e1="";
if( $hlavicka->g1b6f1 == 0 ) $hlavicka->g1b6f1="";

$hlavicka->g1b6a1nyg46nyg46="1234.56";
$hlavicka->g1b6b1nyg46nyg46="1234.56";
$hlavicka->g1b6c1nyg46nyg46="1234.56";
$hlavicka->g1b6d1nyg46nyg46="1234.56";
$hlavicka->g1b6e1nyg46nyg46="1234.56";
$hlavicka->g1b6f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b6a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b6b1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b6c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b6d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b6e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b6f1","$rmc",1,"R");

if( $hlavicka->g1b1b2 == 0 ) $hlavicka->g1b1b2="";
if( $hlavicka->g1b1c2 == 0 ) $hlavicka->g1b1c2="";
if( $hlavicka->g1b1d2 == 0 ) $hlavicka->g1b1d2="";
if( $hlavicka->g1b1e2 == 0 ) $hlavicka->g1b1e2="";
if( $hlavicka->g1b1f2 == 0 ) $hlavicka->g1b1f2="";

$hlavicka->g1b1b2nyg46nyg46="1234.56";
$hlavicka->g1b1c2nyg46nyg46="1234.56";
$hlavicka->g1b1d2nyg46nyg46="1234.56";
$hlavicka->g1b1e2nyg46nyg46="1234.56";
$hlavicka->g1b1f2nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(1,5," ","$rmc",0,"L");$pdf->Cell(44,5," ","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b1b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b1c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b1d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b1e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b1f2","$rmc",1,"R");

if( $hlavicka->g1b2b2 == 0 ) $hlavicka->g1b2b2="";
if( $hlavicka->g1b2c2 == 0 ) $hlavicka->g1b2c2="";
if( $hlavicka->g1b2d2 == 0 ) $hlavicka->g1b2d2="";
if( $hlavicka->g1b2e2 == 0 ) $hlavicka->g1b2e2="";
if( $hlavicka->g1b2f2 == 0 ) $hlavicka->g1b2f2="";

$hlavicka->g1b2a2nyg46nyg46="1234.56";
$hlavicka->g1b2b2nyg46nyg46="1234.56";
$hlavicka->g1b2c2nyg46nyg46="1234.56";
$hlavicka->g1b2d2nyg46nyg46="1234.56";
$hlavicka->g1b2e2nyg46nyg46="1234.56";
$hlavicka->g1b2f2nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b2a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b2b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b2c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b2d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b2e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b2f2","$rmc",1,"R");

if( $hlavicka->g1b3b2 == 0 ) $hlavicka->g1b3b2="";
if( $hlavicka->g1b3c2 == 0 ) $hlavicka->g1b3c2="";
if( $hlavicka->g1b3d2 == 0 ) $hlavicka->g1b3d2="";
if( $hlavicka->g1b3e2 == 0 ) $hlavicka->g1b3e2="";
if( $hlavicka->g1b3f2 == 0 ) $hlavicka->g1b3f2="";

$hlavicka->g1b3a2nyg46nyg46="1234.56";
$hlavicka->g1b3b2nyg46nyg46="1234.56";
$hlavicka->g1b3c2nyg46nyg46="1234.56";
$hlavicka->g1b3d2nyg46nyg46="1234.56";
$hlavicka->g1b3e2nyg46nyg46="1234.56";
$hlavicka->g1b3f2nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b3a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b3b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b3c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b3d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b3e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b3f2","$rmc",1,"R");

if( $hlavicka->g1b4b2 == 0 ) $hlavicka->g1b4b2="";
if( $hlavicka->g1b4c2 == 0 ) $hlavicka->g1b4c2="";
if( $hlavicka->g1b4d2 == 0 ) $hlavicka->g1b4d2="";
if( $hlavicka->g1b4e2 == 0 ) $hlavicka->g1b4e2="";
if( $hlavicka->g1b4f2 == 0 ) $hlavicka->g1b4f2="";

$hlavicka->g1b4a2nyg46nyg46="1234.56";
$hlavicka->g1b4b2nyg46nyg46="1234.56";
$hlavicka->g1b4c2nyg46nyg46="1234.56";
$hlavicka->g1b4d2nyg46nyg46="1234.56";
$hlavicka->g1b4e2nyg46nyg46="1234.56";
$hlavicka->g1b4f2nyg46nyg46="1234.56";


$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b4a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b4b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b4c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b4d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b4e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b4f2","$rmc",1,"R");

if( $hlavicka->g1b5b2 == 0 ) $hlavicka->g1b5b2="";
if( $hlavicka->g1b5c2 == 0 ) $hlavicka->g1b5c2="";
if( $hlavicka->g1b5d2 == 0 ) $hlavicka->g1b5d2="";
if( $hlavicka->g1b5e2 == 0 ) $hlavicka->g1b5e2="";
if( $hlavicka->g1b5f2 == 0 ) $hlavicka->g1b5f2="";

$hlavicka->g1b5a2nyg46nyg46="1234.56";
$hlavicka->g1b5b2nyg46nyg46="1234.56";
$hlavicka->g1b5c2nyg46nyg46="1234.56";
$hlavicka->g1b5d2nyg46nyg46="1234.56";
$hlavicka->g1b5e2nyg46nyg46="1234.56";
$hlavicka->g1b5f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b5a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b5b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b5c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b5d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b5e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b5f2","$rmc",1,"R");

if( $hlavicka->g1b6b2 == 0 ) $hlavicka->g1b6b2="";
if( $hlavicka->g1b6c2 == 0 ) $hlavicka->g1b6c2="";
if( $hlavicka->g1b6d2 == 0 ) $hlavicka->g1b6d2="";
if( $hlavicka->g1b6e2 == 0 ) $hlavicka->g1b6e2="";
if( $hlavicka->g1b6f2 == 0 ) $hlavicka->g1b6f2="";

$hlavicka->g1b6a2nyg46nyg46="1234.56";
$hlavicka->g1b6b2nyg46nyg46="1234.56";
$hlavicka->g1b6c2nyg46nyg46="1234.56";
$hlavicka->g1b6d2nyg46nyg46="1234.56";
$hlavicka->g1b6e2nyg46nyg46="1234.56";
$hlavicka->g1b6f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b6a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b6b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b6c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b6d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b6e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b6f2","$rmc",1,"R");

if( $hlavicka->g1b7b2 == 0 ) $hlavicka->g1b7b2="";
if( $hlavicka->g1b7c2 == 0 ) $hlavicka->g1b7c2="";
if( $hlavicka->g1b7d2 == 0 ) $hlavicka->g1b7d2="";
if( $hlavicka->g1b7e2 == 0 ) $hlavicka->g1b7e2="";
if( $hlavicka->g1b7f2 == 0 ) $hlavicka->g1b7f2="";

$hlavicka->g1b7a2nyg46nyg46="1234.56";
$hlavicka->g1b7b2nyg46nyg46="1234.56";
$hlavicka->g1b7c2nyg46nyg46="1234.56";
$hlavicka->g1b7d2nyg46nyg46="1234.56";
$hlavicka->g1b7e2nyg46nyg46="1234.56";
$hlavicka->g1b7f2nyg46nyg46="1234.56";


$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b7a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b7b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b7c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b7d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b7e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b7f2","$rmc",1,"R");

if( $hlavicka->g1b8b2 == 0 ) $hlavicka->g1b8b2="";
if( $hlavicka->g1b8c2 == 0 ) $hlavicka->g1b8c2="";
if( $hlavicka->g1b8d2 == 0 ) $hlavicka->g1b8d2="";
if( $hlavicka->g1b8e2 == 0 ) $hlavicka->g1b8e2="";
if( $hlavicka->g1b8f2 == 0 ) $hlavicka->g1b8f2="";

$hlavicka->g1b8a2nyg46nyg46="1234.56";
$hlavicka->g1b8b2nyg46nyg46="1234.56";
$hlavicka->g1b8c2nyg46nyg46="1234.56";
$hlavicka->g1b8d2nyg46nyg46="1234.56";
$hlavicka->g1b8e2nyg46nyg46="1234.56";
$hlavicka->g1b8f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(32,5,"$hlavicka->g1b8a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1b8b2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b8c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b8d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b8e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b8f2","$rmc",1,"R");


//textove

$pdf->SetFont('arial','',9);

$ozntext="G_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(143);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text5"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(153);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 14
    }


}
$i = $i + 1;

  }


$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_no2011s3 WHERE psys >= 0 ".""; 

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


//tlac strana 15
if ( $nopg15 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab26.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab26.jpg',22,25,167,80);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab28.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab28.jpg',22,170,167,50);
}

//prva tabulka

$pdf->Cell(20,11,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 14 pÌsm. c) a d) o z·v‰zkoch","$rmc",1,"L");
$pdf->Cell(90,18,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//26.info k casti G pism. c,d, prilohy c 3

if( $hlavicka->gcd11 == 0 ) $hlavicka->gcd11="";
if( $hlavicka->gcd12 == 0 ) $hlavicka->gcd12="";

$hlavicka->gcd11nyg46nyg46="1234.56";
$hlavicka->gcd12nyg46nyg46="1234.56";

$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd11","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd12","$rmc",1,"R");

if( $hlavicka->gcd21 == 0 ) $hlavicka->gcd21="";
if( $hlavicka->gcd22 == 0 ) $hlavicka->gcd22="";

$hlavicka->gcd21nyg46nyg46="1234.56";
$hlavicka->gcd22nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd21","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd22","$rmc",1,"R");


if( $hlavicka->gcd31 == 0 ) $hlavicka->gcd31="";
if( $hlavicka->gcd32 == 0 ) $hlavicka->gcd32="";

$hlavicka->gcd31nyg46nyg46="1234.56";
$hlavicka->gcd32nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd31","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd32","$rmc",1,"R");

if( $hlavicka->gcd41 == 0 ) $hlavicka->gcd41="";
if( $hlavicka->gcd42 == 0 ) $hlavicka->gcd42="";

$hlavicka->gcd41nyg46nyg46="1234.56";
$hlavicka->gcd42nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd41","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd42","$rmc",1,"R");

if( $hlavicka->gcd51 == 0 ) $hlavicka->gcd51="";
if( $hlavicka->gcd52 == 0 ) $hlavicka->gcd52="";

$hlavicka->gcd51nyg46nyg46="1234.56";
$hlavicka->gcd52nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd51","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd52","$rmc",1,"R");


if( $hlavicka->gcd61 == 0 ) $hlavicka->gcd61="";
if( $hlavicka->gcd62 == 0 ) $hlavicka->gcd62="";

$hlavicka->gcd61nyg46nyg46="1234.56";
$hlavicka->gcd62nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd61","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd62","$rmc",1,"R");


if( $hlavicka->gcd61x == 0 ) $hlavicka->gcd61x="";
if( $hlavicka->gcd62x == 0 ) $hlavicka->gcd62x="";

$hlavicka->gcd61nyg46nyg46="1234.56";
$hlavicka->gcd62nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->gcd61x","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gcd62x","$rmc",1,"R");

//druha tabulka

$pdf->Cell(90,63,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 14 pÌsm. e) o v˝voji soci·lneho fondu","$rmc",1,"L");
$pdf->Cell(90,14,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//28.info k casti G pism. g, prilohy c 3

if( $hlavicka->gg11 == 0 ) $hlavicka->gg11="";
if( $hlavicka->gg12 == 0 ) $hlavicka->gg12="";

$hlavicka->gg11nyg46nyg46="1234.56";
$hlavicka->gg12nyg46nyg46="1234.56";

$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->gg11","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gg12","$rmc",1,"R");

if( $hlavicka->gg21 == 0 ) $hlavicka->gg21="";
if( $hlavicka->gg22 == 0 ) $hlavicka->gg22="";

$hlavicka->gg21nyg46nyg46="1234.56";
$hlavicka->gg22nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->gg21","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gg22","$rmc",1,"R");

if( $hlavicka->gg31 == 0 ) $hlavicka->gg31="";
if( $hlavicka->gg32 == 0 ) $hlavicka->gg32="";

$hlavicka->gg31nyg46nyg46="1234.56";
$hlavicka->gg32nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->gg31","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gg32","$rmc",1,"R");


if( $hlavicka->gg61 == 0 ) $hlavicka->gg61="";
if( $hlavicka->gg62 == 0 ) $hlavicka->gg62="";

$hlavicka->gg61nyg46nyg46="1234.56";
$hlavicka->gg62nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->gg61","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gg62","$rmc",1,"R");

if( $hlavicka->gg71 == 0 ) $hlavicka->gg71="";
if( $hlavicka->gg72 == 0 ) $hlavicka->gg72="";

$hlavicka->gg71nyg46nyg46="1234.56";
$hlavicka->gg72nyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->gg71","$rmc",0,"R");$pdf->Cell(51,5,"$hlavicka->gg72","$rmc",1,"R");



//textove

$pdf->SetFont('arial','',9);

$ozntext="G_text7"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(105);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text9"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(220);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 15
    }


//tlac strana 16
if ( $nopg16 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab30_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab30_1.jpg',0,25,210,80);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab30_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab30_2.jpg',0,103,210,80);
}


//prva tabulka

$pdf->Cell(90,12,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. III. ods. 14 pÌsm. f) o bankov˝ch ˙veroch, o pÙûiËk·ch a n·vratn˝ch finanËn˝ch v˝pomociach","$rmc",1,"L");

$pdf->Cell(90,34,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//30.info k casti G pism. i, prilohy c 3
if( $hlavicka->g1i1c1 == 0 ) $hlavicka->g1i1c1="";
if( $hlavicka->g1i1d1 == 0 ) $hlavicka->g1i1d1="";
if( $hlavicka->g1i1e1 == 0 ) $hlavicka->g1i1e1="";
if( $hlavicka->g1i1f1 == 0 ) $hlavicka->g1i1f1="";

$hlavicka->g1i1a1nyg46nyg46="1234.56";
$hlavicka->g1i1b1nyg46nyg46="1234.56";
$hlavicka->g1i1c1nyg46nyg46="1234.56";
$hlavicka->g1i1d1nyg46nyg46="1234.56";
$hlavicka->g1i1e1nyg46nyg46="1234.56";
$hlavicka->g1i1f1nyg46nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g1i1a1","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g1i1b1","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g1i1c1","$rmc",0,"R");

$g1i1d1sk = SkDatum($hlavicka->g1i1d1);
if( $g1i1d1sk == '00.00.0000' ) $g1i1d1sk="";
$pdf->Cell(17,5,"$g1i1d1sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g1i1e1","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g1i1f1","$rmc",1,"R");

if( $hlavicka->g1i2c1 == 0 ) $hlavicka->g1i2c1="";
if( $hlavicka->g1i2d1 == 0 ) $hlavicka->g1i2d1="";
if( $hlavicka->g1i2e1 == 0 ) $hlavicka->g1i2e1="";
if( $hlavicka->g1i2f1 == 0 ) $hlavicka->g1i2f1="";

$hlavicka->g1i2a1nyg46nyg46="1234.56";
$hlavicka->g1i2b1nyg46nyg46="1234.56";
$hlavicka->g1i2c1nyg46nyg46="1234.56";
$hlavicka->g1i2d1nyg46nyg46="1234.56";
$hlavicka->g1i2e1nyg46nyg46="1234.56";
$hlavicka->g1i2f1nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g1i2a1","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g1i2b1","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g1i2c1","$rmc",0,"R");
$g1i2d1sk = SkDatum($hlavicka->g1i2d1);
if( $g1i2d1sk == '00.00.0000' ) $g1i2d1sk="";
$pdf->Cell(17,5,"$g1i2d1sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g1i2e1","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g1i2f1","$rmc",1,"R");

if( $hlavicka->g1i3c1 == 0 ) $hlavicka->g1i3c1="";
if( $hlavicka->g1i3d1 == 0 ) $hlavicka->g1i3d1="";
if( $hlavicka->g1i3e1 == 0 ) $hlavicka->g1i3e1="";
if( $hlavicka->g1i3f1 == 0 ) $hlavicka->g1i3f1="";

$hlavicka->g1i3a1nyg46nyg46="1234.56";
$hlavicka->g1i3b1nyg46nyg46="1234.56";
$hlavicka->g1i3c1nyg46nyg46="1234.56";
$hlavicka->g1i3d1nyg46nyg46="1234.56";
$hlavicka->g1i3e1nyg46nyg46="1234.56";
$hlavicka->g1i3f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g1i3a1","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g1i3b1","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g1i3c1","$rmc",0,"R");
$g1i3d1sk = SkDatum($hlavicka->g1i3d1);
if( $g1i3d1sk == '00.00.0000' ) $g1i3d1sk="";
$pdf->Cell(17,5,"$g1i3d1sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g1i3e1","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g1i3f1","$rmc",1,"R");

if( $hlavicka->g1i1c2 == 0 ) $hlavicka->g1i1c2="";
if( $hlavicka->g1i1d2 == 0 ) $hlavicka->g1i1d2="";
if( $hlavicka->g1i1e2 == 0 ) $hlavicka->g1i1e2="";
if( $hlavicka->g1i1f2 == 0 ) $hlavicka->g1i1f2="";

$hlavicka->g1i1a2nyg46nyg46="1234.56";
$hlavicka->g1i1b2nyg46nyg46="1234.56";
$hlavicka->g1i1c2nyg46nyg46="1234.56";
$hlavicka->g1i1d2nyg46nyg46="1234.56";
$hlavicka->g1i1e2nyg46nyg46="1234.56";
$hlavicka->g1i1f2nyg46nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g1i1a2","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g1i1b2","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g1i1c2","$rmc",0,"R");
$g1i1d2sk = SkDatum($hlavicka->g1i1d2);
if( $g1i1d2sk == '00.00.0000' ) $g1i1d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g1i1d2sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g1i1e2","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g1i1f2","$rmc",1,"R");

if( $hlavicka->g1i2c2 == 0 ) $hlavicka->g1i2c2="";
if( $hlavicka->g1i2d2 == 0 ) $hlavicka->g1i2d2="";
if( $hlavicka->g1i2e2 == 0 ) $hlavicka->g1i2e2="";
if( $hlavicka->g1i2f2 == 0 ) $hlavicka->g1i2f2="";

$hlavicka->g1i2a2nyg46nyg46="1234.56";
$hlavicka->g1i2b2nyg46nyg46="1234.56";
$hlavicka->g1i2c2nyg46nyg46="1234.56";
$hlavicka->g1i2d2nyg46nyg46="1234.56";
$hlavicka->g1i2e2nyg46nyg46="1234.56";
$hlavicka->g1i2f2nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g1i2a2","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g1i2b2","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g1i2c2","$rmc",0,"R");
$g1i2d2sk = SkDatum($hlavicka->g1i2d2);
if( $g1i2d2sk == '00.00.0000' ) $g1i2d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g1i2d2sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g1i2e2","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g1i2f2","$rmc",1,"R");

if( $hlavicka->g1i3c2 == 0 ) $hlavicka->g1i3c2="";
if( $hlavicka->g1i3d2 == 0 ) $hlavicka->g1i3d2="";
if( $hlavicka->g1i3e2 == 0 ) $hlavicka->g1i3e2="";
if( $hlavicka->g1i3f2 == 0 ) $hlavicka->g1i3f2="";

$hlavicka->g1i3a2nyg46nyg46="1234.56";
$hlavicka->g1i3b2nyg46nyg46="1234.56";
$hlavicka->g1i3c2nyg46nyg46="1234.56";
$hlavicka->g1i3d2nyg46nyg46="1234.56";
$hlavicka->g1i3e2nyg46nyg46="1234.56";
$hlavicka->g1i3f2nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g1i3a2","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g1i3b2","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g1i3c2","$rmc",0,"R");
$g1i3d2sk = SkDatum($hlavicka->g1i3d2);
if( $g1i3d2sk == '00.00.0000' ) $g1i3d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g1i3d2sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g1i3e2","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g1i3f2","$rmc",1,"R");


//druha tabulka

//Tabulka 30 c 2 dlhodobe pozicky

if( $hlavicka->g2i1c1 == 0 ) $hlavicka->g2i1c1="";
if( $hlavicka->g2i1d1 == 0 ) $hlavicka->g2i1d1="";
if( $hlavicka->g2i1e1 == 0 ) $hlavicka->g2i1e1="";
if( $hlavicka->g2i1f1 == 0 ) $hlavicka->g2i1f1="";

$hlavicka->g2i1a1nyg46="1234.56";
$hlavicka->g2i1b1nyg46="1234.56";
$hlavicka->g2i1c1nyg46="1234.56";
$hlavicka->g2i1d1nyg46="1234.56";
$hlavicka->g2i1e1nyg46="1234.56";
$hlavicka->g2i1f1nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i1a1","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i1b1","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i1c1","$rmc",0,"R");
$g2i1d1sk = SkDatum($hlavicka->g2i1d1);
if( $g2i1d1sk == '00.00.0000' ) $g2i1d1sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i1d1sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i1e1","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i1f1","$rmc",1,"R");

if( $hlavicka->g2i2c1 == 0 ) $hlavicka->g2i2c1="";
if( $hlavicka->g2i2d1 == 0 ) $hlavicka->g2i2d1="";
if( $hlavicka->g2i2e1 == 0 ) $hlavicka->g2i2e1="";
if( $hlavicka->g2i2f1 == 0 ) $hlavicka->g2i2f1="";

$hlavicka->g2i2a1nyg46="1234.56";
$hlavicka->g2i2b1nyg46="1234.56";
$hlavicka->g2i2c1nyg46="1234.56";
$hlavicka->g2i2d1nyg46="1234.56";
$hlavicka->g2i2e1nyg46="1234.56";
$hlavicka->g2i2f1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i2a1","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i2b1","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i2c1","$rmc",0,"R");
$g2i2d1sk = SkDatum($hlavicka->g2i2d1);
if( $g2i2d1sk == '00.00.0000' ) $g2i2d1sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i2d1sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i2e1","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i2f1","$rmc",1,"R");

if( $hlavicka->g2i3c1 == 0 ) $hlavicka->g2i3c1="";
if( $hlavicka->g2i3d1 == 0 ) $hlavicka->g2i3d1="";
if( $hlavicka->g2i3e1 == 0 ) $hlavicka->g2i3e1="";
if( $hlavicka->g2i3f1 == 0 ) $hlavicka->g2i3f1="";

$hlavicka->g2i3a1nyg46="1234.56";
$hlavicka->g2i3b1nyg46="1234.56";
$hlavicka->g2i3c1nyg46="1234.56";
$hlavicka->g2i3d1nyg46="1234.56";
$hlavicka->g2i3e1nyg46="1234.56";
$hlavicka->g2i3f1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i3a1","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i3b1","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i3c1","$rmc",0,"R");
$g2i3d1sk = SkDatum($hlavicka->g2i3d1);
if( $g2i3d1sk == '00.00.0000' ) $g2i3d1sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i3d1sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i3e1","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i3f1","$rmc",1,"R");

//Kratkodobe pozicky

if( $hlavicka->g2i1c2 == 0 ) $hlavicka->g2i1c2="";
if( $hlavicka->g2i1d2 == 0 ) $hlavicka->g2i1d2="";
if( $hlavicka->g2i1e2 == 0 ) $hlavicka->g2i1e2="";
if( $hlavicka->g2i1f2 == 0 ) $hlavicka->g2i1f2="";

$hlavicka->g2i1a2nyg46="1234.56";
$hlavicka->g2i1b2nyg46="1234.56";
$hlavicka->g2i1c2nyg46="1234.56";
$hlavicka->g2i1d2nyg46="1234.56";
$hlavicka->g2i1e2nyg46="1234.56";
$hlavicka->g2i1f2nyg46="1234.56";

$pdf->Cell(90,9,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i1a2","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i1b2","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i1c2","$rmc",0,"R");
$g2i1d2sk = SkDatum($hlavicka->g2i1d2);
if( $g2i1d2sk == '00.00.0000' ) $g2i1d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i1d2sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i1e2","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i1f2","$rmc",1,"R");

if( $hlavicka->g2i2c2 == 0 ) $hlavicka->g2i2c2="";
if( $hlavicka->g2i2d2 == 0 ) $hlavicka->g2i2d2="";
if( $hlavicka->g2i2e2 == 0 ) $hlavicka->g2i2e2="";
if( $hlavicka->g2i2f2 == 0 ) $hlavicka->g2i2f2="";

$hlavicka->g2i2a2nyg46="1234.56";
$hlavicka->g2i2b2nyg46="1234.56";
$hlavicka->g2i2c2nyg46="1234.56";
$hlavicka->g2i2d2nyg46="1234.56";
$hlavicka->g2i2e2nyg46="1234.56";
$hlavicka->g2i2f2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i2a2","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i2b2","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i2c2","$rmc",0,"R");
$g2i2d2sk = SkDatum($hlavicka->g2i2d2);
if( $g2i2d2sk == '00.00.0000' ) $g2i2d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i2d2sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i2e2","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i2f2","$rmc",1,"R");

if( $hlavicka->g2i3c2 == 0 ) $hlavicka->g2i3c2="";
if( $hlavicka->g2i3d2 == 0 ) $hlavicka->g2i3d2="";
if( $hlavicka->g2i3e2 == 0 ) $hlavicka->g2i3e2="";
if( $hlavicka->g2i3f2 == 0 ) $hlavicka->g2i3f2="";

$hlavicka->g2i3a2nyg46="1234.56";
$hlavicka->g2i3b2nyg46="1234.56";
$hlavicka->g2i3c2nyg46="1234.56";
$hlavicka->g2i3d2nyg46="1234.56";
$hlavicka->g2i3e2nyg46="1234.56";
$hlavicka->g2i3f2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i3a2","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i3b2","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i3c2","$rmc",0,"R");
$g2i3d2sk = SkDatum($hlavicka->g2i3d2);
if( $g2i3d2sk == '00.00.0000' ) $g2i3d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i3d2sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i3e2","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i3f2","$rmc",1,"R");

//Kratkodobe financne vypomoci

if( $hlavicka->g2i1c3 == 0 ) $hlavicka->g2i1c3="";
if( $hlavicka->g2i1d3 == 0 ) $hlavicka->g2i1d3="";
if( $hlavicka->g2i1e3 == 0 ) $hlavicka->g2i1e3="";
if( $hlavicka->g2i1f3 == 0 ) $hlavicka->g2i1f3="";

$hlavicka->g2i1a3nyg46="1234.56";
$hlavicka->g2i1b3nyg46="1234.56";
$hlavicka->g2i1c3nyg46="1234.56";
$hlavicka->g2i1d3nyg46="1234.56";
$hlavicka->g2i1e3nyg46="1234.56";
$hlavicka->g2i1f3nyg46="1234.56";

$pdf->Cell(90,10,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i1a3","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i1b3","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i1c3","$rmc",0,"R");
$g2i1d3sk = SkDatum($hlavicka->g2i1d3);
if( $g2i1d3sk == '00.00.0000' ) $g2i1d3sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i1d3sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i1e3","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i1f3","$rmc",1,"R");

if( $hlavicka->g2i2c3 == 0 ) $hlavicka->g2i2c3="";
if( $hlavicka->g2i2d3 == 0 ) $hlavicka->g2i2d3="";
if( $hlavicka->g2i2e3 == 0 ) $hlavicka->g2i2e3="";
if( $hlavicka->g2i2f3 == 0 ) $hlavicka->g2i2f3="";

$hlavicka->g2i2a3nyg46="1234.56";
$hlavicka->g2i2b3nyg46="1234.56";
$hlavicka->g2i2c3nyg46="1234.56";
$hlavicka->g2i2d3nyg46="1234.56";
$hlavicka->g2i2e3nyg46="1234.56";
$hlavicka->g2i2f3nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(65,5,"$hlavicka->g2i2a3","$rmc",0,"L");
$pdf->Cell(4,5,"$hlavicka->g2i2b3","$rmc",0,"L");$pdf->Cell(16,5,"$hlavicka->g2i2c3","$rmc",0,"R");
$g2i2d3sk = SkDatum($hlavicka->g2i2d3);
if( $g2i2d3sk == '00.00.0000' ) $g2i2d3sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(17,5,"$g2i2d3sk","$rmc",0,"C");
$pdf->Cell(31,5,"$hlavicka->g2i2e3","$rmc",0,"R");$pdf->Cell(30,5,"$hlavicka->g2i2f3","$rmc",1,"R");





//textove

$pdf->SetFont('arial','',9);

$ozntext="G_text11"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(183);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text12"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(203);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


$ozntext="G_text13"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(223);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 16
    }




//tlac strana 17
if ( $nopg17 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab31.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab31.jpg',22,25,167,70);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab23.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab23.jpg',22,180,167,40);
}

//prva tabulka
//<td colspan="1"><input type="text" name="g1j13" id="g1j13" size="12" /></td>
//<td colspan="1"><input type="text" name="g15pr1" id="g15pr1" size="12" /></td>
//<td colspan="1"><input type="text" name="g15ub1" id="g15ub1" size="12" /></td>
//<td colspan="1"><input type="text" name="g1j12" id="g1j12" size="12" /></td>


$pdf->Cell(90,11,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 15 o v˝znamn˝ch poloûk·ch v˝nosov bud˙cich obdobÌ","$rmc",1,"L");
$pdf->Cell(90,12,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka31 G, Casove rozlisenie

if( $hlavicka->g1j12 == 0 ) $hlavicka->g1j12="";
if( $hlavicka->g1j13 == 0 ) $hlavicka->g1j13="";
if( $hlavicka->g15pr1 == 0 ) $hlavicka->g15pr1="";
if( $hlavicka->g15ub1 == 0 ) $hlavicka->g15ub1="";

$hlavicka->g1j12nyg46="1234.56";
$hlavicka->g1j13nyg46="1234.56";

$pdf->Cell(20,3," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g1j13","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr1","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub1","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g1j12","$rmc",1,"R");

if( $hlavicka->g1j22 == 0 ) $hlavicka->g1j22="";
if( $hlavicka->g1j23 == 0 ) $hlavicka->g1j23="";
if( $hlavicka->g15pr2 == 0 ) $hlavicka->g15pr2="";
if( $hlavicka->g15ub2 == 0 ) $hlavicka->g15ub2="";

$hlavicka->g1j21nyg46="1234.56";
$hlavicka->g1j22nyg46="1234.56";
$hlavicka->g1j23nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g1j23","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr2","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub2","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g1j22","$rmc",1,"R");

if( $hlavicka->g1j32 == 0 ) $hlavicka->g1j32="";
if( $hlavicka->g1j33 == 0 ) $hlavicka->g1j33="";
if( $hlavicka->g15pr3 == 0 ) $hlavicka->g15pr3="";
if( $hlavicka->g15ub3 == 0 ) $hlavicka->g15ub3="";

$hlavicka->g1j31nyg46="1234.56";
$hlavicka->g1j32nyg46="1234.56";
$hlavicka->g1j33nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g1j33","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr3","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub3","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g1j32","$rmc",1,"R");

if( $hlavicka->g2j12 == 0 ) $hlavicka->g2j12="";
if( $hlavicka->g2j13 == 0 ) $hlavicka->g2j13="";
if( $hlavicka->g15pr4 == 0 ) $hlavicka->g15pr4="";
if( $hlavicka->g15ub4 == 0 ) $hlavicka->g15ub4="";

$hlavicka->g2j12nyg46="1234.56";
$hlavicka->g2j13nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g2j13","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr4","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub4","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g2j12","$rmc",1,"R");

if( $hlavicka->g2j21 == 0 ) $hlavicka->g2j21="";
if( $hlavicka->g2j22 == 0 ) $hlavicka->g2j22="";
if( $hlavicka->g2j23 == 0 ) $hlavicka->g2j23="";
if( $hlavicka->g15pr5 == 0 ) $hlavicka->g15pr5="";
if( $hlavicka->g15ub5 == 0 ) $hlavicka->g15ub5="";

$hlavicka->g2j21nyg46="1234.56";
$hlavicka->g2j22nyg46="1234.56";
$hlavicka->g2j23nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g2j23","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr5","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub5","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g2j22","$rmc",1,"R");

if( $hlavicka->g2j32 == 0 ) $hlavicka->g2j32="";
if( $hlavicka->g2j33 == 0 ) $hlavicka->g2j33="";
if( $hlavicka->g15pr6 == 0 ) $hlavicka->g15pr6="";
if( $hlavicka->g15ub6 == 0 ) $hlavicka->g15ub6="";

$hlavicka->g2j31nyg46="1234.56";
$hlavicka->g2j32nyg46="1234.56";
$hlavicka->g2j33nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");;
$pdf->Cell(70,5,"$hlavicka->g2j33","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr6","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub6","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g2j32","$rmc",1,"R");

if( $hlavicka->g3j12 == 0 ) $hlavicka->g3j12="";
if( $hlavicka->g3j13 == 0 ) $hlavicka->g3j13="";
if( $hlavicka->g15pr7 == 0 ) $hlavicka->g15pr7="";
if( $hlavicka->g15ub7 == 0 ) $hlavicka->g15ub7="";

$hlavicka->g3j12nyg46="1234.56";
$hlavicka->g3j13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g3j13","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr7","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub7","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g3j12","$rmc",1,"R");

if( $hlavicka->g3j22 == 0 ) $hlavicka->g3j22="";
if( $hlavicka->g3j23 == 0 ) $hlavicka->g3j23="";
if( $hlavicka->g15pr8 == 0 ) $hlavicka->g15pr8="";
if( $hlavicka->g15ub8 == 0 ) $hlavicka->g15ub8="";

$hlavicka->g3j21nyg46="1234.56";
$hlavicka->g3j22nyg46="1234.56";
$hlavicka->g3j23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(20,5," ","$rmc",0,"L");
$pdf->Cell(70,5,"$hlavicka->g3j23","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g15pr8","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g15ub8","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->g3j22","$rmc",1,"R");





//druha tabulka
$pdf->Cell(90,84,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"III. ods. 16 o majetku prenajatom formou finanËnÈho pren·jmu","$rmc",1,"L");
$pdf->Cell(90,11,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//tabulka Gm
if( $hlavicka->gm99b == 0 ) $hlavicka->gm99b="";
if( $hlavicka->gm99c == 0 ) $hlavicka->gm99c="";
if( $hlavicka->gm99d == 0 ) $hlavicka->gm99d="";
if( $hlavicka->gm99e == 0 ) $hlavicka->gm99e="";


$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(47,5," ","$rmc",0,"L");$pdf->Cell(35,5,"$hlavicka->gm99b","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->gm99c","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->gm99d","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->gm99e","$rmc",1,"R");


if( $hlavicka->gm1b == 0 ) $hlavicka->gm1b="";
if( $hlavicka->gm1c == 0 ) $hlavicka->gm1c="";
if( $hlavicka->gm1d == 0 ) $hlavicka->gm1d="";
if( $hlavicka->gm1e == 0 ) $hlavicka->gm1e="";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(47,5," ","$rmc",0,"L");$pdf->Cell(35,5,"$hlavicka->gm1b","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->gm1c","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->gm1d","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->gm1e","$rmc",1,"R");


if( $hlavicka->gm2b == 0 ) $hlavicka->gm2b="";
if( $hlavicka->gm2c == 0 ) $hlavicka->gm2c="";
if( $hlavicka->gm2d == 0 ) $hlavicka->gm2d="";
if( $hlavicka->gm2e == 0 ) $hlavicka->gm2e="";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(47,5," ","$rmc",0,"L");$pdf->Cell(35,5,"$hlavicka->gm2b","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->gm2c","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->gm2d","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->gm2e","$rmc",1,"R");


if( $hlavicka->gm1f == 0 ) $hlavicka->gm1f="";
if( $hlavicka->gm1g == 0 ) $hlavicka->gm1g="";
if( $hlavicka->gm2f == 0 ) $hlavicka->gm2f="";
if( $hlavicka->gm2g == 0 ) $hlavicka->gm2g="";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(47,5," ","$rmc",0,"L");$pdf->Cell(35,5,"$hlavicka->gm1f","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->gm2f","$rmc",0,"R");$pdf->Cell(32,5,"$hlavicka->gm1g","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->gm2g","$rmc",1,"R");

//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text14"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(96);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text18"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(220);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 17
    }


//tlac strana 18
if ( $nopg18 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab35.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab35.jpg',0,45,210,69);
}

//velky nadpis
$pdf->SetFont('arial','',10);
$pdf->Cell(90,10," ","$rmc",1,"L");
$pdf->Cell(15,6," ","$rmc",0,"L");$pdf->Cell(0,6,"IV. Inform·cie, ktorÈ dopÂÚaj˙ a vysvetæuj˙ ˙daje vo v˝kaze ziskov a str·t","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");



//prva tabulka

$pdf->Cell(90,11,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"IV. ods. 1 o trûb·ch za vlastnÈ v˝kony a tovar Tabuæka 1","$rmc",1,"L");
$pdf->Cell(90,35,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka35 Ha

if( $hlavicka->ha1b == 0 ) $hlavicka->ha1b="";
if( $hlavicka->ha1c == 0 ) $hlavicka->ha1c="";
if( $hlavicka->ha1d == 0 ) $hlavicka->ha1d="";
if( $hlavicka->ha1e == 0 ) $hlavicka->ha1e="";
if( $hlavicka->ha1f == 0 ) $hlavicka->ha1f="";
if( $hlavicka->ha1g == 0 ) $hlavicka->ha1g="";

$hlavicka->ha1anyg46="1234.56";
$hlavicka->ha1bnyg46="1234.56";
$hlavicka->ha1cnyg46="1234.56";
$hlavicka->ha1dnyg46="1234.56";
$hlavicka->ha1enyg46="1234.56";
$hlavicka->ha1fnyg46="1234.56";
$hlavicka->ha1gnyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(23,5,"$hlavicka->ha1a","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->ha1b","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha1c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha1d","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha1e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha1f","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha1g","$rmc",1,"R");

if( $hlavicka->ha2b == 0 ) $hlavicka->ha2b="";
if( $hlavicka->ha2c == 0 ) $hlavicka->ha2c="";
if( $hlavicka->ha2d == 0 ) $hlavicka->ha2d="";
if( $hlavicka->ha2e == 0 ) $hlavicka->ha2e="";
if( $hlavicka->ha2f == 0 ) $hlavicka->ha2f="";
if( $hlavicka->ha2g == 0 ) $hlavicka->ha2g="";

$hlavicka->ha2anyg46="1234.56";
$hlavicka->ha2bnyg46="1234.56";
$hlavicka->ha2cnyg46="1234.56";
$hlavicka->ha2dnyg46="1234.56";
$hlavicka->ha2enyg46="1234.56";
$hlavicka->ha2fnyg46="1234.56";
$hlavicka->ha2gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(23,5,"$hlavicka->ha2a","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->ha2b","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha2c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha2d","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha2e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha2f","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha2g","$rmc",1,"R");

if( $hlavicka->ha3b == 0 ) $hlavicka->ha3b="";
if( $hlavicka->ha3c == 0 ) $hlavicka->ha3c="";
if( $hlavicka->ha3d == 0 ) $hlavicka->ha3d="";
if( $hlavicka->ha3e == 0 ) $hlavicka->ha3e="";
if( $hlavicka->ha3f == 0 ) $hlavicka->ha3f="";
if( $hlavicka->ha3g == 0 ) $hlavicka->ha3g="";

$hlavicka->ha3anyg46="1234.56";
$hlavicka->ha3bnyg46="1234.56";
$hlavicka->ha3cnyg46="1234.56";
$hlavicka->ha3dnyg46="1234.56";
$hlavicka->ha3enyg46="1234.56";
$hlavicka->ha3fnyg46="1234.56";
$hlavicka->ha3gnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(23,5,"$hlavicka->ha3a","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->ha3b","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha3c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha3d","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha3e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha3f","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha3g","$rmc",1,"R");

if( $hlavicka->ha4b == 0 ) $hlavicka->ha4b="";
if( $hlavicka->ha4c == 0 ) $hlavicka->ha4c="";
if( $hlavicka->ha4d == 0 ) $hlavicka->ha4d="";
if( $hlavicka->ha4e == 0 ) $hlavicka->ha4e="";
if( $hlavicka->ha4f == 0 ) $hlavicka->ha4f="";
if( $hlavicka->ha4g == 0 ) $hlavicka->ha4g="";

$hlavicka->ha4anyg46="1234.56";
$hlavicka->ha4bnyg46="1234.56";
$hlavicka->ha4cnyg46="1234.56";
$hlavicka->ha4dnyg46="1234.56";
$hlavicka->ha4enyg46="1234.56";
$hlavicka->ha4fnyg46="1234.56";
$hlavicka->ha4gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(23,5,"$hlavicka->ha4a","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->ha4b","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha4c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha4d","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha4e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->ha4f","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->ha4g","$rmc",1,"R");

if( $hlavicka->ha99b == 0 ) $hlavicka->ha99b="";
if( $hlavicka->ha99c == 0 ) $hlavicka->ha99c="";
if( $hlavicka->ha99d == 0 ) $hlavicka->ha99d="";
if( $hlavicka->ha99e == 0 ) $hlavicka->ha99e="";
if( $hlavicka->ha99f == 0 ) $hlavicka->ha99f="";
if( $hlavicka->ha99g == 0 ) $hlavicka->ha99g="";

$hlavicka->ha99bnyg46="1234.56";
$hlavicka->ha99cnyg46="1234.56";
$hlavicka->ha99dnyg46="1234.56";
$hlavicka->ha99enyg46="1234.56";
$hlavicka->ha99fnyg46="1234.56";
$hlavicka->ha99gnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(36,5," ","$rmc",0,"L");$pdf->Cell(23,5,"$hlavicka->ha99b","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->ha99c","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->ha99d","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->ha99e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->ha99f","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->ha99g","$rmc",1,"R");


//texty do tabulky 35 hl.cinnost a podn.cinnost
$pdf->SetFont('arial','',7);
$pdf->SetY(64);
$pdf->Cell(36,5," ","$rmc",0,"C");$pdf->Cell(24,5,"Hlavn·","$rmc",0,"C");$pdf->Cell(23,5,"Podnikateæsk·","$rmc",0,"C");
$pdf->Cell(24,5,"Hlavn·","$rmc",0,"C");$pdf->Cell(23,5,"Podnikateæsk·","$rmc",0,"C");
$pdf->Cell(24,5,"Hlavn·","$rmc",0,"C");$pdf->Cell(23,5,"Podnikateæsk·","$rmc",1,"C");

$pdf->Cell(36,5," ","$rmc",0,"C");$pdf->Cell(24,5,"Ëinnosù","$rmc",0,"C");$pdf->Cell(23,5,"Ëinnosù","$rmc",0,"C");
$pdf->Cell(24,5,"Ëinnosù","$rmc",0,"C");$pdf->Cell(23,5,"Ëinnosù","$rmc",0,"C");
$pdf->Cell(24,5,"Ëinnosù","$rmc",0,"C");$pdf->Cell(23,5,"Ëinnosù","$rmc",1,"C");

//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="H_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(115);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }



$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 18
    }




//tlac strana 19
if ( $nopg19 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab37.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab37.jpg',0,20,210,125);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab38.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab38.jpg',0,190,210,61);
}

//prva tabulka

$pdf->Cell(90,6,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"IV. ods. 2 a 4 o v˝znamn˝ch poloûk·ch v˝nosov","$rmc",1,"L");

$pdf->Cell(90,12,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka37 Hc vynosy pri akt.nakladov

if( $hlavicka->h1cf12 == 0 ) $hlavicka->h1cf12="";
if( $hlavicka->h1cf13 == 0 ) $hlavicka->h1cf13="";

$hlavicka->h1cf12nyg46="1234.56";
$hlavicka->h1cf13nyg46="1234.56";

$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h1cf12","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h1cf13","$rmc",1,"R");

if( $hlavicka->h1cf22 == 0 ) $hlavicka->h1cf22="";
if( $hlavicka->h1cf23 == 0 ) $hlavicka->h1cf23="";

$hlavicka->h1cf21nyg46="1234.56";
$hlavicka->h1cf22nyg46="1234.56";
$hlavicka->h1cf23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h1cf21","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h1cf22","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h1cf23","$rmc",1,"R");

if( $hlavicka->h1cf32 == 0 ) $hlavicka->h1cf32="";
if( $hlavicka->h1cf33 == 0 ) $hlavicka->h1cf33="";

$hlavicka->h1cf31nyg46="1234.56";
$hlavicka->h1cf32nyg46="1234.56";
$hlavicka->h1cf33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h1cf31","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h1cf32","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h1cf33","$rmc",1,"R");

if( $hlavicka->h2cf12 == 0 ) $hlavicka->h2cf12="";
if( $hlavicka->h2cf13 == 0 ) $hlavicka->h2cf13="";

$hlavicka->h2cf12nyg46="1234.56";
$hlavicka->h2cf13nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h2cf12","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h2cf13","$rmc",1,"R");

if( $hlavicka->h2cf22 == 0 ) $hlavicka->h2cf22="";
if( $hlavicka->h2cf23 == 0 ) $hlavicka->h2cf23="";

$hlavicka->h2cf21nyg46="1234.56";
$hlavicka->h2cf22nyg46="1234.56";
$hlavicka->h2cf23nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h2cf21","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h2cf22","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h2cf23","$rmc",1,"R");

if( $hlavicka->h2cf32 == 0 ) $hlavicka->h2cf32="";
if( $hlavicka->h2cf33 == 0 ) $hlavicka->h2cf33="";

$hlavicka->h2cf31nyg46="1234.56";
$hlavicka->h2cf32nyg46="1234.56";
$hlavicka->h2cf33nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h2cf31","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h2cf32","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h2cf33","$rmc",1,"R");

if( $hlavicka->h2cf42 == 0 ) $hlavicka->h2cf42="";
if( $hlavicka->h2cf43 == 0 ) $hlavicka->h2cf43="";

$hlavicka->h2cf41nyg46="1234.56";
$hlavicka->h2cf42nyg46="1234.56";
$hlavicka->h2cf43nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h2cf41","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h2cf42","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h2cf43","$rmc",1,"R");

if( $hlavicka->h3cf12 == 0 ) $hlavicka->h3cf12="";
if( $hlavicka->h3cf13 == 0 ) $hlavicka->h3cf13="";

$hlavicka->h3cf12nyg46="1234.56";
$hlavicka->h3cf13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h3cf12","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h3cf13","$rmc",1,"R");

if( $hlavicka->h3cf22 == 0 ) $hlavicka->h3cf22="";
if( $hlavicka->h3cf23 == 0 ) $hlavicka->h3cf23="";

$hlavicka->h3cf22nyg46="1234.56";
$hlavicka->h3cf23nyg46="1234.56";

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h3cf22","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h3cf23","$rmc",1,"R");

if( $hlavicka->h3cf32 == 0 ) $hlavicka->h3cf32="";
if( $hlavicka->h3cf33 == 0 ) $hlavicka->h3cf33="";

$hlavicka->h3cf32nyg46="1234.56";
$hlavicka->h3cf33nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h3cf32","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h3cf33","$rmc",1,"R");

if( $hlavicka->h3cf42 == 0 ) $hlavicka->h3cf42="";
if( $hlavicka->h3cf43 == 0 ) $hlavicka->h3cf43="";

$hlavicka->h3cf42nyg46="1234.56";
$hlavicka->h3cf43nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h3cf42","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h3cf43","$rmc",1,"R");

if( $hlavicka->h3cf52 == 0 ) $hlavicka->h3cf52="";
if( $hlavicka->h3cf53 == 0 ) $hlavicka->h3cf53="";

$hlavicka->h3cf51nyg46="1234.56";
$hlavicka->h3cf52nyg46="1234.56";
$hlavicka->h3cf53nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h3cf51","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h3cf52","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h3cf53","$rmc",1,"R");

if( $hlavicka->h3cf62 == 0 ) $hlavicka->h3cf62="";
if( $hlavicka->h3cf63 == 0 ) $hlavicka->h3cf63="";

$hlavicka->h3cf61nyg46="1234.56";
$hlavicka->h3cf62nyg46="1234.56";
$hlavicka->h3cf63nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h3cf61","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h3cf62","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h3cf63","$rmc",1,"R");

if( $hlavicka->h3cf72 == 0 ) $hlavicka->h3cf72="";
if( $hlavicka->h3cf73 == 0 ) $hlavicka->h3cf73="";

$hlavicka->h3cf71nyg46="1234.56";
$hlavicka->h3cf72nyg46="1234.56";
$hlavicka->h3cf73nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h3cf71","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h3cf72","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h3cf73","$rmc",1,"R");

if( $hlavicka->h4cf12 == 0 ) $hlavicka->h4cf12="";
if( $hlavicka->h4cf13 == 0 ) $hlavicka->h4cf13="";

$hlavicka->h4cf12nyg46="1234.56";
$hlavicka->h4cf13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(87,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->h4cf12","$rmc",0,"R");
$pdf->Cell(45,5,"$hlavicka->h4cf13","$rmc",1,"R");

if( $hlavicka->h4cf22 == 0 ) $hlavicka->h4cf22="";
if( $hlavicka->h4cf23 == 0 ) $hlavicka->h4cf23="";

$hlavicka->h4cf21nyg46="1234.56";
$hlavicka->h4cf22nyg46="1234.56";
$hlavicka->h4cf23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h4cf21","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h4cf22","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h4cf23","$rmc",1,"R");

if( $hlavicka->h4cf32 == 0 ) $hlavicka->h4cf32="";
if( $hlavicka->h4cf33 == 0 ) $hlavicka->h4cf33="";

$hlavicka->h4cf31nyg46="1234.56";
$hlavicka->h4cf32nyg46="1234.56";
$hlavicka->h4cf33nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h4cf31","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h4cf32","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h4cf33","$rmc",1,"R");





//druha tabulka

$pdf->Cell(90,46,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"»l. IV. ods. 1 o trûb·ch za vlastnÈ v˝kony a tovar Tabuæka 2","$rmc",1,"L");
$pdf->Cell(90,15,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//tabulka38 Hg o cistom obrate

if( $hlavicka->hg11 == 0 ) $hlavicka->hg11="";
if( $hlavicka->hg12 == 0 ) $hlavicka->hg12="";

$hlavicka->hg11nyg46="1234.56";
$hlavicka->hg12nyg46="1234.56";

$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg11","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg12","$rmc",1,"R");


if( $hlavicka->hg21 == 0 ) $hlavicka->hg21="";
if( $hlavicka->hg22 == 0 ) $hlavicka->hg22="";

$hlavicka->hg21nyg46="1234.56";
$hlavicka->hg22nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg21","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg22","$rmc",1,"R");


if( $hlavicka->hg31 == 0 ) $hlavicka->hg31="";
if( $hlavicka->hg32 == 0 ) $hlavicka->hg32="";

$hlavicka->hg31nyg46="1234.56";
$hlavicka->hg32nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg31","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg32","$rmc",1,"R");

if( $hlavicka->hg41 == 0 ) $hlavicka->hg41="";
if( $hlavicka->hg42 == 0 ) $hlavicka->hg42="";

$hlavicka->hg41nyg46="1234.56";
$hlavicka->hg42nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg41","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg42","$rmc",1,"R");

if( $hlavicka->hg51 == 0 ) $hlavicka->hg51="";
if( $hlavicka->hg52 == 0 ) $hlavicka->hg52="";

$hlavicka->hg51nyg46="1234.56";
$hlavicka->hg52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg51","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg52","$rmc",1,"R");

if( $hlavicka->hg61 == 0 ) $hlavicka->hg61="";
if( $hlavicka->hg62 == 0 ) $hlavicka->hg62="";

$hlavicka->hg61nyg46="1234.56";
$hlavicka->hg62nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg61","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg62","$rmc",1,"R");

if( $hlavicka->hg991 == 0 ) $hlavicka->hg991="";
if( $hlavicka->hg992 == 0 ) $hlavicka->hg992="";

$hlavicka->hg991nyg46="1234.56";
$hlavicka->hg992nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg991","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg992","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="H_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(145);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="H_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(250);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 19
    }


//tlac strana 20
if ( $nopg20 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab39.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab39.jpg',0,20,210,168);
}


//prva tabulka

$pdf->Cell(90,8,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,8," ","$rmc",0,"L");$pdf->Cell(0,4,"IV. ods. 5 a 7 o v˝znamn˝ch poloûk·ch n·kladov","$rmc",1,"L");

$pdf->Cell(90,14,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka 39 info k casti I prilohy

if( $hlavicka->i1ag12 == 0 ) $hlavicka->i1ag12="";
if( $hlavicka->i1ag13 == 0 ) $hlavicka->i1ag13="";

$hlavicka->i1ag12nyg46="1234.56";
$hlavicka->i1ag13nyg46="1234.56";

$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag12","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag13","$rmc",1,"R");

if( $hlavicka->i1ag22 == 0 ) $hlavicka->i1ag22="";
if( $hlavicka->i1ag23 == 0 ) $hlavicka->i1ag23="";

$hlavicka->i1ag22nyg46="1234.56";
$hlavicka->i1ag23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag22","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag23","$rmc",1,"R");

if( $hlavicka->i1ag32 == 0 ) $hlavicka->i1ag32="";
if( $hlavicka->i1ag33 == 0 ) $hlavicka->i1ag33="";

$hlavicka->i1ag32nyg46="1234.56";
$hlavicka->i1ag33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag32","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag33","$rmc",1,"R");

if( $hlavicka->i1ag42 == 0 ) $hlavicka->i1ag42="";
if( $hlavicka->i1ag43 == 0 ) $hlavicka->i1ag43="";

$hlavicka->i1ag42nyg46="1234.56";
$hlavicka->i1ag43nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag42","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag43","$rmc",1,"R");

if( $hlavicka->i1ag52 == 0 ) $hlavicka->i1ag52="";
if( $hlavicka->i1ag53 == 0 ) $hlavicka->i1ag53="";

$hlavicka->i1ag52nyg46="1234.56";
$hlavicka->i1ag53nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag52","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag53","$rmc",1,"R");

if( $hlavicka->i1ag62 == 0 ) $hlavicka->i1ag62="";
if( $hlavicka->i1ag63 == 0 ) $hlavicka->i1ag63="";

$hlavicka->i1ag62nyg46="1234.56";
$hlavicka->i1ag63nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag62","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag63","$rmc",1,"R");

if( $hlavicka->i1ag72 == 0 ) $hlavicka->i1ag72="";
if( $hlavicka->i1ag73 == 0 ) $hlavicka->i1ag73="";

$hlavicka->i1ag72nyg46="1234.56";
$hlavicka->i1ag73nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag72","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag73","$rmc",1,"R");

if( $hlavicka->i1ag82 == 0 ) $hlavicka->i1ag82="";
if( $hlavicka->i1ag83 == 0 ) $hlavicka->i1ag83="";

$hlavicka->i1ag82nyg46="1234.56";
$hlavicka->i1ag83nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag82","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i1ag83","$rmc",1,"R");

if( $hlavicka->i1ag92 == 0 ) $hlavicka->i1ag92="";
if( $hlavicka->i1ag93 == 0 ) $hlavicka->i1ag93="";

$hlavicka->i1ag91nyg46="1234.56";
$hlavicka->i1ag92nyg46="1234.56";
$hlavicka->i1ag93nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i1ag91","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i1ag92","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i1ag93","$rmc",1,"R");

if( $hlavicka->i1ag102 == 0 ) $hlavicka->i1ag102="";
if( $hlavicka->i1ag103 == 0 ) $hlavicka->i1ag103="";

$hlavicka->i1ag101nyg46="1234.56";
$hlavicka->i1ag102nyg46="1234.56";
$hlavicka->i1ag103nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i1ag101","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i1ag102","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i1ag103","$rmc",1,"R");

if( $hlavicka->i1ag112 == 0 ) $hlavicka->i1ag112="";
if( $hlavicka->i1ag113 == 0 ) $hlavicka->i1ag113="";

$hlavicka->i1ag111nyg46="1234.56";
$hlavicka->i1ag112nyg46="1234.56";
$hlavicka->i1ag113nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i1ag111","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i1ag112","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i1ag113","$rmc",1,"R");

if( $hlavicka->i2ag12 == 0 ) $hlavicka->i2ag12="";
if( $hlavicka->i2ag13 == 0 ) $hlavicka->i2ag13="";

$hlavicka->i2ag12nyg46="1234.56";
$hlavicka->i2ag13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i2ag12","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i2ag13","$rmc",1,"R");

//if( $hlavicka->i2ag21 == 0 ) $hlavicka->i2ag21="";
if( $hlavicka->i2ag22 == 0 ) $hlavicka->i2ag22="";
if( $hlavicka->i2ag23 == 0 ) $hlavicka->i2ag23="";

$hlavicka->i2ag21nyg46="1234.56";
$hlavicka->i2ag22nyg46="1234.56";
$hlavicka->i2ag23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i2ag21","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i2ag22","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i2ag23","$rmc",1,"R");

//if( $hlavicka->i2ag31 == 0 ) $hlavicka->i2ag31="";
if( $hlavicka->i2ag32 == 0 ) $hlavicka->i2ag32="";
if( $hlavicka->i2ag33 == 0 ) $hlavicka->i2ag33="";

$hlavicka->i2ag31nyg46="1234.56";
$hlavicka->i2ag32nyg46="1234.56";
$hlavicka->i2ag33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i2ag31","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i2ag32","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i2ag33","$rmc",1,"R");

//if( $hlavicka->i2ag41 == 0 ) $hlavicka->i2ag41="";
if( $hlavicka->i2ag42 == 0 ) $hlavicka->i2ag42="";
if( $hlavicka->i2ag43 == 0 ) $hlavicka->i2ag43="";

$hlavicka->i2ag41nyg46="1234.56";
$hlavicka->i2ag42nyg46="1234.56";
$hlavicka->i2ag43nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i2ag41","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i2ag42","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i2ag43","$rmc",1,"R");

//if( $hlavicka->i2ag51 == 0 ) $hlavicka->i2ag51="";
if( $hlavicka->i2ag52 == 0 ) $hlavicka->i2ag52="";
if( $hlavicka->i2ag53 == 0 ) $hlavicka->i2ag53="";

$hlavicka->i2ag51nyg46="1234.56";
$hlavicka->i2ag52nyg46="1234.56";
$hlavicka->i2ag53nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i2ag51","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i2ag52","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i2ag53","$rmc",1,"R");

if( $hlavicka->i3ag12 == 0 ) $hlavicka->i3ag12="";
if( $hlavicka->i3ag13 == 0 ) $hlavicka->i3ag13="";

$hlavicka->i3ag12nyg46="1234.56";
$hlavicka->i3ag13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i3ag12","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i3ag13","$rmc",1,"R");

if( $hlavicka->i3ag22 == 0 ) $hlavicka->i3ag22="";
if( $hlavicka->i3ag23 == 0 ) $hlavicka->i3ag23="";

$hlavicka->i3ag22nyg46="1234.56";
$hlavicka->i3ag23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i3ag22","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i3ag23","$rmc",1,"R");

if( $hlavicka->i3ag32 == 0 ) $hlavicka->i3ag32="";
if( $hlavicka->i3ag33 == 0 ) $hlavicka->i3ag33="";

$hlavicka->i3ag32nyg46="1234.56";
$hlavicka->i3ag33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i3ag32","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i3ag33","$rmc",1,"R");

if( $hlavicka->i3ag42 == 0 ) $hlavicka->i3ag42="";
if( $hlavicka->i3ag43 == 0 ) $hlavicka->i3ag43="";

$hlavicka->i3ag42nyg46="1234.56";
$hlavicka->i3ag43nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i3ag42","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i3ag43","$rmc",1,"R");

if( $hlavicka->i3ag52 == 0 ) $hlavicka->i3ag52="";
if( $hlavicka->i3ag53 == 0 ) $hlavicka->i3ag53="";

$hlavicka->i3ag51nyg46="1234.56";
$hlavicka->i3ag52nyg46="1234.56";
$hlavicka->i3ag53nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i3ag51","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i3ag52","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i3ag53","$rmc",1,"R");

if( $hlavicka->i3ag62 == 0 ) $hlavicka->i3ag62="";
if( $hlavicka->i3ag63 == 0 ) $hlavicka->i3ag63="";

$hlavicka->i3ag61nyg46="1234.56";
$hlavicka->i3ag62nyg46="1234.56";
$hlavicka->i3ag63nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i3ag61","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i3ag62","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i3ag63","$rmc",1,"R");

if( $hlavicka->i4ag12 == 0 ) $hlavicka->i4ag12="";
if( $hlavicka->i4ag13 == 0 ) $hlavicka->i4ag13="";

$hlavicka->i4ag12nyg46="1234.56";
$hlavicka->i4ag13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i4ag12","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->i4ag13","$rmc",1,"R");

if( $hlavicka->i4ag22 == 0 ) $hlavicka->i4ag22="";
if( $hlavicka->i4ag23 == 0 ) $hlavicka->i4ag23="";

$hlavicka->i4ag21nyg46="1234.56";
$hlavicka->i4ag22nyg46="1234.56";
$hlavicka->i4ag23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i4ag21","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i4ag22","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i4ag23","$rmc",1,"R");

if( $hlavicka->i4ag32 == 0 ) $hlavicka->i4ag32="";
if( $hlavicka->i4ag33 == 0 ) $hlavicka->i4ag33="";

$hlavicka->i4ag31nyg46="1234.56";
$hlavicka->i4ag32nyg46="1234.56";
$hlavicka->i4ag33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(92,5,"$hlavicka->i4ag31","$rmc",0,"L");
$pdf->Cell(36,5,"$hlavicka->i4ag32","$rmc",0,"R");$pdf->Cell(36,5,"$hlavicka->i4ag33","$rmc",1,"R");




//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="I_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(190);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 20
    }


//tlac strana 21
if ( $nopg21 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab39_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab39_1.jpg',22,23,167,40);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab40.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkyno2011/poznamkyno_tab40.jpg',22,190,167,27);
}

//prva tabulka

$pdf->Cell(90,8,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,8," ","$rmc",0,"L");$pdf->Cell(0,4,"IV. ods. 8 o n·kladoch vynaloûen˝ch v s˙vislosti s auditom ˙Ëtovnej z·vierky","$rmc",1,"L");

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);


if( $hlavicka->i1ag32 == 0 ) $hlavicka->i1ag32="";

$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag32","$rmc",1,"R");;

if( $hlavicka->i1ag42 == 0 ) $hlavicka->i1ag42="";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag42","$rmc",1,"R");

if( $hlavicka->i1ag52 == 0 ) $hlavicka->i1ag52="";

$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag52","$rmc",1,"R");

if( $hlavicka->i1ag62 == 0 ) $hlavicka->i1ag62="";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag62","$rmc",1,"R");

if( $hlavicka->i1ag72 == 0 ) $hlavicka->i1ag72="";

$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag72","$rmc",1,"R");

if( $hlavicka->i1ag22 == 0 ) $hlavicka->i1ag22="";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->i1ag22","$rmc",1,"R");

//druha tabulka

$pdf->Cell(90,123,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,4,"IV. ods. 6 o ˙Ëele a v˝öke pouûitia podielu zaplatenej dane ","$rmc",1,"L");

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka40 Ja-e o daniach

if( $hlavicka->jae11 == 0 ) $hlavicka->jae11="";
if( $hlavicka->jae12 == 0 ) $hlavicka->jae12="";

$hlavicka->jae11nyg46="1234.56";
$hlavicka->jae12nyg46="1234.56";

$pdf->Cell(14,5," ","$rmc",0,"L");$pdf->Cell(6,5,"$hlavicka->g4j31","$rmc",0,"L");$pdf->Cell(120,5,"$hlavicka->jae11","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->jae12","$rmc",1,"R");

if( $hlavicka->jae21 == 0 ) $hlavicka->jae21="";
if( $hlavicka->jae22 == 0 ) $hlavicka->jae22="";

$hlavicka->jae21nyg46="1234.56";
$hlavicka->jae22nyg46="1234.56";

$pdf->Cell(14,5," ","$rmc",0,"L");$pdf->Cell(6,5,"$hlavicka->g4j41","$rmc",0,"L");$pdf->Cell(120,5,"$hlavicka->jae21","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->jae22","$rmc",1,"R");

if( $hlavicka->jae31 == 0 ) $hlavicka->jae31="";
if( $hlavicka->jae32 == 0 ) $hlavicka->jae32="";

$hlavicka->jae31nyg46="1234.56";
$hlavicka->jae32nyg46="1234.56";

$pdf->Cell(14,5," ","$rmc",0,"L");$pdf->Cell(6,5,"$hlavicka->g4j51","$rmc",0,"L");$pdf->Cell(120,5,"$hlavicka->jae31","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->jae32","$rmc",1,"R");

if( $hlavicka->jae41 == 0 ) $hlavicka->jae41="";
if( $hlavicka->jae42 == 0 ) $hlavicka->jae42="";

$hlavicka->jae41nyg46="1234.56";
$hlavicka->jae42nyg46="1234.56";

$pdf->Cell(14,5," ","$rmc",0,"L");$pdf->Cell(4,5," ","$rmc",0,"R");$pdf->Cell(122,5,"$hlavicka->jae41","$rmc",0,"R");
$pdf->Cell(38,5,"$hlavicka->jae42","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);



$ozntext="I_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(66);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="J_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(219);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 21
    }

//tlac strana 22
if ( $nopg22 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab42.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab42.jpg',0,40,210,80);
}

if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab43_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab43_1.jpg',0,175,210,62);
}

//velky nadpis
$pdf->SetFont('arial','',10);
$pdf->Cell(90,10," ","$rmc",1,"L");
$pdf->Cell(12,6," ","$rmc",0,"L");$pdf->Cell(0,6,"V. Opis ˙dajov na pods˙vahov˝ch ˙Ëtoch ","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,7,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"V. V˝znamnÈ poloûky na pods˙vahov˝ch ˙Ëtoch","$rmc",1,"L");

$pdf->Cell(90,13,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka42 K udaje na podsuvahovych uctoch


if( $hlavicka->k11 == 0 ) $hlavicka->k11="";
if( $hlavicka->k12 == 0 ) $hlavicka->k12="";

$hlavicka->k11nyg46="1234.56";
$hlavicka->k12nyg46="1234.56";

$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k12","$rmc",1,"R");

if( $hlavicka->k21 == 0 ) $hlavicka->k21="";
if( $hlavicka->k22 == 0 ) $hlavicka->k22="";

$hlavicka->k21nyg46="1234.56";
$hlavicka->k22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k22","$rmc",1,"R");


if( $hlavicka->k31 == 0 ) $hlavicka->k31="";
if( $hlavicka->k32 == 0 ) $hlavicka->k32="";

$hlavicka->k31nyg46="1234.56";
$hlavicka->k32nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k32","$rmc",1,"R");

if( $hlavicka->k41 == 0 ) $hlavicka->k41="";
if( $hlavicka->k42 == 0 ) $hlavicka->k42="";

$hlavicka->k41nyg46="1234.56";
$hlavicka->k42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k42","$rmc",1,"R");

if( $hlavicka->k51 == 0 ) $hlavicka->k51="";
if( $hlavicka->k52 == 0 ) $hlavicka->k52="";

$hlavicka->k51nyg46="1234.56";
$hlavicka->k52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k52","$rmc",1,"R");

if( $hlavicka->k61 == 0 ) $hlavicka->k61="";
if( $hlavicka->k62 == 0 ) $hlavicka->k62="";

$hlavicka->k61nyg46="1234.56";
$hlavicka->k62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k62","$rmc",1,"R");

if( $hlavicka->k71 == 0 ) $hlavicka->k71="";
if( $hlavicka->k72 == 0 ) $hlavicka->k72="";

$hlavicka->k71nyg46="1234.56";
$hlavicka->k72nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k71","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k72","$rmc",1,"R");

if( $hlavicka->k81 == 0 ) $hlavicka->k81="";
if( $hlavicka->k82 == 0 ) $hlavicka->k82="";

$hlavicka->k81nyg46="1234.56";
$hlavicka->k82nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k81","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k82","$rmc",1,"R");

if( $hlavicka->k91 == 0 ) $hlavicka->k91="";
if( $hlavicka->k92 == 0 ) $hlavicka->k92="";

$hlavicka->k91nyg46="1234.56";
$hlavicka->k92nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(75,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k91","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k92","$rmc",1,"R");





//velky nadpis
$pdf->SetFont('arial','',10);
$pdf->Cell(90,40," ","$rmc",1,"L");
$pdf->Cell(12,6," ","$rmc",0,"L");$pdf->Cell(0,6,"VI. œalöie inform·cie","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");

//druha tabulka

$pdf->Cell(90,5,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"VI. ods. 2 opis a hodnota in˝ch pasÌv","$rmc",1,"L");
$pdf->Cell(90,18,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka43 La podmienene zavazky tab 1

if( $hlavicka->l1ab11 == 0 ) $hlavicka->l1ab11="";
if( $hlavicka->l1ab12 == 0 ) $hlavicka->l1ab12="";

$hlavicka->l1ab11nyg46="1234.56";
$hlavicka->l1ab12nyg46="1234.56";

$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab12","$rmc",1,"R");

if( $hlavicka->l1ab21 == 0 ) $hlavicka->l1ab21="";
if( $hlavicka->l1ab22 == 0 ) $hlavicka->l1ab22="";

$hlavicka->l1ab21nyg46="1234.56";
$hlavicka->l1ab22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab22","$rmc",1,"R");

if( $hlavicka->l1ab31 == 0 ) $hlavicka->l1ab31="";
if( $hlavicka->l1ab32 == 0 ) $hlavicka->l1ab32="";

$hlavicka->l1ab31nyg46="1234.56";
$hlavicka->l1ab32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab32","$rmc",1,"R");

if( $hlavicka->l1ab41 == 0 ) $hlavicka->l1ab41="";
if( $hlavicka->l1ab42 == 0 ) $hlavicka->l1ab42="";

$hlavicka->l1ab41nyg46="1234.56";
$hlavicka->l1ab42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab42","$rmc",1,"R");

if( $hlavicka->l1ab51 == 0 ) $hlavicka->l1ab51="";
if( $hlavicka->l1ab52 == 0 ) $hlavicka->l1ab52="";

$hlavicka->l1ab51nyg46="1234.56";
$hlavicka->l1ab52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab52","$rmc",1,"R");

if( $hlavicka->l1ab61 == 0 ) $hlavicka->l1ab61="";
if( $hlavicka->l1ab62 == 0 ) $hlavicka->l1ab62="";

$hlavicka->l1ab61nyg46="1234.56";
$hlavicka->l1ab62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l1ab61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l1ab62","$rmc",1,"R");






//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="K_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(118);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="L_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(235);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="L_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(280);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }



$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 22
    }

//tlac strana 23
if ( $nopg23 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


if (File_Exists ('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab44.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2012/poznamkypo2011tabtext/poznamkypo_tab44.jpg',0,25,210,74);
}




//prva tabulka

$pdf->Cell(90,13,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"V. Inform·cie o podmienenom majetku","$rmc",1,"L");
$pdf->Cell(90,11,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Lc podmieneny majetok

if( $hlavicka->lc11 == 0 ) $hlavicka->lc11="";
if( $hlavicka->lc12 == 0 ) $hlavicka->lc12="";

$hlavicka->lc11nyg46="1234.56";
$hlavicka->lc12nyg46="1234.56";

$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc11","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc12","$rmc",1,"R");

if( $hlavicka->lc21 == 0 ) $hlavicka->lc21="";
if( $hlavicka->lc22 == 0 ) $hlavicka->lc22="";

$hlavicka->lc21nyg46="1234.56";
$hlavicka->lc22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc21","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc22","$rmc",1,"R");

if( $hlavicka->lc31 == 0 ) $hlavicka->lc31="";
if( $hlavicka->lc32 == 0 ) $hlavicka->lc32="";

$hlavicka->lc31nyg46="1234.56";
$hlavicka->lc32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc31","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc32","$rmc",1,"R");

if( $hlavicka->lc41 == 0 ) $hlavicka->lc41="";
if( $hlavicka->lc42 == 0 ) $hlavicka->lc42="";

$hlavicka->lc41nyg46="1234.56";
$hlavicka->lc42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc41","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc42","$rmc",1,"R");

if( $hlavicka->lc51 == 0 ) $hlavicka->lc51="";
if( $hlavicka->lc52 == 0 ) $hlavicka->lc52="";

$hlavicka->lc51nyg46="1234.56";
$hlavicka->lc52nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc51","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc52","$rmc",1,"R");

if( $hlavicka->lc61 == 0 ) $hlavicka->lc61="";
if( $hlavicka->lc62 == 0 ) $hlavicka->lc62="";

$hlavicka->lc61nyg46="1234.56";
$hlavicka->lc62nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc61","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc62","$rmc",1,"R");

if( $hlavicka->lc71 == 0 ) $hlavicka->lc71="";
if( $hlavicka->lc72 == 0 ) $hlavicka->lc72="";

$hlavicka->lc71nyg46="1234.56";
$hlavicka->lc72nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc71","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc72","$rmc",1,"R");

if( $hlavicka->lc81 == 0 ) $hlavicka->lc81="";
if( $hlavicka->lc82 == 0 ) $hlavicka->lc82="";

$hlavicka->lc81nyg46="1234.56";
$hlavicka->lc82nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(80,5," ","$rmc",0,"L");$pdf->Cell(48,5,"$hlavicka->lc81","$rmc",0,"R");
$pdf->Cell(48,5,"$hlavicka->lc82","$rmc",1,"R");






//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="L_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(100);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 23
    }



//tlac strana 24
if ( $nopg24 == 0 AND $strana == 9999 )
    {
$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(10); 
$pdf->SetTopMargin(10);


//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(90,10," ","$rmc",1,"L");
$pdf->Cell(12,6," ","$rmc",0,"L");$pdf->Cell(0,6,"VI. ods. 5 Inform·cie o v˝znamn˝ch skutoËnostiach, ktorÈ nastali medzi dÚom, ku ktorÈmu","$rmc",1,"L");
$pdf->Cell(12,6," ","$rmc",0,"L");$pdf->Cell(0,6,"sa zostavuje ⁄Z a dÚom jej zostavenia ","$rmc",1,"L");

$pdf->Cell(90,5," ","$rmc",1,"L");




//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="O_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(43);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }


$stranax=$stranax+1;
$pdf->SetY(10);$pdf->SetFont('arial','',8);$pdf->Cell(0,7,"- $stranax -","$rmc",1,"C");
//koniec tlac strana 24
    }




}
$i = $i + 1;

  }




$pdf->Output("$outfilex");



?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
          }
//koniec zostava PDF copern=11
?>



<?php

// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
