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
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

       do
       {
if ( $copern !== 99 )
{
$sys = 'DOP';
$cslm=1;
$urov = 1000;
if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite v�etky okn� v prehliada�i IE a prihl�ste sa znovu pros�m do IS, ak ste pou��vali Cestovn� pr�kazy"; exit; }
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;
$oddelnew=0;
if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb1new.php");
$oddelnew=1;
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

if( $oddelnew == 1 )
  {
$zmazane = mysql_query("DELETE FROM $mysqldb2010.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2010.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
$zmazane = mysql_query("DELETE FROM $mysqldb2011.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2011.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
$zmazane = mysql_query("DELETE FROM $mysqldb2012.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2012.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
$zmazane = mysql_query("DELETE FROM $mysqldb2013.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2013.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
$zmazane = mysql_query("DELETE FROM $mysqldb2014.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2014.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); "); 
$zmazane = mysql_query("DELETE FROM $mysqldb2015.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2015.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2016.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2016.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2017.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2017.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2018.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2018.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2019.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2019.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2020.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2020.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2021.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2021.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2022.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2022.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2023.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2023.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
$zmazane = mysql_query("DELETE FROM $mysqldb2024.nas_id WHERE id='$kli_uzid'");
$ulozene = mysql_query("INSERT INTO $mysqldb2024.nas_id ( id,xcf,ume ) VALUES ($kli_uzid, $firs, $umes); ");
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
$xdop=1;
$sqlmax = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_hoteluzid WHERE uzix=$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $xdop=1*$riadmax->xdop;
  }
if( $xdop == 0 )
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

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Doprava Hl.menu</title>
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
  ( "Z�znamy o prev�dzke vozidiel",
    "OtvorStaz()",
    "Nahr�vanie z�znamov o prev�dzke vozidiel"
  );
  M1.NovaPolozka
  ( "Dodacie listy tovar a slu�by",
    "OtvorDodl()",
    "Dodacie listy na dopraven� materi�l pr�padne in� nedopravn� slu�by , ktor� nie s� v z�zname o prev�dzke vozidla"
  );
  M1.NovaPolozka
  ( "Pr�jmov� pokladni�n� doklad",
    "Otvorppri()",
    "Pr�jmov� pokladni�n� doklad - z�lohy a �hrady odberate�skej fakt�ry"
  );
  M1.NovaPolozka
  ( "N�kup PHM",
    "OtvorNphm()",
    "Evidencia n�kupu pohonn�ch hm�t"
  );
  M1.NovaPolozka
  ( "N�klady na vozidl�",
    "OtvorNakl()",
    "Evidencia n�kladov na vozidl� - poistenie,opravy,phm,pneumatiky ..."
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 340);
  M2.NovaPolozka
  ( "Vytvori� odberate�sk� fakt�ru",
    "Nefak()",
    "Vytvorenie odberate�skej fakt�ry z nevyfakt�rovan�ch z�znamov oPV a dodac�ch listov"
  );
  M2.NovaPolozka
  ( "Vytvori� vn�tropodnikov� fakt�ru",
    "Nefav()",
    "Vytvorenie vn�tropodnikovej fakt�ry z nevyfakt�rovan�ch z�znamov oPV a dodac�ch listov"
  );
  M2.NovaPolozka
  ( "Vytvori� doklad z registra�nej pokladnice",
    "Nefap()",
    "Vytvorenie reg.dokladu z nevyfakt�rovan�ch z�znamov oPV a dodac�ch listov"
  );
  M2.NovaPolozka
  ( "Fakt�ry - odberate�sk�",
    "FakOdb()",
    "Vytvoren� odberate�sk� fakt�ry zo z�znamov o prev�dzke a dodac�ch listov,�prava,mazanie,nov�"
  );
  M2.NovaPolozka
  ( "Fakt�ry - vn�tropodnikov� ",
    "FakVnf()",
    "Vytvoren� vn�tropodnikov� fakt�ry zo z�znamov o prev�dzke a dodac�ch listov,�prava,mazanie,nov�"
  );
  M2.NovaPolozka
  ( "Doklady z registra�nej pokladnice ",
    "RegPok()",
    "Vytvoren� doklady z registra�nej pokladnice,�prava,mazanie,nov�"
  );
  M2.NovaPolozka
  ( "Predfakt�ry - proformafakt�ry ",
    "FakPrf()",
    "Vytvoren� predfakt�ry - proformafakt�ra"
  );
  M2.NovaPolozka
  ( "Prevod do ��tovn�ctva",
    "PrevUct()",
    "Prevod roz��tovania vn�tropodnikov�ch fakt�r do ��tovn�ctva"
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 300);
  M3.NovaPolozka
  ( "Mesa�n� s�hrn o prev�dzke - autopark",
    "MASuhrn()",
    "Mesa�n� s�hrn o prev�dzke za cel� autopark"
  );
  M3.NovaPolozka
  ( "Mesa�n� s�hrn o prev�dzke - vozidl�",
    "MVSuhrn()",
    "Mesa�n� s�hrn o prev�dzke za jednotliv� vozidl� vozidla"
  );
  M3.NovaPolozka
  ( "Ro�n� s�hrn o prev�dzke - autopark",
    "RASuhrn()",
    "Ro�n� s�hrn o prev�dzke za cel� autopark"
  );
  M3.NovaPolozka
  ( "Zoznam Odber.faktur�cie",
    "Mfakt()",
    "Mesa�n� zostava odberatelskej faktur�cie - zoznam dokladov s rozpisom DPH"
  );
  M3.NovaPolozka
  ( "Zoznam Vn�trop.faktur�cie",
    "Mvnpf()",
    "Mesa�n� zostava vn�tropodnikovej faktur�cie - zoznam dokladov"
  );
  M3.NovaPolozka
  ( "Zoznam Dokladov z ERP",
    "Mregp()",
    "Mesa�n� zostava dokladov z registra�nej pokladnice - zoznam dokladov s rozpisom DPH"
  );
  M3.NovaPolozka
  ( "Roz��tovanie - Odberate�sk� fakt�ry",
    "RozOdb()",
    "Roz��tovanie v�nosov odberate�sk�ch fakt�r na stredisk� a z�kazky"
  );
  M3.NovaPolozka
  ( "Roz��tovanie - Vn�tropod. fakt�ry",
    "RozVnp()",
    "Roz��tovanie v�nosov a n�kladov vn�tropodnikov�ch fakt�r na stredisk� a z�kazky"
  );
  M3.NovaPolozka
  ( "Roz��tovanie - Doklady z ERP",
    "RozReg()",
    "Roz��tovanie v�nosov dokladov z ERP na stredisk� a z�kazky"
  );
  M3.NovaPolozka
  ( "Tr�by za vozidl� a tovar",
    "VynVoz()",
    "Roz��tovanie tr�ieb za jednotliv� vozidl� a tovarov� polo�ky"
  );
  M3.NovaPolozka
  ( "V�kaz o pr�ci vodi�a",
    "VykVod()",
    "V�kaz o pr�ci vodi�a"
  );
  M3.NovaPolozka
  ( "Preh�ad o n�kupe PHM",
    "ZosPhm()",
    "Preh�ad o n�kupe PHM"
  );
  M3.NovaPolozka
  ( "Preh�ad o spotrebe PHM",
    "SpoPhm()",
    "Preh�ad o spotrebe PHM"
  );
  M3.NovaPolozka
  ( "Kniha j�zd osobn�ch vozidiel",
    "Kjazd()",
    "Kniha j�zd osobn�ch vozidiel"
  );
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 350);
  M4.NovaPolozka
  ( "Parametre programu Doprava",
    "OtvorUfir31()",
    "Parametre programu Doprava"
  );
  M4.NovaPolozka
  ( "Druhy vozidiel",
    "OtvorDvoz()",
    "Druhy vozidiel"
  );
  M4.NovaPolozka
  ( "Zoznam vozidiel",
    "OtvorCvoz()",
    "Zoznam vozidiel"
  );
  M4.NovaPolozka
  ( "Zoznam vodi�ov",
    "OtvorCvod()",
    "Zoznam vodi�ov"
  );
  M4.NovaPolozka
  ( "Druhy PHM",
    "OtvorDphm()",
    "Druhy PHM"
  );
  M4.NovaPolozka
  ( "Platobn� karty na PHM",
    "OtvorPlk()",
    "Platobn� karty na PHM"
  );
  M4.NovaPolozka
  ( "Slu�by a neskladov� polo�ky - DOPRAVA",
    "OtvorDslu()",
    "Slu�by a neskladov� polo�ky - DOPRAVA"
  );
  M4.NovaPolozka
  ( "Druhy odberate�sk�ch dokladov",
    "OtvorDodb()",
    "Druhy odberate�sk�ch dokladov"
  );
  M4.NovaPolozka
  ( "Nastavenie reg.pokladnice",
    "NastReg()",
    "Nastavenie DKP registra�nej pokladnice, adresa predajne, nastavenie ��sel uz�vierok ..."
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
  M5.NovaPolozka
  ( "Prenos po�.stavu",
    "PrenosPoc()",
    "Prenos po�iato�n�ho stavu majetku "
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

  function OtvorUfir31()
  { 
  var okno = window.open("../cis/ufir.php?copern=31","_blank");
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

  function PrenosPoc()
  { 
  var okno = window.open("../cis/prenos_poc.php?copern=3&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

//[[[[[[[ body doprava

  function OtvorStaz()
  { 
  var okno = window.open("../doprava/vstdop.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorDodl()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=12&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorDodb()
  { 
  var okno = window.open("../faktury/dodb.php?copern=1&drupoh=1&page=1&sys=DOP","_blank");
  }

  function OtvorDvoz()
  { 
  var okno = window.open("../doprava/dvoz.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDphm()
  { 
  var okno = window.open("../doprava/dphm.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorPlk()
  { 
  var okno = window.open("../doprava/dplk.php?copern=1&drupoh=1&page=1","_blank");
  }

  function OtvorDslu()
  { 
  var okno = window.open("../doprava/dslu.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorCvod()
  { 
  var okno = window.open("../doprava/cvod.php?copern=1&drupoh=1&page=1&sys=DOP","_blank");
  }

  function OtvorCvoz()
  { 
  var okno = window.open("../doprava/cvoz.php?copern=1&drupoh=1&page=1&sys=DOP","_blank");
  }

  function Nefak()
  { 
  var okno = window.open("../doprava/nefak.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function Nefav()
  { 
  var okno = window.open("../doprava/nefak.php?copern=20&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Nefap()
  { 
  var okno = window.open("../doprava/nefak.php?copern=11&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function FakOdb()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=31&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function FakVnf()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=22&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }
  function RegPok()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=42&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }
  function FakPrf()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=52&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }
  function NastReg()
  { 
  var okno = window.open("../doprava/regpok.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function OtvorNphm()
  { 
  var okno = window.open("../doprava/nakphm.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function ZosPhm()
  { 
  var okno = window.open("../doprava/nakphm.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function SpoPhm()
  { 
  var okno = window.open("../doprava/spophm.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function MVSuhrn()
  { 
  var okno = window.open("../doprava/msuhrn.php?copern=20&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function MASuhrn()
  { 
  var okno = window.open("../doprava/msuhrn.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function RASuhrn()
  { 
  var okno = window.open("../doprava/msuhrn.php?copern=11&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorNakl()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=308&drupoh=9&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function VykVod()
  { 
  var okno = window.open("../doprava/vykvod.php?copern=20&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function Mfakt()
  { 
  var okno = window.open("../doprava/zozdok.php?copern=5&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function Mvnpf()
  { 
  var okno = window.open("../doprava/zozdok.php?copern=6&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Mregp()
  { 
  var okno = window.open("../doprava/zozdok.php?copern=7&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorppri()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=3&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function RozOdb()
  { 
  var okno = window.open("../doprava/rozdok.php?copern=5&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function RozReg()
  { 
  var okno = window.open("../doprava/rozdok.php?copern=7&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function RozVnp()
  { 
  var okno = window.open("../doprava/rozdok.php?copern=6&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function VynVoz()
  { 
  var okno = window.open("../doprava/vynvoz.php?copern=20&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Kjazd()
  { 
  var okno = window.open("../doprava/kjazd.php?copern=1&drupoh=1&page=1&typ=HTML","_blank",'<?php echo $parwin; ?>');
  }

  function PrevUct()
  { 
  var okno = window.open("../doprava/rozdok.php?copern=6&drupoh=1&page=1&zauct=1","_blank",'<?php echo $parwin; ?>');
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
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dodb WHERE drod = 12");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $uceodb=$riadok->dodb;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?pocstav=0&copern=5&drupoh=12&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $uceodb; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� Dodac� list ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../doprava/vstd_u.php?copern=5&drupoh=1&page=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra� nov� Z�znam o prev�dzke vozidla ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../doprava/nefak.php?copern=10&drupoh=1&page=1', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete fakt�rova� nahrat� Dodacie listy a Z�znamy oPV ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>Chcete zoznam "; 

htmlmenu += " <a href=\"#\" onClick=\"window.open('../doprava/vstdop.php?copern=1&drupoh=1&page=1&vyroba=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Z�znamov o PV </a> , ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=12&page=1&vyroba=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Dod.listov </a> , ";

htmlmenu += " <a href=\"#\" onClick=\"window.open('../faktury/vstfak.php?copern=1&drupoh=31&page=1&vyroba=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Fakt�r</a> ";

    htmlmenu += " ?</td></tr>";

    function M1naM2(kurz)
    {
       var mena1;
       var prep;
       mena1=document.ekalk.h_mena1.value;
       prep = kurz*mena1;
       prep = prep.toFixed(2);
       document.ekalk.h_mena2.value = prep;
    }

    function M2naM1(kurz)
    {
       var mena2;
       var prep;
       mena2=document.ekalk.h_mena2.value;
       prep = mena2/kurz;
       prep = prep.toFixed(2);
       document.ekalk.h_mena1.value = prep;
    }

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_ufir");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $mena1=$riadok->mena1;
  $mena2=$riadok->mena2;
  $kurz12=$riadok->kurz12;
  }
  ?>

    htmlmenu += "<tr><FORM name='ekalk' method='post' action='#' ><td width='100%' class='ponuka' colspan='2'>"; 
    htmlmenu += "EUROkalkula�ka ";
    htmlmenu += "<input type='text' name='h_mena2' id='h_mena2' size='9' value='0' onchange='M2naM1(<?php echo $kurz12; ?>)'>";
    htmlmenu += " <a href=\"#\" onClick=\"M1naM2(<?php echo $kurz12; ?>);\">" + "<?php echo $mena2; ?> </a>";

    htmlmenu += " kurz <?php echo $kurz12; ?> ";
    htmlmenu += "<input type='text' name='h_mena1' id='h_mena1' size='8' value='0' onchange='M1naM2(<?php echo $kurz12; ?>)'>";
    htmlmenu += " <a href=\"#\" onClick=\"M2naM1(<?php echo $kurz12; ?>);\">" + "<?php echo $mena1; ?> </a>";
    htmlmenu += "</td></FORM></tr>";

    htmlmenu += "</table>";  

</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Doprava</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none">
<tr>
<td width="60%">
<a href='dopr.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ��tovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='dopr.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ��tovn�ho obdobia"> ��tovn� obdobie:</a>
<?php echo "$vyb_ume";?>
</td>
</tr>
</table>

<?php
$kjazd = 1*$_REQUEST['kjazd'];
if( $kjazd == 1 AND $newmenu == 1 )
  {
?>
<script type="text/javascript">
  var okno = window.open("../doprava/kjazd.php?copern=1&drupoh=1&page=1&typ=HTML", "_self" );
</script>
<?php
exit;
  }
?>

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
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup d�t' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/fakturacia.jpg' style='width:98%; height:20;' alt='Mesa�n� spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/informacieavystupy.jpg' style='width:98%; height:20;' alt='Inform�cie a v�stupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a slu�by' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='��seln�ky a �dr�ba' ></a></center>
</td>
</tr>
</table>

<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Vstup d�t</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' title='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorStaz();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s1-r1.jpg' style='width:98%; height:20;' alt='Z�znamy o prev�dzke vozidiel' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodl();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s1-r2.jpg' style='width:98%; height:20;' alt='Dodacie listy tovar a slu�by' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorppri();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s1-r3.jpg' style='width:98%; height:20;' alt='Pr�jmov� pokladni�n� doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorNphm();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s1-r4.jpg' style='width:98%; height:20;' alt='N�kup PHM' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorNakl();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s1-r5.jpg' style='width:98%; height:20;' alt='N�klady na vozidl�' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Faktur�cia</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' title='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="Nefak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r1.jpg' style='width:98%; height:20;' alt='Vytvori� odberate�sk� fakt�ru' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Nefav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r2.jpg' style='width:98%; height:20;' alt='Vytvori� vn�tropodnikov� fakt�ru' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Nefap();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r3.jpg' style='width:98%; height:20;' alt='Vytvori� doklad z registra�nej pokladnice' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="FakOdb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r4.jpg' style='width:98%; height:20;' alt='Fakt�ry - odberate�sk�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="FakVnf();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r5.jpg' style='width:98%; height:20;' alt='Fakt�ry - vn�tropodnikov�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RegPok();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r6.jpg' style='width:98%; height:20;' alt='Doklady z registra�nej pokladnice' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="FakPrf();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r7.jpg' style='width:98%; height:20;' alt='Predfakt�ry - proformafakt�ry' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PrevUct();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s2-r8.jpg' style='width:98%; height:20;' alt='Prevod do ��tovn�ctva' ></a></center></td></tr>


</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Inform�cie a v�stupy</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' title='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="MASuhrn();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r1.jpg' style='width:98%; height:20;' alt='Mesa�n� s�hrn o prev�dzke - autopark' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="MVSuhrn();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r2.jpg' style='width:98%; height:20;' alt='Mesa�n� s�hrn o prev�dzke - vozidl�' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RASuhrn();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r3.jpg' style='width:98%; height:20;' alt='Ro�n� s�hrn o prev�dzke - autopark' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Mfakt();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r4.jpg' style='width:98%; height:20;' alt='Zoznam Odber.faktur�cie' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Mvnpf();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r5.jpg' style='width:98%; height:20;' alt='Zoznam Vn�trop.faktur�cie' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Mregp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r6.jpg' style='width:98%; height:20;' alt='Zoznam Dokladov z ERP' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RozOdb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r7.jpg' style='width:98%; height:20;' alt='Roz��tovanie - Odberate�sk� fakt�ry' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RozVnp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r8.jpg' style='width:98%; height:20;' alt='Roz��tovanie - Vn�tropod. fakt�ry' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RozReg();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r9.jpg' style='width:98%; height:20;' alt='Roz��tovanie - Doklady z ERP' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="VynVoz();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r10.jpg' style='width:98%; height:20;' alt='Tr�by za vozidl� a tovar' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="VykVod();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r11.jpg' style='width:98%; height:20;' alt='V�kaz o pr�ci vodi�a' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZosPhm();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r12.jpg' style='width:98%; height:20;' alt='Preh�ad o n�kupe PHM' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="SpoPhm();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r13.jpg' style='width:98%; height:20;' alt='Preh�ad o spotrebe PHM' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Kjazd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s3-r14.jpg' style='width:98%; height:20;' alt='Kniha j�zd osobn�ch vozidiel' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu Nastavenia a slu�by</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' title='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir31();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Doprava' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDvoz();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r2.jpg' style='width:98%; height:20;' alt='Druhy vozidiel' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCvoz();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r3.jpg' style='width:98%; height:20;' alt='Zoznam vozidiel' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCvod();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r4.jpg' style='width:98%; height:20;' alt='Zoznam vodi�ov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDphm();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r5.jpg' style='width:98%; height:20;' alt='Druhy PHM' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorPlk();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r6.jpg' style='width:98%; height:20;' alt='Platobn� karty na PHM' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDslu();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r7.jpg' style='width:98%; height:20;' alt='Slu�by a neskladov� polo�ky - DOPRAVA' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r8.jpg' style='width:98%; height:20;' alt='Druhy odberate�sk�ch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="NastReg();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s4-r9.jpg' style='width:98%; height:20;' alt='Nastavenie reg.pokladnice' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%'>Menu ��seln�ky a �dr�ba</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' title='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r1.jpg' style='width:98%; height:20;' alt='�daje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r2.jpg' style='width:98%; height:20;' alt='��seln�k I�O' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r3.jpg' style='width:98%; height:20;' alt='��seln�k stred�sk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r4.jpg' style='width:98%; height:20;' alt='��seln�k z�kaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r5.jpg' style='width:98%; height:20;' alt='��seln�k skup�n' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r6.jpg' style='width:98%; height:20;' alt='��seln�k stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r7.jpg' style='width:98%; height:20;' alt='E-z�kazn�ci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/doprava/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos po�.stavu' ></a></center></td></tr>


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
<td width="20%" ><center>Faktur�cia</center></td>
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
<FORM name="fir1" class="obyc" method="post" action="dopr.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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

$setuzrok = include("cis/citajrok.php");

$sql = mysql_query("SELECT xcf,naz,rok FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' AND rok > $citajrok ORDER BY xcf");

// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>

<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="dopr.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
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
$zmenume=1; $odkaz="../dopr.php?copern=1&newmenu=$newmenu";
$cislista = include("doprava/dop_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
