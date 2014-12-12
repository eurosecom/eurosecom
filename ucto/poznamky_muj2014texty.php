<HTML>
<?php

// celkovy zaciatok dokkurztu
       do
       {
$sys = 'UCT';
$urov = 2000;
$clsm = 960;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

if(!isset($kli_vxcf)) $kli_vxcf = 1;

  require_once("../pswd/password.php");
  @$spojeni = mysql_connect($mysqlhost, $mysqluser, $mysqlpasswd);
  if (!$spojeni):
    echo "Spojenie so serverom nedostupne.";
    exit;
  endif;
  mysql_select_db($mysqldb);

$pole = explode(".", $kli_vume);
$kli_vmes=$pole[0];
$kli_vrok=$pole[1];

$sql = "ALTER TABLE F$kli_vxcf"."_poznamky_muj2014texty MODIFY ozntxt VARCHAR(10) PRIMARY KEY not null ";
$vysledek = mysql_query("$sql");

//datumove funkcie
$sDat = include("../funkcie/dat_sk_us.php");

$citfir = include("../cis/citaj_fir.php");

// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);
$drupoh = 1*strip_tags($_REQUEST['drupoh']);
$h_ozntxt = $_REQUEST['h_ozntxt'];
$uloz="NO";
$zmaz="NO";
$uprav="NO";


$ulozenx="";

$bralsomjedentext=0;
//zober jeden text z inej firmy len z novej a nahradi existujuci text
if ( $copern == 4055 )
     {
$bralsomjedentext=1;
$h_ozntxt = strip_tags($_REQUEST['h_ozntxt']);
$firmax = strip_tags($_REQUEST['firmax']);
$oznacx = strip_tags($_REQUEST['oznacx']);

$kli_vrokxy=$kli_vrok;
$firmaneex=1;
$sqlfir = "SELECT * FROM fir WHERE xcf = $firmax ";
$fir_vysledok = mysql_query($sqlfir);
$kolkofir = 1*mysql_num_rows($fir_vysledok);
if( $kolkofir == 1 ) { $firmaneex=0; }
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $kli_vrokxy = 1*$fir_riadok->rok;  }

if( $firmaneex == 1 ) { echo "Zadana firma cislo ".$firmax." neexistuje v ciselniku firiem."; exit; }

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$kli_vrokxy;
$dtb2 = include("../cis/oddel_dtbz2.php");
$kli_vrok=$kli_vrokx;

$ulozttt = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014texty ( ozntxt, hdntxt ) VALUES ('$h_ozntxt', '' ) "; 
$ulozene = mysql_query("$ulozttt"); 

$nerob=1;

if( $nerob == 0 )
  {
$sqlfir = "SELECT * FROM ".$databaza."F$firmax"."_poznamky_muj2014texty WHERE ozntxt='$oznacx' ";
//echo $sqlfir; 
$fir_vysledok = mysql_query($sqlfir);
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); 
$h_hdntxtplus = str_replace("\r\n","###rn###",$fir_riadok->hdntxt); $h_hdntxtplusx=str_replace("\r","###r###",$h_hdntxtplus); }

$ulozttt = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty SET hdntxt='".$h_hdntxtplusx."' WHERE ozntxt='$h_ozntxt' "; 
$ulozene = mysql_query("$ulozttt"); 

echo $ulozttt;

$sqult = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty SET hdntxt=REPLACE(hdntxt,'###rn###','\r\n') WHERE ozntxt='$h_ozntxt' ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty SET hdntxt=REPLACE(hdntxt,'###r###','\r') WHERE ozntxt='$h_ozntxt' ";
$ulozene = mysql_query("$sqult"); 
  }

$ulozttt = "DROP TABLE F$kli_vxcf"."_poznamky_muj2014textyxxx "; 
$ulozene = mysql_query("$ulozttt"); 
$ulozttt = "CREATE TABLE F$kli_vxcf"."_poznamky_muj2014textyxxx SELECT * FROM ".$databaza."F$firmax"."_poznamky_muj2014texty WHERE  ozntxt='$oznacx' "; 
$ulozene = mysql_query("$ulozttt"); 


