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
$sys = 'ANA';
$urov = 3000;
$cslm = 1;

if( $_SESSION['kli_vxcf'] == 9999 ) 
{ echo "Vypnite všetky okná v prehliadaèi IE a prihláste sa znovu prosím do IS, ak ste pouívali Cestovné príkazy"; exit; }

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
$_SESSION['kli_vduj'] = $vyb_duj;

  $kli_vduj=$_SESSION['kli_vduj'];

$dtb2 = include("oddel_dtb2.php");

  mysql_select_db($mysqldbdata);
$vrz = include("verzia.php");

$sql = "SELECT uzid FROM $mysqldbfir.druzis";
$vysledok = mysql_query($sql);
if (!$vysledok):
$kli_vxcf=$vyb_xcf;
$kalend = include("analyzy/vtvana.php");
endif;

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="css/styl.css">
<title>Analızy Hl.menu</title>
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

<?php
$lenan=0;
$dealer=0;

$anaM1c001=1;
$anaM1c002=1;
$anaM1c003=1;
$anaM1c004=1;
$anaM1c005=1;
$anaM1c006=0;
$anaM1ziadne=0;

$anaM2c001=1;
$anaM2c002=1;
$anaM2c003=1;
$anaM2c004=1;
$anaM2c005=1;
$anaM2ziadne=0;

$anaM3c001=1;
$anaM3ziadne=0;

$anaM4c001=1;
$anaM4c006=1;
$anaM4ziadne=0;

$anaM5c001=1;
$anaM5c002=1;
$anaM5c003=1;
$anaM5c004=1;
$anaM5c005=1;
$anaM5c006=1;
$anaM5ziadne=0;


$sqlfir = "SELECT * FROM $mysqldbfir.druzis WHERE uzid=$kli_uzid";
$fir_vysledok = mysql_query($sqlfir);
$cpol = mysql_num_rows($fir_vysledok);
if( $cpol == 1 )
     {
$fir_riadok=mysql_fetch_object($fir_vysledok);

$anaM1c001 = $fir_riadok->anaM1c001;
$anaM1c002 = $fir_riadok->anaM1c002;
$anaM1c003 = $fir_riadok->anaM1c003;
$anaM1c004 = $fir_riadok->anaM1c004;
$anaM1c005 = $fir_riadok->anaM1c005;
$anaM1c006 = $fir_riadok->anaM1c006;


$anaM2c001 = $fir_riadok->anaM2c001;
$anaM2c002 = $fir_riadok->anaM2c002;
$anaM2c003 = $fir_riadok->anaM2c003;
$anaM2c004 = $fir_riadok->anaM2c004;
$anaM2c005 = $fir_riadok->anaM2c005;

$anaM3c001 = $fir_riadok->anaM3c001;

$anaM4c001 = $fir_riadok->anaM4c001;
$anaM4c006 = $fir_riadok->anaM4c006;

$anaM5c001 = $fir_riadok->anaM5c001;
$anaM5c002 = $fir_riadok->anaM5c002;
$anaM5c003 = $fir_riadok->anaM5c003;
$anaM5c004 = $fir_riadok->anaM5c004;
$anaM5c005 = $fir_riadok->anaM5c005;
$anaM5c006 = $fir_riadok->anaM5c006;

$anaM1ziadne=0;
$anaM2ziadne=0;
$anaM3ziadne=0;
$anaM4ziadne=0;
$anaM5ziadne=0;
$lenan = $fir_riadok->lenan;
//cislo dealera
$dealer = $fir_riadok->prmuz1;
//cislo klienta z ktoreho cita saldo
$zdroj = $fir_riadok->prmuz2;
     }
?>

