<?PHP
session_start();
$_SESSION['pocstav'] = 0;

?>
<HTML>
<?php

// cislo operacie
$copern = 1*$_REQUEST['copern'];

$newmenu = 1*$_REQUEST['newmenu'];
if( $_SESSION['chrome'] == 0 ) { $newmenu = 0; }
if( $_SESSION['nieie'] == 1 ) { $newmenu = 1; }

$parwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes";
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

       do
       {
if ( $copern !== 99 )
{
$sys = 'VYR';
$cslm=1;
$urov = 1000;
if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite všetky okná v prehliadaèi IE a prihláste sa znovu prosím do IS, ak ste pouívali Cestovné príkazy"; exit; }
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb1new.php");
          }
else
          {
$dtb2 = include("oddel_dtb1.php");
          }

  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

}

$firs = 1*$_REQUEST['firs'];
$umes = 1*$_REQUEST['umes'];
//echo "$copern";

// zmena firmy
if ( $copern == 25 OR $copern == 23 )
     {

$query="START TRANSACTION;"; 
$trans = mysql_query($query);

$zmazane = mysql_query("DELETE FROM $mysqldbfir.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldbfir.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
if ( $ulozene )
{
$query="COMMIT;";
$trans = mysql_query($query);
}
if ( !$ulozene )
{
$query="ROLLBACK;";
$trans = mysql_query($query);
}
     }

$cit_nas = include("cis/citaj_nas.php");

$cook=0;
if( $cook == 1 )
    {
setcookie("kli_vxcf", $vyb_xcf, time() + (7 * 24 * 60 * 60));
setcookie("kli_nxcf", $vyb_naz, time() + (7 * 24 * 60 * 60));
setcookie("kli_vume", $vyb_ume, time() + (7 * 24 * 60 * 60));
setcookie("kli_vrok", $vyb_rok, time() + (7 * 24 * 60 * 60));
    }
session_start();    
$_SESSION['kli_vxcf'] = $vyb_xcf;
$_SESSION['kli_nxcf'] = $vyb_naz;
$_SESSION['kli_vume'] = $vyb_ume;
$_SESSION['kli_vrok'] = $vyb_rok;

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb2new.php");
          }
else
          {
$dtb2 = include("oddel_dtb2.php");
          }

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$sqlfir = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_ufir WHERE udaje = 1";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok )
{
$fir_riadok=mysql_fetch_object($fir_vysledok);
}
$fir_xvr01 = 1*$fir_riadok->xvr01;
//echo $fir_xvr01;
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Vıroba Hl.menu</title>
<style type="text/css">

