<?PHP
session_start();

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
$sys = 'HIM';
$cslm=1;
$urov = 1000;
if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite vöetky okn· v prehliadaËi IE a prihl·ste sa znovu prosÌm do IS, ak ste pouûÌvali CestovnÈ prÌkazy"; exit; }
$uziv = include("uziv.php");
if( !$uziv ) exit;

  require_once("pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;
$dtb2 = include("oddel_dtb1.php");

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

$dtb2 = include("oddel_dtb2.php");

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$cvybxcf=1*$vyb_xcf;
if( $cvybxcf > 0 )
          {
//len ak je vybrana firma
//echo "<br /><br /><br /><br /><br />idem";

$sql = "SELECT rdoba7 FROM ".$mysqldbdata.".F$vyb_xcf"."_majsodp";
if( $copern == 1 OR $copern == 25 )
{
//echo $sql;
$vysledok = mysql_query($sql);
if (!$vysledok):
$kli_vxcf=$vyb_xcf;
  mysql_select_db($mysqldbdata);
$kalend = include("majetok/vtvmaj.php");
endif;
}


          }
//koniec len ak je vybrana firma

$hhmmss = Date ("d_m_H_i_s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Majetok Hl.menu</title>
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
  ( "Zoznam dlhodobÈho majetku",
    "Zozmaj()",
    "Zoznam dlhodobÈho majetku"
  );
  M1.NovaPolozka
  ( "Zoznam drobnÈho majetku",
    "Zozdim()",
    "Zoznam drobnÈho majetku"
  );
  M1.NovaPolozka
  ( "Pohyby dlhodobÈho majetku",
    "Pohmaj()",
    "Pohyby dlhodobÈho majetku"
  );
  M1.NovaPolozka
  ( "Pohyby drobnÈho majetku",
    "Pohdim()",
    "Pohyby drobnÈho majetku"
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 330);
  M2.NovaPolozka
  ( "Spracovanie mesaËn˝ch ˙Ëtovn˝ch odpisov",
    "MesOdp()",
    "Spracovaù mesaËnÈ ˙ËtovnÈ odpisy"
  );
  M2.NovaPolozka
  ( "Prehæady a ruöenie mesaËn˝ch odpisov",
    "ZrsOdp()",
    "Prehæad o spracovan˝ch mesaËn˝ch odpisoch a zruöenie mesaËn˝ch ˙Ëtovn˝ch odpisov"
  );
  M2.NovaPolozka
  ( "Prevod do ˙ËtovnÌctva",
    "PreUct()",
    "Prevod do ˙ËtovnÌctva"
  );
  M2.NovaPolozka
  ( "RoËnÈ daÚovÈ odpisy",
    "DanOdp()",
    "Spracovaù roËnÈ daÚovÈ odpisy"
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 350);
  M3.NovaPolozka
  ( "Invent˙rne a evidenËnÈ zostavy majetku",
    "Invmaj()",
    "Invent˙ra dlhodobÈho a drobnÈho majetku a Ôalöie evidenËnÈ zostavy majetku "
  );
  M3.NovaPolozka
  ( "Karty umiestnenia dlhodobÈho majetku",
    "Karmaj()",
    "Karty umiestnenia dlhodobÈho majetku"
  );
  M3.NovaPolozka
  ( "Karty umiestnenia drobnÈho majetku",
    "Kardim()",
    "Karty umiestnenia drobnÈho majetku"
  );
  M3.NovaPolozka
  ( "Presuny dlhodobÈho majetku",
    "ZmKarmaj()",
    "Zmena umiestnenia dlhodobÈho majetku , presun medzi kancel·riami a zamestnancami"
  );
  M3.NovaPolozka
  ( "Presuny drobnÈho majetku",
    "ZmKardim()",
    "Zmena umiestnenia drobnÈho majetku , presun medzi kancel·riami a zamestnancami"
  );
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 250);
  M4.NovaPolozka
  ( "Parametre programu Majetok",
    "OtvorUfir81()",
    "Parametre programu Dlhodob˝ majetok"
  );
  M4.NovaPolozka
  ( "OdpisovÈ sadzby majetku",
    "sadodp()",
    "OdpisovÈ sadzby majetku"
  );
  M4.NovaPolozka
  ( "Druhy dlhodobÈho majetku",
    "CisDrm()",
    "Druhy dlhodobÈho majetku"
  );
  M4.NovaPolozka
  ( "Druhy drobnÈho majetku",
    "DruDim()",
    "Druhy drobnÈho majetku"
  );
  M4.NovaPolozka
  ( "Druhy obstarania majetku",
    "DruNak()",
    "Druhy obstarania majetku"
  );
  M4.NovaPolozka
  ( "Druhy vyradenia majetku",
    "DruVyr()",
    "Druhy vyradenia majetku"
  );
  M4.NovaPolozka
  ( "Zoznam kancel·riÌ",
    "Kanc()",
    "Zoznam kancel·riÌ"
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
  ( "⁄daje o firme",
    "OtvorUfir1()",
    "⁄daje o firme"
  );
  M5.NovaPolozka
  ( "»ÌselnÌk I»O",
    "OtvorCico()",
    "»ÌselnÌk"
  );
  M5.NovaPolozka
  ( "»ÌselnÌk stredÌsk",
    "OtvorCstr()",
    "»ÌselnÌk"
  );
  M5.NovaPolozka
  ( "»ÌselnÌk z·kaziek",
    "OtvorCzak()",
    "»ÌselnÌk"
  );
  M5.NovaPolozka
  ( "»ÌselnÌk skupÌn",
    "OtvorCsku()",
    "»ÌselnÌk skupn"
  );
  M5.NovaPolozka
  ( "»ÌselnÌk stavieb",
    "OtvorCsta()",
    "»ÌselnÌk stavieb"
  );
  M5.NovaPolozka
  ( "E-z·kaznÌci",
    "Ezakaznik()",
    "Registr·cia e-z·kaznÌkov"
  );
  M5.NovaPolozka
  ( "Z·lohovanie d·t",
    "ZalDat()",
    "Z·lohovanie d·t na mÈdium "
  );
  M5.NovaPolozka
  ( "Prenos poË.stavu",
    "PrenosPoc()",
    "Prenos poËiatoËnÈho stavu majetku "
  );
  M5.classMenu = "menu2";
  M5.classPolozka = "polozka2";
  M5.classApolozka = "Apolozka2";
//  M5.x=800;// M1.y=100;

<?php                     } ?>

   // Priklad funkce volane z menu
  function Funkciazmenu()
  {
    alert ("Hl·si sa sluûba z menu");
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

  function OtvorUfir81()
  { 
  var okno = window.open("../cis/ufir.php?copern=81","_blank");
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
  var okno = window.open("../cis/zaldat_maj.php?copern=101&page=1","_blank");
  }

  function ObnDat()
  { 
  var okno = window.open("../cis/obndat.php?copern=1&page=1","_blank");
  }

  function Ezakaznik()
  { 
  var okno = window.open("../cis/ezak.php?copern=1&page=1","_blank");
  }

//[[[[[[[ body majetok

  function Zozmaj()
  { 
  var okno = window.open("../majetok/vstmaj.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function Zozdim()
  { 
  var okno = window.open("../majetok/vstmaj.php?copern=1&drupoh=2&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function Pohmaj()
  { 
  var okno = window.open("../majetok/vstmaj.php?copern=1&drupoh=11&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function Pohdim()
  { 
  var okno = window.open("../majetok/vstmaj.php?copern=1&drupoh=12&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function MesOdp()
  { 
  var okno = window.open("../majetok/mesodp.php?copern=2&drupoh=1&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function DanOdp()
  { 
  var okno = window.open("../majetok/mesodp.php?copern=3&drupoh=3&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function ZrsOdp()
  { 
  var okno = window.open("../majetok/zrsmes.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function PreUct()
  { 
  var okno = window.open("../majetok/majuct.php?copern=10&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Infmaj()
  { 

  }

  function Infdan()
  { 

  }

  function Infdim()
  { 

  }

  function Invmaj()
  { 
  var okno = window.open("../majetok/invmaj.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function Invdan()
  { 
  var okno = window.open("../majetok/invmaj.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function Invdim()
  { 
  var okno = window.open("../majetok/invmaj.php?copern=1&drupoh=1&page=1&<?php echo $hhmmss; ?>","_blank",'<?php echo $parwin; ?>');
  }

  function CisDrm()
  { 
  var okno = window.open("../majetok/cisdrm.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function DruDim()
  { 
  var okno = window.open("../majetok/cisdbm.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function DruNak()
  { 
  var okno = window.open("../majetok/cisnak.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function DruVyr()
  { 
  var okno = window.open("../majetok/cisvyr.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Kanc()
  { 
  var okno = window.open("../majetok/ciskanc.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function MzdKun()
  { 
  var okno = window.open("../majetok/mzdkun.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function sadodp()
  { 
  var okno = window.open("../majetok/sadodp.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Karmaj()
  { 
  var okno = window.open("../majetok/majkar.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function Kardim()
  { 
  var okno = window.open("../majetok/majkar.php?copern=1&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZmKarmaj()
  { 
  var okno = window.open("../majetok/prekar.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZmKardim()
  { 
  var okno = window.open("../majetok/prekar.php?copern=1&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function PrenosPoc()
  { 
  var okno = window.open("../cis/prenos_poc.php?copern=2&drupoh=1&page=1&upozorni2011=1&upozorni2012=1&upozorni2013=1","_blank",'<?php echo $parwin; ?>');
  }

</script>
</HEAD>
<BODY class="white" >


<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Dlhodob˝ majetok</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none;">
<tr>
<td width="60%" >
<a href='majetok.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ˙Ëtovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='majetok.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ˙ËtovnÈho obdobia"> ⁄ËtovnÈ obdobie:</a>
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

<table class="pmenu" width="100%" style="position:relative; top:3px; border:none; background-color:white;">
<tr>
<td width='20%' onClick="M1KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup d·t' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/mesacnespracovanie.jpg' style='width:98%; height:20;' alt='MesaËnÈ spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/informacieavystupy.jpg' style='width:98%; height:20;' alt='Inform·cie a v˝stupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a sluûby' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='»ÌselnÌky a ˙drûba' ></a></center>
</td>
</tr>
</table>

<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup d·t</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="Zozmaj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s1-r1.jpg' style='width:98%; height:20;' alt='Zoznam dlhodobÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Zozdim();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s1-r2.jpg' style='width:98%; height:20;' alt='Zoznam drobnÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Pohmaj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s1-r3.jpg' style='width:98%; height:20;' alt='Pohyby dlhodobÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Pohdim();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s1-r4.jpg' style='width:98%; height:20;' alt='Pohyby drobnÈho majetku' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu MesaËnÈ spracovanie</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="MesOdp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s2-r1.jpg' style='width:98%; height:20;' alt='Spracovanie mesaËn˝ch ˙Ëtovn˝ch odpisov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZrsOdp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s2-r2.jpg' style='width:98%; height:20;' alt='Prehæady a ruöenie mesaËn˝ch odpisov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PreUct();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s2-r3.jpg' style='width:98%; height:20;' alt='Prevod do ˙ËtovnÌctva' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="DanOdp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s2-r4.jpg' style='width:98%; height:20;' alt='RoËnÈ daÚovÈ odpisy' ></a></center></td></tr>



</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Inform·cie a v˝stupy</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="Invmaj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s3-r1.jpg' style='width:98%; height:20;' alt='Invent˙rne a evidenËnÈ zostavy majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Karmaj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s3-r2.jpg' style='width:98%; height:20;' alt='Karty umiestnenia dlhodobÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Kardim();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s3-r3.jpg' style='width:98%; height:20;' alt='Karty umiestnenia drobnÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZmKarmaj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s3-r4.jpg' style='width:98%; height:20;' alt='Presuny dlhodobÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="ZmKardim();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s3-r5.jpg' style='width:98%; height:20;' alt='Presuny drobnÈho majetku' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a sluûby</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir81();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Majetok' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="sadodp();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r2.jpg' style='width:98%; height:20;' alt='OdpisovÈ sadzby majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="CisDrm();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r3.jpg' style='width:98%; height:20;' alt='Druhy dlhodobÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="DruDim();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r4.jpg' style='width:98%; height:20;' alt='Druhy drobnÈho majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="DruNak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r5.jpg' style='width:98%; height:20;' alt='Druhy obstarania majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="DruVyr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r6.jpg' style='width:98%; height:20;' alt='Druhy vyradenia majetku' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="Kanc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r7.jpg' style='width:98%; height:20;' alt='Zoznam kancel·riÌ' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="MzdKun();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s4-r8.jpg' style='width:98%; height:20;' alt='Zoznam zamestnancov' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu »ÌselnÌky a ˙drûba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r1.jpg' style='width:98%; height:20;' alt='⁄daje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r2.jpg' style='width:98%; height:20;' alt='»ÌselnÌk I»O' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r3.jpg' style='width:98%; height:20;' alt='»ÌselnÌk stredÌsk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r4.jpg' style='width:98%; height:20;' alt='»ÌselnÌk z·kaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r5.jpg' style='width:98%; height:20;' alt='»ÌselnÌk skupÌn' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r6.jpg' style='width:98%; height:20;' alt='»ÌselnÌk stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r7.jpg' style='width:98%; height:20;' alt='E-z·kaznÌci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="ZalDat();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r9.jpg' style='width:98%; height:20;' alt='Z·lohovanie d·t' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/majetok/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos poË.stavu' ></a></center></td></tr>


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
<td width="20%" ><center>Vstup d·t</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>MesaËnÈ spracovanie</center></td>
</span>

<span  onclick="M3.Klepnuti(); return false;  ">
<td width="20%" ><center>Inform·cie a v˝stupy</center></td>
</span>

<span  onclick="M4.Klepnuti(); return false; ">
<td width="20%" ><center>Nastavenia a sluûby</center></td>
</span>

<span  onclick="M5.Klepnuti(); return false; ">
<td width="20%" ><center>»ÌselnÌky a ˙drûba</center></td>
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
<FORM name="fir1" class="obyc" method="post" action="majetok.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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
<td class="obyc"><INPUT type="submit" id="umev" name="umev" value="Vybraù ˙ËtovnÈ obdobie" ></td>
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
<FORM name="fir1" class="obyc" method="post" action="majetok.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
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
<td class="obyc"><INPUT type="submit" id="firv" name="firv" value="Vybraù ˙Ëtovn˙ jednotku" ></td>
</tr>
</FORM>
</table>
</span>

<?php
mysql_close();
mysql_free_result($sql);

// toto je koniec zmeny firmy 
     }

$absolut=1;
$zmenume=1; $odkaz="../majetok.php?copern=1&newmenu=$newmenu";
$cislista = include("majetok/maj_lista.php");


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
