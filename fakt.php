<?PHP
session_start();
$_SESSION['ucto_sys'] = 0;
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

       do
       {
if ( $copern !== 99 )
{
$sys = 'FAK';
$cslm=1;
$urov = 1000;
if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite v�etky okn� v prehliada�i IE a prihl�ste sa znovu pros�m do IS, ak ste pou��vali Cestovn� pr�kazy"; exit; }
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

  $ajeshop=0;
  if (File_Exists ("eshop/index.php")) { $ajeshop=1; }


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

//ak zmena firmy nastav umes podla kli_vrok vo firme
if ( $copern == 23 )
     {
$sqlmax = mysql_query("SELECT * FROM $mysqldbfir.fir WHERE xcf=$firs");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $umes="1.".$riadmax->rok;
  }
     }

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

  $ajnajom=0;
  if (File_Exists ("secomnajom/najom.php")) { $ajnajom=1; }
  if( $_SERVER['SERVER_NAME'] == "www.europkse.sk" AND $vyb_xcf != 514 AND $vyb_xcf != 614 AND $vyb_xcf != 714 ) { $ajnajom=0; }
  if( $vyb_xcf != 2686 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ajeshop=0; }
  if( $vyb_xcf == 2686 AND $_SERVER['SERVER_NAME'] == "www.educto.sk" ) { $ajeshop=1; }


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
$_SESSION['kli_vduj'] = $vyb_duj;

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


$hotel = 1*$_REQUEST['hotel'];
if( $hotel == 1 )
   {
//echo "hotel".$hotel;
$xfak=1;
$sqlmax = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_hoteluzid WHERE uzix=$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $xfak=1*$riadmax->xfak;
  }
if( $xfak == 0 )
{
?>
<script type="text/javascript" > 
alert ("�utujem , nem�te dostato�n� pr�stupov� pr�va .");
window.close();
</script>
<?php
exit;
}
   }

//cleaning
$datdnessql = Date ("Y-m-d", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
$jeclean=0;
$poslhh = "SELECT * FROM ".$mysqldbdata.".cleaningtmp WHERE dat='$datdnessql' ";
$posl = mysql_query("$poslhh"); 
if( $posl ) { $jeclean = 1*mysql_num_rows($posl); }
if( $jeclean == 0 )
{
$copernx="alibaba40";
//echo "idem";
$clean = include("funkcie/subory.php");
}
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Fakt�ry Hl.menu</title>
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
  var M1 = new CSkryvaneMenu("M1", 300);
  M1.NovaPolozka
  ( "Kniha odberate�sk�ch fakt�r",
    "OtvorOdber()",
    "Kniha odberate�sk�ch fakt�r, vytvorenie novej , oprava, vymazanie ulo�enej"
  );
  M1.NovaPolozka
  ( "Kniha dod�vate�sk�ch fakt�r",
    "OtvorDodav()",
    "Kniha dod�vate�sk�ch fakt�r"
  );
  M1.NovaPolozka
  ( "Kniha dodac�ch listov",
    "OtvorDodl()",
    "Kniha dodac�ch listov"
  );
  M1.NovaPolozka
  ( "Kniha vn�tropodnikov�ch fakt�r",
    "OtvorKvnp()",
    "Kniha vn�tropodnikov�ch fakt�r"
  );
  M1.NovaPolozka
  ( "Pr�jmov� pokladni�n� doklad",
    "Otvorppri()",
    "Pr�jmov� pokladni�n� doklad - �hrada odberate�skej fakt�ry"
  );
  M1.NovaPolozka
  ( "V�davkov� pokladni�n� doklad",
    "Otvorpvyd()",
    "V�davkov� pokladni�n� doklad - �hrada dod�vate�skej fakt�ry"
  );
  M1.Cara(); // --------------------
  M1.NovaPolozka
  ( "Upomienka odberate�sk�ch fakt�r",
    "Upomienka()",
    "Upomienka odberate�sk�ch fakt�r"
  );
  M1.NovaPolozka
  ( "Pr�kaz na �hradu dod�v.fakt�r",
    "Priku()",
    "Pr�kaz na �hradu dod�vate�sk�ch fakt�r"
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 450);
  M2.NovaPolozka
  ( "Zoznam odberate�sk�ch fakt�r - mesa�n�",
    "ZozOdb()",
    "Zoznam odberate�sk�ch fakt�r - mesa�n�"
  );
  M2.NovaPolozka
  ( "Zoznam dod�vate�sk�ch fakt�r - mesa�n�",
    "ZozDod()",
    "Zoznam dod�vate�sk�ch fakt�r - mesa�n�"
  );
  M2.NovaPolozka
  ( "Zoznam vn�tropodnikov�ch fakt�r - mesa�n�",
    "ZozVnp()",
    "Zoznam vn�tropodnikov�ch fakt�r - mesa�n�"
  );
  M2.NovaPolozka
  ( "Zoznam pr�jmov�ch pokladni�n�ch dokladov - mesa�n�",
    "ZozPri()",
    "Zoznam pr�jmov�ch pokladni�n�ch dokladov - mesa�n�"
  );
  M2.NovaPolozka
  ( "Zoznam v�davkov�ch pokladni�n�ch dokladov - mesa�n�",
    "ZozVyd()",
    "Zoznam v�davkov�ch pokladni�n�ch dokladov - mesa�n�"
  );
  M2.NovaPolozka
  ( "Prevod do ��tovn�ctva",
    "location.href='fakt.php'",
    "Prevod do ��tovn�ctva"
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 350);
  M3.NovaPolozka
  ( "Odberate�sk� a dod�vate�sk� Saldokonto",
    "saldo()",
    "Zoznamy odberate�sk�ch a dod�vate�sk�ch fakt�r a �hrad za I�O, ��et, obdobie...."
  );
  M3.NovaPolozka
  ( "Preh�ad�vanie odberate�sk�ch fakt�r",
    "PrehOdber()",
    "Preh�ad�vanie odberate�sk�ch fakt�r"
  );
  M3.NovaPolozka
  ( "Preh�ad�vanie dod�vate�sk�ch fakt�r",
    "PrehDodav()",
    "Preh�ad�vanie dod�vate�sk�ch fakt�r"
  );
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 300);
  M4.NovaPolozka
  ( "Parametre programu faktur�cia",
    "OtvorUfir21()",
    "Parametre programu faktur�cia"
  );
  M4.NovaPolozka
  ( "Materi�lov� a tovarov� polo�ky",
    "OtvorCcis()",
    "Materi�lov� a tovarov� polo�ky"
  );
  M4.NovaPolozka
  ( "Slu�by a neskladov� polo�ky",
    "OtvorPslu()",
    "Slu�by a neskladov� polo�ky"
  );
  M4.NovaPolozka
  ( "Druhy odberate�sk�ch dokladov",
    "OtvorDodb()",
    "Druhy odberate�sk�ch dokladov"
  );
  M4.NovaPolozka
  ( "Druhy dod�vate�sk�ch dokladov",
    "OtvorDdod()",
    "Druhy dod�vate�sk�ch dokladov"
  );
  M4.NovaPolozka
  ( "Druhy pokladn�c",
    "OtvorDpok()",
    "Druhy pokladn�c"
  );
  M4.NovaPolozka
  ( "Predvolen� texty na dokladoch",
    "OtvorFtext()",
    "Predvolen� texty na dokladoch"
  );
  M4.classMenu = "menu2";
  M4.classPolozka = "polozka2";
  M4.classApolozka = "Apolozka2";