$ulozttt = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty,F$kli_vxcf"."_poznamky_muj2014textyxxx SET ".
" F$kli_vxcf"."_poznamky_muj2014texty.hdntxt=F$kli_vxcf"."_poznamky_muj2014textyxxx.hdntxt ".
" WHERE F$kli_vxcf"."_poznamky_muj2014texty.ozntxt='$h_ozntxt' "; 
$ulozene = mysql_query("$ulozttt"); 

$ulozttt = "DROP TABLE F$kli_vxcf"."_poznamky_muj2014textyxxx "; 
$ulozene = mysql_query("$ulozttt"); 

$copern=1;
$ulozenx="Text uloûen˝";
    }
//koniec zober jeden text z inej firmy

//ulozenie
if ( $copern == 116 )
     {

$h_hdntxt = strip_tags($_REQUEST['h_hdntxt']);

$ulozttt = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014texty ( ozntxt, hdntxt ) VALUES ('$h_ozntxt', '$h_hdntxt' ) "; 
//echo $ulozttt;
$ulozene = mysql_query("$ulozttt"); 

$ulozttt = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty SET hdntxt='$h_hdntxt' WHERE ozntxt='$h_ozntxt' "; 
$ulozene = mysql_query("$ulozttt"); 
//echo $ulozttt;
$copern=1;
$ulozenx="Text uloûen˝";
    }
//koniec ulozenia


//import z ../import/FIR$kli_vxcf/POZNAMKYMUJ.CSV
    if ( $copern == 55 )
    {
$odkial="../import/FIR".$kli_vxcf."/POZNAMKYMUJ".$kli_vrok.".CSV";
$firxyz = 1*strip_tags($_REQUEST['firx']);
if( $firxyz == 9999 ) { $odkial="../import/POZNAMKYMUJ".$kli_vrok.".CSV"; }

?>
<script type="text/javascript">
if( !confirm ("Chcete importovaù poloûky \r zo s˙boru <?php echo $odkial; ?> ? \r POZOR!!! Pred importom bud˙ terajöie pozn·mky v tejto firme vymazanÈ .") )
         { window.close()  }
else
         { location.href='poznamky_muj2014texty.php?copern=56&page=1&firx=<?php echo $firxyz; ?>'  }
</script>
<?php
    }
    if ( $copern == 56 )
    {
$copern=20;

$odkial="../import/FIR".$kli_vxcf."/POZNAMKYMUJ".$kli_vrok.".CSV";
$firxyz = 1*strip_tags($_REQUEST['firx']);
if( $firxyz == 9999 ) { $odkial="../import/POZNAMKYMUJ".$kli_vrok.".CSV"; }

if( file_exists("$odkial")) 
{
echo "S˙bor $odkial existuje<br />";
$sqult = "TRUNCATE TABLE F$kli_vxcf"."_poznamky_muj2014texty ";
$ulozene = mysql_query("$sqult"); 
}

$subor = fopen("$odkial", "r");
while (! feof($subor))
  {
  $riadok = fgets($subor, 1120);
  //print "$riadok<br />";
  $pole = explode(";", $riadok);


  $h_ozntxt = $pole[0];
  $h_hdntxt = $pole[1];


$sqult = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014texty ( ozntxt, hdntxt ) VALUES ('$h_ozntxt', '$h_hdntxt' ) ";
//echo $sqult;

$ulozene = mysql_query("$sqult"); 


  }

echo "Tabulka F$kli_vxcf"."_poznamky_muj2014texty!"." naimportovan· <br />";
echo "Zatvorte toto okno aj okno ˙prav Pozn·mok k ˙Ëtovnej z·vierke. Po op‰tovnom otvorenÌ ˙prav Pozn·mok k ˙Ëtovnej z·vierke bud˙ texty naËÌtanÈ. <br />";

fclose ($subor);

$sqult = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty SET hdntxt=REPLACE(hdntxt,'###rn###','\r\n') ";
$ulozene = mysql_query("$sqult"); 
$sqult = "UPDATE F$kli_vxcf"."_poznamky_muj2014texty SET hdntxt=REPLACE(hdntxt,'###r###','\r') ";
$ulozene = mysql_query("$sqult"); 

exit;
    }
//koniec nacitania poznamok


