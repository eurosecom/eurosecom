<?PHP
session_start();
$_SESSION['ucto_sys'] = 1;
$_SESSION['pocstav'] = 0;
?>

<HTML>
<?php

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$newmenu = 1*$_REQUEST['newmenu'];
if( $_SESSION['chrome'] == 0 ) { $newmenu = 0; }
if( $_SESSION['nieie'] == 1 ) { $newmenu = 1; }
$copern = 1*$_REQUEST['copern'];
$parwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes";
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";

       do
       {
if ( $copern !== 99 )
{
$sys = 'UCT';
$urov = 2000;
$cslm = 1;
if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite všetky okná v prehliadaèi IE a prihláste sa znovu prosím do IS, ak ste pouívali Cestovné príkazy"; exit; }
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

  $kli_vduj=$_SESSION['kli_vduj'];

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("oddel_dtb2new.php");
          }
else
          {
$dtb2 = include("oddel_dtb2.php");
          }


//echo " rok ".$vyb_rok;
//echo " dbdata ".$mysqldbdata."<br />";
//exit;

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$cvybxcf=1*$vyb_xcf;
if( $cvybxcf > 0 )
          {
//len ak je vybrana firma
//echo "<br /><br /><br /><br /><br />idem";

$sql = "SELECT zmen FROM ".$mysqldbdata.".F$vyb_xcf"."_uctvsdh";
if( $copern == 1 OR $copern == 25 )
{
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok):
$kli_vxcf=$vyb_xcf;
  mysql_select_db($mysqldbdata);
$kalend = include("ucto/vtvuct.php");
endif;
}


          }