<?php if( $newmenu == 0 ) { ?>

  // PRVE MENU
  var M1 = new CSkryvaneMenu("M1", 350);

<?php if ( $anaM1c001 == 1 ) { ?>
  M1.NovaPolozka
  ( "Odberate¾ské a dodávate¾ské Saldokonto",
    "saldo()",
    "Zoznamy odberate¾skıch a dodávate¾skıch faktúr a úhrad za IÈO, úèet, obdobie...."
  );
<?php                         } ?>

<?php if ( $anaM1c002 == 1 ) { ?>
  M1.NovaPolozka
  ( "Odberatelia - saldokonto za IÈO, úèet",
    "saldoodber()",
    "Zoznamy odberate¾skıch faktúr a úhrad za IÈO, úèet...."
  );
<?php                         } ?>

<?php if ( $anaM1c003 == 1 ) { ?>
  M1.NovaPolozka
  ( "Dodávatelia - saldokonto za IÈO, úèet",
    "saldododav()",
    "Zoznamy dodávate¾skıch faktúr a úhrad za IÈO, úèet...."
  );
<?php                         } ?>

<?php if ( $anaM1c004 == 1 ) { ?>
  M1.NovaPolozka
  ( "Príkazy na úhradu dodávate¾skıch faktúr",
    "priku()",
    "Vytvorenie a prezeranie Príkazov na úhradu dodávate¾skıch faktúr...."
  );
<?php                         } ?>


<?php if ( $anaM1c006 == 1 ) { ?>
  M1.NovaPolozka
  ( "Saldokonto pod¾a DEALEROV",
    "saldodealer()",
    "Zoznamy odberate¾skıch a dodávate¾skıch faktúr a úhrad za IÈO, úèet, obdobie...."
  );
<?php                         } ?>

<?php if ( $anaM1ziadne == 1 ) { ?>
  M1.NovaPolozka
  ( "iadne menu",
    "Nic()",
    "iadne menu"
  );
<?php                         } ?>

  M1.classMenu = "menu2";
  M1.classPolozka = "polozka2";
  M1.classApolozka = "Apolozka2";
  //M1.x=100;// M1.y=100;

  // DRUHE MENU
  var M2 = new CSkryvaneMenu("M2", 340);

<?php if ( $anaM2c001 == 1 ) { ?>
  M2.NovaPolozka
  ( "Vıkaz ziskov a strát Úè POD 2-01 ",
    "vykzis()",
    "Vytvori zostavu Vıkaz ziskov a strát Úè POD 2 - 01 verzia UVPOD2v09_1"
  );
<?php                         } ?>

<?php if ( $anaM2c002 == 1 ) { ?>
  M2.NovaPolozka
  ( "Súvaha Úè POD 1-01 ",
    "suvaha()",
    "Vytvori zostavu Súvaha Úè POD 1 - 01 verzia UVPOD1v09_1"
  );
<?php                         } ?>

<?php if ( $anaM2c003 == 1 ) { ?>
  M2.NovaPolozka
  ( "Vısledovka jednoduchá",
    "vysmala()",
    "Vytvori zostavu Vısledovka jednoduchá"
  );
<?php                         } ?>

<?php if ( $anaM2c004 == 1 ) { ?>
  M2.NovaPolozka
  ( "Súvaha jednoduchá",
    "suvmala()",
    "Vytvori zostavu Súvaha jednoduchá"
  );
<?php                         } ?>

<?php if ( $anaM2c005 == 1 ) { ?>
  M2.NovaPolozka
  ( "Analızy zákaziek",
    "zakanalyza()",
    "Analızy zákaziek"
  );
  M2.NovaPolozka
  ( "Analızy stredísk, skupín a stavieb",
    "stranalyza()",
    "Analızy stredísk, skupín a stavieb"
  );
  M2.NovaPolozka
  ( "Analızy trieb a predajní",
    "predajanalyza()",
    "Analızy trieb a predajní"
  );
<?php                         } ?>


<?php if ( $anaM2ziadne == 1 ) { ?>
  M2.NovaPolozka
  ( "iadne menu",
    "Nic()",
    "iadne menu"
  );
<?php                         } ?>

  M2.classMenu = "menu2";
  M2.classPolozka = "polozka2";
  M2.classApolozka = "Apolozka2";

  // TRETIE MENU
  var M3 = new CSkryvaneMenu("M3", 370);

<?php if ( $anaM3c001 == 1 ) { ?>
  M3.NovaPolozka
  ( "Údaje o zamestnancoch",
    "personal()",
    "Údaje o zamestnancoch"
  );
<?php                         } ?>

<?php if ( $anaM3ziadne == 1 ) { ?>
  M3.NovaPolozka
  ( "iadne menu",
    "Nic()",
    "iadne menu"
  );
<?php                         } ?>

  M3.classMenu = "menu2";
  M3.classPolozka = "polozka2";
  M3.classApolozka = "Apolozka2";

  // STVRTE MENU
  var M4 = new CSkryvaneMenu("M4", 280);

<?php if ( $anaM4c001 == 1 ) { ?>
  M4.NovaPolozka
  ( "Parametre programu Analızy",
    "OtvorUfir197()",
    "Parametre programu Analızy"
  );
<?php                         } ?>

<?php if ( $anaM4c006 == 1 ) { ?>
  M4.NovaPolozka
  ( "Export údajov do CSV",
    "ExportCSV()",
    "Export údajov do CSV pre spracovanie v programe Excel..."
  );
<?php                         } ?>

<?php if ( $anaM4ziadne == 1 ) { ?>
  M3.NovaPolozka
  ( "iadne menu",
    "Nic()",
    "iadne menu"
  );
<?php                         } ?>

  M4.classMenu = "menu2";
  M4.classPolozka = "polozka2";
  M4.classApolozka = "Apolozka2";
//  M4.x=605;// M1.y=100;

  // PIATE MENU
  var M5 = new CSkryvaneMenu("M5", 150);

<?php if ( $anaM5c001 == 1 ) { ?>
  M5.NovaPolozka
  ( "Údaje o firme",
    "OtvorUfir1()",
    "Údaje o firme"
  );
<?php                         } ?>

<?php if ( $anaM5c002 == 1 ) { ?>
  M5.NovaPolozka
  ( "Èíselník IÈO",
    "OtvorCico()",
    "Èíselník"
  );
<?php                         } ?>

<?php if ( $anaM5c003 == 1 ) { ?>
  M5.NovaPolozka
  ( "Èíselník stredísk",
    "OtvorCstr()",
    "Èíselník"
  );
<?php                         } ?>

<?php if ( $anaM5c004 == 1 ) { ?>
  M5.NovaPolozka
  ( "Èíselník zákaziek",
    "OtvorCzak()",
    "Èíselník"
  );
<?php                         } ?>

<?php if ( $anaM5c005 == 1 ) { ?>
  M5.NovaPolozka
  ( "Èíselník skupín",
    "OtvorCsku()",
    "Èíselník skupn"
  );
<?php                         } ?>

<?php if ( $anaM5c006 == 1 ) { ?>
  M5.NovaPolozka
  ( "Èíselník stavieb",
    "OtvorCsta()",
    "Èíselník stavieb"
  );
<?php                         } ?>

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


  function OtvorUfir1()
  { 
<?php if ( $anaM5c001 == 1 ) { ?>
  var okno = window.open("../cis/ufir.php?copern=1","_blank");
<?php                        } ?>
  }

  function OtvorCico()
  { 
<?php if ( $anaM5c002 == 1 ) { ?>
  var okno = window.open("../cis/cico.php?copern=1&page=1","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }

  function OtvorCstr()
  { 
<?php if ( $anaM5c003 == 1 ) { ?>
  var okno = window.open("../cis/cstr.php?copern=1&page=1","_blank");
<?php                        } ?>
  }

  function OtvorCzak()
  { 
<?php if ( $anaM5c004 == 1 ) { ?>
  var okno = window.open("../cis/czak.php?copern=1&page=1","_blank");
<?php                        } ?>
  }

  function OtvorCsku()
  { 
<?php if ( $anaM5c005 == 1 ) { ?>
  var okno = window.open("../cis/csku.php?copern=1&page=1","_blank");
<?php                        } ?>
  }


  function OtvorCsta()
  { 
<?php if ( $anaM5c006 == 1 ) { ?>
  var okno = window.open("../cis/csta.php?copern=1&page=1","_blank");
<?php                        } ?>
  }





  function OtvorUfir197()
  { 
<?php if ( $anaM4c001 == 1 ) { ?>
  var okno = window.open("../cis/ufir.php?copern=197","_blank");
<?php                        } ?>
  }

  function ExportCSV()
  { 
<?php if ( $anaM4c006 == 1 ) { ?>
  var okno = window.open("../analyzy/export_csv.php?copern=1&analyzy=1","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }



//[[[[[[[ body analzyz

  function Nic()
  { 

  }

  function saldo()
  { 
<?php if ( $anaM1c001 == 1 ) { ?>
  var okno = window.open("../ucto/saldo.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=0&analyzy=1","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }

  function saldoodber()
  { 
<?php if ( $anaM1c002 == 1 ) { ?>
  var okno = window.open("../analyzy/saldo_analyzy.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=0&analyzy=1","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }

  function saldododav()
  { 
<?php if ( $anaM1c003 == 1 ) { ?>
  var okno = window.open("../analyzy/saldo_analyzy.php?copern=1&drupoh=2&page=1&sysx=UCT&typhtml=0&analyzy=1","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }

  function priku()
  { 
<?php if ( $anaM1c004 == 1 ) { ?>
  var okno = window.open("../ucto/vstpru.php?copern=1&drupoh=1&page=1&sysx=UCT","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }



  function saldodealer()
  { 
<?php if ( $anaM1c006 == 1 ) { ?>
  var okno = window.open("../analyzy/saldo_dealer.php?copern=1&drupoh=1&page=1&sysx=UCT&typhtml=0&analyzy=1&somdealer=<?php echo $dealer; ?>","_blank",'<?php echo $parwin; ?>');
<?php                        } ?>
  }


  function vykzis()
  { 
<?php if ( $anaM2c001 == 1 ) { ?>
  var okno = window.open("../ucto/vykzis__x.php?copern=10&drupoh=1&page=1&tis=0&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function suvaha()
  { 
<?php if ( $anaM2c002 == 1 ) { ?>
  var okno = window.open("../ucto/suvaha__x.php?copern=10&drupoh=1&page=1&tis=0&vyb_ume=<?php echo $kli_vume; ?>&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function vysmala()
  { 
<?php if ( $anaM2c003 == 1 ) { ?>
  var okno = window.open("../ucto/vys_mala.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function suvmala()
  { 
<?php if ( $anaM2c004 == 1 ) { ?>
  var okno = window.open("../ucto/suv_mala.php?copern=10&drupoh=1&page=1&typ=PDF&vyb_ume=<?php echo $kli_vume; ?>&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function zakanalyza()
  { 
<?php if ( $anaM2c004 == 1 ) { ?>
  var okno = window.open("../analyzy/zakazky_analyzy.php?copern=1&drupoh=1&page=1&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function stranalyza()
  { 
<?php if ( $anaM2c004 == 1 ) { ?>
  var okno = window.open("../analyzy/str_analyzy.php?copern=1&drupoh=1&page=1&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function predajanalyza()
  { 
<?php if ( $anaM2c004 == 1 ) { ?>
  var okno = window.open("../eshop/infotovar.php?copern=1&drupoh=1&page=1&zmtz=1&html=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function personal()
  { 
<?php if ( $anaM3c001 == 1 ) { ?>
  var okno = window.open("../analyzy/personal_analyzy.php?copern=1&drupoh=1&page=1&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
<?php                        } ?>
  }

  function Grafy()
  { 
  var okno = window.open("../analyzy/grafy.php?copern=1&drupoh=1&page=1&analyzy=1","_blank",'<?php echo $tlcswin; ?>');
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
    var toprobotmenu = 180;
    var leftrobotmenu = 100;
    var widthrobotmenu = 400;

    var htmlmenu = "<table  class='ponuka' width='100%'><tr><td width='90%'>Menu EkoRobot</td>" +
    "<td width='10%' align='right'><img border=0 src='../obr/zmazuplne.png' style='width:10; height:10;' onClick='zhasni_menurobot();' alt='Zhasni menu' ></td></tr>";  

<?php if ( $anaM1c001 == 1 ) { ?>
    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"saldo();\">" +
"Chcete Odberate¾ské a dodávate¾ské Saldokonto ?</a>";
    htmlmenu += "</td></tr>";
<?php                        } ?>

    htmlmenu += "<tr><td width='100%' class='ponuka' colspan='2'>"; 
htmlmenu += "<a href=\"#\" onClick=\"Grafy();\">" +
"Grafické analızy a Finanèné ukazovatele</a>";
    htmlmenu += "</td></tr>";

    htmlmenu += "</table>";  

</script>
</HEAD>
<BODY class="white" <?php if( $copern != 22 AND $copern != 23 AND $copern != 24 AND $dealer == 0 ) { echo "onload='ukazrobot();'"; } ?> >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  Finanèné analızy
</td>
<td align="right"><span class="login"><?php echo "login: $kli_uzmeno $kli_uzprie / $kli_uzid  ";?></span></td>
</tr>
</table>

<table class="pmenu" width="100%" style="border:none">
<tr>
<td width="60%" >
<a href='analyzy.php?copern=22&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena úètovnej jednotky"> Firma</a>
<?php echo "$vyb_xcf";?> <?php echo "$vyb_naz";?>
</td>
<td width="40%" >
<a href='analyzy.php?copern=24&newmenu=<?php echo "$newmenu";?>'><img src='../obr/uprav.png' width=15 height=10 border=0 alt="Zmena úètovného obdobia"> Úètovné obdobie:</a>
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
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/odberdodav.jpg' style='width:98%; height:20;' alt='Vstup dát' ></a></center></td>

<td width='20%' onClick="M2KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/financieazisk.jpg' style='width:98%; height:20;' alt='Mesaèné spracovanie' ></a></center></td>

<td width='20%' onClick="M3KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/pracovnesily.jpg' style='width:98%; height:20;' alt='Informácie a vıstupy' ></a></center></td>

<td width='20%' onClick="M4KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/nastaveniaasluzby.jpg' style='width:98%; height:20;' alt='Nastavenia a sluby' ></a></center></td>

<td width='20%' onClick="M5KlikNaMenu();" >
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/ciselnikyaudrzba.jpg' style='width:98%; height:20;' alt='Èíselníky a údrba' ></a></center></td>

</tr>
</table>

<div id="progmenu1" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 20; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M1ZhasniMenu();'>Menu Odberatelia/Dodávatelia</td>
<td width='10%' align='right' onClick='M1ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M1ZhasniMenu();' alt='Zhasni menu' ></td></tr>  
<?php if ( $anaM1c001 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="saldo();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s1-r1.jpg' style='width:98%; height:20;' alt='Odberate¾ské a dodávate¾ské Saldokonto' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM1c002 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="saldoodber();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s1-r2.jpg' style='width:98%; height:20;' alt='Odberatelia - saldokonto za IÈO, úèet' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM1c003 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="saldododav();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s1-r3.jpg' style='width:98%; height:20;' alt='Dodávatelia - saldokonto za IÈO, úèet' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM1c004 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="priku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s1-r4.jpg' style='width:98%; height:20;' alt='Príkazy na úhradu dodávate¾skıch faktúr' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM1c006 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="saldodealer();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s1-r5.jpg' style='width:98%; height:20;' alt='Saldokonto pod¾a dealerov' ></a></center></td></tr>
<?php                         } ?>
</FORM>
</table>
</div>

<div id="progmenu2" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 300; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M2ZhasniMenu();'>Menu Financie a zisk</td>
<td width='10%' align='right' onClick='M2ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M2ZhasniMenu();' alt='Zhasni menu' ></td></tr>  
<?php if ( $anaM2c001 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="vykzis();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r1.jpg' style='width:98%; height:20;' alt='Vıkaz ziskov a strát Úè POD 2-01' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM2c002 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="suvaha();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r2.jpg' style='width:98%; height:20;' alt='Súvaha Úè POD 1-01' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM2c003 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="vysmala();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r3.jpg' style='width:98%; height:20;' alt='Vısledovka jednoduchá' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM2c004 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="suvmala();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r4.jpg' style='width:98%; height:20;' alt='Súvaha jednoduchá' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM2c005 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="zakanalyza();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r5.jpg' style='width:98%; height:20;' alt='Analızy zákaziek' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="stranalyza();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r6.jpg' style='width:98%; height:20;' alt='Analızy stredísk' ></a></center></td></tr>
<tr><td width='100%' colspan='2' onClick="predajanalyza();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s2-r7.jpg' style='width:98%; height:20;' alt='Analızy trieb a predajní' ></a></center></td></tr>
<?php                         } ?>


</FORM>
</table>
</div>


<div id="progmenu3" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 470; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M3ZhasniMenu();'>Menu Pracovné sily</td>
<td width='10%' align='right' onClick='M3ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M3ZhasniMenu();' alt='Zhasni menu' ></td></tr>  
<?php if ( $anaM3c001 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="personal();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s3-r1.jpg' style='width:98%; height:20;' alt='Údaje o zamestnancoch' ></a></center></td></tr>
<?php                         } ?>

</FORM>
</table>
</div>

<div id="progmenu4" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 740; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M4ZhasniMenu();'>Menu Nastavenia a sluby</td>
<td width='10%' align='right' onClick='M4ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M4ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<?php if ( $anaM4c001 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="OtvorUfir197();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s4-r1.jpg' style='width:98%; height:20;' alt='Parametre programu Analızy' ></a></center></td></tr>
<?php                         } ?>
<?php if ( $anaM4c006 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="ExportCSV();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s4-r2.jpg' style='width:98%; height:20;' alt='Export údajov do CSV' ></a></center></td></tr>
<?php                         } ?>

</FORM>
</table>
</div>

<div id="progmenu5" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 80; left: 900; width:300; height:150;">
<table class='pmenu' width='100%'>
<FORM name='znew' method='post' action='#' >
<tr><td width='90%' onClick='M5ZhasniMenu();'>Menu Èíselníky a údrba</td>
<td width='10%' align='right' onClick='M5ZhasniMenu();'>
<img border=0 src='../obr/zmazuplne.png' style='width:15; height:15;' onClick='M5ZhasniMenu();' alt='Zhasni menu' ></td></tr>  

<?php if ( $anaM5c001 == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="OtvorUfir1();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r1.jpg' style='width:98%; height:20;' alt='Údaje o firme' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCico();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r2.jpg' style='width:98%; height:20;' alt='Èíselník IÈO' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCstr();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r3.jpg' style='width:98%; height:20;' alt='Èíselník stredísk' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCzak();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r4.jpg' style='width:98%; height:20;' alt='Èíselník zákaziek' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsku();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r5.jpg' style='width:98%; height:20;' alt='Èíselník skupín' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="OtvorCsta();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r6.jpg' style='width:98%; height:20;' alt='Èíselník stavieb' ></a></center></td></tr>

<tr><td width='100%' colspan='2' onClick="Ezakaznik();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r7.jpg' style='width:98%; height:20;' alt='E-zákazníci' ></a></center></td></tr>

<?php if( $dajpoc == 1 ) { ?>
<tr><td width='100%' colspan='2' onClick="PrenosPoc();" onmouseover="MZvyrazni(this);" onmouseout="MNeZvyrazni(this);">
<center><a href="#" ><img border=0 src='../obr/menutexty/analyzy/s5-r8.jpg' style='width:98%; height:20;' alt='Prenos poè.stavu' ></a></center></td></tr>
<?php                    } ?>

<?php                         } ?>

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
<td width="20%" ><center>Odber/Dodáv</center></td>
</span>

<span  onclick="M2.Klepnuti(); return false;  ">
<td width="20%" ><center>Financie a zisk</center></td>
</span>

<span  onclick="M3.Klepnuti(); return false;  ">
<td width="20%" ><center>Pracovné sily</center></td>
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
<FORM name="fir1" class="obyc" method="post" action="analyzy.php?copern=25&newmenu=<?php echo "$newmenu";?>" >
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
<FORM name="fir1" class="obyc" method="post" action="analyzy.php?copern=23&newmenu=<?php echo "$newmenu";?>" >
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
$zmenume=1; $odkaz="../analyzy.php?copern=1&newmenu=$newmenu";
if( $dealer == 0 ) { $cislista = include("analyzy/ana_lista.php"); }



// celkovy koniec dokumentu
       } while (false);
?>

</BODY>
</HTML>
