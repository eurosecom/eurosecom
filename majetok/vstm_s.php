<HTML>
<?php

do
{
$sys = 'HIM';
$urov = 1000;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$cislo_xy = $_REQUEST['cislo_xy'];
$citfir = include("../cis/citaj_fir.php");
$drupoh = $_REQUEST['drupoh'];

$adrdok="maj";
if( $drupoh == 2 ) $adrdok="dim";


if( $copern == 30 ) $nzs = "ainv";
if( $copern == 31 ) $nzs = "binv";
if( $copern == 32 ) $nzs = "cinv";
if( $copern == 33 ) $nzs = "dinv";

?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=Windows 1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Na��taj Origin�l</title>
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
  if ( $copern == 30 ) echo "- ulo�enie fotografie A do datab�zy";
  if ( $copern == 31 ) echo "- ulo�enie fotografie B do datab�zy";
  if ( $copern == 32 ) echo "- ulo�enie fotografie C do datab�zy";
  if ( $copern == 33 ) echo "- ulo�enie fotografie D do datab�zy";
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
if( $styp != "jpg" AND $styp != "gif" AND  $styp != "bmp" AND  $styp != "png" AND  $styp != "pdf" AND  $styp != "doc"  ) { echo $styp." Erorr Code 433"; exit; }


  if (move_uploaded_file($_FILES['original']['tmp_name'], "../dokumenty/FIR$kli_vxcf/$adrdok/$nzs$cislo_xy.$styp")) 
  { 
?>
<script type="text/javascript" > 
alert ("S�bor <?php echo $_FILES['original']['name']; ?> bol spr�vne ulo�en� do datab�zy .");
window.close();
</script>
<?php
  }; 
else: 
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?cislo_xy=<?php echo $cislo_xy; ?>
&drupoh=<?php echo $drupoh; ?>&copern=<?php echo $copern; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="35%" align="right" >S�bor:</td> 
        <td  width="30%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE=800000> 
        <input type="file" name="original" > 
        </td> 
        <td  width="35%" align="left" >(max. 800 kB)</td> 
      </tr> 
      <tr> 
        <td colspan="3"> 
              <input type="hidden" name="odeslano" value="1"> 
          <p align="center"><input type="submit" value="Odosla�"></td> 
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