//len ak je vybrana firma

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
<title>Finanèné úètovníctvo Hl.menu</title>
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
  ( "Kniha odberate¾skıch faktúr",
    "OtvorOdber()",
    "Kniha odberate¾skıch faktúr, vytvorenie novej , oprava, vymazanie uloenej"
  );
  M1.NovaPolozka
  ( "Kniha dodávate¾skıch faktúr",
    "OtvorDodav()",
    "Kniha dodávate¾skıch faktúr"
  );
  M1.NovaPolozka
  ( "Príjmovı pokladniènı doklad",
    "Otvorppri()",
    "Príjmovı pokladniènı doklad - úhrada odberate¾skej faktúry"
  );
  M1.NovaPolozka
  ( "Vıdavkovı pokladniènı doklad",
    "Otvorpvyd()",
    "Vıdavkovı pokladniènı doklad - úhrada dodávate¾skej faktúry"
  );
  M1.NovaPolozka
  ( "Bankovı vıpis",
    "Otvorbank()",
    "Bankovı vıpis - nahrávanie"
  );
  M1.NovaPolozka
  ( "Všeobecné úètovné doklady",
    "Otvorvseo()",
    "Všeobecné úètovné doklady - nahrávanie"
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 350);
  M2.NovaPolozka
  ( "Vytvorenie mesaènıch úètovnıch zostáv",
    "meszos()",
    "Vytvorenie mesaènıch úètovnıch zostáv - Vıkaz ziskov, Súvaha, Obratová predvaha, Zostavy DPH...."
  );
  M2.NovaPolozka
  ( "Štatistika a vıkazníctvo",
    "sttzos()",
    "Vytvorenie štatistickıch, štvrroènıch a roènıch vıkazov a preh¾adov...."
  );
  M2.NovaPolozka
  ( "Preh¾ady a úpravy dát z podsystémov",
    "oprsys()",
    "Preh¾ady, úpravy a mazanie dát prenesenıch automatickım úètovaním z podsystémov...."
  );
  M2.NovaPolozka
  ( "Priznanie k dani z príjmov",
    "danprij()",
    "Vytvorenie priznania k dani z príjmov a príloh k priznaniu...."
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 350);
  M3.NovaPolozka
  ( "Odberate¾ské a dodávate¾ské Saldokonto",
    "saldo()",
    "Zoznamy odberate¾skıch a dodávate¾skıch faktúr a úhrad za IÈO, úèet, obdobie...."
  );
  M3.NovaPolozka
  ( "Vıpis úètovnıch pohybov",
    "uctpohyby()",
    "Vıpis úètovnıch pohybov za syntetické alebo analytické úèty"
  );
  M3.NovaPolozka
  ( "Preh¾adávanie dokladov",
    "hladaj_doklad()",
    "Vyh¾adávanie v dokladoch pod¾a textu, èísla úètu, faktúry, IÈO, dátumu, strediska, zákazky......"
  );
  M3.NovaPolozka
  ( "Úèty vedené v cudzích menách",
    "Cudzie()",
    "Pokladnice,Bankové úèty,Poh¾adávky,Záväzky a ïalšie úèty vedené v cudzích menách...."
  );
  M3.NovaPolozka
  ( "Upomienka, penále odberate¾skıch faktúr",
    "Upomienka()",
    "Vytvorenie PDF alebo e-mailovej upomienky alebo penalizácie odberate¾skıch faktúr nezaplatenıch po lehote splatnosti"
  );
  M3.NovaPolozka
  ( "Príkaz na úhradu dodáv.faktúr",
    "Priku()",
    "Príkaz na úhradu dodávate¾skıch faktúr"
  );
  M3.NovaPolozka
  ( "Ruèné spárovanie a opravy saldokonta",
    "Rucnespar()",
    "Ruèné spárovanie faktúr a úhrad, ktoré nemajú rovnakı var.symbol a iné opravy saldokonta"
  );
  M3.NovaPolozka
  ( "Vzájomnı zápoèet odber. a dodav. faktúr",
    "Vzajomny()",
    "Vytvorenie vzájomného zápoètu odber. a dodav. faktúr"
  );
  M3.NovaPolozka
  ( "Postúpenie poh¾adávok a záväzkov",
    "Faktoring()",
    "Vytvorenie a zaúètovanie faktoringovej zmluvy odber. a dodáv. faktúr"
  );
  M3.NovaPolozka
  ( "Zoznamy dokladov",
    "prhdok()",
    "Zoznamy zaúètovanıch pokladniènıch dokladov,bankovıch vıpisov,všeobecnıch úètovnıch dokladov,odberate¾skıch a dodávate¾skıch faktúr...."
  );
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 350);
  M4.NovaPolozka
  ( "Parametre programu Finanèné Úètovníctvo",
    "OtvorUfir91()",
    "Parametre programu Finanèné Úètovníctvo"
  );
  M4.NovaPolozka
  ( "Úètová osnova",
    "Uctosn()",
    "Úètová osnova - nahrávanie a úpravy"
  );
  M4.NovaPolozka
  ( "Druhy daòovıch dokladov DPH",
    "Drudan()",
    "Druhy daòovıch dokladov DPH - nahrávanie a úpravy"
  );
  M4.NovaPolozka
  ( "Druhy odberate¾skıch dokladov",
    "OtvorDodb()",
    "Druhy odberate¾skıch dokladov"
  );
  M4.NovaPolozka
  ( "Druhy dodávate¾skıch dokladov",
    "OtvorDdod()",
    "Druhy dodávate¾skıch dokladov"
  );
  M4.NovaPolozka
  ( "Druhy pokladníc",
    "OtvorDpok()",
    "Druhy pokladníc"
  );
  M4.NovaPolozka
  ( "Druhy bankovıch úètov",
    "OtvorDban()",
    "Druhy bankovıch úètov"
  );
  M4.NovaPolozka
  ( "Poèiatoènı stav Odberate¾skıch faktúr",
    "PocOdber()",
    "Poèiatoènı stav Odberate¾skıch faktúr"
  );
  M4.NovaPolozka
  ( "Poèiatoènı stav Dodávate¾skıch faktúr",
    "PocDodav()",
    "Poèiatoènı stav Dodávate¾skıch faktúr"
  );
  M4.NovaPolozka
  ( "Poèiatoènı stav Úhrad",
    "PocUhrad()",
    "Poèiatoènı stav Úhrad"
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
  ( "Zálohovanie dát",
    "ZalDat()",
    "Zálohovanie dát na médium "
  );
  M5.NovaPolozka
  ( "Prenos poè.stavu",
    "PrenosPoc()",
    "Prenos poèiatoèného stavu úètovníctva "
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

  function OtvorUfir91()
  { 
  var okno = window.open("../cis/ufir.php?copern=91","_blank");
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
  var okno = window.open("../cis/zaldat_ucto.php?copern=101&page=1","_blank");
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
  var okno = window.open("../cis/prenos_poc.php?copern=10&drupoh=1&page=1&upozorni2011=1&upozorni2012=1&upozorni2013=1","_blank",'<?php echo $parwin; ?>');
  }

//[[[[[[[ body ucto

  function OtvorOdber()
  { 
  var okno = window.open('../faktury/vstfak.php?copern=1&drupoh=1001&page=1&pocstav=0','_blank','<?php echo $parwin; ?>');
  }

  function OtvorDodav()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=1002&page=1&pocstav=0","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorppri()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorpvyd()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=2&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorbank()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=4&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Otvorvseo()
  { 
  var okno = window.open("../ucto/vstpok.php?copern=1&drupoh=5&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function prhdok()
  { 
  var okno = window.open("../ucto/prhdok.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function saldo()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=0","_blank",'<?php echo $parwin; ?>');
  }

  function Upomienka()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=1","_blank",'<?php echo $parwin; ?>');
  }

  function Rucnespar()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=9","_blank",'<?php echo $parwin; ?>');
  }

  function Vzajomny()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=8","_blank",'<?php echo $parwin; ?>');
  }

  function Faktoring()
  { 
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=1&cinnost=6","_blank",'<?php echo $parwin; ?>');
  }

  function uctpohyby()
  { 
  var okno = window.open("../ucto/uctpohyby.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function hladaj_doklad()
  { 
  var okno = window.open("../ucto/hladaj_dok.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Cudzie()
  { 
  var okno = window.open("../ucto/cudzie.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function oprsys()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function meszos()
  { 
  var okno = window.open("../ucto/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function danprij()
  { 
  var okno = window.open("../ucto/danprij.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function sttzos()
  { 
  var okno = window.open("../ucto/statzos.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function Imvykzis()
  { 
  var okno = window.open("../ucto/import.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Uctosn()
  { 
  var okno = window.open("../ucto/uctosn.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Drudan()
  { 
  var okno = window.open("../ucto/drudan.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
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

  function OtvorDban()
  { 
  var okno = window.open("../ucto/dban.php?copern=1&drupoh=1&page=1","_blank");
  }

  function Priku()
  { 
  var okno = window.open("../ucto/vstpru.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }

  function PocOdber()
  { 
  var okno = window.open('../faktury/vstfak.php?copern=1&drupoh=1001&page=1&pocstav=1','_blank','<?php echo $parwin; ?>');
  }

  function PocDodav()
  { 
  var okno = window.open("../faktury/vstfak.php?copern=1&drupoh=1002&page=1&pocstav=1","_blank",'<?php echo $parwin; ?>');
  }

  function PocUhrad()
  { 
  var okno = window.open("../ucto/oprsys.php?copern=308&drupoh=8&page=1","_blank",'<?php echo $parwin; ?>');
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
"Chcete nahra novú odberate¾skú faktúru ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_ddod WHERE drdo = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $ucedod=$riadok->ddod;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../faktury/vstf_u.php?pocstav=0&copern=5&drupoh=2&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $ucedod; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra novú dodávate¾skú faktúru ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dpok WHERE drpk = 1");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $ucepok=$riadok->dpok;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=1&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $ucepok; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra novı príjmovı pokladniènı doklad ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=2&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $ucepok; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra novı vıdavkovı pokladniènı doklad ?</a>";
    htmlmenu += "</td></tr>";

  <?php
  $sql = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_dban WHERE dban > 0");
  if (@$zaznam=mysql_data_seek($sql,0))
  {
  $riadok=mysql_fetch_object($sql);
  $uceban=$riadok->dban;
  }
  ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=4&page=1&rozuct=ANO&sysx=UCT&hladaj_uce=<?php echo $uceban; ?>', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra novı bankovı vıpis ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vspk_u.php?copern=5&drupoh=5&page=1&rozuct=ANO&sysx=UCT', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete nahra novı všeobecnı úètovnı doklad ?</a>";
    htmlmenu += "</td></tr>";

<?php if( $kli_vduj == 9 ) { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/penden.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Peòanı denník ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vprivyd.php?copern=10&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıkaz o príjmoch a vıdavkoch ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vmajzav.php?copern=10&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıkaz o majetku a záväzkoch ?</a>";
    htmlmenu += "</td></tr>";

<?php                      } ?>

<?php if( $kli_vduj != 9 ) { ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/udennik.php?copern=10&drupoh=1&page=1&typ=HTML', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Úètovnı denník ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/vykzis_pod2014.php?copern=10&drupoh=1&tis=0&h_zos=&h_sch=&h_drp=&page=1&lensuv=0&lenvzs=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Vıkaz ziskov a strát Úè POD 2-01 ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/suvaha_pod2014.php?copern=10&drupoh=1&tis=0&h_zos=&h_sch=&h_drp=&page=1&lensuv=1&lenvzs=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Súvahu Úè POD 1-01 ?</a>";
    htmlmenu += "</td></tr>";

<?php                      } 

$rokdph=2018;
if( $vyb_rok <= 2017 ) { $rokdph=2014; }
if( $vyb_rok <= 2013 ) { $rokdph=2013; }
if( $vyb_rok <= 2012 ) { $rokdph=2012; }
?>


    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?copern=10&drupoh=1&page=1fir_uctx01=0&h_drp=1&h_dap=&h_arch=0', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete vytlaèi Daòové priznanie Daò z pridanej hodnoty ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
    htmlmenu += "Chcete skontrolova ";
    htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/prizdph<?php echo $rokdph; ?>.php?copern=40&drupoh=1&page=1&chyby=1', '_blank','<?php echo $tlcswin; ?>' )\">";
    htmlmenu += "DPH </a> , ";
    htmlmenu += "<a href=\"#\" onClick=\"window.open('../ucto/ucto_kontrol.php?copern=40&drupoh=1&page=1', '_blank','<?php echo $tlcswin; ?>' )\">";
    htmlmenu += "Úètovanie </a> nahratıch dokladov ?";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../cis/stiahni_ecb.php?copern=1010', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete stiahnu kurzovı lístok ECB na dnes ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../cis/stiahni_ecb.php?copern=1010&dni90=1', '_blank','<?php echo $tlcswin; ?>' )\">" +
"Chcete stiahnu kurzovı lístok ECB 90dní spä ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "</table>";  

</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Finanèné úètovníctvo
<?php if( $vyb_duj == 0 ) { echo " PU"; } ?>
<?php if( $vyb_duj == 9 ) { echo " JU"; } ?>
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid  ";?></span></td>
</tr>
</table>
<table class="pmenu" width="100%" style="border:none;" >
<tr>
<td width="60%" >
<a href='podvojneu.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width="15" height="10" title="Zmena úètovnej jednotky" border="0"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='podvojneu.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width="15" height="10" border="0" title="Zmena úètovného obdobia">
Úètovné obdobie:</a>
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
<td width='18%' onClick="M1KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup dát' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/mesacnespracovanie.jpg' style='width:98%; height:20;' alt='Mesaèné spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/informacieavystupy.jpg' style='width:98%; height:20;' alt='Informácie a vıstupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a sluby' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='Èíselníky a údrba' ></a></center>
</td>
</tr>
</table>


<div id="progmenu1" style="cursor:hand; display:none; position:absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup dát</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorOdber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r1.jpg' style='width:98%; height:20;' alt='Kniha odberate¾skıch faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r2.jpg' style='width:98%; height:20;' alt='Kniha dodávate¾skıch faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorppri();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r3.jpg' style='width:98%; height:20;' alt='Príjmovı pokladniènı doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorpvyd();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r4.jpg' style='width:98%; height:20;' alt='Vıdavkovı pokladniènı doklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorbank();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r5.jpg' style='width:98%; height:20;' alt='Bankovı vıpis' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Otvorvseo();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s1-r6.jpg' style='width:98%; height:20;' alt='Všeobecné úètovné doklady' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu Mesaèné spracovanie</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="meszos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r1.jpg' style='width:98%; height:20;' alt='Vytvorenie mesaènıch úètovnıch zostáv' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="sttzos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r2.jpg' style='width:98%; height:20;' alt='Štatistika a vıkazníctvo' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="oprsys();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r3.jpg' style='width:98%; height:20;' alt='Preh¾ady a úpravy dát z podsystémov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="danprij();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s2-r4.jpg' style='width:98%; height:20;' alt='Priznanie k dani z príjmov' ></a></center></td></tr>



</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Informácie a vıstupy</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="saldo();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r1.jpg' style='width:98%; height:20;' alt='Odberate¾ské a dodávate¾ské Saldokonto' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="uctpohyby();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r2.jpg' style='width:98%; height:20;' alt='Vıpis úètovnıch pohybov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="hladaj_doklad();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r3.jpg' style='width:98%; height:20;' alt='Preh¾adávanie dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Cudzie();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r4.jpg' style='width:98%; height:20;' alt='Úèty vedené v cudzích menách' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Upomienka();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r5.jpg' style='width:98%; height:20;' alt='Upomienka, penále odberate¾skıch faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Priku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r6.jpg' style='width:98%; height:20;' alt='Príkaz na úhradu dodáv.faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Rucnespar();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r7.jpg' style='width:98%; height:20;' alt='Ruèné spárovanie a opravy saldokonta' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Vzajomny();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r8.jpg' style='width:98%; height:20;' alt='Vzájomnı zápoèet odber. a dodav. faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Faktoring();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r9.jpg' style='width:98%; height:20;' alt='Postúpenie poh¾adávok a záväzkov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="prhdok();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s3-r10.jpg' style='width:98%; height:20;' alt='Zoznamy dokladov' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a sluby</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir91();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Finanèné Úètovníctvo' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Uctosn();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r2.jpg' style='width:98%; height:20;' alt='Úètová osnova' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Drudan();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r3.jpg' style='width:98%; height:20;' alt='Druhy daòovıch dokladov DPH' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDodb();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r4.jpg' style='width:98%; height:20;' alt='Druhy odberate¾skıch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDdod();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r5.jpg' style='width:98%; height:20;' alt='Druhy dodávate¾skıch dokladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDpok();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r6.jpg' style='width:98%; height:20;' alt='Druhy pokladníc' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDban();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r7.jpg' style='width:98%; height:20;' alt='Druhy bankovıch úètov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PocOdber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r8.jpg' style='width:98%; height:20;' alt='Poèiatoènı stav Odberate¾skıch faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PocDodav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r9.jpg' style='width:98%; height:20;' alt='Poèiatoènı stav Dodávate¾skıch faktúr' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PocUhrad();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s4-r10.jpg' style='width:98%; height:20;' alt='Poèiatoènı stav Úhrad' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu Èíselníky a údrba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r1.jpg' style='width:98%; height:20;' alt='Údaje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r2.jpg' style='width:98%; height:20;' alt='Èíselník IÈO' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r3.jpg' style='width:98%; height:20;' alt='Èíselník stredísk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r4.jpg' style='width:98%; height:20;' alt='Èíselník zákaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r5.jpg' style='width:98%; height:20;' alt='Èíselník skupín' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r6.jpg' style='width:98%; height:20;' alt='Èíselník stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r7.jpg' style='width:98%; height:20;' alt='E-zákazníci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="ZalDat();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r9.jpg' style='width:98%; height:20;' alt='Zálohovanie dát' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos poè.stavu' ></a></center></td></tr>


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
<td width="20%" ><center>Vstup dát</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>Mesaèné spracovanie</center></td>
</span>

<span  onclick="M3.Klepnuti(); return false;  ">
<td width="20%" ><center>Informácie a vıstupy</center></td>
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
<FORM name="fir1" class="obyc" method="post" action="podvojneu.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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

$setuzrok = include("cis/citajrok.php");

$sql = mysql_query("SELECT xcf,naz,rok,duj FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' AND rok > $citajrok ORDER BY xcf");
// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>

<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="podvojneu.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
<tr>
<td class="obyc">
<select size="10" name="firs" id="firs">
<?php while($zaznam=mysql_fetch_array($sql)):?>
<?php
$coloritem="FFFFFF";
//if( $zaznam["xcf"] == 1 ) { $coloritem="c8e6c9"; }
?>
<option value="<?php echo $zaznam["xcf"];?>" style="background-color: #<?php echo $coloritem;?>" 
<?php

if ( $zaznam["xcf"] == $vyb_xcf ) echo " selected='selected'";
$umes1="1.".$zaznam["rok"]
?>
 ><?php echo $zaznam["xcf"];?> - <?php echo $zaznam["naz"];?></option>

<?php endwhile;?>
</td>
</tr>
<tr>
<INPUT type="hidden" id="umes" name="umes" value="<?php echo $umes1;?>" >
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
 alt='Dobrı deò , ja som Váš EkoRobot , ak máte otázku alebo nejaké elanie kliknite na mòa prosím 1x myšou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>
<?php

$robot=1;
$absolut=1;
$zmenume=1; $odkaz="../podvojneu.php?copern=1&newmenu=$newmenu";
$cislista = include("ucto/uct_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
