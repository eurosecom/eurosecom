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
{ echo "Vypnite v�etky okn� v prehliada�i IE a prihl�ste sa znovu pros�m do IS, ak ste pou��vali Cestovn� pr�kazy"; exit; }
$uziv = include("../uziv.php");
if( !$uziv ) exit;

  require_once("../pswd/password.php");

$mysqldbfir=$mysqldb;
$mysqldbdata=$mysqldb;

if (File_Exists ("pswd/newdeleniedtb.ano") OR File_Exists ("../pswd/newdeleniedtb.ano")) 
          {
$dtb2 = include("../cis/oddel_dtbm1new.php");
          }
else
          {
$dtb2 = include("../cis/oddel_dtbm1.php");
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

$cit_nas = include("../cis/citaj_nas.php");

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
$dtb2 = include("../cis/oddel_dtbm2new.php");
          }
else
          {
$dtb2 = include("../cis/oddel_dtbm2.php");
          }

$sqlfir = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_vtvrest ";
if( $copern == 1 OR $copern == 25 )
{
$fir_vysledok = mysql_query($sqlfir);
if( !$fir_vysledok AND $vyb_xcf > 0 )
  {
//echo "idem";
$kli_vxcf=1*$vyb_xcf;
  mysql_select_db($mysqldbdata);

$vrz = include("vtvrest.php");

  mysql_select_db($mysqldb);
  }
}



$sqlfir = "SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_kuchprm ";
$fir_vysledok = mysql_query($sqlfir);
if( $fir_vysledok )
{
$fir_riadok=mysql_fetch_object($fir_vysledok);
}
$fir_xrs01 = 1*$fir_riadok->xrs01;

