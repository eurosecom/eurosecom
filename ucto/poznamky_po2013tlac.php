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
alert ("Poznámky budú pripravené v priebehu januára 2014. Aktuálne info nájdete na vstupnej stránke v bode Novinky, tipy, triky.");
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

//new2013
$sqlfirn = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011s4 WHERE ico >= 0";
$fir_vysledokn = mysql_query($sqlfirn);
$fir_riadokn=mysql_fetch_object($fir_vysledokn);

$f1a18pb = $fir_riadokn->f1a18pb;
$f1a18pc = $fir_riadokn->f1a18pc;
$f1a18pd = $fir_riadokn->f1a18pd;
$f1a18pe = $fir_riadokn->f1a18pe;
$f1a18pf = $fir_riadokn->f1a18pf;
$f1a18pg = $fir_riadokn->f1a18pg;
$f1a18ph = $fir_riadokn->f1a18ph;
$f1a18pi = $fir_riadokn->f1a18pi;

$f1a112pb = $fir_riadokn->f1a112pb;
$f1a112pc = $fir_riadokn->f1a112pc;
$f1a112pd = $fir_riadokn->f1a112pd;
$f1a112pe = $fir_riadokn->f1a112pe;
$f1a112pf = $fir_riadokn->f1a112pf;
$f1a112pg = $fir_riadokn->f1a112pg;
$f1a112ph = $fir_riadokn->f1a112ph;
$f1a112pi = $fir_riadokn->f1a112pi;

$f1a28pb = $fir_riadokn->f1a28pb;
$f1a28pc = $fir_riadokn->f1a28pc;
$f1a28pd = $fir_riadokn->f1a28pd;
$f1a28pe = $fir_riadokn->f1a28pe;
$f1a28pf = $fir_riadokn->f1a28pf;
$f1a28pg = $fir_riadokn->f1a28pg;
$f1a28ph = $fir_riadokn->f1a28ph;
$f1a28pi = $fir_riadokn->f1a28pi;

$f1a212pb = $fir_riadokn->f1a212pb;
$f1a212pc = $fir_riadokn->f1a212pc;
$f1a212pd = $fir_riadokn->f1a212pd;
$f1a212pe = $fir_riadokn->f1a212pe;
$f1a212pf = $fir_riadokn->f1a212pf;
$f1a212pg = $fir_riadokn->f1a212pg;
$f1a212ph = $fir_riadokn->f1a212ph;
$f1a212pi = $fir_riadokn->f1a212pi;

$f2a18pb = $fir_riadokn->f2a18pb;
$f2a18pc = $fir_riadokn->f2a18pc;
$f2a18pd = $fir_riadokn->f2a18pd;
$f2a18pe = $fir_riadokn->f2a18pe;
$f2a18pf = $fir_riadokn->f2a18pf;
$f2a18pg = $fir_riadokn->f2a18pg;
$f2a18ph = $fir_riadokn->f2a18ph;
$f2a18pi = $fir_riadokn->f2a18pi;
$f2a18pj = $fir_riadokn->f2a18pj;

$f2a112pb = $fir_riadokn->f2a112pb;
$f2a112pc = $fir_riadokn->f2a112pc;
$f2a112pd = $fir_riadokn->f2a112pd;
$f2a112pe = $fir_riadokn->f2a112pe;
$f2a112pf = $fir_riadokn->f2a112pf;
$f2a112pg = $fir_riadokn->f2a112pg;
$f2a112ph = $fir_riadokn->f2a112ph;
$f2a112pi = $fir_riadokn->f2a112pi;
$f2a112pj = $fir_riadokn->f2a112pj;

$f2a28pb = $fir_riadokn->f2a28pb;
$f2a28pc = $fir_riadokn->f2a28pc;
$f2a28pd = $fir_riadokn->f2a28pd;
$f2a28pe = $fir_riadokn->f2a28pe;
$f2a28pf = $fir_riadokn->f2a28pf;
$f2a28pg = $fir_riadokn->f2a28pg;
$f2a28ph = $fir_riadokn->f2a28ph;
$f2a28pi = $fir_riadokn->f2a28pi;
$f2a28pj = $fir_riadokn->f2a28pj;

$f2a212pb = $fir_riadokn->f2a212pb;
$f2a212pc = $fir_riadokn->f2a212pc;
$f2a212pd = $fir_riadokn->f2a212pd;
$f2a212pe = $fir_riadokn->f2a212pe;
$f2a212pf = $fir_riadokn->f2a212pf;
$f2a212pg = $fir_riadokn->f2a212pg;
$f2a212ph = $fir_riadokn->f2a212ph;
$f2a212pi = $fir_riadokn->f2a212pi;
$f2a212pj = $fir_riadokn->f2a212pj;

//finm
$f1j8pb = $fir_riadokn->f1j8pb;
$f1j8pc = $fir_riadokn->f1j8pc;
$f1j8pd = $fir_riadokn->f1j8pd;
$f1j8pe = $fir_riadokn->f1j8pe;
$f1j8pf = $fir_riadokn->f1j8pf;
$f1j8pg = $fir_riadokn->f1j8pg;
$f1j8ph = $fir_riadokn->f1j8ph;
$f1j8pi = $fir_riadokn->f1j8pi;
$f1j8pj = $fir_riadokn->f1j8pj;

$f2j8pb = $fir_riadokn->f2j8pb;
$f2j8pc = $fir_riadokn->f2j8pc;
$f2j8pd = $fir_riadokn->f2j8pd;
$f2j8pe = $fir_riadokn->f2j8pe;
$f2j8pf = $fir_riadokn->f2j8pf;
$f2j8pg = $fir_riadokn->f2j8pg;
$f2j8ph = $fir_riadokn->f2j8ph;
$f2j8pi = $fir_riadokn->f2j8pi;
$f2j8pj = $fir_riadokn->f2j8pj;

//dan.prij
$jfg4n1b = $fir_riadokn->jfg4n1b;
$jfg4n1c = $fir_riadokn->jfg4n1c;
$jfg4n1d = $fir_riadokn->jfg4n1d;
$jfg4n1e = $fir_riadokn->jfg4n1e;
$jfg4n1f = $fir_riadokn->jfg4n1f;
$jfg4n1g = $fir_riadokn->jfg4n1g;

$jfg5n1b = $fir_riadokn->jfg5n1b;
$jfg5n1c = $fir_riadokn->jfg5n1c;
$jfg5n1d = $fir_riadokn->jfg5n1d;
$jfg5n1e = $fir_riadokn->jfg5n1e;
$jfg5n1f = $fir_riadokn->jfg5n1f;
$jfg5n1g = $fir_riadokn->jfg5n1g;

$jfg5n2b = $fir_riadokn->jfg5n2b;
$jfg5n2c = $fir_riadokn->jfg5n2c;
$jfg5n2d = $fir_riadokn->jfg5n2d;
$jfg5n2e = $fir_riadokn->jfg5n2e;
$jfg5n2f = $fir_riadokn->jfg5n2f;
$jfg5n2g = $fir_riadokn->jfg5n2g;

//kratkod.f.
$f2w1dp = $fir_riadokn->f2w1dp;
$f2w2dp = $fir_riadokn->f2w2dp;
$f2w3dp = $fir_riadokn->f2w3dp;
$f2w4dp = $fir_riadokn->f2w4dp;
$f2w5dp = $fir_riadokn->f2w5dp;
$f2w6dp = $fir_riadokn->f2w6dp;
$f2w99dp = $fir_riadokn->f2w99dp;

//bankove uvery, pozicky istina tab.1
$g1i1e1eur = $fir_riadokn->g1i1e1eur;
$g1i2e1eur = $fir_riadokn->g1i2e1eur;
$g1i3e1eur = $fir_riadokn->g1i3e1eur;
$g1i1e2eur = $fir_riadokn->g1i1e2eur;
$g1i2e2eur = $fir_riadokn->g1i2e2eur;
$g1i3e2eur = $fir_riadokn->g1i3e2eur;

$g2i1e1eur = $fir_riadokn->g2i1e1eur;
$g2i2e1eur = $fir_riadokn->g2i2e1eur;
$g2i3e1eur = $fir_riadokn->g2i3e1eur;
$g2i1e2eur = $fir_riadokn->g2i1e2eur;
$g2i2e2eur = $fir_riadokn->g2i2e2eur;
$g2i3e2eur = $fir_riadokn->g2i3e2eur;
$g2i1e3eur = $fir_riadokn->g2i1e3eur;
$g2i2e3eur = $fir_riadokn->g2i2e3eur;

//odloz dan.paz
$gf141 = $fir_riadokn->gf141;
$gf142 = $fir_riadokn->gf142;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Poznámky PO</title>

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

window.open('../ucto/poznamky_po2013nacitaj.php?h_mfir=' + h_mfir + '&copern=200&drupoh=1&page=1&typ=PDF&cstat=10101&vyb_ume=<?php echo $vyb_umk; ?>&dopoz=' + dopoz + '&xxc=1', '_self' );
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

window.open('../ucto/poznamky_po2013nacitaj.php?h_ucm1=' + ucm1 + '&h_ucm2=' + ucm2 + '&h_ucm3=' + ucm3 + '&h_ucm4=' + ucm4 + '&h_ucm5=' + ucm5 + '&h_ico1=' + ico1 + '&h_ico2=' + ico2 + '&h_ico3=' + ico3 + '&h_ico4=' + ico4 + '&h_ico5=' + ico5 + '&zmd=' + zmd + '&zdl=' + zdl + '&omd=' + omd + '&odl=' + odl + '&pmd=' + pmd + '&pdl=' + pdl + '&mnl=' + mnl + '&premenna=' + premenna + '&copern=900&drupoh=1&page=1&strana=<?php echo $strana; ?>', '_self' );
                }

function UrobSubor()
                {
window.open('../ucto/poznamky_po2013nacitaj.php?&copern=901&drupoh=1&page=1&strana=<?php echo $strana; ?>&dopoz=1', '_self' );
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
"Chcete naèíta údaje o Dlhodobom Nehmotnom majetku (tab.3) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 300 );\">" +
"Chcete naèíta údaje o Dlhodobom Hmotnom majetku (tab.5) z obratovky ?</a>";
    htmlmenu += "</td></tr>";                    

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 302 );\">" +
"Chcete naèíta údaje o dlhodobom Finanènom majetku (tab.7) z obratovky ?</a>";
    htmlmenu += "</td></tr>";                      

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 401 );\">" +
"Chcete naèíta údaje o vekovej štruktúre poh¾adávok (tab.16) zo saldokonta ?</a>";
    htmlmenu += "</td></tr>";  

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 501 );\">" +
"Chcete naèíta údaje o krátkodobom Finanènom majetku (tab.18) z obratovky ?</a>";
    htmlmenu += "</td></tr>";   

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 502 );\">" +
"Chcete naèíta údaje o Èasovom rozlíšení na strane aktív (tab.22) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 503 );\">" +
"Chcete naèíta údaje o Rozdelení úètovného zisku, straty (tab.24) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 504 );\">" +
"Chcete naèíta údaje o Rezervách (tab.25) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 402 );\">" +
"Chcete naèíta údaje o záväzkoch (tab.26) zo saldokonta ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 505 );\">" +
"Chcete naèíta údaje o Sociálnom fonde a úveroch (tab.28) z obratovky ?</a>";
    htmlmenu += "</td></tr>"; 

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 506 );\">" +
"Chcete naèíta údaje o Èasovom rozlíšení na strane pasív (tab.31) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 507 );\">" +
"Chcete naèíta údaje o Trbách, vınosoch a obrate (tab.35-38) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 508 );\">" +
"Chcete naèíta údaje o Nákladoch (tab.39) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 511 );\">" +
"Chcete naèíta údaje o Stave vnútroorganizaènıch zásob (tab.36) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 509 );\">" +
"Chcete naèíta údaje o Daniach (tab.40-41) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 510 );\">" +
"Chcete naèíta údaje o Zmenách vlastného imania (tab.47) z obratovky ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"NacitajHodnotu( 999 );\">" +
"Chcete naèíta údaje o bezprostredne predchádzajúcom období z poznámok z firmy minulého roka ?</a>";
    htmlmenu += "</td></tr>";
                    
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>";
htmlmenu += "<a href=\"#\" onClick=\"NacitajMzdy();\">" +
"Chcete naèíta údaje z miezd (tab.1) firma èíslo</a> ";
    htmlmenu += "<input type='text' name='h_mfir' id='h_mfir' size='2' maxlenght='4' value='<?php echo $kli_vxcf; ?>' >"; 
    htmlmenu += " ?</td></tr>";

    htmlmenu += "<tr><td class='ponuka' colspan='1'>"; 
    htmlmenu += " <img border=0 src='../obr/zoznam.png' style='width:15; height:15;' onClick='UrobSubor();' alt='Vytvorenie súboru, z ktorého naèítate hodnoty (staèí jeden krát kliknú)' > Súbor"; 
    htmlmenu += "<td class='ponuka' colspan='1'>Po naèítaní naspä <input type='checkbox' name='dopoz' value='1' >"; 
    htmlmenu += " </td></tr>";

    htmlmenu += "</table></FORM>"; 

  function NacitajHodnotu( riadok )
  {
   var dopoz = 0;
   if ( document.emzdy.dopoz.checked ) dopoz=1;
   window.open('../ucto/poznamky_po2013nacitaj.php?copern=' + riadok + '&drupoh=1&page=1&dopoz=' + dopoz + '&xxc=1', '_self');
  }
</script>
<script type="text/javascript" src="poznamky_po2011js.js"></script>
</HEAD>
<BODY class="white" onload="<?php if ( $copern == 1 ) { echo 'ukazrobot();'; } ?>
<?php if( $copern == 1 AND $dopoz == 1 ) { echo ' zobraz_robotmenu();'; } ?>"  >
<table class="h2" width="100%" >
<tr>
  <td>EuroSecom - Poznámky PO<?php if ( $copern == 1 ) { echo ' - naèítanie údajov'; } ?></td>
  <td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/robot3.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobrı deò , ja som Váš EkoRobot , ak máte otázku alebo nejaké elanie kliknite na mòa prosím 1x myšou' >
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

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$outfilexdel="../tmp/poznamky_".$kli_uzid."_*.*";
foreach (glob("$outfilexdel") as $filename) { unlink($filename); }
$outfilex="../tmp/poznamky_".$kli_uzid."_".$hhmmss.".pdf";
if ( File_Exists("$outfilex") ) { $soubor = unlink("$outfilex"); }

     define('FPDF_FONTPATH','../fpdf/font/');
     require('../fpdf/fpdf.php');

$sirka_vyska="210,320";
$velkost_strany = explode(",", $sirka_vyska);
$pdf=new FPDF("P","mm", $velkost_strany );
$pdf->Open();
$pdf->AddFont('arial','','arial.php');

//vytlac
$sqlmp = "SELECT * FROM F$kli_vxcf"."_ufirdalsie WHERE kkx >= 0 ";
$fir_mp = mysql_query($sqlmp);
$fir_rmp=mysql_fetch_object($fir_mp);
$aa2sk = SkDatum($fir_rmp->datvzn);

$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011$no WHERE psys >= 0 ".""; 
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

$bez1 = 1*$_REQUEST['bez1'];

$kli_vrokxd=$kli_vrok;

$datkxd="";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $datkxd=$riadok->datk;
  }
if( $datkxd != '' AND $datkxd != '0000-00-00' ) 
{  
$polexd = explode("-", $datkxd);
$kli_xdrok=$polexd[0];
$kli_xdmes=$polexd[1];
$kli_xdden=$polexd[2];

if( $kli_vrok == 2014 AND $kli_xdmes < 12 ) { $kli_vrokxd=2013; }
if( $kli_vrok == 2014 AND $kli_xdmes == 12 AND $kli_xdden < 31 ) { $kli_vrokxd=2013; }

//echo $kli_xdrok."-".$kli_xdmes."-".$kli_xdden;
//exit;
}

$priebeznauzav=0;
if( $kli_vxcf == 854 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
if( $kli_vxcf == 855 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
if( $kli_vxcf == 856 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
if( $kli_vxcf == 857 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
if( $kli_vxcf == 858 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
if( $kli_vxcf == 859 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
if( $kli_vxcf == 860 AND $_SERVER['SERVER_NAME'] == "www.zerotax.sk" )  { $priebeznauzav=1; $kli_vrokxd=2013; }
//if( $kli_vxcf == 73  AND $_SERVER['SERVER_NAME'] == "localhost" )       { $priebeznauzav=1; $kli_vrokxd=2013; }

if ( ( $strana == 1 OR $strana == 9999 ) AND $kli_vrokxd >= 2014 AND $bez1 == 0 ) {

$pdf->AddPage();
$pdf->SetFont('arial','',12);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/vykazy_pu2014/pod2014/uzpod_v14_str1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/vykazy_pu2014/pod2014/uzpod_v14_str1.jpg',0,0,210,297); 
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
if ( $fir_fico < 1000000 ) { $text="00".$fir_fico; }
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

//uctovna jednotka a druh uzavierky
$pdf->SetFont('arial','',10);
$mala=""; $velka="";
$druz=0;
//nacitaj druh uj
$druhuj=" ";
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $druhuj=$riadok->tpuj;
  $druz=1*$riadok->druz;
  }
if ( $druhuj == 1 ) { $mala="x"; $velka=""; }
if ( $druhuj == 2 ) { $mala=""; $velka="x"; }
if ( $kli_vrok <= 2014 ) { $mala=""; $velka=""; }
$h_drp=$druz+1;

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
$pdf->Cell(61,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$riadna","$rmc",0,"C");
$pdf->SetY(71);
$pdf->Cell(61,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$mimor","$rmc",0,"C");
$pdf->SetY(80);
$pdf->Cell(61,3," ","$rmc1",0,"C");$pdf->Cell(4,4,"$priebez","$rmc",0,"C");


$pdf->SetY(62);
$pdf->Cell(97,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$mala","$rmc",0,"C");
$pdf->SetY(71);
$pdf->Cell(97,3," ","$rmc1",0,"C");$pdf->Cell(3,4,"$velka","$rmc",0,"C");
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

//Sidlo
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
if ( $_SESSION['chrome'] == 1 ) {
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


                                       } //koniec strana 1 rok >= 2014

if ( ( $strana == 1 OR $strana == 9999 ) AND $kli_vrokxd < 2014 ) {

$pdf->AddPage();
$pdf->SetFont('arial','',9);

$pdf->SetLeftMargin(8); 
$pdf->SetTopMargin(10);

if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_vrchnastrana.jpg') AND $i == 0 )
{
if( $priebeznauzav == 0 ) { $pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_vrchnastrana.jpg',0,0,210,296); }
if( $priebeznauzav == 1 ) { $pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypuz_vrchnastrana.jpg',0,0,210,296); }
}

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
$pdf->Cell(190,15,"     ","$rmc1",1,"L");
$text=$datk_sk;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(86,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//dic
$pdf->Cell(190,29,"                          ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",1,"C");

//ico
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$A=substr($fir_fico,0,1);
$B=substr($fir_fico,1,1);
$C=substr($fir_fico,2,1);
$D=substr($fir_fico,3,1);
$E=substr($fir_fico,4,1);
$F=substr($fir_fico,5,1);
$G=substr($fir_fico,6,1);
$H=substr($fir_fico,7,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(4,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");

//sknace
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$pole = explode(".", $fir_sknace);
$sknacea=$pole[0];
$sn1a=substr($sknacea,0,1);
$sn2a=substr($sknacea,1,1);
$sknaceb=$pole[1];
$sn1b=substr($sknaceb,0,1);
$sn2b=substr($sknaceb,1,1);
$sknacec=$pole[2];
$sn1c=substr($sknacec,0,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1a","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$sn2a","$rmc",0,"C");
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1b","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$sn2b","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$sn1c","$rmc",1,"C");

//uctovna zavierka
$druz=0;
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_ufirdalsie ");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $druz=1*$riadok->druz;
  }

$riadna="x";
$mimoriadna=" ";
$priebez=" ";
if( $druz == 1 ) { $riadna=" "; $mimoriadna="x"; $priebez=" "; }
if( $priebeznauzav == 1 ) { $riadna=" "; $mimoriadna=" "; $priebez="x"; } 
$zostavena="x";
$schvalena="x";
$text=1*$hlavicka->a2e; if ( $text == 0 ) $schvalena="";
$text=1*$hlavicka->a1e; if ( $text == 0 ) $zostavena="";
$pdf->SetY(61);
$pdf->Cell(63,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$riadna","$rmc",0,"C");$pdf->Cell(27,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$zostavena","$rmc",1,"C");
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$pdf->Cell(63,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$mimoriadna","$rmc",0,"C");$pdf->Cell(27,3," ","$rmc1",0,"C");$pdf->Cell(3,3,"$schvalena","$rmc",1,"C");
$pdf->Cell(190,4,"                          ","$rmc1",1,"L");
$pdf->Cell(63,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$priebez","$rmc",1,"C");

//v eurocentoch
$keurocenty="x";
$kcenty=" ";
if ( $kli_nezis == 1001 ) { $keurocenty=" "; $kcenty="X"; }
$pdf->SetY(81);
$pdf->Cell(63,3," ","$rmc1",0,"C");$pdf->Cell(4,3,"$keurocenty","$rmc",1,"C");
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$pdf->Cell(63,3," ","$rmc1",0,"L");$pdf->Cell(4,3,"$kcenty","$rmc",1,"C");

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

//za obdobie
$me1=substr($obdm1,0,1);
$me2=substr($obdm1,1,1);
$ro1=substr($obdr1,2,1);
$ro2=substr($obdr1,3,1);
$pdf->SetY(59);
$pdf->Cell(158,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$me1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$me2","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$ro1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$ro2","$rmc",1,"C");

$me21=substr($obdm2,0,1);
$me22=substr($obdm2,1,1);
$ro21=substr($obdr2,2,1);
$ro22=substr($obdr2,3,1);
$pdf->SetY(68);
$pdf->Cell(158,5," ","0",0,"R");$pdf->Cell(4,6,"$me21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$me22","$rmc",0,"C");
$pdf->Cell(14,5," ","0",0,"R");$pdf->Cell(4,6,"$ro21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$ro22","$rmc",1,"C");

//predchadzajuce obdobie
$me31=substr($obmm1,0,1);
$me32=substr($obmm1,1,1);
$ro31=substr($obmr1,2,1);
$ro32=substr($obmr1,3,1);
$pdf->SetY(77);
$pdf->Cell(158,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$me31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$me32","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$ro31","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$ro32","$rmc",1,"C");

$me41=substr($obmm2,0,1);
$me42=substr($obmm2,1,1);
$ro41=substr($obmr2,2,1);
$ro42=substr($obmr2,3,1);
$pdf->SetY(85);
$pdf->Cell(158,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$me41","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$me42","$rmc",0,"C");
$pdf->Cell(14,5," ","$rmc1",0,"R");$pdf->Cell(4,6,"$ro41","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$ro42","$rmc",1,"C");

//nazov1
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

//nazov2
$pdf->Cell(190,3,"                          ","$rmc1",1,"L");
$fir_fnazr2=substr($fir_fnaz,30,30);
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
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

//Sidlo uctovej jednotky
//ulica
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");
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
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(5,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t28","$rmc",0,"C");

//cislo
$text=$fir_fcdm;
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$t06=substr($text,5,1);
$t07=substr($text,6,1);
$t08=substr($text,7,1);
$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,6,"$t08","$rmc",1,"C");

//psc
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");
$text=$fir_fpsc;
$text=str_replace(" ","",$text);
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,2,1);
$t04=substr($text,3,1);
$t05=substr($text,4,1);
$pdf->Cell(3,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");

//obec
$text=$fir_fmes;
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
$pdf->Cell(6,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t07","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t08","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t09","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t10","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t11","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t12","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t13","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t14","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t15","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t16","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t17","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t18","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t19","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t20","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t21","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t22","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t23","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t24","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t25","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t26","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t27","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t28","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t29","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t30","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$t31","$rmc",1,"C");

//telefon
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$text=$fir_ftel;
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(9,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",0,"C");

//fax
$text=$fir_ffax;
$text=str_replace(" ","",$text);
$pole = explode("/", $text);
$tel_pred=1*$pole[0];
$tel_za=$pole[1];
if ( $tel_pred == 0 ) $tel_pred="";
if ( $tel_za == 0 ) $tel_za="";
$t01=substr($tel_pred,0,1);
$t02=substr($tel_pred,1,1);
$t03=substr($tel_pred,2,1);
$t04=substr($tel_za,0,1);
$t05=substr($tel_za,1,1);
$t06=substr($tel_za,2,1);
$t07=substr($tel_za,3,1);
$t08=substr($tel_za,4,1);
$t09=substr($tel_za,5,1);
$t10=substr($tel_za,6,1);
$t11=substr($tel_za,7,1);
$pdf->Cell(11,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t01","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t02","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t03","$rmc",0,"C");$pdf->Cell(6,7," ","$rmc1",0,"C");$pdf->Cell(4,7,"$t04","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t05","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t06","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t07","$rmc",0,"C");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t08","$rmc",0,"C");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t09","$rmc",0,"R");$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(5,7,"$t10","$rmc",0,"R");
$pdf->Cell(1,7," ","$rmc",0,"C");$pdf->Cell(4,7,"$t11","$rmc",1,"C");

//email
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");
$A=substr($fir_fem1,0,1);$B=substr($fir_fem1,1,1);$C=substr($fir_fem1,2,1);$D=substr($fir_fem1,3,1);$E=substr($fir_fem1,4,1);
$F=substr($fir_fem1,5,1);$G=substr($fir_fem1,6,1);$H=substr($fir_fem1,7,1);$I=substr($fir_fem1,8,1);$J=substr($fir_fem1,9,1);
$K=substr($fir_fem1,10,1);$L=substr($fir_fem1,11,1);$M=substr($fir_fem1,12,1);$N=substr($fir_fem1,13,1);$O=substr($fir_fem1,14,1);
$P=substr($fir_fem1,15,1);$R=substr($fir_fem1,16,1);$S=substr($fir_fem1,17,1);$T=substr($fir_fem1,18,1);$U=substr($fir_fem1,19,1);
$V=substr($fir_fem1,20,1);$W=substr($fir_fem1,21,1);$X=substr($fir_fem1,22,1);$Y=substr($fir_fem1,23,1);$Z=substr($fir_fem1,24,1);
$A1=substr($fir_fem1,25,1);$B1=substr($fir_fem1,26,1);$C1=substr($fir_fem1,27,1);$D1=substr($fir_fem1,28,1);$E1=substr($fir_fem1,29,1);
$F1=substr($fir_fem1,30,1);$G1=substr($fir_fem1,31,1);$H1=substr($fir_fem1,32,1);$I1=substr($fir_fem1,33,1);$J1=substr($fir_fem1,34,1);
$K1=substr($fir_fem1,35,1);$L1=substr($fir_fem1,36,1);
$pdf->Cell(3,6," ","$rmc1",0,"R");$pdf->Cell(5,6,"$A","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$C","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$L","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$M","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$N","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$O","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$P","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$R","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$S","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$T","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$U","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$V","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$W","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$X","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Y","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$Z","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$A1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$B1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$C1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$D1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$E1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$F1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$G1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$H1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$I1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$J1","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$K1","$rmc",0,"C");
$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(5,6,"$L1","$rmc",1,"C");

$h_sch=$_REQUEST['h_sch'];
$h_zos=$_REQUEST['h_zos'];
if( $zostavena == 'x' ) { $h_sch=""; }
if( $schvalena == 'x' ) { $h_zos=""; }

//zostavena dna
$pdf->Cell(190,11,"                          ","$rmc1",1,"L");
$text=$h_zos;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//schvalene dna
$pdf->Cell(190,12,"                          ","$rmc1",1,"L");
$text=$h_sch;
if ( $text =='00.00.0000' ) $text="";
$t01=substr($text,0,1);
$t02=substr($text,1,1);
$t03=substr($text,3,1);
$t04=substr($text,4,1);
$t05=substr($text,8,1);
$t06=substr($text,9,1);
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t01","$rmc",0,"R");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t02","$rmc",0,"C");
$pdf->Cell(4,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t03","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t04","$rmc",0,"C");
$pdf->Cell(13,6," ","$rmc1",0,"C");$pdf->Cell(4,6,"$t05","$rmc",0,"C");$pdf->Cell(1,6," ","$rmc",0,"C");$pdf->Cell(4,6,"$t06","$rmc",1,"C");

//datum vzniku UJ
//$aa2sk = SkDatum($hlavicka->aa2);
//if( $aa2sk == '00.00.0000' ) $aa2sk="";
//$A=substr($aa2sk,0,1);
//$B=substr($aa2sk,1,1);
//$C=substr($aa2sk,3,1);
//$D=substr($aa2sk,4,1);
//$E=substr($aa2sk,6,1);
//$F=substr($aa2sk,7,1);
//$G=substr($aa2sk,8,1);
//$H=substr($aa2sk,9,1);
//$pdf->SetY(123);
//$pdf->Cell(1,3," ","$rmc",0,"C");$pdf->Cell(6,5,"$A","$rmc",0,"C");$pdf->Cell(6,5,"$B","$rmc",0,"C");$pdf->Cell(7,5," ","$rmc",0,"C");$pdf->Cell(6,5,"$C","$rmc",0,"C");
//$pdf->Cell(6,5,"$D","$rmc",0,"C");$pdf->Cell(6,5," ","$rmc",0,"C");$pdf->Cell(6,5,"$E","$rmc",0,"C");$pdf->Cell(6,5,"$F","$rmc",0,"C");$pdf->Cell(7,5,"$G","$rmc",0,"C");
//$pdf->Cell(6,5,"$H","$rmc",0,"C");

                                       } //koniec strana 1 rok < 2014


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
$sqlttt = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011texty WHERE ozntxt = '$ozntext' ";
//echo $sqlttt;
$sqldok = mysql_query("$sqlttt");
 if (@$zaznam=mysql_data_seek($sqldok,0))
 {
 $riaddok=mysql_fetch_object($sqldok);
 $textvypis=$riaddok->hdntxt;
 }

    return $textvypis;
    }


$sqlfir = "SELECT * FROM F$kli_vxcf"."_poznamky_podnopage ";
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
   $nopg26 = 1*$fir_riadok->nopg26;
   $nopg27 = 1*$fir_riadok->nopg27;
   $nopg28 = 1*$fir_riadok->nopg28;
   $nopg29 = 1*$fir_riadok->nopg29;
   $nopg30 = 1*$fir_riadok->nopg30;
   $nopg31 = 1*$fir_riadok->nopg31;
   $nopg32 = 1*$fir_riadok->nopg32;
   $nopg33 = 1*$fir_riadok->nopg33;
   $nopg34 = 1*$fir_riadok->nopg34;
   $nopg35 = 1*$fir_riadok->nopg35;
   $nopg36 = 1*$fir_riadok->nopg36;
   $nopg37 = 1*$fir_riadok->nopg37;
   $nopg38 = 1*$fir_riadok->nopg38;
   $nopg39 = 1*$fir_riadok->nopg39;
   $nopg40 = 1*$fir_riadok->nopg40;

$stranax=1;

if ( $nopg2 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab1.jpg',0,164,210,40);
}

$nazpoz="POD 3 - 04 ";
if( $kli_vrokxd >= 2014 ) { $nazpoz="POD 3 - 01 "; }
if( $priebeznauzav == 1 ) { $nazpoz="POD PÚZ 3-04 "; }

$stranax=$stranax+1;
//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"A. INFORMÁCIE O ÚÈTOVNEJ JEDNOTKE","$rmc",1,"L");


//cast A pism. c
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

$pdf->Cell(90,136,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"1. Informácie k èasti A. písm. c) prílohy è.3 o poète zamestnancov","$rmc",1,"L");
$pdf->Cell(90,12,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',9);
$pdf->Cell(82,6,"     ","$rmc1",0,"L");$pdf->Cell(47,6,"$hlavicka->ac11","$rmc",0,"R");$pdf->Cell(48,6,"$hlavicka->ac12","$rmc",1,"R");
$pdf->Cell(82,5,"     ","$rmc1",0,"L");$pdf->Cell(47,10,"$hlavicka->ac21","$rmc",0,"R");$pdf->Cell(48,10,"$hlavicka->ac22","$rmc",1,"R");
$pdf->Cell(82,5,"     ","$rmc1",0,"L");$pdf->Cell(47,7,"$hlavicka->ac31","$rmc",0,"R");$pdf->Cell(48,7,"$hlavicka->ac32","$rmc",1,"R");



$ozntext="A_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(30);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="A_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(208);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 2


if ( $nopg3 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

$stranax=$stranax+1;
//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"C. INFORMÁCIE O KONSOLIDOVANOM CELKU","$rmc",1,"L");

$ozntext="C_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf);
$poleosob = explode("\r\n", $textvypis);

if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="E_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(100);
$pdf->Cell(10,6," ","$rmc1",0,"L");$pdf->Cell(180,6,"E. INFORMÁCIE O POUITİCH ÚÈTOVNİCH ZÁSADÁCH A ÚÈTOVNİCH METÓDACH","$rmc",1,"L");
$pdf->Cell(0,5," ","$rmc",1,"L");

if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 3

if ( $nopg4 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

$stranax=$stranax+1;
//hlavicka strany
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



$ozntext="E_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

                                       } //koniec strana 4

if ( $nopg5 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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







$ozntext="E_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(130);

$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"F. INFORMÁCIE O ÚDAJOCH VYKÁZANİCH NA STRANE AKTÍV SÚVAHY ","$rmc",1,"L");
$pdf->Cell(0,5," ","$rmc",1,"L");

if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

                                       } //koniec strana 5

if ( $nopg6 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab3_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab3_1.jpg',0,37,210,180);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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




$pdf->Cell(90,10,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"3. Informácie k èasti F písm. a) prílohy è.3 o dlhodobom nehmotnom majetku","$rmc",1,"L");
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1 ","$rmc",1,"L");
$pdf->Cell(90,34,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',6);

//3.info k casti F pism. a tabulka 1.
//prvotne ocenenie
if( $hlavicka->f1a11b == 0 ) $hlavicka->f1a11b="";
if( $hlavicka->f1a11c == 0 ) $hlavicka->f1a11c="";
if( $hlavicka->f1a11d == 0 ) $hlavicka->f1a11d="";
if( $hlavicka->f1a11e == 0 ) $hlavicka->f1a11e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,8,"$hlavicka->f1a11b","$rmc",0,"R");$pdf->Cell(16,8,"$hlavicka->f1a11c","$rmc",0,"R");
$pdf->Cell(15,8,"$hlavicka->f1a11d","$rmc",0,"R");$pdf->Cell(17,8,"$hlavicka->f1a11e","$rmc",0,"R");
$pdf->Cell(13,8,"$hlavicka->f1a11f","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a11g","$rmc",0,"R");
$pdf->Cell(20,8,"$hlavicka->f1a11h","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a11i","$rmc",1,"R");


if( $hlavicka->f1a12b == 0 ) $hlavicka->f1a12b="";
if( $hlavicka->f1a12c == 0 ) $hlavicka->f1a12c="";
if( $hlavicka->f1a12d == 0 ) $hlavicka->f1a12d="";
if( $hlavicka->f1a12e == 0 ) $hlavicka->f1a12e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f1a12b","$rmc",0,"R");$pdf->Cell(16,7,"$hlavicka->f1a12c","$rmc",0,"R");
$pdf->Cell(15,7,"$hlavicka->f1a12d","$rmc",0,"R");$pdf->Cell(17,7,"$hlavicka->f1a12e","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1a12f","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1a12g","$rmc",0,"R");
$pdf->Cell(20,7,"$hlavicka->f1a12h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1a12i","$rmc",1,"R");


if( $hlavicka->f1a13b == 0 ) $hlavicka->f1a13b="";
if( $hlavicka->f1a13c == 0 ) $hlavicka->f1a13c="";
if( $hlavicka->f1a13d == 0 ) $hlavicka->f1a13d="";
if( $hlavicka->f1a13e == 0 ) $hlavicka->f1a13e="";
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


$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a13b","$rmc",0,"R");$pdf->Cell(16,6,"$hlavicka->f1a13c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a13d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f1a13e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f1a13f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a13g","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->f1a13h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a13i","$rmc",1,"R");

if( $hlavicka->f1a14b == 0 ) $hlavicka->f1a14b="";
if( $hlavicka->f1a14c == 0 ) $hlavicka->f1a14c="";
if( $hlavicka->f1a14d == 0 ) $hlavicka->f1a14d="";
if( $hlavicka->f1a14e == 0 ) $hlavicka->f1a14e="";
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


$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a14b","$rmc",0,"R");$pdf->Cell(16,6,"$hlavicka->f1a14c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a14d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f1a14e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f1a14f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a14g","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->f1a14h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a14i","$rmc",1,"R");

if( $hlavicka->f1a15b == 0 ) $hlavicka->f1a15b="";
if( $hlavicka->f1a15c == 0 ) $hlavicka->f1a15c="";
if( $hlavicka->f1a15d == 0 ) $hlavicka->f1a15d="";
if( $hlavicka->f1a15e == 0 ) $hlavicka->f1a15e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a15b","$rmc",0,"R");$pdf->Cell(16,9,"$hlavicka->f1a15c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a15d","$rmc",0,"R");$pdf->Cell(17,9,"$hlavicka->f1a15e","$rmc",0,"R");
$pdf->Cell(13,9,"$hlavicka->f1a15f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a15g","$rmc",0,"R");
$pdf->Cell(20,9,"$hlavicka->f1a15h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a15i","$rmc",1,"R");

//opravky
if( $hlavicka->f1a16b == 0 ) $hlavicka->f1a16b="";
if( $hlavicka->f1a16c == 0 ) $hlavicka->f1a16c="";
if( $hlavicka->f1a16d == 0 ) $hlavicka->f1a16d="";
if( $hlavicka->f1a16e == 0 ) $hlavicka->f1a16e="";
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

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a16b","$rmc",0,"R");$pdf->Cell(16,9,"$hlavicka->f1a16c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a16d","$rmc",0,"R");$pdf->Cell(17,9,"$hlavicka->f1a16e","$rmc",0,"R");
$pdf->Cell(13,9,"$hlavicka->f1a16f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a16g","$rmc",0,"R");
$pdf->Cell(20,9,"$hlavicka->f1a16h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a16i","$rmc",1,"R");


if( $hlavicka->f1a17b == 0 ) $hlavicka->f1a17b="";
if( $hlavicka->f1a17c == 0 ) $hlavicka->f1a17c="";
if( $hlavicka->f1a17d == 0 ) $hlavicka->f1a17d="";
if( $hlavicka->f1a17e == 0 ) $hlavicka->f1a17e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a17b","$rmc",0,"R");$pdf->Cell(16,6,"$hlavicka->f1a17c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a17d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f1a17e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f1a17f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a17g","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->f1a17h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a17i","$rmc",1,"R");

if( $hlavicka->f1a18b == 0 ) $hlavicka->f1a18b="";
if( $hlavicka->f1a18c == 0 ) $hlavicka->f1a18c="";
if( $hlavicka->f1a18d == 0 ) $hlavicka->f1a18d="";
if( $hlavicka->f1a18e == 0 ) $hlavicka->f1a18e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a18b","$rmc",0,"R");$pdf->Cell(16,6,"$hlavicka->f1a18c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a18d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f1a18e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f1a18f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a18g","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->f1a18h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a18i","$rmc",1,"R");


if( $f1a18pb == 0.00 ) $f1a18pb="";
if( $f1a18pc == 0.00 ) $f1a18pc="";
if( $f1a18pd == 0.00 ) $f1a18pd="";
if( $f1a18pe == 0.00 ) $f1a18pe="";
if( $f1a18pf == 0.00 ) $f1a18pf="";
if( $f1a18pg == 0.00 ) $f1a18pg="";
if( $f1a18ph == 0.00 ) $f1a18ph="";
if( $f1a18pi == 0.00 ) $f1a18pi="";


$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$f1a18pb","$rmc",0,"R");$pdf->Cell(16,7,"$f1a18pc","$rmc",0,"R");
$pdf->Cell(15,7,"$f1a18pd","$rmc",0,"R");$pdf->Cell(17,7,"$f1a18pe","$rmc",0,"R");
$pdf->Cell(13,7,"$f1a18pf","$rmc",0,"R");$pdf->Cell(15,7,"$f1a18pg","$rmc",0,"R");
$pdf->Cell(20,7,"$f1a18ph","$rmc",0,"R");$pdf->Cell(15,7,"$f1a18pi","$rmc",1,"R");


if( $hlavicka->f1a19b == 0 ) $hlavicka->f1a19b="";
if( $hlavicka->f1a19c == 0 ) $hlavicka->f1a19c="";
if( $hlavicka->f1a19d == 0 ) $hlavicka->f1a19d="";
if( $hlavicka->f1a19e == 0 ) $hlavicka->f1a19e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,8,"$hlavicka->f1a19b","$rmc",0,"R");$pdf->Cell(16,8,"$hlavicka->f1a19c","$rmc",0,"R");
$pdf->Cell(15,8,"$hlavicka->f1a19d","$rmc",0,"R");$pdf->Cell(17,8,"$hlavicka->f1a19e","$rmc",0,"R");
$pdf->Cell(13,8,"$hlavicka->f1a19f","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a19g","$rmc",0,"R");
$pdf->Cell(20,8,"$hlavicka->f1a19h","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a19i","$rmc",1,"R");


//opravne polozky
if( $hlavicka->f1a110b == 0 ) $hlavicka->f1a110b="";
if( $hlavicka->f1a110c == 0 ) $hlavicka->f1a110c="";
if( $hlavicka->f1a110d == 0 ) $hlavicka->f1a110d="";
if( $hlavicka->f1a110e == 0 ) $hlavicka->f1a110e="";
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

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a110b","$rmc",0,"R");$pdf->Cell(16,9,"$hlavicka->f1a110c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a110d","$rmc",0,"R");$pdf->Cell(17,9,"$hlavicka->f1a110e","$rmc",0,"R");
$pdf->Cell(13,9,"$hlavicka->f1a110f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a110g","$rmc",0,"R");
$pdf->Cell(20,9,"$hlavicka->f1a110h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a110i","$rmc",1,"R");


if( $hlavicka->f1a111b == 0 ) $hlavicka->f1a111b="";
if( $hlavicka->f1a111c == 0 ) $hlavicka->f1a111c="";
if( $hlavicka->f1a111d == 0 ) $hlavicka->f1a111d="";
if( $hlavicka->f1a111e == 0 ) $hlavicka->f1a111e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a111b","$rmc",0,"R");$pdf->Cell(16,6,"$hlavicka->f1a111c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a111d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f1a111e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f1a111f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a111g","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->f1a111h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a111i","$rmc",1,"R");


if( $hlavicka->f1a112b == 0 ) $hlavicka->f1a112b="";
if( $hlavicka->f1a112c == 0 ) $hlavicka->f1a112c="";
if( $hlavicka->f1a112d == 0 ) $hlavicka->f1a112d="";
if( $hlavicka->f1a112e == 0 ) $hlavicka->f1a112e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a112b","$rmc",0,"R");$pdf->Cell(16,6,"$hlavicka->f1a112c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a112d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f1a112e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f1a112f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a112g","$rmc",0,"R");
$pdf->Cell(20,6,"$hlavicka->f1a112h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a112i","$rmc",1,"R");


if( $f1a112pb == 0 ) $f1a112pb="";
if( $f1a112pc == 0 ) $f1a112pc="";
if( $f1a112pd == 0 ) $f1a112pd="";
if( $f1a112pe == 0 ) $f1a112pe="";
if( $f1a112pf == 0 ) $f1a112pf="";
if( $f1a112pg == 0 ) $f1a112pg="";
if( $f1a112ph == 0 ) $f1a112ph="";
if( $f1a112pi == 0 ) $f1a112pi="";

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$f1a112pb","$rmc",0,"R");$pdf->Cell(16,7,"$f1a112pc","$rmc",0,"R");
$pdf->Cell(15,7,"$f1a112pd","$rmc",0,"R");$pdf->Cell(17,7,"$f1a112pe","$rmc",0,"R");
$pdf->Cell(13,7,"$f1a112pf","$rmc",0,"R");$pdf->Cell(15,7,"$f1a112pg","$rmc",0,"R");
$pdf->Cell(20,7,"$f1a112ph","$rmc",0,"R");$pdf->Cell(15,7,"$f1a112pi","$rmc",1,"R");


if( $hlavicka->f1a113b == 0 ) $hlavicka->f1a113b="";
if( $hlavicka->f1a113c == 0 ) $hlavicka->f1a113c="";
if( $hlavicka->f1a113d == 0 ) $hlavicka->f1a113d="";
if( $hlavicka->f1a113e == 0 ) $hlavicka->f1a113e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,10,"$hlavicka->f1a113b","$rmc",0,"R");$pdf->Cell(16,10,"$hlavicka->f1a113c","$rmc",0,"R");
$pdf->Cell(15,10,"$hlavicka->f1a113d","$rmc",0,"R");$pdf->Cell(17,10,"$hlavicka->f1a113e","$rmc",0,"R");
$pdf->Cell(13,10,"$hlavicka->f1a113f","$rmc",0,"R");$pdf->Cell(15,10,"$hlavicka->f1a113g","$rmc",0,"R");
$pdf->Cell(20,10,"$hlavicka->f1a113h","$rmc",0,"R");$pdf->Cell(15,10,"$hlavicka->f1a113i","$rmc",1,"R");


//zostatkova
if( $hlavicka->f1a114b == 0 ) $hlavicka->f1a114b="";
if( $hlavicka->f1a114c == 0 ) $hlavicka->f1a114c="";
if( $hlavicka->f1a114d == 0 ) $hlavicka->f1a114d="";
if( $hlavicka->f1a114e == 0 ) $hlavicka->f1a114e="";
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

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,8,"$hlavicka->f1a114b","$rmc",0,"R");$pdf->Cell(16,8,"$hlavicka->f1a114c","$rmc",0,"R");
$pdf->Cell(15,8,"$hlavicka->f1a114d","$rmc",0,"R");$pdf->Cell(17,8,"$hlavicka->f1a114e","$rmc",0,"R");
$pdf->Cell(13,8,"$hlavicka->f1a114f","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a114g","$rmc",0,"R");
$pdf->Cell(20,8,"$hlavicka->f1a114h","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a114i","$rmc",1,"R");


if( $hlavicka->f1a115b == 0 ) $hlavicka->f1a115b="";
if( $hlavicka->f1a115c == 0 ) $hlavicka->f1a115c="";
if( $hlavicka->f1a115d == 0 ) $hlavicka->f1a115d="";
if( $hlavicka->f1a115e == 0 ) $hlavicka->f1a115e="";
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

$pdf->Cell(46,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a115b","$rmc",0,"R");$pdf->Cell(16,9,"$hlavicka->f1a115c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a115d","$rmc",0,"R");$pdf->Cell(17,9,"$hlavicka->f1a115e","$rmc",0,"R");
$pdf->Cell(13,9,"$hlavicka->f1a115f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a115g","$rmc",0,"R");
$pdf->Cell(20,9,"$hlavicka->f1a115h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a115i","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(216);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

                                       } //koniec strana 6

if ( $nopg7 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab3_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab3_2.jpg',1,33,210,180);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab4.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab4.jpg',1,242,210,15);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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


$pdf->Cell(90,10,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2 ","$rmc",1,"L");
$pdf->Cell(90,34,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',6);

//3.info k casti F pism. a tabulka 2. minuly rok
//prvotne ocenenie
if( $hlavicka->f1a21b == 0 ) $hlavicka->f1a21b="";
if( $hlavicka->f1a21c == 0 ) $hlavicka->f1a21c="";
if( $hlavicka->f1a21d == 0 ) $hlavicka->f1a21d="";
if( $hlavicka->f1a21e == 0 ) $hlavicka->f1a21e="";
if( $hlavicka->f1a21f == 0 ) $hlavicka->f1a21f="";
if( $hlavicka->f1a21g == 0 ) $hlavicka->f1a21g="";
if( $hlavicka->f1a21h == 0 ) $hlavicka->f1a21h="";
if( $hlavicka->f1a21i == 0 ) $hlavicka->f1a21i="";

$hlavicka->f1a21bnyg46nyg46="1234.56";
$hlavicka->f1a21cnyg46nyg46="1234.56";
$hlavicka->f1a21dnyg46nyg46="1234.56";
$hlavicka->f1a21enyg46nyg46="1234.56";
$hlavicka->f1a21fnyg46nyg46="1234.56";
$hlavicka->f1a21gnyg46nyg46="1234.56";
$hlavicka->f1a21hnyg46nyg46="1234.56";
$hlavicka->f1a21inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,8,"$hlavicka->f1a21b","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a21c","$rmc",0,"R");
$pdf->Cell(15,8,"$hlavicka->f1a21d","$rmc",0,"R");$pdf->Cell(18,8,"$hlavicka->f1a21e","$rmc",0,"R");
$pdf->Cell(12,8,"$hlavicka->f1a21f","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a21g","$rmc",0,"R");
$pdf->Cell(21,8,"$hlavicka->f1a21h","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1a21i","$rmc",1,"R");


if( $hlavicka->f1a22b == 0 ) $hlavicka->f1a22b="";
if( $hlavicka->f1a22c == 0 ) $hlavicka->f1a22c="";
if( $hlavicka->f1a22d == 0 ) $hlavicka->f1a22d="";
if( $hlavicka->f1a22e == 0 ) $hlavicka->f1a22e="";
if( $hlavicka->f1a22f == 0 ) $hlavicka->f1a22f="";
if( $hlavicka->f1a22g == 0 ) $hlavicka->f1a22g="";
if( $hlavicka->f1a22h == 0 ) $hlavicka->f1a22h="";
if( $hlavicka->f1a22i == 0 ) $hlavicka->f1a22i="";

$hlavicka->f1a22bnyg46nyg46="1234.56";
$hlavicka->f1a22cnyg46nyg46="1234.56";
$hlavicka->f1a22dnyg46nyg46="1234.56";
$hlavicka->f1a22enyg46nyg46="1234.56";
$hlavicka->f1a22fnyg46nyg46="1234.56";
$hlavicka->f1a22gnyg46nyg46="1234.56";
$hlavicka->f1a22hnyg46nyg46="1234.56";
$hlavicka->f1a22inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f1a22b","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1a22c","$rmc",0,"R");
$pdf->Cell(15,7,"$hlavicka->f1a22d","$rmc",0,"R");$pdf->Cell(18,7,"$hlavicka->f1a22e","$rmc",0,"R");
$pdf->Cell(12,7,"$hlavicka->f1a22f","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1a22g","$rmc",0,"R");
$pdf->Cell(21,7,"$hlavicka->f1a22h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1a22i","$rmc",1,"R");


if( $hlavicka->f1a23b == 0 ) $hlavicka->f1a23b="";
if( $hlavicka->f1a23c == 0 ) $hlavicka->f1a23c="";
if( $hlavicka->f1a23d == 0 ) $hlavicka->f1a23d="";
if( $hlavicka->f1a23e == 0 ) $hlavicka->f1a23e="";
if( $hlavicka->f1a23f == 0 ) $hlavicka->f1a23f="";
if( $hlavicka->f1a23g == 0 ) $hlavicka->f1a23g="";
if( $hlavicka->f1a23h == 0 ) $hlavicka->f1a23h="";
if( $hlavicka->f1a23i == 0 ) $hlavicka->f1a23i="";

$hlavicka->f1a23bnyg46nyg46="1234.56";
$hlavicka->f1a23cnyg46nyg46="1234.56";
$hlavicka->f1a23dnyg46nyg46="1234.56";
$hlavicka->f1a23enyg46nyg46="1234.56";
$hlavicka->f1a23fnyg46nyg46="1234.56";
$hlavicka->f1a23gnyg46nyg46="1234.56";
$hlavicka->f1a23hnyg46nyg46="1234.56";
$hlavicka->f1a23inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a23b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a23c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a23d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f1a23e","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f1a23f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a23g","$rmc",0,"R");
$pdf->Cell(21,6,"$hlavicka->f1a23h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a23i","$rmc",1,"R");


if( $hlavicka->f1a24b == 0 ) $hlavicka->f1a24b="";
if( $hlavicka->f1a24c == 0 ) $hlavicka->f1a24c="";
if( $hlavicka->f1a24d == 0 ) $hlavicka->f1a24d="";
if( $hlavicka->f1a24e == 0 ) $hlavicka->f1a24e="";
if( $hlavicka->f1a24f == 0 ) $hlavicka->f1a24f="";
if( $hlavicka->f1a24g == 0 ) $hlavicka->f1a24g="";
if( $hlavicka->f1a24h == 0 ) $hlavicka->f1a24h="";
if( $hlavicka->f1a24i == 0 ) $hlavicka->f1a24i="";

$hlavicka->f1a24bnyg46nyg46="1234.56";
$hlavicka->f1a24cnyg46nyg46="1234.56";
$hlavicka->f1a24dnyg46nyg46="1234.56";
$hlavicka->f1a24enyg46nyg46="1234.56";
$hlavicka->f1a24fnyg46nyg46="1234.56";
$hlavicka->f1a24gnyg46nyg46="1234.56";
$hlavicka->f1a24hnyg46nyg46="1234.56";
$hlavicka->f1a24inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a24b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a24c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a24d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f1a24e","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f1a24f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a24g","$rmc",0,"R");
$pdf->Cell(21,6,"$hlavicka->f1a24h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a24i","$rmc",1,"R");


if( $hlavicka->f1a25b == 0 ) $hlavicka->f1a25b="";
if( $hlavicka->f1a25c == 0 ) $hlavicka->f1a25c="";
if( $hlavicka->f1a25d == 0 ) $hlavicka->f1a25d="";
if( $hlavicka->f1a25e == 0 ) $hlavicka->f1a25e="";
if( $hlavicka->f1a25f == 0 ) $hlavicka->f1a25f="";
if( $hlavicka->f1a25g == 0 ) $hlavicka->f1a25g="";
if( $hlavicka->f1a25h == 0 ) $hlavicka->f1a25h="";
if( $hlavicka->f1a25i == 0 ) $hlavicka->f1a25i="";

$hlavicka->f1a25bnyg46nyg46="1234.56";
$hlavicka->f1a25cnyg46nyg46="1234.56";
$hlavicka->f1a25dnyg46nyg46="1234.56";
$hlavicka->f1a25enyg46nyg46="1234.56";
$hlavicka->f1a25fnyg46nyg46="1234.56";
$hlavicka->f1a25gnyg46nyg46="1234.56";
$hlavicka->f1a25hnyg46nyg46="1234.56";
$hlavicka->f1a25inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a25b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a25c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a25d","$rmc",0,"R");$pdf->Cell(18,9,"$hlavicka->f1a25e","$rmc",0,"R");
$pdf->Cell(12,9,"$hlavicka->f1a25f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a25g","$rmc",0,"R");
$pdf->Cell(21,9,"$hlavicka->f1a25h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a25i","$rmc",1,"R");


//opravky
if( $hlavicka->f1a26b == 0 ) $hlavicka->f1a26b="";
if( $hlavicka->f1a26c == 0 ) $hlavicka->f1a26c="";
if( $hlavicka->f1a26d == 0 ) $hlavicka->f1a26d="";
if( $hlavicka->f1a26e == 0 ) $hlavicka->f1a26e="";
if( $hlavicka->f1a26f == 0 ) $hlavicka->f1a26f="";
if( $hlavicka->f1a26g == 0 ) $hlavicka->f1a26g="";
if( $hlavicka->f1a26h == 0 ) $hlavicka->f1a26h="";
if( $hlavicka->f1a26i == 0 ) $hlavicka->f1a26i="";

$hlavicka->f1a26bnyg46nyg46="1234.56";
$hlavicka->f1a26cnyg46nyg46="1234.56";
$hlavicka->f1a26dnyg46nyg46="1234.56";
$hlavicka->f1a26enyg46nyg46="1234.56";
$hlavicka->f1a26fnyg46nyg46="1234.56";
$hlavicka->f1a26gnyg46nyg46="1234.56";
$hlavicka->f1a26hnyg46nyg46="1234.56";
$hlavicka->f1a26inyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a26b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a26c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a26d","$rmc",0,"R");$pdf->Cell(18,9,"$hlavicka->f1a26e","$rmc",0,"R");
$pdf->Cell(12,9,"$hlavicka->f1a26f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a26g","$rmc",0,"R");
$pdf->Cell(21,9,"$hlavicka->f1a26h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a26i","$rmc",1,"R");


if( $hlavicka->f1a27b == 0 ) $hlavicka->f1a27b="";
if( $hlavicka->f1a27c == 0 ) $hlavicka->f1a27c="";
if( $hlavicka->f1a27d == 0 ) $hlavicka->f1a27d="";
if( $hlavicka->f1a27e == 0 ) $hlavicka->f1a27e="";
if( $hlavicka->f1a27f == 0 ) $hlavicka->f1a27f="";
if( $hlavicka->f1a27g == 0 ) $hlavicka->f1a27g="";
if( $hlavicka->f1a27h == 0 ) $hlavicka->f1a27h="";
if( $hlavicka->f1a27i == 0 ) $hlavicka->f1a27i="";

$hlavicka->f1a27bnyg46nyg46="1234.56";
$hlavicka->f1a27cnyg46nyg46="1234.56";
$hlavicka->f1a27dnyg46nyg46="1234.56";
$hlavicka->f1a27enyg46nyg46="1234.56";
$hlavicka->f1a27fnyg46nyg46="1234.56";
$hlavicka->f1a27gnyg46nyg46="1234.56";
$hlavicka->f1a27hnyg46nyg46="1234.56";
$hlavicka->f1a27inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a27b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a27c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a27d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f1a27e","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f1a27f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a27g","$rmc",0,"R");
$pdf->Cell(21,6,"$hlavicka->f1a27h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a27i","$rmc",1,"R");


if( $hlavicka->f1a28b == 0 ) $hlavicka->f1a28b="";
if( $hlavicka->f1a28c == 0 ) $hlavicka->f1a28c="";
if( $hlavicka->f1a28d == 0 ) $hlavicka->f1a28d="";
if( $hlavicka->f1a28e == 0 ) $hlavicka->f1a28e="";
if( $hlavicka->f1a28f == 0 ) $hlavicka->f1a28f="";
if( $hlavicka->f1a28g == 0 ) $hlavicka->f1a28g="";
if( $hlavicka->f1a28h == 0 ) $hlavicka->f1a28h="";
if( $hlavicka->f1a28i == 0 ) $hlavicka->f1a28i="";

$hlavicka->f1a28bnyg46nyg46="1234.56";
$hlavicka->f1a28cnyg46nyg46="1234.56";
$hlavicka->f1a28dnyg46nyg46="1234.56";
$hlavicka->f1a28enyg46nyg46="1234.56";
$hlavicka->f1a28fnyg46nyg46="1234.56";
$hlavicka->f1a28gnyg46nyg46="1234.56";
$hlavicka->f1a28hnyg46nyg46="1234.56";
$hlavicka->f1a28inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a28b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a28c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a28d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f1a28e","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f1a28f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a28g","$rmc",0,"R");
$pdf->Cell(21,6,"$hlavicka->f1a28h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a28i","$rmc",1,"R");


if( $f1a28pb == 0 ) $f1a28pb="";
if( $f1a28pc == 0 ) $f1a28pc="";
if( $f1a28pd == 0 ) $f1a28pd="";
if( $f1a28pe == 0 ) $f1a28pe="";
if( $f1a28pf == 0 ) $f1a28pf="";
if( $f1a28pg == 0 ) $f1a28pg="";
if( $f1a28ph == 0 ) $f1a28ph="";
if( $f1a28pi == 0 ) $f1a28pi="";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$f1a28pb","$rmc",0,"R");$pdf->Cell(15,6,"$f1a28pc","$rmc",0,"R");
$pdf->Cell(15,6,"$f1a28pd","$rmc",0,"R");$pdf->Cell(18,6,"$f1a28pe","$rmc",0,"R");
$pdf->Cell(12,6,"$f1a28pf","$rmc",0,"R");$pdf->Cell(15,6,"$f1a28pg","$rmc",0,"R");
$pdf->Cell(21,6,"$f1a28ph","$rmc",0,"R");$pdf->Cell(15,6,"$f1a28pi","$rmc",1,"R");


if( $hlavicka->f1a29b == 0 ) $hlavicka->f1a29b="";
if( $hlavicka->f1a29c == 0 ) $hlavicka->f1a29c="";
if( $hlavicka->f1a29d == 0 ) $hlavicka->f1a29d="";
if( $hlavicka->f1a29e == 0 ) $hlavicka->f1a29e="";
if( $hlavicka->f1a29f == 0 ) $hlavicka->f1a29f="";
if( $hlavicka->f1a29g == 0 ) $hlavicka->f1a29g="";
if( $hlavicka->f1a29h == 0 ) $hlavicka->f1a29h="";
if( $hlavicka->f1a29i == 0 ) $hlavicka->f1a29i="";

$hlavicka->f1a29bnyg46nyg46="1234.56";
$hlavicka->f1a29cnyg46nyg46="1234.56";
$hlavicka->f1a29dnyg46nyg46="1234.56";
$hlavicka->f1a29enyg46nyg46="1234.56";
$hlavicka->f1a29fnyg46nyg46="1234.56";
$hlavicka->f1a29gnyg46nyg46="1234.56";
$hlavicka->f1a29hnyg46nyg46="1234.56";
$hlavicka->f1a29inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a29b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a29c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a29d","$rmc",0,"R");$pdf->Cell(18,9,"$hlavicka->f1a29e","$rmc",0,"R");
$pdf->Cell(12,9,"$hlavicka->f1a29f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a29g","$rmc",0,"R");
$pdf->Cell(21,9,"$hlavicka->f1a29h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a29i","$rmc",1,"R");


//opravne polozky
if( $hlavicka->f1a210b == 0 ) $hlavicka->f1a210b="";
if( $hlavicka->f1a210c == 0 ) $hlavicka->f1a210c="";
if( $hlavicka->f1a210d == 0 ) $hlavicka->f1a210d="";
if( $hlavicka->f1a210e == 0 ) $hlavicka->f1a210e="";
if( $hlavicka->f1a210f == 0 ) $hlavicka->f1a210f="";
if( $hlavicka->f1a210g == 0 ) $hlavicka->f1a210g="";
if( $hlavicka->f1a210h == 0 ) $hlavicka->f1a210h="";
if( $hlavicka->f1a210i == 0 ) $hlavicka->f1a210i="";

$hlavicka->f1a210bnyg46nyg46="1234.56";
$hlavicka->f1a210cnyg46nyg46="1234.56";
$hlavicka->f1a210dnyg46nyg46="1234.56";
$hlavicka->f1a210enyg46nyg46="1234.56";
$hlavicka->f1a210fnyg46nyg46="1234.56";
$hlavicka->f1a210gnyg46nyg46="1234.56";
$hlavicka->f1a210hnyg46nyg46="1234.56";
$hlavicka->f1a210inyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a210b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a210c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a210d","$rmc",0,"R");$pdf->Cell(18,9,"$hlavicka->f1a210e","$rmc",0,"R");
$pdf->Cell(12,9,"$hlavicka->f1a210f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a210g","$rmc",0,"R");
$pdf->Cell(21,9,"$hlavicka->f1a210h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a210i","$rmc",1,"R");


if( $hlavicka->f1a211b == 0 ) $hlavicka->f1a211b="";
if( $hlavicka->f1a211c == 0 ) $hlavicka->f1a211c="";
if( $hlavicka->f1a211d == 0 ) $hlavicka->f1a211d="";
if( $hlavicka->f1a211e == 0 ) $hlavicka->f1a211e="";
if( $hlavicka->f1a211f == 0 ) $hlavicka->f1a211f="";
if( $hlavicka->f1a211g == 0 ) $hlavicka->f1a211g="";
if( $hlavicka->f1a211h == 0 ) $hlavicka->f1a211h="";
if( $hlavicka->f1a211i == 0 ) $hlavicka->f1a211i="";

$hlavicka->f1a211bnyg46nyg46="1234.56";
$hlavicka->f1a211cnyg46nyg46="1234.56";
$hlavicka->f1a211dnyg46nyg46="1234.56";
$hlavicka->f1a211enyg46nyg46="1234.56";
$hlavicka->f1a211fnyg46nyg46="1234.56";
$hlavicka->f1a211gnyg46nyg46="1234.56";
$hlavicka->f1a211hnyg46nyg46="1234.56";
$hlavicka->f1a211inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a211b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a211c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a211d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f1a211e","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f1a211f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a211g","$rmc",0,"R");
$pdf->Cell(21,6,"$hlavicka->f1a211h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a211i","$rmc",1,"R");


if( $hlavicka->f1a212b == 0 ) $hlavicka->f1a212b="";
if( $hlavicka->f1a212c == 0 ) $hlavicka->f1a212c="";
if( $hlavicka->f1a212d == 0 ) $hlavicka->f1a212d="";
if( $hlavicka->f1a212e == 0 ) $hlavicka->f1a212e="";
if( $hlavicka->f1a212f == 0 ) $hlavicka->f1a212f="";
if( $hlavicka->f1a212g == 0 ) $hlavicka->f1a212g="";
if( $hlavicka->f1a212h == 0 ) $hlavicka->f1a212h="";
if( $hlavicka->f1a212i == 0 ) $hlavicka->f1a212i="";

$hlavicka->f1a212bnyg46nyg46="1234.56";
$hlavicka->f1a212cnyg46nyg46="1234.56";
$hlavicka->f1a212dnyg46nyg46="1234.56";
$hlavicka->f1a212enyg46nyg46="1234.56";
$hlavicka->f1a212fnyg46nyg46="1234.56";
$hlavicka->f1a212gnyg46nyg46="1234.56";
$hlavicka->f1a212hnyg46nyg46="1234.56";
$hlavicka->f1a212inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f1a212b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a212c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f1a212d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f1a212e","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f1a212f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a212g","$rmc",0,"R");
$pdf->Cell(21,6,"$hlavicka->f1a212h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f1a212i","$rmc",1,"R");


if( $f1a212pb == 0 ) $f1a212pb="";
if( $f1a212pc == 0 ) $f1a212pc="";
if( $f1a212pd == 0 ) $f1a212pd="";
if( $f1a212pe == 0 ) $f1a212pe="";
if( $f1a212pf == 0 ) $f1a212pf="";
if( $f1a212pg == 0 ) $f1a212pg="";
if( $f1a212ph == 0 ) $f1a212ph="";
if( $f1a212pi == 0 ) $f1a212pi="";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$f1a212pb","$rmc",0,"R");$pdf->Cell(15,6,"$f1a212pc","$rmc",0,"R");
$pdf->Cell(15,6,"$f1a212pd","$rmc",0,"R");$pdf->Cell(18,6,"$f1a212pe","$rmc",0,"R");
$pdf->Cell(12,6,"$f1a212pf","$rmc",0,"R");$pdf->Cell(15,6,"$f1a212pg","$rmc",0,"R");
$pdf->Cell(21,6,"$f1a212ph","$rmc",0,"R");$pdf->Cell(15,6,"$f1a212pi","$rmc",1,"R");


if( $hlavicka->f1a213b == 0 ) $hlavicka->f1a213b="";
if( $hlavicka->f1a213c == 0 ) $hlavicka->f1a213c="";
if( $hlavicka->f1a213d == 0 ) $hlavicka->f1a213d="";
if( $hlavicka->f1a213e == 0 ) $hlavicka->f1a213e="";
if( $hlavicka->f1a213f == 0 ) $hlavicka->f1a213f="";
if( $hlavicka->f1a213g == 0 ) $hlavicka->f1a213g="";
if( $hlavicka->f1a213h == 0 ) $hlavicka->f1a213h="";
if( $hlavicka->f1a213i == 0 ) $hlavicka->f1a213i="";

$hlavicka->f1a213bnyg46nyg46="1234.56";
$hlavicka->f1a213cnyg46nyg46="1234.56";
$hlavicka->f1a213dnyg46nyg46="1234.56";
$hlavicka->f1a213enyg46nyg46="1234.56";
$hlavicka->f1a213fnyg46nyg46="1234.56";
$hlavicka->f1a213gnyg46nyg46="1234.56";
$hlavicka->f1a213hnyg46nyg46="1234.56";
$hlavicka->f1a213inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,11,"$hlavicka->f1a213b","$rmc",0,"R");$pdf->Cell(15,11,"$hlavicka->f1a213c","$rmc",0,"R");
$pdf->Cell(15,11,"$hlavicka->f1a213d","$rmc",0,"R");$pdf->Cell(18,11,"$hlavicka->f1a213e","$rmc",0,"R");
$pdf->Cell(12,11,"$hlavicka->f1a213f","$rmc",0,"R");$pdf->Cell(15,11,"$hlavicka->f1a213g","$rmc",0,"R");
$pdf->Cell(21,11,"$hlavicka->f1a213h","$rmc",0,"R");$pdf->Cell(15,11,"$hlavicka->f1a213i","$rmc",1,"R");


//zostatkova
if( $hlavicka->f1a214b == 0 ) $hlavicka->f1a214b="";
if( $hlavicka->f1a214c == 0 ) $hlavicka->f1a214c="";
if( $hlavicka->f1a214d == 0 ) $hlavicka->f1a214d="";
if( $hlavicka->f1a214e == 0 ) $hlavicka->f1a214e="";
if( $hlavicka->f1a214f == 0 ) $hlavicka->f1a214f="";
if( $hlavicka->f1a214g == 0 ) $hlavicka->f1a214g="";
if( $hlavicka->f1a214h == 0 ) $hlavicka->f1a214h="";
if( $hlavicka->f1a214i == 0 ) $hlavicka->f1a214i="";

$hlavicka->f1a214bnyg46nyg46="1234.56";
$hlavicka->f1a214cnyg46nyg46="1234.56";
$hlavicka->f1a214dnyg46nyg46="1234.56";
$hlavicka->f1a214enyg46nyg46="1234.56";
$hlavicka->f1a214fnyg46nyg46="1234.56";
$hlavicka->f1a214gnyg46nyg46="1234.56";
$hlavicka->f1a214hnyg46nyg46="1234.56";
$hlavicka->f1a214inyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a214b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a214c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a214d","$rmc",0,"R");$pdf->Cell(18,9,"$hlavicka->f1a214e","$rmc",0,"R");
$pdf->Cell(12,9,"$hlavicka->f1a214f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a214g","$rmc",0,"R");
$pdf->Cell(21,9,"$hlavicka->f1a214h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a214i","$rmc",1,"R");


if( $hlavicka->f1a215b == 0 ) $hlavicka->f1a215b="";
if( $hlavicka->f1a215c == 0 ) $hlavicka->f1a215c="";
if( $hlavicka->f1a215d == 0 ) $hlavicka->f1a215d="";
if( $hlavicka->f1a215e == 0 ) $hlavicka->f1a215e="";
if( $hlavicka->f1a215f == 0 ) $hlavicka->f1a215f="";
if( $hlavicka->f1a215g == 0 ) $hlavicka->f1a215g="";
if( $hlavicka->f1a215h == 0 ) $hlavicka->f1a215h="";
if( $hlavicka->f1a215i == 0 ) $hlavicka->f1a215i="";

$hlavicka->f1a215bnyg46nyg46="1234.56";
$hlavicka->f1a215cnyg46nyg46="1234.56";
$hlavicka->f1a215dnyg46nyg46="1234.56";
$hlavicka->f1a215enyg46nyg46="1234.56";
$hlavicka->f1a215fnyg46nyg46="1234.56";
$hlavicka->f1a215gnyg46nyg46="1234.56";
$hlavicka->f1a215hnyg46nyg46="1234.56";
$hlavicka->f1a215inyg46nyg46="1234.56";

$pdf->Cell(48,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f1a215b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a215c","$rmc",0,"R");
$pdf->Cell(15,9,"$hlavicka->f1a215d","$rmc",0,"R");$pdf->Cell(18,9,"$hlavicka->f1a215e","$rmc",0,"R");
$pdf->Cell(12,9,"$hlavicka->f1a215f","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a215g","$rmc",0,"R");
$pdf->Cell(21,9,"$hlavicka->f1a215h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f1a215i","$rmc",1,"R");


$pdf->Cell(90,27,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"3. Informácie k èasti F písm. c) prílohy è.3 o dlhodobom nehmotnom majetku","$rmc",1,"L");
$pdf->Cell(90,9,"     ","$rmc1",1,"L");

//4. info k casti F pism. c
$pdf->SetFont('arial','',9);
if( $hlavicka->f1c1 == 0 ) $hlavicka->f1c1="";
if( $hlavicka->f1c2 == 0 ) $hlavicka->f1c2="";

$hlavicka->f1c1nyg46nyg46="1234.56";
$hlavicka->f1c2nyg46nyg46="1234.56";
$pdf->Cell(128,5,"     ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f1c1","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(213);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(272);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

                                       } //koniec strana 7

if ( $nopg8 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_1.jpg',0,28,210,208);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_1b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_1b.jpg',0.2,236,213.2,21.5);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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

$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"3. Informácie k èasti F písm. a) prílohy è.3 o dlhodobom hmotnom majetku","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc1",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1 ","$rmc",1,"L");
$pdf->Cell(90,50,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',5);

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

$hlavicka->f2a11bnyg46nyg46="1234.56";
$hlavicka->f2a11cnyg46nyg46="1234.56";
$hlavicka->f2a11dnyg46nyg46="1234.56";
$hlavicka->f2a11enyg46nyg46="1234.56";
$hlavicka->f2a11fnyg46nyg46="1234.56";
$hlavicka->f2a11gnyg46nyg46="1234.56";
$hlavicka->f2a11hnyg46nyg46="1234.56";
$hlavicka->f2a11inyg46nyg46="1234.56";
$hlavicka->f2a11jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,16,"$hlavicka->f2a11b","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2a11c","$rmc",0,"R");
$pdf->Cell(15,16,"$hlavicka->f2a11d","$rmc",0,"R");$pdf->Cell(18,16,"$hlavicka->f2a11e","$rmc",0,"R");
$pdf->Cell(19,16,"$hlavicka->f2a11f","$rmc",0,"R");$pdf->Cell(12,16,"$hlavicka->f2a11g","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a11h","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2a11i","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a11j","$rmc",1,"R");


if( $hlavicka->f2a12b == 0 ) $hlavicka->f2a12b="";
if( $hlavicka->f2a12c == 0 ) $hlavicka->f2a12c="";
if( $hlavicka->f2a12d == 0 ) $hlavicka->f2a12d="";
if( $hlavicka->f2a12e == 0 ) $hlavicka->f2a12e="";
if( $hlavicka->f2a12f == 0 ) $hlavicka->f2a12f="";
if( $hlavicka->f2a12g == 0 ) $hlavicka->f2a12g="";
if( $hlavicka->f2a12h == 0 ) $hlavicka->f2a12h="";
if( $hlavicka->f2a12i == 0 ) $hlavicka->f2a12i="";
if( $hlavicka->f2a12j == 0 ) $hlavicka->f2a12j="";

$hlavicka->f2a12bnyg46nyg46="1234.56";
$hlavicka->f2a12cnyg46nyg46="1234.56";
$hlavicka->f2a12dnyg46nyg46="1234.56";
$hlavicka->f2a12enyg46nyg46="1234.56";
$hlavicka->f2a12fnyg46nyg46="1234.56";
$hlavicka->f2a12gnyg46nyg46="1234.56";
$hlavicka->f2a12hnyg46nyg46="1234.56";
$hlavicka->f2a12inyg46nyg46="1234.56";
$hlavicka->f2a12jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a12b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a12c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f2a12d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f2a12e","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2a12f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a12g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a12h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a12i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a12j","$rmc",1,"R");


if( $hlavicka->f2a13b == 0 ) $hlavicka->f2a13b="";
if( $hlavicka->f2a13c == 0 ) $hlavicka->f2a13c="";
if( $hlavicka->f2a13d == 0 ) $hlavicka->f2a13d="";
if( $hlavicka->f2a13e == 0 ) $hlavicka->f2a13e="";
if( $hlavicka->f2a13f == 0 ) $hlavicka->f2a13f="";
if( $hlavicka->f2a13g == 0 ) $hlavicka->f2a13g="";
if( $hlavicka->f2a13h == 0 ) $hlavicka->f2a13h="";
if( $hlavicka->f2a13i == 0 ) $hlavicka->f2a13i="";
if( $hlavicka->f2a13j == 0 ) $hlavicka->f2a13j="";

$hlavicka->f2a13bnyg46nyg46="1234.56";
$hlavicka->f2a13cnyg46nyg46="1234.56";
$hlavicka->f2a13dnyg46nyg46="1234.56";
$hlavicka->f2a13enyg46nyg46="1234.56";
$hlavicka->f2a13fnyg46nyg46="1234.56";
$hlavicka->f2a13gnyg46nyg46="1234.56";
$hlavicka->f2a13hnyg46nyg46="1234.56";
$hlavicka->f2a13inyg46nyg46="1234.56";
$hlavicka->f2a13jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f2a13b","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a13c","$rmc",0,"R");
$pdf->Cell(15,7,"$hlavicka->f2a13d","$rmc",0,"R");$pdf->Cell(18,7,"$hlavicka->f2a13e","$rmc",0,"R");
$pdf->Cell(19,7,"$hlavicka->f2a13f","$rmc",0,"R");$pdf->Cell(12,7,"$hlavicka->f2a13g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a13h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a13i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a13j","$rmc",1,"R");


if( $hlavicka->f2a14b == 0 ) $hlavicka->f2a14b="";
if( $hlavicka->f2a14c == 0 ) $hlavicka->f2a14c="";
if( $hlavicka->f2a14d == 0 ) $hlavicka->f2a14d="";
if( $hlavicka->f2a14e == 0 ) $hlavicka->f2a14e="";
if( $hlavicka->f2a14f == 0 ) $hlavicka->f2a14f="";
if( $hlavicka->f2a14g == 0 ) $hlavicka->f2a14g="";
if( $hlavicka->f2a14h == 0 ) $hlavicka->f2a14h="";
if( $hlavicka->f2a14i == 0 ) $hlavicka->f2a14i="";
if( $hlavicka->f2a14j == 0 ) $hlavicka->f2a14j="";

$hlavicka->f2a14bnyg46nyg46="1234.56";
$hlavicka->f2a14cnyg46nyg46="1234.56";
$hlavicka->f2a14dnyg46nyg46="1234.56";
$hlavicka->f2a14enyg46nyg46="1234.56";
$hlavicka->f2a14fnyg46nyg46="1234.56";
$hlavicka->f2a14gnyg46nyg46="1234.56";
$hlavicka->f2a14hnyg46nyg46="1234.56";
$hlavicka->f2a14inyg46nyg46="1234.56";
$hlavicka->f2a14jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a14b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a14c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f2a14d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f2a14e","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2a14f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a14g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a14h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a14i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a14j","$rmc",1,"R");


if( $hlavicka->f2a15b == 0 ) $hlavicka->f2a15b="";
if( $hlavicka->f2a15c == 0 ) $hlavicka->f2a15c="";
if( $hlavicka->f2a15d == 0 ) $hlavicka->f2a15d="";
if( $hlavicka->f2a15e == 0 ) $hlavicka->f2a15e="";
if( $hlavicka->f2a15f == 0 ) $hlavicka->f2a15f="";
if( $hlavicka->f2a15g == 0 ) $hlavicka->f2a15g="";
if( $hlavicka->f2a15h == 0 ) $hlavicka->f2a15h="";
if( $hlavicka->f2a15i == 0 ) $hlavicka->f2a15i="";
if( $hlavicka->f2a15j == 0 ) $hlavicka->f2a15j="";

$hlavicka->f2a15bnyg46nyg46="1234.56";
$hlavicka->f2a15cnyg46nyg46="1234.56";
$hlavicka->f2a15dnyg46nyg46="1234.56";
$hlavicka->f2a15enyg46nyg46="1234.56";
$hlavicka->f2a15fnyg46nyg46="1234.56";
$hlavicka->f2a15gnyg46nyg46="1234.56";
$hlavicka->f2a15hnyg46nyg46="1234.56";
$hlavicka->f2a15inyg46nyg46="1234.56";
$hlavicka->f2a15jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,12,"$hlavicka->f2a15b","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a15c","$rmc",0,"R");
$pdf->Cell(15,12,"$hlavicka->f2a15d","$rmc",0,"R");$pdf->Cell(18,12,"$hlavicka->f2a15e","$rmc",0,"R");
$pdf->Cell(19,12,"$hlavicka->f2a15f","$rmc",0,"R");$pdf->Cell(12,12,"$hlavicka->f2a15g","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a15h","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a15i","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a15j","$rmc",1,"R");


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

$hlavicka->f2a16bnyg46nyg46="1234.56";
$hlavicka->f2a16cnyg46nyg46="1234.56";
$hlavicka->f2a16dnyg46nyg46="1234.56";
$hlavicka->f2a16enyg46nyg46="1234.56";
$hlavicka->f2a16fnyg46nyg46="1234.56";
$hlavicka->f2a16gnyg46nyg46="1234.56";
$hlavicka->f2a16hnyg46nyg46="1234.56";
$hlavicka->f2a16inyg46nyg46="1234.56";
$hlavicka->f2a16jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,17,"$hlavicka->f2a16b","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a16c","$rmc",0,"R");
$pdf->Cell(15,17,"$hlavicka->f2a16d","$rmc",0,"R");$pdf->Cell(18,17,"$hlavicka->f2a16e","$rmc",0,"R");
$pdf->Cell(19,17,"$hlavicka->f2a16f","$rmc",0,"R");$pdf->Cell(12,17,"$hlavicka->f2a16g","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a16h","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a16i","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a16j","$rmc",1,"R");


if( $hlavicka->f2a17b == 0 ) $hlavicka->f2a17b="";
if( $hlavicka->f2a17c == 0 ) $hlavicka->f2a17c="";
if( $hlavicka->f2a17d == 0 ) $hlavicka->f2a17d="";
if( $hlavicka->f2a17e == 0 ) $hlavicka->f2a17e="";
if( $hlavicka->f2a17f == 0 ) $hlavicka->f2a17f="";
if( $hlavicka->f2a17g == 0 ) $hlavicka->f2a17g="";
if( $hlavicka->f2a17h == 0 ) $hlavicka->f2a17h="";
if( $hlavicka->f2a17i == 0 ) $hlavicka->f2a17i="";
if( $hlavicka->f2a17j == 0 ) $hlavicka->f2a17j="";

$hlavicka->f2a17bnyg46nyg46="1234.56";
$hlavicka->f2a17cnyg46nyg46="1234.56";
$hlavicka->f2a17dnyg46nyg46="1234.56";
$hlavicka->f2a17enyg46nyg46="1234.56";
$hlavicka->f2a17fnyg46nyg46="1234.56";
$hlavicka->f2a17gnyg46nyg46="1234.56";
$hlavicka->f2a17hnyg46nyg46="1234.56";
$hlavicka->f2a17inyg46nyg46="1234.56";
$hlavicka->f2a17jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a17b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a17c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f2a17d","$rmc",0,"R");$pdf->Cell(18,6,"$hlavicka->f2a17e","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2a17f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a17g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a17h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a17i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a17j","$rmc",1,"R");


if( $hlavicka->f2a18b == 0 ) $hlavicka->f2a18b="";
if( $hlavicka->f2a18c == 0 ) $hlavicka->f2a18c="";
if( $hlavicka->f2a18d == 0 ) $hlavicka->f2a18d="";
if( $hlavicka->f2a18e == 0 ) $hlavicka->f2a18e="";
if( $hlavicka->f2a18f == 0 ) $hlavicka->f2a18f="";
if( $hlavicka->f2a18g == 0 ) $hlavicka->f2a18g="";
if( $hlavicka->f2a18h == 0 ) $hlavicka->f2a18h="";
if( $hlavicka->f2a18i == 0 ) $hlavicka->f2a18i="";
if( $hlavicka->f2a18j == 0 ) $hlavicka->f2a18j="";

$hlavicka->f2a18bnyg46nyg46="1234.56";
$hlavicka->f2a18cnyg46nyg46="1234.56";
$hlavicka->f2a18dnyg46nyg46="1234.56";
$hlavicka->f2a18enyg46nyg46="1234.56";
$hlavicka->f2a18fnyg46nyg46="1234.56";
$hlavicka->f2a18gnyg46nyg46="1234.56";
$hlavicka->f2a18hnyg46nyg46="1234.56";
$hlavicka->f2a18inyg46nyg46="1234.56";
$hlavicka->f2a18jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f2a18b","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a18c","$rmc",0,"R");
$pdf->Cell(15,7,"$hlavicka->f2a18d","$rmc",0,"R");$pdf->Cell(18,7,"$hlavicka->f2a18e","$rmc",0,"R");
$pdf->Cell(19,7,"$hlavicka->f2a18f","$rmc",0,"R");$pdf->Cell(12,7,"$hlavicka->f2a18g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a18h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a18i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a18j","$rmc",1,"R");


if( $f2a18pb == 0 ) $f2a18pb="";
if( $f2a18pc == 0 ) $f2a18pc="";
if( $f2a18pd == 0 ) $f2a18pd="";
if( $f2a18pe == 0 ) $f2a18pe="";
if( $f2a18pf == 0 ) $f2a18pf="";
if( $f2a18pg == 0 ) $f2a18pg="";
if( $f2a18ph == 0 ) $f2a18ph="";
if( $f2a18pi == 0 ) $f2a18pi="";
if( $f2a18pj == 0 ) $f2a18pj="";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$f2a18pb","$rmc",0,"R");$pdf->Cell(15,6,"$f2a18pc","$rmc",0,"R");
$pdf->Cell(15,6,"$f2a18pd","$rmc",0,"R");$pdf->Cell(18,6,"$f2a18pe","$rmc",0,"R");
$pdf->Cell(19,6,"$f2a18pf","$rmc",0,"R");$pdf->Cell(12,6,"$f2a18pg","$rmc",0,"R");
$pdf->Cell(13,6,"$f2a18ph","$rmc",0,"R");$pdf->Cell(15,6,"$f2a18pi","$rmc",0,"R");
$pdf->Cell(13,6,"$f2a18pj","$rmc",1,"R");


if( $hlavicka->f2a19b == 0 ) $hlavicka->f2a19b="";
if( $hlavicka->f2a19c == 0 ) $hlavicka->f2a19c="";
if( $hlavicka->f2a19d == 0 ) $hlavicka->f2a19d="";
if( $hlavicka->f2a19e == 0 ) $hlavicka->f2a19e="";
if( $hlavicka->f2a19f == 0 ) $hlavicka->f2a19f="";
if( $hlavicka->f2a19g == 0 ) $hlavicka->f2a19g="";
if( $hlavicka->f2a19h == 0 ) $hlavicka->f2a19h="";
if( $hlavicka->f2a19i == 0 ) $hlavicka->f2a19i="";
if( $hlavicka->f2a19j == 0 ) $hlavicka->f2a19j="";

$hlavicka->f2a19bnyg46nyg46="1234.56";
$hlavicka->f2a19cnyg46nyg46="1234.56";
$hlavicka->f2a19dnyg46nyg46="1234.56";
$hlavicka->f2a19enyg46nyg46="1234.56";
$hlavicka->f2a19fnyg46nyg46="1234.56";
$hlavicka->f2a19gnyg46nyg46="1234.56";
$hlavicka->f2a19hnyg46nyg46="1234.56";
$hlavicka->f2a19inyg46nyg46="1234.56";
$hlavicka->f2a19jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,12,"$hlavicka->f2a19b","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a19c","$rmc",0,"R");
$pdf->Cell(15,12,"$hlavicka->f2a19d","$rmc",0,"R");$pdf->Cell(18,12,"$hlavicka->f2a19e","$rmc",0,"R");
$pdf->Cell(19,12,"$hlavicka->f2a19f","$rmc",0,"R");$pdf->Cell(12,12,"$hlavicka->f2a19g","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a19h","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a19i","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a19j","$rmc",1,"R");


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

$hlavicka->f2a110bnyg46nyg46="1234.56";
$hlavicka->f2a110cnyg46nyg46="1234.56";
$hlavicka->f2a110dnyg46nyg46="1234.56";
$hlavicka->f2a110enyg46nyg46="1234.56";
$hlavicka->f2a110fnyg46nyg46="1234.56";
$hlavicka->f2a110gnyg46nyg46="1234.56";
$hlavicka->f2a110hnyg46nyg46="1234.56";
$hlavicka->f2a110inyg46nyg46="1234.56";
$hlavicka->f2a110jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,17,"$hlavicka->f2a110b","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a110c","$rmc",0,"R");
$pdf->Cell(14,17,"$hlavicka->f2a110d","$rmc",0,"R");$pdf->Cell(19,17,"$hlavicka->f2a110e","$rmc",0,"R");
$pdf->Cell(19,17,"$hlavicka->f2a110f","$rmc",0,"R");$pdf->Cell(12,17,"$hlavicka->f2a110g","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a110h","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a110i","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a110j","$rmc",1,"R");


if( $hlavicka->f2a111b == 0 ) $hlavicka->f2a111b="";
if( $hlavicka->f2a111c == 0 ) $hlavicka->f2a111c="";
if( $hlavicka->f2a111d == 0 ) $hlavicka->f2a111d="";
if( $hlavicka->f2a111e == 0 ) $hlavicka->f2a111e="";
if( $hlavicka->f2a111f == 0 ) $hlavicka->f2a111f="";
if( $hlavicka->f2a111g == 0 ) $hlavicka->f2a111g="";
if( $hlavicka->f2a111h == 0 ) $hlavicka->f2a111h="";
if( $hlavicka->f2a111i == 0 ) $hlavicka->f2a111i="";
if( $hlavicka->f2a111j == 0 ) $hlavicka->f2a111j="";

$hlavicka->f2a111bnyg46nyg46="1234.56";
$hlavicka->f2a111cnyg46nyg46="1234.56";
$hlavicka->f2a111dnyg46nyg46="1234.56";
$hlavicka->f2a111enyg46nyg46="1234.56";
$hlavicka->f2a111fnyg46nyg46="1234.56";
$hlavicka->f2a111gnyg46nyg46="1234.56";
$hlavicka->f2a111hnyg46nyg46="1234.56";
$hlavicka->f2a111inyg46nyg46="1234.56";
$hlavicka->f2a111jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a111b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a111c","$rmc",0,"R");
$pdf->Cell(14,6,"$hlavicka->f2a111d","$rmc",0,"R");$pdf->Cell(19,6,"$hlavicka->f2a111e","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2a111f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a111g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a111h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a111i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a111j","$rmc",1,"R");


if( $hlavicka->f2a112b == 0 ) $hlavicka->f2a112b="";
if( $hlavicka->f2a112c == 0 ) $hlavicka->f2a112c="";
if( $hlavicka->f2a112d == 0 ) $hlavicka->f2a112d="";
if( $hlavicka->f2a112e == 0 ) $hlavicka->f2a112e="";
if( $hlavicka->f2a112f == 0 ) $hlavicka->f2a112f="";
if( $hlavicka->f2a112g == 0 ) $hlavicka->f2a112g="";
if( $hlavicka->f2a112h == 0 ) $hlavicka->f2a112h="";
if( $hlavicka->f2a112i == 0 ) $hlavicka->f2a112i="";
if( $hlavicka->f2a112j == 0 ) $hlavicka->f2a112j="";

$hlavicka->f2a112bnyg46nyg46="1234.56";
$hlavicka->f2a112cnyg46nyg46="1234.56";
$hlavicka->f2a112dnyg46nyg46="1234.56";
$hlavicka->f2a112enyg46nyg46="1234.56";
$hlavicka->f2a112fnyg46nyg46="1234.56";
$hlavicka->f2a112gnyg46nyg46="1234.56";
$hlavicka->f2a112hnyg46nyg46="1234.56";
$hlavicka->f2a112inyg46nyg46="1234.56";
$hlavicka->f2a112jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a112b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a112c","$rmc",0,"R");
$pdf->Cell(14,6,"$hlavicka->f2a112d","$rmc",0,"R");$pdf->Cell(19,6,"$hlavicka->f2a112e","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2a112f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a112g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a112h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a112i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a112j","$rmc",1,"R");


if( $f2a112pb == 0 ) $f2a112pb="";
if( $f2a112pc == 0 ) $f2a112pc="";
if( $f2a112pd == 0 ) $f2a112pd="";
if( $f2a112pe == 0 ) $f2a112pe="";
if( $f2a112pf == 0 ) $f2a112pf="";
if( $f2a112pg == 0 ) $f2a112pg="";
if( $f2a112ph == 0 ) $f2a112ph="";
if( $f2a112pi == 0 ) $f2a112pi="";
if( $f2a112pj == 0 ) $f2a112pj="";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$f2a112pb","$rmc",0,"R");$pdf->Cell(15,7,"$f2a112pc","$rmc",0,"R");
$pdf->Cell(14,7,"$f2a112pd","$rmc",0,"R");$pdf->Cell(19,7,"$f2a112pe","$rmc",0,"R");
$pdf->Cell(19,7,"$f2a112pf","$rmc",0,"R");$pdf->Cell(12,7,"$f2a112pg","$rmc",0,"R");
$pdf->Cell(13,7,"$f2a112ph","$rmc",0,"R");$pdf->Cell(15,7,"$f2a112pi","$rmc",0,"R");
$pdf->Cell(13,7,"$f2a112pj","$rmc",1,"R");


if( $hlavicka->f2a113b == 0 ) $hlavicka->f2a113b="";
if( $hlavicka->f2a113c == 0 ) $hlavicka->f2a113c="";
if( $hlavicka->f2a113d == 0 ) $hlavicka->f2a113d="";
if( $hlavicka->f2a113e == 0 ) $hlavicka->f2a113e="";
if( $hlavicka->f2a113f == 0 ) $hlavicka->f2a113f="";
if( $hlavicka->f2a113g == 0 ) $hlavicka->f2a113g="";
if( $hlavicka->f2a113h == 0 ) $hlavicka->f2a113h="";
if( $hlavicka->f2a113i == 0 ) $hlavicka->f2a113i="";
if( $hlavicka->f2a113j == 0 ) $hlavicka->f2a113j="";

$hlavicka->f2a113bnyg46nyg46="1234.56";
$hlavicka->f2a113cnyg46nyg46="1234.56";
$hlavicka->f2a113dnyg46nyg46="1234.56";
$hlavicka->f2a113enyg46nyg46="1234.56";
$hlavicka->f2a113fnyg46nyg46="1234.56";
$hlavicka->f2a113gnyg46nyg46="1234.56";
$hlavicka->f2a113hnyg46nyg46="1234.56";
$hlavicka->f2a113inyg46nyg46="1234.56";
$hlavicka->f2a113jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,12,"$hlavicka->f2a113b","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a113c","$rmc",0,"R");
$pdf->Cell(14,12,"$hlavicka->f2a113d","$rmc",0,"R");$pdf->Cell(19,12,"$hlavicka->f2a113e","$rmc",0,"R");
$pdf->Cell(19,12,"$hlavicka->f2a113f","$rmc",0,"R");$pdf->Cell(12,12,"$hlavicka->f2a113g","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a113h","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a113i","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a113j","$rmc",1,"R");


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

$hlavicka->f2a114bnyg46nyg46="1234.56";
$hlavicka->f2a114cnyg46nyg46="1234.56";
$hlavicka->f2a114dnyg46nyg46="1234.56";
$hlavicka->f2a114enyg46nyg46="1234.56";
$hlavicka->f2a114fnyg46nyg46="1234.56";
$hlavicka->f2a114gnyg46nyg46="1234.56";
$hlavicka->f2a114hnyg46nyg46="1234.56";
$hlavicka->f2a114inyg46nyg46="1234.56";
$hlavicka->f2a114jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,12,"$hlavicka->f2a114b","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a114c","$rmc",0,"R");
$pdf->Cell(14,12,"$hlavicka->f2a114d","$rmc",0,"R");$pdf->Cell(19,12,"$hlavicka->f2a114e","$rmc",0,"R");
$pdf->Cell(19,12,"$hlavicka->f2a114f","$rmc",0,"R");$pdf->Cell(12,12,"$hlavicka->f2a114g","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a114h","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a114i","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a114j","$rmc",1,"R");


if( $hlavicka->f2a115b == 0 ) $hlavicka->f2a115b="";
if( $hlavicka->f2a115c == 0 ) $hlavicka->f2a115c="";
if( $hlavicka->f2a115d == 0 ) $hlavicka->f2a115d="";
if( $hlavicka->f2a115e == 0 ) $hlavicka->f2a115e="";
if( $hlavicka->f2a115f == 0 ) $hlavicka->f2a115f="";
if( $hlavicka->f2a115g == 0 ) $hlavicka->f2a115g="";
if( $hlavicka->f2a115h == 0 ) $hlavicka->f2a115h="";
if( $hlavicka->f2a115i == 0 ) $hlavicka->f2a115i="";
if( $hlavicka->f2a115j == 0 ) $hlavicka->f2a115j="";

$hlavicka->f2a115bnyg46nyg46="1234.56";
$hlavicka->f2a115cnyg46nyg46="1234.56";
$hlavicka->f2a115dnyg46nyg46="1234.56";
$hlavicka->f2a115enyg46nyg46="1234.56";
$hlavicka->f2a115fnyg46nyg46="1234.56";
$hlavicka->f2a115gnyg46nyg46="1234.56";
$hlavicka->f2a115hnyg46nyg46="1234.56";
$hlavicka->f2a115inyg46nyg46="1234.56";
$hlavicka->f2a115jnyg46nyg46="1234.56";

$pdf->Cell(42,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,9,"$hlavicka->f2a115b","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f2a115c","$rmc",0,"R");
$pdf->Cell(14,9,"$hlavicka->f2a115d","$rmc",0,"R");$pdf->Cell(19,9,"$hlavicka->f2a115e","$rmc",0,"R");
$pdf->Cell(19,9,"$hlavicka->f2a115f","$rmc",0,"R");$pdf->Cell(12,9,"$hlavicka->f2a115g","$rmc",0,"R");
$pdf->Cell(13,9,"$hlavicka->f2a115h","$rmc",0,"R");$pdf->Cell(15,9,"$hlavicka->f2a115i","$rmc",0,"R");
$pdf->Cell(13,9,"$hlavicka->f2a115j","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text5"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(258);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 8

if ( $nopg9 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_2.jpg',0,30,210,180);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_2b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab5_2b.jpg',-0.2,209,210.2,60);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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


$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4," ","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2 ","$rmc",1,"L");
$pdf->Cell(90,50,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',5);
//5.info k casti F pism. o dlhodobom hmotnom majetku a tabulka 2. minuly rok
//prvotne ocenenie
if( $hlavicka->f2a21b == 0 ) $hlavicka->f2a21b="";
if( $hlavicka->f2a21c == 0 ) $hlavicka->f2a21c="";
if( $hlavicka->f2a21d == 0 ) $hlavicka->f2a21d="";
if( $hlavicka->f2a21e == 0 ) $hlavicka->f2a21e="";
if( $hlavicka->f2a21f == 0 ) $hlavicka->f2a21f="";
if( $hlavicka->f2a21g == 0 ) $hlavicka->f2a21g="";
if( $hlavicka->f2a21h == 0 ) $hlavicka->f2a21h="";
if( $hlavicka->f2a21i == 0 ) $hlavicka->f2a21i="";
if( $hlavicka->f2a21j == 0 ) $hlavicka->f2a21j="";

$hlavicka->f2a21bnyg46nyg46="1234.56";
$hlavicka->f2a21cnyg46nyg46="1234.56";
$hlavicka->f2a21dnyg46nyg46="1234.56";
$hlavicka->f2a21enyg46nyg46="1234.56";
$hlavicka->f2a21fnyg46nyg46="1234.56";
$hlavicka->f2a21gnyg46nyg46="1234.56";
$hlavicka->f2a21hnyg46nyg46="1234.56";
$hlavicka->f2a21inyg46nyg46="1234.56";
$hlavicka->f2a21jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,17,"$hlavicka->f2a21b","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a21c","$rmc",0,"R");
$pdf->Cell(15,17,"$hlavicka->f2a21d","$rmc",0,"R");$pdf->Cell(17,17,"$hlavicka->f2a21e","$rmc",0,"R");
$pdf->Cell(18,17,"$hlavicka->f2a21f","$rmc",0,"R");$pdf->Cell(12,17,"$hlavicka->f2a21g","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a21h","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a21i","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a21j","$rmc",1,"R");


if( $hlavicka->f2a22b == 0 ) $hlavicka->f2a22b="";
if( $hlavicka->f2a22c == 0 ) $hlavicka->f2a22c="";
if( $hlavicka->f2a22d == 0 ) $hlavicka->f2a22d="";
if( $hlavicka->f2a22e == 0 ) $hlavicka->f2a22e="";
if( $hlavicka->f2a22f == 0 ) $hlavicka->f2a22f="";
if( $hlavicka->f2a22g == 0 ) $hlavicka->f2a22g="";
if( $hlavicka->f2a22h == 0 ) $hlavicka->f2a22h="";
if( $hlavicka->f2a22i == 0 ) $hlavicka->f2a22i="";
if( $hlavicka->f2a22j == 0 ) $hlavicka->f2a22j="";

$hlavicka->f2a22bnyg46nyg46="1234.56";
$hlavicka->f2a22cnyg46nyg46="1234.56";
$hlavicka->f2a22dnyg46nyg46="1234.56";
$hlavicka->f2a22enyg46nyg46="1234.56";
$hlavicka->f2a22fnyg46nyg46="1234.56";
$hlavicka->f2a22gnyg46nyg46="1234.56";
$hlavicka->f2a22hnyg46nyg46="1234.56";
$hlavicka->f2a22inyg46nyg46="1234.56";
$hlavicka->f2a22jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a22b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a22c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f2a22d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f2a22e","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2a22f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a22g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a22h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a22i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a22j","$rmc",1,"R");


if( $hlavicka->f2a23b == 0 ) $hlavicka->f2a23b="";
if( $hlavicka->f2a23c == 0 ) $hlavicka->f2a23c="";
if( $hlavicka->f2a23d == 0 ) $hlavicka->f2a23d="";
if( $hlavicka->f2a23e == 0 ) $hlavicka->f2a23e="";
if( $hlavicka->f2a23f == 0 ) $hlavicka->f2a23f="";
if( $hlavicka->f2a23g == 0 ) $hlavicka->f2a23g="";
if( $hlavicka->f2a23h == 0 ) $hlavicka->f2a23h="";
if( $hlavicka->f2a23i == 0 ) $hlavicka->f2a23i="";
if( $hlavicka->f2a23j == 0 ) $hlavicka->f2a23j="";

$hlavicka->f2a23bnyg46nyg46="1234.56";
$hlavicka->f2a23cnyg46nyg46="1234.56";
$hlavicka->f2a23dnyg46nyg46="1234.56";
$hlavicka->f2a23enyg46nyg46="1234.56";
$hlavicka->f2a23fnyg46nyg46="1234.56";
$hlavicka->f2a23gnyg46nyg46="1234.56";
$hlavicka->f2a23hnyg46nyg46="1234.56";
$hlavicka->f2a23inyg46nyg46="1234.56";
$hlavicka->f2a23jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f2a23b","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a23c","$rmc",0,"R");
$pdf->Cell(15,7,"$hlavicka->f2a23d","$rmc",0,"R");$pdf->Cell(17,7,"$hlavicka->f2a23e","$rmc",0,"R");
$pdf->Cell(18,7,"$hlavicka->f2a23f","$rmc",0,"R");$pdf->Cell(12,7,"$hlavicka->f2a23g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a23h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a23i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a23j","$rmc",1,"R");


if( $hlavicka->f2a24b == 0 ) $hlavicka->f2a24b="";
if( $hlavicka->f2a24c == 0 ) $hlavicka->f2a24c="";
if( $hlavicka->f2a24d == 0 ) $hlavicka->f2a24d="";
if( $hlavicka->f2a24e == 0 ) $hlavicka->f2a24e="";
if( $hlavicka->f2a24f == 0 ) $hlavicka->f2a24f="";
if( $hlavicka->f2a24g == 0 ) $hlavicka->f2a24g="";
if( $hlavicka->f2a24h == 0 ) $hlavicka->f2a24h="";
if( $hlavicka->f2a24i == 0 ) $hlavicka->f2a24i="";
if( $hlavicka->f2a24j == 0 ) $hlavicka->f2a24j="";

$hlavicka->f2a24bnyg46nyg46="1234.56";
$hlavicka->f2a24cnyg46nyg46="1234.56";
$hlavicka->f2a24dnyg46nyg46="1234.56";
$hlavicka->f2a24enyg46nyg46="1234.56";
$hlavicka->f2a24fnyg46nyg46="1234.56";
$hlavicka->f2a24gnyg46nyg46="1234.56";
$hlavicka->f2a24hnyg46nyg46="1234.56";
$hlavicka->f2a24inyg46nyg46="1234.56";
$hlavicka->f2a24jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a24b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a24c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f2a24d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f2a24e","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2a24f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a24g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a24h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a24i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a24j","$rmc",1,"R");


if( $hlavicka->f2a25b == 0 ) $hlavicka->f2a25b="";
if( $hlavicka->f2a25c == 0 ) $hlavicka->f2a25c="";
if( $hlavicka->f2a25d == 0 ) $hlavicka->f2a25d="";
if( $hlavicka->f2a25e == 0 ) $hlavicka->f2a25e="";
if( $hlavicka->f2a25f == 0 ) $hlavicka->f2a25f="";
if( $hlavicka->f2a25g == 0 ) $hlavicka->f2a25g="";
if( $hlavicka->f2a25h == 0 ) $hlavicka->f2a25h="";
if( $hlavicka->f2a25i == 0 ) $hlavicka->f2a25i="";
if( $hlavicka->f2a25j == 0 ) $hlavicka->f2a25j="";

$hlavicka->f2a25bnyg46nyg46="1234.56";
$hlavicka->f2a25cnyg46nyg46="1234.56";
$hlavicka->f2a25dnyg46nyg46="1234.56";
$hlavicka->f2a25enyg46nyg46="1234.56";
$hlavicka->f2a25fnyg46nyg46="1234.56";
$hlavicka->f2a25gnyg46nyg46="1234.56";
$hlavicka->f2a25hnyg46nyg46="1234.56";
$hlavicka->f2a25inyg46nyg46="1234.56";
$hlavicka->f2a25jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,13,"$hlavicka->f2a25b","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f2a25c","$rmc",0,"R");
$pdf->Cell(15,13,"$hlavicka->f2a25d","$rmc",0,"R");$pdf->Cell(17,13,"$hlavicka->f2a25e","$rmc",0,"R");
$pdf->Cell(18,13,"$hlavicka->f2a25f","$rmc",0,"R");$pdf->Cell(12,13,"$hlavicka->f2a25g","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f2a25h","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f2a25i","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f2a25j","$rmc",1,"R");


//opravky
if( $hlavicka->f2a26b == 0 ) $hlavicka->f2a26b="";
if( $hlavicka->f2a26c == 0 ) $hlavicka->f2a26c="";
if( $hlavicka->f2a26d == 0 ) $hlavicka->f2a26d="";
if( $hlavicka->f2a26e == 0 ) $hlavicka->f2a26e="";
if( $hlavicka->f2a26f == 0 ) $hlavicka->f2a26f="";
if( $hlavicka->f2a26g == 0 ) $hlavicka->f2a26g="";
if( $hlavicka->f2a26h == 0 ) $hlavicka->f2a26h="";
if( $hlavicka->f2a26i == 0 ) $hlavicka->f2a26i="";
if( $hlavicka->f2a26j == 0 ) $hlavicka->f2a26j="";

$hlavicka->f2a26bnyg46nyg46="1234.56";
$hlavicka->f2a26cnyg46nyg46="1234.56";
$hlavicka->f2a26dnyg46nyg46="1234.56";
$hlavicka->f2a26enyg46nyg46="1234.56";
$hlavicka->f2a26fnyg46nyg46="1234.56";
$hlavicka->f2a26gnyg46nyg46="1234.56";
$hlavicka->f2a26hnyg46nyg46="1234.56";
$hlavicka->f2a26inyg46nyg46="1234.56";
$hlavicka->f2a26jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,16,"$hlavicka->f2a26b","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2a26c","$rmc",0,"R");
$pdf->Cell(15,16,"$hlavicka->f2a26d","$rmc",0,"R");$pdf->Cell(17,16,"$hlavicka->f2a26e","$rmc",0,"R");
$pdf->Cell(18,16,"$hlavicka->f2a26f","$rmc",0,"R");$pdf->Cell(12,16,"$hlavicka->f2a26g","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a26h","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2a26i","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a26j","$rmc",1,"R");


if( $hlavicka->f2a27b == 0 ) $hlavicka->f2a27b="";
if( $hlavicka->f2a27c == 0 ) $hlavicka->f2a27c="";
if( $hlavicka->f2a27d == 0 ) $hlavicka->f2a27d="";
if( $hlavicka->f2a27e == 0 ) $hlavicka->f2a27e="";
if( $hlavicka->f2a27f == 0 ) $hlavicka->f2a27f="";
if( $hlavicka->f2a27g == 0 ) $hlavicka->f2a27g="";
if( $hlavicka->f2a27h == 0 ) $hlavicka->f2a27h="";
if( $hlavicka->f2a27i == 0 ) $hlavicka->f2a27i="";
if( $hlavicka->f2a27j == 0 ) $hlavicka->f2a27j="";

$hlavicka->f2a27bnyg46nyg46="1234.56";
$hlavicka->f2a27cnyg46nyg46="1234.56";
$hlavicka->f2a27dnyg46nyg46="1234.56";
$hlavicka->f2a27enyg46nyg46="1234.56";
$hlavicka->f2a27fnyg46nyg46="1234.56";
$hlavicka->f2a27gnyg46nyg46="1234.56";
$hlavicka->f2a27hnyg46nyg46="1234.56";
$hlavicka->f2a27inyg46nyg46="1234.56";
$hlavicka->f2a27jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a27b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a27c","$rmc",0,"R");
$pdf->Cell(15,6,"$hlavicka->f2a27d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f2a27e","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2a27f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a27g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a27h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a27i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a27j","$rmc",1,"R");


if( $hlavicka->f2a28b == 0 ) $hlavicka->f2a28b="";
if( $hlavicka->f2a28c == 0 ) $hlavicka->f2a28c="";
if( $hlavicka->f2a28d == 0 ) $hlavicka->f2a28d="";
if( $hlavicka->f2a28e == 0 ) $hlavicka->f2a28e="";
if( $hlavicka->f2a28f == 0 ) $hlavicka->f2a28f="";
if( $hlavicka->f2a28g == 0 ) $hlavicka->f2a28g="";
if( $hlavicka->f2a28h == 0 ) $hlavicka->f2a28h="";
if( $hlavicka->f2a28i == 0 ) $hlavicka->f2a28i="";
if( $hlavicka->f2a28j == 0 ) $hlavicka->f2a28j="";

$hlavicka->f2a28bnyg46nyg46="1234.56";
$hlavicka->f2a28cnyg46nyg46="1234.56";
$hlavicka->f2a28dnyg46nyg46="1234.56";
$hlavicka->f2a28enyg46nyg46="1234.56";
$hlavicka->f2a28fnyg46nyg46="1234.56";
$hlavicka->f2a28gnyg46nyg46="1234.56";
$hlavicka->f2a28hnyg46nyg46="1234.56";
$hlavicka->f2a28inyg46nyg46="1234.56";
$hlavicka->f2a28jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f2a28b","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a28c","$rmc",0,"R");
$pdf->Cell(15,7,"$hlavicka->f2a28d","$rmc",0,"R");$pdf->Cell(17,7,"$hlavicka->f2a28e","$rmc",0,"R");
$pdf->Cell(18,7,"$hlavicka->f2a28f","$rmc",0,"R");$pdf->Cell(12,7,"$hlavicka->f2a28g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a28h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a28i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a28j","$rmc",1,"R");


if( $f2a28pb == 0 ) $f2a28pb="";
if( $f2a28pc == 0 ) $f2a28pc="";
if( $f2a28pd == 0 ) $f2a28pd="";
if( $f2a28pe == 0 ) $f2a28pe="";
if( $f2a28pf == 0 ) $f2a28pf="";
if( $f2a28pg == 0 ) $f2a28pg="";
if( $f2a28ph == 0 ) $f2a28ph="";
if( $f2a28pi == 0 ) $f2a28pi="";
if( $f2a28pj == 0 ) $f2a28pj="";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$f2a28pb","$rmc",0,"R");$pdf->Cell(15,7,"$f2a28pc","$rmc",0,"R");
$pdf->Cell(15,7,"$f2a28pd","$rmc",0,"R");$pdf->Cell(17,7,"$f2a28pe","$rmc",0,"R");
$pdf->Cell(18,7,"$f2a28pf","$rmc",0,"R");$pdf->Cell(12,7,"$f2a28pg","$rmc",0,"R");
$pdf->Cell(13,7,"$f2a28ph","$rmc",0,"R");$pdf->Cell(15,7,"$f2a28pi","$rmc",0,"R");
$pdf->Cell(13,7,"$f2a28pj","$rmc",1,"R");


if( $hlavicka->f2a29b == 0 ) $hlavicka->f2a29b="";
if( $hlavicka->f2a29c == 0 ) $hlavicka->f2a29c="";
if( $hlavicka->f2a29d == 0 ) $hlavicka->f2a29d="";
if( $hlavicka->f2a29e == 0 ) $hlavicka->f2a29e="";
if( $hlavicka->f2a29f == 0 ) $hlavicka->f2a29f="";
if( $hlavicka->f2a29g == 0 ) $hlavicka->f2a29g="";
if( $hlavicka->f2a29h == 0 ) $hlavicka->f2a29h="";
if( $hlavicka->f2a29i == 0 ) $hlavicka->f2a29i="";
if( $hlavicka->f2a29j == 0 ) $hlavicka->f2a29j="";

$hlavicka->f2a29bnyg46nyg46="1234.56";
$hlavicka->f2a29cnyg46nyg46="1234.56";
$hlavicka->f2a29dnyg46nyg46="1234.56";
$hlavicka->f2a29enyg46nyg46="1234.56";
$hlavicka->f2a29fnyg46nyg46="1234.56";
$hlavicka->f2a29gnyg46nyg46="1234.56";
$hlavicka->f2a29hnyg46nyg46="1234.56";
$hlavicka->f2a29inyg46nyg46="1234.56";
$hlavicka->f2a29jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,12,"$hlavicka->f2a29b","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a29c","$rmc",0,"R");
$pdf->Cell(15,12,"$hlavicka->f2a29d","$rmc",0,"R");$pdf->Cell(17,12,"$hlavicka->f2a29e","$rmc",0,"R");
$pdf->Cell(18,12,"$hlavicka->f2a29f","$rmc",0,"R");$pdf->Cell(12,12,"$hlavicka->f2a29g","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a29h","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a29i","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a29j","$rmc",1,"R");


//opravne polozky
if( $hlavicka->f2a210b == 0 ) $hlavicka->f2a210b="";
if( $hlavicka->f2a210c == 0 ) $hlavicka->f2a210c="";
if( $hlavicka->f2a210d == 0 ) $hlavicka->f2a210d="";
if( $hlavicka->f2a210e == 0 ) $hlavicka->f2a210e="";
if( $hlavicka->f2a210f == 0 ) $hlavicka->f2a210f="";
if( $hlavicka->f2a210g == 0 ) $hlavicka->f2a210g="";
if( $hlavicka->f2a210h == 0 ) $hlavicka->f2a210h="";
if( $hlavicka->f2a210i == 0 ) $hlavicka->f2a210i="";
if( $hlavicka->f2a210j == 0 ) $hlavicka->f2a210j="";

$hlavicka->f2a210bnyg46nyg46="1234.56";
$hlavicka->f2a210cnyg46nyg46="1234.56";
$hlavicka->f2a210dnyg46nyg46="1234.56";
$hlavicka->f2a210enyg46nyg46="1234.56";
$hlavicka->f2a210fnyg46nyg46="1234.56";
$hlavicka->f2a210gnyg46nyg46="1234.56";
$hlavicka->f2a210hnyg46nyg46="1234.56";
$hlavicka->f2a210inyg46nyg46="1234.56";
$hlavicka->f2a210jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,16,"$hlavicka->f2a210b","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2a210c","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a210d","$rmc",0,"R");$pdf->Cell(19,16,"$hlavicka->f2a210e","$rmc",0,"R");
$pdf->Cell(18,16,"$hlavicka->f2a210f","$rmc",0,"R");$pdf->Cell(12,16,"$hlavicka->f2a210g","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a210h","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2a210i","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2a210j","$rmc",1,"R");


if( $hlavicka->f2a211b == 0 ) $hlavicka->f2a211b="";
if( $hlavicka->f2a211c == 0 ) $hlavicka->f2a211c="";
if( $hlavicka->f2a211d == 0 ) $hlavicka->f2a211d="";
if( $hlavicka->f2a211e == 0 ) $hlavicka->f2a211e="";
if( $hlavicka->f2a211f == 0 ) $hlavicka->f2a211f="";
if( $hlavicka->f2a211g == 0 ) $hlavicka->f2a211g="";
if( $hlavicka->f2a211h == 0 ) $hlavicka->f2a211h="";
if( $hlavicka->f2a211i == 0 ) $hlavicka->f2a211i="";
if( $hlavicka->f2a211j == 0 ) $hlavicka->f2a211j="";

$hlavicka->f2a211bnyg46nyg46="1234.56";
$hlavicka->f2a211cnyg46nyg46="1234.56";
$hlavicka->f2a211dnyg46nyg46="1234.56";
$hlavicka->f2a211enyg46nyg46="1234.56";
$hlavicka->f2a211fnyg46nyg46="1234.56";
$hlavicka->f2a211gnyg46nyg46="1234.56";
$hlavicka->f2a211hnyg46nyg46="1234.56";
$hlavicka->f2a211inyg46nyg46="1234.56";
$hlavicka->f2a211jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$hlavicka->f2a211b","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a211c","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a211d","$rmc",0,"R");$pdf->Cell(19,6,"$hlavicka->f2a211e","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2a211f","$rmc",0,"R");$pdf->Cell(12,6,"$hlavicka->f2a211g","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a211h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2a211i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2a211j","$rmc",1,"R");


if( $hlavicka->f2a212b == 0 ) $hlavicka->f2a212b="";
if( $hlavicka->f2a212c == 0 ) $hlavicka->f2a212c="";
if( $hlavicka->f2a212d == 0 ) $hlavicka->f2a212d="";
if( $hlavicka->f2a212e == 0 ) $hlavicka->f2a212e="";
if( $hlavicka->f2a212f == 0 ) $hlavicka->f2a212f="";
if( $hlavicka->f2a212g == 0 ) $hlavicka->f2a212g="";
if( $hlavicka->f2a212h == 0 ) $hlavicka->f2a212h="";
if( $hlavicka->f2a212i == 0 ) $hlavicka->f2a212i="";
if( $hlavicka->f2a212j == 0 ) $hlavicka->f2a212j="";

$hlavicka->f2a212bnyg46nyg46="1234.56";
$hlavicka->f2a212cnyg46nyg46="1234.56";
$hlavicka->f2a212dnyg46nyg46="1234.56";
$hlavicka->f2a212enyg46nyg46="1234.56";
$hlavicka->f2a212fnyg46nyg46="1234.56";
$hlavicka->f2a212gnyg46nyg46="1234.56";
$hlavicka->f2a212hnyg46nyg46="1234.56";
$hlavicka->f2a212inyg46nyg46="1234.56";
$hlavicka->f2a212jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,7,"$hlavicka->f2a212b","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a212c","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a212d","$rmc",0,"R");$pdf->Cell(19,7,"$hlavicka->f2a212e","$rmc",0,"R");
$pdf->Cell(18,7,"$hlavicka->f2a212f","$rmc",0,"R");$pdf->Cell(12,7,"$hlavicka->f2a212g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a212h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2a212i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2a212j","$rmc",1,"R");


if( $f2a212pb == 0 ) $f2a212pb="";
if( $f2a212pc == 0 ) $f2a212pc="";
if( $f2a212pd == 0 ) $f2a212pd="";
if( $f2a212pe == 0 ) $f2a212pe="";
if( $f2a212pf == 0 ) $f2a212pf="";
if( $f2a212pg == 0 ) $f2a212pg="";
if( $f2a212ph == 0 ) $f2a212ph="";
if( $f2a212pi == 0 ) $f2a212pi="";
if( $f2a212pj == 0 ) $f2a212pj="";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,6,"$f2a212pb","$rmc",0,"R");$pdf->Cell(15,6,"$f2a212pc","$rmc",0,"R");
$pdf->Cell(13,6,"$f2a212pd","$rmc",0,"R");$pdf->Cell(19,6,"$f2a212pe","$rmc",0,"R");
$pdf->Cell(18,6,"$f2a212pf","$rmc",0,"R");$pdf->Cell(12,6,"$f2a212pg","$rmc",0,"R");
$pdf->Cell(13,6,"$f2a212ph","$rmc",0,"R");$pdf->Cell(15,6,"$f2a212pi","$rmc",0,"R");
$pdf->Cell(13,6,"$f2a212pj","$rmc",1,"R");


if( $hlavicka->f2a213b == 0 ) $hlavicka->f2a213b="";
if( $hlavicka->f2a213c == 0 ) $hlavicka->f2a213c="";
if( $hlavicka->f2a213d == 0 ) $hlavicka->f2a213d="";
if( $hlavicka->f2a213e == 0 ) $hlavicka->f2a213e="";
if( $hlavicka->f2a213f == 0 ) $hlavicka->f2a213f="";
if( $hlavicka->f2a213g == 0 ) $hlavicka->f2a213g="";
if( $hlavicka->f2a213h == 0 ) $hlavicka->f2a213h="";
if( $hlavicka->f2a213i == 0 ) $hlavicka->f2a213i="";
if( $hlavicka->f2a213j == 0 ) $hlavicka->f2a213j="";

$hlavicka->f2a213bnyg46nyg46="1234.56";
$hlavicka->f2a213cnyg46nyg46="1234.56";
$hlavicka->f2a213dnyg46nyg46="1234.56";
$hlavicka->f2a213enyg46nyg46="1234.56";
$hlavicka->f2a213fnyg46nyg46="1234.56";
$hlavicka->f2a213gnyg46nyg46="1234.56";
$hlavicka->f2a213hnyg46nyg46="1234.56";
$hlavicka->f2a213inyg46nyg46="1234.56";
$hlavicka->f2a213jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,12,"$hlavicka->f2a213b","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a213c","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a213d","$rmc",0,"R");$pdf->Cell(19,12,"$hlavicka->f2a213e","$rmc",0,"R");
$pdf->Cell(18,12,"$hlavicka->f2a213f","$rmc",0,"R");$pdf->Cell(12,12,"$hlavicka->f2a213g","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a213h","$rmc",0,"R");$pdf->Cell(15,12,"$hlavicka->f2a213i","$rmc",0,"R");
$pdf->Cell(13,12,"$hlavicka->f2a213j","$rmc",1,"R");


//zostatok
if( $hlavicka->f2a214b == 0 ) $hlavicka->f2a214b="";
if( $hlavicka->f2a214c == 0 ) $hlavicka->f2a214c="";
if( $hlavicka->f2a214d == 0 ) $hlavicka->f2a214d="";
if( $hlavicka->f2a214e == 0 ) $hlavicka->f2a214e="";
if( $hlavicka->f2a214f == 0 ) $hlavicka->f2a214f="";
if( $hlavicka->f2a214g == 0 ) $hlavicka->f2a214g="";
if( $hlavicka->f2a214h == 0 ) $hlavicka->f2a214h="";
if( $hlavicka->f2a214i == 0 ) $hlavicka->f2a214i="";
if( $hlavicka->f2a214j == 0 ) $hlavicka->f2a214j="";

$hlavicka->f2a214bnyg46nyg46="1234.56";
$hlavicka->f2a214cnyg46nyg46="1234.56";
$hlavicka->f2a214dnyg46nyg46="1234.56";
$hlavicka->f2a214enyg46nyg46="1234.56";
$hlavicka->f2a214fnyg46nyg46="1234.56";
$hlavicka->f2a214gnyg46nyg46="1234.56";
$hlavicka->f2a214hnyg46nyg46="1234.56";
$hlavicka->f2a214inyg46nyg46="1234.56";
$hlavicka->f2a214jnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,17,"$hlavicka->f2a214b","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a214c","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a214d","$rmc",0,"R");$pdf->Cell(19,17,"$hlavicka->f2a214e","$rmc",0,"R");
$pdf->Cell(18,17,"$hlavicka->f2a214f","$rmc",0,"R");$pdf->Cell(12,17,"$hlavicka->f2a214g","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a214h","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f2a214i","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f2a214j","$rmc",1,"R");


if( $hlavicka->f2a215b == 0 ) $hlavicka->f2a215b="";
if( $hlavicka->f2a215c == 0 ) $hlavicka->f2a215c="";
if( $hlavicka->f2a215d == 0 ) $hlavicka->f2a215d="";
if( $hlavicka->f2a215e == 0 ) $hlavicka->f2a215e="";
if( $hlavicka->f2a215f == 0 ) $hlavicka->f2a215f="";
if( $hlavicka->f2a215g == 0 ) $hlavicka->f2a215g="";
if( $hlavicka->f2a215h == 0 ) $hlavicka->f2a215h="";
if( $hlavicka->f2a215i == 0 ) $hlavicka->f2a215i="";
if( $hlavicka->f2a215j == 0 ) $hlavicka->f2a215j="";

$hlavicka->f2a215bnyg46nyg46="1234.56";
$hlavicka->f2a215cnyg46nyg46="1234.56";
$hlavicka->f2a215dnyg46nyg46="1234.56";
$hlavicka->f2a215enyg46nyg46="1234.56";
$hlavicka->f2a215fnyg46nyg46="1234.56";
$hlavicka->f2a215gnyg46nyg46="1234.56";
$hlavicka->f2a215hnyg46nyg46="1234.56";
$hlavicka->f2a215inyg46nyg46="1234.56";
$hlavicka->f2a215jnyg46nyg46="1234.56";

$pdf->Cell(41,5,"     ","$rmc1",0,"L");
$pdf->Cell(18,13,"$hlavicka->f2a215b","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f2a215c","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f2a215d","$rmc",0,"R");$pdf->Cell(19,13,"$hlavicka->f2a215e","$rmc",0,"R");
$pdf->Cell(18,13,"$hlavicka->f2a215f","$rmc",0,"R");$pdf->Cell(12,13,"$hlavicka->f2a215g","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f2a215h","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f2a215i","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f2a215j","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text6"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(269);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                       } //koniec strana 9

$f2c1=$hlavicka->f2c1;
$f2c2=$hlavicka->f2c2;

if( $f2c1 == 0 ) $f2c1="";
if( $f2c2 == 0 ) $f2c2="";

}
$i = $i + 1;

  }


$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011".$no."s2 WHERE psys >= 0 ".""; 

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


if ( $nopg10 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab6.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab6.jpg',1,26,210,18);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_1.jpg',1,67,210,130);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_1b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_1b.jpg',1,197,210,70);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"6. Informácie k èasti F písm. c) prílohy è.3 o dlhodobom hmotnom majetku","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',9);
//6. info k casti F pism. c o dlhodobom HM
$pdf->SetFont('arial','',9);

$hlavicka->f2c1nyg46nyg46="1234.56";
$hlavicka->f2c2nyg46nyg46="1234.56";

$pdf->Cell(123,5,"     ","$rmc",0,"L");$pdf->Cell(54,7,"$f2c1","$rmc",1,"R");




$pdf->Cell(90,16,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"7. Informácie k èasti F písm. j) prílohy è.3 o dlhodobom finanènom majetku","$rmc",1,"L");
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 1","$rmc",1,"L");
$pdf->Cell(90,52,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',5);

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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,18,"$hlavicka->f1j1b","$rmc",0,"R");$pdf->Cell(19,18,"$hlavicka->f1j1c","$rmc",0,"R");
$pdf->Cell(19,18,"$hlavicka->f1j1d","$rmc",0,"R");$pdf->Cell(15,18,"$hlavicka->f1j1e","$rmc",0,"R");
$pdf->Cell(13,18,"$hlavicka->f1j1f","$rmc",0,"R");$pdf->Cell(14,18,"$hlavicka->f1j1g","$rmc",0,"R");
$pdf->Cell(13,18,"$hlavicka->f1j1h","$rmc",0,"R");$pdf->Cell(15,18,"$hlavicka->f1j1i","$rmc",0,"R");
$pdf->Cell(13,18,"$hlavicka->f1j1j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,8,"$hlavicka->f1j2b","$rmc",0,"R");$pdf->Cell(19,8,"$hlavicka->f1j2c","$rmc",0,"R");
$pdf->Cell(19,8,"$hlavicka->f1j2d","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1j2e","$rmc",0,"R");
$pdf->Cell(13,8,"$hlavicka->f1j2f","$rmc",0,"R");$pdf->Cell(14,8,"$hlavicka->f1j2g","$rmc",0,"R");
$pdf->Cell(13,8,"$hlavicka->f1j2h","$rmc",0,"R");$pdf->Cell(15,8,"$hlavicka->f1j2i","$rmc",0,"R");
$pdf->Cell(13,8,"$hlavicka->f1j2j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,7,"$hlavicka->f1j3b","$rmc",0,"R");$pdf->Cell(19,7,"$hlavicka->f1j3c","$rmc",0,"R");
$pdf->Cell(19,7,"$hlavicka->f1j3d","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j3e","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j3f","$rmc",0,"R");$pdf->Cell(14,7,"$hlavicka->f1j3g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j3h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j3i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j3j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,7,"$hlavicka->f1j4b","$rmc",0,"R");$pdf->Cell(19,7,"$hlavicka->f1j4c","$rmc",0,"R");
$pdf->Cell(19,7,"$hlavicka->f1j4d","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j4e","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j4f","$rmc",0,"R");$pdf->Cell(14,7,"$hlavicka->f1j4g","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j4h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j4i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j4j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,14,"$hlavicka->f1j5b","$rmc",0,"R");$pdf->Cell(19,14,"$hlavicka->f1j5c","$rmc",0,"R");
$pdf->Cell(19,14,"$hlavicka->f1j5d","$rmc",0,"R");$pdf->Cell(15,14,"$hlavicka->f1j5e","$rmc",0,"R");
$pdf->Cell(13,14,"$hlavicka->f1j5f","$rmc",0,"R");$pdf->Cell(14,14,"$hlavicka->f1j5g","$rmc",0,"R");
$pdf->Cell(13,14,"$hlavicka->f1j5h","$rmc",0,"R");$pdf->Cell(15,14,"$hlavicka->f1j5i","$rmc",0,"R");
$pdf->Cell(13,14,"$hlavicka->f1j5j","$rmc",1,"R");


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

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,18,"$hlavicka->f1j6b","$rmc",0,"R");$pdf->Cell(20,18,"$hlavicka->f1j6c","$rmc",0,"R");
$pdf->Cell(18,18,"$hlavicka->f1j6d","$rmc",0,"R");$pdf->Cell(15,18,"$hlavicka->f1j6e","$rmc",0,"R");
$pdf->Cell(13,18,"$hlavicka->f1j6f","$rmc",0,"R");$pdf->Cell(15,18,"$hlavicka->f1j6g","$rmc",0,"R");
$pdf->Cell(11,18,"$hlavicka->f1j6h","$rmc",0,"R");$pdf->Cell(16,18,"$hlavicka->f1j6i","$rmc",0,"R");
$pdf->Cell(12,18,"$hlavicka->f1j6j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,7,"$hlavicka->f1j7b","$rmc",0,"R");$pdf->Cell(20,7,"$hlavicka->f1j7c","$rmc",0,"R");
$pdf->Cell(18,7,"$hlavicka->f1j7d","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j7e","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j7f","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j7g","$rmc",0,"R");
$pdf->Cell(11,7,"$hlavicka->f1j7h","$rmc",0,"R");$pdf->Cell(16,7,"$hlavicka->f1j7i","$rmc",0,"R");
$pdf->Cell(12,7,"$hlavicka->f1j7j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,7,"$hlavicka->f1j8b","$rmc",0,"R");$pdf->Cell(20,7,"$hlavicka->f1j8c","$rmc",0,"R");
$pdf->Cell(18,7,"$hlavicka->f1j8d","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j8e","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f1j8f","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f1j8g","$rmc",0,"R");
$pdf->Cell(11,7,"$hlavicka->f1j8h","$rmc",0,"R");$pdf->Cell(16,7,"$hlavicka->f1j8i","$rmc",0,"R");
$pdf->Cell(12,7,"$hlavicka->f1j8j","$rmc",1,"R");


if( $f1j8pb == 0 ) $f1j8pb="";
if( $f1j8pc == 0 ) $f1j8pc="";
if( $f1j8pd == 0 ) $f1j8pd="";
if( $f1j8pe == 0 ) $f1j8pe="";
if( $f1j8pf == 0 ) $f1j8pf="";
if( $f1j8pg == 0 ) $f1j8pg="";
if( $f1j8ph == 0 ) $f1j8ph="";
if( $f1j8pi == 0 ) $f1j8pi="";
if( $f1j8pj == 0 ) $f1j8pj="";

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,7,"$f1j8pb","$rmc",0,"R");$pdf->Cell(20,7,"$f1j8pc","$rmc",0,"R");
$pdf->Cell(18,7,"$f1j8pd","$rmc",0,"R");$pdf->Cell(15,7,"$f1j8pe","$rmc",0,"R");
$pdf->Cell(13,7,"$f1j8pf","$rmc",0,"R");$pdf->Cell(15,7,"$f1j8pg","$rmc",0,"R");
$pdf->Cell(11,7,"$f1j8ph","$rmc",0,"R");$pdf->Cell(16,7,"$f1j8pi","$rmc",0,"R");
$pdf->Cell(12,7,"$f1j8pj","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,13,"$hlavicka->f1j9b","$rmc",0,"R");$pdf->Cell(20,13,"$hlavicka->f1j9c","$rmc",0,"R");
$pdf->Cell(18,13,"$hlavicka->f1j9d","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f1j9e","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f1j9f","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f1j9g","$rmc",0,"R");
$pdf->Cell(11,13,"$hlavicka->f1j9h","$rmc",0,"R");$pdf->Cell(16,13,"$hlavicka->f1j9i","$rmc",0,"R");
$pdf->Cell(12,13,"$hlavicka->f1j9j","$rmc",1,"R");


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

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,17,"$hlavicka->f1j10b","$rmc",0,"R");$pdf->Cell(20,17,"$hlavicka->f1j10c","$rmc",0,"R");
$pdf->Cell(16,17,"$hlavicka->f1j10d","$rmc",0,"R");$pdf->Cell(17,17,"$hlavicka->f1j10e","$rmc",0,"R");
$pdf->Cell(13,17,"$hlavicka->f1j10f","$rmc",0,"R");$pdf->Cell(15,17,"$hlavicka->f1j10g","$rmc",0,"R");
$pdf->Cell(11,17,"$hlavicka->f1j10h","$rmc",0,"R");$pdf->Cell(16,17,"$hlavicka->f1j10i","$rmc",0,"R");
$pdf->Cell(12,17,"$hlavicka->f1j10j","$rmc",1,"R");


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

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,13,"$hlavicka->f1j11b","$rmc",0,"R");$pdf->Cell(20,13,"$hlavicka->f1j11c","$rmc",0,"R");
$pdf->Cell(16,13,"$hlavicka->f1j11d","$rmc",0,"R");$pdf->Cell(17,13,"$hlavicka->f1j11e","$rmc",0,"R");
$pdf->Cell(13,13,"$hlavicka->f1j11f","$rmc",0,"R");$pdf->Cell(15,13,"$hlavicka->f1j11g","$rmc",0,"R");
$pdf->Cell(11,13,"$hlavicka->f1j11h","$rmc",0,"R");$pdf->Cell(16,13,"$hlavicka->f1j11i","$rmc",0,"R");
$pdf->Cell(12,13,"$hlavicka->f1j11j","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text7"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(43);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text8"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(270);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 10

if ( $nopg11 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_2.jpg',1,25,210,150);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_2b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab7_2b.jpg',1.2,175,209.8,35);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab8.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab8.jpg',1,253,210,18);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 2","$rmc",1,"L");
$pdf->Cell(90,48,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',5);


//7.info k casti F pism. o dlhodobom financnom majetku a tabulka 1. minuly rok
//prvotne ocenenie
if( $hlavicka->f2j1b == 0 ) $hlavicka->f2j1b="";
if( $hlavicka->f2j1c == 0 ) $hlavicka->f2j1c="";
if( $hlavicka->f2j1d == 0 ) $hlavicka->f2j1d="";
if( $hlavicka->f2j1e == 0 ) $hlavicka->f2j1e="";
if( $hlavicka->f2j1f == 0 ) $hlavicka->f2j1f="";
if( $hlavicka->f2j1g == 0 ) $hlavicka->f2j1g="";
if( $hlavicka->f2j1h == 0 ) $hlavicka->f2j1h="";
if( $hlavicka->f2j1i == 0 ) $hlavicka->f2j1i="";
if( $hlavicka->f2j1j == 0 ) $hlavicka->f2j1j="";

$hlavicka->f2j1bnyg46nyg46="1234.56";
$hlavicka->f2j1cnyg46nyg46="1234.56";
$hlavicka->f2j1dnyg46nyg46="1234.56";
$hlavicka->f2j1enyg46nyg46="1234.56";
$hlavicka->f2j1fnyg46nyg46="1234.56";
$hlavicka->f2j1gnyg46nyg46="1234.56";
$hlavicka->f2j1hnyg46nyg46="1234.56";
$hlavicka->f2j1inyg46nyg46="1234.56";
$hlavicka->f2j1jnyg46nyg46="1234.56";

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,16,"$hlavicka->f2j1b","$rmc",0,"R");$pdf->Cell(19,16,"$hlavicka->f2j1c","$rmc",0,"R");
$pdf->Cell(19,16,"$hlavicka->f2j1d","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2j1e","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2j1f","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2j1g","$rmc",0,"R");
$pdf->Cell(12,16,"$hlavicka->f2j1h","$rmc",0,"R");$pdf->Cell(15,16,"$hlavicka->f2j1i","$rmc",0,"R");
$pdf->Cell(13,16,"$hlavicka->f2j1j","$rmc",1,"R");


if( $hlavicka->f2j2b == 0 ) $hlavicka->f2j2b="";
if( $hlavicka->f2j2c == 0 ) $hlavicka->f2j2c="";
if( $hlavicka->f2j2d == 0 ) $hlavicka->f2j2d="";
if( $hlavicka->f2j2e == 0 ) $hlavicka->f2j2e="";
if( $hlavicka->f2j2f == 0 ) $hlavicka->f2j2f="";
if( $hlavicka->f2j2g == 0 ) $hlavicka->f2j2g="";
if( $hlavicka->f2j2h == 0 ) $hlavicka->f2j2h="";
if( $hlavicka->f2j2i == 0 ) $hlavicka->f2j2i="";
if( $hlavicka->f2j2j == 0 ) $hlavicka->f2j2j="";

$hlavicka->f2j2bnyg46nyg46="1234.56";
$hlavicka->f2j2cnyg46nyg46="1234.56";
$hlavicka->f2j2dnyg46nyg46="1234.56";
$hlavicka->f2j2enyg46nyg46="1234.56";
$hlavicka->f2j2fnyg46nyg46="1234.56";
$hlavicka->f2j2gnyg46nyg46="1234.56";
$hlavicka->f2j2hnyg46nyg46="1234.56";
$hlavicka->f2j2inyg46nyg46="1234.56";
$hlavicka->f2j2jnyg46nyg46="1234.56";

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,7,"$hlavicka->f2j2b","$rmc",0,"R");$pdf->Cell(19,7,"$hlavicka->f2j2c","$rmc",0,"R");
$pdf->Cell(19,7,"$hlavicka->f2j2d","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2j2e","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2j2f","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2j2g","$rmc",0,"R");
$pdf->Cell(12,7,"$hlavicka->f2j2h","$rmc",0,"R");$pdf->Cell(15,7,"$hlavicka->f2j2i","$rmc",0,"R");
$pdf->Cell(13,7,"$hlavicka->f2j2j","$rmc",1,"R");


if( $hlavicka->f2j3b == 0 ) $hlavicka->f2j3b="";
if( $hlavicka->f2j3c == 0 ) $hlavicka->f2j3c="";
if( $hlavicka->f2j3d == 0 ) $hlavicka->f2j3d="";
if( $hlavicka->f2j3e == 0 ) $hlavicka->f2j3e="";
if( $hlavicka->f2j3f == 0 ) $hlavicka->f2j3f="";
if( $hlavicka->f2j3g == 0 ) $hlavicka->f2j3g="";
if( $hlavicka->f2j3h == 0 ) $hlavicka->f2j3h="";
if( $hlavicka->f2j3i == 0 ) $hlavicka->f2j3i="";
if( $hlavicka->f2j3j == 0 ) $hlavicka->f2j3j="";

$hlavicka->f2j3bnyg46nyg46="1234.56";
$hlavicka->f2j3cnyg46nyg46="1234.56";
$hlavicka->f2j3dnyg46nyg46="1234.56";
$hlavicka->f2j3enyg46nyg46="1234.56";
$hlavicka->f2j3fnyg46nyg46="1234.56";
$hlavicka->f2j3gnyg46nyg46="1234.56";
$hlavicka->f2j3hnyg46nyg46="1234.56";
$hlavicka->f2j3inyg46nyg46="1234.56";
$hlavicka->f2j3jnyg46nyg46="1234.56";

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j3b","$rmc",0,"R");$pdf->Cell(19,6,"$hlavicka->f2j3c","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2j3d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j3e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j3f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j3g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j3h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j3i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j3j","$rmc",1,"R");


if( $hlavicka->f2j4b == 0 ) $hlavicka->f2j4b="";
if( $hlavicka->f2j4c == 0 ) $hlavicka->f2j4c="";
if( $hlavicka->f2j4d == 0 ) $hlavicka->f2j4d="";
if( $hlavicka->f2j4e == 0 ) $hlavicka->f2j4e="";
if( $hlavicka->f2j4f == 0 ) $hlavicka->f2j4f="";
if( $hlavicka->f2j4g == 0 ) $hlavicka->f2j4g="";
if( $hlavicka->f2j4h == 0 ) $hlavicka->f2j4h="";
if( $hlavicka->f2j4i == 0 ) $hlavicka->f2j4i="";
if( $hlavicka->f2j4j == 0 ) $hlavicka->f2j4j="";

$hlavicka->f2j4bnyg46nyg46="1234.56";
$hlavicka->f2j4cnyg46nyg46="1234.56";
$hlavicka->f2j4dnyg46nyg46="1234.56";
$hlavicka->f2j4enyg46nyg46="1234.56";
$hlavicka->f2j4fnyg46nyg46="1234.56";
$hlavicka->f2j4gnyg46nyg46="1234.56";
$hlavicka->f2j4hnyg46nyg46="1234.56";
$hlavicka->f2j4inyg46nyg46="1234.56";
$hlavicka->f2j4jnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j4b","$rmc",0,"R");$pdf->Cell(19,6,"$hlavicka->f2j4c","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2j4d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j4e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j4f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j4g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j4h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j4i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j4j","$rmc",1,"R");


if( $hlavicka->f2j5b == 0 ) $hlavicka->f2j5b="";
if( $hlavicka->f2j5c == 0 ) $hlavicka->f2j5c="";
if( $hlavicka->f2j5d == 0 ) $hlavicka->f2j5d="";
if( $hlavicka->f2j5e == 0 ) $hlavicka->f2j5e="";
if( $hlavicka->f2j5f == 0 ) $hlavicka->f2j5f="";
if( $hlavicka->f2j5g == 0 ) $hlavicka->f2j5g="";
if( $hlavicka->f2j5h == 0 ) $hlavicka->f2j5h="";
if( $hlavicka->f2j5i == 0 ) $hlavicka->f2j5i="";
if( $hlavicka->f2j5j == 0 ) $hlavicka->f2j5j="";

$hlavicka->f2j5bnyg46nyg46="1234.56";
$hlavicka->f2j5cnyg46nyg46="1234.56";
$hlavicka->f2j5dnyg46nyg46="1234.56";
$hlavicka->f2j5enyg46nyg46="1234.56";
$hlavicka->f2j5fnyg46nyg46="1234.56";
$hlavicka->f2j5gnyg46nyg46="1234.56";
$hlavicka->f2j5hnyg46nyg46="1234.56";
$hlavicka->f2j5inyg46nyg46="1234.56";
$hlavicka->f2j5jnyg46nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j5b","$rmc",0,"R");$pdf->Cell(19,6,"$hlavicka->f2j5c","$rmc",0,"R");
$pdf->Cell(19,6,"$hlavicka->f2j5d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j5e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j5f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j5g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j5h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j5i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j5j","$rmc",1,"R");


//opravne polozky
if( $hlavicka->f2j6b == 0 ) $hlavicka->f2j6b="";
if( $hlavicka->f2j6c == 0 ) $hlavicka->f2j6c="";
if( $hlavicka->f2j6d == 0 ) $hlavicka->f2j6d="";
if( $hlavicka->f2j6e == 0 ) $hlavicka->f2j6e="";
if( $hlavicka->f2j6f == 0 ) $hlavicka->f2j6f="";
if( $hlavicka->f2j6g == 0 ) $hlavicka->f2j6g="";
if( $hlavicka->f2j6h == 0 ) $hlavicka->f2j6h="";
if( $hlavicka->f2j6i == 0 ) $hlavicka->f2j6i="";
if( $hlavicka->f2j6j == 0 ) $hlavicka->f2j6j="";

$hlavicka->f2j6bnyg46nyg46="1234.56";
$hlavicka->f2j6cnyg46nyg46="1234.56";
$hlavicka->f2j6dnyg46nyg46="1234.56";
$hlavicka->f2j6enyg46nyg46="1234.56";
$hlavicka->f2j6fnyg46nyg46="1234.56";
$hlavicka->f2j6gnyg46nyg46="1234.56";
$hlavicka->f2j6hnyg46nyg46="1234.56";
$hlavicka->f2j6inyg46nyg46="1234.56";
$hlavicka->f2j6jnyg46nyg46="1234.56";

$pdf->Cell(90,15,"     ","$rmc1",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j6b","$rmc",0,"R");$pdf->Cell(20,6,"$hlavicka->f2j6c","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2j6d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j6e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j6f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j6g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j6h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j6i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j6j","$rmc",1,"R");


if( $hlavicka->f2j7b == 0 ) $hlavicka->f2j7b="";
if( $hlavicka->f2j7c == 0 ) $hlavicka->f2j7c="";
if( $hlavicka->f2j7d == 0 ) $hlavicka->f2j7d="";
if( $hlavicka->f2j7e == 0 ) $hlavicka->f2j7e="";
if( $hlavicka->f2j7f == 0 ) $hlavicka->f2j7f="";
if( $hlavicka->f2j7g == 0 ) $hlavicka->f2j7g="";
if( $hlavicka->f2j7h == 0 ) $hlavicka->f2j7h="";
if( $hlavicka->f2j7i == 0 ) $hlavicka->f2j7i="";
if( $hlavicka->f2j7j == 0 ) $hlavicka->f2j7j="";

$hlavicka->f2j7bnyg46nyg46="1234.56";
$hlavicka->f2j7cnyg46nyg46="1234.56";
$hlavicka->f2j7dnyg46nyg46="1234.56";
$hlavicka->f2j7enyg46nyg46="1234.56";
$hlavicka->f2j7fnyg46nyg46="1234.56";
$hlavicka->f2j7gnyg46nyg46="1234.56";
$hlavicka->f2j7hnyg46nyg46="1234.56";
$hlavicka->f2j7inyg46nyg46="1234.56";
$hlavicka->f2j7jnyg46nyg46="1234.56";

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j7b","$rmc",0,"R");$pdf->Cell(20,6,"$hlavicka->f2j7c","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2j7d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j7e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j7f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j7g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j7h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j7i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j7j","$rmc",1,"R");


if( $hlavicka->f2j8b == 0 ) $hlavicka->f2j8b="";
if( $hlavicka->f2j8c == 0 ) $hlavicka->f2j8c="";
if( $hlavicka->f2j8d == 0 ) $hlavicka->f2j8d="";
if( $hlavicka->f2j8e == 0 ) $hlavicka->f2j8e="";
if( $hlavicka->f2j8f == 0 ) $hlavicka->f2j8f="";
if( $hlavicka->f2j8g == 0 ) $hlavicka->f2j8g="";
if( $hlavicka->f2j8h == 0 ) $hlavicka->f2j8h="";
if( $hlavicka->f2j8i == 0 ) $hlavicka->f2j8i="";
if( $hlavicka->f2j8j == 0 ) $hlavicka->f2j8j="";

$hlavicka->f2j8bnyg46nyg46="1234.56";
$hlavicka->f2j8cnyg46nyg46="1234.56";
$hlavicka->f2j8dnyg46nyg46="1234.56";
$hlavicka->f2j8enyg46nyg46="1234.56";
$hlavicka->f2j8fnyg46nyg46="1234.56";
$hlavicka->f2j8gnyg46nyg46="1234.56";
$hlavicka->f2j8hnyg46nyg46="1234.56";
$hlavicka->f2j8inyg46nyg46="1234.56";
$hlavicka->f2j8jnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j8b","$rmc",0,"R");$pdf->Cell(20,6,"$hlavicka->f2j8c","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2j8d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j8e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j8f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j8g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j8h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j8i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j8j","$rmc",1,"R");


if( $f2j8pb == 0 ) $f2j8pb="";
if( $f2j8pc == 0 ) $f2j8pc="";
if( $f2j8pd == 0 ) $f2j8pd="";
if( $f2j8pe == 0 ) $f2j8pe="";
if( $f2j8pf == 0 ) $f2j8pf="";
if( $f2j8pg == 0 ) $f2j8pg="";
if( $f2j8ph == 0 ) $f2j8ph="";
if( $f2j8pi == 0 ) $f2j8pi="";
if( $f2j8pj == 0 ) $f2j8pj="";

$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$f2j8pb","$rmc",0,"R");$pdf->Cell(20,6,"$f2j8pc","$rmc",0,"R");
$pdf->Cell(18,6,"$f2j8pd","$rmc",0,"R");$pdf->Cell(15,6,"$f2j8pe","$rmc",0,"R");
$pdf->Cell(13,6,"$f2j8pf","$rmc",0,"R");$pdf->Cell(15,6,"$f2j8pg","$rmc",0,"R");
$pdf->Cell(12,6,"$f2j8ph","$rmc",0,"R");$pdf->Cell(15,6,"$f2j8pi","$rmc",0,"R");
$pdf->Cell(13,6,"$f2j8pj","$rmc",1,"R");


if( $hlavicka->f2j9b == 0 ) $hlavicka->f2j9b="";
if( $hlavicka->f2j9c == 0 ) $hlavicka->f2j9c="";
if( $hlavicka->f2j9d == 0 ) $hlavicka->f2j9d="";
if( $hlavicka->f2j9e == 0 ) $hlavicka->f2j9e="";
if( $hlavicka->f2j9f == 0 ) $hlavicka->f2j9f="";
if( $hlavicka->f2j9g == 0 ) $hlavicka->f2j9g="";
if( $hlavicka->f2j9h == 0 ) $hlavicka->f2j9h="";
if( $hlavicka->f2j9i == 0 ) $hlavicka->f2j9i="";
if( $hlavicka->f2j9j == 0 ) $hlavicka->f2j9j="";

$hlavicka->f2j9bnyg46nyg46="1234.56";
$hlavicka->f2j9cnyg46nyg46="1234.56";
$hlavicka->f2j9dnyg46nyg46="1234.56";
$hlavicka->f2j9enyg46nyg46="1234.56";
$hlavicka->f2j9fnyg46nyg46="1234.56";
$hlavicka->f2j9gnyg46nyg46="1234.56";
$hlavicka->f2j9hnyg46nyg46="1234.56";
$hlavicka->f2j9inyg46nyg46="1234.56";
$hlavicka->f2j9jnyg46nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j9b","$rmc",0,"R");$pdf->Cell(20,6,"$hlavicka->f2j9c","$rmc",0,"R");
$pdf->Cell(18,6,"$hlavicka->f2j9d","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j9e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j9f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j9g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j9h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j9i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j9j","$rmc",1,"R");


//uctovna hodnota
if( $hlavicka->f2j10b == 0 ) $hlavicka->f2j10b="";
if( $hlavicka->f2j10c == 0 ) $hlavicka->f2j10c="";
if( $hlavicka->f2j10d == 0 ) $hlavicka->f2j10d="";
if( $hlavicka->f2j10e == 0 ) $hlavicka->f2j10e="";
if( $hlavicka->f2j10f == 0 ) $hlavicka->f2j10f="";
if( $hlavicka->f2j10g == 0 ) $hlavicka->f2j10g="";
if( $hlavicka->f2j10h == 0 ) $hlavicka->f2j10h="";
if( $hlavicka->f2j10i == 0 ) $hlavicka->f2j10i="";
if( $hlavicka->f2j10j == 0 ) $hlavicka->f2j10j="";

$hlavicka->f2j10bnyg46nyg46="1234.56";
$hlavicka->f2j10cnyg46nyg46="1234.56";
$hlavicka->f2j10dnyg46nyg46="1234.56";
$hlavicka->f2j10enyg46nyg46="1234.56";
$hlavicka->f2j10fnyg46nyg46="1234.56";
$hlavicka->f2j10gnyg46nyg46="1234.56";
$hlavicka->f2j10hnyg46nyg46="1234.56";
$hlavicka->f2j10inyg46nyg46="1234.56";
$hlavicka->f2j10jnyg46nyg46="1234.56";

$pdf->Cell(90,16,"     ","$rmc1",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j10b","$rmc",0,"R");$pdf->Cell(20,6,"$hlavicka->f2j10c","$rmc",0,"R");
$pdf->Cell(16,6,"$hlavicka->f2j10d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f2j10e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j10f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j10g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j10h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j10i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j10j","$rmc",1,"R");


if( $hlavicka->f2j11b == 0 ) $hlavicka->f2j11b="";
if( $hlavicka->f2j11c == 0 ) $hlavicka->f2j11c="";
if( $hlavicka->f2j11d == 0 ) $hlavicka->f2j11d="";
if( $hlavicka->f2j11e == 0 ) $hlavicka->f2j11e="";
if( $hlavicka->f2j11f == 0 ) $hlavicka->f2j11f="";
if( $hlavicka->f2j11g == 0 ) $hlavicka->f2j11g="";
if( $hlavicka->f2j11h == 0 ) $hlavicka->f2j11h="";
if( $hlavicka->f2j11i == 0 ) $hlavicka->f2j11i="";
if( $hlavicka->f2j11j == 0 ) $hlavicka->f2j11j="";

$hlavicka->f2j11bnyg46nyg46="1234.56";
$hlavicka->f2j11cnyg46nyg46="1234.56";
$hlavicka->f2j11dnyg46nyg46="1234.56";
$hlavicka->f2j11enyg46nyg46="1234.56";
$hlavicka->f2j11fnyg46nyg46="1234.56";
$hlavicka->f2j11gnyg46nyg46="1234.56";
$hlavicka->f2j11hnyg46nyg46="1234.56";
$hlavicka->f2j11inyg46nyg46="1234.56";
$hlavicka->f2j11jnyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(38,5,"     ","$rmc1",0,"L");
$pdf->Cell(19,6,"$hlavicka->f2j11b","$rmc",0,"R");$pdf->Cell(20,6,"$hlavicka->f2j11c","$rmc",0,"R");
$pdf->Cell(16,6,"$hlavicka->f2j11d","$rmc",0,"R");$pdf->Cell(17,6,"$hlavicka->f2j11e","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j11f","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j11g","$rmc",0,"R");
$pdf->Cell(12,6,"$hlavicka->f2j11h","$rmc",0,"R");$pdf->Cell(15,6,"$hlavicka->f2j11i","$rmc",0,"R");
$pdf->Cell(13,6,"$hlavicka->f2j11j","$rmc",1,"R");


//8. info k casti F pism. c o dlhodobom fin.majetku
$pdf->SetFont('arial','',9);

$pdf->Cell(90,40,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(14,4," ","$rmc",0,"L");$pdf->Cell(0,4,"8. Informácie k èasti F písm. m) prílohy è.3 o dlhodobom finanènom majetku","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

if( $hlavicka->fm1 == 0 ) $hlavicka->fm1="";
if( $hlavicka->fm2 == 0 ) $hlavicka->fm2="";


$hlavicka->fm1nyg46nyg46="1234.56";
$hlavicka->fm2nyg46nyg46="1234.56";

$pdf->SetFont('arial','',9);
$pdf->Cell(126,5,"     ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->fm1","$rmc",1,"R");


$ozntext="F_text9"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(210);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text10"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(271);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 11

if ( $nopg12 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab9.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab9.jpg',1,23,210,147);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"9. Informácie k èasti F písm. i) prílohy è.3 o štruktúre dlhodobého finanèného majetku","$rmc",1,"L");
$pdf->Cell(90,43,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',7);
//9.info k casti F pism. i o strukture dlhodobeho financ.majetku 
//dcerske uct jednotky
if( $hlavicka->f1i1b == 0 ) $hlavicka->f1i1b="";
if( $hlavicka->f1i1c == 0 ) $hlavicka->f1i1c="";
if( $hlavicka->f1i1d == 0 ) $hlavicka->f1i1d="";
if( $hlavicka->f1i1e == 0 ) $hlavicka->f1i1e="";
if( $hlavicka->f1i1f == 0 ) $hlavicka->f1i1f="";

$hlavicka->f1i1anyg46nyg46="1234.56";
$hlavicka->f1i1bnyg46nyg46="1234.56";
$hlavicka->f1i1cnyg46nyg46="1234.56";
$hlavicka->f1i1dnyg46nyg46="1234.56";
$hlavicka->f1i1enyg46nyg46="1234.56";
$hlavicka->f1i1fnyg46nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f1i1a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1i1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1i1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1i1d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1i1e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1i1f","$rmc",1,"R");

if( $hlavicka->f1i2b == 0 ) $hlavicka->f1i2b="";
if( $hlavicka->f1i2c == 0 ) $hlavicka->f1i2c="";
if( $hlavicka->f1i2d == 0 ) $hlavicka->f1i2d="";
if( $hlavicka->f1i2e == 0 ) $hlavicka->f1i2e="";
if( $hlavicka->f1i2f == 0 ) $hlavicka->f1i2f="";

$hlavicka->f1i2anyg46nyg46="1234.56";
$hlavicka->f1i2bnyg46nyg46="1234.56";
$hlavicka->f1i2cnyg46nyg46="1234.56";
$hlavicka->f1i2dnyg46nyg46="1234.56";
$hlavicka->f1i2enyg46nyg46="1234.56";
$hlavicka->f1i2fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f1i2a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1i2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1i2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1i2d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1i2e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1i2f","$rmc",1,"R");

if( $hlavicka->f1i3b == 0 ) $hlavicka->f1i3b="";
if( $hlavicka->f1i3c == 0 ) $hlavicka->f1i3c="";
if( $hlavicka->f1i3d == 0 ) $hlavicka->f1i3d="";
if( $hlavicka->f1i3e == 0 ) $hlavicka->f1i3e="";
if( $hlavicka->f1i3f == 0 ) $hlavicka->f1i3f="";

$hlavicka->f1i3anyg46nyg46="1234.56";
$hlavicka->f1i3bnyg46nyg46="1234.56";
$hlavicka->f1i3cnyg46nyg46="1234.56";
$hlavicka->f1i3dnyg46nyg46="1234.56";
$hlavicka->f1i3enyg46nyg46="1234.56";
$hlavicka->f1i3fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f1i3a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1i3b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1i3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1i3d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1i3e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1i3f","$rmc",1,"R");


//uct jdn s podstatnym vplyvom
if( $hlavicka->f2i1b == 0 ) $hlavicka->f2i1b="";
if( $hlavicka->f2i1c == 0 ) $hlavicka->f2i1c="";
if( $hlavicka->f2i1d == 0 ) $hlavicka->f2i1d="";
if( $hlavicka->f2i1e == 0 ) $hlavicka->f2i1e="";
if( $hlavicka->f2i1f == 0 ) $hlavicka->f2i1f="";

$hlavicka->f2i1anyg46nyg46="1234.56";
$hlavicka->f2i1bnyg46nyg46="1234.56";
$hlavicka->f2i1cnyg46nyg46="1234.56";
$hlavicka->f2i1dnyg46nyg46="1234.56";
$hlavicka->f2i1enyg46nyg46="1234.56";
$hlavicka->f2i1fnyg46nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f2i1a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2i1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2i1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2i1d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2i1e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2i1f","$rmc",1,"R");

if( $hlavicka->f2i2b == 0 ) $hlavicka->f2i2b="";
if( $hlavicka->f2i2c == 0 ) $hlavicka->f2i2c="";
if( $hlavicka->f2i2d == 0 ) $hlavicka->f2i2d="";
if( $hlavicka->f2i2e == 0 ) $hlavicka->f2i2e="";
if( $hlavicka->f2i2f == 0 ) $hlavicka->f2i2f="";

$hlavicka->f2i2anyg46nyg46="1234.56";
$hlavicka->f2i2bnyg46nyg46="1234.56";
$hlavicka->f2i2cnyg46nyg46="1234.56";
$hlavicka->f2i2dnyg46nyg46="1234.56";
$hlavicka->f2i2enyg46nyg46="1234.56";
$hlavicka->f2i2fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f2i2a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2i2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2i2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2i2d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2i2e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2i2f","$rmc",1,"R");

if( $hlavicka->f2i3b == 0 ) $hlavicka->f2i3b="";
if( $hlavicka->f2i3c == 0 ) $hlavicka->f2i3c="";
if( $hlavicka->f2i3d == 0 ) $hlavicka->f2i3d="";
if( $hlavicka->f2i3e == 0 ) $hlavicka->f2i3e="";
if( $hlavicka->f2i3f == 0 ) $hlavicka->f2i3f="";

$hlavicka->f2i3anyg46nyg46="1234.56";
$hlavicka->f2i3bnyg46nyg46="1234.56";
$hlavicka->f2i3cnyg46nyg46="1234.56";
$hlavicka->f2i3dnyg46nyg46="1234.56";
$hlavicka->f2i3enyg46nyg46="1234.56";
$hlavicka->f2i3fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f2i3a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2i3b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2i3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2i3d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2i3e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2i3f","$rmc",1,"R");

//ostatne CP
if( $hlavicka->f3i1b == 0 ) $hlavicka->f3i1b="";
if( $hlavicka->f3i1c == 0 ) $hlavicka->f3i1c="";
if( $hlavicka->f3i1d == 0 ) $hlavicka->f3i1d="";
if( $hlavicka->f3i1e == 0 ) $hlavicka->f3i1e="";
if( $hlavicka->f3i1f == 0 ) $hlavicka->f3i1f="";

$hlavicka->f3i1anyg46nyg46="1234.56";
$hlavicka->f3i1bnyg46nyg46="1234.56";
$hlavicka->f3i1cnyg46nyg46="1234.56";
$hlavicka->f3i1dnyg46nyg46="1234.56";
$hlavicka->f3i1enyg46nyg46="1234.56";
$hlavicka->f3i1fnyg46nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f3i1a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f3i1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f3i1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f3i1d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f3i1e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f3i1f","$rmc",1,"R");

if( $hlavicka->f3i2b == 0 ) $hlavicka->f3i2b="";
if( $hlavicka->f3i2c == 0 ) $hlavicka->f3i2c="";
if( $hlavicka->f3i2d == 0 ) $hlavicka->f3i2d="";
if( $hlavicka->f3i2e == 0 ) $hlavicka->f3i2e="";
if( $hlavicka->f3i2f == 0 ) $hlavicka->f3i2f="";

$hlavicka->f3i2anyg46nyg46="1234.56";
$hlavicka->f3i2bnyg46nyg46="1234.56";
$hlavicka->f3i2cnyg46nyg46="1234.56";
$hlavicka->f3i2dnyg46nyg46="1234.56";
$hlavicka->f3i2enyg46nyg46="1234.56";
$hlavicka->f3i2fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f3i2a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f3i2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f3i2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f3i2d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f3i2e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f3i2f","$rmc",1,"R");

if( $hlavicka->f3i3b == 0 ) $hlavicka->f3i3b="";
if( $hlavicka->f3i3c == 0 ) $hlavicka->f3i3c="";
if( $hlavicka->f3i3d == 0 ) $hlavicka->f3i3d="";
if( $hlavicka->f3i3e == 0 ) $hlavicka->f3i3e="";
if( $hlavicka->f3i3f == 0 ) $hlavicka->f3i3f="";

$hlavicka->f3i3anyg46nyg46="1234.56";
$hlavicka->f3i3bnyg46nyg46="1234.56";
$hlavicka->f3i3cnyg46nyg46="1234.56";
$hlavicka->f3i3dnyg46nyg46="1234.56";
$hlavicka->f3i3enyg46nyg46="1234.56";
$hlavicka->f3i3fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f3i3a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f3i3b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f3i3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f3i3d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f3i3e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f3i3f","$rmc",1,"R");

//obstaravany DFM
if( $hlavicka->f4i1b == 0 ) $hlavicka->f4i1b="";
if( $hlavicka->f4i1c == 0 ) $hlavicka->f4i1c="";
if( $hlavicka->f4i1d == 0 ) $hlavicka->f4i1d="";
if( $hlavicka->f4i1e == 0 ) $hlavicka->f4i1e="";
if( $hlavicka->f4i1f == 0 ) $hlavicka->f4i1f="";

$hlavicka->f4i1anyg46nyg46="1234.56";
$hlavicka->f4i1bnyg46nyg46="1234.56";
$hlavicka->f4i1cnyg46nyg46="1234.56";
$hlavicka->f4i1dnyg46nyg46="1234.56";
$hlavicka->f4i1enyg46nyg46="1234.56";
$hlavicka->f4i1fnyg46nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f4i1a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f4i1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f4i1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f4i1d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f4i1e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f4i1f","$rmc",1,"R");

if( $hlavicka->f4i2b == 0 ) $hlavicka->f4i2b="";
if( $hlavicka->f4i2c == 0 ) $hlavicka->f4i2c="";
if( $hlavicka->f4i2d == 0 ) $hlavicka->f4i2d="";
if( $hlavicka->f4i2e == 0 ) $hlavicka->f4i2e="";
if( $hlavicka->f4i2f == 0 ) $hlavicka->f4i2f="";

$hlavicka->f4i2anyg46nyg46="1234.56";
$hlavicka->f4i2bnyg46nyg46="1234.56";
$hlavicka->f4i2cnyg46nyg46="1234.56";
$hlavicka->f4i2dnyg46nyg46="1234.56";
$hlavicka->f4i2enyg46nyg46="1234.56";
$hlavicka->f4i2fnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(40,5,"$hlavicka->f4i2a","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f4i2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f4i2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f4i2d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f4i2e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f4i2f","$rmc",1,"R");


//DFM spolu
if( $hlavicka->fi99 == 0 ) $hlavicka->fi99="";

$hlavicka->fi99nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(18,5," ","$rmc",0,"L");
$pdf->Cell(18,5," ","$rmc",0,"R");$pdf->Cell(25,5," ","$rmc",0,"R");
$pdf->Cell(18,5," ","$rmc",0,"R");$pdf->Cell(25,5," ","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->fi99","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text11"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(170);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 12

if ( $nopg13 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab10.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab10.jpg',1,23,210,82);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab11.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab11.jpg',1,160,210,80);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"10. Informácie k èasti F písm. j) a l) prílohy è.3 o dlhovıch CP dranıch do splatnosti","$rmc",1,"L");
$pdf->Cell(90,30,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//10.info k casti F pism. j,l o dlhovych CP
if( $hlavicka->f1jl1c == 0 ) $hlavicka->f1jl1c="";
if( $hlavicka->f1jl1d == 0 ) $hlavicka->f1jl1d="";
if( $hlavicka->f1jl1e == 0 ) $hlavicka->f1jl1e="";
if( $hlavicka->f1jl1f == 0 ) $hlavicka->f1jl1f="";
if( $hlavicka->f1jl1g == 0 ) $hlavicka->f1jl1g="";

$hlavicka->f1jl1bnyg46nyg46="1234.56";
$hlavicka->f1jl1cnyg46nyg46="1234.56";
$hlavicka->f1jl1dnyg46nyg46="1234.56";
$hlavicka->f1jl1enyg46nyg46="1234.56";
$hlavicka->f1jl1fnyg46nyg46="1234.56";
$hlavicka->f1jl1gnyg46nyg46="1234.56";

$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(20,5,"$hlavicka->f1jl1b","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->f1jl1c","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->f1jl1d","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl1e","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1jl1f","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl1g","$rmc",1,"R");

if( $hlavicka->f1jl2c == 0 ) $hlavicka->f1jl2c="";
if( $hlavicka->f1jl2d == 0 ) $hlavicka->f1jl2d="";
if( $hlavicka->f1jl2e == 0 ) $hlavicka->f1jl2e="";
if( $hlavicka->f1jl2f == 0 ) $hlavicka->f1jl2f="";
if( $hlavicka->f1jl2g == 0 ) $hlavicka->f1jl2g="";

$hlavicka->f1jl2bnyg46nyg46="1234.56";
$hlavicka->f1jl2cnyg46nyg46="1234.56";
$hlavicka->f1jl2dnyg46nyg46="1234.56";
$hlavicka->f1jl2enyg46nyg46="1234.56";
$hlavicka->f1jl2fnyg46nyg46="1234.56";
$hlavicka->f1jl2gnyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(20,5,"$hlavicka->f1jl2b","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->f1jl2c","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->f1jl2d","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl2e","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1jl2f","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl2g","$rmc",1,"R");

if( $hlavicka->f1jl3c == 0 ) $hlavicka->f1jl3c="";
if( $hlavicka->f1jl3d == 0 ) $hlavicka->f1jl3d="";
if( $hlavicka->f1jl3e == 0 ) $hlavicka->f1jl3e="";
if( $hlavicka->f1jl3f == 0 ) $hlavicka->f1jl3f="";
if( $hlavicka->f1jl3g == 0 ) $hlavicka->f1jl3g="";

$hlavicka->f1jl3bnyg46nyg46="1234.56";
$hlavicka->f1jl3cnyg46nyg46="1234.56";
$hlavicka->f1jl3dnyg46nyg46="1234.56";
$hlavicka->f1jl3enyg46nyg46="1234.56";
$hlavicka->f1jl3fnyg46nyg46="1234.56";
$hlavicka->f1jl3gnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(20,5,"$hlavicka->f1jl3b","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->f1jl3c","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->f1jl3d","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl3e","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1jl3f","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl3g","$rmc",1,"R");

if( $hlavicka->f1jl4c == 0 ) $hlavicka->f1jl4c="";
if( $hlavicka->f1jl4d == 0 ) $hlavicka->f1jl4d="";
if( $hlavicka->f1jl4e == 0 ) $hlavicka->f1jl4e="";
if( $hlavicka->f1jl4f == 0 ) $hlavicka->f1jl4f="";
if( $hlavicka->f1jl4g == 0 ) $hlavicka->f1jl4g="";

$hlavicka->f1jl4bnyg46nyg46="1234.56";
$hlavicka->f1jl4cnyg46nyg46="1234.56";
$hlavicka->f1jl4dnyg46nyg46="1234.56";
$hlavicka->f1jl4enyg46nyg46="1234.56";
$hlavicka->f1jl4fnyg46nyg46="1234.56";
$hlavicka->f1jl4gnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(20,5,"$hlavicka->f1jl4b","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->f1jl4c","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->f1jl4d","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl4e","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1jl4f","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl4g","$rmc",1,"R");


if( $hlavicka->f1jl99c == 0 ) $hlavicka->f1jl99c="";
if( $hlavicka->f1jl99d == 0 ) $hlavicka->f1jl99d="";
if( $hlavicka->f1jl99e == 0 ) $hlavicka->f1jl99e="";
if( $hlavicka->f1jl99f == 0 ) $hlavicka->f1jl99f="";
if( $hlavicka->f1jl99g == 0 ) $hlavicka->f1jl99g="";

$hlavicka->f1jl99cnyg46nyg46="1234.56";
$hlavicka->f1jl99dnyg46nyg46="1234.56";
$hlavicka->f1jl99enyg46nyg46="1234.56";
$hlavicka->f1jl99fnyg46nyg46="1234.56";
$hlavicka->f1jl99gnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(54,5," ","$rmc",0,"L");
$pdf->Cell(20,5," ","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl99c","$rmc",0,"R");
$pdf->Cell(20,5,"$hlavicka->f1jl99d","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl99e","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->f1jl99f","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->f1jl99g","$rmc",1,"R");



$pdf->Cell(90,58,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"11. Informácie k èasti F písm. j) a l) prílohy è.3 o poskytnutıch dlhodobıch pôièkách","$rmc",1,"L");
$pdf->Cell(90,30,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//11.info k casti F pism. j,l o poskytnutych dlhodob.pozickach
if( $hlavicka->f2jl1b == 0 ) $hlavicka->f2jl1b="";
if( $hlavicka->f2jl1c == 0 ) $hlavicka->f2jl1c="";
if( $hlavicka->f2jl1d == 0 ) $hlavicka->f2jl1d="";
if( $hlavicka->f2jl1e == 0 ) $hlavicka->f2jl1e="";
if( $hlavicka->f2jl1f == 0 ) $hlavicka->f2jl1f="";

$hlavicka->f2jl1bnyg46nyg46="1234.56";
$hlavicka->f2jl1cnyg46nyg46="1234.56";
$hlavicka->f2jl1dnyg46nyg46="1234.56";
$hlavicka->f2jl1enyg46nyg46="1234.56";
$hlavicka->f2jl1fnyg46nyg46="1234.56";

$pdf->Cell(53,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2jl1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl1d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl1e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl1f","$rmc",1,"R");

if( $hlavicka->f2jl2b == 0 ) $hlavicka->f2jl2b="";
if( $hlavicka->f2jl2c == 0 ) $hlavicka->f2jl2c="";
if( $hlavicka->f2jl2d == 0 ) $hlavicka->f2jl2d="";
if( $hlavicka->f2jl2e == 0 ) $hlavicka->f2jl2e="";
if( $hlavicka->f2jl2f == 0 ) $hlavicka->f2jl2f="";

$hlavicka->f2jl2bnyg46nyg46="1234.56";
$hlavicka->f2jl2cnyg46nyg46="1234.56";
$hlavicka->f2jl2dnyg46nyg46="1234.56";
$hlavicka->f2jl2enyg46nyg46="1234.56";
$hlavicka->f2jl2fnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(53,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2jl2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl2d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl2e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl2f","$rmc",1,"R");

if( $hlavicka->f2jl3b == 0 ) $hlavicka->f2jl3b="";
if( $hlavicka->f2jl3c == 0 ) $hlavicka->f2jl3c="";
if( $hlavicka->f2jl3d == 0 ) $hlavicka->f2jl3d="";
if( $hlavicka->f2jl3e == 0 ) $hlavicka->f2jl3e="";
if( $hlavicka->f2jl3f == 0 ) $hlavicka->f2jl3f="";

$hlavicka->f2jl3bnyg46nyg46="1234.56";
$hlavicka->f2jl3cnyg46nyg46="1234.56";
$hlavicka->f2jl3dnyg46nyg46="1234.56";
$hlavicka->f2jl3enyg46nyg46="1234.56";
$hlavicka->f2jl3fnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(53,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2jl3b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl3d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl3e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl3f","$rmc",1,"R");

if( $hlavicka->f2jl4b == 0 ) $hlavicka->f2jl4b="";
if( $hlavicka->f2jl4c == 0 ) $hlavicka->f2jl4c="";
if( $hlavicka->f2jl4d == 0 ) $hlavicka->f2jl4d="";
if( $hlavicka->f2jl4e == 0 ) $hlavicka->f2jl4e="";
if( $hlavicka->f2jl4f == 0 ) $hlavicka->f2jl4f="";

$hlavicka->f2jl4bnyg46nyg46="1234.56";
$hlavicka->f2jl4cnyg46nyg46="1234.56";
$hlavicka->f2jl4dnyg46nyg46="1234.56";
$hlavicka->f2jl4enyg46nyg46="1234.56";
$hlavicka->f2jl4fnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(53,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2jl4b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl4c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl4d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl4e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl4f","$rmc",1,"R");

if( $hlavicka->f2jl99b == 0 ) $hlavicka->f2jl99b="";
if( $hlavicka->f2jl99c == 0 ) $hlavicka->f2jl99c="";
if( $hlavicka->f2jl99d == 0 ) $hlavicka->f2jl99d="";
if( $hlavicka->f2jl99e == 0 ) $hlavicka->f2jl99e="";
if( $hlavicka->f2jl99f == 0 ) $hlavicka->f2jl99f="";

$hlavicka->f2jl99bnyg46nyg46="1234.56";
$hlavicka->f2jl99cnyg46nyg46="1234.56";
$hlavicka->f2jl99dnyg46nyg46="1234.56";
$hlavicka->f2jl99enyg46nyg46="1234.56";
$hlavicka->f2jl99fnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(53,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f2jl99b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl99c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl99d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f2jl99e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f2jl99f","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text12"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(106);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text13"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(241);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 13

if ( $nopg14 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab12_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab12_1.jpg',0,26,210,102);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab12_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab12_2.jpg',0,170,210,30);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab13.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab13.jpg',0,243,210,18);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"12. Informácie k èasti F písm. o) prílohy è.3 o opravnıch polokách k zásobám","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 1","$rmc",1,"L");
$pdf->Cell(90,36,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);

//12.info k casti F pism. o o opravnych polozkach tab1
if( $hlavicka->f1o1b == 0 ) $hlavicka->f1o1b="";
if( $hlavicka->f1o1c == 0 ) $hlavicka->f1o1c="";
if( $hlavicka->f1o1d == 0 ) $hlavicka->f1o1d="";
if( $hlavicka->f1o1e == 0 ) $hlavicka->f1o1e="";
if( $hlavicka->f1o1f == 0 ) $hlavicka->f1o1f="";

$hlavicka->f1o1bnyg46nyg46="1234.56";
$hlavicka->f1o1cnyg46nyg46="1234.56";
$hlavicka->f1o1dnyg46nyg46="1234.56";
$hlavicka->f1o1enyg46nyg46="1234.56";
$hlavicka->f1o1fnyg46nyg46="1234.56";

$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o1b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o1c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o1d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o1e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o1f","$rmc",1,"R");

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

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o2b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o2c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o2d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o2e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o2f","$rmc",1,"R");

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
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o3b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o3c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o3d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o3e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o3f","$rmc",1,"R");

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
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o4b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o4c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o4d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o4e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o4f","$rmc",1,"R");

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

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o5b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o5c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o5d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o5e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o5f","$rmc",1,"R");

if( $hlavicka->f1o6b == 0 ) $hlavicka->f1o6b="";
if( $hlavicka->f1o6c == 0 ) $hlavicka->f1o6c="";
if( $hlavicka->f1o6d == 0 ) $hlavicka->f1o6d="";
if( $hlavicka->f1o6e == 0 ) $hlavicka->f1o6e="";
if( $hlavicka->f1o6f == 0 ) $hlavicka->f1o6f="";

$hlavicka->f1o6bnyg46nyg46="1234.56";
$hlavicka->f1o6cnyg46nyg46="1234.56";
$hlavicka->f1o6dnyg46nyg46="1234.56";
$hlavicka->f1o6enyg46nyg46="1234.56";
$hlavicka->f1o6fnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o6b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o6c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o6d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o6e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o6f","$rmc",1,"R");

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

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o7b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o7c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o7d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o7e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o7f","$rmc",1,"R");

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
$pdf->Cell(52,5," ","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->f1o99b","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o99c","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o99d","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->f1o99e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->f1o99f","$rmc",1,"R");


$pdf->Cell(90,43,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 2","$rmc",1,"L");
$pdf->Cell(90,10,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);

//12.info k casti F pism. o o opravnych polozkach tab2
if( $hlavicka->f2o1 == 0 ) $hlavicka->f2o1="";
if( $hlavicka->f2o2 == 0 ) $hlavicka->f2o2="";
$hlavicka->f2o1nyg46nyg46="1234.56";
$hlavicka->f2o2nyg46nyg46="1234.56";

$pdf->Cell(95,5," ","$rmc",0,"L");$pdf->Cell(82,5,"$hlavicka->f2o1","$rmc",1,"R");
$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(95,5," ","$rmc",0,"L");$pdf->Cell(82,5,"$hlavicka->f2o2","$rmc",1,"R");


$pdf->Cell(90,42,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"13. Informácie k èasti F písm. p) prílohy è.3 o zásobách, na ktoré je zriadené záloné právo","$rmc",1,"L");
$pdf->Cell(90,11,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//13.info k casti F pism. p o zasobach...
if( $hlavicka->fp1 == 0 ) $hlavicka->fp1="";
if( $hlavicka->fp2 == 0 ) $hlavicka->fp2="";

$hlavicka->fp1nyg46nyg46="1234.56";
$hlavicka->fp2nyg46nyg46="1234.56";

$pdf->Cell(138,5," ","$rmc",0,"L");$pdf->Cell(38,5,"$hlavicka->fp1","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text14"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(129);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text15"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(201);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text16"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(271);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 14

if ( $nopg15 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_1.jpg',0,28,210,47);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_2.jpg',0,119,210,58);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_3.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_3.jpg',0,215,210,58);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"12. Informácie k èasti F písm. q) prílohy è.3 o zákazkovej vırobe a o zákazkovej vıstavbe nehnute¾nosti urèenej na predaj","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 1","$rmc",1,"L");
$pdf->Cell(90,25,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//14.info k casti F pism. q o zak.vyrobe tab1
if( $hlavicka->f1q1b == 0 ) $hlavicka->f1q1b="";
if( $hlavicka->f1q1c == 0 ) $hlavicka->f1q1c="";
if( $hlavicka->f1q1d == 0 ) $hlavicka->f1q1d="";

$hlavicka->f1q1bnyg46nyg46="1234.56";
$hlavicka->f1q1cnyg46nyg46="1234.56";
$hlavicka->f1q1dnyg46nyg46="1234.56";

$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->f1q1b","$rmc",0,"R");$pdf->Cell(38,5,"$hlavicka->f1q1c","$rmc",0,"R");$pdf->Cell(38,5,"$hlavicka->f1q1d","$rmc",1,"R");

if( $hlavicka->f1q2b == 0 ) $hlavicka->f1q2b="";
if( $hlavicka->f1q2c == 0 ) $hlavicka->f1q2c="";
if( $hlavicka->f1q2d == 0 ) $hlavicka->f1q2d="";

$hlavicka->f1q2bnyg46nyg46="1234.56";
$hlavicka->f1q2cnyg46nyg46="1234.56";
$hlavicka->f1q2dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->f1q2b","$rmc",0,"R");$pdf->Cell(38,5,"$hlavicka->f1q2c","$rmc",0,"R");$pdf->Cell(38,5,"$hlavicka->f1q2d","$rmc",1,"R");


if( $hlavicka->f1q3b == 0 ) $hlavicka->f1q3b="";
if( $hlavicka->f1q3c == 0 ) $hlavicka->f1q3c="";
if( $hlavicka->f1q3d == 0 ) $hlavicka->f1q3d="";

$hlavicka->f1q3bnyg46nyg46="1234.56";
$hlavicka->f1q3cnyg46nyg46="1234.56";
$hlavicka->f1q3dnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->f1q3b","$rmc",0,"R");$pdf->Cell(38,5,"$hlavicka->f1q3c","$rmc",0,"R");$pdf->Cell(38,5,"$hlavicka->f1q3d","$rmc",1,"R");



$pdf->Cell(90,44,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 2","$rmc",1,"L");
$pdf->Cell(90,23,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//14.info k casti F pism. q o zak.vyrobe tab2
if( $hlavicka->f2q1b == 0 ) $hlavicka->f2q1b="";
if( $hlavicka->f2q1c == 0 ) $hlavicka->f2q1c="";

$hlavicka->f2q1bnyg46nyg46="1234.56";
$hlavicka->f2q1cnyg46nyg46="1234.56";

$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(56,5,"$hlavicka->f2q1b","$rmc",0,"R");$pdf->Cell(57,5,"$hlavicka->f2q1c","$rmc",1,"R");

if( $hlavicka->f2q2b == 0 ) $hlavicka->f2q2b="";
if( $hlavicka->f2q2c == 0 ) $hlavicka->f2q2c="";

$hlavicka->f2q2bnyg46nyg46="1234.56";
$hlavicka->f2q2cnyg46nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(56,5,"$hlavicka->f2q2b","$rmc",0,"R");$pdf->Cell(57,5,"$hlavicka->f2q2c","$rmc",1,"R");

if( $hlavicka->f2q3b == 0 ) $hlavicka->f2q3b="";
if( $hlavicka->f2q3c == 0 ) $hlavicka->f2q3c="";

$hlavicka->f2q3bnyg46nyg46="1234.56";
$hlavicka->f2q3cnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(56,5,"$hlavicka->f2q3b","$rmc",0,"R");$pdf->Cell(57,5,"$hlavicka->f2q3c","$rmc",1,"R");

if( $hlavicka->f2q4b == 0 ) $hlavicka->f2q4b="";
if( $hlavicka->f2q4c == 0 ) $hlavicka->f2q4c="";

$hlavicka->f2q4bnyg46nyg46="1234.56";
$hlavicka->f2q4cnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(63,5," ","$rmc",0,"L");
$pdf->Cell(56,5,"$hlavicka->f2q4b","$rmc",0,"R");$pdf->Cell(57,5,"$hlavicka->f2q4c","$rmc",1,"R");



$pdf->Cell(90,39,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 3","$rmc",1,"L");
$pdf->Cell(90,30,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//14.info k casti F pism. q o zak.vyrobe tab3
if( $hlavicka->f3q1b == 0 ) $hlavicka->f3q1b="";
if( $hlavicka->f3q1c == 0 ) $hlavicka->f3q1c="";
if( $hlavicka->f3q1d == 0 ) $hlavicka->f3q1d="";

$hlavicka->f3q1bnyg46nyg46="1234.56";
$hlavicka->f3q1cnyg46nyg46="1234.56";
$hlavicka->f3q1dnyg46nyg46="1234.56";

$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f3q1b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f3q1c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f3q1d","$rmc",1,"R");

if( $hlavicka->f3q2b == 0 ) $hlavicka->f3q2b="";
if( $hlavicka->f3q2c == 0 ) $hlavicka->f3q2c="";
if( $hlavicka->f3q2d == 0 ) $hlavicka->f3q2d="";

$hlavicka->f3q2bnyg46nyg46="1234.56";
$hlavicka->f3q2cnyg46nyg46="1234.56";
$hlavicka->f3q2dnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f3q2b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f3q2c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f3q2d","$rmc",1,"R");


if( $hlavicka->f3q3b == 0 ) $hlavicka->f3q3b="";
if( $hlavicka->f3q3c == 0 ) $hlavicka->f3q3c="";
if( $hlavicka->f3q3d == 0 ) $hlavicka->f3q3d="";

$hlavicka->f3q3bnyg46nyg46="1234.56";
$hlavicka->f3q3cnyg46nyg46="1234.56";
$hlavicka->f3q3dnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f3q3b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f3q3c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f3q3d","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text17"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(76);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text18"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(177);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text19"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(273);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 15

if ( $nopg16 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_4.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab14_4.jpg',0,23,210,50);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab15.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab15.jpg',0,150,210,81);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");



$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 4","$rmc",1,"L");
$pdf->Cell(90,18,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//14.info k casti F pism. q o zak.vyrobe tab4
if( $hlavicka->f4q1b == 0 ) $hlavicka->f4q1b="";
if( $hlavicka->f4q1c == 0 ) $hlavicka->f4q1c="";

$hlavicka->f4q1bnyg46nyg46="1234.56";
$hlavicka->f4q1cnyg46nyg46="1234.56";

$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->f4q1b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f4q1c","$rmc",1,"R");

if( $hlavicka->f4q2b == 0 ) $hlavicka->f4q2b="";
if( $hlavicka->f4q2c == 0 ) $hlavicka->f4q2c="";

$hlavicka->f4q2bnyg46nyg46="1234.56";
$hlavicka->f4q2cnyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->f4q2b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f4q2c","$rmc",1,"R");

if( $hlavicka->f4q3b == 0 ) $hlavicka->f4q3b="";
if( $hlavicka->f4q3c == 0 ) $hlavicka->f4q3c="";

$hlavicka->f4q3bnyg46nyg46="1234.56";
$hlavicka->f4q3cnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(59,5,"$hlavicka->f4q3b","$rmc",0,"R");$pdf->Cell(58,5,"$hlavicka->f4q3c","$rmc",1,"R");

if( $hlavicka->f4q4b == 0 ) $hlavicka->f4q4b="";
if( $hlavicka->f4q4c == 0 ) $hlavicka->f4q4c="";

$hlavicka->f4q4bnyg46nyg46="1234.56";
$hlavicka->f4q4cnyg46nyg46="1234.56";

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(59,4,"$hlavicka->f4q4b","$rmc",0,"R");$pdf->Cell(58,4,"$hlavicka->f4q4c","$rmc",1,"R");



$pdf->Cell(90,76,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"15. Informácie k èasti F písm. r) prílohy è.3 o vıvoji opravnej poloky k poh¾adávkam","$rmc",1,"L");
$pdf->Cell(90,32,"     ","$rmc1",1,"L");

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
$pdf->Cell(23,5,"$hlavicka->fr1b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr1c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr1d","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr1e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr1f","$rmc",1,"R");

if( $hlavicka->fr2b == 0 ) $hlavicka->fr2b="";
if( $hlavicka->fr2c == 0 ) $hlavicka->fr2c="";
if( $hlavicka->fr2d == 0 ) $hlavicka->fr2d="";
if( $hlavicka->fr2e == 0 ) $hlavicka->fr2e="";
if( $hlavicka->fr2f == 0 ) $hlavicka->fr2f="";

$hlavicka->fr2bnyg46nyg46="1234.56";
$hlavicka->fr2cnyg46nyg46="1234.56";
$hlavicka->fr2dnyg46nyg46="1234.56";
$hlavicka->fr2enyg46nyg46="1234.56";
$hlavicka->fr2fnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->fr2b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr2c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr2d","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr2e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr2f","$rmc",1,"R");

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

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->fr3b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr3c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr3d","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr3e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr3f","$rmc",1,"R");

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
$pdf->Cell(23,5,"$hlavicka->fr4b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr4c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr4d","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr4e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr4f","$rmc",1,"R");

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

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->fr5b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr5c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr5d","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr5e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr5f","$rmc",1,"R");


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

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(61,5," ","$rmc",0,"L");
$pdf->Cell(23,5,"$hlavicka->fr99b","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr99c","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr99d","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fr99e","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fr99f","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text20"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(75);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text21"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(232);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 16

if ( $nopg17 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab16_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab16_1.jpg',0,28,210,143);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab16_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab16_2.jpg',0,211,210,70);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"16. Informácie k èasti F písm. s) prílohy è.3 o vekovej štruktúre poh¾adávok","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 1","$rmc",1,"L");
$pdf->Cell(90,21,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);

//16.info k casti F pism. s o vekovej... tabulka 1
if( $hlavicka->f1s1b == 0 ) $hlavicka->f1s1b="";
if( $hlavicka->f1s1c == 0 ) $hlavicka->f1s1c="";
if( $hlavicka->f1s1d == 0 ) $hlavicka->f1s1d="";

$hlavicka->f1s1bnyg46nyg46="1234.56";
$hlavicka->f1s1cnyg46nyg46="1234.56";
$hlavicka->f1s1dnyg46nyg46="1234.56";

$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s1b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s1c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s1d","$rmc",1,"R");

if( $hlavicka->f1s2b == 0 ) $hlavicka->f1s2b="";
if( $hlavicka->f1s2c == 0 ) $hlavicka->f1s2c="";
if( $hlavicka->f1s2d == 0 ) $hlavicka->f1s2d="";

$hlavicka->f1s2bnyg46nyg46="1234.56";
$hlavicka->f1s2cnyg46nyg46="1234.56";
$hlavicka->f1s2dnyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s2b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s2c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s2d","$rmc",1,"R");


if( $hlavicka->f1s3b == 0 ) $hlavicka->f1s3b="";
if( $hlavicka->f1s3c == 0 ) $hlavicka->f1s3c="";
if( $hlavicka->f1s3d == 0 ) $hlavicka->f1s3d="";

$hlavicka->f1s3bnyg46nyg46="1234.56";
$hlavicka->f1s3cnyg46nyg46="1234.56";
$hlavicka->f1s3dnyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s3b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s3c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s3d","$rmc",1,"R");

if( $hlavicka->f1s4b == 0 ) $hlavicka->f1s4b="";
if( $hlavicka->f1s4c == 0 ) $hlavicka->f1s4c="";
if( $hlavicka->f1s4d == 0 ) $hlavicka->f1s4d="";

$hlavicka->f1s4bnyg46nyg46="1234.56";
$hlavicka->f1s4cnyg46nyg46="1234.56";
$hlavicka->f1s4dnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s4b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s4c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s4d","$rmc",1,"R");

if( $hlavicka->f1s5b == 0 ) $hlavicka->f1s5b="";
if( $hlavicka->f1s5c == 0 ) $hlavicka->f1s5c="";
if( $hlavicka->f1s5d == 0 ) $hlavicka->f1s5d="";

$hlavicka->f1s5bnyg46nyg46="1234.56";
$hlavicka->f1s5cnyg46nyg46="1234.56";
$hlavicka->f1s5dnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s5b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s5c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s5d","$rmc",1,"R");


if( $hlavicka->f1s6b == 0 ) $hlavicka->f1s6b="";
if( $hlavicka->f1s6c == 0 ) $hlavicka->f1s6c="";
if( $hlavicka->f1s6d == 0 ) $hlavicka->f1s6d="";

$hlavicka->f1s6bnyg46nyg46="1234.56";
$hlavicka->f1s6cnyg46nyg46="1234.56";
$hlavicka->f1s6dnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s6b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s6c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s6d","$rmc",1,"R");


if( $hlavicka->f1s7b == 0 ) $hlavicka->f1s7b="";
if( $hlavicka->f1s7c == 0 ) $hlavicka->f1s7c="";
if( $hlavicka->f1s7d == 0 ) $hlavicka->f1s7d="";

$hlavicka->f1s7bnyg46nyg46="1234.56";
$hlavicka->f1s7cnyg46nyg46="1234.56";
$hlavicka->f1s7dnyg46nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s7b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s7c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s7d","$rmc",1,"R");


if( $hlavicka->f1s8b == 0 ) $hlavicka->f1s8b="";
if( $hlavicka->f1s8c == 0 ) $hlavicka->f1s8c="";
if( $hlavicka->f1s8d == 0 ) $hlavicka->f1s8d="";

$hlavicka->f1s8bnyg46nyg46="1234.56";
$hlavicka->f1s8cnyg46nyg46="1234.56";
$hlavicka->f1s8dnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s8b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s8c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s8d","$rmc",1,"R");

if( $hlavicka->f1s9b == 0 ) $hlavicka->f1s9b="";
if( $hlavicka->f1s9c == 0 ) $hlavicka->f1s9c="";
if( $hlavicka->f1s9d == 0 ) $hlavicka->f1s9d="";

$hlavicka->f1s9bnyg46nyg46="1234.56";
$hlavicka->f1s9cnyg46nyg46="1234.56";
$hlavicka->f1s9dnyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s9b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s9c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s9d","$rmc",1,"R");


if( $hlavicka->f1s10b == 0 ) $hlavicka->f1s10b="";
if( $hlavicka->f1s10c == 0 ) $hlavicka->f1s10c="";
if( $hlavicka->f1s10d == 0 ) $hlavicka->f1s10d="";

$hlavicka->f1s10bnyg46nyg46="1234.56";
$hlavicka->f1s10cnyg46nyg46="1234.56";
$hlavicka->f1s10dnyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s10b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s10c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s10d","$rmc",1,"R");


if( $hlavicka->f1s11b == 0 ) $hlavicka->f1s11b="";
if( $hlavicka->f1s11c == 0 ) $hlavicka->f1s11c="";
if( $hlavicka->f1s11d == 0 ) $hlavicka->f1s11d="";

$hlavicka->f1s11bnyg46nyg46="1234.56";
$hlavicka->f1s11cnyg46nyg46="1234.56";
$hlavicka->f1s11dnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s11b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s11c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s11d","$rmc",1,"R");


if( $hlavicka->f1s12b == 0 ) $hlavicka->f1s12b="";
if( $hlavicka->f1s12c == 0 ) $hlavicka->f1s12c="";
if( $hlavicka->f1s12d == 0 ) $hlavicka->f1s12d="";

$hlavicka->f1s12bnyg46nyg46="1234.56";
$hlavicka->f1s12cnyg46nyg46="1234.56";
$hlavicka->f1s12dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s12b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s12c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s12d","$rmc",1,"R");


if( $hlavicka->f1s13b == 0 ) $hlavicka->f1s13b="";
if( $hlavicka->f1s13c == 0 ) $hlavicka->f1s13c="";
if( $hlavicka->f1s13d == 0 ) $hlavicka->f1s13d="";

$hlavicka->f1s13bnyg46nyg46="1234.56";
$hlavicka->f1s13cnyg46nyg46="1234.56";
$hlavicka->f1s13dnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s13b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s13c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s13d","$rmc",1,"R");


if( $hlavicka->f1s14b == 0 ) $hlavicka->f1s14b="";
if( $hlavicka->f1s14c == 0 ) $hlavicka->f1s14c="";
if( $hlavicka->f1s14d == 0 ) $hlavicka->f1s14d="";

$hlavicka->f1s14bnyg46nyg46="1234.56";
$hlavicka->f1s14cnyg46nyg46="1234.56";
$hlavicka->f1s14dnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(60,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->f1s14b","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s14c","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->f1s14d","$rmc",1,"R");




$pdf->Cell(90,41,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 2","$rmc",1,"L");
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

$pdf->Cell(90,4,"     ","$rmc",1,"L");
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

$pdf->Cell(90,4,"     ","$rmc",1,"L");
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





$pdf->SetFont('arial','',9);

$ozntext="F_text22"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(170);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text23"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(279);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 17

if ( $nopg18 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab17.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab17.jpg',0,26,210,28);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab18_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab18_1.jpg',0,118,210,48);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab18_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab18_2.jpg',0,196,210,84);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");
$pdf->Cell(0,4,"17. Informácie k èasti F písm. t) a u) prílohy è.3 o poh¾adávkach zabezpeèenıch zálonım právom alebo inou formou zabezpeèenia","$rmc",1,"L");
$pdf->Cell(90,15,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//17.info k casti F pism. t,u o pohl.zabezp.
if( $hlavicka->ftu11 == 0 ) $hlavicka->ftu11="";
if( $hlavicka->ftu12 == 0 ) $hlavicka->ftu12="";

$hlavicka->ftu11nyg46nyg46="1234.56";
$hlavicka->ftu12nyg46nyg46="1234.56";

$pdf->Cell(97,7," ","$rmc",0,"L");
$pdf->Cell(40,5,"$hlavicka->ftu11","$rmc",0,"R");$pdf->Cell(39,5,"$hlavicka->ftu12","$rmc",1,"R");

if( $hlavicka->ftu21 == 0 ) $hlavicka->ftu21="";
if( $hlavicka->ftu22 == 0 ) $hlavicka->ftu22="";

$hlavicka->ftu21nyg46nyg46="1234.56";
$hlavicka->ftu22nyg46nyg46="1234.56";

$pdf->Cell(97,2,"     ","$rmc",1,"L");
$pdf->Cell(97,7," ","$rmc",0,"L");
$pdf->Cell(40,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->ftu22","$rmc",1,"R");



$pdf->Cell(90,58,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"18. Informácie k èasti F písm. w) prílohy è.3 o krátkodobom finanènom majetku ","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 1","$rmc",1,"L");
$pdf->Cell(90,12,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//18.info k casti F pism. w o krat.FM
if( $hlavicka->f1w11 == 0 ) $hlavicka->f1w11="";
if( $hlavicka->f1w12 == 0 ) $hlavicka->f1w12="";

$hlavicka->f1w11nyg46nyg46="1234.56";
$hlavicka->f1w12nyg46nyg46="1234.56";

$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w11","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->f1w12","$rmc",1,"R");

if( $hlavicka->f1w21 == 0 ) $hlavicka->f1w21="";
if( $hlavicka->f1w22 == 0 ) $hlavicka->f1w22="";

$hlavicka->f1w21nyg46nyg46="1234.56";
$hlavicka->f1w22nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w21","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->f1w22","$rmc",1,"R");

if( $hlavicka->f1w31 == 0 ) $hlavicka->f1w31="";
if( $hlavicka->f1w32 == 0 ) $hlavicka->f1w32="";

$hlavicka->f1w31nyg46nyg46="1234.56";
$hlavicka->f1w32nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w31","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->f1w32","$rmc",1,"R");

if( $hlavicka->f1w41 == 0 ) $hlavicka->f1w41="";
if( $hlavicka->f1w42 == 0 ) $hlavicka->f1w42="";

$hlavicka->f1w41nyg46nyg46="1234.56";
$hlavicka->f1w42nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w41","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->f1w42","$rmc",1,"R");

if( $hlavicka->f1w991 == 0 ) $hlavicka->f1w991="";
if( $hlavicka->f1w992 == 0 ) $hlavicka->f1w992="";

$hlavicka->f1w991nyg46nyg46="1234.56";
$hlavicka->f1w992nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(55,5,"$hlavicka->f1w991","$rmc",0,"R");$pdf->Cell(55,5,"$hlavicka->f1w992","$rmc",1,"R");


$pdf->Cell(90,28,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka 2","$rmc",1,"L");
$pdf->Cell(90,28,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',6);

//18.info k casti F pism. w o krat.FM tabulka 2
if( $hlavicka->f2w1b == 0 ) $hlavicka->f2w1b="";
if( $hlavicka->f2w1c == 0 ) $hlavicka->f2w1c="";
if( $hlavicka->f2w1d == 0 ) $hlavicka->f2w1d="";
if( $f2w1dp == 0 ) $f2w1dp="";
if( $hlavicka->f2w1e == 0 ) $hlavicka->f2w1e="";

$hlavicka->f2w1bnyg46nyg46="1234.56";
$hlavicka->f2w1cnyg46nyg46="1234.56";
$hlavicka->f2w1dnyg46nyg46="1234.56";
$hlavicka->f2w1enyg46nyg46="1234.56";

$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w1b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w1c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w1d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w1dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w1e","$rmc",1,"R");

if( $hlavicka->f2w2b == 0 ) $hlavicka->f2w2b="";
if( $hlavicka->f2w2c == 0 ) $hlavicka->f2w2c="";
if( $hlavicka->f2w2d == 0 ) $hlavicka->f2w2d="";
if( $f2w2dp == 0 ) $f2w2dp="";
if( $hlavicka->f2w2e == 0 ) $hlavicka->f2w2e="";

$hlavicka->f2w2bnyg46nyg46="1234.56";
$hlavicka->f2w2cnyg46nyg46="1234.56";
$hlavicka->f2w2dnyg46nyg46="1234.56";
$hlavicka->f2w2enyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w2b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w2c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w2d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w2dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w2e","$rmc",1,"R");

if( $hlavicka->f2w3b == 0 ) $hlavicka->f2w3b="";
if( $hlavicka->f2w3c == 0 ) $hlavicka->f2w3c="";
if( $hlavicka->f2w3d == 0 ) $hlavicka->f2w3d="";
if( $f2w3dp == 0 ) $f2w3dp="";
if( $hlavicka->f2w3e == 0 ) $hlavicka->f2w3e="";

$hlavicka->f2w3bnyg46nyg46="1234.56";
$hlavicka->f2w3cnyg46nyg46="1234.56";
$hlavicka->f2w3dnyg46nyg46="1234.56";
$hlavicka->f2w3enyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w3b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w3c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w3d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w3dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w3e","$rmc",1,"R");

if( $hlavicka->f2w4b == 0 ) $hlavicka->f2w4b="";
if( $hlavicka->f2w4c == 0 ) $hlavicka->f2w4c="";
if( $hlavicka->f2w4d == 0 ) $hlavicka->f2w4d="";
if( $f2w4dp == 0 ) $f2w4dp="";
if( $hlavicka->f2w4e == 0 ) $hlavicka->f2w4e="";

$hlavicka->f2w4bnyg46nyg46="1234.56";
$hlavicka->f2w4cnyg46nyg46="1234.56";
$hlavicka->f2w4dnyg46nyg46="1234.56";
$hlavicka->f2w4enyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w4b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w4c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w4d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w4dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w4e","$rmc",1,"R");

if( $hlavicka->f2w5b == 0 ) $hlavicka->f2w5b="";
if( $hlavicka->f2w5c == 0 ) $hlavicka->f2w5c="";
if( $hlavicka->f2w5d == 0 ) $hlavicka->f2w5d="";
if( $f2w5dp == 0 ) $f2w5dp="";
if( $hlavicka->f2w5e == 0 ) $hlavicka->f2w5e="";

$hlavicka->f2w5bnyg46nyg46="1234.56";
$hlavicka->f2w5cnyg46nyg46="1234.56";
$hlavicka->f2w5dnyg46nyg46="1234.56";
$hlavicka->f2w5enyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w5b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w5c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w5d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w5dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w5e","$rmc",1,"R");

if( $hlavicka->f2w6b == 0 ) $hlavicka->f2w6b="";
if( $hlavicka->f2w6c == 0 ) $hlavicka->f2w6c="";
if( $hlavicka->f2w6d == 0 ) $hlavicka->f2w6d="";
if( $f2w6dp == 0 ) $f2w6dp="";
if( $hlavicka->f2w6e == 0 ) $hlavicka->f2w6e="";

$hlavicka->f2w6bnyg46nyg46="1234.56";
$hlavicka->f2w6cnyg46nyg46="1234.56";
$hlavicka->f2w6dnyg46nyg46="1234.56";
$hlavicka->f2w6enyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w6b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w6c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w6d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w6dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w6e","$rmc",1,"R");

if( $hlavicka->f2w99b == 0 ) $hlavicka->f2w99b="";
if( $hlavicka->f2w99c == 0 ) $hlavicka->f2w99c="";
if( $hlavicka->f2w99d == 0 ) $hlavicka->f2w99d="";
if( $f2w99dp == 0 ) $f2w99dp="";
if( $hlavicka->f2w99e == 0 ) $hlavicka->f2w99e="";

$hlavicka->f2w99bnyg46nyg46="1234.56";
$hlavicka->f2w99cnyg46nyg46="1234.56";
$hlavicka->f2w99dnyg46nyg46="1234.56";
$hlavicka->f2w99enyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(64,5," ","$rmc1",0,"L");
$pdf->Cell(26,5,"$hlavicka->f2w99b","$rmc",0,"R");$pdf->Cell(20,5,"$hlavicka->f2w99c","$rmc",0,"R");
$pdf->Cell(16,5,"$hlavicka->f2w99d","$rmc",0,"R");$pdf->Cell(22,5,"$f2w99dp","$rmc",0,"R");
$pdf->Cell(28,5,"$hlavicka->f2w99e","$rmc",1,"R");


$pdf->SetFont('arial','',9);

$ozntext="F_text24"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(57);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
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

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text26"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(280);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 18

if ( $nopg19 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab19.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab19.jpg',1,23,210,54);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab20.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab20.jpg',0,132,210,18);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab21.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab21.jpg',0,220,210,60);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,9,"                          ","$rmc1",1,"L");


$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"19. Informácie k èasti F písm. x) prílohy è.3 o vıvoji opravnej poloky ku krátkodobému finanènému majetku","$rmc",1,"L");
$pdf->Cell(90,28,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//19.info k casti F pism. z vyvoj opravnej....
if( $hlavicka->fx1b == 0 ) $hlavicka->fx1b="";
if( $hlavicka->fx1c == 0 ) $hlavicka->fx1c="";
if( $hlavicka->fx1d == 0 ) $hlavicka->fx1d="";
if( $hlavicka->fx1e == 0 ) $hlavicka->fx1e="";
if( $hlavicka->fx1f == 0 ) $hlavicka->fx1f="";

$hlavicka->fx1bnyg46nyg46="1234.56";
$hlavicka->fx1cnyg46nyg46="1234.56";
$hlavicka->fx1dnyg46nyg46="1234.56";
$hlavicka->fx1enyg46nyg46="1234.56";
$hlavicka->fx1fnyg46nyg46="1234.56";

$pdf->Cell(68,5,"     ","$rmc",0,"L");
$pdf->Cell(22,5,"$hlavicka->fx1b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->fx1c","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fx1d","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->fx1e","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fx1f","$rmc",1,"R");

if( $hlavicka->fx2b == 0 ) $hlavicka->fx2b="";
if( $hlavicka->fx2c == 0 ) $hlavicka->fx2c="";
if( $hlavicka->fx2d == 0 ) $hlavicka->fx2d="";
if( $hlavicka->fx2e == 0 ) $hlavicka->fx2e="";
if( $hlavicka->fx2f == 0 ) $hlavicka->fx2f="";

$hlavicka->fx2bnyg46nyg46="1234.56";
$hlavicka->fx2cnyg46nyg46="1234.56";
$hlavicka->fx2dnyg46nyg46="1234.56";
$hlavicka->fx2enyg46nyg46="1234.56";
$hlavicka->fx2fnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(68,5,"     ","$rmc",0,"L");
$pdf->Cell(22,5,"$hlavicka->fx2b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->fx2c","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fx2d","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->fx2e","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fx2f","$rmc",1,"R");

if( $hlavicka->fx99b == 0 ) $hlavicka->fx99b="";
if( $hlavicka->fx99c == 0 ) $hlavicka->fx99c="";
if( $hlavicka->fx99d == 0 ) $hlavicka->fx99d="";
if( $hlavicka->fx99e == 0 ) $hlavicka->fx99e="";
if( $hlavicka->fx99f == 0 ) $hlavicka->fx99f="";

$hlavicka->fx99bnyg46nyg46="1234.56";
$hlavicka->fx99cnyg46nyg46="1234.56";
$hlavicka->fx99dnyg46nyg46="1234.56";
$hlavicka->fx99enyg46nyg46="1234.56";
$hlavicka->fx99fnyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(68,5,"     ","$rmc",0,"L");
$pdf->Cell(22,5,"$hlavicka->fx99b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->fx99c","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fx99d","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->fx99e","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fx99f","$rmc",1,"R");




$pdf->Cell(90,54,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"20. Informácie k èasti F písm. y) prílohy è.3 o krátkodobom finanènom majetku, na ktorı bolo zriadené záloné právo","$rmc",1,"L");
$pdf->Cell(90,11,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//20.info k casti F pism. y o kr.FM
if( $hlavicka->fy1 == 0 ) $hlavicka->fy1="";
if( $hlavicka->fy2 == 0 ) $hlavicka->fy2="";

$hlavicka->fy1nyg46nyg46="1234.56";
$hlavicka->fy2nyg46nyg46="1234.56";

$pdf->Cell(135,5," ","$rmc",0,"L");$pdf->Cell(42,5,"$hlavicka->fy1","$rmc",1,"R");



$pdf->Cell(90,66,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"21. Informácie k èasti F písm. za) prílohy è.3 o ocenení krátkodobého finanèného majetku, ku dòu ku ktorému","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"sa zostavuje úètovná závierka reálnou hodnotou","$rmc",1,"L");
$pdf->Cell(90,24,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//21.info k casti F pism. za o oceneni krat.FM tabulka 2
if( $hlavicka->fza1b == 0 ) $hlavicka->fza1b="";
if( $hlavicka->fza1c == 0 ) $hlavicka->fza1c="";
if( $hlavicka->fza1d == 0 ) $hlavicka->fza1d="";

$hlavicka->fza1bnyg46nyg46="1234.56";
$hlavicka->fza1cnyg46nyg46="1234.56";
$hlavicka->fza1dnyg46nyg46="1234.56";

$pdf->Cell(66,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza1b","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fza1c","$rmc",0,"R");
$pdf->Cell(37,5,"$hlavicka->fza1d","$rmc",1,"R");

if( $hlavicka->fza2b == 0 ) $hlavicka->fza2b="";
if( $hlavicka->fza2c == 0 ) $hlavicka->fza2c="";
if( $hlavicka->fza2d == 0 ) $hlavicka->fza2d="";

$hlavicka->fza2bnyg46nyg46="1234.56";
$hlavicka->fza2cnyg46nyg46="1234.56";
$hlavicka->fza2dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(66,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza2b","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fza2c","$rmc",0,"R");
$pdf->Cell(37,5,"$hlavicka->fza2d","$rmc",1,"R");

if( $hlavicka->fza3b == 0 ) $hlavicka->fza3b="";
if( $hlavicka->fza3c == 0 ) $hlavicka->fza3c="";
if( $hlavicka->fza3d == 0 ) $hlavicka->fza3d="";

$hlavicka->fza3bnyg46nyg46="1234.56";
$hlavicka->fza3cnyg46nyg46="1234.56";
$hlavicka->fza3dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(66,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza3b","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fza3c","$rmc",0,"R");
$pdf->Cell(37,5,"$hlavicka->fza3d","$rmc",1,"R");

if( $hlavicka->fza4b == 0 ) $hlavicka->fza4b="";
if( $hlavicka->fza4c == 0 ) $hlavicka->fza4c="";
if( $hlavicka->fza4d == 0 ) $hlavicka->fza4d="";

$hlavicka->fza4bnyg46nyg46="1234.56";
$hlavicka->fza4cnyg46nyg46="1234.56";
$hlavicka->fza4dnyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(66,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza4b","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fza4c","$rmc",0,"R");
$pdf->Cell(37,5,"$hlavicka->fza4d","$rmc",1,"R");

if( $hlavicka->fza99b == 0 ) $hlavicka->fza99b="";
if( $hlavicka->fza99c == 0 ) $hlavicka->fza99c="";
if( $hlavicka->fza99d == 0 ) $hlavicka->fza99d="";

$hlavicka->fza99bnyg46nyg46="1234.56";
$hlavicka->fza99cnyg46nyg46="1234.56";
$hlavicka->fza99dnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(66,5," ","$rmc",0,"L");
$pdf->Cell(37,5,"$hlavicka->fza99b","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fza99c","$rmc",0,"R");
$pdf->Cell(37,5,"$hlavicka->fza99d","$rmc",1,"R");



$pdf->SetFont('arial','',9);

$ozntext="F_text27"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(77);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text28"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(161);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text29"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(280);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(17,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 19

if ( $nopg20 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab22.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab22.jpg',0,30,210,98);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab23.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab23.jpg',0,180,210,60);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,7,"                          ","$rmc1",1,"L");


//prva tabulka

$pdf->Cell(90,8,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"22. Informácie k èasti F písm. zb) prílohy è.3 o vıznamnıch polokách èasového rozlíšenia na strane aktív","$rmc",1,"L");
$pdf->Cell(90,13,"     ","$rmc1",1,"L");
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

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f2zb21","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f2zb22","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f2zb23","$rmc",1,"R");

if( $hlavicka->f2zb32 == 0 ) $hlavicka->f2zb32="";
if( $hlavicka->f2zb33 == 0 ) $hlavicka->f2zb33="";

$hlavicka->f2zb31nyg46nyg46="1234.56";
$hlavicka->f2zb32nyg46nyg46="1234.56";
$hlavicka->f2zb33nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f2zb31","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f2zb32","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f2zb33","$rmc",1,"R");

if( $hlavicka->f3zb12 == 0 ) $hlavicka->f3zb12="";
if( $hlavicka->f3zb13 == 0 ) $hlavicka->f3zb13="";

$hlavicka->f3zb12nyg46nyg46="1234.56";
$hlavicka->f3zb13nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(67,5," ","$rmc",0,"L");
$pdf->Cell(60,5,"$hlavicka->f3zb12","$rmc",0,"R");$pdf->Cell(49,5,"$hlavicka->f3zb13","$rmc",1,"R");

if( $hlavicka->f3zb22 == 0 ) $hlavicka->f3zb22="";
if( $hlavicka->f3zb23 == 0 ) $hlavicka->f3zb23="";

$hlavicka->f3zb21nyg46nyg46="1234.56";
$hlavicka->f3zb22nyg46nyg46="1234.56";
$hlavicka->f3zb23nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f3zb21","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f3zb22","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f3zb23","$rmc",1,"R");

if( $hlavicka->f3zb32 == 0 ) $hlavicka->f3zb32="";
if( $hlavicka->f3zb33 == 0 ) $hlavicka->f3zb33="";

$hlavicka->f3zb31nyg46nyg46="1234.56";
$hlavicka->f3zb32nyg46nyg46="1234.56";
$hlavicka->f3zb33nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(14,5," ","$rmc",0,"L");
$pdf->Cell(64,5,"$hlavicka->f3zb31","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->f3zb32","$rmc",0,"R");
$pdf->Cell(49,5,"$hlavicka->f3zb33","$rmc",1,"R");

if( $hlavicka->f4zb12 == 0 ) $hlavicka->f4zb12="";
if( $hlavicka->f4zb13 == 0 ) $hlavicka->f4zb13="";

$hlavicka->f4zb12nyg46nyg46="1234.56";
$hlavicka->f4zb13nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
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
$pdf->Cell(90,51,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"23. Informácie k èasti F písm. zc) prílohy è.3 o majetku prenajatom formou finanèného prenájmu","$rmc",1,"L");
$pdf->Cell(90,38,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//23.info k casti F pism. zc prilohy c 3
//dcerske uct jednotky
if( $hlavicka->fzc1b == 0 ) $hlavicka->fzc1b="";
if( $hlavicka->fzc1c == 0 ) $hlavicka->fzc1c="";
if( $hlavicka->fzc1d == 0 ) $hlavicka->fzc1d="";
if( $hlavicka->fzc1e == 0 ) $hlavicka->fzc1e="";
if( $hlavicka->fzc1f == 0 ) $hlavicka->fzc1f="";
if( $hlavicka->fzc1g == 0 ) $hlavicka->fzc1g="";

$hlavicka->fzc1bnyg46nyg46="1234.56";
$hlavicka->fzc1cnyg46nyg46="1234.56";
$hlavicka->fzc1dnyg46nyg46="1234.56";
$hlavicka->fzc1enyg46nyg46="1234.56";
$hlavicka->fzc1fnyg46nyg46="1234.56";
$hlavicka->fzc1gnyg46nyg46="1234.56";

$pdf->Cell(36,5," ","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->fzc1b","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fzc1c","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->fzc1d","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->fzc1e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fzc1f","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fzc1g","$rmc",1,"R");

if( $hlavicka->fzc2b == 0 ) $hlavicka->fzc2b="";
if( $hlavicka->fzc2c == 0 ) $hlavicka->fzc2c="";
if( $hlavicka->fzc2d == 0 ) $hlavicka->fzc2d="";
if( $hlavicka->fzc2e == 0 ) $hlavicka->fzc2e="";
if( $hlavicka->fzc2f == 0 ) $hlavicka->fzc2f="";
if( $hlavicka->fzc2g == 0 ) $hlavicka->fzc2g="";

$hlavicka->fzc2bnyg46nyg46="1234.56";
$hlavicka->fzc2cnyg46nyg46="1234.56";
$hlavicka->fzc2dnyg46nyg46="1234.56";
$hlavicka->fzc2enyg46nyg46="1234.56";
$hlavicka->fzc2fnyg46nyg46="1234.56";
$hlavicka->fzc2gnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(36,5," ","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->fzc2b","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fzc2c","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->fzc2d","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->fzc2e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fzc2f","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fzc2g","$rmc",1,"R");

if( $hlavicka->fzc99b == 0 ) $hlavicka->fzc99b="";
if( $hlavicka->fzc99c == 0 ) $hlavicka->fzc99c="";
if( $hlavicka->fzc99d == 0 ) $hlavicka->fzc99d="";
if( $hlavicka->fzc99e == 0 ) $hlavicka->fzc99e="";
if( $hlavicka->fzc99f == 0 ) $hlavicka->fzc99f="";
if( $hlavicka->fzc99g == 0 ) $hlavicka->fzc99g="";

$hlavicka->fzc99bnyg46nyg46="1234.56";
$hlavicka->fzc99cnyg46nyg46="1234.56";
$hlavicka->fzc99dnyg46nyg46="1234.56";
$hlavicka->fzc99enyg46nyg46="1234.56";
$hlavicka->fzc99fnyg46nyg46="1234.56";
$hlavicka->fzc99gnyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(36,5," ","$rmc",0,"L");$pdf->Cell(24,5,"$hlavicka->fzc99b","$rmc",0,"R");
$pdf->Cell(22,5,"$hlavicka->fzc99c","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->fzc99d","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->fzc99e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->fzc99f","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->fzc99g","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="F_text30"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(130);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="F_text31"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(245);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 20

if ( $nopg21 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab24_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab24_1.jpg',0,150,210,93);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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


//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"G. INFORMÁCIE O ÚDAJOCH VYKÁZANİCH NA STRANE PASÍV SÚVAHY ","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");


//prva tabulka
$pdf->Cell(90,112,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"24. Informácie k èasti G písm. a) tretiemu bodu prílohy è.3 o rozdelení úètovného zisku alebo o vysporiadaní úètovnej straty","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");
$pdf->Cell(90,13,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);

//24.info k casti G pism. a,k 3 bodu prilohy 3
$pdf->SetFont('arial','',9);
if( $hlavicka->g3a11 == 0 ) $hlavicka->g3a11="";
if( $hlavicka->g3a12 == 0 ) $hlavicka->g3a12="";
if( $hlavicka->g3a13 == 0 ) $hlavicka->g3a13="";
if( $hlavicka->g3a14 == 0 ) $hlavicka->g3a14="";
if( $hlavicka->g3a15 == 0 ) $hlavicka->g3a15="";
if( $hlavicka->g3a16 == 0 ) $hlavicka->g3a16="";
if( $hlavicka->g3a17 == 0 ) $hlavicka->g3a17="";
if( $hlavicka->g3a18 == 0 ) $hlavicka->g3a18="";
if( $hlavicka->g3a19 == 0 ) $hlavicka->g3a19="";
if( $hlavicka->g3a199 == 0 ) $hlavicka->g3a199="";


$hlavicka->g3a11nyg46nyg46="1234.56";
$hlavicka->g3a12nyg46nyg46="1234.56";
$hlavicka->g3a13nyg46nyg46="1234.56";
$hlavicka->g3a14nyg46nyg46="1234.56";
$hlavicka->g3a15nyg46nyg46="1234.56";
$hlavicka->g3a16nyg46nyg46="1234.56";
$hlavicka->g3a17nyg46nyg46="1234.56";
$hlavicka->g3a18nyg46nyg46="1234.56";
$hlavicka->g3a19nyg46nyg46="1234.56";
$hlavicka->g3a199nyg46nyg46="1234.56";


$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a11","$rmc",1,"R");
$pdf->Cell(90,9,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a12","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a13","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a14","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a15","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a16","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a17","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a18","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a19","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a199","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(30);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(16,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(246);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 21

if ( $nopg22 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab24_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab24_2.jpg',0,30,210,80);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab25_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab25_1.jpg',0,150,210,112);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,15,"                          ","$rmc1",1,"L");


//prva tabulka
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2","$rmc",1,"L");
$pdf->Cell(90,13,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka 24.2
if( $hlavicka->g3a21 == 0 ) $hlavicka->g3a21="";
if( $hlavicka->g3a22 == 0 ) $hlavicka->g3a22="";
if( $hlavicka->g3a23 == 0 ) $hlavicka->g3a23="";
if( $hlavicka->g3a24 == 0 ) $hlavicka->g3a24="";
if( $hlavicka->g3a25 == 0 ) $hlavicka->g3a25="";
if( $hlavicka->g3a26 == 0 ) $hlavicka->g3a26="";
if( $hlavicka->g3a27 == 0 ) $hlavicka->g3a27="";
if( $hlavicka->g3a299 == 0 ) $hlavicka->g3a299="";


$hlavicka->g3a21nyg46nyg46="1234.56";
$hlavicka->g3a22nyg46nyg46="1234.56";
$hlavicka->g3a23nyg46nyg46="1234.56";
$hlavicka->g3a24nyg46nyg46="1234.56";
$hlavicka->g3a25nyg46nyg46="1234.56";
$hlavicka->g3a26nyg46nyg46="1234.56";
$hlavicka->g3a27nyg46nyg46="1234.56";
$hlavicka->g3a299nyg46nyg46="1234.56";


$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a21","$rmc",1,"R");
$pdf->Cell(90,10,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a22","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a23","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a24","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a25","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a26","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a27","$rmc",1,"R");
$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(127,5," ","$rmc",0,"L");$pdf->Cell(49,5,"$hlavicka->g3a299","$rmc",1,"R");



//druha tabulka
$pdf->Cell(90,37,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"25. Informácie k èasti G písm. b) prílohy è.3 o rezervách","$rmc",1,"L");
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");
$pdf->Cell(90,27,"     ","$rmc1",1,"L");

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

$pdf->Cell(56,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b1b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b1c1","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b2a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b2b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b2c1","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b3a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b3b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b3c1","$rmc",0,"R");
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

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b4a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b4b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b4c1","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b5a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b5b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b5c1","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b6a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b6b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b6c1","$rmc",0,"R");
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

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(56,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b1b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b1c2","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b2a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b2b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b2c2","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b3a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b3b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b3c2","$rmc",0,"R");
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


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b4a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b4b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b4c2","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b5a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b5b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b5c2","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b6a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b6b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b6c2","$rmc",0,"R");
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


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b7a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b7b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b7c2","$rmc",0,"R");
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
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g1b8a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g1b8b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g1b8c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b8d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g1b8e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g1b8f2","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(111);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(263);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 22

if ( $nopg23 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab25_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab25_2.jpg',0,90,210,115);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



$pdf->Cell(90,67,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2","$rmc",1,"L");
$pdf->Cell(90,27,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka 25.2

if( $hlavicka->g2b1b1 == 0 ) $hlavicka->g2b1b1="";
if( $hlavicka->g2b1c1 == 0 ) $hlavicka->g2b1c1="";
if( $hlavicka->g2b1d1 == 0 ) $hlavicka->g2b1d1="";
if( $hlavicka->g2b1e1 == 0 ) $hlavicka->g2b1e1="";
if( $hlavicka->g2b1f1 == 0 ) $hlavicka->g2b1f1="";

$hlavicka->g2b1b1nyg46nyg46="1234.56";
$hlavicka->g2b1c1nyg46nyg46="1234.56";
$hlavicka->g2b1d1nyg46nyg46="1234.56";
$hlavicka->g2b1e1nyg46nyg46="1234.56";
$hlavicka->g2b1f1nyg46nyg46="1234.56";

$pdf->Cell(56,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b1b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b1c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b1d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b1e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b1f1","$rmc",1,"R");

if( $hlavicka->g2b2b1 == 0 ) $hlavicka->g2b2b1="";
if( $hlavicka->g2b2c1 == 0 ) $hlavicka->g2b2c1="";
if( $hlavicka->g2b2d1 == 0 ) $hlavicka->g2b2d1="";
if( $hlavicka->g2b2e1 == 0 ) $hlavicka->g2b2e1="";
if( $hlavicka->g2b2f1 == 0 ) $hlavicka->g2b2f1="";

$hlavicka->g2b2a1nyg46nyg46="1234.56";
$hlavicka->g2b2b1nyg46nyg46="1234.56";
$hlavicka->g2b2c1nyg46nyg46="1234.56";
$hlavicka->g2b2d1nyg46nyg46="1234.56";
$hlavicka->g2b2e1nyg46nyg46="1234.56";
$hlavicka->g2b2f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b2a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b2b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b2c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b2d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b2e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b2f1","$rmc",1,"R");

if( $hlavicka->g2b3b1 == 0 ) $hlavicka->g2b3b1="";
if( $hlavicka->g2b3c1 == 0 ) $hlavicka->g2b3c1="";
if( $hlavicka->g2b3d1 == 0 ) $hlavicka->g2b3d1="";
if( $hlavicka->g2b3e1 == 0 ) $hlavicka->g2b3e1="";
if( $hlavicka->g2b3f1 == 0 ) $hlavicka->g2b3f1="";

$hlavicka->g2b3a1nyg46nyg46="1234.56";
$hlavicka->g2b3b1nyg46nyg46="1234.56";
$hlavicka->g2b3c1nyg46nyg46="1234.56";
$hlavicka->g2b3d1nyg46nyg46="1234.56";
$hlavicka->g2b3e1nyg46nyg46="1234.56";
$hlavicka->g2b3f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b3a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b3b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b3c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b3d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b3e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b3f1","$rmc",1,"R");

if( $hlavicka->g2b4b1 == 0 ) $hlavicka->g2b4b1="";
if( $hlavicka->g2b4c1 == 0 ) $hlavicka->g2b4c1="";
if( $hlavicka->g2b4d1 == 0 ) $hlavicka->g2b4d1="";
if( $hlavicka->g2b4e1 == 0 ) $hlavicka->g2b4e1="";
if( $hlavicka->g2b4f1 == 0 ) $hlavicka->g2b4f1="";

$hlavicka->g2b4a1nyg46nyg46="1234.56";
$hlavicka->g2b4b1nyg46nyg46="1234.56";
$hlavicka->g2b4c1nyg46nyg46="1234.56";
$hlavicka->g2b4d1nyg46nyg46="1234.56";
$hlavicka->g2b4e1nyg46nyg46="1234.56";
$hlavicka->g2b4f1nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b4a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b4b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b4c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b4d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b4e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b4f1","$rmc",1,"R");

if( $hlavicka->g2b5b1 == 0 ) $hlavicka->g2b5b1="";
if( $hlavicka->g2b5c1 == 0 ) $hlavicka->g2b5c1="";
if( $hlavicka->g2b5d1 == 0 ) $hlavicka->g2b5d1="";
if( $hlavicka->g2b5e1 == 0 ) $hlavicka->g2b5e1="";
if( $hlavicka->g2b5f1 == 0 ) $hlavicka->g2b5f1="";

$hlavicka->g2b5a1nyg46nyg46="1234.56";
$hlavicka->g2b5b1nyg46nyg46="1234.56";
$hlavicka->g2b5c1nyg46nyg46="1234.56";
$hlavicka->g2b5d1nyg46nyg46="1234.56";
$hlavicka->g2b5e1nyg46nyg46="1234.56";
$hlavicka->g2b5f1nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b5a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b5b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b5c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b5d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b5e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b5f1","$rmc",1,"R");

if( $hlavicka->g2b6b1 == 0 ) $hlavicka->g2b6b1="";
if( $hlavicka->g2b6c1 == 0 ) $hlavicka->g2b6c1="";
if( $hlavicka->g2b6d1 == 0 ) $hlavicka->g2b6d1="";
if( $hlavicka->g2b6e1 == 0 ) $hlavicka->g2b6e1="";
if( $hlavicka->g2b6f1 == 0 ) $hlavicka->g2b6f1="";

$hlavicka->g2b6a1nyg46nyg46="1234.56";
$hlavicka->g2b6b1nyg46nyg46="1234.56";
$hlavicka->g2b6c1nyg46nyg46="1234.56";
$hlavicka->g2b6d1nyg46nyg46="1234.56";
$hlavicka->g2b6e1nyg46nyg46="1234.56";
$hlavicka->g2b6f1nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b6a1","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b6b1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b6c1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b6d1","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b6e1","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b6f1","$rmc",1,"R");

if( $hlavicka->g2b1b2 == 0 ) $hlavicka->g2b1b2="";
if( $hlavicka->g2b1c2 == 0 ) $hlavicka->g2b1c2="";
if( $hlavicka->g2b1d2 == 0 ) $hlavicka->g2b1d2="";
if( $hlavicka->g2b1e2 == 0 ) $hlavicka->g2b1e2="";
if( $hlavicka->g2b1f2 == 0 ) $hlavicka->g2b1f2="";

$hlavicka->g2b1b2nyg46nyg46="1234.56";
$hlavicka->g2b1c2nyg46nyg46="1234.56";
$hlavicka->g2b1d2nyg46nyg46="1234.56";
$hlavicka->g2b1e2nyg46nyg46="1234.56";
$hlavicka->g2b1f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(56,5," ","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b1b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b1c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b1d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b1e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b1f2","$rmc",1,"R");

if( $hlavicka->g2b2b2 == 0 ) $hlavicka->g2b2b2="";
if( $hlavicka->g2b2c2 == 0 ) $hlavicka->g2b2c2="";
if( $hlavicka->g2b2d2 == 0 ) $hlavicka->g2b2d2="";
if( $hlavicka->g2b2e2 == 0 ) $hlavicka->g2b2e2="";
if( $hlavicka->g2b2f2 == 0 ) $hlavicka->g2b2f2="";


$hlavicka->g2b2a2nyg46nyg46="1234.56";
$hlavicka->g2b2b2nyg46nyg46="1234.56";
$hlavicka->g2b2c2nyg46nyg46="1234.56";
$hlavicka->g2b2d2nyg46nyg46="1234.56";
$hlavicka->g2b2e2nyg46nyg46="1234.56";
$hlavicka->g2b2f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b2a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b2b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b2c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b2d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b2e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b2f2","$rmc",1,"R");

if( $hlavicka->g2b3b2 == 0 ) $hlavicka->g2b3b2="";
if( $hlavicka->g2b3c2 == 0 ) $hlavicka->g2b3c2="";
if( $hlavicka->g2b3d2 == 0 ) $hlavicka->g2b3d2="";
if( $hlavicka->g2b3e2 == 0 ) $hlavicka->g2b3e2="";
if( $hlavicka->g2b3f2 == 0 ) $hlavicka->g2b3f2="";

$hlavicka->g2b3a2nyg46nyg46="1234.56";
$hlavicka->g2b3b2nyg46nyg46="1234.56";
$hlavicka->g2b3c2nyg46nyg46="1234.56";
$hlavicka->g2b3d2nyg46nyg46="1234.56";
$hlavicka->g2b3e2nyg46nyg46="1234.56";
$hlavicka->g2b3f2nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b3a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b3b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b3c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b3d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b3e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b3f2","$rmc",1,"R");

if( $hlavicka->g2b4b2 == 0 ) $hlavicka->g2b4b2="";
if( $hlavicka->g2b4c2 == 0 ) $hlavicka->g2b4c2="";
if( $hlavicka->g2b4d2 == 0 ) $hlavicka->g2b4d2="";
if( $hlavicka->g2b4e2 == 0 ) $hlavicka->g2b4e2="";
if( $hlavicka->g2b4f2 == 0 ) $hlavicka->g2b4f2="";

$hlavicka->g2b4a2nyg46nyg46="1234.56";
$hlavicka->g2b4b2nyg46nyg46="1234.56";
$hlavicka->g2b4c2nyg46nyg46="1234.56";
$hlavicka->g2b4d2nyg46nyg46="1234.56";
$hlavicka->g2b4e2nyg46nyg46="1234.56";
$hlavicka->g2b4f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b4a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b4b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b4c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b4d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b4e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b4f2","$rmc",1,"R");

if( $hlavicka->g2b5b2 == 0 ) $hlavicka->g2b5b2="";
if( $hlavicka->g2b5c2 == 0 ) $hlavicka->g2b5c2="";
if( $hlavicka->g2b5d2 == 0 ) $hlavicka->g2b5d2="";
if( $hlavicka->g2b5e2 == 0 ) $hlavicka->g2b5e2="";
if( $hlavicka->g2b5f2 == 0 ) $hlavicka->g2b5f2="";

$hlavicka->g2b5a2nyg46nyg46="1234.56";
$hlavicka->g2b5b2nyg46nyg46="1234.56";
$hlavicka->g2b5c2nyg46nyg46="1234.56";
$hlavicka->g2b5d2nyg46nyg46="1234.56";
$hlavicka->g2b5e2nyg46nyg46="1234.56";
$hlavicka->g2b5f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b5a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b5b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b5c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b5d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b5e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b5f2","$rmc",1,"R");

if( $hlavicka->g2b6b2 == 0 ) $hlavicka->g2b6b2="";
if( $hlavicka->g2b6c2 == 0 ) $hlavicka->g2b6c2="";
if( $hlavicka->g2b6d2 == 0 ) $hlavicka->g2b6d2="";
if( $hlavicka->g2b6e2 == 0 ) $hlavicka->g2b6e2="";
if( $hlavicka->g2b6f2 == 0 ) $hlavicka->g2b6f2="";

$hlavicka->g2b6a2nyg46nyg46="1234.56";
$hlavicka->g2b6b2nyg46nyg46="1234.56";
$hlavicka->g2b6c2nyg46nyg46="1234.56";
$hlavicka->g2b6d2nyg46nyg46="1234.56";
$hlavicka->g2b6e2nyg46nyg46="1234.56";
$hlavicka->g2b6f2nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b6a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b6b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b6c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b6d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b6e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b6f2","$rmc",1,"R");

if( $hlavicka->g2b7b2 == 0 ) $hlavicka->g2b7b2="";
if( $hlavicka->g2b7c2 == 0 ) $hlavicka->g2b7c2="";
if( $hlavicka->g2b7d2 == 0 ) $hlavicka->g2b7d2="";
if( $hlavicka->g2b7e2 == 0 ) $hlavicka->g2b7e2="";
if( $hlavicka->g2b7f2 == 0 ) $hlavicka->g2b7f2="";

$hlavicka->g2b7a2nyg46nyg46="1234.56";
$hlavicka->g2b7b2nyg46nyg46="1234.56";
$hlavicka->g2b7c2nyg46nyg46="1234.56";
$hlavicka->g2b7d2nyg46nyg46="1234.56";
$hlavicka->g2b7e2nyg46nyg46="1234.56";
$hlavicka->g2b7f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b7a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b7b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b7c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b7d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b7e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b7f2","$rmc",1,"R");

if( $hlavicka->g2b8b2 == 0 ) $hlavicka->g2b8b2="";
if( $hlavicka->g2b8c2 == 0 ) $hlavicka->g2b8c2="";
if( $hlavicka->g2b8d2 == 0 ) $hlavicka->g2b8d2="";
if( $hlavicka->g2b8e2 == 0 ) $hlavicka->g2b8e2="";
if( $hlavicka->g2b8f2 == 0 ) $hlavicka->g2b8f2="";

$hlavicka->g2b8a2nyg46nyg46="1234.56";
$hlavicka->g2b8b2nyg46nyg46="1234.56";
$hlavicka->g2b8c2nyg46nyg46="1234.56";
$hlavicka->g2b8d2nyg46nyg46="1234.56";
$hlavicka->g2b8e2nyg46nyg46="1234.56";
$hlavicka->g2b8f2nyg46nyg46="1234.56";


$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(44,5,"$hlavicka->g2b8a2","$rmc",0,"L");
$pdf->Cell(24,5,"$hlavicka->g2b8b2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->g2b8c2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b8d2","$rmc",0,"R");$pdf->Cell(24,5,"$hlavicka->g2b8e2","$rmc",0,"R");
$pdf->Cell(24,5,"$hlavicka->g2b8f2","$rmc",1,"R");


//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text5"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(28);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(15,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text6"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(206);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 23


}
$i = $i + 1;

  }


$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_po2011".$no."s3 WHERE psys >= 0 ".""; 

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


if ( $nopg24 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab26.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab26.jpg',0,20,210,70);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab27.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab27.jpg',0,140,210,80);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab27b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab27b.jpg',0,220,210,60);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,6,"                          ","$rmc1",1,"L");


//prva tabulka

$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"26. Informácie k èasti G písm. c) a d) prílohy è.3 o záväzkoch","$rmc",1,"L");
$pdf->Cell(90,13,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//26.info k casti G pism. c,d, prilohy c 3

if( $hlavicka->gcd11 == 0 ) $hlavicka->gcd11="";
if( $hlavicka->gcd12 == 0 ) $hlavicka->gcd12="";

$hlavicka->gcd11nyg46nyg46="1234.56";
$hlavicka->gcd12nyg46nyg46="1234.56";

$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd11","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd12","$rmc",1,"R");

if( $hlavicka->gcd21 == 0 ) $hlavicka->gcd21="";
if( $hlavicka->gcd22 == 0 ) $hlavicka->gcd22="";

$hlavicka->gcd21nyg46nyg46="1234.56";
$hlavicka->gcd22nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd21","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd22","$rmc",1,"R");


if( $hlavicka->gcd31 == 0 ) $hlavicka->gcd31="";
if( $hlavicka->gcd32 == 0 ) $hlavicka->gcd32="";

$hlavicka->gcd31nyg46nyg46="1234.56";
$hlavicka->gcd32nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd31","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd32","$rmc",1,"R");

if( $hlavicka->gcd41 == 0 ) $hlavicka->gcd41="";
if( $hlavicka->gcd42 == 0 ) $hlavicka->gcd42="";

$hlavicka->gcd41nyg46nyg46="1234.56";
$hlavicka->gcd42nyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd41","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd42","$rmc",1,"R");

if( $hlavicka->gcd51 == 0 ) $hlavicka->gcd51="";
if( $hlavicka->gcd52 == 0 ) $hlavicka->gcd52="";

$hlavicka->gcd51nyg46nyg46="1234.56";
$hlavicka->gcd52nyg46nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd51","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd52","$rmc",1,"R");


if( $hlavicka->gcd61 == 0 ) $hlavicka->gcd61="";
if( $hlavicka->gcd62 == 0 ) $hlavicka->gcd62="";

$hlavicka->gcd61nyg46nyg46="1234.56";
$hlavicka->gcd62nyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(68,5," ","$rmc",0,"L");
$pdf->Cell(54,5,"$hlavicka->gcd61","$rmc",0,"R");$pdf->Cell(54,5,"$hlavicka->gcd62","$rmc",1,"R");


//druha tabulka

$pdf->Cell(90,45,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"27. Informácie k èasti F písm. v) a èasti G písm. f) prílohy è.3 o odloenej daòovej poh¾adávke alebo o odloenom","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"daòovom záväzku","$rmc",1,"L");
$pdf->Cell(90,22,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//27.info k casti F pism. v,a casti G pism.f, prilohy c 3

if( $hlavicka->gf11 == 0 ) $hlavicka->gf11="";
if( $hlavicka->gf12 == 0 ) $hlavicka->gf12="";

$hlavicka->gf11nyg46nyg46="1234.56";
$hlavicka->gf12nyg46nyg46="1234.56";

$pdf->Cell(101,5," ","$rmc1",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf11","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf12","$rmc",1,"R");

if( $hlavicka->gf21 == 0 ) $hlavicka->gf21="";
if( $hlavicka->gf22 == 0 ) $hlavicka->gf22="";

$hlavicka->gf21nyg46nyg46="1234.56";
$hlavicka->gf22nyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf21","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf22","$rmc",1,"R");

if( $hlavicka->gf31 == 0 ) $hlavicka->gf31="";
if( $hlavicka->gf32 == 0 ) $hlavicka->gf32="";

$hlavicka->gf31nyg46nyg46="1234.56";
$hlavicka->gf32nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf31","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf32","$rmc",1,"R");

if( $hlavicka->gf41 == 0 ) $hlavicka->gf41="";
if( $hlavicka->gf42 == 0 ) $hlavicka->gf42="";

$hlavicka->gf41nyg46nyg46="1234.56";
$hlavicka->gf42nyg46nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf41","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf42","$rmc",1,"R");

if( $hlavicka->gf51 == 0 ) $hlavicka->gf51="";
if( $hlavicka->gf52 == 0 ) $hlavicka->gf52="";

$hlavicka->gf51nyg46nyg46="1234.56";
$hlavicka->gf52nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc1",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf51","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf52","$rmc",1,"R");


if( $hlavicka->gf61 == 0 ) $hlavicka->gf61="";
if( $hlavicka->gf62 == 0 ) $hlavicka->gf62="";

$hlavicka->gf61nyg46nyg46="1234.56";
$hlavicka->gf62nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf61","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf62","$rmc",1,"R");

if( $hlavicka->gf71 == 0 ) $hlavicka->gf71="";
if( $hlavicka->gf72 == 0 ) $hlavicka->gf72="";

$hlavicka->gf71nyg46nyg46="1234.56";
$hlavicka->gf72nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf71","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf72","$rmc",1,"R");

if( $hlavicka->gf81 == 0 ) $hlavicka->gf81="";
if( $hlavicka->gf82 == 0 ) $hlavicka->gf82="";

$hlavicka->gf81nyg46nyg46="1234.56";
$hlavicka->gf82nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf81","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf82","$rmc",1,"R");

if( $hlavicka->gf91 == 0 ) $hlavicka->gf91="";
if( $hlavicka->gf92 == 0 ) $hlavicka->gf92="";

$hlavicka->gf91nyg46nyg46="1234.56";
$hlavicka->gf92nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf91","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf92","$rmc",1,"R");

if( $hlavicka->fv11 == 0 ) $hlavicka->fv11="";
if( $hlavicka->fv12 == 0 ) $hlavicka->fv12="";

$hlavicka->fv11nyg46nyg46="1234.56";
$hlavicka->fv12nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->fv11","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fv12","$rmc",1,"R");

if( $hlavicka->fv21 == 0 ) $hlavicka->fv21="";
if( $hlavicka->fv22 == 0 ) $hlavicka->fv22="";

$hlavicka->fv21nyg46nyg46="1234.56";
$hlavicka->fv22nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->fv21","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fv22","$rmc",1,"R");

if( $hlavicka->fv31 == 0 ) $hlavicka->fv31="";
if( $hlavicka->fv32 == 0 ) $hlavicka->fv32="";

$hlavicka->fv31nyg46nyg46="1234.56";
$hlavicka->fv32nyg46nyg46="1234.56";

$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->fv31","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fv32","$rmc",1,"R");

if( $hlavicka->fv41 == 0 ) $hlavicka->fv41="";
if( $hlavicka->fv42 == 0 ) $hlavicka->fv42="";

$hlavicka->fv41nyg46nyg46="1234.56";
$hlavicka->fv42nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->fv41","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->fv42","$rmc",1,"R");

if( $hlavicka->gf101 == 0 ) $hlavicka->gf101="";
if( $hlavicka->gf102 == 0 ) $hlavicka->gf102="";

$hlavicka->gf101nyg46nyg46="1234.56";
$hlavicka->gf102nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf101","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf102","$rmc",1,"R");

if( $hlavicka->gf111 == 0 ) $hlavicka->gf111="";
if( $hlavicka->gf112 == 0 ) $hlavicka->gf112="";

$hlavicka->gf111nyg46nyg46="1234.56";
$hlavicka->gf112nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,5,"$hlavicka->gf111","$rmc",0,"R");$pdf->Cell(37,5,"$hlavicka->gf112","$rmc",1,"R");

if( $hlavicka->gf121 == 0 ) $hlavicka->gf121="";
if( $hlavicka->gf122 == 0 ) $hlavicka->gf122="";

$hlavicka->gf121nyg46nyg46="1234.56";
$hlavicka->gf122nyg46nyg46="1234.56";

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,6,"$hlavicka->gf121","$rmc",0,"R");$pdf->Cell(37,6,"$hlavicka->gf122","$rmc",1,"R");

if( $hlavicka->gf131 == 0 ) $hlavicka->gf131="";
if( $hlavicka->gf132 == 0 ) $hlavicka->gf132="";

$hlavicka->gf131nyg46nyg46="1234.56";
$hlavicka->gf132nyg46nyg46="1234.56";

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,6,"$hlavicka->gf131","$rmc",0,"R");$pdf->Cell(37,6,"$hlavicka->gf132","$rmc",1,"R");

if( $gf141 == 0 ) $gf141="";
if( $gf142 == 0 ) $gf142="";

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(101,5," ","$rmc",0,"L");
$pdf->Cell(39,6,"$gf141","$rmc",0,"R");$pdf->Cell(37,6,"$gf142","$rmc",1,"R");


//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text7"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(91);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 24

if ( $nopg25 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab28.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab28.jpg',0,80,210,65);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab29.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab29.jpg',0,210,210,40);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//prva tabulka

$pdf->Cell(90,57,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"28. Informácie k èasti G písm. g) prílohy è.3 o záväzkoch zo sociálneho fondu","$rmc",1,"L");
$pdf->Cell(90,14,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//28.info k casti G pism. g, prilohy c 3

if( $hlavicka->gg11 == 0 ) $hlavicka->gg11="";
if( $hlavicka->gg12 == 0 ) $hlavicka->gg12="";

$hlavicka->gg11nyg46nyg46="1234.56";
$hlavicka->gg12nyg46nyg46="1234.56";

$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg11","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg12","$rmc",1,"R");

if( $hlavicka->gg21 == 0 ) $hlavicka->gg21="";
if( $hlavicka->gg22 == 0 ) $hlavicka->gg22="";

$hlavicka->gg21nyg46nyg46="1234.56";
$hlavicka->gg22nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg21","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg22","$rmc",1,"R");

if( $hlavicka->gg31 == 0 ) $hlavicka->gg31="";
if( $hlavicka->gg32 == 0 ) $hlavicka->gg32="";

$hlavicka->gg31nyg46nyg46="1234.56";
$hlavicka->gg32nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg31","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg32","$rmc",1,"R");

if( $hlavicka->gg41 == 0 ) $hlavicka->gg41="";
if( $hlavicka->gg42 == 0 ) $hlavicka->gg42="";

$hlavicka->gg41nyg46nyg46="1234.56";
$hlavicka->gg42nyg46nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg41","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg42","$rmc",1,"R");

if( $hlavicka->gg51 == 0 ) $hlavicka->gg51="";
if( $hlavicka->gg52 == 0 ) $hlavicka->gg52="";

$hlavicka->gg51nyg46nyg46="1234.56";
$hlavicka->gg52nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg51","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg52","$rmc",1,"R");

if( $hlavicka->gg61 == 0 ) $hlavicka->gg61="";
if( $hlavicka->gg62 == 0 ) $hlavicka->gg62="";

$hlavicka->gg61nyg46nyg46="1234.56";
$hlavicka->gg62nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg61","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg62","$rmc",1,"R");

if( $hlavicka->gg71 == 0 ) $hlavicka->gg71="";
if( $hlavicka->gg72 == 0 ) $hlavicka->gg72="";

$hlavicka->gg71nyg46nyg46="1234.56";
$hlavicka->gg72nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(72,5," ","$rmc",0,"L");
$pdf->Cell(52,5,"$hlavicka->gg71","$rmc",0,"R");$pdf->Cell(52,5,"$hlavicka->gg72","$rmc",1,"R");



//druha tabulka
$pdf->Cell(90,64,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"29. Informácie k èasti G písm. h) prílohy è.3 o vydanıch dlhopisoch","$rmc",1,"L");
$pdf->Cell(90,11,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//29.info k casti G pism. h, prilohy c 

if( $hlavicka->gh12 == 0 ) $hlavicka->gh12="";
if( $hlavicka->gh13 == 0 ) $hlavicka->gh13="";
if( $hlavicka->gh14 == 0 ) $hlavicka->gh14="";
if( $hlavicka->gh15 == 0 ) $hlavicka->gh15="";

$hlavicka->gh11nyg46nyg46="1234.56";
$hlavicka->gh12nyg46nyg46="1234.56";
$hlavicka->gh13nyg46nyg46="1234.56";
$hlavicka->gh14nyg46nyg46="1234.56";
$hlavicka->gh15nyg46nyg46="1234.56";
$hlavicka->gh16nyg46nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh11","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh12","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh13","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh14","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh15","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh16","$rmc",1,"L");

if( $hlavicka->gh22 == 0 ) $hlavicka->gh22="";
if( $hlavicka->gh23 == 0 ) $hlavicka->gh23="";
if( $hlavicka->gh24 == 0 ) $hlavicka->gh24="";
if( $hlavicka->gh25 == 0 ) $hlavicka->gh25="";

$hlavicka->gh21nyg46nyg46="1234.56";
$hlavicka->gh22nyg46nyg46="1234.56";
$hlavicka->gh23nyg46nyg46="1234.56";
$hlavicka->gh24nyg46nyg46="1234.56";
$hlavicka->gh25nyg46nyg46="1234.56";
$hlavicka->gh26nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh21","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh22","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh23","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh24","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh25","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh26","$rmc",1,"L");

if( $hlavicka->gh32 == 0 ) $hlavicka->gh32="";
if( $hlavicka->gh33 == 0 ) $hlavicka->gh33="";
if( $hlavicka->gh34 == 0 ) $hlavicka->gh34="";
if( $hlavicka->gh35 == 0 ) $hlavicka->gh35="";

$hlavicka->gh31nyg46nyg46="1234.56";
$hlavicka->gh32nyg46nyg46="1234.56";
$hlavicka->gh33nyg46nyg46="1234.56";
$hlavicka->gh34nyg46nyg46="1234.56";
$hlavicka->gh35nyg46nyg46="1234.56";
$hlavicka->gh36nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh31","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh32","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh33","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh34","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh35","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh36","$rmc",1,"L");

if( $hlavicka->gh42 == 0 ) $hlavicka->gh42="";
if( $hlavicka->gh43 == 0 ) $hlavicka->gh43="";
if( $hlavicka->gh44 == 0 ) $hlavicka->gh44="";
if( $hlavicka->gh45 == 0 ) $hlavicka->gh45="";

$hlavicka->gh41nyg46nyg46="1234.56";
$hlavicka->gh42nyg46nyg46="1234.56";
$hlavicka->gh43nyg46nyg46="1234.56";
$hlavicka->gh44nyg46nyg46="1234.56";
$hlavicka->gh45nyg46nyg46="1234.56";
$hlavicka->gh46nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(27,5,"$hlavicka->gh41","$rmc",0,"L");
$pdf->Cell(28,5,"$hlavicka->gh42","$rmc",0,"R");$pdf->Cell(27,5,"$hlavicka->gh43","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh44","$rmc",0,"R");$pdf->Cell(28,5,"$hlavicka->gh45","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->gh46","$rmc",1,"L");



//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text8"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(17);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text9"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(146);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text10"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(251);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 25

if ( $nopg26 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab30_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab30_1.jpg',0,30,210,37);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab30_1b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab30_1b.jpg',0,67,210,46);
}

if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab30_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab30_2.jpg',0,172,210,104);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,10,"                          ","$rmc1",1,"L");



//prva tabulka

$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"30. Informácie k èasti G písm. i) prílohy è.3 o banovıch úveroch, pôièkách a krátkodobıch finanènıch vıpomociach","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");

$pdf->Cell(90,43,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//30.info k casti G pism. i, prilohy c 3
if( $hlavicka->g1i1c1 == 0 ) $hlavicka->g1i1c1="";
if( $hlavicka->g1i1d1 == 0 ) $hlavicka->g1i1d1="";
if( $hlavicka->g1i1e1 == 0 ) $hlavicka->g1i1e1="";
if( $g1i1e1eur == 0 ) $g1i1e1eur="";
if( $hlavicka->g1i1f1 == 0 ) $hlavicka->g1i1f1="";

$hlavicka->g1i1a1nyg46nyg46="1234.56";
$hlavicka->g1i1b1nyg46nyg46="1234.56";
$hlavicka->g1i1c1nyg46nyg46="1234.56";
$hlavicka->g1i1d1nyg46nyg46="1234.56";
$hlavicka->g1i1e1nyg46nyg46="1234.56";
$hlavicka->g1i1f1nyg46nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g1i1a1","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g1i1b1","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g1i1c1","$rmc",0,"R");
$g1i1d1sk = SkDatum($hlavicka->g1i1d1);
if( $g1i1d1sk == '00.00.0000' ) $g1i1d1sk="";
$pdf->Cell(23,5,"$g1i1d1sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g1i1e1","$rmc",0,"R");$pdf->Cell(20,5,"$g1i1e1eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g1i1f1","$rmc",1,"R");

if( $hlavicka->g1i2c1 == 0 ) $hlavicka->g1i2c1="";
if( $hlavicka->g1i2d1 == 0 ) $hlavicka->g1i2d1="";
if( $hlavicka->g1i2e1 == 0 ) $hlavicka->g1i2e1="";
if( $g1i2e1eur == 0 ) $g1i2e1eur="";
if( $hlavicka->g1i2f1 == 0 ) $hlavicka->g1i2f1="";

$hlavicka->g1i2a1nyg46nyg46="1234.56";
$hlavicka->g1i2b1nyg46nyg46="1234.56";
$hlavicka->g1i2c1nyg46nyg46="1234.56";
$hlavicka->g1i2d1nyg46nyg46="1234.56";
$hlavicka->g1i2e1nyg46nyg46="1234.56";
$hlavicka->g1i2f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g1i2a1","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g1i2b1","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g1i2c1","$rmc",0,"R");
$g1i2d1sk = SkDatum($hlavicka->g1i2d1);
if( $g1i2d1sk == '00.00.0000' ) $g1i2d1sk="";
$pdf->Cell(23,5,"$g1i2d1sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g1i2e1","$rmc",0,"R");$pdf->Cell(20,5,"$g1i2e1eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g1i2f1","$rmc",1,"R");

if( $hlavicka->g1i3c1 == 0 ) $hlavicka->g1i3c1="";
if( $hlavicka->g1i3d1 == 0 ) $hlavicka->g1i3d1="";
if( $hlavicka->g1i3e1 == 0 ) $hlavicka->g1i3e1="";
if( $g1i3e1eur == 0 ) $g1i3e1eur="";
if( $hlavicka->g1i3f1 == 0 ) $hlavicka->g1i3f1="";

$hlavicka->g1i3a1nyg46nyg46="1234.56";
$hlavicka->g1i3b1nyg46nyg46="1234.56";
$hlavicka->g1i3c1nyg46nyg46="1234.56";
$hlavicka->g1i3d1nyg46nyg46="1234.56";
$hlavicka->g1i3e1nyg46nyg46="1234.56";
$hlavicka->g1i3f1nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g1i3a1","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g1i3b1","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g1i3c1","$rmc",0,"R");
$g1i3d1sk = SkDatum($hlavicka->g1i3d1);
if( $g1i3d1sk == '00.00.0000' ) $g1i3d1sk="";
$pdf->Cell(23,5,"$g1i3d1sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g1i3e1","$rmc",0,"R");$pdf->Cell(20,5,"$g1i3e1eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g1i3f1","$rmc",1,"R");

if( $hlavicka->g1i1c2 == 0 ) $hlavicka->g1i1c2="";
if( $hlavicka->g1i1d2 == 0 ) $hlavicka->g1i1d2="";
if( $hlavicka->g1i1e2 == 0 ) $hlavicka->g1i1e2="";
if( $g1i1e2eur == 0 ) $g1i1e2eur="";
if( $hlavicka->g1i1f2 == 0 ) $hlavicka->g1i1f2="";

$hlavicka->g1i1a2nyg46nyg46="1234.56";
$hlavicka->g1i1b2nyg46nyg46="1234.56";
$hlavicka->g1i1c2nyg46nyg46="1234.56";
$hlavicka->g1i1d2nyg46nyg46="1234.56";
$hlavicka->g1i1e2nyg46nyg46="1234.56";
$hlavicka->g1i1f2nyg46nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g1i1a2","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g1i1b2","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g1i1c2","$rmc",0,"R");
$g1i1d2sk = SkDatum($hlavicka->g1i1d2);
if( $g1i1d2sk == '00.00.0000' ) $g1i1d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g1i1d2sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g1i1e2","$rmc",0,"R");$pdf->Cell(20,5,"$g1i1e2eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g1i1f2","$rmc",1,"R");

if( $hlavicka->g1i2c2 == 0 ) $hlavicka->g1i2c2="";
if( $hlavicka->g1i2d2 == 0 ) $hlavicka->g1i2d2="";
if( $hlavicka->g1i2e2 == 0 ) $hlavicka->g1i2e2="";
if( $g1i2e2eur == 0 ) $g1i2e2eur="";
if( $hlavicka->g1i2f2 == 0 ) $hlavicka->g1i2f2="";

$hlavicka->g1i2a2nyg46nyg46="1234.56";
$hlavicka->g1i2b2nyg46nyg46="1234.56";
$hlavicka->g1i2c2nyg46nyg46="1234.56";
$hlavicka->g1i2d2nyg46nyg46="1234.56";
$hlavicka->g1i2e2nyg46nyg46="1234.56";
$hlavicka->g1i2f2nyg46nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g1i2a2","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g1i2b2","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g1i2c2","$rmc",0,"R");
$g1i2d2sk = SkDatum($hlavicka->g1i2d2);
if( $g1i2d2sk == '00.00.0000' ) $g1i2d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g1i2d2sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g1i2e2","$rmc",0,"R");$pdf->Cell(20,5,"$g1i2e2eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g1i2f2","$rmc",1,"R");

if( $hlavicka->g1i3c2 == 0 ) $hlavicka->g1i3c2="";
if( $hlavicka->g1i3d2 == 0 ) $hlavicka->g1i3d2="";
if( $hlavicka->g1i3e2 == 0 ) $hlavicka->g1i3e2="";
if( $g1i3e2eur == 0 ) $g1i3e2eur="";
if( $hlavicka->g1i3f2 == 0 ) $hlavicka->g1i3f2="";

$hlavicka->g1i3a2nyg46nyg46="1234.56";
$hlavicka->g1i3b2nyg46nyg46="1234.56";
$hlavicka->g1i3c2nyg46nyg46="1234.56";
$hlavicka->g1i3d2nyg46nyg46="1234.56";
$hlavicka->g1i3e2nyg46nyg46="1234.56";
$hlavicka->g1i3f2nyg46nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g1i3a2","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g1i3b2","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g1i3c2","$rmc",0,"R");
$g1i3d2sk = SkDatum($hlavicka->g1i3d2);
if( $g1i3d2sk == '00.00.0000' ) $g1i3d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g1i3d2sk","$rmc",0,"C");
$pdf->Cell(20,5,"$hlavicka->g1i3e2","$rmc",0,"R");$pdf->Cell(25,5,"$g1i3e2eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g1i3f2","$rmc",1,"R");



//druha tabulka

$pdf->Cell(90,55,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2","$rmc",1,"L");
$pdf->Cell(90,41,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka 30 c 2 dlhodobe pozicky

if( $hlavicka->g2i1c1 == 0 ) $hlavicka->g2i1c1="";
if( $hlavicka->g2i1d1 == 0 ) $hlavicka->g2i1d1="";
if( $hlavicka->g2i1e1 == 0 ) $hlavicka->g2i1e1="";
if( $g2i1e1eur == 0 ) $g2i1e1eur="";
if( $hlavicka->g2i1f1 == 0 ) $hlavicka->g2i1f1="";

$hlavicka->g2i1a1nyg46="1234.56";
$hlavicka->g2i1b1nyg46="1234.56";
$hlavicka->g2i1c1nyg46="1234.56";
$hlavicka->g2i1d1nyg46="1234.56";
$hlavicka->g2i1e1nyg46="1234.56";
$hlavicka->g2i1f1nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i1a1","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i1b1","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i1c1","$rmc",0,"R");
$g2i1d1sk = SkDatum($hlavicka->g2i1d1);
if( $g2i1d1sk == '00.00.0000' ) $g2i1d1sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i1d1sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i1e1","$rmc",0,"R");$pdf->Cell(20,5,"$g2i1e1eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i1f1","$rmc",1,"R");

if( $hlavicka->g2i2c1 == 0 ) $hlavicka->g2i2c1="";
if( $hlavicka->g2i2d1 == 0 ) $hlavicka->g2i2d1="";
if( $hlavicka->g2i2e1 == 0 ) $hlavicka->g2i2e1="";
if( $g2i2e1eur == 0 ) $g2i2e1eur="";
if( $hlavicka->g2i2f1 == 0 ) $hlavicka->g2i2f1="";

$hlavicka->g2i2a1nyg46="1234.56";
$hlavicka->g2i2b1nyg46="1234.56";
$hlavicka->g2i2c1nyg46="1234.56";
$hlavicka->g2i2d1nyg46="1234.56";
$hlavicka->g2i2e1nyg46="1234.56";
$hlavicka->g2i2f1nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i2a1","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i2b1","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i2c1","$rmc",0,"R");
$g2i2d1sk = SkDatum($hlavicka->g2i2d1);
if( $g2i2d1sk == '00.00.0000' ) $g2i2d1sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i2d1sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i2e1","$rmc",0,"R");$pdf->Cell(20,5,"$g2i2e1eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i2f1","$rmc",1,"R");

if( $hlavicka->g2i3c1 == 0 ) $hlavicka->g2i3c1="";
if( $hlavicka->g2i3d1 == 0 ) $hlavicka->g2i3d1="";
if( $hlavicka->g2i3e1 == 0 ) $hlavicka->g2i3e1="";
if( $g2i3e1eur == 0 ) $g2i3e1eur="";
if( $hlavicka->g2i3f1 == 0 ) $hlavicka->g2i3f1="";

$hlavicka->g2i3a1nyg46="1234.56";
$hlavicka->g2i3b1nyg46="1234.56";
$hlavicka->g2i3c1nyg46="1234.56";
$hlavicka->g2i3d1nyg46="1234.56";
$hlavicka->g2i3e1nyg46="1234.56";
$hlavicka->g2i3f1nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i3a1","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i3b1","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i3c1","$rmc",0,"R");
$g2i3d1sk = SkDatum($hlavicka->g2i3d1);
if( $g2i3d1sk == '00.00.0000' ) $g2i3d1sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i3d1sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i3e1","$rmc",0,"R");$pdf->Cell(20,5,"$g2i3e1eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i3f1","$rmc",1,"R");

//Kratkodobe pozicky

if( $hlavicka->g2i1c2 == 0 ) $hlavicka->g2i1c2="";
if( $hlavicka->g2i1d2 == 0 ) $hlavicka->g2i1d2="";
if( $hlavicka->g2i1e2 == 0 ) $hlavicka->g2i1e2="";
if( $g2i1e2eur == 0 ) $g2i1e2eur="";
if( $hlavicka->g2i1f2 == 0 ) $hlavicka->g2i1f2="";

$hlavicka->g2i1a2nyg46="1234.56";
$hlavicka->g2i1b2nyg46="1234.56";
$hlavicka->g2i1c2nyg46="1234.56";
$hlavicka->g2i1d2nyg46="1234.56";
$hlavicka->g2i1e2nyg46="1234.56";
$hlavicka->g2i1f2nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i1a2","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i1b2","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i1c2","$rmc",0,"R");
$g2i1d2sk = SkDatum($hlavicka->g2i1d2);
if( $g2i1d2sk == '00.00.0000' ) $g2i1d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i1d2sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i1e2","$rmc",0,"R");$pdf->Cell(20,5,"$g2i1e2eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i1f2","$rmc",1,"R");

if( $hlavicka->g2i2c2 == 0 ) $hlavicka->g2i2c2="";
if( $hlavicka->g2i2d2 == 0 ) $hlavicka->g2i2d2="";
if( $hlavicka->g2i2e2 == 0 ) $hlavicka->g2i2e2="";
if( $g2i2e2eur == 0 ) $g2i2e2eur="";
if( $hlavicka->g2i2f2 == 0 ) $hlavicka->g2i2f2="";

$hlavicka->g2i2a2nyg46="1234.56";
$hlavicka->g2i2b2nyg46="1234.56";
$hlavicka->g2i2c2nyg46="1234.56";
$hlavicka->g2i2d2nyg46="1234.56";
$hlavicka->g2i2e2nyg46="1234.56";
$hlavicka->g2i2f2nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i2a2","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i2b2","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i2c2","$rmc",0,"R");
$g2i2d2sk = SkDatum($hlavicka->g2i2d2);
if( $g2i2d2sk == '00.00.0000' ) $g2i2d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i2d2sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i2e2","$rmc",0,"R");$pdf->Cell(20,5,"$g2i2e2eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i2f2","$rmc",1,"R");

if( $hlavicka->g2i3c2 == 0 ) $hlavicka->g2i3c2="";
if( $hlavicka->g2i3d2 == 0 ) $hlavicka->g2i3d2="";
if( $hlavicka->g2i3e2 == 0 ) $hlavicka->g2i3e2="";
if( $g2i3e2eur == 0 ) $g2i3e2eur="";
if( $hlavicka->g2i3f2 == 0 ) $hlavicka->g2i3f2="";

$hlavicka->g2i3a2nyg46="1234.56";
$hlavicka->g2i3b2nyg46="1234.56";
$hlavicka->g2i3c2nyg46="1234.56";
$hlavicka->g2i3d2nyg46="1234.56";
$hlavicka->g2i3e2nyg46="1234.56";
$hlavicka->g2i3f2nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i3a2","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i3b2","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i3c2","$rmc",0,"R");
$g2i3d2sk = SkDatum($hlavicka->g2i3d2);
if( $g2i3d2sk == '00.00.0000' ) $g2i3d2sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i3d2sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i3e2","$rmc",0,"R");$pdf->Cell(20,5,"$g2i3e2eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i3f2","$rmc",1,"R");

//Kratkodobe financne vypomoci

if( $hlavicka->g2i1c3 == 0 ) $hlavicka->g2i1c3="";
if( $hlavicka->g2i1d3 == 0 ) $hlavicka->g2i1d3="";
if( $hlavicka->g2i1e3 == 0 ) $hlavicka->g2i1e3="";
if( $g2i1e3eur == 0 ) $g2i1e3eur="";
if( $hlavicka->g2i1f3 == 0 ) $hlavicka->g2i1f3="";

$hlavicka->g2i1a3nyg46="1234.56";
$hlavicka->g2i1b3nyg46="1234.56";
$hlavicka->g2i1c3nyg46="1234.56";
$hlavicka->g2i1d3nyg46="1234.56";
$hlavicka->g2i1e3nyg46="1234.56";
$hlavicka->g2i1f3nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i1a3","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i1b3","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i1c3","$rmc",0,"R");
$g2i1d3sk = SkDatum($hlavicka->g2i1d3);
if( $g2i1d3sk == '00.00.0000' ) $g2i1d3sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i1d3sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i1e3","$rmc",0,"R");$pdf->Cell(20,5,"$g2i1e3eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i1f3","$rmc",1,"R");

if( $hlavicka->g2i2c3 == 0 ) $hlavicka->g2i2c3="";
if( $hlavicka->g2i2d3 == 0 ) $hlavicka->g2i2d3="";
if( $hlavicka->g2i2e3 == 0 ) $hlavicka->g2i2e3="";
if( $g2i2e3eur == 0 ) $g2i2e3eur="";
if( $hlavicka->g2i2f3 == 0 ) $hlavicka->g2i2f3="";

$hlavicka->g2i2a3nyg46="1234.56";
$hlavicka->g2i2b3nyg46="1234.56";
$hlavicka->g2i2c3nyg46="1234.56";
$hlavicka->g2i2d3nyg46="1234.56";
$hlavicka->g2i2e3nyg46="1234.56";
$hlavicka->g2i2f3nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(39,5,"$hlavicka->g2i2a3","$rmc",0,"L");
$pdf->Cell(15,5,"$hlavicka->g2i2b3","$rmc",0,"L");$pdf->Cell(15,5,"$hlavicka->g2i2c3","$rmc",0,"R");
$g2i2d3sk = SkDatum($hlavicka->g2i2d3);
if( $g2i2d3sk == '00.00.0000' ) $g2i2d3sk="";
$pdf->SetFont('arial','',8);
$pdf->Cell(23,5,"$g2i2d3sk","$rmc",0,"C");
$pdf->Cell(25,5,"$hlavicka->g2i2e3","$rmc",0,"R");$pdf->Cell(20,5,"$g2i2e3eur","$rmc",0,"R");
$pdf->Cell(27,5,"$hlavicka->g2i2f3","$rmc",1,"R");






//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text11"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(114);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text12"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(275);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 26

if ( $nopg27 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab31.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab31.jpg',0,28,210,115);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab32_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab32_1.jpg',0,200,210,101);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,13,"                          ","$rmc1",1,"L");



//prva tabulka

$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"31. Informácie k èasti G písm. j) prílohy è.3 o vıznamnıch polokách èasového rozlíšenia na strane pasív","$rmc",1,"L");
$pdf->Cell(90,13,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka31 G, Casove rozlisenie

if( $hlavicka->g1j12 == 0 ) $hlavicka->g1j12="";
if( $hlavicka->g1j13 == 0 ) $hlavicka->g1j13="";

$hlavicka->g1j12nyg46="1234.56";
$hlavicka->g1j13nyg46="1234.56";

$pdf->Cell(84,5," ","$rmc",0,"L");$pdf->Cell(46,5,"$hlavicka->g1j12","$rmc",0,"R");
$pdf->Cell(46,5,"$hlavicka->g1j13","$rmc",1,"R");

if( $hlavicka->g1j22 == 0 ) $hlavicka->g1j22="";
if( $hlavicka->g1j23 == 0 ) $hlavicka->g1j23="";

$hlavicka->g1j21nyg46="1234.56";
$hlavicka->g1j22nyg46="1234.56";
$hlavicka->g1j23nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g1j21","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g1j22","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g1j23","$rmc",1,"R");

if( $hlavicka->g1j32 == 0 ) $hlavicka->g1j32="";
if( $hlavicka->g1j33 == 0 ) $hlavicka->g1j33="";

$hlavicka->g1j31nyg46="1234.56";
$hlavicka->g1j32nyg46="1234.56";
$hlavicka->g1j33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g1j31","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g1j32","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g1j33","$rmc",1,"R");

if( $hlavicka->g2j12 == 0 ) $hlavicka->g2j12="";
if( $hlavicka->g2j13 == 0 ) $hlavicka->g2j13="";

$hlavicka->g2j12nyg46="1234.56";
$hlavicka->g2j13nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(84,5," ","$rmc",0,"L");$pdf->Cell(46,5,"$hlavicka->g2j12","$rmc",0,"R");
$pdf->Cell(46,5,"$hlavicka->g2j13","$rmc",1,"R");

//if( $hlavicka->g2j21 == 0 ) $hlavicka->g2j21="";
if( $hlavicka->g2j22 == 0 ) $hlavicka->g2j22="";
if( $hlavicka->g2j23 == 0 ) $hlavicka->g2j23="";

$hlavicka->g2j21nyg46="1234.56";
$hlavicka->g2j22nyg46="1234.56";
$hlavicka->g2j23nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g2j21","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g2j22","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g2j23","$rmc",1,"R");

if( $hlavicka->g2j32 == 0 ) $hlavicka->g2j32="";
if( $hlavicka->g2j33 == 0 ) $hlavicka->g2j33="";

$hlavicka->g2j31nyg46="1234.56";
$hlavicka->g2j32nyg46="1234.56";
$hlavicka->g2j33nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g2j31","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g2j32","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g2j33","$rmc",1,"R");

if( $hlavicka->g3j12 == 0 ) $hlavicka->g3j12="";
if( $hlavicka->g3j13 == 0 ) $hlavicka->g3j13="";

$hlavicka->g3j12nyg46="1234.56";
$hlavicka->g3j13nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(84,5," ","$rmc",0,"L");$pdf->Cell(46,5,"$hlavicka->g3j12","$rmc",0,"R");
$pdf->Cell(46,5,"$hlavicka->g3j13","$rmc",1,"R");

if( $hlavicka->g3j22 == 0 ) $hlavicka->g3j22="";
if( $hlavicka->g3j23 == 0 ) $hlavicka->g3j23="";

$hlavicka->g3j21nyg46="1234.56";
$hlavicka->g3j22nyg46="1234.56";
$hlavicka->g3j23nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g3j21","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g3j22","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g3j23","$rmc",1,"R");

if( $hlavicka->g3j32 == 0 ) $hlavicka->g3j32="";
if( $hlavicka->g3j33 == 0 ) $hlavicka->g3j33="";

$hlavicka->g3j31nyg46="1234.56";
$hlavicka->g3j32nyg46="1234.56";
$hlavicka->g3j33nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g3j31","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g3j32","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g3j33","$rmc",1,"R");

if( $hlavicka->g3j42 == 0 ) $hlavicka->g3j42="";
if( $hlavicka->g3j43 == 0 ) $hlavicka->g3j43="";

$hlavicka->g3j41nyg46="1234.56";
$hlavicka->g3j42nyg46="1234.56";
$hlavicka->g3j43nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g3j41","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g3j42","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g3j43","$rmc",1,"R");

if( $hlavicka->g4j12 == 0 ) $hlavicka->g4j12="";
if( $hlavicka->g4j13 == 0 ) $hlavicka->g4j13="";

$hlavicka->g4j12nyg46="1234.56";
$hlavicka->g4j13nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(84,5," ","$rmc",0,"L");$pdf->Cell(46,5,"$hlavicka->g4j12","$rmc",0,"R");
$pdf->Cell(46,5,"$hlavicka->g4j13","$rmc",1,"R");

if( $hlavicka->g4j22 == 0 ) $hlavicka->g4j22="";
if( $hlavicka->g4j23 == 0 ) $hlavicka->g4j23="";

$hlavicka->g4j21nyg46="1234.56";
$hlavicka->g4j22nyg46="1234.56";
$hlavicka->g4j23nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g4j21","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g4j22","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g4j23","$rmc",1,"R");

if( $hlavicka->g4j32 == 0 ) $hlavicka->g4j32="";
if( $hlavicka->g4j33 == 0 ) $hlavicka->g4j33="";

$hlavicka->g4j31nyg46="1234.56";
$hlavicka->g4j32nyg46="1234.56";
$hlavicka->g4j33nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g4j31","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g4j32","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g4j33","$rmc",1,"R");

if( $hlavicka->g4j42 == 0 ) $hlavicka->g4j42="";
if( $hlavicka->g4j43 == 0 ) $hlavicka->g4j43="";

$hlavicka->g4j41nyg46="1234.56";
$hlavicka->g4j42nyg46="1234.56";
$hlavicka->g4j43nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g4j41","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g4j42","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g4j43","$rmc",1,"R");

if( $hlavicka->g4j52 == 0 ) $hlavicka->g4j52="";
if( $hlavicka->g4j53 == 0 ) $hlavicka->g4j53="";

$hlavicka->g4j51nyg46="1234.56";
$hlavicka->g4j52nyg46="1234.56";
$hlavicka->g4j53nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(71,5,"$hlavicka->g4j51","$rmc",0,"L");
$pdf->Cell(46,5,"$hlavicka->g4j52","$rmc",0,"R");$pdf->Cell(46,5,"$hlavicka->g4j53","$rmc",1,"R");






//druha tabulka

$pdf->Cell(90,53,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"32. Informácie k èasti G písm. k) prílohy è.3 o vıznamnıch polokách derivátov za bené úètovné obdobie","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");
$pdf->Cell(90,22,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka32 c.1 Gk

if( $hlavicka->g1k1b1 == 0 ) $hlavicka->g1k1b1="";
if( $hlavicka->g1k1c1 == 0 ) $hlavicka->g1k1c1="";
if( $hlavicka->g1k1d1 == 0 ) $hlavicka->g1k1d1="";

$hlavicka->g1k1b1nyg46="1234.56";
$hlavicka->g1k1c1nyg46="1234.56";
$hlavicka->g1k1d1nyg46="1234.56";

$pdf->Cell(73,5," ","$rmc",0,"L");$pdf->Cell(35,5,"$hlavicka->g1k1b1","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k1c1","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k1d1","$rmc",1,"R");

if( $hlavicka->g1k2b1 == 0 ) $hlavicka->g1k2b1="";
if( $hlavicka->g1k2c1 == 0 ) $hlavicka->g1k2c1="";
if( $hlavicka->g1k2d1 == 0 ) $hlavicka->g1k2d1="";

$hlavicka->g1k2a1nyg46="1234.56";
$hlavicka->g1k2b1nyg46="1234.56";
$hlavicka->g1k2c1nyg46="1234.56";
$hlavicka->g1k2d1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k2a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k2b1","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k2c1","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k2d1","$rmc",1,"R");

if( $hlavicka->g1k3b1 == 0 ) $hlavicka->g1k3b1="";
if( $hlavicka->g1k3c1 == 0 ) $hlavicka->g1k3c1="";
if( $hlavicka->g1k3d1 == 0 ) $hlavicka->g1k3d1="";

$hlavicka->g1k3a1nyg46="1234.56";
$hlavicka->g1k3b1nyg46="1234.56";
$hlavicka->g1k3c1nyg46="1234.56";
$hlavicka->g1k3d1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k3a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k3b1","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k3c1","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k3d1","$rmc",1,"R");

if( $hlavicka->g1k4b1 == 0 ) $hlavicka->g1k4b1="";
if( $hlavicka->g1k4c1 == 0 ) $hlavicka->g1k4c1="";
if( $hlavicka->g1k4d1 == 0 ) $hlavicka->g1k4d1="";

$hlavicka->g1k4a1nyg46="1234.56";
$hlavicka->g1k4b1nyg46="1234.56";
$hlavicka->g1k4c1nyg46="1234.56";
$hlavicka->g1k4d1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k4a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k4b1","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k4c1","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k4d1","$rmc",1,"R");

if( $hlavicka->g1k5b1 == 0 ) $hlavicka->g1k5b1="";
if( $hlavicka->g1k5c1 == 0 ) $hlavicka->g1k5c1="";
if( $hlavicka->g1k5d1 == 0 ) $hlavicka->g1k5d1="";

$hlavicka->g1k5a1nyg46="1234.56";
$hlavicka->g1k5b1nyg46="1234.56";
$hlavicka->g1k5c1nyg46="1234.56";
$hlavicka->g1k5d1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k5a1","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k5b1","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k5c1","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k5d1","$rmc",1,"R");

//Zabezpecovacie derivaty

if( $hlavicka->g1k1b2 == 0 ) $hlavicka->g1k1b2="";
if( $hlavicka->g1k1c2 == 0 ) $hlavicka->g1k1c2="";
if( $hlavicka->g1k1d2 == 0 ) $hlavicka->g1k1d2="";

$hlavicka->g1k1b2nyg46="1234.56";
$hlavicka->g1k1c2nyg46="1234.56";
$hlavicka->g1k1d2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(73,5," ","$rmc",0,"L");$pdf->Cell(35,5,"$hlavicka->g1k1b2","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k1c2","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k1d2","$rmc",1,"R");

if( $hlavicka->g1k2b2 == 0 ) $hlavicka->g1k2b2="";
if( $hlavicka->g1k2c2 == 0 ) $hlavicka->g1k2c2="";
if( $hlavicka->g1k2d2 == 0 ) $hlavicka->g1k2d2="";

$hlavicka->g1k2a2nyg46="1234.56";
$hlavicka->g1k2b2nyg46="1234.56";
$hlavicka->g1k2c2nyg46="1234.56";
$hlavicka->g1k2d2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k2a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k2b2","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k2c2","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k2d2","$rmc",1,"R");

if( $hlavicka->g1k3b2 == 0 ) $hlavicka->g1k3b2="";
if( $hlavicka->g1k3c2 == 0 ) $hlavicka->g1k3c2="";
if( $hlavicka->g1k3d2 == 0 ) $hlavicka->g1k3d2="";

$hlavicka->g1k3a2nyg46="1234.56";
$hlavicka->g1k3b2nyg46="1234.56";
$hlavicka->g1k3c2nyg46="1234.56";
$hlavicka->g1k3d2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k3a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k3b2","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k3c2","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k3d2","$rmc",1,"R");

if( $hlavicka->g1k4b2 == 0 ) $hlavicka->g1k4b2="";
if( $hlavicka->g1k4c2 == 0 ) $hlavicka->g1k4c2="";
if( $hlavicka->g1k4d2 == 0 ) $hlavicka->g1k4d2="";

$hlavicka->g1k4a2nyg46="1234.56";
$hlavicka->g1k4b2nyg46="1234.56";
$hlavicka->g1k4c2nyg46="1234.56";
$hlavicka->g1k4d2nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k4a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k4b2","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k4c2","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k4d2","$rmc",1,"R");

if( $hlavicka->g1k5b2 == 0 ) $hlavicka->g1k5b2="";
if( $hlavicka->g1k5c2 == 0 ) $hlavicka->g1k5c2="";
if( $hlavicka->g1k5d2 == 0 ) $hlavicka->g1k5d2="";

$hlavicka->g1k5a2nyg46="1234.56";
$hlavicka->g1k5b2nyg46="1234.56";
$hlavicka->g1k5c2nyg46="1234.56";
$hlavicka->g1k5d2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k5a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k5b2","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k5c2","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k5d2","$rmc",1,"R");

if( $hlavicka->g1k6b2 == 0 ) $hlavicka->g1k6b2="";
if( $hlavicka->g1k6c2 == 0 ) $hlavicka->g1k6c2="";
if( $hlavicka->g1k6d2 == 0 ) $hlavicka->g1k6d2="";

$hlavicka->g1k6a2nyg46="1234.56";
$hlavicka->g1k6b2nyg46="1234.56";
$hlavicka->g1k6c2nyg46="1234.56";
$hlavicka->g1k6d2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g1k6a2","$rmc",0,"L");
$pdf->Cell(35,5,"$hlavicka->g1k6b2","$rmc",0,"R");$pdf->Cell(34,5,"$hlavicka->g1k6c2","$rmc",0,"R");
$pdf->Cell(34,5,"$hlavicka->g1k6d2","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text14"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
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
                                        } //koniec strana 27

if ( $nopg28 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab32_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab32_2.jpg',0,100,210,98);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//prva tabulka

$pdf->Cell(90,78,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2","$rmc",1,"L");
$pdf->Cell(90,40,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//Tabulka32 c.2 Gk

if( $hlavicka->g2k1b1 == 0 ) $hlavicka->g2k1b1="";
if( $hlavicka->g2k1c1 == 0 ) $hlavicka->g2k1c1="";
if( $hlavicka->g2k1d1 == 0 ) $hlavicka->g2k1d1="";
if( $hlavicka->g2k1e1 == 0 ) $hlavicka->g2k1e1="";

$hlavicka->g2k1b1nyg46="1234.56";
$hlavicka->g2k1c1nyg46="1234.56";
$hlavicka->g2k1d1nyg46="1234.56";
$hlavicka->g2k1e1nyg46="1234.56";

$pdf->Cell(73,5," ","$rmc",0,"L");$pdf->Cell(26,5,"$hlavicka->g2k1b1","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k1c1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k1d1","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k1e1","$rmc",1,"R");

if( $hlavicka->g2k2b1 == 0 ) $hlavicka->g2k2b1="";
if( $hlavicka->g2k2c1 == 0 ) $hlavicka->g2k2c1="";
if( $hlavicka->g2k2d1 == 0 ) $hlavicka->g2k2d1="";
if( $hlavicka->g2k2e1 == 0 ) $hlavicka->g2k2e1="";

$hlavicka->g2k2a1nyg46="1234.56";
$hlavicka->g2k2b1nyg46="1234.56";
$hlavicka->g2k2c1nyg46="1234.56";
$hlavicka->g2k2d1nyg46="1234.56";
$hlavicka->g2k2e1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g2k2a1","$rmc",0,"L");
$pdf->Cell(26,5,"$hlavicka->g2k2b1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k2c1","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k2d1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k2e1","$rmc",1,"R");

if( $hlavicka->g2k3b1 == 0 ) $hlavicka->g2k3b1="";
if( $hlavicka->g2k3c1 == 0 ) $hlavicka->g2k3c1="";
if( $hlavicka->g2k3d1 == 0 ) $hlavicka->g2k3d1="";
if( $hlavicka->g2k3e1 == 0 ) $hlavicka->g2k3e1="";

$hlavicka->g2k3a1nyg46="1234.56";
$hlavicka->g2k3b1nyg46="1234.56";
$hlavicka->g2k3c1nyg46="1234.56";
$hlavicka->g2k3d1nyg46="1234.56";
$hlavicka->g2k3e1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g2k3a1","$rmc",0,"L");
$pdf->Cell(26,5,"$hlavicka->g2k3b1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k3c1","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k3d1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k3e1","$rmc",1,"R");

if( $hlavicka->g2k4b1 == 0 ) $hlavicka->g2k4b1="";
if( $hlavicka->g2k4c1 == 0 ) $hlavicka->g2k4c1="";
if( $hlavicka->g2k4d1 == 0 ) $hlavicka->g2k4d1="";
if( $hlavicka->g2k4e1 == 0 ) $hlavicka->g2k4e1="";

$hlavicka->g2k4a1nyg46="1234.56";
$hlavicka->g2k4b1nyg46="1234.56";
$hlavicka->g2k4c1nyg46="1234.56";
$hlavicka->g2k4d1nyg46="1234.56";
$hlavicka->g2k4e1nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g2k4a1","$rmc",0,"L");
$pdf->Cell(26,5,"$hlavicka->g2k4b1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k4c1","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k4d1","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k4e1","$rmc",1,"R");

//Zabezpecovacie derivaty

if( $hlavicka->g2k1b2 == 0 ) $hlavicka->g2k1b2="";
if( $hlavicka->g2k1c2 == 0 ) $hlavicka->g2k1c2="";
if( $hlavicka->g2k1d2 == 0 ) $hlavicka->g2k1d2="";
if( $hlavicka->g2k1e2 == 0 ) $hlavicka->g2k1e2="";

$hlavicka->g2k1b2nyg46="1234.56";
$hlavicka->g2k1c2nyg46="1234.56";
$hlavicka->g2k1d2nyg46="1234.56";
$hlavicka->g2k1e2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(73,5," ","$rmc",0,"L");$pdf->Cell(26,5,"$hlavicka->g2k1b2","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k1c2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k1d2","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k1e2","$rmc",1,"R");

if( $hlavicka->g2k2b2 == 0 ) $hlavicka->g2k2b2="";
if( $hlavicka->g2k2c2 == 0 ) $hlavicka->g2k2c2="";
if( $hlavicka->g2k2d2 == 0 ) $hlavicka->g2k2d2="";
if( $hlavicka->g2k2e2 == 0 ) $hlavicka->g2k2e2="";

$hlavicka->g2k2a2nyg46="1234.56";
$hlavicka->g2k2b2nyg46="1234.56";
$hlavicka->g2k2c2nyg46="1234.56";
$hlavicka->g2k2d2nyg46="1234.56";
$hlavicka->g2k2e2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g2k2a2","$rmc",0,"L");
$pdf->Cell(26,5,"$hlavicka->g2k2b2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k2c2","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k2d2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k2e2","$rmc",1,"R");

if( $hlavicka->g2k3b2 == 0 ) $hlavicka->g2k3b2="";
if( $hlavicka->g2k3c2 == 0 ) $hlavicka->g2k3c2="";
if( $hlavicka->g2k3d2 == 0 ) $hlavicka->g2k3d2="";
if( $hlavicka->g2k3e2 == 0 ) $hlavicka->g2k3e2="";

$hlavicka->g2k3a2nyg46="1234.56";
$hlavicka->g2k3b2nyg46="1234.56";
$hlavicka->g2k3c2nyg46="1234.56";
$hlavicka->g2k3d2nyg46="1234.56";
$hlavicka->g2k3e2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g2k3a2","$rmc",0,"L");
$pdf->Cell(26,5,"$hlavicka->g2k3b2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k3c2","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k3d2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k3e2","$rmc",1,"R");

if( $hlavicka->g2k4b2 == 0 ) $hlavicka->g2k4b2="";
if( $hlavicka->g2k4c2 == 0 ) $hlavicka->g2k4c2="";
if( $hlavicka->g2k4d2 == 0 ) $hlavicka->g2k4d2="";
if( $hlavicka->g2k4e2 == 0 ) $hlavicka->g2k4e2="";

$hlavicka->g2k4a2nyg46="1234.56";
$hlavicka->g2k4b2nyg46="1234.56";
$hlavicka->g2k4c2nyg46="1234.56";
$hlavicka->g2k4d2nyg46="1234.56";
$hlavicka->g2k4e2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(60,5,"$hlavicka->g2k4a2","$rmc",0,"L");
$pdf->Cell(26,5,"$hlavicka->g2k4b2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k4c2","$rmc",0,"R");
$pdf->Cell(26,5,"$hlavicka->g2k4d2","$rmc",0,"R");$pdf->Cell(26,5,"$hlavicka->g2k4e2","$rmc",1,"R");




//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text15"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="G_text16"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(200);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 28

if ( $nopg29 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab33.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab33.jpg',0,28,210,65);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab34.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab34.jpg',0,170,210,65);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//prva tabulka

$pdf->Cell(90,5,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"33. Informácie k èasti G písm. l) prílohy è.3 o polokách zabezpeèenıch derivátmi","$rmc",1,"L");
$pdf->Cell(90,26,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tABULKA 33, tabulka Fl

if( $hlavicka->gl1b == 0 ) $hlavicka->gl1b="";
if( $hlavicka->gl1b == 0 ) $hlavicka->gl1c="";

$hlavicka->gl1bnyg46="1234.56";
$hlavicka->gl1cnyg46="1234.56";

$pdf->Cell(74,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->gl1b","$rmc",0,"R");
$pdf->Cell(51,5,"$hlavicka->gl1c","$rmc",1,"R");

if( $hlavicka->gl2b == 0 ) $hlavicka->gl2b="";
if( $hlavicka->gl2b == 0 ) $hlavicka->gl2c="";

$hlavicka->gl2bnyg46="1234.56";
$hlavicka->gl2cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(74,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->gl2b","$rmc",0,"R");
$pdf->Cell(51,5,"$hlavicka->gl2c","$rmc",1,"R");

if( $hlavicka->gl3b == 0 ) $hlavicka->gl3b="";
if( $hlavicka->gl3b == 0 ) $hlavicka->gl3c="";

$hlavicka->gl3bnyg46="1234.56";
$hlavicka->gl3cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(74,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->gl3b","$rmc",0,"R");
$pdf->Cell(51,5,"$hlavicka->gl3c","$rmc",1,"R");

if( $hlavicka->gl4b == 0 ) $hlavicka->gl4b="";
if( $hlavicka->gl4b == 0 ) $hlavicka->gl4c="";

$hlavicka->gl4bnyg46="1234.56";
$hlavicka->gl4cnyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(74,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->gl4b","$rmc",0,"R");
$pdf->Cell(51,5,"$hlavicka->gl4c","$rmc",1,"R");

if( $hlavicka->gl99b == 0 ) $hlavicka->gl99b="";
if( $hlavicka->gl99b == 0 ) $hlavicka->gl99c="";

$hlavicka->gl99bnyg46="1234.56";
$hlavicka->gl99cnyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(74,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->gl99b","$rmc",0,"R");
$pdf->Cell(51,5,"$hlavicka->gl99c","$rmc",1,"R");



//druha tabulka

$pdf->Cell(90,77,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"34. Informácie k èasti G písm. m) prílohy è.3 o majetku prenajatom formou finanèného prenájmu","$rmc",1,"L");
$pdf->Cell(90,41,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//tabulka34 Gm

if( $hlavicka->gm1b == 0 ) $hlavicka->gm1b="";
if( $hlavicka->gm1c == 0 ) $hlavicka->gm1c="";
if( $hlavicka->gm1d == 0 ) $hlavicka->gm1d="";
if( $hlavicka->gm1e == 0 ) $hlavicka->gm1e="";
if( $hlavicka->gm1f == 0 ) $hlavicka->gm1f="";
if( $hlavicka->gm1g == 0 ) $hlavicka->gm1g="";


$hlavicka->gm1bnyg46="1234.56";
$hlavicka->gm1cnyg46="1234.56";
$hlavicka->gm1dnyg46="1234.56";
$hlavicka->gm1enyg46="1234.56";
$hlavicka->gm1fnyg46="1234.56";
$hlavicka->gm1gnyg46="1234.56";

$pdf->Cell(37,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->gm1b","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm1c","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->gm1d","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm1e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->gm1f","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm1g","$rmc",1,"R");

if( $hlavicka->gm2b == 0 ) $hlavicka->gm2b="";
if( $hlavicka->gm2c == 0 ) $hlavicka->gm2c="";
if( $hlavicka->gm2d == 0 ) $hlavicka->gm2d="";
if( $hlavicka->gm2e == 0 ) $hlavicka->gm2e="";
if( $hlavicka->gm2f == 0 ) $hlavicka->gm2f="";
if( $hlavicka->gm2g == 0 ) $hlavicka->gm2g="";


$hlavicka->gm2bnyg46="1234.56";
$hlavicka->gm2cnyg46="1234.56";
$hlavicka->gm2dnyg46="1234.56";
$hlavicka->gm2enyg46="1234.56";
$hlavicka->gm2fnyg46="1234.56";
$hlavicka->gm2gnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(37,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->gm2b","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm2c","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->gm2d","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm2e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->gm2f","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm2g","$rmc",1,"R");


if( $hlavicka->gm99b == 0 ) $hlavicka->gm99b="";
if( $hlavicka->gm99c == 0 ) $hlavicka->gm99c="";
if( $hlavicka->gm99d == 0 ) $hlavicka->gm99d="";
if( $hlavicka->gm99e == 0 ) $hlavicka->gm99e="";
if( $hlavicka->gm99f == 0 ) $hlavicka->gm99f="";
if( $hlavicka->gm99g == 0 ) $hlavicka->gm99g="";


$hlavicka->gm99bnyg46="1234.56";
$hlavicka->gm99cnyg46="1234.56";
$hlavicka->gm99dnyg46="1234.56";
$hlavicka->gm99enyg46="1234.56";
$hlavicka->gm99fnyg46="1234.56";
$hlavicka->gm99gnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(37,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->gm99b","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm99c","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->gm99d","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm99e","$rmc",0,"R");$pdf->Cell(23,5,"$hlavicka->gm99f","$rmc",0,"R");
$pdf->Cell(23,5,"$hlavicka->gm99g","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);

$ozntext="G_text17"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(93);
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

$pdf->SetY(235);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 29

if ( $nopg30 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab35.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab35.jpg',0,45,210,69);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab36.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab36.jpg',0,210,210,95);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"H. INFORMÁCIE O VİNOSOCH ","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");



//prva tabulka

$pdf->Cell(90,12,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"35. Informácie k èasti H písm. a) prílohy è.3 o trbách","$rmc",1,"L");
$pdf->Cell(90,34,"     ","$rmc1",1,"L");
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





//druha tabulka

$pdf->Cell(90,96,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"36. Informácie k èasti H písm. b) prílohy è.3 o zmene stavu vnútroorganizaènıch zásob","$rmc",1,"L");
$pdf->Cell(90,30,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//tabulka36 Hb vnutrozasoby


if( $hlavicka->hb1b == 0 ) $hlavicka->hb1b="";
if( $hlavicka->hb1c == 0 ) $hlavicka->hb1c="";
if( $hlavicka->hb1d == 0 ) $hlavicka->hb1d="";
if( $hlavicka->hb1e == 0 ) $hlavicka->hb1e="";
if( $hlavicka->hb1f == 0 ) $hlavicka->hb1f="";

$hlavicka->hb1bnyg46="1234.56";
$hlavicka->hb1cnyg46="1234.56";
$hlavicka->hb1dnyg46="1234.56";
$hlavicka->hb1enyg46="1234.56";
$hlavicka->hb1fnyg46="1234.56";

$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb1b","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb1c","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb1d","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb1e","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb1f","$rmc",1,"R");

if( $hlavicka->hb2b == 0 ) $hlavicka->hb2b="";
if( $hlavicka->hb2c == 0 ) $hlavicka->hb2c="";
if( $hlavicka->hb2d == 0 ) $hlavicka->hb2d="";
if( $hlavicka->hb2e == 0 ) $hlavicka->hb2e="";
if( $hlavicka->hb2f == 0 ) $hlavicka->hb2f="";

$hlavicka->hb2bnyg46="1234.56";
$hlavicka->hb2cnyg46="1234.56";
$hlavicka->hb2dnyg46="1234.56";
$hlavicka->hb2enyg46="1234.56";
$hlavicka->hb2fnyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb2b","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb2c","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb2d","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb2e","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb2f","$rmc",1,"R");

if( $hlavicka->hb3b == 0 ) $hlavicka->hb3b="";
if( $hlavicka->hb3c == 0 ) $hlavicka->hb3c="";
if( $hlavicka->hb3d == 0 ) $hlavicka->hb3d="";
if( $hlavicka->hb3e == 0 ) $hlavicka->hb3e="";
if( $hlavicka->hb3f == 0 ) $hlavicka->hb3f="";

$hlavicka->hb3bnyg46="1234.56";
$hlavicka->hb3cnyg46="1234.56";
$hlavicka->hb3dnyg46="1234.56";
$hlavicka->hb3enyg46="1234.56";
$hlavicka->hb3fnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb3b","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb3c","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb3d","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb3e","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb3f","$rmc",1,"R");


if( $hlavicka->hb4b == 0 ) $hlavicka->hb4b="";
if( $hlavicka->hb4c == 0 ) $hlavicka->hb4c="";
if( $hlavicka->hb4d == 0 ) $hlavicka->hb4d="";
if( $hlavicka->hb4e == 0 ) $hlavicka->hb4e="";
if( $hlavicka->hb4f == 0 ) $hlavicka->hb4f="";

$hlavicka->hb4bnyg46="1234.56";
$hlavicka->hb4cnyg46="1234.56";
$hlavicka->hb4dnyg46="1234.56";
$hlavicka->hb4enyg46="1234.56";
$hlavicka->hb4fnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb4b","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb4c","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb4d","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb4e","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->hb4f","$rmc",1,"R");

if( $hlavicka->hb5e == 0 ) $hlavicka->hb5e="";
if( $hlavicka->hb5f == 0 ) $hlavicka->hb5f="";

$hlavicka->hb5enyg46="1234.56";
$hlavicka->hb5fnyg46="1234.56";

$pdf->Cell(90,0,"     ","$rmc",1,"L");
$pdf->Cell(126,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb5e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb5f","$rmc",1,"R");

if( $hlavicka->hb6e == 0 ) $hlavicka->hb6e="";
if( $hlavicka->hb6f == 0 ) $hlavicka->hb6f="";

$hlavicka->hb6enyg46="1234.56";
$hlavicka->hb6fnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(126,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb6e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb6f","$rmc",1,"R");

if( $hlavicka->hb7e == 0 ) $hlavicka->hb7e="";
if( $hlavicka->hb7f == 0 ) $hlavicka->hb7f="";

$hlavicka->hb7enyg46="1234.56";
$hlavicka->hb7fnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(126,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb7e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb7f","$rmc",1,"R");

if( $hlavicka->hb8e == 0 ) $hlavicka->hb8e="";
if( $hlavicka->hb8f == 0 ) $hlavicka->hb8f="";

$hlavicka->hb8enyg46="1234.56";
$hlavicka->hb8fnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(126,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb8e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb8f","$rmc",1,"R");

if( $hlavicka->hb9e == 0 ) $hlavicka->hb9e="";
if( $hlavicka->hb9f == 0 ) $hlavicka->hb9f="";

$hlavicka->hb9enyg46="1234.56";
$hlavicka->hb9fnyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(126,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->hb9e","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->hb9f","$rmc",1,"R");





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
                                        } //koniec strana 30

if ( $nopg31 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab37.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab37.jpg',0,80,210,125);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab38.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab38.jpg',0,230,210,62);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//prva tabulka

$pdf->Cell(90,53,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"37. Informácie k èasti H písm. c) a f) prílohy è.3 o vınosoch pri aktivácii nákladov a o vınosoch z hospodárskej","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"èinnosti, finanènej èinnosti a mimoriadnej èinnosti","$rmc",1,"L");

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

$pdf->Cell(90,1,"     ","$rmc",1,"L");
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


$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(73,5,"$hlavicka->h4cf31","$rmc",0,"L");
$pdf->Cell(45,5,"$hlavicka->h4cf32","$rmc",0,"R");$pdf->Cell(45,5,"$hlavicka->h4cf33","$rmc",1,"R");





//druha tabulka

$pdf->Cell(90,26,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"38. Informácie k èasti H písm. g) prílohy è.3 o èístom obrate","$rmc",1,"L");
$pdf->Cell(90,15,"     ","$rmc1",1,"L");

$pdf->SetFont('arial','',8);
//tabulka38 Hg o cistom obrate

if( $hlavicka->hg11 == 0 ) $hlavicka->hg11="";
if( $hlavicka->hg12 == 0 ) $hlavicka->hg12="";

$hlavicka->hg11nyg46="1234.56";
$hlavicka->hg12nyg46="1234.56";

$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg11","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg12","$rmc",1,"R");


if( $hlavicka->hg21 == 0 ) $hlavicka->hg21="";
if( $hlavicka->hg22 == 0 ) $hlavicka->hg22="";

$hlavicka->hg21nyg46="1234.56";
$hlavicka->hg22nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg21","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg22","$rmc",1,"R");


if( $hlavicka->hg31 == 0 ) $hlavicka->hg31="";
if( $hlavicka->hg32 == 0 ) $hlavicka->hg32="";

$hlavicka->hg31nyg46="1234.56";
$hlavicka->hg32nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg31","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg32","$rmc",1,"R");

if( $hlavicka->hg41 == 0 ) $hlavicka->hg41="";
if( $hlavicka->hg42 == 0 ) $hlavicka->hg42="";

$hlavicka->hg41nyg46="1234.56";
$hlavicka->hg42nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg41","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg42","$rmc",1,"R");

if( $hlavicka->hg51 == 0 ) $hlavicka->hg51="";
if( $hlavicka->hg52 == 0 ) $hlavicka->hg52="";

$hlavicka->hg51nyg46="1234.56";
$hlavicka->hg52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg51","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg52","$rmc",1,"R");

if( $hlavicka->hg61 == 0 ) $hlavicka->hg61="";
if( $hlavicka->hg62 == 0 ) $hlavicka->hg62="";

$hlavicka->hg61nyg46="1234.56";
$hlavicka->hg62nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg61","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg62","$rmc",1,"R");

if( $hlavicka->hg991 == 0 ) $hlavicka->hg991="";
if( $hlavicka->hg992 == 0 ) $hlavicka->hg992="";

$hlavicka->hg991nyg46="1234.56";
$hlavicka->hg992nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(105,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->hg991","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->hg992","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="H_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="H_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(205);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 31

if ( $nopg32 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab39.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab39.jpg',0,90,210,168);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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





//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(90,60," ","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"I. INFORMÁCIE O NÁKLADOCH ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,8," ","$rmc",0,"L");$pdf->Cell(0,4,"39. Informácie k èasti I prílohy è.3 o nákladoch","$rmc",1,"L");

$pdf->Cell(90,13,"     ","$rmc1",1,"L");
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


$ozntext="H_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="I_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
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
                                        } //koniec strana 32

if ( $nopg33 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab40.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab40.jpg',0,50,210,98);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab41.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab41.jpg',0,180,210,20);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab41b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab41b.jpg',0,200,210,76);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(90,16," ","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"J. INFORMÁCIE O DANIACH Z PRÍJMOV ","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,1,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(0,4,"40. Informácie k èasti J písm. a) a e) prílohy è.3 o daniach z príjmov","$rmc",1,"L");

$pdf->Cell(90,18,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka40 Ja-e o daniach

if( $hlavicka->jae11 == 0 ) $hlavicka->jae11="";
if( $hlavicka->jae12 == 0 ) $hlavicka->jae12="";

$hlavicka->jae11nyg46="1234.56";
$hlavicka->jae12nyg46="1234.56";

$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->jae11","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->jae12","$rmc",1,"R");

if( $hlavicka->jae21 == 0 ) $hlavicka->jae21="";
if( $hlavicka->jae22 == 0 ) $hlavicka->jae22="";

$hlavicka->jae21nyg46="1234.56";
$hlavicka->jae22nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->jae21","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->jae22","$rmc",1,"R");

if( $hlavicka->jae31 == 0 ) $hlavicka->jae31="";
if( $hlavicka->jae32 == 0 ) $hlavicka->jae32="";

$hlavicka->jae31nyg46="1234.56";
$hlavicka->jae32nyg46="1234.56";

$pdf->Cell(90,10,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->jae31","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->jae32","$rmc",1,"R");

if( $hlavicka->jae41 == 0 ) $hlavicka->jae41="";
if( $hlavicka->jae42 == 0 ) $hlavicka->jae42="";

$hlavicka->jae41nyg46="1234.56";
$hlavicka->jae42nyg46="1234.56";

$pdf->Cell(90,14,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->jae41","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->jae42","$rmc",1,"R");

if( $hlavicka->jae51 == 0 ) $hlavicka->jae51="";
if( $hlavicka->jae52 == 0 ) $hlavicka->jae52="";

$hlavicka->jae51nyg46="1234.56";
$hlavicka->jae52nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->jae51","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->jae52","$rmc",1,"R");

if( $hlavicka->jae61 == 0 ) $hlavicka->jae61="";
if( $hlavicka->jae62 == 0 ) $hlavicka->jae62="";

$hlavicka->jae61nyg46="1234.56";
$hlavicka->jae62nyg46="1234.56";

$pdf->Cell(90,9,"     ","$rmc",1,"L");
$pdf->Cell(104,5," ","$rmc",0,"L");$pdf->Cell(36,5,"$hlavicka->jae61","$rmc",0,"R");
$pdf->Cell(36,5,"$hlavicka->jae62","$rmc",1,"R");




//druha tabulka

$pdf->Cell(90,31,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"41. Informácie k èasti J písm. f) a g) prílohy è.3 o daniach z príjmov","$rmc",1,"L");

$pdf->Cell(90,22,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka41 Jf-g 

if( $hlavicka->jfg1b == 0 ) $hlavicka->jfg1b="";
if( $hlavicka->jfg1c == 0 ) $hlavicka->jfg1c="";
if( $hlavicka->jfg1d == 0 ) $hlavicka->jfg1d="";
if( $hlavicka->jfg1e == 0 ) $hlavicka->jfg1e="";
if( $hlavicka->jfg1f == 0 ) $hlavicka->jfg1f="";
if( $hlavicka->jfg1g == 0 ) $hlavicka->jfg1g="";

$hlavicka->jfg1bnyg46="1234.56";
$hlavicka->jfg1cnyg46="1234.56";
$hlavicka->jfg1dnyg46="1234.56";
$hlavicka->jfg1enyg46="1234.56";
$hlavicka->jfg1fnyg46="1234.56";
$hlavicka->jfg1gnyg46="1234.56";

$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$hlavicka->jfg1b","$rmc",0,"R");
$pdf->Cell(15,5,"","$rmc",0,"R");$pdf->Cell(11,5,"","$rmc",0,"R");
$pdf->Cell(35,5,"$hlavicka->jfg1e","$rmc",0,"R");$pdf->Cell(12,5,"","$rmc",0,"R");
$pdf->Cell(12,5,"","$rmc",1,"R");

if( $hlavicka->jfg2b == 0 ) $hlavicka->jfg2b="";
if( $hlavicka->jfg2c == 0 ) $hlavicka->jfg2c="";
if( $hlavicka->jfg2d == 0 ) $hlavicka->jfg2d="";
if( $hlavicka->jfg2e == 0 ) $hlavicka->jfg2e="";
if( $hlavicka->jfg2f == 0 ) $hlavicka->jfg2f="";
if( $hlavicka->jfg2g == 0 ) $hlavicka->jfg2g="";

$hlavicka->jfg2bnyg46="1234.56";
$hlavicka->jfg2cnyg46="1234.56";
$hlavicka->jfg2dnyg46="1234.56";
$hlavicka->jfg2enyg46="1234.56";
$hlavicka->jfg2fnyg46="1234.56";
$hlavicka->jfg2gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg2c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg2d","$rmc",0,"R");
$pdf->Cell(35,5,"","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg2f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg2g","$rmc",1,"R");

if( $hlavicka->jfg3b == 0 ) $hlavicka->jfg3b="";
if( $hlavicka->jfg3c == 0 ) $hlavicka->jfg3c="";
if( $hlavicka->jfg3d == 0 ) $hlavicka->jfg3d="";
if( $hlavicka->jfg3e == 0 ) $hlavicka->jfg3e="";
if( $hlavicka->jfg3f == 0 ) $hlavicka->jfg3f="";
if( $hlavicka->jfg3g == 0 ) $hlavicka->jfg3g="";

$hlavicka->jfg3bnyg46="1234.56";
$hlavicka->jfg3cnyg46="1234.56";
$hlavicka->jfg3dnyg46="1234.56";
$hlavicka->jfg3enyg46="1234.56";
$hlavicka->jfg3fnyg46="1234.56";
$hlavicka->jfg3gnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$hlavicka->jfg3b","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg3c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg3d","$rmc",0,"R");
$pdf->Cell(35,5,"$hlavicka->jfg3e","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg3f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg3g","$rmc",1,"R");

if( $hlavicka->jfg4b == 0 ) $hlavicka->jfg4b="";
if( $hlavicka->jfg4c == 0 ) $hlavicka->jfg4c="";
if( $hlavicka->jfg4d == 0 ) $hlavicka->jfg4d="";
if( $hlavicka->jfg4e == 0 ) $hlavicka->jfg4e="";
if( $hlavicka->jfg4f == 0 ) $hlavicka->jfg4f="";
if( $hlavicka->jfg4g == 0 ) $hlavicka->jfg4g="";

$hlavicka->jfg4bnyg46="1234.56";
$hlavicka->jfg4cnyg46="1234.56";
$hlavicka->jfg4dnyg46="1234.56";
$hlavicka->jfg4enyg46="1234.56";
$hlavicka->jfg4fnyg46="1234.56";
$hlavicka->jfg4gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$hlavicka->jfg4b","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg4c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg4d","$rmc",0,"R");
$pdf->Cell(35,5,"$hlavicka->jfg4e","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg4f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg4g","$rmc",1,"R");

if( $jfg4n1b == 0 ) $jfg4n1b="";
if( $jfg4n1c == 0 ) $jfg4n1c="";
if( $jfg4n1d == 0 ) $jfg4n1d="";
if( $jfg4n1e == 0 ) $jfg4n1e="";
if( $jfg4n1f == 0 ) $jfg4n1f="";
if( $jfg4n1g == 0 ) $jfg4n1g="";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$jfg4n1b","$rmc",0,"R");
$pdf->Cell(15,5,"$jfg4n1c","$rmc",0,"R");$pdf->Cell(11,5,"$jfg4n1d","$rmc",0,"R");
$pdf->Cell(35,5,"$jfg4n1e","$rmc",0,"R");$pdf->Cell(12,5,"$jfg4n1f","$rmc",0,"R");
$pdf->Cell(12,5,"$jfg4n1g","$rmc",1,"R");


if( $hlavicka->jfg5b == 0 ) $hlavicka->jfg5b="";
if( $hlavicka->jfg5c == 0 ) $hlavicka->jfg5c="";
if( $hlavicka->jfg5d == 0 ) $hlavicka->jfg5d="";
if( $hlavicka->jfg5e == 0 ) $hlavicka->jfg5e="";
if( $hlavicka->jfg5f == 0 ) $hlavicka->jfg5f="";
if( $hlavicka->jfg5g == 0 ) $hlavicka->jfg5g="";

$hlavicka->jfg5bnyg46="1234.56";
$hlavicka->jfg5cnyg46="1234.56";
$hlavicka->jfg5dnyg46="1234.56";
$hlavicka->jfg5enyg46="1234.56";
$hlavicka->jfg5fnyg46="1234.56";
$hlavicka->jfg5gnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$hlavicka->jfg5b","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg5c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg5d","$rmc",0,"R");
$pdf->Cell(35,5,"$hlavicka->jfg5e","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg5f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg5g","$rmc",1,"R");


if( $jfg5n1b == 0 ) $jfg5n1b="";
if( $jfg5n1c == 0 ) $jfg5n1c="";
if( $jfg5n1d == 0 ) $jfg5n1d="";
if( $jfg5n1e == 0 ) $jfg5n1e="";
if( $jfg5n1f == 0 ) $jfg5n1f="";
if( $jfg5n1g == 0 ) $jfg5n1g="";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$jfg5n1b","$rmc",0,"R");
$pdf->Cell(15,5,"$jfg5n1c","$rmc",0,"R");$pdf->Cell(11,5,"$jfg5n1d","$rmc",0,"R");
$pdf->Cell(35,5,"$jfg5n1e","$rmc",0,"R");$pdf->Cell(12,5,"$jfg5n1f","$rmc",0,"R");
$pdf->Cell(12,5,"$jfg5n1g","$rmc",1,"R");

if( $jfg5n2b == 0 ) $jfg5n2b="";
if( $jfg5n2c == 0 ) $jfg5n2c="";
if( $jfg5n2d == 0 ) $jfg5n2d="";
if( $jfg5n2e == 0 ) $jfg5n2e="";
if( $jfg5n2f == 0 ) $jfg5n2f="";
if( $jfg5n2g == 0 ) $jfg5n2g="";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$jfg5n2b","$rmc",0,"R");
$pdf->Cell(15,5,"$jfg5n2c","$rmc",0,"R");$pdf->Cell(11,5,"$jfg5n2d","$rmc",0,"R");
$pdf->Cell(35,5,"$jfg5n2e","$rmc",0,"R");$pdf->Cell(12,5,"$jfg5n2f","$rmc",0,"R");
$pdf->Cell(12,5,"$jfg5n2g","$rmc",1,"R");


if( $hlavicka->jfg6b == 0 ) $hlavicka->jfg6b="";
if( $hlavicka->jfg6c == 0 ) $hlavicka->jfg6c="";
if( $hlavicka->jfg6d == 0 ) $hlavicka->jfg6d="";
if( $hlavicka->jfg6e == 0 ) $hlavicka->jfg6e="";
if( $hlavicka->jfg6f == 0 ) $hlavicka->jfg6f="";
if( $hlavicka->jfg6g == 0 ) $hlavicka->jfg6g="";

$hlavicka->jfg6bnyg46="1234.56";
$hlavicka->jfg6cnyg46="1234.56";
$hlavicka->jfg6dnyg46="1234.56";
$hlavicka->jfg6enyg46="1234.56";
$hlavicka->jfg6fnyg46="1234.56";
$hlavicka->jfg6gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"$hlavicka->jfg6b","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg6c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg6d","$rmc",0,"R");
$pdf->Cell(35,5,"$hlavicka->jfg6e","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg6f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg6g","$rmc",1,"R");

if( $hlavicka->jfg7b == 0 ) $hlavicka->jfg7b="";
if( $hlavicka->jfg7c == 0 ) $hlavicka->jfg7c="";
if( $hlavicka->jfg7d == 0 ) $hlavicka->jfg7d="";
if( $hlavicka->jfg7e == 0 ) $hlavicka->jfg7e="";
if( $hlavicka->jfg7f == 0 ) $hlavicka->jfg7f="";
if( $hlavicka->jfg7g == 0 ) $hlavicka->jfg7g="";

$hlavicka->jfg7bnyg46="1234.56";
$hlavicka->jfg7cnyg46="1234.56";
$hlavicka->jfg7dnyg46="1234.56";
$hlavicka->jfg7enyg46="1234.56";
$hlavicka->jfg7fnyg46="1234.56";
$hlavicka->jfg7gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg7c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg7d","$rmc",0,"R");
$pdf->Cell(35,5,"","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg7f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg7g","$rmc",1,"R");

if( $hlavicka->jfg8b == 0 ) $hlavicka->jfg8b="";
if( $hlavicka->jfg8c == 0 ) $hlavicka->jfg8c="";
if( $hlavicka->jfg8d == 0 ) $hlavicka->jfg8d="";
if( $hlavicka->jfg8e == 0 ) $hlavicka->jfg8e="";
if( $hlavicka->jfg8f == 0 ) $hlavicka->jfg8f="";
if( $hlavicka->jfg8g == 0 ) $hlavicka->jfg8g="";

$hlavicka->jfg8bnyg46="1234.56";
$hlavicka->jfg8cnyg46="1234.56";
$hlavicka->jfg8dnyg46="1234.56";
$hlavicka->jfg8enyg46="1234.56";
$hlavicka->jfg8fnyg46="1234.56";
$hlavicka->jfg8gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg8c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg8d","$rmc",0,"R");
$pdf->Cell(35,5,"","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg8f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg8g","$rmc",1,"R");

if( $hlavicka->jfg9b == 0 ) $hlavicka->jfg9b="";
if( $hlavicka->jfg9c == 0 ) $hlavicka->jfg9c="";
if( $hlavicka->jfg9d == 0 ) $hlavicka->jfg9d="";
if( $hlavicka->jfg9e == 0 ) $hlavicka->jfg9e="";
if( $hlavicka->jfg9f == 0 ) $hlavicka->jfg9f="";
if( $hlavicka->jfg9g == 0 ) $hlavicka->jfg9g="";

$hlavicka->jfg9bnyg46="1234.56";
$hlavicka->jfg9cnyg46="1234.56";
$hlavicka->jfg9dnyg46="1234.56";
$hlavicka->jfg9enyg46="1234.56";
$hlavicka->jfg9fnyg46="1234.56";
$hlavicka->jfg9gnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(62,5," ","$rmc",0,"L");$pdf->Cell(30,5,"","$rmc",0,"R");
$pdf->Cell(15,5,"$hlavicka->jfg9c","$rmc",0,"R");$pdf->Cell(11,5,"$hlavicka->jfg9d","$rmc",0,"R");
$pdf->Cell(35,5,"","$rmc",0,"R");$pdf->Cell(12,5,"$hlavicka->jfg9f","$rmc",0,"R");
$pdf->Cell(12,5,"$hlavicka->jfg9g","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="I_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
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

$pdf->SetY(148);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 33

if ( $nopg34 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab42.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab42.jpg',0,70,210,80);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab43_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab43_1.jpg',0,210,210,62);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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
$pdf->Cell(190,5,"                          ","$rmc1",1,"L");



//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(90,40," ","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"K. INFORMÁCIE O ÚDAJOCH NA PODSÚVAHOVİCH ÚÈTOCH ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"42. Informácie k èasti K prílohy è.3 o podsúvahovıch polokách","$rmc",1,"L");

$pdf->Cell(90,14,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tabulka42 K udaje na podsuvahovych uctoch


if( $hlavicka->k11 == 0 ) $hlavicka->k11="";
if( $hlavicka->k12 == 0 ) $hlavicka->k12="";

$hlavicka->k11nyg46="1234.56";
$hlavicka->k12nyg46="1234.56";

$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k12","$rmc",1,"R");

if( $hlavicka->k21 == 0 ) $hlavicka->k21="";
if( $hlavicka->k22 == 0 ) $hlavicka->k22="";

$hlavicka->k21nyg46="1234.56";
$hlavicka->k22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k22","$rmc",1,"R");


if( $hlavicka->k31 == 0 ) $hlavicka->k31="";
if( $hlavicka->k32 == 0 ) $hlavicka->k32="";

$hlavicka->k31nyg46="1234.56";
$hlavicka->k32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k32","$rmc",1,"R");

if( $hlavicka->k41 == 0 ) $hlavicka->k41="";
if( $hlavicka->k42 == 0 ) $hlavicka->k42="";

$hlavicka->k41nyg46="1234.56";
$hlavicka->k42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k42","$rmc",1,"R");

if( $hlavicka->k51 == 0 ) $hlavicka->k51="";
if( $hlavicka->k52 == 0 ) $hlavicka->k52="";

$hlavicka->k51nyg46="1234.56";
$hlavicka->k52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k52","$rmc",1,"R");

if( $hlavicka->k61 == 0 ) $hlavicka->k61="";
if( $hlavicka->k62 == 0 ) $hlavicka->k62="";

$hlavicka->k61nyg46="1234.56";
$hlavicka->k62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k62","$rmc",1,"R");

if( $hlavicka->k71 == 0 ) $hlavicka->k71="";
if( $hlavicka->k72 == 0 ) $hlavicka->k72="";

$hlavicka->k71nyg46="1234.56";
$hlavicka->k72nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k71","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k72","$rmc",1,"R");

if( $hlavicka->k81 == 0 ) $hlavicka->k81="";
if( $hlavicka->k82 == 0 ) $hlavicka->k82="";

$hlavicka->k81nyg46="1234.56";
$hlavicka->k82nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k81","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k82","$rmc",1,"R");

if( $hlavicka->k91 == 0 ) $hlavicka->k91="";
if( $hlavicka->k92 == 0 ) $hlavicka->k92="";

$hlavicka->k91nyg46="1234.56";
$hlavicka->k92nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->k91","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->k92","$rmc",1,"R");





//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(90,40," ","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"L. INFORMÁCIE O INİCH AKTÍVACH A INİCH PASÍVACH ","$rmc",1,"L");
$pdf->Cell(90,7," ","$rmc",1,"L");

//druha tabulka

$pdf->Cell(90,5,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"43. Informácie k èasti L písm. a) prílohy è.3 o podmienenıch záväzkoch","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");
$pdf->Cell(90,17,"     ","$rmc1",1,"L");
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


$ozntext="J_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="K_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(150);
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

$pdf->SetY(273);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 34

if ( $nopg35 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab43_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab43_2.jpg',0,70,210,60);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab44.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab44.jpg',0,190,210,74);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//prva tabulka

$pdf->Cell(90,43,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(12,4," ","$rmc",0,"L");$pdf->Cell(0,4,"","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2","$rmc",1,"L");
$pdf->Cell(90,17,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tab42 La podmienene zavazky tab2


if( $hlavicka->l2ab11 == 0 ) $hlavicka->l2ab11="";
if( $hlavicka->l2ab12 == 0 ) $hlavicka->l2ab12="";

$hlavicka->l2ab11nyg46="1234.56";
$hlavicka->l2ab12nyg46="1234.56";

$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab11","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab12","$rmc",1,"R");

if( $hlavicka->l2ab21 == 0 ) $hlavicka->l2ab21="";
if( $hlavicka->l2ab22 == 0 ) $hlavicka->l2ab22="";

$hlavicka->l2ab21nyg46="1234.56";
$hlavicka->l2ab22nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab21","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab22","$rmc",1,"R");

if( $hlavicka->l2ab31 == 0 ) $hlavicka->l2ab31="";
if( $hlavicka->l2ab32 == 0 ) $hlavicka->l2ab32="";

$hlavicka->l2ab31nyg46="1234.56";
$hlavicka->l2ab32nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab31","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab32","$rmc",1,"R");

if( $hlavicka->l2ab41 == 0 ) $hlavicka->l2ab41="";
if( $hlavicka->l2ab42 == 0 ) $hlavicka->l2ab42="";

$hlavicka->l2ab41nyg46="1234.56";
$hlavicka->l2ab42nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab41","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab42","$rmc",1,"R");

if( $hlavicka->l2ab51 == 0 ) $hlavicka->l2ab51="";
if( $hlavicka->l2ab52 == 0 ) $hlavicka->l2ab52="";

$hlavicka->l2ab51nyg46="1234.56";
$hlavicka->l2ab52nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab51","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab52","$rmc",1,"R");

if( $hlavicka->l2ab61 == 0 ) $hlavicka->l2ab61="";
if( $hlavicka->l2ab62 == 0 ) $hlavicka->l2ab62="";

$hlavicka->l2ab61nyg46="1234.56";
$hlavicka->l2ab62nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(76,5," ","$rmc",0,"L");$pdf->Cell(50,5,"$hlavicka->l2ab61","$rmc",0,"R");
$pdf->Cell(50,5,"$hlavicka->l2ab62","$rmc",1,"R");





//druha tabulka

$pdf->Cell(90,60,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"44. Informácie k èasti L písm. c) prílohy è.3 o podmienenom majetku","$rmc",1,"L");
$pdf->Cell(90,12,"     ","$rmc1",1,"L");
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


$ozntext="L_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(20);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="L_text3"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(132);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }

$ozntext="L_text4"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(264);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 35

if ( $nopg36 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab45.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab45.jpg',0,70,210,140);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"M. INFORMÁCIE O PRÍJMOCH A VİHODÁCH ÈLENOV ŠTATUTÁRNYCH ORGÁNOV, DOZORNİCH ","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"ORGÁNOV A INİCH ORGÁNOV ÚÈTOVNEJ JEDNOTKY","$rmc",1,"L");
$pdf->Cell(90,5," ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,26,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"45. Informácie o príjmoch a vıhodách èlenov štatutárnych orgánov, dozornıch orgánov a inıch","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"orgánov úètovnej jednotky","$rmc",1,"L");
$pdf->Cell(90,43,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//tab45 M prijmy a vyhody clenov

if( $hlavicka->m11b == 0 ) $hlavicka->m11b ="";
if( $hlavicka->m12b == 0 ) $hlavicka->m12b ="";
if( $hlavicka->m13b == 0 ) $hlavicka->m13b ="";
if( $hlavicka->m11c == 0 ) $hlavicka->m11c ="";
if( $hlavicka->m12c == 0 ) $hlavicka->m12c ="";
if( $hlavicka->m13c == 0 ) $hlavicka->m13c ="";

$hlavicka->m11bnyg46="1234.56";
$hlavicka->m12bnyg46="1234.56";
$hlavicka->m13bnyg46="1234.56";
$hlavicka->m11cnyg46="1234.56";
$hlavicka->m12cnyg46="1234.56";
$hlavicka->m13cnyg46="1234.56";

$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m11b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m12b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m13b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m11c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m12c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m13c","$rmc",1,"R");

if( $hlavicka->m21b == 0 ) $hlavicka->m21b ="";
if( $hlavicka->m22b == 0 ) $hlavicka->m22b ="";
if( $hlavicka->m23b == 0 ) $hlavicka->m23b ="";
if( $hlavicka->m21c == 0 ) $hlavicka->m21c ="";
if( $hlavicka->m22c == 0 ) $hlavicka->m22c ="";
if( $hlavicka->m23c == 0 ) $hlavicka->m23c ="";

$hlavicka->m21bnyg46="1234.56";
$hlavicka->m22bnyg46="1234.56";
$hlavicka->m23bnyg46="1234.56";
$hlavicka->m21cnyg46="1234.56";
$hlavicka->m22cnyg46="1234.56";
$hlavicka->m23cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m21b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m22b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m23b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m21c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m22c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m23c","$rmc",1,"R");

if( $hlavicka->m31b == 0 ) $hlavicka->m31b ="";
if( $hlavicka->m32b == 0 ) $hlavicka->m32b ="";
if( $hlavicka->m33b == 0 ) $hlavicka->m33b ="";
if( $hlavicka->m31c == 0 ) $hlavicka->m31c ="";
if( $hlavicka->m32c == 0 ) $hlavicka->m32c ="";
if( $hlavicka->m33c == 0 ) $hlavicka->m33c ="";

$hlavicka->m31bnyg46="1234.56";
$hlavicka->m32bnyg46="1234.56";
$hlavicka->m33bnyg46="1234.56";
$hlavicka->m31cnyg46="1234.56";
$hlavicka->m32cnyg46="1234.56";
$hlavicka->m33cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m31b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m32b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m33b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m31c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m32c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m33c","$rmc",1,"R");

if( $hlavicka->m41b == 0 ) $hlavicka->m41b ="";
if( $hlavicka->m42b == 0 ) $hlavicka->m42b ="";
if( $hlavicka->m43b == 0 ) $hlavicka->m43b ="";
if( $hlavicka->m41c == 0 ) $hlavicka->m41c ="";
if( $hlavicka->m42c == 0 ) $hlavicka->m42c ="";
if( $hlavicka->m43c == 0 ) $hlavicka->m43c ="";

$hlavicka->m41bnyg46="1234.56";
$hlavicka->m42bnyg46="1234.56";
$hlavicka->m43bnyg46="1234.56";
$hlavicka->m41cnyg46="1234.56";
$hlavicka->m42cnyg46="1234.56";
$hlavicka->m43cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m41b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m42b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m43b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m41c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m42c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m43c","$rmc",1,"R");

if( $hlavicka->m51b == 0 ) $hlavicka->m51b ="";
if( $hlavicka->m52b == 0 ) $hlavicka->m52b ="";
if( $hlavicka->m53b == 0 ) $hlavicka->m53b ="";
if( $hlavicka->m51c == 0 ) $hlavicka->m51c ="";
if( $hlavicka->m52c == 0 ) $hlavicka->m52c ="";
if( $hlavicka->m53c == 0 ) $hlavicka->m53c ="";

$hlavicka->m51bnyg46="1234.56";
$hlavicka->m52bnyg46="1234.56";
$hlavicka->m53bnyg46="1234.56";
$hlavicka->m51cnyg46="1234.56";
$hlavicka->m52cnyg46="1234.56";
$hlavicka->m53cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m51b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m52b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m53b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m51c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m52c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m53c","$rmc",1,"R");

if( $hlavicka->m61b == 0 ) $hlavicka->m61b ="";
if( $hlavicka->m62b == 0 ) $hlavicka->m62b ="";
if( $hlavicka->m63b == 0 ) $hlavicka->m63b ="";
if( $hlavicka->m61c == 0 ) $hlavicka->m61c ="";
if( $hlavicka->m62c == 0 ) $hlavicka->m62c ="";
if( $hlavicka->m63c == 0 ) $hlavicka->m63c ="";

$hlavicka->m61bnyg46="1234.56";
$hlavicka->m62bnyg46="1234.56";
$hlavicka->m63bnyg46="1234.56";
$hlavicka->m61cnyg46="1234.56";
$hlavicka->m62cnyg46="1234.56";
$hlavicka->m63cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m61b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m62b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m63b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m61c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m62c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m63c","$rmc",1,"R");

if( $hlavicka->m71b == 0 ) $hlavicka->m71b ="";
if( $hlavicka->m72b == 0 ) $hlavicka->m72b ="";
if( $hlavicka->m73b == 0 ) $hlavicka->m73b ="";
if( $hlavicka->m71c == 0 ) $hlavicka->m71c ="";
if( $hlavicka->m72c == 0 ) $hlavicka->m72c ="";
if( $hlavicka->m73c == 0 ) $hlavicka->m73c ="";

$hlavicka->m71bnyg46="1234.56";
$hlavicka->m72bnyg46="1234.56";
$hlavicka->m73bnyg46="1234.56";
$hlavicka->m71cnyg46="1234.56";
$hlavicka->m72cnyg46="1234.56";
$hlavicka->m73cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m71b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m72b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m73b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m71c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m72c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m73c","$rmc",1,"R");

if( $hlavicka->m81b == 0 ) $hlavicka->m81b ="";
if( $hlavicka->m82b == 0 ) $hlavicka->m82b ="";
if( $hlavicka->m83b == 0 ) $hlavicka->m83b ="";
if( $hlavicka->m81c == 0 ) $hlavicka->m81c ="";
if( $hlavicka->m82c == 0 ) $hlavicka->m82c ="";
if( $hlavicka->m83c == 0 ) $hlavicka->m83c ="";

$hlavicka->m81bnyg46="1234.56";
$hlavicka->m82bnyg46="1234.56";
$hlavicka->m83bnyg46="1234.56";
$hlavicka->m81cnyg46="1234.56";
$hlavicka->m82cnyg46="1234.56";
$hlavicka->m83cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m81b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m82b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m83b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m81c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m82c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m83c","$rmc",1,"R");

if( $hlavicka->m91b == 0 ) $hlavicka->m91b ="";
if( $hlavicka->m92b == 0 ) $hlavicka->m92b ="";
if( $hlavicka->m93b == 0 ) $hlavicka->m93b ="";
if( $hlavicka->m91c == 0 ) $hlavicka->m91c ="";
if( $hlavicka->m92c == 0 ) $hlavicka->m92c ="";
if( $hlavicka->m93c == 0 ) $hlavicka->m93c ="";

$hlavicka->m91bnyg46="1234.56";
$hlavicka->m92bnyg46="1234.56";
$hlavicka->m93bnyg46="1234.56";
$hlavicka->m91cnyg46="1234.56";
$hlavicka->m92cnyg46="1234.56";
$hlavicka->m93cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m91b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m92b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m93b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m91c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m92c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m93c","$rmc",1,"R");

if( $hlavicka->m101b == 0 ) $hlavicka->m101b ="";
if( $hlavicka->m102b == 0 ) $hlavicka->m102b ="";
if( $hlavicka->m103b == 0 ) $hlavicka->m103b ="";
if( $hlavicka->m101c == 0 ) $hlavicka->m101c ="";
if( $hlavicka->m102c == 0 ) $hlavicka->m102c ="";
if( $hlavicka->m103c == 0 ) $hlavicka->m103c ="";

$hlavicka->m101bnyg46="1234.56";
$hlavicka->m102bnyg46="1234.56";
$hlavicka->m103bnyg46="1234.56";
$hlavicka->m101cnyg46="1234.56";
$hlavicka->m102cnyg46="1234.56";
$hlavicka->m103cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m101b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m102b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m103b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m101c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m102c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m103c","$rmc",1,"R");

if( $hlavicka->m111b == 0 ) $hlavicka->m111b ="";
if( $hlavicka->m112b == 0 ) $hlavicka->m112b ="";
if( $hlavicka->m113b == 0 ) $hlavicka->m113b ="";
if( $hlavicka->m111c == 0 ) $hlavicka->m111c ="";
if( $hlavicka->m112c == 0 ) $hlavicka->m112c ="";
if( $hlavicka->m113c == 0 ) $hlavicka->m113c ="";

$hlavicka->m111bnyg46="1234.56";
$hlavicka->m112bnyg46="1234.56";
$hlavicka->m113bnyg46="1234.56";
$hlavicka->m111cnyg46="1234.56";
$hlavicka->m112cnyg46="1234.56";
$hlavicka->m113cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m111b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m112b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m113b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m111c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m112c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m113c","$rmc",1,"R");

if( $hlavicka->m121b == 0 ) $hlavicka->m121b ="";
if( $hlavicka->m122b == 0 ) $hlavicka->m122b ="";
if( $hlavicka->m123b == 0 ) $hlavicka->m123b ="";
if( $hlavicka->m121c == 0 ) $hlavicka->m121c ="";
if( $hlavicka->m122c == 0 ) $hlavicka->m122c ="";
if( $hlavicka->m123c == 0 ) $hlavicka->m123c ="";

$hlavicka->m121bnyg46="1234.56";
$hlavicka->m122bnyg46="1234.56";
$hlavicka->m123bnyg46="1234.56";
$hlavicka->m121cnyg46="1234.56";
$hlavicka->m122cnyg46="1234.56";
$hlavicka->m123cnyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m121b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m122b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m123b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m121c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m122c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m123c","$rmc",1,"R");

if( $hlavicka->m131b == 0 ) $hlavicka->m131b ="";
if( $hlavicka->m132b == 0 ) $hlavicka->m132b ="";
if( $hlavicka->m133b == 0 ) $hlavicka->m133b ="";
if( $hlavicka->m131c == 0 ) $hlavicka->m131c ="";
if( $hlavicka->m132c == 0 ) $hlavicka->m132c ="";
if( $hlavicka->m133c == 0 ) $hlavicka->m133c ="";

$hlavicka->m131bnyg46="1234.56";
$hlavicka->m132bnyg46="1234.56";
$hlavicka->m133bnyg46="1234.56";
$hlavicka->m131cnyg46="1234.56";
$hlavicka->m132cnyg46="1234.56";
$hlavicka->m133cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m131b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m132b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m133b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m131c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m132c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m133c","$rmc",1,"R");

if( $hlavicka->m141b == 0 ) $hlavicka->m141b ="";
if( $hlavicka->m142b == 0 ) $hlavicka->m142b ="";
if( $hlavicka->m143b == 0 ) $hlavicka->m143b ="";
if( $hlavicka->m141c == 0 ) $hlavicka->m141c ="";
if( $hlavicka->m142c == 0 ) $hlavicka->m142c ="";
if( $hlavicka->m143c == 0 ) $hlavicka->m143c ="";

$hlavicka->m141bnyg46="1234.56";
$hlavicka->m142bnyg46="1234.56";
$hlavicka->m143bnyg46="1234.56";
$hlavicka->m141cnyg46="1234.56";
$hlavicka->m142cnyg46="1234.56";
$hlavicka->m143cnyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(49,5," ","$rmc",0,"L");$pdf->Cell(21,5,"$hlavicka->m141b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m142b","$rmc",0,"R");$pdf->Cell(22,5,"$hlavicka->m143b","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m141c","$rmc",0,"R");$pdf->Cell(21,5,"$hlavicka->m142c","$rmc",0,"R");
$pdf->Cell(21,5,"$hlavicka->m143c","$rmc",1,"R");


//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="M_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(211);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 36

if ( $nopg37 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab46_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab46_1.jpg',0,43,210,99);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"N. INFORMÁCIE O EKONOMICKİCH VZAHOCH ÚÈTOVNEJ JEDNOTKY A SPRIAZNENİCH OSôB","$rmc",1,"L");
$pdf->Cell(90,6," ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,5,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"46. Informácie k èasti N prílohy è.3 o ekonomickıch vzahoch medzi úètovnou jednotkou a spriznenımi osobami","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");
$pdf->Cell(90,29,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
//N ekonomicke vztahy UJ a spriaznenych osob tab46.1

if( $hlavicka->n1b12 == 0 ) $hlavicka->n1b12 ="";
if( $hlavicka->n1c13 == 0 ) $hlavicka->n1c13 ="";
if( $hlavicka->n1d14 == 0 ) $hlavicka->n1d14 ="";

$hlavicka->n1a11nyg46="1234.56";
$hlavicka->n1b12nyg46="1234.56";
$hlavicka->n1c13nyg46="1234.56";
$hlavicka->n1d14nyg46="1234.56";

$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a11","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b12","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c13","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d14","$rmc",1,"R");

if( $hlavicka->n1b22 == 0 ) $hlavicka->n1b22 ="";
if( $hlavicka->n1c23 == 0 ) $hlavicka->n1c23 ="";
if( $hlavicka->n1d24 == 0 ) $hlavicka->n1d24 ="";

$hlavicka->n1a21nyg46="1234.56";
$hlavicka->n1b22nyg46="1234.56";
$hlavicka->n1c23nyg46="1234.56";
$hlavicka->n1d24nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a21","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b22","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c23","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d24","$rmc",1,"R");

if( $hlavicka->n1b32 == 0 ) $hlavicka->n1b32 ="";
if( $hlavicka->n1c33 == 0 ) $hlavicka->n1c33 ="";
if( $hlavicka->n1d34 == 0 ) $hlavicka->n1d34 ="";

$hlavicka->n1a31nyg46="1234.56";
$hlavicka->n1b32nyg46="1234.56";
$hlavicka->n1c33nyg46="1234.56";
$hlavicka->n1d34nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a31","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b32","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c33","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d34","$rmc",1,"R");

if( $hlavicka->n1b42 == 0 ) $hlavicka->n1b42 ="";
if( $hlavicka->n1c43 == 0 ) $hlavicka->n1c43 ="";
if( $hlavicka->n1d44 == 0 ) $hlavicka->n1d44 ="";

$hlavicka->n1a41nyg46="1234.56";
$hlavicka->n1b42nyg46="1234.56";
$hlavicka->n1c43nyg46="1234.56";
$hlavicka->n1d44nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a41","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b42","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c43","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d44","$rmc",1,"R");

if( $hlavicka->n1b52 == 0 ) $hlavicka->n1b52 ="";
if( $hlavicka->n1c53 == 0 ) $hlavicka->n1c53 ="";
if( $hlavicka->n1d54 == 0 ) $hlavicka->n1d54 ="";

$hlavicka->n1a51nyg46="1234.56";
$hlavicka->n1b52nyg46="1234.56";
$hlavicka->n1c53nyg46="1234.56";
$hlavicka->n1d54nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a51","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b52","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c53","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d54","$rmc",1,"R");

if( $hlavicka->n1b62 == 0 ) $hlavicka->n1b62 ="";
if( $hlavicka->n1c63 == 0 ) $hlavicka->n1c63 ="";
if( $hlavicka->n1d64 == 0 ) $hlavicka->n1d64 ="";

$hlavicka->n1a61nyg46="1234.56";
$hlavicka->n1b62nyg46="1234.56";
$hlavicka->n1c63nyg46="1234.56";
$hlavicka->n1d64nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a61","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b62","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c63","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d64","$rmc",1,"R");

if( $hlavicka->n1b72 == 0 ) $hlavicka->n1b72 ="";
if( $hlavicka->n1c73 == 0 ) $hlavicka->n1c73 ="";
if( $hlavicka->n1d74 == 0 ) $hlavicka->n1d74 ="";

$hlavicka->n1a71nyg46="1234.56";
$hlavicka->n1b72nyg46="1234.56";
$hlavicka->n1c73nyg46="1234.56";
$hlavicka->n1d74nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a71","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b72","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c73","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d74","$rmc",1,"R");

if( $hlavicka->n1b82 == 0 ) $hlavicka->n1b82 ="";
if( $hlavicka->n1c83 == 0 ) $hlavicka->n1c83 ="";
if( $hlavicka->n1d84 == 0 ) $hlavicka->n1d84 ="";

$hlavicka->n1a81nyg46="1234.56";
$hlavicka->n1b82nyg46="1234.56";
$hlavicka->n1c83nyg46="1234.56";
$hlavicka->n1d84nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a81","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b82","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c83","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d84","$rmc",1,"R");

if( $hlavicka->n1b92 == 0 ) $hlavicka->n1b92 ="";
if( $hlavicka->n1c93 == 0 ) $hlavicka->n1c93 ="";
if( $hlavicka->n1d94 == 0 ) $hlavicka->n1d94 ="";

$hlavicka->n1a91nyg46="1234.56";
$hlavicka->n1b92nyg46="1234.56";
$hlavicka->n1c93nyg46="1234.56";
$hlavicka->n1d94nyg46="1234.56";

$pdf->Cell(90,1,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a91","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b92","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c93","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d94","$rmc",1,"R");

if( $hlavicka->n1b102 == 0 ) $hlavicka->n1b102 ="";
if( $hlavicka->n1c103 == 0 ) $hlavicka->n1c103 ="";
if( $hlavicka->n1d104 == 0 ) $hlavicka->n1d104 ="";

$hlavicka->n1a101nyg46="1234.56";
$hlavicka->n1b102nyg46="1234.56";
$hlavicka->n1c103nyg46="1234.56";
$hlavicka->n1d104nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(13,5," ","$rmc",0,"L");$pdf->Cell(51,5,"$hlavicka->n1a101","$rmc",0,"L");
$pdf->Cell(25,5,"$hlavicka->n1b102","$rmc",0,"C");$pdf->Cell(44,5,"$hlavicka->n1c103","$rmc",0,"R");
$pdf->Cell(44,5,"$hlavicka->n1d104","$rmc",1,"R");





//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="N_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(142);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 37

if ( $nopg38 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//velky nadpis
$pdf->SetFont('arial','',9);
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"O. INFORMÁCIE O SKUTOÈNOSTIACH, KTORÉ NASTALI PO DNI, KU KTORÉMU SA ZOSTAVUJE","$rmc",1,"L");
$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"ÚÈTOVNÁ ZÁVIERKA DO DÒA ZOSTAVENIA ÚÈTOVNEJ ZÁVIERKY","$rmc",1,"L");
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
                                        } //koniec strana 38


if ( $nopg39 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_1.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_1.jpg',0,45,210,120);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_1b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_1b.jpg',0,164.2,210,75);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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



//velky nadpis
$pdf->SetFont('arial','',9);

$pdf->Cell(10,6," ","$rmc",0,"L");$pdf->Cell(0,6,"P. PREH¼AD ZMIEN VLASTNÉHO IMANIA","$rmc",1,"L");
$pdf->Cell(90,6," ","$rmc",1,"L");


//prva tabulka

$pdf->Cell(90,5,"     ","$rmc1",1,"L");  
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"47. Informácie k èasti P prílohy è.3 o zmenách vlastného imania","$rmc",1,"L");
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.1","$rmc",1,"L");
$pdf->Cell(90,28,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);

//tab47.1 P zmeny vlastneho imania tab1

if( $hlavicka->p1b1 == 0 ) $hlavicka->p1b1 ="";
if( $hlavicka->p1c1 == 0 ) $hlavicka->p1c1 ="";
if( $hlavicka->p1d1 == 0 ) $hlavicka->p1d1 ="";
if( $hlavicka->p1e1 == 0 ) $hlavicka->p1e1 ="";
if( $hlavicka->p1f1 == 0 ) $hlavicka->p1f1 ="";

$hlavicka->p1b1nyg46="1234.56";
$hlavicka->p1c1nyg46="1234.56";
$hlavicka->p1d1nyg46="1234.56";
$hlavicka->p1e1nyg46="1234.56";
$hlavicka->p1f1nyg46="1234.56";

$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b1","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d1","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f1","$rmc",1,"R");

if( $hlavicka->p1b2 == 0 ) $hlavicka->p1b2 ="";
if( $hlavicka->p1c2 == 0 ) $hlavicka->p1c2 ="";
if( $hlavicka->p1d2 == 0 ) $hlavicka->p1d2 ="";
if( $hlavicka->p1e2 == 0 ) $hlavicka->p1e2 ="";
if( $hlavicka->p1f2 == 0 ) $hlavicka->p1f2 ="";

$hlavicka->p1b2nyg46="1234.56";
$hlavicka->p1c2nyg46="1234.56";
$hlavicka->p1d2nyg46="1234.56";
$hlavicka->p1e2nyg46="1234.56";
$hlavicka->p1f2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b2","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d2","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f2","$rmc",1,"R");

if( $hlavicka->p1b3 == 0 ) $hlavicka->p1b3 ="";
if( $hlavicka->p1c3 == 0 ) $hlavicka->p1c3 ="";
if( $hlavicka->p1d3 == 0 ) $hlavicka->p1d3 ="";
if( $hlavicka->p1e3 == 0 ) $hlavicka->p1e3 ="";
if( $hlavicka->p1f3 == 0 ) $hlavicka->p1f3 ="";

$hlavicka->p1b3nyg46="1234.56";
$hlavicka->p1c3nyg46="1234.56";
$hlavicka->p1d3nyg46="1234.56";
$hlavicka->p1e3nyg46="1234.56";
$hlavicka->p1f3nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b3","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c3","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d3","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e3","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f3","$rmc",1,"R");

if( $hlavicka->p1b4 == 0 ) $hlavicka->p1b4 ="";
if( $hlavicka->p1c4 == 0 ) $hlavicka->p1c4 ="";
if( $hlavicka->p1d4 == 0 ) $hlavicka->p1d4 ="";
if( $hlavicka->p1e4 == 0 ) $hlavicka->p1e4 ="";
if( $hlavicka->p1f4 == 0 ) $hlavicka->p1f4 ="";

$hlavicka->p1b4nyg46="1234.56";
$hlavicka->p1c4nyg46="1234.56";
$hlavicka->p1d4nyg46="1234.56";
$hlavicka->p1e4nyg46="1234.56";
$hlavicka->p1f4nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b4","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c4","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d4","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e4","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f4","$rmc",1,"R");

if( $hlavicka->p1b5 == 0 ) $hlavicka->p1b5 ="";
if( $hlavicka->p1c5 == 0 ) $hlavicka->p1c5 ="";
if( $hlavicka->p1d5 == 0 ) $hlavicka->p1d5 ="";
if( $hlavicka->p1e5 == 0 ) $hlavicka->p1e5 ="";
if( $hlavicka->p1f5 == 0 ) $hlavicka->p1f5 ="";

$hlavicka->p1b5nyg46="1234.56";
$hlavicka->p1c5nyg46="1234.56";
$hlavicka->p1d5nyg46="1234.56";
$hlavicka->p1e5nyg46="1234.56";
$hlavicka->p1f5nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b5","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c5","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d5","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e5","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f5","$rmc",1,"R");

if( $hlavicka->p1b6 == 0 ) $hlavicka->p1b6 ="";
if( $hlavicka->p1c6 == 0 ) $hlavicka->p1c6 ="";
if( $hlavicka->p1d6 == 0 ) $hlavicka->p1d6 ="";
if( $hlavicka->p1e6 == 0 ) $hlavicka->p1e6 ="";
if( $hlavicka->p1f6 == 0 ) $hlavicka->p1f6 ="";

$hlavicka->p1b6nyg46="1234.56";
$hlavicka->p1c6nyg46="1234.56";
$hlavicka->p1d6nyg46="1234.56";
$hlavicka->p1e6nyg46="1234.56";
$hlavicka->p1f6nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b6","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c6","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d6","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e6","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f6","$rmc",1,"R");


if( $hlavicka->p1b7 == 0 ) $hlavicka->p1b7 ="";
if( $hlavicka->p1c7 == 0 ) $hlavicka->p1c7 ="";
if( $hlavicka->p1d7 == 0 ) $hlavicka->p1d7 ="";
if( $hlavicka->p1e7 == 0 ) $hlavicka->p1e7 ="";
if( $hlavicka->p1f7 == 0 ) $hlavicka->p1f7 ="";

$hlavicka->p1b7nyg46="1234.56";
$hlavicka->p1c7nyg46="1234.56";
$hlavicka->p1d7nyg46="1234.56";
$hlavicka->p1e7nyg46="1234.56";
$hlavicka->p1f7nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b7","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c7","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d7","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e7","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f7","$rmc",1,"R");

if( $hlavicka->p1b8 == 0 ) $hlavicka->p1b8 ="";
if( $hlavicka->p1c8 == 0 ) $hlavicka->p1c8 ="";
if( $hlavicka->p1d8 == 0 ) $hlavicka->p1d8 ="";
if( $hlavicka->p1e8 == 0 ) $hlavicka->p1e8="";
if( $hlavicka->p1f8 == 0 ) $hlavicka->p1f8 ="";

$hlavicka->p1b8nyg46="1234.56";
$hlavicka->p1c8nyg46="1234.56";
$hlavicka->p1d8nyg46="1234.56";
$hlavicka->p1e8nyg46="1234.56";
$hlavicka->p1f8nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b8","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c8","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d8","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e8","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f8","$rmc",1,"R");

if( $hlavicka->p1b9 == 0 ) $hlavicka->p1b9 ="";
if( $hlavicka->p1c9 == 0 ) $hlavicka->p1c9 ="";
if( $hlavicka->p1d9 == 0 ) $hlavicka->p1d9 ="";
if( $hlavicka->p1e9 == 0 ) $hlavicka->p1e9="";
if( $hlavicka->p1f9 == 0 ) $hlavicka->p1f9 ="";

$hlavicka->p1b9nyg46="1234.56";
$hlavicka->p1c9nyg46="1234.56";
$hlavicka->p1d9nyg46="1234.56";
$hlavicka->p1e9nyg46="1234.56";
$hlavicka->p1f9nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b9","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c9","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d9","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e9","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f9","$rmc",1,"R");

if( $hlavicka->p1b10 == 0 ) $hlavicka->p1b10 ="";
if( $hlavicka->p1c10 == 0 ) $hlavicka->p1c10 ="";
if( $hlavicka->p1d10 == 0 ) $hlavicka->p1d10 ="";
if( $hlavicka->p1e10 == 0 ) $hlavicka->p1e10="";
if( $hlavicka->p1f10 == 0 ) $hlavicka->p1f10 ="";

$hlavicka->p1b10nyg46="1234.56";
$hlavicka->p1c10nyg46="1234.56";
$hlavicka->p1d10nyg46="1234.56";
$hlavicka->p1e10nyg46="1234.56";
$hlavicka->p1f10nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b10","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c10","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d10","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e10","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f10","$rmc",1,"R");

if( $hlavicka->p1b11 == 0 ) $hlavicka->p1b11 ="";
if( $hlavicka->p1c11 == 0 ) $hlavicka->p1c11 ="";
if( $hlavicka->p1d11 == 0 ) $hlavicka->p1d11 ="";
if( $hlavicka->p1e11 == 0 ) $hlavicka->p1e11="";
if( $hlavicka->p1f11 == 0 ) $hlavicka->p1f11 ="";

$hlavicka->p1b11nyg46="1234.56";
$hlavicka->p1c11nyg46="1234.56";
$hlavicka->p1d11nyg46="1234.56";
$hlavicka->p1e11nyg46="1234.56";
$hlavicka->p1f11nyg46="1234.56";

$pdf->Cell(90,5,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b11","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c11","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d11","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e11","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f11","$rmc",1,"R");

if( $hlavicka->p1b12 == 0 ) $hlavicka->p1b12 ="";
if( $hlavicka->p1c12 == 0 ) $hlavicka->p1c12 ="";
if( $hlavicka->p1d12 == 0 ) $hlavicka->p1d12 ="";
if( $hlavicka->p1e12 == 0 ) $hlavicka->p1e12="";
if( $hlavicka->p1f12 == 0 ) $hlavicka->p1f12 ="";

$hlavicka->p1b12nyg46="1234.56";
$hlavicka->p1c12nyg46="1234.56";
$hlavicka->p1d12nyg46="1234.56";
$hlavicka->p1e12nyg46="1234.56";
$hlavicka->p1f12nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b12","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c12","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d12","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e12","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f12","$rmc",1,"R");

if( $hlavicka->p1b13 == 0 ) $hlavicka->p1b13 ="";
if( $hlavicka->p1c13 == 0 ) $hlavicka->p1c13 ="";
if( $hlavicka->p1d13 == 0 ) $hlavicka->p1d13 ="";
if( $hlavicka->p1e13 == 0 ) $hlavicka->p1e13="";
if( $hlavicka->p1f13 == 0 ) $hlavicka->p1f13 ="";

$hlavicka->p1b13nyg46="1234.56";
$hlavicka->p1c13nyg46="1234.56";
$hlavicka->p1d13nyg46="1234.56";
$hlavicka->p1e13nyg46="1234.56";
$hlavicka->p1f13nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b13","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c13","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d13","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e13","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f13","$rmc",1,"R");

if( $hlavicka->p1b14 == 0 ) $hlavicka->p1b14 ="";
if( $hlavicka->p1c14 == 0 ) $hlavicka->p1c14 ="";
if( $hlavicka->p1d14 == 0 ) $hlavicka->p1d14 ="";
if( $hlavicka->p1e14 == 0 ) $hlavicka->p1e14="";
if( $hlavicka->p1f14 == 0 ) $hlavicka->p1f14 ="";

$hlavicka->p1b14nyg46="1234.56";
$hlavicka->p1c14nyg46="1234.56";
$hlavicka->p1d14nyg46="1234.56";
$hlavicka->p1e14nyg46="1234.56";
$hlavicka->p1f14nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b14","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c14","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d14","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e14","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f14","$rmc",1,"R");


if( $hlavicka->p1b15 == 0 ) $hlavicka->p1b15 ="";
if( $hlavicka->p1c15 == 0 ) $hlavicka->p1c15 ="";
if( $hlavicka->p1d15 == 0 ) $hlavicka->p1d15 ="";
if( $hlavicka->p1e15 == 0 ) $hlavicka->p1e15="";
if( $hlavicka->p1f15 == 0 ) $hlavicka->p1f15 ="";

$hlavicka->p1b15nyg46="1234.56";
$hlavicka->p1c15nyg46="1234.56";
$hlavicka->p1d15nyg46="1234.56";
$hlavicka->p1e15nyg46="1234.56";
$hlavicka->p1f15nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b15","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c15","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d15","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e15","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f15","$rmc",1,"R");

if( $hlavicka->p1b16 == 0 ) $hlavicka->p1b16 ="";
if( $hlavicka->p1c16 == 0 ) $hlavicka->p1c16 ="";
if( $hlavicka->p1d16 == 0 ) $hlavicka->p1d16 ="";
if( $hlavicka->p1e16 == 0 ) $hlavicka->p1e16="";
if( $hlavicka->p1f16 == 0 ) $hlavicka->p1f16 ="";

$hlavicka->p1b16nyg46="1234.56";
$hlavicka->p1c16nyg46="1234.56";
$hlavicka->p1d16nyg46="1234.56";
$hlavicka->p1e16nyg46="1234.56";
$hlavicka->p1f16nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b16","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c16","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d16","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e16","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f16","$rmc",1,"R");


if( $hlavicka->p1b18 == 0 ) $hlavicka->p1b18 ="";
if( $hlavicka->p1c18 == 0 ) $hlavicka->p1c18 ="";
if( $hlavicka->p1d18 == 0 ) $hlavicka->p1d18 ="";
if( $hlavicka->p1e18 == 0 ) $hlavicka->p1e18="";
if( $hlavicka->p1f18 == 0 ) $hlavicka->p1f18 ="";

$hlavicka->p1b18nyg46="1234.56";
$hlavicka->p1c18nyg46="1234.56";
$hlavicka->p1d18nyg46="1234.56";
$hlavicka->p1e18nyg46="1234.56";
$hlavicka->p1f18nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b18","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c18","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d18","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e18","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f18","$rmc",1,"R");

if( $hlavicka->p1b19 == 0 ) $hlavicka->p1b19 ="";
if( $hlavicka->p1c19 == 0 ) $hlavicka->p1c19 ="";
if( $hlavicka->p1d19 == 0 ) $hlavicka->p1d19 ="";
if( $hlavicka->p1e19 == 0 ) $hlavicka->p1e19 ="";
if( $hlavicka->p1f19 == 0 ) $hlavicka->p1f19 ="";

$hlavicka->p1b19nyg46="1234.56";
$hlavicka->p1c19nyg46="1234.56";
$hlavicka->p1d19nyg46="1234.56";
$hlavicka->p1e19nyg46="1234.56";
$hlavicka->p1f19nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p1b19","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1c19","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1d19","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p1e19","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p1f19","$rmc",1,"R");






//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="P_text1"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(241);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 39

if ( $nopg40 == 0 AND $strana == 9999 ) {
$pdf->AddPage();
$pdf->SetFont('arial','',9);
$pdf->SetLeftMargin(10);
$pdf->SetTopMargin(10);
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_2.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_2.jpg',0,30,210,143);
}
if ( File_Exists('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_2b.jpg') AND $i == 0 )
{
$pdf->Image('../dokumenty/dan_z_prijmov2013/poznamkypo2013tabtext/poznamkypo_tab47_2b.jpg',-0.5,173,210.5,48);
}

//hlavicka strany
$stranax=$stranax+1;
$pdf->SetY(5);
$pdf->Cell(48,7,"Poznámky Úè $nazpoz","1",0,"L");
$pdf->Cell(42,7," ","$rmc1",0,"L");$pdf->Cell(10,7,"- $stranax -","$rmc1",0,"C");$pdf->Cell(42,7," ","$rmc1",0,"L");
$pdf->Cell(8,7,"DIÈ","$rmc1",0,"L");
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




//prva tabulka

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
$pdf->Cell(13,4," ","$rmc",0,"L");$pdf->Cell(0,4,"Tabu¾ka è.2","$rmc",1,"L");
$pdf->Cell(90,30,"     ","$rmc1",1,"L");
$pdf->SetFont('arial','',8);
// zmeny vlastneho imania tab47.2

if( $hlavicka->p2b1 == 0 ) $hlavicka->p2b1 ="";
if( $hlavicka->p2c1 == 0 ) $hlavicka->p2c1 ="";
if( $hlavicka->p2d1 == 0 ) $hlavicka->p2d1 ="";
if( $hlavicka->p2e1 == 0 ) $hlavicka->p2e1 ="";
if( $hlavicka->p2f1 == 0 ) $hlavicka->p2f1 ="";

$hlavicka->p2b1nyg46="1234.56";
$hlavicka->p2c1nyg46="1234.56";
$hlavicka->p2d1nyg46="1234.56";
$hlavicka->p2e1nyg46="1234.56";
$hlavicka->p2f1nyg46="1234.56";

$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b1","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d1","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e1","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f1","$rmc",1,"R");

if( $hlavicka->p2b2 == 0 ) $hlavicka->p2b2 ="";
if( $hlavicka->p2c2 == 0 ) $hlavicka->p2c2 ="";
if( $hlavicka->p2d2 == 0 ) $hlavicka->p2d2 ="";
if( $hlavicka->p2e2 == 0 ) $hlavicka->p2e2 ="";
if( $hlavicka->p2f2 == 0 ) $hlavicka->p2f2 ="";

$hlavicka->p2b2nyg46="1234.56";
$hlavicka->p2c2nyg46="1234.56";
$hlavicka->p2d2nyg46="1234.56";
$hlavicka->p2e2nyg46="1234.56";
$hlavicka->p2f2nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b2","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d2","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e2","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f2","$rmc",1,"R");

if( $hlavicka->p2b3 == 0 ) $hlavicka->p2b3 ="";
if( $hlavicka->p2c3 == 0 ) $hlavicka->p2c3 ="";
if( $hlavicka->p2d3 == 0 ) $hlavicka->p2d3 ="";
if( $hlavicka->p2e3 == 0 ) $hlavicka->p2e3 ="";
if( $hlavicka->p2f3 == 0 ) $hlavicka->p2f3 ="";

$hlavicka->p2b3nyg46="1234.56";
$hlavicka->p2c3nyg46="1234.56";
$hlavicka->p2d3nyg46="1234.56";
$hlavicka->p2e3nyg46="1234.56";
$hlavicka->p2f3nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b3","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c3","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d3","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e3","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f3","$rmc",1,"R");

if( $hlavicka->p2b4 == 0 ) $hlavicka->p2b4 ="";
if( $hlavicka->p2c4 == 0 ) $hlavicka->p2c4 ="";
if( $hlavicka->p2d4 == 0 ) $hlavicka->p2d4 ="";
if( $hlavicka->p2e4 == 0 ) $hlavicka->p2e4 ="";
if( $hlavicka->p2f4 == 0 ) $hlavicka->p2f4 ="";

$hlavicka->p2b4nyg46="1234.56";
$hlavicka->p2c4nyg46="1234.56";
$hlavicka->p2d4nyg46="1234.56";
$hlavicka->p2e4nyg46="1234.56";
$hlavicka->p2f4nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b4","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c4","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d4","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e4","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f4","$rmc",1,"R");

if( $hlavicka->p2b5 == 0 ) $hlavicka->p2b5 ="";
if( $hlavicka->p2c5 == 0 ) $hlavicka->p2c5 ="";
if( $hlavicka->p2d5 == 0 ) $hlavicka->p2d5 ="";
if( $hlavicka->p2e5 == 0 ) $hlavicka->p2e5 ="";
if( $hlavicka->p2f5 == 0 ) $hlavicka->p2f5 ="";

$hlavicka->p2b5nyg46="1234.56";
$hlavicka->p2c5nyg46="1234.56";
$hlavicka->p2d5nyg46="1234.56";
$hlavicka->p2e5nyg46="1234.56";
$hlavicka->p2f5nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b5","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c5","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d5","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e5","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f5","$rmc",1,"R");

if( $hlavicka->p2b6 == 0 ) $hlavicka->p2b6 ="";
if( $hlavicka->p2c6 == 0 ) $hlavicka->p2c6 ="";
if( $hlavicka->p2d6 == 0 ) $hlavicka->p2d6 ="";
if( $hlavicka->p2e6 == 0 ) $hlavicka->p2e6 ="";
if( $hlavicka->p2f6 == 0 ) $hlavicka->p2f6 ="";

$hlavicka->p2b6nyg46="1234.56";
$hlavicka->p2c6nyg46="1234.56";
$hlavicka->p2d6nyg46="1234.56";
$hlavicka->p2e6nyg46="1234.56";
$hlavicka->p2f6nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b6","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c6","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d6","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e6","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f6","$rmc",1,"R");


if( $hlavicka->p2b7 == 0 ) $hlavicka->p2b7 ="";
if( $hlavicka->p2c7 == 0 ) $hlavicka->p2c7 ="";
if( $hlavicka->p2d7 == 0 ) $hlavicka->p2d7 ="";
if( $hlavicka->p2e7 == 0 ) $hlavicka->p2e7 ="";
if( $hlavicka->p2f7 == 0 ) $hlavicka->p2f7 ="";

$hlavicka->p2b7nyg46="1234.56";
$hlavicka->p2c7nyg46="1234.56";
$hlavicka->p2d7nyg46="1234.56";
$hlavicka->p2e7nyg46="1234.56";
$hlavicka->p2f7nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b7","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c7","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d7","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e7","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f7","$rmc",1,"R");

if( $hlavicka->p2b8 == 0 ) $hlavicka->p2b8 ="";
if( $hlavicka->p2c8 == 0 ) $hlavicka->p2c8 ="";
if( $hlavicka->p2d8 == 0 ) $hlavicka->p2d8 ="";
if( $hlavicka->p2e8 == 0 ) $hlavicka->p2e8 ="";
if( $hlavicka->p2f8 == 0 ) $hlavicka->p2f8 ="";

$hlavicka->p2b8nyg46="1234.56";
$hlavicka->p2c8nyg46="1234.56";
$hlavicka->p2d8nyg46="1234.56";
$hlavicka->p2e8nyg46="1234.56";
$hlavicka->p2f8nyg46="1234.56";

$pdf->Cell(90,8,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b8","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c8","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d8","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e8","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f8","$rmc",1,"R");

if( $hlavicka->p2b9 == 0 ) $hlavicka->p2b9 ="";
if( $hlavicka->p2c9 == 0 ) $hlavicka->p2c9 ="";
if( $hlavicka->p2d9 == 0 ) $hlavicka->p2d9 ="";
if( $hlavicka->p2e9 == 0 ) $hlavicka->p2e9 ="";
if( $hlavicka->p2f9 == 0 ) $hlavicka->p2f9 ="";

$hlavicka->p2b9nyg46="1234.56";
$hlavicka->p2c9nyg46="1234.56";
$hlavicka->p2d9nyg46="1234.56";
$hlavicka->p2e9nyg46="1234.56";
$hlavicka->p2f9nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b9","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c9","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d9","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e9","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f9","$rmc",1,"R");

if( $hlavicka->p2b10 == 0 ) $hlavicka->p2b10 ="";
if( $hlavicka->p2c10 == 0 ) $hlavicka->p2c10 ="";
if( $hlavicka->p2d10 == 0 ) $hlavicka->p2d10 ="";
if( $hlavicka->p2e10 == 0 ) $hlavicka->p2e10 ="";
if( $hlavicka->p2f10 == 0 ) $hlavicka->p2f10 ="";

$hlavicka->p2b10nyg46="1234.56";
$hlavicka->p2c10nyg46="1234.56";
$hlavicka->p2d10nyg46="1234.56";
$hlavicka->p2e10nyg46="1234.56";
$hlavicka->p2f10nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b10","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c10","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d10","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e10","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f10","$rmc",1,"R");


if( $hlavicka->p2b11 == 0 ) $hlavicka->p2b11 ="";
if( $hlavicka->p2c11 == 0 ) $hlavicka->p2c11 ="";
if( $hlavicka->p2d11 == 0 ) $hlavicka->p2d11 ="";
if( $hlavicka->p2e11 == 0 ) $hlavicka->p2e11 ="";
if( $hlavicka->p2f11 == 0 ) $hlavicka->p2f11 ="";

$hlavicka->p2b11nyg46="1234.56";
$hlavicka->p2c11nyg46="1234.56";
$hlavicka->p2d11nyg46="1234.56";
$hlavicka->p2e11nyg46="1234.56";
$hlavicka->p2f11nyg46="1234.56";

$pdf->Cell(90,7,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b11","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c11","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d11","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e11","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f11","$rmc",1,"R");

if( $hlavicka->p2b12 == 0 ) $hlavicka->p2b12 ="";
if( $hlavicka->p2c12 == 0 ) $hlavicka->p2c12 ="";
if( $hlavicka->p2d12 == 0 ) $hlavicka->p2d12 ="";
if( $hlavicka->p2e12 == 0 ) $hlavicka->p2e12 ="";
if( $hlavicka->p2f12 == 0 ) $hlavicka->p2f12 ="";

$hlavicka->p2b12nyg46="1234.56";
$hlavicka->p2c12nyg46="1234.56";
$hlavicka->p2d12nyg46="1234.56";
$hlavicka->p2e12nyg46="1234.56";
$hlavicka->p2f12nyg46="1234.56";

$pdf->Cell(90,0,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b12","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c12","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d12","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e12","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f12","$rmc",1,"R");

if( $hlavicka->p2b13 == 0 ) $hlavicka->p2b13 ="";
if( $hlavicka->p2c13 == 0 ) $hlavicka->p2c13 ="";
if( $hlavicka->p2d13 == 0 ) $hlavicka->p2d13 ="";
if( $hlavicka->p2e13 == 0 ) $hlavicka->p2e13 ="";
if( $hlavicka->p2f13 == 0 ) $hlavicka->p2f13 ="";

$hlavicka->p2b13nyg46="1234.56";
$hlavicka->p2c13nyg46="1234.56";
$hlavicka->p2d13nyg46="1234.56";
$hlavicka->p2e13nyg46="1234.56";
$hlavicka->p2f13nyg46="1234.56";

$pdf->Cell(90,2,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b13","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c13","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d13","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e13","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f13","$rmc",1,"R");

if( $hlavicka->p2b14 == 0 ) $hlavicka->p2b14 ="";
if( $hlavicka->p2c14 == 0 ) $hlavicka->p2c14 ="";
if( $hlavicka->p2d14 == 0 ) $hlavicka->p2d14 ="";
if( $hlavicka->p2e14 == 0 ) $hlavicka->p2e14 ="";
if( $hlavicka->p2f14 == 0 ) $hlavicka->p2f14 ="";

$hlavicka->p2b14nyg46="1234.56";
$hlavicka->p2c14nyg46="1234.56";
$hlavicka->p2d14nyg46="1234.56";
$hlavicka->p2e14nyg46="1234.56";
$hlavicka->p2f14nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc1",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b14","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c14","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d14","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e14","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f14","$rmc",1,"R");

if( $hlavicka->p2b15 == 0 ) $hlavicka->p2b15 ="";
if( $hlavicka->p2c15 == 0 ) $hlavicka->p2c15 ="";
if( $hlavicka->p2d15 == 0 ) $hlavicka->p2d15 ="";
if( $hlavicka->p2e15 == 0 ) $hlavicka->p2e15 ="";
if( $hlavicka->p2f15 == 0 ) $hlavicka->p2f15 ="";

$hlavicka->p2b15nyg46="1234.56";
$hlavicka->p2c15nyg46="1234.56";
$hlavicka->p2d15nyg46="1234.56";
$hlavicka->p2e15nyg46="1234.56";
$hlavicka->p2f15nyg46="1234.56";

$pdf->Cell(90,3,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b15","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c15","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d15","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e15","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f15","$rmc",1,"R");


if( $hlavicka->p2b16 == 0 ) $hlavicka->p2b16 ="";
if( $hlavicka->p2c16 == 0 ) $hlavicka->p2c16 ="";
if( $hlavicka->p2d16 == 0 ) $hlavicka->p2d16 ="";
if( $hlavicka->p2e16 == 0 ) $hlavicka->p2e16 ="";
if( $hlavicka->p2f16 == 0 ) $hlavicka->p2f16 ="";

$hlavicka->p2b16nyg46="1234.56";
$hlavicka->p2c16nyg46="1234.56";
$hlavicka->p2d16nyg46="1234.56";
$hlavicka->p2e16nyg46="1234.56";
$hlavicka->p2f16nyg46="1234.56";

$pdf->Cell(90,6,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b16","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c16","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d16","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e16","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f16","$rmc",1,"R");


if( $hlavicka->p2b18 == 0 ) $hlavicka->p2b18 ="";
if( $hlavicka->p2c18 == 0 ) $hlavicka->p2c18 ="";
if( $hlavicka->p2d18 == 0 ) $hlavicka->p2d18 ="";
if( $hlavicka->p2e18 == 0 ) $hlavicka->p2e18 ="";
if( $hlavicka->p2f18 == 0 ) $hlavicka->p2f18 ="";

$hlavicka->p2b18nyg46="1234.56";
$hlavicka->p2c18nyg46="1234.56";
$hlavicka->p2d18nyg46="1234.56";
$hlavicka->p2e18nyg46="1234.56";
$hlavicka->p2f18nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b18","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c18","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d18","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e18","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f18","$rmc",1,"R");

if( $hlavicka->p2b19 == 0 ) $hlavicka->p2b19 ="";
if( $hlavicka->p2c19 == 0 ) $hlavicka->p2c19 ="";
if( $hlavicka->p2d19 == 0 ) $hlavicka->p2d19 ="";
if( $hlavicka->p2e19 == 0 ) $hlavicka->p2e19 ="";
if( $hlavicka->p2f19 == 0 ) $hlavicka->p2f19 ="";

$hlavicka->p2b19nyg46="1234.56";
$hlavicka->p2c19nyg46="1234.56";
$hlavicka->p2d19nyg46="1234.56";
$hlavicka->p2e19nyg46="1234.56";
$hlavicka->p2f19nyg46="1234.56";

$pdf->Cell(90,4,"     ","$rmc",1,"L");
$pdf->Cell(51,5," ","$rmc",0,"L");$pdf->Cell(25,5,"$hlavicka->p2b19","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2c19","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2d19","$rmc",0,"R");
$pdf->Cell(25,5,"$hlavicka->p2e19","$rmc",0,"R");$pdf->Cell(25,5,"$hlavicka->p2f19","$rmc",1,"R");



//textove bloky

$pdf->SetFont('arial','',9);


$ozntext="P_text2"; $textvypis=vytlactextx($ozntext, $mysqlhost, $mysqluser, $mysqlpasswd, $mysqldb, $kli_vxcf); 
$poleosob = explode("\r\n", $textvypis);

$pdf->SetY(222);
if( $poleosob[0] != '' )
    {
$ipole=1;
foreach( $poleosob as $hodnota ) {

$pdf->Cell(12,5," ","$rmc",0,"L");$pdf->Cell(0,5,"$hodnota","$rmc",1,"L");
$ipole=$ipole+1;
                                 }
    }
                                        } //koniec strana 40




}
$i = $i + 1;

  }


//aj cash
$ajcash = 1*$_REQUEST['ajcash'];
if( $ajcash == 1 )
{

$sqltt = "SELECT * FROM F$kli_vxcf"."_prccash1000ziss".$kli_uzid.
" LEFT JOIN F$kli_vxcf"."_uctpoccash2011_stt".
" ON F$kli_vxcf"."_prccash1000ziss$kli_uzid.icx=F$kli_vxcf"."_uctpoccash2011_stt.fic".
" WHERE prx = 99 ".""; 

$fort=1;
$citfir = include("cashflow2011_pdf.php");

//exit;


}
//koniec aj cash

$pdf->Output("$outfilex");

if( $urobxml == 0 ) {
?> 
<script type="text/javascript">
  var okno = window.open("<?php echo $outfilex; ?>","_self");
</script>
<?php
                    }
     }
//koniec zostava PDF copern=11

//skoc do XML
if( $urobxml == 1 ) {
?> 
<script type="text/javascript">
window.open('../ucto/poznamky2013_xml.php?copern=110&h_zos=<?php echo $h_zos; ?>&h_sch=<?php echo $h_sch; ?>&page=1&sysx=UCT&drupoh=1&uprav=1&outfilex=<?php echo $outfilex; ?>', '_self' );
</script>
<?php
                    }
//koniec skoc do XML
?>




<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>