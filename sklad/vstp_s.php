<HTML>
<?php

do
{
$sys = 'SKL';
$urov = 1000;
$cslm=401103;
$uziv = include("../uziv.php");
if( !$uziv ) exit;

$copern = $_REQUEST['copern'];
$cislo_skl = $_REQUEST['cislo_skl'];
$cislo_dok = $_REQUEST['cislo_dok'];
$citfir = include("../cis/citaj_fir.php");
$drupoh = $_REQUEST['drupoh'];

if( $drupoh == 1 )
{
$tabl = "sklpri";
$cov1p = "Pr�jem";
$com1p = "pr�jem";
$com4p = "pr�jmu";
$dokm1p = "pr�jemka";
$dokm4p = "pr�jemky";
$dokm2p = "pr�jemku";
$dokm4pm = "pr�jemok";
$icov1p = "Dod�vate�";
$hladp = "Dod�vate�";
$skladp = "Na sklad";
$fakv1p = "Fakt�ra";
$skladpd = "Na sklad:";
$fakv1pd = "Fakt�ra:";
$cisdok = "sklcpr";
$akedrp = "<= 4";
$znmskl = "+";
$znxskl = "-";
$h_sk2 = $cislo_skl;
if( $copern == 68 ) $h_sk2 = $h_skl;
$popico = "Dod�vate� I�O:";
$popnai = "Dod�vate� N�zov:";
$adrdok = "prijemky";
}

if( $drupoh == 2 )
{
$tabl = "sklvyd";
$cov1p = "V�daj";
$com1p = "v�daj";
$com4p = "v�daja";
$dokm1p = "v�dajka";
$dokm4p = "v�dajky";
$dokm2p = "v�dajku";
$dokm4pm = "v�dajok";
$icov1p = "Odberate�";
$hladp = "Odberate� - Z�kazka";
$skladp = "Zo skladu";
$fakv1p = "Fakt�ra";
$skladpd = "Zo skladu:";
$fakv1pd = "Fakt�ra:";
$cisdok = "sklcvd";
$akedrp = ">= 6";
$znmskl = "-";
$znxskl = "+";
$h_sk2 = $cislo_skl;
if( $copern == 68 ) $h_sk2 = $h_skl;
$popico = "Odberate� I�O:";
$popnai = "Odberate� N�zov:";
$adrdok = "vydajky";
}

if( $drupoh == 3 )
{
$tabl = "sklpre";
$cov1p = "Presun";
$com1p = "presun";
$com4p = "presunu";
$dokm1p = "presunka";
$dokm4p = "presunky";
$dokm2p = "presunku";
$dokm4pm = "presuniek";
$icov1p = "Dod�vate�";
$hladp = "Na sklad";
$skladp = "Zo skladu";
$skladpd = "Zo skladu:";
$fakv1pd = "";
$fakv1p = "   ";
$cisdok = "sklcps";
$akedrp = "= 5";
$znmskl = "-";
$znxskl = "+";
$h_str = 0;
$h_zak = 0;
$popico = " ";
$popnai = " ";
$adrdok = "presunky";
}


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
<td>EuroSecom  -  <?php echo $cov1p; ?> z�sob
<?php
  if ( $copern == 20 ) echo "- ulo�enie origin�lu $dokm4p ��slo $cislo_dok zo skladu $cislo_skl do datab�zy";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />


<?php 
if ($copern == 20)
                { 

if ($_REQUEST["odeslano"]==1): 

$pole = explode(".", $_FILES['original']['name']);
$snazov=$pole[0];
$styp=strtolower($pole[1]);
if( $styp != "jpg" AND $styp != "gif" AND  $styp != "bmp" AND  $styp != "png" AND  $styp != "pdf" AND  $styp != "doc"  ) { echo $styp." Erorr Code 433"; exit; }


  if (move_uploaded_file($_FILES['original']['tmp_name'], "../dokumenty/FIR$kli_vxcf/$adrdok/d$cislo_dok.$styp")) 
  { 
?>
<script type="text/javascript" > 
alert ("Origin�l dokladu <?php echo $_FILES['original']['name']; ?> bol spr�vne ulo�en� do datab�zy .");
window.close();
</script>
<?php
  }; 
else: 
?> 
    <form method="POST" ENCTYPE="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]?>?cislo_dok=<?php echo $cislo_dok; ?>
&drupoh=<?php echo $drupoh; ?>&copern=<?php echo $copern; ?>"> 
    <table class="vstup" width="100%" height="50px">
      <tr> 
        <td  width="35%" align="right" >Origin�l dokladu :</td> 
        <td  width="30%" align="center" > 
        <input type="HIDDEN" name="MAX_FILE_SIZE" VALUE=200000> 
        <input type="file" name="original" > 
        </td> 
        <td  width="35%" align="left" >(max. 200 kB)</td> 
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
//koniec copern 20
                 }
?> 



<?php
//celkovy koniec dokumentu
} while (false);
?>
</BODY>
</HTML>