$hotel = 1*$_REQUEST['hotel'];
if( $hotel == 1 )
   {
//echo "hotel".$hotel;
$xrest=1;
$sqlmax = mysql_query("SELECT * FROM ".$mysqldbdata.".F$vyb_xcf"."_hoteluzid WHERE uzix=$kli_uzid ");
  if (@$zaznam=mysql_data_seek($sqlmax,0))
  {
  $riadmax=mysql_fetch_object($sqlmax);
  $xrest=1*$riadmax->xrest;
  }
if( $xrest == 0 )
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
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Re�taur�cia Hl.menu</title>
<style type="text/css">
a:link, a:visited {text-decoration: none; color: black;}
a:hover {text-decoration: underline; background-color: #ffff90; }


<?php if( $newmenu == 0 ) { ?>
  @import url(../css/skryvanemenu.css);
<?php                     } ?>
</style>
<?php if( $newmenu == 0 ) { ?>
<script type="text/javascript" src="../js/cskryvanemenu.js" > </script>
<?php                     } ?>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-10;
var vyskawin = screen.height-90;

<?php if( $newmenu == 0 ) { ?>

  // PRVE MENU
  var M1 = new CSkryvaneMenu("M1", 390);
  M1.NovaPolozka
  ( "TOUCH ME - Predaj a Objedn�vky v Re�taur�cii ",
    "PredajTouchme()",
    "Interakt�vny Predaj a Objedn�vanie tovaru v Re�taur�cii - dotykov� ovl�danie..."
  );
  M1.NovaPolozka
  ( "Zoznam objedn�vok v re�taur�cii",
    "ZozObj()",
    "Zoznam objedn�vok v re�taur�cii..."
  );
  M1.NovaPolozka
  ( "Zoznam predajn�ch dokladov v re�taur�cii",
    "ZozPre()",
    "Zoznam predajn�ch dokladov v re�taur�cii..."
  );
  M1.NovaPolozka
  ( "Zoznam dokladov na hotelov� ��et v re�taur�cii",
    "ZozHot()",
    "Zoznam dokladov na hotelov� ��et v re�taur�cii..."
  );
  M1.NovaPolozka
  ( "Zoznam rozpracovan�ch objedn�vok v kuchyni",
    "ZozRoz()",
    "Objedn�vky z re�taur�cie do kuchyne a ich aktu�lny stav..."
  );
  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 350);
  M2.NovaPolozka
  ( "Vyhodnotenie a �tatistiky predaja tovaru",
    "InfoTovar()",
    "Vyhodnotenie a �tatistiky predaja tovaru"
  );
  M2.NovaPolozka
  ( "Odp�sanie predan�ho tovaru zo skladu",
    "OdpisSklad()",
    "Odp�sanie predan�ho tovaru zo skladu"
  );
  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 290);
  M4.NovaPolozka
  ( "Parametre programu Re�taur�cia",
    "OtvorUhot141()",
    "Parametre programu Re�taur�cia"
  );
  M4.NovaPolozka
  ( "Obsluha v re�taur�cii",
    "Casnici()",
    "��seln�k pracovn�kov v re�taur�cii"
  );
  M4.NovaPolozka
  ( "��seln�k stolov",
    "Stoly()",
    "��seln�k stolov, predajn�ch miest"
  );
  M4.NovaPolozka
  ( "��seln�k pred�van�ho tovaru",
    "OtvorCcis()",
    "��seln�k pred�van�ch jed�l, n�pojov a tovaru"
  );
  M4.NovaPolozka
  ( "Kateg�rie pred�van�ho tovaru",
    "OtvorKtgt()",
    "��seln�k Kateg�ri� pred�van�ho tovaru"
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
    "Prenos po�iato�n�ho stavu v�roby "
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

  function OtvorUhot141()
  { 
  var okno = window.open("../kuchyna/uhot.php?copern=141","_blank");
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

//[[[[[[[ body rest

  function InfoTovar()
  { 
  var okno = window.open("../restauracia/infotovar.php?copern=30&drupoh=1&page=1&spo=1","_blank",'<?php echo $parwin; ?>');
  }

  function fiskalna()
  { 
  var okno = window.open("../restauracia/fiskalna.php?copern=30&drupoh=1&page=1&spo=1","_blank",'<?php echo $parwin; ?>');
  }

  function Casnici()
  { 
  var okno = window.open("../restauracia/casnici.php?copern=1&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorKtgt()
  { 
  var okno = window.open("../restauracia/ktgtov.php?copern=1&drupoh=1&page=1&spo=0&pds=0&prvespustenie=1","_blank",'<?php echo $parwin; ?>');
  }

  function Stoly()
  { 
  var okno = window.open("../restauracia/stoly.php?copern=1&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function Predaj()
  { 
  var okno = window.open("../restauracia/vstobj.php?copern=1&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function ZozPre()
  { 
  var okno = window.open("../restauracia/vstobj.php?copern=1&drupoh=2&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function ZozHot()
  { 
  var okno = window.open("../ubyt/vstobj.php?copern=1&drupoh=4&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function ZozObj()
  { 
  var okno = window.open("../restauracia/vstobj.php?copern=1&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function Predaj()
  { 
  var okno = window.open("../restauracia/vstobj.php?copern=1&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
  }

  function PredajTouchme()
  { 
  var okno = window.open("../restauracia/resttouchme.php?copern=1&drupoh=1&page=1&spo=0&pds=0&zhs=1","_blank",'<?php echo $parwin; ?>');
  }

  function ZozRoz()
  { 
  var okno = window.open("../kuchyna/rozprac.php?copern=1&drupoh=1","_blank",'<?php echo $parwin; ?>');
  }

  function OtvorCcis()
  { 
  var okno = window.open("../sklad/ccis.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
  }

  function OdpisSklad()
  { 
  var okno = window.open("../restauracia/odpissklad.php?copern=1&drupoh=1&page=1&spo=0&pds=0","_blank",'<?php echo $parwin; ?>');
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

  function novazakazka()
  { 
  var newzaknaz = document.znew.h_nazz.value;

  window.open('../kuchyna/dopzak.php?copern=55&drupoh=1&page=1&newzaknaz=' + newzaknaz + '&zrushladaj=1', '_blank','<?php echo $parwin; ?>' );
  }

    var toprobot = 200;
    var leftrobot = 40;
    var toprobotmenu = 112;
    var leftrobotmenu = 100;
    var widthrobotmenu = 430;

    var htmlmenu = "<table  class='ponuka' width='100%'><FORM name='znew' method='post' action='#' ><tr><td width='90%'>Menu ProRobot</td>" +
    "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../restauracia/vstobj.php?copern=1&drupoh=1&page=1&spo=0&pds=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete zoznam objedn�vok v re�taur�cii ?</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"window.open('../restauracia/vstobj.php?copern=1&drupoh=2&page=1&spo=0&pds=0', '_blank','<?php echo $parwin; ?>' )\">" +
"Chcete zoznam predajn�ch dokladov v re�taur�cii ?</a>";
    htmlmenu += "</td></tr>";



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
<td>EuroSecom  -  Re�taur�cia</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none">
<tr>
<td width="60%" >
<a href='rest.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ��tovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='rest.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena ��tovn�ho obdobia"> ��tovn� obdobie:</a>
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
  function M4KlikNaMenu()  {   progmenu4.style.display='';  }
  function M4ZhasniMenu()  {   progmenu4.style.display='none';  }
  function M5KlikNaMenu()  {   progmenu5.style.display='';  }
  function M5ZhasniMenu()  {   progmenu5.style.display='none';  }
</script>

<?php //OBRAZKOVE MENU ?>


<table class="pmenu" width="100%" style="position:relative; top:3px; border:none; background-color:white;" >
<tr>
<td width='20%' onClick="M1KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/vstupdat.jpg' style='width:98%; height:20;' alt='Vstup d�t' ></a></center>
</td>
<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/informacieavystupy.jpg' style='width:98%; height:20;' alt='Inform�cie a v�stupy' ></a></center>
</td>
<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a slu�by' ></a></center>
</td>
<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/ucto/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='��seln�ky a �dr�ba' ></a></center>
</td>
</tr>
</table>



<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:410; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Vstup d�t</td>
<td width='10%' align='right' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%'  colspan='2' onClick="PredajTouchme();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >TOUCH ME - Predaj a Objedn�vky v Re�taur�cii</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="ZozObj();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Zoznam objedn�vok v re�taur�cii</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="ZozPre();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Zoznam predajn�ch dokladov v re�taur�cii</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="ZozHot();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Zoznam dokladov na hotelov� ��et v re�taur�cii</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="ZozRoz();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Zoznam rozpracovan�ch objedn�vok v kuchyni</a></td></tr>
</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 340; width:410; height:150;">
<table class='pmenu' width='100%'  >
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();' >Menu Inform�cie a v�stupy</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="InfoTovar();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Vyhodnotenie a �tatistiky predaja tovaru</a></td></tr>
<tr><td width='100%' colspan='2' onClick="OdpisSklad();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Odp�sanie predan�ho tovaru zo skladu</a></td></tr>


</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 680; width:250; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();' >Menu Nastavenia a slu�by</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUhot141();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Parametre prog. Re�taur�cia</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="Casnici();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Obsluha v re�taur�cii</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="Stoly();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k stolov</a></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCcis();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k pred�van�ho tovaru</a></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorKtgt();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Kateg�rie pred�van�ho tovaru</a></td></tr>
</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 980; width:230; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();' >Menu ��seln�ky a �dr�ba</td>
<td width='10%' align='right'>
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >�daje o firme</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k I�O</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k stred�sk</a></td></tr>
<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k z�kaziek</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k skup�n</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >��seln�k stavieb</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >E-z�kazn�ci</a></td></tr>
<tr><td width='100%'  colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<a href="#" >Prenos po�.stavu</a></td></tr>
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
<FORM name="fir1" class="obyc" method="post" action="rest.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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

if( $akefirmy == "( xcf >= 0 AND xcf <= 0 )" ) { $setuzfir = include("../cis/vybuzfir.php"); }

$setuzrok = include("../cis/citajrok.php");

$sql = mysql_query("SELECT xcf,naz,rok FROM $mysqldbfir.fir WHERE ( $akefirmy ) AND SUBSTRING(prav,$kli_uzid,1) != 'n' AND rok > $citajrok ORDER BY xcf");
// celkom poloziek
// $cpol = mysql_num_rows($sql);
?>

<span style="position:absolute; top:70; left:10; ">
<table class="fmenu" width="30%" >
<FORM name="fir1" class="obyc" method="post" action="rest.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
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


$akyrobot = include("../akyrobot.php");
$robot3="robot3_rest";
?>

<div id="robotokno" style="cursor: hand; display: none; position: absolute; z-index: 200; top: 200; left: 40; width:60; height:100;">
<img border=0 src='../obr/robot/<?php echo $robot3;?>.jpg' style='' onClick="zobraz_robotmenu();"
 alt='Dobr� de� , ja som V� ProRobot , ak m�te ot�zku alebo nejak� �elanie kliknite na m�a pros�m 1x my�ou' >
<img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick="zhasnirobot();"
 alt='Zhasni EkoRobota' >
</div>
<div id="robotmenu" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 150; left: 90; width:200; height:100;">
zobrazene menu
</div>

<?php

$robot=1;
$absolut=1;
$cislista = include("rest_lista.php");

// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
