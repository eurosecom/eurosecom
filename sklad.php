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
$paruwin="width=' + 980 + ', height=' + vyskawin + ', top=0, left=0, status=yes, resizable=yes, scrollbars=yes";

       do
       {
if ( $copern !== 99 )
{
$sys = 'SKL';
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

$sql = "SELECT me2 FROM ".$mysqldbdata.".F$vyb_xcf"."_sklfak  ";
$vysledok = mysql_query($sql);
if ( !$vysledok ){
$ttvv = "DROP TABLE ".$mysqldbdata.".F$vyb_xcf"."_vtvskl";
$ttqq = mysql_query("$ttvv");
                 }

$dtb2 = include("oddel_dtb2.php");

//echo $vyb_rok;
//echo $mysqldbdata;


  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$zver=0;
if (File_Exists ("zver.php")) 
{ 
$zver=1;
}

$hotel = 1*$_REQUEST['hotel'];
if( $hotel == 1 )
   {
//echo "hotel".$hotel;
$xskl=1;
$sqlmax = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_hoteluzid WHERE uzix=$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $xskl=1*$riadmax->xskl;
  }
if( $xskl == 0 )
{
?>
<script type="text/javascript" > 
alert ("ºutujem , nem·te dostatoËnÈ prÌstupovÈ pr·va .");
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
<title>Sklad Hl.menu</title>
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
  ( "PrÌjem z·sob na sklad",
    "OtvorPrijem()",
    "PrÌjem materi·lu na sklad"
  );
  M1.NovaPolozka
  ( "V˝daj z·sob zo skladu",
    "OtvorVydaj()",
    "V˝daj materi·lu zo skladu"
  );
  M1.NovaPolozka
  ( "Presun z·sob medzi skladmi",
    "OtvorPresun()",
   "Presun materi·lu na in˝ sklad"
  );
  M1.Cara(); // --------------------
  M1.NovaPolozka
  ( "Spotreba staveniötn˝ch skladov",
    "SpoSta()",
   "Spotreba staveniötn˝ch skladov"
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 380);
  M2.NovaPolozka
  ( "Vytvorenie mesaËn˝ch skladov˝ch zost·v",
    "meszos()",
    "Vytvorenie mesaËn˝ch skladov˝ch zost·v...."
  );

  M2.NovaPolozka
  ( "Prevod do ˙ËtovnÌctva",
    "PrevUct()",
    "Prevod do ˙ËtovnÌctva"
  );
  M2.NovaPolozka
  ( "Kontrola za˙Ëtovania dokladov v sklade ",
    "KontrolUcto()",
    "Kontrola za˙Ëtovania dokladov v sklade "
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 400);
  M3.NovaPolozka
  ( "SkladovÈ karty materi·lu",
    "Skarty()",
    "SkladovÈ karty"
  )
<?php if( $zver == 1 ) { ?>
  M3.NovaPolozka
  ( "SkladovÈ zostavy a inform·cie o zvierat·ch",
    "zos2mj()",
    "Prehæady a inform·cie o zvierat·ch"
  )
<?php                  } ?>
<?php if( $zver == 3 ) { ?>
  M3.NovaPolozka
  ( "SkladovÈ zostavy a inform·cie o 2MJ poloûk·ch",
    "zos2mj()",
    "Prehæady o poloûk·ch, ktorÈ s˙ evidovanÈ v dvoch mern˝ch jednotk·ch"
  )
<?php                  } ?>
  M3.NovaPolozka
  ( "Prehæady a inform·cie o z·sob·ch",
    "InfoZas()",
    "Prehæady a inform·cie o z·sob·ch"
  )
  M3.NovaPolozka
  ( "Invent˙rna zostava",
    "InvZos()",
    "Invent˙rna zostava"
  )
  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 350);
  M4.NovaPolozka
  ( "Parametre programu sklad",
    "OtvorUfir11()",
    "Parametre programu sklad"
  );
  M4.NovaPolozka
  ( "Sklady materi·lu a tovaru",
    "OtvorCskl()",
    "Sklady materi·lu a tovaru"
  );
  M4.NovaPolozka
  ( "Materi·lovÈ a tovarovÈ poloûky",
    "OtvorCcis()",
    "Materi·lovÈ a tovarovÈ poloûky"
  );
  M4.NovaPolozka
  ( "SkladovÈ pohyby materi·lu a tovaru",
    "OtvorDRPoh()",
    "SkladovÈ pohyby materi·lu a tovaru"
  );
  M4.NovaPolozka
  ( "PoËiatoËn˝ stav skladov",
    "OtvorPocStav()",
    "PoËiatoËn˝ stav skladov"
  );
  M4.NovaPolozka
  ( "Vymazanie nulov˝ch materi·lov˝ch poloûiek",
    "vymaznulovecis()",
    "Vymazanie nulov˝ch materi·lov˝ch poloûiek"
  );
  M4.NovaPolozka
  ( "Rekonötrukcia stavu z·sob",
    "RekZas()",
    "Rekonötrukcia stavu z·sob na skladoch"
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
    "Prenos poËiatoËnÈho stavu skladov "
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

  function OtvorPocStav()
  { 
  var okno = window.open("../sklad/cpoc.php?copern=1&page=1","_blank");
  //okno.document.write("<html><head><title>okno</title></head><body><h1>novÈ okno</h1></body></html>");
  //okno.document.close();
  }

  function OtvorCskl()
  { 
  var okno = window.open("../sklad/cskl.php?copern=1&page=1","_blank");
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

  function OtvorUfir11()
  { 
  var okno = window.open("../cis/ufir.php?copern=11","_blank");
  }

  function OtvorDRPoh()
  { 
  var okno = window.open("../sklad/csph.php?copern=1&page=1","_blank");
  }

  function OtvorCico()
  { 
  var okno = window.open("../cis/cico.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorPrijem()
  { 
  var okno = window.open("../sklad/vstpoh.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorVydaj()
  { 
  var okno = window.open("../sklad/vstpoh.php?copern=1&drupoh=2&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorPresun()
  { 
  var okno = window.open("../sklad/vstpoh.php?copern=1&drupoh=3&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function SpoSta()
  { 
  var okno = window.open("../sklad/sposta.php?copern=10&page=1","_blank",'<?php echo $parwin; ?>, menubar=yes, toolbar=yes');
  }

  function meszos()
  { 
  var okno = window.open("../sklad/meszos.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
  }


  function OtvorCcis()
  { 
  var okno = window.open("../sklad/ccis.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }
  function RekZas()
  { 
  var okno = window.open("../sklad/sklzas.php?copern=50&page=1","_blank");
  }
  function StavZas()
  { 
  var okno = window.open("../sklad/sklzas_pdf.php?copern=10","_blank");
  }
  function PohSklM()
  { 
  var okno = window.open("../sklad/pohskl.php?copern=10&page=1","_blank");
  }
  function PohSklO()
  { 
  var okno = window.open("../sklad/pohskl.php?copern=20&page=1","_blank");
  }
  function SklPohM()
  { 
  var okno = window.open("../sklad/pohyby_pdf.php?copern=10&page=1","_blank");
  }
  function SklPohO()
  { 
  var okno = window.open("../sklad/pohyby_pdf.php?copern=20&page=1","_blank");
  }

  function PohDruM()
  { 
  var okno = window.open("../sklad/pohdru.php?copern=10&page=1","_blank");
  }
  function PohDruO()
  { 
  var okno = window.open("../sklad/pohdru.php?copern=20&page=1","_blank");
  }
  function SpoZakM()
  { 
  var okno = window.open("../sklad/spozak.php?copern=10&page=1","_blank");
  }
  function SpoZakO()
  { 
  var okno = window.open("../sklad/spozak.php?copern=20&page=1","_blank");
  }
  function PrevUct()
  { 
  var okno = window.open("../sklad/preuct.php?copern=10&page=1","_blank");
  }

  function ZosCisM()
  { 
  var okno = window.open("../sklad/sklzas_pdf.php?copern=20","_blank");
  }
  function ZosPriM()
  { 
  var okno = window.open("../sklad/zprijmu_pdf.php?copern=10&page=1","_blank");
  }
  function ZosVydM()
  { 
  var okno = window.open("../sklad/zvydaja_pdf.php?copern=10&page=1","_blank");
  }
  function ZosPreM()
  { 
  var okno = window.open("../sklad/zpresun.php?copern=10&page=1","_blank");
  }

  function PrehladPrijem()
  { 
  var okno = window.open("../sklad/vstpoh.php?copern=10&drupoh=1&page=1","_blank");
  }

  function PrehladVydaj()
  { 
  var okno = window.open("../sklad/vstpoh.php?copern=10&drupoh=2&page=1","_blank");
  }

  function PrehladPresun()
  { 
  var okno = window.open("../sklad/vstpoh.php?copern=10&drupoh=3&page=1","_blank");
  }

  function vymaznulovecis()
  { 
  var okno = window.open("../sklad/zmaznulcis.php?copern=10&drupoh=1&page=1","_blank");
  }

  function ZmnPrih()
  { 
  var okno = window.open("../cis/zmnprih.php?copern=1&page=1","_blank");
  }

  function ZalDat()
  { 
  var okno = window.open("../cis/zaldat_skl.php?copern=101&page=1","_blank");
  }

  function ObnDat()
  { 
  var okno = window.open("../cis/obndat.php?copern=1&page=1","_blank");
  }

  function Ezakaznik()
  { 
  var okno = window.open("../cis/ezak.php?copern=1&page=1","_blank");
  }

  function Skarty()
  { 
  var okno = window.open("../sklad/sklkar.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function PrenosPoc()
  { 
  var okno = window.open("../cis/prenos_poc.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function InfoZas() 
  {
  var okno = window.open("../sklad/info_zas.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function zos2mj() 
  {
  var okno = window.open("../sklad/zos2mj.php?copern=1&drupoh=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function InvZos()
  { 
  var okno = window.open("../sklad/sklinv_pdf.php?copern=10","_blank",'<?php echo $parwin; ?>');
  }

  function KontrolUcto() 
  {
  var okno = window.open("../sklad/preuct.php?copern=10&page=1&kontrol=1","_blank",'<?php echo $paruwin; ?>');
  }

  function ukazrobot()
  { 
  <?php if( $vyb_robot == 1 ) { echo "robotokno.style.display='';"; } ?>
  myRobot = document.getElementById("robotokno");
  myRobot.style.top = toprobot;
  myRobot.style.left = leftrobot;
  }

  function zhasnirobot()
  { 
  robotokno.style.display='none';
  nastavdakx.style.display='none';
  }

  function zobraz_robotmenu()
  { 
  nastavdakx.style.display='';
  }

  function zhasni_menurobot()
  { 
  nastavdakx.style.display='none';
  }


  function ZmenyPriemerne()
  { 

  var okno = window.open('../sklad/zmenapriemer_pdf.php?copern=20&&xx=1',"_blank", 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes');
  }


</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 ) { echo "onload='ukazrobot();'"; } ?> >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Sklad</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>



<?php
//kontrola nahrate po datume
if ( $copern == 1 OR $copern == 25 )
     {

$dnesoktime = Date ("d.m.Y H.s", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

?>
<div id="nastavdakx" style="cursor: hand; display: none; position: absolute; z-index: 500; top: 170px; left: 100px; width:500px; height:300px;">
<table  class='ponuka' width='100%'>
<FORM name='ekont' method='post' action='#' >
<tr><td width='90%'>Menu EkoRobot</td>

<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' title='Zhasni menu' ></td></tr>  

<tr><td width='100%' class='ponuka' colspan='2'> 
<a href="#" onClick="window.open('../sklad/vstpoh.php?copern=10&drupoh=1&page=1', '_blank' )">
Chcete zoznam prÌjemok materi·lu ?</a>
</td></tr>


<tr><td width='100%' class='ponuka' colspan='2'> 
<a href="#" onClick="window.open('../sklad/vstpoh.php?copern=10&drupoh=2&page=1', '_blank' )">
Chcete zoznam v˝dajok materi·lu ?</a>
</td></tr>


<tr><td width='100%' class='ponuka' colspan='2'> 
<a href="#" onClick="window.open('../sklad/vstpoh.php?copern=10&drupoh=3&page=1', '_blank' )">
Chcete zoznam presuniek materi·lu  ?</a>
</td></tr>


<tr><td class='ponuka' colspan='2'>
Chcete skontrolovaù 
<a href="#" onClick="KontrolaPoUme();", '_blank' )">
doklady z <?php echo $vyb_ume; ?> nahratÈ po d·tume</a> <input type='text' name='h_datpo' id='h_datpo' size='15' maxlenght='15' value='<?php echo $dnesoktime; ?>' >
 ?
</td>
</FORM>
</tr> 


<tr><td width='100%' class='ponuka' colspan='2'> 
Chcete skontrolovaù 
<a href="#" onClick="ZmenyPriemerne();">
PriemernÈ ceny <?php echo $vyb_ume; ?> / n·kupnÈ ceny</a> ? 
</td></tr>

</table>  
</div>

<script type="text/javascript">
    function KontrolaPoUme()
    {
    var datum=document.ekont.h_datpo.value;

    window.open('../sklad/sklad_kontrol.php?copern=50&drupoh=1&datum=' + datum + '&page=1', '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' )

    }

</script>
<?php
     }
//koniec kontrola nahrate po datume
?>




<table class="pmenu" width="100%" style="border:none;">
<tr>
<td width="60%" >
<a href='sklad.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ˙Ëtovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='sklad.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ˙ËtovnÈho obdobia"> ⁄ËtovnÈ obdobie:</a>
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
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup d·t' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/mesacnespracovanie.jpg' style='width:98%; height:20;' alt='MesaËnÈ spracovanie' ></a></center>
</td>
<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/informacieavystupy.jpg' style='width:98%; height:20;' alt='Inform·cie a v˝stupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a sluûby' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='»ÌselnÌky a ˙drûba' ></a></center>
</td>
</tr>
</table>

<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew1' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup d·t</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorPrijem();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s1-r1.jpg' style='width:98%; height:20;' alt='PrÌjem z·sob na sklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorVydaj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s1-r2.jpg' style='width:98%; height:20;' alt='V˝daj z·sob zo skladu' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorPresun();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s1-r3.jpg' style='width:98%; height:20;' alt='Presun z·sob medzi skladmi' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="SpoSta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s1-r4.jpg' style='width:98%; height:20;' alt='Spotreba staveniötn˝ch skladov' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew2' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu MesaËnÈ spracovanie</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="meszos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s2-r1.jpg' style='width:98%; height:20;' alt='Vytvorenie mesaËn˝ch skladov˝ch zost·v' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="PrevUct();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s2-r2.jpg' style='width:98%; height:20;' alt='Prevod do ˙ËtovnÌctva' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="KontrolUcto();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s2-r3.jpg' style='width:98%; height:20;' alt='Kontrola za˙Ëtovania dokladov v sklade' ></a></center></td></tr>


</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew3' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Inform·cie a v˝stupy</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="Skarty();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s3-r1.jpg' style='width:98%; height:20;' alt='SkladovÈ karty materi·lu' ></a></center></td></tr>
<?php if( $zver == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="zos2mj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s3-r2.jpg' style='width:98%; height:20;' alt='SkladovÈ zostavy a inform·cie o zvierat·ch' ></a></center></td></tr>
<?php                  } ?>
<?php if( $zver == 3 ) { ?>
<tr><td width='100%' colspan='2' onClick="uctpohyby();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s3-r2.jpg' style='width:98%; height:20;' alt='SkladovÈ zostavy a inform·cie o 2MJ poloûk·ch' ></a></center></td></tr>
<?php                  } ?>
<tr><td width='100%' colspan='2' onClick="InfoZas();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s3-r3.jpg' style='width:98%; height:20;' alt='Prehæady a inform·cie o z·sob·ch' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="InvZos();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s3-r4.jpg' style='width:98%; height:20;' alt='Invent˙rna zostava' ></a></center></td></tr>


</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew4' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a sluûby</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir11();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu sklad' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCskl();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r2.jpg' style='width:98%; height:20;' alt='Sklady materi·lu a tovaru' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCcis();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r3.jpg' style='width:98%; height:20;' alt='Materi·lovÈ a tovarovÈ poloûky' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorDRPoh();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r4.jpg' style='width:98%; height:20;' alt='SkladovÈ pohyby materi·lu a tovaru' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorPocStav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r5.jpg' style='width:98%; height:20;' alt='PoËiatoËn˝ stav skladov' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="vymaznulovecis();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r6.jpg' style='width:98%; height:20;' alt='Vymazanie nulov˝ch materi·lov˝ch poloûiek' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="RekZas();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s4-r7.jpg' style='width:98%; height:20;' alt='Rekonötrukcia stavu z·sob' ></a></center></td></tr>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew5' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu »ÌselnÌky a ˙drûba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r1.jpg' style='width:98%; height:20;' alt='⁄daje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r2.jpg' style='width:98%; height:20;' alt='»ÌselnÌk I»O' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r3.jpg' style='width:98%; height:20;' alt='»ÌselnÌk stredÌsk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r4.jpg' style='width:98%; height:20;' alt='»ÌselnÌk z·kaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r5.jpg' style='width:98%; height:20;' alt='»ÌselnÌk skupÌn' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r6.jpg' style='width:98%; height:20;' alt='»ÌselnÌk stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r7.jpg' style='width:98%; height:20;' alt='E-z·kaznÌci' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="ZalDat();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/s5-r9.jpg' style='width:98%; height:20;' alt='Z·lohovanie d·t' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/sklad/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos poË.stavu' ></a></center></td></tr>


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

<span  onclick="M3.Klepnuti(); return false; ">
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
<FORM name="fir1" class="obyc" method="post" action="sklad.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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
<FORM name="fir1" class="obyc" method="post" action="sklad.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
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

$akyrobot = include("akyrobot.php");
?>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr˝ deÚ , ja som V·ö EkoRobot , ak m·te ot·zku alebo nejakÈ ûelanie kliknite na mÚa prosÌm 1x myöou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>
<?php

$robot=1;
$absolut=1;
$zmenume=1; $odkaz="../sklad.php?copern=1&newmenu=$newmenu";
$cislista = include("sklad/skl_lista.php");

//skuska session
// echo $_SESSION['kli_uzid'];
// echo $_SESSION['kli_uzmeno'];
// echo $_SESSION['kli_uzprie'];
// echo $_SESSION['kli_txt1'];
// echo $_SESSION['kli_uzall'];
// echo $_SESSION['kli_uzfak'];
// echo $_SESSION['kli_uzskl'];
// echo $_SESSION['kli_vxcf'];
// echo $_SESSION['kli_nxcf'];
// echo $_SESSION['kli_vume'];
// echo $_SESSION['kli_vrok'];


// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
