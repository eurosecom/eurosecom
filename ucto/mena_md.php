<HTML>
<?php
$sys = 'UCT';
$urov = 1000;
//$cslm=320;
$cslm=103400;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;
if(!isset($kli_vduj)) $kli_vduj = 1;

       do
       {

// cislo operacie
$copern = 1*$_REQUEST['copern'];
$drupoh = 1*$_REQUEST['drupoh'];

require_once("../pswd/password.php");
@$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$citfir = include("../cis/citaj_fir.php");
$mena1 = $fir_mena1;
$mena2 = $fir_mena2;
$kurz12 = $fir_kurz12;

$rozuct = $_REQUEST['rozuct'];
if(!isset($rozuct)) $rozuct = 'NIE';
$sysx = $_REQUEST['sysx'];
if(!isset($sysx)) $sysx = 'INE';
if( $sysx == 'UCT' ) $rozuct="ANO";


//tlacove okno
$tlcuwin="width=700, height=' + vyskawin + ', top=0, left=200, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$tlcswin="width=980, height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=yes, toolbar=yes";
$uliscwin="width=' + sirkawin + ', height=' + vyskawin + ', top=0, left=20, status=yes, resizable=yes, scrollbars=yes, menubar=no, toolbar=no";

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

//import z ../import/FIR$kli_vxcf/CUDZIE.CSV
    if ( $copern == 55 )
    {

//Tabulka uctpokuct
$sql = "SELECT * FROM F$kli_vxcf"."_uctcudzieold";
$vysledok = mysql_query("$sql");
if (!$vysledok)
{
echo "Vytvorit tabulku F$kli_vxcf"."_uctcudzieold!"."<br />";

$sqlt = <<<uctpokuct
(
   cpl         int not null auto_increment,
   ume         DECIMAL(7,4) DEFAULT 0,
   dat         DATE NOT NULL,
   dok         DECIMAL(10,0) DEFAULT 0,
   muc         VARCHAR(10) NOT NULL,
   duc         VARCHAR(10) NOT NULL,
   ico         DECIMAL(10,0) DEFAULT 0,
   fak         DECIMAL(10,0) DEFAULT 0,
   hoz         DECIMAL(10,2) DEFAULT 0,
   hod         DECIMAL(10,2) DEFAULT 0,
   val         VARCHAR(4) NOT NULL,
   kur         DECIMAL(10,4) DEFAULT 0,
   kuj         DECIMAL(10,0) DEFAULT 0,
   PRIMARY KEY(cpl)
);
uctpokuct;

$sql = 'CREATE TABLE F'.$kli_vxcf.'_uctcudzieold'.$sqlt;
$vysledek = mysql_query("$sql");
}


?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru ../import/FIR<?php echo $kli_vxcf; ?>/CUDZIE.CSV ?") )
         { window.close()  }
else
         { location.href='cudzie.php?copern=56&page=1&drupoh=<?php echo $drupoh;?>'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=1;

if( file_exists("../import/FIR$kli_vxcf/CUDZIE.CSV")) echo "S˙bor ../import/FIR$kli_vxcf/CUDZIE.CSV existuje<br />";

$subor = fopen("../import/FIR$kli_vxcf/CUDZIE.CSV", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 500);
  print "$riadok<br />";
  $pole = explode(";", $riadok);

  $x_ume = $pole[0];
  $x_dat= $pole[1];
  $x_dok = $pole[2];
  $x_muc = $pole[3];
  $x_duc = $pole[4];
  $x_ico = $pole[5];
  $x_fak = $pole[6];
  $x_hoz = $pole[7];
  $x_hod = $pole[8];
  $x_val = $pole[9];
  $x_kur = $pole[10];
  $x_kuj = $pole[11];
  $x_kon = $pole[12];
 

$c_hod=1*$x_hod;
$c_hoz=1*$x_hoz;
$sql_dat=SqlDatum($x_dat);

if( $c_hod != 0 OR $c_hoz != 0)
{
$sqult = "INSERT INTO F$kli_vxcf"."_uctcudzieold ( ume,dat,dok,muc,duc,ico,fak,hoz,hod,val,kur,kuj )".
" VALUES ( '$x_ume', '$sql_dat', '$x_dok', '$x_muc', '$x_duc', '$x_ico', '$x_fak', '$x_hoz', '$x_hod', '$x_val', '$x_kur', '$x_kuj' ); "; 

//echo $sqult;

$ulozene = mysql_query("$sqult"); 
}

  }

echo "Tabulka F$kli_vxcf"."_uctcudzieold !"." naimportovan· <br />";

fclose ($subor);
$copern=1;
    }
//koniec nacitania pohybov



//vymazanie vsetkych poloziek
    if ( $copern == 67 )
    {
?>
<script type="text/javascript">
if( !confirm ("Chcete vymazaù vöetky poloûky \r cudzej meny OLD ?") )
         { window.close()  }
else
         { location.href='cudzie.php?copern=167&page=1&drupoh=<?php echo $drupoh;?>'  }
</script>
<?php
    }
    if ( $copern == 167 )
    {
$copern=1;
$sqlt = 'TRUNCATE F'.$kli_vxcf.'_uctcudzieold';
$vysledok = mysql_query("$sqlt");
echo $sqlt;
if ($vysledok)
echo "Tabulka F$kli_vxcf"."_uctcudzieold!"." vynulovan· <br />";
    }


?> 

<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Cudzie meny</title>
  <style type="text/css">

  </style>
<script type="text/javascript">
//sirka a vyska okna
var sirkawin = screen.width-80;
var vyskawin = screen.height-175;
var vyskawic = screen.height;
var sirkawic = screen.width-10;

function TlacPohyby()
                {
var h_uce = document.forms.formp1.h_uce.value;

window.open('../ucto/zoscudz.php?copern=10&drupoh=1&page=1&cislo_cuce=' + h_uce + '&typ=PDF',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravPohyby()
                {
var h_uce = document.forms.formp1.h_uce.value;

window.open('../ucto/zoscudz.php?copern=10&drupoh=1&page=1&cislo_cuce=' + h_uce + '&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function TlacSaldo()
                {
var h_uce = document.forms.formp2.h_uce.value;
var h_ake = document.forms.formp2.h_ake.value;
var h_nakurz = document.forms.formp2.h_nakurz.value;
  var h_prep = 0;
  if( document.formp2.h_prep.checked ) h_prep=1;

window.open('../ucto/zoscudz.php?copern=11&drupoh=1&page=1&cislo_ico=0&cislo_cuce=' + h_uce + '&h_ake=' + h_ake + '&h_prep=' + h_prep + '&h_nakurz=' + h_nakurz + '&typ=PDF',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }

function UpravSaldo()
                {
var h_uce = document.forms.formp2.h_uce.value;
var h_ake = document.forms.formp2.h_ake.value;
var h_nakurz = document.forms.formp2.h_nakurz.value;
  var h_prep = 0;
  if( document.formp2.h_prep.checked ) h_prep=1;

window.open('../ucto/zoscudz.php?copern=11&drupoh=1&page=1&cislo_ico=0&cislo_cuce=' + h_uce + '&h_ake=' + h_ake + '&h_prep=' + h_prep + '&h_nakurz=' + h_nakurz + '&typ=HTML',
 '_blank', 'width=1080, height=900, top=0, left=10, status=yes, resizable=yes, scrollbars=yes' );
                }


</script>
</HEAD>
<BODY class="white" >




<?php
if( $copern == 1  )
           {
?>
<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  FinanËnÈ ˙ËtovnÌctvo - ⁄Ëty vedenÈ v cudzej mene</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<table class="vstup" width="100%" >
<FORM name="formp1" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravPohyby();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava pohybov na ˙Ëte' ></a>
</td>
<td class="bmenu" width="98%">
<a href="#" onClick="UpravPohyby();">Pohyby a zostatok na ˙Ëte</a>
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctcudz WHERE cuce > 0 ORDER BY cuce");
?>
<select size="1" name="h_uce" id="h_uce" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["cuce"];?>" >
<?php echo $zaznam["cuce"];?> <?php echo $zaznam["cume"];?></option>
<?php endwhile;?>
</select>
<a href="#" onClick="TlacPohyby();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<FORM name="formp2" class="obyc" method="post" action="#" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="UpravSaldo();">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava dokladov' ></a>
</td>
<td class="bmenu" width="58%">
<a href="#" onClick="UpravSaldo();">Saldokonto v cudzej mene</a>
<?php
$sql = mysql_query("SELECT * FROM F$kli_vxcf"."_uctcudz WHERE cuce > 0 AND LEFT(cuce,1) = 3 ORDER BY cuce");
?>
<select size="1" name="h_uce" id="h_uce" >
<?php while($zaznam=mysql_fetch_array($sql)):?>
<option value="<?php echo $zaznam["cuce"];?>" >
<?php echo $zaznam["cuce"];?> <?php echo $zaznam["cume"];?></option>
<?php endwhile;?>
</select>

<select size="1" name="h_ake" id="h_ake" >
<option value="0" >vöetky poloûky</option>
<option value="1" >nesp·rovanÈ poloûky</option>
</select>

<a href="#" onClick="TlacSaldo();">
<img src='../obr/tlac.png' width=20 height=15 border=0 title='VytlaËiù vo form·te PDF' ></a>
</td>
<td class="bmenu" width="40%">
PrepoËet <input type="checkbox" name="h_prep" value="1" /> 
 na kurz  <input type="text" name="h_nakurz" id="h_nakurz" size="10" value="" />
</td>


</tr>
</FORM>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/kurzy.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $uliscwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zobrazenie a ˙prava kurzovÈho lÌstka' ></a>
</td>
<td class="bmenu" width="90%">
<a href="#" onClick="window.open('../ucto/kurzy.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $uliscwin; ?>' )">
Kurzov˝ lÌstok</a>
</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/uctcudz.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $uliscwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zoznam ˙Ëtov veden˝ch v cudzej mene' ></a>
</td>
<td class="bmenu" width="90%">
<a href="#" onClick="window.open('../ucto/uctcudz.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $uliscwin; ?>' )">
Zoznam ˙Ëtov veden˝ch v cudzej mene</a>
</td>
</tr>
</table>


<table class="vstup" width="100%" >
<tr>
<td class="bmenu" width="2%">
<a href="#" onClick="window.open('../ucto/cismeny.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $uliscwin; ?>' )">
<img src='../obr/zoznam.png' width=20 height=15 border=0 title='Zoznam cudzÌch mien pouûÌvan˝ch v programe' ></a>
</td>
<td class="bmenu" width="90%">
<a href="#" onClick="window.open('../ucto/cismeny.php?copern=1&drupoh=1&page=1', '_blank','<?php echo $uliscwin; ?>' )">
Zoznam cudzÌch mien pouûÌvan˝ch v programe</a>
</td>

<?php
if ( $kli_uzall > 90000 )
  {
?>
<td class="bmenu" width="10%">
<a href='cudzie.php?copern=67&page=1&drupoh=<?php echo $drupoh;?>'>
<img src='../obr/kos.png' width=20 height=15 border=0 title="Vymazanie vöetk˝ch poloûiek pohybov v cudzej mene OLD"></a>
 <a href='cudzie.php?copern=55&page=1&drupoh=<?php echo $drupoh;?>'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Import ˙dajov z TXT pohybov v cudzej mene OLD"></a>
</tr>
<?php
  }
?>


</tr>
</table>


<?php
           }
?>





<br /><br />
<?php
// celkovy koniec dokumentu

$zmenume=1; $odkaz="../ucto/cudzie.php?copern=1&drupoh=1&page=1&sysx=UCT";
$cislista = include("uct_lista.php");

       } while (false);
?>
</BODY>
</HTML>