//exportuj poznamky
if ( $copern == 655 )
    {
$nazsub="POZNAMKYMUJ".$kli_vrok;


if (File_Exists ("../tmp/$nazsub.CSV")) { $soubor = unlink("../tmp/$nazsub.CSV"); }

$soubor = fopen("../tmp/$nazsub.CSV", "a+");

//polozky
$sqltt = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014texty ORDER BY ozntxt";


$sql = mysql_query("$sqltt");
$pol = mysql_num_rows($sql);

$i=0;
$j=0; //zaciatok strany ak by som chcel strankovat

  while ($i <= $pol )
  {


  if (@$zaznam=mysql_data_seek($sql,$i))
{
$hlavicka=mysql_fetch_object($sql);

$poznbr=str_replace("\r\n","###rn###",$hlavicka->hdntxt);
$poznbr=str_replace("\r","###r###",$poznbr);

  $text = $hlavicka->ozntxt.";".$poznbr.";koniec";
  $text = $text."\r\n";


  fwrite($soubor, $text);


}
$i = $i + 1;
$j = $j + 1;
  }

$copern=1;
fclose($soubor);
?>

<a href="../tmp/<?php echo $nazsub; ?>.CSV">../tmp/<?php echo $nazsub; ?>.CSV</a>


<?php
exit;
    }
//koniec exportuj poznamky



//nacitanie nacitania poznamok z firmy
    if ( $copern == 355 )
    {

$firxyz = 1*strip_tags($_REQUEST['firx']);
$fix=0;
if( $fir_allx11 > 0 ) $fix=1*$fir_allx11;
if( $firxyz > 0 ) { $fix=1*$firxyz; }

if( $fix == 0 AND $firxyz == 0 ) { echo "V ˙dajoch o firme musÌte zadaù ËÌslo firmy minulÈho roka."; exit; }

?>
<script type="text/javascript">
if( !confirm ("Chcete naËÌtaù pozn·mky z firmy Ë. <?php echo $fix;?> ? \r POZOR !!! CelÈ pozn·mky bud˙ najprv vymazanÈ .") )
         { window.close()  }
else
         { location.href='poznamky_muj2014texty.php?&copern=356&drupoh=1&page=1&h_ozntxt=<?php echo $h_ozntxt; ?>&firx=<?php echo $firxyz; ?>'  }
</script>
<?php
    }

    if ( $copern == 356 )
    {
$copern=1;
$firxyz = 1*strip_tags($_REQUEST['firx']);
$fix=0;
if( $fir_allx11 > 0 ) { $fix=1*$fir_allx11; }
if( $firxyz > 0 ) { $fix=1*$firxyz; }

if( $fix == 0 AND $firxyz == 0 ) { echo "V ˙dajoch o firme musÌte zadaù ËÌslo firmy minulÈho roka."; exit; }

$kli_vrokxy=$kli_vrok;
$firmaneex=1;
$sqlfir = "SELECT * FROM fir WHERE xcf = $fix ";
$fir_vysledok = mysql_query($sqlfir);
$kolkofir = 1*mysql_num_rows($fir_vysledok);
if( $kolkofir == 1 ) { $firmaneex=0; }
if ($fir_vysledok) { $fir_riadok=mysql_fetch_object($fir_vysledok); $kli_vrokxy = 1*$fir_riadok->rok;  }

if( $firmaneex == 1 ) { echo "Zadan· firma ËÌslo ".$fix." neexistuje v ËÌselnÌku firiem."; exit; }
//echo $kli_vrokxy;

$databaza="";
$kli_vrokx=$kli_vrok;
$kli_vrok=$kli_vrokxy;
$dtb2 = include("../cis/oddel_dtbz2.php");
$kli_vrok=$kli_vrokx;

//_poznamky_muj2014texty   psys  ozntxt  hdntxt  prmx1  prmx2  prmx3  prmx4  oldp  oldc1  oldc2  konx  konx8  ico 

//z akych poznamok ideme
$idemezostarych=0;

//len ked ideme z novych
if( $idemezostarych == 0 )
     {
//echo "ideme z novych";

$sqlfir = "SELECT * FROM ".$databaza."F$fix"."_poznamky_muj2014texty ";
$fir_vysledok = mysql_query($sqlfir);
if(!$fir_vysledok) { echo "Vo firme ".$fix." neexistuj˙ Pozn·mky MUJ 2014."; exit;  }

$sqult = "TRUNCATE TABLE F$kli_vxcf"."_poznamky_muj2014texty ";
$ulozene = mysql_query("$sqult");

$dsqlt = "INSERT INTO F$kli_vxcf"."_poznamky_muj2014texty SELECT * FROM ".$databaza."F$fix"."_poznamky_muj2014texty WHERE ico >= 0 ";
$dsql = mysql_query("$dsqlt");
//echo $dsqlt;

//koniec len ked ideme z novych
     }

$copern=1;
    }
