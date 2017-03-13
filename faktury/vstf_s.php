<HTML>
<?php

do
{
$sys = 'FAK';
$urov = 2000;
$drupoh = $_REQUEST['drupoh'];
if( $drupoh == 31 OR $drupoh == 12 OR $drupoh == 22 OR $drupoh == 42 )
{
$sys = 'DOP';
$urov = 2000;
}

$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$cislo_dok = $_REQUEST['cislo_dok'];
$citfir = include("../cis/citaj_fir.php");
$drupoh = $_REQUEST['drupoh'];
$zmluva = 1*$_REQUEST['zmluva'];
if( $zmluva == 1 ) { $copern=120; }

$zmluva=0;
if( $drupoh == 1 AND $copern == 20 )
{
$tabl = "fakodb";
$cisdok = "fakodb";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$adrdok = "fakodber";
}
if( $drupoh == 2 AND $copern == 20 )
{
$tabl = "fakdod";
$cisdok = "fakdod";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Dodávate¾";
$adrdok = "fakdodav";
}
if( $drupoh == 1 AND $copern == 120 )
{
$tabl = "fakodb";
$cisdok = "fakodb";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Odberate¾";
$adrdok = "fakodber";
$zmluva=1;
$copern=20;
}
if( $drupoh == 2 AND $copern == 120 )
{
$tabl = "fakdod";
$cisdok = "fakdod";
$znmskl = "-";
$znxskl = "+";
$Odberatel = "Dodávate¾";
$adrdok = "fakdodav";
$zmluva=1;
$copern=20;
}

if( $drupoh == 1 AND $copern == 130 )
{
$tabl = "kuchjedalne";
$cisdok = "kuchjedalne";
$znmskl = "";
$znxskl = "";
$Odberatel = "";
$adrdok = "jedalnylistok";
$zmluva=0;
}

if( $drupoh == 101 AND $copern == 20 ){ $adrdok = "pokprijem"; }
if( $drupoh == 102 AND $copern == 20 ){ $adrdok = "pokvydaj"; }
if( $drupoh == 103 AND $copern == 20 ){ $adrdok = "banvyp"; }
if( $drupoh == 104 AND $copern == 20 ){ $adrdok = "vsdh"; }
if( $drupoh == 105 AND $copern == 20 ){ $adrdok = "vsdh"; }

if( $copern == 31 ) $adrdok = "asluzby";
if( $copern == 32 ) $adrdok = "bsluzby";
if( $copern == 33 ) $adrdok = "csluzby";
if( $copern == 34 ) $adrdok = "dsluzby";
if( $copern == 131 ) $adrdok = "amaterial";
if( $copern == 132 ) $adrdok = "bmaterial";
if( $copern == 133 ) $adrdok = "cmaterial";
if( $copern == 134 ) $adrdok = "dmaterial";
if( $copern == 231 ) $adrdok = "adsluzby";
if( $copern == 232 ) $adrdok = "bdsluzby";
if( $copern == 233 ) $adrdok = "cdsluzby";
if( $copern == 234 ) $adrdok = "ddsluzby";
if( $copern == 334 ) $adrdok = "";
if( $copern == 335 ) $adrdok = "";
?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Naèítaj Originál</title>
  <style type="text/css">

  </style>

<SCRIPT Language="JavaScript">
    <!--

     
    // -->
</SCRIPT>

</HEAD>
<BODY class="white" >

<table class="h2" width="100%" >
<tr>
<td>EuroSecom 
<?php
  if ( $copern == 130 AND $drupoh == 1 ) echo "- uloženie jedálneho lístka èíslo $cislo_dok na web";
  if ( $copern == 20 AND $drupoh < 100 AND $zmluva == 0 ) echo "- uloženie originálu faktúry èíslo $cislo_dok do databázy";
  if ( $copern == 20 AND $drupoh < 100 AND $zmluva == 1 ) echo "- uloženie originálu zmluvy èíslo $cislo_dok do databázy";
  if ( $copern == 20 AND $drupoh > 100 ) echo "- uloženie originálu dokladu èíslo $cislo_dok do databázy";
  if ( $copern == 31 ) echo "- uloženie obrázok A k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 32 ) echo "- uloženie obrázok B k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 33 ) echo "- uloženie obrázok C k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 34 ) echo "- uloženie obrázok D k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 131 ) echo "- uloženie obrázok A k materiálovej položke $cislo_dok do databázy";
  if ( $copern == 132 ) echo "- uloženie obrázok B k materiálovej položke $cislo_dok do databázy";
  if ( $copern == 133 ) echo "- uloženie obrázok C k materiálovej položke $cislo_dok do databázy";
  if ( $copern == 134 ) echo "- uloženie obrázok, video D k materiálovej položke $cislo_dok do databázy";
  if ( $copern == 231 ) echo "- uloženie obrázok A k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 232 ) echo "- uloženie obrázok B k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 233 ) echo "- uloženie obrázok C k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 234 ) echo "- uloženie obrázok D k neskladovej položke $cislo_dok do databázy";
  if ( $copern == 334 ) echo "- uloženie obrázok v hlavièke eshopu do databázy";
  if ( $copern == 335 ) echo "- uloženie Všeobecné obchod. podmienky eshopu do databázy";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php 