//  M4.x=605;// M1.y=100;

  // PIATE MENU
  var M5 = new CSkryvaneMenu("M5", 150);
  M5.NovaPolozka
  ( "�daje o firme",
    "OtvorUfir1()",
    "�daje o firme"
  );
  M5.NovaPolozka
  ( "��seln�k I�O",
    "OtvorCico()",
    "��seln�k"
  );
  M5.NovaPolozka
  ( "��seln�k stred�sk",
    "OtvorCstr()",
    "��seln�k"
  );
  M5.NovaPolozka
  ( "��seln�k z�kaziek",
    "OtvorCzak()",
    "��seln�k"
  );
  M5.NovaPolozka
  ( "��seln�k skup�n",
    "OtvorCsku()",
    "��seln�k skupn"
  );
  M5.NovaPolozka
  ( "��seln�k stavieb",
    "OtvorCsta()",
    "��seln�k stavieb"
  );
  M5.NovaPolozka
  ( "E-z�kazn�ci",
    "Ezakaznik()",
    "Registr�cia e-z�kazn�kov"
  );
  M5.classMenu = "menu2";
  M5.classPolozka = "polozka2";
  M5.classApolozka = "Apolozka2";
//  M5.x=800;// M1.y=100;

<?php                     } ?>

   // Priklad funkce volane z menu
  function Funkciazmenu()
  {
    alert ("Hl�si sa slu�ba z menu");
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

  function OtvorUfir21()
  { 
  var okno = window.open("../cis/ufir.php?copern=21","_blank");
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

//[[[[[[[ body fakturacie


  function Upomienka()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorOdber()
  { 
  var okno = window.open('../faktury/vstfak.php?copern=1&drupoh=1&page=1&pocstav=0','_blank','<?php echo $parwin; ?>');
  }

  function OtvorDodav()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=2&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorDodl()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=11&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorKvnp()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=21&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorppri()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorpvyd()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function PrehOdber()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=10&drupoh=1&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function PrehDodav()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=10&drupoh=2&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function ZozOdb()
  { 
  var okno = window.open("../ucto/zozdok.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZozVnp()
  { 
  var okno = window.open("../ucto/zozdok.php?copern=9&drupoh=31&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZozDod()
  { 
  var okno = window.open("../ucto/zozdok.php?copern=2&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZozPri()
  { 
  var okno = window.open("../ucto/zozdok.php?copern=3&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZozVyd()
  { 
  var okno = window.open("../ucto/zozdok.php?copern=4&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorCcis()
  { 
  var okno = window.open("../sklad/ccis.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorDodb()
  { 
  var okno = window.open("../faktury/dodb.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDdod()
  { 
  var okno = window.open("../faktury/ddod.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDpok()
  { 
  var okno = window.open("../ucto/dpok.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorPslu()
  { 
  var okno = window.open("../faktury/cslu.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Ezakaznik()
  { 
  var okno = window.open("../cis/ezak.php?copern=1&page=1","_blank");
  }

  function saldo()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Priku()
  { 
  var okno = window.open("../ucto/vstpru.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorFtext()
  { 
  var okno = window.open("../faktury/ftexty.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ukazrobot()
  { 
  <?php if( $kli_vduj >= 0 AND $vyb_robot == 1 ) { echo "robotokno.style.display=''; robotmenu.style.display='none';"; } ?>
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
  }

  function zhasni_menurobot()
  { 
  robotmenu.style.display='none';
  }

    var toprobot = 200;
    var leftrobot = 40;
    var toprobotmenu = 112;
    var leftrobotmenu = 100;
    var widthrobotmenu = 400;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>" +
    "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dodb WHERE drod = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $uceodb=$riadok->dodb;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?pocstav=0&copern=5&drupoh=1&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $uceodb; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� Odberate�sk� fakt�ru ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $ajregistracka=0;
  if (File_Exists ("dokumenty/FIR$vyb_xcf/ajregistracka.ano")) { $ajregistracka=1; }
  if( $ajregistracka == 1 ) {
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dpok WHERE drpk = 9");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $ucepok=$riadok->dpok;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=42&page=1&hladaj_uce=<?php echo $ucepok; ?>&pocstav=0&regpok=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete zaregistrova� platbu do registra�nej pokladnice ?</a>";
    htmlmenu += "</td></tr>";

  <?php
                            }


  if( $ajeshop == 1 )       { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../eshop/obj_tlac.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"Chcete spracova� objedn�vky z E-SHOPu ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../eshop/infotovar.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"Chcete vyhodnoti� predaj tovaru a slu�ieb ?</a>";
    htmlmenu += "</td></tr>";

  <?php
                            }


  if( $ajnajom == 1 )       { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../secomnajom/najom.php?copern=1&drupoh=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"Chcete spracova� n�jomn� zmluvy za nebytov� priestory ?</a>";
    htmlmenu += "</td></tr>";


  <?php
                            }


  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_ddod WHERE drdo = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $uceodb=$riadok->ddod;
  }
  ?>

<?php
  $ajdodobj=0;
  if (File_Exists ("dodobj/index.php")) { $ajdodobj=1; }
  if( $ajdodobj == 1 )       { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../dodobj/dodobj.php?copern=1&drupoh=1&page=1&zmtz=1&html=1', '_blank','width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )\">" +
"Chcete vytvori� dod�vate�sk� OBJedn�vku ?</a>";
    htmlmenu += "</td></tr>";


<?php                        } ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?pocstav=0&copern=5&drupoh=2&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $uceodb; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� Dod�vate�sk� fakt�ru ?</a>";
    htmlmenu += "</td></tr>";



    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>Chcete zoznam "; 

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=1&page=1&vyroba=0', '_blank','<?php echo $parwin; ?>' )\">" +
"ODB.Fakt�r </a> , ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=2&page=1&vyroba=0', '_blank','<?php echo $parwin; ?>' )\">" +
"DOD.Fakt�r </a> , ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=11&page=1&vyroba=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Dod.listov </a> , ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=52&page=1&pocstav=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Predfakt�r</a>  ";

    htmlmenu += " ?</td></tr>";


</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Fakt�ry</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none;">
<tr>
<td width="60%" >
<a href='fakt.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ��tovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='fakt.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ��tovn�ho obdobia"> ��tovn� obdobie:</a>
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
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup d�t' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/mesacnespracovanie.jpg' style='width:98%; height:20;' alt='Mesa�n� spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/informacieavystupy.jpg' style='width:98%; height:20;' alt='Inform�cie a v�stupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a slu�by' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='��seln�ky a �dr�ba' ></a></center>
</td>
</tr>
</table>

<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup d�t</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorOdber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r1.jpg' style='width:98%; height:20;' alt='Kniha odberate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r2.jpg' style='width:98%; height:20;' alt='Kniha dod�vate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodl();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r3.jpg' style='width:98%; height:20;' alt='Kniha dodac�ch listov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorKvnp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r4.jpg' style='width:98%; height:20;' alt='Kniha vn�tropodnikov�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorppri();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r5.jpg' style='width:98%; height:20;' alt='Pr�jmov� pokladni�n� doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorpvyd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r6.jpg' style='width:98%; height:20;' alt='V�davkov� pokladni�n� doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorpvyd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r7.jpg' style='width:98%; height:20;' alt='Upomienka odberate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorpvyd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s1-r8.jpg' style='width:98%; height:20;' alt='Pr�kaz na �hradu dod�v.fakt�r' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu Mesa�n� spracovanie</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="ZozOdb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s2-r1.jpg' style='width:98%; height:20;' alt='Zoznam odberate�sk�ch fakt�r - mesa�n�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZozDod();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s2-r2.jpg' style='width:98%; height:20;' alt='Zoznam dod�vate�sk�ch fakt�r - mesa�n�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZozVnp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s2-r3.jpg' style='width:98%; height:20;' alt='Zoznam vn�tropodnikov�ch fakt�r - mesa�n�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZozPri();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s2-r4.jpg' style='width:98%; height:20;' alt='Zoznam pr�jmov�ch pokladni�n�ch dokladov - mesa�n�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZozVyd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s2-r5.jpg' style='width:98%; height:20;' alt='Zoznam v�davkov�ch pokladni�n�ch dokladov - mesa�n�' ></a></center></td></tr>


</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Inform�cie a v�stupy</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="saldo();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s3-r1.jpg' style='width:98%; height:20;' alt='Odberate�sk� a dod�vate�sk� Saldokonto' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PrehOdber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s3-r2.jpg' style='width:98%; height:20;' alt='Preh�ad�vanie odberate�sk�ch fakt�r' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PrehDodav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s3-r3.jpg' style='width:98%; height:20;' alt='Preh�ad�vanie dod�vate�sk�ch fakt�r' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a slu�by</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir21();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu faktur�cia' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCcis();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r2.jpg' style='width:98%; height:20;' alt='Materi�lov� a tovarov� polo�ky' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorPslu();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r3.jpg' style='width:98%; height:20;' alt='Slu�by a neskladov� polo�ky' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r4.jpg' style='width:98%; height:20;' alt='Druhy odberate�sk�ch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDdod();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r5.jpg' style='width:98%; height:20;' alt='Druhy dod�vate�sk�ch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDpok();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r6.jpg' style='width:98%; height:20;' alt='Druhy pokladn�c' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorFtext();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s4-r7.jpg' style='width:98%; height:20;' alt='Predvolen� texty na dokladoch' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu ��seln�ky a �dr�ba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r1.jpg' style='width:98%; height:20;' alt='�daje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r2.jpg' style='width:98%; height:20;' alt='��seln�k I�O' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r3.jpg' style='width:98%; height:20;' alt='��seln�k stred�sk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r4.jpg' style='width:98%; height:20;' alt='��seln�k z�kaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r5.jpg' style='width:98%; height:20;' alt='��seln�k skup�n' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r6.jpg' style='width:98%; height:20;' alt='��seln�k stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r7.jpg' style='width:98%; height:20;' alt='E-z�kazn�ci' ></a></center></td></tr>

<?php if( $dajpoc == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/faktury/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos po�.stavu' ></a></center></td></tr>
<?php                    } ?>

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
<td width="20%" ><center>Vstup d�t</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>Mesa�n� spracovanie</center></td>
</span>

<span  onclick="M3.Klepnuti(); return false; ">
<td width="20%" ><center>Inform�cie a v�stupy</center></td>
</span>

<span  onclick="M4.Klepnuti(); return false; ">
<td width="20%" ><center>Nastavenia a slu�by</center></td>
</span>

<span  onclick="M5.Klepnuti(); return false; ">
<td width="20%" ><center>��seln�ky a �dr�ba</center></td>
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
<FORM name="fir1" class="obyc" method="post" action="fakt.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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
<td class="obyc"><INPUT type="submit" id="umev" name="umev" value="Vybra� ��tovn� obdobie" ></td>
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
<FORM name="fir1" class="obyc" method="post" action="fakt.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
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
<td class="obyc"><INPUT type="submit" id="firv" name="firv" value="Vybra� ��tovn� jednotku" ></td>
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
 alt='Dobr� de� , ja som V� EkoRobot , ak m�te ot�zku alebo nejak� �elanie kliknite na m�a pros�m 1x my�ou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>
<?php

$robot=1;
$absolut=1;
$zmenume=1; $odkaz="../fakt.php?copern=1&newmenu=$newmenu";
$cislista = include("faktury/fak_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