//koniec nacitania poznamok z firmy


$sqlfir = "SELECT * FROM F$kli_vxcf"."_poznamky_muj2014texty ".
" WHERE ozntxt = '$h_ozntxt' ";
//echo $sqlfir;

$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$h_hdntxt = $fir_riadok->hdntxt;


mysql_free_result($fir_vysledok);



?>


<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link rel="stylesheet" href="../css/styl_poznamky_po2011.css" type="text/css">
  <style type="text/css">
table.pnseda { border: outset 2pt ; background-color:gray;
              background:gray; top:10px; 
              font-family:bold; font-size:10pt; font-weight:bold; } 
td.pnseda  { background-color:white; color:black; font-weight:bold;
            height:12px; font-size:12px; } 

  </style>
<title>EuroSecom - ⁄ËtovnÈ pozn·mky - doplÚuj˙ci text</title>
<script type="text/javascript">

    function ImportPoz()
    {
var firma = 1*document.forms.formpren.xfir.value;


window.open('poznamky_muj2014texty.php?&copern=55&page=1&firx=' + firma + '&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
    }

    function nacitajMin()
    {
window.open('poznamky_muj2014texty.php?copern=355&drupoh=1&page=1&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
    }

    function nacitajFir()
    {
var firma = 1*document.forms.formpren.xfir.value;

if( firma > 0 && firma != <?php echo $kli_vxcf; ?> )
       {
window.open('poznamky_muj2014texty.php?copern=355&drupoh=1&page=1&firx='+ firma + '&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
       }
    }

    function nacitajFirJeden()
    {
myZakelement.style.display='';
volajZak(0,1);

    }

    function vykonajTextJeden(oznacenie,firma,starytyp)
    {

var oznacx= oznacenie;
var firmax= firma;
var strtpx= starytyp;

myZakelement.style.display='none';
window.open('poznamky_muj2014texty.php?copern=4055&drupoh=1&page=1&firmax='+ firmax + '&oznacx='+ oznacx + '&h_ozntxt=<?php echo $h_ozntxt; ?>',
 '_self', 'width=1080, height=900, top=0, left=20, status=yes, resizable=yes, scrollbars=yes' );
    }

<?php
//nova
  if ( $copern == 1 AND $bralsomjedentext == 0 )
  { 
?>
    function ObnovUI()
    {


    }

<?php
//koniec nova
  }
?>
<?php
//nova
  if ( $copern == 1 AND $bralsomjedentext == 1 )
  { 
?>
    function ObnovUI()
    {
    document.forms.formpren.xfir.value = <?php echo $firmax; ?>

    }

<?php
//koniec nova
  }
?>

  </script> 
<script type="text/javascript" src="poznamky_textymuj2014_xml.js"></script>
</HEAD>
<BODY onload="ObnovUI();" style="overflow:auto;"  >


<div id="myZakelement" style="cursor: hand; display: none; position: absolute; z-index: 300; top: 200; left: 40; ">texty</div>

<table class="nadpis" width="100%" style="margin-bottom:20px;" >
 <tr>
<?php
if( $h_ozntxt == "A_text1" ) { $h_ozntxtx="Ël.I.2 "; }
if( $h_ozntxt == "A_text2" ) { $h_ozntxtx="Ël.I.3 "; }
if( $h_ozntxt == "B_text1" ) { $h_ozntxtx="Ël.II.1 "; }
if( $h_ozntxt == "B_text2" ) { $h_ozntxtx="Ël.II.2 "; }
if( $h_ozntxt == "B_text3" ) { $h_ozntxtx="Ël.II.3 "; }
if( $h_ozntxt == "B_text4" ) { $h_ozntxtx="Ël.II.4 "; }
if( $h_ozntxt == "B_text5" ) { $h_ozntxtx="Ël.II.5 "; }
if( $h_ozntxt == "B_text6" ) { $h_ozntxtx="Ël.II.6 "; }
if( $h_ozntxt == "C_text1" ) { $h_ozntxtx="Ël.III.1 "; }
if( $h_ozntxt == "C_text2" ) { $h_ozntxtx="Ël.III.2 "; }
if( $h_ozntxt == "C_text3" ) { $h_ozntxtx="Ël.III.3 "; }
if( $h_ozntxt == "C_text4" ) { $h_ozntxtx="Ël.III.4 "; }
if( $h_ozntxt == "C_text5" ) { $h_ozntxtx="Ël.III.5 Pods˙vahovÈ poloûky"; }
if( $h_ozntxt == "C_text6" ) { $h_ozntxtx="Ël.III.5 PodmienenÈ z·v‰zky"; }
if( $h_ozntxt == "C_text7" ) { $h_ozntxtx="Ël.III.5 Podmienen˝ majetok"; }

?>
  <td width="40%" class="h2" >DoplÚuj˙ci text k <?php echo $h_ozntxtx;?></td>
<FORM name="formpren" method="post" action="#">
  <td width="60%" align="right" style="font-size:14px;" >
  <a href="#" onClick="nacitajMin();" title='NaËÌtaù vöetky texty pozn·mok z minulÈho roka'>Minul˝ rok
  <img src='../obr/zoznam.png' width=20 height=15 border=0 ></a>
  &nbsp;|&nbsp;
  <a href="#" onClick="nacitajFir();" title='NaËÌtaù vöetky texty pozn·mok z firmy ËÌslo' >Firma
  <img src='../obr/zoznam.png' width=20 height=15 border=0 ></a>
  &nbsp;|&nbsp;
  <span style="font-weight:normal" >ËÌslo</span><INPUT type="text" name="xfir" id="xfir" size="5">
  &nbsp;|&nbsp;
  <a href="#" onClick="nacitajFirJeden();" title='NaËÌtaù jeden text pozn·mok z firmy ËÌslo' >1x
  <img src='../obr/naradie.png' width=20 height=15 border=0 ></a>

<?php if ( $kli_uzall > 90000 ) { ?>
  &nbsp;&nbsp;&nbsp;|&nbsp;
<a href='poznamky_muj2014texty.php?&copern=655&page=1'>
<img src='../obr/export.png' width=20 height=15 border=0 title="Exportuj pozn·mky do CSV"></a>
<?php                           } ?>
<?php if ( $kli_uzall > 90000 ) { ?>
  &nbsp;|&nbsp;
<a href='#' onclick='ImportPoz();'>
<img src='../obr/import.png' width=20 height=15 border=0 title="Importuj pozn·mky z CSV"></a>
<?php                           } ?>
  &nbsp;|&nbsp;
<a href='poznamky_muj2014texty.php?&copern=55&page=1&firx=9999' >
<img src='../obr/orig.png' width=20 height=15 border=0 title="Importuj ötandartnÈ pozn·mky"></a>
  </td>
</FORM>
 </tr>
</table>


<?php
if ( $copern == 1  )
     {
?>
<FORM name="formv1" method="post" action="poznamky_muj2014texty.php?page=1&copern=116&h_ozntxt=<?php echo $h_ozntxt;?>">
<table style="" width="900px" align="center" >
<thead style="" >
 <tr>
  <td width="15%" ></td>
  <td width="50%" ><span id="infosave" name="infosave" style="letter-spacing:1px; background-color:lightblue; padding:2px 10px; font-weight:bold;"><?php echo $ulozenx; ?></span></td>
  <td width="20%" align="right" ><INPUT style="height:26px; width:80px;" type="submit" id="uloz" name="uloz" value="Uloûiù"></td>
  <td width="15%" ></td>
 </tr>
</thead>
<tbody>
 <tr>
  <td valign="bottom" ><img src="../obr/left_quote.png" style="" title="bottom quote" height="50" width="62"></td>
  <td colspan="2" align="center" ><div>
  <textarea style="margin:5px 0; overflow:auto; border:4px solid lightblue;" onClick="infosave.style.display='none';" name="h_hdntxt" id="h_hdntxt" rows="34" cols="90" style=""><?php echo $h_hdntxt; ?></textarea>
  </div>
  </td>
  <td valign="top" >&nbsp;<img src="../obr/right_quote.png" style="" title="top quote" height="50" width="62"></td>
 </tr>
</tbody>
</table>
</FORM>

<?php
// toto je koniec casti na zobrazenie tabulky a prechody medzi stranami 
     }

// celkovy koniec dokkurztu

       } while (false);
?>
</BODY>
</HTML>