if ($copern > 0)
                { 

if ($_REQUEST["odeslano"]==1): 

$pole = explode(".", $_FILES['original']['name']);
$snazov=$pole[0];
$styp=strtolower($pole[1]);
if( $styp != "jpg" AND $styp != "gif" AND  $styp != "bmp" AND  $styp != "png" AND  $styp != "pdf" AND  $styp != "doc" AND  $styp != "avi"  ) 
{ echo $styp." Erorr Code 433"; exit; }

$d="d";
if( $zmluva == 1 ) { $d="dd"; }
$lenvymaz=0;
if( $snazov == 'vymazat' ) { $lenvymaz=1; }

if( $lenvymaz == 0 AND $copern != 334 AND $copern != 335 AND $copern != 131 ) {

$ddir="../dokumenty/FIR".$kli_vxcf."/".$adrdok;
if (!File_Exists ("$ddir")) { mkdir ($ddir, 0777); }

  if (move_uploaded_file($_FILES['original']['tmp_name'], "../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp")) 
  { 
?>
<script type="text/javascript" > 
alert ("Súbor <?php echo $_FILES['original']['name']; ?> bol správne uložený do databázy .");
window.close();
</script>
<?php
  }
                                        }
if( $lenvymaz == 0 AND $copern == 131 ) {

$hhmmss = Date ("His", MkTime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.jpg")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.jpg"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.png")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.png"); }

 $outfilexdel="../dokumenty/FIR".$kli_vxcf."/".$adrdok."/".$d.$cislo_dok."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

 $savefilex="../dokumenty/FIR".$kli_vxcf."/".$adrdok."/".$d.$cislo_dok."_".$hhmmss.".".$styp;

  if (move_uploaded_file($_FILES['original']['tmp_name'], $savefilex)) 
  { 
?>
<script type="text/javascript" > 
alert ("Súbor <?php echo $_FILES['original']['name']; ?> bol správne uložený do databázy .");
window.close();
</script>
<?php
  }
                                        }
if( $lenvymaz == 0 AND $copern == 334 ) {
  if (move_uploaded_file($_FILES['original']['tmp_name'], "../dokumenty/FIR$kli_vxcf/hlavickaweb.$styp")) 
  { 
?>
<script type="text/javascript" > 
alert ("Súbor <?php echo $_FILES['original']['name']; ?> bol správne uložený do databázy .");
window.close();
</script>
<?php
  }
                                        }
if( $lenvymaz == 0 AND $copern == 335 ) {
  if (move_uploaded_file($_FILES['original']['tmp_name'], "../dokumenty/FIR$kli_vxcf/vseobpodmienky.$styp")) 
  { 
?>
<script type="text/javascript" > 
alert ("Súbor <?php echo $_FILES['original']['name']; ?> bol správne uložený do databázy .");
window.close();
</script>
<?php
  }
                                        }
if( $lenvymaz == 1 AND $copern != 334 AND $copern != 335 AND $copern != 131 ) {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.jpg")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.jpg"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.png")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.png"); }
?>
<script type="text/javascript" > 
alert ("Obrázok bol vymazaný .");
window.close();
</script>
<?php
                                        };
if( $lenvymaz == 1 AND $copern == 131 ) {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.$styp"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.jpg")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.jpg"); }
if (File_Exists ("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.png")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/$adrdok/$d$cislo_dok.png"); }

 $outfilexdel="../dokumenty/FIR".$kli_vxcf."/".$adrdok."/".$d.$cislo_dok."_*.*";
 foreach (glob("$outfilexdel") as $filename) {
    unlink($filename);
 }

?>
<script type="text/javascript" > 
alert ("Obrázok bol vymazaný .");
window.close();
</script>
<?php
                                        };
if( $lenvymaz == 1 AND $copern == 334 ) {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/hlavickaweb.jpg")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/hlavickaweb.jpg"); }
?>
<script type="text/javascript" > 
alert ("Obrázok bol vymazaný .");
window.close();
</script>
<?php
                                        };
if( $lenvymaz == 1 AND $copern == 335 ) {
if (File_Exists ("../dokumenty/FIR$kli_vxcf/vseobpodmienky.pdf")) { $soubor = unlink("../dokumenty/FIR$kli_vxcf/vseobpodmienky.pdf"); }
?>
<script type="text/javascript" > 
alert ("Obrázok bol vymazaný .");
window.close();
</script>
<?php
                                        };
else: 
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?cislo_dok=<?php echo $cislo_dok; ?>
&drupoh=<?php echo $drupoh; ?>&copern=<?php echo $copern; ?>&zmluva=<?php echo $zmluva; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="35%" align="right" >Súbor:</td> 
        <td  width="30%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE=2097152> 
        <input type="file" name="original" > 
        </td> 
        <td  width="35%" align="left" >(max. 2 MB)</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="Odosla"></td> 
      </tr> 
    </table> 
    </form> 
<?php 
endif; 
//koniec copern 0
                 }
?> 



<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>