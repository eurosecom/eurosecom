<HTML>
<?php

// celkovy zaciatok dokumentu
       do
       {
$sys = 'HIM';
$urov = 2000;
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

$sql = "SELECT * FROM F$kli_vxcf"."_vtvall";
$vysledok = mysql_query($sql);
if (!$vysledok):
$vtvall = include("../cis/vtvall.php");
endif;


// cislo operacie
$copern = 1*strip_tags($_REQUEST['copern']);

// zapis upravene sadzby
if ( $copern == 3 )
    {
$rdoba1 = strip_tags($_REQUEST['rdoba1']);
$rdoba2 = strip_tags($_REQUEST['rdoba2']);
$rdoba3 = strip_tags($_REQUEST['rdoba3']);
$rdoba4 = strip_tags($_REQUEST['rdoba4']);
$rdoba5 = strip_tags($_REQUEST['rdoba5']);
$rdoba6 = strip_tags($_REQUEST['rdoba6']);
$rdoba7 = strip_tags($_REQUEST['rdoba7']);
$rdoba8 = strip_tags($_REQUEST['rdoba8']);
$rdoba9 = strip_tags($_REQUEST['rdoba9']);
$rdoba10 = strip_tags($_REQUEST['rdoba10']);
$zkoep1 = strip_tags($_REQUEST['zkoep1']);
$zkoep2 = strip_tags($_REQUEST['zkoep2']);
$zkoep3 = strip_tags($_REQUEST['zkoep3']);
$zkoep4 = strip_tags($_REQUEST['zkoep4']);
$zkoep5 = strip_tags($_REQUEST['zkoep5']);
$zkoep6 = strip_tags($_REQUEST['zkoep6']);
$zkoep7 = strip_tags($_REQUEST['zkoep7']);
$zkoep8 = strip_tags($_REQUEST['zkoep8']);
$zkoep9 = strip_tags($_REQUEST['zkoep9']);
$zkoep10 = strip_tags($_REQUEST['zkoep10']);
$zkoed1 = strip_tags($_REQUEST['zkoed1']);
$zkoed2 = strip_tags($_REQUEST['zkoed2']);
$zkoed3 = strip_tags($_REQUEST['zkoed3']);
$zkoed4 = strip_tags($_REQUEST['zkoed4']);
$zkoed5 = strip_tags($_REQUEST['zkoed5']);
$zkoed6 = strip_tags($_REQUEST['zkoed6']);
$zkoed7 = strip_tags($_REQUEST['zkoed7']);
$zkoed8 = strip_tags($_REQUEST['zkoed8']);
$zkoed9 = strip_tags($_REQUEST['zkoed9']);
$zkoed10 = strip_tags($_REQUEST['zkoed10']);
$zzvys1 = strip_tags($_REQUEST['zzvys1']);
$zzvys2 = strip_tags($_REQUEST['zzvys2']);
$zzvys3 = strip_tags($_REQUEST['zzvys3']);
$zzvys4 = strip_tags($_REQUEST['zzvys4']);
$zzvys5 = strip_tags($_REQUEST['zzvys5']);
$zzvys6 = strip_tags($_REQUEST['zzvys6']);
$zzvys7 = strip_tags($_REQUEST['zzvys7']);
$zzvys8 = strip_tags($_REQUEST['zzvys8']);
$zzvys9 = strip_tags($_REQUEST['zzvys9']);
$zzvys10 = strip_tags($_REQUEST['zzvys10']);

$rdoba1_dan = strip_tags($_REQUEST['rdoba1_dan']);
$rdoba2_dan = strip_tags($_REQUEST['rdoba2_dan']);
$rdoba3_dan = strip_tags($_REQUEST['rdoba3_dan']);
$rdoba4_dan = strip_tags($_REQUEST['rdoba4_dan']);
$rdoba5_dan = strip_tags($_REQUEST['rdoba5_dan']);
$rdoba6_dan = strip_tags($_REQUEST['rdoba6_dan']);
$rdoba7_dan = strip_tags($_REQUEST['rdoba7_dan']);
$zkoep1_dan = strip_tags($_REQUEST['zkoep1_dan']);
$zkoep2_dan = strip_tags($_REQUEST['zkoep2_dan']);
$zkoep3_dan = strip_tags($_REQUEST['zkoep3_dan']);
$zkoep4_dan = strip_tags($_REQUEST['zkoep4_dan']);
$zkoep5_dan = strip_tags($_REQUEST['zkoep5_dan']);
$zkoep6_dan = strip_tags($_REQUEST['zkoep6_dan']);
$zkoep7_dan = strip_tags($_REQUEST['zkoep7_dan']);
$zkoed1_dan = strip_tags($_REQUEST['zkoed1_dan']);
$zkoed2_dan = strip_tags($_REQUEST['zkoed2_dan']);
$zkoed3_dan = strip_tags($_REQUEST['zkoed3_dan']);
$zkoed4_dan = strip_tags($_REQUEST['zkoed4_dan']);
$zkoed5_dan = strip_tags($_REQUEST['zkoed5_dan']);
$zkoed6_dan = strip_tags($_REQUEST['zkoed6_dan']);
$zkoed7_dan = strip_tags($_REQUEST['zkoed7_dan']);
$zzvys1_dan = strip_tags($_REQUEST['zzvys1_dan']);
$zzvys2_dan = strip_tags($_REQUEST['zzvys2_dan']);
$zzvys3_dan = strip_tags($_REQUEST['zzvys3_dan']);
$zzvys4_dan = strip_tags($_REQUEST['zzvys4_dan']);
$zzvys5_dan = strip_tags($_REQUEST['zzvys5_dan']);
$zzvys6_dan = strip_tags($_REQUEST['zzvys6_dan']);
$zzvys7_dan = strip_tags($_REQUEST['zzvys7_dan']);

$uprav="NO";


$uprtxt = "UPDATE F$kli_vxcf"."_majsodp SET rdoba1='$rdoba1', rdoba2='$rdoba2', rdoba3='$rdoba3',".
" rdoba4='$rdoba4', rdoba5='$rdoba5', rdoba6='$rdoba6', ".
" rdoba7='$rdoba7', rdoba8='$rdoba8', rdoba9='$rdoba9', rdoba10='$rdoba10',".
" zkoep1='$zkoep1', zkoep2='$zkoep2', zkoep3='$zkoep3', zkoep4='$zkoep4', zkoep5='$zkoep5', zkoep6='$zkoep6',".
" zkoep7='$zkoep7', zkoep8='$zkoep8', zkoep9='$zkoep9', zkoep10='$zkoep10',".
" zkoed1='$zkoed1', zkoed2='$zkoed2', zkoed3='$zkoed3', zkoed4='$zkoed4', zkoed5='$zkoed5', zkoed6='$zkoed6',".
" zkoed7='$zkoed7', zkoed8='$zkoed8', zkoed9='$zkoed9', zkoed10='$zkoed10',".
" zzvys1='$zzvys1', zzvys2='$zzvys2', zzvys3='$zzvys3', zzvys4='$zzvys4', zzvys5='$zzvys5', zzvys6='$zzvys6',".
" zzvys7='$zzvys7', zzvys8='$zzvys8', zzvys9='$zzvys9', zzvys10='$zzvys10',".
" rdoba1_dan='$rdoba1_dan', rdoba2_dan='$rdoba2_dan', rdoba3_dan='$rdoba3_dan', rdoba4_dan='$rdoba4_dan', rdoba5_dan='$rdoba5_dan', rdoba6_dan='$rdoba6_dan', rdoba7_dan='$rdoba7_dan',".
" zkoep1_dan='$zkoep1_dan', zkoep2_dan='$zkoep2_dan', zkoep3_dan='$zkoep3_dan', zkoep4_dan='$zkoep4_dan', zkoep5_dan='$zkoep5_dan', zkoep6_dan='$zkoep6_dan', zkoep7_dan='$zkoep7_dan',".
" zkoed1_dan='$zkoed1_dan', zkoed2_dan='$zkoed2_dan', zkoed3_dan='$zkoed3_dan', zkoed4_dan='$zkoed4_dan', zkoed5_dan='$zkoed5_dan', zkoed6_dan='$zkoed6_dan', zkoed7_dan='$zkoed7_dan',".
" zzvys1_dan='$zzvys1_dan', zzvys2_dan='$zzvys2_dan', zzvys3_dan='$zzvys3_dan', zzvys4_dan='$zzvys4_dan', zzvys5_dan='$zzvys5_dan', zzvys6_dan='$zzvys6_dan', zzvys7_dan='$zzvys7_dan' ".
" WHERE cpl=1"; 

$upravene = mysql_query("$uprtxt");  
$copern=1;
if (!$upravene):
?>
<script type="text/javascript"> alert( "ÚDAJE NEBOLI UPRAVENÉ " ) </script>
<?php
endif;
if ($upravene):
$uprav="OK";
endif;
    }
//koniec zapisu upravenych sadzieb




//nacitaj udaje
if ( $copern > 1 )
    {

$sqlfir = "SELECT * FROM F$kli_vxcf"."_majsodp WHERE cpl = 1";
$fir_vysledok = mysql_query($sqlfir);
$fir_riadok=mysql_fetch_object($fir_vysledok);

$rdoba1 = $fir_riadok->rdoba1;
$rdoba2 = $fir_riadok->rdoba2;
$rdoba3 = $fir_riadok->rdoba3;
$rdoba4 = $fir_riadok->rdoba4;
$rdoba5 = $fir_riadok->rdoba5;
$rdoba6 = $fir_riadok->rdoba6;
$rdoba7 = $fir_riadok->rdoba7;
$rdoba8 = $fir_riadok->rdoba8;
$rdoba9 = $fir_riadok->rdoba9;
$rdoba10 = $fir_riadok->rdoba10;
$zkoep1 = $fir_riadok->zkoep1;
$zkoep2 = $fir_riadok->zkoep2;
$zkoep3 = $fir_riadok->zkoep3;
$zkoep4 = $fir_riadok->zkoep4;
$zkoep5 = $fir_riadok->zkoep5;
$zkoep6 = $fir_riadok->zkoep6;
$zkoep7 = $fir_riadok->zkoep7;
$zkoep8 = $fir_riadok->zkoep8;
$zkoep9 = $fir_riadok->zkoep9;
$zkoep10 = $fir_riadok->zkoep10;
$zkoed1 = $fir_riadok->zkoed1;
$zkoed2 = $fir_riadok->zkoed2;
$zkoed3 = $fir_riadok->zkoed3;
$zkoed4 = $fir_riadok->zkoed4;
$zkoed5 = $fir_riadok->zkoed5;
$zkoed6 = $fir_riadok->zkoed6;
$zkoed7 = $fir_riadok->zkoed7;
$zkoed8 = $fir_riadok->zkoed8;
$zkoed9 = $fir_riadok->zkoed9;
$zkoed10 = $fir_riadok->zkoed10;
$zzvys1 = $fir_riadok->zzvys1;
$zzvys2 = $fir_riadok->zzvys2;
$zzvys3 = $fir_riadok->zzvys3;
$zzvys4 = $fir_riadok->zzvys4;
$zzvys5 = $fir_riadok->zzvys5;
$zzvys6 = $fir_riadok->zzvys6;
$zzvys7 = $fir_riadok->zzvys7;
$zzvys8 = $fir_riadok->zzvys8;
$zzvys9 = $fir_riadok->zzvys9;
$zzvys10 = $fir_riadok->zzvys10;

$rdoba1_dan = $fir_riadok->rdoba1_dan;
$rdoba2_dan = $fir_riadok->rdoba2_dan;
$rdoba3_dan = $fir_riadok->rdoba3_dan;
$rdoba4_dan = $fir_riadok->rdoba4_dan;
$rdoba5_dan = $fir_riadok->rdoba5_dan;
$rdoba6_dan = $fir_riadok->rdoba6_dan;
$rdoba7_dan = $fir_riadok->rdoba7_dan;
$zkoep1_dan = $fir_riadok->zkoep1_dan;
$zkoep2_dan = $fir_riadok->zkoep2_dan;
$zkoep3_dan = $fir_riadok->zkoep3_dan;
$zkoep4_dan = $fir_riadok->zkoep4_dan;
$zkoep5_dan = $fir_riadok->zkoep5_dan;
$zkoep6_dan = $fir_riadok->zkoep6_dan;
$zkoep7_dan = $fir_riadok->zkoep7_dan;
$zkoed1_dan = $fir_riadok->zkoed1_dan;
$zkoed2_dan = $fir_riadok->zkoed2_dan;
$zkoed3_dan = $fir_riadok->zkoed3_dan;
$zkoed4_dan = $fir_riadok->zkoed4_dan;
$zkoed5_dan = $fir_riadok->zkoed5_dan;
$zkoed6_dan = $fir_riadok->zkoed6_dan;
$zkoed7_dan = $fir_riadok->zkoed7_dan;
$zzvys1_dan = $fir_riadok->zzvys1_dan;
$zzvys2_dan = $fir_riadok->zzvys2_dan;
$zzvys3_dan = $fir_riadok->zzvys3_dan;
$zzvys4_dan = $fir_riadok->zzvys4_dan;
$zzvys5_dan = $fir_riadok->zzvys5_dan;
$zzvys6_dan = $fir_riadok->zzvys6_dan;
$zzvys7_dan = $fir_riadok->zzvys7_dan;

mysql_free_result($fir_vysledok);

    }
//koniec nacitania




?>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=cp1250">
  <link type="text/css" rel="stylesheet" href="../css/styl.css">
<title>Sadzby odpisov majetku</title>
  <style type="text/css">

  </style>
<SCRIPT Language="JavaScript" Src="../js/cookies.js">
</SCRIPT>
<script type="text/javascript">
<?php
//uprava sadzby
  if ( $copern == 2 )
  { 
?>
    function ObnovUI()
    {
    document.formv1.rdoba1.value = '<?php echo "$rdoba1";?>';
    document.formv1.rdoba2.value = '<?php echo "$rdoba2";?>';
    document.formv1.rdoba3.value = '<?php echo "$rdoba3";?>';
    document.formv1.rdoba4.value = '<?php echo "$rdoba4";?>';
    document.formv1.rdoba5.value = '<?php echo "$rdoba5";?>';
    document.formv1.rdoba6.value = '<?php echo "$rdoba6";?>';
    document.formv1.rdoba7.value = '<?php echo "$rdoba7";?>';
    document.formv1.rdoba8.value = '<?php echo "$rdoba8";?>';
    document.formv1.rdoba9.value = '<?php echo "$rdoba9";?>';
    document.formv1.rdoba10.value = '<?php echo "$rdoba10";?>';
    document.formv1.zkoep1.value = '<?php echo "$zkoep1";?>';
    document.formv1.zkoep2.value = '<?php echo "$zkoep2";?>';
    document.formv1.zkoep3.value = '<?php echo "$zkoep3";?>';
    document.formv1.zkoep4.value = '<?php echo "$zkoep4";?>';
    document.formv1.zkoep5.value = '<?php echo "$zkoep5";?>';
    document.formv1.zkoep6.value = '<?php echo "$zkoep6";?>';
    document.formv1.zkoep7.value = '<?php echo "$zkoep7";?>';
    document.formv1.zkoep8.value = '<?php echo "$zkoep8";?>';
    document.formv1.zkoep9.value = '<?php echo "$zkoep9";?>';
    document.formv1.zkoep10.value = '<?php echo "$zkoep10";?>';
    document.formv1.zkoed1.value = '<?php echo "$zkoed1";?>';
    document.formv1.zkoed2.value = '<?php echo "$zkoed2";?>';
    document.formv1.zkoed3.value = '<?php echo "$zkoed3";?>';
    document.formv1.zkoed4.value = '<?php echo "$zkoed4";?>';
    document.formv1.zkoed5.value = '<?php echo "$zkoed5";?>';
    document.formv1.zkoed6.value = '<?php echo "$zkoed6";?>';
    document.formv1.zkoed7.value = '<?php echo "$zkoed7";?>';
    document.formv1.zkoed8.value = '<?php echo "$zkoed8";?>';
    document.formv1.zkoed9.value = '<?php echo "$zkoed9";?>';
    document.formv1.zkoed10.value = '<?php echo "$zkoed10";?>';
    document.formv1.zzvys1.value = '<?php echo "$zzvys1";?>';
    document.formv1.zzvys2.value = '<?php echo "$zzvys2";?>';
    document.formv1.zzvys3.value = '<?php echo "$zzvys3";?>';
    document.formv1.zzvys4.value = '<?php echo "$zzvys4";?>';
    document.formv1.zzvys5.value = '<?php echo "$zzvys5";?>';
    document.formv1.zzvys6.value = '<?php echo "$zzvys6";?>';
    document.formv1.zzvys7.value = '<?php echo "$zzvys7";?>';
    document.formv1.zzvys8.value = '<?php echo "$zzvys8";?>';
    document.formv1.zzvys9.value = '<?php echo "$zzvys9";?>';
    document.formv1.zzvys10.value = '<?php echo "$zzvys10";?>';

    document.formv1.rdoba1_dan.value = '<?php echo "$rdoba1_dan";?>';
    document.formv1.rdoba2_dan.value = '<?php echo "$rdoba2_dan";?>';
    document.formv1.rdoba3_dan.value = '<?php echo "$rdoba3_dan";?>';
    document.formv1.rdoba4_dan.value = '<?php echo "$rdoba4_dan";?>';
    document.formv1.rdoba5_dan.value = '<?php echo "$rdoba5_dan";?>';
    document.formv1.rdoba6_dan.value = '<?php echo "$rdoba6_dan";?>';
    document.formv1.rdoba7_dan.value = '<?php echo "$rdoba7_dan";?>';
    document.formv1.zkoep1_dan.value = '<?php echo "$zkoep1_dan";?>';
    document.formv1.zkoep2_dan.value = '<?php echo "$zkoep2_dan";?>';
    document.formv1.zkoep3_dan.value = '<?php echo "$zkoep3_dan";?>';
    document.formv1.zkoep4_dan.value = '<?php echo "$zkoep4_dan";?>';
    document.formv1.zkoep5_dan.value = '<?php echo "$zkoep5_dan";?>';
    document.formv1.zkoep6_dan.value = '<?php echo "$zkoep6_dan";?>';
    document.formv1.zkoep7_dan.value = '<?php echo "$zkoep7_dan";?>';
    document.formv1.zkoed1_dan.value = '<?php echo "$zkoed1_dan";?>';
    document.formv1.zkoed2_dan.value = '<?php echo "$zkoed2_dan";?>';
    document.formv1.zkoed3_dan.value = '<?php echo "$zkoed3_dan";?>';
    document.formv1.zkoed4_dan.value = '<?php echo "$zkoed4_dan";?>';
    document.formv1.zkoed5_dan.value = '<?php echo "$zkoed5_dan";?>';
    document.formv1.zkoed6_dan.value = '<?php echo "$zkoed6_dan";?>';
    document.formv1.zkoed7_dan.value = '<?php echo "$zkoed7_dan";?>';
    document.formv1.zzvys1_dan.value = '<?php echo "$zzvys1_dan";?>';
    document.formv1.zzvys2_dan.value = '<?php echo "$zzvys2_dan";?>';
    document.formv1.zzvys3_dan.value = '<?php echo "$zzvys3_dan";?>';
    document.formv1.zzvys4_dan.value = '<?php echo "$zzvys4_dan";?>';
    document.formv1.zzvys5_dan.value = '<?php echo "$zzvys5_dan";?>';
    document.formv1.zzvys6_dan.value = '<?php echo "$zzvys6_dan";?>';
    document.formv1.zzvys7_dan.value = '<?php echo "$zzvys7_dan";?>';
    }
<?php
//koniec uprava
  }
?>



<?php
//nie uprava
  if ( $copern != 2 )
  { 
?>
    function ObnovUI()
    {

    }
<?php
//koniec uprava
  }
?>

</script>
</HEAD>
<BODY class="white" onload="ObnovUI();">

<table class="h2" width="100%" >
<tr>
<td>EuroSecom  -  
<?php
  if ( $copern == 1 OR $copern == 2 OR $copern == 3 ) echo " Sadzby odpisov majetku";
?>

</td>
<td align="right"><span class="login"><?php echo "UME $kli_vume FIR$kli_vxcf-$kli_nxcf  login: $kli_uzmeno $kli_uzprie / $kli_uzid ";?></span></td>
</tr>
</table>
<br />

<?php
//zobraz nastavene sadzby
if ( $copern == 1 OR $copern == 3 )
    {
$sql = "SELECT * FROM F$kli_vxcf"."_majsodp WHERE cpl = 1";
$vysledok = mysql_query($sql);
$riadok=mysql_fetch_object($vysledok);
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="sadodp.php?copern=2" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" colspan="5">SADZBY ÚÈTOVNÝCH ODPISOV</td>
</tr>
<tr>
<td class="bmenu" width="20%">ODPISOVÁ SKUPINA</td>
<td class="bmenu" width="20%">Doba_odpisu</td>
<td class="bmenu" width="20%">Koeficient 1.rok</td>
<td class="bmenu" width="20%">Koeficient ïalšie roky</td>
<td class="bmenu" width="20%">Koeficient zvýšená cena</td>
</tr>
<tr>
<td class="fmenu" width="20%">1</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba1";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep1";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed1";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys1";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">2</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba2";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep2";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed2";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys2";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">3</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba3";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep3";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed3";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys3";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">4</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba4";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep4";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed4";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys4";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">5</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba5";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep5";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed5";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys5";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">6</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba6";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep6";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed6";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys6";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">7</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba7";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep7";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed7";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys7";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">8</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba8";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep8";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed8";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys8";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">9</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba9";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep9";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed9";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys9";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">10</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba10";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep10";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed10";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys10";?></td>
</tr>
<tr>
<td class="bmenu" colspan="5"> </td>
</tr>
<tr>
<td class="bmenu" colspan="5"> </td>
</tr>
<tr>
<td class="bmenu" colspan="5">SADZBY DAÒOVÝCH ODPISOV</td>
</tr>
<tr>
<td class="bmenu" width="20%">ODPISOVÁ SKUPINA</td>
<td class="bmenu" width="20%">Doba_odpisu</td>
<td class="bmenu" width="20%">Koeficient 1.rok</td>
<td class="bmenu" width="20%">Koeficient ïalšie roky</td>
<td class="bmenu" width="20%">Koeficient zvýšená cena</td>
</tr>
<tr>
<td class="fmenu" width="20%">1</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba1_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep1_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed1_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys1_dan";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">2</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba2_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep2_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed2_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys2_dan";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">3</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba3_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep3_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed3_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys3_dan";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">4</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba4_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep4_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed4_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys4_dan";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">5</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba5_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep5_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed5_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys5_dan";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">6</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba6_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep6_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed6_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys6_dan";?></td>
</tr>
<tr>
<td class="fmenu" width="20%">7</td>
<td class="fmenu" width="20%"><?php echo "$riadok->rdoba7_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoep7_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zkoed7_dan";?></td>
<td class="fmenu" width="20%"><?php echo "$riadok->zzvys7_dan";?></td>
</tr>
<tr></tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Upravi údaje"></td>
</tr>
</FORM>

</table>
<?php
mysql_free_result($vysledok);
    }
//koniec zobrazenia  sadzieb
?>



<?php
//upravy  sadzby
if ( $copern == 2 )
    {
?>
<table class="fmenu" width="100%" >
<FORM name="formv1" class="obyc" method="post" action="sadodp.php?copern=3" >
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" colspan="5">SADZBY ÚÈTOVNÝCH ODPISOV</td>
</tr>
<tr>
<td class="bmenu" width="20%">ODPISOVÁ SKUPINA</td>
<td class="bmenu" width="20%">Doba_odpisu</td>
<td class="bmenu" width="20%">Koeficient 1.rok</td>
<td class="bmenu" width="20%">Koeficient ïalšie roky</td>
<td class="bmenu" width="20%">Koeficient zvýšená cena</td>
</tr>
<tr>
<td class="fmenu" width="20%">1</td>
<td class="fmenu" width="20%"><input type="text" name="rdoba1" id="rdoba1" /></td>
<td class="fmenu" width="20%"><input type="text" name="zkoep1" id="zkoep1" /></td>
<td class="fmenu" width="20%"><input type="text" name="zkoed1" id="zkoed1" /></td>
<td class="fmenu" width="20%"><input type="text" name="zzvys1" id="zzvys1" /></td>
</tr>
<tr>
<td class="fmenu" >2</td>
<td class="fmenu" ><input type="text" name="rdoba2" id="rdoba2" /></td>
<td class="fmenu" ><input type="text" name="zkoep2" id="zkoep2" /></td>
<td class="fmenu" ><input type="text" name="zkoed2" id="zkoed2" /></td>
<td class="fmenu" ><input type="text" name="zzvys2" id="zzvys2" /></td>
</tr>
<tr>
<td class="fmenu" >3</td>
<td class="fmenu" ><input type="text" name="rdoba3" id="rdoba3" /></td>
<td class="fmenu" ><input type="text" name="zkoep3" id="zkoep3" /></td>
<td class="fmenu" ><input type="text" name="zkoed3" id="zkoed3" /></td>
<td class="fmenu" ><input type="text" name="zzvys3" id="zzvys3" /></td>
</tr>
<tr>
<td class="fmenu" >4</td>
<td class="fmenu" ><input type="text" name="rdoba4" id="rdoba4" /></td>
<td class="fmenu" ><input type="text" name="zkoep4" id="zkoep4" /></td>
<td class="fmenu" ><input type="text" name="zkoed4" id="zkoed4" /></td>
<td class="fmenu" ><input type="text" name="zzvys4" id="zzvys4" /></td>
</tr>
<tr>
<td class="fmenu" >5</td>
<td class="fmenu" ><input type="text" name="rdoba5" id="rdoba5" /></td>
<td class="fmenu" ><input type="text" name="zkoep5" id="zkoep5" /></td>
<td class="fmenu" ><input type="text" name="zkoed5" id="zkoed5" /></td>
<td class="fmenu" ><input type="text" name="zzvys5" id="zzvys5" /></td>
</tr>
<tr>
<td class="fmenu" >6</td>
<td class="fmenu" ><input type="text" name="rdoba6" id="rdoba6" /></td>
<td class="fmenu" ><input type="text" name="zkoep6" id="zkoep6" /></td>
<td class="fmenu" ><input type="text" name="zkoed6" id="zkoed6" /></td>
<td class="fmenu" ><input type="text" name="zzvys6" id="zzvys6" /></td>
</tr>
<tr>
<td class="fmenu" >7</td>
<td class="fmenu" ><input type="text" name="rdoba7" id="rdoba7" /></td>
<td class="fmenu" ><input type="text" name="zkoep7" id="zkoep7" /></td>
<td class="fmenu" ><input type="text" name="zkoed7" id="zkoed7" /></td>
<td class="fmenu" ><input type="text" name="zzvys7" id="zzvys7" /></td>
</tr>
<tr>
<td class="fmenu" >8</td>
<td class="fmenu" ><input type="text" name="rdoba8" id="rdoba8" /></td>
<td class="fmenu" ><input type="text" name="zkoep8" id="zkoep8" /></td>
<td class="fmenu" ><input type="text" name="zkoed8" id="zkoed8" /></td>
<td class="fmenu" ><input type="text" name="zzvys8" id="zzvys8" /></td>
</tr>
<tr>
<td class="fmenu" >9</td>
<td class="fmenu" ><input type="text" name="rdoba9" id="rdoba9" /></td>
<td class="fmenu" ><input type="text" name="zkoep9" id="zkoep9" /></td>
<td class="fmenu" ><input type="text" name="zkoed9" id="zkoed9" /></td>
<td class="fmenu" ><input type="text" name="zzvys9" id="zzvys9" /></td>
</tr>
<tr>
<td class="fmenu" >10</td>
<td class="fmenu" ><input type="text" name="rdoba10" id="rdoba10" /></td>
<td class="fmenu" ><input type="text" name="zkoep10" id="zkoep10" /></td>
<td class="fmenu" ><input type="text" name="zkoed10" id="zkoed10" /></td>
<td class="fmenu" ><input type="text" name="zzvys10" id="zzvys10" /></td>
</tr>
<tr></tr><tr></tr><tr></tr>
<tr>
<td class="bmenu" colspan="5">SADZBY DAÒOVÝCH ODPISOV</td>
</tr>
<tr>
<td class="bmenu" width="20%">ODPISOVÁ SKUPINA</td>
<td class="bmenu" width="20%">Doba_odpisu</td>
<td class="bmenu" width="20%">Koeficient 1.rok</td>
<td class="bmenu" width="20%">Koeficient ïalšie roky</td>
<td class="bmenu" width="20%">Koeficient zvýšená cena</td>
</tr>
<tr>
<td class="fmenu" width="20%">1</td>
<td class="fmenu" width="20%"><input type="text" name="rdoba1_dan" id="rdoba1_dan" /></td>
<td class="fmenu" width="20%"><input type="text" name="zkoep1_dan" id="zkoep1_dan" /></td>
<td class="fmenu" width="20%"><input type="text" name="zkoed1_dan" id="zkoed1_dan" /></td>
<td class="fmenu" width="20%"><input type="text" name="zzvys1_dan" id="zzvys1_dan" /></td>
</tr>
<tr>
<td class="fmenu" >2</td>
<td class="fmenu" ><input type="text" name="rdoba2_dan" id="rdoba2_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoep2_dan" id="zkoep2_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoed2_dan" id="zkoed2_dan" /></td>
<td class="fmenu" ><input type="text" name="zzvys2_dan" id="zzvys2_dan" /></td>
</tr>
<tr>
<td class="fmenu" >3</td>
<td class="fmenu" ><input type="text" name="rdoba3_dan" id="rdoba3_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoep3_dan" id="zkoep3_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoed3_dan" id="zkoed3_dan" /></td>
<td class="fmenu" ><input type="text" name="zzvys3_dan" id="zzvys3_dan" /></td>
</tr>
<tr>
<td class="fmenu" >4</td>
<td class="fmenu" ><input type="text" name="rdoba4_dan" id="rdoba4_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoep4_dan" id="zkoep4_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoed4_dan" id="zkoed4_dan" /></td>
<td class="fmenu" ><input type="text" name="zzvys4_dan" id="zzvys4_dan" /></td>
</tr>
<tr>
<td class="fmenu" >5</td>
<td class="fmenu" ><input type="text" name="rdoba5_dan" id="rdoba5_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoep5_dan" id="zkoep5_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoed5_dan" id="zkoed5_dan" /></td>
<td class="fmenu" ><input type="text" name="zzvys5_dan" id="zzvys5_dan" /></td>
</tr>
<tr>
<td class="fmenu" >6</td>
<td class="fmenu" ><input type="text" name="rdoba6_dan" id="rdoba6_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoep6_dan" id="zkoep6_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoed6_dan" id="zkoed6_dan" /></td>
<td class="fmenu" ><input type="text" name="zzvys6_dan" id="zzvys6_dan" /></td>
</tr>
<tr>
<td class="fmenu" >7</td>
<td class="fmenu" ><input type="text" name="rdoba7_dan" id="rdoba7_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoep7_dan" id="zkoep7_dan" /></td>
<td class="fmenu" ><input type="text" name="zkoed7_dan" id="zkoed7_dan" /></td>
<td class="fmenu" ><input type="text" name="zzvys7_dan" id="zzvys7_dan" /></td>
</tr>
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Uloži úpravy"></td>
</tr>
</FORM>

<FORM name="formv2" class="obyc" method="post" action="sadodp.php?copern=1" >
<tr>
<td></td>
<td class="obyc"><INPUT type="submit" id="uloz" name="uloz" value="Koniec neuloži"></td>
</tr>
</FORM>

</table>
<?php
//mysql_free_result($vysledok);
    }
//koniec uprav  sadzby
?>



<?php
// celkovy koniec dokumentu
       } while (false);
?>
</BODY>
</HTML>