a:link, a:visited {text-decoration: none; color: black;}
a:hover {text-decoration: underline; background-color: #ffff90; }


<?php if( $newmenu == 0 ) { ?>
  @import url(css/skryvanemenu.css);
<?php                     } ?>
</style>
<?php if( $newmenu == 0 ) { ?>
<script type="text/javascript" src="js/cskryvanemenu.js" > </script>
<?php                     } ?>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-90;

<?php if( $newmenu == 0 ) { ?>

  // PRVE MENU
  var M1 = new CSkryvaneMenu("M1", 350);
  M1.NovaPolozka
  ( "Vırobné náklady a trby predaja z VRDP",
    "VyrSpotDP()",
    "Vytvorenie zostavy o vırobnıch nákladoch na vırobky a trbách z predaja vırobkov z podsystému VİROBA a DOPRAVA"
  );
  M1.NovaPolozka
  ( "Vırobné náklady a trby predaja z FAKT",
    "VyrSpotFK()",
    "Vytvorenie zostavy o vırobnıch nákladoch na vırobky a trbách z predaja vırobkov z podsystému FAKTÚRY"
  );
  M1.NovaPolozka
  ( "Spotreba vırobnıch komponentov a operácií",
    "SpoKomp()",
    "Spotreba vırobnıch komponentov a vırobnıch operácií na jednotlivé vırobky"
  );
  M1.NovaPolozka
  ( "Nastavenie receptúr pre vırobky",
    "VyrRecept()",
    "Priradenie receptúry k èíslu predaného vırobku"
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 350);
  M2.NovaPolozka
  ( "Základné údaje a vırobky na zákazke",
    "DopZak()",
    "Základné údaje o zákazke - èíslo a dátum objednávky, odberate¾, dohodnutá cena, popis, dokumentácia, zadávanie vırobkov na zákazke..."
  );
  M2.NovaPolozka
  ( "Vırobné operácie na zákazke",
    "VyrZak()",
    "Vıdaj materiálu na zákazku, príjem hotovıch vırobkov na zákazku, zaúètovanie prác na zákazku..."
  );
  M2.NovaPolozka
  ( "Ekonomické operácie na zákazke",
    "EkoZak()",
    "Vystavenie predfaktúry, dodacieho listu, faktúry, nahrávanie úhrad..."
  );
  M2.NovaPolozka
  ( "Prehladávanie vırobkov",
    "PrehVyr()",
    "Vyh¾adávanie vırobkov pod¾a názvu,rozmerov..."
  );
  M2.NovaPolozka
  ( "Zoznam pracovnıch príkazov",
    "pracprik()",
    "Zadávanie a úprava pracovnıch príkazov pre zamestnancov na vıkon práce na zakázkach..."
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 250);
  M4.NovaPolozka
  ( "Parametre programu Vıroba",
    "OtvorUfir41()",
    "Parametre programu Vıroba"
  );
  M4.NovaPolozka
  ( "Èíselník UNIkódov",
    "CisUni()",
    "Èíselník UNIkódov"
  );
  M4.NovaPolozka
  ( "Receptúry vırobkov",
    "Receptury()",
    "Zostavenie receptúr vırobkov , zadanie mnostva vırobného materiálu a vırobnıch operácií pouívanıch pri vırobe"
  );
  M4.NovaPolozka
  ( "Vırobné komponenty - materiál",
    "Komponenty()",
    "Zoznam komponentov - vırobného mteriálu pouívaného v receptúrach"
  );
  M4.NovaPolozka
  ( "Vırobné operácie - práce",
    "strojoper()",
    "Zoznam strojov , vırobnıch operácií a prác  pouívanıch pri vırobe"
  );
  M4.NovaPolozka
  ( "Zoznam zamestnancov",
    "MzdKun()",
    "Zoznam zamestnancov"
  );
  M4.classMenu = "menu2";
  M4.classPolozka = "polozka2";
  M4.classApolozka = "Apolozka2";
//  M4.x=605;// M1.y=100;

  // PIATE MENU
  var M5 = new CSkryvaneMenu("M5", 150);
  M5.NovaPolozka
  ( "Údaje o firme",
    "OtvorUfir1()",
    "Údaje o firme"
  );
  M5.NovaPolozka
  ( "Èíselník IÈO",
    "OtvorCico()",
    "Èíselník"
  );
  M5.NovaPolozka
  ( "Èíselník stredísk",
    "OtvorCstr()",
    "Èíselník"
  );
  M5.NovaPolozka
  ( "Èíselník zákaziek",
    "OtvorCzak()",
    "Èíselník"
  );
  M5.NovaPolozka
  ( "Èíselník skupín",
    "OtvorCsku()",
    "Èíselník skupn"
  );
  M5.NovaPolozka
  ( "Èíselník stavieb",
    "OtvorCsta()",
    "Èíselník stavieb"
  );
  M5.NovaPolozka
  ( "E-zákazníci",
    "Ezakaznik()",
    "Registrácia e-zákazníkov"
  );
  M5.NovaPolozka
  ( "Prenos poè.stavu",
    "PrenosPoc()",
    "Prenos poèiatoèného stavu vıroby "
  );
  M5.classMenu = "menu2";
  M5.classPolozka = "polozka2";
  M5.classApolozka = "Apolozka2";
//  M5.x=800;// M1.y=100;

<?php                     } ?>

   // Priklad funkce volane z menu
  function Funkciazmenu()
  {
    alert ("Hlási sa sluba z menu");
  }


  function OtvorCstr()
  { 
  var okno = window.open("../cis/cstr.php?copern=1&page=1","_blank");
  }


  function OtvorCsku()
  { 
  var okno = window.open("../cis/csku.php?copern=1&page=1","_blank");
  }


  function OtvorCsta()
  { 
  var okno = window.open("../cis/csta.php?copern=1&page=1","_blank");
  }

  function OtvorCzak()
  { 
  var okno = window.open("../cis/czak.php?copern=1&page=1","_blank");
  }

  function OtvorUfir1()
  { 
  var okno = window.open("../cis/ufir.php?copern=1","_blank");
  }

  function OtvorUfir41()
  { 
  var okno = window.open("../cis/ufir.php?copern=41","_blank");
  }

  function OtvorCico()
  { 
  var okno = window.open("../cis/cico.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZmnPrih()
  { 
  var okno = window.open("../cis/zmnprih.php?copern=1&page=1","_blank");
  }

  function ZalDat()
  { 
  var okno = window.open("../cis/zaldat.php?copern=1&page=1","_blank");
  }

  function ObnDat()
  { 
  var okno = window.open("../cis/obndat.php?copern=1&page=1","_blank");
  }

  function Ezakaznik()
  { 
  var okno = window.open("../cis/ezak.php?copern=1&page=1","_blank");
  }

//[[[[[[[ body vyroba

  function SpoKomp()
  { 
  var okno = window.open("../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&spo=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function VyrSpotDP()
  { 
  var okno = window.open("../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $tlcswin; ?>');
  }

  function VyrSpotFK()
  { 
  var okno = window.open("../vyroba/vyrspot.php?copern=30&drupoh=1&page=1&spo=0&pds=1","_blank",'<?php echo $tlcswin; ?>');
  }

  function VyrRecept()
  { 
  var okno = window.open("../vyroba/vyrspot.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }


  function VyrZak()
  { 
  var okno = window.open("../vyroba/vyrzak.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function EkoZak()
  { 
  var okno = window.open("../vyroba/vyrzak.php?copern=1&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function PrehVyr()
  { 
  var okno = window.open("../vyroba/vyrhladaj.php?copern=1&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function DopZak()
  { 
  var okno = window.open("../vyroba/dopzak.php?copern=1&drupoh=1&page=1&zrushladaj=1","_blank",'<?php echo $parwin; ?>');
  }

  function CisUni()
  { 
  var okno = window.open("../vyroba/cisuni.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Receptury()
  { 
  var okno = window.open("../vyroba/recepty.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Komponenty()
  { 
  var okno = window.open("../vyroba/ciskomp.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function MzdKun()
  { 
  var okno = window.open("../majetok/mzdkun.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function strojoper()
  { 
  var okno = window.open("../vyroba/strojoper.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function pracprik()
  { 
  var okno = window.open("../vyroba/pracprik.php?copern=1&drupoh=1&page=1&kanc=1","_blank",'<?php echo $parwin; ?>');
  }

  function PrenosPoc()
  { 
  var okno = window.open("../cis/prenos_poc.php?copern=8&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ukazrobot()
  { 
  <?php if( $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
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
  nazovx.style.display='none';
  }


    var toprobot = 200;
    var leftrobot = 40;
    var toprobotmenu = 112;
    var leftrobotmenu = 100;
    var widthrobotmenu = 430;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu ProRobot</td>" +
    "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' title='Zhasni menu' ></td></tr>";  
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"novazakazka();\">Automatické vytvorenie NOVEJ zákazky ?</a> - názov ";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../vyroba/dopzak.php?copern=1&drupoh=1&page=1&zrushladaj=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"Chcete zadáva ZÁKLADNÉ ÚDAJE o zákazke a VİROBKY na zákazke ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrzak.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete zobrazi VİROBNÉ informácie o zákazke ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../vyroba/vyrzak.php?copern=1&drupoh=2&page=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete zobrazi EKONOMICKÉ informácie o zákazke ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>Chcete upravova vırobnı èíselník"; 
htmlmenu += " <a href=\"#\" onClick=\"window.open('../vyroba/model.php?copern=208&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"VYR</a> ";
htmlmenu += " <a href=\"#\" onClick=\"window.open('../vyroba/model.php?copern=308&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"NOSN</a> ";
htmlmenu += " <a href=\"#\" onClick=\"window.open('../vyroba/model.php?copern=408&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"ROZP</a> ";
htmlmenu += " <a href=\"#\" onClick=\"window.open('../vyroba/model.php?copern=508&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"OKO</a> ";
htmlmenu += " <a href=\"#\" onClick=\"window.open('../vyroba/model.php?copern=608&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"LEM</a> ";
    htmlmenu += " ?</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>Chcete zoznam "; 

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=52&page=1&vyroba=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Predfaktúr</a> ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=12&page=1&vyroba=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Dod.listov</a> ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=31&page=1&vyroba=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Faktúr</a> ";

    htmlmenu += " ?</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../cis/czak.php?copern=5&drupoh=1&page=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"Chcete zapísa novú zákazku do èíselníka zákaziek?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "</table>";



  function zobraz_robotmenu()
  { 
  myRobotmenu.style.width = widthrobotmenu;
  myRobotmenu.innerHTML = htmlmenu;
  robotmenu.style.display='';
  nazovx.style.display='';
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  nazovx.style.display='none';
  }

  function novazakazka()
  { 
  var newzaknaz = document.znewx.h_nazzx.value;

  window.open('../vyroba/dopzak.php?copern=55&drupoh=1&page=1&newzaknaz=' + newzaknaz + '&zrushladaj=1', '_blank','<?php echo $parwin; ?>' );
  }

</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Vıroba</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none">
<tr>
<td width="60%" >
<a href='vyroba.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena úètovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='vyroba.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena úètovného obdobia"> Úètovné obdobie:</a>
<?php echo "$vyb_ume";?>
</td>
</tr>
</table>

<?php 
$klepnutie=".Klepnuti";
if( $newmenu == 1 ) 
{ 
?>
<script type="text/javascript">

  function MZvyrazni(Obj)
                {

  Obj.className = "pmenuz";

                }

  function MNeZvyrazni(Obj)
                {

  Obj.className = "pmenu";

                }

  function M1KlikNaMenu()  {   progmenu1.style.display='';  }
  function M1ZhasniMenu()  {   progmenu1.style.display='none';  }
  function M2KlikNaMenu()  {   progmenu2.style.display='';  }
  function M2ZhasniMenu()  {   progmenu2.style.display='none';  }
  function M3KlikNaMenu()  {   progmenu3.style.display='';  }
  function M3ZhasniMenu()  {   progmenu3.style.display='none';  }
  function M4KlikNaMenu()  {   progmenu4.style.display='';  }
  function M4ZhasniMenu()  {   progmenu4.style.display='none';  }
  function M5KlikNaMenu()  {   progmenu5.style.display='';  }
  function M5ZhasniMenu()  {   progmenu5.style.display='none';  }
</script>

<?php //OBRAZKOVE MENU ?>


<table class="pmenu" width="100%" style="position:relative; top:3px; border:none; background-color:white;" >
<tr>

<td width='20%' onClick="M1KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/vyrobnaspotreba.jpg' style='width:98%; height:20;' alt='Vstup dát' ></a></center></td>

<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/zakazkovavyroba.jpg' style='width:98%; height:20;' alt='Mesaèné spracovanie' ></a></center></td>

<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a sluby' ></a></center></td>

<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='Èíselníky a údrba' ></a></center></td>

</tr>
</table>







<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Vırobná spotreba</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="VyrSpotDP();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s1-r1.jpg' style='width:98%; height:20;' alt='Vırobné náklady a trby predaja z VRDP' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="VyrSpotFK();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s1-r2.jpg' style='width:98%; height:20;' alt='Vırobné náklady a trby predaja z FAKT' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="SpoKomp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s1-r3.jpg' style='width:98%; height:20;' alt='Spotreba vırobnıch komponentov a operácií' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="VyrRecept();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s1-r4.jpg' style='width:98%; height:20;' alt='Nastavenie receptúr pre vırobky' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Zákazková vıroba</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="DopZak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s2-r1.jpg' style='width:98%; height:20;' alt='Základné údaje a vırobky na zákazke' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="VyrZak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s2-r2.jpg' style='width:98%; height:20;' alt='Vırobné operácie na zákazke' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="EkoZak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s2-r3.jpg' style='width:98%; height:20;' alt='Ekonomické operácie na zákazke' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PrehVyr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s2-r4.jpg' style='width:98%; height:20;' alt='Prehladávanie vırobkov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="pracprik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s2-r5.jpg' style='width:98%; height:20;' alt='Zoznam pracovnıch príkazov' ></a></center></td></tr>



</FORM>
</table>
</div>



<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Nastavenia a sluby</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir41();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Vıroba' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="CisUni();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s4-r2.jpg' style='width:98%; height:20;' alt='Èíselník UNIkódov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Receptury();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s4-r3.jpg' style='width:98%; height:20;' alt='Receptúry vırobkov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Komponenty();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s4-r4.jpg' style='width:98%; height:20;' alt='Vırobné komponenty - materiál' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="strojoper();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s4-r5.jpg' style='width:98%; height:20;' alt='Vırobné operácie - práce' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="MzdKun();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s4-r6.jpg' style='width:98%; height:20;' alt='Zoznam zamestnancov' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Èíselníky a údrba</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r1.jpg' style='width:98%; height:20;' alt='Údaje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r2.jpg' style='width:98%; height:20;' alt='Èíselník IÈO' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r3.jpg' style='width:98%; height:20;' alt='Èíselník stredísk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r4.jpg' style='width:98%; height:20;' alt='Èíselník zákaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r5.jpg' style='width:98%; height:20;' alt='Èíselník skupín' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r6.jpg' style='width:98%; height:20;' alt='Èíselník stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r7.jpg' style='width:98%; height:20;' alt='E-zákazníci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/vyroba/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos poè.stavu' ></a></center></td></tr>

</FORM>
</table>
</div>

<?php
} 
?>

<?php
if( $newmenu == 0 ) 
{ 
?>
<span style="position:absolute; top:70; ">
<table class="pmenu" width="100%" border=1 >
<tr>
<span onclick="M1.Klepnuti(); return false; ">
<td width="20%" ><center>Vırobná spotreba</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>Zákazková vıroba</center></td>
</span>

<span  onclick="M4.Klepnuti(); return false; ">
<td width="20%" ><center>Nastavenia a sluby</center></td>
</span>

<span  onclick="M5.Klepnuti(); return false; ">
<td width="20%" ><center>Èíselníky a údrba</center></td>
</span>
</tr>
</table>
</span>
<?php
} 
?>

<br />
<br />
<br />
<br />
<br />
<br />
<br />


<?php 
// zmena ume
if ( $copern == 23 OR $copern == 24 )
     {
?>
<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="vyroba.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="12" name="umes" id="umes" >

<option value="01.<?php echo $vyb_rok;?>" selected='selected'
 >01.<?php echo $vyb_rok;?></option>
<option value="02.<?php echo $vyb_rok;?>"
 >02.<?php echo $vyb_rok;?></option>
<option value="03.<?php echo $vyb_rok;?>"
 >03.<?php echo $vyb_rok;?></option>
<option value="04.<?php echo $vyb_rok;?>"
 >04.<?php echo $vyb_rok;?></option>
<option value="05.<?php echo $vyb_rok;?>"
 >05.<?php echo $vyb_rok;?></option>
<option value="06.<?php echo $vyb_rok;?>"
 >06.<?php echo $vyb_rok;?></option>
<option value="07.<?php echo $vyb_rok;?>"
 >07.<?php echo $vyb_rok;?></option>
<option value="08.<?php echo $vyb_rok;?>"
 >08.<?php echo $vyb_rok;?></option>
<option value="09.<?php echo $vyb_rok;?>"
 >09.<?php echo $vyb_rok;?></option>
<option value="10.<?php echo $vyb_rok;?>"
 >10.<?php echo $vyb_rok;?></option>
<option value="11.<?php echo $vyb_rok;?>"
 >11.<?php echo $vyb_rok;?></option>
<option value="12.<?php echo $vyb_rok;?>"
 >12.<?php echo $vyb_rok;?></option>

</td>
</tr>
<tr>
<INPUT type="hidden" id="firs" name="firs" value="<?php echo $vyb_xcf;?>" >
<td class="obyc"><INPUT type="submit" id="umev" name="umev" value="Vybra úètovné obdobie" ></td>
</tr>
</FORM>
</table>
</span>
<?php
     }
//toto je koniec zmeny ume


if ( $copern == 22 )
     {
$pole = explode(",", $kli_txt1);

$pole0 = explode("-", $pole[0]);
$kli_fmin0=$pole0[0];
$kli_fmax0=$pole0[1];
$akefirmy = "( xcf >= $kli_fmin0 AND xcf <= $kli_fmax0 )";

$pole1 = explode("-", $pole[1]);
$kli_fmin1=$pole1[0];
$kli_fmax1=$pole1[1];
$cislo=1*$kli_fmin1;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin1 AND xcf <= $kli_fmax1 )";

$pole2 = explode("-", $pole[2]);
$kli_fmin2=$pole2[0];
$kli_fmax2=$pole2[1];
$cislo=1*$kli_fmin2;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin2 AND xcf <= $kli_fmax2 )";

$pole3 = explode("-", $pole[3]);
$kli_fmin3=$pole3[0];
$kli_fmax3=$pole3[1];
$cislo=1*$kli_fmin3;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin3 AND xcf <= $kli_fmax3 )";

$pole4 = explode("-", $pole[4]);
$kli_fmin4=$pole4[0];
$kli_fmax4=$pole4[1];
$cislo=1*$kli_fmin4;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin4 AND xcf <= $kli_fmax4 )";

$pole5 = explode("-", $pole[5]);
$kli_fmin5=$pole5[0];
$kli_fmax5=$pole5[1];
$cislo=1*$kli_fmin5;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin5 AND xcf <= $kli_fmax5 )";

$pole6 = explode("-", $pole[6]);
$kli_fmin6=$pole6[0];
$kli_fmax6=$pole6[1];
$cislo=1*$kli_fmin6;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin6 AND xcf <= $kli_fmax6 )";

$pole7 = explode("-", $pole[7]);
$kli_fmin7=$pole7[0];
$kli_fmax7=$pole7[1];
$cislo=1*$kli_fmin7;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin7 AND xcf <= $kli_fmax7 )";

$pole8 = explode("-", $pole[8]);
$kli_fmin8=$pole8[0];
$kli_fmax8=$pole8[1];
$cislo=1*$kli_fmin8;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin8 AND xcf <= $kli_fmax8 )";

$pole9 = explode("-", $pole[9]);
$kli_fmin9=$pole9[0];
$kli_fmax9=$pole9[1];
$cislo=1*$kli_fmin9;
if( $cislo > 0 ) $akefirmy = $akefirmy." OR ( xcf >= $kli_fmin9 AND xcf <= $kli_fmax9 )";

if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) { $setuzfir = include("cis/vybuzfir.php"); }

$sql = mysql_query("SELECT xcf,naz FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' ORDER BY xcf");
// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>

<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="vyroba.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="10" name="firs" id="firs" >
<?php while($zaznam=mysql_fetch_array($sql)):?>

<option value="<?php echo $zaznam["xcf"];?>"
<?php

if ( $zaznam["xcf"] == $vyb_xcf ) echo " selected='selected'";

?>
 ><?php echo $zaznam["xcf"];?> - <?php echo $zaznam["naz"];?></option>

<?php endwhile;?>
</td>
</tr>
<tr>
<INPUT type="hidden" id="umes" name="umes" value="<?php echo $vyb_ume;?>" >
<td class="obyc"><INPUT type="submit" id="firv" name="firv" value="Vybra úètovnú jednotku" ></td>
</tr>
</FORM>
</table>
</span>

<?php
mysql_close();
mysql_free_result($sql);

// toto je koniec zmeny firmy 
     }

$akyrobot = include("akyrobot.php");
?>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobrı deò , ja som Váš ProRobot , ak máte otázku alebo nejaké elanie kliknite na mòa prosím 1x myšou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>
<div id="nazovx" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 130; left: 370; width:30; height:10;">
<FORM name="znewx" method="post" action="#" ><input type="text" name="h_nazzx" id="h_nazzx" value="" ></FORM>
</div>
<?php

$robot=1;
$absolut=1;
$cislista = include("vyroba/vyr_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
